<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name', 'J-Curve Interactive'))</title>
        @yield('meta')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="site">
        <header class="site-header">
            <a class="site-header__brand" href="{{ route('home') }}">J-Curve Interactive</a>

            <nav class="site-nav" aria-label="주요 메뉴">
                <ul class="site-nav__list">
                    <li class="site-nav__item"><a href="{{ route('home') }}">홈</a></li>
                    <li class="site-nav__item">
                        <a href="{{ route('services.index') }}">서비스</a>
                        <ul class="site-nav__sublist">
                            <li><a href="{{ route('services.show', ['slug' => 'performance-marketing']) }}">퍼포먼스 마케팅</a></li>
                            <li><a href="{{ route('services.show', ['slug' => 'cpa-marketing']) }}">CPA 마케팅</a></li>
                            <li><a href="{{ route('services.show', ['slug' => 'reward-network']) }}">리워드 네트워크</a></li>
                            <li>
                                <a href="{{ route('services.show', ['slug' => 'seo']) }}">SEO</a>
                                <ul class="site-nav__sublist">
                                    <li><a href="{{ route('services.seo.aeo') }}">AEO</a></li>
                                    <li><a href="{{ route('services.seo.geo') }}">GEO</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('services.show', ['slug' => 'wordpress']) }}">워드프레스</a></li>
                        </ul>
                    </li>
                    <li class="site-nav__item">
                        <span>솔루션</span>
                        <ul class="site-nav__sublist">
                            <li><a href="{{ route('solutions.rankfree') }}">랭크프리</a></li>
                            <li><a href="{{ route('solutions.boostingshop') }}">부스팅샵</a></li>
                        </ul>
                    </li>
                    <li class="site-nav__item">
                        <a href="{{ route('company') }}">회사소개</a>
                        <ul class="site-nav__sublist">
                            <li><a href="{{ route('company.anarchy') }}">아나키</a></li>
                        </ul>
                    </li>
                    <li class="site-nav__item"><a href="{{ route('work.index') }}">포트폴리오</a></li>
                    <li class="site-nav__item"><a href="{{ route('insights.index') }}">인사이트</a></li>
                    <li class="site-nav__item"><a href="{{ route('community.index') }}">커뮤니티</a></li>
                    <li class="site-nav__item"><a href="{{ route('contact') }}">문의</a></li>
                </ul>

                <ul class="site-nav__account">
                    @auth
                        <li><a href="{{ route('dashboard') }}">마이페이지</a></li>
                        <li><a href="{{ route('profile.edit') }}">프로필</a></li>
                    @else
                        <li><a href="{{ route('login') }}">로그인</a></li>
                        <li><a href="{{ route('register') }}">회원가입</a></li>
                    @endauth
                </ul>
            </nav>
        </header>

        @isset($header)
            <section class="page-header">
                {{ $header }}
            </section>
        @endisset

        @hasSection('content')
            @yield('content')
        @else
            <main class="site-main">
                {{ $slot ?? '' }}
            </main>
        @endif

        <footer class="site-footer">
            <section class="site-footer__company" aria-label="회사 정보">
                <p><strong>(주)제이커브인터렉티브 / J-Curve Interactive</strong></p>
                <p>대표이사: 김태훈</p>
                <p>사업자등록번호: 753-88-01488</p>
                <address>서울특별시 금천구 가산디지털1로, 가산더블유센터 703호</address>
                <p>전화: 02-1668-2612</p>
                <p>이메일: jcurve19@gmail.com</p>
                <p>도메인: <a href="{{ url('/') }}">{{ url('/') }}</a></p>
            </section>
        </footer>

        @stack('scripts')
    </body>
</html>
