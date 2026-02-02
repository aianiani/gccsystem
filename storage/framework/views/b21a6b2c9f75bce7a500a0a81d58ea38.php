<div class="custom-sidebar" id="studentSidebar">
    
    <button class="btn-close-sidebar d-md-none" id="studentSidebarClose">
        <i class="bi bi-x-lg"></i>
    </button>

    <div class="sidebar-logo">
        <div class="logo-wrapper">
            <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="CMU Logo">
        </div>
        <h3>CMU Guidance and Counseling Center</h3>
        <p>Student Portal</p>
    </div>
    <nav class="sidebar-nav">
        <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-link<?php echo e(request()->routeIs('dashboard') ? ' active' : ''); ?>"><i
                class="bi bi-house-door"></i>Dashboard</a>
        <a href="<?php echo e(route('profile')); ?>" class="sidebar-link<?php echo e(request()->routeIs('profile') ? ' active' : ''); ?>"><i
                class="bi bi-person"></i>Profile</a>
        <a href="<?php echo e(route('appointments.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('appointments.*') && !request()->routeIs('appointments.completedWithNotes') ? ' active' : ''); ?>"><i
                class="bi bi-calendar-check"></i>Appointments</a>
        <a href="<?php echo e(route('appointments.completedWithNotes')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('appointments.completedWithNotes') ? ' active' : ''); ?>"><i
                class="bi bi-journal-text"></i>Sessions & Feedback</a>
        <a href="<?php echo e(route('assessments.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('assessments.*') ? ' active' : ''); ?>"><i
                class="bi bi-clipboard-data"></i>Assessments</a>
        <a href="<?php echo e(route('student.seminars.index')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('student.seminars.*') ? ' active' : ''); ?>"><i
                class="bi bi-award"></i>Guidance Program</a>
        <a href="<?php echo e(route('chat.selectCounselor')); ?>"
            class="sidebar-link<?php echo e(request()->routeIs('chat.selectCounselor') ? ' active' : ''); ?>"><i
                class="bi bi-headset"></i>Talk with Counselor</a>

        <div class="sidebar-divider my-3" style="border-top: 1px solid rgba(255, 255, 255, 0.1);"></div>
        <div class="sidebar-resources">
            <div class="text-uppercase small px-3 mb-2"
                style="color: rgba(255,255,255,0.5); font-weight:700; font-size: 0.75rem; letter-spacing: 1px;">
                Resources</div>
            <a href="#" class="sidebar-link"><i class="bi bi-info-circle-fill"></i>Orientation</a>
            <a href="#" class="sidebar-link"><i class="bi bi-book"></i>Library</a>
            <a href="#" class="sidebar-link"><i class="bi bi-gear"></i>Settings</a>
        </div>
    </nav>
    <div class="sidebar-bottom w-100">
        <a href="<?php echo e(route('logout')); ?>" class="sidebar-link logout"
            onclick="event.preventDefault(); document.getElementById('logout-form-partial').submit();">
            <i class="bi bi-box-arrow-right"></i>Logout
        </a>
        <form id="logout-form-partial" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
    </div>
</div><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/student/sidebar.blade.php ENDPATH**/ ?>