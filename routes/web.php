<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Homepage route for guests
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('home');
})->name('home');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', function () {
        return view('auth.register');
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
    
    // Announcements: allow all authenticated users to view
    Route::get('announcements', [App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'show'])->name('announcements.show');

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/activities', [DashboardController::class, 'activities'])->name('activities');
        // Only admins can create, edit, update, delete announcements
        Route::get('announcements/create', [App\Http\Controllers\AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('announcements', [App\Http\Controllers\AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('announcements/{announcement}/edit', [App\Http\Controllers\AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });

    // Profile Management Routes
    Route::get('profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('profile/update', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('profile.password');
    Route::post('profile/avatar', [App\Http\Controllers\UserController::class, 'uploadAvatar'])->name('profile.avatar');

    // Student-only routes
    Route::middleware('role:student')->group(function () {
        Route::get('appointments', [App\Http\Controllers\AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/create', [App\Http\Controllers\AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments', [App\Http\Controllers\AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/appointments/available-slots/{counselor}', [App\Http\Controllers\AppointmentController::class, 'availableSlots'])->name('appointments.availableSlots');
    });

    // Counselor-only routes
    Route::middleware('role:counselor')->group(function () {
        Route::get('counselor/appointments', [App\Http\Controllers\CounselorDashboardController::class, 'index'])->name('counselor.appointments.index');
        Route::get('counselor/appointments/{id}', [App\Http\Controllers\CounselorDashboardController::class, 'show'])->name('counselor.appointments.show');
        Route::get('counselor/appointments/{id}/session-notes/create', [App\Http\Controllers\SessionNoteController::class, 'create'])->name('counselor.session_notes.create');
        Route::post('counselor/appointments/{id}/session-notes', [App\Http\Controllers\SessionNoteController::class, 'store'])->name('counselor.session_notes.store');
    });
});

// Password Reset Routes
Route::get('password/reset', [App\Http\Controllers\AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\AuthController::class, 'reset'])->name('password.update');

// Two-Factor Authentication Routes
Route::get('2fa', [App\Http\Controllers\AuthController::class, 'showTwoFactorForm'])->name('2fa.form');
Route::post('2fa', [App\Http\Controllers\AuthController::class, 'verifyTwoFactorCode'])->name('2fa.verify');
Route::post('2fa/resend', [App\Http\Controllers\AuthController::class, 'resendTwoFactorCode'])->name('2fa.resend');

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

Route::get('/resources', function () {
    return view('resources');
})->name('resources');

Route::prefix('counselor')->middleware(['auth', 'role:counselor'])->group(function () {
    Route::resource('messages', App\Http\Controllers\Counselor\MessageController::class)
        ->names('counselor.messages')
        ->only(['index', 'show', 'create', 'store']);
    Route::resource('assessments', App\Http\Controllers\Counselor\AssessmentController::class)
        ->names('counselor.assessments')
        ->only(['index', 'show', 'create', 'store']);
    Route::get('priority-cases', [App\Http\Controllers\Counselor\PriorityCaseController::class, 'index'])
        ->name('counselor.priority-cases.index');
    Route::get('feedback', [App\Http\Controllers\Counselor\FeedbackController::class, 'index'])
        ->name('counselor.feedback.index');
    Route::resource('appointments', App\Http\Controllers\Counselor\AppointmentController::class)
        ->names('counselor.appointments');
    Route::get('availability', [App\Http\Controllers\CounselorAvailabilityController::class, 'index'])->name('counselor.availability.index');
    Route::get('availabilities', [App\Http\Controllers\AvailabilityController::class, 'index']);
    Route::post('availabilities', [App\Http\Controllers\AvailabilityController::class, 'store']);
});

