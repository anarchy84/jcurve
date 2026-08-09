@extends('layouts.app')

@section('title', '콜투세일 — 동의 기반 보험 상담 리드 운영 CRM | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="원천 DB 관리, 상담원 배분, AI 콜 품질 분석, 수주·납품·AS·전자계약·정산까지 보험DB 콜센터의 운영 흐름을 관리하는 세일즈 CRM 콜투세일.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero landing__hero--media">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                <nav class="subpage__breadcrumb" aria-label="상위"><a href="{{ route('solutions.index') }}">솔루션</a></nav>
                <span class="landing__eyebrow">Call2.Sale</span>
                <h1>동의 기반 보험 상담 리드를<br>생산·운영·납품하는 CRM</h1>
                <p class="landing__lead">원천 DB 관리, 상담원 배분, AI 콜 품질 분석,
                   수주·납품·AS·전자계약·정산 — 콜센터 운영의 전 공정을 한 흐름에서 관리합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://call2.sale" target="_blank" rel="noopener">콜투세일 바로가기 →</a>
                    <a class="btn-ghost" href="#governance">AI·개인정보 확인사항</a>
                </div>
                <p class="landing__note">AI 분석은 상담 검토를 돕는 보조 정보입니다. 분석 결과의 정확도나 영업 성과를 보장하지 않으며 최종 평가는 사람이 원자료와 맥락을 함께 확인해야 합니다.</p>
                </div>
                <figure class="landing__hero-figure"><img src="{{ asset('media/scenes/call2sale.webp') }}" alt="" width="1000" height="750" loading="eager"></figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="콜투세일 페이지 바로가기">
            <div class="landing__local-nav-inner">
                <a href="#overview">서비스 정의</a>
                <a href="#problem">문제</a>
                <a href="#features">기능</a>
                <a href="#workflow">운영 흐름</a>
                <a href="#onboarding">도입 절차</a>
                <a href="#governance">제공 범위·준법</a>
                <a href="#fit">적합성</a>
                <a href="#faq">FAQ</a>
            </div>
        </nav>

        {{-- ① 정의 [라이트] --}}
        <section class="landing__section landing__section--light" id="overview">
            <div class="landing__inner">
                <span class="landing__eyebrow">CRM For The Supply Side</span>
                <h2 class="landing__head">상담 생산부터 납품·정산까지 이어보는 콜센터 운영 CRM</h2>
                <p class="landing__lead">콜투세일은 보험DB를 생산·납품하는 콜센터를 위한 서비스입니다. 원천 DB가 상담원에게 배분되고, 상담 결과가 수주·납품·AS·전자계약·정산으로 이어지는 흐름을 관리합니다.</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>생산 운영</h3>
                        <p>원천 DB와 상담원 배분, 상담 진행과 AI 콜 품질 분석 정보를 한 운영 흐름에서 확인합니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>거래 운영</h3>
                        <p>주문 수주, DB 납품, AS, 전자계약과 정산 상태를 앞선 생산 기록과 이어 관리합니다.</p>
                    </article>
                </div>
                <div class="landing__callout">콜센터가 커질수록 통화 건수보다 중요한 건, 누가 어떤 기준으로 만들고 무엇을 근거로 납품했는지 남기는 일입니다.</div>
            </div>
        </section>

        {{-- ② 문제 [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="problem">
            <div class="landing__inner">
                <span class="landing__eyebrow">Where Operations Break</span>
                <h2 class="landing__head">납품처는 늘었는데 관리가 안 될 때</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>원천 DB와 상담 결과가 갈린다</h3>
                        <p>어떤 원천에서 들어온 대상이 누구에게 배분돼 어떤 결과가 됐는지 이어지지 않으면 생산 품질을 비교하기 어렵습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>상담 품질이 감에 의존한다</h3>
                        <p>일부 통화만 듣거나 관리자 기억에 의존하면 동일한 기준으로 코칭하고 이슈를 찾기 어렵습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>주문과 납품 기준이 다르다</h3>
                        <p>고객사별 주문 조건과 유효 기준, 납품 이력이 분리되면 누락·중복·반품 이슈를 확인하는 시간이 늘어납니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>AS와 정산이 월말에 몰린다</h3>
                        <p>납품 이후의 AS 근거와 계약·정산 상태가 따로 있으면 확정 수량과 비용을 다시 맞춰야 합니다.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- ③ 기능 [다크] --}}
        <section class="landing__section landing__section--dark has-orb" id="features">
            <div class="landing__inner">
                <span class="landing__eyebrow">Operational Modules</span>
                <h2 class="landing__head">콜센터의 전 공정을 하나의 상태 흐름으로</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>원천 DB 관리</strong><span>상담 대상이 들어온 출처와 운영에 필요한 상태를 관리합니다.</span></div>
                    <div class="landing__point"><strong>상담원 배분</strong><span>원천 DB를 상담원에게 배분하고 담당 관계와 진행 상태를 확인합니다.</span></div>
                    <div class="landing__point"><strong>AI 콜 품질 분석</strong><span>통화 품질을 검토하는 데 참고할 분석 정보를 제공해 관리자 확인을 보조합니다.</span></div>
                    <div class="landing__point"><strong>수주·납품</strong><span>고객사의 주문 조건과 생산된 DB의 납품 상태를 이어 관리합니다.</span></div>
                    <div class="landing__point"><strong>AS·전자계약</strong><span>납품 이후 이슈와 계약 상태를 앞선 상담·납품 기록과 연결합니다.</span></div>
                    <div class="landing__point"><strong>정산 관리</strong><span>확인된 운영 기록을 토대로 정산 상태와 후속 업무를 관리합니다.</span></div>
                </div>
                <p class="landing__note">실제 화면, 자동화 범위, AI 분석 항목, 연동·전자계약·정산 기능의 세부 조건은 콜투세일의 현재 서비스에서 확인해야 합니다.</p>
            </div>
        </section>

        {{-- ④ 운영 흐름 [라이트] --}}
        <section class="landing__section landing__section--light" id="workflow">
            <div class="landing__inner">
                <span class="landing__eyebrow">Source To Settlement</span>
                <h2 class="landing__head">한 건의 DB가 만들어지고 납품되는 순서</h2>
                <div class="steps">
                    <div class="steps__item"><strong>원천과 처리 기준 등록</strong><p>DB 출처와 이용 근거, 고객사별 생산 조건, 상담 가능 범위와 내부 권한을 먼저 확인합니다.</p></div>
                    <div class="steps__item"><strong>상담원 배분</strong><p>담당자와 배분 기준을 정하고 중복·무단 접근을 막을 운영 규칙을 적용합니다.</p></div>
                    <div class="steps__item"><strong>상담 진행과 품질 확인</strong><p>상담 결과를 기록하고 AI 분석 정보와 필요한 원자료를 함께 보며 관리자 검토와 코칭에 참고합니다.</p></div>
                    <div class="steps__item"><strong>주문 조건에 맞춰 납품</strong><p>고객사가 합의한 유효 기준과 제공 범위에 맞는지 확인하고 납품 상태를 남깁니다.</p></div>
                    <div class="steps__item"><strong>AS·계약·정산 처리</strong><p>이의 제기와 교환·반품, 전자계약, 확정 수량과 정산 상태를 앞선 이력과 연결해 관리합니다.</p></div>
                </div>
            </div>
        </section>

        {{-- ⑤ 도입 절차 [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="onboarding">
            <div class="landing__inner">
                <span class="landing__eyebrow">Adoption Checklist</span>
                <h2 class="landing__head">데이터를 넣기 전에 기준과 권한부터 정합니다</h2>
                <div class="steps">
                    <div class="steps__item"><strong>현재 서비스 조건 확인</strong><p>콜투세일에서 가입·이용 대상, 현재 제공 기능, 요금과 도입 조건을 확인합니다.</p></div>
                    <div class="steps__item"><strong>업무 상태와 고객사 기준 정리</strong><p>원천, 배분, 상담, 검수, 납품, AS, 계약, 정산 상태와 고객사별 유효 조건을 문서화합니다.</p></div>
                    <div class="steps__item"><strong>개인정보·통화 데이터 기준 점검</strong><p>수집·제공·마케팅 이용, 녹취와 분석에 필요한 고지·동의, 보유기간과 파기 기준을 확인합니다.</p></div>
                    <div class="steps__item"><strong>사용자 권한 설정</strong><p>관리자·상담원·영업·정산 담당자가 볼 수 있는 정보와 수정·다운로드 범위를 최소화합니다.</p></div>
                    <div class="steps__item"><strong>일부 업무부터 검증</strong><p>전체 센터를 한 번에 옮기기보다 한 원천·한 팀·한 고객사 흐름에서 누락과 예외를 확인합니다.</p></div>
                </div>
            </div>
        </section>

        {{-- ⑥ 제공 범위·준법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb" id="governance">
            <div class="landing__inner">
                <span class="landing__eyebrow">AI & Data Governance</span>
                <h2 class="landing__head">AI가 판단을 대신하지 않고, CRM이 동의를 대신하지 않습니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>AI 분석을 사용할 때</h3>
                        <ul>
                            <li>분석 항목과 한계, 오류 가능성을 관리자에게 안내합니다.</li>
                            <li>낮은 점수만으로 상담 품질이나 직원을 확정 평가하지 않습니다.</li>
                            <li>필요한 통화 원자료와 상담 맥락을 사람이 함께 확인합니다.</li>
                            <li>모델 결과를 코칭·검수의 보조 정보로 사용합니다.</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>개인정보·통화 데이터를 다룰 때</h3>
                        <ul>
                            <li>DB의 수집 출처와 제공·이용 동의 범위를 확인합니다.</li>
                            <li>녹취·보관·분석에 필요한 고지와 내부 기준을 갖춥니다.</li>
                            <li>최소 권한, 접속 이력, 퇴사자 차단과 보유·파기를 운영합니다.</li>
                            <li>고객사 납품 시 목적을 벗어난 재사용과 무단 재제공을 막습니다.</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">적용 기준은 통화 방식, 정보 항목, 거래 구조, 고객사와 조직에 따라 달라질 수 있습니다. 실제 도입 전 담당 준법·개인정보 책임자 또는 필요한 전문 검토를 거치세요.</p>
            </div>
        </section>

        {{-- ⑦ 적합성 [라이트] --}}
        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">Fit Check</span>
                <h2 class="landing__head">보험DB를 생산·납품하는 운영조직에 맞습니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>콜투세일을 검토할 경우</h3>
                        <ul>
                            <li>여러 원천과 상담원의 배분·진행 상태를 관리할 때</li>
                            <li>상담 품질 검토와 관리자 코칭 기준을 정리할 때</li>
                            <li>고객사별 수주·납품·AS·정산 이력이 흩어져 있을 때</li>
                            <li>통화·개인정보의 권한과 보유 기준을 운영할 준비가 됐을 때</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>먼저 기준을 정리할 경우</h3>
                        <ul>
                            <li>원천 DB의 수집·제공·이용 근거를 확인할 수 없을 때</li>
                            <li>AI 점수만으로 직원 평가나 납품 결정을 자동 확정하려 할 때</li>
                            <li>시스템 도입만으로 생산량·매출·정산 정확도를 보장받고 싶을 때</li>
                            <li>DB를 구매해 영업하는 수요 조직의 상담 관리가 중심일 때</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        {{-- ⑧ 연결 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Two-sided Operations</span>
                <h2 class="landing__head">사는 쪽과 파는 쪽은 다른 CRM이 필요합니다</h2>
                <p class="landing__lead">콜투세일은 보험DB 콜센터의 공급 운영을 다룹니다. DB를 구매해 설계사에게 배분하고 계약까지 관리하는 조직은 리드베이를, 새로운 DB 유입 설계가 필요한 조직은 보험 CPA 마케팅을 확인하세요.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.leadbay') }}"><strong>리드베이 (수요 운영)</strong><p>보험DB 구매·배분·상담·계약·AS·정산 흐름을 관리합니다.</p><span>보험 영업 CRM 보기 →</span></a>
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'insurance']) }}"><strong>보험 CPA 마케팅</strong><p>캠페인의 유입 조건과 유효 DB 기준을 설계합니다.</p><span>DB 유입 설계 보기 →</span></a>
                </div>
            </div>
        </section>

        {{-- ⑨ FAQ [라이트] --}}
        <section class="landing__section landing__section--light" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">도입 전에 자주 묻는 질문</h2>
                <div class="faq">
                    <details class="faq__item"><summary>콜투세일은 어떤 조직을 위한 서비스인가요?</summary><p>원천 DB를 상담원에게 배분해 보험DB를 생산하고 고객사에 수주·납품·AS·정산하는 콜센터 운영조직을 위한 CRM입니다.</p></details>
                    <details class="faq__item"><summary>AI 콜 품질 분석이 상담을 정확히 평가하나요?</summary><p>정확성을 보장하지 않습니다. 분석은 패턴과 검토 지점을 찾는 보조 정보이며 관리자 또는 검수자가 통화 원자료와 상담 맥락을 함께 확인해야 합니다.</p></details>
                    <details class="faq__item"><summary>AI 점수로 인사평가를 자동화해도 되나요?</summary><p>AI 결과만으로 중요한 평가를 확정하는 방식은 오류와 맥락 누락 위험이 있습니다. 평가 기준을 공개하고 사람이 원자료를 검토하는 절차를 두어야 합니다.</p></details>
                    <details class="faq__item"><summary>녹취와 AI 분석은 별도 동의가 필요 없나요?</summary><p>그렇게 단정할 수 없습니다. 통화 방식과 데이터 처리 구조에 맞는 고지·동의, 이용 목적, 접근 권한, 보유·파기 기준을 실제 운영 전에 확인해야 합니다.</p></details>
                    <details class="faq__item"><summary>콜투세일이 DB의 적법성을 보장하나요?</summary><p>보장하지 않습니다. 원천 DB의 수집·제공·마케팅 이용 근거와 고객사 납품 조건은 운영·거래 당사자가 직접 확인해야 합니다.</p></details>
                    <details class="faq__item"><summary>전자계약과 정산은 모두 자동 처리되나요?</summary><p>세부 자동화와 연동 범위는 현재 서비스와 계약 조건에 따라 달라질 수 있습니다. 실제 화면과 지원 범위를 확인한 뒤 기존 업무와의 차이를 점검하세요.</p></details>
                    <details class="faq__item"><summary>기능과 이용 조건은 어디서 최종 확인하나요?</summary><p>이 페이지는 소개용입니다. 실제 기능, AI 분석 항목, 가격, 도입·연동 조건, 약관과 개인정보 처리 안내는 콜투세일의 최신 서비스가 우선합니다.</p></details>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">Make The Flow Auditable</span>
                <h2>콜센터 운영,<br>DB부터 정산까지 한 시스템으로</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">실제 서비스 범위와 AI·개인정보 처리 기준을 확인하고, 작은 운영 단위부터 도입을 검토하세요.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://call2.sale" target="_blank" rel="noopener">콜투세일 바로가기 →</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">도입 상담</a>
                </div>
            </div>
        </section>
    </main>
@endsection
