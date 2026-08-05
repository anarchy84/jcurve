@extends('layouts.app')

@section('title', '랭크프리 — 네이버 순위·시장 분석 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="키워드만 넣으면 플레이스·쇼핑 순위, 경쟁사, 시장 규모까지. 가입 없이 30초, 대부분 무료인 네이버 마케팅 분석 솔루션 랭크프리.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위">
                    <a href="{{ route('solutions.index') }}">솔루션</a>
                </nav>
                <span class="landing__eyebrow">RankFree</span>
                <h1>네이버 마케팅, 순위부터 시장까지 한눈에</h1>
                <p class="landing__lead">키워드만 넣으면 플레이스·쇼핑 순위, 경쟁사, 시장 규모까지.
                   가입 없이 30초, 대부분 무료입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://rankfree.kr/register" target="_blank" rel="noopener">무료로 시작 →</a>
                </div>
                <p class="landing__body" style="margin-top:20px;color:var(--text-muted);">이미 1,200+ 사장님이 순위를 확인했습니다.</p>
            </div>
        </section>

        {{-- ① 문제 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">“순위가 왜 떨어졌는지, 아무도 안 알려준다.”</h2>
                <p class="landing__body">순위 체크만 해주는 툴은 많습니다. 정작 ‘왜 떨어졌나’는 답이 없죠.
                   리뷰가 부족한지, 저장수가 밀리는지, 어떤 키워드에서 빠지는지 —
                   그 근거가 있어야 개선을 합니다.</p>
            </div>
        </section>

        {{-- ② 방법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">분석 축</span>
                <h2 class="landing__head">순위 확인만? 분석까지 한 번에.</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>플레이스</strong>
                        <span>순위 추적 + 상위 30위 경쟁사 비교 + SEO 점수 진단.</span>
                    </div>
                    <div class="landing__point">
                        <strong>쇼핑</strong>
                        <span>순위 추적 + 6개월 시장 규모·매출 추정 + 셀러력·리뷰 분석.</span>
                    </div>
                    <div class="landing__point">
                        <strong>키워드</strong>
                        <span>검색량·트렌드 + 기회점수로 ‘황금 키워드’ 발굴 + 엑셀 대량분석.</span>
                    </div>
                    <div class="landing__point">
                        <strong>블로그 · API</strong>
                        <span>상위 블로거 지수화, 순위 API로 내 서비스에 데이터 연동.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ③ 증거·요금 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">요금</span>
                <h2 class="landing__head">무료로 시작해서, 필요할 때 확장</h2>
                <ul class="landing__evidence">
                    <li><strong>무료</strong> — 순위체크 100개 / 플레이스·경쟁분석 월 5회 / 키워드·블로그·쇼핑 분석</li>
                    <li><strong>프로 29,000원/월</strong> — 순위체크 무제한 + 자동추적·알림 + 순위 API</li>
                    <li><strong>마케팅 대행</strong> — 맞춤 견적 (분석 + 실행까지)</li>
                </ul>
                {{-- ⚠️ 필수 고지(실사이트 명시) — 반드시 노출 [Evidence Guardian] --}}
                <p class="landing__note">순위·점수(N1·N2·N3)는 자체 수집·분석 기반 추정치이며 네이버 공식 지표가 아닙니다.</p>
            </div>
        </section>

        {{-- ④ 연결 + CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>분석에서 끝나지 않습니다 — 실행까지 연결</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">플레이스 최적화·블로그·광고 대행으로 이어집니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://rankfree.kr/register" target="_blank" rel="noopener">무료로 시작 →</a>
                    <a class="btn-ghost" href="{{ route('services.show', ['slug' => 'seo']) }}">SEO 대행 보기</a>
                </div>
            </div>
        </section>
    </main>
@endsection
