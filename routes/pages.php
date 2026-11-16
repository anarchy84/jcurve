<?php

/*
|--------------------------------------------------------------------------
| 정적 페이지 라우트 — Claude 구역 (docs/COLLAB.md §2)
|--------------------------------------------------------------------------
| 데이터가 필요 없는 화면만 Route::view()로 등록한다.
| 컨트롤러·미들웨어·파라미터 라우트가 필요하면 docs/collab/QUEUE.md로 Codex에 요청한다.
| routes/web.php에서 require 된다 (QUEUE Q-002).
*/

use Illuminate\Support\Facades\Route;

// 셀프마케팅 — 2026-11-16 대표님 지시(JC-RELEASE-A)로 새 랜딩(pages.self-marketing-landing)을 이 주소에 띄운다.
// 옛 허브 화면(pages.self-marketing)은 지우지 않고 남겨 둔다(삭제는 대표님 검수 사항).
Route::view('/self-marketing', 'pages.self-marketing-landing')->name('self-marketing');

// 운영 서비스 소개 — 쇼피트렌드 (실제 서비스: https://shopitrend.co)
Route::view('/solutions/shopitrend', 'solutions.shopitrend')->name('solutions.shopitrend');

// 고객센터 — 자주 묻는 질문 (대웅 지시 10/27). 문의게시판은 비회원 작성이라 Codex 백엔드 필요 → QUEUE Q-028
Route::view('/support/faq', 'pages.faq')->name('support.faq');

// 셀프마케팅 주문 '광고 시작하기' 4단계 + 상품 상세 (대웅 지시 10/27 "주문은 랭크프리로 바로 보내지 말고 주문 페이지가 필요해")
// 상품표·크레딧·주문 생성은 GPT/Codex가 컨트롤러로 바꾸면서 연결 → docs/HANDOFF-CLAUDE-ORDER-UI-2026-10-27.md
Route::view('/self-marketing/order', 'pages.self-marketing-order')->name('self-marketing.order');
Route::view('/self-marketing/place', 'pages.self-marketing-place')->name('self-marketing.place');
// 쇼핑 리워드 상세 (SEO-KW-01, 2026-11-04 제코 지시 — 쇼핑 유입·쇼핑 순위·스마트스토어 상위노출 키워드)
Route::view('/self-marketing/shopping', 'pages.self-marketing-shopping')->name('self-marketing.shopping');

// 옛 랜딩 주소 → /self-marketing 영구 이동(301). Route::view 가 아니지만 같은 화면을 두 주소로 띄우지 않으려는 예외(JC-RELEASE-A)
Route::permanentRedirect('/lp/self-marketing', '/self-marketing')->name('lp.self-marketing');
