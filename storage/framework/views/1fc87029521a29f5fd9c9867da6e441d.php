

<?php $__env->startSection('content'); ?>
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
        :root {
            --primary-green: #1f7a2d; /* Homepage forest green */
            --primary-green-2: #13601f; /* darker stop */
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0,0,0,0.08);

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
            --info: #17a2b8;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        /* Apply the same page zoom used on the homepage */
        .home-zoom {
            zoom: 0.85;
        }
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.85);
                transform-origin: top center;
            }
        }
        
        body, .profile-card, .stats-card, .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green) ;
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0,0,0,0.08);
            overflow-y: auto;
            padding-bottom: 1rem;
        }
        
        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2rem 1rem 1rem 1rem;
            border-bottom: 1px solid #4a7c59;
        }
        
        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0.5rem 0 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .custom-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
            position: relative;
        }
        
        .custom-sidebar .sidebar-link.active, .custom-sidebar .sidebar-link:hover {
            background: #4a7c59;
            color: #f4d03f;
        }
        
        .custom-sidebar .sidebar-link .bi {
            font-size: 1.1rem;
        }
        
        .custom-sidebar .sidebar-bottom {
            padding: 1rem 0.5rem;
            border-top: 1px solid #4a7c59;
        }
        
        .custom-sidebar .sidebar-link.logout {
            background: #dc3545;
            color: #fff;
            border-radius: 8px;
            text-align: center;
            padding: 0.75rem 1rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        
        .custom-sidebar .sidebar-link.logout:hover {
            background: #b52a37;
            color: #fff;
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
                transition: transform 0.2s ease;
                flex-direction: column;
                padding: 0;
            }
            .custom-sidebar.show {
                transform: translateX(0);
            }
            .custom-sidebar .sidebar-logo { display: block; }
            .custom-sidebar .sidebar-nav {
                flex-direction: column;
                gap: 0.25rem;
                padding: 1rem 0.5rem 1rem 0.5rem;
            }
            .custom-sidebar .sidebar-link {
                justify-content: flex-start;
                padding: 0.6rem 0.75rem;
                font-size: 1rem;
            }
            .main-dashboard-content {
                margin-left: 0;
            }
            /* Toggle button */
            #counselorSidebarToggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--forest-green);
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 0.5rem 0.75rem;
                box-shadow: var(--shadow-sm);
            }
        }
        
        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 1180px;
            margin: 0 auto;
        }

        .profile-header-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .profile-avatar-section {
            text-align: center;
            margin-bottom: 1rem;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.3);
            object-fit: cover;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            margin-bottom: 0.75rem;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .profile-email {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .avatar-upload-section {
            margin-top: 0.5rem;
        }

        .avatar-upload-btn {
            background: rgba(255,255,255,0.2);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-block;
        }

        .avatar-upload-btn:hover {
            background: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.5);
        }

        .hero-info-section {
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .hero-section-title {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .hero-info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.5rem 0;
        }

        .hero-info-icon {
            color: var(--yellow-maize);
            font-size: 1.1rem;
            margin-top: 0.2rem;
            min-width: 20px;
        }

        .hero-info-content {
            flex: 1;
        }

        .hero-info-label {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-bottom: 0.25rem;
        }

        .hero-info-value {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .profile-info-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid var(--gray-100);
        }

        .profile-info-card .card-title {
            color: var(--forest-green);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--forest-green-lighter);
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item-icon {
            color: var(--forest-green);
            font-size: 1.1rem;
            margin-top: 0.2rem;
            min-width: 20px;
        }

        .info-item-content {
            flex: 1;
        }

        .info-item-label {
            font-size: 0.85rem;
            color: var(--gray-600);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-item-value {
            font-size: 0.95rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        .info-item-value.empty {
            color: var(--gray-600);
            font-style: italic;
            font-weight: 400;
        }

        .edit-btn {
            background: var(--forest-green);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .edit-btn:hover {
            background: var(--forest-green-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .form-section {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid var(--gray-100);
        }

        .form-section-title {
            color: var(--forest-green);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--forest-green-lighter);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 1px solid var(--gray-100);
            border-radius: 8px;
            padding: 0.6rem 0.75rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--forest-green);
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
            outline: none;
        }

        .btn-primary-custom {
            background: var(--forest-green);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary-custom:hover {
            background: var(--forest-green-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .badge-status {
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-active {
            background: var(--success);
            color: white;
        }

        .badge-inactive {
            background: var(--danger);
            color: white;
        }

        .badge-pending {
            background: var(--warning);
            color: var(--text-dark);
        }

        .badge-approved {
            background: var(--success);
            color: white;
        }

        .badge-rejected {
            background: var(--danger);
            color: white;
        }

        @media (max-width: 768px) {
            .profile-header-card {
                padding: 1.5rem;
            }
            .hero-info-section {
                padding: 0.75rem;
            }
            .hero-info-value {
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="home-zoom">
    <div class="d-flex">
        <!-- Mobile Sidebar Toggle -->
        <button id="counselorSidebarToggle" class="d-md-none">
            <i class="bi bi-list"></i>
        </button>
        <!-- Sidebar -->
        <?php echo $__env->make('counselor.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <!-- Main Content -->
        <div class="main-dashboard-content flex-grow-1">
            <div class="main-dashboard-inner">
                <div class="container py-1">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 1rem;">
                            <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; margin-bottom: 1rem;">
                            <i class="bi bi-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <!-- Profile Header -->
                    <div class="profile-header-card">
                        <div class="row g-4">
                            <!-- Left Side - Avatar Section -->
                            <div class="col-md-4">
                                <div class="profile-avatar-section">
                                    <img src="<?php echo e($user->avatar_url); ?>" alt="Profile Picture" class="profile-avatar">
                                    <div class="profile-name"><?php echo e($user->name); ?></div>
                                    <div class="profile-email"><?php echo e($user->email); ?></div>
                                    <form method="POST" action="<?php echo e(route('profile.avatar')); ?>" enctype="multipart/form-data" class="avatar-upload-section">
                                        <?php echo csrf_field(); ?>
                                        <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;" onchange="this.form.submit()">
                                        <label for="avatarInput" class="avatar-upload-btn">
                                            <i class="bi bi-camera me-1"></i>Change Photo
                                        </label>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Right Side - Personal & Professional Information -->
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <!-- Personal Information -->
                                    <div class="col-md-6">
                                        <div class="hero-info-section">
                                            <div class="hero-section-title">
                                                <i class="bi bi-person-circle"></i>
                                                Personal Information
                                            </div>
                                            <div class="hero-info-item">
                                                <i class="bi bi-person hero-info-icon"></i>
                                                <div class="hero-info-content">
                                                    <div class="hero-info-label">Full Name</div>
                                                    <div class="hero-info-value"><?php echo e($user->name); ?></div>
                                                </div>
                                            </div>
                                            <div class="hero-info-item">
                                                <i class="bi bi-envelope hero-info-icon"></i>
                                                <div class="hero-info-content">
                                                    <div class="hero-info-label">Email Address</div>
                                                    <div class="hero-info-value"><?php echo e($user->email); ?></div>
                                                </div>
                                            </div>
                                            <div class="hero-info-item">
                                                <i class="bi bi-telephone hero-info-icon"></i>
                                                <div class="hero-info-content">
                                                    <div class="hero-info-label">Contact Number</div>
                                                    <div class="hero-info-value"><?php echo e($user->contact_number ?? 'Not provided'); ?></div>
                                                </div>
                                            </div>
                                            <div class="hero-info-item">
                                                <i class="bi bi-geo-alt hero-info-icon"></i>
                                                <div class="hero-info-content">
                                                    <div class="hero-info-label">Home Address</div>
                                                    <div class="hero-info-value"><?php echo e($user->address ?? 'Not provided'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Professional Information -->
                                    <div class="col-md-6">
                                        <div class="hero-info-section">
                                            <div class="hero-section-title">
                                                <i class="bi bi-briefcase"></i>
                                                Professional Information
                                            </div>
                                            <div class="hero-info-item">
                                                <i class="bi bi-shield-check hero-info-icon"></i>
                                                <div class="hero-info-content">
                                                    <div class="hero-info-label">License Number</div>
                                                    <div class="hero-info-value"><?php echo e($user->license_number ?? 'Not provided'); ?></div>
                                                </div>
                                            </div>
                                            <div class="hero-info-item">
                                                <i class="bi bi-star hero-info-icon"></i>
                                                <div class="hero-info-content">
                                                    <div class="hero-info-label">Specialization</div>
                                                    <div class="hero-info-value"><?php echo e($user->specialization ?? 'Not provided'); ?></div>
                                                </div>
                                            </div>
                                            <div class="hero-info-item">
                                                <i class="bi bi-calendar-check hero-info-icon"></i>
                                                <div class="hero-info-content">
                                                    <div class="hero-info-label">Years of Experience</div>
                                                    <div class="hero-info-value"><?php echo e($user->years_of_experience ?? 'Not provided'); ?></div>
                                                </div>
                                            </div>
                                            <div class="hero-info-item">
                                                <i class="bi bi-mortarboard hero-info-icon"></i>
                                                <div class="hero-info-content">
                                                    <div class="hero-info-label">Education</div>
                                                    <div class="hero-info-value"><?php echo e($user->education ?? 'Not provided'); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Left Column - Empty now, can be used for other content if needed -->
                        <div class="col-lg-6">
                        </div>

                        <!-- Right Column - Account Information & Edit Forms -->
                        <div class="col-lg-6">
                            <!-- Account Information Card -->
                            <div class="profile-info-card">
                                <div class="card-title">
                                    <i class="bi bi-shield-check"></i>
                                    Account Information
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-person-badge info-item-icon"></i>
                                    <div class="info-item-content">
                                        <div class="info-item-label">Role</div>
                                        <div class="info-item-value">
                                            <span class="badge-status badge-active"><?php echo e(ucfirst($user->role)); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-check-circle info-item-icon"></i>
                                    <div class="info-item-content">
                                        <div class="info-item-label">Account Status</div>
                                        <div class="info-item-value">
                                            <span class="badge-status <?php echo e($user->isActive() ? 'badge-active' : 'badge-inactive'); ?>">
                                                <?php echo e($user->isActive() ? 'Active' : 'Inactive'); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-file-check info-item-icon"></i>
                                    <div class="info-item-content">
                                        <div class="info-item-label">Registration Status</div>
                                        <div class="info-item-value">
                                            <?php if($user->registration_status === 'approved'): ?>
                                                <span class="badge-status badge-approved">Approved</span>
                                            <?php elseif($user->registration_status === 'pending'): ?>
                                                <span class="badge-status badge-pending">Pending</span>
                                            <?php elseif($user->registration_status === 'rejected'): ?>
                                                <span class="badge-status badge-rejected">Rejected</span>
                                            <?php else: ?>
                                                <span class="badge-status badge-pending">Pending</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-calendar-check info-item-icon"></i>
                                    <div class="info-item-content">
                                        <div class="info-item-label">Member Since</div>
                                        <div class="info-item-value"><?php echo e($user->created_at->format('F j, Y')); ?></div>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="bi bi-clock-history info-item-icon"></i>
                                    <div class="info-item-content">
                                        <div class="info-item-label">Last Login</div>
                                        <div class="info-item-value"><?php echo e($user->updated_at->format('F j, Y g:i A')); ?></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Personal Information Form -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="bi bi-pencil-square"></i>
                                    Edit Personal Information
                                </div>
                                <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_number" class="form-label">Contact Number</label>
                                        <input type="tel" class="form-control <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="contact_number" name="contact_number" value="<?php echo e(old('contact_number', $user->contact_number ?? '')); ?>" placeholder="e.g., 09XXXXXXXXX">
                                        <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="form-label">Home Address</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="address" name="address" value="<?php echo e(old('address', $user->address ?? '')); ?>" placeholder="House/Street, Barangay, City/Province">
                                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <button type="submit" class="btn-primary-custom w-100">
                                        <i class="bi bi-check-circle me-1"></i>Update Information
                                    </button>
                                </form>
                            </div>

                            <!-- Edit Professional Information Form -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="bi bi-briefcase"></i>
                                    Edit Professional Information
                                </div>
                                <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="license_number" class="form-label">License Number</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['license_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="license_number" name="license_number" value="<?php echo e(old('license_number', $user->license_number ?? '')); ?>" placeholder="e.g., PRC-12345">
                                        <?php $__errorArgs = ['license_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="specialization" class="form-label">Specialization / Area of Expertise</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['specialization'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="specialization" name="specialization" value="<?php echo e(old('specialization', $user->specialization ?? '')); ?>" placeholder="e.g., Clinical Psychology, Family Counseling">
                                        <?php $__errorArgs = ['specialization'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="years_of_experience" class="form-label">Years of Experience</label>
                                        <input type="number" class="form-control <?php $__errorArgs = ['years_of_experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="years_of_experience" name="years_of_experience" value="<?php echo e(old('years_of_experience', $user->years_of_experience ?? '')); ?>" placeholder="e.g., 5" min="0">
                                        <?php $__errorArgs = ['years_of_experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="education" class="form-label">Education / Qualifications</label>
                                        <textarea class="form-control <?php $__errorArgs = ['education'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="education" name="education" rows="3" placeholder="e.g., Master of Arts in Psychology, University of the Philippines"><?php echo e(old('education', $user->education ?? '')); ?></textarea>
                                        <?php $__errorArgs = ['education'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <button type="submit" class="btn-primary-custom w-100">
                                        <i class="bi bi-check-circle me-1"></i>Update Professional Information
                                    </button>
                                </form>
                            </div>

                            <!-- Change Password Form -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <i class="bi bi-key"></i>
                                    Change Password
                                </div>
                                <form method="POST" action="<?php echo e(route('profile.password')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="current_password" name="current_password" required>
                                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" required>
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                    <button type="submit" class="btn-primary-custom w-100">
                                        <i class="bi bi-key me-1"></i>Change Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/profile.blade.php ENDPATH**/ ?>