@extends('layouts.app')

@section('content')
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

        /* Match admin zoom standard */
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

        .form-label {
            font-weight: 600;
            color: var(--forest-green);
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--gray-100);
            padding: 0.75rem 1rem;
            border-radius: 8px;
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
    </style>

    <div class="main-dashboard-inner home-zoom">
        <div class="page-header-card">
            <div>
                <h1><i class="fas fa-edit me-2"></i>Edit Hero Image</h1>
                <p>Update image details and visibility settings</p>
            </div>
            <div>
                <a href="{{ route('admin.hero-images.index') }}" class="btn btn-light text-success fw-bold">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="main-content-card">
                    <div class="card-header">
                        <i class="fas fa-pen-to-square me-2"></i> Edit Image Details
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.hero-images.update', $heroImage->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-5">
                                    <label class="form-label d-block text-start">Current Image</label>
                                    <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm border">
                                        <img src="{{ asset($heroImage->image_path) }}" alt="Current Image"
                                            style="object-fit: cover;">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <label for="image" class="form-label">Change Image (Optional)</label>
                                    <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                    <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i> Leave blank to keep
                                        current image.</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="title" class="form-label">Title / Alt Text</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $heroImage->title }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control" id="order" name="order"
                                        value="{{ $heroImage->order }}" min="0">
                                </div>
                                <div class="col-md-6 mb-4 d-flex align-items-center">
                                    <div class="form-check p-0 ms-3 mt-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                                value="1" {{ $heroImage->is_active ? 'checked' : '' }}
                                                style="width: 3em; height: 1.5em;">
                                            <label class="form-check-label ms-3 pt-1 fw-bold text-dark" for="is_active">Set
                                                as Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 text-muted">

                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('admin.hero-images.index') }}"
                                    class="btn btn-light border btn-lg px-4">Cancel</a>
                                <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                    <i class="fas fa-save me-2"></i>Update Image
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection