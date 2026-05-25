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

        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        .fc .fc-toolbar-title {
            color: var(--forest-green);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .fc .fc-button-primary {
            background: var(--forest-green);
            border: none;
            color: var(--yellow-maize);
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .fc .fc-button-primary:not(:disabled):hover {
            background: var(--forest-green-light);
            color: var(--yellow-maize);
        }

        .fc .fc-button-active,
        .fc .fc-button-primary:focus {
            background: var(--yellow-maize);
            color: var(--forest-green);
            border: none;
        }

        .fc .fc-daygrid-day.fc-day-today,
        .fc .fc-timegrid-col.fc-day-today {
            background: var(--yellow-maize);
            opacity: 0.15;
        }

        .fc .fc-event {
            background: var(--forest-green) !important;
            color: var(--white) !important;
            border-radius: 10px;
            border: none;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(44, 80, 22, 0.08);
            transition: box-shadow 0.2s;
        }

        .fc .fc-event:hover {
            box-shadow: 0 4px 16px rgba(44, 80, 22, 0.18);
            background: var(--forest-green-light) !important;
        }

        .fc .fc-col-header-cell-cushion,
        .fc .fc-timegrid-slot-label-cushion {
            color: var(--forest-green);
            font-weight: 600;
        }

        .fc .fc-scrollgrid {
            border-radius: 18px;
            background: var(--white);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-100);
        }

        .fc .fc-toolbar {
            margin-bottom: 1.5rem;
        }

        .availability-legend {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .legend-dot {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            background: var(--forest-green);
            display: inline-block;
            margin-right: 0.5rem;
        }

        .help-icon {
            color: var(--yellow-maize);
            font-size: 1.3rem;
            margin-left: 0.5rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .help-icon:hover {
            color: var(--forest-green-light);
        }



        body,
        .profile-card,
        .stats-card,
        .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        }

        .main-content-card .card-body {
            padding: 1.25rem;
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

        @media (max-width: 991.98px) {
            .fc .fc-toolbar-title {
                font-size: 1.1rem;
            }

            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {
            /* Reset sidebar margin on mobile */
            .main-dashboard-content {
                margin-left: 0 !important;
                padding: 0.75rem !important;
            }

            /* Disable home-zoom on small screens */
            .home-zoom {
                zoom: 1 !important;
                transform: none !important;
            }

            /* Add top padding so content doesn't hide behind the hamburger */
            .main-dashboard-inner {
                padding-top: 3.5rem;
            }

            /* Welcome card: stack vertically */
            .welcome-card {
                flex-direction: column;
                text-align: center;
                padding: 1.25rem 1rem;
            }

            .welcome-card .welcome-text {
                font-size: 1.3rem;
            }

            .welcome-card .welcome-avatar {
                width: 65px;
                height: 65px;
            }

            /* FullCalendar toolbar: stack rows so buttons don't overflow */
            .fc .fc-toolbar {
                flex-direction: column !important;
                gap: 0.5rem;
                align-items: stretch !important;
            }

            .fc .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
            }

            .fc .fc-toolbar-title {
                font-size: 1rem;
                text-align: center;
            }

            .fc .fc-button {
                padding: 0.4rem 0.6rem !important;
                font-size: 0.8rem !important;
                min-height: 38px;
                min-width: 38px;
            }

            /* Make the calendar scroll horizontally if needed */
            #calendar {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Stack action buttons vertically on mobile for easy tapping */
            .mt-4.text-end {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .mt-4.text-end .btn {
                width: 100%;
                margin: 0 !important;
                padding: 0.85rem 1rem !important;
                font-size: 1rem;
            }

            /* Ensure modals are tappable on mobile */
            .modal-dialog {
                margin: 0.75rem;
            }

            .modal-footer .btn {
                min-height: 44px;
                min-width: 44px;
            }

            /* Make table scroll on mobile */
            .table-responsive {
                -webkit-overflow-scrolling: touch;
            }

            /* Ensure card elements don't overflow */
            .main-content-card .card-body {
                padding: 0.75rem !important;
            }

            .main-content-card .card-header {
                padding: 0.75rem 1rem !important;
            }

            .main-content-card .card-header h5 {
                font-size: 1rem;
            }

            .availability-legend {
                flex-wrap: wrap;
                font-size: 0.85rem;
            }
        }

        
    </style>

    <div>
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            
            <!-- Sidebar -->
            @include('counselor.sidebar')

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="welcome-card" style="padding: 1rem 1.25rem; min-height: auto; border-radius: 12px;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; flex: 1; min-width: 0;">
                            <i class="bi bi-calendar2-week" style="font-size: 1.4rem; color: var(--yellow-maize); flex-shrink: 0;"></i>
                            <div style="min-width: 0;">
                                <div style="font-size: 1.1rem; font-weight: 700; line-height: 1.2;">My Availability</div>
                                <div style="font-size: 0.8rem; opacity: 0.75;">{{ now()->format('F j, Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="main-content-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-calendar2-week me-2"></i>Availability Calendar</h5>
                            <div class="availability-legend">
                                <span class="legend-dot"></span>
                                <span style="color: var(--forest-green); font-weight: 500;">Available Slot</span>
                                <span class="help-icon" tabindex="0" data-bs-toggle="tooltip"
                                    title="Click and drag on the calendar to add available slots. Click an event to edit or delete. Use the Save button to store your availability.">
                                    <i class="bi bi-question-circle-fill"></i>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                            <div class="mt-4 text-end">
                                <button id="resetAvailabilityBtn" class="btn btn-outline-danger px-4 py-2 me-2"
                                    style="font-weight:600; border-radius: 12px;">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                                </button>
                                <button id="saveAvailabilityBtn" class="btn px-5 py-2"
                                    style="background: var(--forest-green); color: var(--yellow-maize); font-weight:600; border-radius: 12px; box-shadow: 0 2px 8px rgba(44,80,22,0.08);">
                                    <i class="bi bi-save me-2"></i>Save Availability
                                </button>
                            </div>
                            <div id="availabilityListSection" class="mt-5">
                                <h4 class="mb-3" style="color: var(--forest-green); font-weight: 700;"><i
                                        class="bi bi-list-check me-2"></i>Current Availability List</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="availabilityListTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Label</th>
                                                <th>Start</th>
                                                <th>End</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- Edit Event Modal -->
    <style>
        #editEventModal .modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        #editEventModal .modal-header {
            background: linear-gradient(135deg, var(--forest-green) 0%, #13601f 100%);
            border: none;
            padding: 2rem 1.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            position: relative;
        }

        #editEventModal .modal-header .modal-icon {
            width: 54px;
            height: 54px;
            background: rgba(255, 203, 5, 0.15);
            border: 2px solid rgba(255, 203, 5, 0.3);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--yellow-maize);
            margin-bottom: 0.25rem;
        }

        #editEventModal .modal-title {
            color: #fff;
            font-weight: 700;
            font-size: 1.35rem;
            margin: 0;
            letter-spacing: -0.5px;
        }

        #editEventModal .modal-header .btn-close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.2s;
            z-index: 10;
        }

        #editEventModal .modal-header .btn-close-modal:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }

        #editEventModal .modal-body {
            padding: 2rem;
        }

        #editEventModal .form-label {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--forest-green);
            margin-bottom: 0.6rem;
            display: block;
        }

        #editEventModal .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s;
            height: 48px; /* Fixed height for alignment */
            background-color: #f8fafc;
            color: var(--text-dark);
            font-weight: 500;
        }

        #editEventModal .form-control:focus {
            background-color: #fff;
            border-color: var(--forest-green);
            box-shadow: 0 0 0 4px rgba(31, 122, 45, 0.1);
            outline: none;
        }

        #editEventModal .time-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.5rem;
            margin-top: 1.25rem;
            width: 100%;
        }

        #editEventModal .modal-footer {
            border-top: 1px solid #f1f5f9;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            background: #f8fafc;
        }

        #editEventModal .btn-delete-slot {
            background: #fff;
            border: 1.5px solid #fee2e2;
            color: #ef4444;
            border-radius: 12px;
            padding: 0.5rem 1.25rem;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-height: 46px;
        }

        #editEventModal .btn-delete-slot:hover {
            background: #fef2f2;
            border-color: #ef4444;
            transform: translateY(-1px);
        }

        #editEventModal .footer-actions {
            display: flex;
            gap: 0.75rem;
            flex: 1;
            justify-content: flex-end;
        }

        #editEventModal .btn-cancel-slot {
            background: #e2e8f0;
            border: none;
            color: #475569;
            border-radius: 12px;
            padding: 0.5rem 1.5rem;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s;
            min-height: 46px;
        }

        #editEventModal .btn-cancel-slot:hover {
            background: #cbd5e1;
            color: #1e293b;
        }

        #editEventModal .btn-update-slot {
            background: var(--forest-green);
            border: none;
            color: #fff;
            border-radius: 12px;
            padding: 0.5rem 1.75rem;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-height: 46px;
            box-shadow: 0 4px 12px rgba(31, 122, 45, 0.2);
        }

        #editEventModal .btn-update-slot:hover {
            background: #13601f;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(31, 122, 45, 0.3);
        }

        @media (max-width: 767.98px) {
            #editEventModal .modal-dialog {
                margin: 1rem;
            }

            #editEventModal .time-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            #editEventModal .modal-footer {
                flex-direction: column;
                padding: 1.25rem;
            }

            #editEventModal .footer-actions {
                width: 100%;
            }

            #editEventModal .footer-actions .btn-cancel-slot,
            #editEventModal .footer-actions .btn-update-slot {
                flex: 1;
            }

            #editEventModal .btn-delete-slot {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                    <div class="modal-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <h5 class="modal-title" id="editEventModalLabel">Edit Availability</h5>
                </div>
                <div class="modal-body">
                    <form id="editEventForm">
                        <div class="mb-3">
                            <label for="editEventTitle" class="form-label">Label</label>
                            <input type="text" class="form-control" id="editEventTitle" placeholder="e.g. Available, Office Hours">
                        </div>
                        <div class="time-row">
                            <div>
                                <label for="editEventStart" class="form-label">Start</label>
                                <input type="datetime-local" class="form-control" id="editEventStart">
                            </div>
                            <div>
                                <label for="editEventEnd" class="form-label">End</label>
                                <input type="datetime-local" class="form-control" id="editEventEnd">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-delete-slot" id="deleteEventBtn">
                        <i class="bi bi-trash3 me-1"></i>Delete
                    </button>
                    <div class="footer-actions">
                        <button type="button" class="btn-cancel-slot" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn-update-slot" id="updateEventBtn">
                            <i class="bi bi-check2 me-1"></i>Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FullCalendar CSS/JS -->
    <link href="{{ asset('vendor/fullcalendar/index.global.min.css') }}" rel="stylesheet">
    <script src="{{ asset('vendor/fullcalendar/index.global.min.js') }}"></script>
    <!-- SweetAlert2 CSS/JS -->
    <link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        let calendar;
        let currentEvent = null;
        // Helper to format date as 'YYYY-MM-DDTHH:MM' in local time
        function toLocalDatetimeString(date) {
            if (!date) return '';
            const pad = n => n.toString().padStart(2, '0');
            return date.getFullYear() + '-' +
                pad(date.getMonth() + 1) + '-' +
                pad(date.getDate()) + 'T' +
                pad(date.getHours()) + ':' +
                pad(date.getMinutes());
        }
        // Helper to format ISO string to readable local date/time
        function formatDateTime(iso) {
            if (!iso) return '';
            const d = new Date(iso);
            return d.toLocaleString([], { year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true });
        }
        // Helper to render the availability list from backend data
        function renderAvailabilityList(data) {
            const section = document.getElementById('availabilityListSection');
            const tbody = document.querySelector('#availabilityListTable tbody');
            tbody.innerHTML = '';
            if (data.length > 0) {
                data.forEach((ev) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td>${ev.title}</td><td>${formatDateTime(ev.start)}</td><td>${formatDateTime(ev.end)}</td><td><button class='btn btn-sm btn-outline-success edit-list-btn' data-id='${ev.id}' title='Edit'><i class='bi bi-pencil-square'></i></button></td>`;
                    tbody.appendChild(tr);
                });
            } else {
                const tr = document.createElement('tr');
                tr.innerHTML = `<td colspan='4' class='text-center text-muted'>No availabilities set yet.</td>`;
                tbody.appendChild(tr);
            }
            section.style.display = '';
        }
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var isMobile = window.innerWidth < 768;
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: isMobile ? 'timeGridDay' : 'timeGridWeek',
                height: 'auto',
                expandRows: true, // Ensure rows take up full height
                headerToolbar: isMobile ? {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridDay,listWeek'
                } : {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                longPressDelay: 0,
                selectLongPressDelay: 0,
                eventLongPressDelay: 0,
                selectable: true,
                editable: true,
                selectMirror: true,
                nowIndicator: true,
                allDaySlot: false,
                slotDuration: '01:00:00',
                snapDuration: '01:00:00',
                defaultTimedEventDuration: '01:00:00',
                slotMinTime: '08:00:00',
                slotMaxTime: '18:00:00',
                slotLabelFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    omitZeroMinute: false,
                    meridiem: 'short',
                    hour12: true
                },
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short',
                    hour12: true
                },
                eventColor: '#2d5016',
                select: function (info) {
                    calendar.addEvent({
                        title: 'Available',
                        start: info.start,
                        end: info.end,
                        allDay: info.allDay,
                        color: '#2d5016'
                    });
                    calendar.unselect();
                },
                eventClick: function (info) {
                    currentEvent = info.event;
                    // Fill modal fields with local time
                    document.getElementById('editEventTitle').value = currentEvent.title;
                    document.getElementById('editEventStart').value = toLocalDatetimeString(currentEvent.start);
                    document.getElementById('editEventEnd').value = toLocalDatetimeString(currentEvent.end);
                    var modal = new bootstrap.Modal(document.getElementById('editEventModal'));
                    modal.show();
                },
                events: [], // Will be loaded via AJAX
            });
            calendar.render();
            // On page load, fetch and render both calendar and list
            fetch('/counselor/availabilities')
                .then(res => res.json())
                .then(data => {
                    data.forEach(ev => {
                        calendar.addEvent({
                            id: ev.id,
                            title: ev.title,
                            start: ev.start ? new Date(ev.start) : null,
                            end: ev.end ? new Date(ev.end) : null,
                            color: '#2d5016'
                        });
                    });
                    renderAvailabilityList(data);
                });
            // Enable Bootstrap tooltips
            if (window.bootstrap) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
            document.getElementById('saveAvailabilityBtn').addEventListener('click', function () {
                const events = calendar.getEvents().map(ev => ({
                    title: ev.title,
                    start: ev.start.toISOString(),
                    end: ev.end ? ev.end.toISOString() : null,
                    allDay: ev.allDay
                }));
                // Show the list below the calendar
                const section = document.getElementById('availabilityListSection');
                const tbody = document.querySelector('#availabilityListTable tbody');
                tbody.innerHTML = '';
                if (events.length > 0) {
                    events.forEach((ev, idx) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `<td>${ev.title}</td><td>${formatDateTime(ev.start)}</td><td>${formatDateTime(ev.end)}</td><td><button class='btn btn-sm btn-outline-success edit-list-btn' data-id='${ev.id}' title='Edit'><i class='bi bi-pencil-square'></i></button></td>`;
                        tbody.appendChild(tr);
                    });
                    section.style.display = '';
                } else {
                    section.style.display = 'none';
                }
                // Robust CSRF token fetch
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;
                if (!csrfToken) {
                    Swal.fire({
                        icon: 'error',
                        title: 'CSRF Token Missing',
                        text: 'Could not find CSRF token. Please refresh the page or contact support.',
                        confirmButtonColor: '#2d5016',
                        background: '#fafcf8',
                        color: '#2d5016',
                    });
                    return;
                }
                // Save to backend
                fetch('/counselor/availabilities', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ availabilities: events })
                })
                    .then(async res => {
                        if (!res.ok) {
                            let msg = 'Failed to save availability!';
                            if (res.status === 419) msg = 'Session expired or CSRF error. Please refresh and try again.';
                            const data = await res.json().catch(() => ({}));
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || msg,
                                confirmButtonColor: '#2d5016',
                                background: '#fafcf8',
                                color: '#2d5016',
                            });
                            return;
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data && data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Availability Saved!',
                                text: 'Your availability schedule has been updated.',
                                confirmButtonColor: '#2d5016',
                                background: '#fafcf8',
                                color: '#2d5016',
                                timer: 1800,
                                showConfirmButton: false
                            });
                            // Reload events from backend
                            fetch('/counselor/availabilities')
                                .then(res => res.json())
                                .then(data => {
                                    console.log('Reloaded availability data:', data);

                                    // Clear existing events first
                                    calendar.getEvents().forEach(ev => ev.remove());

                                    // Add events from backend
                                    data.forEach(ev => {
                                        console.log('Adding event:', ev);
                                        calendar.addEvent({
                                            id: ev.id,
                                            title: ev.title,
                                            start: ev.start ? new Date(ev.start) : null,
                                            end: ev.end ? new Date(ev.end) : null,
                                            color: '#2d5016'
                                        });
                                    });
                                    renderAvailabilityList(data);
                                })
                                .catch(error => {
                                    console.error('Error reloading events:', error);
                                    showToast('Error reloading events', 'error');
                                });
                        } else if (data) {
                            showToast('Failed to save availability!', 'error');
                        }
                    })
                    .catch(() => showToast('Failed to save availability!', 'error'));
            });
            document.getElementById('resetAvailabilityBtn').addEventListener('click', function () {
                Swal.fire({
                    title: 'Reset All Availability?',
                    text: 'This will remove all your availability slots permanently.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, reset',
                    background: '#fafcf8',
                    color: '#2d5016',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Get CSRF token
                        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : null;

                        if (!csrfToken) {
                            Swal.fire({
                                icon: 'error',
                                title: 'CSRF Token Missing',
                                text: 'Could not find CSRF token. Please refresh the page or contact support.',
                                confirmButtonColor: '#2d5016',
                                background: '#fafcf8',
                                color: '#2d5016',
                            });
                            return;
                        }

                        // Delete all availabilities from database
                        fetch('/counselor/availabilities', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            }
                        })
                            .then(async res => {
                                if (!res.ok) {
                                    let msg = 'Failed to reset availability!';
                                    if (res.status === 419) msg = 'Session expired or CSRF error. Please refresh and try again.';
                                    const data = await res.json().catch(() => ({}));
                                    throw new Error(data.message || msg);
                                }
                                return res.json();
                            })
                            .then(data => {
                                // Clear calendar events
                                calendar.getEvents().forEach(ev => ev.remove());

                                // Hide the availability list
                                document.getElementById('availabilityListSection').style.display = 'none';

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Reset Complete!',
                                    text: 'All availability slots have been permanently removed.',
                                    confirmButtonColor: '#2d5016',
                                    background: '#fafcf8',
                                    color: '#2d5016',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            })
                            .catch((error) => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: error.message || 'Failed to reset availability!',
                                    confirmButtonColor: '#2d5016',
                                    background: '#fafcf8',
                                    color: '#2d5016',
                                });
                            });
                    }
                });
            });
            // Toast helper
            function showToast(message, icon = 'success') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: icon,
                    title: message,
                    showConfirmButton: false,
                    timer: 1800,
                    background: '#fafcf8',
                    color: '#2d5016',
                    customClass: { popup: 'shadow' }
                });
            }
            // Modal event handlers
            document.getElementById('updateEventBtn').addEventListener('click', function () {
                if (!currentEvent) return;
                const newTitle = document.getElementById('editEventTitle').value.trim() || 'Available';
                const newStart = document.getElementById('editEventStart').value;
                const newEnd = document.getElementById('editEventEnd').value;
                if (!newStart || !newEnd) {
                    Swal.fire({ icon: 'error', title: 'Missing Time', text: 'Start and end time are required.', confirmButtonColor: '#2d5016', background: '#fafcf8', color: '#2d5016' });
                    return;
                }
                if (newStart >= newEnd) {
                    Swal.fire({ icon: 'error', title: 'Invalid Time', text: 'Start time must be before end time.', confirmButtonColor: '#2d5016', background: '#fafcf8', color: '#2d5016' });
                    return;
                }
                currentEvent.setProp('title', newTitle);
                currentEvent.setStart(newStart);
                currentEvent.setEnd(newEnd);
                bootstrap.Modal.getInstance(document.getElementById('editEventModal')).hide();
                showToast('Availability updated!');
                // Auto-save after edit
                document.getElementById('saveAvailabilityBtn').click();
            });
            document.getElementById('deleteEventBtn').addEventListener('click', function () {
                if (!currentEvent) return;
                Swal.fire({
                    title: 'Delete this slot?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete',
                    background: '#fafcf8',
                    color: '#2d5016',
                }).then((result) => {
                    if (result.isConfirmed) {
                        currentEvent.remove();
                        bootstrap.Modal.getInstance(document.getElementById('editEventModal')).hide();
                        showToast('Slot deleted!', 'info');
                    }
                });
            });
            // Add event listener for edit button in the list
            document.getElementById('availabilityListTable').addEventListener('click', function (e) {
                if (e.target.closest('.edit-list-btn')) {
                    const eventId = e.target.closest('.edit-list-btn').getAttribute('data-id');
                    const calEvent = calendar.getEvents().find(ev => ev.extendedProps && ev.extendedProps.dbId == eventId || ev.id == eventId);
                    if (calEvent) {
                        currentEvent = calEvent;
                        document.getElementById('editEventTitle').value = currentEvent.title;
                        document.getElementById('editEventStart').value = toLocalDatetimeString(currentEvent.start);
                        document.getElementById('editEventEnd').value = toLocalDatetimeString(currentEvent.end);
                        var modal = new bootstrap.Modal(document.getElementById('editEventModal'));
                        modal.show();
                    }
                }
            });
        });
    </script>
@endsection