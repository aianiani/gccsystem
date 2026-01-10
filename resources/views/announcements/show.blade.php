@extends('layouts.app')

@section('content')
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

        .home-zoom .container {
            max-width: 100%;
        }
    </style>
    <div class="home-zoom">
        <div class="container">
            <div class="py-4 px-4 px-lg-5 mb-4 rounded-4"
                style="background: linear-gradient(135deg, #228B22, #0f3d1e); color: #fff;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <a href="#"
                                onclick="event.preventDefault(); if (window.history.length > 1) { window.history.back(); } else { window.location.href = '{{ route('announcements.index') }}'; }"
                                class="text-white-50 text-decoration-none me-3">
                                <span class="me-1">&larr;</span> Back
                            </a>
                        </div>
                        <h1 class="h3 fw-bold mb-2">{{ $announcement->title }}</h1>
                        <div class="d-flex align-items-center gap-2 small">
                            <span class="badge rounded-pill"
                                style="background: rgba(255,203,5,0.15); color:#ffdf66;">{{ optional($announcement->created_at)->format('M d, Y') }}</span>
                            <span class="text-white-50">&middot;</span>
                            <span class="text-white-75">Posted
                                {{ optional($announcement->created_at)->diffForHumans() }}</span>
                            @if(optional($announcement->created_at) && optional($announcement->created_at)->greaterThanOrEqualTo(now()->subDays(14)))
                                <span class="badge" style="background:#FFCB05; color:#1a1a1a; font-weight:700;">NEW</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-lg-5">
                            <div class="mb-4" style="line-height: 1.8; color:#2c3e50;">
                                {!! nl2br(e($announcement->content)) !!}
                            </div>
                            @php
                                $attachmentPath = $announcement->attachment ?? null;
                                $attachmentUrl = $attachmentPath ? asset('storage/' . $attachmentPath) : null;
                                $isImage = $attachmentPath && preg_match('/\.(jpg|jpeg|png|gif|webp|bmp|svg)$/i', $attachmentPath);
                            @endphp
                            @if($attachmentPath)
                                @if($isImage)
                                    <div class="rounded-3 overflow-hidden mb-3"
                                        style="background:#f5f7f6;border:1px solid rgba(0,0,0,0.06);">
                                        <a href="{{ $attachmentUrl }}" target="_blank" class="d-block">
                                            <img src="{{ $attachmentUrl }}" alt="Announcement Attachment" class="img-fluid w-100"
                                                style="display:block;object-fit:cover;">
                                        </a>
                                    </div>
                                    <div class="text-muted small mb-2">Click the image to open in a new tab.</div>
                                @else
                                    <div class="p-3 p-lg-4 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-3"
                                        style="background: #f8faf9; border: 1px solid rgba(0,0,0,0.06);">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="d-inline-flex align-items-center justify-content-center"
                                                style="width:44px;height:44px;border-radius:12px;background: linear-gradient(135deg, #2e7d32, #228B22); color:#fff;">
                                                <i class="fas fa-paperclip"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">Attachment</div>
                                                <div class="text-muted small">Click to view or download</div>
                                            </div>
                                        </div>
                                        <a href="{{ $attachmentUrl }}" target="_blank" class="btn btn-success fw-semibold"
                                            style="background:#228B22;border:none;border-radius:10px;">
                                            View Attachment
                                        </a>
                                    </div>
                                @endif
                            @endif

                            @if($announcement->images && count($announcement->images) > 0)
                                <div class="mt-4">
                                    <h5 class="mb-3" style="color:#2e7d32; font-weight:600;">
                                        <i class="bi bi-images me-2"></i>Gallery
                                    </h5>
                                    <div class="row g-3">
                                        @foreach($announcement->images as $index => $image)
                                            <div class="col-md-3 col-sm-4 col-6">
                                                <div class="position-relative rounded-3 overflow-hidden shadow-sm"
                                                    style="cursor: pointer;">
                                                    <img src="{{ asset('storage/' . $image) }}"
                                                        alt="Announcement Image {{ $index + 1 }}" class="img-fluid w-100"
                                                        style="height: 200px; object-fit: cover;"
                                                        onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Image Modal -->
                                <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content bg-transparent border-0">
                                            <div class="modal-header border-0">
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <img id="modalImage" src="" class="img-fluid w-100 rounded">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function openImageModal(imageSrc) {
                                        document.getElementById('modalImage').src = imageSrc;
                                        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                                        imageModal.show();
                                    }
                                </script>
                            @endif

                            <div class="d-flex align-items-center gap-2 mt-4">
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('announcements.edit', $announcement->id) }}"
                                            class="btn btn-warning">Edit</a>
                                        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST"
                                            style="display:inline-block;"
                                            data-confirm="Are you sure you want to delete this announcement?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Confirmation modal + handler (lightweight) -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Please confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmModalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmModalOk">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const confirmModalEl = document.getElementById('confirmModal');
            let bsConfirm = (typeof bootstrap !== 'undefined' && confirmModalEl) ? new bootstrap.Modal(confirmModalEl, { backdrop: 'static' }) : null;
            let confirmTarget = null;
            function showConfirm(message, target) {
                document.getElementById('confirmModalMessage').textContent = message;
                confirmTarget = target;
                if (bsConfirm) { bsConfirm.show(); return; }
                confirmModalEl.classList.add('show'); confirmModalEl.style.display = 'block';
                let bd = document.getElementById('confirmModalBackdrop');
                if (!bd) { bd = document.createElement('div'); bd.id = 'confirmModalBackdrop'; bd.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1050'; document.body.appendChild(bd); } else bd.style.display = 'block';
            }
            document.querySelectorAll('[data-confirm]').forEach(function (el) {
                if (el.tagName === 'FORM') {
                    el.addEventListener('submit', function (e) { e.preventDefault(); showConfirm(el.getAttribute('data-confirm') || 'Are you sure?', el); });
                } else {
                    el.addEventListener('click', function (e) { e.preventDefault(); showConfirm(el.getAttribute('data-confirm') || 'Are you sure?', el); });
                }
            });
            const ok = document.getElementById('confirmModalOk');
            if (ok) ok.addEventListener('click', function () { if (!confirmTarget) return; if (confirmTarget.tagName === 'FORM') { confirmTarget.removeAttribute('data-confirm'); confirmTarget.submit(); } else if (confirmTarget.tagName === 'A') { const href = confirmTarget.getAttribute('href'); if (href) window.location.href = href; } if (bsConfirm) bsConfirm.hide(); else { confirmModalEl.classList.remove('show'); confirmModalEl.style.display = 'none'; const bd = document.getElementById('confirmModalBackdrop'); if (bd) bd.style.display = 'none'; } });
        });
    </script>
@endsection