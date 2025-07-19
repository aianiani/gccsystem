@extends('layouts.app')

@section('content')
<style>
    .log-section { background: white; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 2rem; overflow: hidden; }
    .card-header { background: linear-gradient(135deg, #2d5016 0%, #4a7c59 100%); color: white; padding: 1.5rem 2rem; border-bottom: none; }
    .card-body { padding: 2rem; }
    .log-item { border: 1px solid #e9ecef; border-radius: 8px; padding: 1.5rem; margin-bottom: 1rem; background: #f8f9fa; transition: all 0.2s ease; }
    .log-item:hover { box-shadow: 0 4px 8px rgba(0,0,0,0.1); transform: translateY(-2px); }
    .rating-badge { padding: 0.5rem 1rem; border-radius: 12px; font-size: 0.9rem; font-weight: 500; }
    .rating-5 { background: #d4edda; color: #155724; }
    .rating-4 { background: #cce5ff; color: #004085; }
    .rating-3 { background: #fff3cd; color: #856404; }
    .rating-2 { background: #f8d7da; color: #721c24; }
    .rating-1 { background: #721c24; color: #f8d7da; }
    .search-filters { background: white; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 1.5rem; margin-bottom: 2rem; }
    .page-header { background: linear-gradient(135deg, #2d5016 0%, #4a7c59 100%); color: white; border-radius: 16px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .stats-card { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; margin-bottom: 1rem; }
    .stats-number { font-size: 2rem; font-weight: bold; color: #2d5016; }
    .stats-label { color: #6c757d; font-size: 0.9rem; margin-top: 0.5rem; }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2"><i class="bi bi-star me-3"></i>Session Feedbacks Logs</h1>
                <p class="mb-0 opacity-75">Student feedback tracking and analysis</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\SessionFeedback::count() ?? 0 }}</div>
                <div class="stats-label">Total Feedbacks</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\SessionFeedback::where('rating', '>=', 4)->count() ?? 0 }}</div>
                <div class="stats-label">High Ratings (4-5)</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ \App\Models\SessionFeedback::where('rating', '<=', 2)->count() ?? 0 }}</div>
                <div class="stats-label">Low Ratings (1-2)</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ round(\App\Models\SessionFeedback::avg('rating'), 1) ?? 0 }}</div>
                <div class="stats-label">Average Rating</div>
            </div>
        </div>
    </div>

    {{-- Export Buttons --}}
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('admin.logs.export', ['format' => 'pdf']) }}" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Export PDF</a>
        <a href="{{ route('admin.logs.export', ['format' => 'csv']) }}" class="btn btn-success"><i class="fa fa-file-csv"></i> Export CSV</a>
        <a href="{{ route('admin.logs.export', ['format' => 'excel']) }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Excel</a>
    </div>

    <div class="search-filters">
        <form method="GET" action="{{ route('admin.logs.session-feedbacks') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Search Feedbacks</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Search by student name...">
            </div>
            <div class="col-md-3">
                <label for="rating" class="form-label">Rating Filter</label>
                <select class="form-select" id="rating" name="rating">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
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

    <div class="log-section">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-star me-2"></i>All Session Feedbacks ({{ \App\Models\SessionFeedback::count() ?? 0 }})</h5>
        </div>
        <div class="card-body">
            @php
                $feedbacks = \App\Models\SessionFeedback::with(['appointment.student', 'appointment.counselor'])
                    ->when(request('search'), function($query, $search) {
                        return $query->whereHas('appointment.student', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->when(request('rating'), function($query, $rating) {
                        return $query->where('rating', $rating);
                    })
                    ->when(request('date'), function($query, $date) {
                        return $query->whereDate('created_at', $date);
                    })
                    ->latest()
                    ->paginate(15);
            @endphp
            
            @foreach($feedbacks as $feedback)
                <div class="log-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    @if($feedback->appointment && $feedback->appointment->student && $feedback->appointment->student->avatar)
                                        <img src="{{ $feedback->appointment->student->avatar_url }}" alt="{{ $feedback->appointment->student->name }}" 
                                             class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <span class="text-white fw-bold">{{ strtoupper(substr($feedback->appointment->student->name ?? 'U', 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ $feedback->appointment->student->name ?? 'Unknown Student' }}</h6>
                                    <p class="text-muted mb-1">Counselor: {{ $feedback->appointment->counselor->name ?? 'Unknown' }}</p>
                                    <div class="d-flex gap-2">
                                        <span class="rating-badge rating-{{ $feedback->rating }}">
                                            {{ $feedback->rating }} Star{{ $feedback->rating > 1 ? 's' : '' }}
                                        </span>
                                        <span class="text-muted">
                                            Submitted: {{ $feedback->created_at->format('M d, Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Student:</strong><br>
                                    <span>{{ $feedback->appointment->student->name ?? 'Unknown' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Counselor:</strong><br>
                                    <span>{{ $feedback->appointment->counselor->name ?? 'Unknown' }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Rating:</strong><br>
                                    <span class="rating-badge rating-{{ $feedback->rating }}">
                                        {{ $feedback->rating }}/5 Stars
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Reviewed:</strong><br>
                                    <span class="badge {{ $feedback->reviewed_by_counselor ? 'bg-success' : 'bg-warning' }}">
                                        {{ $feedback->reviewed_by_counselor ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                            </div>

                            @if($feedback->comments)
                                <div class="mt-3">
                                    <strong>Comments:</strong>
                                    <p class="text-muted mb-0">{{ Str::limit($feedback->comments, 300) }}</p>
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
                {{ $feedbacks->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection 