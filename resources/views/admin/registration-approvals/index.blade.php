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
        }

        .main-content-card .card-body {
            padding: 1.25rem;
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
            margin: 0 0 0.5rem 0;
            color: #fff;
        }

        .page-header-card p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .dashboard-stat-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem 1rem;
            text-align: center;
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
        }

        .dashboard-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .dashboard-stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
        }

        .dashboard-stat-card .stat-label {
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .nav-tabs {
            border-bottom: 2px solid var(--gray-100);
            margin-bottom: 1.5rem;
        }

        .nav-tabs .nav-link {
            border: none;
            color: var(--gray-600);
            font-weight: 500;
            padding: 1rem 1.5rem;
            border-radius: 0;
            transition: all 0.2s;
        }

        .nav-tabs .nav-link.active {
            color: var(--forest-green);
            background: none;
            border-bottom: 3px solid var(--forest-green);
        }

        .nav-tabs .nav-link:hover {
            color: var(--forest-green);
        }

        .registration-item {
            border: 1px solid var(--gray-100);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            background: var(--gray-50);
            transition: all 0.2s ease;
        }

        .registration-item:hover {
            box-shadow: var(--shadow-sm);
            transform: translateY(-2px);
            background: white;
        }

        .status-badge {
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
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

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--gray-600);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>

    <div class="main-dashboard-inner">
        <div class="page-header-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1><i class="bi bi-person-check me-2"></i>Registration Approvals</h1>
                    <p>Manage student registration approvals and rejections</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('users.index') }}" class="btn btn-light">
                        <i class="bi bi-people me-2"></i>View All Users
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="dashboard-stats">
            <div class="dashboard-stat-card">
                <div class="stat-value">{{ $pendingRegistrations->total() ?? 0 }}</div>
                <div class="stat-label">Pending Approvals</div>
            </div>
            <div class="dashboard-stat-card">
                <div class="stat-value">{{ $approvedRegistrations->total() ?? 0 }}</div>
                <div class="stat-label">Approved Registrations</div>
            </div>
            <div class="dashboard-stat-card">
                <div class="stat-value">{{ $rejectedRegistrations->total() ?? 0 }}</div>
                <div class="stat-label">Rejected Registrations</div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs" id="approvalTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                    type="button" role="tab">
                    <i class="bi bi-clock me-2"></i>Pending ({{ $pendingRegistrations->total() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button"
                    role="tab">
                    <i class="bi bi-check-circle me-2"></i>Approved ({{ $approvedRegistrations->total() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button"
                    role="tab">
                    <i class="bi bi-x-circle me-2"></i>Rejected ({{ $rejectedRegistrations->total() }})
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="approvalTabsContent">
            <!-- Pending Registrations -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                <div class="main-content-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-clock me-2"></i>Pending Approvals</h5>
                    </div>
                    <div class="card-body">
                        @if($pendingRegistrations->count() > 0)
                            @foreach($pendingRegistrations as $user)
                                <div class="registration-item">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="me-3">
                                                    @if($user->avatar)
                                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                                            class="rounded-circle"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                            style="width: 50px; height: 50px;">
                                                            <span
                                                                class="text-white fw-bold">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold">{{ $user->name ?? 'N/A' }}</h6>
                                                    <p class="text-muted mb-1">{{ $user->email ?? 'N/A' }}</p>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        <span class="status-badge status-pending">Pending Approval</span>
                                                        <span class="text-muted small">
                                                            Registered: {{ $user->created_at->format('M d, Y H:i') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.registration-approvals.show', $user->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>Review
                                            </a>
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#approveModal{{ $user->id }}">
                                                <i class="bi bi-check me-1"></i>Approve
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $user->id }}">
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
                                            <form action="{{ route('admin.registration-approvals.approve', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Are you sure you want to approve the registration for
                                                        <strong>{{ $user->name }}</strong>?
                                                    </p>
                                                    <div class="mb-3">
                                                        <label for="registration_notes" class="form-label">Approval Notes
                                                            (Optional)</label>
                                                        <textarea class="form-control" id="registration_notes"
                                                            name="registration_notes" rows="3"
                                                            placeholder="Add any notes about this approval..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
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
                                            <form action="{{ route('admin.registration-approvals.reject', $user->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Are you sure you want to reject the registration for
                                                        <strong>{{ $user->name }}</strong>?
                                                    </p>
                                                    <div class="mb-3">
                                                        <label for="rejection_reason" class="form-label">Rejection Reason <span
                                                                class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="rejection_reason" name="rejection_reason"
                                                            rows="3" placeholder="Please provide a reason for rejection..."
                                                            required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
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
                            <div class="empty-state">
                                <i class="bi bi-check-circle text-success"></i>
                                <h5 class="mt-3">No Pending Approvals</h5>
                                <p class="text-muted">All student registrations have been processed.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Approved Registrations -->
            <div class="tab-pane fade" id="approved" role="tabpanel">
                <div class="main-content-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-check-circle me-2"></i>Approved Registrations</h5>
                    </div>
                    <div class="card-body">
                        @if($approvedRegistrations->count() > 0)
                            @foreach($approvedRegistrations as $user)
                                <div class="registration-item">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="me-3">
                                                    @if($user->avatar)
                                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                                            class="rounded-circle"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                            style="width: 50px; height: 50px;">
                                                            <span
                                                                class="text-white fw-bold">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold">{{ $user->name ?? 'N/A' }}</h6>
                                                    <p class="text-muted mb-1">{{ $user->email ?? 'N/A' }}</p>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        <span class="status-badge status-approved">Approved</span>
                                                        <span class="text-muted small">
                                                            Approved:
                                                            {{ $user->approved_at ? $user->approved_at->format('M d, Y H:i') : 'N/A' }}
                                                        </span>
                                                        @if($user->approvedBy)
                                                            <span class="text-muted small">
                                                                by {{ $user->approvedBy->name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if($user->registration_notes)
                                                <div class="mt-2">
                                                    <small class="text-muted"><strong>Notes:</strong>
                                                        {{ $user->registration_notes }}</small>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.registration-approvals.show', $user->id) }}"
                                                class="btn btn-sm btn-outline-primary">
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
                            <div class="empty-state">
                                <i class="bi bi-check-circle text-success"></i>
                                <h5 class="mt-3">No Approved Registrations</h5>
                                <p class="text-muted">No student registrations have been approved yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Rejected Registrations -->
            <div class="tab-pane fade" id="rejected" role="tabpanel">
                <div class="main-content-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-x-circle me-2"></i>Rejected Registrations</h5>
                    </div>
                    <div class="card-body">
                        @if($rejectedRegistrations->count() > 0)
                            @foreach($rejectedRegistrations as $user)
                                <div class="registration-item">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="me-3">
                                                    @if($user->avatar)
                                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                                            class="rounded-circle"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                            style="width: 50px; height: 50px;">
                                                            <span
                                                                class="text-white fw-bold">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-bold">{{ $user->name ?? 'N/A' }}</h6>
                                                    <p class="text-muted mb-1">{{ $user->email ?? 'N/A' }}</p>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        <span class="status-badge status-rejected">Rejected</span>
                                                        <span class="text-muted small">
                                                            Rejected:
                                                            {{ $user->approved_at ? $user->approved_at->format('M d, Y H:i') : 'N/A' }}
                                                        </span>
                                                        @if($user->approvedBy)
                                                            <span class="text-muted small">
                                                                by {{ $user->approvedBy->name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if($user->rejection_reason)
                                                <div class="mt-2">
                                                    <small class="text-muted"><strong>Reason:</strong>
                                                        {{ $user->rejection_reason }}</small>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.registration-approvals.show', $user->id) }}"
                                                class="btn btn-sm btn-outline-primary">
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
                            <div class="empty-state">
                                <i class="bi bi-x-circle text-danger"></i>
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