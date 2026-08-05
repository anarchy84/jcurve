@extends('layouts.app')

@section('title', $category->name.' 인사이트 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="{{ $category->name }} 관련 마케팅 인사이트 — 제이커브인터렉티브가 현장에서 검증한 콘텐츠입니다.">
@endsection

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
