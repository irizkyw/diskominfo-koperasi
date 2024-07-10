<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminContoller;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;

use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('landing.home');
})->name('landing.home');

Route::get('/authentication/sign-in', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/authentication/authenticated', [AuthController::class, 'login'])->name('login.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', AdminMiddleware::class])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/groups', function(){
        return view('dashboard.pages.group');
    })->name('groups.index');
    Route::get('/savings', function(){
        return view('dashboard.pages.savings');
    })->name('savings.index');
});

// temp
Route::get('/admin/cekSemuaUser', [AdminContoller::class, 'cekSemuaUser']);
