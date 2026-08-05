@extends('layouts.app')

@section('title', '퍼포먼스 마케팅 대행 — 광고비의 성적표 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="373억을 집행하며 배운 것: 감으로 배분한 예산은 반드시 샙니다. 노출·클릭이 아니라 ROAS로, 주 단위 리밸런싱으로 광고비의 성적표를 만듭니다.">
    @verbatim
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {"@type":"Question","name":"광고비가 적어도 되나요?","acceptedAnswer":{"@type":"Answer","text":"월 예산 규모보다 전환 데이터가 쌓이는 속도가 중요합니다. 예산이 작으면 테스트 설계를 다르게 합니다. 상담 때 예산부터 말씀해 주세요. 그에 맞는 판을 짭니다."}},
        {"@type":"Question","name":"기존 대행사에서 옮기면 뭐가 달라지나요?","acceptedAnswer":{"@type":"Answer","text":"인수인계 첫 주에 계정 구조 진단부터 합니다. 대부분 여기서 새는 구멍이 나옵니다. 진단 결과는 옮기지 않으셔도 드립니다."}},
        {"@type":"Question","name":"리포트는 어떻게 받나요?","acceptedAnswer":{"@type":"Answer","text":"주간 단위로, 노출·클릭이 아니라 전환·ROAS 중심으로 받습니다. 나쁜 숫자도 그대로 보냅니다."}}
      ]
    }
    </script>
    @endverbatim
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] — 숫자부터 던진다 --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Performance Marketing</span>
                <h1>광고비의 성적표를 만들어 드립니다</h1>
                <p class="landing__lead">373억. 저희가 지금까지 집행한 광고비입니다.
                   이 돈이 가르쳐준 건 하나였습니다 — 감으로 배분한 예산은 반드시 샙니다.</p>
                {{-- ① 숫자 스트립 (문제보다 먼저) [검증 V2] 회사 전체 누적 --}}
                <div class="detail__metrics">
                    <div class="detail__metric"><strong>373억+</strong><span>누적 집행 광고비 (회사 전체)</span></div>
                    <div class="detail__metric"><strong>15,700+</strong><span>캠페인 수</span></div>
                    <div class="detail__metric"><strong>주 단위</strong><span>예산 리밸런싱 주기</span></div>
                </div>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">내 광고 성적 진단받기</a>
                </div>
            </div>
        </section>

        {{-- ② 문제 — 시나리오 서술형 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">리포트는 화려한데, 통장은 조용한 이유</h2>
                <div class="prose">
                    <p>월말 리포트를 열어봅니다. 노출 300만, 클릭 4만, CTR 양호. 그런데 이상하죠. 매출은 그대로입니다.</p>
                    <p>이유는 단순합니다. 그 리포트에 ‘매출’이 없기 때문입니다. 노출과 클릭은 광고회사의 성적이지, 사장님의 성적이 아닙니다.</p>
                    <p>저희는 처음부터 다른 숫자를 봅니다. 광고비 1원이 매출 몇 원이 됐는가 — ROAS. 그거 하나만 봅니다.</p>
                </div>
            </div>
        </section>

        {{-- ③ 방법 — 프로세스 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method</span>
                <h2 class="landing__head">예산이 새는 곳을 찾고, 이기는 곳으로 옮깁니다</h2>
                <div class="steps">
                    <div class="steps__item">
                        <strong>전환 정의부터 다시 합니다</strong>
                        <p>“우리한테 성과란 무엇인가”를 먼저 합의합니다. 매출인지, 가입인지, 상담신청인지. 이게 정해져야 나머지 전부가 의미를 갖습니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>매체를 한 판 위에 올립니다</strong>
                        <p>메타·구글·네이버·유튜브 성과를 한 대시보드에서 봅니다. 같은 전환을 두 매체가 서로 자기 성과라고 우기는 중복 귀속부터 걷어냅니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>주 단위로 예산을 옮깁니다</strong>
                        <p>지는 소재는 끕니다. 이기는 소재에 몰아줍니다. 광고비가 낭비되는 최대 원인은 나쁜 광고를 한 달 내내 튼 것이거든요.</p>
                    </div>
                    <div class="steps__item">
                        <strong>소재는 사내에서 만듭니다</strong>
                        <p>촬영·편집·디자인 내재화. 외주 대기 없이 이번 주 데이터로 다음 주 소재를 만듭니다.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ④ FAQ [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">자주 묻는 것들</h2>
                <div class="faq">
                    <details class="faq__item">
                        <summary>광고비가 적어도 되나요?</summary>
                        <p>월 예산 규모보다 ‘전환 데이터가 쌓이는 속도’가 중요합니다. 예산이 작으면 테스트 설계를 다르게 합니다. 상담 때 예산부터 말씀해 주세요. 그에 맞는 판을 짭니다.</p>
                    </details>
                    <details class="faq__item">
                        <summary>기존 대행사에서 옮기면 뭐가 달라지나요?</summary>
                        <p>인수인계 첫 주에 계정 구조 진단부터 합니다. 대부분 여기서 새는 구멍이 나옵니다. 진단 결과는 옮기지 않으셔도 드립니다.</p>
                    </details>
                    <details class="faq__item">
                        <summary>리포트는 어떻게 받나요?</summary>
                        <p>주간 단위. 노출·클릭이 아니라 전환·ROAS 중심으로. 나쁜 숫자도 그대로 보냅니다.</p>
                    </details>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>지금 광고, 성적표부터 만들어 보세요</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">계정 열어주시면 어디서 새는지 짚어드립니다. 옮기지 않으셔도 진단 결과는 드립니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">성과 진단 요청</a>
                </div>
            </div>
        </section>
    </main>
@endsection
