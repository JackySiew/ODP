<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\Product;
use DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $products = Product::all()->where('presentBy',$user_id)->sortByDesc('created_at');
        if (session('status')) {
            Alert::success('Create successfully!', 'You have created new product!!!');
        }else if (session('status2')) {
            Alert::success('Update successfully!', 'You have updated your product!!!');
        }else if (session('status3')){
            Alert::success('Delete successfully!', 'You have deleted your product!!!');
        }

        return view('designer.myprod',compact('products'))->with(['reviews','categories']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::orderBy('category_name','asc')->get();
        return view('designer.create')->with('category',$category);
    }
    public function show($id)
    {
        $products = DB::table('products')
        ->join('categories', 'products.category','=','categories.id')
        ->select('products.*','categories.category_name')
        ->where('products.id',$id)
        ->get();
        $reviews = DB::table('reviews')
        ->join('users', 'reviews.user_id','=','users.id')
        ->select('reviews.*','users.name')
        ->where('reviews.product_id',$id)
        ->get();
        return view('designer.show',compact('products','reviews'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'prodName' => 'required',
            'category' => 'required',
            'description' => 'required',
            'prodPrice' => 'required',
            'prodImage' => 'image|nullable|max:5000'
        ]);
        //Create Product
        $product = new Product;
        $product->prodname = $request->input('prodName');
        $product->category = $request->input('category');
        $product->description = $request->input('description');
        $product->prodPrice = $request->input('prodPrice');
        $product->presentBy = auth()->user()->id;//get current login user's id

        if ($request->hasFile('prodImage')) {
            $fileNameWithExt = $request->file('prodImage')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('prodImage')->getClientOriginalExtension();

            $fileNameToStore = $filename.'_'.time().'_'.$extension;

            $path  =$request->file('prodImage')->storeAs('public/image', $fileNameToStore);
        }else {
            $fileNameToStore = "noimage.png";
        }
        
        $product->prodImage = $fileNameToStore;
        $product->save();

        return redirect('/products')->with('status','Product Created');
    }

    // public function show($id){
    //     $product = Product::find($id);
    //     return view('designer.show')->with('product',$product);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Db::table('products')
        ->join('categories', 'products.category','=','categories.id')
        ->select('products.*','categories.category_name')
        ->where('products.id',$id)
        ->get();

        $cat_id =  Db::table('products')
        ->select('category')
        ->where('id',$id)
        ->pluck('category');

        $category = Db::table('categories')
        ->select('*')
        ->where('id','!=',$cat_id)
        ->orderBy('category_name','asc')
        ->get();
        return view('designer.edit',compact('products','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->hasFile('prodImage')) {
            $fileNameWithExt = $request->file('prodImage')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('prodImage')->getClientOriginalExtension();

            $fileNameToStore = $filename.'_'.time().'_'.$extension;

            $path  =$request->file('prodImage')->storeAs('public/image', $fileNameToStore);
        }

        $product = Product::findOrFail($id);
        $product->prodName = $request->input('prodName');
        $product->category = $request->input('category');
        $product->description = $request->input('description');
        $product->prodPrice = $request->input('prodPrice');
        if ($request->hasFile('prodImage')) {
            if ($product->prodImage != "noimage.png") {
                Storage::delete('public/image/'.$product->prodImage);          
                $product->prodImage = $fileNameToStore;
            }  
        }
        $product->update();

        return redirect('/products')->with('status2','Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product->prodImage != "noimage.png") {
            Storage::delete('public/image/'.$product->prodImage);
        }
        $product->delete();
        return redirect('/products')->with('status3','Product Deleted'); 
    }
}
