@extends('layouts.app')

@section('title', '자체 솔루션 4종 — 빌려 쓰지 않고 직접 만듭니다 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="현장에서 필요한 도구를 제이커브가 직접 개발해 운영합니다. 랭크프리·부스팅샵·리드베이·콜투세일 — 마케팅 데이터부터 보험 세일즈 CRM까지 네 개의 자체 솔루션.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Our Products</span>
                <h1>빌려 쓰지 않습니다. 직접 만듭니다.</h1>
                <p class="landing__lead">현장에서 필요한 도구를 제이커브가 직접 개발해 운영합니다.
                   마케팅 데이터부터 보험 세일즈 CRM까지, 네 개의 자체 솔루션.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="#products">솔루션 살펴보기</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">도입·활용 문의</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="솔루션 페이지 바로가기">
            <div class="landing__local-nav-inner">
                <a href="#overview">솔루션 소개</a>
                <a href="#problems">현장의 문제</a>
                <a href="#products">4개 제품</a>
                <a href="#workflow">선택 순서</a>
                <a href="#scope">제공 범위</a>
                <a href="#fit">적합성</a>
                <a href="#faq">FAQ</a>
            </div>
        </nav>

        {{-- ① 정의 [라이트] --}}
        <section class="landing__section landing__section--light" id="overview">
            <div class="landing__inner">
                <span class="landing__eyebrow">Built From The Field</span>
                <h2 class="landing__head">반복되는 현장 문제를, 계속 쓸 수 있는 제품으로</h2>
                <p class="landing__lead">프로젝트마다 같은 데이터를 다시 모으고, 같은 엑셀을 만들고, 같은 운영 실수를 반복하지 않도록 필요한 흐름을 제품으로 정리했습니다.</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>마케팅 데이터를 직접 확인</h3>
                        <p>랭크프리로 네이버 순위와 시장 데이터를 살펴보고, 부스팅샵에서 필요한 셀프 마케팅 상품을 비교합니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>보험 세일즈 흐름을 한곳에서 관리</h3>
                        <p>리드베이는 보험DB를 활용하는 영업조직의 흐름을, 콜투세일은 DB를 생산·납품하는 콜센터의 흐름을 다룹니다.</p>
                    </article>
                </div>
                <div class="landing__callout">도구가 많아서 강한 게 아닙니다. 문제를 직접 겪고, 무엇을 한 화면에서 이어야 하는지 아는 것이 차이입니다.</div>
            </div>
        </section>

        {{-- ② 문제 [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="problems">
            <div class="landing__inner">
                <span class="landing__eyebrow">Why Products</span>
                <h2 class="landing__head">정보와 실행이 흩어지면, 판단도 늦어집니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>현재 상태를 모른다</h3>
                        <p>순위와 경쟁 상황을 모르면 무엇부터 바꿔야 하는지 정하기 어렵습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>필요한 것보다 크게 산다</h3>
                        <p>목표가 작은데도 풀 대행부터 시작하면 비용과 관리 범위가 불필요하게 커질 수 있습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>상담 이력이 사람에게 묶인다</h3>
                        <p>DB 배분과 상담 상태가 엑셀·메신저에 흩어지면 담당자가 바뀔 때 흐름도 끊깁니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>납품과 정산의 근거가 갈린다</h3>
                        <p>수주·납품·AS·정산 자료가 서로 다르면 월말 확인과 이슈 대응에 시간이 더 듭니다.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- ③ 마케팅 데이터 제품 [다크] --}}
        <section class="landing__section landing__section--dark has-orb" id="products">
            <div class="landing__inner">
                <span class="landing__eyebrow">Marketing Data & Execution</span>
                <h2 class="landing__head">먼저 보고, 필요한 만큼 실행합니다</h2>
                <p class="landing__lead">분석 도구와 셀프 마케팅 상품은 역할이 다릅니다. 현재 상태를 확인하려면 랭크프리, 실행 항목이 이미 정해졌다면 부스팅샵부터 살펴보세요.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.rankfree') }}">
                        <strong>랭크프리 (RankFree)</strong>
                        <p>네이버 플레이스·쇼핑·키워드·블로그의 순위와 분석 데이터를 확인하는 도구입니다.</p>
                        <span>순위·시장 분석 보기 →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.boostingshop') }}">
                        <strong>부스팅샵 (BoostingShop)</strong>
                        <p>SEO 캠페인과 인스타그램 관련 상품을 개별 페이지에서 확인하는 셀프 마케팅 허브입니다.</p>
                        <span>상품과 확인사항 보기 →</span>
                    </a>
                    {{-- 2026-10-27 추가: 운영 서비스 쇼피트렌드 --}}
                    <a class="subcard" href="{{ route('solutions.shopitrend') }}">
                        <strong>쇼피트렌드 (Shopitrend)</strong>
                        <p>플레이스·쇼핑·SNS 광고를 직접 주문하고 광고 관리·순위체크까지 이어서 확인하는 셀프 마케팅 플랫폼입니다.</p>
                        <span>플랫폼 소개 보기 →</span>
                    </a>
                    <a class="subcard" href="{{ route('self-marketing') }}">
                        <strong>셀프마케팅 주문</strong>
                        <p>제이커브 사이트에서 랭크프리 계정을 연결해 순위상승 캠페인을 바로 주문합니다.</p>
                        <span>주문 시작하기 →</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ④ 보험 세일즈 CRM [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Insurance Sales Operations</span>
                <h2 class="landing__head">보험DB 시장의 두 운영 흐름을 각각 봅니다</h2>
                <p class="landing__lead">사는 쪽과 파는 쪽은 필요한 화면과 책임이 다릅니다. 하나의 제품에 억지로 합치지 않고 각 업무 흐름에 맞춘 CRM으로 나눴습니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.leadbay') }}">
                        <strong>리드베이 (LEADBAY)</strong>
                        <p>보험 영업조직이 DB 비교·구매부터 상담 배분, 계약·AS·정산 흐름을 관리하는 CRM입니다.</p>
                        <span>DB를 활용하는 조직용 →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.call2sale') }}">
                        <strong>콜투세일 (Call2.Sale)</strong>
                        <p>보험DB 콜센터가 원천 DB, 상담원 배분, 수주·납품·AS·전자계약·정산을 관리하는 CRM입니다.</p>
                        <span>DB를 생산·납품하는 조직용 →</span>
                    </a>
                </div>
                <p class="landing__note">보험DB의 수집·제공·이용은 관련 법령과 계약, 정보주체 동의, 보험사·GA의 내부 기준을 함께 확인해야 합니다. 솔루션 사용만으로 개별 거래의 적법성이나 성과가 보장되지는 않습니다.</p>
            </div>
        </section>

        {{-- ⑤ 선택 흐름 [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="workflow">
            <div class="landing__inner">
                <span class="landing__eyebrow">How To Choose</span>
                <h2 class="landing__head">제품명보다 지금 막힌 일을 먼저 고르세요</h2>
                <div class="steps">
                    <div class="steps__item"><strong>현재 문제를 한 문장으로 정리</strong><p>순위를 모르겠다, 필요한 마케팅만 사고 싶다, 상담 배분이 흩어졌다, 납품·정산 관리가 어렵다처럼 병목을 구체화합니다.</p></div>
                    <div class="steps__item"><strong>소개 페이지에서 역할 확인</strong><p>각 솔루션이 다루는 사용자와 업무 범위, 다루지 않는 범위를 먼저 확인합니다.</p></div>
                    <div class="steps__item"><strong>실제 서비스와 상품 조건 확인</strong><p>외부에서 운영되는 솔루션은 해당 서비스의 현재 화면과 이용 조건을, 부스팅샵은 개별 상품 페이지의 현재 구성을 확인합니다.</p></div>
                    <div class="steps__item"><strong>내 데이터와 운영 기준 정리</strong><p>추적할 키워드, 필요한 상품, DB 처리 기준, 상담 상태와 담당 권한처럼 도입 전에 맞춰야 할 항목을 정합니다.</p></div>
                    <div class="steps__item"><strong>작은 범위부터 사용</strong><p>한 번에 모든 업무를 옮기기보다 가장 반복이 많은 구간부터 적용하고 다음 확대 범위를 판단합니다.</p></div>
                </div>
            </div>
        </section>

        {{-- ⑥ 제공 범위 [다크] --}}
        <section class="landing__section landing__section--dark has-orb" id="scope">
            <div class="landing__inner">
                <span class="landing__eyebrow">What This Site Provides</span>
                <h2 class="landing__head">여기서는 이해하고, 실제 서비스에서 확인합니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>제이커브 소개 페이지</h3>
                        <ul>
                            <li>솔루션이 해결하려는 문제와 대상</li>
                            <li>확인된 핵심 기능과 업무 흐름</li>
                            <li>도입 전에 확인할 제한과 주의사항</li>
                            <li>관련 서비스와 실제 서비스로 가는 링크</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>실제 서비스·상품 페이지</h3>
                        <ul>
                            <li>현재 제공 기능과 화면</li>
                            <li>요금제·상품 구성·이용 조건</li>
                            <li>가입·구매·도입 절차</li>
                            <li>약관·개인정보 처리·운영 정책</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">서비스 기능·가격·제공 여부는 변경될 수 있으므로 최종 결정 전 각 실제 서비스와 상품 페이지의 최신 조건을 확인하세요.</p>
            </div>
        </section>

        {{-- ⑦ 적합성 [라이트] --}}
        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">Fit Check</span>
                <h2 class="landing__head">이럴 때 자체 솔루션이 잘 맞습니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>잘 맞는 경우</h3>
                        <ul>
                            <li>반복 확인·배분·상태 관리가 수작업에 머물러 있을 때</li>
                            <li>대행 전에 현재 데이터부터 직접 확인하고 싶을 때</li>
                            <li>필요한 실행 항목과 예산 범위가 비교적 명확할 때</li>
                            <li>보험DB 업무의 권한·동의·처리 기준을 이미 운영하고 있을 때</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>먼저 상담이 필요한 경우</h3>
                        <ul>
                            <li>무엇이 문제인지 아직 정의되지 않았을 때</li>
                            <li>도구 도입과 함께 전략·콘텐츠·광고 운영 전체가 필요할 때</li>
                            <li>개인정보의 수집 근거와 제공 범위가 정리되지 않았을 때</li>
                            <li>특정 순위·매출·계약 성과의 사전 보장을 기대할 때</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        {{-- ⑧ FAQ [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">솔루션을 고르기 전에 자주 묻는 질문</h2>
                <div class="faq">
                    <details class="faq__item"><summary>네 솔루션을 모두 함께 써야 하나요?</summary><p>아닙니다. 각 제품은 대상과 문제가 다릅니다. 지금 가장 반복이 많거나 판단이 늦어지는 한 구간부터 고르는 편이 낫습니다.</p></details>
                    <details class="faq__item"><summary>제이커브 대행 서비스를 이용해야만 쓸 수 있나요?</summary><p>각 솔루션과 상품의 이용 방식은 해당 실제 서비스 또는 상품 페이지에서 확인해야 합니다. 소개 페이지는 대행 계약을 전제로 기능을 과장하지 않습니다.</p></details>
                    <details class="faq__item"><summary>이 페이지의 기능 설명이 실제 서비스와 다르면 어떻게 하나요?</summary><p>기능과 조건은 바뀔 수 있으므로 실제 서비스의 최신 화면·약관·안내가 우선합니다. 차이가 발견되면 문의를 통해 현재 범위를 확인해 주세요.</p></details>
                    <details class="faq__item"><summary>도입하면 매출이나 계약이 늘어난다고 보장하나요?</summary><p>보장하지 않습니다. 솔루션은 확인과 운영을 돕는 도구이며, 성과는 데이터 품질, 실행 방식, 조직 운영, 시장 상황 등에 따라 달라집니다.</p></details>
                    <details class="faq__item"><summary>보험DB 솔루션은 개인정보 적법성까지 대신 판단하나요?</summary><p>아닙니다. 수집·제공·이용 근거와 동의 범위, 보유·파기, 접근 권한은 거래 당사자가 관련 기준에 따라 확인해야 합니다.</p></details>
                    <details class="faq__item"><summary>어떤 제품이 맞는지 모르겠습니다.</summary><p>현재 하고 있는 수작업, 사용하는 자료, 가장 자주 생기는 오류와 원하는 결과를 알려주면 어느 제품부터 확인할지 정리할 수 있습니다.</p></details>
                </div>
            </div>
        </section>

        {{-- 최종 CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">Choose By The Bottleneck</span>
                <h2>도구를 고르기 전에,<br>막힌 흐름부터 말해주세요</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">현재 데이터와 업무 방식을 보고 직접 확인할 제품과 별도 상담이 필요한 범위를 나눠드립니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">도입·활용 문의</a>
                    <a class="btn-ghost" href="#products">4개 솔루션 다시 보기</a>
                </div>
            </div>
        </section>
    </main>
@endsection
