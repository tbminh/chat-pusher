<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Events\GreetingSent;
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

    public function fetchMessages($receiver)
    {
        $room_id = Message::where(function ($query) use ($receiver){
            $query->where('user_id', Auth::id())
                ->where('receiver',$receiver);
        })
        ->orWhere(function ($query) use ($receiver){
            $query->where('user_id',$receiver)
                ->where('receiver', Auth::id());
        })
        ->orderBy('room_id', 'asc')
        ->first();
        if ($room_id == null) {
            return [""];
        }
        return Message::with('user')
        ->where('room_id', $room_id->room_id)
        ->orderBy('id', 'desc') 
        ->take(6) 
        ->get()
        ->reverse()->values();
    }

    public function sendMessage(Request $request, $receiver){
        $message = Message::select('room_id')->where(function ($query) use ($receiver){
            $query->where('user_id', Auth::id())
                ->where('receiver',$receiver);
        })
        ->orWhere(function ($query) use ($receiver){
            $query->where('user_id',$receiver)
                ->where('receiver', Auth::id());
        })
        ->first();
        $user = Auth::user();

        if ($message == null) {
            $room_id = Message::select('room_id') + 1;
        }
        else{
            $room_id = $message->room_id;
        }
        // $message = $user->messages()->create([
        //     'receiver' => $receiver,
        //     'message' => $request->input('message'),
        //     'room_id' => $room_id
        // ]);
        
        // broadcast(new MessageSent($user, $message))->toOthers();
        return $room_id;
    }

    public function chat_zalo(){
        $get_users = DB::table('users')->get();
        return view('chat-form',['get_users'=>$get_users]);
    }

    public function get_list(Request $request){
        $search = $request->input('search');
        $list = DB::table('users')
                ->where('name', 'like', '%' . $search. '%')
                ->where('id','!=',Auth::id())
                ->get();
        return $list;
    }   
    public function get_current_user(){
        $user = Auth::id();
        return ['user'=>$user];
    }
    public function get_receiver($receiver){
        $user = User::where('id',$receiver)->first();
        return response()->json([
            'name'=>$user->name,
            'avatar'=>$user->avatar
        ]);
    }

    public function greetReceived($id){
        $receiver = User::find($id);
        $name = Auth::user()->name;
        broadcast(new GreetingSent($receiver, "{$name} đã chào bạn"))->toOthers();
        return "Lời chào từ {$name} đến {$receiver->name}";
    }

    public function authenticate(Request $request)
    {
        $socketId = $request->socket_id;
        $channelName = $request->channel_name;
        
        // Your authentication logic here
        // For example, check user's authentication, authorization for the channel
        
        // Return a response to allow or deny access
        return response()->json([
            'allow_access' => true, // or false based on your logic
        ]);
    }
}

