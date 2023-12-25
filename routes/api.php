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
    // Xử lý logic xác thực ở đây
    // Lấy thông tin socket_id và channel_name từ $request
    
    // Ví dụ: trả về kết quả xác thực dựa trên người dùng hiện tại
    if (Auth::check()) {
        return response()->json(['authorized' => true]);
    } else {
        return response()->json(['authorized' => false]);
    }
});
// Route::post('/broadcasting/auth', [ChatsController::class, 'authenticate']);
