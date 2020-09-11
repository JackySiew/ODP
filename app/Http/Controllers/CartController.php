<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use DB;
use Session;
use Auth;
use Stripe\Charge;
use Stripe\Stripe;
use App\Orders;
class CartController extends Controller
{
    public function index(){
        if (!Session::has('cart')) {
            return view('cart.cart',['products' => null]);
        }
        $oldCart = Session::get('cart');
        $cart  = new Cart($oldCart);
        return view('cart.cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function addToCart(Request $request, $id){
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart')  : null;
        $cart  = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart',$cart);
        return redirect()->back()->with('status','Your product has added in cart!');
    }
    public function getcheckout(){
        if (!Session::has('cart')) {
            return view('cart.cart');
        }
        $oldCart = Session::get('cart');
        $cart  = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('cart.checkout',['total' => $total]);
    }
    public function checkout(Request $request){
        if (!Session::has('cart')) {
            return view('cart.cart');
        }
        $oldCart = Session::get('cart');
        $cart  = new Cart($oldCart);

        Stripe::setApiKey ('sk_test_51HFVGNCFq6SzGxX29Qawy6zsQPaLDyEWCJfZTJRI4ENUD2JRP0mKSv7n8LdbfsBWuasyqU7QErHVNliZ9ARKhBY400eCmKx89T');
        try {
            $charge =Charge::create ( array (
                    "amount" => $cart->totalPrice * 100,
                    "currency" => "myr",
                    "source" => $request->input ( 'stripeToken' ), // obtained with Stripe.js
                    "description" => "Test payment." 
            ) );
            $order = new Orders;
            
            $order->cart = serialize($cart);
            $order->address = $request->input('address');
            $order->payment_id = $charge->id;
            $order->user_id = Auth::user()->id;
            $order->user_name = Auth::user()->name;
            $order->status = 0;
            $order->save();
            Session::forget('cart');
            return redirect('/all-products')->with('status','Purchase Sucessfully!');
            } catch ( \Exception $e ) {
            return $e->getMessage();
        }
    }
    public function getAdd($id){
        $oldCart = Session::has('cart') ? Session::get('cart')  : null;
        $cart  = new Cart($oldCart);
        $cart->addqty($id);     
        Session::put('cart',$cart);
        return redirect('/cart');
    }
    public function getReduce($id){
        $oldCart = Session::has('cart') ? Session::get('cart')  : null;
        $cart  = new Cart($oldCart);
        $cart->reduceqty($id);  
        if (count($cart->items) > 0) {
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
        return redirect('/cart');    

    }
    public function getRemove($id){
        $oldCart = Session::has('cart') ? Session::get('cart')  : null;
        $cart  = new Cart($oldCart);
        $cart->removeItem($id);     
        if (count($cart->items) > 0) {
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
        return redirect('/cart');
    }

}