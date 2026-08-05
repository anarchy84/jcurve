@extends('layouts.app')

@section('title', 'CPA 마케팅 — 성과가 난 만큼만 과금 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="설치·가입·구매·상담신청. 실제 액션이 일어난 만큼만 과금하는 성과형(CPA) 광고를 설계하고 운영합니다. 보험 DB는 자체 CRM으로 원스톱.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">CPA Marketing</span>
                <h1>CPA 마케팅 — 성과가 난 만큼만 비용이 발생합니다</h1>
                <p class="landing__lead">설치·가입·구매·상담신청. 실제 액션이 일어난 만큼만 과금하는
                   성과형 광고를 설계하고 운영합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">CPA 상담 요청</a>
                </div>
            </div>
        </section>

        {{-- ① 문제 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">“노출은 샀는데, 전환이 안 왔다.”</h2>
                <p class="landing__body">노출·클릭 단가로 광고를 사면 리스크는 광고주가 다 집니다.
                   클릭이 많아도 가입 한 건이 없으면 그대로 손실입니다.</p>
            </div>
        </section>

        {{-- ② 방법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method</span>
                <h2 class="landing__head">액션 단위로 과금 구조를 다시 짭니다</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>전환 정의 합의</strong>
                        <span>무엇을 ‘성과’로 볼지(설치·가입·구매·DB) 먼저 확정합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>트래킹 세팅</strong>
                        <span>픽셀·포스트백·서버 이벤트로 전환을 정확히 귀속합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>매체 소싱</strong>
                        <span>CPA에 맞는 인벤토리(리워드 네트워크 포함)로 물량을 확보합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>어뷰징 필터</strong>
                        <span>무효 전환을 걸러 실제 성과만 정산합니다.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ③ 증거 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Evidence</span>
                <h2 class="landing__head">양면을 다 아는 CPA</h2>
                <ul class="landing__evidence">
                    <li>업종별 CPA 랜딩 다수 운영(부동산·주식·보험·코인·퍼미션콜) — 카테고리별 노하우 축적</li>
                    <li>리워드 네트워크 자체 연동 — CPA 물량 소싱에 강점</li>
                </ul>
            </div>
        </section>

        {{-- ③-보험 자체 CRM 연결 [라이트] ⭐ --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Insurance · 원스톱</span>
                <h2 class="landing__head">보험이라면, DB 유입부터 관리까지 원스톱</h2>
                <p class="landing__body">제이커브는 보험 세일즈 CRM을 직접 만들어 운영합니다.
                   DB를 사는 쪽도, 파는 쪽도 — 양면을 다 이해합니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.leadbay') }}">
                        <strong>리드베이 (LEADBAY)</strong>
                        <span>보험 영업조직용 세일즈 CRM · 구매·상담·계약·정산 한 흐름 →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.call2sale') }}">
                        <strong>콜투세일 (Call2.Sale)</strong>
                        <span>보험DB 콜센터용 CRM · 납품·AI 콜품질·전자계약·정산 →</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ④ 하위 영역 [파치먼트] --}}
        {{-- ⚠️ [검증] 금융·주식·코인 DB는 표시광고·개인정보·유사수신 규제 민감.
             하위 랜딩 카피는 config/subpages.php에 안전 톤으로 존재하나, 법무 확인 전
             "수익/원금 보장" 류 표현 금지. 여기서는 링크만 노출. --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">업종별 CPA</span>
                <h2 class="landing__head">업종별 전문 랜딩</h2>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'real-estate']) }}">
                        <strong>부동산 분양 CPA</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'stock']) }}">
                        <strong>주식 DB 마케팅</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'insurance']) }}">
                        <strong>보험 DB</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'coin']) }}">
                        <strong>코인 DB</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'permission-call']) }}">
                        <strong>퍼미션콜 DB</strong><span>자세히 →</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ⑥ 최종 CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>쓴 만큼이 아니라, 나온 만큼만 내는 구조로 바꿔보세요</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">CPA 상담 요청</a>
                </div>
            </div>
        </section>
    </main>
@endsection
