@extends('layouts.app')

@php
    $faqs = [
        [
            'question' => 'SEO는 얼마나 걸리나요?',
            'answer' => '사이트의 기술 상태, 경쟁도, 기존 콘텐츠와 검색엔진의 수집 주기에 따라 달라집니다. 고정 기간이나 특정 순위 시점을 보장하지 않으며, 색인·노출·클릭·전환의 선행 지표부터 확인합니다.',
        ],
        [
            'question' => '검색광고와 SEO는 무엇이 다른가요?',
            'answer' => '검색광고는 비용을 지불해 즉시 노출을 확보하고, SEO는 검색엔진이 발견·이해할 수 있는 사이트와 콘텐츠 자산을 축적합니다. 역할이 다르므로 사업 목표에 따라 함께 운영할 수 있습니다.',
        ],
        [
            'question' => '백링크만 늘리면 순위가 오르나요?',
            'answer' => '링크만으로 해결되지 않습니다. 크롤링과 색인, 검색의도에 맞는 콘텐츠, 내부 링크, 출처의 관련성과 품질을 함께 봐야 합니다. 특정 링크 수나 순위 상승을 보장하지 않습니다.',
        ],
        [
            'question' => 'AEO와 GEO를 하면 AI 답변에 반드시 나오나요?',
            'answer' => '아닙니다. 정보 접근성, 엔티티의 명확성, 근거와 출처의 일관성을 개선해 답변 시스템이 참고할 가능성을 높이는 작업입니다. 최종 노출과 인용은 각 검색·생성 시스템이 결정합니다.',
        ],
        [
            'question' => '기존 사이트를 유지한 채 진행할 수 있나요?',
            'answer' => '가능합니다. 먼저 현재 URL과 검색 유입, 기술 문제, 콘텐츠 자산을 진단해 유지할 부분과 수정할 부분을 구분합니다. 전면 개편이 항상 필요한 것은 아닙니다.',
        ],
    ];
@endphp

@section('title', 'SEO·AEO·GEO — 검색과 AI 답변에서 발견되는 구조 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="구글·네이버 검색 최적화부터 AEO·GEO까지. 크롤링·색인·콘텐츠·엔티티·신뢰 근거와 전환 동선을 함께 정비하는 제이커브 SEO 서비스.">
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
                <span class="landing__eyebrow">SEO · AEO · GEO</span>
                <h1>검색과 AI 답변에서 발견될 수 있는 구조를 만듭니다</h1>
                <p class="landing__lead">키워드 몇 개를 올리는 일이 아닙니다. 검색엔진이 사이트를 읽고, 사용자의 질문과 연결하고, 믿을 만한 정보로 판단할 수 있도록 기술·콘텐츠·신뢰 근거를 함께 정비합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">SEO 진단 요청</a>
                </div>
                </div>
                <figure class="landing__hero-figure"><img src="{{ asset('media/scenes/seo.webp') }}" alt="" width="1000" height="750" loading="eager"></figure>
            </div>
        </section>

        <nav class="landing__local-nav" aria-label="SEO·AEO·GEO 페이지 내 탐색">
            <div class="landing__local-nav-inner">
                <a href="#seo-problem">문제</a>
                <a href="#seo-diagnostic">진단</a>
                <a href="#seo-method">방법</a>
                <a href="#seo-ai">AEO·GEO</a>
                <a href="#seo-deliverables">제공 항목</a>
                <a href="#seo-measurement">측정</a>
                <a href="#seo-areas">세부 영역</a>
                <a href="#seo-fit">적합성</a>
                <a href="#seo-faq">FAQ</a>
            </div>
        </nav>

        <section id="seo-problem" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">The Problem</span>
                <h2 class="landing__head">광고를 멈추면, 발견될 경로도 함께 줄어듭니다</h2>
                <div class="prose">
                    <p>광고는 원하는 시점에 빠르게 유입을 만들 수 있지만 집행을 멈추면 노출도 감소합니다. 검색 자산은 느리게 쌓이고 계속 관리해야 하지만, 사용자가 이미 답을 찾고 있는 순간에 브랜드를 만날 수 있게 합니다.</p>
                    <p>문제는 많은 SEO가 ‘키워드를 많이 넣거나 링크를 늘리는 일’로 축소된다는 데 있습니다. 검색엔진이 페이지를 수집하지 못하거나, 사용자의 의도와 문서가 맞지 않거나, 회사와 서비스 정보에 믿을 근거가 없다면 한 가지 작업만으로 해결되지 않습니다.</p>
                </div>
                <div class="landing__callout">순위는 결과입니다. 먼저 발견되고, 이해되고, 선택될 수 있는 조건을 만듭니다.</div>
            </div>
        </section>

        <section id="seo-diagnostic" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Diagnostic</span>
                <h2 class="landing__head">어느 층에서 막혔는지부터 찾습니다</h2>
                <p class="landing__body">같은 ‘검색 유입 감소’도 원인은 다릅니다. 먼저 다섯 층을 나눠 보고 가장 큰 병목부터 고칩니다.</p>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>발견</strong><span>robots, 사이트맵, 링크 구조와 URL 상태가 검색엔진의 접근을 막고 있지 않은지 봅니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>이해</strong><span>제목, 본문 계층, 구조화 데이터가 페이지의 주제와 역할을 명확히 설명하는지 확인합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>적합성</strong><span>사용자가 실제로 묻는 질문과 페이지가 제공하는 답이 맞는지 검색의도를 기준으로 봅니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>신뢰</strong><span>작성 주체, 근거, 수정 정보, 회사·인물·서비스 정보가 일관되고 확인 가능한지 살핍니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>전환</strong><span>검색 방문자가 내용을 이해한 뒤 문의·가입·구매 등 다음 행동으로 이동할 수 있는지 확인합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>측정</strong><span>색인, 노출, 클릭, 페이지 행동과 전환을 같은 기간과 URL 기준으로 비교할 수 있게 정리합니다.</span></div>
                </div>
            </div>
        </section>

        <section id="seo-method" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method</span>
                <h2 class="landing__head">기술·콘텐츠·신뢰·전환을 한 흐름으로</h2>
                <div class="steps">
                    <div class="steps__item">
                        <strong>기술 SEO</strong>
                        <p>크롤링과 색인, 중복 URL, canonical, 사이트맵, 페이지 성능과 구조화 데이터를 점검합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>콘텐츠 SEO</strong>
                        <p>검색의도를 질문과 주제로 나누고, 각 페이지가 하나의 명확한 역할을 갖도록 콘텐츠와 내부 링크를 설계합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>엔티티와 신뢰 근거</strong>
                        <p>회사·인물·서비스 정보를 일관되게 정리하고, 주장에는 확인 가능한 근거와 출처를 연결합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>전환 연결</strong>
                        <p>상위 노출만 보지 않습니다. 방문자가 원하는 답을 얻고 다음 행동으로 이동하도록 정보와 CTA를 배치합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>관찰과 개선</strong>
                        <p>수집·노출·클릭·전환 변화를 기록하고, 영향이 큰 페이지부터 계속 보완합니다.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="seo-ai" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">AEO · GEO</span>
                <h2 class="landing__head">같은 뿌리에서 출발하지만, 노출면은 다릅니다</h2>
                <p class="landing__body">생성형 AI는 웹 문서와 여러 정보원을 종합합니다. 검색 접근성만으로 충분하지 않고, 브랜드 엔티티와 근거·출처가 명확해야 합니다.</p>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>AEO — 질문에 바로 답하는 구조</h3>
                        <p>사용자의 질문을 분해하고, 결론·조건·근거·관련 문서를 읽기 쉬운 순서로 정리합니다.</p>
                        <ul>
                            <li>질문 의도와 답변 단위 설계</li>
                            <li>FAQ·본문 계층과 내부 링크</li>
                            <li>적절한 구조화 데이터</li>
                        </ul>
                        <a href="{{ route('services.seo.aeo') }}">AEO 자세히 →</a>
                    </div>
                    <div class="landing__panel">
                        <h3>GEO — 브랜드와 근거를 이해시키는 구조</h3>
                        <p>회사·인물·서비스의 관계를 일관되게 만들고, 생성 시스템이 참고할 수 있는 원본 자료와 출처를 정비합니다.</p>
                        <ul>
                            <li>브랜드 엔티티와 정보 일관성</li>
                            <li>인용 가능한 사실·근거 문서</li>
                            <li>표본 질문 기반 노출 관찰</li>
                        </ul>
                        <a href="{{ route('services.seo.geo') }}">GEO 자세히 →</a>
                    </div>
                </div>
                <p class="landing__note">AEO·GEO는 검색 결과나 생성형 AI의 특정 답변에 노출·인용되는 것을 보장하지 않습니다.</p>
            </div>
        </section>

        <section id="seo-deliverables" class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Deliverables</span>
                <h2 class="landing__head">진단이 보고서로 끝나지 않도록</h2>
                <p class="landing__body">무엇이 문제인지뿐 아니라 어떤 순서로 바꿀지, 누가 실행할지까지 연결합니다. 구체적인 범위는 계약 단계에서 확정합니다.</p>
                <ul class="landing__evidence">
                    <li><strong>기술 진단과 우선순위</strong> — 수집·색인·URL·성능 문제를 영향도와 실행 난이도로 정리합니다.</li>
                    <li><strong>키워드·질문·검색의도 맵</strong> — 검색량 나열이 아니라 사용자의 목적과 필요한 답을 연결합니다.</li>
                    <li><strong>정보 구조와 내부 링크안</strong> — 페이지 역할과 문서 간 관계를 설계합니다.</li>
                    <li><strong>페이지별 콘텐츠 브리프</strong> — 핵심 질문, 답변 범위, 근거와 CTA를 정의합니다.</li>
                    <li><strong>구조화 데이터 적용안</strong> — 실제 화면 콘텐츠와 일치하는 마크업을 설계합니다.</li>
                    <li><strong>측정 기준과 개선 이력</strong> — 색인·유입·전환과 실행 변경 사항을 같은 기준으로 남깁니다.</li>
                </ul>
            </div>
        </section>

        <section id="seo-measurement" class="landing__section landing__section--dark has-orb">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Measurement</span>
                <h2 class="landing__head">순위 하나로 SEO 전체를 설명하지 않습니다</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>검색 성과</h3>
                        <ul>
                            <li>수집·색인 가능한 URL 상태</li>
                            <li>검색어별 노출과 클릭 변화</li>
                            <li>주요 페이지의 유입과 행동</li>
                            <li>문의·가입·구매 등 합의한 전환</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>AI 가시성</h3>
                        <ul>
                            <li>표본 질문별 브랜드 언급 여부</li>
                            <li>답변에 연결된 출처와 문맥</li>
                            <li>회사·서비스 정보의 정확성</li>
                            <li>기간별 변화와 수정이 필요한 오류</li>
                        </ul>
                    </div>
                </div>
                <p class="landing__note">표본 질문으로 확인한 AI 답변은 전체 사용자와 모든 시점의 결과를 대표하지 않습니다. 관찰 범위와 날짜를 함께 기록합니다.</p>
            </div>
        </section>

        <section id="seo-areas" class="landing__section landing__section--light">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Specialties</span>
                <h2 class="landing__head">검색되는 플랫폼과 목적에 맞춰</h2>
                <p class="landing__body">웹 검색, 로컬 검색, 상품 검색은 같은 방식으로 움직이지 않습니다. 각 플랫폼에서 사용자가 찾고 비교하고 행동하는 흐름에 맞춰 세부 작업을 나눕니다.</p>
                <div class="subcards">
                    <a class="subcard" href="{{ route('services.seo.aeo') }}"><strong>AEO</strong><p>질문에 답하는 콘텐츠와 정보 구조.</p><span>답변엔진 최적화 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.geo') }}"><strong>GEO</strong><p>생성형 AI가 이해할 수 있는 엔티티·근거·출처.</p><span>생성엔진 최적화 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'backlinks']) }}"><strong>백링크</strong><p>수보다 관련성과 품질을 보는 링크 프로필 관리.</p><span>월 50만원부터 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'naver-place']) }}"><strong>네이버 플레이스</strong><p>검색 노출부터 전화·예약·길찾기까지.</p><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'naver-shopping']) }}"><strong>네이버 쇼핑</strong><p>상품 데이터와 검색의도, 구매 전환의 연결.</p><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'coupang']) }}"><strong>쿠팡</strong><p>찾히는 상품 정보와 구매를 돕는 상세 구성.</p><span>자세히 →</span></a>
                    <a class="subcard" href="{{ route('services.seo.sub', ['sub' => 'kakao-gift']) }}"><strong>카카오 선물하기</strong><p>관계·상황·시즌·가격대별 선물 의도 설계.</p><span>자세히 →</span></a>
                </div>
            </div>
        </section>

        <section id="seo-fit" class="landing__section landing__section--parchment">
            <div class="landing__inner landing__inner--wide">
                <span class="landing__eyebrow">Fit Check</span>
                <h2 class="landing__head">SEO가 필요한 순간과, 먼저 준비할 것</h2>
                <div class="landing__split">
                    <div class="landing__panel">
                        <h3>지금 시작하기 좋은 경우</h3>
                        <ul>
                            <li>광고 외의 지속적인 발견 경로를 만들고 싶다.</li>
                            <li>사이트와 콘텐츠가 있지만 검색 유입이 약하다.</li>
                            <li>서비스 전문성을 설명할 원본 자료가 있다.</li>
                            <li>단기 순위보다 검색 자산을 꾸준히 운영할 수 있다.</li>
                        </ul>
                    </div>
                    <div class="landing__panel">
                        <h3>먼저 조건을 정리할 경우</h3>
                        <ul>
                            <li>일주일 안에 특정 키워드 1위를 보장받고 싶다.</li>
                            <li>사이트 수정 권한이나 콘텐츠 근거를 제공할 수 없다.</li>
                            <li>실제 서비스와 다른 정보를 대량 생산하려 한다.</li>
                            <li>검색 유입 이후의 문의·구매 동선이 준비되지 않았다.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="seo-faq" class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">FAQ</span>
                <h2 class="landing__head">SEO를 시작하기 전에</h2>
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
                <h2>순위 약속보다, 지금 막힌 이유부터</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">사이트 URL과 중요 서비스, 확보하고 싶은 검색 유입을 알려주세요. 기술·콘텐츠·신뢰 중 어디부터 볼지 정리하겠습니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">SEO 진단 요청</a>
                </div>
            </div>
        </section>
    </main>
@endsection
