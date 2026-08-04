@extends('layouts.app')

@section('title', '제이커브인터렉티브 | 데이터로 증명하는 퍼포먼스 마케팅 에이전시')

@section('content')
    <main class="home">

        {{-- ============ S1. 히어로 [다크·검정] — 풀스크린 비디오 + 스크롤 줌 ============ --}}
        <section class="home__hero">
            <div class="home__hero-media" data-hero-zoom aria-hidden="true">
                {{-- 풀사이즈 히어로 동영상 슬롯: public/media/hero.mp4 + hero-poster.jpg 를 넣으면 자동 재생.
                     에셋 부착 전에는 니어블랙 폴백. prefers-reduced-motion 시 CSS로 숨김 처리. --}}
                <video class="home__hero-video" autoplay muted loop playsinline preload="metadata"
                       poster="{{ asset('media/hero-poster.jpg') }}">
                    <source src="{{ asset('media/hero.webm') }}" type="video/webm">
                    <source src="{{ asset('media/hero.mp4') }}" type="video/mp4">
                </video>
            </div>

            <div class="home__hero-inner">
                <span class="home__hero-badge">퍼포먼스 · CPA · SEO · 리워드 네트워크</span>
                <h1>데이터로 증명하는<br><span class="grad">퍼포먼스 마케팅</span></h1>
                <p>성과형 광고부터 검색·AI 최적화, 자체 데이터 솔루션까지 —
                   숫자로 말하는 종합 디지털 마케팅 에이전시입니다.</p>
                {{-- 증거 한 줄(하네스 Creative Director): 제이커브만의 훅 = 자기 사이트로 SEO 실력 증명 --}}
                <p class="home__hero-proof">지금 이 화면도 저희가 직접 검색 상위에 올린 결과입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">프로젝트 문의하기</a>
                    <a class="btn-ghost" href="{{ route('work.index') }}">성과 사례 보기</a>
                </div>
            </div>

            <a class="home__hero-scroll" href="#home-trust" aria-label="아래로 스크롤">
                <span></span>
            </a>
        </section>

        {{-- ============ S2. 신뢰 스트립 [파치먼트] — 클라이언트 로고월 ============ --}}
        <section class="home__trust" id="home-trust" aria-labelledby="home-trust-title">
            {{-- [검증 V1] 현재는 매체노출도 포괄하는 안전 표현. 직접계약 확인 시 "함께한 브랜드"로 강화 --}}
            <p class="home__trust-head" id="home-trust-title">캠페인이 집행된 브랜드</p>
            <ul class="home__trust-logos" role="list">
                @foreach (['넷플릭스', 'LG유플러스', '현대해상', '야놀자', '함소아', '대명리조트', '라미화장품', '1300K', '유가네닭갈비'] as $brand)
                    <li class="home__trust-logo">{{ $brand }}</li>
                @endforeach
            </ul>
            {{-- [검증 V2] 기준시점 병기(산출 근거·기준시점 미표기 시 신뢰 하락 방지) --}}
            <p class="home__trust-proof">2026년 기준 누적 집행 광고비 373억원 · 진행 캠페인 15,700건</p>
        </section>

        {{-- ============ S3. 통계 [다크 타일] — 4대 숫자 (강세) ============ --}}
        <section class="home__stats" aria-label="핵심 성과 지표">
            <div class="home__stats-inner">
                <div class="stat">
                    <strong data-count-to="373" data-count-suffix="억+">373억+</strong>
                    <span>누적 집행 광고비</span>
                </div>
                <div class="stat">
                    <strong data-count-to="128" data-count-suffix="만+">128만+</strong>
                    <span>누적 수집 DB</span>
                </div>
                <div class="stat">
                    <strong data-count-to="15700" data-count-suffix="+" data-count-comma="1">15,700+</strong>
                    <span>진행 캠페인</span>
                </div>
                <div class="stat">
                    <strong data-count-to="5.06" data-count-suffix="만" data-count-decimals="2">5.06만</strong>
                    <span>아나키 채널 구독자</span>
                </div>
            </div>
        </section>

        {{-- ============ S4. 사업영역 인트로 [라이트] ============ --}}
        <section class="home__intro" aria-labelledby="home-intro-title">
            <h2 id="home-intro-title">하나의 팀, 아홉 개의 전문 영역</h2>
            <p class="section-sub">유입부터 전환, 데이터 분석까지 — 흩어진 대행사 대신
               한 팀에서 통합 운영합니다. 매체·데이터·개발이 한자리에 있습니다.</p>
        </section>

        {{-- ============ S5. 핵심영역 타일 ×3 [라이트↔다크 교차] ============ --}}
        <section class="home__pillars" aria-label="핵심 사업 영역">
            {{-- 5-1 퍼포먼스 마케팅 [라이트] --}}
            <article class="pillar pillar--light">
                <div class="pillar__body">
                    <span class="pillar__label">PERFORMANCE</span>
                    <h3 class="pillar__title">쓴 만큼이 아니라, 번 만큼 말합니다</h3>
                    <p class="pillar__sub">ROAS·CPA·전환을 기준으로 매체를 운용합니다.
                       감이 아니라 데이터로 예산을 배분합니다.</p>
                    <a class="pillar__cta" href="{{ route('services.show', ['slug' => 'performance-marketing']) }}">퍼포먼스 마케팅 →</a>
                </div>
                <div class="pillar__media" aria-hidden="true"></div>
            </article>

            {{-- 5-2 CPA · 리워드 네트워크 [다크] --}}
            <article class="pillar pillar--dark">
                <div class="pillar__body">
                    <span class="pillar__label">CPA · REWARD</span>
                    <h3 class="pillar__title">성과가 나온 만큼만 비용이 발생합니다</h3>
                    <p class="pillar__sub">CPA 성과형 광고와 리워드 네트워크 운영.
                       앱 설치·회원가입·구매까지, 액션 단위로 과금합니다.</p>
                    <div class="pillar__ctas">
                        <a class="pillar__cta" href="{{ route('services.show', ['slug' => 'cpa-marketing']) }}">CPA 마케팅 →</a>
                        <a class="pillar__cta" href="{{ route('services.show', ['slug' => 'reward-network']) }}">리워드 네트워크 →</a>
                    </div>
                </div>
                <div class="pillar__media" aria-hidden="true"></div>
            </article>

            {{-- 5-3 SEO · AEO · GEO [라이트] --}}
            <article class="pillar pillar--light">
                <div class="pillar__body">
                    <span class="pillar__label">SEARCH · AI</span>
                    <h3 class="pillar__title">검색을 넘어, AI 답변에 노출됩니다</h3>
                    <p class="pillar__sub">구글·네이버 상위노출(SEO)부터 AI 검색 최적화(AEO·GEO)까지.
                       이 사이트 자체가 저희의 포트폴리오입니다.</p>
                    <a class="pillar__cta" href="{{ route('services.show', ['slug' => 'seo']) }}">SEO · AEO · GEO →</a>
                </div>
                <div class="pillar__media" aria-hidden="true"></div>
            </article>
        </section>

        {{-- ============ S6. 나머지 영역 + 허브 [파치먼트] ============ --}}
        <section class="home__more" aria-labelledby="home-more-title">
            <h3 class="home__more-title" id="home-more-title">그 외 전문 영역</h3>
            <div class="home__more-grid">
                <a class="home__more-card" href="{{ route('services.show', ['slug' => 'wordpress']) }}">
                    <strong>워드프레스 대행</strong>
                    <span>제작부터 SEO·유지보수까지</span>
                </a>
                <a class="home__more-card" href="{{ route('services.index') }}">
                    <strong>전체 서비스 보기 →</strong>
                    <span>9개 전문 영역 한눈에</span>
                </a>
            </div>
        </section>

        {{-- ============ S7. 자체 솔루션 [다크 타일] — 최대 차별점 ============ --}}
        <section class="home__solutions" aria-labelledby="home-solutions-title">
            <div class="home__solutions-inner">
                <span class="pillar__label">OUR PRODUCTS</span>
                <h2 id="home-solutions-title">우리는 도구까지 직접 만듭니다</h2>
                <p class="home__solutions-sub">남의 툴을 빌려 쓰지 않습니다. 현장에서 필요한 데이터 솔루션을
                   직접 개발해 운영합니다.</p>
                <div class="home__solutions-grid">
                    <div class="solution-card">
                        <strong>랭크프리 <span>(RankFree)</span></strong>
                        <p>데이터드리븐 순위 추적·분석 솔루션</p>
                        <a href="{{ route('solutions.rankfree') }}">자세히 →</a>
                    </div>
                    <div class="solution-card">
                        <strong>부스팅샵 <span>(BoostingShop)</span></strong>
                        <p>직접 돌리는 셀프 마케팅 솔루션</p>
                        <a href="{{ route('solutions.boostingshop') }}">자세히 →</a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============ S8. 대표 성과 [라이트] — 데이터 없으면 섹션 숨김 ============ --}}
        @if ($works->isNotEmpty())
            <section class="home__works" aria-labelledby="home-works-title">
                <h2 id="home-works-title">숫자로 남은 결과들</h2>
                <p class="section-sub">캠페인은 끝나도 데이터는 남습니다. 대표 사례 몇 가지입니다.</p>
                <div class="home__works-grid">
                    @foreach ($works as $work)
                        <a class="work-preview" href="{{ route('work.show', ['work' => $work->slug]) }}">
                            <div class="work-preview__thumb" aria-hidden="true"></div>
                            <span class="work-preview__meta">{{ $work->client }}@if ($work->industry) · {{ $work->industry }}@endif</span>
                            <strong class="work-preview__title">{{ $work->title }}</strong>
                            <span class="work-preview__link">사례 보기 →</span>
                        </a>
                    @endforeach
                </div>
                <div class="home__works-cta">
                    <a class="btn-ghost" href="{{ route('work.index') }}">전체 성과 보기 →</a>
                </div>
            </section>
        @endif

        {{-- ============ S9. 아나키 밴드 [파치먼트] — 은은하게 ============ --}}
        <section class="home__anarchy" aria-label="아나키 유튜브 채널">
            {{-- [검증 V4] 홈에서는 직함 미표기(임원 신분·개인 브랜드 충돌 회피). 직함 확정 시 "총괄이사가 운영하는"으로 --}}
            <p class="home__anarchy-text">제이커브가 함께하는 유튜브 채널 ‘아나키’ —
               마케팅 현장의 이야기를 콘텐츠로 풉니다. <span>(구독 5.06만)</span></p>
            <a class="home__anarchy-link" href="{{ route('company') }}#anarchy">채널 보기 →</a>
        </section>

        {{-- ============ S10a. 인사이트 프리뷰 [라이트] — 없으면 섹션 숨김 ============ --}}
        @if ($insights->isNotEmpty())
            <section class="home__insights" aria-labelledby="home-insights-title">
                <h2 id="home-insights-title">마케팅, 계속 공부합니다</h2>
                <p class="section-sub">현장에서 검증한 것만 글로 남깁니다.</p>
                <div class="home__insights-grid">
                    @foreach ($insights as $insight)
                        <a class="insight-preview" href="{{ route('insights.show', ['insight' => $insight->slug]) }}">
                            @if ($insight->category)
                                <span class="insight-preview__cat">{{ $insight->category->name }}</span>
                            @endif
                            <strong class="insight-preview__title">{{ $insight->title }}</strong>
                            @if ($insight->excerpt)
                                <span class="insight-preview__excerpt">{{ $insight->excerpt }}</span>
                            @endif
                            @if ($insight->published_at)
                                <time class="insight-preview__date" datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format('Y.m.d') }}</time>
                            @endif
                        </a>
                    @endforeach
                </div>
                <div class="home__insights-cta">
                    <a class="btn-ghost" href="{{ route('insights.index') }}">인사이트 전체 보기 →</a>
                </div>
            </section>
        @endif

        {{-- ============ S10b. 최종 CTA [다크 타일] — 페이지 클로징 앵커 ============ --}}
        <section class="home__cta" aria-labelledby="home-cta-title">
            <div class="home__cta-inner">
                <h2 id="home-cta-title">숫자로 증명할 준비가 되어 있습니다</h2>
                {{-- [검증 V3] "첫 상담 무료" 삭제(대웅 미확정 — 단정 시 고객이 근거 요구). 확인 후 복원 가능 --}}
                <p>지금 진행 중인 마케팅, 데이터로 다시 보겠습니다.<br>현재 성과를 알려주시면 개선 지점부터 짚어드립니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">프로젝트 문의하기</a>
                    <a class="btn-ghost" href="{{ route('work.index') }}">성과 사례 보기</a>
                </div>
            </div>
        </section>

    </main>
@endsection
