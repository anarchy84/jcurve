@extends('layouts.app')

@section('title', '성과와 운영 기준 — 결과를 어떻게 만들고 읽는가 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="공개 동의와 근거가 있는 사례만 소개합니다. 제이커브인터렉티브가 목표를 정의하고 실행·측정·학습하는 방식과 공개 성과 사례를 확인하세요.">
@endsection

@section('content')
    <main class="listing landing">
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">Work & Evidence</span>
                <h1>좋은 숫자보다,<br>그 숫자가 만들어진 구조를 봅니다</h1>
                <p class="landing__lead">성과 사례는 결과만 자랑하는 페이지가 아닙니다. 어떤 문제를 정의했고, 무엇을 바꿨으며, 어떤 기준으로 결과를 판단했는지까지 공개 가능한 범위에서 설명합니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="#cases">공개 사례 보기</a>
                    <a class="btn-ghost" href="#principles">성과 원칙 보기</a>
                </div>
            </div>
        </section>

        <section class="home__stats has-orb" aria-label="회사 전체 누적 운영 지표">
            <div class="home__stats-inner">
                <div class="stat glass-card"><strong data-count-to="373" data-count-suffix="억+">373억+</strong><span>2026년 기준 · 회사 전체 누적 집행 광고비</span></div>
                <div class="stat glass-card"><strong data-count-to="128" data-count-suffix="만+">128만+</strong><span>2026년 기준 · 회사 전체 누적 수집 DB</span></div>
                <div class="stat glass-card"><strong data-count-to="15700" data-count-suffix="+" data-count-comma="1">15,700+</strong><span>2026년 기준 · 회사 전체 누적 진행 캠페인</span></div>
                <div class="stat glass-card"><strong data-count-to="2009" data-count-suffix="년">2009년</strong><span>법인 설립</span></div>
            </div>
        </section>

        <section class="landing__section landing__section--light" id="principles">
            <div class="landing__inner">
                <span class="landing__eyebrow">How We Read Results</span>
                <h2 class="landing__head">서비스마다 성적표가 달라야 합니다</h2>
                <div class="landing__points">
                    <div class="landing__point landing__point--light"><strong>커머스</strong><span>매출만 보지 않고 구매당 비용, 신규 고객, 객단가와 마진 구조를 함께 봅니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>리드 비즈니스</strong><span>DB 건수보다 유효 기준, 상담 연결, 다음 영업 단계로 이어졌는지 확인합니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>앱·서비스</strong><span>설치에서 멈추지 않고 가입, 활성화, 핵심 기능 경험처럼 사업 가치에 가까운 행동을 봅니다.</span></div>
                    <div class="landing__point landing__point--light"><strong>검색·콘텐츠</strong><span>순위 한 칸보다 색인, 노출 검색어, 클릭 후 행동과 전환까지 연결해 판단합니다.</span></div>
                </div>
            </div>
        </section>

        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Case Anatomy</span>
                <h2 class="landing__head">사례는 네 가지 질문으로 씁니다</h2>
                <div class="steps">
                    <div class="steps__item"><strong>무엇이 문제였나</strong><p>광고, 페이지, 측정, 영업 운영 중 실제 병목이 어디였는지 설명합니다.</p></div>
                    <div class="steps__item"><strong>무엇을 바꿨나</strong><p>예산·소재·타깃·전환 구조에서 바꾼 범위를 구체적으로 구분합니다.</p></div>
                    <div class="steps__item"><strong>어떻게 측정했나</strong><p>비교 기간, 전환 정의, 데이터 출처와 해석상 제한을 함께 적습니다.</p></div>
                    <div class="steps__item"><strong>다음에 무엇을 배웠나</strong><p>결과를 복제 가능한 원리와 다음 실험으로 연결합니다.</p></div>
                </div>
            </div>
        </section>

        <section class="listing__body" id="cases">
            <div style="max-width:var(--container);margin:0 auto;">
                <span class="landing__eyebrow">Published Cases</span>
                <h2 class="landing__head">공개 성과 사례</h2>
                @if ($works->count())
                    <div class="listing__grid">
                        @foreach ($works as $work)
                            <a class="work-preview" href="{{ route('work.show', $work) }}">
                                <span class="work-preview__thumb" aria-hidden="true">
                                    @if ($work->cover_image)<img src="{{ asset($work->cover_image) }}" alt="" loading="lazy" width="1280" height="720">@endif
                                </span>
                                @if ($work->client || $work->industry)
                                    <span class="work-preview__meta">{{ $work->client }}@if ($work->client && $work->industry) · @endif{{ $work->industry }}</span>
                                @endif
                                @php
                                    $metric = null;
                                    $metrics = $work->metrics; // 오버로드 속성 직접 reset() 방지 위해 로컬 복사
                                    if (is_array($metrics) && count($metrics)) {
                                        $first = reset($metrics);
                                        if (is_array($first)) {
                                            $metric = ['value' => $first['value'] ?? null, 'label' => $first['label'] ?? null];
                                        } else {
                                            $k = array_key_first($metrics);
                                            $metric = ['value' => $metrics[$k], 'label' => is_string($k) ? $k : null];
                                        }
                                    }
                                @endphp
                                @if ($metric && ! empty($metric['value']))
                                    <span class="work-preview__metric">{{ $metric['value'] }}@if ($metric['label'])<small>{{ $metric['label'] }}</small>@endif</span>
                                @endif
                                <span class="work-preview__title">{{ $work->title }}</span>
                                <span class="work-preview__link">사례 보기 →</span>
                            </a>
                        @endforeach
                    </div>
                    <div class="listing__pagination">{{ $works->links('partials.pagination') }}</div>
                @else
                    <div class="listing__empty">
                        <h3 class="landing__head" style="font-size:28px;">현재 공개 승인된 개별 사례가 없습니다</h3>
                        <p class="landing__lead">개별 사례는 공개 등록 전에 고객사 공개 동의와 성과 근거를 수동으로 확인합니다. 가상의 사례나 익명 수치를 만들어 채우지 않습니다.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Evidence Rules</span>
                <h2 class="landing__head">성과를 공개할 때 지키는 기준</h2>
                <div class="landing__points">
                    <div class="landing__point"><strong>회사 누적과 개별 성과를 구분</strong><span>회사 전체 운영 지표를 특정 서비스나 고객사의 성과처럼 표현하지 않습니다.</span></div>
                    <div class="landing__point"><strong>기준과 기간을 함께 표시</strong><span>무엇을 언제와 비교했는지 없이 퍼센트만 크게 보여주지 않습니다.</span></div>
                    <div class="landing__point"><strong>공개 동의를 우선</strong><span>고객사명, 계정 정보, 내부 데이터를 임의로 공개하지 않습니다.</span></div>
                    <div class="landing__point"><strong>재현을 보장하지 않음</strong><span>과거 결과는 참고 자료이며 시장·예산·상품이 다른 프로젝트의 미래 성과를 보장하지 않습니다.</span></div>
                </div>
            </div>
        </section>

        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>남의 숫자보다,<br>지금 내 구조부터 진단하세요</h2>
                <p class="landing__lead" style="text-align:center;color:var(--muted-on-dark);">현재 채널과 목표를 알려주시면 어디서 성과가 막히는지부터 확인합니다.</p>
                <div class="cta-row"><a class="btn-primary" href="{{ route('contact') }}">현재 마케팅 진단 요청</a></div>
            </div>
        </section>
    </main>
@endsection
