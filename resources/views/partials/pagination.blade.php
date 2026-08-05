{{-- 디자인시스템 톤 커스텀 페이지네이션 (Laravel 기본 Tailwind 뷰 대체) --}}
@if ($paginator->hasPages())
    <nav class="pager" role="navigation" aria-label="페이지 이동">
        @if ($paginator->onFirstPage())
            <span class="pager__link pager__link--disabled" aria-disabled="true">← 이전</span>
        @else
            <a class="pager__link" href="{{ $paginator->previousPageUrl() }}" rel="prev">← 이전</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pager__dots" aria-hidden="true">{{ $element }}</span>
            @endif
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
            <a class="pager__link" href="{{ $paginator->nextPageUrl() }}" rel="next">다음 →</a>
        @else
            <span class="pager__link pager__link--disabled" aria-disabled="true">다음 →</span>
        @endif
    </nav>
@endif
