@extends('layouts.jc')

{{--
    홈 — 제이커브인터렉티브 본진 (리뉴얼 v3, 대웅 확정 2026-10-27)
    - 이 사이트는 제이커브 모든 사업의 '매대': 대행 서비스 · 셀프마케팅 주문 · 직접 운영하는 서비스 · 자체 앱을 한곳에서 보여준다.
    - 기존 홈(v1)의 문장·숫자·라벨은 하나도 빼지 않는다(SEO 보존). 새 디자인 구간은 그 위에 더한다.
    - 컨트롤러 데이터: $works(대표 성과), $insights(최신 글). 둘 다 비어 있으면 해당 구간을 숨긴다(기존과 동일).
    - 성과 수치·라벨은 기존 표기 그대로(CLAUDE.md 절대 규칙 2).
--}}

@section('title', '제이커브인터렉티브 | 데이터로 증명하는 퍼포먼스 마케팅 에이전시')
@section('meta')
    <meta name="description" content="퍼포먼스·CPA·SEO·리워드 네트워크 대행부터 셀프마케팅 주문, 랭크프리·부스팅샵·쇼피트렌드 등 직접 운영하는 서비스까지. 2026년 기준 누적 집행 광고비 373억원 · 진행 캠페인 15,700건의 제이커브인터렉티브.">
@endsection

@php
    $jcMenu = require resource_path('views/partials/jc/menu.php');
    $ownApps = [
        ['eggfarm', '꼬꼬농장'], ['carrotcash', '당근캐시'], ['moneytree', '머니트리'], ['pigcash', '꿀꿀캐시'],
        ['saimcash', '사임캐시'], ['stamptech', '꾹테크'], ['youngtech', '영테크'], ['cashpang', '캐시팡팡'],
        ['moneycapsule', '용돈캡슐'], ['potatofarm', '감자밭'], ['eggmoney', '에그머니'], ['jelly', '젤리요정키우기'],
    ];
    $runningApps = [
        ['eggfarm-1', '꼬꼬농장', '닭 키우고 기프티콘·현금 받는 앱테크'],
        ['carrotcash-1', '당근캐시', '당근 키우고 기프티콘·현금 받기'],
        ['pigcash-1', '꿀꿀캐시', '끼니 기록하고 기프티콘·현금 받는 앱테크'],
        ['cashpang-1', '캐시팡팡', '영단어 공부하고 기프티콘·현금 받는 앱테크'],
        ['stamptech-1', '꾹테크', '매일 국어 공부하고 기프티콘·현금 받는 앱테크'],
        ['moneytree-1', '머니트리', '나무 키우고 기프티콘·현금 받기'],
    ];
    $trustBrands = ['넷플릭스', 'LG유플러스', '현대해상', '야놀자', '함소아', '대명리조트', '라미화장품', '1300K', '유가네닭갈비'];
    $stats = [
        ['373억+', '누적 집행 광고비', '실집행 미디어 스펜드'],
        ['128만+', '누적 수집 DB', '성과형·리드 캠페인 합산'],
        ['15,700+', '진행 캠페인', '누적 집행 건수'],
        ['5.06만', '아나키 채널 구독자', '자체 유튜브 채널'],
    ];
    $goalPills = [
        'all' => '전체', 'brand' => '브랜드 알리기', 'lead' => '잠재고객 확보',
        'convert' => '전환 극대화', 'search' => '검색·AI 노출', 'build' => '채널·제작',
    ];
    $goalCards = [
        ['href' => route('services.show', ['slug' => 'performance-marketing']), 'eyebrow' => 'ROAS로 증명하는', 'title' => '퍼포먼스 마케팅', 'desc' => 'ROAS·CPA·전환 기준으로 매체를 운용합니다. 감이 아니라 데이터로 예산을 배분합니다.', 'goals' => ['brand', 'convert']],
        ['href' => route('services.show', ['slug' => 'cpa-marketing']), 'eyebrow' => '액션당 과금하는', 'title' => 'CPA 마케팅', 'desc' => '앱 설치·회원가입·구매까지, 성과가 나온 액션 단위로만 과금합니다.', 'goals' => ['lead', 'convert']],
        ['href' => route('services.show', ['slug' => 'reward-network']), 'eyebrow' => '대량 유입을 만드는', 'title' => '리워드 네트워크', 'desc' => '리워드 매체 네트워크로 잠재고객을 대규모로 확보합니다.', 'goals' => ['lead']],
        ['href' => route('services.show', ['slug' => 'seo']), 'eyebrow' => '검색을 넘어 AI 답변까지', 'title' => 'SEO · AEO · GEO', 'desc' => '구글·네이버 상위노출부터 AI 검색 최적화까지. 이 사이트가 곧 포트폴리오입니다.', 'goals' => ['brand', 'search']],
        ['href' => route('services.show', ['slug' => 'wordpress']), 'eyebrow' => '제작부터 운영까지', 'title' => '워드프레스 대행', 'desc' => '사이트 제작부터 SEO·유지보수까지 한 팀에서 끝냅니다.', 'goals' => ['search', 'build']],
    ];
    $layers = [
        ['1', '매체', '사용자가 매일 머무는 앱', '꼬꼬농장, 사임캐시 등 자체 리워드 앱', '자체 앱 보기', '#apps'],
        ['2', '네트워크', '광고주의 미션을 매체로 연결', '리워드 네트워크, 오퍼월', '리워드 네트워크', route('services.show', ['slug' => 'reward-network'])],
        ['3', '노출', '검색·AI·플랫폼에서 보이게', 'SEO·AEO·GEO, 셀프마케팅, 랭크프리', '셀프마케팅', route('self-marketing')],
        ['4', '전환', '광고비를 문의와 구매로', '퍼포먼스 마케팅, CPA 마케팅', '광고 서비스', route('services.index')],
        ['5', '세일즈', '들어온 리드를 계약으로', '리드베이, 콜투세일', '운영 서비스', route('solutions.index')],
    ];
    $products = [
        ['랭크프리', 'RankFree', '네이버 순위·시장 분석', route('solutions.rankfree')],
        ['부스팅샵', 'BoostingShop', '직접 돌리는 셀프 마케팅', route('solutions.boostingshop')],
        ['쇼피트렌드', 'shopitrend', '쇼피트렌드 마케팅 플랫폼', route('solutions.shopitrend')],
        ['리드베이', 'LEADBAY', '보험 영업조직 세일즈 CRM', route('solutions.leadbay')],
        ['콜투세일', 'Call2.Sale', '보험DB 콜센터 CRM', route('solutions.call2sale')],
    ];
@endphp

@section('content')
    {{-- ① 첫 화면 — 매출 파트너 선언 + 자체 앱 진열장 --}}
    <section class="jc-wrap jc-hero" aria-labelledby="home-title">
        <div class="jc-hero__copy">
            <span class="jc-hero__badge">퍼포먼스 · CPA · SEO · 리워드 네트워크</span>
            <h1 id="home-title" class="jc-display jc-h1 jc-h1--home">여러분들의 매출 파트너<br><span class="jc-hero__brand">제이커브인터렉티브</span></h1>
            <p class="jc-lead">성과형 광고부터 검색·AI 최적화, 자체 데이터 솔루션까지 — 숫자로 말하는 종합 디지털 마케팅 에이전시입니다.</p>
            <p class="jc-hero__proof">지금 이 화면도 저희가 직접 검색 상위에 올린 결과입니다.</p>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ route('contact') }}">프로젝트 문의하기</a>
                <a class="jc-btn jc-btn--line" href="{{ route('work.index') }}">성과 사례 보기</a>
            </div>
        </div>
        <div class="jc-shelf">
            @foreach (array_chunk($ownApps, 4) as $r => $row)
                <div>
                    <ul class="jc-shelf__row">
                        @foreach ($row as $i => [$file, $name])
                            <li><img class="jc-shelf__icon" src="{{ asset("images/apps/{$file}.png") }}" alt="{{ $name }} 앱 아이콘" width="108" height="108" style="animation-delay: {{ ($r * 4 + $i) * 60 }}ms"></li>
                        @endforeach
                    </ul>
                    <div class="jc-shelf__names" aria-hidden="true">
                        @foreach ($row as [$file, $name])<span>{{ $name }}</span>@endforeach
                    </div>
                </div>
            @endforeach
            <p class="jc-shelf__caption">제이커브가 개발하고 운영하는 리워드 앱. <a href="#apps">운영 중인 앱 보기</a></p>
        </div>
    </section>

    {{-- ② 매대 — 제이커브가 하는 모든 일을 한 화면에 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="home-biz">
        <div class="jc-wrap">
            <div class="jc-head">
                <h2 id="home-biz" class="jc-display jc-h2">대신 맡기거나, 직접 주문하거나,<br>우리 서비스를 쓰거나</h2>
                <p class="jc-text">제이커브인터렉티브는 마케팅 대행, 셀프마케팅 주문, 직접 만든 서비스 운영을 한 회사에서 합니다. 필요한 방식으로 시작하세요.</p>
            </div>
            <div class="jc-biz">
                <div class="jc-biz__col">
                    <span class="jc-biz__kicker">맡기기</span>
                    <h3 class="jc-display">마케팅 서비스</h3>
                    @foreach ($jcMenu['marketing'] as $group => $links)
                        <div class="jc-biz__group">
                            <span>{{ $group }}</span>
                            <ul>@foreach ($links as $link)<li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>@endforeach</ul>
                        </div>
                    @endforeach
                    <a class="jc-link" href="{{ route('services.index') }}">서비스 전체 보기</a>
                </div>
                <div class="jc-biz__col jc-biz__col--self">
                    <span class="jc-biz__kicker">직접 주문하기</span>
                    <h3 class="jc-display">셀프마케팅</h3>
                    <p>플레이스·쇼핑 순위상승 캠페인을 이 사이트에서 직접 고르고 주문합니다. 랭크프리 계정만 연결하면 됩니다.</p>
                    <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ route('self-marketing') }}">셀프마케팅 주문하기</a>
                </div>
                <div class="jc-biz__col">
                    <span class="jc-biz__kicker">우리 서비스 쓰기</span>
                    <h3 class="jc-display">운영 서비스</h3>
                    <ul class="jc-biz__ops">
                        @foreach ($jcMenu['operations'] as $op)
                            <li><a href="{{ $op['href'] }}"><strong>{{ $op['label'] }}</strong><span>{{ $op['desc'] }}</span></a></li>
                        @endforeach
                    </ul>
                    <a class="jc-link" href="{{ route('solutions.index') }}">운영 서비스 전체 보기</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ③ 신뢰 — 캠페인이 집행된 브랜드 --}}
    <section class="jc-wrap jc-trust" aria-labelledby="home-trust-title">
        <h2 id="home-trust-title" class="jc-trust__head">캠페인이 집행된 브랜드</h2>
        <ul class="jc-trust__list">@foreach ($trustBrands as $brand)<li>{{ $brand }}</li>@endforeach</ul>
        <p class="jc-trust__proof">2026년 기준 누적 집행 광고비 373억원 · 진행 캠페인 15,700건</p>
    </section>

    {{-- ④ 숫자 --}}
    <section id="home-stats" class="jc-section jc-bg-dark" aria-labelledby="home-stats-title">
        <div class="jc-wrap">
            <span class="jc-label jc-label--dark">BY THE NUMBERS</span>
            <h2 id="home-stats-title" class="jc-display jc-h2">숫자가 먼저 말합니다</h2>
            <p class="jc-text jc-text--dark">감이 아니라 누적 데이터로 증명합니다. 2026년 기준.</p>
            <div class="jc-stats jc-stats--four jc-stats--dark">
                @foreach ($stats as [$num, $label, $note])
                    <div class="jc-stat"><span class="jc-stat__num">{{ $num }}</span><span class="jc-stat__label">{{ $label }}</span><span class="jc-stat__note">{{ $note }}</span></div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ⑤ 목표별 서비스 고르기 --}}
    <section class="jc-section" aria-labelledby="home-goals-title">
        <div class="jc-wrap">
            <span class="jc-label">WHAT'S YOUR GOAL?</span>
            <div class="jc-head">
                <h2 id="home-goals-title" class="jc-display jc-h2">지금, 목표가 무엇인가요?</h2>
                <p class="jc-text">목표를 고르면 딱 맞는 방식을 보여드립니다. 흩어진 대행사 대신 한 팀에서 통합 운영합니다.</p>
            </div>
            <div class="jc-goals" data-jc-goals>
                <div class="jc-goals__pills" role="group" aria-label="마케팅 목표 필터">
                    @foreach ($goalPills as $key => $label)
                        <button type="button" data-goal="{{ $key }}" aria-pressed="{{ $key === 'all' ? 'true' : 'false' }}">{{ $label }}</button>
                    @endforeach
                </div>
                <div class="jc-goals__grid">
                    @foreach ($goalCards as $c)
                        <a class="jc-goal" href="{{ $c['href'] }}" data-goals="{{ implode('|', $c['goals']) }}">
                            <span class="jc-goal__eyebrow">{{ $c['eyebrow'] }}</span>
                            <span class="jc-goal__title">{{ $c['title'] }} <span aria-hidden="true">→</span></span>
                            <span class="jc-goal__desc">{{ $c['desc'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ⑥ 고객별 입구 --}}
    <nav class="jc-wrap" aria-label="고객별 시작하기">
        <div class="jc-doors">
            <a class="jc-door" href="{{ route('self-marketing') }}">
                <span class="jc-door__title">사장님·셀러</span>
                <span class="jc-door__desc">플레이스·쇼핑 순위상승, 직접 설정하고 바로 집행하세요.</span>
                <span class="jc-door__go">셀프마케팅 시작하기</span>
            </a>
            <a class="jc-door" href="{{ route('services.show', ['slug' => 'reward-network']) }}#advertisers">
                <span class="jc-door__title">광고주·브랜드</span>
                <span class="jc-door__desc">설치, 가입, 구매까지 목표 액션 단위로 캠페인을 설계합니다.</span>
                <span class="jc-door__go">캠페인 상담하기</span>
            </a>
            <a class="jc-door" href="{{ route('services.show', ['slug' => 'reward-network']) }}#publishers">
                <span class="jc-door__title">앱 매체사</span>
                <span class="jc-door__desc">오퍼월을 붙여 우리 앱 사용자의 참여를 수익으로 바꾸세요.</span>
                <span class="jc-door__go">매체 제휴 문의</span>
            </a>
        </div>
    </nav>

    {{-- ⑦ 제휴 네트워크·매체 --}}
    @include('partials.jc.partner-band')

    {{-- ⑧ 왜 제이커브인가 --}}
    <section class="jc-section" aria-labelledby="home-bento-title">
        <div class="jc-wrap">
            <span class="jc-label">WHY J-CURVE</span>
            <h2 id="home-bento-title" class="jc-display jc-h2">광고에서 끝나지 않습니다.<br>데이터와 도구까지 직접 만듭니다.</h2>
            <div class="jc-why">
                <article class="jc-why__item jc-why__item--wide">
                    <h3>흩어진 대행사 대신,<br>한 팀에서 통합 운영</h3>
                    <p>매체·데이터·개발이 한자리에 있습니다. 유입부터 전환, 분석까지 끊김 없이 이어집니다.</p>
                    <a class="jc-link" href="{{ route('services.index') }}">9개 전문 영역 보기 →</a>
                </article>
                <article class="jc-why__item">
                    <strong class="jc-why__num">128만+</strong>
                    <span class="jc-why__label">누적 수집 DB</span>
                    <p>캠페인은 끝나도 데이터는 남습니다.</p>
                </article>
                <article class="jc-why__item">
                    <h3>도구까지 직접 개발</h3>
                    <p>남의 툴을 빌리지 않습니다. 현장에서 필요한 솔루션 4종을 자체 운영합니다.</p>
                    <a class="jc-link" href="{{ route('solutions.index') }}">자체 솔루션 →</a>
                </article>
                <article class="jc-why__item">
                    <strong class="jc-why__num">15,700+</strong>
                    <span class="jc-why__label">진행 캠페인</span>
                    <p>373억+ 광고비를 실제로 태워봤습니다.</p>
                </article>
                <article class="jc-why__item">
                    <h3>이 사이트가 증거입니다</h3>
                    <p>지금 이 화면도 저희가 직접 검색 상위에 올린 결과입니다. SEO 실력을 자기 사이트로 증명합니다.</p>
                    <a class="jc-link" href="{{ route('services.show', ['slug' => 'seo']) }}">SEO · AEO · GEO →</a>
                </article>
            </div>
        </div>
    </section>

    {{-- ⑨ 직접 운영하는 서비스 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="home-solutions-title">
        <div class="jc-wrap">
            <span class="jc-label">OUR PRODUCTS</span>
            <div class="jc-head">
                <h2 id="home-solutions-title" class="jc-display jc-h2">우리는 도구까지 직접 만듭니다</h2>
                <p class="jc-text">남의 툴을 빌려 쓰지 않습니다. 마케팅 데이터부터 보험 세일즈 CRM까지, 현장에서 필요한 도구를 직접 개발해 운영합니다.</p>
            </div>
            <div class="jc-products">
                @foreach ($products as [$name, $en, $desc, $href])
                    <a class="jc-product" href="{{ $href }}">
                        <strong>{{ $name }} <span>({{ $en }})</span></strong>
                        <p>{{ $desc }}</p>
                        <span class="jc-product__go">자세히 →</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ⑩ 운영 중인 앱 --}}
    <section id="apps" class="jc-section" aria-labelledby="home-apps">
        <div class="jc-wrap">
            <div class="jc-head">
                <div>
                    <h2 id="home-apps" class="jc-display jc-h2">지금 운영 중인 리워드 앱</h2>
                    <p class="jc-text" style="margin-top:18px">직접 기획하고 개발해 스토어에서 운영하는 앱입니다. 광고주의 미션이 이 앱들 안에서 실행됩니다.</p>
                </div>
                <a class="jc-link" href="https://apps.j-curve.co.kr/" rel="noopener">제이커브 앱스 전체 보기</a>
            </div>
            <ul class="jc-apps">
                @foreach ($runningApps as [$file, $name, $desc])
                    <li>
                        <img src="{{ asset("images/screens/{$file}.jpg") }}" alt="{{ $name }} 앱 화면" width="390" height="847" loading="lazy">
                        <span>
                            <span class="jc-apps__name">{{ $name }}</span><br>
                            <span class="jc-apps__desc">{{ $desc }}</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ⑪ 다섯 층 --}}
    <section class="jc-section jc-section--tight" aria-labelledby="home-layers">
        <div class="jc-wrap">
            <div class="jc-head">
                <h2 id="home-layers" class="jc-display jc-h2">매체부터 계약까지,<br>다섯 층을 직접 운영합니다</h2>
                <p class="jc-text">한 층만 맡는 회사는 다른 층에서 생긴 문제를 설명하지 못합니다. 제이커브는 앱, 네트워크, 노출, 전환, 세일즈를 모두 직접 운영합니다.</p>
            </div>
            <ol class="jc-layers">
                @foreach ($layers as [$no, $name, $job, $ours, $cta, $href])
                    <li class="jc-layer">
                        <span class="jc-layer__name"><span class="jc-layer__no">{{ $no }}</span><span class="jc-display jc-layer__title">{{ $name }}</span></span>
                        <span class="jc-layer__job">{{ $job }}</span>
                        <span class="jc-layer__ours">{{ $ours }}</span>
                        <a class="jc-link" href="{{ $href }}">{{ $cta }}</a>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ⑫ 셀프마케팅 — 순위 확인부터 주문까지 --}}
    <section class="jc-bg-dark jc-section" aria-labelledby="home-self">
        <div class="jc-wrap jc-rank">
            <div>
                <h2 id="home-self" class="jc-display jc-h2">순위상승을 위한 실행,<br>직접 시작하세요.</h2>
                <p class="jc-text" style="margin-top:20px;color:var(--jc-on-dark-2)">플레이스·쇼핑 마케팅을 직접 설정하고, 집행량과 순위 변화를 확인하세요.</p>
                <ol class="jc-rank__steps">
                    <li><span class="jc-rank__no">1</span><span><strong>지금 순위 확인</strong><span>랭크프리로 내 가게와 상품의 현재 순위를 무료로 확인합니다.</span></span></li>
                    <li><span class="jc-rank__no">2</span><span><strong>캠페인 설정</strong><span>키워드, 수량, 기간을 직접 정하고 바로 집행합니다.</span></span></li>
                    <li><span class="jc-rank__no">3</span><span><strong>결과 확인</strong><span>집행량과 순위 변화를 기록으로 남겨 다음 집행에 씁니다.</span></span></li>
                </ol>
                <a class="jc-btn jc-btn--white jc-btn--md" style="margin-top:32px" href="{{ route('self-marketing') }}">셀프마케팅 주문하기</a>
            </div>
            @include('partials.jc.rank-form', ['variant' => 'stack'])
        </div>
    </section>

    {{-- ⑬ 광고주 | 매체사 --}}
    <section class="jc-section" aria-label="광고주와 매체사">
        <div class="jc-wrap jc-split">
            <div>
                <span class="jc-label">광고주·브랜드</span>
                <h2 class="jc-display jc-split__title">목표 액션 단위로 집행하는<br>리워드 광고</h2>
                <p>설치에서 끝나지 않고 회원가입, 미션 완료, 상담 신청, 구매까지 원하는 깊이의 액션을 고릅니다. 승인 기준은 집행 전에 문서로 맞추고, 운영 중에도 같은 기준으로 봅니다.</p>
                <ul class="jc-chips"><li>앱 설치</li><li>회원가입</li><li>미션 완료</li><li>상담 신청</li><li>구매</li></ul>
                <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ route('services.show', ['slug' => 'reward-network']) }}#advertisers">캠페인 상담하기</a>
            </div>
            <div>
                <span class="jc-label">앱 매체사</span>
                <h2 class="jc-display jc-split__title">우리 앱 이용 흐름에 맞춘<br>오퍼월 수익화</h2>
                <p>서비스 성격에 맞는 접점을 고르고, 유저 경험과 수익 운영을 함께 설계합니다. 매체 검토부터 연동, 운영 안정화까지 같이 봅니다.</p>
                <ul class="jc-chips"><li>오퍼월 도입</li><li>유저 경험 설계</li><li>수익 운영</li><li>정산 기준</li></ul>
                <a class="jc-btn jc-btn--line jc-btn--md" href="{{ route('services.show', ['slug' => 'reward-network']) }}#publishers">매체 제휴 문의</a>
            </div>
        </div>
    </section>

    {{-- ⑭ 대표 성과 (데이터 없으면 숨김 — 기존과 동일) --}}
    @if ($works->isNotEmpty())
        <section class="jc-section jc-bg-fog" aria-labelledby="home-works-title">
            <div class="jc-wrap">
                <span class="jc-label">CASE STUDIES</span>
                <div class="jc-head">
                    <div>
                        <h2 id="home-works-title" class="jc-display jc-h2">함께 만든 브랜드의 성장</h2>
                        <p class="jc-text" style="margin-top:18px">캠페인은 끝나도 데이터는 남습니다. 대표 사례 몇 가지입니다.</p>
                    </div>
                    <a class="jc-link" href="{{ route('work.index') }}">전체 성과 보기 →</a>
                </div>
                <div class="jc-works">
                    @foreach ($works as $work)
                        @php
                            $metrics = $work->metrics;
                            $m = is_array($metrics) && count($metrics) ? reset($metrics) : null;
                            $mv = is_array($m) ? ($m['value'] ?? null) : $m;
                            $ml = is_array($m) ? ($m['label'] ?? null) : null;
                        @endphp
                        <a class="jc-work" href="{{ route('work.show', ['work' => $work->slug]) }}">
                            <span class="jc-work__meta">{{ $work->client }}@if ($work->industry) · {{ $work->industry }}@endif</span>
                            @if (! empty($mv))
                                <span class="jc-work__metric">{{ $mv }}@if ($ml)<small>{{ $ml }}</small>@endif</span>
                            @endif
                            <strong class="jc-work__title">{{ $work->title }}</strong>
                            <span class="jc-work__go">사례 보기 →</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ⑮ 인사이트 --}}
    @if ($insights->isNotEmpty())
        <section class="jc-section" aria-labelledby="home-insights-title">
            <div class="jc-wrap">
                <span class="jc-label">INSIGHTS</span>
                <div class="jc-head" style="margin-bottom:24px">
                    <div>
                        <h2 id="home-insights-title" class="jc-display jc-h2">마케팅, 계속 공부합니다</h2>
                        <p class="jc-text" style="margin-top:18px">현장에서 검증한 것만 글로 남깁니다.</p>
                    </div>
                    <a class="jc-link" href="{{ route('insights.index') }}">인사이트 전체 보기 →</a>
                </div>
                <div class="jc-posts">
                    @foreach ($insights as $insight)
                        <a class="jc-post jc-post--rich" href="{{ route('insights.show', ['insight' => $insight->slug]) }}">
                            @if ($insight->published_at)
                                <time class="jc-post__date" datetime="{{ $insight->published_at->toDateString() }}">{{ $insight->published_at->format('Y.m.d') }}</time>
                            @endif
                            <span class="jc-post__cat">{{ $insight->category?->name }}</span>
                            <span class="jc-post__body">
                                <span class="jc-post__title">{{ $insight->title }}</span>
                                @if ($insight->excerpt)
                                    <span class="jc-post__excerpt">{{ $insight->excerpt }}</span>
                                @endif
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ⑯ 전체 서비스 목록 + 무료 SEO·GEO·AEO 진단 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="home-index">
        <div class="jc-wrap">
            <h2 id="home-index" class="jc-display jc-h2" style="margin-bottom:48px">제이커브가 하는 일 전체</h2>
            <div class="jc-index">
                @foreach ($jcMenu['marketing'] as $group => $links)
                    <div><h3>{{ $group }}</h3><ul>
                        @foreach ($links as $link)
                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                            @foreach ($link['children'] ?? [] as $child)
                                <li class="jc-index__child"><a href="{{ $child['href'] }}">{{ $child['label'] }}</a></li>
                            @endforeach
                        @endforeach
                    </ul></div>
                @endforeach
                <div><h3>셀프마케팅</h3><ul>
                    <li><a href="{{ route('self-marketing') }}">셀프마케팅 주문</a></li>
                </ul></div>
                <div><h3>운영 서비스</h3><ul>
                    @foreach ($jcMenu['operations'] as $op)
                        <li><a href="{{ $op['href'] }}">{{ $op['label'] }}</a></li>
                    @endforeach
                </ul></div>
            </div>
            <form class="jc-tool" method="GET" action="{{ route('seo.check') }}" role="search">
                <div style="max-width:560px">
                    <span class="jc-label">FREE SEO · GEO·AEO CHECK</span>
                    <h3 class="jc-display jc-h3">내 사이트, SEO와 AI 답변 최적화 몇 점일까요?</h3>
                    <p class="jc-text" style="margin-top:10px;font-size:16px">주소만 넣으면 온페이지 SEO(타이틀·메타·모바일)부터 GEO·AEO(구조화 데이터·스키마·답변형 구조)까지 즉석 점검합니다. 무료입니다.</p>
                </div>
                <div class="jc-tool__form">
                    <label class="jc-field jc-field--light">사이트 주소
                        <input class="jc-input jc-input--line" type="url" name="url" inputmode="url" autocomplete="url" placeholder="https://내사이트.com" aria-label="분석할 웹사이트 주소" required>
                    </label>
                    <button class="jc-btn jc-btn--black" type="submit">무료로 진단 →</button>
                </div>
            </form>
        </div>
    </section>

    {{-- ⑰ 아나키 채널 --}}
    <section class="jc-wrap jc-anarchy" aria-label="아나키 유튜브 채널">
        <p>제이커브가 함께하는 유튜브 채널 ‘아나키’ — 마케팅 현장의 이야기를 콘텐츠로 풉니다. <span>(구독 5.06만)</span></p>
        <a class="jc-link" href="{{ route('company') }}#anarchy">채널 보기 →</a>
    </section>

    {{-- ⑱ 마지막 상담 --}}
    <section class="jc-bg-dark jc-section" aria-labelledby="home-cta-title">
        <div class="jc-wrap jc-cta">
            <div>
                <h2 id="home-cta-title" class="jc-display jc-h2">숫자로 증명할 준비가 되어 있습니다</h2>
                <p class="jc-text jc-text--dark">지금 진행 중인 마케팅, 데이터로 다시 보겠습니다.<br>현재 성과를 알려주시면 개선 지점부터 짚어드립니다.</p>
                <p class="jc-contact jc-contact--dark"><span>전화 <a href="tel:0216682612">02-1668-2612</a></span><span>메일 <a href="mailto:jcurve19@gmail.com">jcurve19@gmail.com</a></span></p>
            </div>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ route('contact') }}">프로젝트 문의하기</a>
                <a class="jc-btn jc-btn--line-white" href="{{ route('work.index') }}">성과 사례 보기</a>
            </div>
        </div>
    </section>
@endsection
