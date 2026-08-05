@extends('layouts.app')

@section('title', '인사이트 — 현장에서 검증한 마케팅 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="현장에서 검증한 것만 글로 남깁니다. 퍼포먼스·SEO·콘텐츠까지, 제이커브인터렉티브의 마케팅 인사이트.">
@endsection

@section('content')
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
