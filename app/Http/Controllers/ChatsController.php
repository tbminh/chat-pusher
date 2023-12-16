<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Broadcast;
use App\Jobs\ProcessPodcast;

class ChatsController extends Controller
{
    //Add the below functions
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat');
    }

    public function fetchMessages($room_id)
    {
        return Message::with('user')->where('room_id',$room_id)->get();
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'message' => $request->input('message'),
            'room_id' => 1
        ]);
        broadcast(new MessageSent($user, $message))->toOthers();
        return $user;
    }
    public function chat_zalo(){
        $get_users = DB::table('users')->get();
        return view('chat-form',['get_users'=>$get_users]);
    }

    public function get_list(Request $request){
        $search = $request->input('search');
        $list = DB::table('users')->where('name', 'like', '%' . $search. '%')->get();
        return $list;
    }   
    public function get_current_user(){
        $user = Auth::id();
        return ['user'=>$user];
    }
}

