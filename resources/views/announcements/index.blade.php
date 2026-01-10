@extends('layouts.app')

@section('content')
    <style>
        :root {
            --forest-green: #1f7a2d;
            --forest-green-light: #4a7c59;
            --forest-green-lighter: #e8f5e8;
            --yellow-maize: #f4d03f;
            --gray-50: #f8f9fa;
            --gray-100: #eef6ee;
            --gray-600: #6c757d;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hero-gradient: linear-gradient(135deg, var(--forest-green) 0%, #13601f 100%);
        }

        /* Force sidebar to use the local forest-green variable */
        .custom-sidebar {
            background: var(--forest-green) !important;
        }

        /* Match dashboard zoom */
        .home-zoom {
            zoom: 0.75;
        }
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }



        @if(auth()->check() && auth()->user()->isAdmin())
            .main-dashboard-inner {
                padding: 2rem;
            }

        @elseif(auth()->check() && auth()->user()->isCounselor())


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
            }

        @endif .welcome-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
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
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .page-header-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-header-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
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

        .announcement-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 1.25rem;
            height: 100%;
            position: relative;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .announcement-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #228B22, #FFCB05);
        }

        .announcement-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(0, 0, 0, 0.08);
            text-decoration: none;
        }

        .announcement-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2e7d32, #228B22);
            color: #fff;
            box-shadow: 0 6px 16px rgba(34, 139, 34, 0.2);
            margin-bottom: .75rem;
        }

        .announcement-title {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: .25rem;
        }

        .announcement-meta {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: .5rem;
        }

        .announcement-date {
            display: inline-block;
            padding: .22rem .6rem;
            border-radius: 999px;
            background: rgba(255, 203, 5, 0.15);
            color: #8a6d00;
            font-size: .8rem;
            font-weight: 600;
        }

        .announcement-new {
            display: inline-block;
            padding: .22rem .5rem;
            border-radius: 999px;
            background: #FFCB05;
            color: #1a1a1a;
            font-size: .72rem;
            font-weight: 700;
        }

        .announcement-excerpt {
            color: #6c757d;
            margin-bottom: 0;
        }
    </style>

    @if(auth()->check() && auth()->user()->isCounselor())
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
                    <div class="main-dashboard-inner home-zoom">
                        <div class="welcome-card">
                            <div>
                                <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
                                <div class="welcome-text">Announcements</div>
                                <div style="font-size: 0.9rem; margin-top: 0.5rem;">Stay updated with the latest news and
                                    updates</div>
                            </div>
                            <div class="welcome-avatar">
                                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            </div>
                        </div>

                        <div class="main-content-card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>All Announcements</h5>
                                @if(auth()->check() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin())
                                    <a href="{{ route('announcements.create') }}" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-plus-circle me-1"></i>Create Announcement
                                    </a>
                                @endif
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                <div class="row g-4">
    @elseif(auth()->check() && auth()->user()->isAdmin())
                                    <div class="main-dashboard-inner home-zoom">
                                        <div class="page-header-card">
                                            <div>
                                                <h1><i class="bi bi-megaphone me-2"></i>Announcements</h1>
                                                <p style="margin: 0.5rem 0 0 0; opacity: 0.9; font-size: 0.95rem;">Manage and
                                                    create system announcements</p>
                                            </div>
                                            <div>
                                                <a href="{{ route('announcements.create') }}" class="btn btn-light btn-lg">
                                                    <i class="bi bi-plus-circle me-2"></i>Create Announcement
                                                </a>
                                            </div>
                                        </div>

                                        <div class="main-content-card">
                                            <div class="card-header">
                                                <h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>All Announcements</h5>
                                            </div>
                                            <div class="card-body">
                                                @if(session('success'))
                                                    <div class="alert alert-success">{{ session('success') }}</div>
                                                @endif
                                                <div class="row g-4">
                                @else

                                                    <div class="home-zoom">
                                                        <div class="container-fluid px-4 py-4">
                                                            <div class="page-header-card">
                                                                <div>
                                                                    <h1><i class="bi bi-megaphone me-2"></i>Announcements</h1>
                                                                </div>
                                                                <div>
                                                                    @if(auth()->check())
                                                                        <a href="{{ route('dashboard') }}" class="btn btn-light">
                                                                            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ route('home') }}" class="btn btn-light">
                                                                            <i class="bi bi-arrow-left me-2"></i>Back to Home
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if(session('success'))
                                                                <div class="alert alert-success">{{ session('success') }}</div>
                                                            @endif
                                                            <div class="row g-4">
                                                @endif
                                                            @forelse($announcements as $announcement)
                                                                <div class="col-md-6 col-lg-4">
                                                                    <a href="{{ route('announcements.show', $announcement->id) }}"
                                                                        class="announcement-card">
                                                                        <div class="announcement-icon"><i
                                                                                class="fas fa-bullhorn"></i>
                                                                        </div>
                                                                        <div class="announcement-title">
                                                                            {{ $announcement->title }}
                                                                        </div>
                                                                        <div class="announcement-meta">
                                                                            <span
                                                                                class="announcement-date">{{ optional($announcement->created_at)->format('M d, Y') }}</span>
                                                                            @if(optional($announcement->created_at) && optional($announcement->created_at)->greaterThanOrEqualTo(now()->subDays(14)))
                                                                                <span class="announcement-new">NEW</span>
                                                                            @endif
                                                                        </div>
                                                                        <p class="announcement-excerpt">
                                                                            {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content ?? ''), 140) }}
                                                                        </p>
                                                                    </a>
                                                                </div>
                                                            @empty
                                                                <div class="col-12">
                                                                    <div class="text-center p-5 bg-white rounded-4 shadow-sm border"
                                                                        style="border-color: rgba(0,0,0,0.06) !important;">
                                                                        <div class="d-inline-flex align-items-center justify-content-center announcement-icon"
                                                                            style="margin-bottom: .75rem;">
                                                                            <i class="fas fa-bullhorn"></i>
                                                                        </div>
                                                                        <h5 class="fw-bold mb-2" style="color:#2c3e50;">No
                                                                            announcements found</h5>
                                                                        <p class="text-muted mb-0">Please check back later for
                                                                            updates and news.</p>
                                                                    </div>
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                        <div class="mt-3">
                                                            {{ $announcements->links() }}
                                                        </div>
                                                        @if(auth()->check() && auth()->user()->isCounselor())
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
                                                                        document.addEventListener('keydown', function (e) {
                                                                            if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                                                                                sidebar.classList.remove('show');
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            </script>
                                                        @elseif(auth()->check() && auth()->user()->isAdmin())
                                        </div>
                                    </div>
                                </div>
                            @else
                    </div>
                @endif
@endsection