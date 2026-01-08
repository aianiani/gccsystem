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



        .main-dashboard-inner {
            padding: 2rem;
        }

        .registration-detail {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .registration-detail .card-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .registration-detail .card-body {
            padding: 1.25rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
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

        .info-row {
            display: flex;
            justify-content-between;
            align-items: flex-start;
            padding: 1rem 0;
            gap: 1rem;
            border-bottom: 1px solid var(--gray-100);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--forest-green);
            min-width: 180px;
            flex-shrink: 0;
        }

        .info-value {
            color: var(--gray-600);
            text-align: right;
            flex: 1;
            word-break: break-word;
        }

        .action-buttons {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .student-avatar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
            background: var(--gray-50);
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .student-avatar-container img,
        .student-avatar-container .avatar-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1rem;
        }

        .student-avatar-container .avatar-placeholder {
            background: var(--forest-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .main-dashboard-inner {
                padding: 1rem;
            }

            .page-header-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>

    <div class="main-dashboard-inner">
        <!-- Page Header -->
        <div class="page-header-card">
            <div>
                <h1><i class="bi bi-person me-2"></i>Registration Details</h1>
                <p>Review student registration information</p>
            </div>
            <div>
                <a href="{{ route('admin.registration-approvals.index') }}" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Approvals
                </a>
            </div>
        </div>

        <!-- Action Buttons (for pending registrations) -->
        @if($user->registration_status === 'pending')
            <div class="action-buttons">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal"
                            data-bs-target="#approveModal">
                            <i class="bi bi-check-circle me-2"></i>
                            Approve Registration
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-danger btn-lg w-100" data-bs-toggle="modal"
                            data-bs-target="#rejectModal">
                            <i class="bi bi-x-circle me-2"></i>
                            Reject Registration
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Registration Details -->
        <div class="registration-detail">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-person me-2"></i>
                        Student Information
                    </h5>
                    <span class="status-badge status-{{ $user->registration_status }}">
                        {{ ucfirst($user->registration_status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="student-avatar-container">
                            @if($user->avatar)
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle">
                            @else
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                            <h4 class="mb-1 fw-bold">{{ $user->name ?? 'N/A' }}</h4>
                            <p class="text-muted mb-0">{{ $user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="info-row">
                            <span class="info-label">Full Name:</span>
                            <span class="info-value">{{ $user->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email Address:</span>
                            <span class="info-value">{{ $user->email ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Role:</span>
                            <span class="info-value">{{ ucfirst($user->role ?? 'N/A') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Registration Status:</span>
                            <span class="info-value">
                                <span class="status-badge status-{{ $user->registration_status }}">
                                    {{ ucfirst($user->registration_status) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Account Status:</span>
                            <span class="info-value">
                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email Verified:</span>
                            <span class="info-value">
                                <span class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-warning' }}">
                                    {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Registration Date:</span>
                            <span
                                class="info-value">{{ $user->created_at ? $user->created_at->format('F d, Y \a\t g:i A') : 'N/A' }}</span>
                        </div>
                        @if($user->approved_at)
                            <div class="info-row">
                                <span class="info-label">Processed Date:</span>
                                <span class="info-value">{{ $user->approved_at->format('F d, Y \a\t g:i A') }}</span>
                            </div>
                            @if($user->approvedBy)
                                <div class="info-row">
                                    <span class="info-label">Processed By:</span>
                                    <span class="info-value">{{ $user->approvedBy->name }}</span>
                                </div>
                            @endif
                        @endif
                        @if($user->registration_notes)
                            <div class="info-row">
                                <span class="info-label">Approval Notes:</span>
                                <span class="info-value">{{ $user->registration_notes }}</span>
                            </div>
                        @endif
                        @if($user->rejection_reason)
                            <div class="info-row">
                                <span class="info-label">Rejection Reason:</span>
                                <span class="info-value">{{ $user->rejection_reason }}</span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Last Updated:</span>
                            <span
                                class="info-value">{{ $user->updated_at ? $user->updated_at->format('F d, Y \a\t g:i A') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Details (if student) -->
        @if($user->role === 'student' && ($user->student_id || $user->college || $user->course || $user->contact_number || $user->address || $user->cor_file))
            <div class="registration-detail">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-graduation-cap me-2"></i>
                        Academic & Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if($user->student_id)
                                <div class="info-row">
                                    <span class="info-label">Student ID:</span>
                                    <span class="info-value">{{ $user->student_id }}</span>
                                </div>
                            @endif
                            @if($user->college)
                                <div class="info-row">
                                    <span class="info-label">College:</span>
                                    <span class="info-value">{{ $user->college }}</span>
                                </div>
                            @endif
                            @if($user->course)
                                <div class="info-row">
                                    <span class="info-label">Course/Program:</span>
                                    <span class="info-value">{{ $user->course }}</span>
                                </div>
                            @endif
                            @if($user->year_level)
                                <div class="info-row">
                                    <span class="info-label">Year Level:</span>
                                    <span class="info-value">{{ $user->year_level }}</span>
                                </div>
                            @endif
                            @if($user->gender)
                                <div class="info-row">
                                    <span class="info-label">Gender:</span>
                                    <span class="info-value">{{ ucfirst(str_replace('_', ' ', $user->gender)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($user->contact_number)
                                <div class="info-row">
                                    <span class="info-label">Contact Number:</span>
                                    <span class="info-value">{{ $user->contact_number }}</span>
                                </div>
                            @endif
                            @if($user->address)
                                <div class="info-row">
                                    <span class="info-label">Address:</span>
                                    <span class="info-value">{{ $user->address }}</span>
                                </div>
                            @endif
                            @if($user->cor_file)
                                <div class="info-row">
                                    <span class="info-label">Certificate of Registration (COR):</span>
                                    <span class="info-value">
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url('cor_files/' . $user->cor_file) }}"
                                            target="_blank" class="btn btn-sm btn-primary">
                                            <i class="bi bi-file-earmark-pdf me-1"></i>
                                            View COR File
                                        </a>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Approve Modal -->
    @if($user->registration_status === 'pending')
        <div class="modal fade" id="approveModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Approve Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.registration-approvals.approve', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p>Are you sure you want to approve the registration for <strong>{{ $user->name }}</strong>?</p>
                            <p class="text-muted">This will activate their account and send them an approval email.</p>
                            <div class="mb-3">
                                <label for="registration_notes" class="form-label">Approval Notes (Optional)</label>
                                <textarea class="form-control" id="registration_notes" name="registration_notes" rows="3"
                                    placeholder="Add any notes about this approval..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve Registration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.registration-approvals.reject', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p>Are you sure you want to reject the registration for <strong>{{ $user->name }}</strong>?</p>
                            <p class="text-muted">This will deactivate their account and send them a rejection email.</p>
                            <div class="mb-3">
                                <label for="rejection_reason" class="form-label">Rejection Reason <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"
                                    placeholder="Please provide a reason for rejection..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject Registration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection