@extends('layouts.app')

@section('title', '중소기업 마케팅 지원사업 | 제이커브인터렉티브')

@section('content')
    <main class="subpage">
        <article class="subpage__content">
            <h1>중소기업 마케팅 지원사업</h1>
            <p class="subpage__lead">제이커브인터렉티브는 정부·기관의 중소기업 마케팅 지원사업 수행기업으로, 지원금을 활용해 온라인 마케팅을 시작하려는 기업을 돕습니다.</p>

            <p>바우처·지원사업은 절차와 요건이 복잡해 첫 단추를 어려워하는 기업이 많습니다. 사업 신청부터 마케팅 실행, 결과 보고까지 전 과정을 함께 진행합니다.</p>

            <section>
                <h2>지원 범위</h2>
                <ul>
                    <li>지원사업 적합성 진단 및 신청 지원</li>
                    <li>퍼포먼스·SEO·콘텐츠 마케팅 실행</li>
                    <li>성과 리포트 및 정산 서류 관리</li>
                </ul>
            </section>

            <a href="{{ route('contact') }}">지원사업 상담 문의</a>
        </article>
    </main>
@endsection
