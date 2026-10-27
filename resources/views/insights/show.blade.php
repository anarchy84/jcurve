@extends('layouts.jc')

{{--
    인사이트 글 상세 — 리뉴얼 v3 (Claude Design 와꾸 '인사이트 글 상세')
    - 본문: 이식 HTML 원문 그대로 렌더(리라이팅 금지, URL-MIGRATION §E). 원문 정리는 QUEUE Q-013(Codex).
    - 목차: 본문 h2/h3로 화면에서 자동 생성(resources/js/jc.js). 소제목이 없으면 숨김.
    - 읽는 시간: 본문 글자 수 기준 화면 계산(분당 약 500자).
    - $related / $insight->sources 는 COLLAB §3 '제안'(Q-015). 컨트롤러가 넘겨주면 자동으로 보인다.
--}}

@php
    $plain = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $insight->content)));
    $readingMinutes = max(1, (int) ceil(mb_strlen($plain) / 500));
    $author = $insight->user ? ($insight->user->nickname ?: $insight->user->name) : '제이커브인터렉티브';
    $related = $related ?? collect();
    $sources = $insight->sources ?? [];
@endphp

{{-- 제목 태그는 기존(v1) 형식 그대로 — SEO 보존. 원문 제목 정리는 QUEUE Q-013(Codex) --}}
@section('title', ($insight->meta_title ?: $insight->title).' | 제이커브인터렉티브')
@section('meta')
    @if ($insight->meta_description ?: $insight->excerpt)
        <meta name="description" content="{{ Str::limit(strip_tags($insight->meta_description ?: $insight->excerpt), 155) }}">
    @endif
@endsection

@section('content')
    <article>
        <div class="jc-wrap" style="padding-top:clamp(40px,5vw,72px);padding-bottom:48px">
            <div class="jc-article-grid">
                <div class="jc-article-spacer" aria-hidden="true"></div>
                <header>
                    <nav class="jc-crumb" aria-label="현재 위치" style="margin-bottom:24px">
                        <a href="{{ route('home') }}">홈</a><span aria-hidden="true">/</span>
                        <a href="{{ route('insights.index') }}">인사이트</a>
                        @if ($insight->category)
                            <span aria-hidden="true">/</span><a href="{{ route('insights.category', ['slug' => $insight->category->slug]) }}">{{ $insight->category->name }}</a>
                        @endif
                    </nav>
                    <h1 class="jc-display" style="font-size:clamp(34px,3.9vw,56px);line-height:1.18;letter-spacing:-0.045em;text-wrap:balance">{{ $insight->title }}</h1>
                    <div class="jc-article-meta">
                        @if ($insight->user)
                            <span>글 <strong>{{ $author }}</strong></span>
                        @endif
                        @if ($insight->published_at)
                            <span>발행 <time datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format('Y.m.d') }}</time></span>
                        @endif
                        <span>읽는 시간 약 {{ $readingMinutes }}분</span>
                    </div>
                </header>
            </div>
        </div>

        <div class="jc-wrap">
            <div class="jc-article-grid">
                <nav class="jc-toc" aria-label="목차" data-jc-toc>
                    <span class="jc-toc__title">목차</span>
                    <ol></ol>
                </nav>
                <div>
                    {{-- content는 관리자가 이식한 자사 칼럼 원문. 원문 보존을 위해 HTML 그대로 렌더 --}}
                    <div class="jc-prose" data-jc-prose>{!! $insight->content !!}</div>

                    <div class="jc-article-foot">
                        @if ($insight->category)
                            <div class="jc-article-foot__tags">
                                <span style="font-size:14px;font-weight:700;margin-right:8px">분류</span>
                                <a class="jc-tag" href="{{ route('insights.category', ['slug' => $insight->category->slug]) }}">{{ $insight->category->name }}</a>
                            </div>
                        @endif
                        @if (! empty($sources))
                            <div style="font-size:14px;line-height:1.7;color:var(--jc-body)"><strong style="color:#000">인용한 자료</strong><br>{{ implode(' / ', (array) $sources) }}</div>
                        @endif
                        @if ($insight->source_url)
                            <div class="jc-small">원문 위치: {{ $insight->source_url }}</div>
                        @endif
                    </div>

                    <p style="margin-top:24px"><a class="jc-link" href="{{ route('insights.index') }}">← 인사이트 목록</a></p>

                    <aside class="jc-aside-cta" aria-label="관련 서비스">
                        <div style="max-width:420px">
                            <strong class="jc-display" style="font-size:22px;letter-spacing:-0.03em">직접 하기 어렵다면</strong>
                            <p style="margin-top:8px;font-size:15px;line-height:1.6;color:var(--jc-body)">사이트 규모와 목표에 맞는 실행 방법을 함께 정리해 드립니다.</p>
                        </div>
                        <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ route('contact') }}">마케팅 상담 요청</a>
                    </aside>
                </div>
            </div>
        </div>
    </article>

    <section class="jc-section" aria-labelledby="in-related">
        <div class="jc-wrap">
            <div class="jc-article-grid">
                <div class="jc-article-spacer" aria-hidden="true"></div>
                <div class="jc-related">
                    @if ($related->isNotEmpty())
                        <h2 id="in-related" class="jc-display">같이 읽으면 좋은 글</h2>
                        @foreach ($related as $item)
                            <a class="jc-related__item" href="{{ route('insights.show', $item) }}"><span class="jc-post__date">{{ $item->published_at?->format('Y.m.d') }}</span><span style="font-size:18px;line-height:1.45;font-weight:600"><x-jc.clean-title :text="$item->title" /></span></a>
                        @endforeach
                    @else
                        <h2 id="in-related" class="jc-display">다른 글도 읽어보세요</h2>
                    @endif
                    <a class="jc-link" style="display:inline-block;margin-top:20px" href="{{ route('insights.index') }}">인사이트 전체 보기</a>
                </div>
            </div>
        </div>
    </section>
@endsection
