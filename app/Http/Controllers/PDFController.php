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
                'paymentPending2' => $paymentPending2,
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
                'paymentPending2' => $paymentPending2,
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

            //get orders where involve the designer
            $orders = Orders::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->get();

            //get tasks where involve the designer
            $tasks = CustomTask::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->get();

            //count completed orders by the designer
            $ordercompleted = Orders::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->where('status','completed')->get()->count();

            //count completed tasks by the designer
            $taskcompleted = CustomTask::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->where('status','completed')->get()->count();

            //count paid orders by the designer
            $orderpaid = Orders::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->where('is_paid',true)->get()->sum('grand_total');

            //count fully paid tasks by the designer
            $taskfullypaid = CustomTask::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->where('fully_paid',true)->get()->sum('grand_total');

            //count deposit paid tasks by the designer
            $taskdepositpaid = CustomTask::whereHas('items',function($query) use ($user){
                $query->where('presentBy', $user);
            })->where('deposit_paid',true)->get()->sum('deposit');

            $totalIncome = $orderpaid+$taskfullypaid+$taskdepositpaid;
            //get all order id where involve the designer
            foreach ($orders as $order) {
                $order_id[] = $order->id;
            }    
            //get all task id where involve the designer
            foreach ($tasks as $task) {
                $task_id[] = $task->id;
                $allTaskPrice[] = $task->grand_total;
            }    

            //get all orderItems that involve the designer
            foreach ($order_id as $id) {
                $orderItems[] = DB::table('order_items')
            ->join('products', 'order_items.product_id','=','products.id')
            ->select('order_items.*','products.*')
            ->where([
                'order_items.order_id' => $id,
                'products.presentBy' => $user,
                ])->where('status','!=','declined')->get();
            }    

            //get all taskItems that involve the designer
            foreach ($task_id as $id) {
                $taskItems[] = DB::table('custom_items')
            ->join('products', 'custom_items.product_id','=','products.id')
            ->select('custom_items.*','products.*')
            ->where([
                'custom_items.custom_id' => $id,
                'products.presentBy' => $user
                ])->get();
            }    
            
            // get all order items' quantity and price
            foreach ($orderItems as $item) {
                foreach ($item as $value) {
                    $qty[] = $value->quantity;
                    $price[] = $value->price;
                }
            }
            //get sum sales from orders
            $allPrice = [];
            foreach($orderItems as $i=>$val){
                array_push($allPrice, $qty[$i] * $price[$i]);
            }

            //check both sales is empty or not
            if (!empty($allPrice) && !empty($allTaskPrice)) {
                $totalSales = array_sum($allPrice) + array_sum($allTaskPrice);
            }elseif(empty($allPrice) && !empty($allTaskPrice)){
                $totalSales = array_sum($allTaskPrice);
            }elseif(!empty($allPrice) && empty($allTaskPrice)){
                $totalSales = array_sum($allPrice);
            }else{
                $totalSales = 0; 
            }
            $paymentPending = $totalSales - $totalIncome;

            $details = [
                'designer' => $name,
                'orders' => $orders,
                'tasks' => $tasks,
                'ordercompleted' => $ordercompleted,
                'taskcompleted' => $taskcompleted,
                'totalSales'=> $totalSales,
                'totalIncome' => $totalIncome,
                'paymentPending' => $paymentPending,
            ];
        $pdf = \PDF::loadView('pdf.designersalesreport', $details);
        return $pdf->download('designer-sales-report.pdf');    
    }
}
