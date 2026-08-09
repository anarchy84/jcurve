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
    ];
@endphp

@section('title', 'GEO 생성엔진 최적화 — AI가 이해하는 브랜드 정보 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="생성형 AI가 회사·인물·서비스와 근거 정보를 혼동하지 않도록 엔티티, 공식 소스, 인용 가능한 콘텐츠와 기술 접근성을 정비하는 GEO 생성엔진 최적화.">
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
                <span class="landing__eyebrow">GEO</span>
                <h1>생성형 AI가 브랜드를 혼동하지 않도록</h1>
                <p class="landing__lead">회사·인물·서비스·근거 자료를 일관된 엔티티로 정리하고, 생성형 AI가 참고할 수 있는 명확한 디지털 자산을 구축합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">GEO 진단 요청</a>
                    <a class="btn-ghost" href="{{ route('seo.check') }}">무료 GEO·AEO 자가진단 →</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="GEO 페이지 내 탐색">
            <div class="landing__local-nav-inner">
                <a href="#geo-problem">문제</a>
                <a href="#geo-entity">엔티티</a>
                <a href="#geo-sources">근거·출처</a>
                <a href="#geo-content">콘텐츠·기술</a>
                <a href="#geo-process">진행 과정</a>
                <a href="#geo-deliverables">제공 항목</a>
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

        <section id="geo-process" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Process</span>
                <h2 class="landing__head">현재 답변을 확인하고, 원본부터 고칩니다</h2>
                <div class="steps">
                    <div class="steps__item"><strong>브랜드와 목표 질문을 정의합니다</strong><p>어떤 회사·인물·서비스가 어떤 질문에서 정확히 설명되어야 하는지 정합니다.</p></div>
                    <div class="steps__item"><strong>현재 정보와 답변을 감사합니다</strong><p>공식 사이트와 주요 외부 채널의 설명, 표본 AI 답변과 출처를 날짜별로 확인합니다.</p></div>
                    <div class="steps__item"><strong>엔티티와 정보 불일치를 정리합니다</strong><p>같은 대상을 다르게 설명하는 문구와 오래된 정보를 찾아 기준 원본을 정합니다.</p></div>
                    <div class="steps__item"><strong>근거 문서와 콘텐츠를 보강합니다</strong><p>정의·비교·방법·조건 등 부족한 질문의 답과 확인 가능한 자료를 연결합니다.</p></div>
                    <div class="steps__item"><strong>기술 접근성과 마크업을 정비합니다</strong><p>수집, URL, 내부 링크와 구조화 데이터를 화면 정보에 맞춰 적용합니다.</p></div>
                    <div class="steps__item"><strong>같은 질문으로 변화를 관찰합니다</strong><p>언급 여부뿐 아니라 설명의 정확성, 문맥과 출처가 어떻게 달라지는지 기록합니다.</p></div>
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
                </div>
            </div>
        </section>

        <section id="geo-monitoring" class="landing__section landing__section--light">
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

        <section id="geo-faq" class="landing__section landing__section--parchment">
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
