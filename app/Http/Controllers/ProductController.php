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
    //designer view products
    public function index()
    {
        $user_id = auth()->user()->id;
        $products = Product::all()->where('presentBy',$user_id)->sortByDesc('created_at');
        return view('designer.myprod',compact('products'));
    }

    //designer create product
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

   //designer save product
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
        $product->presentBy = auth()->user()->id;
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

        return redirect('/products')->with('success','Product Created!');
    }

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
        return redirect('/products')->with('success','Product Updated!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product->prodImage != "noimage.png") {
            Storage::delete('public/image/'.$product->prodImage);
        }
        $product->delete();
        return redirect('/products')->with('success','Product Deleted!'); 
    }
}
