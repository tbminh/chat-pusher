<?php

use App\Http\Controllers\ChatsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/broadcasting/auth', function (Request $request) {
    $socketId = $request->input('socket_id');
    $channelName = $request->input('channel_name');

    // Perform authentication logic here based on $socketId, $channelName
    // Example: Check if the user is authenticated
   
    return response()->json(['authorized' => true]);
    
});
// Route::post('/broadcasting/auth', [ChatsController::class, 'authenticate']);
