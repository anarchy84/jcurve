@extends('layouts.app')

@section('title', '콜투세일 — 보험DB 콜센터 세일즈 CRM | 제이커브인터렉티브')

@section('content')
    <main class="solution">
        <div class="solution__content">
            <p class="subpage__breadcrumb"><a href="{{ route('solutions.index') }}">솔루션</a> · 콜투세일</p>
            <h1>보험DB 콜센터를 위한 세일즈 CRM</h1>
            <p class="subpage__lead">원천 DB 관리와 상담원 배분, AI 콜 품질 분석,
               주문 수주·납품·AS·전자계약·정산까지 한 번에.</p>

            {{-- [Client Risk] 보험DB 규제 민감 영역. 실서비스 문구만 승계, 보장 표현 금지 (03_솔루션.md). --}}
            {{-- TODO(4단계): 방법 포인트 + 리드베이(짝) 연결로 확장 --}}
            <a href="https://call2.sale" target="_blank" rel="noopener">콜투세일 바로가기 →</a>
        </div>
    </main>
@endsection
