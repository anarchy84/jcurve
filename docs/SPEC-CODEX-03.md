# Codex 작업지시서 #03 — 전면 301 인프라 + 레거시 콘텐츠 이식

> 근거: docs/URL-MIGRATION.md **v2** (전면 301 정책). 금지사항: SPEC-CODEX-01 §0 동일 (단, bootstrap/app.php 예외 훅 추가와 public/.htaccess 트레일링 슬래시 룰 삭제는 허용·요구됨).
> 참고: #02 지시서는 폐기됨. 현재 트리는 #01 완료 상태 그대로다.

## 1. 신규 라우트/뷰 (301 도착지) — 전부 named route, 시맨틱 HTML 구조만

PageController 확장 (기존 서비스 화이트리스트 패턴 유지):

```
GET /services/seo/{sub}                  # 화이트리스트: backlinks, naver-place, naver-shopping, kakao-gift, coupang
                                         # 기존 /services/seo/aeo, /services/seo/geo 라우트가 먼저 매칭되도록 순서 유지
GET /services/cpa-marketing/{sub}        # real-estate, stock, insurance, coin, permission-call
GET /services/performance-marketing/{sub}# naver-gfa, facebook, youtube
GET /services/marketing-support          # 정부지원사업
GET /solutions/boostingshop/{sub}        # basic, pro, elite, instagram-popular, instagram-followers, instagram-likes
GET /privacy                             # 개인정보처리방침
```

- 뷰 파일: resources/views/services/seo/naver-place.blade.php 식으로 디렉토리 정리
- 각 뷰의 placeholder 카피는 database/content/legacy/landings/*.html의 실제 텍스트에서 핵심 문구를 발췌해 채운다 (예: cpa 계열 → cpa.html의 "누적 광고비 373억" 등 실적 수치, 부스팅샵 인스타 3종 → instagram*.html). HTML 구조는 새로 짜되 **콘텐츠 문구는 원문 발췌**.
- 서비스/솔루션 허브 페이지에 신규 서브페이지 링크 추가 (내부링크)

## 2. legacy_redirects 인프라

1. 마이그레이션 `legacy_redirects`: id, from_path(string unique — 소문자·rawurldecode·양끝 슬래시 제거·쿼리 포함 가능), to_path, status_code(smallint, default 301), hit_count(unsigned default 0), timestamps
2. **404 시점 훅** (bootstrap/app.php `withExceptions` → NotFoundHttpException render):
   - 정규화: `strtolower(trim(rawurldecode($request->path()), '/'))`
   - 1차 lookup: 경로만 / 2차 lookup(1차 실패 시): `경로?bo_table=column&wr_id=N` 형태 — 쿼리에서 bo_table·wr_id만 추출해 정렬 조합
   - 매칭 시 hit_count 증가 + `redirect($to, $status)`, 실패 시 기본 404
   - DB 미가동 시(마이그레이션 전) 예외 삼키고 404 유지 (try-catch)
3. `LegacyRedirectSeeder`: URL-MIGRATION.md v2의 §A 전체 + §B-2 전체를 정확히 시딩 (약 45행). Avada 더미 13개 슬러그 포함.

## 3. 레거시 칼럼·아티클 이식

1. 마이그레이션: insights에 `legacy_wr_id` unsignedSmallInteger nullable unique, `source_url` string nullable
2. `InsightCategorySeeder` 확장: 기존 5개 + facebook, instagram, google-ads, youtube, content-marketing, branding, news (slug/name)
3. `LegacyContentSeeder` (신규):
   - `database/content/legacy/columns/*.json` 50건 → insights insert
     · title, slug(json의 slug 그대로), content(html 그대로), legacy_wr_id(source_url의 wr_id 파싱), source_url
     · category: json의 category 값 매핑(퍼포먼스마케팅→performance-marketing, 페이스북→facebook, 인스타그램→instagram, 구글→google-ads, 콘텐츠→content-marketing, 브랜딩→branding, 없음/기타→news), 제목에 "제이커브"·"론칭"·"인증"·"설립"·"상표" 포함 시 news
     · published_at: date_raw 파싱 가능하면 사용, 아니면 `2019-01-01`부터 wr_id 순 하루 간격 (정렬 안정성용)
   - `database/content/legacy/wp-posts/*.json` 3건 → insights insert (slug 동일 유지, published 필드 파싱, category=seo)
   - slug 중복 시 `-2` 서픽스, 재실행 안전(updateOrCreate by slug)
   - 각 행 생성 후 legacy_redirects에 원 URL 매핑 자동 추가:
     · 칼럼: `v1/manager/bbs/board.php?bo_table=column&wr_id={N}` → `/insights/{slug}` 그리고 `v1/manager/column/{slug}` → `/insights/{slug}`
     · WP 아티클: `seo/{slug}` → `/insights/{slug}`
4. DatabaseSeeder에 등록 (LegacyRedirectSeeder → LegacyContentSeeder 순)

## 4. 트레일링 슬래시

- public/.htaccess의 트레일링 슬래시 제거 301 룰 삭제 → 레거시 URL(`/seo/`)이 Laravel 404 훅까지 도달해 **한 번의 301로 최종 목적지** 도착.

## 5. Feature 테스트 (신규 LegacyRedirectTest)

- `/about-us/` → 301 `/company` (트레일링 슬래시 포함 1홉)
- `/seo-backlinks` → 301 `/services/seo/backlinks`
- `/cpa.php` → 301 `/services/cpa-marketing`
- `/v1/manager/bbs/board.php?bo_table=column&wr_id={시딩된 wr_id}` → 301 `/insights/{slug}`
- `/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략` (rawurlencode 형태 요청 포함) → 301 `/insights/...`
- `/portfolio-items/cras-mollis-nons` → 301 `/work`
- `/없는-페이지` → 404 유지
- `/insights/{이식된 슬러그}` → 200 + 본문 일부 문자열 포함
- 신규 서브페이지 전부 200 (화이트리스트 외 slug 404)

## 6. 완료 기준

- `php artisan migrate:fresh --seed` 그린 (insights 53건 + legacy_redirects 145행 내외 생성 확인 로그)
- `./vendor/bin/pint --test` / `php artisan test` 전부 그린 (기존 25 + 신규)
- route:list에 §1 라우트 존재
- 작업 후 직접 전부 실행해 확인
