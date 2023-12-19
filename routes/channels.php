<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Message;

Broadcast::channel('chat.{roomId}', function (Message $message, $roomId) {
    return $message->room_id === $roomId;
});
Broadcast::channel('chat', function ($user) {
    return Auth::check();
});


/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
