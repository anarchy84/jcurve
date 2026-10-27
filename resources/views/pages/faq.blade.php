@extends('layouts.jc')

{{--
    고객센터 · 자주 묻는 질문 (대웅 지시 2026-10-27: "자주 묻는 질문, 문의게시판이 필요해")
    - 경로: /support/faq (routes/pages.php, Route::view). 메뉴: 상단 '고객센터▾'
    - 질문·답변은 각 서비스·소개 페이지에 이미 공개된 문구를 모은 것 → partials/jc/faq-data.php (새 약속·새 수치 없음)
    - 왼쪽 분야 목록으로 거르고, 위 검색칸으로 전체에서 찾는다(resources/js/jc.js §12). 스크립트가 없으면 전부 펼친 목록으로 보인다.
    - 문의게시판 주소(support.inquiries.index)는 Codex 백엔드가 붙으면 자동 연결, 그 전엔 프로젝트 문의로 보낸다.
--}}

@php
    $jcFaq = require resource_path('views/partials/jc/faq-data.php');
    $jcFaqTotal = collect($jcFaq)->sum(fn ($c) => count($c['items']));
    $jcInquiryHref = Route::has('support.inquiries.index') ? route('support.inquiries.index') : route('contact');
    $jcInquiryLabel = Route::has('support.inquiries.index') ? '문의게시판에 남기기' : '문의 남기기';
@endphp

@section('title', '자주 묻는 질문 — 고객센터 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="제이커브인터렉티브 고객센터. 퍼포먼스·CPA·리워드 광고, SEO·AEO·GEO, 셀프마케팅·부스팅샵, 리드베이·콜투세일, 웹 제작·지원사업에 대해 자주 묻는 질문과 답변을 한곳에 모았습니다.">
    <script type="application/ld+json">
        {!! json_encode([
            '@'.'context' => 'https://schema.org', // 키를 쪼갠 이유: 붙여 쓰면 Blade 지시어로 컴파일됨
            '@type' => 'FAQPage',
            'mainEntity' => collect($jcFaq)->flatMap(fn ($c) => $c['items'])->map(fn ($f) => [
                '@type' => 'Question',
                'name' => $f['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
            ])->values()->all(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endsection

@section('content')
    {{-- ① 머리 + 검색 --}}
    <section class="jc-support-hero" aria-labelledby="faq-title">
        <div class="jc-wrap">
            <nav class="jc-crumb" aria-label="현재 위치"><a href="{{ route('home') }}">홈</a><span aria-hidden="true">/</span><span>고객센터</span><span aria-hidden="true">/</span><span aria-current="page">자주 묻는 질문</span></nav>
            <h1 id="faq-title" class="jc-display jc-h1--page">자주 묻는 질문</h1>
            <p class="jc-lead">서비스마다 가장 많이 받는 질문을 모았습니다. 찾는 답이 없으면 문의를 남겨 주세요.</p>
            <label class="jc-faqsearch">
                <x-jc.icon name="seo" class="jc-faqsearch__ico" />
                <span class="jc-sr">질문 검색</span>
                <input type="search" placeholder="궁금한 내용을 검색하세요 — 예: 보장, 계정, 환불, 리포트" autocomplete="off" data-jc-faq-search>
                <span class="jc-faqsearch__count" data-jc-faq-count aria-live="polite">질문 {{ $jcFaqTotal }}개</span>
            </label>
            <div class="jc-support-links">
                <a href="{{ $jcInquiryHref }}"><x-jc.icon name="mail" />{{ $jcInquiryLabel }}</a>
                <a href="{{ route('contact') }}"><x-jc.icon name="megaphone" />프로젝트 문의(1:1)</a>
                <a href="tel:0216682612"><x-jc.icon name="phone" />02-1668-2612</a>
            </div>
        </div>
    </section>

    {{-- ② 분야 + 질문 목록 --}}
    <section class="jc-section jc-faqsec" aria-label="질문 목록">
        <div class="jc-wrap jc-faqhub" data-jc-faq>
            <nav class="jc-faqhub__nav" aria-label="질문 분야">
                <button type="button" data-cat="all" aria-pressed="true"><x-jc.icon name="layers" /><span>전체</span><em>{{ $jcFaqTotal }}</em></button>
                @foreach ($jcFaq as $key => $cat)
                    <button type="button" data-cat="{{ $key }}" aria-pressed="false"><x-jc.icon :name="$cat['icon']" /><span>{{ $cat['label'] }}</span><em>{{ count($cat['items']) }}</em></button>
                @endforeach
            </nav>
            <div class="jc-faqhub__list">
                @foreach ($jcFaq as $key => $cat)
                    <section class="jc-faqhub__group" id="faq-{{ $key }}" data-group="{{ $key }}" aria-labelledby="faq-h-{{ $key }}">
                        <h2 id="faq-h-{{ $key }}" class="jc-faqhub__head"><x-jc.icon :name="$cat['icon']" />{{ $cat['label'] }}</h2>
                        <div class="jc-faq">
                            @foreach ($cat['items'] as $f)
                                <details class="jc-faqhub__item">
                                    <summary><span class="jc-faqhub__q">{{ $f['q'] }}</span></summary>
                                    <div class="jc-faqhub__a">
                                        <p>{{ $f['a'] }}</p>
                                        <a class="jc-faqhub__from" href="{{ $f['from'][0] }}">관련 페이지 · {{ $f['from'][1] }} →</a>
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </section>
                @endforeach
                <div class="jc-faqhub__empty" data-jc-faq-empty hidden>
                    <strong>‘<span data-jc-faq-term></span>’에 맞는 질문을 찾지 못했어요.</strong>
                    <p>다른 단어로 찾아보거나, 문의를 남겨 주시면 확인 후 답변드립니다.</p>
                    <div class="jc-btns">
                        <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ $jcInquiryHref }}">{{ $jcInquiryLabel }}</a>
                        <a class="jc-btn jc-btn--line jc-btn--md" href="{{ route('contact') }}">프로젝트 문의</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ③ 답을 못 찾았을 때 --}}
    <section class="jc-bg-dark jc-section" aria-labelledby="faq-cta">
        <div class="jc-wrap jc-cta">
            <div>
                <h2 id="faq-cta" class="jc-display jc-h2">찾는 답이 없나요?</h2>
                <p class="jc-text jc-text--dark">궁금한 점은 문의로 남겨 주세요. 프로젝트 상담은 1:1 문의가 가장 빠릅니다.</p>
                <p class="jc-contact jc-contact--dark"><span><x-jc.icon name="phone" />전화 <a href="tel:0216682612">02-1668-2612</a></span><span><x-jc.icon name="mail" />메일 <a href="mailto:jcurve19@gmail.com">jcurve19@gmail.com</a></span></p>
            </div>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ $jcInquiryHref }}">{{ $jcInquiryLabel }}</a>
                <a class="jc-btn jc-btn--line-white" href="{{ route('contact') }}">프로젝트 문의</a>
            </div>
        </div>
    </section>
@endsection
