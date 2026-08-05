@extends('layouts.app')

@section('title', '워드프레스 제작·운영 대행 — SEO 내장 사이트 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="디자인만 예쁜 사이트가 아니라, 만든 순간부터 검색에 잡히는 사이트를 만듭니다. 제작 단계부터 SEO를 심는 워드프레스 제작·운영 대행.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">WordPress</span>
                <h1>워드프레스 제작·운영 대행</h1>
                <p class="landing__lead">디자인만 예쁜 사이트가 아니라,
                   만든 순간부터 검색에 잡히는 사이트를 만듭니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">제작 문의</a>
                </div>
            </div>
        </section>

        {{-- ① 문제 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">“홈페이지는 만들었는데, 아무도 안 들어온다.”</h2>
                <p class="landing__body">외주로 만든 사이트 대부분은 SEO가 비어 있습니다.
                   예쁘지만 검색에 안 잡히면, 결국 또 광고비를 써야 유입이 생깁니다.</p>
            </div>
        </section>

        {{-- ② 방법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method</span>
                <h2 class="landing__head">제작 단계부터 SEO를 심습니다</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>SEO 내장</strong>
                        <span>구조화데이터·속도·시맨틱 마크업을 처음부터.</span>
                    </div>
                    <div class="landing__point">
                        <strong>확장 구조</strong>
                        <span>블로그·랜딩·다국어까지 붙일 수 있는 설계.</span>
                    </div>
                    <div class="landing__point">
                        <strong>운영·유지보수</strong>
                        <span>만들고 끝이 아니라 성장까지 관리.</span>
                    </div>
                    <div class="landing__point">
                        <strong>마케팅 연결</strong>
                        <span>퍼포먼스·SEO팀과 같은 회사라 유입 전략까지 한 번에.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ③ 증거 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Evidence</span>
                <h2 class="landing__head">제작과 마케팅이 한 팀</h2>
                <ul class="landing__evidence">
                    <li>홈페이지 제작 + SEO를 한 팀에서 — 제작사와 마케팅사가 나뉘지 않음</li>
                    {{-- [검증] 기존 "홈페이지 제작" 서비스 실적 승계 확인 필요 --}}
                    <li>기존 홈페이지 제작 서비스 실적 승계</li>
                </ul>
            </div>
        </section>

        {{-- ⑥ 최종 CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>만든 순간부터 검색에 잡히는 사이트, 만들어 드립니다</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">제작 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
