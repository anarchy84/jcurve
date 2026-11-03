@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/geo.'.$key);
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
                    <a href="{{ intl_route('services.show', ['slug' => 'seo']) }}">{{ $t('s117') }}</a>
                </nav>
                <span class="landing__eyebrow">{{ $t('s118') }}</span>
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
                <a href="#geo-problem">{{ $t('s018') }}</a>
                <a href="#geo-entity">{{ $t('s019') }}</a>
                <a href="#geo-sources">{{ $t('s020') }}</a>
                <a href="#geo-content">{{ $t('s021') }}</a>
                <a href="#geo-process">{{ $t('s022') }}</a>
                <a href="#geo-deliverables">{{ $t('s023') }}</a>
                <a href="#geo-monitoring">{{ $t('s024') }}</a>
                <a href="#geo-faq">{{ $t('s119') }}</a>
            </div>
        </nav>

        <section id="geo-problem" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s120') }}</span>
                <h2 class="landing__head">{{ $t('s025') }}</h2>
                <div class="prose">
                    <p>{{ $t('s026') }}</p>
                    <p>{{ $t('s027') }}</p>
                </div>
                <div class="landing__callout">{{ $t('s028') }}</div>
            </div>
        </section>

        <section id="geo-entity" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s121') }}</span>
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

        <section id="geo-sources" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s122') }}</span>
                <h2 class="landing__head">{{ $t('s043') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s044') }}</h3>
                        <ul>
                            <li>{{ $t('s045') }}</li>
                            <li>{{ $t('s046') }}</li>
                            <li>{{ $t('s047') }}</li>
                            <li>{{ $t('s048') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s049') }}</h3>
                        <ul>
                            <li>{{ $t('s050') }}</li>
                            <li>{{ $t('s051') }}</li>
                            <li>{{ $t('s052') }}</li>
                            <li>{{ $t('s053') }}</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">{{ $t('s054') }}</p>
            </div>
        </section>

        <section id="geo-content" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s123') }}</span>
                <h2 class="landing__head">{{ $t('s055') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s056') }}</h3>
                        <ul>
                            <li>{{ $t('s057') }}</li>
                            <li>{{ $t('s058') }}</li>
                            <li>{{ $t('s059') }}</li>
                            <li>{{ $t('s060') }}</li>
                            <li>{{ $t('s061') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s062') }}</h3>
                        <ul>
                            <li>{{ $t('s063') }}</li>
                            <li>{{ $t('s064') }}</li>
                            <li>{{ $t('s065') }}</li>
                            <li>{{ $t('s066') }}</li>
                            <li>{{ $t('s067') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="geo-process" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s124') }}</span>
                <h2 class="landing__head">{{ $t('s068') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s069') }}</strong><p>{{ $t('s070') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s071') }}</strong><p>{{ $t('s072') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s073') }}</strong><p>{{ $t('s074') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s075') }}</strong><p>{{ $t('s076') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s077') }}</strong><p>{{ $t('s078') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s079') }}</strong><p>{{ $t('s080') }}</p></div>
                </div>
            </div>
        </section>

        <section id="geo-deliverables" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s125') }}</span>
                <h2 class="landing__head">{{ $t('s081') }}</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s082') }}</strong><span>{{ $t('s083') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s084') }}</strong><span>{{ $t('s085') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s086') }}</strong><span>{{ $t('s087') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s088') }}</strong><span>{{ $t('s089') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s090') }}</strong><span>{{ $t('s091') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s092') }}</strong><span>{{ $t('s093') }}</span></div>
                </div>
            </div>
        </section>

        <section id="geo-monitoring" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s126') }}</span>
                <h2 class="landing__head">{{ $t('s094') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s095') }}</h3>
                        <ul>
                            <li>{{ $t('s096') }}</li>
                            <li>{{ $t('s097') }}</li>
                            <li>{{ $t('s098') }}</li>
                            <li>{{ $t('s099') }}</li>
                            <li>{{ $t('s100') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s101') }}</h3>
                        <ul>
                            <li>{{ $t('s102') }}</li>
                            <li>{{ $t('s103') }}</li>
                            <li>{{ $t('s104') }}</li>
                            <li>{{ $t('s105') }}</li>
                            <li>{{ $t('s106') }}</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">{{ $t('s107') }}</p>
            </div>
        </section>

        <section id="geo-faq" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s127') }}</span>
                <h2 class="landing__head">{{ $t('s108') }}</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item">
                            <summary>{{ $faq['question'] }}</summary>
                            <p>{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('services.seo.aeo') }}"><strong>{{ $t('s109') }}</strong><p>{{ $t('s110') }}</p><span>{{ $t('s111') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.show', ['slug' => 'seo']) }}"><strong>{{ $t('s112') }}</strong><p>{{ $t('s113') }}</p><span>{{ $t('s114') }}</span></a>
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>{{ $t('s115') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s116') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s016') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact', ['service_interest' => 'seo']) }}">{{ $t('s017') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection

