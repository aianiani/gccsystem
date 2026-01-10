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

        body,
        .card {
            background-color: var(--light-gray) !important;
            color: var(--text-dark);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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

        .btn-secondary {
            border-radius: 10px;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            color: var(--forest-green-dark);
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 0.5rem;
        }

        .breadcrumb-item a {
            color: var(--forest-green);
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: var(--forest-green-dark);
        }

        .rounded-avatar {
            border-radius: 50%;
            border: 3px solid var(--forest-green);
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
    </style>
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0" style="color:var(--forest-green)">
                <i class="bi bi-pencil me-2"></i>Edit User
            </h1>
            <p class="text-muted">Update user information and settings</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>User Information</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {!! session('error') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('users.update', $user) }}" id="edit-user-form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                                    required>
                                    <option value="">Select Role</option>
                                    <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>
                                        Student</option>
                                    <option value="counselor" {{ old('role', $user->role) == 'counselor' ? 'selected' : '' }}>
                                        Counselor</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active Account
                                    </label>
                                </div>
                                <div class="form-text">Uncheck to deactivate this user account.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="avatar" class="form-label">Profile Avatar</label>
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                    name="avatar" accept="image/*">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2">
                                    <img src="{{ $user->avatar_url }}" alt="Current Avatar" class="rounded-avatar">
                                    <span class="text-muted small ms-2">Current Avatar</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" id="edit-user-btn">
                                <i class="bi bi-check-lg me-2"></i>Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        document.getElementById('edit-user-btn').addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this user information?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('edit-user-form').submit();
                }
            });
        });
    </script>
@endsection