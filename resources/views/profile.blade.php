@extends('layouts.app')

@section('content')
<style>
    :root {
        --forest-green: #2d5016;
        --forest-green-light: #4a7c59;
        --forest-green-lighter: #e8f5e8;
        --yellow-maize: #f4d03f;
        --yellow-maize-light: #fef9e7;
        --white: #ffffff;
        --gray-50: #f8f9fa;
        --gray-100: #f1f3f4;
        --gray-600: #6c757d;
        --danger: #dc3545;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .admin-profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
    }
    .admin-profile-card img {
        border: 3px solid var(--yellow-maize);
        box-shadow: 0 2px 8px rgba(244, 208, 63, 0.08);
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
    }
    .admin-action-btn {
        background: var(--yellow-maize);
        color: var(--forest-green);
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .admin-action-btn:hover {
        background: #f1c40f;
        color: var(--forest-green);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }
    .admin-action-btn.primary {
        background: var(--forest-green);
        color: white;
    }
    .admin-action-btn.primary:hover {
        background: var(--forest-green-light);
        color: white;
    }
    .admin-action-btn.outline {
        background: white;
        color: var(--forest-green);
        border: 2px solid var(--forest-green);
    }
    .admin-action-btn.outline:hover {
        background: var(--forest-green-light);
        color: white;
    }
    .admin-stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        transition: all 0.3s ease;
        height: 100%;
        text-align: center;
        margin-bottom: 1.5rem;
    }
</style>
<div class="container py-4">
    <div class="row mb-4 position-relative">
        <div class="col-12">
            <a href="{{ route('dashboard') }}" class="admin-action-btn outline position-absolute top-0 end-0 mt-1 me-2">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
            <h1 class="h3 mb-0" style="color:var(--forest-green)">
                <i class="bi bi-person-circle me-2"></i>My Profile
            </h1>
            <p class="text-muted">View and manage your account information</p>
        </div>
    </div>
    <div class="row g-4 align-items-start justify-content-center">
        <div class="col-md-4 d-flex flex-column align-items-center justify-content-start mb-4 mb-md-0">
            <div class="admin-profile-card w-100 d-flex flex-column align-items-center justify-content-center">
                <img src="{{ $user->avatar_url }}" alt="Avatar" class="mb-3">
                <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="mb-3 w-100">
                    @csrf
                    <div class="mb-2">
                        <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                        @error('avatar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="admin-action-btn outline w-100">Upload Avatar</button>
                </form>
                <h5 style="color:var(--forest-green)" class="mt-2 text-center">{{ $user->name }}</h5>
                <p class="text-muted text-center">{{ $user->email }}</p>
                <div class="admin-stats-card w-100">
                    <div class="row text-start mb-2">
                        <div class="col-6"><strong>Role:</strong></div>
                        <div class="col-6">
                            <span class="badge" style="background: var(--forest-green); color: #fff;">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                    <div class="row text-start mb-2">
                        <div class="col-6"><strong>Status:</strong></div>
                        <div class="col-6">
                            <span class="badge" style="background: {{ $user->isActive() ? 'var(--yellow-maize)' : 'var(--danger)' }}; color: var(--forest-green);">
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
                @if($user->isAdmin())
                    <div class="admin-stats-card w-100">
                        <div class="d-grid gap-2">
                            <a href="{{ route('users.index') }}" class="admin-action-btn outline w-100">
                                <i class="bi bi-people me-2"></i>Manage Users
                            </a>
                            <a href="{{ route('activities') }}" class="admin-action-btn outline w-100">
                                <i class="bi bi-activity me-2"></i>View Activity Logs
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-8 d-flex flex-column align-items-center justify-content-start mt-4 mt-md-0">
            <div class="admin-stats-card w-100 mb-4" style="padding: 1.5rem 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                <h5 class="mb-3 text-center" style="color: var(--forest-green);">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profile
                </h5>
                <form method="POST" action="{{ route('profile.update') }}" style="max-width: 480px; margin-left: auto; margin-right: auto;">
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
                    <button type="submit" class="admin-action-btn primary w-100">Update Profile</button>
                </form>
            </div>
            <div class="admin-stats-card w-100 mb-4" style="padding: 1.5rem 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                <h5 class="mb-3 text-center" style="color: var(--forest-green);">
                    <i class="bi bi-key me-2"></i>Change Password
                </h5>
                <form method="POST" action="{{ route('profile.password') }}" style="max-width: 480px; margin-left: auto; margin-right: auto;">
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
                    <button type="submit" class="admin-action-btn w-100">Change Password</button>
                </form>
            </div>
            <div class="admin-stats-card w-100" style="padding: 1.5rem 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                <h5 class="mb-3 text-center" style="color: var(--forest-green);">
                    <i class="bi bi-activity me-2"></i>My Activity History
                </h5>
                <div class="card-body p-0">
                    @php $userActivities = \App\Models\UserActivity::where('user_id', $user->id)->latest()->take(5)->get(); @endphp
                    @if($userActivities->count())
                        <ul class="list-group list-group-flush">
                            @foreach($userActivities as $activity)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ ucfirst($activity->action) }} - {{ $activity->description }}</span>
                                    <span class="text-muted small">{{ $activity->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-muted">No recent activities.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 