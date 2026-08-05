@extends('layouts.app')

@php
    $sections = is_array($page['sections'] ?? null) ? $page['sections'] : [];
    $legacyBody = is_array($page['body'] ?? null) ? $page['body'] : [];
    $localNav = collect($page['local_nav'] ?? [])
        ->filter(fn ($item) => is_array($item)
            && filled($item['label'] ?? null)
            && is_string($item['href'] ?? null)
            && preg_match('/^#[a-z][a-z0-9-]*$/', $item['href']))
        ->values();
    $faq = collect($page['faq'] ?? [])
        ->filter(fn ($item) => is_array($item) && filled($item['question'] ?? null) && filled($item['answer'] ?? null))
        ->values();

    $parentUrl = null;
    if (! empty($parent['route'])) {
        $parentUrl = ($parent['param'] ?? null) !== null
            ? route($parent['route'], $parent['param'])
            : route($parent['route']);
    }

    $contactParams = [
        'message' => is_string($page['inquiry_template'] ?? null)
            ? $page['inquiry_template']
            : '['.$page['title']."] 페이지를 보고 문의합니다.\n\n현재 상황: \n목표: \n예산·일정 범위: ",
    ];
    if (is_string($page['contact_interest'] ?? null) && $page['contact_interest'] !== '') {
        $contactParams['service_interest'] = $page['contact_interest'];
    }
    $contactUrl = route('contact', $contactParams);

    $faqSchema = $faq->isEmpty() ? null : [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faq->map(fn ($item) => [
            '@type' => 'Question',
            'name' => $item['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $item['answer'],
            ],
        ])->all(),
    ];
@endphp

@section('title', $page['title'].' | 제이커브인터렉티브')

@section('meta')
    @if (! empty($page['meta_description']))
        <meta name="description" content="{{ $page['meta_description'] }}">
    @endif
    @if ($faqSchema)
        <script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    @endif
@endsection

@section('content')
    <main class="landing subpage">
        <section class="landing__hero">
            <div class="landing__hero-inner">
                @if ($parentUrl)
                    <nav aria-label="상위 서비스" class="subpage__breadcrumb">
                        <a href="{{ $parentUrl }}">{{ $parent['label'] }}</a>
                    </nav>
                @endif

                <span class="landing__eyebrow">{{ $page['eyebrow'] ?? ($parent['label'] ?? 'J-Curve Interactive') }}</span>
                <h1>{{ $page['title'] }}</h1>
                <p class="landing__lead">{{ $page['lead'] }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ $contactUrl }}">{{ $page['hero_cta'] ?? '상담 문의하기' }}</a>
                </div>
            </div>
        </section>

        @if ($localNav->isNotEmpty())
            <nav class="landing__local-nav" aria-label="{{ $page['title'] }} 바로가기">
                <div class="landing__local-nav-inner">
                    @foreach ($localNav as $item)
                        <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                    @endforeach
                </div>
            </nav>
        @endif

        @if ($sections !== [])
            @foreach ($sections as $index => $section)
                @php
                    $allowedTypes = ['prose', 'points', 'steps', 'checklist', 'table', 'chips'];
                    $allowedTones = ['light', 'dark', 'parchment'];
                    $type = in_array($section['type'] ?? null, $allowedTypes, true) ? $section['type'] : 'prose';
                    $tone = in_array($section['tone'] ?? null, $allowedTones, true)
                        ? $section['tone']
                        : (['light', 'dark', 'parchment'][$index % 3]);
                    $isDark = $tone === 'dark';
                    $sectionId = is_string($section['id'] ?? null)
                        && preg_match('/^[a-z][a-z0-9-]*$/', $section['id'])
                        ? $section['id']
                        : null;
                    $items = is_array($section['items'] ?? null) ? $section['items'] : [];
                    $paragraphs = is_array($section['paragraphs'] ?? null) ? $section['paragraphs'] : [];
                @endphp

                <section class="landing__section landing__section--{{ $tone }}{{ $isDark ? ' has-orb' : '' }}" @if ($sectionId) id="{{ $sectionId }}" @endif>
                    <div class="landing__inner{{ ! empty($section['wide']) ? ' landing__inner--wide' : '' }}">
                        @if (! empty($section['eyebrow']))
                            <span class="landing__eyebrow">{{ $section['eyebrow'] }}</span>
                        @endif
                        @if (! empty($section['title']))
                            <h2 class="landing__head">{{ $section['title'] }}</h2>
                        @endif
                        @if (! empty($section['lead']))
                            <p class="landing__lead">{{ $section['lead'] }}</p>
                        @endif

                        @switch($type)
                            @case('points')
                                <div class="landing__points">
                                    @foreach ($items as $item)
                                        @if (is_array($item))
                                            @php
                                                $itemHref = is_string($item['href'] ?? null) && trim($item['href']) !== ''
                                                    ? trim($item['href'])
                                                    : null;
                                                $itemExternal = $itemHref && preg_match('/^https?:\/\//', $itemHref);
                                            @endphp
                                            @if ($itemHref)
                                                <a class="landing__point landing__point--link{{ $isDark ? '' : ' landing__point--light' }}" href="{{ $itemHref }}" @if ($itemExternal) target="_blank" rel="noopener" @endif>
                                                    <strong>{{ $item['title'] ?? '' }}</strong>
                                                    <span>{{ $item['text'] ?? '' }}</span>
                                                    @if (! empty($item['label']))
                                                        <small class="landing__point-link">{{ $item['label'] }} →</small>
                                                    @endif
                                                </a>
                                            @else
                                                <div class="landing__point{{ $isDark ? '' : ' landing__point--light' }}">
                                                    <strong>{{ $item['title'] ?? '' }}</strong>
                                                    <span>{{ $item['text'] ?? '' }}</span>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                                @break

                            @case('steps')
                                <div class="steps">
                                    @foreach ($items as $item)
                                        @if (is_array($item))
                                            <div class="steps__item">
                                                <strong>{{ $item['title'] ?? '' }}</strong>
                                                <p>{{ $item['text'] ?? '' }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                @break

                            @case('checklist')
                                <ul class="landing__evidence">
                                    @foreach ($items as $item)
                                        <li>{{ is_array($item) ? ($item['text'] ?? '') : $item }}</li>
                                    @endforeach
                                </ul>
                                @break

                            @case('table')
                                <div class="compare-table-wrap">
                                    <table class="compare-table">
                                        @if (! empty($section['caption']))
                                            <caption>{{ $section['caption'] }}</caption>
                                        @endif
                                        @if (! empty($section['columns']) && is_array($section['columns']))
                                            <thead>
                                                <tr>
                                                    @foreach ($section['columns'] as $column)
                                                        <th scope="col">{{ $column }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                        @endif
                                        <tbody>
                                            @foreach ($section['rows'] ?? [] as $row)
                                                @if (is_array($row))
                                                    <tr>
                                                        @foreach (array_values($row) as $cellIndex => $cell)
                                                            @if ($cellIndex === 0)
                                                                <th scope="row">{{ $cell }}</th>
                                                            @else
                                                                <td>{{ $cell }}</td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @break

                            @case('chips')
                                <div class="landing__chips">
                                    @foreach ($items as $item)
                                        <span>{{ is_array($item) ? ($item['text'] ?? '') : $item }}</span>
                                    @endforeach
                                </div>
                                @break

                            @default
                                <div class="prose">
                                    @foreach ($paragraphs as $paragraph)
                                        <p @if ($isDark) style="color:var(--on-dark);" @endif>{{ $paragraph }}</p>
                                    @endforeach
                                </div>
                        @endswitch

                        @if (! empty($section['note']))
                            <p class="landing__note">{{ $section['note'] }}</p>
                        @endif
                        @if (is_array($section['link'] ?? null) && is_string($section['link']['href'] ?? null) && ! empty($section['link']['href']) && ! empty($section['link']['label']))
                            @php($sectionLinkExternal = preg_match('/^https?:\/\//', $section['link']['href']))
                            <div class="cta-row" style="margin-top:28px;">
                                <a class="btn-ghost" href="{{ $section['link']['href'] }}" @if ($sectionLinkExternal) target="_blank" rel="noopener" @endif>{{ $section['link']['label'] }} →</a>
                            </div>
                        @endif
                    </div>
                </section>
            @endforeach
        @else
            {{-- 기존 body 스키마를 사용하는 페이지를 위한 하위호환 렌더링. --}}
            <section class="landing__section landing__section--light">
                <div class="landing__inner prose">
                    @foreach ($legacyBody as $block)
                        @if (is_array($block))
                            <section>
                                <h2>{{ $block['h2'] ?? '' }}</h2>
                                <ul>
                                    @foreach ($block['items'] ?? [] as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </section>
                        @else
                            <p>{{ $block }}</p>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        @if ($faq->isNotEmpty())
            <section class="landing__section landing__section--light" id="faq">
                <div class="landing__inner">
                    <span class="landing__eyebrow">FAQ</span>
                    <h2 class="landing__head">자주 묻는 질문</h2>
                    <div class="faq">
                        @foreach ($faq as $item)
                            <details class="faq__item">
                                <summary>{{ $item['question'] }}</summary>
                                <p>{{ $item['answer'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if ($parentUrl)
            <section class="landing__section landing__section--parchment landing__section--center">
                <div class="landing__inner">
                    <span class="landing__eyebrow">Related Service</span>
                    <h2 class="landing__head">{{ $parent['label'] }} 전체 구조도 함께 살펴보세요</h2>
                    <p class="landing__lead">{{ $parent['summary'] ?? '개별 상품만 떼어 보기보다 상위 서비스의 전략과 연결해 설계할 때 실행 방향이 더 선명해집니다.' }}</p>
                    <div class="cta-row">
                        <a class="btn-ghost" href="{{ $parentUrl }}">{{ $parent['label'] }} 보기 →</a>
                    </div>
                </div>
            </section>
        @endif

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>{{ $page['cta']['title'] ?? '현재 상황부터 함께 진단해 보겠습니다' }}</h2>
                @if (! empty($page['cta']['text']))
                    <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $page['cta']['text'] }}</p>
                @endif
                <div class="cta-row">
                    <a class="btn-primary" href="{{ $contactUrl }}">{{ $page['cta']['label'] ?? '상담 문의하기' }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection
