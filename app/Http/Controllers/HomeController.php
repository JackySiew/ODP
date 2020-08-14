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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

    public function category($id){
        $products = DB::table('products')
        ->join('category', 'products.category','=','category.id')
        ->select('products.*','category.category_name')
        ->where('products.category',$id)
        ->get();
        // return $products;
        $categories = Db::table('category')
        ->select('*')
        ->orderBy('category_name','asc')
        ->get();
        if (count($products)>0) {
            return view('showcate',compact('products','categories'));    
        }else{
            return redirect('/all-products')->with('alert','Sorry! No such product in this category. =="');    
        }
    }

    public function showprod($id)
    {
        $products = DB::table('products')
        ->join('category', 'products.category','=','category.id')
        ->select('products.*','category.category_name')
        ->where('products.id',$id)
        ->get();
        // return $products;
        return view('showprod')->with('products',$products);
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