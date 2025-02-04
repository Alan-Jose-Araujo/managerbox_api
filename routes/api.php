<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredClientController;
use App\Http\Controllers\AuthenticationController;

Route::controller(RegisteredClientController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
});

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/login', 'login')->name('login');

    Route::post('/refresh-token', 'refreshToken')->name('refresh-token');

    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('logout');
});
