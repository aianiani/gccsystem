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
    </style>
    <div class="container">
        <h1>Edit Announcement</h1>
        <form action="<?php echo e(route('announcements.update', $announcement->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="<?php echo e(old('title', $announcement->title)); ?>" required>
                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" class="form-control" rows="5"
                    required><?php echo e(old('content', $announcement->content)); ?></textarea>
                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Attachment (optional)</label>
                <input type="file" name="attachment" id="attachment" class="form-control">
                <?php if($announcement->attachment): ?>
                    <p>Current: <a href="<?php echo e(asset('storage/' . $announcement->attachment)); ?>" target="_blank">View
                            Attachment</a></p>
                <?php endif; ?>
                <?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Images (optional)</label>
                <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple
                    onchange="previewImages(this)">
                <small class="text-muted">You can select multiple images. Supported formats: JPG, PNG, GIF. Max file size
                    per image: 5MB</small>
                <?php if($announcement->images && count($announcement->images) > 0): ?>
                    <div class="mt-2">
                        <strong>Current Images:</strong>
                        <div class="row g-2 mt-1" id="current-images">
                            <?php $__currentLoopData = $announcement->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-2 col-sm-3 col-4" id="image-<?php echo e($index); ?>" data-image-index="<?php echo e($index); ?>">
                                    <div class="position-relative image-container">
                                        <img src="<?php echo e(asset('storage/' . $image)); ?>" class="img-fluid rounded"
                                            style="width: 100%; height: 120px; object-fit: cover;">
                                        <button type="button"
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-image-btn"
                                            data-announcement-id="<?php echo e($announcement->id); ?>" data-image-index="<?php echo e($index); ?>"
                                            onclick="deleteImage(<?php echo e($announcement->id); ?>, <?php echo e($index); ?>)" title="Delete this image">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div id="image-preview" class="mt-3" style="display: none;">
                    <strong>New Images to Add:</strong>
                    <div class="row g-2 mt-1" id="preview-container"></div>
                </div>
            </div>

            <style>
                .image-container {
                    position: relative;
                }

                .delete-image-btn {
                    opacity: 0;
                    transition: opacity 0.2s ease-in-out;
                    padding: 0.25rem 0.5rem;
                    font-size: 0.75rem;
                    line-height: 1;
                }

                .image-container:hover .delete-image-btn {
                    opacity: 1;
                }
            </style>

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
                                                            <span class="badge bg-success">New ${index + 1}</span>
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

                function deleteImage(announcementId, imageIndex) {
                    if (!confirm('Are you sure you want to delete this image?')) {
                        return;
                    }

                    const imageElement = document.getElementById('image-' + imageIndex);
                    const deleteBtn = imageElement.querySelector('.delete-image-btn');

                    // Disable button and show loading state
                    deleteBtn.disabled = true;
                    deleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

                    fetch(`/announcements/${announcementId}/images/${imageIndex}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove the image element with fade effect
                                imageElement.style.opacity = '0';
                                imageElement.style.transition = 'opacity 0.3s ease-out';
                                setTimeout(() => {
                                    imageElement.remove();

                                    // Check if there are no more images
                                    const currentImagesContainer = document.getElementById('current-images');
                                    if (currentImagesContainer.children.length === 0) {
                                        currentImagesContainer.parentElement.remove();
                                    }
                                }, 300);
                            } else {
                                alert('Error: ' + (data.message || 'Failed to delete image'));
                                // Re-enable button
                                deleteBtn.disabled = false;
                                deleteBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while deleting the image.');
                            // Re-enable button
                            deleteBtn.disabled = false;
                            deleteBtn.innerHTML = '<i class="bi bi-x-lg"></i>';
                        });
                }
            </script>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?php echo e(route('announcements.index')); ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/announcements/edit.blade.php ENDPATH**/ ?>