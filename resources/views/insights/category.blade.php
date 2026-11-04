@extends('layouts.app')

{{-- 원주소 카테고리(/blog/seo/, /blog/link-building/)는 운영 워드프레스 제목 그대로(SEO 보존, 제코 2026-11-03). 나머지 카테고리는 기존 형식 --}}
@section('title', [
    'seo' => 'SEO 개념 - SEO 전문 컨설팅 기업 | 제이커브인터렉티브',
    'link-building' => '링크빌딩 - SEO 전문 컨설팅 기업 | 제이커브인터렉티브',
][$category->slug] ?? $category->name.' 인사이트 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="{{ $category->name }} 관련 마케팅 인사이트 — 제이커브인터렉티브가 현장에서 검증한 콘텐츠입니다.">
@endsection
{{-- 글이 한 편도 없는 카테고리는 빈 페이지라 검색에 내지 않는다(SEO-KW-01, 2026-11-04 운영 확인: 9개 카테고리 0편). 원주소 두 곳(/blog/seo/·/blog/link-building/)은 보존 대상이라 제외 --}}
@if ($insights->total() === 0 && ! in_array($category->slug, ['seo', 'link-building'], true))
    @section('robots', 'noindex, follow')
@endif

@section('content')
    <main class="listing">
        {{-- 페이지 헤더 [파치먼트] + 카테고리 탭 --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Insights</span>
                <h1>{{ $category->name }}</h1>
                <p class="landing__lead">{{ $category->name }} 관련 인사이트입니다.</p>
                @include('insights.partials.tabs', ['activeSlug' => $category->slug])
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
                {{-- 카테고리별 0건 — 전체 보기로 유도 --}}
                <div class="listing__empty">
                    <h2 class="landing__head">이 카테고리의 글을 준비 중입니다</h2>
                    <div class="cta-row">
                        <a class="btn-primary" href="{{ route('insights.index') }}">전체 인사이트 보기 →</a>
                    </div>
                </div>
            @endif
        </section>
    </main>
@endsection
