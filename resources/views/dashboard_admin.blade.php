@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="fw-bold mb-1" style="color: var(--primary);"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</h1>
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
            <span class="fs-5">Welcome, <span style="color: var(--accent);">{{ auth()->user()->name }}</span>!</span>
            <span class="text-muted">Today is <strong>{{ now()->format('l, F j, Y') }}</strong></span>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card p-4 text-center shadow-sm">
                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="rounded-circle mb-3 border border-3" width="90" height="90" style="border-color: var(--accent);">
                <h5 class="fw-bold mb-1" style="color: var(--primary);">{{ auth()->user()->name }}</h5>
                <div class="text-muted mb-2">{{ auth()->user()->email }}</div>
                <div class="mb-2">
                    <span class="badge" style="background: var(--primary); color: #fff;">Admin</span>
                </div>
                <a href="{{ route('profile') }}" class="btn btn-outline-secondary btn-sm mt-2">
                    <i class="bi bi-pencil me-1"></i>Edit Profile
                </a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row g-3 mb-3">
                <div class="col-6 col-lg-4">
                    <a href="{{ route('users.index') }}" class="btn btn-accent w-100 py-3 shadow-sm"><i class="bi bi-people me-2"></i>Manage Users</a>
                </div>
                <div class="col-6 col-lg-4">
                    <a href="{{ route('announcements.index') }}" class="btn btn-primary w-100 py-3 shadow-sm"><i class="bi bi-megaphone me-2"></i>Manage Announcements</a>
                </div>
                <div class="col-12 col-lg-4 mt-2 mt-lg-0">
                    <a href="{{ route('activities') }}" class="btn btn-outline-secondary w-100 py-3 shadow-sm"><i class="bi bi-activity me-2"></i>Activity Logs</a>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-6 col-lg-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <div class="fs-2 fw-bold" style="color: var(--primary);">{{ \App\Models\User::count() }}</div>
                            <div class="text-muted">Total Users</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <div class="fs-2 fw-bold" style="color: var(--primary);">{{ \App\Models\Appointment::count() }}</div>
                            <div class="text-muted">Total Appointments</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <div class="fs-2 fw-bold" style="color: var(--primary);">{{ \App\Models\Announcement::count() }}</div>
                            <div class="text-muted">Total Announcements</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-white" style="background: var(--primary-light) !important; color: var(--primary) !important;">
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