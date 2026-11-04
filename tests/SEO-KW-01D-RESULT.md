# SEO-KW-01D 결과

- 기준 지시서: `docs/SPEC-CODEX-SEO-KW-01D.md`.
- 기준 HEAD: `a03ddc2a64d159de32b152470fa1bb81193ea015` (`main`, 시작 때 clean, origin/main보다 13개 앞).
- 작업일: 2026-11-04. PHP 8.5.8 CLI.
- 역할: Claude의 작성자 화면 변경을 대상으로 Codex가 회귀 테스트 추가·실행·무력화 검증을 수행했다. 제품 최종 검수는 Claude 담당.
- 저장소 내 최종 변경: `tests/Feature/SeoKeywordViewsTest.php`(+40줄), `tests/SEO-KW-01D-RESULT.md`(신규).
- git 쓰기·운영 DB 작업·배포·발행 없음. 소유 범위 제한에 따라 요청 큐·대시보드는 저장하지 않았다.

## 결과

| 게이트 | 실제 결과 | exit |
|---|---|---:|
| 작성자 회귀 테스트, 실험 전 | 4/4 통과, 30 assertions | 0 |
| 예전 작성자 식으로 무력화 | 4/4 실패, 25 assertions | 1 |
| 화면 원복 후 작성자 회귀 테스트 | 4/4 통과, 30 assertions | 0 |
| 원복 후 `php artisan test` 전체 | **283/283 통과, 23,843 assertions** | 0 |
| 지정 테스트 파일 Pint | 통과 | 0 |
| 지정 테스트 파일 PHP 문법 | 통과 | 0 |
| 화면 복구 | 화면 99파일 SHA 동일, 화면 diff 빈 출력 | 0 |
| 소유 범위 밖 보존 | 점검 1,094파일의 변경·추가·삭제 0, git 메타데이터 동일 | 0 |

이 표는 로컬 실행 증거다. 브라우저 육안 검수와 운영 반영은 수행하지 않았다.

## 검증 내용

각 테스트는 `RefreshDatabase`와 SQLite `:memory:`에서 공개 인사이트를 만들어 HTTP 200 응답을 검사한다. 두 데이터셋 각각에 화면 테스트와 JSON-LD 테스트를 독립 실행해 총 4개 케이스를 구성했다.

| 데이터셋 | 계정 nickname | 계정 name | 화면 기대값 |
|---|---|---|---|
| company account nickname | `jcurve` | 제이커브 운영 계정 | `글 <strong>제이커브</strong>` |
| different account nickname and name | 다른 필자 | 다른 작성자 | `글 <strong>제이커브</strong>` |

- 화면: `.jc-article-meta`의 작성자 칸이 정확히 1개이고, 해당 칸에 `jcurve`가 없으며, 정규화한 문구가 정확히 `글 제이커브`, strong 내용은 정확히 `제이커브`인지 검사한다. 실제 HTML의 `글 <strong>제이커브</strong>`도 검사한다.
- 구조화 데이터: 렌더된 JSON-LD를 파싱해 BlogPosting이 정확히 1개인지 확인하고, 그 `author` 객체 전체를 아래 값과 엄격 비교한다. 기존 `author.@id` 검사도 유지했다.

```json
{"@type":"Organization","@id":"https://j-curve.co.kr/#organization","name":"제이커브","url":"https://j-curve.co.kr/about-us/"}
```

## 테스트 diff

아래는 실제 `GIT_OPTIONAL_LOCKS=0 git diff -- tests/Feature/SeoKeywordViewsTest.php` 출력이다.

```diff
diff --git a/tests/Feature/SeoKeywordViewsTest.php b/tests/Feature/SeoKeywordViewsTest.php
index b71bdf3..e5acf98 100644
--- a/tests/Feature/SeoKeywordViewsTest.php
+++ b/tests/Feature/SeoKeywordViewsTest.php
@@ -91,6 +91,46 @@ public function test_insight_blogposting_dates_author_publisher_and_article_meta
         $this->assertSame($insight->published_at->toAtomString(), $xpath->evaluate('string(//head/meta[@property="article:published_time"]/@content)'));
     }
 
+    public static function insightAuthors(): array
+    {
+        return [
+            'company account nickname' => ['jcurve', '제이커브 운영 계정'],
+            'different account nickname and name' => ['다른 필자', '다른 작성자'],
+        ];
+    }
+
+    #[DataProvider('insightAuthors')]
+    public function test_insight_byline_always_uses_the_jcurve_brand(string $nickname, string $name): void
+    {
+        $author = User::factory()->create(['nickname' => $nickname, 'name' => $name]);
+        $insight = $this->insight(['user_id' => $author->id]);
+        $html = $this->page($this->insightPath($insight));
+        $xpath = $this->html($html);
+        $bylines = $xpath->query('//div[contains(concat(" ", normalize-space(@class), " "), " jc-article-meta ")]/span[strong]');
+
+        $this->assertSame(1, $bylines->length);
+        $byline = $bylines->item(0);
+        $this->assertStringNotContainsString('jcurve', $byline->textContent);
+        $this->assertSame('글 제이커브', $this->normalize($byline->textContent));
+        $this->assertSame('제이커브', $xpath->evaluate('string(strong)', $byline));
+        $this->assertStringContainsString('글 <strong>제이커브</strong>', $html);
+    }
+
+    #[DataProvider('insightAuthors')]
+    public function test_insight_blogposting_author_always_uses_the_jcurve_organization(string $nickname, string $name): void
+    {
+        $author = User::factory()->create(['nickname' => $nickname, 'name' => $name]);
+        $insight = $this->insight(['user_id' => $author->id]);
+        $html = $this->page($this->insightPath($insight));
+
+        $this->assertSame([
+            '@type' => 'Organization',
+            '@id' => self::ORGANIZATION,
+            'name' => '제이커브',
+            'url' => self::PUBLIC_URL.'/about-us/',
+        ], $this->oneSchema($html, 'BlogPosting')['author']);
+    }
+
     public static function legacyArticles(): array
     {
         $pages = json_decode(file_get_contents(dirname(__DIR__, 2).'/docs/SEO-META-02-TITLES.json'), true, flags: JSON_THROW_ON_ERROR)['pages'];
```

## 실행 환경과 실제 출력

모든 artisan 실행에 아래 환경을 적용했다. DB 연결·URL·세션·캐시·메일·큐를 명시했고, 컴파일 뷰·Laravel 런타임 저장소·캐시·테스트 임시 파일은 `/private/tmp/jcurve-seo-kw-01d`에 격리했다. `.env`를 직접 열람하거나 수정하지 않았다. PHPUnit 결과 캐시를 끄고 캐시 디렉터리도 임시 경로로 지정했다.

전체 테스트의 실제 명령:

```sh
env \
  APP_ENV=testing \
  APP_URL=http://localhost \
  SEO_PUBLIC_URL=https://j-curve.co.kr \
  DB_CONNECTION=sqlite \
  DB_DATABASE=:memory: \
  DB_URL= \
  CACHE_STORE=array \
  SESSION_DRIVER=array \
  QUEUE_CONNECTION=sync \
  MAIL_MAILER=array \
  LOG_CHANNEL=stderr \
  LARAVEL_STORAGE_PATH=/private/tmp/jcurve-seo-kw-01d/storage \
  VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01d/views \
  APP_CONFIG_CACHE=/private/tmp/jcurve-seo-kw-01d/cache/config.php \
  APP_SERVICES_CACHE=/private/tmp/jcurve-seo-kw-01d/cache/services.php \
  APP_PACKAGES_CACHE=/private/tmp/jcurve-seo-kw-01d/cache/packages.php \
  APP_ROUTES_CACHE=/private/tmp/jcurve-seo-kw-01d/cache/routes.php \
  APP_EVENTS_CACHE=/private/tmp/jcurve-seo-kw-01d/cache/events.php \
  TMPDIR=/private/tmp/jcurve-seo-kw-01d \
  TMP=/private/tmp/jcurve-seo-kw-01d \
  TEMP=/private/tmp/jcurve-seo-kw-01d \
  php artisan test --do-not-cache-result --cache-directory=/private/tmp/jcurve-seo-kw-01d/phpunit-cache --no-ansi
```

전체 출력(exit 0). WARNING 2줄도 원출력 그대로 보존한다.

```text
[2026-11-04 08:37:41] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"} 
[2026-11-04 08:37:41] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"} 
{"tool":"phpunit","result":"passed","tests":283,"passed":283,"assertions":23843,"duration_ms":13030}
```

작성자 검사 명령(위와 동일한 환경으로 실험 전·무력화 중·원복 후 각각 실행):

```sh
php artisan test --filter='SeoKeywordViewsTest::test_insight_(byline_always_uses_the_jcurve_brand|blogposting_author_always_uses_the_jcurve_organization)' --do-not-cache-result --cache-directory=/private/tmp/jcurve-seo-kw-01d/phpunit-cache --no-ansi
```

실험 전 실제 출력(exit 0):

```text
{"tool":"phpunit","result":"passed","tests":4,"passed":4,"assertions":30,"duration_ms":236}
```

원복 후 실제 출력(exit 0):

```text
{"tool":"phpunit","result":"passed","tests":4,"passed":4,"assertions":30,"duration_ms":266}
```

Pint 실제 명령·출력(exit 0):

```sh
./vendor/bin/pint --test tests/Feature/SeoKeywordViewsTest.php --cache-file=/private/tmp/jcurve-seo-kw-01d/pint.cache --no-ansi
```

```text
{"tool":"pint","result":"passed"}
```

PHP 문법 실제 명령·출력(exit 0):

```sh
php -l tests/Feature/SeoKeywordViewsTest.php
```

```text
No syntax errors detected in tests/Feature/SeoKeywordViewsTest.php
```

## 무력화 실험

`resources/views/insights/show.blade.php`의 다음 한 줄만 임시 변경했다.

```diff
-    $author = '제이커브';
+    $author = $insight->user ? ($insight->user->nickname ?: $insight->user->name) : '제이커브인터렉티브';
```

변경 후와 복구 후 각각 동일한 격리 환경에서 `php artisan view:clear --no-ansi`를 실행했다(exit 0, `INFO  Compiled views cleared successfully.`). 이전 컴파일 결과가 무력화 실험을 가리지 않도록 한 조치다. 실험 실행과 복구를 try/finally로 묶고, 복구 후 SHA와 전체 테스트를 확인했다.

| 검사 | 무력화 시 실제 값 | 실패 확인 | 복구 후 |
|---|---|---|---|
| 화면 / jcurve 계정 | `글 jcurve` | jcurve 노출 금지 검사 실패 | 통과 |
| 화면 / 다른 계정 | `글 다른 필자` | `글 제이커브` 엄격 비교 실패 | 통과 |
| BlogPosting author / jcurve 계정 | `name: jcurve` | author 객체 엄격 비교 실패 | 통과 |
| BlogPosting author / 다른 계정 | `name: 다른 필자` | author 객체 엄격 비교 실패 | 통과 |

무력화 중 실제 출력(exit 1):

```text
{"tool":"phpunit","result":"failed","tests":4,"passed":0,"assertions":25,"duration_ms":219,"failed":4,"failures":[{"test":"Tests\\Feature\\SeoKeywordViewsTest::test_insight_byline_always_uses_the_jcurve_brand with data set \"company account nickname\"","file":"/Users/anarchy/Claude_Projects/jcurve/tests/Feature/SeoKeywordViewsTest.php","line":103,"message":"Failed asserting that '\uae00 jcurve' [UTF-8](length: 10) does not contain \"jcurve\" [ASCII](length: 6)."},{"test":"Tests\\Feature\\SeoKeywordViewsTest::test_insight_byline_always_uses_the_jcurve_brand with data set \"different account nickname and name\"","file":"/Users/anarchy/Claude_Projects/jcurve/tests/Feature/SeoKeywordViewsTest.php","line":103,"message":"Failed asserting that two strings are identical.\n--- Expected\n+++ Actual\n@@ @@\n-'\uae00 \uc81c\uc774\ucee4\ube0c'\n+'\uae00 \ub2e4\ub978 \ud544\uc790'"},{"test":"Tests\\Feature\\SeoKeywordViewsTest::test_insight_blogposting_author_always_uses_the_jcurve_organization with data set \"company account nickname\"","file":"/Users/anarchy/Claude_Projects/jcurve/tests/Feature/SeoKeywordViewsTest.php","line":120,"message":"Failed asserting that two arrays are identical.\n--- Expected\n+++ Actual\n@@ @@\n Array &0 [\n     '@type' => 'Organization',\n     '@id' => 'https://j-curve.co.kr/#organization',\n-    'name' => '\uc81c\uc774\ucee4\ube0c',\n+    'name' => 'jcurve',\n     'url' => 'https://j-curve.co.kr/about-us/',\n ]"},{"test":"Tests\\Feature\\SeoKeywordViewsTest::test_insight_blogposting_author_always_uses_the_jcurve_organization with data set \"different account nickname and name\"","file":"/Users/anarchy/Claude_Projects/jcurve/tests/Feature/SeoKeywordViewsTest.php","line":120,"message":"Failed asserting that two arrays are identical.\n--- Expected\n+++ Actual\n@@ @@\n Array &0 [\n     '@type' => 'Organization',\n     '@id' => 'https://j-curve.co.kr/#organization',\n-    'name' => '\uc81c\uc774\ucee4\ube0c',\n+    'name' => '\ub2e4\ub978 \ud544\uc790',\n     'url' => 'https://j-curve.co.kr/about-us/',\n ]"}]}
```

## 원복·소유 범위 증명

실험 전·중·후 `GIT_OPTIONAL_LOCKS=0 git diff --stat -- resources/views`를 실행했다.

| 시점 | exit | stdout |
|---|---:|---|
| 실험 전 | 0 | 빈 출력(0바이트) |
| 무력화 중 | 0 | 아래 실제 출력 |
| 원복 후·전체 테스트 후 | 0 | 빈 출력(0바이트) |

```text
 resources/views/insights/show.blade.php | 2 +-
 1 file changed, 1 insertion(+), 1 deletion(-)
```

작성자 뷰 SHA-256은 실험 전과 원복 후 모두 다음 값이다.

```text
9a3fff5e0ff848f1105a4df78e795c21378735d4d625a4797c5c938118dee318
```

무력화 전 기준 스냅샷과 전체 테스트 후 비교 결과. 소유 파일 두 개는 비교에서 제외했다. 비교 범위는 git이 열거한 추적·비추적 비ignored 파일에 기존 Laravel 런타임 파일과 git 메타데이터를 추가한 것이다. 비밀 환경 파일은 읽지 않았다.

```sh
python3 /private/tmp/jcurve-seo-kw-01d/integrity.py /private/tmp/jcurve-seo-kw-01d/baseline.json
```

```json
{
  "checked_files": 1094,
  "view_files": 99,
  "changed_outside_owned": [],
  "view_sha256": "9a3fff5e0ff848f1105a4df78e795c21378735d4d625a4797c5c938118dee318",
  "git_metadata_unchanged": true
}
```

HEAD도 시작 때와 동일하다. 저장소의 최종 변경은 지정 테스트와 이 보고서 두 파일뿐이다. 커밋·스테이징·push·checkout·reset·stash 등 git 쓰기는 수행하지 않았다.

원자료는 `/private/tmp/jcurve-seo-kw-01d/`의 `author-green.log`, `author-red.log`, `author-restored.log`, `full-suite.log`, `pint.log`, `syntax.log`, `baseline.json`, `integrity.py`에 보존했다.
