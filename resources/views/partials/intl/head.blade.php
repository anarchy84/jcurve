{{--
    영어·일본어 공통 <head> SEO·글꼴 블록 (Claude 구역, 2026-11-03 INTL)
    - canonical: 지금 언어의 공개 주소(intl_alternates 가 주는 값). 없으면 공개 주소 + 현재 경로.
    - hreflang: 실제로 있는 언어판끼리만 서로 가리킨다. x-default = 한국어판.
    - robots: 한국어 head 와 같은 규칙(공개 도메인만 index, dev·로컬은 noindex).
    - RSS 는 한국어 글만이라 여기선 연결하지 않는다.
--}}
@php
    $intlLocale = intl_locale();
    $intlAlts = $intlAlts ?? intl_alternates();
    $jcPublicUrl = rtrim((string) config('seo.public_url'), '/');
    $jcPublicHost = parse_url($jcPublicUrl, PHP_URL_HOST);
    $jcHost = request()->getHost();
    $jcIsPublicHost = $jcPublicHost && $jcHost === $jcPublicHost && ! str_starts_with($jcHost, 'dev.');
    $jcCanonical = trim($__env->yieldContent('canonical')) ?: ($intlAlts[$intlLocale] ?? $jcPublicUrl.'/'.ltrim(request()->path(), '/'));
    $jcRobots = $jcIsPublicHost ? (trim($__env->yieldContent('robots')) ?: 'index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large') : 'noindex, nofollow';
    $jcTitle = trim($__env->yieldContent('title')) ?: 'J-Curve Interactive';
@endphp
<script>document.documentElement.classList.add('jc-js')</script>
<link rel="canonical" href="{{ $jcCanonical }}">
<meta name="robots" content="{{ $jcRobots }}">
@if (count($intlAlts) > 1)
@foreach ($intlAlts as $altLocale => $altUrl)
<link rel="alternate" hreflang="{{ config("intl.locales.{$altLocale}.html_lang", $altLocale) }}" href="{{ $altUrl }}">
@endforeach
@isset($intlAlts['ko'])
<link rel="alternate" hreflang="x-default" href="{{ $intlAlts['ko'] }}">
@endisset
@endif
<meta property="og:type" content="website">
<meta property="og:site_name" content="J-Curve Interactive">
<meta property="og:title" content="{{ $jcTitle }}">
<meta property="og:url" content="{{ $jcCanonical }}">
<meta property="og:locale" content="{{ config("intl.locales.{$intlLocale}.og_locale") }}">
@foreach ($intlAlts as $altLocale => $altUrl)
@continue($altLocale === $intlLocale)
<meta property="og:locale:alternate" content="{{ config("intl.locales.{$altLocale}.og_locale") }}">
@endforeach
<link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('seo.sitemap') }}">
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
@if ($intlLocale === 'ja')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-jp-dynamic-subset.min.css">
@else
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-dynamic-subset.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/wanted-sans@1.0.3/fonts/webfonts/variable/split/WantedSansVariable.css">
@endif
