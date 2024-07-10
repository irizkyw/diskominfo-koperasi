<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminContoller;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\TabunganController;


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


Route::get('/admin/transaksi/LogTransaksiAll', [TransaksiController::class, 'cekTransaksiAll']);

Route::get('/admin/transaksi/LogAllTransaksiByUserId/{id}', [TransaksiController::class, 'LogAllTransaksiByUserId']);
Route::get('/admin/transaksi/LogTransaksiSimpananBulananByUserId/{id}', [TransaksiController::class, 'LogTransaksiSimpananBulananByUserId']);

Route::get('/admin/transaksi/SumTransaksiSimpananBulananByUserId/{id}', [TransaksiController::class, 'SumTransaksiSimpananBulananByUserId']);
Route::get('/admin/transaksi/SumTransaksiSimpananAkhirByUserId/{id}', [TransaksiController::class, 'SumTransaksiSimpananAkhirByUserId']);
Route::get('/admin/transaksi/LaporanByUserId/{id}', [TransaksiController::class, 'LaporanByUserId']);

Route::get('/admin/tabungan/cekTabunganAll', [TabunganController::class, 'cekTabunganAll']);
Route::get('/admin/tabungan/cekTabunganByUserAuth', [TabunganController::class, 'cekTabunganByUserAuth']);
Route::get('/admin/tabungan/cekTabunganByUser/{id}', [TabunganController::class, 'cekTabunganByUserId']);
Route::get('/admin/tabungan/updateSimpananBulananUser/{id}', [TabunganController::class, 'updateSimpananBulananUser']);