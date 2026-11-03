@if ($categories->isNotEmpty())
    <nav class="listing__filters" aria-label="{{ __('pages/insights.categories') }}">
        <a class="listing__filter @if (empty($activeSlug)) listing__filter--active @endif" href="{{ intl_route('insights.index') }}">{{ __('pages/insights.all') }}</a>
        @foreach ($categories as $cat)
            <a class="listing__filter @if (($activeSlug ?? null) === $cat->slug) listing__filter--active @endif" href="{{ intl_route('insights.category', ['slug' => $cat->slug]) }}">{{ __('insights.categories.'.$cat->slug) }}</a>
        @endforeach
    </nav>
@endif
