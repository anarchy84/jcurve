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

    // URL-PRESERVE-01: 공개된 원주소를 정식 주소로 유지한다(끝 슬래시 포함).
    'preserved_map' => [
        '/company' => '/about-us/',
        '/contact' => '/contact-us/',
        '/insights' => '/blog/',
        '/insights/category/seo' => '/blog/seo/',
        '/insights/category/link-building' => '/blog/link-building/',
        '/services/seo' => '/seo/',
        '/services/seo/backlinks' => '/seo-backlinks/',
        '/services/wordpress' => '/wordpress-agency/',
        '/services/seo/naver-place' => '/naver-place-marketing/',
        '/services/seo/naver-shopping' => '/naver-shopping-marketing/',
        '/services/seo/kakao-gift' => '/kakao-gift/',
        '/services/seo/coupang' => '/coupang/',
        '/insights/chrome-및-firefox에서-nofollow-링크를-확인하는-방법' => '/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/',
        '/insights/11가지-최고의-seo-실수와-이를-피하는-방법' => '/seo/11가지-최고의-seo-실수와-이를-피하는-방법/',
        '/insights/경쟁자를-압도하는-6가지-고급-링크-구축-전략' => '/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/',
    ],
    // 삭제/발행일 변경 없이 설정을 비우면 다시 공개할 수 있다.
    'hidden_insights' => ['온라인-마케팅-제대로-배울-수-있는-아나키-강의'],
    'preserved_paths' => [
        '/', '/seo/', '/seo-backlinks/', '/wordpress-agency/',
        '/naver-place-marketing/', '/naver-shopping-marketing/',
        '/kakao-gift/', '/coupang/', '/about-us/', '/contact-us/',
        '/blog/', '/blog/seo/', '/blog/link-building/',
        '/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/',
        '/seo/11가지-최고의-seo-실수와-이를-피하는-방법/',
        '/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/',
    ],
    'legacy_hosts' => ['j-curve.co.kr', 'www.j-curve.co.kr'],
];
