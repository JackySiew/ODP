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

            return view('admin.report.usersales',compact('designer','orders','tasks','totalSales','totalIncome','paymentPending','ordercompleted','orderdeclined','taskcompleted','taskdeclined'));
        }else{
            return redirect()->back()->with('error','Please enter a valid data!');
        }
    }    
}