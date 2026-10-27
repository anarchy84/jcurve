<?php

return [
    'public_url' => env('SEO_PUBLIC_URL', env('APP_URL', 'http://localhost')),
    'sitemap_page_size' => 1000,
    'rss_limit' => 50,
    'feed_title' => '제이커브',
    'feed_description' => '제이커브의 공개 인사이트',

    // 현재 공개 라우트만 명시한다. 인증·검색 결과·UGC·폼 결과는 제외.
    'pages' => [
        '/', '/services', '/solutions', '/company', '/work', '/insights', '/contact',
    ],
    'services' => [
        '/services/performance-marketing', '/services/cpa-marketing',
        '/services/reward-network', '/services/seo', '/services/seo/aeo',
        '/services/seo/geo', '/services/wordpress', '/services/marketing-support',
        '/solutions/rankfree', '/solutions/leadbay', '/solutions/call2sale',
        '/solutions/boostingshop',
    ],
    'subpage_prefixes' => [
        'seo' => '/services/seo',
        'cpa' => '/services/cpa-marketing',
        'performance' => '/services/performance-marketing',
        'boostingshop' => '/solutions/boostingshop',
    ],

    // 이 목록은 보존 목표다. 기존 301을 승인한 것으로 간주하지 않는다.
    'preserved_paths' => [
        '/seo/', '/seo-backlinks/', '/wordpress-agency/',
        '/naver-place-marketing/', '/naver-shopping-marketing/',
        '/kakao-gift/', '/coupang/', '/about-us/', '/contact-us/',
        '/blog/', '/blog/seo/', '/blog/link-building/', '/shop/',
    ],
    'legacy_hosts' => ['j-curve.co.kr', 'www.j-curve.co.kr'],
];
