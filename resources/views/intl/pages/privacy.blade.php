@extends('layouts.intl-app')

@php($t = fn ($k) => __('pages/privacy.'.$k))

@section('title', $t('title'))
@section('meta')
    <meta name="description" content="{{ $t('description') }}">
@endsection

@section('content')
    <main class="legal">
        <article class="legal__content">
            <h1>{{ $t('heading') }}</h1>
            <p>{{ $t('translation_notice') }}</p>
            <p>{{ $t('introduction') }}</p>

            @foreach ($t('sections') as [$heading, $paragraph])
                <section>
                    <h2>{{ $heading }}</h2>
                    <p>{{ $paragraph }}</p>
                </section>
            @endforeach

            <p>{{ $t('closing') }}</p>
        </article>
    </main>
@endsection
