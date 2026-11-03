@extends('layouts.intl')

{{--
    영어·일본어 홈 (Claude 구역, 2026-11-03 INTL) — 한국어 홈(pages/home)과 같은 디자인, 대상은 한국 진출 외국 기업.
    - 문구: lang/{en,ja}/pages/home.php. 숫자·사실은 한국어 홈 그대로(GLOSSARY §6), 한국어에만 맞는 문장은 뺐다.
    - 한국어 홈과 다른 점: 「내 순위 확인」 탭·무료 SEO 진단(한국어 전용 도구)·워드프레스 원문 구간(한국어 SEO 보존용) 없음,
      대신 「한국 플랫폼」 구간을 넣었다. 셀프마케팅 주문은 외국어판이 없어 소개 페이지로만 보낸다.
    - 컨트롤러 데이터: $insights(그 언어 번역이 있는 최신 글). 비어 있으면 구간을 숨긴다.
--}}

@php
    $L = intl_locale();
    $t = fn (string $key) => __('pages/home.'.$key);
    $to = function (string $name, array $params = [], string $hash = '') {
        if ($name === 'google-ads') {
            return config('subpages.performance.items.google-ads')
                ? intl_route('services.performance.sub', ['sub' => 'google-ads'])
                : intl_route('services.show', ['slug' => 'performance-marketing']).'#performance-channels';
        }
        if (str_starts_with($name, '#')) {
            return $name;
        }
        if ($name === 'reward') {
            return intl_route('services.show', ['slug' => 'reward-network']);
        }

        return intl_route($name, $params).$hash;
    };
    $intlMenu = require resource_path('views/partials/intl/menu.php');
    $subs = $t('subs');
@endphp

@section('title', __('pages/home.title'))
@section('meta')
    <meta name="description" content="{{ __('pages/home.description') }}">
@endsection

@section('content')
    {{-- ① 첫 화면 --}}
    <section class="jc-stage" aria-labelledby="home-title">
    @include('partials.jc.hero-curve')
    <div class="jc-wrap jc-hero jc-hero--stage">
        <div class="jc-hero__copy">
            <span class="jc-hero__badge">{{ $t('hero.badge') }}</span>
            <h1 id="home-title" class="jc-display jc-h1 jc-h1--home">{{ $t('hero.h1') }}<br><span class="jc-hero__brand">{{ $t('hero.brand') }}</span></h1>
            <p class="jc-lead">{{ $t('hero.lead') }}</p>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ intl_route('contact') }}">{{ $t('hero.cta_primary') }}</a>
                <a class="jc-btn jc-btn--line-white" href="{{ intl_route('services.index') }}">{{ $t('hero.cta_secondary') }}</a>
            </div>
        </div>
        <div class="jc-hx" data-jc-hx>
            <div class="jc-hx__tabs" role="tablist" aria-label="{{ $t('hero.tabs_label') }}">
                <button class="jc-hx__tab is-active" type="button" role="tab" id="hx-tab-1" aria-controls="hx-panel-1" aria-selected="true"><x-jc.icon name="performance" />{{ $t('hero.tab_numbers') }}<span class="jc-hx__bar"><i></i></span></button>
                <button class="jc-hx__tab" type="button" role="tab" id="hx-tab-2" aria-controls="hx-panel-2" aria-selected="false" tabindex="-1"><x-jc.icon name="arrow-right" />{{ $t('hero.tab_start') }}<span class="jc-hx__bar"><i></i></span></button>
            </div>
            <div class="jc-hx__stage" data-jc-hx-stage>
                <div class="jc-hx__panel is-active" role="tabpanel" id="hx-panel-1" aria-labelledby="hx-tab-1">
                    <div class="jc-hx__head">
                        <p class="jc-hx__title">{{ $t('hero.numbers_title') }}</p>
                        <span class="jc-hx__meta"><span class="jc-hx__live" aria-hidden="true"></span>{{ $t('hero.numbers_meta') }}</span>
                    </div>
                    <div class="jc-hx__chart">
                        <svg viewBox="0 0 500 340" aria-hidden="true" focusable="false">
                            <defs>
                                <linearGradient id="hx-fill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#4F68FF" stop-opacity=".34"/><stop offset="1" stop-color="#1E3AFF" stop-opacity="0"/></linearGradient>
                                <linearGradient id="hx-stroke" x1="0" y1="1" x2="1" y2="0"><stop offset="0" stop-color="#1E3AFF" stop-opacity=".5"/><stop offset=".6" stop-color="#4F68FF"/><stop offset="1" stop-color="#C9D2FF"/></linearGradient>
                                <filter id="hx-glow" x="-10%" y="-10%" width="120%" height="120%"><feGaussianBlur stdDeviation="6"/></filter>
                                <linearGradient id="hx-fade" x1="0" y1="0" x2="1" y2="0"><stop offset=".8" stop-color="#fff"/><stop offset=".97" stop-color="#fff" stop-opacity="0"/></linearGradient>
                                <mask id="hx-mask"><rect width="500" height="340" fill="url(#hx-fade)"/></mask>
                            </defs>
                            <g class="jc-hx__grid" stroke="#fff" stroke-opacity=".07">
                                <line x1="0" y1="85" x2="500" y2="85"/><line x1="0" y1="170" x2="500" y2="170"/><line x1="0" y1="255" x2="500" y2="255"/>
                            </g>
                            <path class="jc-hx__area" mask="url(#hx-mask)" d="M0 300 C 30 296 50 290 70 286 C 150 270 230 250 290 214 C 360 172 420 110 452 48 C 462 28 470 14 480 4 L 480 340 L 0 340 Z" fill="url(#hx-fill)"/>
                            <path class="jc-hx__glow" d="M0 300 C 30 296 50 290 70 286 C 150 270 230 250 290 214 C 360 172 420 110 452 48 C 462 28 470 14 480 4" fill="none" stroke="#3B55FF" stroke-width="9" filter="url(#hx-glow)" pathLength="1"/>
                            <path class="jc-hx__line" d="M0 300 C 30 296 50 290 70 286 C 150 270 230 250 290 214 C 360 172 420 110 452 48 C 462 28 470 14 480 4" fill="none" stroke="url(#hx-stroke)" stroke-width="2.5" stroke-linecap="round" pathLength="1"/>
                            <g class="jc-hx__dots">
                                <circle cx="70" cy="286" r="5"/><circle cx="290" cy="214" r="5"/><circle cx="452" cy="48" r="6"/>
                            </g>
                        </svg>
                        @foreach ($t('hero_proof') as $i => [$num, $label, $delay])
                            <div class="jc-hx__chip jc-hx__chip--{{ $i + 1 }}">
                                <strong class="jc-hx__num" data-jc-delay="{{ $delay }}">{{ $num }}</strong>
                                <small>{{ $label }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="jc-hx__panel" role="tabpanel" id="hx-panel-2" aria-labelledby="hx-tab-2">
                    <p class="jc-hx__title">{{ $t('hero.start_title') }}</p>
                    <ul class="jc-hx__doors">
                        @foreach ($t('doors') as [$icon, $kicker, $title, $desc, $route])
                            <li><a class="jc-hx__door" href="{{ intl_route($route) }}"><x-jc.icon :name="$icon" class="jc-hx__doorico" /><span><small>{{ $kicker }}</small><strong>{{ $title }}</strong><span>{{ $desc }}</span></span><x-jc.icon name="arrow-right" class="jc-hx__go" /></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </section>

    {{-- ② 한국 플랫폼 — 외국 기업이 모르는 한국 채널을 먼저 짚는다(외국어판에만 있는 구간) --}}
    <section class="jc-section" aria-labelledby="home-korea">
        <div class="jc-wrap">
            <span class="jc-label">{{ $t('korea.label') }}</span>
            <div class="jc-head">
                <h2 id="home-korea" class="jc-display jc-h2">{{ $t('korea.h2') }}</h2>
                <p class="jc-text">{{ $t('korea.text') }}</p>
            </div>
            <div class="jc-goals__grid jc-intl-platforms">
                @foreach ($t('korea.items') as [$icon, $name, $desc])
                    <div class="jc-goal">
                        <x-jc.icon :name="$icon" class="jc-goal__ico" />
                        <span class="jc-goal__title">{{ $name }}</span>
                        <span class="jc-goal__desc">{{ $desc }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ③ 매대 — 제이커브가 하는 모든 일 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="home-biz">
        <div class="jc-wrap">
            <div class="jc-head">
                <h2 id="home-biz" class="jc-display jc-h2">{{ $t('biz.h2') }}</h2>
                <p class="jc-text">{{ $t('biz.text') }}</p>
            </div>
            <div class="jc-biz" data-jc-biz>
                <div class="jc-biz__col jc-biz__col--mkt">
                    <span class="jc-biz__kicker"><x-jc.icon name="megaphone" />{{ $t('biz.kicker') }}</span>
                    <h3 class="jc-display">{{ $t('biz.col_title') }}</h3>
                    <ul class="jc-biz__ops jc-biz__mkt">
                        @foreach ($t('services') as $i => [$icon, $label, $short, $group, $headline, $desc, $route, $params, $subKey])
                            @php($href = intl_route($route, $params))
                            <li>
                                <a class="jc-biz__item" href="{{ $href }}" aria-expanded="false" aria-controls="biz-detail-{{ $i }}" data-jc-biz-item>
                                    <x-jc.icon :name="$icon" class="jc-biz__opico" /><strong>{{ $label }}</strong><span>{{ $short }}</span><x-jc.icon name="arrow-right" class="jc-biz__chev" />
                                </a>
                                <div class="jc-biz__detail" id="biz-detail-{{ $i }}">
                                    <div class="jc-biz__detailin"><div class="jc-biz__dbody">
                                        <span class="jc-biz__dkicker"><x-jc.icon :name="$icon" />{{ $group }} · {{ $label }}</span>
                                        <p class="jc-display jc-biz__dhead">{{ $headline }}</p>
                                        <p class="jc-biz__ddesc">{{ $desc }}</p>
                                        @if ($subKey && ! empty($subs[$subKey]))
                                            <ul class="jc-biz__dsubs">
                                                @foreach ($subs[$subKey] as $sub)<li><a href="{{ $to($sub[1], $sub[2] ?? [], $sub[3] ?? '') }}">{{ $sub[0] }}</a></li>@endforeach
                                            </ul>
                                        @endif
                                        <div class="jc-biz__dbtns">
                                            <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ $href }}">{{ $t('biz.more') }}</a>
                                            <a class="jc-btn jc-btn--line jc-btn--md" href="{{ intl_route('contact') }}">{{ $t('biz.consult') }}</a>
                                        </div>
                                        <button class="jc-biz__close" type="button" data-jc-biz-close aria-label="{{ $t('biz.close') }}"><span aria-hidden="true">×</span></button>
                                    </div></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <a class="jc-link" href="{{ intl_route('services.index') }}">{{ $t('biz.all') }}</a>
                </div>
                <div class="jc-biz__restclip" data-jc-biz-rest>
                    <div class="jc-biz__rest">
                        <div class="jc-biz__col jc-biz__col--self">
                            <span class="jc-biz__kicker"><x-jc.icon name="self" />{{ $t('biz.self_kicker') }}</span>
                            <h3 class="jc-display">{{ $t('biz.self_title') }}</h3>
                            <p>{{ $t('biz.self_text') }}</p>
                            <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ intl_route('self-marketing') }}">{{ $t('biz.self_cta') }}</a>
                        </div>
                        <div class="jc-biz__col">
                            <span class="jc-biz__kicker"><x-jc.icon name="store" />{{ $t('biz.ops_kicker') }}</span>
                            <h3 class="jc-display">{{ $t('biz.ops_title') }}</h3>
                            <ul class="jc-biz__ops">
                                @foreach ($intlMenu['operations'] as $op)
                                    <li><a href="{{ $op['href'] }}"><x-jc.icon :name="$op['icon']" class="jc-biz__opico" /><strong>{{ $op['label'] }}</strong><span>{{ $op['desc'] }}</span></a></li>
                                @endforeach
                            </ul>
                            <a class="jc-link" href="{{ intl_route('solutions.index') }}">{{ $t('biz.ops_all') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ④ 신뢰 --}}
    <section class="jc-wrap jc-trust" aria-labelledby="home-trust-title">
        <h2 id="home-trust-title" class="jc-trust__head">{{ $t('trust.h2') }}</h2>
        <ul class="jc-trust__list">@foreach ($t('trust.brands') as $brand)<li>{{ $brand }}</li>@endforeach</ul>
        <p class="jc-trust__proof">{{ $t('trust.proof') }}</p>
    </section>

    {{-- ⑤ 숫자 --}}
    <section id="home-stats" class="jc-section jc-bg-dark" aria-labelledby="home-stats-title">
        <div class="jc-wrap">
            <span class="jc-label jc-label--dark">{{ $t('stats.label') }}</span>
            <h2 id="home-stats-title" class="jc-display jc-h2">{{ $t('stats.h2') }}</h2>
            <p class="jc-text jc-text--dark">{{ $t('stats.text') }}</p>
            <div class="jc-stats jc-stats--home jc-stats--dark">
                @foreach ($t('stats.items') as [$num, $label, $note])
                    <div class="jc-stat"><span class="jc-stat__num">{{ $num }}</span><span class="jc-stat__label">{{ $label }}</span><span class="jc-stat__note">{{ $note }}</span></div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ⑥ 다섯 층 --}}
    <section class="jc-section jc-section--tight" aria-labelledby="home-layers">
        <div class="jc-wrap">
            <div class="jc-head">
                <h2 id="home-layers" class="jc-display jc-h2">{{ $t('layers.h2') }}</h2>
                <p class="jc-text">{{ $t('layers.text') }}</p>
            </div>
            <ol class="jc-layers">
                @foreach ($t('layers.items') as [$no, $name, $job, $ours, $cta, $route, $lico])
                    <li class="jc-layer">
                        <span class="jc-layer__name"><x-jc.icon :name="$lico" class="jc-layer__ico" /><span class="jc-layer__no">{{ $no }}</span><span class="jc-display jc-layer__title">{{ $name }}</span></span>
                        <span class="jc-layer__job">{{ $job }}</span>
                        <span class="jc-layer__ours">{{ $ours }}</span>
                        <a class="jc-link" href="{{ $to($route) }}">{{ $cta }}</a>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ⑦ 직접 만든 도구 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="home-solutions-title">
        <div class="jc-wrap">
            <span class="jc-label">{{ $t('products.label') }}</span>
            <div class="jc-head">
                <h2 id="home-solutions-title" class="jc-display jc-h2">{{ $t('products.h2') }}</h2>
                <p class="jc-text">{{ $t('products.text') }}</p>
            </div>
            <div class="jc-products">
                @foreach ($t('products.items') as [$name, $desc, $route, $ico])
                    <a class="jc-product" href="{{ intl_route($route) }}">
                        <x-jc.icon :name="$ico" class="jc-product__ico" />
                        <strong>{{ $name }}</strong>
                        <p>{{ $desc }}</p>
                        <span class="jc-product__go">{{ $t('products.more') }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ⑧ 운영 중인 앱 --}}
    <section id="apps" class="jc-section" aria-labelledby="home-apps">
        <div class="jc-wrap">
            <div class="jc-head">
                <div>
                    <h2 id="home-apps" class="jc-display jc-h2">{{ $t('apps.h2') }}</h2>
                    <p class="jc-text" style="margin-top:18px">{{ $t('apps.text') }}</p>
                </div>
                <div class="jc-apps__nav" data-jc-apps-nav>
                    <button type="button" data-dir="-1" aria-label="{{ $t('apps.prev') }}"><x-jc.icon name="arrow-right" class="jc-apps__prev" /></button>
                    <button type="button" data-dir="1" aria-label="{{ $t('apps.next') }}"><x-jc.icon name="arrow-right" /></button>
                </div>
            </div>
            <ul class="jc-apps" data-jc-apps>
                @foreach ($t('apps.items') as [$file, $name, $desc])
                    <li>
                        <img src="{{ asset("images/screens/{$file}.jpg") }}" alt="{{ __('pages/home.apps.alt', ['name' => $name]) }}" width="390" height="847" loading="lazy">
                        <span>
                            <span class="jc-apps__name">{{ $name }}</span><br>
                            <span class="jc-apps__desc">{{ $desc }}</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ⑨ 광고주 | 매체사 --}}
    <section class="jc-section jc-bg-fog" aria-label="{{ $t('split.aria') }}">
        <div class="jc-wrap jc-split">
            <div>
                <span class="jc-label">{{ $t('split.adv_label') }}</span>
                <h2 class="jc-display jc-split__title">{{ $t('split.adv_h2') }}</h2>
                <p>{{ $t('split.adv_text') }}</p>
                <ul class="jc-chips">@foreach ($t('split.adv_chips') as $chip)<li>{{ $chip }}</li>@endforeach</ul>
                <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ intl_route('services.show', ['slug' => 'reward-network']) }}#advertisers">{{ $t('split.adv_cta') }}</a>
            </div>
            <div>
                <span class="jc-label">{{ $t('split.pub_label') }}</span>
                <h2 class="jc-display jc-split__title">{{ $t('split.pub_h2') }}</h2>
                <p>{{ $t('split.pub_text') }}</p>
                <ul class="jc-chips">@foreach ($t('split.pub_chips') as $chip)<li>{{ $chip }}</li>@endforeach</ul>
                <a class="jc-btn jc-btn--line jc-btn--md" href="{{ intl_route('services.show', ['slug' => 'reward-network']) }}#publishers">{{ $t('split.pub_cta') }}</a>
            </div>
        </div>
    </section>

    {{-- ⑩ 인사이트 (그 언어 번역이 있는 글만) --}}
    @if (($insights ?? collect())->isNotEmpty())
        <section class="jc-section" aria-labelledby="home-insights-title">
            <div class="jc-wrap">
                <span class="jc-label">{{ $t('insights.label') }}</span>
                <div class="jc-head" style="margin-bottom:24px">
                    <div>
                        <h2 id="home-insights-title" class="jc-display jc-h2">{{ $t('insights.h2') }}</h2>
                        <p class="jc-text" style="margin-top:18px">{{ $t('insights.text') }}</p>
                    </div>
                    <a class="jc-link" href="{{ intl_route('insights.index') }}">{{ $t('insights.all') }}</a>
                </div>
                <div class="jc-posts">
                    @foreach ($insights as $insight)
                        @php($tr = $insight->translation)
                        @continue(! $tr)
                        <a class="jc-post jc-post--rich" href="{{ intl_route('insights.show', ['slug' => $tr->slug]) }}">
                            @if ($insight->published_at)
                                <time class="jc-post__date" datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format('Y.m.d') }}</time>
                            @endif
                            @php($catKey = 'insights.categories.'.($insight->category?->slug ?? ''))
                            @if ($insight->category && __($catKey) !== $catKey)
                                <span class="jc-post__cat">{{ __($catKey) }}</span>
                            @endif
                            <span class="jc-post__body">
                                <span class="jc-post__title">{{ $tr->title }}</span>
                                @if ($tr->excerpt)
                                    <span class="jc-post__excerpt">{{ $tr->excerpt }}</span>
                                @endif
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ⑪ 마지막 상담 --}}
    <section class="jc-bg-dark jc-section" aria-labelledby="home-cta-title">
        <div class="jc-wrap jc-cta">
            <div>
                <h2 id="home-cta-title" class="jc-display jc-h2">{{ $t('cta.h2') }}</h2>
                <p class="jc-text jc-text--dark">{{ $t('cta.text') }}</p>
                <p class="jc-contact jc-contact--dark"><span><x-jc.icon name="mail" />{{ $t('cta.email') }} <a href="mailto:jcurve19@gmail.com">jcurve19@gmail.com</a></span><span><x-jc.icon name="phone" />{{ $t('cta.phone') }} <a href="tel:0216682612">02-1668-2612</a></span></p>
            </div>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ intl_route('contact') }}">{{ $t('cta.primary') }}</a>
                <a class="jc-btn jc-btn--line-white" href="{{ intl_route('services.index') }}">{{ $t('cta.secondary') }}</a>
            </div>
        </div>
    </section>
@endsection
