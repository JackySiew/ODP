<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use DB;
use Session;
use Auth;
use App\Orders;
class CartController extends Controller
{
    //view the cart
    public function index(){
        $cartItems= \Cart::session(auth()->id())->getContent();
        return view('user.cart', compact('cartItems'));
    }

    // add item into cart
    public function addToCart(Request $request, $id){
        $product = Product::find($id);
        \Cart::session(auth()->id())->add(array(
            'id' => $product->id,
            'presentBy' => $product->presentBy,
            'name' => $product->prodName,
            'price' => $product->prodPrice,
            'quantity' => 1,
            'image' => $product->prodImage,
            'attributes' => array(),
            'associatedModel' => $product
        ));
        return redirect()->back()->with('status','Product added to cart!');
    }

    // go checkout
    public function getcheckout(){
        $product = \Cart::session(auth()->id())->getContent();
        return view('user.pay.checkout', compact('product'));
    }

    //update item's quantity
    public function update($id){
        \Cart::session(auth()->id())->update($id, [
            'quantity' => array(
                'relative' =>false,
                'value' => request('quantity')
            )
        ]);
        return redirect()->back();    
    }

    //remove item from cart
    public function getRemove($id){
        \Cart::session(auth()->id())->remove($id);
        return redirect()->back();    
    }

}