@if ($paginator->hasPages())
    <div class="ui pagination menu" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="icon disabled arrow" aria-disabled="true" aria-label="@lang('pagination.previous')"> <i class="fas fa-angle-left"></i> </a>
        @else
            <a class="icon arrow" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"> <i class="fas fa-angle-left"></i> </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a class="icon disabled" aria-disabled="true">{{ $element }}</a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="icon active" href="{{ $url }}" aria-current="page">{{ $page }}</a>
                    @else
                        <a class="icon" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="icon arrow" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"> <i class="fas fa-angle-right"></i> </a>
        @else
            <a class="icon arrow disabled" aria-disabled="true" aria-label="@lang('pagination.next')"> <i class="fas fa-angle-right"></i> </a>
        @endif
    </div>
@endif
