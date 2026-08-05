@extends('layouts.app')

@section('title', 'SEO·AEO·GEO — 이 페이지, 어떻게 찾으셨나요? | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="검색했더니 나왔을 겁니다. 그게 저희가 파는 상품입니다. 구글·네이버 상위노출부터 AI 답변 노출(AEO·GEO)까지 — 이 사이트가 곧 포트폴리오입니다.">
    @verbatim
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {"@type":"Question","name":"얼마나 걸리나요?","acceptedAnswer":{"@type":"Answer","text":"업종·경쟁도에 따라 다르지만 보통 3개월부터 변화가 보입니다. 일주일 만에 1위를 약속하는 곳은 피하세요. 그건 SEO가 아니라 어뷰징입니다."}},
        {"@type":"Question","name":"광고랑 뭐가 다른가요?","acceptedAnswer":{"@type":"Answer","text":"광고는 끄면 끝납니다. 검색 순위는 자산으로 남습니다. 느린 대신 쌓입니다."}}
      ]
    }
    </script>
    @endverbatim
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] — 도발 질문 --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">SEO · AEO · GEO</span>
                <h1>이 페이지, 어떻게 찾으셨나요?</h1>
                <p class="landing__lead">검색했더니 나왔을 겁니다. 그게 저희가 파는 상품입니다.
                   제이커브의 SEO 포트폴리오 1번은 언제나 — 지금 보고 계신 이 사이트입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">내 사이트도 이렇게 →</a>
                </div>
            </div>
        </section>

        {{-- ① 실증 — 자기 증명 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">말 대신 검색 결과로 증명합니다</h2>
                <div class="prose">
                    <p>SEO 업체를 고르는 가장 확실한 방법을 알려드릴까요? 그 업체 이름을 검색해 보세요. 자기 사이트도 못 올리는 회사가 남의 사이트를 올려줄 리 없습니다.</p>
                    {{-- [검증] CONTENT.md 경력·프로젝트 수치 승계 --}}
                    <p>저희는 10년 넘게, 1,000개가 넘는 프로젝트에서 이 일을 해왔습니다. 구글·네이버뿐 아니라 네이버 쇼핑, 플레이스, 쿠팡, 카카오 선물하기까지 — ‘검색되는 곳’이라면 전부 저희 무대입니다.</p>
                </div>
            </div>
        </section>

        {{-- ② 시대 전환 — AEO·GEO [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">AEO · GEO</span>
                <h2 class="landing__head">그리고 지금, 검색의 규칙이 다시 바뀌고 있습니다</h2>
                <div class="prose">
                    <p style="color:var(--on-dark);">사람들이 챗GPT한테 물어보기 시작했습니다. “OO 업체 추천해줘.” AI는 어디서 답을 가져올까요? 검색 상위 문서입니다. 즉 SEO가 죽은 게 아니라, SEO가 AI 노출의 입구가 된 겁니다.</p>
                </div>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>AEO — 답변엔진</strong>
                        <span>구글 AI 개요, 네이버 AI 답변에 인용되도록 문서를 구조화합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>GEO — 생성엔진</strong>
                        <span>챗GPT·퍼플렉시티의 답변에 브랜드가 언급되도록 최적화합니다.</span>
                    </div>
                </div>
                <p class="landing__lead" style="margin-top:24px;">아직 하는 곳이 드뭅니다. 그래서 지금이 선점 타이밍입니다.</p>
            </div>
        </section>

        {{-- ③ 방법 — 3계층 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method</span>
                <h2 class="landing__head">저희가 손대는 세 개의 층</h2>
                <div class="steps">
                    <div class="steps__item">
                        <strong>기술 층</strong>
                        <p>크롤링, 색인, 속도(CWV), 구조화 데이터. 검색엔진이 읽을 수 있는 몸을 만듭니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>콘텐츠 층</strong>
                        <p>검색의도 기반 토픽 클러스터. ‘많이’가 아니라 ‘의도에 맞게’ 씁니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>신뢰 층</strong>
                        <p>내부링크·백링크·E-E-A-T. 검색엔진이 믿을 이유를 쌓습니다. 백링크 패키지는 월 50만원부터.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ④ 하위 카드 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">세부 영역</span>
                <h2 class="landing__head">플랫폼별·유형별 최적화</h2>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.seo.aeo') }}"><strong>AEO — 답변엔진 최적화</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.geo') }}"><strong>GEO — 생성형 AI 노출</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'backlinks']) }}"><strong>백링크 패키지</strong><span>월 50만원~ →</span></a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'naver-place']) }}"><strong>네이버 플레이스</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'naver-shopping']) }}"><strong>네이버 쇼핑</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'coupang']) }}"><strong>쿠팡</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'kakao-gift']) }}"><strong>카카오 선물하기</strong><span>자세히 →</span></a>
                </div>

                <div class="faq">
                    <details class="faq__item">
                        <summary>얼마나 걸리나요?</summary>
                        <p>업종·경쟁도에 따라 다르지만 보통 3개월부터 변화가 보입니다. “일주일 만에 1위”를 약속하는 곳은 피하세요. 그건 SEO가 아니라 어뷰징입니다.</p>
                    </details>
                    <details class="faq__item">
                        <summary>광고랑 뭐가 다른가요?</summary>
                        <p>광고는 끄면 끝납니다. 검색 순위는 자산으로 남습니다. 느린 대신 쌓입니다.</p>
                    </details>
                </div>
            </div>
        </section>

        {{-- CTA [다크] [검증 V3] 무료 SEO 진단 --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>무료 SEO 진단부터 받아보세요</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">내 사이트가 검색엔진에 어떻게 보이는지, 문제 지점을 리포트로 드립니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">무료 SEO 진단</a>
                </div>
            </div>
        </section>
    </main>
@endsection
