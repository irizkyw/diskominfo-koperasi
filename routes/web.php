<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminContoller;
use App\Http\Controllers\TransaksiController;
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


Route::get('/admin/cekSemuaUser', [AdminContoller::class, 'cekSemuaUser']);


Route::get('/admin/transaksi/cekTransaksiAll', [TransaksiController::class, 'cekTransaksiAll']);
Route::get('/admin/transaksi/cekTransaksiSimpananBulananByUserId/{id}', [TransaksiController::class, 'cekTransaksiSimpananBulananByUserId']);
Route::get('/admin/transaksi/cekTransaksiSimpananByUserId/{id}', [TransaksiController::class, 'SumTransaksiSimpananBulananByUserId']);

Route::get('/admin/tabungan/updateSimpananBulananUser/{id}', [TransaksiController::class, 'updateSimpananBulananUser']);