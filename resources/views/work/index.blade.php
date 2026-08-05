@extends('layouts.app')

@section('title', '성과 — 숫자로 증명된 결과 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="캠페인은 끝나도 데이터는 남습니다. 제이커브인터렉티브가 숫자로 증명한 마케팅 성과 사례들입니다.">
@endsection

@section('content')
    <main class="listing">
        {{-- 페이지 헤더 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Work</span>
                <h1>성과</h1>
                <p class="landing__lead">캠페인은 끝나도 데이터는 남습니다. 숫자로 증명된 결과들입니다.</p>
            </div>
        </section>

        {{-- 카드 그리드 [라이트] --}}
        <section class="listing__body">
            @if ($works->count())
                <div class="listing__grid">
                    @foreach ($works as $work)
                        <a class="work-preview" href="{{ route('work.show', $work) }}">
                            <span class="work-preview__thumb" aria-hidden="true"></span>
                            @if ($work->client || $work->industry)
                                <span class="work-preview__meta">{{ $work->client }}@if ($work->client && $work->industry) · @endif{{ $work->industry }}</span>
                            @endif
                            {{-- 대표 지표: metrics(json) 실데이터만. 없으면 숫자 카드 미생성 [Evidence Guardian] --}}
                            @php
                                $metric = null;
                                if (is_array($work->metrics) && count($work->metrics)) {
                                    $first = reset($work->metrics);
                                    if (is_array($first)) {
                                        $metric = ['value' => $first['value'] ?? null, 'label' => $first['label'] ?? null];
                                    } else {
                                        $k = array_key_first($work->metrics);
                                        $metric = ['value' => $work->metrics[$k], 'label' => is_string($k) ? $k : null];
                                    }
                                }
                            @endphp
                            @if ($metric && ! empty($metric['value']))
                                <span class="work-preview__metric">{{ $metric['value'] }}@if ($metric['label'])<small>{{ $metric['label'] }}</small>@endif</span>
                            @endif
                            <span class="work-preview__title">{{ $work->title }}</span>
                            <span class="work-preview__link">사례 보기 →</span>
                        </a>
                    @endforeach
                </div>
                <div class="listing__pagination">{{ $works->links('partials.pagination') }}</div>
            @else
                {{-- 빈 상태 = 리드 유입구 (하네스 Growth) --}}
                <div class="listing__empty">
                    <h2 class="landing__head">아직 공개된 성과 사례를 준비 중입니다</h2>
                    <p class="landing__lead">지금 진행 중인 마케팅의 성과가 궁금하시면 —</p>
                    <div class="cta-row">
                        <a class="btn-primary" href="{{ route('contact') }}">무료 진단 요청 →</a>
                    </div>
                </div>
            @endif
        </section>
    </main>
@endsection
