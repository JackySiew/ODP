<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Orders;
use App\Product;
use App\Category;
use DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DesignerController extends Controller
{
    public function getAllMonths(){
        $month_array= array();
        $orders_date = Orders::orderBy('created_at','asc')->pluck('created_at');
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
    function getMonthlyOrdersCount($month){
        $monthOrderCount = Orders::whereMonth('created_at',$month)->get()->count();
        return $monthOrderCount;
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Orders::all();
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
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
        $month_array = $this->getAllMonths();
        $monthly_order_data_array= array(
            'months' => $month_name_array,
            'order_count_data' => $monthly_order_count_array
        );
        $months = $monthly_order_data_array['months'];
        $data = $monthly_order_data_array['order_count_data'];

        $chartjs2 = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 700, 'height' => 500])
        ->labels($months)
        ->datasets([
            [
                "label" => "Total Order",
                'backgroundColor' => "rgba(0,0,255,0.1)",
                'borderColor' => "blue",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $data     ]
                
        ])
        ->options([]);

        $pending = Orders::where('status',0)->count();
        $shipping = Orders::where('status',1)->count();
        $shipped = Orders::where('status',2)->count();
        $chartjs = app()->chartjs
        ->name('Order')
        ->type('pie')
        ->size(['width' => 700, 'height' => 500])
        ->labels(['Pending', 'Shipped','Shipping'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384','green', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384','green', '#36A2EB'],
                'data' => [$pending,$shipped, $shipping]
            ]
        ])
        ->options([]);
        $categories = Category::all()->pluck('category_name');
        $chartjs3 = app()->chartjs
        ->name('Product')
        ->type('doughnut')
        ->size(['width' => 700, 'height' => 500])
        ->labels(["Living Room","Office Room","Sofa","Table","Chair","Storage","Stool","Benches","Bedroom"])
        ->datasets([
            [
                'backgroundColor' => ['red','orange','yellow','green','blue','black','purple','gold','grey'],
                'hoverBackgroundColor' => ['red','orange','yellow','green','blue','black','purple','gold','grey'],
                'data' => [0,0,0,0,1,0,1,0,1]
            ]
        ])
        ->options([]);

        return view('designer.dashboard',compact('chartjs','chartjs2','chartjs3'));
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
        if ($request->hasFile('profile')) {
            if ($user->profile != "noimage.png") {
                Storage::delete('public/image/'.$user->profile);          
                $user->profile = $fileNameToStore;
            }  
        }

        $user->update();

        return redirect('/profile')->with('status','Your Profile is updated'); 
    }
    public function orders()
    {
        $orders = Orders::all()->sortByDesc('created_at');
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('designer.order',compact('orders'));
    }
    public function tasks()
    {

        return view('designer.tasks');
    }

}
