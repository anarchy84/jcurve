# SEO-KW-01B 구현 반환물

- 상태: **구현 파일 작성, 합격 게이트 미충족 — 작성자 NULL과 DB NOT NULL 충돌로 실행 차단**.
- 시작 HEAD: `925199b00e749705bb828e9c885e5f83c7d4b2f7` (`main`). 작업 중 외부 체크포인트로 `8229427eabc79883373ea411da9ac666bc56eb24`가 관찰됐다. 이 세션은 git 쓰기 명령을 실행하지 않았다.
- 담당: Codex = 지시 범위 구현·실행 증거, 별도 Codex 세션 = 독립 검증, Claude = 최종 합격 판정.
- **운영 시더 실행 금지 상태**. 아래 스키마 충돌 해결 전에는 운영에 시더 실행을 요청하면 안 된다.

## 1. 지시서와 스키마의 충돌

지시서 B3는 `user_id = null`을 요구한다. 현재 `database/migrations/2026_08_04_000007_create_insights_table.php:13`은 다음과 같다.

```php
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
```

작성자 필드에 NULL을 허용하지 않아서, 지시서 그대로 작성한 시더의 첫 신규 글 저장이 다음 오류로 중단된다.

```text
SQLSTATE[23000]: Integrity constraint violation: 19 NOT NULL constraint failed: insights.user_id
```

마이그레이션은 지정 소유 파일 밖이다. 마이그레이션 변경이나 시더 안에서 스키마를 바꾸는 우회는 하지 않았다. 사용자에게 nullable 마이그레이션 1개를 소유 범위에 추가할지 질문했고 답변 대기 중이다. 원고·문구를 바꾸거나 임의 작성자를 넣지 않았다. 시더는 트랜잭션으로 묶여 있으므로 이 실패가 발생하면 신규 글·설명문·중복 정리가 부분 반영되지 않는다.

## 2. 바꾼 파일 목록

| 파일 | 변경 |
|---|---|
| `config/subpages.php` | B1·B2 H1, 지정 순서의 순위 섹션 2개, FAQ 4개, 쇼핑 제목·설명 |
| `database/seeders/KeywordInsightSeeder.php` (신규) | 배포용 복사본만 읽기, 카테고리 사전 확인, 슬러그 upsert, 고정 서울 시각을 앱 시간대로 변환, NULL 작성자, 33편 설명문만 수정, 중복 비공개·301·이전표 체인 정리, 누락 개수 출력, 트랜잭션 |
| `database/content/kw01/manifest.json` (신규) | Claude 확정 manifest 원본 복사 |
| `database/content/kw01/01-place-rank.html` (신규) | 원고 원본 복사 |
| `database/content/kw01/02-place-reward.html` (신규) | 원고 원본 복사 |
| `database/content/kw01/03-smartstore-rank.html` (신규) | 원고 원본 복사 |
| `database/content/kw01/04-shopping-inflow.html` (신규) | 원고 원본 복사 |
| `database/content/kw01/05-offerwall.html` (신규) | 원고 원본 복사 |
| `database/content/kw01/insight-meta.json` (신규) | 33개 설명문 원본 복사 |
| `tests/Feature/KeywordInsightTest.php` (신규) | B1~B5 회귀 검사 10개(데이터 제공자 포함) |
| `tests/Feature/SeoMetaRestorationTest.php` | B2-3 쇼핑 원주소의 title·description 기대값만 추가 분기 |
| `tests/SEO-KW-01B-RESULT.md` (신규) | 이 반환 보고서 |

`config/seo.php`의 `pages`에 `/self-marketing/shopping`이 이미 있었으므로 수정하지 않았다. `routes/pages.php`의 `self-marketing.shopping`도 읽기로만 확인했다. `DatabaseSeeder`에는 시더를 등록하지 않았다.

설명문 갱신과 중복 비공개는 query builder로 지정 필드만 수정하여 기존 글의 `updated_at`도 보존한다. 중복 글은 삭제하지 않고 `published_at = null`로 비공개 처리하는 구현이다. 이전표의 상대 주소·인코딩 주소·끝 슬래시·자사 절대 주소는 최종 정상 글로 직접 연결하도록 처리한다.

## 3. 문구·원고 보존 검증

지시서의 PHP 코드 블록을 배열로 읽어 삽입된 섹션·FAQ와 엄격 비교한 실제 출력:

```text
naver-place section and FAQ arrays match spec exactly
naver-shopping section and FAQ arrays match spec exactly
```

복사본을 원본과 바이트 단위로 비교한 실제 출력:

```text
01-place-rank.html byte-identical=True bytes=5725
02-place-reward.html byte-identical=True bytes=4724
03-smartstore-rank.html byte-identical=True bytes=4768
04-shopping-inflow.html byte-identical=True bytes=3821
05-offerwall.html byte-identical=True bytes=3901
manifest.json byte-identical=True bytes=4586
insight-meta.json byte-identical=True rows=33
```

새 회귀 테스트도 위 7파일의 `file_get_contents` 결과가 원본과 완전히 동일한지 검사한다. 시더의 원고 경로는 `database/content/kw01`이며 운영 실행에서 `docs`를 읽지 않는다.

## 4. git diff --stat 실제 출력

공유 폴더의 외부 체크포인트가 작업 도중 앞 변경을 커밋한 상태라, 기본 명령은 마지막 추가 변경만 보인다.

명령: `git diff --stat`

```text
 database/seeders/KeywordInsightSeeder.php | 14 ++++++++++----
 tests/Feature/KeywordInsightTest.php      |  6 +++++-
 2 files changed, 15 insertions(+), 5 deletions(-)
```

시작 HEAD 기준 이 작업 소유 구현 파일의 전체 비교:

```sh
git diff --stat 925199b -- config/subpages.php database/seeders/KeywordInsightSeeder.php database/content/kw01 tests/Feature/KeywordInsightTest.php tests/Feature/SeoMetaRestorationTest.php
```

```text
 config/subpages.php                           |  42 +++-
 database/content/kw01/01-place-rank.html      |  64 ++++++
 database/content/kw01/02-place-reward.html    |  51 +++++
 database/content/kw01/03-smartstore-rank.html |  51 +++++
 database/content/kw01/04-shopping-inflow.html |  41 ++++
 database/content/kw01/05-offerwall.html       |  38 ++++
 database/content/kw01/insight-meta.json       |  35 ++++
 database/content/kw01/manifest.json           |  47 +++++
 database/seeders/KeywordInsightSeeder.php     | 104 ++++++++++
 tests/Feature/KeywordInsightTest.php          | 268 ++++++++++++++++++++++++++
 tests/Feature/SeoMetaRestorationTest.php      |   5 +
 11 files changed, 742 insertions(+), 4 deletions(-)
```

보고서 자체는 위 통계에서 제외됐다. 이 통계는 git 읽기 명령으로만 얻었다.

## 5. 실행 명령과 실제 출력

### 독립 가능한 B1·B2·원본 보존·카테고리 누락·쇼핑 검사

```sh
mkdir -p /private/tmp/jcurve-seo-kw-01b/views
env VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01b/views LOG_CHANNEL=stderr php artisan test --filter='KeywordInsightTest::(test_landing|test_deployable|test_missing_category|test_shopping_page)' --do-not-cache-result
```

```json
{"tool":"phpunit","result":"passed","tests":5,"passed":5,"assertions":34,"duration_ms":191}
```

종료 코드 0.

### 전체 테스트

```sh
env VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01b/views LOG_CHANNEL=stderr php artisan test --do-not-cache-result
```

실제 출력의 JSON에서 긴 SQL 원고를 포함한 `error_details`만 분리했다. 나머지 필드값은 그대로다.

```json
{"tool":"phpunit","result":"failed","tests":213,"passed":208,"assertions":21602,"duration_ms":6927,"errors":5}
```

종료 코드 2. 기존 테스트 203개는 모두 통과했다. 신규 검사 10개 중 5개 통과, 아래 5개는 모두 동일한 `NOT NULL constraint failed: insights.user_id` 오류다.

- `Tests\Feature\KeywordInsightTest::test_seeding_twice_keeps_five_exact_public_articles_with_fixed_dates_and_categories`
- `Tests\Feature\KeywordInsightTest::test_new_articles_render_their_own_canonical_metadata_and_appear_in_the_insights_sitemap`
- `Tests\Feature\KeywordInsightTest::test_all_33_descriptions_change_without_touching_other_legacy_fields`
- `Tests\Feature\KeywordInsightTest::test_missing_description_slugs_are_skipped_and_counted`
- `Tests\Feature\KeywordInsightTest::test_duplicate_is_retained_unpublished_and_all_inbound_redirects_finish_in_one_hop`

테스트 삭제·skip·기대값 완화로 오류를 숨기지 않았다. 메모리 SQLite로 실행했으며 운영 DB에 시더를 실행하지 않았다. 실패한 테스트 안의 후속 단언은 실행 완료로 간주하지 않는다.

### 변경 PHP Pint

```sh
./vendor/bin/pint --test config/subpages.php database/seeders/KeywordInsightSeeder.php tests/Feature/KeywordInsightTest.php tests/Feature/SeoMetaRestorationTest.php
```

```json
{"tool":"pint","result":"passed"}
```

종료 코드 0. 첫 검사에서 신규 테스트 파일의 import 규칙 2개가 보고돼 해당 테스트 파일에만 Pint를 적용한 뒤 재검사했다.

### 임시 경로 빌드

```sh
npm run build -- --outDir /private/tmp/jcurve-seo-kw-01b/build
```

실제 출력에서 터미널 제어 문자만 제거했다.

```text
> build
> vite build --outDir /private/tmp/jcurve-seo-kw-01b/build

vite v8.2.0 building client environment for production...
transforming...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
✓ 12 modules transformed.

(!) outDir /private/tmp/jcurve-seo-kw-01b/build is not inside project root and will not be emptied.
Use --emptyOutDir to override.

rendering chunks...
computing gzip size...
../../../../private/tmp/jcurve-seo-kw-01b/build/manifest.json                        0.88 kB │ gzip:  0.25 kB
../../../../private/tmp/jcurve-seo-kw-01b/build/assets/legacy-reskin-3fymEzpK.css   13.71 kB │ gzip:  2.99 kB
../../../../private/tmp/jcurve-seo-kw-01b/build/assets/jc-Bqs11fyj.css              90.23 kB │ gzip: 17.45 kB
../../../../private/tmp/jcurve-seo-kw-01b/build/assets/app-Bust_w4X.css             97.40 kB │ gzip: 18.38 kB
../../../../private/tmp/jcurve-seo-kw-01b/build/assets/jc-DIWfGL1E.js               25.80 kB │ gzip:  9.23 kB
../../../../private/tmp/jcurve-seo-kw-01b/build/assets/app-XOhwnyVw.js             159.36 kB │ gzip: 60.50 kB

✓ built in 521ms
```

종료 코드 0. `public/build`로 빌드하는 명령은 실행하지 않았다. `VIEW_COMPILED_PATH`도 임시 폴더로 지정했다. `/media/bg/hero-glow.webp` 경고의 실제 런타임 제공 여부는 이번 작업에서 확인하지 않았다.

### 공백

명령: `git diff --check`

실제 출력: 없음. 종료 코드 0.

## 6. 바꾼 기존 테스트 기대값 — B2-3 한 곳

기존 파일 변경의 실제 diff:

```diff
diff --git a/tests/Feature/SeoMetaRestorationTest.php b/tests/Feature/SeoMetaRestorationTest.php
index bad62c0..07b6fa9 100644
--- a/tests/Feature/SeoMetaRestorationTest.php
+++ b/tests/Feature/SeoMetaRestorationTest.php
@@ -31,6 +31,11 @@ public static function publicPages(): array
         $expectations = json_decode(file_get_contents(dirname(__DIR__, 2).'/docs/SEO-META-02-TITLES.json'), true, flags: JSON_THROW_ON_ERROR);
         $cases = [];
         foreach ($expectations['pages'] as $path => $page) {
+            // SEO-KW-01B B2-3: only the shopping page intentionally adds ·스마트스토어.
+            if ($path === '/naver-shopping-marketing/') {
+                $page['title'] = '네이버쇼핑·스마트스토어 상위노출 마케팅 전문가의 노하우로 매출 UP';
+                $page['description'] = '네이버쇼핑·스마트스토어 상위노출 마케팅을 위한 SEO는 제이커브에게 맡기세요! 10년 이상 풍부한 노하우로 상품 노출 극대화, 클릭률 향상, 매출 증대를 실현시켜 드립니다.';
+            }
             $cases[$path] = [$path, $page['title'], $page['description']];
         }
```

`/naver-shopping-marketing/` 두 메타값에만 `·스마트스토어`를 더했다. 다른 원주소 기대값과 문서 정본 JSON은 변경하지 않았다.

새 글의 DB `meta_title`은 manifest와 완전 동일하게 저장한다. 렌더된 HTML title은 기존 Claude 뷰의 공통 규칙대로 `manifest.meta_title + " | 제이커브인터렉티브"`를 검사한다. H1과 description은 manifest 문자열 그대로를 검사한다. 기존 뷰의 제목 접미사는 수정하지 않았다.

## 7. 금지 파일·공유 작업 폴더

- 이 세션의 저장 도구는 2절 소유 파일에만 사용했다. `resources/views/**`, `routes/pages.php`, `docs/**`, `.env`, `public/media/**`, `database/content/legacy/**`를 저장하지 않았다.
- 시작 때 `resources/views/insights/category.blade.php`에 이미 변경이 있었다. 그대로 보존했다.
- 시작 파일과 `public/build`를 포함한 547개 파일의 SHA-256을 보관해 비교했다. 전체 작업 기간에 다음 범위 밖 변경이 관찰됐다: `resources/views/partials/jc/head.blade.php`, `docs/SPEC-CODEX-SEO-KW-01C.md`, `docs/SPEC-CODEX-SEO-KW-01-VERIFY.md`, `public/build/manifest.json`, `public/build/assets/app-BW-Dp7Pe.css`, `public/build/assets/app-Bust_w4X.css`. 이 세션은 해당 파일을 쓰거나 되돌리지 않았다. 변경 주체는 직접 식별하지 않았다.
- 외부 체크포인트 때문에 현재 git diff만으로 전체 작업 기간의 금지 파일 무변경을 증명할 수 없다. **이 세션의 금지 파일 저장 0건이며, 공유 폴더 전체의 금지 파일 변경 0 게이트는 충족으로 보고하지 않는다.**
- 소유 범위 제한에 따라 대시보드 `tasks.json`·요청 큐를 갱신하거나 대시보드 생성기를 실행하지 않았다.
- git commit/push/stash/reset/checkout·브랜치 변경·배포·운영 시딩은 실행하지 않았다.

## 8. 미검증·후속 항목

- 작성자 NULL 스키마 충돌 해소 후 전체 테스트 재실행이 필요하다. 현재는 새 글 5편의 실제 저장/두 번 실행/응답/메타/카테고리/사이트맵, 설명문 33편 갱신, 중복 글·기존 이전표의 단일 301·RSS 제외가 실행 완료로 검증되지 않았다.
- 스키마 수정이 승인되면 새 마이그레이션 및 그 검증을 추가하고 이 보고서를 갱신해야 한다. 승인 없이 소유 범위를 확대하지 않는다.
- 별도 Codex 검증 세션의 결과는 도착 후 아래에 보강한다. Claude 최종 합격 판정은 아직 받지 않았다.
- 운영 배포·발행·검색 수집·실제 순위 변화·운영 DB 데이터 일치·실서비스 MySQL은 확인하지 않았다.

