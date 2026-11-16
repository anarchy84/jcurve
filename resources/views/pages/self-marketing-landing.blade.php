@extends('layouts.jc')

{{--
    셀프마케팅 랜딩 — 처음 오는 사장님용 한 페이지 안내 (팀장 배정 2026-11-16, 참고: placewizard.kr/placeai.php 섹션 순서·레이아웃만)
    - 경로: /self-marketing (이름 self-marketing, 2026-11-16 JC-RELEASE-A 대표님 지시로 옛 허브 대신 이 화면). 옛 주소 /lp/self-marketing 은 301. 처음 판 메모 — /self-marketing/ 아래에 두지 않는다 — Codex 예정 파라미터 라우트와 충돌 방지.
    - 참고 사이트의 문장·이미지·로고·브랜드명은 쓰지 않았다. 카피는 기존 셀프마케팅 4개 화면·랭크프리 페이지에 이미 있는 사실만 다시 썼다.
    - 숫자(30초·0원·1,200+·100개·월 5회)는 self-marketing.blade.php 히어로·FAQ 와 같은 값이다(랭크프리 v1 공개 안내).
    - '순위상승' 적극 사용(PLAN-FINAL U2). 특정 순위·기간·매출 보장은 쓰지 않는다.
    - 상단 메뉴·사이트맵 포함 여부는 대웅 결정 대기(QUEUE 공지).
    - 2026-11-16 보강: 셀프마케팅.com 플레이스 리워드 페이지의 정보 항목을 대조해, 제이커브 근거가 있는 것만 제이커브 문구로 넣었다
      (진행 방식·유형·매체·직접 주문의 장점·주의사항·FAQ 3개). 항목별 근거와 미반영 사유: docs/frontend/12_셀프마케팅닷컴_플레이스리워드_대조표_2026-11-16.md
    - 2026-11-16 디자인: docs/frontend/14_셀프마케팅랜딩_디자인지시서_2026-11-16.md 기준(레이아웃·글꼴·글자 크기는 마케팅마법사 실측, 색은 jc.css).
      전체를 .jc-lp 로 감싸 랜딩 안에서만 바꾼다.
    - 2026-11-16 이미지 교체(대표님 지시 「그림은 GPT로, 네이버는 실제 화면 캡처로」): public/images/lp/self-marketing/gpt/(GPT 그림 — 「예시 화면」 배지)·real/(실제 네이버 캡처 — CSS 휴대폰 틀 + 캡션, 배지 없음). 지시서 6장.
--}}

@php
    $jcKakao = config('services.kakao.channel_url');
    // FAQ — 화면과 구조화 데이터(FAQPage)가 같은 배열을 쓴다. 답은 기존 화면 문구 그대로(출처: 각 줄 끝 주석).
    $lpFaqs = [
        ['q' => '상위 노출을 보장하나요?', 'a' => '보장하지 않습니다. 약속하는 것은 상품 페이지에 적힌 제공 항목과 집행량, 그리고 같은 조건으로 남기는 순위 기록입니다.'], // self-marketing
        ['q' => '랭크프리 순위는 네이버 공식 순위인가요?', 'a' => '아닙니다. 자체 수집·분석 기반의 추정 정보이며 네이버의 승인이나 보증을 의미하지 않습니다.'], // self-marketing
        ['q' => '제가 직접 검색한 순위와 왜 다른가요?', 'a' => '검색 시점, 기기와 위치, 로그인과 개인화 상태에 따라 결과가 달라질 수 있습니다. 같은 조건으로 반복 확인하는 것이 중요합니다.'], // self-marketing
        ['q' => '광고는 언제부터 시작되나요?', 'a' => '등록한 다음 날부터 진행됩니다. 주문 화면의 광고 기간에 시작일과 종료일이 함께 표시됩니다.'], // self-marketing-place·shopping
        ['q' => '진행 상황은 어디서 확인하나요?', 'a' => '진행 상황과 순위 기록은 마이페이지에서 확인합니다. 순위는 랭크프리로 같은 조건에서 언제든 다시 잴 수 있습니다.'], // self-marketing-place:157, self-marketing-shopping:181
        ['q' => '순위 변화는 얼마나 지나야 보이나요?', 'a' => '매장·키워드·기간에 따라 달라서 특정 시점을 약속하지 않습니다. 진행 전 순위를 기준으로 남겨 두고, 같은 조건으로 변화를 비교해 보세요.'], // self-marketing-place:73·75, self-marketing:169, self-marketing-shopping:26
        ['q' => '실제 사람이 미션에 참여하나요?', 'a' => '네. 제이커브가 운영하는 리워드 앱과 제휴 매체의 이용자가 미션에 참여해, 안내된 키워드로 직접 검색합니다. 다만 실제 사람의 참여라는 사실이 플랫폼 정책 충족이나 순위 상승을 보장하지는 않습니다.'], // self-marketing-place:34·178, partner-band, PLAN-FINAL:95
        ['q' => '구매나 구매평·리뷰도 만들어 주나요?', 'a' => '제공하지 않습니다. 구매·구매평·리뷰를 대신 만드는 방식은 플랫폼 정책 위반 소지가 크고 상품과 스토어에 불이익이 생길 수 있습니다. 실제 고객의 구매와 후기는 상품 경쟁력과 운영으로 만들어야 합니다.'], // self-marketing-shopping
        ['q' => '분석 후 실행까지 맡길 수 있나요?', 'a' => '마케팅 대행으로 분석부터 실행까지 맞춤 견적을 드립니다.'], // self-marketing
    ];
@endphp
{{-- 구조화 데이터: FAQ(화면 질문과 같은 배열)·위치 경로·서비스 --}}
@include('partials.jc.schema-faq', ['items' => $lpFaqs])
@section('sd_page', '셀프마케팅')
@section('sd_crumbs', '')
@section('sd_service', '플레이스·쇼핑 순위상승 셀프마케팅')

@section('title', '셀프마케팅 — 순위 확인부터 순위상승 캠페인 주문까지 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="셀프마케팅을 처음 시작하는 사장님을 위한 한 페이지 안내. 플레이스·쇼핑 순위상승 캠페인이 하는 일, 랭크프리 무료 순위 확인, 진단 기준, 주문 3단계와 자주 묻는 질문을 정리했습니다.">
@endsection
{{-- 글꼴: Pretendard Variable v1.3.9(OFL 1.1) 하나만 쓴다. 모든 페이지 <head>(partials/jc/head:150)에서 이미 불러오고 @font-face 가 font-display: swap 이라 여기서 더 불러오지 않는다(지시서 2장). 옛 Archivo 는 뺐다. --}}
@section('footer_variant', 'jc-footer--white')

@section('content')
<div class="jc-lp">
    {{-- ① 첫 화면 --}}
    <section class="jc-lp-hero jc-bg-dark" aria-labelledby="lp-title">
        <img class="jc-lp-hero__bg" src="{{ asset('images/hero/hero-bg.webp') }}" alt="" width="1672" height="941" fetchpriority="high" decoding="async">
        <div class="jc-wrap jc-lp-hero__in">
            <div class="jc-lp-hero__top">
                <nav class="jc-crumb" aria-label="현재 위치"><a href="{{ route('home') }}">홈</a><span aria-hidden="true">/</span><span aria-current="page">셀프마케팅</span></nav>
                <h1 id="lp-title" class="jc-lp-h1">순위 확인부터<br>순위상승 캠페인 주문까지</h1>
            </div>
            <div class="jc-lp-hero__copy">
                <p class="jc-lp-lead">랭크프리로 플레이스·쇼핑 순위를 무료로 확인하고, 순위상승 캠페인은 제이커브에서 직접 주문하세요. 매장·키워드·수량·기간은 사장님이 정합니다.</p>
                <p class="jc-lp-principle">순위를 보장하지 않습니다. 대신 집행 전후 순위를 같은 조건으로 기록해 함께 봅니다.</p>
                <div class="jc-lp-btns">
                    <a class="jc-btn jc-btn--primary jc-lp-btn" href="{{ route('self-marketing.order') }}">광고 시작하기<x-jc.icon name="arrow-right" /></a>
                    <a class="jc-btn jc-btn--line-white jc-lp-btn" href="#services">서비스 보기<x-jc.icon name="arrow-right" /></a>
                </div>
                <div class="jc-lp-stats">
                    <div><span class="jc-lp-stat__num">30초</span><span class="jc-lp-stat__label"><strong>키워드 넣고 순위 확인까지</strong><span>가입 없이 바로</span></span></div>
                    <div><span class="jc-lp-stat__num">0원</span><span class="jc-lp-stat__label"><strong>무료 순위체크 100개</strong><span>분석 월 5회 포함</span></span></div>
                    <div><span class="jc-lp-stat__num">1,200+</span><span class="jc-lp-stat__label"><strong>순위를 확인한 사장님</strong><span>랭크프리 이용 기준</span></span></div>
                </div>
                <p class="jc-lp-small jc-lp-stats__note">랭크프리 현재 안내 기준. 결제 전 최신 가격과 제공량을 확인하세요.</p>
            </div>
            <figure class="jc-lp-hero__art"><img src="{{ asset('images/lp/self-marketing/gpt/hero-rankcheck.webp') }}" alt="랭크프리 순위 확인 화면 예시. ‘성수동 파스타’로 플레이스를 검색해 내 매장이 12위(예시)로 표시된 모습 (추정 순위·공식 순위 아님)" width="1120" height="840" decoding="async"><span class="jc-lp-badge">예시 화면</span></figure>
            <nav class="jc-lp-jump" aria-label="바로가기">
                <a href="#lp-place"><span class="jc-lp-jump__no">01</span><strong>플레이스 순위상승</strong><span>지도·플레이스 검색에서 내 가게가 보이는 위치</span></a>
                <a href="#lp-shopping"><span class="jc-lp-jump__no">02</span><strong>쇼핑 순위상승</strong><span>스마트스토어 상품이 검색되는 위치</span></a>
                <a href="#tools"><span class="jc-lp-jump__no">03</span><strong>무료 순위 확인</strong><span>랭크프리로 지금 몇 등인지 확인</span></a>
            </nav>
        </div>
    </section>

    {{-- ② 01 하는 일 — 머리(fog) + 서비스 띠 2개(전폭 2칸, 이미지 좌우 번갈아) --}}
    <section id="services" class="jc-lp-services" aria-labelledby="lp-services">
        <div class="jc-lp-services__head">
            <div class="jc-wrap jc-lp-head jc-lp-head--solo">
                <span class="jc-lp-label"><b>01</b> 하는 일</span>
                <h2 id="lp-services" class="jc-lp-h2 jc-lp-h2--xl">셀프마케팅으로 무엇을 할 수 있나요?</h2>
            </div>
        </div>
        <article id="lp-place" class="jc-lp-band jc-lp-band--blue" aria-labelledby="lp-place-title">
            <figure class="jc-lp-band__art">
                <span class="jc-lp-phone"><img src="{{ asset('images/lp/self-marketing/real/naver-place-list.webp') }}" srcset="{{ asset('images/lp/self-marketing/real/naver-place-list-600.webp') }} 600w, {{ asset('images/lp/self-marketing/real/naver-place-list.webp') }} 1170w" sizes="(max-width: 1100px) min(242px, calc(68vw - 18px)), 280px" alt="네이버 모바일에서 ‘성수동 파스타’를 검색한 실제 화면. 플레이스 목록에 내 매장(예시)이 파란 테두리로 표시돼 있고, 매장 이름과 사진은 가려져 있다" width="1170" height="2532" loading="lazy" decoding="async"></span>
                <figcaption class="jc-lp-small jc-lp-capnote">실제 네이버 화면 · 2026-11-16 캡처 · 매장 정보 가림</figcaption>
            </figure>
            <div class="jc-lp-band__body">
                <span class="jc-lp-band__no">01 플레이스</span>
                <h3 id="lp-place-title" class="jc-lp-band__title">플레이스 순위상승 캠페인</h3>
                <dl class="jc-lp-dl">
                    <dt>고민</dt><dd>‘지역명 + 업종’으로 검색하면 우리 매장이 잘 보이지 않는다.</dd>
                    <dt>먼저 보는 것</dt><dd>키워드별 플레이스 순위와 상위 경쟁 결과, 그리고 업종·카테고리·영업시간·사진처럼 검색어와 맞아야 하는 매장 정보.</dd>
                    <dt>이렇게 하는 것</dt><dd>제이커브가 운영하는 리워드 앱과 제휴 매체에 매장 찾기 미션을 보내, 실제 사람이 키워드로 검색해 매장을 찾아오게 합니다. 유입·저장·길찾기·복합 중에서 고릅니다.</dd>
                    <dt>받아보는 것</dt><dd>상품에 적힌 제공 항목과 집행량, 진행 전후 같은 조건으로 남기는 순위 기록. 진행 상황은 마이페이지에서 확인합니다.</dd>
                </dl>
                <p class="jc-lp-small">특정 순위나 기간을 보장하지는 않습니다.</p>
                <div class="jc-lp-btns"><a class="jc-btn jc-btn--white jc-lp-btn jc-lp-btn--sm" href="{{ route('self-marketing.order', ['type' => 'place']) }}">광고 시작하기<x-jc.icon name="arrow-right" /></a><a class="jc-lp-link" href="{{ route('self-marketing.place') }}">플레이스 자세히 →</a></div>
            </div>
        </article>
        <article id="lp-shopping" class="jc-lp-band jc-lp-band--dark jc-lp-band--rev" aria-labelledby="lp-shopping-title">
            <figure class="jc-lp-band__art">
                <span class="jc-lp-phone"><img src="{{ asset('images/lp/self-marketing/real/naver-shopping-list.webp') }}" srcset="{{ asset('images/lp/self-marketing/real/naver-shopping-list-600.webp') }} 600w, {{ asset('images/lp/self-marketing/real/naver-shopping-list.webp') }} 1170w" sizes="(max-width: 1100px) min(242px, calc(68vw - 18px)), 280px" alt="네이버 모바일에서 ‘무선 청소기’를 검색한 실제 쇼핑 결과 화면. 내 상품(예시)이 파란 테두리로 표시돼 있고, 상품 이름과 사진은 가려져 있다" width="1170" height="2502" loading="lazy" decoding="async"></span>
                <figcaption class="jc-lp-small jc-lp-capnote">실제 네이버 화면 · 2026-11-16 캡처 · 상품 정보 가림</figcaption>
            </figure>
            <div class="jc-lp-band__body">
                <span class="jc-lp-band__no">02 쇼핑</span>
                <h3 id="lp-shopping-title" class="jc-lp-band__title">쇼핑 순위상승 캠페인</h3>
                <dl class="jc-lp-dl">
                    <dt>고민</dt><dd>스마트스토어 상품이 네이버 쇼핑 검색에서 잘 보이지 않는다.</dd>
                    <dt>먼저 보는 것</dt><dd>상품 순위와 6개월 시장 규모·매출 추정, 그리고 상품명·카테고리·속성이 검색어와 맞는지.</dd>
                    <dt>이렇게 하는 것</dt><dd>리워드 앱과 제휴 매체에 상품 찾기 미션을 보내, 실제 사람이 키워드로 검색해 상품에 들어오게 합니다. 쇼핑 유입·찜·복합 중에서 고릅니다. 구매·구매평·리뷰 작성은 하지 않습니다.</dd>
                    <dt>받아보는 것</dt><dd>상품에 적힌 제공 항목과 집행량, 진행 전후 같은 조건으로 남기는 쇼핑 순위 기록. 진행 상황은 마이페이지에서 확인합니다.</dd>
                </dl>
                <p class="jc-lp-small">상품 정보가 부실하면 네이버 쇼핑 SEO 정비를 먼저 권합니다. 특정 순위나 기간을 보장하지는 않습니다.</p>
                <div class="jc-lp-btns"><a class="jc-btn jc-btn--primary jc-lp-btn jc-lp-btn--sm" href="{{ route('self-marketing.order', ['type' => 'shopping']) }}">광고 시작하기<x-jc.icon name="arrow-right" /></a><a class="jc-lp-link" href="{{ route('self-marketing.shopping') }}">쇼핑 자세히 →</a></div>
            </div>
        </article>
    </section>

    {{-- ③ 02 진행 방식 — 미션 흐름은 self-marketing-place ③(:84-113), 유형 이름은 place:140-143·shopping:143-145, 설명은 order-sample 설명 문구(숫자 제외)·shopping:24 --}}
    <section id="flow" class="jc-section" aria-labelledby="lp-flow">
        <div class="jc-wrap">
            <div class="jc-lp-head">
                <div>
                    <span class="jc-lp-label"><b>02</b> 진행 방식</span>
                    <h2 id="lp-flow" class="jc-lp-h2">리워드 미션은<br>어떻게 진행되나요?</h2>
                </div>
                <p class="jc-lp-text">광고를 등록하면 제이커브가 운영하는 리워드 앱과 제휴 매체에 미션이 올라갑니다. 참여자는 안내된 키워드로 직접 검색해 매장이나 상품을 찾아 들어옵니다.</p>
            </div>
            <div class="jc-lp-cols">
                <div>
                    <span class="jc-lp-num">01</span>
                    <h3 class="jc-lp-card__title">미션 올리기</h3>
                    <p class="jc-lp-body">리워드 앱과 제휴 매체에 매장 찾기·상품 찾기 미션을 보냅니다. 미션 유형은 주문할 때 고른 그대로입니다.</p>
                </div>
                <div>
                    <span class="jc-lp-num">02</span>
                    <h3 class="jc-lp-card__title">검색해서 찾아오기</h3>
                    <p class="jc-lp-body">참여자가 안내된 키워드로 네이버를 검색하고, 미션에 적힌 정보와 같은 매장이나 상품을 골라 들어와 정답을 확인합니다.</p>
                </div>
                <div>
                    <span class="jc-lp-num">03</span>
                    <h3 class="jc-lp-card__title">반응 신호 쌓기</h3>
                    <p class="jc-lp-body">이런 검색·방문 활동이 광고 기간 동안 꾸준히 쌓여 인기도 신호에 도움을 줍니다. 특정 순위나 기간을 보장하지는 않습니다.</p>
                </div>
            </div>
            <div class="jc-lp-proof jc-lp-flow">
                <figure class="jc-lp-flow__mission">
                    <div class="jc-lp-frame jc-lp-mission">
                        <strong class="jc-lp-sub">예시 · 플레이스 매장 찾기 미션</strong>
                        <ol>
                            <li><span class="jc-lp-phone jc-lp-phone--sm"><img src="{{ asset('images/lp/self-marketing/real/naver-search-input.webp') }}" srcset="{{ asset('images/lp/self-marketing/real/naver-search-input-600.webp') }} 600w, {{ asset('images/lp/self-marketing/real/naver-search-input.webp') }} 1170w" sizes="(max-width: 680px) calc(50vw - 52px), (max-width: 1100px) calc(25vw - 40px), 184px" alt="네이버 검색창에 ‘성수동 파스타’를 입력해 자동완성 검색어가 펼쳐진 실제 화면" width="1170" height="1980" loading="lazy" decoding="async"></span><span class="jc-lp-mission__cap">안내받은 키워드로 네이버에서 검색</span></li>
                            <li><span class="jc-lp-phone jc-lp-phone--sm"><img src="{{ asset('images/lp/self-marketing/real/naver-place-pick.webp') }}" srcset="{{ asset('images/lp/self-marketing/real/naver-place-pick-600.webp') }} 600w, {{ asset('images/lp/self-marketing/real/naver-place-pick.webp') }} 1170w" sizes="(max-width: 680px) calc(50vw - 52px), (max-width: 1100px) calc(25vw - 40px), 184px" alt="‘성수동 파스타’ 플레이스 검색 결과에서 미션 정보와 같은 매장(내 매장 예시)을 골라 체크한 실제 화면. 매장 이름과 사진은 가려져 있다" width="1170" height="2316" loading="lazy" decoding="async"></span><span class="jc-lp-mission__cap">미션에 적힌 정보와 같은 매장 고르기</span></li>
                            <li><span class="jc-lp-phone jc-lp-phone--sm"><img src="{{ asset('images/lp/self-marketing/real/naver-place-detail.webp') }}" srcset="{{ asset('images/lp/self-marketing/real/naver-place-detail-600.webp') }} 600w, {{ asset('images/lp/self-marketing/real/naver-place-detail.webp') }} 1170w" sizes="(max-width: 680px) calc(50vw - 52px), (max-width: 1100px) calc(25vw - 40px), 184px" alt="네이버 플레이스 매장 상세 실제 화면. 내 매장(예시)의 ‘소식’ 탭에 정답 찾기 표시가 붙어 있고, 주소·연락처 같은 매장 정보는 가려져 있다" width="1170" height="1866" loading="lazy" decoding="async"></span><span class="jc-lp-mission__cap">매장 상세 정보에서 정답 찾기</span></li>
                            <li>{{-- I7 은 GPT 그림이라 폰이 그려져 있다 — 화면 부분만 잘라 낸 파일을 같은 CSS 틀에 넣어 4칸 모양을 맞춘다(원본 gpt/mission-4-reward.webp 유지) --}}<span class="jc-lp-phone jc-lp-phone--sm"><img src="{{ asset('images/lp/self-marketing/gpt/mission-4-reward-screen.webp') }}" alt="미션 화면 예시: 정답을 입력하고 정답 확인을 누르면 리워드를 받는 단계" width="366" height="594" loading="lazy" decoding="async"></span><span class="jc-lp-badge">예시 화면</span><span class="jc-lp-mission__cap">정답을 입력하면 리워드 지급</span></li>
                        </ol>
                    </div>
                    <figcaption class="jc-lp-small">미션 흐름 예시입니다. 쇼핑은 같은 방식으로 상품을 찾습니다. 1~3은 실제 네이버 화면 · 2026-11-16 캡처 · 매장 정보 가림, 4는 예시 화면입니다.</figcaption>
                </figure>
                <div class="jc-lp-types">
                    <h3 class="jc-lp-sub">플레이스 유형</h3>
                    <dl class="jc-lp-dl">
                        <dt>플레이스 유입</dt><dd>검색해서 매장에 들어오는 행동</dd>
                        <dt>플레이스 저장</dt><dd>매장을 저장하는 행동</dd>
                        <dt>플레이스 길찾기</dt><dd>매장까지 길찾기를 누르는 행동</dd>
                        <dt>플레이스 복합</dt><dd>유입·저장·길찾기를 함께 진행</dd>
                    </dl>
                    <h3 class="jc-lp-sub">쇼핑 유형</h3>
                    <dl class="jc-lp-dl">
                        <dt>쇼핑 유입</dt><dd>안내된 키워드로 네이버 쇼핑을 검색해 상품 상세에 들어오는 행동</dd>
                        <dt>쇼핑 찜</dt><dd>상품을 찜 목록에 담는 행동</dd>
                        <dt>쇼핑 복합</dt><dd>유입과 찜을 함께 진행</dd>
                    </dl>
                    <p class="jc-lp-small">실제로 주문할 수 있는 유형과 조건은 주문 화면의 상품표를 따릅니다.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ③-1 매체 — 제휴 리워드 네트워크와 연결된 매체(대웅 확인 2026-10-27, partials/jc/partner-band). 파일은 그대로, 모양만 .jc-lp 범위 CSS --}}
    @include('partials.jc.partner-band')

    {{-- ④ 03 분석 도구 — 흰 바탕 카드 2개(큰 칸에 화면 목업) + 순위 확인 폼은 아래 검정 띠 --}}
    <section id="tools" class="jc-section" aria-labelledby="lp-tools">
        <div class="jc-wrap">
            <div class="jc-lp-head">
                <div>
                    <span class="jc-lp-label"><b>03</b> 분석 도구</span>
                    <h2 id="lp-tools" class="jc-lp-h2">순위는 랭크프리로<br>먼저 잽니다</h2>
                </div>
                <p class="jc-lp-text">랭크프리는 네이버 플레이스·쇼핑·블로그 순위를 확인하고 상위 결과와 비교하는 분석 도구입니다. 키워드만 넣으면 가입 없이 바로 확인할 수 있습니다.</p>
            </div>
            <ol class="jc-lp-proofs">
                <li class="jc-lp-proof">
                    <figure class="jc-lp-frame jc-lp-proof__art"><img src="{{ asset('images/lp/self-marketing/gpt/tools-rank.webp') }}" alt="랭크프리 순위 기록 화면 예시. ‘성수동 파스타’ 키워드를 모바일·같은 위치·같은 시간대 조건으로 7번 기록한 그래프와 표(14위 안팎, 예시) (추정 순위·공식 순위 아님)" width="1840" height="1456" loading="lazy" decoding="async"><span class="jc-lp-badge">예시 화면</span></figure>
                    <div class="jc-lp-proof__body"><span class="jc-lp-num">01</span><strong class="jc-lp-card__title">현재 순위 기록</strong><span class="jc-lp-body">키워드별 노출 위치를 확인해 감으로만 알던 현재 상태를 기록합니다. 캠페인을 시작하기 전 기준선이 됩니다.</span></div>
                </li>
                <li class="jc-lp-proof jc-lp-proof--rev">
                    <figure class="jc-lp-frame jc-lp-proof__art">
                        <picture>
                            <source media="(max-width: 680px)" srcset="{{ asset('images/lp/self-marketing/gpt/tools-compare-m.webp') }}" width="1400" height="2600">
                            <img src="{{ asset('images/lp/self-marketing/gpt/tools-compare.webp') }}" alt="상위 결과 비교 화면 예시. 플레이스는 상위 결과 3곳과 내 매장의 업종·카테고리·영업시간·사진·소식을 비교하고, 쇼핑은 6개월 시장 규모와 매출 추정을 막대와 선으로 보여 준다(예시)" width="2640" height="1440" loading="lazy" decoding="async">
                        </picture>
                        <span class="jc-lp-badge">예시 화면</span>
                    </figure>
                    <div class="jc-lp-proof__body"><span class="jc-lp-num">02</span><strong class="jc-lp-card__title">상위 결과와 비교</strong><span class="jc-lp-body">플레이스는 상위 경쟁 결과를, 쇼핑은 6개월 시장 규모·매출 추정을 함께 봅니다. 무엇을 먼저 정비할지 정하는 데 씁니다.</span></div>
                </li>
            </ol>
            <div class="jc-lp-rankband jc-bg-dark">
                <div>
                    <p class="jc-lp-notice">랭크프리 순위는 네이버 공식 순위가 아닌 추정치입니다. 자체 수집·분석 기반의 정보이며, 검색 시점·기기·위치에 따라 직접 본 결과와 다를 수 있습니다.</p>
                    <a class="jc-lp-link" href="{{ route('solutions.rankfree') }}">랭크프리 자세히 보기</a>
                </div>
                @include('partials.jc.rank-form', ['variant' => 'stack'])
            </div>
        </div>
    </section>

    {{-- ⑤ 04 진단 기준 --}}
    <section class="jc-section" aria-labelledby="lp-criteria">
        <div class="jc-wrap">
            <div class="jc-lp-head jc-lp-head--solo">
                <span class="jc-lp-label"><b>04</b> 진단 기준</span>
                <h2 id="lp-criteria" class="jc-lp-h2">순위를 올리기 전에<br>무엇을 보나요?</h2>
            </div>
            <div class="jc-lp-cols">
                <div>
                    <img class="jc-lp-cols__ico" src="{{ asset('images/lp/self-marketing/gpt/criteria-keyword.webp') }}" alt="" width="48" height="48" loading="lazy" decoding="async">
                    <span class="jc-lp-num">01</span>
                    <h3 class="jc-lp-card__title">키워드</h3>
                    <p class="jc-lp-body">검색량만 큰 단어보다 실제 고객이 검색하는 ‘지역명 + 업종’이나 상품 키워드를 고르고, 순위를 기록할 메인 키워드 하나를 정합니다.</p>
                </div>
                <div>
                    <img class="jc-lp-cols__ico" src="{{ asset('images/lp/self-marketing/gpt/criteria-status.webp') }}" alt="" width="48" height="48" loading="lazy" decoding="async">
                    <span class="jc-lp-num">02</span>
                    <h3 class="jc-lp-card__title">현재 상태</h3>
                    <p class="jc-lp-body">랭크프리로 지금 순위를 기록하고, 업종·카테고리·상품명·속성처럼 검색어와 맞아야 하는 정보가 정비돼 있는지 봅니다. 어긋나 있으면 정비를 먼저 권합니다.</p>
                </div>
                <div>
                    <img class="jc-lp-cols__ico" src="{{ asset('images/lp/self-marketing/gpt/criteria-track.webp') }}" alt="" width="48" height="48" loading="lazy" decoding="async">
                    <span class="jc-lp-num">03</span>
                    <h3 class="jc-lp-card__title">비교와 추적</h3>
                    <p class="jc-lp-body">상위 결과와 비교할 항목을 보고, 진행 전후 순위를 같은 조건으로 기록합니다. 순위 변동만으로 원인을 단정하지 않고 문의·방문·매출 자료와 함께 봅니다.</p>
                </div>
            </div>
            <ul class="jc-lp-links" aria-label="관련 안내">
                <li><a class="jc-lp-chip" href="{{ route('self-marketing.place') }}#pl-rank">네이버 플레이스 순위는 무엇으로 정해지나요? →</a></li>
                <li><a class="jc-lp-chip" href="{{ route('self-marketing.shopping') }}#sh-rank">네이버 쇼핑 순위는 무엇으로 정해지나요? →</a></li>
                <li><a class="jc-lp-chip" href="{{ route('solutions.rankfree') }}#limits">랭크프리 데이터 읽는 법 →</a></li>
                <li><a class="jc-lp-chip" href="{{ route('support.faq') }}#faq-self">셀프마케팅 자주 묻는 질문 전체 →</a></li>
            </ul>
        </div>
    </section>

    {{-- ⑥ 05 직접 주문의 장점 — self-marketing-place ⑥(:177-180) 사실을 다시 씀 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="lp-why">
        <div class="jc-wrap">
            <div class="jc-lp-head jc-lp-head--solo">
                <span class="jc-lp-label"><b>05</b> 직접 주문의 장점</span>
                <h2 id="lp-why" class="jc-lp-h2">직접 주문하면<br>무엇이 다른가요?</h2>
            </div>
            <div class="jc-lp-grid2">
                <div><x-jc.icon name="self" class="jc-lp-grid2__ico" /><h3 class="jc-lp-card__title">정하는 사람이 <span class="jc-blue">사장님</span></h3><p class="jc-lp-body">매장·키워드·수량·기간을 직접 고르고 그 자리에서 등록합니다. 견적이 나오기를 기다릴 필요가 없습니다.</p></div>
                <div><x-jc.icon name="apps" class="jc-lp-grid2__ico" /><h3 class="jc-lp-card__title">미션이 도는 앱을 <span class="jc-blue">직접 운영</span></h3><p class="jc-lp-body">제이커브는 꼬꼬농장·당근캐시 등 리워드 앱 12종을 직접 개발하고 운영하며, 미션이 실행되는 매체를 직접 관리합니다.</p></div>
                <div><x-jc.icon name="rankfree" class="jc-lp-grid2__ico" /><h3 class="jc-lp-card__title">집행량과 순위를 <span class="jc-blue">기록으로</span></h3><p class="jc-lp-body">상품에 적힌 제공 항목과 집행량, 그리고 같은 조건으로 남기는 순위 기록을 약속합니다.</p></div>
                <div><x-jc.icon name="calendar" class="jc-lp-grid2__ico" /><h3 class="jc-lp-card__title">시간 맞출 필요 없는 <span class="jc-blue">24시간 주문</span></h3><p class="jc-lp-body">상담 시간을 기다리지 않고 사이트에서 언제든 주문합니다. 등록한 광고는 다음 날부터 진행됩니다.</p></div>
            </div>
        </div>
    </section>

    {{-- ⑦ 06 시작 방법 — 주문 화면(self-marketing-order) 4단계 중 일정 설정·최종 확인을 한 단계로 묶었다. 1단계 이름은 주문 화면 표시(:91, jc.js:613)와 같게.
         2단계 권장 범위는 상품에 guide 값이 있을 때만 주문 화면에 보인다(jc.js:542) — 그래서 조건부로 쓴다(2026-11-16 검토 보완) --}}
    <section class="jc-section" aria-labelledby="lp-start">
        <div class="jc-wrap">
            <div class="jc-lp-split jc-lp-split--start">
                <div class="jc-lp-split__side">
                    <span class="jc-lp-label"><b>06</b> 시작 방법</span>
                    <h2 id="lp-start" class="jc-lp-h2">세 단계로 시작하세요</h2>
                    <p class="jc-lp-small jc-lp-start__note">주문 화면에서는 일정 설정과 최종 확인이 나뉘어 매장 정보 입력(쇼핑은 상품 정보 입력) → 광고 설정 → 일정 설정 → 최종 확인 4단계로 보입니다.</p>
                    <div class="jc-lp-btns"><a class="jc-btn jc-btn--primary jc-lp-btn" href="{{ route('self-marketing.order') }}">광고 시작하기<x-jc.icon name="arrow-right" /></a></div>
                    <figure class="jc-lp-start__art"><img src="{{ asset('images/lp/self-marketing/gpt/order-steps.webp') }}" alt="주문 화면 예시. 매장 정보 입력·광고 설정을 마치고 3단계 일정 설정에서 광고 기간 10일(인기)을 고른 모습. 마지막 4단계는 최종 확인" width="872" height="1088" loading="lazy" decoding="async"><span class="jc-lp-badge">예시 화면</span></figure>
                </div>
                <ol class="jc-lp-steps">
                    <li><span class="jc-lp-steps__no" aria-hidden="true">1</span><strong class="jc-lp-step__title">매장(상품) 정보 입력</strong><span class="jc-lp-body">상호명이나 플레이스 URL, 상품명이나 상품 URL로 광고할 매장(상품)을 찾습니다.</span></li>
                    <li><span class="jc-lp-steps__no" aria-hidden="true">2</span><strong class="jc-lp-step__title">광고 설정</strong><span class="jc-lp-body">광고 유형을 고르고, 순위를 기록할 메인 키워드 하나와 하루 목표 수를 정합니다. 주문 화면에 경쟁도별 권장 범위가 표시되면 참고하고, 필요하면 요청사항도 남길 수 있습니다(선택).</span></li>
                    <li><span class="jc-lp-steps__no" aria-hidden="true">3</span><strong class="jc-lp-step__title">일정 설정·주문</strong><span class="jc-lp-body">광고 기간을 고르고, 최종 확인에서 금액을 본 뒤 로그인해 주문합니다. 등록한 광고는 다음 날부터 진행됩니다.</span></li>
                </ol>
            </div>
            <blockquote class="jc-lp-quote">
                <p>제이커브는 특정 순위·기간·매출을 보장하지 않습니다.</p>
                <p>약속하는 것은 상품 페이지에 적힌 제공 항목과 집행량, 그리고 같은 조건으로 남기는 순위 기록입니다.</p>
            </blockquote>
        </div>
    </section>

    {{-- ⑧ 07 주의사항 — 근거: self-marketing-shopping:25·129, self-marketing-place:147, self-marketing:168, PLAN-FINAL:95.
         첫 칸은 근거가 쇼핑 FAQ(shopping:25)뿐이라 쇼핑 범위로 좁혔다. 둘째 칸 권장 범위는 guide 값이 있을 때만 보이므로 조건부(jc.js:542) — 2026-11-16 검토 보완 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="lp-care">
        <div class="jc-wrap">
            <div class="jc-lp-head jc-lp-head--solo">
                <span class="jc-lp-label"><b>07</b> 주의사항</span>
                <h2 id="lp-care" class="jc-lp-h2">주문 전에 꼭 확인하세요</h2>
            </div>
            <div class="jc-lp-cols jc-lp-cols--4">
                <div><h3 class="jc-lp-step__title">쇼핑 구매·리뷰는 만들지 않습니다</h3><p class="jc-lp-body">쇼핑 캠페인에서 구매·구매평·리뷰 작성은 제공하지 않습니다. 플랫폼 정책 위반 소지가 크고 상품과 스토어에 불이익이 생길 수 있기 때문입니다.</p></div>
                <div><h3 class="jc-lp-step__title">하루 목표 수는 권장 범위가 보이면 그 안에서</h3><p class="jc-lp-body">주문 화면에 경쟁도별 권장 범위가 표시되면 그 안에서 정하세요. 무리한 수량은 오히려 신뢰도에 부담이 될 수 있습니다.</p></div>
                <div><h3 class="jc-lp-step__title">이상 신호가 보이면 멈춥니다</h3><p class="jc-lp-body">정책 경고나 비정상적인 순위 변동이 보이면 진행을 멈추고 함께 확인합니다.</p></div>
                <div><h3 class="jc-lp-step__title">참여와 성과는 따로 봅니다</h3><p class="jc-lp-body">실제 사람이 참여한다는 사실만으로 모든 플랫폼 정책을 충족한다고 말할 수 없습니다. 참여 수량·검색 순위·매출은 서로 다른 지표입니다.</p></div>
            </div>
        </div>
    </section>

    {{-- ⑨ 08 자주 묻는 질문 — 왼쪽 제목, 오른쪽 목록. 앞 번호는 장식(aria-hidden) --}}
    <section class="jc-section" aria-labelledby="lp-faq">
        <div class="jc-wrap jc-lp-split jc-lp-split--faq">
            <div class="jc-lp-split__side">
                <span class="jc-lp-label"><b>08</b> 자주 묻는 질문</span>
                <h2 id="lp-faq" class="jc-lp-h2 jc-lp-h2--sm">시작 전에 많이 묻는 질문</h2>
            </div>
            <div class="jc-lp-faq">
                @foreach ($lpFaqs as $i => $f)
                    <details @if ($i === 0) open @endif><summary><span class="jc-lp-faq__no" aria-hidden="true">{{ sprintf('%02d', $i + 1) }}</span><span class="jc-lp-faq__q">{{ $f['q'] }}</span></summary><p class="jc-lp-faq__a">{{ $f['a'] }}</p></details>
                @endforeach
                <a class="jc-lp-link jc-lp-faq__more" href="{{ route('support.faq') }}#faq-self">자주 묻는 질문 전체 보기 →</a>
            </div>
        </div>
    </section>

    {{-- ⑩ 마무리 --}}
    <section class="jc-lp-ctaband jc-bg-dark" aria-labelledby="lp-cta">
        <div class="jc-wrap jc-lp-cta">
            <div>
                <h2 id="lp-cta" class="jc-lp-cta__title">어디서부터 시작할지<br>고민되시나요?</h2>
                <p class="jc-lp-text">매장이나 상품을 찾고 키워드와 기간만 정하면 됩니다. 막히는 부분은 카카오로 바로 물어보세요.</p>
            </div>
            <div class="jc-lp-cta__btns">
                <a class="jc-btn jc-btn--primary jc-lp-btn" href="{{ route('self-marketing.order') }}">광고 시작하기<x-jc.icon name="arrow-right" /></a>
                <a class="jc-btn jc-btn--kakao jc-lp-btn" href="{{ $jcKakao ?: route('contact') }}" @if ($jcKakao) target="_blank" rel="noopener" @endif><x-jc.icon name="kakao" />카카오 상담</a>
            </div>
        </div>
    </section>
</div>
@endsection
