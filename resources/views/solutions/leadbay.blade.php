@extends('layouts.app')

@section('title', '리드베이 — 보험DB, 사는 순간부터 계약까지 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="보험DB 업체를 품질 점수·납품 속도·AS 정보로 비교하고, 상담 배분에서 계약·AS·정산까지 관리하는 보험 영업조직용 세일즈 CRM 리드베이.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero landing__hero--media">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                <nav class="subpage__breadcrumb" aria-label="상위"><a href="{{ route('solutions.index') }}">솔루션</a></nav>
                <span class="landing__eyebrow">LEADBAY</span>
                <h1>보험DB, 사는 순간부터 계약까지 한 흐름으로</h1>
                <p class="landing__lead">서비스에 표시된 DB 업체를 품질 점수·납품 속도·AS 정보로 비교하고,
                   구입한 DB의 상담 배분에서 계약·AS·정산까지 관리합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://leadbay.co.kr" target="_blank" rel="noopener">리드베이 바로가기 →</a>
                    <a class="btn-ghost" href="#compliance">개인정보 확인사항</a>
                </div>
                <p class="landing__note">품질 점수와 업체 정보는 비교를 돕는 서비스 내 정보이며 개별 DB의 적법성, 상담 연결, 계약 체결 또는 영업 성과를 보장하지 않습니다.</p>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'leadbay'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="리드베이 페이지 바로가기">
            <div class="landing__local-nav-inner">
                <a href="#overview">서비스 정의</a>
                <a href="#problem">문제</a>
                <a href="#features">기능</a>
                <a href="#workflow">업무 흐름</a>
                <a href="#onboarding">도입·사용</a>
                <a href="#compliance">제공 범위·준법</a>
                <a href="#fit">적합성</a>
                <a href="#faq">FAQ</a>
            </div>
        </nav>

        {{-- ① 정의 [라이트] --}}
        <section class="landing__section landing__section--light" id="overview">
            <div class="landing__inner">
                <span class="landing__eyebrow">CRM For The Buying Side</span>
                <h2 class="landing__head">DB 구매 화면과 영업 관리 화면을 이어놓은 CRM</h2>
                <p class="landing__lead">리드베이는 보험DB를 활용하는 영업조직을 위한 서비스입니다. 업체와 조건을 비교하는 단계부터 담당자 배분, 상담 진행, 계약·AS·정산 상태를 한 업무 흐름에서 관리합니다.</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>비교와 구매</h3>
                        <p>업체별로 표시된 품질 점수, 납품 속도, AS 정책과 거래 조건을 확인해 구매 판단에 참고합니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>배분과 후속 관리</h3>
                        <p>구입한 DB가 어느 담당자에게 배분됐고 상담·계약·AS·정산이 어느 상태인지 이어서 관리합니다.</p>
                    </article>
                </div>
                <div class="landing__callout">DB를 확보하는 것보다 중요한 건, 누가 어떤 근거로 연락하고 결과와 이슈를 어떻게 남기는가입니다.</div>
            </div>
        </section>

        {{-- ② 문제 [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="problem">
            <div class="landing__inner">
                <span class="landing__eyebrow">Where Leads Leak</span>
                <h2 class="landing__head">영업조직이 매일 겪는 그 일들</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>구매 근거가 흩어진다</h3>
                        <p>업체 정보와 가격, 납품·AS 조건이 메신저와 문서에 나뉘면 비교와 재구매 판단이 사람의 기억에 의존합니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>상담 배분이 엑셀에 멈춘다</h3>
                        <p>중복 배분, 담당자 누락, 상태 미입력은 리드가 실제 영업으로 넘어가는 과정에서 확인 공수를 키웁니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>AS 근거를 찾기 어렵다</h3>
                        <p>연락 불가나 정보 이슈가 생겼을 때 구매 조건과 상담 이력이 이어지지 않으면 처리 기준을 맞추기 어렵습니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>계약과 정산이 따로 논다</h3>
                        <p>상담 결과와 계약·AS·정산 상태가 다른 자료에 있으면 조직별 성과와 비용을 같은 기준으로 보기 어렵습니다.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- ③ 기능 [다크] --}}
        <section class="landing__section landing__section--dark has-orb" id="features">
            <div class="landing__inner">
                <span class="landing__eyebrow">Core Workflow</span>
                <h2 class="landing__head">사는 순간부터 계약까지, 상태를 이어서 봅니다</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>보험DB 마켓</strong><span>서비스에 표시된 업체별 품질 점수·납품 속도·AS 정보와 거래 조건을 비교합니다.</span></div>
                    <div class="landing__point"><strong>구매·납품 확인</strong><span>구매한 DB와 납품 상태를 확인하고 이후 상담 업무로 연결합니다.</span></div>
                    <div class="landing__point"><strong>상담 배분</strong><span>조직 내 담당자에게 DB를 배분하고 담당 관계를 기록합니다.</span></div>
                    <div class="landing__point"><strong>상담 상태 관리</strong><span>진행 상태와 후속 조치가 어디까지 왔는지 업무 흐름 안에서 확인합니다.</span></div>
                    <div class="landing__point"><strong>계약·AS 관리</strong><span>상담 이후 계약과 사후 처리 상태를 앞선 이력과 연결해 관리합니다.</span></div>
                    <div class="landing__point"><strong>정산 흐름</strong><span>구매·상담·계약·AS 관련 기록을 바탕으로 조직의 정산 업무를 관리합니다.</span></div>
                </div>
                <p class="landing__note">실제 화면, 입력 항목, 권한, 거래·정산 기능의 세부 범위는 리드베이의 현재 서비스와 이용 조건을 확인해야 합니다.</p>
            </div>
        </section>

        {{-- ④ 활용 흐름 [라이트] --}}
        <section class="landing__section landing__section--light" id="workflow">
            <div class="landing__inner">
                <span class="landing__eyebrow">Lead To Contract</span>
                <h2 class="landing__head">한 건의 DB가 조직 안에서 이동하는 순서</h2>
                <div class="steps">
                    <div class="steps__item"><strong>업체와 조건 비교</strong><p>품질 점수·납품 속도·AS 정보뿐 아니라 수집·제공 근거, 사용 목적과 거래 조건을 확인합니다.</p></div>
                    <div class="steps__item"><strong>구매·납품 상태 확인</strong><p>구매한 DB가 어떤 조건으로 들어왔는지 확인하고 내부 관리 기준에 맞게 분류합니다.</p></div>
                    <div class="steps__item"><strong>담당자 배분</strong><p>조직·팀·담당자 기준에 따라 배분하고 중복 연락과 무단 재배포를 막을 운영 권한을 정합니다.</p></div>
                    <div class="steps__item"><strong>상담 결과 기록</strong><p>연락·상담·후속 일정과 정보 이슈를 같은 상태 기준으로 남깁니다.</p></div>
                    <div class="steps__item"><strong>계약·AS·정산 연결</strong><p>계약 여부와 사후 처리, 비용·정산 상태를 앞선 구매·상담 기록과 함께 확인합니다.</p></div>
                </div>
            </div>
        </section>

        {{-- ⑤ 도입·사용 절차 [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="onboarding">
            <div class="landing__inner">
                <span class="landing__eyebrow">Before Adoption</span>
                <h2 class="landing__head">화면을 옮기기 전에 운영 기준부터 맞추세요</h2>
                <div class="steps">
                    <div class="steps__item"><strong>조직과 이용 조건 확인</strong><p>리드베이에서 현재 가입·이용 대상, 계정과 조직 설정, 요금·거래 조건을 확인합니다.</p></div>
                    <div class="steps__item"><strong>개인정보 처리 기준 점검</strong><p>DB의 수집 출처, 동의 내용, 제공·이용 목적, 보유·파기와 마케팅 연락 범위를 조직 기준과 대조합니다.</p></div>
                    <div class="steps__item"><strong>상담 상태 정의</strong><p>신규, 배분, 연락, 상담, 후속, 계약, AS 등 팀이 실제 사용하는 상태와 입력 책임자를 정합니다.</p></div>
                    <div class="steps__item"><strong>권한과 배분 규칙 설정</strong><p>누가 DB를 보고 배분·수정·다운로드할 수 있는지, 이력과 퇴사자 권한을 어떻게 관리할지 정합니다.</p></div>
                    <div class="steps__item"><strong>일부 팀부터 운영 확인</strong><p>전체 조직을 한 번에 옮기기보다 작은 범위에서 누락·중복·상태 입력과 AS 흐름을 확인합니다.</p></div>
                </div>
            </div>
        </section>

        {{-- ⑥ 제공 범위·준법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb" id="compliance">
            <div class="landing__inner">
                <span class="landing__eyebrow">Compliance Boundary</span>
                <h2 class="landing__head">CRM은 기록을 돕지만, 적법한 DB를 대신 만들어주지 않습니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>거래 전에 확인할 것</h3>
                        <ul>
                            <li>정보가 어떤 경로와 시점에 수집됐는지</li>
                            <li>보험 상담과 마케팅 연락에 필요한 동의가 있는지</li>
                            <li>제3자 제공 대상·목적·항목과 보유기간이 맞는지</li>
                            <li>업체의 AS·교환·분쟁 처리 조건이 무엇인지</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>조직 안에서 지킬 것</h3>
                        <ul>
                            <li>필요한 사람에게만 열리는 최소 권한</li>
                            <li>목적을 벗어난 재사용·재판매·무단 전달 방지</li>
                            <li>연락 거부·철회와 정보 정정 요청 처리</li>
                            <li>보유기간 종료와 퇴사자 계정의 접근 차단</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">적용되는 법령·계약·보험사 또는 GA 내부 기준은 거래와 조직 구조에 따라 달라질 수 있습니다. 실제 운영 전 담당 준법·개인정보 책임자 또는 필요한 전문 검토를 거치세요.</p>
            </div>
        </section>

        {{-- ⑦ 적합성 [라이트] --}}
        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">Fit Check</span>
                <h2 class="landing__head">보험 영업조직의 운영 도구가 필요할 때</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>리드베이를 검토할 조직</h3>
                        <ul>
                            <li>여러 업체와 DB 거래 조건을 비교·관리하는 영업조직</li>
                            <li>DB 배분과 상담 상태를 엑셀·메신저로 관리하는 팀</li>
                            <li>계약·AS·정산 이력을 구매·상담 기록과 잇고 싶은 조직</li>
                            <li>권한·동의·보유·파기 기준을 내부에서 운영할 준비가 된 조직</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>먼저 기준을 정리할 조직</h3>
                        <ul>
                            <li>DB의 수집 출처와 동의 범위를 확인할 수 없을 때</li>
                            <li>보험 상담 외 목적으로 정보를 자유롭게 재사용하려 할 때</li>
                            <li>CRM 도입만으로 계약률 상승을 보장받고 싶을 때</li>
                            <li>콜센터에서 DB를 생산·납품하는 공급 업무가 중심일 때</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        {{-- ⑧ 연결 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Connected Workflow</span>
                <h2 class="landing__head">DB 유입과 공급 흐름까지 함께 살펴보세요</h2>
                <p class="landing__lead">리드베이는 DB를 활용하는 영업조직의 관리 흐름을 다룹니다. DB 유입 설계가 필요하면 보험 CPA 마케팅을, DB를 생산·납품하는 콜센터라면 콜투세일을 확인하세요.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.cpa.sub', ['sub' => 'insurance']) }}"><strong>보험 CPA 마케팅</strong><p>유입 조건과 유효 DB 기준을 먼저 설계합니다.</p><span>DB 유입 설계 보기 →</span></a>
                    <a class="subcard" href="{{ route('solutions.call2sale') }}"><strong>콜투세일 (공급 운영)</strong><p>보험DB 콜센터의 생산·상담·납품·정산 흐름을 관리합니다.</p><span>콜센터 CRM 보기 →</span></a>
                </div>
            </div>
        </section>

        {{-- ⑨ FAQ [라이트] --}}
        <section class="landing__section landing__section--light" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">도입 전에 자주 묻는 질문</h2>
                <div class="faq">
                    <details class="faq__item"><summary>리드베이는 어떤 조직을 위한 서비스인가요?</summary><p>보험DB를 비교·구매하고 조직 내 담당자에게 배분해 상담·계약·AS·정산 상태를 관리하는 영업조직, 설계사와 대리점을 위한 CRM입니다.</p></details>
                    <details class="faq__item"><summary>품질 점수가 높으면 계약 가능성도 높나요?</summary><p>그렇게 보장되지 않습니다. 점수는 서비스 내 비교 정보이며 실제 상담 연결과 계약은 DB의 적법성·시점·대상, 담당자의 상담과 시장 상황 등 여러 요인의 영향을 받습니다.</p></details>
                    <details class="faq__item"><summary>입점 업체라는 이유만으로 DB의 적법성이 보장되나요?</summary><p>보장되지 않습니다. 구매자는 거래 전에 수집 출처, 동의 범위, 제공·이용 목적, 보유기간과 AS 조건을 확인해야 합니다.</p></details>
                    <details class="faq__item"><summary>리드베이가 개인정보 준법 책임을 대신하나요?</summary><p>아닙니다. 서비스는 관리 흐름을 돕지만 거래·이용 주체의 법적·계약상 책임을 대신하지 않습니다. 조직의 기준과 필요한 전문 검토가 별도로 필요합니다.</p></details>
                    <details class="faq__item"><summary>DB를 구매하면 상담이나 계약이 보장되나요?</summary><p>보장되지 않습니다. 연락 가능 여부, 상담 의향, 정보의 시의성, 배분과 상담 품질에 따라 결과가 달라질 수 있습니다.</p></details>
                    <details class="faq__item"><summary>AS와 정산 기준은 모두 같나요?</summary><p>업체, 상품, 거래 조건에 따라 다를 수 있습니다. 구매 전에 적용 기준과 필요한 증빙, 처리 기간을 실제 서비스에서 확인하세요.</p></details>
                    <details class="faq__item"><summary>기능과 이용 조건은 어디서 최종 확인하나요?</summary><p>이 페이지는 소개용입니다. 실제 화면, 가격, 권한, 거래·정산 기능, 약관과 개인정보 처리 안내는 리드베이의 최신 서비스가 우선합니다.</p></details>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">Use Leads Responsibly</span>
                <h2>보험 영업, DB부터 계약까지 한 흐름으로</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">실제 서비스의 최신 기능과 거래 조건을 확인하고, 개인정보 처리 기준을 먼저 갖춘 뒤 도입하세요.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://leadbay.co.kr" target="_blank" rel="noopener">리드베이 바로가기 →</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">도입 상담</a>
                </div>
            </div>
        </section>
    </main>
@endsection
