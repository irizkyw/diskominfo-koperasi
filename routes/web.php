<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminContoller;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TabunganController;

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


    Route::get('/cekSemuaUser', [AdminContoller::class, 'cekSemuaUser']);

    Route::get('/transaksi/LogTransaksiAll', [TransaksiController::class, 'cekTransaksiAll']);

    Route::get('/transaksi/LogAllTransaksiByUserId/{id}', [TransaksiController::class, 'LogAllTransaksiByUserId']);
    Route::get('/transaksi/LogTransaksiSimpananBulananByUserId/{id}', [TransaksiController::class, 'LogTransaksiSimpananBulananByUserId']);

    Route::get('/transaksi/SumTransaksiSimpananBulananByUserId/{id}', [TransaksiController::class, 'SumTransaksiSimpananBulananByUserId']);
    Route::get('/transaksi/SumTransaksiSimpananAkhirByUserId/{id}', [TransaksiController::class, 'SumTransaksiSimpananAkhirByUserId']);
    Route::get('/transaksi/LaporanByUserId/{id}', [TransaksiController::class, 'LaporanByUserId']);

    Route::get('/tabungan/cekTabunganAll', [TabunganController::class, 'cekTabunganAll']);
    Route::get('/tabungan/cekTabunganByUserAuth', [TabunganController::class, 'cekTabunganByUserAuth']);
    Route::get('/tabungan/cekTabunganByUser/{id}', [TabunganController::class, 'cekTabunganByUserId']);
    Route::get('/tabungan/updateSimpananBulananUser/{id}', [TabunganController::class, 'updateSimpananBulananUser']);

});