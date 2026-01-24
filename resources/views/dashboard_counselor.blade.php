@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
        :root {
            --primary-green: #1f7a2d;
            /* Homepage forest green */
            --primary-green-2: #13601f;
            /* darker stop */
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

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
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        body,
        .profile-card,
        .stats-card,
        .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0, 0, 0, 0.08);
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

        .custom-sidebar .sidebar-link.active,
        .custom-sidebar .sidebar-link:hover {
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

            .custom-sidebar .sidebar-logo {
                display: block;
            }

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

        .privacy-blur {
            filter: blur(5px);
            transition: filter 0.3s ease;
            cursor: pointer;
            user-select: none;
        }

        .privacy-blur:hover {
            filter: blur(0);
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
            max-width: none;
            width: 100%;
            margin: 0;
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
            background: rgba(255, 255, 255, 0.2);
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
            align-items: stretch;
            /* ensure children stretch to equal height */
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
            min-height: 140px;
            /* ensure consistent card height */
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
        .main-content-card,
        .quick-actions-sidebar {
            display: flex;
            flex-direction: column;
            min-height: 120px;
        }

        .main-content-card .card-body,
        .quick-actions-sidebar .card-body {
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
            background: linear-gradient(180deg, rgba(34, 139, 34, 0.06), rgba(34, 139, 34, 0.02));
            color: var(--forest-green);
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
        }

        .quick-actions-sidebar .card-body {
            padding: 1rem;
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-info,
        .btn-outline-warning {
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.15s ease;
            padding: 0.6rem 1rem;
            border-width: 1px;
            box-shadow: 0 6px 18px rgba(17, 94, 37, 0.06);
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

        .btn-outline-success:hover,
        .btn-outline-info:hover,
        .btn-outline-warning:hover {
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
        .sidebar-logo img {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .sidebar-link {
            padding-left: 1.1rem;
            padding-right: 1.1rem;
        }

        .sidebar-link i {
            font-size: 1.1rem;
        }

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

        .main-dashboard-content {
            flex: 1;
            background: var(--bg-light);
            padding: 1.5rem 1.5rem 2rem 1.5rem;
            overflow-y: auto;
            margin-left: 240px;
        }

        .main-dashboard-inner {
            padding: 1rem;
            max-width: 100%;
        }

        .risk-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .risk-high {
            background: var(--danger);
        }

        .risk-moderate {
            background: var(--warning);
        }

        .risk-low {
            background: var(--success);
        }

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

        /* Calendar Sidebar & Layout */
        .calendar-section-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 1.5rem;
            align-items: start;
        }

        @media (max-width: 1200px) {
            .calendar-section-grid {
                grid-template-columns: 1fr;
            }
        }

        .calendar-sidebar {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            height: 100%;
        }

        .legend-title,
        .agenda-title {
            font-weight: 700;
            color: var(--forest-green);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--gray-100);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .legend-list {
            list-style: none;
            padding: 0;
            margin-bottom: 2rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
            font-size: 0.9rem;
            color: var(--text-dark);
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .agenda-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .agenda-item {
            padding: 0.75rem;
            border-radius: 12px;
            background: var(--bg-light);
            border-left: 4px solid var(--forest-green);
            transition: transform 0.2s;
        }

        .agenda-item:hover {
            transform: translateX(5px);
        }

        .agenda-time {
            font-weight: 700;
            color: var(--forest-green);
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
        }

        .agenda-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .agenda-status {
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 999px;
            display: inline-block;
        }

        /* FullCalendar Customizations */
        .fc-event {
            border: none !important;
            padding: 2px 8px !important;
            border-radius: 6px !important;
            font-size: 0.85rem !important;
            font-weight: 500 !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
            transition: transform 0.1s, box-shadow 0.1s !important;
            cursor: pointer !important;
        }

        .fc-event:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
        }

        .fc-daygrid-event-dot {
            display: none !important;
            /* Hide the default dot since we use pill style */
        }

        .fc-v-event {
            /* background-color: var(--event-bg) !important; */
        }

        .fc-more-link {
            font-weight: 700 !important;
            color: var(--forest-green) !important;
            padding: 2px 5px !important;
        }

        /* Tooltip Styling */
        .calendar-tooltip {
            position: absolute;
            z-index: 9999;
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-100);
            width: 300px;
            pointer-events: none;
            display: none;
        }

        .tooltip-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--gray-100);
        }

        .tooltip-title {
            font-weight: 700;
            color: var(--forest-green);
            font-size: 0.95rem;
        }

        .tooltip-row {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
        }

        .tooltip-label {
            font-weight: 600;
            color: var(--text-light);
            min-width: 80px;
        }

        .tooltip-value {
            color: var(--text-dark);
        }

        .tooltip-risk {
            font-size: 0.75rem;
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
            font-weight: 600;
        }
    </style>

    <!-- Notification Bell Dropdown at Top Right -->
    <style>
        .notification-bell {
            background: white !important;
            border: none !important;
            outline: none !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            position: relative;
            transition: all 0.3s ease !important;
            width: 60px !important;
            height: 60px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            min-width: 60px !important;
        }

        .notification-bell:hover {
            background: var(--yellow-maize);
            box-shadow: 0 6px 20px rgba(255, 203, 5, 0.4);
            transform: translateY(-2px);
        }

        .notification-bell .bi-bell {
            color: var(--forest-green);
            font-size: 1.7rem;
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

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-10deg);
            }

            75% {
                transform: rotate(10deg);
            }
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
            width: 700px;
            max-width: 95vw;
            max-height: 500px;
            overflow-y: auto;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            border: none;
            padding: 0;
            margin-top: 0.75rem;
            background: white;
            overflow: hidden;
            z-index: 9999 !important;
            position: absolute !important;
            right: 0;
            top: 70px;
            list-style: none;
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

            .notification-item,
            .notification-empty {
                padding: 0.7rem 1rem;
            }
        }
    </style>
    @php
        $unreadCount = auth()->user()->unreadNotifications()->count();
        // Show ALL notifications (both read and unread) - most recent 10
        $recentNotifications = auth()->user()->notifications()->latest()->take(10)->get();
    @endphp
    <div class="dropdown me-3" style="position: fixed; top: 1rem; right: 1.5rem; z-index: 9999;">
        <button class="btn notification-bell position-relative p-0{{ $unreadCount > 0 ? ' pulse' : '' }}" type="button"
            id="notificationDropdown" onclick="toggleNotificationDropdown()">
            <i class="bi bi-bell"></i>
            @if($unreadCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge notification-bell-badge">
                    {{ $unreadCount }}
                </span>
            @endif
        </button>
        <ul class="notification-dropdown-menu" id="notificationMenu" style="display: none;">
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
                        @if(is_null($notification->read_at))
                            <span class="badge bg-primary ms-2" style="font-size: 0.7rem;">New</span>
                        @endif
                        <div class="text-muted small mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="notification-actions">
                        @if(isset($notification->data['url']))
                            <a href="{{ $notification->data['url'] }}" class="btn-view" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                        @elseif(isset($notification->data['appointment_id']))
                            <a href="{{ route('counselor.appointments.show', $notification->data['appointment_id']) }}"
                                class="btn-view" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                        @else
                            <a href="{{ route('counselor.appointments.index') }}" class="btn-view" title="View Appointments">
                                <i class="bi bi-eye"></i>
                            </a>
                        @endif
                        <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" class="d-inline"
                            style="margin: 0;">
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
        // Custom dr    opdown toggle function (Bootstrap dropdown wasn't wor                              king)
        function toggleNotificationDropdown() {
            const menu = document.getElementById('notificationMenu');
            if (menu) {
                if (menu.style.display === 'none' || menu.style.display === '') {
                    menu.style.display = 'block';
                    console.log('Dropdown opened');
                } else {
                    menu.style.display = 'none';
                    console.log('Dropdown closed');
                }
            } else {
                console.error('Notification menu not found!');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            const bell = document.getElementById('notificationDropdown');
            const menu = document.getElementById('notificationMenu');

            if (bell && menu && !bell.contains(event.target) && !menu.contains(event.target)) {
                menu.style.display = 'none';
            }
        });

        // Shake notification bell only once on page load if there are unread notifications
        document.addEventListener('DOMContentLoaded', function () {
            const notificationBell = document.getElementById('notificationDropdown');
            if (notificationBell && notificationBell.classList.contains('pulse')) {
                // Shake for 2 seconds then remove the pulse class
                setTimeout(function () {
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
            <div class="main-dashboard-content flex-grow-1" style="padding: 1rem;">
                <div class="welcome-card">
                    <div>
                        <div class="welcome-date">{{ now()->format('F j, Y') }}</div>
                        <div class="welcome-text">Welcome back, {{ auth()->user()->first_name ?? auth()->user()->name }}!
                        </div>
                        <div style="font-size: 0.9rem; margin-top: 0.5rem;">Always stay updated in your counselor portal
                        </div>
                    </div>
                    <div class="welcome-avatar">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    </div>
                </div>

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
                            <div class="stat-value">{{ $activeStudentsCount }}</div>
                            <div class="stat-label">Active Students</div>
                            <div class="stat-subtitle">Students in last 30 days</div>
                        </div>

                        <!-- High-Risk Cases -->
                        <div class="dashboard-stat-card">
                            <div class="stat-value">
                                <i class="bi bi-exclamation-triangle text-danger"></i>
                                {{ $highRiskCasesCount }}
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
                                <a href="{{ route('counselor.appointments.index') }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-calendar-event me-1"></i>View All Appointments
                                </a>
                                <a href="{{ route('counselor.session_notes.index') }}"
                                    class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-journal-text me-1"></i>Session Notes
                                </a>
                                <a href="{{ route('counselor.assessments.index') }}" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-clipboard-data me-1"></i>Student Assessments
                                </a>
                                <a href="{{ route('counselor.availability.index') }}"
                                    class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-clock me-1"></i>Set Availability
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Section -->
                <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
                <div class="calendar-section-grid">
                    <div class="main-content-card h-100 mb-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Appointment Calendar</h5>
                            <a href="{{ route('counselor.appointments.index') }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-list-ul me-1"></i>List View
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <div id='calendar' style="min-height: 600px; width: 100%;"></div>
                            <div id="calendarTooltip" class="calendar-tooltip"></div>
                        </div>
                    </div>

                    <div class="calendar-sidebar">
                        <div class="legend-title">
                            <i class="bi bi-info-circle"></i> Legend
                        </div>
                        <ul class="legend-list">
                            <li class="legend-item"><span class="legend-dot" style="background: #28a745;"></span> Approved
                            </li>
                            <li class="legend-item"><span class="legend-dot" style="background: #ffc107;"></span> Pending
                            </li>
                            <li class="legend-item"><span class="legend-dot" style="background: #1f7a2d;"></span> Completed
                            </li>
                            <li class="legend-item"><span class="legend-dot" style="background: #dc3545;"></span>
                                Declined/Cancelled</li>
                        </ul>

                        <div class="agenda-title">
                            <i class="bi bi-card-checklist"></i> Today's Agenda
                        </div>
                        <div class="agenda-list">
                            @forelse($todayAppointmentsList as $appt)
                                                <div class="agenda-item"
                                                    style="border-left-color: {{ 
                                                                                                                                                                                                                                                                                                                                            $appt->status === 'pending' ? '#ffc107' :
                                ($appt->status === 'completed' ? '#1f7a2d' :
                                    ($appt->status === 'cancelled' || $appt->status === 'declined' ? '#dc3545' : '#28a745')) 
                                                                                                                                                                                                                                                                                                                                        }}">
                                                    <div class="agenda-time">
                                                        {{ $appt->scheduled_at->format('h:i A') }}
                                                    </div>
                                                    <div class="agenda-name privacy-blur" title="Hover to reveal name">
                                                        {{ $appt->student->name }}
                                                    </div>
                                                    <div class="agenda-status"
                                                        style="background: {{ 
                                                                                                                                                                                                                                                                                                                                                $appt->status === 'pending' ? '#fff9e6' :
                                ($appt->status === 'completed' ? '#eef6ee' :
                                    ($appt->status === 'cancelled' || $appt->status === 'declined' ? '#fbeeee' : '#eef6ee')) 
                                                                                                                                                                                                                                                                                                                                            }}; color: {{ 
                                                                                                                                                                                                                                                                                                                                                $appt->status === 'pending' ? '#856404' :
                                ($appt->status === 'completed' ? '#1f7a2d' :
                                    ($appt->status === 'cancelled' || $appt->status === 'declined' ? '#721c24' : '#155724')) 
                                                                                                                                                                                                                                                                                                                                            }}">
                                                        {{ $appt->status === 'accepted' ? 'Approved' : ucfirst($appt->status) }}
                                                    </div>
                                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-calendar-check d-block mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                                    <p class="small mb-0">No sessions for today</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <script>
                    window.addEventListener('load', function () {
                        var calendarEl = document.getElementById('calendar');
                        var calendarTooltip = document.getElementById('calendarTooltip');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            themeSystem: 'bootstrap5',
                            height: 'auto',
                            contentHeight: 'auto',
                            slotMinTime: '08:00:00',
                            slotMaxTime: '18:00:00',
                            slotDuration: '00:30:00',
                            snapDuration: '00:15:00',
                            scrollTime: '08:00:00',
                            allDaySlot: false,
                            slotLabelFormat: {
                                hour: 'numeric',
                                minute: '2-digit',
                                meridiem: 'short',
                                hour12: true
                            },
                            eventTimeFormat: {
                                hour: 'numeric',
                                minute: '2-digit',
                                meridiem: 'short',
                                hour12: true
                            },
                            dayMaxEvents: 2, // Show +more after 2 events
                            navLinks: true,
                            selectable: true,
                            selectMirror: true,
                            windowResizeDelay: 0,
                            slotEventOverlap: false,
                            slotLabelInterval: '01:00:00',
                            dateClick: function (info) {
                                calendar.changeView('timeGridDay', info.dateStr);
                            },
                            eventContent: function (arg) {
                                const props = arg.event.extendedProps;
                                const timeDisplay = props.apptTime || arg.timeText;

                                            let container = document.createElement('div');
                                                container.style.display = 'flex';
                                                container.style.alignItems = 'center';
                                                container.style.gap = '8px';
                                                container.style.padding = '0 10px';
                                                container.style.overflow = 'hidden';
                                                container.style.width = '100%';
                                                container.style.minHeight = '100%';
                                                container.style.backgroundColor = arg.event.backgroundColor;
                                                container.style.borderRadius = '6px';
                                                container.style.boxSizing = 'border-box';

                                    let timeEl = document.createElement('span');
                                    timeEl.style.fontWeight = '700';
                                    timeEl.style.fontSize = '0.75rem';
                                    timeEl.style.whiteSpace = 'nowrap';
                                    timeEl.style.color = arg.event.textColor || '#ffffff';
                                    timeEl.innerText = timeDisplay;

                                    let iconEl = document.createElement('i');
                                    iconEl.className = 'bi bi-person-fill';
                                    iconEl.style.fontSize = '0.9rem';
                                    iconEl.style.flexShrink = '0';
                                    iconEl.style.color = arg.event.textColor || '#ffffff';

                                    container.appendChild(timeEl);
                                    container.appendChild(iconEl);
                                    return { domNodes: [container] };
                                },
                                events: [
                                    @foreach($allAppointments as $appt)
                                        @php
                                            $color = '#28a745'; // Default Green (Approved)
                                            $textColor = '#ffffff';
                                            if ($appt->status === 'pending') {
                                                $color = '#ffc107'; // Yellow
                                                $textColor = '#333333';
                                            } elseif ($appt->status === 'completed') {
                                                $color = '#1f7a2d'; // Forest Green
                                            } elseif ($appt->status === 'cancelled' || $appt->status === 'declined') {
                                                $color = '#dc3545'; // Red
                                            }

                                            $start = $appt->scheduled_at->toIso8601String();
                                            $end = $appt->scheduled_at->copy()->addMinutes(90)->toIso8601String();
                                         @endphp
                                        {
                                            title: '{{ addslashes($appt->student->name) }}',
                                            start: '{{ $start }}',
                                            end: '{{ $end }}',
                                            url: '{{ route("counselor.appointments.show", $appt->id) }}',
                                            backgroundColor: '{{ $color }}',
                                            borderColor: '{{ $color }}',
                                            textColor: '{{ $textColor }}',
                                            extendedProps: {
                                                status: '{{ $appt->status }}',
                                                studentName: '{{ addslashes($appt->student ? $appt->student->name : "Unknown") }}',
                                                purpose: '{{ addslashes($appt->purpose) }}',
                                                riskLevel: '{{ ($appt->student && $appt->student->assessments->first()) ? $appt->student->assessments->first()->risk_level : "low" }}',
                                                apptDate: '{{ $appt->scheduled_at->format('M d, Y') }}',
                                                 apptTime: '{{ $appt->scheduled_at->format('g:i a') }} - {{ $appt->scheduled_at->copy()->addMinutes(90)->format('g:i a') }}'
                                            }
                                        },
                                    @endforeach
                                                                                            ],
                                                                                            eventClick: function(info) {
                                                                                                if (info.event.url) {
                                                                                                    window.location.href = info.event.url;
                                                                                                    info.jsEvent.preventDefault(); // prevents browser from following link in current tab
                                                                                                }
                                                                                            },
                                                                                            eventMouseEnter: function(info) {
                                                                                                const props = info.event.extendedProps;
                                                                                                const rect = info.el.getBoundingClientRect();
                                                                                                const riskColor = props.riskLevel === 'high' || props.riskLevel === 'very-high' ? '#dc3545' : (props.riskLevel === 'moderate' ? '#ffc107' : '#28a745');

                                                                                                const statusColor = props.status === 'pending' ? '#ffc107' : (props.status === 'completed' ? '#1f7a2d' : (props.status === 'cancelled' || props.status === 'declined' ? '#dc3545' : '#28a745'));

                                                                            calendarTooltip.innerHTML = `
                                                                                                    <div class="tooltip-header">
                                                                                                        <span class="tooltip-title">Session Details</span>
                                                                                                        <span class="tooltip-risk" style="background: ${riskColor}20; color: ${riskColor}">
                                                                                                            ${props.riskLevel.replace('-', ' ').toUpperCase()} RISK
                                                                                                        </span>
                                                                                                    </div>
                                                                                                    <div class="tooltip-row">
                                                                                                        <span class="tooltip-label">Student:</span>
                                                                                                        <span class="tooltip-value privacy-blur" title="Hover to reveal">${props.studentName}</span>
                                                                                                    </div>
                                                                                                    <div class="tooltip-row">
                                                                                                        <span class="tooltip-label">Date:</span>
                                                                                                        <span class="tooltip-value">${props.apptDate}</span>
                                                                                                    </div>
                                                                                                    <div class="tooltip-row">
                                                                                                        <span class="tooltip-label">Time:</span>
                                                                                                        <span class="tooltip-value">${props.apptTime}</span>
                                                                                                    </div>
                                                                                                    <div class="tooltip-row">
                                                                                                        <span class="tooltip-label">Purpose:</span>
                                                                                                        <span class="tooltip-value">${props.purpose || 'Not specified'}</span>
                                                                                                    </div>
                                                                                                    <div class="tooltip-row">
                                                                                <span class="tooltip-label">Status:</span>
                                                                                <span class="tooltip-value" style="color: ${statusColor}; font-weight: 700;">${props.status === 'accepted' ? 'Approved' : props.status.charAt(0).toUpperCase() + props.status.slice(1)}</span>
                                                                            </div>                        </div>
                                                                                                `;

                                                                                                calendarTooltip.style.display = 'block';
                                                                                                const tooltipRect = calendarTooltip.getBoundingClientRect();

                                                                                                let top = rect.top + window.scrollY - tooltipRect.height - 10;
                                                                                                let left = rect.left + window.scrollX + (rect.width / 2) - (tooltipRect.width / 2);

                                                                                                if (top < window.scrollY) top = rect.bottom + window.scrollY + 10;
                                                                                                if (left < 0) left = 10;
                                                                                                if (left + tooltipRect.width > window.innerWidth) left = window.innerWidth - tooltipRect.width - 10;

                                                                                                calendarTooltip.style.top = top + 'px';
                                                                                                calendarTooltip.style.left = left + 'px';
                                                                                            },
                                                                                            eventMouseLeave: function() {
                                                                                                calendarTooltip.style.display = 'none';
                                                                                            },
                                                                                        });
                                                                                        calendar.render();

                                                                                        // Aggressive update for initial load rendering
                                                                                        setTimeout(function() {
                                                                                            calendar.updateSize();
                                                                                            window.dispatchEvent(new Event('resize'));
                                                                                        }, 500);

                                                                                        // Fallback for slower connections
                                                                                        setTimeout(function() {
                                                                                            calendar.updateSize();
                                                                                        }, 1500);
                                                                                    });
                                                                                </script>

                                                                                <style>
                                                                                    /* Custom Calendar Styling for Premium Feel */
                                                                                    .fc {
                                                                                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                                                                        width: 100% !important;
                                                                                        transform: translateZ(0);
                                                                                    }
                                                                                    .fc-view-harness {
                                                                                        width: 100% !important;
                                                                                    }
                                                                                    .fc-scrollgrid {
                                                                                        width: 100% !important;
                                                                                    }
                                                                                    .fc-col-header {
                                                                                        width: 100% !important;
                                                                                    }
                                                                                    .fc-daygrid-body {
                                                                                        width: 100% !important;
                                                                                    }
                                                                                    .fc-daygrid-body table {
                                                                                        width: 100% !important;
                                                                                    }
                                                                                    .fc-timegrid-body {
                                                                                        width: 100% !important;
                                                                                    }
                                                                                    .fc-timegrid-body table {
                                                                                        width: 100% !important;
                                                                                    }
                                                                                    .fc-timegrid-cols table {
                                                                                        width: 100% !important;
                                                                                    }
                                                                                    .fc-toolbar-title {
                                                                                        font-weight: 700;
                                                                                        color: var(--forest-green);
                                                                                    }
                                                                                    .fc-button-primary {
                                                                                        background-color: var(--forest-green) !important;
                                                                                        border-color: var(--forest-green) !important;
                                                                                        font-weight: 600;
                                                                                        text-transform: capitalize;
                                                                                    }
                                                                                    .fc-button-primary:hover {
                                                                                        background-color: var(--forest-green-light) !important;
                                                                                        border-color: var(--forest-green-light) !important;
                                                                                    }
                                                                                    .fc-button-active {
                                                                                        background-color: var(--primary-green-2) !important;
                                                                                        border-color: var(--primary-green-2) !important;
                                                                                    }
                                                                                    .fc-daygrid-day-number,
                                                                                    .fc-daygrid-day-top a {
                                                                                        color: var(--text-dark) !important;
                                                                                        font-weight: 600 !important;
                                                                                        text-decoration: none !important;
                                                                                        padding: 4px 8px !important;
                                                                                    }
                                                                                    .fc-daygrid-day:hover {
                                                                                        background-color: var(--bg-light);
                                                                                    }
                                                                                    .fc-col-header-cell-cushion {
                                                                                        color: var(--forest-green);
                                                                                        text-transform: uppercase;
                                                                                        font-size: 0.85rem;
                                                                                        letter-spacing: 0.05em;
                                                                                    }
                                                                                    .fc-event-main {
                                                                                        padding: 2px 4px;
                                                                                        font-weight: 500;
                                                                                        font-size: 0.85rem;
                                                                                    }
                                                                                </style>


                                                                                <div class="main-content-card">
                                                                                    <div class="card-header">
                                                                                        <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Priority Students</h5>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                    @if($priorityStudents->count())
                                                                                        @foreach($priorityStudents as $student)
                                                                                            @php 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $latestAssessment = $student->assessments->first();
                                                                                                $riskLevel = $latestAssessment ? $latestAssessment->risk_level : 'low';
                                                                                            @endphp
                                                                                            <div class="student-item {{ in_array($riskLevel, ['high', 'very-high']) ? 'high-risk' : ($riskLevel === 'moderate' ? 'moderate-risk' : '') }}">
                                                                                                <div class="d-flex justify-content-between align-items-center">
                                                                                                    <div class="d-flex align-items-center">
                                                                                                        <div class="me-3">
                                                                                                            <span class="risk-indicator risk-{{ $riskLevel }}"></span>
                                                                                                        </div>
                                                                                                        <div>
                                                                                                            <h6 class="mb-0 fw-semibold privacy-blur" style="color: var(--forest-green);" title="Hover to reveal name">
                                                                                                                {{ $student->name }}
                                                                                                            </h6>
                                                                                                            <small class="text-muted">
                                                                                                                Last assessment: {{ $latestAssessment ? $latestAssessment->created_at->diffForHumans() : 'No assessment' }}
                                                                                                            </small>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="d-flex align-items-center gap-2">
                                                                                                        <span class="badge-{{ in_array($riskLevel, ['high', 'very-high']) ? 'priority' : ($riskLevel === 'moderate' ? 'moderate' : 'normal') }}">
                                                                                                            {{ ucfirst(str_replace('-', ' ', $riskLevel)) }} Risk
                                                                                                        </span>
                                                                                                        <a href="{{ route('counselor.students.show', $student->id) }}" class="btn-view btn-small">
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
                                                                                        <h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>Recent Announcements</h5>
                                                                                        <a href="{{ route('announcements.index') }}" class="btn btn-light btn-sm">
                                                                                            <i class="bi bi-list-ul me-1"></i>View All
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        @if($recentAnnouncements->count())
                                                                                            @foreach($recentAnnouncements->take(3) as $announcement)
                                                                                                <div class="announcement-item mb-3 p-3" style="background: var(--gray-50); border-radius: 12px; border-left: 4px solid var(--forest-green);">
                                                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                                                        <h6 class="mb-0 fw-bold" style="color: var(--forest-green);">
                                                                                                            {{ $announcement->title }}
                                                                                                        </h6>
                                                                                                        <small class="text-muted">{{ $announcement->created_at->format('M d, Y') }}</small>
                                                                                                    </div>
                                                                                                    <div class="mb-0 text-muted small">
                                                                                                        {!! Str::limit(strip_tags($announcement->content), 150) !!}
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <div class="empty-state">
                                                                                                <i class="bi bi-megaphone"></i>
                                                                                                <p class="mb-0">No recent announcements.</p>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>

                                                                                <div class="main-content-card">
                                                                                    <div class="card-header">
                                                                                        <h5 class="mb-0"><i class="bi bi-star me-2"></i>Recent Session Feedback</h5>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                    @if($recentFeedback->count())
                                                                                        @foreach($recentFeedback as $feedback)
                                                                                            <div class="activity-item">
                                                                                                <div class="d-flex justify-content-between align-items-start">
                                                                                                    <div class="flex-grow-1">
                                                                                                        <div class="d-flex align-items-center mb-1">
                                                                                                            <h6 class="mb-0 fw-semibold me-2 privacy-blur" style="color: var(--forest-green);" title="Hover to reveal name">
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
                                                                </script>
@endsection