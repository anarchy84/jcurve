# Claude 최종 검수 기록 (다국어)

## INTL-02 (2026-11-03)
- 검증 결과 `INTL-02-VERIFY-RESULT.md`: 15개 중 12 PASS / 3 FAIL.
- **V7 FAIL → Claude 수정.** `partials/intl/switcher.blade.php` 의 `parse_url` 이 한글 UTF-8 경로 바이트를 깨뜨려(`및` → `�_`) 외국어 블로그 글의 KO 링크가 404. 「scheme://host」만 정규식으로 잘라 내는 방식으로 교체. 재확인: 임시 DB 에 번역 52편 시딩 후 `/en|ja/insights/*` 104화면 전부 200, KO 링크 전부 200·대체문자 0. 한국어 104주소 DIFF 0 유지.
- **V8 FAIL → 허용으로 판정(수정 없음).** `intl/pages/faq.blade.php:42-43` 의 `{!! json_encode(…, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) !!}` 는 스크립트 안 JSON 의 표준 안전 출력이고, 주입 실험에서도 실행 가능한 태그 0. 허용 목록에 「HEX 플래그를 모두 쓴 json_encode」를 추가한다.
- **V9 FAIL → 의도된 예외로 판정(수정 없음).** 홈 메타 설명은 외국 기업용 요약이라 한국어 메타의 「10년+·1,000개+」 대신 누적 373억(KRW 37.3B+) 라벨을 골랐다. 값을 바꾸거나 환산한 숫자는 0.
- 기계번역 발견: 서브페이지·FAQ·개인정보·블로그 1~26 이 Google 번역 무료 엔드포인트 초벌 → 외부 번역 금지로 재번역(INTL-04A~D). 블로그 27~52(03B)는 직접 번역이라 재번역하지 않음.
