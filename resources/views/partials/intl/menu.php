<?php

/*
|--------------------------------------------------------------------------
| 영어·일본어 메뉴 데이터 — 헤더·모바일 메뉴·푸터 공용 (Claude 구역, 2026-11-03 INTL)
|--------------------------------------------------------------------------
| 한국어 메뉴(partials/jc/menu.php)와 같은 항목·순서. 문구는 lang/{en,ja}/menu.php.
| 외국어판이 없는 문의게시판·로그인·커뮤니티는 넣지 않는다(INTL-PLAN §2 제외 목록).
| 사용: @php($intlMenu = require resource_path('views/partials/intl/menu.php'))
| 함수 안에 감싸서, require 한 화면의 변수($t 등)를 덮어쓰지 않게 한다.
*/

return (function (): array {
    $r = fn (string $name, array $params = []) => intl_route($name, $params);
    $t = fn (string $key) => __('menu.'.$key);
    $item = fn (string $key, string $icon, string $href, array $children = []) => ['label' => $t('items.'.$key), 'icon' => $icon, 'href' => $href, 'children' => $children];
    $child = fn (string $key, string $href) => ['label' => $t('items.'.$key), 'href' => $href];

    $googleAdsHref = config('subpages.performance.items.google-ads')
        ? $r('services.performance.sub', ['sub' => 'google-ads'])
        : $r('services.show', ['slug' => 'performance-marketing']).'#performance-channels';

    return [
        'marketing' => [
            $t('groups.ads') => [
                $item('performance', 'performance', $r('services.show', ['slug' => 'performance-marketing']), [
                    $child('google-ads', $googleAdsHref),
                    $child('naver-gfa', $r('services.performance.sub', ['sub' => 'naver-gfa'])),
                    $child('facebook', $r('services.performance.sub', ['sub' => 'facebook'])),
                    $child('youtube', $r('services.performance.sub', ['sub' => 'youtube'])),
                ]),
                $item('cpa', 'cpa', $r('services.show', ['slug' => 'cpa-marketing']), [
                    $child('real-estate', $r('services.cpa.sub', ['sub' => 'real-estate'])),
                    $child('stock', $r('services.cpa.sub', ['sub' => 'stock'])),
                    $child('insurance', $r('services.cpa.sub', ['sub' => 'insurance'])),
                    $child('coin', $r('services.cpa.sub', ['sub' => 'coin'])),
                    $child('permission-call', $r('services.cpa.sub', ['sub' => 'permission-call'])),
                ]),
                $item('reward', 'reward', $r('services.show', ['slug' => 'reward-network'])),
            ],
            $t('groups.search') => [
                $item('seo', 'seo', $r('services.show', ['slug' => 'seo'])),
                $item('aeo', 'aeo', $r('services.seo.aeo')),
                $item('geo', 'geo', $r('services.seo.geo')),
                $item('naver-place', 'place', $r('services.seo.sub', ['sub' => 'naver-place'])),
                $item('naver-shopping', 'shopping', $r('services.seo.sub', ['sub' => 'naver-shopping'])),
                $item('coupang', 'coupang', $r('services.seo.sub', ['sub' => 'coupang'])),
                $item('kakao-gift', 'gift', $r('services.seo.sub', ['sub' => 'kakao-gift'])),
                $item('backlinks', 'backlink', $r('services.seo.sub', ['sub' => 'backlinks'])),
            ],
            $t('groups.build') => [
                $item('wordpress', 'wordpress', $r('services.show', ['slug' => 'wordpress'])),
                $item('marketing-support', 'support', $r('services.marketing-support')),
            ],
        ],

        'self' => ['label' => $t('self'), 'icon' => 'self', 'href' => $r('self-marketing')],

        'operations' => [
            ['label' => $t('ops.rankfree.0'), 'icon' => 'rankfree', 'desc' => $t('ops.rankfree.1'), 'href' => $r('solutions.rankfree')],
            ['label' => $t('ops.boostingshop.0'), 'icon' => 'boostingshop', 'desc' => $t('ops.boostingshop.1'), 'href' => $r('solutions.boostingshop')],
            ['label' => $t('ops.shopitrend.0'), 'icon' => 'shopitrend', 'desc' => $t('ops.shopitrend.1'), 'href' => $r('solutions.shopitrend')],
            ['label' => $t('ops.leadbay.0'), 'icon' => 'leadbay', 'desc' => $t('ops.leadbay.1'), 'href' => $r('solutions.leadbay')],
            ['label' => $t('ops.call2sale.0'), 'icon' => 'call2sale', 'desc' => $t('ops.call2sale.1'), 'href' => $r('solutions.call2sale')],
            ['label' => $t('ops.apps.0'), 'icon' => 'apps', 'desc' => $t('ops.apps.1'), 'href' => $r('home').'#apps'],
        ],

        'support' => [
            ['label' => $t('faq'), 'icon' => 'check', 'desc' => $t('faq_desc'), 'href' => $r('support.faq')],
            ['label' => $t('project'), 'icon' => 'megaphone', 'desc' => $t('project_desc'), 'href' => $r('contact')],
        ],

        'company' => [
            ['label' => $t('company'), 'href' => $r('company')],
            ['label' => $t('work'), 'href' => $r('work.index')],
            ['label' => $t('insights'), 'href' => $r('insights.index')],
            ['label' => $t('contact'), 'href' => $r('contact')],
        ],
    ];
})();
