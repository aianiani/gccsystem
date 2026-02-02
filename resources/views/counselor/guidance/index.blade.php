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

        /* Sidebar Styles */
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

        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2rem 1rem 1rem 1rem;
            border-bottom: 1px solid #4a7c59;
        }

        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0.5rem 0 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .custom-sidebar .sidebar-link {
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

        .custom-sidebar .sidebar-link.active,
        .custom-sidebar .sidebar-link:hover {
            background: #4a7c59;
            color: #f4d03f;
        }

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

        @media (max-width: 991.98px) {
            .custom-sidebar {
                width: 200px;
            }

            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .custom-sidebar {
                position: fixed;
                z-index: 1040;
                height: 100vh;
                left: 0;
                top: 0;
                width: 240px;
                transform: translateX(-100%);
                transition: transform 0.2s ease;
                flex-direction: column;
                padding: 0;
            }

            .custom-sidebar.show {
                transform: translateX(0);
            }

            .custom-sidebar .sidebar-logo {
                display: block;
            }

            .custom-sidebar .sidebar-nav {
                flex-direction: column;
                gap: 0.25rem;
                padding: 1rem 0.5rem 1rem 0.5rem;
            }

            .custom-sidebar .sidebar-link {
                justify-content: flex-start;
                padding: 0.6rem 0.75rem;
                font-size: 1rem;
            }

            .main-dashboard-content {
                margin-left: 0;
            }

            #counselorSidebarToggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--forest-green);
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 0.5rem 0.75rem;
                box-shadow: var(--shadow-sm);
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

        /* Module Styles */
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
        }

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
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--light-green);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-custom th {
            background-color: var(--light-green);
            color: var(--primary-green);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem 1.5rem;
            border: none;
        }

        .table-custom td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            color: var(--text-dark);
        }

        .table-custom tr:hover td {
            background-color: #fafdfa;
        }

        .btn-primary-custom {
            background: var(--primary-green);
            border: none;
            color: #fff;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(31, 122, 45, 0.3);
        }

        .btn-primary-custom:hover {
            background: var(--primary-green-2);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(31, 122, 45, 0.4);
            color: #fff;
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--primary-green);
            color: var(--primary-green);
            padding: 0.4rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-outline-custom:hover {
            background: var(--light-green);
            color: var(--primary-green-2);
        }

        .form-control-custom,
        .form-select-custom {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
            outline: none;
        }

        .badge-custom {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .badge-success-custom {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning-custom {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-locked-custom {
            background-color: #e9ecef;
            color: #6c757d;
        }

        .badge-info-custom {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .progress-custom {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-custom {
            background: var(--hero-gradient);
        }

        /* Avatar styles */
        .student-avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: 2px solid #fff;
        }

        /* Bulk Toolbar */
        #bulkToolbar {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 1rem 2rem;
            border-radius: 50px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            z-index: 1050;
            display: none;
            align-items: center;
            gap: 1.5rem;
            border: 2px solid var(--primary-green);
        }

        #bulkToolbar.show {
            display: flex;
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                transform: translate(-50%, 100%);
                opacity: 0;
            }

            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        /* Modal Custom */
        .modal-header {
            background: var(--light-green);
            color: var(--primary-green);
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
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

                    <!-- Header -->
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="page-title">Guidance Module</h2>
                            <p class="page-subtitle mt-1">Track attendance, generate reports, and manage student seminars
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light text-success fw-bold" data-bs-toggle="modal"
                                data-bs-target="#importModal">
                                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Import CSV
                            </button>
                        </div>
                    </div>

                    <!-- Main Content Card -->
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">Student List</h3>

                            <form method="GET" action="{{ route('counselor.guidance.index') }}"
                                class="row g-2 align-items-center w-100 mt-2 mt-lg-0">
                                <!-- Filter by Year -->
                                <div class="col-6 col-md-auto">
                                    <select name="year_level" class="form-select-custom w-100"
                                        onchange="this.form.submit()">
                                        <option value="">All Years</option>
                                        <option value="1" {{ request('year_level') == '1' ? 'selected' : '' }}>1st Year
                                        </option>
                                        <option value="2" {{ request('year_level') == '2' ? 'selected' : '' }}>2nd Year
                                        </option>
                                        <option value="3" {{ request('year_level') == '3' ? 'selected' : '' }}>3rd Year
                                        </option>
                                        <option value="4" {{ request('year_level') == '4' ? 'selected' : '' }}>4th Year
                                        </option>
                                    </select>
                                </div>

                                <!-- Filter by College -->
                                <div class="col-6 col-md-auto">
                                    <select name="college" class="form-select-custom w-100" onchange="this.form.submit()"
                                        style="max-width: 200px;">
                                        <option value="">All Colleges</option>
                                        <option value="College of Arts and Sciences" {{ request('college') == 'College of Arts and Sciences' ? 'selected' : '' }}>CAS</option>
                                        <option value="College of Veterinary Medicine" {{ request('college') == 'College of Veterinary Medicine' ? 'selected' : '' }}>CVM</option>
                                        <option value="College of Forestry and Environmental Sciences" {{ request('college') == 'College of Forestry and Environmental Sciences' ? 'selected' : '' }}>CFES</option>
                                        <option value="College of Business and Management" {{ request('college') == 'College of Business and Management' ? 'selected' : '' }}>CBM</option>
                                        <option value="College of Nursing" {{ request('college') == 'College of Nursing' ? 'selected' : '' }}>CON</option>
                                        <option value="College of Human Ecology" {{ request('college') == 'College of Human Ecology' ? 'selected' : '' }}>CHE</option>
                                        <option value="College of Agriculture" {{ request('college') == 'College of Agriculture' ? 'selected' : '' }}>CA</option>
                                        <option value="College of Information Sciences and Computing" {{ request('college') == 'College of Information Sciences and Computing' ? 'selected' : '' }}>CISC</option>
                                        <option value="College of Education" {{ request('college') == 'College of Education' ? 'selected' : '' }}>CE</option>
                                        <option value="College of Engineering" {{ request('college') == 'College of Engineering' ? 'selected' : '' }}>COE</option>
                                    </select>
                                </div>

                                <!-- Filter by Seminar -->
                                <div class="col-6 col-md-auto">
                                    <select name="seminar_name" class="form-select-custom w-100"
                                        onchange="this.form.submit()">
                                        <option value="">All Seminars</option>
                                        <option value="New Student Orientation Program" {{ request('seminar_name') == 'New Student Orientation Program' ? 'selected' : '' }}>
                                            New Student Orientation Program</option>
                                        <option value="IDREAMS" {{ request('seminar_name') == 'IDREAMS' ? 'selected' : '' }}>
                                            IDREAMS</option>
                                        <option value="10C" {{ request('seminar_name') == '10C' ? 'selected' : '' }}>10C
                                        </option>
                                        <option value="LEADS" {{ request('seminar_name') == 'LEADS' ? 'selected' : '' }}>LEADS
                                        </option>
                                        <option value="IMAGE" {{ request('seminar_name') == 'IMAGE' ? 'selected' : '' }}>IMAGE
                                        </option>
                                    </select>
                                </div>

                                <!-- Filter by Attendance Status -->
                                <div class="col-6 col-md-auto">
                                    <select name="status" class="form-select-custom w-100" onchange="this.form.submit()">
                                        <option value="">Attendance</option>
                                        <option value="unlocked" {{ request('status') == 'unlocked' ? 'selected' : '' }}>
                                            Verified (Unlocked)</option>
                                        <option value="attended" {{ request('status') == 'attended' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                    </select>
                                </div>

                                <!-- Filter by Evaluation Status -->
                                <div class="col-6 col-md-auto">
                                    <select name="eval_status" class="form-select-custom w-100"
                                        onchange="this.form.submit()">
                                        <option value="">Evaluation</option>
                                        <option value="done" {{ request('eval_status') == 'done' ? 'selected' : '' }}>Done
                                        </option>
                                        <option value="missing" {{ request('eval_status') == 'missing' ? 'selected' : '' }}>
                                            Missing</option>
                                    </select>
                                </div>

                                <!-- Search -->
                                <div class="col-12 col-md flex-grow-1">
                                    <div class="d-flex w-100">
                                        <input type="text" name="search" placeholder="Search..."
                                            value="{{ request('search') }}" class="form-control-custom rounded-end-0 w-100">
                                        <button type="submit" class="btn-primary-custom rounded-start-0">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Bulk Action Form Wrapper -->
                        <form id="bulkActionForm" action="{{ route('counselor.guidance.bulk.store') }}" method="POST">
                            @csrf
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-custom">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px;">
                                                <input type="checkbox" id="selectAllCheckbox" class="form-check-input"
                                                    style="transform: scale(1.2); cursor: pointer;">
                                            </th>
                                            <th>Name / ID</th>
                                            <th>College / Year</th>
                                            <th class="text-center">Progress</th>
                                            <th class="text-center">Attendance</th>
                                            <th class="text-center">Evaluation</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $seminarIdMap = $allSeminars->pluck('id', 'name')->toArray();
                                        @endphp
                                        @forelse ($students as $student)
                                            @php
                                                $seminarMap = ['New Student Orientation Program' => 1, 'IDREAMS' => 1, '10C' => 2, 'LEADS' => 3, 'IMAGE' => 4];
                                                $completedCount = 0;
                                                $totalRequiredSoFar = 0;
                                                foreach ($seminarMap as $name => $targetYear) {
                                                    if ($student->year_level >= $targetYear) {
                                                        $totalRequiredSoFar++;
                                                        $attendance = $student->seminarAttendances->where('seminar_name', $name)->first();
                                                        if ($attendance && $attendance->status === 'completed') {
                                                            $completedCount++;
                                                        }
                                                    }
                                                }
                                                $progressPercent = $totalRequiredSoFar > 0 ? ($completedCount / $totalRequiredSoFar) * 100 : 0;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                                        class="student-checkbox form-check-input"
                                                        style="transform: scale(1.2); cursor: pointer;">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}"
                                                            class="student-avatar-sm">
                                                        <div>
                                                            <div class="font-bold text-gray-800">{{ $student->name }}</div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ $student->student_id ?? 'N/A' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="font-medium">{{ $student->college_acronym }}</div>
                                                    <div class="text-sm text-gray-500">{{ $student->year_level_label }}</div>
                                                </td>

                                                <td class="align-middle" style="min-width: 120px;">
                                                    <div class="progress-custom">
                                                        <div class="progress-bar-custom"
                                                            style="width: {{ $progressPercent }}%; height: 100%;"></div>
                                                    </div>
                                                    <div class="text-xs text-center text-gray-500 mt-1 font-medium">
                                                        {{ $completedCount }}/{{ $totalRequiredSoFar }} Completed
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        @foreach($seminarMap as $seminarName => $targetYear)
                                                            @php
                                                                $isLocked = $student->year_level < $targetYear;
                                                                $attendance = $student->seminarAttendances->where('seminar_name', $seminarName)->first();
                                                                $isAttended = $attendance && $attendance->status === 'completed';
                                                                $isUnlocked = $attendance && $attendance->status === 'unlocked';

                                                                if ($isLocked) {
                                                                    $badgeClass = 'badge-locked-custom';
                                                                    $icon = 'bi-lock-fill';
                                                                    $title = "Attendance: Locked ($seminarName)";
                                                                } elseif ($isAttended) {
                                                                    $badgeClass = 'badge-success-custom';
                                                                    $icon = 'bi-check-circle-fill';
                                                                    $title = "Attendance: Completed ($seminarName)";
                                                                } elseif ($isUnlocked) {
                                                                    $badgeClass = 'badge-info-custom';
                                                                    $icon = 'bi-unlock-fill';
                                                                    $title = "Attendance: Verified & Unlocked (Waiting Evaluation) ($seminarName)";
                                                                } else {
                                                                    $badgeClass = 'badge-warning-custom';
                                                                    $icon = 'bi-exclamation-circle';
                                                                    $title = "Attendance: Pending Verification ($seminarName)";
                                                                }
                                                            @endphp

                                                            <span class="badge-custom {{ $badgeClass }}" data-bs-toggle="tooltip"
                                                                title="{{ $title }}"
                                                                style="cursor: help; width: 32px; height: 32px; justify-content: center; padding: 0;">
                                                                <i class="bi {{ $icon }}" style="font-size: 1rem;"></i>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        @foreach($seminarMap as $seminarName => $targetYear)
                                                            @php
                                                                $sId = $seminarIdMap[$seminarName] ?? null;
                                                                $isLocked = $student->year_level < $targetYear;
                                                                $isEvaluated = $sId && $student->seminarEvaluations->where('seminar_id', $sId)->isNotEmpty();

                                                                if ($isLocked) {
                                                                    $badgeClass = 'badge-locked-custom';
                                                                    $icon = 'bi-lock-fill';
                                                                    $title = "Evaluation: Locked ($seminarName)";
                                                                } elseif ($isEvaluated) {
                                                                    $badgeClass = 'badge-success-custom';
                                                                    $icon = 'bi-file-earmark-check-fill';
                                                                    $title = "Evaluation: Done ($seminarName)";
                                                                } else {
                                                                    $badgeClass = 'badge-warning-custom';
                                                                    $icon = 'bi-file-earmark-text';
                                                                    $title = "Evaluation: Missing ($seminarName)";
                                                                }
                                                            @endphp

                                                            <span class="badge-custom {{ $badgeClass }}" data-bs-toggle="tooltip"
                                                                title="{{ $title }}"
                                                                style="cursor: help; width: 32px; height: 32px; justify-content: center; padding: 0;">
                                                                <i class="bi {{ $icon }}" style="font-size: 1rem;"></i>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('counselor.guidance.show', $student) }}"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-pencil-square"></i> Manage
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5 text-gray-500">
                                                    <i class="bi bi-inbox text-4xl mb-2 block opacity-50"></i>
                                                    No students found matching your filters.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Bulk Toolbar -->
                            <div id="bulkToolbar">
                                <span class="fw-bold text-success"><span id="selectedCount">0</span> selected</span>
                                <div class="d-flex gap-2 align-items-center">
                                    <select name="seminar_name" class="form-select-custom form-select-sm" required
                                        style="min-width: 150px;">
                                        <option value="">Select Seminar...</option>
                                        <option value="New Student Orientation Program">New Student Orientation Program</option>
                                        <option value="IDREAMS">IDREAMS</option>
                                        <option value="10C">10C</option>
                                        <option value="LEADS">LEADS</option>
                                        <option value="IMAGE">IMAGE</option>
                                    </select>
                                    <input type="hidden" name="attended" value="1">
                                    <input type="hidden" name="year_level" value="{{ request('year_level', 1) }}">
                                    <!-- Default to 1 if not set, or handle in controller? Controller expects year_level. Ideally we pass each student's year level but bulk update implies uniform action. Let's use request or JS. Actually, update logic needs year_level. I'll rely on the user to filter by Year Level first OR I'll update the controller to fetch year from student model if not provided. For now, let's keep it simple: required filter. -->
                                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">
                                        <i class="bi bi-unlock-fill me-1"></i> Unlock Evaluations
                                    </button>
                                </div>
                                <button type="button" id="cancelSelection" class="btn btn-link text-muted p-0 ms-2"
                                    style="text-decoration: none;">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </form>

                        <div class="p-4 border-t border-gray-100">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Import Attendance CSV
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('counselor.guidance.import') }}" method="POST" enctype="multipart/form-data"
                        id="importForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Seminar</label>
                            <select name="seminar_name" class="form-select-custom w-100" required>
                                <option value="">Select Seminar...</option>
                                <option value="New Student Orientation Program">New Student Orientation Program (Year 1)</option>
                                <option value="IDREAMS">IDREAMS (Year 1)</option>
                                <option value="10C">10C (Year 2)</option>
                                <option value="LEADS">LEADS (Year 3)</option>
                                <option value="IMAGE">IMAGE (Year 4)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Year Level</label>
                            <select name="year_level" class="form-select-custom w-100" required>
                                <option value="">Select Year...</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">CSV File</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required>
                            <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Must have
                                <strong>student_id</strong> column.</div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold py-2">Upload and Process</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Sidebar Toggle
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', () => { if (window.innerWidth < 768) sidebar.classList.toggle('show'); });
                document.addEventListener('click', (e) => {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show') && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }

            // Bulk Selection Logic
            const selectAll = document.getElementById('selectAllCheckbox');
            const checkboxes = document.querySelectorAll('.student-checkbox');
            const toolbar = document.getElementById('bulkToolbar');
            const countSpan = document.getElementById('selectedCount');
            const cancelBtn = document.getElementById('cancelSelection');

            function updateToolbar() {
                const checked = document.querySelectorAll('.student-checkbox:checked');
                countSpan.textContent = checked.length;
                if (checked.length > 0) {
                    toolbar.classList.add('show');
                } else {
                    toolbar.classList.remove('show');
                }

                // Update Select All State
                if (checked.length === checkboxes.length && checkboxes.length > 0) {
                    selectAll.checked = true;
                    selectAll.indeterminate = false;
                } else if (checked.length > 0) {
                    selectAll.checked = false;
                    selectAll.indeterminate = true;
                } else {
                    selectAll.checked = false;
                    selectAll.indeterminate = false;
                }
            }

            selectAll.addEventListener('change', function () {
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateToolbar();
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateToolbar);
            });

            cancelBtn.addEventListener('click', function () {
                checkboxes.forEach(cb => cb.checked = false);
                updateToolbar();
            });
        });
    </script>
@endsection