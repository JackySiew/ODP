<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Orders;
use App\Review;
use DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
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
    $monthOrderCount = Orders::where('status','2')->whereMonth('created_at',$month)->get()->count();
    return $monthOrderCount;
}
    /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
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

    $chartjs = app()->chartjs
    ->name('lineChartTest')
    ->type('line')
    ->size(['width' => 700, 'height' => 500])
    ->labels(['Jul','Aug','Sep'])
    ->datasets([
        [
            "label" => "Sales",
            'backgroundColor' => "rgba(38, 185, 154, 0.31)",
            'borderColor' => "rgba(38, 185, 154, 0.7)",
            "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
            "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
            "pointHoverBackgroundColor" => "#fff",
            "pointHoverBorderColor" => "rgba(220,220,220,1)",
            'data' => [340,575,450]]
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

    return view('admin.dashboard',compact('chartjs','chartjs2','chartjs3'));
    }

    public function users(){
        $users = User::all();
        return view('admin.users')->with('users',$users);
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edituser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('admin.edituser')->with('users',$user);
    }
    
    public function updateuser(Request $request, $id)
    {
        $user = User::find($id);
        $user->name =$request->input('name');
        $user->usertype =$request->input('usertype');
        $user->update();

        return redirect('/users')->with('status','User Updated'); 
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteuser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('status','User Deleted'); 
    }

    public function profile(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if (session('status')) {
            Alert::success('Update successfully!', 'You have updated your profile!!!');
        }
        return view('admin.profile',compact('user'));
    }

    public function editprofile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('admin.editprofile')->with('user',$user);
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

        return redirect('/aprofile')->with('status','Your Profile is updated'); 
    }
    public function prodlist(){
        $products = Product::all()->sortByDesc('created_at');
        return view('admin.prodlist')->with('products',$products);
    }

    public function orders(){
        $orders = Orders::all()->sortByDesc('created_at');
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('admin.orders',compact('orders'));
    }

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

}
