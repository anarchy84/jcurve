# Claude 최종 검수 기록 (다국어)

## INTL-02 (2026-11-03)
- 검증 결과 `INTL-02-VERIFY-RESULT.md`: 15개 중 12 PASS / 3 FAIL.
- **V7 FAIL → Claude 수정.** `partials/intl/switcher.blade.php` 의 `parse_url` 이 한글 UTF-8 경로 바이트를 깨뜨려(`및` → `�_`) 외국어 블로그 글의 KO 링크가 404. 「scheme://host」만 정규식으로 잘라 내는 방식으로 교체. 재확인: 임시 DB 에 번역 52편 시딩 후 `/en|ja/insights/*` 104화면 전부 200, KO 링크 전부 200·대체문자 0. 한국어 104주소 DIFF 0 유지.
- **V8 FAIL → 허용으로 판정(수정 없음).** `intl/pages/faq.blade.php:42-43` 의 `{!! json_encode(…, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) !!}` 는 스크립트 안 JSON 의 표준 안전 출력이고, 주입 실험에서도 실행 가능한 태그 0. 허용 목록에 「HEX 플래그를 모두 쓴 json_encode」를 추가한다.
- **V9 FAIL → 의도된 예외로 판정(수정 없음).** 홈 메타 설명은 외국 기업용 요약이라 한국어 메타의 「10년+·1,000개+」 대신 누적 373억(KRW 37.3B+) 라벨을 골랐다. 값을 바꾸거나 환산한 숫자는 0.
- 기계번역 발견: 서브페이지·FAQ·개인정보·블로그 1~26 이 Google 번역 무료 엔드포인트 초벌 → 외부 번역 금지로 재번역(INTL-04A~D). 블로그 27~52(03B)는 직접 번역이라 재번역하지 않음.

## INTL-04A~C 재번역 (2026-11-03)
- 검증 결과 `INTL-04-VERIFY-RESULT.md`: 10개 중 6 PASS / 4 FAIL(U2·U5·U7·U9). 외부 번역 호출 0, 한글 0, 숫자 값 변경 0, 용어집 금지어 0, 표본 60개 중 OK 57.
- **의미 결함 3곳(U5·U7·U9) → Claude 직접 수정**(`lang/en/subpages.php`). 일본어 같은 키는 원문 뜻대로라 그대로.
  - `cpa.items.insurance.sections.4.title`: 비교 대상 누락 → "Standard vs. consented leads: the difference is verification before delivery"
  - `performance.items.youtube.lead`: 「조회수를 사는 일이 아닙니다」가 "more than"으로 약해짐 → "is not about uploading lots of videos or buying views"
  - `boostingshop.items.instagram-popular.cta.title`: 「노출 자리를 사기보다」 누락 → "Instead of buying placement, give people a reason to discover you"
- **U2 FAIL → 허용으로 판정.** 바뀐 58잎은 기술값이 아니라 한국어판에도 영어로 쓰인 사람용 eyebrow("Fit Check"→"Fit check" 등 문장형 대소문자 통일). 키·자료형·기술값 변경 0.

## 화면 점검 (2026-11-03, 에고 브라우저)
- 모바일 가로 넘침: 외국어 페이지만 넘침(한국어는 같은 조건에서 정상). 원인 3개 → `resources/css/jc.css` 맨 아래 `.jc-intl` 전용 규칙으로 수정.
  - 헤더: 영·일 버튼 글자가 길어 로고+문의+메뉴 합이 화면을 넘음 → ≤480px 에서 로고 보조어 숨김·간격·여백 축소
  - 홈 서비스 목록: 영어 긴 낱말이 그리드 칸을 밀어냄 → `min-width: 0`
  - 가격 카드 큰 숫자(72px 한 줄 고정) → ≤480px 에서 `clamp(36px, 12vw, 72px)`
  - 일본어 가격 문구 「個別見積もり」(72px 에서 426px) → 「要見積」
- 재확인: 외국어 14화면 × 폭 320·360·390·430 넘침 0, 한국어 104주소 DIFF 0.

## INTL-03 블로그 52편 (2026-11-04) — 합격
- 제코 지시 「코덱스 시키지 말고 너가 다 마무리해」 → Codex 없이 진행. 기계 점검은 Claude 메인 스크립트, 52편 **전문** 뜻 대조·수정은 Claude 서브에이전트 6개, 검증은 수정 안 한 별도 Claude 검증 세션 2개. 상세 `INTL-03-VERIFY-RESULT.md`.
- 오역 123·어색 1,093건 수정(바뀐 줄 1,148). 일본어 문장 누락·부정 약화·인과 뒤집힘(40번)·업종명 오역(38번)·원문에 없는 내용 추가가 주된 오역. 49번 「非常に強い施策」 해결.
- 검증: 표본 90줄 OK 86·어색 3·FAIL 1(52번 b185 → Claude 메인이 원문 구조대로 수정), 17~25번 표본 40줄 FAIL 0, 「오역」 수정 119행 중 117행 정확(틀린 2행 = 위 52번 b185 의 EN·JA, 수정 완료).
- 판정: 원문 최상급을 약하게 옮긴 곳은 용어집 §1(B2B 단정·과장 금지)에 따라 **허용**. 숫자 점검 T6 의 「10대」·「1도」 표기 차이는 정상 번역으로 허용.
- 수정 중 메타 제목이 본 제목과 같아져 권장 길이를 넘은 9개 → 원래 값으로 원복.
- 끝 상태: 태그·속성 HEAD 대비 52편 전부 동일, 한글 0, stale 0, 시더 멱등, 104화면 200, `php artisan test` 206/206.
- 진행 중 실수 기록: G3(17~25)가 아직 고치는 중에 「6개 다 끝났다」고 잘못 판단하고 1차 점검을 돌렸다 → G3 종료 뒤 전 점검을 다시 돌리고 17~25 전용 검증 세션을 따로 붙였다.
