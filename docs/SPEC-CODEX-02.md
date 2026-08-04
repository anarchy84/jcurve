# Codex 작업지시서 #02 — 레거시 URL 구조 반영 + 301 인프라

> 참조: docs/URL-MIGRATION.md (근거), docs/SPEC-CODEX-01.md §0 금지사항 동일 적용.
> 목적: 기존 워드프레스 색인 URL을 새 사이트가 그대로 승계한다. 색인 URL 404 = 반려 사유.

## 1. 라우트 개편 (routes/web.php)

**변경 (URI만 바꾸고 컨트롤러 구조 유지, route name은 아래 표대로):**

| 기존 (작업 #01) | 신규 URI | route name |
|---|---|---|
| /services/{slug} 중 seo | `/seo` | services.seo |
| /services/seo/aeo | `/seo/aeo` | services.seo.aeo |
| /services/seo/geo | `/seo/geo` | services.seo.geo |
| /services/{slug} 중 wordpress | `/wordpress-agency` | services.wordpress |
| /company | `/about-us` | about |
| /company/anarchy | `/about-us/anarchy` | about.anarchy |
| /contact (GET/POST) | `/contact-us` | contact / contact.store |
| /insights | `/blog` | blog.index |
| /insights/category/{slug} | (삭제 — 아래 /blog/{slug} 통합) | |
| /insights/{insight:slug} | `/blog/{slug}` | blog.show |

**신규 추가:**

| URI | 처리 |
|---|---|
| `/seo-backlinks` | PageController 서비스 화이트리스트에 추가 (뷰: services/seo-backlinks) |
| `/naver-place-marketing` | 〃 (뷰: services/naver-place-marketing) |
| `/naver-shopping-marketing` | 〃 |
| `/kakao-gift` | 〃 |
| `/coupang` | 〃 |
| `/seo/{slug}` | InsightController@legacyShow — insights에서 slug 조회, 없으면 404. **/seo/aeo, /seo/geo 라우트보다 뒤에 등록** |
| `/shop` | PageController@shop — 부스팅샵 허브 뷰 (solutions/boostingshop 뷰와 별개, 3개 패키지 카드 + /solutions/boostingshop 링크) |
| `/shop/backlinks/{slug}` | PageController@shopProduct — 화이트리스트 3개 슬러그(`seo-캠페인-베이직`, `seo-캠페인-프로`, `seo-캠페인-엘리트`, **rawurldecode 후 비교**), 각각 정적 뷰 (shop/backlinks-basic|pro|elite) |
| `/blog/{slug}` 해석 순서 | ① insight_categories에 slug 존재 → 카테고리 목록 뷰 ② 아니면 insights slug 조회 ③ 404 |

- /services, /services/performance-marketing, /services/cpa-marketing, /services/reward-network, /solutions/*, /work, /community 등 나머지는 그대로.
- 기존 /services/seo, /services/wordpress, /company, /contact, /insights 경로는 라우트에서 제거 (아직 미공개 사이트라 리다이렉트 불필요).

## 2. insights 스키마 보강

- 마이그레이션 추가: insights에 `legacy_prefix` string nullable (기본 null = 신규 글은 /blog/{slug}, 'seo' = /seo/{slug}로 서빙되는 레거시 글)
- Insight 모델에 `getUrlAttribute()`: legacy_prefix 있으면 `/seo/{slug}`, 없으면 `/blog/{slug}` — 뷰의 모든 아티클 링크는 이 accessor 사용
- InsightController@legacyShow: `where('legacy_prefix','seo')->where('slug', $slug)` 조회
- 시더: 레거시 아티클 3편 자리표시 레코드 (slug는 URL-MIGRATION.md의 한글 슬러그 rawurldecode 값, legacy_prefix='seo', title은 원문 제목, content는 "이관 예정" placeholder, published_at은 사이트맵 lastmod)

## 3. legacy_redirects 인프라

1. 마이그레이션: `legacy_redirects` (id, from_path unique — 앞뒤 슬래시 정규화된 소문자 rawurldecode 값, to_path, status_code smallint default 301, hit_count unsigned default 0, timestamps)
2. `App\Http\Middleware\LegacyRedirect` — **글로벌 미들웨어 아님.** `bootstrap/app.php`의 예외 렌더링에서 404 발생 시에만 조회하는 방식이 이상적이나 복잡하면: web 그룹 미들웨어로 등록하되 **라우트 매칭 실패(404) 시에만** DB 조회 (Route::getRoutes()->match 시도 후가 아니라, `$response->status() === 404` 인 terminable 방식 불가 — 다음 방식으로 구현):
   - `bootstrap/app.php` → `->withExceptions()`에서 `NotFoundHttpException` 렌더 훅: request path를 정규화(rawurldecode, trim '/', 소문자)해서 legacy_redirects 조회 → 있으면 `redirect($to, $status)` + hit_count increment, 없으면 기본 404
3. `LegacyRedirectSeeder` — URL-MIGRATION.md B·C 목록 그대로:
   - log-in→/login, join→/register, recover-password→/forgot-password, my-account→/mypage(일단 /profile로), cart→/shop, checkout→/shop
   - portfolio-items 및 하위 13개 슬러그 전부 → /work
4. Feature 테스트: `/log-in/` → 301 /login, `/portfolio-items/cras-mollis-nons/` → 301 /work, `/없는페이지` → 404 유지, `/seo/` 트레일링 슬래시 → 200 (리다이렉트 아님)

## 4. 트레일링 슬래시

- `public/.htaccess`의 트레일링 슬래시 제거 301 룰이 있으면 **삭제** (기존 색인 URL이 슬래시 포함이라 홉을 만들지 않기 위함). Laravel 라우터는 슬래시 유무 모두 매칭하므로 추가 작업 불필요 — 테스트로 `/seo/`와 `/seo` 모두 200 확인.

## 5. 뷰·내부링크 정리

- layouts/app.blade.php 네비·푸터의 route() 호출을 새 route name으로 전부 수정
- 새 서비스 뷰 5개(naver-place/naver-shopping/kakao-gift/coupang/seo-backlinks)는 기존 서비스 뷰와 같은 구조(h1 1개 + 시맨틱 섹션 + placeholder 카피)
- shop 허브 + 백링크 패키지 3개 뷰 (패키지명/설명 placeholder, CONTENT.md의 "월 50만원부터" 카피 활용 가능)

## 6. 완료 기준 (#01 §7과 동일 + 추가)

- `php artisan migrate:fresh --seed` / `pint --test` / `php artisan test` 그린
- 3번의 Feature 테스트 신규 작성 + 통과
- route:list에 §1 표의 URI 전부 존재, 구 URI(/company 등) 부재
- 수동 확인: `/seo/`, `/seo/aeo`, `/wordpress-agency/`, `/about-us/`, `/blog/`, `/blog/seo/`, `/shop/backlinks/seo-캠페인-베이직/`(인코딩 요청 포함) 전부 200
