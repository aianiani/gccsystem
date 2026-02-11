

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('full_width', true); ?>
    <style>
        :root {
            --forest-green: #1f7a2d;
            --forest-green-dark: #13601f;
            --forest-green-light: #2e7d32;
            --forest-green-lighter: #e8f5e9;
            --yellow-maize: #f4d03f;
            --gray-50: #f8f9fa;
            --gray-100: #e9ecef;
            --gray-200: #dee2e6;
            --gray-600: #6c757d;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-dark) 100%);
        }

        /* Prevent horizontal overflow on mobile */
        html,
        body {
            overflow-x: hidden;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .d-flex {
            width: 100%;
        }

        /* Compensation for zoom: 0.75 */
        .home-zoom {
            width: 133.333%;
        }

        @media (max-width: 767.98px) {
            .home-zoom {
                width: 100%;
            }
        }

        /* Sidebar Styles */
        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            background: var(--forest-green);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0, 0, 0, 0.08);
            overflow-y: auto;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (max-width: 991.98px) {
            .custom-sidebar {
                transform: translateX(-100%);
            }

            .custom-sidebar.show {
                transform: translateX(0) !important;
                z-index: 1100;
                visibility: visible;
            }

            .main-dashboard-content {
                margin-left: 0 !important;
            }

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
            }
        }

        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            margin-left: 280px;
            transition: margin-left 0.3s ease;
            width: calc(100% - 280px);
            overflow-x: hidden;
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }

        /* Hero Header */
        .resources-hero {
            background: var(--hero-gradient);
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .resources-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            filter: blur(60px);
        }

        .resources-hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: rgba(244, 208, 63, 0.1);
            border-radius: 50%;
            filter: blur(50px);
        }

        .resources-hero h1 {
            color: #fff;
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .resources-hero p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 1.05rem;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .resources-hero .search-box {
            position: relative;
            max-width: 450px;
            margin-top: 1.5rem;
            z-index: 1;
        }

        .resources-hero .search-box input {
            width: 100%;
            padding: 0.9rem 1.25rem 0.9rem 3rem;
            border: none;
            border-radius: 50px;
            font-size: 0.95rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .resources-hero .search-box i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-600);
        }

        /* Category Tabs */
        .category-tabs {
            display: flex;
            gap: 0.75rem;
            padding: 1.5rem 2rem;
            background: #fff;
            border-bottom: 1px solid var(--gray-100);
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .category-tab {
            padding: 0.6rem 1.25rem;
            border-radius: 50px;
            background: var(--gray-50);
            color: var(--gray-600);
            font-weight: 600;
            font-size: 0.875rem;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .category-tab:hover {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
        }

        .category-tab.active {
            background: var(--forest-green);
            color: #fff;
            border-color: var(--forest-green);
        }

        .category-tab .count {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.1rem 0.5rem;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        .category-tab.active .count {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Resources Grid */
        .resources-grid {
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        @media (max-width: 767.98px) {
            .resources-grid {
                grid-template-columns: 1fr;
                padding: 1rem;
            }
        }

        /* Resource Card */
        .resource-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .resource-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--forest-green-lighter);
        }

        .resource-card .card-thumbnail {
            height: 180px;
            background: linear-gradient(135deg, var(--forest-green-lighter) 0%, #d4edda 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .resource-card .card-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .resource-card .card-thumbnail .thumbnail-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--forest-green);
            box-shadow: 0 8px 25px rgba(31, 122, 45, 0.2);
        }

        .resource-card .card-thumbnail .play-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .resource-card:hover .card-thumbnail .play-overlay {
            opacity: 1;
        }

        .resource-card .card-thumbnail .play-overlay i {
            font-size: 3.5rem;
            color: #fff;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.3));
        }

        .resource-card .type-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.35rem 0.85rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 10;
        }

        .resource-card .type-badge.video {
            background: #e3f2fd;
            color: #1565c0;
        }

        .resource-card .type-badge.image {
            background: #fff3e0;
            color: #e65100;
        }

        .resource-card .type-badge.file {
            background: #fce4ec;
            color: #c2185b;
        }

        .resource-card .type-badge.article {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .resource-card .card-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .resource-card .card-category {
            font-size: 0.75rem;
            color: var(--forest-green);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .resource-card .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .resource-card .card-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            line-height: 1.6;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .resource-card .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-100);
        }

        .resource-card .card-meta {
            font-size: 0.8rem;
            color: var(--gray-600);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .resource-card .view-btn {
            padding: 0.5rem 1.25rem;
            background: var(--forest-green);
            color: #fff;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .resource-card .view-btn:hover {
            background: var(--forest-green-dark);
            color: #fff;
            transform: scale(1.05);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state .empty-icon {
            width: 120px;
            height: 120px;
            background: var(--forest-green-lighter);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .empty-state .empty-icon i {
            font-size: 3rem;
            color: var(--forest-green);
        }

        .empty-state h3 {
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--gray-600);
        }

        /* Category Section Headers */
        .category-section {
            margin-bottom: 2rem;
        }

        .category-section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0 2rem;
            margin-bottom: 1rem;
        }

        .category-section-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--forest-green);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .category-section-header .section-line {
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, var(--forest-green-lighter), transparent);
        }

        .category-section-header .count-badge {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* ========== MOBILE RESPONSIVE FIXES ========== */
        @media (max-width: 767.98px) {

            /* Disable zoom on mobile for proper touch experience */
            .home-zoom {
                zoom: 1 !important;
                transform: none !important;
            }

            /* Hero section mobile adjustments */
            .resources-hero {
                padding: 4rem 1rem 1.5rem 1rem;
            }

            .resources-hero h1 {
                font-size: 1.5rem;
            }

            .resources-hero p {
                font-size: 0.9rem;
            }

            .resources-hero .search-box {
                max-width: 100%;
            }

            .resources-hero .search-box input {
                padding: 0.75rem 1rem 0.75rem 2.75rem;
                font-size: 0.9rem;
            }

            .resources-hero .search-box i {
                left: 1rem;
            }

            /* Category tabs - horizontal scroll */
            .category-tabs {
                padding: 1rem;
                gap: 0.5rem;
                overflow-x: auto;
                flex-wrap: nowrap;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .category-tabs::-webkit-scrollbar {
                display: none;
            }

            .category-tab {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
                white-space: nowrap;
                flex-shrink: 0;
            }

            /* Category section headers */
            .category-section-header {
                padding: 0 1rem;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .category-section-header h2 {
                font-size: 1.2rem;
                width: 100%;
            }

            .category-section-header .section-line {
                display: none;
            }

            .category-section-header .count-badge {
                font-size: 0.75rem;
                padding: 0.2rem 0.6rem;
            }

            /* Resource cards */
            .resource-card .card-thumbnail {
                height: 150px;
            }

            .resource-card .card-content {
                padding: 1rem;
            }

            .resource-card .card-title {
                font-size: 1rem;
            }

            .resource-card .card-description {
                font-size: 0.85rem;
                -webkit-line-clamp: 2;
            }

            .resource-card .card-footer {
                flex-direction: column;
                gap: 0.75rem;
                align-items: stretch;
            }

            .resource-card .card-meta {
                justify-content: center;
            }

            .resource-card .view-btn {
                justify-content: center;
                width: 100%;
            }

            /* Empty state */
            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-state .empty-icon {
                width: 80px;
                height: 80px;
            }

            .empty-state .empty-icon i {
                font-size: 2rem;
            }
        }

        /* Extra small devices */
        @media (max-width: 375px) {
            .resources-hero h1 {
                font-size: 1.25rem;
            }

            .category-tab {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }

            .resource-card .card-thumbnail {
                height: 120px;
            }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="studentSidebarToggle" class="d-lg-none">
                <i class="bi bi-list"></i>
            </button>

            <!-- Sidebar -->
            <?php echo $__env->make('student.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <!-- Hero Header -->
                <div class="resources-hero">
                    <h1><i class="bi bi-collection-play me-2"></i>Student Resources</h1>
                    <p>Access mental health materials, orientation videos, and guidance resources to support your journey.
                    </p>
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchInput" placeholder="Search resources...">
                    </div>
                </div>

                <!-- Category Tabs -->
                <div class="category-tabs">
                    <button class="category-tab active" data-category="all">
                        <i class="bi bi-grid-3x3-gap"></i>
                        All
                        <span class="count"><?php echo e($resources->flatten()->count()); ?></span>
                    </button>
                    <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button class="category-tab" data-category="<?php echo e(Str::slug($category)); ?>">
                            <?php if($category == 'Mental Health'): ?>
                                <i class="bi bi-heart-pulse"></i>
                            <?php elseif($category == 'Orientation'): ?>
                                <i class="bi bi-compass"></i>
                            <?php elseif($category == 'Academic Support'): ?>
                                <i class="bi bi-book"></i>
                            <?php elseif($category == 'Career Guidance'): ?>
                                <i class="bi bi-briefcase"></i>
                            <?php else: ?>
                                <i class="bi bi-folder"></i>
                            <?php endif; ?>
                            <?php echo e($category); ?>

                            <span class="count"><?php echo e($items->count()); ?></span>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Resources Content -->
                <?php $__empty_1 = true; $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="category-section" data-category="<?php echo e(Str::slug($category)); ?>">
                            <div class="category-section-header">
                                <h2>
                                    <?php if($category == 'Mental Health'): ?>
                                        <i class="bi bi-heart-pulse"></i>
                                    <?php elseif($category == 'Orientation'): ?>
                                        <i class="bi bi-compass"></i>
                                    <?php elseif($category == 'Academic Support'): ?>
                                        <i class="bi bi-book"></i>
                                    <?php elseif($category == 'Career Guidance'): ?>
                                        <i class="bi bi-briefcase"></i>
                                    <?php else: ?>
                                        <i class="bi bi-folder"></i>
                                    <?php endif; ?>
                                    <?php echo e($category); ?>

                                </h2>
                                <div class="section-line"></div>
                                <span class="count-badge"><?php echo e($items->count()); ?> resources</span>
                            </div>

                            <div class="resources-grid">
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="resource-card" data-title="<?php echo e(strtolower($resource->title)); ?>"
                                            data-description="<?php echo e(strtolower($resource->description)); ?>">
                                            <div class="card-thumbnail">
                                                <span class="type-badge <?php echo e($resource->type); ?>"><?php echo e(ucfirst($resource->type)); ?></span>

                                                <?php if($resource->type == 'video'): ?>
                                                    <?php
                                                        // Extract YouTube video ID for thumbnail
                                                        preg_match(
                                                            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\s]+)/',
                                                            $resource->content,
                                                            $matches,
                                                        );
                                                        $videoId = $matches[1] ?? null;
                                                    ?>
                                                    <?php if($videoId): ?>
                                                        <img src="https://img.youtube.com/vi/<?php echo e($videoId); ?>/mqdefault.jpg"
                                                            alt="<?php echo e($resource->title); ?>">
                                                    <?php elseif($resource->file_path && str_starts_with($resource->file_type ?? '', 'video/')): ?>
                                                        <div class="thumbnail-icon">
                                                            <i class="bi bi-film"></i>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="thumbnail-icon">
                                                            <i class="bi bi-play-circle"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="play-overlay">
                                                        <i class="bi bi-play-circle-fill"></i>
                                                    </div>
                                                <?php elseif($resource->type == 'image'): ?>
                                                    <?php if($resource->file_path): ?>
                                                        <img src="<?php echo e(asset('storage/' . $resource->file_path)); ?>" alt="<?php echo e($resource->title); ?>">
                                                    <?php else: ?>
                                                        <div class="thumbnail-icon">
                                                            <i class="bi bi-image"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php elseif($resource->type == 'file'): ?>
                                                    <div class="thumbnail-icon">
                                                        <?php if(str_contains($resource->file_type ?? '', 'pdf')): ?>
                                                            <i class="bi bi-file-earmark-pdf"></i>
                                                        <?php elseif(str_contains($resource->file_type ?? '', 'word') || str_contains($resource->file_name ?? '', '.doc')): ?>
                                                            <i class="bi bi-file-earmark-word"></i>
                                                        <?php elseif(str_contains($resource->file_type ?? '', 'presentation') || str_contains($resource->file_name ?? '', '.ppt')): ?>
                                                            <i class="bi bi-file-earmark-ppt"></i>
                                                        <?php else: ?>
                                                            <i class="bi bi-file-earmark"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="thumbnail-icon">
                                                        <i class="bi bi-link-45deg"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="card-content">
                                                <div class="card-category"><?php echo e($category); ?></div>
                                                <h3 class="card-title"><?php echo e($resource->title); ?></h3>
                                                <p class="card-description">
                                                    <?php echo e($resource->description ?? 'No description available.'); ?>

                                                </p>

                                                <div class="card-footer">
                                                    <div class="card-meta">
                                                        <?php if($resource->file_size): ?>
                                                            <i class="bi bi-hdd"></i>
                                                            <?php echo e(number_format($resource->file_size / (1024 * 1024), 1)); ?> MB
                                                        <?php else: ?>
                                                            <i class="bi bi-calendar3"></i>
                                                            <?php echo e($resource->created_at->format('M d, Y')); ?>

                                                        <?php endif; ?>
                                                    </div>

                                                    <?php if($resource->file_path): ?>
                                                        <a href="<?php echo e(asset('storage/' . $resource->file_path)); ?>" target="_blank"
                                                            class="view-btn" <?php if($resource->type == 'file'): ?> download <?php endif; ?>>
                                                            <?php if($resource->type == 'video'): ?>
                                                                <i class="bi bi-play-fill"></i> Watch
                                                            <?php elseif($resource->type == 'image'): ?>
                                                                <i class="bi bi-eye"></i> View
                                                            <?php else: ?>
                                                                <i class="bi bi-download"></i> Download
                                                            <?php endif; ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="<?php echo e($resource->content); ?>" target="_blank" class="view-btn">
                                                            <?php if($resource->type == 'video'): ?>
                                                                <i class="bi bi-play-fill"></i> Watch
                                                            <?php else: ?>
                                                                <i class="bi bi-box-arrow-up-right"></i> Open
                                                            <?php endif; ?>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-collection"></i>
                    </div>
                    <h3>No Resources Found</h3>
                    <p>We couldn't find any resources matching your search or category filter.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle
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

            // Category tabs filtering
            const categoryTabs = document.querySelectorAll('.category-tab');
            const categorySections = document.querySelectorAll('.category-section');

            categoryTabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const category = this.dataset.category;

                    // Update active tab
                    categoryTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Filter sections
                    if (category === 'all') {
                        categorySections.forEach(section => {
                            section.style.display = 'block';
                        });
                    } else {
                        categorySections.forEach(section => {
                            if (section.dataset.category === category) {
                                section.style.display = 'block';
                            } else {
                                section.style.display = 'none';
                            }
                        });
                    }
                });
            });

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const resourceCards = document.querySelectorAll('.resource-card');

            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const query = this.value.toLowerCase().trim();

                    if (query === '') {
                        // Show all cards and sections
                        resourceCards.forEach(card => card.style.display = 'flex');
                        categorySections.forEach(section => section.style.display = 'block');
                        return;
                    }

                    // Filter cards
                    resourceCards.forEach(card => {
                        const title = card.dataset.title || '';
                        const description = card.dataset.description || '';
                        if (title.includes(query) || description.includes(query)) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Hide empty sections
                    categorySections.forEach(section => {
                        const cards = section.querySelectorAll('.resource-card');
                        let hasVisible = false;
                        cards.forEach(card => {
                            if (card.style.display !== 'none') hasVisible = true;
                        });
                        section.style.display = hasVisible ? 'block' : 'none';
                    });

                    // Reset to "All" tab during search
                    categoryTabs.forEach(t => t.classList.remove('active'));
                    if (categoryTabs[0]) categoryTabs[0].classList.add('active');
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/resources.blade.php ENDPATH**/ ?>