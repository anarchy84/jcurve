@extends('layouts.app')

@section('title', '제이커브인터렉티브 | 데이터로 증명하는 퍼포먼스 마케팅 에이전시')

@section('content')
    <main class="home">
        <section class="home__hero">
            <div class="home__hero-media" aria-hidden="true">
                {{-- 풀사이즈 히어로 동영상 슬롯: public/media/hero.mp4 + hero-poster.jpg 를 넣으면 자동 재생.
                     에셋 부착 전에는 니어블랙 폴백. prefers-reduced-motion 시 CSS로 숨김 처리. --}}
                <video class="home__hero-video" autoplay muted loop playsinline preload="metadata"
                       poster="{{ asset('media/hero-poster.jpg') }}">
                    <source src="{{ asset('media/hero.webm') }}" type="video/webm">
                    <source src="{{ asset('media/hero.mp4') }}" type="video/mp4">
                </video>
            </div>

            <div class="home__hero-inner">
                <span class="home__hero-badge">퍼포먼스 · CPA · SEO · 리워드 네트워크</span>
                <h1>데이터로 증명하는<br><span class="grad">퍼포먼스 마케팅</span></h1>
                <p>제이커브인터렉티브는 성과형 광고부터 검색·AI 최적화, 자체 데이터 솔루션까지 —
                   숫자로 말하는 종합 디지털 마케팅 에이전시입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">프로젝트 문의하기</a>
                    <a class="btn-ghost" href="{{ route('work.index') }}">성과 사례 보기</a>
                </div>
            </div>
        </section>

        <section class="home__stats" aria-label="핵심 성과 지표">
            <div class="stat"><strong>373억+</strong><span>누적 집행 광고비</span></div>
            <div class="stat"><strong>128만+</strong><span>누적 수집 DB</span></div>
            <div class="stat"><strong>15,700+</strong><span>진행 캠페인</span></div>
            <div class="stat"><strong>5.06만</strong><span>아나키 채널 구독자</span></div>
        </section>

        <section class="home__services" aria-labelledby="home-services-title">
            <h2 id="home-services-title">사업 영역</h2>
            <p class="section-sub">하나의 팀에서 유입부터 전환, 데이터 분석까지. 9개 전문 영역을 통합 운영합니다.</p>
            <nav aria-label="사업 영역 바로가기">
                <ul>
                    <li><a href="{{ route('services.show', ['slug' => 'performance-marketing']) }}">퍼포먼스 마케팅</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'cpa-marketing']) }}">CPA 마케팅</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'reward-network']) }}">리워드 네트워크</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'seo']) }}">SEO · AEO · GEO</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'wordpress']) }}">워드프레스 대행</a></li>
                    <li><a href="{{ route('solutions.rankfree') }}">랭크프리 — 데이터 솔루션</a></li>
                    <li><a href="{{ route('solutions.boostingshop') }}">부스팅샵 — 셀프 마케팅</a></li>
                    <li><a href="{{ route('company.anarchy') }}">아나키 — 유튜브 총괄</a></li>
                    <li><a href="{{ route('community.index') }}">마케터 커뮤니티</a></li>
                </ul>
            </nav>
        </section>
    </main>
@endsection
