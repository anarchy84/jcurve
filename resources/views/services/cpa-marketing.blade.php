@extends('layouts.app')

@section('title', 'CPA 마케팅 — 성과가 없으면 비용도 없습니다 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="노출당 과금이 아니라 액션당 과금. 설치·가입·상담신청 1건, 일어난 만큼만 계산하는 CPA 구조를 계약처럼 명료하게 설계합니다. 보험 DB는 자체 CRM으로 원스톱.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">CPA Marketing</span>
                <h1>성과가 없으면, 비용도 없습니다</h1>
                <p class="landing__lead">노출당 과금이 아니라 액션당 과금.
                   설치 1건, 가입 1건, 상담신청 1건 — 일어난 만큼만 계산하는 구조입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">CPA 구조 상담</a>
                </div>
            </div>
        </section>

        {{-- ① 과금 구조 비교표 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">어디에 돈을 내는 구조인지부터 보시죠</h2>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr>
                                <th scope="col">구분</th>
                                <th scope="col">일반 디스플레이 광고</th>
                                <th scope="col" class="is-cpa">CPA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">과금 시점</th><td>노출·클릭 발생 시</td><td class="is-cpa">정의된 액션 완료 시</td></tr>
                            <tr><th scope="row">리스크 부담</th><td>광고주</td><td class="is-cpa">매체·네트워크</td></tr>
                            <tr><th scope="row">성과 없을 때</th><td>광고비 소진</td><td class="is-cpa">비용 0</td></tr>
                            <tr><th scope="row">적합한 목표</th><td>인지도</td><td class="is-cpa">설치·가입·DB·구매</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="prose" style="margin-top:24px;">
                    <p>광고주 입장에서 CPA의 본질은 하나입니다. 리스크의 이동. “보여주는 값”이 아니라 “일어난 값”을 내는 것.</p>
                </div>
            </div>
        </section>

        {{-- ② 조건 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Conditions</span>
                <h2 class="landing__head">대신, 조건이 있습니다</h2>
                <p class="landing__lead">CPA가 만능은 아닙니다. 세 가지가 갖춰져야 돌아갑니다.</p>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>하나. 액션 정의가 명확할 것</strong>
                        <span>‘설치’인지 ‘가입’인지 ‘결제’인지. 모호하면 정산 분쟁이 됩니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>둘. 트래킹이 정확할 것</strong>
                        <span>픽셀·포스트백·서버 이벤트. 측정 안 되는 액션은 과금할 수 없습니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>셋. 단가가 시장가일 것</strong>
                        <span>액션당 단가가 너무 낮으면 물량이 안 붙습니다. 시장가는 상담에서 투명하게 공개합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>이 세팅을 저희가 합니다</strong>
                        <span>그게 CPA 대행의 일입니다.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ③ 업종 케이스 [파치먼트] --}}
        {{-- ⚠️ [검증] 금융계열 하위 랜딩 본문은 법무 확인 전까지 링크만(히어로+CTA만 방침 유지) --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">업종별 CPA</span>
                <h2 class="landing__head">업종마다 판이 다릅니다</h2>
                <p class="landing__body">부동산 분양 · 주식 · 보험 · 코인 · 퍼미션콜 — 각 업종 전용 구조로 운영합니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'real-estate']) }}"><strong>부동산 분양 CPA</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'stock']) }}"><strong>주식 DB 마케팅</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'insurance']) }}"><strong>보험 DB</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'coin']) }}"><strong>코인 DB</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'permission-call']) }}"><strong>퍼미션콜 DB</strong><span>자세히 →</span></a>
                </div>
            </div>
        </section>

        {{-- ④ 보험 CRM 연결 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Insurance</span>
                <h2 class="landing__head">보험 쪽이시라면, 저희는 조금 더 깊이 들어갑니다</h2>
                <p class="landing__body">DB를 사는 쪽을 위한 CRM(리드베이)과 파는 쪽을 위한 CRM(콜투세일)을
                   직접 만들어 운영 중입니다. 유입에서 끝나지 않고 상담·계약·정산까지 — 파이프라인 전체가 저희 영역입니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.leadbay') }}"><strong>리드베이 (LEADBAY)</strong><span>보험 영업조직 세일즈 CRM →</span></a>
                    <a class="subcard" href="{{ route('solutions.call2sale') }}"><strong>콜투세일 (Call2.Sale)</strong><span>보험DB 콜센터 CRM →</span></a>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>조건 맞춰서 구조 설계해 드립니다</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">목표 액션·예상 단가·물량, 상담에서 숫자로 말씀드립니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">CPA 구조 상담</a>
                </div>
            </div>
        </section>
    </main>
@endsection
