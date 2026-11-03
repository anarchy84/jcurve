@extends('layouts.intl-app')
@php
    $t = fn ($key) => __('pages/work.'.$key);
    $lines = fn ($key) => implode('<br>', array_map('e', $t($key)));
@endphp
@section('title', $t('title'))
@section('meta')
    <meta name="description" content="{{ $t('description') }}">
@endsection
@section('content')
    <main class="listing landing">
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Work & Evidence</span>
                <h1>{!! $lines('heading') !!}</h1>
                <p class="landing__lead">{{ $t('lead') }}</p>
                <div class="cta-row">
                    <a class="btn-primary" href="#cases">{{ $t('cases_link') }}</a>
                    <a class="btn-ghost" href="#principles">{{ $t('principles_link') }}</a>
                </div>
            </div>
        </section>
        <section class="home__stats has-orb" aria-label="{{ $t('stats_label') }}">
            <div class="home__stats-inner">
                @foreach ($t('stats') as [$value, $label])
                    <div class="stat glass-card"><strong>{{ $value }}</strong><span>{{ $label }}</span></div>
                @endforeach
            </div>
        </section>
        <section class="landing__section landing__section--light" id="principles">
            <div class="landing__inner">
                <span class="landing__eyebrow">How We Read Results</span>
                <h2 class="landing__head">{{ $t('principles_heading') }}</h2>
                <div class="landing__points">
                    @foreach ($t('principles') as [$heading, $body])
                        <div class="landing__point landing__point--light"><strong>{{ $heading }}</strong><span>{{ $body }}</span></div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Case Anatomy</span>
                <h2 class="landing__head">{{ $t('anatomy_heading') }}</h2>
                <div class="steps">
                    @foreach ($t('anatomy') as [$heading, $body])
                        <div class="steps__item"><strong>{{ $heading }}</strong><p>{{ $body }}</p></div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="listing__body" id="cases">
            <div style="max-width:var(--container);margin:0 auto;">
                <span class="landing__eyebrow">Published Cases</span>
                <h2 class="landing__head">{{ $t('cases_heading') }}</h2>
                <div class="listing__empty">
                    @if ($works->count())
                        <p class="landing__lead">{{ $t('untranslated') }}</p>
                    @else
                        <h3 class="landing__head" style="font-size:28px;">{{ $t('empty_heading') }}</h3>
                        <p class="landing__lead">{{ $t('empty_lead') }}</p>
                    @endif
                </div>
            </div>
        </section>
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Evidence Rules</span>
                <h2 class="landing__head">{{ $t('rules_heading') }}</h2>
                <div class="landing__points">
                    @foreach ($t('rules') as [$heading, $body])
                        <div class="landing__point"><strong>{{ $heading }}</strong><span>{{ $body }}</span></div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>{!! $lines('cta_heading') !!}</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">{{ $t('cta_lead') }}</p>
                <div class="cta-row"><a class="btn-primary" href="{{ intl_route('contact') }}">{{ $t('cta') }}</a></div>
            </div>
        </section>
    </main>
@endsection
