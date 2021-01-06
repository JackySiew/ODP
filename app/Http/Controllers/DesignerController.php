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
        ->join('users', 'orders.user_id','=','users.id')
        ->join('order_items', 'orders.id','=','order_items.order_id')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('orders.created_at')
        ->where('products.presentBy', Auth::user()->id)
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
        $monthOrderCount = DB::table('orders')->whereMonth('created_at',$month)->get()->count();
        return $monthOrderCount;
    }
    //count tasks monthly by order's month record
    function getMonthlyTasksCount($month){
        $monthTaskCount = DB::table('customize')->whereMonth('created_at',$month)->get()->count();
        return $monthTaskCount;
    }
        
    //Dashboard
    public function index()
    {
        // Ordering data chart
        $orders = Orders::all();
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
        $tasks = CustomTask::all();
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
        
        alert()->info('InfoAlert','jkzbkgbdkgdj');
        return view('designer.dashboard',compact('chartjs'));
    }


    public function profile(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if (session('status')) {
            Alert::success('Update successfully!', 'You have updated your profile!!!');
        }
        return view('designer.profile',compact('user'));
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
