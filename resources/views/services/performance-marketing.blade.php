@extends('layouts.app')

@section('title', '퍼포먼스 마케팅 대행 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="ROAS를 기준으로 매체·데이터·크리에이티브를 한 팀에서 운용하는 퍼포먼스 마케팅 대행. 노출·클릭이 아니라 매출로 증명합니다.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Performance Marketing</span>
                <h1>퍼포먼스 마케팅 대행</h1>
                <p class="landing__lead">광고비를 쓰는 게 아니라, 매출을 만드는 구조로 운용합니다.
                   매체·데이터·크리에이티브를 한 팀에서 돌립니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">성과 진단 요청</a>
                </div>
            </div>
        </section>

        {{-- ① 문제 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">“광고는 돌아가는데, 이게 남는 장사인지 모르겠다.”</h2>
                <p class="landing__body">대행사를 써도 리포트는 노출·클릭까지만 옵니다. 정작 궁금한 건
                   “이 돈 써서 얼마 벌었나”인데, 그 답이 없습니다. 매체가 나뉘어 있으면
                   전환 하나가 어느 광고에서 왔는지도 흐려집니다.</p>
            </div>
        </section>

        {{-- ② 방법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method</span>
                <h2 class="landing__head">ROAS를 기준으로, 감이 아니라 데이터로 예산을 옮깁니다</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>전환 기준 설계</strong>
                        <span>노출·클릭이 아니라 매출·가입·설치를 KPI로 먼저 정의합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>매체 통합 운용</strong>
                        <span>메타·구글·네이버·유튜브를 한 대시보드에서 교차 배분합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>주간 리밸런싱</strong>
                        <span>성과 낮은 세트는 끄고, 이기는 크리에이티브에 예산을 이동합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>크리에이티브 내재화</strong>
                        <span>촬영·편집·디자인이 사내에 있어 소재 회전이 빠릅니다.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ③ 증거 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Evidence</span>
                <h2 class="landing__head">숫자로 남은 실행</h2>
                <ul class="landing__evidence">
                    {{-- [검증 V2] 373억·15,700은 회사 전체 누적. 서비스 전액 귀속 금지 --}}
                    <li>제이커브 누적(회사 전체 기준) — 집행 광고비 373억 · 진행 캠페인 15,700건</li>
                    <li>크리에이티브 자체 제작(외주 아님) — 소재 A/B 회전 속도가 대행 평균보다 빠릅니다</li>
                    <li>채널별 전문 랜딩으로 연결 — 네이버 GFA · 메타 · 유튜브</li>
                </ul>
            </div>
        </section>

        {{-- ④ 하위 영역 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">채널별 상세</span>
                <h2 class="landing__head">채널별 전문 랜딩</h2>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.performance.sub', ['sub' => 'naver-gfa']) }}">
                        <strong>네이버 GFA 광고</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.performance.sub', ['sub' => 'facebook']) }}">
                        <strong>페이스북·인스타그램</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.performance.sub', ['sub' => 'youtube']) }}">
                        <strong>유튜브 광고·영상</strong><span>자세히 →</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ⑥ 최종 CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>지금 돌리는 광고, 남는 장사인지부터 봐드립니다</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">성과 진단 요청</a>
                </div>
            </div>
        </section>
    </main>
@endsection
