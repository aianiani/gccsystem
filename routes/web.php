<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AnalyticsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Homepage route (visible to guests and authenticated users)
Route::get('/', function () {
    $announcements = \App\Models\Announcement::latest()->take(3)->get();
    $heroImages = \App\Models\HeroImage::where('is_active', true)->orderBy('order')->get();
    return view('home', compact('announcements', 'heroImages'));
})->name('home');

// Redirect legacy standalone auth pages to homepage which hosts modal login/signup.
Route::get('/login', function () {
    return redirect()->route('home', ['showLogin' => 1]);
})->name('login');

Route::get('/register', function () {
    return redirect()->route('home', ['showRegister' => 1]);
})->name('register');

// Public Announcements routes (viewable by guests)
Route::get('announcements', [App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements.index');
// Constrain the wildcard so it doesn't capture "create" or other non-ID paths
Route::get('announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'show'])
    ->whereNumber('announcement')
    ->name('announcements.show');

// Guest routes
Route::middleware('guest')->group(function () {
    // We only expose POST endpoints for login/register because authentication
    // is handled via the modal on the homepage. Remove standalone pages.
    Route::post('/login', [AuthController::class, 'login']);
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

    // (Announcements index/show are public above)

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/users-export', [UserController::class, 'export'])->name('users.export');
        // Bulk actions
        Route::post('/users/bulk-activate', [UserController::class, 'bulkActivate'])->name('users.bulk-activate');
        Route::post('/users/bulk-deactivate', [UserController::class, 'bulkDeactivate'])->name('users.bulk-deactivate');
        Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk-delete');
        Route::post('/users/bulk-role-change', [UserController::class, 'bulkRoleChange'])->name('users.bulk-role-change');
        Route::post('/users/verify-import-delete', [UserController::class, 'verifyImportDelete'])->name('users.verify-import-delete');
        Route::get('/activities', [DashboardController::class, 'activities'])->name('activities');


        // Registration Approval Routes
        Route::prefix('admin/registration-approvals')->name('admin.registration-approvals.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'index'])->name('index');
            Route::get('/statistics', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'statistics'])->name('statistics'); // Moved up to avoid conflict with {user}
            Route::post('/bulk-approve', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'bulkApprove'])->name('bulk-approve');
            Route::post('/bulk-reject', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'bulkReject'])->name('bulk-reject');
            Route::post('/verify-enrollment', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'verifyEnrollment'])->name('verify-enrollment');
            Route::get('/{user}', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'show'])->name('show');
            Route::post('/{user}/approve', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'approve'])->name('approve');
            Route::post('/{user}/reject', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'reject'])->name('reject');
        });

        // Hero Images Management
        Route::resource('admin/hero-images', App\Http\Controllers\Admin\HeroImageController::class, ['as' => 'admin']);
        // Only admins can create, edit, update, delete announcements
        Route::get('announcements/create', [App\Http\Controllers\AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('announcements', [App\Http\Controllers\AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('announcements/{announcement}/edit', [App\Http\Controllers\AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::delete('announcements/{announcement}/images/{index}', [App\Http\Controllers\AnnouncementController::class, 'deleteImage'])->name('announcements.deleteImage');
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
        Route::get('appointments/{id}/confirmation', [App\Http\Controllers\AppointmentController::class, 'confirmation'])->name('appointments.confirmation');
        Route::get('appointments/{id}/download-pdf', [App\Http\Controllers\AppointmentController::class, 'downloadPdf'])->name('appointments.downloadPdf');
        Route::get('/appointments/available-slots/{counselor}', [App\Http\Controllers\AppointmentController::class, 'availableSlots'])->name('appointments.availableSlots');
        // Accept/Decline rescheduled appointment
        Route::patch('appointments/{id}/accept-reschedule', [App\Http\Controllers\AppointmentController::class, 'acceptReschedule'])->name('appointments.acceptReschedule');
        Route::patch('appointments/{id}/decline-reschedule', [App\Http\Controllers\AppointmentController::class, 'declineReschedule'])->name('appointments.declineReschedule');
        Route::get('appointments/completed-with-notes', [App\Http\Controllers\AppointmentController::class, 'completedWithNotes'])->name('appointments.completedWithNotes');
        Route::get('appointments/{id}/feedback', [App\Http\Controllers\SessionFeedbackController::class, 'create'])->name('session-feedback.create');
        Route::post('appointments/{id}/feedback', [App\Http\Controllers\SessionFeedbackController::class, 'store'])->name('session-feedback.store');
        // Assessments route for students
        Route::get('assessments', [App\Http\Controllers\AssessmentController::class, 'index'])->name('assessments.index');
        Route::get('assessments/dass42', [App\Http\Controllers\AssessmentController::class, 'dass42Page'])->name('assessments.dass42');
        Route::post('assessments/dass42', [App\Http\Controllers\AssessmentController::class, 'submitDass42'])->name('assessments.dass42.submit');
        Route::post('assessments/grit', [App\Http\Controllers\AssessmentController::class, 'submitGrit'])->name('assessments.grit.submit');
        Route::post('assessments/neo', [App\Http\Controllers\AssessmentController::class, 'submitNeo'])->name('assessments.neo.submit');
        Route::post('assessments/wvi', [App\Http\Controllers\AssessmentController::class, 'submitWvi'])->name('assessments.wvi.submit');

        // Seminar Evaluation Routes
        Route::get('seminars', [App\Http\Controllers\Student\SeminarController::class, 'index'])->name('student.seminars.index');
        Route::get('seminars/{seminar}/evaluate', [App\Http\Controllers\Student\SeminarController::class, 'create'])->name('student.seminars.evaluate');
        Route::post('seminars/{seminar}/evaluate', [App\Http\Controllers\Student\SeminarController::class, 'store'])->name('student.seminars.store');

        // Consent routes
        Route::get('consent', [App\Http\Controllers\ConsentController::class, 'show'])->name('consent.show');
        Route::post('consent', [App\Http\Controllers\ConsentController::class, 'store'])->name('consent.store');
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
        Route::delete('counselor/appointments/bulk/completed', [App\Http\Controllers\CounselorDashboardController::class, 'deleteAllCompleted'])->name('counselor.appointments.bulk.deleteCompleted');
        Route::get('counselor/session-notes', [App\Http\Controllers\SessionNoteController::class, 'index'])->name('counselor.session_notes.index');
        Route::get('counselor/session-notes/{id}', [App\Http\Controllers\SessionNoteController::class, 'show'])->name('counselor.session_notes.show');
        Route::patch('counselor/session-notes/{id}/complete', [App\Http\Controllers\SessionNoteController::class, 'complete'])->name('counselor.session_notes.complete');
        Route::get('counselor/session-notes/{id}/edit', [App\Http\Controllers\SessionNoteController::class, 'edit'])->name('counselor.session_notes.edit');
        Route::patch('counselor/session-notes/{id}', [App\Http\Controllers\SessionNoteController::class, 'update'])->name('counselor.session_notes.update');
        Route::post('counselor/session-notes/{id}/remind', [App\Http\Controllers\SessionNoteController::class, 'remind'])->name('counselor.session_notes.remind');
        Route::post('counselor/session-notes/{id}/create-next-appointment', [App\Http\Controllers\SessionNoteController::class, 'createNextAppointment'])->name('counselor.session_notes.create_next_appointment');
        // Assessment results for counselors
        Route::get('counselor/assessments', [App\Http\Controllers\AssessmentController::class, 'counselorIndex'])->name('counselor.assessments.index');
        Route::get('/counselor/assessments/{assessment}', [App\Http\Controllers\AssessmentController::class, 'show'])->name('counselor.assessments.show');
    });

    // Notification routes - accessible to all authenticated users
    Route::get('notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
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
    Route::get('feedback', [App\Http\Controllers\SessionFeedbackController::class, 'index'])->name('counselor.feedback.index');
    Route::get('feedback/{id}', [App\Http\Controllers\SessionFeedbackController::class, 'show'])->name('counselor.feedback.show');
    Route::get('availability', [App\Http\Controllers\CounselorAvailabilityController::class, 'index'])->name('counselor.availability.index');
    Route::get('students', [App\Http\Controllers\CounselorStudentController::class, 'index'])->name('counselor.students.index');
    Route::get('students/{student}', [App\Http\Controllers\CounselorStudentController::class, 'show'])->name('counselor.students.show');
    Route::get('availabilities', [App\Http\Controllers\AvailabilityController::class, 'index']);
    Route::post('availabilities', [App\Http\Controllers\AvailabilityController::class, 'store']);
    Route::delete('availabilities', [App\Http\Controllers\AvailabilityController::class, 'destroy']);
    Route::get('counselor/session-notes/timeline/{studentId}', [App\Http\Controllers\SessionNoteController::class, 'timeline'])->name('counselor.session_notes.timeline');

    // Guidance Module Routes
    Route::get('guidance', [App\Http\Controllers\Counselor\GuidanceController::class, 'index'])->name('counselor.guidance.index');
    Route::get('guidance/bulk', [App\Http\Controllers\Counselor\BulkAttendanceController::class, 'create'])->name('counselor.guidance.bulk.create');
    Route::post('guidance/bulk', [App\Http\Controllers\Counselor\BulkAttendanceController::class, 'store'])->name('counselor.guidance.bulk.store');
    Route::post('guidance/import', [App\Http\Controllers\Counselor\BulkAttendanceController::class, 'import'])->name('counselor.guidance.import');
    Route::get('guidance/{student}', [App\Http\Controllers\Counselor\GuidanceController::class, 'show'])->name('counselor.guidance.show');
    Route::post('guidance/{student}/update', [App\Http\Controllers\Counselor\GuidanceController::class, 'update'])->name('counselor.guidance.update');
    Route::post('guidance/{student}/profile', [App\Http\Controllers\Counselor\GuidanceController::class, 'updateProfile'])->name('counselor.guidance.update_profile');

    // Seminar Management Routes
    Route::resource('seminars', App\Http\Controllers\Counselor\SeminarController::class)->names('counselor.seminars');
    Route::post('seminars/{seminar}/schedules', [App\Http\Controllers\Counselor\SeminarController::class, 'storeSchedule'])->name('counselor.seminars.schedules.store');
    Route::delete('seminars/schedules/{schedule}', [App\Http\Controllers\Counselor\SeminarController::class, 'destroySchedule'])->name('counselor.seminars.schedules.destroy');

    // Reports
    Route::get('guidance/reports', [App\Http\Controllers\Counselor\GuidanceReportController::class, 'index'])->name('counselor.guidance.reports.index');
    Route::post('guidance/reports/generate', [App\Http\Controllers\Counselor\GuidanceReportController::class, 'generate'])->name('counselor.guidance.reports.generate');
});

// TEST: Simple POST route to debug 404 issues
Route::post('test-post', function () {
    return 'It works!';
});

Route::middleware('admin')->get('test-admin', function () {
    return 'You are admin!';
});

Route::get('/counselor/assessments/{assessment}/export', [App\Http\Controllers\AssessmentController::class, 'exportPdf'])->name('counselor.assessments.export');
Route::post('/counselor/assessments/{assessment}/save-notes', [App\Http\Controllers\AssessmentController::class, 'saveNotes'])->name('counselor.assessments.saveNotes');

// Admin Reports
Route::middleware(['auth', 'admin'])->prefix('admin/reports')->name('admin.reports.')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminReportsController::class, 'index'])->name('index');
    Route::get('/export/{format}', [App\Http\Controllers\AdminReportsController::class, 'export'])->name('export');
});

// Admin Analytics
Route::middleware(['auth', 'admin'])->prefix('admin/analytics')->name('admin.analytics.')->group(function () {
    Route::get('/', [AnalyticsController::class, 'index'])->name('index');
});

// Temporary debug route - add at the end of the file
Route::get('/debug/notifications', function () {
    if (!auth()->check()) {
        return response()->json(['error' => 'Not authenticated']);
    }

    $user = auth()->user();
    $notifications = $user->notifications()->latest()->take(10)->get();

    return response()->json([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_role' => $user->role,
        'total_notifications' => $notifications->count(),
        'unread_count' => $user->unreadNotifications()->count(),
        'notifications_raw' => $notifications->map(function ($n) {
            return [
                'id' => $n->id,
                'type' => $n->type,
                'data' => $n->data,
                'read_at' => $n->read_at,
                'created_at' => $n->created_at,
            ];
        })
    ]);
});

// Test route to create a sample notification for students
Route::get('/debug/create-test-notification', function () {
    if (!auth()->check()) {
        return 'Please log in first';
    }

    $user = auth()->user();

    if ($user->role !== 'student') {
        return 'This route is only for students. Your role is: ' . $user->role;
    }

    // Create a fake appointment for testing
    $appointment = new \App\Models\Appointment();
    $appointment->id = 999; // Fake ID
    $appointment->scheduled_at = now()->addDays(2);

    // Send a test notification
    $user->notify(new \App\Notifications\AppointmentAcceptedNotification($appointment));

    return 'Test notification created! Go check your notification bell.';
});

