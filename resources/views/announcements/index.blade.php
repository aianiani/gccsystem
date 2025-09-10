@extends('layouts.app')

@section('content')
<style>
    .create-announcement-btn {
        background: #FFCB05;
        color: #1a3a1f;
        border: none;
        border-radius: 16px;
        padding: 1rem 2.2rem;
        font-size: 1.15rem;
        font-weight: 700;
        box-shadow: 0 4px 16px rgba(44,62,80,0.10);
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
        text-decoration: none;
        margin-left: 0.5rem;
    }
    .create-announcement-btn:hover, .create-announcement-btn:focus {
        background: #ffe066;
        color: #1a3a1f;
        box-shadow: 0 8px 24px rgba(44,62,80,0.13);
        transform: translateY(-2px) scale(1.03);
        text-decoration: none;
    }
    .back-dashboard-btn {
        background: #FFCB05;
        color: #1a3a1f;
        border: none;
        border-radius: 16px;
        padding: 1rem 2.2rem;
        font-size: 1.15rem;
        font-weight: 700;
        box-shadow: 0 4px 16px rgba(44,62,80,0.10);
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
        text-decoration: none;
        margin-left: 0.5rem;
    }
    .back-dashboard-btn:hover, .back-dashboard-btn:focus {
        background: #ffe066;
        color: #1a3a1f;
        box-shadow: 0 8px 24px rgba(44,62,80,0.13);
        transform: translateY(-2px) scale(1.03);
        text-decoration: none;
    }
    @media (max-width: 600px) {
        .create-announcement-btn, .back-dashboard-btn {
            width: 100%;
            justify-content: center;
            font-size: 1rem;
            padding: 0.8rem 1.2rem;
        }
    }

    /* Announcements Grid */
    .announcement-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
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
        top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, #228B22, #FFCB05);
    }
    .announcement-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        border-color: rgba(0,0,0,0.08);
        text-decoration: none;
    }
    .announcement-icon {
        width: 42px; height: 42px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #2e7d32, #228B22);
        color: #fff; box-shadow: 0 6px 16px rgba(34,139,34,0.2);
        margin-bottom: .75rem;
    }
    .announcement-title { font-weight: 700; color: #2c3e50; margin-bottom: .25rem; }
    .announcement-meta { display: flex; align-items: center; gap: .5rem; margin-bottom: .5rem; }
    .announcement-date { display: inline-block; padding: .22rem .6rem; border-radius: 999px; background: rgba(255,203,5,0.15); color: #8a6d00; font-size: .8rem; font-weight: 600; }
    .announcement-new { display: inline-block; padding: .22rem .5rem; border-radius: 999px; background: #FFCB05; color: #1a1a1a; font-size: .72rem; font-weight: 700; }
    .announcement-excerpt { color: #6c757d; margin-bottom: 0; }
</style>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="fw-bold mb-0" style="color: #228B22;"><i class="bi bi-megaphone me-2"></i>Announcements</h1>
        @if(auth()->check() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin())
            <a href="{{ route('announcements.create') }}" class="create-announcement-btn"><i class="bi bi-plus-circle me-1"></i> Create Announcement</a>
        @else
            <a href="{{ route('home') }}" class="back-dashboard-btn"><i class="bi bi-arrow-left me-1"></i> Back to Home</a>
        @endif
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row g-4">
        @forelse($announcements as $announcement)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('announcements.show', $announcement->id) }}" class="announcement-card">
                    <div class="announcement-icon"><i class="fas fa-bullhorn"></i></div>
                    <div class="announcement-title">{{ $announcement->title }}</div>
                    <div class="announcement-meta">
                        <span class="announcement-date">{{ optional($announcement->created_at)->format('M d, Y') }}</span>
                        @if(optional($announcement->created_at) && optional($announcement->created_at)->greaterThanOrEqualTo(now()->subDays(14)))
                            <span class="announcement-new">NEW</span>
                        @endif
                    </div>
                    <p class="announcement-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->content ?? ''), 140) }}</p>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center p-5 bg-white rounded-4 shadow-sm border" style="border-color: rgba(0,0,0,0.06) !important;">
                    <div class="d-inline-flex align-items-center justify-content-center announcement-icon" style="margin-bottom: .75rem;">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h5 class="fw-bold mb-2" style="color:#2c3e50;">No announcements found</h5>
                    <p class="text-muted mb-0">Please check back later for updates and news.</p>
                </div>
            </div>
        @endforelse
    </div>
    <div class="mt-3">
        {{ $announcements->links() }}
    </div>
</div>
@endsection 