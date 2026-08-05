@extends('layouts.app')

@section('title', 'GEO 생성엔진 최적화 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="ChatGPT·Perplexity 같은 생성형 AI가 브랜드와 전문 정보를 정확히 이해하고 근거로 인용하도록 디지털 자산을 구축하는 GEO(생성엔진 최적화) 서비스.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위 서비스">
                    <a href="{{ route('services.show', ['slug' => 'seo']) }}">SEO · AEO · GEO</a>
                </nav>
                <span class="landing__eyebrow">GEO</span>
                <h1>생성엔진 최적화 (GEO)</h1>
                <p class="landing__lead">생성형 AI가 브랜드와 전문 정보를 정확히 이해하고
                   근거로 인용할 수 있는 디지털 자산을 구축합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">GEO 컨설팅 문의</a>
                </div>
            </div>
        </section>

        {{-- 방법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method</span>
                <h2 class="landing__head">AI 검색 가시성</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>엔티티 정보 정비</strong>
                        <span>브랜드·인물·서비스를 AI가 식별할 수 있는 엔티티로 구조화합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>신뢰 근거 확보</strong>
                        <span>일관된 정보와 외부 인용으로 AI가 신뢰할 근거를 쌓습니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>인용 가능한 콘텐츠</strong>
                        <span>AI가 발췌·인용하기 좋은 명확한 사실 기반 문서를 만듭니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>기술 기반 정비</strong>
                        <span>크롤링·구조화데이터로 생성엔진이 접근·이해하도록 정비합니다.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA [파치먼트·중앙] --}}
        <section class="landing__section landing__section--parchment landing__section--center">
            <div class="landing__inner">
                <h2 class="landing__head">AI 답변에 브랜드를 올려보세요</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">GEO 컨설팅 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
