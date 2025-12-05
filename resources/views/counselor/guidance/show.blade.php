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

        /* Custom Styles for Guidance Module */
        .page-header {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            color: #fff;
        }

        .content-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: none;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .card-header-custom {
            background: #fff;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--light-green);
        }

        .table-custom th {
            background-color: var(--light-green);
            color: var(--primary-green);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem 1.5rem;
            border: none;
        }

        .table-custom td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            color: var(--text-dark);
        }

        .btn-secondary-custom {
            background: #fff;
            border: 1px solid #e0e0e0;
            color: var(--text-dark);
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary-custom:hover {
            background: #f8f9fa;
            border-color: #d6d8db;
            color: var(--primary-green);
        }

        .checkbox-custom {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 4px;
            border: 2px solid #ced4da;
            cursor: pointer;
        }

        .checkbox-custom:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }
    </style>

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
                    <div class="mb-6">
                        <a href="{{ route('counselor.guidance.index') }}" class="btn-secondary-custom">
                            <i class="bi bi-arrow-left"></i> Back to Student List
                        </a>
                    </div>

                    <!-- Student Profile Header -->
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-4">
                            <div class="bg-white/20 p-3 rounded-full">
                                <i class="bi bi-person-fill text-4xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold m-0">{{ $student->name }}</h2>
                                <p class="opacity-90 m-0 mt-1">{{ $student->email }} • ID: {{ $student->student_id ?? 'N/A' }}</p>
                                <div class="mt-2 text-sm opacity-80 grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1">
                                    <span><i class="bi bi-mortarboard-fill mr-1"></i> {{ $student->course ?? 'No Course' }}</span>
                                    <span><i class="bi bi-building-fill mr-1"></i> {{ $student->college ?? 'No College' }}</span>
                                    <span><i class="bi bi-gender-ambiguous mr-1"></i> {{ ucfirst($student->gender ?? 'N/A') }}</span>
                                    <span><i class="bi bi-telephone-fill mr-1"></i> {{ $student->contact_number ?? 'N/A' }}</span>
                                </div>

                                <!-- Seminar Badges -->
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @php
                                        $badges = [
                                            'IDREAMS' => ['color' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => 'bi-clouds-fill', 'year' => 1],
                                            '10C' => ['color' => 'bg-orange-100 text-orange-800 border-orange-200', 'icon' => 'bi-lightbulb-fill', 'year' => 2],
                                            'LEADS' => ['color' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'bi-people-fill', 'year' => 3],
                                            'IMAGE' => ['color' => 'bg-teal-100 text-teal-800 border-teal-200', 'icon' => 'bi-person-badge-fill', 'year' => 4],
                                        ];
                                    @endphp

                                    @foreach($badges as $seminarName => $style)
                                        @php
                                            $isAttended = isset($attendanceMatrix[$style['year']][$seminarName]);
                                        @endphp
                                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border {{ $isAttended ? $style['color'] : 'bg-gray-100 text-gray-400 border-gray-200' }} transition-all">
                                            @if($isAttended)
                                                <i class="bi {{ $style['icon'] }}"></i>
                                                <span class="font-bold text-xs tracking-wide">{{ $seminarName }}</span>
                                                <i class="bi bi-check-circle-fill text-xs ml-1 opacity-75"></i>
                                            @else
                                                <i class="bi bi-lock-fill text-xs"></i>
                                                <span class="font-medium text-xs tracking-wide">{{ $seminarName }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="text-right d-none d-md-block">
                            <div class="text-sm opacity-75 uppercase tracking-wider">Current Year</div>
                            <div class="text-3xl font-bold">{{ $student->year_level }}</div>
                        </div>
                    </div>



                    <div class="content-card">
                        <div class="card-header-custom">
                            <h3 class="text-lg font-bold text-gray-800 m-0">Seminar Attendance Matrix</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full table-custom">
                                <thead>
                                    <tr>
                                        <th>Year Level</th>
                                        @foreach(['IDREAMS', '10C', 'LEADS', 'IMAGE'] as $seminar)
                                            <th class="text-center">{{ $seminar }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($year = 1; $year <= 4; $year++)
                                        <tr>
                                            <td class="font-bold text-gray-700">
                                                @php
                                                    $suffixes = [1 => 'st', 2 => 'nd', 3 => 'rd', 4 => 'th'];
                                                @endphp
                                                {{ $year }}{{ $suffixes[$year] ?? 'th' }} Year
                                                @if($student->year_level == $year)
                                                    <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded-full">Current</span>
                                                @endif
                                            </td>
                                            @foreach(['IDREAMS', '10C', 'LEADS', 'IMAGE'] as $index => $seminar)
                                                <td class="text-center">
                                                    <div class="flex justify-center">
                                                        @if($year == $index + 1)
                                                            <input type="checkbox" 
                                                                   class="attendance-checkbox checkbox-custom form-check-input"
                                                                   data-year="{{ $year }}"
                                                                   data-seminar="{{ $seminar }}"
                                                                   {{ isset($attendanceMatrix[$year][$seminar]) ? 'checked' : '' }}>
                                                        @endif
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 bg-gray-50 text-sm text-gray-500 border-t border-gray-100">
                            <i class="bi bi-info-circle mr-1"></i> Changes are saved automatically when you click a checkbox.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Selection Modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-2xl">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title font-bold text-gray-800">Select Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-gray-600 text-sm mb-4">Please select the specific schedule the student attended for <span id="modalSeminarName" class="font-bold text-primary-green"></span>.</p>

                    <div id="scheduleOptions" class="space-y-2">
                        <!-- Options will be populated by JS -->
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light text-gray-600" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmScheduleBtn" class="btn-primary-custom">Confirm Attendance</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            }

            // Data from backend
            const seminars = @json($seminars);
            const attendanceMatrix = @json($attendanceMatrix);
            let currentCheckbox = null;
            let currentYear = null;
            let currentSeminarName = null;

            // Modal instance
            const scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));

            // Attendance Checkbox Logic
            const checkboxes = document.querySelectorAll('.attendance-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function(e) {
                    const year = this.dataset.year;
                    const seminarName = this.dataset.seminar;
                    const isChecking = this.checked;

                    if (isChecking) {
                        e.preventDefault(); // Prevent immediate checking
                        currentCheckbox = this;
                        currentYear = year;
                        currentSeminarName = seminarName;

                        // Find seminar details
                        const seminar = seminars.find(s => s.name === seminarName);

                        if (seminar && seminar.schedules && seminar.schedules.length > 0) {
                            // Populate modal
                            document.getElementById('modalSeminarName').textContent = seminarName;
                            const optionsContainer = document.getElementById('scheduleOptions');
                            optionsContainer.innerHTML = '';

                            seminar.schedules.forEach(schedule => {
                                const date = new Date(schedule.date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                                const div = document.createElement('div');
                                div.className = 'form-check p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors';
                                div.innerHTML = `
                                    <input class="form-check-input" type="radio" name="schedule_id" value="${schedule.id}" id="schedule_${schedule.id}">
                                    <label class="form-check-label w-full cursor-pointer ml-2" for="schedule_${schedule.id}">
                                        <div class="font-semibold text-gray-800">${date}</div>
                                        <div class="text-xs text-gray-500 flex gap-2 mt-1">
                                            <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded">${schedule.session_type}</span>
                                            <span>${schedule.location || 'No Location'}</span>
                                        </div>
                                    </label>
                                `;
                                optionsContainer.appendChild(div);

                                // Allow clicking the div to select radio
                                div.addEventListener('click', () => {
                                    div.querySelector('input').checked = true;
                                });
                            });

                            scheduleModal.show();
                        } else {
                            // No schedules found, just mark as attended (legacy behavior)
                            updateAttendance(year, seminarName, true, null);
                        }
                    } else {
                        // Unchecking - remove attendance
                        updateAttendance(year, seminarName, false, null);
                    }
                });
            });

            // Confirm Button Logic
            document.getElementById('confirmScheduleBtn').addEventListener('click', function() {
                const selectedSchedule = document.querySelector('input[name="schedule_id"]:checked');
                if (selectedSchedule) {
                    updateAttendance(currentYear, currentSeminarName, true, selectedSchedule.value);
                    scheduleModal.hide();
                } else {
                    alert('Please select a schedule.');
                }
            });

            function updateAttendance(year, seminarName, attended, scheduleId) {
                fetch(`{{ route('counselor.guidance.update', $student) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        year_level: year,
                        seminar_name: seminarName,
                        attended: attended,
                        seminar_schedule_id: scheduleId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (currentCheckbox) {
                            currentCheckbox.checked = attended;
                            // Optional: Update UI to show selected schedule details if needed
                            // For now, just the checkmark is enough as per request
                        } else {
                             // If called directly (no schedules case), find the checkbox
                             const cb = document.querySelector(`.attendance-checkbox[data-year="${year}"][data-seminar="${seminarName}"]`);
                             if(cb) cb.checked = attended;
                        }
                    } else {
                        alert('Failed to update attendance');
                        if (currentCheckbox) currentCheckbox.checked = !attended;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred');
                    if (currentCheckbox) currentCheckbox.checked = !attended;
                });
            }
        });
    </script>
@endsection
