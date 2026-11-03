@extends('layouts.intl')
@php
    $t = fn ($key) => __('pages/insights.'.$key);
    $plain = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $translation->content)));
    $readingMinutes = max(1, (int) ceil(mb_strlen($plain) / 500));
    $related = ($related ?? collect())->filter(fn ($item) => $item->translation !== null);
@endphp
@section('title', ($translation->meta_title ?: $translation->title).' | J-Curve Interactive')
@section('meta')
    @if ($translation->meta_description ?: $translation->excerpt)
        <meta name="description" content="{{ Str::limit(strip_tags($translation->meta_description ?: $translation->excerpt), 155) }}">
    @endif
@endsection
@section('content')
    <article>
        <div class="jc-wrap" style="padding-top:clamp(40px,5vw,72px);padding-bottom:48px">
            <div class="jc-article-grid">
                <div class="jc-article-spacer" aria-hidden="true"></div>
                <header>
                    <nav class="jc-crumb" aria-label="{{ $t('breadcrumb') }}" style="margin-bottom:24px">
                        <a href="{{ intl_route('home') }}">{{ $t('home') }}</a><span aria-hidden="true">/</span>
                        <a href="{{ intl_route('insights.index') }}">{{ $t('heading') }}</a>
                        @if ($insight->category)
                            <span aria-hidden="true">/</span><a href="{{ intl_route('insights.category', ['slug' => $insight->category->slug]) }}">{{ __('insights.categories.'.$insight->category->slug) }}</a>
                        @endif
                    </nav>
                    <h1 class="jc-display" style="font-size:clamp(34px,3.9vw,56px);line-height:1.18;letter-spacing:-0.045em;text-wrap:balance">{{ $translation->title }}</h1>
                    <div class="jc-article-meta">
                        @if ($insight->published_at)
                            <span>{{ $t('published') }} <time datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format($t('date_format')) }}</time></span>
                        @endif
                        <span>{{ __('pages/insights.reading', ['minutes' => $readingMinutes]) }}</span>
                    </div>
                </header>
            </div>
        </div>
        <div class="jc-wrap">
            <div class="jc-article-grid">
                <nav class="jc-toc" aria-label="{{ $t('toc') }}" data-jc-toc>
                    <span class="jc-toc__title">{{ $t('toc') }}</span><ol></ol>
                </nav>
                <div>
                    {{-- Trusted first-party HTML loaded by IntlInsightSeeder. --}}
                    <div class="jc-prose" data-jc-prose>{!! $translation->content !!}</div>
                    <div class="jc-article-foot">
                        @if ($insight->category)
                            <div class="jc-article-foot__tags">
                                <span style="font-size:14px;font-weight:700;margin-right:8px">{{ $t('category') }}</span>
                                <a class="jc-tag" href="{{ intl_route('insights.category', ['slug' => $insight->category->slug]) }}">{{ __('insights.categories.'.$insight->category->slug) }}</a>
                            </div>
                        @endif
                        @if ($insight->source_url)
                            <div class="jc-small">{{ $t('source') }}: {{ preg_replace_callback('/[^\x00-\x7F]/u', fn ($m) => rawurlencode($m[0]), $insight->source_url) }}</div>
                        @endif
                    </div>
                    <p style="margin-top:24px"><a class="jc-link" href="{{ intl_route('insights.index') }}">← {{ $t('back') }}</a></p>
                    <aside class="jc-aside-cta" aria-label="{{ $t('related_services') }}">
                        <div style="max-width:420px">
                            <strong class="jc-display" style="font-size:22px;letter-spacing:-0.03em">{{ $t('cta_heading') }}</strong>
                            <p style="margin-top:8px;font-size:15px;line-height:1.6;color:var(--jc-body)">{{ $t('cta_lead') }}</p>
                        </div>
                        <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ intl_route('contact') }}">{{ $t('cta') }}</a>
                    </aside>
                </div>
            </div>
        </div>
    </article>
    <section class="jc-section" aria-labelledby="in-related">
        <div class="jc-wrap">
            <div class="jc-article-grid">
                <div class="jc-article-spacer" aria-hidden="true"></div>
                <div class="jc-related">
                    @if ($related->isNotEmpty())
                        <h2 id="in-related" class="jc-display">{{ $t('related') }}</h2>
                        @foreach ($related as $item)
                            <a class="jc-related__item" href="{{ intl_route('insights.show', ['slug' => $item->translation->slug]) }}"><span class="jc-post__date">{{ $item->published_at?->format($t('date_format')) }}</span><span style="font-size:18px;line-height:1.45;font-weight:600">{{ $item->translation->title }}</span></a>
                        @endforeach
                    @else
                        <h2 id="in-related" class="jc-display">{{ $t('other') }}</h2>
                    @endif
                    <a class="jc-link" style="display:inline-block;margin-top:20px" href="{{ intl_route('insights.index') }}">{{ $t('all_link') }}</a>
                </div>
            </div>
        </div>
    </section>
@endsection
