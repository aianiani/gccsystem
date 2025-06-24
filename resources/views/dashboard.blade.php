@extends('layouts.app')

@section('content')
<div class="row mb-5">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="display-4 fw-bold mb-2" style="color:var(--text-primary)">
                    <i class="bi bi-speedometer2 me-3"></i>Dashboard
                </h1>
                <p class="fs-5 mb-0" style="color:var(--text-secondary)">Welcome back, {{ auth()->user()->name }}!</p>
            </div>
            <div class="text-end">
                <div class="text-muted">Today is</div>
                <div class="fw-semibold" style="color:var(--primary-color)">{{ now()->format('l, F j, Y') }}</div>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->isAdmin())
    {{-- Admin Dashboard --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 fade-in" style="background:rgba(99,102,241,0.07)">
                <div class="card-body text-center p-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-3 shadow" style="width: 70px; height: 70px;">
                        <i class="bi bi-people-fill fs-1 text-primary"></i>
                    </div>
                    <h2 class="fw-bold text-primary mb-2">{{ \App\Models\User::count() }}</h2>
                    <p class="text-secondary mb-3">Total Users</p>
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-people me-2"></i>Manage Users
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 fade-in" style="background:rgba(16,185,129,0.07)">
                <div class="card-body text-center p-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle mb-3 shadow" style="width: 70px; height: 70px;">
                        <i class="bi bi-person-check-fill fs-1 text-success"></i>
                    </div>
                    <h2 class="fw-bold text-success mb-2">{{ \App\Models\User::where('is_active', true)->count() }}</h2>
                    <p class="text-secondary mb-3">Active Users</p>
                    <div class="text-success small">
                        <i class="bi bi-arrow-up me-1"></i>Active accounts
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card h-100">
                <div class="card-body text-center p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-fill-check fs-2 text-warning"></i>
                    </div>
                    <h3 class="fw-bold text-warning mb-2">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
                    <p class="text-muted mb-3">Administrators</p>
                    <div class="text-warning small">
                        <i class="bi bi-shield me-1"></i>System admins
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card h-100">
                <div class="card-body text-center p-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-activity fs-2 text-info"></i>
                    </div>
                    <h3 class="fw-bold text-info mb-2">{{ \App\Models\UserActivity::count() }}</h3>
                    <p class="text-muted mb-3">Total Activities</p>
                    <a href="{{ route('activities') }}" class="btn btn-outline-info btn-sm w-100">
                        <i class="bi bi-activity me-2"></i>View Logs
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-activity me-2"></i>Recent User Activities
                    </h5>
                    <a href="{{ route('activities') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-arrow-right me-1"></i>View All
                    </a>
                </div>
                <div class="card-body p-0">
                    @php
                        $recentActivities = \App\Models\UserActivity::with('user')
                            ->latest()
                            ->take(8)
                            ->get();
                    @endphp
                    
                    @if($recentActivities->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentActivities as $activity)
                                <div class="list-group-item border-0 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            @if($activity->user)
                                                <img src="{{ $activity->user->avatar_url }}" alt="Avatar" class="rounded-circle" width="40" height="40">
                                            @else
                                                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person text-primary"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1 fw-semibold">{{ $activity->user->name }}</h6>
                                                    <p class="text-muted mb-0 small">{{ ucfirst($activity->action) }}: {{ $activity->description }}</p>
                                                    @if($activity->ip_address)
                                                        <small class="text-muted">IP: {{ $activity->ip_address }}</small>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-activity fs-1 text-muted"></i>
                            </div>
                            <h6 class="fw-semibold">No activities found</h6>
                            <p class="text-muted">No user activities have been recorded yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person me-2"></i>Your Profile
                    </h5>
                </div>
                <div class="card-body text-center p-4">
                    <div class="mb-4">
                        <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="rounded-circle" width="100" height="100">
                    </div>
                    <h5 class="fw-bold mb-2">{{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-danger fs-6 px-3 py-2">
                            <i class="bi bi-shield-fill me-1"></i>Administrator
                        </span>
                    </div>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i>Active
                        </span>
                    </div>
                    
                    <a href="{{ route('profile') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-pencil me-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

@else
    {{-- Regular User Dashboard --}}
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-activity me-2"></i>Your Recent Activities
                    </h5>
                    <span class="badge bg-primary">{{ \App\Models\UserActivity::where('user_id', auth()->id())->count() }} total</span>
                </div>
                <div class="card-body p-0">
                    @php
                        $userActivities = \App\Models\UserActivity::where('user_id', auth()->id())
                            ->latest()
                            ->take(8)
                            ->get();
                    @endphp
                    
                    @if($userActivities->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($userActivities as $activity)
                                <div class="list-group-item border-0 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle" style="width: 40px; height: 40px;">
                                                <i class="bi bi-check-circle text-success"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1 fw-semibold">{{ ucfirst($activity->action) }}</h6>
                                                    <p class="text-muted mb-0 small">{{ $activity->description }}</p>
                                                    @if($activity->ip_address)
                                                        <small class="text-muted">IP: {{ $activity->ip_address }}</small>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-activity fs-1 text-muted"></i>
                            </div>
                            <h6 class="fw-semibold">No activities found</h6>
                            <p class="text-muted">You haven't performed any actions yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person me-2"></i>Your Profile
                    </h5>
                </div>
                <div class="card-body text-center p-4">
                    <div class="mb-4">
                        <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="rounded-circle" width="100" height="100">
                    </div>
                    <h5 class="fw-bold mb-2">{{ auth()->user()->name }}</h5>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-secondary fs-6 px-3 py-2">
                            <i class="bi bi-person me-1"></i>Regular User
                        </span>
                    </div>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-{{ auth()->user()->isActive() ? 'success' : 'danger' }} fs-6 px-3 py-2">
                            <i class="bi bi-{{ auth()->user()->isActive() ? 'check-circle' : 'x-circle' }} me-1"></i>
                            {{ auth()->user()->isActive() ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="text-muted small mb-4">
                        <i class="bi bi-calendar me-1"></i>
                        Member since {{ auth()->user()->created_at->format('M d, Y') }}
                    </div>
                    
                    <a href="{{ route('profile') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-pencil me-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection 