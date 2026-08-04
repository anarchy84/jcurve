# 기존 URL 보존·이관 정책 (절대 원칙: 색인 URL 404 금지)

> 2026-08-04 기존 워드프레스(Rank Math + Avada + WooCommerce) 사이트맵 전수 조사 결과.
> 원칙: **구글·네이버에 색인된 기존 문서는 전부 보존한다. 콘텐츠 문서는 URL 원형 유지, 기능 페이지만 301.**

## A. 원형 보존 (동일 URL을 Laravel 라우트로 그대로 서빙 — 콘텐츠 이식)

랭킹 자산. 콘텐츠를 워드프레스에서 그대로 가져와 새 사이트에서 **같은 URL로 200 응답**. 리다이렉트 없음.

| 기존 URL | 처리 | 비고 |
|---|---|---|
| `/` | 신규 홈 (콘텐츠 리뉴얼, URL 동일) | |
| `/seo/` | 보존 — SEO 서비스 페이지 | 신규 IA의 /services/seo를 만들지 않고 **이 URL을 그대로 서비스 페이지로 승격** |
| `/seo-backlinks/` | 보존 — 백링크 서비스 페이지 | |
| `/wordpress-agency/` | 보존 — 워드프레스 대행 페이지 | 신규 /services/wordpress 대신 이 URL 유지 |
| `/naver-place-marketing/` | 보존 | |
| `/naver-shopping-marketing/` | 보존 | |
| `/kakao-gift/` | 보존 | |
| `/coupang/` | 보존 | |
| `/about-us/` | 보존 — 회사소개 | 신규 /company 대신 이 URL 유지 |
| `/contact-us/` | 보존 — 문의 | 신규 /contact 대신 이 URL 유지 |
| `/blog/` | 보존 — 인사이트 목록으로 | /insights 만들지 않고 /blog 유지 |
| `/blog/seo/` | 보존 — 카테고리 | |
| `/blog/link-building/` | 보존 — 카테고리 | |
| `/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/` | **본문 그대로 이식** (한글 슬러그 URL 인코딩 포함 완전 동일) | 색인 아티클 |
| `/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/` | 본문 그대로 이식 | 색인 아티클 |
| `/seo/11가지-최고의-seo-실수와-이를-피하는-방법/` | 본문 그대로 이식 | 색인 아티클 |
| `/shop/` | 보존 — 부스팅샵 연결 허브로 | |
| `/shop/backlinks/seo-캠페인-베이직/` | 보존 — 상품 페이지 이식 | 우커머스 상품 3종 |
| `/shop/backlinks/seo-캠페인-프로/` | 보존 | |
| `/shop/backlinks/seo-캠페인-엘리트/` | 보존 | |

**→ PLAN.md URL 구조 개정**: /services/seo → `/seo/`, /services/wordpress → `/wordpress-agency/`, /company → `/about-us/`, /contact → `/contact-us/`, /insights → `/blog/`. 신규 페이지(퍼포먼스·CPA·리워드·솔루션·아나키)만 신규 URL.

## B. 301 리다이렉트 (기능 페이지 — 새 시스템의 등가 페이지로)

| 기존 URL | → 301 대상 |
|---|---|
| `/log-in/` | `/login` |
| `/join/` | `/register` |
| `/recover-password/` | `/forgot-password` |
| `/my-account/` | `/mypage` |
| `/cart/`, `/checkout/` | `/shop/` (신규엔 장바구니 없음 — 문의/부스팅샵 전환) |

## C. 정리 대상 (사용자 확인 완료 전까지는 301로 안전 처리)

Avada 테마 **데모 더미 페이지 13개** (lorem ipsum, 실콘텐츠 없음):
`/portfolio-items/` + `/portfolio-items/{cras-mollis-nons, enim-pellentesque, donec-et-sagittis, tras-commodo-ets, proin-tortor-orcus, class-et-aptent, iaculis-eu-gigni, donec-magna-velit, varius-lectus-ulla, duis-imperdiet-malis, non-mattis-tortor, faucibus-tellus}/`
→ 전부 `/work` 301. (검색 품질에 오히려 해로운 페이지들이라 보존 가치 없음. 단, 삭제·410은 쓰지 않고 301로 안전하게.)

## D. 미디어·부속 자산

- `/wp-content/uploads/**` — 색인 문서들이 참조하는 이미지 전부. **서버 이관 시 동일 경로로 통째 복사** (이미지 사이트맵 색인 유지).
- 트레일링 슬래시: WP는 `/slug/`, Laravel은 `/slug`. 보존 URL은 **트레일링 슬래시 원형까지 유지**하도록 라우팅 (301 홉 자체를 만들지 않는 게 목표).
- 한글 슬러그 라우팅: rawurldecode 기준 매칭, 인코딩/비인코딩 요청 모두 동일 200.

## E. 구현 방식 (Laravel)

1. `database/seeders/LegacyRedirectSeeder` + `legacy_redirects` 테이블(from_path unique, to_path, status_code) — B·C 항목 주입.
2. 미들웨어 `LegacyRedirectMiddleware`: 404 직전에 legacy_redirects 조회 → 301. (정상 라우트에 오버헤드 0)
3. A 항목은 정식 라우트로 등록 (routes/web.php).
4. 신규 sitemap.xml에 A 전체 포함 + lastmod는 이식 원본 날짜 유지.
5. 런칭 후 GSC·네이버 서치어드바이저에서 커버리지 모니터링 2주 — 404/소프트404 발생 시 즉시 매핑 추가.

## G. 구버전 사이트 `/v1/` + 루트 .php 랜딩 (2026-08-04 추가 조사)

워드프레스와 별개로 **그누보드 기반 구 사이트**가 공존 중. 전부 콘텐츠 보존 대상 (사용자 지시: "싹 다 살려야").

### G-1. 마케팅 칼럼 (~52편, 4페이지) — 전량 /blog 이식 + 301

- 원 URL: `/v1/manager/column/{한글슬러그}/` 및 `/v1/manager/bbs/board.php?bo_table=column&wr_id={N}`
- 처리: 본문·이미지·작성일 원문 그대로 insights로 이식 (카테고리: 퍼포먼스마케팅/페이스북/인스타그램/구글/브랜딩/콘텐츠마케팅 → insight_categories 매핑)
- 301: 두 URL 형태 모두 → `/blog/{슬러그}` (legacy_redirects)
- 브랜드 자산 글(벤처기업인증, NOBB 상표등록, 기업부설연구소, CRMPRO 개발, 아나키 강의, 마이인플루언서 론칭)은 E-E-A-T 근거로 /about-us 연혁 섹션에서도 링크

### G-2. 루트 .php 랜딩 17개 — 콘텐츠 흡수 후 301

| 기존 | 301 대상 (콘텐츠 이식처) |
|---|---|
| /cpa.php | /services/cpa-marketing (누적 광고비 373억·DB 128만건 등 실적 수치 이식) |
| /land.php | /services/cpa-marketing/real-estate (부동산 분양) |
| /stock.php | /services/cpa-marketing/stock (주식DB) |
| /insurance.php | /services/cpa-marketing/insurance (보험DB) |
| /coin.php | /services/cpa-marketing/coin (코인DB) |
| /permission.php | /services/cpa-marketing/permission-call (퍼미션콜DB) |
| /gfa.php | /services/performance-marketing/naver-gfa |
| /facebook.php | /services/performance-marketing/facebook |
| /youtube.php | /services/performance-marketing/youtube |
| /instagram.php | /solutions/boostingshop/instagram-popular |
| /followers_up.php | /solutions/boostingshop/instagram-followers |
| /instagram_likes.php | /solutions/boostingshop/instagram-likes |
| /shopping_marketing.php | /naver-shopping-marketing/ (WP 보존 페이지와 통합) |
| /shopping_smartstore.php | /naver-shopping-marketing/ |
| /marketing-support-project.php | /services/marketing-support (정부지원사업 — 신규 페이지) |
| /company.php | /about-us/ |
| /policy.php | /privacy (신규 개인정보처리방침) |

### G-3. /v1/ 기타

- /v1/ → / 301, /v1/contact.php → /contact-us/ 301, /v1/ad_campaign.php → /work 301
- /v1/portfolio.php (포트폴리오 235, 카테고리 12종 필터형·개별 상세 없음) → /work 301, 클라이언트 로고·카테고리 데이터는 /work 신설 시 이식
- 외부 도메인 링크(myinfluencer.co.kr, leadbay.co.kr, call2.sale, crmpro.co.kr, goodmarketing.co.kr)는 신규 사이트 솔루션/패밀리 사이트 섹션에 유지 (자사 생태계 = E-E-A-T 신호)
- 콘텐츠 원본은 `scripts/scrape_legacy.php`로 `database/content/legacy/`에 전량 백업 후 이식 작업

## F. 런칭 전 체크리스트

- [ ] A 목록 전 URL: 신규 서버에서 200 + 원본과 동일한 주제 콘텐츠
- [ ] 한글 슬러그 3개 아티클: 원문 100% 이식 (제목·본문·이미지)
- [ ] B·C 목록 전 URL: 301 + 올바른 도착지 (curl -I 전수 테스트 스크립트)
- [ ] /wp-content/uploads/ 미러링 완료
- [ ] 워드프레스 DB·파일 전체 백업 보관 (형님 서버 측)
