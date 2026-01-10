@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
        :root {
            --primary-green: #1f7a2d;
            /* Homepage forest green */
            --primary-green-2: #13601f;
            /* darker stop */
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

            /* Map dashboard-specific names to homepage palette for compatibility */
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

        /* Apply the same page zoom used on the homepage */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        body,
        .profile-card,
        .stats-card,
        .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            overflow: hidden;
        }

        .dashboard-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: start;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 0.75rem;
            align-items: stretch;
        }

        .dashboard-stat-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem 1rem;
            text-align: center;
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 140px;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .dashboard-stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
            display: block;
        }

        .dashboard-stat-card .stat-label {
            font-size: 1rem;
            color: var(--forest-green-light);
            margin-bottom: 0.25rem;
        }

        .dashboard-stat-card .stat-subtitle {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-bottom: 0.75rem;
        }

        .dashboard-stat-card .stat-progress {
            height: 6px;
            background-color: var(--gray-100);
            border-radius: 3px;
            overflow: hidden;
        }

        .dashboard-stat-card .stat-progress-bar {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease-in-out;
        }

        .progress-success {
            background-color: var(--success);
        }

        .progress-warning {
            background-color: var(--warning);
        }

        .progress-info {
            background-color: var(--info);
        }

        .progress-danger {
            background-color: var(--danger);
        }

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

        .quick-actions-sidebar {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
            height: fit-content;
        }

        .quick-actions-sidebar .card-header {
            background: linear-gradient(180deg, rgba(34, 139, 34, 0.06), rgba(34, 139, 34, 0.02));
            color: var(--forest-green);
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }

        .quick-actions-sidebar .card-body {
            padding: 1rem;
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-info,
        .btn-outline-warning {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.15s ease;
            padding: 0.6rem 1rem;
            border-width: 1px;
            box-shadow: 0 6px 18px rgba(17, 94, 37, 0.06);
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
            box-shadow: var(--shadow-sm);
        }

        .btn-outline-success:hover,
        .btn-outline-info:hover,
        .btn-outline-warning:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid var(--gray-100);
            padding: 0.75rem 0;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        @media (max-width: 991px) {
            .dashboard-layout {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .dashboard-stats {
                grid-template-columns: 1fr;
                gap: 1.2rem;
            }

            .welcome-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 2rem 1.5rem;
                text-align: center;
            }

            .main-dashboard-content {
                padding: 1.5rem 1rem;
            }
        }

        @media (max-width: 768px) {
            .welcome-card .welcome-text {
                font-size: 1.8rem;
            }

            .dashboard-stat-card {
                padding: 1.5rem 1rem;
            }

            .main-content-card .card-header,
            .main-content-card .card-body,
            .quick-actions-sidebar .card-header,
            .quick-actions-sidebar .card-body {
                padding: 1rem;
            }
        }
    </style>

    <div class="welcome-card">
        <div>
            <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
            <div class="welcome-text">Welcome back, {{ auth()->user()->name }}!</div>
            <div style="font-size: 0.9rem; margin-top: 0.5rem;">Manage and monitor the GCC System</div>
        </div>
        <div class="welcome-avatar">
            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
        </div>
    </div>

    <div class="dashboard-layout">
        <div class="dashboard-stats">
            <div class="dashboard-stat-card">
                <div class="stat-value">{{ \App\Models\User::count() }}</div>
                <div class="stat-label">Total Users</div>
                <div class="stat-subtitle">{{ \App\Models\User::where('role', 'student')->count() }} Students •
                    {{ \App\Models\User::where('role', 'counselor')->count() }} Counselors</div>
                <div class="stat-progress">
                    <div class="stat-progress-bar progress-success"
                        style="width: {{ round((\App\Models\User::where('is_active', true)->count() / \App\Models\User::count()) * 100) }}%">
                    </div>
                </div>
            </div>
            <div class="dashboard-stat-card">
                <div class="stat-value">{{ \App\Models\Appointment::count() }}</div>
                <div class="stat-label">Total Appointments</div>
                <div class="stat-subtitle">{{ \App\Models\Appointment::where('status', 'pending')->count() }} Pending •
                    {{ \App\Models\Appointment::where('status', 'completed')->count() }} Completed</div>
                <div class="stat-progress">
                    <div class="stat-progress-bar progress-info"
                        style="width: {{ \App\Models\Appointment::count() > 0 ? round((\App\Models\Appointment::where('status', 'completed')->count() / \App\Models\Appointment::count()) * 100) : 0 }}%">
                    </div>
                </div>
            </div>
            <div class="dashboard-stat-card">
                <div class="stat-value">{{ \App\Models\Assessment::count() }}</div>
                <div class="stat-label">Total Assessments</div>
                <div class="stat-subtitle">{{ \App\Models\Assessment::where('status', 'completed')->count() }} Completed •
                    {{ \App\Models\Assessment::where('status', 'pending')->count() }} Pending</div>
                <div class="stat-progress">
                    <div class="stat-progress-bar progress-warning"
                        style="width: {{ \App\Models\Assessment::count() > 0 ? round((\App\Models\Assessment::where('status', 'completed')->count() / \App\Models\Assessment::count()) * 100) : 0 }}%">
                    </div>
                </div>
            </div>
            <div class="dashboard-stat-card">
                <div class="stat-value">{{ \App\Models\User::where('registration_status', 'pending')->count() }}</div>
                <div class="stat-label">Pending Approvals</div>
                <div class="stat-subtitle">{{ \App\Models\User::where('registration_status', 'pending')->count() }}
                    registrations awaiting review</div>
                @if(\App\Models\User::where('registration_status', 'pending')->count() > 0)
                    <div class="stat-progress">
                        <div class="stat-progress-bar progress-danger" style="width: 100%"></div>
                    </div>
                @else
                    <div class="stat-progress">
                        <div class="stat-progress-bar" style="width: 0%"></div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="quick-actions-sidebar">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-people me-1"></i>Manage Users
                    </a>
                    <a href="{{ route('admin.registration-approvals.index') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-person-check me-1"></i>Review Registrations
                    </a>
                    <a href="{{ route('announcements.index') }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-megaphone me-1"></i>Manage Announcements
                    </a>
                    <a href="{{ route('activities') }}" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-activity me-1"></i>View Activity Logs
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content-card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-activity me-2"></i>Recent Activity</h5>
            <a href="{{ route('activities') }}" class="btn btn-success btn-sm">
                <i class="bi bi-arrow-right me-1"></i>View All
            </a>
        </div>
        <div class="card-body">
            @php $userActivities = \App\Models\UserActivity::where('user_id', auth()->id())->latest()->take(10)->get(); @endphp
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
                <div class="text-muted text-center py-4">No recent activities.</div>
            @endif
        </div>
    </div>
@endsection