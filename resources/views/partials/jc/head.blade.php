{{--
    공통 <head> SEO·글꼴 블록 (Claude 구역, QUEUE Q-006 대응)
    - canonical: 공개 주소(config seo.public_url = SEO_PUBLIC_URL) + 현재 경로. 페이지에서 @section('canonical')로 덮어쓸 수 있다.
    - robots: 공개 도메인이 아닌 호스트(dev. 포함)에서는 무조건 noindex, nofollow.
      서버 헤더·기본 인증(Q-001)은 Codex 구역이고, 이 태그는 화면 쪽 안전장치다.
    - sitemap·RSS 발견 링크: Codex가 만든 seo.sitemap / seo.rss 라우트.
--}}
@php
    $jcPublicUrl = rtrim((string) config('seo.public_url'), '/');
    $jcPublicHost = parse_url($jcPublicUrl, PHP_URL_HOST);
    $jcPath = \App\Services\Seo\Publishing\PreservedPaths::path('/'.ltrim(request()->path(), '/'));
    $jcCanonical = \App\Services\Seo\Publishing\PreservedPaths::destination($jcPath) !== null ? $jcPublicUrl.$jcPath : (trim($__env->yieldContent('canonical')) ?: $jcPublicUrl.$jcPath);
    $jcHost = request()->getHost();
    $jcIsPublicHost = $jcPublicHost && $jcHost === $jcPublicHost && ! str_starts_with($jcHost, 'dev.');
    $jcRobots = $jcIsPublicHost ? (trim($__env->yieldContent('robots')) ?: 'index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large') : 'noindex, nofollow';
    $jcTitle = trim($__env->yieldContent('title')) ?: '제이커브인터렉티브';
@endphp
{{-- 스크립트가 켜진 화면 표시(첫 화면 전환 패널 등이 그려지기 전에 자리를 잡아 화면이 덜컹이지 않게) --}}
<script>document.documentElement.classList.add('jc-js')</script>
<link rel="canonical" href="{{ $jcCanonical }}">
<meta name="robots" content="{{ $jcRobots }}">
@if ($jcIsPublicHost)
{{-- 구글 서치콘솔 소유 확인 — 기존 워드프레스(랭크매스)가 내던 값 그대로. 빠지면 전환 뒤 서치콘솔 소유 확인이 풀린다(2026-11-03 운영 홈 head 대조) --}}
<meta name="google-site-verification" content="-JI9b9PGuPzBzPbZQXEAqZR8YfikUXM7GOP_5lgEQXM">
@endif
<meta property="og:type" content="{{ trim($__env->yieldContent('og_type')) ?: 'website' }}">
<meta property="og:site_name" content="제이커브">
<meta property="og:title" content="{{ $jcTitle }}">
<meta property="og:url" content="{{ $jcCanonical }}">
<meta property="og:locale" content="ko_KR">
@php
    // 공유 미리보기(카카오·페이스북·X): 설명은 페이지 @section('meta') 의 description 을 그대로 쓰고,
    // 이미지는 페이지가 @section('og_image') 로 주지 않으면 기본 1200x630 이미지.
    $jcDesc = preg_match('/<meta\s+name="description"\s+content="([^"]*)"/i', $__env->yieldContent('meta'), $jcM) ? $jcM[1] : '';
    $jcOgImage = trim($__env->yieldContent('og_image')) ?: $jcPublicUrl.'/images/og-default.png';
@endphp
@if ($jcDesc !== '')
<meta property="og:description" content="{!! $jcDesc !!}">
<meta name="twitter:description" content="{!! $jcDesc !!}">
@endif
<meta property="og:image" content="{{ $jcOgImage }}">
@if (! trim($__env->yieldContent('og_image')))
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
@endif
<meta property="og:image:alt" content="제이커브인터렉티브">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $jcTitle }}">
<meta name="twitter:image" content="{{ $jcOgImage }}">
@php
    // 구조화 데이터(JSON-LD) — 모든 페이지 공통: 회사(Organization)·사이트(WebSite)·이 페이지(WebPage). SEO-KW-01 (2026-11-04)
    // 옛 워드프레스(랭크매스)가 모든 페이지에 내던 그래프를 대신한다. 페이지별 추가(글·서비스·위치 경로)는 @push('jsonld').
    // 키를 '@'.'type' 처럼 쪼갠 이유: 붙여 쓰면 Blade 가 지시어로 읽을 수 있다(reward-network 와 같은 방식).
    $jcAt = '@';
    $jcOrgId = $jcPublicUrl.'/#organization';
    $jcSiteId = $jcPublicUrl.'/#website';
    $jcGraph = [
        [
            $jcAt.'type' => 'Organization',
            $jcAt.'id' => $jcOrgId,
            'name' => '제이커브인터렉티브',
            'legalName' => '(주)제이커브인터렉티브',
            'alternateName' => ['J-Curve Interactive', '제이커브'],
            'url' => $jcPublicUrl.'/',
            'image' => $jcPublicUrl.'/images/og-default.png',
            'foundingDate' => '2019',
            'email' => 'jcurve19@gmail.com',
            'telephone' => '02-1668-2612',
            'address' => [
                $jcAt.'type' => 'PostalAddress',
                'streetAddress' => '가산디지털1로, 가산더블유센터 703호',
                'addressLocality' => '금천구',
                'addressRegion' => '서울특별시',
                'addressCountry' => 'KR',
            ],
            'contactPoint' => [
                $jcAt.'type' => 'ContactPoint',
                'telephone' => '02-1668-2612',
                'contactType' => 'customer service',
                'areaServed' => 'KR',
                'availableLanguage' => 'ko',
            ],
            'knowsAbout' => ['네이버 플레이스 상위노출', '네이버 쇼핑 상위노출', '스마트스토어 상위노출', '플레이스 리워드', '쇼핑 리워드', '리워드 광고', '오퍼월', '검색엔진 최적화(SEO)', '퍼포먼스 마케팅', 'CPA 마케팅'],
        ],
        [
            $jcAt.'type' => 'WebSite',
            $jcAt.'id' => $jcSiteId,
            'url' => $jcPublicUrl.'/',
            'name' => '제이커브인터렉티브',
            'inLanguage' => 'ko-KR',
            'publisher' => [$jcAt.'id' => $jcOrgId],
        ],
        [
            $jcAt.'type' => 'WebPage',
            $jcAt.'id' => $jcCanonical.'#webpage',
            'url' => $jcCanonical,
            'name' => html_entity_decode($jcTitle, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            'description' => $jcDesc !== '' ? html_entity_decode($jcDesc, ENT_QUOTES | ENT_HTML5, 'UTF-8') : null,
            'inLanguage' => 'ko-KR',
            'isPartOf' => [$jcAt.'id' => $jcSiteId],
            'about' => [$jcAt.'id' => $jcOrgId],
            'primaryImageOfPage' => ['url' => $jcOgImage],
        ],
    ];
    $jcGraph[2] = array_filter($jcGraph[2], fn ($v) => $v !== null);

    // 위치 경로(BreadcrumbList)·서비스(Service) — 페이지가 아래 섹션을 두면 같은 그래프에 더한다. SEO-KW-02 (2026-11-04)
    //   @section('sd_page', '이 페이지 이름')               → 홈 › (상위) › 이 페이지 위치 경로
    //   @section('sd_crumbs', '상위 이름=/경로|상위 이름=/경로') → 홈과 이 페이지 사이 단계(없으면 홈 › 이 페이지)
    //   @section('sd_service', '서비스 종류')                → 제공자 = 회사인 Service(이름 = sd_page, 설명 = 이 페이지 설명)
    // pages/subpage 처럼 이미 자기 Service·BreadcrumbList 를 내는 화면에는 두지 않는다(중복 방지).
    $jcSdText = fn ($name) => trim(html_entity_decode($__env->yieldContent($name), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $jcSdPage = $jcSdText('sd_page');
    if ($jcSdPage !== '') {
        $jcSdItems = [['홈', $jcPublicUrl.'/']];
        foreach (array_filter(explode('|', $jcSdText('sd_crumbs'))) as $jcSdPair) {
            [$jcSdName, $jcSdPath] = array_pad(array_map('trim', explode('=', $jcSdPair, 2)), 2, '');
            if ($jcSdName !== '' && str_starts_with($jcSdPath, '/')) {
                $jcSdItems[] = [$jcSdName, $jcPublicUrl.$jcSdPath];
            }
        }
        $jcSdItems[] = [$jcSdPage, $jcCanonical];
        $jcGraph[2]['breadcrumb'] = [$jcAt.'id' => $jcCanonical.'#breadcrumb'];
        $jcGraph[] = [
            $jcAt.'type' => 'BreadcrumbList',
            $jcAt.'id' => $jcCanonical.'#breadcrumb',
            'itemListElement' => array_map(fn ($jcSdItem, $jcSdIndex) => [$jcAt.'type' => 'ListItem', 'position' => $jcSdIndex + 1, 'name' => $jcSdItem[0], 'item' => $jcSdItem[1]], $jcSdItems, array_keys($jcSdItems)),
        ];
        $jcSdService = $jcSdText('sd_service');
        if ($jcSdService !== '') {
            $jcGraph[2]['mainEntity'] = [$jcAt.'id' => $jcCanonical.'#service'];
            $jcGraph[] = array_filter([
                $jcAt.'type' => 'Service',
                $jcAt.'id' => $jcCanonical.'#service',
                'name' => $jcSdPage,
                'serviceType' => $jcSdService,
                'description' => $jcDesc !== '' ? html_entity_decode($jcDesc, ENT_QUOTES | ENT_HTML5, 'UTF-8') : null,
                'url' => $jcCanonical,
                'areaServed' => [$jcAt.'type' => 'Country', 'name' => 'KR'],
                'provider' => [$jcAt.'id' => $jcOrgId],
            ], fn ($v) => $v !== null);
        }
    }
@endphp
<script type="application/ld+json">{!! json_encode([$jcAt.'context' => 'https://schema.org', $jcAt.'graph' => $jcGraph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@stack('jsonld')
<link rel="alternate" type="application/rss+xml" title="제이커브 인사이트" href="{{ route('seo.rss') }}">
<link rel="sitemap" type="application/xml" title="사이트맵" href="{{ route('seo.sitemap') }}">
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-dynamic-subset.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/wanted-sans@1.0.3/fonts/webfonts/variable/split/WantedSansVariable.css">
