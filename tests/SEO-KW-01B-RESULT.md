# SEO-KW-01B / SEO-KW-01B2 구현 반환물

- 상태: **작성자 NULL 충돌 수정 완료. 전체 합격 게이트 미충족 — 214개 중 211개 통과, 기존 단언 3개 실패.**
- 지시서: `docs/SPEC-CODEX-SEO-KW-01B2.md`. 새 글 5편은 `jcurve19@gmail.com` 계정을 작성자로 사용한다.
- 실제 시작 HEAD: `c9a21b2d5fd3d6b57230e91e02314221e23e15a2`, 시작 작업 트리는 clean이었다. 지시서의 `c9cf526` 다음 체크포인트가 이미 존재했다.
- 작업 중 외부 체크포인트 `e80e2cc50220c3c5c1528246f638482add2cdac3`가 관측됐다. 구현 diff는 동일했다. 구현자·검증자 모두 git 읽기 명령만 실행했다.
- 담당: Codex 구현 세션 = 소유 파일 구현·이 보고서, 별도 Codex 검증 세션 = 읽기 검토·실행·임시 복사본 무력화. Claude 최종 검수 미실시.

## 1. 이번에 바꾼 소유 파일

| 파일 | 변경 |
|---|---|
| `database/seeders/KeywordInsightSeeder.php` | `LegacyContentSeeder::run()`과 같은 이메일 조건·기본값의 `firstOrCreate`로 작성자 확보, 신규 5편의 `user_id`에 해당 id 저장 |
| `tests/Feature/KeywordInsightTest.php` | 5편의 정확한 작성자 id, 두 번 실행해도 users 1개, 신규·기존 계정 전체 필드 보존 검사 |
| `tests/SEO-KW-01B-RESULT.md` | 이전 NULL 충돌 보고서를 현재 결과·실제 출력·남은 실패로 교체 |

작성자 기본값은 이름 `제이커브인터렉티브`, 닉네임 `jcurve`, 비밀번호 `bcrypt(Str::random(32))`, 권한 `admin`, 인증 시각 `now()`다. 계정 확보는 기존 트랜잭션 안에서 실행한다. 이미 있는 계정은 이름·권한·비밀번호·인증 시각·타임스탬프를 포함한 모든 저장값을 그대로 사용한다.

스키마 변경, `LegacyContentSeeder` 변경, 화면 변경은 하지 않았다. 원고·manifest·33개 설명문 데이터도 변경하지 않았다.

## 2. 바꾼 기존 테스트 기대값 목록

이번 B2에서 바꾼 기존 기대값은 `KeywordInsightTest.php:125` 한 곳뿐이다. 지시서의 작성자 계약 정정에 따른 정확한 id 검사이며 NULL 허용·단언 삭제·skip은 추가하지 않았다.

```diff
-            $this->assertNull($insight->user_id);
+            $this->assertSame($author->id, $insight->user_id);
```

다음 검사는 추가했다.

- 새 계정의 이름·닉네임·권한·인증 시각이 정해진 기본값과 일치한다.
- 시더 2회 실행 전후 users가 1개이며, 계정 전체 원본 필드가 동일하다.
- 기존 계정의 이름·닉네임이 기본값과 다르고 권한이 `member`, 인증 시각이 NULL인 상태에서도 2회 실행 후 모든 필드를 보존하고 5편이 그 id를 사용한다.

앞 B 작업에서 이미 들어 있던 `tests/Feature/SeoMetaRestorationTest.php:34`의 쇼핑 원주소 예외는 이번에 변경하지 않았다. 이전 기대값 변경 이력을 아래에 유지한다.

```php
if ($path === '/naver-shopping-marketing/') {
    $page['title'] = '네이버쇼핑·스마트스토어 상위노출 마케팅 전문가의 노하우로 매출 UP';
    $page['description'] = '네이버쇼핑·스마트스토어 상위노출 마케팅을 위한 SEO는 제이커브에게 맡기세요! 10년 이상 풍부한 노하우로 상품 노출 극대화, 클릭률 향상, 매출 증대를 실현시켜 드립니다.';
}
```

실패한 description 원문 동일·샘플 행·중복 글 전체 필드 단언은 모두 그대로 유지했다.

## 3. 실행 명령과 실제 출력

모든 테스트는 운영 DB 대신 SQLite `:memory:`를 사용했다. 컴파일 뷰는 사용자 지정 경로만 사용하고 PHPUnit 결과 캐시는 생성하지 않았다.

### 작성자·계정 보존·카테고리 누락 검사

```sh
mkdir -p /private/tmp/jcurve-seo-kw-01b2/views
env APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= CACHE_STORE=array SESSION_DRIVER=array LOG_CHANNEL=stderr VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01b2/views php artisan test --filter='KeywordInsightTest::(test_seeding_twice|test_existing_author|test_missing_category)' --do-not-cache-result
```

개발 세션 최종 출력, 종료 코드 0:

```json
{"tool":"phpunit","result":"passed","tests":3,"passed":3,"assertions":61,"duration_ms":162}
```

### 별도 검증 세션 전체 테스트

```sh
env APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= CACHE_STORE=array SESSION_DRIVER=array LOG_CHANNEL=stderr VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01b2/views php artisan test --do-not-cache-result
```

공유 폴더의 외부 화면 변경 후 최신 상태에서 재실행한 실제 stdout·stderr 전체(행 끝 공백만 제거), 종료 코드 1:

```text
[2026-11-04 07:38:40] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"}
[2026-11-04 07:38:40] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"}
{"tool":"phpunit","result":"failed","tests":214,"passed":211,"assertions":21726,"duration_ms":6803,"failed":3,"failures":[{"test":"Tests\\Feature\\KeywordInsightTest::test_new_articles_render_their_own_canonical_metadata_and_appear_in_the_insights_sitemap","file":"/Users/anarchy/Claude_Projects/jcurve/tests/Feature/KeywordInsightTest.php","line":153,"message":"Failed asserting that two strings are identical.\n--- Expected\n+++ Actual\n@@ @@\n-'\ub124\uc774\ubc84 \ud50c\ub808\uc774\uc2a4 \uc21c\uc704\ub97c \uc62c\ub9ac\ub294 \uc810\uac80 \uc21c\uc11c\ub97c \uc815\ub9ac\ud588\uc2b5\ub2c8\ub2e4. \uc5f0\uad00\uc131\u00b7\uc815\ubcf4 \ucda9\uc2e4\uc131\u00b7\uc778\uae30\ub3c4\u00b7\uac70\ub9ac \ub124 \uac00\uc9c0 \uae30\uc900\uacfc \uc5c5\uc885\u00b7\uc18c\uac1c\u00b7\uc601\uc5c5 \uc815\ubcf4 \uc815\ube44, \ub9ac\ubdf0\u00b7\ub9ac\uc6cc\ub4dc \ud65c\uc6a9, \uac19\uc740 \uc870\uac74\uc758 \uc21c\uc704 \uae30\ub85d \ubc29\ubc95\uae4c\uc9c0 \ub2e4\ub8f9\ub2c8\ub2e4.'\n+'\ub124\uc774\ubc84 \ud50c\ub808\uc774\uc2a4 \uc21c\uc704\ub97c \uc62c\ub9ac\ub294 \uc810\uac80 \uc21c\uc11c\ub97c \uc815\ub9ac\ud588\uc2b5\ub2c8\ub2e4. \uc5f0\uad00\uc131\u00b7\uc815\ubcf4 \ucda9\uc2e4\uc131\u00b7\uc778\uae30\ub3c4\u00b7\uac70\ub9ac \ub124 \uac00\uc9c0 \uae30\uc900\uacfc \uc5c5\uc885\u00b7\uc18c\uac1c\u00b7\uc601\uc5c5 \uc815\ubcf4 \uc815\ube44, \ub9ac\ubdf0\u00b7\ub9ac\uc6cc\ub4dc \ud65c\uc6a9, \uac19\uc740 \uc870\uac74...'"},{"test":"Tests\\Feature\\KeywordInsightTest::test_all_33_descriptions_change_without_touching_other_legacy_fields","file":"/Users/anarchy/Claude_Projects/jcurve/tests/Feature/KeywordInsightTest.php","line":187,"message":"Failed asserting that a row in the table [insights] matches the attributes {\n    \"path\": \"\\/insights\\/2019\ub144-\uadf8\ub85c\uc2a4\ud574\ucee4\uc5d0\uac8c-\ud544\uc694\ud55c-\uc2a4\ud0ac1\",\n    \"slug\": \"2019\ub144-\uadf8\ub85c\uc2a4\ud574\ucee4\uc5d0\uac8c-\ud544\uc694\ud55c-\uc2a4\ud0ac1\",\n    \"meta_description\": \"\uadf8\ub85c\uc2a4\ud574\ucee4\uc5d0\uac8c \ud544\uc694\ud55c \uc2a4\ud0ac 15\uac00\uc9c0\uc640 \uae30\ucd08\u00b7\uc77c\ubc18\u00b7\ud2b9\ubcc4 3\ub2e8\uacc4 \uad6c\ubd84\uc744 \uc815\ub9ac\ud569\ub2c8\ub2e4. 1\ud3b8\uc740 \ub370\uc774\ud130 \ucd94\uc801 \ubc0f \ubd84\uc11d\uc744 \uc911\uc2ec\uc73c\ub85c \uad6c\uae00 \uc560\ub110\ub9ac\ud2f1\uc2a4, \ud0dc\uadf8 \ub9e4\ub2c8\uc800, \uc5d1\uc140, SQL \ub4f1 \ucd08\uae09\uc790\uc640 \uc219\ub828\uc790\uc5d0\uac8c \uc694\uad6c\ub418\ub294 \uc5ed\ub7c9\uc744 \uc124\uba85\ud569\ub2c8\ub2e4.\"\n}.\n\nFound: [\n    {\n        \"\\\"path\\\"\": \"path\",\n        \"slug\": \"\ubc18\ub4dc\uc2dc-\uc54c\uc544\uc57c-\ud560-\ubaa8\ubc14\uc77c-\ub9c8\ucf00\ud305-\uc804\ub7b5-5\uac00\uc9c0\",\n        \"meta_description\": null\n    },\n    {\n        \"\\\"path\\\"\": \"path\",\n        \"slug\": \"2019\ub144-\uc778\ud50c\ub8e8\uc5b8\uc11c\ub9c8\ucf00\ud305-\ud575\uc2ec-\ud2b8\ub80c\ub4dc\",\n        \"meta_description\": null\n    },\n    {\n        \"\\\"path\\\"\": \"path\",\n        \"slug\": \"2019\ub144-\ud544\uc694\ud55c-\uc720\ud29c\ube0c\ub9c8\ucf00\ud305-\uc804\ub7b5\",\n        \"meta_description\": null\n    }\n] and 55 others."},{"test":"Tests\\Feature\\KeywordInsightTest::test_duplicate_is_retained_unpublished_and_all_inbound_redirects_finish_in_one_hop","file":"/Users/anarchy/Claude_Projects/jcurve/tests/Feature/KeywordInsightTest.php","line":227,"message":"Failed asserting that two arrays are identical.\n--- Expected\n+++ Actual\n@@ @@\n \uc624\ub298\uc740 \uadf8\ub85c\uc2a4 \ud574\ucee4\uc5d0\uac8c \ud544\uc694\ud55c \uae30\uc220\ub4e4\uc744 \uc54c\uc544\ubcf4\uc558\uc2b5\ub2c8\ub2e4. \uadf8\ub85c\uc2a4 \ud574\ud0b9\uc5d0 \ub300\ud574 \ub354 \uc54c\uc544\ubcf4\uace0 \uc2f6\uc73c\uc2dc\uac70\ub098, \uad11\uace0 \ub300\ud589\uc744 \uc6d0\ud558\uc2dc\ub294 \ubd84\ub4e4\uc740 \uc81c\uc774\ucee4\ube0c \uc778\ud130\ub809\ud2f0\ube0c\ub85c \uc5f0\ub77d \uc8fc\uc138\uc694:D',\n     'cover_image' => null,\n     'meta_title' => null,\n-    'meta_description' => null,\n+    'meta_description' => '\uadf8\ub85c\uc2a4\ud574\ucee4\uc5d0\uac8c \ud544\uc694\ud55c \uc2a4\ud0ac \uc2dc\ub9ac\uc988\uc758 \ub9c8\uc9c0\ub9c9 \ud3b8\uc785\ub2c8\ub2e4. \uc815\uc131\uc801\uc778 \ub2f5\uc744 \uc5bb\ub294 \uace0\uac1d \uc778\ud130\ubdf0\uac00 \uc2e4\ud328\ub97c \uc904\uc774\ub294 \uc774\uc720\uc640, \ub09a\uc2dc\uac00 \ub418\uc9c0 \uc54a\uc73c\uba74\uc11c \uc8fc\uc758\ub97c \ub044\ub294 \uce74\ud53c \ub77c\uc774\ud305\uc5d0 80/20 \uaddc\uce59\uc774 \uc801\uc6a9\ub418\ub294 \uc774\uc720\ub97c \uc815\ub9ac\ud569\ub2c8\ub2e4.',\n     'published_at' => null,\n     'created_at' => '2026-11-05 12:00:00',\n     'updated_at' => '2026-11-05 12:00:00',"}]}
```

JSON 원문에 `errors` 필드는 없다. 이전 `NOT NULL constraint failed: insights.user_id` 오류는 원본 구현의 전체 검사에서 재현되지 않았다. 이번 추가 1개를 포함해 `KeywordInsightTest`는 11개 중 8개 통과다.

최신 전체 원문 파일: `/private/tmp/jcurve-seo-kw-01b2/independent-full-suite-latest-output.log`.
최신 원문 JSON·명령·종료 코드·실행 전후 SHA 증거: `/private/tmp/jcurve-seo-kw-01b2/independent-full-suite-latest-evidence.json`.
최초 전체 검사도 214개 중 211개 통과·3개 실패(6,578ms)였고, 당시 원문은 `/private/tmp/jcurve-seo-kw-01b2/independent-full-suite-output.log`와 `/private/tmp/jcurve-seo-kw-01b2/independent-full-suite-raw.json`에 보관했다. 최신 재실행(6,803ms) 전후 시더·테스트·공통 head의 SHA-256이 모두 같아 검사 중 소스 변경은 없었다.

### Pint

```sh
./vendor/bin/pint --test database/seeders/KeywordInsightSeeder.php tests/Feature/KeywordInsightTest.php
```

실제 출력, 종료 코드 0:

```json
{"tool":"pint","result":"passed"}
```

`npm run build`는 프론트 변경이 없으므로 B2 지시서대로 생략했다.

## 4. 남은 실패 3개와 확인 범위

| 검사 | 실제 원인 | 그대로 둔 이유 |
|---|---|---|
| `test_new_articles_render_their_own_canonical_metadata_and_appear_in_the_insights_sitemap` | `resources/views/insights/show.blade.php:56`의 `Str::limit(..., 155)`가 설명문을 잘라 `KeywordInsightTest.php:164`의 manifest 원문 동일 검사 실패 | 화면 수정 금지, 원고 수정·기대값 완화 금지 |
| `test_all_33_descriptions_change_without_touching_other_legacy_fields` | `KeywordInsightTest.php:212`에서 설명문 JSON의 `path`까지 `assertDatabaseHas`에 전달하지만 insights에는 해당 열이 없음 | 기존 단언·기대값 변경 금지. 스키마 열 추가로 우회하지 않음 |
| `test_duplicate_is_retained_unpublished_and_all_inbound_redirects_finish_in_one_hop` | `KeywordInsightTest.php:253`은 원본에서 공개일만 NULL로 바꾼 행을 기대하지만, B4의 설명문 33편 교체에 이 중복 글도 포함돼 `meta_description`이 함께 바뀜 | B4 데이터·시더 동작·기존 기대값을 임의로 바꾸지 않음 |

설명문 길이 제한은 `Str::limit`의 문자열 폭 기준이다. 5편 원문의 `mb_strwidth`는 186·198·202·175·179로, 5편 모두 현재 화면에서 잘린다. 렌더 테스트는 첫 글의 설명문에서 멈춰 이후 canonical·개별 사이트맵 단언까지 모두 통과했다고 보고할 수 없다.

33편 검사에서는 시더의 `Insight descriptions updated: 33; missing slugs skipped: 0` 출력과 기존 53편 전체 필드 비교가 먼저 통과했다. 그 뒤 첫 샘플의 잘못된 `path` DB 조건에서 실패했다. 중복 검사도 전체 행 비교에서 멈췄으므로 뒤의 GET·HEAD 단일 301·RSS/목록 제외 단언은 이번 실행의 통과 근거로 사용할 수 없다.

이전 NULL 오류에 막혔던 5개 중 재실행·5편 저장 검사와 누락 설명문 개수 검사는 통과했다. 나머지 3개는 위 잠복 문제를 드러냈다. **전체 초록 게이트는 미충족이며 합격으로 판정하지 않는다.**

## 5. 별도 세션 테스트 무력화

저장소 원본은 수정하지 않았다. 지정 임시 폴더에 만든 같은 클래스의 변형을 임시 PHPUnit bootstrap에서 로드했다. 두 실험 모두 운영 DB를 사용하지 않았다.

| 임시 변형 | 실제 결과 |
|---|---|
| `user_id`를 다시 NULL로 변경 | 종료 코드 2, 1개 검사·0 단언·오류 1개. `SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: insights.user_id` 재현 |
| `firstOrCreate`를 `updateOrCreate`로 변경 | 종료 코드 1, 1개 검사·2 단언·실패 1개. 기존 계정의 이름·비밀번호·인증 시각·닉네임·권한(member→admin)·타임스탬프 변경 검출 |

실제 무력화 실행 명령:

```sh
env APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= CACHE_STORE=array SESSION_DRIVER=array LOG_CHANNEL=stderr VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01b2/views php artisan test --bootstrap=/private/tmp/jcurve-seo-kw-01b2/mutant-bootstrap.php --filter='KeywordInsightTest::test_seeding_twice_keeps_five_exact_public_articles_with_fixed_dates_and_categories' --do-not-cache-result
env APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= CACHE_STORE=array SESSION_DRIVER=array LOG_CHANNEL=stderr VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01b2/views php artisan test --bootstrap=/private/tmp/jcurve-seo-kw-01b2/update-mutant-bootstrap.php --filter='KeywordInsightTest::test_existing_author_is_reused_without_changing_any_account_fields' --do-not-cache-result
```

실험 후 임시 bootstrap 없이 저장소 원본으로 관련 3개 검사를 재실행한 실제 출력, 종료 코드 0:

```sh
env APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= CACHE_STORE=array SESSION_DRIVER=array LOG_CHANNEL=stderr VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01b2/views php artisan test --filter='KeywordInsightTest::test_(seeding_twice_keeps_five_exact_public_articles_with_fixed_dates_and_categories|existing_author_is_reused_without_changing_any_account_fields|missing_category_throws_without_partial_inserts_or_existing_content_changes)' --do-not-cache-result
```

```json
{"tool":"phpunit","result":"passed","tests":3,"passed":3,"assertions":61,"duration_ms":165}
```

두 무력화의 긴 SQL·전체 실패 출력과 원본 재통과 증거는 `/private/tmp/jcurve-seo-kw-01b2/independent-verification-evidence.json`에 보관했다. 시더·테스트·Legacy 시더의 SHA-256은 무력화 전후 동일했다.

## 6. 구현 diff

명령: `git diff --unified=0 c9a21b2d5fd3d6b57230e91e02314221e23e15a2 -- database/seeders/KeywordInsightSeeder.php tests/Feature/KeywordInsightTest.php`.

외부 체크포인트 전후 동일한 실제 구현 diff다. 구현 2파일은 47줄 추가·2줄 삭제이며, 이 결과 문서의 교체는 아래 diff에서 제외했다.

```diff
diff --git a/database/seeders/KeywordInsightSeeder.php b/database/seeders/KeywordInsightSeeder.php
index 0c1724f..6b4d9c1 100644
--- a/database/seeders/KeywordInsightSeeder.php
+++ b/database/seeders/KeywordInsightSeeder.php
@@ -7,0 +8 @@
+use App\Models\User;
@@ -11,0 +13 @@
+use Illuminate\Support\Str;
@@ -41,0 +44,11 @@ public function run(): void
+            $author = User::query()->firstOrCreate(
+                ['email' => 'jcurve19@gmail.com'],
+                [
+                    'name' => '제이커브인터렉티브',
+                    'nickname' => 'jcurve',
+                    'password' => bcrypt(Str::random(32)),
+                    'role' => 'admin',
+                    'email_verified_at' => now(),
+                ],
+            );
+
@@ -54 +67 @@ public function run(): void
-                    'user_id' => null,
+                    'user_id' => $author->id,
diff --git a/tests/Feature/KeywordInsightTest.php b/tests/Feature/KeywordInsightTest.php
index 23d184c..70e0c54 100644
--- a/tests/Feature/KeywordInsightTest.php
+++ b/tests/Feature/KeywordInsightTest.php
@@ -7,0 +8 @@
+use App\Models\User;
@@ -101,0 +103,7 @@ public function test_seeding_twice_keeps_five_exact_public_articles_with_fixed_d
+        $author = User::query()->where('email', 'jcurve19@gmail.com')->sole();
+        $this->assertDatabaseCount('users', 1);
+        $this->assertSame('제이커브인터렉티브', $author->name);
+        $this->assertSame('jcurve', $author->nickname);
+        $this->assertSame('admin', $author->role);
+        $this->assertTrue($author->email_verified_at->equalTo(now()));
+        $firstAuthor = $author->getRawOriginal();
@@ -105,0 +114,2 @@ public function test_seeding_twice_keeps_five_exact_public_articles_with_fixed_d
+        $this->assertDatabaseCount('users', 1);
+        $this->assertSame($firstAuthor, $author->fresh()->getRawOriginal());
@@ -115 +125 @@ public function test_seeding_twice_keeps_five_exact_public_articles_with_fixed_d
-            $this->assertNull($insight->user_id);
+            $this->assertSame($author->id, $insight->user_id);
@@ -120,0 +131,22 @@ public function test_seeding_twice_keeps_five_exact_public_articles_with_fixed_d
+    public function test_existing_author_is_reused_without_changing_any_account_fields(): void
+    {
+        $author = User::factory()->create([
+            'email' => 'jcurve19@gmail.com',
+            'name' => '기존 콘텐츠 작성자',
+            'nickname' => 'existing-author',
+            'role' => 'member',
+            'email_verified_at' => null,
+        ])->fresh();
+        $original = $author->getRawOriginal();
+        $this->seed([InsightCategorySeeder::class, KeywordInsightSeeder::class]);
+        $this->travelTo(now()->addDays(3));
+        $this->seed(KeywordInsightSeeder::class);
+
+        $this->assertDatabaseCount('users', 1);
+        $this->assertSame($original, $author->fresh()->getRawOriginal());
+        $this->assertDatabaseCount('insights', 5);
+        foreach ($this->manifest() as $article) {
+            $this->assertSame($author->id, Insight::query()->where('slug', $article['slug'])->sole()->user_id);
+        }
+    }
+
```

## 7. 범위 준수·미검증

- 이 구현·검증 세션의 저장소 저장 도구는 소유 3파일에만 사용했다. 외부 체크포인트에는 구현 2파일만 포함됐다.
- 최종 감사에서 공유 폴더의 범위 밖 변경도 관측했다: `docs/SPEC-CODEX-SEO-KW-01C.md` 1줄 삭제, `resources/views/partials/jc/head.blade.php` 4줄 삭제. 이 세션은 두 파일을 저장하거나 되돌리지 않았다. 변경 주체는 확인하지 않았다. 따라서 공유 작업 폴더 전체의 금지 파일 diff 0 게이트를 충족으로 보고하지 않는다.
- `database/migrations/**`, `database/seeders/LegacyContentSeeder.php`, `resources/views/**`, `config/**`, `routes/**`, `public/**`, `docs/**`, `.env`를 저장하지 않았다.
- 소유 범위 제한에 따라 요청 큐·대시보드 데이터도 저장하지 않고 대시보드 생성기를 실행하지 않았다.
- git 쓰기·운영 DB 접속/시딩·배포·발행은 실행하지 않았다.
- 소유 3파일의 공백 검사는 `git diff --check c9a21b2d5fd3d6b57230e91e02314221e23e15a2 -- database/seeders/KeywordInsightSeeder.php tests/Feature/KeywordInsightTest.php tests/SEO-KW-01B-RESULT.md`로 실행했다. 실제 출력 없음, 종료 코드 0.
- 실제 운영 MySQL·운영 계정/콘텐츠·검색 수집·순위 변화는 미검증이다.
- 전체 초록을 위한 후속 결정은 4절의 화면 제한 및 테스트 계약 불일치 3건이다. 이번 구현에서 금지 파일을 고치거나 기대값을 낮춰 숨기지 않았다.
