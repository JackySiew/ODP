<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Orders;
use App\Review;
use Carbon\Carbon;
use App\CustomTask;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //get all month by orders
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
        $monthOrderCount = DB::table('orders')->whereMonth('created_at',$month)->get()->count();
        return $monthOrderCount;
    }

    //count monthly total order sales
    function getMonthlyOrdersSales($month){
        $monthOrderSales = DB::table('orders')->whereMonth('created_at',$month)->where('is_paid',true)->get()->sum('grand_total');
        return $monthOrderSales;
    }

    //count monthly total order sales
    function getMonthlyTasksSales($month){
        $monthTasksSales = DB::table('customize')->whereMonth('created_at',$month)->where(['fully_paid' => true, 'deposit_paid' =>true])->get()->sum('grand_total');
        return $monthTasksSales;
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
        $products = Product::all();
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

        //chart overview
        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels($months)
        ->datasets([
            [
                "label" => "Total Order",
                'backgroundColor' => "blue",
                'data' => $data     
            ],[
                "label" => "Total Customize Request",
                'backgroundColor' => "yellow",
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

    $orderSales = DB::table('orders')->where('status','!=','declined')->sum('grand_total');
    $taskSales = DB::table('customize')->where('status','!=','declined')->sum('grand_total');    
    $totalSales = $orderSales + $taskSales;
    $orderTrueSales = DB::table('orders')->where('status','!=','declined')->where('is_paid',true)->sum('grand_total');
    $taskFully = DB::table('customize')->where('status','!=','declined')->where('fully_paid',true)->sum('grand_total');
    $taskDeposit = DB::table('customize')->where('status','!=','declined')->where(['deposit_paid'=>true, 'fully_paid'=>false])->sum('deposit');
    $taskTrueSales = $taskFully + $taskDeposit;
    $actualSales = $orderTrueSales + $taskTrueSales;
    $paymentPending = $totalSales-$actualSales;
    $completeTask = DB::table('customize')->where('status','completed')->count();
    $completeOrder = DB::table('orders')->where('status','completed')->count();
    return view('admin.dashboard',compact('chartjs','chartjs2','chartjs3','orders','tasks','totalSales','actualSales','completeTask','completeOrder','paymentPending','products'));
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
        $user->mobile =$request->input('mobile');
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
        $users = DB::table('users')
        ->select('*')
        ->where('id','!=', Auth::user()->id)->get();
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
        if ($request->input('active') == 'on') {
            $user->active = true;
        }else{
            $user->active = false;
        }
        $user->update();

        return redirect('/users')->with('status','User account updated!'); 
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

    //admin view order's details
    public function getOrder($id){
        $orders = Orders::find($id);
        
        $orderItems = DB::table('order_items')
        ->join('products', 'order_items.product_id','=','products.id')
        ->join('users','products.presentBy','=','users.id')
        ->select('order_items.*','products.*','users.name')
        ->where([
            'order_items.order_id' => $orders->id
            ])->get();
       return view('admin.showorder',compact('orders','orderItems'));
    }

    //View all customize request tasks
    public function customizeTask(){
        $customs = CustomTask::all()->sortByDesc('created_at');
        return view('admin.tasks',compact('customs'));
    }

    // Admin View Customize task details
    public function getTask($id){
        $task = CustomTask::find($id);
        
        $taskItems = DB::table('custom_items')
        ->join('products', 'custom_items.product_id','=','products.id')
        ->join('users','products.presentBy','=','users.id')
        ->select('custom_items.*','products.*','users.name')
        ->where([
            'custom_items.custom_id' => $task->id
            ])->get();
        $dt = new Carbon();
        return view('admin.showtask',compact('task','taskItems','dt'));
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
