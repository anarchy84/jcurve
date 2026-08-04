@extends('layouts.app')

@section('title', '회사소개 | 제이커브인터랙티브')

@section('content')
    <main class="company">
        <article class="company__introduction">
            <h1>회사소개</h1>
            <p>제이커브인터랙티브는 데이터와 실행력을 바탕으로 고객사의 지속 가능한 성장을 만드는 디지털 마케팅 전문 에이전시입니다.</p>

            <section aria-labelledby="company-mission-title">
                <h2 id="company-mission-title">미션</h2>
                <p>측정 가능한 전략과 검증 가능한 결과로 마케팅의 성장 곡선을 설계합니다.</p>
            </section>

            <section aria-labelledby="company-expertise-title">
                <h2 id="company-expertise-title">전문 영역</h2>
                <p>퍼포먼스 마케팅, CPA, 리워드 네트워크, SEO·AEO·GEO, 워드프레스 제작과 운영을 통합 지원합니다.</p>
            </section>
        </article>
    </main>
@endsection
