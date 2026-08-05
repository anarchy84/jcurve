@extends('layouts.app')

@section('title', '리드베이 — 보험DB, 사는 순간부터 계약까지 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="검증된 DB 업체를 품질 점수·납품 속도·AS 정책으로 비교 구매하고, 상담 배분에서 계약·정산까지 리드베이 하나로. 보험 영업 현장에서 나온 세일즈 CRM.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위"><a href="{{ route('solutions.index') }}">솔루션</a></nav>
                <span class="landing__eyebrow">LEADBAY</span>
                <h1>보험DB, 사는 순간부터 계약까지 한 흐름으로</h1>
                <p class="landing__lead">검증된 DB 업체를 품질 점수·납품 속도·AS 정책으로 비교해 구매하고,
                   상담 배분에서 계약·정산까지 리드베이 하나로 관리합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://leadbay.co.kr" target="_blank" rel="noopener">리드베이 바로가기 →</a>
                </div>
            </div>
        </section>

        {{-- 공감 서사 [라이트] --}}
        {{-- ⚠️ [Client Risk] 보험DB·개인정보 규제 영역. 실서비스 문구만 승계, 보장성 표현 금지 --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">영업조직이 매일 겪는 그 일들</h2>
                <div class="prose">
                    <p>DB는 샀는데 품질이 복불복이고, 상담 배분은 엑셀이고, AS 처리는 카톡으로 하고 계시죠.</p>
                    <p>리드베이는 그 흐름 전체를 하나의 CRM으로 옮긴 겁니다. 보험 영업 현장에서 나온 설계입니다.</p>
                </div>
            </div>
        </section>

        {{-- 방법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">DB를 사는 쪽을 위해</span>
                <h2 class="landing__head">사는 순간부터 계약까지, 새는 곳 없이</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>보험DB 마켓</strong><span>검증된 업체를 품질점수·납품속도·AS로 비교해 구매합니다.</span></div>
                    <div class="landing__point"><strong>상담 관리</strong><span>구입한 DB의 상담 배분·진행 상태를 추적합니다.</span></div>
                    <div class="landing__point"><strong>계약 · AS · 정산</strong><span>계약 체결부터 사후 관리까지 한 흐름으로.</span></div>
                    <div class="landing__point"><strong>대상</strong><span>보험 영업조직 · 설계사 · 대리점.</span></div>
                </div>
            </div>
        </section>

        {{-- 연결 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">원스톱 연결</span>
                <h2 class="landing__head">DB 유입부터 관리까지, 원스톱</h2>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'insurance']) }}"><strong>보험 CPA 마케팅</strong><span>DB 유입 설계 →</span></a>
                    <a class="subcard" href="{{ route('solutions.call2sale') }}"><strong>콜투세일 (파는 쪽)</strong><span>보험DB 콜센터 CRM →</span></a>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>보험 영업, DB부터 계약까지 한 흐름으로</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="https://leadbay.co.kr" target="_blank" rel="noopener">리드베이 바로가기 →</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">도입 상담</a>
                </div>
            </div>
        </section>
    </main>
@endsection
