<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Página inicial redireciona para login
Route::get('/', function () {
    return redirect('/login');
});

// Rotas para o Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Rotas para o Registro
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Rota para Logout
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// Rotas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::controller(\App\Http\Controllers\ItemInStockController::class)->group(function () {
    Route::get('/items-in-stock', 'index')->name('items-in-stock');
})->middleware('auth');
