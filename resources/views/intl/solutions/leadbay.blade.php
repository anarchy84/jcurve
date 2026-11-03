@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/leadbay.'.$key);
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
                    <a class="btn-primary" href="https://leadbay.co.kr" target="_blank" rel="noopener">{{ $t('s007') }}</a>
                    <a class="btn-ghost" href="#compliance">{{ $t('s008') }}</a>
                </div>
                <p class="landing__note">{{ $t('s009') }}</p>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'leadbay'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s002') }}">
            <div class="landing__local-nav-inner">
                <a href="#overview">{{ $t('s010') }}</a>
                <a href="#problem">{{ $t('s011') }}</a>
                <a href="#features">{{ $t('s012') }}</a>
                <a href="#workflow">{{ $t('s013') }}</a>
                <a href="#onboarding">{{ $t('s014') }}</a>
                <a href="#compliance">{{ $t('s015') }}</a>
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

        
        <section class="landing__section landing__section--dark has-orb" id="features">
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
                <p class="landing__note">{{ $t('s050') }}</p>
            </div>
        </section>

        
        <section class="landing__section landing__section--light" id="workflow">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s051') }}</span>
                <h2 class="landing__head">{{ $t('s052') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s053') }}</strong><p>{{ $t('s054') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s055') }}</strong><p>{{ $t('s056') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s057') }}</strong><p>{{ $t('s058') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s059') }}</strong><p>{{ $t('s060') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s061') }}</strong><p>{{ $t('s062') }}</p></div>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment" id="onboarding">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s063') }}</span>
                <h2 class="landing__head">{{ $t('s064') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s065') }}</strong><p>{{ $t('s066') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s067') }}</strong><p>{{ $t('s068') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s069') }}</strong><p>{{ $t('s070') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s071') }}</strong><p>{{ $t('s072') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s073') }}</strong><p>{{ $t('s074') }}</p></div>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--dark has-orb" id="compliance">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s075') }}</span>
                <h2 class="landing__head">{{ $t('s076') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s077') }}</h3>
                        <ul>
                            <li>{{ $t('s078') }}</li>
                            <li>{{ $t('s079') }}</li>
                            <li>{{ $t('s080') }}</li>
                            <li>{{ $t('s081') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s082') }}</h3>
                        <ul>
                            <li>{{ $t('s083') }}</li>
                            <li>{{ $t('s084') }}</li>
                            <li>{{ $t('s085') }}</li>
                            <li>{{ $t('s086') }}</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">{{ $t('s087') }}</p>
            </div>
        </section>

        
        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s088') }}</span>
                <h2 class="landing__head">{{ $t('s089') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s090') }}</h3>
                        <ul>
                            <li>{{ $t('s091') }}</li>
                            <li>{{ $t('s092') }}</li>
                            <li>{{ $t('s093') }}</li>
                            <li>{{ $t('s094') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s095') }}</h3>
                        <ul>
                            <li>{{ $t('s096') }}</li>
                            <li>{{ $t('s097') }}</li>
                            <li>{{ $t('s098') }}</li>
                            <li>{{ $t('s099') }}</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s100') }}</span>
                <h2 class="landing__head">{{ $t('s101') }}</h2>
                <p class="landing__lead">{{ $t('s102') }}</p>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('services.cpa.sub', ['sub' => 'insurance']) }}"><strong>{{ $t('s103') }}</strong><p>{{ $t('s104') }}</p><span>{{ $t('s105') }}</span></a>
                    <a class="subcard" href="{{ intl_route('solutions.call2sale') }}"><strong>{{ $t('s106') }}</strong><p>{{ $t('s107') }}</p><span>{{ $t('s108') }}</span></a>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--light" id="faq">
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
                <h2>{{ $t('s126') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s127') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://leadbay.co.kr" target="_blank" rel="noopener">{{ $t('s128') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact') }}">{{ $t('s129') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection
