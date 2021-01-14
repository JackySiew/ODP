<?php

namespace App\Http\Controllers;

use App\Orders;
use Stripe\Charge;
use Stripe\Stripe;
use App\Mail\OrderMail;
use App\Product;
use App\OrderItems;
use App\Notifications\Action;
use App\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Auth;
use DB;
class OrdersController extends Controller
{
    //user save ordering 
    public function store(Request $request)
    {
        try {
            $request->validate([
                'fullname' => 'required',
                'address1' => 'required',
                'address2' => 'required',
                'city' => 'required',
                'state' => 'required',
                'postcode' => 'required',
                'mobile' => 'required',
    
            ]);
            $order = new Orders();
            $order->order_number = uniqid();
            $order->fullname = $request->input('fullname');
            $order->address1 = $request->input('address1');
            $order->address2 = $request->input('address2');
            $order->city = $request->input('city');
            $order->state = $request->input('state');
            $order->postcode = $request->input('postcode');
            $order->mobile = $request->input('mobile');
            $order->grand_total = \Cart::session(auth()->id())->getTotal();
            $order->item_count = \Cart::session(auth()->id())->getContent()->count();
            $order->user_id = Auth::user()->id;            
            $order->payment_method = $request->input('payment_method');
            $order->status = 'pending';
            if ($request->input('payment_method') == 'stripe') {
                Stripe::setApiKey ('sk_test_51HFVGNCFq6SzGxX29Qawy6zsQPaLDyEWCJfZTJRI4ENUD2JRP0mKSv7n8LdbfsBWuasyqU7QErHVNliZ9ARKhBY400eCmKx89T');
                $charge = Charge::create ( array (
                        "amount" => \Cart::session(auth()->id())->getTotal() * 100,
                        "currency" => "myr",
                        "source" => $request->input ( 'stripeToken' ), // obtained with Stripe.js
                        "description" => "Ordering payment." 
                ));
                $order->payment_id = $charge->id;
            }else{
                $order->payment_id = null;
            }
            $order->notes = $request->input('notes');
            
            if ($order->payment_method != 'cash') {
                $order->is_paid = 1;
            }else {
                $order->is_paid = 0;
            }
            $order->save();

            //save order items
            $cartItems =  \Cart::session(auth()->id())->getContent();   
            foreach ($cartItems as $item) {
                $order_items = new OrderItems();
                $order_items->product_id = $item->id;
                $order_items->order_id = $order->id;
                $order_items->quantity = $item->quantity;
                $order_items->price = $item->price;
                $order_items->save();
                $action = ["Action" => 'You got a new order'];
                $product = Product::find($item->id);
                $seller = User::find($product->presentBy);
                $seller->notify(new Action($action));
            }
            $details = [
                'name' => Auth::user()->name,
                
                'address' => [
                    'address1' => $order->address1,
                    'address2' => $order->address2,
                    'postcode' => $order->postcode,
                    'city' => $order->city,
                    'state' => $order->state,
                    ],
                'orderNumber' => $order->order_number,
                'orderDate' => Carbon::today()->format('d M, Y'), 
                'products'  => $cartItems,
                'total' => $order->grand_total,
            ];
            
            \Mail::to(Auth::user()->email)->send(new OrderMail($details));
        
            //clear cart
            \Cart::session(auth()->id())->clear();

            return redirect('/my-orders')->with('status','Your order has been sent! You can check your order status & download invoice here.');

            } catch ( \Exception $e ) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }    
    
    //designer view orders
    public function orders()
    {
        $orders = Orders::whereHas('items',function($query){
            $query->where('presentBy', Auth::user()->id);
        })->orderBy('created_at','desc')->get();
        
        return view('designer.order.order',compact('orders'));
    }

    //designer view order's details
    public function getOrder($id){
        $orders = Orders::find($id);
        
        $orderItems = DB::table('order_items')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('order_items.*','products.*')
        ->where([
            'order_items.order_id' => $orders->id,
            'products.presentBy' => Auth::user()->id
            ])->get();

       return view('designer.order.showorder',compact('orders','orderItems'));
    }

    // Designer deliver product
    public function deliver($id){
        $order = Orders::findOrFail($id);
        $order->status = 'processing';
        $order->update();
        $action = ["Action" => "Your product is on delivering!"];
        $orderItems = DB::table('order_items')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('order_items.*','products.*')
        ->where([
            'order_items.order_id' => $order->id,
            'products.presentBy' => Auth::user()->id
            ])->update(['status'=>'processing']);
            
        $user = User::find($order->user_id);
        $user->notify(new Action($action));

        return redirect()->back()->with('status','Task Updated!');
    }

    public function decline($id){

        $action = ["Action" => "Your product order is declined!"];
        $order = Orders::whereHas('items',function($query) use ($id){
            $query->where('product_id', $id);
        })->update(['status'=>'declined']);

        $orderItems = DB::table('order_items')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('order_items.*')
        ->where([
            'order_items.product_id' => $id,
            ])->update(['status'=>'declined']);

            $items = DB::table('order_items')
            ->join('products', 'order_items.product_id','=','products.id')
            ->select('order_items.*','products.*')
            ->where('order_items.product_id', $id)->get();
            foreach ($items as $item) {
                $seller = User::find($item->presentBy);
            }
    
        $seller->notify(new Action($action));

        return redirect()->back()->with('status','The product order has canceled!');
    }
    
}
