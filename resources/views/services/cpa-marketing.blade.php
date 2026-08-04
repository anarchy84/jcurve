@extends('layouts.app')

@section('title', 'CPA 마케팅 | 제이커브인터랙티브')

@section('content')
    <main class="service">
        <article class="service__content">
            <h1>CPA 마케팅</h1>
            <p>정의된 전환이 발생했을 때 비용을 집행하는 성과 중심 캠페인을 설계하고 운영합니다.</p>
            <section aria-labelledby="cpa-operation-title">
                <h2 id="cpa-operation-title">성과형 운영 체계</h2>
                <p>리드 품질, 승인 기준, 전환 단가를 함께 관리해 양과 질의 균형을 맞춥니다.</p>
            </section>
            <a href="{{ route('contact') }}">CPA 마케팅 문의</a>
        </article>
    </main>
@endsection
