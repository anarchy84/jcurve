# VERIFY-CODEX-URL-PRESERVE-01 — 독립 검증 지시서 (Codex 검증 세션)

- 작성: Claude, 2026-11-03. 대상: 작업 트리의 미커밋 변경(기준 커밋 `3cbe3d8`).
- 구현 지시서: `docs/SPEC-CODEX-URL-PRESERVE-01.md` (이게 합격 기준). 함께 검증할 Claude 변경: `resources/views/partials/jc/head.blade.php`(google-site-verification), `resources/views/partials/jc/gtm.blade.php`(신규), `resources/views/layouts/{jc,app}.blade.php`(gtm include), `config/services.php`(`gtm.id`), `.env.example`(`GTM_ID`).

## ⛔ 규칙
- **소스 수정 금지. 판정과 근거만 낸다.** 고칠 점은 「무엇이·어디서·어떻게 재현」으로 적는다.
- 커밋·푸시·배포·실서버 접속 금지. 포트 8000 서버 건드리지 말 것. 로컬 서버는 8012 포트, DB 는 임시 SQLite 파일(스크래치 경로)로.
- 테스트 무력화 실험(§T) 때만 임시 수정 허용 → **반드시 원복**하고, 실험 전후 `git diff | shasum` 이 같은지 출력으로 증명.

## 준비
1. 임시 SQLite 로 `php artisan migrate --force` → `DatabaseSeeder` 에서 `WorkSeeder` 를 뺀 시더만 실행(운영과 동일 조건). 시더 목록을 출력.
2. `SEO_PUBLIC_URL=https://j-curve.co.kr` 로 띄우고, 요청은 `Host: j-curve.co.kr` 헤더로(공개 호스트 조건). `php artisan serve --port=8012`.

## 공격 시나리오 (각각 PASS/FAIL + 실제 출력)
- **S1 원주소 15개**: 지시서 §A 표의 P 각각 → 200, `<link rel=canonical>`·`og:url` = `https://j-curve.co.kr` + P(끝 슬래시 포함), `<title>`·`<h1>` 이 비어 있지 않고 오류/404 화면이 아님. 13~15번은 ①소문자 hex 인코딩 ②대문자 hex ③인코딩 안 한 한글 세 형태로 요청.
- **S2 슬래시 없는 P** (`/about-us`, `/blog/seo` 등 15개) → 정확히 301 1홉 → P. `?utm_source=x&page=2` 붙여서 쿼리 보존 확인.
- **S3 새 경로 N 15개** → 301 1홉 → P, 쿼리 보존(`/insights?page=2` → `/blog/?page=2`).
- **S4 체인 전수**: `legacy_redirects` 전 행(301/302)에 대해 from_path 요청 → Location → 그 주소 요청이 **200** 이어야 함(다시 3xx 면 체인 = FAIL). 행 수·FAIL 목록 출력. `seo/{slug}` WP 글 3편 행이 남아 P 의 200 을 가리지 않는지도.
- **S5 내부 링크 크롤**: `/` 에서 시작해 같은 호스트 링크를 BFS 로 최대 300페이지 수집. 렌더된 `href` 중 요청 시 3xx·4xx·5xx 인 것 전부 목록(어느 페이지의 어느 링크인지). N 으로 가는 href 가 하나라도 있으면 FAIL. JSON-LD 안 URL 도 같은 기준.
- **S6 문의 폼**: `/contact-us/` 화면의 `<form action>` 주소 확인 → 그 주소로 ①정상 제출(CSRF·honeypot 정상) 성공 ②CSRF 없이 → 419 ③honeypot 채움 → 거부 ④1분에 6번째 → 429 ⑤필수값 빠짐 → `/contact-us/` 로 돌아와 오류. POST 가 301 로 튕겨 본문이 사라지는 경로가 있으면 FAIL.
- **S7 사이트맵·RSS**: `/sitemap.xml`(색인 파일이면 하위까지) 의 모든 `<loc>` 요청 → 전부 200. P 15개 포함·N 0개. 아나키 글 미포함. RSS 의 WP 글 3편 링크 = P.
- **S8 410**: 지시서 §C 30개 → 410, 본문에 `noindex`. 파라미터 순서 바꿈(`wr_id=19&bo_table=column`)·키 대문자 → 410. `wr_id=1` → 301(410 아님). `wr_id=999` → 404. `bo_table=column` 만 / `wr_id=` 빈 값 → 301 `/blog/`.
- **S9 v1 랜딩**: `/v1/gfa.php`, `/v1/youtube.php`, 그리고 §B-2 루트 랜딩 전부의 `/v1/X.php` → 301 1홉, 도착지 200.
- **S10 아나키(Q-026)**: 아나키 강의 글 상세 → 302 `/blog/`. 목록·카테고리·관련 글·사이트맵·RSS 어디에도 없음. `wr_id=51` → 301 `/blog/`. 스마트스토어 글 2편: 「초짜 셀러 아나키입니다」 문장 없음 + 제목·본문 나머지(본문 글자 수가 원문 대비 크게 줄지 않음) 그대로. S5 크롤 전체에서 「아나키」 가 나오는 페이지 목록(보고만).
- **S11 안 바뀌어야 하는 것**: `/services/seo/aeo`, `/services/seo/geo`, 다른 인사이트 글 2편, 다른 카테고리 1개, `/work`, `/self-marketing`, `/self-marketing/order`, `/solutions/shopitrend`, `/solutions/boostingshop/basic` → 200 + canonical 이 자기 주소. `/shop/` → 301 `/solutions/boostingshop`. `/portfolio-items/cras-mollis-nons/` → 301 `/work`. `/` → 200.
- **S12 열린 리다이렉트**: `GET //evil.example/`, `/%2f%2fevil.example`, `/\evil.example`, `/about-us//evil.example`, `/about-us/%2e%2e/` 등 → Location 이 외부 호스트·프로토콜 상대(`//`)로 나가면 FAIL. 슬래시 붙이는 301 이 P 목록 밖 경로에도 적용되면 FAIL.
- **S13 멱등**: 시더를 한 번 더 돌린 뒤 `legacy_redirects` 행 수·내용 동일, S4 재실행 결과 동일.
- **S14 호스트·태그**: ①`Host: dev.j-curve.co.kr` → robots `noindex, nofollow`, google-site-verification·GTM 없음 ②공개 호스트 + `GTM_ID` 빈 값 → GTM 없음, google-site-verification 1개 ③`GTM_ID=GTM-TEST123` → head 스크립트 1개 + body 바로 뒤 noscript iframe 1개, 두 레이아웃(jc·app) 각각 확인 ④`GTM_ID="GTM-X');alert(1);//"` → 출력 없음.
- **S15 품질 게이트**: `php artisan test` 전체(개수·실패 0), `./vendor/bin/pint --test`(변경 PHP 파일), `npm run build` 성공. 실제 출력.

## §T 테스트 무력화 실험 (필수)
1. §A 매핑(원주소 → 내용, N → P 301)을 임시로 끈다 → §A 테스트가 **실제로 빨개지는지**.
2. 410 처리를 임시로 301/404 로 되돌린다 → §C 테스트가 빨개지는지.
3. 각각 원복 → 전체 그린 재확인 → `git diff | shasum` 실험 전후 동일 출력.

## 반환
시나리오별 PASS/FAIL 표 → FAIL 은 재현 명령·실제 출력·원인 위치(파일:줄) → 무력화 실험 결과 → 미검증 항목. 최종 한 줄: 「운영 전환 커밋으로 써도 됨 / 안 됨」 과 이유.
