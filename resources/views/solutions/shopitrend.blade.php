@extends('layouts.app')

{{--
    운영 서비스 소개 — 쇼피트렌드 (신규, 2026-10-27)
    - 대웅 지시: 제이커브가 운영하는 서비스 → 소개 페이지 + 실제 서비스(https://shopitrend.co) 링크.
    - 문구 근거: docs/research/RESEARCH-REA-2026-10-27.md ④ 쇼피트렌드 공개 화면 관측(메뉴·판매 채널),
      현재 라이브 사이트 푸터 표기 '쇼피트렌드 마케팅 플랫폼'. 가격·적립금 정책 등 미확인 정보는 쓰지 않았다.
    - ⚠️ 초안: 대웅 검수 후 확정. 기존 서비스 소개 페이지와 같은 틀(landing)이라 같은 새 톤이 적용된다.
--}}

@section('title', '쇼피트렌드 — 플레이스·쇼핑·SNS 마케팅을 직접 주문하는 플랫폼 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="제이커브가 운영하는 셀프 마케팅 플랫폼 쇼피트렌드. 네이버 플레이스·N쇼핑·쿠팡·오늘의집·카카오 선물하기 리워드 광고와 인스타그램·유튜브 SNS 광고를 주문하고, 광고 관리·순위체크·키워드 분석까지 한곳에서 확인합니다.">
@endsection

@section('content')
    <main class="landing">
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위"><a href="{{ route('solutions.index') }}">운영 서비스</a></nav>
                <span class="landing__eyebrow">Shopitrend</span>
                <h1>플레이스·쇼핑·SNS 마케팅을<br>직접 주문하고 관리하는 플랫폼</h1>
                <p class="landing__lead">쇼피트렌드는 제이커브가 운영하는 셀프 마케팅 플랫폼입니다. 네이버 플레이스·N쇼핑·쿠팡·오늘의집·카카오 선물하기 리워드 광고와 인스타그램·유튜브 SNS 광고를 한곳에서 주문하고, 광고 관리·순위체크·키워드 분석까지 이어서 확인합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://shopitrend.co" target="_blank" rel="noopener">쇼피트렌드 바로가기 ↗</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">도입 상담</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="쇼피트렌드 페이지 바로가기">
            <div class="landing__local-nav-inner">
                <a href="#features">주요 기능</a>
                <a href="#channels">다루는 채널</a>
                <a href="#fit">이런 분께 맞습니다</a>
                <a href="#notice">이용 전 확인</a>
            </div>
        </nav>

        <section class="landing__section landing__section--light" id="features">
            <div class="landing__inner">
                <span class="landing__eyebrow">주요 기능</span>
                <h2 class="landing__head">주문부터 순위 확인까지, 한 화면의 동선으로</h2>
                <p class="landing__lead">반복해서 주문하고 결과를 확인하는 운영자의 작업 순서대로 메뉴가 나뉘어 있습니다.</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light">
                        <strong>주문하기</strong>
                        <span>채널별 리워드 광고와 SNS 광고 상품을 골라 직접 주문합니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>광고 관리</strong>
                        <span>진행 중인 주문과 광고 상태를 한곳에서 확인하고 관리합니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>분석 서비스</strong>
                        <span>키워드 분석과 블로그 지수로 집행 전에 시장과 채널 상태를 살펴봅니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>순위체크</strong>
                        <span>플레이스·블로그·웹문서 순위를 확인해 집행 전후를 같은 기준으로 비교합니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>적립금 충전</strong>
                        <span>적립금을 충전해 두고 필요할 때마다 주문에 사용합니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>파트너 관리</strong>
                        <span>여러 고객사를 운영하는 대행사는 하부 업체의 충전 요청과 주문 흐름을 함께 관리합니다.</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark" id="channels">
            <div class="landing__inner">
                <span class="landing__eyebrow">다루는 채널</span>
                <h2 class="landing__head">검색·커머스·SNS, 고객이 찾는 자리마다</h2>
                <p class="landing__lead">채널마다 노출되는 방식과 확인할 지표가 다릅니다. 쇼피트렌드는 채널별로 상품을 나눠 주문하고 결과를 확인합니다.</p>
                <div class="landing__chips">
                    <span>네이버 플레이스</span>
                    <span>N쇼핑</span>
                    <span>쿠팡</span>
                    <span>오늘의집</span>
                    <span>카카오 선물하기</span>
                    <span>인스타그램</span>
                    <span>유튜브</span>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">이런 분께 맞습니다</span>
                <h2 class="landing__head">직접 주문하는 사장님부터, 여러 고객사를 맡은 대행사까지</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>사장님·셀러</h3>
                        <p>대행을 맡기기보다 필요한 채널과 수량을 직접 정해 주문하고, 순위체크로 변화를 확인하고 싶은 경우에 맞습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>마케팅 대행사</h3>
                        <p>여러 고객사의 캠페인을 반복 주문하고, 파트너 관리로 하부 업체의 충전과 주문을 함께 운영하는 경우에 맞습니다.</p>
                    </article>
                </div>
                <p class="landing__body" style="margin-top:28px">처음이라 무엇부터 해야 할지 모르겠다면 <a href="{{ route('self-marketing') }}">제이커브 셀프마케팅</a>에서 순위 확인부터 시작하거나, <a href="{{ route('contact') }}">상담</a>으로 맞는 방식을 함께 정할 수 있습니다.</p>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="notice">
            <div class="landing__inner">
                <span class="landing__eyebrow">이용 전 확인</span>
                <h2 class="landing__head">주문 전에 확인해 주세요</h2>
                <ul class="landing__evidence">
                    <li>상품 구성, 가격, 적립금 정책은 쇼피트렌드의 현재 안내를 기준으로 합니다.</li>
                    <li>광고 집행은 특정 기간 안의 특정 순위나 매출을 보장하지 않습니다.</li>
                    <li>순위체크와 분석 값은 판단을 돕는 참고 정보이며, 검색엔진과 플랫폼의 공식 지표가 아닙니다.</li>
                </ul>
            </div>
        </section>

        <section class="landing__cta">
            <div class="landing__cta-inner">
                <h2>필요한 채널부터,<br>쇼피트렌드에서 바로 시작하세요</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="https://shopitrend.co" target="_blank" rel="noopener">쇼피트렌드 바로가기 ↗</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">도입 상담</a>
                </div>
            </div>
        </section>
    </main>
@endsection
