@extends('layouts.app')

{{--
    오퍼월 — 「오퍼월」 키워드 1순위 담당 페이지 (SEO-KW-03, 2026-11-16 대표님 지시 「"오퍼월" 이 키워드에 노출되어야 해」)
    - 검색 의도 3가지를 한 페이지에서 답한다: ① 오퍼월이란(정보형) ② 앱 운영사의 오퍼월 도입·앱 수익화 ③ 광고주의 오퍼월 광고 집행.
    - 사실 근거: services/reward-network(오퍼월 정의·지면 형태·매체 온보딩·측정·품질 기준·FAQ), pages/home(매체사 오퍼월 수익화),
      database/content/kw01/05-offerwall.html(CPI·CPA·CPE 표·도입 전 확인 항목), 공개 API 문서 https://api.j-curve.co.kr/docs/ (2026-09-22판)·
      /docs/missions/ (2026-09-01판) — 2026-11-16 읽음, 미션 허브·서버 적립 구조의 일반 설명에만 씀.
    - 새 숫자·단가·수익률·정산 주기·제휴사 이름·SDK 제공 여부는 쓰지 않는다(근거 없음 → 팀장 확인 필요 목록). 수익·물량 보장은 부정문만.
    - reward-network 문장은 그대로 옮기지 않고 같은 용어로 새로 썼다(중복 콘텐츠 방지). 화면 부품은 reward-network 와 같은 landing__* 클래스.
--}}

@php
    $faqs = [
        ['question' => '오퍼월이란 무엇인가요?', 'answer' => '오퍼월은 앱 안에서 여러 보상형 광고를 한 화면에 목록으로 보여 주는 전용 지면입니다. 유저가 마음에 드는 미션을 직접 골라 조건을 채우면 포인트나 앱 재화가 쌓이는 방식입니다. 앱 운영사는 광고 수익을 나눠 받고, 광고주는 완료가 확인된 액션에 대해서만 비용을 냅니다.'],
        ['question' => '오퍼월과 리워드 광고는 어떻게 다른가요?', 'answer' => '리워드 광고는 보상을 주고 정해진 행동을 요청하는 광고 방식 전체를 가리킵니다. 오퍼월은 그런 리워드 광고를 여러 개 모아 유저가 직접 고르게 하는 앱 안의 지면입니다. 같은 리워드 광고라도 기존 포인트 메뉴에 한 건씩 붙이는 미션 카드형이나 기간 한정 프로모션형으로 실을 수도 있습니다.'],
        ['question' => '오퍼월 수익은 무엇에 따라 달라지나요?', 'answer' => '오퍼월을 앱 어디에 두는지, 앱을 쓰는 이용자가 어떤 사람들인지, 유저가 미션에 얼마나 참여하는지, 광고가 어떤 조건에서 승인되는지에 따라 달라집니다. 그래서 정해진 금액을 미리 말씀드리지 않고 수익을 보장하지도 않습니다. 제휴 검토 단계에서 지면 위치와 보상 안내 방식부터 함께 정하고, 오픈 뒤에는 참여율과 승인 이슈를 보며 캠페인 구성을 조정합니다.'],
        ['question' => '오퍼월을 붙이려면 SDK가 꼭 있어야 하나요?', 'answer' => '앱 구조와 개발 환경에 따라 다릅니다. 기존 지면을 활용할 수 있는지, 웹뷰나 서버 연동이 가능한지, 보상을 어떻게 처리하는지를 먼저 확인하고 그 결과로 개발 범위와 테스트 절차를 정합니다.'],
        ['question' => '광고주는 오퍼월 광고비를 어떤 기준으로 내나요?', 'answer' => '설치(CPI), 회원가입 같은 지정 액션(CPA), 앱 안 참여(CPE)처럼 목표 액션을 정하고, 집행 전에 합의한 유효 기준을 통과한 액션만큼 정산합니다. 단가와 가능 여부는 업종, 미션 난이도, 검수 방식에 따라 달라집니다.'],
        ['question' => '오퍼월 캠페인 품질은 어떤 기준으로 보나요?', 'answer' => '집행 전에 신규·중복 판별 기준, 반드시 끝내야 하는 완료 조건, 참여부터 완료까지 인정하는 기간을 문서로 정해 두고 그 기준을 통과한 참여만 승인합니다. 설치에서 멈추지 않고 회원가입·튜토리얼·특정 단계 도달처럼 다음 행동까지 미션을 나누면 캠페인 목적에 맞는 참여인지 더 분명하게 볼 수 있습니다. 처음에는 작은 규모로 승인율과 후속 행동을 확인한 뒤 확대를 정합니다.'],
    ];
    $publisherContact = route('contact', ['service_interest' => 'reward-publisher', 'message' => '앱에 오퍼월 도입을 문의합니다. 서비스와 이용자, 희망 지면을 상담하고 싶습니다.']);
    $advertiserContact = route('contact', ['service_interest' => 'reward-advertiser', 'message' => '오퍼월 광고 집행을 문의합니다. 목표 액션과 일정, 예산 범위를 상담하고 싶습니다.']);
@endphp

@section('title', '오퍼월 — 앱 수익화 오퍼월 도입과 광고 집행 | 제이커브인터렉티브')
{{-- 위치 경로·서비스 구조화 데이터(head 에서 조립) + FAQPage(화면 FAQ 와 같은 배열) --}}
@section('sd_page', '오퍼월')
@section('sd_crumbs', '서비스=/services|리워드 광고·오퍼월=/services/reward-network')
@section('sd_service', '오퍼월')
@section('meta')
    <meta name="description" content="오퍼월은 앱 안에 보상형 광고 미션 목록을 여는 지면입니다. 앱 운영사의 오퍼월 도입과 앱 수익화, 광고주의 CPI·CPA·CPE 오퍼월 광고 집행, 유효 전환 기준과 정산 흐름을 한 페이지에 정리했습니다.">
@endsection
@include('partials.jc.schema-faq', ['items' => $faqs])

@section('content')
    <main class="landing">
        <section class="landing__hero landing__hero--media">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                <div class="landing__hero-mark"><span class="icon3d icon-il">@include('partials.icon', ['name' => 'reward'])</span></div>
                <span class="landing__eyebrow">Offerwall</span>
                <h1>오퍼월, 앱 운영사와 광고주가<br>같은 기준으로 쓰는 보상형 광고 지면</h1>
                <p class="landing__lead">오퍼월(Offerwall)은 앱 안에 광고 미션을 목록으로 모아 보여 주는 보상형 광고 지면입니다. 유저가 앱 설치·회원가입·미션 같은 광고를 골라 완료하면 포인트나 앱 재화를 받고, 앱 운영사는 광고 수익을 나눠 받으며, 광고주는 완료가 확인된 액션만큼 비용을 냅니다.</p>
                <div class="landing__chips">
                    <span style="color:var(--ink);border-color:var(--hairline);">오퍼월 도입</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">앱 수익화</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">CPI</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">CPA</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">CPE</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">유효 전환 기준</span>
                </div>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ $publisherContact }}">오퍼월 도입 문의</a>
                    <a class="btn-ghost" href="{{ $advertiserContact }}">오퍼월 광고 집행 문의</a>
                </div>
                </div>
                <figure class="jc-nc-hero">@include('partials.jc.nc.hero', ['name' => 'reward'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="오퍼월 페이지 바로가기">
            <div class="landing__local-nav-inner">
                <a href="#what">오퍼월이란</a>
                <a href="#flow">동작 흐름</a>
                <a href="#publishers">앱 운영사</a>
                <a href="#settlement">정산</a>
                <a href="#advertisers">광고주</a>
                <a href="#validity">유효 전환</a>
                <a href="#process">진행 절차</a>
                <a href="#faq">FAQ</a>
            </div>
        </nav>

        {{-- ① 정보형 — 오퍼월이란 --}}
        <section class="landing__section landing__section--light" id="what">
            <div class="landing__inner">
                <span class="landing__eyebrow">What is Offerwall</span>
                <h2 class="landing__head">오퍼월이란 무엇인가요?</h2>
                <p class="landing__lead">오퍼월은 리워드 광고를 싣는 지면 가운데 하나입니다. 유저가 보상을 받으려고 스스로 들어와 여러 미션을 둘러보고 고른다는 점이 다른 지면과 다릅니다.</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light">
                        <strong>리워드 광고와의 관계</strong>
                        <p>리워드 광고는 보상을 주고 행동을 요청하는 광고 방식 전체이고, 오퍼월은 그 광고들을 목록으로 모아 보여 주는 앱 안의 전용 화면입니다.</p>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>유저가 하는 일</strong>
                        <p>목록에서 앱 설치·회원가입·미션처럼 원하는 광고를 고르고, 조건을 채우면 포인트나 앱 재화를 받습니다.</p>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>앱 운영사가 얻는 것</strong>
                        <p>인앱 결제를 하지 않는 유저에게서도 광고 수익을 기대할 수 있고, 받은 재화를 앱 안에서 쓰게 하면 다시 들어올 이유가 생깁니다.</p>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>광고주가 얻는 것</strong>
                        <p>노출이나 클릭이 아니라 설치·가입·앱 안 참여처럼 확인할 수 있는 액션에 비용을 씁니다.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 동작 흐름 — 유저·앱·광고주 --}}
        <section class="landing__section landing__section--parchment" id="flow">
            <div class="landing__inner">
                <span class="landing__eyebrow">How It Works</span>
                <h2 class="landing__head">오퍼월은 어떤 순서로 움직이나요?</h2>
                <p class="landing__lead">유저의 참여 한 건이 광고주의 비용, 앱 운영사의 수익, 유저의 보상으로 나뉘기까지 같은 완료 기록을 기준으로 처리합니다.</p>
                <div class="steps">
                    <div class="steps__item"><strong>앱이 오퍼월에 캠페인 목록을 띄웁니다</strong><p>앱 운영사가 정한 위치에 진행 중인 광고 미션이 모여 보입니다.</p></div>
                    <div class="steps__item"><strong>유저가 미션을 골라 참여합니다</strong><p>미션 내용과 받을 보상, 지급 조건을 보고 직접 선택합니다.</p></div>
                    <div class="steps__item"><strong>완료 여부를 확인합니다</strong><p>광고주 쪽 전환 이벤트나 미리 합의한 확인 방식으로 미션이 끝났는지 전달받습니다.</p></div>
                    <div class="steps__item"><strong>유효 기준으로 검수합니다</strong><p>신규 여부, 중복 참여, 필수 단계, 인정 기간처럼 집행 전에 정한 기준과 대조해 승인·대기·무효를 나눕니다.</p></div>
                    <div class="steps__item"><strong>보상을 지급하고 정산합니다</strong><p>승인된 참여를 기준으로 유저에게 보상을, 앱 운영사에 광고 수익을 반영하고 광고주와 정산합니다.</p></div>
                </div>
            </div>
        </section>

        {{-- ② 앱 운영사 — 도입 효과 --}}
        <section class="landing__section landing__section--dark has-orb" id="publishers">
            <div class="landing__inner">
                <span class="landing__eyebrow">For App Publishers</span>
                <h2 class="landing__head">앱 운영사는 오퍼월 도입으로 무엇을 얻나요?</h2>
                <p class="landing__lead">오퍼월은 앱에 광고 화면을 하나 더 붙이는 일보다, 이용 흐름 안에 수익 구조를 넣는 일에 가깝습니다. 그래서 어디에 두고 어떻게 안내할지를 먼저 정합니다.</p>
                <div class="landing__points">
                    <div class="landing__point"><strong>결제하지 않는 유저의 수익화</strong><span>인앱 결제를 하지 않는 유저도 광고 미션에 참여하면 앱에 광고 수익이 생깁니다.</span></div>
                    <div class="landing__point"><strong>재화 사용처와 연결</strong><span>오퍼월에서 받은 포인트나 재화를 앱 안에서 쓰게 하면 체류·재방문 흐름과 이어집니다.</span></div>
                    <div class="landing__point"><strong>검수·CS·정산 기준</strong><span>제이커브는 리워드 앱 12종을 직접 개발·운영하며 만든 검수·CS·정산 기준으로 매체 운영을 함께 봅니다.</span></div>
                    <div class="landing__point"><strong>광고 피로 관리</strong><span>앱의 핵심 행동과 겹치는 위치를 피하고, 미션 조건과 승인 상태를 유저에게 어떻게 보여 줄지 설계합니다.</span></div>
                </div>
                <p class="landing__note">오퍼월 수익은 이용자 구성, 지면 위치, 참여율과 승인 조건에 따라 달라지며 고정 수익을 보장하지 않습니다.</p>
            </div>
        </section>

        {{-- 앱 운영사 — 도입 방식 --}}
        <section class="landing__section landing__section--light" id="integration">
            <div class="landing__inner">
                <span class="landing__eyebrow">How to Integrate</span>
                <h2 class="landing__head">오퍼월은 어떤 방식으로 도입하나요?</h2>
                <p class="landing__lead">오퍼월 전용 화면을 새로 열 수도 있고, 이미 있는 포인트 메뉴 안에 미션을 넣을 수도 있습니다. 서비스 성격에 맞는 형태를 고른 뒤 연동 범위를 정합니다.</p>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr><th scope="col">형태</th><th scope="col">유저에게 보이는 모습</th><th scope="col">먼저 정할 것</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">오퍼월형</th><td>보상을 받으려는 유저가 직접 들어와 여러 미션을 고르는 전용 화면</td><td>진입 위치, 목록 안내 문구, 보상 표시 방식</td></tr>
                            <tr><th scope="row">미션 카드형</th><td>출석·이벤트·포인트 메뉴 같은 기존 화면 안에 붙는 개별 미션</td><td>기존 리워드 정책과의 관계, 노출 순간</td></tr>
                            <tr><th scope="row">프로모션형</th><td>기간과 목적을 정해 여는 한정 캠페인이나 공동 이벤트</td><td>기간, 대상, 종료 후 안내</td></tr>
                            <tr><th scope="row">맞춤 연동형</th><td>앱의 리워드 정책과 개발 환경에 맞춰 노출·상태·보상 흐름을 따로 맞춘 형태</td><td>필요한 데이터, 상태 처리, 테스트 범위</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="prose" style="margin-top:28px;">
                    <p>제이커브가 운영하는 리워드 앱은 공용 미션 허브 한 곳에 매체를 연결해 미션을 받고, 포인트 적립은 앱 화면이 아니라 서버가 완료를 확인한 뒤 확정합니다. 앱이 금액을 직접 계산하지 않는 구조라 설정을 바꿔도 지급 기준이 흔들리지 않습니다.</p>
                    <p>앱 운영사와의 연동 방식은 기존 지면 활용 여부, 웹뷰·서버 연동 가능 여부, 보상 처리 구조를 확인한 뒤 합의합니다.</p>
                </div>
                <p class="landing__note">실제 지원 형태와 연동 방식은 매체 환경을 검토한 뒤 확정합니다. 특정 SDK나 API 제공을 이 페이지에서 일괄 약속하지 않습니다.</p>
            </div>
        </section>

        {{-- 앱 운영사 — 정산 --}}
        <section class="landing__section landing__section--parchment" id="settlement">
            <div class="landing__inner">
                <span class="landing__eyebrow">Settlement</span>
                <h2 class="landing__head">오퍼월 수익은 어떻게 정산되나요?</h2>
                <p class="landing__lead">정산의 기준은 확정된 유효 전환입니다. 광고주와 앱 운영사가 같은 기록을 보고 마감할 수 있도록, 무엇을 확정으로 볼지 제휴 단계에서 먼저 맞춥니다.</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>정산 전에 맞추는 것</h3>
                        <ul>
                            <li>전환을 확정하는 기준과 시점</li>
                            <li>승인 대기·실패를 유저에게 안내하는 방법</li>
                            <li>무효 사유와 CS 처리 경로</li>
                            <li>전환 확정과 정산 일정</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>운영 중에 확인하는 것</h3>
                        <ul>
                            <li>노출·참여·승인 흐름의 급격한 변화</li>
                            <li>보상 미지급, 조건 오인, 승인 지연 같은 CS 원인</li>
                            <li>캠페인별 확정 전환과 조정 내역</li>
                            <li>광고주·매체 데이터 차이</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        {{-- ③ 광고주 — 성과 단위 --}}
        <section class="landing__section landing__section--light" id="advertisers">
            <div class="landing__inner">
                <span class="landing__eyebrow">For Advertisers</span>
                <h2 class="landing__head">광고주는 오퍼월 광고를 어떤 단위로 집행하나요?</h2>
                <p class="landing__lead">오퍼월 광고는 목표 액션을 먼저 정하고 그 액션이 확인된 만큼 비용을 내는 성과형 광고입니다. 이번 캠페인에서 바꾸고 싶은 행동이 무엇인지에 따라 단위를 고릅니다.</p>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr><th scope="col">성과 단위</th><th scope="col">비용이 생기는 시점</th><th scope="col">어울리는 목표</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">CPI (설치당)</th><td>앱 설치가 확인됐을 때</td><td>새 앱의 설치 규모를 먼저 만들어야 할 때</td></tr>
                            <tr><th scope="row">CPA (액션당)</th><td>회원가입·신청처럼 지정한 액션이 끝났을 때</td><td>가입·신청처럼 확인 가능한 전환이 목표일 때</td></tr>
                            <tr><th scope="row">CPE (참여당)</th><td>튜토리얼 완료·특정 단계 도달 같은 앱 안 참여가 확인됐을 때</td><td>설치 뒤 실제 이용까지 이어지게 하고 싶을 때</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="landing__points" style="margin-top:28px;">
                    <div class="landing__point landing__point--light"><strong>행동을 단계로 나누기</strong><span>설치에서 끝내지 않고 가입·튜토리얼·특정 미션 도달까지 이어지도록 미션 단계를 설계할 수 있습니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>보상과 난이도 맞추기</strong><span>미션에 걸리는 시간과 난이도에 비해 보상이 작으면 참여가 적고, 지나치면 목적과 다른 참여가 몰릴 수 있습니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>작게 확인하고 늘리기</strong><span>처음에는 작은 규모로 참여율·승인율·후속 행동을 보고 단가와 미션을 조정한 뒤 확대를 판단합니다.</span></div>
                </div>
                <p class="landing__note">고정 물량을 미리 보장하지 않습니다. 확보할 수 있는 참여 규모는 타깃 범위와 단가, 미션 난이도, 집행 기간, 매체 상황에 따라 그때그때 달라집니다.</p>
            </div>
        </section>

        {{-- 광고주 — 유효 전환 기준 --}}
        <section class="landing__section landing__section--dark has-orb" id="validity">
            <div class="landing__inner">
                <span class="landing__eyebrow">Valid Conversion</span>
                <h2 class="landing__head">어떤 전환을 유효로 인정하나요?</h2>
                <p class="landing__lead">유효 전환 기준은 캠페인마다 집행 전에 문서로 정하고, 집행 중에는 바꾸지 않습니다. 승인과 제외의 이유를 양쪽이 같은 근거로 설명할 수 있어야 하기 때문입니다.</p>
                <div class="landing__points">
                    <div class="landing__point"><strong>신규·중복</strong><span>같은 이용자·기기·계정의 반복 참여를 어떤 기준으로 가를지 정합니다.</span></div>
                    <div class="landing__point"><strong>완료 조건</strong><span>화면에 들어온 것과 실제로 끝낸 것을 구분하고, 필요한 완료 이벤트가 들어왔는지 봅니다.</span></div>
                    <div class="landing__point"><strong>인정 기간</strong><span>참여 시작부터 완료까지 인정하는 기간과, 지나치게 짧은 완료 같은 이상 신호를 확인합니다.</span></div>
                    <div class="landing__point"><strong>취소·환불</strong><span>구매가 들어간 캠페인은 취소·환불을 언제 반영하고 승인을 얼마나 보류할지 미리 정합니다.</span></div>
                    <div class="landing__point"><strong>이의 제기</strong><span>광고주와 앱 운영사가 같은 자료로 확인할 수 있게 필요한 증빙과 처리 기한을 정합니다.</span></div>
                </div>
            </div>
        </section>

        {{-- 제이커브 오퍼월 진행 절차 --}}
        <section class="landing__section landing__section--parchment" id="process">
            <div class="landing__inner">
                <span class="landing__eyebrow">Getting Started</span>
                <h2 class="landing__head">제이커브와 오퍼월은 어떻게 시작하나요?</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>앱 운영사 — 오퍼월 도입</h3>
                        <ul>
                            <li>1. 서비스·이용자 확인 — 앱 카테고리, 주요 이용자, 활성 규모, 리워드 사용처</li>
                            <li>2. 지면·정책 설계 — 노출 위치, 참여 동선, 보상 표시, 승인 대기 안내</li>
                            <li>3. 연동 범위 합의 — 개발 환경에 맞춘 데이터·상태 처리·테스트 범위와 담당자</li>
                            <li>4. 테스트 캠페인 검수 — 참여 시작부터 보상 반영까지 실제 조건으로 확인</li>
                            <li>5. 오픈 후 조정 — 참여율, 승인 이슈, CS를 보고 캠페인 구성과 안내 문구 보정</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>광고주 — 오퍼월 광고 집행</h3>
                        <ul>
                            <li>1. 목표 정하기 — 설치·가입·참여 중 이번 캠페인이 바꿀 행동 하나</li>
                            <li>2. 미션 설계 — 행동의 깊이, 보상, 단가 조건</li>
                            <li>3. 기준 문서화 — 신규·중복, 필수 단계, 인정 기간, 증빙 방식</li>
                            <li>4. 소량 검증 — 참여율·승인율·후속 행동 확인</li>
                            <li>5. 확대 판단 — 단가·메시지·미션을 조정한 뒤 규모 결정</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        {{-- 문의 전 준비 --}}
        <section class="landing__section landing__section--light" id="prepare">
            <div class="landing__inner">
                <span class="landing__eyebrow">Before You Ask</span>
                <h2 class="landing__head">문의 전에 무엇을 준비하면 되나요?</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>앱 운영사</h3>
                        <ul>
                            <li>서비스와 이용자 특성, 월간 활성 이용 규모</li>
                            <li>희망 지면(오퍼월 전용 화면인지, 기존 포인트 메뉴 안인지)</li>
                            <li>보상 재화의 사용처와 지급 정책</li>
                            <li>개발 환경(SDK·웹뷰·서버 연동 가능 여부)</li>
                            <li>운영·CS·정산 담당 체계</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>광고주</h3>
                        <ul>
                            <li>목표 액션과 희망 일정, 예산 범위</li>
                            <li>앱 또는 랜딩 링크</li>
                            <li>전환을 확인할 방법</li>
                            <li>제한 조건, 소재와 브랜드 가이드</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">준비되지 않은 항목은 상담에서 체크리스트로 함께 정리합니다.</p>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">오퍼월에 대해 자주 묻는 질문</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item"><summary>{{ $faq['question'] }}</summary><p>{{ $faq['answer'] }}</p></details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="related">
            <div class="landing__inner">
                <span class="landing__eyebrow">Related</span>
                <h2 class="landing__head">함께 보면 좋은 안내</h2>
                <div class="landing__points">
                    <a class="landing__point landing__point--link landing__point--light" href="{{ route('services.show', ['slug' => 'reward-network']) }}">
                        <strong>리워드 광고 · 오퍼월 서비스</strong>
                        <span>광고주 리워드 광고 캠페인과 앱 매체 제휴를 어떻게 운영하는지 전체 구조를 봅니다.</span>
                        <small class="landing__point-link">리워드 광고 보기 →</small>
                    </a>
                    <a class="landing__point landing__point--link landing__point--light" href="{{ route('insights.show', ['insight' => '오퍼월이란-리워드-광고-구조와-앱-수익화']) }}">
                        <strong>오퍼월이란? 리워드 광고 구조 정리</strong>
                        <span>오퍼월이 움직이는 순서와 광고주·앱 운영사가 확인할 점을 글로 정리했습니다.</span>
                        <small class="landing__point-link">글 읽기 →</small>
                    </a>
                    <a class="landing__point landing__point--link landing__point--light" href="{{ $publisherContact }}">
                        <strong>오퍼월 도입·광고 문의</strong>
                        <span>서비스와 희망 지면, 또는 목표 액션을 알려 주시면 가능한 범위와 다음 단계를 답합니다.</span>
                        <small class="landing__point-link">문의하기 →</small>
                    </a>
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">Start With Offerwall</span>
                <h2>앱 운영사라면 지면을,<br>광고주라면 목표 액션을 알려 주세요</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">서비스와 조건, 기술 환경을 먼저 확인하고 오퍼월로 가능한 범위를 구체적으로 답합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ $publisherContact }}">오퍼월 도입 문의</a>
                    <a class="btn-ghost" href="{{ $advertiserContact }}">오퍼월 광고 집행 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
