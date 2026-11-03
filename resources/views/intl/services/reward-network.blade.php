@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/reward-network.'.$key);
    $lines = fn (array|string $value) => implode('<br>', array_map('e', (array) $value));
@endphp

@php
    $faqs = [
        ['question' => $t('s000'), 'answer' => $t('s001')],
        ['question' => $t('s002'), 'answer' => $t('s003')],
        ['question' => $t('s004'), 'answer' => $t('s005')],
        ['question' => $t('s006'), 'answer' => $t('s007')],
        ['question' => $t('s008'), 'answer' => $t('s009')],
        ['question' => $t('s010'), 'answer' => $t('s011')],
        ['question' => $t('s012'), 'answer' => $t('s013')],
        ['question' => $t('s014'), 'answer' => $t('s015')],
    ];
@endphp

@section('title', $t('s016'))
@section('meta')
    <meta name="description" content="{{ $t('s017') }}">
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
                <div class="landing__hero-mark"><span class="icon3d icon-il">@include('partials.icon', ['name' => 'reward'])</span></div>
                <span class="landing__eyebrow">{{ $t('s250') }}</span>
                <h1>{!! $lines([$t('s022'), $t('s023')]) !!}</h1>
                <p class="landing__lead">{{ $t('s024') }}</p>
                <div class="landing__chips">
                    <span style="color:var(--ink);border-color:var(--hairline);">{{ $t('s025') }}</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">{{ $t('s026') }}</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">{{ $t('s027') }}</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">{{ $t('s028') }}</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">{{ $t('s029') }}</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">{{ $t('s030') }}</span>
                </div>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact', ['service_interest' => 'reward-advertiser', 'message' => $t('s246')]) }}">{{ $t('s031') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact', ['service_interest' => 'reward-publisher', 'message' => $t('s247')]) }}">{{ $t('s032') }}</a>
                </div>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'reward'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s018') }}">
            <div class="landing__local-nav-inner">
                <a href="#ecosystem">{{ $t('s033') }}</a>
                <a href="#advertisers">{{ $t('s034') }}</a>
                <a href="#quality">{{ $t('s035') }}</a>
                <a href="#publishers">{{ $t('s036') }}</a>
                <a href="#onboarding">{{ $t('s037') }}</a>
                <a href="#deliverables">{{ $t('s038') }}</a>
                <a href="#fit">{{ $t('s039') }}</a>
                <a href="#faq">{{ $t('s251') }}</a>
            </div>
        </nav>

        
        <section class="landing__section landing__section--dark has-orb" id="placements">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s252') }}</span>
                <h2 class="landing__head">{{ $t('s040') }}</h2>
                <p class="landing__lead">{{ $t('s041') }}</p>

                <div class="rw-showcase" role="list">
                    
                    <div class="rw-phone" role="listitem">
                        <div class="rw-phone__frame">
                            <span class="rw-phone__notch"></span>
                            <div class="rw-phone__screen">
                                <div class="rw-phone__status"><span>{{ $t('s253') }}</span><span>{{ $t('s254') }}</span></div>
                                <div class="rw-ss"><span class="rw-ss__q">{{ $t('s042') }}</span><span class="rw-ss__mic">🎙</span></div>
                                <div class="rw-tabs"><span>{{ $t('s043') }}</span><span>{{ $t('s044') }}</span><span>{{ $t('s045') }}</span><span>{{ $t('s046') }}</span><span>{{ $t('s047') }}</span></div>
                                <div class="rw-panel">
                                    <div class="rw-panel__head"><strong>{{ $t('s048') }}</strong><span class="rw-badge">{{ $t('s049') }}</span></div>
                                    <div class="rw-list">
                                        <div class="rw-card">
                                            <div class="rw-thumb rw-thumb--meat">🥩</div>
                                            <div class="rw-card__body">
                                                <strong>{{ $t('s050') }}</strong>
                                                <span class="rw-meta">{{ $t('s051') }}</span>
                                                <span class="rw-star">{{ $t('s255') }}</span>
                                            </div>
                                        </div>
                                        <div class="rw-mini"><span class="rw-mini__box">🍖</span><span class="rw-mini__box">🔥</span><span class="rw-mini__box">🥓</span><span class="rw-mini__box">🍗</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="rw-phone-cap">{{ $t('s052') }}</p>
                    </div>

                    
                    <div class="rw-phone" role="listitem">
                        <div class="rw-phone__frame">
                            <span class="rw-phone__notch"></span>
                            <div class="rw-phone__screen">
                                <div class="rw-phone__status"><span>{{ $t('s256') }}</span><span>{{ $t('s257') }}</span></div>
                                <div class="rw-mission-hero">
                                    <span class="rw-mission-hero__eyebrow">{{ $t('s053') }}</span>
                                    <strong>{{ $t('s054') }}</strong>
                                    <div class="rw-progress"><i></i><i></i><i class="is-off"></i><i class="is-off"></i></div>
                                </div>
                                <p class="rw-mission-count">{{ $t('s055') }}</p>
                                <p class="rw-mission-title">{{ $t('s056') }}</p>
                                <div class="rw-missions">
                                    <div class="rw-mission is-done"><div><strong>{{ $t('s057') }}</strong><span>{{ $t('s058') }}</span></div><span class="rw-check">✓</span></div>
                                    <div class="rw-mission is-done"><div><strong>{{ $t('s059') }}</strong><span>{{ $t('s060') }}</span></div><span class="rw-check">✓</span></div>
                                    <div class="rw-mission is-active"><div><strong>{{ $t('s061') }}</strong><span>{{ $t('s062') }}</span></div><span class="rw-arrow">→</span></div>
                                    <div class="rw-mission"><div><strong>{{ $t('s063') }}</strong><span>{{ $t('s064') }}</span></div><span class="rw-arrow">›</span></div>
                                </div>
                            </div>
                        </div>
                        <p class="rw-phone-cap">{{ $t('s065') }}</p>
                    </div>

                    
                    <div class="rw-phone" role="listitem">
                        <div class="rw-phone__frame">
                            <span class="rw-phone__notch"></span>
                            <div class="rw-phone__screen">
                                <div class="rw-phone__status"><span>{{ $t('s258') }}</span><span>{{ $t('s259') }}</span></div>
                                <div class="rw-store-bar"><span>←</span><strong>{{ $t('s066') }}</strong><span>🛒</span></div>
                                <div class="rw-ss rw-ss--sm"><span class="rw-ss__q">{{ $t('s067') }}</span><span class="rw-ss__mic">🔍</span></div>
                                <div class="rw-chips"><span class="is-on">{{ $t('s068') }}</span><span>{{ $t('s069') }}</span><span>{{ $t('s070') }}</span><span>{{ $t('s071') }}</span></div>
                                <div class="rw-list">
                                    <div class="rw-card">
                                        <div class="rw-thumb rw-thumb--flower">🌷</div>
                                        <div class="rw-card__body">
                                            <strong>{{ $t('s072') }}</strong>
                                            <span class="rw-meta">{{ $t('s073') }}</span>
                                            <span class="rw-price"><em>{{ $t('s260') }}</em> {{ $t('s074') }}</span>
                                        </div>
                                    </div>
                                    <div class="rw-card">
                                        <div class="rw-thumb rw-thumb--plant">🪴</div>
                                        <div class="rw-card__body">
                                            <strong>{{ $t('s075') }}</strong>
                                            <span class="rw-meta">{{ $t('s076') }}</span>
                                            <span class="rw-price"><em>{{ $t('s261') }}</em> {{ $t('s077') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="rw-phone-cap">{{ $t('s078') }}</p>
                    </div>
                </div>

                <p class="rw-showcase-cap">{{ $t('s079') }}</p>
                <p class="landing__note">{{ $t('s080') }}</p>
            </div>
        </section>

        
        <section class="landing__section landing__section--dark is-black" id="partners">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s262') }}</span>
                <h2 class="landing__head">{{ $t('s081') }}<br>{{ $t('s082') }}</h2>
                <p class="landing__lead">{{ $t('s083') }}</p>
                
                <div class="rw-networks">
                    <span class="rw-networks__title">{{ $t('s084') }}</span>
                    <ul class="rw-networks__logos">
                        <li><img src="{{ asset('images/networks/buzzvil.svg') }}" alt="{{ $t('s019') }}" width="113" height="34" style="height:30px"></li>
                        <li><img src="{{ asset('images/networks/adpopcorn.png') }}" alt="{{ $t('s020') }}" width="152" height="22" style="height:20px"></li>
                        <li class="rw-networks__word">{{ $t('s263') }}</li>
                        <li class="rw-networks__word">{{ $t('s085') }}</li>
                    </ul>
                </div>
            </div>
            @php
                $partnerTop = range(1, 13);
                $partnerBottom = range(14, 26);
            @endphp
            <div class="partner-belt-wrap">
                <div class="marquee partner-belt" aria-label="{{ $t('s021') }}">
                    <ul class="marquee__track" role="list">
                        @foreach (array_merge($partnerTop, $partnerTop) as $i => $n)
                            <li class="partner-logo" aria-hidden="true"><img src="{{ asset('images/partners/logo-'.sprintf('%02d', $n).'.png') }}" alt="" loading="lazy" width="240" height="240"></li>
                        @endforeach
                    </ul>
                </div>
                <div class="marquee partner-belt" aria-hidden="true">
                    <ul class="marquee__track marquee__track--reverse" role="list">
                        @foreach (array_merge($partnerBottom, $partnerBottom) as $n)
                            <li class="partner-logo"><img src="{{ asset('images/partners/logo-'.sprintf('%02d', $n).'.png') }}" alt="" loading="lazy" width="240" height="240"></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="landing__inner">
                <p class="landing__note" style="text-align:center;">{{ $t('s086') }}</p>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="ecosystem">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s264') }}</span>
                <h2 class="landing__head">{{ $t('s087') }}</h2>
                <p class="landing__lead">{{ $t('s088') }}</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s089') }}</strong>
                        <p>{{ $t('s090') }}</p>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s091') }}</strong>
                        <p>{{ $t('s092') }}</p>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s093') }}</strong>
                        <p>{{ $t('s094') }}</p>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s095') }}</strong>
                        <p>{{ $t('s096') }}</p>
                    </div>
                </div>
                <div class="landing__callout">{{ $t('s097') }}</div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s265') }}</span>
                <h2 class="landing__head">{{ $t('s098') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s099') }}</h3>
                        <p>{{ $t('s100') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s101') }}</h3>
                        <p>{{ $t('s102') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s103') }}</h3>
                        <p>{{ $t('s104') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s105') }}</h3>
                        <p>{{ $t('s106') }}</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb" id="advertisers">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s266') }}</span>
                <h2 class="landing__head">{{ $t('s107') }}</h2>
                <p class="landing__lead">{{ $t('s108') }}</p>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s109') }}</strong><p>{{ $t('s110') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s111') }}</strong><p>{{ $t('s112') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s113') }}</strong><p>{{ $t('s114') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s115') }}</strong><p>{{ $t('s116') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s117') }}</strong><p>{{ $t('s118') }}</p></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s267') }}</span>
                <h2 class="landing__head">{{ $t('s119') }}</h2>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr><th scope="col">{{ $t('s120') }}</th><th scope="col">{{ $t('s121') }}</th><th scope="col">{{ $t('s122') }}</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">{{ $t('s123') }}</th><td>{{ $t('s124') }}</td><td>{{ $t('s125') }}</td></tr>
                            <tr><th scope="row">{{ $t('s126') }}</th><td>{{ $t('s127') }}</td><td>{{ $t('s128') }}</td></tr>
                            <tr><th scope="row">{{ $t('s129') }}</th><td>{{ $t('s130') }}</td><td>{{ $t('s131') }}</td></tr>
                            <tr><th scope="row">{{ $t('s132') }}</th><td>{{ $t('s133') }}</td><td>{{ $t('s134') }}</td></tr>
                            <tr><th scope="row">{{ $t('s135') }}</th><td>{{ $t('s136') }}</td><td>{{ $t('s137') }}</td></tr>
                        </tbody>
                    </table>
                </div>
                <p class="landing__note">{{ $t('s138') }}</p>
            </div>
        </section>

        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s268') }}</span>
                <h2 class="landing__head">{{ $t('s139') }}</h2>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>{{ $t('s140') }}</strong><span>{{ $t('s141') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s142') }}</strong><span>{{ $t('s143') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s144') }}</strong><span>{{ $t('s145') }}</span></div>
                    <div class="landing__point landing__point--light"><strong>{{ $t('s146') }}</strong><span>{{ $t('s147') }}</span></div>
                </div>
                <div class="prose" style="margin-top:28px;">
                    <p>{{ $t('s148') }}</p>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb" id="quality">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s269') }}</span>
                <h2 class="landing__head">{{ $t('s149') }}</h2>
                <p class="landing__lead">{{ $t('s150') }}</p>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s151') }}</strong><span>{{ $t('s152') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s153') }}</strong><span>{{ $t('s154') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s155') }}</strong><span>{{ $t('s156') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s157') }}</strong><span>{{ $t('s158') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s159') }}</strong><span>{{ $t('s160') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s161') }}</strong><span>{{ $t('s162') }}</span></div>
                </div>
                <p class="landing__note">{{ $t('s163') }}</p>
            </div>
        </section>

        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s270') }}</span>
                <h2 class="landing__head">{{ $t('s164') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s165') }}</strong><p>{{ $t('s166') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s167') }}</strong><p>{{ $t('s168') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s169') }}</strong><p>{{ $t('s170') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s171') }}</strong><p>{{ $t('s172') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s173') }}</strong><p>{{ $t('s174') }}</p></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="publishers">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s271') }}</span>
                <h2 class="landing__head">{{ $t('s175') }}</h2>
                <p class="landing__lead">{{ $t('s176') }}</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s177') }}</h3>
                        <ul>
                            <li>{{ $t('s178') }}</li>
                            <li>{{ $t('s179') }}</li>
                            <li>{{ $t('s180') }}</li>
                            <li>{{ $t('s181') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s182') }}</h3>
                        <ul>
                            <li>{{ $t('s183') }}</li>
                            <li>{{ $t('s184') }}</li>
                            <li>{{ $t('s185') }}</li>
                            <li>{{ $t('s186') }}</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">{{ $t('s187') }}</p>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s272') }}</span>
                <h2 class="landing__head">{{ $t('s188') }}</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s189') }}</strong><span>{{ $t('s190') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s191') }}</strong><span>{{ $t('s192') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s193') }}</strong><span>{{ $t('s194') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s195') }}</strong><span>{{ $t('s196') }}</span></div>
                </div>
                <p class="landing__note">{{ $t('s197') }}</p>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="onboarding">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s273') }}</span>
                <h2 class="landing__head">{{ $t('s198') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s199') }}</strong><p>{{ $t('s200') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s201') }}</strong><p>{{ $t('s202') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s203') }}</strong><p>{{ $t('s204') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s205') }}</strong><p>{{ $t('s206') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s207') }}</strong><p>{{ $t('s208') }}</p></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="deliverables">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s274') }}</span>
                <h2 class="landing__head">{{ $t('s209') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s210') }}</h3>
                        <ul>
                            <li>{{ $t('s211') }}</li>
                            <li>{{ $t('s212') }}</li>
                            <li>{{ $t('s213') }}</li>
                            <li>{{ $t('s214') }}</li>
                            <li>{{ $t('s215') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s216') }}</h3>
                        <ul>
                            <li>{{ $t('s217') }}</li>
                            <li>{{ $t('s218') }}</li>
                            <li>{{ $t('s219') }}</li>
                            <li>{{ $t('s220') }}</li>
                            <li>{{ $t('s221') }}</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s275') }}</span>
                <h2 class="landing__head">{{ $t('s222') }}</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s223') }}</strong><span>{{ $t('s224') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s225') }}</strong><span>{{ $t('s226') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s227') }}</strong><span>{{ $t('s228') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s229') }}</strong><span>{{ $t('s230') }}</span></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s276') }}</span>
                <h2 class="landing__head">{{ $t('s231') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s232') }}</h3>
                        <ul>
                            <li>{{ $t('s233') }}</li>
                            <li>{{ $t('s234') }}</li>
                            <li>{{ $t('s235') }}</li>
                            <li>{{ $t('s236') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s237') }}</h3>
                        <ul>
                            <li>{{ $t('s238') }}</li>
                            <li>{{ $t('s239') }}</li>
                            <li>{{ $t('s240') }}</li>
                            <li>{{ $t('s241') }}</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s277') }}</span>
                <h2 class="landing__head">{{ $t('s242') }}</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item"><summary>{{ $faq['question'] }}</summary><p>{{ $faq['answer'] }}</p></details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">{{ $t('s278') }}</span>
                <h2>{{ $t('s243') }}<br>{{ $t('s244') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s245') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact', ['service_interest' => 'reward-advertiser', 'message' => $t('s248')]) }}">{{ $t('s031') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact', ['service_interest' => 'reward-publisher', 'message' => $t('s249')]) }}">{{ $t('s032') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection

