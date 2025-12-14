<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\ReservationApprovalController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\FacilityBrowseController;
use App\Http\Controllers\User\FacilityRatingController;
use App\Http\Controllers\User\ChatbotController;
use App\Http\Controllers\User\MapController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', LandingController::class)->name('landing');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth'])->group(function () {
    // Backward-compatible dashboard alias
    Route::get('/home', function (Request $request) {
        $user = $request->user();
        return redirect()->route($user->isAdmin() ? 'admin.dashboard' : 'user.dashboard');
    })->name('dashboard');

    // User Routes
    Route::prefix('dashboard')->name('user.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('reservations', ReservationController::class)
            ->except(['create', 'edit', 'show']);

        Route::get('calendar/events', [ReservationController::class, 'events'])
            ->name('calendar.events');

        Route::get('facilities', [FacilityBrowseController::class, 'index'])
            ->name('facilities.index');
        Route::post('facilities/{facility}/ratings', [FacilityRatingController::class, 'store'])
            ->name('facilities.ratings.store');

        Route::get('map', [MapController::class, 'index'])->name('map.index');

        Route::get('chat', [ChatbotController::class, 'index'])->name('chat.index');
        Route::post('chat/message', [ChatbotController::class, 'message'])->name('chat.message');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    });

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('facilities', FacilityController::class)->except(['create', 'edit', 'show']);

        Route::get('reservations/pending', [ReservationApprovalController::class, 'index'])
            ->name('reservations.pending');

        Route::get('reservations/calendar', [ReservationApprovalController::class, 'calendar'])
            ->name('reservations.calendar');

        Route::post('reservations/{id}/approve', [ReservationApprovalController::class, 'approve'])
            ->name('reservations.approve');

        Route::post('reservations/{id}/reject', [ReservationApprovalController::class, 'reject'])
            ->name('reservations.reject');

        Route::post('reservations/{id}/cancel', [ReservationApprovalController::class, 'cancel'])
            ->name('reservations.cancel');

        Route::get('calendar/events', [ReservationApprovalController::class, 'events'])
            ->name('calendar.events');

        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('analytics/facility-usage', [AnalyticsController::class, 'facilityUsage'])
            ->name('analytics.facility');
        Route::get('analytics/peak-hours', [AnalyticsController::class, 'peakHours'])
            ->name('analytics.peak');
    });
});

// Shared notifications endpoints for both user and admin contexts
Route::middleware('auth')->group(function () {
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/read', [NotificationController::class, 'markRead'])->name('notifications.read');
});
