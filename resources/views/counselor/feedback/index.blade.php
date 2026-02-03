@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables */
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-600: var(--text-light);
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        /* Apply page zoom */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styles to ensure fixed positioning works correctly */
        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0, 0, 0, 0.08);
            overflow-y: auto;
            padding-bottom: 1rem;
        }

        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: margin-left 0.2s;
        }

        .main-dashboard-inner {
            max-width: 100%;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .welcome-card {
            background: var(--hero-gradient);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 1.5rem 1.5rem;
            margin-bottom: 1.5rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            min-height: 100px;
        }

        .welcome-card .welcome-text {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }

        .welcome-card .welcome-date {
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Reuse premium dashboard styles */
        .filter-control {
            background: #fff;
            border: 1.5px solid var(--gray-100);
            border-radius: 12px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            color: var(--text-dark);
            transition: all 0.2s;
            width: 100%;
        }

        .filter-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(31, 122, 45, 0.1);
            outline: none;
        }

        .filter-select {
            background: #fff;
            border: 1.5px solid var(--gray-100);
            border-radius: 12px;
            padding: 0.6rem 2rem 0.6rem 1rem;
            font-size: 0.9rem;
            color: var(--text-dark);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-filter {
            background: var(--forest-green);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-filter:hover {
            background: var(--forest-green-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(31, 122, 45, 0.2);
        }

        .btn-reset {
            background: var(--gray-50);
            color: var(--text-light);
            border: 1.5px solid var(--gray-100);
            border-radius: 12px;
            padding: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-reset:hover {
            background: #fff;
            color: var(--primary-green);
            border-color: var(--primary-green);
        }

        /* Table Aesthetics */
        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--gray-50);
            margin-right: 0.85rem;
        }

        .user-details h6 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .user-details span {
            font-size: 0.75rem;
            color: var(--text-light);
            font-weight: 500;
        }

        .comments-preview {
            font-size: 0.9rem;
            color: var(--text-light);
            font-style: italic;
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4;
        }

        /* Bulk Actions Bar */
        .bulk-actions-bar {
            position: fixed;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            border: 1px solid var(--gray-100);
            border-radius: 100px;
            padding: 0.75rem;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            min-width: 400px;
        }

        .bulk-actions-bar.active {
            bottom: 30px;
        }

        .selected-badge {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 0.5rem 1rem;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .bulk-btn {
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .bulk-btn-delete {
            background: #fff;
            color: var(--danger);
            border: 1.5px solid #ff000015;
        }

        .bulk-btn-delete:hover {
            background: #fff5f5;
            transform: translateY(-1px);
        }

        /* Custom Checkbox */
        .custom-checkbox {
            position: relative;
            width: 20px;
            height: 20px;
        }

        .custom-checkbox input {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .custom-checkbox label {
            position: absolute;
            top: 0;
            left: 0;
            width: 20px;
            height: 20px;
            background: #fff;
            border: 2px solid var(--gray-100);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-checkbox input:checked + label {
            background: var(--primary-green);
            border-color: var(--primary-green);
        }

        .custom-checkbox input:checked + label:after {
            content: '';
            position: absolute;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid var(--gray-100);
            background: #fff;
        }

        .btn-action.view { color: var(--primary-green); }
        .btn-action.view:hover { background: var(--light-green); border-color: var(--primary-green); }
        .btn-action.delete { color: var(--danger); }
        .btn-action.delete:hover { background: #fff5f5; border-color: var(--danger); }

        .pagination-wrap {
            padding: 1.5rem;
            background: #fff;
            border-top: 1px solid var(--gray-50);
        }

        @media (max-width: 991.98px) {
            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .main-dashboard-content {
                margin-left: 0;
            }
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="counselorSidebarToggle" class="d-md-none"
                style="position: fixed; top: 10px; left: 10px; z-index: 1050; border: none; background: var(--forest-green); color: white; padding: 5px 10px; border-radius: 5px;">
                <i class="bi bi-list"></i>
            </button>

            <!-- Sidebar -->
            @include('counselor.sidebar')

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner">
                    <!-- Header -->
                    <div class="welcome-card mb-4" style="min-height: auto; padding: 1.5rem;">
                        <div>
                            <div class="welcome-text" style="font-size: 1.5rem;">Student Feedback</div>
                            <div style="font-size: 0.9rem; margin-top: 0.25rem; opacity: 0.9;">
                                Review ratings and comments from your counseling sessions.
                            </div>
                        </div>
                        <div class="d-none d-md-block" style="font-size: 2rem; opacity: 0.8;">
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                    </div>

                    <!-- Statistics Bar (Optional, can add later) -->

                    <!-- Filter Bar -->
                    <div class="main-content-card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="card-body p-3">
                            <form action="{{ route('counselor.feedback.index') }}" method="GET" class="row g-3">
                                <div class="col-md-4">
                                    <div class="search-box position-relative">
                                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                        <input type="text" name="student" class="filter-control ps-5"
                                            placeholder="Search student or ID..." value="{{ request('student') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select name="rating" class="filter-select w-100">
                                        <option value="">All Ratings</option>
                                        @for ($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                                {{ $i }} Stars
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="per_page" class="filter-select w-100">
                                        @foreach ([10, 20, 30, 50, 100] as $count)
                                            <option value="{{ $count }}"
                                                {{ request('per_page') == $count ? 'selected' : '' }}>
                                                {{ $count }} Per Page
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <button type="submit" class="btn-filter flex-grow-1">
                                        <i class="bi bi-funnel-fill me-2"></i>Filter
                                    </button>
                                    <a href="{{ route('counselor.feedback.index') }}" class="btn-reset">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Bulk Actions Bar -->
                    <div id="bulkBar" class="bulk-actions-bar shadow-lg">
                        <div class="container-fluid d-flex align-items-center justify-content-between px-4">
                            <div class="d-flex align-items-center gap-3">
                                <span class="selected-badge"><span id="selectedCount">0</span> selected</span>
                                <div class="v-divider"></div>
                                <button type="button" id="bulkDeleteBtn" class="bulk-btn bulk-btn-delete">
                                    <i class="bi bi-trash3-fill me-2"></i>Delete Selected
                                </button>
                            </div>
                            <button type="button" id="closeBulkBar" class="btn-close-bulk">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <form id="bulk-delete-form" action="{{ route('counselor.feedback.bulkDestroy') }}" method="POST"
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <!-- Feedback List Card -->
                    <div class="main-content-card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4 py-3" style="width: 40px;">
                                                <div class="custom-checkbox">
                                                    <input type="checkbox" id="selectAll">
                                                    <label for="selectAll"></label>
                                                </div>
                                            </th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold"
                                                style="letter-spacing: 0.5px;">Student</th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold"
                                                style="letter-spacing: 0.5px; width: 150px;">Rating</th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold"
                                                style="letter-spacing: 0.5px;">Comments</th>
                                            <th class="py-3 text-secondary text-uppercase small font-weight-bold"
                                                style="letter-spacing: 0.5px; width: 130px;">Date & Time</th>
                                            <th class="pe-4 py-3 text-end text-secondary text-uppercase small font-weight-bold"
                                                style="letter-spacing: 0.5px; width: 100px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($feedbacks as $feedback)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="custom-checkbox">
                                                        <input type="checkbox" class="item-checkbox" id="check-{{ $feedback->id }}"
                                                            value="{{ $feedback->id }}">
                                                        <label for="check-{{ $feedback->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $feedback->appointment->student->avatar_url }}"
                                                            class="user-avatar" alt="">
                                                        <div class="user-details">
                                                            <h6>{{ $feedback->appointment->student->name }}</h6>
                                                            <span>{{ $feedback->appointment->student->student_id ?? '-' }} •
                                                                {{ $feedback->appointment->student->college ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <div class="star-rating d-flex text-warning">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="bi bi-star{{ $i <= $feedback->rating ? '-fill' : '' }}"></i>
                                                            @endfor
                                                        </div>
                                                        <span class="small text-muted fw-semibold mt-1">{{ $feedback->rating }}/5
                                                            Rating</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="comments-preview" title="{{ $feedback->comments }}">
                                                        "{{ $feedback->comments }}"
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="fw-semibold">{{ $feedback->created_at->format('M d, Y') }}</span>
                                                        <span
                                                            class="text-muted small">{{ $feedback->created_at->format('g:i A') }}</span>
                                                    </div>
                                                </td>
                                                <td class="pe-4 text-end">
                                                    <div class="actions-cell justify-content-end">
                                                        <a href="{{ route('counselor.feedback.show', $feedback->id) }}"
                                                            class="btn-action view" title="View Details">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </a>
                                                        <button type="button" class="btn-action delete" title="Delete"
                                                            onclick="confirmDelete({{ $feedback->id }})">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                        <form id="delete-form-{{ $feedback->id }}"
                                                            action="{{ route('counselor.feedback.bulkDestroy') }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="ids[]" value="{{ $feedback->id }}">
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5">
                                                    <div class="empty-state text-center py-5">
                                                        <i class="bi bi-chat-left-text fs-1 text-muted opacity-25"></i>
                                                        <h5 class="mt-3 fw-bold">No feedback found</h5>
                                                        <p class="text-muted">Student ratings and reviews will appear here.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Status & Links -->
                            <div class="pagination-wrap">
                                {{ $feedbacks->links('vendor.pagination.premium') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle logic
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('counselorSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function () {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function (e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
            }

            // Bulk actions logic
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const bulkBar = document.getElementById('bulkBar');
            const selectedCountSpan = document.getElementById('selectedCount');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const bulkDeleteForm = document.getElementById('bulk-delete-form');
            const closeBulkBar = document.getElementById('closeBulkBar');

            function updateBulkBar() {
                const checked = document.querySelectorAll('.item-checkbox:checked');
                selectedCountSpan.textContent = checked.length;
                if (checked.length > 0) {
                    bulkBar.classList.add('active');
                } else {
                    bulkBar.classList.remove('active');
                    if (selectAll) selectAll.checked = false;
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateBulkBar();
                });
            }

            checkboxes.forEach(cb => cb.addEventListener('change', updateBulkBar));

            if (closeBulkBar) {
                closeBulkBar.addEventListener('click', () => {
                    checkboxes.forEach(cb => cb.checked = false);
                    if (selectAll) selectAll.checked = false;
                    updateBulkBar();
                });
            }

            if (bulkDeleteBtn) {
                bulkDeleteBtn.addEventListener('click', () => {
                    const ids = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
                    if (ids.length === 0) return;

                    Swal.fire({
                        title: 'Delete Selected?',
                        text: `You are about to delete ${ids.length} feedback(s). This cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'Yes, Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            bulkDeleteForm.innerHTML = '@csrf @method("DELETE")';
                            ids.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'ids[]';
                                input.value = id;
                                bulkDeleteForm.appendChild(input);
                            });
                            bulkDeleteForm.submit();
                        }
                    });
                });
            }
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Delete Feedback?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection