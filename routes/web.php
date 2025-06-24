<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.auth');
    });
    Route::get('/login', function () {
        return view('auth.auth');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', function () {
        return view('auth.auth');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Email Verification Routes
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
Route::get('/email/verify/resend', [AuthController::class, 'showResendForm'])->name('verification.resend');
Route::post('/email/verify/resend', [AuthController::class, 'resend'])->name('verification.resend');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/activities', [DashboardController::class, 'activities'])->name('activities');
    });

    // Profile Management Routes
    Route::get('profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('profile/update', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('profile.password');
    Route::post('profile/avatar', [App\Http\Controllers\UserController::class, 'uploadAvatar'])->name('profile.avatar');
});

// Password Reset Routes
Route::get('password/reset', [App\Http\Controllers\AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\AuthController::class, 'reset'])->name('password.update');

// Two-Factor Authentication Routes
Route::get('2fa', [App\Http\Controllers\AuthController::class, 'showTwoFactorForm'])->name('2fa.form');
Route::post('2fa', [App\Http\Controllers\AuthController::class, 'verifyTwoFactorCode'])->name('2fa.verify');
