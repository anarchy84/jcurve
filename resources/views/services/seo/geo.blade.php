@extends('layouts.app')

@php
    $faqs = [
        [
            'question' => 'GEO와 SEO는 무엇이 다른가요?',
            'answer' => 'SEO는 검색엔진의 수집·이해·노출과 검색 유입 전반을 다룹니다. GEO는 그 기반 위에서 생성형 AI가 회사·인물·서비스와 근거 자료를 혼동하지 않고 참고할 수 있도록 엔티티와 정보 출처를 더 집중적으로 정비합니다.',
        ],
        [
            'question' => 'GEO를 위해 새로운 콘텐츠를 모두 만들어야 하나요?',
            'answer' => '아닙니다. 기존 공식 페이지, 회사 자료, 서비스 문서와 콘텐츠를 먼저 감사해 재사용할 수 있는 근거와 불일치를 찾습니다. 부족한 질문과 근거만 우선순위에 따라 보강합니다.',
        ],
        [
            'question' => '외부 언급이나 인용도 필요한가요?',
            'answer' => '브랜드가 스스로 작성한 정보만으로는 확인 가능한 근거가 부족할 수 있습니다. 다만 관련성 없는 대량 노출을 만드는 것이 아니라, 실제 활동과 전문성을 확인할 수 있는 신뢰 가능한 출처와 정보 일관성이 중요합니다.',
        ],
        [
            'question' => '생성형 AI 노출은 어떻게 측정하나요?',
            'answer' => '사업과 관련된 표본 질문을 정하고 답변의 브랜드 언급, 설명 정확성, 연결된 출처와 문맥을 날짜별로 기록합니다. 질문·계정·지역·시점에 따라 결과가 달라질 수 있음을 함께 표시합니다.',
        ],
        [
            'question' => 'ChatGPT나 다른 AI의 추천을 보장하나요?',
            'answer' => '보장하지 않습니다. GEO는 생성 시스템이 브랜드와 정보를 정확히 이해하고 참고할 수 있는 조건을 개선하는 작업이며, 최종 답변과 추천은 각 시스템이 결정합니다.',
        ],
        [
            'question' => 'GEO를 하려면 사이트를 새로 만들어야 하나요?',
            'answer' => '아닙니다. 운영 중인 페이지에 메타 설명, 이미지 대체 텍스트, 구조화 데이터, 요약·Q&A 블록을 더하는 방식으로 시작합니다. 이미 가진 상세 설명과 이미지 속 정보를 AI가 읽을 수 있는 글로 옮기는 것이 먼저입니다.',
        ],
        [
            'question' => 'AI 답변에 브랜드가 언급되면 성과인가요?',
            'answer' => '언급은 출발점입니다. AI가 브랜드를 알고 있어도 출처로는 다른 블로그나 쇼핑몰이 붙을 수 있습니다. 그래서 브랜드 언급률보다 우리 도메인과 상세 페이지가 출처로 인용되는 비율에 더 무게를 둡니다.',
        ],
        [
            'question' => 'GEO 성과는 얼마 만에 판단하나요?',
            'answer' => '적용 전에 고정한 질문으로 기준선을 기록하고, 사이트 반영일부터 같은 질문을 반복해 주 단위로 비교합니다. AI 답변은 물을 때마다 달라지므로 하루 결과가 아니라 몇 주의 흐름으로 판단하며, 정해진 기간 안의 변화를 약속하지 않습니다.',
        ],
        [
            'question' => 'GEO로 매출 효과까지 알 수 있나요?',
            'answer' => 'GEO 측정은 AI 답변 속 언급과 인용을 다룹니다. 유입과 전환은 고객사의 분석 도구에서 AI 서비스 유입 경로를 함께 보며 판단해야 하고, 노출 자체가 매출을 보장하지는 않습니다.',
        ],
    ];
@endphp

@section('title', 'GEO 생성엔진 최적화 — AI가 이해하는 브랜드 정보 | 제이커브인터렉티브')
{{-- 위치 경로·서비스 구조화 데이터(head 에서 조립) — SEO-KW-02 (2026-11-04) --}}
@section('sd_page', 'GEO 생성엔진 최적화')
@section('sd_crumbs', '서비스=/services|SEO=/seo/')
@section('sd_service', '생성엔진 최적화(GEO)')
@section('meta')
    <meta name="description" content="생성형 AI가 회사·인물·서비스와 근거 정보를 혼동하지 않도록 엔티티와 공식 소스, AI가 읽을 수 있는 페이지 정보와 기술 접근성을 정비하고, 고정한 질문으로 언급률·인용률을 비교하는 GEO 생성엔진 최적화.">
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
    @include('partials.jc.viz.kit')
    <main class="landing">
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위 서비스">
                    <a href="{{ route('services.show', ['slug' => 'seo']) }}">SEO · AEO · GEO</a>
                </nav>
                <span class="landing__eyebrow">GEO</span>
                <h1>생성형 AI가 브랜드를 혼동하지 않도록</h1>
                <p class="landing__lead">회사·인물·서비스·근거 자료를 일관된 엔티티로 정리하고, 생성형 AI가 참고할 수 있는 명확한 디지털 자산을 구축합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">GEO 진단 요청</a>
                    <a class="btn-ghost" href="{{ route('seo.check') }}">무료 GEO·AEO 자가진단 →</a>
                </div>
            </div>
        </section>

    @include('partials.jc.fig.geo')

        <nav class="landing__local-nav" aria-label="GEO 페이지 내 탐색">
            <div class="landing__local-nav-inner">
                <a href="#geo-problem">문제</a>
                <a href="#geo-entity">엔티티</a>
                <a href="#geo-sources">근거·출처</a>
                <a href="#geo-content">콘텐츠·기술</a>
                <a href="#geo-readable">AI가 읽는 정보</a>
                <a href="#geo-quality">원문 대조</a>
                <a href="#geo-questions">질문 설계</a>
                <a href="#geo-process">진행 과정</a>
                <a href="#geo-deliverables">제공 항목</a>
                <a href="#geo-metrics">성과 지표</a>
                <a href="#geo-monitoring">측정·한계</a>
                <a href="#geo-faq">FAQ</a>
            </div>
        </nav>

        <section id="geo-problem" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">The Problem</span>
                <h2 class="landing__head">웹 곳곳의 브랜드 정보가 서로 다르면</h2>
                <div class="prose">
                    <p>회사명, 대표 정보, 서비스 범위와 설명이 공식 사이트·플랫폼·기사·프로필마다 다르면 사람도 생성형 AI도 같은 대상을 확신하기 어렵습니다. 오래된 설명이 남아 있으면 현재 사업과 다른 답이 만들어질 수도 있습니다.</p>
                    <p>GEO는 AI에게 특정 문장을 외우게 하는 작업이 아닙니다. 브랜드의 공식 원본을 분명히 하고, 확인 가능한 사실과 출처가 서로 모순되지 않도록 디지털 자산을 정리하는 일입니다.</p>
                </div>
                <div class="landing__callout">브랜드를 많이 말하는 것보다, 누구인지 일관되게 증명하는 것이 먼저입니다.</div>
            </div>
        </section>

        <section id="geo-entity" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Entity</span>
                <h2 class="landing__head">회사·인물·서비스의 관계를 한 장으로 정리합니다</h2>
                <p class="landing__body">동일하거나 비슷한 이름을 구분하고, 브랜드가 제공하는 서비스와 운영하는 제품이 어떤 관계인지 명확히 표현합니다.</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>조직</strong><span>법인명, 브랜드명, 공식 설명, 위치와 공식 연락 채널을 일관되게 정리합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>인물</strong><span>대표·전문가·작성자의 역할과 실제 전문 분야, 조직과의 관계를 명확히 합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>서비스</strong><span>무엇을 누구에게 어떤 범위로 제공하는지 서비스별 정의를 통일합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>제품</strong><span>자체 솔루션과 외부 서비스의 소유·운영·연결 관계를 구분합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>전문 주제</strong><span>브랜드가 반복적으로 설명하고 실제 자료로 뒷받침할 수 있는 주제를 연결합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>공식 원본</strong><span>변경되는 정보가 처음 업데이트되고 다른 채널이 참조할 기준 페이지를 정합니다.</span></div>
                </div>
            </div>
        </section>

        <section id="geo-sources" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Evidence &amp; Sources</span>
                <h2 class="landing__head">주장보다 확인 가능한 근거를 늘립니다</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>브랜드가 직접 관리할 원본</h3>
                        <ul>
                            <li>회사와 서비스의 공식 소개 페이지</li>
                            <li>작성자·수정일이 있는 전문 콘텐츠</li>
                            <li>방법론, 정책, FAQ와 기술 문서</li>
                            <li>실제 제공 범위와 한계를 밝힌 자료</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>외부에서 확인되는 신호</h3>
                        <ul>
                            <li>실제 활동을 설명하는 관련성 높은 언급</li>
                            <li>공식 프로필과 플랫폼 정보의 일치</li>
                            <li>서비스 또는 연구를 인용하는 신뢰 가능한 출처</li>
                            <li>오래된 정보와 오류의 수정 상태</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">관련성 없는 대량 언급이나 출처를 꾸미는 방식은 신뢰 근거가 아닙니다. 실제 활동과 확인 가능한 자료를 기준으로 정리합니다.</p>
            </div>
        </section>

        <section id="geo-content" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Content &amp; Technology</span>
                <h2 class="landing__head">인용하기 쉬운 문서와 접근 가능한 기술 기반</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>콘텐츠 원칙</h3>
                        <ul>
                            <li>정의와 결론을 먼저 말합니다.</li>
                            <li>사실, 의견, 추정과 사례를 구분합니다.</li>
                            <li>조건과 예외, 업데이트 날짜를 표시합니다.</li>
                            <li>한 문서가 답할 질문 범위를 명확히 합니다.</li>
                            <li>근거와 원본 자료로 이동할 수 있게 합니다.</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>기술 원칙</h3>
                        <ul>
                            <li>중요 페이지의 크롤링·색인 가능 여부</li>
                            <li>중복 URL과 canonical 정리</li>
                            <li>조직·인물·서비스 관계의 구조화 데이터</li>
                            <li>사이트맵과 내부 링크</li>
                            <li>화면 콘텐츠와 마크업의 일치</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- GEO 방법론 보강(SEO-GEO-02, 2026-11-17 제코 지시 「다운로드 PDF 4개 내용 싹 다 반영」).
             참고 자료: 외부 GEO·AI 검색 제품소개서 4종(2026-11-17 수령). 문장·사례·성과 숫자·회사명은 옮기지 않고, 방법(진단 3단계·질문 설계·
             기준선 비교·인용 지표·원문 대조 검토·이미지 속 글자의 텍스트화)만 제이커브 표현으로 새로 썼다. 성과 보장·새 숫자 없음. --}}
        <section id="geo-readable" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">What AI Reads</span>
                <h2 class="landing__head">사람이 보는 화면과 AI가 읽는 정보는 다릅니다</h2>
                <p class="landing__body">사람 눈에는 잘 보이는 페이지라도 AI가 수집하는 과정에서 핵심 내용이 빠질 수 있습니다. 이미지 안의 글자는 읽히지 않고, 화면과 코드의 정보가 서로 다르면 AI는 코드 쪽을 근거로 삼기 쉽습니다.</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>이미지 속 글자</strong><span>상세 설명·가격표·사양을 통이미지로만 올리면 사람은 읽어도 AI가 읽을 글자 정보가 없습니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>화면과 코드의 불일치</strong><span>화면 가격과 구조화 데이터의 가격이 다르거나, 화면에 없는 효능이 코드에만 적혀 있으면 잘못된 답의 원인이 됩니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>비어 있는 설명</strong><span>구조화 데이터의 설명 칸이 비어 있거나 이미지 대체 텍스트가 없으면 AI가 페이지를 이해할 단서가 줄어듭니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>페이지와 맞지 않는 메타 설명</strong><span>모든 페이지에 회사 소개 한 줄이 똑같이 들어가 있으면 그 페이지가 무엇에 답하는지 알 수 없습니다.</span></div>
                </div>
                <div class="landing__split" style="margin-top:28px;">
                    <div class="landing__panel">
                        <h3>기술 진단 — 세 가지를 순서대로 확인합니다</h3>
                        <ul>
                            <li><strong>접근할 수 있는가</strong> — robots.txt, AI 크롤러 차단, 방화벽·접속 대기열 설정</li>
                            <li><strong>실제 내용을 읽을 수 있는가</strong> — 핵심 정보가 처음 받는 HTML 안에 글자로 들어 있는지</li>
                            <li><strong>올바르게 이해할 수 있는가</strong> — 대표 URL, 색인, 메타 정보, 구조화 데이터</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>진단 결과는 두 갈래로 나눕니다</h3>
                        <ul>
                            <li><strong>기술 보완 과제</strong> — 개발팀이 고칠 접근·렌더링·마크업 문제</li>
                            <li><strong>콘텐츠 보강 과제</strong> — 이미지 속 정보의 텍스트화, 요약·Q&amp;A, 설명 보강</li>
                        </ul>
                        <p>사이트를 새로 만들지 않고, 운영 중인 페이지와 이미 가진 이미지·설명에서 시작합니다.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="geo-quality" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Source-faithful Content</span>
                <h2 class="landing__head">페이지에 없는 내용은 쓰지 않습니다</h2>
                <p class="landing__body">AI가 읽을 글을 보강할 때 원칙은 하나입니다. 원본 페이지와 자료에서 확인되는 사실만 씁니다. 보이는 설명과 구조화 데이터가 서로 다른 조건·효능을 말하지 않도록 사실과 표현 수준을 맞춥니다.</p>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>보강하는 산출물</h3>
                        <ul>
                            <li><strong>메타 설명</strong> — 그 페이지가 답하는 내용을 한두 문장으로 요약</li>
                            <li><strong>이미지 대체 텍스트</strong> — 이미지에 담긴 특징을 글로 설명</li>
                            <li><strong>구조화 데이터(JSON-LD)</strong> — 화면과 같은 사실을 기계가 읽는 형식으로</li>
                            <li><strong>요약·Q&amp;A 블록</strong> — 핵심 요약, 쓰임새, 구매·문의 전 질문과 답</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>원문과 한 문장씩 대조해 거르는 것</h3>
                        <ul>
                            <li>원문에 없는 효과·특징을 덧붙인 문장</li>
                            <li>원문과 달라진 숫자·단위·조건</li>
                            <li>확인되지 않는 인증·수상·특허 표현</li>
                            <li>"최고", "유일" 같은 근거 없는 단정과 과장</li>
                            <li>확인할 수 없는 항목 — 만들지 않고 "확인 불가"로 남깁니다</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">요약·Q&amp;A 블록은 접어서 보여 줘도 HTML 안에 글자로 들어 있으면 읽힙니다. 적용 위치는 페이지 구조에 맞춰 함께 정하고, 건강·의료처럼 표현에 민감한 업종은 담당자의 최종 검토를 거칩니다.</p>
            </div>
        </section>

        <section id="geo-questions" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Question Design</span>
                <h2 class="landing__head">고객이 AI에게 실제로 할 질문부터 설계합니다</h2>
                <p class="landing__body">고객은 이제 키워드 대신 상황과 조건을 문장으로 묻습니다. 그래서 무엇을 고칠지 정하기 전에, 어떤 질문에서 우리 브랜드가 설명되고 인용되어야 하는지부터 정합니다. 이 질문 목록이 고칠 대상과 성과 비교의 기준이 됩니다.</p>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr><th scope="col">질문 유형</th><th scope="col">예시 질문</th><th scope="col">확인하는 것</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">카테고리·관심 영역</th><td>"플레이스 마케팅 대행사 어떻게 골라?"</td><td>분야 전체 질문에서 우리가 후보로 나오는지</td></tr>
                            <tr><th scope="row">고객층·지역·사용 상황</th><td>"성수동에서 처음 식당 연 사장님이 할 마케팅"</td><td>특정 상황에 맞는 답으로 연결되는지</td></tr>
                            <tr><th scope="row">브랜드·판매처</th><td>"○○는 어떤 회사야?"</td><td>회사·서비스 설명이 정확하고 공식 페이지가 출처로 붙는지</td></tr>
                            <tr><th scope="row">특정 상품·서비스</th><td>"○○의 △△ 서비스는 어떻게 진행돼?"</td><td>해당 상세 페이지까지 연결되는지</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="landing__points" style="margin-top:28px;">
                    <div class="landing__point landing__point--light"><strong>목표</strong><span>무엇을 찾는가 — 예: 면접용 재킷, 매장 홍보 방법</span></div>
                    <div class="landing__point landing__point--light"><strong>상황</strong><span>언제·어디서 필요한가 — 예: 다음 주, 가을 결혼식, 신규 오픈</span></div>
                    <div class="landing__point landing__point--light"><strong>선택 기준</strong><span>무엇으로 고르는가 — 예: 예산, 소재, 진행 기간</span></div>
                    <div class="landing__point landing__point--light"><strong>신뢰 근거</strong><span>무엇을 보고 믿는가 — 예: 후기, 인증, 사례 출처</span></div>
                    <div class="landing__point landing__point--light"><strong>걱정</strong><span>무엇이 망설여지는가 — 예: 사이즈, 효과 보장, 위험 신호</span></div>
                </div>
                <p class="landing__note">문장형 질문에 담긴 다섯 가지 신호를 나눠 보면, 페이지에 어떤 정보가 비어 있는지가 드러납니다. 질문은 사업 영역을 조사해 초안을 만들고, 고객사 검토를 거쳐 확정한 뒤 측정을 시작합니다. 업종마다 AI가 찾는 정보가 다르므로(매장은 위치·영업 정보·메뉴와 가격, 쇼핑몰 상품은 소재·사이즈·사용 상황, B2B 서비스는 제공 범위·절차·비용 기준) 질문 유형과 검토 기준도 업종에 맞춥니다.</p>
            </div>
        </section>

        <section id="geo-process" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Process</span>
                <h2 class="landing__head">현재 답변을 확인하고, 원본부터 고칩니다</h2>
                <div class="steps">
                    <div class="steps__item"><strong>브랜드와 목표 질문을 정의합니다</strong><p>어떤 회사·인물·서비스가 어떤 질문에서 정확히 설명되어야 하는지 정합니다.</p></div>
                    <div class="steps__item"><strong>현재 정보와 답변을 감사하고 기준선을 기록합니다</strong><p>공식 사이트와 주요 외부 채널의 설명을 점검하고, 고정한 질문으로 지금의 AI 답변·언급·출처를 기록해 비교 기준으로 삼습니다.</p></div>
                    <div class="steps__item"><strong>엔티티와 정보 불일치를 정리합니다</strong><p>같은 대상을 다르게 설명하는 문구와 오래된 정보를 찾아 기준 원본을 정합니다.</p></div>
                    <div class="steps__item"><strong>근거 문서와 콘텐츠를 보강합니다</strong><p>정의·비교·방법·조건 등 부족한 질문의 답과 확인 가능한 자료를 연결합니다.</p></div>
                    <div class="steps__item"><strong>기술 접근성과 마크업을 정비합니다</strong><p>수집, URL, 내부 링크와 구조화 데이터를 화면 정보에 맞춰 적용합니다.</p></div>
                    <div class="steps__item"><strong>반영일 기준으로 같은 질문을 다시 측정합니다</strong><p>사이트에 반영한 날짜를 기준점으로 두고, 언급 여부뿐 아니라 설명의 정확성, 인용된 출처가 어떻게 달라지는지 주 단위로 기록합니다. 결과를 보고 보강·반영·재측정을 반복합니다.</p></div>
                </div>
            </div>
        </section>

        <section id="geo-deliverables" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Deliverables</span>
                <h2 class="landing__head">브랜드팀·콘텐츠팀·개발팀이 공유할 기준</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>엔티티 맵</strong><span>회사·인물·서비스·제품과 공식 원본의 관계를 정리합니다.</span></div>
                    <div class="landing__point"><strong>정보 불일치 목록</strong><span>채널별로 다른 설명과 오래된 정보를 찾아 수정 우선순위를 제시합니다.</span></div>
                    <div class="landing__point"><strong>소스 페이지 설계</strong><span>정의, 회사 정보, 서비스 범위와 근거가 모일 공식 문서를 설계합니다.</span></div>
                    <div class="landing__point"><strong>콘텐츠 브리프</strong><span>중요 질문별 핵심 답, 근거, 조건과 관련 문서를 정의합니다.</span></div>
                    <div class="landing__point"><strong>기술 적용안</strong><span>URL, 내부 링크, 크롤링과 구조화 데이터의 개선 범위를 정리합니다.</span></div>
                    <div class="landing__point"><strong>표본 질문 모니터링표</strong><span>질문, 날짜, 답변, 언급, 출처와 오류를 같은 형식으로 기록합니다.</span></div>
                    <div class="landing__point"><strong>페이지 반영안</strong><span>메타 설명, 이미지 대체 텍스트, 구조화 데이터, 요약·Q&amp;A 블록을 원문과 대조한 뒤 전달합니다.</span></div>
                    <div class="landing__point"><strong>주간 리포트</strong><span>지표 변화, 밀리는 질문과 대신 인용된 출처, 다음에 보강할 페이지를 정리합니다. 답변 원문과 인용 URL도 함께 남깁니다.</span></div>
                </div>
            </div>
        </section>

        <section id="geo-metrics" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Metrics</span>
                <h2 class="landing__head">이름이 나왔다는 것만으로 성과를 판단하지 않습니다</h2>
                <p class="landing__body">AI가 브랜드를 아는 것과, 답변의 출처로 우리 사이트를 붙이는 것은 다릅니다. 아래로 갈수록 실제 방문에 가까운 지표라서, 언급보다 인용에 무게를 둡니다.</p>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr><th scope="col">지표</th><th scope="col">묻는 것</th><th scope="col">계산 기준</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">브랜드 언급률</th><td>AI가 우리를 알고 있나요?</td><td>답변 본문에 브랜드가 나온 응답 ÷ 전체 응답</td></tr>
                            <tr><th scope="row">브랜드 추천률</th><td>이름만이 아니라 권하고 있나요?</td><td>추천 문장에 브랜드가 함께 나온 응답 ÷ 전체 응답(판정이 들어가는 추정값)</td></tr>
                            <tr><th scope="row">도메인 인용률</th><td>출처로 우리 사이트가 붙나요?</td><td>출처에 우리 도메인 URL이 포함된 응답 ÷ 전체 응답</td></tr>
                            <tr><th scope="row">상세 페이지 인용률</th><td>그 상품·서비스 페이지까지 연결되나요?</td><td>출처에 우리 상세 페이지 URL이 포함된 응답 ÷ 전체 응답</td></tr>
                            <tr><th scope="row">자사 출처 비중</th><td>인용된 출처 중 공식 채널은 얼마나 되나요?</td><td>자사·공식 채널 출처 ÷ 답변이 인용한 전체 출처</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="steps" style="margin-top:28px;">
                    <div class="steps__item"><strong>적용 전 — 기준선</strong><p>고정한 질문으로 현재 수치를 기록합니다.</p></div>
                    <div class="steps__item"><strong>사이트 반영</strong><p>반영한 날짜를 기준점으로 공유합니다.</p></div>
                    <div class="steps__item"><strong>반영 후 1~2주</strong><p>기준선 대비 변화와, 변화가 이어지는지 확인합니다.</p></div>
                    <div class="steps__item"><strong>3주 이후</strong><p>추세를 보고 다음 개선 과제를 정리합니다.</p></div>
                </div>
                <p class="landing__note">응답 1건은 질문 1개 × AI 1개 × 수집 1회입니다. AI 답변은 물을 때마다 달라지므로 같은 질문을 반복해 묻고 몇 주의 흐름으로 판단합니다. 처음부터 유지한 질문으로 기간을 비교하고, 바꾸거나 더한 질문은 바꾼 시점부터 따로 측정합니다. AI마다 출처를 표시하는 방식이 달라 같은 AI 안의 추세를 중심으로 봅니다.</p>
            </div>
        </section>

        <section id="geo-monitoring" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Monitoring &amp; Limits</span>
                <h2 class="landing__head">추천 여부보다, 정확히 설명되는지부터</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>관찰할 항목</h3>
                        <ul>
                            <li>표본 질문별 브랜드 언급 여부</li>
                            <li>회사·서비스 설명의 정확성</li>
                            <li>경쟁 브랜드와 구분되는 문맥</li>
                            <li>답변에 연결된 출처</li>
                            <li>오래된 정보와 사실 오류</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>보장할 수 없는 것</h3>
                        <ul>
                            <li>특정 생성형 AI의 언급·추천</li>
                            <li>모든 사용자에게 동일한 답변</li>
                            <li>고정 기간 안의 노출 변화</li>
                            <li>외부 시스템의 수집·학습 시점</li>
                            <li>노출 자체가 만드는 매출·전환</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">표본 답변은 계정, 위치, 언어, 질문 표현과 시점에 따라 달라질 수 있습니다. 관찰 조건을 함께 기록하며 전체 결과로 일반화하지 않습니다.</p>
            </div>
        </section>

        <section id="geo-faq" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">GEO를 시작하기 전에</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item">
                            <summary>{{ $faq['question'] }}</summary>
                            <p>{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
                <div class="subcards">
                    <a class="subcard" href="{{ route('insights.show', ['insight' => 'geo-성과-측정-언급률-인용률-지표']) }}"><strong>GEO 성과 측정 방법</strong><p>언급률보다 인용률을 보는 이유와 다섯 가지 지표의 계산 기준.</p><span>글 읽기 →</span></a>
                    <a class="subcard" href="{{ route('insights.show', ['insight' => 'ai-답변-출처가-되는-페이지-만드는-법']) }}"><strong>AI 답변의 출처가 되는 페이지</strong><p>이미지 속 글자, 구조화 데이터, 요약·Q&amp;A 블록 정비 방법.</p><span>글 읽기 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.aeo') }}"><strong>AEO도 함께 보기</strong><p>사용자의 질문에 바로 답하는 콘텐츠 구조를 설계합니다.</p><span>AEO 자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'seo']) }}"><strong>SEO 전체 서비스</strong><p>기술·콘텐츠·신뢰·전환을 함께 보는 검색 최적화.</p><span>SEO 자세히 →</span></a>
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>AI가 지금 우리 회사를 어떻게 설명하는지부터</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">공식 사이트와 중요한 브랜드·서비스, 확인하고 싶은 질문을 알려주시면 정보 불일치와 우선 진단 범위를 정리하겠습니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">GEO 진단 요청</a>
                    <a class="btn-ghost" href="{{ route('seo.check') }}">무료 GEO·AEO 자가진단 →</a>
                </div>
            </div>
        </section>
    </main>
@endsection
