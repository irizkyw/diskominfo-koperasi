<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\AdminContoller;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;

use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\GolonganController;

use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('landing.home');
})->name('landing.home');

Route::get('/authentication/sign-in', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/authentication/authenticated', [AuthController::class, 'login'])->name('login.submit');

Route::middleware(['auth'])->group(function () {
    route::get('/profile', function(){return view('dashboard.pages.profile');})->name('profile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', AdminMiddleware::class])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/datatable', [UsersController::class, 'datatable'])->name('users.datatable');
    Route::get('/users/generate', [UsersController::class, 'getNewMemberNumber'])->name('users.generate_number');
    Route::get('/users/detail/{num_member}', [UsersController::class, 'cekUserByNumMember'])->name('users.detail');
    Route::post('/users/create', [UsersController::class, 'createUser'])->name('users.create');
    Route::post('/users/update/{id}', [UsersController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/destory/{id}', [UsersController::class, 'deleteUser'])->name('users.destroy');

    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::get('/roles/datatable', [RolesController::class, 'datatable'])->name('roles.datatable');
    Route::post('/roles/create', [RolesController::class, 'store'])->name('roles.create');
    Route::post('/roles/update/{id}', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/destroy/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles/detail/{id}', [RolesController::class, 'findById'])->name('roles.findById');


    Route::get('/golongan', [GolonganController::class, 'index'])->name('golongan.index');
    Route::get('/golongan/datatable', [GolonganController::class, 'datatable'])->name('golongan.datatable');

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
