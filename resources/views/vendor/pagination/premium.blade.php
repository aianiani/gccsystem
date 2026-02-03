<div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 py-1">
    <div class="text-muted small">
        @if ($paginator->total() > 0)
            Showing <span class="fw-bold text-dark">{{ $paginator->firstItem() }}</span> to <span
                class="fw-bold text-dark">{{ $paginator->lastItem() }}</span> of <span
                class="fw-bold">{{ $paginator->total() }}</span> results
        @else
            {{ $paginator->total() }} results
        @endif
    </div>

    @if ($paginator->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0 gap-1" style="--bs-pagination-border-radius: 8px;">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link border-0 bg-transparent text-muted"><i class="bi bi-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link border-0 bg-light rounded-2 text-dark" href="{{ $paginator->previousPageUrl() }}"
                            rel="prev"><i class="bi bi-chevron-left"></i></a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link border-0 bg-transparent text-muted">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link border-0 rounded-2 px-3 fw-bold"
                                        style="background: var(--primary-green, #1f7a2d); color: #fff;">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0 bg-light rounded-2 text-dark px-3 fw-medium"
                                        href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link border-0 bg-light rounded-2 text-dark" href="{{ $paginator->nextPageUrl() }}"
                            rel="next"><i class="bi bi-chevron-right"></i></a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link border-0 bg-transparent text-muted"><i class="bi bi-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>