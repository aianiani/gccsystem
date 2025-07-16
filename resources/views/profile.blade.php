@extends('layouts.app')

@section('content')
<style>
    :root {
        --forest-green: #228B22;
        --forest-green-light: #32CD32;
        --forest-green-dark: #006400;
        --yellow-maize: #FFDB58;
        --yellow-maize-light: #FFF8DC;
        --yellow-maize-dark: #DAA520;
        --white: #FFFFFF;
        --light-gray: #F8F9FA;
        --text-dark: #2C3E50;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
    }
    body, .card {
        background-color: var(--light-gray) !important;
        color: var(--text-dark);
    }
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }
    .card-header {
        background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.2rem;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, var(--forest-green-dark) 0%, var(--forest-green) 100%);
        transform: translateY(-1px);
    }
    .btn-warning {
        background: linear-gradient(135deg, var(--yellow-maize) 0%, var(--yellow-maize-dark) 100%);
        border: none;
        border-radius: 10px;
        color: var(--text-dark);
        font-weight: 600;
    }
    .btn-outline {
        border: 2px solid var(--forest-green);
        color: var(--forest-green);
        border-radius: 10px;
        font-weight: 600;
    }
    .btn-outline:hover {
        background: var(--forest-green);
        border-color: var(--forest-green);
        color: white;
    }
    .form-label {
        font-weight: 500;
        color: var(--forest-green-dark);
    }
    .rounded-avatar {
        border-radius: 50%;
        border: 3px solid var(--forest-green);
        width: 100px;
        height: 100px;
        object-fit: cover;
    }
    .badge.bg-danger, .badge.bg-success, .badge.bg-secondary {
        font-size: 0.95em;
        padding: 0.5em 0.8em;
        border-radius: 8px;
    }
    .btn-yellow-maize {
        background: linear-gradient(135deg, var(--yellow-maize) 0%, var(--yellow-maize-dark) 100%) !important;
        color: var(--text-dark) !important;
        border: none !important;
        font-weight: 600;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        transition: background 0.2s, color 0.2s;
    }
    .btn-yellow-maize:hover {
        background: linear-gradient(135deg, var(--yellow-maize-dark) 0%, var(--yellow-maize) 100%) !important;
        color: var(--forest-green-dark) !important;
    }
</style>
<div class="row mb-4 position-relative">
    <div class="col-12">
        <a href="{{ route('dashboard') }}" class="btn btn-yellow-maize position-absolute top-0 end-0 mt-1 me-2" style="background: linear-gradient(135deg, var(--yellow-maize) 0%, var(--yellow-maize-dark) 100%); color: var(--text-dark); border: none; font-weight: 600;">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        <h1 class="h3 mb-0" style="color:var(--forest-green)">
            <i class="bi bi-person-circle me-2"></i>My Profile
        </h1>
        <p class="text-muted">View and manage your account information</p>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person-circle me-2"></i>Profile Information
                </h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ $user->avatar_url }}" alt="Avatar" class="rounded-avatar mb-3">
                <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="mb-3">
                    @csrf
                    <div class="mb-2">
                        <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                        @error('avatar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-outline w-100">Upload Avatar</button>
                </form>
                <h5 style="color:var(--forest-green)">{{ $user->name }}</h5>
                <p class="text-muted">{{ $user->email }}</p>
                <div class="row text-start mb-2">
                    <div class="col-6"><strong>Role:</strong></div>
                    <div class="col-6">
                        <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'secondary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
                <div class="row text-start mb-2">
                    <div class="col-6"><strong>Status:</strong></div>
                    <div class="col-6">
                        <span class="badge bg-{{ $user->isActive() ? 'success' : 'danger' }}">
                            {{ $user->isActive() ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="row text-start mb-2">
                    <div class="col-6"><strong>Member Since:</strong></div>
                    <div class="col-6">{{ $user->created_at->format('M d, Y') }}</div>
                </div>
                <div class="row text-start mb-2">
                    <div class="col-6"><strong>Last Login:</strong></div>
                    <div class="col-6">{{ $user->updated_at->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
        @if($user->isAdmin())
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>Admin Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-people me-2"></i>Manage Users
                        </a>
                        <a href="{{ route('activities') }}" class="btn btn-outline-info">
                            <i class="bi bi-activity me-2"></i>View Activity Logs
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profile
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-key me-2"></i>Change Password
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Change Password</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-activity me-2"></i>My Activity History
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
                        <p class="text-muted">You haven't performed any actions yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 