@extends('layouts.intl')

@php
    $t = fn (string $key) => __('pages/self-marketing-place.'.$key);
    $lines = fn (array|string $value) => implode('<br>', array_map('e', (array) $value));
@endphp



@php
    $jcOrder = intl_route('contact', ['service_interest' => 'boostingshop']);
    $jcCases = [];
    $jcCasesSample = false;
    $jcFloatApps = ['eggfarm', 'cashpang', 'carrotcash', 'pigcash', 'stamptech', 'moneytree'];
    $jcFaq = $t('faqs');
@endphp

@section('title', $t('title'))
@section('meta')
    <meta name="description" content="{{ $t('description') }}">
@endsection
@section('footer_variant', 'jc-footer--white')

@section('content')
    
    <section class="jc-wrap jc-prod-hero" aria-labelledby="pl-title">
        <div class="jc-prod-hero__panel">
            <div class="jc-prod-hero__copy">
                <nav class="jc-crumb" aria-label="{{ $t('s001') }}"><a href="{{ intl_route('home') }}">{{ $t('s003') }}</a><span aria-hidden="true">/</span><a href="{{ intl_route('self-marketing') }}">{{ $t('s004') }}</a><span aria-hidden="true">/</span><span aria-current="page">{{ $t('s005') }}</span></nav>
                <h1 id="pl-title" class="jc-display">{{ $t('s006') }}</h1>
                <p class="jc-lead">{{ $t('s007') }}<br>{{ $t('s008') }}</p>
                <div class="jc-btns">
                    <a class="jc-btn jc-btn--primary" href="{{ $jcOrder }}"><x-jc.icon name="plus" />{{ $t('s009') }}</a>
                </div>
            </div>
            <div class="jc-prod-hero__art" aria-hidden="true">
                @foreach ($jcFloatApps as $i => $app)
                    <img class="jc-prod-hero__app jc-prod-hero__app--{{ $i + 1 }}" src="{{ asset("images/apps/{$app}.png") }}" alt="" width="120" height="120">
                @endforeach
                <span class="jc-prod-hero__pin"><x-jc.icon name="place" /></span>
            </div>
        </div>
    </section>

    
    <section class="jc-section jc-section--tight" aria-labelledby="pl-cases">
        <div class="jc-wrap">
            <h2 id="pl-cases" class="jc-display jc-h2 jc-center">{{ $t('s010') }}<br><span class="jc-blue">{{ $t('s011') }}</span> {{ $t('s012') }}</h2>
                <p class="jc-text jc-center" style="max-width:640px;margin:20px auto 0">{{ $t('s013') }}</p>

        </div>
    </section>

    
    <section class="jc-how" aria-labelledby="pl-how">
        <div class="jc-wrap">
            <h2 id="pl-how" class="jc-display jc-h2 jc-center">{{ $t('s014') }} <mark>{{ $t('s015') }}</mark>{{ $t('s016') }}</h2>
            <ol class="jc-how__steps">
                <li>
                    <span class="jc-how__no">1</span>
                    <p>{{ $t('s017') }}<br>{{ $t('s018') }}</p>
                    <figure class="jc-how__card"><img src="{{ asset('images/screens/eggfarm-1.jpg') }}" alt="{{ $t('s002') }}" width="390" height="845" loading="lazy"><figcaption>{{ $t('s019') }}</figcaption></figure>
                </li>
                <li>
                    <span class="jc-how__no">2</span>
                    <p>{{ $t('s020') }}<br>{{ $t('s021') }}</p>
                    <figure class="jc-how__card jc-how__card--mission">
                        <div class="jc-mission">
                            <strong>{{ $t('s022') }}</strong>
                            <ol><li>{{ $t('s023') }}</li><li>{{ $t('s024') }}</li><li>{{ $t('s025') }}</li><li>{{ $t('s026') }}</li></ol>
                        </div>
                        <figcaption>{{ $t('s027') }}</figcaption>
                    </figure>
                </li>
                <li>
                    <span class="jc-how__no">3</span>
                    <p>{{ $t('s028') }}<br>{{ $t('s029') }}</p>
                    <figure class="jc-how__card jc-how__card--chart">
                        <svg viewBox="0 0 300 200" aria-hidden="true"><defs><linearGradient id="pl-fill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#1E3AFF" stop-opacity=".25"/><stop offset="1" stop-color="#1E3AFF" stop-opacity="0"/></linearGradient></defs><g stroke="#E6E7EA"><line x1="20" y1="40" x2="290" y2="40"/><line x1="20" y1="90" x2="290" y2="90"/><line x1="20" y1="140" x2="290" y2="140"/></g><path d="M20 170 C 80 165 110 150 150 128 S 230 60 285 30 L 285 190 L 20 190 Z" fill="url(#pl-fill)"/><path class="jc-how__line" d="M20 170 C 80 165 110 150 150 128 S 230 60 285 30" fill="none" stroke="#1E3AFF" stroke-width="3" stroke-linecap="round" pathLength="1"/><circle cx="285" cy="30" r="6" fill="#1E3AFF"/></svg>
                        <figcaption>{{ $t('s030') }}</figcaption>
                    </figure>
                </li>
            </ol>
            <div class="jc-how__note">
                <strong>{{ $t('s031') }}</strong>
                <p>{{ $t('s032') }}</p>
            </div>
        </div>
    </section>

    
    <section class="jc-section" aria-labelledby="pl-steps">
        <div class="jc-wrap">
            <h2 id="pl-steps" class="jc-display jc-h2 jc-center">{{ $t('s033') }}</h2>
            <div class="jc-steprows">
                <div class="jc-steprow">
                    <div><span class="jc-steprow__no">{{ $t('s034') }}</span><h3 class="jc-display">{{ $t('s035') }}<br>{{ $t('s036') }}</h3><p>{{ $t('s037') }}</p></div>
                    <div class="jc-mock" aria-hidden="true">
                        <span class="jc-mock__h"><x-jc.icon name="flag" />{{ $t('s038') }}</span>
                        <span class="jc-mock__row is-on"><x-jc.icon name="users" />{{ $t('s039') }}<x-jc.icon name="check" /></span>
                        <span class="jc-mock__row"><x-jc.icon name="bookmark" />{{ $t('s040') }}</span>
                        <span class="jc-mock__row"><x-jc.icon name="route" />{{ $t('s041') }}</span>
                        <span class="jc-mock__row"><x-jc.icon name="layers" />{{ $t('s042') }}</span>
                    </div>
                </div>
                <div class="jc-steprow jc-steprow--rev">
                    <div><span class="jc-steprow__no">{{ $t('s043') }}</span><h3 class="jc-display">{{ $t('s044') }}<br>{{ $t('s045') }}</h3><p>{{ $t('s046') }}</p></div>
                    <div class="jc-mock" aria-hidden="true">
                        <span class="jc-mock__h"><x-jc.icon name="flag" />{{ $t('s047') }}</span>
                        <span class="jc-mock__input">{{ $t('s048') }}</span>
                        <span class="jc-mock__h"><x-jc.icon name="flag" />{{ $t('s049') }}</span>
                        <span class="jc-mock__stepper"><i>−</i><b>100<small>{{ $t('s050') }}</small></b><i>+</i></span>
                        <span class="jc-mock__guide"><em class="is-low">{{ $t('s051') }}</em><em class="is-mid">{{ $t('s052') }}</em><em class="is-high">{{ $t('s053') }}</em></span>
                    </div>
                </div>
                <div class="jc-steprow">
                    <div><span class="jc-steprow__no">{{ $t('s054') }}</span><h3 class="jc-display">{{ $t('s055') }}<br>{{ $t('s056') }}</h3><p>{{ $t('s057') }}</p></div>
                    <div class="jc-mock" aria-hidden="true">
                        <span class="jc-mock__h"><x-jc.icon name="calendar" />{{ $t('s058') }}</span>
                        <span class="jc-mock__days"><em class="is-on"><b>{{ $t('s059') }}</b>{{ $t('s060') }}</em><em>{{ $t('s061') }}</em><em>{{ $t('s062') }}</em></span>
                        <span class="jc-mock__btn">{{ $t('s063') }}</span>
                    </div>
                </div>
            </div>
            <div class="jc-btns jc-center-btns"><a class="jc-btn jc-btn--primary" href="{{ $jcOrder }}">{{ $t('s064') }}</a></div>
        </div>
    </section>

    
    
@php
    $jcPartner = fn (string $n, string $alt) => ['src' => asset("images/partners/logo-{$n}.png"), 'alt' => $alt, 'own' => false];
    $jcOwn = fn (string $file, string $name) => ['src' => asset("images/apps/{$file}.png"), 'alt' => $name.' ('.$t('partners.suffix').')', 'own' => true];
    $jcWall = [
        $jcPartner('01', $t('partner_names.01')), $jcPartner('18', $t('partner_names.18')), $jcOwn('eggfarm', $t('app_names.eggfarm')),
        $jcPartner('24', $t('partner_names.24')), $jcPartner('26', $t('partner_names.26')), $jcOwn('saimcash', $t('app_names.saimcash')),
        $jcPartner('02', $t('partner_names.02')), $jcPartner('04', $t('partner_names.04')), $jcOwn('carrotcash', $t('app_names.carrotcash')),
        $jcPartner('09', $t('partner_names.09')), $jcPartner('06', $t('partner_names.06')), $jcOwn('pigcash', $t('app_names.pigcash')),
        $jcPartner('19', $t('partner_names.19')), $jcPartner('23', $t('partner_names.23')), $jcOwn('moneytree', $t('app_names.moneytree')),
        $jcPartner('11', ''), $jcPartner('20', ''), $jcOwn('stamptech', $t('app_names.stamptech')),
        $jcPartner('05', ''),
        $jcPartner('25', $t('partner_names.25')), $jcPartner('21', ''), $jcOwn('cashpang', $t('app_names.cashpang')),
        $jcPartner('14', ''), $jcPartner('03', ''), $jcOwn('youngtech', $t('app_names.youngtech')),
        $jcPartner('07', ''), $jcPartner('08', ''), $jcOwn('moneycapsule', $t('app_names.moneycapsule')),
        $jcPartner('10', ''), $jcPartner('12', ''), $jcOwn('potatofarm', $t('app_names.potatofarm')),
        $jcPartner('13', ''), $jcPartner('15', ''), $jcOwn('eggmoney', $t('app_names.eggmoney')),
        $jcPartner('16', ''), $jcPartner('17', ''), $jcOwn('jelly', $t('app_names.jelly')),
        $jcPartner('22', ''),
    ];
    $jcPlain = $plain ?? false;
    $jcHeading = $heading ?? 'h2';
@endphp
<section class="jc-partners {{ $jcPlain ? 'jc-partners--plain' : '' }}" aria-label="{{ $t('partners.aria') }}">
    <div class="{{ $jcPlain ? '' : 'jc-wrap' }} jc-partners__inner">
        <div class="jc-networks">
            <{{ $jcHeading }} class="jc-networks__title">{{ $t('partners.networks') }}</{{ $jcHeading }}>
            <ul class="jc-networks__logos">
                <li><img src="{{ asset('images/networks/buzzvil.svg') }}" alt="{{ $t('partners.buzzvil') }}" width="113" height="34" style="height:34px"></li>
                <li><img src="{{ asset('images/networks/adpopcorn.png') }}" alt="{{ $t('partners.adpopcorn') }}" width="152" height="22" style="height:22px"></li>
                <li class="jc-networks__word jc-networks__word--latin">NBT</li>
                <li class="jc-networks__word">{{ $t('partners.okcashbag') }}</li>
            </ul>
        </div>
        <div>
            <div class="jc-media__head">
                <{{ $jcHeading }} class="jc-media__title">{{ $t('partners.media') }}</{{ $jcHeading }}>
                <span class="jc-media__legend"><span class="jc-dot" aria-hidden="true"></span>{{ $t('partners.own') }}</span>
            </div>
            
            <div class="jc-wall-marquee" aria-label="{{ $t('partners.wall_aria') }}">
                @foreach (array_chunk($jcWall, (int) ceil(count($jcWall) / 2)) as $r => $row)
                    <div class="jc-wall-marquee__row {{ $r === 1 ? 'jc-wall-marquee__row--reverse' : '' }}">
                        @foreach ([false, true] as $dup)
                            <ul class="jc-wall" @if ($dup) aria-hidden="true" data-dup @endif>
                                @foreach ($row as $app)
                                    <li>
                                        <img src="{{ $app['src'] }}" alt="{{ $dup ? '' : $app['alt'] }}" width="56" height="56" loading="lazy">
                                        @if ($app['own'])<span class="jc-wall__own" aria-hidden="true"></span>@endif
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <p class="jc-media__note">{{ $t('partners.note') }}</p>
        </div>
    </div>
</section>


    
    <section class="jc-section" aria-labelledby="pl-why">
        <div class="jc-wrap">
            <h2 id="pl-why" class="jc-display jc-h2 jc-center">{{ $t('s065') }}</h2>
            <div class="jc-benefits">
                <div><x-jc.icon name="self" class="jc-benefits__ico" /><h3>{{ $t('s066') }} <span class="jc-blue">{{ $t('s067') }}</span></h3><p>{{ $t('s068') }}</p></div>
                <div><x-jc.icon name="apps" class="jc-benefits__ico" /><h3>{{ $t('s069') }} <span class="jc-blue">{{ $t('s070') }}</span></h3><p>{{ $t('s071') }}</p></div>
                <div><x-jc.icon name="rankfree" class="jc-benefits__ico" /><h3>{{ $t('s072') }} <span class="jc-blue">{{ $t('s073') }}</span></h3><p>{{ $t('s074') }}</p></div>
                <div><x-jc.icon name="calendar" class="jc-benefits__ico" /><h3>{{ $t('s075') }} <span class="jc-blue">{{ $t('s076') }}</span></h3><p>{{ $t('s077') }}</p></div>
            </div>
        </div>
    </section>

    
    <section class="jc-section jc-bg-fog" aria-labelledby="pl-faq">
        <div class="jc-wrap jc-faq jc-faq--narrow">
            <span class="jc-label" style="color:var(--jc-blue)">{{ $t('s078') }}</span>
            <h2 id="pl-faq" class="jc-display jc-h2" style="margin-bottom:32px">{{ $t('s079') }}</h2>
            @foreach ($jcFaq as $i => $f)
                <details @if ($i === 0) open @endif><summary>{{ $f['q'] }}</summary><p>{{ $f['a'] }}</p></details>
            @endforeach
            <a class="jc-link" href="{{ intl_route('support.faq') }}#faq-self" style="display:inline-block;margin-top:24px">{{ $t('s080') }}</a>
        </div>
    </section>

    
    <section class="jc-bg-dark jc-section" aria-labelledby="pl-cta">
        <div class="jc-wrap jc-cta">
            <div>
                <h2 id="pl-cta" class="jc-display jc-h2">{{ $t('s081') }}</h2>
                <p class="jc-text jc-text--dark">{{ $t('s082') }}</p>
            </div>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ $jcOrder }}">{{ $t('s083') }}</a>
            </div>
        </div>
    </section>
@endsection
