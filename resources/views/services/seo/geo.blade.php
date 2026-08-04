@extends('layouts.app')

@section('title', 'GEO 최적화 | 제이커브인터랙티브')

@section('content')
    <main class="service">
        <article class="service__content">
            <h1>GEO 생성엔진 최적화</h1>
            <p>생성형 AI가 브랜드와 전문 정보를 정확히 이해하고 근거로 활용할 수 있는 디지털 자산을 구축합니다.</p>
            <section aria-labelledby="geo-method-title">
                <h2 id="geo-method-title">AI 검색 가시성</h2>
                <p>엔티티 정보, 신뢰 근거, 인용 가능한 콘텐츠와 기술 기반을 함께 정비합니다.</p>
            </section>
            <a href="{{ route('contact') }}">GEO 컨설팅 문의</a>
        </article>
    </main>
@endsection
