<div class="custom-sidebar" id="studentSidebar">
    {{-- Mobile Close Button --}}
    <button class="btn-close-sidebar d-md-none" id="studentSidebarClose">
        <i class="bi bi-x-lg"></i>
    </button>

    <div class="sidebar-logo">
        <div class="logo-wrapper">
            <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo">
        </div>
        <h3>CMU Guidance and Counseling Center</h3>
        <p>Student Portal</p>
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
                class="bi bi-headset"></i>Talk with Counselor</a>

        <div class="sidebar-divider my-3" style="border-top: 1px solid rgba(255, 255, 255, 0.1);"></div>
        <div class="sidebar-resources">
            <div class="text-uppercase small px-3 mb-2"
                style="color: rgba(255,255,255,0.5); font-weight:700; font-size: 0.75rem; letter-spacing: 1px;">
                Resources</div>
            <a href="{{ route('resources') }}"
                class="sidebar-link{{ request()->routeIs('resources') ? ' active' : '' }}"><i
                    class="bi bi-collection-play"></i>Resources</a>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('studentSidebar');
        const toggleBtn = document.getElementById('studentSidebarToggle');
        const closeBtn = document.getElementById('studentSidebarClose');
        let isToggling = false;

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                isToggling = true;
                sidebar.classList.add('show');
                setTimeout(() => { isToggling = false; }, 100);
            });
        }

        if (closeBtn && sidebar) {
            closeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                sidebar.classList.remove('show');
            });
        }

        document.addEventListener('click', function (e) {
            if (isToggling) return;
            if (window.innerWidth < 992 && sidebar && sidebar.classList.contains('show')) {
                const clickInside = sidebar.contains(e.target) || (toggleBtn && toggleBtn.contains(e.target));
                if (!clickInside) {
                    sidebar.classList.remove('show');
                }
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && window.innerWidth < 992 && sidebar && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    });
</script>