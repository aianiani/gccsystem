@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
        :root {
            --primary-green: #1f7a2d; /* Homepage forest green */
            --primary-green-2: #13601f; /* darker stop */
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0,0,0,0.08);

            /* Map dashboard-specific names to homepage palette for compatibility */
            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-600: var(--text-light);
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        /* Apply the same page zoom used on the homepage */
        .home-zoom {
            zoom: 0.85;
        }
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.85);
                transform-origin: top center;
            }
        }
        
        body, .profile-card, .stats-card, .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green) ;
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0,0,0,0.08);
            overflow-y: auto;
            padding-bottom: 1rem;
        }
        
        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
        }
        
        .welcome-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 1.5rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            min-height: 100px;
        }
        
        .welcome-card .welcome-text {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }
        
        .welcome-card .welcome-date {
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .welcome-card .welcome-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
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
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .main-content-card .card-body {
            padding: 1.25rem;
        }
        
        .btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.15s ease;
            padding: 0.6rem 1rem;
            border-width: 1px;
            box-shadow: 0 6px 18px rgba(17,94,37,0.06);
        }
        
        .btn-outline-primary {
            border-color: var(--forest-green);
            color: var(--forest-green);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--forest-green);
            border-color: var(--forest-green);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }
        
        .btn-outline-success:hover, .btn-outline-info:hover, .btn-outline-warning:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }
        
        @media (max-width: 991.98px) { 
            .main-dashboard-content { 
                margin-left: 200px; 
            } 
        }
        @media (max-width: 767.98px) { 
            .main-dashboard-content { 
                margin-left: 0; 
            } 
        }
    </style>
    
    <div class="home-zoom">
    <div class="d-flex">
        <!-- Mobile Sidebar Toggle -->
        <button id="counselorSidebarToggle" class="d-md-none">
            <i class="bi bi-list"></i>
        </button>
        <!-- Sidebar -->
        @include('counselor.sidebar')
        
        <!-- Main Content -->
        <div class="main-dashboard-content flex-grow-1">
            <div class="main-dashboard-inner">
            <div class="welcome-card">
                <div>
                    <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
                    <div class="welcome-text">Session Notes</div>
                    <div style="font-size: 0.9rem; margin-top: 0.5rem;">Manage and review all your session notes</div>
                </div>
                <div class="welcome-avatar">
                    <img src="{{ auth()->user()->avatar_url }}" 
                         alt="{{ auth()->user()->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <div class="main-content-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-journal-text me-2"></i>Session Notes</h5>
                    <a href="{{ route('counselor.appointments.index') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-calendar-event me-1"></i>Go to Appointments
                    </a>
                </div>
                <div class="card-body">
            <form method="GET" class="row g-2 align-items-center mb-3">
                <div class="col-auto">
                    <input type="text" name="student" class="form-control" placeholder="Filter by student name" value="{{ request('student') }}" style="max-width: 250px;">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i> Filter</button>
                </div>
                @if(request('student'))
                <div class="col-auto">
                    <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
                @endif
            </form>
            <div class="mb-3 d-flex flex-wrap gap-2">
                <a href="{{ route('counselor.session_notes.index', array_merge(request()->except('filter'), ['filter' => null])) }}" class="btn btn-sm {{ !request('filter') ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
                <a href="{{ route('counselor.session_notes.index', array_merge(request()->except('filter'), ['filter' => 'upcoming'])) }}" class="btn btn-sm {{ request('filter') === 'upcoming' ? 'btn-primary' : 'btn-outline-primary' }}">Upcoming</a>
                <a href="{{ route('counselor.session_notes.index', array_merge(request()->except('filter'), ['filter' => 'past'])) }}" class="btn btn-sm {{ request('filter') === 'past' ? 'btn-primary' : 'btn-outline-primary' }}">Past</a>
            </div>
            <div class="table-responsive">
                @php
                    $grouped = $sessionNotes->groupBy('appointment_id');
                @endphp
                @forelse($grouped as $appointmentId => $notes)
                    @php $appointment = $notes->first()->appointment; @endphp
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <img src="{{ $appointment->student->avatar_url }}" alt="Avatar" class="rounded-circle border border-2 flex-shrink-0" style="width: 40px; height: 40px; object-fit: cover; border-color: var(--forest-green);">
                            <div>
                                <span class="fw-semibold" style="color: var(--forest-green);">{{ $appointment->student->name }}</span>
                                <span class="text-muted ms-2">({{ $appointment->scheduled_at->format('F j, Y') }})</span>
                            </div>
                        </div>
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="align-middle text-center">
                                    <th>Session #</th>
                                    <th>Status</th>
                                    <th>Attendance</th>
                                    <th class="text-start">Note</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notes as $note)
                                    <tr class="align-middle text-center">
                                        <td><span class="badge bg-primary">{{ $note->session_number ?? '-' }}</span></td>
                                        <td>
                                            @php
                                                $status = $note->session_status;
                                                $statusMap = [
                                                    'scheduled' => ['label' => 'Scheduled', 'class' => 'bg-info text-dark', 'icon' => 'calendar-event'],
                                                    'completed' => ['label' => 'Completed', 'class' => 'bg-success', 'icon' => 'check-circle'],
                                                    'missed' => ['label' => 'Missed', 'class' => 'bg-warning text-dark', 'icon' => 'clock'],
                                                    'expired' => ['label' => 'Expired', 'class' => 'bg-danger', 'icon' => 'exclamation-triangle'],
                                                ];
                                            @endphp
                                            @if(isset($statusMap[$status]))
                                                <span class="badge {{ $statusMap[$status]['class'] }} d-inline-flex align-items-center gap-1 px-2 py-2">
                                                    <i class="bi bi-{{ $statusMap[$status]['icon'] }}"></i> {{ $statusMap[$status]['label'] }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('counselor.session_notes.update', $note->id) }}" method="POST" class="d-flex align-items-center gap-2 justify-content-center mb-0">
                                                @csrf
                                                @method('PATCH')
                                                <select name="attendance" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                                    <option value="unknown" {{ $note->attendance === 'unknown' ? 'selected' : '' }}>Unknown</option>
                                                    <option value="attended" {{ $note->attendance === 'attended' ? 'selected' : '' }}>Attended</option>
                                                    <option value="missed" {{ $note->attendance === 'missed' ? 'selected' : '' }}>Missed</option>
                                                </select>
                                                @if($note->attendance === 'missed')
                                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#absenceReasonModal{{ $note->id }}">
                                                        <i class="bi bi-exclamation-triangle"></i> Reason
                                                    </button>
                                                @endif
                                            </form>
                                            @if($note->attendance === 'missed')
                                                <!-- Absence Reason Modal -->
                                                <div class="modal fade" id="absenceReasonModal{{ $note->id }}" tabindex="-1" aria-labelledby="absenceReasonModalLabel{{ $note->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('counselor.session_notes.update', $note->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="absenceReasonModalLabel{{ $note->id }}">Absence Reason</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <textarea name="absence_reason" class="form-control" rows="3" placeholder="Enter reason for absence...">{{ $note->absence_reason }}</textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger">Save Reason</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-start">
                                            @if(trim($note->note) === '')
                                                <span class="badge bg-warning text-dark">Empty – needs completion</span>
                                            @else
                                                <span class="text-muted">{{ Str::limit($note->note, 60) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">{{ $note->appointment->scheduled_at->format('F j, Y') }}</td>
                                        <td class="text-nowrap">{{ $note->appointment->scheduled_at->format('g:i A') }} &ndash; {{ $note->appointment->scheduled_at->copy()->addMinutes(30)->format('g:i A') }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                                <a href="{{ route('counselor.session_notes.show', $note->id) }}" class="btn btn-outline-primary btn-sm" title="View"><i class="bi bi-eye"></i></a>
                                                <a href="{{ route('counselor.session_notes.timeline', $note->appointment->student->id) }}" class="btn btn-outline-secondary btn-sm" title="Timeline"><i class="bi bi-clock-history"></i></a>
                                                @if($note->session_status !== 'completed')
                                                    <a href="{{ route('counselor.session_notes.edit', $note->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                                    <form action="{{ route('counselor.session_notes.complete', $note->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm" title="Mark Completed"><i class="bi bi-check-circle"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                            <i class="bi bi-journal-x" style="font-size: 2.5rem; color: var(--forest-green);"></i>
                            <div class="mt-2">No session notes found.</div>
                        </div>
                    </div>
                @endforelse
                </div>
            </div>
            </div>
        </div>
    </div>
    
    </div>
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
@endsection 