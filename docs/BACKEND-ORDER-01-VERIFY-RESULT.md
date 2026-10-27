# BACKEND-ORDER-01 독립 검증 결과

검증일: 2026-10-27 · 기준 HEAD: `0b8ee517b8a383bbc45afccf5da240b53aaa0107` · 작업 폴더: `/Users/anarchy/Claude_Projects/jcurve`

**로컬 모듈 검증: PASS.** 1차 독립 공격에서 5개 실패를 재현해 부모 구현 세션에 반환했다. 부모의 수정 후 제품을 재동결하고 다시 실행해 **전체 74/74 tests · 484 assertions**, 주문 모듈 **14/14 · 82 assertions**, 독립 공격 **13/13 · 386 assertions**가 통과했다. 소유 PHP 4파일의 Pint·문법 검사와 격리 Vite 빌드도 통과했다.

검증자는 제품을 수정하지 않았다. 지시서의 enabled guard 임시 무력화·원문 복구 1회만 수행했고 영구 저장 산출물은 이 보고서다. 최종 제품·실연동·주문·배포·공개 승인은 Claude의 별도 검수 대상이다.

## 1. 범위와 격리

- 필수 지시서·구현 계약·AGENTS/COLLAB/QUEUE를 완독했다. 부모가 제품과 대시보드를 맡고, 별도 verifier 세션이 이 보고서를 소유한다.
- `.env`를 열거나 로드하지 않았다. 임시 환경 경로에서 SQLite `:memory:`/array 캐시·세션/가짜 메일·비활성 랭크프리 설정으로 config를 생성하고 `APP_CONFIG_CACHE`로 실행했다. 수정본 검증 전에 config를 재생성했다.
- 실제 키를 입력하거나 사용하지 않았다. `rk_independent_fake_secret`, `rk_unit_test_secret`는 fixture 문자열이다. 아래 유출 재현도 이 가짜 표식값을 사용했다.
- 모든 HTTP는 `Http::fake()`/`Http::preventStrayRequests()`로 차단했다. 외부 API·실주문·실제 DB 연결은 0회다. fake callback에서 HTTPS 고정 URL·Authorization·`allow_redirects=false` 옵션을 직접 단언했다.
- 프론트·미디어·DB·인증·결제·라우트·배포·git 변경을 하지 않았다. 공유 작업자의 변경을 되돌리지 않았다.

## 2. 1차 재현 → 수정 → 최종 결과

원본 줄 번호는 무력화 실험 전에 보존한 `original-RankfreeClient.php`와 같다.

| 항목·원본 위치 | 공격 입력 | 1차 실제 관측 / 기대 | 부모 수정 후 독립 결과 |
|---|---|---|---|
| 상품 metadata 중첩 유출 · `RankfreeClient.php:166` | `type`, `type_name`, `quantity_mode`, `min_quantity`, `max_quantity`, `min_days`, `fixed_quantity`, `fixed_days`, `earliest_start_date` 각각에 `{supplier_secret: 가짜키}` | 9개 모두 반환 배열에 중첩 표식이 남음 / 비정상 타입 거부 또는 제거 | `invalid_response`로 차단, leak 목록 `[]` |
| 필드 descriptor 중첩 유출 · `:182` | 승인된 `place_url` 필드의 `label`, `type`, `required`, `help`, `contains`에 중첩 표식 | 5개 모두 고객용 결과에 표식 반환 / 타입 검증·안전한 거부 | leak 목록 `[]` |
| 지원 타입 검증 누락 · `:179` | preflight의 승인 필드 `type`을 array/null/int로 변형 | 세 경우 모두 POST 발생 / 프로토콜 위반은 POST 전 차단 | array/null/int/미지 문자열/필수 FILE·IMAGE 모두 POST 0 |
| 손상된 201의 일반 PHP 오류 · `:83` | POST 201의 정상 주문 외형에서 `product=[]` | `ErrorException: Undefined array key "id"` / `RankfreeException(submission_uncertain)` | 안전한 `submission_uncertain`, 1 POST 유지 |
| GET 주문 상품 식별자 검증 누락 · `:212` | `product=[]`, id 0, title 키 누락 및 잘못된 타입 | 누락·0 등을 정상 주문으로 반환 / `invalid_response` | 잘못된 상품 accepted 목록 `[]`; 명시적 nullable 계약은 보존 |

부모는 상품 metadata의 scalar/string/int/date/nullable fixed 값, field의 타입·지원 enum·options를 검증하도록 바꿨다. 필수 FILE/IMAGE·지원하지 않는 필수 필드는 주문 불가로 처리하며, 주문 응답은 product id/title 키의 존재와 값을 구분한다.

**nullable 계약 정정:** 부모가 확정한 외부 계약에서 `order.product.id`는 int|null, `title`은 string|null이다. 첫 독립 fixture의 정상 null 거부 기대는 바로잡았다. 1차 로그에 기록된 `{id:null,title:null}` 허용 자체는 버그로 판정하지 않는다. 최종 fixture는 키 누락·0·문자열 id·배열 title을 거부하고, `(null,null)`, `(12,null)`, `(null,문자열)` 세 GET 조합이 유효함을 각각 단언한다. 검증자가 외부 문서를 요청하거나 서버를 호출하지 않았다.

1차 실행은 12 tests 중 7 PASS·5 FAIL, 355 assertions, exit 1이었다. 이후 타입 경계 케이스를 넓히고 읽기 전용 라우트 점검 1개를 추가해 최종 13개로 실행했다.

### 1차 실제 전체 출력

```text
POST_MATRIX_INVOCATIONS 15 GETS 15 POSTS 15
NESTED_PRODUCT_LEAK_KEYS ["type","type_name","quantity_mode","min_quantity","max_quantity","min_days","fixed_quantity","fixed_days","earliest_start_date"]
NESTED_FIELD_LEAK_KEYS ["label","type","required","help","contains"]
MALFORMED_FIELD_TYPE_POSTED ["array","null","int"]
MISSING_ID_EXCEPTION ErrorException:Undefined array key "id"
INVALID_ORDER_PRODUCTS_ACCEPTED [[],{"id":null,"title":null},{"id":0,"title":"zero"},{"id":12}]
{"tool":"phpunit","result":"failed","tests":12,"passed":7,"assertions":355,"duration_ms":528,"failed":5,"failures":[{"test":"IndependentRankfreeProbeTest::test_product_optional_keys_cannot_carry_nested_internal_fields","file":"/private/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/IndependentRankfreeProbeTest.php","line":148,"message":"Allowlisted product keys must reject or strip nested internal arrays\nFailed asserting that two arrays are identical.\n--- Expected\n+++ Actual\n@@ @@\n-Array &0 []\n+Array &0 [\n+    0 => 'type',\n+    1 => 'type_name',\n+    2 => 'quantity_mode',\n+    3 => 'min_quantity',\n+    4 => 'max_quantity',\n+    5 => 'min_days',\n+    6 => 'fixed_quantity',\n+    7 => 'fixed_days',\n+    8 => 'earliest_start_date',\n+]"},{"test":"IndependentRankfreeProbeTest::test_field_descriptors_cannot_carry_nested_internal_fields","file":"/private/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/IndependentRankfreeProbeTest.php","line":165,"message":"Field descriptor allowlists must not preserve nested internal arrays\nFailed asserting that two arrays are identical.\n--- Expected\n+++ Actual\n@@ @@\n-Array &0 []\n+Array &0 [\n+    0 => 'label',\n+    1 => 'type',\n+    2 => 'required',\n+    3 => 'help',\n+    4 => 'contains',\n+]"},{"test":"IndependentRankfreeProbeTest::test_non_string_field_types_cannot_reach_order_post","file":"/private/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/IndependentRankfreeProbeTest.php","line":179,"message":"Invalid upstream field types must be rejected before POST\nFailed asserting that two arrays are identical.\n--- Expected\n+++ Actual\n@@ @@\n-Array &0 []\n+Array &0 [\n+    0 => 'array',\n+    1 => 'null',\n+    2 => 'int',\n+]"},{"test":"IndependentRankfreeProbeTest::test_missing_product_identity_in_post_response_stays_safe_uncertain","file":"/private/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/IndependentRankfreeProbeTest.php","line":197,"message":"Malformed201 must not emit raw PHP errors\nFailed asserting that an instance of class ErrorException is an instance of class App\\Services\\Rankfree\\RankfreeException."},{"test":"IndependentRankfreeProbeTest::test_order_status_requires_valid_product_identity","file":"/private/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/IndependentRankfreeProbeTest.php","line":210,"message":"Order status cannot return missing/null/nonpositive identity as a valid order\nFailed asserting that two arrays are identical.\n--- Expected\n+++ Actual\n@@ @@\n-Array &0 []\n+Array &0 [\n+    0 => Array &1 [],\n+    1 => Array &2 [\n+        'id' => null,\n+        'title' => null,\n+    ],\n+    2 => Array &3 [\n+        'id' => 0,\n+        'title' => 'zero',\n+    ],\n+    3 => Array &4 [\n+        'id' => 12,\n+    ],\n+]"}]}
```

## 3. 실행 명령·실제 출력

임시 증거 폴더: `/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt`. 모든 명령은 저장소 루트에서 실행했다.

### 전체·주문 모듈

```sh
APP_CONFIG_CACHE=/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/config.php php artisan test --compact
APP_CONFIG_CACHE=/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/config.php php artisan test --compact --filter=RankfreeClientTest
```

첫 구현 기준선: 각 exit 0.

```text
{"tool":"phpunit","result":"passed","tests":71,"passed":71,"assertions":456,"duration_ms":7647}
{"tool":"phpunit","result":"passed","tests":11,"passed":11,"assertions":54,"duration_ms":298}
```

최종 수정본: 각 exit 0.

```text
{"tool":"phpunit","result":"passed","tests":74,"passed":74,"assertions":484,"duration_ms":9855}
{"tool":"phpunit","result":"passed","tests":14,"passed":14,"assertions":82,"duration_ms":395}
```

### 독립 공격

```sh
APP_CONFIG_CACHE=/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/config.php vendor/bin/phpunit --configuration phpunit.xml --no-progress /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/IndependentRankfreeProbeTest.php
```

최종 exit 0. 실제 전체 출력:

```text
POST_MATRIX_INVOCATIONS 15 GETS 15 POSTS 15
NESTED_PRODUCT_LEAK_KEYS []
NESTED_FIELD_LEAK_KEYS []
MALFORMED_FIELD_TYPE_POSTED []
MISSING_ID_EXCEPTION App\Services\Rankfree\RankfreeException:주문 접수 여부 확인이 필요합니다. 같은 주문을 다시 전송하지 마세요.
INVALID_ORDER_PRODUCTS_ACCEPTED []
{"tool":"phpunit","result":"passed","tests":13,"passed":13,"assertions":386,"duration_ms":246}
```

| 실행 시나리오 | 실제 확인 |
|---|---|
| 기본 비활성·미검수·키와 숫자 입력 경계 | API/주문 기본 false, 허용표 빈 배열; 빈/배열/CRLF/불량 키와 미승인 상품·수량/기간/쿠폰 0·음수는 요청 0 |
| 주문번호·고객 필드 경계 | 빈 번호·경로/쿼리/fragment 주입·65자·NUL·한글 거부. 미승인 키·null/object/중첩 배열/NAN/INF 입력은 요청 0 |
| GET 301/302/307/308 | 외부·내부 Location 8종을 각각 거부. callback의 URL은 고정 HTTPS이며 redirect 옵션은 false |
| POST 응답 15종 | 401/403/404/422/429는 rejected, 5xx/redirect/202/손상 201/다른 상품/완료 상태 201은 uncertain. 각 호출 GET 1회+POST 1회, 원문/미승인 field 제거 |
| 연결 오류 | uncertain, POST 1회, previous 예외·가짜 키 메시지 없음 |
| 승인키 아래 비정상 데이터 | 상품 9개 키·필드 5개 키의 중첩값 유출 차단. 비문자열·미지 타입·필수 FILE/IMAGE는 POST 전 차단 |
| 주문 응답 타입 | 키 누락·숫자/상태/주문번호/중첩 고객 필드 위반은 안전한 예외. 허용 null과 누락은 구분 |
| 정상 접수 | `pending`·‘접수’ 유지, 원격 total 407/discount 9 그대로, 미지 상위·product·fields 내부값 제거 |
| 공개 경계 | 활성 fixture에서도 customer orders/checkout/RankfreeClient 공개 라우트 없음 |

`rejected()` helper는 예상 `RankfreeException`만 포착한다. 단언 실패나 일반 PHP 오류를 성공으로 삼키지 않는다. 실패가 났던 5개 검사는 제품의 실제 반환·POST 횟수·예외 클래스를 비교한다.

### Pint·PHP 문법

```sh
vendor/bin/pint --test app/Services/Rankfree config/rankfree.php tests/Feature/RankfreeClientTest.php
```

exit 0. 소유 PHP 4파일에 `php -l`도 각각 실행했다.

```text
{"tool":"pint","result":"passed"}
No syntax errors detected in app/Services/Rankfree/RankfreeException.php
No syntax errors detected in app/Services/Rankfree/RankfreeClient.php
No syntax errors detected in config/rankfree.php
No syntax errors detected in tests/Feature/RankfreeClientTest.php
```

### Vite 격리 빌드

```sh
npm run build -- --config /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/vite.config.mjs --configLoader native
```

exit 0. 임시 envDir/outDir를 써서 `.env`와 실제 `public/build`를 건드리지 않았다. 아래는 ANSI 제어문자 제거 후 전체 출력이다.

```text

> build
> vite build --config /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/vite.config.mjs --configLoader native

vite v8.2.0 building client environment for production...

transforming...✓ 9 modules transformed.
rendering chunks...
computing gzip size...
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/build/manifest.json              0.33 kB │ gzip:  0.16 kB
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/build/assets/app-D_PS-FNm.css   97.94 kB │ gzip: 18.46 kB
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/build/assets/app-XOhwnyVw.js   159.36 kB │ gzip: 60.50 kB

✓ built in 1.69s

/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
```

기존 `hero-glow.webp` runtime 참조 경고가 있다. 실제 화면·미디어 존재는 이번 백엔드 범위에서 확인하지 않았다. npm에는 `build`, `dev`만 있으며 typecheck/lint/test 스크립트는 없다. PHP 스타일·테스트는 Pint/Artisan/PHPUnit으로 확인했다.

## 4. enabled guard 무력화 실험 1회

시작·복구를 부모에게 알리고, `RankfreeClient::request()`의 enabled 검사 블록만 제거했다. `try/finally`로 원문 bytes를 복구한 뒤 같은 테스트를 재실행했다.

```sh
APP_CONFIG_CACHE=/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/config.php php artisan test --compact --filter=RankfreeClientTest::test_disabled_missing_key_and_submission_gate_never_contact_remote
```

해시·종료 상태:

```json
{
  "before_sha256": "9812b2409e61a27518520c5e301d25a96f71ba47514b3e8188d6b70c8b2cfe14",
  "mutated_sha256": "3abc557d9b18abbfbcbfd38f2c6d42e3d3adc80f39e70088776e1bd43029b7e6",
  "mutated_exit": 2,
  "restored_sha256": "9812b2409e61a27518520c5e301d25a96f71ba47514b3e8188d6b70c8b2cfe14",
  "restored_bytes_equal": true,
  "restored_exit": 0
}
```

제거 시 exit 2로 실패했다. 외부 연결은 `preventStrayRequests()`가 차단했으며 실제 랭크프리 호출은 없었다. 복구 후 exit 0·1 test·5 assertions. 아래 복구 SHA는 부모의 이후 버그 수정 전 원본 해시이며, 최종 수정본 해시는 뒤 표에 따로 기록한다.

제거 시 실제 전체 출력:

```text
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":0,"duration_ms":206,"errors":1,"error_details":[{"test":"Tests\\Feature\\RankfreeClientTest::test_disabled_missing_key_and_submission_gate_never_contact_remote","file":"/Users/anarchy/Claude_Projects/jcurve/tests/Feature/RankfreeClientTest.php","line":27,"message":"Attempted request to [https://rankfree.kr/api/v1/products] without a matching fake."}]}
```

복구 후 실제 전체 출력:

```text
{"tool":"phpunit","result":"passed","tests":1,"passed":1,"assertions":5,"duration_ms":149}
```

## 5. 변경 경계·최종 파일 해시

`.env.example`에는 `RANKFREE_API_ENABLED=false`, 빈 `RANKFREE_API_KEY`, `RANKFREE_ORDER_SUBMISSION_ENABLED=false`와 안내 주석만 추가됐다. 모듈 외 라우트·DB·결제 엔진 추가는 없다. 라우트 registry 검사와 routes/bootstrap/composer/phpunit/package 통합 파일 8개의 작업 중 SHA 비교도 통과했다.

최종 전체·주문·독립 테스트 직전에 아래 제품 파일을 동결했고, 보고서 저장 직전에 다시 비교해 bytes가 같음을 확인했다.

```text
f526ed4f82d1a5642defc72780549360628978d539d9ebe94e493894a6d34800  app/Services/Rankfree/RankfreeException.php
94cfefe25a135230e75d4449cc973816ec345801982cdc47c4f16694627c6e75  app/Services/Rankfree/RankfreeClient.php
2e38c2f8c824c804c292859d48824551e8df3fe32a12d90bd0927106b209a5a1  config/rankfree.php
e8065411a88bdc974c80ef588bd4b8cb1b5f080614291f1e7deb30c5ae22e2cd  tests/Feature/RankfreeClientTest.php
c129f05d30964942cfdef6b81435da45c7133d8ab4575205a5ddd259d4e5e986  .env.example
```

통합부 작업 중 불변 스냅샷:

```text
f6d9fc84707d74c3dd5a4f82e8a35fedb14d0ef751910fca8f4317e7b84c51ef  routes/web.php
ae97a0c4ed28bd79ac0ff8c3a11539489518e1da4f17a3cf7a2b606b96dfd765  routes/auth.php
1695bc13ff9d8e38866a02610eac0dddc8d4b87bd4cb30b83ebb4a6187355d35  routes/seo.php
4c0a2661a5da867d8c0be3916151e87356e2312eeb714efda246089b77da0338  bootstrap/app.php
a443643d15a2ccc689ea4d365770c57e39365d8c37dbdd5741b0d016baff79b7  composer.json
5dbb1acf102eb4bb146950562404a3bf25c680edcdee893bff64911d54be82d3  composer.lock
493369cfb7feea104da4bec214c2cc6526ca2f1b9d937c50a2961fc59cb61aaf  phpunit.xml
ad1478c7b08c2c6d88f4f0a79801256ac6b086a72f589fac569a705de739f8f5  package.json
```

## 6. 남은 게이트·미검증

1. 고객별 랭크프리 계정인지 통합 계정인지 아직 결정되지 않았다. 이 모듈은 고객별 소유권·권한 판정을 제공하지 않는다.
2. 고객 인증·주문 소유권 원장·가격 동의·결제/잔액·주문 승인 게이트·영속 멱등성 원장·동시 재클릭 방지는 후속이다. 이번 증거는 **호출 1회의 자동 재시도 없음**이며 중복 주문 전체 방지 완료 증거가 아니다.
3. 상품 ID·고객 필드 운영자 검수와 공식 판매 허용표는 아직 비어 있다. 기본 플래그도 꺼져 있다. 공개 주문 UI·고객 조회 라우트는 추가되지 않았다.
4. 실제 API·테스트 주문·실제 키/권한·실계정 잔액·운영 DB·운영 서버 PHP/MySQL·프록시/네트워크 장애의 실연동은 미검증이다. 승인 전 서버 반영·실주문은 하지 않았다.
5. 독립 HTTP fixture의 프로토콜 검증이며 실제 공급자 API 전체 적합성 인증은 아니다. 브라우저·클라이언트 화면과 결제·정산 완주도 이번 범위가 아니다.
6. Claude 최종 제품 검수, 대표 확인, 서버 담당자 반영·공개 판단은 별도다.

## 부록 A. 독립 HTTP fixture 원문

다음 파일은 임시 폴더에서 실행했으며 그대로 보관한다. 네트워크는 fake/preventStrayRequests로 차단된다.

```php
<?php

use App\Services\Rankfree\RankfreeClient;
use App\Services\Rankfree\RankfreeException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IndependentRankfreeProbeTest extends TestCase
{
    private const KEY = 'rk_independent_fake_secret';
    private RankfreeClient $client;
    private array $defaults;

    protected function setUp(): void
    {
        parent::setUp();
        $this->defaults = config('rankfree');
        config(['rankfree.enabled' => true, 'rankfree.submission_enabled' => true,
            'rankfree.api_key' => self::KEY,
            'rankfree.product_fields' => [12 => ['place_url', 'tags', 'attachment']]]);
        Http::preventStrayRequests();
        $this->client = app(RankfreeClient::class);
    }

    private function product(): array
    {
        return ['id' => 12, 'title' => '검수 상품', 'orderable' => true, 'unit_price' => 250,
            'fields' => [
                ['key' => 'place_url', 'label' => 'URL', 'type' => 'URL', 'required' => true, 'api_supported' => true],
                ['key' => 'tags', 'label' => '태그', 'type' => 'TAGS', 'required' => false, 'api_supported' => true],
                ['key' => 'attachment', 'label' => '파일', 'type' => 'FILE', 'required' => false, 'api_supported' => false],
                ['key' => 'supplier_secret', 'label' => '관리용', 'type' => 'TEXT', 'required' => true, 'api_supported' => true],
            ]];
    }

    private function order(string $number = 'MO-INDEPENDENT'): array
    {
        return ['order_no' => $number, 'status' => 'pending', 'product' => ['id' => 12, 'title' => '검수 상품'],
            'quantity' => 17, 'days' => 6, 'unit_price' => 250, 'discount_amount' => 9, 'total_price' => 407,
            'fields' => ['place_url' => 'https://place.example/123'], 'created_at' => '2026-10-27T14:30:00+09:00'];
    }

    private function rejected(string $reason, callable $action): RankfreeException
    {
        try { $action(); $this->fail('Expected safe rejection: '.$reason); }
        catch (RankfreeException $e) {
            $this->assertSame($reason, $e->reason);
            $this->assertStringNotContainsString(self::KEY, $e->getMessage());
            $this->assertNull($e->getPrevious());
            return $e;
        }
    }

    public function test_default_flags_and_bad_configuration_send_no_requests(): void
    {
        $this->assertFalse($this->defaults['enabled']);
        $this->assertFalse($this->defaults['submission_enabled']);
        $this->assertSame([], $this->defaults['product_fields']);
        foreach ([null, '', [], "rk_invalid\r\nHeader: injected", 'Bearer rk_bad', 'rk_'] as $key) {
            config(['rankfree.api_key' => $key]);
            $this->rejected('not_configured', fn() => $this->client->products());
        }
        config(['rankfree.api_key' => self::KEY, 'rankfree.enabled' => false]);
        $this->rejected('disabled', fn() => $this->client->products());
        config(['rankfree.enabled' => true, 'rankfree.submission_enabled' => false]);
        $this->rejected('submission_disabled', fn() => $this->client->createOrder(12));
        config(['rankfree.submission_enabled' => true]);
        $this->rejected('product_not_approved', fn() => $this->client->createOrder(99));
        Http::assertNothingSent();
    }

    public function test_get_redirect_statuses_keep_fixed_host_and_disable_redirect_option(): void
    {
        $cases = [];
        foreach ([301, 302, 307, 308] as $status) {
            foreach (['https://external.invalid/steal', '/api/v1/private'] as $location) { $cases[] = [$status, $location]; }
        }
        $offset = 0;
        Http::fake(function(Request $request, array $options) use (&$offset, $cases) {
            $this->assertSame('https://rankfree.kr/api/v1/products', $request->url());
            $this->assertFalse($options['allow_redirects']);
            $this->assertSame(['Bearer '.self::KEY], $request->header('Authorization'));
            $this->assertStringNotContainsString(self::KEY, $request->url());
            [$status, $location] = $cases[$offset++];
            return Http::response(['message' => self::KEY], $status, ['Location' => $location]);
        });
        foreach ($cases as $_) { $this->rejected('rejected', fn() => $this->client->products()); }
        $this->assertSame(8, $offset);
        Http::assertSentCount(8);
    }

    public function test_post_response_failure_matrix_sends_one_post_per_invocation(): void
    {
        $cases = [];
        foreach ([401, 403, 404, 422, 429, 500, 503, 301, 302, 307, 308, 202] as $status) {
            $cases[] = [$status, ['message' => self::KEY, 'field' => 'f_supplier_secret'], in_array($status,[401,403,404,422,429],true) ? 'rejected' : 'submission_uncertain'];
        }
        $cases[] = [201, 'not-json', 'submission_uncertain'];
        $wrong = $this->order(); $wrong['product']['id'] = 99; $cases[] = [201, ['order' => $wrong], 'submission_uncertain'];
        $done = $this->order(); $done['status'] = 'completed'; $cases[] = [201, ['order' => $done], 'submission_uncertain'];
        $offset=0; $gets=0; $posts=0;
        Http::fake(function(Request $request, array $options) use (&$offset,&$gets,&$posts,$cases) {
            $this->assertFalse($options['allow_redirects']);
            $this->assertStringStartsWith('https://rankfree.kr/api/v1/', $request->url());
            if ($request->method()==='GET') { $gets++; return Http::response(['product'=>$this->product()]); }
            $posts++; [$status,$body]=$cases[$offset++];
            return Http::response($body,$status,['Location'=>'https://external.invalid/steal']);
        });
        foreach ($cases as [$_,$__, $reason]) {
            $e=$this->rejected($reason, fn()=>$this->client->createOrder(12, ['place_url'=>'https://place.example/123']));
            $this->assertNull($e->field);
        }
        $this->assertSame(count($cases), $gets);$this->assertSame(count($cases),$posts);
        Http::assertSentCount(count($cases)*2);
        fwrite(STDOUT, 'POST_MATRIX_INVOCATIONS '.count($cases).' GETS '.$gets.' POSTS '.$posts."\n");
    }

    public function test_connection_failure_is_uncertain_without_retry_or_secret_previous(): void
    {
        $posts=0;
        Http::fake(function(Request $request) use (&$posts) {
            if ($request->method()==='GET') { return Http::response(['product'=>$this->product()]); }
            $posts++;
            return Http::failedConnection(self::KEY);
        });
        $this->rejected('submission_uncertain',fn()=>$this->client->createOrder(12));
        $this->assertSame(1,$posts);
        Http::assertSentCount(2);
    }

    public function test_path_numeric_and_nested_input_boundaries_do_not_send_requests(): void
    {
        foreach (['', '../orders', 'A/B', 'A?key=value', 'A#fragment', str_repeat('X',65), "A\0B", '한글'] as $number) {
            $this->rejected('invalid_input',fn()=>$this->client->order($number));
        }
        foreach ([['supplier_secret'=>'x'], ['place_url'=>null], ['place_url'=>new stdClass], ['tags'=>[['nested'=>'x']]], ['tags'=>[NAN]], ['place_url'=>INF]] as $fields) {
            $this->rejected('invalid_input',fn()=>$this->client->createOrder(12,$fields));
        }
        foreach ([0,-1] as $value) {
            $this->rejected('invalid_input',fn()=>$this->client->createOrder(12,quantity:$value));
            $this->rejected('invalid_input',fn()=>$this->client->createOrder(12,days:$value));
            $this->rejected('invalid_input',fn()=>$this->client->createOrder(12,couponId:$value));
        }
        Http::assertNothingSent();
    }

    public function test_product_optional_keys_cannot_carry_nested_internal_fields(): void
    {
        $wire=$this->product();
        Http::fake(fn()=>Http::response(['product'=>$wire]));
        $leaks=[];
        foreach (['type','type_name','quantity_mode','min_quantity','max_quantity','min_days','fixed_quantity','fixed_days','earliest_start_date'] as $key) {
            $wire=$this->product();$wire[$key]=['supplier_secret'=>self::KEY];
            Http::swap(new Illuminate\Http\Client\Factory);
            Http::preventStrayRequests();
            Http::fake(fn()=>Http::response(['product'=>$wire]));
            try { $result=$this->client->product(12); if(str_contains(json_encode($result),self::KEY)){$leaks[]=$key;} }
            catch(RankfreeException $e){$this->assertSame('invalid_response',$e->reason);}
        }
        fwrite(STDOUT,'NESTED_PRODUCT_LEAK_KEYS '.json_encode($leaks)."\n");
        $this->assertSame([],$leaks,'Allowlisted product keys must reject or strip nested internal arrays');
    }

    public function test_field_descriptors_cannot_carry_nested_internal_fields(): void
    {
        $leaks=[];
        foreach (['label','type','required','help','contains'] as $key) {
            $wire=$this->product();$wire['fields'][0][$key]=['supplier_secret'=>self::KEY];
            Http::swap(new Illuminate\Http\Client\Factory);Http::preventStrayRequests();
            Http::fake(fn()=>Http::response(['product'=>$wire]));
            try{$result=$this->client->product(12);if(str_contains(json_encode($result),self::KEY)){$leaks[]=$key;}}
            catch(RankfreeException $e){$this->assertSame('invalid_response',$e->reason);}
        }
        fwrite(STDOUT,'NESTED_FIELD_LEAK_KEYS '.json_encode($leaks)."\n");
        $this->assertSame([],$leaks,'Field descriptor allowlists must not preserve nested internal arrays');
    }

    public function test_non_string_field_types_cannot_reach_order_post(): void
    {
        $posted=[];
        foreach ([['private'=>true],null,17,'UNREVIEWED_INTERNAL_WIDGET','FILE','IMAGE'] as $badType) {
            $wire=$this->product();$wire['fields'][0]['type']=$badType;$posts=0;
            Http::swap(new Illuminate\Http\Client\Factory);Http::preventStrayRequests();
            Http::fake(function(Request $request)use($wire,&$posts){
                if($request->method()==='GET'){return Http::response(['product'=>$wire]);}
                $posts++;return Http::response(['order'=>$this->order()],201);
            });
            try{$this->client->createOrder(12,['place_url'=>'https://place.example/123']);}
            catch(RankfreeException $e){$this->assertContains($e->reason,['invalid_response','invalid_input','not_orderable']);}
            if($posts>0){$posted[]=is_string($badType)?$badType:get_debug_type($badType);}
        }
        fwrite(STDOUT,'MALFORMED_FIELD_TYPE_POSTED '.json_encode($posted)."\n");
        $this->assertSame([],$posted,'Invalid upstream field types must be rejected before POST');
    }

    public function test_missing_product_identity_in_post_response_stays_safe_uncertain(): void
    {
        $wire=$this->order();$wire['product']=[];
        Http::fake(['https://rankfree.kr/api/v1/products/12'=>Http::response(['product'=>$this->product()]),
            'https://rankfree.kr/api/v1/orders'=>Http::response(['order'=>$wire],201)]);
        $caught=null;
        try{$this->client->createOrder(12);}catch(Throwable $e){$caught=$e;}
        fwrite(STDOUT,'MISSING_ID_EXCEPTION '.($caught?get_class($caught).':'.$caught->getMessage():'none')."\n");
        $this->assertInstanceOf(RankfreeException::class,$caught,'Malformed201 must not emit raw PHP errors');
        $this->assertSame('submission_uncertain',$caught->reason);
        Http::assertSentCount(2);
    }

    public function test_order_status_requires_present_valid_or_explicitly_nullable_identity(): void
    {
        $accepted=[];
        foreach ([[],['id'=>0,'title'=>'zero'],['id'=>12],['id'=>'12','title'=>'bad-type'],['id'=>12,'title'=>[]]] as $badProduct) {
            $wire=$this->order();$wire['product']=$badProduct;
            Http::swap(new Illuminate\Http\Client\Factory);Http::preventStrayRequests();Http::fake(fn()=>Http::response(['order'=>$wire]));
            try{$result=$this->client->order('MO-INDEPENDENT');$accepted[]=$result['product'];}
            catch(RankfreeException $e){$this->assertSame('invalid_response',$e->reason);}
        }
        fwrite(STDOUT,'INVALID_ORDER_PRODUCTS_ACCEPTED '.json_encode($accepted)."\n");
        $this->assertSame([],$accepted,'Order status cannot return missing/nonpositive/incorrectly-typed identity as a valid order');
        foreach ([['id'=>null,'title'=>null],['id'=>12,'title'=>null],['id'=>null,'title'=>'삭제된 상품']] as $nullableProduct) {
            $wire=$this->order();$wire['product']=$nullableProduct;
            Http::swap(new Illuminate\Http\Client\Factory);Http::preventStrayRequests();Http::fake(fn()=>Http::response(['order'=>$wire]));
            $this->assertSame($nullableProduct,$this->client->order('MO-INDEPENDENT')['product'],'Explicit null identity is permitted by the documented GET contract');
        }

    }

    public function test_order_unknown_status_mismatch_and_malformed_numbers_are_safe(): void
    {
        $cases=[];
        foreach (['unknown',[],null] as $state){$wire=$this->order();$wire['status']=$state;$cases[]=$wire;}
        foreach (['unit_price','discount_amount','total_price','quantity'] as $key){foreach([-1,1.25,'100',[]]as$value){$wire=$this->order();$wire[$key]=$value;$cases[]=$wire;}}
        $wire=$this->order('MO-OTHER');$cases[]=$wire;
        $wire=$this->order();$wire['fields']['place_url']=['nested'=>self::KEY];$cases[]=$wire;
        $wire=$this->order();$wire['days']=0;$cases[]=$wire;
        foreach($cases as$wire){
            Http::swap(new Illuminate\Http\Client\Factory);Http::preventStrayRequests();Http::fake(fn()=>Http::response(['order'=>$wire]));
            $this->rejected('invalid_response',fn()=>$this->client->order('MO-INDEPENDENT'));
        }
    }

    public function test_valid_order_keeps_remote_prices_pending_and_filters_unknown_fields(): void
    {
        $wire=$this->order();$wire['api_key']=self::KEY;$wire['product']['supplier_secret']=self::KEY;$wire['fields']['supplier_secret']=self::KEY;
        Http::fake(['https://rankfree.kr/api/v1/products/12'=>Http::response(['product'=>$this->product()]),
            'https://rankfree.kr/api/v1/orders'=>Http::response(['order'=>$wire,'private'=>self::KEY],201)]);
        $result=$this->client->createOrder(12,['place_url'=>'https://place.example/123'],17,6);
        $this->assertSame('pending',$result['status']);$this->assertSame('접수',$result['status_label']);
        $this->assertSame(407,$result['total_price']);$this->assertSame(9,$result['discount_amount']);
        $this->assertStringNotContainsString(self::KEY,json_encode($result));
        Http::assertSentCount(2);
    }

    public function test_no_public_order_routes_are_registered_by_the_adapter(): void
    {
        $found=[];
        foreach (Illuminate\Support\Facades\Route::getRoutes() as $route) {
            if (str_contains($route->getActionName(),'RankfreeClient') || preg_match('~(^|/)(orders|checkout)(/|$)~',$route->uri())) {
                $found[]=$route->uri();
            }
        }
        $this->assertSame([],$found,'Flags must not expose customer ordering without the ownership and duplicate ledger gates');
    }
}
```

## 부록 B. 환경·빌드 격리 원문

`make-safe-config.php`:

```php
<?php
require '/Users/anarchy/Claude_Projects/jcurve/vendor/autoload.php';
$app = require '/Users/anarchy/Claude_Projects/jcurve/bootstrap/app.php';
$app->useEnvironmentPath(__DIR__);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
file_put_contents(__DIR__.'/config.php', '<?php return '.var_export($app['config']->all(), true).';');
echo "Safe config generated without repository .env\n";
```

실제 생성 명령:

```sh
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= APP_URL=http://localhost DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= CACHE_STORE=array SESSION_DRIVER=array QUEUE_CONNECTION=sync MAIL_MAILER=array BROADCAST_CONNECTION=null RANKFREE_API_ENABLED=false RANKFREE_API_KEY= RANKFREE_ORDER_SUBMISSION_ENABLED=false php /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/make-safe-config.php
```

`vite.config.mjs`:

```js
import base from '/Users/anarchy/Claude_Projects/jcurve/vite.config.js';
export default { ...base, envDir: '/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt', build: { ...base.build, outDir: '/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order-verify-yur9wbqt/build', emptyOutDir: true } };
```
