@extends('layouts.app')

@section('content')
<style>
    .log-section {
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

    .log-item {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: #f8f9fa;
        transition: all 0.2s ease;
    }

    .log-item:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-active { background: #d4edda; color: #155724; }
    .status-inactive { background: #f8d7da; color: #721c24; }
    .status-student { background: #cce5ff; color: #004085; }
    .status-counselor { background: #d1ecf1; color: #0c5460; }
    .status-admin { background: #fff3cd; color: #856404; }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-approved { background: #d4edda; color: #155724; }
    .status-rejected { background: #f8d7da; color: #721c24; }

    .search-filters {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

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
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="bi bi-people me-3"></i>
                    Student Registration Logs
                </h1>
                <p class="mb-0 opacity-75">Monitor and manage student registration approvals</p>
            </div>
            <div>
                <a href="{{ route('admin.registration-approvals.index') }}" class="btn btn-warning me-2">
                    <i class="bi bi-check-circle me-2"></i>
                    Manage Approvals
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
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\User::where('role', 'student')->count() ?? 0 }}</div>
                <div class="stats-label">Total Students</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\User::where('role', 'student')->where('registration_status', 'pending')->count() ?? 0 }}</div>
                <div class="stats-label">Pending Approval</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\User::where('role', 'student')->where('registration_status', 'approved')->count() ?? 0 }}</div>
                <div class="stats-label">Approved Students</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\User::where('role', 'student')->where('registration_status', 'rejected')->count() ?? 0 }}</div>
                <div class="stats-label">Rejected Registrations</div>
            </div>
        </div>
    </div>

    {{-- Export Buttons --}}
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('admin.logs.export', ['format' => 'pdf']) }}" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Export PDF</a>
        <a href="{{ route('admin.logs.export', ['format' => 'csv']) }}" class="btn btn-success"><i class="fa fa-file-csv"></i> Export CSV</a>
        <a href="{{ route('admin.logs.export', ['format' => 'excel']) }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Excel</a>
    </div>

    <!-- Search and Filters -->
    <div class="search-filters">
        <form method="GET" action="{{ route('admin.logs.users') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Search Students</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Search by name or email...">
            </div>
            <div class="col-md-3">
                <label for="registration_status" class="form-label">Filter by Registration Status</label>
                <select class="form-select" id="registration_status" name="registration_status">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('registration_status') == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                    <option value="approved" {{ request('registration_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('registration_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date" class="form-label">Filter by Registration Date</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ request('date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Student Registrations Log Section -->
    <div class="log-section">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-people me-2"></i>Student Registrations ({{ \App\Models\User::where('role', 'student')->count() ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @php
                $users = \App\Models\User::where('role', 'student')
                    ->with(['appointments.counselor', 'assessments', 'sessionNotes', 'activities', 'approvedBy'])
                    ->when(request('search'), function($query, $search) {
                        return $query->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->when(request('registration_status'), function($query, $status) {
                        return $query->where('registration_status', $status);
                    })
                    ->when(request('date'), function($query, $date) {
                        return $query->whereDate('created_at', $date);
                    })
                    ->latest()
                    ->paginate(15);
            @endphp
            
            @foreach($users as $user)
                <div class="log-item">
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
                                        <span class="status-badge status-{{ $user->registration_status }}">
                                            {{ ucfirst($user->registration_status) }}
                                        </span>
                                        <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <span class="text-muted">
                                            Registered: {{ $user->created_at->format('M d, Y') }}
                                        </span>
                                        @if($user->approved_at)
                                            <span class="text-muted">
                                                Approved: {{ $user->approved_at->format('M d, Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">Member since: {{ $user->created_at->format('M d, Y') }}</div>
                                <div class="col-md-3">Last login: {{ $user->updated_at->format('M d, Y') }}</div>
                                <div class="col-md-3">Activities: {{ $user->activities ? $user->activities->count() : 0 }}</div>
                                <div class="col-md-3">
                                    @if($user->role == 'student')
                                        <div class="d-flex align-items-center">
                                            <span>Appointments: {{ $user->appointments ? $user->appointments->count() : 0 }}</span>
                                            @if($user->appointments && $user->appointments->count() > 0)
                                                <button type="button" class="btn btn-sm btn-outline-info ms-2" data-bs-toggle="modal" data-bs-target="#appointmentsModal{{ $user->id }}">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </button>
                                            @endif
                                        </div>
                                    @elseif($user->role == 'counselor')
                                        Sessions: {{ $user->sessionNotes ? $user->sessionNotes->count() : 0 }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Appointment Details Modals -->
            @foreach($users as $user)
                @if($user->role == 'student' && $user->appointments && $user->appointments->count() > 0)
                    <div class="modal fade" id="appointmentsModal{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        Appointments for {{ $user->name }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Date & Time</th>
                                                    <th>Counselor</th>
                                                    <th>Status</th>
                                                    <th>Type</th>
                                                    <th>Notes</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($user->appointments as $appointment)
                                                    <tr>
                                                        <td>
                                                            <div class="fw-bold">{{ $appointment->scheduled_at ? $appointment->scheduled_at->format('M d, Y') : 'N/A' }}</div>
                                                            <small class="text-muted">{{ $appointment->scheduled_at ? $appointment->scheduled_at->format('g:i A') : 'N/A' }}</small>
                                                        </td>
                                                        <td>
                                                            @if($appointment->counselor)
                                                                <div class="d-flex align-items-center">
                                                                    @if($appointment->counselor->avatar)
                                                                        <img src="{{ $appointment->counselor->avatar_url }}" alt="{{ $appointment->counselor->name }}" 
                                                                             class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                                                    @else
                                                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2" 
                                                                             style="width: 30px; height: 30px;">
                                                                            <span class="text-white fw-bold" style="font-size: 0.8rem;">{{ strtoupper(substr($appointment->counselor->name ?? 'U', 0, 1)) }}</span>
                                                                        </div>
                                                                    @endif
                                                                    <span>{{ $appointment->counselor->name ?? 'N/A' }}</span>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">Not assigned</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                                $statusClass = '';
                                                                switch($appointment->status) {
                                                                    case 'pending': $statusClass = 'bg-warning'; break;
                                                                    case 'confirmed': $statusClass = 'bg-info'; break;
                                                                    case 'completed': $statusClass = 'bg-success'; break;
                                                                    case 'cancelled': $statusClass = 'bg-danger'; break;
                                                                    case 'rescheduled': $statusClass = 'bg-secondary'; break;
                                                                    default: $statusClass = 'bg-secondary';
                                                                }
                                                            @endphp
                                                            <span class="badge {{ $statusClass }}">{{ ucfirst($appointment->status ?? 'N/A') }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-primary">Regular</span>
                                                        </td>
                                                        <td>
                                                            @if($appointment->notes)
                                                                <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $appointment->notes }}">
                                                                    {{ Str::limit($appointment->notes, 50) }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">No notes</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye me-1"></i>View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="{{ route('appointments.index', ['student_id' => $user->id]) }}" class="btn btn-primary">
                                        <i class="bi bi-calendar-plus me-1"></i>View All Appointments
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection 