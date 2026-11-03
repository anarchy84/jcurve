{{--
    구글 태그 관리자(GTM) 자리 (Claude 구역, 2026-11-03 제코 「GTM 자리만 만들어 둬」)
    - 광고 전환 추적(GA4·구글애즈·메타 픽셀 등)은 GTM 컨테이너 안에서 붙인다. 코드에 픽셀을 따로 박지 않는다.
    - 켜지는 조건: 서버 설정 GTM_ID(config services.gtm.id)가 'GTM-' 형식이고, 공개 도메인(SEO_PUBLIC_URL 호스트, dev. 제외)일 때만.
      ID 가 비어 있으면 아무것도 출력하지 않는다 → 지금 전환을 막지 않는다.
    - 사용: <head> 안에서 @include('partials.jc.gtm', ['gtmSlot' => 'head']), <body> 바로 뒤에서 ['gtmSlot' => 'body'].
--}}
@php
    $jcGtmId = (string) config('services.gtm.id', '');
    $jcGtmPublicHost = parse_url(rtrim((string) config('seo.public_url'), '/'), PHP_URL_HOST);
    $jcGtmHost = request()->getHost();
    $jcGtmOn = preg_match('/^GTM-[A-Z0-9]{4,12}$/', $jcGtmId) === 1
        && $jcGtmPublicHost && $jcGtmHost === $jcGtmPublicHost && ! str_starts_with($jcGtmHost, 'dev.');
@endphp
@if ($jcGtmOn)
@if (($gtmSlot ?? 'head') === 'head')
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ $jcGtmId }}');</script>
@else
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $jcGtmId }}" height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>
@endif
@endif
