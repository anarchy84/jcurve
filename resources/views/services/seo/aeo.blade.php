@extends('layouts.app')

@php
    $faqs = [
        [
            'question' => '기존 콘텐츠를 그대로 활용할 수 있나요?',
            'answer' => '가능합니다. 기존 문서에서 실제 질문에 답하는 부분과 근거를 먼저 찾고, 결론·조건·예외·관련 문서의 순서로 재구성합니다. 모든 콘텐츠를 새로 쓸 필요는 없습니다.',
        ],
        [
            'question' => 'AEO와 일반 SEO는 무엇이 다른가요?',
            'answer' => 'SEO가 페이지의 발견·이해·신뢰 전반을 다룬다면 AEO는 그 기반 위에서 사용자의 질문에 명확하게 답할 수 있는 정보 단위와 문서 구조를 더 집중적으로 설계합니다.',
        ],
        [
            'question' => 'FAQ 구조화 데이터만 넣으면 되나요?',
            'answer' => '아닙니다. 구조화 데이터는 화면에 실제로 존재하는 내용을 설명하는 보조 수단입니다. 답변의 정확성, 근거, 페이지 품질과 검색 시스템의 판단이 함께 작용합니다.',
        ],
        [
            'question' => 'AEO 성과는 어떻게 확인하나요?',
            'answer' => '질문군별 검색 노출과 클릭, 해당 페이지의 행동·전환, 표본 검색 결과에서의 답변 노출과 출처를 함께 기록합니다. 표본 결과가 전체 사용자 결과를 대표한다고 단정하지 않습니다.',
        ],
        [
            'question' => '답변 영역이나 AI 요약 노출을 보장하나요?',
            'answer' => '보장하지 않습니다. AEO는 검색·답변 시스템이 내용을 이해하고 참고하기 쉬운 조건을 만드는 작업이며, 최종 노출 방식은 각 시스템이 결정합니다.',
        ],
    ];
@endphp

@section('title', 'AEO 답변엔진 최적화 — 질문에 답하는 콘텐츠 구조 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="사용자의 질문을 분해하고 핵심 답변·근거·조건·관련 문서를 명확하게 연결하는 AEO 답변엔진 최적화. 콘텐츠 구조, 내부 링크, 구조화 데이터와 측정 기준을 설계합니다.">
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
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
                <nav class="subpage__breadcrumb" aria-label="상위 서비스">
                    <a href="{{ route('services.show', ['slug' => 'seo']) }}">SEO · AEO · GEO</a>
                </nav>
                <span class="landing__eyebrow">AEO</span>
                <h1>질문 바로 아래, 답이 보이는 콘텐츠</h1>
                <p class="landing__lead">사용자가 묻는 질문을 분해하고, 결론·근거·조건·다음 행동이 한 문서 안에서 명확히 연결되도록 설계합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">AEO 진단 요청</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="AEO 페이지 내 탐색">
            <div class="landing__local-nav-inner">
                <a href="#aeo-problem">문제</a>
                <a href="#aeo-questions">질문 맵</a>
                <a href="#aeo-anatomy">답변 구조</a>
                <a href="#aeo-technical">기술 기반</a>
                <a href="#aeo-process">진행 과정</a>
                <a href="#aeo-deliverables">제공 항목</a>
                <a href="#aeo-measurement">측정·한계</a>
                <a href="#aeo-faq">FAQ</a>
            </div>
        </nav>

        <section id="aeo-problem" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">The Problem</span>
                <h2 class="landing__head">길게 쓴다고 답이 되는 것은 아닙니다</h2>
                <div class="prose">
                    <p>핵심 답이 여러 문단 뒤에 숨어 있거나, 주장만 있고 근거가 없거나, 하나의 페이지가 너무 많은 의도를 다루면 사용자도 검색 시스템도 문서의 역할을 이해하기 어렵습니다.</p>
                    <p>AEO는 글을 짧게 줄이는 작업도, FAQ를 무작정 늘리는 작업도 아닙니다. 누가 어떤 상황에서 무엇을 묻고 있으며 어디까지 답해야 하는지 정하는 정보 설계입니다.</p>
                </div>
                <div class="landing__callout">좋은 답변은 결론이 빠르고, 조건이 정직하며, 근거를 확인할 수 있습니다.</div>
            </div>
        </section>

        <section id="aeo-questions" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Question Map</span>
                <h2 class="landing__head">키워드를 실제 질문으로 바꿉니다</h2>
                <p class="landing__body">같은 키워드 안에도 서로 다른 의도가 섞여 있습니다. 질문의 종류를 나눠야 한 페이지가 맡아야 할 답의 범위가 보입니다.</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>정의형</strong><span>무엇인가, 어떤 원리인가, 누구를 위한 것인가.</span></div>
                    <div class="landing__point landing__point--light"><strong>비교형</strong><span>무엇이 다른가, 어떤 경우에 어느 선택이 적합한가.</span></div>
                    <div class="landing__point landing__point--light"><strong>방법형</strong><span>어떤 순서로 시작하고 준비해야 하는가.</span></div>
                    <div class="landing__point landing__point--light"><strong>조건형</strong><span>가능한 범위, 필요한 요건, 예외와 제한은 무엇인가.</span></div>
                    <div class="landing__point landing__point--light"><strong>비용·기간형</strong><span>무엇이 비용과 일정에 영향을 주며 어떻게 범위를 산정하는가.</span></div>
                    <div class="landing__point landing__point--light"><strong>위험형</strong><span>실패 원인, 주의사항, 보장할 수 없는 것은 무엇인가.</span></div>
                </div>
            </div>
        </section>

        <section id="aeo-anatomy" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Answer Anatomy</span>
                <h2 class="landing__head">짧은 답, 충분한 근거, 명확한 출처</h2>
                <div class="steps">
                    <div class="steps__item"><strong>핵심 답변</strong><p>질문 바로 아래에서 결론을 먼저 말합니다. 수식어보다 판단에 필요한 내용을 앞에 둡니다.</p></div>
                    <div class="steps__item"><strong>세부 설명</strong><p>답이 왜 그런지 사용자가 이해할 수 있는 용어와 구조로 풀어냅니다.</p></div>
                    <div class="steps__item"><strong>조건과 예외</strong><p>항상 성립하지 않는 부분과 적용 범위를 숨기지 않습니다.</p></div>
                    <div class="steps__item"><strong>근거와 출처</strong><p>자체 주장, 공식 자료, 관찰 결과를 구분하고 확인 가능한 근거를 연결합니다.</p></div>
                    <div class="steps__item"><strong>관련 문서와 다음 행동</strong><p>더 깊은 질문의 답과 문의·진단 등 자연스러운 다음 단계로 이어줍니다.</p></div>
                </div>
            </div>
        </section>

        <section id="aeo-technical" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Technical Foundation</span>
                <h2 class="landing__head">좋은 답도 읽히지 않으면 선택될 수 없습니다</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>문서 구조</h3>
                        <ul>
                            <li>한 페이지의 명확한 제목과 주제</li>
                            <li>질문을 드러내는 제목 계층</li>
                            <li>관련 문서를 잇는 내부 링크</li>
                            <li>작성자·수정일·책임 주체 표시</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>검색 접근성</h3>
                        <ul>
                            <li>크롤링과 색인 가능 여부</li>
                            <li>중복 URL과 canonical</li>
                            <li>화면 콘텐츠와 일치하는 구조화 데이터</li>
                            <li>모바일·성능·기본 접근성</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">FAQ·HowTo 등 구조화 데이터는 실제 화면에 같은 내용이 존재하고 해당 유형의 요구사항을 충족할 때만 적용합니다.</p>
            </div>
        </section>

        <section id="aeo-process" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Process</span>
                <h2 class="landing__head">질문을 모으고, 답을 배치하고, 빈틈을 확인합니다</h2>
                <div class="steps">
                    <div class="steps__item"><strong>대상과 목표 질문을 정합니다</strong><p>고객 문의, 검색어, 영업 현장의 질문과 기존 콘텐츠를 함께 확인합니다.</p></div>
                    <div class="steps__item"><strong>질문군과 페이지 역할을 나눕니다</strong><p>한 페이지가 답할 질문과 별도 문서로 분리할 질문을 구분합니다.</p></div>
                    <div class="steps__item"><strong>답변과 근거를 편집합니다</strong><p>결론, 세부 설명, 조건, 출처가 이어지도록 기존 문서를 보강하거나 새로 작성합니다.</p></div>
                    <div class="steps__item"><strong>기술 구조를 적용합니다</strong><p>제목 계층, 내부 링크, 메타 정보와 적절한 구조화 데이터를 맞춥니다.</p></div>
                    <div class="steps__item"><strong>표본 질문과 검색 지표를 관찰합니다</strong><p>노출·클릭·행동과 답변 결과를 날짜와 질문 기준으로 기록해 다음 개선점을 찾습니다.</p></div>
                </div>
            </div>
        </section>

        <section id="aeo-deliverables" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Deliverables</span>
                <h2 class="landing__head">콘텐츠팀과 개발팀이 함께 쓸 수 있는 결과물</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>질문·의도 맵</strong><span>대상 사용자의 질문을 유형과 여정별로 정리합니다.</span></div>
                    <div class="landing__point"><strong>페이지 역할표</strong><span>각 URL이 답할 핵심 질문과 중복을 구분합니다.</span></div>
                    <div class="landing__point"><strong>콘텐츠 브리프·수정안</strong><span>핵심 답, 조건, 근거, 관련 문서와 CTA를 정의합니다.</span></div>
                    <div class="landing__point"><strong>내부 링크·마크업안</strong><span>문서 관계와 화면에 맞는 구조화 데이터 범위를 제시합니다.</span></div>
                    <div class="landing__point"><strong>표본 질문 세트</strong><span>기간별로 같은 기준으로 관찰할 질문과 확인 항목을 정합니다.</span></div>
                    <div class="landing__point"><strong>개선 우선순위</strong><span>영향도와 실행 난이도에 따라 다음 작업 순서를 남깁니다.</span></div>
                </div>
            </div>
        </section>

        <section id="aeo-measurement" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Measurement &amp; Limits</span>
                <h2 class="landing__head">노출 여부만 보지 않고, 답변 이후 행동까지</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>확인할 수 있는 신호</h3>
                        <ul>
                            <li>질문군별 검색 노출과 클릭</li>
                            <li>대상 페이지의 유입과 탐색</li>
                            <li>문의·가입 등 합의한 전환</li>
                            <li>표본 결과의 답변 노출과 출처</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>보장할 수 없는 것</h3>
                        <ul>
                            <li>특정 답변 영역이나 AI 요약 노출</li>
                            <li>모든 사용자에게 동일한 검색 결과</li>
                            <li>구조화 데이터만으로 얻는 순위 상승</li>
                            <li>고정 기간 안의 인용·전환 성과</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">표본 결과는 질문, 위치, 시점과 시스템에 따라 달라질 수 있습니다. 관찰 조건을 기록하고 추세로 판단합니다.</p>
            </div>
        </section>

        <section id="aeo-faq" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">AEO를 시작하기 전에</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item">
                            <summary>{{ $faq['question'] }}</summary>
                            <p>{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.seo.geo') }}"><strong>GEO도 함께 보기</strong><p>브랜드 엔티티와 인용 근거를 생성형 AI 관점에서 정비합니다.</p><span>GEO 자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'seo']) }}"><strong>SEO 전체 서비스</strong><p>기술·콘텐츠·신뢰·전환을 함께 보는 검색 최적화.</p><span>SEO 자세히 →</span></a>
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>고객이 실제로 묻는 질문부터 정리해 보세요</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">사이트 URL과 중요한 서비스, 자주 받는 고객 질문을 알려주시면 우선 진단할 문서부터 정리하겠습니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">AEO 진단 요청</a>
                </div>
            </div>
        </section>
    </main>
@endsection
