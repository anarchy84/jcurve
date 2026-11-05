# VERIFY-CODEX-INTL-03 — 블로그 52편 영어·일본어 번역 독립 검증 (Codex 검증 세션)

- 작성: Claude, 2026-11-03. 작업 폴더 `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`.
- **수정하지 마라. 판정과 근거만 낸다.** 실험으로 파일을 잠깐 바꿨으면 반드시 원복하고 해시가 실험 전과 같은지 적는다.
- 읽을 것: `docs/intl/SPEC-CODEX-INTL-03.md`(맨 아래 「추가 지시」 포함), `docs/intl/INTL-03A-IMPL-RESULT.md`·`INTL-03B-IMPL-RESULT.md`(구현 세션 주장 — 믿지 말고 재현), `docs/intl/GLOSSARY.md`, `docs/intl/insights-list.json`.
- 실DB·`.env`·Claude 임시 DB 사용 금지. 자기 전용 SQLite(`storage/framework/testing/verify03.sqlite`)를 `migrate:fresh --seed` 로 채워서. `DB_DATABASE` 는 명령 하나에만 붙인다. 서버가 필요하면 포트 8042만.
- 점검은 **직접 짠 스크립트로** 한다(구현 세션 스크립트 재사용 금지). 52편 전부, en·ja 각각.

## 공격 시나리오 (항목마다 PASS/FAIL + 근거)

| # | 공격 | FAIL 조건 |
|---|---|---|
| T1 | **빠진 글·남은 초안.** `insights-list.json` 52개 `slug` ↔ JSON 파일의 `ko_slug` 1:1. `[EN DRAFT]`·`[JA DRAFT]`·`TODO`·`TBD`·`translation`·`번역` 같은 자리표시 문자열. | 빠진 글·중복·자리표시 1건이라도 |
| T2 | **원문 해시.** 각 파일 `source_hash` = 현재 한국어 표시본 `$insight->content` SHA256(직접 계산). 시더 후 `php artisan intl:stale` 0. | 불일치 / stale 1건 이상 |
| T3 | **한글 0.** title·excerpt·meta_title·meta_description·content(태그 제거 텍스트)·content 안 `alt`·`title` 속성. | 1자라도 |
| T4 | **구조 보존.** 한국어 vs en·ja: `<img>` 개수·src 집합, `<a>` 개수, `<table>`·`<tr>`·`<td>`, `<ul>`·`<ol>`·`<li>`, `<h2>`~`<h4>`, `<p>` 개수, `<iframe>`·embed. DOMDocument 파싱 오류가 한국어 대비 새로 생겼는지. | 개수·src 다름 / 새 파싱 오류 |
| T5 | **지어낸 내용·빠진 내용.** 글마다 문단(`<p>`)별 길이 비율(en/ko·ja/ko)을 계산해 이상치 목록(예: en/ko < 0.8 또는 > 4.5, ja/ko < 0.5 또는 > 2.5). 이상치 상위 10개 문단은 한국어·번역을 나란히 보고 「빠짐/추가/정상」 판정. 무작위 5편은 처음부터 끝까지 문단 대조. | 빠진 문장·새 주장·새 출처 1건이라도 |
| T6 | **숫자.** 한국어 본문 숫자 토큰 vs 번역. 억·만 자리 이동(GLOSSARY §6) 외의 값 변경, 원화 환산(USD·$·円 금액 새로 생김), 연도·%·건수 변경. | 값 변경·환산 1건이라도 (표기 차이는 목록만) |
| T7 | **링크.** 외부 링크 href 집합 = 한국어와 동일. 내부 링크: 외국어판이 있는 정적 페이지 → 같은 언어 주소, 같은 세션 범위 글 → 그 번역 slug(그 slug 가 실제로 있는지), 다른 범위 글 → 한국어 링크 그대로이면서 반환물 목록에 있음. 목록에 없는 한국어 내부 링크가 남아 있으면 FAIL. | 위 규칙 위반 1건이라도 |
| T8 | **slug·메타.** slug 소문자 ASCII·하이픈, 52편 안에서 유일(en·ja 각각), `mobile-marketing-strategies` 유지. 메타 길이 권장 초과는 목록만. | 형식 위반·중복·예외 slug 변경 |
| T9 | **용어집.** 제품명 표기(RankFree·BoostingShop·ShopiTrend·LeadBay·Call2Sale), 한국 플랫폼(네이버·카카오·쿠팡·당근 등)이 나오는 글에서 첫 등장 설명이 한 번 붙었는지. 회사명 표기 J-Curve Interactive. | 제품명 오기 (설명 누락은 목록만) |
| T10 | **말투.** 일본어 본문이 です・ます 체인지(문장 끝 だ・である 비율 목록), 영어에 과장 최상급(best·No.1·leading 등)이 원문에 없는데 새로 생겼는지. | 원문에 없는 최상급·과장 추가 (말투 비율은 목록만) |
| T11 | **시더.** `IntlInsightSeeder` 두 번 실행 후 행 수 동일(멱등), 글마다 en·ja 각 1행. `intl.insights.show` 뷰가 있으면 `/en/insights/{slug}`·`/ja/insights/{slug}` 52×2 전부 200·Location 없음·canonical 자기 주소·hreflang ko 는 그 한국어 글 주소. | 하나라도 |
| T12 | **범위 밖 변경.** `git status` 기준 03 세션이 만든·고친 파일은 `database/content/intl/insights/*.json` 과 결과 문서뿐인지. | 그 밖의 파일 변경 |
| T13 | **점검 무력화 실험.** 파일 하나의 en.content 에 한글 한 단어, ja.content 에서 `<img>` 하나 삭제, 숫자 하나 변경 → 구현 세션이 만든 점검 스크립트가 각각 실제로 실패하는지(스크립트 경로는 결과 문서에서). 원복 후 해시 동일. | 하나라도 통과해 버림 |

## 반환물 `docs/intl/INTL-03-VERIFY-RESULT.md`
항목별 표(PASS/FAIL·근거·명령·실제 출력 일부), 글별 요약 표(ko slug → en slug·T3~T7 결과), T5 이상치 판정 목록, T6 숫자 차이 목록, 확신 없는 번역 표현 목록(최대 40개, 글·문장), 원복 확인 해시, 검증 못 한 항목.

## 추가 (Claude, 2026-11-03 — 재번역 반영. 위 표보다 이 절이 우선)
- 현재 상태: **1~26번은 INTL-04D 가 다시 번역**(외부 번역 금지, 결과 `docs/intl/INTL-04D-IMPL-RESULT.md`), **27~52번은 INTL-03B 직접 번역**(결과 `INTL-03B-IMPL-RESULT.md`). 1~26번의 03A 기계번역 초벌 결과(`INTL-03A-IMPL-RESULT.md`)는 참고만.
- 재번역 전 사본: `/private/tmp/claude-501/-Users-anarchy-Claude-Projects-jcurve/782fb1b7-1762-465f-befa-38be705ecc7f/scratchpad/pre04/insights-03a/`(1~26번 기계번역판 포함). 구현 로그: 같은 폴더 `codex-intl03b.log`·`codex-intl04d.log`.
- 추가 공격:

| # | 공격 | FAIL 조건 |
|---|---|---|
| T14 | **외부 번역.** 03B·04D 로그에서 실제 웹 요청 흔적(`translate.googleapis`·`translate_a`·`deepl.com`·`papago`·`curl http`). 지시서 인용·영어 단어(deeply 등) 오탐과 구별. | 실제 호출 1건이라도 |
| T15 | **용어집 §8·기계번역 흔적.** 금지 예(ペット·オペレーティングシステム·地面·グラウンド·カウンセリング·インフロー·operating system·top exposure·inflow·counseling·remodeling) 0. 한국어에 `반려`·`지면`·`소재`·`운영 체계`·`DB`(리드)·`상담` 이 있는 문단은 §8 대응을 쓰는지 목록. | 금지 예 1건이라도 |
| T16 | **뜻 뒤집힘.** 한국어 문단에 부정·면책(`않습니다` `없습니다` `아닙니다` `보장` `금지` `하지 마`)이 있으면 번역에도 부정이 있는지 전수, 의심 건은 직접 읽고 판정. | 부정·면책 누락·반대 뜻 1건이라도 |
| T17 | **의미 대조 표본(가장 중요).** 글마다 무작위 3문단 × en·ja(seed 를 적는다) = 312쌍을 한국어와 나란히 읽고 OK/어색/오역. 오역·어색은 대안 문장. 이미 알려진 의심 1건: 49번(인스타그램 인기게시물) 일본어 「Instagramは非常に強い施策です」(원문 뜻은 강력한 마케팅 채널). 같은 유형(施策·素材·露出 남용, 주어 빠진 직역, 잘린 문장)을 글 전체에서 검색해 목록으로. | 오역(뜻이 다름) — 건수와 위치를 전부 적는다 (어색은 목록만) |

## 경로 변경 (Claude, 2026-11-03 17:10 — 세션 종료로 첫 실행 중단)
- 위 「재번역 전 사본」·「구현 로그」의 `/private/tmp/...scratchpad/` 가 없으면 작업 폴더 안 사본을 쓴다: `storage/app/intl-handoff/pre04/`(기계번역판), `storage/app/intl-handoff/logs/codex-intl03b.log.gz`·`codex-intl04d.log.gz`(`gzip -dc` 로 읽는다).
- 첫 실행이 남긴 `storage/framework/testing/verify03.sqlite` 는 지우고 새로 만들어도 된다.
