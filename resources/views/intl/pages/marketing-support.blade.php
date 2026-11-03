@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/marketing-support.'.$key);
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
                <span class="landing__eyebrow">{{ $t('s123') }}</span>
                <h1>{{ $t('s013') }}</h1>
                <p class="landing__lead">{{ $t('s014') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s015') }}</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s012') }}">
            <div class="landing__local-nav-inner">
                <a href="#support-first">{{ $t('s016') }}</a>
                <a href="#support-problem">{{ $t('s017') }}</a>
                <a href="#support-scope">{{ $t('s018') }}</a>
                <a href="#support-services">{{ $t('s019') }}</a>
                <a href="#support-process">{{ $t('s020') }}</a>
                <a href="#support-deliverables">{{ $t('s021') }}</a>
                <a href="#support-roles">{{ $t('s022') }}</a>
                <a href="#support-fit">{{ $t('s023') }}</a>
                <a href="#support-faq">{{ $t('s124') }}</a>
            </div>
        </nav>

        <section id="support-first" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s125') }}</span>
                <h2 class="landing__head">{{ $t('s024') }}</h2>
                <div class="prose">
                    <p>{{ $t('s025') }}</p>
                    <p>{{ $t('s026') }}</p>
                </div>
                <p class="landing__note">{{ $t('s027') }}</p>
            </div>
        </section>

        <section id="support-problem" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s126') }}</span>
                <h2 class="landing__head">{{ $t('s028') }}</h2>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>{{ $t('s029') }}</strong><span>{{ $t('s030') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s031') }}</strong><span>{{ $t('s032') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s033') }}</strong><span>{{ $t('s034') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s035') }}</strong><span>{{ $t('s036') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s037') }}</strong><span>{{ $t('s038') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s039') }}</strong><span>{{ $t('s040') }}</span></div>
                </div>
            </div>
        </section>

        <section id="support-scope" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s127') }}</span>
                <h2 class="landing__head">{{ $t('s041') }}</h2>
                <p class="landing__lead">{{ $t('s042') }}</p>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s043') }}</strong><span>{{ $t('s044') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s045') }}</strong><span>{{ $t('s046') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s047') }}</strong><span>{{ $t('s048') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s049') }}</strong><span>{{ $t('s050') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s051') }}</strong><span>{{ $t('s052') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s053') }}</strong><span>{{ $t('s054') }}</span></div>
                </div>
            </div>
        </section>

        <section id="support-services" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s128') }}</span>
                <h2 class="landing__head">{{ $t('s055') }}</h2>
                <p class="landing__body">{{ $t('s056') }}</p>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('services.show', ['slug' => 'performance-marketing']) }}"><strong>{{ $t('s057') }}</strong><p>{{ $t('s058') }}</p><span>{{ $t('s059') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.show', ['slug' => 'seo']) }}"><strong>{{ $t('s129') }}</strong><p>{{ $t('s060') }}</p><span>{{ $t('s059') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.show', ['slug' => 'wordpress']) }}"><strong>{{ $t('s061') }}</strong><p>{{ $t('s062') }}</p><span>{{ $t('s059') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.performance.sub', ['sub' => 'youtube']) }}"><strong>{{ $t('s063') }}</strong><p>{{ $t('s064') }}</p><span>{{ $t('s059') }}</span></a>
                </div>
                <p class="landing__note">{{ $t('s065') }}</p>
            </div>
        </section>

        <section id="support-process" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s130') }}</span>
                <h2 class="landing__head">{{ $t('s066') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s067') }}</strong><p>{{ $t('s068') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s069') }}</strong><p>{{ $t('s070') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s071') }}</strong><p>{{ $t('s072') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s073') }}</strong><p>{{ $t('s074') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s075') }}</strong><p>{{ $t('s076') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s077') }}</strong><p>{{ $t('s078') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s053') }}</strong><p>{{ $t('s079') }}</p></div>
                </div>
            </div>
        </section>

        <section id="support-deliverables" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s131') }}</span>
                <h2 class="landing__head">{{ $t('s080') }}</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s081') }}</strong><span>{{ $t('s082') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s083') }}</strong><span>{{ $t('s084') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s085') }}</strong><span>{{ $t('s086') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s087') }}</strong><span>{{ $t('s088') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s089') }}</strong><span>{{ $t('s090') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s091') }}</strong><span>{{ $t('s092') }}</span></div>
                </div>
                <p class="landing__note">{{ $t('s093') }}</p>
            </div>
        </section>

        <section id="support-roles" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s132') }}</span>
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

        <section id="support-fit" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s133') }}</span>
                <h2 class="landing__head">{{ $t('s108') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s109') }}</h3>
                        <ul>
                            <li>{{ $t('s110') }}</li>
                            <li>{{ $t('s111') }}</li>
                            <li>{{ $t('s112') }}</li>
                            <li>{{ $t('s113') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s114') }}</h3>
                        <ul>
                            <li>{{ $t('s115') }}</li>
                            <li>{{ $t('s116') }}</li>
                            <li>{{ $t('s117') }}</li>
                            <li>{{ $t('s118') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="support-faq" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s134') }}</span>
                <h2 class="landing__head">{{ $t('s119') }}</h2>
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
                <h2>{{ $t('s120') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s121') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s122') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection

