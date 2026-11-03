@if ($paginator->hasPages())
    <nav class="pager" role="navigation" aria-label="{{ __('pages/insights.pagination') }}">
        @if ($paginator->onFirstPage())
            <span class="pager__link pager__link--disabled" aria-disabled="true">← {{ __('pages/insights.previous') }}</span>
        @else
            <a class="pager__link" href="{{ $paginator->previousPageUrl() }}" rel="prev">← {{ __('pages/insights.previous') }}</a>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))<span class="pager__dots" aria-hidden="true">{{ $element }}</span>@endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pager__link pager__link--active" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="pager__link" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <a class="pager__link" href="{{ $paginator->nextPageUrl() }}" rel="next">{{ __('pages/insights.next') }} →</a>
        @else
            <span class="pager__link pager__link--disabled" aria-disabled="true">{{ __('pages/insights.next') }} →</span>
        @endif
    </nav>
@endif
