@extends('layouts.app')

@section('title', '회사소개 — 2009년부터, 숫자로 말해왔습니다 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="2009년 시작. 보여준 값이 아니라 만들어낸 값으로 말해온 회사. 373억 집행·15,700 캠페인·128만 DB, 그리고 필요해서 직접 만든 자체 솔루션 4종.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">About</span>
                <h1>2009년부터, 숫자로 말해왔습니다</h1>
                <p class="landing__lead">광고 시장이 ‘노출’을 팔던 시절에 시작했습니다.
                   그때부터 지금까지 지킨 기준은 하나 — 보여준 값이 아니라 만들어낸 값으로 말할 것.</p>
            </div>
        </section>

        {{-- 우리는 — 연대기 서사 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Our story</span>
                <h2 class="landing__head">우리는 이렇게 일해왔습니다</h2>
                <div class="prose">
                    <p>우리는 2009년에 시작했습니다. 광고 시장이 ‘노출’을 팔던 시절이었죠. 그때부터 지금까지 한 가지 기준을 지켰습니다 — 보여준 값이 아니라 만들어낸 값으로 말할 것.</p>
                    <p>그 기준으로 373억 원의 광고비를 집행했고, 15,700개의 캠페인을 돌렸고, 128만 건의 DB를 만들었습니다.</p>
                </div>
            </div>
        </section>

        {{-- 숫자 [다크] — 홈 stat 재사용 [검증 V2] 회사 전체 누적 --}}
        <section class="home__stats has-orb" aria-label="회사 핵심 지표">
            <div class="home__stats-inner">
                <div class="stat glass-card">
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

        {{-- 도구를 만들다 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <span class="landing__eyebrow">Products</span>
                <h2 class="landing__head">도구가 없으면, 만들었습니다</h2>
                <div class="prose">
                    <p>순위 분석이 필요해서 랭크프리를 만들었고, 보험 영업 관리가 엉망이라 리드베이와 콜투세일을 만들었고, 셀프 마케팅 수요가 보여서 부스팅샵을 열었습니다.</p>
                    <p>대행사가 소프트웨어를 만드는 건 흔치 않은 길이지만, 현장에 필요하면 만드는 게 저희 방식입니다.</p>
                </div>
                <div class="subcards">
                    <a class="subcard" href="{{ route('solutions.rankfree') }}"><strong>랭크프리</strong><span>네이버 순위·시장 분석 →</span></a>
                    <a class="subcard" href="{{ route('solutions.boostingshop') }}"><strong>부스팅샵</strong><span>셀프 마케팅 →</span></a>
                    <a class="subcard" href="{{ route('solutions.leadbay') }}"><strong>리드베이</strong><span>보험 영업 CRM →</span></a>
                    <a class="subcard" href="{{ route('solutions.call2sale') }}"><strong>콜투세일</strong><span>보험DB 콜센터 CRM →</span></a>
                </div>
            </div>
        </section>

        {{-- 아나키 섹션 [파치먼트] — 작게 (id=anarchy) --}}
        <section class="landing__section landing__section--parchment" id="anarchy">
            <div class="landing__inner">
                <span class="landing__eyebrow">Anarchy · 유튜브</span>
                <h2 class="landing__head">2011년엔, 유튜브 채널도 열었습니다</h2>
                <div class="prose">
                    <p>총괄이사가 직접 운영하는 ‘아나키’ — 마케팅 현장 이야기를 하는 채널입니다. 이론이 아니라 실제로 돌려본 것만 다룹니다.</p>
                </div>
                <ul class="landing__evidence">
                    <li>구독 5.06만 · 영상 248개 · 누적 조회 239만+</li>
                </ul>
                <div class="cta-row" style="margin-top:24px;">
                    <a class="btn-ghost" href="https://www.youtube.com/@anarchy" target="_blank" rel="noopener">채널 보기 →</a>
                </div>
            </div>
        </section>

        {{-- 다음 10년 + CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>광고를 파는 회사가 아니라, 성과를 만드는 회사로</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">지금 우리는 검색과 AI의 경계에서 다음 10년을 준비하고 있습니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">프로젝트 문의하기</a>
                </div>
            </div>
        </section>
    </main>
@endsection
