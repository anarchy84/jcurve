@extends('layouts.app')

@section('title', '무료 SEO · GEO·AEO 진단 — URL 하나로 온페이지 + AI 답변 최적화 점검 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="주소만 넣으면 타이틀·메타·H1·모바일부터 구조화 데이터·스키마 타입·답변형 구조까지 SEO와 GEO·AEO(AI 답변 최적화)를 즉석 점검합니다. 무료.">
@endsection

@section('content')
    <main class="landing seocheck">
        {{-- 히어로 + 입력 --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Free SEO · GEO·AEO Check</span>
                <h1>주소 하나로, SEO와 AI 답변 최적화까지 봅니다</h1>
                <p class="landing__lead">타이틀·메타·H1·모바일 같은 온페이지 SEO부터 구조화 데이터·스키마 타입·답변형 구조 같은
                   GEO·AEO(AI 답변 최적화)까지 즉석 점검합니다. 백링크·키워드 정밀 분석은 제이커브가 이어서 도와드립니다.</p>

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
                                <span class="landing__eyebrow">On-Page + AI Result</span>
                                <h2 class="landing__head">SEO + GEO·AEO 종합 점수</h2>
                                <p class="landing__lead" style="margin:0;word-break:break-all;">{{ $result['url'] }}</p>
                                @if (! empty($result['catScores']))
                                    <div class="seocheck__subscores">
                                        @isset($result['catScores']['seo'])
                                            <span class="seocheck__subscore seocheck__subscore--{{ strtolower($result['catScores']['seo']['grade']) }}">온페이지 SEO <strong>{{ $result['catScores']['seo']['score'] }}</strong></span>
                                        @endisset
                                        @isset($result['catScores']['geo'])
                                            <span class="seocheck__subscore seocheck__subscore--{{ strtolower($result['catScores']['geo']['grade']) }}">GEO·AEO <strong>{{ $result['catScores']['geo']['score'] }}</strong></span>
                                        @endisset
                                    </div>
                                @endif
                                <div class="seocheck__actions">
                                    <a class="btn-primary" href="{{ route('seo.check.pdf', ['url' => $result['url']]) }}">리포트 PDF 다운로드 ↓</a>
                                </div>
                            </div>
                        </div>

                        @php
                            $groups = collect($result['checks'])->groupBy(fn ($ck) => $ck['category'] ?? 'seo');
                            $sections = [
                                'seo' => ['온페이지 SEO', '검색엔진이 페이지를 읽고 순위 매기는 기본 요소'],
                                'geo' => ['GEO · AEO (AI 답변 최적화)', 'AI 검색·챗봇이 이 페이지를 인용하도록 만드는 요소'],
                            ];
                        @endphp
                        @foreach ($sections as $cat => $meta)
                            @if ($groups->has($cat))
                                <div class="seocheck__group">
                                    <h3 class="seocheck__grouptitle">
                                        {{ $meta[0] }}
                                        @isset($result['catScores'][$cat])
                                            <span class="seocheck__grouptitle-score">{{ $result['catScores'][$cat]['score'] }}점</span>
                                        @endisset
                                    </h3>
                                    <p class="seocheck__groupdesc">{{ $meta[1] }}</p>
                                    <ul class="seocheck__list">
                                        @foreach ($groups->get($cat) as $ck)
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
                            @endif
                        @endforeach
                    </div>
                </section>

                {{-- 백링크 프로필 (지금은 샘플 데이터 — 유료 API 키 확보 시 실데이터로 교체) --}}
                @isset($backlinks)
                    <section class="landing__section landing__section--parchment" id="backlinks">
                        <div class="landing__inner landing__inner--wide">
                            <span class="landing__eyebrow">Backlink Profile</span>
                            <h2 class="landing__head">
                                백링크 프로필
                                @if (! empty($backlinks['sample']))
                                    <span class="seocheck__sample-badge">샘플 데이터</span>
                                @endif
                            </h2>
                            @if (! empty($backlinks['sample']))
                                <p class="landing__note" style="margin-top:-8px;">아래 수치는 레이아웃 확인용 <strong>예시</strong>입니다. 실제 백링크 데이터 연동(Ahrefs 등)은 준비 중입니다.</p>
                            @endif

                            <div class="seocheck__blstats">
                                <div class="seocheck__blstat"><strong>{{ $backlinks['domain_rating'] }}</strong><span>도메인 등급 (DR)</span></div>
                                <div class="seocheck__blstat"><strong>{{ number_format($backlinks['referring_domains']) }}</strong><span>참조 도메인</span></div>
                                <div class="seocheck__blstat"><strong>{{ number_format($backlinks['total_backlinks']) }}</strong><span>전체 백링크</span></div>
                                <div class="seocheck__blstat"><strong>{{ round($backlinks['dofollow_ratio'] * 100) }}%</strong><span>Dofollow 비율</span></div>
                            </div>

                            <h3 class="seocheck__grouptitle" style="margin-top:32px;">상위 백링크</h3>
                            <div class="seocheck__bltable-wrap">
                                <table class="seocheck__bltable">
                                    <thead>
                                        <tr><th scope="col">참조 페이지</th><th scope="col">DR</th><th scope="col">앵커 텍스트</th><th scope="col">유형</th><th scope="col">최초 발견</th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($backlinks['top'] as $bl)
                                            <tr>
                                                <td class="seocheck__blurl">{{ $bl['domain'] }}<span>{{ \Illuminate\Support\Str::after($bl['url'], $bl['domain']) }}</span></td>
                                                <td class="seocheck__bldr">{{ $bl['dr'] }}</td>
                                                <td>{{ $bl['anchor'] }}</td>
                                                <td><span class="seocheck__bltype seocheck__bltype--{{ $bl['type'] }}">{{ $bl['type'] }}</span></td>
                                                <td>{{ $bl['first_seen'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                @endisset

                {{-- 오가닉 키워드 (샘플) --}}
                @isset($keywords)
                    <section class="landing__section landing__section--light" id="keywords">
                        <div class="landing__inner landing__inner--wide">
                            <span class="landing__eyebrow">Organic Keywords</span>
                            <h2 class="landing__head">
                                오가닉 키워드
                                @if (! empty($keywords['sample'])) <span class="seocheck__sample-badge">샘플 데이터</span> @endif
                            </h2>
                            @if (! empty($keywords['sample']))
                                <p class="landing__note" style="margin-top:-8px;">검색에서 걸리는 키워드·순위·검색량 <strong>예시</strong>입니다. 실데이터 연동(Ahrefs·Semrush 등)은 준비 중입니다.</p>
                            @endif
                            <div class="seocheck__blstats">
                                <div class="seocheck__blstat"><strong>{{ number_format($keywords['total_keywords']) }}</strong><span>노출 키워드</span></div>
                                <div class="seocheck__blstat"><strong>{{ number_format($keywords['top3']) }}</strong><span>TOP 3 키워드</span></div>
                                <div class="seocheck__blstat"><strong>{{ number_format($keywords['top10']) }}</strong><span>TOP 10 키워드</span></div>
                            </div>
                            <h3 class="seocheck__grouptitle" style="margin-top:32px;">상위 키워드</h3>
                            <div class="seocheck__bltable-wrap">
                                <table class="seocheck__bltable">
                                    <thead>
                                        <tr><th scope="col">키워드</th><th scope="col">순위</th><th scope="col">월 검색량</th><th scope="col">트래픽 점유</th><th scope="col">의도</th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($keywords['keywords'] as $kw)
                                            <tr>
                                                <td class="seocheck__blurl">{{ $kw['keyword'] }}<span>{{ $kw['url'] }}</span></td>
                                                <td class="seocheck__bldr">{{ $kw['position'] }}위</td>
                                                <td>{{ number_format($kw['volume']) }}</td>
                                                <td>{{ $kw['share'] }}%</td>
                                                <td>{{ $kw['intent'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                @endisset

                {{-- 트래픽 추정 (샘플) --}}
                @isset($traffic)
                    @php($trMax = collect($traffic['trend'])->max('visits') ?: 1)
                    <section class="landing__section landing__section--parchment" id="traffic">
                        <div class="landing__inner landing__inner--wide">
                            <span class="landing__eyebrow">Traffic Estimate</span>
                            <h2 class="landing__head">
                                트래픽 추정
                                @if (! empty($traffic['sample'])) <span class="seocheck__sample-badge">샘플 데이터</span> @endif
                            </h2>
                            @if (! empty($traffic['sample']))
                                <p class="landing__note" style="margin-top:-8px;">월 방문·추정 가치·유입 채널 <strong>예시</strong>입니다. 실데이터 연동(Ahrefs·SimilarWeb·GSC)은 준비 중입니다.</p>
                            @endif
                            <div class="seocheck__blstats">
                                <div class="seocheck__blstat"><strong>{{ number_format($traffic['monthly_visits']) }}</strong><span>월 오가닉 방문(추정)</span></div>
                                <div class="seocheck__blstat"><strong>₩{{ number_format($traffic['traffic_value_krw']) }}</strong><span>월 트래픽 가치(추정)</span></div>
                                <div class="seocheck__blstat"><strong>{{ $traffic['channels'][0]['pct'] }}%</strong><span>오가닉 검색 비중</span></div>
                                <div class="seocheck__blstat"><strong>{{ $traffic['countries'][0]['pct'] }}%</strong><span>{{ $traffic['countries'][0]['name'] }} 비중</span></div>
                            </div>

                            <div class="seocheck__trafgrid">
                                <div>
                                    <h3 class="seocheck__grouptitle" style="margin-top:28px;">최근 6개월 추이</h3>
                                    <div class="seocheck__trend">
                                        @foreach ($traffic['trend'] as $t)
                                            <div class="seocheck__trend-col">
                                                <div class="seocheck__trend-bar" style="height:{{ max(6, round($t['visits'] / $trMax * 100)) }}%"></div>
                                                <span class="seocheck__trend-m">{{ $t['month'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <h3 class="seocheck__grouptitle" style="margin-top:28px;">유입 채널</h3>
                                    <div class="seocheck__channels">
                                        @foreach ($traffic['channels'] as $ch)
                                            <div class="seocheck__channel">
                                                <span class="seocheck__channel-name">{{ $ch['name'] }}</span>
                                                <span class="seocheck__channel-track"><span class="seocheck__channel-fill" style="width:{{ $ch['pct'] }}%"></span></span>
                                                <span class="seocheck__channel-pct">{{ $ch['pct'] }}%</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endisset

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
