@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/cpa-marketing.'.$key);
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
                <span class="landing__eyebrow">{{ $t('s132') }}</span>
                <h1>{{ $t('s013') }}</h1>
                <p class="landing__lead">{{ $t('s014') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s015') }}</a>
                </div>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'cpa'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s012') }}">
            <div class="landing__local-nav-inner">
                <a href="#cpa-structure">{{ $t('s016') }}</a>
                <a href="#cpa-conditions">{{ $t('s017') }}</a>
                <a href="#cpa-process">{{ $t('s018') }}</a>
                <a href="#cpa-quality">{{ $t('s019') }}</a>
                <a href="#cpa-deliverables">{{ $t('s020') }}</a>
                <a href="#cpa-industries">{{ $t('s021') }}</a>
                <a href="#cpa-insurance">{{ $t('s022') }}</a>
                <a href="#cpa-compliance">{{ $t('s023') }}</a>
                <a href="#cpa-faq">{{ $t('s133') }}</a>
            </div>
        </nav>

        <section id="cpa-structure" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s134') }}</span>
                <h2 class="landing__head">{{ $t('s024') }}</h2>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr>
                                <th scope="col">{{ $t('s025') }}</th>
                                <th scope="col">{{ $t('s026') }}</th>
                                <th scope="col" class="is-cpa">{{ $t('s135') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">{{ $t('s027') }}</th><td>{{ $t('s028') }}</td><td class="is-cpa">{{ $t('s029') }}</td></tr>
                            <tr><th scope="row">{{ $t('s030') }}</th><td>{{ $t('s031') }}</td><td class="is-cpa">{{ $t('s032') }}</td></tr>
                            <tr><th scope="row">{{ $t('s033') }}</th><td>{{ $t('s034') }}</td><td class="is-cpa">{{ $t('s035') }}</td></tr>
                            <tr><th scope="row">{{ $t('s036') }}</th><td>{{ $t('s037') }}</td><td class="is-cpa">{{ $t('s038') }}</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="landing__callout">{{ $t('s039') }}</div>
                <p class="landing__note">{{ $t('s040') }}</p>
            </div>
        </section>

        <section id="cpa-conditions" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s136') }}</span>
                <h2 class="landing__head">{{ $t('s041') }}</h2>
                <p class="landing__lead">{{ $t('s042') }}</p>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>{{ $t('s043') }}</strong>
                        <span>{{ $t('s044') }}</span>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s045') }}</strong>
                        <span>{{ $t('s046') }}</span>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s047') }}</strong>
                        <span>{{ $t('s048') }}</span>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s049') }}</strong>
                        <span>{{ $t('s050') }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="cpa-process" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s137') }}</span>
                <h2 class="landing__head">{{ $t('s051') }}</h2>
                <div class="steps">
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
                    <div class="steps__item">
                        <strong>{{ $t('s060') }}</strong>
                        <p>{{ $t('s061') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s062') }}</strong>
                        <p>{{ $t('s063') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s064') }}</strong>
                        <p>{{ $t('s065') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="cpa-quality" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s138') }}</span>
                <h2 class="landing__head">{{ $t('s066') }}</h2>
                <p class="landing__body">{{ $t('s067') }}</p>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s068') }}</h3>
                        <ul>
                            <li>{{ $t('s069') }}</li>
                            <li>{{ $t('s070') }}</li>
                            <li>{{ $t('s071') }}</li>
                            <li>{{ $t('s072') }}</li>
                            <li>{{ $t('s073') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s074') }}</h3>
                        <ul>
                            <li>{{ $t('s075') }}</li>
                            <li>{{ $t('s076') }}</li>
                            <li>{{ $t('s077') }}</li>
                            <li>{{ $t('s078') }}</li>
                            <li>{{ $t('s079') }}</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">{{ $t('s080') }}</p>
            </div>
        </section>

        <section id="cpa-deliverables" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s139') }}</span>
                <h2 class="landing__head">{{ $t('s081') }}</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>{{ $t('s082') }}</strong>
                        <span>{{ $t('s083') }}</span>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s084') }}</strong>
                        <span>{{ $t('s085') }}</span>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s086') }}</strong>
                        <span>{{ $t('s087') }}</span>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s088') }}</strong>
                        <span>{{ $t('s089') }}</span>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s090') }}</strong>
                        <span>{{ $t('s091') }}</span>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s092') }}</strong>
                        <span>{{ $t('s093') }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="cpa-industries" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s140') }}</span>
                <h2 class="landing__head">{{ $t('s094') }}</h2>
                <p class="landing__body">{{ $t('s095') }}</p>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('services.cpa.sub', ['sub' => 'real-estate']) }}"><strong>{{ $t('s096') }}</strong><p>{{ $t('s097') }}</p><span>{{ $t('s098') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.cpa.sub', ['sub' => 'stock']) }}"><strong>{{ $t('s099') }}</strong><p>{{ $t('s100') }}</p><span>{{ $t('s098') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.cpa.sub', ['sub' => 'insurance']) }}"><strong>{{ $t('s101') }}</strong><p>{{ $t('s102') }}</p><span>{{ $t('s098') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.cpa.sub', ['sub' => 'coin']) }}"><strong>{{ $t('s103') }}</strong><p>{{ $t('s104') }}</p><span>{{ $t('s098') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.cpa.sub', ['sub' => 'permission-call']) }}"><strong>{{ $t('s105') }}</strong><p>{{ $t('s106') }}</p><span>{{ $t('s098') }}</span></a>
                </div>
                <p class="landing__note">{{ $t('s107') }}</p>
            </div>
        </section>

        <section id="cpa-insurance" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s141') }}</span>
                <h2 class="landing__head">{{ $t('s108') }}</h2>
                <p class="landing__body">{{ $t('s109') }}</p>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('solutions.leadbay') }}">
                        <strong>{{ $t('s110') }}</strong>
                        <p>{{ $t('s111') }}</p>
                        <span>{{ $t('s112') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('solutions.call2sale') }}">
                        <strong>{{ $t('s113') }}</strong>
                        <p>{{ $t('s114') }}</p>
                        <span>{{ $t('s115') }}</span>
                    </a>
                </div>
            </div>
        </section>

        <section id="cpa-compliance" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s142') }}</span>
                <h2 class="landing__head">{{ $t('s116') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s117') }}</h3>
                        <ul>
                            <li>{{ $t('s118') }}</li>
                            <li>{{ $t('s119') }}</li>
                            <li>{{ $t('s120') }}</li>
                            <li>{{ $t('s121') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s122') }}</h3>
                        <ul>
                            <li>{{ $t('s123') }}</li>
                            <li>{{ $t('s124') }}</li>
                            <li>{{ $t('s125') }}</li>
                            <li>{{ $t('s126') }}</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">{{ $t('s127') }}</p>
            </div>
        </section>

        <section id="cpa-faq" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s143') }}</span>
                <h2 class="landing__head">{{ $t('s128') }}</h2>
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
                <h2>{{ $t('s129') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s130') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s131') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection

