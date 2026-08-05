@extends('layouts.app')

@section('title', '부스팅샵 — 직접 돌리는 셀프 마케팅 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="대행을 맡길 예산이 부담이라면, 필요한 마케팅을 직접 골라 바로 실행하세요. SEO 캠페인부터 인스타 부스팅까지 패키지로 간단하게.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위">
                    <a href="{{ route('solutions.index') }}">솔루션</a>
                </nav>
                <span class="landing__eyebrow">BoostingShop</span>
                <h1>직접 돌리는 셀프 마케팅</h1>
                <p class="landing__lead">대행을 맡길 예산이 부담이라면, 필요한 마케팅을 직접 골라
                   바로 실행하세요. 패키지로 간단하게.</p>
            </div>
        </section>

        {{-- ① 문제 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">“대행은 비싸고, 혼자 하긴 막막하다.”</h2>
                <p class="landing__body">소상공인에게 풀 대행은 부담입니다. 그렇다고 뭘 어떻게 해야 할지
                   막막하죠. 검증된 셀프 마케팅 상품을 골라 바로 시작할 수 있게 했습니다.</p>
            </div>
        </section>

        {{-- ② 방법·상품 [다크] --}}
        {{-- ⚠️ [검증] 인스타 팔로워/좋아요/인기게시물은 플랫폼 정책·표시광고 리스크.
             "어뷰징/가짜 지표" 오해 표현 주의, 카피 대웅 확인. 우선 상품명만 노출. --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">상품</span>
                <h2 class="landing__head">필요한 것만, 패키지로</h2>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'basic']) }}">
                        <strong>SEO 캠페인 베이직</strong><span>월 50만원~ →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'pro']) }}">
                        <strong>SEO 캠페인 프로</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'elite']) }}">
                        <strong>SEO 캠페인 엘리트</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'instagram-popular']) }}">
                        <strong>인스타 인기게시물</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'instagram-followers']) }}">
                        <strong>인스타 팔로워</strong><span>자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'instagram-likes']) }}">
                        <strong>인스타 좋아요</strong><span>자세히 →</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ⑥ CTA [파치먼트·중앙] --}}
        <section class="landing__section landing__section--parchment landing__section--center">
            <div class="landing__inner">
                <h2 class="landing__head">예산에 맞게, 필요한 것부터</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">상담 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
