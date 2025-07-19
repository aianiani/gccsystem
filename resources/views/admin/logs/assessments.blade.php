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

    .risk-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .risk-low { background: #d4edda; color: #155724; }
    .risk-moderate { background: #fff3cd; color: #856404; }
    .risk-high { background: #f8d7da; color: #721c24; }
    .risk-critical { background: #721c24; color: #f8d7da; }

    .type-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .type-dass21 { background: #cce5ff; color: #004085; }
    .type-academic { background: #d1ecf1; color: #0c5460; }
    .type-wellness { background: #e2e3e5; color: #383d41; }

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

    .score-display {
        font-size: 1.2rem;
        font-weight: bold;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
    }
</style>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2">
                    <i class="bi bi-clipboard-data me-3"></i>
                    Assessments Logs
                </h1>
                <p class="mb-0 opacity-75">Complete student assessment tracking and analysis</p>
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
                <div class="stats-number">{{ \App\Models\Assessment::count() ?? 0 }}</div>
                <div class="stats-label">Total Assessments</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\Assessment::where('risk_level', 'high')->orWhere('risk_level', 'critical')->count() ?? 0 }}</div>
                <div class="stats-label">High/Critical Risk</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\Assessment::where('type', 'dass21')->count() ?? 0 }}</div>
                <div class="stats-label">DASS-21 Assessments</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\Assessment::where('type', 'academic')->count() ?? 0 }}</div>
                <div class="stats-label">Academic Surveys</div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-filters">
        <form method="GET" action="{{ route('admin.logs.assessments') }}" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Search Assessments</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Search by student name...">
            </div>
            <div class="col-md-2">
                <label for="risk_level" class="form-label">Risk Level</label>
                <select class="form-select" id="risk_level" name="risk_level">
                    <option value="">All Levels</option>
                    <option value="low" {{ request('risk_level') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="moderate" {{ request('risk_level') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                    <option value="high" {{ request('risk_level') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="critical" {{ request('risk_level') == 'critical' ? 'selected' : '' }}>Critical</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="type" class="form-label">Assessment Type</label>
                <select class="form-select" id="type" name="type">
                    <option value="">All Types</option>
                    <option value="dass21" {{ request('type') == 'dass21' ? 'selected' : '' }}>DASS-21</option>
                    <option value="academic" {{ request('type') == 'academic' ? 'selected' : '' }}>Academic</option>
                    <option value="wellness" {{ request('type') == 'wellness' ? 'selected' : '' }}>Wellness</option>
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

    <!-- Assessments Log Section -->
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
                    ->when(request('risk_level'), function($query, $risk_level) {
                        return $query->where('risk_level', $risk_level);
                    })
                    ->when(request('type'), function($query, $type) {
                        return $query->where('type', $type);
                    })
                    ->when(request('date'), function($query, $date) {
                        return $query->whereDate('created_at', $date);
                    })
                    ->latest()
                    ->paginate(15);
            @endphp
            
            @foreach($assessments as $assessment)
                <div class="log-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    @if($assessment->user && $assessment->user->avatar)
                                        <img src="{{ $assessment->user->avatar_url }}" alt="{{ $assessment->user->name }}" 
                                             class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <span class="text-white fw-bold">{{ strtoupper(substr($assessment->user->name ?? 'U', 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ $assessment->user->name ?? 'Unknown Student' }}</h6>
                                    <p class="text-muted mb-1">{{ $assessment->user->email ?? 'N/A' }}</p>
                                    <div class="d-flex gap-2">
                                        <span class="risk-badge risk-{{ strtolower($assessment->risk_level) }}">
                                            {{ ucfirst($assessment->risk_level) }} Risk
                                        </span>
                                        <span class="type-badge type-{{ $assessment->type ?? 'unknown' }}">
                                            {{ ucfirst($assessment->type ?? 'Unknown') }}
                                        </span>
                                        <span class="text-muted">
                                            Taken: {{ $assessment->created_at->format('M d, Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Assessment Type:</strong><br>
                                    <span class="type-badge type-{{ $assessment->type ?? 'unknown' }}">
                                        {{ ucfirst($assessment->type ?? 'Unknown') }}
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Risk Level:</strong><br>
                                    <span class="risk-badge risk-{{ strtolower($assessment->risk_level) }}">
                                        {{ ucfirst($assessment->risk_level) }}
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Score:</strong><br>
                                    <span class="score-display">{{ $assessment->score ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Student Status:</strong><br>
                                    <span class="badge {{ $assessment->user && $assessment->user->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $assessment->user && $assessment->user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>

                            @if($assessment->notes)
                                <div class="mt-3">
                                    <strong>Notes:</strong>
                                    <p class="text-muted mb-0">{{ Str::limit($assessment->notes, 200) }}</p>
                                </div>
                            @endif
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
</div>
@endsection 