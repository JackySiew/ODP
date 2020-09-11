<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Orders;
use DB;
use Auth;
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
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Db::table('products')
        ->join('categories', 'products.category','=','categories.id')
        ->select('products.*','categories.category_name')
        ->orderBy('created_at','desc')
        ->get();
        return view('home')->with('products',$products);
    }

    public function products(){
        $products = Product::all()->sortByDesc('created_at');
        $categories = Db::table('categories')
        ->select('*')
        ->orderBy('category_name','asc')
        ->get();
        return view('products',compact('products','categories'))->with('reviews');    
    }

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
        return view('showprod',compact('products','reviews','cates'));
    }
    public function category($id){
        $products = Product::where('category',$id)->get();
        $cates = DB::table('products')
        ->join('categories', 'products.category','=','categories.id')
        ->select('products.*','categories.category_name')
        ->where('products.category',$id)
        ->get();

        $categories = Db::table('categories')
        ->select('*')
        ->orderBy('category_name','asc')
        ->get();
        if (count($products)>0) {
            return view('showcate',compact('products','categories','cates'))->with('reviews');    
        }else{
            return redirect('/all-products')->with('alert','Sorry! No such product in this category. =="');    
        }
    }
    public function myorder()
    {
        $user_id =Auth::user()->id;
        $orders = Orders::where('user_id',$user_id)->orderBy('created_at', 'desc')->get();
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('myorders',['orders'=> $orders]);
}

}