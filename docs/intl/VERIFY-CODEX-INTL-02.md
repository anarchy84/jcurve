# VERIFY-CODEX-INTL-02 — 영어·일본어 나머지 페이지 독립 검증 (Codex 검증 세션)

- 작성: Claude, 2026-11-03. 작업 폴더 `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`.
- **수정하지 마라. 판정과 근거만 낸다.** 실험으로 파일을 잠깐 바꿨으면 반드시 원복하고 `git diff | shasum` 이 실험 전과 같은지 적는다.
- 읽을 것: `docs/intl/SPEC-CODEX-INTL-02.md`(맨 아래 「추가 지시」 포함), `docs/intl/INTL-02-IMPL-RESULT.md`(구현 세션 주장 — 믿지 말고 재현), `docs/intl/INTL-PLAN.md` §1·§5, `docs/intl/GLOSSARY.md`.
- 실DB·`.env`·Claude 임시 DB 사용 금지. 서버가 필요하면 포트 8041만, 자기 전용 SQLite(`storage/framework/testing/verify02.sqlite`)를 `migrate:fresh --seed` 로 채워서. `DB_DATABASE` 는 명령 하나에만 붙인다(셸 export 금지).

## 공격 시나리오 (항목마다 PASS/FAIL + 재현 명령 + 실제 출력 일부)

| # | 공격 | FAIL 조건 |
|---|---|---|
| V1 | **한국어 무변경.** 기준 0662117 과 현재를 기준 사이트맵 모든 주소 + 제외 구역(`/login` `/register` `/community` `/self-marketing/order` `/seo-check` `/dashboard`) + 이동 주소(`/company` `/contact` `/insights` `/services/seo`)로 비교. 301·302 는 따라가지 않고 상태·Location·본문 비교. 허용 차이는 현재 쪽 `^<link rel="alternate" hreflang=…>\n` 줄과 `<nav class="jc-lang…" data-intl-switcher>…</nav>\n` 블록뿐(정규화: CSRF·허니팟 `my_name_*`·`valid_from`·SVG id `(sbg\|sgl\|sdot)-*`·Vite 해시). 구현 세션의 비교기를 쓰지 말고 **직접 짠 스크립트로** 한 번 더. | 그 밖의 차이 1건이라도 |
| V2 | **비교기 무력화.** 한국어 뷰 하나(예: `resources/views/partials/jc/footer.blade.php`)에 공백 한 칸을 넣고 갱신된 `tests/Support/intl_compare.py`(또는 그것을 부르는 테스트)를 돌린다. 지우는 정규식이 RSS 등 다른 `<link rel="alternate">` 나 다른 `<nav>` 까지 지우지 않는지 코드로 확인. | 공백을 넣어도 초록 / 정규식이 허용 블록 밖까지 지움 |
| V3 | **한글 0.** 외국어 사이트맵의 모든 주소 + `config('intl.routes')` 의 모든 라우트(서브페이지 19개 × en·ja 포함)를 받아, 보이는 글자·`<title>`·meta description·og·twitter·`alt`·`title`·`aria-label`·`placeholder`·`value`·JSON-LD 문자열에서 한글을 센다. 예외는 언어 전환 블록(`data-intl-switcher`) 안의 「한국어」 표기뿐. | 예외 밖 한글 1자라도 |
| V4 | **번역 키 노출.** 위 화면들에서 `pages/` `menu.` `subpages.` `insights.` `validation.` 같은 원문 키 모양 문자열. | 1건이라도 |
| V5 | **hreflang 상호성.** 외국어판이 있는 한국어 페이지와 그 en·ja 페이지 각각: canonical = 자기 주소, hreflang ko·en·ja·x-default 4개, 가리키는 주소가 모두 200·Location 없음, 세 페이지의 hreflang 집합이 서로 같음. 외국어판이 없는 한국어 페이지(로그인·커뮤니티·주문·번역 없는 블로그 글 등)는 `<link rel="alternate" hreflang` 0. | 하나라도 어긋남 |
| V6 | **V5 수정(뷰 존재 확인) 무력화.** 라우트→뷰 매핑 한 개를 없는 뷰 이름으로 바꾸면: 그 한국어 페이지 hreflang 0, 사이트맵에서 그 외국어 주소 빠짐, 외국어 주소 404. 뷰 확인 코드를 되돌리면 관련 테스트가 **실제로 빨개지는지**. 그리고 외국어 사이트맵의 모든 주소가 200·Location 없음인지. | 셋 중 하나라도 안 맞음 / 되돌려도 초록 / 사이트맵에 200 아닌 주소 |
| V7 | **제외 구역 링크.** 외국어 화면의 모든 `href`·`action`: `/en`·`/ja` 접두가 없는 사이트 내부 주소(언어 전환의 KO 링크 제외), 로그인·회원가입·마이페이지·커뮤니티·셀프마케팅 주문·`seo-check`·문의게시판·`work/{slug}` 로 가는 것, 카카오 버튼. 폼은 `en.contact.store`/`ja.contact.store` 로 가는 문의 폼뿐인지. 페이지 안 내부 링크는 전부 200(또는 의도된 301 1홉). | 1건이라도 |
| V8 | **출력 이스케이프.** `resources/views/intl/**` 와 `partials/intl/**` 의 `{!! !!}` 전수. 허용: 블로그 본문 `$translation->content`(한국어 show 와 같은 방식), `JSON_HEX_TAG` 를 쓴 JSON-LD. 번역 문자열·`__()` 결과를 `{!! !!}` 로 내는 곳이 있으면 FAIL. 실험: lang 값 하나에 `<script>alert(1)</script>` 를 넣고 렌더해서 그대로 실행 가능한 태그로 나오는지(원복). | 허용 밖 `{!! !!}` / 태그가 살아서 나옴 |
| V9 | **숫자.** 페이지마다 한국어 렌더본의 숫자 토큰 vs en·ja 렌더본. GLOSSARY §6 대응(373억+ → `KRW 37.3B+`/`373億ウォン+`, 128만+ → `1.28M+`/`128万件+`, 15,700+ 등) 외의 값 차이, 원화 환산(USD·$·円 금액이 새로 생김), 「2026년 기준」「회사 전체 누적」 같은 라벨 누락. | 값 변경·환산·라벨 누락 1건이라도 (단순 표기 차이는 목록만) |
| V10 | **고지 유지.** `marketing-support` 의 「선정·지원금 보장 안 함」 취지 고지, `privacy` 맨 위 「한국어 원문 우선」 한 줄(영·일), 성과 수치 고지 문구가 외국어판에도 있는지. | 누락 |
| V11 | **문의.** `/en/…contact…`·`/ja/…` POST: 정상 입력 → `leads.locale` = en/ja, `service_interest` 는 한국어 허용 목록 안 값만 저장. 허용 밖 값·빈 필수값 → 그 언어 오류 문구(한글 0). 허니팟 걸리면 저장 안 됨. 한국어 문의와 같은 throttle·CSRF 미들웨어가 붙어 있는지(라우트 목록으로). | 하나라도 |
| V12 | **FAQ.** 한국어 FAQ 문항 수 = en = ja (81). FAQPage JSON-LD 파싱 성공·문항 수 일치·`inLanguage` 있음. | 불일치 |
| V13 | **한국어 쪽 파일 무변경.** `git status`/`git diff --stat` 기준: 한국어 뷰(`resources/views/**` 중 `intl/`·`layouts/intl*`·`partials/intl/` 밖)·`config/subpages.php`·한국어 lang 변경은 Claude 의 3개 파일(`partials/jc/head`·`partials/jc/header`·`partials/intl/switcher`)뿐인지, 그 3개도 구현 세션이 고치지 않았는지(INTL-02 결과 문서의 변경 파일 표와 대조). | 그 밖의 한국어 쪽 변경 |
| V14 | **테스트 무력화 실험 재현.** 구현 세션이 적은 실험을 직접 다시: lang 키 하나 삭제 → 키 노출 테스트 빨강, 템플릿에 한글 한 단어 → 한글 0 테스트 빨강, 뷰 확인 제거 → V6 테스트 빨강, 한국어 뷰 공백 → 무변경 테스트 빨강. | 하나라도 초록 |
| V15 | **게이트.** `php artisan test`(통과/전체), 새·변경 PHP `./vendor/bin/pint --test`, `npm run build`(EPERM 이면 `npx vite build --configLoader runner`). INTL-03 세션 JSON 때문에 생긴 실패는 따로 표시. | 빨강 |

## 반환물 `docs/intl/INTL-02-VERIFY-RESULT.md`
항목별 표(PASS/FAIL·근거·명령·실제 출력 일부), FAIL 은 재현 절차와 파일:줄, 숫자 차이 목록, 확신 없는 번역 표현 목록(최대 30개, 화면·키·문장), 원복 확인 해시, 검증 못 한 항목.

## 참고 (Claude, 15:43)
- 같은 폴더에서 INTL-03A·03B(블로그 번역)가 아직 돈다. `database/content/intl/insights/*.json` 은 검증 범위 밖이고 건드리지 않는다. 실험으로 파일을 바꿀 때는 짧게 하고 바로 원복한다.
- 구현 뒤 Claude 가 본보기 메타 길이를 줄였다: `lang/en/pages/{home,company,contact}.php`, `lang/ja/pages/company.php` 의 title·description 한 줄씩. 이것도 V3·V9(숫자·라벨) 대상에 넣는다.
- Claude 실측(15:40): 한국어 104개 주소 DIFF 0, 외국어 사이트맵 90개(en 45·ja 45) 전부 200·한글 0·키 노출 0. 이 숫자를 믿지 말고 직접 재현한다.
