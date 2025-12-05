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
        
        .main-content-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        
            /* Filter button sizing */
            .filter-btn, .reset-btn { padding: 0.38rem 0.45rem; min-width: 40px; display:inline-flex; align-items:center; justify-content:center; }
            .filter-btn i, .reset-btn i { font-size: 1rem; }
        .main-content-card .card-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
                                        @php
                                            $studentMeta = [];
                                            if(!empty($appointment->student->college)) $studentMeta[] = $appointment->student->college;
                                            if(!empty($appointment->student->course)) $studentMeta[] = $appointment->student->course;
                                        @endphp
                                        @if(!empty($studentMeta))
                                                <div class="small text-muted">{{ implode(' • ', $studentMeta) }}</div>
                                        @endif
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .main-content-card .card-body {
            padding: 1.25rem;
        }
        
        .appointment-item {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            border: 1px solid var(--gray-100);
            transition: all 0.2s ease;
        }
        
        .appointment-item:hover {
            background: var(--forest-green-lighter);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }
        
        .appointment-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .appointment-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        .appointment-avatar { width:40px; height:40px; object-fit:cover; border:2px solid var(--forest-green); }
        /* Welcome header avatar */
        .welcome-avatar { width:72px; height:72px; border-radius:50%; overflow:hidden; flex:0 0 auto; border:4px solid rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; }
        .welcome-avatar-img { width:100%; height:100%; object-fit:cover; display:block; }
        .appointment-main .name { font-size:1rem; margin:0; }
        .appointment-right { min-width:110px; }
        .appointment-card .time { color: #6c757d; }
        .appointment-card .appointment-left { flex: 1 1 auto; min-width: 220px; }
        .appointment-card .appointment-right { flex: 0 0 auto; }
        .action-btn { padding: 0.45rem 0.75rem; }
    .status-badge {
        border-radius: 12px;
        padding: 0.25rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #fff;
        display: inline-block;
    }
        .status-pending { background: var(--warning); color: var(--forest-green); }
        .status-completed { background: var(--success); }
        .status-cancelled { background: var(--danger); }
        .status-upcoming { background: var(--info); }
        .status-accepted { background: var(--forest-green); }
        .status-declined { background: var(--gray-600); }
    .action-btn {
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.95rem;
        font-weight: 500;
        margin-right: 0.5rem;
        transition: background 0.2s, color 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
        .action-btn.view { background: var(--forest-green); color: #fff; }
        .action-btn.view:hover { background: var(--forest-green-light); }
        .action-btn.edit { background: var(--yellow-maize); color: var(--forest-green); }
        .action-btn.edit:hover { background: #f1c40f; }
        .action-btn.cancel { background: var(--danger); color: #fff; }
        .action-btn.cancel:hover { background: #b52a37; }
        .action-btn.complete { background: var(--success); color: #fff; }
        .action-btn.complete:hover { background: #218838; }
        .action-btn.notes { background: var(--info); color: #fff; }
        .action-btn.notes:hover { background: #138496; }
        
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
        
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--gray-600);
            background: var(--gray-50);
            border-radius: 12px;
            border: 2px dashed var(--gray-100);
        }
        .empty-state i { font-size: 2rem; color: var(--gray-600); margin-bottom: 1rem; }
        
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
                    <div class="welcome-text">My Appointments</div>
                    <div style="font-size: 0.9rem; margin-top: 0.5rem;">Manage and review all your counseling appointments here</div>
                </div>
                <div class="welcome-avatar">
                    <img src="{{ auth()->user()->avatar_url }}" 
                         alt="{{ auth()->user()->name }}" 
                         class="welcome-avatar-img rounded-circle">
                </div>
            </div>
            
            <div class="main-content-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Appointments</h5>
                    <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-journal-text me-1"></i>Go to Session Notes
                    </a>
                </div>
                <div class="card-body">
            <!-- Filter/Search -->
            <form method="GET" class="row g-2 mb-4 align-items-center">
                <div class="col-md-3">
                    <input type="text" name="student" class="form-control" placeholder="Search by student name or email" value="{{ request('student') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="declined" {{ request('status') == 'declined' ? 'selected' : '' }}>Declined</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="mode" class="form-control">
                        <option value="">All Modes</option>
                        <option value="online" {{ request('mode') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="in_person" {{ request('mode') == 'in_person' ? 'selected' : '' }}>In-person</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex gap-1">
                    <button type="submit" class="btn btn-success w-100" title="Apply filters"><i class="bi bi-funnel"></i></button>
                    <a href="{{ route('counselor.appointments.index') }}" class="btn btn-outline-secondary w-100" title="Clear filters"><i class="bi bi-x-lg"></i></a>
                </div>
            </form>
                    
                    <!-- Appointments List -->
                    @forelse($appointments as $appointment)
                @if($appointment->status !== 'cancelled')
                    @php
                        $start = $appointment->scheduled_at;
                        $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                            ->where('start', $start)
                            ->first();
                        $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                    @endphp
                    <div class="appointment-card">
                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                            <div class="d-flex align-items-center gap-3 appointment-left">
                                <img src="{{ $appointment->student->avatar_url }}" 
                                     alt="{{ $appointment->student->name }}" 
                                     class="appointment-avatar rounded-circle">
                                <div class="appointment-main">
                                    <h5 class="mb-1 fw-bold name" style="color: var(--forest-green);">{{ $appointment->student->name ?? 'N/A' }}</h5>
                                    <div class="text-muted small time"><i class="bi bi-clock me-1"></i> {{ $start->format('M d, Y - g:i A') }} – {{ $end->format('g:i A') }}</div>
                                </div>
                                @php
                                    // Get the session note for this appointment (if any)
                                    $sessionNoteForThisAppointment = $appointment->sessionNotes->first();
                                @endphp
                                @if($sessionNoteForThisAppointment)
                                    <span class="badge bg-primary ms-2">Session {{ $sessionNoteForThisAppointment->session_number }}</span>
                                @endif
                            </div>
                            <div class="appointment-right text-end">
                                <div>
                                    <span class="status-badge status-{{ $appointment->status }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            @if($appointment->status === 'pending')
                                <div class="btn-group" role="group">
                                    <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="action-btn view"><i class="bi bi-eye"></i> View</a>
                                    <form action="{{ route('counselor.appointments.accept', $appointment->id) }}" method="POST" style="display:inline;" data-confirm="Accept this appointment?">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn complete"><i class="bi bi-check-circle"></i> Accept</button>
                                    </form>
                                    <form action="{{ route('counselor.appointments.decline', $appointment->id) }}" method="POST" style="display:inline;" data-confirm="Decline this appointment?">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn cancel"><i class="bi bi-x-circle"></i> Decline</button>
                                    </form>
                                </div>
                            @endif
                            @if($appointment->status === 'accepted')
                                <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="action-btn view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('counselor.appointments.edit', $appointment->id) }}" class="action-btn edit" data-confirm="Reschedule this appointment?">
                                    <i class="bi bi-calendar2-week"></i> Reschedule
                                </a>
                                <form action="{{ route('counselor.appointments.complete', $appointment->id) }}" method="POST" style="display:inline;" data-confirm="Mark this appointment as complete?">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="action-btn complete"><i class="bi bi-check-circle"></i> Mark Complete</button>
                                </form>
                            @endif
                            @if($appointment->status === 'completed')
                                <a href="{{ route('counselor.session_notes.create', $appointment->id) }}" class="action-btn notes">
                                    <i class="bi bi-journal-plus"></i> Add/View Session Notes
                                </a>
                                @if($sessionNoteForThisAppointment)
                                    <a href="{{ route('counselor.session_notes.show', $sessionNoteForThisAppointment->id) }}" class="action-btn view">
                                        <i class="bi bi-eye"></i> View Session Note
                                    </a>
                                @endif
                                <form action="{{ route('counselor.appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;" data-confirm="Permanently delete this appointment?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn cancel">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                            @if($appointment->status === 'declined')
                                <form action="{{ route('counselor.appointments.destroy', $appointment->id) }}" method="POST" style="display:inline;" data-confirm="Permanently delete this appointment?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn cancel">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                            @if(in_array($appointment->status, ['rescheduled_pending', 'accepted', 'declined']) && $appointment->previous_scheduled_at)
                                <div class="mt-2 reschedule-status-card small d-flex align-items-center gap-2" style="background: #f8fafc; border: 1px solid #bee5eb; border-radius: 10px; padding: 1rem;">
                                    <i class="bi bi-arrow-repeat me-2 fs-4 text-info"></i>
                                    <div>
                                        @if($appointment->status === 'rescheduled_pending')
                                            <strong>Waiting for student approval for the new rescheduled date.</strong><br>
                                        @elseif($appointment->status === 'accepted')
                                            <strong>The student has <span class="text-success">accepted</span> the new rescheduled date.</strong><br>
                                        @elseif($appointment->status === 'declined')
                                            <strong>The student has <span class="text-danger">declined</span> the new rescheduled date.</strong><br>
                                        @endif
                                        <span>Old date and time: <b>{{ $appointment->previous_scheduled_at ? $appointment->previous_scheduled_at->format('F j, Y \\a\\t g:i A') : 'N/A' }}</b></span><br>
                                        <span>Rescheduled date and time: <b>{{ $appointment->scheduled_at->format('F j, Y \\a\\t g:i A') }}</b></span>
                                    </div>
                                    <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn btn-outline-primary btn-sm ms-auto"><i class="bi bi-eye me-1"></i> View</a>
                                </div>
                            @endif
                        </div>
                        @if($appointment->notes && $appointment->status !== 'completed' && $appointment->status !== 'accepted' && $appointment->status !== 'declined')
                            <div class="mt-2 text-muted small"><i class="bi bi-journal-text"></i> Notes: {{ Str::limit($appointment->notes, 80) }}</div>
                        @endif
                        @if($appointment->status === 'accepted')
                            <div class="mt-2 text-success small"><i class="bi bi-journal-text"></i> This appointment has been accepted.</div>
                        @endif
                        @if($appointment->status === 'completed')
                            <div class="mt-2 text-primary small"><i class="bi bi-journal-text"></i> Session notes available.</div>
                        @endif
                        @if($appointment->status === 'declined')
                            <div class="mt-2 text-danger small"><i class="bi bi-journal-text"></i> Your appointment was declined. Please select another available slot or contact the GCC for assistance.</div>
                        @endif
                    </div>
                @endif
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-calendar-x"></i>
                            <p class="mb-0">No appointments found. Try adjusting your filters or create a new appointment.</p>
                        </div>
                    @endforelse
                    {{-- Pagination controls --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $appointments->links('vendor.pagination.bootstrap-5') }}
                    </div>
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
            // Confirmation handler for actions with data-confirm using Bootstrap modal
            const confirmModalEl = document.getElementById('confirmModal');
            let bsConfirmModal = null;
            if (confirmModalEl && typeof bootstrap !== 'undefined') {
                bsConfirmModal = new bootstrap.Modal(confirmModalEl, { backdrop: 'static' });
            }
            let confirmTarget = null;
            // Helper to show the modal; prefers Bootstrap if available, otherwise uses a lightweight JS fallback
            function showConfirmModal(message, target) {
                document.getElementById('confirmModalMessage').textContent = message;
                confirmTarget = target;
                if (bsConfirmModal) {
                    bsConfirmModal.show();
                    return;
                }
                // Lightweight fallback: toggle modal classes/styles without Bootstrap JS
                confirmModalEl.classList.add('show');
                confirmModalEl.style.display = 'block';
                // add backdrop
                let backdrop = document.getElementById('confirmModalBackdrop');
                if (!backdrop) {
                    backdrop = document.createElement('div');
                    backdrop.id = 'confirmModalBackdrop';
                    backdrop.style.position = 'fixed';
                    backdrop.style.inset = '0';
                    backdrop.style.background = 'rgba(0,0,0,0.5)';
                    backdrop.style.zIndex = 1050;
                    document.body.appendChild(backdrop);
                } else {
                    backdrop.style.display = 'block';
                }
                document.body.classList.add('modal-open');
            }

            document.querySelectorAll('[data-confirm]').forEach(function(el) {
                if (el.tagName === 'FORM') {
                    el.addEventListener('submit', function(event) {
                        event.preventDefault();
                        var msg = el.getAttribute('data-confirm') || 'Are you sure?';
                        showConfirmModal(msg, el);
                    });
                } else {
                    el.addEventListener('click', function(event) {
                        event.preventDefault();
                        var msg = el.getAttribute('data-confirm') || 'Are you sure?';
                        showConfirmModal(msg, el);
                    });
                }
            });

            // Confirm button behavior
            const confirmBtn = document.getElementById('confirmModalOk');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function() {
                    if (!confirmTarget) return;
                    if (confirmTarget.tagName === 'FORM') {
                        // submit the form programmatically
                        confirmTarget.removeAttribute('data-confirm');
                        confirmTarget.submit();
                    } else if (confirmTarget.tagName === 'A') {
                        const href = confirmTarget.getAttribute('href');
                        if (href) window.location.href = href;
                    }
                    // hide modal (bootstrap or fallback)
                    if (bsConfirmModal) {
                        bsConfirmModal.hide();
                    } else {
                        confirmModalEl.classList.remove('show');
                        confirmModalEl.style.display = 'none';
                        const backdrop = document.getElementById('confirmModalBackdrop');
                        if (backdrop) backdrop.style.display = 'none';
                        document.body.classList.remove('modal-open');
                    }
                });
            }
        });
    </script>
        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Please confirm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="confirmModalMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmModalOk">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
@endsection 