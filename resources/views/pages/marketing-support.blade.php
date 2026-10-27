@extends('layouts.app')

@php
    $faqs = [
        [
            'question' => '현재 신청 가능한 지원사업을 바로 추천해 주나요?',
            'answer' => '지원사업의 모집 여부와 자격은 시기와 기관별 공고에 따라 달라집니다. 상담 시 기업 정보와 공고문을 기준으로 마케팅 과업의 적합성을 검토하며, 최신 모집 상태와 신청 자격은 운영기관의 공식 안내를 우선 확인해야 합니다.',
        ],
        [
            'question' => '선정이나 지원금 지급을 보장하나요?',
            'answer' => '보장하지 않습니다. 선정과 지원금 지급은 운영기관의 심사·협약·정산 기준에 따라 결정됩니다. 제이커브는 협의된 범위에서 과업 해석, 실행 계획, 마케팅 운영과 결과 자료 준비를 지원합니다.',
        ],
        [
            'question' => '신청 서류를 모두 대신 작성해 주나요?',
            'answer' => '신청 주체와 사실 확인 책임은 참여 기업에 있습니다. 공고와 과업을 검토해 필요한 마케팅 계획과 자료 정리를 지원할 수 있지만, 대행 가능한 범위는 사업 규정과 계약 단계에서 확정합니다.',
        ],
        [
            'question' => '지원금으로 모든 마케팅 비용을 집행할 수 있나요?',
            'answer' => '아닙니다. 인정되는 비용, 자부담, 집행 기간, 공급기업 요건과 증빙 방식은 사업마다 다릅니다. 계약이나 집행 전에 운영기관의 공고·협약·지침을 확인해야 합니다.',
        ],
        [
            'question' => '광고 외에 홈페이지나 SEO도 가능한가요?',
            'answer' => '공고상 인정 범위와 기업의 과업 목표에 따라 퍼포먼스 광고, SEO, 콘텐츠, 영상, 웹 제작 등을 검토할 수 있습니다. 모든 사업에서 모든 항목이 인정되는 것은 아닙니다.',
        ],
    ];
@endphp

@section('title', '중소기업 마케팅 지원사업 실행 지원 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="중소기업 마케팅 지원사업의 공고·과업·증빙 기준을 확인하고 광고, SEO, 콘텐츠, 영상, 웹 제작 실행과 결과 자료 준비를 지원합니다. 선정과 지원금 지급은 보장하지 않습니다.">
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
                <span class="landing__eyebrow">Marketing Support Program</span>
                <h1>지원금보다 먼저, 과업과 증빙을 읽습니다</h1>
                <p class="landing__lead">지원사업은 공고마다 대상·인정 비용·성과 기준·결과 보고 방식이 다릅니다. 참여 가능 여부와 마케팅 수행 범위를 확인한 뒤 실행 계획을 세웁니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">공고문과 함께 상담 요청</a>
                </div>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="중소기업 마케팅 지원사업 페이지 내 탐색">
            <div class="landing__local-nav-inner">
                <a href="#support-first">먼저 확인할 것</a>
                <a href="#support-problem">흔한 문제</a>
                <a href="#support-scope">지원 범위</a>
                <a href="#support-services">실행 서비스</a>
                <a href="#support-process">진행 과정</a>
                <a href="#support-deliverables">결과 자료</a>
                <a href="#support-roles">역할 구분</a>
                <a href="#support-fit">준비 체크</a>
                <a href="#support-faq">FAQ</a>
            </div>
        </nav>

        <section id="support-first" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Before We Start</span>
                <h2 class="landing__head">“지원사업 마케팅”은 하나의 고정 상품이 아닙니다</h2>
                <div class="prose">
                    <p>중앙정부, 지자체, 기관별 사업은 참여 대상과 과업, 공급기업 요건, 자부담, 집행·정산 방식이 서로 다릅니다. 작년에 가능했던 항목이 올해도 같은 조건이라는 보장은 없습니다.</p>
                    <p>그래서 기업명과 희망 예산만 받고 광고부터 제안하지 않습니다. 공고문, 협약서, 과업지시서가 있다면 먼저 읽고 어떤 비용과 결과물이 인정되는지 확인합니다.</p>
                </div>
                <p class="landing__note">사업별 참여 자격과 지원 범위는 해당 시점의 공식 공고와 운영기관 안내가 우선합니다. 제이커브는 선정이나 지원금 지급을 보장하지 않습니다.</p>
            </div>
        </section>

        <section id="support-problem" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">The Problem</span>
                <h2 class="landing__head">예산은 있는데, 무엇을 남겨야 할지 모를 때</h2>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>과업이 모호합니다</strong><span>‘온라인 마케팅’이라는 한 줄만 있고 어떤 고객과 행동을 만들지 정해지지 않았습니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>인정 범위가 다릅니다</strong><span>광고비, 제작비, 매체비와 운영비의 인정 여부가 공고마다 달라 사전 확인이 필요합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>일정이 거꾸로 갑니다</strong><span>집행 마감부터 맞추다 보면 조사·제작·검수 시간이 부족해집니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>성과와 증빙이 분리됩니다</strong><span>광고 성과는 나왔지만 보고서에 필요한 계약·변경·집행 자료가 빠질 수 있습니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>담당자가 많습니다</strong><span>기업, 운영기관, 공급사 사이의 확인 내용과 승인 이력이 흩어지기 쉽습니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>지원금이 목표가 됩니다</strong><span>사업의 실제 문제보다 예산 소진이 우선되면 과업이 끝난 뒤 남는 자산이 없습니다.</span></div>
                </div>
            </div>
        </section>

        <section id="support-scope" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Scope</span>
                <h2 class="landing__head">공고 해석부터 실행·결과 자료까지</h2>
                <p class="landing__lead">실제 지원 범위는 사업 규정과 계약에 따라 확정합니다. 모든 지원사업에서 아래 항목이 전부 가능한 것은 아닙니다.</p>
                <div class="landing__points">
                    <div class="landing__point"><strong>적합성 검토</strong><span>공고의 대상, 기간, 과업, 인정 항목과 필요한 결과물을 확인합니다.</span></div>
                    <div class="landing__point"><strong>목표·KPI 설계</strong><span>사업 목적을 광고·검색·콘텐츠·웹의 측정 가능한 목표로 바꿉니다.</span></div>
                    <div class="landing__point"><strong>실행 계획</strong><span>일정, 채널, 제작물, 승인 단계와 담당자를 한 흐름으로 정리합니다.</span></div>
                    <div class="landing__point"><strong>마케팅 운영</strong><span>승인된 범위 안에서 캠페인·콘텐츠·웹 과업을 실행하고 변경 이력을 남깁니다.</span></div>
                    <div class="landing__point"><strong>성과 확인</strong><span>과업 목표와 실제 운영 데이터를 같은 기준으로 비교합니다.</span></div>
                    <div class="landing__point"><strong>결과 자료 정리</strong><span>계약 범위에 따라 결과 보고에 필요한 실행 내역과 성과 자료를 정리합니다.</span></div>
                </div>
            </div>
        </section>

        <section id="support-services" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Execution</span>
                <h2 class="landing__head">과업에 맞는 실행 수단을 고릅니다</h2>
                <p class="landing__body">유행하는 채널을 끼워 넣기보다 공고가 요구하는 결과와 기업이 실제로 필요한 자산이 겹치는 지점을 찾습니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'performance-marketing']) }}"><strong>퍼포먼스 마케팅</strong><p>매체 집행, 전환 측정, 크리에이티브 테스트와 운영 리포트.</p><span>서비스 보기 →</span></a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'seo']) }}"><strong>SEO·AEO·GEO</strong><p>검색 가능한 기술 기반, 콘텐츠와 AI 가시성 자산 구축.</p><span>서비스 보기 →</span></a>
                    <a class="subcard" href="{{ route('services.show', ['slug' => 'wordpress']) }}"><strong>워드프레스 제작</strong><p>검색·광고·운영과 전환 측정을 고려한 웹사이트 제작.</p><span>서비스 보기 →</span></a>
                    <a class="subcard" href="{{ route('services.performance.sub', ['sub' => 'youtube']) }}"><strong>영상·유튜브</strong><p>목표·시청자·메시지·배포를 연결한 영상 콘텐츠와 캠페인.</p><span>서비스 보기 →</span></a>
                </div>
                <p class="landing__note">각 항목의 지원금 인정 여부와 공급 범위는 해당 사업의 공고·협약·운영기관 확인 후 확정합니다.</p>
            </div>
        </section>

        <section id="support-process" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Process</span>
                <h2 class="landing__head">마감일부터 역산해, 승인 지점을 먼저 잡습니다</h2>
                <div class="steps">
                    <div class="steps__item"><strong>공고·협약·과업 기준 확인</strong><p>대상, 기간, 인정 비용, 필수 결과물, 변경 승인과 정산 조건을 확인합니다.</p></div>
                    <div class="steps__item"><strong>기업 현황과 목표 진단</strong><p>제품·시장·고객, 기존 채널과 자료, 내부 담당자와 현실적인 실행 여건을 봅니다.</p></div>
                    <div class="steps__item"><strong>과업·KPI·산출물 설계</strong><p>무엇을 실행하고 어떤 자료와 지표를 결과로 남길지 정합니다.</p></div>
                    <div class="steps__item"><strong>일정과 승인 단계 확정</strong><p>기획·제작·검수·집행·보고 일정을 마감일에서 역산하고 각 승인 주체를 정합니다.</p></div>
                    <div class="steps__item"><strong>제작·집행·운영</strong><p>승인된 범위에서 실행하고 변경 사항과 근거를 기록합니다.</p></div>
                    <div class="steps__item"><strong>성과 분석과 개선</strong><p>운영 데이터를 확인해 가능한 범위 안에서 소재·타깃·콘텐츠·페이지를 조정합니다.</p></div>
                    <div class="steps__item"><strong>결과 자료 정리</strong><p>실행 내역, 산출물, 성과와 변경 이력을 계약 범위와 사업 기준에 맞춰 정리합니다.</p></div>
                </div>
            </div>
        </section>

        <section id="support-deliverables" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Deliverables</span>
                <h2 class="landing__head">집행이 끝난 뒤에도 확인할 수 있는 자료</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>과업 해석 요약</strong><span>확인한 목표, 인정 범위, 제약과 필요한 승인 항목을 정리합니다.</span></div>
                    <div class="landing__point"><strong>실행 계획표</strong><span>채널·콘텐츠·일정·담당자와 주요 승인 지점을 정리합니다.</span></div>
                    <div class="landing__point"><strong>제작 산출물</strong><span>계약된 광고 소재, 콘텐츠, 영상, 웹 페이지 등을 합의한 형식으로 제공합니다.</span></div>
                    <div class="landing__point"><strong>운영 기록</strong><span>집행 기간, 주요 변경 내용과 승인 이력을 남깁니다.</span></div>
                    <div class="landing__point"><strong>성과 자료</strong><span>공고와 과업에서 합의한 지표를 기준으로 결과를 정리합니다.</span></div>
                    <div class="landing__point"><strong>후속 제안</strong><span>지원 기간 종료 후 유지할 자산과 다음 개선 우선순위를 구분합니다.</span></div>
                </div>
                <p class="landing__note">운영기관의 특정 서식 작성이나 정산 대행 여부는 사업과 계약에 따라 달라집니다. 제공 산출물 목록을 착수 전에 확정합니다.</p>
            </div>
        </section>

        <section id="support-roles" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Roles</span>
                <h2 class="landing__head">기업·제이커브·운영기관의 역할을 섞지 않습니다</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>참여 기업이 준비할 것</h3>
                        <ul>
                            <li>사업자와 신청 자격 관련 사실 자료</li>
                            <li>제품·서비스·고객과 기존 성과 자료</li>
                            <li>공고문·협약서·과업지시서</li>
                            <li>콘텐츠와 광고 표현의 사실 확인</li>
                            <li>내부 승인 담당자와 피드백 일정</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>제이커브가 협의할 것</h3>
                        <ul>
                            <li>마케팅 과업과 실행 범위 설계</li>
                            <li>채널·콘텐츠·웹 제작과 운영</li>
                            <li>측정 기준과 운영 데이터 정리</li>
                            <li>계약된 산출물과 실행 이력 제공</li>
                            <li>변경이 필요한 항목의 사전 공유</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">지원 자격 판단, 선정, 협약 승인과 최종 정산은 운영기관의 권한입니다. 공식 확인이 필요한 사항은 운영기관 답변을 기준으로 합니다.</p>
            </div>
        </section>

        <section id="support-fit" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Readiness Check</span>
                <h2 class="landing__head">상담 전에 준비하면 빨라지는 것</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>준비된 프로젝트</h3>
                        <ul>
                            <li>공고문 또는 사업명이 명확하다.</li>
                            <li>마감·집행 기간과 예산 구조를 알고 있다.</li>
                            <li>마케팅할 제품과 목표 고객을 설명할 수 있다.</li>
                            <li>내부 승인자와 자료 담당자가 정해져 있다.</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>먼저 확인할 프로젝트</h3>
                        <ul>
                            <li>사업명 없이 지원금 사용 가능 여부만 묻는다.</li>
                            <li>인정 비용과 자부담 구조를 확인하지 않았다.</li>
                            <li>선정이나 성과 보장을 계약 조건으로 요구한다.</li>
                            <li>마감 직전인데 제작·승인 자료가 준비되지 않았다.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="support-faq" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">지원사업 상담 전에</h2>
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
                <h2>공고문부터 같이 읽어보겠습니다</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">사업명·공고문, 마감일, 지원 예산과 원하는 마케팅 과업을 알려주세요. 가능한 실행 범위와 먼저 확인할 조건을 정리하겠습니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">지원사업 마케팅 상담</a>
                </div>
            </div>
        </section>
    </main>
@endsection
