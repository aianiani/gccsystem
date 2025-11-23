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

    .main-dashboard-inner {
        padding: 2rem;
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
        flex-wrap: wrap;
        gap: 1rem;
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
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--forest-green);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--gray-100);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
        font-size: 0.95rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--forest-green);
        box-shadow: 0 0 0 0.2rem rgba(31, 122, 45, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: var(--gray-600);
        opacity: 0.6;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-text {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin-top: 0.25rem;
    }

    .btn-primary {
        background: var(--forest-green);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
        color: white;
    }

    .btn-primary:hover {
        background: #13601f;
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
        color: white;
    }

    .btn-secondary {
        background: var(--gray-50);
        color: var(--forest-green);
        border: 1px solid var(--gray-100);
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-secondary:hover {
        background: var(--gray-100);
        border-color: var(--forest-green);
        color: var(--forest-green);
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        gap: 0.75rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-100);
    }

    @media (max-width: 768px) {
        .main-dashboard-inner {
            padding: 1rem;
        }

        .page-header-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
        }
    }
</style>

<div class="home-zoom">
<div class="main-dashboard-inner">
    <div class="page-header-card">
        <div>
            <h1><i class="bi bi-person-plus me-2"></i>Create New User</h1>
            <p>Add a new user to the system</p>
        </div>
        <div>
            <a href="{{ route('users.index') }}" class="btn btn-light btn-lg">
                <i class="bi bi-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="main-content-card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>User Information</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>Please correct the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-1"></i>Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter full name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i>Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter email address"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock me-1"></i>Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter password"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Password must be at least 8 characters long.</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i>Confirm Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Confirm password"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">
                        <i class="bi bi-person-badge me-1"></i>Role <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('role') is-invalid @enderror" 
                            id="role" 
                            name="role" 
                            required>
                        <option value="">Select Role</option>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="counselor" {{ old('role') == 'counselor' ? 'selected' : '' }}>Counselor</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection 