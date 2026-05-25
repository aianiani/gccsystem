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
        }

        .card-header-custom h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .card-body-custom {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn-primary-custom {
            background: var(--primary-green);
            border: none;
            color: #fff;
            padding: 0.55rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(31, 122, 45, 0.3);
            cursor: pointer;
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

        .btn-secondary-custom {
            background: #fff;
            border: 1px solid #e0e0e0;
            color: var(--text-dark);
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-secondary-custom:hover {
            background: #f8f9fa;
            border-color: #d6d8db;
            color: var(--primary-green);
        }

        /* Form controls */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label-custom {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 0.5rem;
        }

        .form-control-custom,
        .form-select-custom {
            display: block;
            width: 100%;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            color: var(--text-dark);
            background: #fff;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
            outline: none;
        }

        textarea.form-control-custom {
            resize: vertical;
            min-height: 80px;
        }

        /* Add Schedule Section */
        .add-schedule-section {
            background: var(--bg-light);
            border: 1px solid #e8f0e8;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .add-schedule-section h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-schedule-section h4 i {
            color: var(--primary-green);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-grid-full {
            grid-column: 1 / -1;
        }

        @media (max-width: 767.98px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        /* College checkboxes */
        .college-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.75rem;
            background: #fff;
        }

        .college-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            transition: background 0.15s;
            cursor: pointer;
        }

        .college-checkbox:hover {
            background: var(--light-green);
        }

        .college-checkbox input[type="checkbox"] {
            accent-color: var(--primary-green);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .college-checkbox label {
            font-size: 0.85rem;
            color: var(--text-dark);
            margin: 0;
            cursor: pointer;
        }

        @media (max-width: 767.98px) {
            .college-grid {
                grid-template-columns: 1fr;
            }
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
            vertical-align: top;
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

        /* Schedule date display */
        .schedule-date {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .session-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .session-badge.morning {
            background: #fff8e1;
            color: #e65100;
            border: 1px solid #ffe0b2;
        }

        .session-badge.afternoon {
            background: #fff3e0;
            color: #bf360c;
            border: 1px solid #ffccbc;
        }

        .session-time {
            font-size: 0.78rem;
            color: var(--text-light);
            font-weight: 500;
        }

        .academic-year {
            font-size: 0.78rem;
            color: #999;
            margin-top: 2px;
        }

        /* Location cell */
        .location-cell {
            display: flex;
            align-items: flex-start;
            gap: 0.4rem;
            font-weight: 500;
            color: var(--text-dark);
        }

        .location-cell i {
            color: var(--text-light);
            margin-top: 2px;
            font-size: 0.9rem;
        }

        /* College tags */
        .college-tag {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            background: #f3f4f6;
            color: #555;
            border-radius: 4px;
            font-size: 0.78rem;
            border: 1px solid #e5e7eb;
            margin: 1px;
        }

        .college-tag-all {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            background: #d4edda;
            color: #155724;
            border-radius: 4px;
            font-size: 0.78rem;
            font-weight: 600;
            border: 1px solid #c3e6cb;
        }

        /* Delete button for schedules */
        .btn-delete-schedule {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: transparent;
            border: 1px solid #f5c6cb;
            color: #dc3545;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-delete-schedule:hover {
            background: #fff5f5;
            border-color: #dc3545;
            color: #c82333;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
        }

        .empty-state i {
            font-size: 2rem;
            color: #ccc;
            display: block;
            margin-bottom: 0.5rem;
        }

        .empty-state span {
            font-style: italic;
            color: #999;
            font-size: 0.9rem;
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
                    <!-- Back Button -->
                    <div style="margin-bottom: 1.5rem;">
                        <a href="{{ route('counselor.seminars.index') }}" class="btn-secondary-custom">
                            <i class="bi bi-arrow-left"></i> Back to Seminars
                        </a>
                    </div>

                    <!-- Page Header -->
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="page-title">{{ $seminar->name }}</h2>
                            <p class="page-subtitle">Edit seminar details & manage schedules</p>
                        </div>
                        <div class="d-none d-md-block">
                            <i class="bi bi-pencil-square" style="font-size: 3rem; opacity: 0.2;"></i>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert-success-custom" role="alert">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Edit Seminar Details -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3><i class="bi bi-info-circle me-2" style="color: var(--primary-green);"></i>Seminar Details</h3>
                        </div>
                        <div class="card-body-custom">
                            <form action="{{ route('counselor.seminars.update', $seminar) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="name" class="form-label-custom">Seminar Name</label>
                                        <input type="text" name="name" id="name" value="{{ $seminar->name }}"
                                            class="form-control-custom" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="target_year_level" class="form-label-custom">Target Year Level</label>
                                        <select name="target_year_level" id="target_year_level" class="form-select-custom"
                                            required>
                                            <option value="1" {{ $seminar->target_year_level == 1 ? 'selected' : '' }}>1st Year</option>
                                            <option value="2" {{ $seminar->target_year_level == 2 ? 'selected' : '' }}>2nd Year</option>
                                            <option value="3" {{ $seminar->target_year_level == 3 ? 'selected' : '' }}>3rd Year</option>
                                            <option value="4" {{ $seminar->target_year_level == 4 ? 'selected' : '' }}>4th Year</option>
                                        </select>
                                    </div>

                                    <div class="form-group form-grid-full">
                                        <label for="description" class="form-label-custom">Description</label>
                                        <textarea name="description" id="description" rows="3"
                                            class="form-control-custom">{{ $seminar->description }}</textarea>
                                    </div>
                                </div>

                                <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
                                    <button type="submit" class="btn-primary-custom">
                                        <i class="bi bi-check-lg"></i> Update Seminar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Manage Schedules -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3><i class="bi bi-calendar-plus me-2" style="color: var(--primary-green);"></i>Manage Schedules</h3>
                        </div>
                        <div class="card-body-custom">
                            <!-- Add Schedule Form -->
                            <div class="add-schedule-section">
                                <h4><i class="bi bi-plus-circle"></i> Add New Schedule</h4>
                                <form action="{{ route('counselor.seminars.schedules.store', $seminar) }}" method="POST">
                                    @csrf
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label for="date" class="form-label-custom">Date</label>
                                            <input type="date" name="date" id="date" class="form-control-custom" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="location" class="form-label-custom">Location</label>
                                            <input type="text" name="location" id="location" class="form-control-custom"
                                                placeholder="e.g. University Hall">
                                        </div>
                                        <div class="form-group">
                                            <label for="academic_year" class="form-label-custom">Academic Year</label>
                                            <input type="text" name="academic_year" id="academic_year"
                                                class="form-control-custom" placeholder="e.g. 2025-2026">
                                        </div>
                                        <div class="form-group">
                                            <label for="session_type" class="form-label-custom">Session Type</label>
                                            <select name="session_type" id="session_type" class="form-select-custom" required>
                                                <option value="Morning">Morning (8:00 AM - 12:00 PM)</option>
                                                <option value="Afternoon">Afternoon (1:00 PM - 5:00 PM)</option>
                                            </select>
                                        </div>
                                        <div class="form-group form-grid-full">
                                            <label class="form-label-custom">Assign Colleges</label>
                                            <div class="college-grid">
                                                @php
                                                    $colleges = [
                                                        'College of Arts and Sciences',
                                                        'College of Veterinary Medicine',
                                                        'College of Forestry and Environmental Sciences',
                                                        'College of Business and Management',
                                                        'College of Nursing',
                                                        'College of Human Ecology',
                                                        'College of Agriculture',
                                                        'College of Information Science and Computing',
                                                        'College of Education',
                                                        'College of Engineering'
                                                    ];
                                                @endphp
                                                @foreach($colleges as $college)
                                                    <div class="college-checkbox">
                                                        <input type="checkbox" name="colleges[]" value="{{ $college }}" id="college_{{ $loop->index }}">
                                                        <label for="college_{{ $loop->index }}">{{ $college }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-grid-full">
                                            <button type="submit" class="btn-primary-custom" style="width: 100%; justify-content: center;">
                                                <i class="bi bi-plus-lg"></i> Add Schedule
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Schedules List -->
                            <div style="overflow-x: auto;">
                                <table class="table-custom">
                                    <thead>
                                        <tr>
                                            <th style="width: 28%;">Date & Time</th>
                                            <th style="width: 20%;">Location</th>
                                            <th style="width: 40%;">Target Colleges</th>
                                            <th style="width: 12%; text-align: right;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($seminar->schedules as $schedule)
                                            <tr>
                                                <td>
                                                    <div class="schedule-date">{{ $schedule->date->format('F d, Y') }}</div>
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <span class="session-badge {{ $schedule->session_type === 'Morning' ? 'morning' : 'afternoon' }}">
                                                            {{ $schedule->session_type }} Session
                                                        </span>
                                                        <span class="session-time">
                                                            @if($schedule->session_type === 'Morning')
                                                                (8:00 AM - 12:00 PM)
                                                            @else
                                                                (1:00 PM - 5:00 PM)
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="academic-year">AY {{ $schedule->academic_year }}</div>
                                                </td>
                                                <td>
                                                    <div class="location-cell">
                                                        <i class="bi bi-geo-alt-fill"></i>
                                                        <span>{{ $schedule->location ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($schedule->colleges)
                                                        <div class="d-flex flex-wrap gap-1">
                                                            @foreach($schedule->colleges as $college)
                                                                <span class="college-tag">{{ $college }}</span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="college-tag-all">All Colleges</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: right;">
                                                    <form action="{{ route('counselor.seminars.schedules.destroy', $schedule) }}"
                                                        method="POST" class="d-inline delete-form" data-confirm-message="Delete this schedule?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-delete-schedule" title="Delete Schedule">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <div class="empty-state">
                                                        <i class="bi bi-calendar-x"></i>
                                                        <span>No schedules configured yet.</span>
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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