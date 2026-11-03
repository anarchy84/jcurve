# SEO-META-02 구현 결과

작성: Codex, 2026-11-03. 지시서: `docs/SPEC-CODEX-SEO-META-02.md`. 기대값: `docs/SEO-META-02-TITLES.json`.

## 변경 파일과 핵심 diff

| 파일 | 변경 내용 |
|---|---|
| `config/subpages.php` | SEO 하위 5개 항목에 정본의 `seo_title` 추가, `meta_description` 교체. 기존 `title`·본문·문의 템플릿은 유지 |
| `database/seeders/LegacyContentSeeder.php` | WP 3편의 H1용 순수 제목·브랜드 꼬리를 제외한 `meta_title`·정본 설명문·기사부터 시작하는 excerpt 저장. 대표 이미지와 기사 HTML을 원문에서 그대로 추출하고 위젯을 제외. 남는 본문 h1은 h2로 전환 |
| `routes/web.php` | 확인한 WP 사이트맵 별칭 8개 → `/sitemap.xml`, `/feed`·`/feed/` → `/rss`, 301 직행 |
| `public/robots.txt` | 기존 크롤링 허용 두 줄에 `Sitemap: https://j-curve.co.kr/sitemap.xml` 추가 |
| `tests/Feature/SeoMetaRestorationTest.php` | 정본 16경로의 메타값·robots, WP 기사 보존·재시딩, GET/HEAD 리다이렉트, robots.txt 회귀 검사 |
| `docs/SEO-META-02-IMPL-RESULT.md` | 이 반환물 |

기사의 메타 제목은 `순수 제목 + ' - SEO 전문 컨설팅 기업'`으로 저장해. 기존 Blade가 붙이는 ` | 제이커브인터렉티브`와 합쳐서 정본 제목이 돼. 정본 JSON은 테스트가 직접 읽고, 운영 시더는 문서 파일에 의존하지 않아.

시더는 기존 `updateOrCreate(['slug' => ...])`에 정리된 필드와 메타값을 함께 넘겨서 이미 존재하는 행도 교정해. 옛 칼럼 50편의 처리, 숨김 설정, 아나키 문장 제거 accessor는 건드리지 않았어. `Insight.php` 수정은 필요 없었어.

## 실제 운영 사이트맵에서 확인한 주소

지시서 §C의 읽기 요청만 수행했어. 운영 서버 로그인·DB 접속·파일 변경은 없어.

Python `urllib.request.urlopen(..., timeout=25)`로 다음 두 공개 URL을 GET했어. 웹 열람 도구는 해당 URL에서 접근 오류를 반환해서 직접 HTTP 읽기로 확인했어.

```text
https://j-curve.co.kr/robots.txt
HTTP 200, 357 bytes
SHA256 6eaa922b063601cb5bcb17eb5ae26c22337b84b238134d42202c3c524a8629dd
Sitemap: https://j-curve.co.kr/sitemap.xml
Sitemap: https://j-curve.co.kr/news-sitemap.xml
Sitemap: https://j-curve.co.kr/sitemap_index.xml

https://j-curve.co.kr/sitemap_index.xml
HTTP 200, 907 bytes
SHA256 8c536c3cc62cea29565664734a476129187c3d7a6653fa115e6e0a58fea2fda9
```

색인 XML의 `<sitemap><loc>`은 아래 **5개 전부**였어. 추측한 사이트맵 이름을 더하지 않았어.

```text
https://j-curve.co.kr/post-sitemap.xml
https://j-curve.co.kr/page-sitemap.xml
https://j-curve.co.kr/product-sitemap.xml
https://j-curve.co.kr/avada_portfolio-sitemap.xml
https://j-curve.co.kr/category-sitemap.xml
```

이 5개와 `sitemap_index.xml`, `news-sitemap.xml`, `wp-sitemap.xml`을 같은 `/sitemap.xml`로 보내. 미들웨어의 보존 경로에 해당하지 않는 직접 라우트여서 옛 주소 정규화 경유가 없어.

## §B 글별 제거 전후 텍스트 차이

원본 JSON의 HTML을 실제 `wpArticleContent()`에 넘긴 결과를 HTMLParser로 텍스트 노드화한 뒤 `difflib.unified_diff(..., n=1)`로 비교했어. `-`는 제거한 원래 화면 잔재, 앞에 공백이 있는 줄은 보존한 기사 문장이야. 기사 문장 추가·수정은 없어.

| 글 | 원문 HTML bytes → 표시본 bytes | 보존한 기사 이미지 / 링크 | 원문 전체 h1 → 저장 본문 h1 |
|---|---:|---:|---:|
| 고급 링크 구축 전략 | 96,582 → 72,720 | 22 / 0 | 3 → 0 |
| Chrome·Firefox Nofollow | 29,773 → 6,522 | 2 / 4 | 3 → 0 |
| 11가지 SEO 실수 | 61,829 → 37,631 | 10 / 0 | 3 → 0 |

이미지 수는 대표 이미지를 포함한 `<img>` 수야. 기사 링크만 세었고, 삭제한 공유·관련 글·카테고리 위젯 링크는 제외했어. 현재 원문 3편의 h1은 모두 앞쪽 배너·중복 제목에 있어 그 블록과 함께 제거돼. 추출 후에도 h1이 남는 경우에는 태그 이름만 h2로 내려.

### 1. 경쟁자를 압도하는 6가지 고급 링크 빌딩 구축 전략

```diff
--- WP 화면 원문
+++ 시딩 후 표시본
@@ -1,6 +1 @@
-SEO Blog
-SEO에 대한 유용한 정보와 기사
-경쟁자를 압도하는 6가지 고급 링크 빌딩 구축 전략
-1월 18th, 2025
-jcurve
 몇 년 후의 웹사이트를 상상해보세요. 미친 듯이 노력한다면 검색 엔진 트래픽이 늘어나고, 백링크와 참조 도메인이 늘어나고, 전환율이 높아지기를 바랄 것입니다.
@@ -268,21 +263 @@
 이러한 점을 명심한다면 귀하의 웹사이트의 미래는 더욱 밝아질 것입니다.
-Categories:
-SEO 개념
-,
-링크빌딩
-마음껏 공유해 가세요~
-Related Posts
-11가지 최고의 SEO 실수와 이를 피하는 방법
-11가지 최고의 SEO 실수와 이를 피하는 방법
-1월 14th, 2025
-|
-0 Comments
-Chrome 및 Firefox에서 Nofollow 링크를 확인하는 방법
-Chrome 및 Firefox에서 Nofollow 링크를 확인하는 방법
-1월 14th, 2025
-|
-0 Comments
-Search for:
-Categorys
-SEO 개념
-링크빌딩
```

실제 excerpt:

```text
몇 년 후의 웹사이트를 상상해보세요. 미친 듯이 노력한다면 검색 엔진 트래픽이 늘어나고, 백링크와 참조 도메인이 늘어나고, 전환율이 높아지기를 바랄 것입니...
```

표시본 HTML SHA256: `2bf336b20048c9d4f5399b2bb718cb2887ccf46b0fb429b74c1b81a30486a3b0`.

### 2. Chrome 및 Firefox에서 Nofollow 링크를 확인하는 방법

```diff
--- WP 화면 원문
+++ 시딩 후 표시본
@@ -1,6 +1 @@
-SEO Blog
-SEO에 대한 유용한 정보와 기사
-Chrome 및 Firefox에서 Nofollow 링크를 확인하는 방법
-1월 14th, 2025
-jcurve
 웹사이트로의
@@ -25,23 +20 @@
 웹마스터가 나중에 귀하의 링크에 nofollow를 추가할 수 있다는 사실을 잊지 마십시오.
-Categories:
-SEO 개념
-,
-링크빌딩
-Tags:
-seo
-마음껏 공유해 가세요~
-Related Posts
-경쟁자를 압도하는 6가지 고급 링크 빌딩 구축 전략
-경쟁자를 압도하는 6가지 고급 링크 빌딩 구축 전략
-1월 18th, 2025
-|
-0 Comments
-11가지 최고의 SEO 실수와 이를 피하는 방법
-11가지 최고의 SEO 실수와 이를 피하는 방법
-1월 14th, 2025
-|
-0 Comments
-Search for:
-Categorys
-SEO 개념
-링크빌딩
```

실제 excerpt:

```text
웹사이트로의 링크빌딩(Links Building) 할 때 , 링크에 nofollow 속성이 없는지 확인하는 것이 매우 중요합니다 . Google 및 기타 검색 엔진의 경우 nofollow는...
```

표시본 HTML SHA256: `6ee162759f5afc7b469639aba575f4faea3bcebedbf0fb478eb0d86265c161e9`.

### 3. 11가지 최고의 SEO 실수와 이를 피하는 방법

```diff
--- WP 화면 원문
+++ 시딩 후 표시본
@@ -1,6 +1 @@
-SEO Blog
-SEO에 대한 유용한 정보와 기사
-11가지 최고의 SEO 실수와 이를 피하는 방법
-1월 14th, 2025
-jcurve
 Google은 지속적으로 알고리즘을 업데이트하기 위해 노력하고 있습니다.
@@ -147,23 +142 @@
 이게 게임이에요. 규칙을 꼭 따라주세요!
-Categories:
-SEO 개념
-Tags:
-seo 노하우
-,
-seo 실수
-마음껏 공유해 가세요~
-Related Posts
-경쟁자를 압도하는 6가지 고급 링크 빌딩 구축 전략
-경쟁자를 압도하는 6가지 고급 링크 빌딩 구축 전략
-1월 18th, 2025
-|
-0 Comments
-Chrome 및 Firefox에서 Nofollow 링크를 확인하는 방법
-Chrome 및 Firefox에서 Nofollow 링크를 확인하는 방법
-1월 14th, 2025
-|
-0 Comments
-Search for:
-Categorys
-SEO 개념
-링크빌딩
```

실제 excerpt:

```text
Google은 지속적으로 알고리즘을 업데이트하기 위해 노력하고 있습니다. 그리고 초보자와 전문가가 모두 저지르는 가장 흔한 SEO 실수가 바로 Google의 표적이...
```

표시본 HTML SHA256: `fd2656d873a4410ed4705e372ff22a71f2993d630d3cf1decc76667ccb9639c9`.

`← 인사이트 목록`은 보존 원문 3개 안에는 없었어. 새 화면이 제공하는 목록 이동 UI는 이 시더의 정리 대상이 아니야.

## 실행 명령·실제 출력·검증 결과

**별도 검증 세션의 로컬 게이트 통과:** 전체 **158 tests / 19,636 assertions**, 신규 묶음 **32 / 381**, 추가 독립 공격 **3 / 537**, Pint **4 files**, Vite build 성공. 신규 묶음은 전체 158개에 포함되고, 독립 공격 3개는 별도 임시 fixture야.

구현은 Codex 본 세션, 검증·테스트·무력화 실험은 별도 Codex verifier 세션이 맡았어. 검증 세션은 원본 제품 코드를 수정하지 않았고, 최초 실패를 보고받은 구현 세션이 신규 테스트의 상대 Location 처리만 보정했어. 최종 제품 합격 판정은 Claude·대웅 검수 대상이야.

### 격리와 재현 경로

- 격리본: `/private/tmp/seo-meta-02-independent-20261103-125706/isolated`.
- 실제 `.env`, 기존 SQLite DB, `.git`, 기존 storage를 제외한 복사본에서 실행했어. vendor와 node_modules도 실제 복사했고, Reflection으로 App·Seeder·TestCase·Laravel·PHPUnit 클래스 **5개 모두 격리본 경로를 로드**하는 것을 확인했어.
- `APP_ENV=testing`, `APP_URL=http://localhost`, `SEO_PUBLIC_URL=https://j-curve.co.kr`, `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`, `CACHE_STORE=array`, `SESSION_DRIVER=array`, `MAIL_MAILER=array`, `QUEUE_CONNECTION=sync`, 공개 dummy APP_KEY를 썼어. 원래 환경을 상속하지 않고 허용한 환경변수만 전달했어.
- 실행 환경: PHP 8.5.8, Node 20.20.2, npm 10.8.2. npm 스크립트는 build/dev만 있고 별도 typecheck/lint/test는 없어.
- 재현 실행기: [run.py](/private/tmp/seo-meta-02-independent-20261103-125706/run.py), 환경: [environment.json](/private/tmp/seo-meta-02-independent-20261103-125706/environment.json), 소스 비교 증거: [source-preservation-final.json](/private/tmp/seo-meta-02-independent-20261103-125706/source-preservation-final.json).
- 각 로그 첫 줄이 실제 실행 명령이고 마지막의 `EXIT_CODE`가 종료 코드야. 아래 전체 출력은 ANSI 제어문자만 제거했어.

최종 전체 게이트를 실행한 호출:

```sh
python3 /private/tmp/seo-meta-02-independent-20261103-125706/run.py full-test-restored-final php artisan test
```

### 전체 PHP 테스트 — 무력화 실험 원복 후 최종 실행

<details>
<summary>실제 전체 출력: 158 passed / 19,636 assertions</summary>

```text
$ php artisan test

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\Auth\AuthenticationTest
  ✓ login screen can be rendered                                         0.58s  
  ✓ users can authenticate using the login screen                        0.05s  
  ✓ users can not authenticate with invalid password                     0.22s  
  ✓ users can logout                                                     0.01s  

   PASS  Tests\Feature\Auth\EmailVerificationTest
  ✓ email verification screen can be rendered                            0.03s  
  ✓ email can be verified                                                0.02s  
  ✓ email is not verified with invalid hash                              0.02s  

   PASS  Tests\Feature\Auth\PasswordConfirmationTest
  ✓ confirm password screen can be rendered                              0.02s  
  ✓ password can be confirmed                                            0.02s  
  ✓ password is not confirmed with invalid password                      0.22s  

   PASS  Tests\Feature\Auth\PasswordResetTest
  ✓ reset password link screen can be rendered                           0.02s  
  ✓ reset password link can be requested                                 0.23s  
  ✓ reset password screen can be rendered                                0.22s  
  ✓ password can be reset with valid token                               0.24s  

   PASS  Tests\Feature\Auth\PasswordUpdateTest
  ✓ password can be updated                                              0.03s  
  ✓ correct password must be provided to update password                 0.02s  

   PASS  Tests\Feature\Auth\RegistrationTest
  ✓ registration screen can be rendered                                  0.05s  
  ✓ new users can register                                               0.03s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                        0.05s  

   PASS  Tests\Feature\LegacyRedirectTest
  ✓ wordpress page with trailing slash is preserved                      0.08s  
  ✓ service landing redirects                                            0.05s  
  ✓ legacy php landing redirects                                         0.05s  
  ✓ v1 insurance landing redirects in one hop                            0.06s  
  ✓ avada dummy portfolio redirects to work                              0.07s  
  ✓ gnuboard column query redirects to insight                           0.06s  
  ✓ unknown path stays 404                                               0.05s  
  ✓ subpage whitelist enforced                                           0.06s  
  ✓ standalone pages render                                              0.04s  

   PASS  Tests\Feature\MarketingContentTest
  ✓ public marketing pages render                                        0.13s  
  ✓ all configured subpages render                                       0.20s  
  ✓ reward inquiry paths prefill distinct roles                          0.06s  
  ✓ reward inquiry roles are accepted and stored                         0.02s  
  ✓ reward page contains advertiser and publisher decision content       0.02s  
  ✓ instagram guides do not sell artificial engagement                   0.05s  
  ✓ insurance page reuses the full legacy decision journey               0.02s  
  ✓ insurance faq schema matches visible faq count                       0.02s  
  ✓ insurance inquiry is prefilled and stored                            0.02s  

   PASS  Tests\Feature\ProfileTest
  ✓ profile page is displayed                                            0.03s  
  ✓ profile information can be updated                                   0.01s  
  ✓ email verification status is unchanged when the email address is un… 0.01s  
  ✓ user can delete their account                                        0.02s  
  ✓ correct password must be provided to delete account                  0.02s  

   PASS  Tests\Feature\RankfreeClientTest
  ✓ disabled missing key and submission gate never contact remote        0.03s  
  ✓ catalog only returns reviewed products and customer fields           0.04s  
  ✓ create order uses server quote and returns pending not completed     0.02s  
  ✓ unreviewed product path injection and invalid values send nothing    0.01s  
  ✓ non orderable and file fields never reach order post                 0.04s  
  ✓ empty fields are a json object and optional numbers are omitted      0.02s  
  ✓ validation errors are sanitized and not retried                      0.01s  
  ✓ post transport failure is uncertain and is never retried             0.01s  
  ✓ post redirect server error and malformed success are uncertain       0.01s  
  ✓ order status keeps server ownership boundary and filters internal d… 0.01s  
  ✓ read redirect and malformed json do not leak or follow remote        0.01s  
  ✓ nested product metadata is rejected instead of returning internal v… 0.01s  
  ✓ malformed customer field metadata cannot be returned or posted       0.01s  
  ✓ missing or invalid order product is a safe error and explicit null…  0.02s  

   PASS  Tests\Feature\RankfreeConnectionApiTest
  ✓ guest receives private json even when accepting html                 0.02s  
  ✓ registration stores authenticated ciphertext without returning key…  0.03s  
  ✓ replacement preserves one row and changes revision and resolved key  0.03s  
  ✓ other customer cannot view replace or disconnect a connection by id… 0.02s  
  ✓ current password is required for registration and disconnect         0.02s  
  ✓ disconnect is idempotent and reregistration uses a new revision      0.03s  
  ✓ invalid types key length unknown fields and query values do not mut… 0.03s  
  ✓ only json objects with a small body are accepted                     0.02s  
  ✓ csrf is enforced outside the framework unit test bypass              0.02s  
  ✓ feature flag is closed and does not enable order flags               0.03s  
  ✓ write rate limit is per customer and shared by put and delete        0.05s  
  ✓ debug error is redacted in json and default exception log            0.02s  
  ✓ deleted user with a stale auth instance cannot read or register      0.03s  

   PASS  Tests\Feature\RankfreeConnectionStoreTest
  ✓ resolver reads each customer from storage and disconnect cannot be…  0.03s  
  ✓ ciphertext tampering fails closed without chain or network           0.01s  
  ✓ replacement failure keeps the existing ciphertext and revision       0.03s  
  ✓ soft delete purges only its credentials and restore does not restor… 0.02s  
  ✓ force delete cascades and repeated equal keys use randomized cipher… 0.02s  

   PASS  Tests\Feature\RankfreeCustomerIsolationTest
  ✓ unlinked or wrong customer cannot fall back to global key            0.02s  
  ✓ alternating customer calls keep their original keys without shared…  0.02s  
  ✓ preflight order and status all use the same customer and other acco… 0.01s  
  ✓ credential and client debug json and export never include the key    0.01s  
  ✓ credentials cannot be persisted via serialization or change custome… 0.01s  
  ✓ invalid credential errors hide constructor arguments                 0.01s  

   PASS  Tests\Feature\SeoFeedTest
  ✓ only current public content appears in sitemaps and rss              0.03s  
  ✓ index is paginated and does not trust request host                   0.04s  
  ✓ imported article keeps original date and removal is immediate        0.03s  
  ✓ rss limit and noindex category and private routes                    0.04s  
  ✓ invalid metadata canonical does not break other entries              0.02s  
  ✓ metadata paths preserve encoded delimiters                           0.02s  
  ✓ future update timestamp does not invent a current lastmod            0.02s  
  ✓ existing public service subpages are discoverable and respect noind… 0.06s  

   PASS  Tests\Feature\SeoMetaRestorationTest
  ✓ public metadata matches the authoritative json with data set "/"     0.17s  
  ✓ public metadata matches the authoritative json with data set "/abou… 0.12s  
  ✓ public metadata matches the authoritative json with data set "/cont… 0.09s  
  ✓ public metadata matches the authoritative json with data set "/blog… 0.12s  
  ✓ public metadata matches the authoritative json with data set "/blog… 0.18s  
  ✓ public metadata matches the authoritative json with data set "/blog… 0.12s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.11s  
  ✓ public metadata matches the authoritative json with data set "/seo-… 0.11s  
  ✓ public metadata matches the authoritative json with data set "/word… 0.10s  
  ✓ public metadata matches the authoritative json with data set "/nave… 0.15s  
  ✓ public metadata matches the authoritative json with data set "/nave… 0.13s  
  ✓ public metadata matches the authoritative json with data set "/kaka… 0.11s  
  ✓ public metadata matches the authoritative json with data set "/coup… 0.10s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.11s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.16s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.15s  
  ✓ dev host remains noindex                                             0.38s  
  ✓ articles keep their sentences images and links without wordpress wi… 0.14s  
  ✓ articles keep their sentences images and links without wordpress wi… 0.12s  
  ✓ articles keep their sentences images and links without wordpress wi… 0.12s  
  ✓ reseeding repairs existing wp rows and is idempotent without changi… 0.20s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.13s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.14s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.12s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.52s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.63s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.23s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.18s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.19s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.18s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.15s  
  ✓ robots txt keeps crawling allowed and advertises the current sitema… 0.14s  

   PASS  Tests\Feature\SeoUrlAuditTest
  ✓ preservation is a 200 contract and existing mapping is not changed   0.04s  
  ✓ preserved content and explicit single hop redirect pass              0.01s  
  ✓ chain external target missing canonical noindex and connection fail… 0.02s  
  ✓ default manifest preserves pages and explicitly approves existing c… 0.02s  
  ✓ no base url does not contact any server                              0.02s  
  ✓ external manifest paths are rejected before network requests         0.01s  
  ✓ invalid origin cannot replace the public base                        0.01s  
  ✓ encoded delimiters cannot masquerade as approved redirect targets    0.01s  
  ✓ url comparison preserves reserved characters and accepts unicode en… 0.01s  

   PASS  Tests\Feature\UrlPreservationTest
  ✓ preserved page renders original content canonical and single hop al… 0.23s  
  ✓ preserved page renders original content canonical and single hop al… 0.22s  
  ✓ preserved page renders original content canonical and single hop al… 0.22s  
  ✓ preserved page renders original content canonical and single hop al… 0.25s  
  ✓ preserved page renders original content canonical and single hop al… 0.25s  
  ✓ preserved page renders original content canonical and single hop al… 0.16s  
  ✓ preserved page renders original content canonical and single hop al… 0.16s  
  ✓ preserved page renders original content canonical and single hop al… 0.25s  
  ✓ preserved page renders original content canonical and single hop al… 0.30s  
  ✓ preserved page renders original content canonical and single hop al… 0.23s  
  ✓ preserved page renders original content canonical and single hop al… 0.30s  
  ✓ preserved page renders original content canonical and single hop al… 0.16s  
  ✓ preserved page renders original content canonical and single hop al… 0.25s  
  ✓ preserved page renders original content canonical and single hop al… 0.21s  
  ✓ preserved page renders original content canonical and single hop al… 0.17s  
  ✓ percent encoded article paths in both hex cases render and normaliz… 0.22s  
  ✓ generated urls cover parameters queries fragments and relative rout… 0.09s  
  ✓ canonical override cannot replace preserved canonical                0.16s  
  ✓ rendered internal hrefs and structured data do not point to modern…  0.29s  
  ✓ contact success validation honeypot and throttle use preserved form  0.17s  
  ✓ sitemaps rss pagination and preservation audit use original paths    0.19s  
  ✓ legacy chains new redirects and every v1 landing are one hop         0.34s  
  ✓ all thirty missing columns are gone with case and query order indep… 0.22s  
  ✓ live column and dummy redirects remain unchanged                     0.19s  
  ✓ hidden insight is reversible and absent from all public collections  0.24s  
  ✓ only two introduction sentences are hidden without changing raw con… 0.16s  
  ✓ seeders are idempotent and upgrade stale rows                        0.53s  
  ✓ unmapped paths and unknown seo slugs keep their behaviour            0.19s  

  Tests:    158 passed (19636 assertions)
  Duration: 16.62s


EXIT_CODE=0
ELAPSED_SECONDS=17.166
```

</details>

### 신규 SEO-META-02 테스트 묶음

```text
$ php artisan test --filter=SeoMetaRestorationTest

   PASS  Tests\Feature\SeoMetaRestorationTest
  ✓ public metadata matches the authoritative json with data set "/"     0.30s  
  ✓ public metadata matches the authoritative json with data set "/abou… 0.10s  
  ✓ public metadata matches the authoritative json with data set "/cont… 0.10s  
  ✓ public metadata matches the authoritative json with data set "/blog… 0.09s  
  ✓ public metadata matches the authoritative json with data set "/blog… 0.11s  
  ✓ public metadata matches the authoritative json with data set "/blog… 0.11s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.08s  
  ✓ public metadata matches the authoritative json with data set "/seo-… 0.09s  
  ✓ public metadata matches the authoritative json with data set "/word… 0.09s  
  ✓ public metadata matches the authoritative json with data set "/nave… 0.09s  
  ✓ public metadata matches the authoritative json with data set "/nave… 0.08s  
  ✓ public metadata matches the authoritative json with data set "/kaka… 0.09s  
  ✓ public metadata matches the authoritative json with data set "/coup… 0.08s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.07s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.08s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.08s  
  ✓ dev host remains noindex                                             0.23s  
  ✓ articles keep their sentences images and links without wordpress wi… 0.11s  
  ✓ articles keep their sentences images and links without wordpress wi… 0.11s  
  ✓ articles keep their sentences images and links without wordpress wi… 0.11s  
  ✓ reseeding repairs existing wp rows and is idempotent without changi… 0.18s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.11s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.10s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.09s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.11s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.11s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.12s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.11s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.10s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.10s  
  ✓ legacy sitemaps and feeds redirect once for get and head with data…  0.10s  
  ✓ robots txt keeps crawling allowed and advertises the current sitema… 0.09s  

  Tests:    32 passed (381 assertions)
  Duration: 3.65s


EXIT_CODE=0
ELAPSED_SECONDS=4.038
```

공개 호스트 16개 경로는 title과 description의 정본 일치·중복 없음·공개 robots를 검사해. dev 호스트 16개는 noindex를 검사해. 옛 사이트맵 8개와 feed 2개 형태는 GET/HEAD **20개 조합**에서 301 → 200을 확인해. 시더는 이미 더러운 DB 행을 새 값으로 교정하고 같은 인스턴스로 두 번 실행해 전체 53행이 같은지도 검사해.

### 변경 PHP 스타일

```text
$ vendor/bin/pint --test config/subpages.php database/seeders/LegacyContentSeeder.php routes/web.php tests/Feature/SeoMetaRestorationTest.php

  ....

  ──────────────────────────────────────────────────────────────────── Laravel  
    PASS   ........................................................... 4 files  


EXIT_CODE=0
ELAPSED_SECONDS=0.479
```

### 프론트 빌드

```text
$ npm run build

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
public/build/assets/app-Bust_w4X.css             97.40 kB │ gzip: 18.38 kB
public/build/assets/jc-DIWfGL1E.js               25.80 kB │ gzip:  9.23 kB
public/build/assets/app-XOhwnyVw.js             159.36 kB │ gzip: 60.50 kB

✓ built in 1.14s

EXIT_CODE=0
ELAPSED_SECONDS=1.551
```

`/media/bg/hero-glow.webp`는 빌드 시 해석되지 않아 런타임 해석으로 남는 경고가 있어. 빌드는 exit 0이고, 금지된 미디어 파일을 수정하지 않았어. 생성물은 격리본의 public/build에만 만들어졌어.

### 추가 독립 공격 검사

```text
$ php artisan test /private/tmp/seo-meta-02-independent-20261103-125706/IndependentSeoMetaAttackTest.php

   PASS  Tests\Feature\IndependentSeoMetaAttackTest
  ✓ independent public dev og positioning and home numbers               0.81s  
  ✓ baseline wp upgrade twice preserves other fifty rows and all tables  0.33s  
  ✓ subpage non seo fields and default titles remain the baseline        0.13s  

  Tests:    3 passed (537 assertions)
  Duration: 1.49s


EXIT_CODE=0
ELAPSED_SECONDS=1.966
```

검증자가 별도 fixture로 확인한 항목:

- 공개/dev 호스트 각 16개, og:title, 홈의 SEO 포지셔닝과 기존 본문 성과 수치 3개.
- 기준 커밋 `38c1327`의 옛 시더로 만든 53행을 새 시더로 갱신. 시간을 2분 진행시킨 뒤 다시 실행해 전체 테이블과 타임스탬프까지 동일함을 확인.
- 옛 칼럼 50행의 모든 원시 필드 보존, WP 기사의 문장·대표 이미지·본문 이미지·링크의 모든 속성 보존, 메타 외 필드와 기존 하위 그룹·카테고리·목록 2페이지 동작.

### 테스트 무력화 실험

격리본 backlinks의 seo_title 하나를 `INTENTIONAL WRONG SEO TITLE`로 바꾸고 공개 메타 16개 검사를 실행했어. 정본 title 비교 줄에서 실제 실패했어. 원본 저장소의 제품 파일은 바꾸지 않았어.

```text
$ php artisan test --filter=test_public_metadata_matches_the_authoritative_json

   FAIL  Tests\Feature\SeoMetaRestorationTest
  ✓ public metadata matches the authoritative json with data set "/"     0.39s  
  ✓ public metadata matches the authoritative json with data set "/abou… 0.10s  
  ✓ public metadata matches the authoritative json with data set "/cont… 0.11s  
  ✓ public metadata matches the authoritative json with data set "/blog… 0.10s  
  ✓ public metadata matches the authoritative json with data set "/blog… 0.12s  
  ✓ public metadata matches the authoritative json with data set "/blog… 0.15s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.11s  
  ⨯ public metadata matches the authoritative json with data set "/seo-… 0.14s  
  ✓ public metadata matches the authoritative json with data set "/word… 0.12s  
  ✓ public metadata matches the authoritative json with data set "/nave… 0.12s  
  ✓ public metadata matches the authoritative json with data set "/nave… 0.13s  
  ✓ public metadata matches the authoritative json with data set "/kaka… 0.11s  
  ✓ public metadata matches the authoritative json with data set "/coup… 0.15s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.09s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.08s  
  ✓ public metadata matches the authoritative json with data set "/seo/… 0.12s  
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\SeoMetaRestorationTest > public metadata matches th…   
  Failed asserting that two strings are identical.
  -'고품질 백링크 서비스 | 구글・네이버 순위상승 전문 | 제이커브'
  +'INTENTIONAL WRONG SEO TITLE'
  

  at tests/Feature/SeoMetaRestorationTest.php:45
     41▕     public function test_public_metadata_matches_the_authoritative_json(string $path, string $title, string $description): void
     42▕     {
     43▕         $html = $this->html($this->get(self::PUBLIC_URL.$path)->assertOk()->getContent());
     44▕         $this->assertSame(1, $html->query('//head/title')->length);
  ➜  45▕         $this->assertSame($title, $html->evaluate('string(//head/title)'));
     46▕         $this->assertSame(1, $html->query('//head/meta[@name="description"]')->length);
     47▕         $expectedDescription = str_starts_with($path, '/seo/') && $path !== '/seo/'
     48▕             ? Str::limit(strip_tags($description), 155) : $description;
     49▕         $this->assertSame($expectedDescription, $html->evaluate('string(//head/meta[@name="description"]/@content)'));

  1   tests/Feature/SeoMetaRestorationTest.php:45


  Tests:    1 failed, 15 passed (109 assertions)
  Duration: 2.48s


EXIT_CODE=1
ELAPSED_SECONDS=3.057
```

`config/subpages.php` SHA256:

```text
before   731ba65f99813c81861981f2c58dd991ef1d77d9cf816b1e2efd3af2e0ebf4cd
mutated  d7817ce489a83a34c94ce30f1bb2521625be666dfde45b4955117a684224edde
restored 731ba65f99813c81861981f2c58dd991ef1d77d9cf816b1e2efd3af2e0ebf4cd
restored_exactly=true
```

원복 후 신규 32/381 및 최종 전체 158/19,636이 다시 통과했어. 세부 증거: [mutation-sha.json](/private/tmp/seo-meta-02-independent-20261103-125706/mutation-sha.json).

### 기존 테스트 변경과 최초 실패 설명

**기존 테스트 파일 변경은 없어.** 새 `SeoMetaRestorationTest.php`만 추가했어.

최초 실행은 11 failed / 147 passed였어. 신규 10건은 라우트가 정상적인 상대 Location(`/sitemap.xml`·`/rss`)을 반환하는데 테스트가 절대 URI만 기대해서 실패했어. 신규 테스트에서 공개 origin으로 해석한 후 정확한 도착지를 비교하고, 그 주소를 직접 요청해 200·추가 Location 없음까지 검사하도록 고쳤어.

나머지 기존 검사 1건은 검증 환경이 APP_URL을 https 공개 주소로 둔 탓에 기존 localhost URL 생성 단언과 충돌한 것이었어. APP_URL은 기존 테스트 조건인 http://localhost로 맞추고, 공개 SEO 설정과 실제 요청 Host는 계속 https://j-curve.co.kr로 유지했어. 기존 기대값을 완화하거나 제품 코드를 바꾸지 않고 전체 그린을 확인했어.

`git diff --check`도 출력 없이 exit 0이었어. 추적 파일의 diff stat은 아래와 같고, 신규 테스트와 이 반환물은 미추적 파일이라 이 숫자에 포함되지 않아.

```text
 config/subpages.php                      | 15 ++++++++----
 database/seeders/LegacyContentSeeder.php | 42 ++++++++++++++++++++++++++++++--
 public/robots.txt                        |  1 +
 routes/web.php                           |  7 ++++++
 4 files changed, 58 insertions(+), 7 deletions(-)
```

## 범위·보존 확인

- 시작 HEAD: `38c13270627c0d62a40ac6c1e176fbee97f698f2`. 시작 때 Claude의 Blade 변경 9개와 지시서·정본 JSON이 미커밋 상태였어.
- 세션 중 HEAD가 `8ee6e949bbd6896acbffc91a732934a6ce74464c`로 이동했고, 로그에는 `checkpoint: 2026-11-03 12:54:03`으로 표시됐어. 이 구현·검증 세션은 git 읽기 명령만 사용했어.
- `resources/**`, `public/media/**`, `database/content/legacy/**`, `WorkSeeder.php`, 정본 JSON, 지시서 총 **223개**의 경로별 SHA256을 정렬해 합친 해시는 시작·구현 후 모두 `8d2656f5106724c562e5b063b1bbe45b0f8d1427b4d9905985169b940ad66fa9`였어. 기존 프론트 수정도 바이트 그대로 보존됐어.
- 실제 `.env`·운영 DB·기존 로컬 DB를 열거나 수정하지 않았어. 포트 8000 서버도 조작하지 않았어.
- 커밋·푸시·배포·운영 발행은 실행하지 않았어.
- 마지막 상태 확인에서 추가로 나타난 미추적 `docs/content/wp-legacy/`는 이 세션의 산출물이 아니야. Claude 구역이므로 열거나 수정하지 않고 그대로 뒀어. 이 보고서의 변경 목록에는 포함하지 않았어.

## 미검증·후속 범위

- 운영 서버에 새 시더를 실행하지 않았어. 운영 DB에 남은 3편은 승인된 배포·시더 재실행 뒤 변경돼. 현재 로컬 구현과 운영 반영은 구분해야 해.
- Q-019의 이미지 로컬 이관·URL 치환·SVG srcset 복구는 이번 범위 밖이야. 기사 이미지와 링크 속성을 그대로 보존했으므로 기존 WP 외부 이미지 의존성은 남아 있어. 이번에 처리한 것은 Q-013의 화면 잔재와 Q-019②의 중복 h1 정리야.
- 실서버 전환·검색엔진 재수집·검색순위 변화·PHP 8.3/MySQL 환경은 검증하지 않았어. PHP 8.5.8·SQLite 메모리에서 확인한 결과야. 웹서버가 직접 제공하는 robots.txt 실제 HTTP 응답과 원격 기사 이미지 로딩도 별도 미검증이야.
- 대시보드 `AnarchyContentTeam/anc_main/06_사이트/data/tasks.json` 및 렌더 스크립트는 현재 허용된 쓰기 경로 밖이어서 갱신·실행하지 않았어.
- 공동 요청 큐의 타 작업 문구는 수정하지 않았어. 최종 제품 검수는 Claude·대웅이 담당해.
