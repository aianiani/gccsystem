<div class="custom-sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo"
            style="width: 80px; height: 80px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <h3 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">
            CMU Guidance and Counseling Center</h3>
        <p
            style="margin: 0; font-size: 0.8rem; color: #fff; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">
            Student Portal</p>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i
                class="bi bi-house-door"></i>Dashboard</a>
        <a href="{{ route('profile') }}" class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i
                class="bi bi-person"></i>Profile</a>
        <a href="{{ route('appointments.index') }}"
            class="sidebar-link{{ request()->routeIs('appointments.*') && !request()->routeIs('appointments.completedWithNotes') ? ' active' : '' }}"><i
                class="bi bi-calendar-check"></i>Appointments</a>
        <a href="{{ route('appointments.completedWithNotes') }}"
            class="sidebar-link{{ request()->routeIs('appointments.completedWithNotes') ? ' active' : '' }}"><i
                class="bi bi-journal-text"></i>Sessions & Feedback</a>
        <a href="{{ route('assessments.index') }}"
            class="sidebar-link{{ request()->routeIs('assessments.*') ? ' active' : '' }}"><i
                class="bi bi-clipboard-data"></i>Assessments</a>
        <a href="{{ route('student.seminars.index') }}"
            class="sidebar-link{{ request()->routeIs('student.seminars.*') ? ' active' : '' }}"><i
                class="bi bi-award"></i>Guidance Program</a>
        <a href="{{ route('chat.selectCounselor') }}"
            class="sidebar-link{{ request()->routeIs('chat.selectCounselor') ? ' active' : '' }}"><i
                class="bi bi-chat-dots"></i>Talk with Counselor</a>

        <div class="sidebar-divider my-3" style="border-top: 1px solid rgba(255, 255, 255, 0.1);"></div>
        <div class="sidebar-resources">
            <div class="text-uppercase small px-3 mb-2"
                style="color: rgba(255,255,255,0.5); font-weight:700; font-size: 0.75rem; letter-spacing: 1px;">
                Resources</div>
            <a href="#" class="sidebar-link"><i class="bi bi-play-circle"></i>Orientation</a>
            <a href="#" class="sidebar-link"><i class="bi bi-book"></i>Library</a>
            <a href="#" class="sidebar-link"><i class="bi bi-gear"></i>Settings</a>
        </div>
    </nav>
    <div class="sidebar-bottom w-100">
        <a href="{{ route('logout') }}" class="sidebar-link logout"
            onclick="event.preventDefault(); document.getElementById('logout-form-partial').submit();">
            <i class="bi bi-box-arrow-right"></i>Logout
        </a>
        <form id="logout-form-partial" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>