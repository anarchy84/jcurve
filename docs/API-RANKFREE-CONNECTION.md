# 고객별 랭크프리 연결 관리 API — Claude 프론트 계약

버전: ORDER03 · 2026-10-27 · 서버 구현: Codex / 프론트: Claude

## 공통

Base path: **`/api/account/rankfree-connection`**. 제이커브의 기존 **web 세션 쿠키**로 인증한다. 별도 Bearer 로그인이나 고객 ID URL은 없다. 같은 origin에서 `credentials: 'same-origin'`, `Accept: application/json`을 사용한다. 모든 응답은 JSON 또는 DELETE204이며 `Cache-Control: no-store, private`, `X-Robots-Tag: noindex, nofollow`, `X-Content-Type-Options: nosniff`를 설정한다.

PUT/DELETE는 `Content-Type: application/json`과 기존 페이지의 CSRF 토큰을 `X-CSRF-TOKEN` 헤더로 보낸다. Laravel13 web의 CSRF/동일-origin 검사를 유지한다. `_token` 본문·query·폼 인코딩은 이 API 계약에 포함하지 않는다. 요청 본문은 JSON object·8,192 bytes 이내이며 아래 필드 외에는422다. 고객 ID·ciphertext·상태를 보내지 않는다.

Laravel13은 신뢰할 수 있는 `Sec-Fetch-Site: same-origin` 요청을 토큰 없이 통과시킬 수 있다. 프론트는 위 토큰 전송 계약을 유지한다. web CSRF 검사가 인증보다 먼저 실행되므로 비로그인 변경 요청도 CSRF가 틀리면419가 먼저 나오며, CSRF를 통과한 뒤401이 나온다. 세션 만료 시401·419를 모두 처리한다.

기본 설정은 `RANKFREE_CONNECTIONS_ENABLED=false`다. 운영자가 검수 환경에서 연결 관리만 활성화할 때 true로 설정한다. 이 플래그는 `RANKFREE_API_ENABLED`/`RANKFREE_ORDER_SUBMISSION_ENABLED`를 켜지 않는다. 기존 Laravel APP_KEY를 사용하며 이 기능 때문에 새 APP_KEY를 생성하거나 기존 키를 덮어쓰지 않는다. 이번 작업에서 실제 `.env`·서버 마이그레이션은 실행하지 않았다.

## GET — 현재 고객의 등록 상태

파라미터·본문 없음. 고객별 분당60회.

등록 전200:

```json
{"data":{"registered":false,"provider_verified":false,"revision":null,"registered_at":null,"updated_at":null}}
```

등록 후200 응답 예시(문서용 합성 값):

```json
{"data":{"registered":true,"provider_verified":false,"revision":"bba8f8b0-7f5a-44a0-bcb3-370d659a4c64","registered_at":"2026-10-27T05:00:00.000000Z","updated_at":"2026-10-27T05:00:00.000000Z"}}
```

| 필드 | 타입 | 의미 |
|---|---|---|
| registered | boolean | 로컬 저장 레코드 존재. 실제 원격 인증 성공은 아님 |
| provider_verified | false | 아직 원격 소유자·유효성·order 권한 검증을 하지 않음 |
| revision | UUID string 또는 null | 등록/교체마다 새 값. 공개 주문 승인 토큰이나 고객 ID가 아님 |
| registered_at / updated_at | UTC ISO8601 string 또는 null | 최초 등록/최근 교체 시각 |

키 원문·ciphertext·앞/뒤 일부는 전혀 반환하지 않는다. GET이 원격 서버를 호출하거나 암호문을 복호화하지는 않는다. `registered:true`를 ‘실제 주문 가능’·‘원격 연결 검증 완료’로 표시하지 않는다. 초기 UI 라벨은 **등록됨 · 원격 검증 전**이다.

## PUT — 등록 또는 기존 키 교체

JSON 필수 필드:

| 필드 | 타입 | 검증 |
|---|---|---|
| api_key | string | ASCII `rk_` 접두 + 영문/숫자/밑줄/하이픈, 최대512자. 공백 자동 제거 없음 |
| current_password | string | 현재 로그인한 제이커브 계정 비밀번호, 최대1024자 |

성공200은 GET과 같은 data 구조이며 registered=true·provider_verified=false다. 같은 고객의 기존 레코드가 있으면 교체한다. 레코드는 고객당1개, revision과 updated_at은 갱신하며 registered_at은 유지한다. 동시 변경은 사용자 행 lock/transaction으로 직렬화하고 **마지막으로 성공한 변경**이 현재 키가 된다. revision에 의한 If-Match/낙관적 잠금은 제공하지 않는다.

키 형식 확인과 암호화 저장만 수행하고 랭크프리에 전송하지 않는다. 실패 시 기존 키를 유지한다. 사용자 입력 키는 등록 요청에서만 브라우저→제이커브 서버로 전달하며, JS 번들·URL·console·분석 이벤트·localStorage/sessionStorage에 넣지 않는다. 입력은 password 타입으로 받고 성공 후 프론트 상태에서도 비운다. 저장된 키를 다시 가져와 폼에 채우는 기능은 없다.

## DELETE — 로컬 연결 해제

JSON 필수: `current_password`(현재 제이커브 비밀번호). 성공204·본문 없음. 이미 미등록이면 동일하게204다. 해당 고객의 ciphertext 레코드를 물리 삭제하고 다른 고객은 유지한다. 이후 새 `ConnectionStore::clientFor()`는 `account_not_connected`로 거절한다. 다시 등록하면 새로운 revision을 받는다.

**로컬 해제는 랭크프리 원격 키 폐기가 아니다.** 랭크프리 콘솔의 키 유효성·권한을 변경하지 않으며 이미 시작한 외부 HTTP 요청을 취소하지 않는다. 서버는 Credential/client를 전역 또는 singleton으로 보관하지 않고 매 요청 resolve한다. 사용자 일반 ORM 탈퇴에서도 연결 레코드를 삭제한다.

PUT/DELETE 합산 고객별 분당5회(잘못된 비밀번호·입력도 포함). 자동 재시도 대신 오류와 Retry-After를 안내한다. raw SQL/quiet bulk 사용자 삭제는 observer 범위 밖이므로 기존 탈퇴 경로의 ORM 이벤트를 유지한다.

## 오류 계약

```json
{"error":{"code":"validation_failed","message":"입력값을 확인해 주세요.","fields":{"current_password":["현재 비밀번호를 확인해 주세요."]}}}
```

fields는422 검증 오류에서만 붙을 수 있다. 키는 api_key/current_password/request 중 일부이고 값은 문자열 배열이다. 원격/시스템 예외 원문·요청 값·stack trace는 반환하지 않는다. Accept가 text/html이고 APP_DEBUG=true여도 같은 API 오류 형식이다.

| HTTP | error.code | 프론트 처리 |
|---|---|---|
| 401 | unauthenticated | 로그인 이동. 고객 연결 상태를 재사용하지 않음 |
| 403 | forbidden | 권한/동일-origin 조건 확인 |
| 419 | csrf_mismatch | 페이지/CSRF 토큰 갱신 안내 |
| 422 | validation_failed / connection_invalid | fields 또는 고정 메시지 안내. 키/비밀번호를 오류 텍스트로 출력하지 않음 |
| 400 | invalid_json | 요청 JSON object 수정 |
| 413 | payload_too_large | 본문 크기 초과 |
| 415 | json_required | JSON Content-Type 수정 |
| 429 | rate_limited | Retry-After 대기. PUT/DELETE 제한 공유 |
| 503 | connections_disabled | 검수 설정 대기, 등록/해제 버튼 비활성 |
| 503 | connection_storage_unavailable | 암호화 설정·복호화 등 저장 계층 확인 필요. 기존 키를 성공 교체한 것으로 표시하지 않음 |
| 404 / 405 | not_found / method_not_allowed | 경로/메서드 수정 |
| 500 | internal_error | 고정 오류 안내. 원문/trace를 화면에 렌더하지 않음 |

## 서버 연결 방법과 공개 전 조건

기존 로그인으로 인증한 `$request->user()`를 `ConnectionStore::clientFor($user)`에 전달한다. 저장 계층은 active user와 해당 user_id의 최신 레코드만 조회·복호화해서 ORDER02의 `forCustomer`로 연결한다. 요청 본문에서 받은 사용자 객체/ID나 사전 로딩한 다른 사람의 relation을 사용하지 않는다.

현재 주문 생성/상태용 **고객 공개 HTTP 라우트는 없다**. 이 API는 연결 관리만 제공한다. 원격 키 검증·주문별 소유권·가격 동의/결제·영속 중복 주문 원장과 실제 서버/PHP8.3/MySQL·키 운영/보관·백업 접근 통제는 공개 전 검수 대상이다. 기존 APP_KEY 분실/잘못된 교체 시 ciphertext를 복호화할 수 없으므로 서버 담당자가 기존 키를 유지해야 한다.

설치 시 신규 migration은 `2026_10_27_000001_create_rankfree_connections_table.php`다. 이번에는 테스트의 SQLite 메모리 DB에만 적용했다. 운영 반영·설정·마이그레이션·배포는 대웅 확인 후 별도 작업이다.
