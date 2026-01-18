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

        .main-dashboard-inner {
            padding: 2rem;
        }

        .page-header-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-header-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
        }

        .page-header-card p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .main-content-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .main-content-card .card-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .main-content-card .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--gray-100);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--forest-green);
            box-shadow: 0 0 0 0.2rem rgba(31, 122, 45, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--gray-600);
            opacity: 0.6;
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .btn-primary {
            background: var(--forest-green);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
            color: white;
        }

        .btn-primary:hover {
            background: #13601f;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
            color: white;
        }

        .btn-secondary {
            background: var(--gray-50);
            color: var(--forest-green);
            border: 1px solid var(--gray-100);
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: var(--gray-100);
            border-color: var(--forest-green);
            color: var(--forest-green);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-100);
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input-label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .file-input-info {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            .main-dashboard-inner {
                padding: 1rem;
            }

            .page-header-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }
        }
    </style>

    <div class="main-dashboard-inner home-zoom">
        <div class="page-header-card">
            <div>
                <h1><i class="bi bi-megaphone me-2"></i>Create Announcement</h1>
                <p>Share important updates and information with all users</p>
            </div>
            <div>
                <a href="<?php echo e(route('announcements.index')); ?>" class="btn btn-light btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>Back to Announcements
                </a>
            </div>
        </div>

        <div class="main-content-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Announcement Details</h5>
            </div>
            <div class="card-body">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger mb-4">
                        <strong>Please correct the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('announcements.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label for="title" class="form-label">
                            <i class="bi bi-type me-1"></i>Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title" id="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            value="<?php echo e(old('title')); ?>" placeholder="Enter announcement title" required>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label for="content" class="form-label">
                            <i class="bi bi-text-paragraph me-1"></i>Content <span class="text-danger">*</span>
                        </label>
                        <textarea name="content" id="content" class="form-control <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            rows="8" placeholder="Enter announcement content..." required><?php echo e(old('content')); ?></textarea>
                        <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label for="attachment" class="form-label file-input-label">
                            <i class="bi bi-paperclip me-1"></i>Attachment <span class="text-muted">(Optional)</span>
                        </label>
                        <input type="file" name="attachment" id="attachment"
                            class="form-control <?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="file-input-info">
                            <i class="bi bi-info-circle me-1"></i>
                            Supported formats: PDF, DOC, DOCX, JPG, PNG. Max file size: 5MB
                        </div>
                        <?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label for="images" class="form-label file-input-label">
                            <i class="bi bi-images me-1"></i>Images <span class="text-muted">(Optional)</span>
                        </label>
                        <input type="file" name="images[]" id="images"
                            class="form-control <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*" multiple
                            onchange="previewImages(this)">
                        <div class="file-input-info">
                            <i class="bi bi-info-circle me-1"></i>
                            You can select multiple images. Supported formats: JPG, PNG, GIF. Max file size per image:
                            5MB
                        </div>
                        <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div id="image-preview" class="mt-3" style="display: none;">
                            <div class="row g-2" id="preview-container"></div>
                        </div>
                    </div>

                    <script>
                        function previewImages(input) {
                            const previewContainer = document.getElementById('preview-container');
                            const imagePreview = document.getElementById('image-preview');

                            previewContainer.innerHTML = '';

                            if (input.files && input.files.length > 0) {
                                imagePreview.style.display = 'block';

                                Array.from(input.files).forEach((file, index) => {
                                    const reader = new FileReader();

                                    reader.onload = function (e) {
                                        const col = document.createElement('div');
                                        col.className = 'col-md-2 col-sm-3 col-4';
                                        col.innerHTML = `
                                                        <div class="position-relative">
                                                            <img src="${e.target.result}" 
                                                                 class="img-fluid rounded shadow-sm" 
                                                                 style="width: 100%; height: 120px; object-fit: cover;">
                                                            <div class="position-absolute top-0 start-0 w-100 p-2">
                                                                <span class="badge bg-dark">${index + 1}</span>
                                                            </div>
                                                        </div>
                                                    `;
                                        previewContainer.appendChild(col);
                                    };

                                    reader.readAsDataURL(file);
                                });
                            } else {
                                imagePreview.style.display = 'none';
                            }
                        }
                    </script>

                    <div class="form-actions">
                        <a href="<?php echo e(route('announcements.index')); ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Create Announcement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/announcements/create.blade.php ENDPATH**/ ?>