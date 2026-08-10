@extends('layouts.app')

@section('title', '부스팅샵 — 필요한 것만 골라 담는 셀프 마케팅 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="풀 대행은 부담스럽고 혼자는 막막할 때. SEO 캠페인 구성과 인스타그램 콘텐츠·광고·협업 기반 성장 가이드를 한곳에서 비교하는 셀프 마케팅 허브, 부스팅샵.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero landing__hero--media">
            <div class="landing__hero-inner">
                <div class="landing__hero-copy">
                <nav class="subpage__breadcrumb" aria-label="상위"><a href="{{ route('solutions.index') }}">솔루션</a></nav>
                <span class="landing__eyebrow">BoostingShop</span>
                <h1>필요한 것만 골라 담는 셀프 마케팅</h1>
                <p class="landing__lead">풀 대행은 부담스럽고, 혼자는 막막할 때.
                   SEO 캠페인 구성과 인스타그램의 정책 친화적 성장 경로를 확인하고 필요한 항목부터 검토하세요.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="#products">구성 보기</a>
                    <a class="btn-ghost" href="#policy">구매 전 확인사항</a>
                </div>
                </div>
                <figure class="landing__hero-figure">@include('partials.scene', ['name' => 'boostingshop'])</figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="부스팅샵 페이지 바로가기">
            <div class="landing__local-nav-inner">
                <a href="#overview">서비스 정의</a>
                <a href="#problem">문제</a>
                <a href="#choose">선택 기준</a>
                <a href="#products">구성</a>
                <a href="#process">이용 절차</a>
                <a href="#policy">정책·제공 범위</a>
                <a href="#fit">적합성</a>
                <a href="#faq">FAQ</a>
            </div>
        </nav>

        {{-- ① 정의 [라이트] --}}
        <section class="landing__section landing__section--light" id="overview">
            <div class="landing__inner">
                <span class="landing__eyebrow">Self-service Marketing Hub</span>
                <h2 class="landing__head">전략 전체가 아니라, 이미 정한 실행 항목부터</h2>
                <p class="landing__lead">부스팅샵은 SEO 캠페인 구성과 인스타그램 성장 가이드를 개별 페이지로 나눠 확인하는 셀프 마케팅 허브입니다. 검색 상품은 현재 구성·기간·가격을 비교하고, 인스타그램은 수량 판매가 아닌 콘텐츠·공식 광고·협업 기반의 성장 경로를 검토합니다.</p>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>SEO 캠페인</h3>
                        <p>베이직·프로·엘리트 가운데 사이트 규모와 목표에 맞는 구성을 개별 상품 페이지에서 확인합니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>인스타그램 성장 가이드</h3>
                        <p>인기게시물·팔로워·좋아요 숫자를 목표처럼 보지 않고 콘텐츠, 공식 광고, 협업과 실제 고객 행동을 함께 검토합니다.</p>
                    </article>
                </div>
                <div class="landing__callout">셀프 마케팅은 싸게 사는 방식이 아니라, 내가 필요한 범위와 감당할 위험을 알고 선택하는 방식입니다.</div>
            </div>
        </section>

        {{-- ② 문제 [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="problem">
            <div class="landing__inner">
                <span class="landing__eyebrow">Before You Buy</span>
                <h2 class="landing__head">대행은 부담스럽지만, 이름만 보고 결정하기도 어렵습니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>내 목표가 아직 모호하다</h3>
                        <p>검색 유입, 사이트 기반 정비, 게시물 반응처럼 원하는 결과가 다르면 확인해야 할 실행 방식도 달라집니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>구성과 결과를 혼동한다</h3>
                        <p>제공 항목을 구매하는 것과 특정 순위·노출·매출을 보장받는 것은 같은 말이 아닙니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>플랫폼 정책을 놓친다</h3>
                        <p>인스타그램의 인위적 반응 수집은 플랫폼 정책과 계정 안전에 영향을 줄 수 있어 공개 서비스로 확정하기 전 운영 방식 검증이 필요합니다.</p>
                    </article>
                    <article class="landing__panel">
                        <h3>최신 조건을 확인하지 않는다</h3>
                        <p>SEO 가격·기간·구성은 달라질 수 있으므로 신청 직전 안내가 기준입니다. 인스타그램 가이드는 인위적 반응 수량을 판매하거나 접수하는 주문 안내가 아닙니다.</p>
                    </article>
                </div>
            </div>
        </section>

        {{-- ③ 선택 기준 [다크] --}}
        <section class="landing__section landing__section--dark has-orb" id="choose">
            <div class="landing__inner">
                <span class="landing__eyebrow">Choose By The Job</span>
                <h2 class="landing__head">패키지 이름보다, 지금 해결할 일을 먼저 고르세요</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>목표</strong><span>검색 기반을 만들 것인지, 경쟁 키워드 범위를 넓힐 것인지, 인스타그램에서 어떤 고객 행동을 키울 것인지 정합니다.</span></div>
                    <div class="landing__point"><strong>현재 상태</strong><span>사이트 연령과 콘텐츠, 기존 링크, 인스타그램 계정 상태와 운영 이력을 확인합니다.</span></div>
                    <div class="landing__point"><strong>실행 항목</strong><span>SEO는 작업·기간·준비물과 제외 범위를, 인스타그램은 콘텐츠·광고·협업 경로와 측정 지표를 읽습니다.</span></div>
                    <div class="landing__point"><strong>정책 위험</strong><span>검색엔진과 소셜 플랫폼 정책, 광고·협찬 표시, 계정 보안과 콘텐츠 권리를 함께 확인합니다.</span></div>
                    <div class="landing__point"><strong>판단 기준</strong><span>순위나 팔로워 숫자 하나보다 유입·문의·전환·계정 건전성을 어떻게 볼지 정합니다.</span></div>
                    <div class="landing__point"><strong>중단 조건</strong><span>예상 밖 변동이나 정책 경고가 생겼을 때 언제 멈추고 확인할지 정합니다.</span></div>
                </div>
            </div>
        </section>

        {{-- ④ 구성 [라이트] --}}
        {{-- 인스타 페이지는 인위적 반응 수량 상품이 아니라 정책 친화적 성장 가이드로만 노출한다. --}}
        <section class="landing__section landing__section--light" id="products">
            <div class="landing__inner">
                <span class="landing__eyebrow">Products</span>
                <h2 class="landing__head">SEO 상품과 인스타그램 성장 가이드</h2>
                <p class="landing__lead">SEO 캠페인은 베이직·프로·엘리트로 나뉘며 베이직 안내는 월 50만원부터입니다. 인스타그램 세 페이지는 인위적 반응 수량을 판매하지 않고 콘텐츠·공식 광고·협업을 통한 발견·팔로워·참여 개선 기준을 설명합니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'basic']) }}"><strong>SEO 캠페인 베이직</strong><p>소규모 사이트와 소수 키워드의 시작 단계를 위한 구성.</p><span>월 50만원부터 · 상세 확인 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'pro']) }}"><strong>SEO 캠페인 프로</strong><p>여러 키워드와 콘텐츠를 함께 관리하려는 성장 단계 구성.</p><span>현재 구성 확인 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'elite']) }}"><strong>SEO 캠페인 엘리트</strong><p>고경쟁 키워드와 다수 페이지를 함께 검토하는 상위 구성.</p><span>현재 구성 확인 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'instagram-popular']) }}"><strong>인스타 발견 전략</strong><p>노출 보장 대신 콘텐츠 관련성과 설명 가능한 유입 경로를 점검합니다.</p><span>발견 가이드 보기 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'instagram-followers']) }}"><strong>인스타 팔로워 성장</strong><p>수량 구매 대신 프로필·콘텐츠·공식 광고·협업 경로를 점검합니다.</p><span>성장 가이드 보기 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop.sub', ['sub' => 'instagram-likes']) }}"><strong>인스타 콘텐츠 참여</strong><p>좋아요 납품 대신 실제 저장·공유·방문으로 이어지는 반응 구조를 점검합니다.</p><span>참여 가이드 보기 →</span></a>
                </div>
                <p class="landing__note">특정 검색 순위, 인기게시물 진입, 팔로워·좋아요 수량 또는 매출 성과를 보장하지 않습니다. 인스타그램 가이드는 인위적 반응 판매를 접수하는 상품 페이지가 아닙니다.</p>
            </div>
        </section>

        {{-- ⑤ 사용 절차 [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="process">
            <div class="landing__inner">
                <span class="landing__eyebrow">Review Before Order</span>
                <h2 class="landing__head">바로 결제하기 전에 다섯 가지를 확인하세요</h2>
                <div class="steps">
                    <div class="steps__item"><strong>목표와 기준 정리</strong><p>원하는 작업, 대상 사이트·계정, 운영 기간과 결과를 판단할 지표를 적습니다.</p></div>
                    <div class="steps__item"><strong>상세 페이지 확인</strong><p>현재 구성, 가격, 기간, 필요한 자료, 제외 범위와 이용 조건을 읽습니다.</p></div>
                    <div class="steps__item"><strong>정책·계정 위험 점검</strong><p>검색엔진 또는 인스타그램의 최신 정책, 계정 상태, 콘텐츠 권리와 광고·협찬 표시 필요성을 확인합니다.</p></div>
                    <div class="steps__item"><strong>불명확한 조건 문의</strong><p>SEO 제공 방식, 변경·취소·환불과 인스타그램의 실행 경로·계정 접근 여부처럼 확인되지 않는 항목은 신청 전에 문의합니다.</p></div>
                    <div class="steps__item"><strong>진행 중 직접 관찰</strong><p>약속된 제공 항목과 함께 유입·문의·전환, 계정 경고와 비정상 변동을 보고 지속 여부를 판단합니다.</p></div>
                </div>
            </div>
        </section>

        {{-- ⑥ 제공 범위·정책 [다크] --}}
        <section class="landing__section landing__section--dark has-orb" id="policy">
            <div class="landing__inner">
                <span class="landing__eyebrow">Policy & Boundaries</span>
                <h2 class="landing__head">제공 항목과 플랫폼의 판단은 별개입니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>SEO 상품 확인사항</h3>
                        <ul>
                            <li>구매 대상은 상세 페이지에 명시된 작업 범위입니다.</li>
                            <li>검색엔진의 색인·평가·순위는 외부에서 확정할 수 없습니다.</li>
                            <li>과도하거나 부자연스러운 작업은 검색 품질 정책상 위험이 될 수 있습니다.</li>
                            <li>기존 사이트 상태와 콘텐츠 품질에 따라 결과가 달라질 수 있습니다.</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>인스타그램 성장 방식 확인사항</h3>
                        <ul>
                            <li>콘텐츠·광고·협업의 실행 방식이 인스타그램의 현재 약관과 정책에 맞는지 확인해야 합니다.</li>
                            <li>노출·반응·유지 기간과 계정 안전을 보장한다고 해석하면 안 됩니다.</li>
                            <li>광고·협찬 관계가 있는 콘텐츠는 필요한 표시 기준을 별도로 확인해야 합니다.</li>
                            <li>비밀번호·인증코드 등 민감한 계정 정보의 제공 여부와 보안 방식을 사전에 확인해야 합니다.</li>
                        </ul>
                    </article>
                </div>
                <p class="landing__note">플랫폼 정책은 변경될 수 있고, 동일한 작업도 계정·콘텐츠·지역·시점에 따라 판단이 달라질 수 있습니다. 최신 공식 정책과 실제 계약·이용 조건을 우선하세요.</p>
            </div>
        </section>

        {{-- ⑦ 적합성 [라이트] --}}
        <section class="landing__section landing__section--light" id="fit">
            <div class="landing__inner">
                <span class="landing__eyebrow">Fit Check</span>
                <h2 class="landing__head">필요한 작업이 분명할수록 셀프 상품이 잘 맞습니다</h2>
                <div class="landing__split">
                    <article class="landing__panel">
                        <h3>부스팅샵부터 볼 경우</h3>
                        <ul>
                            <li>진행하려는 상품과 예산 범위가 이미 정해져 있을 때</li>
                            <li>상세 페이지의 구성과 위험을 직접 비교할 수 있을 때</li>
                            <li>진행 전후 데이터를 스스로 확인할 수 있을 때</li>
                            <li>작은 범위부터 시험하고 판단하려 할 때</li>
                        </ul>
                    </article>
                    <article class="landing__panel">
                        <h3>상담부터 필요한 경우</h3>
                        <ul>
                            <li>SEO와 광고 중 무엇이 필요한지 아직 모를 때</li>
                            <li>사이트 기술·콘텐츠 문제까지 함께 고쳐야 할 때</li>
                            <li>인스타그램 계정에 경고·제한·보안 이슈가 있을 때</li>
                            <li>특정 순위·노출·매출을 반드시 보장받아야 할 때</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        {{-- ⑧ FAQ [파치먼트] --}}
        <section class="landing__section landing__section--parchment" id="faq">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">상품을 선택하기 전에 자주 묻는 질문</h2>
                <div class="faq">
                    <details class="faq__item"><summary>SEO 상품을 구매하면 상위 노출이 보장되나요?</summary><p>보장되지 않습니다. 검색 결과는 검색엔진이 여러 신호와 정책에 따라 결정합니다. 구매 전 제공 작업과 기간, 제외 범위를 기준으로 판단하세요.</p></details>
                    <details class="faq__item"><summary>베이직·프로·엘리트 중 무엇을 골라야 하나요?</summary><p>사이트 규모, 운영 기간, 대상 키워드 수와 경쟁도, 현재 콘텐츠와 링크 상태를 함께 봐야 합니다. 이름만으로 고르지 말고 각 상세 페이지의 구성을 비교하세요.</p></details>
                    <details class="faq__item"><summary>인스타그램 성장 가이드는 계정에 안전한가요?</summary><p>어떤 실행도 일률적인 안전을 보장할 수 없습니다. 콘텐츠·공식 광고·협업 방식, 계정 상태와 최신 약관·정책을 확인하고 필요한 최소 권한만 사용해야 합니다.</p></details>
                    <details class="faq__item"><summary>인기게시물 노출이나 반응 수치를 보장하나요?</summary><p>보장하지 않습니다. 플랫폼이 최종 노출을 결정하며 인스타그램 세부 페이지도 인위적 반응 수량이나 노출 위치를 판매하는 주문 페이지가 아닙니다.</p></details>
                    <details class="faq__item"><summary>상품 가격과 구성은 항상 같은가요?</summary><p>변경될 수 있습니다. 이 허브의 요약보다 신청 시점의 상세 페이지에 표시된 최신 가격·기간·구성·이용 조건이 우선합니다.</p></details>
                    <details class="faq__item"><summary>취소와 환불 기준은 어디서 확인하나요?</summary><p>각 상품의 현재 이용 조건과 신청·결제 과정에서 확인해야 합니다. 불명확한 경우 결제 전에 문의해 적용 기준을 확인하세요.</p></details>
                    <details class="faq__item"><summary>무엇을 사야 할지 모르겠으면 어떻게 하나요?</summary><p>현재 사이트나 계정, 목표, 예산 범위와 가장 답답한 지점을 알려주세요. 상품 구매가 맞는지, 먼저 진단이나 대행 상담이 필요한지부터 나눠볼 수 있습니다.</p></details>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <span class="landing__eyebrow">Buy With Context</span>
                <h2>예산에 맞게,<br>필요한 것부터</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">SEO는 제공 범위를, 인스타그램은 정책 친화적 성장 경로와 계정 위험을 먼저 확인하세요.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="#products">구성 다시 보기</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">상담 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
