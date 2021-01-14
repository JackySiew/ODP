<?php

namespace App\Http\Controllers;

use App\Product;
use Auth;
use Stripe\Stripe;
use Stripe\Charge;
use DB;
use App\CustomTask;
use App\CustomItems;
use App\Notifications\Action;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomController extends Controller
{
    // Designer view All customize tasks
    public function index(){
        $customs = CustomTask::whereHas('items',function($query){
            $query->where('presentBy', Auth::user()->id);
        })->orderBy('created_at','desc')->get();
        if (session('status')) {
            Alert::success('Update successfully!', 'You have accepted this task!');
        }else{
            Alert::success('Update successfully!', 'You have rejected this task!');            
        }
        $day = new Carbon();
        return view('designer.customize.tasks',compact('customs','day'));
    }
    
    // Designer View Customize task details
    public function getTask($id){
        $task = CustomTask::find($id);
        
        $taskItems = DB::table('custom_items')
        ->join('products', 'custom_items.product_id','=','products.id')
        ->select('custom_items.*','products.*')
        ->where([
            'custom_items.custom_id' => $task->id,
            'products.presentBy' => Auth::user()->id
            ])->get();
        $dt = new Carbon();
       return view('designer.customize.showtask',compact('task','taskItems','dt'));
    }

    // User Save & send customize request to designer
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postcode' => 'required',
            'mobile' => 'required',
            'description' => 'required',
            'deadline' => 'required',
        ]);
        
        $custom = new CustomTask();
        $custom->custom_number = uniqid();
        $custom->user_id = Auth::user()->id;
        $custom->status = 'pending';
        $custom->fullname = $request->input('fullname');
        $custom->address1 = $request->input('address1');
        $custom->address2 = $request->input('address2');
        $custom->city = $request->input('city');
        $custom->state = $request->input('state');
        $custom->postcode = $request->input('postcode');
        $custom->mobile = $request->input('mobile');
        $custom->deadline = $request->input('deadline');
        
        $custom->save();
        //send customize items
            $product = Product::find($request->input('prodid'));
            $custom_items = new CustomItems();
            $custom_items->product_id = $product->id;
            $custom_items->custom_id = $custom->id;
            $custom_items->quantity = $request->input('quantity');
            $custom_items->request = $request->input('description');
            $custom_items->save();
        $seller = User::find($product->presentBy);
        $action = ["Action"=>"Someone sent customize request to your product"];
        $seller->notify(new Action($action));
        return redirect('my-customize')->with('status', 'Your request has sent! You can check your customize request status at here.');

    }

    // User's send customize request page
    public function show($id)
    {
        $product = Product::find($id);
        return view('user.customize.customize',compact('product'));
    }

    //User go to pay deposit
    public function deposit($id){
        $deposit = CustomTask::find($id);
        $items = DB::table('custom_items')
        ->join('products', 'custom_items.product_id','=','products.id')
        ->select('custom_items.*','products.*')
        ->where('custom_items.custom_id', $deposit->id)->get();

        return view('user.pay.deposit',compact('deposit','items'));
    }

    public function paydeposit(Request $request, $id){
        $deposit = CustomTask::find($id);
        $items = DB::table('custom_items')
        ->join('products', 'custom_items.product_id','=','products.id')
        ->select('custom_items.*','products.*')
        ->where('custom_items.custom_id', $deposit->id)->get();
        foreach ($items as $item) {
            $seller = User::find($item->presentBy);
        }

        if ($request->input('payment_method') == 'stripe') {
            Stripe::setApiKey ('sk_test_51HFVGNCFq6SzGxX29Qawy6zsQPaLDyEWCJfZTJRI4ENUD2JRP0mKSv7n8LdbfsBWuasyqU7QErHVNliZ9ARKhBY400eCmKx89T');
            $charge = Charge::create ( array (
                    "amount" => $deposit->deposit * 100,
                    "currency" => "myr",
                    "source" => $request->input ( 'stripeToken' ), // obtained with Stripe.js
                    "description" => "Test payment." 
            ));
            $deposit->paydeposit_id = $charge->id;
        }

        $deposit->deposit_paid = 1;
        $deposit->status = 'processing';
        $deposit->update();

        $action = ["Action" => 'Your customer has paid the deposit'];
        $seller->notify(new Action($action));
        return redirect('/my-customize')->with('status','You have paid the deposit! Now your customize product is processing');
    }

    // Designer accept the task
    public function accept(Request $request)
    {
        $task = CustomTask::findOrFail($request->id);
        $user = User::find($task->user_id);
        $task->grand_total = $request->input('totalPrice');
        if ($request->input('deposit') == true) {
            $task->status = 'accepted';
            $task->deposit = $request->input('totalPrice') * 50/100;
            $action = ["Action" => "Your request are accepted, please pay deposit"];
        }else{
            $task->status = 'processing';
            $task->deposit_paid = 1;
            $action = ["Action" => "Your request are accepted"];
        }
        $task->update();
        $user->notify(new Action($action));
        return redirect()->back()->with('status','Task updated!');
    }

    // Designer decline the task
    public function decline(Request $request)
    {
        $task = CustomTask::findOrFail($request->id);
        $action = ["Action" => "Your request has been declined"];
        $user = User::find($task->user_id);
        $task->status = 'declined';
        $task->notes = $request->input('notes');
        $task->update();
        $user->notify(new Action($action));
        return redirect()->back()->with('status','Task Declined!');
    }

    // Designer deliver customized product
    public function deliver($id){
        $task = CustomTask::findOrFail($id);
        $action = ["Action" => "Your customized product is on delivering"];
        $task->status = 'processing';
        $task->update();
        $user = User::find($task->user_id);
        $user->notify(new Action($action));

        return redirect()->back()->with('status','Task Updated!');
    }

    // User reject to pay deposit
    public function declineDeposit($id){
        $task = CustomTask::findOrFail($id);
        $action = ["Action" => "Your customer is declined to pay deposit!"];
        $task->status = 'declined';
        $task->update();
        $items = DB::table('custom_items')
        ->join('products', 'custom_items.product_id','=','products.id')
        ->select('custom_items.*','products.*')
        ->where('custom_items.custom_id', $task->id)->get();
        foreach ($items as $item) {
            $seller = User::find($item->presentBy);
        }

        $seller->notify(new Action($action));

        return redirect()->back()->with('status','You has declined to pay this customize task deposit!');
    }

    public function cancel($id){
        $task = CustomTask::findOrFail($id);
        $action = ["Action" => "Your customer has cancel the task!"];
        $task->status = 'declined';
        $task->update();
        $items = DB::table('custom_items')
        ->join('products', 'custom_items.product_id','=','products.id')
        ->select('custom_items.*','products.*')
        ->where('custom_items.custom_id', $task->id)->get();
        foreach ($items as $item) {
            $seller = User::find($item->presentBy);
        }

        $seller->notify(new Action($action));
        return redirect()->back()->with('status','You have cancel the customize task!');

    }
}
