@extends('layouts.app')

@section('content')
<style>
    .announcement-zoom { zoom: 0.9; }
    @supports not (zoom: 1) {
        .announcement-zoom { transform: scale(0.9); transform-origin: top center; }
    }
}</style>
<div class="announcement-zoom">
<div class="container">
    <div class="py-4 px-4 px-lg-5 mb-4 rounded-4" style="background: linear-gradient(135deg, #228B22, #0f3d1e); color: #fff;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <a href="{{ route('home') }}" class="text-white-50 text-decoration-none me-3">
                        <span class="me-1">&larr;</span> Back
                    </a>
                </div>
                <h1 class="h3 fw-bold mb-2">{{ $announcement->title }}</h1>
                <div class="d-flex align-items-center gap-2 small">
                    <span class="badge rounded-pill" style="background: rgba(255,203,5,0.15); color:#ffdf66;">{{ optional($announcement->created_at)->format('M d, Y') }}</span>
                    <span class="text-white-50">&middot;</span>
                    <span class="text-white-75">Posted {{ optional($announcement->created_at)->diffForHumans() }}</span>
                    @if(optional($announcement->created_at) && optional($announcement->created_at)->greaterThanOrEqualTo(now()->subDays(14)))
                        <span class="badge" style="background:#FFCB05; color:#1a1a1a; font-weight:700;">NEW</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <div class="mb-4" style="line-height: 1.8; color:#2c3e50;">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>
                    @php
                        $attachmentPath = $announcement->attachment ?? null;
                        $attachmentUrl = $attachmentPath ? asset('storage/' . $attachmentPath) : null;
                        $isImage = $attachmentPath && preg_match('/\.(jpg|jpeg|png|gif|webp|bmp|svg)$/i', $attachmentPath);
                    @endphp
                    @if($attachmentPath)
                        @if($isImage)
                            <div class="rounded-3 overflow-hidden mb-3" style="background:#f5f7f6;border:1px solid rgba(0,0,0,0.06);">
                                <a href="{{ $attachmentUrl }}" target="_blank" class="d-block">
                                    <img src="{{ $attachmentUrl }}" alt="Announcement Attachment" class="img-fluid w-100" style="display:block;object-fit:cover;">
                                </a>
                            </div>
                            <div class="text-muted small mb-2">Click the image to open in a new tab.</div>
                        @else
                            <div class="p-3 p-lg-4 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: #f8faf9; border: 1px solid rgba(0,0,0,0.06);">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-inline-flex align-items-center justify-content-center" style="width:44px;height:44px;border-radius:12px;background: linear-gradient(135deg, #2e7d32, #228B22); color:#fff;">
                                        <i class="fas fa-paperclip"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">Attachment</div>
                                        <div class="text-muted small">Click to view or download</div>
                                    </div>
                                </div>
                                <a href="{{ $attachmentUrl }}" target="_blank" class="btn btn-success fw-semibold" style="background:#228B22;border:none;border-radius:10px;">
                                    View Attachment
                                </a>
                            </div>
                        @endif
                    @endif

                    <div class="d-flex align-items-center gap-2 mt-4">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
@endsection 