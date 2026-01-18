@extends('layouts.app')

@section('content')
    <style>
        :root {
            --forest-green: #1f7a2d;
            --forest-green-light: #4a7c59;
            --forest-green-lighter: #e8f5e8;
            --yellow-maize: #f4d03f;
            --gray-50: #f8f9fa;
            --gray-100: #dee2e6;
            --gray-600: #6c757d;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hero-gradient: linear-gradient(135deg, var(--forest-green) 0%, #13601f 100%);
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

        .page-header-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-header-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
        }

        .page-header-card p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--gray-50);
            color: var(--forest-green);
            font-weight: 600;
            border-bottom: 2px solid var(--gray-100);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: var(--forest-green-lighter);
        }

        .action-btn {
            transition: all 0.2s ease;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--gray-600);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .filter-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .filter-row {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
            display: block;
        }

        .filter-group .form-control,
        .filter-group .form-select {
            border: 1px solid var(--gray-100);
            border-radius: 8px;
            padding: 0.625rem 0.875rem;
            transition: all 0.2s ease;
        }

        .filter-group .form-control:focus,
        .filter-group .form-select:focus {
            border-color: var(--forest-green);
            box-shadow: 0 0 0 0.2rem rgba(31, 122, 45, 0.1);
        }

        .search-input-group {
            position: relative;
        }

        .search-input-group .form-control {
            padding-left: 2.5rem;
        }

        .search-input-group i {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-600);
            z-index: 1;
        }

        .bulk-selected-count {
            font-weight: bold;
            color: var(--forest-green);
            background: var(--forest-green-lighter);
            padding: 5px 12px;
            border-radius: 20px;
        }

        /* Improved Checkbox Visibility */
        .form-check-input {
            border: 2px solid var(--gray-600);
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--forest-green);
            border-color: var(--forest-green);
        }

        .filter-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-filter {
            background: var(--forest-green);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-filter:hover {
            background: #13601f;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .btn-reset {
            background: var(--gray-50);
            color: var(--forest-green);
            border: 1px solid var(--gray-100);
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-reset:hover {
            background: var(--gray-100);
            border-color: var(--forest-green);
        }

        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
            }

            .filter-actions {
                width: 100%;
            }

            .filter-actions .btn {
                flex: 1;
            }
        }
    </style>

    <div class="main-dashboard-inner home-zoom">
        <div class="page-header-card">
            <div>
                <h1><i class="bi bi-people me-2"></i>Users Management</h1>
                <p>Manage system users and their roles</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal"
                    data-bs-target="#importDeleteModal">
                    <i class="bi bi-person-x me-2"></i>Import List to Delete
                </button>
                <a href="{{ route('users.export', request()->all()) }}" class="btn btn-success btn-lg">
                    <i class="bi bi-file-earmark-arrow-down me-2"></i>Export to Excel
                </a>
                <a href="{{ route('users.create') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-person-plus me-2"></i>Add New User
                </a>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="filter-card">
            <form method="GET" action="{{ route('users.index') }}" id="filterForm">
                <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
                <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
                <input type="hidden" name="per_page" value="{{ request('per_page', 15) }}">

                <div class="row g-2 align-items-end mb-2">
                    <!-- Search -->
                    <div class="col-md-4">
                        <label for="search" class="form-label text-success fw-semibold small text-uppercase mb-1">
                            <i class="bi bi-search me-1"></i>Search
                        </label>
                        <input type="text" class="form-control" id="search" name="search"
                            placeholder="Name, email, or ID..." value="{{ request('search') }}">
                    </div>

                    <!-- College -->
                    <div class="col-md-3">
                        <label for="college" class="form-label text-success fw-semibold small text-uppercase mb-1">
                            <i class="bi bi-building me-1"></i>College
                        </label>
                        <select class="form-select" id="college" name="college" onchange="this.form.submit()">
                            <option value="">All Colleges</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college }}" {{ request('college') == $college ? 'selected' : '' }}>
                                    {{ $college }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course -->
                    <div class="col-md-3">
                        <label for="course" class="form-label text-success fw-semibold small text-uppercase mb-1">
                            <i class="bi bi-book me-1"></i>Course
                        </label>
                        <select class="form-select" id="course" name="course" onchange="this.form.submit()">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>
                                    {{ $course }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year Level -->
                    <div class="col-md-2">
                        <label for="year_level" class="form-label text-success fw-semibold small text-uppercase mb-1">
                            <i class="bi bi-calendar3 me-1"></i>Year
                        </label>
                        <select class="form-select" id="year_level" name="year_level" onchange="this.form.submit()">
                            <option value="">All Years</option>
                            <option value="1st Year" {{ request('year_level') === '1st Year' ? 'selected' : '' }}>1st Year
                            </option>
                            <option value="2nd Year" {{ request('year_level') === '2nd Year' ? 'selected' : '' }}>2nd Year
                            </option>
                            <option value="3rd Year" {{ request('year_level') === '3rd Year' ? 'selected' : '' }}>3rd Year
                            </option>
                            <option value="4th Year" {{ request('year_level') === '4th Year' ? 'selected' : '' }}>4th Year
                            </option>
                            <option value="Graduated" {{ request('year_level') === 'Graduated' ? 'selected' : '' }}>Graduated
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row g-2 align-items-end">
                    <!-- Role -->
                    <div class="col-md-2">
                        <label for="role" class="form-label text-success fw-semibold small text-uppercase mb-1">
                            <i class="bi bi-person-badge me-1"></i>Role
                        </label>
                        <select class="form-select" id="role" name="role" onchange="this.form.submit()">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Student</option>
                            <option value="counselor" {{ request('role') === 'counselor' ? 'selected' : '' }}>Counselor
                            </option>
                        </select>
                    </div>

                    <!-- Sex (Gender) -->
                    <div class="col-md-2">
                        <label for="gender" class="form-label text-success fw-semibold small text-uppercase mb-1">
                            <i class="bi bi-gender-ambiguous me-1"></i>Sex
                        </label>
                        <select class="form-select" id="gender" name="gender" onchange="this.form.submit()">
                            <option value="">All</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender }}" {{ request('gender') == $gender ? 'selected' : '' }}>
                                    {{ ucfirst($gender) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-2">
                        <label for="status" class="form-label text-success fw-semibold small text-uppercase mb-1">
                            <i class="bi bi-toggle-on me-1"></i>Status
                        </label>
                        <select class="form-select" id="status" name="status" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="col-md-3">
                        <label for="date_from" class="form-label text-success fw-semibold small text-uppercase mb-1">
                            <i class="bi bi-calendar-event me-1"></i>From Date
                        </label>
                        <input type="date" class="form-control" id="date_from" name="date_from"
                            value="{{ request('date_from') }}" onchange="this.form.submit()">
                    </div>

                    <!-- Date To -->
                    <div class="col-md-3">
                        <label for="date_to" class="form-label text-success fw-semibold small text-uppercase mb-1">
                            <i class="bi bi-calendar-event me-1"></i>To Date
                        </label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                value="{{ request('date_to') }}" onchange="this.form.submit()">
                            @if(request()->anyFilled(['search', 'college', 'course', 'year_level', 'role', 'gender', 'status', 'date_from', 'date_to']))
                                <a href="{{ route('users.index') }}" class="btn btn-outline-danger" title="Clear Filters">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="main-content-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-people me-2"></i>All Users</h5>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">{{ $users->total() }} total users</span>
                    @if(request()->hasAny(['search', 'role', 'status', 'registration_status']))
                        <span class="badge bg-info">{{ $users->count() }} filtered</span>
                    @endif
                    <span class="badge bg-success">{{ $users->where('is_active', true)->count() }} active</span>
                </div>
            </div>
            <div class="card-body p-0">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="ps-4">
                                        <a href="?{{ http_build_query(array_merge(request()->except(['sort', 'direction']), ['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                            class="text-decoration-none text-dark d-flex align-items-center gap-1 {{ request('sort') === 'name' ? 'fw-bold text-success' : '' }}">
                                            User
                                            @if(request('sort') === 'name')
                                                <i class="bi bi-chevron-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="bi bi-chevron-expand text-muted opacity-50"
                                                    style="font-size: 0.7rem;"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?{{ http_build_query(array_merge(request()->except(['sort', 'direction']), ['sort' => 'email', 'direction' => request('sort') === 'email' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                            class="text-decoration-none text-dark d-flex align-items-center gap-1 {{ request('sort') === 'email' ? 'fw-bold text-success' : '' }}">
                                            Email
                                            @if(request('sort') === 'email')
                                                <i class="bi bi-chevron-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="bi bi-chevron-expand text-muted opacity-50"
                                                    style="font-size: 0.7rem;"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?{{ http_build_query(array_merge(request()->except(['sort', 'direction']), ['sort' => 'role', 'direction' => request('sort') === 'role' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                            class="text-decoration-none text-dark d-flex align-items-center gap-1 {{ request('sort') === 'role' ? 'fw-bold text-success' : '' }}">
                                            Role
                                            @if(request('sort') === 'role')
                                                <i class="bi bi-chevron-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="bi bi-chevron-expand text-muted opacity-50"
                                                    style="font-size: 0.7rem;"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?{{ http_build_query(array_merge(request()->except(['sort', 'direction']), ['sort' => 'is_active', 'direction' => request('sort') === 'is_active' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                            class="text-decoration-none text-dark d-flex align-items-center gap-1 {{ request('sort') === 'is_active' ? 'fw-bold text-success' : '' }}">
                                            Status
                                            @if(request('sort') === 'is_active')
                                                <i class="bi bi-chevron-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="bi bi-chevron-expand text-muted opacity-50"
                                                    style="font-size: 0.7rem;"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a href="?{{ http_build_query(array_merge(request()->except(['sort', 'direction']), ['sort' => 'created_at', 'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}"
                                            class="text-decoration-none text-dark d-flex align-items-center gap-1 {{ request('sort') === 'created_at' || !request('sort') ? 'fw-bold text-success' : '' }}">
                                            Joined
                                            @if(request('sort') === 'created_at' || !request('sort'))
                                                <i
                                                    class="bi bi-chevron-{{ request('direction', 'desc') === 'asc' ? 'up' : 'down' }}"></i>
                                            @else
                                                <i class="bi bi-chevron-expand text-muted opacity-50"
                                                    style="font-size: 0.7rem;"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr data-user-id="{{ $user->id }}">
                                        <td class="ps-4">
                                            <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}" {{ $user->id === auth()->id() ? 'disabled title="Cannot select yourself"' : '' }}>
                                        </td>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle me-3 shadow"
                                                    style="width: 45px; height: 45px;">
                                                    <img src="{{ $user->avatar_url }}" alt="Avatar" class="rounded-circle"
                                                        width="36" height="36">
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $user->name }}</div>
                                                    @if($user->id === auth()->id())
                                                        <small class="text-primary fw-medium">
                                                            <i class="bi bi-star-fill me-1"></i>You
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-envelope text-muted me-2"></i>
                                                {{ $user->email }}
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $badgeColor = match ($user->role) {
                                                    'admin' => 'danger',
                                                    'student' => 'primary',
                                                    'counselor' => 'success',
                                                    default => 'secondary'
                                                };
                                                $icon = match ($user->role) {
                                                    'admin' => 'shield-fill',
                                                    'student' => 'person',
                                                    'counselor' => 'person-badge',
                                                    default => 'person'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $badgeColor }} fs-6 px-3 py-2">
                                                <i class="bi bi-{{ $icon }} me-1"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $user->isActive() ? 'success' : 'danger' }} fs-6 px-3 py-2"
                                                data-bs-toggle="tooltip"
                                                title="{{ $user->isActive() ? 'User can log in and access the system' : 'User account is deactivated' }}">
                                                <i class="bi bi-{{ $user->isActive() ? 'check-circle' : 'x-circle' }} me-1"></i>
                                                {{ $user->isActive() ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="align-middle" style="min-width: 150px;">
                                            <div class="d-flex align-items-center gap-2 flex-nowrap">
                                                <i class="bi bi-calendar text-muted" style="font-size: 1.1rem;"></i>
                                                <span style="white-space: nowrap;">{{ $user->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end pe-2 align-middle">
                                            <div class="d-flex align-items-center justify-content-end gap-1 flex-nowrap">
                                                <a href="{{ route('users.show', $user) }}"
                                                    class="btn btn-outline-primary btn-sm p-1 rounded-circle shadow-sm d-flex align-items-center justify-content-center action-btn"
                                                    data-bs-toggle="tooltip" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('users.edit', $user) }}"
                                                    class="btn btn-outline-warning btn-sm p-1 rounded-circle shadow-sm d-flex align-items-center justify-content-center action-btn"
                                                    data-bs-toggle="tooltip" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('users.toggle-status', $user) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="btn btn-outline-{{ $user->isActive() ? 'warning' : 'success' }} btn-sm p-1 rounded-circle shadow-sm btn-toggle-status d-flex align-items-center justify-content-center action-btn"
                                                            data-bs-toggle="tooltip"
                                                            title="{{ $user->isActive() ? 'Deactivate' : 'Activate' }}">
                                                            <i class="bi bi-{{ $user->isActive() ? 'pause' : 'play' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-outline-danger btn-sm p-1 rounded-circle shadow-sm btn-delete-user d-flex align-items-center justify-content-center action-btn"
                                                            data-bs-toggle="tooltip" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-3 px-3 border-top">
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-muted small">
                                Showing <strong>{{ $users->firstItem() ?? 0 }}</strong> to
                                <strong>{{ $users->lastItem() ?? 0 }}</strong> of <strong>{{ $users->total() }}</strong> users
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <label class="text-muted small mb-0">Per page:</label>
                                <select class="form-select form-select-sm" style="width: auto;"
                                    onchange="changePerPage(this.value)">
                                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            {{ $users->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>

                    <script>
                        function changePerPage(perPage) {
                            const url = new URL(window.location.href);
                            url.searchParams.set('per_page', perPage);
                            url.searchParams.delete('page'); // Reset to page 1
                            window.location.href = url.toString();
                        }
                    </script>
                @else
                    <div class="empty-state">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-4"
                            style="width: 100px; height: 100px;">
                            <i class="bi bi-people fs-1 text-muted"></i>
                        </div>
                        <h5 class="fw-semibold mb-3">No users found</h5>
                        <p class="text-muted mb-4">Get started by adding your first user to the system.</p>
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-person-plus me-2"></i>Add First User
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bulk Action Bar (sticky) -->
    <div id="bulkActionBar" class="position-fixed bottom-0 start-50 translate-middle-x mb-4 shadow-lg"
        style="display: none; z-index: 1050; width: 95%; max-width: 900px;">
        <div class="card border-success">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-center flex-wrap gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold text-success"><span id="selectedCount">0</span> selected</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearSelection()">
                            <i class="bi bi-x"></i> Clear
                        </button>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm btn-success" onclick="submitBulkAction('activate')"
                            style="white-space: nowrap;">
                            <i class="bi bi-check-circle"></i> Activate
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" onclick="submitBulkAction('deactivate')"
                            style="white-space: nowrap;">
                            <i class="bi bi-pause-circle"></i> Deactivate
                        </button>

                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                            data-bs-target="#bulkDeleteModal" style="white-space: nowrap;">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Forms for Bulk Actions -->
    <form id="bulkActivateForm" method="POST" action="{{ route('users.bulk-activate') }}" style="display: none;">
        @csrf
        <div id="bulkActivateInputs"></div>
    </form>

    <form id="bulkDeactivateForm" method="POST" action="{{ route('users.bulk-deactivate') }}" style="display: none;">
        @csrf
        <div id="bulkDeactivateInputs"></div>
    </form>

    <form id="bulkDeleteForm" method="POST" action="{{ route('users.bulk-delete') }}" style="display: none;">
        @csrf
        <div id="bulkDeleteInputs"></div>
    </form>



    <!-- Bulk Delete Confirmation Modal -->
    <div class="modal fade" id="bulkDeleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Confirm Bulk Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to permanently delete <strong><span id="deleteCount">0</span> user(s)</strong>?
                    </p>
                    <p class="text-danger mb-0"><i class="bi bi-exclamation-circle me-1"></i>This action cannot be undone!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmBulkDelete()">
                        <i class="bi bi-trash me-1"></i>Delete Users
                    </button>
                </div>
            </div>
        </div>
    </div>



    <!-- Import Match Modal -->
    <div class="modal fade" id="importDeleteModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-person me-2"></i>Match Users from File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Upload your student list</strong> (Excel or CSV). Matched users will be automatically
                        selected in the list below so you can perform bulk actions on them.
                    </div>

                    <form id="importDeleteForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="import_file" class="form-label">Upload Student List (Excel/CSV)</label>
                            <input type="file" class="form-control" id="import_file" name="import_file"
                                accept=".xlsx,.xls,.csv" required>
                            <div class="form-text">
                                File must contain a <strong>Student ID</strong> column. You may also include
                                <strong>Name</strong> and <strong>Email</strong> columns to help you identify users.
                            </div>
                        </div>
                    </form>
                    <div id="importError" class="alert alert-danger d-none mt-2"></div>

                    <!-- Results Area -->
                    <div id="verificationResults" class="mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="verifyImport(this)">
                        <i class="bi bi-search me-1"></i>Process File
                    </button>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Bulk Actions JavaScript
        // Clear Import Selection Function
        function clearVerifiedImport() {
            sessionStorage.removeItem('verified_import_user_ids');
            window.location.reload();
        }

        document.addEventListener('DOMContentLoaded', function () {
            let selectedUsers = [];
            const selectAll = document.getElementById('selectAll');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');


            // Apply verified import IDs from previous session
            // REMOVED: Selections now clear on page reload
            // Kept in sessionStorage only for verifyImport function to access on same page

            // Select All functionality
            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    const checkboxes = document.querySelectorAll('.user-checkbox:not(:disabled)');
                    checkboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateSelection();
                });
            }

            // Individual checkbox handling
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    updateSelection();
                    // Update select all state
                    const allCheckboxes = document.querySelectorAll('.user-checkbox:not(:disabled)');
                    const checkedCheckboxes = document.querySelectorAll('.user-checkbox:checked:not(:disabled)');
                    if (selectAll) {
                        selectAll.checked = allCheckboxes.length === checkedCheckboxes.length && allCheckboxes.length > 0;
                    }
                });
            });

            // Make functions globally available for inline onclick handlers
            window.updateSelection = function () {
                selectedUsers = [];
                document.querySelectorAll('.user-checkbox:checked:not(:disabled)').forEach(cb => {
                    selectedUsers.push(cb.value);
                });

                const count = selectedUsers.length;
                const countElements = ['selectedCount', 'deleteCount'];

                countElements.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = count;
                });

                // Show/hide bulk action bar
                const actionBar = document.getElementById('bulkActionBar');
                if (actionBar) {
                    if (count > 0) {
                        actionBar.style.display = 'block';
                    } else {
                        actionBar.style.display = 'none';
                    }
                }
            };

            window.clearSelection = function () {
                document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = false);
                if (selectAll) selectAll.checked = false;
                updateSelection();
            };

            window.submitBulkAction = function (action) {
                if (selectedUsers.length === 0) {
                    alert('Please select at least one user');
                    return;
                }

                let form, inputsContainer;
                if (action === 'activate') {
                    form = document.getElementById('bulkActivateForm');
                    inputsContainer = document.getElementById('bulkActivateInputs');
                } else if (action === 'deactivate') {
                    form = document.getElementById('bulkDeactivateForm');
                    inputsContainer = document.getElementById('bulkDeactivateInputs');
                }

                if (!form || !inputsContainer) return;

                // Clear and add hidden inputs
                inputsContainer.innerHTML = '';
                selectedUsers.forEach(userId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'user_ids[]';
                    input.value = userId;
                    inputsContainer.appendChild(input);
                });
                form.submit();
            };

            window.confirmBulkDelete = function () {
                if (selectedUsers.length === 0) {
                    alert('Please select at least one user');
                    return;
                }
                const form = document.getElementById('bulkDeleteForm');
                const inputsContainer = document.getElementById('bulkDeleteInputs');

                if (!form || !inputsContainer) return;

                inputsContainer.innerHTML = '';
                selectedUsers.forEach(userId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'user_ids[]';
                    input.value = userId;
                    inputsContainer.appendChild(input);
                });
                form.submit();
            };
        });





        // --- IMPORT MATCH FUNCTIONALITY ---
        window.verifyImport = function (btn) {
            console.log('verifyImport function called'); // Debug log
            
            try {
                const form = document.getElementById('importDeleteForm');
                const errorDiv = document.getElementById('importError');
                const fileInput = document.getElementById('import_file');
                const resultsDiv = document.getElementById('verificationResults');

                // Validate elements exist
                if (!form) {
                    console.error('Form not found');
                    alert('Form not found. Please refresh the page and try again.');
                    return;
                }
                
                if (!btn) {
                    console.error('Button reference lost');
                    return;
                }

                // Clear previous state
                if (errorDiv) {
                    errorDiv.classList.add('d-none');
                    errorDiv.textContent = '';
                }
                if (resultsDiv) resultsDiv.innerHTML = '';

                // Reset valid/invalid classes on input
                if (fileInput) {
                    fileInput.classList.remove('is-invalid');
                }

                // Basic Validation
                if (!fileInput || !fileInput.files.length) {
                    if (fileInput) fileInput.classList.add('is-invalid');
                    if (errorDiv) {
                        errorDiv.textContent = 'Please select a file first.';
                        errorDiv.classList.remove('d-none');
                    }
                    return;
                }

                // Loading State
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
                btn.disabled = true;

                const formData = new FormData(form);

                // Safely get CSRF token
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                if (!csrfTokenMeta) {
                    throw new Error('CSRF token not found. Please refresh the page.');
                }
                const csrfToken = csrfTokenMeta.getAttribute('content');

                fetch('{{ route("users.verify-import-delete") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                try {
                                    const json = JSON.parse(text);
                                    throw new Error(json.message || 'Server returned error ' + response.status);
                                } catch (e) {
                                    throw new Error('Server returned error ' + response.status);
                                }
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Store matched IDs in sessionStorage for cross-page selection
                            if (data.matched_ids && data.matched_ids.length > 0) {
                                sessionStorage.setItem('verified_import_user_ids', JSON.stringify(data.matched_ids));

                                // Auto-select matched users on current page
                                let visibleMatches = 0;
                                data.matched_ids.forEach(id => {
                                    const checkbox = document.querySelector(`input.user-checkbox[value="${id}"]`);
                                    if (checkbox) {
                                        if (!checkbox.checked) {
                                            checkbox.checked = true;
                                            visibleMatches++;
                                        }
                                        // Visual highlight
                                        const row = checkbox.closest('tr');
                                        if (row) {
                                            row.classList.remove('table-success');
                                            void row.offsetWidth;
                                            row.classList.add('table-success');
                                            setTimeout(() => row.classList.remove('table-success'), 3000);
                                        }
                                    }
                                });

                                // Notify about users on other pages
                                const hiddenMatches = data.matched_ids.length - visibleMatches;
                                if (hiddenMatches > 0) {
                                    console.log(`${hiddenMatches} matched user(s) are on other pages and will be auto-selected when you navigate to those pages.`);
                                }

                                // Trigger update of bulk action bar
                                updateSelection();
                            }

                            // Display Results in Modal
                            if (resultsDiv) {
                                resultsDiv.innerHTML = `
                                                                        <div class="alert alert-success">
                                                                            <h6><i class="bi bi-check-circle me-2"></i>Matching Complete</h6>
                                                                            <p class="mb-2"><strong>${data.count}</strong> students matched out of <strong>${data.total_in_file}</strong> records in your file.</p>
                                                                            <p class="mb-0 small">Matched users currently visible on this page have been selected.</p>
                                                                        </div>
                                                                    `;
                            }



                        } else {
                            throw new Error(data.message || 'Verification failed.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        errorDiv.textContent = error.message || 'An error occurred. Please check console.';
                        errorDiv.classList.remove('d-none');
                    })
                    .finally(() => {
                        // Always reset button state
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    });

            } catch (e) {
                console.error("Synchronous Error:", e);
                if (btn) {
                    btn.innerHTML = '<i class="bi bi-search me-1"></i>Process File';
                    btn.disabled = false;
                }
                if (document.getElementById('importError')) {
                    document.getElementById('importError').textContent = e.message;
                    document.getElementById('importError').classList.remove('d-none');
                }
            }
        };
    </script>
@endsection