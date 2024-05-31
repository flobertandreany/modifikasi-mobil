@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->currentPage() > 2)
                <li class="page-item">
                    <a class="page-link-prev-next" href="{{ $paginator->url(max(1, $paginator->currentPage() - 2)) }}" rel="prev"><i class="fa fa-angle-double-left"></i></a>
                </li>
            @else
                <li class="page-item">
                    <span class="page-link-disabled" rel="prev"><i class="fa fa-angle-double-left"></i></span>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @php
                        $start = max(1, $paginator->currentPage() - 1);
                        $end = min($start + 2, $paginator->lastPage());
                        if ($end - $start < 2) {
                            $start = max(1, $end - 2);
                        }
                    @endphp
                    @foreach ($element as $page => $url)
                        @if ($page >= $start && $page <= $end)
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
            @if ($paginator->currentPage() + 2 <= $paginator->lastPage())
                <li class="page-item">
                    <a class="page-link-prev-next" href="{{ $paginator->url(min($paginator->lastPage(), $paginator->currentPage() + 2)) }}" rel="next"><i class="fa fa-angle-double-right"></i></a>
                </li>
            @else
                <li class="page-item">
                    <span class="page-link-disabled" rel="next"><i class="fa fa-angle-double-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@else
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            <li class="page-item">
                <span class="page-link-disabled" rel="prev"><i class="fa fa-angle-double-left"></i></span>
            </li>

            {{-- Pagination Elements --}}
            <li class="page-item active"><span class="page-link">1</span></li>
            <li class="page-item disabled"><span class="page-link">2</span></li>
            <li class="page-item disabled"><span class="page-link">3</span></li>

            {{-- Next Page Link --}}
            <li class="page-item">
                <span class="page-link-disabled" rel="next"><i class="fa fa-angle-double-right"></i></span>
            </li>
        </ul>
    </nav>
@endif
