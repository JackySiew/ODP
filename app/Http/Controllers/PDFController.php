<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\CustomTask;
use App\User;
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
        $items = DB::table('order_items')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('order_items.*')
        ->where('order_items.order_id', $order->id)
        ->where('status','!=','declined')->get();
        if (!empty($items)) {
            foreach ($items as $item) {
                $qty[] = $item->quantity;
                $price[] = $item->price;
            }
        }
        $allTotal = [];
        if (!empty($items)) {
            foreach ($items as $i=>$value) {
               array_push($allTotal, $qty[$i] * $price[$i]);
            }
        }

        $total =  array_sum($allTotal);
        $details = [
            'name' => Auth::user()->name,
            'payBy' => $order->payment_method,
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
            $sum2 = DB::table('customize')->whereDate('created_at',$date)->where('status','!=','declined')->sum('grand_total');
            $fullypaid = DB::table('customize')->whereDate('created_at',$date)->where('fully_paid',true)->sum('grand_total');
            $depositpaid = DB::table('customize')->whereDate('created_at',$date)->where('deposit_paid',true)->sum('deposit');            
            $sum2 = $fullypaid + $depositpaid;
            $actual = DB::table('orders')->whereDate('created_at',$date)->where('status','!=','declined')->where('is_paid',true)->sum('grand_total');
            $paymentPending = $sum - $actual;
            $paymentPending2 = $sum2 - $actual2;
            $details =[
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'description' => $orders,
                'description2' => $tasks,
                'sum' => $sum,
                'sum2' => $sum2,
                'actual' => $actual,
                'actual2' => $actual2,
                'paymentPending' => $paymentPending,
            ];
            $pdf = \PDF::loadView('pdf.salesreport', $details);
            return $pdf->download('sales-report.pdf');    
        }elseif($year != null && $month != null && $day == null){
            $orders = DB::table('orders')->whereYear('created_at',$year)->whereMonth('created_at',$month)->get();
            $sum = DB::table('orders')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('status','!=','declined')->sum('grand_total');
            $tasks = DB::table('customize')->whereYear('created_at',$year)->whereMonth('created_at',$month)->get();
            $sum2 = DB::table('customize')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('status','!=','declined')->sum('grand_total');
            $fullypaid = DB::table('customize')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('fully_paid',true)->sum('grand_total');
            $depositpaid = DB::table('customize')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('deposit_paid',true)->sum('deposit');            
            $actual2 = $fullypaid + $depositpaid;
            $actual = DB::table('orders')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('status','!=','declined')->where('is_paid',true)->sum('grand_total');
            $paymentPending = $sum - $actual;
            $details =[
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'description' => $orders,
                'description2' => $tasks,
                'sum' => $sum,
                'sum2' => $sum2,
                'actual' => $actual,
                'actual2' => $actual2,
                'paymentPending' => $paymentPending,
            ];
            $pdf = \PDF::loadView('pdf.salesreport', $details);
            return $pdf->download('sales-report.pdf');    
        }elseif($year != null && $month == null && $day == null){
            $orders = DB::table('orders')->whereYear('created_at',$year)->get();
            $sum = DB::table('orders')->whereYear('created_at',$year)->where('status','!=','declined')->sum('grand_total');
            $tasks = DB::table('customize')->whereYear('created_at',$year)->get();
            $sum2 = DB::table('customize')->whereYear('created_at',$year)->where('status','!=','declined')->sum('grand_total');
            $fullypaid = DB::table('customize')->whereYear('created_at',$year)->where('fully_paid',true)->sum('grand_total');
            $depositpaid = DB::table('customize')->whereYear('created_at',$year)->where('deposit_paid',true)->sum('deposit');            
            $actual2 = $fullypaid + $depositpaid;
            $actual = DB::table('orders')->whereYear('created_at',$year)->where('status','!=','declined')->sum('grand_total');
            $paymentPending = $sum - $actual;
            $paymentPending2 = $sum2 - $actual2;
            $details =[
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'description' => $orders,
                'description2' => $tasks,
                'sum' => $sum,
                'sum2' => $sum2,
                'actual' => $actual,
                'actual2' => $actual2,
                'paymentPending' => $paymentPending,
            ];
            $pdf = \PDF::loadView('pdf.salesreport', $details);
            return $pdf->download('sales-report.pdf');    
        }else{
            return redirect()->back()->with('error','Unable to download!');
        }
    }

    public function designerSalesReport($id){
            //get designer all details
            $designer = User::where('id',$id)->get();
            foreach ($designer as $key) {
                $name = $key->name;
            }
            $user = $id;

            //get total orders that the designer received
            $orders = Orders::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->get();

            if (!empty($orders)) {
                foreach ($orders as $order) {
                    $orderid[] = $order->id;
                }    
            }
            if (!empty($orderid)) {
                foreach ($orderid as $id) {
                    $ocompleted[] = DB::table('order_items')
                    ->join('products', 'order_items.product_id','=','products.id')
                    ->select('order_items.*')
                    ->where([
                    'order_items.order_id' => $id,
                    'products.presentBy' => $user,  
                    ])->where('status','completed')->count();
    
                    $odeclined[] = DB::table('order_items')
                    ->join('products', 'order_items.product_id','=','products.id')
                    ->select('order_items.*')
                    ->where([
                    'order_items.order_id' => $id,
                    'products.presentBy' => $user,  
                    ])->where('status','declined')->count();
                }    
                $ordercompleted = array_sum($ocompleted);
                $orderdeclined = array_sum($odeclined);    
            }else{
                $ordercompleted = null;
                $orderdeclined = null; 
            }


// <------- Calculate Total Sales, Income & Payment Pending of that designer from orders ---------->
            $orderSales = Orders::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->where('status','!=','declined')->get();

            $orderIncome = Orders::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->where('status','!=','declined')->where('is_paid',true)->get();

            if (!empty($orderSales)) {
                foreach ($orderSales as $sales) {
                    $salesId[] = $sales->id;
                }
            }

            if (!empty($orderIncome)) {
                foreach ($orderIncome as $income) {
                    $incomeId[] = $income->id;
                }
            }

            if (!empty($salesId)) {
                foreach ($salesId as $id) {
                    $orderItemSales[] = DB::table('order_items')
                    ->join('products', 'order_items.product_id','=','products.id')
                    ->select('order_items.*')
                    ->where([
                    'order_items.order_id' => $id,
                    'products.presentBy' => $user,  
                    ])->where('status','!=','declined')->first();
                }    
            }

            if (!empty($incomeId)) {
                foreach ($incomeId as $id) {
                    $orderItemIncome[] = DB::table('order_items')
                    ->join('products', 'order_items.product_id','=','products.id')
                    ->select('order_items.*')
                    ->where([
                    'order_items.order_id' => $id,
                    'products.presentBy' => $user,  
                    ])->where('status','!=','declined')->first();
                }    
            }

            if (!empty($orderItemSales)) {
                foreach ($orderItemSales as $item) {
                    $qty[] = $item->quantity;
                    $price[] = $item->price;
                }
            }

            if (!empty($orderItemIncome)) {
                foreach ($orderItemIncome as $item) {
                    $qty2[] = $item->quantity;
                    $price2[] = $item->price;
                }    
            }
            $allOrderSales = [];
            $allOrderIncome = [];

            if (!empty($orderItemSales)) {
                foreach ($orderItemSales as $i=>$value) { 
                    array_push($allOrderSales, $qty[$i] * $price[$i]);
                }
            }

            if (!empty($orderItemIncome)) {
                foreach ($orderItemIncome as $i=>$value) { 
                    array_push($allOrderIncome, $qty2[$i] * $price2[$i]);
                }    
            }

// <---------------------------- End Calculation ------------------------------->


            //get total tasks that the designer
            $tasks = CustomTask::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->get();

            //count the tasks that the designer completed
            $taskcompleted = CustomTask::whereHas('items',function($query) use ($user){
                $query->where(['presentBy'=> $user, 'status' => 'completed']);
            })->count();

            //count the tasks that declined
            $taskdeclined = CustomTask::whereHas('items',function($query) use ($user){
                $query->where(['presentBy'=> $user, 'status' => 'declined']);
            })->count();

// <------- Calculate Total Sales, Income & Payment Pending of that designer from tasks ---------->

            $taskAllSales = CustomTask::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->where('status','!=','delined')->sum('grand_total');

            $taskfullypaid = CustomTask::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->where('fully_paid',true)->sum('grand_total');
            
            $taskdepositpaid = CustomTask::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->where(['deposit_paid'=>true,'fully_paid'=>false])->sum('deposit');

            $taskAllIncome = $taskfullypaid + $taskdepositpaid;
// <---------------------------- End Calculation ------------------------------->

            $totalSales = $taskAllSales + array_sum($allOrderSales);
            $totalIncome = $taskAllIncome  + array_sum($allOrderIncome);
            $paymentPending = $totalSales - $totalIncome;

            $details = [
                'designer' => $name,
                'orders' => $orders,
                'tasks' => $tasks,
                'ordercompleted' => $ordercompleted,
                'orderdeclined' => $orderdeclined,
                'taskcompleted' => $taskcompleted,
                'taskdeclined' => $taskdeclined,
                'totalSales'=> $totalSales,
                'totalIncome' => $totalIncome,
                'paymentPending' => $paymentPending,
            ];
        $pdf = \PDF::loadView('pdf.designersalesreport', $details);
        return $pdf->download('designer-sales-report.pdf');    
    }
}
