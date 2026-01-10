@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Hero Image</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hero-images.index') }}">Hero Images</a></li>
            <li class="breadcrumb-item active">Edit Image</li>
        </ol>

        <div class="card mb-4" style="max-width: 600px;">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i> Edit Image Details
            </div>
            <div class="card-body">
                <form action="{{ route('admin.hero-images.update', $heroImage->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 text-center">
                        <label class="form-label d-block text-start">Current Image</label>
                        <img src="{{ asset($heroImage->image_path) }}" alt="Current Image" class="img-thumbnail mb-2"
                            style="max-height: 200px;">
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Change Image (Optional)</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*">
                        <div class="form-text">Leave blank to keep current image.</div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title / Alt Text</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $heroImage->title }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="order" name="order"
                                value="{{ $heroImage->order }}" min="0">
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ $heroImage->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active (Visible on Homepage)</label>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.hero-images.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Image</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection