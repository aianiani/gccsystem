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
                                            @if($user->avatar)
                                                <img src="{{ $user->avatar_url }}" alt="Avatar" class="rounded-circle" width="36" height="36">
                                            @else
                                                <i class="bi bi-person text-primary fs-5"></i>
                                            @endif
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
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar text-muted me-2"></i>
                                        {{ $user->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('users.show', $user) }}" 
                                           class="btn btn-outline-primary btn-sm"
                                           data-bs-toggle="tooltip"
                                           title="View user details and activity history">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" 
                                           class="btn btn-outline-warning btn-sm"
                                           data-bs-toggle="tooltip"
                                           title="Edit user information and settings">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('users.toggle-status', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-outline-{{ $user->isActive() ? 'warning' : 'success' }} btn-sm btn-toggle-status"
                                                        data-user-name="{{ $user->name }}"
                                                        data-current-status="{{ $user->isActive() ? 'active' : 'inactive' }}"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ $user->isActive() ? 'Deactivate user account' : 'Activate user account' }}">
                                                    <i class="bi bi-{{ $user->isActive() ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger btn-sm btn-delete-user"
                                                        data-user-name="{{ $user->name }}"
                                                        data-user-email="{{ $user->email }}"
                                                        data-bs-toggle="tooltip"
                                                        title="Permanently delete user account">
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
                {{ $users->links() }}
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

<!-- Loading indicator for pagination -->
<div id="page-loading" class="text-center py-4" style="display: none;">
    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-3" style="width: 60px; height: 60px;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <p class="text-muted">Loading users...</p>
</div>
@endsection 