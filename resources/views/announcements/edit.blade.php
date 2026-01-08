@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Announcement</h1>
        <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $announcement->title) }}" required>
                @error('title')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" class="form-control" rows="5"
                    required>{{ old('content', $announcement->content) }}</textarea>
                @error('content')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Attachment (optional)</label>
                <input type="file" name="attachment" id="attachment" class="form-control">
                @if($announcement->attachment)
                    <p>Current: <a href="{{ asset('storage/' . $announcement->attachment) }}" target="_blank">View
                            Attachment</a></p>
                @endif
                @error('attachment')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Images (optional)</label>
                <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple
                    onchange="previewImages(this)">
                <small class="text-muted">You can select multiple images. Supported formats: JPG, PNG, GIF. Max file size
                    per image: 5MB</small>
                @if($announcement->images && count($announcement->images) > 0)
                    <div class="mt-2">
                        <strong>Current Images:</strong>
                        <div class="row g-2 mt-1" id="current-images">
                            @foreach($announcement->images as $index => $image)
                                <div class="col-md-2 col-sm-3 col-4" id="image-{{ $index }}" data-image-index="{{ $index }}">
                                    <div class="position-relative image-container">
                                        <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded"
                                            style="width: 100%; height: 120px; object-fit: cover;">
                                        <button type="button"
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-image-btn"
                                            data-announcement-id="{{ $announcement->id }}" data-image-index="{{ $index }}"
                                            onclick="deleteImage({{ $announcement->id }}, {{ $index }})" title="Delete this image">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @error('images.*')<div class="text-danger">{{ $message }}</div>@enderror
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
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
            <a href="{{ route('announcements.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection