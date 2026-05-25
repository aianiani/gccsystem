@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
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

        .custom-sidebar .sidebar-link.active,

        .custom-sidebar .sidebar-link .bi {
            font-size: 1.1rem;
        }

        .custom-sidebar .sidebar-bottom {
            padding: 1rem 0.5rem;
            border-top: 1px solid #4a7c59;
        }

        .custom-sidebar .sidebar-link.logout {
            background: #dc3545;
            color: #fff;
            border-radius: 8px;
            text-align: center;
            padding: 0.75rem 1rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .custom-sidebar .sidebar-link.logout:hover {
            background: #b52a37;
            color: #fff;
        }

        @media (max-width: 767.98px) {
            .custom-sidebar.show {
                transform: translateX(0);
            }

            .main-dashboard-content {
                margin-left: 0;
            }
        }

        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Page Header */
        .page-header {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            color: #fff;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
        }

        .page-subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
            margin: 0.25rem 0 0;
        }

        /* Content Card */
        .content-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .card-header-custom {
            background: #fff;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--light-green);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .card-header-custom h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        /* Buttons */
        .btn-primary-custom {
            background: var(--primary-green);
            border: none;
            color: #fff;
            padding: 0.55rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(31, 122, 45, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-primary-custom:hover {
            background: var(--primary-green-2);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(31, 122, 45, 0.4);
            color: #fff;
        }

        /* Table */
        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom th {
            background-color: var(--light-green);
            color: var(--primary-green);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            padding: 0.75rem 1rem;
            border: none;
        }

        .table-custom td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .table-custom tbody tr {
            transition: background-color 0.15s ease;
        }

        .table-custom tbody tr:hover td {
            background-color: #fafdfa;
        }

        /* Seminar name cell */
        .seminar-name {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 0.95rem;
            margin-bottom: 2px;
        }

        .seminar-desc {
            font-size: 0.82rem;
            color: var(--text-light);
            line-height: 1.4;
        }

        /* Year badge */
        .year-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e8f0fe;
            color: #1a56db;
            font-weight: 700;
            font-size: 0.85rem;
            border: 1px solid #c6d8f7;
        }

        /* Progress bar */
        .progress-wrapper {
            min-width: 100px;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .progress-info .count {
            font-size: 0.78rem;
            font-weight: 600;
            color: #555;
        }

        .progress-info .percent {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--primary-green);
        }

        .progress-track {
            width: 100%;
            height: 7px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--hero-gradient);
            border-radius: 4px;
            transition: width 0.5s ease;
        }

        /* Schedule chips */
        .schedule-chip {
            display: inline-flex;
            flex-direction: column;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.35rem 0.6rem;
            font-size: 0.78rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: border-color 0.2s;
        }

        .schedule-chip:hover {
            border-color: var(--primary-green);
        }

        .schedule-chip .chip-date {
            font-weight: 600;
            color: var(--text-dark);
        }

        .schedule-chip .chip-meta {
            display: flex;
            align-items: center;
            gap: 4px;
            color: var(--text-light);
            font-size: 0.72rem;
        }

        .no-schedule-text {
            color: #b0b0b0;
            font-style: italic;
            font-size: 0.85rem;
        }

        /* Action buttons */
        .btn-action-edit {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: transparent;
            border: 1px solid #e0a800;
            color: #c48a00;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.35rem 0.8rem;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-action-edit:hover {
            background: #fff8e1;
            border-color: #c48a00;
            color: #a67200;
        }

        .btn-action-delete {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.35rem 0.8rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-action-delete:hover {
            background: #fff5f5;
            border-color: #c82333;
            color: #c82333;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 2.5rem;
            color: #ccc;
            display: block;
            margin-bottom: 0.75rem;
        }

        .empty-state .empty-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #666;
            margin-bottom: 0.25rem;
        }

        .empty-state .empty-desc {
            font-size: 0.9rem;
            color: #999;
        }

        /* Success alert */
        .alert-success-custom {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.25rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->

            <!-- Sidebar -->
            @include('counselor.sidebar')

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <!-- Page Header -->
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="page-title">Seminar Management</h2>
                            <p class="page-subtitle">Configure seminars and schedules</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="bi bi-calendar-event" style="font-size: 3rem; opacity: 0.2;"></i>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert-success-custom" role="alert">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Seminars Card -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3>All Seminars</h3>
                            <a href="{{ route('counselor.seminars.create') }}" class="btn-primary-custom">
                                <i class="bi bi-plus-lg"></i> Create New Seminar
                            </a>
                        </div>

                        <div style="overflow-x: auto;">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Name</th>
                                        <th style="width: 8%; text-align: center;">Year</th>
                                        <th style="width: 18%;">Participation</th>
                                        <th style="width: 32%;">Schedules</th>
                                        <th style="width: 17%; text-align: right;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($seminars as $seminar)
                                        <tr>
                                            <td>
                                                <div class="seminar-name">{{ $seminar->name }}</div>
                                                <div class="seminar-desc">
                                                    {{ Str::limit($seminar->description, 60) }}
                                                </div>
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="year-badge">
                                                    {{ $seminar->target_year_level }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="progress-wrapper">
                                                    <div class="progress-info">
                                                        <span class="count">{{ $seminar->stats['completed'] }}/{{ $seminar->stats['total'] }}</span>
                                                        <span class="percent">{{ $seminar->stats['percentage'] }}%</span>
                                                    </div>
                                                    <div class="progress-track">
                                                        <div class="progress-fill"
                                                            style="width: {{ $seminar->stats['percentage'] }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @forelse($seminar->schedules as $schedule)
                                                        <div class="schedule-chip">
                                                            <span class="chip-date">
                                                                {{ $schedule->date->format('M d, Y') }}
                                                            </span>
                                                            <span class="chip-meta">
                                                                <span>{{ $schedule->session_type }}</span>
                                                                @if($schedule->location)
                                                                    <span>&bull;</span>
                                                                    <span>{{ $schedule->location }}</span>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @empty
                                                        <span class="no-schedule-text">No schedules configured</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td style="text-align: right; white-space: nowrap;">
                                                <div class="d-flex align-items-center justify-content-end gap-2">
                                                    <a href="{{ route('counselor.seminars.edit', $seminar) }}"
                                                        class="btn-action-edit">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                    <form action="{{ route('counselor.seminars.destroy', $seminar) }}"
                                                        method="POST" class="d-inline delete-form"
                                                        data-confirm-message="Are you sure you want to delete this seminar?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action-delete">
                                                            <i class="bi bi-trash3"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="empty-state">
                                                    <i class="bi bi-calendar-x"></i>
                                                    <div class="empty-title">No seminars found</div>
                                                    <div class="empty-desc">Get started by creating a new seminar.</div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete confirmation
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    var message = form.getAttribute('data-confirm-message') || 'Are you sure?';
                    if (!confirm(message)) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection