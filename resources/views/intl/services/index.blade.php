@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/services-index.'.$key);
    $lines = fn (array|string $value) => implode('<br>', array_map('e', (array) $value));
@endphp

@php
    $faqs = [
        ['question' => $t('s000'), 'answer' => $t('s001')],
        ['question' => $t('s002'), 'answer' => $t('s003')],
        ['question' => $t('s004'), 'answer' => $t('s005')],
        ['question' => $t('s006'), 'answer' => $t('s007')],
        ['question' => $t('s008'), 'answer' => $t('s009')],
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
                <span class="landing__eyebrow">{{ $t('s088') }}</span>
                <h1>{!! $lines([$t('s013'), $t('s014')]) !!}</h1>
                <p class="landing__lead">{{ $t('s015') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s016') }}</a>
                    <a class="btn-ghost" href="#service-map">{{ $t('s017') }}</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s012') }}">
            <div class="landing__local-nav-inner">
                <a href="#service-map">{{ $t('s018') }}</a>
                <a href="#operating-system">{{ $t('s019') }}</a>
                <a href="#selection-guide">{{ $t('s020') }}</a>
                <a href="#process">{{ $t('s021') }}</a>
                <a href="#faq">{{ $t('s089') }}</a>
            </div>
        </nav>

        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s090') }}</span>
                <h2 class="landing__head">{{ $t('s022') }}</h2>
                <div class="prose">
                    <p>{{ $t('s023') }}</p>
                    <p>{{ $t('s024') }}</p>
                </div>
                <div class="landing__callout">{{ $t('s025') }}</div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="service-map">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s091') }}</span>
                <h2 class="landing__head">{{ $t('s026') }}</h2>
                <p class="landing__lead">{{ $t('s027') }}</p>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('services.show', ['slug' => 'performance-marketing']) }}">
                        <strong>{{ $t('s028') }}</strong>
                        <p>{{ $t('s029') }}</p>
                        <span>{{ $t('s030') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('services.show', ['slug' => 'cpa-marketing']) }}">
                        <strong>{{ $t('s031') }}</strong>
                        <p>{{ $t('s032') }}</p>
                        <span>{{ $t('s033') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('services.show', ['slug' => 'reward-network']) }}">
                        <strong>{{ $t('s034') }}</strong>
                        <p>{{ $t('s035') }}</p>
                        <span>{{ $t('s036') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('services.show', ['slug' => 'seo']) }}">
                        <strong>{{ $t('s092') }}</strong>
                        <p>{{ $t('s037') }}</p>
                        <span>{{ $t('s038') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('services.show', ['slug' => 'wordpress']) }}">
                        <strong>{{ $t('s039') }}</strong>
                        <p>{{ $t('s040') }}</p>
                        <span>{{ $t('s041') }}</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb" id="operating-system">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s093') }}</span>
                <h2 class="landing__head">{{ $t('s042') }}</h2>
                <p class="landing__lead">{{ $t('s043') }}</p>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s044') }}</strong><span>{{ $t('s045') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s046') }}</strong><span>{{ $t('s047') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s048') }}</strong><span>{{ $t('s049') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s050') }}</strong><span>{{ $t('s051') }}</span></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="selection-guide">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s094') }}</span>
                <h2 class="landing__head">{{ $t('s052') }}</h2>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr><th scope="col">{{ $t('s053') }}</th><th scope="col">{{ $t('s054') }}</th><th scope="col">{{ $t('s055') }}</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">{{ $t('s056') }}</th><td class="is-cpa">{{ $t('s028') }}</td><td>{{ $t('s057') }}</td></tr>
                            <tr><th scope="row">{{ $t('s058') }}</th><td class="is-cpa">{{ $t('s031') }}</td><td>{{ $t('s059') }}</td></tr>
                            <tr><th scope="row">{{ $t('s060') }}</th><td class="is-cpa">{{ $t('s034') }}</td><td>{{ $t('s061') }}</td></tr>
                            <tr><th scope="row">{{ $t('s062') }}</th><td class="is-cpa">{{ $t('s095') }}</td><td>{{ $t('s063') }}</td></tr>
                            <tr><th scope="row">{{ $t('s064') }}</th><td class="is-cpa">{{ $t('s065') }}</td><td>{{ $t('s066') }}</td></tr>
                        </tbody>
                    </table>
                </div>
                <p class="landing__note">{{ $t('s067') }}</p>
            </div>
        </section>

        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s096') }}</span>
                <h2 class="landing__head">{{ $t('s068') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s069') }}</h3>
                        <p>{{ $t('s070') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s071') }}</h3>
                        <p>{{ $t('s072') }}</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb" id="process">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s097') }}</span>
                <h2 class="landing__head">{{ $t('s073') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s074') }}</strong><p>{{ $t('s075') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s076') }}</strong><p>{{ $t('s077') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s078') }}</strong><p>{{ $t('s079') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s080') }}</strong><p>{{ $t('s081') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s082') }}</strong><p>{{ $t('s083') }}</p></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s098') }}</span>
                <h2 class="landing__head">{{ $t('s084') }}</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item"><summary>{{ $faq['question'] }}</summary><p>{{ $faq['answer'] }}</p></details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>{{ $t('s085') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s086') }}</p>
                <div class="cta-row"><a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s087') }}</a></div>
            </div>
        </section>
    </main>
@endsection

