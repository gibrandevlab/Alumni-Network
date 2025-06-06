<?php

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
use Illuminate\Support\Facades\Route;

// 1. HomepageController
Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');

// 2. Routes Menggunakan Closure (Tanpa Controller)
Route::get('/dashboard/partisipasi-alumni', fn() => view('pages.dashboard.table data.read_partisipasiAlumni'))->name('dashboard.partisipasi-alumni');
Route::get('/panduan', fn() => view('pages.panduan'))->name('panduan.index');

// 3. Hapus route lama kuesioner
// Route::get('/pengisian-tracer-study', fn() => view('pages.Kuesioner.index_quest'))->name('kuesioner.index');
// Route::get('/pengisian-tracer-study/Tracer-Study-1', fn() => view('pages.Kuesioner.Tracer-study-1'))->name('kuesioner.tracer-study-1');
// Route::get('/pengisian-tracer-study/Tracer-Study-1/Q1', [FormQ1Controllers::class, 'index'])->name('kuesioner.tracer-study-1.index');
// Route::get('/pengisian-tracer-study/Tracer-Study-1/Q1_2015-2020', [FormQ1Controllers::class, 'index_Public'])->name('kuesioner.tracer-study-1.index_public');
// Route::post('/pengisian-tracer-study/Tracer-Study-1/Q1_2015-2020', [FormQ1Controllers::class, 'store_public'])->name('kuesioner.tracer-study-1.store_public');
// Route::get('/search-by-nim/{nim}', [FormQ1Controllers::class, 'searchByNim'])->name('alumni.searchByNim');

// Route dinamis baru untuk sistem kuesioner
Route::prefix('pengisian-tracer-study')->group(function () {
    Route::get('/', [KuesionerController::class, 'index'])->name('kuesioner.index');
    Route::get('/{event_id}/form', [KuesionerController::class, 'showForm'])->name('kuesioner.form');
    Route::post('/{event_id}/submit', [KuesionerController::class, 'submit'])->name('kuesioner.submit');
});

// 4. Dashboard Controllers

Route::middleware(['auth'])->group(function () {
    // AlumniSettingController Routes
    Route::prefix('dashboard/member')->name('dashboard.member.')->group(function () {
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

    // AdminSettingController Routes
    Route::prefix('dashboard/member')->name('dashboard.member.')->group(function () {
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

    // DashboardController Routes
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard.dashboard');
    });

    Route::get('/alumni-career-status', [DashboardController::class, 'getAlumniCareerStatus'])->name('dashboard.alumni-career-status');

    // Event User Routes
    Route::get('/event-user', [EventUserController::class, 'index'])->name('event.user.index');
    Route::get('/event-user/order/{eventId}', [EventUserController::class, 'order'])->name('event.user.order');
    Route::post('/event-user/daftar/{eventId}', [EventUserController::class, 'daftar'])->name('event.user.daftar');
    Route::get('/event-user/daftar/{eventId}', function ($eventId) {
        return redirect()->route('event.user.order', $eventId);
    });
});

// EventController
Route::controller(EventController::class)->group(function () {
    Route::get('/events', 'index')->name('events.index');
    Route::get('/events/create', 'create')->name('events.create');
    Route::post('/events', 'store')->name('events.store');
    Route::get('/events/{id}', 'show')->name('events.show');
    Route::get('/events/{id}/edit', 'edit')->name('events.edit');
    Route::put('/events/{id}', 'update')->name('events.update');
    Route::delete('/events/{id}', 'destroy')->name('events.destroy');
});

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
    Route::get('/profile', 'index')->name('profile.index');
    Route::post('/profile/store', 'store')->name('profile.store');
});

// Notification Webhook (live update)
Route::post('/midtrans/notification', [MidtransNotificationController::class, 'handle']);

// Redirect setelah pembayaran
Route::get('/midtrans/finish',   [MidtransNotificationController::class, 'finish'])->name('midtrans.finish');
Route::get('/midtrans/unfinish', [MidtransNotificationController::class, 'unfinish'])->name('midtrans.unfinish');
Route::get('/midtrans/error',    [MidtransNotificationController::class, 'error'])->name('midtrans.error');

// ===================== KUESIONER (DASHBOARD) =====================
Route::middleware(['auth'])
    ->prefix('dashboard/kuesioner')
    ->name('dashboard.kuesioner.')
    ->group(function () {

        // 1) Halaman index: list semua event kuesioner
        Route::get('/', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'index'])
            ->name('index');

        // 2) CRUD Event Kuesioner
        Route::post('/create', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'store'])
            ->name('store');
        Route::post('/{eventId}/edit', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'update'])
            ->name('update');
        Route::post('/{eventId}/delete', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'destroy'])
            ->name('destroy');

        // 3) CRUD Pertanyaan Kuesioner
        Route::post('/{eventId}/pertanyaan', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'pertanyaanStore'])
            ->name('pertanyaan.store');
        Route::post('/{eventId}/pertanyaan/{pertanyaanId}/edit', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'pertanyaanUpdate'])
            ->name('pertanyaan.update');
        Route::post('/{eventId}/pertanyaan/{pertanyaanId}/delete', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'pertanyaanDestroy'])
            ->name('pertanyaan.destroy');
        Route::get('/{eventId}/pertanyaan-list', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'pertanyaanList'])
            ->name('pertanyaan.list');

        // 4) Download respon
        Route::get('/{eventId}/download-respon', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'downloadRespon'])
            ->name('downloadRespon');

        // 5) Respon Kuesioner
        Route::get('/{eventId}/respon/create', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'responCreate'])
            ->name('respon.create');
        Route::post('/{eventId}/respon', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'responStore'])
            ->name('respon.store');
        Route::get('/{eventId}/respon/{responId}', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'responShow'])
            ->name('respon.show');
        Route::get('/{eventId}/respon/{responId}/detail', [\App\Http\Controllers\Dashboard\KuesionerEventController::class, 'responDetail'])
            ->name('respon.detail');
    });
