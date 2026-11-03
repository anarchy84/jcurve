@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/solutions-index.'.$key);
    $lines = fn (array|string $value) => implode('<br>', array_map('e', (array) $value));
@endphp

@section('title', $t('title'))
@section('meta')
    <meta name="description" content="{{ $t('description') }}">
@endsection

@section('content')
    <main class="landing">
        
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">{{ $t('s002') }}</span>
                <h1>{{ $t('s003') }}</h1>
                <p class="landing__lead">{{ $t('s004') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="#products">{{ $t('s005') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact') }}">{{ $t('s006') }}</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s001') }}">
            <div class="landing__local-nav-inner">
                <a href="#overview">{{ $t('s007') }}</a>
                <a href="#problems">{{ $t('s008') }}</a>
                <a href="#products">{{ $t('s009') }}</a>
                <a href="#workflow">{{ $t('s010') }}</a>
                <a href="#scope">{{ $t('s011') }}</a>
                <a href="#fit">{{ $t('s012') }}</a>
                <a href="#faq">{{ $t('s013') }}</a>
            </div>
        </nav>

        
        <section class="landing__section landing__section--light" id="overview">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s014') }}</span>
                <h2 class="landing__head">{{ $t('s015') }}</h2>
                <p class="landing__lead">{{ $t('s016') }}</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s017') }}</h3>
                        <p>{{ $t('s018') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s019') }}</h3>
                        <p>{{ $t('s020') }}</p>
                    </article>
                </div>
                <div class="landing__callout">{{ $t('s021') }}</div>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment" id="problems">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s022') }}</span>
                <h2 class="landing__head">{{ $t('s023') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s024') }}</h3>
                        <p>{{ $t('s025') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s026') }}</h3>
                        <p>{{ $t('s027') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s028') }}</h3>
                        <p>{{ $t('s029') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s030') }}</h3>
                        <p>{{ $t('s031') }}</p>
                    </article>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--dark has-orb" id="products">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s032') }}</span>
                <h2 class="landing__head">{{ $t('s033') }}</h2>
                <p class="landing__lead">{{ $t('s034') }}</p>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('solutions.rankfree') }}">
                        <strong>{{ $t('s035') }}</strong>
                        <p>{{ $t('s036') }}</p>
                        <span>{{ $t('s037') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('solutions.boostingshop') }}">
                        <strong>{{ $t('s038') }}</strong>
                        <p>{{ $t('s039') }}</p>
                        <span>{{ $t('s040') }}</span>
                    </a>
                    
                    <a class="subcard" href="{{ intl_route('solutions.shopitrend') }}">
                        <strong>{{ $t('s041') }}</strong>
                        <p>{{ $t('s042') }}</p>
                        <span>{{ $t('s043') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('self-marketing') }}">
                        <strong>{{ $t('s044') }}</strong>
                        <p>{{ $t('s045') }}</p>
                        <span>{{ $t('s046') }}</span>
                    </a>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s047') }}</span>
                <h2 class="landing__head">{{ $t('s048') }}</h2>
                <p class="landing__lead">{{ $t('s049') }}</p>
                <div class="subcards">
                    <a class="subcard" href="{{ intl_route('solutions.leadbay') }}">
                        <strong>{{ $t('s050') }}</strong>
                        <p>{{ $t('s051') }}</p>
                        <span>{{ $t('s052') }}</span>
                    </a>
                    <a class="subcard" href="{{ intl_route('solutions.call2sale') }}">
                        <strong>{{ $t('s053') }}</strong>
                        <p>{{ $t('s054') }}</p>
                        <span>{{ $t('s055') }}</span>
                    </a>
                </div>
                <p class="landing__note">{{ $t('s056') }}</p>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment" id="workflow">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s057') }}</span>
                <h2 class="landing__head">{{ $t('s058') }}</h2>
                <div class="steps">
                    <div class="steps__item"><strong>{{ $t('s059') }}</strong><p>{{ $t('s060') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s061') }}</strong><p>{{ $t('s062') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s063') }}</strong><p>{{ $t('s064') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s065') }}</strong><p>{{ $t('s066') }}</p></div>
                    <div class="steps__item"><strong>{{ $t('s067') }}</strong><p>{{ $t('s068') }}</p></div>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--dark has-orb" id="scope">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s069') }}</span>
                <h2 class="landing__head">{{ $t('s070') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s071') }}</h3>
                        <ul>
                            <li>{{ $t('s072') }}</li>
                            <li>{{ $t('s073') }}</li>
                            <li>{{ $t('s074') }}</li>
                            <li>{{ $t('s075') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s076') }}</h3>
                        <ul>
                            <li>{{ $t('s077') }}</li>
                            <li>{{ $t('s078') }}</li>
                            <li>{{ $t('s079') }}</li>
                            <li>{{ $t('s080') }}</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">{{ $t('s081') }}</p>
            </div>
        </section>

        
        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s082') }}</span>
                <h2 class="landing__head">{{ $t('s083') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s084') }}</h3>
                        <ul>
                            <li>{{ $t('s085') }}</li>
                            <li>{{ $t('s086') }}</li>
                            <li>{{ $t('s087') }}</li>
                            <li>{{ $t('s088') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s089') }}</h3>
                        <ul>
                            <li>{{ $t('s090') }}</li>
                            <li>{{ $t('s091') }}</li>
                            <li>{{ $t('s092') }}</li>
                            <li>{{ $t('s093') }}</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s094') }}</span>
                <h2 class="landing__head">{{ $t('s095') }}</h2>
                <div class="faq">
                    <details class="faq__item"><summary>{{ $t('s096') }}</summary><p>{{ $t('s097') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s098') }}</summary><p>{{ $t('s099') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s100') }}</summary><p>{{ $t('s101') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s102') }}</summary><p>{{ $t('s103') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s104') }}</summary><p>{{ $t('s105') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s106') }}</summary><p>{{ $t('s107') }}</p></details>
                </div>
            </div>
        </section>

        
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">{{ $t('s108') }}</span>
                <h2>{{ $t('s109') }}<br>{{ $t('s110') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s111') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('s112') }}</a>
                    <a class="btn-ghost" href="#products">{{ $t('s113') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection
