@extends('layouts.app')

@section('content')
<style>
    :root {
        --forest-green: #2d5016;
        --forest-green-light: #4a7c59;
        --forest-green-lighter: #e8f5e8;
        --yellow-maize: #f4d03f;
        --yellow-maize-light: #fef9e7;
        --white: #ffffff;
        --gray-50: #f8f9fa;
        --gray-100: #f1f3f4;
        --gray-600: #6c757d;
        --danger: #dc3545;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .admin-header {
        background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
        color: white;
        border-radius: 16px;
        padding: 2rem 2rem 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
    }
    .log-section {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .log-section .card-header {
        background: var(--forest-green-lighter) !important;
        color: var(--forest-green) !important;
        border-radius: 16px 16px 0 0 !important;
        font-weight: 600;
        font-size: 1.1rem;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--gray-100);
    }
    .log-section .card-body {
        padding: 2rem;
    }
    .log-item {
        border: 1px solid var(--gray-100);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    .log-item:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }
    .log-item:last-child {
        margin-bottom: 0;
    }
    .status-badge {
        border-radius: 12px;
        padding: 0.25rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
        display: inline-block;
    }
    .status-pending { background: #ffc107; color: #2d5016; }
    .status-completed { background: #28a745; }
    .status-cancelled { background: #dc3545; }
    .status-active { background: #28a745; }
    .status-inactive { background: #6c757d; }
    .role-badge {
        border-radius: 12px;
        padding: 0.25rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
        display: inline-block;
    }
    .role-admin { background: #dc3545; }
    .role-counselor { background: #17a2b8; }
    .role-student { background: #28a745; }
    .filter-section {
        background: var(--gray-50);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
    }
    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--forest-green);
        margin-bottom: 0.5rem;
    }
    .stat-card .stat-label {
        color: var(--gray-600);
        font-weight: 500;
    }
</style>

<div class="container py-4">
    <div class="admin-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2 fw-bold">
                    <i class="bi bi-journal-text me-2"></i>System Logs & Data
                </h1>
                <p class="mb-0">Comprehensive view of all system data and activities</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-3 gap-2">
        <a href="{{ route('admin.logs.export', ['format' => 'pdf']) }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
        </a>
        <a href="{{ route('admin.logs.export', ['format' => 'excel']) }}" class="btn btn-outline-success">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
        </a>
        <a href="{{ route('admin.logs.export', ['format' => 'csv']) }}" class="btn btn-outline-primary">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV
        </a>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#resetLogsModal">
            <i class="bi bi-trash me-1"></i> Reset All Logs
        </button>
    </div>

    <!-- Reset Confirmation Modal -->
    <div class="modal fade" id="resetLogsModal" tabindex="-1" aria-labelledby="resetLogsModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="resetLogsModalLabel">Confirm Reset</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="text-danger fw-bold">Are you sure you want to reset <u>all logs and data</u>? This action cannot be undone and will delete all users, appointments, assessments, session notes, feedback, messages, and activities from the system.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <form method="POST" action="{{ route('admin.logs.reset') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Yes, Reset Everything</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Stats Summary -->
    <div class="stats-summary">
        <div class="stat-card">
            <div class="stat-value">{{ \App\Models\User::count() }}</div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ \App\Models\Appointment::count() }}</div>
            <div class="stat-label">Total Appointments</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ \App\Models\Assessment::count() }}</div>
            <div class="stat-label">Total Assessments</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ \App\Models\SessionFeedback::count() }}</div>
            <div class="stat-label">Session Feedbacks Logs</div>
        </div>
    </div>

    <!-- Navigation Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">Users Logs</h5>
                    <p class="card-text">View all users and their activities</p>
                    <a href="{{ route('admin.logs.users') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-right me-1"></i>View Users
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-check fs-1 text-success mb-3"></i>
                    <h5 class="card-title">Appointments Logs</h5>
                    <p class="card-text">Track all counseling appointments</p>
                    <a href="{{ route('admin.logs.appointments') }}" class="btn btn-success">
                        <i class="bi bi-arrow-right me-1"></i>View Appointments
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-journal-text fs-1 text-info mb-3"></i>
                    <h5 class="card-title">Session Notes</h5>
                    <p class="card-text">Review all session documentation</p>
                    <a href="{{ route('admin.logs.session-notes') }}" class="btn btn-info">
                        <i class="bi bi-arrow-right me-1"></i>View Notes
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-star fs-1 text-warning mb-3"></i>
                    <h5 class="card-title">Session Feedbacks</h5>
                    <p class="card-text">Monitor student feedback</p>
                    <a href="{{ route('admin.logs.session-feedbacks') }}" class="btn btn-warning">
                        <i class="bi bi-arrow-right me-1"></i>View Feedbacks
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard-data fs-1 text-danger mb-3"></i>
                    <h5 class="card-title">Assessments</h5>
                    <p class="card-text">Review all assessment results</p>
                    <a href="{{ route('admin.logs.assessments') }}" class="btn btn-danger">
                        <i class="bi bi-arrow-right me-1"></i>View Assessments
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-chat-dots fs-1 text-secondary mb-3"></i>
                    <h5 class="card-title">Messages</h5>
                    <p class="card-text">Monitor all communications</p>
                    <a href="{{ route('admin.logs.messages') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right me-1"></i>View Messages
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-activity fs-1 text-dark mb-3"></i>
                    <h5 class="card-title">System Activities</h5>
                    <p class="card-text">Track all system activities</p>
                    <a href="{{ route('admin.logs.activities') }}" class="btn btn-dark">
                        <i class="bi bi-arrow-right me-1"></i>View Activities
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-grid-3x3-gap fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">All Logs</h5>
                    <p class="card-text">View everything in one place</p>
                    <a href="{{ route('admin.logs') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-right me-1"></i>View All
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Date From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Date To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-funnel me-2"></i>Filter
                </button>
                <a href="{{ route('admin.logs') }}" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-arrow-clockwise me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Users Section -->
    <div class="log-section">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-people me-2"></i>All Users ({{ \App\Models\User::count() ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @php
                $users = \App\Models\User::with('activities')
                    ->when(request('search'), function($query, $search) {
                        return $query->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->when(request('status'), function($query, $status) {
                        if($status == 'active') return $query->where('is_active', true);
                        if($status == 'inactive') return $query->where('is_active', false);
                        return $query;
                    })
                    ->latest()
                    ->paginate(10);
            @endphp
            
            @foreach($users as $user)
                <div class="log-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                     class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ $user->name }}</h6>
                                    <p class="text-muted mb-1">{{ $user->email }}</p>
                                    <div class="d-flex gap-2">
                                        <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                                        <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-muted small">
                                <div class="col-md-3">Member since: {{ $user->created_at->format('M d, Y') }}</div>
                                <div class="col-md-3">Last login: {{ $user->updated_at->format('M d, Y') }}</div>
                                                                    <div class="col-md-3">Activities: {{ $user->activities ? $user->activities->count() : 0 }}</div>
                                <div class="col-md-3">
                                    @if($user->role == 'student')
                                        Appointments: {{ $user->appointments ? $user->appointments->count() : 0 }}
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
            
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Appointments Section -->
    <div class="log-section">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>All Appointments ({{ \App\Models\Appointment::count() ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @php
                $appointments = \App\Models\Appointment::with(['student', 'counselor'])
                    ->when(request('search'), function($query, $search) {
                        return $query->whereHas('student', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })->orWhereHas('counselor', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->when(request('status'), function($query, $status) {
                        return $query->where('status', $status);
                    })
                    ->latest('scheduled_at')
                    ->paginate(10);
            @endphp
            
            @foreach($appointments as $appointment)
                <div class="log-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <i class="bi bi-calendar-event fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Counseling Session</h6>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-person me-1"></i>{{ $appointment->student->name ?? 'N/A' }} 
                                        <i class="bi bi-arrow-right mx-2"></i>
                                        <i class="bi bi-person-badge me-1"></i>{{ $appointment->counselor->name ?? 'N/A' }}
                                    </p>
                                    <div class="d-flex gap-2">
                                        <span class="status-badge status-{{ $appointment->status }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                        <span class="text-muted">
                                            {{ $appointment->scheduled_at->format('M d, Y - g:i A') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if($appointment->notes)
                                <div class="text-muted small">
                                    <i class="bi bi-journal-text me-1"></i>{{ Str::limit($appointment->notes, 100) }}
                                </div>
                            @endif
                        </div>
                        <div class="text-end">
                            <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="d-flex justify-content-center mt-4">
                {{ $appointments->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Session Notes Section -->
    <div class="log-section">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-journal-text me-2"></i>Session Notes ({{ \App\Models\SessionNote::count() ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @php
                $sessionNotes = \App\Models\SessionNote::with(['appointment.student', 'appointment.counselor'])
                    ->when(request('search'), function($query, $search) {
                        return $query->whereHas('appointment.student', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })->orWhereHas('appointment.counselor', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })->orWhere('note', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(10);
            @endphp
            
            @foreach($sessionNotes as $note)
                <div class="log-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <i class="bi bi-journal-text fs-4 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Session Note #{{ $note->session_number }}</h6>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-person me-1"></i>{{ $note->appointment->student->name ?? 'N/A' }} 
                                        <i class="bi bi-arrow-right mx-2"></i>
                                        <i class="bi bi-person-badge me-1"></i>{{ $note->appointment->counselor->name ?? 'N/A' }}
                                    </p>
                                    <div class="d-flex gap-2">
                                        <span class="status-badge {{ $note->session_status == 'completed' ? 'status-completed' : 'status-pending' }}">
                                            {{ ucfirst($note->session_status) }}
                                        </span>
                                        <span class="text-muted">
                                            {{ $note->created_at->format('M d, Y - g:i A') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if($note->note)
                                <div class="text-muted small">
                                    <i class="bi bi-quote me-1"></i>{{ Str::limit($note->note, 150) }}
                                </div>
                            @endif
                        </div>
                        <div class="text-end">
                            <a href="{{ route('counselor.session_notes.show', $note->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="d-flex justify-content-center mt-4">
                {{ $sessionNotes->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Session Feedbacks Section -->
    <div class="log-section">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-star me-2"></i>Session Feedbacks ({{ \App\Models\SessionFeedback::count() ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @php
                $sessionFeedbacks = \App\Models\SessionFeedback::with(['appointment.student', 'appointment.counselor'])
                    ->when(request('search'), function($query, $search) {
                        return $query->whereHas('appointment.student', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })->orWhereHas('appointment.counselor', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })->orWhere('comments', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(10);
            @endphp
            
            @foreach($sessionFeedbacks as $feedback)
                <div class="log-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <i class="bi bi-star-fill fs-4 text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Session Feedback</h6>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-person me-1"></i>{{ $feedback->appointment->student->name ?? 'N/A' }} 
                                        <i class="bi bi-arrow-right mx-2"></i>
                                        <i class="bi bi-person-badge me-1"></i>{{ $feedback->appointment->counselor->name ?? 'N/A' }}
                                    </p>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-{{ $feedback->rating >= 4 ? 'success' : ($feedback->rating >= 3 ? 'warning' : 'danger') }}">
                                            {{ $feedback->rating }}/5 Stars
                                        </span>
                                        <span class="text-muted">
                                            {{ $feedback->created_at->format('M d, Y - g:i A') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if($feedback->comments)
                                <div class="text-muted small">
                                    <i class="bi bi-quote me-1"></i>{{ Str::limit($feedback->comments, 150) }}
                                </div>
                            @endif
                        </div>
                        <div class="text-end">
                            <a href="{{ route('counselor.feedback.show', $feedback->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="d-flex justify-content-center mt-4">
                {{ $sessionFeedbacks->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Assessments Section -->
    <div class="log-section">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>All Assessments ({{ \App\Models\Assessment::count() ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @php
                $assessments = \App\Models\Assessment::with('user')
                    ->when(request('search'), function($query, $search) {
                        return $query->whereHas('user', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->when(request('status'), function($query, $status) {
                        return $query->where('status', $status);
                    })
                    ->latest()
                    ->paginate(10);
            @endphp
            
            @foreach($assessments as $assessment)
                <div class="log-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <i class="bi bi-clipboard-check fs-4 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ $assessment->type ?? 'Assessment' }}</h6>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-person me-1"></i>{{ $assessment->user->name ?? 'N/A' }}
                                    </p>
                                    <div class="d-flex gap-2">
                                        <span class="status-badge status-{{ $assessment->status }}">
                                            {{ ucfirst($assessment->status) }}
                                        </span>
                                        @if($assessment->risk_level)
                                            <span class="badge bg-{{ $assessment->risk_level == 'high' ? 'danger' : ($assessment->risk_level == 'moderate' ? 'warning' : 'success') }}">
                                                {{ ucfirst($assessment->risk_level) }} Risk
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row text-muted small">
                                <div class="col-md-4">Created: {{ $assessment->created_at->format('M d, Y') }}</div>
                                <div class="col-md-4">Updated: {{ $assessment->updated_at->format('M d, Y') }}</div>
                                <div class="col-md-4">Score: {{ $assessment->total_score ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('counselor.assessments.show', $assessment->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="d-flex justify-content-center mt-4">
                {{ $assessments->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Messages Section -->
    <div class="log-section">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-chat-dots me-2"></i>All Messages ({{ \App\Models\Message::count() ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @php
                $messages = \App\Models\Message::with(['sender', 'recipient'])
                    ->when(request('search'), function($query, $search) {
                        return $query->where('content', 'like', "%{$search}%")
                                   ->orWhereHas('sender', function($q) use ($search) {
                                       $q->where('name', 'like', "%{$search}%");
                                   })
                                   ->orWhereHas('recipient', function($q) use ($search) {
                                       $q->where('name', 'like', "%{$search}%");
                                   });
                    })
                    ->latest()
                    ->paginate(10);
            @endphp
            
            @foreach($messages as $message)
                <div class="log-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <i class="bi bi-chat fs-4 text-info"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Message</h6>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-person me-1"></i>{{ $message->sender->name ?? 'N/A' }} 
                                        <i class="bi bi-arrow-right mx-2"></i>
                                        <i class="bi bi-person me-1"></i>{{ $message->recipient->name ?? 'N/A' }}
                                    </p>
                                    <div class="text-muted">
                                        {{ $message->created_at->format('M d, Y - g:i A') }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-muted">
                                <i class="bi bi-quote me-1"></i>{{ Str::limit($message->content, 150) }}
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="text-muted small">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="d-flex justify-content-center mt-4">
                {{ $messages->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- System Activities Section -->
    <div class="log-section">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-activity me-2"></i>System Activities ({{ \App\Models\UserActivity::count() ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @php
                $activities = \App\Models\UserActivity::with('user')
                    ->when(request('search'), function($query, $search) {
                        return $query->where('action', 'like', "%{$search}%")
                                   ->orWhere('description', 'like', "%{$search}%")
                                   ->orWhereHas('user', function($q) use ($search) {
                                       $q->where('name', 'like', "%{$search}%");
                                   });
                    })
                    ->latest()
                    ->paginate(15);
            @endphp
            
            @foreach($activities as $activity)
                <div class="log-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <i class="bi bi-activity fs-4 text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ ucfirst($activity->action) }}</h6>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-person me-1"></i>{{ $activity->user->name ?? 'System' }}
                                    </p>
                                    <div class="text-muted">
                                        {{ $activity->created_at->format('M d, Y - g:i A') }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>{{ $activity->description }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div class="d-flex justify-content-center mt-4">
                {{ $activities->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection 