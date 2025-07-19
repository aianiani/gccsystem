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
        --warning: #ffc107;
        --success: #28a745;
        --info: #17a2b8;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 250px;
        background: #2d5016;
        color: #fff;
        z-index: 1040;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 8px rgba(0,0,0,0.04);
        overflow-y: auto; /* Make sidebar scrollable */
    }
    .sidebar-header {
        text-align: center;
        padding: 2rem 1rem 1rem 1rem;
        border-bottom: 1px solid #4a7c59;
    }
    .sidebar-header img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-bottom: 0.5rem;
    }
    .sidebar-header h3 {
        margin: 0.5rem 0 0.25rem 0;
        font-size: 1.3rem;
        font-weight: 700;
        color: #f4d03f;
    }
    .sidebar-header p {
        margin: 0;
        font-size: 0.95rem;
        color: #fff;
        opacity: 0.7;
    }
    .sidebar-menu {
        flex: 1;
        padding: 1.5rem 0.5rem 0 0.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .menu-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.2s, color 0.2s;
        position: relative;
    }
    .menu-item.active, .menu-item:hover {
        background: #4a7c59;
        color: #f4d03f;
    }
    .menu-category {
        margin: 1.5rem 0 0.5rem 1rem;
        font-size: 0.85rem;
        color: #f4d03f;
        font-weight: 600;
        opacity: 0.8;
    }
    .appointment-count {
        background: #f4d03f;
        color: #2d5016;
        border-radius: 12px;
        padding: 0.1rem 0.6rem;
        font-size: 0.8rem;
        font-weight: 700;
        margin-left: auto;
    }
    #logoutButton {
        margin-top: 2rem;
        background: #dc3545;
        color: #fff;
        border-radius: 8px;
        text-align: center;
        padding: 0.75rem 1rem;
        font-weight: 600;
        transition: background 0.2s;
    }
    #logoutButton:hover {
        background: #b52a37;
        color: #fff;
    }
    @media (max-width: 991.98px) {
        .sidebar {
            width: 200px;
        }
        .main-content {
            margin-left: 200px;
        }
    }
    @media (max-width: 767.98px) {
        .sidebar {
            position: static;
            width: 100%;
            height: auto;
            flex-direction: row;
            padding: 0.5rem 0;
        }
        .sidebar-header, .menu-category {
            display: none;
        }
        .sidebar-menu {
            flex-direction: row;
            gap: 0.25rem;
            padding: 0;
        }
        .menu-item {
            flex: 1;
            justify-content: center;
            padding: 0.5rem 0.25rem;
            font-size: 0.95rem;
        }
        .main-content {
            margin-left: 0;
        }
    }
    .main-content {
        margin-left: 250px;
        transition: margin-left 0.2s;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
        color: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
    }

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        transition: all 0.3s ease;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stats-card.priority {
        border-left: 4px solid var(--danger);
    }

    .stats-card.warning {
        border-left: 4px solid var(--warning);
    }

    .stats-card.success {
        border-left: 4px solid var(--success);
    }

    .stats-card.info {
        border-left: 4px solid var(--info);
    }

    .profile-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        height: fit-content;
    }

    .action-btn {
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
    }

    .action-btn:hover {
        background: #f1c40f;
        color: var(--forest-green);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .action-btn.primary {
        background: var(--forest-green);
        color: white;
    }

    .action-btn.primary:hover {
        background: var(--forest-green-light);
        color: white;
    }

    .action-btn.danger {
        background: var(--danger);
        color: white;
    }

    .action-btn.danger:hover {
        background: #c82333;
        color: white;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        overflow: hidden;
    }

    .info-card-header {
        background: var(--forest-green-lighter);
        color: var(--forest-green);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-100);
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .info-card-body {
        padding: 1.5rem;
    }

    .student-item {
        background: var(--gray-50);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 1px solid var(--gray-100);
        transition: all 0.2s ease;
    }

    .student-item:hover {
        background: var(--yellow-maize-light);
        border-color: var(--yellow-maize);
    }

    .student-item.high-risk {
        border-left: 4px solid var(--danger);
        background: #fff5f5;
    }

    .student-item.moderate-risk {
        border-left: 4px solid var(--warning);
        background: #fffbf0;
    }

    .student-item:last-child {
        margin-bottom: 0;
    }

    .activity-item {
        background: var(--gray-50);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border-left: 4px solid var(--forest-green);
        transition: all 0.2s ease;
    }

    .activity-item:hover {
        background: var(--forest-green-lighter);
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

    .appointment-item {
        background: var(--gray-50);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 1px solid var(--gray-100);
        transition: all 0.2s ease;
    }

    .appointment-item:hover {
        background: var(--forest-green-lighter);
    }

    .appointment-item.urgent {
        border-left: 4px solid var(--danger);
    }

    .appointment-item.upcoming {
        border-left: 4px solid var(--success);
    }

    .message-item {
        background: var(--gray-50);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 1px solid var(--gray-100);
        transition: all 0.2s ease;
    }

    .message-item.unread {
        background: var(--yellow-maize-light);
        border-color: var(--yellow-maize);
    }

    .message-item:hover {
        background: var(--forest-green-lighter);
    }

    .badge-counselor {
        background: var(--forest-green);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .badge-priority {
        background: var(--danger);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-moderate {
        background: var(--warning);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-normal {
        background: var(--success);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .btn-view {
        background: var(--forest-green);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-view:hover {
        background: var(--forest-green-light);
        color: white;
    }

    .btn-edit {
        background: var(--yellow-maize);
        color: var(--forest-green);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .btn-edit:hover {
        background: #f1c40f;
        color: var(--forest-green);
    }

    .btn-small {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
    }

    .welcome-text {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        font-weight: 300;
    }

    .date-text {
        opacity: 0.9;
        font-size: 1rem;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--gray-600);
        background: var(--gray-50);
        border-radius: 12px;
        border: 2px dashed var(--gray-100);
    }

    .empty-state i {
        font-size: 2rem;
        color: var(--gray-600);
        margin-bottom: 1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .notification-dot {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 16px;
        height: 16px;
        background: var(--danger);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        color: white;
        font-weight: bold;
    }

    .risk-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }

    .risk-high { background: var(--danger); }
    .risk-moderate { background: var(--warning); }
    .risk-low { background: var(--success); }

    @media (max-width: 768px) {
        .quick-actions {
            grid-template-columns: 1fr;
        }
        
        .dashboard-header {
            padding: 1.5rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Notification Bell Dropdown at Top Right -->
<style>
    .notification-bell {
        background: transparent;
        border: none;
        outline: none;
        box-shadow: none;
        position: relative;
        transition: color 0.2s;
    }
    .notification-bell .bi-bell {
        color: var(--forest-green);
        font-size: 2.2rem;
        transition: color 0.2s;
    }
    .notification-bell.pulse .bi-bell {
        animation: bell-pulse 1.2s infinite;
    }
    .notification-bell:hover .bi-bell {
        color: var(--yellow-maize);
    }
    @keyframes bell-pulse {
        0% { filter: drop-shadow(0 0 0 var(--yellow-maize)); }
        70% { filter: drop-shadow(0 0 8px var(--yellow-maize)); }
        100% { filter: drop-shadow(0 0 0 var(--yellow-maize)); }
    }
    .notification-bell-badge {
        background: var(--yellow-maize);
        color: var(--forest-green);
        font-weight: bold;
        font-size: 0.9rem;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(244, 208, 63, 0.25);
        padding: 0.2em 0.7em;
        border-radius: 999px;
        top: 0;
        right: 0;
    }
    .notification-dropdown-menu {
        min-width: 340px;
        max-width: 95vw;
        border-radius: 16px;
        box-shadow: 0 1px 3px var(--shadow-sm), 0 20px 40px var(--shadow-md), 0 0 0 1px rgba(0,0,0,0.02);
        border: none;
        padding: 0.5rem 0;
        margin-top: 0.5rem;
        background: var(--gray-100);
    }
    .notification-dropdown-header {
        background: var(--forest-green-lighter);
        color: var(--forest-green);
        font-weight: 700;
        border-radius: 16px 16px 0 0;
        padding: 1rem 1.5rem;
        font-size: 1.08rem;
        border-bottom: 1px solid var(--gray-100);
        font-family: inherit;
    }
    .notification-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        background: transparent;
        transition: background 0.18s;
        border-bottom: 1px solid var(--gray-50);
        font-family: inherit;
    }
    .notification-item:last-child {
        border-bottom: none;
    }
    .notification-item:hover {
        background: var(--yellow-maize-light);
    }
    .notification-item .btn-link {
        color: var(--danger);
        font-size: 1.1rem;
        margin-left: 0.5rem;
    }
    .notification-empty {
        padding: 1.2rem 1.5rem;
        color: var(--gray-600);
        text-align: center;
        font-size: 1rem;
        font-family: inherit;
    }
    @media (max-width: 500px) {
        .notification-dropdown-menu {
            min-width: 90vw;
            padding: 0.25rem 0;
        }
        .notification-dropdown-header {
            font-size: 1rem;
            padding: 0.7rem 1rem;
        }
        .notification-item, .notification-empty {
            padding: 0.7rem 1rem;
        }
    }
</style>
@php
    $unreadCount = auth()->user()->unreadNotifications()->count();
    $recentNotifications = auth()->user()->unreadNotifications()->take(5)->get();
@endphp
<div class="dropdown me-3" style="position: fixed; top: 1.5rem; right: 2.5rem; z-index: 2000;">
    <button class="btn notification-bell position-relative p-0{{ $unreadCount > 0 ? ' pulse' : '' }}" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell fs-4" style="color: var(--yellow-maize);"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge notification-bell-badge" style="background: var(--yellow-maize); color: var(--forest-green); font-weight: bold; font-size: 0.85rem; border: 2px solid #fff;">
                {{ $unreadCount }}
            </span>
        @endif
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown" style="min-width: 320px;">
        <li class="dropdown-header fw-bold">Notifications</li>
        @forelse($recentNotifications as $notification)
            <li class="px-3 py-2 border-bottom small d-flex align-items-center gap-2">
                @if(isset($notification->data['appointment_id']))
                    <i class="bi bi-calendar-event text-primary"></i>
                @else
                    <i class="bi bi-info-circle text-info"></i>
                @endif
                <div class="flex-grow-1">
                    {{ $notification->data['message'] ?? 'You have a new notification.' }}
                    @if(isset($notification->data['appointment_id']))
                        <a href="{{ route('counselor.appointments.show', $notification->data['appointment_id']) }}" class="ms-2 fw-bold">View</a>
                    @endif
                </div>
                <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Mark as read"><i class="bi bi-x-circle"></i></button>
                </form>
            </li>
        @empty
            <li class="px-3 py-2 text-muted small">No new notifications</li>
        @endforelse
    </ul>
</div>

@include('counselor.sidebar')
<!-- Main Content -->
<div class="main-content">
    <div class="container-fluid py-4">
        {{-- Notification Section --}}
        @php
            $unreadNotifications = auth()->user()->unreadNotifications()->take(5)->get();
        @endphp
        @if($unreadNotifications->count())
            <div class="mb-4">
                @foreach($unreadNotifications as $notification)
                    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                        @if(isset($notification->data['appointment_id']))
                            <i class="bi bi-calendar-event fs-5"></i>
                        @else
                            <i class="bi bi-info-circle fs-5"></i>
                        @endif
                        <div>
                            {{ $notification->data['message'] ?? 'You have a new notification.' }}
                            @if(isset($notification->data['appointment_id']))
                                <a href="{{ route('counselor.appointments.show', $notification->data['appointment_id']) }}" class="ms-2 fw-bold">View</a>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" class="ms-auto">
                            @csrf
                            <button type="submit" class="btn-close" aria-label="Close"></button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="dashboard-header position-relative">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-4">
                <div class="flex-grow-1">
                    <h1 class="mb-2 fw-bold d-flex align-items-center" style="gap: 0.75rem;">
                        <i class="bi bi-speedometer2" style="font-size: 2rem;"></i>
                        Counselor Dashboard
                    </h1>
                    <p class="welcome-text mb-1">
                        Welcome back, <strong>{{ auth()->user()->name }}</strong>!
                    </p>
                    <p class="date-text mb-0">
                        <i class="bi bi-calendar3 me-2"></i>{{ now()->format('l, F j, Y') }}
                    </p>
                    <div class="d-flex flex-wrap align-items-center gap-2 mt-3">
                        <span class="badge-counselor">
                            <i class="bi bi-person-badge me-2"></i>Licensed Counselor
                        </span>
                        <small class="text-white-50 ms-2">CMU Counseling Services</small>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end gap-2 position-relative" style="min-width: 240px; max-width: 320px;">
                    <div class="profile-card p-3 d-flex flex-column align-items-center justify-content-center text-center" style="background: #fff; border-radius: 16px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-100); min-width: 240px; max-width: 320px;">
                        <div class="position-relative mb-2">
                            <img src="{{ auth()->user()->avatar_url }}" 
                                 alt="Avatar" 
                                 class="rounded-circle border border-3 shadow-sm" 
                                 width="100" 
                                 height="80" 
                                 style="border-color: var(--yellow-maize) !important;">
                            <div class="position-absolute bottom-0 end-0 bg-success rounded-circle" 
                                 style="width: 18px; height: 18px; border: 2px solid white;"></div>
                        </div>
                        <h5 class="fw-bold mb-1" style="color: var(--forest-green);">
                            {{ auth()->user()->name }}
                        </h5>
                        <div class="text-muted mb-2 small">{{ auth()->user()->email }}</div>
                        <span class="badge-counselor mb-2">
                            <i class="bi bi-shield-check me-1"></i>Counselor
                        </span>
                        <a href="{{ route('profile') }}" class="btn-edit mt-2">
                            <i class="bi bi-pencil me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards and Quick Actions Row -->
        @php
            $counselorId = auth()->id();
            
            // Today's appointments
            $todayAppointments = \App\Models\Appointment::where('counselor_id', $counselorId)
                ->whereDate('scheduled_at', today())
                ->count();
            
            // Pending appointments
            $pendingAppointments = \App\Models\Appointment::where('counselor_id', $counselorId)
                ->where('status', 'pending')
                ->count();
            
            // Completed sessions this month
            $completedThisMonth = \App\Models\Appointment::where('counselor_id', $counselorId)
                ->where('status', 'completed')
                ->whereMonth('scheduled_at', now()->month)
                ->whereYear('scheduled_at', now()->year)
                ->count();
            
            // Active students (with appointments in last 30 days)
            $activeStudents = \App\Models\Appointment::where('counselor_id', $counselorId)
                ->where('scheduled_at', '>=', now()->subDays(30))
                ->distinct('student_id')
                ->count('student_id');
            
            // High-risk cases
            $highRiskCases = \App\Models\User::where('role', 'student')
                ->whereHas('assessments', function($q) {
                    $q->where('risk_level', 'high');
                })
                ->whereHas('appointments', function($q) use ($counselorId) {
                    $q->where('counselor_id', $counselorId);
                })
                ->count();
        @endphp

        <div class="row mb-4">
            <!-- Statistics Cards Column -->
            <div class="col-lg-8">
                <div class="stats-grid">
                    <!-- Today's Appointments -->
                    <div class="stats-card info">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-1 fw-bold" style="color: var(--forest-green);">{{ $todayAppointments }}</h3>
                                <p class="mb-0 text-muted">Today's Appointments</p>
                                <a href="{{ route('admin.logs.appointments') }}" class="btn btn-sm btn-outline-info mt-2">
                                    <i class="bi bi-arrow-right me-1"></i>View All Appointments
                                </a>
                            </div>
                            <div class="text-info" style="font-size: 2.5rem;">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Appointments -->
                    <div class="stats-card warning">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-1 fw-bold" style="color: var(--forest-green);">{{ $pendingAppointments }}</h3>
                                <p class="mb-0 text-muted">Pending Appointments</p>
                                <a href="{{ route('admin.logs.appointments') }}?status=pending" class="btn btn-sm btn-outline-warning mt-2">
                                    <i class="bi bi-arrow-right me-1"></i>View Pending
                                </a>
                            </div>
                            <div class="text-warning" style="font-size: 2.5rem;">
                                <i class="bi bi-clock"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Sessions This Month -->
                    <div class="stats-card success">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-1 fw-bold" style="color: var(--forest-green);">{{ $completedThisMonth }}</h3>
                                <p class="mb-0 text-muted">Completed This Month</p>
                                <a href="{{ route('admin.logs.session-notes') }}" class="btn btn-sm btn-outline-success mt-2">
                                    <i class="bi bi-arrow-right me-1"></i>View Session Notes
                                </a>
                            </div>
                            <div class="text-success" style="font-size: 2.5rem;">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Active Students -->
                    <div class="stats-card">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="mb-1 fw-bold" style="color: var(--forest-green);">{{ $activeStudents }}</h3>
                                <p class="mb-0 text-muted">Active Students</p>
                                <a href="{{ route('admin.logs.users') }}?role=student&status=active" class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="bi bi-arrow-right me-1"></i>View Students
                                </a>
                            </div>
                            <div class="text-primary" style="font-size: 2.5rem;">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>

                    <!-- High-Risk Cases -->
                    <div class="stats-card priority">
                        <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-1 fw-bold" style="color: var(--forest-green);">{{ $highRiskCases }}</h3>
                            <p class="mb-0 text-muted">High-Risk Cases</p>
                            <a href="{{ route('admin.logs.assessments') }}?risk_level=high" class="btn btn-sm btn-outline-danger mt-2">
                                <i class="bi bi-arrow-right me-1"></i>View Assessments
                            </a>
                        </div>
                        <div class="text-danger" style="font-size: 2.5rem;">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Column -->
            <div class="col-lg-4">
                <div class="info-card h-100">
                    <div class="info-card-header">
                        <i class="bi bi-lightning me-2"></i>Quick Actions
                    </div>
                    <div class="info-card-body">
                        <div class="d-flex flex-column gap-3">
                            <a href="{{ route('counselor.appointments.index') }}" class="action-btn w-100">
                                <i class="bi bi-calendar-event me-2"></i>
                                View All Appointments
                            </a>
                            <a href="{{ route('counselor.session_notes.index') }}" class="action-btn w-100">
                                <i class="bi bi-journal-text me-2"></i>
                                Session Notes
                            </a>
                            <a href="{{ route('counselor.assessments.index') }}" class="action-btn w-100">
                                <i class="bi bi-clipboard-data me-2"></i>
                                Student Assessments
                            </a>
                            <a href="{{ route('counselor.availability.index') }}" class="action-btn w-100">
                                <i class="bi bi-clock me-2"></i>
                                Set Availability
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 align-items-stretch mb-4">
            <div class="col-lg-12">
                <!-- All Appointments -->
                <div class="info-card mb-4 h-100">
                    <div class="info-card-header">
                        <div>
                            <i class="bi bi-calendar-event me-2"></i>All Appointments
                        </div>
                        <a href="{{ route('counselor.appointments.index') }}" class="btn-view btn-small">
                            View All
                        </a>
                    </div>
                    <div class="info-card-body">
                        @forelse($allAppointments as $appointment)
                            @php
                                $start = $appointment->scheduled_at;
                                $end = $start->copy()->addMinutes(30);
                                $autoCreated = false;
                                $sessionNumber = null;
                                $originSession = null;
                                if($appointment->notes && preg_match('/^(\d+)(st|nd|rd|th) Session - Auto created from session note #(\d+)/', $appointment->notes, $matches)) {
                                    $autoCreated = true;
                                    $sessionNumber = $matches[1];
                                    $originSession = $matches[3];
                                }
                                $statusColor = $appointment->status === 'completed' ? 'var(--success)' : ($appointment->status === 'pending' ? 'var(--warning)' : 'var(--forest-green)');
                            @endphp
                            <div class="appointment-item mb-3 p-3 d-flex align-items-center justify-content-between" style="background: #fff; border-radius: 12px; box-shadow: 0 1px 4px rgba(44,62,80,0.07); border-left: 6px solid {{ $statusColor }};">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $appointment->student->avatar_url }}" alt="Avatar" class="rounded-circle me-2" style="width: 48px; height: 48px; object-fit: cover; border: 2px solid var(--forest-green-light);">
                                    <div>
                                        <div class="fw-bold" style="color: var(--forest-green); font-size: 1.1rem;">{{ $appointment->student->name }}</div>
                                        <div class="text-muted small mb-1"><i class="bi bi-envelope me-1"></i>{{ $appointment->student->email }}</div>
                                        <div class="mb-1">
                                            <span class="badge {{ $appointment->status === 'completed' ? 'bg-success' : ($appointment->status === 'pending' ? 'bg-warning text-dark' : 'bg-primary') }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                            @if($autoCreated && $sessionNumber)
                                                <span class="badge bg-secondary ms-2">Session {{ $sessionNumber }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-1">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            <span class="text-muted">{{ $start->format('F j, Y') }}</span>
                                            <i class="bi bi-clock ms-3 me-1"></i>
                                            <span class="text-muted">{{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}</span>
                                        </div>
                                        @if($autoCreated && $originSession)
                                            <div class="text-info small mb-1"><i class="bi bi-arrow-right-circle me-1"></i>Auto-created as next session from Session {{ $originSession }}</div>
                                        @endif
                                        @if($appointment->notes)
                                            <div class="text-muted small"><i class="bi bi-journal-text me-1"></i>{{ Str::limit(strip_tags($appointment->notes), 80) }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn-view btn-small" title="View Appointment">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(!$appointment->sessionNotes()->exists())
                                        <a href="{{ route('counselor.session_notes.create', $appointment->id) }}" class="btn-edit btn-small" title="Add Session Note">
                                            <i class="bi bi-journal-plus"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="bi bi-calendar-x"></i>
                                <p class="mb-0">No appointments found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            {{-- Removed Today's Appointments card as requested --}}
        </div>
<!-- Announcements Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="info-card">
            <div class="info-card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-megaphone me-2"></i>Latest Announcements
                </div>
                <a href="{{ route('announcements.index') }}" class="btn-view btn-small">
                    View All
                </a>
            </div>
            <div class="info-card-body">
                @php
                    $announcements = \App\Models\Announcement::orderBy('created_at', 'desc')->take(3)->get();
                @endphp
                @if($announcements->count())
                    @foreach($announcements as $announcement)
                        <div class="mb-3 pb-3 border-bottom">
                            <h6 class="fw-bold mb-1" style="color: var(--forest-green);">
                                {{ $announcement->title }}
                            </h6>
                            <small class="text-muted">{{ $announcement->created_at->format('M d, Y') }}</small>
                            <p class="mb-1 mt-2">{{ Str::limit($announcement->content, 80) }}</p>
                            <a href="{{ route('announcements.show', $announcement->id) }}" class="btn-view btn-small">
                                <i class="bi bi-eye"></i> Read More
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="bi bi-megaphone"></i>
                        <p class="mb-0">No announcements at this time.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

        

            <!-- Main Content -->
            <div class="col-lg-12">
                <!-- Priority Students and Recent Messages Row -->
                <div class="row g-4 mb-4 align-items-stretch w-100" style="margin-left:0; margin-right:0;">
                    <div class="col-12 col-lg-6 d-flex">
                        <!-- Priority Students (High-Risk Cases) -->
                        <div class="info-card h-100 flex-fill d-flex flex-column">
                            <div class="info-card-header">
                                <div>
                                    <i class="bi bi-exclamation-triangle me-2"></i>Priority Students
                                </div>
                                {{-- <a href="{{ route('counselor.priority-cases.index') }}" class="btn-view btn-small"> --}}
                                {{-- View All --}}
                                {{-- </a> --}}
                            </div>
                            <div class="info-card-body">
                                @php 
                                    $priorityStudents = \App\Models\User::where('role', 'student')
                                        ->whereHas('assessments', function($q) {
                                            $q->where('risk_level', 'high')
                                              ->orWhere('risk_level', 'moderate');
                                        })
                                        ->whereHas('appointments', function($q) {
                                            $q->where('counselor_id', auth()->id()); 
                                        })
                                        ->whereHas('appointments', function($q) {
                                            $q->where('counselor_id', auth()->id());
                                            $q->whereColumn('users.id', 'appointments.student_id');
                                        })
                                        ->with(['assessments' => function($q) {
                                            $q->latest()->first();
                                        }])
                                        ->take(4)
                                        ->get(); 
                                @endphp
                                @if($priorityStudents->count())
                                    @foreach($priorityStudents as $student)
                                        @php 
                                            $latestAssessment = $student->assessments->first();
                                            $riskLevel = $latestAssessment ? $latestAssessment->risk_level : 'low';
                                        @endphp
                                        <div class="student-item {{ $riskLevel === 'high' ? 'high-risk' : ($riskLevel === 'moderate' ? 'moderate-risk' : '') }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <span class="risk-indicator risk-{{ $riskLevel }}"></span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold" style="color: var(--forest-green);">
                                                            {{ $student->name }}
                                                        </h6>
                                                        <small class="text-muted">
                                                            Last assessment: {{ $latestAssessment ? $latestAssessment->created_at->diffForHumans() : 'No assessment' }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge-{{ $riskLevel === 'high' ? 'priority' : ($riskLevel === 'moderate' ? 'moderate' : 'normal') }}">
                                                        {{ ucfirst($riskLevel) }} Risk
                                                    </span>
                                                    <a href="{{ route('users.show', $student->id) }}" class="btn-view btn-small">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <i class="bi bi-shield-check"></i>
                                        <p class="mb-0">No priority cases at this time.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 d-flex">
                        <!-- Recent Messages -->
                        <div class="info-card h-100 flex-fill d-flex flex-column">
                            <div class="info-card-header">
                                <div>
                                    <i class="bi bi-chat-dots me-2"></i>Recent Messages
                                </div>
                                {{-- <a href="{{ route('counselor.messages.index') }}" class="btn-view btn-small"> --}}
                                {{-- View All --}}
                                {{-- </a> --}}
                            </div>
                            <div class="info-card-body">
                                @php 
                                    $recentMessages = \App\Models\Message::where('recipient_id', auth()->id())
                                        ->with('sender')
                                        ->orderBy('created_at', 'desc')
                                        ->take(4)
                                        ->get(); 
                                @endphp
                                @if($recentMessages->count())
                                    @foreach($recentMessages as $message)
                                        <div class="message-item {{ !$message->is_read ? 'unread' : '' }}">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <h6 class="mb-0 fw-semibold me-2" style="color: var(--forest-green);">
                                                            {{ $message->sender->name }}
                                                        </h6>
                                                        @if(!$message->is_read)
                                                            <span class="badge bg-danger">New</span>
                                                        @endif
                                                    </div>
                                                    <p class="mb-0 text-muted small">
                                                        {{ Str::limit($message->content, 80) }}
                                                    </p>
                                                </div>
                                                <div class="ms-3 text-end">
                                                    <small class="text-muted">
                                                        {{ $message->created_at->diffForHumans() }}
                                                    </small>
                                                    <div class="mt-1">
                                                        <a href="{{ route('chat.selectStudent') }}" class="btn-view btn-small">
                                                            <i class="bi bi-reply"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <i class="bi bi-chat-dots"></i>
                                        <p class="mb-0">No recent messages.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Session Feedback -->
                <div class="info-card">
                    <div class="info-card-header">
                        <div>
                            <i class="bi bi-star me-2"></i>Recent Session Feedback
                        </div>
                        {{-- <a href="{{ route('counselor.feedback.index') }}" class="btn-view btn-small"> --}}
                        {{-- View All --}}
                        {{-- </a> --}}
                    </div>
                    <div class="info-card-body">
                        @php 
                            $recentFeedback = \App\Models\SessionFeedback::whereHas('appointment', function($q) {
                                    $q->where('counselor_id', auth()->id());
                                })
                                ->with(['appointment.student'])
                                ->orderBy('created_at', 'desc')
                                ->take(3)
                                ->get(); 
                        @endphp
                        
                        @if($recentFeedback->count())
                            @foreach($recentFeedback as $feedback)
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <h6 class="mb-0 fw-semibold me-2" style="color: var(--forest-green);">
                                                    {{ $feedback->appointment->student->name }}
                                        </h6>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $feedback->rating ? '-fill' : '' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="mb-0 text-muted small">
                                            {{ Str::limit($feedback->comments, 60) }}
                                        </p>
                                    </div>
                                    <div class="ms-3 text-end">
                                        <small class="text-muted">
                                            {{ $feedback->created_at->diffForHumans() }}
                                    </small>
                                        <div class="mt-1">
                                            <a href="{{ route('counselor.feedback.show', $feedback->id) }}" class="btn-view btn-small">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="bi bi-star"></i>
                                <p class="mb-0">No feedback received yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Modal for Emergency Cases -->
    <div class="modal fade" id="emergencyModal" tabindex="-1" aria-labelledby="emergencyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="emergencyModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>Emergency Protocol
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h6><i class="bi bi-shield-exclamation me-2"></i>High-Risk Student Detected</h6>
                        <p class="mb-0">A student assessment indicates immediate attention may be required.</p>
                    </div>
                    <div class="d-grid gap-2">
                        {{-- <a href="{{ route('counselor.priority-cases.index') }}" class="btn btn-danger"> --}}
                        {{-- <i class="bi bi-eye me-2"></i>View Priority Cases --}}
                        {{-- </a> --}}
                        <a href="{{ route('counselor.appointments.create') }}" class="btn btn-warning">
                            <i class="bi bi-calendar-plus me-2"></i>Schedule Urgent Appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Auto-check for high-risk cases every 30 seconds
    setInterval(function() {
        fetch('/counselor/check-priority-cases')
            .then(response => response.json())
            .then(data => {
                if (data.hasHighRiskCases && !localStorage.getItem('emergencyModalShown')) {
                    var emergencyModal = new bootstrap.Modal(document.getElementById('emergencyModal'));
                    emergencyModal.show();
                    localStorage.setItem('emergencyModalShown', 'true');
                    
                    // Reset flag after 1 hour
                    setTimeout(() => {
                        localStorage.removeItem('emergencyModalShown');
                    }, 3600000);
                }
            });
    }, 30000);

    // Real-time updates for message notifications
    setInterval(function() {
        fetch('/counselor/unread-messages-count')
            .then(response => response.json())
            .then(data => {
                const notificationDots = document.querySelectorAll('.notification-dot');
                notificationDots.forEach(dot => {
                    if (data.count > 0) {
                        dot.textContent = data.count;
                        dot.style.display = 'flex';
                    } else {
                        dot.style.display = 'none';
                    }
                });
            });
    }, 10000);
    </script>
    @endsection