@extends('layouts.app')

@section('content')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @php
        $studentName = $assessment->user->name ?? 'Student';
        $avatarUrl = $assessment->user->avatar_url ?? ('https://ui-avatars.com/api/?name=' . urlencode($studentName) . '&background=1f7a2d&color=fff&rounded=true&size=128');
        $createdAt = $assessment->created_at ? $assessment->created_at->format('M d, Y h:i A') : '';
        $studentId = $assessment->user->student_id ?? 'N/A';
        $course = $assessment->user->course ?? 'N/A';
        $yearLevel = $assessment->user->year_level ?? 'N/A';
    @endphp
    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="counselorSidebarToggle" class="d-md-none"
                style="position: fixed; top: 1rem; left: 1rem; z-index: 1100; background: var(--forest-green); color: #fff; border: none; border-radius: 8px; padding: 0.5rem 0.75rem;">
                <i class="bi bi-list"></i>
            </button>

            @include('counselor.sidebar')

            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <!-- Assessment Summary Title -->
                    <h2 class="h4 fw-bold text-dark mb-3">
                        <i class="bi bi-clipboard-data me-2"></i>Assessment Summary
                    </h2>

                    <!-- Green Hero Header with Student Profile -->
                    <div class="details-header mb-4">
                        <div class="d-flex flex-column flex-md-row align-items-center gap-4 w-100">
                            <!-- Avatar -->
                            <div class="position-relative">
                                <button id="privacyToggleBtn"
                                    class="btn btn-sm btn-light border position-absolute top-0 start-0 translate-middle-y"
                                    style="z-index: 10; border-radius: 50%; width: 35px; height: 35px; padding: 0;"
                                    title="Toggle Privacy">
                                    <i class="bi bi-eye-slash-fill" id="privacyIcon"></i>
                                </button>
                                <img src="{{ $avatarUrl }}"
                                    class="rounded-circle shadow-sm border border-3 border-white privacy-blur"
                                    id="avatarPrivacyContainer" width="90" height="90" alt="{{ $studentName }}">
                            </div>

                            <!-- Student Info -->
                            <div class="flex-grow-1 text-center text-md-start privacy-blur" id="studentPrivacyContainer">

                                <h1 class="h3 fw-bold text-white mb-2">{{ $studentName }}</h1>

                                <!-- Primary Contact Info -->
                                <div
                                    class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 text-white mb-2">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bi bi-card-heading"></i>
                                        <span class="fw-semibold">{{ $assessment->user->student_id ?? 'No ID' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bi bi-envelope"></i>
                                        <span>{{ $assessment->user->email }}</span>
                                    </div>
                                    @if($assessment->user->contact_number)
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="bi bi-telephone"></i>
                                            <span>{{ $assessment->user->contact_number }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Secondary Academic Info -->
                                <div
                                    class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 text-white-50 mb-3 small">
                                    @if($assessment->user->college)
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="bi bi-building"></i> {{ $assessment->user->college }}
                                        </div>
                                    @endif
                                    @if($assessment->user->course)
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="bi bi-mortarboard"></i> {{ $assessment->user->course }}
                                        </div>
                                    @endif
                                    @if($assessment->user->year_level)
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="bi bi-calendar3"></i> {{ $assessment->user->year_level }}
                                        </div>
                                    @endif
                                    @if($assessment->user->sex)
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="bi bi-person"></i> {{ ucfirst($assessment->user->sex) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Badges Row with Risk Level -->
                                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                                    <span class="badge bg-white text-success border"><i
                                            class="bi bi-file-earmark-text me-1"></i> {{ $assessment->type }}</span>
                                    <span class="badge bg-white text-secondary border"><i class="bi bi-clock me-1"></i>
                                        {{ $createdAt }}</span>
                                    @php
                                        $risk = strtolower($assessment->risk_level ?? 'low');
                                        $riskColors = [
                                            'low' => 'success',
                                            'low-moderate' => 'info',
                                            'moderate' => 'warning',
                                            'high' => 'danger',
                                            'very-high' => 'dark'
                                        ];
                                        $riskClass = $riskColors[$risk] ?? 'secondary';
                                        $riskLabel = ucwords(str_replace('-', ' ', $risk));
                                    @endphp
                                    <span class="badge bg-{{ $riskClass }} text-white border">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Risk: {{ $riskLabel }}
                                    </span>
                                    <a href="{{ route('counselor.assessments.export', $assessment->id) }}" target="_blank"
                                        class="btn btn-sm btn-light text-danger fw-bold"
                                        style="padding: 0.25rem 0.75rem; font-size: 0.85rem;">
                                        <i class="bi bi-file-pdf me-1"></i> Export PDF
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2 align-self-md-start ms-md-auto">
                            @if(request('from_appointment'))
                                <a href="{{ route('counselor.appointments.show', request('from_appointment')) }}"
                                    class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
                                    <i class="bi bi-arrow-left"></i> Back to Appointment
                                </a>
                            @else
                                <a href="{{ route('counselor.assessments.index') }}"
                                    class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
                                    <i class="bi bi-arrow-left"></i> Back to List
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Main Content --}}
                <div id="assessmentPrivacyContainer" class="privacy-blur">
                    @includeIf('counselor.assessments.partials.summary', ['assessment' => $assessment])
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Mobile Sidebar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function () {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function (e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }

            // Privacy Toggle Logic
            const privacyBtn = document.getElementById('privacyToggleBtn');
            const privacyIcon = document.getElementById('privacyIcon');
            const studentContainer = document.getElementById('studentPrivacyContainer');
            const avatarContainer = document.getElementById('avatarPrivacyContainer');
            const assessmentContainer = document.getElementById('assessmentPrivacyContainer');
            let isRevealed = false;

            if (privacyBtn) {
                privacyBtn.addEventListener('click', function () {
                    if (!isRevealed) {
                        Swal.fire({
                            title: 'Enter Passkey',
                            input: 'password',
                            inputLabel: 'To view sensitive details, please enter the passkey:',
                            inputPlaceholder: 'Enter passkey',
                            showCancelButton: true,
                            confirmButtonText: 'Reveal',
                            confirmButtonColor: '#1f7a2d',
                            cancelButtonColor: '#6c757d',
                            preConfirm: (passkey) => {
                                if (!passkey) {
                                    Swal.showValidationMessage('Please enter a passkey');
                                }
                                return passkey;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Default fallback passkey if not set in profile
                                const userPasskey = '{{ auth()->user()->passkey ?? "GCC2026" }}';

                                if (result.value === userPasskey) {
                                    isRevealed = true;
                                    studentContainer.classList.remove('privacy-blur');
                                    studentContainer.classList.add('privacy-revealed');
                                    avatarContainer.classList.remove('privacy-blur');
                                    avatarContainer.classList.add('privacy-revealed');
                                    assessmentContainer.classList.remove('privacy-blur');
                                    assessmentContainer.classList.add('privacy-revealed');
                                    privacyIcon.classList.remove('bi-eye-slash-fill');
                                    privacyIcon.classList.add('bi-eye-fill');
                                    privacyBtn.classList.remove('btn-light');
                                    privacyBtn.classList.add('btn-warning');

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Access Granted',
                                        text: 'Sensitive details revealed.',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Access Denied',
                                        text: 'Incorrect passkey.',
                                        confirmButtonColor: '#dc3545'
                                    });
                                }
                            }
                        });
                    } else {
                        // Re-hide
                        isRevealed = false;
                        studentContainer.classList.add('privacy-blur');
                        studentContainer.classList.remove('privacy-revealed');
                        avatarContainer.classList.add('privacy-blur');
                        avatarContainer.classList.remove('privacy-revealed');
                        assessmentContainer.classList.add('privacy-blur');
                        assessmentContainer.classList.remove('privacy-revealed');
                        privacyIcon.classList.add('bi-eye-slash-fill');
                        privacyIcon.classList.remove('bi-eye-fill');
                        privacyBtn.classList.add('btn-light');
                        privacyBtn.classList.remove('btn-warning');
                    }
                });
            }
        });
    </script>

    <style>
        /* Homepage theme variables */
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

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

        /* Apply page zoom */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        /* Privacy Blur */
        .privacy-blur {
            filter: blur(8px);
            user-select: none;
            pointer-events: none;
            transition: all 0.5s ease;
        }

        .privacy-revealed {
            filter: blur(0);
            user-select: auto;
            pointer-events: auto;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
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

        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 100%;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header Styles */
        .details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: var(--hero-gradient);
            padding: 1.5rem 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            color: #fff;
        }

        .header-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-meta {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        /* Card Styles */
        .content-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .content-card:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--forest-green-lighter);
        }

        /* Ensure nav tabs match */
        .nav-tabs .nav-link {
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
            color: var(--text-light);
            font-weight: 600;
        }

        .nav-tabs .nav-link.active {
            color: var(--forest-green);
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .main-dashboard-content {
                margin-left: 0;
                padding: 1rem;
            }

            .details-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

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
        }
    </style>

@endsection