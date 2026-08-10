@extends('layouts.app')

@php
    $faqs = [
        [
            'question' => '광고 예산이 작아도 시작할 수 있나요?',
            'answer' => '예산의 크기보다 목표 전환 데이터가 얼마나 쌓일 수 있는지가 중요합니다. 예산이 작다면 채널과 테스트 변수를 줄여 한 번에 확인할 가설을 선명하게 잡습니다.',
        ],
        [
            'question' => '기존 광고 계정을 그대로 사용할 수 있나요?',
            'answer' => '먼저 기존 계정의 구조와 데이터 연속성을 확인합니다. 새 계정을 만드는 것이 항상 정답은 아니며, 유지할 자산과 정리할 문제를 구분한 뒤 인수인계 범위를 정합니다.',
        ],
        [
            'question' => '광고 소재도 함께 제작하나요?',
            'answer' => '촬영·편집·디자인을 사내에서 연결할 수 있습니다. 필요한 소재의 형식과 수량, 촬영 여부는 캠페인 목표와 계약 범위에 맞춰 확정합니다.',
        ],
        [
            'question' => '매출이나 ROAS를 보장하나요?',
            'answer' => '특정 매출이나 ROAS는 보장하지 않습니다. 대신 목표 전환, 테스트 기준, 중단·유지·확대 조건을 먼저 합의하고 같은 기준으로 결과를 판단합니다.',
        ],
        [
            'question' => '리포트에서는 무엇을 확인할 수 있나요?',
            'answer' => '노출과 클릭뿐 아니라 합의한 비즈니스 전환, 비용, 매체·캠페인·소재별 차이와 다음 실행 항목을 중심으로 정리합니다. 구체적인 항목과 주기는 운영 범위에 따라 확정합니다.',
        ],
    ];
@endphp

@section('title', '퍼포먼스 마케팅 대행 — 광고비의 성적표 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="2026년 기준 제이커브 회사 전체 누적 광고비 373억 원, 캠페인 15,700건 이상. 매체 숫자가 아니라 매출·유효 리드·가입 등 합의한 비즈니스 KPI를 기준으로 광고를 운영합니다.">
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
        <section class="landing__hero landing__hero--media">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                <span class="landing__eyebrow">Performance Marketing</span>
                <h1>광고비의 성적표를 만들어 드립니다</h1>
                <p class="landing__lead">2026년 기준 제이커브 회사 전체 누적으로 373억 원의 광고비와 15,700건 이상의 캠페인을 운영했습니다. 그 과정에서 확인한 것은 단순합니다. 매체 숫자가 아니라 사업에 남는 결과를 기준으로 봐야 한다는 것.</p>
                <div class="detail__metrics" aria-label="2026년 기준 제이커브 회사 전체 누적 지표">
                    <div class="detail__metric"><strong>373억+</strong><span>누적 집행 광고비 · 2026년 회사 전체</span></div>
                    <div class="detail__metric"><strong>15,700+</strong><span>진행 캠페인 · 2026년 회사 전체</span></div>
                    <div class="detail__metric"><strong>주 단위</strong><span>운영 판단과 예산 점검</span></div>
                </div>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">현재 광고 구조 진단 요청</a>
                </div>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'performance'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="퍼포먼스 마케팅 페이지 내 탐색">
            <div class="landing__local-nav-inner">
                <a href="#performance-problem">문제 진단</a>
                <a href="#performance-scorecard">성과 기준</a>
                <a href="#performance-process">운영 과정</a>
                <a href="#performance-channels">채널 전략</a>
                <a href="#performance-deliverables">제공 항목</a>
                <a href="#performance-operations">운영 원칙</a>
                <a href="#performance-fit">적합성</a>
                <a href="#performance-faq">FAQ</a>
            </div>
        </nav>

        <section id="performance-problem" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">The Problem</span>
                <h2 class="landing__head">리포트는 쌓이는데, 다음 결정은 여전히 감입니다</h2>
                <div class="prose">
                    <p>노출과 클릭이 늘었다는 보고서는 받았지만 매출, 유효 상담, 가입과 어떻게 연결됐는지는 알기 어렵습니다. 매체마다 전환 숫자가 다르고 어떤 소재가 고객을 움직였는지도 흐릿합니다.</p>
                    <p>이 상태에서 예산만 늘리면 성과보다 불확실성이 먼저 커집니다. 광고 계정, 전환 측정, 랜딩페이지, 크리에이티브가 서로 다른 목표를 보고 있기 때문입니다.</p>
                    <p>제이커브는 광고를 더 돌리기 전에 무엇을 성과로 볼지부터 맞춥니다. 매체 지표는 그다음입니다.</p>
                </div>
            </div>
        </section>

        <section id="performance-scorecard" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Scorecard</span>
                <h2 class="landing__head">사업마다 성적표가 달라야 합니다</h2>
                <p class="landing__body">ROAS가 중요한 사업도 있고, 유효 DB나 활성 사용자가 더 중요한 사업도 있습니다. 먼저 사업의 성과를 정의하고 광고 지표를 그 아래에 놓습니다.</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light">
                        <strong>커머스</strong>
                        <span>매출, 구매당 비용, 신규 고객, 객단가처럼 실제 거래와 연결되는 지표를 봅니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>리드 비즈니스</strong>
                        <span>신청 건수에서 멈추지 않고 유효 리드, 상담 연결, 계약 단계까지 확인할 수 있는 기준을 정합니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>앱·온라인 서비스</strong>
                        <span>설치나 가입 이후 활성화, 핵심 기능 사용 등 서비스 가치와 가까운 행동을 구분합니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>콘텐츠·브랜드</strong>
                        <span>도달만 세지 않고 후속 검색, 사이트 방문, 문의처럼 다음 행동으로 이어지는 신호를 함께 봅니다.</span>
                    </div>
                </div>
                <div class="landing__callout">노출과 클릭은 과정입니다. 성과의 이름은 광고주 사업 안에서 정해져야 합니다.</div>
            </div>
        </section>

        <section id="performance-process" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Process</span>
                <h2 class="landing__head">진단부터 리밸런싱까지, 판단이 끊기지 않게</h2>
                <p class="landing__lead">한 번의 세팅보다 중요한 것은 같은 기준으로 보고, 바꾸고, 다시 확인하는 운영 루프입니다.</p>
                <div class="steps">
                    <div class="steps__item">
                        <strong>목표와 전환을 정의합니다</strong>
                        <p>매출인지, 유효 상담인지, 가입인지. 캠페인이 최적화해야 할 최종 행동과 보조 지표를 구분합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>계정·트래킹·랜딩을 진단합니다</strong>
                        <p>캠페인 구조와 이벤트 누락, 중복 귀속, 페이지 속도와 전환 동선을 함께 확인합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>매체별 역할과 예산을 설계합니다</strong>
                        <p>모든 매체를 같은 기준으로 경쟁시키지 않습니다. 발견, 재방문, 전환 등 각 채널이 맡을 역할을 정합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>소재 가설에 우선순위를 매깁니다</strong>
                        <p>이미지 하나만 바꾸는 테스트가 아니라 고객, 문제, 제안, 증거 중 어떤 요소가 반응을 만들었는지 확인합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>주 단위로 운영 판단을 내립니다</strong>
                        <p>성과가 낮은 조합을 정리하고 확인된 조합에 예산을 옮깁니다. 변경 이유와 결과를 기록합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>유지·중단·확대를 결정합니다</strong>
                        <p>좋은 숫자만 설명하지 않습니다. 데이터가 부족한지, 구조가 틀렸는지, 더 투자할 근거가 있는지 구분합니다.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="performance-channels" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Channel Strategy</span>
                <h2 class="landing__head">매체를 따로 돌려도, 판단은 한 판 위에서</h2>
                <p class="landing__body">채널마다 강점과 전환 집계 방식이 다릅니다. 제이커브는 각 매체의 보고서를 단순 합산하지 않고 같은 비즈니스 목표 아래에서 역할과 중복을 확인합니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.performance.sub', ['sub' => 'naver-gfa']) }}">
                        <strong>네이버 GFA</strong>
                        <p>네이버 지면 안의 발견을 전환으로 연결하는 소재·타깃·랜딩 구조.</p>
                        <span>GFA 광고 자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.performance.sub', ['sub' => 'facebook']) }}">
                        <strong>페이스북·인스타그램</strong>
                        <p>전환 신호와 크리에이티브 학습이 이어지는 메타 캠페인 운영.</p>
                        <span>메타 광고 자세히 →</span>
                    </a>
                    <a class="subcard" href="{{ route('services.performance.sub', ['sub' => 'youtube']) }}">
                        <strong>유튜브</strong>
                        <p>조회에서 끝나지 않고 시청 이후 검색·방문·행동까지 설계하는 영상 마케팅.</p>
                        <span>유튜브 마케팅 자세히 →</span>
                    </a>
                </div>
            </div>
        </section>

        <section id="performance-deliverables" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Deliverables</span>
                <h2 class="landing__head">무엇을 바꿨는지 남아야 합니다</h2>
                <p class="landing__body">구체적인 산출물은 계약 범위에 따라 확정하지만, 운영의 출발점과 판단 근거는 문서로 공유합니다.</p>
                <ul class="landing__evidence">
                    <li><strong>현 계정 진단 요약</strong> — 유지할 자산과 우선 수정할 문제를 구분합니다.</li>
                    <li><strong>KPI·전환 이벤트 정의</strong> — 최종 전환과 보조 지표, 집계 기준을 맞춥니다.</li>
                    <li><strong>매체·캠페인 구조안</strong> — 채널별 역할과 예산 운용 기준을 정리합니다.</li>
                    <li><strong>소재 테스트 계획</strong> — 검증할 가설과 비교할 변수를 명확히 합니다.</li>
                    <li><strong>랜딩 개선 우선순위</strong> — 광고 이후 이탈을 만드는 페이지 문제를 함께 봅니다.</li>
                    <li><strong>운영 리포트와 변경 기록</strong> — 결과, 해석, 다음 실행을 한 흐름으로 남깁니다.</li>
                </ul>
            </div>
        </section>

        <section id="performance-operations" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Operations</span>
                <h2 class="landing__head">숫자만 보내지 않고, 다음 판단까지 씁니다</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>성과가 좋을 때</h3>
                        <p>왜 좋아졌는지 설명할 수 있어야 확대할 수 있습니다. 특정 매체, 소재, 오디언스, 랜딩 변화 중 실제 기여 요인을 분리해 봅니다.</p>
                        <ul>
                            <li>재현 가능한 조합인지 확인</li>
                            <li>예산 증가 시 단가 변화 관찰</li>
                            <li>후속 소재와 랜딩으로 학습 확장</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>성과가 꺾일 때</h3>
                        <p>대행사를 바꾸거나 소재를 전부 버리기 전에 원인을 매체·측정·소재·랜딩·시장 조건으로 나눕니다.</p>
                        <ul>
                            <li>이벤트 누락과 중복 여부 확인</li>
                            <li>노출 피로와 고객 반응 변화 확인</li>
                            <li>중단할 것과 더 검증할 것을 구분</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="performance-fit" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Fit Check</span>
                <h2 class="landing__head">이런 팀과 잘 맞습니다</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>함께 풀기 좋은 상황</h3>
                        <ul>
                            <li>광고는 집행 중이지만 사업 성과와 연결되지 않는다.</li>
                            <li>매체별 숫자가 달라 어느 데이터를 믿어야 할지 모르겠다.</li>
                            <li>소재 제작과 운영이 분리돼 테스트가 느리다.</li>
                            <li>예산을 늘리기 전에 현재 구조를 점검하고 싶다.</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>먼저 조건을 바꿔야 하는 상황</h3>
                        <ul>
                            <li>전환 측정 없이 매출 보장만 원한다.</li>
                            <li>테스트할 시간과 데이터 없이 즉시 결론을 요구한다.</li>
                            <li>상품·가격·재고 문제를 광고 설정만으로 해결하려 한다.</li>
                            <li>계정과 데이터를 공개하지 않은 채 진단을 원한다.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="performance-faq" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">시작 전에 가장 많이 묻는 질문</h2>
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
                <h2>광고를 더 쓰기 전에, 어디서 새는지부터</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">현재 매체, 월 예산, 목표 전환, 가장 답답한 지점을 알려주세요. 확인할 순서부터 정리하겠습니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">성과 진단 요청</a>
                </div>
            </div>
        </section>
    </main>
@endsection
