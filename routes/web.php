<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(\App\Http\Controllers\RegisteredClientController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
});

Route::controller(\App\Http\Controllers\AuthenticationController::class)->group(function () {
    Route::post('/login', 'login')->name('login');

    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('logout');
});
