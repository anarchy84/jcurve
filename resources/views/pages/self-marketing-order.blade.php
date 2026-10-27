@extends('layouts.jc')

{{--
    셀프마케팅 주문 — '광고 시작하기' 4단계 (대웅 지시 2026-10-27: "주문은 랭크프리로 바로 보내지 말고 주문 페이지가 필요해. 바로 주문할 수 있게")
    - 경로: /self-marketing/order (?type=place|shopping). 지금은 routes/pages.php 의 Route::view —
      GPT/Codex가 컨트롤러로 바꾸면서 아래 변수를 넘긴다 → docs/HANDOFF-CLAUDE-ORDER-UI-2026-10-27.md
        $orderCatalog       : 랭크프리 상품표에서 읽은 유형·상품·단가·수량 규칙·기간 (모양은 partials/jc/order-sample.php 와 동일)
        $orderCredit        : 로그인 고객의 보유 크레딧(원). 모르면 null
        $rankfreeConnected  : 로그인 고객의 랭크프리 계정 연결 여부(bool). 모르면 null
      라우트(있으면 자동 사용): self-marketing.targets.search(매장·상품 검색 JSON), self-marketing.orders.store(주문 생성),
      credits.charge(크레딧 충전 결제), self-marketing.orders.index(내 주문)
    - 상품표가 없을 때: 로컬이면 '견본' 상품표로 화면만 보여주고, 운영이면 상담 안내를 보여준다.
    - 로그인은 마지막 단계에서 받는다(대웅 확정). 입력값은 브라우저 세션 저장소에 잠시 보관해 로그인 후 이어서 진행.
    - 금액은 화면 표시용 계산일 뿐이다. 실제 금액·수량·기간은 서버(랭크프리)가 다시 계산해 확정한다.
--}}

@php
    $jcCatalog = $orderCatalog ?? null;
    $jcSample = false;
    if (empty($jcCatalog) && app()->environment('local')) {
        $jcCatalog = require resource_path('views/partials/jc/order-sample.php');
        $jcSample = true;
    }
    $jcTypes = array_keys($jcCatalog ?? []);
    $jcType = in_array(request('type'), $jcTypes, true) ? request('type') : ($jcTypes[0] ?? 'place');
    $jcKakao = config('services.kakao.channel_url');
    $jcState = [
        'catalog' => $jcCatalog,
        'type' => $jcType,
        'sample' => $jcSample,
        'guest' => ! auth()->check(),
        'credit' => $orderCredit ?? null,
        'connected' => $rankfreeConnected ?? null,
        'today' => now('Asia/Seoul')->toDateString(),
        'routes' => [
            'search' => Route::has('self-marketing.targets.search') ? route('self-marketing.targets.search') : null,
            'store' => Route::has('self-marketing.orders.store') ? route('self-marketing.orders.store') : null,
            'charge' => Route::has('credits.charge') ? route('credits.charge') : null,
            'orders' => Route::has('self-marketing.orders.index') ? route('self-marketing.orders.index') : null,
            'login' => route('login'),
            'connect' => route('dashboard').'#rankfree',
            'self' => route('self-marketing.order'),
        ],
    ];
@endphp

@section('title', '광고 시작하기 — 셀프마케팅 주문 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="플레이스·쇼핑 셀프마케팅 광고를 제이커브에서 바로 주문하세요. 매장 찾기, 광고 설정, 일정 설정, 최종 확인 4단계면 끝납니다.">
@endsection
@section('footer_variant', 'jc-footer--white')

@section('content')
    <section class="jc-order-page" aria-labelledby="order-title">
        <div class="jc-wrap">
            <nav class="jc-crumb" aria-label="현재 위치"><a href="{{ route('home') }}">홈</a><span aria-hidden="true">/</span><a href="{{ route('self-marketing') }}">셀프마케팅</a><span aria-hidden="true">/</span><span aria-current="page">광고 시작하기</span></nav>

            @if ($jcSample)
                <p class="jc-sample-ribbon"><x-jc.icon name="info" /><span><strong>견본 화면</strong> — 상품·단가·매장 검색·크레딧은 랭크프리 연동 후 실제 값으로 바뀝니다. 이 띠는 로컬에서만 보입니다.</span></p>
            @endif

            @if (empty($jcCatalog))
                <div class="jc-order-closed">
                    <h1 id="order-title" class="jc-display">광고 시작하기</h1>
                    <p>셀프마케팅 주문을 준비하고 있습니다. 지금은 상담으로 바로 도와드립니다.</p>
                    <div class="jc-btns">
                        <a class="jc-btn jc-btn--kakao" href="{{ $jcKakao ?: route('contact') }}" @if ($jcKakao) target="_blank" rel="noopener" @endif><x-jc.icon name="kakao" />카카오 상담</a>
                        <a class="jc-btn jc-btn--line" href="{{ route('contact') }}">프로젝트 문의</a>
                    </div>
                </div>
            @else
                <div class="jc-order" data-jc-order>
                    <script type="application/json" data-jc-order-state>@json($jcState)</script>
                    <header class="jc-order__head">
                        <div>
                            <h1 id="order-title" class="jc-display">광고 시작하기</h1>
                            <p data-o="title">{{ $jcCatalog[$jcType]['title'] ?? '' }}</p>
                        </div>
                        @if (count($jcTypes) > 1)
                            <div class="jc-order__types" role="group" aria-label="광고 종류">
                                @foreach ($jcCatalog as $key => $cat)
                                    <button type="button" data-o-type="{{ $key }}" aria-pressed="{{ $key === $jcType ? 'true' : 'false' }}"><x-jc.icon :name="$key === 'shopping' ? 'shopping' : 'place'" />{{ $cat['label'] }}</button>
                                @endforeach
                            </div>
                        @endif
                    </header>

                    <div class="jc-order__body">
                        <aside class="jc-order__side">
                            <ol class="jc-order__steps" data-o="steps">
                                <li data-step="1"><span class="jc-order__dot"><b>1</b><x-jc.icon name="check" /></span><span><strong data-o="step1-title">매장 정보 입력</strong><small data-o="step1-desc">매장의 기본 정보를 입력하세요</small></span></li>
                                <li data-step="2"><span class="jc-order__dot"><b>2</b><x-jc.icon name="check" /></span><span><strong>광고 설정</strong><small>광고 옵션을 설정하세요</small></span></li>
                                <li data-step="3"><span class="jc-order__dot"><b>3</b><x-jc.icon name="check" /></span><span><strong>일정 설정</strong><small>광고 일정을 설정하세요</small></span></li>
                                <li data-step="4"><span class="jc-order__dot"><b>4</b><x-jc.icon name="check" /></span><span><strong>최종 확인</strong><small>입력한 정보를 확인하세요</small></span></li>
                            </ol>
                            <div class="jc-order__bar" aria-hidden="true"><i data-o="bar"></i></div>
                            <a class="jc-btn jc-btn--kakao jc-order__kakao" href="{{ $jcKakao ?: route('contact') }}" @if ($jcKakao) target="_blank" rel="noopener" @endif data-jc-kakao><x-jc.icon name="kakao" />카카오 문의</a>
                        </aside>

                        <div class="jc-order__main" data-o="main" aria-live="polite">
                            {{-- 단계별 화면은 resources/js/jc.js §13 이 상품표로 그린다 --}}
                            <noscript><p class="jc-order__noscript">주문 화면은 자바스크립트가 필요합니다. <a href="{{ route('contact') }}">프로젝트 문의</a>로 남겨 주시면 도와드립니다.</p></noscript>
                        </div>
                    </div>

                    <footer class="jc-order__foot">
                        <button type="button" class="jc-btn jc-btn--soft" data-o="prev">이전</button>
                        <p class="jc-order__hint" data-o="hint"></p>
                        <button type="button" class="jc-btn jc-btn--primary" data-o="next">다음</button>
                    </footer>
                </div>
            @endif
        </div>
    </section>
@endsection
