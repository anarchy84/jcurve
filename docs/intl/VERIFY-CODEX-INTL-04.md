# VERIFY-CODEX-INTL-04 — 다시 번역한 서브페이지·FAQ·개인정보처리방침 독립 검증 (Codex 검증 세션)

- 작성: Claude, 2026-11-03. 작업 폴더 `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`.
- **수정하지 마라. 판정과 근거만 낸다.** 실험으로 바꾼 파일은 원복하고 해시를 적는다.
- 대상 파일: `lang/en/subpages.php`(04A), `lang/ja/subpages.php`(04B), `lang/{en,ja}/pages/faq.php`·`lang/{en,ja}/pages/privacy.php`(04C).
- 한국어 원문: `config/subpages.php`, `resources/views/pages/faq.blade.php`, `resources/views/pages/privacy.blade.php`.
- 재번역 전 사본(기계번역판): `/private/tmp/claude-501/-Users-anarchy-Claude-Projects-jcurve/782fb1b7-1762-465f-befa-38be705ecc7f/scratchpad/pre04/{en-subpages,ja-subpages,en-faq,ja-faq}.php`.
- 구현 세션 로그: 같은 폴더의 `codex-intl04a.log`·`codex-intl04b.log`·`codex-intl04c.log`.
- 읽을 것: `docs/intl/SPEC-CODEX-INTL-04.md`, `docs/intl/GLOSSARY.md`(§6 숫자, §8 업계 용어), 결과 문서 `docs/intl/INTL-04{A,B,C}-IMPL-RESULT.md`(주장 — 믿지 말고 재현).
- 실DB·`.env`·Claude 임시 DB 사용 금지. 같은 폴더에서 04D(블로그 1~26 재번역)가 아직 돈다 — `database/content/intl/insights/*.json` 은 범위 밖.

## 공격 시나리오 (항목마다 PASS/FAIL + 근거·명령·실제 출력 일부). 점검은 직접 짠 스크립트로.

| # | 공격 | FAIL 조건 |
|---|---|---|
| U1 | **외부 번역 사용.** 세 로그에서 실제 웹 요청 흔적(`translate.googleapis`·`translate_a`·`deepl.com`·`papago`·`curl http`·`file_get_contents('http`·`Http::get`)을 찾는다. 지시서 본문 인용과 실제 호출을 구별해 적는다. | 실제 호출 1건이라도 |
| U2 | **구조·기술값.** 재번역 전 사본과 키 목록 완전 동일. 한국어 원문 값과 바이트가 같은 잎(아이콘·주소·숫자 등 번역 대상 아님)은 재번역 후에도 바이트 동일. | 키 차이·기술값 변경 |
| U3 | **한글 0·키 노출 0.** 파일 문자열 전부 + 렌더 화면(서브페이지 19개·FAQ·개인정보 × en·ja, 보이는 글자·title·meta·alt·aria-label·JSON-LD). 예외는 언어 전환 블록의 「한국어」뿐. | 1건이라도 |
| U4 | **숫자.** 잎마다 한국어 숫자 토큰 vs 번역(GLOSSARY §6 억·만 대응 허용). | 값 변경·원화 환산·연도/% 변경 1건이라도 (표기 차이는 목록만) |
| U5 | **뜻이 뒤집힘(가장 중요).** 한국어 잎에 부정·면책 표현(`않습니다` `없습니다` `아닙니다` `보장하지` `보장할 수 없` `약속하지` `제공하지` `판매하지` `금지`)이 있으면 번역에도 부정(EN not/no/never/cannot/without/neither, JA ません/ない/いいえ/できません/保証しません 등)이 있어야 한다. 전수 목록 + 의심 건은 직접 읽고 판정. | 부정·면책이 빠지거나 반대 뜻 1건이라도 |
| U6 | **용어집 §8.** 한국어 잎에 `반려` `지면` `소재` `운영 체계` `DB`(리드 뜻) `상담` `상위노출` `인정`(유효 인정) `리모델링`이 있으면 번역이 §8 대응을 쓰는지 표로. §8 「틀린 예」 단어(ペット·地面·グラウンド·オペレーティングシステム·カウンセリング·operating system·material·top exposure·inflow·counseling·remodeling)가 하나라도 있으면 FAIL. | 틀린 예 1건이라도 (대응 불일치는 목록) |
| U7 | **누락·추가.** 잎별 길이 비율 이상치(en/ko < 0.8 또는 > 4.5, ja/ko < 0.5 또는 > 2.5) 전수 목록, 상위 15건은 직접 읽고 「누락/추가/정상」. 원문에 없는 실적·최상급·보장 문구가 생겼는지(EN best·leading·No.1·guarantee 긍정형, JA 業界No.1・最高・保証します). | 누락·새 주장 1건이라도 |
| U8 | **FAQ·개인정보 형상.** FAQ 81문항 en·ja(한국어와 순서·분류 동일), FAQPage JSON-LD 파싱·문항 수 일치. 개인정보 조항 수·순서 = 한국어, 맨 위 「한국어 원문 우선」 고지 en·ja 존재, 법령 이름(개인정보 보호법 등)·기간·기관명 누락 없음. | 불일치·누락 |
| U9 | **번역 품질 표본.** 언어별 무작위 30잎(seed 를 적는다) + U5·U6 의심 건을 한국어와 나란히 읽고 OK / 어색 / 오역 판정, 오역·어색은 대안 문장 제시. | 오역(뜻이 다름) 1건이라도 (어색은 목록만) |
| U10 | **게이트.** `php artisan test`(통과/전체), 대상 PHP 6개 `./vendor/bin/pint --test`·`php -l`, 서브페이지 19 × 2·FAQ·개인정보 렌더 200·`<html lang>` 맞음. 04D 때문에 생긴 실패는 따로 표시. | 빨강 |

## 반환물 `docs/intl/INTL-04-VERIFY-RESULT.md`
항목별 표, U5·U6·U7·U9 의 전수/표본 목록(파일·키·한국어·번역·판정·대안), 원복 해시, 검증 못 한 항목. 마지막 메시지는 반환물 경로와 PASS/FAIL 개수만.
