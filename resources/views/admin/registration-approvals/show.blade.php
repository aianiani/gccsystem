@extends('layouts.app')

@section('content')
<style>
    .registration-detail {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #2d5016 0%, #4a7c59 100%);
        color: white;
        padding: 1.5rem 2rem;
        border-bottom: none;
    }

    .card-body {
        padding: 2rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .status-pending { background: #fff3cd; color: #856404; }
    .status-approved { background: #d4edda; color: #155724; }
    .status-rejected { background: #f8d7da; color: #721c24; }

    .page-header {
        background: linear-gradient(135deg, #2d5016 0%, #4a7c59 100%);
        color: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .info-row {
        display: flex;
        justify-content-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
    }

    .info-value {
        color: #6c757d;
    }

    .action-buttons {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="bi bi-person me-3"></i>
                    Registration Details
                </h1>
                <p class="mb-0 opacity-75">Review student registration information</p>
            </div>
            <div>
                <a href="{{ route('admin.registration-approvals.index') }}" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Approvals
                </a>
            </div>
        </div>
    </div>

    <!-- Action Buttons (for pending registrations) -->
    @if($user->registration_status === 'pending')
        <div class="action-buttons">
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#approveModal">
                        <i class="bi bi-check-circle me-2"></i>
                        Approve Registration
                    </button>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-danger btn-lg w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
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
                <div class="col-md-4 text-center mb-4">
                    @if($user->avatar)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                             class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 150px; height: 150px;">
                            <span class="text-white fw-bold" style="font-size: 3rem;">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                        </div>
                    @endif
                    <h4 class="mb-1">{{ $user->name ?? 'N/A' }}</h4>
                    <p class="text-muted">{{ $user->email ?? 'N/A' }}</p>
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
                        <span class="info-value">{{ $user->created_at ? $user->created_at->format('F d, Y \a\t g:i A') : 'N/A' }}</span>
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
                        <span class="info-value">{{ $user->updated_at ? $user->updated_at->format('F d, Y \a\t g:i A') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            <textarea class="form-control" id="registration_notes" name="registration_notes" rows="3" placeholder="Add any notes about this approval..."></textarea>
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
                            <label for="rejection_reason" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
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