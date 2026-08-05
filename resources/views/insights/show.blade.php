@extends('layouts.app')

@section('title', ($insight->meta_title ?: $insight->title).' | 제이커브인터렉티브')
@section('meta')
    @if ($insight->meta_description ?: $insight->excerpt)
        <meta name="description" content="{{ Str::limit(strip_tags($insight->meta_description ?: $insight->excerpt), 155) }}">
    @endif
@endsection

@section('content')
    <main class="detail">
        {{-- 히어로 [파치먼트] — 카테고리 · 제목 · 메타 --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                @if ($insight->category)
                    <a class="landing__eyebrow" href="{{ route('insights.category', ['slug' => $insight->category->slug]) }}">{{ $insight->category->name }}</a>
                @endif
                <h1>{{ $insight->title }}</h1>
                <div class="detail__meta">
                    @if ($insight->user)
                        <span>{{ $insight->user->nickname ?: $insight->user->name }}</span>
                    @endif
                    @if ($insight->published_at)
                        <time datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format('Y.m.d') }}</time>
                    @endif
                </div>
            </div>
        </section>

        {{-- 본문 [라이트] — 이식 HTML 원문 100% 보존(리라이팅 금지, URL-MIGRATION §E) --}}
        <section class="detail__body">
            <div class="detail__inner">
                {{-- content는 관리자가 이식한 신뢰 콘텐츠(자사 칼럼). 원문 보존 위해 HTML 렌더. --}}
                <div class="prose">{!! $insight->content !!}</div>

                <div class="detail__foot">
                    <a class="detail__back" href="{{ route('insights.index') }}">← 인사이트 목록</a>
                    <a class="btn-primary" href="{{ route('contact') }}">마케팅 상담 요청</a>
                </div>
            </div>
        </section>
    </main>
@endsection
