<?php

/*
|--------------------------------------------------------------------------
| 셀프마케팅 주문 — 디자인 확인용 '견본' 상품표 (로컬 전용)
|--------------------------------------------------------------------------
| 대웅 지시(10/27): "랭크프리에 상품을 만들면 그걸 불러와서 넣는 구조. 디자인으로 자리만 만들어 놓고 인계"
| - 실제 상품·단가·수량 규칙·기간은 컨트롤러가 랭크프리 상품표에서 읽어 $orderCatalog 로 넘긴다(GPT/Codex 구현).
| - 이 견본은 로컬(APP_ENV=local)에서 $orderCatalog 가 없을 때만 쓰이고, 화면에 '견본' 띠가 붙는다.
|   운영 환경에서 상품표가 비어 있으면 주문 화면 대신 상담 안내가 나온다.
| - 아래 숫자는 화면 확인용 임시값이다. 실제 판매가로 쓰지 않는다.
|
| 계약(= 컨트롤러가 넘길 $orderCatalog 모양) → docs/HANDOFF-CLAUDE-ORDER-UI-2026-10-27.md §2
*/

return [
    'place' => [
        'label' => '플레이스',
        'title' => '스마트 플레이스 광고를 만듭니다',
        'target' => [
            'noun' => '매장',
            'heading' => '매장 찾기',
            'lead' => '홍보하고 싶은 매장의 상호명이나 네이버 플레이스 URL을 입력하고 검색을 눌러 주세요. 지점이 여러 곳이면 동네 이름을 함께 넣으면 빨리 찾아요.',
            'label' => '상호명 또는 플레이스 URL',
            'example' => '입력 예시: 성수동 파스타, https://m.place.naver.com/place/123456',
        ],
        'keyword_label' => '메인 키워드 1개',
        'keyword_help' => '메인 키워드 기준으로 순위를 기록합니다.',
        'keyword_placeholder' => '예: 성수 맛집',
        'products' => [
            ['id' => 'sample-place-visit', 'name' => '플레이스 유입', 'icon' => 'users', 'unit_price' => 25, 'unit' => '회', 'description' => '검색해서 매장에 들어오는 유입',
                'qty_label' => '일일 목표 유입수', 'qty_unit' => '명', 'qty_min' => 100, 'qty_step' => 100, 'qty_max' => 2000,
                'guide' => [['하', '100~300'], ['중', '400~600'], ['상', '800~2,000']], 'days' => [10, 20, 30], 'popular_days' => 10],
            ['id' => 'sample-place-save', 'name' => '플레이스 저장', 'icon' => 'bookmark', 'unit_price' => 35, 'unit' => '회', 'description' => '매장을 저장하는 행동',
                'qty_label' => '일일 목표 저장수', 'qty_unit' => '회', 'qty_min' => 100, 'qty_step' => 100, 'qty_max' => 2000,
                'guide' => [['하', '100~300'], ['중', '400~600'], ['상', '800~2,000']], 'days' => [10, 20, 30], 'popular_days' => 10],
            ['id' => 'sample-place-route', 'name' => '플레이스 길찾기', 'icon' => 'route', 'unit_price' => 35, 'unit' => '회', 'description' => '매장까지 길찾기를 누르는 행동',
                'qty_label' => '일일 목표 길찾기수', 'qty_unit' => '회', 'qty_min' => 100, 'qty_step' => 100, 'qty_max' => 2000,
                'guide' => [['하', '100~300'], ['중', '400~600'], ['상', '800~2,000']], 'days' => [10, 20, 30], 'popular_days' => 10],
            ['id' => 'sample-place-mix', 'name' => '플레이스 복합', 'icon' => 'layers', 'unit_price' => 40, 'unit' => '회', 'description' => '유입·저장·길찾기를 함께',
                'qty_label' => '일일 목표 참여수', 'qty_unit' => '회', 'qty_min' => 100, 'qty_step' => 100, 'qty_max' => 2000,
                'guide' => [['하', '100~300'], ['중', '400~600'], ['상', '800~2,000']], 'days' => [10, 20, 30], 'popular_days' => 10],
        ],
    ],
    'shopping' => [
        'label' => '쇼핑',
        'title' => '네이버 쇼핑 광고를 만듭니다',
        'target' => [
            'noun' => '상품',
            'heading' => '상품 찾기',
            'lead' => '홍보하고 싶은 상품의 이름이나 스마트스토어 상품 URL을 입력하고 검색을 눌러 주세요.',
            'label' => '상품명 또는 상품 URL',
            'example' => '입력 예시: 무선 청소기, https://smartstore.naver.com/스토어/products/123456',
        ],
        'keyword_label' => '메인 키워드 1개',
        'keyword_help' => '메인 키워드 기준으로 순위를 기록합니다.',
        'keyword_placeholder' => '예: 무선 청소기',
        'products' => [
            ['id' => 'sample-shop-visit', 'name' => '쇼핑 유입', 'icon' => 'shopping', 'unit_price' => 25, 'unit' => '회', 'description' => '검색해서 상품에 들어오는 유입',
                'qty_label' => '일일 목표 유입수', 'qty_unit' => '명', 'qty_min' => 100, 'qty_step' => 100, 'qty_max' => 2000,
                'guide' => [['하', '100~300'], ['중', '400~600'], ['상', '800~2,000']], 'days' => [10, 20, 30], 'popular_days' => 10],
            ['id' => 'sample-shop-like', 'name' => '쇼핑 찜', 'icon' => 'heart', 'unit_price' => 35, 'unit' => '회', 'description' => '상품을 찜하는 행동',
                'qty_label' => '일일 목표 찜수', 'qty_unit' => '회', 'qty_min' => 100, 'qty_step' => 100, 'qty_max' => 2000,
                'guide' => [['하', '100~300'], ['중', '400~600'], ['상', '800~2,000']], 'days' => [10, 20, 30], 'popular_days' => 10],
            ['id' => 'sample-shop-mix', 'name' => '쇼핑 복합', 'icon' => 'layers', 'unit_price' => 40, 'unit' => '회', 'description' => '유입·찜을 함께',
                'qty_label' => '일일 목표 참여수', 'qty_unit' => '회', 'qty_min' => 100, 'qty_step' => 100, 'qty_max' => 2000,
                'guide' => [['하', '100~300'], ['중', '400~600'], ['상', '800~2,000']], 'days' => [10, 20, 30], 'popular_days' => 10],
        ],
    ],
];
