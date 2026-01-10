@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Add Hero Image</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.hero-images.index') }}">Hero Images</a></li>
            <li class="breadcrumb-item active">Add New</li>
        </ol>

        <div class="card mb-4" style="max-width: 600px;">
            <div class="card-header">
                <i class="fas fa-plus me-1"></i> Upload New Image
            </div>
            <div class="card-body">
                <form action="{{ route('admin.hero-images.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="image" class="form-label">Image File <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="image" name="image" required accept="image/*">
                        <div class="form-text">Recommended size: 1000x800px or larger. Max size: 2MB.</div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title / Alt Text (Optional)</label>
                        <input type="text" class="form-control" id="title" name="title"
                            placeholder="Description of the image">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="order" name="order" value="0" min="0">
                            <div class="form-text">Lower numbers appear first.</div>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Active (Visible on Homepage)</label>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.hero-images.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Upload Image</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection