<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserControllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::post('/login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/users', [UserControllers::class, 'index']);

    Route::post('/chat/send', [MessageController::class, 'store']);
    Route::get('/chat/messages/{user_id}', [MessageController::class, 'getMessages']);
    Route::patch('/chat/read/{message_id}', [MessageController::class, 'markAsRead']);
});