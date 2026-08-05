@extends('layouts.app')

@section('title', '리워드 네트워크 — 유저는 리워드를, 광고주는 액션을 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="유저는 리워드를 얻고 광고주는 액션을 얻습니다. 그 사이 품질을 지키는 것이 네트워크의 일. 제이커브는 광고주와 매체 양쪽을 모두 직접 운영합니다.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        {{-- ⚠️ 경쟁사명(버즈빌·애드팝콘·NBT) meta·본문 금지 --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Reward Network</span>
                <h1>유저는 리워드를 얻고, 광고주는 액션을 얻습니다</h1>
                <p class="landing__lead">그 사이에서 품질을 지키는 게 네트워크의 일입니다.
                   제이커브는 광고주와 매체, 양쪽을 모두 직접 운영합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">광고주 문의</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">매체 제휴 문의</a>
                </div>
            </div>
        </section>

        {{-- ① 3자 관계도 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">리워드 광고는 삼각형입니다</h2>
                <div class="landing__points">
                    <div class="landing__point landing__point--light">
                        <strong>유저</strong>
                        <span>미션을 수행하고 포인트를 받습니다. 광고를 ‘당하는’ 게 아니라 ‘참여’합니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>광고주</strong>
                        <span>설치·가입·미션완료, 실제 액션에만 비용을 냅니다.</span>
                    </div>
                    <div class="landing__point landing__point--light">
                        <strong>매체(앱)</strong>
                        <span>오퍼월 지면을 열고 수익을 만듭니다.</span>
                    </div>
                </div>
                <div class="prose" style="margin-top:24px;">
                    <p>셋 중 하나라도 손해 보면 무너지는 구조입니다. 그래서 네트워크 운영의 핵심은 물량이 아니라 균형입니다.</p>
                </div>
            </div>
        </section>

        {{-- ② 광고주 트랙 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">For Advertisers</span>
                <h2 class="landing__head">광고주께는 — ‘설치 수’가 아니라 ‘남는 유저’를</h2>
                <div class="prose">
                    <p style="color:var(--on-dark);">리워드 광고의 고질병을 압니다. 설치는 쏟아지는데 다음날 잔존율이 바닥인 것. 그래서 저희는 액션 설계 단계부터 다르게 갑니다.</p>
                    <p style="color:var(--muted-on-dark);">단순 설치가 아니라 튜토리얼 완료·레벨 도달 같은 심화 액션으로 과금 지점을 미루면, 포인트만 먹고 떠나는 유저가 걸러집니다. 어뷰징 필터는 그 다음 방어선이고요.</p>
                </div>
            </div>
        </section>

        {{-- ③ 매체 트랙 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">For Publishers</span>
                <h2 class="landing__head">매체께는 — 지면이 돈이 되도록</h2>
                <div class="prose">
                    <p>앱에 오퍼월·리워드 지면을 붙이는 순간부터 정산까지 저희가 함께합니다. 유저 이탈 없이 수익을 만드는 지면 설계, 캠페인 소싱, 투명한 리포팅.</p>
                    <p>광고주 쪽 물량을 직접 돌리고 있어서 지면에 캠페인이 마르지 않습니다.</p>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>어느 쪽이셔도, 대화는 구체적일 겁니다</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">광고주 문의</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">매체 제휴 문의</a>
                </div>
            </div>
        </section>
    </main>
@endsection
