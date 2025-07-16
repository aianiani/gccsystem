@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center my-3">
        <ul class="pagination pagination-modern mb-0" style="gap: 0.25rem;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link rounded-circle border-0 bg-light text-secondary" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-circle border-0 bg-white text-primary" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link border-0 bg-transparent text-secondary">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link rounded-circle border-0 bg-primary text-white fw-bold" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link rounded-circle border-0 bg-white text-primary" href="{{ $url }}" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-circle border-0 bg-white text-primary" href="{{ $paginator->nextPageUrl() }}" rel="next" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link rounded-circle border-0 bg-light text-secondary" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
