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

        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
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
        }

        .page-header-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
        }

        .edit-user-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            overflow: hidden;
        }

        .edit-user-card .card-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }

        .edit-user-card .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            border-color: #dee2e6;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--forest-green-light);
            box-shadow: 0 0 0 0.25rem rgba(31, 122, 45, 0.15);
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--forest-green-lighter);
        }

        .context-info-card {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--gray-100);
        }

        .context-row {
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
        }

        .context-row:last-child {
            border-bottom: none;
        }

        .context-label {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .context-value {
            font-weight: 600;
            color: #333;
            text-align: right;
        }
    </style>

    <div class="home-zoom">
        <div class="main-dashboard-inner">
            <!-- Page Header -->
            <div class="page-header-card">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h1>
                            <i class="bi bi-pencil-square me-2"></i>
                            Edit User
                        </h1>
                        <p class="mb-0">Update account information and settings for <strong>{{ $user->name }}</strong></p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('users.show', $user) }}" class="btn btn-light">
                            <i class="bi bi-arrow-left me-2"></i>Cancel & Return
                        </a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('users.update', $user) }}" id="edit-user-form"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Left Column: Editable Form -->
                    <div class="col-lg-8">
                        <div class="edit-user-card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i>Account Information</h5>
                            </div>
                            <div class="card-body">
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {!! session('error') !!}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i
                                                    class="bi bi-person"></i></span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i
                                                    class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="role" class="form-label">System Role <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('role') is-invalid @enderror" id="role"
                                            name="role" required>
                                            <option value="">Select Role</option>
                                            <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                                            <option value="counselor" {{ old('role', $user->role) == 'counselor' ? 'selected' : '' }}>Counselor</option>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                                Administrator</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text small">Changing roles affects user permissions.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Account Status</label>
                                        <div class="p-2 border rounded d-flex align-items-center bg-light">
                                            <div class="form-check form-switch custom-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active"
                                                    name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold ms-2" for="is_active">
                                                    Active Account
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-text small text-muted mt-1">
                                            <i class="bi bi-info-circle me-1"></i>Uncheck to prevent user login.
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="avatar" class="form-label">Profile Avatar</label>
                                        <div class="d-flex align-items-center gap-4">
                                            <img src="{{ $user->avatar_url }}" alt="Current Avatar"
                                                class="avatar-preview shadow-sm" id="avatarPreviewImg">
                                            <div class="flex-grow-1">
                                                <input type="file"
                                                    class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                                    name="avatar" accept="image/*" onchange="previewImage(this)">
                                                <div class="form-text mt-1">Accepted formats: JPG, PNG, GIF. Max size: 2MB.
                                                </div>
                                                @error('avatar')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                    <button type="button" class="btn btn-primary btn-lg px-4" id="edit-user-btn">
                                        <i class="bi bi-check-lg me-2"></i>Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Read-Only Context -->
                    <div class="col-lg-4">
                        <div class="edit-user-card mb-4">
                            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                                <h6 class="text-uppercase text-muted fw-bold small ls-1 mb-0">Student Context</h6>
                            </div>
                            <div class="card-body pt-3">
                                <div class="context-info-card">
                                    <h5 class="mb-3 text-success fw-bold">{{ $user->name }}</h5>

                                    <div class="context-row">
                                        <span class="context-label">Student ID</span>
                                        <span class="context-value">{{ $user->student_id ?? 'N/A' }}</span>
                                    </div>
                                    <div class="context-row">
                                        <span class="context-label">College</span>
                                        <span class="context-value text-wrap"
                                            style="max-width: 60%;">{{ $user->college ?? 'N/A' }}</span>
                                    </div>
                                    <div class="context-row">
                                        <span class="context-label">Course</span>
                                        <span class="context-value text-wrap"
                                            style="max-width: 60%;">{{ $user->course ?? 'N/A' }}</span>
                                    </div>
                                    <div class="context-row">
                                        <span class="context-label">Year Level</span>
                                        <span class="context-value">{{ $user->year_level ?? 'N/A' }}</span>
                                    </div>
                                    <div class="context-row">
                                        <span class="context-label">Gender</span>
                                        <span class="context-value">{{ ucfirst($user->gender ?? 'N/A') }}</span>
                                    </div>
                                    <div class="context-row">
                                        <span class="context-label">Registered</span>
                                        <span class="context-value">{{ $user->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <div
                                    class="alert alert-info d-flex align-items-center mt-3 mb-0 py-2 border-0 bg-info bg-opacity-10 text-info">
                                    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                                    <small>These fields are managed during registration and cannot be edited here.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatarPreviewImg').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('edit-user-btn').addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Save Changes?',
                text: 'Are you sure you want to update this user\'s information?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1f7a2d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Update User',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('edit-user-form').submit();
                }
            });
        });
    </script>
@endsection