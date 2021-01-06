<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Orders;
use App\Review;
use App\CustomTask;
use DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function getAllMonths(){
        $month_array= array();
        $orders_date = DB::table('orders')
        ->join('users', 'orders.user_id','=','users.id')
        ->join('order_items', 'orders.id','=','order_items.order_id')
        ->join('products', 'order_items.product_id','=','products.id')
        ->select('orders.created_at')
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
    // Dashboard
    public function index(){

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

    $admin = User::where('usertype','admin')->count();
    $designer = User::where('usertype','designer')->count();
    $user = User::where('usertype','user')->count();
    $chartjs2 = app()->chartjs
    ->name('Users')
    ->type('pie')
    ->size(['width' => 700, 'height' => 500])
    ->labels(['Admin', 'Designer','User'])
    ->datasets([
        [
            'backgroundColor' => ['red','orange', 'blue'],
            'hoverBackgroundColor' => ['red','orange', 'blue'],
            'data' => [$admin,$designer, $user]
        ]
    ])
    ->options([]);
    
    $five = Review::where('rating','5')->count();
    $four = Review::where('rating','4')->count();
    $three = Review::where('rating','3')->count();
    $two = Review::where('rating','2')->count();
    $one = Review::where('rating','1')->count();

    $chartjs3 = app()->chartjs
    ->name('Rates')
    ->type('radar')
    ->size(['width' => 700, 'height' => 500])
    ->labels(['5', '4','3','2','1'])
    ->datasets([
        [
            "label" => "Total rates",
            'borderColor' => 'rgba(240, 255, 0, 1)',
            'backgroundColor' => 'rgba(240, 255, 0, 0.5)',
            'data' => [$five,$four,$three,$two,$one]
        ]
    ])
    ->options([]);

    return view('admin.dashboard',compact('chartjs','chartjs2','chartjs3','orders','tasks'));
    }

    //View admin profile
    public function profile(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if (session('status')) {
            Alert::success('Update successfully!', 'You have updated your profile!!!');
        }
        return view('admin.profile',compact('user'));
    }

    //Edit Admin Profile
    public function editprofile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('admin.editprofile')->with('user',$user);
    }

    //Update Admin Profile
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
        if ($request->hasFile('profile')) {
            if ($user->profile != "noimage.png") {
                Storage::delete('public/image/'.$user->profile);          
                $user->profile = $fileNameToStore;
            }  
        }

        $user->update();

        return redirect('/aprofile')->with('status','Your Profile is updated'); 
    }

    // View all products
    public function prodlist(){
        $products = Product::all()->sortByDesc('created_at');
        return view('admin.prodlist')->with('products',$products);
    }

    
    //View all users
    public function users(){
        $users = User::all();
        return view('admin.users')->with('users',$users);
    }

    
    //Edit user details
    public function edituser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('admin.edituser')->with('users',$user);
    }
    
    //Update user details
    public function updateuser(Request $request, $id)
    {
        $user = User::find($id);
        $user->name =$request->input('name');
        $user->usertype =$request->input('usertype');
        $user->update();

        return redirect('/users')->with('status','User Updated'); 
    }
    
    public function activation(){
        $user = User::find($id);
        $user->active = $status;
        $user->update();
        return redirect('/users')->with('status','User Updated'); 
    }

    //Delete user
    public function deleteuser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('status','User Deleted'); 
    }

    // View all orders
    public function orders(){
        $orders = Orders::all()->sortByDesc('created_at');
        return view('admin.orders',compact('orders'));
    }

    //View all customize request tasks
    public function customizeTask(){
        $customs = CustomTask::all()->sortByDesc('created_at');
        return view('admin.tasks',compact('customs'));
    }
    // View product's details
    public function show($id)
    {
        $products = DB::table('products')
        ->join('categories', 'products.category','=','categories.id')
        ->select('products.*','categories.category_name')
        ->where('products.id',$id)
        ->get();
        $reviews = DB::table('reviews')
        ->join('users', 'reviews.user_id','=','users.id')
        ->select('reviews.*','users.name')
        ->where('reviews.product_id',$id)
        ->get();
        return view('admin.show',compact('products','reviews'));
    }
    public function report(){
        return view('admin.report');
    }

}
