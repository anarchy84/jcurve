# VERIFY-CODEX-INTL-01 — 다국어 기반 독립 검증 (Codex 검증 세션)

- 작성: Claude, 2026-11-03. 대상: 작업 폴더 `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`(브랜치 `wip/2026-11-03-i18n`) 의 기준 `0662117` 이후 변경 전부.
  - Codex 구현분: `docs/intl/INTL-01-IMPL-RESULT.md` §6 파일 목록.
  - Claude 화면분: `resources/views/layouts/intl.blade.php`, `resources/views/partials/intl/**`, `resources/views/intl/pages/home.blade.php`, `lang/{en,ja}/menu.php`, `lang/{en,ja}/pages/home.php`, `resources/css/jc.css` 끝부분(INTL 주석 아래).
- 합격 기준: `docs/intl/SPEC-CODEX-INTL-01.md`, 설계 정본 `docs/intl/INTL-PLAN.md`(특히 §1 절대 원칙·§2 주소 규칙), 용어·숫자 `docs/intl/GLOSSARY.md` §6.

## ⛔ 규칙
- **소스 수정 금지. 판정과 근거만 낸다.** 고칠 점은 「무엇이·어디서(파일:줄)·어떻게 재현」으로.
- 커밋·푸시·브랜치 변경·배포 금지. 원래 저장소 `/Users/anarchy/Claude_Projects/jcurve` 는 읽지도 쓰지도 않는다. 포트 8000·8014·8023 서버 건드리지 말 것 — 필요하면 8030 대, DB 는 `$TMPDIR` 의 임시 SQLite.
- 기준 코드는 `git archive 0662117 | tar -x -C "$TMPDIR/intl-base"` 로 풀고 vendor·node_modules·public/build 는 작업 폴더 것을 링크(작업 폴더 `git worktree add` 금지). 끝나면 임시 폴더 삭제.
- §T 무력화 실험 때만 임시 수정 허용 → 반드시 원복, 실험 전후 `git status --porcelain | shasum` 과 `git diff | shasum` 같음을 출력으로 증명.

## 준비
임시 SQLite 에 `migrate --force` → `db:seed --force`(WorkSeeder 는 호출되지 않아야 함 — 확인). `SEO_PUBLIC_URL=https://j-curve.co.kr`, 요청 Host `j-curve.co.kr`.

## 공격 시나리오 (각각 PASS/FAIL + 실제 출력)
- **V1 한국어 무변경(가장 중요)**: 기준 `0662117` 과 현재를 같은 시더·환경으로 띄워 한국어 페이지 HTML 비교 — 사이트맵의 한국어 주소 전부 + 원주소 16개 + `/company` `/contact` `/services` `/solutions` `/self-marketing` `/self-marketing/order` `/support/faq` `/login` `/register` `/community`(있으면) `/seo-check`. 정규화는 CSRF 토큰·Vite 해시 파일명만(`jc.css` 가 바뀌어 해시가 달라지는 건 정상). 그 밖의 차이가 한 줄이라도 있으면 FAIL(경로·diff). 응답 상태·Location 헤더도 비교. `Accept-Language: en` / `ja` 헤더로 한국어 페이지를 요청해도 결과가 같아야 한다.
- **V2 외국어 주소**: INTL-01 결과 §2 의 43주소 × en·ja 를 전수 요청 → 홈 2개 200, 나머지는 「뷰 없음 404」(500 은 FAIL). 제외 구역 404: `/en/login` `/en/register` `/en/dashboard` `/en/profile` `/en/my-account` `/en/community` `/en/self-marketing/order` `/en/seo-check` `/en/support/inquiries` `/en/work/아무거나` `/en/rss` `/en/sitemap.xml`(ja 도 같게). 이상한 주소: `/EN/`, `/en`, `/en//about-us/`, `/en/./about-us/`, `/en/%2e%2e/`, `/en%2Fabout-us`, `/ko/`, `/fr/`, `/en/en/` — 500·한국어 화면 노출·열린 리다이렉트(`//evil.com`) 없어야 함.
- **V3 301 한 번**: `/en/company`→`/en/about-us/`, `/en/about-us`→`/en/about-us/`, `/en/contact`→`/en/contact-us/`, `/en/insights`→`/en/blog/`, `/en/services/seo`→`/en/seo/`, `/ja/services/seo/backlinks`→`/ja/seo-backlinks/` 등 한국어 쪽 301 규칙 전부를 외국어 접두로 — 1홉, 쿼리(중복 키·인코딩 포함) 보존, HEAD 도 동일, 루프 없음. 옛 워드프레스·v1 별칭을 `/en` 아래에서 요청했을 때 동작 목록(보고만).
- **V4 글**: 번역 없는 글 `/en/insights/{한국어 slug}` 404(한국어 본문 대신 출력 금지). 숨김 글(`seo.hidden_insights`)·미래 발행 글에 번역 행을 직접 넣어도 404. 번역 slug 로 en 200 / 같은 slug 로 ja 요청 시 ja 번역 없으면 404. 카테고리는 그 언어 번역 공개 글이 있을 때만 200. 목록 페이지네이션 `?page=2` 주소가 그 언어 주소.
- **V5 hreflang·canonical**: `/en/`·`/ja/`·`/` 의 canonical 자기 주소, hreflang ko·en·ja·x-default 서로 가리킴. **뷰가 없어 404 인 외국어 주소를 가리키는 hreflang·og:locale:alternate·사이트맵 항목이 있는지** — 현재 상태에서 개수와 예시를 보고(지금은 한국어 head 에 hreflang 이 없으므로 외국어 페이지·사이트맵 기준). `intl_alternates()` 를 404 대상 페이지 문맥에서 호출하면 무엇을 내는지.
- **V6 사이트맵**: 한국어 항목 순서·내용·lastmod 기준과 동일, 외국어 항목 수, 중복 0, XML 유효. 외국어 항목 각각의 실제 상태코드 분포(200/404).
- **V7 문의**: `POST /en/contact-us/` → `leads.locale = en`, ja 도. 본문에 `locale=ko`·`locale=xx` 를 넣어도 주소가 이김. 한국어 POST 는 null. CSRF 없으면 419, honeypot·시간 검사·throttle 이 외국어 경로에도 똑같이 걸림(횟수 초과 재현). 검증 실패 메시지가 그 언어, 리다이렉트가 그 언어 문의 주소. 이름·메시지에 `<script>` 넣고 재표시 시 이스케이프.
- **V8 언어 새는지**: 같은 PHP 프로세스(테스트 한 개 안)에서 `/en/` → `/` → `/ja/` → `/about-us/` 순서로 요청했을 때 한국어 응답에 영어·일본어 문구, `lang="en"` 등이 섞이지 않음. 세션·쿠키로 언어가 고정되지 않음.
- **V9 번역 데이터**: 시더 두 번 실행 → 행 수·내용 동일. 없는 `ko_slug` 는 경고 후 건너뜀. 한국어 글 content 를 바꾸면 `php artisan intl:stale` 에 나옴. 마이그레이션 rollback(down) 후 재 migrate 정상. 글 삭제 시 번역 cascade.
- **V10 화면(Claude 분)**: `/en/`·`/ja/` 본문 텍스트에 한글 0자, 번역 키 노출(`menu.` `pages/home.` 같은 문자열) 0. 숫자가 한국어 홈과 GLOSSARY §6 대응대로인지(373억↔KRW 37.3B·373億ウォン, 128만↔1.28M·128万件, 15,700) — 다른 숫자가 생겼으면 FAIL. 페이지의 모든 내부 링크 수집 → 외국어 주소인지, 제외 구역(로그인·주문·진단·문의게시판)으로 가는 링크 0, 한국어 주소로 새는 링크 목록(보고). 언어 전환 링크가 같은 페이지의 다른 언어로 가는지. 390px 폭에서 가로 스크롤 없음(가능하면 헤드리스로).
- **V11 품질 게이트**: `php artisan test` 전체(개수·실패 0), 변경·신규 PHP 에 `./vendor/bin/pint --test <파일들>`, `npm run build`. 실제 출력.

## §T 테스트 무력화 실험 (필수)
1. 외국어 접두 인식 301 을 끄면 → 301 테스트가 실제로 빨개지는지.
2. 번역 없는 글 404 필터를 끄면 → 해당 테스트가 빨개지는지.
3. `ContactController` 가 locale 을 폼 값에서 읽게 바꾸면 → 문의 locale 테스트가 빨개지는지.
4. 한국어 뷰 하나(`resources/views/pages/company.blade.php`)에 공백 한 글자를 넣으면 → V1 비교 방법(또는 테스트)이 실제로 차이를 잡는지.
5. 각각 원복 → 전체 그린 재확인 → 실험 전후 해시 동일.

## 반환
`docs/intl/INTL-01-VERIFY-RESULT.md`: 시나리오별 PASS/FAIL 표 → FAIL·주의는 재현 명령·실제 출력·원인 위치(파일:줄) → 무력화 실험 결과 → 미검증 항목. 마지막 줄: 「다음 단계(화면 확장)로 넘어가도 됨 / 안 됨」과 이유.
