# BACKEND-ORDER-03 — 고객 API 키 등록·암호화 저장·해제

상태: 로컬 구현·독립 검증 완료 / Claude 최종 검토 대기 · 기준 `main / 018093c` · 2026-10-27

사용자가 고객별 API 키 등록·암호화 저장·연결 해제 백엔드와 Claude용 API 계약·작업 기록을 요청했다. 이번 범위는 명시 승인됐으며 배포는 금지다. 실제 `.env`·운영DB·실키·랭크프리 API·주문·결제·프론트는 변경/실행하지 않는다. 마이그레이션은 작성·격리 DB 테스트만 하고 서버에 적용하지 않는다.

## 계약

- 동일 origin 세션 인증의 `/api/account/rankfree-connection`: GET 상태, PUT 등록/교체, DELETE 해제. URL/본문으로 다른 고객 ID를 지정할 수 없다.
- PUT은 JSON `api_key`와 `current_password`, DELETE는 JSON `current_password`를 받는다. 기존 Laravel web 세션·CSRF 보호를 사용하며 mutation은 고객별 분당5회로 제한한다.
- 등록은 형식 검증과 암호화 저장이다. 원격 소유자·order 권한·유효기간을 확인하지 않았으므로 응답 `provider_verified`는 항상false다. 키나 ciphertext·키 일부도 반환하지 않는다.
- `rankfree_connections`는 user_id 유일키·users 외래키·ciphertext TEXT·revision UUID·timestamps를 가진다. 실제 키는 기존 Laravel APP_KEY 기반 인증 암호화로만 저장한다. 모델 자동 복호화 cast는 쓰지 않고 서버 저장 계층에서만 복호화한다.
- 변경은 active user 행을 잠근 transaction에서 처리한다. 폐쇄/삭제된 계정은 접근할 수 없다. 사용자 ORM soft delete 후에도 저장 키를 삭제한다. 키 교체 실패는 기존 키를 보존한다.
- 저장 계층의 `clientFor(User)`는 매번 DB에서 현재 고객 연결을 새로 읽는다. 해제 후 새 요청은 즉시 미연결이다. 해제는 로컬 저장 키 제거이며 랭크프리 키의 원격 폐기를 실행한 것이 아니다. 이미 시작된 외부 요청을 취소하지 않는다.
- 성공/오류 모두 no-store·noindex·JSON으로 응답한다. 디버그가 켜져도 이 API의 예외 원문/trace/입력은 응답에 내보내지 않고 보고 로그도 고정 코드로 한정한다. api_key/current_password는 flash 대상에서 제외한다.
- 연결 관리 활성화는 `RANKFREE_CONNECTIONS_ENABLED=false` 기본값으로 별도 제어한다. 활성화해도 기존 API/주문 플래그는 켜지지 않으며 실주문 라우트는 추가하지 않는다.

## 소유·게이트

소유: 신규 connection 모델/마이그레이션/저장 서비스/컨트롤러/미들웨어/오류 응답/사용자 삭제 observer/라우트/테스트, `app/Providers/AppServiceProvider.php`, `bootstrap/app.php`, `config/rankfree.php`, `.env.example`, 본 문서 및 API 계약. User 모델·기존 로그인/프로필·프론트·이관/성과·미디어는 수정하지 않는다.

필수 검증: 본인/타인 분리·로그아웃/삭제계정·현재비밀번호·CSRF·요청형식/허용필드·암호문 at-rest·교체/해제/재등록·해제 후 resolver·키오염/복호화실패·기본 비활성·rate limit·오류/로그/flash 키 유출·전체 회귀. 구현과 독립 검증을 분리하고 최종 제품 판단은 Claude 검수로 남긴다.

## 구현자 확인 결과

- 프론트가 사용할 전체 요청·응답·오류·CSRF·세션·화면 상태 계약은 [API-RANKFREE-CONNECTION](API-RANKFREE-CONNECTION.md)에 있다. 상태 조회는 분당60회, 등록/교체/해제는 합산 분당5회다.
- 신규 연결 검사 **18 tests / 141 assertions**, 전체 회귀 **98 tests / 663 assertions**, 소유 PHP14개 Pint 통과. PHP8.5.8·SQLite 메모리 DB·모의 키/모의 HTTP 결과이며 PHP8.3/MySQL 서버 실험 결과로 간주하지 않는다.
- 독립 검증은 [별도 지시서](BACKEND-ORDER-03-VERIFY.md)에 따라 완료했다. 구현자 결과와 독립 판정은 아래에서 구분한다.
- 신규 migration은 작성하고 테스트 환경에서만 적용했다. 실제 `.env`·운영DB·랭크프리 실키·원격 인증·주문·서버 migration·배포는 실행하지 않았다. 기존 `RANKFREE_API_ENABLED`·`RANKFREE_ORDER_SUBMISSION_ENABLED`와 상품 허용표는 그대로 비활성/빈 값이다.

## Claude가 이어갈 부분

1. 연결 화면에서 현재 비밀번호와 키를 입력받아 동일 origin 세션으로 API를 호출한다. 저장 키를 다시 채우거나 브라우저 영구 저장소에 보관하지 않는다.
2. `registered=true`는 **등록됨·원격 검증 전**으로 표시한다. `provider_verified=false`를 유효 계정/주문 권한 확인으로 바꾸어 표현하지 않는다.
3. 교체 실패 때 기존 연결은 유지한다. 해제 성공 후 입력을 비우고 상태를 갱신한다. 로컬 해제를 원격 키 폐기로 안내하지 않는다.
4. 제품 최종 검수와 배포 승인은 별도다. 인증을 통과한 실제 고객/실키 검증·원격 소유자와 order 권한 확인 방식·공개 주문/결제/영속 중복 접수 방지는 이번 완료 범위에 포함하지 않는다.

## 독립 검증 최종 결과

[독립 검증 보고서](BACKEND-ORDER-03-VERIFY-RESULT.md)에 실행 명령·격리 실행기·공격 fixture·실제 출력·소스 해시를 보관한다. 제품 결함은 이번 독립 실행에서 발견하지 않았다.

- 전체 **98 tests / 663 assertions**, 연결 테스트 **18 / 141**, 별도 독립 공격 **14 / 3,680** 통과. 소유 PHP14개 Pint·문법과 격리 Vite 빌드 통과. 기존 `hero-glow.webp` 참조 경고는 남아 있으며 미디어는 수정하지 않았다.
- 실제 `.env`를 로딩하지 않는 가짜 APP_KEY/SQLite 메모리 DB/array 세션·캐시 환경이다. 원본 CSRF 미들웨어의 unit-test bypass를 끄고 실제 세션 쿠키·토큰·Fetch Metadata를 검증했다. 비로그인 변경 요청은 잘못된 CSRF419가 인증401보다 먼저 나오는 실제 순서를 API 계약에 반영했다.
- IDOR·비밀번호·허용 필드·본문 크기·MAC 손상/잘못된 복호화 키·암호화/DB 교체 실패 rollback·해제/재등록·삭제/복구·rate limit·기본 Monolog/응답/flash 키 유출을 모의 값으로 공격했다. migration의 unique/FK와 down/up도 테스트 DB에서 검증했다.
- 암호화 표현식을 지정된 한 번만 평문으로 무력화하면 at-rest 검사가 실제 exit1로 실패했다. 원문 복구 후 대상1/13·전체98/663 재통과. `ConnectionStore.php` 복구 SHA256은 `4a4928ad717a13fd29502e41766efd265885be5532587d427000aa66b64f3f1c`, 시작/끝 검사23파일은 모두 바이트 동일이다.
- 보고서 SHA256: `32b7525857cdc38477b213eafbb83cdd37a2ad76538bb362152d3bc8e98b5dc2`. Claude용 계약/UI 인계는 Q-016, 최종 검토 요청은 Q-017에 기록했다. 제품 최종 판단과 실제 PHP8.3/MySQL 동시성·서버/실키/원격 인증·배포는 별도다.
