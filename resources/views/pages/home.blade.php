@extends('layouts.app')

@section('title', '제이커브인터렉티브 | 데이터로 증명하는 퍼포먼스 마케팅 에이전시')

@section('content')
    <main class="home">

        {{-- ============ S1. 히어로 [다크·검정] — 풀스크린 비디오 + 스크롤 줌 (변경 금지 영역) ============ --}}
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
                <h1>여러분들의 매출 파트너<br><span class="grad">제이커브인터렉티브</span></h1>
                <p>성과형 광고부터 검색·AI 최적화, 자체 데이터 솔루션까지 —
                   숫자로 말하는 종합 디지털 마케팅 에이전시입니다.</p>
                {{-- 증거 한 줄(하네스 Creative Director): 제이커브만의 훅 = 자기 사이트로 SEO 실력 증명 --}}
                <p class="home__hero-proof">지금 이 화면도 저희가 직접 검색 상위에 올린 결과입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">프로젝트 문의하기</a>
                    <a class="btn-ghost" href="{{ route('work.index') }}">성과 사례 보기</a>
                </div>
            </div>

            <a class="home__hero-scroll" href="#home-stats" aria-label="아래로 스크롤">
                <span></span>
            </a>
        </section>

        {{-- ============ S2. 신뢰 스트립 [파치먼트] — 클라이언트 로고월 ============ --}}
        <section class="home__trust" id="home-trust" aria-labelledby="home-trust-title">
            {{-- [검증 V1] 현재는 매체노출도 포괄하는 안전 표현. 직접계약 확인 시 "함께한 브랜드"로 강화 --}}
            <p class="home__trust-head" id="home-trust-title">캠페인이 집행된 브랜드</p>
            @php($trustBrands = ['넷플릭스', 'LG유플러스', '현대해상', '야놀자', '함소아', '대명리조트', '라미화장품', '1300K', '유가네닭갈비'])
            <div class="marquee home__trust-marquee">
                <ul class="marquee__track" role="list">
                    {{-- 무한 흐름 위해 2세트 복제(translateX -50% 반복). reduce-motion 시 정적 그리드 --}}
                    @foreach (array_merge($trustBrands, $trustBrands) as $i => $brand)
                        <li class="home__trust-logo"@if ($i >= count($trustBrands)) aria-hidden="true"@endif>{{ $brand }}</li>
                    @endforeach
                </ul>
            </div>
            {{-- [검증 V2] 기준시점 병기(산출 근거·기준시점 미표기 시 신뢰 하락 방지) --}}
            <p class="home__trust-proof">2026년 기준 누적 집행 광고비 373억원 · 진행 캠페인 15,700건</p>
        </section>

        {{-- ============ S3. 핵심 지표 [다크] — 3D 아이콘 스탯 카드 (버즈빌형) ============ --}}
        <section class="home__stats has-orb" id="home-stats" aria-label="핵심 성과 지표">
            @include('partials.section-mesh', ['k' => 'stats', 'variant' => 'data'])
            <div class="home__stats-head">
                <span class="section-eyebrow">BY THE NUMBERS</span>
                <h2>숫자가 먼저 말합니다</h2>
                <p class="section-sub section-sub--dark">감이 아니라 누적 데이터로 증명합니다. 2026년 기준.</p>
            </div>
            @php($stats = [
                ['icon' => 'performance', 'to' => '373', 'suffix' => '억+', 'label' => '누적 집행 광고비', 'note' => '실집행 미디어 스펜드'],
                ['icon' => 'leadbay', 'to' => '128', 'suffix' => '만+', 'label' => '누적 수집 DB', 'note' => '성과형·리드 캠페인 합산'],
                ['icon' => 'cpa', 'to' => '15700', 'suffix' => '+', 'comma' => '1', 'label' => '진행 캠페인', 'note' => '누적 집행 건수'],
                ['icon' => 'rankfree', 'to' => '5.06', 'suffix' => '만', 'decimals' => '2', 'label' => '아나키 채널 구독자', 'note' => '자체 유튜브 채널'],
            ])
            <div class="home__stats-inner">
                @foreach ($stats as $s)
                    <div class="statcard glass-card">
                        <span class="icon3d icon-il statcard__icon">
                            @include('partials.icon', ['name' => $s['icon']])
                        </span>
                        <strong data-count-to="{{ $s['to'] }}" data-count-suffix="{{ $s['suffix'] }}"
                            @isset($s['decimals']) data-count-decimals="{{ $s['decimals'] }}" @endisset
                            @isset($s['comma']) data-count-comma="1" @endisset>{{ isset($s['comma']) ? number_format((int) $s['to']) . $s['suffix'] : $s['to'] . $s['suffix'] }}</strong>
                        <span class="statcard__label">{{ $s['label'] }}</span>
                        <span class="statcard__note">{{ $s['note'] }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ============ S4. 목표 필터 [라이트] — Alpine 인터랙티브 (버즈빌 "목표가 무엇인가요?") ============ --}}
        @php($goalPills = [
            'all' => '전체',
            'brand' => '브랜드 알리기',
            'lead' => '잠재고객 확보',
            'convert' => '전환 극대화',
            'search' => '검색·AI 노출',
            'build' => '채널·제작',
        ])
        @php($goalCards = [
            ['slug' => 'performance-marketing', 'route' => ['services.show', ['slug' => 'performance-marketing']], 'eyebrow' => 'ROAS로 증명하는', 'title' => '퍼포먼스 마케팅', 'desc' => 'ROAS·CPA·전환 기준으로 매체를 운용합니다. 감이 아니라 데이터로 예산을 배분합니다.', 'img' => 'performance', 'goals' => ['brand', 'convert']],
            ['slug' => 'cpa-marketing', 'route' => ['services.show', ['slug' => 'cpa-marketing']], 'eyebrow' => '액션당 과금하는', 'title' => 'CPA 마케팅', 'desc' => '앱 설치·회원가입·구매까지, 성과가 나온 액션 단위로만 과금합니다.', 'img' => 'cpa', 'goals' => ['lead', 'convert']],
            ['slug' => 'reward-network', 'route' => ['services.show', ['slug' => 'reward-network']], 'eyebrow' => '대량 유입을 만드는', 'title' => '리워드 네트워크', 'desc' => '리워드 매체 네트워크로 잠재고객을 대규모로 확보합니다.', 'img' => 'reward', 'goals' => ['lead']],
            ['slug' => 'seo', 'route' => ['services.show', ['slug' => 'seo']], 'eyebrow' => '검색을 넘어 AI 답변까지', 'title' => 'SEO · AEO · GEO', 'desc' => '구글·네이버 상위노출부터 AI 검색 최적화까지. 이 사이트가 곧 포트폴리오입니다.', 'img' => 'seo', 'goals' => ['brand', 'search']],
            ['slug' => 'wordpress', 'route' => ['services.show', ['slug' => 'wordpress']], 'eyebrow' => '제작부터 운영까지', 'title' => '워드프레스 대행', 'desc' => '사이트 제작부터 SEO·유지보수까지 한 팀에서 끝냅니다.', 'img' => 'wordpress', 'goals' => ['search', 'build']],
        ])
        <section class="home__goals" aria-labelledby="home-goals-title" x-data="{ goal: 'all' }">
            <div class="home__goals-head">
                <span class="section-eyebrow">WHAT'S YOUR GOAL?</span>
                <h2 id="home-goals-title">지금, 목표가 무엇인가요?</h2>
                <p class="section-sub">목표를 고르면 딱 맞는 방식을 보여드립니다. 흩어진 대행사 대신 한 팀에서 통합 운영합니다.</p>
            </div>

            <div class="goalfilter" role="tablist" aria-label="마케팅 목표 필터">
                @foreach ($goalPills as $key => $label)
                    <button type="button" class="pill" role="tab"
                            :class="{ 'is-active': goal === '{{ $key }}' }"
                            :aria-selected="goal === '{{ $key }}' ? 'true' : 'false'"
                            @click="goal = '{{ $key }}'">{{ $label }}</button>
                @endforeach
            </div>

            <div class="home__goals-grid">
                @foreach ($goalCards as $c)
                    <a class="goalcard" href="{{ route($c['route'][0], $c['route'][1]) }}"
                       data-goals="{{ implode('|', $c['goals']) }}"
                       x-show="goal === 'all' || '{{ implode('|', $c['goals']) }}'.split('|').includes(goal)"
                       x-transition.opacity>
                        <span class="goalcard__eyebrow">{{ $c['eyebrow'] }}</span>
                        <span class="goalcard__title">{{ $c['title'] }} <span aria-hidden="true">→</span></span>
                        <span class="goalcard__media">
                            <img src="{{ asset('media/scenes/' . $c['img'] . '.webp') }}" alt="" loading="lazy" width="1400" height="1050">
                        </span>
                        <span class="goalcard__desc">{{ $c['desc'] }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- ============ S5. 차별점 벤토 [다크] — "대행 넘어 도구까지" (버즈빌 인터랙션 AI 벤토) ============ --}}
        <section class="home__bento has-orb" aria-labelledby="home-bento-title">
            @include('partials.section-mesh', ['k' => 'bento', 'variant' => 'mesh'])
            <div class="home__bento-head">
                <span class="section-eyebrow">WHY J-CURVE</span>
                <h2 id="home-bento-title">광고에서 끝나지 않습니다.<br>데이터와 도구까지 직접 만듭니다.</h2>
            </div>
            <div class="home__bento-grid">
                {{-- 큰 타일: 통합 운영 + 씬 이미지 --}}
                <article class="bento bento--wide glass-card">
                    <div class="bento__body">
                        <h3 class="bento__title">흩어진 대행사 대신,<br>한 팀에서 통합 운영</h3>
                        <p class="bento__text">매체·데이터·개발이 한자리에 있습니다. 유입부터 전환, 분석까지 끊김 없이 이어집니다.</p>
                        <a class="bento__cta" href="{{ route('services.index') }}">9개 전문 영역 보기 →</a>
                    </div>
                    <div class="bento__media" aria-hidden="true">
                        <img src="{{ asset('media/scenes/pillar_search.webp') }}" alt="" loading="lazy" width="1400" height="1050">
                    </div>
                </article>

                {{-- 스탯 타일 --}}
                <article class="bento bento--stat glass-card">
                    <strong class="bento__stat" data-count-to="128" data-count-suffix="만+">128만+</strong>
                    <span class="bento__stat-label">누적 수집 DB</span>
                    <p class="bento__text">캠페인은 끝나도 데이터는 남습니다.</p>
                </article>

                {{-- 자체 솔루션 타일 --}}
                <article class="bento bento--accent glass-card">
                    <span class="icon3d icon-il bento__icon">@include('partials.icon', ['name' => 'rankfree'])</span>
                    <h3 class="bento__title bento__title--sm">도구까지 직접 개발</h3>
                    <p class="bento__text">남의 툴을 빌리지 않습니다. 현장에서 필요한 솔루션 4종을 자체 운영합니다.</p>
                    <a class="bento__cta" href="{{ route('solutions.index') }}">자체 솔루션 →</a>
                </article>

                {{-- 스탯 타일 --}}
                <article class="bento bento--stat glass-card">
                    <strong class="bento__stat" data-count-to="15700" data-count-suffix="+" data-count-comma="1">15,700+</strong>
                    <span class="bento__stat-label">진행 캠페인</span>
                    <p class="bento__text">373억+ 광고비를 실제로 태워봤습니다.</p>
                </article>

                {{-- 검색 증명 타일 --}}
                <article class="bento bento--proof glass-card">
                    <span class="icon3d icon-il bento__icon">@include('partials.icon', ['name' => 'seo'])</span>
                    <h3 class="bento__title bento__title--sm">이 사이트가 증거입니다</h3>
                    <p class="bento__text">지금 이 화면도 저희가 직접 검색 상위에 올린 결과입니다. SEO 실력을 자기 사이트로 증명합니다.</p>
                    <a class="bento__cta" href="{{ route('services.show', ['slug' => 'seo']) }}">SEO · AEO · GEO →</a>
                </article>
            </div>
        </section>

        {{-- ============ S6. 자체 솔루션 [다크 타일] — 최대 차별점 ============ --}}
        <section class="home__solutions has-orb" aria-labelledby="home-solutions-title">
            @include('partials.section-mesh', ['k' => 'sol', 'variant' => 'orbit'])
            <div class="home__solutions-inner">
                <span class="section-eyebrow">OUR PRODUCTS</span>
                <h2 id="home-solutions-title">우리는 도구까지 직접 만듭니다</h2>
                {{-- 03_솔루션.md 상호링크 규칙: 홈 S7 = 자체 솔루션 4종. 리드 톤도 4종(데이터+CRM) 반영 --}}
                <p class="home__solutions-sub">남의 툴을 빌려 쓰지 않습니다. 마케팅 데이터부터 보험 세일즈 CRM까지,
                   현장에서 필요한 도구를 직접 개발해 운영합니다.</p>
                <div class="home__solutions-grid">
                    <a class="solution-card glass-card" href="{{ route('solutions.rankfree') }}">
                        <span class="icon3d icon-il solution-card__icon">@include('partials.icon', ['name' => 'rankfree'])</span>
                        <strong>랭크프리 <span>(RankFree)</span></strong>
                        <p>네이버 순위·시장 분석</p>
                        <span class="solution-card__cta">자세히 →</span>
                    </a>
                    <a class="solution-card glass-card" href="{{ route('solutions.boostingshop') }}">
                        <span class="icon3d icon-il solution-card__icon">@include('partials.icon', ['name' => 'boostingshop'])</span>
                        <strong>부스팅샵 <span>(BoostingShop)</span></strong>
                        <p>직접 돌리는 셀프 마케팅</p>
                        <span class="solution-card__cta">자세히 →</span>
                    </a>
                    <a class="solution-card glass-card" href="{{ route('solutions.leadbay') }}">
                        <span class="icon3d icon-il solution-card__icon">@include('partials.icon', ['name' => 'leadbay'])</span>
                        <strong>리드베이 <span>(LEADBAY)</span></strong>
                        <p>보험 영업조직 세일즈 CRM</p>
                        <span class="solution-card__cta">자세히 →</span>
                    </a>
                    <a class="solution-card glass-card" href="{{ route('solutions.call2sale') }}">
                        <span class="icon3d icon-il solution-card__icon">@include('partials.icon', ['name' => 'call2sale'])</span>
                        <strong>콜투세일 <span>(Call2.Sale)</span></strong>
                        <p>보험DB 콜센터 CRM</p>
                        <span class="solution-card__cta">자세히 →</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ============ S7. 대표 성과 [라이트] — 캐러셀 (버즈빌 브랜드 성장). 데이터 없으면 숨김 ============ --}}
        @if ($works->isNotEmpty())
            <section class="home__works" aria-labelledby="home-works-title">
                <div class="home__works-head">
                    <div>
                        <span class="section-eyebrow">CASE STUDIES</span>
                        <h2 id="home-works-title">함께 만든 브랜드의 성장</h2>
                        <p class="section-sub">캠페인은 끝나도 데이터는 남습니다. 대표 사례 몇 가지입니다.</p>
                    </div>
                    <a class="btn-ghost home__works-headcta" href="{{ route('work.index') }}">전체 성과 보기 →</a>
                </div>
                <div class="home__works-rail">
                    @foreach ($works as $work)
                        <a class="work-preview" href="{{ route('work.show', ['work' => $work->slug]) }}">
                            <div class="work-preview__thumb" aria-hidden="true">
                                @if ($work->cover_image)<img src="{{ asset($work->cover_image) }}" alt="" loading="lazy" width="1280" height="720">@endif
                            </div>
                            <span class="work-preview__meta">{{ $work->client }}@if ($work->industry) · {{ $work->industry }}@endif</span>
                            {{-- 인라인 @php() 사용: 파일 상단 @php() 인라인과 @php 블록이 섞이면 Blade가 오파싱하므로 --}}
                            @php($metrics = $work->metrics)
                            @php($m = is_array($metrics) && count($metrics) ? reset($metrics) : null)
                            @php($mv = is_array($m) ? ($m['value'] ?? null) : $m)
                            @php($ml = is_array($m) ? ($m['label'] ?? null) : null)
                            @if (! empty($mv))
                                <span class="work-preview__metric">{{ $mv }}@if ($ml)<small>{{ $ml }}</small>@endif</span>
                            @endif
                            <strong class="work-preview__title">{{ $work->title }}</strong>
                            <span class="work-preview__link">사례 보기 →</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ============ S8. 인사이트 프리뷰 [라이트] — 없으면 섹션 숨김 ============ --}}
        @if ($insights->isNotEmpty())
            <section class="home__insights" aria-labelledby="home-insights-title">
                <span class="section-eyebrow">INSIGHTS</span>
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

        {{-- ============ S9. 아나키 밴드 [파치먼트] — 은은하게 ============ --}}
        <section class="home__anarchy" aria-label="아나키 유튜브 채널">
            {{-- [검증 V4] 홈에서는 직함 미표기(임원 신분·개인 브랜드 충돌 회피). 직함 확정 시 "총괄이사가 운영하는"으로 --}}
            <p class="home__anarchy-text">제이커브가 함께하는 유튜브 채널 ‘아나키’ —
               마케팅 현장의 이야기를 콘텐츠로 풉니다. <span>(구독 5.06만)</span></p>
            <a class="home__anarchy-link" href="{{ route('company') }}#anarchy">채널 보기 →</a>
        </section>

        {{-- ============ S10. 무료 SEO 진단 진입 [파치먼트] ============ --}}
        <section class="home__seocheck" aria-labelledby="home-seocheck-title">
            <div class="home__seocheck-inner">
                <span class="section-eyebrow">FREE SEO · GEO·AEO CHECK</span>
                <h2 id="home-seocheck-title">내 사이트, SEO와 AI 답변 최적화 몇 점일까요?</h2>
                <p class="section-sub" style="margin:0 auto 28px;">주소만 넣으면 온페이지 SEO(타이틀·메타·모바일)부터 GEO·AEO(구조화 데이터·스키마·답변형 구조)까지 즉석 점검합니다. 무료입니다.</p>
                <form class="seocheck__form" method="GET" action="{{ route('seo.check') }}" role="search">
                    <input type="url" name="url" inputmode="url" autocomplete="url"
                           placeholder="https://내사이트.com" aria-label="분석할 웹사이트 주소" required>
                    <button type="submit" class="btn-primary">무료로 진단 →</button>
                </form>
            </div>
        </section>

        {{-- ============ S11. 최종 CTA [다크 타일] — 페이지 클로징 앵커 ============ --}}
        <section class="home__cta has-orb" aria-labelledby="home-cta-title">
            @include('partials.section-mesh', ['k' => 'cta', 'variant' => 'rays'])
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
