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
    public function products(){
        $products = Db::table('products')
        ->join('category', 'products.category','=','category.id')
        ->select('products.*','category.category_name')
        ->orderBy('created_at','desc')
        ->get();
        $categories = Db::table('category')
        ->select('*')
        ->orderBy('category_name','asc')
        ->get();
        return view('products',compact('products','categories'));    
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Db::table('products')
        ->join('category', 'products.category','=','category.id')
        ->select('products.*','category.category_name')
        ->orderBy('created_at','desc')
        ->get();
        return view('home')->with('products',$products);
    }

    public function myorder()
    {
        $user_id =Auth::user()->id;
        $orders = Orders::where('user_id',$user_id)->orderBy('created_at', 'desc')->get();
        // return $orders;
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('order',['orders'=> $orders]);
}

}