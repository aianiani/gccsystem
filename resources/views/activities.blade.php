@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="display-4 fw-bold mb-2" style="color:var(--text-primary)">
            <i class="bi bi-activity me-2"></i>Activity Logs
        </h1>
        <p class="fs-5 mb-0" style="color:var(--text-secondary)">Monitor all user activities across the system</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-activity me-2"></i>System Activities</h5>
            <div class="text-muted">
                Total: {{ $activities->total() }} activities
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($activities->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($activity->user)
                                            <img src="{{ $activity->user->avatar_url }}" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                        @else
                                            <i class="bi bi-person-circle fs-5 me-2 text-primary"></i>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $activity->user->name }}</div>
                                            <small class="text-muted">{{ $activity->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ getActivityBadgeColor($activity->action) }} fs-6 px-3 py-2">
                                        {{ ucfirst($activity->action) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-wrap" style="max-width: 300px;">
                                        {{ $activity->description }}
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $activity->ip_address ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <div>
                                        <div>{{ $activity->created_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $activity->created_at->format('H:i:s') }}</small>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center py-4">
                {{ $activities->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-4" style="width: 100px; height: 100px;">
                    <i class="bi bi-activity fs-1 text-muted"></i>
                </div>
                <h5 class="fw-semibold mb-3">No activities found</h5>
                <p class="text-muted mb-4">No user activities have been recorded yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@php
function getActivityBadgeColor($action) {
    return match($action) {
        'login' => 'success',
        'logout' => 'secondary',
        'register' => 'primary',
        'create_user' => 'info',
        'update_user' => 'warning',
        'delete_user' => 'danger',
        'toggle_user_status' => 'warning',
        default => 'secondary'
    };
}
@endphp 