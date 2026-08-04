@extends('layouts.app')

@section('title', '리워드 광고 | 제이커브인터랙티브')

@section('content')
    <main class="service">
        <article class="service__content">
            <h1>리워드 네트워크</h1>
            <p>서비스 목표에 맞는 리워드 매체와 오퍼 구조를 설계해 유효 사용자의 행동을 만듭니다.</p>
            <section aria-labelledby="reward-design-title">
                <h2 id="reward-design-title">캠페인 설계</h2>
                <p>유입 이후의 잔존과 전환까지 측정할 수 있도록 보상 조건과 트래킹 구조를 구성합니다.</p>
            </section>
            <a href="{{ route('contact') }}">리워드 광고 문의</a>
        </article>
    </main>
@endsection
