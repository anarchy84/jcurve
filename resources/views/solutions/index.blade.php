@extends('layouts.app')

@section('title', '자체 솔루션 | 제이커브인터렉티브')

@section('content')
    <main class="solution">
        <div class="solution__content">
            <p class="subpage__breadcrumb"><a href="{{ route('home') }}">홈</a> · 솔루션</p>
            <h1>빌려 쓰지 않습니다. 직접 만듭니다.</h1>
            <p class="subpage__lead">현장에서 필요한 도구를 제이커브가 직접 개발해 운영합니다.
               마케팅 데이터부터 보험 세일즈 CRM까지, 네 개의 자체 솔루션.</p>

            {{-- TODO(4단계): 03_솔루션.md 허브 구조(솔루션 카드 4개 + 역동 레이어)로 확장 --}}
            <ul>
                <li><a href="{{ route('solutions.rankfree') }}">랭크프리 — 네이버 순위·시장 분석</a></li>
                <li><a href="{{ route('solutions.boostingshop') }}">부스팅샵 — 직접 돌리는 셀프 마케팅</a></li>
                <li><a href="{{ route('solutions.leadbay') }}">리드베이 — 보험 영업조직 세일즈 CRM</a></li>
                <li><a href="{{ route('solutions.call2sale') }}">콜투세일 — 보험DB 콜센터 CRM</a></li>
            </ul>
        </div>
    </main>
@endsection
