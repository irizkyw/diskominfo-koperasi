<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.home');
});

Route::get('/dashboard', function() {
    return view('dashboard.pages.dashboard');
});
