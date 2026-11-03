{{--
    영어·일본어 공통 헤더 (Claude 구역, 2026-11-03 INTL) — 한국어 헤더(partials/jc/header)와 같은 디자인·같은 메뉴 순서.
    About us · Marketing services▾ · Self-serve marketing · Our platforms▾ · Results · Insights · Support▾ | KO·EN·JA · [Contact us]
    - 로그인·마이페이지·문의게시판은 외국어판이 없어 넣지 않는다(INTL-PLAN §2).
    - 메뉴 항목은 partials/intl/menu.php 한 곳에서 관리 (헤더·모바일·푸터 공용).
--}}
@php
    $intlMenu = require resource_path('views/partials/intl/menu.php');
    $intlPrefix = intl_locale();
    $intlIs = fn (string $pattern) => request()->is($intlPrefix.'/'.$pattern);
    $intlTop = [
        ['label' => __('menu.work'), 'href' => intl_route('work.index'), 'active' => $intlIs('work*')],
        ['label' => __('menu.insights'), 'href' => intl_route('insights.index'), 'active' => $intlIs('blog*') || $intlIs('insights*')],
    ];
@endphp
<a class="jc-skip" href="#main">{{ __('menu.skip') }}</a>
<header class="jc-header">
    <div class="jc-wrap jc-header__bar">
        <a class="jc-brand" href="{{ intl_route('home') }}" aria-label="{{ __('menu.home_aria') }}">
            <span class="jc-brand__name">{{ __('menu.brand_name') }}</span>
            <span class="jc-brand__sub">{{ __('menu.brand_sub') }}</span>
        </a>

        <nav class="jc-nav" aria-label="{{ __('menu.main_nav') }}">
            <a href="{{ intl_route('company') }}" @if ($intlIs('about-us*')) aria-current="page" @endif>{{ __('menu.company') }}</a>

            <div class="jc-nav__menu">
                <a class="jc-nav__trigger" href="{{ intl_route('services.index') }}" aria-haspopup="true" @if ($intlIs('services*')) aria-current="page" @endif>{{ __('menu.marketing') }}</a>
                <div class="jc-mega">
                    <div class="jc-wrap jc-mega__inner">
                        <div class="jc-mega__intro">
                            <strong>{{ __('menu.marketing') }}</strong>
                            <p>{{ __('menu.marketing_intro') }}</p>
                            <a href="{{ intl_route('services.index') }}">{{ __('menu.marketing_all') }}</a>
                        </div>
                        @foreach ($intlMenu['marketing'] as $group => $links)
                            <div class="jc-mega__col">
                                <span class="jc-mega__label">{{ $group }}</span>
                                @foreach ($links as $link)
                                    <a class="jc-mega__link" href="{{ $link['href'] }}"><x-jc.icon :name="$link['icon']" class="jc-mega__ico" />{{ $link['label'] }}</a>
                                    @if (! empty($link['children']))
                                        <div class="jc-mega__sub">
                                            @foreach ($link['children'] as $child)
                                                <a href="{{ $child['href'] }}">{{ $child['label'] }}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <a class="jc-nav__self" href="{{ $intlMenu['self']['href'] }}" @if ($intlIs('self-marketing*')) aria-current="page" @endif><span class="jc-nav__dot" aria-hidden="true"></span>{{ $intlMenu['self']['label'] }}</a>

            <div class="jc-nav__menu">
                <a class="jc-nav__trigger" href="{{ intl_route('solutions.index') }}" aria-haspopup="true" @if ($intlIs('solutions*')) aria-current="page" @endif>{{ __('menu.operations') }}</a>
                <div class="jc-mega">
                    <div class="jc-wrap jc-mega__inner">
                        <div class="jc-mega__intro">
                            <strong>{{ __('menu.operations') }}</strong>
                            <p>{{ __('menu.operations_intro') }}</p>
                            <a href="{{ intl_route('solutions.index') }}">{{ __('menu.operations_all') }}</a>
                        </div>
                        <div class="jc-mega__cards">
                            @foreach ($intlMenu['operations'] as $op)
                                <a class="jc-mega__card" href="{{ $op['href'] }}"><x-jc.icon :name="$op['icon']" class="jc-mega__cardico" /><span class="jc-mega__cardtxt"><strong>{{ $op['label'] }}</strong><span>{{ $op['desc'] }}</span></span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($intlTop as $item)
                <a href="{{ $item['href'] }}" @if ($item['active']) aria-current="page" @endif>{{ $item['label'] }}</a>
            @endforeach

            <div class="jc-nav__menu">
                <a class="jc-nav__trigger" href="{{ intl_route('support.faq') }}" aria-haspopup="true" @if ($intlIs('support*')) aria-current="page" @endif>{{ __('menu.support') }}</a>
                <div class="jc-mega">
                    <div class="jc-wrap jc-mega__inner">
                        <div class="jc-mega__intro">
                            <strong>{{ __('menu.support') }}</strong>
                            <p>{{ __('menu.support_intro') }}</p>
                            <a href="mailto:jcurve19@gmail.com">jcurve19@gmail.com</a>
                        </div>
                        <div class="jc-mega__cards">
                            @foreach ($intlMenu['support'] as $sp)
                                <a class="jc-mega__card" href="{{ $sp['href'] }}"><x-jc.icon :name="$sp['icon']" class="jc-mega__cardico" /><span class="jc-mega__cardtxt"><strong>{{ $sp['label'] }}</strong><span>{{ $sp['desc'] }}</span></span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="jc-header__aside">
            @include('partials.intl.switcher')
            <a class="jc-btn jc-btn--primary jc-btn--sm" href="{{ intl_route('contact') }}">{{ __('menu.contact') }}</a>
            <details class="jc-mnav">
                <summary aria-label="{{ __('menu.menu_open') }}">{{ __('menu.menu') }}</summary>
                <nav class="jc-mnav__panel" aria-label="{{ __('menu.mobile_nav') }}">
                    <a href="{{ intl_route('company') }}">{{ __('menu.company') }}</a>
                    <details class="jc-mnav__group">
                        <summary>{{ __('menu.marketing') }}</summary>
                        @foreach ($intlMenu['marketing'] as $group => $links)
                            <span class="jc-mnav__label">{{ $group }}</span>
                            @foreach ($links as $link)
                                <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
                                @foreach ($link['children'] ?? [] as $child)
                                    <a class="jc-mnav__child" href="{{ $child['href'] }}">{{ $child['label'] }}</a>
                                @endforeach
                            @endforeach
                        @endforeach
                        <a href="{{ intl_route('services.index') }}">{{ __('menu.marketing_all') }}</a>
                    </details>
                    <a class="jc-mnav__self" href="{{ $intlMenu['self']['href'] }}">{{ $intlMenu['self']['label'] }}</a>
                    <details class="jc-mnav__group">
                        <summary>{{ __('menu.operations') }}</summary>
                        @foreach ($intlMenu['operations'] as $op)
                            <a href="{{ $op['href'] }}">{{ $op['label'] }}</a>
                        @endforeach
                        <a href="{{ intl_route('solutions.index') }}">{{ __('menu.operations_all') }}</a>
                    </details>
                    @foreach ($intlTop as $item)
                        <a href="{{ $item['href'] }}" @if ($item['active']) aria-current="page" @endif>{{ $item['label'] }}</a>
                    @endforeach
                    <details class="jc-mnav__group">
                        <summary>{{ __('menu.support') }}</summary>
                        @foreach ($intlMenu['support'] as $sp)
                            <a href="{{ $sp['href'] }}">{{ $sp['label'] }}</a>
                        @endforeach
                    </details>
                    <a href="{{ intl_route('contact') }}">{{ __('menu.contact') }}</a>
                    @include('partials.intl.switcher', ['intlSwitcherClass' => 'jc-lang--mnav'])
                </nav>
            </details>
        </div>
    </div>
</header>
