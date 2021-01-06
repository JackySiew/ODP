<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use Auth;
use DB;
use Pusher\Pusher;
class ChatController extends Controller
{
    //view chat room page
    public function index()
    {
        $users = DB::select("select users.id, users.name, users.profile, users.email, count(is_read) as unread
        from users LEFT JOIN messages on users.id = messages.from and is_read = 0 and messages.to =".Auth::id()."
        where users.id != ".Auth::id()." and users.usertype != 'user' group by users.id, users.name, users.profile, users.email");
        return view('user.chat',['users'=>$users]);
    }

    public function aindex()
    {
        $users = DB::select("select users.id, users.name, users.profile, users.email, count(is_read) as unread
        from users LEFT JOIN messages on users.id = messages.from and is_read = 0 and messages.to =".Auth::id()."
        where users.id != ".Auth::id()." group by users.id, users.name, users.profile, users.email");
        return view('admin.chat',['users'=>$users]);
    }

    public function dindex()
    {
        $users = DB::select("select users.id, users.name, users.profile, users.email, count(is_read) as unread
        from users LEFT JOIN messages on users.id = messages.from and is_read = 0 and messages.to =".Auth::id()."
        where users.id != ".Auth::id()." group by users.id, users.name, users.profile, users.email");
        return view('designer.chat',['users'=>$users]);
    }

    //ajax get message
    public function getMessage($user_id)
    {
        $my_id = Auth::id();
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);
        $messages = Message::where(function ($query) use ($user_id, $my_id){
            $query->where('from',$my_id)->where('to',$user_id);
        })->orWhere(function ($query) use ($user_id, $my_id){
            $query->where('from',$user_id)->where('to',$my_id);
        })->get();

        return view('message',['messages'=>$messages]);
    }
    
    //ajax send message
    public function sentMessage(Request $request){
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;
        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;//unread

        $data->save();

        // $user = User::find($to);
        // $action = ["Action"=>"Someone send message to you"];

        // $user->notify(new Action($action));

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $data = ['from' => $from, 'to' => $to];
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}
