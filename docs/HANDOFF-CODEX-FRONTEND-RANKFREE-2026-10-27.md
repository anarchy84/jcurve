# 클로드에게 전달 — 고객별 랭크프리 키 연결 화면

아래 내용은 그대로 클로드에게 전달할 수 있는 작업 지시다. 작성: Codex, 2026-10-27. 제품 코드·환경·서버는 이번 문서 정리에서 변경하지 않았다.

---

`/Users/anarchy/Claude_Projects/jcurve`에서 기존 마이페이지(`/dashboard`)에 **고객별 랭크프리 API 키 연결 관리 화면**을 붙여줘. 백엔드는 ORDER03까지 로컬 구현·독립 검증을 마쳤어. 기존 Laravel Blade·로그인 세션·디자인을 사용해. **배포·커밋·푸시·운영DB 마이그레이션은 하지 마.**

## 1. 먼저 읽을 문서

1. `/Users/anarchy/Claude_Projects/jcurve/AGENTS.md`
2. `/Users/anarchy/Claude_Projects/jcurve/docs/COLLAB.md`
3. `/Users/anarchy/Claude_Projects/jcurve/docs/collab/QUEUE.md` — Q-016 계약 인계·Q-017 최종 검토·Q-018 기존 테스트 충돌·Q-022 후속 주문 화면 요청 확인.
4. `/Users/anarchy/Claude_Projects/jcurve/docs/API-RANKFREE-CONNECTION.md` — 프론트가 따라야 할 요청·응답·오류 계약.
5. `/Users/anarchy/Claude_Projects/jcurve/docs/BACKEND-ORDER-03.md` — 구현 범위와 후속 게이트.
6. `/Users/anarchy/Claude_Projects/jcurve/docs/BACKEND-ORDER-03-VERIFY-RESULT.md` — 실제 실행 증거·독립 공격·암호화 무력화 후 복구 기록.
7. `/Users/anarchy/Claude_Projects/jcurve/docs/HANDOFF-CODEX-2026-10-27.md` §12 — 최신 작업 기록.

ORDER01/02의 ‘키 저장·DB·해제 미구현’은 당시 기록이야. 최신 연결 관리 계약은 ORDER03과 API-RANKFREE-CONNECTION을 따라줘.

## 2. 연결할 API

공통 경로: `/api/account/rankfree-connection`. 외부 랭크프리 주소를 브라우저에서 직접 호출하지 마.

| 메서드 | 동작 | JSON 본문 | 성공 응답 |
|---|---|---|---|
| GET | 로그인 고객 본인의 등록 상태 | 없음. query도 보내지 않음 | 200, 아래 data |
| PUT | 키 등록 또는 기존 키 교체 | `api_key`, `current_password` | 200, 아래 data |
| DELETE | 본인의 로컬 연결 해제 | `current_password` | 204, 본문 없음 |

모든 요청은 `credentials: 'same-origin'`, `Accept: application/json`을 사용해. PUT/DELETE에는 `Content-Type: application/json`과 기존 페이지의 `<meta name="csrf-token">` 값을 `X-CSRF-TOKEN` 헤더로 보내. 고객 ID·`_token`·revision·ciphertext 등 추가 필드는 보내지 마. 본문은 JSON object, 최대8,192 bytes야.

- `api_key`: ASCII `rk_` 접두 뒤 영문·숫자·밑줄·하이픈, 최대512자. 공백 자동 제거는 없어.
- `current_password`: 랭크프리 비밀번호가 아니라 **현재 로그인한 제이커브 계정 비밀번호**, 최대1024자야.
- GET은 고객별 분당60회, PUT/DELETE는 합산 분당5회야. 잘못된 비밀번호·입력도 변경 요청 제한에 포함돼.

등록 전 응답:

```json
{"data":{"registered":false,"provider_verified":false,"revision":null,"registered_at":null,"updated_at":null}}
```

등록 후에는 `registered=true`, `provider_verified=false`, UUID revision과 UTC ISO8601 등록/교체 시각이 내려와. **키 원문·일부·암호문은 내려오지 않아.**

DELETE204에는 `response.json()`을 호출하지 마. 성공 후 GET으로 미등록 상태를 확인하고 화면을 갱신해.

## 3. 화면 동작과 키 취급

- 초기 조회 중에는 로딩 상태와 조작 비활성화를 보여줘. 로그인 고객의 상태를 확인하기 전 다른 고객/이전 세션 상태를 재사용하지 마.
- 미등록은 키와 현재 비밀번호 입력·등록 버튼을 제공해. 두 입력은 password 타입을 사용해.
- 등록 상태의 라벨은 **‘등록됨 · 원격 검증 전’**이야. 키 교체와 연결 해제를 제공하고 등록/최근 교체 시각을 표시해.
- 등록됐다는 응답은 로컬 암호화 저장 성공이야. ‘연결 검증 완료’·‘실제 주문 가능’·‘order 권한 확인’으로 표시하지 마.
- 교체 실패 시 기존 연결 상태를 유지해. 요청 중 중복 클릭을 막고 mutation 자동 재시도는 하지 마. 결과가 불확실하면 GET으로 현재 상태를 다시 확인해.
- 성공 후 키/비밀번호를 입력창과 프론트 메모리 상태에서 비워. 저장된 키를 다시 채우는 기능은 만들지 마.
- 키/비밀번호를 URL·console·분석 이벤트·오류 보고·JS 번들·localStorage/sessionStorage에 넣지 마. 폼 수집·세션 리플레이가 있다면 해당 입력을 수집 대상에서 제외해.
- 해제는 **제이커브에 저장된 키만 삭제**해. 랭크프리 원격 키 폐기나 진행 중 주문/요청 취소로 안내하지 마. 반복 해제도204로 성공해.

## 4. 오류 처리

오류 기본 형태는 `error.code`, `error.message`, 검증 오류의 선택적 `error.fields`야. 값은 텍스트로 표시하고 입력 키/비밀번호나 예외 원문을 덧붙이지 마.

| 응답 | 화면 처리 |
|---|---|
| 401 | 고객 연결 상태·민감 입력을 비우고 기존 로그인 흐름으로 이동 |
| 419 | 세션/CSRF 갱신 또는 다시 로그인하도록 안내. 요청을 자동 재전송하지 않음 |
| 422 | `error.fields`의 `api_key`·`current_password`·`request` 오류를 해당 위치에 표시 |
| 429 | `Retry-After`에 따라 대기 안내, 중복 요청 방지 |
| 503 + `connections_disabled` | ‘연결 기능 준비 중’으로 표시하고 등록/교체/해제 비활성화 |
| 503 + `connection_storage_unavailable` | 저장 처리 실패 안내. 교체/해제가 성공한 것으로 표시하지 않음 |
| 나머지 | API 계약의 고정 오류 안내. 기존 연결 상태를 임의로 지우거나 성공 처리하지 않음 |

Laravel13은 same-origin Fetch Metadata로 토큰 없는 요청을 통과시킬 수 있지만, 프론트는 위 CSRF 헤더 계약을 유지해. 실제 web 미들웨어는 CSRF를 인증보다 먼저 검사하므로 비로그인 변경 요청도 잘못된 CSRF419가401보다 먼저 나올 수 있어. 둘 다 처리해.

## 5. 수정 범위와 검수

- 화면은 기존 `resources/views/dashboard.blade.php`와 Claude 소유 `resources/views/**`, `resources/css/**`, `resources/js/**`에서 작업해. 기존 `/dashboard` 라우트는 auth/verified로 보호돼 있어.
- `app/**`, `database/**`, `config/**`, `bootstrap/**`, 백엔드 라우트·테스트를 직접 바꾸지 말고 필요한 변경을 요청 큐로 Codex에 전달해. 기존 백엔드 응답을 프론트 편의로 임의 변경하지 마.
- 현재 연결 관리 플래그 `RANKFREE_CONNECTIONS_ENABLED`는 기본false야. 실제 `.env`는 열거나 고치지 마. 승인된 격리 테스트 환경/모의 API에서만 활성 응답을 확인하고, 기본 비활성503 화면도 구현해.
- `RANKFREE_API_ENABLED`·`RANKFREE_ORDER_SUBMISSION_ENABLED`를 켜거나 상품 허용표를 바꾸지 마. **APP_KEY를 새로 생성하거나 교체하지 마.**
- 원격 키 검증과 고객 공개 상품/주문 생성/주문 상태 API 라우트는 이번 연결 관리 API에 포함되지 않아. Q-022 주문 UI는 별도 백엔드 계약이 필요해. 키 등록만으로 주문 버튼을 실제 접수 API에 연결하거나 브라우저에서 랭크프리를 직접 호출하지 마.
- 성과 수치·고지 문구·기존 URL을 유지하고 `public/media/`를 덮어쓰지 마.
- 로컬/격리 환경에서 미등록→등록→교체 실패/성공→해제→재등록, 비밀번호 오류,401/419,429,503, 모바일·키보드 조작, 입력값 유출 여부를 확인해. 실제 키·계정·원격 주문은 사용하지 마.
- ORDER03 검증 완료 당시 전체98/663·독립 공격14/3,680이 통과했어. 이후 프론트 변경으로 기존 `MarketingContentTest` 문구 검사가 충돌한다는 Q-018이 있으니, 과거 수치를 현재 전체 통과로 보고하지 마. 백엔드 테스트 변경은 Codex에 요청하고 프론트 변경 후 실제 결과를 구분해서 남겨.
- 완료 시 바꾼 파일·화면 확인 결과·실제 검사 출력·미검증 항목을 네 인수인계에 기록하고 Q-016/Q-017과 대시보드를 갱신해. 필요한 독립 프론트 검증은 Codex에 인계해.

**이번에는 로컬 프론트 구현·검수 결과까지만. 커밋·푸시·서버 마이그레이션·배포·발행은 하지 마.**
