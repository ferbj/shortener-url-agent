@if ($paginator->hasPages())
<nav>
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="disabled" aria-disabled="true">
            <a href="#!"><i class="material-icons">chevron_left</i></a>
        </li>
        @else
        <li>
            <a href="{{ $paginator->previousPageUrl()}}"><i class="material-icons">chevron_left</i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="disabled" aria-disabled="true"><a>{{ $element }}</a></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="active"><a href="">{{ $page }}</a></li>
        @else
        <li><a href="{{ $url }}">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a>
        </li>
        @else
        <li class=" disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
            <a href="" aria-hidden="true"><i class="material-icons">chevron_right</i></a>
        </li>
        @endif
    </ul>
</nav>
@endif
