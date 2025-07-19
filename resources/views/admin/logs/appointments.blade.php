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
    .status-confirmed { background: #d4edda; color: #155724; }
    .status-completed { background: #d1ecf1; color: #0c5460; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
    .status-pending { background: #fff3cd; color: #856404; }

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
                    <i class="bi bi-calendar-check me-3"></i>
                    Appointments Logs
                </h1>
                <p class="mb-0 opacity-75">Complete appointment tracking and management</p>
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
                <div class="stats-number">{{ \App\Models\Appointment::count() ?? 0 }}</div>
                <div class="stats-label">Total Appointments</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\Appointment::where('status', 'scheduled')->count() ?? 0 }}</div>
                <div class="stats-label">Scheduled</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\Appointment::where('status', 'completed')->count() ?? 0 }}</div>
                <div class="stats-label">Completed</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\Appointment::where('status', 'cancelled')->count() ?? 0 }}</div>
                <div class="stats-label">Cancelled</div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-filters">
        <form method="GET" action="{{ route('admin.logs.appointments') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Search Appointments</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Search by student or counselor name...">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Filter by Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
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

    <!-- Appointments Log Section -->
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
                    ->when(request('date'), function($query, $date) {
                        return $query->whereDate('scheduled_at', $date);
                    })
                    ->latest('scheduled_at')
                    ->paginate(15);
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
</div>
@endsection 