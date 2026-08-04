@extends('layouts.app')

@section('title', 'SEO 대행 | 제이커브인터랙티브')

@section('content')
    <main class="service">
        <article class="service__content">
            <h1>SEO·AEO·GEO 전문 서비스</h1>
            <p>내부 최적화부터 기술적 SEO 문제까지 진단하고, 검색과 AI 답변 환경에서 발견되는 콘텐츠 구조를 만듭니다.</p>

            <nav aria-label="SEO 연관 서비스">
                <ul>
                    <li><a href="{{ route('services.seo.aeo') }}">AEO 답변엔진 최적화</a></li>
                    <li><a href="{{ route('services.seo.geo') }}">GEO 생성엔진 최적화</a></li>
                </ul>
            </nav>

            <a href="{{ route('contact') }}">SEO 진단 문의</a>
        </article>
    </main>
@endsection
