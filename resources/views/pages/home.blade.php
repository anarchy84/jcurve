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
    // 첫 화면 오른쪽 전환 패널: ① 성장 곡선 위 성과(기존 표기 그대로) ② 순위 확인 ③ 바로 시작 3갈래
    $heroProof = [
        ['128만+', '누적 수집 DB', 600],
        ['15,700+', '진행 캠페인', 900],
        ['373억+', '누적 집행 광고비', 1200],
    ];
    // ② 매대 — 마케팅 서비스 8갈래. 문구는 각 서비스 페이지의 기존 소개 문장에서 가져옴(새 주장 없음)
    $mkSub = fn ($group) => collect($jcMenu['marketing'][$group])->keyBy('label');
    $bizMarketing = [
        ['performance', '퍼포먼스 마케팅', '전환 기준 매체 운영', '광고 마케팅', '광고비의 성적표를 매출로 받습니다',
            '매체 숫자가 아니라 매출·유효 리드·가입 등 합의한 비즈니스 KPI를 기준으로 광고를 운영합니다.',
            route('services.show', ['slug' => 'performance-marketing']), $mkSub('광고 마케팅')['퍼포먼스 마케팅']['children']],
        ['cpa', 'CPA 마케팅', '유효 액션 기준 집행', '광고 마케팅', '유효 액션 기준 성과형 광고',
            '설치·가입·구매·상담신청 등 사전에 합의한 유효 액션을 기준으로 집행합니다. 트래킹과 정산 구조까지 설계합니다.',
            route('services.show', ['slug' => 'cpa-marketing']), $mkSub('광고 마케팅')['CPA 마케팅']['children']],
        ['reward', '리워드 네트워크', '광고주 액션 × 앱 수익화', '광고 마케팅', '광고주 액션과 앱 수익화를 연결합니다',
            '목표 액션을 설계하는 광고주 캠페인부터 오퍼월·리워드 지면을 운영하는 앱 매체 제휴까지 한 흐름으로 연결합니다.',
            route('services.show', ['slug' => 'reward-network']), [
                ['label' => '광고주 캠페인', 'href' => route('services.show', ['slug' => 'reward-network']).'#advertisers'],
                ['label' => '앱 매체 제휴', 'href' => route('services.show', ['slug' => 'reward-network']).'#publishers'],
            ]],
        ['seo', 'SEO · AEO · GEO', '검색·AI 답변 노출', '검색 마케팅', '검색과 AI 답변에서 발견되는 구조',
            '구글·네이버 검색 최적화부터 AEO·GEO까지. 크롤링·색인·콘텐츠·엔티티·신뢰 근거와 전환 동선을 함께 정비합니다.',
            route('services.show', ['slug' => 'seo']), [
                ['label' => 'SEO', 'href' => route('services.show', ['slug' => 'seo'])],
                ['label' => 'AEO 답변엔진 최적화', 'href' => route('services.seo.aeo')],
                ['label' => 'GEO 생성엔진 최적화', 'href' => route('services.seo.geo')],
            ]],
        ['place', '플레이스·쇼핑', '네이버·쿠팡·카카오 상위노출', '검색 마케팅', '발견에서 방문·구매까지',
            '네이버 플레이스·네이버 쇼핑·쿠팡·카카오 선물하기에서 검색 의도와 매장·상품 정보, 전환 동선을 함께 정비합니다.',
            route('services.seo.sub', ['sub' => 'naver-place']), [
                ['label' => '네이버 플레이스', 'href' => route('services.seo.sub', ['sub' => 'naver-place'])],
                ['label' => '네이버 쇼핑', 'href' => route('services.seo.sub', ['sub' => 'naver-shopping'])],
                ['label' => '쿠팡', 'href' => route('services.seo.sub', ['sub' => 'coupang'])],
                ['label' => '카카오 선물하기', 'href' => route('services.seo.sub', ['sub' => 'kakao-gift'])],
            ]],
        ['backlink', '백링크', '검색 신뢰 신호 설계', '검색 마케팅', '검색을 위한 신뢰 신호 설계',
            '페이지 진단부터 출처 맥락, 앵커텍스트, 링크 상태 점검까지 단계적으로 관리합니다.',
            route('services.seo.sub', ['sub' => 'backlinks']), []],
        ['wordpress', '워드프레스 제작·운영', '검색에 강한 사이트', '제작·지원', '검색과 마케팅을 고려한 웹사이트',
            '디자인만이 아니라 검색·광고·콘텐츠 운영과 전환 측정까지 고려해 만들고 운영합니다.',
            route('services.show', ['slug' => 'wordpress']), []],
        ['support', '마케팅 지원사업', '공고·실행·증빙 지원', '제작·지원', '중소기업 마케팅 지원사업 실행 지원',
            '공고·과업·증빙 기준을 확인하고 광고, SEO, 콘텐츠, 영상, 웹 제작 실행과 결과 자료 준비를 지원합니다. 선정과 지원금 지급은 보장하지 않습니다.',
            route('services.marketing-support'), []],
    ];
    $heroDoors = [
        ['megaphone', '맡기기', '마케팅 서비스', '퍼포먼스·CPA·SEO·리워드 네트워크까지 대신 운영합니다.', route('services.index')],
        ['self', '직접 주문하기', '셀프마케팅', '플레이스·쇼핑 순위상승 캠페인을 바로 주문합니다.', route('self-marketing')],
        ['store', '우리 서비스 쓰기', '운영 서비스', '랭크프리 · 부스팅샵 · 쇼피트렌드 · 리드베이 · 콜투세일', route('solutions.index')],
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
    ];
    $goalPills = [
        'all' => '전체', 'brand' => '브랜드 알리기', 'lead' => '잠재고객 확보',
        'convert' => '전환 극대화', 'boost' => '검색 순위 부스팅', 'search' => '검색·AI 노출', 'build' => '채널·제작',
    ];
    $goalCards = [
        ['icon' => 'performance', 'href' => route('services.show', ['slug' => 'performance-marketing']), 'eyebrow' => 'ROAS로 증명하는', 'title' => '퍼포먼스 마케팅', 'desc' => 'ROAS·CPA·전환 기준으로 매체를 운용합니다. 감이 아니라 데이터로 예산을 배분합니다.', 'goals' => ['brand', 'convert']],
        ['icon' => 'cpa', 'href' => route('services.show', ['slug' => 'cpa-marketing']), 'eyebrow' => '액션당 과금하는', 'title' => 'CPA 마케팅', 'desc' => '앱 설치·회원가입·구매까지, 성과가 나온 액션 단위로만 과금합니다.', 'goals' => ['lead', 'convert']],
        ['icon' => 'reward', 'href' => route('services.show', ['slug' => 'reward-network']), 'eyebrow' => '대량 유입을 만드는', 'title' => '리워드 네트워크', 'desc' => '리워드 매체 네트워크로 잠재고객을 대규모로 확보합니다.', 'goals' => ['lead']],
        ['icon' => 'seo', 'href' => route('services.show', ['slug' => 'seo']), 'eyebrow' => '검색을 넘어 AI 답변까지', 'title' => 'SEO · AEO · GEO', 'desc' => '구글·네이버 상위노출부터 AI 검색 최적화까지. 이 사이트가 곧 포트폴리오입니다.', 'goals' => ['brand', 'search']],
        ['icon' => 'wordpress', 'href' => route('services.show', ['slug' => 'wordpress']), 'eyebrow' => '제작부터 운영까지', 'title' => '워드프레스 대행', 'desc' => '사이트 제작부터 SEO·유지보수까지 한 팀에서 끝냅니다.', 'goals' => ['search', 'build']],
        ['icon' => 'self', 'href' => route('self-marketing'), 'eyebrow' => '직접 주문하는', 'title' => '셀프마케팅', 'desc' => '플레이스·쇼핑 순위상승 캠페인을 이 사이트에서 직접 고르고 주문합니다.', 'goals' => ['boost']],
        ['icon' => 'place', 'href' => route('services.seo.sub', ['sub' => 'naver-place']), 'eyebrow' => '발견에서 방문·구매까지', 'title' => '플레이스·쇼핑 상위노출', 'desc' => '네이버 플레이스·쇼핑·쿠팡·카카오 선물하기의 검색 의도와 매장·상품 정보를 함께 정비합니다.', 'goals' => ['boost', 'search']],
        ['icon' => 'rankfree', 'href' => route('solutions.rankfree'), 'eyebrow' => '순위부터 확인하는', 'title' => '랭크프리', 'desc' => '네이버 순위·시장 데이터로 지금 내 가게와 상품이 몇 등인지 먼저 확인합니다.', 'goals' => ['boost']],
    ];
    $layers = [
        ['1', '매체', '사용자가 매일 머무는 앱', '꼬꼬농장, 사임캐시 등 자체 리워드 앱', '자체 앱 보기', '#apps', 'apps'],
        ['2', '네트워크', '광고주의 미션을 매체로 연결', '리워드 네트워크, 오퍼월', '리워드 네트워크', route('services.show', ['slug' => 'reward-network']), 'network'],
        ['3', '노출', '검색·AI·플랫폼에서 보이게', 'SEO·AEO·GEO, 셀프마케팅, 랭크프리', '셀프마케팅', route('self-marketing'), 'seo'],
        ['4', '전환', '광고비를 문의와 구매로', '퍼포먼스 마케팅, CPA 마케팅', '광고 서비스', route('services.index'), 'performance'],
        ['5', '세일즈', '들어온 리드를 계약으로', '리드베이, 콜투세일', '운영 서비스', route('solutions.index'), 'users'],
    ];
    $products = [
        ['랭크프리', 'RankFree', '네이버 순위·시장 분석', route('solutions.rankfree'), 'rankfree'],
        ['부스팅샵', 'BoostingShop', '직접 돌리는 셀프 마케팅', route('solutions.boostingshop'), 'boostingshop'],
        ['쇼피트렌드', 'shopitrend', '쇼피트렌드 마케팅 플랫폼', route('solutions.shopitrend'), 'shopitrend'],
        ['리드베이', 'LEADBAY', '보험 영업조직 세일즈 CRM', route('solutions.leadbay'), 'leadbay'],
        ['콜투세일', 'Call2.Sale', '보험DB 콜센터 CRM', route('solutions.call2sale'), 'call2sale'],
    ];
@endphp

@section('content')
    {{-- ① 첫 화면 — 매출 파트너 선언 + 오른쪽 전환 패널(숫자로 증명 / 내 순위 확인 / 바로 시작). 배경: J커브(성장 곡선) 이미지·모션 --}}
    <section class="jc-stage" aria-labelledby="home-title">
    @include('partials.jc.hero-curve')
    <div class="jc-wrap jc-hero jc-hero--stage">
        <div class="jc-hero__copy">
            <span class="jc-hero__badge">퍼포먼스 · CPA · SEO · 리워드 네트워크</span>
            <h1 id="home-title" class="jc-display jc-h1 jc-h1--home">여러분들의 매출 파트너<br><span class="jc-hero__brand">제이커브인터렉티브</span></h1>
            <p class="jc-lead">성과형 광고부터 검색·AI 최적화, 자체 데이터 솔루션까지 — 숫자로 말하는 종합 디지털 마케팅 에이전시입니다.</p>
            <p class="jc-hero__proof">지금 이 화면도 저희가 직접 검색 상위에 올린 결과입니다.</p>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ route('contact') }}">프로젝트 문의하기</a>
                <a class="jc-btn jc-btn--line-white" href="{{ route('work.index') }}">성과 사례 보기</a>
            </div>
        </div>
        <div class="jc-hx" data-jc-hx>
            <div class="jc-hx__tabs" role="tablist" aria-label="첫 화면 안내 전환">
                <button class="jc-hx__tab is-active" type="button" role="tab" id="hx-tab-1" aria-controls="hx-panel-1" aria-selected="true"><x-jc.icon name="performance" />숫자로 증명<span class="jc-hx__bar"><i></i></span></button>
                <button class="jc-hx__tab" type="button" role="tab" id="hx-tab-2" aria-controls="hx-panel-2" aria-selected="false" tabindex="-1"><x-jc.icon name="rankfree" />내 순위 확인<span class="jc-hx__bar"><i></i></span></button>
                <button class="jc-hx__tab" type="button" role="tab" id="hx-tab-3" aria-controls="hx-panel-3" aria-selected="false" tabindex="-1"><x-jc.icon name="arrow-right" />바로 시작<span class="jc-hx__bar"><i></i></span></button>
            </div>
            <div class="jc-hx__stage" data-jc-hx-stage>
                {{-- ① 성장 곡선 위 성과 지표: 곡선이 그려지고 기록점이 켜지며 숫자가 올라간다 --}}
                <div class="jc-hx__panel is-active" role="tabpanel" id="hx-panel-1" aria-labelledby="hx-tab-1">
                    <div class="jc-hx__head">
                        <p class="jc-hx__title">감이 아니라 숫자로 증명합니다</p>
                        <span class="jc-hx__meta"><span class="jc-hx__live" aria-hidden="true"></span>2026년 기준 누적</span>
                    </div>
                    <div class="jc-hx__chart">
                        <svg viewBox="0 0 500 340" aria-hidden="true" focusable="false">
                            <defs>
                                <linearGradient id="hx-fill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#4F68FF" stop-opacity=".34"/><stop offset="1" stop-color="#1E3AFF" stop-opacity="0"/></linearGradient>
                                <linearGradient id="hx-stroke" x1="0" y1="1" x2="1" y2="0"><stop offset="0" stop-color="#1E3AFF" stop-opacity=".5"/><stop offset=".6" stop-color="#4F68FF"/><stop offset="1" stop-color="#C9D2FF"/></linearGradient>
                                <filter id="hx-glow" x="-10%" y="-10%" width="120%" height="120%"><feGaussianBlur stdDeviation="6"/></filter>
                                <linearGradient id="hx-fade" x1="0" y1="0" x2="1" y2="0"><stop offset=".8" stop-color="#fff"/><stop offset=".97" stop-color="#fff" stop-opacity="0"/></linearGradient>
                                <mask id="hx-mask"><rect width="500" height="340" fill="url(#hx-fade)"/></mask>
                            </defs>
                            <g class="jc-hx__grid" stroke="#fff" stroke-opacity=".07">
                                <line x1="0" y1="85" x2="500" y2="85"/><line x1="0" y1="170" x2="500" y2="170"/><line x1="0" y1="255" x2="500" y2="255"/>
                            </g>
                            <path class="jc-hx__area" mask="url(#hx-mask)" d="M0 300 C 30 296 50 290 70 286 C 150 270 230 250 290 214 C 360 172 420 110 452 48 C 462 28 470 14 480 4 L 480 340 L 0 340 Z" fill="url(#hx-fill)"/>
                            <path class="jc-hx__glow" d="M0 300 C 30 296 50 290 70 286 C 150 270 230 250 290 214 C 360 172 420 110 452 48 C 462 28 470 14 480 4" fill="none" stroke="#3B55FF" stroke-width="9" filter="url(#hx-glow)" pathLength="1"/>
                            <path class="jc-hx__line" d="M0 300 C 30 296 50 290 70 286 C 150 270 230 250 290 214 C 360 172 420 110 452 48 C 462 28 470 14 480 4" fill="none" stroke="url(#hx-stroke)" stroke-width="2.5" stroke-linecap="round" pathLength="1"/>
                            <g class="jc-hx__dots">
                                <circle cx="70" cy="286" r="5"/><circle cx="290" cy="214" r="5"/><circle cx="452" cy="48" r="6"/>
                            </g>
                        </svg>
                        @foreach ($heroProof as $i => [$num, $label, $delay])
                            <div class="jc-hx__chip jc-hx__chip--{{ $i + 1 }}">
                                <strong class="jc-hx__num" data-jc-delay="{{ $delay }}">{{ $num }}</strong>
                                <small>{{ $label }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ② 순위 확인: 랭크프리 무료 순위 확인으로 연결 --}}
                <div class="jc-hx__panel" role="tabpanel" id="hx-panel-2" aria-labelledby="hx-tab-2">
                    @include('partials.jc.rank-form', ['variant' => 'hero'])
                </div>

                {{-- ③ 바로 시작: 맡기기 / 직접 주문 / 우리 서비스 --}}
                <div class="jc-hx__panel" role="tabpanel" id="hx-panel-3" aria-labelledby="hx-tab-3">
                    <p class="jc-hx__title">필요한 방식으로 시작하세요</p>
                    <ul class="jc-hx__doors">
                        @foreach ($heroDoors as [$icon, $kicker, $title, $desc, $href])
                            <li><a class="jc-hx__door" href="{{ $href }}"><x-jc.icon :name="$icon" class="jc-hx__doorico" /><span><small>{{ $kicker }}</small><strong>{{ $title }}</strong><span>{{ $desc }}</span></span><x-jc.icon name="arrow-right" class="jc-hx__go" /></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </section>

    {{-- ② 매대 — 제이커브가 하는 모든 일을 한 화면에 --}}
    <section class="jc-section jc-bg-fog" aria-labelledby="home-biz">
        <div class="jc-wrap">
            <div class="jc-head">
                <h2 id="home-biz" class="jc-display jc-h2">대신 맡기거나, 직접 주문하거나,<br>우리 서비스를 쓰거나</h2>
                <p class="jc-text">제이커브인터렉티브는 마케팅 대행, 셀프마케팅 주문, 직접 만든 서비스 운영을 한 회사에서 합니다. 필요한 방식으로 시작하세요.</p>
            </div>
            {{-- 데스크톱: 마케팅 서비스 하나를 누르면 셀프마케팅·운영 서비스가 오른쪽으로 비켜나고 그 자리에 상세가 나온다.
                 빈 곳이나 비켜난 셀프마케팅을 누르면 원래대로. 모바일: 누른 항목 바로 아래로 상세가 펼쳐진다. --}}
            <div class="jc-biz" data-jc-biz>
                <div class="jc-biz__col jc-biz__col--mkt">
                    <span class="jc-biz__kicker"><x-jc.icon name="megaphone" />맡기기</span>
                    <h3 class="jc-display">마케팅 서비스</h3>
                    <ul class="jc-biz__ops jc-biz__mkt">
                        @foreach ($bizMarketing as $i => [$icon, $label, $short, $group, $headline, $desc, $href, $subs])
                            <li>
                                <a class="jc-biz__item" href="{{ $href }}" aria-expanded="false" aria-controls="biz-detail-{{ $i }}" data-jc-biz-item>
                                    <x-jc.icon :name="$icon" class="jc-biz__opico" /><strong>{{ $label }}</strong><span>{{ $short }}</span><x-jc.icon name="arrow-right" class="jc-biz__chev" />
                                </a>
                                <div class="jc-biz__detail" id="biz-detail-{{ $i }}">
                                    <div class="jc-biz__detailin"><div class="jc-biz__dbody">
                                        <span class="jc-biz__dkicker"><x-jc.icon :name="$icon" />{{ $group }} · {{ $label }}</span>
                                        <p class="jc-display jc-biz__dhead">{{ $headline }}</p>
                                        <p class="jc-biz__ddesc">{{ $desc }}</p>
                                        @if (count($subs))
                                            <ul class="jc-biz__dsubs">
                                                @foreach ($subs as $sub)<li><a href="{{ $sub['href'] }}">{{ $sub['label'] }}</a></li>@endforeach
                                            </ul>
                                        @endif
                                        <div class="jc-biz__dbtns">
                                            <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ $href }}">자세히 보기</a>
                                            <a class="jc-btn jc-btn--line jc-btn--md" href="{{ route('contact') }}">상담 문의</a>
                                        </div>
                                        <button class="jc-biz__close" type="button" data-jc-biz-close aria-label="상세 닫기"><span aria-hidden="true">×</span></button>
                                    </div></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <a class="jc-link" href="{{ route('services.index') }}">서비스 전체 보기</a>
                </div>
                <div class="jc-biz__restclip" data-jc-biz-rest>
                    <div class="jc-biz__rest">
                        <div class="jc-biz__col jc-biz__col--self">
                            <span class="jc-biz__kicker"><x-jc.icon name="self" />직접 주문하기</span>
                            <h3 class="jc-display">셀프마케팅</h3>
                            <p>플레이스·쇼핑 순위상승 캠페인을 이 사이트에서 직접 고르고 주문합니다. 랭크프리 계정만 연결하면 됩니다.</p>
                            <a class="jc-btn jc-btn--primary jc-btn--md" href="{{ route('self-marketing') }}">셀프마케팅 주문하기</a>
                        </div>
                        <div class="jc-biz__col">
                            <span class="jc-biz__kicker"><x-jc.icon name="store" />우리 서비스 쓰기</span>
                            <h3 class="jc-display">운영 서비스</h3>
                            <ul class="jc-biz__ops">
                                @foreach ($jcMenu['operations'] as $op)
                                    <li><a href="{{ $op['href'] }}"><x-jc.icon :name="$op['icon']" class="jc-biz__opico" /><strong>{{ $op['label'] }}</strong><span>{{ $op['desc'] }}</span></a></li>
                                @endforeach
                            </ul>
                            <a class="jc-link" href="{{ route('solutions.index') }}">운영 서비스 전체 보기</a>
                        </div>
                    </div>
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
            <div class="jc-stats jc-stats--home jc-stats--dark">
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
                            <x-jc.icon :name="$c['icon']" class="jc-goal__ico" />
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
                <x-jc.icon name="store" class="jc-door__ico" />
                <span class="jc-door__title">사장님·셀러</span>
                <span class="jc-door__desc">플레이스·쇼핑 순위상승, 직접 설정하고 바로 집행하세요.</span>
                <span class="jc-door__go">셀프마케팅 시작하기</span>
            </a>
            <a class="jc-door" href="{{ route('services.show', ['slug' => 'reward-network']) }}#advertisers">
                <x-jc.icon name="megaphone" class="jc-door__ico" />
                <span class="jc-door__title">광고주·브랜드</span>
                <span class="jc-door__desc">설치, 가입, 구매까지 목표 액션 단위로 캠페인을 설계합니다.</span>
                <span class="jc-door__go">캠페인 상담하기</span>
            </a>
            <a class="jc-door" href="{{ route('services.show', ['slug' => 'reward-network']) }}#publishers">
                <x-jc.icon name="apps" class="jc-door__ico" />
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
                    <x-jc.icon name="layers" class="jc-why__ico" />
                    <h3>흩어진 대행사 대신,<br>한 팀에서 통합 운영</h3>
                    <p>매체·데이터·개발이 한자리에 있습니다. 유입부터 전환, 분석까지 끊김 없이 이어집니다.</p>
                    <a class="jc-link" href="{{ route('services.index') }}">9개 전문 영역 보기 →</a>
                </article>
                <article class="jc-why__item">
                    <x-jc.icon name="users" class="jc-why__ico" />
                    <strong class="jc-why__num">128만+</strong>
                    <span class="jc-why__label">누적 수집 DB</span>
                    <p>캠페인은 끝나도 데이터는 남습니다.</p>
                </article>
                <article class="jc-why__item">
                    <x-jc.icon name="megaphone" class="jc-why__ico" />
                    <strong class="jc-why__num">15,700+</strong>
                    <span class="jc-why__label">진행 캠페인</span>
                    <p>373억+ 광고비를 실제로 태워봤습니다.</p>
                </article>
                <article class="jc-why__item">
                    <x-jc.icon name="spark" class="jc-why__ico" />
                    <h3>도구까지 직접 개발</h3>
                    <p>남의 툴을 빌리지 않습니다. 현장에서 필요한 솔루션 4종을 자체 운영합니다.</p>
                    <a class="jc-link" href="{{ route('solutions.index') }}">자체 솔루션 →</a>
                </article>
                <article class="jc-why__item">
                    <x-jc.icon name="seo" class="jc-why__ico" />
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
                @foreach ($products as [$name, $en, $desc, $href, $ico])
                    <a class="jc-product" href="{{ $href }}">
                        <x-jc.icon :name="$ico" class="jc-product__ico" />
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
                <div class="jc-apps__nav" data-jc-apps-nav>
                    <button type="button" data-dir="-1" aria-label="이전 앱 보기"><x-jc.icon name="arrow-right" class="jc-apps__prev" /></button>
                    <button type="button" data-dir="1" aria-label="다음 앱 보기"><x-jc.icon name="arrow-right" /></button>
                </div>
            </div>
            <ul class="jc-apps" data-jc-apps>
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
                @foreach ($layers as [$no, $name, $job, $ours, $cta, $href, $lico])
                    <li class="jc-layer">
                        <span class="jc-layer__name"><x-jc.icon :name="$lico" class="jc-layer__ico" /><span class="jc-layer__no">{{ $no }}</span><span class="jc-display jc-layer__title">{{ $name }}</span></span>
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
                                <span class="jc-work__metric">{{ $mv }}</span>
                                @if ($ml)<span class="jc-work__basis">{{ $ml }}</span>@endif
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

    {{-- ⑱ 마지막 상담 --}}
    <section class="jc-bg-dark jc-section" aria-labelledby="home-cta-title">
        <div class="jc-wrap jc-cta">
            <div>
                <h2 id="home-cta-title" class="jc-display jc-h2">숫자로 증명할 준비가 되어 있습니다</h2>
                <p class="jc-text jc-text--dark">지금 진행 중인 마케팅, 데이터로 다시 보겠습니다.<br>현재 성과를 알려주시면 개선 지점부터 짚어드립니다.</p>
                <p class="jc-contact jc-contact--dark"><span><x-jc.icon name="phone" />전화 <a href="tel:0216682612">02-1668-2612</a></span><span><x-jc.icon name="mail" />메일 <a href="mailto:jcurve19@gmail.com">jcurve19@gmail.com</a></span></p>
            </div>
            <div class="jc-btns">
                <a class="jc-btn jc-btn--primary" href="{{ route('contact') }}">프로젝트 문의하기</a>
                <a class="jc-btn jc-btn--line-white" href="{{ route('work.index') }}">성과 사례 보기</a>
            </div>
        </div>
    </section>
@endsection
