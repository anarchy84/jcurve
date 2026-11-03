@extends('layouts.intl-app')
@php
    $t = fn ($key) => __('pages/insights.'.$key);
    $categoryName = __('insights.categories.'.$category->slug);
@endphp
@section('title', $categoryName.' | J-Curve Interactive')
@section('meta')
    <meta name="description" content="{{ __('pages/insights.category_lead', ['category' => $categoryName]) }}">
@endsection
@section('content')
    <main class="listing">
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Insights</span>
                <h1>{{ $categoryName }}</h1>
                <p class="landing__lead">{{ __('pages/insights.category_lead', ['category' => $categoryName]) }}</p>
                @include('intl.insights.partials.tabs', ['activeSlug' => $category->slug])
            </div>
        </section>
        @include('intl.insights.partials.cards')
    </main>
@endsection
