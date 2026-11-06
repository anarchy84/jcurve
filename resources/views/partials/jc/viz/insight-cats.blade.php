{{--
    인사이트 주제 목록 (2026-11-06 2판) — 공개된 글 수를 DB 에서 바로 센다. 막대·장식 없이 글자 목록만.
    @include('partials.jc.viz.insight-cats', ['activeSlug' => $category->slug ?? null])
--}}
@php
    $jvCats = \App\Models\InsightCategory::query()
        ->withCount(['insights' => fn ($q) => $q->published()])
        ->get()
        ->filter(fn ($c) => $c->insights_count > 0)
        ->sortByDesc('insights_count')
        ->values();
    $jvTotal = (int) $jvCats->sum('insights_count');
@endphp
@if ($jvCats->count() > 1)
    <section class="jf" aria-label="주제별 글 수">
        <div class="jf__in">
            <p class="jf__cap">주제별 글 · 전체 {{ number_format($jvTotal) }}편</p>
            <ul class="jf-topics">
                @foreach ($jvCats as $c)
                    <li class="{{ ($activeSlug ?? null) === $c->slug ? 'is-on' : '' }}"><a href="{{ route('insights.category', ['slug' => $c->slug]) }}">{{ $c->name }}</a><em>{{ $c->insights_count }}</em></li>
                @endforeach
            </ul>
        </div>
    </section>
@endif
