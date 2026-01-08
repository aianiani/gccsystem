@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
        :root {
            --primary-green: #1f7a2d; /* Homepage forest green */
            --primary-green-2: #13601f; /* darker stop */
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0,0,0,0.08);

            /* Map dashboard-specific names to homepage palette for compatibility */
            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-600: var(--text-light);
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        /* Apply the same page zoom used on the homepage */
        .home-zoom {
            zoom: 0.85;
        }
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.85);
                transform-origin: top center;
            }
        }
        
        body, .profile-card, .stats-card, .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green) ;
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0,0,0,0.08);
            overflow-y: auto;
            padding-bottom: 1rem;
        }
        
        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2rem 1rem 1rem 1rem;
            border-bottom: 1px solid #4a7c59;
        }
        
        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0.5rem 0 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .custom-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
            position: relative;
        }
        
        .custom-sidebar .sidebar-link.active, .custom-sidebar .sidebar-link:hover {
            background: #4a7c59;
            color: #f4d03f;
        }
        
        .custom-sidebar .sidebar-link .bi {
            font-size: 1.1rem;
        }
        
        .custom-sidebar .sidebar-bottom {
            padding: 1rem 0.5rem;
            border-top: 1px solid #4a7c59;
        }
        
        .custom-sidebar .sidebar-link.logout {
            background: #dc3545;
            color: #fff;
            border-radius: 8px;
            text-align: center;
            padding: 0.75rem 1rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        
        .custom-sidebar .sidebar-link.logout:hover {
            background: #b52a37;
            color: #fff;
        }
        
        @media (max-width: 991.98px) {
            .custom-sidebar {
                width: 200px;
            }
            .main-dashboard-content {
                margin-left: 200px;
            }
        }
        @media (max-width: 767.98px) {
            /* Off-canvas behavior on mobile */
            .custom-sidebar {
                position: fixed;
                z-index: 1040;
                height: 100vh;
                left: 0;
                top: 0;
                width: 240px;
                transform: translateX(-100%);
                transition: transform 0.2s ease;
                flex-direction: column;
                padding: 0;
            }
            .custom-sidebar.show {
                transform: translateX(0);
            }
            .custom-sidebar .sidebar-logo { display: block; }
            .custom-sidebar .sidebar-nav {
                flex-direction: column;
                gap: 0.25rem;
                padding: 1rem 0.5rem 1rem 0.5rem;
            }
            .custom-sidebar .sidebar-link {
                justify-content: flex-start;
                padding: 0.6rem 0.75rem;
                font-size: 1rem;
            }
            .main-dashboard-content {
                margin-left: 0;
            }
            /* Toggle button */
            #counselorSidebarToggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--forest-green);
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 0.5rem 0.75rem;
                box-shadow: var(--shadow-sm);
            }
        }
        
        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        /* Constrain inner content and center it within the available area */
        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
        }

        .welcome-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 1.5rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            min-height: 100px;
        }
        
        .welcome-card .welcome-text {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }
        
        .welcome-card .welcome-date {
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .welcome-card .welcome-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dashboard-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: start;
        }
        
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 0.75rem;
            align-items: stretch; /* ensure children stretch to equal height */
        }
        
        .dashboard-stat-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem 1rem;
            text-align: center;
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 140px; /* ensure consistent card height */
        }
        
        .dashboard-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .dashboard-stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .dashboard-stat-card .stat-label {
            font-size: 1rem;
            color: var(--forest-green-light);
            margin-bottom: 0.25rem;
        }
        
        .dashboard-stat-card .stat-subtitle {
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-bottom: 0.75rem;
        }
        
        .dashboard-stat-card .stat-progress {
            height: 6px;
            background-color: var(--gray-100);
            border-radius: 3px;
            overflow: hidden;
        }
        
        .dashboard-stat-card .stat-progress-bar {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease-in-out;
        }
        
        .progress-success {
            background-color: var(--success);
        }
        
        .progress-warning {
            background-color: var(--warning);
        }
        
        .progress-info {
            background-color: var(--info);
        }
        
        .progress-danger {
            background-color: var(--danger);
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
        
        /* Make main content cards use flex so headers and bodies behave predictably */
        .main-content-card, .quick-actions-sidebar {
            display: flex;
            flex-direction: column;
            min-height: 120px;
        }
        .main-content-card .card-body, .quick-actions-sidebar .card-body {
            flex: 1 1 auto;
        }
        
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stats-card.priority {
            border-left: 4px solid var(--danger);
        }

        .stats-card.warning {
            border-left: 4px solid var(--warning);
        }

        .stats-card.success {
            border-left: 4px solid var(--success);
        }

        .stats-card.info {
            border-left: 4px solid var(--info);
        }

    .profile-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        height: fit-content;
    }

    .action-btn {
        background: var(--yellow-maize);
        color: var(--forest-green);
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .action-btn:hover {
        background: #f1c40f;
        color: var(--forest-green);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .action-btn.primary {
        background: var(--forest-green);
        color: white;
    }

    .action-btn.primary:hover {
        background: var(--forest-green-light);
        color: white;
    }

    .action-btn.danger {
        background: var(--danger);
        color: white;
    }

    .action-btn.danger:hover {
        background: #c82333;
        color: white;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        overflow: hidden;
    }

    .info-card-header {
        background: var(--forest-green-lighter);
        color: var(--forest-green);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-100);
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .info-card-body {
        padding: 1.5rem;
    }

    .student-item {
        background: var(--gray-50);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 1px solid var(--gray-100);
        transition: all 0.2s ease;
    }

    .student-item:hover {
        background: var(--yellow-maize-light);
        border-color: var(--yellow-maize);
    }

    .student-item.high-risk {
        border-left: 4px solid var(--danger);
        background: #fff5f5;
    }

    .student-item.moderate-risk {
        border-left: 4px solid var(--warning);
        background: #fffbf0;
    }

    .student-item:last-child {
        margin-bottom: 0;
    }

    .activity-item {
        background: var(--gray-50);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border-left: 4px solid var(--forest-green);
        transition: all 0.2s ease;
    }

    .activity-item:hover {
        background: var(--forest-green-lighter);
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

        .appointment-item {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            border: 1px solid var(--gray-100);
            transition: all 0.2s ease;
        }
        
        .appointment-item:hover {
            background: var(--forest-green-lighter);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }
        
        .appointment-item:last-child {
            margin-bottom: 0;
        }
        
        .announcement-item {
            background: var(--gray-50);
            border-radius: 10px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-left: 4px solid var(--forest-green);
            transition: all 0.2s ease;
        }
        
        .announcement-item:hover {
            background: var(--forest-green-lighter);
        }
        
        .announcement-item:last-child {
            margin-bottom: 0;
        }
        
        .message-preview {
            background: var(--gray-50);
            border-radius: 10px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border: 1px solid var(--gray-100);
            transition: all 0.2s ease;
        }
        
        .message-preview:hover {
            background: var(--forest-green-lighter);
        }
        
        .message-preview:last-child {
            margin-bottom: 0;
        }
        
        .quick-actions-sidebar {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
            height: fit-content;
        }
        
        .quick-actions-sidebar .card-header {
            background: linear-gradient(180deg, rgba(34,139,34,0.06), rgba(34,139,34,0.02));
            color: var(--forest-green);
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }
        
        .quick-actions-sidebar .card-body {
            padding: 1rem;
        }
        
        .btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.15s ease;
            padding: 0.6rem 1rem;
            border-width: 1px;
            box-shadow: 0 6px 18px rgba(17,94,37,0.06);
        }
        
        .btn-outline-primary {
            border-color: var(--forest-green);
            color: var(--forest-green);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--forest-green);
            border-color: var(--forest-green);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }
        
        .btn-outline-success:hover, .btn-outline-info:hover, .btn-outline-warning:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .appointment-item.urgent {
            border-left: 4px solid var(--danger);
        }

        .appointment-item.upcoming {
            border-left: 4px solid var(--success);
        }

    .message-item {
        background: var(--gray-50);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 1px solid var(--gray-100);
        transition: all 0.2s ease;
    }

    .message-item.unread {
        background: var(--yellow-maize-light);
        border-color: var(--yellow-maize);
    }

    .message-item:hover {
        background: var(--forest-green-lighter);
    }

    .badge-counselor {
        background: var(--forest-green);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .badge-priority {
        background: var(--danger);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-moderate {
        background: var(--warning);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-normal {
        background: var(--success);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .btn-view {
        background: var(--forest-green);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-view:hover {
        background: var(--forest-green-light);
        color: white;
    }

    .btn-edit {
        background: var(--yellow-maize);
        color: var(--forest-green);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .btn-edit:hover {
        background: #f1c40f;
        color: var(--forest-green);
    }

    .btn-small {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
    }

    .welcome-text {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        font-weight: 300;
    }

    .date-text {
        opacity: 0.9;
        font-size: 1rem;
    }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--gray-600);
            background: var(--gray-50);
            border-radius: 12px;
            border: 2px dashed var(--gray-100);
        }

        .empty-state i {
            font-size: 2rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
        }
        
        /* Small refinements for spacing */
        .sidebar-logo img { box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        .sidebar-link { padding-left: 1.1rem; padding-right: 1.1rem; }
        .sidebar-link i { font-size: 1.1rem; }
        
        @media (max-width: 991px) {
            .dashboard-layout {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .dashboard-stats {
                grid-template-columns: 1fr;
                gap: 1.2rem;
            }
            
            .welcome-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 2rem 1.5rem;
                text-align: center;
            }
            
            .main-dashboard-content {
                padding: 1.5rem 1rem;
            }
        }
        
        @media (max-width: 768px) {
            .welcome-card .welcome-text {
                font-size: 1.8rem;
            }
            
            .dashboard-stat-card {
                padding: 1.5rem 1rem;
            }
            
            .main-content-card .card-header,
            .main-content-card .card-body,
            .quick-actions .card-header,
            .quick-actions .card-body {
                padding: 1rem;
            }
        }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .notification-dot {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 16px;
        height: 16px;
        background: var(--danger);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        color: white;
        font-weight: bold;
    }

    .risk-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }

    .risk-high { background: var(--danger); }
    .risk-moderate { background: var(--warning); }
    .risk-low { background: var(--success); }

    @media (max-width: 768px) {
        .quick-actions {
            grid-template-columns: 1fr;
        }
        
        .dashboard-header {
            padding: 1.5rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Notification Bell Dropdown at Top Right -->
<style>
    .notification-bell {
        background: white;
        border: none;
        outline: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        position: relative;
        transition: all 0.3s ease;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .notification-bell:hover {
        background: var(--yellow-maize);
        box-shadow: 0 6px 20px rgba(255, 203, 5, 0.4);
        transform: translateY(-2px);
    }
    .notification-bell .bi-bell {
        color: var(--forest-green);
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }
    .notification-bell:hover .bi-bell {
        color: var(--forest-green);
        transform: scale(1.1);
    }
    .notification-bell.pulse {
        animation: bell-shake 0.5s ease-in-out infinite;
    }
    @keyframes bell-shake {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-10deg); }
        75% { transform: rotate(10deg); }
    }
    .notification-bell-badge {
        background: var(--danger);
        color: white;
        font-weight: bold;
        font-size: 0.75rem;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.4);
        padding: 0.2em 0.5em;
        border-radius: 999px;
        top: -4px;
        right: -4px;
    }
    .notification-dropdown-menu {
        min-width: 400px;
        max-width: 95vw;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        border: none;
        padding: 0;
        margin-top: 0.75rem;
        background: white;
        overflow: hidden;
    }
    .notification-dropdown-header {
        background: linear-gradient(135deg, var(--forest-green), var(--forest-green-light));
        color: white;
        font-weight: 700;
        padding: 1.25rem 1.5rem;
        font-size: 1.1rem;
        border-bottom: none;
        font-family: inherit;
    }
    .notification-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        font-size: 0.95rem;
        background: white;
        transition: background 0.2s;
        border-bottom: 1px solid #f0f0f0;
        font-family: inherit;
        position: relative;
    }
    .notification-item:last-child {
        border-bottom: none;
    }
    .notification-item:hover {
        background: #f8f9fa;
    }
    .notification-item .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .notification-item .notification-icon i {
        color: #1976d2;
        font-size: 1.1rem;
    }
    .notification-item .notification-content {
        flex: 1;
        line-height: 1.5;
        color: #333;
    }
    .notification-item .notification-content strong {
        color: var(--forest-green);
        font-weight: 600;
    }
    .notification-item .notification-actions {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.5rem !important;
        align-items: center !important;
    }
    .notification-item .btn-view {
        background: var(--forest-green);
        color: white;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: all 0.2s;
        padding: 0;
    }
    .notification-item .btn-view:hover {
        background: var(--forest-green-light);
        transform: scale(1.1);
    }
    .notification-item .btn-link {
        color: #dc3545;
        font-size: 1rem;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s;
        background: none;
        border: none;
        border-radius: 50%;
    }
    .notification-item .btn-link:hover {
        color: #c82333;
        background: rgba(220, 53, 69, 0.1);
        transform: scale(1.1);
    }
    .notification-empty {
        padding: 2.5rem 1.5rem;
        color: #999;
        text-align: center;
        font-size: 0.95rem;
        font-family: inherit;
    }
    .notification-empty i {
        font-size: 2.5rem;
        color: #ddd;
        margin-bottom: 0.75rem;
        display: block;
    }
    @media (max-width: 500px) {
        .notification-dropdown-menu {
            min-width: 90vw;
            padding: 0.25rem 0;
        }
        .notification-dropdown-header {
            font-size: 1rem;
            padding: 0.7rem 1rem;
        }
        .notification-item, .notification-empty {
            padding: 0.7rem 1rem;
        }
    }
</style>
@php
    $unreadCount = auth()->user()->unreadNotifications()->count();
    $recentNotifications = auth()->user()->unreadNotifications()->take(5)->get();
@endphp
<div class="dropdown me-3" style="position: fixed; top: 1.5rem; right: 2.5rem; z-index: 2000;">
    <button class="btn notification-bell position-relative p-0{{ $unreadCount > 0 ? ' pulse' : '' }}" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge notification-bell-badge">
                {{ $unreadCount }}
            </span>
        @endif
    </button>
    <ul class="dropdown-menu dropdown-menu-end notification-dropdown-menu" aria-labelledby="notificationDropdown">
        <li class="notification-dropdown-header">Notifications</li>
        @forelse($recentNotifications as $notification)
            <li class="notification-item">
                <div class="notification-icon">
                    @if(isset($notification->data['appointment_id']))
                        <i class="bi bi-calendar-check"></i>
                    @else
                        <i class="bi bi-info-circle"></i>
                    @endif
                </div>
                <div class="notification-content">
                    {{ $notification->data['message'] ?? 'You have a new notification.' }}
                </div>
                <div class="notification-actions">
                    @if(isset($notification->data['appointment_id']))
                        <a href="{{ route('counselor.appointments.show', $notification->data['appointment_id']) }}" class="btn-view" title="View Details">
                            <i class="bi bi-eye"></i>
                        </a>
                    @endif
                    <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link" title="Dismiss">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </form>
                </div>
            </li>
        @empty
            <li class="notification-empty">
                <i class="bi bi-bell-slash"></i>
                <div>No new notifications</div>
            </li>
        @endforelse
    </ul>
</div>

    </style>
    
    <script>
        // Shake notification bell only once on page load if there are unread notifications
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBell = document.getElementById('notificationDropdown');
            if (notificationBell && notificationBell.classList.contains('pulse')) {
                // Shake for 2 seconds then remove the pulse class
                setTimeout(function() {
                    notificationBell.classList.remove('pulse');
                }, 2000);
            }
        });
    </script>

    <div class="home-zoom">
    <div class="d-flex">
        <!-- Mobile Sidebar Toggle -->
        <button id="counselorSidebarToggle" class="d-md-none">
            <i class="bi bi-list"></i>
        </button>
        <!-- Sidebar -->
        @include('counselor.sidebar')
        
        <!-- Main Content -->
        <div class="main-dashboard-content flex-grow-1">
            <div class="main-dashboard-inner">
            <div class="welcome-card">
                <div>
                    <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
                    <div class="welcome-text">Welcome back, {{ auth()->user()->first_name ?? auth()->user()->name }}!</div>
                    <div style="font-size: 0.9rem; margin-top: 0.5rem;">Always stay updated in your counselor portal</div>
                </div>
                <div class="welcome-avatar">
                    <img src="{{ auth()->user()->avatar_url }}" 
                         alt="{{ auth()->user()->name }}" 
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
            </div>

            @php
                $counselorId = auth()->id();
                
                // Today's appointments
                $todayAppointments = \App\Models\Appointment::where('counselor_id', $counselorId)
                    ->whereDate('scheduled_at', today())
                    ->count();
                
                // Pending appointments
                $pendingAppointments = \App\Models\Appointment::where('counselor_id', $counselorId)
                    ->where('status', 'pending')
                    ->count();
                
                // Completed sessions this month
                $completedThisMonth = \App\Models\Appointment::where('counselor_id', $counselorId)
                    ->where('status', 'completed')
                    ->whereMonth('scheduled_at', now()->month)
                    ->whereYear('scheduled_at', now()->year)
                    ->count();
                
                // Active students (with appointments in last 30 days)
                $activeStudents = \App\Models\Appointment::where('counselor_id', $counselorId)
                    ->where('scheduled_at', '>=', now()->subDays(30))
                    ->distinct('student_id')
                    ->count('student_id');
                
                // High-risk cases
                $highRiskCases = \App\Models\User::where('role', 'student')
                    ->whereHas('assessments', function($q) {
                        $q->where('risk_level', 'high');
                    })
                    ->whereHas('appointments', function($q) use ($counselorId) {
                        $q->where('counselor_id', $counselorId);
                    })
                    ->count();
            @endphp
            
            <div class="dashboard-layout">
                <div class="dashboard-stats">
                    <!-- Today's Appointments -->
                    <div class="dashboard-stat-card">
                        <div class="stat-value">{{ $todayAppointments }}</div>
                        <div class="stat-label">Today's Appointments</div>
                        <div class="stat-subtitle">{{ $todayAppointments }} scheduled for today</div>
                    </div>
                    
                    <!-- Pending Appointments -->
                    <div class="dashboard-stat-card">
                        <div class="stat-value">{{ $pendingAppointments }}</div>
                        <div class="stat-label">Pending Appointments</div>
                        <div class="stat-subtitle">Awaiting your response</div>
                    </div>
                    
                    <!-- Completed Sessions This Month -->
                    <div class="dashboard-stat-card">
                        <div class="stat-value">{{ $completedThisMonth }}</div>
                        <div class="stat-label">Completed This Month</div>
                        <div class="stat-subtitle">Sessions completed</div>
                    </div>
                    
                    <!-- Active Students -->
                    <div class="dashboard-stat-card">
                        <div class="stat-value">{{ $activeStudents }}</div>
                        <div class="stat-label">Active Students</div>
                        <div class="stat-subtitle">Students in last 30 days</div>
                    </div>
                    
                    <!-- High-Risk Cases -->
                    <div class="dashboard-stat-card">
                        <div class="stat-value">
                            <i class="bi bi-exclamation-triangle text-danger"></i>
                            {{ $highRiskCases }}
                        </div>
                        <div class="stat-label">High-Risk Cases</div>
                        <div class="stat-subtitle">Requires immediate attention</div>
                    </div>
                </div>
                
                <!-- Quick Actions Section - Beside Stats -->
                <div class="quick-actions-sidebar">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('counselor.appointments.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-calendar-event me-1"></i>View All Appointments
                            </a>
                            <a href="{{ route('counselor.session_notes.index') }}" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-journal-text me-1"></i>Session Notes
                            </a>
                            <a href="{{ route('counselor.assessments.index') }}" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-clipboard-data me-1"></i>Student Assessments
                            </a>
                            <a href="{{ route('counselor.availability.index') }}" class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-clock me-1"></i>Set Availability
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>All Appointments</h5>
                    <a href="{{ route('counselor.appointments.index') }}" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="View all appointments">
                        <i class="bi bi-eye me-1"></i>View All
                    </a>
                </div>
                <div class="card-body">
                        @forelse($allAppointments as $appointment)
                            @php
                                $start = $appointment->scheduled_at;
                                $end = $start->copy()->addMinutes(30);
                                $autoCreated = false;
                                $sessionNumber = null;
                                $originSession = null;
                                if($appointment->notes && preg_match('/^(\d+)(st|nd|rd|th) Session - Auto created from session note #(\d+)/', $appointment->notes, $matches)) {
                                    $autoCreated = true;
                                    $sessionNumber = $matches[1];
                                    $originSession = $matches[3];
                                }
                                $statusColor = $appointment->status === 'completed' ? 'var(--success)' : ($appointment->status === 'pending' ? 'var(--warning)' : 'var(--forest-green)');
                            @endphp
                            <div class="appointment-item mb-3 p-3 d-flex align-items-center justify-content-between" style="background: #fff; border-radius: 12px; box-shadow: 0 1px 4px rgba(44,62,80,0.07); border-left: 6px solid {{ $statusColor }};">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $appointment->student->avatar_url }}" alt="Avatar" class="rounded-circle me-2" style="width: 48px; height: 48px; object-fit: cover; border: 2px solid var(--forest-green-light);">
                                    <div>
                                        <div class="fw-bold" style="color: var(--forest-green); font-size: 1.1rem;">{{ $appointment->student->name }}</div>
                                        <div class="text-muted small mb-1"><i class="bi bi-envelope me-1"></i>{{ $appointment->student->email }}</div>
                                        <div class="mb-1">
                                            <span class="badge {{ $appointment->status === 'completed' ? 'bg-success' : ($appointment->status === 'pending' ? 'bg-warning text-dark' : 'bg-primary') }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                            @if($autoCreated && $sessionNumber)
                                                <span class="badge bg-secondary ms-2">Session {{ $sessionNumber }}</span>
                                            @endif
                                        </div>
                                        <div class="mb-1">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            <span class="text-muted">{{ $start->format('F j, Y') }}</span>
                                            <i class="bi bi-clock ms-3 me-1"></i>
                                            <span class="text-muted">{{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}</span>
                                        </div>
                                        @if($autoCreated && $originSession)
                                            <div class="text-info small mb-1"><i class="bi bi-arrow-right-circle me-1"></i>Auto-created as next session from Session {{ $originSession }}</div>
                                        @endif
                                        @if($appointment->notes)
                                            <div class="text-muted small"><i class="bi bi-journal-text me-1"></i>{{ Str::limit(strip_tags($appointment->notes), 80) }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="{{ route('counselor.appointments.show', $appointment->id) }}" class="btn-view btn-small" title="View Appointment">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(!$appointment->sessionNotes()->exists())
                                        <a href="{{ route('counselor.session_notes.create', $appointment->id) }}" class="btn-edit btn-small" title="Add Session Note">
                                            <i class="bi bi-journal-plus"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-calendar-x"></i>
                            <p class="mb-0">No appointments found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <div class="main-content-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-megaphone me-2"></i>Announcements</h6>
                </div>
                <div class="card-body">
                    @forelse($recentAnnouncements as $announcement)
                        <div class="announcement-item">
                            <h6 class="mb-1 fw-bold small">{{ $announcement->title }}</h6>
                            <p class="mb-1 small text-muted">{{ Str::limit($announcement->content, 80) }}</p>
                            <small class="text-muted">{{ $announcement->created_at->format('F j, Y') }}</small>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-megaphone"></i>
                            <p class="mb-0">No announcements available.</p>
                        </div>
                    @endforelse
                    <div class="text-center mt-3">
                        <a href="{{ route('announcements.index') }}" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="View all announcements">
                            <i class="bi bi-eye me-1"></i>View All
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="main-content-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Priority Students</h5>
                </div>
                <div class="card-body">
                                @php 
                                    $priorityStudents = \App\Models\User::where('role', 'student')
                                        ->whereHas('assessments', function($q) {
                                            $q->where('risk_level', 'high')
                                              ->orWhere('risk_level', 'moderate');
                                        })
                                        ->whereHas('appointments', function($q) {
                                            $q->where('counselor_id', auth()->id()); 
                                        })
                                        ->whereHas('appointments', function($q) {
                                            $q->where('counselor_id', auth()->id());
                                            $q->whereColumn('users.id', 'appointments.student_id');
                                        })
                                        ->with(['assessments' => function($q) {
                                            $q->latest()->first();
                                        }])
                                        ->take(4)
                                        ->get(); 
                                @endphp
                                @if($priorityStudents->count())
                                    @foreach($priorityStudents as $student)
                                        @php 
                                            $latestAssessment = $student->assessments->first();
                                            $riskLevel = $latestAssessment ? $latestAssessment->risk_level : 'low';
                                        @endphp
                                        <div class="student-item {{ $riskLevel === 'high' ? 'high-risk' : ($riskLevel === 'moderate' ? 'moderate-risk' : '') }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <span class="risk-indicator risk-{{ $riskLevel }}"></span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold" style="color: var(--forest-green);">
                                                            {{ $student->name }}
                                                        </h6>
                                                        <small class="text-muted">
                                                            Last assessment: {{ $latestAssessment ? $latestAssessment->created_at->diffForHumans() : 'No assessment' }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge-{{ $riskLevel === 'high' ? 'priority' : ($riskLevel === 'moderate' ? 'moderate' : 'normal') }}">
                                                        {{ ucfirst($riskLevel) }} Risk
                                                    </span>
                                                    <a href="{{ route('users.show', $student->id) }}" class="btn-view btn-small">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <i class="bi bi-shield-check"></i>
                                        <p class="mb-0">No priority cases at this time.</p>
                                    </div>
                                @endif
                </div>
            </div>
            
            <div class="main-content-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>Recent Messages</h5>
                    <a href="{{ route('chat.selectStudent') }}" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Open chat with students">
                        <i class="bi bi-chat-dots me-1"></i>Open Chat
                    </a>
                </div>
                <div class="card-body">
                                @php 
                                    $recentMessages = \App\Models\Message::where('recipient_id', auth()->id())
                                        ->with('sender')
                                        ->orderBy('created_at', 'desc')
                                        ->take(4)
                                        ->get(); 
                                @endphp
                                @if($recentMessages->count())
                                    @foreach($recentMessages as $message)
                                        <div class="message-item {{ !$message->is_read ? 'unread' : '' }}">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <h6 class="mb-0 fw-semibold me-2" style="color: var(--forest-green);">
                                                            {{ $message->sender->name }}
                                                        </h6>
                                                        @if(!$message->is_read)
                                                            <span class="badge bg-danger">New</span>
                                                        @endif
                                                    </div>
                                                    <p class="mb-0 text-muted small">
                                                        {{ Str::limit($message->content, 80) }}
                                                    </p>
                                                </div>
                                                <div class="ms-3 text-end">
                                                    <small class="text-muted">
                                                        {{ $message->created_at->diffForHumans() }}
                                                    </small>
                                                    <div class="mt-1">
                                                        <a href="{{ route('chat.selectStudent') }}" class="btn-view btn-small">
                                                            <i class="bi bi-reply"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <i class="bi bi-chat-dots"></i>
                                        <p class="mb-0">No recent messages.</p>
                                    </div>
                                @endif
                </div>
            </div>
            
            <div class="main-content-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-star me-2"></i>Recent Session Feedback</h5>
                </div>
                <div class="card-body">
                        @php 
                            $recentFeedback = \App\Models\SessionFeedback::whereHas('appointment', function($q) {
                                    $q->where('counselor_id', auth()->id());
                                })
                                ->with(['appointment.student'])
                                ->orderBy('created_at', 'desc')
                                ->take(3)
                                ->get(); 
                        @endphp
                        
                        @if($recentFeedback->count())
                            @foreach($recentFeedback as $feedback)
                                <div class="activity-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <h6 class="mb-0 fw-semibold me-2" style="color: var(--forest-green);">
                                                    {{ $feedback->appointment->student->name }}
                                        </h6>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $feedback->rating ? '-fill' : '' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="mb-0 text-muted small">
                                            {{ Str::limit($feedback->comments, 60) }}
                                        </p>
                                    </div>
                                    <div class="ms-3 text-end">
                                        <small class="text-muted">
                                            {{ $feedback->created_at->diffForHumans() }}
                                    </small>
                                        <div class="mt-1">
                                            <a href="{{ route('counselor.feedback.show', $feedback->id) }}" class="btn-view btn-small">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <i class="bi bi-star"></i>
                                <p class="mb-0">No feedback received yet.</p>
                            </div>
                        @endif
                </div>
            </div>
            </div>
        </div>
    </div>
    
    </div>

    <!-- Quick Access Modal for Emergency Cases -->
    <div class="modal fade" id="emergencyModal" tabindex="-1" aria-labelledby="emergencyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="emergencyModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>Emergency Protocol
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h6><i class="bi bi-shield-exclamation me-2"></i>High-Risk Student Detected</h6>
                        <p class="mb-0">A student assessment indicates immediate attention may be required.</p>
                    </div>
                    <div class="d-grid gap-2">
                        {{-- <a href="{{ route('counselor.priority-cases.index') }}" class="btn btn-danger"> --}}
                        {{-- <i class="bi bi-eye me-2"></i>View Priority Cases --}}
                        {{-- </a> --}}
                        <a href="{{ route('counselor.appointments.create') }}" class="btn btn-warning">
                            <i class="bi bi-calendar-plus me-2"></i>Schedule Urgent Appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enable Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
            // Sidebar toggle for mobile
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    // Auto-check for high-risk cases every 30 seconds
    setInterval(function() {
        fetch('/counselor/check-priority-cases')
            .then(response => response.json())
            .then(data => {
                if (data.hasHighRiskCases && !localStorage.getItem('emergencyModalShown')) {
                    var emergencyModal = new bootstrap.Modal(document.getElementById('emergencyModal'));
                    emergencyModal.show();
                    localStorage.setItem('emergencyModalShown', 'true');
                    
                    // Reset flag after 1 hour
                    setTimeout(() => {
                        localStorage.removeItem('emergencyModalShown');
                    }, 3600000);
                }
            });
    }, 30000);

    // Real-time updates for message notifications
    setInterval(function() {
        fetch('/counselor/unread-messages-count')
            .then(response => response.json())
            .then(data => {
                const notificationDots = document.querySelectorAll('.notification-dot');
                notificationDots.forEach(dot => {
                    if (data.count > 0) {
                        dot.textContent = data.count;
                        dot.style.display = 'flex';
                    } else {
                        dot.style.display = 'none';
                    }
                });
            });
    }, 10000);
    </script>
    @endsection