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
    $jcPath = '/'.ltrim(request()->path(), '/');
    $jcCanonical = trim($__env->yieldContent('canonical')) ?: $jcPublicUrl.($jcPath === '/' ? '/' : $jcPath);
    $jcHost = request()->getHost();
    $jcIsPublicHost = $jcPublicHost && $jcHost === $jcPublicHost && ! str_starts_with($jcHost, 'dev.');
    $jcRobots = $jcIsPublicHost ? (trim($__env->yieldContent('robots')) ?: 'index, follow') : 'noindex, nofollow';
    $jcTitle = trim($__env->yieldContent('title')) ?: '제이커브인터렉티브';
@endphp
<link rel="canonical" href="{{ $jcCanonical }}">
<meta name="robots" content="{{ $jcRobots }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="제이커브">
<meta property="og:title" content="{{ $jcTitle }}">
<meta property="og:url" content="{{ $jcCanonical }}">
<meta property="og:locale" content="ko_KR">
<link rel="alternate" type="application/rss+xml" title="제이커브 인사이트" href="{{ route('seo.rss') }}">
<link rel="sitemap" type="application/xml" title="사이트맵" href="{{ route('seo.sitemap') }}">
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-dynamic-subset.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/wanted-sans@1.0.3/fonts/webfonts/variable/split/WantedSansVariable.css">
