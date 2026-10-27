@extends('layouts.app')

@php
    $faqs = [
        [
            'question' => '디자인 시안과 수정 횟수는 어떻게 정하나요?',
            'answer' => '페이지 수, 디자인 방식, 승인 단계와 프로젝트 일정에 따라 달라집니다. 시안 범위와 수정 기준은 견적과 계약 단계에서 명확히 정합니다.',
        ],
        [
            'question' => '사이트 콘텐츠도 함께 작성하나요?',
            'answer' => '콘텐츠 구조와 페이지별 메시지를 함께 설계할 수 있습니다. 원고 작성, 자료 정리, 촬영·이미지 제작 범위는 개발 범위와 분리해 사전에 확정합니다.',
        ],
        [
            'question' => '기존 사이트와 검색 유입을 유지하며 이전할 수 있나요?',
            'answer' => '기존 URL, 검색 유입, 콘텐츠와 기능을 먼저 감사한 뒤 유지·통합·301 리다이렉트 범위를 정합니다. 이전 후에도 실제 URL과 색인 상태를 별도로 확인해야 합니다.',
        ],
        [
            'question' => '워드프레스로 만들면 검색 상위 노출이 보장되나요?',
            'answer' => '아닙니다. 워드프레스는 검색엔진이 접근하기 좋은 구조를 만들 수 있는 도구일 뿐입니다. 기술 기반, 콘텐츠, 경쟁도와 지속적인 운영이 함께 필요합니다.',
        ],
        [
            'question' => '오픈 후 유지보수도 가능한가요?',
            'answer' => '보안 업데이트, 백업, 장애 대응, 콘텐츠 수정 등 필요한 운영 항목을 확인해 별도 범위로 정할 수 있습니다. 소유권과 각 계정의 책임 주체도 인수인계 전에 정리합니다.',
        ],
    ];
@endphp

@section('title', '워드프레스 제작·운영 — 검색과 마케팅을 고려한 웹사이트 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="디자인만이 아니라 검색·광고·콘텐츠 운영과 전환 측정까지 고려한 워드프레스 제작·운영. 사이트맵, 반응형 화면, SEO 기반, 분석 이벤트와 인수인계를 연결합니다.">
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
        <section class="landing__hero landing__hero--media">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                <span class="landing__eyebrow">WordPress</span>
                <h1>검색·광고·운영까지 고려한 웹사이트를 만듭니다</h1>
                <p class="landing__lead">화면만 완성하는 제작이 아닙니다. 사용자가 찾고, 이해하고, 문의할 수 있으며 운영자가 계속 고칠 수 있는 구조를 설계합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">제작 범위 상담</a>
                </div>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'wordpress'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="워드프레스 제작 페이지 내 탐색">
            <div class="landing__local-nav-inner">
                <a href="#wordpress-problem">문제</a>
                <a href="#wordpress-planning">기획 기준</a>
                <a href="#wordpress-process">제작 과정</a>
                <a href="#wordpress-deliverables">제공 항목</a>
                <a href="#wordpress-seo">SEO 기반</a>
                <a href="#wordpress-measurement">측정</a>
                <a href="#wordpress-operations">운영·인수인계</a>
                <a href="#wordpress-fit">적합성</a>
                <a href="#wordpress-faq">FAQ</a>
            </div>
        </nav>

        <section id="wordpress-problem" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">The Problem</span>
                <h2 class="landing__head">예쁜데 운영할 수 없는 사이트</h2>
                <div class="prose">
                    <p>새 페이지를 만들 때마다 제작사에 요청해야 하고, 광고를 시작한 뒤에야 전환 측정이 빠졌다는 사실을 알게 됩니다. 검색엔진은 중요한 내용을 읽지 못하고, 운영자는 이미지 한 장도 마음대로 바꾸기 어렵습니다.</p>
                    <p>이 문제는 오픈 이후의 유지보수 문제가 아닙니다. 누구를 데려오고 어떤 행동을 만들며 누가 계속 운영할지 정하지 않은 채 화면부터 만들었기 때문에 생깁니다.</p>
                </div>
                <div class="landing__callout">홈페이지의 완성은 오픈이 아니라, 오픈한 뒤 팀이 직접 운영할 수 있는 상태입니다.</div>
            </div>
        </section>

        <section id="wordpress-planning" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Planning</span>
                <h2 class="landing__head">만들기 전에 다섯 가지를 정합니다</h2>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>사용자</strong><span>누가 어떤 문제를 해결하기 위해 방문하는지 구체적으로 정의합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>유입 경로</strong><span>검색, 광고, 직접 방문, 제휴 중 중요한 진입 경로와 첫 화면을 연결합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>목표 행동</strong><span>문의, 견적, 예약, 구매, 콘텐츠 탐색 중 페이지가 만들어야 할 다음 행동을 정합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>운영 주체</strong><span>어떤 콘텐츠를 누가 얼마나 자주 수정할지 확인해 관리자 구조를 설계합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>측정 기준</strong><span>오픈 뒤 무엇을 성과로 볼지 정하고 필요한 이벤트와 분석 도구를 연결합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>확장 계획</strong><span>블로그, 랜딩페이지, 다국어, 외부 시스템 등 이후에 붙을 기능을 미리 고려합니다.</span></div>
                </div>
            </div>
        </section>

        <section id="wordpress-process" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Process</span>
                <h2 class="landing__head">저희가 짓는 순서</h2>
                <p class="landing__lead">디자인보다 먼저 구조를 정하고, 개발보다 먼저 운영 방식을 확인합니다.</p>
                <div class="steps">
                    <div class="steps__item">
                        <strong>목표·사용자·콘텐츠 조사</strong>
                        <p>사업 자료와 고객 질문, 경쟁 환경, 기존 사이트 자산을 확인합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>사이트맵과 전환 동선</strong>
                        <p>페이지 역할을 나누고 사용자가 원하는 정보에서 CTA까지 이동하는 흐름을 설계합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>와이어프레임과 디자인</strong>
                        <p>정보 우선순위를 화면으로 옮기고 브랜드의 색·서체·이미지 원칙을 맞춥니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>콘텐츠·컴포넌트 개발</strong>
                        <p>반복되는 요소를 재사용 가능한 구조로 만들고 운영자가 수정할 영역을 구분합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>SEO·속도·접근성 기본 설정</strong>
                        <p>시맨틱 구조, 메타 정보, 사이트맵, 이미지, 성능과 기본 접근성을 점검합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>폼·분석·이벤트 QA</strong>
                        <p>문의와 주요 행동이 실제로 작동하고 기록되는지 데스크톱과 모바일에서 확인합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>오픈과 운영 인수인계</strong>
                        <p>도메인·호스팅·관리자·백업·업데이트 책임과 운영 방법을 정리합니다.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="wordpress-deliverables" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Deliverables</span>
                <h2 class="landing__head">무엇이 만들어지고, 어디까지 넘겨받는가</h2>
                <p class="landing__body">프로젝트마다 범위는 다르지만 제작물과 운영 책임을 계약 전에 구분합니다.</p>
                <ul class="landing__evidence">
                    <li><strong>사이트맵과 페이지 목록</strong> — 각 URL의 목적과 필요한 콘텐츠를 정리합니다.</li>
                    <li><strong>핵심 화면 설계</strong> — 주요 사용자 흐름과 반응형 화면을 설계합니다.</li>
                    <li><strong>관리 가능한 콘텐츠 구조</strong> — 반복 콘텐츠와 운영자가 수정할 필드를 구분합니다.</li>
                    <li><strong>기본 SEO 기반</strong> — 메타, 사이트맵, 내부 링크, 필요한 구조화 데이터 범위를 적용합니다.</li>
                    <li><strong>문의 폼과 측정 이벤트</strong> — 주요 전환이 동작하고 기록되는지 확인합니다.</li>
                    <li><strong>운영 가이드</strong> — 관리자 사용법과 업데이트·백업 등 운영 항목을 정리합니다.</li>
                    <li><strong>유지보수 범위표</strong> — 오픈 이후 직접 관리와 지원 항목을 나눕니다.</li>
                </ul>
            </div>
        </section>

        <section id="wordpress-seo" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">SEO Ready</span>
                <h2 class="landing__head">색인을 보장하는 게 아니라, 검색을 방해하지 않는 구조</h2>
                <p class="landing__body">워드프레스라는 도구 자체가 상위 노출을 만들지는 않습니다. 검색엔진이 페이지를 발견하고 이해할 수 있는 기술 조건을 제작 단계부터 갖춥니다.</p>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>오픈 전에 확인합니다</h3>
                        <ul>
                            <li>의미가 명확하고 중복되지 않는 URL</li>
                            <li>페이지별 제목·설명과 본문 계층</li>
                            <li>사이트맵, robots, canonical</li>
                            <li>내부 링크와 오류 페이지</li>
                            <li>이미지 대체 텍스트와 기본 성능</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>오픈 뒤 계속 운영합니다</h3>
                        <ul>
                            <li>실제 운영 도메인의 수집·색인 상태</li>
                            <li>검색 유입이 생기는 페이지와 질문</li>
                            <li>변경·삭제 URL의 리다이렉트</li>
                            <li>콘텐츠 보강과 내부 링크</li>
                            <li>성능·보안 업데이트의 영향</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">색인 시점과 순위는 검색엔진이 결정합니다. 사이트 구축은 검색 가능한 기반을 만드는 일이며, 실제 성과에는 콘텐츠와 지속적인 운영이 필요합니다.</p>
            </div>
        </section>

        <section id="wordpress-measurement" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Measurement</span>
                <h2 class="landing__head">오픈 여부가 아니라, 사용자가 움직였는지 봅니다</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>유입</strong><span>어떤 채널과 페이지로 방문했는지 확인할 수 있는 기본 분석 구조.</span></div>
                    <div class="landing__point"><strong>탐색</strong><span>주요 페이지와 콘텐츠가 실제로 읽히고 다음 화면으로 이어지는지 확인.</span></div>
                    <div class="landing__point"><strong>전환</strong><span>문의 제출, 전화·메일 클릭 등 합의한 중요 행동을 이벤트로 구분.</span></div>
                    <div class="landing__point"><strong>품질</strong><span>오류, 느린 화면, 모바일 사용성과 폼 이탈처럼 전환을 막는 문제를 점검.</span></div>
                </div>
                <p class="landing__note">구체적인 분석 도구와 이벤트 범위는 프로젝트에서 사용하는 계정과 동의·개인정보 처리 환경에 맞춰 확정합니다.</p>
            </div>
        </section>

        <section id="wordpress-operations" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Ownership &amp; Operations</span>
                <h2 class="landing__head">사이트의 진짜 소유권은 운영할 수 있을 때 생깁니다</h2>
                <p class="landing__body">파일만 전달받아도 도메인, 서버, 관리자, 유료 라이선스와 백업 책임이 불명확하면 사이트를 통제하기 어렵습니다.</p>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>인수인계 체크리스트</h3>
                        <ul>
                            <li>도메인과 호스팅 계정의 명의·접근 권한</li>
                            <li>워드프레스 관리자와 운영자 권한</li>
                            <li>테마·플러그인·외부 서비스 라이선스</li>
                            <li>소스·데이터베이스·업로드 파일 백업</li>
                            <li>분석·검색·메일 발송 계정</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>운영 범위 체크리스트</h3>
                        <ul>
                            <li>보안·코어·플러그인 업데이트</li>
                            <li>장애와 폼 전송 상태 확인</li>
                            <li>콘텐츠 등록과 페이지 추가</li>
                            <li>정기 백업과 복구 기준</li>
                            <li>SEO·분석 이벤트 변경 관리</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="wordpress-fit" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Fit Check</span>
                <h2 class="landing__head">이런 프로젝트에 잘 맞습니다</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>워드프레스가 좋은 선택인 경우</h3>
                        <ul>
                            <li>회사·서비스·콘텐츠 페이지를 계속 운영한다.</li>
                            <li>검색과 광고 랜딩을 한 사이트 안에서 연결한다.</li>
                            <li>내부 담당자가 글과 기본 정보를 직접 수정해야 한다.</li>
                            <li>기능보다 콘텐츠와 마케팅 확장성이 중요하다.</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>별도 검토가 필요한 경우</h3>
                        <ul>
                            <li>복잡한 실시간 서비스나 앱 기능이 핵심이다.</li>
                            <li>운영 주체 없이 제작 후 장기간 방치할 예정이다.</li>
                            <li>콘텐츠와 자료가 전혀 없는데 디자인부터 확정하려 한다.</li>
                            <li>검색 상위 노출이나 매출 보장을 제작 조건으로 요구한다.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="wordpress-faq" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">제작 전에 확인할 질문</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item">
                            <summary>{{ $faq['question'] }}</summary>
                            <p>{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>홈페이지가 아니라, 운영 가능한 영업 자산을</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">필요한 페이지, 중요한 사용자 행동, 내부 운영 방식과 현재 사이트 유무를 알려주세요. 적절한 제작 범위부터 정리하겠습니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">제작 범위 상담</a>
                </div>
            </div>
        </section>
    </main>
@endsection
