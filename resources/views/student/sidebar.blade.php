<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo">
        <h3>CMU Guidance</h3>
        <p>Student Portal</p>
    </div>
    <div class="sidebar-menu">
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('profile') }}" class="menu-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
        <a href="{{ route('appointments.index') }}" class="menu-item {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check me-2"></i>
            <span>Appointments</span>
        </a>
        <a href="{{ route('assessments.index') }}" class="menu-item {{ request()->routeIs('assessments.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Assessments</span>
        </a>
        <a href="{{ route('chat.selectCounselor') }}" class="menu-item {{ request()->routeIs('chat.selectCounselor') ? 'active' : '' }}">
            <i class="bi bi-chat-dots me-2"></i>
            <span>Chat with Counselor</span>
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