@extends('layouts.intl-app')

{{--
    영어·일본어 회사소개 (Claude 구역, 2026-11-03 INTL) — 한국어 회사소개(pages/company)와 같은 구조·디자인(legacy 랜딩 톤).
    문구: lang/{en,ja}/pages/company.php. 숫자는 회사 전체 누적(2026년 기준) 라벨을 유지한다.
--}}

@php
    $t = fn (string $key) => __('pages/company.'.$key);
    $lines = fn (array|string $value) => implode('<br>', array_map('e', (array) $value));
@endphp

@section('title', __('pages/company.title'))
@section('meta')
    <meta name="description" content="{{ __('pages/company.description') }}">
    <script type="application/ld+json">
        {!! json_encode([
            '@'.'context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'inLanguage' => config('intl.locales.'.intl_locale().'.html_lang'),
            'mainEntity' => array_map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq[0],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq[1]],
            ], __('pages/company.faq.items')),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
    </script>
@endsection

@section('content')
    <main class="landing">
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">{{ $t('hero.eyebrow') }}</span>
                <h1>{!! $lines($t('hero.h1')) !!}</h1>
                <p class="landing__lead">{{ $t('hero.lead') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('hero.cta_primary') }}</a>
                    <a class="btn-ghost" href="#how-we-work">{{ $t('hero.cta_secondary') }}</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('local_nav.aria') }}">
            <div class="landing__local-nav-inner">
                @foreach ($t('local_nav.items') as $anchor => $label)
                    <a href="#{{ $anchor }}">{{ $label }}</a>
                @endforeach
            </div>
        </nav>

        <section class="landing__section landing__section--light" id="story">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('story.eyebrow') }}</span>
                <h2 class="landing__head">{{ $t('story.h2') }}</h2>
                <div class="prose">
                    @foreach ($t('story.paragraphs') as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
                <div class="landing__callout">{{ $t('story.callout') }}</div>
            </div>
        </section>

        {{-- 2026년 회사 전체 누적 기준. 서비스별 실적으로 오인되지 않게 공통 라벨을 유지한다. 외국어 표기(KRW 37.3B+ 등)는 숫자 세기 효과 없이 그대로 보여 준다. --}}
        <section class="home__stats has-orb" aria-label="{{ $t('stats.aria') }}">
            <div class="home__stats-inner">
                @foreach ($t('stats.items') as [$num, $label])
                    <div class="stat glass-card"><strong>{{ $num }}</strong><span>{{ $label }}</span></div>
                @endforeach
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="how-we-work">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('how.eyebrow') }}</span>
                <h2 class="landing__head">{{ $t('how.h2') }}</h2>
                <div class="landing__points">
                    @foreach ($t('how.points') as [$title, $text])
                        <div class="landing__point landing__point--light"><strong>{{ $title }}</strong><span>{{ $text }}</span></div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('loop.eyebrow') }}</span>
                <h2 class="landing__head">{{ $t('loop.h2') }}</h2>
                <div class="steps">
                    @foreach ($t('loop.steps') as [$title, $text])
                        <div class="steps__item"><strong>{{ $title }}</strong><p>{{ $text }}</p></div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="capabilities">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('capabilities.eyebrow') }}</span>
                <h2 class="landing__head">{{ $t('capabilities.h2') }}</h2>
                <div class="subcards">
                    @foreach ($t('capabilities.cards') as [$title, $text, $more, $route, $params])
                        <a class="subcard" href="{{ intl_route($route, $params) }}"><strong>{{ $title }}</strong><p>{{ $text }}</p><span>{{ $more }}</span></a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="products">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('products.eyebrow') }}</span>
                <h2 class="landing__head">{{ $t('products.h2') }}</h2>
                <div class="prose">
                    @foreach ($t('products.paragraphs') as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
                <div class="subcards">
                    @foreach ($t('products.cards') as [$name, $text, $route])
                        <a class="subcard" href="{{ intl_route($route) }}"><strong>{{ $name }}</strong><p>{{ $text }}</p><span>{{ $t('products.more') }}</span></a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('ways.eyebrow') }}</span>
                <h2 class="landing__head">{{ $t('ways.h2') }}</h2>
                <div class="landing__points">
                    @foreach ($t('ways.points') as [$title, $text])
                        <div class="landing__point"><strong>{{ $title }}</strong><span>{{ $text }}</span></div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('faq.eyebrow') }}</span>
                <h2 class="landing__head">{{ $t('faq.h2') }}</h2>
                <div class="faq">
                    @foreach ($t('faq.items') as [$question, $answer])
                        <details class="faq__item"><summary>{{ $question }}</summary><p>{{ $answer }}</p></details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>{!! $lines($t('cta.h2')) !!}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('cta.text') }}</p>
                <div class="cta-row"><a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('cta.button') }}</a></div>
            </div>
        </section>
    </main>
@endsection
