@extends('layouts.app')

@section('title', '무료 SEO 진단 — URL 하나로 온페이지 점검 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="주소만 넣으면 타이틀·메타·H1·모바일·구조화 데이터까지 온페이지 SEO를 즉석 점검합니다. 백링크·키워드 정밀 분석은 제이커브에 문의하세요.">
@endsection

@section('content')
    <main class="landing seocheck">
        {{-- 히어로 + 입력 --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Free SEO Check</span>
                <h1>주소 하나로, 지금 SEO 상태를 봅니다</h1>
                <p class="landing__lead">타이틀·메타 설명·H1·모바일·구조화 데이터까지 온페이지 요소를 즉석 점검합니다.
                   백링크·키워드 순위 같은 정밀 분석은 제이커브가 이어서 도와드립니다.</p>

                <form class="seocheck__form" method="GET" action="{{ route('seo.check') }}" role="search">
                    <input type="url" name="url" inputmode="url" autocomplete="url"
                           placeholder="https://example.com" value="{{ $inputUrl }}"
                           aria-label="분석할 웹사이트 주소" required>
                    <button type="submit" class="btn-primary">무료로 진단 →</button>
                </form>
                <p class="seocheck__hint">공개된 웹페이지만 분석하며, 입력 주소는 저장하지 않습니다.</p>
            </div>
        </section>

        @isset($result)
            @if (! $result['ok'])
                <section class="landing__section landing__section--light">
                    <div class="landing__inner">
                        <div class="seocheck__error" role="alert">
                            <strong>분석할 수 없습니다.</strong>
                            <span>{{ $result['error'] }}</span>
                        </div>
                    </div>
                </section>
            @else
                {{-- 점수 + 체크리스트 --}}
                <section class="landing__section landing__section--light" id="result">
                    <div class="landing__inner landing__inner--wide">
                        <div class="seocheck__scoreband">
                            <div class="seocheck__score seocheck__score--{{ strtolower($result['grade']) }}">
                                <strong>{{ $result['score'] }}</strong><span>/ 100</span>
                                <em>{{ $result['grade'] }}</em>
                            </div>
                            <div class="seocheck__scoremeta">
                                <span class="landing__eyebrow">On-Page Result</span>
                                <h2 class="landing__head">온페이지 SEO 점수</h2>
                                <p class="landing__lead" style="margin:0;word-break:break-all;">{{ $result['url'] }}</p>
                            </div>
                        </div>

                        <ul class="seocheck__list">
                            @foreach ($result['checks'] as $ck)
                                <li class="seocheck__item seocheck__item--{{ $ck['status'] }}">
                                    <span class="seocheck__badge" aria-hidden="true">
                                        @if ($ck['status'] === 'pass') ✓ @elseif ($ck['status'] === 'warn') ! @else × @endif
                                    </span>
                                    <div class="seocheck__itembody">
                                        <strong>{{ $ck['label'] }}</strong>
                                        <span>{{ $ck['detail'] }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>

                {{-- 백링크·키워드: 유료 데이터 영역 → 리드 전환 (어댑터 연동 시 실데이터로 교체) --}}
                <section class="landing__section landing__section--dark has-orb">
                    <div class="landing__inner landing__inner--wide">
                        <span class="landing__eyebrow">Deeper Analysis</span>
                        <h2 class="landing__head">백링크·키워드 순위·트래픽까지 보려면</h2>
                        <p class="landing__lead">도메인 등급(DR), 참조 도메인, 상위 키워드와 경쟁사 비교는 온페이지 너머의 정밀 데이터입니다.
                           제이커브가 실데이터로 분석해 드립니다.</p>
                        <div class="landing__points">
                            <div class="landing__point"><strong>백링크 · 참조 도메인</strong><span>누가 우리를 링크하는지, 링크 품질과 위험 요소.</span></div>
                            <div class="landing__point"><strong>키워드 순위 · 기회</strong><span>지금 걸린 키워드와 놓치고 있는 검색 수요.</span></div>
                            <div class="landing__point"><strong>경쟁사 비교</strong><span>같은 시장에서 상대적 위치와 격차.</span></div>
                            <div class="landing__point"><strong>AI 검색 노출(AEO·GEO)</strong><span>AI 답변에 인용되는 구조인지 점검.</span></div>
                        </div>
                        <div class="cta-row" style="margin-top:32px;">
                            <a class="btn-primary" href="{{ route('contact') }}?ref=seo-check">정밀 SEO 분석 문의</a>
                            <a class="btn-ghost" href="{{ route('services.show', ['slug' => 'seo']) }}">SEO 서비스 보기</a>
                        </div>
                    </div>
                </section>
            @endif
        @endisset
    </main>
@endsection
