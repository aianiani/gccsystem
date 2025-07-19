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
    Route::get('announcements/create', [App\Http\Controllers\AnnouncementController::class, 'create'])->name('announcements.create');
    Route::get('announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'show'])->name('announcements.show');

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/activities', [DashboardController::class, 'activities'])->name('activities');
        Route::get('/admin/logs', function () {
    return view('admin.logs');
})->name('admin.logs');

// Individual log sections
Route::get('/admin/logs/users', function () {
    return view('admin.logs.users');
})->name('admin.logs.users');

Route::get('/admin/logs/appointments', function () {
    return view('admin.logs.appointments');
})->name('admin.logs.appointments');

Route::get('/admin/logs/session-notes', function () {
    return view('admin.logs.session-notes');
})->name('admin.logs.session-notes');

Route::get('/admin/logs/session-feedbacks', function () {
    return view('admin.logs.session-feedbacks');
})->name('admin.logs.session-feedbacks');

Route::get('/admin/logs/assessments', function () {
    return view('admin.logs.assessments');
})->name('admin.logs.assessments');

Route::get('/admin/logs/messages', function () {
    return view('admin.logs.messages');
})->name('admin.logs.messages');

Route::get('/admin/logs/activities', function () {
    return view('admin.logs.activities');
})->name('admin.logs.activities');

// Registration Approval Routes
Route::prefix('admin/registration-approvals')->name('admin.registration-approvals.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'index'])->name('index');
    Route::get('/{user}', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'show'])->name('show');
    Route::post('/{user}/approve', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'approve'])->name('approve');
    Route::post('/{user}/reject', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'reject'])->name('reject');
    Route::get('/statistics', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'statistics'])->name('statistics');
});
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
        // Accept/Decline rescheduled appointment
        Route::patch('appointments/{id}/accept-reschedule', [App\Http\Controllers\AppointmentController::class, 'acceptReschedule'])->name('appointments.acceptReschedule');
Route::patch('appointments/{id}/decline-reschedule', [App\Http\Controllers\AppointmentController::class, 'declineReschedule'])->name('appointments.declineReschedule');
Route::get('appointments/completed-with-notes', [App\Http\Controllers\AppointmentController::class, 'completedWithNotes'])->name('appointments.completedWithNotes');
Route::get('appointments/{id}/feedback', [App\Http\Controllers\SessionFeedbackController::class, 'create'])->name('session-feedback.create');
Route::post('appointments/{id}/feedback', [App\Http\Controllers\SessionFeedbackController::class, 'store'])->name('session-feedback.store');
        // Assessments route for students
        Route::get('assessments', [App\Http\Controllers\AssessmentController::class, 'index'])->name('assessments.index');
        Route::post('assessments/dass21', [App\Http\Controllers\AssessmentController::class, 'submitDass21'])->name('assessments.dass21.submit');
        Route::post('assessments/academic', [App\Http\Controllers\AssessmentController::class, 'submitAcademicSurvey'])->name('assessments.academic.submit');
        Route::post('assessments/wellness', [App\Http\Controllers\AssessmentController::class, 'submitWellnessCheck'])->name('assessments.wellness.submit');
    });

    // Counselor and Admin routes
    Route::middleware('role:counselor,admin')->group(function () {
        Route::get('counselor/appointments', [App\Http\Controllers\CounselorDashboardController::class, 'index'])->name('counselor.appointments.index');
        Route::get('counselor/appointments/{id}', [App\Http\Controllers\CounselorDashboardController::class, 'show'])->name('counselor.appointments.show');
        Route::get('counselor/appointments/create', [App\Http\Controllers\AppointmentController::class, 'create'])->name('counselor.appointments.create');
        Route::get('counselor/appointments/{id}/edit', [App\Http\Controllers\AppointmentController::class, 'edit'])->name('counselor.appointments.edit');
        Route::get('counselor/appointments/{id}/reschedule', [App\Http\Controllers\AppointmentController::class, 'edit'])->name('counselor.appointments.reschedule');
        Route::get('counselor/appointments/{id}/session-notes/create', [App\Http\Controllers\SessionNoteController::class, 'create'])->name('counselor.session_notes.create');
        Route::post('counselor/appointments/{id}/session-notes', [App\Http\Controllers\SessionNoteController::class, 'store'])->name('counselor.session_notes.store');
        Route::patch('counselor/appointments/{id}/complete', [App\Http\Controllers\AppointmentController::class, 'complete'])->name('counselor.appointments.complete');
        Route::delete('counselor/appointments/{id}/cancel', [App\Http\Controllers\AppointmentController::class, 'cancel'])->name('counselor.appointments.cancel');
        Route::patch('counselor/appointments/{id}', [App\Http\Controllers\AppointmentController::class, 'update'])->name('counselor.appointments.update');
        Route::patch('counselor/appointments/{id}/accept', [App\Http\Controllers\AppointmentController::class, 'accept'])->name('counselor.appointments.accept');
        Route::patch('counselor/appointments/{id}/decline', [App\Http\Controllers\AppointmentController::class, 'decline'])->name('counselor.appointments.decline');
        Route::delete('counselor/appointments/{id}', [App\Http\Controllers\AppointmentController::class, 'destroy'])->name('counselor.appointments.destroy');
        Route::get('counselor/session-notes', [App\Http\Controllers\SessionNoteController::class, 'index'])->name('counselor.session_notes.index');
        Route::get('counselor/session-notes/{id}', [App\Http\Controllers\SessionNoteController::class, 'show'])->name('counselor.session_notes.show');
        Route::patch('counselor/session-notes/{id}/complete', [App\Http\Controllers\SessionNoteController::class, 'complete'])->name('counselor.session_notes.complete');
        Route::get('counselor/session-notes/{id}/edit', [App\Http\Controllers\SessionNoteController::class, 'edit'])->name('counselor.session_notes.edit');
        Route::patch('counselor/session-notes/{id}', [App\Http\Controllers\SessionNoteController::class, 'update'])->name('counselor.session_notes.update');
        Route::post('counselor/session-notes/{id}/remind', [App\Http\Controllers\SessionNoteController::class, 'remind'])->name('counselor.session_notes.remind');
        Route::post('counselor/session-notes/{id}/create-next-appointment', [App\Http\Controllers\SessionNoteController::class, 'createNextAppointment'])->name('counselor.session_notes.create_next_appointment');
        // Mark notification as read
        Route::post('notifications/{id}/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        // Assessment results for counselors
        Route::get('counselor/assessments', [App\Http\Controllers\AssessmentController::class, 'counselorIndex'])->name('counselor.assessments.index');
        Route::get('/counselor/assessments/{assessment}', [App\Http\Controllers\AssessmentController::class, 'show'])->name('counselor.assessments.show');
    });

    Route::get('notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
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

Route::middleware(['auth'])->group(function () {
    // Place these FIRST!
    Route::get('/chat/counselors', [App\Http\Controllers\MessageController::class, 'selectCounselor'])->name('chat.selectCounselor');
    Route::get('/chat/students', [App\Http\Controllers\MessageController::class, 'selectStudent'])->name('chat.selectStudent');
    // Then the dynamic user chat routes
    Route::get('/chat/{user}', [App\Http\Controllers\MessageController::class, 'index'])->name('chat.index');
    Route::post('/chat/{user}', [App\Http\Controllers\MessageController::class, 'store'])->name('chat.store');
    Route::get('/chat/{user}/fetch', [App\Http\Controllers\MessageController::class, 'fetch'])->name('chat.fetch');
    Route::get('/chat/{user}/messages', [App\Http\Controllers\MessageController::class, 'messages'])->name('chat.messages');
});

Route::prefix('counselor')->middleware(['auth', 'role:counselor'])->group(function () {
    // Route::resource('messages', App\Http\Controllers\Counselor\MessageController::class)
    //     ->names('counselor.messages')
    //     ->only(['index', 'show', 'create', 'store']);
    // Route::resource('assessments', App\Http\Controllers\Counselor\AssessmentController::class)
    //     ->names('counselor.assessments')
    //     ->only(['index', 'show', 'create', 'store']);
    // Route::get('priority-cases', [App\Http\Controllers\Counselor\PriorityCaseController::class, 'index'])
    //     ->name('counselor.priority-cases.index');
    // Route::get('feedback', [App\Http\Controllers\Counselor\FeedbackController::class, 'index'])
//     ->name('counselor.feedback.index');
Route::get('feedback/{id}', [App\Http\Controllers\SessionFeedbackController::class, 'show'])->name('counselor.feedback.show');
    Route::get('availability', [App\Http\Controllers\CounselorAvailabilityController::class, 'index'])->name('counselor.availability.index');
    Route::get('availabilities', [App\Http\Controllers\AvailabilityController::class, 'index']);
    Route::post('availabilities', [App\Http\Controllers\AvailabilityController::class, 'store']);
    Route::delete('availabilities', [App\Http\Controllers\AvailabilityController::class, 'destroy']);
    Route::get('counselor/session-notes/timeline/{studentId}', [App\Http\Controllers\SessionNoteController::class, 'timeline'])->name('counselor.session_notes.timeline');
});

// TEST: Simple POST route to debug 404 issues
Route::post('test-post', function() { return 'It works!'; });

Route::middleware('admin')->get('test-admin', function() {
    return 'You are admin!';
});

Route::get('/counselor/assessments/{assessment}/export', [App\Http\Controllers\AssessmentController::class, 'exportPdf'])->name('counselor.assessments.export');
Route::post('/counselor/assessments/{assessment}/save-notes', [App\Http\Controllers\AssessmentController::class, 'saveNotes'])->name('counselor.assessments.saveNotes');

// Admin Logs Export & Reset
Route::middleware(['auth', 'admin'])->prefix('admin/logs')->name('admin.logs.')->group(function () {
    Route::get('export/{format}', [App\Http\Controllers\AdminLogsController::class, 'export'])->name('export');
    Route::post('reset', [App\Http\Controllers\AdminLogsController::class, 'reset'])->name('reset');
});

Route::post('admin/logs/{type}/reset', [AdminLogsController::class, 'reset'])->name('admin.logs.reset');

