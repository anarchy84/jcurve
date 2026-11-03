@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/seo.'.$key);
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
                <span class="landing__eyebrow">{{ $t('s123') }}</span>
                <h1>{{ $t('s013') }}</h1>
                <p class="landing__lead">{{ $t('s014') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s015') }}</a>
                </div>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'seo'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s012') }}">
            <div class="landing__local-nav-inner">
                <a href="#seo-problem">{{ $t('s016') }}</a>
                <a href="#seo-diagnostic">{{ $t('s017') }}</a>
                <a href="#seo-method">{{ $t('s018') }}</a>
                <a href="#seo-ai">{{ $t('s124') }}</a>
                <a href="#seo-deliverables">{{ $t('s019') }}</a>
                <a href="#seo-measurement">{{ $t('s020') }}</a>
                <a href="#seo-areas">{{ $t('s021') }}</a>
                <a href="#seo-fit">{{ $t('s022') }}</a>
                <a href="#seo-faq">{{ $t('s125') }}</a>
            </div>
        </nav>

        <section id="seo-problem" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s126') }}</span>
                <h2 class="landing__head">{{ $t('s023') }}</h2>
                <div class="prose">
                    <p>{{ $t('s024') }}</p>
                    <p>{{ $t('s025') }}</p>
                </div>
                <div class="landing__callout">{{ $t('s026') }}</div>
            </div>
        </section>

        <section id="seo-diagnostic" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s127') }}</span>
                <h2 class="landing__head">{{ $t('s027') }}</h2>
                <p class="landing__body">{{ $t('s028') }}</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>{{ $t('s029') }}</strong><span>{{ $t('s030') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s031') }}</strong><span>{{ $t('s032') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s022') }}</strong><span>{{ $t('s033') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s034') }}</strong><span>{{ $t('s035') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s036') }}</strong><span>{{ $t('s037') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s020') }}</strong><span>{{ $t('s038') }}</span></div>
                </div>
            </div>
        </section>

        <section id="seo-method" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s128') }}</span>
                <h2 class="landing__head">{{ $t('s039') }}</h2>
                <div class="steps">
                    <div class="steps__item">
                        <strong>{{ $t('s040') }}</strong>
                        <p>{{ $t('s041') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s042') }}</strong>
                        <p>{{ $t('s043') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s044') }}</strong>
                        <p>{{ $t('s045') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s046') }}</strong>
                        <p>{{ $t('s047') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s048') }}</strong>
                        <p>{{ $t('s049') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="seo-ai" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s129') }}</span>
                <h2 class="landing__head">{{ $t('s050') }}</h2>
                <p class="landing__body">{{ $t('s051') }}</p>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s052') }}</h3>
                        <p>{{ $t('s053') }}</p>
                        <ul>
                            <li>{{ $t('s054') }}</li>
                            <li>{{ $t('s055') }}</li>
                            <li>{{ $t('s056') }}</li>
                        </ul>
                        <a href="{{ intl_route('services.seo.aeo') }}">{{ $t('s057') }}</a>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s058') }}</h3>
                        <p>{{ $t('s059') }}</p>
                        <ul>
                            <li>{{ $t('s060') }}</li>
                            <li>{{ $t('s061') }}</li>
                            <li>{{ $t('s062') }}</li>
                        </ul>
                        <a href="{{ intl_route('services.seo.geo') }}">{{ $t('s063') }}</a>
                    </div>
                </div>
                <p class="landing__note">{{ $t('s064') }}</p>
            </div>
        </section>

        <section id="seo-deliverables" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s130') }}</span>
                <h2 class="landing__head">{{ $t('s065') }}</h2>
                <p class="landing__body">{{ $t('s066') }}</p>
                <ul class="landing__evidence">
                    <li><strong>{{ $t('s067') }}</strong> {{ $t('s068') }}</li>
                    <li><strong>{{ $t('s069') }}</strong> {{ $t('s070') }}</li>
                    <li><strong>{{ $t('s071') }}</strong> {{ $t('s072') }}</li>
                    <li><strong>{{ $t('s073') }}</strong> {{ $t('s074') }}</li>
                    <li><strong>{{ $t('s075') }}</strong> {{ $t('s076') }}</li>
                    <li><strong>{{ $t('s077') }}</strong> {{ $t('s078') }}</li>
                </ul>
            </div>
        </section>

        <section id="seo-measurement" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s131') }}</span>
                <h2 class="landing__head">{{ $t('s079') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s080') }}</h3>
                        <ul>
                            <li>{{ $t('s081') }}</li>
                            <li>{{ $t('s082') }}</li>
                            <li>{{ $t('s083') }}</li>
                            <li>{{ $t('s084') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s085') }}</h3>
                        <ul>
                            <li>{{ $t('s086') }}</li>
                            <li>{{ $t('s087') }}</li>
                            <li>{{ $t('s088') }}</li>
                            <li>{{ $t('s089') }}</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">{{ $t('s090') }}</p>
            </div>
        </section>

        <section id="seo-areas" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s132') }}</span>
                <h2 class="landing__head">{{ $t('s091') }}</h2>
                <p class="landing__body">{{ $t('s092') }}</p>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('services.seo.aeo') }}"><strong>{{ $t('s133') }}</strong><p>{{ $t('s093') }}</p><span>{{ $t('s094') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.seo.geo') }}"><strong>{{ $t('s134') }}</strong><p>{{ $t('s095') }}</p><span>{{ $t('s096') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.seo.sub', ['sub' => 'backlinks']) }}"><strong>{{ $t('s097') }}</strong><p>{{ $t('s098') }}</p><span>{{ $t('s099') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.seo.sub', ['sub' => 'naver-place']) }}"><strong>{{ $t('s100') }}</strong><p>{{ $t('s101') }}</p><span>{{ $t('s102') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.seo.sub', ['sub' => 'naver-shopping']) }}"><strong>{{ $t('s103') }}</strong><p>{{ $t('s104') }}</p><span>{{ $t('s102') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.seo.sub', ['sub' => 'coupang']) }}"><strong>{{ $t('s105') }}</strong><p>{{ $t('s106') }}</p><span>{{ $t('s102') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.seo.sub', ['sub' => 'kakao-gift']) }}"><strong>{{ $t('s107') }}</strong><p>{{ $t('s108') }}</p><span>{{ $t('s102') }}</span></a>
                </div>
            </div>
        </section>

        <section id="seo-fit" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s135') }}</span>
                <h2 class="landing__head">{{ $t('s109') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s110') }}</h3>
                        <ul>
                            <li>{{ $t('s111') }}</li>
                            <li>{{ $t('s112') }}</li>
                            <li>{{ $t('s113') }}</li>
                            <li>{{ $t('s114') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s115') }}</h3>
                        <ul>
                            <li>{{ $t('s116') }}</li>
                            <li>{{ $t('s117') }}</li>
                            <li>{{ $t('s118') }}</li>
                            <li>{{ $t('s119') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="seo-faq" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s136') }}</span>
                <h2 class="landing__head">{{ $t('s120') }}</h2>
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
                <h2>{{ $t('s121') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s122') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s015') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection

