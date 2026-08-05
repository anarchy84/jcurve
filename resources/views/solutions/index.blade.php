@extends('layouts.app')

@section('title', '자체 솔루션 4종 — 빌려 쓰지 않고 직접 만듭니다 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="현장에서 필요한 도구를 제이커브가 직접 개발해 운영합니다. 랭크프리·부스팅샵·리드베이·콜투세일 — 마케팅 데이터부터 보험 세일즈 CRM까지 네 개의 자체 솔루션.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Our Products</span>
                <h1>빌려 쓰지 않습니다. 직접 만듭니다.</h1>
                <p class="landing__lead">현장에서 필요한 도구를 제이커브가 직접 개발해 운영합니다.
                   마케팅 데이터부터 보험 세일즈 CRM까지, 네 개의 자체 솔루션.</p>
            </div>
        </section>

        {{-- 마케팅 데이터 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">마케팅 데이터</span>
                <h2 class="landing__head">순위와 시장을, 직접 본다</h2>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.rankfree') }}">
                        <strong>랭크프리 (RankFree)</strong>
                        <span>네이버 순위·시장 분석 — 무료로 시작 →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.boostingshop') }}">
                        <strong>부스팅샵 (BoostingShop)</strong>
                        <span>직접 돌리는 셀프 마케팅 →</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- 보험 세일즈 CRM [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">보험 세일즈 CRM</span>
                <h2 class="landing__head">보험DB 시장의 양면을 각각 잡습니다</h2>
                <p class="landing__lead">사는 쪽(영업조직)과 파는 쪽(콜센터), 두 흐름을 각각의 CRM으로.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.leadbay') }}">
                        <strong>리드베이 (LEADBAY)</strong>
                        <span>보험 영업조직을 위한 세일즈 CRM →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.call2sale') }}">
                        <strong>콜투세일 (Call2.Sale)</strong>
                        <span>보험DB 콜센터를 위한 납품·상담 CRM →</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- 최종 CTA [다크는 위와 연속 → 파치먼트 중앙] --}}
        <section class="landing__section landing__section--parchment landing__section--center">
            <div class="landing__inner">
                <h2 class="landing__head">도구까지 직접 만드는 팀과 일해보세요</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">프로젝트 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
