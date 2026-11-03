@extends('layouts.intl')

@php
    $t = fn (string $key) => __('pages/self-marketing.'.$key);
    $lines = fn (array|string $value) => implode('<br>', array_map('e', (array) $value));
@endphp



@section('title', $t('title'))
@section('meta')
    <meta name="description" content="{{ $t('description') }}">
@endsection
@push('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&display=swap">
@endpush

@php($selfFaqs = $t('faqs'))

@section('content')
    <section class="jc-wrap jc-page-hero jc-page-hero--self" aria-labelledby="sf-title">
        <div>
            <nav class="jc-crumb" aria-label="{{ $t('s001') }}"><a href="{{ intl_route('home') }}">{{ $t('s002') }}</a><span aria-hidden="true">/</span><span aria-current="page">{{ $t('s003') }}</span></nav>
            <h1 id="sf-title" class="jc-display jc-h1--page">{{ $t('s004') }}<br>{{ $t('s005') }}</h1>
            <p class="jc-lead">{{ $t('s006') }}</p>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ intl_route('contact', ['service_interest' => 'boostingshop']) }}">{{ $t('s007') }}</a>
                <a class="jc-btn jc-btn--line" href="#check">{{ $t('s008') }}</a>
            </div>
        </div>
        <div>
            <div class="jc-board">
                <div><span class="jc-board__up" aria-hidden="true">▲</span><span class="jc-num">{{ $t('s009') }}</span><span class="jc-board__label"><strong>{{ $t('s010') }}</strong><span>{{ $t('s011') }}</span></span></div>
                <div><span class="jc-board__up" aria-hidden="true">▲</span><span class="jc-num">{{ $t('s012') }}</span><span class="jc-board__label"><strong>{{ $t('s013') }}</strong><span>{{ $t('s014') }}</span></span></div>
                <div><span class="jc-board__up" aria-hidden="true">▲</span><span class="jc-num">1,200+</span><span class="jc-board__label"><strong>{{ $t('s015') }}</strong><span>{{ $t('s016') }}</span></span></div>
            </div>
            <p class="jc-small" style="margin-top:14px">{{ $t('s017') }}</p>
        </div>
    </section>

    <section id="check" class="jc-bg-dark" style="padding:48px 0 52px" aria-labelledby="sf-check">
        <div class="jc-wrap jc-check">
            <div>
                <h2 id="sf-check" class="jc-display" style="font-size:clamp(26px,2.6vw,34px);letter-spacing:-0.035em">{{ $t('s018') }}</h2>
                <p style="margin-top:10px;font-size:15px;line-height:1.6;color:var(--jc-on-dark-2)">{{ $t('s019') }}</p>
            </div>
            <a class="jc-btn jc-btn--primary" href="https://rankfree.kr" target="_blank" rel="noopener">{{ $t('rankfree_link') }}</a>
        </div>
    </section>

    <section id="campaigns" class="jc-section" aria-labelledby="sf-campaigns">
        <div class="jc-wrap">
            <div class="jc-head">
                <h2 id="sf-campaigns" class="jc-display jc-h2">{{ $t('s020') }}</h2>
                <p class="jc-text">{{ $t('s021') }}</p>
            </div>
            <div class="jc-three">
                <div>
                    <h3 class="jc-display">{{ $t('s022') }}</h3>
                    <p>{{ $t('s023') }}</p>
                    <dl class="jc-dl"><dt>{{ $t('s024') }}</dt><dd>{{ $t('s025') }}</dd><dt>{{ $t('s026') }}</dt><dd>{{ $t('s027') }}</dd></dl>
                    <div class="jc-btns"><a class="jc-btn jc-btn--primary jc-btn--sm" href="{{ intl_route('contact', ['service_interest' => 'boostingshop']) }}">{{ $t('s028') }}</a><a class="jc-link" href="{{ intl_route('self-marketing.place') }}">{{ $t('s029') }}</a></div>
                </div>
                <div>
                    <h3 class="jc-display">{{ $t('s030') }}</h3>
                    <p>{{ $t('s031') }}</p>
                    <dl class="jc-dl"><dt>{{ $t('s032') }}</dt><dd>{{ $t('s033') }}</dd><dt>{{ $t('s034') }}</dt><dd>{{ $t('s035') }}</dd></dl>
                    <div class="jc-btns"><a class="jc-btn jc-btn--primary jc-btn--sm" href="{{ intl_route('contact', ['service_interest' => 'boostingshop']) }}">{{ $t('s036') }}</a></div>
                </div>
                <div>
                    <h3 class="jc-display">{{ $t('s037') }}</h3>
                    <p>{{ $t('s038') }}</p>
                    <dl class="jc-dl"><dt>{{ $t('s039') }}</dt><dd><a href="{{ intl_route('contact', ['service_interest' => 'seo']) }}">{{ $t('s040') }}</a></dd><dt>{{ $t('s041') }}</dt><dd>{{ $t('s042') }}</dd></dl>
                    <a class="jc-link" href="{{ intl_route('solutions.boostingshop.sub', ['sub' => 'basic']) }}">{{ $t('s043') }}</a>
                </div>
            </div>
        </div>
    </section>


    
    <section id="order" class="jc-section jc-bg-fog" aria-labelledby="sf-order">
        <div class="jc-wrap">
            <div class="jc-head">
                <h2 id="sf-order" class="jc-display jc-h2">{{ $t('s044') }}</h2>
                <p class="jc-text">{{ $t('s045') }}</p>
            </div>
            <ol class="jc-order-steps">
                <li><span class="jc-num" aria-hidden="true">1</span><strong>{{ $t('s046') }}</strong><span>{{ $t('s047') }}</span></li>
                <li><span class="jc-num" aria-hidden="true">2</span><strong>{{ $t('s048') }}</strong><span>{{ $t('s049') }}</span></li>
                <li><span class="jc-num" aria-hidden="true">3</span><strong>{{ $t('s050') }}</strong><span>{{ $t('s051') }}</span></li>
                <li><span class="jc-num" aria-hidden="true">4</span><strong>{{ $t('s052') }}</strong><span>{{ $t('s053') }}</span></li>
            </ol>
            <div class="jc-btns" style="margin-top:32px"><a class="jc-btn jc-btn--primary" href="{{ intl_route('contact', ['service_interest' => 'boostingshop']) }}">{{ $t('s054') }}</a><a class="jc-btn jc-btn--line" href="{{ intl_route('self-marketing.place') }}">{{ $t('s055') }}</a></div>

            <div class="jc-order-start"><p>{{ $t('inquiry_only') }}</p><a class="jc-btn jc-btn--primary jc-btn--md" href="{{ intl_route('contact', ['service_interest' => 'boostingshop']) }}">{{ $t('consult') }}</a></div>
        </div>
    </section>

    <section class="jc-section jc-section--tight" aria-labelledby="sf-steps">
        <div class="jc-wrap">
            <h2 id="sf-steps" class="jc-display jc-h2" style="margin-bottom:48px">{{ $t('s056') }}</h2>
            <ol class="jc-bigsteps">
                <li><span class="jc-num" aria-hidden="true">1</span><strong>{{ $t('s057') }}</strong><span>{{ $t('s058') }}</span></li>
                <li><span class="jc-num" aria-hidden="true">2</span><strong>{{ $t('s059') }}</strong><span>{{ $t('s060') }}</span></li>
                <li><span class="jc-num" aria-hidden="true" style="color:var(--jc-up)">3</span><strong>{{ $t('s061') }}</strong><span>{{ $t('s062') }}</span></li>
            </ol>
        </div>
    </section>

    <section class="jc-section jc-bg-fog" aria-labelledby="sf-promise">
        <div class="jc-wrap">
            <h2 id="sf-promise" class="jc-display jc-h2" style="margin-bottom:40px">{{ $t('s063') }}</h2>
            <div class="jc-promise">
                <div><h3>{{ $t('s064') }}</h3><ul><li>{{ $t('s065') }}</li><li>{{ $t('s066') }}</li><li>{{ $t('s067') }}</li></ul></div>
                <div><h3>{{ $t('s068') }}</h3><ul><li>{{ $t('s069') }}</li><li>{{ $t('s070') }}</li><li>{{ $t('s071') }}</li></ul></div>
            </div>
        </div>
    </section>

    <section class="jc-section" aria-labelledby="sf-read">
        <div class="jc-wrap">
            <blockquote class="jc-display jc-quote" id="sf-read">{{ $t('s072') }}</blockquote>
            <div class="jc-read">
                <div><h3>{{ $t('s073') }}</h3><p>{{ $t('s074') }}</p></div>
                <div><h3>{{ $t('s075') }}</h3><p>{{ $t('s076') }}</p></div>
                <div><h3>{{ $t('s077') }}</h3><p>{{ $t('s078') }}</p></div>
                <div><h3>{{ $t('s079') }}</h3><p>{{ $t('s080') }}</p></div>
            </div>
        </div>
    </section>

    <section class="jc-section jc-section--tight" aria-labelledby="sf-plans">
        <div class="jc-wrap">
            <div class="jc-head" style="margin-bottom:32px">
                <h2 id="sf-plans" class="jc-display jc-h2">{{ $t('s081') }}</h2>
                <span class="jc-small" style="font-size:14px">{{ $t('s082') }}</span>
            </div>
            <div class="jc-plans">
                <div><span class="jc-plans__name">{{ $t('s083') }}</span><span class="jc-num">{{ $t('s084') }}</span><span class="jc-plans__desc">{{ $t('s085') }}</span><a class="jc-link" href="#check">{{ $t('s086') }}</a></div>
                <div><span class="jc-plans__name">{{ $t('s087') }}</span><span style="display:flex;align-items:baseline;gap:6px"><span class="jc-num">{{ $t('s088') }}</span><span class="jc-small" style="font-size:15px">{{ $t('s089') }}</span></span><span class="jc-plans__desc">{{ $t('s090') }}</span><a class="jc-link" href="https://rankfree.kr" rel="noopener">{{ $t('s091') }}</a></div>
                <div><span class="jc-plans__name">{{ $t('s092') }}</span><span class="jc-num">{{ $t('s093') }}</span><span class="jc-plans__desc">{{ $t('s094') }}</span><a class="jc-link" href="{{ intl_route('contact') }}">{{ $t('s095') }}</a></div>
            </div>
            <p class="jc-small" style="margin-top:16px">{{ $t('s096') }}</p>
        </div>
    </section>

    <section class="jc-section jc-section--tight" aria-labelledby="sf-faq">
        <div class="jc-wrap jc-faq">
            <h2 id="sf-faq" class="jc-display jc-h2" style="margin-bottom:32px">{{ $t('s097') }}</h2>
            @foreach ($selfFaqs as $i => [$q, $a])
                <details @if ($i === 0) open @endif><summary>{{ $q }}</summary><p>{{ $a }}</p></details>
            @endforeach
        </div>
    </section>

    <section class="jc-section jc-bg-dark" aria-labelledby="sf-start">
        <div class="jc-wrap jc-cta">
            <div>
                <h2 id="sf-start" class="jc-display jc-h2">{{ $t('s098') }}<br>{{ $t('s099') }}</h2>
                <p class="jc-text" style="color:var(--jc-on-dark-2)">{{ $t('s100') }}</p>
            </div>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--up" href="#check">{{ $t('s101') }}</a>
                <a class="jc-btn jc-btn--line-white" href="{{ intl_route('contact') }}">{{ $t('s102') }}</a>
            </div>
        </div>
    </section>
@endsection

@section('footer_variant', 'jc-footer--white')
