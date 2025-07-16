@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Announcements</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @auth
        @if(auth()->user()->isAdmin())
            <a href="{{ route('announcements.create') }}" class="btn btn-primary mb-3">Create Announcement</a>
        @endif
    @endauth
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