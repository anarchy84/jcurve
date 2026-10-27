# BACKEND-ORDER-02 독립 검증 결과

검증일: 2026-10-27 · 작업 폴더: `/Users/anarchy/Claude_Projects/jcurve` · 계약 기준: `main / f2f7f61`(지시서 기재값, 이번 검증에서 git 명령 미사용)

**로컬 고객별 Credential·서버 클라이언트 검증: PASS.** 전체 **80 tests / 522 assertions**, 주문 모듈 **20 / 120**, 이전 ORDER01 독립 회귀 **13 / 385**, 추가 고객 경계 공격 **6 / 191**을 실제 실행해 통과했다. 추가 독립 PHP subprocess의 비밀 출력·예외·직렬화 검사는 별도로 **897 checks**가 통과했다. Pint 6파일·PHP 문법 6파일·격리 Vite 빌드도 통과했다.

검증자가 제품과 구현자 테스트를 수정하지 않았다. 지정된 customerId 불일치 가드 무력화 1회만 수행했고 try/finally로 원문을 복구했다. 영구 산출물은 이 보고서 하나다. **최종 제품 판정·실제 계정 연결·실연동·배포·공개 승인은 별도**다.

## 1. 범위·격리

- AGENTS.md, COLLAB, QUEUE, ORDER02 계약/검증 지시서, 필수 tri-agent 스킬을 읽었다. 부모가 제품/테스트를 동결하고 대시보드를 맡았다.
- 실제 `.env`를 열거나 로드·변경하지 않았다. 빈 임시 환경 경로에서 config를 생성했고, 테스트 프로세스는 그 config를 `APP_CONFIG_CACHE`로 사용했다. 실행 환경은 명시한 가짜 APP_KEY, SQLite `:memory:`, array 캐시/세션/메일, sync queue로 제한했다. config 생성은 저장소 `.env` 경로를 바라보지 않는다.
- 키는 `rk_probe_customer_A_secret`, `rk_probe_customer_B_secret`, `rk_probe_global_fallback_secret` 등 fixture 표식만 사용했다. 실제 키/외부 API/실주문/실DB/브라우저/프론트 변경/git/배포를 수행하지 않았다. 주문 HTTP는 fake/preventStrayRequests로 차단했다.
- Vite의 envDir/outDir도 임시 폴더다. `public/build`나 미디어를 수정하지 않았다.
- PHP CLI는 **8.5.8**, PHPUnit은 **12.5.33**이다. `SensitiveParameterValue`가 native internal class인지 실행으로 확인했다. PHP 8.3 서버 런타임은 별도 게이트다.
- 증거 폴더: `/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd`. 재현 원문과 주요 출력은 아래 부록에 보존했다.

## 2. 계약과 독립 공격 대조

| 계약·제품 위치 | 독립 입력·관측 | 결과 |
|---|---|---|
| 생성 시 고객 경계 · RankfreeClient.php:25 | null 연결, 0/음수 인증ID, A 인증ID+B Credential, 반대 조합, 큰 양수 불일치. 전역 모의 키가 있어도 연결없음·불일치를 HTTP 전에 거부 | PASS, HTTP 0 |
| Credential 입력 · CustomerCredential.php:15 | 고객ID 0/음수/PHP_INT_MIN, 빈/rk_/Bearer/CRLF/NUL/공백/비ASCII 키. strict fixture의 null/배열/객체/숫자/bool 키는 TypeError | PASS, HTTP 0 |
| 동일 주문번호·고객 요청별 분리 · RankfreeClient.php:23, :120, :134 | 같은 `MO-SHARED`를 A/B/A/B 조회. 고객별 상품명 A/B와 total 117/223을 반환하고 Bearer A/B/A/B를 단언. 그 사이 오래된 global api_key를 다른 값/null로 변경 | PASS, 호출 4회, 결과 혼합 없음 |
| preflight→POST→status 키 고정 · :80, :134 | Fiber로 A 상품상세 GET을 중단→B GET 중단→전역키 변경→A POST 중단→B POST 중단→각 완료→A/B 상태 조회. 6개 요청 각각의 Bearer·HTTPS·redirect=false·POST body를 단언 | PASS, 교차 순서 아래 로그와 동일 |
| 생성 후 불변·무인증 기본 생성 방지 · :23, CustomerCredential.php:13 | customerId/key/client credential을 ReflectionProperty로 바꾸려 하면 readonly 오류. private constructor 직접 생성/컨테이너 기본 생성 거절. Reflection으로 비초기화 객체를 만들어도 HTTP 전 초기화 오류 | PASS, HTTP 0 |
| 객체 출력·native 비밀 래핑 · CustomerCredential.php:24, :33, :38, RankfreeClient.php:42 | Credential/client/둘의 배열을 JSON·var_dump·print_r·var_export. native SensitiveParameterValue 확인. Credential JSON은 customer_id만 반환 | PASS, 키 표식 없음 |
| 직렬화/복원 금지 · CustomerCredential.php:42, :47 | Credential/client/중첩 배열 serialize 3종과 customerId 0/1/202의 조작 serialized Credential 복원 3종 | PASS, 모두 LogicException |
| 예외 문자열/trace 비밀 차단 · CustomerCredential.php:15, RankfreeClient.php:25, :134 | `zend.exception_ignore_args=0`으로 불량키·0고객ID·불일치·원격 403·연결 오류를 발생시킨 뒤 문자열/message/trace-string/예외 object/trace-array의 4출력 검사 | PASS, 직렬화 예외 포함 standalone 897 checks |
| 공용 키 fallback 제거 · config/rankfree.php, .env.example | 제품 config에 api_key 항목 없음. 예제 env에는 공용키 할당 없음. 모듈의 고객 키는 오래된 global 설정의 값/변경에 영향받지 않음 | PASS |
| ORDER01 가격·상태·필터·오류·HTTP 경계 유지 | 이전 독립 fixture의 공격 단언문을 유지하고 생성 부분과 키 부재 입력 경계만 새 factory에 이식. pending/서버 total·discount 유지, 고정 HTTPS·리다이렉트 거부·POST 1회·불명 응답·중첩 응답·nullable 상품 식별자 검사 | PASS, 13 / 385 |

독립 helper는 예상 RankfreeException만 잡는다. 단언 실패/일반 PHP 오류를 성공으로 삼키지 않는다. standalone 출력 검사는 하나라도 거짓이면 exit 1이며, PHPUnit에서 그 subprocess의 exit와 결과 수를 다시 단언한다. 키를 삭제/마스킹한 출력으로 단언하지 않는다.

직렬화·예외 검사 초기 준비본은 PHPUnit 자체의 trace args를 덤프해 TestCase→Laravel 테스트 컨테이너→HTTP fake 기록을 재귀 탐색했다. 이 과정에서 순환참조 경고와 테스트 컨테이너에 저장된 모의 키가 발견됐다. 이를 모듈 유출로 판정하지 않고 같은 비밀 검사를 PHPUnit 밖의 격리 PHP 프로세스로 옮겼다. 모듈·실제 호출 trace에 대한 키 검사 단언은 유지했고 최종 원문을 부록에 보존했다.

ORDER01 역사 결과의 13/386과 이번 13/385는 별개다. 이전 `api_key` config를 바꾸던 부재키 검사를 새 생성 계약으로 이식하면서 null/배열은 TypeError, null 연결은 account_not_connected로 검사한다. 기존 응답·금액·리다이렉트·POST 횟수 단언은 줄이지 않았다.

## 3. 실행 명령·실제 출력

명령은 아래 안전 실행기(run.py)가 부록의 safe-environment.json만 넘긴 상태로 저장소 루트에서 실행했다. 이는 저장소 `.env`를 로드하는 composer test/config:clear를 실행하지 않기 위한 격리다.

```sh
python3 /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/run.py full php artisan test --compact
python3 /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/run.py order-module-final php artisan test --compact --filter=Rankfree
python3 /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/run.py order01-regression vendor/bin/phpunit --configuration phpunit.xml --no-progress /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/IndependentRankfreeProbeTest.php
python3 /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/run.py independent-customer-isolated vendor/bin/phpunit --configuration phpunit.xml --no-progress /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/IndependentRankfreeCustomerProbeTest.php
python3 /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/run.py build npm run build -- --config /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/vite.config.mjs --configLoader native
```

각 exit 0. 전체/주문 실제 요약:

```text
............................................................................
  ....

  Tests:    80 passed (522 assertions)
  Duration: 5.44s

....................

  Tests:    20 passed (120 assertions)
  Duration: 3.88s
```

독립 ORDER01 실제 출력:

```text
PHPUnit 12.5.33 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.5.8
Configuration: /Users/anarchy/Claude_Projects/jcurve/phpunit.xml

POST_MATRIX_INVOCATIONS 15 GETS 15 POSTS 15
NESTED_PRODUCT_LEAK_KEYS []
NESTED_FIELD_LEAK_KEYS []
MALFORMED_FIELD_TYPE_POSTED []
MISSING_ID_EXCEPTION App\Services\Rankfree\RankfreeException:주문 접수 여부 확인이 필요합니다. 같은 주문을 다시 전송하지 마세요.
INVALID_ORDER_PRODUCTS_ACCEPTED []
Time: 00:00.209, Memory: 42.50 MB

OK (13 tests, 385 assertions)
```

독립 고객 공격 실제 출력:

```text
PHPUnit 12.5.33 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.5.8
Configuration: /Users/anarchy/Claude_Projects/jcurve/phpunit.xml

SAME_ORDER_NUMBER_OWNERS ["A","B","A","B"]
INTERLEAVED_HTTP ["A:GET:\/api\/v1\/products\/12","B:GET:\/api\/v1\/products\/12","A:POST:\/api\/v1\/orders","B:POST:\/api\/v1\/orders","A:GET:\/api\/v1\/orders\/MO-SHARED","B:GET:\/api\/v1\/orders\/MO-SHARED"]
ISOLATED_SECRET_PROBE {"passed":true,"checks":897,"serialize_blocked":3,"restore_blocked":3,"exception_cases":5,"trace_args":"0"}
Time: 00:00.510, Memory: 42.50 MB

OK (6 tests, 191 assertions)
```

Pint는 **임시 작업 폴더**에서 `APP_CONFIG_CACHE` 없이 저장소의 절대경로 6 PHP 파일만 `--test`로 확인했다. PHP 앱 config 캐시를 Pint의 Laravel Zero phar에 넘긴 최초 시도는 `Class "Illuminate\Auth\AuthServiceProvider" not found`(exit 255)였고, Pint 자체 실행 환경을 분리한 뒤 아래와 같이 통과했다. 제품 파일을 변경해 해결하지 않았다.

```text
......

  ──────────────────────────────────────────────────────────────────── Laravel  
    PASS   ........................................................... 6 files

No syntax errors detected in app/Services/Rankfree/CustomerCredential.php
No syntax errors detected in app/Services/Rankfree/RankfreeClient.php
No syntax errors detected in app/Services/Rankfree/RankfreeException.php
No syntax errors detected in config/rankfree.php
No syntax errors detected in tests/Feature/RankfreeClientTest.php
No syntax errors detected in tests/Feature/RankfreeCustomerIsolationTest.php
```

npm 스크립트에는 build/dev만 있으며 typecheck/lint/test는 없다. PHP 테스트는 Artisan/PHPUnit, 스타일은 Pint로 확인했다.

격리 빌드 실제 출력:

```text
> build
> vite build --config /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/vite.config.mjs --configLoader native

vite v8.2.0 building client environment for production...

transforming...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
✓ 9 modules transformed.
rendering chunks...
computing gzip size...
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/build/manifest.json              0.33 kB │ gzip:  0.16 kB
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/build/assets/app-D_PS-FNm.css   97.94 kB │ gzip: 18.46 kB
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/build/assets/app-XOhwnyVw.js   159.36 kB │ gzip: 60.50 kB

✓ built in 941ms
```

기존 `/media/bg/hero-glow.webp` 런타임 참조 경고는 남아 있다. 프론트·실제 미디어 화면은 이번 백엔드 판정 범위가 아니다.

## 4. customerId 가드 무력화 1회·원문 복구

시작/복구를 부모에게 알렸다. 제거한 내용은 `forCustomer()`의 아래 3줄만이다.

```php
        if ($credential->customerId !== $authenticatedCustomerId) {
            throw new RankfreeException('account_mismatch');
        }
```

실행 대상:

```sh
APP_CONFIG_CACHE=/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/config.php php artisan test --compact --filter=RankfreeCustomerIsolationTest::test_unlinked_or_wrong_customer_cannot_fall_back_to_global_key
```

무력화 후 실제 출력(exit 1):

```text
⨯
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RankfreeCustomerIsolationTest…  AssertionFailedError   
  Expected account_mismatch

  at tests/Feature/RankfreeCustomerIsolationTest.php:146
    142▕     private function reason(string $reason, callable $action): RankfreeException
    143▕     {
    144▕         try {
    145▕             $action();
  ➜ 146▕             $this->fail('Expected '.$reason);
    147▕         } catch (RankfreeException $exception) {
    148▕             $this->assertSame($reason, $exception->reason);
    149▕ 
    150▕             return $exception;

  1   tests/Feature/RankfreeCustomerIsolationTest.php:146
  2   tests/Feature/RankfreeCustomerIsolationTest.php:30


  Tests:    1 failed (3 assertions)
  Duration: 0.28s
```

`try/finally` 원문 복구 후 같은 테스트 실제 출력(exit 0):

```text
.

  Tests:    1 passed (4 assertions)
  Duration: 0.14s
```

```json
{
  "before_sha256": "9e02dd95db0a61cd0a5b64fa0e2a051164479b268cbc28e5afd5e6a6674e9cf6",
  "command": [
    "php",
    "artisan",
    "test",
    "--compact",
    "--filter=RankfreeCustomerIsolationTest::test_unlinked_or_wrong_customer_cannot_fall_back_to_global_key"
  ],
  "mutated_sha256": "6dfa37c5e8a58113e91b9ff43c3f3cc3c12d8b45909bcc58e9b8a878e90b2e60",
  "mutated_exit": 1,
  "restored_sha256": "9e02dd95db0a61cd0a5b64fa0e2a051164479b268cbc28e5afd5e6a6674e9cf6",
  "restored_bytes_equal": true,
  "restored_exit": 0
}
```

불일치 방어를 제거하면 테스트가 실제로 빨개진다. 예상 예외가 없을 때 helper가 `AssertionFailedError`를 전파했다. 정상 제품의 버그를 고친 것이 아니라 지정된 가드 제거/복구만 수행했다. 복구 뒤 주문 모듈 전체 20/120도 다시 통과했다.

## 5. 파일 보존·최종 SHA256

무력화 복구 직후 첫 확인에서는 동결한 8파일의 SHA256이 모두 동일했다. 최종 보고 직전 부모가 계약 상태를 갱신해 `docs/BACKEND-ORDER-02.md`만 변경됐으며, 제품/설정/env 예제/구현자 테스트 7파일은 여전히 시작 SHA와 같다. 계약 문서의 시작 SHA는 `42f038bb6e701e04920537cbd8eebdae7b100defd88aabf7dd2c9fe436673c33`, 최종 SHA는 아래 값이다. 부모의 문서 변경을 되돌리지 않았다. 라우트/DB·마이그레이션/모델·인증·HTTP/리소스/미디어·정적에셋/bootstrap의 기존 293파일은 시작/끝 크기·mtime_ns가 같았다. 이 293개는 stat 비교이며 전체 바이트 해시 증거로 과장하지 않는다. `.env` 자체를 열거나 변경하지 않았다. 대시보드는 부모 소유다.

```text
c79c29485156ae4437cbcdcdf2687a54e09b9d3f92599b33cd53707a259fd6e6  app/Services/Rankfree/CustomerCredential.php
9e02dd95db0a61cd0a5b64fa0e2a051164479b268cbc28e5afd5e6a6674e9cf6  app/Services/Rankfree/RankfreeClient.php
bdf41ecf21d20139337620ca755a51fe03161e7da50dd9b40c9ad74c022b66b9  app/Services/Rankfree/RankfreeException.php
fba06e6ccf356a3297e456356f5516e260dcb27531851bc255d9540f68f30ab5  config/rankfree.php
6d3727e8400589e6f85604e5ca5dec3f0dd7c2b5b85164f92d1d70877de33aa6  .env.example
ea86f3d2b3ab34a08af83b5d80c797f5c3b690d58b2c4defba81df5ae7d8775a  tests/Feature/RankfreeClientTest.php
c66038a1a06101d5b91fe27a781512aa48d866ce09f78a60941a5dbfc114970a  tests/Feature/RankfreeCustomerIsolationTest.php
b46f45b1d52ef81bedb41b3f08b566cb97836b1608658415fb910a707ac6c20c  docs/BACKEND-ORDER-02.md
```

검증자 영구 변경 파일: `docs/BACKEND-ORDER-02-VERIFY-RESULT.md` 하나. 보고서 자체 SHA는 자기참조를 피하기 위해 부모에게 별도로 반환한다.

## 6. 남은 게이트·미검증

1. 고객별 계정 방향은 이미 확정이다. 실제 연결 등록/키 소유자·order 권한 증명/암호화 영속 저장/복호화·해제/로그인·SSO는 아직 구현·검증하지 않았다.
2. `forCustomer()`는 제공된 정수 고객ID와 Credential.customerId의 일치만 검사한다. 서버 인증 결과와 올바른 저장 레코드를 전달하는 계층은 별도다. 이 메모리 객체를 생성할 수 있다는 사실은 로그인·주문 소유권 증명이 아니다. `authorizationKey()`는 서버 전송용 raw 키 반환 함수이므로 그 반환값을 직접 로그하는 호출자까지 보호하는 기능으로 주장하지 않는다.
3. 공개 고객 주문 라우트·주문 소유권/권한 원장·결제/잔액/가격 동의·영속 멱등성/중복 주문·실제 동시 요청 운영은 후속이다. Fiber 결과는 이 서버 객체의 교차 실행 격리 증거다.
4. 상품 검수 허용표는 빈 값이고 API/주문 플래그는 기본 false다. 실제 공급자 응답·실제 계정 권한·주문·서버 PHP8.3/MySQL·운영 네트워크는 검증하지 않았다.
5. Claude 최종 diff/제품 검수, 대표 검수, 서버 담당자의 반영·공개 판단은 별도다. 커밋/푸시/배포/발행은 수행하지 않았다.

## 부록 A. 고객 경계 독립 fixture 원문

`IndependentRankfreeCustomerProbeTest.php`:

```php
<?php

declare(strict_types=1);

use App\Services\Rankfree\CustomerCredential;
use App\Services\Rankfree\RankfreeClient;
use App\Services\Rankfree\RankfreeException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

final class IndependentRankfreeCustomerProbeTest extends TestCase
{
    private const A = 'rk_probe_customer_A_secret';
    private const B = 'rk_probe_customer_B_secret';
    private const G = 'rk_probe_global_fallback_secret';

    protected function setUp(): void
    {
        parent::setUp();
        config(['rankfree.enabled' => true, 'rankfree.submission_enabled' => true,
            'rankfree.api_key' => self::G, 'rankfree.product_fields' => [12 => []]]);
        Http::preventStrayRequests();
    }

    private function client(int $id, string $key): RankfreeClient
    {
        return RankfreeClient::forCustomer($id, new CustomerCredential($id, $key));
    }

    private function product(string $owner): array
    {
        return ['id' => 12, 'title' => $owner, 'unit_price' => 200, 'orderable' => true, 'fields' => []];
    }

    private function order(string $owner): array
    {
        return ['order_no' => 'MO-SHARED', 'status' => 'pending', 'product' => ['id' => 12, 'title' => $owner],
            'quantity' => 1, 'days' => null, 'unit_price' => 200, 'discount_amount' => 0,
            'total_price' => $owner === 'A' ? 117 : 223, 'fields' => [], 'created_at' => '2026-10-27T14:00:00+09:00'];
    }

    private function reason(string $reason, callable $call): Throwable
    {
        try { $call(); $this->fail('Expected rejection: '.$reason); }
        catch (RankfreeException $e) {
            $this->assertSame($reason, $e->reason);
            $this->assertNull($e->getPrevious());
            return $e;
        }
    }

    private function renderings(mixed $value): array
    {
        ob_start(); var_dump($value); $dump = ob_get_clean();
        set_error_handler(static function (int $level, string $message): bool {
            if ($message === 'var_export does not handle circular references') { return true; }
            return false;
        });
        try { $export = var_export($value, true); } finally { restore_error_handler(); }
        return [$dump, print_r($value, true), $export, json_encode($value, JSON_PARTIAL_OUTPUT_ON_ERROR)];
    }

    private function noSecrets(mixed $value): void
    {
        foreach ($this->renderings($value) as $rendered) {
            foreach ([self::A, self::B, self::G, 'rk_bad_probe_secret'] as $marker) {
                $this->assertStringNotContainsString($marker, $rendered);
            }
        }
    }

    public function test_same_number_alternation_has_no_customer_or_global_cache(): void
    {
        $a = $this->client(101, self::A); $b = $this->client(202, self::B); $seen = [];
        Http::fake(function (Request $r, array $options) use (&$seen) {
            $token = $r->header('Authorization');
            $this->assertCount(1, $token);
            $this->assertContains($token[0], ['Bearer '.self::A, 'Bearer '.self::B]);
            $this->assertSame('GET', $r->method());
            $this->assertSame('https://rankfree.kr/api/v1/orders/MO-SHARED', $r->url());
            $this->assertFalse($options['allow_redirects']);
            $owner = $token[0] === 'Bearer '.self::A ? 'A' : 'B'; $seen[] = $owner;
            return Http::response(['order' => $this->order($owner)]);
        });
        foreach ([[$a,'A',117],[$b,'B',223],[$a,'A',117],[$b,'B',223]] as [$client,$owner,$total]) {
            config(['rankfree.api_key' => $owner === 'A' ? 'rk_changed_global_1' : null]);
            $result = $client->order('MO-SHARED');
            $this->assertSame($owner, $result['product']['title']); $this->assertSame($total, $result['total_price']);
        }
        $this->assertSame(['A','B','A','B'], $seen); Http::assertSentCount(4);
        $this->assertNotSame($a, $this->client(101, self::A));
        fwrite(STDOUT, 'SAME_ORDER_NUMBER_OWNERS '.json_encode($seen)."\n");
    }

    public function test_interleaved_preflight_post_and_status_pin_each_customer_key(): void
    {
        $a = $this->client(101, self::A); $b = $this->client(202, self::B); $seen = [];
        Http::fake(function (Request $r, array $options) use (&$seen) {
            $token = $r->header('Authorization');
            $this->assertCount(1, $token); $this->assertContains($token[0], ['Bearer '.self::A, 'Bearer '.self::B]);
            $owner = $token[0] === 'Bearer '.self::A ? 'A' : 'B';
            $this->assertFalse($options['allow_redirects']);
            $this->assertStringStartsWith('https://rankfree.kr/api/v1/', $r->url());
            $this->assertStringNotContainsString('rk_', $r->url());
            $seen[] = $owner.':'.$r->method().':'.parse_url($r->url(), PHP_URL_PATH);
            if (str_ends_with($r->url(), '/products/12')) {
                Fiber::suspend($owner.':GET'); return Http::response(['product' => $this->product($owner)]);
            }
            if ($r->method() === 'POST') {
                $this->assertSame(['product_id','fields'], array_keys($r->data()));
                Fiber::suspend($owner.':POST'); return Http::response(['order' => $this->order($owner)], 201);
            }
            return Http::response(['order' => $this->order($owner)]);
        });
        $fa = new Fiber(fn () => $a->createOrder(12)); $fb = new Fiber(fn () => $b->createOrder(12));
        $this->assertSame('A:GET', $fa->start()); $this->assertSame('B:GET', $fb->start());
        config(['rankfree.api_key' => 'rk_switched_during_inflight']);
        $this->assertSame('A:POST', $fa->resume()); $this->assertSame('B:POST', $fb->resume());
        $fa->resume(); $fb->resume();
        $this->assertTrue($fa->isTerminated()); $this->assertTrue($fb->isTerminated());
        $this->assertSame('A', $fa->getReturn()['product']['title']); $this->assertSame('B', $fb->getReturn()['product']['title']);
        $this->assertSame(117, $a->order('MO-SHARED')['total_price']);
        $this->assertSame(223, $b->order('MO-SHARED')['total_price']);
        $this->assertSame(['A:GET:/api/v1/products/12','B:GET:/api/v1/products/12',
            'A:POST:/api/v1/orders','B:POST:/api/v1/orders',
            'A:GET:/api/v1/orders/MO-SHARED','B:GET:/api/v1/orders/MO-SHARED'], $seen);
        Http::assertSentCount(6); fwrite(STDOUT, 'INTERLEAVED_HTTP '.json_encode($seen)."\n");
    }

    public function test_missing_mismatch_invalid_id_and_invalid_key_fail_before_http(): void
    {
        foreach ([0,-1,PHP_INT_MIN] as $id) {
            $this->reason('invalid_input', fn () => new CustomerCredential($id, self::A));
            $this->reason('account_not_connected', fn () => RankfreeClient::forCustomer($id, new CustomerCredential(101, self::A)));
        }
        foreach ([1,101,PHP_INT_MAX] as $id) { $this->reason('account_not_connected', fn () => RankfreeClient::forCustomer($id, null)); }
        foreach ([[101,202],[202,101],[PHP_INT_MAX,1]] as [$auth,$owner]) {
            $this->reason('account_mismatch', fn () => RankfreeClient::forCustomer($auth, new CustomerCredential($owner, self::A)));
        }
        foreach (['','rk_','Bearer '.self::A,"rk_bad_probe_secret\r\nInjected: yes","rk_bad_probe_secret\0",' rk_whitespace','rk_한글'] as $key) {
            $this->reason('not_configured', fn () => new CustomerCredential(101, $key));
        }
        foreach ([null, [], new stdClass, 1, true] as $key) {
            try { new CustomerCredential(101, $key); $this->fail('Expected typed rejection'); }
            catch (TypeError $e) { $this->assertInstanceOf(TypeError::class, $e); }
        }
        Http::assertNothingSent();
    }

    public function test_context_is_readonly_and_default_constructor_cannot_send(): void
    {
        $credential = new CustomerCredential(101, self::A); $client = RankfreeClient::forCustomer(101, $credential);
        foreach (['customerId' => 202,'key' => new SensitiveParameterValue(self::B)] as $name => $value) {
            try { (new ReflectionProperty($credential, $name))->setValue($credential, $value); $this->fail('Expected readonly rejection'); }
            catch (Error $e) { $this->assertStringContainsString('readonly', $e->getMessage()); }
        }
        try { (new ReflectionProperty($client, 'credential'))->setValue($client, new CustomerCredential(202, self::B)); $this->fail('Expected readonly rejection'); }
        catch (Error $e) { $this->assertStringContainsString('readonly', $e->getMessage()); }
        $this->assertSame(101, $credential->customerId); $this->assertSame(101, $client->customerId());
        $this->assertSame(self::A, $credential->authorizationKey());
        $this->assertTrue((new ReflectionMethod(RankfreeClient::class, '__construct'))->isPrivate());
        try { new RankfreeClient; $this->fail('Expected private constructor failure'); }
        catch (Error $e) { $this->assertStringContainsString('private', $e->getMessage()); }
        try { app(RankfreeClient::class); $this->fail('Container must not supply default client'); }
        catch (Illuminate\Contracts\Container\BindingResolutionException $e) { $this->assertStringContainsString('not instantiable', $e->getMessage()); }
        $empty = (new ReflectionClass(RankfreeClient::class))->newInstanceWithoutConstructor();
        try { $empty->products(); $this->fail('Uninitialized bypass must not send'); }
        catch (Error $e) { $this->assertStringContainsString('must not be accessed before initialization', $e->getMessage()); }
        Http::assertNothingSent();
    }

    public function test_native_sensitive_value_debug_json_export_and_serialization_are_safe(): void
    {
        $this->assertTrue(class_exists(SensitiveParameterValue::class));
        $this->assertTrue((new ReflectionClass(SensitiveParameterValue::class))->isInternal());
        $credential = new CustomerCredential(101, self::A); $client = RankfreeClient::forCustomer(101, $credential);
        $this->assertInstanceOf(SensitiveParameterValue::class, (new ReflectionProperty($credential, 'key'))->getValue($credential));
        $this->assertSame(['customer_id'=>101], json_decode(json_encode($credential), true));
        foreach ([$credential, $client, [$credential, $client]] as $value) { $this->noSecrets($value); }
        Http::assertNothingSent();
    }

    public function test_exception_text_trace_and_serialization_in_isolated_process_are_safe(): void
    {
        $process = new Symfony\Component\Process\Process([PHP_BINARY, __DIR__.'/ExceptionProbe.php'], __DIR__);
        $process->run();
        $this->assertSame(0, $process->getExitCode(), $process->getOutput().$process->getErrorOutput());
        $result = json_decode($process->getOutput(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertTrue($result['passed']);
        $this->assertSame(3, $result['serialize_blocked']);
        $this->assertSame(3, $result['restore_blocked']);
        $this->assertSame(5, $result['exception_cases']);
        $this->assertSame('0', $result['trace_args']);
        $this->assertGreaterThan(800, $result['checks']);
        fwrite(STDOUT, 'ISOLATED_SECRET_PROBE '.json_encode($result)."\n");
        Http::assertNothingSent();
    }
}

```

`ExceptionProbe.php` — PHPUnit 컨텍스트와 분리한 실제 PHP 예외/trace·직렬화 검사:

```php
<?php

declare(strict_types=1);

require '/Users/anarchy/Claude_Projects/jcurve/vendor/autoload.php';
$app = require '/Users/anarchy/Claude_Projects/jcurve/bootstrap/app.php';
$app->useEnvironmentPath(__DIR__);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\Rankfree\CustomerCredential;
use App\Services\Rankfree\RankfreeClient;
use App\Services\Rankfree\RankfreeException;
use Illuminate\Support\Facades\Http;

const K_A = 'rk_probe_customer_A_secret';
const K_B = 'rk_probe_customer_B_secret';
const K_G = 'rk_probe_global_fallback_secret';
$checks = 0;
function check(bool $valid, string $context): void {
    global $checks;
    $checks++;
    if (!$valid) { throw new RuntimeException('PROBE_FAILED '.$context); }
}
function noSecrets(mixed $value, string $context): void {
    ob_start(); var_dump($value); $dump = ob_get_clean();
    set_error_handler(static function(int $level,string $message): bool {
        return $message === 'var_export does not handle circular references';
    });
    try { $export=var_export($value,true); } finally { restore_error_handler(); }
    foreach ([$dump, print_r($value,true), $export, json_encode($value,JSON_PARTIAL_OUTPUT_ON_ERROR)] as $index=>$text) {
        foreach ([K_A,K_B,K_G,'rk_bad_probe_secret'] as $marker) {
            check(!str_contains($text,$marker),$context.':render'.$index);
        }
    }
}
function expectRankfree(string $reason, callable $action): Throwable {
    try { $action(); } catch (RankfreeException $e) {
        check($e->reason===$reason,'safe-reason:'.$reason);check($e->getPrevious()===null,'safe-previous');return $e;
    }
    throw new RuntimeException('Expected RankfreeException '.$reason);
}
function inspectException(Throwable $e, string $context): void {
    noSecrets((string)$e,$context.':string');noSecrets($e->getMessage(),$context.':message');
    noSecrets($e->getTraceAsString(),$context.':trace-string');noSecrets($e,$context.':object');
    noSecrets($e->getTrace(),$context.':trace-array');
}
try {
    ini_set('zend.exception_ignore_args','0'); check(ini_get('zend.exception_ignore_args')==='0','args-enabled');
    config(['rankfree.enabled'=>true,'rankfree.submission_enabled'=>true,'rankfree.api_key'=>K_G,'rankfree.product_fields'=>[12=>[]]]);
    Http::preventStrayRequests();
    $credential=new CustomerCredential(101,K_A);$client=RankfreeClient::forCustomer(101,$credential);
    $serialization=0;$restoration=0;
    foreach ([$credential,$client,[$credential,$client]] as $value) {
        try {serialize($value);throw new RuntimeException('Expected serialization rejection');}
        catch (LogicException $e) {check(str_contains($e->getMessage(),'must not be serialized'),'serialize-block');inspectException($e,'serialize');$serialization++;}
    }
    foreach ([0,1,202] as $id) {
        $class=CustomerCredential::class;$wire='O:'.strlen($class).':"'.$class.'":1:{s:10:"customerId";i:'.$id.';}';
        try {unserialize($wire);throw new RuntimeException('Expected restoration rejection');}
        catch (LogicException $e) {check(str_contains($e->getMessage(),'must not be restored'),'restore-block');inspectException($e,'restore');$restoration++;}
    }
    Http::assertNothingSent();
    $exceptions=[
        expectRankfree('not_configured',static fn()=>new CustomerCredential(101,"rk_bad_probe_secret\r\nInjected: x")),
        expectRankfree('invalid_input',static fn()=>new CustomerCredential(0,K_A)),
        expectRankfree('account_mismatch',static fn()=>RankfreeClient::forCustomer(202,new CustomerCredential(101,K_A))),
    ];
    Http::fake(static fn()=>Http::response(['message'=>K_A,'field'=>K_B],403));
    $exceptions[]=expectRankfree('rejected',static fn()=>$client->products());Http::assertSentCount(1);
    Http::swap(new Illuminate\Http\Client\Factory);Http::preventStrayRequests();
    Http::fake(static fn()=>Http::failedConnection(K_A));
    $exceptions[]=expectRankfree('unavailable',static fn()=>$client->products());Http::assertSentCount(1);
    foreach ($exceptions as $e) {inspectException($e,'rankfree:'.$e->reason);}
    echo json_encode(['passed'=>true,'checks'=>$checks,'serialize_blocked'=>$serialization,'restore_blocked'=>$restoration,'exception_cases'=>count($exceptions),'trace_args'=>'0'],JSON_THROW_ON_ERROR).PHP_EOL;
} catch (Throwable $e) {fwrite(STDERR,$e->getMessage().PHP_EOL);exit(1);}

```

## 부록 B. 이전 ORDER01 독립 fixture의 이번 실행 원문

기존 보고서는 수정하지 않았다. 아래는 임시 폴더에 보관한 새 factory 이식본이다.

```php
<?php

use App\Services\Rankfree\CustomerCredential;
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
        $this->client = RankfreeClient::forCustomer(101, new CustomerCredential(101, self::KEY));
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
        foreach (['', "rk_invalid\r\nHeader: injected", 'Bearer rk_bad', 'rk_'] as $key) {
            $this->rejected('not_configured', fn() => new CustomerCredential(101, $key));
        }
        $this->rejected('account_not_connected', fn() => RankfreeClient::forCustomer(101, null));
        foreach ([null, []] as $key) {
            try { new CustomerCredential(101, $key); $this->fail('Typed invalid key must reject'); }
            catch (TypeError $e) { $this->assertInstanceOf(TypeError::class, $e); }
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

## 부록 C. 환경·실행기·빌드 격리 원문

`make-safe-config.php` — 빈 임시 경로를 environmentPath로 지정한 후 생성:

```php
<?php
require '/Users/anarchy/Claude_Projects/jcurve/vendor/autoload.php';
$app = require '/Users/anarchy/Claude_Projects/jcurve/bootstrap/app.php';
$app->useEnvironmentPath(__DIR__);
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
file_put_contents(__DIR__.'/config.php', '<?php return '.var_export($app['config']->all(), true).';');
echo 'Safe config: environmentPath=' . $app->environmentPath() . PHP_EOL;

```

`safe-environment.json` — 부모 환경 전체를 전달하지 않고 아래 값만 subprocess에 넘겼다:

```json
{
  "PATH": "/Applications/ChatGPT.app/Contents/Resources/codex-cli/codex-path:/Users/anarchy/bin:/Users/anarchy/.grok/bin:/Users/anarchy/.local/bin:/Users/anarchy/.nvm/versions/node/v20.20.2/bin:/Users/anarchy/Library/Python/3.13/bin:/opt/homebrew/bin:/opt/homebrew/sbin:/Library/Frameworks/Python.framework/Versions/3.13/bin:/usr/local/bin:/System/Cryptexes/App/usr/bin:/usr/bin:/bin:/usr/sbin:/sbin:/var/run/com.apple.security.cryptexd/codex.system/bootstrap/usr/local/bin:/var/run/com.apple.security.cryptexd/codex.system/bootstrap/usr/bin:/var/run/com.apple.security.cryptexd/codex.system/bootstrap/usr/appleinternal/bin:/pkg/env/global/bin:/Library/Apple/usr/bin:/opt/homebrew/bin:/Users/anarchy/.codex/tmp/arg0-macos/codex-arg0KWwPpU:/Applications/ChatGPT.app/Contents/Resources/codex-cli/codex-path:/Users/anarchy/.cache/codex-runtimes/codex-primary-runtime/dependencies/bin/override:/Users/anarchy/bin:/Users/anarchy/.grok/bin:/Users/anarchy/.unity/bin:/Users/anarchy/.local/bin:/Users/anarchy/.nvm/versions/node/v20.20.2/bin:/Users/anarchy/Library/Python/3.13/bin:/opt/homebrew/sbin:/Library/Frameworks/Python.framework/Versions/3.13/bin:/Users/anarchy/.cache/codex-runtimes/codex-primary-runtime/dependencies/bin/fallback:/Applications/ChatGPT.app/Contents/Resources:/Applications/ChatGPT.app/Contents/Resources/codex-cli/CodexCLI.app/Contents/MacOS",
  "APP_ENV": "testing",
  "APP_KEY": "base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=",
  "APP_URL": "http://localhost",
  "DB_CONNECTION": "sqlite",
  "DB_DATABASE": ":memory:",
  "DB_URL": "",
  "CACHE_STORE": "array",
  "SESSION_DRIVER": "array",
  "QUEUE_CONNECTION": "sync",
  "MAIL_MAILER": "array",
  "BROADCAST_CONNECTION": "null",
  "RANKFREE_API_ENABLED": "false",
  "RANKFREE_ORDER_SUBMISSION_ENABLED": "false",
  "APP_CONFIG_CACHE": "/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/config.php"
}
```

`run.py`:

```python
import os,json,subprocess,sys
from pathlib import Path
t=Path(__file__).parent
env=json.loads((t/'safe-environment.json').read_text())
label=sys.argv[1];cmd=sys.argv[2:]
r=subprocess.run(cmd,cwd='/Users/anarchy/Claude_Projects/jcurve',env=env,stdout=subprocess.PIPE,stderr=subprocess.STDOUT,text=True)
(t/(label+'.log')).write_text(r.stdout)
(t/(label+'.json')).write_text(json.dumps({'command':cmd,'exit':r.returncode},indent=2))
print(r.stdout if len(r.stdout)<20000 else r.stdout[:10000]+'\n[full output retained in log]\n'+r.stdout[-5000:]);print('COMMAND_EXIT',r.returncode)
sys.exit(r.returncode)

```

`vite.config.mjs`:

```js
import base from '/Users/anarchy/Claude_Projects/jcurve/vite.config.js';
export default { ...base, envDir: "/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd", build: { ...base.build, outDir: "/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order02-verify-h4_7d7rd/build", emptyOutDir: true } };

```
