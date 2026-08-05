@extends('layouts.app')

@section('title', '워드프레스 제작 — 검색되는 집을 짓습니다 | 제이커브인터렉티브')
@section('meta')
    <meta name="description" content="예쁜 사이트가 아니라 사람이 찾아오는 사이트. SEO 회사가 설계 단계부터 검색되는 길을 먼저 내는 워드프레스 제작·운영 대행.">
@endsection

@section('content')
    <main class="landing">
        {{-- 히어로 [파치먼트] --}}
        <section class="landing__hero">
            <div class="landing__hero-inner">
                <span class="landing__eyebrow">WordPress</span>
                <h1>검색되는 집을 짓습니다</h1>
                <p class="landing__lead">홈페이지는 집과 같습니다. 예쁘게 지을 수도 있고, 사람이 찾아오게 지을 수도 있죠.
                   저희는 설계 단계부터 ‘찾아오는 길’을 먼저 냅니다.</p>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">제작 상담</a>
                </div>
            </div>
        </section>

        {{-- ① 흔한 실패담 [라이트] --}}
        <section class="landing__section landing__section--light">
            <div class="landing__inner">
                <h2 class="landing__head">500만 원짜리 유령주택 이야기</h2>
                <div class="prose">
                    <p>많은 사장님들이 겪는 순서가 있습니다. 제작사에 맡긴다 → 예쁜 사이트가 나온다 → 오픈한다 → … 아무도 안 온다.</p>
                    <p>검색창에 회사 이름을 쳐도 안 나옵니다. 왜냐면 그 사이트, 검색엔진 입장에선 지도에 없는 집이거든요. 주소(색인)도, 표지판(구조화 데이터)도 없이 지어진 겁니다.</p>
                    <p>저희는 SEO 회사가 짓는 홈페이지입니다. 순서가 다릅니다.</p>
                </div>
            </div>
        </section>

        {{-- ② 제작 공정 5단계 [다크] --}}
        <section class="landing__section landing__section--dark has-orb">
            <div class="landing__inner">
                <span class="landing__eyebrow">Process</span>
                <h2 class="landing__head">저희가 짓는 순서</h2>
                <div class="steps">
                    <div class="steps__item">
                        <strong>터 고르기</strong>
                        <p>타깃 키워드·검색의도 조사. 어떤 검색에서 발견될 집인지부터 정합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>뼈대 세우기</strong>
                        <p>시맨틱 마크업, 크롤링 가능한 구조, 속도 최적화. 검색엔진이 읽는 골조.</p>
                    </div>
                    <div class="steps__item">
                        <strong>내부 공사</strong>
                        <p>디자인·콘텐츠. 예쁜 건 기본이고, 모든 페이지가 검색 목적을 갖게 합니다.</p>
                    </div>
                    <div class="steps__item">
                        <strong>길 내기</strong>
                        <p>색인 등록, 구조화 데이터, 사이트맵. 오픈 첫날부터 검색에 잡히게.</p>
                    </div>
                    <div class="steps__item">
                        <strong>관리</strong>
                        <p>만들고 끝이 아니라 운영·보안·업데이트까지. 집은 관리해야 값이 오릅니다.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ③ 왜 우리인가 [파치먼트] --}}
        <section class="landing__section landing__section--parchment">
            <div class="landing__inner">
                <span class="landing__eyebrow">Why us</span>
                <h2 class="landing__head">제작사와 마케팅사를 따로 쓰지 않아도 됩니다</h2>
                <div class="prose">
                    <p>사이트를 만든 팀이 유입까지 책임지면, “제작사는 마케팅 몰라요”와 “마케팅사는 사이트 구조를 못 고쳐요” 사이의 핑퐁이 사라집니다.</p>
                    <p>퍼포먼스·SEO팀이 같은 회사에 있다는 것 — 그게 실질적인 차이입니다.</p>
                </div>
            </div>
        </section>

        {{-- CTA [다크] --}}
        <section class="landing__cta has-orb">
            <div class="landing__cta-inner">
                <h2>찾아오는 집, 지어드립니다</h2>
                <div class="cta-row">
                    <a class="btn-primary" href="{{ route('contact') }}">제작 상담</a>
                </div>
            </div>
        </section>
    </main>
@endsection
