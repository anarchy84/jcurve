@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/call2sale.'.$key);
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
                <h1>{{ $t('s005') }}<br>{{ $t('s006') }}</h1>
                <p class="landing__lead">{{ $t('s007') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://call2.sale" target="_blank" rel="noopener">{{ $t('s008') }}</a>
                    <a class="btn-ghost" href="#governance">{{ $t('s009') }}</a>
                </div>
                <p class="landing__note">{{ $t('s010') }}</p>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'call2sale'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s002') }}">
            <div class="landing__local-nav-inner">
                <a href="#overview">{{ $t('s011') }}</a>
                <a href="#problem">{{ $t('s012') }}</a>
                <a href="#features">{{ $t('s013') }}</a>
                <a href="#workflow">{{ $t('s014') }}</a>
                <a href="#onboarding">{{ $t('s015') }}</a>
                <a href="#governance">{{ $t('s016') }}</a>
                <a href="#fit">{{ $t('s017') }}</a>
                <a href="#faq">{{ $t('s018') }}</a>
            </div>
        </nav>

        
        <section class="landing__section landing__section--light" id="overview">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s019') }}</span>
                <h2 class="landing__head">{{ $t('s020') }}</h2>
                <p class="landing__lead">{{ $t('s021') }}</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s022') }}</h3>
                        <p>{{ $t('s023') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s024') }}</h3>
                        <p>{{ $t('s025') }}</p>
                    </article>
                </div>
                <div class="landing__callout">{{ $t('s026') }}</div>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment" id="problem">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s027') }}</span>
                <h2 class="landing__head">{{ $t('s028') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s029') }}</h3>
                        <p>{{ $t('s030') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s031') }}</h3>
                        <p>{{ $t('s032') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s033') }}</h3>
                        <p>{{ $t('s034') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s035') }}</h3>
                        <p>{{ $t('s036') }}</p>
                    </article>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--dark has-orb" id="features">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s037') }}</span>
                <h2 class="landing__head">{{ $t('s038') }}</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>{{ $t('s039') }}</strong><span>{{ $t('s040') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s041') }}</strong><span>{{ $t('s042') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s043') }}</strong><span>{{ $t('s044') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s045') }}</strong><span>{{ $t('s046') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s047') }}</strong><span>{{ $t('s048') }}</span></div>
                    <div class="landing__point"><strong>{{ $t('s049') }}</strong><span>{{ $t('s050') }}</span></div>
                </div>
                <p class="landing__note">{{ $t('s051') }}</p>
            </div>
        </section>

        
        <section class="landing__section landing__section--light" id="workflow">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s052') }}</span>
                <h2 class="landing__head">{{ $t('s053') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s054') }}</strong><p>{{ $t('s055') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s056') }}</strong><p>{{ $t('s057') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s058') }}</strong><p>{{ $t('s059') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s060') }}</strong><p>{{ $t('s061') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s062') }}</strong><p>{{ $t('s063') }}</p></div>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment" id="onboarding">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s064') }}</span>
                <h2 class="landing__head">{{ $t('s065') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s066') }}</strong><p>{{ $t('s067') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s068') }}</strong><p>{{ $t('s069') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s070') }}</strong><p>{{ $t('s071') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s072') }}</strong><p>{{ $t('s073') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s074') }}</strong><p>{{ $t('s075') }}</p></div>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--dark has-orb" id="governance">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s076') }}</span>
                <h2 class="landing__head">{{ $t('s077') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s078') }}</h3>
                        <ul>
                            <li>{{ $t('s079') }}</li>
                            <li>{{ $t('s080') }}</li>
                            <li>{{ $t('s081') }}</li>
                            <li>{{ $t('s082') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s083') }}</h3>
                        <ul>
                            <li>{{ $t('s084') }}</li>
                            <li>{{ $t('s085') }}</li>
                            <li>{{ $t('s086') }}</li>
                            <li>{{ $t('s087') }}</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">{{ $t('s088') }}</p>
            </div>
        </section>

        
        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s089') }}</span>
                <h2 class="landing__head">{{ $t('s090') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s091') }}</h3>
                        <ul>
                            <li>{{ $t('s092') }}</li>
                            <li>{{ $t('s093') }}</li>
                            <li>{{ $t('s094') }}</li>
                            <li>{{ $t('s095') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s096') }}</h3>
                        <ul>
                            <li>{{ $t('s097') }}</li>
                            <li>{{ $t('s098') }}</li>
                            <li>{{ $t('s099') }}</li>
                            <li>{{ $t('s100') }}</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s101') }}</span>
                <h2 class="landing__head">{{ $t('s102') }}</h2>
                <p class="landing__lead">{{ $t('s103') }}</p>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('solutions.leadbay') }}"><strong>{{ $t('s104') }}</strong><p>{{ $t('s105') }}</p><span>{{ $t('s106') }}</span></a>
                    <a class="subcard" href="{{ intl_route('services.cpa.sub', ['sub' => 'insurance']) }}"><strong>{{ $t('s107') }}</strong><p>{{ $t('s108') }}</p><span>{{ $t('s109') }}</span></a>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--light" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s110') }}</span>
                <h2 class="landing__head">{{ $t('s111') }}</h2>
                <div class="faq">
                    <details class="faq__item"><summary>{{ $t('s112') }}</summary><p>{{ $t('s113') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s114') }}</summary><p>{{ $t('s115') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s116') }}</summary><p>{{ $t('s117') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s118') }}</summary><p>{{ $t('s119') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s120') }}</summary><p>{{ $t('s121') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s122') }}</summary><p>{{ $t('s123') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s124') }}</summary><p>{{ $t('s125') }}</p></details>
                </div>
            </div>
        </section>

        
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">{{ $t('s126') }}</span>
                <h2>{{ $t('s127') }}<br>{{ $t('s128') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s129') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://call2.sale" target="_blank" rel="noopener">{{ $t('s130') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact') }}">{{ $t('s131') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection
