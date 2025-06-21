<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\Dashboard\AlumniSettingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AdminSettingController;
use App\Http\Controllers\FormQ1Controllers;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\ExportDataController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\MidtransNotificationController;
use App\Http\Controllers\EventUserController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\Dashboard\WorkshopAdminController;
use App\Http\Controllers\AlumniWorkshopController;

// ===================== HOMEPAGE =====================
Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');

// ===================== STATIC PAGES =====================
Route::get('/dashboard/partisipasi-alumni', fn() => view('pages.dashboard.table data.read_partisipasiAlumni'))->name('dashboard.partisipasi-alumni');
Route::get('/panduan', fn() => view('pages.panduan'))->name('panduan.index');

// ===================== DASHBOARD (AUTH) =====================
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    // Member - Alumni
    Route::prefix('member')->name('dashboard.member.')->group(function () {
        Route::resource('alumni', AlumniSettingController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names([
                'index' => 'alumni.index',
                'show' => 'alumni.show',
                'store' => 'alumni.store',
                'update' => 'alumni.update',
                'destroy' => 'alumni.destroy',
            ]);
        Route::get('alumni-export-all', [AlumniSettingController::class, 'exportAll'])->name('alumni.exportAll');
    });
    // Member - Admin
    Route::prefix('member')->name('dashboard.member.')->group(function () {
        Route::resource('admin', AdminSettingController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names([
                'index' => 'admin.index',
                'show' => 'admin.show',
                'store' => 'admin.store',
                'update' => 'admin.update',
                'destroy' => 'admin.destroy',
            ]);
        Route::get('admin-export-all', [AdminSettingController::class, 'exportAll'])->name('admin.exportAll');
    });
    // Dashboard utama
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'dashboard')->name('dashboard.dashboard');
    });
    Route::get('/alumni-career-status', [DashboardController::class, 'getAlumniCareerStatus'])->name('dashboard.alumni-career-status');
    // Kuesioner (DASHBOARD BARU)
    Route::prefix('kuesioner')->name('dashboard.kuesioner.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\KuesionerController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Dashboard\KuesionerController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Dashboard\KuesionerController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Dashboard\KuesionerController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\Dashboard\KuesionerController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Dashboard\KuesionerController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/pertanyaan', [\App\Http\Controllers\Dashboard\KuesionerController::class, 'addPertanyaan'])->name('pertanyaan.add');
        Route::delete('/{id}/pertanyaan/{pertanyaan_id}', [\App\Http\Controllers\Dashboard\KuesionerController::class, 'deletePertanyaan'])->name('pertanyaan.delete');
    });
    // Workshop/Event Pengembangan Diri (Admin)
    Route::prefix('workshop')->name('dashboard.workshop.')->group(function () {
        Route::get('/', [WorkshopAdminController::class, 'index'])->name('index');
        Route::post('/', [WorkshopAdminController::class, 'store'])->name('store');
        Route::put('/{id}', [WorkshopAdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [WorkshopAdminController::class, 'destroy'])->name('destroy');
    });
});



// ===================== AUTH =====================
// Login
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('login/google', 'redirectToGoogle')->name('login.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});
// Register
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register.show');
    Route::post('/register', 'register')->name('register');
    Route::get('/auth/google', 'redirectToGoogle')->name('google.redirect');
    Route::get('/auth/google/callback', 'handleGoogleCallback')->name('google.callback');
});

// ===================== GROUP CHAT =====================
Route::controller(GroupChatController::class)->group(function () {
    Route::get('/group-chat', 'index')->name('group-chat.index');
    Route::post('/group-chat/store', 'store')->name('group-chat.store');
    Route::get('/group-chat/messages', 'fetchMessages')->name('group-chat.messages');
    Route::get('/users/search', 'searchUsers')->name('users.search');
});

// ===================== PROFILE =====================
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile.index');
    Route::post('/profile/store', 'store')->name('profile.store');
});

// ===================== MIDTRANS =====================
Route::post('/midtrans/notification', [MidtransNotificationController::class, 'handle']);
Route::get('/midtrans/finish',   [MidtransNotificationController::class, 'finish'])->name('midtrans.finish');
Route::get('/midtrans/unfinish', [MidtransNotificationController::class, 'unfinish'])->name('midtrans.unfinish');
Route::get('/midtrans/error',    [MidtransNotificationController::class, 'error'])->name('midtrans.error');

// ===================== KUESIONER (PUBLIC) =====================
Route::get('/pengisian-tracer-study', [\App\Http\Controllers\KuesionerPublicController::class, 'index'])->name('kuesioner.list');
Route::get('/pengisian-tracer-study/{id}/form', [\App\Http\Controllers\KuesionerPublicController::class, 'form'])->name('kuesioner.form');
Route::post('/pengisian-tracer-study/{id}/submit', [\App\Http\Controllers\KuesionerPublicController::class, 'submit'])->name('kuesioner.submit');

// ===================== EVENT WORKSHOP (ALUMNI) =====================
Route::get('/event-user', [AlumniWorkshopController::class, 'index'])->name('alumni.workshop.index');
Route::get('/event-user/{id}', [AlumniWorkshopController::class, 'show'])->name('alumni.workshop.show');
Route::post('/event-user/{id}/daftar-ajax', [AlumniWorkshopController::class, 'daftarAjax'])->name('alumni.workshop.daftar.ajax');
Route::get('/simulator-pembayaran', [AlumniWorkshopController::class, 'simulatorPembayaranForm'])->name('alumni.simulator.form');
Route::post('/simulator-pembayaran', [AlumniWorkshopController::class, 'simulatorPembayaranProses'])->name('alumni.simulator.proses');