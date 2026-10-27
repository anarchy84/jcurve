# GPT(Codex)에게 전달 — 셀프마케팅 주문 화면·카카오·문의게시판 마무리

작성: Claude(프론트), 2026-10-27. 아래는 그대로 GPT/Codex에게 넘기는 작업 지시다. **커밋·푸시·배포·운영DB 마이그레이션·실결제는 하지 마.** 로컬 구현·검수까지만.

---

## 0. 대웅 결정 (10/27)

| 항목 | 결정 |
|---|---|
| 주문 | "주문은 랭크프리로 바로 보내지 말고 주문 페이지가 필요해. 바로 주문할 수 있게" → 이 사이트 안에서 4단계로 주문 |
| 상품 | "랭크프리에 상품을 만들면 그걸 불러와서 넣는 구조" → 유형·단가·수량 규칙·기간은 **랭크프리 상품표에서 읽어** 화면에 넘김. 화면은 데이터 자리만 만들어 둠 |
| 결제 | "우리 사이트에서 결제하면 랭크프리에 충전되고 랭크프리에서 차감되면 제일 베스트" → 아래 §3 |
| 로그인 | 마지막 단계(최종 확인)에서 요구 |
| 카카오톡 | "모양과 자리만 만들어 놓고 구현 마무리는 GPT" → §4 |
| 문의게시판 | 비회원 작성 → QUEUE Q-028 |
| 커뮤니티 | 메뉴에서 제외(페이지는 남김) |

## 1. 화면과 파일 (Claude 작성, 로컬 반영됨)

| 화면 | 주소·라우트 | 파일 |
|---|---|---|
| 광고 시작하기(주문 4단계) | `/self-marketing/order?type=place|shopping` · `self-marketing.order` (지금 `routes/pages.php` Route::view) | `resources/views/pages/self-marketing-order.blade.php`, 동작 `resources/js/jc.js` §13, 견본 `resources/views/partials/jc/order-sample.php` |
| 플레이스 상세 | `/self-marketing/place` · `self-marketing.place` (Route::view) | `resources/views/pages/self-marketing-place.blade.php` |
| 셀프마케팅 허브 | `/self-marketing` (기존) | 버튼들을 주문 화면으로 연결 |
| 자주 묻는 질문 | `/support/faq` · `support.faq` (Route::view) | `resources/views/pages/faq.blade.php`, 데이터 `partials/jc/faq-data.php` |
| 카카오 떠 있는 버튼 | 전 페이지(주문 화면 제외) | `resources/views/partials/jc/kakao-float.blade.php` |

컨트롤러로 바꿀 때는 **라우트 이름을 그대로** 두고 `routes/pages.php`의 해당 Route::view 줄 삭제를 큐로 알려 줘(그 파일은 Claude 구역).

## 2. 주문 화면 데이터 계약

### 2-1. 뷰 변수 (`self-marketing.order`)

| 변수 | 형태 | 없을 때 |
|---|---|---|
| `$orderCatalog` | 아래 구조. 운영자가 랭크프리에 만든 상품 중 **허용표를 통과한 것만** | 로컬: 견본 상품표 + '견본' 띠 / 운영: "주문 준비 중" + 상담 버튼 |
| `$orderCredit` | `int` 로그인 고객의 보유 크레딧(원) | `null` → "크레딧은 연동 후 표시" |
| `$rankfreeConnected` | `bool` 로그인 고객의 랭크프리 연결 여부 | `null`(모름). `false`면 연결 안내 표시 |

```php
$orderCatalog = [
    'place' => [                       // 탭 키(place|shopping, 늘려도 됨)
        'label' => '플레이스',
        'title' => '스마트 플레이스 광고를 만듭니다',
        'target' => [ 'noun' => '매장', 'heading' => '매장 찾기', 'lead' => '…', 'label' => '상호명 또는 플레이스 URL', 'example' => '입력 예시: …' ],
        'keyword_label' => '메인 키워드 1개', 'keyword_help' => '…', 'keyword_placeholder' => '예: 성수 맛집',
        'products' => [[
            'id' => 123,                 // 랭크프리 상품 ID
            'name' => '플레이스 유입',
            'icon' => 'users',           // 아이콘 이름: users|bookmark|route|layers|shopping|heart|spark … (partials/jc/icons)
            'unit_price' => 25, 'unit' => '회',
            'qty_label' => '일일 목표 유입수', 'qty_unit' => '명',
            'qty_min' => 100, 'qty_step' => 100, 'qty_max' => 2000,
            'guide' => [['하','100~300'], ['중','400~600'], ['상','800~2,000']],   // 없으면 []
            'days' => [10, 20, 30], 'popular_days' => 10,
        ]],
    ],
];
```

### 2-2. 라우트 (있으면 화면이 자동으로 씀 — `Route::has()`로 확인)

| 이름 | 메서드 | 요청 | 응답 |
|---|---|---|---|
| `self-marketing.targets.search` | GET | `?type=place&q=상호명 또는 URL` | `{"data":[{"id","name","category","thumbnail","visitor_reviews","blog_reviews","url"}]}` (없는 값은 생략/null). 결과 1개면 화면이 자동 선택 |
| `self-marketing.orders.store` | POST(JSON, `X-CSRF-TOKEN`) | `{type, product_id, target_id, target_url, keyword, daily_quantity, days, note}` | 성공 `{"data":{"redirect":"/…"}}` / 실패 `{"error":{"message":"…"}}` + 4xx |
| `credits.charge` | GET | `?amount=부족분` | 결제 화면 |
| `self-marketing.orders.index` | GET | — | 내 주문(성공 후 기본 이동처) |

- **금액은 화면 표시용 계산이다(단가×일 수량×기간).** 서버가 상품표 기준으로 다시 계산·검증하고, 클라이언트가 보낸 값으로 가격을 정하지 마.
- 매장 검색: 랭크프리 API에 플레이스·상품 조회가 있으면 그걸로, 없으면 URL에서 ID만 뽑아 확인하는 방식도 가능(화면은 둘 다 받음).
- 로그인 복귀: 비로그인으로 4단계에서 누르면 `route('login')?redirect=/self-marketing/order?type=…` 로 간다. **로그인 후 이 `redirect`(같은 사이트 경로만 허용)로 돌려보내는 처리 필요.** 입력값은 브라우저 sessionStorage(`jc-order-draft`)에 남아 4단계로 복원된다.
- **광고 시작일 = 주문 다음 날 (대웅 확정 10/27).** 화면은 시작일=오늘+1, 종료일=시작일+기간-1로 표시한다. 랭크프리 연동 시 서버도 같은 규칙으로 시작일을 정해 줘.
- 단가·순위 사례 등 견본 표시는 대웅 지시대로 "표시만" 해 둔 상태다. 실제 값은 랭크프리 연동으로 채운다.

## 3. 결제 → 랭크프리 충전 → 차감 (대웅 희망안)

랭크프리가 우리 서비스라 가능하다. 제안 흐름:

1. 4단계에서 보유 크레딧 < 총 광고비 → [크레딧 충전] (`credits.charge?amount=부족분`)
2. 이 사이트에서 PG 결제(카드·간편결제) → PG 승인 웹훅 검증
3. 서버가 **랭크프리 외부 충전 API**로 해당 고객 계정에 크레딧 적립 — 결제 건별 멱등 키(중복 적립 방지), 실패 시 재시도·보류 상태, 관리자 확인 화면
4. 주문 생성 시 랭크프리가 크레딧 차감(현재 ORDER 모듈 흐름)
5. 환불: 미사용 크레딧 환불 규정·부분 취소 처리 — **대웅 확인 필요**

필요한 것: 랭크프리 쪽 충전 API(파트너 인증), PG 계약, 환불·정산 규정, 개인정보·전자상거래 고지. 화면은 이미 이 흐름 기준(보유 크레딧·부족분·충전 버튼·광고 생성하기).

## 4. 카카오톡

- 화면 3곳이 `config('services.kakao.channel_url')`을 읽는다: 떠 있는 버튼(`partials/jc/kakao-float`), 주문 화면 왼쪽 '카카오 문의', 플레이스 상세·주문 안내의 '카카오 상담'.
- `config/services.php`에 `'kakao' => ['channel_url' => env('KAKAO_CHANNEL_URL')]` 추가 + `.env.example`에 키 이름만. 값은 대웅이 채널 주소를 정하면 넣는다.
- 값이 없으면 지금처럼 `/contact`로 연결된다(새 창 아님).

## 5. 플레이스 상세의 순위 사례 자리

- `$rankCases = [['keyword' => '성수 맛집', 'before' => 37, 'after' => 1], …]` 를 넘기면 카드로 보인다. **고객 동의를 받은 실제 기록만.** 없으면 기록 방식 안내 문장만 나온다(로컬은 '견본' 3개).
- 참고 사이트의 사례·후기·"30~40% 저렴"·"100% 실사용자" 같은 문구는 쓰지 않았다(그 회사 주장).

## 6. 문의게시판

QUEUE **Q-028** 참고(비회원 작성, 글 비밀번호, 비밀글 기본, 개인정보 동의, 스팸 제한, 관리자 답변). 라우트 `support.inquiries.index`가 생기면 메뉴·FAQ의 '문의게시판'이 자동으로 그 주소로 바뀐다. 화면 4개는 Claude가 Q-028 계약으로 만든다.

## 7. 검수

- 로컬: `/self-marketing/order`에서 플레이스·쇼핑 탭, 4단계 이동, 새로고침 후 복원, 비로그인 → 로그인 → 복귀, 크레딧 부족/충분, 주문 성공·실패 메시지, 모바일(390px) 확인.
- 하지 말 것: 실결제, 실주문, 실제 키 사용, 커밋·푸시·배포, `.env` 열람·수정, `RANKFREE_*` 플래그 켜기.
- 완료하면 HANDOFF-CODEX 문서와 QUEUE Q-029/Q-028 상태, 대시보드를 갱신.
