@extends('layouts.app')

@section('content')
<div class="row mb-5">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="display-4 fw-bold mb-2" style="color:var(--text-primary)">
                    <i class="bi bi-people me-3"></i>Users Management
                </h1>
                <p class="fs-5 mb-0" style="color:var(--text-secondary)">Manage system users and their roles</p>
            </div>
            <div>
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus me-2"></i>Add New User
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-people me-2"></i>All Users
        </h5>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary fs-6">{{ $users->total() }} total users</span>
            <span class="badge bg-success fs-6">{{ $users->where('is_active', true)->count() }} active</span>
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
            <div class="text-center py-5">
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

<style>
.action-btn {
    transition: box-shadow 0.2s, background 0.2s, color 0.2s;
}
.action-btn:hover, .action-btn:focus {
    background: rgba(99, 102, 241, 0.08) !important;
    box-shadow: 0 2px 8px 0 rgba(99,102,241,0.12) !important;
    color: var(--primary-color) !important;
}
.btn-outline-danger.action-btn:hover, .btn-outline-danger.action-btn:focus {
    background: rgba(239, 68, 68, 0.08) !important;
    color: #ef4444 !important;
}
.btn-outline-warning.action-btn:hover, .btn-outline-warning.action-btn:focus {
    background: rgba(245, 158, 11, 0.08) !important;
    color: #f59e0b !important;
}
.btn-outline-success.action-btn:hover, .btn-outline-success.action-btn:focus {
    background: rgba(16, 185, 129, 0.08) !important;
    color: #10b981 !important;
}
</style>
@endsection 