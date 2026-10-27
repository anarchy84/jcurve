@extends('layouts.jc')

{{--
    셀프마케팅 상품 상세 — 플레이스 리워드 마케팅 (대웅 지시 2026-10-27, 참고: 셀프마케팅.com 상세 구성)
    - 구성만 참고하고 문구·수치·사진은 제이커브 것만 쓴다(남의 사례·후기·'몇 % 저렴' 같은 주장 사용 안 함).
    - 순위 사례 칸($rankCases)은 실제 고객 기록이 들어올 자리. 없으면 '기록 방식' 안내만 보이고, 로컬에선 견본 3개에 '견본' 표시.
      $rankCases = [ ['keyword' => '성수 맛집', 'before' => 37, 'after' => 1], ... ]  (GPT/Codex가 랭크프리 기록에서 동의받은 사례만)
    - 단가·상품은 주문 화면(/self-marketing/order)에서 랭크프리 상품표로 보여준다. 여기엔 가격을 적지 않는다.
--}}

@php
    $jcKakao = config('services.kakao.channel_url');
    $jcOrder = route('self-marketing.order', ['type' => 'place']);
    $jcCases = $rankCases ?? [];
    $jcCasesSample = false;
    if (empty($jcCases) && app()->environment('local')) {
        $jcCases = [['keyword' => '예시 키워드 A', 'before' => 37, 'after' => 1], ['keyword' => '예시 키워드 B', 'before' => 81, 'after' => 2], ['keyword' => '예시 키워드 C', 'before' => 24, 'after' => 1]];
        $jcCasesSample = true;
    }
    $jcFloatApps = ['eggfarm', 'cashpang', 'carrotcash', 'pigcash', 'stamptech', 'moneytree'];
    $jcFaq = (require resource_path('views/partials/jc/faq-data.php'))['self']['items'] ?? [];
    $jcFaq = array_merge([
        ['q' => '광고는 언제부터 시작되나요?', 'a' => '등록한 다음 날부터 진행됩니다. 주문 화면의 광고 기간에 시작일과 종료일이 함께 표시됩니다.', 'from' => [route('self-marketing.order'), '광고 시작하기']],
    ], array_slice($jcFaq, 0, 5));
@endphp

@section('title', '플레이스 리워드 마케팅 — 셀프마케팅 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="제이커브가 직접 운영하는 리워드 앱과 제휴 매체에 매장 미션을 보내 실제 사람이 검색해 찾아오게 합니다. 매장·키워드·수량·기간을 직접 정하고 바로 등록하는 플레이스 셀프마케팅.">
@endsection
@section('footer_variant', 'jc-footer--white')

@section('content')
    {{-- ① 첫 화면 --}}
    <section class="jc-wrap jc-prod-hero" aria-labelledby="pl-title">
        <div class="jc-prod-hero__panel">
            <div class="jc-prod-hero__copy">
                <nav class="jc-crumb" aria-label="현재 위치"><a href="{{ route('home') }}">홈</a><span aria-hidden="true">/</span><a href="{{ route('self-marketing') }}">셀프마케팅</a><span aria-hidden="true">/</span><span aria-current="page">플레이스</span></nav>
                <h1 id="pl-title" class="jc-display">플레이스 리워드 마케팅</h1>
                <p class="jc-lead">리워드 앱 미션으로 플레이스 유입을 만들어 보세요.<br>실제 사람이 검색해서 매장을 찾아오고, 그 활동이 순위 상승에 도움을 줍니다.</p>
                <div class="jc-btns">
                    <a class="jc-btn jc-btn--primary" href="{{ $jcOrder }}"><x-jc.icon name="plus" />광고 시작하기</a>
                    <a class="jc-btn jc-btn--kakao" href="{{ $jcKakao ?: route('contact') }}" @if ($jcKakao) target="_blank" rel="noopener" @endif><x-jc.icon name="kakao" />카카오 상담</a>
                </div>
            </div>
            <div class="jc-prod-hero__art" aria-hidden="true">
                @foreach ($jcFloatApps as $i => $app)
                    <img class="jc-prod-hero__app jc-prod-hero__app--{{ $i + 1 }}" src="{{ asset("images/apps/{$app}.png") }}" alt="" width="120" height="120">
                @endforeach
                <span class="jc-prod-hero__pin"><x-jc.icon name="place" /></span>
            </div>
        </div>
    </section>

    {{-- ② 순위 기록 --}}
    <section class="jc-section jc-section--tight" aria-labelledby="pl-cases">
        <div class="jc-wrap">
            <h2 id="pl-cases" class="jc-display jc-h2 jc-center">우리 매장 상위노출,<br><span class="jc-blue">대행사 없이 직접</span> 해보세요</h2>
            @if (count($jcCases))
                <ul class="jc-cases">
                    @foreach ($jcCases as $c)
                        <li>
                            <div class="jc-cases__top"><span><x-jc.icon name="search" />{{ $c['keyword'] }}</span><em>↑ {{ $c['before'] - $c['after'] }}위 상승</em></div>
                            <div class="jc-cases__nums"><span><small>진행 전</small><b class="is-before">{{ $c['before'] }}</b><i>위</i></span><span class="jc-cases__arrow" aria-hidden="true">▶</span><span><small>진행 후</small><b>{{ $c['after'] }}</b><i>위</i></span></div>
                        </li>
                    @endforeach
                </ul>
                <p class="jc-small jc-center">@if ($jcCasesSample)<strong class="jc-sample-tag">견본</strong> 실제 고객 기록이 연결되면 이 자리에 표시됩니다. @else 서비스 이용 고객의 동의를 받아 같은 조건으로 기록한 키워드 순위 변화입니다. 결과는 매장·키워드·기간에 따라 달라집니다. @endif</p>
            @else
                <p class="jc-text jc-center" style="max-width:640px;margin:20px auto 0">진행 전후 순위를 같은 조건으로 기록해 마이페이지에서 확인합니다. 결과는 매장·키워드·기간에 따라 달라집니다.</p>
            @endif
        </div>
    </section>

    {{-- ③ 원리 --}}
    <section class="jc-how" aria-labelledby="pl-how">
        <div class="jc-wrap">
            <h2 id="pl-how" class="jc-display jc-h2 jc-center">어떤 원리로 <mark>순위 상승</mark>에 도움이 되나요?</h2>
            <ol class="jc-how__steps">
                <li>
                    <span class="jc-how__no">1</span>
                    <p>리워드 앱에서<br>매장 미션 송출</p>
                    <figure class="jc-how__card"><img src="{{ asset('images/screens/eggfarm-1.jpg') }}" alt="꼬꼬농장 앱 화면" width="390" height="845" loading="lazy"><figcaption>제이커브 리워드 앱·제휴 매체에 플레이스 미션</figcaption></figure>
                </li>
                <li>
                    <span class="jc-how__no">2</span>
                    <p>미션 참여자가 검색해서<br>매장을 찾아 방문</p>
                    <figure class="jc-how__card jc-how__card--mission">
                        <div class="jc-mission">
                            <strong>네이버 플레이스 매장 찾기 미션</strong>
                            <ol><li>안내된 키워드로 검색해 미션 매장 찾기</li><li>미션 정보와 같은 매장을 찾아 들어가기</li><li>매장 상세 정보에서 정답 확인</li><li>정답 입력 후 리워드 받기</li></ol>
                        </div>
                        <figcaption>실제 사람의 검색을 통한 플레이스 방문</figcaption>
                    </figure>
                </li>
                <li>
                    <span class="jc-how__no">3</span>
                    <p>검색·방문 활동이<br>꾸준히 쌓임</p>
                    <figure class="jc-how__card jc-how__card--chart">
                        <svg viewBox="0 0 300 200" aria-hidden="true"><defs><linearGradient id="pl-fill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#1E3AFF" stop-opacity=".25"/><stop offset="1" stop-color="#1E3AFF" stop-opacity="0"/></linearGradient></defs><g stroke="#E6E7EA"><line x1="20" y1="40" x2="290" y2="40"/><line x1="20" y1="90" x2="290" y2="90"/><line x1="20" y1="140" x2="290" y2="140"/></g><path d="M20 170 C 80 165 110 150 150 128 S 230 60 285 30 L 285 190 L 20 190 Z" fill="url(#pl-fill)"/><path class="jc-how__line" d="M20 170 C 80 165 110 150 150 128 S 230 60 285 30" fill="none" stroke="#1E3AFF" stroke-width="3" stroke-linecap="round" pathLength="1"/><circle cx="285" cy="30" r="6" fill="#1E3AFF"/></svg>
                        <figcaption>쌓인 활동 신호가 순위 상승에 도움</figcaption>
                    </figure>
                </li>
            </ol>
            <div class="jc-how__note">
                <strong>순위 상승에 도움을 줍니다</strong>
                <p>꾸준한 유입으로 매장의 활동 신호를 쌓아 보세요. 특정 순위나 기간을 보장하지는 않습니다.</p>
            </div>
        </div>
    </section>

    {{-- ④ 1분 등록 --}}
    <section class="jc-section" aria-labelledby="pl-steps">
        <div class="jc-wrap">
            <h2 id="pl-steps" class="jc-display jc-h2 jc-center">처음이어도 1분이면 광고가 등록됩니다</h2>
            <div class="jc-steprows">
                <div class="jc-steprow">
                    <div><span class="jc-steprow__no">STEP 01</span><h3 class="jc-display">매장 정보와<br>광고 유형 선택</h3><p>상호명이나 플레이스 URL로 매장을 찾고, 유입·저장·길찾기 중 원하는 유형을 고릅니다.</p></div>
                    <div class="jc-mock" aria-hidden="true">
                        <span class="jc-mock__h"><x-jc.icon name="flag" />광고 유형</span>
                        <span class="jc-mock__row is-on"><x-jc.icon name="users" />플레이스 유입<x-jc.icon name="check" /></span>
                        <span class="jc-mock__row"><x-jc.icon name="bookmark" />플레이스 저장</span>
                        <span class="jc-mock__row"><x-jc.icon name="route" />플레이스 길찾기</span>
                        <span class="jc-mock__row"><x-jc.icon name="layers" />플레이스 복합</span>
                    </div>
                </div>
                <div class="jc-steprow jc-steprow--rev">
                    <div><span class="jc-steprow__no">STEP 02</span><h3 class="jc-display">상위노출 희망 키워드와<br>일 목표 수 설정</h3><p>순위를 기록할 메인 키워드 하나와 하루 목표 수를 정합니다. 경쟁도별 권장 범위를 보고 고르면 됩니다.</p></div>
                    <div class="jc-mock" aria-hidden="true">
                        <span class="jc-mock__h"><x-jc.icon name="flag" />메인 키워드 1개</span>
                        <span class="jc-mock__input">예: 강남 맛집</span>
                        <span class="jc-mock__h"><x-jc.icon name="flag" />일일 목표 유입수</span>
                        <span class="jc-mock__stepper"><i>−</i><b>100<small>명</small></b><i>+</i></span>
                        <span class="jc-mock__guide"><em class="is-low">하</em><em class="is-mid">중</em><em class="is-high">상</em></span>
                    </div>
                </div>
                <div class="jc-steprow">
                    <div><span class="jc-steprow__no">STEP 03</span><h3 class="jc-display">광고 기간 설정 후<br>등록하면 끝</h3><p>기간을 고르고 등록하면 다음 날부터 진행됩니다. 진행 상황과 순위 기록은 마이페이지에서 확인합니다.</p></div>
                    <div class="jc-mock" aria-hidden="true">
                        <span class="jc-mock__h"><x-jc.icon name="calendar" />광고 기간</span>
                        <span class="jc-mock__days"><em class="is-on"><b>인기</b>10일</em><em>20일</em><em>30일</em></span>
                        <span class="jc-mock__btn">저장 후 다음으로</span>
                    </div>
                </div>
            </div>
            <div class="jc-btns jc-center-btns"><a class="jc-btn jc-btn--primary" href="{{ $jcOrder }}">지금 광고 시작하기</a></div>
        </div>
    </section>

    {{-- ⑤ 매체 --}}
    @include('partials.jc.partner-band')

    {{-- ⑥ 직접 하면 좋은 점 --}}
    <section class="jc-section" aria-labelledby="pl-why">
        <div class="jc-wrap">
            <h2 id="pl-why" class="jc-display jc-h2 jc-center">대행사 없이 직접 하면 좋은 점</h2>
            <div class="jc-benefits">
                <div><x-jc.icon name="self" class="jc-benefits__ico" /><h3>직접 고르고 <span class="jc-blue">바로 등록</span></h3><p>매장·키워드·수량·기간을 직접 정하고 그 자리에서 등록합니다. 견적을 기다리지 않아도 됩니다.</p></div>
                <div><x-jc.icon name="apps" class="jc-benefits__ico" /><h3>리워드 앱을 <span class="jc-blue">직접 만드는 회사</span></h3><p>제이커브는 꼬꼬농장·당근캐시 등 리워드 앱 12종을 직접 개발하고 운영합니다. 미션이 실행되는 매체를 직접 관리합니다.</p></div>
                <div><x-jc.icon name="rankfree" class="jc-benefits__ico" /><h3>집행량과 순위를 <span class="jc-blue">기록으로</span></h3><p>상품에 적힌 제공 항목과 집행량, 같은 조건으로 남기는 순위 기록을 약속합니다.</p></div>
                <div><x-jc.icon name="calendar" class="jc-benefits__ico" /><h3>언제든 <span class="jc-blue">24시간 주문</span></h3><p>상담 시간을 맞출 필요 없이 사이트에서 언제든 주문할 수 있습니다. 등록한 광고는 다음 날부터 진행됩니다.</p></div>
            </div>
        </div>
    </section>

    {{-- ⑦ 자주 묻는 질문 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="pl-faq">
        <div class="jc-wrap jc-faq jc-faq--narrow">
            <span class="jc-label" style="color:var(--jc-blue)">FAQ</span>
            <h2 id="pl-faq" class="jc-display jc-h2" style="margin-bottom:32px">자주 묻는 질문</h2>
            @foreach ($jcFaq as $i => $f)
                <details @if ($i === 0) open @endif><summary>{{ $f['q'] }}</summary><p>{{ $f['a'] }}</p></details>
            @endforeach
            <a class="jc-link" href="{{ route('support.faq') }}#faq-self" style="display:inline-block;margin-top:24px">자주 묻는 질문 전체 보기 →</a>
        </div>
    </section>

    {{-- ⑧ 마지막 --}}
    <section class="jc-bg-dark jc-section" aria-labelledby="pl-cta">
        <div class="jc-wrap jc-cta">
            <div>
                <h2 id="pl-cta" class="jc-display jc-h2">오늘 등록하면, 내일부터 시작합니다</h2>
                <p class="jc-text jc-text--dark">매장을 찾고 키워드와 기간만 정하면 됩니다. 막히면 카카오로 바로 물어보세요.</p>
            </div>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ $jcOrder }}">광고 시작하기</a>
                <a class="jc-btn jc-btn--kakao" href="{{ $jcKakao ?: route('contact') }}" @if ($jcKakao) target="_blank" rel="noopener" @endif><x-jc.icon name="kakao" />카카오 상담</a>
            </div>
        </div>
    </section>
@endsection
