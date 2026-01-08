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

    .page-header-card {
        background: var(--hero-gradient);
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        color: #fff;
    }

    .page-header-card h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: #fff;
    }

    .page-header-card p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .filter-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .month-banner {
        background: var(--forest-green-lighter);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .month-banner h3 {
        color: var(--forest-green);
        font-weight: 700;
        margin: 0;
        font-size: 1.3rem;
    }

    .report-section-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .report-section-header {
        background: var(--forest-green-lighter);
        color: var(--forest-green);
        font-weight: 700;
        font-size: 1.1rem;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--gray-100);
        text-transform: uppercase;
    }

    .report-table {
        width: 100%;
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .report-table thead {
        background: var(--forest-green);
        color: white;
    }

    .report-table thead th {
        padding: 0.85rem 0.75rem;
        font-weight: 600;
        text-align: center;
        border: 1px solid var(--forest-green-light);
        font-size: 0.85rem;
    }

    .report-table tbody td {
        padding: 0.75rem 0.85rem;
        border: 1px solid #dee2e6;
        font-size: 0.85rem;
    }

    .total-row {
        background: var(--forest-green-lighter) !important;
        font-weight: 700;
        color: var(--forest-green);
    }

    .college-list {
        font-size: 0.8rem;
        color: var(--gray-600);
        font-style: italic;
    }
</style>

<div class="page-header-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1><i class="bi bi-file-earmark-bar-graph me-2"></i>Monthly Reports</h1>
            <p>Comprehensive report for Testing, Guidance, and Counseling activities</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-light no-print">
                <i class="bi bi-printer me-1"></i> Print
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-light no-print">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>
</div>
