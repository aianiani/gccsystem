<div class="custom-sidebar">
    <div class="sidebar-logo mb-4 text-center">
        <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo" style="width:60px;height:60px;border-radius:50%;display:block;margin:0 auto 0.5rem;">
        <h3 style="margin:0.25rem 0 0; font-size:1.25rem; font-weight:700; color: var(--yellow-maize, #f4d03f);">CMU Guidance</h3>
        <p style="margin:0; font-size:0.9rem; color: #fff; opacity:0.8">Student Portal</p>
    </div>
    <nav class="sidebar-nav flex-grow-1">
        <a href="{{ route('dashboard') }}" class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i class="bi bi-house-door"></i>Dashboard</a>
        <a href="{{ route('profile') }}" class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i class="bi bi-person"></i>Profile</a>
        <a href="{{ route('appointments.index') }}" class="sidebar-link{{ request()->routeIs('appointments.*') ? ' active' : '' }}"><i class="bi bi-calendar-check"></i>Appointments</a>
        <a href="{{ route('assessments.index') }}" class="sidebar-link{{ request()->routeIs('assessments.*') ? ' active' : '' }}"><i class="bi bi-clipboard-data"></i>Assessments</a>
        <a href="{{ route('chat.selectCounselor') }}" class="sidebar-link{{ request()->routeIs('chat.selectCounselor') ? ' active' : '' }}"><i class="bi bi-chat-dots"></i>Chat with a Counselor</a>
        <div class="sidebar-divider my-2" style="border-top:1px solid rgba(255,255,255,0.08);"></div>
        <div class="sidebar-resources px-2">
            <div class="text-uppercase small text-muted mb-2" style="color: rgba(255,255,255,0.75); font-weight:600;">Resources</div>
            <a href="#" class="sidebar-link"><i class="fas fa-video"></i>Orientation</a>
            <a href="#" class="sidebar-link"><i class="fas fa-book"></i>Library</a>
            <a href="#" class="sidebar-link"><i class="fas fa-cog"></i>Settings</a>
        </div>
    </nav>
    <div class="sidebar-bottom w-100 p-3">
        <form action="{{ route('logout') }}" method="POST" style="width:100%;">
            @csrf
            <button type="submit" class="sidebar-link logout" style="width:100%; text-align:left; border:none; background:transparent;">
                <i class="bi bi-box-arrow-right"></i>Logout
            </button>
        </form>
    </div>
</div>