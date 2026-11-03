<section class="listing__body">
    @if ($insights->count())
        <div class="listing__grid">
            @foreach ($insights as $insight)
                <a class="insight-preview" href="{{ intl_route('insights.show', ['slug' => $insight->translation->slug]) }}">
                    @if ($insight->category)
                        <span class="insight-preview__cat">{{ __('insights.categories.'.$insight->category->slug) }}</span>
                    @endif
                    <span class="insight-preview__title">{{ $insight->translation->title }}</span>
                    @if ($insight->translation->excerpt)
                        <span class="insight-preview__excerpt">{{ Str::limit($insight->translation->excerpt, 90) }}</span>
                    @endif
                    @if ($insight->published_at)
                        <time class="insight-preview__date" datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format($t('date_format')) }}</time>
                    @endif
                </a>
            @endforeach
        </div>
        <div class="listing__pagination">{{ $insights->links('intl.partials.pagination') }}</div>
    @else
        <div class="listing__empty">
            <h2 class="landing__head">{{ $t(isset($category) ? 'category_empty' : 'empty') }}</h2>
            @if (! isset($category))<p class="landing__lead">{{ $t('empty_lead') }}</p>@endif
            <div class="cta-row">
                <a class="btn-primary" href="{{ intl_route(isset($category) ? 'insights.index' : 'contact') }}">{{ $t(isset($category) ? 'all_link' : 'contact') }}</a>
            </div>
        </div>
    @endif
</section>
