@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/performance-marketing.'.$key);
    $lines = fn (array|string $value) => implode('<br>', array_map('e', (array) $value));
@endphp

@php
    $faqs = [
        [
            'question' => $t('s000'),
            'answer' => $t('s001'),
        ],
        [
            'question' => $t('s002'),
            'answer' => $t('s003'),
        ],
        [
            'question' => $t('s004'),
            'answer' => $t('s005'),
        ],
        [
            'question' => $t('s006'),
            'answer' => $t('s007'),
        ],
        [
            'question' => $t('s008'),
            'answer' => $t('s009'),
        ],
    ];
@endphp

@section('title', $t('s010'))
@section('meta')
    <meta name="description" content="{{ $t('s011') }}">
    <script type="application/ld+json">
        {!! json_encode([
            '@'.'context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'inLanguage' => config('intl.locales.'.intl_locale().'.html_lang'),
            'mainEntity' => array_map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
            ], $faqs),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
    </script>
@endsection

@section('content')
    <main class="landing">
        <section class="landing__hero landing__hero--media">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                <span class="landing__eyebrow">{{ $t('s113') }}</span>
                <h1>{{ $t('s016') }}</h1>
                <p class="landing__lead">{{ $t('s017') }}</p>
                <div class="detail__metrics" aria-label="{{ $t('s012') }}">
                    <div class="detail__metric"><strong>{{ $t('s018') }}</strong><span>{{ $t('s019') }}</span></div>
                    <div class="detail__metric"><strong>{{ $t('s114') }}</strong><span>{{ $t('s020') }}</span></div>
                    <div class="detail__metric"><strong>{{ $t('s021') }}</strong><span>{{ $t('s022') }}</span></div>
                </div>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s023') }}</a>
                </div>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'performance'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s013') }}">
            <div class="landing__local-nav-inner">
                <a href="#performance-problem">{{ $t('s024') }}</a>
                <a href="#performance-scorecard">{{ $t('s025') }}</a>
                <a href="#performance-process">{{ $t('s026') }}</a>
                <a href="#performance-channels">{{ $t('s027') }}</a>
                <a href="#performance-deliverables">{{ $t('s028') }}</a>
                <a href="#performance-operations">{{ $t('s029') }}</a>
                <a href="#performance-fit">{{ $t('s030') }}</a>
                <a href="#performance-faq">{{ $t('s115') }}</a>
            </div>
        </nav>

        <section id="performance-problem" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s116') }}</span>
                <h2 class="landing__head">{{ $t('s031') }}</h2>
                <div class="prose">
                    <p>{{ $t('s032') }}</p>
                    <p>{{ $t('s033') }}</p>
                    <p>{{ $t('s034') }}</p>
                </div>
            </div>
        </section>

        <section id="performance-scorecard" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s117') }}</span>
                <h2 class="landing__head">{{ $t('s035') }}</h2>
                <p class="landing__body">{{ $t('s036') }}</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s037') }}</strong>
                        <span>{{ $t('s038') }}</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s039') }}</strong>
                        <span>{{ $t('s040') }}</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s041') }}</strong>
                        <span>{{ $t('s042') }}</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s043') }}</strong>
                        <span>{{ $t('s044') }}</span>
                    </div>
                </div>
                <div class="landing__callout">{{ $t('s045') }}</div>
            </div>
        </section>

        <section id="performance-process" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s118') }}</span>
                <h2 class="landing__head">{{ $t('s046') }}</h2>
                <p class="landing__lead">{{ $t('s047') }}</p>
                <div class="steps">
                    <div class="steps__item">
                        <strong>{{ $t('s048') }}</strong>
                        <p>{{ $t('s049') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s050') }}</strong>
                        <p>{{ $t('s051') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s052') }}</strong>
                        <p>{{ $t('s053') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s054') }}</strong>
                        <p>{{ $t('s055') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s056') }}</strong>
                        <p>{{ $t('s057') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s058') }}</strong>
                        <p>{{ $t('s059') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="performance-channels" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s119') }}</span>
                <h2 class="landing__head">{{ $t('s060') }}</h2>
                <p class="landing__body">{{ $t('s061') }}</p>
                <div class="subcards">
                    <a class="subcard" id="google-ads" href="{{ config('subpages.performance.items.google-ads') ? intl_route('services.performance.sub', ['sub' => 'google-ads']) : intl_route('contact') }}">
                        <strong>{{ $t('s062') }}</strong>
                        <p>{{ $t('s063') }}</p>
                        <span>{{ config('subpages.performance.items.google-ads') ? $t('s014') : $t('s015') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('services.performance.sub', ['sub' => 'naver-gfa']) }}">
                        <strong>{{ $t('s064') }}</strong>
                        <p>{{ $t('s065') }}</p>
                        <span>{{ $t('s066') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('services.performance.sub', ['sub' => 'facebook']) }}">
                        <strong>{{ $t('s067') }}</strong>
                        <p>{{ $t('s068') }}</p>
                        <span>{{ $t('s069') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('services.performance.sub', ['sub' => 'youtube']) }}">
                        <strong>{{ $t('s070') }}</strong>
                        <p>{{ $t('s071') }}</p>
                        <span>{{ $t('s072') }}</span>
                    </a>
                </div>
            </div>
        </section>

        <section id="performance-deliverables" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s120') }}</span>
                <h2 class="landing__head">{{ $t('s073') }}</h2>
                <p class="landing__body">{{ $t('s074') }}</p>
                <ul class="landing__evidence">
                    <li><strong>{{ $t('s075') }}</strong> {{ $t('s076') }}</li>
                    <li><strong>{{ $t('s077') }}</strong> {{ $t('s078') }}</li>
                    <li><strong>{{ $t('s079') }}</strong> {{ $t('s080') }}</li>
                    <li><strong>{{ $t('s081') }}</strong> {{ $t('s082') }}</li>
                    <li><strong>{{ $t('s083') }}</strong> {{ $t('s084') }}</li>
                    <li><strong>{{ $t('s085') }}</strong> {{ $t('s086') }}</li>
                </ul>
            </div>
        </section>

        <section id="performance-operations" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s121') }}</span>
                <h2 class="landing__head">{{ $t('s087') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s088') }}</h3>
                        <p>{{ $t('s089') }}</p>
                        <ul>
                            <li>{{ $t('s090') }}</li>
                            <li>{{ $t('s091') }}</li>
                            <li>{{ $t('s092') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s093') }}</h3>
                        <p>{{ $t('s094') }}</p>
                        <ul>
                            <li>{{ $t('s095') }}</li>
                            <li>{{ $t('s096') }}</li>
                            <li>{{ $t('s097') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="performance-fit" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s122') }}</span>
                <h2 class="landing__head">{{ $t('s098') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s099') }}</h3>
                        <ul>
                            <li>{{ $t('s100') }}</li>
                            <li>{{ $t('s101') }}</li>
                            <li>{{ $t('s102') }}</li>
                            <li>{{ $t('s103') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s104') }}</h3>
                        <ul>
                            <li>{{ $t('s105') }}</li>
                            <li>{{ $t('s106') }}</li>
                            <li>{{ $t('s107') }}</li>
                            <li>{{ $t('s108') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="performance-faq" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s123') }}</span>
                <h2 class="landing__head">{{ $t('s109') }}</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item">
                            <summary>{{ $faq['question'] }}</summary>
                            <p>{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>{{ $t('s110') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s111') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s112') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection

