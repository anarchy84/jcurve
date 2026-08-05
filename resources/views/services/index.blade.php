@extends('layouts.app')

@php
    $faqs = [
        ['question' => '어떤 서비스부터 시작해야 하나요?', 'answer' => '빠른 매출 검증, 유효 액션 확보, 앱 활성화, 검색 자산, 자체 웹 채널 중 지금 가장 급한 목표를 고릅니다. 목표가 불명확하면 현재 데이터에서 가장 큰 이탈 구간부터 진단합니다.'],
        ['question' => '여러 서비스를 함께 운영할 수 있나요?', 'answer' => '가능합니다. 다만 채널을 많이 여는 것보다 전환 정의와 측정 기준을 먼저 통일해야 합니다. 기반이 맞으면 유료 광고의 학습을 SEO·웹사이트·리워드 캠페인으로 연결할 수 있습니다.'],
        ['question' => '기존 대행사나 내부 팀이 있어도 괜찮나요?', 'answer' => '괜찮습니다. 전체를 교체하는 방식뿐 아니라 진단, 특정 채널 운영, 측정 구조 정비, 제작과 SEO처럼 비어 있는 구간만 맡는 방식도 설계할 수 있습니다.'],
        ['question' => '성과를 미리 보장하나요?', 'answer' => '시장 반응을 미리 확정할 수는 없습니다. 대신 시작 전에 성공 기준과 중단 기준을 합의하고, 측정 가능한 결과로 다음 결정을 내리도록 운영합니다.'],
        ['question' => '상담 전에 무엇을 준비하면 빠른가요?', 'answer' => '현재 운영 채널, 월 예산 범위, 가장 중요한 전환, 최근 성과 자료가 있으면 좋습니다. 자료가 없더라도 사업 목표와 현재 가장 답답한 지점부터 정리할 수 있습니다.'],
    ];
@endphp

@section('title', '디지털 마케팅 서비스 — 유입부터 전환·재구매까지 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="퍼포먼스 광고, CPA, 리워드 네트워크, SEO·AEO·GEO, 워드프레스까지. 유입·전환·측정·개선을 하나의 성장 체계로 연결합니다.">
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
                <span class="landing__eyebrow">Growth Services</span>
                <h1>채널은 다섯 개여도,<br>성과 기준은 하나여야 합니다</h1>
                <p class="landing__lead">광고·리드·리워드·검색·웹사이트를 따로 떼어 운영하면 데이터와 책임도 흩어집니다. 제이커브는 발견부터 전환 이후까지 하나의 성장 체계로 연결합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">현재 마케팅 진단받기</a>
                    <a class="btn-ghost" href="#service-map">서비스 한눈에 보기</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="서비스 페이지 바로가기">
            <div class="landing__local-nav-inner">
                <a href="#service-map">서비스 맵</a>
                <a href="#operating-system">운영 방식</a>
                <a href="#selection-guide">선택 가이드</a>
                <a href="#process">진행 절차</a>
                <a href="#faq">FAQ</a>
            </div>
        </nav>

        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">The Real Problem</span>
                <h2 class="landing__head">성과가 막히는 지점은 광고계정 밖에 있을 때가 많습니다</h2>
                <div class="prose">
                    <p>클릭은 충분한데 랜딩에서 이탈할 수 있고, 상담 신청은 쌓이는데 영업 배분이 늦을 수 있습니다. 검색 노출은 늘었지만 무엇이 매출로 이어졌는지 모를 수도 있죠.</p>
                    <p>그래서 매체 운영만 떼어 최적화하면 숫자는 좋아져도 사업은 그대로일 수 있습니다. 유입 경로, 페이지, 전환 이벤트, 후속 상담과 재방문을 한 흐름으로 봐야 진짜 병목이 보입니다.</p>
                </div>
                <div class="landing__callout">제이커브의 시작점은 “어느 광고를 할까요?”가 아니라 “어느 단계에서 고객을 잃고 있나요?”입니다.</div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="service-map">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Service Map</span>
                <h2 class="landing__head">목표에 따라 골라도, 함께 연결해도 됩니다</h2>
                <p class="landing__lead">각 서비스는 단독으로 시작할 수 있고, 데이터가 쌓이면 다음 단계로 확장할 수 있습니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'performance-marketing']) }}">
                        <strong>퍼포먼스 마케팅</strong>
                        <p>메타·구글·네이버·유튜브의 예산과 소재를 전환 기준으로 운영합니다.</p>
                        <span>광고 성과 구조 보기 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'cpa-marketing']) }}">
                        <strong>CPA 마케팅</strong>
                        <p>설치·가입·구매·상담 등 사전에 합의한 유효 액션을 기준으로 집행합니다.</p>
                        <span>성과형 과금 구조 보기 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'reward-network']) }}">
                        <strong>리워드 네트워크</strong>
                        <p>광고주에게는 행동을, 앱 매체에는 수익과 유저 경험을 연결합니다.</p>
                        <span>광고주·매체 제휴 보기 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'seo']) }}">
                        <strong>SEO · AEO · GEO</strong>
                        <p>검색 결과부터 답변엔진과 생성형 AI의 인용 가능성까지 디지털 자산을 만듭니다.</p>
                        <span>검색 자산 구축 보기 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'wordpress']) }}">
                        <strong>워드프레스 제작·운영</strong>
                        <p>검색엔진이 읽고 고객이 행동할 수 있는 마케팅 기반의 웹사이트를 구축합니다.</p>
                        <span>제작 범위 보기 →</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb" id="operating-system">
            <div class="landing__inner">
                <span class="landing__eyebrow">Operating System</span>
                <h2 class="landing__head">채널보다 먼저 맞추는 네 가지</h2>
                <p class="landing__lead">이 기준이 맞아야 서비스가 늘어나도 데이터가 한 방향으로 쌓입니다.</p>
                <div class="landing__points">
                    <div class="landing__point"><strong>하나의 전환 정의</strong><span>매출·가입·설치·상담 중 무엇을 성과로 볼지, 유효 조건과 중복 처리까지 먼저 합의합니다.</span></div>
                    <div class="landing__point"><strong>끊기지 않는 측정</strong><span>광고 클릭부터 페이지 행동과 후속 결과까지 연결해 어느 구간이 문제인지 확인합니다.</span></div>
                    <div class="landing__point"><strong>빠른 실험 주기</strong><span>가설을 작게 검증하고, 이기는 메시지·타깃·지면에 다음 예산과 제작 역량을 옮깁니다.</span></div>
                    <div class="landing__point"><strong>읽히는 보고</strong><span>노출과 클릭을 나열하지 않습니다. 결정해야 할 것, 바꾼 것, 다음 실험을 중심으로 공유합니다.</span></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="selection-guide">
            <div class="landing__inner">
                <span class="landing__eyebrow">Selection Guide</span>
                <h2 class="landing__head">지금 목표로 출발점을 고르세요</h2>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr><th scope="col">현재 목표</th><th scope="col">먼저 볼 서비스</th><th scope="col">핵심 판단 기준</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">광고비 대비 매출 개선</th><td class="is-cpa">퍼포먼스 마케팅</td><td>전환 측정, 채널별 한계효율, 소재 회전</td></tr>
                            <tr><th scope="row">유효 액션 단위 집행</th><td class="is-cpa">CPA 마케팅</td><td>액션 정의, 승인 기준, 트래킹과 정산</td></tr>
                            <tr><th scope="row">앱 활성화 또는 지면 수익화</th><td class="is-cpa">리워드 네트워크</td><td>미션 설계, 유저 품질, 매체 경험</td></tr>
                            <tr><th scope="row">광고 외 검색 유입 자산</th><td class="is-cpa">SEO · AEO · GEO</td><td>색인, 검색의도, 신뢰 근거와 인용성</td></tr>
                            <tr><th scope="row">자체 전환 채널 구축</th><td class="is-cpa">워드프레스</td><td>정보구조, 속도, 콘텐츠 운영과 측정</td></tr>
                        </tbody>
                    </table>
                </div>
                <p class="landing__note">서비스명이 아니라 병목을 기준으로 고르면 됩니다. 상담 단계에서 현재 데이터와 실행 여건을 보고 우선순위를 함께 정합니다.</p>
            </div>
        </section>

        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Connected Growth</span>
                <h2 class="landing__head">집행은 끝나도, 학습은 다음 채널에 남습니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>유료 채널에서 빠르게 검증</h3>
                        <p>퍼포먼스·CPA·리워드 캠페인으로 어떤 타깃과 메시지가 실제 행동을 만드는지 빠르게 확인합니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>검색과 웹사이트에 자산화</h3>
                        <p>검증된 질문·메시지·전환 구조를 SEO 콘텐츠와 자체 웹사이트에 반영해 일회성 집행을 축적 가능한 자산으로 바꿉니다.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb" id="process">
            <div class="landing__inner">
                <span class="landing__eyebrow">Process</span>
                <h2 class="landing__head">상담부터 개선까지, 이렇게 진행합니다</h2>
                <div class="steps">
                    <div class="steps__item"><strong>현재 상태 진단</strong><p>사업 목표, 운영 채널, 데이터 환경, 내부 실행 인력을 확인합니다.</p></div>
                    <div class="steps__item"><strong>우선순위와 KPI 합의</strong><p>이번 단계에서 해결할 한 가지 병목과 성공·중단 기준을 숫자로 정합니다.</p></div>
                    <div class="steps__item"><strong>측정 기반 정비</strong><p>필요한 이벤트와 리포트 구조를 맞춰 실행 결과가 다음 판단으로 이어지게 합니다.</p></div>
                    <div class="steps__item"><strong>작은 단위로 실행</strong><p>채널·소재·페이지를 한 번에 전부 바꾸지 않고, 원인을 구분할 수 있게 실험합니다.</p></div>
                    <div class="steps__item"><strong>검증과 재배분</strong><p>좋은 신호는 확대하고 나쁜 신호는 중단합니다. 결과뿐 아니라 이유와 다음 행동을 공유합니다.</p></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">시작 전에 가장 많이 묻는 질문</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item"><summary>{{ $faq['question'] }}</summary><p>{{ $faq['answer'] }}</p></details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>서비스를 고르기 전에, 병목부터 찾으세요</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">현재 상황과 목표를 알려주시면 가장 먼저 손댈 지점부터 구체적으로 정리합니다.</p>
                <div class="cta-row"><a class="btn-primary" href="{{ route('contact') }}">프로젝트 진단 요청</a></div>
            </div>
        </section>
    </main>
@endsection
