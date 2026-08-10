@extends('layouts.app')

@php
    $faqs = [
        [
            'question' => '원하는 액션이면 모두 CPA로 진행할 수 있나요?',
            'answer' => '액션을 기술적으로 측정할 수 있는지, 합리적인 단가와 가용 매체가 있는지, 업종과 광고 표현이 법령·플랫폼 정책에 맞는지를 먼저 확인해야 합니다.',
        ],
        [
            'question' => '목표 물량을 보장하나요?',
            'answer' => '고정 물량을 일괄적으로 보장하지 않습니다. 액션 난이도, 단가, 일정, 매체 가용성과 초기 운영 데이터를 확인한 뒤 가능한 범위를 협의합니다.',
        ],
        [
            'question' => '유효하지 않은 DB나 전환은 어떻게 처리하나요?',
            'answer' => '중복, 필수 항목 오류, 연락 가능 여부, 동의 범위 등 캠페인 전에 합의한 승인·반려 기준으로 판단합니다. 업종과 액션에 따라 기준은 달라질 수 있습니다.',
        ],
        [
            'question' => '기존 CRM이나 어드민으로 데이터를 받을 수 있나요?',
            'answer' => '현재 시스템과 필요한 전달 항목을 확인한 뒤 가능한 연동 방식을 정합니다. 별도 개발이나 API 작업이 필요하면 운영 범위와 분리해 사전에 협의합니다.',
        ],
        [
            'question' => '개인정보 동의와 광고 심사도 검토하나요?',
            'answer' => '캠페인 운영에 필요한 동의 항목과 표시 문구, 매체 심사 조건을 확인합니다. 다만 최종적인 법률 적합성과 광고주 자격은 관련 법령·전문가·플랫폼의 최신 기준을 함께 확인해야 합니다.',
        ],
    ];
@endphp

@section('title', 'CPA 마케팅 — 유효 액션 기준 성과형 광고 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="설치·가입·구매·상담신청 등 사전에 합의한 유효 액션을 기준으로 운영하는 CPA 마케팅. 액션 정의, 트래킹, 유효 기준, 매체 운영과 정산 구조를 설계합니다.">
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
                <span class="landing__eyebrow">CPA Marketing</span>
                <h1>사전 합의한 유효 액션을 기준으로 정산합니다</h1>
                <p class="landing__lead">설치·가입·구매·상담신청처럼 측정 가능한 행동을 정의하고, 승인 기준을 통과한 액션을 중심으로 운영하는 성과형 광고입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">CPA 가능 여부 상담</a>
                </div>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'cpa'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="CPA 마케팅 페이지 내 탐색">
            <div class="landing__local-nav-inner">
                <a href="#cpa-structure">과금 구조</a>
                <a href="#cpa-conditions">성립 조건</a>
                <a href="#cpa-process">진행 과정</a>
                <a href="#cpa-quality">유효 기준</a>
                <a href="#cpa-deliverables">제공 항목</a>
                <a href="#cpa-industries">업종별 CPA</a>
                <a href="#cpa-insurance">보험 CRM</a>
                <a href="#cpa-compliance">적합성</a>
                <a href="#cpa-faq">FAQ</a>
            </div>
        </nav>

        <section id="cpa-structure" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Cost Structure</span>
                <h2 class="landing__head">어디에 비용을 내는 구조인지부터 맞춥니다</h2>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr>
                                <th scope="col">구분</th>
                                <th scope="col">노출·클릭형 광고</th>
                                <th scope="col" class="is-cpa">CPA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">주요 과금 기준</th><td>노출 또는 클릭</td><td class="is-cpa">합의한 승인 액션</td></tr>
                            <tr><th scope="row">먼저 정할 것</th><td>예산·타깃·소재</td><td class="is-cpa">액션·측정·유효 기준</td></tr>
                            <tr><th scope="row">운영의 핵심</th><td>매체 효율 최적화</td><td class="is-cpa">물량과 전환 품질의 균형</td></tr>
                            <tr><th scope="row">확인할 조건</th><td>입찰·도달·전환율</td><td class="is-cpa">단가·매체 가용성·승인 조건</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="landing__callout">CPA는 “성과가 자동으로 생기는 상품”이 아니라, 무엇을 성과로 인정할지 먼저 계약하는 운영 방식입니다.</div>
                <p class="landing__note">제작·개발·트래킹 등 별도 작업의 비용 여부는 캠페인 범위에 따라 사전에 구분합니다.</p>
            </div>
        </section>

        <section id="cpa-conditions" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Conditions</span>
                <h2 class="landing__head">CPA가 작동하려면 네 가지 조건이 필요합니다</h2>
                <p class="landing__lead">조건을 생략한 채 단가와 물량만 먼저 정하면 정상 전환 누락, 낮은 품질, 정산 분쟁이 뒤따릅니다.</p>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>명확한 액션</strong>
                        <span>설치인지, 가입인지, 결제인지, 상담신청인지 한 문장으로 판별할 수 있어야 합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>검증 가능한 트래킹</strong>
                        <span>픽셀·포스트백·서버 이벤트·DB 전달 등 실제 환경에 맞는 확인 경로가 필요합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>현실적인 단가와 일정</strong>
                        <span>액션 난이도와 업종, 매체 조건에 맞지 않는 단가로는 안정적인 운영이 어렵습니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>사전 합의한 유효 기준</strong>
                        <span>중복, 오류, 취소, 연락 가능 여부 등 승인과 반려의 경계를 시작 전에 정합니다.</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="cpa-process" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Process</span>
                <h2 class="landing__head">한 줄짜리 요청을 집행 가능한 명세로 바꿉니다</h2>
                <div class="steps">
                    <div class="steps__item">
                        <strong>광고주와 업종 적합성을 확인합니다</strong>
                        <p>서비스 내용, 광고주 자격, 매체 정책, 개인정보 처리 구조를 먼저 봅니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>성과 액션과 승인 조건을 정의합니다</strong>
                        <p>어떤 이벤트가 언제 발생해야 한 건으로 인정되는지, 중복과 예외는 어떻게 판단할지 정합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>단가·물량·기간의 균형을 맞춥니다</strong>
                        <p>희망 수량만 받지 않고 액션 난이도와 가용 인벤토리를 함께 검토합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>랜딩·동의·입력 항목을 점검합니다</strong>
                        <p>사용자가 무엇에 신청하는지 이해하고 필요한 정보만 입력하도록 구성합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>트래킹과 전달 흐름을 확인합니다</strong>
                        <p>이벤트 수신, DB 전달, 중복 처리, 광고주 시스템 연결을 실제 운영 흐름에 맞춰 확인합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>초기 운영에서 품질을 검수합니다</strong>
                        <p>승인률과 반려 사유를 보고 액션 조건, 매체 구성, 문구를 조정합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>승인 수량을 기준으로 정산합니다</strong>
                        <p>합의한 기간과 기준 안에서 유효 전환과 제외 사유를 맞춥니다.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="cpa-quality" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Quality</span>
                <h2 class="landing__head">DB는 건수보다 상태가 중요합니다</h2>
                <p class="landing__body">상담신청 한 건이 실제 영업 기회가 되려면 입력·동의·전달·후속 상담의 상태를 함께 봐야 합니다.</p>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>시작 전에 정할 유효 기준</h3>
                        <ul>
                            <li>동일 연락처·사용자의 중복 범위</li>
                            <li>필수 입력 항목의 오류 기준</li>
                            <li>연락 가능 여부와 확인 기간</li>
                            <li>개인정보 수집·이용·제공 동의 범위</li>
                            <li>취소·철회·테스트 데이터 처리</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>운영 중 확인할 품질 신호</h3>
                        <ul>
                            <li>매체·랜딩별 승인률</li>
                            <li>중복과 반려 사유 분포</li>
                            <li>전달 누락과 처리 지연</li>
                            <li>광고주가 공유 가능한 상담 상태</li>
                            <li>문구와 타깃 변경 전후의 차이</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">유효 기준은 업종과 계약에 따라 달라집니다. 공개 페이지의 한 가지 기준을 모든 캠페인에 일괄 적용하지 않습니다.</p>
            </div>
        </section>

        <section id="cpa-deliverables" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Deliverables</span>
                <h2 class="landing__head">운영 전에 합의하고, 운영 후에 근거를 남깁니다</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>캠페인 정의서</strong>
                        <span>목표, 액션, 기간, 단가, 예상 운영 범위를 정리합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>승인·반려 기준</strong>
                        <span>유효, 중복, 오류, 취소 등 판단 조건을 문서로 맞춥니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>랜딩·입력 폼 검토안</strong>
                        <span>제안과 신청 내용, 동의 문구, 필수 입력 항목을 점검합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>측정·전달 항목 명세</strong>
                        <span>이벤트와 DB가 어떤 경로로 전달되고 확인되는지 정리합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>운영·품질 리포트</strong>
                        <span>수량뿐 아니라 승인률과 주요 반려 사유, 조정 내용을 공유합니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>정산 기준표</strong>
                        <span>합의한 기간과 승인 수량을 기준으로 정산 근거를 맞춥니다.</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="cpa-industries" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Industry</span>
                <h2 class="landing__head">업종마다 액션과 규제가 다릅니다</h2>
                <p class="landing__body">같은 상담신청이라도 부동산, 보험, 투자정보, 퍼미션콜의 유효 기준과 심사 조건은 같지 않습니다. 업종별 페이지에서 범위와 주의사항을 확인할 수 있습니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'real-estate']) }}"><strong>부동산 분양 CPA</strong><p>지역·상품·상담 의향을 반영한 관심고객 수집 구조.</p><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'stock']) }}"><strong>주식 DB 마케팅</strong><p>광고주 자격과 광고 표현을 먼저 확인하는 투자 관심고객 캠페인.</p><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'insurance']) }}"><strong>보험 DB</strong><p>유입 이후 상담 배분과 관리까지 연결하는 보험 DB 캠페인.</p><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'coin']) }}"><strong>코인 DB</strong><p>플랫폼 심사와 사업자·표시 문구 적합성을 우선 검토.</p><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'permission-call']) }}"><strong>퍼미션콜 DB</strong><p>연락 여부보다 수집 목적과 동의 범위를 명확히 하는 구조.</p><span>자세히 →</span></a>
                </div>
                <p class="landing__note">금융·투자·보험·부동산 관련 캠페인은 광고주 자격, 표시 문구, 개인정보 동의와 최신 법령·플랫폼 정책을 확인한 뒤 집행 범위를 결정합니다. 수익·계약·전환을 보장하지 않습니다.</p>
            </div>
        </section>

        <section id="cpa-insurance" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Insurance CRM</span>
                <h2 class="landing__head">보험이라면, 유입 이후의 운영까지 봅니다</h2>
                <p class="landing__body">제이커브는 보험 DB를 사용하는 영업조직과 생산·납품하는 콜센터를 위한 CRM을 각각 운영합니다. CPA로 들어온 DB가 상담·계약·AS·정산 단계에서 어떻게 사용되는지까지 연결해 볼 수 있는 이유입니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.leadbay') }}">
                        <strong>리드베이 (LEADBAY)</strong>
                        <p>보험 DB를 사용하는 영업조직의 구매·배분·상담·계약 관리.</p>
                        <span>리드베이 소개 →</span>
                    </a>
                    <a class="subcard" href="{{ route('solutions.call2sale') }}">
                        <strong>콜투세일 (Call2.Sale)</strong>
                        <p>보험 DB를 생산·납품하는 콜센터의 상담·납품·AS·정산 관리.</p>
                        <span>콜투세일 소개 →</span>
                    </a>
                </div>
            </div>
        </section>

        <section id="cpa-compliance" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Fit &amp; Compliance</span>
                <h2 class="landing__head">물량보다 먼저, 진행 가능한 캠페인인지 판단합니다</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>CPA에 적합한 상황</h3>
                        <ul>
                            <li>측정 가능한 명확한 액션이 있다.</li>
                            <li>승인·반려 기준을 사전에 합의할 수 있다.</li>
                            <li>단가와 물량을 초기 데이터에 따라 조정할 수 있다.</li>
                            <li>광고주와 매체가 필요한 자격·자료를 제공할 수 있다.</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>먼저 재설계할 상황</h3>
                        <ul>
                            <li>측정할 이벤트 없이 결과만 보장받으려 한다.</li>
                            <li>광고 표현이나 개인정보 동의의 근거가 불명확하다.</li>
                            <li>시장 조건과 무관하게 고정 물량·단가를 요구한다.</li>
                            <li>운영 후 반려 기준을 바꾸려 한다.</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">제이커브의 운영 검토가 법률 자문이나 플랫폼 승인 자체를 대신하지는 않습니다. 필요한 경우 관련 전문가와 최신 공식 기준을 함께 확인해야 합니다.</p>
            </div>
        </section>

        <section id="cpa-faq" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">계약 전에 확인할 질문</h2>
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
                <h2>액션·단가·유효 기준부터 맞춰보세요</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">서비스와 원하는 액션, 목표 일정, 현재 측정 환경을 알려주시면 진행 가능성을 먼저 검토합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">CPA 구조 상담</a>
                </div>
            </div>
        </section>
    </main>
@endsection
