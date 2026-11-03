# INTL-01 구현 반환물

- 작업: INTL-01 / 2026-11-03
- 위치: `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`
- 브랜치: `wip/2026-11-03-i18n` / 기준·현재 HEAD: `0662117`
- 설계·지시: Claude. 이번 구현·로컬 실행 증거 반환: Codex. **별도 세션 독립 검증과 최종 합격 판정은 미실시.**
- 지시서·INTL-PLAN·COLLAB·QUEUE와 지정된 URL 보존 코드를 읽고 구현했다.
- 커밋·푸시·브랜치 변경·배포·발행·실DB 마이그레이션을 실행하지 않았다. 원래 저장소를 작업 경로로 사용하거나 그 코드를 직접 열거나 수정하지 않았다. worktree에서 허용된 Git 읽기·archive와 기존 의존성 링크만 사용했다.

## 1. 결과

- 전체 **199/199 테스트, 21,198 assertions**, INTL 전용 **16/16 테스트, 1,003 assertions** 통과.
- 이번 소유 변경·신규 PHP **31파일** Pint 통과. 프론트 빌드 exit 0.
- **한국어 사이트맵 94항목의 순서·URL·lastmod 동일.** 그 주소 전부와 원주소 16개, 별도 소개 5페이지를 포함한 중복 제거 **99페이지 전부 200, 정규화 후 HTML·응답 상태 차이 0**.
- 두 무력화 실험에서 각각 301·404 테스트가 실제로 실패했다. 원복 전후 `git diff | shasum` 동일, 원복 후 해당 2테스트 통과.
- 외국어 정적 대상은 **26개 이름 중 정적 24개 이름을 펼친 43주소 × 2언어**. 카테고리·글은 번역 공개 여부로 추가한다.
- 현재 실제 외국어 화면은 지시된 최소 홈 1템플릿(EN/JA 각각 200)뿐이다. 나머지 페이지는 외국어 뷰가 없어서 404가 정상이다. 사이트맵에는 지시대로 해당 주소 기반을 먼저 추가했다.
- 예시 글 **1편 × EN/JA 2번역**만 제공했다. `[EN DRAFT]` / `[JA DRAFT]` 표시된 파이프라인 확인용 자료다.

## 2. 확정한 라우트

아래는 작업 폴더의 실제 라우트와 `config/subpages.php`로 확인한 목록이다. 정적 KO 주소 P에 EN은 `/en`+P, JA는 `/ja`+P를 붙인다. 홈은 `/en/`, `/ja/`. 이름은 `en.<아래 이름>`, `ja.<아래 이름>`이다.

| 한국어 라우트 이름 | 주소 수 | 한국어 정식 주소·제약 |
|---|---:|---|
| home | 1 | `/` |
| company | 1 | `/about-us/` |
| contact | 1 | `/contact-us/` |
| privacy | 1 | `/privacy` |
| support.faq | 1 | `/support/faq` (실재 확인) |
| services.index | 1 | `/services` |
| services.show | 5 | `/services/{performance-marketing,cpa-marketing,reward-network}`, `/seo/`, `/wordpress-agency/` |
| services.seo.aeo | 1 | `/services/seo/aeo` |
| services.seo.geo | 1 | `/services/seo/geo` |
| services.seo.sub | 5 | `/seo-backlinks/`, `/naver-place-marketing/`, `/naver-shopping-marketing/`, `/kakao-gift/`, `/coupang/` |
| services.cpa.sub | 5 | `/services/cpa-marketing/{real-estate,stock,insurance,coin,permission-call}` |
| services.performance.sub | 3 | `/services/performance-marketing/{naver-gfa,facebook,youtube}` (google-ads 없음) |
| services.marketing-support | 1 | `/services/marketing-support` |
| solutions.index | 1 | `/solutions` |
| solutions.rankfree | 1 | `/solutions/rankfree` |
| solutions.boostingshop | 1 | `/solutions/boostingshop` |
| solutions.shopitrend | 1 | `/solutions/shopitrend` |
| solutions.leadbay | 1 | `/solutions/leadbay` |
| solutions.call2sale | 1 | `/solutions/call2sale` |
| solutions.boostingshop.sub | 6 | `/solutions/boostingshop/{basic,pro,elite,instagram-popular,instagram-followers,instagram-likes}` |
| self-marketing | 1 | `/self-marketing` |
| self-marketing.place | 1 | `/self-marketing/place` |
| work.index | 1 | `/work` |
| insights.index | 1 | `/blog/` |
| insights.category | 동적 | `/blog/{seo,link-building}/` 및 `/insights/category/{slug}` — 해당 언어의 번역된 공개 글이 있는 카테고리만 |
| insights.show | 동적 | KO 기존 주소 유지. EN/JA는 `/{locale}/insights/{translation.slug}` |

문의 접수 이름은 별도로 `en.contact.store` / `ja.contact.store`, 메서드·주소는 `POST /en/contact-us/` / `POST /ja/contact-us/`이다. 기존 한국어 POST는 그대로다.

- 한국어의 새 경로·정식 경로 끝 슬래시 변형은 외국어에서도 301 1홉, 쿼리 원문·중복 키·percent escape 보존.
- `/en/company` → `/en/about-us/`, `/ja/services/seo/backlinks` → `/ja/seo-backlinks/`.
- 기존 PHP·v1·shop·company/anarchy 별칭도 도착지가 외국어 대상이면 바로 그 언어의 정식 주소로 이동한다. 기존 글 별칭은 해당 언어 번역이 있을 때만 번역 slug로 이동한다.
- 숨김·미래 발행·미번역 글과 외국어 제외 구역은 404. 한국어 글 slug를 외국어 본문으로 대신 렌더하지 않는다.
- 커뮤니티·인증·계정·주문·무료 SEO 진단·문의게시판·사례 상세 외국어 라우트는 만들지 않았다.
- `routes/pages.php`의 대상 정적 4페이지는 같은 PageController를 쓰도록 연결했다. 기존 한국어 뷰·데이터·HTML은 그대로이며 99페이지 비교에 해당 4페이지도 포함했다.
- 정식 별칭은 이름을 추가하지 않고 `intl_name` 액션 메타데이터로 원래 이름을 연결한다. 그룹 접두만 붙은 중복 라우트 이름이 생기지 않으며 라우트 컬렉션 compile 테스트도 통과했다.

## 3. 단계 2가 사용할 계약

### 설정·도우미

- `config('intl.default')` = `ko`.
- `config('intl.locales.<ko|en|ja>')` = `prefix, html_lang, og_locale, label, short`.
- `config('intl.routes')` = 위 26개 한국어 라우트 이름.
- `intl_locale(): string` — 요청 주소 첫 구간이 en/ja면 그 언어, 나머지는 ko. 폼의 locale을 읽지 않는다.
- `intl_route($name, $params = [], $locale = null): string` — locale 생략 시 현재 언어, 한국어면 기존 route(), 외국어면 이름 접두 추가. 요청 호스트 기준 Laravel 절대 URL이며 공개 SEO 호스트를 강제하는 함수는 아니다.
- `intl_alternates(): array` — 현재 페이지의 `['ko' => 절대URL, 'en' => ..., 'ja' => ...]`. `SEO_PUBLIC_URL` 기준, 쿼리 제외, 원주소 보존. 대상 밖이면 빈 배열. 글은 실제 번역이 있는 언어만, 숨김·미공개 글은 빈 배열. 카테고리도 해당 언어 번역된 공개 글이 있을 때만 추가한다. 한국어의 이름 없는 정식 주소도 지원한다. `x-default`는 뷰에서 `ko` 값을 써서 출력한다.
- `intl_view($name, $data = []): Illuminate\View\View` — ko는 기존 view(), en/ja는 `intl.$name`. 외국어 템플릿 없으면 404. 한국어 폴백 없음.
- 일반 페이지의 alternates는 등록된 대상 라우트 계약을 기준으로 한다. 이번 단계의 홈 이외 템플릿은 아직 404지만, 다음 단계 템플릿을 만들면 같은 라우트에서 바로 사용된다.
- helper는 AppServiceProvider에서 require_once한다. composer.json·composer.lock 변경 불필요.

사용 예:

```php
intl_route('company');                            // 현재 언어 /about-us/
intl_route('services.seo.sub', ['sub' => 'backlinks']);
intl_route('insights.category', ['slug' => 'seo']);
intl_route('insights.show', ['slug' => $translation->slug], 'en');
intl_route('insights.show', ['insight' => $insight->slug], 'ko');
intl_route('contact.store');                      // 현재 언어 POST 주소
```

글 상세의 매개변수는 **KO: insight, EN/JA: slug**다. 외국어 slug는 소문자 ASCII 영숫자와 하이픈을 사용한다. 일본어 글도 영문 slug를 사용한다.

### 뷰·데이터

- 홈: `intl.pages.home`, 기존 `$works`와 `$insights`. 외국어 insights는 최신 번역된 공개 글 최대 3개, 각 `translation`·`category` 관계 로드.
- 목록: `intl.insights.index`, `$insights` = 12개 paginator, `$categories` = 해당 언어 번역 공개 글이 있는 카테고리. 각 글 `category, user, translation` 로드. paginator 경로도 현재 언어 정식 주소.
- 카테고리: `intl.insights.category`, 위 변수 + `$category`.
- 상세: `intl.insights.show`, **원본 `$insight` + 현재 언어 `$translation` 둘 다 전달**.
- 서브페이지: `intl.pages.subpage`, 기존 `$parent`·`$page` 데이터 계약 유지. 외국어 문구는 다음 단계에서 언어 파일을 사용해야 한다.
- 그 밖에는 `intl.<기존 뷰 이름>` 계약 그대로다. 기존 한국어 레이아웃은 최소 외국어 홈에서 재사용하지 않았다.
- `Insight::translations(): HasMany`, `Insight::translation(?string $locale = null): HasOne`. locale 생략은 현재 요청 언어.
- `InsightTranslation`: insight 관계, translated_at datetime cast. 두 유일키와 insight 삭제 cascade.
- 문의 GET의 UTM 세션·POST 검증·honeypot·throttle 계약 유지. 성공 status 플래시는 기존 `inquiry-received`. 외국어 HTML 검증 실패는 다른 referer에서도 자신의 contact-us로 복귀한다. KO locale 저장은 null.
- `lang/{en,ja}/intl.php`: `inquiry_received`, `contact`. 완료 화면에서 이 문자열을 사용하면 된다. validation은 Laravel 기본 키 전체와 문의 6개 attributes. 한국어의 영어 폴백 표시를 바꾸지 않도록 EN attributes는 기존 기본 필드 표시와 동일하게 두었다.

### 번역 원문·시더

- JSON: `database/content/intl/insights/*.json`. `ko_slug, source_hash, en, ja` 계약은 지시서와 동일.
- `source_hash`는 **DB 원시값이 아니라 `$insight->content` 표시본 SHA256**. 현재 한글 표시본과 다르면 `php artisan intl:stale`에 나온다.
- 시더는 기존 행 갱신·재실행 멱등, 실제 값이 바뀔 때만 translated_at 갱신. 누락된 ko_slug는 경고 후 건너뛴다.
- DatabaseSeeder 마지막에 IntlInsightSeeder 호출. WorkSeeder 호출 없음.
- RSS 코드·한국어 항목은 그대로다. 사이트맵은 한국어 기존 항목 뒤에 외국어를 추가하며 원문의 noindex·다른 canonical과 외국어 자체 metadata도 반영한다.

## 4. 실행 환경·실제 명령과 출력

출력은 실행 당시 원문이며, 빌드의 ANSI 화면 제어 문자만 제거했다. 모든 명령은 지정한 작업 폴더에서 실행했다.

```sh
php --version | head -1
node --version
git branch --show-current
git rev-parse --short HEAD
git diff --name-only -- resources/views public/media database/seeders/WorkSeeder.php .env
git diff | shasum
```

실제 출력 (exit 0):

```text
PHP 8.5.8 (cli) (built: Jul  1 2026 03:46:27) (NTS)
v20.20.2
wip/2026-11-03-i18n
0662117
88f3a633815239c22914fa7505f1cd92b5bf36ce  -
```


위 보호 경로 `git diff --name-only`는 출력이 없었다. `.env`는 읽기만 했고 값을 저장하지 않았다. 아래 신규 홈 외 기존 한국어 Blade 파일은 수정하지 않았다.

```sh
php artisan test
```

실제 출력 (exit 0):

```text
{"tool":"phpunit","result":"passed","tests":199,"passed":199,"assertions":21198,"duration_ms":24699}
```

```sh
php artisan test --filter=IntlFoundationTest
```

실제 출력 (exit 0):

```text
{"tool":"phpunit","result":"passed","tests":16,"passed":16,"assertions":1003,"duration_ms":7515}
```

```sh
vendor/bin/pint --test app/Http/Controllers/ContactController.php app/Http/Controllers/InsightController.php app/Http/Controllers/PageController.php app/Http/Controllers/WorkController.php app/Http/Middleware/PreservePublicUrls.php app/Http/Middleware/SetIntlLocale.php app/Models/Insight.php app/Models/InsightTranslation.php app/Providers/AppServiceProvider.php app/Services/Seo/Publishing/FeedCatalog.php app/Services/Seo/Publishing/PreservedPaths.php app/Console/Commands/IntlStale.php app/Support config/intl.php database/migrations/2026_11_03_000001_create_insight_translations_table.php database/migrations/2026_11_03_000002_add_locale_to_leads_table.php database/seeders/DatabaseSeeder.php database/seeders/IntlInsightSeeder.php routes/pages.php routes/web.php routes/intl.php tests/Feature/IntlFoundationTest.php tests/Support lang/en/validation.php lang/ja/validation.php lang/en/intl.php lang/ja/intl.php lang/en/pages/home.php lang/ja/pages/home.php
```

실제 출력 (exit 0):

```text
{"tool":"pint","result":"passed"}
```

```sh
npm run build -- --configLoader runner
```

실제 출력 (exit 0):

```text
> build
> vite build --configLoader runner

vite v8.2.0 building client environment for production...
transforming...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
✓ 12 modules transformed.
rendering chunks...
computing gzip size...
public/build/manifest.json                        0.88 kB │ gzip:  0.25 kB
public/build/assets/legacy-reskin-3fymEzpK.css   13.71 kB │ gzip:  2.99 kB
public/build/assets/jc-BVRsJh4m.css              91.47 kB │ gzip: 17.75 kB
public/build/assets/app-BW-Dp7Pe.css             97.52 kB │ gzip: 18.40 kB
public/build/assets/jc-DIWfGL1E.js               25.80 kB │ gzip:  9.23 kB
public/build/assets/app-XOhwnyVw.js             159.36 kB │ gzip: 60.50 kB

✓ built in 1.64s
```


`runner`는 동일 npm build 스크립트에 전달한 Vite 설정 로더 옵션이다. 기존 node_modules 링크 쪽에 기본 bundle 로더의 .vite-temp를 쓰지 않도록 사용했다. 기존 `/media/bg/hero-glow.webp` 미해결 경고는 남아 있으며 미디어 파일은 수정하지 않았다. 빌드 산출물에는 동시에 진행된 별도 프론트 CSS 변경도 들어 있으므로, 이것을 전부 INTL-01 프론트 산출물로 간주하지 않는다.

```sh
python3 tests/Support/intl_compare.py
```

실제 출력 (exit 0):

```text
baseline: php /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Support/intl_snapshot.php /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/intl-01-kwq3zlc0/base /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/intl-01-kwq3zlc0/baseline.json
Snapshot: 99 Korean pages; preserved paths: 16
Korean sitemap entries: 94
HTTP statuses: {"200":99}
implementation: php /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Support/intl_snapshot.php /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/intl-01-kwq3zlc0/implementation.json
Snapshot: 99 Korean pages; preserved paths: 16
Korean sitemap entries: 94
HTTP statuses: {"200":99}
Korean sitemap entries identical (including order/lastmod): True
Korean rendered pages: 99
HTML/status differences: 0
Normalization: CSRF meta/input; encrypted valid_from input; 5-character random sbg/sgl/sdot SVG IDs. Vite assets shared, no hash normalization.
Temporary archive, SQLite databases, snapshots: removed on exit.
```


한국어 비교 재현 방법:

1. `git archive 0662117`을 메모리로 받아 임시 폴더에 푼다. git worktree add·checkout·원래 저장소 작업 없음.
2. vendor·node_modules·public/build와 작업 폴더의 로컬 .env를 읽기 전용 용도로 링크한다. 각자 독립 SQLite 파일을 사용한다.
3. 같은 환경·한국어 시더와 고정 시각 `2026-11-03 00:00:00`으로 렌더한다. 공통 테스트 키·APP_LOCALE=ko·APP_FALLBACK_LOCALE=en·SEO_PUBLIC_URL=https://j-curve.co.kr·array 세션/캐시 등 실제 환경 목록은 첨부 diff의 intl_compare.py에 있다.
4. autoload의 App/Database classmap과 PSR-4를 각 checkout으로 다시 지정하여 기준 코드가 현재 구현을 잘못 읽지 않게 한다.
5. 한국어 sitemap 94항목의 URL·순서·lastmod와 원주소 16개를 비교한다. sitemap 밖 privacy·FAQ·Shopitrend·self-marketing·place까지 더해 중복 제거 99페이지를 HTTP 커널로 렌더한다.
6. 아래 정규화만 적용한 HTML 바이트·HTTP 상태를 비교한다. UTF-8 손실이 없도록 HTML·키를 base64로 보관한 뒤 원문 바이트를 비교한다.
7. finally/TemporaryDirectory로 기준 코드·SQLite·스냅샷 폴더를 모두 제거한다.

정규화 규칙은 다음 4개뿐이다.

```text
(<meta name="csrf-token" content=")[^"]*(")           → $1[CSRF]$2
(<input\b[^>]*\bname="_token"[^>]*\bvalue=")[^"]*(") → $1[CSRF]$2
(<input\b[^>]*\bname="valid_from"[^>]*\bvalue=")[^"]*(") (s) → $1[HONEYPOT]$2
\b(sbg|sgl|sdot)-[a-zA-Z0-9]{5}\b                    → $1-[SVG-ID]
```

마지막 규칙은 기존 `partials/scene.blade.php`의 `Str::random(5)`로 생성되는 SVG 정의·참조 ID만 치환한다. 본문·태그·공백·제목·설명·canonical·hreflang은 정규화하지 않았다. 양쪽이 같은 public/build를 사용하므로 Vite 해시는 치환하지 않았다. 이 PHP 환경의 parse_url은 한글 UTF-8 중간 바이트를 underscore로 바꾸므로 비교 도구에서는 알려진 HTTP origin만 정규식으로 제거하여 실제 URL 바이트를 보존했다.

```sh
git diff --check
git diff --name-only -- resources/views public/media database/seeders/WorkSeeder.php .env
```

실제 출력 (exit 0):

```text
(출력 없음)
```


## 5. 무력화 실험과 원복

### ① 접두 인식 끄기

`PreservedPaths::destination()`의 외국어 분기를 잠깐 `if (false && preg_match(...))`로 바꿨다.

```sh
php artisan test --compact --filter=test_all_foreign_aliases_redirect_once_preserving_raw_queries
```

실제 출력 (exit 1):

```text
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":1,"duration_ms":1201,"failed":1,"failures":[{"test":"Tests\\Feature\\IntlFoundationTest::test_all_foreign_aliases_redirect_once_preserving_raw_queries","file":"/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Feature/IntlFoundationTest.php","line":101,"message":"Expected response status code [301] but received 200.\nFailed asserting that 200 is identical to 301."}]}
```


분기 원복 후:

```sh
git diff | shasum
```

실제 출력 (exit 0):

```text
88f3a633815239c22914fa7505f1cd92b5bf36ce  -
```


### ② 번역 없는 글 404 필터 끄기

`InsightController::translatedShow()`에서 locale+slug의 whereHas 조건 한 줄만 잠깐 제거했다. 테스트는 외국어 상세 뷰를 임시로 제공하므로, 뷰 없음 404에 기대어 통과할 수 없다.

```sh
php artisan test --compact --filter=test_untranslated_and_hidden_insights_are_404_even_when_foreign_view_exists
```

실제 출력 (exit 1):

```text
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":1,"duration_ms":864,"failed":1,"failures":[{"test":"Tests\\Feature\\IntlFoundationTest::test_untranslated_and_hidden_insights_are_404_even_when_foreign_view_exists","file":"/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Feature/IntlFoundationTest.php","line":209,"message":"Expected response status code [404] but received 200.\nFailed asserting that 200 is identical to 404."}]}
```


필터 원복 후:

```sh
git diff | shasum
```

실제 출력 (exit 0):

```text
88f3a633815239c22914fa7505f1cd92b5bf36ce  -
```


두 실험 전 해시도 `88f3a633815239c22914fa7505f1cd92b5bf36ce  -`로 동일했다. 무력화 코드는 남기지 않았다. 원복 직후 두 관련 테스트 재실행:

```sh
php artisan test --compact --filter='test_all_foreign_aliases_redirect_once_preserving_raw_queries|test_untranslated_and_hidden_insights_are_404_even_when_foreign_view_exists'
```

실제 출력 (exit 0):

```text
{"tool":"phpunit","result":"passed","tests":2,"passed":2,"assertions":535,"duration_ms":1725}
```


이후 테스트 보강·라우트 캐시 중복 이름 방지까지 반영한 최종 전체 실행은 위 199/199이다. Git diff 해시는 추적 파일 기준이므로, 신규 파일은 아래 전체 diff에 /dev/null 비교로 별도 포함했다.

## 6. 이번 변경 파일

소스·테스트 **34파일 + 이 결과 문서**. 기존 추적 파일 12개, 신규 구현·테스트 파일 22개다.

- `app/Console/Commands/IntlStale.php`
- `app/Http/Controllers/ContactController.php`
- `app/Http/Controllers/InsightController.php`
- `app/Http/Controllers/PageController.php`
- `app/Http/Controllers/WorkController.php`
- `app/Http/Middleware/PreservePublicUrls.php`
- `app/Http/Middleware/SetIntlLocale.php`
- `app/Models/Insight.php`
- `app/Models/InsightTranslation.php`
- `app/Providers/AppServiceProvider.php`
- `app/Services/Seo/Publishing/FeedCatalog.php`
- `app/Services/Seo/Publishing/PreservedPaths.php`
- `app/Support/IntlLegacyRedirects.php`
- `app/Support/IntlRoutes.php`
- `app/Support/intl.php`
- `config/intl.php`
- `database/migrations/2026_11_03_000001_create_insight_translations_table.php`
- `database/migrations/2026_11_03_000002_add_locale_to_leads_table.php`
- `database/seeders/DatabaseSeeder.php`
- `database/seeders/IntlInsightSeeder.php`
- `database/content/intl/insights/mobile-marketing-strategies.json`
- `lang/en/validation.php`
- `lang/ja/validation.php`
- `lang/en/intl.php`
- `lang/ja/intl.php`
- `lang/en/pages/home.php`
- `lang/ja/pages/home.php`
- `resources/views/intl/pages/home.blade.php`
- `routes/pages.php`
- `routes/web.php`
- `routes/intl.php`
- `tests/Feature/IntlFoundationTest.php`
- `tests/Support/intl_snapshot.php`
- `tests/Support/intl_compare.py`
- `docs/intl/INTL-01-IMPL-RESULT.md` (이 문서)

변경 책임은 컨트롤러·주소 보존/별칭·사이트맵·언어 미들웨어/도우미·번역 모델/마이그레이션/시더/명령·허용된 최소 홈·테스트에 한정한다. 기존 PreservedUrlGenerator/PublicUrl은 PreservedPaths를 이미 사용하므로 파일 자체를 바꾸지 않고 접두 동작을 확장했다. 한국어 소스 데이터·성과 수치·WorkSeeder는 바꾸지 않았다.

작업 도중 다른 작업의 `resources/css/jc.css`, `resources/views/layouts/intl.blade.php`, `resources/views/partials/intl/**`가 추가·변경된 것을 확인했다. 직접 수정·삭제·원복하지 않았으며 아래 INTL-01 소유 diff에도 포함하지 않았다. 기존 docs/intl 설계 문서 3개도 수정하지 않았다.

## 7. 미검증·후속

- **미검증:** 별도 Codex 검증 세션의 독립 공격 검증, Claude 최종 판정.
- **미검증:** 운영 PHP 8.3/MySQL에서의 마이그레이션·롤백·성능. 이번 실행은 PHP 8.5.8 + SQLite다.
- **미검증:** 실서버·실도메인·실브라우저·실메일/문의 운영 처리. 서버는 열지 않았고 8000·8014를 사용하지 않았다.
- **미구현(다음 단계 범위):** 완성 외국어 레이아웃·페이지, 한국어 head hreflang·언어 전환, 블로그 전체 번역. 현재 홈 외 외국어 뷰는 없어서 404다. 테스트의 임시 뷰로 같은 라우트가 뷰 생성 후 200이 되는 것만 확인했다.
- **미검증:** hero-glow.webp의 실제 서버 응답. 빌드 경고는 위 원문에 남겼다.
- **미실행:** 외부 대시보드 tasks.json 갱신·대시보드.py. 이 세션의 쓰기 허용 범위가 지정 worktree·임시 폴더뿐이어서 외부 업무 파일을 수정하지 않았다.
- 커밋·푸시·배포·원래 저장소 반영은 하지 않았다.

## 8. 전체 소유 diff

검토 편의를 위해 소유 34파일의 실제 diff를 붙인다. 추적 파일은 `git diff -- <path>`, 신규 파일은 `git diff --no-index -- /dev/null <path>` 출력이다. 기존 다른 작업 변경·이 결과 문서 자체는 포함하지 않았다.

<details>
<summary>INTL-01 구현·테스트 전체 diff</summary>

```diff
diff --git a/app/Console/Commands/IntlStale.php b/app/Console/Commands/IntlStale.php
new file mode 100644
index 0000000..c5419de
--- /dev/null
+++ b/app/Console/Commands/IntlStale.php
@@ -0,0 +1,28 @@
+<?php
+
+namespace App\Console\Commands;
+
+use App\Models\InsightTranslation;
+use Illuminate\Console\Command;
+
+class IntlStale extends Command
+{
+    protected $signature = 'intl:stale';
+
+    protected $description = 'List translations whose Korean display content has changed';
+
+    public function handle(): int
+    {
+        $rows = [];
+        foreach (InsightTranslation::query()->with('insight')->orderBy('insight_id')->orderBy('locale')->cursor() as $translation) {
+            $current = hash('sha256', (string) $translation->insight->content);
+            if (! hash_equals($translation->source_hash, $current)) {
+                $rows[] = [$translation->insight->slug, $translation->locale, $translation->slug, $translation->source_hash, $current];
+            }
+        }
+        $this->table(['ko_slug', 'locale', 'translation_slug', 'source_hash', 'current_hash'], $rows);
+        $this->info('Stale translations: '.count($rows));
+
+        return self::SUCCESS;
+    }
+}
diff --git a/app/Http/Controllers/ContactController.php b/app/Http/Controllers/ContactController.php
index 2c41996..e9fd9a1 100644
--- a/app/Http/Controllers/ContactController.php
+++ b/app/Http/Controllers/ContactController.php
@@ -6,6 +6,7 @@
 use Illuminate\Http\RedirectResponse;
 use Illuminate\Http\Request;
 use Illuminate\Validation\Rule;
+use Illuminate\Validation\ValidationException;
 use Illuminate\View\View;
 
 class ContactController extends Controller
@@ -48,19 +49,26 @@ public function show(Request $request): View
             $request->session()->put(self::UTM_SESSION_KEY, array_replace($storedUtm, $utm));
         }
 
-        return view('contact');
+        return intl_view('contact');
     }
 
     public function store(Request $request): RedirectResponse
     {
-        $validated = $request->validate([
-            'name' => ['required', 'string', 'max:255'],
-            'company' => ['nullable', 'string', 'max:255'],
-            'email' => ['required', 'email', 'max:255'],
-            'phone' => ['nullable', 'string', 'max:50'],
-            'service_interest' => ['required', Rule::in(self::SERVICE_INTERESTS)],
-            'message' => ['required', 'string', 'max:2000'],
-        ]);
+        try {
+            $validated = $request->validate([
+                'name' => ['required', 'string', 'max:255'],
+                'company' => ['nullable', 'string', 'max:255'],
+                'email' => ['required', 'email', 'max:255'],
+                'phone' => ['nullable', 'string', 'max:50'],
+                'service_interest' => ['required', Rule::in(self::SERVICE_INTERESTS)],
+                'message' => ['required', 'string', 'max:2000'],
+            ]);
+        } catch (ValidationException $exception) {
+            if (intl_locale() !== 'ko') {
+                $exception->redirectTo(intl_route('contact'));
+            }
+            throw $exception;
+        }
 
         $storedUtm = $request->session()->get(self::UTM_SESSION_KEY, []);
         $storedUtm = is_array($storedUtm) ? $storedUtm : [];
@@ -75,12 +83,13 @@ public function store(Request $request): RedirectResponse
         $lead->message = $validated['message'];
         $lead->utm = $utm === [] ? null : $utm;
         $lead->status = 'new';
+        $lead->locale = intl_locale() === 'ko' ? null : intl_locale();
         $lead->save();
 
         $request->session()->forget(self::UTM_SESSION_KEY);
 
         return redirect()
-            ->route('contact')
+            ->to(intl_route('contact'))
             ->with('status', 'inquiry-received');
     }
 
diff --git a/app/Http/Controllers/InsightController.php b/app/Http/Controllers/InsightController.php
index 4dde31c..aad51da 100644
--- a/app/Http/Controllers/InsightController.php
+++ b/app/Http/Controllers/InsightController.php
@@ -5,12 +5,23 @@
 use App\Models\Insight;
 use App\Models\InsightCategory;
 use Illuminate\Http\RedirectResponse;
+use Illuminate\Support\Collection;
 use Illuminate\View\View;
 
 class InsightController extends Controller
 {
     public function index(): View
     {
+        if (intl_locale() !== 'ko') {
+            $insights = Insight::query()->published()
+                ->whereHas('translations', fn ($query) => $query->where('locale', intl_locale()))
+                ->with(['category', 'user', 'translation'])->latest('published_at')->latest('id')
+                ->paginate(12)->withPath(intl_route('insights.index'));
+            $categories = $this->translatedCategories();
+
+            return intl_view('insights.index', compact('insights', 'categories'));
+        }
+
         $insights = Insight::query()
             ->with(['category', 'user'])
             ->published()
@@ -26,6 +37,18 @@ public function index(): View
 
     public function category(string $slug): View
     {
+        if (intl_locale() !== 'ko') {
+            $categories = $this->translatedCategories();
+            $category = $categories->firstWhere('slug', $slug);
+            abort_unless($category, 404);
+            $insights = $category->insights()->published()
+                ->whereHas('translations', fn ($query) => $query->where('locale', intl_locale()))
+                ->with(['category', 'user', 'translation'])->latest('published_at')->latest('id')
+                ->paginate(12)->withPath(intl_route('insights.category', ['slug' => $slug]));
+
+            return intl_view('insights.category', compact('category', 'insights', 'categories'));
+        }
+
         $category = InsightCategory::query()
             ->where('slug', $slug)
             ->firstOrFail();
@@ -56,4 +79,23 @@ public function show(Insight $insight): View|RedirectResponse
 
         return view('insights.show', compact('insight'));
     }
+
+    public function translatedShow(string $slug): View
+    {
+        $insight = Insight::query()->published()
+            ->whereHas('translations', fn ($query) => $query->where('locale', intl_locale())->where('slug', $slug))
+            ->with(['category', 'user', 'translation'])->firstOrFail();
+        $translation = $insight->translation;
+        request()->attributes->set('intl.insight', $insight);
+
+        return intl_view('insights.show', compact('insight', 'translation'));
+    }
+
+    private function translatedCategories(): Collection
+    {
+        return InsightCategory::query()
+            ->whereHas('insights', fn ($query) => $query->published()
+                ->whereHas('translations', fn ($query) => $query->where('locale', intl_locale())))
+            ->orderBy('name')->get();
+    }
 }
diff --git a/app/Http/Controllers/PageController.php b/app/Http/Controllers/PageController.php
index b4544e5..3df7c46 100644
--- a/app/Http/Controllers/PageController.php
+++ b/app/Http/Controllers/PageController.php
@@ -30,67 +30,71 @@ public function home(): View
             ->get();
 
         // S10a 인사이트 프리뷰: 최신 3건. 없으면 뷰에서 섹션 숨김.
-        $insights = Insight::query()
-            ->with('category')
+        $query = Insight::query()->with('category');
+        if (intl_locale() !== 'ko') {
+            $query->whereHas('translations', fn ($query) => $query->where('locale', intl_locale()))
+                ->with('translation');
+        }
+        $insights = $query
             ->published()
             ->latest('published_at')
             ->latest('id')
             ->take(3)
             ->get();
 
-        return view('pages.home', compact('works', 'insights'));
+        return intl_view('pages.home', compact('works', 'insights'));
     }
 
     public function services(): View
     {
-        return view('services.index');
+        return intl_view('services.index');
     }
 
     public function service(string $slug): View
     {
         abort_unless(isset(self::SERVICE_VIEWS[$slug]), 404);
 
-        return view(self::SERVICE_VIEWS[$slug]);
+        return intl_view(self::SERVICE_VIEWS[$slug]);
     }
 
     public function seoAeo(): View
     {
-        return view('services.seo.aeo');
+        return intl_view('services.seo.aeo');
     }
 
     public function seoGeo(): View
     {
-        return view('services.seo.geo');
+        return intl_view('services.seo.geo');
     }
 
     public function solutions(): View
     {
-        return view('solutions.index');
+        return intl_view('solutions.index');
     }
 
     public function rankfree(): View
     {
-        return view('solutions.rankfree');
+        return intl_view('solutions.rankfree');
     }
 
     public function leadbay(): View
     {
-        return view('solutions.leadbay');
+        return intl_view('solutions.leadbay');
     }
 
     public function call2sale(): View
     {
-        return view('solutions.call2sale');
+        return intl_view('solutions.call2sale');
     }
 
     public function boostingshop(): View
     {
-        return view('solutions.boostingshop');
+        return intl_view('solutions.boostingshop');
     }
 
     public function company(): View
     {
-        return view('pages.company');
+        return intl_view('pages.company');
     }
 
     // ── 레거시 301 도착지 서브페이지 (config/subpages.php 데이터 주도) ──
@@ -117,12 +121,32 @@ public function boostingshopSub(string $sub): View
 
     public function marketingSupport(): View
     {
-        return view('pages.marketing-support');
+        return intl_view('pages.marketing-support');
     }
 
     public function privacy(): View
     {
-        return view('pages.privacy');
+        return intl_view('pages.privacy');
+    }
+
+    public function selfMarketing(): View
+    {
+        return intl_view('pages.self-marketing');
+    }
+
+    public function selfMarketingPlace(): View
+    {
+        return intl_view('pages.self-marketing-place');
+    }
+
+    public function shopitrend(): View
+    {
+        return intl_view('solutions.shopitrend');
+    }
+
+    public function faq(): View
+    {
+        return intl_view('pages.faq');
     }
 
     /**
@@ -134,7 +158,7 @@ private function subpage(string $group, string $sub): View
         $items = config("subpages.{$group}.items", []);
         abort_unless(isset($items[$sub]), 404);
 
-        return view('pages.subpage', [
+        return intl_view('pages.subpage', [
             'parent' => config("subpages.{$group}.parent"),
             'page' => $items[$sub],
         ]);
diff --git a/app/Http/Controllers/WorkController.php b/app/Http/Controllers/WorkController.php
index c26d30d..9b2cd91 100644
--- a/app/Http/Controllers/WorkController.php
+++ b/app/Http/Controllers/WorkController.php
@@ -15,7 +15,7 @@ public function index(): View
             ->latest('id')
             ->paginate(12);
 
-        return view('work.index', compact('works'));
+        return intl_view('work.index', compact('works'));
     }
 
     public function show(Work $work): View
diff --git a/app/Http/Middleware/PreservePublicUrls.php b/app/Http/Middleware/PreservePublicUrls.php
index a2bf772..53cbf47 100644
--- a/app/Http/Middleware/PreservePublicUrls.php
+++ b/app/Http/Middleware/PreservePublicUrls.php
@@ -4,6 +4,7 @@
 
 use App\Services\Seo\Publishing\PreservedPaths;
 use App\Services\Seo\Publishing\PublicUrl;
+use App\Support\IntlLegacyRedirects;
 use Closure;
 use Illuminate\Http\Request;
 use Symfony\Component\HttpFoundation\Response;
@@ -15,6 +16,9 @@ public function handle(Request $request, Closure $next): Response
         if (in_array($request->method(), ['GET', 'HEAD'], true)) {
             $path = $request->getPathInfo();
             $destination = PreservedPaths::destination($path);
+            if ($destination === null && preg_match('~^/(en|ja)/~', $path)) {
+                $destination = IntlLegacyRedirects::destination($request);
+            }
 
             if ($destination !== null && PublicUrl::comparisonKey($path) !== $destination) {
                 $query = $request->server->get('QUERY_STRING', '');
diff --git a/app/Http/Middleware/SetIntlLocale.php b/app/Http/Middleware/SetIntlLocale.php
new file mode 100644
index 0000000..90bd52a
--- /dev/null
+++ b/app/Http/Middleware/SetIntlLocale.php
@@ -0,0 +1,21 @@
+<?php
+
+namespace App\Http\Middleware;
+
+use Closure;
+use Illuminate\Http\Request;
+use Symfony\Component\HttpFoundation\Response;
+
+class SetIntlLocale
+{
+    public function handle(Request $request, Closure $next): Response
+    {
+        $previous = app()->getLocale();
+        app()->setLocale(intl_locale());
+        try {
+            return $next($request);
+        } finally {
+            app()->setLocale($previous);
+        }
+    }
+}
diff --git a/app/Models/Insight.php b/app/Models/Insight.php
index 1719411..27cb696 100644
--- a/app/Models/Insight.php
+++ b/app/Models/Insight.php
@@ -6,6 +6,8 @@
 use Illuminate\Database\Eloquent\Casts\Attribute;
 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Relations\BelongsTo;
+use Illuminate\Database\Eloquent\Relations\HasMany;
+use Illuminate\Database\Eloquent\Relations\HasOne;
 use Illuminate\Database\Eloquent\Relations\MorphMany;
 
 class Insight extends Model
@@ -72,6 +74,16 @@ public function user(): BelongsTo
         return $this->belongsTo(User::class);
     }
 
+    public function translations(): HasMany
+    {
+        return $this->hasMany(InsightTranslation::class);
+    }
+
+    public function translation(?string $locale = null): HasOne
+    {
+        return $this->hasOne(InsightTranslation::class)->where('locale', $locale ?? intl_locale());
+    }
+
     public function category(): BelongsTo
     {
         return $this->belongsTo(InsightCategory::class, 'category_id');
diff --git a/app/Models/InsightTranslation.php b/app/Models/InsightTranslation.php
new file mode 100644
index 0000000..90785ae
--- /dev/null
+++ b/app/Models/InsightTranslation.php
@@ -0,0 +1,24 @@
+<?php
+
+namespace App\Models;
+
+use Illuminate\Database\Eloquent\Model;
+use Illuminate\Database\Eloquent\Relations\BelongsTo;
+
+class InsightTranslation extends Model
+{
+    protected $fillable = [
+        'insight_id', 'locale', 'slug', 'title', 'excerpt', 'content',
+        'meta_title', 'meta_description', 'source_hash', 'translated_at',
+    ];
+
+    protected function casts(): array
+    {
+        return ['translated_at' => 'datetime'];
+    }
+
+    public function insight(): BelongsTo
+    {
+        return $this->belongsTo(Insight::class);
+    }
+}
diff --git a/app/Providers/AppServiceProvider.php b/app/Providers/AppServiceProvider.php
index cc38128..c9a1fd0 100644
--- a/app/Providers/AppServiceProvider.php
+++ b/app/Providers/AppServiceProvider.php
@@ -23,6 +23,8 @@ class AppServiceProvider extends ServiceProvider
      */
     public function register(): void
     {
+        require_once app_path('Support/intl.php');
+
         // Keep Laravel's URL session/key/route extenders and request rebinding.
         $this->app->singleton('url', function ($app) {
             $routes = $app['router']->getRoutes();
diff --git a/app/Services/Seo/Publishing/FeedCatalog.php b/app/Services/Seo/Publishing/FeedCatalog.php
index b200e50..611ab91 100644
--- a/app/Services/Seo/Publishing/FeedCatalog.php
+++ b/app/Services/Seo/Publishing/FeedCatalog.php
@@ -4,8 +4,10 @@
 
 use App\Models\Insight;
 use App\Models\InsightCategory;
+use App\Models\InsightTranslation;
 use App\Models\SeoMeta;
 use App\Models\Work;
+use App\Support\IntlRoutes;
 use Illuminate\Support\Collection;
 
 class FeedCatalog
@@ -63,6 +65,31 @@ public function sections(): array
             }
         }
 
+        // Append only: Korean entries keep their original bytes and order.
+        foreach (['en', 'ja'] as $locale) {
+            foreach (IntlRoutes::variants() as $variant) {
+                $path = route($locale.'.'.$variant['name'], $variant['parameters'], false);
+                if ($this->indexable($variant['path'], $meta) && $this->indexable($path, $meta)) {
+                    $section = str_starts_with($variant['name'], 'services.') || str_starts_with($variant['name'], 'solutions.') ? 'services' : 'pages';
+                    $sections[$section][] = ['url' => $this->urls->absolute($path), 'modified' => null];
+                }
+            }
+            foreach (InsightCategory::query()->whereHas('insights', fn ($query) => $query->published()
+                ->whereHas('translations', fn ($query) => $query->where('locale', $locale)))->get() as $category) {
+                $path = route($locale.'.insights.category', ['slug' => $category->slug], false);
+                if ($this->indexable($path, $meta)) {
+                    $sections['pages'][] = ['url' => $this->urls->absolute($path), 'modified' => null];
+                }
+            }
+            foreach (InsightTranslation::query()->where('locale', $locale)
+                ->whereHas('insight', fn ($query) => $query->published())->with('insight')->orderBy('insight_id')->cursor() as $translation) {
+                $path = route($locale.'.insights.show', ['slug' => $translation->slug], false);
+                if ($this->indexable($this->insightPath($translation->insight), $meta) && $this->indexable($path, $meta)) {
+                    $sections['insights'][] = ['url' => $this->urls->absolute($path), 'modified' => $translation->translated_at];
+                }
+            }
+        }
+
         return $sections;
     }
 
diff --git a/app/Services/Seo/Publishing/PreservedPaths.php b/app/Services/Seo/Publishing/PreservedPaths.php
index d7264e4..c17a4cb 100644
--- a/app/Services/Seo/Publishing/PreservedPaths.php
+++ b/app/Services/Seo/Publishing/PreservedPaths.php
@@ -2,10 +2,39 @@
 
 namespace App\Services\Seo\Publishing;
 
+use App\Support\IntlRoutes;
+
 class PreservedPaths
 {
     public static function destination(string $path): ?string
     {
+        if (preg_match('~^/(en|ja)(/.*)?$~', $path, $matches)) {
+            $prefix = '/'.$matches[1];
+            $local = $matches[2] ?? '/';
+            $key = PublicUrl::comparisonKey(rtrim($local, '/'));
+            foreach (IntlRoutes::variants() as $variant) {
+                $modern = $variant['path'];
+                $canonical = self::destination($modern) ?? $modern;
+                if ($key === rtrim($modern, '/') || $key === rtrim($canonical, '/')) {
+                    return $prefix.$canonical;
+                }
+            }
+            // Categories share Korean preserved addresses; articles use translation slugs only.
+            if (preg_match('~^/insights/category/[^/]+$~', $key)) {
+                return $prefix.(self::destination($local) ?? rtrim($local, '/'));
+            }
+            foreach (['seo', 'link-building'] as $slug) {
+                if ($key === '/blog/'.$slug) {
+                    return $prefix.'/blog/'.$slug.'/';
+                }
+            }
+            if (preg_match('~^/insights/[a-z0-9]+(?:-[a-z0-9]+)*$~', $key)) {
+                return $prefix.$key;
+            }
+
+            return null;
+        }
+
         $key = PublicUrl::comparisonKey(rtrim($path, '/'));
 
         foreach (config('seo.preserved_map', []) as $modern => $preserved) {
diff --git a/app/Support/IntlLegacyRedirects.php b/app/Support/IntlLegacyRedirects.php
new file mode 100644
index 0000000..c4ec772
--- /dev/null
+++ b/app/Support/IntlLegacyRedirects.php
@@ -0,0 +1,60 @@
+<?php
+
+namespace App\Support;
+
+use App\Models\Insight;
+use App\Models\LegacyRedirect;
+use App\Services\Seo\Publishing\PreservedPaths;
+use Illuminate\Http\Request;
+
+class IntlLegacyRedirects
+{
+    public static function destination(Request $request): ?string
+    {
+        if (! preg_match('~^/(en|ja)(/.*)$~', $request->getPathInfo(), $matches)) {
+            return null;
+        }
+        [, $locale, $local] = $matches;
+        $parameters = array_change_key_case($request->query(), CASE_LOWER);
+        $columnId = $parameters['wr_id'] ?? null;
+        if (str_contains(mb_strtolower($local), 'board.php')
+            && is_string($parameters['bo_table'] ?? null) && mb_strtolower($parameters['bo_table']) === 'column'
+            && is_scalar($columnId) && ctype_digit((string) $columnId)) {
+            $insight = Insight::query()->published()->where('legacy_wr_id', $columnId)->first();
+            $translation = $insight?->translation($locale)->first();
+
+            return $translation ? '/'.$locale.'/insights/'.$translation->slug : null;
+        }
+        if (preg_match('~^/v1/manager/column/([^/]+)/?$~u', rawurldecode($local), $column)) {
+            $insight = Insight::query()->published()->where('slug', $column[1])->first();
+            $translation = $insight?->translation($locale)->first();
+
+            return $translation ? '/'.$locale.'/insights/'.$translation->slug : null;
+        }
+        $target = PreservedPaths::destination($local) ?? $local;
+        if ($local === '/company/anarchy' || $local === '/company/anarchy/') {
+            $target = '/about-us/';
+        } else {
+            $copy = Request::create($local, 'GET', $request->query());
+            $legacy = LegacyRedirect::resolveFor($copy);
+            if ($legacy !== null) {
+                if ($legacy->status_code !== 301) {
+                    return null;
+                }
+                $target = PreservedPaths::path($legacy->to_path);
+            }
+        }
+        // A Korean article alias is useful only when this exact language has a public translation.
+        if (preg_match('~^/(?:insights|seo)/([^/]+)/?$~u', rawurldecode($target), $article)) {
+            $insight = Insight::query()->published()->where('slug', $article[1])->first();
+            $translation = $insight?->translation($locale)->first();
+
+            return $translation ? '/'.$locale.'/insights/'.$translation->slug : null;
+        }
+        if ($target !== $local && ($canonical = PreservedPaths::destination('/'.$locale.$target)) !== null) {
+            return $canonical;
+        }
+
+        return null;
+    }
+}
diff --git a/app/Support/IntlRoutes.php b/app/Support/IntlRoutes.php
new file mode 100644
index 0000000..44c250d
--- /dev/null
+++ b/app/Support/IntlRoutes.php
@@ -0,0 +1,37 @@
+<?php
+
+namespace App\Support;
+
+use Illuminate\Support\Facades\Route;
+
+class IntlRoutes
+{
+    /** Static pages, expanded using the same parameter allowlists as the controllers. */
+    public static function variants(): array
+    {
+        $variants = [];
+        foreach (config('intl.routes', []) as $name) {
+            if (! Route::has($name) || in_array($name, ['insights.category', 'insights.show'], true)) {
+                continue;
+            }
+            $parameters = [[]];
+            if ($name === 'services.show') {
+                $parameters = array_map(fn ($slug) => ['slug' => $slug], config('intl.services'));
+            }
+            // Config keys containing dots must be read as array keys, not dot paths.
+            if (isset(config('intl.subpages')[$name])) {
+                $group = config('intl.subpages')[$name];
+                $parameters = array_map(fn ($sub) => ['sub' => $sub], array_keys(config("subpages.{$group}.items", [])));
+            }
+            foreach ($parameters as $params) {
+                $path = '/'.ltrim(Route::getRoutes()->getByName($name)->uri(), '/');
+                foreach ($params as $key => $value) {
+                    $path = str_replace('{'.$key.'}', rawurlencode($value), $path);
+                }
+                $variants[] = ['name' => $name, 'parameters' => $params, 'path' => $path];
+            }
+        }
+
+        return $variants;
+    }
+}
diff --git a/app/Support/intl.php b/app/Support/intl.php
new file mode 100644
index 0000000..33c074f
--- /dev/null
+++ b/app/Support/intl.php
@@ -0,0 +1,93 @@
+<?php
+
+use App\Models\Insight;
+use App\Models\InsightCategory;
+use App\Services\Seo\Publishing\PreservedPaths;
+use App\Services\Seo\Publishing\PublicUrl;
+use Illuminate\Http\Request;
+use Illuminate\Support\Facades\Route;
+use Illuminate\Support\Facades\View;
+
+function intl_locale(): string
+{
+    $prefix = request()->segment(1);
+
+    return isset(config('intl.locales', [])[$prefix]) && $prefix !== 'ko' ? $prefix : config('intl.default', 'ko');
+}
+
+function intl_route($name, $params = [], $locale = null): string
+{
+    $locale ??= intl_locale();
+    abort_unless(isset(config('intl.locales')[$locale]), 404);
+    $name = preg_replace('/^(?:en|ja)\./', '', $name);
+
+    return route($locale === 'ko' ? $name : $locale.'.'.$name, $params);
+}
+
+function intl_view($name, $data = []): Illuminate\View\View
+{
+    if (intl_locale() !== 'ko') {
+        $name = 'intl.'.$name;
+        abort_unless(View::exists($name), 404);
+    }
+
+    return view($name, $data);
+}
+
+function intl_alternates(): array
+{
+    $route = request()->route();
+    $name = preg_replace('/^(?:en|ja)\./', '', $route?->getAction('intl_name') ?? $route?->getName() ?? '');
+    $params = $route?->parameters() ?? [];
+    // Korean preserved routes intentionally stay unnamed. Resolve their named
+    // counterpart without changing any Korean route, response, or URL contract.
+    if ($name === '' && intl_locale() === 'ko') {
+        foreach (config('seo.preserved_map', []) as $modern => $preserved) {
+            if (PublicUrl::comparisonKey(request()->getPathInfo()) === $preserved) {
+                $counterpart = Route::getRoutes()->match(Request::create(PreservedPaths::encode($modern)));
+                $name = $counterpart->getName() ?? '';
+                $params = $counterpart->parameters();
+                break;
+            }
+        }
+    }
+    if (! in_array($name, config('intl.routes', []), true)) {
+        return [];
+    }
+    $insight = null;
+    if ($name === 'insights.show') {
+        $insight = request()->attributes->get('intl.insight');
+        if (! $insight) {
+            $value = $params['insight'] ?? null;
+            $insight = $value instanceof Insight ? $value : Insight::query()->where('slug', $value)->first();
+        }
+        if (! $insight || ! Insight::query()->published()->whereKey($insight->id)->exists()) {
+            return [];
+        }
+        $insight->loadMissing('translations');
+    }
+    $urls = [];
+    foreach (array_keys(config('intl.locales')) as $locale) {
+        $localized = $params;
+        if ($insight) {
+            $translation = $insight->translations->firstWhere('locale', $locale);
+            if ($locale !== 'ko' && ! $translation) {
+                continue;
+            }
+            $localized = $locale === 'ko' ? ['insight' => $insight->slug] : ['slug' => $translation->slug];
+        } elseif ($name === 'insights.category' && $locale !== 'ko') {
+            $exists = InsightCategory::query()->where('slug', $params['slug'] ?? '')
+                ->whereHas('insights', fn ($query) => $query->published()->whereHas('translations', fn ($query) => $query->where('locale', $locale)))
+                ->exists();
+            if (! $exists) {
+                continue;
+            }
+        }
+        $localizedName = $locale === 'ko' ? $name : $locale.'.'.$name;
+        if (Route::has($localizedName)) {
+            $urls[$locale] = app(PublicUrl::class)->absolute(route($localizedName, $localized, false));
+        }
+    }
+
+    return $urls;
+}
diff --git a/config/intl.php b/config/intl.php
new file mode 100644
index 0000000..75be6d4
--- /dev/null
+++ b/config/intl.php
@@ -0,0 +1,26 @@
+<?php
+
+return [
+    'default' => 'ko',
+    'locales' => [
+        'ko' => ['prefix' => '', 'html_lang' => 'ko', 'og_locale' => 'ko_KR', 'label' => '한국어', 'short' => 'KO'],
+        'en' => ['prefix' => 'en', 'html_lang' => 'en', 'og_locale' => 'en_US', 'label' => 'English', 'short' => 'EN'],
+        'ja' => ['prefix' => 'ja', 'html_lang' => 'ja', 'og_locale' => 'ja_JP', 'label' => '日本語', 'short' => 'JA'],
+    ],
+    'routes' => [
+        'home', 'company', 'contact', 'privacy', 'support.faq',
+        'services.index', 'services.show', 'services.seo.aeo', 'services.seo.geo',
+        'services.seo.sub', 'services.cpa.sub', 'services.performance.sub', 'services.marketing-support',
+        'solutions.index', 'solutions.rankfree', 'solutions.boostingshop', 'solutions.shopitrend',
+        'solutions.leadbay', 'solutions.call2sale', 'solutions.boostingshop.sub',
+        'self-marketing', 'self-marketing.place', 'work.index',
+        'insights.index', 'insights.category', 'insights.show',
+    ],
+    'services' => ['performance-marketing', 'cpa-marketing', 'reward-network', 'seo', 'wordpress'],
+    'subpages' => [
+        'services.seo.sub' => 'seo',
+        'services.cpa.sub' => 'cpa',
+        'services.performance.sub' => 'performance',
+        'solutions.boostingshop.sub' => 'boostingshop',
+    ],
+];
diff --git a/database/migrations/2026_11_03_000001_create_insight_translations_table.php b/database/migrations/2026_11_03_000001_create_insight_translations_table.php
new file mode 100644
index 0000000..7bafef6
--- /dev/null
+++ b/database/migrations/2026_11_03_000001_create_insight_translations_table.php
@@ -0,0 +1,33 @@
+<?php
+
+use Illuminate\Database\Migrations\Migration;
+use Illuminate\Database\Schema\Blueprint;
+use Illuminate\Support\Facades\Schema;
+
+return new class extends Migration
+{
+    public function up(): void
+    {
+        Schema::create('insight_translations', function (Blueprint $table) {
+            $table->id();
+            $table->foreignId('insight_id')->constrained()->cascadeOnDelete();
+            $table->string('locale', 5);
+            $table->string('slug');
+            $table->string('title');
+            $table->text('excerpt')->nullable();
+            $table->longText('content');
+            $table->string('meta_title')->nullable();
+            $table->text('meta_description')->nullable();
+            $table->char('source_hash', 64);
+            $table->timestamp('translated_at')->nullable();
+            $table->timestamps();
+            $table->unique(['insight_id', 'locale']);
+            $table->unique(['locale', 'slug']);
+        });
+    }
+
+    public function down(): void
+    {
+        Schema::dropIfExists('insight_translations');
+    }
+};
diff --git a/database/migrations/2026_11_03_000002_add_locale_to_leads_table.php b/database/migrations/2026_11_03_000002_add_locale_to_leads_table.php
new file mode 100644
index 0000000..4941507
--- /dev/null
+++ b/database/migrations/2026_11_03_000002_add_locale_to_leads_table.php
@@ -0,0 +1,18 @@
+<?php
+
+use Illuminate\Database\Migrations\Migration;
+use Illuminate\Database\Schema\Blueprint;
+use Illuminate\Support\Facades\Schema;
+
+return new class extends Migration
+{
+    public function up(): void
+    {
+        Schema::table('leads', fn (Blueprint $table) => $table->string('locale', 5)->nullable());
+    }
+
+    public function down(): void
+    {
+        Schema::table('leads', fn (Blueprint $table) => $table->dropColumn('locale'));
+    }
+};
diff --git a/database/seeders/DatabaseSeeder.php b/database/seeders/DatabaseSeeder.php
index 38324d1..b12a50d 100644
--- a/database/seeders/DatabaseSeeder.php
+++ b/database/seeders/DatabaseSeeder.php
@@ -19,6 +19,7 @@ public function run(): void
             InsightCategorySeeder::class,
             LegacyRedirectSeeder::class,
             LegacyContentSeeder::class,
+            IntlInsightSeeder::class,
         ]);
     }
 }
diff --git a/database/seeders/IntlInsightSeeder.php b/database/seeders/IntlInsightSeeder.php
new file mode 100644
index 0000000..088c00f
--- /dev/null
+++ b/database/seeders/IntlInsightSeeder.php
@@ -0,0 +1,50 @@
+<?php
+
+namespace Database\Seeders;
+
+use App\Models\Insight;
+use Illuminate\Database\Seeder;
+use UnexpectedValueException;
+
+class IntlInsightSeeder extends Seeder
+{
+    public function run(): void
+    {
+        $files = glob(database_path('content/intl/insights/*.json')) ?: [];
+        sort($files);
+        foreach ($files as $file) {
+            $data = json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
+            $insight = Insight::query()->where('slug', $data['ko_slug'] ?? '')->first();
+            if (! $insight) {
+                $this->command?->warn('INTL skipped missing ko_slug: '.($data['ko_slug'] ?? basename($file)));
+
+                continue;
+            }
+            if (! preg_match('/^[a-f0-9]{64}$/', $data['source_hash'] ?? '')) {
+                throw new UnexpectedValueException('Invalid source_hash: '.basename($file));
+            }
+            foreach (['en', 'ja'] as $locale) {
+                if (! isset($data[$locale])) {
+                    continue;
+                }
+                $payload = $data[$locale];
+                foreach (['slug', 'title', 'content'] as $field) {
+                    if (! is_string($payload[$field] ?? null) || trim($payload[$field]) === '') {
+                        throw new UnexpectedValueException("Invalid {$locale}.{$field}: ".basename($file));
+                    }
+                }
+                if (! preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $payload['slug'])) {
+                    throw new UnexpectedValueException('Translation slug must use lowercase ASCII words and hyphens.');
+                }
+                $values = array_intersect_key($payload, array_flip(['slug', 'title', 'excerpt', 'content', 'meta_title', 'meta_description']));
+                $values['source_hash'] = $data['source_hash'];
+                $translation = $insight->translations()->firstOrNew(['locale' => $locale]);
+                $translation->fill($values);
+                if (! $translation->exists || $translation->isDirty()) {
+                    $translation->translated_at = now();
+                    $translation->save();
+                }
+            }
+        }
+    }
+}
diff --git a/database/content/intl/insights/mobile-marketing-strategies.json b/database/content/intl/insights/mobile-marketing-strategies.json
new file mode 100644
index 0000000..33221e1
--- /dev/null
+++ b/database/content/intl/insights/mobile-marketing-strategies.json
@@ -0,0 +1,20 @@
+{
+    "ko_slug": "반드시-알아야-할-모바일-마케팅-전략-5가지",
+    "source_hash": "e825527449071ab6acda3c943ee09fffdc5017a1ea11722725398a08d0e2d598",
+    "en": {
+        "slug": "mobile-marketing-strategies",
+        "title": "[EN DRAFT] Five mobile marketing strategies",
+        "excerpt": "[EN DRAFT] Translation pipeline sample awaiting editorial review.",
+        "content": "<p>[EN DRAFT] Translation pipeline sample awaiting editorial review.</p>",
+        "meta_title": "[EN DRAFT] Mobile marketing | J-Curve",
+        "meta_description": "[EN DRAFT] Translation pipeline sample awaiting editorial review."
+    },
+    "ja": {
+        "slug": "mobile-marketing-strategies-ja",
+        "title": "[JA DRAFT] モバイルマーケティングの5つの戦略",
+        "excerpt": "[JA DRAFT] 翻訳処理の確認用サンプルです。編集確認前です。",
+        "content": "<p>[JA DRAFT] 翻訳処理の確認用サンプルです。編集確認前です。</p>",
+        "meta_title": "[JA DRAFT] モバイルマーケティング | J-Curve",
+        "meta_description": "[JA DRAFT] 翻訳処理の確認用サンプルです。編集確認前です。"
+    }
+}
diff --git a/lang/en/validation.php b/lang/en/validation.php
new file mode 100644
index 0000000..656755d
--- /dev/null
+++ b/lang/en/validation.php
@@ -0,0 +1,200 @@
+<?php
+
+return [
+
+    /*
+    |--------------------------------------------------------------------------
+    | Validation Language Lines
+    |--------------------------------------------------------------------------
+    |
+    | The following language lines contain the default error messages used by
+    | the validator class. Some of these rules have multiple versions such
+    | as the size rules. Feel free to tweak each of these messages here.
+    |
+    */
+
+    'accepted' => 'The :attribute field must be accepted.',
+    'accepted_if' => 'The :attribute field must be accepted when :other is :value.',
+    'active_url' => 'The :attribute field must be a valid URL.',
+    'after' => 'The :attribute field must be a date after :date.',
+    'after_or_equal' => 'The :attribute field must be a date after or equal to :date.',
+    'alpha' => 'The :attribute field must only contain letters.',
+    'alpha_dash' => 'The :attribute field must only contain letters, numbers, dashes, and underscores.',
+    'alpha_num' => 'The :attribute field must only contain letters and numbers.',
+    'any_of' => 'The :attribute field is invalid.',
+    'array' => 'The :attribute field must be an array.',
+    'ascii' => 'The :attribute field must only contain single-byte alphanumeric characters and symbols.',
+    'before' => 'The :attribute field must be a date before :date.',
+    'before_or_equal' => 'The :attribute field must be a date before or equal to :date.',
+    'between' => [
+        'array' => 'The :attribute field must have between :min and :max items.',
+        'file' => 'The :attribute field must be between :min and :max kilobytes.',
+        'numeric' => 'The :attribute field must be between :min and :max.',
+        'string' => 'The :attribute field must be between :min and :max characters.',
+    ],
+    'boolean' => 'The :attribute field must be true or false.',
+    'can' => 'The :attribute field contains an unauthorized value.',
+    'confirmed' => 'The :attribute field confirmation does not match.',
+    'contains' => 'The :attribute field is missing a required value.',
+    'current_password' => 'The password is incorrect.',
+    'date' => 'The :attribute field must be a valid date.',
+    'date_equals' => 'The :attribute field must be a date equal to :date.',
+    'date_format' => 'The :attribute field must match the format :format.',
+    'decimal' => 'The :attribute field must have :decimal decimal places.',
+    'declined' => 'The :attribute field must be declined.',
+    'declined_if' => 'The :attribute field must be declined when :other is :value.',
+    'different' => 'The :attribute field and :other must be different.',
+    'digits' => 'The :attribute field must be :digits digits.',
+    'digits_between' => 'The :attribute field must be between :min and :max digits.',
+    'dimensions' => 'The :attribute field has invalid image dimensions.',
+    'distinct' => 'The :attribute field has a duplicate value.',
+    'doesnt_contain' => 'The :attribute field must not contain any of the following: :values.',
+    'doesnt_end_with' => 'The :attribute field must not end with one of the following: :values.',
+    'doesnt_start_with' => 'The :attribute field must not start with one of the following: :values.',
+    'email' => 'The :attribute field must be a valid email address.',
+    'encoding' => 'The :attribute field must be encoded in :encoding.',
+    'ends_with' => 'The :attribute field must end with one of the following: :values.',
+    'enum' => 'The selected :attribute is invalid.',
+    'exists' => 'The selected :attribute is invalid.',
+    'extensions' => 'The :attribute field must have one of the following extensions: :values.',
+    'file' => 'The :attribute field must be a file.',
+    'filled' => 'The :attribute field must have a value.',
+    'gt' => [
+        'array' => 'The :attribute field must have more than :value items.',
+        'file' => 'The :attribute field must be greater than :value kilobytes.',
+        'numeric' => 'The :attribute field must be greater than :value.',
+        'string' => 'The :attribute field must be greater than :value characters.',
+    ],
+    'gte' => [
+        'array' => 'The :attribute field must have :value items or more.',
+        'file' => 'The :attribute field must be greater than or equal to :value kilobytes.',
+        'numeric' => 'The :attribute field must be greater than or equal to :value.',
+        'string' => 'The :attribute field must be greater than or equal to :value characters.',
+    ],
+    'hex_color' => 'The :attribute field must be a valid hexadecimal color.',
+    'image' => 'The :attribute field must be an image.',
+    'in' => 'The selected :attribute is invalid.',
+    'in_array' => 'The :attribute field must exist in :other.',
+    'in_array_keys' => 'The :attribute field must contain at least one of the following keys: :values.',
+    'integer' => 'The :attribute field must be an integer.',
+    'ip' => 'The :attribute field must be a valid IP address.',
+    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
+    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
+    'json' => 'The :attribute field must be a valid JSON string.',
+    'list' => 'The :attribute field must be a list.',
+    'lowercase' => 'The :attribute field must be lowercase.',
+    'lt' => [
+        'array' => 'The :attribute field must have less than :value items.',
+        'file' => 'The :attribute field must be less than :value kilobytes.',
+        'numeric' => 'The :attribute field must be less than :value.',
+        'string' => 'The :attribute field must be less than :value characters.',
+    ],
+    'lte' => [
+        'array' => 'The :attribute field must not have more than :value items.',
+        'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
+        'numeric' => 'The :attribute field must be less than or equal to :value.',
+        'string' => 'The :attribute field must be less than or equal to :value characters.',
+    ],
+    'mac_address' => 'The :attribute field must be a valid MAC address.',
+    'max' => [
+        'array' => 'The :attribute field must not have more than :max items.',
+        'file' => 'The :attribute field must not be greater than :max kilobytes.',
+        'numeric' => 'The :attribute field must not be greater than :max.',
+        'string' => 'The :attribute field must not be greater than :max characters.',
+    ],
+    'max_digits' => 'The :attribute field must not have more than :max digits.',
+    'mimes' => 'The :attribute field must be a file of type: :values.',
+    'mimetypes' => 'The :attribute field must be a file of type: :values.',
+    'min' => [
+        'array' => 'The :attribute field must have at least :min items.',
+        'file' => 'The :attribute field must be at least :min kilobytes.',
+        'numeric' => 'The :attribute field must be at least :min.',
+        'string' => 'The :attribute field must be at least :min characters.',
+    ],
+    'min_digits' => 'The :attribute field must have at least :min digits.',
+    'missing' => 'The :attribute field must be missing.',
+    'missing_if' => 'The :attribute field must be missing when :other is :value.',
+    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
+    'missing_with' => 'The :attribute field must be missing when :values is present.',
+    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
+    'multiple_of' => 'The :attribute field must be a multiple of :value.',
+    'not_in' => 'The selected :attribute is invalid.',
+    'not_regex' => 'The :attribute field format is invalid.',
+    'numeric' => 'The :attribute field must be a number.',
+    'password' => [
+        'letters' => 'The :attribute field must contain at least one letter.',
+        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
+        'numbers' => 'The :attribute field must contain at least one number.',
+        'symbols' => 'The :attribute field must contain at least one symbol.',
+        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
+    ],
+    'present' => 'The :attribute field must be present.',
+    'present_if' => 'The :attribute field must be present when :other is :value.',
+    'present_unless' => 'The :attribute field must be present unless :other is :value.',
+    'present_with' => 'The :attribute field must be present when :values is present.',
+    'present_with_all' => 'The :attribute field must be present when :values are present.',
+    'prohibited' => 'The :attribute field is prohibited.',
+    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
+    'prohibited_if_accepted' => 'The :attribute field is prohibited when :other is accepted.',
+    'prohibited_if_declined' => 'The :attribute field is prohibited when :other is declined.',
+    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
+    'prohibits' => 'The :attribute field prohibits :other from being present.',
+    'regex' => 'The :attribute field format is invalid.',
+    'required' => 'The :attribute field is required.',
+    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
+    'required_if' => 'The :attribute field is required when :other is :value.',
+    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
+    'required_if_declined' => 'The :attribute field is required when :other is declined.',
+    'required_unless' => 'The :attribute field is required unless :other is in :values.',
+    'required_with' => 'The :attribute field is required when :values is present.',
+    'required_with_all' => 'The :attribute field is required when :values are present.',
+    'required_without' => 'The :attribute field is required when :values is not present.',
+    'required_without_all' => 'The :attribute field is required when none of :values are present.',
+    'same' => 'The :attribute field must match :other.',
+    'size' => [
+        'array' => 'The :attribute field must contain :size items.',
+        'file' => 'The :attribute field must be :size kilobytes.',
+        'numeric' => 'The :attribute field must be :size.',
+        'string' => 'The :attribute field must be :size characters.',
+    ],
+    'starts_with' => 'The :attribute field must start with one of the following: :values.',
+    'string' => 'The :attribute field must be a string.',
+    'timezone' => 'The :attribute field must be a valid timezone.',
+    'unique' => 'The :attribute has already been taken.',
+    'uploaded' => 'The :attribute failed to upload.',
+    'uppercase' => 'The :attribute field must be uppercase.',
+    'url' => 'The :attribute field must be a valid URL.',
+    'ulid' => 'The :attribute field must be a valid ULID.',
+    'uuid' => 'The :attribute field must be a valid UUID.',
+
+    /*
+    |--------------------------------------------------------------------------
+    | Custom Validation Language Lines
+    |--------------------------------------------------------------------------
+    |
+    | Here you may specify custom validation messages for attributes using the
+    | convention "attribute.rule" to name the lines. This makes it quick to
+    | specify a specific custom language line for a given attribute rule.
+    |
+    */
+
+    'custom' => [
+        'attribute-name' => [
+            'rule-name' => 'custom-message',
+        ],
+    ],
+
+    /*
+    |--------------------------------------------------------------------------
+    | Custom Validation Attributes
+    |--------------------------------------------------------------------------
+    |
+    | The following language lines are used to swap our attribute placeholder
+    | with something more reader friendly such as "E-Mail Address" instead
+    | of "email". This simply helps us make our message more expressive.
+    |
+    */
+
+    'attributes' => ['name' => 'name', 'company' => 'company', 'email' => 'email', 'phone' => 'phone', 'service_interest' => 'service interest', 'message' => 'message'],
+
+];
diff --git a/lang/ja/validation.php b/lang/ja/validation.php
new file mode 100644
index 0000000..e942aea
--- /dev/null
+++ b/lang/ja/validation.php
@@ -0,0 +1,162 @@
+<?php
+
+return [
+    'accepted' => ':attributeに同意してください。',
+    'accepted_if' => ':otherが:valueの場合、:attributeに同意してください。',
+    'active_url' => ':attributeには有効なURLを入力してください。',
+    'after' => ':attributeには:dateより後の日付を入力してください。',
+    'after_or_equal' => ':attributeには:date以降の日付を入力してください。',
+    'alpha' => ':attributeには文字のみを入力してください。',
+    'alpha_dash' => ':attributeには文字、数字、ハイフン、アンダースコアのみを入力してください。',
+    'alpha_num' => ':attributeには文字と数字のみを入力してください。',
+    'any_of' => ':attributeの値が正しくありません。',
+    'array' => ':attributeは配列で指定してください。',
+    'ascii' => ':attributeには半角英数字と記号のみを入力してください。',
+    'before' => ':attributeには:dateより前の日付を入力してください。',
+    'before_or_equal' => ':attributeには:date以前の日付を入力してください。',
+    'between' => [
+        'array' => ':attributeの項目数は:min個から:max個にしてください。',
+        'file' => ':attributeのサイズは:min KBから:max KBにしてください。',
+        'numeric' => ':attributeは:minから:maxの間にしてください。',
+        'string' => ':attributeは:min文字から:max文字にしてください。',
+    ],
+    'boolean' => ':attributeにはtrueまたはfalseを指定してください。',
+    'can' => ':attributeの値は許可されていません。',
+    'confirmed' => ':attributeが確認用の値と一致しません。',
+    'contains' => ':attributeに必要な値が含まれていません。',
+    'current_password' => '現在のパスワードが正しくありません。',
+    'date' => ':attributeには有効な日付を入力してください。',
+    'date_equals' => ':attributeには:dateと同じ日付を入力してください。',
+    'date_format' => ':attributeは:format形式で入力してください。',
+    'decimal' => ':attributeの小数点以下の桁数は:decimal桁にしてください。',
+    'declined' => ':attributeへの同意を拒否してください。',
+    'declined_if' => ':otherが:valueの場合、:attributeへの同意を拒否してください。',
+    'different' => ':attributeと:otherには異なる値を入力してください。',
+    'digits' => ':attributeには:digits桁の数字を入力してください。',
+    'digits_between' => ':attributeには:min桁から:max桁の数字を入力してください。',
+    'dimensions' => ':attributeの画像サイズが正しくありません。',
+    'distinct' => ':attributeの値が重複しています。',
+    'doesnt_contain' => ':attributeに禁止された値が含まれています。',
+    'doesnt_end_with' => ':attributeの末尾に:valuesは使用できません。',
+    'doesnt_start_with' => ':attributeの先頭に:valuesは使用できません。',
+    'email' => ':attributeには有効なメールアドレスを入力してください。',
+    'encoding' => ':attributeは:encodingでエンコードしてください。',
+    'ends_with' => ':attributeの末尾は:valuesのいずれかにしてください。',
+    'enum' => '選択した:attributeは正しくありません。',
+    'exists' => '選択した:attributeは存在しません。',
+    'extensions' => ':attributeの拡張子は:valuesのいずれかにしてください。',
+    'file' => ':attributeにはファイルを指定してください。',
+    'filled' => ':attributeには値を入力してください。',
+    'gt' => [
+        'array' => ':attributeの項目数は:value個より多くしてください。',
+        'file' => ':attributeのサイズは:value KBより大きくしてください。',
+        'numeric' => ':attributeは:valueより大きくしてください。',
+        'string' => ':attributeは:value文字より長くしてください。',
+    ],
+    'gte' => [
+        'array' => ':attributeの項目数は:value個以上にしてください。',
+        'file' => ':attributeのサイズは:value KB以上にしてください。',
+        'numeric' => ':attributeは:value以上にしてください。',
+        'string' => ':attributeは:value文字以上にしてください。',
+    ],
+    'hex_color' => ':attributeには有効な16進数のカラーコードを入力してください。',
+    'image' => ':attributeには画像ファイルを指定してください。',
+    'in' => '選択した:attributeは正しくありません。',
+    'in_array' => ':attributeは:otherに含まれる値を指定してください。',
+    'in_array_keys' => ':attributeには:valuesのいずれかのキーを含めてください。',
+    'integer' => ':attributeには整数を入力してください。',
+    'ip' => ':attributeには有効なIPアドレスを入力してください。',
+    'ipv4' => ':attributeには有効なIPv4アドレスを入力してください。',
+    'ipv6' => ':attributeには有効なIPv6アドレスを入力してください。',
+    'json' => ':attributeには有効なJSON文字列を入力してください。',
+    'list' => ':attributeはリストで指定してください。',
+    'lowercase' => ':attributeには小文字を入力してください。',
+    'lt' => [
+        'array' => ':attributeの項目数は:value個より少なくしてください。',
+        'file' => ':attributeのサイズは:value KBより小さくしてください。',
+        'numeric' => ':attributeは:valueより小さくしてください。',
+        'string' => ':attributeは:value文字より短くしてください。',
+    ],
+    'lte' => [
+        'array' => ':attributeの項目数は:value個以下にしてください。',
+        'file' => ':attributeのサイズは:value KB以下にしてください。',
+        'numeric' => ':attributeは:value以下にしてください。',
+        'string' => ':attributeは:value文字以下にしてください。',
+    ],
+    'mac_address' => ':attributeには有効なMACアドレスを入力してください。',
+    'max' => [
+        'array' => ':attributeの項目数は:max個以下にしてください。',
+        'file' => ':attributeのサイズは:max KB以下にしてください。',
+        'numeric' => ':attributeは:max以下にしてください。',
+        'string' => ':attributeは:max文字以下にしてください。',
+    ],
+    'max_digits' => ':attributeには:max桁以下の数字を入力してください。',
+    'mimes' => ':attributeには:values形式のファイルを指定してください。',
+    'mimetypes' => ':attributeには:values形式のファイルを指定してください。',
+    'min' => [
+        'array' => ':attributeの項目数は:min個以上にしてください。',
+        'file' => ':attributeのサイズは:min KB以上にしてください。',
+        'numeric' => ':attributeは:min以上にしてください。',
+        'string' => ':attributeは:min文字以上にしてください。',
+    ],
+    'min_digits' => ':attributeには:min桁以上の数字を入力してください。',
+    'missing' => ':attributeは指定しないでください。',
+    'missing_if' => ':otherが:valueの場合、:attributeは指定しないでください。',
+    'missing_unless' => ':otherが:valueでない場合、:attributeは指定しないでください。',
+    'missing_with' => ':valuesを指定する場合、:attributeは指定しないでください。',
+    'missing_with_all' => ':valuesをすべて指定する場合、:attributeは指定しないでください。',
+    'multiple_of' => ':attributeには:valueの倍数を入力してください。',
+    'not_in' => '選択した:attributeは正しくありません。',
+    'not_regex' => ':attributeの形式が正しくありません。',
+    'numeric' => ':attributeには数値を入力してください。',
+    'password' => [
+        'letters' => ':attributeには文字を1文字以上含めてください。',
+        'mixed' => ':attributeには大文字と小文字をそれぞれ1文字以上含めてください。',
+        'numbers' => ':attributeには数字を1文字以上含めてください。',
+        'symbols' => ':attributeには記号を1文字以上含めてください。',
+        'uncompromised' => ':attributeは漏えいしたことがあります。別の値を入力してください。',
+    ],
+    'present' => ':attributeを指定してください。',
+    'present_if' => ':otherが:valueの場合、:attributeを指定してください。',
+    'present_unless' => ':otherが:valueでない場合、:attributeを指定してください。',
+    'present_with' => ':valuesを指定する場合、:attributeも指定してください。',
+    'present_with_all' => ':valuesをすべて指定する場合、:attributeも指定してください。',
+    'prohibited' => ':attributeは入力できません。',
+    'prohibited_if' => ':otherが:valueの場合、:attributeは入力できません。',
+    'prohibited_if_accepted' => ':otherに同意した場合、:attributeは入力できません。',
+    'prohibited_if_declined' => ':otherへの同意を拒否した場合、:attributeは入力できません。',
+    'prohibited_unless' => ':otherが:valuesでない場合、:attributeは入力できません。',
+    'prohibits' => ':attributeを入力する場合、:otherは入力できません。',
+    'regex' => ':attributeの形式が正しくありません。',
+    'required' => ':attributeは必須です。',
+    'required_array_keys' => ':attributeには:valuesのキーを含めてください。',
+    'required_if' => ':otherが:valueの場合、:attributeは必須です。',
+    'required_if_accepted' => ':otherに同意した場合、:attributeは必須です。',
+    'required_if_declined' => ':otherへの同意を拒否した場合、:attributeは必須です。',
+    'required_unless' => ':otherが:valuesでない場合、:attributeは必須です。',
+    'required_with' => ':valuesのいずれかを入力する場合、:attributeは必須です。',
+    'required_with_all' => ':valuesをすべて入力する場合、:attributeは必須です。',
+    'required_without' => ':valuesのいずれかが未入力の場合、:attributeは必須です。',
+    'required_without_all' => ':valuesがすべて未入力の場合、:attributeは必須です。',
+    'same' => ':attributeと:otherには同じ値を入力してください。',
+    'size' => [
+        'array' => ':attributeの項目数は:size個にしてください。',
+        'file' => ':attributeのサイズは:size KBにしてください。',
+        'numeric' => ':attributeは:sizeにしてください。',
+        'string' => ':attributeは:size文字にしてください。',
+    ],
+    'starts_with' => ':attributeの先頭は:valuesのいずれかにしてください。',
+    'string' => ':attributeには文字列を入力してください。',
+    'timezone' => ':attributeには有効なタイムゾーンを入力してください。',
+    'unique' => ':attributeは既に使用されています。',
+    'uploaded' => ':attributeのアップロードに失敗しました。',
+    'uppercase' => ':attributeには大文字を入力してください。',
+    'url' => ':attributeには有効なURLを入力してください。',
+    'ulid' => ':attributeには有効なULIDを入力してください。',
+    'uuid' => ':attributeには有効なUUIDを入力してください。',
+    'custom' => [],
+    'attributes' => [
+        'name' => 'お名前', 'company' => '会社名', 'email' => 'メールアドレス',
+        'phone' => '電話番号', 'service_interest' => 'ご希望のサービス', 'message' => 'お問い合わせ内容',
+    ],
+];
diff --git a/lang/en/intl.php b/lang/en/intl.php
new file mode 100644
index 0000000..da58f4c
--- /dev/null
+++ b/lang/en/intl.php
@@ -0,0 +1,3 @@
+<?php
+
+return ['inquiry_received' => 'Your inquiry has been received.', 'contact' => 'Contact us'];
diff --git a/lang/ja/intl.php b/lang/ja/intl.php
new file mode 100644
index 0000000..dc21fbd
--- /dev/null
+++ b/lang/ja/intl.php
@@ -0,0 +1,3 @@
+<?php
+
+return ['inquiry_received' => 'お問い合わせを受け付けました。', 'contact' => 'お問い合わせ'];
diff --git a/lang/en/pages/home.php b/lang/en/pages/home.php
new file mode 100644
index 0000000..863171b
--- /dev/null
+++ b/lang/en/pages/home.php
@@ -0,0 +1,3 @@
+<?php
+
+return ['title' => 'J-Curve'];
diff --git a/lang/ja/pages/home.php b/lang/ja/pages/home.php
new file mode 100644
index 0000000..863171b
--- /dev/null
+++ b/lang/ja/pages/home.php
@@ -0,0 +1,3 @@
+<?php
+
+return ['title' => 'J-Curve'];
diff --git a/resources/views/intl/pages/home.blade.php b/resources/views/intl/pages/home.blade.php
new file mode 100644
index 0000000..6a3c9e8
--- /dev/null
+++ b/resources/views/intl/pages/home.blade.php
@@ -0,0 +1,14 @@
+<!doctype html>
+<html lang="{{ config('intl.locales.'.intl_locale().'.html_lang') }}">
+<head>
+    <meta charset="utf-8">
+    <title>{{ __('pages/home.title') }}</title>
+    <link rel="canonical" href="{{ intl_alternates()[intl_locale()] }}">
+    @foreach(intl_alternates() as $locale => $url)
+        <link rel="alternate" hreflang="{{ $locale }}" href="{{ $url }}">
+    @endforeach
+    <link rel="alternate" hreflang="x-default" href="{{ intl_alternates()['ko'] }}">
+    <meta property="og:locale" content="{{ config('intl.locales.'.intl_locale().'.og_locale') }}">
+</head>
+<body><h1>{{ __('pages/home.title') }}</h1></body>
+</html>
diff --git a/routes/pages.php b/routes/pages.php
index a5d679f..efa5483 100644
--- a/routes/pages.php
+++ b/routes/pages.php
@@ -9,19 +9,20 @@
 | routes/web.php에서 require 된다 (QUEUE Q-002).
 */
 
+use App\Http\Controllers\PageController;
 use Illuminate\Support\Facades\Route;
 
 // 셀프마케팅 — 이 사이트에서 바로 주문하는 허브 (대웅 확정 2026-10-27).
 // 주문 데이터(상품·주문 현황)는 Codex 컨트롤러 연결 전까지 화면의 정적 안내만 보인다 → QUEUE 참고
-Route::view('/self-marketing', 'pages.self-marketing')->name('self-marketing');
+Route::get('/self-marketing', [PageController::class, 'selfMarketing'])->name('self-marketing');
 
 // 운영 서비스 소개 — 쇼피트렌드 (실제 서비스: https://shopitrend.co)
-Route::view('/solutions/shopitrend', 'solutions.shopitrend')->name('solutions.shopitrend');
+Route::get('/solutions/shopitrend', [PageController::class, 'shopitrend'])->name('solutions.shopitrend');
 
 // 고객센터 — 자주 묻는 질문 (대웅 지시 10/27). 문의게시판은 비회원 작성이라 Codex 백엔드 필요 → QUEUE Q-028
-Route::view('/support/faq', 'pages.faq')->name('support.faq');
+Route::get('/support/faq', [PageController::class, 'faq'])->name('support.faq');
 
 // 셀프마케팅 주문 '광고 시작하기' 4단계 + 상품 상세 (대웅 지시 10/27 "주문은 랭크프리로 바로 보내지 말고 주문 페이지가 필요해")
 // 상품표·크레딧·주문 생성은 GPT/Codex가 컨트롤러로 바꾸면서 연결 → docs/HANDOFF-CLAUDE-ORDER-UI-2026-10-27.md
 Route::view('/self-marketing/order', 'pages.self-marketing-order')->name('self-marketing.order');
-Route::view('/self-marketing/place', 'pages.self-marketing-place')->name('self-marketing.place');
+Route::get('/self-marketing/place', [PageController::class, 'selfMarketingPlace'])->name('self-marketing.place');
diff --git a/routes/web.php b/routes/web.php
index 6ffdc7d..450c1a5 100644
--- a/routes/web.php
+++ b/routes/web.php
@@ -111,3 +111,4 @@
 
 require __DIR__.'/auth.php';
 require __DIR__.'/pages.php';
+require __DIR__.'/intl.php';
diff --git a/routes/intl.php b/routes/intl.php
new file mode 100644
index 0000000..d86d122
--- /dev/null
+++ b/routes/intl.php
@@ -0,0 +1,46 @@
+<?php
+
+use App\Http\Controllers\ContactController;
+use App\Http\Controllers\InsightController;
+use App\Http\Middleware\SetIntlLocale;
+use Illuminate\Http\Request;
+use Illuminate\Support\Facades\Route;
+use Spatie\Honeypot\ProtectAgainstSpam;
+
+// Snapshot the Korean routes before registering either language.
+Route::getRoutes()->refreshNameLookups();
+$originals = [];
+foreach (config('intl.routes') as $name) {
+    if (Route::has($name)) {
+        $originals[$name] = Route::getRoutes()->getByName($name);
+    }
+}
+foreach (['en', 'ja'] as $locale) {
+    Route::prefix($locale)->name($locale.'.')->middleware(SetIntlLocale::class)->group(function () use ($originals) {
+        foreach ($originals as $name => $original) {
+            if ($name === 'insights.show') {
+                Route::get('/insights/{slug}', [InsightController::class, 'translatedShow'])
+                    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')->name($name);
+            } else {
+                Route::get($original->uri(), $original->getAction('uses'))->name($name);
+            }
+        }
+        // Only preserved static/category aliases; Korean article slugs are never foreign aliases.
+        foreach (config('seo.preserved_map') as $modern => $preserved) {
+            if (preg_match('~^/insights/(?!category/)~', $modern)) {
+                continue;
+            }
+            $original = Route::getRoutes()->match(Request::create($modern));
+            if (! isset($originals[$original->getName()])) {
+                continue;
+            }
+            $route = Route::get($preserved, $original->getAction('uses'));
+            $route->setAction(array_merge($route->getAction(), ['as' => null, 'intl_name' => $original->getName()]));
+            foreach ($original->parameters() as $key => $value) {
+                $route->defaults($key, $value);
+            }
+        }
+        Route::post('/contact-us/', [ContactController::class, 'store'])
+            ->middleware([ProtectAgainstSpam::class, 'throttle:5,1'])->name('contact.store');
+    });
+}
diff --git a/tests/Feature/IntlFoundationTest.php b/tests/Feature/IntlFoundationTest.php
new file mode 100644
index 0000000..ce13785
--- /dev/null
+++ b/tests/Feature/IntlFoundationTest.php
@@ -0,0 +1,348 @@
+<?php
+
+namespace Tests\Feature;
+
+use App\Models\Insight;
+use App\Models\InsightTranslation;
+use App\Models\Lead;
+use App\Models\LegacyRedirect;
+use App\Models\SeoMeta;
+use App\Services\Seo\Publishing\FeedCatalog;
+use App\Services\Seo\Publishing\PreservedPaths;
+use App\Support\IntlRoutes;
+use Database\Seeders\DatabaseSeeder;
+use Database\Seeders\IntlInsightSeeder;
+use Illuminate\Foundation\Testing\RefreshDatabase;
+use Illuminate\Http\Request;
+use Illuminate\Support\Facades\File;
+use Illuminate\Support\Facades\Route;
+use Illuminate\Support\Facades\View;
+use Spatie\Honeypot\EncryptedTime;
+use Spatie\Honeypot\ProtectAgainstSpam;
+use Tests\TestCase;
+
+class IntlFoundationTest extends TestCase
+{
+    use RefreshDatabase;
+
+    private array $temporaryDirectories = [];
+
+    protected function setUp(): void
+    {
+        parent::setUp();
+        config(['seo.public_url' => 'https://j-curve.co.kr', 'honeypot.randomize_name_field_name' => false]);
+        $this->seed(DatabaseSeeder::class);
+    }
+
+    protected function tearDown(): void
+    {
+        foreach ($this->temporaryDirectories as $directory) {
+            File::deleteDirectory($directory);
+        }
+        parent::tearDown();
+    }
+
+    private function sample(): Insight
+    {
+        return Insight::query()->whereHas('translations')->with('translations')->firstOrFail();
+    }
+
+    private function translatedView(string $name, string $content = 'translated test view'): void
+    {
+        $directory = sys_get_temp_dir().'/intl-view-'.bin2hex(random_bytes(8));
+        $this->temporaryDirectories[] = $directory;
+        $file = $directory.'/intl/'.str_replace('.', '/', $name).'.blade.php';
+        File::ensureDirectoryExists(dirname($file));
+        File::put($file, $content);
+        View::getFinder()->prependLocation($directory);
+        View::getFinder()->flush();
+    }
+
+    private function staticStatus(array $variant): int
+    {
+        $views = [
+            'home' => 'pages.home', 'company' => 'pages.company', 'contact' => 'contact',
+            'privacy' => 'pages.privacy', 'support.faq' => 'pages.faq',
+            'services.marketing-support' => 'pages.marketing-support',
+            'self-marketing' => 'pages.self-marketing', 'self-marketing.place' => 'pages.self-marketing-place',
+        ];
+        $name = $variant['name'];
+        $view = $views[$name] ?? $name;
+        if ($name === 'services.show') {
+            $view = 'services.'.$variant['parameters']['slug'];
+        } elseif (isset(config('intl.subpages')[$name])) {
+            $view = 'pages.subpage';
+        }
+
+        return View::exists('intl.'.$view) ? 200 : 404;
+    }
+
+    public function test_foreign_route_collection_compiles_without_duplicate_alias_names(): void
+    {
+        $compiled = Route::getRoutes()->compile();
+        $this->assertArrayHasKey('en.home', $compiled['attributes']);
+        $this->assertArrayHasKey('ja.contact.store', $compiled['attributes']);
+    }
+
+    public function test_all_static_targets_have_foreign_routes_and_missing_views_return_404(): void
+    {
+        foreach (config('intl.routes') as $name) {
+            $this->assertTrue(Route::has($name), $name);
+            foreach (['en', 'ja'] as $locale) {
+                $this->assertTrue(Route::has($locale.'.'.$name), $locale.'.'.$name);
+            }
+        }
+        foreach (['en', 'ja'] as $locale) {
+            foreach (IntlRoutes::variants() as $variant) {
+                $path = route($locale.'.'.$variant['name'], $variant['parameters'], false);
+                $response = $this->get($path);
+                $response->assertStatus($this->staticStatus($variant));
+            }
+            $this->get('/'.$locale.'/')->assertSee('lang="'.$locale.'"', false)
+                ->assertSee('href="https://j-curve.co.kr/'.$locale.'/"', false)
+                ->assertSee('hreflang="x-default"', false)
+                ->assertSee('content="'.config('intl.locales.'.$locale.'.og_locale').'"', false)
+                ->assertDontSee('pages/home.title');
+        }
+    }
+
+    public function test_all_foreign_aliases_redirect_once_preserving_raw_queries(): void
+    {
+        foreach (['en', 'ja'] as $locale) {
+            foreach (IntlRoutes::variants() as $variant) {
+                $canonical = route($locale.'.'.$variant['name'], $variant['parameters'], false);
+                $modern = '/'.$locale.($variant['path'] === '/' ? '' : $variant['path']);
+                $slashVariant = str_ends_with($canonical, '/') ? rtrim($canonical, '/') : $canonical.'/';
+                foreach (array_unique([$modern, $slashVariant]) as $alias) {
+                    if ($alias === $canonical) {
+                        continue;
+                    }
+                    $response = $this->get($alias.'?utm_source=a%2Fb&x=1&x=2')->assertStatus(301);
+                    $this->assertSame('http://localhost'.$canonical.'?utm_source=a%2Fb&x=1&x=2', $response->headers->get('Location'));
+                    $this->get($response->headers->get('Location'))->assertStatus($this->staticStatus($variant))->assertHeaderMissing('Location');
+                    $this->head($alias)->assertStatus(301);
+                }
+            }
+        }
+    }
+
+    public function test_excluded_foreign_paths_are_404_without_redirects(): void
+    {
+        foreach (['en', 'ja'] as $locale) {
+            foreach (['community', 'login', 'register', 'dashboard', 'profile', 'self-marketing/order', 'self-marketing/orders', 'seo-check', 'support/inquiries', 'work/example'] as $path) {
+                $this->get('/'.$locale.'/'.$path)->assertNotFound()->assertHeaderMissing('Location');
+            }
+            foreach (config('seo.preserved_paths') as $path) {
+                if (str_starts_with($path, '/seo/') && $path !== '/seo/') {
+                    $this->get('/'.$locale.$path)->assertNotFound()->assertHeaderMissing('Location');
+                }
+            }
+        }
+    }
+
+    public function test_legacy_landing_aliases_are_single_hop_but_excluded_destinations_have_no_foreign_redirect(): void
+    {
+        foreach (['en', 'ja'] as $locale) {
+            foreach (['/v1/company.php' => '/about-us/', '/company/anarchy' => '/about-us/', '/shop/' => '/solutions/boostingshop', '/v1/gfa.php' => '/services/performance-marketing/naver-gfa'] as $alias => $canonical) {
+                $this->get('/'.$locale.$alias.'?utm_source=a%2Fb&x=1&x=2')->assertStatus(301)
+                    ->assertRedirect('http://localhost/'.$locale.$canonical.'?utm_source=a%2Fb&x=1&x=2');
+                $this->get('/'.$locale.$canonical)->assertNotFound()->assertHeaderMissing('Location');
+            }
+            $this->get('/'.$locale.'/my-account/')->assertNotFound()->assertHeaderMissing('Location');
+            $this->get('/'.$locale.'/v1/manager/bbs/board.php?bo_table=column&wr_id=51')->assertNotFound()->assertHeaderMissing('Location');
+            $this->get('/'.$locale.'/v1/manager/column/온라인-마케팅-제대로-배울-수-있는-아나키-강의')->assertNotFound()->assertHeaderMissing('Location');
+        }
+        $this->get('/en/v1/manager/bbs/board.php?bo_table=column&wr_id=1&utm_source=a%2Fb')->assertStatus(301)
+            ->assertRedirect('http://localhost/en/insights/mobile-marketing-strategies?bo_table=column&wr_id=1&utm_source=a%2Fb');
+        $article = $this->sample()->replicate();
+        $article->slug = 'untranslated-source';
+        $article->legacy_wr_id = null;
+        $article->save();
+        LegacyRedirect::query()->create(['from_path' => 'legacy-ascii.php', 'to_path' => '/insights/untranslated-source', 'status_code' => 301]);
+        $this->get('/en/legacy-ascii.php')->assertNotFound()->assertHeaderMissing('Location');
+    }
+
+    public function test_url_helpers_preserve_addresses_and_use_public_origin_for_alternates(): void
+    {
+        $this->assertSame('http://localhost/en/about-us/', route('en.company'));
+        $this->assertSame('http://localhost/ja/seo-backlinks/', route('ja.services.seo.sub', ['sub' => 'backlinks']));
+        $this->assertSame('http://localhost/en/blog/seo/?page=2', route('en.insights.category', ['slug' => 'seo', 'page' => 2]));
+        $this->assertSame('http://localhost/en/insights/mobile-marketing-strategies', route('en.insights.show', ['slug' => 'mobile-marketing-strategies']));
+        $this->assertSame('http://localhost/about-us/', intl_route('company', [], 'ko'));
+        $this->assertSame('http://localhost/en/about-us/', intl_route('company', [], 'en'));
+        $this->translatedView('pages.company', '{{ json_encode(intl_alternates()) }}');
+        $this->get('/en/about-us/')->assertOk()->assertSee('https:\/\/j-curve.co.kr\/en\/about-us\/', false);
+        $this->get('/ja/')->assertOk();
+        $this->get('/')->assertOk()->assertDontSee('hreflang=');
+    }
+
+    public function test_adding_a_view_enables_its_existing_controller_without_route_changes(): void
+    {
+        $this->get('/en/about-us/')->assertStatus(View::exists('intl.pages.company') ? 200 : 404);
+        $this->translatedView('pages.company', '{{ intl_locale() }} company');
+        $this->get('/en/about-us/')->assertOk()->assertSee('en company');
+        $this->get('/ja/about-us/')->assertOk()->assertSee('ja company');
+    }
+
+    public function test_korean_preserved_routes_expose_alternates_without_modifying_korean_views(): void
+    {
+        $alternates = [];
+        View::composer('pages.company', function () use (&$alternates) {
+            $alternates = intl_alternates();
+        });
+        $this->get('/about-us/')->assertOk();
+        $this->assertSame([
+            'ko' => 'https://j-curve.co.kr/about-us/',
+            'en' => 'https://j-curve.co.kr/en/about-us/',
+            'ja' => 'https://j-curve.co.kr/ja/about-us/',
+        ], $alternates);
+        $article = Insight::query()->published()->where('slug', 'chrome-및-firefox에서-nofollow-링크를-확인하는-방법')->firstOrFail();
+        $article->translations()->create([
+            'locale' => 'en', 'slug' => 'check-nofollow-links', 'title' => 'Check nofollow links',
+            'content' => '<p>Translated article</p>', 'source_hash' => hash('sha256', $article->content),
+        ]);
+        View::composer('insights.show', function () use (&$alternates) {
+            $alternates = intl_alternates();
+        });
+        $this->get('/seo/'.$article->slug.'/')->assertOk();
+        $this->assertSame([
+            'ko' => 'https://j-curve.co.kr/seo/'.$article->slug.'/',
+            'en' => 'https://j-curve.co.kr/en/insights/check-nofollow-links',
+        ], $alternates);
+    }
+
+    public function test_translated_detail_passes_both_models_and_alternates_use_translated_slugs(): void
+    {
+        $sample = $this->sample();
+        $this->translatedView('insights.show', '{{ $insight->id }} {{ $translation->title }} {!! json_encode(intl_alternates()) !!}');
+        $this->get('/en/insights/mobile-marketing-strategies')->assertOk()
+            ->assertSee('[EN DRAFT]')->assertSee('https:\/\/j-curve.co.kr\/ja\/insights\/mobile-marketing-strategies-ja', false);
+        $sample->translations()->where('locale', 'ja')->delete();
+        $this->get('/en/insights/mobile-marketing-strategies')->assertOk()->assertDontSee('mobile-marketing-strategies-ja');
+        $this->get('/ja/insights/mobile-marketing-strategies')->assertNotFound();
+        $this->get('/en/insights/mobile-marketing-strategies/')->assertStatus(301)
+            ->assertRedirect('http://localhost/en/insights/mobile-marketing-strategies');
+    }
+
+    public function test_untranslated_and_hidden_insights_are_404_even_when_foreign_view_exists(): void
+    {
+        $this->translatedView('insights.show', 'foreign detail');
+        $this->get('/en/insights/no-such-translation')->assertNotFound();
+        $sample = $this->sample();
+        foreach (['en', 'ja'] as $locale) {
+            $this->get('/'.$locale.'/insights/'.$sample->slug)->assertStatus(301);
+        }
+        config(['seo.hidden_insights' => [...config('seo.hidden_insights'), $sample->slug]]);
+        $this->get('/en/insights/mobile-marketing-strategies')->assertNotFound();
+        config(['seo.hidden_insights' => []]);
+        $sample->update(['published_at' => now()->addDay()]);
+        $this->get('/en/insights/mobile-marketing-strategies')->assertNotFound();
+    }
+
+    public function test_foreign_home_lists_and_categories_load_only_published_translations(): void
+    {
+        $sample = $this->sample();
+        $home = $this->get('/en/')->assertOk();
+        $this->assertSame([$sample->id], $home->viewData('insights')->modelKeys());
+        $this->assertTrue($home->viewData('insights')->first()->relationLoaded('translation'));
+        $this->translatedView('insights.index');
+        $this->translatedView('insights.category');
+        $response = $this->get('/en/blog/')->assertOk();
+        $this->assertSame([$sample->id], $response->viewData('insights')->getCollection()->modelKeys());
+        $this->assertSame('http://localhost/en/blog/', $response->viewData('insights')->path());
+        $category = $sample->category;
+        $this->get(route('en.insights.category', ['slug' => $category->slug], false))->assertOk();
+        $this->get('/en/blog/seo/')->assertNotFound();
+        $sample->translations()->where('locale', 'en')->delete();
+        $this->get(route('en.insights.category', ['slug' => $category->slug], false))->assertNotFound();
+    }
+
+    public function test_translation_seeder_is_idempotent_updates_rows_and_detects_display_content_changes(): void
+    {
+        $sample = $this->sample();
+        $before = InsightTranslation::query()->orderBy('id')->get()->toArray();
+        $this->seed(IntlInsightSeeder::class);
+        $this->assertSame($before, InsightTranslation::query()->orderBy('id')->get()->toArray());
+        $sample->translations()->where('locale', 'en')->update(['title' => 'obsolete']);
+        $this->seed(IntlInsightSeeder::class);
+        $this->assertDatabaseCount('insight_translations', 2);
+        $this->assertDatabaseHas('insight_translations', ['locale' => 'en', 'title' => '[EN DRAFT] Five mobile marketing strategies']);
+        $this->artisan('intl:stale')->expectsOutputToContain('Stale translations: 0')->assertSuccessful();
+        $sample->update(['content' => $sample->content.' changed']);
+        $this->artisan('intl:stale')->expectsOutputToContain($sample->slug)
+            ->expectsOutputToContain('Stale translations: 2')->assertSuccessful();
+        $sample->delete();
+        $this->assertDatabaseCount('insight_translations', 0);
+        $this->artisan('db:seed', ['--class' => IntlInsightSeeder::class])
+            ->expectsOutputToContain('INTL skipped missing ko_slug:')->assertSuccessful();
+    }
+
+    public function test_contact_locale_comes_from_path_and_keeps_utm_flash_and_middleware(): void
+    {
+        foreach (['en', 'ja', 'ko'] as $locale) {
+            $path = ($locale === 'ko' ? '' : '/'.$locale).'/contact-us/';
+            $matched = Route::getRoutes()->match(Request::create($path, 'POST'));
+            foreach (['web', ProtectAgainstSpam::class, 'throttle:5,1'] as $middleware) {
+                $this->assertContains($middleware, $matched->gatherMiddleware());
+            }
+            $fields = [
+                'name' => 'Intl Test', 'email' => $locale.'@example.com', 'message' => 'Inquiry',
+                'service_interest' => 'seo', 'locale' => 'xx', 'my_name' => '',
+                'valid_from' => (string) EncryptedTime::create(now()->subSeconds(3)),
+            ];
+            $this->withSession(['contact.utm' => ['utm_source' => 'first']])
+                ->post($path.'?utm_campaign=global', $fields)->assertRedirect('http://localhost'.$path)
+                ->assertSessionHas('status', 'inquiry-received')->assertSessionMissing('contact.utm');
+            $lead = Lead::query()->where('email', $locale.'@example.com')->firstOrFail();
+            $this->assertSame($locale === 'ko' ? null : $locale, $lead->locale);
+            $this->assertSame(['utm_source' => 'first', 'utm_campaign' => 'global'], $lead->utm);
+        }
+    }
+
+    public function test_contact_validation_is_localized_and_redirects_to_its_own_language(): void
+    {
+        foreach (['en' => 'The name field is required.', 'ja' => 'お名前は必須です。'] as $locale => $message) {
+            $fields = ['my_name' => '', 'valid_from' => (string) EncryptedTime::create(now()->subSeconds(3)), 'locale' => 'ko'];
+            $this->from('/login')->post('/'.$locale.'/contact-us/', $fields)
+                ->assertRedirect('http://localhost/'.$locale.'/contact-us/')
+                ->assertSessionHasErrors(['name' => $message]);
+        }
+        $this->assertDatabaseCount('leads', 0);
+    }
+
+    public function test_stale_hash_uses_korean_display_content_instead_of_hidden_raw_introductions(): void
+    {
+        $article = Insight::query()->where('slug', '스마트스토어-검색광고가-꼭-필요할까')->firstOrFail();
+        $first = '안녕하십니까. 마케팅 비전공자이자 10년차 광고대행사 마케터로 생활하고 있는 초짜 셀러 아나키입니다.';
+        $second = '안녕하세요. 마케팅 비전공자이자 10년차 광고대행사 마케터로 생활하고 있는 초짜 셀러 아나키입니다.';
+        $article->update(['content' => $first.'<p>Visible content</p>']);
+        $visible = $article->fresh()->content;
+        $article->translations()->create([
+            'locale' => 'en', 'slug' => 'display-hash-example', 'title' => 'Display hash example',
+            'content' => '<p>Translated content</p>', 'source_hash' => hash('sha256', $visible),
+        ]);
+        $article->update(['content' => $second.'<p>Visible content</p>']);
+        $this->assertSame($visible, $article->fresh()->content);
+        $this->artisan('intl:stale')->expectsOutputToContain('Stale translations: 0')->assertSuccessful();
+        $article->update(['content' => $second.'<p>Changed content</p>']);
+        $this->artisan('intl:stale')->expectsOutputToContain('Stale translations: 1')->assertSuccessful();
+    }
+
+    public function test_foreign_sitemap_entries_and_korean_rss_contract(): void
+    {
+        $sections = app(FeedCatalog::class)->sections();
+        $urls = collect($sections)->flatten(1)->pluck('url');
+        foreach (['en', 'ja'] as $locale) {
+            foreach (IntlRoutes::variants() as $variant) {
+                $this->assertContains('https://j-curve.co.kr'.route($locale.'.'.$variant['name'], $variant['parameters'], false), $urls);
+            }
+        }
+        $this->assertContains('https://j-curve.co.kr/en/insights/mobile-marketing-strategies', $urls);
+        $this->assertNotContains('https://j-curve.co.kr/en/self-marketing/order', $urls);
+        $this->get('/rss')->assertOk()->assertDontSee('https://j-curve.co.kr/en/')->assertDontSee('https://j-curve.co.kr/ja/');
+        SeoMeta::query()->create(['path' => '/en/insights/mobile-marketing-strategies', 'robots' => 'noindex']);
+        $urls = collect(app(FeedCatalog::class)->sections())->flatten(1)->pluck('url');
+        $this->assertNotContains('https://j-curve.co.kr/en/insights/mobile-marketing-strategies', $urls);
+        $this->assertSame('/en/about-us/', PreservedPaths::destination('/en/company'));
+    }
+}
diff --git a/tests/Support/intl_snapshot.php b/tests/Support/intl_snapshot.php
new file mode 100644
index 0000000..77c9073
--- /dev/null
+++ b/tests/Support/intl_snapshot.php
@@ -0,0 +1,62 @@
+<?php
+
+use App\Services\Seo\Publishing\FeedCatalog;
+use Illuminate\Contracts\Console\Kernel;
+use Illuminate\Http\Request;
+use Illuminate\Support\Carbon;
+
+// Usage: php tests/Support/intl_snapshot.php ROOT OUTPUT_JSON
+// The caller supplies isolated SQLite and environment variables; never use a real database.
+$root = realpath($argv[1]);
+$loader = require $root.'/vendor/autoload.php';
+foreach (['App\\' => 'app/', 'Database\\Seeders\\' => 'database/seeders/', 'Database\\Factories\\' => 'database/factories/'] as $prefix => $directory) {
+    $loader->setPsr4($prefix, $root.'/'.$directory);
+    foreach ($loader->getClassMap() as $class => $path) {
+        if (str_starts_with($class, $prefix)) {
+            $loader->addClassMap([$class => $root.'/'.$directory.str_replace('\\', '/', substr($class, strlen($prefix))).'.php']);
+        }
+    }
+}
+$app = require $root.'/bootstrap/app.php';
+$console = $app->make(Kernel::class);
+$console->bootstrap();
+Carbon::setTestNow('2026-11-03 00:00:00');
+$app['config']->set('honeypot.randomize_name_field_name', false);
+$console->call('migrate:fresh', ['--force' => true]);
+$console->call('db:seed', ['--force' => true]);
+$catalog = $app->make(FeedCatalog::class)->sections();
+$korean = [];
+$paths = $app['config']->get('seo.preserved_paths');
+foreach ($catalog as $section => $entries) {
+    $korean[$section] = [];
+    foreach ($entries as $entry) {
+        // This runtime's parse_url replaces C1 bytes inside valid Korean UTF-8.
+        // Strip the known HTTP origin without touching the original path bytes.
+        $path = preg_replace('~^https?://[^/]+~', '', $entry['url']);
+        if (! preg_match('~^/(en|ja)(/|$)~', $path)) {
+            $korean[$section][] = $entry;
+            $paths[] = $path;
+        }
+    }
+}
+$paths = array_values(array_unique([...$paths, '/privacy', '/support/faq', '/solutions/shopitrend', '/self-marketing', '/self-marketing/place']));
+$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
+$pages = [];
+foreach ($paths as $path) {
+    $encoded = preg_replace_callback('/[\x80-\xff]/', fn ($match) => rawurlencode($match[0]), $path);
+    $request = Request::create('https://j-curve.co.kr'.$encoded);
+    $response = $kernel->handle($request);
+    $html = $response->getContent();
+    // Only per-request randomness: CSRF meta/input and Honeypot's encrypted timer.
+    $html = preg_replace('~(<meta name="csrf-token" content=")[^"]*(")~', '$1[CSRF]$2', $html);
+    $html = preg_replace('~(<input\b[^>]*\bname="_token"[^>]*\bvalue=")[^"]*(")~', '$1[CSRF]$2', $html);
+    $html = preg_replace('~(<input\b[^>]*\bname="valid_from"[^>]*\bvalue=")[^"]*(")~s', '$1[HONEYPOT]$2', $html);
+    $html = preg_replace('/\b(sbg|sgl|sdot)-[a-zA-Z0-9]{5}\b/', '$1-[SVG-ID]', $html);
+    $pages[base64_encode($path)] = ['status' => $response->getStatusCode(), 'html_base64' => base64_encode($html)];
+    $kernel->terminate($request, $response);
+}
+$snapshot = ['catalog' => $korean, 'pages' => $pages];
+file_put_contents($argv[2], json_encode($snapshot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
+echo 'Snapshot: '.count($pages).' Korean pages; preserved paths: '.count($app['config']->get('seo.preserved_paths')).PHP_EOL;
+echo 'Korean sitemap entries: '.array_sum(array_map('count', $korean)).PHP_EOL;
+echo 'HTTP statuses: '.json_encode(array_count_values(array_column($pages, 'status'))).PHP_EOL;
diff --git a/tests/Support/intl_compare.py b/tests/Support/intl_compare.py
new file mode 100644
index 0000000..71efbd2
--- /dev/null
+++ b/tests/Support/intl_compare.py
@@ -0,0 +1,66 @@
+"""Compare Korean responses against an archive, without creating a Git worktree."""
+
+import difflib
+import base64
+import io
+import json
+import os
+import shlex
+from pathlib import Path
+import subprocess
+import tarfile
+import tempfile
+
+
+root = Path(__file__).resolve().parents[2]
+with tempfile.TemporaryDirectory(prefix="intl-01-") as scratch:
+    scratch = Path(scratch)
+    base = scratch / "base"
+    base.mkdir()
+    archive = subprocess.check_output(["git", "archive", "0662117"], cwd=root)
+    with tarfile.open(fileobj=io.BytesIO(archive)) as bundle:
+        bundle.extractall(base, filter="data")
+    for relative in ["vendor", "node_modules", "public/build"]:
+        (base / relative).symlink_to(root / relative, target_is_directory=True)
+    if (root / ".env").is_file():
+        (base / ".env").symlink_to(root / ".env")
+    for relative in ["storage/framework/views", "storage/framework/sessions", "storage/framework/cache/data", "storage/logs", "bootstrap/cache"]:
+        (base / relative).mkdir(parents=True, exist_ok=True)
+    results = []
+    for label, checkout in [("baseline", base), ("implementation", root)]:
+        env = os.environ.copy()
+        env.update({
+            "APP_ENV": "testing", "APP_DEBUG": "false",
+            "APP_KEY": "base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=",
+            "APP_URL": "https://j-curve.co.kr", "SEO_PUBLIC_URL": "https://j-curve.co.kr",
+            "APP_LOCALE": "ko", "APP_FALLBACK_LOCALE": "en", "APP_FAKER_LOCALE": "en_US",
+            "DB_CONNECTION": "sqlite", "DB_DATABASE": str(scratch / (label + ".sqlite")), "DB_URL": "",
+            "SESSION_DRIVER": "array", "CACHE_STORE": "array", "QUEUE_CONNECTION": "sync",
+            "MAIL_MAILER": "array", "BCRYPT_ROUNDS": "4", "GTM_ID": "",
+            "APP_BASE_PATH": str(checkout),
+        })
+        Path(env["DB_DATABASE"]).touch()
+        output = scratch / (label + ".json")
+        command = ["php", str(root / "tests/Support/intl_snapshot.php"), str(checkout), str(output)]
+        print(label + ": " + shlex.join(command), flush=True)
+        subprocess.run(command, env=env, cwd=checkout, check=True)
+        results.append(json.loads(output.read_text()))
+    old, new = results
+    catalog_equal = old["catalog"] == new["catalog"]
+    differences = []
+    for path in sorted(set(old["pages"]) | set(new["pages"])):
+        before, after = old["pages"].get(path), new["pages"].get(path)
+        if before != after:
+            differences.append(path)
+            if before and after:
+                print("DIFF " + base64.b64decode(path).decode("utf-8", errors="replace"))
+                before_html = base64.b64decode(before["html_base64"]).decode("utf-8", errors="replace")
+                after_html = base64.b64decode(after["html_base64"]).decode("utf-8", errors="replace")
+                print("".join(list(difflib.unified_diff(before_html.splitlines(True), after_html.splitlines(True), n=1))[:30]))
+    print("Korean sitemap entries identical (including order/lastmod): " + str(catalog_equal))
+    print("Korean rendered pages: " + str(len(old["pages"])))
+    print("HTML/status differences: " + str(len(differences)))
+    print("Normalization: CSRF meta/input; encrypted valid_from input; 5-character random sbg/sgl/sdot SVG IDs. Vite assets shared, no hash normalization.")
+    print("Temporary archive, SQLite databases, snapshots: removed on exit.")
+    if differences or not catalog_equal or any(page["status"] != 200 for page in new["pages"].values()):
+        raise SystemExit(1)
```

</details>
