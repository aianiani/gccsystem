@extends('layouts.app')

@section('content')
<style>
    .admin-announcement-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 3px 0 rgba(0,0,0,0.08);
        padding: 2rem 2.5rem;
        max-width: 600px;
        margin: 2rem auto;
    }
    .admin-announcement-card h1 {
        color: var(--forest-green);
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
    .admin-action-btn {
        background: var(--yellow-maize);
        color: var(--forest-green);
        border: none;
        border-radius: 12px;
        padding: 0.8rem 1.7rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 1px 3px 0 rgba(0,0,0,0.08);
        margin-right: 0.5rem;
    }
    .admin-action-btn:hover {
        background: #f1c40f;
        color: var(--forest-green);
    }
    .btn-secondary {
        border-radius: 12px;
        font-weight: 600;
        margin-left: 0.5rem;
    }
</style>
<div class="container">
    <div class="admin-announcement-card">
        <h1><i class="bi bi-megaphone me-2"></i>Create Announcement</h1>
        <form action="{{ url('announcements') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label fw-bold">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="content" class="form-label fw-bold">Content</label>
                <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
                @error('content')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label fw-bold">Attachment (optional)</label>
                <input type="file" name="attachment" id="attachment" class="form-control">
                @error('attachment')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="admin-action-btn"><i class="bi bi-plus-circle me-1"></i> Create</button>
                <a href="{{ route('announcements.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection 