{{--
    공통 헤더 — 제이커브 본진 메뉴 (대웅 확정 2026-10-27)
    회사소개 · 마케팅 서비스▾ · 운영 서비스▾ · 성과 · 인사이트 · 고객센터▾ | 로그인 · [셀프마케팅] · [문의하기]
    - 11/06 ncloud 배치 참고: 오른쪽 버튼 2개(테두리 + 채움), 메가메뉴 = 왼쪽 큰 제목·설명·버튼 + 오른쪽 칸(아이콘·이름·설명)
    - ▾ 메뉴는 마우스를 올리거나 키보드로 들어가면 헤더 아래 전체 폭 패널(메가메뉴)이 열린다. 스타일은 public/css/jc-nc.css
    - 메뉴 항목은 partials/jc/menu.php 한 곳에서 관리 (헤더·모바일·푸터 공용).
--}}
@php
    $jcMenu = require resource_path('views/partials/jc/menu.php');
    $jcMarketingActive = request()->is('services*');
    $jcOpsActive = request()->is('solutions*');
    $jcSupportActive = request()->is('support*');
    $jcTop = [
        ['label' => '성과', 'href' => route('work.index'), 'active' => request()->is('work*')],
        ['label' => '인사이트', 'href' => route('insights.index'), 'active' => request()->is('insights*')],
    ];
@endphp
<link rel="stylesheet" href="{{ asset('css/jc-nc.css') }}?v={{ @filemtime(public_path('css/jc-nc.css')) }}">
{{-- 11/06 섹션 카드·도식 (jc-sec) --}}
<link rel="stylesheet" href="{{ asset('css/jc-sec.css') }}?v={{ @filemtime(public_path('css/jc-sec.css')) }}">
<script src="{{ asset('js/jc-sec.js') }}?v={{ @filemtime(public_path('js/jc-sec.js')) }}" defer></script>
<a class="jc-skip" href="#main">본문 바로가기</a>
<header class="jc-header jc-nch">
    <div class="jc-wrap jc-header__bar">
        <a class="jc-brand" href="{{ route('home') }}" aria-label="제이커브인터렉티브 홈">
            <span class="jc-brand__name">제이커브</span>
            <span class="jc-brand__sub">Interactive</span>
        </a>

        <nav class="jc-nav" aria-label="주 메뉴">
            <a href="{{ route('company') }}" @if (request()->is('company*')) aria-current="page" @endif>회사소개</a>

            <div class="jc-nav__menu">
                <a class="jc-nav__trigger" href="{{ route('services.index') }}" aria-haspopup="true" @if ($jcMarketingActive) aria-current="page" @endif>마케팅 서비스</a>
                <div class="jc-mega">
                    <div class="jc-wrap jc-mega__inner">
                        <div class="jc-mega__intro">
                            <strong>마케팅 서비스</strong>
                            <p>광고 집행부터 검색 노출, 사이트 제작까지 제이커브가 직접 맡아 운영합니다.</p>
                            <a class="jc-nch__introbtn" href="{{ route('services.index') }}">서비스 전체 보기</a>
                        </div>
                        @foreach ($jcMenu['marketing'] as $group => $links)
                            <div class="jc-mega__col jc-nch__col--{{ $loop->index }}">
                                <span class="jc-mega__label">{{ $group }}</span>
                                @foreach ($links as $link)
                                    <div class="jc-nch__item">
                                        <a class="jc-mega__link" href="{{ $link['href'] }}"><x-jc.icon :name="$link['icon']" class="jc-mega__ico" />{{ $link['label'] }}</a>
                                        @if (! empty($link['children']))
                                            <div class="jc-mega__sub">
                                                @foreach ($link['children'] as $child)
                                                    <a href="{{ $child['href'] }}">{{ $child['label'] }}</a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="jc-nav__menu">
                <a class="jc-nav__trigger" href="{{ route('solutions.index') }}" aria-haspopup="true" @if ($jcOpsActive) aria-current="page" @endif>운영 서비스</a>
                <div class="jc-mega">
                    <div class="jc-wrap jc-mega__inner">
                        <div class="jc-mega__intro">
                            <strong>운영 서비스</strong>
                            <p>제이커브가 직접 만들고 운영하는 서비스입니다. 소개를 보고 각 서비스로 바로 이동할 수 있습니다.</p>
                            <a class="jc-nch__introbtn" href="{{ route('solutions.index') }}">운영 서비스 전체 보기</a>
                        </div>
                        <div class="jc-mega__cards">
                            @foreach ($jcMenu['operations'] as $op)
                                <a class="jc-mega__card" href="{{ $op['href'] }}"><x-jc.icon :name="$op['icon']" class="jc-mega__cardico" /><span class="jc-mega__cardtxt"><strong>{{ $op['label'] }}</strong><span>{{ $op['desc'] }}</span></span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($jcTop as $item)
                <a href="{{ $item['href'] }}" @if ($item['active']) aria-current="page" @endif>{{ $item['label'] }}</a>
            @endforeach

            <div class="jc-nav__menu">
                <a class="jc-nav__trigger" href="{{ route('support.faq') }}" aria-haspopup="true" @if ($jcSupportActive) aria-current="page" @endif>고객센터</a>
                <div class="jc-mega">
                    <div class="jc-wrap jc-mega__inner">
                        <div class="jc-mega__intro">
                            <strong>고객센터</strong>
                            <p>궁금한 점은 자주 묻는 질문에서 먼저 찾아보고, 없으면 문의를 남겨 주세요.</p>
                            <a class="jc-nch__introbtn" href="tel:0216682612">전화 02-1668-2612</a>
                        </div>
                        <div class="jc-mega__cards">
                            @foreach ($jcMenu['support'] as $sp)
                                <a class="jc-mega__card" href="{{ $sp['href'] }}"><x-jc.icon :name="$sp['icon']" class="jc-mega__cardico" /><span class="jc-mega__cardtxt"><strong>{{ $sp['label'] }}</strong><span>{{ $sp['desc'] }}</span></span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="jc-header__aside">
            @auth
                <a class="jc-header__login" href="{{ route('dashboard') }}">마이페이지</a>
            @else
                <a class="jc-header__login" href="{{ route('login') }}">로그인</a>
            @endauth
            <a class="jc-nch__btn jc-nch__btn--line" href="{{ $jcMenu['self']['href'] }}" @if (request()->is('self-marketing*')) aria-current="page" @endif>{{ $jcMenu['self']['label'] }}</a>
            <a class="jc-nch__btn jc-nch__btn--fill" href="{{ route('contact') }}">문의하기</a>
            <details class="jc-mnav">
                <summary aria-label="메뉴 열기"><span class="jc-nch__burger" aria-hidden="true"><i></i><i></i><i></i></span>메뉴</summary>
                <nav class="jc-mnav__panel" aria-label="모바일 메뉴">
                    <a href="{{ route('company') }}">회사소개</a>
                    <details class="jc-mnav__group">
                        <summary>마케팅 서비스</summary>
                        @foreach ($jcMenu['marketing'] as $group => $links)
                            <span class="jc-mnav__label">{{ $group }}</span>
                            @foreach ($links as $link)
                                <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
                                @foreach ($link['children'] ?? [] as $child)
                                    <a class="jc-mnav__child" href="{{ $child['href'] }}">{{ $child['label'] }}</a>
                                @endforeach
                            @endforeach
                        @endforeach
                        <a href="{{ route('services.index') }}">서비스 전체 보기</a>
                    </details>
                    <a class="jc-mnav__self" href="{{ $jcMenu['self']['href'] }}">{{ $jcMenu['self']['label'] }}</a>
                    <details class="jc-mnav__group">
                        <summary>운영 서비스</summary>
                        @foreach ($jcMenu['operations'] as $op)
                            <a href="{{ $op['href'] }}">{{ $op['label'] }}</a>
                        @endforeach
                        <a href="{{ route('solutions.index') }}">운영 서비스 전체 보기</a>
                    </details>
                    @foreach ($jcTop as $item)
                        <a href="{{ $item['href'] }}" @if ($item['active']) aria-current="page" @endif>{{ $item['label'] }}</a>
                    @endforeach
                    <details class="jc-mnav__group">
                        <summary>고객센터</summary>
                        @foreach ($jcMenu['support'] as $sp)
                            <a href="{{ $sp['href'] }}">{{ $sp['label'] }}</a>
                        @endforeach
                    </details>
                    <div class="jc-nch__mbtns">
                        <a class="jc-nch__btn jc-nch__btn--line" href="tel:0216682612">전화 02-1668-2612</a>
                        <a class="jc-nch__btn jc-nch__btn--fill" href="{{ route('contact') }}">문의하기</a>
                    </div>
                    @auth
                        <a href="{{ route('dashboard') }}">마이페이지</a>
                    @else
                        <a href="{{ route('login') }}">로그인</a>
                    @endauth
                </nav>
            </details>
        </div>
    </div>
</header>
