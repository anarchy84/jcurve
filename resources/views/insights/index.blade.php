@extends('layouts.app')

{{-- 제목·설명문 = 운영 워드프레스 원문 그대로(SEO 보존, 제코 2026-11-03 「seo 쪽으로 되돌리는게 맞아. 퍼포먼스 마케팅 에이전시는 아니야」). 바꾸면 검색 순위가 흔들린다 --}}
@section('title', 'SEO | 검색엔진최적화를 위한 완벽 가이드')
@section('meta')
    <meta name="description" content="SEO가 필요하신가요? 검색엔진최적화(SEO)의 모든 것을 쉽게 이해하고, 실전에서 활용할 수 있는 팁을 제공합니다. 기술적 SEO (Technical SEO)부터 콘텐츠 SEO, 링크 빌딩과 백링크 전략, 온페이지 SEO & 오프페이지 SEO, 로컬 SEO, SEO 분석 및 측정 도구 활용까지 한눈에 알아보세요.">
@endsection

@section('content')
    @include('partials.jc.viz.kit')
    <main class="listing">
        {{-- 페이지 헤더 [파치먼트] + 카테고리 탭 --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Insights</span>
                <h1>인사이트</h1>
                <p class="landing__lead">현장에서 검증한 것만 글로 남깁니다.</p>
                @include('insights.partials.tabs', ['activeSlug' => null])
            </div>
        </section>
        @include('partials.jc.viz.insight-cats', ['activeSlug' => null])

        {{-- 아티클 카드 그리드 [라이트] --}}
        <section class="listing__body">
            @if ($insights->count())
                <div class="listing__grid">
                    @foreach ($insights as $insight)
                        <a class="insight-preview" href="{{ route('insights.show', $insight) }}">
                            @if ($insight->category)
                                <span class="insight-preview__cat">{{ $insight->category->name }}</span>
                            @endif
                            <span class="insight-preview__title">{{ $insight->title }}</span>
                            @if ($insight->excerpt)
                                <span class="insight-preview__excerpt">{{ Str::limit($insight->excerpt, 90) }}</span>
                            @endif
                            @if ($insight->published_at)
                                <time class="insight-preview__date" datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format('Y.m.d') }}</time>
                            @endif
                        </a>
                    @endforeach
                </div>
                <div class="listing__pagination">{{ $insights->links('partials.pagination') }}</div>
            @else
                <div class="listing__empty">
                    <h2 class="landing__head">인사이트를 준비 중입니다</h2>
                    <p class="landing__lead">마케팅에 대해 궁금한 점이 있으시면 언제든 문의해 주세요.</p>
                    <div class="cta-row">
                        <a class="btn-primary" href="{{ route('contact') }}">문의하기</a>
                    </div>
                </div>
            @endif
        </section>
    </main>
@endsection
