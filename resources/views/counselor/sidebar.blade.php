<div class="custom-sidebar">
    <div class="sidebar-logo mb-4">
        <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo" style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto;">
        <h3 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">CMU Guidance and Counseling Center</h3>
        <p style="margin: 0; font-size: 0.95rem; color: #fff; opacity: 0.7;">Counselor Portal</p>
    </div>
    <nav class="sidebar-nav flex-grow-1">
        <a href="{{ route('profile') }}" class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i class="bi bi-person"></i>Profile</a>
        <a href="{{ route('dashboard') }}" class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i class="bi bi-house-door"></i>Dashboard</a>
        <a href="{{ route('counselor.appointments.index') }}" class="sidebar-link{{ request()->routeIs('counselor.appointments.*') ? ' active' : '' }}"><i class="bi bi-calendar-check"></i>Appointments</a>
        <a href="{{ route('counselor.session_notes.index') }}" class="sidebar-link{{ request()->routeIs('counselor.session_notes.*') ? ' active' : '' }}"><i class="bi bi-journal-text"></i>Session Notes</a>
        <a href="{{ route('counselor.assessments.index') }}" class="sidebar-link{{ request()->routeIs('counselor.assessments.*') ? ' active' : '' }}"><i class="bi bi-clipboard-data"></i>Assessments</a>
        <a href="{{ route('chat.selectStudent') }}" class="sidebar-link{{ request()->routeIs('chat.selectStudent') ? ' active' : '' }}"><i class="bi bi-chat-dots"></i>Chat with Student</a>
        <a href="{{ route('counselor.availability.index') }}" class="sidebar-link{{ request()->routeIs('counselor.availability.*') ? ' active' : '' }}"><i class="bi bi-clock"></i>Availability</a>
        <a href="{{ route('counselor.students.index') }}" class="sidebar-link{{ request()->routeIs('counselor.students.*') ? ' active' : '' }}"><i class="bi bi-people"></i>Students</a>
        <a href="{{ route('announcements.index') }}" class="sidebar-link{{ request()->routeIs('announcements.*') ? ' active' : '' }}"><i class="bi bi-megaphone"></i>Announcements</a>
    </nav>
    <div class="sidebar-bottom w-100">
        <a href="{{ route('logout') }}" class="sidebar-link logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i>Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div> 