@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables */
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

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

        /* Apply page zoom */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styles to ensure fixed positioning works correctly */
        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0, 0, 0, 0.08);
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
            max-width: 100%;
            margin: 0 auto;
            padding: 0 1rem;
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

        .btn-outline-primary {
            border-radius: 12px;
            font-weight: 600;
            border-color: var(--forest-green);
            color: var(--forest-green);
            transition: all 0.15s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--forest-green);
            color: white;
            transform: translateY(-1px);
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
            <button id="counselorSidebarToggle" class="d-md-none" style="position: fixed; top: 10px; left: 10px; z-index: 1050; border: none; background: var(--forest-green); color: white; padding: 5px 10px; border-radius: 5px;">
                <i class="bi bi-list"></i>
            </button>
            
            <!-- Sidebar -->
            @include('counselor.sidebar')

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <!-- Header with Welcome Card style for consistency -->
                    <div class="welcome-card mb-4" style="min-height: auto; padding: 1.5rem;">
                        <div>
                            <div class="welcome-text" style="font-size: 1.5rem;">Student Feedback</div>
                            <div style="font-size: 0.9rem; margin-top: 0.25rem; opacity: 0.9;">
                                Review ratings and comments from your counseling sessions.
                            </div>
                        </div>
                        <div class="d-none d-md-block" style="font-size: 2rem; opacity: 0.8;">
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                    </div>

                    <div class="main-content-card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0 text-dark fw-bold">
                                <i class="bi bi-chat-left-text me-2 text-warning"></i>Feedback Received
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead style="background-color: var(--bg-light);">
                                        <tr>
                                            <th class="ps-4 py-3 text-secondary text-uppercase small font-weight-bold"
                                                style="letter-spacing: 0.5px; border-bottom: 2px solid var(--gray-100);">Student</th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold"
                                                style="letter-spacing: 0.5px; border-bottom: 2px solid var(--gray-100);">Rating</th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold"
                                                style="letter-spacing: 0.5px; border-bottom: 2px solid var(--gray-100);">Comments</th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold"
                                                style="letter-spacing: 0.5px; border-bottom: 2px solid var(--gray-100);">Date</th>
                                            <th class="pe-4 py-3 text-end text-secondary text-uppercase small font-weight-bold"
                                                style="letter-spacing: 0.5px; border-bottom: 2px solid var(--gray-100);">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($feedbacks as $feedback)
                                            <tr>
                                                <td class="ps-4 py-3">
                                                    <div class="d-flex align-items-center">
                                                        @if($feedback->appointment->student->avatar)
                                                            <img src="{{ $feedback->appointment->student->avatar_url }}" alt=""
                                                                class="rounded-circle me-3 border" width="45" height="45"
                                                                style="object-fit: cover;">
                                                        @else
                                                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                                                style="width: 45px; height: 45px; font-size: 1.2rem; font-weight: bold;">
                                                                {{ strtoupper(substr($feedback->appointment->student->name, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-bold text-dark" style="font-size: 1rem;">
                                                                {{ $feedback->appointment->student->name }}</div>
                                                            <div class="small text-muted">
                                                                {{ $feedback->appointment->student->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="d-flex text-warning" style="font-size: 0.9rem;">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="bi bi-star{{ $i <= $feedback->rating ? '-fill' : '' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="small fw-semibold text-muted ms-1">{{ $feedback->rating }}/5</span>
                                                </td>
                                                <td class="py-3">
                                                    <div class="text-truncate text-secondary" style="max-width: 350px; font-style: italic;">
                                                        "{{ $feedback->comments }}"
                                                    </div>
                                                </td>
                                                <td class="py-3 text-muted small">
                                                    <div class="fw-semibold">{{ $feedback->created_at->format('M d, Y') }}</div>
                                                    <div class="text-xs text-muted">{{ $feedback->created_at->format('h:i A') }}
                                                    </div>
                                                </td>
                                                <td class="pe-4 py-3 text-end">
                                                    <a href="{{ route('counselor.feedback.show', $feedback->id) }}"
                                                        class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1">
                                                        <i class="bi bi-eye me-1"></i>View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5">
                                                    <div class="d-flex flex-column align-items-center justify-content-center opacity-50">
                                                        <i class="bi bi-chat-heart display-1 mb-3 text-success"></i>
                                                        <h5 class="text-muted fw-bold">No feedback received yet</h5>
                                                        <p class="text-muted small">Student reviews and ratings will appear here.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Pagination -->
                        @if($feedbacks->hasPages())
                            <div class="card-footer bg-white border-0 py-3">
                                {{ $feedbacks->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle logic matching student directory
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function () {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function (e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
@endsection