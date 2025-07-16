<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - CMU Counseling System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --forest-green: #228B22;
            --forest-green-light: #32CD32;
            --forest-green-dark: #006400;
            --yellow-maize: #FFDB58;
            --yellow-maize-light: #FFF8DC;
            --yellow-maize-dark: #DAA520;
            --white: #FFFFFF;
            --light-gray: #F8F9FA;
            --text-dark: #2C3E50;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;
        }

        body {
            background-color: var(--light-gray);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-dark) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .card-header {
            background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.2rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--forest-green-dark) 0%, var(--forest-green) 100%);
            transform: translateY(-1px);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--yellow-maize) 0%, var(--yellow-maize-dark) 100%);
            border: none;
            border-radius: 10px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .btn-outline-primary {
            border: 2px solid var(--forest-green);
            color: var(--forest-green);
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-outline-primary:hover {
            background: var(--forest-green);
            border-color: var(--forest-green);
        }

        .wellness-meter {
            height: 15px;
            background: linear-gradient(90deg, var(--danger) 0%, var(--warning) 50%, var(--success) 100%);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .wellness-indicator {
            position: absolute;
            top: -5px;
            width: 25px;
            height: 25px;
            background: white;
            border: 3px solid var(--forest-green);
            border-radius: 50%;
            transition: left 0.3s ease;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .activity-item {
            padding: 1rem;
            border-left: 4px solid var(--forest-green);
            margin-bottom: 1rem;
            background: white;
            border-radius: 0 10px 10px 0;
        }

        .calendar-mini {
            background: white;
            border-radius: 10px;
            padding: 1rem;
        }

        .calendar-day {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .calendar-day:hover {
            background: var(--yellow-maize-light);
        }

        .calendar-day.today {
            background: var(--forest-green);
            color: white;
        }

        .calendar-day.has-appointment {
            background: var(--yellow-maize);
            color: var(--text-dark);
        }

        .progress-ring {
            width: 80px;
            height: 80px;
        }

        .progress-ring__circle {
            stroke: var(--forest-green);
            stroke-linecap: round;
            transition: stroke-dashoffset 0.3s ease;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--yellow-maize-light) 0%, var(--white) 100%);
            border-left: 5px solid var(--forest-green);
        }

        .emergency-alert {
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            border: 2px solid var(--danger);
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            color: var(--text-dark);
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--forest-green) 0%, var(--yellow-maize) 100%);
        }

        .action-card:hover {
            color: var(--text-dark);
            text-decoration: none;
        }

        .message-preview {
            background: var(--yellow-maize-light);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-heart-pulse me-2"></i>CMU Counseling System
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="bi bi-person me-2"></i>Profile
                            </a>
                        </li>
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
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <!-- Welcome Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="fw-bold mb-1" style="color: var(--forest-green);">
                            <i class="bi bi-speedometer2 me-2"></i>Welcome back, {{ auth()->user()->first_name ?? auth()->user()->name }}!
                        </h1>
                        <p class="text-muted mb-0">Today is {{ now()->format('l, F j, Y') }}</p>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Emergency Alert (conditionally shown) -->

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('appointments.create') }}" class="action-card">
                <div class="position-relative">
                    <i class="bi bi-calendar-plus text-primary fs-1 mb-3"></i>
                    <div class="notification-badge">2</div>
                </div>
                <h6 class="fw-bold">Book Appointment</h6>
                <p class="text-muted small mb-0">Schedule a counseling session</p>
            </a>
            
            <a href="#" class="action-card" onclick="openChat()">
                <div class="position-relative">
                    <i class="bi bi-chat-dots text-success fs-1 mb-3"></i>
                    <div class="notification-badge">5</div>
                </div>
                <h6 class="fw-bold">Secure Chat</h6>
                <p class="text-muted small mb-0">Message your counselor</p>
            </a>
            
            <a href="#" class="action-card" onclick="takeAssessment()">
                <i class="bi bi-clipboard-pulse text-warning fs-1 mb-3"></i>
                <h6 class="fw-bold">Take Assessment</h6>
                <p class="text-muted small mb-0">DASS-21 & Stress Scale</p>
            </a>
            
            <a href="#" class="action-card">
                <i class="bi bi-journal-text text-info fs-1 mb-3"></i>
                <h6 class="fw-bold">Resources</h6>
                <p class="text-muted small mb-0">Self-help materials</p>
            </a>
        </div>

        <!-- Main Content Row -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Mental Health Overview -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Upcoming Appointments</h5>
                        <button class="btn btn-light btn-sm" onclick="showCalendarView()">
                            <i class="bi bi-calendar3 me-1"></i>Calendar View
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="appointment-item mb-3 p-3 border rounded-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 fw-bold">Individual Counseling</h6>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-person me-1"></i>Dr. Maria Santos
                                    </p>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-calendar me-1"></i>July 18, 2025 at 2:00 PM
                                        <i class="bi bi-geo-alt ms-3 me-1"></i>Room 204, Counseling Center
                                    </p>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <span class="badge bg-primary">Confirmed</span>
                                    <div class="btn-group-vertical btn-group-sm">
                                        <button class="btn btn-outline-secondary" onclick="rescheduleAppointment(1)">
                                            <i class="bi bi-arrow-clockwise me-1"></i>Reschedule
                                        </button>
                                        <button class="btn btn-outline-danger" onclick="cancelAppointment(1)">
                                            <i class="bi bi-x-circle me-1"></i>Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="appointment-item mb-3 p-3 border rounded-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 fw-bold">Group Therapy Session</h6>
                                    <p class="text-muted mb-1">
                                        <i class="bi bi-people me-1"></i>Anxiety Support Group
                                    </p>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-calendar me-1"></i>July 20, 2025 at 10:00 AM
                                        <i class="bi bi-geo-alt ms-3 me-1"></i>Group Room A
                                    </p>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    <span class="badge bg-warning">Pending</span>
                                    <button class="btn btn-outline-success btn-sm" onclick="confirmAppointment(2)">
                                        <i class="bi bi-check-circle me-1"></i>Confirm
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-outline-primary" onclick="viewAllAppointments()">
                                <i class="bi bi-eye me-1"></i>View All Appointments
                            </button>
                        </div>
                    </div>
                </div>
                
                

                <!-- Appointments Section -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-megaphone me-2"></i>Announcements</h6>
                    </div>
                    <div class="card-body">
                        <div class="announcement-item mb-3 p-2 border-start border-primary border-3">
                            <h6 class="mb-1 fw-bold small">Mental Health Awareness Week</h6>
                            <p class="mb-1 small text-muted">Join us for various activities and workshops focused on mental wellness.</p>
                            <small class="text-muted">July 22-26, 2025</small>
                        </div>
                        
                        <div class="announcement-item mb-3 p-2 border-start border-warning border-3">
                            <h6 class="mb-1 fw-bold small">New Group Therapy Sessions</h6>
                            <p class="mb-1 small text-muted">Additional slots available for anxiety and depression support groups.</p>
                            <small class="text-muted">Starting July 30</small>
                        </div>
                        
                        <div class="text-center">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewAllAnnouncements()">
                                <i class="bi bi-eye me-1"></i>View All
                            </button>
                        </div>
                    </div>
                </div>
                

                <!-- Recent Messages -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>Recent Messages</h5>
                        <button class="btn btn-light btn-sm" onclick="openChat()">
                            <i class="bi bi-chat-dots me-1"></i>Open Chat
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="message-preview">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 fw-bold">Dr. Maria Santos</h6>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                            <p class="mb-0 text-muted">Thank you for sharing your concerns about exam stress. I've sent you some relaxation techniques to try before our next session...</p>
                        </div>
                        
                        <div class="message-preview">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 fw-bold">Counseling Center</h6>
                                <small class="text-muted">1 day ago</small>
                            </div>
                            <p class="mb-0 text-muted">Reminder: Your appointment with Dr. Santos is scheduled for July 18th at 2:00 PM. Please arrive 10 minutes early.</p>
                        </div>
                        
                        <div class="text-center mt-3">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewAllMessages()">
                                <i class="bi bi-eye me-1"></i>View All Messages
                            </button>
                        </div>
                    </div>
                </div>

                <br></br>
            
                <div> 
                <div class="row mb-4" id="emergencyAlert" style="display: none;">
                <div class="col-12">
                <div class="emergency-alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-3 fs-3"></i>
                        <div>
                            <h6 class="mb-1 fw-bold">Need immediate help?</h6>
                            <p class="mb-2">If you're experiencing a mental health crisis, please reach out immediately:</p>
                            <div class="d-flex gap-3">
                                <a href="tel:911" class="btn btn-danger btn-sm">Emergency: 911</a>
                                <a href="tel:988" class="btn btn-outline-danger btn-sm">Crisis Hotline: 988</a>
                                <button class="btn btn-outline-secondary btn-sm" onclick="requestEmergencySession()">Request Emergency Session</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
            </div>
        </div>

                
            </div>
            

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ auth()->user()->avatar_url ?? 'https://via.placeholder.com/80x80/228B22/FFFFFF?text=' . substr(auth()->user()->name, 0, 2) }}" alt="Avatar" class="rounded-circle mb-3 border border-3" style="border-color: var(--forest-green); width: 80px; height: 80px; object-fit: cover;">
                        <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-2">{{ auth()->user()->email }}</p>
                        <span class="badge bg-primary mb-3">{{ auth()->user()->role ?? 'Student' }}</span>
                        <div class="d-grid">
                            <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil me-1"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mini Calendar -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-calendar3 me-2"></i>July 2025</h6>
                    </div>
                    <div class="card-body">
                        <div class="calendar-mini">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="row text-center w-100">
                                    <div class="col fw-bold small">S</div>
                                    <div class="col fw-bold small">M</div>
                                    <div class="col fw-bold small">T</div>
                                    <div class="col fw-bold small">W</div>
                                    <div class="col fw-bold small">T</div>
                                    <div class="col fw-bold small">F</div>
                                    <div class="col fw-bold small">S</div>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col"><div class="calendar-day">13</div></div>
                                <div class="col"><div class="calendar-day">14</div></div>
                                <div class="col"><div class="calendar-day">15</div></div>
                                <div class="col"><div class="calendar-day today">16</div></div>
                                <div class="col"><div class="calendar-day">17</div></div>
                                <div class="col"><div class="calendar-day has-appointment">18</div></div>
                                <div class="col"><div class="calendar-day">19</div></div>
                            </div>
                            <div class="row text-center">
                                <div class="col"><div class="calendar-day has-appointment">20</div></div>
                                <div class="col"><div class="calendar-day">21</div></div>
                                <div class="col"><div class="calendar-day">22</div></div>
                                <div class="col"><div class="calendar-day">23</div></div>
                                <div class="col"><div class="calendar-day">24</div></div>
                                <div class="col"><div class="calendar-day">25</div></div>
                                <div class="col"><div class="calendar-day">26</div></div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-muted">Legend:</small>
                                <div class="d-flex gap-2">
                                    <div class="d-flex align-items-center">
                                        <div class="calendar-day today" style="width: 15px; height: 15px; font-size: 0;"></div>
                                        <small class="ms-1">Today</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="calendar-day has-appointment" style="width: 15px; height: 15px; font-size: 0;"></div>
                                        <small class="ms-1">Appointment</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Your Progress</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small>Sessions Completed</small>
                                <small class="fw-bold">8/12</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" style="width: 67%; background: var(--forest-green);"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small>Assessments</small>
                                <small class="fw-bold">3 this month</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" style="width: 100%; background: var(--yellow-maize);"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small>Attendance Rate</small>
                                <small class="fw-bold">95%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar" style="width: 95%; background: var(--success);"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Announcements -->

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-activity me-2"></i>Mental Health Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="stats-card card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="text-muted mb-1">Stress Level</h6>
                                                <h4 class="mb-0 fw-bold">Moderate</h4>
                                                <small class="text-success">↓ 15% from last week</small>
                                            </div>
                                            <i class="bi bi-thermometer-half text-warning fs-3"></i>
                                        </div>
                                        <div class="wellness-meter mt-3">
                                            <div class="wellness-indicator" style="left: 45%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="stats-card card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="text-muted mb-1">Last Assessment</h6>
                                                <h4 class="mb-0 fw-bold">July 10</h4>
                                                <small class="text-info">DASS-21 completed</small>
                                            </div>
                                            <i class="bi bi-clipboard-check text-success fs-3"></i>
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-outline-primary btn-sm" onclick="viewAssessmentHistory()">View History</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h6 class="fw-bold mb-3">Recommended Actions</h6>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="alert alert-info py-2 mb-2">
                                        <i class="bi bi-lightbulb me-2"></i>
                                        <small>Practice mindfulness exercises</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-warning py-2 mb-2">
                                        <i class="bi bi-calendar-week me-2"></i>
                                        <small>Schedule follow-up session</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-success py-2 mb-2">
                                        <i class="bi bi-people me-2"></i>
                                        <small>Join support group</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sample JavaScript functions for interactivity
        function showBookingModal() {
            alert('Opening appointment booking modal...');
        }
        
        function openChat() {
            alert('Opening secure chat interface...');
        }
        
        function takeAssessment() {
            alert('Starting DASS-21 assessment...');
        }
        
        function viewAssessmentHistory() {
            alert('Viewing assessment history...');
        }
        
        function rescheduleAppointment(id) {
            alert(`Rescheduling appointment ${id}...`);
        }
        
        function cancelAppointment(id) {
            if (confirm('Are you sure you want to cancel this appointment?')) {
                alert(`Appointment ${id} cancelled successfully.`);
            }
        }
        
        function confirmAppointment(id) {
            alert(`Appointment ${id} confirmed!`);
        }
        
        function viewAllAppointments() {
            alert('Viewing all appointments...');
        }
        
        function viewAllMessages() {
            alert('Opening message history...');
        }
        
        function editProfile() {
            alert('Opening profile editor...');
        }
        
        function showCalendarView() {
            alert('Opening calendar view...');
        }
        
        function viewAllAnnouncements() {
            alert('Viewing all announcements...');
        }
        
        function requestEmergencySession() {
            if (confirm('This will immediately notify counselors of your urgent need for help. Continue?')) {
                alert('Emergency session request sent. A counselor will contact you within 15 minutes.');
            }
        }
        
        // Check for emergency conditions and show alert if needed
        function checkEmergencyConditions() {
            // This would typically check recent assessment scores or user flags
            const recentStressLevel = 85; // Example: high stress level
            const hasEmergencyFlag = false; // Example: emergency flag from assessment
            
            if (recentStressLevel > 80 || hasEmergencyFlag) {
                document.getElementById('emergencyAlert').style.display = 'block';
            }
        }
        
        // Simulate real-time updates
        function updateWellnessScore() {
            const score = 75; // This would come from backend
            const circumference = 2 * Math.PI * 26;
            const offset = circumference - (score / 100) * circumference;
            
            const circle = document.querySelector('.progress-ring__circle:last-child');
            if (circle) {
                circle.style.strokeDashoffset = offset;
            }
        }
        
        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            updateWellnessScore();
            checkEmergencyConditions();
            
            // Add smooth scrolling for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
        
        // Sample function to handle feedback submission
        function submitFeedback() {
            alert('Thank you for your feedback! It helps us improve our services.');
        }
        
        // Function to handle wellness meter interaction
        function updateWellnessMeter(level) {
            const indicator = document.querySelector('.wellness-indicator');
            if (indicator) {
                indicator.style.left = level + '%';
            }
        }
        
        // Add notification sound (optional)
        function playNotificationSound() {
            // This would play a subtle notification sound
            console.log('Notification sound played');
        }
        
        // Handle appointment reminders
        function showAppointmentReminder() {
            const now = new Date();
            const appointmentTime = new Date('2025-07-18T14:00:00');
            const timeDiff = appointmentTime - now;
            const daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
            
            if (daysDiff === 1) {
                // Show reminder for tomorrow's appointment
                const reminderDiv = document.createElement('div');
                reminderDiv.className = 'alert alert-info alert-dismissible fade show';
                reminderDiv.innerHTML = `
                    <i class="bi bi-bell me-2"></i>
                    <strong>Appointment Reminder:</strong> You have a counseling session tomorrow at 2:00 PM with Dr. Maria Santos.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.querySelector('.container-fluid').insertBefore(reminderDiv, document.querySelector('.row').nextSibling);
            }
        }
        
        // Initialize reminders
        setTimeout(showAppointmentReminder, 1000);
    </script>
</body>
</html>