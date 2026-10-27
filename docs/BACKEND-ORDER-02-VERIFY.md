# BACKEND-ORDER-02 독립 검증 지시서

사용자는 **고객별 랭크프리 계정 연결**을 선택했다. 이번 변경은 공통 서버 모듈을 요청별 고객 자격증명으로 분리하고 공용 키 fallback을 제거한다. 실제 연결 등록/암호화 DB/로그인/공개 주문·결제/배포는 대상이 아니다.

## 소유와 금지

검토: `app/Services/Rankfree/{CustomerCredential,RankfreeClient,RankfreeException}.php`, `config/rankfree.php`, `.env.example`, `tests/Feature/{RankfreeClient,RankfreeCustomerIsolation}Test.php`, `docs/BACKEND-ORDER-02.md`.

검증자는 제품/구현자 테스트를 수정하지 않는다. 보고서 `docs/BACKEND-ORDER-02-VERIFY-RESULT.md`만 소유한다. 타인이 함께 작업하므로 다른 변경을 되돌리지 않는다. `.env` 열람/로딩·실제 키·외부 API·실주문·실DB·프론트·git·배포 금지. 부모가 대시보드를 갱신한다. 이전 독립 보고서는 역사 기록이므로 수정하지 않는다.

별도 임시 config로 `.env` 없이 전체 suite·Pint·문법·독립 공격을 실행한다. HTTP는 fake/preventStrayRequests로 차단하고 fixture 원문·재현 명령은 보고서에 보관한다. 부모는 제품/테스트 파일을 동결한다.

## 공격/실패 기준

1. 고객A/B/A 순서와 교차된 상품 상세→주문POST→상태 조회에 정확한 Bearer 키가 쓰여야 한다. 같은 주문번호·서로 다른 고객의 결과를 전역 캐시로 섞으면 실패. config의 오래된 `rankfree.api_key` 값을 바꿔도 고객 키는 바뀌지 않아야 한다.
2. 연결없음·인증고객ID와 Credential.customerId 불일치·잘못된 고객ID·불량 키는 HTTP 이전에 거절해야 한다. 공용키 fallback을 허용하면 실패.
3. 고객 ID와 키 문맥은 생성 후 불변이다. 외부에서 생성자 우회로 무인증 기본 클라이언트를 만들 수 있다고 제공하면 실패. 신뢰할 수 있는 authenticatedCustomerId/저장레코드를 호출자가 제공해야 한다는 한계는 분명히 유지한다.
4. Credential/client의 JSON·var_dump·print_r·var_export·예외 문자열/trace에 모의 키 표식이 나오면 실패. serialize()/unserialize()로 Credential을 영속화/복원할 수 없어야 한다. native SensitiveParameterValue가 필요한 PHP환경도 확인한다.
5. 기존 ORDER01의 응답 필터·pending·서버 금액·고정 HTTPS·리다이렉트 금지·POST 자동 재시도 금지·불명 응답 분기를 유지해야 한다. 이전 독립 fixture가 있다면 생성 부분을 새 forCustomer 계약으로 바꾸되 공격 단언문은 약화하지 않는다.
6. 라우트·DB·인증 모델·프론트/미디어·실제 `.env`가 변경되지 않아야 한다. 실제 계정 연결/SSO/암호화저장 완료라고 주장하면 실패.
7. **무력화1회:** 부모에게 시작을 알리고 `RankfreeClient::forCustomer()`의 customerId 불일치 검사 블록만 임시 제거한다. `RankfreeCustomerIsolationTest::test_unlinked_or_wrong_customer_cannot_fall_back_to_global_key`가 실제 실패해야 한다. 이 테스트는 HTTP를 호출하지 않고 preventStrayRequests도 있다. try/finally로 원문 복구·전후SHA256 동일·복구 후 대상 테스트 PASS를 반드시 기록한다. 다른 제품 수정은 금지다.

## 반환

실행 결과·버그 입력/원본위치/실제와기대·독립 fixture·무력화 실패/복구·최종 소유파일SHA·미검증을 보고서에 작성한다. 버그를 고치지 말고 부모에게 반환한다. Claude 최종 제품 판단과 실제 공개 승인은 별도다.
