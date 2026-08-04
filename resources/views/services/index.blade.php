@extends('layouts.app')

@section('title', '서비스 | 제이커브인터랙티브')

@section('content')
    <main class="services">
        <section class="services__overview">
            <h1>디지털 마케팅 서비스</h1>
            <p>전략 수립부터 실행, 측정, 개선까지 하나의 성장 체계로 연결합니다.</p>

            <nav aria-label="서비스 목록">
                <ul>
                    <li><a href="{{ route('services.show', ['slug' => 'performance-marketing']) }}">퍼포먼스 마케팅 대행</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'cpa-marketing']) }}">CPA 마케팅</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'reward-network']) }}">리워드 네트워크</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'seo']) }}">SEO·AEO·GEO</a></li>
                    <li><a href="{{ route('services.show', ['slug' => 'wordpress']) }}">워드프레스 제작·운영</a></li>
                </ul>
            </nav>
        </section>
    </main>
@endsection
