@extends('layouts.app')

@section('content')
    <style>
        /* Premium Page Layout */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--forest-green);
            margin: 0;
            letter-spacing: -0.5px;
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon.primary {
            background: var(--light-green);
            color: var(--primary-green);
        }

        .stat-icon.success {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .stat-icon.warning {
            background: #fff8e1;
            color: #fbc02d;
        }

        .stat-icon.danger {
            background: #ffebee;
            color: #c62828;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .stat-info p {
            margin: 0;
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Filter Bar */
        .filter-bar {
            background: #fff;
            padding: 1.25rem;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .filter-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary-green);
            text-transform: uppercase;
            margin-bottom: 0.4rem;
            display: block;
        }

        .filter-select,
        .filter-input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            width: 100%;
            height: 38px;
        }

        .filter-select:focus,
        .filter-input:focus {
            border-color: var(--primary-green);
            outline: none;
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
        }

        /* Tabs & Content */
        .nav-pills .nav-link {
            border-radius: 50px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            color: #64748b;
            margin-right: 0.5rem;
            border: 1px solid transparent;
            transition: all 0.2s;
        }

        .nav-pills .nav-link.active {
            background-color: var(--forest-green);
            color: #fff;
            box-shadow: 0 4px 6px -1px rgba(31, 122, 45, 0.2);
        }

        .nav-pills .nav-link:hover:not(.active) {
            background-color: #f8fafc;
            color: var(--forest-green);
        }

        /* Premium Registration Item */
        .registration-item {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }

        .registration-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: rgba(31, 122, 45, 0.15);
        }

        .item-checkbox {
            width: 1.2em;
            height: 1.2em;
            cursor: pointer;
            border: 2px solid #cbd5e1;
            border-radius: 4px;
        }

        .item-checkbox:checked {
            background-color: var(--forest-green);
            border-color: var(--forest-green);
        }

        .status-badge {
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .status-pending {
            background: #fff7ed;
            color: #ea580c;
            border: 1px solid #ffedd5;
        }

        .status-approved {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .status-rejected {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* Actions */
        .btn-action-pill {
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.2s;
        }

        .btn-approve {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .btn-approve:hover {
            background: #15803d;
            color: #fff;
        }

        .btn-reject {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .btn-reject:hover {
            background: #dc2626;
            color: #fff;
        }

        .bulk-action-bar {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            z-index: 1050;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .bulk-action-bar.visible {
            transform: translateX(-50%) translateY(0);
        }
    </style>

    <div class="main-dashboard-inner home-zoom">
        <!-- Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Registration Approvals</h1>
                <p class="text-muted mb-0 mt-1">Review and manage student registration requests</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold shadow-sm">
                    <i class="bi bi-people me-2"></i>All Users
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm fw-semibold shadow-sm">
                    <i class="bi bi-grid me-2"></i>Dashboard
                </a>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $pendingRegistrations->total() }}</h3>
                    <p>Pending Review</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $approvedRegistrations->total() }}</h3>
                    <p>Approved Today</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon danger">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $rejectedRegistrations->total() }}</h3>
                    <p>Rejected</p>
                </div>
            </div>
        </div>



        <!-- Filter Bar -->
        <div class="filter-bar">
            <form action="{{ route('admin.registration-approvals.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="filter-label"><i class="bi bi-search me-1"></i> Search</label>
                        <input type="text" class="filter-input" name="search" value="{{ request('search') }}"
                            placeholder="Student name, ID, or email...">
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">College</label>
                        <select class="filter-select" name="college" onchange="this.form.submit()">
                            <option value="">All Colleges</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college }}" {{ request('college') == $college ? 'selected' : '' }}>
                                    {{ $college }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">Course</label>
                        <select class="filter-select" name="course" onchange="this.form.submit()">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>
                                    {{ $course }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">From Date</label>
                        <input type="date" class="filter-input" name="date_from" value="{{ request('date_from') }}"
                            onchange="this.form.submit()">
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">To Date</label>
                        <input type="date" class="filter-input" name="date_to" value="{{ request('date_to') }}"
                            onchange="this.form.submit()">
                    </div>
                    <div class="col-md-2">
                        <label class="filter-label">Sort By</label>
                        <select class="filter-select" name="sort" onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button"
                            class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2"
                            style="height: 38px; border-radius: 8px;" data-bs-toggle="modal"
                            data-bs-target="#enrollmentVerificationModal">
                            <i class="bi bi-file-earmark-check"></i> Verify
                        </button>
                    </div>
                    <div class="col-md-8 d-flex align-items-end justify-content-end">
                        @if(request()->anyFilled(['search', 'college', 'course', 'sort', 'date_from', 'date_to']))
                            <a href="{{ route('admin.registration-approvals.index') }}" class="btn btn-danger btn-sm px-3"
                                style="height: 38px; display: flex; align-items: center; border-radius: 8px;">
                                <i class="bi bi-x-circle me-1"></i> Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-pills mb-4" id="approvalTabs" role="tablist">
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

                    <!-- Floating Bulk Action Bar -->
                    <div class="bulk-action-bar" id="bulkActionBar">
                        <div class="d-flex align-items-center gap-3">
                            <span class="bulk-selected-count" id="selectedCount">0 Selected</span>
                            <div class="vr"></div>
                            <button type="button" class="btn btn-approve btn-sm rounded-pill fw-bold px-3"
                                onclick="submitBulkAction('approve')">
                                <i class="bi bi-check-lg me-1"></i> Approve Selected
                            </button>
                            <button type="button" class="btn btn-reject btn-sm rounded-pill fw-bold px-3"
                                onclick="submitBulkAction('reject')">
                                <i class="bi bi-x-lg me-1"></i> Reject Selected
                            </button>
                        </div>
                    </div>

                    @if($pendingRegistrations->count() > 0)
                        <!-- List Header (Select All) -->
                        <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                            <div class="form-check">
                                <input class="form-check-input item-checkbox" type="checkbox" id="selectAllPending">
                                <label class="form-check-label fw-bold text-muted" for="selectAllPending">Select All
                                    Pending</label>
                            </div>
                            <div class="text-muted small">
                                Showing {{ $pendingRegistrations->firstItem() }}-{{ $pendingRegistrations->lastItem() }} of
                                {{ $pendingRegistrations->total() }}
                            </div>
                        </div>

                        @foreach($pendingRegistrations as $user)
                            <div class="registration-item p-4">
                                <div class="d-flex align-items-center gap-4">
                                    <div>
                                        <input class="form-check-input item-checkbox user-select-checkbox" type="checkbox"
                                            name="user_ids[]" value="{{ $user->id }}">
                                    </div>

                                    <div class="d-flex align-items-center gap-4 flex-grow-1">
                                        <!-- User Avatar -->
                                        <div class="position-relative">
                                            @if($user->avatar)
                                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                                    class="rounded-circle shadow-sm"
                                                    style="width: 48px; height: 48px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow-sm"
                                                    style="width: 48px; height: 48px;">
                                                    <span
                                                        class="fw-bold text-success">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- User Details (Relaxed) -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0 fw-bold text-dark fs-6">{{ $user->name ?? 'N/A' }}</h6>
                                                <small class="text-muted"><i
                                                        class="bi bi-clock me-1"></i>{{ $user->created_at->format('M d, h:i A') }}</small>
                                            </div>
                                            <div class="mb-1 text-muted small">
                                                {{ $user->email ?? 'N/A' }}
                                                @if($user->has_potential_duplicate ?? false)
                                                    <span class="badge bg-warning text-dark border border-warning ms-2"
                                                        title="Potential duplicate: {{ $user->duplicate_count }} similar record(s) found">
                                                        <i class="bi bi-exclamation-triangle"></i>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-muted small">
                                                <span class="fw-medium text-dark">{{ $user->student_id ?? 'N/A' }}</span>
                                                <span class="mx-2 text-muted">&bull;</span>
                                                <span class="text-truncate" style="max-width: 200px;"
                                                    title="{{ $user->course }}">{{ $user->course ?? 'N/A' }}</span>
                                                <span class="mx-2 text-muted">&bull;</span>
                                                <span class="text-truncate" style="max-width: 200px;"
                                                    title="{{ $user->college }}">{{ $user->college ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions (Right) -->
                                    <div class="d-flex align-items-center gap-2 border-start ps-4">
                                        <!-- COR Preview -->
                                        @if($user->cor_file)
                                            <button type="button" class="btn btn-light btn-sm text-danger border" data-bs-toggle="modal"
                                                data-bs-target="#corPreviewModal{{ $user->id }}" title="View COR File">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-light btn-sm text-muted border" disabled
                                                title="No COR File">
                                                <i class="bi bi-file-earmark-x"></i>
                                            </button>
                                        @endif

                                        <a href="{{ route('admin.registration-approvals.show', $user->id) }}"
                                            class="btn btn-light btn-sm rounded-pill px-3 border" title="Review Details">
                                            Review
                                        </a>
                                        <button type="button" class="btn btn-success btn-sm rounded-pill px-3"
                                            onclick="confirmAction('{{ route('admin.registration-approvals.approve', $user->id) }}', 'Approve {{ addslashes($user->name) }}?')">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm rounded-pill px-3"
                                            onclick="confirmRejectAction('{{ route('admin.registration-approvals.reject', $user->id) }}', 'Reject {{ addslashes($user->name) }}?')">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="d-flex align-items-center gap-2">
                                <label class="text-muted small mb-0">Per page:</label>
                                <select class="form-select form-select-sm rounded-3" style="width: auto;"
                                    onchange="changePerPage(this.value)">
                                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    <option value="500" {{ request('per_page') == 500 ? 'selected' : '' }}>500</option>
                                    <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>1000</option>
                                </select>
                            </div>
                            <div>
                                {{ $pendingRegistrations->withQueryString()->links('vendor.pagination.premium-simple') }}
                            </div>
                        </div>

                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="bi bi-check-lg text-success fs-1"></i>
                                </div>
                            </div>
                            <h4 class="fw-bold text-dark">No Pending Approvals</h4>
                            <p class="text-muted">Great job! All registration requests have been processed.</p>
                        </div>
                    @endif
                </form> <!-- End Bulk Form -->



                <!-- COR File Preview Modal -->
                @foreach($pendingRegistrations as $user)
                    @if($user->cor_file)
                        <div class="modal fade" id="corPreviewModal{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="bi bi-file-earmark-pdf me-2"></i>COR File -
                                            {{ $user->name }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        @php
                                            $extension = pathinfo($user->cor_file, PATHINFO_EXTENSION);
                                        @endphp

                                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            <div class="p-3 text-center bg-light">
                                                <img src="{{ asset('storage/cor_files/' . $user->cor_file) }}"
                                                    class="img-fluid rounded shadow-sm" style="max-height: 70vh; object-fit: contain;"
                                                    alt="COR File">
                                            </div>
                                        @else
                                            <iframe src="{{ asset('storage/cor_files/' . $user->cor_file) }}"
                                                style="width: 100%; height: 70vh; border: none;"></iframe>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ asset('storage/cor_files/' . $user->cor_file) }}" target="_blank"
                                            class="btn btn-primary">
                                            <i class="bi bi-download me-1"></i>Open in New Tab
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Approved Registrations -->

            <div class="tab-pane fade" id="approved" role="tabpanel">
                @if($approvedRegistrations->count() > 0)
                    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                        <div class="text-muted small">
                            Showing {{ $approvedRegistrations->firstItem() }}-{{ $approvedRegistrations->lastItem() }} of
                            {{ $approvedRegistrations->total() }}
                        </div>
                    </div>


                    @foreach($approvedRegistrations as $user)
                        <div class="registration-item p-4">
                            <div class="d-flex align-items-center gap-4">
                                <!-- Avatar -->
                                <div class="position-relative">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle shadow-sm"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 48px; height: 48px;">
                                            <span class="fw-bold text-success">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Details -->
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <h6 class="mb-0 fw-bold text-dark fs-6">{{ $user->name ?? 'N/A' }}</h6>
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success border border-success fw-normal py-0 px-2"
                                                style="font-size: 0.75rem;">Approved</span>
                                        </div>
                                        <small class="text-muted"><i
                                                class="bi bi-calendar-check me-1"></i>{{ $user->approved_at ? $user->approved_at->format('M d, h:i A') : 'N/A' }}</small>
                                    </div>
                                    <div class="mb-1 text-muted small">
                                        {{ $user->email ?? 'N/A' }}
                                    </div>
                                    <div class="text-muted small">
                                        @if($user->approvedBy)
                                            <span class="text-muted">Approved by {{ $user->approvedBy->name }}</span>
                                        @endif
                                        @if($user->registration_notes)
                                            <span class="border-start ps-3 ms-3 text-truncate d-inline-block align-bottom"
                                                style="max-width: 300px;" title="{{ $user->registration_notes }}">
                                                <i class="bi bi-sticky me-1"></i>{{ $user->registration_notes }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="border-start ps-4">
                                    <a href="{{ route('admin.registration-approvals.show', $user->id) }}"
                                        class="btn btn-light btn-sm rounded-pill px-3 fw-bold border" title="View Details">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted small mb-0">Per page:</label>
                            <select class="form-select form-select-sm rounded-3" style="width: auto;"
                                onchange="changePerPage(this.value)">
                                <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                <option value="500" {{ request('per_page') == 500 ? 'selected' : '' }}>500</option>
                                <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>1000</option>
                            </select>
                        </div>
                        <div>
                            {{ $approvedRegistrations->withQueryString()->links('vendor.pagination.premium-simple') }}
                        </div>
                    </div>

                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-check-circle text-success fs-1"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-dark">No Approved Registrations</h4>
                        <p class="text-muted">Approved student registrations will appear here.</p>
                    </div>
                @endif
            </div>

            <!-- Rejected Registrations -->
            <div class="tab-pane fade" id="rejected" role="tabpanel">
                @if($rejectedRegistrations->count() > 0)
                    <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                        <div class="text-muted small">
                            Showing {{ $rejectedRegistrations->firstItem() }}-{{ $rejectedRegistrations->lastItem() }} of
                            {{ $rejectedRegistrations->total() }}
                        </div>
                    </div>


                    @foreach($rejectedRegistrations as $user)
                        <div class="registration-item p-4">
                            <div class="d-flex align-items-center gap-4">
                                <!-- Avatar -->
                                <div class="position-relative">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle shadow-sm"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center shadow-sm"
                                            style="width: 48px; height: 48px;">
                                            <span class="fw-bold text-success">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Details -->
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <h6 class="mb-0 fw-bold text-dark fs-6">{{ $user->name ?? 'N/A' }}</h6>
                                            <span
                                                class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-normal py-0 px-2"
                                                style="font-size: 0.75rem;">Rejected</span>
                                        </div>
                                        <small class="text-muted"><i
                                                class="bi bi-calendar-x me-1"></i>{{ $user->approved_at ? $user->approved_at->format('M d, h:i A') : 'N/A' }}</small>
                                    </div>
                                    <div class="mb-1 text-muted small">
                                        {{ $user->email ?? 'N/A' }}
                                    </div>
                                    <div class="text-muted small">
                                        @if($user->approvedBy)
                                            <span class="text-muted">Rejected by {{ $user->approvedBy->name }}</span>
                                        @endif
                                        @if($user->rejection_reason)
                                            <span class="border-start ps-3 ms-3 text-danger text-truncate d-inline-block align-bottom"
                                                style="max-width: 300px;" title="{{ $user->rejection_reason }}">
                                                <i class="bi bi-exclamation-circle me-1"></i>{{ $user->rejection_reason }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="border-start ps-4">
                                    <a href="{{ route('admin.registration-approvals.show', $user->id) }}"
                                        class="btn btn-light btn-sm rounded-pill px-3 fw-bold border" title="View Details">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted small mb-0">Per page:</label>
                            <select class="form-select form-select-sm rounded-3" style="width: auto;"
                                onchange="changePerPage(this.value)">
                                <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                <option value="500" {{ request('per_page') == 500 ? 'selected' : '' }}>500</option>
                                <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>1000</option>
                            </select>
                        </div>
                        <div>
                            {{ $rejectedRegistrations->withQueryString()->links('vendor.pagination.premium-simple') }}
                        </div>
                    </div>

                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-x-circle text-danger fs-1"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-dark">No Rejected Registrations</h4>
                        <p class="text-muted">Rejected student registrations will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>



    <script>
        // Per Page Selector Function
        function changePerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            url.searchParams.delete('pending_page'); // Reset to page 1
            url.searchParams.delete('approved_page'); // Reset to page 1
            url.searchParams.delete('rejected_page'); // Reset to page 1
            window.location.href = url.toString();
        }

        // Clear Verified Enrollment Function
        function clearVerifiedEnrollment() {
            sessionStorage.removeItem('verified_enrollment_ids');
            window.location.reload();
        }

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
                const count = document.querySelectorAll('.user-select-checkbox:checked').length;
                Swal.fire({
                    title: 'Approve Students?',
                    text: `Are you sure you want to approve the ${count} selected student(s)?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1f7a2d',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Approve All'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.action = "{{ route('admin.registration-approvals.bulk-approve') }}";
                        form.submit();
                    }
                });
            } else if (action === 'reject') {
                const count = document.querySelectorAll('.user-select-checkbox:checked').length;
                Swal.fire({
                    title: 'Reject Students',
                    text: `Please provide a reason for rejecting the ${count} selected student(s):`,
                    input: 'textarea',
                    inputPlaceholder: 'Reason for rejection...',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Reject All',
                    cancelButtonText: 'Cancel',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'You need to write a reason!'
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value) {
                        document.getElementById('bulk_rejection_reason').value = result.value;
                        form.action = "{{ route('admin.registration-approvals.bulk-reject') }}";
                        form.submit();
                    }
                });
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
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                // Check for non-OK response first
                if (!response.ok) {
                    // Start by trying to parse JSON error (e.g. valid 422 validation error)
                    try {
                        const errorData = await response.json();
                        if (errorData.message) {
                            throw new Error(errorData.message);
                        }
                    } catch (ignore) { }

                    // If not JSON, try text
                    const text = await response.text();
                    let errorMsg = 'Server Error: ' + response.status;
                    if (text) {
                        let match = text.match(/<title>(.*?)<\/title>/i);
                        if (match) errorMsg += ' - ' + match[1];
                        else errorMsg += ' - ' + text.substring(0, 100);
                    }
                    throw new Error(errorMsg);
                }

                const data = await response.json();

                if (data.success) {
                    // Auto-select matched students
                    if (data.matched_ids) {
                        // Store matched IDs in sessionStorage for cross-page selection
                        sessionStorage.setItem('verified_enrollment_ids', JSON.stringify(data.matched_ids));

                        // Check boxes for currently visible students
                        let visibleMatches = 0;
                        data.matched_ids.forEach(id => {
                            const checkbox = document.querySelector(`input[name="user_ids[]"][value="${id}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                                visibleMatches++;
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

                        // Notify about students on other pages
                        const hiddenMatches = data.matched_ids.length - visibleMatches;
                        if (hiddenMatches > 0) {
                            console.log(`${hiddenMatches} matched student(s) are on other pages and will be auto-selected when you navigate to those pages.`);
                        }
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
                                                                                                                                                                                                        <h6>Matched Students (showing first 50):</h6>
                                                                                                                                                                                                        <div class="list-group" style="max-height: 400px; overflow-y: auto;">
                                                                                                                                                                                                            ${data.match_details.slice(0, 50).map(student => `
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
                // Clean up the error message
                let msg = error.message.replace(/&quot;/g, '"').replace(/&lt;/g, '<').replace(/&gt;/g, '>');

                if (verificationResults) {
                    verificationResults.innerHTML = `
                                                                                                                                                                                            <div class="alert alert-danger">
                                                                                                                                                                                                <i class="bi bi-exclamation-triangle me-2"></i>${msg}
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
    </div>
    </div>

    <!-- Universal Hidden Action Form -->
    <form id="actionForm" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check for success/error messages from redirect
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#1f7a2d'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#dc3545'
                });
            @endif
                                                                                                });

        function confirmAction(url, message) {
            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1f7a2d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('actionForm');
                    form.action = url;
                    form.submit();
                }
            });
        }

        function confirmRejectAction(url, message) {
            Swal.fire({
                title: 'Reject Registration',
                text: "Please provide a reason for rejection:",
                input: 'textarea',
                inputPlaceholder: 'Reason for rejection...',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Reject Registration',
                cancelButtonText: 'Cancel',
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to write a reason!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const form = document.getElementById('actionForm');
                    form.action = url;

                    // Create hidden input for reason
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'rejection_reason';
                    input.value = result.value;
                    form.appendChild(input);

                    form.submit();
                }
            });
        }
    </script>
@endsection