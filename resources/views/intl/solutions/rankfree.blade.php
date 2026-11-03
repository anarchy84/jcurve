@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/rankfree.'.$key);
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
                    <a class="btn-primary" href="https://rankfree.kr" target="_blank" rel="noopener">{{ $t('s007') }}</a>
                    <a class="btn-ghost" href="#limits">{{ $t('s008') }}</a>
                </div>
                <p class="landing__body" style="margin-top:20px;color:var(--text-muted);">{{ $t('s009') }}</p>
                <p class="landing__note">{{ $t('s010') }}</p>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'rankfree'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s002') }}">
            <div class="landing__local-nav-inner">
                <a href="#overview">{{ $t('s011') }}</a>
                <a href="#problem">{{ $t('s012') }}</a>
                <a href="#features">{{ $t('s013') }}</a>
                <a href="#workflow">{{ $t('s014') }}</a>
                <a href="#limits">{{ $t('s015') }}</a>
                <a href="#pricing">{{ $t('s016') }}</a>
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
                    <div class="landing__point">
                        <strong>{{ $t('s039') }}</strong>
                        <p>{{ $t('s040') }}</p>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s041') }}</strong>
                        <p>{{ $t('s042') }}</p>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s043') }}</strong>
                        <p>{{ $t('s044') }}</p>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s045') }}</strong>
                        <p>{{ $t('s046') }}</p>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s047') }}</strong>
                        <p>{{ $t('s048') }}</p>
                    </div>
                    <div class="landing__point">
                        <strong>{{ $t('s049') }}</strong>
                        <p>{{ $t('s050') }}</p>
                    </div>
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

        
        <section class="landing__section landing__section--parchment" id="limits">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s064') }}</span>
                <h2 class="landing__head">{{ $t('s065') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s066') }}</h3>
                        <p>{{ $t('s067') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s068') }}</h3>
                        <p>{{ $t('s069') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s070') }}</h3>
                        <p>{{ $t('s071') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s072') }}</h3>
                        <p>{{ $t('s073') }}</p>
                    </article>
                </div>
                <div class="landing__callout">{{ $t('s074') }}</div>
            </div>
        </section>

        
        <section class="landing__section landing__section--dark has-orb" id="pricing">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s075') }}</span>
                <h2 class="landing__head">{{ $t('s076') }}</h2>
                <ul class="landing__evidence">
                    <li><strong>{{ $t('s077') }}</strong> {{ $t('s078') }}</li>
                    <li><strong>{{ $t('s079') }}</strong> {{ $t('s080') }}</li>
                    <li><strong>{{ $t('s081') }}</strong> {{ $t('s082') }}</li>
                </ul>
                <p class="landing__note">{{ $t('s083') }}</p>
                <p class="landing__note">{{ $t('s084') }}</p>
            </div>
        </section>

        
        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s085') }}</span>
                <h2 class="landing__head">{{ $t('s086') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s087') }}</h3>
                        <ul>
                            <li>{{ $t('s088') }}</li>
                            <li>{{ $t('s089') }}</li>
                            <li>{{ $t('s090') }}</li>
                            <li>{{ $t('s091') }}</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s092') }}</h3>
                        <ul>
                            <li>{{ $t('s093') }}</li>
                            <li>{{ $t('s094') }}</li>
                            <li>{{ $t('s095') }}</li>
                            <li>{{ $t('s096') }}</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        
        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s097') }}</span>
                <h2 class="landing__head">{{ $t('s098') }}</h2>
                <div class="faq">
                    <details class="faq__item"><summary>{{ $t('s099') }}</summary><p>{{ $t('s100') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s101') }}</summary><p>{{ $t('s102') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s103') }}</summary><p>{{ $t('s104') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s105') }}</summary><p>{{ $t('s106') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s107') }}</summary><p>{{ $t('s108') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s109') }}</summary><p>{{ $t('s110') }}</p></details>
                    <details class="faq__item"><summary>{{ $t('s111') }}</summary><p>{{ $t('s112') }}</p></details>
                </div>
            </div>
        </section>

        
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">{{ $t('s113') }}</span>
                <h2>{{ $t('s114') }}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('s115') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://rankfree.kr" target="_blank" rel="noopener">{{ $t('s116') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('services.show', ['slug' => 'seo']) }}">{{ $t('s117') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection
