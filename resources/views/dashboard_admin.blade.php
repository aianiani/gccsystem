@extends('layouts.app')

@section('content')
<style>
    :root {
        --forest-green: #2d5016;
        --forest-green-light: #4a7c59;
        --forest-green-lighter: #e8f5e8;
        --yellow-maize: #f4d03f;
        --yellow-maize-light: #fef9e7;
        --white: #ffffff;
        --gray-50: #f8f9fa;
        --gray-100: #f1f3f4;
        --gray-600: #6c757d;
        --danger: #dc3545;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .admin-header {
        background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
        color: white;
        border-radius: 16px;
        padding: 2rem 2rem 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
    }
    .admin-header .title {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 0;
    }
    .admin-header .badge {
        font-size: 1.1rem;
        padding: 0.7em 1.2em;
        border-radius: 999px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(44,62,80,0.08);
        background: var(--yellow-maize);
        color: var(--forest-green);
    }
    .admin-profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
    }
    .admin-profile-card img {
        border: 3px solid var(--yellow-maize);
        box-shadow: 0 2px 8px rgba(244, 208, 63, 0.08);
    }
    .admin-stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        transition: all 0.3s ease;
        height: 100%;
        text-align: center;
    }
    .admin-stats-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .admin-action-btn {
        background: var(--yellow-maize);
        color: var(--forest-green);
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .admin-action-btn:hover {
        background: #f1c40f;
        color: var(--forest-green);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }
    .admin-action-btn.primary {
        background: var(--forest-green);
        color: white;
    }
    .admin-action-btn.primary:hover {
        background: var(--forest-green-light);
        color: white;
    }
    .admin-action-btn.outline {
        background: white;
        color: var(--forest-green);
        border: 2px solid var(--forest-green);
    }
    .admin-action-btn.outline:hover {
        background: var(--forest-green-light);
        color: white;
    }
    .admin-activity-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        margin-top: 2rem;
    }
    .admin-activity-card .card-header {
        background: var(--forest-green-lighter) !important;
        color: var(--forest-green) !important;
        border-radius: 16px 16px 0 0 !important;
        font-weight: 600;
        font-size: 1.1rem;
        padding: 1.5rem 2rem;
    }
    .admin-activity-card .card-body {
        padding: 2rem;
    }
    @media (max-width: 991.98px) {
        .admin-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1.25rem 1rem;
        }
        .admin-header .title { font-size: 1.3rem; }
        .admin-header .badge { font-size: 1rem; padding: 0.5em 0.9em; }
    }
    @media (max-width: 575.98px) {
        .admin-action-btn { padding: 0.8rem 1rem; }
        .admin-stats-card { padding: 1rem; }
        .admin-activity-card .card-header { padding: 1rem; }
        .admin-activity-card .card-body { padding: 1rem; }
    }
</style>
<div class="container py-4">
    <div class="admin-header mb-4">
        <div class="title">
            <i class="bi bi-speedometer2 fs-2"></i>
            Admin Dashboard
        </div>
        <span class="badge">Welcome, {{ auth()->user()->name }}!</span>
        <span class="text-white">Today is <strong>{{ now()->format('l, F j, Y') }}</strong></span>
    </div>
    <div class="row g-4 mb-4 align-items-stretch">
        <div class="col-12">
            <div class="row g-3 mb-3 align-items-stretch">
                <div class="col-6 col-lg-3 d-flex">
                    <a href="{{ route('users.index') }}" class="admin-action-btn w-100 primary align-self-stretch d-flex align-items-center justify-content-center"><i class="bi bi-people me-2"></i>Manage Users</a>
                </div>
                <div class="col-6 col-lg-3 d-flex">
                    <a href="{{ route('announcements.index') }}" class="admin-action-btn w-100 align-self-stretch d-flex align-items-center justify-content-center"><i class="bi bi-megaphone me-2"></i>Manage Announcements</a>
                </div>
                <div class="col-6 col-lg-3 d-flex">
                    <a href="{{ route('activities') }}" class="admin-action-btn w-100 outline align-self-stretch d-flex align-items-center justify-content-center"><i class="bi bi-activity me-2"></i>Activity Logs</a>
                </div>
                <div class="col-6 col-lg-3 d-flex">
                    <a href="{{ route('admin.logs') }}" class="admin-action-btn w-100 outline align-self-stretch d-flex align-items-center justify-content-center"><i class="bi bi-journal-text me-2"></i>View All Logs</a>
                </div>
            </div>
            <div class="row g-3 align-items-stretch">
                <div class="col-6 col-lg-3 d-flex">
                    <div class="admin-stats-card w-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="fs-2 fw-bold" style="color: var(--forest-green);">{{ \App\Models\User::count() }}</div>
                        <div class="text-muted">Total Users</div>
                        <div class="small text-muted mt-1">
                            {{ \App\Models\User::where('role', 'student')->count() }} Students • 
                            {{ \App\Models\User::where('role', 'counselor')->count() }} Counselors
                        </div>
                        <a href="{{ route('admin.logs.users') }}" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-arrow-right me-1"></i>View All Users
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 d-flex">
                    <div class="admin-stats-card w-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="fs-2 fw-bold" style="color: var(--forest-green);">{{ \App\Models\Appointment::count() }}</div>
                        <div class="text-muted">Total Appointments</div>
                        <div class="small text-muted mt-1">
                            {{ \App\Models\Appointment::where('status', 'pending')->count() }} Pending • 
                            {{ \App\Models\Appointment::where('status', 'completed')->count() }} Completed
                        </div>
                        <a href="{{ route('admin.logs.appointments') }}" class="btn btn-sm btn-outline-success mt-2">
                            <i class="bi bi-arrow-right me-1"></i>View All Appointments
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 d-flex">
                    <div class="admin-stats-card w-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="fs-2 fw-bold" style="color: var(--forest-green);">{{ \App\Models\Assessment::count() }}</div>
                        <div class="text-muted">Total Assessments</div>
                        <div class="small text-muted mt-1">
                            {{ \App\Models\Assessment::where('status', 'completed')->count() }} Completed • 
                            {{ \App\Models\Assessment::where('status', 'pending')->count() }} Pending
                        </div>
                        <a href="{{ route('admin.logs.assessments') }}" class="btn btn-sm btn-outline-danger mt-2">
                            <i class="bi bi-arrow-right me-1"></i>View All Assessments
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 d-flex">
                    <div class="admin-stats-card w-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="fs-2 fw-bold" style="color: var(--forest-green);">{{ \App\Models\Announcement::count() }}</div>
                        <div class="text-muted">Total Announcements</div>
                        <div class="small text-muted mt-1">
                            {{ \App\Models\Announcement::where('is_active', true)->count() }} Active • 
                            {{ \App\Models\Announcement::where('is_active', false)->count() }} Inactive
                        </div>
                        <a href="{{ route('announcements.index') }}" class="btn btn-sm btn-outline-warning mt-2">
                            <i class="bi bi-arrow-right me-1"></i>Manage Announcements
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Additional Stats Row -->
            <div class="row g-3 align-items-stretch mt-3">
                <div class="col-6 col-lg-3 d-flex">
                    <div class="admin-stats-card w-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="fs-2 fw-bold" style="color: var(--forest-green);">{{ \App\Models\SessionNote::count() }}</div>
                        <div class="text-muted">Session Notes</div>
                        <div class="small text-muted mt-1">
                            {{ \App\Models\SessionNote::where('created_at', '>=', now()->subDays(30))->count() }} This Month
                        </div>
                        <a href="{{ route('admin.logs.session-notes') }}" class="btn btn-sm btn-outline-info mt-2">
                            <i class="bi bi-arrow-right me-1"></i>View Session Notes
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 d-flex">
                    <div class="admin-stats-card w-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="fs-2 fw-bold" style="color: var(--forest-green);">{{ \App\Models\SessionFeedback::count() }}</div>
                        <div class="text-muted">Session Feedbacks Logs</div>
                        <div class="small text-muted mt-1">
                            {{ \App\Models\SessionFeedback::where('created_at', '>=', now()->subDays(30))->count() }} This Month
                        </div>
                        <a href="{{ route('admin.logs.session-feedbacks') }}" class="btn btn-sm btn-outline-warning mt-2">
                            <i class="bi bi-arrow-right me-1"></i>View Session Feedbacks
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 d-flex">
                    <div class="admin-stats-card w-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="fs-2 fw-bold" style="color: var(--forest-green);">{{ \App\Models\UserActivity::count() }}</div>
                        <div class="text-muted">System Activities</div>
                        <div class="small text-muted mt-1">
                            {{ \App\Models\UserActivity::where('created_at', '>=', now()->subDays(7))->count() }} This Week
                        </div>
                        <a href="{{ route('activities') }}" class="btn btn-sm btn-outline-dark mt-2">
                            <i class="bi bi-arrow-right me-1"></i>View Activities
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3 d-flex">
                    <div class="admin-stats-card w-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="fs-2 fw-bold" style="color: var(--forest-green);">{{ \App\Models\User::where('is_active', true)->count() }}</div>
                        <div class="text-muted">Active Users</div>
                        <div class="small text-muted mt-1">
                            {{ round((\App\Models\User::where('is_active', true)->count() / \App\Models\User::count()) * 100) }}% of Total
                        </div>
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-arrow-right me-1"></i>View Active Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <div class="admin-activity-card card shadow-sm mt-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-activity me-2"></i>Recent Activity</h5>
        </div>
        <div class="card-body">
            @php $userActivities = \App\Models\UserActivity::where('user_id', auth()->id())->latest()->take(5)->get(); @endphp
            @if($userActivities->count())
                <ul class="list-group list-group-flush">
                    @foreach($userActivities as $activity)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ ucfirst($activity->action) }} - {{ $activity->description }}</span>
                            <span class="text-muted small">{{ $activity->created_at->diffForHumans() }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-muted">No recent activities.</div>
            @endif
        </div>
    </div>
</div>
@endsection 