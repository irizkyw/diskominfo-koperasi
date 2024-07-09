<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Middleware\AdminMiddleware;


Route::get('/', function () {
    return view('landing.home');
})->name('landing.home');

Route::get('/authentication/sign-in', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/authentication/authenticated', [AuthController::class, 'login'])->name('login.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
