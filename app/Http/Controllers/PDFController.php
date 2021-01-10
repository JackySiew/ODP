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

    public function salesReport($year = null, $month = null, $day = null){
        if ($year != null && $month != null && $day != null) {
            $date = $year.'-'.$month.'-'.$day;
            $orders = DB::table('orders')->whereDate('created_at',$date)->get();
            $sum = DB::table('orders')->whereDate('created_at',$date)->where('status','!=','declined')->sum('grand_total');
            $tasks = DB::table('customize')->whereDate('created_at',$date)->get();
            $fullypaid = DB::table('customize')->whereDate('created_at',$date)->where('fully_paid',true)->sum('grand_total');
            $depositpaid = DB::table('customize')->whereDate('created_at',$date)->where('deposit_paid',true)->sum('deposit');            
            $sum2 = $fullypaid + $depositpaid;
            $actual = DB::table('orders')->whereDate('created_at',$date)->where('status','!=','declined')->where('is_paid',true)->sum('grand_total');

            $details =[
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'description' => $orders,
                'description2' => $tasks,
                'sum' => $sum,
                'sum2' => $sum2,
                'actual' => $actual,
            ];
            $pdf = \PDF::loadView('pdf.salesreport', $details);
            return $pdf->download('sales-report.pdf');    
        }elseif($year != null && $month != null && $day == null){
            $orders = DB::table('orders')->whereYear('created_at',$year)->whereMonth('created_at',$month)->get();
            $sum = DB::table('orders')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('status','!=','declined')->sum('grand_total');
            $tasks = DB::table('customize')->whereYear('created_at',$year)->whereMonth('created_at',$month)->get();
            $fullypaid = DB::table('customize')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('fully_paid',true)->sum('grand_total');
            $depositpaid = DB::table('customize')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('deposit_paid',true)->sum('deposit');            
            $sum2 = $fullypaid + $depositpaid;
            $orders = DB::table('orders')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('is_paid',true)->get();
            $details =[
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'description' => $orders,
                'description2' => $tasks,
                'sum' => $sum,
                'sum2' => $sum2,
                'actual' => $actual,
            ];
            $pdf = \PDF::loadView('pdf.salesreport', $details);
            return $pdf->download('sales-report.pdf');    
        }elseif($year != null && $month == null && $day == null){
            $orders = DB::table('orders')->whereYear('created_at',$year)->get();
            $sum = DB::table('orders')->whereYear('created_at',$year)->where('status','!=','declined')->sum('grand_total');
            $tasks = DB::table('customize')->whereYear('created_at',$year)->get();
            $fullypaid = DB::table('customize')->whereYear('created_at',$year)->where('fully_paid',true)->sum('grand_total');
            $depositpaid = DB::table('customize')->whereYear('created_at',$year)->where('deposit_paid',true)->sum('deposit');            
            $sum2 = $fullypaid + $depositpaid;
            $details =[
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'description' => $orders,
                'description2' => $tasks,
                'sum' => $sum,
                'sum2' => $sum2,
                'actual' => $actual,
            ];
            $pdf = \PDF::loadView('pdf.salesreport', $details);
            return $pdf->download('sales-report.pdf');    
        }else{
            return redirect()->back()->with('error','Unable to download!');
        }
    }

    public function DesignerSalesReport($id){
        $pdf = \PDF::loadView('pdf.salesreport', $details);
        return $pdf->download('designer-sales-report.pdf');    
    }
}
