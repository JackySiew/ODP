<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Orders;
use App\Sliders;
use App\CustomTask;
use DB;
use Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'products','category','showprod']]);
    }    
    
    //Home page
    public function index()
    {
        $products = Db::table('products')
        ->join('categories', 'products.category','=','categories.id')
        ->select('products.*','categories.category_name')
        ->orderBy('created_at','desc')
        ->take(4)
        ->get();
        $sliders = Sliders::where('status','0')->get();
        return view('home',compact('products','sliders'));
    }

    //view all products
    public function products(){
        $products = Product::orderBy('created_at','desc')->paginate(6);
        $categories = Db::table('categories')
        ->select('*')
        ->orderBy('category_name','asc')
        ->get();
        return view('user.product.products',compact('products','categories'))->with('reviews');    
    }

    //view product details
    public function showprod($id)
    {
        $products = Product::where('id',$id)->get();
        $cates = DB::table('products')
        ->join('categories', 'products.category','=','categories.id')
        ->select('products.*','categories.category_name')
        ->where('products.id',$id)
        ->get();
        $reviews = DB::table('reviews')
        ->join('users', 'reviews.user_id','=','users.id')
        ->select('reviews.*','users.name')
        ->where('reviews.product_id',$id)
        ->get();
        $dt = new Carbon();
        return view('user.product.showprod',compact('products','reviews','cates','dt'));
    }

    //view product by category
    public function category($id){
        $products = Product::where('category',$id)->paginate(6);

        $cates = DB::table('products')
        ->join('categories', 'products.category','=','categories.id')
        ->select('categories.category_name')
        ->where('products.category',$id)
        ->get();
        foreach ($cates as $cate) {
            $cateName = $cate->category_name;
        }
        
        $categories = Db::table('categories')
        ->select('*')
        ->orderBy('category_name','asc')
        ->get();

        if (count($products)>0) {
            return view('user.product.showcate',compact('products','categories','cateName'))->with('reviews');    
        }else{
            return redirect('/all-products')->with('alert','Sorry! No such product in this category. =="');    
        }
    }

    //view order status
    public function myorder()
    {
        $orders = Orders::whereHas('items',function($query){
            $query->where('user_id', Auth::user()->id);
        })->orderBy('created_at','desc')->get();  
        return view('user.order.myorders',compact('orders'));
    }

    //ajax get order items
    public function getItems($id)
    {      
        $orders = Orders::find($id);
        
        $orderItems = DB::table('order_items')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('order_items.*','products.*')
        ->where('order_items.order_id', $orders->id)->get();
        return view('user.order.showitem',['orderItems'=>$orderItems]);
    }

    //view customize request status
    public function myCustomize()
    {
        $customs = CustomTask::whereHas('items',function($query){
            $query->where('user_id', Auth::user()->id);
        })->orderBy('created_at','desc')->get();        
        return view('user.customize.mycustomizes',compact('customs'));
    }

    //ajax get customize items
    public function getTaskItem($id)
    {      
        $custom = CustomTask::find($id);
        
        $customItems = DB::table('custom_items')
        ->join('products', 'custom_items.product_id','=','products.id')
        ->select('custom_items.*','products.*')
        ->where('custom_items.custom_id', $custom->id)->get();

        return view('user.customize.showtaskitem',['customItems'=>$customItems]);
    }

    //user view more ordering details
    public function getOrder($id){
        $orders = Orders::find($id);
        
        $orderItems = DB::table('order_items')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('order_items.*','products.*')
        ->where('order_items.order_id', $orders->id)->get();

       return view('user.order.showorder',compact('orders','orderItems'));
    }
    //user view more customize task details
    public function getCustomize($id){
        $custom = CustomTask::find($id);
        
        $customItems = DB::table('custom_items')
        ->join('products', 'custom_items.product_id','=','products.id')
        ->select('custom_items.*','products.*')
        ->where('custom_items.custom_id', $custom->id)->get();

       return view('user.customize.showcustom',compact('custom','customItems'));
    }

    public function designers(){
        $designers = User::where('usertype','designer')->get();

        return view('user.designer.designers',compact('designers'));
    }

    public function designerProduct($id){
        $designer = User::where('id',$id)->get();

        $products = Product::where('presentBy',$id)->get();

        if (count($products)>0) {
            return view('user.designer.designerProduct',compact('designer','products'));
        }else{
            return redirect('/designers')->with('alert',"Sorry! This designer haven't upload any product");    
        }
    }
    public function profile(){
        $user = User::where('id',Auth::user()->id)->first();
        return view('user.profile.profile',compact('user'));
    }

    public function editprofile($id)
    {
        $user = User::findOrFail($id);
        return view('user.profile.editprofile')->with('user',$user);
    }

    public function updateprofile(Request $request, $id)
    {
        if ($request->hasFile('profile')) {
            $fileNameWithExt = $request->file('profile')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'_'.$extension;
            $path  =$request->file('profile')->storeAs('public/image', $fileNameToStore);
        }

        $user = User::find($id);
        $user->name =$request->input('name');
        $user->email =$request->input('email');
        $user->mobile =$request->input('mobile');
        if ($request->hasFile('profile')) {
            if ($user->profile != "noimage.png") {
                Storage::delete('public/image/'.$user->profile);          
                $user->profile = $fileNameToStore;
            }  
        }

        $user->update();

        return redirect('/my-profile')->with('status','Your Profile is updated'); 
    }
}