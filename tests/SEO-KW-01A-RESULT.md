# SEO-KW-01A 구현 반환물

- 기준/현재 커밋: `70ccde4` (`main`). git 쓰기 명령 미실행.
- 담당: Codex = 백엔드 구현·회귀 테스트·실행 증거, Claude = 동시 진행 중인 화면·정적 라우트 및 최종 검수.
- 결과: 전체 테스트 **203/203**, 변경 PHP 7개 Pint 통과, Vite 빌드 성공.
- 검사 시점의 작업 트리에는 Claude 동시 작업으로 금지 구역 diff가 존재한다. 아래에 Codex 변경과 구분했다. 전체 작업 트리의 금지 파일 diff가 0이라고 판정하지 않는다.

## 1. 바꾼 파일 목록

| 파일 | 변경 |
|---|---|
| `routes/web.php` | 원본 미디어 301 및 GET/HEAD `/llms.txt` 라우트 |
| `app/Http/Controllers/LegacyMediaRedirectController.php` (신규) | 디코딩 전 경로·원본 QUERY_STRING을 보존해 `/v1`으로 301 |
| `app/Http/Controllers/SeoFeedController.php` | 빈 사이트맵 묶음의 인덱스 노출 제외, addImage 연결, llms 뷰 응답 및 RSS와 같은 캐시 헤더 |
| `app/Services/Seo/Publishing/FeedCatalog.php` | 공개 인사이트 cover_image 전달, 외부·로컬·프로토콜 상대 이미지 주소 절대화 |
| `config/seo.php` | 실제 쇼핑 라우트 확인 후 `/self-marketing/shopping` 추가 |
| `public/robots.txt` | 지정된 11개 검색·AI 크롤러 허용 및 llms 안내 |
| `tests/Feature/SeoKeywordFoundationTest.php` (신규) | A1~A4·쇼핑 라우트 회귀 테스트 20개 |
| `tests/Feature/SeoMetaRestorationTest.php` | 기존 robots 3줄 전체 일치 검사를 전체 허용·차단 없음·Sitemap 보존 검사로 변경 |
| `tests/SEO-KW-01A-RESULT.md` (신규) | 이 반환 보고서 |

공개 글이 있는 모든 카테고리를 조회하는 기존 `whereHas(...published())` 조건은 이미 요구를 충족하므로 유지했다. 9개 카테고리 전체, SEO·link-building 원주소 매핑, 중복 없는 노출, 비공개·noindex·외부 canonical 제외를 새 테스트로 확인했다. 기존 원주소 두 카테고리를 유지하는 동작도 보존했다.

빈 `works`·`insights` 묶음은 인덱스에 없지만 각 `1.xml`은 200이며 `2.xml`은 404다. cover_image는 sitemap의 이미지 네임스페이스로 출력하며 요청 Host 대신 설정된 공개 도메인을 기준으로 절대화한다.

`routes/pages.php`의 `self-marketing.shopping` 등록과 실제 화면 200을 테스트로 확인했다. 해당 파일과 뷰는 저장하지 않았다.

## 2. git diff --stat 실제 출력

공유 작업 폴더 전체 출력이다. 뷰·`routes/pages.php`는 Claude의 동시 작업이며 Codex 수정 목록이 아니다. 기본 git diff는 아래 신규 미추적 파일을 포함하지 않는다.

명령: `git diff --stat`

```text
 app/Http/Controllers/SeoFeedController.php         | 18 +++++--
 app/Services/Seo/Publishing/FeedCatalog.php        | 15 +++++-
 config/seo.php                                     |  1 +
 public/robots.txt                                  | 16 ++++++
 resources/views/insights/show.blade.php            | 43 +++++++++++++++
 resources/views/layouts/guest.blade.php            |  8 ++-
 .../views/pages/self-marketing-place.blade.php     | 21 ++++++--
 resources/views/pages/subpage.blade.php            | 33 ++++++++++++
 resources/views/partials/jc/head.blade.php         | 61 +++++++++++++++++++++-
 resources/views/services/reward-network.blade.php  | 40 ++++++++++++--
 resources/views/solutions/rankfree.blade.php       | 12 +++--
 routes/pages.php                                   |  2 +
 routes/web.php                                     |  6 +++
 tests/Feature/SeoMetaRestorationTest.php           |  5 +-
 14 files changed, 260 insertions(+), 21 deletions(-)
```

Codex가 수정한 추적 파일만 지정한 출력:

```sh
git diff --stat -- routes/web.php app/Http/Controllers/SeoFeedController.php app/Services/Seo/Publishing/FeedCatalog.php config/seo.php public/robots.txt tests/Feature/SeoMetaRestorationTest.php
```

```text
 app/Http/Controllers/SeoFeedController.php  | 18 +++++++++++++-----
 app/Services/Seo/Publishing/FeedCatalog.php | 15 ++++++++++++++-
 config/seo.php                              |  1 +
 public/robots.txt                           | 16 ++++++++++++++++
 routes/web.php                              |  6 ++++++
 tests/Feature/SeoMetaRestorationTest.php    |  5 ++++-
 6 files changed, 54 insertions(+), 7 deletions(-)
```

신규 PHP 파일은 인덱스를 변경하지 않는 읽기 전용 비교로 별도 확인했다.

```sh
git diff --no-index --stat -- /dev/null app/Http/Controllers/LegacyMediaRedirectController.php
```

```text
 .../Http/Controllers/LegacyMediaRedirectController.php  | 17 +++++++++++++++++
 1 file changed, 17 insertions(+)
```

```sh
git diff --no-index --stat -- /dev/null tests/Feature/SeoKeywordFoundationTest.php
```

```text
 .../Feature/SeoKeywordFoundationTest.php           | 213 +++++++++++++++++++++
 1 file changed, 213 insertions(+)
```

두 no-index 비교의 종료 코드 1은 차이가 있다는 의미다. 보고서 자체도 미추적 파일이라 위 통계에는 포함되지 않는다.

## 3. 실행 명령과 실제 출력

### 신규 테스트 스모크

```sh
mkdir -p /private/tmp/jcurve-seo-kw-01a/views
env VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01a/views LOG_CHANNEL=stderr php artisan test --filter=SeoKeywordFoundationTest --do-not-cache-result
```

```json
{"tool":"phpunit","result":"passed","tests":20,"passed":20,"assertions":125,"duration_ms":251}
```

종료 코드 0. 최초 스모크에서는 성과 테스트 데이터의 필수 content 누락 1건과, 동시 등록된 쇼핑 라우트가 아직 사이트맵 설정에 없는 실패 1건을 확인하고 수정했다. 이후 쇼핑 테스트는 라우트 존재를 필수로 확인하도록 강화했으며, 최종 검증은 아래 전체 실행 결과다.

### 전체 테스트

```sh
env VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01a/views LOG_CHANNEL=stderr php artisan test --do-not-cache-result
```

```text
[2026-11-04 07:05:53] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"}
[2026-11-04 07:05:53] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"}
{"tool":"phpunit","result":"passed","tests":203,"passed":203,"assertions":21560,"duration_ms":6229}
```

종료 코드 0. 기존 183개 + 신규 20개가 모두 실행됐다. 첫 전체 실행은 202/203으로, 기존 robots 테스트의 3줄 고정 기대값이 이번 크롤러 허용 추가와 충돌했다. 테스트가 원래 보호하던 전체 허용·Sitemap 보존 조건을 유지하면서 새 요구를 허용하도록 바꾼 뒤 위 결과를 얻었다. 테스트 삭제·skip 처리는 없다.

VIEW_COMPILED_PATH는 컴파일된 뷰를 임시 경로에 두고, --do-not-cache-result는 저장소 안 PHPUnit 결과 캐시 쓰기를 피한다. 원본 Blade 파일을 저장하는 동작이 아니다.

### 변경 PHP 파일 Pint

```sh
./vendor/bin/pint --test routes/web.php app/Http/Controllers/LegacyMediaRedirectController.php app/Http/Controllers/SeoFeedController.php app/Services/Seo/Publishing/FeedCatalog.php config/seo.php tests/Feature/SeoKeywordFoundationTest.php tests/Feature/SeoMetaRestorationTest.php
```

```json
{"tool":"pint","result":"passed"}
```

종료 코드 0.

### 프론트 빌드

```sh
npm run build -- --outDir /private/tmp/jcurve-seo-kw-01a/build
```

실제 출력에서 터미널 제어 문자만 제거했다.

```text
> build
> vite build --outDir /private/tmp/jcurve-seo-kw-01a/build

vite v8.2.0 building client environment for production...
transforming...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
✓ 12 modules transformed.

(!) outDir /private/tmp/jcurve-seo-kw-01a/build is not inside project root and will not be emptied.
Use --emptyOutDir to override.

rendering chunks...
computing gzip size...
../../../../private/tmp/jcurve-seo-kw-01a/build/manifest.json                        0.88 kB │ gzip:  0.25 kB
../../../../private/tmp/jcurve-seo-kw-01a/build/assets/legacy-reskin-3fymEzpK.css   13.71 kB │ gzip:  2.99 kB
../../../../private/tmp/jcurve-seo-kw-01a/build/assets/jc-Bqs11fyj.css              90.23 kB │ gzip: 17.45 kB
../../../../private/tmp/jcurve-seo-kw-01a/build/assets/app-BW-Dp7Pe.css             97.52 kB │ gzip: 18.40 kB
../../../../private/tmp/jcurve-seo-kw-01a/build/assets/jc-DIWfGL1E.js               25.80 kB │ gzip:  9.23 kB
../../../../private/tmp/jcurve-seo-kw-01a/build/assets/app-XOhwnyVw.js             159.36 kB │ gzip: 60.50 kB

✓ built in 545ms
```

종료 코드 0. 소유 범위 밖인 `public/build`를 덮어쓰지 않도록 출력 경로만 /private/tmp로 지정했다.

### 공백 검사

명령: `git diff --check`

실제 출력: 없음. 종료 코드 0.

### 금지 구역 확인

```sh
git diff --name-only -- resources/views config/subpages.php routes/pages.php public/media database/content
```

실제 출력:

```text
resources/views/insights/show.blade.php
resources/views/layouts/guest.blade.php
resources/views/pages/self-marketing-place.blade.php
resources/views/pages/subpage.blade.php
resources/views/partials/jc/head.blade.php
resources/views/services/reward-network.blade.php
resources/views/solutions/rankfree.blade.php
routes/pages.php
```

위 8개는 작업 중인 Claude 구역의 동시 변경이다. 수정 도구는 소유 범위 안의 위 9개 파일에만 사용했다. 금지 구역 변경을 되돌리거나 저장하지 않았다. 시작 때 소유 범위 밖 436개 파일의 SHA-256을 보관해 대조했으며, 변한 파일은 위 8개뿐이었다. Claude가 미리 만든 `resources/views/seo/llms.blade.php`는 해시도 동일하다. `config/subpages.php`, `public/media/**`, `database/content/**` 등 나머지 감시 대상도 동일했다. `.env`는 열람·수정하지 않았다.

명령: `git rev-parse --short HEAD`

실제 출력: `70ccde4`. 종료 코드 0.

## 4. 미검증 항목·반환 경계

- 운영 배포·발행·실제 크롤러 수집·검색 순위 변화는 확인하지 않았다. 이번 실행은 로컬 구현 검사다.
- 운영 DB의 카테고리 연결·게시 상태와 본문 이미지 84개 실제 파일은 재조회하지 않았다. 공개 카테고리와 이미지 태그 동작은 독립된 SQLite 메모리 DB로 검증했다.
- 빌드 경고의 `/media/bg/hero-glow.webp` 런타임 제공 여부는 미확인이다. 금지된 미디어 파일은 수정하지 않았다.
- 공유 작업 트리에 Claude 변경이 계속 존재하므로, 저장소 전체의 금지 파일 diff 0 게이트는 충족했다고 보고하지 않는다. Codex의 금지 파일 저장은 0건이다.
- 별도 Codex 검증 세션의 공격·무력화 실험 및 Claude 최종 합격 판정은 이번 구현 반환에 포함되지 않는다.
- 소유 파일 제한에 따라 대시보드 tasks.json·요청 큐를 갱신하거나 대시보드 생성기를 실행하지 않았다.
- git commit/push/stash/reset/checkout/브랜치 변경 및 배포 명령은 실행하지 않았다.
