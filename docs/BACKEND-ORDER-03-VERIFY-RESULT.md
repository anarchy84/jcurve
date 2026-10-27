# BACKEND-ORDER-03 독립 검증 결과

검증일: 2026-10-27 · 작업 폴더: `/Users/anarchy/Claude_Projects/jcurve` · 계약 기준: `main / 018093c`(지시서 기재값, 검증자는 git 명령 미사용)

**로컬 ORDER03 백엔드 독립 검증: PASS.** 전체 **98 tests / 663 assertions**, 연결 구현자 테스트 **18 / 141**, 별도 공격 fixture **14 / 3,680**을 실제 실행해 통과했다. 소유 PHP **14파일 Pint·문법**, 격리 Vite 빌드도 통과했다. 지정된 암호화 무력화 1회는 평문 저장 단언에서 실제 실패했고 원문 복구 후 재통과했다.

제품 결함은 이번 실행에서 발견하지 않았다. 이 판정은 지정된 로컬 연결 관리 범위의 실행 증거다. **Claude·대웅의 최종 제품 검수·서버 반영·공개 승인은 별도**다. PHP8.3/MySQL 동시성 및 실서버·실키·원격 계정 소유권은 검증하지 않았다.

## 1. 격리·소유

- AGENTS/COLLAB/QUEUE, ORDER03 계약·API 계약·검증 지시서와 필수 tri-agent 스킬을 완독했다. 부모가 구현/대시보드를 맡고 제품·구현자 테스트를 동결했다.
- 검증자 영구 산출물은 이 보고서 하나다. 제품/구현자 테스트는 수정하지 않았고 지정된 암호화 표현식의 임시 무력화/복구만 수행했다. 검사한 제품·설정·구현자 테스트·인증 경로 **23파일 SHA256이 모두 시작/끝 동일**하다.
- 실제 `.env`를 열거나 로딩하지 않았다. Laravel 환경 경로를 빈 임시 폴더로 변경한 뒤 가짜 APP_KEY 기반 config를 생성했다. 이후 모든 앱 실행은 `APP_CONFIG_CACHE`로 이 config를 사용했다. 설정 캐시 존재 시 LoadEnvironmentVariables는 반환하는 프레임워크 코드를 확인했다.
- DB는 SQLite `:memory:`와 외래키 ON, 캐시/세션은 array, 메일은 array, queue는 sync다. SQL migration은 테스트 DB에서만 수행했다. 서버 migration·외부 API·실주문·실키·프론트 수정·미디어 수정·git·배포/발행은 수행하지 않았다.
- 독립 fixture는 `Http::preventStrayRequests()`를 매 테스트 적용한다. HTTP 전송 확인이 필요한 한 테스트만 `Http::fake`로 **A/B/교체A 3회**를 실행했고 다른 독립 테스트는 **0회**를 단언했다. 원격 서버 호출은 없다.
- PHP CLI **8.5.8**, PHPUnit **12.5.33**. Vite envDir/outDir 및 compiled views·로그도 임시 경로다. 빌드가 `public/build`를 덮어쓰지 않는다.
- 증거 폴더: `/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0`. 아래 부록에 독립 fixture와 안전 실행기를 원문 보존했다.

격리 config 생성 실제 출력:

```text
{"environment_path":"\/private\/var\/folders\/_s\/jxm41njj5198jwlz0rcc8p1m0000gn\/T\/jcurve-order03-verify-d8z0xvg0\/empty-env","database":":memory:","cache":"array","session":"array","connections_enabled":false}
```

## 2. 지시서 대조·실제 공격

| 지시서·코드 위치 | 독립 입력과 실제 결과 | 판정 |
|---|---|---|
| 본인/타인 분리 · ConnectionStore.php:16/23/46/54, controller:17/24/35 | A/B 각자 실제 PUT 등록 후 GET 메타데이터 분리. 다른 ID를 user_id/customer_id/owner 중첩/ciphertext/revision으로 PUT·DELETE 주입하면422. query 3종을 GET/PUT/DELETE 주입하면422. 고객ID/가짜 주문 하위 경로404, POST405. 두 고객 원문 키·레코드 불변 | PASS |
| 현재비밀번호·키 검증 · controller:27/38 | password null/빈값/틀림/배열/중첩/bool/숫자/1,025자 및 누락 거부. 키 null/빈값/배열/object/bool/숫자/빈 rk_/공백/개행/NUL/비ASCII/Bearer/513자 거부. 정확히512자 키는 저장·복호화 성공 | PASS |
| 본문 계약 · controller:53 | malformed JSON·null/배열/문자열/숫자 root·잘못된 쉼표·깊이초과400, 8,193 bytes413, form/multipart+파일415. 모두 미등록 유지·old input 없음 | PASS |
| APP_KEY 인증 암호화 · store:33/62 | DB 직접 읽은 ciphertext는 평문과 다름. fixture config의 APP_KEY에서 별도로 만든 Encrypter가 원문 정확히 복호화. 동일 키 재등록 ciphertext/revision이 각각 달라지고 모델 toArray는 ciphertext를 숨김 | PASS |
| MAC/잘못된 키 · store:61 | 실제 base64 payload의 MAC만 0으로 변조하면 credential_unreadable. 다른 encrypter로 읽어도 동일한 안전 예외·previous 없음. status GET은 복호화 없이 registered=true/provider_verified=false라는 문서 계약 유지 | PASS |
| 교체 실패·transaction · store:30 | encryptString이 키/비밀번호 포함 예외를 던지면503. SQLite BEFORE UPDATE trigger가 모의 비밀 포함 RAISE(ABORT)를 일으키면500. 양쪽 모두 기존 ciphertext/revision/timestamps 전체 동일·기존 키 복호화 성공 | PASS |
| 변경/해제/재등록 · store:37/46/70 | 고객당1레코드, 교체 revision/updated_at 변경·registered_at 유지. DELETE204, 반복DELETE204·빈 본문·다른 고객 유지. 새 resolver는 account_not_connected. 재등록 새 revision. fresh client는 A/B/교체A 키로만 fake HTTP | PASS |
| 삭제/복원·stale · observer, store:75 | A soft delete 후 A 연결 물리삭제·B 보존. 별도 stale User로 상태·등록·해제·resolve 거절, 실제 GET/PUT/DELETE401. restore 후 미등록. force delete 후 연결 없음 | PASS |
| 실제 CSRF · Laravel 원본 PreventRequestForgery | app env를 testing 밖으로 바꿔 unit-test bypass=false를 단언. 클래스 override·CSRF exemption 없음. 저장된 array 세션과 암호화된 session cookie로 실제 인증. 없음/불일치/cross-site 무토큰/same-site 무토큰419, 올바른 token200·DELETE204, same-origin Fetch Metadata 무토큰200 | PASS |
| 실제 guest 순서 | CSRF보다 auth가 뒤다. 비로그인 mutation 무토큰419, 정상 session token으로 CSRF 통과 후401, GET401. 일반 테스트 bypass에서 나온 guest401과 구분했다 | PASS |
| 기본 flag·분당제한 · config/Provider/routes | 초기 config의 연결/API/주문 flags 모두false. 연결flag false의 GET/PUT/DELETE503·DB 변화없음. 활성화 후 잘못된 입력도 PUT/DELETE 합산5회 뒤429, GET60회 뒤429. 숫자 Retry-After·limit·remaining 확인. B 독립·61초 뒤 A 회복. API/주문 flags는 별개 | PASS |
| JSON·기본 예외 로그·flash · bootstrap, error response | APP_DEBUG=true·HTML Accept에서 성공/401/403/419/422/429/500/503을 검사. 실제 validator 내부 RuntimeException, 저장 encrypt/DB 예외, 키·비밀번호·ciphertext가 든 예외와 ValidationException 메시지 주입. 응답은 고정 JSON·no-store/noindex/nosniff, 허용 fields만 고정 문구, raw 비밀/trace·old input 없음. 실제 기본 Monolog TestHandler는 고정 메시지+exception_type만 수신 | PASS |
| schema·migration | TEXT ciphertext, user_id unique·FK 실제 위반이 QueryException으로 차단. 신규 migration down→테이블 없음→up→빈테이블→새 저장/복호화 성공. 모두 메모리DB | PASS |
| 주문 경계·회귀 | runtime API route 목록은 연결 GET/HEAD·PUT·DELETE 3개뿐. 공개 주문 라우트 없음. API/주문 활성화·실주문 없이 전체98/663 통과. 기존 ORDER01/02 구현자 테스트도 전체 suite에 포함 | PASS |

403 검사는 AuthorizationException 주입에 대한 실제 HTTP 오류 렌더링 검증이다. 기본 Laravel13 cross-site 무토큰 결과를403으로 주장하지 않는다(실제419). 같은 origin 메타데이터 경로와 token 비교 경로는 서로 독립이며, cross-site라도 유효 token이 있으면 통과하는 기본 동작을 관측했다. 부모가 API 계약에 이 차이와 guest401/419 처리를 보강했다.

`clientFor(User)`의 User는 서버 인증 계층이 제공해야 한다. 임의 User 객체/ID를 서버 내부에서 만들어 전달하는 호출자를 인증해 주는 함수는 아니다. 이번 실제 HTTP는 `$request->user()`만 전달하며 소유 ID 입력을 거부했다. 이미 얻은 client/in-flight 요청의 취소, 원격 키 폐기, quiet/bulk SQL 사용자 삭제 observer 한계는 API 문서에서 구분하며 새 기능으로 주장하지 않는다.

기본 로그 파일 `/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/laravel.log`도 직접 검색했다. 마지막 확인 시5,232 bytes·고정 로그38줄, 모의 키A/B·비밀번호·validator internals·forced database failure·encryption attack 문자열은 모두0건이었다. `emergency.log`는 생성되지 않았다. 이는 해당 기본 로그 경로 검증이며 별도 운영 APM/프록시/DB query 로그 검증은 아니다.

## 3. 실제 명령·출력

각 앱 명령은 `run.py`가 허용한 환경만 subprocess에 전달한다. `.env` 로딩이나 저장소 config cache 삭제를 유발하는 `composer test`/`config:clear`는 실행하지 않았다.

```sh
python3 /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/run.py full-after-restore php artisan test --compact
python3 /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/run.py connections-final php artisan test --compact --filter=RankfreeConnection
python3 /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/run.py independent-final vendor/bin/phpunit --configuration phpunit.xml --no-progress /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/IndependentOrder03ProbeTest.php
python3 /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/run.py routes php artisan route:list --json --path=api
python3 /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/run.py build npm run build -- --config /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/vite.config.mjs --configLoader native
```

전체 최종 출력(exit0):

```text
............................................................................
  ......................

  Tests:    98 passed (663 assertions)
  Duration: 2.21s
```

연결 테스트 출력(exit0):

```text
..................

  Tests:    18 passed (141 assertions)
  Duration: 0.85s
```

독립 공격 출력(exit0):

```text
PHPUnit 12.5.33 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.5.8
Configuration: /Users/anarchy/Claude_Projects/jcurve/phpunit.xml

ACTUAL_CSRF no-token=419 wrong=419 cross-site-no-token=419 same-site=419 cross-site-valid-token=200 valid-delete=204 same-origin-no-token=200 cookie-auth-user=1
RATE_LIMIT write=5+429 read=60+429 B=isolated reset61s=200
ISOLATED_TRANSPORT A,B,A-rotated fake=3 after-disconnect=account_not_connected
REAL_GUEST mutation-no-token=419 mutation-valid-token=401 read=401
Time: 00:01.139, Memory: 66.50 MB

OK (14 tests, 3680 assertions)
```

Pint는 임시 폴더를 cwd로, APP_CONFIG_CACHE 없이 `vendor/bin/pint --test`에 소유 PHP14파일의 절대경로를 전달했다(부록 해시 목록 첫14개). PHP 문법은 동일14파일에 각각 `php -l`을 실행했다. 둘 다 exit0.

```text
..............

  ──────────────────────────────────────────────────────────────────── Laravel  
    PASS   .......................................................... 14 files
No syntax errors detected in app/Models/RankfreeConnection.php
No syntax errors detected in app/Services/Rankfree/ConnectionStore.php
No syntax errors detected in app/Services/Rankfree/ConnectionStoreException.php
No syntax errors detected in app/Observers/UserRankfreeConnectionObserver.php
No syntax errors detected in app/Http/Controllers/RankfreeConnectionController.php
No syntax errors detected in app/Http/Middleware/RankfreeConnectionApi.php
No syntax errors detected in app/Http/Responses/RankfreeConnectionError.php
No syntax errors detected in database/migrations/2026_10_27_000001_create_rankfree_connections_table.php
No syntax errors detected in routes/rankfree-connections.php
No syntax errors detected in tests/Feature/RankfreeConnectionApiTest.php
No syntax errors detected in tests/Feature/RankfreeConnectionStoreTest.php
No syntax errors detected in app/Providers/AppServiceProvider.php
No syntax errors detected in bootstrap/app.php
No syntax errors detected in config/rankfree.php
```

npm에는 build/dev만 존재하며 typecheck/lint/test 스크립트는 없다. PHP 스타일은 Pint, 회귀는 PHPUnit/Artisan으로 검증했다. 격리 빌드(exit0):

```text
> build
> vite build --config /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/vite.config.mjs --configLoader native

vite v8.2.0 building client environment for production...

transforming...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
✓ 9 modules transformed.
rendering chunks...
computing gzip size...
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/build/manifest.json              0.33 kB │ gzip:  0.16 kB
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/build/assets/app-D_PS-FNm.css   97.94 kB │ gzip: 18.46 kB
../../../../var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/build/assets/app-XOhwnyVw.js   159.36 kB │ gzip: 60.50 kB

✓ built in 1.38s
```

`/media/bg/hero-glow.webp`는 기존 런타임 참조 경고로 남아 있다. 프론트·실제 미디어 화면은 이번 백엔드 판정 범위가 아니다.

### 독립 fixture 준비 중 실패와 제품 실패 구분

초기12테스트 실행은3회 단언 실패였다. 두 건은 검증 helper가 정상 DELETE204 빈 본문까지 JSON 파싱했고, 한 건은 비활성 요청 이후 남아 있던 throttle 카운터를 재사용한 채 새5회를 기대했다. helper는204에서 빈 본문을 직접 단언하도록 고쳤고, flag단계와 rate단계를 분리하는 cache reset을 넣었다. 제품·구현자 테스트 변경은 없다. 이후13/3,565 통과.

추가 guest 순서 테스트의 첫 실행은419 뒤 테스트 메모리에만 넣은 세션 토큰을 cookie 요청에 재사용해 예상401 대신419였다. 실제 요청에서 session token이 기대값과 다른 것을 확인했고, fixture에서 `session()->save()`로 로그인 없는 세션을 먼저 저장한 뒤 암호화 cookie를 보냈다. 그 뒤 원본 CSRF가 유효 token을 통과시키고 auth가401을 반환했다. 제품을 바꾸거나 예상 상태를 완화하지 않았다. 최종14/3,680 통과. 초기 출력은 증거 폴더의 `independent-initial.log`, `independent-guest-final.log`, `guest-diag.log`에 남겼다.

## 4. 암호화 무력화1회·복구

부모에게 시작/복구를 각각 알렸다. 아래 표현식 한 군데만 임시 치환했다.

```php
Crypt::encryptString($credential->authorizationKey())
// 임시 실험 표현식
$credential->authorizationKey()
```

실행 대상은 지시서에 지정된 원래 구현자 테스트다. `mutation.py`의 try/finally로 원문을 복구했고 SHA/바이트 동등성을 확인했다.

무력화 실제 출력(exit1):

```text
⨯
  ────────────────────────────────────────────────────────────────────────────  
   FAILED  Tests\Feature\RankfreeConnectionApiTest > registration stores aut…   
  Failed asserting that two strings are not identical.

  at tests/Feature/RankfreeConnectionApiTest.php:62
     58▕         $response = $this->putJson(self::URL, $this->payload())->assertOk()
     59▕             ->assertJsonPath('data.registered', true)->assertJsonPath('data.provider_verified', false)
     60▕             ->assertHeader('Cache-Control', 'no-store, private');
     61▕         $raw = DB::table('rankfree_connections')->where('user_id', $this->customer->id)->first();
  ➜  62▕         $this->assertNotSame(self::KEY, $raw->credential_ciphertext);
     63▕         $this->assertSame(self::KEY, Crypt::decryptString($raw->credential_ciphertext));
     64▕         $this->assertStringNotContainsString(self::KEY, $response->getContent());
     65▕         $this->assertStringNotContainsString($raw->credential_ciphertext, $response->getContent());
     66▕         $this->assertArrayNotHasKey('credential_ciphertext', RankfreeConnection::query()->first()->toArray());

  1   tests/Feature/RankfreeConnectionApiTest.php:62


  Tests:    1 failed (8 assertions)
  Duration: 0.50s
```

복구 실제 출력(exit0):

```text
.

  Tests:    1 passed (13 assertions)
  Duration: 0.62s
```

```json
{
  "before_sha256": "4a4928ad717a13fd29502e41766efd265885be5532587d427000aa66b64f3f1c",
  "command": [
    "php",
    "artisan",
    "test",
    "--compact",
    "--filter=RankfreeConnectionApiTest::test_registration_stores_authenticated_ciphertext_without_returning_key_material"
  ],
  "mutated_sha256": "ff6b426c9a149dda610dc9b166c84b21958c9ed80dc98f955309537c311b8f9c",
  "mutated_exit": 1,
  "restored_sha256": "4a4928ad717a13fd29502e41766efd265885be5532587d427000aa66b64f3f1c",
  "restored_bytes_equal": true,
  "restored_exit": 0
}
```

테스트는 DB 평문 저장을 `assertNotSame`에서 실제 감지한다. 실패를 삼키는 try/catch나 무효 단언은 없었다. 복구 후 연결18/141과 전체98/663도 재통과했다.

## 5. 보존 해시·남은 게이트

아래23파일은 검증 시작/끝 SHA256이 전부 같다. 첫14파일이 이번 PHP 소유 파일이다. User·기존 auth/profile·ORDER01/02 모듈/테스트도 현재 검증 중 보존됐다. git을 사용하지 않았으므로 구현 전 기준 커밋과의 diff 검증으로 과장하지 않는다.

```text
299ebcbc07c79a1cd0fcf0b5f8fc8d5d8dde6939ee073c351b500aadc2d7f5a2  app/Models/RankfreeConnection.php
4a4928ad717a13fd29502e41766efd265885be5532587d427000aa66b64f3f1c  app/Services/Rankfree/ConnectionStore.php
072f4420c140d4acaf9c361f664f7efa7a8608720436525451d92d26a2f118d3  app/Services/Rankfree/ConnectionStoreException.php
0c7734aeb6c927b715d3f83e87a417b1c2ff5aad93db14aa5e942ecaa7b53c00  app/Observers/UserRankfreeConnectionObserver.php
e9d9de1916e239723ab3f33cdd068ade979915f3a9358c2a8ee4ef6b6b4b2f12  app/Http/Controllers/RankfreeConnectionController.php
f4811bf4e2bbcfd91021da56b2365db66dc8c9ff8b1284d587d505211f70b910  app/Http/Middleware/RankfreeConnectionApi.php
5b44566bdb79c51c7bc9dbb29a8922f4903755a471a3a42fd799c8b6b1814b00  app/Http/Responses/RankfreeConnectionError.php
1582581580b88276f91be11c3421c1cd9114d713424cd15ab6dc5f7642e87ca4  database/migrations/2026_10_27_000001_create_rankfree_connections_table.php
cd05c6285c19ca5d03417409672a5645055b3185ff7134f81402c285ea5fc179  routes/rankfree-connections.php
410c835b76a5550d491b6d32fe5d76101420d6e591e7f31c5c6235ca373d6c9a  tests/Feature/RankfreeConnectionApiTest.php
e482fcf1b2b9d399eafaa645400c25838f1ec8b7ebdc9eda8bea600dc064fb20  tests/Feature/RankfreeConnectionStoreTest.php
e117c083bf46ccf48f556b20d702d75cab5c7dc8bfbacf678eacdfc23bcd4769  app/Providers/AppServiceProvider.php
e38e943b6089038b7853c4738d0dbf780d88acd105255b88933546b9e49ae8d1  bootstrap/app.php
fe1105dc4963f294603f0911c3159bec5740b9a448bab4e1fadcd22072a4e07d  config/rankfree.php
f9b41ce3795e352dd97adc1847af1295f7fc5ac4571848389001f43d8ed5615d  .env.example
a6b271f657d4da559635184d30abb5cde695954296546b15034294f3c1090ada  app/Models/User.php
ae97a0c4ed28bd79ac0ff8c3a11539489518e1da4f17a3cf7a2b606b96dfd765  routes/auth.php
01586a456c9162ecf08234897b47ab29828e67b185e68983932ecc41a76ed355  app/Http/Controllers/ProfileController.php
9e02dd95db0a61cd0a5b64fa0e2a051164479b268cbc28e5afd5e6a6674e9cf6  app/Services/Rankfree/RankfreeClient.php
c79c29485156ae4437cbcdcdf2687a54e09b9d3f92599b33cd53707a259fd6e6  app/Services/Rankfree/CustomerCredential.php
bdf41ecf21d20139337620ca755a51fe03161e7da50dd9b40c9ad74c022b66b9  app/Services/Rankfree/RankfreeException.php
ea86f3d2b3ab34a08af83b5d80c797f5c3b690d58b2c4defba81df5ae7d8775a  tests/Feature/RankfreeClientTest.php
c66038a1a06101d5b91fe27a781512aa48d866ce09f78a60941a5dbfc114970a  tests/Feature/RankfreeCustomerIsolationTest.php
```

독립 fixture SHA256: `5593d46bda4b50b1c6f1c08338c327d2fff1fd9ffb2fc0215a7e2f0527a8e959`. 보고서 자체 SHA는 자기참조를 피하려고 부모에게 별도로 반환한다.

미검증·후속 게이트:

- PHP8.3/MySQL 및 서버 migration/rollback, 실서버 로그인·cookie 설정, HTTPS·프록시·운영 rate-limit cache 분산 구성.
- MySQL 사용자 행 lock의 실제 동시 요청 직렬화·교착/동시 탈퇴 race. SQLite unique/FK·transaction 실패 rollback은 검증했지만 MySQL row-lock 동시성 증거로 대체하지 않는다.
- 실키 유효성·원격 소유자/order 권한·키 보관/백업/APP_KEY 운영/접근통제·운영 관측 도구의 비밀 처리.
- 연결 프론트와 실제 브라우저 UX, 주문별 소유권 원장·결제/가격 동의·영속 중복 주문 방지·실주문.
- 제품 최종 판정은 Claude·대웅. 커밋/푸시/배포/발행을 수행하지 않았다.

## 부록 A. 독립 fixture 원문

`IndependentOrder03ProbeTest.php` — 저장소의 구현자 테스트를 수정하지 않고 임시 경로에서 실행했다. 단언 실패는 PHPUnit 실패로 전파되며 예상 service 예외만 잡는다.

```php
<?php

declare(strict_types=1);

use App\Models\RankfreeConnection;
use App\Models\User;
use App\Services\Rankfree\ConnectionStore;
use App\Services\Rankfree\ConnectionStoreException;
use App\Services\Rankfree\RankfreeException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Encryption\Encrypter;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\TestResponse;
use Illuminate\Validation\ValidationException;
use Monolog\Handler\TestHandler;
use Tests\TestCase;

final class IndependentOrder03ProbeTest extends TestCase
{
    use RefreshDatabase;

    private const URL = '/api/account/rankfree-connection';
    private const A = 'rk_independent_A_secret_marker';
    private const B = 'rk_independent_B_secret_marker';
    private const PASS = 'independent_password_marker';
    private User $a;
    private User $b;
    private ConnectionStore $store;
    private int $expectedHttp = 0;
    private TestHandler $logs;
    private array $secrets = [self::A, self::B, self::PASS];

    protected function setUp(): void
    {
        parent::setUp();
        $this->assertFalse(config('rankfree.connections_enabled'));
        $this->assertFalse(config('rankfree.enabled'));
        $this->assertFalse(config('rankfree.submission_enabled'));
        config(['rankfree.connections_enabled' => true, 'app.debug' => true]);
        Http::preventStrayRequests();
        $this->a = User::factory()->create(['password' => self::PASS]);
        $this->b = User::factory()->create(['password' => self::PASS]);
        $this->store = app(ConnectionStore::class);
        $this->logs = new TestHandler;
        Log::getLogger()->pushHandler($this->logs);
    }

    protected function tearDown(): void
    {
        Http::assertSentCount($this->expectedHttp);
        $this->assertEmpty(session()->getOldInput());
        $this->checkSecrets(json_encode($this->logs->getRecords(), JSON_PARTIAL_OUTPUT_ON_ERROR));
        parent::tearDown();
    }

    private function payload(string $key = self::A): array
    {
        return ['api_key' => $key, 'current_password' => self::PASS];
    }

    private function checkSecrets(string $text): void
    {
        foreach ($this->secrets as $secret) {
            $this->assertStringNotContainsString($secret, $text);
        }
    }

    private function safe(TestResponse $response, int $status, ?string $code = null): TestResponse
    {
        $response->assertStatus($status)->assertHeader('Cache-Control', 'no-store, private')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')->assertHeader('X-Content-Type-Options', 'nosniff');
        if ($status !== 204) {
            $response->assertHeader('Content-Type', 'application/json');
            $data = $response->json();
            $this->assertIsArray($data);
            if ($code !== null) {
                $response->assertJsonPath('error.code', $code);
                $this->assertSame(['error'], array_keys($data));
                $this->assertContains(array_keys($data['error']), [['code', 'message'], ['code', 'message', 'fields']]);
            }
        } else {
            $this->assertSame('', $response->getContent());
        }
        $this->checkSecrets($response->getContent());
        if ($status !== 204) {
            foreach (['exception', 'trace', 'file', 'line'] as $field) {
                $this->assertArrayNotHasKey($field, $response->json());
            }
        }
        $this->assertEmpty(session()->getOldInput());
        return $response;
    }

    private function reason(string $type, string $reason, callable $action): Throwable
    {
        try {
            $action();
            $this->fail('Expected '.$type.':'.$reason);
        } catch (ConnectionStoreException|RankfreeException $e) {
            $this->assertInstanceOf($type, $e);
            $this->assertSame($reason, $e->reason);
            $this->assertNull($e->getPrevious());
            $this->checkSecrets($e->getMessage());
            return $e;
        }
    }

    public function test_real_routes_isolate_a_b_and_reject_identity_injections(): void
    {
        $a = $this->safe($this->actingAs($this->a)->putJson(self::URL, $this->payload()), 200)->json('data');
        $b = $this->safe($this->actingAs($this->b)->putJson(self::URL, $this->payload(self::B)), 200)->json('data');
        $this->assertNotSame($a['revision'], $b['revision']);
        foreach ([['user_id' => $this->a->id], ['customer_id' => $this->a->id], ['owner' => ['id' => $this->a->id]], ['credential_ciphertext' => self::A], ['revision' => $a['revision']]] as $extra) {
            Cache::flush();
            $this->safe($this->putJson(self::URL, $this->payload(self::B) + $extra), 422, 'validation_failed');
            $this->safe($this->deleteJson(self::URL, ['current_password' => self::PASS] + $extra), 422, 'validation_failed');
        }
        foreach (['?user_id='.$this->a->id, '?api_key='.self::A, '?current_password='.self::PASS] as $query) {
            Cache::flush();
            $this->safe($this->get(self::URL.$query, ['Accept' => 'text/html']), 422, 'validation_failed');
            $this->safe($this->putJson(self::URL.$query, $this->payload()), 422, 'validation_failed');
            $this->safe($this->deleteJson(self::URL.$query, ['current_password' => self::PASS]), 422, 'validation_failed');
        }
        foreach (['/'.$this->a->id, '/../../orders', '/orders/MO-SHARED'] as $path) {
            $this->safe($this->get(self::URL.$path, ['Accept' => 'text/html']), 404, 'not_found');
        }
        $this->safe($this->postJson(self::URL, $this->payload()), 405, 'method_not_allowed');
        $this->safe($this->getJson(self::URL), 200)->assertJsonPath('data.revision', $b['revision']);
        $this->assertSame(self::A, $this->store->credentialFor($this->a)->authorizationKey());
        $this->assertSame(self::B, $this->store->credentialFor($this->b)->authorizationKey());
        $this->assertDatabaseCount('rankfree_connections', 2);
    }

    public function test_current_password_empty_wrong_types_and_input_matrix_do_not_mutate(): void
    {
        $this->actingAs($this->a);
        $invalid = [null, '', 'wrong_password_marker', [], ['nested' => self::PASS], false, 123, str_repeat('p', 1025)];
        foreach ($invalid as $value) {
            Cache::flush();
            $this->safe($this->putJson(self::URL, ['api_key' => self::A, 'current_password' => $value]), 422, 'validation_failed');
            $this->safe($this->deleteJson(self::URL, ['current_password' => $value]), 422, 'validation_failed');
        }
        Cache::flush();
        $this->safe($this->putJson(self::URL, ['api_key' => self::A]), 422, 'validation_failed');
        $this->safe($this->deleteJson(self::URL, []), 400, 'invalid_json');
        foreach ([null, '', [], (object) ['x' => self::A], true, 123, 'rk_', ' rk_bad', 'rk_bad ', "rk_bad\n", "rk_bad\0", 'rk_한글', 'Bearer '.self::A, 'rk_'.str_repeat('x', 510)] as $key) {
            Cache::flush();
            $this->safe($this->putJson(self::URL, ['api_key' => $key, 'current_password' => self::PASS]), 422, 'validation_failed');
        }
        $this->assertDatabaseCount('rankfree_connections', 0);
        Cache::flush();
        $maxKey = 'rk_'.str_repeat('x', 509);
        $this->safe($this->putJson(self::URL, $this->payload($maxKey)), 200);
        $this->assertSame($maxKey, $this->store->credentialFor($this->a)->authorizationKey());
        $this->assertSame(512, strlen($maxKey));
        $this->assertDatabaseCount('rankfree_connections', 1);
    }

    public function test_invalid_json_content_types_files_and_size_are_closed(): void
    {
        $this->actingAs($this->a);
        foreach (['null', '[]', '"'.self::A.'"', '42', '{bad', '{"api_key":"'.self::A.'",}', str_repeat('[', 513)] as $body) {
            Cache::flush();
            $this->safe($this->call('PUT', self::URL, [], [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'text/html'], $body), 400, 'invalid_json');
        }
        Cache::flush();
        $this->safe($this->call('PUT', self::URL, [], [], [], ['CONTENT_TYPE' => 'application/json'], str_repeat('x', 8193)), 413, 'payload_too_large');
        $this->safe($this->put(self::URL, $this->payload()), 415, 'json_required');
        $this->safe($this->call('PUT', self::URL, ['current_password' => self::PASS], [], ['api_key' => UploadedFile::fake()->create('key.txt', 1)], ['CONTENT_TYPE' => 'multipart/form-data']), 415, 'json_required');
        $this->assertDatabaseCount('rankfree_connections', 0);
    }

    public function test_app_key_ciphertext_mac_wrong_key_and_failed_rotation(): void
    {
        $this->actingAs($this->a);
        $this->safe($this->putJson(self::URL, $this->payload()), 200);
        $before = DB::table('rankfree_connections')->where('user_id', $this->a->id)->first();
        $this->secrets[] = $before->credential_ciphertext;
        $crypto = new Encrypter(base64_decode(substr(config('app.key'), 7)), 'AES-256-CBC');
        $this->assertNotSame(self::A, $before->credential_ciphertext);
        $this->assertStringNotContainsString(self::A, $before->credential_ciphertext);
        $this->assertSame(self::A, $crypto->decryptString($before->credential_ciphertext));
        $this->assertArrayNotHasKey('credential_ciphertext', RankfreeConnection::query()->first()->toArray());
        $decoded = json_decode(base64_decode($before->credential_ciphertext), true, flags: JSON_THROW_ON_ERROR);
        $decoded['mac'] = str_repeat('0', 64);
        DB::table('rankfree_connections')->where('user_id', $this->a->id)->update(['credential_ciphertext' => base64_encode(json_encode($decoded))]);
        $this->reason(ConnectionStoreException::class, 'credential_unreadable', fn () => $this->store->clientFor($this->a));
        // Status is metadata only and intentionally does not decrypt.
        $this->safe($this->getJson(self::URL), 200)->assertJsonPath('data.registered', true)->assertJsonPath('data.provider_verified', false);
        DB::table('rankfree_connections')->where('user_id', $this->a->id)->update(['credential_ciphertext' => $before->credential_ciphertext]);
        Crypt::swap(new Encrypter(str_repeat('w', 32), 'AES-256-CBC'));
        $this->reason(ConnectionStoreException::class, 'credential_unreadable', fn () => $this->store->clientFor($this->a));
        Crypt::swap(new class(str_repeat('v', 32), 'AES-256-CBC') extends Encrypter {
            public function encryptString($value) { throw new RuntimeException('rk_independent_A_secret_marker independent_password_marker encryption attack'); }
        });
        $this->safe($this->putJson(self::URL, $this->payload(self::B)), 503, 'connection_storage_unavailable');
        $after = DB::table('rankfree_connections')->where('user_id', $this->a->id)->first();
        $this->assertEquals($before, $after);
        $this->assertSame(self::A, $crypto->decryptString($after->credential_ciphertext));
        Crypt::swap($crypto);
    }

    public function test_replacement_database_failure_rolls_back_and_redacts(): void
    {
        $this->actingAs($this->a);
        $this->safe($this->putJson(self::URL, $this->payload()), 200);
        $before = (array) DB::table('rankfree_connections')->first();
        $this->secrets[] = $before['credential_ciphertext'];
        $sql = "CREATE TRIGGER order03_failure BEFORE UPDATE ON rankfree_connections BEGIN SELECT RAISE(ABORT, 'rk_independent_A_secret_marker independent_password_marker forced database failure'); END";
        DB::statement($sql);
        $this->safe($this->putJson(self::URL, $this->payload(self::B)), 500, 'internal_error');
        $this->assertSame($before, (array) DB::table('rankfree_connections')->first());
        DB::statement('DROP TRIGGER order03_failure');
        $this->assertSame(self::A, $this->store->credentialFor($this->a)->authorizationKey());
    }

    public function test_actual_session_cookie_and_framework_csrf_without_any_override(): void
    {
        $this->app->instance('env', 'independent-http');
        $this->assertFalse($this->app->runningUnitTests());
        $csrf = $this->app->make(PreventRequestForgery::class);
        $this->assertSame(PreventRequestForgery::class, get_class($csrf));
        $this->assertSame([], $csrf->getExcludedPaths());
        $token = 'independent_csrf_session_token';
        $this->withSession([Auth::guard('web')->getName() => $this->a->id, '_token' => $token]);
        session()->save();
        $this->withCookie(config('session.cookie'), session()->getId());
        $send = function (string $method, array $headers = []): TestResponse {
            Auth::forgetGuards();
            return $this->call($method, self::URL, [], $this->prepareCookiesForRequest(), [], array_merge(['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'text/html'], $headers), json_encode($method === 'DELETE' ? ['current_password' => self::PASS] : $this->payload()));
        };
        $this->safe($send('PUT'), 419, 'csrf_mismatch');
        $this->safe($send('PUT', ['HTTP_X_CSRF_TOKEN' => 'wrong']), 419, 'csrf_mismatch');
        $this->safe($send('PUT', ['HTTP_SEC_FETCH_SITE' => 'cross-site']), 419, 'csrf_mismatch');
        $this->safe($send('PUT', ['HTTP_SEC_FETCH_SITE' => 'same-site']), 419, 'csrf_mismatch');
        $this->safe($send('PUT', ['HTTP_X_CSRF_TOKEN' => $token, 'HTTP_SEC_FETCH_SITE' => 'cross-site']), 200);
        $this->assertSame($this->a->id, Auth::id());
        $this->safe($send('DELETE', ['HTTP_X_CSRF_TOKEN' => $token]), 204);
        // Laravel 13 permits same-origin through Fetch Metadata independently of token matching.
        $this->safe($send('PUT', ['HTTP_SEC_FETCH_SITE' => 'same-origin']), 200);
        $this->assertSame(1, DB::table('rankfree_connections')->count());
        fwrite(STDOUT, "ACTUAL_CSRF no-token=419 wrong=419 cross-site-no-token=419 same-site=419 cross-site-valid-token=200 valid-delete=204 same-origin-no-token=200 cookie-auth-user=".Auth::id()."\n");
    }

    public function test_delete_restore_stale_and_force_delete_cleanup(): void
    {
        $first = $this->store->registerFor($this->a, self::A);
        $this->store->registerFor($this->b, self::B);
        $stale = User::findOrFail($this->a->id);
        $this->a->delete();
        $this->assertDatabaseMissing('rankfree_connections', ['user_id' => $this->a->id]);
        $this->assertSame(self::B, $this->store->credentialFor($this->b)->authorizationKey());
        foreach (['statusFor', 'clientFor', 'disconnectFor'] as $method) {
            try { $this->store->$method($stale); $this->fail('Stale user accepted'); }
            catch (AuthenticationException $e) { $this->assertInstanceOf(AuthenticationException::class, $e); }
        }
        try { $this->store->registerFor($stale, self::A); $this->fail('Stale user registered'); }
        catch (AuthenticationException $e) { $this->assertInstanceOf(AuthenticationException::class, $e); }
        $this->actingAs($stale);
        $this->safe($this->getJson(self::URL), 401, 'unauthenticated');
        $this->safe($this->putJson(self::URL, $this->payload()), 401, 'unauthenticated');
        $this->safe($this->deleteJson(self::URL, ['current_password' => self::PASS]), 401, 'unauthenticated');
        $this->a->restore();
        $this->assertFalse($this->store->statusFor($this->a)['registered']);
        Cache::flush();
        $next = $this->safe($this->actingAs($this->a)->putJson(self::URL, $this->payload()), 200)->json('data.revision');
        $this->assertNotSame($first['revision'], $next);
        $this->safe($this->deleteJson(self::URL, ['current_password' => self::PASS]), 204);
        $this->safe($this->deleteJson(self::URL, ['current_password' => self::PASS]), 204);
        $this->reason(RankfreeException::class, 'account_not_connected', fn () => app(ConnectionStore::class)->clientFor($this->a));
        $this->store->registerFor($this->a, self::A);
        $this->a->forceDelete();
        $this->assertDatabaseMissing('rankfree_connections', ['user_id' => $this->a->id]);
        $this->assertDatabaseHas('rankfree_connections', ['user_id' => $this->b->id]);
    }

    public function test_metadata_replacement_uniqueness_schema_and_migration_round_trip(): void
    {
        $first = $this->store->registerFor($this->a, self::A);
        $old = DB::table('rankfree_connections')->first();
        $this->travel(2)->seconds();
        $second = $this->store->registerFor($this->a, self::A);
        $new = DB::table('rankfree_connections')->first();
        $this->assertNotSame($old->credential_ciphertext, $new->credential_ciphertext);
        $this->assertNotSame($first['revision'], $second['revision']);
        $this->assertSame($first['registered_at'], $second['registered_at']);
        $this->assertNotSame($first['updated_at'], $second['updated_at']);
        $this->assertFalse($second['provider_verified']);
        $this->assertSame(['registered', 'provider_verified', 'revision', 'registered_at', 'updated_at'], array_keys($second));
        $this->assertSame(1, DB::table('rankfree_connections')->count());
        $this->assertSame('text', Schema::getColumnType('rankfree_connections', 'credential_ciphertext'));
        try { DB::table('rankfree_connections')->insert(['user_id' => $this->a->id, 'credential_ciphertext' => 'bogus', 'revision' => '00000000-0000-0000-0000-000000000001']); $this->fail('Unique constraint absent'); }
        catch (Illuminate\Database\QueryException $e) { $this->assertStringContainsString('UNIQUE constraint failed', $e->getMessage()); }
        try { DB::table('rankfree_connections')->insert(['user_id' => 999999, 'credential_ciphertext' => 'bogus', 'revision' => '00000000-0000-0000-0000-000000000001']); $this->fail('Foreign key absent'); }
        catch (Illuminate\Database\QueryException $e) { $this->assertStringContainsString('FOREIGN KEY constraint failed', $e->getMessage()); }
        $migration = require base_path('database/migrations/2026_10_27_000001_create_rankfree_connections_table.php');
        $migration->down();
        $this->assertFalse(Schema::hasTable('rankfree_connections'));
        $migration->up();
        $this->assertTrue(Schema::hasTable('rankfree_connections'));
        $this->assertSame(0, DB::table('rankfree_connections')->count());
        $this->store->registerFor($this->b, self::B);
        $this->assertSame(self::B, $this->store->credentialFor($this->b)->authorizationKey());
    }

    public function test_default_closed_write_five_read_sixty_per_customer_and_time_window(): void
    {
        $this->actingAs($this->a);
        config(['rankfree.connections_enabled' => false]);
        foreach (['GET', 'PUT', 'DELETE'] as $method) {
            $this->safe($this->json($method, self::URL, $method === 'PUT' ? $this->payload() : ['current_password' => self::PASS]), 503, 'connections_disabled');
        }
        $this->assertFalse(config('rankfree.enabled'));
        $this->assertFalse(config('rankfree.submission_enabled'));
        config(['rankfree.connections_enabled' => true]);
        Cache::flush();
        for ($i = 1; $i <= 5; $i++) {
            $method = $i % 2 === 0 ? 'DELETE' : 'PUT';
            $this->safe($this->json($method, self::URL, $method === 'PUT' ? ['api_key' => self::A, 'current_password' => 'wrong'] : ['current_password' => 'wrong']), 422, 'validation_failed');
        }
        $limited = $this->safe($this->putJson(self::URL, $this->payload()), 429, 'rate_limited');
        $limited->assertHeader('X-RateLimit-Limit', '5')->assertHeader('X-RateLimit-Remaining', '0')->assertHeader('Retry-After');
        $this->assertMatchesRegularExpression('/^\d+$/', $limited->headers->get('Retry-After'));
        $this->safe($this->actingAs($this->b)->putJson(self::URL, $this->payload(self::B)), 200);
        $this->actingAs($this->a);
        for ($i = 0; $i < 60; $i++) { $this->safe($this->getJson(self::URL), 200); }
        $this->safe($this->getJson(self::URL), 429, 'rate_limited')->assertHeader('X-RateLimit-Limit', '60')->assertHeader('Retry-After');
        $this->safe($this->actingAs($this->b)->getJson(self::URL), 200);
        $this->travel(61)->seconds();
        $this->safe($this->actingAs($this->a)->putJson(self::URL, $this->payload()), 200);
        $this->safe($this->getJson(self::URL), 200);
        $this->assertDatabaseCount('rankfree_connections', 2);
        fwrite(STDOUT, "RATE_LIMIT write=5+429 read=60+429 B=isolated reset61s=200\n");
    }

    public function test_debug_html_authorization_and_storage_exception_logs_are_fixed(): void
    {
        $this->actingAs($this->a);
        $this->store->registerFor($this->a, self::A);
        $cipher = DB::table('rankfree_connections')->value('credential_ciphertext');
        $this->secrets[] = $cipher;
        foreach ([new AuthorizationException(self::A.' '.self::PASS.' '.$cipher), new RuntimeException(self::A.' '.self::PASS.' '.$cipher), new ConnectionStoreException(self::A)] as $throwable) {
            $this->app->instance(ConnectionStore::class, new class($throwable) extends ConnectionStore {
                public function __construct(private Throwable $problem) {}
                public function statusFor(User $user): array { throw $this->problem; }
            });
            $status = $throwable instanceof AuthorizationException ? 403 : ($throwable instanceof ConnectionStoreException ? 503 : 500);
            $code = $status === 403 ? 'forbidden' : ($status === 503 ? 'connection_storage_unavailable' : 'internal_error');
            $this->safe($this->get(self::URL, ['Accept' => 'text/html']), $status, $code);
        }
        $this->app->instance(ConnectionStore::class, new class extends ConnectionStore {
            public function registerFor(User $user, string $apiKey): array { throw ValidationException::withMessages(['api_key' => [self::bad()], 'current_password' => [self::bad()], 'untrusted_field' => [self::bad()]]); }
            private static function bad(): string { return 'rk_independent_A_secret_marker independent_password_marker'; }
        });
        $this->safe($this->putJson(self::URL, $this->payload(), ['Accept' => 'text/html']), 422, 'validation_failed')
            ->assertJsonPath('error.fields.api_key.0', '입력값을 확인해 주세요.')->assertJsonPath('error.fields.current_password.0', '현재 비밀번호를 확인해 주세요.');
        foreach ($this->logs->getRecords() as $record) {
            $this->assertSame('rankfree_connection_request_failed', $record->message);
            $this->assertSame(['exception_type'], array_keys($record->context));
            $this->assertIsString($record->context['exception_type']);
        }
        $this->assertGreaterThanOrEqual(2, count($this->logs->getRecords()));
    }

    public function test_actual_validator_internal_exception_cannot_leak_request_or_flash(): void
    {
        $this->actingAs($this->a);
        Validator::resolver(function ($translator, $data, $rules, $messages, $attributes) {
            return new class($translator, $data, $rules, $messages, $attributes) extends Illuminate\Validation\Validator {
                public function validateCurrentPassword($attribute, $value, $parameters) { throw new RuntimeException('rk_independent_A_secret_marker independent_password_marker validator internals'); }
            };
        });
        $this->safe($this->putJson(self::URL, $this->payload(), ['Accept' => 'text/html']), 500, 'internal_error');
        $this->assertDatabaseCount('rankfree_connections', 0);
        $records = $this->logs->getRecords();
        $this->assertCount(1, $records);
        $this->assertSame('rankfree_connection_request_failed', $records[0]->message);
        $this->assertSame(['exception_type' => RuntimeException::class], $records[0]->context);
    }

    public function test_resolved_clients_pin_owner_and_fresh_resolver_rejects_disconnect(): void
    {
        config(['rankfree.enabled' => true, 'rankfree.product_fields' => [12 => []]]);
        $this->store->registerFor($this->a, self::A);
        $this->store->registerFor($this->b, self::B);
        $seen = [];
        Http::fake(function (Illuminate\Http\Client\Request $request) use (&$seen) {
            $header = $request->header('Authorization');
            $this->assertCount(1, $header);
            $seen[] = $header[0];
            $this->assertSame('https://rankfree.kr/api/v1/products', $request->url());
            return Http::response(['products' => [['id' => 12, 'title' => 'safe', 'unit_price' => 1, 'orderable' => true]]]);
        });
        $this->expectedHttp = 3;
        $a = $this->store->clientFor($this->a);
        $a->products();
        $this->store->clientFor($this->b)->products();
        $this->store->registerFor($this->a, 'rk_independent_rotated');
        $this->assertNotSame($a, $this->store->clientFor($this->a));
        $this->store->clientFor($this->a)->products();
        $this->store->disconnectFor($this->a);
        $this->reason(RankfreeException::class, 'account_not_connected', fn () => app(ConnectionStore::class)->clientFor($this->a));
        $this->assertSame(self::B, $this->store->credentialFor($this->b)->authorizationKey());
        $this->assertSame(['Bearer '.self::A, 'Bearer '.self::B, 'Bearer rk_independent_rotated'], $seen);
        fwrite(STDOUT, "ISOLATED_TRANSPORT A,B,A-rotated fake=3 after-disconnect=account_not_connected\n");
    }

    public function test_real_guest_csrf_precedes_auth_for_mutations(): void
    {
        $this->app->instance('env', 'independent-http');
        $this->assertFalse($this->app->runningUnitTests());
        $this->safe($this->putJson(self::URL, $this->payload()), 419, 'csrf_mismatch');
        $this->safe($this->deleteJson(self::URL, ['current_password' => self::PASS]), 419, 'csrf_mismatch');
        $token = 'independent_guest_csrf_token';
        $this->withSession(['_token' => $token]);
        session()->save();
        $this->withCookie(config('session.cookie'), session()->getId());
        foreach (['PUT', 'DELETE'] as $method) {
            Auth::forgetGuards();
            $body = $method === 'PUT' ? $this->payload() : ['current_password' => self::PASS];
            $r = $this->call($method, self::URL, [], $this->prepareCookiesForRequest(), [], ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'text/html', 'HTTP_X_CSRF_TOKEN' => $token], json_encode($body));
            $this->safe($r, 401, 'unauthenticated');
        }
        $this->safe($this->get(self::URL, ['Accept' => 'text/html']), 401, 'unauthenticated');
        $this->assertDatabaseCount('rankfree_connections', 0);
        fwrite(STDOUT, "REAL_GUEST mutation-no-token=419 mutation-valid-token=401 read=401\n");
    }

    public function test_guest_and_logged_out_session_have_no_connection_access(): void
    {
        $this->store->registerFor($this->a, self::A);
        foreach (['GET', 'PUT', 'DELETE'] as $method) {
            $this->safe($this->json($method, self::URL, $method === 'PUT' ? $this->payload() : ['current_password' => self::PASS], ['Accept' => 'text/html']), 401, 'unauthenticated');
        }
        $this->actingAs($this->a);
        $this->safe($this->getJson(self::URL), 200)->assertJsonPath('data.registered', true);
        Auth::guard('web')->logout();
        $this->safe($this->get(self::URL, ['Accept' => 'text/html']), 401, 'unauthenticated');
        $this->assertSame(self::A, $this->store->credentialFor($this->a)->authorizationKey());
    }
}
```

## 부록 B. 안전 실행·재현 원문

`safe-environment.json` (키는 fixture 전용 가짜 값):

```json
{
  "PATH": "/Applications/ChatGPT.app/Contents/Resources/codex-cli/codex-path:/Users/anarchy/bin:/Users/anarchy/.grok/bin:/Users/anarchy/.local/bin:/Users/anarchy/.nvm/versions/node/v20.20.2/bin:/Users/anarchy/Library/Python/3.13/bin:/opt/homebrew/bin:/opt/homebrew/sbin:/Library/Frameworks/Python.framework/Versions/3.13/bin:/usr/local/bin:/System/Cryptexes/App/usr/bin:/usr/bin:/bin:/usr/sbin:/sbin:/var/run/com.apple.security.cryptexd/codex.system/bootstrap/usr/local/bin:/var/run/com.apple.security.cryptexd/codex.system/bootstrap/usr/bin:/var/run/com.apple.security.cryptexd/codex.system/bootstrap/usr/appleinternal/bin:/pkg/env/global/bin:/Library/Apple/usr/bin:/opt/homebrew/bin:/Users/anarchy/.codex/tmp/arg0-macos/codex-arg0KWwPpU:/Applications/ChatGPT.app/Contents/Resources/codex-cli/codex-path:/Users/anarchy/.cache/codex-runtimes/codex-primary-runtime/dependencies/bin/override:/Users/anarchy/bin:/Users/anarchy/.grok/bin:/Users/anarchy/.unity/bin:/Users/anarchy/.local/bin:/Users/anarchy/.nvm/versions/node/v20.20.2/bin:/Users/anarchy/Library/Python/3.13/bin:/opt/homebrew/sbin:/Library/Frameworks/Python.framework/Versions/3.13/bin:/Users/anarchy/.cache/codex-runtimes/codex-primary-runtime/dependencies/bin/fallback:/Applications/ChatGPT.app/Contents/Resources:/Applications/ChatGPT.app/Contents/Resources/codex-cli/CodexCLI.app/Contents/MacOS",
  "HOME": "/Users/anarchy",
  "TMPDIR": "/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0",
  "APP_ENV": "testing",
  "APP_KEY": "base64:dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnY=",
  "APP_DEBUG": "false",
  "APP_URL": "http://localhost",
  "DB_CONNECTION": "sqlite",
  "DB_DATABASE": ":memory:",
  "DB_URL": "",
  "DB_FOREIGN_KEYS": "true",
  "CACHE_STORE": "array",
  "SESSION_DRIVER": "array",
  "MAIL_MAILER": "array",
  "QUEUE_CONNECTION": "sync",
  "BCRYPT_ROUNDS": "4",
  "BROADCAST_CONNECTION": "null",
  "LOG_CHANNEL": "single",
  "APP_CONFIG_CACHE": "/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/config.php",
  "VIEW_COMPILED_PATH": "/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/views",
  "RANKFREE_CONNECTIONS_ENABLED": "false",
  "RANKFREE_API_ENABLED": "false",
  "RANKFREE_ORDER_SUBMISSION_ENABLED": "false"
}
```

`generate-config.php` — 실행 전 `empty-env` 폴더를 만들고 아직 config.php가 없는 상태로 실행한다. repo .env 경로는 바라보지 않는다.

```php
<?php
require '/Users/anarchy/Claude_Projects/jcurve/vendor/autoload.php';
$app = require '/Users/anarchy/Claude_Projects/jcurve/bootstrap/app.php';
$app->useEnvironmentPath(__DIR__.'/empty-env');
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$app['config']->set('logging.channels.single.path', __DIR__.'/laravel.log');
$app['config']->set('logging.channels.emergency.path', __DIR__.'/emergency.log');
file_put_contents(__DIR__.'/config.php', '<?php return '.var_export($app['config']->all(), true).';');
echo json_encode(['environment_path'=>$app->environmentPath(),'database'=>$app['config']->get('database.connections.sqlite.database'),'cache'=>$app['config']->get('cache.default'),'session'=>$app['config']->get('session.driver'),'connections_enabled'=>$app['config']->get('rankfree.connections_enabled')]).PHP_EOL;
```

`run.py`:

```python
import json, pathlib, subprocess, sys
p=pathlib.Path(__file__).parent
env=json.loads((p/'safe-environment.json').read_text())
r=subprocess.run(sys.argv[2:],cwd='/Users/anarchy/Claude_Projects/jcurve',env=env,stdout=subprocess.PIPE,stderr=subprocess.STDOUT,text=True)
(p/(sys.argv[1]+'.log')).write_text(r.stdout)
print(r.stdout,end='')
print('EXIT',r.returncode)
sys.exit(r.returncode)
```

`vite.config.mjs`:

```js
import base from '/Users/anarchy/Claude_Projects/jcurve/vite.config.js';
export default { ...base, envDir: '/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/empty-env', build: { ...base.build, outDir: '/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/jcurve-order03-verify-d8z0xvg0/build', emptyOutDir: true } };
```

`mutation.py` — 지정 실험은 이미1회 완료했다. 재검증자가 재실험할 때도 먼저 동결/소유자 조율을 해야 한다.

```python
import pathlib,json,subprocess,hashlib
p=pathlib.Path(__file__).parent
root=pathlib.Path('/Users/anarchy/Claude_Projects/jcurve')
f=root/'app/Services/Rankfree/ConnectionStore.php'
original=f.read_bytes()
needle=b'Crypt::encryptString($credential->authorizationKey())'
assert original.count(needle)==1
sha=lambda b:hashlib.sha256(b).hexdigest()
env=json.loads((p/'safe-environment.json').read_text())
command=['php','artisan','test','--compact','--filter=RankfreeConnectionApiTest::test_registration_stores_authenticated_ciphertext_without_returning_key_material']
result={'before_sha256':sha(original),'command':command}
try:
 mutated=original.replace(needle,b'$credential->authorizationKey()')
 f.write_bytes(mutated)
 result['mutated_sha256']=sha(mutated)
 r=subprocess.run(command,cwd=root,env=env,stdout=subprocess.PIPE,stderr=subprocess.STDOUT,text=True)
 (p/'mutation-failed.log').write_text(r.stdout)
 result['mutated_exit']=r.returncode
 print(r.stdout)
finally:
 f.write_bytes(original)
 result['restored_sha256']=sha(f.read_bytes())
 result['restored_bytes_equal']=f.read_bytes()==original
 (p/'mutation-result.json').write_text(json.dumps(result,indent=2))
assert result['restored_bytes_equal']
r=subprocess.run(command,cwd=root,env=env,stdout=subprocess.PIPE,stderr=subprocess.STDOUT,text=True)
(p/'mutation-restored.log').write_text(r.stdout)
result['restored_exit']=r.returncode
(p/'mutation-result.json').write_text(json.dumps(result,indent=2))
print(r.stdout)
print(json.dumps(result,indent=2))
assert result['mutated_exit']==1
assert 'Failed asserting that two strings are not identical' in (p/'mutation-failed.log').read_text()
assert result['restored_exit']==0
```
