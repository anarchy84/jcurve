@extends('layouts.intl')

{{--
    {{ $t('support') }} · {{ $t('heading') }} (대웅 지시 2026-10-27: "{{ $t('heading') }}, 문의게시판이 필요해")
    - 경로: /support/faq (routes/pages.php, Route::view). 메뉴: 상단 '{{ $t('support') }}▾'
    - 질문·답변은 각 서비스·소개 페이지에 이미 공개된 문구를 모은 것 → partials/jc/faq-data.php (새 약속·새 수치 없음)
    - 왼쪽 분야 목록으로 거르고, 위 검색칸으로 전체에서 찾는다(resources/js/jc.js §12). 스크립트가 없으면 전부 펼친 목록으로 보인다.
    - 문의게시판 주소(support.inquiries.index)는 Codex 백엔드가 붙으면 자동 연결, 그 전엔 {{ $t('project') }}로 보낸다.
--}}

@php
    $t = fn ($k) => __('pages/faq.'.$k);
    $jcFaq = $t('categories');
    $jcFaqTotal = collect($jcFaq)->sum(fn ($c) => count($c['items']));
    $jcInquiryHref = intl_route('contact');
    $jcInquiryLabel = $t('inquiry');
@endphp

@section('title', $t('title'))
@section('meta')
    <meta name="description" content="{{ $t('description') }}">
    <script type="application/ld+json">
        {!! json_encode([
            '@'.'context' => 'https://schema.org', // 키를 쪼갠 이유: 붙여 쓰면 Blade 지시어로 컴파일됨
            '@type' => 'FAQPage',
            'inLanguage' => config('intl.locales.'.intl_locale().'.html_lang'),
            'mainEntity' => collect($jcFaq)->flatMap(fn ($c) => $c['items'])->map(fn ($f) => [
                '@type' => 'Question',
                'name' => $f['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
            ])->values()->all(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
    </script>
@endsection

@push('scripts')
    <script>
        (() => {
            const count = document.querySelector('[data-jc-faq-count]');
            const search = document.querySelector('[data-jc-faq-search]');
            if (!count) return;
            const questions = {!! json_encode($t('questions'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
            const results = {!! json_encode($t('results'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
            new MutationObserver(() => {
                const number = count.textContent.match(/\d+/)?.[0];
                if (number === undefined) return;
                const label = `${number} ${search?.value.trim() ? results : questions}`;
                if (count.textContent !== label) count.textContent = label;
            }).observe(count, { childList: true });
        })();
    </script>
@endpush

@section('content')
    {{-- ① 머리 + 검색 --}}
    <section class="jc-support-hero" aria-labelledby="faq-title">
        <div class="jc-wrap">
            <nav class="jc-crumb" aria-label="{{ $t('breadcrumb_aria') }}"><a href="{{ intl_route('home') }}">{{ $t('home') }}</a><span aria-hidden="true">/</span><span>{{ $t('support') }}</span><span aria-hidden="true">/</span><span aria-current="page">{{ $t('heading') }}</span></nav>
            <h1 id="faq-title" class="jc-display jc-h1--page">{{ $t('heading') }}</h1>
            <p class="jc-lead">{{ $t('lead') }}</p>
            <label class="jc-faqsearch">
                <x-jc.icon name="seo" class="jc-faqsearch__ico" />
                <span class="jc-sr">{{ $t('search_label') }}</span>
                <input type="search" placeholder="{{ $t('search_placeholder') }}" autocomplete="off" data-jc-faq-search>
                <span class="jc-faqsearch__count" data-jc-faq-count aria-live="polite">{{ $jcFaqTotal }} {{ $t('questions') }}</span>
            </label>
            <div class="jc-support-links">
                <a href="{{ $jcInquiryHref }}"><x-jc.icon name="mail" />{{ $jcInquiryLabel }}</a>
                <a href="{{ intl_route('contact') }}"><x-jc.icon name="megaphone" />{{ $t('project_direct') }}</a>
                <a href="tel:0216682612"><x-jc.icon name="phone" />02-1668-2612</a>
            </div>
        </div>
    </section>

    {{-- ② 분야 + {{ $t('list_aria') }} --}}
    <section class="jc-section jc-faqsec" aria-label="{{ $t('list_aria') }}">
        <div class="jc-wrap jc-faqhub" data-jc-faq>
            <nav class="jc-faqhub__nav" aria-label="{{ $t('categories_aria') }}">
                <button type="button" data-cat="all" aria-pressed="true"><x-jc.icon name="layers" /><span>{{ $t('all') }}</span><em>{{ $jcFaqTotal }}</em></button>
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
                                        <a class="jc-faqhub__from" href="{{ intl_route($f['from'][0]['route'], $f['from'][0]['params']) }}">{{ $t('related') }} · {{ $f['from'][1] }} →</a>
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </section>
                @endforeach
                <div class="jc-faqhub__empty" data-jc-faq-empty hidden>
                    <strong>{{ $t('empty_before') }}<span data-jc-faq-term></span>{{ $t('empty_after') }}</strong>
                    <p>{{ $t('empty_text') }}</p>
                    <div class="jc-btns">
                        <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ $jcInquiryHref }}">{{ $jcInquiryLabel }}</a>
                        <a class="jc-btn jc-btn--line jc-btn--md" href="{{ intl_route('contact') }}">{{ $t('project') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ③ 답을 못 찾았을 때 --}}
    <section class="jc-bg-dark jc-section" aria-labelledby="faq-cta">
        <div class="jc-wrap jc-cta">
            <div>
                <h2 id="faq-cta" class="jc-display jc-h2">{{ $t('cta_heading') }}</h2>
                <p class="jc-text jc-text--dark">{{ $t('cta_text') }}</p>
                <p class="jc-contact jc-contact--dark"><span><x-jc.icon name="phone" />{{ $t('phone') }} <a href="tel:0216682612">02-1668-2612</a></span><span><x-jc.icon name="mail" />{{ $t('email') }} <a href="mailto:jcurve19@gmail.com">jcurve19@gmail.com</a></span></p>
            </div>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ $jcInquiryHref }}">{{ $jcInquiryLabel }}</a>
                <a class="jc-btn jc-btn--line-white" href="{{ intl_route('contact') }}">{{ $t('project') }}</a>
            </div>
        </div>
    </section>
@endsection
