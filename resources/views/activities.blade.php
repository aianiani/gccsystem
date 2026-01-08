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



        .main-dashboard-inner {
            padding: 2rem;
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

        .page-header-card p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
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

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--gray-50);
            color: var(--forest-green);
            font-weight: 600;
            border-bottom: 2px solid var(--gray-100);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: var(--forest-green-lighter);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--gray-600);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .main-dashboard-inner {
                padding: 1rem;
            }

            .page-header-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }
    </style>

    <div class="main-dashboard-inner">
        <div class="page-header-card">
            <div>
                <h1><i class="bi bi-activity me-2"></i>Activity Logs</h1>
                <p>Monitor all user activities across the system</p>
            </div>
            <div>
                <span class="badge bg-light text-dark fs-6 px-3 py-2">
                    <i class="bi bi-list-ul me-1"></i>{{ $activities->total() }} total activities
                </span>
            </div>
        </div>

        <div class="main-content-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-activity me-2"></i>System Activities</h5>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary">{{ $activities->count() }} shown</span>
                </div>
            </div>
            <div class="card-body p-0">
                @if($activities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">User</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>IP Address</th>
                                    <th>Browser</th>
                                    <th class="pe-4">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if($activity->user)
                                                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle me-3 shadow"
                                                        style="width: 45px; height: 45px;">
                                                        <img src="{{ $activity->user->avatar_url }}" alt="Avatar" class="rounded-circle"
                                                            width="36" height="36">
                                                    </div>
                                                @else
                                                    <div class="d-inline-flex align-items-center justify-content-center bg-secondary bg-opacity-10 rounded-circle me-3 shadow"
                                                        style="width: 45px; height: 45px;">
                                                        <i class="bi bi-person-circle fs-5 text-secondary"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $activity->user->name ?? 'Unknown' }}</div>
                                                    <small class="text-muted">{{ $activity->user->email ?? 'Unknown' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ getActivityBadgeColor($activity->action) }} fs-6 px-3 py-2">
                                                <i class="bi bi-{{ getActivityIcon($activity->action) }} me-1"></i>
                                                {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-wrap" style="max-width: 300px;">
                                                {{ $activity->description }}
                                            </div>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-globe me-1"></i>{{ $activity->ip_address ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="bi bi-browser-chrome me-1"></i>{{ getBrowserName($activity->user_agent) }}
                                            </small>
                                        </td>
                                        <td class="pe-4">
                                            <div>
                                                <div class="fw-medium">{{ $activity->created_at->format('M d, Y') }}</div>
                                                <small class="text-muted">
                                                    <i class="bi bi-clock me-1"></i>{{ $activity->created_at->format('H:i:s') }}
                                                </small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center py-4">
                        {{ $activities->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-4"
                            style="width: 100px; height: 100px;">
                            <i class="bi bi-activity fs-1 text-muted"></i>
                        </div>
                        <h5 class="fw-semibold mb-3">No activities found</h5>
                        <p class="text-muted mb-4">No user activities have been recorded yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@php
    function getActivityBadgeColor($action)
    {
        return match ($action) {
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

    function getActivityIcon($action)
    {
        return match ($action) {
            'login' => 'box-arrow-in-right',
            'logout' => 'box-arrow-right',
            'register' => 'person-plus',
            'create_user' => 'person-plus-fill',
            'update_user' => 'pencil',
            'delete_user' => 'trash',
            'toggle_user_status' => 'toggle-on',
            default => 'circle'
        };
    }

    function getBrowserName($userAgent)
    {
        if (!$userAgent)
            return 'Unknown';
        if (stripos($userAgent, 'Brave') !== false || $userAgent === 'Brave')
            return 'Brave';
        if (stripos($userAgent, 'Edg') !== false)
            return 'Microsoft Edge';
        if (stripos($userAgent, 'OPR') !== false || stripos($userAgent, 'Opera') !== false)
            return 'Opera';
        if (stripos($userAgent, 'Chrome') !== false && stripos($userAgent, 'Edg') === false && stripos($userAgent, 'OPR') === false)
            return 'Google Chrome';
        if (stripos($userAgent, 'Safari') !== false && stripos($userAgent, 'Chrome') === false)
            return 'Safari';
        if (stripos($userAgent, 'Firefox') !== false)
            return 'Mozilla Firefox';
        if (stripos($userAgent, 'MSIE') !== false || stripos($userAgent, 'Trident') !== false)
            return 'Internet Explorer';
        return 'Other';
    }
@endphp