@extends('layouts.jc')

{{--
    셀프마케팅 상품 상세 — 쇼핑 리워드 마케팅 (SEO-KW-01, Claude 2026-11-04)
    - 목표 키워드: 쇼핑 유입 · 쇼핑 리워드 · 쇼핑 순위 · 스마트스토어 상위노출(보조). 대행형 쇼핑 SEO 는 /naver-shopping-marketing/ 가 맡는다(키워드 겹침 방지).
    - 구성은 플레이스 상세(self-marketing-place)와 같고, 상품 유형은 주문 화면(order-sample.php shopping)의 유입·찜·복합과 같다.
    - 순위 사례 칸($rankCases)은 실제 고객 기록이 들어올 자리. 없으면 '기록 방식' 안내만, 로컬에선 견본 3개에 '견본' 표시.
    - 가격은 적지 않는다(주문 화면 상품표가 정본). 구매·구매평·리뷰 작성은 제공하지 않는다고 분명히 쓴다.
--}}

@php
    $jcKakao = config('services.kakao.channel_url');
    $jcOrder = route('self-marketing.order', ['type' => 'shopping']);
    $jcCases = $rankCases ?? [];
    $jcCasesSample = false;
    if (empty($jcCases) && app()->environment('local')) {
        $jcCases = [['keyword' => '예시 키워드 A', 'before' => 54, 'after' => 3], ['keyword' => '예시 키워드 B', 'before' => 120, 'after' => 8], ['keyword' => '예시 키워드 C', 'before' => 33, 'after' => 2]];
        $jcCasesSample = true;
    }
    $jcFloatApps = ['eggfarm', 'cashpang', 'carrotcash', 'pigcash', 'stamptech', 'moneytree'];
    $jcFaq = [
        ['q' => '쇼핑 리워드는 어떤 상품에 잘 맞나요?', 'a' => '상품명·카테고리·속성·상세페이지가 이미 정비된 스마트스토어 상품에 잘 맞습니다. 검색어와 상품 정보가 맞지 않으면 유입이 들어와도 순위에 반영되기 어렵기 때문에, 정보가 부실하면 먼저 네이버 쇼핑 SEO 정비를 권합니다.'],
        ['q' => '쇼핑 순위나 상위노출을 보장하나요?', 'a' => '보장하지 않습니다. 네이버 쇼핑 순위는 검색어와 상품 정보의 적합도, 클릭·찜·판매·리뷰 같은 인기도, 신뢰도와 경쟁 상황에 따라 달라집니다. 제이커브는 상품에 적힌 제공 항목과 집행량, 같은 조건으로 남기는 순위 기록을 약속합니다.'],
        ['q' => '쇼핑 유입과 쇼핑 찜은 어떻게 다른가요?', 'a' => '쇼핑 유입은 미션 참여자가 안내된 키워드로 네이버 쇼핑을 검색해 상품 상세에 들어오는 행동입니다. 쇼핑 찜은 상품을 찜 목록에 담는 행동이고, 쇼핑 복합은 유입과 찜을 함께 진행합니다.'],
        ['q' => '구매나 구매평·리뷰도 만들어 주나요?', 'a' => '제공하지 않습니다. 구매·구매평·리뷰를 대신 만드는 방식은 플랫폼 정책 위반 소지가 크고 상품과 스토어에 불이익이 생길 수 있습니다. 실제 고객의 구매와 후기는 상품 경쟁력과 운영으로 만들어야 합니다.'],
        ['q' => '내 상품의 쇼핑 순위는 어디서 확인하나요?', 'a' => '랭크프리에서 키워드만 넣으면 가입 없이 네이버 쇼핑 순위를 확인할 수 있습니다. 광고를 시작하기 전 순위를 기준으로 잡아 두면 진행 후 변화를 같은 조건으로 비교하기 쉽습니다.', 'from' => [route('solutions.rankfree'), '랭크프리']],
        ['q' => '광고는 언제부터 시작되나요?', 'a' => '등록한 다음 날부터 진행됩니다. 주문 화면의 광고 기간에 시작일과 종료일이 함께 표시됩니다.'],
    ];
@endphp
{{-- 구조화 데이터: FAQ(화면 질문과 같은 배열)·위치 경로·서비스 — SEO-KW-02 (2026-11-04) --}}
@include('partials.jc.schema-faq', ['items' => $jcFaq])
@section('sd_page', '쇼핑 리워드 마케팅')
@section('sd_crumbs', '셀프마케팅=/self-marketing')
@section('sd_service', '네이버 쇼핑 리워드 광고')

@section('title', '쇼핑 리워드 마케팅 — 스마트스토어 상품 유입·찜 셀프마케팅 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="네이버 쇼핑 순위를 위한 쇼핑 리워드 마케팅. 제이커브가 운영하는 리워드 앱과 제휴 매체에 상품 검색 미션을 보내 실제 사람이 키워드로 검색해 스마트스토어 상품에 들어오게 합니다. 쇼핑 유입·찜·복합을 직접 정해 바로 등록하세요.">
@endsection
@section('footer_variant', 'jc-footer--white')

@section('content')
    {{-- ① 첫 화면 --}}
    <section class="jc-wrap jc-prod-hero" aria-labelledby="sh-title">
        <div class="jc-prod-hero__panel">
            <div class="jc-prod-hero__copy">
                <nav class="jc-crumb" aria-label="현재 위치"><a href="{{ route('home') }}">홈</a><span aria-hidden="true">/</span><a href="{{ route('self-marketing') }}">셀프마케팅</a><span aria-hidden="true">/</span><span aria-current="page">쇼핑</span></nav>
                <h1 id="sh-title" class="jc-display">쇼핑 리워드 마케팅</h1>
                <p class="jc-lead">리워드 앱 미션으로 스마트스토어 상품 유입을 만들어 보세요.<br>실제 사람이 키워드로 검색해 상품을 찾아 들어오고, 그 활동이 쇼핑 순위 상승에 도움을 줍니다.</p>
                <div class="jc-btns">
                    <a class="jc-btn jc-btn--primary" href="{{ $jcOrder }}"><x-jc.icon name="plus" />광고 시작하기</a>
                    <a class="jc-btn jc-btn--kakao" href="{{ $jcKakao ?: route('contact') }}" @if ($jcKakao) target="_blank" rel="noopener" @endif><x-jc.icon name="kakao" />카카오 상담</a>
                </div>
            </div>
            <div class="jc-prod-hero__art" aria-hidden="true">
                @foreach ($jcFloatApps as $i => $app)
                    <img class="jc-prod-hero__app jc-prod-hero__app--{{ $i + 1 }}" src="{{ asset("images/apps/{$app}.png") }}" alt="" width="120" height="120">
                @endforeach
                <span class="jc-prod-hero__pin"><x-jc.icon name="shopping" /></span>
            </div>
        </div>
    </section>

    {{-- ② 순위 기록 --}}
    <section class="jc-section jc-section--tight" aria-labelledby="sh-cases">
        <div class="jc-wrap">
            <h2 id="sh-cases" class="jc-display jc-h2 jc-center">스마트스토어 상위노출,<br><span class="jc-blue">대행사 없이 직접</span> 해보세요</h2>
            @if (count($jcCases))
                <ul class="jc-cases">
                    @foreach ($jcCases as $c)
                        <li>
                            <div class="jc-cases__top"><span><x-jc.icon name="search" />{{ $c['keyword'] }}</span><em>↑ {{ $c['before'] - $c['after'] }}위 상승</em></div>
                            <div class="jc-cases__nums"><span><small>진행 전</small><b class="is-before">{{ $c['before'] }}</b><i>위</i></span><span class="jc-cases__arrow" aria-hidden="true">▶</span><span><small>진행 후</small><b>{{ $c['after'] }}</b><i>위</i></span></div>
                        </li>
                    @endforeach
                </ul>
                <p class="jc-small jc-center">@if ($jcCasesSample)<strong class="jc-sample-tag">견본</strong> 실제 고객 기록이 연결되면 이 자리에 표시됩니다. @else 서비스 이용 고객의 동의를 받아 같은 조건으로 기록한 키워드 순위 변화입니다. 결과는 상품·키워드·기간에 따라 달라집니다. @endif</p>
            @else
                <p class="jc-text jc-center" style="max-width:640px;margin:20px auto 0">진행 전후 쇼핑 순위를 같은 조건으로 기록해 마이페이지에서 확인합니다. 결과는 상품·키워드·기간에 따라 달라집니다.</p>
            @endif
        </div>
    </section>

    {{-- ③ 원리 --}}
    <section class="jc-how" aria-labelledby="sh-how">
        <div class="jc-wrap">
            <h2 id="sh-how" class="jc-display jc-h2 jc-center">쇼핑 유입이 어떻게 <mark>순위 상승</mark>에 도움이 되나요?</h2>
            <ol class="jc-how__steps">
                <li>
                    <span class="jc-how__no">1</span>
                    <p>리워드 앱에서<br>상품 미션 송출</p>
                    <figure class="jc-how__card"><img src="{{ asset('images/screens/eggfarm-1.jpg') }}" alt="꼬꼬농장 앱 화면" width="390" height="845" loading="lazy"><figcaption>제이커브 리워드 앱·제휴 매체에 쇼핑 미션</figcaption></figure>
                </li>
                <li>
                    <span class="jc-how__no">2</span>
                    <p>미션 참여자가 키워드로<br>검색해 상품에 들어옴</p>
                    <figure class="jc-how__card jc-how__card--mission">
                        <div class="jc-mission">
                            <strong>네이버 쇼핑 상품 찾기 미션</strong>
                            <ol><li>안내된 키워드로 네이버 쇼핑 검색하기</li><li>미션 정보와 같은 상품을 찾아 들어가기</li><li>상품 상세 정보에서 정답 확인</li><li>정답 입력 후 리워드 받기</li></ol>
                        </div>
                        <figcaption>실제 사람의 검색을 통한 상품 유입</figcaption>
                    </figure>
                </li>
                <li>
                    <span class="jc-how__no">3</span>
                    <p>검색·유입·찜 활동이<br>꾸준히 쌓임</p>
                    <figure class="jc-how__card jc-how__card--chart">
                        <svg viewBox="0 0 300 200" aria-hidden="true"><defs><linearGradient id="sh-fill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#1E3AFF" stop-opacity=".25"/><stop offset="1" stop-color="#1E3AFF" stop-opacity="0"/></linearGradient></defs><g stroke="#E6E7EA"><line x1="20" y1="40" x2="290" y2="40"/><line x1="20" y1="90" x2="290" y2="90"/><line x1="20" y1="140" x2="290" y2="140"/></g><path d="M20 170 C 80 165 110 150 150 128 S 230 60 285 30 L 285 190 L 20 190 Z" fill="url(#sh-fill)"/><path class="jc-how__line" d="M20 170 C 80 165 110 150 150 128 S 230 60 285 30" fill="none" stroke="#1E3AFF" stroke-width="3" stroke-linecap="round" pathLength="1"/><circle cx="285" cy="30" r="6" fill="#1E3AFF"/></svg>
                        <figcaption>쌓인 인기도 신호가 순위 상승에 도움</figcaption>
                    </figure>
                </li>
            </ol>
            <div class="jc-how__note">
                <strong>순위 상승에 도움을 줍니다</strong>
                <p>꾸준한 유입과 찜으로 상품의 인기도 신호를 쌓아 보세요. 특정 순위나 기간을 보장하지는 않습니다.</p>
            </div>
        </div>
    </section>

    {{-- ④ 쇼핑 순위 기준 — 정보형 검색(쇼핑 순위·스마트스토어 상위노출)에 답하는 구간 --}}
    <section class="jc-section" aria-labelledby="sh-rank">
        <div class="jc-wrap">
            <h2 id="sh-rank" class="jc-display jc-h2 jc-center">네이버 쇼핑 순위는 무엇으로 정해지나요?</h2>
            <p class="jc-text jc-center" style="max-width:720px;margin:16px auto 0">네이버는 쇼핑 검색 순위의 세부 산식을 공개하지 않습니다. 업계에서는 보통 적합도·인기도·신뢰도 세 축으로 설명하며, 리워드 유입이 돕는 영역은 그중 인기도입니다. 그래서 순서가 중요합니다.</p>
            <div class="jc-benefits">
                <div><x-jc.icon name="search" class="jc-benefits__ico" /><h3>① 적합도 — <span class="jc-blue">먼저 정비</span></h3><p>검색어와 상품명·카테고리·브랜드·속성·태그가 얼마나 맞는지입니다. 여기가 어긋나면 유입을 넣어도 순위에 잘 반영되지 않습니다. <a class="jc-link" href="{{ url('/naver-shopping-marketing/') }}">네이버 쇼핑 SEO 보기</a></p></div>
                <div><x-jc.icon name="heart" class="jc-benefits__ico" /><h3>② 인기도 — <span class="jc-blue">리워드가 돕는 곳</span></h3><p>클릭·찜·판매·리뷰와 최신성 같은 고객 반응입니다. 쇼핑 리워드의 유입·찜은 이 반응 신호를 꾸준히 쌓는 데 쓰입니다.</p></div>
                <div><x-jc.icon name="check" class="jc-benefits__ico" /><h3>③ 신뢰도 — <span class="jc-blue">무리하지 않기</span></h3><p>상품 정보 어뷰징, 구매평·판매실적 어뷰징 같은 페널티 요소입니다. 그래서 하루 목표 수를 경쟁도에 맞는 범위로 권하고, 구매·리뷰 작성은 하지 않습니다.</p></div>
            </div>
        </div>
    </section>

    {{-- ⑤ 1분 등록 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="sh-steps">
        <div class="jc-wrap">
            <h2 id="sh-steps" class="jc-display jc-h2 jc-center">처음이어도 1분이면 광고가 등록됩니다</h2>
            <div class="jc-steprows">
                <div class="jc-steprow">
                    <div><span class="jc-steprow__no">STEP 01</span><h3 class="jc-display">상품과<br>광고 유형 선택</h3><p>상품 이름이나 스마트스토어 상품 URL로 상품을 찾고, 쇼핑 유입·찜·복합 중 원하는 유형을 고릅니다.</p></div>
                    <div class="jc-mock" aria-hidden="true">
                        <span class="jc-mock__h"><x-jc.icon name="flag" />광고 유형</span>
                        <span class="jc-mock__row is-on"><x-jc.icon name="shopping" />쇼핑 유입<x-jc.icon name="check" /></span>
                        <span class="jc-mock__row"><x-jc.icon name="heart" />쇼핑 찜</span>
                        <span class="jc-mock__row"><x-jc.icon name="layers" />쇼핑 복합</span>
                    </div>
                </div>
                <div class="jc-steprow jc-steprow--rev">
                    <div><span class="jc-steprow__no">STEP 02</span><h3 class="jc-display">상위노출 희망 키워드와<br>일 목표 수 설정</h3><p>순위를 기록할 메인 키워드 하나와 하루 목표 수를 정합니다. 경쟁도별 권장 범위를 보고 고르면 됩니다.</p></div>
                    <div class="jc-mock" aria-hidden="true">
                        <span class="jc-mock__h"><x-jc.icon name="flag" />메인 키워드 1개</span>
                        <span class="jc-mock__input">예: 여성 니트 가디건</span>
                        <span class="jc-mock__h"><x-jc.icon name="flag" />일일 목표 유입수</span>
                        <span class="jc-mock__stepper"><i>−</i><b>100<small>회</small></b><i>+</i></span>
                        <span class="jc-mock__guide"><em class="is-low">하</em><em class="is-mid">중</em><em class="is-high">상</em></span>
                    </div>
                </div>
                <div class="jc-steprow">
                    <div><span class="jc-steprow__no">STEP 03</span><h3 class="jc-display">광고 기간 설정 후<br>등록하면 끝</h3><p>기간을 고르고 등록하면 다음 날부터 진행됩니다. 진행 상황과 쇼핑 순위 기록은 마이페이지에서 확인합니다.</p></div>
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

    {{-- ⑥ 매체 --}}
    @include('partials.jc.partner-band')

    {{-- ⑦ 직접 하면 좋은 점 --}}
    <section class="jc-section" aria-labelledby="sh-why">
        <div class="jc-wrap">
            <h2 id="sh-why" class="jc-display jc-h2 jc-center">대행사 없이 직접 하면 좋은 점</h2>
            <div class="jc-benefits">
                <div><x-jc.icon name="self" class="jc-benefits__ico" /><h3>직접 고르고 <span class="jc-blue">바로 등록</span></h3><p>상품·키워드·수량·기간을 직접 정하고 그 자리에서 등록합니다. 견적을 기다리지 않아도 됩니다.</p></div>
                <div><x-jc.icon name="apps" class="jc-benefits__ico" /><h3>리워드 앱을 <span class="jc-blue">직접 만드는 회사</span></h3><p>제이커브는 꼬꼬농장·당근캐시 등 리워드 앱 12종을 직접 개발하고 운영합니다. 미션이 실행되는 매체를 직접 관리합니다.</p></div>
                <div><x-jc.icon name="rankfree" class="jc-benefits__ico" /><h3>집행량과 순위를 <span class="jc-blue">기록으로</span></h3><p>상품에 적힌 제공 항목과 집행량, 같은 조건으로 남기는 쇼핑 순위 기록을 약속합니다. 순위는 <a class="jc-link" href="{{ route('solutions.rankfree') }}">랭크프리</a>로 언제든 다시 확인할 수 있습니다.</p></div>
                <div><x-jc.icon name="calendar" class="jc-benefits__ico" /><h3>언제든 <span class="jc-blue">24시간 주문</span></h3><p>상담 시간을 맞출 필요 없이 사이트에서 언제든 주문할 수 있습니다. 등록한 광고는 다음 날부터 진행됩니다.</p></div>
            </div>
        </div>
    </section>

    {{-- ⑧ 자주 묻는 질문 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="sh-faq">
        <div class="jc-wrap jc-faq jc-faq--narrow">
            <span class="jc-label" style="color:var(--jc-blue)">FAQ</span>
            <h2 id="sh-faq" class="jc-display jc-h2" style="margin-bottom:32px">자주 묻는 질문</h2>
            @foreach ($jcFaq as $i => $f)
                <details @if ($i === 0) open @endif><summary>{{ $f['q'] }}</summary><p>{{ $f['a'] }}</p></details>
            @endforeach
            <p class="jc-text" style="margin-top:24px">플레이스도 같은 방식으로 진행할 수 있습니다 → <a class="jc-link" href="{{ route('self-marketing.place') }}">플레이스 리워드 마케팅</a></p>
        </div>
    </section>

    {{-- ⑨ 마지막 --}}
    <section class="jc-bg-dark jc-section" aria-labelledby="sh-cta">
        <div class="jc-wrap jc-cta">
            <div>
                <h2 id="sh-cta" class="jc-display jc-h2">오늘 등록하면, 내일부터 시작합니다</h2>
                <p class="jc-text jc-text--dark">상품을 찾고 키워드와 기간만 정하면 됩니다. 막히면 카카오로 바로 물어보세요.</p>
            </div>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ $jcOrder }}">광고 시작하기</a>
                <a class="jc-btn jc-btn--kakao" href="{{ $jcKakao ?: route('contact') }}" @if ($jcKakao) target="_blank" rel="noopener" @endif><x-jc.icon name="kakao" />카카오 상담</a>
            </div>
        </div>
    </section>
@endsection
