@extends('layouts.app')

@section('title', '퍼포먼스 마케팅 대행 | 제이커브인터랙티브')

@section('content')
    <main class="service">
        <article class="service__content">
            <h1>퍼포먼스 마케팅 대행</h1>
            <p>매체 운영과 전환 데이터를 연결해 예산 효율과 사업 성장을 함께 개선합니다.</p>
            <section aria-labelledby="performance-process-title">
                <h2 id="performance-process-title">데이터드리븐 실행</h2>
                <p>목표 정의, 캠페인 설계, 소재 실험, 전환 분석을 반복하며 성과를 고도화합니다.</p>
            </section>
            <a href="{{ route('contact') }}">퍼포먼스 마케팅 문의</a>
        </article>
    </main>
@endsection
