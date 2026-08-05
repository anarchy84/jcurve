@extends('layouts.app')

@section('title', '콜투세일 — DB를 만들어 파는 콜센터를 위한 CRM | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="원천 DB 관리, 상담원 배분, AI 콜 품질 분석, 수주·납품·AS·전자계약·정산까지. 보험DB를 생산·납품하는 콜센터 운영의 전 공정을 데이터로 바꾸는 세일즈 CRM.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위"><a href="{{ route('solutions.index') }}">솔루션</a></nav>
                <span class="landing__eyebrow">Call2.Sale</span>
                <h1>DB를 만들어 파는 콜센터를 위한 CRM</h1>
                <p class="landing__lead">원천 DB 관리, 상담원 배분, AI 콜 품질 분석,
                   수주·납품·AS·전자계약·정산 — 콜센터 운영의 전 공정입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://call2.sale" target="_blank" rel="noopener">콜투세일 바로가기 →</a>
                </div>
            </div>
        </section>

        {{-- 공감 서사 [라이트] --}}
        {{-- ⚠️ [Client Risk] 보험DB 규제 영역. 실서비스 문구만 승계, 보장성 표현 금지 --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">납품처는 늘었는데 관리가 안 될 때</h2>
                <div class="prose">
                    <p>상담 품질은 감으로 평가하고, 정산은 월말마다 전쟁이고.</p>
                    <p>콜투세일은 그 공정을 데이터로 바꿉니다. AI가 콜 품질을 읽고, 정산은 자동으로 맞춰집니다.</p>
                </div>
            </div>
        </section>

        {{-- 방법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">DB를 파는 쪽을 위해</span>
                <h2 class="landing__head">콜센터의 전 공정을 하나로</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>원천 DB 관리 + 배분</strong><span>원천 DB를 관리하고 상담원에게 배분합니다.</span></div>
                    <div class="landing__point"><strong>AI 콜 품질 분석</strong><span>상담 품질을 감이 아니라 데이터로 읽습니다.</span></div>
                    <div class="landing__point"><strong>수주 · 납품 · AS</strong><span>보험사 주문부터 납품·사후처리까지.</span></div>
                    <div class="landing__point"><strong>전자계약 · 정산</strong><span>계약과 정산을 자동으로 맞춥니다.</span></div>
                </div>
            </div>
        </section>

        {{-- 연결 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">양면 시장</span>
                <h2 class="landing__head">사는 쪽과 파는 쪽, 둘 다 이해합니다</h2>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.leadbay') }}"><strong>리드베이 (사는 쪽)</strong><span>보험 영업조직 세일즈 CRM →</span></a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'insurance']) }}"><strong>보험 CPA 마케팅</strong><span>DB 유입 설계 →</span></a>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>콜센터 운영, DB부터 정산까지 한 시스템으로</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="https://call2.sale" target="_blank" rel="noopener">콜투세일 바로가기 →</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">도입 상담</a>
                </div>
            </div>
        </section>
    </main>
@endsection
