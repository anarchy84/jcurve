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
