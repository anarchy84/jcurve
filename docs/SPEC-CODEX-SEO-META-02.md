# SPEC-CODEX-SEO-META-02 — 원주소 제목·설명문 원복 + 블로그 3편 정리 + 사이트맵 옛 주소 (Codex 구현 세션)

- 작성: Claude, 2026-11-03. 기준 커밋 `38c1327` + 작업 트리의 Claude 미커밋 변경(아래 §0).
- 배경: 운영 전환(워드프레스 → 이 라라벨 앱) 때 같은 주소의 제목이 바뀌면 검색 순위가 흔들린다. 제코 결정(11/3): 「seo 쪽으로 되돌리는게 맞아. 퍼포먼스 마케팅 에이전시는 아니야」 → 원주소 16개 `<title>` 을 운영 워드프레스 원문과 **글자 하나까지** 같게 한다.
- **기대값 정본: `docs/SEO-META-02-TITLES.json`** (16개 경로별 title·description). 테스트도 이 값을 그대로 쓴다.
- 함께 읽을 것: `docs/COLLAB.md`(파일 구역), `docs/collab/QUEUE.md` Q-013·Q-019, `docs/SPEC-CODEX-URL-PRESERVE-01.md`(원주소 정책).

## §0 Claude 가 이미 바꾼 것 (건드리지 말 것 — `resources/views/**` 는 Claude 구역)
- 홈·`/seo/`·`/wordpress-agency/`·`/about-us/`·`/contact-us/`·`/blog/`·카테고리 2개 제목/설명문을 JSON 값으로 교체.
- `pages/subpage.blade.php`: `$page['seo_title']` 이 있으면 `<title>` 로 그대로 쓰고, 없으면 기존 `title | 제이커브인터렉티브`.
- `partials/jc/head.blade.php`: 공개 호스트 기본 robots = `index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large` (워드프레스와 동일).
- `insights/show.blade.php` 는 안 바꿈: `<title>` = `(meta_title ?: title).' | 제이커브인터렉티브'`, H1 = `title`, 설명문 = `Str::limit(strip_tags(meta_description ?: excerpt), 155)`.

## ⛔ 규칙
- 소유 파일: `config/subpages.php`, `database/seeders/LegacyContentSeeder.php`, `app/Models/Insight.php`(필요 시), `routes/web.php`, `public/robots.txt`, `tests/**`.
- 금지: `resources/views/**`, `public/media/**`, `.env`, `database/content/legacy/**` 원문 파일(원문 보존 — 정리는 시딩/표시 단계에서), `WorkSeeder`. 커밋·푸시·배포·실서버 접속 금지. 포트 8000 서버 건드리지 말 것.
- 성과 수치(373억 등) 문구는 건드리지 않는다.

## §A 서브페이지 5개 — `config/subpages.php` 의 `seo.items`
`backlinks`·`naver-place`·`naver-shopping`·`kakao-gift`·`coupang` 각각에 `seo_title` 추가, `meta_description` 교체. 값은 JSON 의 `/seo-backlinks/`·`/naver-place-marketing/`·`/naver-shopping-marketing/`·`/kakao-gift/`·`/coupang/` 항목 그대로. `title`(H1·문의 템플릿에 쓰임)은 그대로 둔다.

## §B 블로그 워드프레스 글 3편 (Q-013 + Q-019②) — `LegacyContentSeeder`
대상 slug: `chrome-및-firefox에서-nofollow-링크를-확인하는-방법`, `11가지-최고의-seo-실수와-이를-피하는-방법`, `경쟁자를-압도하는-6가지-고급-링크-구축-전략`.
1. `title` = 꼬리 ` - SEO 전문 컨설팅 기업 | 제이커브인터렉티브` 를 뗀 순수 제목 (H1 용).
2. `meta_title` = 순수 제목 + ` - SEO 전문 컨설팅 기업` → 화면 `<title>` 이 JSON 값(워드프레스 원문)과 정확히 같아진다.
3. `meta_description` = JSON 의 해당 경로 description.
4. `excerpt` = 본문 앞 찌꺼기를 뺀 첫 문장들(「SEO BlogSEO에 대한 유용한 정보와 기사」, 제목 반복, 「1월 14th, 2025 jcurve」 같은 날짜·작성자 줄 없음).
5. `content`: 워드프레스 화면 잔재만 걷어 낸다 — 앞쪽 「SEO Blog」「SEO에 대한 유용한 정보와 기사」·제목 반복·날짜/작성자 줄, 뒤쪽 「Related Posts」「Search for:」「Categorys」「마음껏 공유해 가세요~」「← 인사이트 목록」 같은 위젯 블록. 본문 안 `<h1>` 은 `<h2>` 로(페이지 H1 과 중복 방지). **그 밖의 기사 문장·이미지·링크는 바꾸지 않는다.** 제거 전후 텍스트 차이를 반환물에 붙일 것.
6. 시더를 다시 돌려도 결과가 같아야 하고(멱등), **이미 DB 에 있는 행도 갱신**돼야 한다(운영은 시더 재실행으로 반영).
- 나머지 50편(옛 칼럼)과 아나키 숨김·문장 제거 동작은 그대로.

## §C 사이트맵·피드 옛 주소 — `routes/web.php`
운영 robots.txt 가 알리는 `/sitemap_index.xml`·`/news-sitemap.xml`, 그리고 `/wp-sitemap.xml`, 운영 `https://j-curve.co.kr/sitemap_index.xml` 안에 나열된 하위 사이트맵 전부(먼저 실제로 받아서 목록 확정) → **301 한 번에 `/sitemap.xml`**. `/feed`·`/feed/` → 301 `/rss`. GET·HEAD. `PreservePublicUrls` 와 겹쳐 2홉이 되지 않게.

## §D `public/robots.txt`
`User-agent: *` / `Disallow:` 유지 + `Sitemap: https://j-curve.co.kr/sitemap.xml` 한 줄 추가.

## §E 테스트
- 공개 호스트(`SEO_PUBLIC_URL=https://j-curve.co.kr`, Host `j-curve.co.kr`)에서 JSON 16개 경로: `<title>` 이 JSON title 과 정확히 같음, `<meta name="description">` 이 정확히 1개이고 JSON description 과 같음(블로그 3편은 155자 제한 후 값).
- 홈 `<title>` 에 「퍼포먼스 마케팅 에이전시」 없음.
- 공개 호스트 robots 에 `max-image-preview:large` 포함, dev 호스트는 여전히 `noindex, nofollow`.
- 블로그 3편: H1 = 순수 제목, 본문·설명문·excerpt 에 「SEO BlogSEO에」·「jcurve」 날짜 줄 없음, 본문 `<h1>` 0개.
- §C 주소 각각 301 1홉, 도착지 200.
- 시더 2회 실행 후 3편 값 동일.
- 기존 테스트 중 바뀐 제목·robots 를 단언하던 것은 새 기대값으로 고친다(무엇을 왜 바꿨는지 반환물에 적기).

## 합격 게이트
`php artisan test` 전체 그린(개수 출력), `./vendor/bin/pint --test`(변경 PHP), `npm run build` 성공. 실제 출력 붙이기.

## 반환물
`docs/SEO-META-02-IMPL-RESULT.md` 에: 변경 파일 목록, 핵심 diff 요약, §B 제거 전후 텍스트 차이(글별), 실행 명령과 실제 출력, 바꾼 기존 테스트와 이유, 미검증 항목.
