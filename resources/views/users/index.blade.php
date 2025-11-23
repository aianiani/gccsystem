@extends('layouts.app')

@section('content')
<style>
    :root {
        --forest-green: #1f7a2d;
        --forest-green-light: #4a7c59;
        --forest-green-lighter: #e8f5e8;
        --yellow-maize: #f4d03f;
        --gray-50: #f8f9fa;
        --gray-100: #eef6ee;
        --gray-600: #6c757d;
        --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
        --hero-gradient: linear-gradient(135deg, var(--forest-green) 0%, #13601f 100%);
    }

    /* Apply the same page zoom used on the homepage */
    .home-zoom {
        zoom: 0.85;
    }
    @supports not (zoom: 1) {
        .home-zoom {
            transform: scale(0.85);
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

<div class="home-zoom">
<div class="main-dashboard-inner">
    <div class="page-header-card">
        <div>
            <h1><i class="bi bi-people me-2"></i>Users Management</h1>
            <p>Manage system users and their roles</p>
        </div>
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-light btn-lg">
                <i class="bi bi-person-plus me-2"></i>Add New User
            </a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="filter-card">
        <form method="GET" action="{{ route('users.index') }}" id="filterForm">
            <div class="filter-row">
                <div class="filter-group" style="flex: 2; min-width: 250px;">
                    <label for="search">
                        <i class="bi bi-search me-1"></i>Search
                    </label>
                    <div class="search-input-group">
                        <i class="bi bi-search"></i>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               placeholder="Search by name, email, or student ID..." 
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="filter-group">
                    <label for="role">
                        <i class="bi bi-person-badge me-1"></i>Role
                    </label>
                    <select class="form-select" id="role" name="role">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Student</option>
                        <option value="counselor" {{ request('role') === 'counselor' ? 'selected' : '' }}>Counselor</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="status">
                        <i class="bi bi-toggle-on me-1"></i>Status
                    </label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="registration_status">
                        <i class="bi bi-file-check me-1"></i>Registration
                    </label>
                    <select class="form-select" id="registration_status" name="registration_status">
                        <option value="">All</option>
                        <option value="pending" {{ request('registration_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('registration_status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('registration_status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-filter">
                        <i class="bi bi-funnel me-1"></i>Apply Filters
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-reset">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                    </a>
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
                                <th class="ps-4">User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr data-user-id="{{ $user->id }}">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle me-3 shadow" style="width: 45px; height: 45px;">
                                                <img src="{{ $user->avatar_url }}" alt="Avatar" class="rounded-circle" width="36" height="36">
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
                                        <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'secondary' }} fs-6 px-3 py-2" 
                                              data-bs-toggle="tooltip" 
                                              title="{{ $user->isAdmin() ? 'Administrator with full access' : 'Regular user with limited access' }}">
                                            <i class="bi bi-{{ $user->isAdmin() ? 'shield-fill' : 'person' }} me-1"></i>
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
                                               data-bs-toggle="tooltip"
                                               title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" 
                                               class="btn btn-outline-warning btn-sm p-1 rounded-circle shadow-sm d-flex align-items-center justify-content-center action-btn"
                                               data-bs-toggle="tooltip"
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('users.toggle-status', $user) }}" method="POST" class="d-inline">
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
                                                            data-bs-toggle="tooltip"
                                                            title="Delete">
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
                
                <div class="d-flex justify-content-center py-4">
                    {{ $users->links('vendor.pagination.bootstrap-5') }}
                </div>
            @else
                <div class="empty-state">
                    <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-4" style="width: 100px; height: 100px;">
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
</div>
@endsection
