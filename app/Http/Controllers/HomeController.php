<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Orders;
use App\CustomTask;
use DB;
use Auth;
use Carbon\Carbon;
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
        ->get();
        return view('home')->with('products',$products);
    }

    //view all products
    public function products(){
        $products = Product::all()->sortByDesc('created_at');
        $categories = Db::table('categories')
        ->select('*')
        ->orderBy('category_name','asc')
        ->get();
        return view('user.products',compact('products','categories'))->with('reviews');    
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
        return view('user.showprod',compact('products','reviews','cates','dt'));
    }

    //view product by category
    public function category($id){
        $products = Product::where('category',$id)->get();

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
            return view('user.showcate',compact('products','categories','cateName'))->with('reviews');    
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
        return view('user.myorders',compact('orders'));
    }

    //ajax get order items
    public function getItems($id)
    {      
        $orders = Orders::find($id);
        
        $orderItems = DB::table('order_items')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('order_items.*','products.*')
        ->where('order_items.order_id', $orders->id)->get();
        // $total = $orderItems->quantity;
        return view('user.showitem',['orderItems'=>$orderItems]);
    }

    //view customize request status
    public function myCustomize()
    {
        $customs = CustomTask::whereHas('items',function($query){
            $query->where('user_id', Auth::user()->id);
        })->orderBy('created_at','desc')->get();        
        return view('user.mycustomizes',compact('customs'));
    }

    //ajax get customize items
    public function getCustomize($id)
    {      
        $custom = CustomTask::find($id);
        
        $customItems = DB::table('custom_items')
        ->join('products', 'custom_items.product_id','=','products.id')
        ->select('custom_items.*','products.*')
        ->where('custom_items.custom_id', $custom->id)->get();

        return view('user.showtask',['customItems'=>$customItems]);
    }

    //view more ordering details
    public function getOrder($id){
        $orders = Orders::find($id);
        
        $orderItems = DB::table('order_items')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('order_items.*','products.*')
        ->where('order_items.order_id', $orders->id)->get();

       return view('user.showorder',compact('orders','orderItems'));
    }
    
}