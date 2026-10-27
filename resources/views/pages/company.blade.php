@extends('layouts.app')

@php
    $faqs = [
        ['question' => '광고대행사인가요, 솔루션 회사인가요?', 'answer' => '두 영역을 함께 운영합니다. 광고·CPA·리워드·SEO·웹 제작을 수행하면서 현장에서 반복되는 문제를 해결하기 위해 자체 솔루션도 개발하고 운영합니다.'],
        ['question' => '프로젝트는 어떤 기준으로 시작하나요?', 'answer' => '목표와 전환 기준, 현재 데이터, 실행 여건을 먼저 확인합니다. 수행 가능 범위와 선행 조건이 맞아야 실행 단계로 넘어갑니다.'],
        ['question' => '일부 영역만 맡길 수도 있나요?', 'answer' => '가능합니다. 전체 운영뿐 아니라 계정 진단, 특정 채널, SEO, 웹 제작, 측정 구조처럼 필요한 구간만 범위를 정할 수 있습니다.'],
        ['question' => '성과를 미리 보장하나요?', 'answer' => '시장 반응과 플랫폼 결과를 미리 보장하지 않습니다. 대신 측정할 기준, 실험 범위, 유지·중단·확대 조건을 먼저 합의합니다.'],
    ];
@endphp

@section('title', '회사소개 — 2009년부터, 실행과 데이터로 말해왔습니다 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="2009년 설립. 광고 집행, CPA, 리워드, 검색, 웹 제작과 자체 솔루션 개발을 한 팀에서 연결하는 제이커브인터렉티브의 역사와 일하는 방식을 소개합니다.">
    <script type="application/ld+json">
        {!! json_encode([
            '@'.'context' => 'https://schema.org', // 키를 쪼갠 이유: 붙여 쓰면 Blade 지시어로 컴파일됨
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer']],
            ], $faqs),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endsection

@section('content')
    <main class="landing">
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">About J-Curve</span>
                <h1>2009년부터,<br>실행과 데이터로 말해왔습니다</h1>
                <p class="landing__lead">광고를 대신 집행하는 데서 멈추지 않았습니다. 유입, 전환, 검색, 리드 운영과 웹 시스템까지 현장에서 막히는 구간을 직접 풀어왔습니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">프로젝트 문의</a>
                    <a class="btn-ghost" href="#how-we-work">일하는 방식 보기</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="회사소개 바로가기">
            <div class="landing__local-nav-inner">
                <a href="#story">시작</a>
                <a href="#how-we-work">운영 원칙</a>
                <a href="#capabilities">역량</a>
                <a href="#products">자체 솔루션</a>
                <a href="#anarchy">아나키</a>
                <a href="#faq">FAQ</a>
            </div>
        </nav>

        <section class="landing__section landing__section--light" id="story">
            <div class="landing__inner">
                <span class="landing__eyebrow">Our Story</span>
                <h2 class="landing__head">시장 이름은 바뀌어도, 고객이 묻는 건 같았습니다</h2>
                <div class="prose">
                    <p>제이커브는 2009년에 시작했습니다. 매체와 기술은 계속 바뀌었지만 광고주가 알고 싶은 것은 늘 같았습니다. “이 예산이 실제로 어떤 결과를 만들었는가.”</p>
                    <p>그래서 노출과 클릭 뒤를 보기 시작했습니다. 상담 신청은 유효했는지, 설치한 유저는 핵심 기능까지 갔는지, 검색 방문자는 문의로 이어졌는지, 운영팀이 그 결과를 다음 행동으로 옮길 수 있는지까지 봤습니다.</p>
                    <p>필요한 도구가 없으면 직접 만들었습니다. 이 실행의 축적이 지금의 퍼포먼스·CPA·리워드·SEO·웹 제작과 네 개의 자체 솔루션으로 이어졌습니다.</p>
                </div>
                <div class="landing__callout">제이커브라는 이름처럼, 작은 개선이 누적돼 어느 순간 성장 곡선이 꺾여 올라가는 구조를 만듭니다.</div>
            </div>
        </section>

        {{-- 2026년 회사 전체 누적 기준. 서비스별 실적으로 오인되지 않게 공통 라벨을 유지한다. --}}
        <section class="home__stats has-orb" aria-label="회사 전체 누적 핵심 지표">
            <div class="home__stats-inner">
                <div class="stat glass-card"><strong data-count-to="373" data-count-suffix="억+">373억+</strong><span>2026년 기준 · 회사 전체 누적 집행 광고비</span></div>
                <div class="stat glass-card"><strong data-count-to="128" data-count-suffix="만+">128만+</strong><span>2026년 기준 · 회사 전체 누적 수집 DB</span></div>
                <div class="stat glass-card"><strong data-count-to="15700" data-count-suffix="+" data-count-comma="1">15,700+</strong><span>2026년 기준 · 회사 전체 누적 진행 캠페인</span></div>
                <div class="stat glass-card"><strong data-count-to="2009" data-count-suffix="년">2009년</strong><span>법인 설립</span></div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="how-we-work">
            <div class="landing__inner">
                <span class="landing__eyebrow">How We Work</span>
                <h2 class="landing__head">성과보다 먼저, 성과의 기준부터 맞춥니다</h2>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>목표를 숫자로 번역</strong><span>“잘되게 해주세요”를 매출·유효 리드·가입·핵심 행동처럼 확인 가능한 기준으로 바꿉니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>측정되지 않으면 확대하지 않음</strong><span>전환이 어디서 발생했고 어떤 조건에서 달라졌는지 볼 수 있게 기반부터 점검합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>작게 검증하고 빠르게 보정</strong><span>한 번에 모든 것을 바꾸지 않습니다. 가설을 나눠 실행하고 유지·중단·확대를 판단합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>불편한 숫자도 함께 공유</strong><span>좋은 결과만 골라 보고하지 않습니다. 막힌 지점과 다음에 바꿀 것을 같은 표에 놓습니다.</span></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">One Operating Loop</span>
                <h2 class="landing__head">전략·제작·집행·개발이 같은 문제를 봅니다</h2>
                <div class="steps">
                    <div class="steps__item"><strong>진단</strong><p>사업 모델, 고객 여정, 기존 채널과 데이터 환경에서 가장 큰 병목을 찾습니다.</p></div>
                    <div class="steps__item"><strong>설계</strong><p>목표, 전환, 메시지, 매체, 페이지와 후속 운영을 하나의 실행안으로 연결합니다.</p></div>
                    <div class="steps__item"><strong>실행</strong><p>광고 운영, 콘텐츠·크리에이티브, 검색 최적화와 필요한 웹 작업을 범위에 맞게 진행합니다.</p></div>
                    <div class="steps__item"><strong>학습</strong><p>성과와 실패 원인을 기록하고 다음 예산·소재·제품 개선의 우선순위로 돌려보냅니다.</p></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="capabilities">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Capabilities</span>
                <h2 class="landing__head">고객을 데려오는 일부터, 전환 이후를 운영하는 일까지</h2>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'performance-marketing']) }}"><strong>데이터 기반 광고 운영</strong><p>매체·소재·랜딩을 합의한 비즈니스 KPI로 연결합니다.</p><span>퍼포먼스 마케팅 →</span></a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'cpa-marketing']) }}"><strong>성과형 액션·리드</strong><p>사전에 합의한 유효 액션과 검수·정산 기준으로 운영합니다.</p><span>CPA 마케팅 →</span></a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'reward-network']) }}"><strong>리워드 생태계</strong><p>광고주 행동과 앱 매체 수익화를 운영 기준으로 연결합니다.</p><span>리워드 네트워크 →</span></a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'seo']) }}"><strong>검색·AI 가시성</strong><p>기술, 콘텐츠, 신뢰 근거를 검색 가능한 디지털 자산으로 쌓습니다.</p><span>SEO · AEO · GEO →</span></a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'wordpress']) }}"><strong>마케팅 웹 구축</strong><p>발견, 이해, 전환, 운영을 고려한 웹사이트를 만듭니다.</p><span>워드프레스 →</span></a>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="products">
            <div class="landing__inner">
                <span class="landing__eyebrow">Owned Products</span>
                <h2 class="landing__head">도구가 없으면, 현장에서 직접 만들었습니다</h2>
                <div class="prose">
                    <p>순위 데이터를 직접 보고 싶어 랭크프리를 만들었고, 셀프 마케팅 수요에 대응해 부스팅샵을 운영했습니다. 보험 영업과 DB 콜센터에서 반복되는 관리 문제는 리드베이와 콜투세일로 제품화했습니다.</p>
                    <p>대행과 제품 개발을 함께한다는 것은 아이디어를 보고서에서 끝내지 않는다는 뜻입니다. 반복되는 문제라면 프로세스로 만들고, 필요한 경우 실제 도구로 구현합니다.</p>
                </div>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.rankfree') }}"><strong>랭크프리</strong><p>검색 순위와 시장 데이터를 확인하는 자체 솔루션.</p><span>제품 소개 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop') }}"><strong>부스팅샵</strong><p>필요한 마케팅 단위를 골라 시작하는 셀프 서비스.</p><span>제품 소개 →</span></a>
                    <a class="subcard" href="{{ route('solutions.leadbay') }}"><strong>리드베이</strong><p>보험 영업조직의 DB 구매·상담·계약 흐름을 잇는 CRM.</p><span>제품 소개 →</span></a>
                    <a class="subcard" href="{{ route('solutions.call2sale') }}"><strong>콜투세일</strong><p>보험DB 콜센터의 생산·납품·정산 흐름을 관리하는 CRM.</p><span>제품 소개 →</span></a>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Ways To Work Together</span>
                <h2 class="landing__head">필요한 깊이에 맞춰 함께합니다</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>진단과 설계</strong><span>현재 구조를 감사하고 우선순위, KPI, 실행 로드맵을 정리합니다.</span></div>
                    <div class="landing__point"><strong>특정 영역 실행</strong><span>광고 채널, CPA, 리워드, SEO, 웹 제작처럼 필요한 구간만 맡습니다.</span></div>
                    <div class="landing__point"><strong>통합 운영</strong><span>유입부터 전환·콘텐츠·페이지 개선까지 하나의 리듬으로 운영합니다.</span></div>
                    <div class="landing__point"><strong>솔루션 도입</strong><span>반복되는 운영 문제는 제이커브가 만든 제품으로 연결해 검토합니다.</span></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="anarchy">
            <div class="landing__inner">
                <span class="landing__eyebrow">Anarchy · YouTube</span>
                <h2 class="landing__head">2011년부터, 현장에서 배운 것을 공개해왔습니다</h2>
                <div class="prose">
                    <p>총괄이사가 직접 운영하는 ‘아나키’ 채널은 마케팅 현장에서 실행하고 확인한 내용을 다룹니다. 유행하는 말을 반복하기보다 실제 운영자가 무엇을 보고 판단해야 하는지 설명합니다.</p>
                </div>
                <div class="cta-row" style="margin-top:24px;">
                    <a class="btn-ghost" href="https://www.youtube.com/@anarchy" target="_blank" rel="noopener">아나키 채널 보기 →</a>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">제이커브와 일하기 전에</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item"><summary>{{ $faq['question'] }}</summary><p>{{ $faq['answer'] }}</p></details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>문제를 설명해 주세요.<br>실행 가능한 구조로 바꾸겠습니다.</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">광고, 검색, 리드, 리워드, 웹 중 무엇부터 시작할지 함께 정리합니다.</p>
                <div class="cta-row"><a class="btn-primary" href="{{ route('contact') }}">프로젝트 문의하기</a></div>
            </div>
        </section>
    </main>
@endsection
