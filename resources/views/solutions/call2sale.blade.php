@extends('layouts.app')

@section('title', '콜투세일 — 보험DB 콜센터 세일즈 CRM | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="원천 DB 관리와 상담원 배분, AI 콜 품질 분석, 주문 수주·납품·AS·전자계약·정산까지 한 번에. 보험DB를 생산·납품하는 콜센터용 세일즈 CRM.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위">
                    <a href="{{ route('solutions.index') }}">솔루션</a>
                </nav>
                <span class="landing__eyebrow">Call2.Sale</span>
                <h1>보험DB 콜센터를 위한 세일즈 CRM</h1>
                <p class="landing__lead">원천 DB 관리와 상담원 배분, AI 콜 품질 분석,
                   주문 수주·납품·AS·전자계약·정산까지 한 번에.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://call2.sale" target="_blank" rel="noopener">콜투세일 바로가기 →</a>
                </div>
            </div>
        </section>

        {{-- ② 방법 [다크] --}}
        {{-- ⚠️ [Client Risk] 보험DB 규제 민감 영역. 실서비스 문구만 승계, 보장 표현 금지. --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method · DB를 파는 쪽</span>
                <h2 class="landing__head">DB를 만들어 파는 콜센터의 모든 흐름을</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>원천 DB 관리 + 배분</strong>
                        <span>원천 DB를 관리하고 상담원에게 배분합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>AI 콜 품질 분석</strong>
                        <span>상담 품질을 데이터로 분석합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>수주 · 납품 · AS</strong>
                        <span>보험사 주문부터 납품·사후처리까지 관리합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>전자계약 · 정산</strong>
                        <span>계약과 정산을 자동화합니다.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- 연결 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">양면 시장</span>
                <h2 class="landing__head">사는 쪽과 파는 쪽, 둘 다 이해합니다</h2>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.leadbay') }}">
                        <strong>리드베이 (사는 쪽)</strong><span>보험 영업조직 세일즈 CRM →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'insurance']) }}">
                        <strong>보험 CPA 마케팅</strong><span>DB 유입 설계 →</span>
                    </a>
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
