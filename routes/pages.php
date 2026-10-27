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

// 셀프마케팅 — 이 사이트에서 바로 주문하는 허브 (대웅 확정 2026-10-27).
// 주문 데이터(상품·주문 현황)는 Codex 컨트롤러 연결 전까지 화면의 정적 안내만 보인다 → QUEUE 참고
Route::view('/self-marketing', 'pages.self-marketing')->name('self-marketing');

// 운영 서비스 소개 — 쇼피트렌드 (실제 서비스: https://shopitrend.co)
Route::view('/solutions/shopitrend', 'solutions.shopitrend')->name('solutions.shopitrend');

// 고객센터 — 자주 묻는 질문 (대웅 지시 10/27). 문의게시판은 비회원 작성이라 Codex 백엔드 필요 → QUEUE Q-028
Route::view('/support/faq', 'pages.faq')->name('support.faq');

// 셀프마케팅 주문 '광고 시작하기' 4단계 + 상품 상세 (대웅 지시 10/27 "주문은 랭크프리로 바로 보내지 말고 주문 페이지가 필요해")
// 상품표·크레딧·주문 생성은 GPT/Codex가 컨트롤러로 바꾸면서 연결 → docs/HANDOFF-CLAUDE-ORDER-UI-2026-10-27.md
Route::view('/self-marketing/order', 'pages.self-marketing-order')->name('self-marketing.order');
Route::view('/self-marketing/place', 'pages.self-marketing-place')->name('self-marketing.place');
