<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Order;
use DB;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
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
        return view('admin.profile')->with('user',$user);
    }

    public function editprofile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('admin.editprofile')->with('user',$user);
    }

    public function updateprofile(Request $request, $id)
    {
        $user = User::find($id);
        $user->name =$request->input('name');
        $user->email =$request->input('email');
        $user->phone =$request->input('phone');
        $user->update();

        return redirect('/profile')->with('status','Your Profile is updated'); 
    }
    public function prodlist(){
        $products = Db::table('products')
        ->join('category', 'products.category','=','category.id')
        ->select('products.*','category.category_name')
        ->orderBy('created_at','desc')
        ->get();
        return view('admin.prodlist')->with('products',$products);
    }

}
