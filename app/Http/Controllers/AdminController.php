<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('designer.dashboard');
    }

    public function users(){
        $users = User::all();
        return view('designer.users')->with('users',$users);
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
        return view('designer.edituser')->with('users',$user);
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
        return view('designer.profile')->with('user',$user);
    }

    public function editprofile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('designer.editprofile')->with('user',$user);
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

}
