# VERIFY-CODEX-SEO-META-02 — 독립 검증 지시서 (Codex 검증 세션)

- 작성: Claude, 2026-11-03. 대상: 작업 트리의 미커밋 변경 전부(기준 커밋 `38c1327`). Claude 변경(`resources/views/**` 9개 파일)과 Codex 변경(`docs/SEO-META-02-IMPL-RESULT.md` 참고) 둘 다.
- 합격 기준: `docs/SPEC-CODEX-SEO-META-02.md`, 기대값 정본 `docs/SEO-META-02-TITLES.json`.

## ⛔ 규칙
- **소스 수정 금지. 판정과 근거만 낸다.** 고칠 점은 「무엇이·어디서·어떻게 재현」으로.
- 커밋·푸시·배포·실서버 쓰기 금지(운영 j-curve.co.kr 은 GET 읽기만 허용). 포트 8000 서버 건드리지 말 것 — 로컬 서버는 8013 포트, DB 는 스크래치 경로의 임시 SQLite.
- 기준 비교가 필요하면 `git worktree add <스크래치>/base 38c1327` 로 따로 띄운다(작업 트리 변경 금지). 끝나면 worktree 제거.
- 테스트 무력화 실험(§T) 때만 임시 수정 허용 → 반드시 원복, 실험 전후 `git diff | shasum` 같음을 출력으로 증명.

## 준비
임시 SQLite 에 `migrate --force` → `DatabaseSeeder` 에서 `WorkSeeder` 뺀 시더만 실행(운영과 동일). `SEO_PUBLIC_URL=https://j-curve.co.kr` 로 8013 에 띄우고 요청은 `Host: j-curve.co.kr`.

## 공격 시나리오 (각각 PASS/FAIL + 실제 출력)
- **V1 제목·설명 16개**: JSON 의 경로마다 `<title>`(HTML 엔티티 풀어서) == JSON title, `<meta name="description">` 정확히 1개 == JSON description(블로그 3편은 155자 제한 적용 값), `og:title` == title. 하나라도 다르면 FAIL — 경로·기대·실제 출력.
- **V2 운영과 대조**: 운영 `https://j-curve.co.kr` 16개 경로의 `<title>` 을 직접 받아 로컬과 글자 단위 비교(V1 과 별개로, JSON 이 틀렸을 가능성까지 잡기).
- **V3 포지셔닝**: 모든 원주소·홈의 title/description/og 에 「퍼포먼스 마케팅 에이전시」 없음.
- **V4 성과 수치 보존**: `git diff 38c1327` 에서 「373억」「15,700」「128만」 등 숫자가 들어간 줄이 사라지거나 바뀐 곳 목록. 홈 본문에 `373억+`·`15,700+`·`128만+` 그대로 보이는지.
- **V5 블로그 3편 본문**: 기준(worktree 로 시딩한 DB) 대비 새 본문의 텍스트 diff. 제거된 조각이 전부 워드프레스 화면 잔재(「SEO Blog」「SEO에 대한 유용한 정보와 기사」·제목 반복·날짜/작성자 줄·Related Posts·Search for·Categorys·공유 문구·목록 링크)인지 하나씩 판정. 기사 문장이 한 글자라도 빠지거나 바뀌었으면 FAIL. `<img>` 개수·src 동일, 본문 내 기사 링크 동일. 페이지 전체 `<h1>` 1개, H1 == 순수 제목.
- **V6 다른 글 무변경**: 나머지 50편(+아나키 숨김 글)의 title·meta_title·meta_description·excerpt·content 해시가 기준과 같은지. 아나키 문장 제거 2편 동작 그대로.
- **V7 시더 갱신·멱등**: 기준 커밋으로 시딩한 DB 에 새 `LegacyContentSeeder` 를 실행 → 3편이 새 값으로 **갱신**되는지(운영 경로). 한 번 더 실행 → 전 테이블 행 수·내용 동일.
- **V8 홈·목록 카드**: 홈·`/blog/`·카테고리 목록에서 3편 요약에 「SEO BlogSEO에」·「jcurve」 날짜 줄 없음.
- **V9 사이트맵·피드 옛 주소**: 운영 `sitemap_index.xml` 에 나열된 하위 사이트맵 전부 + `/sitemap_index.xml`·`/news-sitemap.xml`·`/wp-sitemap.xml` → 301 **1홉** `/sitemap.xml` → 200. `/feed`·`/feed/` → 301 1홉 `/rss` → 200. HEAD 도. `/sitemap.xml`·`/rss` 자체는 200(루프 없음). 목록 밖 임의 `*-sitemap.xml` 은 404 여도 됨(보고만).
- **V10 robots**: `/robots.txt` 200, `Sitemap: https://j-curve.co.kr/sitemap.xml` 1줄, `Disallow:` 빈 값(전체 허용) 유지. 공개 호스트 meta robots = `index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large`. `Host: dev.j-curve.co.kr` → `noindex, nofollow`. 410 페이지 noindex 유지.
- **V11 서브페이지 부작용**: 5개 서브페이지 H1·문의 버튼 링크의 message 파라미터가 기준과 같음(`title` 키 안 바뀜). `seo_title` 없는 다른 서브페이지(cpa·performance·boostingshop 그룹 각 1개 이상)의 `<title>` 이 기준과 같음.
- **V12 카테고리**: `/blog/seo/`·`/blog/link-building/` 외 카테고리 1개 이상은 `X 인사이트 | 제이커브인터렉티브` 그대로. `/blog/seo/?page=2` 도 200 + 같은 제목.
- **V13 회귀(URL-PRESERVE-01)**: 원주소 15개 200 + canonical, N→P 301 1홉(쿼리 보존), 410 30개, `/v1/gfa.php` 301 — 표본이 아니라 전수.
- **V14 품질 게이트**: `php artisan test` 전체(개수·실패 0), `./vendor/bin/pint --test`, `npm run build`. 실제 출력.

## §T 테스트 무력화 실험 (필수)
1. `config/subpages.php` 의 `seo_title` 5개를 임시로 지움 → 제목 테스트가 **실제로 빨개지는지**.
2. 시더의 3편 정리 로직을 임시로 끔 → 블로그 3편 테스트가 빨개지는지.
3. 사이트맵 옛 주소 라우트를 임시로 지움 → 해당 테스트가 빨개지는지.
4. `head.blade.php` 기본 robots 를 임시로 `index, follow` 로 → robots 테스트가 빨개지는지.
5. 각각 원복 → 전체 그린 재확인 → `git diff | shasum` 실험 전후 동일.

## 반환
`docs/SEO-META-02-VERIFY-RESULT.md`: 시나리오별 PASS/FAIL 표 → FAIL 은 재현 명령·실제 출력·원인 위치(파일:줄) → 무력화 실험 결과 → 미검증 항목. 마지막 한 줄: 「운영 반영 커밋으로 써도 됨 / 안 됨」 과 이유.
