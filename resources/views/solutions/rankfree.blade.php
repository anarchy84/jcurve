@extends('layouts.app')

@section('title', '랭크프리 — 사장님, 지금 몇 등인지 아세요? | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="키워드만 넣으면 30초, 가입도 필요 없이 네이버 플레이스·쇼핑·블로그 순위와 경쟁사·시장 규모까지. 대부분 무료인 네이버 마케팅 분석 툴, 랭크프리.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <nav class="subpage__breadcrumb" aria-label="상위"><a href="{{ route('solutions.index') }}">솔루션</a></nav>
                <span class="landing__eyebrow">RankFree</span>
                <h1>사장님, 지금 몇 등인지 아세요?</h1>
                <p class="landing__lead">키워드만 넣으면 30초 안에 나옵니다. 가입도 필요 없어요.
                   네이버 플레이스·쇼핑·블로그 순위, 경쟁사 비교, 시장 규모까지 — 대부분 무료입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="https://rankfree.kr" target="_blank" rel="noopener">무료로 순위 확인 →</a>
                </div>
                <p class="landing__body" style="margin-top:20px;color:var(--text-muted);">이미 1,200+ 사장님이 확인했습니다.</p>
            </div>
        </section>

        {{-- ① 왜 만들었나 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">대행사가 왜 무료 툴을 만들었냐면요</h2>
                <div class="prose">
                    <p>상담 올 때마다 같은 질문을 받았거든요. “우리 지금 몇 등이에요?” “경쟁집은요?”</p>
                    <p>그래서 그냥 만들었습니다. 누구나 직접 확인할 수 있게. 순위를 알아야 대화가 시작되니까요. 그 다음에 뭘 할지는, 그때 정하시면 됩니다.</p>
                </div>
            </div>
        </section>

        {{-- ② 기능 4축 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">기능</span>
                <h2 class="landing__head">순위 확인만? 분석까지 한 번에.</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>플레이스</strong>
                        <span>순위가 왜 떨어졌는지 데이터로 답합니다. 리뷰가 밀리는지, 저장수가 딸리는지.</span>
                    </div>
                    <div class="landing__point">
                        <strong>쇼핑</strong>
                        <span>뛰어들기 전에 시장부터 보세요. 6개월 규모·매출 추정·경쟁 구도.</span>
                    </div>
                    <div class="landing__point">
                        <strong>키워드</strong>
                        <span>검색량 높고 경쟁 낮은 ‘황금 키워드’, 기회 점수로 찾아드립니다.</span>
                    </div>
                    <div class="landing__point">
                        <strong>블로그</strong>
                        <span>체험단 섭외 전에 그 블로거 진짜 영향력부터 확인하세요.</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ③ 요금 + 필수 고지 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">요금</span>
                <h2 class="landing__head">무료로 시작해서, 필요할 때 확장</h2>
                <ul class="landing__evidence">
                    <li><strong>무료 0원</strong> — 순위체크 100개 · 분석 월 5회</li>
                    <li><strong>프로 29,000원/월</strong> — 무제한 + 자동추적 알림 + API</li>
                    <li><strong>마케팅 대행</strong> — 분석에서 실행까지, 맞춤 견적</li>
                </ul>
                {{-- 필수 고지 [Evidence Guardian] --}}
                <p class="landing__note">순위·점수(N1·N2·N3)는 자체 수집·분석 기반 추정치이며 네이버 공식 지표가 아닙니다.</p>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>지금, 내 순위부터 확인해 보세요</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="https://rankfree.kr" target="_blank" rel="noopener">무료로 순위 확인 →</a>
                    <a class="btn-ghost" href="{{ route('services.show', ['slug' => 'seo']) }}">SEO 대행 보기</a>
                </div>
            </div>
        </section>
    </main>
@endsection
