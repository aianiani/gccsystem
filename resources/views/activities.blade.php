@extends('layouts.app')

@section('content')
    <style>
        /* Premium Theme Variables */
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
            --forest-green: var(--primary-green);
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

        /* Page Header */
        .page-header {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: end;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            background: var(--hero-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Stats Cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
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

        .stat-icon.info {
            background: #e0f2fe;
            color: #0284c7;
        }

        .stat-icon.warning {
            background: #fffbeb;
            color: #b45309;
        }
        
        .stat-icon.danger {
            background: #fef2f2;
            color: #dc2626;
        }

        .stat-info h3 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-dark);
        }

        .stat-info p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* Filter styling */
        .filter-bar {
            background: #fff;
            padding: 1rem 1.25rem;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.25rem;
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

        .filter-input,
        .filter-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            width: 100%;
            height: 38px;
        }

        .filter-input:focus,
        .filter-select:focus {
            border-color: var(--primary-green);
            outline: none;
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
        }

        /* Premium Table */
        .content-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .premium-table {
            width: 100%;
            border-collapse: collapse;
        }

        .premium-table thead th {
            background: #f8fafc;
            padding: 0.9rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }

        .premium-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
        }

        .premium-table tbody tr:hover {
            background: #fcfcfd;
        }

        /* User Cell */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .user-info h6 {
            margin: 0;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-dark);
        }

        .user-info span {
            font-size: 0.75rem;
            color: #64748b;
            display: block;
        }

        /* Badges */
        .premium-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Role Badges */
        .badge-role-admin { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .badge-role-student { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .badge-role-counselor { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

        /* Action Badges matched from old view but premium stylized */
        .badge-action-login { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-action-logout { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .badge-action-create { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-action-update { background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; }
        .badge-action-delete { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

        /* Checkbox */
        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            cursor: pointer;
            border: 2px solid #cbd5e1;
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        /* Details tooltips and layout */
        .details-cell {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: var(--text-light);
            font-size: 0.8rem;
        }

        .backdrop-blur { backdrop-filter: blur(8px); }
    </style>

    <div class="main-dashboard-inner home-zoom">
        <!-- Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Activity Logs</h1>
                <p class="text-muted mb-0 mt-1">Audit trail of system interactions and user security events</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('activities.export', request()->all()) }}"
                    class="btn btn-success btn-sm fw-semibold shadow-sm text-white"
                    style="background: var(--primary-green); border: none;">
                    <i class="bi bi-file-earmark-excel me-2"></i>Export Logs
                </a>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="bi bi-activity"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Total Logs</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ number_format($stats['today']) }}</h3>
                    <p>Events Today</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ number_format($stats['logins_today']) }}</h3>
                    <p>Logins Today</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon danger">
                    <i class="bi bi-shield-exclamation"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ number_format($stats['security_events']) }}</h3>
                    <p>Critical Actions</p>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="filter-bar">
            <form method="GET" action="{{ route('activities') }}" id="filterForm">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-3">
                        <label class="filter-label"><i class="bi bi-search me-1"></i> Search</label>
                        <input type="text" class="filter-input" name="search" placeholder="User, IP, or Description..."
                            value="{{ request('search') }}">
                    </div>

                    <!-- Action Filter -->
                    <div class="col-md-2">
                        <label class="filter-label">Action</label>
                        <select class="filter-select" name="action" onchange="this.form.submit()">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $action)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Role Filter -->
                    <div class="col-md-2">
                        <label class="filter-label">User Role</label>
                        <select class="filter-select" name="role" onchange="this.form.submit()">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="counselor" {{ request('role') == 'counselor' ? 'selected' : '' }}>Counselor</option>
                            <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="col-md-2">
                        <label class="filter-label">From Date</label>
                        <input type="date" class="filter-input" name="date_from" value="{{ request('date_from') }}" onchange="this.form.submit()">
                    </div>

                    <!-- Date To -->
                    <div class="col-md-2">
                        <label class="filter-label">To Date</label>
                        <input type="date" class="filter-input" name="date_to" value="{{ request('date_to') }}" onchange="this.form.submit()">
                    </div>

                    <!-- Clear Filter -->
                    <div class="col-md-1 d-flex align-items-end">
                        @if(request()->anyFilled(['search', 'action', 'role', 'date_from', 'date_to']))
                            <a href="{{ route('activities') }}" class="btn btn-outline-danger w-100" style="height: 38px;" title="Clear Filters">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Content Card -->
        <div class="content-card">
            @if($activities->count() > 0)
                <div class="table-responsive">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 40px;">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>USER</th>
                                <th>ROLE</th>
                                <th>ACTION</th>
                                <th>DESCRIPTION</th>
                                <th>METADATA</th>
                                <th class="text-end pe-4">DATE & TIME</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    <td class="ps-4">
                                        <input type="checkbox" class="form-check-input item-checkbox" value="{{ $activity->id }}">
                                    </td>
                                    <td>
                                        @if($activity->user)
                                            <div class="user-cell">
                                                @if($activity->user->avatar)
                                                    <img src="{{ asset('storage/avatars/' . $activity->user->avatar) }}" alt="Avatar" class="user-avatar">
                                                @else
                                                    <div class="user-avatar bg-light d-flex align-items-center justify-content-center text-primary fw-bold" style="font-size: 0.8rem;">
                                                        {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="user-info">
                                                    <h6>{{ $activity->user->name }}</h6>
                                                    <span>{{ $activity->user->email }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="user-cell">
                                                <div class="user-avatar bg-light d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-robot text-muted"></i>
                                                </div>
                                                <div class="user-info">
                                                    <h6>System / Deleted User</h6>
                                                    <span>N/A</span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($activity->user)
                                            <span class="premium-badge badge-role-{{ $activity->user->role }}">
                                                {{ ucfirst($activity->user->role) }}
                                            </span>
                                        @else
                                            <span class="text-muted small">System</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $actionType = 'default';
                                            if(Str::contains($activity->action, 'login')) $actionType = 'login';
                                            elseif(Str::contains($activity->action, 'logout')) $actionType = 'logout';
                                            elseif(Str::contains($activity->action, ['create', 'store', 'register'])) $actionType = 'create';
                                            elseif(Str::contains($activity->action, ['update', 'edit', 'toggle'])) $actionType = 'update';
                                            elseif(Str::contains($activity->action, ['delete', 'destroy', 'remove'])) $actionType = 'delete';
                                        @endphp
                                        <span class="premium-badge badge-action-{{ $actionType }}">
                                            {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="details-cell" title="{{ $activity->description }}">
                                            {{ $activity->description }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column small">
                                            <span class="text-muted mb-1"><i class="bi bi-globe me-1"></i>{{ $activity->ip_address }}</span>
                                            <span class="text-muted d-none d-lg-block" title="{{ $activity->user_agent }}">
                                                <i class="bi bi-browser-chrome me-1"></i>{{ Str::limit($activity->user_agent, 15) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="fw-medium text-dark">{{ $activity->created_at->format('M d, Y') }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ $activity->created_at->format('h:i A') }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div class="text-muted small">
                        Showing <strong>{{ $activities->firstItem() ?? 0 }}</strong> - <strong>{{ $activities->lastItem() ?? 0 }}</strong>
                        of <strong>{{ $activities->total() }}</strong>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <select class="form-select form-select-sm" style="width: auto; border-radius: 6px;"
                            onchange="window.location.href='{{ route('activities', array_merge(request()->query(), ['per_page' => ''])) }}' + this.value">
                            <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15 / page</option>
                            <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30 / page</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / page</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / page</option>
                        </select>
                        {{ $activities->links('vendor.pagination.premium-simple') }}
                    </div>
                </div>
            @else
                <div class="py-5 text-center">
                    <div class="mb-3">
                        <i class="bi bi-list-task text-muted opacity-25" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="fw-bold text-secondary">No activity logs found</h5>
                    <p class="text-muted">Try adjusting your filters or search terms.</p>
                </div>
            @endif
        </div>

        <!-- Bulk Action Bar -->
        <div id="bulkActionBar" class="position-fixed bottom-0 start-50 translate-middle-x mb-4" style="display: none; z-index: 1050;">
            <div class="d-flex align-items-center gap-3 bg-dark text-white p-2 px-3 rounded-pill shadow-lg border border-secondary bg-opacity-90 backdrop-blur">
                <div class="d-flex align-items-center border-end border-secondary pe-3 me-1">
                    <span class="fw-bold me-2 text-warning"><span id="selectedCount">0</span></span>
                    <span class="text-white-50 small me-2 d-none d-sm-inline">Selected</span>
                    <button type="button" class="btn btn-link text-white-50 btn-sm p-0 text-decoration-none" onclick="clearSelection()" title="Clear Selection">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 py-1 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                        <i class="bi bi-trash3-fill"></i> <span class="small fw-semibold">Delete Logs</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="bulkDeleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Confirm Bulk Delete</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <strong><span id="deleteCountText">0</span> activity log(s)</strong>?</p>
                        <p class="text-danger mb-0 small"><i class="bi bi-info-circle me-1"></i>This audit trail data will be permanently removed.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form id="bulkDeleteForm" method="POST" action="{{ route('activities.bulk-delete') }}">
                            @csrf
                            <div id="bulkDeleteInputs"></div>
                            <button type="submit" class="btn btn-danger">Delete Permanently</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript for Bulk Selection -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const bulkBar = document.getElementById('bulkActionBar');
            const selectedCountDisplay = document.getElementById('selectedCount');
            const deleteCountText = document.getElementById('deleteCountText');
            const bulkDeleteInputs = document.getElementById('bulkDeleteInputs');

            function updateBulkBar() {
                const checked = document.querySelectorAll('.item-checkbox:checked');
                const count = checked.length;
                
                if (count > 0) {
                    bulkBar.style.display = 'block';
                    selectedCountDisplay.textContent = count;
                    deleteCountText.textContent = count;
                    
                    // Update hidden inputs for delete form
                    bulkDeleteInputs.innerHTML = '';
                    checked.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = cb.value;
                        bulkDeleteInputs.appendChild(input);
                    });
                } else {
                    bulkBar.style.display = 'none';
                }
            }

            if(selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                    updateBulkBar();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!this.checked) selectAll.checked = false;
                    else if (document.querySelectorAll('.item-checkbox:checked').length === checkboxes.length) {
                        selectAll.checked = true;
                    }
                    updateBulkBar();
                });
            });

            window.clearSelection = function() {
                selectAll.checked = false;
                checkboxes.forEach(cb => cb.checked = false);
                updateBulkBar();
            };
        });
    </script>
@endsection