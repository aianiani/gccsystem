@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="fw-bold mb-1"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h1>
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
            <span class="fs-5">Welcome back, {{ auth()->user()->name }}!</span>
            <span class="text-muted">Today is <strong>{{ now()->format('l, F j, Y') }}</strong></span>
        </div>
    </div>
    <div class="mb-4 d-flex gap-3">
        <a href="{{ route('announcements.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-megaphone me-1"></i>Announcements
        </a>
        @if(auth()->user()->isStudent())
            <a href="{{ route('appointments.index') }}" class="btn btn-outline-success">
                <i class="bi bi-calendar-check me-1"></i>Appointments
            </a>
        @elseif(auth()->user()->isCounselor())
            <a href="{{ route('counselor.appointments.index') }}" class="btn btn-outline-success">
                <i class="bi bi-calendar-check me-1"></i>Appointments
            </a>
        @endif
    </div>
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="mb-4">
                <h4 class="mb-3"><i class="bi bi-megaphone me-2"></i>Recent Announcements</h4>
                @php
                    $recentAnnouncements = \App\Models\Announcement::with('user')->latest()->take(5)->get();
                @endphp
                @if($recentAnnouncements->count() > 0)
                    <ul class="list-group">
                        @foreach($recentAnnouncements as $announcement)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $announcement->title }}</strong>
                                    <div class="small text-muted">{{ $announcement->created_at->format('M d, Y') }}</div>
                                </div>
                                <a href="{{ route('announcements.show', $announcement->id) }}" class="btn btn-sm btn-outline-info">View</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-muted">No announcements at this time.</div>
                @endif
            </div>
            <div>
                <h4 class="mb-3"><i class="bi bi-activity me-2"></i>Your Recent Activities</h4>
                @php
                    $userActivities = \App\Models\UserActivity::where('user_id', auth()->id())->latest()->take(5)->get();
                @endphp
                @if($userActivities->count() > 0)
                    <ul class="list-group">
                        @foreach($userActivities as $activity)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ ucfirst($activity->action) }}</strong>
                                        <div class="small text-muted">{{ $activity->description }}</div>
                                    </div>
                                    <span class="text-muted small">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-muted">No recent activities.</div>
                @endif
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card p-4 text-center">
                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="rounded-circle mb-3" width="90" height="90">
                <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                <div class="text-muted mb-2">{{ auth()->user()->email }}</div>
                <div class="mb-2">
                    <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>
                    @if(auth()->user()->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </div>
                <a href="{{ route('profile') }}" class="btn btn-outline-secondary btn-sm mt-2">
                    <i class="bi bi-pencil me-1"></i>Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 