@extends('layouts.app')

@section('title', '랭크프리 | 제이커브인터랙티브')

@section('content')
    <main class="solution">
        <article class="solution__content">
            <h1>랭크프리</h1>
            <p>검색 순위 데이터를 수집하고 변화 추이를 분석해 실행 우선순위를 찾는 데이터드리븐 솔루션입니다.</p>
            <section aria-labelledby="rankfree-value-title">
                <h2 id="rankfree-value-title">순위에서 실행으로</h2>
                <p>키워드별 현재 위치와 변화를 확인하고 개선 결과를 일관된 기준으로 추적합니다.</p>
            </section>
            <a href="{{ route('contact') }}">랭크프리 문의</a>
        </article>
    </main>
@endsection
