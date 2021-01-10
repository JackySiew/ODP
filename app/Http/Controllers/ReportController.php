<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Orders;
use App\CustomTask;
use App\User;

class ReportController extends Controller
{
    public function index(){
        $users = User::where('usertype','designer')->orderBy('name','asc')->get();
        return view('admin.report.report',compact('users'));
    }
    public function checkReport(Request $request){
        if ($request->date) {
            $date = $request->date;
            $orders = DB::table('orders')->whereDate('created_at',$date)->get();
            $sum = DB::table('orders')->whereDate('created_at',$date)->where('status','!=','declined')->sum('grand_total');
            $tasks = DB::table('customize')->whereDate('created_at',$date)->get();
            $fullypaid = DB::table('customize')->whereDate('created_at',$date)->where('fully_paid',true)->sum('grand_total');
            $depositpaid = DB::table('customize')->whereDate('created_at',$date)->where('deposit_paid',true)->sum('deposit');            
            $sum2 = $fullypaid + $depositpaid;
            return view('admin.report.result',compact('orders','tasks','sum','sum2','date'));
        }elseif ($request->month && $request->year) {
            $year = $request->year;
            $month = $request->month;
            $orders = DB::table('orders')->whereYear('created_at',$year)->whereMonth('created_at',$month)->get();
            $sum = DB::table('orders')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('status','!=','declined')->sum('grand_total');
            $tasks = DB::table('customize')->whereYear('created_at',$year)->whereMonth('created_at',$month)->get();
            $fullypaid = DB::table('customize')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('fully_paid',true)->sum('grand_total');
            $depositpaid = DB::table('customize')->whereYear('created_at',$year)->whereMonth('created_at',$month)->where('deposit_paid',true)->sum('deposit');            
            $sum2 = $fullypaid + $depositpaid;
            return view('admin.report.result',compact('orders','tasks','sum','sum2','year','month'));
        }elseif($request->year){
            $year = $request->year;
            $orders = DB::table('orders')->whereYear('created_at',$year)->get();
            $sum = DB::table('orders')->whereYear('created_at',$year)->where('status','!=','declined')->sum('grand_total');
            $tasks = DB::table('customize')->whereYear('created_at',$year)->get();
            $fullypaid = DB::table('customize')->whereYear('created_at',$year)->where('fully_paid',true)->sum('grand_total');
            $depositpaid = DB::table('customize')->whereYear('created_at',$year)->where('deposit_paid',true)->sum('deposit');            
            $sum2 = $fullypaid + $depositpaid;
            return view('admin.report.result',compact('orders','tasks','sum','sum2','year'));
        }elseif($request->user){
            //Designer Id
            $user= $request->user;

            //get designer all details
            $designer = User::where('id',$user)->get();

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
            if ($orders != null) {
                foreach ($orders as $order) {
                    $order_id[] = $order->id;
                }    
            }
            //get all task id where involve the designer
            if ($tasks != null) {
                foreach ($tasks as $task) {
                    $task_id[] = $task->id;
                    $allTaskPrice[] = $task->grand_total;
                }    
            }

            //get all orderItems that involve the designer
            if (!empty($order_id)) {
                foreach ($order_id as $id) {
                    $orderItems[] = DB::table('order_items')
                ->join('products', 'order_items.product_id','=','products.id')
                ->select('order_items.*','products.*')
                ->where([
                    'order_items.order_id' => $id,
                    'products.presentBy' => $user,
                    ])->where('status','!=','declined')->get();
                }    
            }

            //get all taskItems that involve the designer
            if (!empty($task_id)) {
                foreach ($task_id as $id) {
                    $taskItems[] = DB::table('custom_items')
                ->join('products', 'custom_items.product_id','=','products.id')
                ->select('custom_items.*','products.*')
                ->where([
                    'custom_items.custom_id' => $id,
                    'products.presentBy' => $user
                    ])->get();
                }    
            }
            
            // get all order items' quantity and price
            if (!empty($orderItems)) {
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
            return view('admin.report.usersales',compact('designer','orders','tasks','ordercompleted','taskcompleted','totalSales','totalIncome','paymentPending'));
        }else{
            return redirect()->back()->with('error','Please enter a valid data!');
        }
    }    
}