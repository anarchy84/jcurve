@extends('layouts.app')

@section('title', '워드프레스 제작 대행 | 제이커브인터랙티브')

@section('content')
    <main class="service">
        <article class="service__content">
            <h1>워드프레스 제작·운영 대행</h1>
            <p>검색 노출, 콘텐츠 운영, 전환 측정을 고려한 워드프레스 사이트를 구축하고 관리합니다.</p>
            <section aria-labelledby="wordpress-operation-title">
                <h2 id="wordpress-operation-title">구축 이후까지 연결</h2>
                <p>정보 구조와 기술 SEO를 설계하고 유지보수와 콘텐츠 개선을 지속 지원합니다.</p>
            </section>
            <a href="{{ route('contact') }}">워드프레스 프로젝트 문의</a>
        </article>
    </main>
@endsection
