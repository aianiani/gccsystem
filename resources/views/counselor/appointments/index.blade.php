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

        /* Apply page zoom - CRITICAL */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top left;
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
            padding: 1.5rem 2rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 1400px;
            margin: 0 auto;
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .main-dashboard-content {
                margin-left: 0;
                padding: 1rem;
            }
        }

        /* Page Header */
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            background: var(--hero-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon.primary {
            background: var(--light-green);
            color: var(--primary-green);
        }

        .stat-icon.warning {
            background: #fff8e1;
            color: #f57f17;
        }

        .stat-icon.success {
            background: #e8f5e9;
            color: #1b5e20;
        }

        .stat-info h3 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-dark);
        }

        .stat-info p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* Filter Bar - FIXED ALIGNMENT */
        .filter-bar {
            background: #fff;
            padding: 1rem 1.25rem;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.25rem;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
        }

        .filter-input {
            flex: 1;
            min-width: 200px;
            max-width: 280px;
        }

        .filter-input input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 0.75rem 0.5rem 2.25rem;
            font-size: 0.9rem;
            width: 100%;
            height: 38px;
        }

        .filter-input .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .filter-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 2rem 0.5rem 0.75rem;
            font-size: 0.9rem;
            height: 38px;
            min-width: 140px;
            background: #fff;
            cursor: pointer;
        }

        .btn-filter {
            background: var(--primary-green);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            font-size: 0.9rem;
            height: 38px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .btn-filter:hover {
            background: var(--primary-green-2);
            color: #fff;
        }

        .btn-reset {
            background: transparent;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: all 0.2s;
        }

        .btn-reset:hover {
            background: #f1f5f9;
            color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-clear-completed {
            background: transparent;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            color: #dc2626;
            font-weight: 600;
            font-size: 0.85rem;
            height: 38px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
            margin-left: auto;
        }

        .btn-clear-completed:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Content Card & Table */
        .content-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        /* Bulk Actions Bar */
        .bulk-bar {
            background: var(--primary-green);
            color: #fff;
            padding: 0.75rem 1.25rem;
            display: none;
            align-items: center;
            gap: 1rem;
        }

        .bulk-bar.active {
            display: flex;
        }

        .bulk-bar .count {
            font-weight: 700;
            font-size: 0.95rem;
        }

        .bulk-bar .btn-bulk {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 0.4rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: background 0.2s;
        }

        .bulk-bar .btn-bulk:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .bulk-bar .btn-bulk.approve {
            color: #a7f3d0;
        }

        .bulk-bar .btn-bulk.delete {
            color: #fecaca;
        }

        /* Premium Table */
        .premium-table {
            width: 100%;
            border-collapse: collapse;
        }

        .premium-table thead th {
            background: #f8fafc;
            padding: 0.9rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
            white-space: nowrap;
        }

        .premium-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
        }

        .premium-table tbody tr:hover {
            background: #fcfcfd;
        }

        .premium-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Checkbox */
        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            cursor: pointer;
            border: 2px solid #cbd5e1;
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        /* Student Cell */
        .student-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .student-info h6 {
            margin: 0;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
            white-space: nowrap;
        }

        .student-info span {
            font-size: 0.8rem;
            color: #64748b;
            display: block;
            white-space: nowrap;
        }

        .session-badge {
            background: var(--light-green);
            color: var(--primary-green);
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            border: 1px solid var(--forest-green-lighter);
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Date Cell */
        .date-cell {
            white-space: nowrap;
        }

        .date-cell .date {
            font-weight: 600;
            color: var(--text-dark);
            display: block;
        }

        .date-cell .time {
            color: #64748b;
            font-size: 0.85rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            white-space: nowrap;
        }

        .status-pending {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fcd34d;
        }

        .status-accepted {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #6ee7b7;
        }

        .status-completed {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #93c5fd;
        }

        .status-declined {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .status-rescheduled {
            background: #f5f3ff;
            color: #6d28d9;
            border: 1px solid #c4b5fd;
        }

        /* Nature Badge */
        .nature-badge {
            background: #f1f5f9;
            color: #475569;
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-weight: 500;
        }

        /* Action Buttons */
        .actions-cell {
            display: flex;
            gap: 0.4rem;
            justify-content: flex-end;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-action:hover {
            background: #f1f5f9;
        }

        .btn-action.view:hover {
            color: #0284c7;
            background: #e0f2fe;
        }

        .btn-action.approve:hover {
            color: #059669;
            background: #d1fae5;
        }

        .btn-action.delete:hover {
            color: #dc2626;
            background: #fee2e2;
        }

        /* Empty State */
        .empty-state {
            padding: 3rem 2rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            color: #e2e8f0;
            margin-bottom: 1rem;
        }

        /* Pagination */
        .pagination-wrap {
            padding: 1rem 1.25rem;
            border-top: 1px solid #f1f5f9;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .stats-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-input {
                max-width: 100%;
            }

            .btn-clear-completed {
                margin-left: 0;
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="counselorSidebarToggle" class="d-md-none">
                <i class="bi bi-list"></i>
            </button>

            @include('counselor.sidebar')

            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">

                    <!-- Page Header -->
                    <div class="page-header">
                        <h1 class="page-title">Appointments</h1>
                        <p class="text-muted mb-0 mt-1" style="font-size: 0.95rem;">Manage student sessions and requests</p>
                    </div>

                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-3 d-flex align-items-center py-2">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span class="fw-medium">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-3 d-flex align-items-center py-2">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <span class="fw-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Stats Row -->
                    <div class="stats-row">
                        <div class="stat-card">
                            <div class="stat-icon primary">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ number_format($totalAppointments) }}</h3>
                                <p>Total Bookings</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon warning">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ number_format($pendingAppointments) }}</h3>
                                <p>Pending Requests</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon success">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="stat-info">
                                <h3>{{ number_format($completedAppointments) }}</h3>
                                <p>Completed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Bar -->
                    <form method="GET" action="{{ route('counselor.appointments.index') }}" class="filter-bar">
                        <div class="filter-row">
                            <div class="filter-input position-relative">
                                <i class="bi bi-search input-icon"></i>
                                <input type="text" name="search" placeholder="Search student or ID..."
                                    value="{{ request('search') }}">
                            </div>

                            <select name="status" class="filter-select">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="rescheduled_pending" {{ request('status') == 'rescheduled_pending' ? 'selected' : '' }}>Rescheduled</option>
                                <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined
                                </option>
                            </select>

                            <select name="sort_by" class="filter-select">
                                <option value="date_desc" {{ request('sort_by') == 'date_desc' ? 'selected' : '' }}>Newest
                                    First</option>
                                <option value="date_asc" {{ request('sort_by') == 'date_asc' ? 'selected' : '' }}>Oldest First
                                </option>
                                <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Name A-Z
                                </option>
                            </select>

                            <select name="per_page" class="filter-select" style="min-width: 100px;">
                                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 Per Page</option>
                                <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20 Per Page</option>
                                <option value="30" {{ request('per_page') == '30' ? 'selected' : '' }}>30 Per Page</option>
                                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 Per Page</option>
                                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 Per Page</option>
                            </select>

                            <button type="submit" class="btn-filter">
                                <i class="bi bi-funnel-fill"></i> Filter
                            </button>

                            <a href="{{ route('counselor.appointments.index') }}" class="btn-reset" title="Reset">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>

                            @if($completedAppointments > 0)
                                <button type="button" id="deleteAllCompletedBtn" class="btn-clear-completed">
                                    <i class="bi bi-trash3"></i> Clear Completed
                                </button>
                            @endif
                        </div>
                    </form>

                    <!-- Content Card -->
                    <div class="content-card">
                        <!-- Bulk Actions Bar -->
                        <div class="bulk-bar" id="bulkBar">
                            <span class="count"><span id="selectedCount">0</span> selected</span>
                            <div class="vr bg-white opacity-25" style="height: 20px;"></div>
                            <button type="button" id="bulkApproveBtn" class="btn-bulk approve">
                                <i class="bi bi-check-lg"></i> Approve
                            </button>
                            <button type="button" id="bulkDeleteBtn" class="btn-bulk delete">
                                <i class="bi bi-trash3"></i> Delete
                            </button>
                            <button type="button" id="bulkSmsBtn" class="btn-bulk"
                                style="background: rgba(255, 203, 5, 0.2); color: #fff;">
                                <i class="bi bi-phone"></i> SMS Reminder
                            </button>
                            <button type="button" id="bulkNotifyBtn" class="btn-bulk"
                                style="background: rgba(13, 110, 253, 0.2); color: #fff;">
                                <i class="bi bi-bell-fill"></i> Send Reminder
                            </button>
                            <button type="button" class="btn-close btn-close-white ms-auto" id="closeBulkBar"
                                style="font-size: 0.6rem;"></button>
                        </div>

                        <!-- Hidden Forms for Bulk Actions -->
                        <form id="bulk-approve-form" action="{{ route('counselor.appointments.bulkApprove') }}"
                            method="POST" class="d-none">@csrf</form>
                        <form id="bulk-delete-form" action="{{ route('counselor.appointments.bulkDestroy') }}" method="POST"
                            class="d-none">@csrf @method('DELETE')</form>

                        @if($appointments->count() > 0)
                            <div class="table-responsive">
                                <table class="premium-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px;">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </th>
                                            <th>Student</th>
                                            <th style="width: 110px;">Session</th>
                                            <th style="width: 130px;">Date & Time</th>
                                            <th style="width: 140px;">Status</th>
                                            <th style="width: 120px;">Nature</th>
                                            <th style="width: 100px; text-align: right;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input item-checkbox" type="checkbox"
                                                        value="{{ $appointment->id }}">
                                                </td>
                                                <td>
                                                    <div class="student-cell">
                                                        <img src="{{ $appointment->student->avatar_url }}" alt=""
                                                            class="student-avatar">
                                                        <div class="student-info">
                                                            <h6>{{ $appointment->student->name }}</h6>
                                                            <span>{{ $appointment->student->student_id ?? '-' }} •
                                                                {{ $appointment->student->college ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="session-badge">Session #{{ $appointment->session_number }}</span>
                                                </td>
                                                <td>
                                                    <div class="date-cell">
                                                        <span class="date">{{ $appointment->scheduled_at->format('M d, Y') }}</span>
                                                        <span class="time">{{ $appointment->scheduled_at->format('g:i A') }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @php
                                                        $status = $appointment->status;
                                                        $statusClasses = [
                                                            'pending' => 'status-pending',
                                                            'accepted' => 'status-accepted',
                                                            'completed' => 'status-completed',
                                                            'declined' => 'status-declined',
                                                            'cancelled' => 'status-declined',
                                                            'rescheduled_pending' => 'status-rescheduled'
                                                        ];
                                                        $statusLabels = [
                                                            'pending' => 'Pending',
                                                            'accepted' => 'Approved',
                                                            'completed' => 'Completed',
                                                            'declined' => 'Declined',
                                                            'cancelled' => 'Cancelled',
                                                            'rescheduled_pending' => 'Reschedule'
                                                        ];
                                                    @endphp
                                                    <span class="status-badge {{ $statusClasses[$status] ?? 'status-pending' }}">
                                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="nature-badge">{{ $appointment->nature_of_problem ?? 'Unspecified' }}</span>
                                                </td>
                                                <td>
                                                    <div class="actions-cell">
                                                        <a href="{{ route('counselor.appointments.show', $appointment->id) }}"
                                                            class="btn-action view" title="View">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </a>

                                                        @if($appointment->status === 'pending' || $appointment->status === 'rescheduled_pending')
                                                            <form
                                                                action="{{ route('counselor.appointments.accept', $appointment->id) }}"
                                                                method="POST" class="d-inline approve-form">
                                                                @csrf @method('PATCH')
                                                                <button type="submit" class="btn-action approve" title="Approve">
                                                                    <i class="bi bi-check-lg"></i>
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <button type="button" class="btn-action delete" title="Delete"
                                                            onclick="confirmDelete({{ $appointment->id }})">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                        <form id="delete-form-{{ $appointment->id }}"
                                                            action="{{ route('counselor.appointments.destroy', $appointment->id) }}"
                                                            method="POST" class="d-none">
                                                            @csrf @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="pagination-wrap">
                                {{ $appointments->links('vendor.pagination.premium') }}
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-calendar-x"></i>
                                <h5 class="fw-bold mb-2">No Appointments Found</h5>
                                <p class="text-muted mb-0">Try adjusting your filters or wait for new bookings.</p>
                            </div>
                        @endif
                    </div>

                    <!-- SMS Queue Modal -->
                    <div class="modal fade" id="smsQueueModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header border-0 pb-0" style="padding: 1.5rem;">
                                    <h5 class="fw-bold mb-0">SMS Reminder Queue</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="padding: 1.5rem;">
                                    <div id="desktopWarning" class="alert alert-warning border-0 rounded-3 mb-4 d-none">
                                        <div class="d-flex gap-2">
                                            <i class="bi bi-laptop fs-5"></i>
                                            <small><strong>Laptop detected.</strong> For the best experience and to use your
                                                own mobile load, open this dashboard on your
                                                <strong>smartphone</strong>.</small>
                                        </div>
                                    </div>
                                    <div class="queue-container" id="smsQueueList">
                                        <!-- Queue items will be injected here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle
            const sidebar = document.querySelector('.custom-sidebar');
            const toggle = document.getElementById('counselorSidebarToggle');
            if (toggle && sidebar) {
                toggle.addEventListener('click', () => sidebar.classList.toggle('show'));
                document.addEventListener('click', (e) => {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show') &&
                        !sidebar.contains(e.target) && !toggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }

            // Bulk selection
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const bulkBar = document.getElementById('bulkBar');
            const selectedCountSpan = document.getElementById('selectedCount');
            const closeBulkBar = document.getElementById('closeBulkBar');

            function updateBulkBar() {
                const checked = document.querySelectorAll('.item-checkbox:checked');
                selectedCountSpan.textContent = checked.length;
                if (checked.length > 0) {
                    bulkBar.classList.add('active');
                } else {
                    bulkBar.classList.remove('active');
                    if (selectAll) selectAll.checked = false;
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateBulkBar();
                });
            }

            checkboxes.forEach(cb => cb.addEventListener('change', updateBulkBar));

            if (closeBulkBar) {
                closeBulkBar.addEventListener('click', () => {
                    checkboxes.forEach(cb => cb.checked = false);
                    if (selectAll) selectAll.checked = false;
                    updateBulkBar();
                });
            }

            // Bulk Approve
            const bulkApproveBtn = document.getElementById('bulkApproveBtn');
            const bulkApproveForm = document.getElementById('bulk-approve-form');
            if (bulkApproveBtn && bulkApproveForm) {
                bulkApproveBtn.addEventListener('click', () => {
                    const ids = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
                    if (ids.length === 0) return;

                    Swal.fire({
                        title: 'Approve Selected?',
                        text: `You are about to approve ${ids.length} appointment(s).`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#1f7a2d',
                        confirmButtonText: 'Yes, Approve'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            bulkApproveForm.innerHTML = '@csrf';
                            ids.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'ids[]';
                                input.value = id;
                                bulkApproveForm.appendChild(input);
                            });
                            bulkApproveForm.submit();
                        }
                    });
                });
            }

            // Bulk Delete
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');
            if (bulkDeleteBtn && bulkDeleteForm) {
                bulkDeleteBtn.addEventListener('click', () => {
                    const ids = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
                    if (ids.length === 0) return;

                    Swal.fire({
                        title: 'Delete Selected?',
                        text: `You are about to delete ${ids.length} appointment(s). This cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'Yes, Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            bulkDeleteForm.innerHTML = '@csrf @method("DELETE")';
                            ids.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'ids[]';
                                input.value = id;
                                bulkDeleteForm.appendChild(input);
                            });
                            bulkDeleteForm.submit();
                        }
                    });
                });
            }

            // Clear All Completed
            const deleteAllCompletedBtn = document.getElementById('deleteAllCompletedBtn');
            if (deleteAllCompletedBtn) {
                deleteAllCompletedBtn.addEventListener('click', () => {
                    Swal.fire({
                        title: 'Clear All Completed?',
                        text: "This will permanently delete all completed appointments!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'Yes, delete all'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ route("counselor.appointments.bulk.deleteCompleted") }}', {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Deleted!', data.message, 'success').then(() => location.reload());
                                    } else {
                                        Swal.fire('Error', 'Something went wrong.', 'error');
                                    }
                                });
                        }
                    });
                });
            }
            // Bulk SMS Functionality
            const bulkSmsBtn = document.getElementById('bulkSmsBtn');
            const smsQueueModalElement = document.getElementById('smsQueueModal');
            let smsQueueModal = null;
            if (smsQueueModalElement) {
                smsQueueModal = new bootstrap.Modal(smsQueueModalElement);
            }

            if (bulkSmsBtn) {
                bulkSmsBtn.addEventListener('click', () => {
                    const ids = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
                    if (ids.length === 0) return;

                    Swal.fire({
                        title: 'Prepare SMS Reminders?',
                        text: `You have selected ${ids.length} students. This will open your messaging app for each one.`,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#1f7a2d',
                        confirmButtonText: 'Start Queue'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ route("counselor.appointments.bulkSmsPrepare") }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ ids: ids })
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        renderSmsQueue(data.students);
                                        smsQueueModal.show();

                                        // Check if probably on desktop
                                        if (window.innerWidth > 768) {
                                            document.getElementById('desktopWarning').classList.remove('d-none');
                                        }
                                    }
                                });
                        }
                    });
                });
            }

            function renderSmsQueue(students) {
                const list = document.getElementById('smsQueueList');
                list.innerHTML = '';

                students.forEach((student, index) => {
                    const card = document.createElement('div');
                    card.className = 'card border-0 bg-light mb-3 rounded-3 overflow-hidden';
                    card.style.transition = 'all 0.3s';
                    card.id = `sms-item-${student.id}`;

                    const encodedMsg = encodeURIComponent(student.message);
                    const smsHref = `sms:${student.phone}?body=${encodedMsg}`;

                    card.innerHTML = `
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold mb-0">${student.name}</h6>
                                        <span class="badge bg-white text-muted border py-1 px-2" style="font-size: 0.7rem;">${student.phone || 'No Number'}</span>
                                    </div>
                                    <p class="small text-muted mb-3 italic" style="font-size: 0.8rem; line-height: 1.4;">"${student.message}"</p>
                                    <a href="${smsHref}" class="btn btn-success btn-sm w-100 fw-bold sms-send-trigger" 
                                       onclick="markAsSent(${student.id})">
                                        <i class="bi bi-chat-dots-fill me-1"></i> Send via Messaging App
                                    </a>
                                </div>
                            `;
                    list.appendChild(card);
                });
            }

            window.markAsSent = function (id) {
                const card = document.getElementById(`sms-item-${id}`);
                if (card) {
                    card.style.opacity = '0.5';
                    card.style.pointerEvents = 'none';
                    const btn = card.querySelector('.sms-send-trigger');
                    btn.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Triggered';
                    btn.className = 'btn btn-secondary btn-sm w-100 fw-bold';
                }
            };

            // Bulk Automated Reminder (In-App + Email)
            const bulkNotifyBtn = document.getElementById('bulkNotifyBtn');
            if (bulkNotifyBtn) {
                bulkNotifyBtn.addEventListener('click', () => {
                    const ids = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
                    if (ids.length === 0) return;

                    Swal.fire({
                        title: 'Send Automated Reminders?',
                        text: `This will send an in-app and email notification to ${ids.length} student(s).`,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#0d6efd',
                        confirmButtonText: 'Yes, Notify All'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route("counselor.appointments.bulkReminder") }}';
                            form.innerHTML = '@csrf';

                            ids.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'ids[]';
                                input.value = id;
                                form.appendChild(input);
                            });

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Delete Appointment?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection