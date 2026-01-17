@extends('layouts.app')

@section('content')
    <style>
        :root {
            --forest-green: #1f7a2d;
            --forest-green-light: #4a7c59;
            --forest-green-lighter: #e8f5e8;
            --yellow-maize: #f4d03f;
            --gray-50: #f8f9fa;
            --gray-100: #dee2e6;
            --gray-600: #6c757d;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hero-gradient: linear-gradient(135deg, var(--forest-green) 0%, #13601f 100%);
        }

        /* Match admin zoom standard */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
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
            border-color: var(--forest-green-light);
        }

        /* Checkbox styling */
        .item-checkbox {
            transform: scale(1.2);
            margin-right: 15px;
            cursor: pointer;
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

        /* Floating Action Bar */
        .bulk-action-bar {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: white;
            padding: 15px 30px;
            border-radius: 50px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 20px;
            z-index: 1000;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid var(--forest-green-lighter);
        }

        .bulk-action-bar.visible {
            transform: translateX(-50%) translateY(0);
        }

        .bulk-selected-count {
            font-weight: bold;
            color: var(--forest-green);
            background: var(--forest-green-lighter);
            padding: 5px 12px;
            border-radius: 20px;
        }
    </style>

    <div class="main-dashboard-inner home-zoom">
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



        <!-- Search and Filter Section -->
        <div class="main-content-card">
            <div class="card-body">
                <form action="{{ route('admin.registration-approvals.index') }}" method="GET">
                    <div class="row g-2 align-items-end mb-2">
                        <div class="col-md-3">
                            <label for="search"
                                class="form-label fw-bold small text-muted text-uppercase mb-1">Search</label>
                            <div class="input-group">
                                <div class="form-control d-flex align-items-center bg-white border"
                                    style="overflow: hidden;">
                                    <i class="bi bi-search text-muted me-2"></i>
                                    <input type="text" class="border-0 shadow-none w-100 p-0" id="search" name="search"
                                        value="{{ request('search') }}" placeholder="Search students..."
                                        style="outline: none;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="college"
                                class="form-label fw-bold small text-muted text-uppercase mb-1">College</label>
                            <select class="form-select" id="college" name="college">
                                <option value="">All</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college }}" {{ request('college') == $college ? 'selected' : '' }}>
                                        {{ $college }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="course"
                                class="form-label fw-bold small text-muted text-uppercase mb-1">Course</label>
                            <select class="form-select" id="course" name="course">
                                <option value="">All</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>
                                        {{ $course }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="date_from" class="form-label fw-bold small text-muted text-uppercase mb-1">From
                                Date</label>
                            <input type="date" class="form-control" id="date_from" name="date_from"
                                value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="date_to" class="form-label fw-bold small text-muted text-uppercase mb-1">To
                                Date</label>
                            <input type="date" class="form-control" id="date_to" name="date_to"
                                value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-success text-white w-100">
                                <i class="bi bi-funnel"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label for="sort" class="form-label fw-bold small text-muted text-uppercase mb-1">Sort
                                By</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First
                                </option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)
                                </option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-auto">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-1">&nbsp;</label>
                            <button type="button" class="btn btn-success d-block" data-bs-toggle="modal"
                                data-bs-target="#enrollmentVerificationModal">
                                <i class="bi bi-file-earmark-check me-1"></i>Verify Enrollment
                            </button>
                        </div>
                        <div class="col-md text-end">
                            @if(request()->anyFilled(['search', 'college', 'course', 'sort', 'date_from', 'date_to']))
                                <a href="{{ route('admin.registration-approvals.index') }}"
                                    class="btn btn-sm btn-light text-muted">
                                    <i class="bi bi-x-circle me-1"></i>Clear All Filters
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
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
                <!-- Bulk Approve Form -->
                <form id="bulkActionForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="rejection_reason" id="bulk_rejection_reason">

                    <div class="main-content-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-clock me-2"></i>Pending Approvals</h5>
                            @if($pendingRegistrations->count() > 0)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllPending">
                                    <label class="form-check-label user-select-none" for="selectAllPending">Select All</label>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($pendingRegistrations->count() > 0)
                                @foreach($pendingRegistrations as $user)
                                    <div class="registration-item">
                                        <div class="d-flex align-items-start">
                                            <div class="d-flex align-items-center h-100 pt-3">
                                                <input class="form-check-input item-checkbox user-select-checkbox" type="checkbox"
                                                    name="user_ids[]" value="{{ $user->id }}">
                                            </div>

                                            <div
                                                class="d-flex justify-content-between align-items-start flex-grow-1 flex-wrap gap-3 ms-2">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-2">
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
                                                            <h6 class="mb-1 fw-bold text-dark">{{ $user->name ?? 'N/A' }}</h6>
                                                            <p class="text-muted mb-1">{{ $user->email ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>

                                                    <!-- Improved Details Grid -->
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-md-6 col-lg-4">
                                                            <small class="text-muted d-block">Student ID</small>
                                                            <span class="fw-medium">{{ $user->student_id ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <small class="text-muted d-block">Course/Program</small>
                                                            <span class="fw-medium text-truncate d-block"
                                                                title="{{ $user->course }}">{{ $user->course ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <small class="text-muted d-block">College</small>
                                                            <span class="fw-medium text-truncate d-block"
                                                                title="{{ $user->college }}">{{ $user->college ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex gap-2 flex-wrap align-items-center mt-2">
                                                        <span class="status-badge status-pending">Pending Approval</span>
                                                        @if($user->has_potential_duplicate ?? false)
                                                            <span class="badge bg-warning text-dark"
                                                                title="Potential duplicate: {{ $user->duplicate_count }} similar record(s) found">
                                                                <i class="bi bi-exclamation-triangle me-1"></i>Duplicate Warning
                                                            </span>
                                                        @endif
                                                        <span class="text-muted small">
                                                            Registered: {{ $user->created_at->format('M d, Y H:i') }}
                                                        </span>
                                                        @if($user->cor_file)
                                                            <a href="{{ asset('storage/cor_files/' . $user->cor_file) }}"
                                                                target="_blank"
                                                                class="badge bg-light text-primary border text-decoration-none">
                                                                <i class="bi bi-file-earmark-pdf me-1"></i>COR File
                                                            </a>
                                                        @else
                                                            <span class="badge bg-light text-danger border">
                                                                <i class="bi bi-exclamation-circle me-1"></i>No COR
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2 align-self-center">
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
                                    </div>

                                    <!-- Approve Modal -->
                                    <div class="modal fade" id="approveModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Approve Registration</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                {{-- Note: We can't nest forms, so we'll handle single logic via JS or dedicated
                                                forms outside the loop if strict HTML compliance is needed.
                                                However, modal forms are usually placed at the end of body or handle themselves.
                                                In this structure, we should be careful not to nest the single act forms inside the
                                                bulk form.

                                                Actually, Blade loop is inside the bulk form. HTML forbids nested forms.
                                                FIX: We will submit single forms via JS or move modals outside.
                                                Better Fix: Use 'formaction' attribute on buttons? No, different inputs needed.
                                                Best Fix: Move modals outside the bulk form. --}}
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
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="d-flex justify-content-center mt-4">
                                    {{ $pendingRegistrations->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <h5 class="mt-3">No Pending Approvals</h5>
                                    @if(request()->anyFilled(['search', 'college', 'course']))
                                        <p class="text-muted">No students matched your search filters.</p>
                                    @else
                                        <p class="text-muted">All student registrations have been processed.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </form> <!-- End Bulk Form -->

                <!-- Single Action Modals (Loop again to place outside form) -->
                @foreach($pendingRegistrations as $user)
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
                                        <p>Are you sure you want to approve the registration for
                                            <strong>{{ $user->name }}</strong>?
                                        </p>
                                        <div class="mb-3">
                                            <label for="registration_notes" class="form-label">Approval Notes (Optional)</label>
                                            <textarea class="form-control" id="registration_notes" name="registration_notes"
                                                rows="3" placeholder="Add any notes about this approval..."></textarea>
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
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Reject Registration</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
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
                                {{ $approvedRegistrations->withQueryString()->links('vendor.pagination.bootstrap-5') }}
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
                                {{ $rejectedRegistrations->withQueryString()->links('vendor.pagination.bootstrap-5') }}
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

    <!-- Bulk Action Floating Bar -->
    <div class="bulk-action-bar" id="bulkActionBar">
        <span class="bulk-selected-count">1</span> Selected
        <div class="vr mx-2"></div>
        <button type="button" class="btn btn-success rounded-pill px-4" onclick="submitBulkAction('approve')">
            <i class="bi bi-check-circle me-1"></i>Approve
        </button>
        <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-toggle="modal"
            data-bs-target="#bulkRejectModal">
            <i class="bi bi-x-circle me-1"></i>Reject
        </button>
    </div>

    <!-- Bulk Reject Reason Modal -->
    <div class="modal fade" id="bulkRejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Reject Students</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bulk_reason_input" class="form-label">Rejection Reason <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" id="bulk_reason_input" rows="3"
                            placeholder="Please provide a reason for rejecting the selected students..."
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="submitBulkAction('reject')">Confirm
                        Rejection</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAllPending');
            const checkboxes = document.querySelectorAll('.user-select-checkbox');
            const actionBar = document.getElementById('bulkActionBar');
            const selectedCountSpan = document.querySelector('.bulk-selected-count');

            window.updateActionBar = function () {
                const selected = document.querySelectorAll('.user-select-checkbox:checked').length;
                selectedCountSpan.textContent = selected;
                if (selected > 0) {
                    actionBar.classList.add('visible');
                } else {
                    actionBar.classList.remove('visible');
                }
            };

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateActionBar();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    updateActionBar();
                    // Update select all state
                    if (selectAll) {
                        const allChecked = document.querySelectorAll('.user-select-checkbox:checked').length === checkboxes.length;
                        selectAll.checked = allChecked;
                    }
                });
            });
        });

        function submitBulkAction(action) {
            const form = document.getElementById('bulkActionForm');
            if (action === 'approve') {
                if (confirm('Are you sure you want to approve the selected students?')) {
                    form.action = "{{ route('admin.registration-approvals.bulk-approve') }}";
                    form.submit();
                }
            } else if (action === 'reject') {
                const reason = document.getElementById('bulk_reason_input').value;
                if (!reason) {
                    alert('Please provide a rejection reason.');
                    return;
                } // The modal validates via required, but we are submitting via JS so we need manual check

                document.getElementById('bulk_rejection_reason').value = reason;
                form.action = "{{ route('admin.registration-approvals.bulk-reject') }}";
                form.submit();
            }
        }

        // Enrollment Verification File Upload
        window.verifyEnrollment = async function (btn) {
            const verificationForm = document.getElementById('enrollmentVerificationForm');
            const fileInput = document.getElementById('enrollment_file');
            const verificationResults = document.getElementById('verificationResults');

            if (!fileInput || !verificationForm) return;

            // Clear previous errors
            if (verificationResults) verificationResults.innerHTML = '';

            const file = fileInput.files[0];

            if (!file) {
                if (verificationResults) {
                    verificationResults.innerHTML = '<div class="alert alert-danger">Please select a file first.</div>';
                } else {
                    alert('Please select a file first.');
                }
                return;
            }

            // Show loading state
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            if (verificationResults) {
                verificationResults.innerHTML = '<div class="text-center"><div class="spinner-border text-success" role="status"></div><p class="mt-2">Analyzing enrollment file...</p></div>';
            }

            const formData = new FormData();
            formData.append('enrollment_file', file);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const response = await fetch('{{ route("admin.registration-approvals.verify-enrollment") }}', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Auto-select matched students
                    if (data.matched_ids) {
                        data.matched_ids.forEach(id => {
                            const checkbox = document.querySelector(`input[name="user_ids[]"][value="${id}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                                // Add visual indicator
                                const card = checkbox.closest('.registration-item');
                                if (card) {
                                    card.style.borderLeft = '4px solid #28a745';
                                    card.style.backgroundColor = '#f8fff9';
                                    // Add verified badge
                                    const badge = document.createElement('span');
                                    badge.className = 'badge bg-success ms-2 verified-badge';
                                    badge.innerHTML = '<i class="bi bi-check-circle me-1"></i>Verified';
                                    const statusArea = card.querySelector('.text-muted.small');
                                    if (statusArea) {
                                        const existingBadge = card.querySelector('.verified-badge');
                                        if (!existingBadge) statusArea.insertAdjacentElement('afterend', badge);
                                    }
                                }
                            }
                        });
                    }

                    // Update action bar visibility
                    if (typeof updateActionBar === 'function') {
                        updateActionBar();
                    }

                    if (verificationResults) {
                        verificationResults.innerHTML = `
                                            <div class="alert alert-success">
                                                <h6><i class="bi bi-check-circle me-2"></i>Enrollment Verification Complete</h6>
                                                <p class="mb-2"><strong>${data.total_matched}</strong> student(s) matched out of <strong>${data.total_enrollment}</strong> in enrollment file.</p>
                                                <p class="mb-0 small">Matched students have been auto-selected and highlighted in green.</p>
                                            </div>
                                            ${data.match_details && data.match_details.length > 0 ? `
                                                <div class="mt-3">
                                                    <h6>Matched Students:</h6>
                                                    <div class="list-group">
                                                        ${data.match_details.map(student => `
                                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <strong>${student.name}</strong>
                                                                    <br><small class="text-muted">${student.student_id} • ${student.email}</small>
                                                                </div>
                                                                <span class="badge bg-success">${student.reasons}</span>
                                                            </div>
                                                        `).join('')}
                                                    </div>
                                                </div>
                                            ` : ''}
                                        `;
                    }

                } else {
                    if (verificationResults) {
                        verificationResults.innerHTML = `
                                            <div class="alert alert-danger">
                                                <i class="bi bi-exclamation-triangle me-2"></i>${data.message}
                                            </div>
                                        `;
                    }
                }

            } catch (error) {
                console.error('Verify error:', error);
                if (verificationResults) {
                    verificationResults.innerHTML = `
                                        <div class="alert alert-danger">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Error processing file: ${error.message}
                                        </div>
                                    `;
                }
            } finally {
                // Reset button
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-upload me-2"></i>Process File';
                }
            }
        };

        // Reset modal on close
        document.addEventListener('DOMContentLoaded', function () {
            const verificationModal = document.getElementById('enrollmentVerificationModal');
            if (verificationModal) {
                verificationModal.addEventListener('hidden.bs.modal', function () {
                    const form = document.getElementById('enrollmentVerificationForm');
                    const results = document.getElementById('verificationResults');
                    const btn = document.getElementById('uploadEnrollmentBtn');

                    if (form) form.reset();
                    if (results) results.innerHTML = '';
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-upload me-2"></i>Process File';
                    }
                });
            }
        });
    </script>

    <!-- Enrollment Verification Modal -->
    <div class="modal fade" id="enrollmentVerificationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-check me-2"></i>Verify Enrollment File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Upload your enrollment list</strong> (Excel or CSV) and we'll automatically match and select
                        registered students.
                    </div>

                    <form id="enrollmentVerificationForm">
                        <div class="mb-3">
                            <label for="enrollment_file" class="form-label">Enrollment File</label>
                            <input type="file" class="form-control" id="enrollment_file" accept=".xlsx,.xls,.csv" required>
                            <div class="form-text">
                                Accepted formats: Excel (.xlsx, .xls) or CSV (.csv). Max size: 5MB
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Required Columns</label>
                            <ul class="small text-muted mb-0">
                                <li><strong>Student ID</strong> (or "ID Number", "Student Number")</li>
                                <li><strong>Name</strong> (or "Full Name", "Student Name")</li>
                                <li><strong>Email</strong> (or "Email Address", "Student Email")</li>
                            </ul>
                            <p class="small text-muted mt-2 mb-0">
                                <i class="bi bi-lightbulb me-1"></i>Extra columns are fine - they'll be ignored
                                automatically!
                            </p>
                        </div>
                    </form>

                    <!-- Results Area -->
                    <div id="verificationResults" class="mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="uploadEnrollmentBtn" onclick="verifyEnrollment(this)">
                        <i class="bi bi-upload me-2"></i>Process File
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection