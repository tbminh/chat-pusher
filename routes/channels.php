<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('chat', function ($user) {
    return Auth::check();
    // return true;
});

Broadcast::channel('chat.greet.{receiver_id} ',function ($user, $receiver_id){ //    
    // return Auth::check();    
    // return (int)$user->id === (int) $receiver_id;
    return true;
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
