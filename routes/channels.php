<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
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


Broadcast::channel('chat.{roomId}', function (User $user, $roomId) {
    // return $user->id === $userId;
    return $user->canJoinChatRoom($roomId);
});
// Broadcast::channel('chat', function ($user) {
//     return Auth::check();
// });
