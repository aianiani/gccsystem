<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo">
        <h3>CMU Guidance</h3>
        <p>Counselor Portal</p>
    </div>
    <div class="sidebar-menu">
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('counselor.appointments.index') }}" class="menu-item {{ request()->routeIs('counselor.appointments.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Appointments</span>
            <span class="appointment-count" id="sidebarAppointmentCount">
                {{ \App\Models\Appointment::where('counselor_id', auth()->id())->whereDate('scheduled_at', '>=', today())->count() }}
            </span>
        </a>
        <a href="{{ route('counselor.availability.index') }}" class="menu-item {{ request()->routeIs('counselor.availability.*') ? 'active' : '' }}">
            <i class="fas fa-clock"></i>
            <span>Availability</span>
        </a>
        <a href="{{ route('counselor.messages.index') }}" class="menu-item {{ request()->routeIs('counselor.messages.*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i>
            <span>Messages</span>
        </a>
        <a href="{{ route('announcements.index') }}" class="menu-item {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
            <i class="fas fa-bullhorn"></i>
            <span>Announcements</span>
        </a>
        <a href="{{ route('users.index') }}" class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>Students</span>
        </a>
        <div class="menu-category"><i class="fas fa-comments"></i> Counseling</div>
        <a href="{{ route('counselor.session_notes.create', 0) }}" class="menu-item {{ request()->routeIs('counselor.session_notes.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i>
            <span>Case Notes</span>
        </a>
        <a href="{{ route('counselor.assessments.index') }}" class="menu-item {{ request()->routeIs('counselor.assessments.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Assessments</span>
        </a>
        <a href="{{ route('counselor.priority-cases.index') }}" class="menu-item {{ request()->routeIs('counselor.priority-cases.*') ? 'active' : '' }}">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Priority Cases</span>
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-chart-bar"></i>
            <span>Reports</span>
        </a>
        <div class="menu-category"><i class="fas fa-book-open"></i> Resources</div>
        <a href="#" class="menu-item">
            <i class="fas fa-video"></i>
            <span>Orientation</span>
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-book"></i>
            <span>Library</span>
        </a>
        <a href="#" class="menu-item">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
            @csrf
            <button type="submit" class="menu-item" id="logoutButton" style="width: 100%; border: none; background: none;">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div> 