@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0">
                    <i class="bi bi-person me-2"></i>{{ $user->name }}
                </h1>
                <p class="text-muted">User details and activity history</p>
            </div>
            <div>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-2"></i>Edit User
                </a>
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
                <i class="bi bi-person-circle fs-1 text-primary mb-3"></i>
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
                        
                        <form action="{{ route('users.destroy', $user) }}" method="POST">
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
                                    </div>
                                    <small class="text-muted">{{ $activity->created_at->format('M d, Y H:i') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $activities->links() }}
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
@endsection 