@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4 mb-0" style="background: var(--primary-white);">
            <div class="card-body py-4 px-4">
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb bg-transparent px-0 py-1 mb-0" style="font-size: 1rem;">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none" style="color:var(--primary-black)">Users</a></li>
                        <li class="breadcrumb-item active text-secondary" aria-current="page">{{ $user->name }}</li>
                    </ol>
                </nav>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        @if($user->avatar)
                            <img src="{{ $user->avatar_url }}" alt="Avatar" class="rounded-circle shadow-sm" width="60" height="60">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 60px; height: 60px;">
                                <i class="bi bi-person" style="color:var(--primary-black);font-size:2rem;"></i>
                            </div>
                        @endif
                        <div>
                            <h1 class="fw-bold mb-1" style="font-size:2rem; color:var(--primary-black)">{{ $user->name }}</h1>
                            <p class="mb-0 text-secondary" style="font-size:1.1rem;">User details and activity history</p>
                        </div>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-lg px-4 shadow-sm">
                            <i class="bi bi-pencil me-2"></i>Edit User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person-circle me-2"></i>User Information
                </h5>
            </div>
            <div class="card-body text-center">
                @if($user->avatar)
                    <img src="{{ $user->avatar_url }}" alt="Avatar" class="rounded-circle shadow-sm mb-3" width="80" height="80">
                @else
                    <i class="bi bi-person-circle fs-1 text-primary mb-3"></i>
                @endif
                <h5>{{ $user->name }}</h5>
                <p class="text-muted">{{ $user->email }}</p>
                
                <div class="row text-start">
                    <div class="col-6">
                        <strong>Role:</strong>
                    </div>
                    <div class="col-6">
                        <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'secondary' }}"
                              data-bs-toggle="tooltip"
                              title="{{ $user->isAdmin() ? 'Administrator with full access' : 'Regular user with limited access' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
                
                <div class="row text-start">
                    <div class="col-6">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-6">
                        <span class="badge bg-{{ $user->isActive() ? 'success' : 'danger' }}"
                              data-bs-toggle="tooltip"
                              title="{{ $user->isActive() ? 'User can log in and access the system' : 'User account is deactivated' }}">
                            {{ $user->isActive() ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                
                <div class="row text-start">
                    <div class="col-6">
                        <strong>Joined:</strong>
                    </div>
                    <div class="col-6">
                        {{ $user->created_at->format('M d, Y') }}
                    </div>
                </div>
                
                <div class="row text-start">
                    <div class="col-6">
                        <strong>Last Updated:</strong>
                    </div>
                    <div class="col-6">
                        {{ $user->updated_at->format('M d, Y') }}
                    </div>
                </div>
                
                @if($user->id !== auth()->id())
                    <hr>
                    <div class="d-grid gap-2">
                        <form action="{{ route('users.toggle-status', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="btn btn-sm btn-outline-{{ $user->isActive() ? 'warning' : 'success' }} btn-toggle-status"
                                    data-user-name="{{ $user->name }}"
                                    data-current-status="{{ $user->isActive() ? 'active' : 'inactive' }}"
                                    data-bs-toggle="tooltip"
                                    title="{{ $user->isActive() ? 'Deactivate user account' : 'Activate user account' }}">
                                <i class="bi bi-{{ $user->isActive() ? 'pause' : 'play' }} me-2"></i>
                                {{ $user->isActive() ? 'Deactivate' : 'Activate' }} User
                            </button>
                        </form>
                        
                        <form action="{{ route('users.destroy', $user) }}" method="POST" id="delete-user-form" data-username="{{ $user->name }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-outline-danger btn-delete-user"
                                    data-user-name="{{ $user->name }}"
                                    data-user-email="{{ $user->email }}"
                                    data-bs-toggle="tooltip"
                                    title="Permanently delete user account">
                                <i class="bi bi-trash me-2"></i>Delete User
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-activity me-2"></i>Activity History
                </h5>
            </div>
            <div class="card-body">
                @if($activities->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($activities as $activity)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{{ ucfirst($activity->action) }}</div>
                                        <small class="text-muted">{{ $activity->description }}</small>
                                        @if($activity->ip_address)
                                            <br><small class="text-muted">IP: {{ $activity->ip_address }}</small>
                                        @endif
                                        @if($activity->user_agent)
                                            <br><small class="text-muted">Browser: {{ getBrowserName($activity->user_agent) }}</small>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $activity->created_at->format('M d, Y H:i') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $activities->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-activity fs-1 text-muted mb-3"></i>
                        <h6>No activities found</h6>
                        <p class="text-muted">This user hasn't performed any actions yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const deleteForm = document.getElementById('delete-user-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const userName = deleteForm.getAttribute('data-username');
            Swal.fire({
                title: `Are you sure you want to delete user "${userName}"?`,
                text: 'This action will permanently delete the user. This cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteForm.submit();
                }
            });
        });
    }
</script>
@php
function getBrowserName($userAgent) {
    if (!$userAgent) return 'Unknown';
    if (stripos($userAgent, 'Brave') !== false || $userAgent === 'Brave') return 'Brave';
    if (stripos($userAgent, 'Edg') !== false) return 'Microsoft Edge';
    if (stripos($userAgent, 'OPR') !== false || stripos($userAgent, 'Opera') !== false) return 'Opera';
    if (stripos($userAgent, 'Chrome') !== false && stripos($userAgent, 'Edg') === false && stripos($userAgent, 'OPR') === false) return 'Google Chrome';
    if (stripos($userAgent, 'Safari') !== false && stripos($userAgent, 'Chrome') === false) return 'Safari';
    if (stripos($userAgent, 'Firefox') !== false) return 'Mozilla Firefox';
    if (stripos($userAgent, 'MSIE') !== false || stripos($userAgent, 'Trident') !== false) return 'Internet Explorer';
    return 'Other';
}
@endphp
@endsection 