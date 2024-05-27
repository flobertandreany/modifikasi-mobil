@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item">
                    <span class="page-link-disabled" rel="prev"><i class="fa fa-chevron-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link-prev-next" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-chevron-left"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page <= 3)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- munculin button page 3 jika jumlah data < 3 pages --}}
            @if ($paginator->lastPage() < 3)
                <li class="page-item disabled"><span class="page-link">3</span></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link-prev-next" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-chevron-right"></i></a>
                </li>
            @else
                <li class="page-item">
                    <span class="page-link-disabled" rel="next"><i class="fa fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@else
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            <li class="page-item">
                <span class="page-link-disabled" rel="prev"><i class="fa fa-chevron-left"></i></span>
            </li>

            {{-- Pagination Elements --}}
            <li class="page-item active"><span class="page-link">1</span></li>
            <li class="page-item disabled"><span class="page-link">2</span></li>
            <li class="page-item disabled"><span class="page-link">3</span></li>

            {{-- Next Page Link --}}
            <li class="page-item">
                <span class="page-link-disabled" rel="next"><i class="fa fa-chevron-right"></i></span>
            </li>
        </ul>
    </nav>
@endif
