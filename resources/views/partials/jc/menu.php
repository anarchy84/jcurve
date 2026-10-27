<?php

/*
|--------------------------------------------------------------------------
| 사이트 메뉴 데이터 — 헤더·모바일 메뉴·푸터 공용 (한 곳에서만 고친다)
|--------------------------------------------------------------------------
| 구조 (대웅 확정 2026-10-27): 회사소개 · 마케팅 서비스▾ · 셀프마케팅(주문) · 운영 서비스▾ · 성과 · 인사이트 · 커뮤니티
| - 마케팅 서비스: 제이커브가 대행하는 서비스 (광고 / 검색 / 제작·지원)
| - 셀프마케팅: 이 사이트에서 바로 주문하는 페이지
| - 운영 서비스: 제이커브가 직접 운영하는 서비스 — 소개 페이지 + 실제 서비스 링크
| 사용: @php($jcMenu = require resource_path('views/partials/jc/menu.php'))
*/

return [
    'marketing' => [
        '광고 마케팅' => [
            ['label' => '퍼포먼스 마케팅', 'href' => route('services.show', ['slug' => 'performance-marketing']), 'children' => [
                ['label' => '네이버 GFA', 'href' => route('services.performance.sub', ['sub' => 'naver-gfa'])],
                ['label' => '페이스북·인스타그램', 'href' => route('services.performance.sub', ['sub' => 'facebook'])],
                ['label' => '유튜브', 'href' => route('services.performance.sub', ['sub' => 'youtube'])],
            ]],
            ['label' => 'CPA 마케팅', 'href' => route('services.show', ['slug' => 'cpa-marketing']), 'children' => [
                ['label' => '부동산 분양', 'href' => route('services.cpa.sub', ['sub' => 'real-estate'])],
                ['label' => '주식 DB', 'href' => route('services.cpa.sub', ['sub' => 'stock'])],
                ['label' => '보험디비', 'href' => route('services.cpa.sub', ['sub' => 'insurance'])],
                ['label' => '코인 DB', 'href' => route('services.cpa.sub', ['sub' => 'coin'])],
                ['label' => '퍼미션 콜 DB', 'href' => route('services.cpa.sub', ['sub' => 'permission-call'])],
            ]],
            ['label' => '리워드 네트워크', 'href' => route('services.show', ['slug' => 'reward-network'])],
        ],
        '검색 마케팅' => [
            ['label' => 'SEO', 'href' => route('services.show', ['slug' => 'seo'])],
            ['label' => 'AEO', 'href' => route('services.seo.aeo')],
            ['label' => 'GEO', 'href' => route('services.seo.geo')],
            ['label' => '네이버 플레이스', 'href' => route('services.seo.sub', ['sub' => 'naver-place'])],
            ['label' => '네이버 쇼핑', 'href' => route('services.seo.sub', ['sub' => 'naver-shopping'])],
            ['label' => '쿠팡', 'href' => route('services.seo.sub', ['sub' => 'coupang'])],
            ['label' => '카카오 선물하기', 'href' => route('services.seo.sub', ['sub' => 'kakao-gift'])],
            ['label' => '백링크', 'href' => route('services.seo.sub', ['sub' => 'backlinks'])],
        ],
        '제작·지원' => [
            ['label' => '워드프레스 제작·운영', 'href' => route('services.show', ['slug' => 'wordpress'])],
            ['label' => '마케팅 지원사업', 'href' => route('services.marketing-support')],
        ],
    ],

    'self' => ['label' => '셀프마케팅', 'href' => route('self-marketing')],

    // desc: 각 서비스 기존 소개 페이지 문구에서 가져온 한 줄
    'operations' => [
        ['label' => '랭크프리', 'desc' => '네이버 순위·시장 데이터', 'href' => route('solutions.rankfree')],
        ['label' => '부스팅샵', 'desc' => '셀프 마케팅 상품', 'href' => route('solutions.boostingshop')],
        ['label' => '쇼피트렌드', 'desc' => '쇼피트렌드 마케팅 플랫폼', 'href' => route('solutions.shopitrend')],
        ['label' => '리드베이', 'desc' => '보험 영업조직용 DB·계약 관리', 'href' => route('solutions.leadbay')],
        ['label' => '콜투세일', 'desc' => '보험DB 콜센터 운영 CRM', 'href' => route('solutions.call2sale')],
        ['label' => '자체 리워드 앱', 'desc' => '꼬꼬농장·당근캐시 등 12종', 'href' => route('home').'#apps'],
    ],

    'company' => [
        ['label' => '회사소개', 'href' => route('company')],
        ['label' => '성과', 'href' => route('work.index')],
        ['label' => '인사이트', 'href' => route('insights.index')],
        ['label' => '커뮤니티', 'href' => route('community.index')],
        ['label' => '문의하기', 'href' => route('contact')],
    ],
];
