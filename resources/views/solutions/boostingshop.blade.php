@extends('layouts.app')

@section('title', '부스팅샵 — 필요한 것만 골라 담는 셀프 마케팅 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="풀 대행은 부담스럽고 혼자는 막막할 때. 검증된 마케팅 상품을 패키지로 골라 바로 시작하는 셀프 마케팅, 부스팅샵.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위"><a href="{{ route('solutions.index') }}">솔루션</a></nav>
                <span class="landing__eyebrow">BoostingShop</span>
                <h1>필요한 것만 골라 담는 셀프 마케팅</h1>
                <p class="landing__lead">풀 대행은 부담스럽고, 혼자는 막막할 때.
                   검증된 마케팅 상품을 패키지로 골라 바로 시작하세요.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="#products">상품 보기</a>
                </div>
            </div>
        </section>

        {{-- 상품 [다크] --}}
        {{-- ⚠️ [검증] 인스타 상품(팔로워·좋아요·인기게시물) 카피는 플랫폼 정책·표시광고 리스크 → 대웅 확인 후 확정. 상품명만 노출 --}}
        <section class="landing__section landing__section--dark has-orb" id="products">
            <div class="landing__inner">
                <span class="landing__eyebrow">상품</span>
                <h2 class="landing__head">구성은 단순합니다</h2>
                <p class="landing__lead">SEO 캠페인은 베이직·프로·엘리트. 백링크 패키지는 월 50만원부터.
                   인스타그램은 인기게시물·팔로워·좋아요. 각 상품 페이지에 구성·기간·가격이 그대로 적혀 있습니다.
                   궁금한 건 상담으로, 결정은 사장님이.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'basic']) }}"><strong>SEO 캠페인 베이직</strong><span>월 50만원~ →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'pro']) }}"><strong>SEO 캠페인 프로</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'elite']) }}"><strong>SEO 캠페인 엘리트</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'instagram-popular']) }}"><strong>인스타 인기게시물</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'instagram-followers']) }}"><strong>인스타 팔로워</strong><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'instagram-likes']) }}"><strong>인스타 좋아요</strong><span>자세히 →</span></a>
                </div>
            </div>
        </section>

        {{-- CTA [파치먼트·중앙] --}}
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
