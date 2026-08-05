@extends('layouts.app')

@section('title', '리워드 네트워크 — 액션을 만드는 광고 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="사용자가 리워드를 받고 앱 설치·회원가입·미션을 완료합니다. 광고주에게는 실제 액션이, 매체에는 수익이 남는 리워드 네트워크를 양방향으로 운영합니다.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        {{-- ⚠️ 경쟁사명(버즈빌·애드팝콘·NBT) meta·본문 금지. "리워드 네트워크 카테고리"로만. --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Reward Network</span>
                <h1>리워드 네트워크 — 액션을 만드는 광고</h1>
                <p class="landing__lead">사용자가 리워드를 받고 앱 설치·회원가입·미션을 완료합니다.
                   광고주에게는 실제 액션이, 매체에는 수익이 남는 구조입니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">광고주 문의</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">매체 제휴 문의</a>
                </div>
            </div>
        </section>

        {{-- ① 문제 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">“설치 수는 늘었는데, 진짜 유저가 없다.”</h2>
                <p class="landing__body">단순 노출형 광고는 ‘보기만 한’ 유저를 데려옵니다.
                   리워드 네트워크는 실제로 행동한 유저를 데려오되, 그 행동의 ‘질’을
                   관리하지 못하면 어뷰징만 남습니다. 관건은 네트워크 운영 능력입니다.</p>
            </div>
        </section>

        {{-- ② 방법 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Method</span>
                <h2 class="landing__head">광고주와 매체, 양쪽을 직접 운영합니다</h2>
                <div class="landing__points">
                    <div class="landing__point">
                        <strong>광고주 측</strong>
                        <span>목표 액션(CPI·CPA·CPE) 설계 + 물량·단가 최적화.</span>
                    </div>
                    <div class="landing__point">
                        <strong>매체(앱) 측</strong>
                        <span>오퍼월·리워드 지면 연동, 수익화 세팅.</span>
                    </div>
                    <div class="landing__point">
                        <strong>품질 관리</strong>
                        <span>어뷰징·무효 전환 필터로 실 유저만 정산.</span>
                    </div>
                    <div class="landing__point">
                        <strong>리포팅</strong>
                        <span>액션별 전환·리텐션까지 추적(설치 후 잔존 관점).</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ③ 증거 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Evidence</span>
                <h2 class="landing__head">양방향 운영 경험</h2>
                <ul class="landing__evidence">
                    <li>광고주·매체 양방향 운영 경험 — 리워드 광고 전문사로 포지셔닝</li>
                    <li>CPA 마케팅과 연계 — 리워드 인벤토리를 CPA 물량 소싱에 활용</li>
                </ul>
            </div>
        </section>

        {{-- ⑥ 최종 CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>광고주라면 액션을, 매체라면 수익을 — 양쪽 다 상담합니다</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">광고주 문의</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">매체 제휴 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
