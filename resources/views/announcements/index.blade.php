@extends('layouts.app')

@section('content')
<style>
    .create-announcement-btn {
        background: var(--yellow-maize);
        color: var(--forest-green);
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
        color: var(--forest-green);
        box-shadow: 0 8px 24px rgba(44,62,80,0.13);
        transform: translateY(-2px) scale(1.03);
        text-decoration: none;
    }
    .back-dashboard-btn {
        background: var(--yellow-maize);
        color: var(--forest-green);
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
        color: var(--forest-green);
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
</style>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="fw-bold mb-0" style="color: var(--forest-green);"><i class="bi bi-megaphone me-2"></i>Announcements</h1>
        @if(auth()->user() && auth()->user()->role === 'admin')
            <a href="{{ route('announcements.create') }}" class="create-announcement-btn"><i class="bi bi-plus-circle me-1"></i> Create Announcement</a>
        @else
            <a href="{{ route('dashboard') }}" class="back-dashboard-btn"><i class="bi bi-arrow-left me-1"></i> Back to Dashboard</a>
        @endif
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="list-group">
        @forelse($announcements as $announcement)
            <a href="{{ route('announcements.show', $announcement->id) }}" class="list-group-item list-group-item-action mb-2">
                <h5>{{ $announcement->title }}</h5>
                <p class="mb-1">{{ Str::limit($announcement->content, 100) }}</p>
                <small>Posted {{ $announcement->created_at->diffForHumans() }}</small>
            </a>
        @empty
            <p>No announcements found.</p>
        @endforelse
    </div>
    <div class="mt-3">
        {{ $announcements->links() }}
    </div>
</div>
@endsection 