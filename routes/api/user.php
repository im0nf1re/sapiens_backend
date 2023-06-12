<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
 
Route::post('/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register']);

Route::post('/send-reset-code', [UserController::class, 'sendResetCode']);
Route::post('/check-reset-code', [UserController::class, 'checkResetCode']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);