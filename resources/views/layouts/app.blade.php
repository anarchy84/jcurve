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
                        <a href="{{ route('solutions.index') }}">솔루션</a>
                        <ul class="site-nav__sublist">
                            <li><a href="{{ route('solutions.rankfree') }}">랭크프리</a></li>
                            <li><a href="{{ route('solutions.boostingshop') }}">부스팅샵</a></li>
                            <li><a href="{{ route('solutions.leadbay') }}">리드베이</a></li>
                            <li><a href="{{ route('solutions.call2sale') }}">콜투세일</a></li>
                        </ul>
                    </li>
                    <li class="site-nav__item"><a href="{{ route('company') }}">회사소개</a></li>
                    <li class="site-nav__item"><a href="{{ route('work.index') }}">성과</a></li>
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
            <div class="site-footer__grid">
                <nav class="site-footer__col" aria-label="서비스">
                    <h3>서비스</h3>
                    <ul>
                        <li><a href="{{ route('services.show', ['slug' => 'performance-marketing']) }}">퍼포먼스 마케팅</a></li>
                        <li><a href="{{ route('services.show', ['slug' => 'cpa-marketing']) }}">CPA 마케팅</a></li>
                        <li><a href="{{ route('services.show', ['slug' => 'reward-network']) }}">리워드 네트워크</a></li>
                        <li><a href="{{ route('services.show', ['slug' => 'seo']) }}">SEO · AEO · GEO</a></li>
                        <li><a href="{{ route('services.show', ['slug' => 'wordpress']) }}">워드프레스 대행</a></li>
                    </ul>
                </nav>
                <nav class="site-footer__col" aria-label="솔루션">
                    <h3>솔루션</h3>
                    <ul>
                        <li><a href="{{ route('solutions.rankfree') }}">랭크프리</a></li>
                        <li><a href="{{ route('solutions.boostingshop') }}">부스팅샵</a></li>
                        <li><a href="{{ route('solutions.leadbay') }}">리드베이</a></li>
                        <li><a href="{{ route('solutions.call2sale') }}">콜투세일</a></li>
                    </ul>
                </nav>
                <nav class="site-footer__col" aria-label="회사">
                    <h3>회사</h3>
                    <ul>
                        <li><a href="{{ route('company') }}">회사소개</a></li>
                        <li><a href="{{ route('company') }}#anarchy">아나키</a></li>
                        <li><a href="{{ route('work.index') }}">성과</a></li>
                        <li><a href="{{ route('insights.index') }}">인사이트</a></li>
                        <li><a href="{{ route('community.index') }}">커뮤니티</a></li>
                        <li><a href="{{ route('contact') }}">문의하기</a></li>
                    </ul>
                </nav>
                <div class="site-footer__col site-footer__newsletter">
                    <h3>뉴스레터</h3>
                    <p>현장에서 검증한 마케팅 인사이트를 이메일로 받아보세요.</p>
                    {{-- TODO(뉴스레터): 구독 처리 백엔드(라우트·저장·개인정보 동의 수집)는 별도 배치.
                         동작하는 구독 폼이 준비되기 전까지 인사이트 열람으로 유도. --}}
                    <a class="site-footer__newsletter-link" href="{{ route('insights.index') }}">인사이트 보러 가기 →</a>
                    <p class="site-footer__consent">구독 기능 제공 시 <a href="{{ route('privacy') }}">개인정보 수집·이용 동의</a>를 별도로 받습니다.</p>
                </div>
            </div>

            <div class="site-footer__company" aria-label="회사 정보">
                <p><strong>(주)제이커브인터렉티브 / J-Curve Interactive</strong> · 대표이사 김태훈 · 사업자등록번호 753-88-01488</p>
                <address>서울특별시 금천구 가산디지털1로, 가산더블유센터 703호 · 02-1668-2612 · jcurve19@gmail.com</address>
                <p class="site-footer__legal"><a href="{{ route('privacy') }}">개인정보처리방침</a> · © 2026 J-Curve Interactive Corporation.</p>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
