<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\Dashboard\MemberSettingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DashboardEffecientController;
use App\Http\Controllers\Dashboard\UserSettingController;
use App\Http\Controllers\FormQ1Controllers;
use App\Http\Controllers\Dashboard\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\ExportDataController;

// 1. HomepageController
Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');

// 2. Routes Menggunakan Closure (Tanpa Controller)
Route::get('/dashboard/partisipasi-alumni', fn() => view('pages.dashboard.table data.read_partisipasiAlumni'))->name('dashboard.partisipasi-alumni');
Route::get('/panduan', fn() => view('pages.panduan'))->name('panduan.index');
Route::get('/pengisian-tracer-study', fn() => view('pages.Kuesioner.index_quest'))->name('kuesioner.index');
Route::get('/pengisian-tracer-study/Tracer-Study-1', fn() => view('pages.Kuesioner.Tracer-study-1'))->name('kuesioner.tracer-study-1');

// 3. FormQ1Controllers
Route::get('/pengisian-tracer-study/Tracer-Study-1/Q1', [FormQ1Controllers::class, 'index'])
    ->name('kuesioner.tracer-study-1.index');
Route::get('/pengisian-tracer-study/Tracer-Study-1/Q1_2015-2020', [FormQ1Controllers::class, 'index_Public'])
    ->name('kuesioner.tracer-study-1.index_public');
Route::post('/pengisian-tracer-study/Tracer-Study-1/Q1_2015-2020', [FormQ1Controllers::class, 'store_public'])
    ->name('kuesioner.tracer-study-1.store_public');
Route::get('/search-by-nim/{nim}', [FormQ1Controllers::class, 'searchByNim'])
    ->name('alumni.searchByNim');

// 4. Dashboard Controllers
// a. MemberSettingController
Route::controller(MemberSettingController::class)->group(function () {
    Route::get('/dashboard/member/setting', 'memberSetting')->name('dashboard.member-setting');
    Route::post('/alumni', 'store')->name('alumni.store');
    Route::get('/alumni/{id}', 'ambilDataAlumni')->name('alumni.show');
    Route::put('/alumni/{id}', 'update')->name('alumni.update');
    Route::delete('/alumni/{id}', 'destroy');
});

// b. UserSettingController
Route::controller(UserSettingController::class)->group(function () {
    Route::get('dashboard/user/setting', 'index')->name('dashboard.user-setting');
    Route::post('dashboard/user/setting', 'store')->name('dashboard.user.setting.store');
    Route::get('dashboard/user/setting/{id}', 'show')->name('dashboard.user.setting.show');
    Route::get('dashboard/user/setting/{id}', 'show')->name('dashboard.user.setting.search');
    Route::put('dashboard/user/setting/{id}', 'update')->name('dashboard.user.setting.update');
    Route::delete('dashboard/user/setting/{id}', 'destroy')->name('dashboard.user.setting.destroy');
});

// c. DashboardController
Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard.dashboard');
});

Route::get('/alumni-career-status', [DashboardController::class, 'getAlumniCareerStatus'])->name('dashboard.alumni-career-status');

// d. EventController (prefix "dashboard")
Route::prefix('dashboard')->group(function () {
    Route::get('/event/setting', [EventController::class, 'index'])->name('dashboard.events.index');
    Route::get('/event/create', [EventController::class, 'create'])->name('dashboard.events.create');
    Route::post('/event/store', [EventController::class, 'store'])->name('dashboard.events.store');
    Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('dashboard.events.edit');
    Route::put('/event/{event}/update', [EventController::class, 'update'])->name('dashboard.events.update');
    Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('dashboard.events.destroy');
    Route::get('/event/mendaftar', [EventController::class, 'mendaftar'])->name('dashboard.events.mendaftar');
});

// e. ExportDataController
Route::get('/export-data', [ExportDataController::class, 'index'])->name('export-data.index');
Route::get('dashboard/export-all', [ExportDataController::class, 'export'])->name('dashboard.export-all');

// 5. Auth Controllers
// a. AuthController
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('login/google', 'redirectToGoogle')->name('login.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

// b. RegisterController
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register.show');
    Route::post('/register', 'register')->name('register');
    Route::get('/auth/google', 'redirectToGoogle')->name('google.redirect');
    Route::get('/auth/google/callback', 'handleGoogleCallback')->name('google.callback');
});

Route::controller(GroupChatController::class)->group(function () {
    Route::get('/group-chat', 'index')->name('group-chat.index');
    Route::post('/group-chat/store', 'store')->name('group-chat.store');
    Route::get('/group-chat/messages', 'fetchMessages')->name('group-chat.messages');
    Route::get('/users/search', 'searchUsers')->name('users.search');
});



// 7. ProfileController
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile/create', 'create')->name('profile.create');
    Route::post('/profile/store', 'store')->name('profile.store');
});

