@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/aeo.'.$key);
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
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="{{ $t('s012') }}">
                    <a href="{{ intl_route('services.show', ['slug' => 'seo']) }}">{{ $t('s111') }}</a>
                </nav>
                <span class="landing__eyebrow">{{ $t('s112') }}</span>
                <h1>{{ $t('s014') }}</h1>
                <p class="landing__lead">{{ $t('s015') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s016') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact', ['service_interest' => 'seo']) }}">{{ $t('s017') }}</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s013') }}">
            <div class="landing__local-nav-inner">
                <a href="#aeo-problem">{{ $t('s018') }}</a>
                <a href="#aeo-questions">{{ $t('s019') }}</a>
                <a href="#aeo-anatomy">{{ $t('s020') }}</a>
                <a href="#aeo-technical">{{ $t('s021') }}</a>
                <a href="#aeo-process">{{ $t('s022') }}</a>
                <a href="#aeo-deliverables">{{ $t('s023') }}</a>
                <a href="#aeo-measurement">{{ $t('s024') }}</a>
                <a href="#aeo-faq">{{ $t('s113') }}</a>
            </div>
        </nav>

        <section id="aeo-problem" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s114') }}</span>
                <h2 class="landing__head">{{ $t('s025') }}</h2>
                <div class="prose">
                    <p>{{ $t('s026') }}</p>
                    <p>{{ $t('s027') }}</p>
                </div>
                <div class="landing__callout">{{ $t('s028') }}</div>
            </div>
        </section>

        <section id="aeo-questions" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s115') }}</span>
                <h2 class="landing__head">{{ $t('s029') }}</h2>
                <p class="landing__body">{{ $t('s030') }}</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>{{ $t('s031') }}</strong><span>{{ $t('s032') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s033') }}</strong><span>{{ $t('s034') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s035') }}</strong><span>{{ $t('s036') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s037') }}</strong><span>{{ $t('s038') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s039') }}</strong><span>{{ $t('s040') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s041') }}</strong><span>{{ $t('s042') }}</span></div>
                </div>
            </div>
        </section>

        <section id="aeo-anatomy" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s116') }}</span>
                <h2 class="landing__head">{{ $t('s043') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s044') }}</strong><p>{{ $t('s045') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s046') }}</strong><p>{{ $t('s047') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s048') }}</strong><p>{{ $t('s049') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s050') }}</strong><p>{{ $t('s051') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s052') }}</strong><p>{{ $t('s053') }}</p></div>
                </div>
            </div>
        </section>

        <section id="aeo-technical" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s117') }}</span>
                <h2 class="landing__head">{{ $t('s054') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s055') }}</h3>
                        <ul>
                            <li>{{ $t('s056') }}</li>
                            <li>{{ $t('s057') }}</li>
                            <li>{{ $t('s058') }}</li>
                            <li>{{ $t('s059') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s060') }}</h3>
                        <ul>
                            <li>{{ $t('s061') }}</li>
                            <li>{{ $t('s062') }}</li>
                            <li>{{ $t('s063') }}</li>
                            <li>{{ $t('s064') }}</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">{{ $t('s065') }}</p>
            </div>
        </section>

        <section id="aeo-process" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s118') }}</span>
                <h2 class="landing__head">{{ $t('s066') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s067') }}</strong><p>{{ $t('s068') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s069') }}</strong><p>{{ $t('s070') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s071') }}</strong><p>{{ $t('s072') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s073') }}</strong><p>{{ $t('s074') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s075') }}</strong><p>{{ $t('s076') }}</p></div>
                </div>
            </div>
        </section>

        <section id="aeo-deliverables" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s119') }}</span>
                <h2 class="landing__head">{{ $t('s077') }}</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s078') }}</strong><span>{{ $t('s079') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s080') }}</strong><span>{{ $t('s081') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s082') }}</strong><span>{{ $t('s083') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s084') }}</strong><span>{{ $t('s085') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s086') }}</strong><span>{{ $t('s087') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s088') }}</strong><span>{{ $t('s089') }}</span></div>
                </div>
            </div>
        </section>

        <section id="aeo-measurement" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s120') }}</span>
                <h2 class="landing__head">{{ $t('s090') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s091') }}</h3>
                        <ul>
                            <li>{{ $t('s092') }}</li>
                            <li>{{ $t('s093') }}</li>
                            <li>{{ $t('s094') }}</li>
                            <li>{{ $t('s095') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s096') }}</h3>
                        <ul>
                            <li>{{ $t('s097') }}</li>
                            <li>{{ $t('s098') }}</li>
                            <li>{{ $t('s099') }}</li>
                            <li>{{ $t('s100') }}</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">{{ $t('s101') }}</p>
            </div>
        </section>

        <section id="aeo-faq" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s121') }}</span>
                <h2 class="landing__head">{{ $t('s102') }}</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item">
                            <summary>{{ $faq['question'] }}</summary>
                            <p>{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('services.seo.geo') }}"><strong>{{ $t('s103') }}</strong><p>{{ $t('s104') }}</p><span>{{ $t('s105') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.show', ['slug' => 'seo']) }}"><strong>{{ $t('s106') }}</strong><p>{{ $t('s107') }}</p><span>{{ $t('s108') }}</span></a>
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>{{ $t('s109') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s110') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s016') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact', ['service_interest' => 'seo']) }}">{{ $t('s017') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection

