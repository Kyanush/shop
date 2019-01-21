@if ($paginator->hasPages())
    <div class="pagination">
        <div class="links">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="prev_pagination"  rel="prev" aria-label="@lang('pagination.previous')"></a>
            @else
                <a class="prev_pagination" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"></a>
            @endif


            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <b>{{ $element }}</b>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <b aria-current="page">{{ $page }}</b>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach






            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="next_pagination" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"></a>
            @else
                <a class="next_pagination" rel="next" aria-label="@lang('pagination.next')"></a>
            @endif


        </div>
    </div>
@endif

