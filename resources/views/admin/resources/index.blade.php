@extends('layouts.app')

@section('content')
    <style>
        :root {
            --forest-green: #1f7a2d;
            --forest-green-dark: #13601f;
            --forest-green-light: #4a7c59;
            --forest-green-lighter: #e8f5e9;
            --yellow-maize: #f4d03f;
            --gray-50: #f8f9fa;
            --gray-100: #e9ecef;
            --gray-200: #dee2e6;
            --gray-600: #6c757d;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --hero-gradient: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-dark) 100%);
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

        /* Page Header */
        .page-header {
            background: var(--hero-gradient);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            filter: blur(50px);
        }

        .page-header .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .page-header h1 {
            color: #fff;
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.85);
            margin: 0.5rem 0 0 0;
            font-size: 0.95rem;
        }

        .page-header .btn-add {
            background: #fff;
            color: var(--forest-green);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .page-header .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            color: var(--forest-green-dark);
        }

        /* Stats Cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-card .stat-icon.total {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
        }

        .stat-card .stat-icon.published {
            background: #d4edda;
            color: #28a745;
        }

        .stat-card .stat-icon.draft {
            background: #fff3cd;
            color: #856404;
        }

        .stat-card .stat-icon.videos {
            background: #e3f2fd;
            color: #1565c0;
        }

        .stat-card .stat-info h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: #1a1a1a;
        }

        .stat-card .stat-info p {
            margin: 0;
            color: var(--gray-600);
            font-size: 0.85rem;
        }

        /* Filter Bar */
        .filter-bar {
            background: #fff;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
        }

        .filter-bar .search-box {
            flex: 1;
            min-width: 200px;
            position: relative;
        }

        .filter-bar .search-box input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .filter-bar .search-box input:focus {
            outline: none;
            border-color: var(--forest-green);
            box-shadow: 0 0 0 3px rgba(31, 122, 45, 0.1);
        }

        .filter-bar .search-box i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-600);
        }

        .filter-bar select {
            padding: 0.6rem 2rem 0.6rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .filter-bar select:focus {
            outline: none;
            border-color: var(--forest-green);
        }

        /* View Toggle */
        .view-toggle {
            display: flex;
            background: var(--gray-50);
            border-radius: 8px;
            padding: 4px;
        }

        .view-toggle button {
            padding: 0.5rem 0.75rem;
            border: none;
            background: transparent;
            color: var(--gray-600);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .view-toggle button.active {
            background: #fff;
            color: var(--forest-green);
            box-shadow: var(--shadow-sm);
        }

        /* Resources Grid */
        .resources-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.25rem;
        }

        /* Resource Card */
        .resource-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            transition: all 0.3s ease;
        }

        .resource-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--forest-green-lighter);
        }

        .resource-card .card-thumbnail {
            height: 140px;
            background: linear-gradient(135deg, var(--forest-green-lighter), #c8e6c9);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .resource-card .card-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .resource-card .card-thumbnail .thumbnail-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--forest-green);
        }

        .resource-card .type-badge {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .resource-card .type-badge.video {
            background: #1565c0;
            color: #fff;
        }

        .resource-card .type-badge.image {
            background: #e65100;
            color: #fff;
        }

        .resource-card .type-badge.file {
            background: #c2185b;
            color: #fff;
        }

        .resource-card .type-badge.article {
            background: var(--forest-green);
            color: #fff;
        }

        .resource-card .status-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .resource-card .status-badge.published {
            background: #28a745;
            color: #fff;
        }

        .resource-card .status-badge.draft {
            background: #ffc107;
            color: #212529;
        }

        .resource-card .card-content {
            padding: 1.25rem;
        }

        .resource-card .card-category {
            font-size: 0.7rem;
            color: var(--forest-green);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.4rem;
        }

        .resource-card .card-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .resource-card .card-description {
            font-size: 0.85rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .resource-card .card-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-100);
        }

        .resource-card .card-meta span {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .resource-card .card-actions {
            display: flex;
            gap: 0.5rem;
        }

        .resource-card .card-actions a,
        .resource-card .card-actions button {
            flex: 1;
            padding: 0.6rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .resource-card .btn-view {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
        }

        .resource-card .btn-view:hover {
            background: var(--forest-green);
            color: #fff;
        }

        .resource-card .btn-edit {
            background: #e3f2fd;
            color: #1565c0;
        }

        .resource-card .btn-edit:hover {
            background: #1565c0;
            color: #fff;
        }

        .resource-card .btn-delete {
            background: #fce4ec;
            color: #c2185b;
        }

        .resource-card .btn-delete:hover {
            background: #c2185b;
            color: #fff;
        }

        /* Table View */
        .resources-table-wrapper {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-100);
            display: none;
        }

        .resources-table-wrapper.active {
            display: block;
        }

        .resources-table {
            width: 100%;
            border-collapse: collapse;
        }

        .resources-table th {
            background: var(--gray-50);
            padding: 1rem 1.25rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-600);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--gray-100);
        }

        .resources-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            vertical-align: middle;
        }

        .resources-table tr:last-child td {
            border-bottom: none;
        }

        .resources-table tr:hover {
            background: var(--gray-50);
        }

        .resources-table .resource-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .resources-table .resource-thumb {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: var(--forest-green-lighter);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--forest-green);
            font-size: 1.25rem;
            overflow: hidden;
        }

        .resources-table .resource-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .resources-table .resource-title {
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.2rem;
        }

        .resources-table .resource-desc {
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .resources-table .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .resources-table .action-btns {
            display: flex;
            gap: 0.5rem;
        }

        .resources-table .action-btns a,
        .resources-table .action-btns button {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: #fff;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
        }

        .empty-state .empty-icon {
            width: 100px;
            height: 100px;
            background: var(--forest-green-lighter);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: var(--forest-green);
        }

        .empty-state h3 {
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--gray-600);
            margin-bottom: 1.5rem;
        }

        .empty-state .btn-create {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--forest-green);
            color: #fff;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .empty-state .btn-create:hover {
            background: var(--forest-green-dark);
            color: #fff;
            transform: translateY(-2px);
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        /* Alert */
        .success-alert {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #155724;
        }

        .success-alert i {
            font-size: 1.25rem;
        }

        .success-alert .close-btn {
            margin-left: auto;
            background: none;
            border: none;
            color: #155724;
            cursor: pointer;
            padding: 0.25rem;
        }
    </style>

    <div class="main-dashboard-inner home-zoom">
        @if (session('success'))
            <div class="success-alert" id="successAlert">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button class="close-btn" onclick="this.parentElement.remove()">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div>
                    <h1><i class="bi bi-collection me-2"></i>Resources Management</h1>
                    <p>Manage educational materials for students</p>
                </div>
                <a href="{{ route('admin.resources.create') }}" class="btn-add">
                    <i class="bi bi-plus-lg"></i>
                    Add Resource
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="bi bi-collection"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $resources->total() }}</h3>
                    <p>Total Resources</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon published">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $resources->where('is_published', true)->count() }}</h3>
                    <p>Published</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon draft">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $resources->where('is_published', false)->count() }}</h3>
                    <p>Drafts</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon videos">
                    <i class="bi bi-play-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $resources->where('type', 'video')->count() }}</h3>
                    <p>Videos</p>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Search resources...">
            </div>
            <select id="categoryFilter">
                <option value="">All Categories</option>
                <option value="Mental Health">Mental Health</option>
                <option value="Orientation">Orientation</option>
                <option value="Academic Support">Academic Support</option>
                <option value="Career Guidance">Career Guidance</option>
                <option value="Other">Other</option>
            </select>
            <select id="typeFilter">
                <option value="">All Types</option>
                <option value="video">Video</option>
                <option value="image">Image</option>
                <option value="file">Document</option>
                <option value="article">Link</option>
            </select>
            <select id="statusFilter">
                <option value="">All Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
            <div class="view-toggle">
                <button class="active" data-view="grid" title="Grid View">
                    <i class="bi bi-grid-3x3-gap"></i>
                </button>
                <button data-view="table" title="Table View">
                    <i class="bi bi-list-ul"></i>
                </button>
            </div>
        </div>

        @if ($resources->count() > 0)
            <!-- Grid View -->
            <div class="resources-grid" id="gridView">
                @foreach ($resources as $resource)
                    <div class="resource-card" data-title="{{ strtolower($resource->title) }}"
                        data-category="{{ $resource->category }}" data-type="{{ $resource->type }}"
                        data-status="{{ $resource->is_published ? 'published' : 'draft' }}">
                        <div class="card-thumbnail">
                            <span class="type-badge {{ $resource->type }}">{{ ucfirst($resource->type) }}</span>
                            <span
                                class="status-badge {{ $resource->is_published ? 'published' : 'draft' }}">{{ $resource->is_published ? 'Published' : 'Draft' }}</span>

                            @if ($resource->type == 'video')
                                @php
                                    preg_match(
                                        '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\s]+)/',
                                        $resource->content,
                                        $matches,
                                    );
                                    $videoId = $matches[1] ?? null;
                                @endphp
                                @if ($videoId)
                                    <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg"
                                        alt="{{ $resource->title }}">
                                @else
                                    <div class="thumbnail-icon"><i class="bi bi-play-circle"></i></div>
                                @endif
                            @elseif($resource->type == 'image' && $resource->file_path)
                                <img src="{{ asset('storage/' . $resource->file_path) }}"
                                    alt="{{ $resource->title }}">
                            @elseif($resource->type == 'file')
                                <div class="thumbnail-icon"><i class="bi bi-file-earmark-pdf"></i></div>
                            @else
                                <div class="thumbnail-icon"><i class="bi bi-link-45deg"></i></div>
                            @endif
                        </div>

                        <div class="card-content">
                            <div class="card-category">{{ $resource->category }}</div>
                            <h3 class="card-title">{{ $resource->title }}</h3>
                            <p class="card-description">
                                {{ $resource->description ?? 'No description available.' }}</p>

                            <div class="card-meta">
                                <span><i class="bi bi-calendar3"></i>
                                    {{ $resource->created_at->format('M d, Y') }}</span>
                                @if ($resource->file_size)
                                    <span><i class="bi bi-hdd"></i>
                                        {{ number_format($resource->file_size / (1024 * 1024), 1) }} MB</span>
                                @endif
                            </div>

                            <div class="card-actions">
                                <a href="{{ $resource->file_path ? asset('storage/' . $resource->file_path) : $resource->content }}"
                                    target="_blank" class="btn-view">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('admin.resources.edit', $resource) }}" class="btn-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.resources.destroy', $resource) }}" method="POST"
                                    class="d-inline" style="flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete w-100"
                                        onclick="return confirm('Are you sure you want to delete this resource?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Table View -->
            <div class="resources-table-wrapper" id="tableView">
                <table class="resources-table">
                    <thead>
                        <tr>
                            <th>Resource</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resources as $resource)
                            <tr data-title="{{ strtolower($resource->title) }}"
                                data-category="{{ $resource->category }}" data-type="{{ $resource->type }}"
                                data-status="{{ $resource->is_published ? 'published' : 'draft' }}">
                                <td>
                                    <div class="resource-info">
                                        <div class="resource-thumb">
                                            @if ($resource->type == 'video')
                                                @php
                                                    preg_match(
                                                        '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\s]+)/',
                                                        $resource->content,
                                                        $matches,
                                                    );
                                                    $videoId = $matches[1] ?? null;
                                                @endphp
                                                @if ($videoId)
                                                    <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg"
                                                        alt="">
                                                @else
                                                    <i class="bi bi-play-circle"></i>
                                                @endif
                                            @elseif($resource->type == 'image' && $resource->file_path)
                                                <img src="{{ asset('storage/' . $resource->file_path) }}" alt="">
                                            @elseif($resource->type == 'file')
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            @else
                                                <i class="bi bi-link-45deg"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="resource-title">{{ Str::limit($resource->title, 40) }}</div>
                                            <div class="resource-desc">
                                                {{ Str::limit($resource->description ?? 'No description', 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge"
                                        style="background: var(--forest-green-lighter); color: var(--forest-green);">{{ $resource->category }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $resource->type }}"
                                        style="background: {{ $resource->type == 'video' ? '#e3f2fd' : ($resource->type == 'image' ? '#fff3e0' : ($resource->type == 'file' ? '#fce4ec' : '#e8f5e9')) }}; color: {{ $resource->type == 'video' ? '#1565c0' : ($resource->type == 'image' ? '#e65100' : ($resource->type == 'file' ? '#c2185b' : '#2e7d32')) }};">
                                        <i
                                            class="bi bi-{{ $resource->type == 'video' ? 'play-circle' : ($resource->type == 'image' ? 'image' : ($resource->type == 'file' ? 'file-earmark' : 'link-45deg')) }} me-1"></i>
                                        {{ ucfirst($resource->type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge"
                                        style="background: {{ $resource->is_published ? '#d4edda' : '#fff3cd' }}; color: {{ $resource->is_published ? '#155724' : '#856404' }};">
                                        {{ $resource->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>{{ $resource->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="action-btns">
                                        <a href="{{ $resource->file_path ? asset('storage/' . $resource->file_path) : $resource->content }}"
                                            target="_blank" class="btn-view" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.resources.edit', $resource) }}" class="btn-edit"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.resources.destroy', $resource) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" title="Delete"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $resources->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-collection"></i>
                </div>
                <h3>No Resources Yet</h3>
                <p>Start by adding your first educational resource for students.</p>
                <a href="{{ route('admin.resources.create') }}" class="btn-create">
                    <i class="bi bi-plus-lg"></i>
                    Add First Resource
                </a>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View toggle
            const viewButtons = document.querySelectorAll('.view-toggle button');
            const gridView = document.getElementById('gridView');
            const tableView = document.getElementById('tableView');

            viewButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    viewButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    if (this.dataset.view === 'grid') {
                        gridView.style.display = 'grid';
                        tableView.classList.remove('active');
                    } else {
                        gridView.style.display = 'none';
                        tableView.classList.add('active');
                    }
                });
            });

            // Filtering
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const typeFilter = document.getElementById('typeFilter');
            const statusFilter = document.getElementById('statusFilter');
            const cards = document.querySelectorAll('.resource-card');
            const rows = document.querySelectorAll('.resources-table tbody tr');

            function filterResources() {
                const search = searchInput.value.toLowerCase();
                const category = categoryFilter.value;
                const type = typeFilter.value;
                const status = statusFilter.value;

                const items = [...cards, ...rows];

                items.forEach(item => {
                    const title = item.dataset.title || '';
                    const itemCategory = item.dataset.category || '';
                    const itemType = item.dataset.type || '';
                    const itemStatus = item.dataset.status || '';

                    let show = true;

                    if (search && !title.includes(search)) show = false;
                    if (category && itemCategory !== category) show = false;
                    if (type && itemType !== type) show = false;
                    if (status && itemStatus !== status) show = false;

                    item.style.display = show ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterResources);
            categoryFilter.addEventListener('change', filterResources);
            typeFilter.addEventListener('change', filterResources);
            statusFilter.addEventListener('change', filterResources);

            // Auto-hide success alert
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    successAlert.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => successAlert.remove(), 300);
                }, 5000);
            }
        });
    </script>
@endsection