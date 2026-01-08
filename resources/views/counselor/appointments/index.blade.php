@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables */
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-600: var(--text-light);
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        /* Apply page zoom */
        .home-zoom {
            zoom: 0.85;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.85);
                transform-origin: top center;
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0, 0, 0, 0.08);
            overflow-y: auto;
            padding-bottom: 1rem;
        }

        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
        }

        .welcome-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 1.5rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            min-height: 100px;
        }

        .welcome-card .welcome-text {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }

        .welcome-card .welcome-date {
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .welcome-card .welcome-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Stats Cards */
        .dashboard-stat-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--forest-green-lighter);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            flex-shrink: 0;
        }

        .stat-icon.primary { background: var(--light-green); color: var(--forest-green); }
        .stat-icon.info { background: #e0f7fa; color: #00acc1; }
        .stat-icon.warning { background: #fff8e1; color: #ffc107; }
        .stat-icon.success { background: #e8f5e9; color: #2e7d32; }
        .stat-icon.danger { background: #ffebee; color: #c62828; }

        .stat-content { flex-grow: 1; min-width: 0; }
        .stat-label { font-size: 0.9rem; color: var(--text-light); font-weight: 500; margin-bottom: 0.25rem; }
        .stat-value { font-size: 1.85rem; font-weight: 700; color: var(--text-dark); line-height: 1.2; }
        .stat-hint { font-size: 0.8rem; color: #9aa0ac; margin-top: 0.25rem; }

        /* Filter Card */
        .filter-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        /* Main Content Card (Student List style) */
        .main-content-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .main-content-card .card-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .main-content-card .card-body {
            padding: 1.25rem;
        }

        /* Appointment Card (based on Student Card) */
        .appointment-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .appointment-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--forest-green-light);
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--forest-green-light);
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-info,
        .btn-outline-warning {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.15s ease;
            padding: 0.5rem 1rem;
            border-width: 1px;
            box-shadow: 0 4px 12px rgba(17, 94, 37, 0.04);
        }

        .btn-outline-primary {
            border-color: var(--forest-green);
            color: var(--forest-green);
        }

        .btn-outline-primary:hover {
            background-color: var(--forest-green);
            border-color: var(--forest-green);
            color: white;
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--gray-600);
            background: var(--gray-50);
            border-radius: 12px;
            border: 2px dashed var(--gray-100);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content { margin-left: 200px; }
        }
        @media (max-width: 767.98px) {
            .main-dashboard-content { margin-left: 0; }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="counselorSidebarToggle" class="d-md-none">
                <i class="bi bi-list"></i>
            </button>
            <!-- Sidebar -->
            @include('counselor.sidebar')

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <!-- Welcome Card -->
                    <div class="welcome-card">
                        <div>
                            <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
                            <div class="welcome-text">Counseling Appointments</div>
                            <div style="font-size: 0.9rem; margin-top: 0.5rem;">Manage your student appointments and requests</div>
                        </div>
                        <div class="welcome-avatar">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Summary Stats -->
                    <div class="row g-3 mb-4 hero-cards">
                        <!-- Total Appointments -->
                        <div class="col-12 col-md-4">
                            <div class="dashboard-stat-card">
                                <div class="stat-icon primary">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Total Appointments</div>
                                    <div class="stat-value">{{ number_format($totalAppointments) }}</div>
                                    <div class="stat-hint">All time records</div>
                                </div>
                            </div>
                        </div>
                        <!-- Pending Requests -->
                        <div class="col-12 col-md-4">
                            <div class="dashboard-stat-card">
                                <div class="stat-icon warning">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Pending Requests</div>
                                    <div class="stat-value">{{ number_format($pendingAppointments) }}</div>
                                    <div class="stat-hint">Requires action</div>
                                </div>
                            </div>
                        </div>
                        <!-- Completed Sessions -->
                        <div class="col-12 col-md-4">
                            <div class="dashboard-stat-card">
                                <div class="stat-icon success">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Completed Sessions</div>
                                    <div class="stat-value">{{ number_format($completedAppointments) }}</div>
                                    <div class="stat-hint">Successful sessions</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Card -->
                    <div class="filter-card">
                        <h5 class="mb-3" style="color: var(--forest-green); font-weight: 700;">
                            <i class="bi bi-funnel me-2"></i>Filter Appointments
                        </h5>
                        <form method="GET" action="{{ route('counselor.appointments.index') }}" class="row g-3">
                            <div class="col-md-5">
                                <label for="search" class="form-label fw-bold small text-muted">Search Student</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="search" name="search"
                                        value="{{ request('search') }}" placeholder="Name, Email, or Student ID">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-bold small text-muted">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="rescheduled_pending" {{ request('status') == 'rescheduled_pending' ? 'selected' : '' }}>Reschedule Pending</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary w-100" style="background: var(--forest-green); border: none;">
                                    <i class="bi bi-funnel me-1"></i>Apply
                                </button>
                                <a href="{{ route('counselor.appointments.index') }}" class="btn btn-outline-secondary w-100" title="Clear Filters">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Appointments List -->
                    <div class="main-content-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-calendar-range me-2"></i>Appointments List ({{ $appointments->total() }})</h5>
                        </div>
                        <div class="card-body">
                            @forelse($appointments as $appointment)
                                <div class="appointment-card">
                                    <div class="row align-items-center gy-3">
                                        <!-- Student Info (4 columns) -->
                                        <div class="col-12 col-md-5 col-lg-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $appointment->student->avatar_url }}" alt="{{ $appointment->student->name }}"
                                                    class="student-avatar flex-shrink-0">
                                                <div class="overflow-hidden">
                                                    <h6 class="mb-1 fw-bold text-truncate" style="color: var(--forest-green); font-size: 1.1rem;">
                                                        {{ $appointment->student->name }}
                                                    </h6>
                                                    <div class="d-flex flex-column small text-muted">
                                                        <span class="text-truncate">{{ $appointment->student->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Date & Time (3 columns) -->
                                        <div class="col-12 col-md-3 col-lg-3">
                                            <div class="d-none d-md-block border-start border-end px-3 text-center">
                                                <div class="fw-bold" style="font-size: 1.1rem; color: var(--text-dark);">
                                                    {{ $appointment->scheduled_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-secondary fw-semibold">
                                                    {{ $appointment->scheduled_at->format('g:i A') }}
                                                </div>
                                                <small class="text-muted">{{ $appointment->scheduled_at->diffForHumans() }}</small>
                                            </div>
                                            <!-- Mobile view -->
                                            <div class="d-md-none text-muted small mb-2">
                                                <i class="bi bi-calendar-event me-1"></i>{{ $appointment->scheduled_at->format('M d, Y • g:i A') }}
                                            </div>
                                        </div>

                                        <!-- Status & Problem (3 columns) -->
                                        <div class="col-12 col-md-4 col-lg-3 text-start text-md-center">
                                            @php
                                                $status = $appointment->status;
                                                $statusMap = [
                                                    'pending' => ['class' => 'bg-warning text-dark', 'icon' => 'hourglass-split'],
                                                    'accepted' => ['class' => 'bg-success', 'icon' => 'check-circle'],
                                                    'completed' => ['class' => 'bg-primary', 'icon' => 'check-all'],
                                                    'declined' => ['class' => 'bg-danger', 'icon' => 'x-circle'],
                                                    'cancelled' => ['class' => 'bg-danger', 'icon' => 'x-circle'],
                                                    'rescheduled_pending' => ['class' => 'bg-info text-dark', 'icon' => 'calendar-date'],
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusMap[$status]['class'] ?? 'bg-secondary' }} px-3 py-2 mb-2 rounded-pill d-inline-flex align-items-center">
                                                <i class="bi bi-{{ $statusMap[$status]['icon'] ?? 'info-circle' }} me-1"></i>
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </span>
                                            <div class="small text-muted fst-italic text-truncate px-2 mx-auto" style="max-width: 200px;">
                                                {{ $appointment->nature_of_problem ?? 'No topic specified' }}
                                            </div>
                                        </div>

                                        <!-- Actions (2 columns) -->
                                        <div class="col-12 col-md-12 col-lg-2">
                                            <div class="d-flex justify-content-md-end justify-content-start gap-2">
                                                <a href="{{ route('counselor.appointments.show', $appointment->id) }}"
                                                    class="btn btn-outline-primary btn-sm flex-fill flex-md-grow-0" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                @if($appointment->status === 'pending')
                                                    <form action="{{ route('counselor.appointments.accept', $appointment->id) }}" method="POST" class="d-inline flex-fill flex-md-grow-0">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm w-100" title="Accept">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('counselor.appointments.decline', $appointment->id) }}" method="POST" class="d-inline flex-fill flex-md-grow-0">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger btn-sm w-100" title="Decline" onclick="return confirm('Are you sure you want to decline this appointment?');">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    </form>
                                                @elseif(in_array($appointment->status, ['accepted', 'rescheduled_pending']))
                                                    <a href="{{ route('counselor.appointments.edit', $appointment->id) }}"
                                                        class="btn btn-warning btn-sm flex-fill flex-md-grow-0" title="Edit/Reschedule">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('counselor.appointments.cancel', $appointment->id) }}" method="POST" class="d-inline flex-fill flex-md-grow-0">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger btn-sm w-100" title="Cancel" onclick="return confirm('Are you sure you want to cancel this appointment?');">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class="bi bi-calendar-x"></i>
                                    <h5 class="mb-2">No Appointments Found</h5>
                                    <p class="mb-0">Try adjusting your filters or wait for new bookings.</p>
                                </div>
                            @endforelse

                            <!-- Pagination -->
                            @if($appointments->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $appointments->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle logic matching student directory
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function () {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function (e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
@endsection
