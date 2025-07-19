@extends('layouts.app')

@section('content')
<style>
    .approval-section {
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

    .registration-item {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: #f8f9fa;
        transition: all 0.2s ease;
    }

    .registration-item:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
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

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-align: center;
        margin-bottom: 1rem;
    }

    .stats-number {
        font-size: 2rem;
        font-weight: bold;
        color: #2d5016;
    }

    .stats-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 2rem;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 1rem 2rem;
        border-radius: 0;
    }

    .nav-tabs .nav-link.active {
        color: #2d5016;
        background: none;
        border-bottom: 3px solid #2d5016;
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="bi bi-check-circle me-3"></i>
                    Registration Approvals
                </h1>
                <p class="mb-0 opacity-75">Manage student registration approvals and rejections</p>
            </div>
            <div>
                <a href="{{ route('admin.logs.users') }}" class="btn btn-outline-light me-2">
                    <i class="bi bi-people me-2"></i>
                    View All Users
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-number">{{ $pendingRegistrations->total() ?? 0 }}</div>
                <div class="stats-label">Pending Approvals</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-number">{{ $approvedRegistrations->total() ?? 0 }}</div>
                <div class="stats-label">Approved Registrations</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stats-number">{{ $rejectedRegistrations->total() ?? 0 }}</div>
                <div class="stats-label">Rejected Registrations</div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs" id="approvalTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                <i class="bi bi-clock me-2"></i>Pending ({{ $pendingRegistrations->total() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
                <i class="bi bi-check-circle me-2"></i>Approved ({{ $approvedRegistrations->total() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab">
                <i class="bi bi-x-circle me-2"></i>Rejected ({{ $rejectedRegistrations->total() }})
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="approvalTabsContent">
        <!-- Pending Registrations -->
        <div class="tab-pane fade show active" id="pending" role="tabpanel">
            <div class="approval-section">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock me-2"></i>Pending Approvals</h5>
                </div>
                <div class="card-body">
                    @if($pendingRegistrations->count() > 0)
                        @foreach($pendingRegistrations as $user)
                            <div class="registration-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3">
                                                @if($user->avatar)
                                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                                         class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <span class="text-white fw-bold">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">{{ $user->name ?? 'N/A' }}</h6>
                                                <p class="text-muted mb-1">{{ $user->email ?? 'N/A' }}</p>
                                                <div class="d-flex gap-2">
                                                    <span class="status-badge status-pending">Pending Approval</span>
                                                    <span class="text-muted">
                                                        Registered: {{ $user->created_at->format('M d, Y H:i') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('admin.registration-approvals.show', $user->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="bi bi-eye me-1"></i>Review
                                        </a>
                                        <button type="button" class="btn btn-sm btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal{{ $user->id }}">
                                            <i class="bi bi-check me-1"></i>Approve
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $user->id }}">
                                            <i class="bi bi-x me-1"></i>Reject
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Approve Modal -->
                            <div class="modal fade" id="approveModal{{ $user->id }}" tabindex="-1">
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
                            <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1">
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
                        @endforeach

                        <div class="d-flex justify-content-center mt-4">
                            {{ $pendingRegistrations->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">No Pending Approvals</h5>
                            <p class="text-muted">All student registrations have been processed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Approved Registrations -->
        <div class="tab-pane fade" id="approved" role="tabpanel">
            <div class="approval-section">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-check-circle me-2"></i>Approved Registrations</h5>
                </div>
                <div class="card-body">
                    @if($approvedRegistrations->count() > 0)
                        @foreach($approvedRegistrations as $user)
                            <div class="registration-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3">
                                                @if($user->avatar)
                                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                                         class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <span class="text-white fw-bold">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">{{ $user->name ?? 'N/A' }}</h6>
                                                <p class="text-muted mb-1">{{ $user->email ?? 'N/A' }}</p>
                                                <div class="d-flex gap-2">
                                                    <span class="status-badge status-approved">Approved</span>
                                                    <span class="text-muted">
                                                        Approved: {{ $user->approved_at ? $user->approved_at->format('M d, Y H:i') : 'N/A' }}
                                                    </span>
                                                    @if($user->approvedBy)
                                                        <span class="text-muted">
                                                            by {{ $user->approvedBy->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if($user->registration_notes)
                                            <div class="mt-2">
                                                <small class="text-muted"><strong>Notes:</strong> {{ $user->registration_notes }}</small>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('admin.registration-approvals.show', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-center mt-4">
                            {{ $approvedRegistrations->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">No Approved Registrations</h5>
                            <p class="text-muted">No student registrations have been approved yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Rejected Registrations -->
        <div class="tab-pane fade" id="rejected" role="tabpanel">
            <div class="approval-section">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-x-circle me-2"></i>Rejected Registrations</h5>
                </div>
                <div class="card-body">
                    @if($rejectedRegistrations->count() > 0)
                        @foreach($rejectedRegistrations as $user)
                            <div class="registration-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="me-3">
                                                @if($user->avatar)
                                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                                         class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <span class="text-white fw-bold">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">{{ $user->name ?? 'N/A' }}</h6>
                                                <p class="text-muted mb-1">{{ $user->email ?? 'N/A' }}</p>
                                                <div class="d-flex gap-2">
                                                    <span class="status-badge status-rejected">Rejected</span>
                                                    <span class="text-muted">
                                                        Rejected: {{ $user->approved_at ? $user->approved_at->format('M d, Y H:i') : 'N/A' }}
                                                    </span>
                                                    @if($user->approvedBy)
                                                        <span class="text-muted">
                                                            by {{ $user->approvedBy->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if($user->rejection_reason)
                                            <div class="mt-2">
                                                <small class="text-muted"><strong>Reason:</strong> {{ $user->rejection_reason }}</small>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('admin.registration-approvals.show', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-center mt-4">
                            {{ $rejectedRegistrations->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-x-circle text-danger" style="font-size: 3rem;"></i>
                            <h5 class="mt-3">No Rejected Registrations</h5>
                            <p class="text-muted">No student registrations have been rejected.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 