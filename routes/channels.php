<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('chat', function ($user) {
    return Auth::check();
});

Broadcast::channel('chat.greet.{receiver_id}',function (User $user, $receiver_id){
    return (int)$user->id === (int) $receiver_id;
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
