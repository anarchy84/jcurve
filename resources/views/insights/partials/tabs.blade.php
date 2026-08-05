{{-- 카테고리 필터 탭 — index/category 공용. $categories, $activeSlug(null=전체) --}}
@if ($categories->isNotEmpty())
    <nav class="listing__filters" aria-label="카테고리">
        <a class="listing__filter @if (empty($activeSlug)) listing__filter--active @endif"
           href="{{ route('insights.index') }}">전체</a>
        @foreach ($categories as $cat)
            <a class="listing__filter @if (($activeSlug ?? null) === $cat->slug) listing__filter--active @endif"
               href="{{ route('insights.category', ['slug' => $cat->slug]) }}">{{ $cat->name }}</a>
        @endforeach
    </nav>
@endif
