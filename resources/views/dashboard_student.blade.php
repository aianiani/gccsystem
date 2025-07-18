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
        body, .profile-card, .stats-card, .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .custom-sidebar {
            background: linear-gradient(180deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
            min-height: 100vh;
            padding: 2rem 0 2rem 0;
            border-radius: 28px 0 0 28px;
            box-shadow: var(--shadow-md);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .custom-sidebar .sidebar-logo {
            margin-bottom: 2.5rem;
        }
        .custom-sidebar .sidebar-nav {
            width: 100%;
        }
        .custom-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.85rem 2rem;
            font-size: 1.2rem;
            color: #fff;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            transition: background 0.2s, color 0.2s;
            text-decoration: none;
        }
        .custom-sidebar .sidebar-link.active, .custom-sidebar .sidebar-link:hover {
            background: var(--yellow-maize);
            color: var(--forest-green);
            font-weight: 600;
        }
        .custom-sidebar .sidebar-link .bi {
            font-size: 1.3rem;
        }
        .custom-sidebar .sidebar-bottom {
            margin-top: auto;
            width: 100%;
        }
        .custom-sidebar .sidebar-link.logout {
            color: #fff;
            background: none;
        }
        .custom-sidebar .sidebar-link.logout:hover {
            background: var(--danger);
            color: #fff;
        }
        .main-dashboard-content {
            background: var(--gray-50);
            min-height: 100vh;
            padding: 2.5rem 2rem;
        }
        .welcome-card {
            background: linear-gradient(135deg, var(--forest-green) 0%, var(--yellow-maize) 100%);
            border-radius: 18px;
            box-shadow: var(--shadow-md);
            padding: 2.5rem 2rem 2rem 2.5rem;
            margin-bottom: 2.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .welcome-card .welcome-text {
            font-size: 2.2rem;
            font-weight: 700;
        }
        .welcome-card .welcome-date {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .welcome-card .welcome-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .dashboard-stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }
        .dashboard-stat-card {
            flex: 1;
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            padding: 2rem 1.5rem;
            text-align: center;
            border: 1.5px solid var(--gray-100);
        }
        .dashboard-stat-card .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--forest-green);
        }
        .dashboard-stat-card .stat-label {
            font-size: 1.1rem;
            color: var(--forest-green-light);
        }
        @media (max-width: 991px) {
            .dashboard-stats {
                flex-direction: column;
                gap: 1.2rem;
            }
            .welcome-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 2rem 1rem;
            }
        }
    </style>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="custom-sidebar">
            <div class="sidebar-logo mb-4">
                <i class="bi bi-mortarboard-fill" style="font-size: 2.5rem; color: #fff;"></i>
            </div>
            <nav class="sidebar-nav flex-grow-1">
                <a href="{{ route('profile') }}" class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i class="bi bi-person"></i>Profile</a>
                <a href="{{ route('dashboard') }}" class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i class="bi bi-house-door"></i>Dashboard</a>
                <a href="{{ route('appointments.index') }}" class="sidebar-link{{ request()->routeIs('appointments.*') ? ' active' : '' }}"><i class="bi bi-calendar-check"></i>Appointments</a>
                <a href="{{ route('assessments.index') }}" class="sidebar-link{{ request()->routeIs('assessments.*') ? ' active' : '' }}"><i class="bi bi-clipboard-data"></i>Assessments</a>
                <a href="{{ route('chat.selectCounselor') }}" class="sidebar-link{{ request()->routeIs('chat.selectCounselor') ? ' active' : '' }}"><i class="bi bi-chat-dots"></i>Chat with a Counselor</a>
            </nav>
            <div class="sidebar-bottom w-100">
                <a href="{{ route('logout') }}" class="sidebar-link logout"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        <!-- Main Content -->
        <div class="main-dashboard-content flex-grow-1">
            <div class="welcome-card">
                <div>
                    <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
                    <div class="welcome-text">Welcome back, {{ auth()->user()->first_name ?? auth()->user()->name }}!</div>
                    <div style="font-size: 1.1rem; margin-top: 0.5rem;">Always stay updated in your student portal</div>
                </div>
                <div class="welcome-avatar">
                    <i class="bi bi-person-circle" style="font-size: 3.5rem; color: #fff;"></i>
                </div>
            </div>
            <div class="dashboard-stats">
                <div class="dashboard-stat-card">
                    <div class="stat-value">8/12</div>
                    <div class="stat-label">Sessions Completed</div>
                </div>
                <div class="dashboard-stat-card">
                    <div class="stat-value">3</div>
                    <div class="stat-label">Assessments</div>
                </div>
                <div class="dashboard-stat-card">
                    <div class="stat-value">95%</div>
                    <div class="stat-label">Attendance Rate</div>
                </div>
            </div>
            <div class="main-content-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Upcoming Appointments</h5>
                    <a href="{{ route('appointments.create') }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Book a new appointment"><i class="bi bi-calendar-plus me-1"></i>Book Appointment</a>
                    </div>
                    <div class="card-body">
                        @forelse($upcomingAppointments as $appointment)
                            @php
                                $start = $appointment->scheduled_at;
                                $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                                    ->where('start', $start)
                                    ->first();
                                $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                            @endphp
                            <div class="appointment-item mb-3 p-3 border rounded-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                    <h6 class="mb-1 fw-bold">Counseling Session</h6>
                                        <p class="text-muted mb-1">
                                            <i class="bi bi-person me-1"></i>{{ $appointment->counselor->name ?? 'Counselor' }}
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="bi bi-calendar me-1"></i>{{ $start->format('F j, Y') }} at {{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}
                                        </p>
                                        @if($appointment->status === 'accepted')
                                            <div class="mt-1 text-success small"><i class="bi bi-journal-text me-1"></i>Your Appointment has been accepted, please proceed to GCC on {{ $start->format('M d, Y') }} at {{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}.</div>
                                        @elseif($appointment->status === 'completed')
                                            <div class="mt-1 text-primary small"><i class="bi bi-journal-text me-1"></i>Session notes available.</div>
                                        @elseif($appointment->status === 'declined')
                                            <div class="mt-1 text-danger small"><i class="bi bi-journal-text me-1"></i>Your appointment was declined. Please select another available slot or contact the GCC for assistance.</div>
                                        @elseif($appointment->status === 'rescheduled_pending')
                                            <div class="mt-1 text-info small"><i class="bi bi-arrow-repeat me-1"></i>Your counselor has proposed a new slot. Please accept or decline below.</div>
                                            <form action="{{ route('appointments.acceptReschedule', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm me-2"><i class="bi bi-check-circle me-1"></i>Accept</button>
                                            </form>
                                            <form action="{{ route('appointments.declineReschedule', $appointment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-circle me-1"></i>Decline</button>
                                            </form>
                                        @elseif($appointment->notes)
                                            <div class="mt-1 text-muted small"><i class="bi bi-journal-text me-1"></i>{{ Str::limit($appointment->notes, 60) }}</div>
                                        @else
                                            <div class="mt-1 text-muted small"><i class="bi bi-journal-text me-1"></i>No notes</div>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column gap-1">
                                            <span class="badge bg-primary">{{ ucfirst($appointment->status) }}</span>
                                </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted">No upcoming appointments.</div>
                        @endforelse
                        <div class="text-center">
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-success" data-bs-toggle="tooltip" title="View all your appointments">
                                <i class="bi bi-eye me-1"></i>View All Appointments
                            </a>
                        </div>
                    </div>
                </div>
            <div class="main-content-card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-megaphone me-2"></i>Announcements</h6>
                    </div>
                    <div class="card-body">
                    @foreach($recentAnnouncements as $announcement)
                        <div class="announcement-item mb-3 p-2 border-start border-primary border-3">
                            <h6 class="mb-1 fw-bold small">{{ $announcement->title }}</h6>
                            <p class="mb-1 small text-muted">{{ Str::limit($announcement->content, 80) }}</p>
                            <small class="text-muted">{{ $announcement->created_at->format('F j, Y') }}</small>
                        </div>
                    @endforeach
                        <div class="text-center">
                        <a href="{{ route('announcements.index') }}" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="View all announcements">
                                <i class="bi bi-eye me-1"></i>View All
                        </a>
                    </div>
                </div>
            </div>
            <div class="main-content-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>Recent Messages</h5>
                    <a href="#" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Open chat with your counselor"><i class="bi bi-chat-dots me-1"></i>Open Chat</a>
                    </div>
                    <div class="card-body">
                    <div class="message-preview mb-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 fw-bold">Dr. Maria Santos</h6>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                            <p class="mb-0 text-muted">Thank you for sharing your concerns about exam stress. I've sent you some relaxation techniques to try before our next session...</p>
                        </div>
                    <div class="message-preview mb-2">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 fw-bold">Counseling Center</h6>
                                <small class="text-muted">1 day ago</small>
                            </div>
                            <p class="mb-0 text-muted">Reminder: Your appointment with Dr. Santos is scheduled for July 18th at 2:00 PM. Please arrive 10 minutes early.</p>
                        </div>
                        <div class="text-center mt-3">
                        <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="View all your messages">
                                <i class="bi bi-eye me-1"></i>View All Messages
                        </a>
                    </div>
                </div>
            </div>
            {{-- Chat button for student to message their counselor --}}
            @if(isset($counselor))
                <div class="mb-3">
                    <a href="{{ route('chat.index', $counselor->id) }}" class="btn btn-outline-success">
                        <i class="bi bi-chat-dots"></i> Message My Counselor
                    </a>
                </div>
            @endif
            {{-- Chat with a Counselor button for student --}}
            <div class="mb-3">
                <a href="{{ route('chat.selectCounselor') }}" class="btn btn-outline-success">
                    <i class="bi bi-chat-dots"></i> Chat with a Counselor
                </a>
            </div>
        </div>
    </div>
</div>
    <script>
    // Enable Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
@endsection