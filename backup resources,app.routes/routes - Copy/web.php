<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Kelompok rute umum (halaman statis)
Route::get('/', fn() => view('pages.welcome'));
Route::get('/dashboard/partisipasi-alumni', fn() => view('pages.dashboard.table data.read_partisipasiAlumni'));
// Kelompok rute AuthController
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->name('logout');
});

// Kelompok rute RegisterController
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register.show');
    Route::post('/register', 'register')->name('register');
});

// Kelompok rute DashboardController
Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard.dashboard');
    Route::get('/dashboard/user-control', 'userControl')->name('dashboard.user-control');
});

