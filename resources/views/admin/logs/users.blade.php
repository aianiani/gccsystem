@extends('layouts.app')

@section('content')
    <style>
        .log-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c59 100%);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: none;
        }

        .card-body {
            padding: 2rem;
        }

        .log-item {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            background: #f8f9fa;
            transition: all 0.2s ease;
        }

        .log-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .status-student {
            background: #cce5ff;
            color: #004085;
        }

        .status-counselor {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-admin {
            background: #fff3cd;
            color: #856404;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .search-filters {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .page-header {
            background: linear-gradient(135deg, #2d5016 0%, #4a7c59 100%);
            color: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 1rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            color: #2d5016;
        }

        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
    </style>

    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2">
                        <i class="bi bi-people me-3"></i>
                        Student Registration Logs
                    </h1>
                    <p class="mb-0 opacity-75">Monitor and manage student registration approvals</p>
                </div>
                <div>
                    <a href="{{ route('admin.registration-approvals.index') }}" class="btn btn-warning me-2">
                        <i class="bi bi-check-circle me-2"></i>
                        Manage Approvals
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">{{ \App\Models\User::where('role', 'student')->count() ?? 0 }}</div>
                    <div class="stats-label">Total Students</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">
                        {{ \App\Models\User::where('role', 'student')->where('registration_status', 'pending')->count() ?? 0 }}
                    </div>
                    <div class="stats-label">Pending Approval</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">
                        {{ \App\Models\User::where('role', 'student')->where('registration_status', 'approved')->count() ?? 0 }}
                    </div>
                    <div class="stats-label">Approved Students</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">
                        {{ \App\Models\User::where('role', 'student')->where('registration_status', 'rejected')->count() ?? 0 }}
                    </div>
                    <div class="stats-label">Rejected Registrations</div>
                </div>
            </div>
        </div>

        {{-- Export Buttons --}}
        <div class="mb-3 d-flex gap-2">
            <a href="{{ route('admin.logs.export', ['format' => 'pdf']) }}" class="btn btn-danger"><i
                    class="fa fa-file-pdf"></i> Export PDF</a>
            <a href="{{ route('admin.logs.export', ['format' => 'csv']) }}" class="btn btn-success"><i
                    class="fa fa-file-csv"></i> Export CSV</a>
            <a href="{{ route('admin.logs.export', ['format' => 'excel']) }}" class="btn btn-primary"><i
                    class="fa fa-file-excel"></i> Export Excel</a>
        </div>

        <!-- Logs removed as per request -->
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i> Student registration logs have been disabled.
        </div>
    </div>
@endsection