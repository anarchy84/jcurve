# URL-PRESERVE-01 구현 세션 반환물

작성일: 2026-11-03. Claude 지시서의 계약을 Codex가 구현하고 지정된 게이트를 실행한 기록이야. 최종 제품 검수·합격 판정은 별도 Claude 검수에서 진행하면 돼.

## 결과

- 원주소 15개는 200, 끝 슬래시 없는 주소와 새 경로는 쿼리를 보존한 1홉 301. canonical·og:url·내부 URL 생성·페이지네이션·사이트맵·RSS를 원주소로 맞췄어.
- 문의의 기존 POST도 유지하고 원주소 POST에 같은 web/CSRF·Spatie honeypot·throttle:5,1을 연결했어.
- 루트 PHP 랜딩의 v1 주소를 추가하고, 회사·문의·쇼핑 리다이렉트 체인을 정리했어.
- 없는 칼럼 30개는 410 + noindex + 목록/홈 링크. 파라미터 순서·키/값 대소문자를 정규화해.
- 아나키 강의 글은 설정으로 숨기고 상세 302 → /blog/, wr_id=51은 직접 301 → /blog/. 두 스마트스토어 글은 모델의 표시값에서 해당 도입 문장만 빼고 DB 원문·보존 JSON은 유지해.
- 기존 98개 + 신규 28개 = 126개 테스트 통과. 실제 HTTP 93개, 기본 URL 감사 66개 통과.
- 추가 마이그레이션·의존성은 없어. WorkSeeder·미디어·CSS·JS·보존 원문은 변경하지 않았어.

## 커밋 상태에서 반드시 알아둘 점

내가 실행한 명령에는 commit·push·배포·reset·checkout·stash가 없어. 다만 세션 진행 중 아래 자동 checkpoint가 생겼어. 누가 실행했는지는 이 세션에서 확인하지 못했어. 이를 취소하거나 수정하지 않았고, 최초 기준 3cbe3d8 대비 전체 변경과 현재 미커밋 diff를 함께 남겨.

```text
9f1783e 2026-11-03T11:06:33+09:00 🤖 checkpoint: 2026-11-03 11:06:33
3cbe3d8 2026-10-27T18:16:10+09:00 docs(queue): Q-026·Q-029 기록 시각 정정
```

지시서와 Google 소유 확인 태그는 세션 시작부터 있던 변경이야. 지시서는 수정하지 않았고, head는 허용된 $jcPath/$jcCanonical 두 줄만 수정했어. 아래 기준 커밋 대비 통계의 head 변경에는 기존 Google 태그 4줄도 포함돼.

## 변경 파일

아래 23개는 기준 커밋 3cbe3d8 대비 구현/테스트 파일이야. 이 반환물 파일(tests/URL-PRESERVE-01-RESULT.md)은 별도 신규 문서야.

```text
app/Http/Controllers/InsightController.php
app/Http/Middleware/PreservePublicUrls.php
app/Models/Insight.php
app/Models/LegacyRedirect.php
app/Providers/AppServiceProvider.php
app/Services/Seo/Publishing/FeedCatalog.php
app/Services/Seo/Publishing/PreservedPaths.php
app/Services/Seo/Publishing/PreservedUrlGenerator.php
app/Services/Seo/Publishing/PublicUrl.php
app/Services/Seo/Publishing/UrlAuditManifest.php
bootstrap/app.php
config/seo.php
database/seeders/LegacyContentSeeder.php
database/seeders/LegacyRedirectSeeder.php
resources/views/errors/410.blade.php
resources/views/partials/jc/head.blade.php
routes/web.php
tests/Feature/LegacyRedirectTest.php
tests/Feature/MarketingContentTest.php
tests/Feature/SeoFeedTest.php
tests/Feature/SeoUrlAuditTest.php
tests/Feature/UrlPreservationTest.php
tests/TestCase.php
```

- PreservedPaths: 매핑·쿼리/fragment 유지·한글 URI 헤더 인코딩.
- PreservedUrlGenerator + AppServiceProvider: Laravel의 마지막 슬래시 제거 뒤에 정식 주소를 복원. 기존 session/key/route extenders와 request rebinding은 그대로 사용.
- PreservePublicUrls + routes: 원주소 화면/폼 별칭과 GET·HEAD 정규화. /seo/{slug}는 지정된 세 글만 별칭으로 허용.
- Insight + InsightController: 가역 숨김, 두 문장만 표시 제외, 정식 페이지네이션 경로.
- FeedCatalog/PublicUrl/UrlAuditManifest: URL·메타 경로 통일, 빈 링크 빌딩 카테고리도 보존, 원주소 16개와 이미 승인된 칼럼 301 50개를 감사.
- 시더: updateOrCreate, 오래된 원주소 리다이렉트 행 정리, 같은 시더 인스턴스 반복 실행 시 슬러그도 멱등.
- 404 훅: 410 행은 화면 응답, 301은 정식 주소로 직접 연결. 한글 Location을 ASCII URI로 인코딩해 PHP HTTP 전송에서 마지막 바이트가 손실되는 현상도 방지.

## git diff --stat

현재 HEAD 대비 실제 출력(반환물 작성 직전):

```text
 app/Http/Middleware/PreservePublicUrls.php     | 2 +-
 app/Services/Seo/Publishing/PreservedPaths.php | 6 ++++++
 bootstrap/app.php                              | 2 +-
 tests/Feature/UrlPreservationTest.php          | 5 +++--
 4 files changed, 11 insertions(+), 4 deletions(-)
```

전체 구현을 검토할 기준 커밋 대비 명령:

```sh
git diff 3cbe3d8 --stat -- app bootstrap/app.php config/seo.php database/seeders/LegacyContentSeeder.php database/seeders/LegacyRedirectSeeder.php routes resources/views/partials/jc/head.blade.php resources/views/errors/410.blade.php tests
```

```text
 app/Http/Controllers/InsightController.php         |  13 +-
 app/Http/Middleware/PreservePublicUrls.php         |  28 ++
 app/Models/Insight.php                             |  31 +-
 app/Models/LegacyRedirect.php                      |  11 +-
 app/Providers/AppServiceProvider.php               |  13 +
 app/Services/Seo/Publishing/FeedCatalog.php        |   5 +-
 app/Services/Seo/Publishing/PreservedPaths.php     |  32 +++
 .../Seo/Publishing/PreservedUrlGenerator.php       |  19 ++
 app/Services/Seo/Publishing/PublicUrl.php          |   2 +-
 app/Services/Seo/Publishing/UrlAuditManifest.php   |  11 +-
 bootstrap/app.php                                  |  10 +-
 config/seo.php                                     |  28 +-
 database/seeders/LegacyContentSeeder.php           |  17 +-
 database/seeders/LegacyRedirectSeeder.php          |  29 +-
 resources/views/errors/410.blade.php               |  13 +
 resources/views/partials/jc/head.blade.php         |   8 +-
 routes/web.php                                     |  28 +-
 tests/Feature/LegacyRedirectTest.php               |   9 +-
 tests/Feature/MarketingContentTest.php             |  29 +-
 tests/Feature/SeoFeedTest.php                      |   2 +-
 tests/Feature/SeoUrlAuditTest.php                  |  12 +-
 tests/Feature/UrlPreservationTest.php              | 317 +++++++++++++++++++++
 tests/TestCase.php                                 |  11 +-
 23 files changed, 622 insertions(+), 56 deletions(-)
```

## 핵심 diff

전체 패치: [implementation.diff](/private/tmp/jcurve-url-preserve-01.gsVPHC/evidence/implementation.diff)

```diff
+ $middleware->prepend(PreservePublicUrls::class);

+ if ($redirect->status_code === 410) {
+     return response()->view('errors.410', [], 410)->header('X-Robots-Tag', 'noindex');
+ }
+ return redirect(PreservedPaths::encode(PreservedPaths::path($redirect->to_path)), $redirect->status_code);
```

```diff
- $jcPath = '/'.ltrim(request()->path(), '/');
- $jcCanonical = trim($__env->yieldContent('canonical')) ?: $jcPublicUrl.($jcPath === '/' ? '/' : $jcPath);
+ $jcPath = \App\Services\Seo\Publishing\PreservedPaths::path('/'.ltrim(request()->path(), '/'));
+ $jcCanonical = \App\Services\Seo\Publishing\PreservedPaths::destination($jcPath) !== null ? $jcPublicUrl.$jcPath : (trim($__env->yieldContent('canonical')) ?: $jcPublicUrl.$jcPath);
```

```diff
- ->where('published_at', '<=', now());
+ ->where('published_at', '<=', now())
+ ->whereNotIn('slug', config('seo.hidden_insights', []));

+ if ($insight->isHidden()) {
+     return redirect()->route('insights.index', [], 302);
+ }
```

## 실행 환경

검증 복사본: /private/tmp/jcurve-url-preserve-01.gsVPHC/appcopy

실제 .env, 기존 DB, .git, storage를 제외하고 복사했어. 임시 SQLite와 별도 storage를 사용했고, 테스트·빌드 산출물도 복사본에서 만들었어. vendor/node_modules는 기존 설치를 읽어 쓰고 의존성 설치는 안 했어. 미디어 링크는 읽기만 했어.

HTTP 검증용 환경 파일: [verification-env.sh](/private/tmp/jcurve-url-preserve-01.gsVPHC/verification-env.sh). APP_KEY는 이 임시 검증에만 쓴 공개된 테스트 값이야. HTTP에서는 SEO_PUBLIC_URL=http://127.0.0.1:8011로 두었고, 기능 테스트에서는 https://j-curve.co.kr 기준 canonical도 별도로 검사했어.

## 실행 명령과 실제 출력

### 1. 전체 기능 테스트

작업 디렉터리: 검증 복사본. .env 없이 환경 변수를 명시했어.

```sh
APP_BASE_PATH=/private/tmp/jcurve-url-preserve-01.gsVPHC/appcopy APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= DB_CONNECTION=sqlite DB_DATABASE=:memory: CACHE_STORE=array SESSION_DRIVER=array MAIL_MAILER=array QUEUE_CONNECTION=sync php artisan test
```

```json
{"tool":"phpunit","result":"passed","tests":126,"passed":126,"assertions":19540,"duration_ms":6262}
```

신규 테스트가 확인하는 항목: 원주소 15개 각각 200/canonical/og:url/기존 main 내용·title·description 동등성/슬래시 없는 주소 301/새 경로 301/쿼리 보존/도착지 200/HEAD, 퍼센트 인코딩 대소문자, 생성 URL과 상대 경로·fragment, canonical section 덮어쓰기 방어, 6개 화면의 href/action·JSON-LD, 문의 성공/실패/honeypot/429, sitemap/RSS/페이지네이션, 6개 체인·B 주소·모든 v1 랜딩, 30개 410(키 대소문자·순서 변형 포함), 살아 있는 칼럼 50개와 더미·shop 유지, 가역 숨김·원문 보존, 시더 반복 실행, 비대상 경로·404 훅 유지.

### 2. Pint — 변경 PHP 21개

```sh
./vendor/bin/pint --test app/Http/Controllers/InsightController.php app/Http/Middleware/PreservePublicUrls.php app/Models/Insight.php app/Models/LegacyRedirect.php app/Providers/AppServiceProvider.php app/Services/Seo/Publishing/PreservedPaths.php app/Services/Seo/Publishing/PreservedUrlGenerator.php app/Services/Seo/Publishing/FeedCatalog.php app/Services/Seo/Publishing/PublicUrl.php app/Services/Seo/Publishing/UrlAuditManifest.php bootstrap/app.php config/seo.php database/seeders/LegacyContentSeeder.php database/seeders/LegacyRedirectSeeder.php routes/web.php tests/Feature/LegacyRedirectTest.php tests/Feature/MarketingContentTest.php tests/Feature/SeoFeedTest.php tests/Feature/SeoUrlAuditTest.php tests/Feature/UrlPreservationTest.php tests/TestCase.php
```

```json
{"tool":"pint","result":"passed"}
```

head와 신규 410 Blade는 PHP Pint 대상에서 제외하고 렌더 테스트·빌드로 확인했어. git diff --check도 exit 0이었어.

### 3. 빌드

작업 디렉터리: 검증 복사본. 출력에서 ANSI 화면 제어문자만 제거했어.

```sh
npm run build
```

```text

> build
> vite build

vite v8.2.0 building client environment for production...

transforming...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
✓ 12 modules transformed.
rendering chunks...
computing gzip size...
public/build/manifest.json                        0.88 kB │ gzip:  0.26 kB
public/build/assets/legacy-reskin-3fymEzpK.css   13.71 kB │ gzip:  2.99 kB
public/build/assets/jc-wWAxyZCv.css              89.85 kB │ gzip: 17.36 kB
public/build/assets/app-BW-Dp7Pe.css             97.52 kB │ gzip: 18.40 kB
public/build/assets/jc-DIWfGL1E.js               25.80 kB │ gzip:  9.23 kB
public/build/assets/app-XOhwnyVw.js             159.36 kB │ gzip: 60.50 kB

✓ built in 1.03s
```

빌드는 exit 0. hero-glow.webp 해석 경고는 남아 있어. 금지된 미디어를 수정하거나 덮어쓰지 않았어.

### 4. 임시 SQLite 마이그레이션과 운영 시더

migrate:fresh는 사용하지 않았어.

```sh
source /private/tmp/jcurve-url-preserve-01.gsVPHC/verification-env.sh
php artisan migrate --force
```

```text

 INFO Preparing database. 

 Creating migration table .. 2.53ms DONE

 INFO Running migrations. 

 0001_01_01_000000_create_users_table .. 2.40ms DONE
 0001_01_01_000001_create_cache_table .. 1.47ms DONE
 0001_01_01_000002_create_jobs_table .. 3.88ms DONE
 2026_08_04_000001_create_boards_table .. 1.47ms DONE
 2026_08_04_000002_create_posts_table .. 8.25ms DONE
 2026_08_04_000003_create_comments_table .. 1.04ms DONE
 2026_08_04_000004_create_post_likes_table .. 1.23ms DONE
 2026_08_04_000005_create_attachments_table .. 0.70ms DONE
 2026_08_04_000006_create_insight_categories_table .. 0.37ms DONE
 2026_08_04_000007_create_insights_table .. 1.17ms DONE
 2026_08_04_000008_create_works_table .. 2.08ms DONE
 2026_08_04_000009_create_leads_table .. 1.02ms DONE
 2026_08_04_000010_create_seo_meta_table .. 1.89ms DONE
 2026_08_04_000011_add_community_columns_to_users_table .. 2.99ms DONE
 2026_08_04_000012_create_legacy_redirects_table .. 0.64ms DONE
 2026_08_04_000013_add_legacy_columns_to_insights_table .. 1.20ms DONE
 2026_10_27_000001_create_rankfree_connections_table .. 1.30ms DONE
```

```sh
php artisan db:seed --class=DatabaseSeeder --force
```

```text

 INFO Seeding database. 

 Database\Seeders\BoardSeeder .. RUNNING 
 Database\Seeders\BoardSeeder .. 21 ms DONE 

 Database\Seeders\InsightCategorySeeder .. RUNNING 
 Database\Seeders\InsightCategorySeeder .. 10 ms DONE 

 Database\Seeders\LegacyRedirectSeeder .. RUNNING 
 Database\Seeders\LegacyRedirectSeeder .. 52 ms DONE 

 Database\Seeders\LegacyContentSeeder .. RUNNING 
 Database\Seeders\LegacyContentSeeder .. 506 ms DONE
```

현재 DatabaseSeeder가 호출하는 BoardSeeder·InsightCategorySeeder·LegacyRedirectSeeder·LegacyContentSeeder만 실행됐고 WorkSeeder는 실행되지 않았어.

### 5. 포트 8011 실제 HTTP

```sh
php artisan serve --host=127.0.0.1 --port=8011 --no-reload
```

```text
 INFO Server running on [http://127.0.0.1:8011].

 Press Ctrl+C to stop the server
```

아래 [http-smoke.py](/private/tmp/jcurve-url-preserve-01.gsVPHC/http-smoke.py)는 실제 curl -sI 출력에서 상태·Location·X-Robots-Tag를 그대로 기록하고, GET으로 canonical과 410의 robots를 확인해. 리다이렉트는 같은 로컬 서버에서 목적지가 바로 200인지 별도로 확인했어.

```sh
python3 /private/tmp/jcurve-url-preserve-01.gsVPHC/http-smoke.py
```

```text
curl -sI http://127.0.0.1:8011/about-us/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/about-us/">
curl -sI http://127.0.0.1:8011/about-us?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/about-us/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/company?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/about-us/?page=2
curl -sI http://127.0.0.1:8011/contact-us/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/contact-us/">
curl -sI http://127.0.0.1:8011/contact-us?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/contact-us/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/contact?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/contact-us/?page=2
curl -sI http://127.0.0.1:8011/blog/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/blog/">
curl -sI http://127.0.0.1:8011/blog?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/blog/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/insights?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/blog/?page=2
curl -sI http://127.0.0.1:8011/blog/seo/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/blog/seo/">
curl -sI http://127.0.0.1:8011/blog/seo?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/blog/seo/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/insights/category/seo?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/blog/seo/?page=2
curl -sI http://127.0.0.1:8011/blog/link-building/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/blog/link-building/">
curl -sI http://127.0.0.1:8011/blog/link-building?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/blog/link-building/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/insights/category/link-building?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/blog/link-building/?page=2
curl -sI http://127.0.0.1:8011/seo/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/seo/">
curl -sI http://127.0.0.1:8011/seo?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/seo/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/services/seo?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/seo/?page=2
curl -sI http://127.0.0.1:8011/seo-backlinks/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/seo-backlinks/">
curl -sI http://127.0.0.1:8011/seo-backlinks?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/seo-backlinks/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/services/seo/backlinks?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/seo-backlinks/?page=2
curl -sI http://127.0.0.1:8011/wordpress-agency/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/wordpress-agency/">
curl -sI http://127.0.0.1:8011/wordpress-agency?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/wordpress-agency/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/services/wordpress?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/wordpress-agency/?page=2
curl -sI http://127.0.0.1:8011/naver-place-marketing/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/naver-place-marketing/">
curl -sI http://127.0.0.1:8011/naver-place-marketing?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/naver-place-marketing/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/services/seo/naver-place?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/naver-place-marketing/?page=2
curl -sI http://127.0.0.1:8011/naver-shopping-marketing/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/naver-shopping-marketing/">
curl -sI http://127.0.0.1:8011/naver-shopping-marketing?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/naver-shopping-marketing/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/services/seo/naver-shopping?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/naver-shopping-marketing/?page=2
curl -sI http://127.0.0.1:8011/kakao-gift/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/kakao-gift/">
curl -sI http://127.0.0.1:8011/kakao-gift?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/kakao-gift/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/services/seo/kakao-gift?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/kakao-gift/?page=2
curl -sI http://127.0.0.1:8011/coupang/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/coupang/">
curl -sI http://127.0.0.1:8011/coupang?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/coupang/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/services/seo/coupang?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/coupang/?page=2
curl -sI http://127.0.0.1:8011/seo/chrome-%EB%B0%8F-firefox%EC%97%90%EC%84%9C-nofollow-%EB%A7%81%ED%81%AC%EB%A5%BC-%ED%99%95%EC%9D%B8%ED%95%98%EB%8A%94-%EB%B0%A9%EB%B2%95/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/">
curl -sI http://127.0.0.1:8011/seo/chrome-%EB%B0%8F-firefox%EC%97%90%EC%84%9C-nofollow-%EB%A7%81%ED%81%AC%EB%A5%BC-%ED%99%95%EC%9D%B8%ED%95%98%EB%8A%94-%EB%B0%A9%EB%B2%95?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/insights/chrome-%EB%B0%8F-firefox%EC%97%90%EC%84%9C-nofollow-%EB%A7%81%ED%81%AC%EB%A5%BC-%ED%99%95%EC%9D%B8%ED%95%98%EB%8A%94-%EB%B0%A9%EB%B2%95?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/?page=2
curl -sI http://127.0.0.1:8011/seo/11%EA%B0%80%EC%A7%80-%EC%B5%9C%EA%B3%A0%EC%9D%98-seo-%EC%8B%A4%EC%88%98%EC%99%80-%EC%9D%B4%EB%A5%BC-%ED%94%BC%ED%95%98%EB%8A%94-%EB%B0%A9%EB%B2%95/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/seo/11가지-최고의-seo-실수와-이를-피하는-방법/">
curl -sI http://127.0.0.1:8011/seo/11%EA%B0%80%EC%A7%80-%EC%B5%9C%EA%B3%A0%EC%9D%98-seo-%EC%8B%A4%EC%88%98%EC%99%80-%EC%9D%B4%EB%A5%BC-%ED%94%BC%ED%95%98%EB%8A%94-%EB%B0%A9%EB%B2%95?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/seo/11가지-최고의-seo-실수와-이를-피하는-방법/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/insights/11%EA%B0%80%EC%A7%80-%EC%B5%9C%EA%B3%A0%EC%9D%98-seo-%EC%8B%A4%EC%88%98%EC%99%80-%EC%9D%B4%EB%A5%BC-%ED%94%BC%ED%95%98%EB%8A%94-%EB%B0%A9%EB%B2%95?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/seo/11가지-최고의-seo-실수와-이를-피하는-방법/?page=2
curl -sI http://127.0.0.1:8011/seo/%EA%B2%BD%EC%9F%81%EC%9E%90%EB%A5%BC-%EC%95%95%EB%8F%84%ED%95%98%EB%8A%94-6%EA%B0%80%EC%A7%80-%EA%B3%A0%EA%B8%89-%EB%A7%81%ED%81%AC-%EA%B5%AC%EC%B6%95-%EC%A0%84%EB%9E%B5/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/">
curl -sI http://127.0.0.1:8011/seo/%EA%B2%BD%EC%9F%81%EC%9E%90%EB%A5%BC-%EC%95%95%EB%8F%84%ED%95%98%EB%8A%94-6%EA%B0%80%EC%A7%80-%EA%B3%A0%EA%B8%89-%EB%A7%81%ED%81%AC-%EA%B5%AC%EC%B6%95-%EC%A0%84%EB%9E%B5?page=2&utm_source=a%2Fb
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/?page=2&utm_source=a%2Fb
curl -sI http://127.0.0.1:8011/insights/%EA%B2%BD%EC%9F%81%EC%9E%90%EB%A5%BC-%EC%95%95%EB%8F%84%ED%95%98%EB%8A%94-6%EA%B0%80%EC%A7%80-%EA%B3%A0%EA%B8%89-%EB%A7%81%ED%81%AC-%EA%B5%AC%EC%B6%95-%EC%A0%84%EB%9E%B5?page=2
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/?page=2
curl -sI http://127.0.0.1:8011/seo/chrome-%eb%b0%8f-firefox%ec%97%90%ec%84%9c-nofollow-%eb%a7%81%ed%81%ac%eb%a5%bc-%ed%99%95%ec%9d%b8%ed%95%98%eb%8a%94-%eb%b0%a9%eb%b2%95/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/">
curl -sI http://127.0.0.1:8011/seo/11%ea%b0%80%ec%a7%80-%ec%b5%9c%ea%b3%a0%ec%9d%98-seo-%ec%8b%a4%ec%88%98%ec%99%80-%ec%9d%b4%eb%a5%bc-%ed%94%bc%ed%95%98%eb%8a%94-%eb%b0%a9%eb%b2%95/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/seo/11가지-최고의-seo-실수와-이를-피하는-방법/">
curl -sI http://127.0.0.1:8011/seo/%ea%b2%bd%ec%9f%81%ec%9e%90%eb%a5%bc-%ec%95%95%eb%8f%84%ed%95%98%eb%8a%94-6%ea%b0%80%ec%a7%80-%ea%b3%a0%ea%b8%89-%eb%a7%81%ed%81%ac-%ea%b5%ac%ec%b6%95-%ec%a0%84%eb%9e%b5/
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/">
curl -sI http://127.0.0.1:8011/v1/company.php
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/about-us/
curl -sI http://127.0.0.1:8011/contact.php
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/contact-us/
curl -sI http://127.0.0.1:8011/v1/contact.php
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/contact-us/
curl -sI http://127.0.0.1:8011/shopping_marketing.php
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/naver-shopping-marketing/
curl -sI http://127.0.0.1:8011/shopping_smartstore.php
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/naver-shopping-marketing/
curl -sI http://127.0.0.1:8011/company/anarchy
HTTP/1.1 301 Moved Permanently
Location: /about-us/
curl -sI http://127.0.0.1:8011/v1/gfa.php
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/services/performance-marketing/naver-gfa
curl -sI http://127.0.0.1:8011/v1/youtube.php
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/services/performance-marketing/youtube
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?bo_table=column
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/blog/
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?BO_TABLE=COLUMN&WR_ID=
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/blog/
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?bo_table=column&wr_id=51
HTTP/1.0 301 Moved Permanently
Location: http://127.0.0.1:8011/blog/
curl -sI http://127.0.0.1:8011/insights/%EC%98%A8%EB%9D%BC%EC%9D%B8-%EB%A7%88%EC%BC%80%ED%8C%85-%EC%A0%9C%EB%8C%80%EB%A1%9C-%EB%B0%B0%EC%9A%B8-%EC%88%98-%EC%9E%88%EB%8A%94-%EC%95%84%EB%82%98%ED%82%A4-%EA%B0%95%EC%9D%98
HTTP/1.1 302 Found
Location: http://127.0.0.1:8011/blog/
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=19&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=21&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=29&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=38&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=47&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=52&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=56&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=58&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=59&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=60&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=61&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=62&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=63&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=64&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=65&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=66&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=67&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=68&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=69&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=70&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=71&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=72&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=73&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=74&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=75&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=76&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=77&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=78&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=79&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/v1/manager/bbs/board.php?WR_ID=80&BO_TABLE=COLUMN
HTTP/1.0 410 Gone
X-Robots-Tag: noindex
<meta name="robots" content="noindex">
curl -sI http://127.0.0.1:8011/services/seo/aeo
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/services/seo/aeo">
curl -sI http://127.0.0.1:8011/services/seo/geo
HTTP/1.1 200 OK
<link rel="canonical" href="http://127.0.0.1:8011/services/seo/geo">
curl -sI http://127.0.0.1:8011/seo/not-an-article/
HTTP/1.1 404 Not Found
HTTP smoke: PASS (93 cases; redirect destinations 200 in one hop)
```

검증 후 이 세션이 띄운 8011 프로세스는 종료했고 lsof -nP -iTCP:8011 -sTCP:LISTEN은 출력 없이 exit 1(리스너 없음)이었어. 8000 서버에 시작·종료·재시작 명령은 실행하지 않았어.

### 6. 기본 URL 감사

```sh
php artisan seo:audit-urls --base-url=http://127.0.0.1:8011 --json
```

전체 실제 출력: [live-audit.json](/private/tmp/jcurve-url-preserve-01.gsVPHC/evidence/live-audit.json). 그 JSON의 집계값은 다음과 같아.

```json
{
  "base_url": "http://127.0.0.1:8011",
  "total": 66,
  "passed": 66,
  "failed": 0
}
```

보존 경로 16개는 200, 기존 칼럼 50개는 승인된 정확한 1홉 301과 도착지 200/canonical을 검사했어. WP 세 글의 중복 원주소는 매니페스트에서 중복 제거했어.

### 7. 실제 문의 폼·CSRF

실행 스크립트: [form-smoke.py](/private/tmp/jcurve-url-preserve-01.gsVPHC/form-smoke.py). 실제 폼의 CSRF·무작위 honeypot·암호화 valid_from과 쿠키를 사용했고 정상 저장도 임시 SQLite에서 읽어 확인했어.

```sh
python3 /private/tmp/jcurve-url-preserve-01.gsVPHC/form-smoke.py
```

```text
GET /contact-us/: form action=http://127.0.0.1:8011/contact-us/; CSRF + randomized honeypot present
POST without CSRF:
HTTP/1.1 419 unknown status
POST invalid email:
HTTP/1.1 302 Found
Location: http://127.0.0.1:8011/contact-us/
GET validation errors: invalid-email retained; email validation error visible
POST valid inquiry:
HTTP/1.1 302 Found
Location: http://127.0.0.1:8011/contact-us/
GET success: 문의가 접수됐습니다.; SQLite lead count=1
POST honeypot spam:
HTTP/1.1 200 OK
Honeypot blocked storage; SQLite lead count=1
Real HTTP form / CSRF / validation / storage / honeypot: PASS
```

throttle:5,1의 429는 기능 테스트에서 검증했고, 실제 HTTP 검증의 CACHE_STORE=array 환경에서는 요청 간 rate limit 유지 여부를 별도로 주장하지 않아.

### 8. 테스트 무력화 실험 → 원복 → 재통과

PreservedPaths::destination() 맨 앞에 return null을 잠시 넣어 매핑을 비활성화했어. 그 상태로 원주소 15개 계약 테스트를 실행했어.

```sh
APP_BASE_PATH=/private/tmp/jcurve-url-preserve-01.gsVPHC/appcopy APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= DB_CONNECTION=sqlite DB_DATABASE=:memory: CACHE_STORE=array SESSION_DRIVER=array MAIL_MAILER=array QUEUE_CONNECTION=sync php artisan test --filter=test_preserved_page_renders_original_content_canonical_and_single_hop_aliases
```

실제 실패 출력 전체: [mutation-disabled.log](/private/tmp/jcurve-url-preserve-01.gsVPHC/evidence/mutation-disabled.log)

```text
{"tool":"phpunit","result":"failed","tests":15,"passed":0,"assertions":30,"duration_ms":1503,"failed":15}
```

첫 실패의 실제 메시지:

```text
Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-'https://j-curve.co.kr/about-us/'
+'https://j-curve.co.kr/about-us'
```

즉시 원복한 뒤 비교한 실제 출력:

```text
git diff --stat before/after identical: True
SHA-256 before/after identical: True (4 changed files)
```

실험 전 git diff --stat:

```text
 app/Http/Middleware/PreservePublicUrls.php     | 2 +-
 app/Services/Seo/Publishing/PreservedPaths.php | 6 ++++++
 bootstrap/app.php                              | 2 +-
 tests/Feature/UrlPreservationTest.php          | 5 +++--
 4 files changed, 11 insertions(+), 4 deletions(-)
```

실험 후 git diff --stat:

```text
 app/Http/Middleware/PreservePublicUrls.php     | 2 +-
 app/Services/Seo/Publishing/PreservedPaths.php | 6 ++++++
 bootstrap/app.php                              | 2 +-
 tests/Feature/UrlPreservationTest.php          | 5 +++--
 4 files changed, 11 insertions(+), 4 deletions(-)
```

SHA 비교 대상은 자동 checkpoint 이후 미커밋 변경 4개 파일이야. 원복 뒤 전체 테스트도 다시 실행했고 위 최종 출력처럼 126/126이 통과했어. 임시 무력화 코드는 남아 있지 않아.

## 바꾼 기존 테스트 목록과 이유

| 파일 | 바꾼 검사 | 이유 |
|---|---|---|
| tests/TestCase.php | prepareUrlForRequest | Laravel 기본 테스트 헬퍼가 URL 생성기로 요청 주소를 바꾸고 끝 슬래시를 제거했어. 요청을 원형 그대로 보내고 UTF-8만 안전하게 인코딩해서, N 요청이 테스트 전에 P로 바뀌어 거짓 통과하는 것도 막았어. |
| tests/Feature/LegacyRedirectTest.php | WP about-us 응답, seo-backlinks 목적지, 서브페이지 렌더 경로 | 새 계약인 P=200, 슬래시 없는 P=301 → P로 변경. 나머지 기존 301/404 검사는 유지. |
| tests/Feature/MarketingContentTest.php | 공개 페이지·SEO 서브페이지·문의 GET 경로 | 렌더 검사는 새 정식 주소 P에서 수행. POST /contact는 기존 호환 검사로 유지. |
| tests/Feature/MarketingContentTest.php | 버즈빌·NBT 검사 | 이미 승인된 Q-018과 충돌하던 기존 실패 1개를 assertDontSee에서 assertSee로 갱신. 섹션 수·기존 문구·과장 문구 금지 검사는 유지. URL 계약 외 기존 테스트 정합성 수정이라는 점을 별도로 기록해. |
| tests/Feature/SeoFeedTest.php | 백링크 서비스 렌더·사이트맵·noindex 경로 | 정식 주소 /seo-backlinks/로 검사. 메타데이터가 N 또는 P로 저장되어 있어도 동일하게 제외되게 구현. |
| tests/Feature/SeoUrlAuditTest.php | 승인된 회사 301 fixture | 도착지와 canonical을 /about-us/로 변경. |
| tests/Feature/SeoUrlAuditTest.php | 기본 매니페스트 검사 | 이전 “모든 과거 주소 200 목표” 대신 이번 계약의 보존 원주소 16개 200 + 기존 칼럼 50개 승인 301을 구체적으로 검사. |

## Blade 하드코딩 N 목록

0건. 뷰의 literal href/action에서 N을 찾지 못했어. 메뉴·CTA·브레드크럼 등의 route()/url() 호출은 생성 단계 매핑으로 처리돼. 홈·회사·문의·목록·SEO·WP 글의 렌더 HTML과 JSON-LD도 테스트했어. llms 파일은 현재 없어.

범위 확인의 실제 출력:

```text
Blade literal N href/action: 0
llms files: []
Forbidden paths diff exit code: 0
Existing Google verification tag retained: True
Temporary SQLite insights: 53
Temporary SQLite works: 0
Temporary SQLite leads: 1
Temporary SQLite legacy_redirects: 191
```

## 미검증·남은 사항

- 운영 서버·실DB·MySQL·PHP 8.3·실제 도메인 전환·운영 시더 재실행은 금지 범위라 실행하지 않았어. 로컬 HTTP는 PHP 8.5.8과 임시 SQLite에서 확인했어.
- Slack 원본 CSV 144개 전체 재시험은 이 세션에서 하지 않았어. 지시서를 SSOT로 사용했고, 신규 계약 테스트·실제 HTTP 93개·기본 감사 66개를 실행했어.
- Claude의 별도 독립 검수·최종 승인, 외부 서버의 캐시/프록시/웹서버 리다이렉트 설정은 남아 있어.
- hero-glow.webp 빌드 경고는 그대로 남아 있어. 미디어 수정은 하지 않았어.
- 대시보드 tasks.json·대시보드 생성기·요청 큐는 이번 지시서의 소유 파일 밖이고 대시보드 경로는 쓰기 허용 범위 밖이라 갱신하지 않았어.
- 자동 checkpoint 9f1783e 발생은 위에 기록했어. 이 세션에서 커밋/푸시/배포 명령은 실행하지 않았어.

