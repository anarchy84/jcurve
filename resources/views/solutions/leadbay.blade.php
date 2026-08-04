@extends('layouts.app')

@section('title', '리드베이 — 보험 영업 세일즈 CRM | 제이커브인터렉티브')

@section('content')
    <main class="solution">
        <div class="solution__content">
            <p class="subpage__breadcrumb"><a href="{{ route('solutions.index') }}">솔루션</a> · 리드베이</p>
            <h1>보험DB 구매부터 계약 관리까지, 한 흐름으로</h1>
            <p class="subpage__lead">검증된 보험DB 업체를 품질 점수·납품 속도·AS 정책으로 비교해 구매하고,
               상담·계약·AS·정산까지 한 곳에서 관리하는 보험 영업 CRM.</p>

            {{-- [Client Risk] "보험DB 구매"는 개인정보·표시광고 규제 영역. 실서비스 문구만 승계하고
                 "수익/실적 보장" 류 표현 금지. 카피 최종 확정은 대웅 (03_솔루션.md). --}}
            {{-- TODO(4단계): 방법 포인트 + 보험 CPA 연결 블록으로 확장 --}}
            <a href="https://leadbay.co.kr" target="_blank" rel="noopener">리드베이 바로가기 →</a>
        </div>
    </main>
@endsection
