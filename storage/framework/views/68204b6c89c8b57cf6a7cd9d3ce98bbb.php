<?php $__env->startSection('content'); ?>
    <style>
        /* Dashboard theme variables - matching dashboard exactly */
        :root {
            --primary-green: #1f7a2d;
            /* Dashboard forest green */
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
            --info: #ffc107;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        /* Apply the same page zoom used on the homepage */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        body,
        .profile-card,
        .stats-card,
        .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0, 0, 0, 0.08);
            overflow-y: auto;
            padding-bottom: 1rem;
        }

        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2.5rem 1.5rem 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.05);
        }

        .custom-sidebar .sidebar-logo h3 {
            font-family: 'Outfit', sans-serif;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .custom-sidebar .sidebar-logo p {
            letter-spacing: 1px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem !important;
        }

        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1.25rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .custom-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            padding: 0.9rem 1.25rem;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            margin: 0.1rem 0;
        }

        .custom-sidebar .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .custom-sidebar .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: #f4d03f;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .custom-sidebar .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: -0.75rem;
            /* Align perfectly with sidebar edge */
            top: 15%;
            bottom: 15%;
            width: 5px;
            background: #f4d03f;
            border-radius: 0 6px 6px 0;
            box-shadow: 2px 0 15px rgba(244, 208, 63, 0.5);
        }

        .custom-sidebar .sidebar-link .bi {
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .custom-sidebar .sidebar-link.active .bi {
            transform: scale(1.1);
            filter: drop-shadow(0 0 5px rgba(244, 208, 63, 0.3));
        }

        .custom-sidebar .sidebar-bottom {
            padding: 1.5rem 1rem;
            background: rgba(0, 0, 0, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-sidebar .sidebar-link.logout {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-sidebar .sidebar-link.logout:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.4);
        }

        @media (max-width: 991.98px) {
            .custom-sidebar {
                width: 200px;
            }

            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {

            /* Off-canvas behavior on mobile */
            .custom-sidebar {
                position: fixed;
                z-index: 1040;
                height: 100vh;
                left: 0;
                top: 0;
                width: 240px;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                flex-direction: column;
                padding: 0;
                box-shadow: 10px 0 30px rgba(0, 0, 0, 0.2);
            }

            .custom-sidebar.show {
                transform: translateX(0);
            }

            .main-dashboard-content {
                margin-left: 0;
                padding: 1rem;
            }

            /* Toggle button */
            #studentSidebarToggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--forest-green);
                color: #fff;
                border: none;
                border-radius: 10px;
                padding: 0.6rem 0.8rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                display: flex !important;
                align-items: center;
                justify-content: center;
            }
        }

        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 2rem;
            margin-left: 240px;
            transition: all 0.3s ease;
        }

        .main-dashboard-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Form Controls */
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            font-size: 0.95rem;
            display: block;
        }

        .form-control,
        .form-select,
        textarea {
            border: 2px solid #e0e6ed;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            background-color: #fcfdfe;
            color: #16321f;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            border-color: var(--forest-green);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(31, 122, 45, 0.1);
            outline: none;
            transform: translateY(-1px);
        }

        .form-control[readonly],
        .form-control[disabled] {
            background-color: #f8fafc;
            border-color: #edf2f7;
            color: #64748b;
            font-weight: 500;
        }

        /* Grouped inputs (guardians) */
        .step-content .border {
            border-color: #edf2f7 !important;
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem !important;
            margin-bottom: 1.5rem !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        /* Autofill styling */
        input:-webkit-autofill,
        textarea:-webkit-autofill,
        select:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #fff inset !important;
            box-shadow: 0 0 0px 1000px #fff inset !important;
            -webkit-text-fill-color: #16321f !important;
        }

        input:-webkit-autofill:focus,
        textarea:-webkit-autofill:focus,
        select:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px #fff176 inset !important;
            box-shadow: 0 0 0px 1000px #fff176 inset !important;
            -webkit-text-fill-color: #16321f !important;
        }

        /* Firefox */
        input:-moz-autofill,
        textarea:-moz-autofill,
        select:-moz-autofill {
            background-color: #fff176 !important;
            color: #16321f !important;
            box-shadow: none !important;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            outline: none;
            border-width: 2.6px;
            border-color: var(--forest-green-dark);
            box-shadow: 0 12px 36px rgba(23, 90, 26, 0.14);
            transform: translateY(-1px);
        }

        .form-control[readonly],
        .form-control[disabled] {
            background: #fff;
            border-color: #cfe6cf;
            color: #16321f;
            font-weight: 600;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--forest-green-dark);
            box-shadow: 0 6px 20px rgba(33, 120, 37, 0.12);
            transform: translateY(-1px);
        }

        /* Distinct containers for guardians and grouped inputs */
        .step-content .border {
            border-color: #e6efe4 !important;
            background: #fff;
            box-shadow: var(--shadow-sm);
            padding: 1rem !important;
        }

        /* Make review/confirmation sections stand out */
        .scheduler-header h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--forest-green-dark);
        }

        .nav-step {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem .75rem;
            border-radius: 10px;
            background: #fff;
            color: var(--forest-green-dark);
            border: 1px solid #ecf3ec;
            font-weight: 600;
            margin-right: .4rem;
        }

        .nav-step.active {
            background: linear-gradient(90deg, var(--forest-green) 0%, var(--forest-green-dark) 100%);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 6px 18px rgba(23, 90, 26, 0.08);
        }

        /* Form helper spacing */
        .form-text {
            margin-top: .25rem;
            color: var(--gray-600);
        }

        @media (max-width: 767.98px) {

            .form-control,
            .form-select,
            textarea {
                padding: .5rem .6rem;
            }

            .nav-step {
                font-size: .9rem;
                padding: .4rem .6rem;
            }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="studentSidebarToggle" class="d-md-none">
                <i class="bi bi-list"></i>
            </button>
            <!-- Sidebar -->
            <div class="custom-sidebar">
                <div class="sidebar-logo mb-4">
                    <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="CMU Logo"
                        style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto;">
                    <h3
                        style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">
                        CMU Guidance and Counseling Center</h3>
                    <p style="margin: 0; font-size: 0.95rem; color: #fff; opacity: 0.7;">Student Portal</p>
                </div>
                <nav class="sidebar-nav flex-grow-1">
                    <a href="<?php echo e(route('profile')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('profile') ? ' active' : ''); ?>"><i
                            class="bi bi-person"></i>Profile</a>
                    <a href="<?php echo e(route('dashboard')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('dashboard') ? ' active' : ''); ?>"><i
                            class="bi bi-house-door"></i>Dashboard</a>
                    <a href="<?php echo e(route('appointments.index')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('appointments.*') && !request()->routeIs('appointments.completedWithNotes') ? ' active' : ''); ?>"><i
                            class="bi bi-calendar-check"></i>Appointments</a>
                    <a href="<?php echo e(route('appointments.completedWithNotes')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('appointments.completedWithNotes') ? ' active' : ''); ?>"><i
                            class="bi bi-journal-text"></i>Sessions & Feedback</a>
                    <a href="<?php echo e(route('assessments.index')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('assessments.*') ? ' active' : ''); ?>"><i
                            class="bi bi-clipboard-data"></i>Assessments</a>
                    <a href="<?php echo e(route('chat.selectCounselor')); ?>"
                        class="sidebar-link<?php echo e(request()->routeIs('chat.selectCounselor') ? ' active' : ''); ?>"><i
                            class="bi bi-chat-dots"></i>Chat with a Counselor</a>
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
                    <a href="<?php echo e(route('logout')); ?>" class="sidebar-link logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>Logout
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <div class="scheduler-container">
                        <!-- Progress Header -->
                        <div class="scheduler-header">
                            <h3><i class="bi bi-calendar-plus me-2"></i>Schedule Your Counseling Session</h3>
                            <div class="scheduler-nav">
                                <button class="nav-step active" data-step="1">
                                    <i class="bi bi-person-badge"></i>
                                    Personal & Guardian Info
                                </button>
                                <button class="nav-step" data-step="2">
                                    <i class="bi bi-person-badge"></i>
                                    Select Counselor
                                </button>
                                <button class="nav-step" data-step="3">
                                    <i class="bi bi-calendar-alt"></i>
                                    Select Date
                                    & Time
                                </button>
                                <button class="nav-step" data-step="4">
                                    <i class="bi bi-check-circle"></i>
                                    Confirm
                                </button>
                            </div>
                        </div>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('appointments.store')); ?>" method="POST" id="appointmentBookingForm">
                            <?php echo csrf_field(); ?>

                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger mb-4">
                                    <h6 class="alert-heading fw-bold mb-2"><i class="bi bi-exclamation-triangle me-2"></i>Please
                                        fix the following errors:</h6>
                                    <ul class="mb-0">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- Step 1: Personal Information & Guardian Information -->
                            <div class="step-content" id="step-1" style="display: block;">
                                <div class="counselor-selection-header">
                                    <h3>Personal & Guardian Information</h3>
                                    <p>Please review your personal information and provide guardian details</p>
                                </div>

                                <!-- Personal Information (Auto-Filled) -->
                                <div class="mb-4">
                                    <h5 class="mb-3"><i class="bi bi-person-circle me-2"></i>Personal Information <span
                                            class="badge" style="background:#f4d03f;color:#16321f;">Auto-filled</span></h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" value="<?php echo e($student->name); ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">College</label>
                                            <input type="text" class="form-control" value="<?php echo e($student->college ?? 'N/A'); ?>"
                                                readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Course</label>
                                            <input type="text" class="form-control" value="<?php echo e($student->course ?? 'N/A'); ?>"
                                                readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Year Level</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo e($student->year_level ?? 'N/A'); ?>" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Sex</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo e(ucfirst($student->sex ?? 'N/A')); ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" value="<?php echo e($student->address ?? 'N/A'); ?>"
                                                readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Contact Number</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo e($student->contact_number ?? 'N/A'); ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" value="<?php echo e($student->email); ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Guardian Information -->
                                <div class="mt-4">
                                    <h5 class="mb-3"><i class="bi bi-people me-2"></i>Guardian Information</h5>

                                    <!-- Guardian 1 (Required) -->
                                    <div class="mb-3 p-3 border rounded">
                                        <h6>Guardian 1 <span class="text-danger">*</span></h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Guardian Full Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="guardian1_name" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Relationship to Student <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" name="guardian1_relationship"
                                                    id="guardian1_relationship" required>
                                                    <option value="">Select relationship</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Aunt">Aunt</option>
                                                    <option value="Uncle">Uncle</option>
                                                    <option value="Grandparent">Grandparent</option>
                                                    <option value="Sibling">Sibling</option>
                                                    <option value="Legal Guardian">Legal Guardian</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <input type="text" class="form-control mt-2"
                                                    name="guardian1_relationship_other" id="guardian1_relationship_other"
                                                    placeholder="Please specify" style="display:none;">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Guardian Contact Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="guardian1_contact" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Guardian 2 (Optional) -->
                                    <div class="p-3 border rounded">
                                        <h6>Guardian 2 <span class="text-muted">(Optional)</span></h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Guardian Full Name</label>
                                                <input type="text" class="form-control" name="guardian2_name">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Relationship to Student</label>
                                                <select class="form-select" name="guardian2_relationship"
                                                    id="guardian2_relationship">
                                                    <option value="">Select relationship</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Aunt">Aunt</option>
                                                    <option value="Uncle">Uncle</option>
                                                    <option value="Grandparent">Grandparent</option>
                                                    <option value="Sibling">Sibling</option>
                                                    <option value="Legal Guardian">Legal Guardian</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                <input type="text" class="form-control mt-2"
                                                    name="guardian2_relationship_other" id="guardian2_relationship_other"
                                                    placeholder="Please specify" style="display:none;">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Guardian Contact Number</label>
                                                <input type="text" class="form-control" name="guardian2_contact">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nature of Problem Section -->
                                <div class="mt-5">
                                    <h5 class="mb-3"><i class="bi bi-question-circle me-2"></i>Nature of the Problem</h5>
                                    <p class="text-muted mb-3">Please select the nature of the problem you'd like to discuss
                                    </p>
                                    <div class="nature-problem-options">
                                        <div class="form-check-square">
                                            <input class="form-check-input" type="radio" name="nature_of_problem"
                                                id="problem_academic" value="Academic" required>
                                            <label class="form-check-label" for="problem_academic">Academic</label>
                                        </div>
                                        <div class="form-check-square">
                                            <input class="form-check-input" type="radio" name="nature_of_problem"
                                                id="problem_family" value="Family" required>
                                            <label class="form-check-label" for="problem_family">Family</label>
                                        </div>
                                        <div class="form-check-square">
                                            <input class="form-check-input" type="radio" name="nature_of_problem"
                                                id="problem_personal" value="Personal / Emotional" required>
                                            <label class="form-check-label" for="problem_personal">Personal /
                                                Emotional</label>
                                        </div>
                                        <div class="form-check-square">
                                            <input class="form-check-input" type="radio" name="nature_of_problem"
                                                id="problem_social" value="Social" required>
                                            <label class="form-check-label" for="problem_social">Social</label>
                                        </div>
                                        <div class="form-check-square">
                                            <input class="form-check-input" type="radio" name="nature_of_problem"
                                                id="problem_psychological" value="Psychological" required>
                                            <label class="form-check-label"
                                                for="problem_psychological">Psychological</label>
                                        </div>
                                        <div class="form-check-square">
                                            <input class="form-check-input" type="radio" name="nature_of_problem"
                                                id="problem_other" value="Other" required>
                                            <label class="form-check-label" for="problem_other">Other (please
                                                specify)</label>
                                        </div>
                                    </div>
                                    <div class="mt-3" id="problem_other_specify" style="display:none;">
                                        <label class="form-label">Please specify:</label>
                                        <textarea class="form-control" name="nature_of_problem_other"
                                            id="nature_of_problem_other" placeholder="Enter details" rows="3"
                                            style="resize:vertical;"></textarea>
                                    </div>
                                </div>

                                <!-- Appointment Type Section -->
                                <div class="mt-5">
                                    <h5 class="mb-3"><i class="bi bi-tag me-2"></i>Appointment Type</h5>
                                    <p class="text-muted mb-3">Please select the type of appointment</p>
                                    <div class="nature-problem-options">
                                        <div class="form-check-square">
                                            <input class="form-check-input" type="radio" name="appointment_type"
                                                id="type_walk_in" value="Walk-in" required>
                                            <label class="form-check-label" for="type_walk_in">Walk-in</label>
                                        </div>
                                        <div class="form-check-square">
                                            <input class="form-check-input" type="radio" name="appointment_type"
                                                id="type_called_in" value="Called-in" required>
                                            <label class="form-check-label" for="type_called_in">Called-in</label>
                                        </div>
                                        <div class="form-check-square">
                                            <input class="form-check-input" type="radio" name="appointment_type"
                                                id="type_referral" value="Referral" required>
                                            <label class="form-check-label" for="type_referral">Referral</label>
                                        </div>
                                    </div>
                                    <div class="mt-3" id="referral_reason_container" style="display:none;">
                                        <label class="form-label">Reason for Referral <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" name="referral_reason" id="referral_reason"
                                            placeholder="Please state the reason for referral..." rows="3"
                                            style="resize:vertical;"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Counselor Selection (formerly Step 3) -->
                            <div class="step-content" id="step-2" style="display: none;">
                                <div class="counselor-selection-wrapper">
                                    <div class="counselor-selection-header">
                                        <h3>Select Your Counselor</h3>
                                        <p>Choose a counselor to view their available dates and times</p>
                                    </div>
                                    <div class="counselor-grid">
                                        <?php $__currentLoopData = $counselors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counselor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="counselor-card" data-counselor-id="<?php echo e($counselor->id); ?>">
                                                <div class="counselor-avatar">
                                                    <img src="<?php echo e($counselor->avatar_url ?? 'https://via.placeholder.com/80x80/228B22/FFFFFF?text=' . substr($counselor->name, 0, 2)); ?>"
                                                        alt="<?php echo e($counselor->name); ?>">
                                                </div>
                                                <div class="counselor-info">
                                                    <h4><?php echo e($counselor->name); ?></h4>
                                                    <p class="specialization">
                                                        <?php echo e($counselor->specialization ?? 'General Counseling'); ?>

                                                    </p>
                                                    <div class="counselor-stats">
                                                        <span class="stat">
                                                            <i class="bi bi-star-fill"></i>
                                                            4.8
                                                        </span>
                                                        <span class="stat">
                                                            <i class="bi bi-people"></i>
                                                            150+ sessions
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="counselor-select">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <input type="hidden" name="counselor_id" id="selectedCounselorId">
                                </div>
                            </div>

                            <!-- Step 3: Date Selection (formerly Step 4) -->
                            <div class="step-content" id="step-3" style="display: none;">
                                <div class="calendar-wrapper">
                                    <div class="calendar-header">
                                        <h3>Select Date</h3>
                                        <p>Choose a date for your appointment</p>
                                    </div>
                                    <div class="calendar-container">
                                        <div class="calendar-nav">
                                            <button class="calendar-nav-btn" id="prevMonth">
                                                <i class="bi bi-chevron-left"></i>
                                            </button>
                                            <h4 id="currentMonth">July 2025</h4>
                                            <button class="calendar-nav-btn" id="nextMonth">
                                                <i class="bi bi-chevron-right"></i>
                                            </button>
                                        </div>
                                        <div class="calendar-grid">
                                            <div class="calendar-weekdays">
                                                <div>Sun</div>
                                                <div>Mon</div>
                                                <div>Tue</div>
                                                <div>Wed</div>
                                                <div>Thu</div>
                                                <div>Fri</div>
                                                <div>Sat</div>
                                            </div>
                                            <div class="calendar-days" id="calendarDays">
                                                <!-- Calendar days will be generated here -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Time Slots Section (shown after date selection) -->
                                    <div class="time-slots-wrapper" id="timeSlotsWrapper"
                                        style="display: none; margin-top: 2rem;">
                                        <div class="time-slots-header">
                                            <div class="time-slots-title">Available Time Slots</div>
                                            <div class="selected-counselor-info">
                                                <i class="bi bi-person-badge me-2"></i>
                                                <span id="selectedCounselorName">Select a counselor</span>
                                                <span class="selected-date" id="selectedDate"></span>
                                            </div>
                                        </div>
                                        <div class="time-slots-grid" id="timeSlotsGrid">
                                            <!-- Time slots will be loaded here -->
                                        </div>
                                        <div class="time-slots-loading" id="timeSlotsLoading" style="display: none;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p>Loading available time slots...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Confirmation (formerly Step 5) -->
                            <div class="step-content" id="step-4" style="display: none;">
                                <div class="appointment-summary">
                                    <div class="summary-header">
                                        <div class="summary-title">Appointment Summary</div>
                                        <button class="btn-outline" id="editAppointment" type="button">
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </button>
                                    </div>
                                    <div class="summary-details">
                                        <div class="summary-item">
                                            <i class="bi bi-calendar"></i>
                                            <div>
                                                <div class="label">Date</div>
                                                <div class="value" id="summaryDate">Select a date</div>
                                            </div>
                                        </div>
                                        <div class="summary-item">
                                            <i class="bi bi-clock"></i>
                                            <div>
                                                <div class="label">Time</div>
                                                <div class="value" id="summaryTime">Select a time</div>
                                            </div>
                                        </div>
                                        <div class="summary-item">
                                            <i class="bi bi-person-badge"></i>
                                            <div>
                                                <div class="label">Counselor</div>
                                                <div class="value" id="summaryCounselor">Select a counselor</div>
                                            </div>
                                        </div>
                                        <div class="summary-item">
                                            <i class="bi bi-question-circle"></i>
                                            <div>
                                                <div class="label">Nature of Problem</div>
                                                <div class="value" id="summaryNatureOfProblem">Not selected</div>
                                            </div>
                                        </div>
                                        <div class="summary-item">
                                            <i class="bi bi-tag"></i>
                                            <div>
                                                <div class="label">Appointment Type</div>
                                                <div class="value" id="summaryAppointmentType">Not selected</div>
                                            </div>
                                        </div>
                                        <div class="summary-item" id="summaryReferralReasonContainer" style="display:none;">
                                            <i class="bi bi-info-circle"></i>
                                            <div>
                                                <div class="label">Reason for Referral</div>
                                                <div class="value" id="summaryReferralReason">Not provided</div>
                                            </div>
                                        </div>
                                        <div class="summary-item">
                                            <i class="bi bi-people"></i>
                                            <div>
                                                <div class="label">Guardian 1</div>
                                                <div class="value" id="summaryGuardian1">Not provided</div>
                                            </div>
                                        </div>
                                        <div class="summary-item align-items-center">
                                            <i class="bi bi-journal-text mt-0"></i>
                                            <div class="d-flex align-items-center flex-grow-1">
                                                <div class="label mb-0 me-3" style="white-space: nowrap; min-width: 140px;">
                                                    Notes (Optional)</div>
                                                <textarea id="appointmentNotes" name="notes" class="form-control" rows="2"
                                                    placeholder="Any specific concerns or topics you'd like to discuss..."
                                                    style="resize: vertical;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden field for scheduled_at -->
                            <input type="hidden" name="scheduled_at" id="scheduled_at">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="appointmentConfirmModal" tabindex="-1" aria-labelledby="appointmentConfirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentConfirmModalLabel">Confirm Appointment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Counselor:</strong> <span id="modalCounselor"></span></li>
                            <li class="list-group-item"><strong>Date:</strong> <span id="modalDate"></span></li>
                            <li class="list-group-item"><strong>Time:</strong> <span id="modalTime"></span></li>
                            <li class="list-group-item"><strong>Session Type:</strong> <span id="modalType"></span></li>
                            <li class="list-group-item"><strong>Notes:</strong> <span id="modalNotes"></span></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmSubmitAppointment">Confirm &
                            Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="scheduler-actions">
            <button class="btn btn-outline" id="backButton" type="button">
                <i class="bi bi-arrow-left"></i>
                Back
            </button>
            <button class="btn btn-primary" id="nextButton" type="button">
                <span id="nextButtonText">Next</span>
                <i class="bi bi-arrow-right" id="nextButtonIcon"></i>
            </button>
        </div>
    </div>
    </div>
    </div>
    </div>

    <style>
        /* Additional styles for appointment booking */
        :root {
            --border-color: #e9ecef;
        }

        .appointment-booking-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
            padding-bottom: 8rem;
            /* Space for fixed bottom buttons */
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
        }

        .booking-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(0, 0, 0, 0.06);
        }

        .booking-header h2 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .form-section {
            background: var(--bg-light);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--gray-100);
            box-shadow: var(--shadow-sm);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--forest-green);
        }

        .section-header h3 {
            color: var(--text-dark);
            font-weight: 700;
            margin: 0;
        }

        .guardian-section {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid var(--gray-100);
        }

        .guardian-title {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .nature-problem-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .form-check-square {
            background: var(--white);
            border: 2px solid var(--gray-100);
            border-radius: 8px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .form-check-square:hover {
            border-color: var(--forest-green);
            background: var(--light-green);
        }

        .form-check-square input[type="radio"] {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            cursor: pointer;
        }

        .form-check-square input[type="radio"]:checked+label {
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-check-square:has(input[type="radio"]:checked) {
            border-color: var(--forest-green);
            background: var(--light-green);
        }

        .form-check-label {
            cursor: pointer;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e0e0e0;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--gray-100);
            border-radius: 8px;
            padding: 0.625rem 0.75rem;
            transition: all 0.2s ease;
            font-size: 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--forest-green);
            box-shadow: 0 0 0 0.2rem rgba(31, 122, 45, 0.15);
            outline: none;
        }

        .form-control:read-only {
            background-color: var(--bg-light);
            cursor: not-allowed;
            border-color: rgba(0, 0, 0, 0.06);
        }

        .scheduler-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0 0 100px 0;
            background: transparent;
        }

        /* Header Styles */
        .scheduler-header {
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
        }

        .scheduler-header h3 {
            color: var(--forest-green);
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.4rem;
        }

        .scheduler-nav {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .nav-step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: 2px solid var(--border-color);
            background: var(--white);
            color: var(--text-dark);
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .nav-step.active {
            background: var(--forest-green);
            color: var(--white);
            border-color: var(--forest-green);
        }

        .nav-step:hover:not(.active) {
            border-color: var(--forest-green);
            color: var(--forest-green);
        }

        /* Step Content Styles */
        .step-content {
            background: var(--white);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
        }

        /* Counselor Selection Styles */
        .counselor-selection-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .counselor-selection-header h3 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .counselor-selection-header p {
            color: var(--text-light);
            margin: 0;
        }

        .counselor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .counselor-card {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            border: 2px solid rgba(0, 0, 0, 0.06);
            border-radius: 16px;
            cursor: pointer;
            background: var(--white);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            position: relative;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .counselor-card:hover {
            border-color: var(--forest-green);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .counselor-card.selected {
            border-color: var(--forest-green);
            background: var(--light-green);
            box-shadow: var(--shadow-md);
        }

        .counselor-avatar {
            margin-right: 1rem;
        }

        .counselor-avatar img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--forest-green);
        }

        .counselor-info {
            flex: 1;
        }

        .counselor-info h4 {
            margin: 0 0 0.25rem 0;
            color: var(--text-dark);
            font-weight: 600;
        }

        .specialization {
            color: #6c757d;
            margin: 0 0 0.5rem 0;
            font-size: 0.9rem;
        }

        .counselor-stats {
            display: flex;
            gap: 1rem;
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.8rem;
            color: #6c757d;
        }

        .stat i {
            color: var(--yellow-maize);
        }

        .counselor-select {
            position: absolute;
            top: 1rem;
            right: 1rem;
            color: var(--forest-green);
            font-size: 1.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .counselor-card.selected .counselor-select {
            opacity: 1;
        }

        /* Calendar Styles */
        .calendar-header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .calendar-header h3 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-size: 1.5rem;
        }

        .calendar-header p {
            color: var(--text-light);
            margin: 0;
            font-size: 0.95rem;
        }

        .calendar-container {
            max-width: 650px;
            margin: 0 auto;
        }

        .calendar-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            background: var(--light-gray);
            border-radius: 10px;
        }

        .calendar-nav h4 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-dark);
            min-width: 150px;
            text-align: center;
        }

        .calendar-nav-btn {
            background: var(--white);
            border: 2px solid var(--forest-green);
            font-size: 1.2rem;
            color: var(--forest-green);
            cursor: pointer;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
            min-width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .calendar-nav-btn:hover {
            background: var(--forest-green);
            color: var(--white);
        }

        .calendar-nav-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(34, 139, 34, 0.2);
        }

        .calendar-grid {
            border: 1px solid var(--gray-100);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            max-width: 650px;
            margin: 0 auto;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: var(--forest-green);
            color: var(--white);
            font-weight: 600;
            text-align: center;
            padding: 0.75rem 0;
            font-size: 0.9rem;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: var(--white);
            gap: 0;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
            position: relative;
            font-size: 0.95rem;
            font-weight: 500;
            min-height: 55px;
        }

        .calendar-day:hover:not(.disabled) {
            background: var(--light-green);
            transform: scale(1.05);
            z-index: 1;
        }

        .calendar-day.available {
            background: var(--yellow-maize-light);
            color: var(--text-dark);
            font-weight: 600;
            box-shadow: inset 0 0 0 2px var(--accent-orange);
        }

        .calendar-day.available:hover {
            background: var(--accent-orange);
            color: var(--white);
        }

        .calendar-day.selected {
            background: var(--forest-green);
            color: var(--white);
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(31, 122, 45, 0.3);
        }

        .calendar-day.disabled {
            color: #d0d0d0;
            cursor: not-allowed;
            background: #f9f9f9;
        }

        /* Time Slots Styles */
        .time-slots-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .time-slots-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .selected-counselor-info {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .time-slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }

        .time-slot {
            padding: 1rem;
            border: 1px solid var(--gray-100);
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .time-slot:hover {
            border-color: var(--forest-green);
        }

        .time-slot.selected {
            background: var(--forest-green);
            color: var(--white);
            border-color: var(--forest-green);
        }

        .time-slot.disabled {
            background: #f8f9fa;
            color: #ccc;
            cursor: not-allowed;
        }

        /* Summary Styles */
        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-100);
        }

        .summary-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .summary-details {
            display: grid;
            gap: 1.5rem;
        }

        .summary-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem;
            border: 1px solid var(--gray-100);
            border-radius: 12px;
            background: var(--white);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .summary-item:hover {
            box-shadow: var(--shadow-md);
        }

        .summary-item i {
            color: var(--forest-green);
            font-size: 1.2rem;
            margin-top: 0.25rem;
        }

        .summary-item .label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .summary-item .value {
            color: #6c757d;
        }

        /* Loading States */
        .time-slots-loading {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .spinner-border {
            width: 2rem;
            height: 2rem;
            margin-bottom: 1rem;
        }

        /* Action Buttons */
        .scheduler-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            background: var(--white);
            border-top: 1px solid var(--gray-100);
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
            position: fixed;
            bottom: 0;
            left: 240px;
            right: 0;
            z-index: 1000;
            margin: 0;
            pointer-events: auto;
        }

        .scheduler-actions button {
            pointer-events: auto !important;
            z-index: 1001;
            position: relative;
        }

        /* Ensure Next button is always visible on the right */
        #nextButton {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
            margin-left: auto !important;
            order: 2;
            flex-shrink: 0;
        }

        /* Back button on the left */
        #backButton {
            order: 1;
            flex-shrink: 0;
        }

        /* Hide Back button when on first step */
        #backButton[style*="display: none"] {
            display: none !important;
        }

        /* Ensure scheduler-actions maintains proper layout */
        .scheduler-actions {
            gap: 1rem;
        }

        @media (max-width: 991.98px) {
            .scheduler-actions {
                left: 0;
                padding: 1rem 1.5rem;
            }
        }

        .btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-outline {
            background: var(--white);
            color: var(--forest-green);
            border: 1px solid var(--gray-100);
        }

        .btn-outline:hover {
            background: var(--forest-green);
            color: var(--white);
            border-color: var(--forest-green);
        }

        .btn-primary {
            background: var(--forest-green);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--forest-green-dark);
        }

        .btn-primary:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            opacity: 0.6;
        }

        .spin-animation {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .btn-primary {
            pointer-events: auto !important;
            cursor: pointer !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .scheduler-container {
                padding: 1rem;
            }

            .scheduler-nav {
                flex-direction: column;
            }

            .counselor-grid {
                grid-template-columns: 1fr;
            }

            .time-slots-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .scheduler-actions {
                background: var(--white);
                padding: 1rem;
                gap: 0.75rem;
                display: flex;
                flex-direction: row !important;
                justify-content: space-between;
                align-items: center;
            }

            .scheduler-actions button {
                flex: 1;
                justify-content: center;
                max-width: 48%;
            }

            .calendar-day {
                min-height: 50px;
                font-size: 0.9rem;
            }

            .calendar-weekdays {
                font-size: 0.85rem;
                padding: 0.75rem 0;
            }

            .calendar-nav h4 {
                font-size: 1.1rem;
            }
        }
    </style>

    <script>
        // Make these variables global
        let selectedCounselor = null;
        let selectedDate = null;
        let selectedTime = null;
        let selectedSlot = null; // Store the full slot object

        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM Content Loaded - Appointment Scheduler');

            let currentStep = 1;

            // Form data persistence
            const STORAGE_KEY = 'appointment_form_data';

            function saveFormData() {
                const formData = {
                    currentStep: currentStep,
                    guardian1_name: document.querySelector('input[name="guardian1_name"]')?.value || '',
                    guardian1_relationship: document.querySelector('select[name="guardian1_relationship"]')?.value || '',
                    guardian1_contact: document.querySelector('input[name="guardian1_contact"]')?.value || '',
                    guardian1_relationship_other: document.querySelector('input[name="guardian1_relationship_other"]')?.value || '',
                    guardian2_name: document.querySelector('input[name="guardian2_name"]')?.value || '',
                    guardian2_relationship: document.querySelector('select[name="guardian2_relationship"]')?.value || '',
                    guardian2_contact: document.querySelector('input[name="guardian2_contact"]')?.value || '',
                    guardian2_relationship_other: document.querySelector('input[name="guardian2_relationship_other"]')?.value || '',
                    nature_of_problem: document.querySelector('input[name="nature_of_problem"]:checked')?.value || '',
                    nature_of_problem_other: document.querySelector('textarea[name="nature_of_problem_other"]')?.value || '',
                    appointment_type: document.querySelector('input[name="appointment_type"]:checked')?.value || '',
                    referral_reason: document.querySelector('textarea[name="referral_reason"]')?.value || '',
                    selectedCounselor: selectedCounselor,
                    selectedDate: selectedDate,
                    selectedTime: selectedTime,
                    selectedSlot: selectedSlot,
                    notes: document.querySelector('textarea[name="notes"]')?.value || ''
                };
                localStorage.setItem(STORAGE_KEY, JSON.stringify(formData));
                console.log('Form data saved to localStorage');
            }

            function restoreFormData() {
                const savedData = localStorage.getItem(STORAGE_KEY);
                if (!savedData) return;

                try {
                    const formData = JSON.parse(savedData);
                    console.log('Restoring form data:', formData);

                    // Restore text inputs
                    if (formData.guardian1_name) document.querySelector('input[name="guardian1_name"]').value = formData.guardian1_name;
                    if (formData.guardian1_contact) document.querySelector('input[name="guardian1_contact"]').value = formData.guardian1_contact;
                    if (formData.guardian1_relationship_other) document.querySelector('input[name="guardian1_relationship_other"]').value = formData.guardian1_relationship_other;
                    if (formData.guardian2_name) document.querySelector('input[name="guardian2_name"]').value = formData.guardian2_name;
                    if (formData.guardian2_contact) document.querySelector('input[name="guardian2_contact"]').value = formData.guardian2_contact;
                    if (formData.guardian2_relationship_other) document.querySelector('input[name="guardian2_relationship_other"]').value = formData.guardian2_relationship_other;
                    if (formData.nature_of_problem_other) document.querySelector('textarea[name="nature_of_problem_other"]').value = formData.nature_of_problem_other;
                    if (formData.referral_reason) document.querySelector('textarea[name="referral_reason"]').value = formData.referral_reason;
                    if (formData.notes) document.querySelector('textarea[name="notes"]').value = formData.notes;

                    // Restore selects
                    if (formData.guardian1_relationship) document.querySelector('select[name="guardian1_relationship"]').value = formData.guardian1_relationship;
                    if (formData.guardian2_relationship) document.querySelector('select[name="guardian2_relationship"]').value = formData.guardian2_relationship;

                    // Restore radio buttons
                    if (formData.nature_of_problem) {
                        const radio = document.querySelector(`input[name="nature_of_problem"][value="${formData.nature_of_problem}"]`);
                        if (radio) radio.checked = true;
                    }
                    if (formData.appointment_type) {
                        const radio = document.querySelector(`input[name="appointment_type"][value="${formData.appointment_type}"]`);
                        if (radio) radio.checked = true;
                    }

                    // Restore global variables
                    if (formData.selectedCounselor) selectedCounselor = formData.selectedCounselor;
                    if (formData.selectedDate) selectedDate = new Date(formData.selectedDate);
                    if (formData.selectedTime) selectedTime = formData.selectedTime;
                    if (formData.selectedSlot) selectedSlot = formData.selectedSlot;

                    // Sync hidden fields with restored global variables
                    syncHiddenFields();

                    // Trigger change events to show conditional fields
                    document.querySelectorAll('input[name="nature_of_problem"]:checked, input[name="appointment_type"]:checked, select[name="guardian1_relationship"], select[name="guardian2_relationship"]').forEach(el => {
                        el.dispatchEvent(new Event('change'));
                    });

                    // Restore step
                    if (formData.currentStep && formData.currentStep > 1) {
                        currentStep = formData.currentStep;
                        showStep(currentStep);

                        // Restore counselor card selection visual state
                        if (selectedCounselor && selectedCounselor.id) {
                            setTimeout(() => {
                                const counselorCard = document.querySelector(`[data-counselor-id="${selectedCounselor.id}"]`);
                                if (counselorCard) {
                                    counselorCard.classList.add('selected');
                                }
                                // Update counselor info display
                                if (typeof updateCounselorInfo === 'function') {
                                    updateCounselorInfo();
                                }
                            }, 100);
                        }

                        // Reload calendar if on step 3 and counselor is selected
                        if (currentStep === 3 && selectedCounselor) {
                            setTimeout(() => {
                                loadAvailableDates(true); // TRUE to preserve selectedDate/selectedTime

                                // If a date was previously selected, show its time slots
                                if (selectedDate) {
                                    const timeSlotsWrapper = document.getElementById('timeSlotsWrapper');
                                    if (timeSlotsWrapper) {
                                        timeSlotsWrapper.style.display = 'block';
                                    }
                                    loadTimeSlots();
                                }
                            }, 500);
                        }

                        // Update summary if on confirmation step
                        if (currentStep === 4) {
                            setTimeout(() => {
                                updateSummary();
                            }, 500);
                        }
                    }

                    Swal.fire({
                        icon: 'info',
                        title: 'Progress Restored',
                        text: 'Your previous form data has been restored.',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } catch (e) {
                    console.error('Error restoring form data:', e);
                }
            }

            // Restore data on page load
            restoreFormData();

            // Auto-save on input changes
            document.querySelectorAll('input, select, textarea').forEach(element => {
                element.addEventListener('change', saveFormData);
                element.addEventListener('input', saveFormData);
            });

            // Simple step navigation
            function showStep(step) {
                console.log('Showing step:', step);

                // Hide all steps
                document.querySelectorAll('.step-content').forEach(el => {
                    el.style.display = 'none';
                });

                // Show the target step
                const stepElement = document.getElementById(`step-${step}`);
                if (stepElement) {
                    stepElement.style.display = 'block';
                    console.log('Step element displayed');
                }

                // Update navigation
                document.querySelectorAll('.nav-step').forEach(el => {
                    el.classList.remove('active');
                });

                const navStep = document.querySelector(`[data-step="${step}"]`);
                if (navStep) {
                    navStep.classList.add('active');
                }

                currentStep = step;
                saveFormData(); // Save progress when step changes
                updateButtons();
                updateActionButtonsForStep(step); // Call the new function here

                // Reload calendar if on step 3 and counselor is selected
                if (currentStep === 3 && selectedCounselor) {
                    loadAvailableDates(true); // Preserve existing selection if any
                }
            }

            function updateButtons() {
                const backBtn = document.getElementById('backButton');
                const nextBtn = document.getElementById('nextButton');

                if (backBtn) {
                    backBtn.style.display = currentStep === 1 ? 'none' : 'flex';
                    backBtn.disabled = false;
                    backBtn.style.pointerEvents = 'auto';
                }

                if (nextBtn) {
                    // Always ensure Next button is visible and on the right
                    nextBtn.style.display = 'flex';
                    nextBtn.style.visibility = 'visible';
                    nextBtn.style.marginLeft = 'auto';
                    nextBtn.disabled = false;
                    nextBtn.style.pointerEvents = 'auto';
                    nextBtn.style.cursor = 'pointer';
                    // Show visual feedback if can't proceed
                    if (!canProceed()) {
                        nextBtn.style.opacity = '0.6';
                    } else {
                        nextBtn.style.opacity = '1';
                    }
                }
            }

            function canProceed() {
                switch (currentStep) {
                    case 1:
                        // Check guardian 1 fields
                        const guardian1Name = document.querySelector('input[name="guardian1_name"]')?.value;
                        const guardian1Relationship = document.querySelector('select[name="guardian1_relationship"]')?.value;
                        const guardian1Contact = document.querySelector('input[name="guardian1_contact"]')?.value;

                        console.log('Step 1 validation:', {
                            guardian1Name,
                            guardian1Relationship,
                            guardian1Contact
                        });

                        if (!guardian1Name || !guardian1Relationship || !guardian1Contact) {
                            console.log('Missing guardian 1 info');
                            return false;
                        }

                        // Check nature of problem
                        const natureOfProblem = document.querySelector('input[name="nature_of_problem"]:checked')?.value;
                        console.log('Nature of problem:', natureOfProblem);

                        if (!natureOfProblem) {
                            console.log('Missing nature of problem');
                            return false;
                        }
                        if (natureOfProblem === 'Other') {
                            const otherSpecify = document.querySelector('[name="nature_of_problem_other"]')?.value;
                            if (!otherSpecify || otherSpecify.trim() === '') {
                                console.log('Missing nature of problem other');
                                return false;
                            }
                        }

                        // Check appointment type
                        const appointmentType = document.querySelector('input[name="appointment_type"]:checked')?.value;
                        console.log('Appointment type:', appointmentType);

                        if (!appointmentType) {
                            console.log('Missing appointment type');
                            return false;
                        }
                        if (appointmentType === 'Referral') {
                            const referralReason = document.querySelector('[name="referral_reason"]')?.value;
                            if (!referralReason || referralReason.trim() === '') {
                                console.log('Missing referral reason');
                                return false;
                            }
                        }

                        console.log('Step 1 validation passed!');
                        return true;
                    case 2: return selectedCounselor !== null;
                    case 3: return selectedDate !== null && selectedTime !== null;
                    case 4: return true;
                    default: return false;
                }
            }

            // Counselor selection
            console.log('Setting up counselor selection...');
            const counselorCards = document.querySelectorAll('.counselor-card');
            console.log('Found counselor cards:', counselorCards.length);

            counselorCards.forEach((card, index) => {
                console.log(`Setting up card ${index}:`, card);

                card.addEventListener('click', function (e) {
                    console.log('Counselor card clicked!');

                    e.preventDefault();
                    e.stopPropagation();

                    // Remove selection from all cards
                    document.querySelectorAll('.counselor-card').forEach(c => {
                        c.classList.remove('selected');
                    });

                    // Select this card
                    this.classList.add('selected');

                    // Store counselor data
                    selectedCounselor = {
                        id: this.dataset.counselorId,
                        name: this.querySelector('h4').textContent
                    };

                    console.log('Selected counselor:', selectedCounselor);

                    // Update counselor info immediately
                    updateCounselorInfo();

                    // Update hidden field
                    syncHiddenFields();
                    updateButtons();
                });
            });

            function syncHiddenFields() {
                const counselorField = document.getElementById('selectedCounselorId');
                const scheduledAtField = document.getElementById('scheduled_at');

                if (counselorField && selectedCounselor) {
                    counselorField.value = selectedCounselor.id;
                }
                if (scheduledAtField && selectedTime) {
                    scheduledAtField.value = selectedTime;
                }
            }

            // Navigation buttons
            const backButton = document.getElementById('backButton');
            const nextButton = document.getElementById('nextButton');

            if (backButton) {
                backButton.addEventListener('click', function () {
                    console.log('Back button clicked');
                    if (currentStep > 1) {
                        showStep(currentStep - 1);
                    }
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Next button clicked, current step:', currentStep);

                    if (!canProceed()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Incomplete Form',
                            text: 'Please complete all required fields before proceeding.',
                            confirmButtonColor: '#1f7a2d'
                        });
                        return false;
                    }

                    if (currentStep === 2 && selectedCounselor) {
                        // Load available dates when moving from counselor selection to date selection
                        loadAvailableDates();
                    }

                    if (currentStep === 3 && selectedTime) {
                        // Update summary when moving to confirmation
                        updateSummary();
                    }

                    if (currentStep < 4) {
                        showStep(currentStep + 1);
                    } else if (currentStep === 4) {
                        // Ensure scheduled_at is set before submitting
                        const scheduledAtField = document.getElementById('scheduled_at');
                        if (!scheduledAtField.value && selectedTime) {
                            scheduledAtField.value = selectedTime;
                        }

                        // Validate that scheduled_at is set
                        if (!scheduledAtField.value) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Missing Information',
                                text: 'Please select a date and time for your appointment.',
                                confirmButtonColor: '#1f7a2d'
                            });
                            return false;
                        }

                        // Show loading state
                        const nextBtnText = document.getElementById('nextButtonText');
                        const nextBtnIcon = document.getElementById('nextButtonIcon');

                        if (nextBtnText) nextBtnText.textContent = 'Submitting...';
                        if (nextBtnIcon) {
                            nextBtnIcon.className = 'bi bi-arrow-repeat spin-animation ms-2';
                        }
                        nextButton.disabled = true;
                        nextButton.style.opacity = '0.7';
                        nextButton.style.cursor = 'not-allowed';

                        // Submit form on last step
                        console.log('Submitting form with scheduled_at:', scheduledAtField.value);
                        // REMOVED: localStorage.removeItem(STORAGE_KEY); 
                        // This will be cleared on the confirmation page or success AJAX to allow recovery on validation errors

                        document.getElementById('appointmentBookingForm').submit();
                    }
                    return false;
                });
            }

            // Edit appointment
            const editAppointmentBtn = document.getElementById('editAppointment');
            if (editAppointmentBtn) {
                editAppointmentBtn.addEventListener('click', function () {
                    console.log('Edit button clicked');
                    showStep(1);
                    // Reset selections
                    selectedCounselor = null;
                    selectedDate = null;
                    selectedTime = null;
                    selectedSlot = null; // Reset selectedSlot
                    document.querySelectorAll('.counselor-card').forEach(c => {
                        c.classList.remove('selected');
                    });
                    updateButtons();
                });
            }

            // Load available dates for selected counselor
            function loadAvailableDates(preserveSelection = false) {
                if (!selectedCounselor) {
                    console.log('No counselor selected, skipping date loading');
                    return;
                }

                console.log('Loading available dates for counselor:', selectedCounselor.id);

                // Hide time slots when counselor/available dates change
                const timeSlotsWrapper = document.getElementById('timeSlotsWrapper');
                if (timeSlotsWrapper && !preserveSelection) {
                    timeSlotsWrapper.style.display = 'none';
                }
                if (!preserveSelection) {
                    // Only reset if NOT preserving (i.e. user explicitly clicked a counselor)
                    selectedDate = null;
                    selectedTime = null;
                    selectedSlot = null;
                }

                fetch(`/appointments/available-slots/${selectedCounselor.id}`)
                    .then(res => res.json())
                    .then(slots => {
                        console.log('Received slots:', slots);
                        // Extract unique dates from slots
                        const availableDates = [...new Set(slots.map(slot =>
                            slot.start.split('T')[0]
                        ))].sort();

                        console.log('Available dates:', availableDates);
                        renderCalendar(availableDates);
                    })
                    .catch((error) => {
                        console.error('Error loading available dates:', error);
                        renderCalendar([]);
                    });
            }

            // Global variables for calendar navigation
            let currentCalendarDate = new Date();
            let availableDates = [];

            // Initialize calendar navigation
            function initializeCalendarNavigation() {
                const prevBtn = document.getElementById('prevMonth');
                const nextBtn = document.getElementById('nextMonth');

                if (prevBtn) {
                    prevBtn.addEventListener('click', () => {
                        currentCalendarDate.setMonth(currentCalendarDate.getMonth() - 1);
                        renderCalendar(availableDates);
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        currentCalendarDate.setMonth(currentCalendarDate.getMonth() + 1);
                        renderCalendar(availableDates);
                    });
                }
            }

            // Dynamic calendar rendering
            function renderCalendar(dates) {
                const calendarDays = document.getElementById('calendarDays');
                if (!calendarDays) {
                    console.log('Calendar days element not found');
                    return;
                }

                // Store available dates globally
                availableDates = dates || [];

                const currentMonth = currentCalendarDate.getMonth();
                const currentYear = currentCalendarDate.getFullYear();
                const today = new Date();

                // Update month display
                const monthElement = document.getElementById('currentMonth');
                if (monthElement) {
                    monthElement.textContent = currentCalendarDate.toLocaleDateString('en-US', {
                        month: 'long',
                        year: 'numeric'
                    });
                }

                // Clear calendar
                calendarDays.innerHTML = '';

                // Get first day of month and number of days
                const firstDay = new Date(currentYear, currentMonth, 1);
                const lastDay = new Date(currentYear, currentMonth + 1, 0);
                const startDate = new Date(firstDay);
                startDate.setDate(startDate.getDate() - firstDay.getDay());

                // Generate calendar days
                for (let i = 0; i < 42; i++) {
                    const date = new Date(startDate);
                    date.setDate(startDate.getDate() + i);

                    const dayElement = document.createElement('div');
                    dayElement.className = 'calendar-day';
                    dayElement.textContent = date.getDate();

                    // Check if date is in current month
                    if (date.getMonth() !== currentMonth) {
                        dayElement.classList.add('disabled');
                    } else if (date >= today) {
                        // Check if date is available (use local date, not UTC)
                        const dateStr = date.toLocaleDateString('en-CA'); // Returns YYYY-MM-DD format
                        if (availableDates.includes(dateStr)) {
                            dayElement.classList.add('available');
                            dayElement.addEventListener('click', () => selectDate(date));
                        } else {
                            dayElement.classList.add('disabled');
                        }
                    } else {
                        // Past dates
                        dayElement.classList.add('disabled');
                    }

                    // Highlight selected date
                    if (selectedDate && date.toDateString() === selectedDate.toDateString()) {
                        dayElement.classList.add('selected');
                    }

                    calendarDays.appendChild(dayElement);
                }
            }

            function selectDate(date) {
                console.log('Date selected:', date);
                selectedDate = date;

                // Update visual selection
                document.querySelectorAll('.calendar-day').forEach(day => {
                    day.classList.remove('selected');
                });
                // Use the passed event or currentTarget if possible, otherwise find the element
                if (window.event && window.event.currentTarget) {
                    window.event.currentTarget.classList.add('selected');
                }

                // Update counselor name in time selection step
                updateCounselorInfo();

                // Show time slots in the same step
                const timeSlotsWrapper = document.getElementById('timeSlotsWrapper');
                if (timeSlotsWrapper) {
                    timeSlotsWrapper.style.display = 'block';
                    // Scroll to time slots
                    timeSlotsWrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

                loadTimeSlots();
                saveFormData();
                updateButtons();
            }

            // Load time slots for selected date
            function loadTimeSlots() {
                if (!selectedCounselor || !selectedDate) {
                    console.log('Missing counselor or date');
                    return;
                }

                console.log('Loading time slots for date:', selectedDate);

                const loading = document.getElementById('timeSlotsLoading');
                const grid = document.getElementById('timeSlotsGrid');

                if (loading) loading.style.display = 'block';
                if (grid) grid.innerHTML = '';

                // Format date for API (use local date, not UTC)
                const dateStr = selectedDate.toLocaleDateString('en-CA'); // Returns YYYY-MM-DD format

                fetch(`/appointments/available-slots/${selectedCounselor.id}`)
                    .then(res => res.json())
                    .then(slots => {
                        if (loading) loading.style.display = 'none';

                        console.log('All slots received:', slots);
                        console.log('Looking for date:', dateStr);

                        const daySlots = slots.filter(slot => {
                            const slotDate = slot.start.split('T')[0];
                            console.log('Checking slot:', slot, 'date part:', slotDate, 'matches:', slotDate === dateStr);
                            return slotDate === dateStr;
                        });

                        console.log('Filtered time slots for date:', daySlots);

                        if (!grid) return;

                        if (daySlots.length === 0) {
                            grid.innerHTML = '<div class="text-center text-muted">No available slots for this date</div>';
                            return;
                        }

                        // Sort slots by time
                        daySlots.sort();

                        daySlots.forEach(slot => {
                            const timeSlot = document.createElement('div');
                            timeSlot.className = 'time-slot';
                            if (slot.booked) {
                                timeSlot.classList.add('disabled');
                            }
                            // Parse the availability slot start and end times
                            const startDate = new Date(slot.start.replace('T', ' '));
                            const endDate = new Date(slot.end.replace('T', ' '));
                            const startTimeStr = startDate.toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true,
                                timeZone: 'Asia/Manila' // Use Philippine timezone
                            });
                            const endTimeStr = endDate.toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true,
                                timeZone: 'Asia/Manila' // Use Philippine timezone
                            });
                            timeSlot.textContent = `${startTimeStr} - ${endTimeStr}`;

                            // Highlight if this is the restored selected slot
                            if (selectedSlot && selectedSlot.start === slot.start) {
                                timeSlot.classList.add('selected');
                            }

                            if (!slot.booked) {
                                timeSlot.addEventListener('click', () => selectTimeSlot(timeSlot, slot));
                            }
                            grid.appendChild(timeSlot);
                        });
                    })
                    .catch((error) => {
                        console.error('Error loading time slots:', error);
                        if (loading) loading.style.display = 'none';
                        if (grid) grid.innerHTML = '<div class="text-center text-danger">Error loading time slots</div>';
                    });
            }

            function selectTimeSlot(element, slot) {
                console.log('Time slot selected:', slot);

                document.querySelectorAll('.time-slot').forEach(el => {
                    el.classList.remove('selected');
                });
                element.classList.add('selected');
                // Save the full slot object
                selectedSlot = slot;
                // For form submission, use slot.start (with timezone)
                let slotWithTZ = slot.start;
                if (!slotWithTZ.endsWith('+08:00') && !slotWithTZ.includes('+')) {
                    slotWithTZ = slotWithTZ + '+08:00';
                }
                selectedTime = slotWithTZ;

                // Update the hidden fields for form submission
                syncHiddenFields();

                saveFormData();
                updateButtons();
            }

            // Update counselor info in time selection step
            function updateCounselorInfo() {
                if (selectedCounselor) {
                    const selectedCounselorName = document.getElementById('selectedCounselorName');
                    if (selectedCounselorName) {
                        selectedCounselorName.textContent = selectedCounselor.name;
                    }
                }

                if (selectedDate) {
                    const selectedDateElement = document.getElementById('selectedDate');
                    if (selectedDateElement) {
                        selectedDateElement.textContent =
                            `- ${selectedDate.toLocaleDateString('en-US', {
                                month: 'long',
                                day: 'numeric',
                                year: 'numeric'
                            })}`;
                    }
                }
            }

            // Update summary with selected data
            function updateSummary() {
                // Update date
                if (selectedDate) {
                    const summaryDate = document.getElementById('summaryDate');
                    if (summaryDate) {
                        summaryDate.textContent = selectedDate.toLocaleDateString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    }
                }

                if (selectedSlot) {
                    const summaryTime = document.getElementById('summaryTime');
                    if (summaryTime) {
                        // Parse as Asia/Manila time
                        const slotStart = new Date(selectedSlot.start + (selectedSlot.start.endsWith('+08:00') ? '' : '+08:00'));
                        const slotEnd = new Date(selectedSlot.end + (selectedSlot.end.endsWith('+08:00') ? '' : '+08:00'));
                        const startTimeStr = slotStart.toLocaleTimeString('en-US', {
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true,
                            timeZone: 'Asia/Manila'
                        });
                        const endTimeStr = slotEnd.toLocaleTimeString('en-US', {
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true,
                            timeZone: 'Asia/Manila'
                        });
                        summaryTime.textContent = `${startTimeStr} - ${endTimeStr}`;
                    }
                }

                if (selectedCounselor) {
                    const summaryCounselor = document.getElementById('summaryCounselor');
                    const selectedCounselorName = document.getElementById('selectedCounselorName');
                    if (summaryCounselor) summaryCounselor.textContent = selectedCounselor.name;
                    if (selectedCounselorName) selectedCounselorName.textContent = selectedCounselor.name;
                }

                if (selectedDate) {
                    const selectedDateElement = document.getElementById('selectedDate');
                    if (selectedDateElement) {
                        selectedDateElement.textContent =
                            `- ${selectedDate.toLocaleDateString('en-US', {
                                month: 'long',
                                day: 'numeric',
                                year: 'numeric'
                            })}`;
                    }
                }

                // Update nature of problem
                const natureOfProblemRadio = document.querySelector('input[name="nature_of_problem"]:checked');
                const summaryNatureOfProblem = document.getElementById('summaryNatureOfProblem');
                if (summaryNatureOfProblem) {
                    if (natureOfProblemRadio) {
                        let natureOfProblem = natureOfProblemRadio.value;
                        // If "Other" is selected, append the specified text
                        if (natureOfProblem === 'Other') {
                            const otherSpecify = document.querySelector('[name="nature_of_problem_other"]')?.value;
                            if (otherSpecify && otherSpecify.trim() !== '') {
                                natureOfProblem = `Other: ${otherSpecify}`;
                            }
                        }
                        summaryNatureOfProblem.textContent = natureOfProblem;
                    } else {
                        summaryNatureOfProblem.textContent = 'Not selected';
                    }
                }

                // Update Appointment Type
                const appointmentTypeRadio = document.querySelector('input[name="appointment_type"]:checked');
                const summaryAppointmentType = document.getElementById('summaryAppointmentType');
                const summaryReferralReasonContainer = document.getElementById('summaryReferralReasonContainer');
                const summaryReferralReason = document.getElementById('summaryReferralReason');

                if (summaryAppointmentType) {
                    if (appointmentTypeRadio) {
                        summaryAppointmentType.textContent = appointmentTypeRadio.value;

                        if (appointmentTypeRadio.value === 'Referral') {
                            if (summaryReferralReasonContainer) summaryReferralReasonContainer.style.display = 'flex';
                            const referralReasonText = document.querySelector('[name="referral_reason"]')?.value;
                            if (summaryReferralReason) summaryReferralReason.textContent = referralReasonText || 'Not provided';
                        } else {
                            if (summaryReferralReasonContainer) summaryReferralReasonContainer.style.display = 'none';
                        }
                    } else {
                        summaryAppointmentType.textContent = 'Not selected';
                        if (summaryReferralReasonContainer) summaryReferralReasonContainer.style.display = 'none';
                    }
                }

                // Update Guardian 1 information
                const guardian1Name = document.querySelector('input[name="guardian1_name"]')?.value;
                const guardian1Relationship = document.querySelector('select[name="guardian1_relationship"]')?.value;
                const guardian1Contact = document.querySelector('input[name="guardian1_contact"]')?.value;
                const guardian1RelationshipOther = document.querySelector('input[name="guardian1_relationship_other"]')?.value;
                const summaryGuardian1 = document.getElementById('summaryGuardian1');

                if (summaryGuardian1) {
                    if (guardian1Name && guardian1Relationship && guardian1Contact) {
                        let relationship = guardian1Relationship;
                        // If relationship is "Other", use the specified text
                        if (guardian1Relationship === 'Other' && guardian1RelationshipOther && guardian1RelationshipOther.trim() !== '') {
                            relationship = guardian1RelationshipOther;
                        }
                        summaryGuardian1.textContent = `${guardian1Name} (${relationship}) - ${guardian1Contact}`;
                    } else {
                        summaryGuardian1.textContent = 'Not provided';
                    }
                }
            }

            // Initialize
            updateButtons();
            initializeCalendarNavigation();

            // Make sure buttons are clickable
            const nextBtnInit = document.getElementById('nextButton');
            const backBtnInit = document.getElementById('backButton');
            if (nextBtnInit) {
                nextBtnInit.style.pointerEvents = 'auto';
                nextBtnInit.style.cursor = 'pointer';
                nextBtnInit.removeAttribute('disabled');
            }
            if (backBtnInit) {
                backBtnInit.style.pointerEvents = 'auto';
                backBtnInit.style.cursor = 'pointer';
            }

            console.log('Appointment scheduler initialized');
            console.log('Next button:', nextBtnInit);
            console.log('Back button:', backBtnInit);
        });

        // Replace Next button with Submit on last step
        function updateActionButtonsForStep(step) {
            var nextBtn = document.getElementById('nextButton');
            if (!nextBtn) return;

            if (step === 4) {
                nextBtn.innerHTML = '<span id="nextButtonText">Submit</span><i class="bi bi-check-circle ms-2" id="nextButtonIcon"></i>';
            } else {
                nextBtn.innerHTML = '<span id="nextButtonText">Next</span><i class="bi bi-arrow-right" id="nextButtonIcon"></i>';
            }
        }

        // Add event listener for modal confirmation
        // Remove success modal logic, redirect to dashboard on success

        document.addEventListener('DOMContentLoaded', function () {
            // Only prevent form submission if it's not the final step
            const appointmentForm = document.getElementById('appointmentBookingForm');
            if (appointmentForm) {
                appointmentForm.addEventListener('submit', function (event) {
                    // Only prevent if we're not on the final step
                    const currentStepNav = parseInt(document.querySelector('.nav-step.active')?.dataset.step || '1');
                    if (currentStepNav < 4) {
                        event.preventDefault();
                        return false;
                    }
                });
            }

            var confirmBtn = document.getElementById('confirmSubmitAppointment');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function (event) {
                    event.preventDefault();
                    // Populate the hidden form with the selected data
                    document.getElementById('formCounselorId').value = selectedCounselor.id;
                    document.getElementById('formScheduledAt').value = selectedTime;
                    document.getElementById('formNotes').value = document.getElementById('appointmentNotes').value || '';
                    // Submit the form via AJAX
                    const form = document.getElementById('appointment-form');
                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(async response => {
                            let data;
                            try {
                                data = await response.json();
                            } catch (e) {
                                // Not JSON, likely an error page
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Server Error',
                                    text: 'There was a server error or you are not logged in. Please refresh and try again.',
                                    confirmButtonColor: '#1f7a2d'
                                });
                                return;
                            }
                            // Hide the confirmation modal
                            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('appointmentConfirmModal'));
                            if (confirmModal) confirmModal.hide();
                            // Redirect to dashboard on success
                            if (data.success) {
                                window.location.href = "<?php echo e(route('dashboard')); ?>";
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Booking Failed',
                                    text: data.error || 'There was an error booking your appointment.',
                                    confirmButtonColor: '#1f7a2d'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Booking Error',
                                text: 'There was an error booking your appointment. Please try again.',
                                confirmButtonColor: '#1f7a2d'
                            });
                            console.error('Error:', error);
                        });
                });
            }

            // Consolidated listeners for conditional fields
            // Nature of Problem "Other" field
            const problemRadios = document.querySelectorAll('input[name="nature_of_problem"]');
            const problemOtherField = document.getElementById('problem_other_specify');
            const natureOfProblemOther = document.getElementById('nature_of_problem_other');

            problemRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'Other') {
                        if (problemOtherField) problemOtherField.style.display = 'block';
                        if (natureOfProblemOther) natureOfProblemOther.setAttribute('required', 'required');
                    } else {
                        if (problemOtherField) problemOtherField.style.display = 'none';
                        if (natureOfProblemOther) {
                            natureOfProblemOther.removeAttribute('required');
                            natureOfProblemOther.value = '';
                        }
                    }
                });
            });

            // Guardian Relationship "Other" fields
            const guardian1Relationship = document.getElementById('guardian1_relationship');
            const guardian1Other = document.getElementById('guardian1_relationship_other');
            if (guardian1Relationship) {
                guardian1Relationship.addEventListener('change', function () {
                    if (this.value === 'Other') {
                        if (guardian1Other) {
                            guardian1Other.style.display = 'block';
                            guardian1Other.setAttribute('required', 'required');
                        }
                    } else {
                        if (guardian1Other) {
                            guardian1Other.style.display = 'none';
                            guardian1Other.removeAttribute('required');
                            guardian1Other.value = '';
                        }
                    }
                });
            }

            const guardian2Relationship = document.getElementById('guardian2_relationship');
            const guardian2Other = document.getElementById('guardian2_relationship_other');
            if (guardian2Relationship) {
                guardian2Relationship.addEventListener('change', function () {
                    if (this.value === 'Other') {
                        if (guardian2Other) guardian2Other.style.display = 'block';
                    } else {
                        if (guardian2Other) {
                            guardian2Other.style.display = 'none';
                            guardian2Other.value = '';
                        }
                    }
                });
            }

            // Appointment Type "Referral" field
            const typeRadios = document.querySelectorAll('input[name="appointment_type"]');
            const referralReasonContainer = document.getElementById('referral_reason_container');
            const referralReason = document.getElementById('referral_reason');

            typeRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'Referral') {
                        if (referralReasonContainer) referralReasonContainer.style.display = 'block';
                        if (referralReason) referralReason.setAttribute('required', 'required');
                    } else {
                        if (referralReasonContainer) referralReasonContainer.style.display = 'none';
                        if (referralReason) {
                            referralReason.removeAttribute('required');
                            referralReason.value = '';
                        }
                    }
                });
            });

            // Sidebar toggle for mobile
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('studentSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function () {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function (e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
    </div>
    </div>
    </div>
    </div>


    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/appointments/create.blade.php ENDPATH**/ ?>