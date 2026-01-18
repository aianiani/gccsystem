<div class="custom-sidebar">
    <div class="sidebar-logo mb-4">
        <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="CMU Logo"
            style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto;">
        <h3 style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">
            CMU Guidance and Counseling Center</h3>
        <p style="margin: 0; font-size: 0.95rem; color: #fff; opacity: 0.7;">Counselor Portal</p>
    </div>
    <nav class="sidebar-nav flex-grow-1">
        <!-- General -->
        <div class="sidebar-header text-xs uppercase tracking-wider opacity-50 px-3 mt-2 mb-1 font-bold"
            style="color: #f4d03f;">
            General</div>
        <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-link<?php echo e(request()->routeIs('dashboard') ? ' active' : ''); ?>"><i
                class="bi bi-house-door"></i>Dashboard</a>
        <a href="<?php echo e(route('profile')); ?>" class="sidebar-link<?php echo e(request()->routeIs('profile') ? ' active' : ''); ?>"><i
                class="bi bi-person"></i>Profile</a>

        <!-- Counseling -->
        <div class="sidebar-header text-xs uppercase tracking-wider opacity-50 px-3 mt-4 mb-1 font-bold"
            style="color: #f4d03f;">
            Counseling</div>
        <a href="<?php echo e(route('counselor.appointments.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('counselor.appointments.*') ? ' active' : ''); ?>"><i
                class="bi bi-calendar-check"></i>Appointments</a>
        <a href="<?php echo e(route('counselor.session_notes.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('counselor.session_notes.*') ? ' active' : ''); ?>"><i
                class="bi bi-journal-text"></i>Session Notes</a>
        <a href="<?php echo e(route('counselor.feedback.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('counselor.feedback.*') ? ' active' : ''); ?>"><i
                class="bi bi-star"></i>Student Feedback</a>
        <a href="<?php echo e(route('counselor.availability.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('counselor.availability.*') ? ' active' : ''); ?>"><i
                class="bi bi-clock"></i>Availability</a>
        <a href="<?php echo e(route('chat.selectStudent')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('chat.selectStudent') ? ' active' : ''); ?>"><i
                class="bi bi-chat-dots"></i>Chat</a>
        <a href="<?php echo e(route('counselor.assessments.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('counselor.assessments.*') ? ' active' : ''); ?>"><i
                class="bi bi-clipboard-data"></i>Assessments</a>

        <!-- Student Records -->
        <div class="sidebar-header text-xs uppercase tracking-wider opacity-50 px-3 mt-4 mb-1 font-bold"
            style="color: #f4d03f;">
            Student Records</div>
        <a href="<?php echo e(route('counselor.students.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('counselor.students.*') ? ' active' : ''); ?>"><i
                class="bi bi-people"></i>Students Directory</a>
        <a href="<?php echo e(route('counselor.guidance.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('counselor.guidance.*') ? ' active' : ''); ?>"><i
                class="bi bi-compass"></i>Guidance Profiling</a>


        <!-- Events -->
        <div class="sidebar-header text-xs uppercase tracking-wider opacity-50 px-3 mt-4 mb-1 font-bold"
            style="color: #f4d03f;">
            Events</div>
        <a href="<?php echo e(route('counselor.seminars.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('counselor.seminars.*') ? ' active' : ''); ?>"><i
                class="bi bi-calendar-event"></i>Seminars</a>
        <a href="<?php echo e(route('announcements.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('announcements.*') ? ' active' : ''); ?>"><i
                class="bi bi-megaphone"></i>Announcements</a>
    </nav>
    <div class="sidebar-bottom w-100">
        <a href="<?php echo e(route('logout')); ?>" class="sidebar-link logout"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i>Logout
        </a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
    </div>
</div><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/sidebar.blade.php ENDPATH**/ ?>