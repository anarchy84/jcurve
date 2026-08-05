@extends('layouts.app')

@section('title', 'AEO 답변엔진 최적화 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="구글 AI개요·네이버 AI가 우리 콘텐츠를 답으로 인용하도록 정보 구조와 콘텐츠를 최적화하는 AEO(답변엔진 최적화) 서비스.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위 서비스">
                    <a href="{{ route('services.show', ['slug' => 'seo']) }}">SEO · AEO · GEO</a>
                </nav>
                <span class="landing__eyebrow">AEO</span>
                <h1>답변엔진 최적화 (AEO)</h1>
                <p class="landing__lead">사용자의 질문에 검색엔진이 우리 콘텐츠를 답으로 선택하도록,
                   정보 구조와 콘텐츠를 최적화합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">AEO 컨설팅 문의</a>
                </div>
            </div>
        </section>

        {{-- 방법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method</span>
                <h2 class="landing__head">답변 중심 콘텐츠 구조</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>질문 의도 분해</strong>
                        <span>실제 검색 질문을 수집해 답해야 할 의도를 정의합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>핵심 답변 + 근거</strong>
                        <span>질문 바로 아래 명확한 답과 인용 가능한 근거를 배치합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>구조화 데이터</strong>
                        <span>FAQ·HowTo 스키마로 AI가 발췌·인용하기 쉽게 마크업합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>내부 링크 체계</strong>
                        <span>토픽 클러스터로 문서 간 권위를 연결합니다.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA [파치먼트·중앙] — 방법(다크) 다음이라 색 교차 유지 --}}
        <section class="landing__section landing__section--parchment landing__section--center">
            <div class="landing__inner">
                <h2 class="landing__head">AI가 인용하는 콘텐츠, 함께 만들어요</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">AEO 컨설팅 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
