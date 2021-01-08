<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;

class ReportController extends Controller
{
    public function index(){
        $users = User::all();
        return view('admin.report.report',compact('users'));
    }
    public function checkReport(Request $request){
        if ($request->date) {
            $date = $request->date;
            $orders = DB::table('orders')->whereDate('created_at',$date)->get();
            $sum = DB::table('orders')->whereDate('created_at',$date)->sum('grand_total');
            return view('admin.report.result',compact('orders','sum','date'));
        }elseif ($request->month && $request->year) {
            $year = $request->year;
            $month = $request->month;
            $orders = DB::table('orders')->whereYear('created_at',$year)->whereMonth('created_at',$month)->get();
            $sum = DB::table('orders')->whereYear('created_at',$year)->whereMonth('created_at',$month)->sum('grand_total');
            return view('admin.report.result',compact('orders','sum','year','month'));

        }elseif($request->year){
            $year = $request->year;
            $orders = DB::table('orders')->whereYear('created_at',$year)->get();
            $sum = DB::table('orders')->whereYear('created_at',$year)->sum('grand_total');
            return view('admin.report.result',compact('orders','sum','year'));
        }else{
            return redirect()->back()->with('error','Please enter a valid data!');
        }
    }
}
