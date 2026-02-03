

<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --forest-green: #1f7a2d;
            --forest-green-light: #4a7c59;
            --forest-green-lighter: #e8f5e8;
            --yellow-maize: #f4d03f;
            --gray-50: #f8f9fa;
            --gray-100: #dee2e6;
            --gray-600: #6c757d;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hero-gradient: linear-gradient(135deg, var(--forest-green) 0%, #13601f 100%);
        }

        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
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
        }

        .main-content-card .card-body {
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
            position: relative;
            overflow: hidden;
        }

        .page-header-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(40px);
        }

        .page-header-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .page-header-card p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .form-label {
            font-weight: 600;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--gray-100);
            padding: 0.75rem 1rem;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--forest-green);
            box-shadow: 0 0 0 0.25rem rgba(31, 122, 45, 0.15);
        }

        .form-check-input:checked {
            background-color: var(--forest-green);
            border-color: var(--forest-green);
        }

        .input-group-text {
            background: var(--forest-green-lighter);
            border: 1px solid var(--gray-100);
            color: var(--forest-green);
        }

        .type-selector {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .type-option {
            flex: 1;
            min-width: 100px;
            padding: 1rem;
            border: 2px solid var(--gray-100);
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #fff;
        }

        .type-option:hover {
            border-color: var(--forest-green-light);
            background: var(--forest-green-lighter);
        }

        .type-option.active {
            border-color: var(--forest-green);
            background: var(--forest-green-lighter);
        }

        .type-option i {
            font-size: 1.75rem;
            color: var(--forest-green);
            margin-bottom: 0.35rem;
        }

        .type-option .type-label {
            font-weight: 600;
            color: var(--forest-green);
            display: block;
            font-size: 0.9rem;
        }

        .type-option .type-desc {
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        .source-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .source-option {
            flex: 1;
            padding: 1rem;
            border: 2px solid var(--gray-100);
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #fff;
        }

        .source-option:hover {
            border-color: var(--forest-green-light);
        }

        .source-option.active {
            border-color: var(--forest-green);
            background: var(--forest-green-lighter);
        }

        .source-option i {
            font-size: 1.5rem;
            color: var(--forest-green);
        }

        .source-option span {
            display: block;
            font-weight: 600;
            color: var(--forest-green);
            margin-top: 0.25rem;
        }

        .upload-zone {
            border: 2px dashed var(--gray-100);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: var(--gray-50);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: var(--forest-green);
            background: var(--forest-green-lighter);
        }

        .upload-zone i {
            font-size: 3rem;
            color: var(--forest-green);
            margin-bottom: 1rem;
        }

        .upload-zone p {
            margin: 0;
            color: var(--gray-600);
        }

        .upload-zone .file-name {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            color: var(--forest-green);
        }

        .preview-card {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px dashed var(--gray-100);
            text-align: center;
        }

        .preview-card i {
            font-size: 3rem;
            color: var(--gray-100);
        }

        .preview-card p {
            margin: 0.5rem 0 0 0;
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .publish-toggle {
            background: var(--forest-green-lighter);
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .publish-toggle .toggle-info h6 {
            margin: 0 0 0.25rem 0;
            font-weight: 600;
            color: var(--forest-green);
        }

        .publish-toggle .toggle-info p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }
    </style>

    <div class="main-dashboard-inner home-zoom">
        <div class="page-header-card">
            <div>
                <h1><i class="bi bi-plus-circle-fill me-2"></i>Create New Resource</h1>
                <p>Add educational materials for students to access</p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.resources.index')); ?>" class="btn btn-light text-success fw-bold">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>

        <form action="<?php echo e(route('admin.resources.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Main Content Card -->
                    <div class="main-content-card">
                        <div class="card-header">
                            <i class="bi bi-file-earmark-text me-2"></i> Resource Details
                        </div>
                        <div class="card-body">
                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label">
                                    <i class="bi bi-type me-1"></i>Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="title" name="title" value="<?php echo e(old('title')); ?>"
                                    placeholder="Enter resource title..." required>
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

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label">
                                    <i class="bi bi-text-paragraph me-1"></i>Description
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description"
                                    rows="3" placeholder="Briefly describe what this resource is about..."><?php echo e(old('description')); ?></textarea>
                                <?php $__errorArgs = ['description'];
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

                            <!-- Resource Type Selector -->
                            <div class="mb-4">
                                <label class="form-label mb-3">
                                    <i class="bi bi-collection me-1"></i>Resource Type <span class="text-danger">*</span>
                                </label>
                                <div class="type-selector">
                                    <label class="type-option" data-type="video">
                                        <input type="radio" name="type" value="video" class="d-none"
                                            <?php echo e(old('type', 'video') == 'video' ? 'checked' : ''); ?>>
                                        <i class="bi bi-play-circle-fill d-block"></i>
                                        <span class="type-label">Video</span>
                                        <span class="type-desc">MP4, YouTube</span>
                                    </label>
                                    <label class="type-option" data-type="image">
                                        <input type="radio" name="type" value="image" class="d-none"
                                            <?php echo e(old('type') == 'image' ? 'checked' : ''); ?>>
                                        <i class="bi bi-image-fill d-block"></i>
                                        <span class="type-label">Image</span>
                                        <span class="type-desc">JPG, PNG, GIF</span>
                                    </label>
                                    <label class="type-option" data-type="file">
                                        <input type="radio" name="type" value="file" class="d-none"
                                            <?php echo e(old('type') == 'file' ? 'checked' : ''); ?>>
                                        <i class="bi bi-file-earmark-pdf-fill d-block"></i>
                                        <span class="type-label">Document</span>
                                        <span class="type-desc">PDF, DOC, PPT</span>
                                    </label>
                                    <label class="type-option" data-type="article">
                                        <input type="radio" name="type" value="article" class="d-none"
                                            <?php echo e(old('type') == 'article' ? 'checked' : ''); ?>>
                                        <i class="bi bi-link-45deg d-block"></i>
                                        <span class="type-label">Link</span>
                                        <span class="type-desc">External URL</span>
                                    </label>
                                </div>
                                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Content Source Selector -->
                            <div class="mb-4">
                                <label class="form-label mb-3">
                                    <i class="bi bi-cloud-arrow-up me-1"></i>Content Source <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="source-selector">
                                    <label class="source-option" data-source="url">
                                        <input type="radio" name="content_source" value="url" class="d-none"
                                            <?php echo e(old('content_source', 'url') == 'url' ? 'checked' : ''); ?>>
                                        <i class="bi bi-link-45deg"></i>
                                        <span>Paste URL</span>
                                    </label>
                                    <label class="source-option" data-source="upload">
                                        <input type="radio" name="content_source" value="upload" class="d-none"
                                            <?php echo e(old('content_source') == 'upload' ? 'checked' : ''); ?>>
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <span>Upload File</span>
                                    </label>
                                </div>
                            </div>

                            <!-- URL Input Section -->
                            <div class="content-section" id="urlSection">
                                <div class="mb-4">
                                    <label for="content" class="form-label">
                                        <i class="bi bi-link-45deg me-1"></i>URL / Link <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                        <input type="url" class="form-control <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="content" name="content" value="<?php echo e(old('content')); ?>"
                                            placeholder="https://...">
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Paste YouTube URL, article link, or any external resource URL.
                                    </div>
                                    <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- File Upload Section -->
                            <div class="content-section" id="uploadSection">
                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="bi bi-cloud-arrow-up me-1"></i>Upload File <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="upload-zone" id="uploadZone">
                                        <input type="file" name="file" id="fileInput" class="d-none"
                                            accept="video/*,image/*,.pdf,.doc,.docx,.ppt,.pptx">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <p><strong>Click to upload</strong> or drag and drop</p>
                                        <p class="small text-muted">Maximum file size: 50MB</p>
                                        <div class="file-name d-none" id="fileName">
                                            <i class="bi bi-file-earmark"></i>
                                            <span></span>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Category Card -->
                    <div class="main-content-card">
                        <div class="card-header">
                            <i class="bi bi-tag me-2"></i> Category
                        </div>
                        <div class="card-body">
                            <select class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="category"
                                name="category" required>
                                <option value="" disabled <?php echo e(old('category') ? '' : 'selected'); ?>>Select a category...
                                </option>
                                <?php $__currentLoopData = ['Mental Health', 'Orientation', 'Academic Support', 'Career Guidance', 'Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat); ?>" <?php echo e(old('category') == $cat ? 'selected' : ''); ?>>
                                        <?php echo e($cat); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category'];
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
                    </div>

                    <!-- Publish Settings Card -->
                    <div class="main-content-card">
                        <div class="card-header">
                            <i class="bi bi-gear me-2"></i> Settings
                        </div>
                        <div class="card-body">
                            <div class="publish-toggle">
                                <div class="toggle-info">
                                    <h6><i class="bi bi-eye me-1"></i>Publish Resource</h6>
                                    <p>Make visible to students</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="is_published"
                                        name="is_published" value="1"
                                        <?php echo e(old('is_published', '1') ? 'checked' : ''); ?>

                                        style="width: 3rem; height: 1.5rem;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Card -->
                    <div class="main-content-card">
                        <div class="card-header">
                            <i class="bi bi-eye me-2"></i> Preview
                        </div>
                        <div class="card-body">
                            <div class="preview-card" id="previewArea">
                                <i class="bi bi-image"></i>
                                <p>Preview will appear here</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg shadow-sm">
                            <i class="bi bi-plus-circle me-2"></i>Create Resource
                        </button>
                        <a href="<?php echo e(route('admin.resources.index')); ?>" class="btn btn-light border">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Type selector toggle
            const typeOptions = document.querySelectorAll('.type-option');
            typeOptions.forEach(option => {
                const radio = option.querySelector('input[type="radio"]');
                if (radio.checked) {
                    option.classList.add('active');
                }
                option.addEventListener('click', function() {
                    typeOptions.forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                    this.querySelector('input[type="radio"]').checked = true;
                });
            });

            // Source selector toggle
            const sourceOptions = document.querySelectorAll('.source-option');
            const urlSection = document.getElementById('urlSection');
            const uploadSection = document.getElementById('uploadSection');

            function updateSourceSections() {
                const selectedSource = document.querySelector('input[name="content_source"]:checked');
                if (selectedSource) {
                    if (selectedSource.value === 'url') {
                        urlSection.classList.add('active');
                        uploadSection.classList.remove('active');
                    } else {
                        urlSection.classList.remove('active');
                        uploadSection.classList.add('active');
                    }
                }
            }

            sourceOptions.forEach(option => {
                const radio = option.querySelector('input[type="radio"]');
                if (radio.checked) {
                    option.classList.add('active');
                }
                option.addEventListener('click', function() {
                    sourceOptions.forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                    this.querySelector('input[type="radio"]').checked = true;
                    updateSourceSections();
                });
            });

            updateSourceSections();

            // File upload handling
            const uploadZone = document.getElementById('uploadZone');
            const fileInput = document.getElementById('fileInput');
            const fileName = document.getElementById('fileName');
            const previewArea = document.getElementById('previewArea');

            uploadZone.addEventListener('click', () => fileInput.click());

            uploadZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadZone.classList.add('dragover');
            });

            uploadZone.addEventListener('dragleave', () => {
                uploadZone.classList.remove('dragover');
            });

            uploadZone.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadZone.classList.remove('dragover');
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    updateFileName();
                }
            });

            fileInput.addEventListener('change', updateFileName);

            function updateFileName() {
                if (fileInput.files.length) {
                    const file = fileInput.files[0];
                    fileName.classList.remove('d-none');
                    fileName.querySelector('span').textContent = file.name;

                    // Update preview based on file type
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            previewArea.innerHTML = `
                                <img src="${e.target.result}" alt="Preview" 
                                     style="max-width: 100%; max-height: 150px; border-radius: 8px;">
                                <p class="mt-2">${file.name}</p>
                            `;
                        };
                        reader.readAsDataURL(file);
                    } else if (file.type.startsWith('video/')) {
                        previewArea.innerHTML = `
                            <i class="bi bi-film" style="color: var(--forest-green);"></i>
                            <p class="mt-2">${file.name}</p>
                            <small class="text-muted">${(file.size / (1024 * 1024)).toFixed(2)} MB</small>
                        `;
                    } else {
                        previewArea.innerHTML = `
                            <i class="bi bi-file-earmark" style="color: var(--forest-green);"></i>
                            <p class="mt-2">${file.name}</p>
                            <small class="text-muted">${(file.size / (1024 * 1024)).toFixed(2)} MB</small>
                        `;
                    }
                }
            }

            // URL Preview functionality
            const contentInput = document.getElementById('content');

            function updateUrlPreview() {
                const url = contentInput.value.trim();
                if (!url) {
                    previewArea.innerHTML = `
                        <i class="bi bi-image"></i>
                        <p>Preview will appear here</p>
                    `;
                    return;
                }

                // Check if it's a YouTube URL
                const youtubeMatch = url.match(
                    /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\s]+)/);
                if (youtubeMatch) {
                    const videoId = youtubeMatch[1];
                    previewArea.innerHTML = `
                        <img src="https://img.youtube.com/vi/${videoId}/mqdefault.jpg" 
                             alt="Video thumbnail" 
                             style="max-width: 100%; border-radius: 8px;">
                        <p class="mt-2"><i class="bi bi-youtube text-danger"></i> YouTube Video</p>
                    `;
                    return;
                }

                // Generic URL preview
                previewArea.innerHTML = `
                    <i class="bi bi-link-45deg" style="color: var(--forest-green);"></i>
                    <p class="mt-2 text-truncate" style="max-width: 100%;">${url}</p>
                `;
            }

            contentInput.addEventListener('input', updateUrlPreview);
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/admin/resources/create.blade.php ENDPATH**/ ?>