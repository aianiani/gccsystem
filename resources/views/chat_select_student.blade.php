@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width: 600px;">
    <h3 class="mb-3">Select a Student to Chat With</h3>
    <ul class="list-group">
        @foreach($students as $student)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $student->name }}</span>
                <a href="{{ route('chat.index', $student->id) }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-chat-dots"></i> Chat
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection 