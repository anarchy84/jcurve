@extends('layouts.intl-app')

@php
    $t = fn (string $key) => __('pages/shopitrend.'.$key);
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
                <nav class="subpage__breadcrumb" aria-label="{{ $t('s001') }}"><a href="{{ intl_route('solutions.index') }}">{{ $t('s003') }}</a></nav>
                <span class="landing__eyebrow">{{ $t('s004') }}</span>
                <h1>{{ $t('s005') }}<br>{{ $t('s006') }}</h1>
                <p class="landing__lead">{{ $t('s007') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://shopitrend.co" target="_blank" rel="noopener">{{ $t('s008') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact') }}">{{ $t('s009') }}</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="{{ $t('s002') }}">
            <div class="landing__local-nav-inner">
                <a href="#features">{{ $t('s010') }}</a>
                <a href="#channels">{{ $t('s011') }}</a>
                <a href="#fit">{{ $t('s012') }}</a>
                <a href="#notice">{{ $t('s013') }}</a>
            </div>
        </nav>

        <section class="landing__section landing__section--light" id="features">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s014') }}</span>
                <h2 class="landing__head">{{ $t('s015') }}</h2>
                <p class="landing__lead">{{ $t('s016') }}</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s017') }}</strong>
                        <span>{{ $t('s018') }}</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s019') }}</strong>
                        <span>{{ $t('s020') }}</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s021') }}</strong>
                        <span>{{ $t('s022') }}</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s023') }}</strong>
                        <span>{{ $t('s024') }}</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s025') }}</strong>
                        <span>{{ $t('s026') }}</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>{{ $t('s027') }}</strong>
                        <span>{{ $t('s028') }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark" id="channels">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s029') }}</span>
                <h2 class="landing__head">{{ $t('s030') }}</h2>
                <p class="landing__lead">{{ $t('s031') }}</p>
                <div class="landing__chips">
                    <span>{{ $t('s032') }}</span>
                    <span>{{ $t('s033') }}</span>
                    <span>{{ $t('s034') }}</span>
                    <span>{{ $t('s035') }}</span>
                    <span>{{ $t('s036') }}</span>
                    <span>{{ $t('s037') }}</span>
                    <span>{{ $t('s038') }}</span>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s039') }}</span>
                <h2 class="landing__head">{{ $t('s040') }}</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>{{ $t('s041') }}</h3>
                        <p>{{ $t('s042') }}</p>
                    </article>
                    <article class="landing__panel">
                        <h3>{{ $t('s043') }}</h3>
                        <p>{{ $t('s044') }}</p>
                    </article>
                </div>
                <p class="landing__body" style="margin-top:28px">{{ $t('s045') }} <a href="{{ intl_route('self-marketing') }}">{{ $t('s046') }}</a>{{ $t('s047') }} <a href="{{ intl_route('contact') }}">{{ $t('s048') }}</a>{{ $t('s049') }}</p>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="notice">
            <div class="landing__inner">
                <span class="landing__eyebrow">{{ $t('s050') }}</span>
                <h2 class="landing__head">{{ $t('s051') }}</h2>
                <ul class="landing__evidence">
                    <li>{{ $t('s052') }}</li>
                    <li>{{ $t('s053') }}</li>
                    <li>{{ $t('s054') }}</li>
                </ul>
            </div>
        </section>

        <section class="landing__cta">
            <div class="landing__cta-inner">
                <h2>{{ $t('s055') }}<br>{{ $t('s056') }}</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="https://shopitrend.co" target="_blank" rel="noopener">{{ $t('s057') }}</a>
                    <a class="btn-ghost" href="{{ intl_route('contact') }}">{{ $t('s058') }}</a>
                </div>
            </div>
        </section>
    </main>
@endsection
