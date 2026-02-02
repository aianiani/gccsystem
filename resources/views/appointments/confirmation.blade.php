@extends('layouts.app')

@section('content')
    <style>
        /* Dashboard theme variables - matching dashboard exactly */
        :root {
            --primary-green: #1f7a2d;
            /* Dashboard forest green */
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

        @media (max-width: 768px) {
            .home-zoom {
                zoom: 1 !important;
                transform: none !important;
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styles */
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
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2.5rem 1.5rem 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.05);
        }

        .custom-sidebar .sidebar-logo h3 {
            font-family: 'Outfit', sans-serif;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .custom-sidebar .sidebar-logo p {
            letter-spacing: 1px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem !important;
        }

        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1.25rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .custom-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            padding: 0.9rem 1.25rem;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            margin: 0.1rem 0;
        }

        .custom-sidebar .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .custom-sidebar .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: #f4d03f;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .custom-sidebar .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: -0.75rem;
            top: 15%;
            bottom: 15%;
            width: 5px;
            background: #f4d03f;
            border-radius: 0 6px 6px 0;
            box-shadow: 2px 0 15px rgba(244, 208, 63, 0.5);
        }

        .custom-sidebar .sidebar-link .bi {
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .custom-sidebar .sidebar-link.active .bi {
            transform: scale(1.1);
            filter: drop-shadow(0 0 5px rgba(244, 208, 63, 0.3));
        }

        .custom-sidebar .sidebar-bottom {
            padding: 1.5rem 1rem;
            background: rgba(0, 0, 0, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-sidebar .sidebar-link.logout {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            text-align: left;
            padding: 0.85rem 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 1.1rem;
        }

        .custom-sidebar .sidebar-link.logout:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.4);
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
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                flex-direction: column;
                padding: 0;
                box-shadow: 10px 0 30px rgba(0, 0, 0, 0.2);
            }

            .custom-sidebar.show {
                transform: translateX(0);
            }

            .main-dashboard-content {
                margin-left: 0;
                padding: 1rem 0.75rem;
            }

            /* Toggle button */
            #studentSidebarToggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--forest-green);
                color: #fff;
                border: none;
                border-radius: 10px;
                padding: 0.6rem 0.8rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                display: flex !important;
                align-items: center;
                justify-content: center;
            }
        }

        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 2rem 1.5rem;
            margin-left: 0;
            transition: margin-left 0.3s ease;
            display: flex;
            justify-content: center;
        }

        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
        }

        .confirmation-container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            padding: 2.5rem 1.5rem;
        }

        .confirmation-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--forest-green);
        }

        .confirmation-header .success-icon {
            font-size: 4rem;
            color: var(--success);
            margin-bottom: 1rem;
        }

        .confirmation-header h2 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.75rem;
        }

        .reference-number {
            background: var(--light-green);
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            text-align: center;
            border: 1px solid var(--gray-100);
        }

        .reference-number strong {
            color: var(--text-dark);
            font-size: 1.2rem;
        }

        .info-section {
            margin-bottom: 2rem;
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--gray-100);
            box-shadow: var(--shadow-sm);
        }

        .info-section h4 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--forest-green);
            font-size: 1.25rem;
        }

        .info-row {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--text-light);
            width: 150px;
            flex-shrink: 0;
        }

        .info-value {
            color: var(--text-dark);
            flex: 1;
            word-break: break-all;
        }

        @media (max-width: 576px) {
            .info-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .info-label {
                width: 100%;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-confirmation {
                width: 100%;
                justify-content: center;
            }
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-100);
        }

        .btn-confirmation {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-confirmation-primary {
            background: var(--forest-green);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .btn-confirmation-primary:hover {
            background: var(--forest-green-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--white);
        }

        .btn-confirmation-secondary {
            background: var(--gray-600);
            color: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .btn-confirmation-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--white);
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">


            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="confirmation-container">
                        <div class="confirmation-header">
                            <div class="success-icon">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h2>Appointment Booked Successfully!</h2>
                            <p class="text-muted">Your appointment request has been submitted and is pending counselor
                                approval.
                            </p>
                            <div class="reference-number">
                                <strong>Reference Number: {{ $appointment->reference_number }}</strong>
                            </div>
                        </div>

                        <!-- Appointment Details -->
                        <div class="info-section">
                            <h4><i class="bi bi-calendar-event me-2"></i>Appointment Details</h4>
                            <div class="info-row">
                                <div class="info-label">Date & Time:</div>
                                <div class="info-value">{{ $appointment->scheduled_at->format('F d, Y h:i A') }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Counselor:</div>
                                <div class="info-value">{{ $appointment->counselor->name }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Status:</div>
                                <div class="info-value">
                                    <span
                                        class="badge bg-warning text-dark">{{ $appointment->status === 'accepted' ? 'Approved' : ucfirst($appointment->status) }}</span>
                                </div>
                            </div>
                            @if($appointment->notes)
                                <div class="info-row">
                                    <div class="info-label">Notes:</div>
                                    <div class="info-value">{{ $appointment->notes }}</div>
                                </div>
                            @endif
                        </div>

                        <!-- Nature of Problem -->
                        <div class="info-section">
                            <h4><i class="bi bi-question-circle me-2"></i>Nature of Problem</h4>
                            <div class="info-row">
                                <div class="info-label">Category:</div>
                                <div class="info-value">{{ $appointment->nature_of_problem }}</div>
                            </div>
                            @if($appointment->nature_of_problem === 'Other' && $appointment->nature_of_problem_other)
                                <div class="info-row">
                                    <div class="info-label">Details:</div>
                                    <div class="info-value">{{ $appointment->nature_of_problem_other }}</div>
                                </div>
                            @endif
                        </div>

                        <!-- Guardian Information -->
                        <div class="info-section">
                            <h4><i class="bi bi-people me-2"></i>Guardian Information</h4>
                            <div class="info-row">
                                <div class="info-label">Guardian 1:</div>
                                <div class="info-value">
                                    <strong>{{ $appointment->guardian1_name }}</strong><br>
                                    <small class="text-muted">{{ $appointment->guardian1_relationship }} -
                                        {{ $appointment->guardian1_contact }}</small>
                                </div>
                            </div>
                            @if($appointment->guardian2_name)
                                <div class="info-row">
                                    <div class="info-label">Guardian 2:</div>
                                    <div class="info-value">
                                        <strong>{{ $appointment->guardian2_name }}</strong><br>
                                        <small class="text-muted">{{ $appointment->guardian2_relationship }} -
                                            {{ $appointment->guardian2_contact }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Student Information -->
                        <div class="info-section">
                            <h4><i class="bi bi-person-circle me-2"></i>Student Information</h4>
                            <div class="info-row">
                                <div class="info-label">Full Name:</div>
                                <div class="info-value">{{ $appointment->student->name }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">College, Course, Year:</div>
                                <div class="info-value">{{ $appointment->student->college ?? 'N/A' }},
                                    {{ $appointment->student->course ?? 'N/A' }},
                                    {{ $appointment->student->year_level ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Email:</div>
                                <div class="info-value">{{ $appointment->student->email }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Contact Number:</div>
                                <div class="info-value">{{ $appointment->student->contact_number ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <!-- DASS-42 Assessment Note -->
                        <div class="info-section">
                            <div class="info-row">
                                <div class="info-label">DASS-42 Assessment:</div>
                                <div class="info-value">
                                    <span class="badge bg-success">Completed</span>
                                    <small class="text-muted d-block mt-1">Your assessment has been submitted and will be
                                        reviewed by your counselor.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('appointments.downloadPdf', $appointment->id) }}"
                                class="btn-confirmation btn-confirmation-primary" target="_blank">
                                <i class="bi bi-download me-2"></i>Print / Download PDF
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn-confirmation btn-confirmation-secondary">
                                <i class="bi bi-house-door me-2"></i>Return to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {


                // Clear appointment form data from localStorage after successful booking
                localStorage.removeItem('appointment_form_data');
                console.log('Cleared appointment form data from localStorage');
            });
        </script>
@endsection