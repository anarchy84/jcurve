# BACKEND-ORDER-03 독립 검증 지시서

사용자가 고객별 랭크프리 키 등록·암호화 저장·해제 백엔드와 프론트 API 계약 문서화를 승인했고 **배포 금지**를 지시했다. 이번에는 DB 스키마·암호화 저장·기존 세션 인증 기반 연결 관리 HTTP까지 구현한다. 기존 ORDER02의 ‘DB/연결 미구현’은 이 범위에서 변경된다.

## 읽을 것·소유·제한

AGENTS/COLLAB/QUEUE·필수 tri-agent skill, `docs/BACKEND-ORDER-03.md`, `docs/API-RANKFREE-CONNECTION.md`, 이 지시서를 읽는다. 소유 PHP14개는 신규 connection 모델/서비스/예외/observer/controller/middleware/error response/migration/routes/tests2개와 수정 Provider/bootstrap/config다. `.env.example`의 connections flag 추가도 검토한다. 부모가 구현·대시보드를 맡고 제품/테스트는 검증 동안 동결한다.

너는 제품 수정 금지. 보고서 `docs/BACKEND-ORDER-03-VERIFY-RESULT.md`만 소유한다. 타인 수정은 보존한다. `.env` 열람/로딩·운영DB·실키·외부 API·주문·프론트·git·배포·발행 금지. 임시 config로 APP_KEY와 SQLite :memory:·캐시/세션 array를 격리하고 HTTP는 fake/preventStrayRequests로만 사용한다. migration은 테스트 DB에서만 적용한다. 서버 migration/배포 명령을 실행하지 않는다.

## 공격·실패 기준

1. 실제 GET/PUT/DELETE를 세션 고객 A/B로 호출하고 IDOR/unknown body/query/path injection·로그아웃·soft-deleted/stale user 차단을 재현한다. 다른 고객 키/메타데이터를 읽거나 바꾸면 실패.
2. DB 직접 원문 조회로 ciphertext가 평문과 다르고 APP_KEY 기반 복호화가 정확한지 확인한다. MAC 변조·잘못된 encrypter·암호화 실패가 안전한 예외로 끝나고 교체 실패가 기존 키를 유지해야 한다.
3. 상태/등록/해제/반복해제/재등록·revision·A/B 키 resolve·해제 후 fresh resolver·soft/force delete 정리·복원 시 미등록을 확인한다. User 모델·로그인/프로필을 바꾸지 않았는지도 본다.
4. 현재비밀번호 없는/틀린 PUT/DELETE·형식/최대 길이/배열/object/파일·malformed JSON·과대 요청·unknown fields/query를 차단해야 한다. 본문에 owner ID를 허용하면 실패.
5. **실제 CSRF 경로**를 unit-test bypass 없이 실행한다. cookie/session 포함 요청의 token 없음/불일치와 정상 token, cross-site 조건을 확인한다. CSRF exemption은 금지다. Laravel13의 same-origin 경로 허용과 token 경로를 구분한다.
6. 비활성 기본값, PUT/DELETE 합산5/min·GET60/min·고객별 격리·429 headers·다른 API/주문 flags 불변을 검사한다.
7. 성공/401/403/419/422/429/5xx·APP_DEBUG true/HTML Accept에서 raw API key/비밀번호/ciphertext/stack trace가 응답·session old input·기본 예외 로그에 나오면 실패. 고정 로그의 예외 타입만 허용한다. 의도적으로 예외 원문에 모의 키를 넣고 저장 실패/validator 예외를 재현한다.
8. 공개 주문 라우트·원격 요청은 없어야 한다. provider_verified=false를 유지하며 로컬 해제를 원격 키 폐기로 주장하면 실패. service clientFor의 신뢰할 수 있는 서버 사용자 인자 및 in-flight/quiet delete 한계는 문서와 구분한다.
9. 전체 suite·소유 Pint·PHP 문법·SQLite migration rollback/reapply 검증을 실행한다. PHP8.3/MySQL 실서버는 실제 사용하지 않았으면 미검증으로 남긴다. 기존 ORDER01/02 경계 회귀도 전체 suite로 확인한다.
10. **무력화 1회:** 부모에게 알리고 `ConnectionStore::registerFor()`의 `Crypt::encryptString($credential->authorizationKey())`만 `$credential->authorizationKey()`로 임시 교체한다. `RankfreeConnectionApiTest::test_registration_stores_authenticated_ciphertext_without_returning_key_material`이 평문 저장을 실제 감지해 실패해야 한다. try/finally 원문 복구·전후SHA동일·복구 후 재통과를 기록한다. 실제 키/외부 호출은 없다. 다른 제품 수정은 금지다.

버그는 재현 입력/위치/실제와기대로 부모에게 반환하고 고치지 않는다. 실제 명령·출력·독립 fixture/재현 방법·무력화 실패/복구·최종 해시·미검증을 보고서에 저장한다. 제품/공개 최종 판정은 Claude·대웅 검수와 구분한다.
