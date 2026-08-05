@extends('layouts.app')

@section('title', '회사소개 — 숫자로 증명하는 마케팅 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="제이커브인터렉티브는 SEO 에이전시와 셀프 마케팅 플랫폼을 함께 운영하는 종합 디지털 마케팅 전문 기업입니다. 2009년 설립, 자체 솔루션 4종 운영.">
@endsection

@section('content')
    <main class="landing">
        {{-- S1 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">About</span>
                <h1>숫자로 증명하는 마케팅을 만듭니다</h1>
                <p class="landing__lead">제이커브인터렉티브는 SEO 에이전시와 셀프 마케팅 플랫폼을 함께 운영하는
                   종합 디지털 마케팅 전문 기업입니다.</p>
            </div>
        </section>

        {{-- S2 우리는 누구인가 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Who we are</span>
                <h2 class="landing__head">대행하고, 직접 만들고, 데이터로 증명합니다</h2>
                <p class="landing__body">2009년 설립 이래, 지금은 퍼포먼스·CPA·SEO를 아우르는
                   종합 마케팅 에이전시로 성장했습니다. 남의 도구를 빌리지 않고, 필요한 솔루션은
                   직접 개발해 운영합니다. 광고를 파는 게 아니라 성과를 만드는 것 — 그게 저희 기준입니다.</p>
            </div>
        </section>

        {{-- S3 숫자 [다크 타일] — 홈 stat 컴포넌트 재사용 --}}
        <section class="home__stats has-orb" aria-label="회사 핵심 지표">
            <div class="home__stats-inner">
                <div class="stat glass-card">
                    {{-- [검증 V2] 회사 전체 누적 기준 --}}
                    <strong data-count-to="373" data-count-suffix="억+">373억+</strong>
                    <span>누적 집행 광고비</span>
                </div>
                <div class="stat glass-card">
                    <strong data-count-to="128" data-count-suffix="만+">128만+</strong>
                    <span>누적 수집 DB</span>
                </div>
                <div class="stat glass-card">
                    <strong data-count-to="15700" data-count-suffix="+" data-count-comma="1">15,700+</strong>
                    <span>진행 캠페인</span>
                </div>
                <div class="stat glass-card">
                    <strong data-count-to="10" data-count-suffix="년+">10년+</strong>
                    <span>마케팅 경력</span>
                </div>
            </div>
        </section>

        {{-- S4 왜 종합 에이전시인가 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Why</span>
                <h2 class="landing__head">대행사를 여러 곳 쓰지 않아도 됩니다</h2>
                <div class="landing__points">
                    <div class="landing__point landing__point--light">
                        <strong>한 팀에서 통합</strong>
                        <span>매체·SEO·크리에이티브·개발이 한 회사에. 커뮤니케이션 손실 0.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>자체 솔루션 보유</strong>
                        <span>랭크프리·부스팅샵·리드베이·콜투세일을 직접 개발·운영.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>데이터 기준</strong>
                        <span>노출이 아니라 전환·매출로 성과를 정의합니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>크리에이티브 내재화</strong>
                        <span>촬영·편집·디자인이 사내에 있어 빠르게 실행합니다.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- S5 ⭐ 아나키 섹션 [파치먼트] — 작게 (id=anarchy) --}}
        <section class="landing__section landing__section--parchment" id="anarchy">
            <div class="landing__inner">
                <span class="landing__eyebrow">Anarchy · 유튜브</span>
                <h2 class="landing__head">총괄이사가 직접 운영하는 유튜브 채널</h2>
                <p class="landing__body">마케팅 현장의 이야기를 콘텐츠로 풉니다. 이론이 아니라 실제로
                   돌려본 것만 다룹니다. 유튜브 채널 ‘아나키’.</p>
                <ul class="landing__evidence">
                    <li>구독 5.06만 · 영상 248개 · 누적 조회 239만+</li>
                </ul>
                <div class="cta-row" style="margin-top:24px;">
                    <a class="btn-ghost" href="https://www.youtube.com/@anarchy" target="_blank" rel="noopener">채널 보기 →</a>
                </div>
            </div>
        </section>

        {{-- S6 연혁 [라이트] — 확정분만. 세부는 [자료 필요] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">History</span>
                <h2 class="landing__head">걸어온 길</h2>
                <ul class="landing__evidence">
                    <li><strong>2009</strong> — (주)제이커브인터렉티브 법인 설립</li>
                    <li><strong>2011</strong> — 유튜브 채널 ‘아나키’ 개설</li>
                    <li><strong>현재</strong> — 자체 솔루션 4종(랭크프리·부스팅샵·리드베이·콜투세일) 운영</li>
                </ul>
                {{-- ⚠️ [자료 필요] 벤처인증·연구소 등 세부 연혁은 대웅 확인 후 추가 --}}
            </div>
        </section>

        {{-- S8 최종 CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>마케팅, 한 팀에서 끝내세요</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">프로젝트 문의하기</a>
                </div>
            </div>
        </section>
    </main>
@endsection
