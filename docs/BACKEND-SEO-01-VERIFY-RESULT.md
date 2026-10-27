# BACKEND-SEO-01 독립 검증 결과

검증일: 2026-10-27 · 기준 HEAD: `ae256e33cc32686abb2aaaadd613d0c5425283c5` · 작업 폴더: `/Users/anarchy/Claude_Projects/jcurve`

**로컬 백엔드 검증: PASS.** 1차 재현 버그를 부모 구현 세션에 반환하고, 수정본을 다시 동결한 뒤 별도 검증 세션에서 실행했다. 전체 **60/60 tests · 402 assertions**, 독립 공격 **10/10 tests · 108 assertions**, 소유 파일 Pint·PHP 문법 검사·격리 Vite 빌드가 통과했다.

이 결과는 명시된 로컬 계약의 실행 증거다. 사이트 공개 승인·배포 승인·기존 URL의 운영 보존 완료·검색 색인 완료 판정은 하지 않았다. 최종 제품 검수는 별도다.

## 1. 역할·범위 준수

- 구현·수정: 부모 Codex 세션. 검증: 별도 verifier 세션. 검증자가 제품 버그를 수정하지 않았다.
- 검증자 제품 쓰기는 지시서가 허용한 `FeedCatalog::latestInsights()`의 `published()` 1곳 임시 제거·복구 1회뿐이다. 영구 저장 파일은 이 보고서다.
- `AGENTS.md`, `docs/COLLAB.md`, `docs/collab/QUEUE.md`, `docs/BACKEND-SEO-01.md`, `docs/BACKEND-SEO-01-VERIFY.md`, 전역 tri-agent 스킬을 완독했다.
- `.env` 파일을 열거나 로드하지 않았다. 임시 환경 경로에서 SQLite `:memory:`/array 세션·캐시/가짜 메일 설정으로 config를 만들고 `APP_CONFIG_CACHE`를 지정했다. 부모의 config 변경 뒤에는 이를 다시 생성했다.
- 외부 서버·API·DB 요청은 하지 않았다. HTTP 감사는 `Http::fake()`와 `Http::preventStrayRequests()`로 격리했다.
- 프론트·미디어·인증·스키마·301 매핑을 수정하지 않았다. 브랜치 변경·배포·발행·커밋·푸시는 하지 않았다. 대시보드 갱신은 부모가 맡는다.

## 2. 1차 발견 → 수정 → 독립 재검증

| 항목 | 1차 관측·기대 | 수정 위치·방향 | 최종 실행 결과 |
|---|---|---|---|
| 승인 301 목적지 경계 혼동 | 승인 `/company#team`, 관측 Location `/company%23team`인데 감사가 `failed:0`. `/company?team=1` 대 `%3F`도 동일. 기대: 목적지 불일치, 후속 요청 없음 | `UrlAuditor.php:30`, `PublicUrl.php:52`. 예약문자 구분을 유지하는 비교 사용 | 두 공격 모두 `redirect_target_mismatch`; `%23` 공격의 요청은 원주소 1회뿐 |
| canonical 경계 혼동 | 기대 `/company?team=1`, 실제 canonical `/company%3Fteam=1`인데 `failed:0`. 기대: canonical 불일치 | `PublicUrl.php:39`/`:63`. unreserved·UTF-8 정규화와 예약문자 경계를 분리 | `canonical_mismatch_or_missing` 실제 관측 |
| 공개 서브페이지 19개 누락 | `config/subpages.php`의 19개가 전부 실제 로컬 HTTP 200인데 services sitemap에 0/19 포함. 독립 포함 검증 exit 1, 22 assertions | `config/seo.php:21`, `FeedCatalog.php:21`. 4개 그룹 화이트리스트를 합치고 중복 제거·기존 metadata 필터 적용 | 19개 전부 포함. `MISSING_PUBLIC_SUBPAGES []`; noindex·다른 canonical 제외와 중복 없음도 확인 |
| 미래 수정일 처리 보완 | 원본 `min(updated_at, now())`는 기록에 없는 현재일을 만들 수 있다는 소스 검토 결과를 부모에게 전달 | `FeedCatalog.php:47`. 실제 공개 원발행일로 fallback | `updated_at`을 실제 미래 값으로 저장·재조회한 뒤 `lastmod=2021-03-02T00:00:00+00:00` 확인 |
| metadata 경계 보완 | 원본 key가 경로 전체 `rawurldecode()` 사용. 부모가 같은 예약문자 정규화 규칙 적용 | `FeedCatalog::key()` | `/insights/question?draft` metadata가 별도 `%3F` 슬러그를 숨기지 않음; 포함 URL 수 1 |

처음 세 항목은 수정 전에 실제 실패로 재현했다. 날짜·metadata 항목은 원본 소스 검토와 수정본 실행 확인을 구분했다. 독립 fixture 준비 중 `Work.content` 누락과 `updated_at` mass-assignment 무시를 발견해 임시 fixture만 바로잡았다. 이 준비 오류는 제품 버그·최종 검증 수치에 포함하지 않았다. 날짜 fixture는 `forceFill()` 후 DB 재조회 단언문으로 미래 시각이 실제 저장됐는지 먼저 증명한다.

1차 잘못된 감사의 실제 출력:

```text
ENCODED_FRAGMENT_REPORT {"base_url":"https://stage.example","total":1,"passed":1,"failed":0,"results":[{"path":"/old","expected_status":301,"observed_status":301,"issues":[],"final_status":200,"canonical":["https://j-curve.co.kr/company"],"passed":true}]}
ENCODED_FRAGMENT_REQUESTS ["https://stage.example/old","https://stage.example/company"]
ENCODED_QUERY_REPORT {"base_url":"https://stage.example","total":1,"passed":1,"failed":0,"results":[{"path":"/old","expected_status":301,"observed_status":301,"issues":[],"final_status":200,"canonical":["https://j-curve.co.kr/company?team=1"],"passed":true}]}
ENCODED_CANONICAL_REPORT {"base_url":"https://stage.example","total":1,"passed":1,"failed":0,"results":[{"path":"/company?team=1","expected_status":200,"observed_status":200,"issues":[],"canonical":["https://j-curve.co.kr/company%3Fteam=1"],"passed":true}]}
```

## 3. 실행 명령·실제 출력

아래 명령은 저장소 루트에서 실행했다. 임시 경로는 이번 실행에서 실제 사용한 경로다.

### 전체 테스트

```sh
APP_CONFIG_CACHE=/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/config.php php artisan test --compact
```

첫 구현 검증: exit 0.

```text
{"tool":"phpunit","result":"passed","tests":55,"passed":55,"assertions":378,"duration_ms":3908}
```

최종 수정본 재검증: exit 0.

```text
{"tool":"phpunit","result":"passed","tests":60,"passed":60,"assertions":402,"duration_ms":3956}
```

### 독립 공격 테스트

```sh
APP_CONFIG_CACHE=/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/config.php vendor/bin/phpunit --configuration phpunit.xml --no-progress /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/IndependentSeoProbeTest.php
```

최종 exit 0. 저장소의 구현자 테스트와 분리된 임시 파일에서 실행했다. 단언문을 무력화하거나 실패를 성공으로 바꾸는 처리는 없다.

```text
ENCODED_FRAGMENT_REPORT {"base_url":"https://stage.example","total":1,"passed":0,"failed":1,"results":[{"path":"/old","expected_status":301,"observed_status":301,"issues":["redirect_target_mismatch"],"passed":false}]}
ENCODED_FRAGMENT_REQUESTS ["https://stage.example/old"]
ENCODED_QUERY_REPORT {"base_url":"https://stage.example","total":1,"passed":0,"failed":1,"results":[{"path":"/old","expected_status":301,"observed_status":301,"issues":["redirect_target_mismatch"],"passed":false}]}
ENCODED_CANONICAL_REPORT {"base_url":"https://stage.example","total":1,"passed":0,"failed":1,"results":[{"path":"/company?team=1","expected_status":200,"observed_status":200,"issues":["canonical_mismatch_or_missing"],"canonical":["https://j-curve.co.kr/company%3Fteam=1"],"passed":false}]}
FUTURE_UPDATED_AT_LASTMOD 2021-03-02T00:00:00+00:00
RESERVED_METADATA_URL_COUNT 1
MISSING_PUBLIC_SUBPAGES []
{"tool":"phpunit","result":"passed","tests":10,"passed":10,"assertions":108,"duration_ms":17284}
```

| 독립 시나리오 | 실행 확인 |
|---|---|
| 빈 sitemap/RSS·잘못된 페이지·요청 Host/forwarded Host 변조 | XML 파싱 성공, item/URL 0, 잘못된 페이지 404, 공개 origin 유지 |
| 50,001개 URL 분할 경계·크기 clamp | 첫 파일 50,000개, 둘째 1개, 셋째 404, 설정 50,001→50,000/0→1 |
| 한글·XML 특수/제어문자·공개 카테고리·RSS 제한 | XML 파싱 후 정확한 텍스트 비교, 제외 후 최신 50개, noindex 성과 제외 |
| 잘못된 origin/manifest 입력 | 빈 입력·외부/자격증명 URL·잘못된 path·status·중복 path 거부, HTTP 요청 0 |
| 예약문자 리다이렉트 2종·canonical 1종 | 수정 전 false PASS를 수정 후 불일치로 차단 |
| 미래 수정일·metadata 예약문자 경계 | 실제 DB fixture 상태와 최종 XML 값 단언 |
| 공개 서브페이지 19개와 제외 정책 | 각 URL 실제 로컬 200, 전부 loc 포함, noindex/다른 canonical 제외, 중복 없음, 가짜 정적 lastmod 없음 |

기존 테스트에서도 초안·미래 발행·noindex·다른 canonical 제외, 원발행일·시딩 시각 구분, 승인 301 1회와 체인·외부 목적지·404·연결 실패·canonical 누락·본문 손실 구분, 기본 manifest의 200 목표 및 --base-url 생략 시 요청 0을 실제 실행했다.

### Pint·PHP 문법

```sh
vendor/bin/pint --test app/Services/Seo/Publishing app/Http/Controllers/SeoFeedController.php app/Console/Commands/AuditSeoUrls.php config/seo.php routes/seo.php bootstrap/app.php tests/Feature/SeoFeedTest.php tests/Feature/SeoUrlAuditTest.php
```

exit 0. 동일 소유 PHP 파일 12개에 `php -l`도 각각 실행했다.

```text
{"tool":"pint","result":"passed"}
No syntax errors detected in app/Services/Seo/Publishing/UrlAuditManifest.php
No syntax errors detected in app/Services/Seo/Publishing/FeedXml.php
No syntax errors detected in app/Services/Seo/Publishing/PublicUrl.php
No syntax errors detected in app/Services/Seo/Publishing/UrlAuditor.php
No syntax errors detected in app/Services/Seo/Publishing/FeedCatalog.php
No syntax errors detected in app/Http/Controllers/SeoFeedController.php
No syntax errors detected in app/Console/Commands/AuditSeoUrls.php
No syntax errors detected in config/seo.php
No syntax errors detected in routes/seo.php
No syntax errors detected in bootstrap/app.php
No syntax errors detected in tests/Feature/SeoFeedTest.php
No syntax errors detected in tests/Feature/SeoUrlAuditTest.php
```

### Vite 격리 빌드

```sh
npm run build -- --config /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/vite.config.mjs --configLoader native
```

exit 0. 기존 설정을 가져오되 `envDir`와 `build.outDir`를 임시 폴더로 지정해 `.env` 로드·`public/build` 덮어쓰기를 피했다. 실제 출력(터미널 제어문자 제거):

```text
> build
> vite build --config /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/vite.config.mjs --configLoader native

vite v8.2.0 building client environment for production...
transforming...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
✓ 9 modules transformed.
rendering chunks...
computing gzip size...
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/build/manifest.json              0.33 kB │ gzip:  0.16 kB
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/build/assets/app-D_PS-FNm.css   97.94 kB │ gzip: 18.46 kB
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/build/assets/app-XOhwnyVw.js   159.36 kB │ gzip: 60.50 kB
✓ built in 543ms
```

`hero-glow.webp`는 빌드 시 해석되지 않아 runtime 참조로 남는 경고다. 실제 에셋 존재·화면 렌더는 이번 백엔드 검증에서 확인하지 않았다. `package.json`에는 `build`, `dev`만 있고 `typecheck`, `lint`, npm `test` 스크립트는 없다. PHP 스타일 검사는 Pint, 테스트는 Artisan/PHPUnit으로 수행했다.

## 4. 테스트 무력화 실험 1회

부모의 제품 편집 중지를 확인한 뒤 `FeedCatalog::latestInsights()`의 `published()`만 제거했다. `try/finally`로 원문 bytes를 복구하고 같은 테스트를 재실행했다. 이 실험 뒤 부모가 승인된 버그 수정을 진행했으므로 아래 복구 해시는 수정 전 파일의 해시다.

```sh
APP_CONFIG_CACHE=/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/config.php php artisan test --compact --filter=SeoFeedTest::test_only_current_public_content_appears_in_sitemaps_and_rss
```

- 원본 SHA-256: `03b74a1d143d38fc535b05f526d41c9e5581210d355c8aa8892f07a6bbcb34e1`
- 필터 제거 후: `c7393a67362e4c4c1e79b78cc9185733432adfaa35a2db5b1536a3bcaaa9a9a9`
- 원문 복구 후: `03b74a1d143d38fc535b05f526d41c9e5581210d355c8aa8892f07a6bbcb34e1`
- bytes 일치: `True`.
- 제거 시 **exit 1**, RSS 500. `FeedXml.php:37`에서 null 발행일의 `toRssString()` 호출이 실패했다.
- 복구 후 **exit 0**, **1 test · 17 assertions**.

테스트는 필터 제거를 실제로 감지한다. 이번 실험의 직접 실패 지점은 RSS 500이며, 초안이 정상 RSS item으로 노출됐다는 관측은 아니다. 최종 수정본 소스에서도 `published()`가 유지되며 전체 60개 실행에 이 테스트가 포함된다.

무력화 시 실제 전체 출력:

```text
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":10,"duration_ms":336,"failed":1,"failures":[{"test":"Tests\\Feature\\SeoFeedTest::test_only_current_public_content_appears_in_sitemaps_and_rss","file":"/Users/anarchy/Claude_Projects/jcurve/tests/Feature/SeoFeedTest.php","line":33,"message":"Expected response status code [200] but received 500.\nFailed asserting that 500 is identical to 200.\n\nThe following exception occurred during the last request:\n\nError: Call to a member function toRssString() on null in /Users/anarchy/Claude_Projects/jcurve/app/Services/Seo/Publishing/FeedXml.php:37\nStack trace:\n#0 /Users/anarchy/Claude_Projects/jcurve/app/Http/Controllers/SeoFeedController.php(49): App\\Services\\Seo\\Publishing\\FeedXml->rss(Array)\n#1 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php(46): App\\Http\\Controllers\\SeoFeedController->rss(Object(App\\Services\\Seo\\Publishing\\FeedCatalog), Object(App\\Services\\Seo\\Publishing\\FeedXml))\n#2 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Routing/Route.php(275): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\SeoFeedController), 'rss')\n#3 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Routing/Route.php(215): Illuminate\\Routing\\Route->runController()\n#4 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Routing/Router.php(822): Illuminate\\Routing\\Route->run()\n#5 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Routing\\Router->{closure:Illuminate\\Routing\\Router::runRouteWithinStack():821}(Object(Illuminate\\Http\\Request))\n#6 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(52): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}(Object(Illuminate\\Http\\Request))\n#7 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#8 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestForgery.php(104): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#9 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestForgery->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#10 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/View/Middleware/ShareErrorsFromSession.php(48): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#11 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\View\\Middleware\\ShareErrorsFromSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#12 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(120): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#13 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Session/Middleware/StartSession.php(63): Illuminate\\Session\\Middleware\\StartSession->handleStatefulRequest(Object(Illuminate\\Http\\Request), Object(Illuminate\\Session\\Store), Object(Closure))\n#14 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Session\\Middleware\\StartSession->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#15 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/AddQueuedCookiesToResponse.php(36): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#16 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#17 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Cookie/Middleware/EncryptCookies.php(74): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#18 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Cookie\\Middleware\\EncryptCookies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#19 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#20 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Routing/Router.php(821): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#21 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Routing/Router.php(800): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#22 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Routing/Router.php(764): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#23 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Routing/Router.php(753): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#24 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(200): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#25 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Foundation\\Http\\Kernel->{closure:Illuminate\\Foundation\\Http\\Kernel::dispatchToRouter():197}(Object(Illuminate\\Http\\Request))\n#26 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}(Object(Illuminate\\Http\\Request))\n#27 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#28 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#29 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#30 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php(51): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#31 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#32 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#33 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#34 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php(109): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#35 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php(61): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#37 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Http\\Middleware\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#38 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php(58): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#39 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#40 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php(22): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#41 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Foundation\\Http\\Middleware\\InvokeDeferredCallbacks->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#42 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePathEncoding.php(28): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#43 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(219): Illuminate\\Http\\Middleware\\ValidatePathEncoding->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#44 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:{closure:Illuminate\\Pipeline\\Pipeline::carry():194}:195}(Object(Illuminate\\Http\\Request))\n#45 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(175): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#46 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(144): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#47 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(638): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#48 /Users/anarchy/Claude_Projects/jcurve/vendor/laravel/framework/src/Illuminate/Foundation/Testing/Concerns/MakesHttpRequests.php(368): Illuminate\\Foundation\\Testing\\TestCase->call('GET', '/rss', Array, Array, Array, Array)\n#49 /Users/anarchy/Claude_Projects/jcurve/tests/Feature/SeoFeedTest.php(52): Illuminate\\Foundation\\Testing\\TestCase->get('/rss')\n#50 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/src/Framework/TestCase.php(1318): Tests\\Feature\\SeoFeedTest->test_only_current_public_content_appears_in_sitemaps_and_rss()\n#51 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/src/Framework/TestCase.php(1355): PHPUnit\\Framework\\TestCase->invokeTestMethod('test_only_curre...', Array)\n#52 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/src/Framework/TestCase.php(521): PHPUnit\\Framework\\TestCase->runTest()\n#53 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/src/Framework/TestRunner/TestRunner.php(99): PHPUnit\\Framework\\TestCase->runBare()\n#54 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/src/Framework/TestCase.php(361): PHPUnit\\Framework\\TestRunner->run(Object(Tests\\Feature\\SeoFeedTest))\n#55 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/src/Framework/TestSuite.php(374): PHPUnit\\Framework\\TestCase->run()\n#56 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/src/Framework/TestSuite.php(374): PHPUnit\\Framework\\TestSuite->run()\n#57 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/src/Framework/TestSuite.php(374): PHPUnit\\Framework\\TestSuite->run()\n#58 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/src/TextUI/TestRunner.php(64): PHPUnit\\Framework\\TestSuite->run()\n#59 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/src/TextUI/Application.php(229): PHPUnit\\TextUI\\TestRunner->run(Object(PHPUnit\\TextUI\\Configuration\\Configuration), Object(PHPUnit\\Runner\\ResultCache\\DefaultResultCache), Object(PHPUnit\\Framework\\TestSuite))\n#60 /Users/anarchy/Claude_Projects/jcurve/vendor/phpunit/phpunit/phpunit(104): PHPUnit\\TextUI\\Application->run(Array)\n#61 {main}\n\n----------------------------------------------------------------------------------\n\nCall to a member function toRssString() on null"}]}
```

복구 후 실제 전체 출력:

```text
{"tool":"phpunit","result":"passed","tests":1,"passed":1,"assertions":17,"duration_ms":306}
```

## 5. 기존 301·협업 변경 확인

`database/seeders/LegacyRedirectSeeder.php`, `database/seeders/LegacyContentSeeder.php`, `app/Models/LegacyRedirect.php`, `tests/Feature/LegacyRedirectTest.php`는 `git show HEAD:<path>`와 현재 bytes가 모두 같았다. 기존 404 fallback redirect 코드는 유지됐고 `bootstrap/app.php` diff는 SEO route 등록뿐이다. 기존 redirect 테스트도 전체 suite에서 통과했다.

`routes/web.php`는 Q-002의 `pages.php` require 1줄만 추가됐다. Q-003의 PLAN 수정은 사용자 디자인 재사용 지시와 후속 백엔드 범위 안내를 반영한다. 다른 세션의 `AGENTS.md`·`CLAUDE.md`·`docs/COLLAB.md`·`routes/pages.php` 변경은 되돌리지 않았다.

기본 감사 manifest는 보존 목표 **200**이며 기존 301 승인 목록이 아니다. 따라서 현 `/seo/` 등의 기존 301은 감사에서 불일치로 나오는 것이 계약에 맞다.

## 6. 미검증·공개 전 게이트

1. 실제 dev/운영 서버에 이번 코드가 반영됐는지와 실제 원주소·본문·canonical·robots 응답은 미검증이다. 배포·서버 요청을 하지 않았다.
2. 기존 원URL 200 보존 목표와 현 301 정책 차이는 미해결 후속 범위다. 이번 코드는 차이를 보고하는 도구이며 URL 호환 작업을 끝낸 것이 아니다.
3. Q-006의 프론트 canonical/robots·sitemap/RSS 발견 링크 계약은 Claude 구역의 별도 작업·검수가 필요하다.
4. Q-001 dev 접근 차단·noindex는 별도 인증/서버 범위로 남아 있다.
5. 서버 `SEO_PUBLIC_URL`/`APP_URL`·운영 DB·실제 공개 데이터/시간대·프록시·캐시·대규모 DB 성능은 확인하지 않았다. 50,001 경계 검증은 정적 URL fixture이며 운영 글 50,001개 성능 증명은 아니다.
6. GSC·네이버 제출·색인 결과, 실제 화면/에셋 렌더, 최종 공개 승인은 별도다.

## 7. 최종 동결 파일 SHA-256

최종 전체 suite·Pint·독립 공격 실행 직전에 스냅샷을 만들었고 보고서 저장 직전에 다시 비교해 아래 12개 제품·테스트 파일의 bytes가 변하지 않았음을 확인했다.

```text
0e0ec2c83643bbe58d80b4c4fa2767413436742f683ad662a8c3473088aa2bb4  app/Services/Seo/Publishing/UrlAuditManifest.php
19005aa4f8576dcb4cc74b239dfac245d03e25b3c88be971f4378af6facf5aa6  app/Services/Seo/Publishing/FeedXml.php
1d61595d8a5f7b0501d20dad1cc8a83b1fb2c976b58dd996ec08f12ab938a6d4  app/Services/Seo/Publishing/PublicUrl.php
c3ae94db9d29a6b1dc9dbc9bc0fa93966f8978cd39d719a4bad6d686c3b26cbf  app/Services/Seo/Publishing/UrlAuditor.php
55f5aa4431711062cb90e596ec97b1f8fb04896b262e7e9c561263952ff2daca  app/Services/Seo/Publishing/FeedCatalog.php
c96db9a25f5f7e1ecd469b5c4132f93e61ffda05a2471e8b7661531b597cba79  app/Http/Controllers/SeoFeedController.php
e4733d0bc0e02ccdfac66d9eba4bbaad6fdf12e18d4d838cba448602917cec0d  app/Console/Commands/AuditSeoUrls.php
a7a1e66faee3727ba711cb54a538adf6994aa795a464de151839c569f3467799  config/seo.php
1695bc13ff9d8e38866a02610eac0dddc8d4b87bd4cb30b83ebb4a6187355d35  routes/seo.php
4c0a2661a5da867d8c0be3916151e87356e2312eeb714efda246089b77da0338  bootstrap/app.php
31e051110e8cfe25b41e8656e8475baceba24b9934eef83ef011ccd5f99a2103  tests/Feature/SeoFeedTest.php
5fbf3150611d2820104b04bc64d11efb7441c52e7d12d29374279f818952d717  tests/Feature/SeoUrlAuditTest.php
```

## 부록 A. 독립 fixture 원문

임시 파일: `/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/IndependentSeoProbeTest.php`. 아래 원문과 실행 명령으로 재현할 수 있다.

```php
<?php

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Models\SeoMeta;
use App\Models\User;
use App\Models\Work;
use App\Services\Seo\Publishing\FeedCatalog;
use App\Services\Seo\Publishing\PublicUrl;
use App\Services\Seo\Publishing\UrlAuditor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IndependentSeoProbeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => 'https://j-curve.co.kr']);
        $this->travelTo(Carbon::parse('2026-10-27 12:00:00'));
        Http::preventStrayRequests();
    }

    private function xml(string $content): DOMXPath
    {
        $doc = new DOMDocument;
        $this->assertTrue($doc->loadXML($content, LIBXML_NONET));
        return new DOMXPath($doc);
    }

    private function page(string $path, string $body = 'preserved body'): mixed
    {
        return Http::response('<html><head><link rel="canonical" href="https://j-curve.co.kr'.$path.'"></head><body>'.$body.'</body></html>', 200, ['Content-Type' => 'text/html']);
    }

    public function test_empty_feeds_invalid_pages_and_untrusted_forwarded_host(): void
    {
        config(['seo.pages' => [], 'seo.services' => [], 'subpages' => []]);
        $index = $this->xml($this->withHeaders(['X-Forwarded-Host' => 'evil.test'])->get('https://evil.test/sitemap.xml')->assertOk()->assertDontSee('evil.test')->getContent());
        $this->assertSame(4, $index->query('//*[local-name()="sitemap"]')->length);
        foreach (['pages', 'services', 'insights', 'works'] as $section) {
            $xml = $this->xml($this->get('/sitemaps/'.$section.'/1.xml')->assertOk()->getContent());
            $this->assertSame(0, $xml->query('//*[local-name()="url"]')->length);
        }
        $rss = $this->xml($this->get('/rss')->assertOk()->getContent());
        $this->assertSame(0, $rss->query('//item')->length);
        foreach (['-1', '01', '+1', '1.0', '2', '1000000000'] as $page) {
            $this->get('/sitemaps/insights/'.$page.'.xml')->assertNotFound();
        }
        Http::assertNothingSent();
    }

    public function test_fifty_thousand_sitemap_boundary_and_page_size_clamps(): void
    {
        config(['seo.sitemap_page_size' => 50001, 'seo.services' => [], 'subpages' => [], 'seo.pages' => array_map(fn($n) => '/boundary-'.$n, range(1, 50001))]);
        $this->assertSame(50000, app(FeedCatalog::class)->pageSize());
        $index = $this->xml($this->get('/sitemap.xml')->assertOk()->getContent());
        $this->assertSame(1, $index->query('//*[local-name()="loc" and text()="https://j-curve.co.kr/sitemaps/pages/2.xml"]')->length);
        $first = $this->xml($this->get('/sitemaps/pages/1.xml')->assertOk()->getContent());
        $this->assertSame(50000, $first->query('//*[local-name()="url"]')->length);
        $last = $this->xml($this->get('/sitemaps/pages/2.xml')->assertOk()->getContent());
        $this->assertSame(1, $last->query('//*[local-name()="url"]')->length);
        $this->assertSame('https://j-curve.co.kr/boundary-50001', $last->evaluate('string(//*[local-name()="loc"])'));
        $this->get('/sitemaps/pages/3.xml')->assertNotFound();
        config(['seo.sitemap_page_size' => 0]);
        $this->assertSame(1, app(FeedCatalog::class)->pageSize());
    }

    public function test_public_category_date_and_xml_safety_and_filtered_rss_limit(): void
    {
        $user = User::factory()->create();
        $category = InsightCategory::create(['name' => '한글 & <분류>', 'slug' => '한글-분류']);
        for ($i = 0; $i < 54; $i++) {
            Insight::create(['user_id' => $user->id, 'category_id' => $category->id, 'title' => "한글 & <문서> ]]> \x01", 'slug' => 'edge-'.$i, 'content' => '<p>본문 &amp; 검증</p>', 'published_at' => now()->subMinutes($i)]);
        }
        SeoMeta::create(['path' => '/insights/edge-0', 'robots' => 'NOINDEX,follow']);
        SeoMeta::create(['path' => '/insights/edge-1', 'canonical' => '/insights/edge-2']);
        SeoMeta::create(['path' => '/insights/edge-2', 'robots' => 'none']);
        Work::create(['title' => '성과 & <검증>', 'slug' => '한글-성과', 'content' => '<p>성과</p>', 'published_at' => now()]);
        SeoMeta::create(['path' => '/work/한글-성과', 'robots' => 'noindex']);
        $rss = $this->xml($this->get('/rss')->assertOk()->getContent());
        $this->assertSame(50, $rss->query('//item')->length);
        $this->assertSame('https://j-curve.co.kr/insights/edge-3', $rss->evaluate('string(//item[1]/link)'));
        $this->assertSame('https://j-curve.co.kr/insights/edge-52', $rss->evaluate('string(//item[last()]/link)'));
        $this->assertSame('한글 & <문서> ]]> ', $rss->evaluate('string(//item/title)'));
        $pages = $this->xml($this->get('/sitemaps/pages/1.xml')->assertOk()->getContent());
        $this->assertSame(1, $pages->query('//*[local-name()="loc" and text()="https://j-curve.co.kr/insights/category/'.rawurlencode($category->slug).'"]')->length);
        $works = $this->xml($this->get('/sitemaps/works/1.xml')->assertOk()->getContent());
        $this->assertSame(0, $works->query('//*[local-name()="url"]')->length);
    }

    public function test_invalid_origins_and_manifests_never_issue_http(): void
    {
        foreach (['', 'ftp://stage.example', 'https://u:p@stage.example', 'https://stage.example/path', 'https://stage.example?x=1', 'https://stage.example#x', "https://stage.example\\evil"] as $origin) {
            $this->artisan('seo:audit-urls', ['--base-url' => $origin])->assertExitCode(2);
        }
        foreach ([[], [['path' => '//external.example/x']], [['path' => 'https://u:p@external.example/x']], [['path' => '/bad#fragment']], [['path' => '/bad path']], [['path' => '/bad\\path']], [['path' => null]], [['path' => '/ok', 'status' => '200']], [['path' => '/ok', 'status' => 301, 'to' => '//external.example/x']], [['path' => '/ok'], ['path' => '/ok']]] as $entries) {
            $file = tempnam(sys_get_temp_dir(), 'jcurve-attack-');
            try {
                file_put_contents($file, json_encode($entries));
                $this->artisan('seo:audit-urls', ['--base-url' => 'https://stage.example', '--manifest' => $file])->assertExitCode(2);
            } finally { unlink($file); }
        }
        Http::assertNothingSent();
    }

    public function test_encoded_fragment_is_not_an_approved_redirect(): void
    {
        Http::fake([
            'https://stage.example/old' => Http::response('', 301, ['Location' => '/company%23team']),
            'https://stage.example/company' => $this->page('/company'),
        ]);
        $report = app(UrlAuditor::class)->audit([['path' => '/old', 'status' => 301, 'to' => '/company#team']], 'https://stage.example');
        fwrite(STDOUT, "ENCODED_FRAGMENT_REPORT ".json_encode($report, JSON_UNESCAPED_SLASHES)."\n");
        fwrite(STDOUT, "ENCODED_FRAGMENT_REQUESTS ".json_encode(Http::recorded()->map(fn($pair) => $pair[0]->url())->all(), JSON_UNESCAPED_SLASHES)."\n");
        $this->assertSame(1, $report['failed'], 'A literal encoded # path is not the approved fragment destination');
        Http::assertSentCount(1);
    }

    public function test_encoded_query_delimiter_is_not_an_approved_redirect(): void
    {
        Http::fake([
            'https://stage.example/old' => Http::response('', 301, ['Location' => '/company%3Fteam=1']),
            'https://stage.example/company?team=1' => $this->page('/company?team=1'),
        ]);
        $report = app(UrlAuditor::class)->audit([['path' => '/old', 'status' => 301, 'to' => '/company?team=1']], 'https://stage.example');
        fwrite(STDOUT, "ENCODED_QUERY_REPORT ".json_encode($report, JSON_UNESCAPED_SLASHES)."\n");
        $this->assertSame(1, $report['failed'], 'A literal encoded ? path is not the approved query destination');
    }

    public function test_reserved_canonical_delimiters_remain_distinct(): void
    {
        Http::fake(['https://stage.example/company?team=1' => $this->page('/company%3Fteam=1')]);
        $report = app(UrlAuditor::class)->audit([['path' => '/company?team=1', 'status' => 200]], 'https://stage.example');
        fwrite(STDOUT, "ENCODED_CANONICAL_REPORT ".json_encode($report, JSON_UNESCAPED_SLASHES)."\n");
        $this->assertSame(1, $report['failed'], 'Canonical with encoded ? path must not equal a query URL');
    }

    public function test_future_update_timestamp_is_not_invented_as_current_time(): void
    {
        $user = User::factory()->create();
        $category = InsightCategory::create(['name' => 'Dates', 'slug' => 'dates']);
        $article = Insight::create(['user_id' => $user->id, 'category_id' => $category->id, 'title' => 'actual date', 'slug' => 'future-update', 'content' => '<p>body</p>', 'published_at' => Carbon::parse('2021-03-02')]);
        $article->forceFill(['created_at' => Carbon::parse('2021-03-02'), 'updated_at' => now()->addYear()])->save();
        $this->assertSame(now()->addYear()->toAtomString(), $article->fresh()->updated_at->toAtomString());
        $xml = $this->xml($this->get('/sitemaps/insights/1.xml')->assertOk()->getContent());
        $lastmod = $xml->evaluate('string(//*[local-name()="lastmod"])');
        fwrite(STDOUT, "FUTURE_UPDATED_AT_LASTMOD ".$lastmod."\n");
        $this->assertSame($article->published_at->toAtomString(), $lastmod, 'Future database timestamp must fall back to the recorded publication timestamp');
    }

    public function test_metadata_key_does_not_merge_encoded_query_delimiter_with_query(): void
    {
        $user = User::factory()->create();
        $category = InsightCategory::create(['name' => 'Keys', 'slug' => 'keys']);
        Insight::create(['user_id' => $user->id, 'category_id' => $category->id, 'title' => 'literal-question', 'slug' => 'question?draft', 'content' => '<p>body</p>', 'published_at' => now()]);
        SeoMeta::create(['path' => '/insights/question?draft', 'robots' => 'noindex']);
        $xml = $this->xml($this->get('/sitemaps/insights/1.xml')->assertOk()->getContent());
        $count = $xml->query('//*[local-name()="url"]')->length;
        fwrite(STDOUT, "RESERVED_METADATA_URL_COUNT ".$count."\n");
        $this->assertSame(1, $count, 'A query URL metadata key must not hide the distinct encoded-question-mark slug');
    }

    public function test_public_configured_marketing_subpages_are_in_sitemap(): void
    {
        $xml = $this->xml($this->get('/sitemaps/services/1.xml')->assertOk()->getContent());
        $locations = [];
        foreach ($xml->query('//*[local-name()="loc"]') as $loc) { $locations[] = $loc->textContent; }
        $missing = [];
        foreach (['seo' => '/services/seo', 'cpa' => '/services/cpa-marketing', 'performance' => '/services/performance-marketing', 'boostingshop' => '/solutions/boostingshop'] as $group => $prefix) {
            foreach (array_keys(config('subpages.'.$group.'.items', [])) as $slug) {
                $path = $prefix.'/'.$slug;
                $this->get($path)->assertOk();
                if (!in_array('https://j-curve.co.kr'.$path, $locations, true)) { $missing[] = $path; }
            }
        }
        fwrite(STDOUT, "MISSING_PUBLIC_SUBPAGES ".json_encode($missing, JSON_UNESCAPED_SLASHES)."\n");
        $this->assertSame([], $missing, 'Public configured marketing detail pages must not be omitted from their sitemap');
        $this->assertSame(count($locations), count(array_unique($locations)), 'Combined sitemap must not contain duplicate URLs');
        SeoMeta::create(['path' => '/services/cpa-marketing/insurance', 'robots' => 'noindex']);
        SeoMeta::create(['path' => '/solutions/boostingshop/basic', 'canonical' => '/solutions/boostingshop/pro']);
        $filtered = $this->xml($this->get('/sitemaps/services/1.xml')->assertOk()->getContent());
        $this->assertSame(0, $filtered->query('//*[local-name()="loc" and text()="https://j-curve.co.kr/services/cpa-marketing/insurance"]')->length);
        $this->assertSame(0, $filtered->query('//*[local-name()="loc" and text()="https://j-curve.co.kr/solutions/boostingshop/basic"]')->length);
        $this->assertSame(0, $filtered->query('//*[local-name()="lastmod"]')->length, 'Static pages must not receive an invented current date');

    }
}
```

## 부록 B. 환경 격리 파일

`make-safe-config.php` 원문:

```php
<?php
require '/Users/anarchy/Claude_Projects/jcurve/vendor/autoload.php';
$app = require '/Users/anarchy/Claude_Projects/jcurve/bootstrap/app.php';
$app->useEnvironmentPath(__DIR__);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
file_put_contents(__DIR__.'/config.php', '<?php return '.var_export($app['config']->all(), true).';');
echo "Safe environment config created without repository .env\n";
```

생성 명령:

```sh
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= APP_URL=http://localhost DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= CACHE_STORE=array SESSION_DRIVER=array QUEUE_CONNECTION=sync MAIL_MAILER=array BROADCAST_CONNECTION=null php /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/make-safe-config.php
```

`vite.config.mjs` 원문:

```js
import base from '/Users/anarchy/Claude_Projects/jcurve/vite.config.js';
export default { ...base, envDir: '/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4', build: { ...base.build, outDir: '/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-seo-verify-aqa4_1v4/build', emptyOutDir: true } };
```
