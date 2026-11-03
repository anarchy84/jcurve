@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/boostingshop.'.$key);
    $lines = fn (array|string $value) => implode('<br>', array_map('e', (array) $value));
@endphp

@section('title', $t('title'))
@section('meta')
    <meta name="description" content="{{ $t('description') }}">
@endsection

@section('content')
    <main class="landing">
        
        <section class="landing__hero landing__hero--media">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                <nav class="subpage__breadcrumb" aria-label="{{ $t('s001') }}"><a href="{{ intl_route('solutions.index') }}">{{ $t('s003') }}</a></nav>
                <span class="landing__eyebrow">{{ $t('s004') }}</span>
                <h1>{{ $t('s005') }}</h1>
                <p class="landing__lead">{{ $t('s006') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="#products">{{ $t('s007') }}</a>
                    <a class="btn-ghost" href="#policy">{{ $t('s008') }}</a>
                    
                    <a class="btn-ghost" href="https://boostings.shop" target="_blank" rel="noopener">{{ $t('s009') }}</a>
                </div>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'boostingshop'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s002') }}">
            <div class="landing__local-nav-inner">
                <a href="#overview">{{ $t('s010') }}</a>
                <a href="#problem">{{ $t('s011') }}</a>
                <a href="#choose">{{ $t('s012') }}</a>
                <a href="#products">{{ $t('s013') }}</a>
                <a href="#process">{{ $t('s014') }}</a>
                <a href="#policy">{{ $t('s015') }}</a>
                <a href="#fit">{{ $t('s016') }}</a>
                <a href="#faq">{{ $t('s017') }}</a>
            </div>
        </nav>

        
        <section class="landing__section landing__section--light" id="overview">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s018') }}</span>
                <h2 class="landing__head">{{ $t('s019') }}</h2>
                <p class="landing__lead">{{ $t('s020') }}</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s021') }}</h3>
                        <p>{{ $t('s022') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s023') }}</h3>
                        <p>{{ $t('s024') }}</p>
                    </article>
                </div>
                <div class="landing__callout">{{ $t('s025') }}</div>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment" id="problem">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s026') }}</span>
                <h2 class="landing__head">{{ $t('s027') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s028') }}</h3>
                        <p>{{ $t('s029') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s030') }}</h3>
                        <p>{{ $t('s031') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s032') }}</h3>
                        <p>{{ $t('s033') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s034') }}</h3>
                        <p>{{ $t('s035') }}</p>
                    </article>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--dark has-orb" id="choose">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s036') }}</span>
                <h2 class="landing__head">{{ $t('s037') }}</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s038') }}</strong><span>{{ $t('s039') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s040') }}</strong><span>{{ $t('s041') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s042') }}</strong><span>{{ $t('s043') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s044') }}</strong><span>{{ $t('s045') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s046') }}</strong><span>{{ $t('s047') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s048') }}</strong><span>{{ $t('s049') }}</span></div>
                </div>
            </div>
        </section>

        
        
        <section class="landing__section landing__section--light" id="products">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s050') }}</span>
                <h2 class="landing__head">{{ $t('s051') }}</h2>
                <p class="landing__lead">{{ $t('s052') }}</p>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('solutions.boostingshop.sub', ['sub' => 'basic']) }}"><strong>{{ $t('s053') }}</strong><p>{{ $t('s054') }}</p><span>{{ $t('s055') }}</span></a>
                    <a class="subcard" href="{{ intl_route('solutions.boostingshop.sub', ['sub' => 'pro']) }}"><strong>{{ $t('s056') }}</strong><p>{{ $t('s057') }}</p><span>{{ $t('s058') }}</span></a>
                    <a class="subcard" href="{{ intl_route('solutions.boostingshop.sub', ['sub' => 'elite']) }}"><strong>{{ $t('s059') }}</strong><p>{{ $t('s060') }}</p><span>{{ $t('s061') }}</span></a>
                    <a class="subcard" href="{{ intl_route('solutions.boostingshop.sub', ['sub' => 'instagram-popular']) }}"><strong>{{ $t('s062') }}</strong><p>{{ $t('s063') }}</p><span>{{ $t('s064') }}</span></a>
                    <a class="subcard" href="{{ intl_route('solutions.boostingshop.sub', ['sub' => 'instagram-followers']) }}"><strong>{{ $t('s065') }}</strong><p>{{ $t('s066') }}</p><span>{{ $t('s067') }}</span></a>
                    <a class="subcard" href="{{ intl_route('solutions.boostingshop.sub', ['sub' => 'instagram-likes']) }}"><strong>{{ $t('s068') }}</strong><p>{{ $t('s069') }}</p><span>{{ $t('s070') }}</span></a>
                </div>
                <p class="landing__note">{{ $t('s071') }}</p>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment" id="process">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s072') }}</span>
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

        
        <section class="landing__section landing__section--dark has-orb" id="policy">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s084') }}</span>
                <h2 class="landing__head">{{ $t('s085') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s086') }}</h3>
                        <ul>
                            <li>{{ $t('s087') }}</li>
                            <li>{{ $t('s088') }}</li>
                            <li>{{ $t('s089') }}</li>
                            <li>{{ $t('s090') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s091') }}</h3>
                        <ul>
                            <li>{{ $t('s092') }}</li>
                            <li>{{ $t('s093') }}</li>
                            <li>{{ $t('s094') }}</li>
                            <li>{{ $t('s095') }}</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">{{ $t('s096') }}</p>
            </div>
        </section>

        
        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s097') }}</span>
                <h2 class="landing__head">{{ $t('s098') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s099') }}</h3>
                        <ul>
                            <li>{{ $t('s100') }}</li>
                            <li>{{ $t('s101') }}</li>
                            <li>{{ $t('s102') }}</li>
                            <li>{{ $t('s103') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s104') }}</h3>
                        <ul>
                            <li>{{ $t('s105') }}</li>
                            <li>{{ $t('s106') }}</li>
                            <li>{{ $t('s107') }}</li>
                            <li>{{ $t('s108') }}</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s109') }}</span>
                <h2 class="landing__head">{{ $t('s110') }}</h2>
                <div class="faq">
                    <details class="faq__item"><summary>{{ $t('s111') }}</summary><p>{{ $t('s112') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s113') }}</summary><p>{{ $t('s114') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s115') }}</summary><p>{{ $t('s116') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s117') }}</summary><p>{{ $t('s118') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s119') }}</summary><p>{{ $t('s120') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s121') }}</summary><p>{{ $t('s122') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s123') }}</summary><p>{{ $t('s124') }}</p></details>
                </div>
            </div>
        </section>

        
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">{{ $t('s125') }}</span>
                <h2>{{ $t('s126') }}<br>{{ $t('s127') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s128') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="#products">{{ $t('s129') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact') }}">{{ $t('s130') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection
