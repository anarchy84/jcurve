# 기존 URL 이관 정책 v2 — 전면 301 리다이렉트 (2026-08-04 개정)

> **정책 변경**: 서버 담당(형님) 지시로 "기존 문서 전부 301 리다이렉트"로 확정.
> 신규 사이트는 클린 IA(PLAN.md §3 원안)를 사용하고, 기존 색인 URL은 **하나도 404 없이 전부 301**로 새 주소에 매핑한다.
> 콘텐츠는 새 페이지에 온전히 이식돼 있어야 301의 랭킹 승계가 성립한다 (도착 페이지가 빈 껍데기면 소프트404 취급됨).

## A. 워드프레스 페이지 → 301 매핑

| 기존 URL | 301 대상 | 콘텐츠 이식 |
|---|---|---|
| `/seo/` | `/services/seo` | WP 원문 + 리뉴얼 |
| `/seo-backlinks/` | `/services/seo/backlinks` | 백링크 패키지 (월 50만원~) |
| `/wordpress-agency/` | `/services/wordpress` | |
| `/naver-place-marketing/` | `/services/seo/naver-place` | |
| `/naver-shopping-marketing/` | `/services/seo/naver-shopping` | |
| `/kakao-gift/` | `/services/seo/kakao-gift` | |
| `/coupang/` | `/services/seo/coupang` | |
| `/about-us/` | `/company` | + 연혁(벤처인증·연구소 등) |
| `/contact-us/` | `/contact` | |
| `/blog/` | `/insights` | |
| `/blog/seo/` | `/insights/category/seo` | |
| `/blog/link-building/` | `/insights/category/link-building` | |
| `/seo/{한글슬러그}/` (아티클 3편) | `/insights/{동일 한글슬러그}` | 원문 100% 이식 (백업: database/content/legacy/wp-posts/) |
| `/shop/` | `/solutions/boostingshop` | |
| `/shop/backlinks/seo-캠페인-베이직/` | `/solutions/boostingshop/basic` | 상품 내용 이식 |
| `/shop/backlinks/seo-캠페인-프로/` | `/solutions/boostingshop/pro` | |
| `/shop/backlinks/seo-캠페인-엘리트/` | `/solutions/boostingshop/elite` | |
| `/log-in/` `/join/` `/recover-password/` `/my-account/` | `/login` `/register` `/forgot-password` `/profile` | |
| `/cart/` `/checkout/` | `/solutions/boostingshop` | |
| `/portfolio-items/` + 하위 13개 (Avada 더미) | `/work` | 더미라 이식 없음 |

## B. 구버전(/v1/ 그누보드) → 301 매핑

### B-1. 칼럼 50편 → `/insights/{슬러그}`

- 수집본: `database/content/legacy/columns/*.json` (50편, 원 제목·본문 확보)
- 전량 insights로 시딩 (slug = 제목 기반 한글 슬러그, legacy_wr_id 컬럼으로 원본 추적)
- 301 두 가지 형태 모두:
  - `/v1/manager/bbs/board.php?bo_table=column&wr_id={N}` → wr_id로 매칭 (쿼리스트링 기반 — 전용 처리 필요)
  - `/v1/manager/column/{슬러그}` → 슬러그 정규화 매칭 (현재 서버에서도 404인 죽은 링크지만 과거 색인 대비)
- 카테고리 매핑: 퍼포먼스마케팅/페이스북/인스타그램/구글/브랜딩/콘텐츠마케팅 → insight_categories

### B-2. 랜딩 .php 17개 + /v1/ 페이지

| 기존 | 301 대상 |
|---|---|
| /cpa.php | /services/cpa-marketing |
| /land.php | /services/cpa-marketing/real-estate |
| /stock.php | /services/cpa-marketing/stock |
| /insurance.php | /services/cpa-marketing/insurance |
| /coin.php | /services/cpa-marketing/coin |
| /permission.php | /services/cpa-marketing/permission-call |
| /gfa.php | /services/performance-marketing/naver-gfa |
| /facebook.php | /services/performance-marketing/facebook |
| /youtube.php | /services/performance-marketing/youtube |
| /instagram.php | /solutions/boostingshop/instagram-popular |
| /followers_up.php | /solutions/boostingshop/instagram-followers |
| /instagram_likes.php | /solutions/boostingshop/instagram-likes |
| /shopping_marketing.php, /shopping_smartstore.php | /services/seo/naver-shopping |
| /marketing-support-project.php | /services/marketing-support |
| /v1/company.php | /company |
| /v1/policy.php | /privacy |
| /v1/, /v1/contact.php | / , /contact |
| /v1/portfolio.php, /v1/ad_campaign.php | /work |

- 랜딩 원본: `database/content/legacy/landings/*.html` — 실적 수치(누적 광고비 373억, DB 128만건 등)는 신규 서비스 페이지에 반드시 이식

## C. 신규 IA에 추가되는 페이지 (301 도착지)

- `/services/seo/{backlinks|naver-place|naver-shopping|kakao-gift|coupang}`
- `/services/cpa-marketing/{real-estate|stock|insurance|coin|permission-call}`
- `/services/performance-marketing/{naver-gfa|facebook|youtube}`
- `/services/marketing-support`
- `/solutions/boostingshop/{basic|pro|elite|instagram-popular|instagram-followers|instagram-likes}`
- `/privacy`

## D. 구현 방식

1. `legacy_redirects` 테이블 (from_path 정규화 unique, to_path, status_code=301, hit_count)
2. **404 시점 훅**: NotFoundHttpException 렌더 시 경로 정규화(rawurldecode, trim '/', 소문자) 후 legacy_redirects 조회 → 301. 정상 라우트 오버헤드 0.
3. **쿼리스트링 리다이렉트**: 경로가 `v1/manager/bbs/board.php`이고 `bo_table=column`이면 wr_id로 Insight 조회 → `/insights/{slug}` 301 (전용 분기)
4. 트레일링 슬래시: public/.htaccess의 슬래시 제거 301 룰 삭제 → Laravel 404 훅이 슬래시 포함 원형을 한 번에 최종 목적지로 301 (**홉 1회 보장**)
5. 사이트맵·llms.txt·내부링크는 전부 신규 URL만 노출. lastmod는 이식 원본 날짜 유지.
6. `/wp-content/uploads/**` 이미지: 신규 본문이 참조하는 경우 신규 서버 동일 경로 유지(형님 서버 작업) 또는 이식 시 신규 경로로 교체.

## E. 런칭 전 체크리스트

- [ ] A·B 전 URL curl 전수 테스트: 정확히 1홉 301 + 올바른 도착지 200
- [ ] 칼럼 50편 + WP 아티클 3편 insights 이식 (원문 대비 손실 없음)
- [ ] 랜딩 실적 수치·카피가 도착 페이지에 존재 (소프트404 방지)
- [ ] GSC + 네이버 서치어드바이저 주소변경/색인 모니터링 2주
- [ ] 워드프레스·그누보드 풀백업 (형님 서버 측)
