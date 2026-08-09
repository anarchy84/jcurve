@extends('layouts.app')

@section('title', '랭크프리 — 사장님, 지금 몇 등인지 아세요? | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="키워드만 넣으면 30초, 가입도 필요 없이 네이버 플레이스·쇼핑·블로그 순위와 경쟁사·시장 규모까지. 대부분 무료인 네이버 마케팅 분석 툴, 랭크프리.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero landing__hero--media">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                <nav class="subpage__breadcrumb" aria-label="상위"><a href="{{ route('solutions.index') }}">솔루션</a></nav>
                <span class="landing__eyebrow">RankFree</span>
                <h1>사장님, 지금 몇 등인지 아세요?</h1>
                <p class="landing__lead">키워드만 넣으면 30초 안에 나옵니다. 가입도 필요 없어요.
                   네이버 플레이스·쇼핑·블로그 순위, 경쟁사 비교, 시장 규모까지 — 대부분 무료입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://rankfree.kr" target="_blank" rel="noopener">무료로 순위 확인 →</a>
                    <a class="btn-ghost" href="#limits">데이터 기준 먼저 보기</a>
                </div>
                <p class="landing__body" style="margin-top:20px;color:var(--text-muted);">이미 1,200+ 사장님이 확인했습니다.</p>
                <p class="landing__note">랭크프리의 순위·점수·시장 데이터는 자체 수집·분석 기반의 추정 정보이며 네이버가 제공하거나 보증하는 공식 지표가 아닙니다.</p>
                </div>
                <figure class="landing__hero-figure"><img src="{{ asset('media/scenes/rankfree.webp') }}" alt="" width="1000" height="750" loading="eager"></figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="랭크프리 페이지 바로가기">
            <div class="landing__local-nav-inner">
                <a href="#overview">서비스 정의</a>
                <a href="#problem">문제</a>
                <a href="#features">분석 기능</a>
                <a href="#workflow">사용 흐름</a>
                <a href="#limits">데이터 기준</a>
                <a href="#pricing">요금</a>
                <a href="#fit">적합성</a>
                <a href="#faq">FAQ</a>
            </div>
        </nav>

        {{-- ① 정의 [라이트] --}}
        <section class="landing__section landing__section--light" id="overview">
            <div class="landing__inner">
                <span class="landing__eyebrow">What RankFree Does</span>
                <h2 class="landing__head">순위를 찍어보는 도구에서, 다음 질문을 만드는 분석 도구로</h2>
                <p class="landing__lead">랭크프리는 네이버의 여러 검색·쇼핑 영역에서 현재 위치와 비교 대상을 확인하고, 무엇을 더 살펴볼지 판단하는 데 쓰는 마케팅 분석 도구입니다.</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>현재 위치 확인</h3>
                        <p>키워드별 노출 위치를 확인해 감으로만 알고 있던 현재 상태를 기록합니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>비교 기준 만들기</h3>
                        <p>상위 결과와 시장 데이터를 함께 살펴보고 리뷰·판매·키워드·콘텐츠의 차이를 확인합니다.</p>
                    </article>
                </div>
                <div class="landing__callout">랭크프리는 “왜 무조건 떨어졌는지”를 단정하지 않습니다. 현재 데이터에서 먼저 점검할 원인 후보와 비교 기준을 보여줍니다.</div>
            </div>
        </section>

        {{-- ② 문제 [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="problem">
            <div class="landing__inner">
                <span class="landing__eyebrow">The Blind Spot</span>
                <h2 class="landing__head">순위 숫자 하나만 보면, 무엇을 바꿔야 할지 모릅니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>기준 없이 검색한다</h3>
                        <p>매번 다른 시간과 환경에서 검색하면 변화인지 측정 차이인지 구분하기 어렵습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>내 순위만 본다</h3>
                        <p>상위 결과가 어떤 리뷰·판매·콘텐츠 조건을 갖췄는지 보지 않으면 개선 우선순위를 세우기 어렵습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>시장 크기를 확정값처럼 본다</h3>
                        <p>검색량과 매출 추정치는 방향을 살피는 보조 정보입니다. 실제 수요와 매출을 그대로 보장하지 않습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>순위 상승을 목표 자체로 둔다</h3>
                        <p>노출이 올라가도 클릭·문의·구매가 늘지 않을 수 있습니다. 순위와 사업 성과를 별도로 확인해야 합니다.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- ③ 기능 [다크] --}}
        <section class="landing__section landing__section--dark has-orb" id="features">
            <div class="landing__inner">
                <span class="landing__eyebrow">Analysis Areas</span>
                <h2 class="landing__head">플레이스부터 API까지, 필요한 분석 축을 고릅니다</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>플레이스</strong>
                        <p>키워드별 순위와 상위 경쟁 결과를 비교하고 리뷰·저장 등 확인 가능한 항목을 점검합니다.</p>
                    </div>
                    <div class="landing__point">
                        <strong>쇼핑</strong>
                        <p>순위와 함께 6개월 시장 규모·매출 추정, 셀러와 리뷰 관련 분석 정보를 살펴봅니다.</p>
                    </div>
                    <div class="landing__point">
                        <strong>키워드</strong>
                        <p>검색량·트렌드와 자체 기회 점수를 이용해 우선 검토할 키워드 후보를 찾습니다.</p>
                    </div>
                    <div class="landing__point">
                        <strong>블로그</strong>
                        <p>검색 결과에 나타나는 블로그와 자체 분석 정보를 확인해 콘텐츠·체험단 후보 검토에 참고합니다.</p>
                    </div>
                    <div class="landing__point">
                        <strong>자동 추적·알림</strong>
                        <p>요금제에서 제공하는 범위에 따라 관심 키워드의 변화를 반복 확인하는 수고를 줄입니다.</p>
                    </div>
                    <div class="landing__point">
                        <strong>순위 API</strong>
                        <p>제공 조건에 맞는 API 키로 순위 데이터를 별도 업무 흐름에 연결할 수 있습니다.</p>
                    </div>
                </div>
                <p class="landing__note">세부 제공 범위와 사용 한도는 랭크프리의 현재 서비스 화면 및 요금제 안내가 우선합니다.</p>
            </div>
        </section>

        {{-- ④ 활용 흐름 [라이트] --}}
        <section class="landing__section landing__section--light" id="workflow">
            <div class="landing__inner">
                <span class="landing__eyebrow">From Search To Decision</span>
                <h2 class="landing__head">한 번 보고 끝내지 말고, 같은 기준으로 반복 확인하세요</h2>
                <div class="steps">
                    <div class="steps__item"><strong>사업과 가까운 키워드 선택</strong><p>검색량만 큰 단어보다 실제 상품·지역·고객 의도와 가까운 키워드부터 입력합니다.</p></div>
                    <div class="steps__item"><strong>확인할 영역 선택</strong><p>플레이스, 쇼핑, 키워드, 블로그 중 지금 판단에 필요한 화면을 고릅니다.</p></div>
                    <div class="steps__item"><strong>내 결과와 상위 결과 비교</strong><p>순위 차이뿐 아니라 각 분석 화면에서 제공하는 리뷰·판매·콘텐츠 관련 항목을 함께 봅니다.</p></div>
                    <div class="steps__item"><strong>변경할 한 가지 결정</strong><p>키워드, 상세 정보, 콘텐츠, 리뷰 운영 등 직접 통제 가능한 항목 하나를 먼저 정합니다.</p></div>
                    <div class="steps__item"><strong>같은 조건으로 다시 확인</strong><p>변경 전후를 기록하되 순위 변동만으로 인과관계를 확정하지 않고 문의·클릭·매출 자료와 함께 봅니다.</p></div>
                </div>
            </div>
        </section>

        {{-- ⑤ 제공 범위·한계 [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="limits">
            <div class="landing__inner">
                <span class="landing__eyebrow">Read The Data Correctly</span>
                <h2 class="landing__head">숫자의 성격을 알아야 잘못된 결론을 피합니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>공식 네이버 지표가 아닙니다</h3>
                        <p>순위·점수(N1·N2·N3)와 분석 결과는 랭크프리의 자체 수집·분석에 따른 정보입니다. 네이버의 승인·제휴·보증을 의미하지 않습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>환경에 따라 결과가 달라질 수 있습니다</h3>
                        <p>검색 시점, 기기·위치, 로그인·개인화, 네이버 화면과 정책 변화, 수집 상태에 따라 직접 확인한 결과와 차이가 날 수 있습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>시장·매출 데이터는 추정치입니다</h3>
                        <p>쇼핑 시장 규모와 매출 관련 값은 의사결정 참고용 추정 정보이며 실제 거래액·수익·향후 성과를 확정하지 않습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>점수는 원인과 성과를 보장하지 않습니다</h3>
                        <p>높거나 낮은 점수는 비교를 돕는 신호입니다. 특정 작업이 순위 상승이나 매출 증가를 만든다고 단정하는 근거는 아닙니다.</p>
                    </article>
                </div>
                <div class="landing__callout">순위 데이터는 판결문이 아니라 계기판입니다. 방향을 읽되, 실제 고객 행동과 매출 자료로 다시 확인해야 합니다.</div>
            </div>
        </section>

        {{-- ⑥ 요금 + 필수 고지 [다크] --}}
        <section class="landing__section landing__section--dark has-orb" id="pricing">
            <div class="landing__inner">
                <span class="landing__eyebrow">Plans</span>
                <h2 class="landing__head">무료로 시작해서, 필요할 때 확장</h2>
                <ul class="landing__evidence">
                    <li><strong>무료 0원</strong> — 순위체크 100개 · 분석 월 5회</li>
                    <li><strong>프로 29,000원/월</strong> — 무제한 + 자동추적 알림 + API</li>
                    <li><strong>마케팅 대행</strong> — 분석에서 실행까지, 맞춤 견적</li>
                </ul>
                <p class="landing__note">위 내용은 현재 페이지에 확인된 안내를 옮긴 것입니다. 결제 전 랭크프리에서 최신 가격, 제공량, 기능 조건을 다시 확인하세요.</p>
                <p class="landing__note">순위·점수(N1·N2·N3)는 자체 수집·분석 기반 추정치이며 네이버 공식 지표가 아닙니다.</p>
            </div>
        </section>

        {{-- ⑦ 적합성 [라이트] --}}
        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">Fit Check</span>
                <h2 class="landing__head">랭크프리가 잘 맞는 일과, 다른 자료가 필요한 일</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>이럴 때 유용합니다</h3>
                        <ul>
                            <li>내 플레이스·상품·콘텐츠의 현재 노출 위치를 확인할 때</li>
                            <li>상위 결과와 비교할 항목을 빠르게 찾을 때</li>
                            <li>여러 키워드 중 먼저 볼 후보를 좁힐 때</li>
                            <li>외주·광고·SEO 상담 전 기초 자료를 준비할 때</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>이것만으로는 부족합니다</h3>
                        <ul>
                            <li>네이버의 공식 내부 평가 기준이 필요할 때</li>
                            <li>정확한 시장 매출이나 경쟁사 실적을 확정해야 할 때</li>
                            <li>순위 변동의 단일 원인을 증명해야 할 때</li>
                            <li>특정 시점까지 상위 노출을 보장받고 싶을 때</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        {{-- ⑧ FAQ [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">데이터를 보기 전에 가장 많이 묻는 질문</h2>
                <div class="faq">
                    <details class="faq__item"><summary>랭크프리 순위는 네이버 공식 순위인가요?</summary><p>아닙니다. 랭크프리의 자체 수집·분석 결과입니다. 네이버 공식 지표나 내부 평가 기준으로 해석하면 안 됩니다.</p></details>
                    <details class="faq__item"><summary>제가 직접 검색한 순위와 왜 다른가요?</summary><p>검색 시점, 위치, 기기, 로그인·개인화 상태, 화면 구성과 수집 상태가 다르면 결과도 달라질 수 있습니다. 한 번의 숫자보다 같은 조건의 변화 흐름을 보는 편이 낫습니다.</p></details>
                    <details class="faq__item"><summary>시장 규모와 매출 추정치는 정확한 거래액인가요?</summary><p>아닙니다. 자체 분석에 따른 추정 정보이며 실제 거래액이나 향후 매출을 보장하지 않습니다. 상품성·원가·전환율 등 별도 자료와 함께 판단해야 합니다.</p></details>
                    <details class="faq__item"><summary>점수가 낮은 항목만 고치면 순위가 오르나요?</summary><p>그렇게 단정할 수 없습니다. 점수는 비교와 점검을 위한 신호이며 검색 서비스의 실제 반영 방식과 성과는 여러 요인의 영향을 받습니다.</p></details>
                    <details class="faq__item"><summary>가입 없이 어디까지 사용할 수 있나요?</summary><p>기본 확인은 현재 서비스에 안내된 무료 범위에서 이용할 수 있습니다. 저장, 자동 추적, 알림, API 등 확장 기능의 가입·요금 조건은 랭크프리에서 확인하세요.</p></details>
                    <details class="faq__item"><summary>상위 노출을 보장하나요?</summary><p>보장하지 않습니다. 랭크프리는 분석과 의사결정을 돕는 도구이며 네이버의 노출 결과를 통제하지 않습니다.</p></details>
                    <details class="faq__item"><summary>분석 후 실행까지 맡길 수 있나요?</summary><p>제이커브의 SEO·마케팅 대행은 별도 상담으로 검토할 수 있습니다. 분석 결과만으로 실행 범위나 성과를 확정하지 않고 현재 사이트와 운영 여건을 함께 확인합니다.</p></details>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">Start With A Baseline</span>
                <h2>지금, 내 순위부터 확인해 보세요</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">한 번의 숫자로 결론내리지 말고, 비교 기준을 만든 뒤 실제 고객 행동과 함께 보세요.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://rankfree.kr" target="_blank" rel="noopener">무료로 순위 확인 →</a>
                    <a class="btn-ghost" href="{{ route('services.show', ['slug' => 'seo']) }}">SEO 대행 보기</a>
                </div>
            </div>
        </section>
    </main>
@endsection
