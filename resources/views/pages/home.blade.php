@extends('layouts.app')

@section('title', '제이커브인터랙티브')

@section('content')
    <main class="home">
        <section class="home__hero">
            <h1>제이커브인터랙티브</h1>
            <p>제이커브는 검색엔진 최적화(SEO) 에이전시와 셀프 마케팅 플랫폼 서비스를 운영하는 디지털 마케팅 전문 에이전시입니다.</p>
            <a href="{{ route('contact') }}">프로젝트 문의하기</a>
        </section>

        <section class="home__services" aria-labelledby="home-services-title">
            <h2 id="home-services-title">사업 영역</h2>
            <nav aria-label="사업 영역 바로가기">
                <ul>
                    <li><a href="{{ route('services.show', ['slug' => 'performance-marketing']) }}">퍼포먼스 마케팅</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'cpa-marketing']) }}">CPA 마케팅</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'reward-network']) }}">리워드 네트워크</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'seo']) }}">SEO</a></li>
                    <li><a href="{{ route('services.seo.aeo') }}">AEO</a></li>
                    <li><a href="{{ route('services.seo.geo') }}">GEO</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'wordpress']) }}">워드프레스</a></li>
                    <li><a href="{{ route('solutions.rankfree') }}">랭크프리</a></li>
                    <li><a href="{{ route('solutions.boostingshop') }}">부스팅샵</a></li>
                </ul>
            </nav>
        </section>
    </main>
@endsection
