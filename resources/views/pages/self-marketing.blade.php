@extends('layouts.jc')

{{--
    셀프마케팅 — 이 사이트에서 바로 주문하는 허브 (대웅 확정 2026-10-27: "여기서 바로 주문이 가능해야 해")
    - 경로: /self-marketing (routes/pages.php). 메뉴: 상단 '셀프마케팅' 단독 메뉴.
    - 주문은 랭크프리 주문 API를 서버에서 호출한다(Codex ORDER01~03, 고객별 랭크프리 계정 연결).
      상품 목록·주문 화면은 Codex 컨트롤러가 아래 변수를 넘겨주면 자동으로 열린다 → COLLAB §3 '제안', QUEUE 참고
        $products            : 주문 가능한 상품 목록 [ ['id','title','description'] ... ]
        $rankfreeConnection  : ['registered' => bool] (로그인 고객의 랭크프리 계정 연결 여부)
      변수가 없을 때(지금)는 주문 순서 안내와 로그인·연결 입구만 보인다.
    - '순위상승' 적극 사용(PLAN-FINAL U2). 특정 기간·특정 순위·매출 보장은 쓰지 않는다.
    - 숫자(30초·0원·1,200+·29,000원)는 랭크프리 페이지(v1)에 공개된 안내를 그대로 옮긴 값.
--}}

@section('title', '셀프마케팅 — 순위상승 캠페인, 여기서 바로 주문하세요 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="플레이스·쇼핑 순위상승 캠페인을 제이커브에서 바로 주문하세요. 랭크프리 무료 순위 확인으로 기준을 잡고, 계정을 연결해 캠페인을 직접 주문·확인하는 셀프마케팅.">
@endsection
@push('head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&display=swap">
@endpush

@php
    $selfFaqs = [
        ['상위 노출을 보장하나요?', '보장하지 않습니다. 약속하는 것은 상품 페이지에 적힌 제공 항목과 집행량, 그리고 같은 조건으로 남기는 순위 기록입니다.'],
        ['랭크프리 순위는 네이버 공식 순위인가요?', '아닙니다. 자체 수집·분석 기반의 추정 정보이며 네이버의 승인이나 보증을 의미하지 않습니다.'],
        ['제가 직접 검색한 순위와 왜 다른가요?', '검색 시점, 기기와 위치, 로그인과 개인화 상태에 따라 결과가 달라질 수 있습니다. 같은 조건으로 반복 확인하는 것이 중요합니다.'],
        ['가입 없이 어디까지 쓸 수 있나요?', '무료 범위에서 순위체크 100개와 분석 월 5회를 쓸 수 있습니다. 자세한 한도는 랭크프리 현재 안내를 따릅니다.'],
        ['분석 후 실행까지 맡길 수 있나요?', '마케팅 대행으로 분석부터 실행까지 맞춤 견적을 드립니다.'],
    ];
@endphp

@section('content')
    <section class="jc-wrap jc-page-hero jc-page-hero--self" aria-labelledby="sf-title">
        <div>
            <nav class="jc-crumb" aria-label="현재 위치"><a href="{{ route('home') }}">홈</a><span aria-hidden="true">/</span><span aria-current="page">셀프마케팅</span></nav>
            <h1 id="sf-title" class="jc-display jc-h1--page">순위상승을 위한 실행,<br>직접 시작하세요.</h1>
            <p class="jc-lead">플레이스·쇼핑 마케팅을 직접 설정하고, 집행량과 순위 변화를 확인하세요. 대행 없이, 필요한 만큼만.</p>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="#order">주문 시작하기</a>
                <a class="jc-btn jc-btn--line" href="#check">내 순위 변화 확인하기</a>
            </div>
        </div>
        <div>
            <div class="jc-board">
                <div><span class="jc-board__up" aria-hidden="true">▲</span><span class="jc-num">30초</span><span class="jc-board__label"><strong>키워드 넣고 순위 확인까지</strong><span>가입 없이 바로</span></span></div>
                <div><span class="jc-board__up" aria-hidden="true">▲</span><span class="jc-num">0원</span><span class="jc-board__label"><strong>무료 순위체크 100개</strong><span>분석 월 5회 포함</span></span></div>
                <div><span class="jc-board__up" aria-hidden="true">▲</span><span class="jc-num">1,200+</span><span class="jc-board__label"><strong>순위를 확인한 사장님</strong><span>랭크프리 이용 기준</span></span></div>
            </div>
            <p class="jc-small" style="margin-top:14px">랭크프리 현재 안내 기준. 결제 전 최신 가격과 제공량을 확인하세요.</p>
        </div>
    </section>

    <section id="check" class="jc-bg-dark" style="padding:48px 0 52px" aria-labelledby="sf-check">
        <div class="jc-wrap jc-check">
            <div>
                <h2 id="sf-check" class="jc-display" style="font-size:clamp(26px,2.6vw,34px);letter-spacing:-0.035em">사장님, 지금 몇 등인지 아세요?</h2>
                <p style="margin-top:10px;font-size:15px;line-height:1.6;color:var(--jc-on-dark-2)">플레이스·쇼핑·블로그 순위를 랭크프리로 무료 확인합니다. 가입은 필요 없습니다.</p>
            </div>
            @include('partials.jc.rank-form', ['variant' => 'row'])
        </div>
    </section>

    <section id="campaigns" class="jc-section" aria-labelledby="sf-campaigns">
        <div class="jc-wrap">
            <div class="jc-head">
                <h2 id="sf-campaigns" class="jc-display jc-h2">어디의 순위를 올릴까요?</h2>
                <p class="jc-text">영역마다 재는 방법과 집행하는 방법이 다릅니다. 먼저 재고, 그다음에 집행합니다.</p>
            </div>
            <div class="jc-three">
                <div>
                    <h3 class="jc-display">플레이스</h3>
                    <p>지도·플레이스 검색에서 내 가게가 보이는 위치</p>
                    <dl class="jc-dl"><dt>측정</dt><dd>키워드별 순위, 상위 경쟁 결과 비교</dd><dt>집행</dt><dd>플레이스 순위상승 캠페인</dd></dl>
                    <a class="jc-link" href="#order">주문하기</a>
                </div>
                <div>
                    <h3 class="jc-display">쇼핑</h3>
                    <p>스마트스토어 상품이 검색되는 위치</p>
                    <dl class="jc-dl"><dt>측정</dt><dd>상품 순위, 6개월 시장 규모·매출 추정</dd><dt>집행</dt><dd>쇼핑 순위상승 캠페인</dd></dl>
                    <a class="jc-link" href="#order">주문하기</a>
                </div>
                <div>
                    <h3 class="jc-display">웹 검색</h3>
                    <p>구글·네이버 웹 검색과 AI 답변 노출</p>
                    <dl class="jc-dl"><dt>측정</dt><dd><a href="{{ route('seo.check') }}">SEO·AEO·GEO 무료 진단</a></dd><dt>집행</dt><dd>SEO 캠페인 베이직·프로·엘리트 (베이직 월 50만원부터)</dd></dl>
                    <a class="jc-link" href="{{ route('solutions.boostingshop.sub', ['sub' => 'basic']) }}">SEO 캠페인 보기</a>
                </div>
            </div>
        </div>
    </section>


    {{-- 주문 — 상품 목록은 Codex 컨트롤러가 $products를 넘기면 보인다 --}}
    <section id="order" class="jc-section jc-bg-fog" aria-labelledby="sf-order">
        <div class="jc-wrap">
            <div class="jc-head">
                <h2 id="sf-order" class="jc-display jc-h2">주문은 네 단계면 끝납니다</h2>
                <p class="jc-text">결제와 집행은 고객님 본인의 랭크프리 계정으로 진행됩니다. 제이커브는 계정 키를 암호화해 보관하고, 화면에 다시 보여주지 않습니다.</p>
            </div>
            <ol class="jc-order-steps">
                <li><span class="jc-num" aria-hidden="true">1</span><strong>로그인</strong><span>제이커브 계정으로 로그인합니다. 처음이면 회원가입부터 합니다.</span></li>
                <li><span class="jc-num" aria-hidden="true">2</span><strong>랭크프리 계정 연결</strong><span>마이페이지에서 랭크프리 API 키를 한 번 등록합니다. 언제든 해제할 수 있습니다.</span></li>
                <li><span class="jc-num" aria-hidden="true">3</span><strong>캠페인 고르고 주문</strong><span>플레이스·쇼핑 캠페인을 고르고 키워드와 조건을 입력해 주문합니다.</span></li>
                <li><span class="jc-num" aria-hidden="true">4</span><strong>접수·진행 확인</strong><span>주문은 ‘접수’로 시작해 진행·완료 상태로 바뀝니다. 금액과 상태는 랭크프리 기준으로 표시됩니다.</span></li>
            </ol>

            @if (! empty($products))
                <div class="jc-order-products">
                    <h3 class="jc-display jc-h3">주문할 수 있는 캠페인</h3>
                    <ul>
                        @foreach ($products as $product)
                            <li>
                                <strong>{{ $product['title'] }}</strong>
                                @if (! empty($product['description']))<p>{{ $product['description'] }}</p>@endif
                                @if (Route::has('self-marketing.products.show'))
                                    <a class="jc-btn jc-btn--primary jc-btn--sm" href="{{ route('self-marketing.products.show', ['product' => $product['id']]) }}">주문하기</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="jc-order-start">
                    @auth
                        @if (! empty($rankfreeConnection['registered']))
                            <p><strong>랭크프리 계정이 연결되어 있습니다.</strong> 주문 가능한 캠페인이 열리면 이 자리에 바로 표시됩니다.</p>
                        @else
                            <p><strong>다음 단계: 랭크프리 계정 연결</strong> 마이페이지에서 랭크프리 API 키를 등록하면 주문할 수 있습니다.</p>
                            <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ route('dashboard') }}">마이페이지에서 연결하기</a>
                        @endif
                    @else
                        <p><strong>로그인하고 주문을 시작하세요.</strong> 랭크프리 계정이 없다면 랭크프리에서 먼저 가입할 수 있습니다.</p>
                        <div class="jc-btns">
                            <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ route('login') }}">로그인</a>
                            <a class="jc-btn jc-btn--line jc-btn--md" href="{{ route('register') }}">회원가입</a>
                            <a class="jc-link" href="https://rankfree.kr" target="_blank" rel="noopener">랭크프리 가입하기 ↗</a>
                        </div>
                    @endauth
                </div>
            @endif
        </div>
    </section>

    <section class="jc-section jc-section--tight" aria-labelledby="sf-steps">
        <div class="jc-wrap">
            <h2 id="sf-steps" class="jc-display jc-h2" style="margin-bottom:48px">재고, 집행하고, 다시 잽니다</h2>
            <ol class="jc-bigsteps">
                <li><span class="jc-num" aria-hidden="true">1</span><strong>지금 순위 확인</strong><span>랭크프리로 내 가게와 상품의 현재 순위를 기록합니다. 같은 조건으로 다시 보기 위한 기준선입니다.</span></li>
                <li><span class="jc-num" aria-hidden="true">2</span><strong>캠페인 설정</strong><span>키워드, 수량, 기간을 직접 정하고 바로 집행합니다. 작은 범위부터 시험할 수 있습니다.</span></li>
                <li><span class="jc-num" aria-hidden="true" style="color:var(--jc-up)">3</span><strong>결과 확인</strong><span>집행량과 순위 변화를 같은 기준으로 다시 확인하고, 문의·방문·매출 자료와 함께 봅니다.</span></li>
            </ol>
        </div>
    </section>

    <section class="jc-section jc-bg-fog" aria-labelledby="sf-promise">
        <div class="jc-wrap">
            <h2 id="sf-promise" class="jc-display jc-h2" style="margin-bottom:40px">약속하는 것과 약속하지 않는 것</h2>
            <div class="jc-promise">
                <div><h3>약속합니다</h3><ul><li>상품 페이지에 적힌 제공 항목과 집행량</li><li>집행 전후 같은 조건의 순위 기록</li><li>정책 경고나 비정상 변동이 보이면 멈추고 함께 확인</li></ul></div>
                <div><h3>약속하지 않습니다</h3><ul><li>특정 기간 안에 특정 순위 도달</li><li>순위 변화에 따른 매출 증가</li><li>검색엔진과 플랫폼이 내리는 색인·평가·순위 판단</li></ul></div>
            </div>
        </div>
    </section>

    <section class="jc-section" aria-labelledby="sf-read">
        <div class="jc-wrap">
            <blockquote class="jc-display jc-quote" id="sf-read">순위 데이터는 판결문이 아니라 계기판입니다. 방향을 읽되, 실제 고객 행동과 매출 자료로 다시 확인하세요.</blockquote>
            <div class="jc-read">
                <div><h3>네이버 공식 지표가 아닙니다</h3><p>랭크프리의 순위와 점수는 자체 수집·분석 기반의 추정 정보입니다.</p></div>
                <div><h3>환경마다 다르게 보입니다</h3><p>검색 시점, 기기와 위치, 로그인 상태에 따라 직접 본 결과와 차이가 날 수 있습니다.</p></div>
                <div><h3>시장·매출은 추정치입니다</h3><p>쇼핑 시장 규모와 매출 값은 판단을 돕는 참고 정보입니다.</p></div>
                <div><h3>점수는 원인을 증명하지 않습니다</h3><p>높거나 낮은 점수는 비교를 돕는 신호이고, 성과를 단정하는 근거는 아닙니다.</p></div>
            </div>
        </div>
    </section>

    <section class="jc-section jc-section--tight" aria-labelledby="sf-plans">
        <div class="jc-wrap">
            <div class="jc-head" style="margin-bottom:32px">
                <h2 id="sf-plans" class="jc-display jc-h2">무료로 시작해서, 필요할 때 확장</h2>
                <span class="jc-small" style="font-size:14px">랭크프리 현재 안내 기준</span>
            </div>
            <div class="jc-plans">
                <div><span class="jc-plans__name">무료</span><span class="jc-num">0원</span><span class="jc-plans__desc">순위체크 100개, 분석 월 5회</span><a class="jc-link" href="#check">무료로 순위 확인</a></div>
                <div><span class="jc-plans__name">프로</span><span style="display:flex;align-items:baseline;gap:6px"><span class="jc-num">29,000원</span><span class="jc-small" style="font-size:15px">/월</span></span><span class="jc-plans__desc">무제한 순위체크, 자동 추적 알림, 순위 API</span><a class="jc-link" href="https://rankfree.kr" rel="noopener">프로 시작하기</a></div>
                <div><span class="jc-plans__name">마케팅 대행</span><span class="jc-num">맞춤 견적</span><span class="jc-plans__desc">분석부터 실행까지 맡기는 경우</span><a class="jc-link" href="{{ route('contact') }}">상담하기</a></div>
            </div>
            <p class="jc-small" style="margin-top:16px">결제 전 랭크프리에서 최신 가격, 제공량, 기능 조건을 다시 확인하세요.</p>
        </div>
    </section>

    <section class="jc-section jc-section--tight" aria-labelledby="sf-faq">
        <div class="jc-wrap jc-faq">
            <h2 id="sf-faq" class="jc-display jc-h2" style="margin-bottom:32px">자주 묻는 질문</h2>
            @foreach ($selfFaqs as $i => [$q, $a])
                <details @if ($i === 0) open @endif><summary>{{ $q }}</summary><p>{{ $a }}</p></details>
            @endforeach
        </div>
    </section>

    <section class="jc-section jc-bg-dark" aria-labelledby="sf-start">
        <div class="jc-wrap jc-cta">
            <div>
                <h2 id="sf-start" class="jc-display jc-h2">지금, 내 순위부터<br>확인해 보세요</h2>
                <p class="jc-text" style="color:var(--jc-on-dark-2)">한 번의 숫자로 결론 내리지 말고, 기준을 만든 뒤 실제 고객 행동과 함께 보세요.</p>
            </div>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--up" href="#check">무료로 순위 확인</a>
                <a class="jc-btn jc-btn--line-white" href="{{ route('contact') }}">상담하기</a>
            </div>
        </div>
    </section>
@endsection

@section('footer_variant', 'jc-footer--white')
