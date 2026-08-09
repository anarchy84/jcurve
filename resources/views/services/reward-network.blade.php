@extends('layouts.app')

@php
    $faqs = [
        ['question' => '어떤 액션으로 캠페인을 만들 수 있나요?', 'answer' => '앱 설치, 첫 실행, 회원가입, 튜토리얼 완료, 특정 미션 도달, 견적·상담 신청, 구매 등 확인 가능한 행동을 기준으로 설계할 수 있습니다. 실제 가능 여부와 단가는 업종, 난이도, 검수 방식에 따라 달라집니다.'],
        ['question' => '리워드 유저는 품질이 낮지 않나요?', 'answer' => '설치만 목표로 두면 일회성 참여가 늘 수 있습니다. 후속 미션, 유효 조건, 중복 기준과 관찰 지표를 함께 설계해 캠페인 목적에 맞는 품질을 판단해야 합니다. 리워드 여부만으로 모든 유저의 가치를 단정하지 않습니다.'],
        ['question' => '원하는 물량을 보장할 수 있나요?', 'answer' => '고정 물량을 사전 보장하지 않습니다. 가용 물량은 타깃, 단가, 미션 난이도, 기간과 매체 상황에 따라 달라집니다. 초기 테스트에서 참여·승인 흐름을 확인한 뒤 확대 범위를 결정합니다.'],
        ['question' => '매체 연동에는 반드시 SDK가 필요한가요?', 'answer' => '연동 방식은 앱 구조와 운영 범위에 따라 달라집니다. 기존 지면, 웹뷰, 서버 연동 가능 여부와 보상 처리 구조를 확인한 뒤 개발 범위와 테스트 절차를 합의합니다.'],
        ['question' => '웹서비스도 매체 제휴가 가능한가요?', 'answer' => '서비스 구조, 로그인·회원 식별, 리워드 정책, 트래픽 특성과 구현 가능성을 먼저 확인해야 합니다. 앱과 동일한 방식이라고 단정하지 않고 개별 검토합니다.'],
        ['question' => '무효 전환은 어떻게 정하나요?', 'answer' => '중복 참여, 필수 조건 미충족, 취소·환불, 비정상 패턴처럼 캠페인별 무효 기준과 필요한 증빙을 집행 전에 합의합니다. 기준을 집행 중 임의로 바꾸지 않는 것이 중요합니다.'],
        ['question' => '광고주는 무엇을 준비해야 하나요?', 'answer' => '목표 액션, 희망 일정과 예산 범위, 랜딩 또는 앱 링크, 전환 확인 방식, 제한 조건, 소재와 브랜드 가이드를 준비하면 됩니다. 준비되지 않은 항목은 상담에서 체크리스트로 정리합니다.'],
        ['question' => '매체 제휴 전에 무엇을 확인하나요?', 'answer' => '서비스와 이용자 특성, 월간 활성 이용 규모, 희망 지면, 리워드 정책, 개발 환경, 운영·CS·정산 담당 체계를 확인합니다. 그 결과를 바탕으로 연동 가능 범위와 순서를 정합니다.'],
    ];
@endphp

@section('title', '리워드 네트워크 — 광고주 액션과 앱 수익화를 연결합니다 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="설치·가입·미션·구매 등 목표 액션을 설계하는 광고주 캠페인부터 오퍼월·리워드 지면을 운영하는 앱 매체 제휴까지. 유효 전환 기준, 트래킹, 운영, 검수와 정산을 한 흐름으로 연결합니다.">
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
        {{-- 경쟁사명은 meta·title·본문에 사용하지 않는다. 정보 밀도와 구조만 참고한다. --}}
        <section class="landing__hero landing__hero--media">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                <div class="landing__hero-mark"><span class="icon3d icon3d--float"><img src="{{ asset('media/icons3d/reward.webp') }}" alt="리워드 네트워크" width="76" height="76" loading="eager"></span></div>
                <span class="landing__eyebrow">Reward Network</span>
                <h1>유저의 참여가<br>광고주의 액션과 매체의 수익이 되도록</h1>
                <p class="landing__lead">설치 수만 늘리는 리워드가 아닙니다. 목표 액션, 보상, 유효 기준, 트래킹과 정산을 한 구조로 설계해 광고주·유저·매체가 오래 갈 수 있는 네트워크를 만듭니다.</p>
                <div class="landing__chips" style="justify-content:center;">
                    <span style="color:var(--ink);border-color:var(--hairline);">앱 설치</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">회원가입</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">미션 완료</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">상담 신청</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">구매</span>
                    <span style="color:var(--ink);border-color:var(--hairline);">앱 수익화</span>
                </div>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact', ['service_interest' => 'reward-advertiser', 'message' => '리워드 광고 캠페인 집행을 문의합니다. 목표 액션과 일정, 예산 범위를 상담하고 싶습니다.']) }}">광고주 캠페인 문의</a>
                    <a class="btn-ghost" href="{{ route('contact', ['service_interest' => 'reward-publisher', 'message' => '앱 리워드 매체 제휴를 문의합니다. 서비스와 이용자, 희망 지면을 상담하고 싶습니다.']) }}">앱 매체 제휴 문의</a>
                </div>
                </div>
                <figure class="landing__hero-figure"><img src="{{ asset('media/scenes/reward.webp') }}" alt="" width="1000" height="750" loading="eager"></figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="리워드 네트워크 페이지 바로가기">
            <div class="landing__local-nav-inner">
                <a href="#ecosystem">구조</a>
                <a href="#advertisers">광고주</a>
                <a href="#quality">품질 관리</a>
                <a href="#publishers">매체사</a>
                <a href="#onboarding">연동 절차</a>
                <a href="#deliverables">제공 범위</a>
                <a href="#fit">적합성</a>
                <a href="#faq">FAQ</a>
            </div>
        </nav>

        <section class="landing__section landing__section--light" id="ecosystem">
            <div class="landing__inner">
                <span class="landing__eyebrow">Three-sided Network</span>
                <h2 class="landing__head">리워드 광고는 세 참여자의 약속입니다</h2>
                <p class="landing__lead">누군가 한쪽만 이기면 오래가지 못합니다. 보상은 명확해야 하고, 액션은 검증 가능해야 하며, 지면은 서비스 경험을 해치지 않아야 합니다.</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light">
                        <strong>유저에게는 납득 가능한 보상</strong>
                        <p>해야 할 미션, 받게 될 리워드, 지급 시점과 제외 조건을 참여 전에 이해할 수 있어야 합니다.</p>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>광고주에게는 확인 가능한 행동</strong>
                        <p>보기만 한 사람보다 설치·가입·미션·구매처럼 사업 목표에 가까운 행동을 정의하고 측정합니다.</p>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>매체에는 지속 가능한 수익</strong>
                        <p>이용 흐름 안에서 자연스러운 지면과 보상 정책을 설계해 단기 수익과 유저 경험 사이의 균형을 잡습니다.</p>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>네트워크에는 투명한 기준</strong>
                        <p>승인·거절·보상·정산 기준을 사전에 맞추고, 이슈가 생겼을 때 확인할 근거를 남깁니다.</p>
                    </div>
                </div>
                <div class="landing__callout">리워드의 본질은 포인트가 아닙니다. 유저가 행동할 이유와 광고주가 그 행동을 인정할 기준을 연결하는 일입니다.</div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Where Campaigns Break</span>
                <h2 class="landing__head">물량만 먼저 사면, 뒤에서 문제가 터집니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>목표 액션이 너무 얕다</h3>
                        <p>설치만 과금하면 설치 후 바로 이탈한 참여와 실제 관심 유저를 구분하기 어렵습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>완료 조건이 모호하다</h3>
                        <p>회원가입 완료인지 인증 완료인지, 구매 완료인지 결제 유지인지가 불분명하면 승인과 정산이 흔들립니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>보상과 난이도가 맞지 않는다</h3>
                        <p>해야 할 일에 비해 보상이 작으면 참여가 나오지 않고, 과하면 목적과 무관한 참여가 몰릴 수 있습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>광고주와 매체의 데이터가 다르다</h3>
                        <p>시간대, 중복 기준, 전환 창, 취소 반영 방식이 다르면 같은 참여를 두고 서로 다른 숫자를 보게 됩니다.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb" id="advertisers">
            <div class="landing__inner">
                <span class="landing__eyebrow">For Advertisers</span>
                <h2 class="landing__head">광고주 캠페인 — 가장 싼 액션보다, 다음 행동이 남는 액션</h2>
                <p class="landing__lead">비즈니스 목표에서 역산해 참여 단계를 정합니다. 깊은 미션이 무조건 좋은 것도, 낮은 단가가 무조건 효율적인 것도 아닙니다.</p>
                <div class="steps">
                    <div class="steps__item"><strong>사업 목표를 한 문장으로 정의</strong><p>신규 설치, 첫 사용 경험, 회원 확보, 상담 리드, 구매처럼 이번 캠페인이 바꿔야 할 행동을 하나로 좁힙니다.</p></div>
                    <div class="steps__item"><strong>행동의 깊이를 설계</strong><p>설치에서 끝낼지, 가입·튜토리얼·특정 미션까지 이어갈지 유저 가치와 참여 장벽을 함께 봅니다.</p></div>
                    <div class="steps__item"><strong>보상과 단가를 맞춤</strong><p>미션 난이도, 예상 소요 시간, 타깃 범위, 승인 지연을 고려해 참여 가능한 조건을 만듭니다.</p></div>
                    <div class="steps__item"><strong>유효·무효 기준을 고정</strong><p>신규 여부, 중복, 필수 단계, 취소·환불, 인정 기간과 증빙 방식을 집행 전에 문서화합니다.</p></div>
                    <div class="steps__item"><strong>소량 검증 후 확대</strong><p>초기 참여율과 승인율, 후속 행동을 확인한 뒤 단가·메시지·미션을 조정하고 확대 여부를 판단합니다.</p></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Action Design</span>
                <h2 class="landing__head">목표에 맞춰 액션의 깊이를 고릅니다</h2>
                <div class="compare-table-wrap">
                    <table class="compare-table">
                        <thead>
                            <tr><th scope="col">목표 단계</th><th scope="col">설계 예시</th><th scope="col">반드시 확인할 것</th></tr>
                        </thead>
                        <tbody>
                            <tr><th scope="row">인지·방문</th><td>콘텐츠 열람, 지정 페이지 방문</td><td>체류 조건, 중복 참여, 랜딩 속도</td></tr>
                            <tr><th scope="row">앱 확보</th><td>신규 설치, 첫 실행</td><td>신규 판별, OS·스토어, 설치 후 이벤트</td></tr>
                            <tr><th scope="row">활성화</th><td>회원가입, 튜토리얼, 레벨·미션 도달</td><td>완료 이벤트, 예상 소요 시간, 이탈 구간</td></tr>
                            <tr><th scope="row">리드</th><td>견적·상담·예약 신청</td><td>필수 정보, 연락 동의, 유효 리드 기준</td></tr>
                            <tr><th scope="row">매출</th><td>첫 구매, 구독, 특정 상품 결제</td><td>최소 금액, 취소·환불, 승인 시점</td></tr>
                        </tbody>
                    </table>
                </div>
                <p class="landing__note">표의 항목은 캠페인 설계 예시이며 제공 가능 상품이나 물량을 보장하는 목록이 아닙니다. 실제 집행 조건은 업종·매체·기술 환경을 확인한 뒤 확정합니다.</p>
            </div>
        </section>

        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Campaign Architecture</span>
                <h2 class="landing__head">한 번의 설치가 아니라, 행동 사다리를 만듭니다</h2>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>1. 진입</strong><span>광고 메시지와 미션 조건을 보고 참여를 선택합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>2. 핵심 액션</strong><span>설치·가입·상담·구매처럼 사전에 정의한 행동을 완료합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>3. 검증</strong><span>전환 데이터와 조건을 대조해 승인·대기·무효 상태를 구분합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>4. 후속 관찰</strong><span>가용 데이터 범위 안에서 재방문·추가 행동·취소 여부를 보고 다음 설계에 반영합니다.</span></div>
                </div>
                <div class="prose" style="margin-top:28px;">
                    <p>깊은 미션일수록 참여량은 줄고 의도는 선명해질 수 있습니다. 반대로 얕은 미션은 빠르게 도달을 만들지만 후속 품질을 별도로 확인해야 합니다. 제이커브는 둘 중 하나를 정답으로 밀지 않고 캠페인 목적에 맞춰 단계와 예산을 나눕니다.</p>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb" id="quality">
            <div class="landing__inner">
                <span class="landing__eyebrow">Validation & Quality</span>
                <h2 class="landing__head">품질은 ‘느낌’이 아니라 승인 규칙으로 관리합니다</h2>
                <p class="landing__lead">네트워크의 신뢰는 많이 승인하는 데서 나오지 않습니다. 왜 승인했고 왜 제외했는지 설명할 수 있을 때 생깁니다.</p>
                <div class="landing__points">
                    <div class="landing__point"><strong>신규·중복 기준</strong><span>동일 이용자, 기기, 계정, 광고 식별자 등 캠페인에서 사용할 판별 기준을 합의합니다.</span></div>
                    <div class="landing__point"><strong>완료 이벤트 기준</strong><span>단순 페이지 진입과 실제 완료를 구분하고, 필수 이벤트가 정상 수신됐는지 확인합니다.</span></div>
                    <div class="landing__point"><strong>시간·순서 기준</strong><span>클릭과 전환 사이 인정 기간, 비정상적으로 짧은 완료, 단계 역전 등 확인 규칙을 둡니다.</span></div>
                    <div class="landing__point"><strong>취소·환불 기준</strong><span>구매형 캠페인은 취소·환불 반영 시점과 승인 보류 기간을 사전에 정합니다.</span></div>
                    <div class="landing__point"><strong>이상 패턴 검토</strong><span>특정 구간에 반복되는 비정상 패턴은 원자료와 운영 이력을 함께 확인해 처리합니다.</span></div>
                    <div class="landing__point"><strong>이의 제기 근거</strong><span>광고주·매체가 같은 기준으로 확인할 수 있도록 필요한 증빙 항목과 처리 기한을 정합니다.</span></div>
                </div>
                <p class="landing__note">수집·처리하는 데이터 범위와 보관 방식은 캠페인 구조, 파트너 계약, 관련 법령과 플랫폼 정책에 맞춰 개별 확인합니다.</p>
            </div>
        </section>

        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Measurement Flow</span>
                <h2 class="landing__head">클릭부터 정산까지 같은 이벤트를 봅니다</h2>
                <div class="steps">
                    <div class="steps__item"><strong>참여 식별</strong><p>유저가 어느 매체와 캠페인에서 미션을 시작했는지 구분합니다.</p></div>
                    <div class="steps__item"><strong>액션 수신</strong><p>광고주 측 전환 이벤트 또는 합의한 확인 방식으로 완료 여부를 전달받습니다.</p></div>
                    <div class="steps__item"><strong>조건 대조</strong><p>신규·중복·필수 단계·인정 기간 등 사전 기준과 대조합니다.</p></div>
                    <div class="steps__item"><strong>보상·승인 상태 반영</strong><p>즉시 승인 또는 검수 대기처럼 캠페인별 처리 상태를 매체 운영 흐름에 반영합니다.</p></div>
                    <div class="steps__item"><strong>리포트와 정산</strong><p>확정된 유효 전환을 기준으로 광고주·매체 데이터 차이를 점검하고 정산합니다.</p></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="publishers">
            <div class="landing__inner">
                <span class="landing__eyebrow">For Publishers</span>
                <h2 class="landing__head">매체 제휴 — 지면을 붙이는 일이 아니라, 이용 흐름에 수익 모델을 넣는 일</h2>
                <p class="landing__lead">앱의 핵심 행동과 리워드 사용처를 이해하지 못한 지면은 잠깐의 수익 뒤에 피로도와 CS를 남깁니다. 매체의 서비스 경험부터 보고 배치와 운영 방식을 정합니다.</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>유저 경험 설계</h3>
                        <ul>
                            <li>어느 화면과 순간에 리워드가 자연스러운지</li>
                            <li>미션 조건과 승인 상태를 어떻게 안내할지</li>
                            <li>포인트 지급·사용 흐름과 어떤 관계인지</li>
                            <li>광고 피로와 핵심 기능 이탈을 어떻게 관찰할지</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>수익 운영 설계</h3>
                        <ul>
                            <li>이용자 특성에 맞는 캠페인 조건 선별</li>
                            <li>노출·참여·승인 상태와 이슈 확인</li>
                            <li>무효 사유와 CS 처리 경로 합의</li>
                            <li>확정 전환 기준 리포트와 정산 점검</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">가용 캠페인과 예상 수익은 시기, 이용자 구성, 지면, 참여율, 단가와 승인 조건에 따라 달라집니다. 제휴 검토 단계에서 고정 수익을 보장하지 않습니다.</p>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Placement Options</span>
                <h2 class="landing__head">서비스 성격에 맞는 접점을 고릅니다</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>오퍼월형</strong><span>유저가 보상을 목적으로 직접 진입해 여러 미션을 탐색하는 전용 지면입니다.</span></div>
                    <div class="landing__point"><strong>미션 카드형</strong><span>출석, 이벤트, 포인트 메뉴 등 기존 서비스 흐름 안에 개별 캠페인을 연결합니다.</span></div>
                    <div class="landing__point"><strong>프로모션형</strong><span>특정 기간과 목적에 맞춰 한정 캠페인이나 공동 이벤트 형태로 운영합니다.</span></div>
                    <div class="landing__point"><strong>맞춤 연동형</strong><span>기존 리워드 정책과 개발 환경을 검토해 노출, 상태, 보상 흐름을 협의합니다.</span></div>
                </div>
                <p class="landing__note">실제 지원 지면과 연동 방식은 매체 환경 검토 후 확정됩니다. 특정 SDK·API 제공을 이 페이지에서 일괄 보장하지 않습니다.</p>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="onboarding">
            <div class="landing__inner">
                <span class="landing__eyebrow">Publisher Onboarding</span>
                <h2 class="landing__head">매체 검토부터 운영 안정화까지</h2>
                <div class="steps">
                    <div class="steps__item"><strong>서비스·이용자 확인</strong><p>앱 카테고리, 주요 이용자, 활성 규모, 리워드 사용처와 기존 광고 운영 상태를 확인합니다.</p></div>
                    <div class="steps__item"><strong>지면·정책 설계</strong><p>노출 위치, 참여 동선, 보상 표시, 승인 대기와 CS 안내 방식을 정합니다.</p></div>
                    <div class="steps__item"><strong>연동 범위 합의</strong><p>매체의 개발 환경에 맞춰 필요한 데이터, 상태 처리, 테스트 범위와 담당자를 확정합니다.</p></div>
                    <div class="steps__item"><strong>테스트 캠페인 검수</strong><p>참여 시작부터 액션 수신, 승인 상태, 보상 반영까지 전체 흐름을 실제 조건으로 확인합니다.</p></div>
                    <div class="steps__item"><strong>오픈 후 운영 보정</strong><p>참여율, 승인 이슈, CS, 지면 반응을 보고 캠페인 구성과 안내 문구를 조정합니다.</p></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="deliverables">
            <div class="landing__inner">
                <span class="landing__eyebrow">What We Align</span>
                <h2 class="landing__head">집행 전에 문서로 맞추고, 운영 중에는 같은 기준으로 봅니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>광고주와 맞추는 항목</h3>
                        <ul>
                            <li>목표 액션과 캠페인 퍼널</li>
                            <li>타깃·기간·예산·단가 조건</li>
                            <li>전환 확인과 유효·무효 기준</li>
                            <li>소재·랜딩·미션 안내 문구</li>
                            <li>리포트 지표와 정산 기준</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>매체와 맞추는 항목</h3>
                        <ul>
                            <li>지면과 이용자 참여 동선</li>
                            <li>보상·승인 대기·실패 안내</li>
                            <li>연동·테스트·오픈 체크리스트</li>
                            <li>CS 이관과 이의 제기 절차</li>
                            <li>전환 확정과 정산 일정</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Operating Rhythm</span>
                <h2 class="landing__head">오픈이 끝이 아니라 운영의 시작입니다</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>일상 모니터링</strong><span>참여·전환·승인 흐름에서 급격한 변화와 운영 이슈를 확인합니다.</span></div>
                    <div class="landing__point"><strong>캠페인 보정</strong><span>참여가 낮으면 메시지·보상·난이도를, 품질이 낮으면 액션 깊이와 승인 기준을 재검토합니다.</span></div>
                    <div class="landing__point"><strong>CS 원인 분류</strong><span>보상 미지급, 조건 오인, 승인 지연을 구분해 광고주·매체 중 확인 주체를 명확히 합니다.</span></div>
                    <div class="landing__point"><strong>마감·정산 확인</strong><span>캠페인별 확정 전환과 조정 내역을 대조해 양측이 같은 기준으로 마감하도록 합니다.</span></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">Fit Check</span>
                <h2 class="landing__head">리워드 네트워크가 맞는 경우와 먼저 기반을 정비해야 하는 경우</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>지금 검토하기 좋은 경우</h3>
                        <ul>
                            <li>짧은 기간에 확인 가능한 액션을 확보해야 한다</li>
                            <li>설치 이후 가입·미션·구매까지 단계를 설계하고 싶다</li>
                            <li>앱의 포인트·리워드 체계에 수익 지면을 연결하고 싶다</li>
                            <li>광고주와 매체 사이 승인·정산 운영을 맡길 파트너가 필요하다</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>먼저 기반을 정비할 경우</h3>
                        <ul>
                            <li>무엇을 전환으로 볼지 내부 합의가 없다</li>
                            <li>완료 이벤트를 확인할 방법이 전혀 없다</li>
                            <li>과도하게 낮은 단가로 고정 물량을 보장받고 싶다</li>
                            <li>매체의 보상 정책과 CS 담당 체계가 준비되지 않았다</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">광고주와 매체가 자주 묻는 질문</h2>
                <div class="faq">
                    @foreach ($faqs as $faq)
                        <details class="faq__item"><summary>{{ $faq['question'] }}</summary><p>{{ $faq['answer'] }}</p></details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">Start With The Right Brief</span>
                <h2>광고주라면 액션을,<br>매체라면 수익 구조를 말해주세요</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">목표·조건·기술 환경을 먼저 확인하고, 가능한 범위와 다음 단계를 구체적으로 답합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact', ['service_interest' => 'reward-advertiser', 'message' => '리워드 광고 캠페인 집행을 문의합니다. 목표 액션과 일정, 예산 범위를 상담하고 싶습니다.']) }}">광고주 캠페인 문의</a>
                    <a class="btn-ghost" href="{{ route('contact', ['service_interest' => 'reward-publisher', 'message' => '앱 리워드 매체 제휴를 문의합니다. 서비스와 이용자, 희망 지면을 상담하고 싶습니다.']) }}">앱 매체 제휴 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
