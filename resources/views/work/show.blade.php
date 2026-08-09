@extends('layouts.app')

@section('title', $work->title.' | 제이커브인터렉티브')
@section('meta')
    @if ($work->summary)
        <meta name="description" content="{{ Str::limit(strip_tags($work->summary), 155) }}">
    @endif
@endsection

@section('content')
    <main class="detail">
        {{-- 히어로 [파치먼트] — 클라이언트·산업 · 제목 · 지표 --}}
        <section class="landing__hero @if ($work->cover_image)landing__hero--media @endif">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                    @if ($work->client || $work->industry)
                        <span class="landing__eyebrow">{{ $work->client }}@if ($work->client && $work->industry) · @endif{{ $work->industry }}</span>
                    @endif
                    <h1>{{ $work->title }}</h1>
                    @if ($work->summary)
                        <p class="landing__lead">{{ $work->summary }}</p>
                    @endif

                    {{-- 대표 지표: metrics 실데이터만 (허위 금지, Evidence Guardian) --}}
                    @if (is_array($work->metrics) && count($work->metrics))
                        <div class="detail__metrics">
                            @foreach ($work->metrics as $key => $value)
                                @php
                                    $mv = is_array($value) ? ($value['value'] ?? implode(', ', $value)) : $value;
                                    $ml = is_array($value) ? ($value['label'] ?? (is_string($key) ? $key : null)) : (is_string($key) ? $key : null);
                                @endphp
                                <div class="detail__metric">
                                    <strong>{{ $mv }}</strong>
                                    @if ($ml)<span>{{ $ml }}</span>@endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if ($work->cover_image)
                    <figure class="landing__hero-figure"><img src="{{ asset($work->cover_image) }}" alt="" width="1280" height="720"></figure>
                @endif
            </div>
        </section>

        {{-- 본문 [라이트] — [문제 → 접근 → 결과] --}}
        <section class="detail__body">
            <div class="detail__inner">
                @if ($work->content)
                    <div class="prose">{!! $work->content !!}</div>
                @endif

                <div class="detail__foot">
                    <a class="detail__back" href="{{ route('work.index') }}">← 성과 목록</a>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>비슷한 결과가 필요하신가요?</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">프로젝트 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
