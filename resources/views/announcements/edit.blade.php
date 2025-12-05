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
                        <div class="row g-2 mt-1">
                            @foreach($announcement->images as $index => $image)
                                <div class="col-md-2 col-sm-3 col-4">
                                    <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded"
                                        style="width: 100%; height: 120px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @error('images.*')<div class="text-danger">{{ $message }}</div>@enderror
                <div id="image-preview" class="mt-3" style="display: none;">
                    <strong>New Images:</strong>
                    <div class="row g-2 mt-1" id="preview-container"></div>
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
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('announcements.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection