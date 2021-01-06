<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use DB;
use Auth;
class PDFController extends Controller
{
    public function invoice($id){
        $order = Orders::find($id);
        
        $orderItems = DB::table('order_items')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('order_items.*','products.*')
        ->where('order_items.order_id', $order->id)->get();
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
            'orderDate' => $order->created_at->format('d M, Y'), 
            'products'  => $orderItems,
            'total' => $order->grand_total,
        ];

        
        $pdf = \PDF::loadView('pdf.invoice', $details);
        return $pdf->download('invoice.pdf');    

    }
}
