<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --forest-green: #1f7a2d;
            --forest-green-light: #4a7c59;
            --forest-green-lighter: #e8f5e8;
            --yellow-maize: #f4d03f;
            --gray-50: #f8f9fa;
            --gray-100: #eef6ee;
            --gray-600: #6c757d;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hero-gradient: linear-gradient(135deg, var(--forest-green) 0%, #13601f 100%);
        }

        /* Force sidebar to use the local forest-green variable */
        .custom-sidebar {
            background: var(--forest-green) !important;
        }

        /* Match dashboard zoom */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        .home-zoom .container {
            max-width: 100%;
        }

        /* Mobile specific fixes */
        @media (max-width: 768px) {
            .home-zoom {
                zoom: 1 !important;
                transform: none !important;
            }

            .announcement-header-bg {
                padding: 2rem 1.25rem !important;
                border-radius: 12px !important;
                text-align: center;
            }

            .announcement-header-bg .d-flex {
                justify-content: center !important;
                flex-direction: column;
            }

            .announcement-header-bg .d-flex.align-items-center.mb-2 {
                justify-content: center !important;
                margin-bottom: 1rem !important;
            }

            .announcement-content-card {
                padding: 1.5rem 1.25rem !important;
            }

            .announcement-title {
                font-size: 1.5rem !important;
                line-height: 1.3;
            }

            .announcement-meta {
                justify-content: center;
            }

            .attachment-compact-mobile {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem !important;
            }

            .attachment-compact-mobile .btn {
                width: 100%;
            }
        }

        .announcement-body-content {
            line-height: 1.8;
            color: #2c3e50;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .announcement-body-content a {
            word-break: break-word;
            overflow-wrap: anywhere;
        }
    </style>
    <div class="home-zoom">
        <div class="container px-0 px-md-3">
            <div class="py-4 px-4 px-lg-5 mb-4 rounded-4 announcement-header-bg"
                style="background: linear-gradient(135deg, #228B22, #0f3d1e); color: #fff;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <a href="#"
                                onclick="event.preventDefault(); if (window.history.length > 1) { window.history.back(); } else { window.location.href = '<?php echo e(route('announcements.index')); ?>'; }"
                                class="text-white-50 text-decoration-none me-3">
                                <span class="me-1">&larr;</span> Back
                            </a>
                        </div>
                        <h1 class="h3 fw-bold mb-2 announcement-title"><?php echo e($announcement->title); ?></h1>
                        <div class="d-flex align-items-center flex-wrap gap-2 small">
                            <span class="badge rounded-pill"
                                style="background: rgba(255,203,5,0.15); color:#ffdf66;"><?php echo e(optional($announcement->created_at)->format('M d, Y')); ?></span>
                            <span class="text-white-50">&middot;</span>
                            <span class="text-white-75">Posted
                                <?php echo e(optional($announcement->created_at)->diffForHumans()); ?></span>
                            <?php if(optional($announcement->created_at) && optional($announcement->created_at)->greaterThanOrEqualTo(now()->subDays(14))): ?>
                                <span class="badge"
                                    style="background:#FFCB05; color:#1a1a1a; font-weight:700; font-size: 0.65rem; padding: 0.35em 0.65em;">NEW</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-lg-5 announcement-content-card">
                            <div class="mb-4 announcement-body-content">
                                <?php echo nl2br(e($announcement->content)); ?>

                            </div>
                            <?php
                                $attachmentPath = $announcement->attachment ?? null;
                                $attachmentUrl = $attachmentPath ? asset('storage/' . $attachmentPath) : null;
                                $isImage = $attachmentPath && preg_match('/\.(jpg|jpeg|png|gif|webp|bmp|svg)$/i', $attachmentPath);
                            ?>
                            <?php if($attachmentPath): ?>
                                <?php if($isImage): ?>
                                    <div class="rounded-3 overflow-hidden mb-3 d-flex justify-content-center bg-light"
                                        style="border:1px solid rgba(0,0,0,0.06);">
                                        <a href="<?php echo e($attachmentUrl); ?>" target="_blank" class="d-inline-block position-relative">
                                            <img src="<?php echo e($attachmentUrl); ?>" alt="Announcement Attachment" class="img-fluid"
                                                style="display:block; object-fit: contain; max-height: 600px; max-width: 100%; width: auto; margin: 0 auto;">
                                        </a>
                                    </div>
                                    <div class="text-muted small mb-2">Click the image to open in a new tab.</div>
                                <?php else: ?>
                                    <div class="p-3 p-lg-4 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-3 attachment-compact-mobile"
                                        style="background: #f8faf9; border: 1px solid rgba(0,0,0,0.06);">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="d-inline-flex align-items-center justify-content-center"
                                                style="width:44px;height:44px;border-radius:12px;background: linear-gradient(135deg, #2e7d32, #228B22); color:#fff; flex-shrink: 0;">
                                                <i class="fas fa-paperclip"></i>
                                            </div>
                                            <div class="text-start">
                                                <div class="fw-semibold">Attachment</div>
                                                <div class="text-muted small">Click to view or download</div>
                                            </div>
                                        </div>
                                        <a href="<?php echo e($attachmentUrl); ?>" target="_blank" class="btn btn-success fw-semibold"
                                            style="background:#228B22;border:none;border-radius:10px;">
                                            View Attachment
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if($announcement->images && count($announcement->images) > 0): ?>
                                <div class="mt-4">
                                    <h5 class="mb-3" style="color:#2e7d32; font-weight:600;">
                                        <i class="bi bi-images me-2"></i>Gallery
                                    </h5>
                                    <div class="row g-2 g-md-3">
                                        <?php $__currentLoopData = $announcement->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-6 col-sm-4 col-md-3">
                                                <div class="position-relative rounded-3 overflow-hidden shadow-sm"
                                                    style="cursor: pointer;">
                                                    <img src="<?php echo e(asset('storage/' . $image)); ?>"
                                                        alt="Announcement Image <?php echo e($index + 1); ?>" class="img-fluid w-100"
                                                        style="height: 200px; object-fit: cover;"
                                                        onclick="openImageModal(<?php echo e($index); ?>)">
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>



                                <script>
                                    const galleryImages = <?php echo json_encode($announcement->images ? collect($announcement->images)->map(fn($img) => asset('storage/' . $img)) : [], 15, 512) ?>;
                                    let currentImageIndex = 0;

                                    function openImageModal(index) {
                                        currentImageIndex = index;
                                        updateModalImage();
                                        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                                        imageModal.show();
                                    }

                                    function updateModalImage() {
                                        if (galleryImages.length > 0) {
                                            document.getElementById('modalImage').src = galleryImages[currentImageIndex];
                                            updateNavButtons();
                                        }
                                    }

                                    function nextImage() {
                                        if (currentImageIndex < galleryImages.length - 1) {
                                            currentImageIndex++;
                                            updateModalImage();
                                        } else {
                                            // Optional: Loop back to start
                                            currentImageIndex = 0;
                                            updateModalImage();
                                        }
                                    }

                                    function prevImage() {
                                        if (currentImageIndex > 0) {
                                            currentImageIndex--;
                                            updateModalImage();
                                        } else {
                                            // Optional: Loop to end
                                            currentImageIndex = galleryImages.length - 1;
                                            updateModalImage();
                                        }
                                    }

                                    function updateNavButtons() {
                                        // You can add logic here to hide/disable buttons if needed,
                                        // or handled by the loop logic above.
                                        const prevBtn = document.getElementById('modalPrevBtn');
                                        const nextBtn = document.getElementById('modalNextBtn');

                                        if (galleryImages.length <= 1) {
                                            if (prevBtn) prevBtn.style.display = 'none';
                                            if (nextBtn) nextBtn.style.display = 'none';
                                        } else {
                                            if (prevBtn) prevBtn.style.display = 'flex';
                                            if (nextBtn) nextBtn.style.display = 'flex';
                                        }
                                    }

                                    // Keyboard navigation
                                    document.addEventListener('keydown', function (event) {
                                        const modal = document.getElementById('imageModal');
                                        if (modal && modal.classList.contains('show')) {
                                            if (event.key === 'ArrowLeft') {
                                                prevImage();
                                            } else if (event.key === 'ArrowRight') {
                                                nextImage();
                                            }
                                        }
                                    });
                                </script>
                            <?php endif; ?>

                            <div class="d-flex align-items-center gap-2 mt-4">
                                <?php if(auth()->guard()->check()): ?>
                                    <?php if(auth()->user()->isAdmin()): ?>
                                        <a href="<?php echo e(route('announcements.edit', $announcement->id)); ?>"
                                            class="btn btn-warning">Edit</a>
                                        <form action="<?php echo e(route('announcements.destroy', $announcement->id)); ?>" method="POST"
                                            style="display:inline-block;"
                                            data-confirm="Are you sure you want to delete this announcement?">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Image Modal (Moved outside zoom container) -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center position-relative">
                    <img id="modalImage" src="" class="img-fluid rounded shadow-lg"
                        style="max-height: 85vh; width: auto; max-width: 100%; display: inline-block;">

                    <!-- Navigation Buttons -->
                    <button id="modalPrevBtn"
                        class="position-absolute top-50 start-0 translate-middle-y btn p-0 ms-1 d-flex align-items-center justify-content-center border-0"
                        style="width: 50px; height: 100%; background: transparent; opacity: 0.8;" onclick="prevImage()">
                        <i class="fas fa-chevron-left text-white display-4"
                            style="text-shadow: 0 2px 10px rgba(0,0,0,0.8);"></i>
                    </button>
                    <button id="modalNextBtn"
                        class="position-absolute top-50 end-0 translate-middle-y btn p-0 me-1 d-flex align-items-center justify-content-center border-0"
                        style="width: 50px; height: 100%; background: transparent; opacity: 0.8;" onclick="nextImage()">
                        <i class="fas fa-chevron-right text-white display-4"
                            style="text-shadow: 0 2px 10px rgba(0,0,0,0.8);"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Please confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmModalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmModalOk">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const confirmModalEl = document.getElementById('confirmModal');
            let bsConfirm = (typeof bootstrap !== 'undefined' && confirmModalEl) ? new bootstrap.Modal(confirmModalEl, { backdrop: 'static' }) : null;
            let confirmTarget = null;
            function showConfirm(message, target) {
                document.getElementById('confirmModalMessage').textContent = message;
                confirmTarget = target;
                if (bsConfirm) { bsConfirm.show(); return; }
                confirmModalEl.classList.add('show'); confirmModalEl.style.display = 'block';
                let bd = document.getElementById('confirmModalBackdrop');
                if (!bd) { bd = document.createElement('div'); bd.id = 'confirmModalBackdrop'; bd.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1050'; document.body.appendChild(bd); } else bd.style.display = 'block';
            }
            document.querySelectorAll('[data-confirm]').forEach(function (el) {
                if (el.tagName === 'FORM') {
                    el.addEventListener('submit', function (e) { e.preventDefault(); showConfirm(el.getAttribute('data-confirm') || 'Are you sure?', el); });
                } else {
                    el.addEventListener('click', function (e) { e.preventDefault(); showConfirm(el.getAttribute('data-confirm') || 'Are you sure?', el); });
                }
            });
            const ok = document.getElementById('confirmModalOk');
            if (ok) ok.addEventListener('click', function () { if (!confirmTarget) return; if (confirmTarget.tagName === 'FORM') { confirmTarget.removeAttribute('data-confirm'); confirmTarget.submit(); } else if (confirmTarget.tagName === 'A') { const href = confirmTarget.getAttribute('href'); if (href) window.location.href = href; } if (bsConfirm) bsConfirm.hide(); else { confirmModalEl.classList.remove('show'); confirmModalEl.style.display = 'none'; const bd = document.getElementById('confirmModalBackdrop'); if (bd) bd.style.display = 'none'; } });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/announcements/show.blade.php ENDPATH**/ ?>