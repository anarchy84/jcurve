# SPEC-CODEX-INTL-03 — 블로그 52편 영어·일본어 번역 초벌 (Codex 구현 세션, A·B 두 세션으로 나눔)

- 작성: Claude, 2026-11-03. 작업 폴더 `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`. 원래 저장소 접근 금지.
- 먼저 읽을 것: `docs/intl/INTL-PLAN.md` §1·§5, **`docs/intl/GLOSSARY.md`(용어·숫자 정본)**, `docs/intl/INTL-01-IMPL-RESULT.md` §3 「번역 원문·시더」, `database/seeders/IntlInsightSeeder.php`, 예시 `database/content/intl/insights/mobile-marketing-strategies.json`.
- 대상 목록: `docs/intl/insights-list.json` — 공개 글 52편(발행순). 각 항목 `slug`(한국어), `cat`, `title`, `len`(본문 글자 수), `hash`(= `source_hash` 로 그대로 쓴다: 한국어 표시본 `$insight->content` SHA256).
  - **세션 A**: 목록 1~26번 / **세션 B**: 27~52번. 자기 범위 밖 파일은 만들지도 고치지도 않는다.

## 만들 것
- 글마다 `database/content/intl/insights/{영문 slug}.json` 1개 (`ko_slug`, `source_hash`, `en`, `ja` — 형식은 예시 파일·시더 그대로).
  - 예시 파일 `mobile-marketing-strategies.json`(`[EN DRAFT]`)은 그 글이 자기 범위에 있는 세션이 **실제 번역으로 교체**한다(파일 이름이 영문 slug 규칙과 다르면 지우고 새로 만든다).
- `en`·`ja` 각각: `slug`, `title`, `excerpt`, `content`, `meta_title`, `meta_description`.
  - `slug`: 영어 제목에서 만든 소문자 ASCII·하이픈, 4~8단어, 영·일 공통으로 같은 값 사용 가능(일본어도 영문 slug). 52편 안에서 유일.
  - `title`: 영어는 문장형 대소문자, 일본어는 자연스러운 제목. 한국어 제목의 「| 제이커브」 같은 꼬리는 넣지 않는다.
  - `meta_title` ≤ 60자(영) / ≤ 32자(일) 권장, `meta_description` ≤ 155자(영) / ≤ 110자(일) 권장, `excerpt` 1~2문장.
  - `content`: 한국어 HTML 의 **태그·속성·순서·이미지(src·개수)·표·목록 구조를 그대로** 두고 글자만 옮긴다. `alt`·`title` 속성도 번역. 새 문단·새 주장·새 숫자·새 출처를 만들지 않는다.

## 번역 원칙
- 충실 번역 + 외국 독자용 최소 현지화: 한국 플랫폼은 그 글에서 처음 나올 때 GLOSSARY §4 설명을 한 번 붙인다(괄호 또는 짧은 구). 한국 시장 배경이 없으면 이해가 안 되는 표현만 짧게 풀어 쓴다.
- 숫자: 값은 절대 그대로. %·건수·날짜·연도 동일. 원화는 환산 금지 — 영어 `KRW 500,000`, 일본어 `50万ウォン`. 「억·만」은 GLOSSARY §6 방식으로 자리만 옮긴다.
- 고유명사·제품명: GLOSSARY §5 표기. 사람·회사 이름은 원문에 있는 것만, 로마자 관용 표기.
- 말투: 영어는 명료한 B2B 블로그체, 일본어는 です・ます. 과장 형용사·최상급 추가 금지.
- **내부 링크**: 본문의 `j-curve.co.kr` 또는 `/` 로 시작하는 링크 중 외국어판이 있는 정적 페이지(INTL-01 결과 §2 표)는 같은 언어 주소로(`/en` + 경로). 다른 블로그 글로 가는 링크는 그 글의 번역 slug(`/{locale}/insights/{slug}`)로 — 다른 세션 범위의 글이면 `docs/intl/insights-list.json` 순서로 slug 를 확정할 수 없으므로 **한국어 링크 그대로 두고 반환물에 목록**으로 남긴다(Claude 가 마지막에 일괄 정리). 외부 링크는 그대로.

## 자동 점검 (스크립트로, 결과를 반환물에)
글마다 en·ja 각각:
1. 본문 텍스트(태그 제거)·title·excerpt·meta 에 **한글 0자** (예외 없음).
2. `<img>` 개수·src 집합 = 한국어와 동일, `<a>` 개수 동일, 표·목록 개수 동일.
3. 숫자 대조: 한국어 본문의 숫자 토큰 목록 vs 번역 본문 — 억·만 변환 외 차이는 목록으로(실패 아님, Claude 검수용).
4. HTML 파싱 오류 없음(DOMDocument, 한국어 원문 대비 새 오류 0).
5. slug 유일·형식, 메타 길이.
6. 시더 실행 후 `/en/insights/{slug}`·`/ja/insights/{slug}` 200, `php artisan intl:stale` 에 자기 범위 글 0.

## 합격 게이트
`php artisan test` 전체 그린, `php artisan db:seed --class=IntlInsightSeeder` 두 번 실행 후 행 수 동일(멱등), 위 자동 점검 전부 통과(3번은 목록만). 무력화 실험: 파일 하나의 en.content 에 한글 한 단어를 넣으면 점검 1이 실제로 실패하는지 — 원복 후 해시 동일.

## 금지
커밋·푸시·배포, 한국어 글·시더·마이그레이션·화면·테스트 수정, 자기 범위 밖 JSON 수정, `.env` 열람·변경, 포트 8000·8014·8023·8024·8031(서버가 필요하면 03A 는 8032, 03B 는 8033만).

## 추가 지시 (Claude, 2026-11-03 15:13 — 위 내용보다 이 절이 우선)
- **동시에 세 세션이 돈다**: INTL-02(나머지 페이지 화면·테스트·도우미 수정)와 INTL-03A·03B 가 같은 폴더에서 일한다. INTL-02 때문에 생기는 `php artisan test` 실패·변화는 **고치지 말고** 테스트 이름과 메시지를 반환물에 그대로 적는다. 합격 게이트의 「전체 그린」은 「내 파일 때문에 생긴 실패 0」으로 읽는다(근거: 내 JSON 을 잠깐 다른 곳으로 옮겼을 때와 결과가 같은지).
- **블로그 글 화면(`intl.insights.show`)은 INTL-02 가 만든다.** 아직 없으면 점검 6의 `/en/insights/{slug}` 200 은 「INTL-02 대기」로 적고, 대신 시더 후 `insight_translations` 행(글마다 en·ja 각 1)과 `php artisan intl:stale` 0 을 확인한다. Claude 가 합친 뒤 다시 확인한다.
- **임시 DB**: 실DB·Claude 임시 DB(`/private/tmp/.../intl.sqlite`)는 쓰지 않는다. 자기 전용 SQLite(`storage/framework/testing/intl03a.sqlite` / `intl03b.sqlite`)를 만들어 `migrate:fresh --seed` 로 한국어 글을 채운 뒤(공개 52편인지 확인) `IntlInsightSeeder` 를 돌린다. `DB_DATABASE` 는 **셸에 export 하지 말고 명령 하나에만** 붙인다(export 한 채로 테스트를 돌려 DB 가 지워진 적 있음).
- **파일 쓰기는 한 번에**: 시더가 폴더 전체를 읽으므로, 다른 세션의 반쯤 쓴 파일 때문에 시더가 깨질 수 있다. JSON 은 폴더 밖 임시 파일에 다 쓴 뒤 `mv` 로 옮긴다. 다른 세션 파일 때문에 시더가 실패하면 잠시 뒤 다시 돌리고 반환물에 적는다.
- **slug 충돌**: 끝내기 전에 폴더의 다른 세션 파일과 slug(영·일)를 대조한다. 겹치면 **03B 가** 자기 slug 에 구별 단어를 붙여 바꾼다.
- **예외 하나**: 예시 글(`mobile-marketing-strategies.json`, 03A 범위)은 slug `mobile-marketing-strategies` 를 그대로 쓴다(테스트·문서가 이 주소를 쓴다 — 4~8단어 규칙 예외). `[EN DRAFT]`/`[JA DRAFT]` 내용만 실제 번역으로 바꾼다.
- 같은 범위 안 다른 글로 가는 내부 링크는 그 글의 번역 slug 로 바꾼다. 다른 세션 범위 글이면 한국어 링크 그대로 + 목록(위 규칙 그대로).

## 반환물 `docs/intl/INTL-03{A|B}-IMPL-RESULT.md`
글별 표(한국어 slug → 영문 slug·영문 제목·일본어 제목·글자 수·점검 1~6 결과), 숫자 차이 목록, 남긴 한국어 링크 목록, 확신 없는 용어 목록, 실행 명령·실제 출력, 미검증 항목.
