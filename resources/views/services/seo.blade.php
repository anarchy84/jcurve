@extends('layouts.app')

@section('title', '검색을 넘어 AI 답변에 노출되는 SEO — SEO·AEO·GEO | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="구글·네이버 상위노출부터 AI 검색 최적화(AEO·GEO)까지. 지금 이 페이지가 검색 상위에 올라온 과정 자체가 저희의 포트폴리오입니다.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">SEO · AEO · GEO</span>
                <h1>검색을 넘어, AI 답변에 노출되는 SEO</h1>
                <p class="landing__lead">구글·네이버 상위노출부터 AI 검색 최적화까지.
                   그리고 — 지금 이 페이지가 어떻게 상위에 올라왔는지가 저희의 포트폴리오입니다.</p>
                {{-- [검증 V3] 구버전에 '무료 SEO 분석' 실재 → '무료 SEO 진단' 유지 가능. 대웅 확정 전이면 '진단 요청'. --}}
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">무료 SEO 진단</a>
                </div>
            </div>
        </section>

        {{-- ① 문제 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">“광고를 멈추면 유입도 멈춘다.”</h2>
                <p class="landing__body">퍼포먼스 광고는 끄는 순간 트래픽이 0이 됩니다.
                   검색 유입은 한 번 자리를 잡으면 광고비 없이 계속 들어옵니다.
                   문제는 SEO가 느리고, 대부분의 업체가 ‘백링크 몇 개’로 끝낸다는 것입니다.</p>
            </div>
        </section>

        {{-- ② 방법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method</span>
                <h2 class="landing__head">기술·콘텐츠·신뢰를 한 번에 — 그리고 AI 검색까지</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>테크니컬 SEO</strong>
                        <span>크롤링·색인·속도(CWV)·구조화데이터를 엔지니어 수준으로.</span>
                    </div>
                    <div class="landing__point">
                        <strong>콘텐츠 SEO</strong>
                        <span>검색의도 기반 토픽 클러스터 설계, 내부링크로 권위 이전.</span>
                    </div>
                    <div class="landing__point">
                        <strong>AEO — 답변엔진</strong>
                        <span>구글 AI개요·네이버 AI가 인용하도록 구조화.</span>
                    </div>
                    <div class="landing__point">
                        <strong>GEO — 생성엔진</strong>
                        <span>ChatGPT·Perplexity 답변에 브랜드가 언급되도록 최적화.</span>
                    </div>
                </div>
                <div class="landing__chips">
                    <span>구글</span>
                    <span>네이버 쇼핑</span>
                    <span>네이버 플레이스</span>
                    <span>쿠팡</span>
                    <span>카카오 선물하기</span>
                </div>
            </div>
        </section>

        {{-- ③ 증거 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Evidence</span>
                <h2 class="landing__head">이 사이트가 곧 증거입니다</h2>
                <ul class="landing__evidence">
                    {{-- [검증] 기존 사이트 카피 승계 확인 필요 --}}
                    <li>10년+ 경력, 1,000개+ 프로젝트 — E-E-A-T 근거</li>
                    <li>이 사이트 자체가 SEO 결과물 — 신규 사이트가 검색 상위에 오르는 과정이 실증</li>
                    <li>백링크 패키지(월 50만원~)로 도메인 권위까지 단계적으로 구축</li>
                </ul>
            </div>
        </section>

        {{-- ④ 하위 영역 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">세부 영역</span>
                <h2 class="landing__head">플랫폼별·유형별 최적화</h2>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.seo.aeo') }}">
                        <strong>AEO — 답변엔진 최적화</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.seo.geo') }}">
                        <strong>GEO — 생성형 AI 노출</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'backlinks']) }}">
                        <strong>백링크 패키지</strong><span>월 50만원~ →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'naver-place']) }}">
                        <strong>네이버 플레이스</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'naver-shopping']) }}">
                        <strong>네이버 쇼핑</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'coupang']) }}">
                        <strong>쿠팡</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'kakao-gift']) }}">
                        <strong>카카오 선물하기</strong><span>자세히 →</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ⑥ 최종 CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>광고를 끄면 사라지는 유입 말고, 쌓이는 유입을 만드세요</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">SEO 진단 요청</a>
                </div>
            </div>
        </section>
    </main>
@endsection
