<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/chat-zalo', [App\Http\Controllers\ChatsController::class, 'chat_zalo']);

Route::get('/getList', [App\Http\Controllers\ChatsController::class, 'get_list']);
Route::get('/getCurrentUser', [App\Http\Controllers\ChatsController::class, 'get_current_user']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/chat', [App\Http\Controllers\ChatsController::class, 'index']);
Route::get('/messages/{room_id}', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage']);

