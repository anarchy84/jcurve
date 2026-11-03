@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/wordpress.'.$key);
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
                <span class="landing__eyebrow">{{ $t('s126') }}</span>
                <h1>{{ $t('s013') }}</h1>
                <p class="landing__lead">{{ $t('s014') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s015') }}</a>
                </div>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'wordpress'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s012') }}">
            <div class="landing__local-nav-inner">
                <a href="#wordpress-problem">{{ $t('s016') }}</a>
                <a href="#wordpress-planning">{{ $t('s017') }}</a>
                <a href="#wordpress-process">{{ $t('s018') }}</a>
                <a href="#wordpress-deliverables">{{ $t('s019') }}</a>
                <a href="#wordpress-seo">{{ $t('s020') }}</a>
                <a href="#wordpress-measurement">{{ $t('s021') }}</a>
                <a href="#wordpress-operations">{{ $t('s022') }}</a>
                <a href="#wordpress-fit">{{ $t('s023') }}</a>
                <a href="#wordpress-faq">{{ $t('s127') }}</a>
            </div>
        </nav>

        <section id="wordpress-problem" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s128') }}</span>
                <h2 class="landing__head">{{ $t('s024') }}</h2>
                <div class="prose">
                    <p>{{ $t('s025') }}</p>
                    <p>{{ $t('s026') }}</p>
                </div>
                <div class="landing__callout">{{ $t('s027') }}</div>
            </div>
        </section>

        <section id="wordpress-planning" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s129') }}</span>
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

        <section id="wordpress-process" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s130') }}</span>
                <h2 class="landing__head">{{ $t('s041') }}</h2>
                <p class="landing__lead">{{ $t('s042') }}</p>
                <div class="steps">
                    <div class="steps__item">
                        <strong>{{ $t('s043') }}</strong>
                        <p>{{ $t('s044') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s045') }}</strong>
                        <p>{{ $t('s046') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s047') }}</strong>
                        <p>{{ $t('s048') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s049') }}</strong>
                        <p>{{ $t('s050') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s051') }}</strong>
                        <p>{{ $t('s052') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s053') }}</strong>
                        <p>{{ $t('s054') }}</p>
                    </div>
                    <div class="steps__item">
                        <strong>{{ $t('s055') }}</strong>
                        <p>{{ $t('s056') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="wordpress-deliverables" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s131') }}</span>
                <h2 class="landing__head">{{ $t('s057') }}</h2>
                <p class="landing__body">{{ $t('s058') }}</p>
                <ul class="landing__evidence">
                    <li><strong>{{ $t('s059') }}</strong> {{ $t('s060') }}</li>
                    <li><strong>{{ $t('s061') }}</strong> {{ $t('s062') }}</li>
                    <li><strong>{{ $t('s063') }}</strong> {{ $t('s064') }}</li>
                    <li><strong>{{ $t('s065') }}</strong> {{ $t('s066') }}</li>
                    <li><strong>{{ $t('s067') }}</strong> {{ $t('s068') }}</li>
                    <li><strong>{{ $t('s069') }}</strong> {{ $t('s070') }}</li>
                    <li><strong>{{ $t('s071') }}</strong> {{ $t('s072') }}</li>
                </ul>
            </div>
        </section>

        <section id="wordpress-seo" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s132') }}</span>
                <h2 class="landing__head">{{ $t('s073') }}</h2>
                <p class="landing__body">{{ $t('s074') }}</p>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s075') }}</h3>
                        <ul>
                            <li>{{ $t('s076') }}</li>
                            <li>{{ $t('s077') }}</li>
                            <li>{{ $t('s078') }}</li>
                            <li>{{ $t('s079') }}</li>
                            <li>{{ $t('s080') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s081') }}</h3>
                        <ul>
                            <li>{{ $t('s082') }}</li>
                            <li>{{ $t('s083') }}</li>
                            <li>{{ $t('s084') }}</li>
                            <li>{{ $t('s085') }}</li>
                            <li>{{ $t('s086') }}</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">{{ $t('s087') }}</p>
            </div>
        </section>

        <section id="wordpress-measurement" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s133') }}</span>
                <h2 class="landing__head">{{ $t('s088') }}</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s089') }}</strong><span>{{ $t('s090') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s091') }}</strong><span>{{ $t('s092') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s093') }}</strong><span>{{ $t('s094') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s095') }}</strong><span>{{ $t('s096') }}</span></div>
                </div>
                <p class="landing__note">{{ $t('s097') }}</p>
            </div>
        </section>

        <section id="wordpress-operations" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s134') }}</span>
                <h2 class="landing__head">{{ $t('s098') }}</h2>
                <p class="landing__body">{{ $t('s099') }}</p>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s100') }}</h3>
                        <ul>
                            <li>{{ $t('s101') }}</li>
                            <li>{{ $t('s102') }}</li>
                            <li>{{ $t('s103') }}</li>
                            <li>{{ $t('s104') }}</li>
                            <li>{{ $t('s105') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s106') }}</h3>
                        <ul>
                            <li>{{ $t('s107') }}</li>
                            <li>{{ $t('s108') }}</li>
                            <li>{{ $t('s109') }}</li>
                            <li>{{ $t('s110') }}</li>
                            <li>{{ $t('s111') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="wordpress-fit" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">{{ $t('s135') }}</span>
                <h2 class="landing__head">{{ $t('s112') }}</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>{{ $t('s113') }}</h3>
                        <ul>
                            <li>{{ $t('s114') }}</li>
                            <li>{{ $t('s115') }}</li>
                            <li>{{ $t('s116') }}</li>
                            <li>{{ $t('s117') }}</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>{{ $t('s118') }}</h3>
                        <ul>
                            <li>{{ $t('s119') }}</li>
                            <li>{{ $t('s120') }}</li>
                            <li>{{ $t('s121') }}</li>
                            <li>{{ $t('s122') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="wordpress-faq" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s136') }}</span>
                <h2 class="landing__head">{{ $t('s123') }}</h2>
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
                <h2>{{ $t('s124') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s125') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s015') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection

