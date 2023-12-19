<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
//Add the following two models
use App\Models\User;
use App\Models\Message;

class MessageSent implements ShouldBroadcast
{
    public $user;
    public $message;
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Message $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()//: array
    {
        // return new PrivateChannel('chat.'.$this->message->room_id);
        // return [new PrivateChannel('chat.'.$this->message->room_id)];
        return [
            'chat'
        ];
    }
}
