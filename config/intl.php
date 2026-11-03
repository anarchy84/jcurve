<?php

return [
    'default' => 'ko',
    'locales' => [
        'ko' => ['prefix' => '', 'html_lang' => 'ko', 'og_locale' => 'ko_KR', 'label' => '한국어', 'short' => 'KO'],
        'en' => ['prefix' => 'en', 'html_lang' => 'en', 'og_locale' => 'en_US', 'label' => 'English', 'short' => 'EN'],
        'ja' => ['prefix' => 'ja', 'html_lang' => 'ja', 'og_locale' => 'ja_JP', 'label' => '日本語', 'short' => 'JA'],
    ],
    'routes' => [
        'home', 'company', 'contact', 'privacy', 'support.faq',
        'services.index', 'services.show', 'services.seo.aeo', 'services.seo.geo',
        'services.seo.sub', 'services.cpa.sub', 'services.performance.sub', 'services.marketing-support',
        'solutions.index', 'solutions.rankfree', 'solutions.boostingshop', 'solutions.shopitrend',
        'solutions.leadbay', 'solutions.call2sale', 'solutions.boostingshop.sub',
        'self-marketing', 'self-marketing.place', 'work.index',
        'insights.index', 'insights.category', 'insights.show',
    ],
    'services' => ['performance-marketing', 'cpa-marketing', 'reward-network', 'seo', 'wordpress'],
    'subpages' => [
        'services.seo.sub' => 'seo',
        'services.cpa.sub' => 'cpa',
        'services.performance.sub' => 'performance',
        'solutions.boostingshop.sub' => 'boostingshop',
    ],
];
