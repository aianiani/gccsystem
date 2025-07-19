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

    .status-scheduled { background: #cce5ff; color: #004085; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-missed { background: #f8d7da; color: #721c24; }
    .status-expired { background: #6c757d; color: #ffffff; }

    .attendance-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .attendance-attended { background: #d4edda; color: #155724; }
    .attendance-missed { background: #f8d7da; color: #721c24; }
    .attendance-unknown { background: #e2e3e5; color: #383d41; }

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

    .session-number {
        font-size: 1.1rem;
        font-weight: bold;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        display: inline-block;
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="bi bi-journal-text me-3"></i>
                    Session Notes Logs
                </h1>
                <p class="mb-0 opacity-75">Complete session notes tracking and management</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Dashboard
            </a>
        </div>
    </div>

    {{-- Export Buttons --}}
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('admin.logs.export', ['format' => 'pdf']) }}" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Export PDF</a>
        <a href="{{ route('admin.logs.export', ['format' => 'csv']) }}" class="btn btn-success"><i class="fa fa-file-csv"></i> Export CSV</a>
        <a href="{{ route('admin.logs.export', ['format' => 'excel']) }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Excel</a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\SessionNote::count() ?? 0 }}</div>
                <div class="stats-label">Total Session Notes</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\SessionNote::where('session_status', 'completed')->count() ?? 0 }}</div>
                <div class="stats-label">Completed Sessions</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\SessionNote::where('attendance', 'attended')->count() ?? 0 }}</div>
                <div class="stats-label">Attended Sessions</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\SessionNote::where('attendance', 'missed')->count() ?? 0 }}</div>
                <div class="stats-label">Missed Sessions</div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-filters">
        <form method="GET" action="{{ route('admin.logs.session-notes') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search Session Notes</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Search by student or counselor name...">
            </div>
            <div class="col-md-2">
                <label for="session_status" class="form-label">Session Status</label>
                <select class="form-select" id="session_status" name="session_status">
                    <option value="">All Status</option>
                    <option value="scheduled" {{ request('session_status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ request('session_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="missed" {{ request('session_status') == 'missed' ? 'selected' : '' }}>Missed</option>
                    <option value="expired" {{ request('session_status') == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="attendance" class="form-label">Attendance</label>
                <select class="form-select" id="attendance" name="attendance">
                    <option value="">All Attendance</option>
                    <option value="attended" {{ request('attendance') == 'attended' ? 'selected' : '' }}>Attended</option>
                    <option value="missed" {{ request('attendance') == 'missed' ? 'selected' : '' }}>Missed</option>
                    <option value="unknown" {{ request('attendance') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date" class="form-label">Filter by Date</label>
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

    <!-- Session Notes Log Section -->
    <div class="log-section">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-journal-text me-2"></i>All Session Notes ({{ \App\Models\SessionNote::count() ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @php
                $sessionNotes = \App\Models\SessionNote::with(['counselor', 'appointment.student'])
                    ->when(request('search'), function($query, $search) {
                        return $query->whereHas('counselor', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })->orWhereHas('appointment.student', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->when(request('session_status'), function($query, $status) {
                        return $query->where('session_status', $status);
                    })
                    ->when(request('attendance'), function($query, $attendance) {
                        return $query->where('attendance', $attendance);
                    })
                    ->when(request('date'), function($query, $date) {
                        return $query->whereDate('created_at', $date);
                    })
                    ->latest()
                    ->paginate(15);
            @endphp
            
            @foreach($sessionNotes as $sessionNote)
                <div class="log-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    @if($sessionNote->counselor && $sessionNote->counselor->avatar)
                                        <img src="{{ $sessionNote->counselor->avatar_url }}" alt="{{ $sessionNote->counselor->name }}" 
                                             class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <span class="text-white fw-bold">{{ strtoupper(substr($sessionNote->counselor->name ?? 'U', 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">
                                        Session #{{ $sessionNote->session_number ?? 'N/A' }} - 
                                        {{ $sessionNote->counselor->name ?? 'Unknown Counselor' }}
                                    </h6>
                                    <p class="text-muted mb-1">
                                        Student: {{ $sessionNote->appointment->student->name ?? 'Unknown Student' }}
                                    </p>
                                    <div class="d-flex gap-2">
                                        <span class="status-badge status-{{ $sessionNote->session_status }}">
                                            {{ ucfirst($sessionNote->session_status) }}
                                        </span>
                                        <span class="attendance-badge attendance-{{ $sessionNote->attendance }}">
                                            {{ ucfirst($sessionNote->attendance) }}
                                        </span>
                                        <span class="text-muted">
                                            Created: {{ $sessionNote->created_at->format('M d, Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-2">
                                    <strong>Session #:</strong><br>
                                    <span class="session-number">{{ $sessionNote->session_number ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Counselor:</strong><br>
                                    <span>{{ $sessionNote->counselor->name ?? 'Unknown' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Student:</strong><br>
                                    <span>{{ $sessionNote->appointment->student->name ?? 'Unknown' }}</span>
                                </div>
                                <div class="col-md-2">
                                    <strong>Status:</strong><br>
                                    <span class="status-badge status-{{ $sessionNote->session_status }}">
                                        {{ ucfirst($sessionNote->session_status) }}
                                    </span>
                                </div>
                                <div class="col-md-2">
                                    <strong>Attendance:</strong><br>
                                    <span class="attendance-badge attendance-{{ $sessionNote->attendance }}">
                                        {{ ucfirst($sessionNote->attendance) }}
                                    </span>
                                </div>
                            </div>

                            @if($sessionNote->next_session)
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <strong>Next Session:</strong><br>
                                        <span class="text-info">{{ $sessionNote->next_session->format('M d, Y g:i A') }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Appointment Date:</strong><br>
                                        <span class="text-muted">{{ $sessionNote->appointment->scheduled_at ? $sessionNote->appointment->scheduled_at->format('M d, Y g:i A') : 'N/A' }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($sessionNote->absence_reason)
                                <div class="mt-2">
                                    <strong>Absence Reason:</strong>
                                    <p class="text-muted mb-0">{{ $sessionNote->absence_reason }}</p>
                                </div>
                            @endif

                            @if($sessionNote->note)
                                <div class="mt-3">
                                    <strong>Session Notes:</strong>
                                    <p class="text-muted mb-0">{{ Str::limit($sessionNote->note, 300) }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="text-end">
                            <a href="{{ route('counselor.session_notes.show', $sessionNote->id) }}" class="btn btn-sm btn-outline-primary">
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
</div>
@endsection 