<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Orders;
use App\Product;
use App\Category;
use App\CustomTask;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DesignerController extends Controller
{
    // get all months by order
    public function getAllMonths(){
        $month_array= array();
        $orders_date = DB::table('orders')
        ->select('created_at')
        ->orderBy('created_at','asc')->pluck('created_at');
        if (!empty($orders_date)) {
            foreach ($orders_date as $date) {
                $date = new \DateTime($date);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }

    //count orders monthly
    function getMonthlyOrdersCount($month){
        $monthOrderCount = Orders::whereHas('items',function($query){
            $query->where('presentBy', Auth::user()->id);
        })->whereMonth('created_at',$month)->get()->count();
        return $monthOrderCount;
    }
    //count tasks monthly by order's month record
    function getMonthlyTasksCount($month){
        $monthTaskCount = CustomTask::whereHas('items',function($query){
            $query->where('presentBy', Auth::user()->id);
        })->whereMonth('created_at',$month)->get()->count();
        return $monthTaskCount;
    }
        
    //Dashboard
    public function index()
    {
        // Ordering data chart
        $monthly_order_count_array = array();
        $month_array = $this->getAllMonths();
        $month_name_array = array();
        if (!empty($month_array)) {
            foreach ($month_array as $month_no => $month_name) {
                $monthOrderCount = $this->getMonthlyOrdersCount($month_no);
                array_push($monthly_order_count_array,$monthOrderCount);
                array_push($month_name_array,$month_name);                
            }
        }

        $monthly_order_data_array= array(
            'months' => $month_name_array,
            'order_count_data' => $monthly_order_count_array
        );
        $months = $monthly_order_data_array['months'];
        $data = $monthly_order_data_array['order_count_data'];

        // Task data chart
        $monthly_task_count_array = array();
        $month_array2 = $this->getAllMonths();
        $month_name_array2 = array();
        if (!empty($month_array2)) {
            foreach ($month_array2 as $month_no => $month_name) {
                $monthTaskCount = $this->getMonthlyTasksCount($month_no);
                array_push($monthly_task_count_array,$monthTaskCount);
                array_push($month_name_array2,$month_name);                
            }
        }
        $monthly_task_data_array= array(
            'months' => $month_name_array2,
            'task_count_data' => $monthly_task_count_array
        );
        $data2 = $monthly_task_data_array['task_count_data'];
        $chartjs = app()->chartjs
        ->name('lineChart')
        ->type('line')
        ->size(['width' => 700, 'height' => 500])
        ->labels($months)
        ->datasets([
            [
                "label" => "Total Order",
                'borderColor' => "blue",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "red",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $data     
            ],[
                "label" => "Total Customize Request",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "green",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $data2     
            ]
                
        ])
        ->options([]);

        $user = Auth::user()->id;
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
                $orderItemSalesResult = DB::table('order_items')
                ->join('products', 'order_items.product_id','=','products.id')
                ->select('order_items.*')
                ->where([
                'order_items.order_id' => $id,
                'products.presentBy' => $user,  
                ])->where('status','!=','declined')->first();
                if ($orderItemSalesResult == null) {
                    $orderItemSales[] = DB::table('order_items')
                    ->select('*')->where('id','0')
                    ->first();
                }else{
                    $orderItemSales[] = $orderItemSalesResult;
                }
            }    
        }
        if (!empty($incomeId)) {
            foreach ($incomeId as $id) {
                $orderItemIncomeresult = DB::table('order_items')
                ->join('products', 'order_items.product_id','=','products.id')
                ->select('order_items.*')
                ->where([
                'order_items.order_id' => $id,
                'products.presentBy' => $user,  
                ])->where('status','!=','declined')->first();
                if ($orderItemIncomeresult == null) {
                    $orderItemIncome[] = DB::table('order_items')
                    ->select('*')->where('id','0')
                    ->first();
                }else{
                    $orderItemIncome[] = $orderItemIncomeresult;
                }

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

        $products = Product::where('presentBy',$user)->count();

        return view('designer.dashboard',compact('chartjs','orders','products','tasks','totalSales','totalIncome','paymentPending','ordercompleted','orderdeclined','taskcompleted','taskdeclined'));
    }


    public function profile(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $products = Product::where('presentBy',$user_id);
        if (session('status')) {
            Alert::success('Update successfully!', 'You have updated your profile!!!');
        }
        return view('designer.profile',compact('user','products'));
    }

    public function editprofile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('designer.editprofile')->with('user',$user);
    }

    public function updateprofile(Request $request, $id)
    {
        if ($request->hasFile('profile')) {
            $fileNameWithExt = $request->file('profile')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'_'.$extension;
            $path  =$request->file('profile')->storeAs('public/image', $fileNameToStore);
        }

        $user = User::find($id);
        $user->name =$request->input('name');
        $user->email =$request->input('email');
        $user->mobile =$request->input('mobile');
        if ($request->hasFile('profile')) {
            if ($user->profile != "noimage.png") {
                Storage::delete('public/image/'.$user->profile);          
                $user->profile = $fileNameToStore;
            }  
        }

        $user->update();

        return redirect('/profile')->with('status','Your Profile is updated'); 
    }

    //View customize tasks
    public function tasks()
    {
        return view('designer.tasks');
    }

}
