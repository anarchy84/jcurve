@extends('layouts.app')

@section('title', 'AEO 답변엔진 최적화 | 제이커브인터랙티브')

@section('content')
    <main class="service">
        <article class="service__content">
            <h1>AEO 답변엔진 최적화</h1>
            <p>사용자의 질문에 검색엔진이 명확한 답을 선택할 수 있도록 정보 구조와 콘텐츠를 최적화합니다.</p>
            <section aria-labelledby="aeo-method-title">
                <h2 id="aeo-method-title">답변 중심 콘텐츠 구조</h2>
                <p>질문 의도, 핵심 답변, 근거, 구조화된 내부 링크를 하나의 문서 체계로 연결합니다.</p>
            </section>
            <a href="{{ route('contact') }}">AEO 컨설팅 문의</a>
        </article>
    </main>
@endsection
