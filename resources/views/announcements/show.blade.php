@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $announcement->title }}</h1>
    <p class="text-muted">Posted {{ $announcement->created_at->diffForHumans() }}</p>
    <div class="mb-3">{!! nl2br(e($announcement->content)) !!}</div>
    @if($announcement->attachment)
        <div class="mb-3">
            <a href="{{ asset('storage/' . $announcement->attachment) }}" target="_blank" class="btn btn-outline-secondary">View Attachment</a>
        </div>
    @endif
    @auth
        @if(auth()->user()->isAdmin())
            <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this announcement?')">Delete</button>
            </form>
        @endif
    @endauth
    <a href="{{ route('announcements.index') }}" class="btn btn-secondary mt-3">Back to Announcements</a>
</div>
@endsection 