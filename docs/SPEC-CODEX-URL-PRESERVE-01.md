# SPEC-CODEX-URL-PRESERVE-01 — 운영 전환 전 주소 48개 맞추기 (Codex 구현 지시서)

- 작성: Claude, 2026-11-03 · 기준 커밋 `3cbe3d8` (+ 작업 트리: `resources/views/partials/jc/head.blade.php` 에 google-site-verification 한 줄 추가됨 — 건드리지 말 것)
- 배경: 서버 담당(형님 쪽 봇)이 `3cbe3d8` 을 운영 서버 별도 폴더에 올려 주소 정리표 144개를 시험함 → **48개 불일치**. 이걸 고친 커밋이 있어야 j-curve.co.kr 전환이 진행된다. 광고 집행이 이 전환을 기다리고 있어 오늘 끝내야 한다.
- 결정권자 지시(제코, 10/28): 「원래 주소로 둘 수 있으면 최대한 원래 주소로 두고, 그렇지 않은 부분은 301」 · 「최대한 SEO에 해가 안 되는 방식」 · 「글이 없는 애는 삭제(410)」.
- 정리표 원본: Slack `jcurve-url-map.csv`(10/28). 시험 실패 목록: Slack `staging-fails.txt`(11/2). 아래 표가 그 내용을 옮긴 것이다 — 이 문서가 SSOT.

## 0. 하지 말 것 (금지)
- 커밋·푸시·배포 금지. 실서버·실DB 접속 금지.
- `database/seeders/WorkSeeder.php`, `public/media/**`, 성과 수치 문구, `resources/css/**`, `resources/js/**` 수정 금지.
- 화면 문장·디자인 변경 금지(아래 §B-2 문장 1개 제외 처리만 예외).
- 아래 표에 없는 기존 주소의 응답(200/301 대상)을 바꾸지 말 것. 특히 칼럼 50편의 `wr_id` 301, 포트폴리오 더미 13개 → `/work` 301, 랜딩 `.php` 301 은 그대로.
- 새 의존성 추가 금지. 새 마이그레이션은 꼭 필요할 때만, **추가형(additive)** 으로만.

## A. 원래 주소 유지 15개 (정리표 A — 지금은 301, 200 이어야 함)

| # | 원래 주소 P (이게 정식 주소) | 지금 내용을 그리는 새 경로 N |
|---|---|---|
| 1 | `/about-us/` | `/company` |
| 2 | `/contact-us/` | `/contact` (GET 화면 + POST 접수) |
| 3 | `/blog/` | `/insights` (목록·페이지네이션) |
| 4 | `/blog/seo/` | `/insights/category/seo` |
| 5 | `/blog/link-building/` | `/insights/category/link-building` |
| 6 | `/seo/` | `/services/seo` |
| 7 | `/seo-backlinks/` | `/services/seo/backlinks` |
| 8 | `/wordpress-agency/` | `/services/wordpress` |
| 9 | `/naver-place-marketing/` | `/services/seo/naver-place` |
| 10 | `/naver-shopping-marketing/` | `/services/seo/naver-shopping` |
| 11 | `/kakao-gift/` | `/services/seo/kakao-gift` |
| 12 | `/coupang/` | `/services/seo/coupang` |
| 13 | `/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/` | `/insights/chrome-및-firefox에서-nofollow-링크를-확인하는-방법` |
| 14 | `/seo/11가지-최고의-seo-실수와-이를-피하는-방법/` | `/insights/11가지-최고의-seo-실수와-이를-피하는-방법` |
| 15 | `/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/` | `/insights/경쟁자를-압도하는-6가지-고급-링크-구축-전략` |

(16번째 `/` 홈은 이미 통과 — 그대로.) 13~15 의 실제 요청은 퍼센트 인코딩(소문자 hex, 예: `/seo/chrome-%eb%b0%8f-…/`)으로 들어온다. 인코딩·비인코딩 둘 다 같은 결과여야 한다.

### 계약 (HTTP 동작 — 이걸로 판정한다)
1. `GET P`(끝 슬래시 포함, 정리표 그대로) → **200**, N 이 지금 그리는 것과 같은 화면(제목·설명·본문 동일). 쿼리스트링(`?page=2` 등)도 그대로 동작.
2. `<link rel="canonical">` 와 `og:url` = `{SEO_PUBLIC_URL}` + **P (끝 슬래시 포함)**. 지금 head 는 `request()->path()` 로 만들어서 슬래시가 빠진다 → 고쳐라. 이번 작업에 한해 `resources/views/partials/jc/head.blade.php` 의 `$jcPath`/`$jcCanonical` 계산 부분 수정을 허용한다(다른 줄은 손대지 말 것). 페이지가 `@section('canonical')` 로 덮는 경우도 P 기준이 되게.
3. `GET P` 에서 끝 슬래시를 뺀 주소(예: `/about-us`) → **301 → P** (1홉, 워드프레스와 같은 동작). 쿼리스트링 보존.
4. `GET N` → **301 → P** (1홉). 쿼리스트링 보존. (N 은 공개된 적 없는 주소라 SEO 손실 없음 — 정식 주소를 P 하나로 모으는 것)
5. **사이트 안 모든 링크가 P 를 가리킨다**: 헤더·메가메뉴·모바일 메뉴·푸터·홈 매대·CTA·브레드크럼·JSON-LD·사이트맵·RSS·`llms.txt`(있으면)·관련 글 링크. `route()`/`url()` 로 만든 주소가 P 로 나오게 하는 게 정석이다(힌트: `URL::formatPathUsing()` 같은 생성 단계 한 곳에서 매핑 — 구현 방식은 Codex 판단). 렌더된 HTML 에 N 으로 가는 `href` 가 남으면 실패.
6. **문의 폼이 끝까지 동작**: `/contact-us/` 화면에서 제출 → 저장·성공 화면, 검증 실패 → `/contact-us/` 로 돌아와 오류 표시. CSRF·honeypot(Spatie)·`throttle:5,1` 그대로 유지. 폼 `action` 이 바뀌면 그 주소의 POST 가 같은 미들웨어를 타야 한다.
7. 사이트맵(`/sitemap.xml`)에는 P 만 나오고 N 은 안 나온다. RSS 의 13~15번 글 링크도 P.
8. `config('seo.preserved_paths')` 를 위 15개(+`/`)로 맞춘다. `/shop/` 은 정리표에서 C(→`/solutions/boostingshop` 301)라 목록에서 뺀다(지금 301 동작 유지). URL 감사(`UrlAuditManifest`/`SeoUrlAuditTest`)가 이 목록 기준으로 통과해야 한다.
9. `/services/seo/aeo`, `/services/seo/geo`, 다른 `/insights/{slug}`, 다른 `/insights/category/{slug}`, `/services/*` 나머지는 **그대로 200** (P 매핑 대상이 아님).
10. 13~15 이외의 `/seo/{아무거나}` → 지금처럼 404 → 레거시 조회 훅(없으면 404).

### 체인 정리 (같이 바꿔야 함 — 1홉 원칙)
기존 301 중 도착지가 N 인 것은 **P 로 바로** 보낸다(N 을 거쳐 2홉이 되면 실패):
- `v1/company.php` → `/about-us/` · `contact.php`, `v1/contact.php` → `/contact-us/`
- `shopping_marketing.php`, `shopping_smartstore.php` → `/naver-shopping-marketing/`
- `company/anarchy` → `/about-us/` (지금 `/company#anarchy`. Q-026 ③)
- `LegacyContentSeeder` 가 등록하는 WP 글 3편 `seo/{slug}` → `/insights/{slug}` 301 은 이제 P 가 200 이므로 등록하지 않게(이미 들어간 행은 시더 재실행 시 지워지거나 무해해야 함).
- 그 밖에 시더·라우트·설정에서 도착지가 N 인 301 이 있으면 전부 P 로.
- **시더는 운영에서 다시 돌린다** → `updateOrCreate` 처럼 몇 번 돌려도 같은 결과(멱등)여야 한다.

## B. 301 추가 3개 (정리표 B — 지금 404)
| 요청 | 기대 |
|---|---|
| `/v1/gfa.php` | 301 → `/services/performance-marketing/naver-gfa` |
| `/v1/youtube.php` | 301 → `/services/performance-marketing/youtube` |
| `/v1/manager/bbs/board.php?bo_table=column` (wr_id 없음 또는 빈 값) | 301 → `/blog/` |

- 같이: `LegacyRedirectSeeder` §B-2 의 루트 랜딩 `X.php` 전부에 대해 `v1/X.php` 도 같은 도착지로 등록(구 서버가 `/X.php` → `/v1/X.php` 로 넘기던 주소라 색인돼 있을 수 있음). 이미 있는 `v1/insurance.php` 는 그대로.

## C. 글 없는 칼럼 30개 → 410 (정리표 C — 지금 404)
- 대상: `/v1/manager/bbs/board.php?bo_table=column&wr_id=N`, N ∈ {19, 21, 29, 38, 47, 52, 56, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80}.
- 기대: **HTTP 410**. 본문은 짧은 안내(「삭제된 글이에요」 + `/blog/`·홈 링크), `<meta name="robots" content="noindex">`. 리다이렉트 아님.
- 지금 404 훅은 `redirect($to_path, $status_code)` 만 한다 → 410 행이면 410 응답을 그리게 고친다. 쿼리 파라미터 순서·대소문자 달라도 같은 결과(`buildQueryKey` 규칙 유지).
- 위 30개 이외 `wr_id`(1~57 중 살아 있는 글)의 301 은 그대로.

## B-2. 아나키 글 가리기 (Q-026, 제코 10/27 확정 「잠시 가리자」 — 운영 공개 전 필수)
- ① 인사이트 `온라인-마케팅-제대로-배울-수-있는-아나키-강의` : 목록·카테고리·관련 글·사이트맵·RSS 에서 제외, 상세 주소는 **302 → `/blog/`**. 되돌릴 수 있게 숨김 플래그/설정으로(글·원문 삭제 금지). `wr_id=51` 은 **301 → `/blog/`** 로 바로(302 체인 금지).
- ② `스마트스토어-검색광고가-꼭-필요할까`, `스마트스토어-내게-맞는-키워드-발굴하는-법` : 도입부 「…초짜 셀러 아나키입니다.」 문장만 **표시본에서** 뺀다(본문 나머지·주소·제목 유지). 원문 보존본 `database/content/legacy/columns/*` 는 수정 금지.

## 소유 파일 (이 안에서만)
`routes/**`, `bootstrap/app.php`, `app/**`, `config/seo.php`, `database/seeders/LegacyRedirectSeeder.php`, `database/seeders/LegacyContentSeeder.php`, `database/migrations/**`(추가형만), `resources/views/errors/410.blade.php`(신규 가능), `resources/views/partials/jc/head.blade.php`(canonical 계산 줄만), `tests/**`.
- 화면(Blade) 안에 N 이 하드코딩돼 있으면 고치지 말고 **목록으로 보고**(Claude 가 고친다). `menu.php` 등이 `route()`/`url()` 을 쓰면 생성 단계 매핑으로 자동 해결돼야 한다.

## 합격 게이트 (실제 출력 붙여서 반환)
1. 새 기능 테스트: §A 15개 × (1)(2)(3)(4), §A-6 폼 POST 성공·실패, §A-5 렌더 HTML 에 N href 없음(홈·회사·문의·인사이트 목록·SEO 서비스·글 1편), §A-7 사이트맵, §A 체인 6건 1홉, §B 3개 + v1 랜딩, §C 30개 410, §B-2 ①②.
2. `php artisan test` 전체 그린(기존 98개 포함). 기존 테스트를 이 지시서 때문에 고쳐야 하면 무엇을 왜 고쳤는지 목록으로.
3. `./vendor/bin/pint --test` (변경 파일) 통과.
4. `npm run build` 성공(뷰가 바뀌므로).
5. 로컬 실서버 확인: `php artisan migrate:fresh --seed` 가 아니라 **임시 SQLite DB** 로 마이그레이션 + 운영과 같은 시더만(`LegacyRedirectSeeder`, `LegacyContentSeeder`, 그 밖에 WorkSeeder 를 뺀 것) 돌린 뒤 `php artisan serve --port=8011` 로 띄워 `curl -sI` 로 §A~§C 대표 20개 이상의 상태코드·Location·canonical 실제 출력. (8000 포트는 다른 서버가 쓰는 중 — 건드리지 말 것)
6. **테스트 무력화 실험** 1회: 매핑(§A)을 임시로 끄면 §A 테스트가 실제로 빨개지는지 → 원복 → 다시 그린. 실험 전후 `git diff --stat` 동일 확인.

## 반환물
변경 파일 목록 · `git diff --stat` · 핵심 diff · 실행 명령과 **실제 출력** · 바꾼 기존 테스트 목록 · Blade 하드코딩 N 목록 · 미검증 항목. 「됐다」는 증거가 아니다.
