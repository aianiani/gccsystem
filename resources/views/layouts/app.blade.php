<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'User Management App') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --light-bg: #f4f6fa;
            --dark-bg: #181a20;
            --card-bg: #fff;
            --card-bg-dark: #23262f;
            --border-color: #e2e8f0;
            --border-color-dark: #23262f;
            --text-primary: #1e293b;
            --text-primary-dark: #f4f6fa;
            --text-secondary: #64748b;
            --text-secondary-dark: #a1a1aa;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        body.dark-mode {
            --light-bg: #181a20;
            --card-bg: #23262f;
            --border-color: #23262f;
            --text-primary: #f4f6fa;
            --text-secondary: #a1a1aa;
        }
        html { font-size: 17px; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--light-bg);
            min-height: 100vh;
            color: var(--text-primary);
            line-height: 1.6;
            transition: background 0.3s, color 0.3s;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            padding: 1.25rem 0;
            margin-bottom: 1.5rem;
            transition: background 0.3s, border-color 0.3s;
        }
        body.dark-mode .navbar {
            background: rgba(35, 38, 47, 0.98) !important;
            border-bottom: 1px solid var(--border-color);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            transition: all 0.3s ease;
        }
        .navbar-brand:hover {
            transform: translateY(-1px);
            color: var(--primary-dark) !important;
        }
        .nav-link {
            font-weight: 500;
            color: var(--text-secondary) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(99, 102, 241, 0.1);
            transform: translateY(-1px);
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1rem;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        main {
            padding: 2rem 0;
            min-height: calc(100vh - 80px);
        }
        .container { max-width: 1200px; }
        .card {
            background: var(--card-bg);
            border: none;
            border-radius: 18px;
            box-shadow: 0 2px 12px 0 rgba(30,41,59,0.07);
            transition: box-shadow 0.2s, transform 0.2s, background 0.3s;
            overflow: hidden;
        }
        body.dark-mode .card {
            background: var(--card-bg);
        }
        .card:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 6px 24px 0 rgba(30,41,59,0.12);
        }
        .card-header {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: background 0.3s;
        }
        .card-body { padding: 2rem; }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            box-shadow: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.3s, color 0.3s;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
        }
        body.dark-mode .form-control, body.dark-mode .form-select {
            background: #23262f;
            color: var(--text-primary);
            border-color: var(--border-color);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(99,102,241,0.08);
            outline: none;
        }
        .form-label {
            font-weight: 500;
            color: var(--text-secondary);
        }
        body.dark-mode .form-label {
            color: var(--text-secondary-dark);
        }
        .btn {
            font-weight: 500;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s;
            border: none;
            position: relative;
            overflow: hidden;
            outline: none;
        }
        .btn:focus {
            box-shadow: 0 0 0 2px var(--primary-color);
        }
        .btn-primary, .btn-success, .btn-warning, .btn-danger {
            box-shadow: 0 2px 8px 0 rgba(99,102,241,0.08);
        }
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus {
            background: var(--primary-color);
            color: white;
        }
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            box-shadow: 0 2px 8px 0 rgba(30,41,59,0.07);
            margin-bottom: 1.25rem;
            opacity: 0.97;
        }
        .alert-success { background: #e6f9f0; color: #15803d; }
        .alert-danger, .alert-error { background: #fbeaea; color: #b91c1c; }
        .alert-warning { background: #fff7e6; color: #b45309; }
        .alert-info { background: #e0f2fe; color: #0369a1; }
        .alert .btn-close {
            float: right;
            font-size: 1.2rem;
            color: #64748b;
            opacity: 0.7;
        }
        .alert .btn-close:focus {
            outline: 2px solid var(--primary-color);
        }
        /* Modern Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            box-shadow: var(--shadow-md);
            padding: 1.25rem 0;
            margin-bottom: 1.5rem;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            transition: all 0.3s ease;
        }
        .navbar-brand:hover {
            transform: translateY(-1px);
            color: var(--primary-dark) !important;
        }
        .nav-link {
            font-weight: 500;
            color: var(--text-secondary) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(99, 102, 241, 0.1);
            transform: translateY(-1px);
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1rem;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }
        /* Main Content */
        main {
            padding: 2rem 0;
            min-height: calc(100vh - 80px);
        }
        .container {
            max-width: 1200px;
        }
        /* Modern Cards */
        .card {
            background: #fff;
            border: none;
            border-radius: 18px;
            box-shadow: 0 2px 12px 0 rgba(30,41,59,0.07);
            transition: box-shadow 0.2s, transform 0.2s;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 6px 24px 0 rgba(30,41,59,0.12);
        }
        .card-header {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .card-body {
            padding: 2rem;
        }
        /* Enhanced Buttons */
        .btn {
            font-weight: 500;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s;
            border: none;
            position: relative;
            overflow: hidden;
            outline: none;
        }
        .btn:focus {
            box-shadow: 0 0 0 2px var(--primary-color);
        }
        .btn-primary, .btn-success, .btn-warning, .btn-danger {
            box-shadow: 0 2px 8px 0 rgba(99,102,241,0.08);
        }
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus {
            background: var(--primary-color);
            color: white;
        }
        /* Enhanced Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            box-shadow: 0 2px 8px 0 rgba(30,41,59,0.07);
            margin-bottom: 1.25rem;
            opacity: 0.97;
        }
        .alert .btn-close {
            float: right;
            font-size: 1.2rem;
            color: #64748b;
            opacity: 0.7;
        }
        .alert .btn-close:focus {
            outline: 2px solid var(--primary-color);
        }
        .alert-success { background: #e6f9f0; color: #15803d; }
        .alert-danger, .alert-error { background: #fbeaea; color: #b91c1c; }
        .alert-warning { background: #fff7e6; color: #b45309; }
        .alert-info { background: #e0f2fe; color: #0369a1; }
        /* Enhanced Badges */
        .badge {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
        }
        /* Enhanced Tables */
        .table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }
        .table thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            font-weight: 600;
            padding: 1rem;
        }
        .table tbody tr {
            transition: all 0.3s ease;
        }
        .table tbody tr:hover {
            background: rgba(99, 102, 241, 0.05);
            transform: scale(1.01);
        }
        .table tbody td {
            padding: 1rem;
            border-color: var(--border-color);
            vertical-align: middle;
        }
        /* Enhanced Forms */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            box-shadow: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(99,102,241,0.08);
            outline: none;
        }
        .form-label {
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }
        /* Enhanced List Groups */
        .list-group-item {
            border: none;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            transition: all 0.3s ease;
        }
        .list-group-item:hover {
            background: rgba(99, 102, 241, 0.05);
            transform: translateX(4px);
        }
        .list-group-item:last-child {
            border-bottom: none;
        }
        /* Enhanced Dropdown */
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .dropdown-item {
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .dropdown-item:hover {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }
        /* Enhanced Tooltips */
        .tooltip {
            font-size: 0.875rem;
        }
        .tooltip-inner {
            background: var(--dark-bg);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
        }
        /* Loading Animation */
        .loading-spinner {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* Fade In Animation */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
            
            .navbar-brand {
                font-size: 1.25rem;
            }
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--light-bg);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
        /* Table dark mode support (extended) */
        body.dark-mode .table,
        body.dark-mode .table-light,
        body.dark-mode .table-striped > tbody > tr,
        body.dark-mode .table-hover > tbody > tr {
            background-color: var(--card-bg) !important;
            color: var(--text-primary) !important;
        }
        body.dark-mode .table thead th,
        body.dark-mode .table-light th {
            background-color: #23262f !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        body.dark-mode .table-hover tbody tr:hover {
            background-color: rgba(99,102,241,0.08) !important;
            color: var(--text-primary) !important;
        }
        body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #23262f !important;
        }
        /* Muted and secondary text dark mode */
        body.dark-mode .text-muted, body.dark-mode .text-secondary {
            color: #a1a1aa !important;
        }
        /* Card header/footer dark mode */
        body.dark-mode .card-header, body.dark-mode .card-footer {
            background: #23262f !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        /* Pagination dark mode */
        body.dark-mode .pagination .page-link {
            background: #23262f !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        body.dark-mode .pagination .page-item.active .page-link {
            background: var(--primary-color) !important;
            color: #fff !important;
            border-color: var(--primary-color) !important;
        }
        /* Badges dark mode */
        body.dark-mode .badge.bg-secondary {
            background: #374151 !important;
            color: #f4f6fa !important;
        }
        body.dark-mode .badge.bg-primary {
            background: #6366f1 !important;
            color: #fff !important;
        }
        body.dark-mode .badge.bg-success {
            background: #10b981 !important;
            color: #fff !important;
        }
        body.dark-mode .badge.bg-danger {
            background: #ef4444 !important;
            color: #fff !important;
        }
        body.dark-mode .badge.bg-warning {
            background: #f59e0b !important;
            color: #fff !important;
        }
        body.dark-mode .badge.bg-info {
            background: #06b6d4 !important;
            color: #fff !important;
        }
        /* Alerts dark mode */
        body.dark-mode .alert-success { background: #1e3a2a !important; color: #22c55e !important; }
        body.dark-mode .alert-danger, body.dark-mode .alert-error { background: #3f1d1d !important; color: #ef4444 !important; }
        body.dark-mode .alert-warning { background: #4b3a1a !important; color: #f59e0b !important; }
        body.dark-mode .alert-info { background: #164e63 !important; color: #06b6d4 !important; }
        /* Buttons dark mode */
        body.dark-mode .btn-outline-primary {
            border-color: #6366f1 !important;
            color: #a5b4fc !important;
        }
        body.dark-mode .btn-outline-primary:hover, body.dark-mode .btn-outline-primary:focus {
            background: #6366f1 !important;
            color: #fff !important;
        }
        body.dark-mode .btn-outline-warning {
            border-color: #f59e0b !important;
            color: #fbbf24 !important;
        }
        body.dark-mode .btn-outline-warning:hover, body.dark-mode .btn-outline-warning:focus {
            background: #f59e0b !important;
            color: #fff !important;
        }
        body.dark-mode .btn-outline-danger {
            border-color: #ef4444 !important;
            color: #fca5a5 !important;
        }
        body.dark-mode .btn-outline-danger:hover, body.dark-mode .btn-outline-danger:focus {
            background: #ef4444 !important;
            color: #fff !important;
        }
        /* Dropdowns, modals, tooltips dark mode */
        body.dark-mode .dropdown-menu, body.dark-mode .modal-content, body.dark-mode .tooltip-inner {
            background: #23262f !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        /* Form controls dark mode */
        body.dark-mode .form-control, body.dark-mode .form-select {
            background: #23262f !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        body.dark-mode .form-control:focus, body.dark-mode .form-select:focus {
            background: #23262f !important;
            color: var(--text-primary) !important;
            border-color: var(--primary-color) !important;
        }
        /* Table borders and zebra striping dark mode */
        body.dark-mode .table td, body.dark-mode .table th {
            border-color: var(--border-color) !important;
        }
        body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #23262f !important;
        }
        /* Muted and secondary text dark mode */
        body.dark-mode .text-muted, body.dark-mode .text-secondary {
            color: #a1a1aa !important;
        }
        /* Universal dark mode for backgrounds */
        body.dark-mode .bg-white, body.dark-mode .bg-light, body.dark-mode .bg-secondary {
            background-color: var(--card-bg) !important;
            color: var(--text-primary) !important;
        }
        body.dark-mode .bg-primary { background-color: #6366f1 !important; color: #fff !important; }
        body.dark-mode .bg-success { background-color: #10b981 !important; color: #fff !important; }
        body.dark-mode .bg-danger { background-color: #ef4444 !important; color: #fff !important; }
        body.dark-mode .bg-warning { background-color: #f59e0b !important; color: #fff !important; }
        body.dark-mode .bg-info { background-color: #06b6d4 !important; color: #fff !important; }
        /* Universal dark mode for text */
        body.dark-mode .text-dark, body.dark-mode .text-black, body.dark-mode .text-white {
            color: var(--text-primary) !important;
        }
        body.dark-mode .text-primary { color: #a5b4fc !important; }
        body.dark-mode .text-success { color: #6ee7b7 !important; }
        body.dark-mode .text-danger { color: #fca5a5 !important; }
        body.dark-mode .text-warning { color: #fde68a !important; }
        body.dark-mode .text-info { color: #67e8f9 !important; }
        /* Universal dark mode for borders */
        body.dark-mode .border, body.dark-mode .border-top, body.dark-mode .border-bottom, body.dark-mode .border-start, body.dark-mode .border-end {
            border-color: var(--border-color) !important;
        }
        /* Universal dark mode for shadows */
        body.dark-mode .shadow, body.dark-mode .shadow-sm, body.dark-mode .shadow-lg {
            box-shadow: 0 2px 12px 0 rgba(30,41,59,0.25) !important;
        }
        /* Modal backdrop dark mode */
        body.dark-mode .modal-backdrop {
            background-color: #181a20 !important;
        }
        /* Custom containers and sections */
        body.dark-mode section, body.dark-mode .container, body.dark-mode .row, body.dark-mode .col, body.dark-mode .col-12, body.dark-mode .col-md-4, body.dark-mode .col-md-8, body.dark-mode .col-lg-3, body.dark-mode .col-lg-4, body.dark-mode .col-lg-8 {
            background-color: transparent !important;
            color: var(--text-primary) !important;
        }
        /* List group dark mode fix */
        body.dark-mode .list-group-item,
        body.dark-mode .list-group-item.bg-white,
        body.dark-mode .list-group-item.bg-light {
            background-color: var(--card-bg) !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        body.dark-mode .list-group-item.active {
            background-color: #23262f !important;
            color: var(--primary-color) !important;
        }
        /* Custom table header dark mode fix */
        body.dark-mode .table thead th,
        body.dark-mode .table-header-custom {
            background-color: #35386a !important;
            color: #f4f6fa !important;
            border-color: var(--border-color) !important;
        }
        /* Force custom table header and body backgrounds to dark in dark mode */
        body.dark-mode .table thead tr,
        body.dark-mode .table thead th,
        body.dark-mode .table-header-custom,
        body.dark-mode .table thead {
            background-color: #35386a !important;
            color: #f4f6fa !important;
            border-color: var(--border-color) !important;
        }
        body.dark-mode .table tbody tr,
        body.dark-mode .table tbody td {
            background-color: var(--card-bg) !important;
            color: var(--text-primary) !important;
        }
        /* User name and bold text dark mode fix */
        body.dark-mode .fw-bold,
        body.dark-mode .mb-2,
        body.dark-mode .profile-name,
        body.dark-mode .user-name {
            color: var(--text-primary) !important;
        }
        /* Dropdown menu and item dark mode fix */
        body.dark-mode .dropdown-menu {
            background-color: #23262f !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        body.dark-mode .dropdown-item {
            background-color: transparent !important;
            color: var(--text-primary) !important;
        }
        body.dark-mode .dropdown-item:hover,
        body.dark-mode .dropdown-item:focus,
        body.dark-mode .dropdown-item.active {
            background-color: #35386a !important;
            color: #fff !important;
        }
        .page-link svg,
        .page-link > span > svg,
        .page-link > svg {
            width: 10px !important;
            height: 10px !important;
            min-width: 10px !important;
            min-height: 10px !important;
            max-width: 10px !important;
            max-height: 10px !important;
            display: inline-block;
            vertical-align: middle;
        }
        .page-link svg[width], .page-link svg[height] {
            width: 10px !important;
            height: 10px !important;
        }
        .page-link {
            padding: 0.25rem 0.5rem !important;
        }
    </style>
</head>
<body>
    @auth
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="bi bi-{{ auth()->user()->isAdmin() ? 'people-fill' : 'speedometer2' }} me-2"></i>
                    {{ auth()->user()->isAdmin() ? 'User Management' : 'Dashboard' }}
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </li>
                        
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    <i class="bi bi-people me-1"></i>Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('activities') ? 'active' : '' }}" href="{{ route('activities') }}">
                                    <i class="bi bi-activity me-1"></i>Activity Logs
                                </a>
                            </li>
                        @endif
                    </ul>
                    
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person me-2"></i>Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <button id="darkModeToggle" class="btn btn-outline-primary ms-3" type="button" title="Toggle dark mode">
                        <i class="bi bi-moon"></i>
                    </button>
                </div>
            </div>
        </nav>
    @endauth

    <main class="fade-in">
        <div class="container">
            <!-- Enhanced notification system -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Success!</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Warning!</strong> {{ session('warning') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Info!</strong> {{ session('info') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dark mode toggle logic
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('darkModeToggle');
            const body = document.body;
            if (localStorage.getItem('darkMode') === 'true') {
                body.classList.add('dark-mode');
            }
            toggle && toggle.addEventListener('click', function() {
                body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', body.classList.contains('dark-mode'));
            });
        });
    </script>
</body>
</html> 