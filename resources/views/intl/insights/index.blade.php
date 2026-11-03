@extends('layouts.intl-app')
@php($t = fn ($key) => __('pages/insights.'.$key))
@section('title', $t('title'))
@section('meta')
    <meta name="description" content="{{ $t('description') }}">
@endsection
@section('content')
    <main class="listing">
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Insights</span>
                <h1>{{ $t('heading') }}</h1>
                <p class="landing__lead">{{ $t('lead') }}</p>
                @include('intl.insights.partials.tabs', ['activeSlug' => null])
            </div>
        </section>
        @include('intl.insights.partials.cards')
    </main>
@endsection
