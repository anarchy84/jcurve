# VERIFY-INTL-04 독립 검증 결과

- 검증자: Codex, 구현 세션과 별도 세션. 작업 ID `VERIFY-INTL-04`.
- 작업 폴더: `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`.
- 날짜: 2026-11-03 (Asia/Seoul). 시작 HEAD `69cc75d0a92648ed86505c3c841e8a9e0784d539`. 동시 세션의 checkpoint로 HEAD가 움직였으므로 대상 파일 SHA-256을 검증 단위로 삼았다.
- **U1~U10: PASS 6 / FAIL 4.** FAIL: U2·U5·U7·U9. 최종 출시·제품 합격 결정은 Claude/사용자 검수에 남긴다.
- 이번 세션의 저장소 산출물은 이 결과 문서 하나다. 제품 코드·번역·원문·테스트 수정, 커밋·푸시·배포 없음. INTL-04D 블로그 JSON과 INTL-02 검증 문서는 열람·수정·복구하지 않았다.
- 실DB·다른 세션 SQLite·`.env`를 사용하지 않았다. SQLite `:memory:`와 전용 캐시·컴파일 뷰, 환경 파일 로더 차단 가드로 실행했다.
- 구현 결과 문서 A/B/C는 주장과 점검 범위를 파악하는 데만 읽었다. 구현자 점검 스크립트는 실행하거나 가져오지 않았다. 아래 데이터는 새 `export.php`·`analyze.py`·`render.php`·`run.py`로 재현했다.

## 1. U1~U10 판정

| 항목 | 판정 | 직접 재현 근거 |
| --- | --- | --- |
| U1 | PASS | 세 구현 로그 32,572,295 bytes, exec 130개. 지정 키워드 15회는 문서 인용/서술, 실제 명령 내 호출 0. |
| U2 | FAIL | 6개 배열의 키·순서·자료형 동일, 비표시 기술값 변경 0. 그러나 원문=재번역 전 사본인 잎 58개가 바뀜(영어 57, 일본어 1). 지시서의 잎 바이트 보존 조건을 그대로 적용. |
| U3 | PASS | 6개 파일 문자열 한글 0·키 노출 0. 번역 렌더 42/42에서 보이는 글자·title·meta·alt·aria-label·JSON-LD 한글/키 노출 0. 언어 전환 title의 한국어 84회만 예외. |
| U4 | PASS | 원문 대응 2,844잎의 숫자 비교. 차이 후보 41개: Call2Sale 이름 38개·억/만 표기 2개·문장 내 순서 변경 1개. 정규화 값/연도/%/원화 통화 변경 0. |
| U5 | FAIL | 지정 부정 표현 280잎 전수, 부정어 미검출 17잎 직접 대조. YouTube lead의 조회수 구매 제외를 more than buying views로 약화함. |
| U6 | PASS | 지정 업계 용어 후보 572잎 전수. 금지 예 단어 0. 문자 대응 미검출 119잎은 의미/동형어를 판정하고 불일치를 별도 표시. 대응 불일치 자체는 지시서상 FAIL 기준이 아님. |
| U7 | FAIL | 길이 이상치 31잎 전수·이탈도 상위 15개 직접 검토는 모두 정상. 별도 대조에서 CTA의 배제 조건, 보험 비교 제목의 양쪽 비교 대상 누락 확인. 보장·최상급 후보 106잎 중 새 실적·긍정 보장 추가 0. |
| U8 | PASS | FAQ en/ja 각각 81문항, 원문과 6분류의 순서·문항 수 동일. DOM과 FAQPage JSON-LD의 질문·답변 순서까지 일치. 개인정보 4조항 순서·원문 우선 고지·법령·보유 조건·연락처 보존. |
| U9 | FAIL | 언어별 30잎 무작위 표본(EN seed 2026110304, JA seed 2026110305). 표본 60개: OK 57·어색 2·오역 1. U5·U6 의심 건도 대조; 전체 확인된 의미 결함은 3키. |
| U10 | PASS | php artisan test 최종 206/206, 36,008 assertions. 대상 PHP 6개 문법/Pint 통과. 서브페이지 19×2+FAQ×2+개인정보×2=42/42 HTTP 200·html lang 일치. 04D 기인 실패 0. |

### 의미 결함 3곳 — 미수정, 검수용 대안만 제시

| 파일 | 키 | 한국어 원문 | 현재 번역 | 판정/영향 | 대안 |
| --- | --- | --- | --- | --- | --- |
| lang/en/subpages.php | cpa.items.insurance.sections.4.title | 일반 신청 DB와 퍼미션 DB의 차이는 ‘전달 전 확인’입니다 | The difference is verification before delivery | 오역 — 일반 신청 DB와 퍼미션 DB라는 두 비교 대상을 제목에서 모두 삭제함. | The difference between standard application leads and consent-based leads is verification before delivery. |
| lang/en/subpages.php | performance.items.youtube.lead | 유튜브 마케팅은 영상을 많이 올리거나 조회수를 사는 일이 아닙니다. 누구에게 어떤 문제를 어떤 형식으로 설명할지 정하고, 광고와 채널 콘텐츠의 역할을 나눠 시청 이후 검색·방문·문의로 이어지는 흐름을 만듭니다. | YouTube marketing is more than uploading videos or buying views. We define the audience, problem and format, then give ads and channel content distinct roles that lead viewers toward searches, visits and inquiries. | 오역 — 조회수 구매를 부정한 원문을 more than으로 바꿔 구매도 업무의 일부인 듯한 여지를 만듦. | YouTube marketing is not about uploading large numbers of videos or buying views. We define the audience, the problem to address and the format, then give ads and channel content distinct roles that lead viewers toward searches, visits and inquiries. |
| lang/en/subpages.php | boostingshop.items.instagram-popular.cta.title | 노출 자리를 사기보다, 발견될 이유를 만드세요 | Give people a reason to discover you | 오역 — 노출 자리를 사기보다라는 대조·서비스 경계가 잎 전체에서 누락됨. | Build reasons to be discovered instead of buying placement. |

YouTube의 `more than`은 단순 문장 취향으로 판정하지 않았다. 원문의 `조회수를 사는 일이 아닙니다`는 구매를 설명 범위에서 배제하는 반면, 현재 표현은 구매 이상의 다른 일도 한다는 의미를 허용한다. 보험 비교 제목의 누락은 표/주변 본문에서 용어를 찾을 수 있어도 지시서의 **잎별** 판정에서 복구된 것으로 보지 않았다.

## 2. 재현 명령·실제 출력·격리

전용 임시 디렉터리: `/private/tmp/verify-intl04-20261103-independent`. 명령은 전부 해당 worktree를 cwd로 사용했다.

```sh
python3 /private/tmp/verify-intl04-20261103-independent/run.py capture
python3 /private/tmp/verify-intl04-20261103-independent/run.py render
python3 /private/tmp/verify-intl04-20261103-independent/analyze.py
python3 /private/tmp/verify-intl04-20261103-independent/mutation.py
python3 /private/tmp/verify-intl04-20261103-independent/run.py gates
python3 /private/tmp/verify-intl04-20261103-independent/run.py test
```

`run.py`는 PHP에 다음 **명령 단위** 환경을 넘겼다. 웹 서버·브라우저·외부 번역/웹 호출은 쓰지 않고 Laravel HTTP 커널을 직접 호출했다.

```text
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=
APP_URL=http://localhost DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL=
CACHE_STORE=array SESSION_DRIVER=array MAIL_MAILER=array QUEUE_CONNECTION=sync BCRYPT_ROUNDS=4 LOG_CHANNEL=stderr
APP_CONFIG_CACHE=/private/tmp/verify-intl04-20261103-independent/cache/config.php
APP_ROUTES_CACHE=/private/tmp/verify-intl04-20261103-independent/cache/routes.php
APP_SERVICES_CACHE=/private/tmp/verify-intl04-20261103-independent/cache/services.php
APP_PACKAGES_CACHE=/private/tmp/verify-intl04-20261103-independent/cache/packages.php
VIEW_COMPILED_PATH=/private/tmp/verify-intl04-20261103-independent/views
```

가드는 `LoadEnvironmentVariables`를 비로딩 구현으로 교체하고 환경 디렉터리를 존재하지 않는 전용 경로로 지정한다. `--env=testing`은 artisan test가 원래 환경 파일을 다시 읽는 경로도 차단한다. 부트 후 DB가 정확히 sqlite/:memory:가 아니면 즉시 예외, Laravel HTTP `preventStrayRequests()` 활성화, PHP http/https stream wrapper 비활성화. Composer의 App/Tests/Database 경로도 현재 worktree로 다시 지정했다.

주요 실제 출력:

```text
Rendered 63 routes; 0 status/lang errors []
structure: en/ja subpages 1338 leaves each; faq 389 each; privacy 14 each; shape_equal=true x6
pairs=2844; negative=280; negative_missing=17; terms=572; term_mismatches=119
hangul=0; file_exposed_keys=0; render_issues=0; allowed_korean=84
numbers=41; outliers=31; forbidden=0; technical_changed=0; equal_source_before_changed=58
{"tool":"pint","result":"passed"}
{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":25894}
```

63개는 한국어 원문 대조 21개를 추가한 수이며, 합격 게이트의 번역 화면은 42개다. 렌더 스냅샷 HTML·구조화 추출 JSON은 전용 `html/`·`renders.json`에 있다.

첫 전체 테스트는 검증 스크립트의 `APP_URL=https://j-curve.co.kr`로 인해 URL 기본값을 localhost로 기대하는 `IntlFoundationTest::test_url_helpers_preserve_addresses_and_use_public_origin_for_alternates`와 `UrlPreservationTest::test_generated_urls_cover_parameters_queries_fragments_and_relative_routes` 2개가 실패(204/206)했다. **검증 스크립트만** 기본값 `http://localhost`로 바로잡은 뒤 전체 206/206 통과. 제품 결함이나 04D 실패로 집계하지 않았다. 초회·최종 출력을 각각 `gates.json`·`test-final.json`으로 보존했다. 테스트 중 나오는 rankfree 예외 경고 2개는 예외 처리 테스트 출력이며 최종 실패가 아니다.

### 도구·파일 경계

context-mode 호출은 `MCP tool call requires approval, but approval policy is never`로 실행되지 않았다. 로컬 분석 스크립트로 대체해 검증을 완료했다. 대시보드·요청 큐 갱신은 이번 사용자의 결과 문서 외 수정 금지와 범위 외 경로 조건에 따라 실행하지 않았다.

## 3. U1 외부 번역 호출 로그 감사

원문/지시서 출력과 실제 exec 명령을 구분했다. 모든 키워드 일치 위치를 기록하며, 실제 명령 헤더 경계 내부에 들어오는지 검사했다. 로그가 증명하는 범위의 결론이며 패킷 캡처를 했다는 뜻은 아니다.

| 로그 | bytes | exec 수 | 지정 키워드 수 | 실제 명령 내 호출 | SHA-256 |
| --- | --- | --- | --- | --- | --- |
| codex-intl04a.log | 15259443 | 41 | 3 | 0 | 72065565d97723c4778e2ff1ae6feadb4af491e57e5f6254d80d05b64b293567 |
| codex-intl04b.log | 13835806 | 58 | 8 | 0 | 0b33bb4d24aeb1f8937fb38b641356188ab1265ff011ce68c53bb49035caba4f |
| codex-intl04c.log | 3477046 | 31 | 4 | 0 | 2a393d8d7c2ea07a500b6adc705cfd1a188fb217400de7dbb95fe829a75ea335 |

| 로그 | 행 | 일치 문자열 | 구분 | 실제 문맥 |
| --- | --- | --- | --- | --- |
| codex-intl04a.log | 172 | translate.googleapis | SPEC 본문 인용 | }.php`.<br><br>## 왜 다시 하나<br>INTL-02(서브페이지·FAQ·개인정보처리방침)와 INTL-03(블로그)은 공개 원문을 Google 번역 무료 엔드포인트(`translate.googleapis.com`)에 넣어 초벌을 만들었다. Claude 검수에서 이런 오역이 나왔다:<br>- 일본어 「반려(리드 거절)」→ 「ペット(애완동물)」, 「광고 지면」→ 「広告地面」「ディスプレイグ |
| codex-intl04a.log | 178 | Papago | SPEC 본문 인용 |  누락<br>외국 기업이 읽는 B2B 문서로 쓸 수 없는 수준이다.<br><br>## 절대 규칙<br>1. **외부 번역 서비스·API·웹 요청 금지**(Google 번역·DeepL·Papago 등 전부, `curl`·`file_get_contents('http…')` 포함). 네가 한국어 원문을 직접 읽고 직접 번역한다. 반환물에 「외부 요청 0」 근거(사용한 명령 목 |
| codex-intl04a.log | 178 | file_get_contents('http | SPEC 본문 인용 |  쓸 수 없는 수준이다.<br><br>## 절대 규칙<br>1. **외부 번역 서비스·API·웹 요청 금지**(Google 번역·DeepL·Papago 등 전부, `curl`·`file_get_contents('http…')` 포함). 네가 한국어 원문을 직접 읽고 직접 번역한다. 반환물에 「외부 요청 0」 근거(사용한 명령 목록)를 적는다.<br>2. 기존 번역을 단어 단위로 고치지 말고, **한국 |
| codex-intl04b.log | 176 | translate.googleapis | SPEC 본문 인용 | }.php`.<br><br>## 왜 다시 하나<br>INTL-02(서브페이지·FAQ·개인정보처리방침)와 INTL-03(블로그)은 공개 원문을 Google 번역 무료 엔드포인트(`translate.googleapis.com`)에 넣어 초벌을 만들었다. Claude 검수에서 이런 오역이 나왔다:<br>- 일본어 「반려(리드 거절)」→ 「ペット(애완동물)」, 「광고 지면」→ 「広告地面」「ディスプレイグ |
| codex-intl04b.log | 182 | Papago | SPEC 본문 인용 |  누락<br>외국 기업이 읽는 B2B 문서로 쓸 수 없는 수준이다.<br><br>## 절대 규칙<br>1. **외부 번역 서비스·API·웹 요청 금지**(Google 번역·DeepL·Papago 등 전부, `curl`·`file_get_contents('http…')` 포함). 네가 한국어 원문을 직접 읽고 직접 번역한다. 반환물에 「외부 요청 0」 근거(사용한 명령 목 |
| codex-intl04b.log | 182 | file_get_contents('http | SPEC 본문 인용 |  쓸 수 없는 수준이다.<br><br>## 절대 규칙<br>1. **외부 번역 서비스·API·웹 요청 금지**(Google 번역·DeepL·Papago 등 전부, `curl`·`file_get_contents('http…')` 포함). 네가 한국어 원문을 직접 읽고 직접 번역한다. 반환물에 「외부 요청 0」 근거(사용한 명령 목록)를 적는다.<br>2. 기존 번역을 단어 단위로 고치지 말고, **한국 |
| codex-intl04b.log | 86712 | Papago | 외부 호출 없음 설명/문서 patch 반복 | 부 요청 0 근거와 실행 명령 기록<br>+<br>+도구 이력에서 웹 검색·브라우저·외부 번역 커넥터·HTTP 전송 도구는 호출하지 않았다. 원문을 Google·DeepL·Papago 등으로 전송한 작업은 없다. 로컬 파일만 처리했고, 테스트에서는 위 HTTP 외부 요청 차단 가드를 사용했다.<br>+<br>+실제 사용한 명령군:<br>+<br>+```text<br>+cat /Users |
| codex-intl04b.log | 90685 | Papago | 외부 호출 없음 설명/문서 patch 반복 | 부 요청 0 근거와 실행 명령 기록<br>+<br>+도구 이력에서 웹 검색·브라우저·외부 번역 커넥터·HTTP 전송 도구는 호출하지 않았다. 원문을 Google·DeepL·Papago 등으로 전송한 작업은 없다. 로컬 파일만 처리했고, 테스트에서는 위 HTTP 외부 요청 차단 가드를 사용했다.<br>+<br>+실제 사용한 명령군:<br>+<br>+```text<br>+cat /Users |
| codex-intl04b.log | 94661 | Papago | 외부 호출 없음 설명/문서 patch 반복 | 부 요청 0 근거와 실행 명령 기록<br>+<br>+도구 이력에서 웹 검색·브라우저·외부 번역 커넥터·HTTP 전송 도구는 호출하지 않았다. 원문을 Google·DeepL·Papago 등으로 전송한 작업은 없다. 로컬 파일만 처리했고, 테스트에서는 위 HTTP 외부 요청 차단 가드를 사용했다.<br>+<br>+실제 사용한 명령군:<br>+<br>+```text<br>+cat /Users |
| codex-intl04b.log | 98651 | Papago | 외부 호출 없음 설명/문서 patch 반복 | 부 요청 0 근거와 실행 명령 기록<br>+<br>+도구 이력에서 웹 검색·브라우저·외부 번역 커넥터·HTTP 전송 도구는 호출하지 않았다. 원문을 Google·DeepL·Papago 등으로 전송한 작업은 없다. 로컬 파일만 처리했고, 테스트에서는 위 HTTP 외부 요청 차단 가드를 사용했다.<br>+<br>+실제 사용한 명령군:<br>+<br>+```text<br>+cat /Users |
| codex-intl04b.log | 102624 | Papago | 외부 호출 없음 설명/문서 patch 반복 | 부 요청 0 근거와 실행 명령 기록<br>+<br>+도구 이력에서 웹 검색·브라우저·외부 번역 커넥터·HTTP 전송 도구는 호출하지 않았다. 원문을 Google·DeepL·Papago 등으로 전송한 작업은 없다. 로컬 파일만 처리했고, 테스트에서는 위 HTTP 외부 요청 차단 가드를 사용했다.<br>+<br>+실제 사용한 명령군:<br>+<br>+```text<br>+cat /Users |
| codex-intl04c.log | 195 | translate.googleapis | SPEC 본문 인용 | }.php`.<br><br>## 왜 다시 하나<br>INTL-02(서브페이지·FAQ·개인정보처리방침)와 INTL-03(블로그)은 공개 원문을 Google 번역 무료 엔드포인트(`translate.googleapis.com`)에 넣어 초벌을 만들었다. Claude 검수에서 이런 오역이 나왔다:<br>- 일본어 「반려(리드 거절)」→ 「ペット(애완동물)」, 「광고 지면」→ 「広告地面」「ディスプレイグ |
| codex-intl04c.log | 201 | Papago | SPEC 본문 인용 |  누락<br>외국 기업이 읽는 B2B 문서로 쓸 수 없는 수준이다.<br><br>## 절대 규칙<br>1. **외부 번역 서비스·API·웹 요청 금지**(Google 번역·DeepL·Papago 등 전부, `curl`·`file_get_contents('http…')` 포함). 네가 한국어 원문을 직접 읽고 직접 번역한다. 반환물에 「외부 요청 0」 근거(사용한 명령 목 |
| codex-intl04c.log | 201 | file_get_contents('http | SPEC 본문 인용 |  쓸 수 없는 수준이다.<br><br>## 절대 규칙<br>1. **외부 번역 서비스·API·웹 요청 금지**(Google 번역·DeepL·Papago 등 전부, `curl`·`file_get_contents('http…')` 포함). 네가 한국어 원문을 직접 읽고 직접 번역한다. 반환물에 「외부 요청 0」 근거(사용한 명령 목록)를 적는다.<br>2. 기존 번역을 단어 단위로 고치지 말고, **한국 |
| codex-intl04c.log | 512 | curl http | context-mode 사용 예 인용 |  the hook injects them. Just write natural task descriptions.<br><br>## Anti-Patterns<br><br>- Using `curl http://api/endpoint` via Bash → 50KB floods context. Use `ctx_execute` with fetch instead.<br>- Using `cat  |

## 4. U2 구조·값 보존

재번역 전 사본 4개는 지시서의 `scratchpad/pre04/`에서 직접 읽었다. 개인정보 사전 사본이 그 디렉터리에 없어, 개인정보 변경 전 checkpoint `0f18dc6a329770671f05bfab159f54b5ab6527fb`의 두 파일을 `git show <commit>:lang/<locale>/pages/privacy.php`로 읽어 비교했다(체크아웃/쓰기 없음). 원문 FAQ는 `faq-data.php`와 Blade의 고정 UI 문구, 결과 라벨은 연결 JS의 `검색 결과`를 사용했다. 개인정보는 한국어 Blade의 h1·서문·4개 section·마지막 고지를 DOM으로 추출했다.

| 언어 | 유형 | 사전 잎 수 | 현재 잎 수 | 키·순서·자료형 |
| --- | --- | --- | --- | --- |
| en | subpages | 1338 | 1338 | 동일 |
| en | faq | 389 | 389 | 동일 |
| en | privacy | 14 | 14 | 동일 |
| ja | subpages | 1338 | 1338 | 동일 |
| ja | faq | 389 | 389 | 동일 |
| ja | privacy | 14 | 14 | 동일 |

구조 검사에는 모든 배열 노드의 자식 키 순서·자료형·빈 배열이 포함된다. 비표시 route/param/params/type/tone/href/id/contact_interest/icon/slug/source_hash 및 숫자/비문자 값의 사전본 대비 차이는 0이다.

**엄격 조건 구분:** 아래 58개는 비표시 기술값이 아니라 사람이 읽는 eyebrow다. 일반 SPEC의 사람용 문자열 수정 허용·영어 문장형 제목 규칙에는 설명 가능한 변경이지만, VERIFY U2의 「원문 값과 바이트가 같은 잎은 이후에도 바이트 동일」에는 예외가 적혀 있지 않다. 검증자가 임의로 예외를 승인하지 않고 U2를 FAIL로 남긴다. 기술값 파손이 58개라는 뜻은 아니다. 최종 검수자가 사람용 기존 영어 eyebrow를 이 조건에서 제외하면 U2만 별도로 재판정할 수 있다.

| 파일 | 키 | 원문=사전본 | 현재 번역 | 바이트 판정 |
| --- | --- | --- | --- | --- |
| lang/en/subpages.php | seo.items.backlinks.eyebrow | Link Building | Link building | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | seo.items.backlinks.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | seo.items.naver-place.eyebrow | Local Search | Local search | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | seo.items.naver-place.sections.2.eyebrow | Check List | Checklist | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | seo.items.naver-place.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | seo.items.naver-shopping.sections.2.eyebrow | Optimization Scope | Optimization scope | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | seo.items.naver-shopping.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | seo.items.kakao-gift.eyebrow | Gift Commerce | Gift commerce | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | seo.items.kakao-gift.sections.2.eyebrow | Check List | Checklist | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | seo.items.kakao-gift.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | seo.items.coupang.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.real-estate.eyebrow | Real Estate CPA | Real estate CPA | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.real-estate.sections.2.eyebrow | Before Launch | Before launch | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.real-estate.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.stock.eyebrow | Finance Lead CPA | Stock-investor CPA | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.stock.sections.2.eyebrow | Required Review | Required review | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.stock.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.0.eyebrow | End-to-End Insurance Lead | End-to-end insurance leads | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.1.eyebrow | Operating Record | Operating record | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.2.eyebrow | Where Insurance Leads Break | Where insurance leads break | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.3.eyebrow | Permission Marketing | Consent-based marketing | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.5.eyebrow | Lead Production Flow | Lead production flow | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.6.eyebrow | Four Operating Principles | Four operating principles | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.7.eyebrow | Decision Variables | Decision variables | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.8.eyebrow | Validity &amp; AS Matrix | Validity and after-sales support | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.9.eyebrow | Custom Script &amp; Allocation | Custom scripts and allocation | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.10.eyebrow | LeadBay Features | LeadBay features | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.11.eyebrow | LeadBay Core Workflow | LeadBay core workflow | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.12.eyebrow | Supply-Side Operations | Supply-side operations | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.13.eyebrow | Pilot To Scale | Pilot to scale | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.14.eyebrow | Compliance Boundary | Compliance boundaries | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.insurance.sections.15.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.coin.eyebrow | Digital Asset Lead CPA | Crypto-investor CPA | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.coin.sections.2.eyebrow | Required Review | Required review | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.coin.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.permission-call.eyebrow | Permission Marketing | Consent-based marketing | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.permission-call.sections.2.eyebrow | Compliance Check | Compliance check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | cpa.items.permission-call.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | performance.items.naver-gfa.eyebrow | Naver GFA | NAVER GFA | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | performance.items.naver-gfa.sections.2.eyebrow | Operation Scope | Management scope | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | performance.items.naver-gfa.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | performance.items.facebook.eyebrow | Meta Advertising | Meta advertising | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | performance.items.facebook.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | performance.items.youtube.eyebrow | YouTube Marketing | YouTube marketing | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | performance.items.youtube.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.basic.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.pro.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.elite.sections.3.eyebrow | Fit Check | Fit check | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.instagram-popular.eyebrow | Instagram Discovery Guide | Instagram discovery guide | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.1.eyebrow | Discovery Options | Discovery options | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.3.eyebrow | Policy Gate | Policy requirements | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.instagram-followers.eyebrow | Instagram Growth Guide | Instagram growth guide | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.instagram-followers.sections.1.eyebrow | Growth Options | Growth options | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.instagram-followers.sections.3.eyebrow | Policy Gate | Policy requirements | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.instagram-likes.eyebrow | Instagram Engagement Guide | Instagram engagement guide | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.instagram-likes.sections.1.eyebrow | Engagement Options | Engagement options | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/en/subpages.php | boostingshop.items.instagram-likes.sections.3.eyebrow | Policy Gate | Policy requirements | FAIL: 동일 잎 변경(사람용 eyebrow) |
| lang/ja/subpages.php | cpa.items.insurance.sections.8.eyebrow | Validity &amp; AS Matrix | 有効判定とアフターサポートの対応基準 | FAIL: 동일 잎 변경(사람용 eyebrow) |

## 5. U3·U4 문자열·숫자

PHP를 직접 로딩해 얻은 **전체 스칼라 3,482잎**을 파일 한글·키 노출 검사에 사용했다. 한국어 대응 사람용 문자열은 언어별 서브페이지 1,136 + FAQ 274 + 개인정보 12 = 1,422, 합계 2,844쌍이다. 원문에 없는 개인정보 description·translation_notice도 파일·화면 검사에서 빠뜨리지 않았으며, 전자는 4조항의 요약, 후자는 지시서가 요구한 고지로 직접 확인했다.

렌더는 텍스트 노드(스크립트·스타일 제외), 모든 meta content·alt·title·aria-label·placeholder를 수집하고 application/ld+json을 전부 JSON 파싱해 문자열을 재귀 검사했다. `한국어` 예외는 정확한 문자열 + 실제 `data-intl-switcher` 조상 조건을 동시에 만족할 때만 허용했다. en/ja 화면의 해당 title 84회 이외 한글 0, 번역 키 0이다.

숫자 비교는 콤마 제거·Decimal·억=10^8/만=10^4/億/万/B/M/K 및 billion/million/thousand를 원값으로 환산한다. `B2B`·`Call2Sale`·`C2S`의 상표 숫자는 숫자 주장과 분리한다. 차이 후보는 전부 아래에 남겼다. 숫자 없는 잎 역시 비교 대상이며, 유일한 정규화 토큰 순서 차이는 백링크 meta의 10년↔1,000프로젝트 어순 이동이다. 값의 multiset이 같고 각 문맥도 동일하다. 통화 환산·수치 추가·연도/% 변경은 없다.

| 파일 | 키 | 한국어 | 번역 | 원문 정규화 | 번역 정규화 | 판정 |
| --- | --- | --- | --- | --- | --- | --- |
| lang/en/subpages.php | seo.items.backlinks.meta_description | 10년간 1,000여 개의 SEO 프로젝트를 성공적으로 수행하며 얻은 검색엔진최적화에 대한 깊은 이해와 경험을 바탕으로 제공하는 전문 백링크 서비스로 검색엔진 상위노출을 경험하세요. 구글과 네이버에 최적화된 검증된 고품질 백링크 전략은 자연스러운 순위 상승을 돕습니다. 무료 컨설팅을 신청하세요. | Our specialist backlink service draws on deep SEO knowledge gained from successfully delivering over 1,000 SEO projects in 10 years. Our proven, quality backlink strategies for Google and NAVER — Korea's largest search portal — support natural ranking improvements. Request a free consultation. | ['1E+1', '1E+3'] | ['1E+3', '1E+1'] | 정상: 10년·1,000프로젝트의 문장 어순만 이동 |
| lang/en/subpages.php | cpa.items.insurance.inquiry_template | [보험 CPA·퍼미션 DB 문의]<br><br>조직 형태 / 설계사 수: <br>희망 DB 유형: <br>희망 지역: <br>월 희망 물량: <br>현재 DB 구매·배분 방식: <br>필요 범위: 광고 유입 / DB 납품 / 리드베이 / 콜투세일<br>현재 유효·AS 기준: <br>시작 희망일:  | [Insurance CPA and consent-based lead inquiry]<br><br>Organization type / Number of insurance agents: <br>Preferred lead type: <br>Target regions: <br>Desired monthly volume: <br>Current lead purchasing and allocation process: <br>Required scope: Ad acquisition / Lead delivery / LeadBay / Call2Sale<br>Current validity and after-sales support criteria: <br>Preferred start date:  | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.items.2.title | 콜투세일 · 공급 조직 | Call2Sale · lead suppliers | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.items.2.label | 콜투세일 자세히 보기 | Explore Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/subpages.php | cpa.items.insurance.sections.1.items.0.title | 373억+ | KRW 37.3B+ | ['3.73E+10'] | ['3.73E+10'] | 정상: 373억 = 37.3B KRW |
| lang/en/subpages.php | cpa.items.insurance.sections.1.items.1.title | 128만+ | 1.28M+ | ['1.28E+6'] | ['1.28E+6'] | 정상: 128만 = 1.28M |
| lang/en/subpages.php | cpa.items.insurance.sections.12.title | DB를 생산·납품하는 콜센터라면 콜투세일로 이어집니다 | Call2Sale supports call centers that produce and deliver leads | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/subpages.php | cpa.items.insurance.sections.12.note | 리드베이는 DB를 활용하는 구매·영업 조직, 콜투세일은 DB를 생산·납품하는 공급 조직의 흐름에 초점을 둡니다. | LeadBay focuses on buyers and sales teams using leads. Call2Sale focuses on suppliers producing and delivering them. | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/subpages.php | cpa.items.insurance.sections.12.link.label | 콜투세일 전체 구조 확인 | Explore the Call2Sale workflow | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/subpages.php | cpa.items.insurance.faq.9.question | 리드베이와 콜투세일은 어떻게 다른가요? | How do LeadBay and Call2Sale differ? | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/subpages.php | cpa.items.insurance.faq.9.answer | 리드베이는 보험DB를 비교·구매하고 배분·상담·계약·AS·정산하는 영업조직의 흐름에, 콜투세일은 DB를 생산·검수·납품하는 콜센터의 공급 운영에 초점을 둡니다. 실제 기능과 연동 범위는 각 서비스의 현재 조건을 확인해야 합니다. | LeadBay focuses on sales teams comparing, buying, allocating and using insurance leads through consultation, contracts, support and settlement. Call2Sale focuses on call centers producing, reviewing and delivering leads. Check each service's current terms for actual features and integration scope. | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/subpages.php | cpa.items.insurance.cta.text | 조직 규모, 희망 지역·물량, DB 유형과 현재 운영 방식을 알려주시면 광고 유입·퍼미션콜·리드베이·콜투세일 중 필요한 범위를 구체적으로 나눠드립니다. | Tell us your organization size, target regions, volume, lead types and current workflow. We will identify the specific scope you need across ad acquisition, consent verification calls, LeadBay and Call2Sale. | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/pages/faq.php | description | 제이커브인터렉티브 고객센터. 퍼포먼스·CPA·리워드 광고, SEO·AEO·GEO, 셀프마케팅·부스팅샵, 리드베이·콜투세일, 웹 제작·지원사업에 대해 자주 묻는 질문과 답변을 한곳에 모았습니다. | Find answers about performance, CPA and rewarded ads, SEO, AEO (Answer Engine Optimization), GEO (Generative Engine Optimization), self-serve marketing, BoostingShop, LeadBay, Call2Sale, web builds and support programs. | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/pages/faq.php | categories.crm.label | 리드베이·콜투세일 | LeadBay &amp; Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/pages/faq.php | categories.crm.items.7.q | 콜투세일은 어떤 조직을 위한 서비스인가요? | Who is Call2Sale designed for? | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/pages/faq.php | categories.crm.items.7.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/pages/faq.php | categories.crm.items.8.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/pages/faq.php | categories.crm.items.9.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/pages/faq.php | categories.crm.items.10.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/pages/faq.php | categories.crm.items.11.q | 콜투세일이 DB의 적법성을 보장하나요? | Does Call2Sale guarantee that leads are lawful? | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/pages/faq.php | categories.crm.items.11.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/en/pages/faq.php | categories.crm.items.12.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/subpages.php | cpa.items.insurance.inquiry_template | [보험 CPA·퍼미션 DB 문의]<br><br>조직 형태 / 설계사 수: <br>희망 DB 유형: <br>희망 지역: <br>월 희망 물량: <br>현재 DB 구매·배분 방식: <br>필요 범위: 광고 유입 / DB 납품 / 리드베이 / 콜투세일<br>현재 유효·AS 기준: <br>시작 희망일:  | [保険CPA・同意取得済みリードのお問い合わせ]<br><br>組織形態 / 保険募集人数: <br>希望するリードの種類: <br>希望地域: <br>月間希望件数: <br>現在のリード購入・配分方法: <br>必要な範囲: 広告からの獲得 / リード納品 / LeadBay / Call2Sale<br>現在の有効認定・アフターサポート基準: <br>希望開始日:  | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.items.2.title | 콜투세일 · 공급 조직 | Call2Sale（コールトゥセール）・供給組織 | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.items.2.label | 콜투세일 자세히 보기 | Call2Saleを詳しく見る | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/subpages.php | cpa.items.insurance.sections.12.title | DB를 생산·납품하는 콜센터라면 콜투세일로 이어집니다 | リードを獲得・納品するコールセンターにはCall2Saleを | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/subpages.php | cpa.items.insurance.sections.12.note | 리드베이는 DB를 활용하는 구매·영업 조직, 콜투세일은 DB를 생산·납품하는 공급 조직의 흐름에 초점을 둡니다. | LeadBayはリードを活用する購入・営業組織、Call2Saleはリードを獲得・納品する供給組織の業務に重点を置いています。 | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/subpages.php | cpa.items.insurance.sections.12.link.label | 콜투세일 전체 구조 확인 | Call2Saleの全体構成を確認する | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/subpages.php | cpa.items.insurance.faq.9.question | 리드베이와 콜투세일은 어떻게 다른가요? | LeadBayとCall2Saleの違いは何ですか？ | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/subpages.php | cpa.items.insurance.faq.9.answer | 리드베이는 보험DB를 비교·구매하고 배분·상담·계약·AS·정산하는 영업조직의 흐름에, 콜투세일은 DB를 생산·검수·납품하는 콜센터의 공급 운영에 초점을 둡니다. 실제 기능과 연동 범위는 각 서비스의 현재 조건을 확인해야 합니다. | LeadBayは、保険リードの比較・購入から配分・相談・契約・アフターサポート・精算まで、営業組織の業務に重点を置いています。Call2Saleは、リードを獲得・確認・納品するコールセンターの供給業務を扱います。実際の機能と連携範囲は、各サービスの現在の条件を確認する必要があります。 | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/subpages.php | cpa.items.insurance.cta.text | 조직 규모, 희망 지역·물량, DB 유형과 현재 운영 방식을 알려주시면 광고 유입·퍼미션콜·리드베이·콜투세일 중 필요한 범위를 구체적으로 나눠드립니다. | 組織規模、希望地域・件数、リード種別、現在の運用方法を教えてください。広告からの獲得・同意確認の電話・LeadBay・Call2Saleの中から、必要な範囲を具体的に整理します。 | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/pages/faq.php | description | 제이커브인터렉티브 고객센터. 퍼포먼스·CPA·리워드 광고, SEO·AEO·GEO, 셀프마케팅·부스팅샵, 리드베이·콜투세일, 웹 제작·지원사업에 대해 자주 묻는 질문과 답변을 한곳에 모았습니다. | パフォーマンス・CPA・リワード広告、SEO・AEO（アンサーエンジン最適化）・GEO（生成AI検索最適化）、セルフマーケティング・BoostingShop（ブースティングショップ）、LeadBay（リードベイ）・Call2Sale（コールトゥセール）、Web制作・支援事業に関するよくある質問と回答をまとめています。 | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/pages/faq.php | categories.crm.label | 리드베이·콜투세일 | LeadBay・Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/pages/faq.php | categories.crm.items.7.q | 콜투세일은 어떤 조직을 위한 서비스인가요? | Call2Saleは、どのような組織向けのサービスですか。 | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/pages/faq.php | categories.crm.items.7.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/pages/faq.php | categories.crm.items.8.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/pages/faq.php | categories.crm.items.9.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/pages/faq.php | categories.crm.items.10.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/pages/faq.php | categories.crm.items.11.q | 콜투세일이 DB의 적법성을 보장하나요? | Call2Saleはリードの適法性を保証しますか。 | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/pages/faq.php | categories.crm.items.11.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |
| lang/ja/pages/faq.php | categories.crm.items.12.from.1 | 콜투세일 | Call2Sale | [] | [] | 정상: Call2Sale 상표의 2, 수치 주장 아님 |

## 6. U5 부정·면책 전수 280잎

지정 한국어 표현 `않습니다|없습니다|아닙니다|보장하지|보장할 수 없|약속하지|제공하지|판매하지|금지`를 전수 검색했다. 번역 부정어 자동 대응 263잎, 미검출 17잎. 자동 대응은 부정이 존재한다는 근거이지 문장 전체의 완벽한 번역 증명이 아니다. 부정 문장이 여러 개인 잎과 미검출 문장은 따로 직접 대조했다. `more than`·`together`·`different`·`対象外` 등 의미상 부정이 되는 정상 표현은 단순 정규식 실패로 오역 처리하지 않았다. YouTube의 배제 약화 1잎은 FAIL이다.

| 파일 | 키 | 한국어 | 번역 | 판정 | 대안 |
| --- | --- | --- | --- | --- | --- |
| lang/en/subpages.php | seo.items.backlinks.body.2 | 검색 순위와 페널티 회피를 보장하지 않으며, 사이트 상태와 경쟁 환경에 맞춰 위험을 낮추는 방식으로 진행합니다. | We do not guarantee search rankings or protection from penalties. We work to reduce risk based on your site's condition and competitive environment. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.backlinks.sections.2.note | 검색 순위 상승이나 특정 시점의 노출, 검색엔진 조치 회피를 보장하는 상품이 아닙니다. | This service does not guarantee higher search rankings, visibility by a specific date or protection from search engine actions. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.backlinks.faq.0.answer | 아닙니다. 검색 결과는 사이트 상태, 콘텐츠, 경쟁도와 여러 신호가 함께 작용합니다. 백링크는 그중 외부 신뢰 신호를 보강하는 수단이며 순위나 반영 시점을 보장하지 않습니다. | No. Results depend on site health, content, competition and multiple signals. Backlinks strengthen external trust signals but do not guarantee rankings or when changes will take effect. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.backlinks.faq.2.answer | 검색엔진의 판단을 제3자가 보장할 수는 없습니다. 제이커브는 과도한 반복과 비정상 패턴을 피하고, 확인 가능한 범위와 위험 요소를 사전에 설명합니다. | No 3rd party can guarantee a search engine's decisions. We avoid excessive repetition and unusual patterns, and explain what we can verify and the risks involved before starting. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.body.1 | 순위나 노출 위치를 보장하지 않고, 운영 가능한 정보와 콘텐츠를 지속적으로 개선합니다. | We continually improve listing information and content without guaranteeing rankings or placement. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.sections.2.note | 허위 리뷰 작성, 대가성 리뷰 은폐 또는 특정 노출 순위 보장은 제공하지 않습니다. | We do not write fake reviews, conceal paid reviews or guarantee specific rankings. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.faq.0.answer | 보장하지 않습니다. 노출은 플랫폼 정책과 경쟁 상황, 이용자 반응 등 여러 요소에 따라 달라집니다. 제이커브는 확인 가능한 정보와 콘텐츠, 전환 동선을 개선합니다. | No. Visibility depends on platform policies, competition, user response and other factors. We improve the information, content and conversion paths we can verify. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.faq.1.answer | 허위 또는 조작 리뷰는 제공하지 않습니다. 실제 고객이 남긴 리뷰에 일관되게 응대하고, 서비스 과정에서 자연스러운 피드백을 받을 수 있는 운영 방식을 안내합니다. | We do not provide fake or manipulated reviews. We help you respond consistently to real customers' reviews and build ways to receive natural feedback during service. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.lead | 네이버 쇼핑 SEO는 상품명 한 줄을 바꾸는 작업이 아닙니다. 카테고리와 속성, 가격·배송 정보, 대표 이미지와 상세페이지가 고객의 검색 의도에 맞게 연결되도록 상품 데이터를 구조적으로 정비합니다. | NAVER Shopping — NAVER's product search and shopping hub. SEO here requires more than changing a product name. We organize categories, attributes, pricing, delivery details, main images and product pages around your customers' search intent. | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.body.1 | 검색 순위나 매출을 보장하지 않으며 플랫폼 정책과 실제 상품 경쟁력을 기준으로 운영합니다. | We follow platform policies and your products' actual competitive strengths. We do not guarantee search rankings or sales. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.sections.0.title | 상품이 검색돼도, 선택 이유가 없으면 전환되지 않습니다 | Being found is not enough: customers need a reason to choose you | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.sections.0.paragraphs.1 | 제이커브는 노출 요소와 구매 설득 요소를 분리하지 않습니다. 상품 데이터의 정확성부터 클릭 이후의 정보 구조까지 한 흐름으로 봅니다. | We review visibility and purchase decisions together, from accurate product data to the structure of information after the click. | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.sections.2.note | 플랫폼의 노출 위치, 판매량 또는 리뷰 결과를 보장하지 않습니다. | We do not guarantee placement, sales volumes or review outcomes on the platform. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.faq.0.answer | 그렇지 않습니다. 상품명은 여러 요소 중 하나이며 카테고리, 속성, 상품 경쟁력, 이용자 반응과 플랫폼 정책이 함께 작용합니다. 변경 전후를 기록해 판단합니다. | No. Product names are one of many factors, alongside categories, attributes, product competitiveness, user response and platform policies. We record the before-and-after data to assess changes. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.faq.1.answer | 허위 리뷰나 조작 리뷰를 제공하지 않습니다. 실제 구매자가 필요한 정보를 확인하고 정당하게 피드백을 남길 수 있는 상품·고객 경험을 우선합니다. | We do not provide fake or manipulated reviews. We prioritize product and customer experiences that give real buyers the information they need and opportunities to leave legitimate feedback. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.body.1 | 플랫폼 입점 승인, 노출 위치 또는 판매 성과를 보장하지 않습니다. | We do not guarantee seller approval, placement or sales results on the platform. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.sections.2.note | 플랫폼 심사·정책은 변경될 수 있으며 입점 승인이나 노출 결과를 대신 보장하지 않습니다. | Platform review criteria and policies may change. We cannot guarantee seller approval or visibility outcomes. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.faq.0.answer | 아닙니다. 입점과 상품 승인은 플랫폼의 심사와 정책에 따릅니다. 제이커브는 제출·운영에 필요한 상품 정보와 마케팅 구조를 정비합니다. | No. Seller and product approval depend on the platform's review and policies. We organize the product information and marketing structure needed for submission and ongoing operations. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.faq.2.answer | 보장하지 않습니다. 플랫폼 노출과 판매는 정책, 경쟁, 상품력과 고객 반응에 따라 달라집니다. 확인 가능한 상품 정보와 선택 경험을 개선합니다. | No. Visibility and sales depend on platform policies, competition, product strengths and customer response. We improve verifiable product information and the buying experience. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.body.1 | 검색 순위, 판매량이나 리뷰 결과를 보장하지 않습니다. | We do not guarantee search rankings, sales volumes or review outcomes. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.sections.2.note | 플랫폼 정책을 우회하거나 리뷰·노출을 조작하는 방식은 제공하지 않습니다. | We do not offer methods that bypass platform policies or manipulate reviews or visibility. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.faq.0.answer | 보장하지 않습니다. 검색 결과와 판매 성과는 플랫폼 정책, 경쟁, 상품력과 고객 반응 등 여러 요소에 따라 달라집니다. | No. Search results and sales depend on platform policies, competition, product strengths, customer response and other factors. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.faq.1.answer | 아닙니다. 카테고리, 옵션, 이미지, 가격·배송 정보와 상세페이지까지 고객의 비교 흐름에 영향을 주는 요소를 함께 확인합니다. | No. We also review categories, options, images, pricing, delivery information and product pages, because they all affect how customers compare products. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.faq.2.answer | 허위·조작 리뷰는 제공하지 않습니다. 실제 상품과 고객 경험을 정확히 설명하고 정당한 피드백을 받을 수 있는 운영을 우선합니다. | We do not provide fake or manipulated reviews. We prioritize accurate descriptions of the product and customer experience, and practices that support legitimate feedback. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.lead | 부동산 분양 CPA는 상담 신청이 들어왔다는 사실만 세는 광고가 아닙니다. 사업지와 공급 조건을 정확히 설명하고, 고객의 연락 동의와 유효 DB 기준, 상담 후 피드백까지 연결해야 품질을 관리할 수 있습니다. | CPA marketing for real estate pre-sale (new developments) goes beyond counting consultation requests. Quality depends on accurate project and sales information, consent to contact, valid lead criteria and feedback from consultations. | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.body.1 | 상담 신청은 실제 방문이나 계약을 의미하지 않으며 계약 성과를 보장하지 않습니다. | A consultation request does not mean a site visit or signed contract. We do not guarantee contract results. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.0.title | DB가 많아도 상담 기준이 다르면 성과를 판단할 수 없습니다 | Lead counts mean little without shared consultation criteria | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.2.note | 관련 법령과 매체 심사 기준을 확인해야 하며, 상담 신청·방문·분양 계약을 보장하지 않습니다. | Applicable laws and media review requirements must be checked. We do not guarantee consultation requests, visits or pre-sale contracts. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.3.items.3.text | CPA는 상담 기회를 만드는 구조이며 계약 결과를 대신 확정할 수 없습니다. | CPA creates consultation opportunities. It cannot determine contract outcomes for you. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.faq.0.answer | 아닙니다. DB는 정해진 정보를 입력하고 상담 연락에 동의한 신청입니다. 방문이나 계약 여부는 상품 조건, 상담 품질과 고객 판단에 따라 달라집니다. | No. A lead is a request from someone who supplied the required information and consented to consultation contact. Visits and contracts depend on the offer, consultation quality and the customer's decision. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.body.1 | 투자 수익, 원금, 가입 또는 상담 전환을 보장하지 않습니다. | We do not guarantee investment returns, principal protection, sign-ups or consultation conversions. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.2.note | 수익·원금·특정 종목 성과를 암시하거나 보장하는 캠페인은 진행하지 않습니다. 최종 집행은 관련 법령과 매체 심사를 충족해야 합니다. | We do not run campaigns that imply or guarantee returns, principal protection or performance of specific stocks. Launch requires compliance with applicable laws and media review requirements. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.3.items.3.text | 보장성 표현이나 오인을 유발하는 구조는 진행 대상이 아닙니다. | We do not support campaigns built on guarantees or misleading claims. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.faq.0.answer | 그럴 수 없습니다. CPA는 상담 관심과 신청을 측정할 뿐 투자 결과를 예측하거나 보장하지 않습니다. 수익을 암시하는 광고 표현도 별도 검토가 필요합니다. | No. CPA measures interest and consultation requests; it does not predict or guarantee investment outcomes. Ad claims that imply returns also require separate review. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.faq.1.answer | 아닙니다. 사업 유형, 관련 법령과 매체 정책에 따라 제한될 수 있습니다. 근거 없는 수익 표현, 원금 보장이나 오인을 유발하는 문구는 사용할 수 없습니다. | No. Restrictions depend on your business type, applicable laws and media policies. Unsupported return claims, principal guarantees and misleading wording cannot be used. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.lead | 보험디비는 전화번호 한 건을 전달하는 상품이 아닙니다. 광고 유입, 퍼미션콜, 동의·녹취 확인, 중복 기준, 지역·조건 매칭, 미팅 조정, AS와 영업 피드백이 이어져야 실제 상담 기회가 됩니다. | An insurance lead is more than a phone number. It becomes a genuine consultation opportunity when ad acquisition, consent verification calls, consent and recording checks, duplicate criteria, location and eligibility matching, meeting coordination, after-sales support and sales feedback work together. | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.body.1 | 보험 가입, 미팅률, 계약률이나 영업 수익을 보장하지 않습니다. | We do not guarantee insurance sign-ups, meeting rates, contract rates or sales income. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.1.note | 기존 보험 랜딩의 일 생산량·광고주 수·미팅률·전환율 수치는 산출 기준과 최신성을 확인하기 전에는 현재 성과로 사용하지 않습니다. 위 수치 역시 회사 전체 누적 기록이며 보험 캠페인의 결과 보장이 아닙니다. | We do not present daily production, advertiser counts, meeting rates or conversion rates from the previous insurance landing page as current results until their calculation basis and freshness are verified. The figures above are also company-wide cumulative records, not guarantees of insurance campaign results. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.3.paragraphs.2 | 다만 동의가 있다는 이유만으로 모든 전화, 무기한 보관, 자유로운 재제공이 허용되는 것은 아닙니다. 수집 항목·목적·제공받는 자·보유기간·철회 방법과 실제 상담 흐름이 맞아야 합니다. | Consent does not permit every call, indefinite retention or unrestricted onward sharing. Data fields, purposes, recipients, retention periods, withdrawal methods and actual consultation practices must align. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.3.note | 이 페이지는 법률 자문이 아닙니다. 실제 캠페인은 적용 법령, 금융·보험 광고 기준, 개인정보 처리 역할과 광고주 내부 준법 기준을 별도로 확인해야 합니다. | This page is not legal advice. Each campaign needs separate checks against applicable laws, financial and insurance advertising standards, data processing responsibilities and the advertiser's internal compliance rules. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.4.note | 퍼미션 확인이 미팅·계약을 보장하지는 않습니다. 기존 페이지가 강조하던 미팅률과 전환율은 캠페인·조직·기간별 결과이며 고정 약속으로 사용하지 않습니다. | Consent verification does not guarantee meetings or contracts. Meeting and conversion rates cited on the previous page reflected specific campaigns, organizations and periods, not fixed commitments. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.6.items.2.text | 한 광고주 전용 여부, 중복 확인 기간, 식별값, 기존 보유 DB 대조와 재제공 금지 범위를 집행 전에 문서화합니다. | Before launch, document advertiser exclusivity, duplicate check windows, identifiers, checks against existing leads and limits on onward supply. | 어색 — limits on onward supply는 재제공 금지 범위의 강도를 명확히 드러내지 않음. | Before launch, document advertiser exclusivity, duplicate-check windows, identifiers, checks against existing leads and the scope of the prohibition on resupplying leads. |
| lang/en/subpages.php | cpa.items.insurance.sections.6.note | ‘실시간’, ‘전량 검수’, ‘중복 없음’, ‘AS 가능’은 자동 보장이 아닙니다. 실제 적용 수준과 예외는 캠페인 계약, 시스템과 운영 인력 확인 후 확정합니다. | “Real-time,” “fully reviewed,” “no duplicates” and “after-sales support available” are not automatic guarantees. Actual service levels and exceptions depend on campaign contracts, systems and staffing checks. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.14.title | “동의받은 DB” 한 문장으로 끝내지 않습니다 | “Consented leads” is the start of the review | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.14.note | 사용 허락이 콘텐츠 저작권 문제를 해결해도 개별 캠페인의 적법성을 자동 보장하지는 않습니다. 실제 공개·집행 전 개인정보·금융 광고 담당자의 현재 기준 확인이 필요합니다. | Permission to use content may resolve copyright concerns, but does not automatically establish a campaign's legality. Before publication or launch, the people responsible for privacy and financial advertising must check current requirements. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.15.items.4.text | 보험DB는 상담 기회를 만드는 입력값이며 미팅·계약·매출을 확정하지 않습니다. | Insurance leads create consultation opportunities. They do not guarantee meetings, contracts or revenue. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.2.answer | 아닙니다. DB는 합의한 조건을 충족한 상담 기회입니다. 실제 미팅과 가입 여부는 고객의 필요, 상품 적합성, 전달 시점, 담당자의 상담 품질과 고객 판단에 따라 달라집니다. | No. A lead is a consultation opportunity that meets agreed conditions. Meetings and sign-ups depend on customer needs, product suitability, delivery timing, staff consultation quality and the customer's decision. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.3.answer | 전달 주기와 예상 물량은 광고 유입, 퍼미션콜·검수 인력, 지역과 조건에 따라 달라집니다. “실시간”을 일괄 보장하지 않고 캠페인별 전달 SLA와 예외를 먼저 합의합니다. | Delivery frequency and expected volumes depend on ad acquisition, verification and review staffing, regions and criteria. We agree on campaign-specific delivery SLAs and exceptions rather than guarantee real-time delivery across all campaigns. | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.4.answer | 그렇지 않습니다. 동의 문구, 제공받는 자, 목적, 항목과 보유기간이 실제 전달·연락 구조와 맞아야 합니다. 제3자 제공인지 처리위탁인지도 실제 역할과 관계를 기준으로 확인해야 합니다. | No. Consent wording, recipients, purposes, data fields and retention periods must match the actual delivery and contact process. Whether the arrangement is 3rd-party sharing or processing on behalf of another party must also be checked against the actual roles and relationships. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.7.answer | 자동으로 인정되지 않습니다. AS 가능 사유, 연락 횟수·시간대, 신청 기한, 필요한 증빙, 교환·보완 범위를 집행 전에 문서화해야 합니다. | No. Before launch, document eligible reasons, contact attempts and times, claim deadlines, required evidence and the scope of replacement or remediation. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.body.1 | 가격, 수익, 원금 또는 투자 결과를 보장하지 않습니다. | We do not guarantee prices, returns, principal protection or investment outcomes. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.0.paragraphs.0 | 가상자산 광고는 고객의 기대를 과도하게 자극하기 쉽고, 사업 유형과 매체에 따라 집행 제한도 달라질 수 있습니다. 강한 카피를 먼저 만드는 방식은 적합하지 않습니다. | Crypto ads can easily create unrealistic expectations. Restrictions also vary by business type and media platform. Starting with bold copy is the wrong approach. | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.2.note | 수익·가격 상승·원금 보장 또는 투자 판단을 오인하게 하는 광고는 진행하지 않습니다. 집행 가능 여부는 법령과 매체 정책에 따라 달라질 수 있습니다. | We do not run ads that guarantee returns, price increases or principal protection, or mislead investment decisions. Eligibility depends on applicable laws and media policies. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.faq.0.answer | 근거 없는 수익률, 가격 상승 또는 원금 보장을 암시하는 표현은 사용할 수 없습니다. 광고 가능 범위는 사업 유형, 법령과 매체 정책을 먼저 확인해야 합니다. | You cannot use unsupported return claims or wording that implies price increases or principal guarantees. Permitted advertising must first be assessed against the business type, applicable laws and media policies. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.faq.1.answer | 아닙니다. 서비스 유형, 제공 지역, 인허가·신고 상태와 매체 정책에 따라 제한될 수 있습니다. 상담 단계에서 사업 자료를 확인합니다. | No. Restrictions may depend on service type, operating regions, licensing or registration status, and media policies. We review your business documents during consultation. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.faq.2.answer | CPA는 합의한 상담 신청을 측정하는 과금 구조입니다. 고객의 투자 판단과 결과, 서비스 계약이나 수익을 보장하지 않습니다. | CPA is a billing model based on agreed consultation requests. It does not guarantee customers' investment decisions or outcomes, service contracts or returns. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.lead | 퍼미션 콜은 단순히 체크박스를 받는 일이 아닙니다. 누가, 어떤 목적으로, 어떤 채널로 연락하는지 고객이 이해하고 동의해야 하며, 그 범위와 시점을 증명할 기록과 철회 절차가 함께 있어야 합니다. | Consent-based calling requires more than a checkbox. Customers must understand and agree to who will contact them, why and through which channel. You also need records of the consent scope and timing, plus a withdrawal process. | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.sections.3.items.3.text | 체크박스 하나로 모든 연락이 허용된다고 보는 운영에는 맞지 않습니다. | This approach does not suit operations that assume one checkbox permits all contact. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.faq.0.answer | 아닙니다. 고객에게 안내한 목적, 주체, 채널과 보유 기간 등 동의 범위 안에서 운영해야 하며 철회·수신 거부 요청도 반영해야 합니다. | No. Contact must stay within the disclosed purpose, provider, channel, retention period and other consent limits. Withdrawals and opt-outs must also be respected. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.body.1 | 특정 전환율이나 광고 성과를 보장하지 않습니다. | We do not guarantee specific conversion rates or campaign results. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.sections.0.title | 노출이 많다는 사실만으로 좋은 캠페인은 아닙니다 | High impressions alone do not make a good campaign | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.faq.1.answer | 보장할 수 없습니다. 상품 경쟁력, 제안, 랜딩페이지, 예산과 측정 환경이 함께 영향을 줍니다. 계정 진단에서 광고 외 병목도 함께 확인합니다. | We cannot guarantee that. Product competitiveness, your offer, landing page, budget and measurement setup all affect results. Our account review also checks bottlenecks outside advertising. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.lead | 메타 광고는 타게팅 설정만으로 끝나지 않습니다. 전환 이벤트와 퍼널, 고객에게 말을 거는 소재, 랜딩 경험을 함께 설계하고 학습 데이터를 잃지 않도록 테스트 단위를 관리해야 합니다. | Meta advertising requires more than targeting settings. We design conversion events, funnels, relevant creative and landing experiences together, and control test scope to preserve useful learning data. | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.body.1 | 특정 ROAS나 전환 결과를 보장하지 않습니다. | We do not guarantee specific ROAS or conversion results. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.faq.1.answer | 사이트와 서버 환경, 현재 측정 구조를 확인한 뒤 필요한 연동 범위를 협의합니다. 모든 환경에서 동일한 방식으로 적용되는 것은 아닙니다. | We review your website, server environment and measurement setup, then agree on the integration scope. The same approach does not apply to every environment. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.faq.2.answer | 보장하지 않습니다. 광고 성과는 상품, 가격, 브랜드, 예산, 시장과 랜딩 경험에 따라 달라집니다. 제이커브는 측정 가능한 가설과 개선 과정을 투명하게 관리합니다. | No. Results depend on the product, price, brand, budget, market and landing experience. We manage measurable hypotheses and the improvement process transparently. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.lead | 유튜브 마케팅은 영상을 많이 올리거나 조회수를 사는 일이 아닙니다. 누구에게 어떤 문제를 어떤 형식으로 설명할지 정하고, 광고와 채널 콘텐츠의 역할을 나눠 시청 이후 검색·방문·문의로 이어지는 흐름을 만듭니다. | YouTube marketing is more than uploading videos or buying views. We define the audience, problem and format, then give ads and channel content distinct roles that lead viewers toward searches, visits and inquiries. | 오역 — 조회수 구매를 부정한 원문을 more than으로 바꿔 구매도 업무의 일부인 듯한 여지를 만듦. | YouTube marketing is not about uploading large numbers of videos or buying views. We define the audience, the problem to address and the format, then give ads and channel content distinct roles that lead viewers toward searches, visits and inquiries. |
| lang/en/subpages.php | performance.items.youtube.body.1 | 조회수, 구독자 수 또는 전환 성과를 보장하지 않습니다. | We do not guarantee views, subscriber counts or conversions. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.sections.0.paragraphs.0 | 브랜드 이야기만 길게 설명하면 시청자는 초반에 떠납니다. 반대로 강한 훅만 있고 다음 행동이 없으면 조회는 남아도 비즈니스 성과로 연결되지 않습니다. | Viewers leave early when a video only tells a long brand story. A strong hook without a next action may generate views but fail to produce business results. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.sections.3.items.3.text | 조회·구독 숫자를 확정하는 방식은 제공하지 않습니다. | We do not offer guaranteed view or subscriber counts. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.faq.2.answer | 보장하지 않습니다. 주제, 콘텐츠 품질, 채널 이력, 배포와 시장 반응에 따라 달라집니다. 확인 가능한 시청·클릭·전환 데이터를 기준으로 개선합니다. | No. Growth depends on topics, content quality, channel history, distribution and market response. We improve using verifiable viewing, click and conversion data. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.basic.sections.0.title | 처음부터 많은 키워드를 쫓지 않습니다 | We do not pursue every keyword from day one | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.basic.sections.2.note | 특정 키워드 순위와 반영 시점은 보장하지 않습니다. 사이트 상태에 따라 우선 작업은 달라질 수 있습니다. | We do not guarantee rankings for specific keywords or when changes will take effect. Initial priorities may vary with site condition. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.basic.faq.0.answer | 보장하지 않습니다. 베이직은 검색 기반과 핵심 페이지를 정비하는 구성입니다. 순위는 경쟁, 콘텐츠, 사이트 신뢰와 검색엔진 판단에 따라 달라집니다. | No. Basic establishes search foundations and priority pages. Rankings depend on competition, content, site trust and search engine decisions. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.pro.sections.2.note | 특정 키워드의 순위나 일정 내 성과를 보장하지 않으며, 실제 실행 범위는 사이트 진단 후 정합니다. | We do not guarantee specific keyword rankings or results within a set period. We define the actual scope after reviewing your site. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.pro.faq.1.answer | 가능합니다. 기존 글의 검색 의도, 중복과 최신성을 확인해 유지·통합·개선·정리 대상으로 나눕니다. 무조건 새 글만 늘리지 않습니다. | Yes. We review their search intent, duplication and freshness, then decide what to retain, merge, improve or remove. We do not simply keep adding new articles. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.pro.faq.2.answer | 정확한 시점은 보장할 수 없습니다. 검색 반영과 경쟁 환경이 달라 변경 이력과 노출·유입 흐름을 관찰하며 다음 작업을 결정합니다. | We cannot guarantee an exact date. Search updates and competition vary, so we use change records, visibility and traffic patterns to decide the next steps. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.sections.0.title | 고경쟁 SEO는 한두 페이지 수정으로 끝나지 않습니다 | Competitive SEO takes more than edits to a few pages | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.sections.2.note | 고경쟁 키워드의 특정 순위와 기간 내 성과를 보장하지 않습니다. 실제 범위는 진단과 실행 역량을 확인해 확정합니다. | We do not guarantee specific competitive keyword rankings or results within a set period. We confirm the scope after reviewing site needs and delivery capacity. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.faq.0.answer | 아닙니다. 사이트 규모, 경쟁도와 내부 실행 역량이 충분할 때 적합합니다. 작은 사이트나 기초 정비 단계라면 베이직·프로가 더 효율적일 수 있습니다. | No. It suits sites with sufficient scale, competition and internal delivery capacity. Basic or Pro may be more efficient for smaller sites or those still establishing foundations. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.faq.2.answer | 보장하지 않습니다. 경쟁사의 활동, 검색엔진 변화와 사이트 실행 상태를 통제할 수 없기 때문에 변경과 결과를 투명하게 기록하며 개선합니다. | No. We cannot control competitor activity, search engine changes or your site's implementation. We improve through transparent records of changes and results. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.lead | 제이커브는 특정 인기게시물 위치·기간이나 인위적 반응을 판매·접수하지 않습니다. 플랫폼이 최종 노출을 결정한다는 한계를 전제로 콘텐츠 관련성, 실제 고객 반응과 설명 가능한 배포 경로를 개선합니다. | We do not sell or accept orders for guaranteed top-post positions, durations or artificial engagement. The platform controls final visibility. We focus on content relevance, real customer response and traceable distribution channels. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.body.0 | 추천·검색 노출은 콘텐츠, 계정, 이용자 반응과 플랫폼 정책의 영향을 받으며 외부에서 위치나 유지 기간을 확정할 수 없습니다. | Visibility in recommendations and search depends on content, the account, user response and platform policies. Outside providers cannot fix a position or duration. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.body.1 | 인위적 반응을 통한 노출 상품은 공개 서비스로 제공하지 않습니다. | We do not offer visibility products based on artificial engagement as a public service. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.0.title | 인기게시물은 외부에서 소유하거나 고정할 수 있는 광고 지면이 아닙니다 | Top posts are not ad placements an outside provider can own or fix | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.0.paragraphs.0 | 인스타그램의 추천과 검색 화면은 콘텐츠 관련성, 계정 상태, 이용자별 맥락과 반응 등 여러 신호에 따라 계속 달라집니다. 제이커브가 특정 위치나 유지 기간을 통제한다고 말할 수 없습니다. | Instagram recommendations and search results change with content relevance, account status, individual user context and response. We cannot claim to control a specific position or how long it lasts. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.2.note | 인기게시물 진입, 노출 위치와 유지 기간은 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | We do not guarantee top-post inclusion, position or duration. Do not use methods that require giving an outside supplier your password or 2-step verification code. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.3.items.3.title | 결과 보장 금지 | Avoid guaranteed outcomes | 어색 — Avoid guaranteed outcomes는 보장을 금지하기보다 결과 자체를 피하라는 표현으로 읽힐 수 있음. | Do not guarantee outcomes |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.3.items.3.text | 통제할 수 없는 노출 위치·기간·매출을 확정 결과처럼 판매하지 않아야 합니다. | Do not sell positions, durations or sales you cannot control as certain results. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.faq.0.answer | 보장하지 않습니다. 플랫폼이 최종 노출을 결정하므로 제이커브가 특정 위치나 기간을 통제한다고 말할 수 없습니다. | No. The platform determines final visibility, so we cannot claim control over a specific position or duration. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.faq.1.answer | 아닙니다. 인위적 반응이나 노출 위치를 판매·접수하지 않습니다. 콘텐츠, 공식 광고와 협업처럼 유입 경로를 설명하고 측정할 수 있는 방법만 검토합니다. | No. We do not sell or accept orders for artificial engagement or placement. We consider only methods with explainable, measurable traffic sources, such as content, official ads and collaborations. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.lead | 제이커브는 인위적인 팔로워 수량을 판매·접수하지 않습니다. 플랫폼 정책, 계정 안전과 실제 고객 기여를 기준으로 콘텐츠·공식 광고·협업처럼 설명 가능한 성장 방법을 검토합니다. | We do not sell or accept orders for artificial follower quantities. We assess explainable growth methods, such as content, official ads and collaborations, against platform policies, account safety and their contribution to real customer growth. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.body.0 | 팔로워 숫자와 실제 도달·참여·문의는 같은 지표가 아닙니다. 계정 목표와 고객 행동을 기준으로 성장 방식을 판단합니다. | Follower counts, actual reach, engagement and inquiries are different metrics. Assess growth methods against account goals and customer actions. | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.body.1 | 외부 수량 공급 방식은 공개 서비스로 제공하지 않습니다. | We do not offer externally supplied follower quantities as a public service. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.sections.0.title | 팔로워 수와 실제 고객 성장은 같은 지표가 아닙니다 | Follower counts and real customer growth measure different things | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.sections.0.paragraphs.0 | 팔로워 수가 증가해도 콘텐츠 저장, 댓글, 클릭, 문의와 매출이 같은 비율로 늘어나는 것은 아닙니다. 계정 운영 목표와 실제 성장 방식을 분리해서 판단해야 합니다. | More followers do not mean proportional increases in saves, comments, clicks, inquiries or sales. Assess your account goals separately from how growth is achieved. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.sections.2.note | 팔로워 증가 자체는 도달·참여·구매를 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | Follower growth alone does not guarantee reach, engagement or purchases. Do not use methods that require giving an outside supplier your password or 2-step verification code. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.faq.0.answer | 아닙니다. 인위적인 팔로워 수량을 판매하거나 보장하지 않습니다. 콘텐츠, 공식 광고와 협업처럼 유입 경로를 설명하고 측정할 수 있는 방법만 검토합니다. | No. We do not sell or guarantee artificial follower quantities. We consider only methods with explainable, measurable traffic sources, such as content, official ads and collaborations. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.faq.2.answer | 보장되지 않습니다. 팔로워 수와 실제 관심·구매 의도는 다를 수 있으므로 도달, 저장·댓글, 프로필 방문, 링크 클릭과 문의를 별도로 확인해야 합니다. | There is no guarantee. Follower counts may not reflect genuine interest or purchase intent. Review reach, saves, comments, profile visits, link clicks and inquiries separately. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.lead | 제이커브는 인위적인 좋아요 수량을 판매·접수하지 않습니다. 플랫폼 정책, 게시물·계정 안전과 실제 고객 기여를 기준으로 콘텐츠·공식 광고·협업처럼 설명 가능한 참여 확대 방법을 검토합니다. | We do not sell or accept orders for artificial likes. We assess explainable ways to increase engagement, such as content, official ads and collaborations, against platform policies, post and account safety, and real customer value. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.body.0 | 좋아요 숫자와 실제 저장·공유·문의는 같은 지표가 아닙니다. 게시물 목적과 고객 행동을 기준으로 참여 확대 방식을 판단합니다. | Like counts, actual saves, shares and inquiries are different metrics. Assess engagement methods against the post's purpose and customer actions. | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.body.1 | 외부 수량 공급 방식은 공개 서비스로 제공하지 않습니다. | We do not offer externally supplied like quantities as a public service. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.sections.0.paragraphs.0 | 좋아요는 게시물에 표시되는 반응 중 하나일 뿐 저장, 공유, 댓글, 프로필 방문, 문의와 매출을 대신하지 않습니다. 신청 목적과 성과 판단 지표를 분리해야 합니다. | Likes are just one visible response to a post. They do not replace saves, shares, comments, profile visits, inquiries or sales. Separate the service request's objective from the metrics used to assess results. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.sections.2.note | 좋아요 증가 자체는 인기게시물 노출, 저장·문의 또는 매출을 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | More likes do not guarantee top-post visibility, saves, inquiries or sales. Do not use methods that require giving an outside supplier your password or 2-step verification code. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.faq.0.answer | 아닙니다. 인위적인 좋아요 수량을 판매하거나 보장하지 않습니다. 콘텐츠, 공식 광고와 협업처럼 유입 경로를 설명하고 측정할 수 있는 방법만 검토합니다. | No. We do not sell or guarantee artificial like quantities. We consider only methods with explainable, measurable traffic sources, such as content, official ads and collaborations. | OK — 부정어 대응 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.faq.2.answer | 보장되지 않습니다. 플랫폼 노출은 다양한 신호로 결정되며 좋아요 수와 실제 관심·구매 의도도 다를 수 있습니다. 저장, 공유, 프로필 방문과 문의를 함께 확인해야 합니다. | There is no guarantee. The platform uses many signals to determine visibility, and likes may not reflect genuine interest or purchase intent. Review saves, shares, profile visits and inquiries too. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.start.items.3.a | 시장 반응을 미리 확정할 수는 없습니다. 대신 시작 전에 성공 기준과 중단 기준을 합의하고, 측정 가능한 결과로 다음 결정을 내리도록 운영합니다. | We cannot determine market response in advance. We agree on success criteria and stopping criteria before we start, then use measurable results to guide the next decision. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.start.items.9.a | 아닙니다. 문의 내용을 확인하고 필요한 정보를 추가로 묻고, 수행 가능 범위와 다음 단계를 맞춘 뒤 별도로 계약 여부를 결정합니다. | No. We review your inquiry, ask for any further information we need and agree on a feasible scope and next steps. The decision to enter into a contract is made separately. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.3.a | 특정 매출이나 ROAS는 보장하지 않습니다. 대신 목표 전환, 테스트 기준, 중단·유지·확대 조건을 먼저 합의하고 같은 기준으로 결과를 판단합니다. | We do not guarantee specific revenue or ROAS. We agree on target conversions, test criteria and the conditions for stopping, continuing or scaling before we start, then assess results against the same criteria. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.6.a | 고정 물량을 일괄적으로 보장하지 않습니다. 액션 난이도, 단가, 일정, 매체 가용성과 초기 운영 데이터를 확인한 뒤 가능한 범위를 협의합니다. | We do not offer a blanket guarantee of a fixed volume. We discuss the feasible range after reviewing the difficulty of the action, pricing, schedule, publisher availability and initial campaign data. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.11.a | 설치만 목표로 두면 일회성 참여가 늘 수 있습니다. 후속 미션, 유효 조건, 중복 기준과 관찰 지표를 함께 설계해 캠페인 목적에 맞는 품질을 판단해야 합니다. 리워드 여부만으로 모든 유저의 가치를 단정하지 않습니다. | Targeting installs alone can increase one-time participation. Follow-up missions, validity requirements, duplicate participation rules and monitoring metrics need to be designed together to assess quality against the campaign objective. Rewards alone do not determine every user’s value. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.12.a | 고정 물량을 사전 보장하지 않습니다. 가용 물량은 타깃, 단가, 미션 난이도, 기간과 매체 상황에 따라 달라집니다. 초기 테스트에서 참여·승인 흐름을 확인한 뒤 확대 범위를 결정합니다. | We do not guarantee a fixed volume in advance. Available volume depends on targeting, pricing, mission difficulty, duration and publisher conditions. We review participation and acceptance in an initial test before deciding how far to scale. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.0.a | 사이트의 기술 상태, 경쟁도, 기존 콘텐츠와 검색엔진의 수집 주기에 따라 달라집니다. 고정 기간이나 특정 순위 시점을 보장하지 않으며, 색인·노출·클릭·전환의 선행 지표부터 확인합니다. | It depends on the site’s technical condition, competition, existing content and search engine crawl cycles. We do not guarantee a fixed timeframe or a date for reaching a specific ranking. We start by checking leading indicators such as indexing, visibility, clicks and conversions. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.2.a | 링크만으로 해결되지 않습니다. 크롤링과 색인, 검색의도에 맞는 콘텐츠, 내부 링크, 출처의 관련성과 품질을 함께 봐야 합니다. 특정 링크 수나 순위 상승을 보장하지 않습니다. | Links alone cannot resolve every issue. Crawling and indexing, content that matches search intent, internal links, and the relevance and quality of sources all need to be reviewed together. We do not guarantee a specific number of links or a ranking increase. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.3.a | 아닙니다. 정보 접근성, 엔티티의 명확성, 근거와 출처의 일관성을 개선해 답변 시스템이 참고할 가능성을 높이는 작업입니다. 최종 노출과 인용은 각 검색·생성 시스템이 결정합니다. | No. They improve information accessibility, clarity about entities, and consistency of evidence and sources to increase the likelihood that answer systems will refer to your content. Each search or generative system decides what to display and cite. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.4.a | 가능합니다. 먼저 현재 URL과 검색 유입, 기술 문제, 콘텐츠 자산을 진단해 유지할 부분과 수정할 부분을 구분합니다. 전면 개편이 항상 필요한 것은 아닙니다. | Yes. We first review your current URLs, search traffic, technical issues and content assets to identify what to retain and what to change. A complete rebuild is not always necessary. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.5.a | 가능합니다. 기존 문서에서 실제 질문에 답하는 부분과 근거를 먼저 찾고, 결론·조건·예외·관련 문서의 순서로 재구성합니다. 모든 콘텐츠를 새로 쓸 필요는 없습니다. | Yes. We first identify the parts of existing documents that answer real questions and provide evidence. We then reorganize them in the order of conclusions, conditions, exceptions and related documents. Not all content needs to be rewritten. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.7.a | 아닙니다. 구조화 데이터는 화면에 실제로 존재하는 내용을 설명하는 보조 수단입니다. 답변의 정확성, 근거, 페이지 품질과 검색 시스템의 판단이 함께 작용합니다. | No. Structured data is a supporting tool that describes content actually present on the page. Answer accuracy, evidence, page quality and the search system’s assessment all play a role. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.8.a | 질문군별 검색 노출과 클릭, 해당 페이지의 행동·전환, 표본 검색 결과에서의 답변 노출과 출처를 함께 기록합니다. 표본 결과가 전체 사용자 결과를 대표한다고 단정하지 않습니다. | We record search visibility and clicks by question group, actions and conversions on the relevant pages, and answer visibility and sources in sampled search results. We do not assume that sampled results represent what all users see. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.9.a | 보장하지 않습니다. AEO는 검색·답변 시스템이 내용을 이해하고 참고하기 쉬운 조건을 만드는 작업이며, 최종 노출 방식은 각 시스템이 결정합니다. | No. AEO helps create conditions that make content easier for search and answer systems to understand and reference. Each system decides how to display it. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.11.a | 아닙니다. 기존 공식 페이지, 회사 자료, 서비스 문서와 콘텐츠를 먼저 감사해 재사용할 수 있는 근거와 불일치를 찾습니다. 부족한 질문과 근거만 우선순위에 따라 보강합니다. | No. We first audit existing official pages, company information, service documentation and content to identify reusable evidence and inconsistencies. We prioritize filling gaps in questions and supporting evidence. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.14.a | 보장하지 않습니다. GEO는 생성 시스템이 브랜드와 정보를 정확히 이해하고 참고할 수 있는 조건을 개선하는 작업이며, 최종 답변과 추천은 각 시스템이 결정합니다. | No. GEO improves the conditions that help generative systems understand and reference brands and information accurately. Each system decides its final answers and recommendations. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.0.a | 보장하지 않습니다. 약속하는 것은 상품 페이지에 적힌 제공 항목과 집행량, 그리고 같은 조건으로 남기는 순위 기록입니다. | No. We commit to the deliverables and campaign volume stated on the product page, along with ranking records collected under consistent conditions. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.1.a | 아닙니다. 자체 수집·분석 기반의 추정 정보이며 네이버의 승인이나 보증을 의미하지 않습니다. | No. These are estimates based on our own data collection and analysis. They do not imply approval or endorsement by NAVER — Korea's largest search portal. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.5.a | 아닙니다. 자체 분석에 따른 추정 정보이며 실제 거래액이나 향후 매출을 보장하지 않습니다. 상품성·원가·전환율 등 별도 자료와 함께 판단해야 합니다. | No. They are estimates based on our own analysis and do not guarantee actual transaction values or future revenue. Assess them alongside other information, such as product viability, costs and conversion rates. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.6.a | 그렇게 단정할 수 없습니다. 점수는 비교와 점검을 위한 신호이며 검색 서비스의 실제 반영 방식과 성과는 여러 요인의 영향을 받습니다. | We cannot conclude that. Scores are signals for comparison and review. Many factors affect how search services reflect changes and the results they produce. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.7.a | 보장되지 않습니다. 검색 결과는 검색엔진이 여러 신호와 정책에 따라 결정합니다. 구매 전 제공 작업과 기간, 제외 범위를 기준으로 판단하세요. | No. Search engines determine search results using multiple signals and policies. Before purchasing, assess the included work, duration and exclusions. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.9.a | 어떤 실행도 일률적인 안전을 보장할 수 없습니다. 콘텐츠·공식 광고·협업 방식, 계정 상태와 최신 약관·정책을 확인하고 필요한 최소 권한만 사용해야 합니다. | No approach can guarantee safety in every case. Review content, official advertising and collaboration methods, account status, and the latest terms and policies. Use only the minimum permissions needed. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.10.a | 보장하지 않습니다. 플랫폼이 최종 노출을 결정하며 인스타그램 세부 페이지도 인위적 반응 수량이나 노출 위치를 판매하는 주문 페이지가 아닙니다. | No. The platform determines visibility. The detailed Instagram pages are not order pages selling artificial engagement quantities or specific positions. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.1.a | 그렇게 보장되지 않습니다. 점수는 서비스 내 비교 정보이며 실제 상담 연결과 계약은 DB의 적법성·시점·대상, 담당자의 상담과 시장 상황 등 여러 요인의 영향을 받습니다. | That is not guaranteed. Scores provide comparisons within the service. Actual consultation contact and contracts depend on many factors, including the legality, timing and target audience of the leads, the agent’s consultation and market conditions. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.2.a | 보장되지 않습니다. 구매자는 거래 전에 수집 출처, 동의 범위, 제공·이용 목적, 보유기간과 AS 조건을 확인해야 합니다. | No. Before a transaction, buyers must check the collection source, scope of consent, purposes of provision and use, retention period and after-sales support terms. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.3.a | 아닙니다. 서비스는 관리 흐름을 돕지만 거래·이용 주체의 법적·계약상 책임을 대신하지 않습니다. 조직의 기준과 필요한 전문 검토가 별도로 필요합니다. | No. The service supports management workflows but does not assume the legal or contractual responsibilities of the parties that transact or use the data. Your organization needs its own standards and any necessary expert review. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.4.a | 보장되지 않습니다. 연락 가능 여부, 상담 의향, 정보의 시의성, 배분과 상담 품질에 따라 결과가 달라질 수 있습니다. | No. Results may vary with contactability, willingness to consult, timeliness of the information, lead assignment and consultation quality. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.8.a | 정확성을 보장하지 않습니다. 분석은 패턴과 검토 지점을 찾는 보조 정보이며 관리자 또는 검수자가 통화 원자료와 상담 맥락을 함께 확인해야 합니다. | Accuracy is not guaranteed. The analysis supports the identification of patterns and points to review. A manager or reviewer must also check the original call data and consultation context. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.10.a | 그렇게 단정할 수 없습니다. 통화 방식과 데이터 처리 구조에 맞는 고지·동의, 이용 목적, 접근 권한, 보유·파기 기준을 실제 운영 전에 확인해야 합니다. | That cannot be assumed. Before operations begin, check the disclosures and consent, purposes of use, access permissions, and retention and destruction rules that fit the call method and data processing structure. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.11.a | 보장하지 않습니다. 원천 DB의 수집·제공·마케팅 이용 근거와 고객사 납품 조건은 운영·거래 당사자가 직접 확인해야 합니다. | No. The parties operating the service and conducting transactions must check the basis for collecting, providing and using source leads for marketing, as well as the conditions for delivery to clients. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.3.a | 아닙니다. 워드프레스는 검색엔진이 접근하기 좋은 구조를 만들 수 있는 도구일 뿐입니다. 기술 기반, 콘텐츠, 경쟁도와 지속적인 운영이 함께 필요합니다. | No. WordPress is simply a tool for creating a structure that search engines can access easily. A technical foundation, content, an assessment of competition and ongoing management are also needed. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.6.a | 보장하지 않습니다. 선정과 지원금 지급은 운영기관의 심사·협약·정산 기준에 따라 결정됩니다. 제이커브는 협의된 범위에서 과업 해석, 실행 계획, 마케팅 운영과 결과 자료 준비를 지원합니다. | No. Selection and funding payments depend on the administering institution’s review, agreement and settlement criteria. J-Curve supports task interpretation, execution planning, marketing management and preparation of results documentation within the agreed scope. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.8.a | 아닙니다. 인정되는 비용, 자부담, 집행 기간, 공급기업 요건과 증빙 방식은 사업마다 다릅니다. 계약이나 집행 전에 운영기관의 공고·협약·지침을 확인해야 합니다. | No. Eligible costs, the company’s own contribution, spending periods, supplier requirements and evidence requirements differ by program. Check the administering institution’s notice, agreement and guidelines before contracting or spending. | OK — 부정어 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.9.a | 공고상 인정 범위와 기업의 과업 목표에 따라 퍼포먼스 광고, SEO, 콘텐츠, 영상, 웹 제작 등을 검토할 수 있습니다. 모든 사업에서 모든 항목이 인정되는 것은 아닙니다. | We can consider performance ads, SEO, content, video and web builds according to the scope permitted by the notice and the company’s task goals. Not every item is eligible under every program. | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.backlinks.body.2 | 검색 순위와 페널티 회피를 보장하지 않으며, 사이트 상태와 경쟁 환경에 맞춰 위험을 낮추는 방식으로 진행합니다. | 検索順位やペナルティの回避を保証するものではありません。サイトの状態と競争環境に応じて、リスクを抑える方法で進めます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.backlinks.sections.2.note | 검색 순위 상승이나 특정 시점의 노출, 검색엔진 조치 회피를 보장하는 상품이 아닙니다. | 検索順位の上昇、特定の時点での表示、検索エンジンによる措置の回避を保証する商品ではありません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.backlinks.faq.0.answer | 아닙니다. 검색 결과는 사이트 상태, 콘텐츠, 경쟁도와 여러 신호가 함께 작용합니다. 백링크는 그중 외부 신뢰 신호를 보강하는 수단이며 순위나 반영 시점을 보장하지 않습니다. | いいえ。検索結果には、サイトの状態、コンテンツ、競争状況など複数のシグナルが影響します。被リンクは外部からの信頼シグナルを補強する手段の一つであり、順位や反映時期は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.backlinks.faq.2.answer | 검색엔진의 판단을 제3자가 보장할 수는 없습니다. 제이커브는 과도한 반복과 비정상 패턴을 피하고, 확인 가능한 범위와 위험 요소를 사전에 설명합니다. | 検索エンジンの判断を第3者が保証することはできません。J-Curveは過度な繰り返しや不自然なパターンを避け、確認できる範囲とリスクを事前に説明します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-place.body.1 | 순위나 노출 위치를 보장하지 않고, 운영 가능한 정보와 콘텐츠를 지속적으로 개선합니다. | 順位や表示位置は保証せず、継続して運用できる情報とコンテンツを改善します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-place.sections.2.note | 허위 리뷰 작성, 대가성 리뷰 은폐 또는 특정 노출 순위 보장은 제공하지 않습니다. | 虚偽の口コミの作成、対価を伴う口コミの隠蔽、特定の表示順位の保証は行いません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-place.faq.0.answer | 보장하지 않습니다. 노출은 플랫폼 정책과 경쟁 상황, 이용자 반응 등 여러 요소에 따라 달라집니다. 제이커브는 확인 가능한 정보와 콘텐츠, 전환 동선을 개선합니다. | 保証しません。表示はプラットフォームの規約、競争状況、利用者の反応などによって変わります。J-Curveは確認可能な情報、コンテンツ、コンバージョンへの導線を改善します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-place.faq.1.answer | 허위 또는 조작 리뷰는 제공하지 않습니다. 실제 고객이 남긴 리뷰에 일관되게 응대하고, 서비스 과정에서 자연스러운 피드백을 받을 수 있는 운영 방식을 안내합니다. | 虚偽や操作による口コミは提供しません。実際のお客様からの口コミに一貫した方針で対応し、サービスの過程で自然なフィードバックを得られる運用方法をご案内します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-shopping.lead | 네이버 쇼핑 SEO는 상품명 한 줄을 바꾸는 작업이 아닙니다. 카테고리와 속성, 가격·배송 정보, 대표 이미지와 상세페이지가 고객의 검색 의도에 맞게 연결되도록 상품 데이터를 구조적으로 정비합니다. | NAVERショッピング（NAVERの商品検索・ショッピング）のSEOは、商品名だけを変える施策ではありません。カテゴリと属性、価格・配送情報、メイン画像、商品詳細ページが検索意図に沿ってつながるよう、商品データの構造を整えます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-shopping.body.1 | 검색 순위나 매출을 보장하지 않으며 플랫폼 정책과 실제 상품 경쟁력을 기준으로 운영합니다. | 検索順位や売上は保証せず、プラットフォームの規約と実際の商品競争力に基づいて運用します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-shopping.sections.0.title | 상품이 검색돼도, 선택 이유가 없으면 전환되지 않습니다 | 検索で見つかっても、選ぶ理由がなければ購入にはつながりません | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-shopping.sections.0.paragraphs.1 | 제이커브는 노출 요소와 구매 설득 요소를 분리하지 않습니다. 상품 데이터의 정확성부터 클릭 이후의 정보 구조까지 한 흐름으로 봅니다. | J-Curveは、表示機会を増やす要素と購入を後押しする要素を分けません。商品データの正確性からクリック後の情報構成まで、一連の流れとして確認します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-shopping.sections.2.note | 플랫폼의 노출 위치, 판매량 또는 리뷰 결과를 보장하지 않습니다. | プラットフォーム上の表示位置、販売数、口コミの結果は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-shopping.faq.0.answer | 그렇지 않습니다. 상품명은 여러 요소 중 하나이며 카테고리, 속성, 상품 경쟁력, 이용자 반응과 플랫폼 정책이 함께 작용합니다. 변경 전후를 기록해 판단합니다. | いいえ。商品名は要素の一つにすぎず、カテゴリ、属性、商品競争力、利用者の反応、プラットフォームの規約も影響します。変更前後を記録して判断します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-shopping.faq.1.answer | 허위 리뷰나 조작 리뷰를 제공하지 않습니다. 실제 구매자가 필요한 정보를 확인하고 정당하게 피드백을 남길 수 있는 상품·고객 경험을 우선합니다. | 虚偽や操作による口コミは提供しません。実際の購入者が必要な情報を確認し、正当にフィードバックを残せる商品・顧客体験を優先します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.kakao-gift.body.1 | 플랫폼 입점 승인, 노출 위치 또는 판매 성과를 보장하지 않습니다. | 出店の承認、表示位置、販売成果は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.kakao-gift.sections.2.note | 플랫폼 심사·정책은 변경될 수 있으며 입점 승인이나 노출 결과를 대신 보장하지 않습니다. | プラットフォームの審査や規約は変更されることがあります。出店の承認や表示結果は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.kakao-gift.faq.0.answer | 아닙니다. 입점과 상품 승인은 플랫폼의 심사와 정책에 따릅니다. 제이커브는 제출·운영에 필요한 상품 정보와 마케팅 구조를 정비합니다. | いいえ。出店や商品の承認は、プラットフォームの審査と規約に従います。J-Curveは申請・運用に必要な商品情報とマーケティングの仕組みを整えます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.kakao-gift.faq.2.answer | 보장하지 않습니다. 플랫폼 노출과 판매는 정책, 경쟁, 상품력과 고객 반응에 따라 달라집니다. 확인 가능한 상품 정보와 선택 경험을 개선합니다. | 保証しません。表示や販売は、規約、競争、商品力、お客様の反応によって変わります。確認可能な商品情報と、選びやすい体験を改善します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.coupang.body.1 | 검색 순위, 판매량이나 리뷰 결과를 보장하지 않습니다. | 検索順位、販売数、口コミの結果は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.coupang.sections.2.note | 플랫폼 정책을 우회하거나 리뷰·노출을 조작하는 방식은 제공하지 않습니다. | プラットフォームの規約を回避したり、口コミや表示を操作したりする方法は提供しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.coupang.faq.0.answer | 보장하지 않습니다. 검색 결과와 판매 성과는 플랫폼 정책, 경쟁, 상품력과 고객 반응 등 여러 요소에 따라 달라집니다. | 保証しません。検索結果と販売成果は、プラットフォームの規約、競争、商品力、お客様の反応などによって変わります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.coupang.faq.1.answer | 아닙니다. 카테고리, 옵션, 이미지, 가격·배송 정보와 상세페이지까지 고객의 비교 흐름에 영향을 주는 요소를 함께 확인합니다. | いいえ。カテゴリ、オプション、画像、価格・配送情報、商品詳細ページなど、お客様の比較の流れに影響する要素を合わせて確認します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | seo.items.coupang.faq.2.answer | 허위·조작 리뷰는 제공하지 않습니다. 실제 상품과 고객 경험을 정확히 설명하고 정당한 피드백을 받을 수 있는 운영을 우선합니다. | 虚偽や操作による口コミは提供しません。実際の商品と顧客体験を正確に伝え、正当なフィードバックを得られる運用を優先します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.lead | 부동산 분양 CPA는 상담 신청이 들어왔다는 사실만 세는 광고가 아닙니다. 사업지와 공급 조건을 정확히 설명하고, 고객의 연락 동의와 유효 DB 기준, 상담 후 피드백까지 연결해야 품질을 관리할 수 있습니다. | 不動産分譲のCPAは、相談申込数だけを数える広告ではありません。開発物件と販売条件を正確に伝え、連絡への同意、有効リードの基準、相談後のフィードバックをつなぐことで品質を管理します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.body.1 | 상담 신청은 실제 방문이나 계약을 의미하지 않으며 계약 성과를 보장하지 않습니다. | 相談申込は実際の来場や契約を意味せず、契約成果は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.0.title | DB가 많아도 상담 기준이 다르면 성과를 판단할 수 없습니다 | リードが多くても、相談の基準が違えば成果を判断できません | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.2.note | 관련 법령과 매체 심사 기준을 확인해야 하며, 상담 신청·방문·분양 계약을 보장하지 않습니다. | 関連法令と媒体の審査基準の確認が必要です。相談申込・来場・分譲契約は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.3.items.3.text | CPA는 상담 기회를 만드는 구조이며 계약 결과를 대신 확정할 수 없습니다. | CPAは相談の機会をつくる仕組みであり、契約結果を確約することはできません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.faq.0.answer | 아닙니다. DB는 정해진 정보를 입력하고 상담 연락에 동의한 신청입니다. 방문이나 계약 여부는 상품 조건, 상담 품질과 고객 판단에 따라 달라집니다. | いいえ。リードは、所定の情報を入力し、相談の連絡に同意した申込者です。来場や契約の有無は、商品条件、相談対応の品質、お客様の判断によって変わります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.body.1 | 투자 수익, 원금, 가입 또는 상담 전환을 보장하지 않습니다. | 投資収益、元本、加入、相談への転換は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.2.note | 수익·원금·특정 종목 성과를 암시하거나 보장하는 캠페인은 진행하지 않습니다. 최종 집행은 관련 법령과 매체 심사를 충족해야 합니다. | 収益・元本・特定銘柄の成果を示唆したり保証したりするキャンペーンは行いません。配信には、関連法令と媒体審査の基準を満たす必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.3.items.3.text | 보장성 표현이나 오인을 유발하는 구조는 진행 대상이 아닙니다. | 保証をうたう表現や誤認を招く仕組みは対応対象外です。 | OK — 직접 대조: 대조/동의 표현으로 부정 보존 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.faq.0.answer | 그럴 수 없습니다. CPA는 상담 관심과 신청을 측정할 뿐 투자 결과를 예측하거나 보장하지 않습니다. 수익을 암시하는 광고 표현도 별도 검토가 필요합니다. | できません。CPAが測定するのは相談への関心と申込であり、投資結果を予測・保証するものではありません。利益を示唆する広告表現も、別途確認が必要です。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.faq.1.answer | 아닙니다. 사업 유형, 관련 법령과 매체 정책에 따라 제한될 수 있습니다. 근거 없는 수익 표현, 원금 보장이나 오인을 유발하는 문구는 사용할 수 없습니다. | いいえ。事業の種類、関連法令、媒体の規約によって制限される場合があります。根拠のない収益表現、元本保証、誤認を招く文言は使えません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.lead | 보험디비는 전화번호 한 건을 전달하는 상품이 아닙니다. 광고 유입, 퍼미션콜, 동의·녹취 확인, 중복 기준, 지역·조건 매칭, 미팅 조정, AS와 영업 피드백이 이어져야 실제 상담 기회가 됩니다. | 保険リードは、電話番号を一件渡すだけの商品ではありません。広告からの獲得、同意確認の電話、同意・録音の確認、重複基準、地域・条件のマッチング、面談調整、アフターサポート、営業からのフィードバックをつなぐことで、実際の相談機会になります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.body.1 | 보험 가입, 미팅률, 계약률이나 영업 수익을 보장하지 않습니다. | 保険加入、面談率、契約率、営業収益は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.1.note | 기존 보험 랜딩의 일 생산량·광고주 수·미팅률·전환율 수치는 산출 기준과 최신성을 확인하기 전에는 현재 성과로 사용하지 않습니다. 위 수치 역시 회사 전체 누적 기록이며 보험 캠페인의 결과 보장이 아닙니다. | 従来の保険ページにあった一日当たりの供給数・広告主数・面談率・コンバージョン率は、算出基準と最新性を確認するまでは現在の実績として使いません。上記も会社全体の累計記録であり、保険キャンペーンの成果を保証するものではありません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.3.paragraphs.2 | 다만 동의가 있다는 이유만으로 모든 전화, 무기한 보관, 자유로운 재제공이 허용되는 것은 아닙니다. 수집 항목·목적·제공받는 자·보유기간·철회 방법과 실제 상담 흐름이 맞아야 합니다. | ただし、同意があれば、あらゆる電話、無期限の保管、自由な再提供が許されるわけではありません。収集項目・目的・提供先・保有期間・撤回方法と、実際の相談の流れが一致する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.3.note | 이 페이지는 법률 자문이 아닙니다. 실제 캠페인은 적용 법령, 금융·보험 광고 기준, 개인정보 처리 역할과 광고주 내부 준법 기준을 별도로 확인해야 합니다. | このページは法律上の助言ではありません。実施時には、適用法令、金融・保険広告の基準、個人情報の取り扱い上の役割、広告主の社内コンプライアンス基準を別途確認する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.4.note | 퍼미션 확인이 미팅·계약을 보장하지는 않습니다. 기존 페이지가 강조하던 미팅률과 전환율은 캠페인·조직·기간별 결과이며 고정 약속으로 사용하지 않습니다. | 同意確認は面談や契約を保証しません。従来のページで強調していた面談率・コンバージョン率は、キャンペーン・組織・期間ごとの結果であり、固定の約束として使いません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.6.items.2.text | 한 광고주 전용 여부, 중복 확인 기간, 식별값, 기존 보유 DB 대조와 재제공 금지 범위를 집행 전에 문서화합니다. | 広告主専用かどうか、重複確認期間、識別値、既存リードとの照合、再提供の禁止範囲を、開始前に文書化します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.6.note | ‘실시간’, ‘전량 검수’, ‘중복 없음’, ‘AS 가능’은 자동 보장이 아닙니다. 실제 적용 수준과 예외는 캠페인 계약, 시스템과 운영 인력 확인 후 확정합니다. | 「リアルタイム」「全件確認」「重複なし」「アフターサポート対応」は自動的に保証されるものではありません。実際の適用水準と例外は、契約、システム、運用人員を確認して決めます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.14.title | “동의받은 DB” 한 문장으로 끝내지 않습니다 | 「同意取得済みリード」という一言で終わらせません | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.14.note | 사용 허락이 콘텐츠 저작권 문제를 해결해도 개별 캠페인의 적법성을 자동 보장하지는 않습니다. 실제 공개·집행 전 개인정보·금융 광고 담당자의 현재 기준 확인이 필요합니다. | 使用許諾によってコンテンツの著作権の問題が解決しても、個々のキャンペーンの適法性が自動的に保証されるわけではありません。公開・配信前に、個人情報・金融広告の担当者による最新基準の確認が必要です。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.15.items.4.text | 보험DB는 상담 기회를 만드는 입력값이며 미팅·계약·매출을 확정하지 않습니다. | 保険リードは相談機会をつくるための情報であり、面談・契約・売上を確定するものではありません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.2.answer | 아닙니다. DB는 합의한 조건을 충족한 상담 기회입니다. 실제 미팅과 가입 여부는 고객의 필요, 상품 적합성, 전달 시점, 담당자의 상담 품질과 고객 판단에 따라 달라집니다. | いいえ。リードは合意した条件を満たす相談機会です。実際の面談と加入の有無は、お客様の必要性、商品の適合性、受け渡し時点、担当者の相談品質、お客様の判断によって変わります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.3.answer | 전달 주기와 예상 물량은 광고 유입, 퍼미션콜·검수 인력, 지역과 조건에 따라 달라집니다. “실시간”을 일괄 보장하지 않고 캠페인별 전달 SLA와 예외를 먼저 합의합니다. | 受け渡し周期と予定件数は、広告からの獲得状況、電話確認・検品の人員、地域、条件によって変わります。リアルタイムを一律に保証せず、キャンペーンごとの受け渡しSLAと例外を先に合意します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.4.answer | 그렇지 않습니다. 동의 문구, 제공받는 자, 목적, 항목과 보유기간이 실제 전달·연락 구조와 맞아야 합니다. 제3자 제공인지 처리위탁인지도 실제 역할과 관계를 기준으로 확인해야 합니다. | いいえ。同意文、提供先、目的、項目、保有期間が、実際の提供・連絡の仕組みと一致する必要があります。第3者提供か処理委託かも、実際の役割と関係に基づいて確認します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.7.answer | 자동으로 인정되지 않습니다. AS 가능 사유, 연락 횟수·시간대, 신청 기한, 필요한 증빙, 교환·보완 범위를 집행 전에 문서화해야 합니다. | 自動的に有効認定されるものではありません。対象理由、連絡回数・時間帯、申請期限、必要な証拠、交換・補完の範囲を開始前に文書化する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.body.1 | 가격, 수익, 원금 또는 투자 결과를 보장하지 않습니다. | 価格、収益、元本、投資結果は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.sections.0.paragraphs.0 | 가상자산 광고는 고객의 기대를 과도하게 자극하기 쉽고, 사업 유형과 매체에 따라 집행 제한도 달라질 수 있습니다. 강한 카피를 먼저 만드는 방식은 적합하지 않습니다. | 暗号資産の広告はお客様の期待を過度にあおりやすく、事業の種類や媒体によって配信制限も異なります。強い訴求文から先に作る進め方は適切ではありません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.sections.2.note | 수익·가격 상승·원금 보장 또는 투자 판단을 오인하게 하는 광고는 진행하지 않습니다. 집행 가능 여부는 법령과 매체 정책에 따라 달라질 수 있습니다. | 収益・価格上昇・元本保証をうたう広告や、投資判断を誤らせる広告は行いません。実施の可否は法令と媒体の規約によって変わる場合があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.faq.0.answer | 근거 없는 수익률, 가격 상승 또는 원금 보장을 암시하는 표현은 사용할 수 없습니다. 광고 가능 범위는 사업 유형, 법령과 매체 정책을 먼저 확인해야 합니다. | 根拠のない収益率、価格上昇、元本保証を示唆する表現は使えません。広告可能な範囲は、事業の種類、法令、媒体の規約を先に確認する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.faq.1.answer | 아닙니다. 서비스 유형, 제공 지역, 인허가·신고 상태와 매체 정책에 따라 제한될 수 있습니다. 상담 단계에서 사업 자료를 확인합니다. | いいえ。サービスの種類、提供地域、許認可・届出の状況、媒体の規約によって制限される場合があります。相談時に事業資料を確認します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.faq.2.answer | CPA는 합의한 상담 신청을 측정하는 과금 구조입니다. 고객의 투자 판단과 결과, 서비스 계약이나 수익을 보장하지 않습니다. | CPAは合意した相談申込を測定する課金方式です。お客様の投資判断や結果、サービス契約、収益は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.lead | 퍼미션 콜은 단순히 체크박스를 받는 일이 아닙니다. 누가, 어떤 목적으로, 어떤 채널로 연락하는지 고객이 이해하고 동의해야 하며, 그 범위와 시점을 증명할 기록과 철회 절차가 함께 있어야 합니다. | 同意確認は、チェック欄に同意をもらうだけではありません。誰が、何の目的で、どの経路から連絡するかをお客様が理解して同意し、その範囲と時点を証明する記録、撤回手順も必要です。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.sections.3.items.3.text | 체크박스 하나로 모든 연락이 허용된다고 보는 운영에는 맞지 않습니다. | 一つのチェック欄であらゆる連絡が許されると考える運用には適していません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.faq.0.answer | 아닙니다. 고객에게 안내한 목적, 주체, 채널과 보유 기간 등 동의 범위 안에서 운영해야 하며 철회·수신 거부 요청도 반영해야 합니다. | いいえ。お客様に案内した目的、主体、連絡経路、保有期間など、同意の範囲内で運用し、撤回・受信拒否の依頼も反映する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.body.1 | 특정 전환율이나 광고 성과를 보장하지 않습니다. | 特定のコンバージョン率や広告成果は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.sections.0.title | 노출이 많다는 사실만으로 좋은 캠페인은 아닙니다 | 表示回数が多いだけでは、よいキャンペーンとはいえません | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.faq.1.answer | 보장할 수 없습니다. 상품 경쟁력, 제안, 랜딩페이지, 예산과 측정 환경이 함께 영향을 줍니다. 계정 진단에서 광고 외 병목도 함께 확인합니다. | 保証はできません。商品競争力、提案内容、ランディングページ、予算、測定環境も影響します。アカウント診断では、広告以外のボトルネックも確認します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.lead | 메타 광고는 타게팅 설정만으로 끝나지 않습니다. 전환 이벤트와 퍼널, 고객에게 말을 거는 소재, 랜딩 경험을 함께 설계하고 학습 데이터를 잃지 않도록 테스트 단위를 관리해야 합니다. | Meta広告は、ターゲティングの設定だけでは終わりません。コンバージョンイベントとファネル、お客様に語りかけるクリエイティブ、ランディングページの体験を合わせて設計し、学習データを失わないようテストの単位を管理する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.body.1 | 특정 ROAS나 전환 결과를 보장하지 않습니다. | 特定のROASやコンバージョン成果は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.faq.1.answer | 사이트와 서버 환경, 현재 측정 구조를 확인한 뒤 필요한 연동 범위를 협의합니다. 모든 환경에서 동일한 방식으로 적용되는 것은 아닙니다. | サイト・サーバーの環境と現在の測定構成を確認し、必要な連携範囲を相談します。すべての環境に同じ方法を適用できるわけではありません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.faq.2.answer | 보장하지 않습니다. 광고 성과는 상품, 가격, 브랜드, 예산, 시장과 랜딩 경험에 따라 달라집니다. 제이커브는 측정 가능한 가설과 개선 과정을 투명하게 관리합니다. | 保証しません。広告成果は商品、価格、ブランド、予算、市場、ランディングページの体験によって変わります。J-Curveは測定可能な仮説と改善の過程を透明に管理します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.youtube.lead | 유튜브 마케팅은 영상을 많이 올리거나 조회수를 사는 일이 아닙니다. 누구에게 어떤 문제를 어떤 형식으로 설명할지 정하고, 광고와 채널 콘텐츠의 역할을 나눠 시청 이후 검색·방문·문의로 이어지는 흐름을 만듭니다. | YouTubeマーケティングは、動画を大量投稿したり再生回数を購入したりする施策ではありません。誰に、どの課題を、どの形式で説明するかを決め、広告とチャンネル動画の役割を分けて、視聴後の検索・訪問・問い合わせにつながる流れをつくります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.youtube.body.1 | 조회수, 구독자 수 또는 전환 성과를 보장하지 않습니다. | 再生回数、登録者数、コンバージョン成果は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.youtube.sections.0.paragraphs.0 | 브랜드 이야기만 길게 설명하면 시청자는 초반에 떠납니다. 반대로 강한 훅만 있고 다음 행동이 없으면 조회는 남아도 비즈니스 성과로 연결되지 않습니다. | ブランドの説明ばかりが長く続くと、視聴者は冒頭で離脱します。反対に、強い導入だけで次の行動がなければ、再生されても事業成果にはつながりません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.youtube.sections.3.items.3.text | 조회·구독 숫자를 확정하는 방식은 제공하지 않습니다. | 再生回数や登録者数を確約する方法は提供しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | performance.items.youtube.faq.2.answer | 보장하지 않습니다. 주제, 콘텐츠 품질, 채널 이력, 배포와 시장 반응에 따라 달라집니다. 확인 가능한 시청·클릭·전환 데이터를 기준으로 개선합니다. | 保証しません。テーマ、品質、チャンネル履歴、配信、市場の反応によって変わります。確認可能な視聴・クリック・コンバージョンのデータに基づいて改善します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.basic.sections.0.title | 처음부터 많은 키워드를 쫓지 않습니다 | 最初から多数のキーワードを追いません | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.basic.sections.2.note | 특정 키워드 순위와 반영 시점은 보장하지 않습니다. 사이트 상태에 따라 우선 작업은 달라질 수 있습니다. | 特定キーワードの順位と反映時期は保証しません。サイトの状態に応じて優先作業は変わる場合があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.basic.faq.0.answer | 보장하지 않습니다. 베이직은 검색 기반과 핵심 페이지를 정비하는 구성입니다. 순위는 경쟁, 콘텐츠, 사이트 신뢰와 검색엔진 판단에 따라 달라집니다. | 保証しません。ベーシックは検索基盤と重要ページを整える構成です。順位は競争、コンテンツ、サイトの信頼性、検索エンジンの判断によって変わります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.pro.sections.2.note | 특정 키워드의 순위나 일정 내 성과를 보장하지 않으며, 실제 실행 범위는 사이트 진단 후 정합니다. | 特定キーワードの順位や一定期間内の成果は保証しません。実際の実行範囲は、サイト診断後に決めます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.pro.faq.1.answer | 가능합니다. 기존 글의 검색 의도, 중복과 최신성을 확인해 유지·통합·개선·정리 대상으로 나눕니다. 무조건 새 글만 늘리지 않습니다. | 可能です。既存記事の検索意図、重複、最新性を確認し、維持・統合・改善・整理の対象に分けます。新規記事を増やすことだけを目的にしません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.pro.faq.2.answer | 정확한 시점은 보장할 수 없습니다. 검색 반영과 경쟁 환경이 달라 변경 이력과 노출·유입 흐름을 관찰하며 다음 작업을 결정합니다. | 正確な時期は保証できません。検索への反映と競争環境は変わるため、変更履歴と表示・流入の推移を観察して次の作業を決めます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.elite.sections.0.title | 고경쟁 SEO는 한두 페이지 수정으로 끝나지 않습니다 | 競争の激しいSEOは、少数のページ修正では完結しません | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.elite.sections.2.note | 고경쟁 키워드의 특정 순위와 기간 내 성과를 보장하지 않습니다. 실제 범위는 진단과 실행 역량을 확인해 확정합니다. | 競争の激しいキーワードの特定順位と期間内の成果は保証しません。実際の範囲は、診断と実行能力を確認して決めます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.elite.faq.0.answer | 아닙니다. 사이트 규모, 경쟁도와 내부 실행 역량이 충분할 때 적합합니다. 작은 사이트나 기초 정비 단계라면 베이직·프로가 더 효율적일 수 있습니다. | いいえ。サイト規模、競争の度合い、社内の実行能力が十分な場合に適しています。小規模サイトや基礎整備の段階では、ベーシック・プロのほうが効率的な場合があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.elite.faq.2.answer | 보장하지 않습니다. 경쟁사의 활동, 검색엔진 변화와 사이트 실행 상태를 통제할 수 없기 때문에 변경과 결과를 투명하게 기록하며 개선합니다. | 保証しません。競合の活動、検索エンジンの変化、サイトの実行状況を制御できないため、変更と結果を透明に記録しながら改善します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.lead | 제이커브는 특정 인기게시물 위치·기간이나 인위적 반응을 판매·접수하지 않습니다. 플랫폼이 최종 노출을 결정한다는 한계를 전제로 콘텐츠 관련성, 실제 고객 반응과 설명 가능한 배포 경로를 개선합니다. | J-Curveは、特定の人気投稿の表示位置・期間や、人為的な反応の販売・受注は行いません。最終的な表示はプラットフォームが決めるという制約を踏まえ、コンテンツの関連性、実際のお客様の反応、説明可能な配信経路を改善します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.body.0 | 추천·검색 노출은 콘텐츠, 계정, 이용자 반응과 플랫폼 정책의 영향을 받으며 외부에서 위치나 유지 기간을 확정할 수 없습니다. | おすすめ・検索での表示は、コンテンツ、アカウント、利用者の反応、プラットフォームの規約に左右されます。外部から表示位置や維持期間を確約することはできません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.body.1 | 인위적 반응을 통한 노출 상품은 공개 서비스로 제공하지 않습니다. | 人為的な反応で露出を増やす商品は、公開サービスとして提供しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.sections.0.title | 인기게시물은 외부에서 소유하거나 고정할 수 있는 광고 지면이 아닙니다 | 人気投稿は、外部から所有・固定できる広告枠ではありません | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.sections.0.paragraphs.0 | 인스타그램의 추천과 검색 화면은 콘텐츠 관련성, 계정 상태, 이용자별 맥락과 반응 등 여러 신호에 따라 계속 달라집니다. 제이커브가 특정 위치나 유지 기간을 통제한다고 말할 수 없습니다. | Instagramのおすすめと検索画面は、コンテンツの関連性、アカウントの状態、利用者ごとの文脈と反応など、複数のシグナルによって変化します。J-Curveが特定の表示位置や維持期間を制御できるとはいえません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.sections.2.note | 인기게시물 진입, 노출 위치와 유지 기간은 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | 人気投稿への掲載、表示位置、維持期間は保証しません。パスワードや2段階認証コードを外部業者に渡す方法は使わないでください。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.sections.3.items.3.title | 결과 보장 금지 | 結果の保証をしない | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.sections.3.items.3.text | 통제할 수 없는 노출 위치·기간·매출을 확정 결과처럼 판매하지 않아야 합니다. | 制御できない表示位置・期間・売上を、確定した結果として販売してはいけません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.faq.0.answer | 보장하지 않습니다. 플랫폼이 최종 노출을 결정하므로 제이커브가 특정 위치나 기간을 통제한다고 말할 수 없습니다. | 保証しません。最終的な表示はプラットフォームが決めるため、J-Curveが特定の位置や期間を制御できるとはいえません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.faq.1.answer | 아닙니다. 인위적 반응이나 노출 위치를 판매·접수하지 않습니다. 콘텐츠, 공식 광고와 협업처럼 유입 경로를 설명하고 측정할 수 있는 방법만 검토합니다. | いいえ。人為的な反応や表示位置の販売・受注は行いません。コンテンツ、公式広告、協業など、流入経路を説明・測定できる方法だけを検討します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.lead | 제이커브는 인위적인 팔로워 수량을 판매·접수하지 않습니다. 플랫폼 정책, 계정 안전과 실제 고객 기여를 기준으로 콘텐츠·공식 광고·협업처럼 설명 가능한 성장 방법을 검토합니다. | J-Curveは人為的なフォロワー数の販売・受注は行いません。プラットフォームの規約、アカウントの安全性、実際の顧客獲得への貢献を基準に、コンテンツ・公式広告・協業など、説明できる成長方法を検討します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.body.0 | 팔로워 숫자와 실제 도달·참여·문의는 같은 지표가 아닙니다. 계정 목표와 고객 행동을 기준으로 성장 방식을 판단합니다. | フォロワー数と実際のリーチ・反応・問い合わせは、同じ指標ではありません。アカウントの目標とお客様の行動を基準に、成長方法を判断します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.body.1 | 외부 수량 공급 방식은 공개 서비스로 제공하지 않습니다. | 外部から数量を供給する方式は、公開サービスとして提供しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.sections.0.title | 팔로워 수와 실제 고객 성장은 같은 지표가 아닙니다 | フォロワー数と実際の顧客基盤の成長は、同じ指標ではありません | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.sections.0.paragraphs.0 | 팔로워 수가 증가해도 콘텐츠 저장, 댓글, 클릭, 문의와 매출이 같은 비율로 늘어나는 것은 아닙니다. 계정 운영 목표와 실제 성장 방식을 분리해서 판단해야 합니다. | フォロワーが増えても、保存、コメント、クリック、問い合わせ、売上が同じ割合で増えるとは限りません。アカウントの運用目標と実際の成長方法を分けて判断する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.sections.2.note | 팔로워 증가 자체는 도달·참여·구매를 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | フォロワーの増加自体は、リーチ・反応・購入を保証しません。パスワードや2段階認証コードを外部業者に渡す方法は使わないでください。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.faq.0.answer | 아닙니다. 인위적인 팔로워 수량을 판매하거나 보장하지 않습니다. 콘텐츠, 공식 광고와 협업처럼 유입 경로를 설명하고 측정할 수 있는 방법만 검토합니다. | いいえ。人為的なフォロワー数の販売や保証は行いません。コンテンツ、公式広告、協業など、流入経路を説明・測定できる方法だけを検討します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.faq.2.answer | 보장되지 않습니다. 팔로워 수와 실제 관심·구매 의도는 다를 수 있으므로 도달, 저장·댓글, 프로필 방문, 링크 클릭과 문의를 별도로 확인해야 합니다. | 保証はありません。フォロワー数と実際の関心・購買意欲は異なるため、リーチ、保存・コメント、プロフィール訪問、リンククリック、問い合わせを別々に確認する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-likes.lead | 제이커브는 인위적인 좋아요 수량을 판매·접수하지 않습니다. 플랫폼 정책, 게시물·계정 안전과 실제 고객 기여를 기준으로 콘텐츠·공식 광고·협업처럼 설명 가능한 참여 확대 방법을 검토합니다. | J-Curveは人為的な「いいね」数の販売・受注は行いません。規約、投稿・アカウントの安全性、実際のお客様への貢献を基準に、コンテンツ・公式広告・協業など、説明できるエンゲージメント向上策を検討します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-likes.body.0 | 좋아요 숫자와 실제 저장·공유·문의는 같은 지표가 아닙니다. 게시물 목적과 고객 행동을 기준으로 참여 확대 방식을 판단합니다. | 「いいね」数と実際の保存・共有・問い合わせは、同じ指標ではありません。投稿の目的とお客様の行動を基準に、エンゲージメント向上の方法を判断します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-likes.body.1 | 외부 수량 공급 방식은 공개 서비스로 제공하지 않습니다. | 外部から数量を供給する方式は、公開サービスとして提供しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-likes.sections.0.paragraphs.0 | 좋아요는 게시물에 표시되는 반응 중 하나일 뿐 저장, 공유, 댓글, 프로필 방문, 문의와 매출을 대신하지 않습니다. 신청 목적과 성과 판단 지표를 분리해야 합니다. | 「いいね」は投稿への反応の一つであり、保存、共有、コメント、プロフィール訪問、問い合わせ、売上の代わりにはなりません。依頼の目的と成果の判断指標を分ける必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-likes.sections.2.note | 좋아요 증가 자체는 인기게시물 노출, 저장·문의 또는 매출을 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | 「いいね」の増加自体は、人気投稿への表示、保存・問い合わせ、売上を保証しません。パスワードや2段階認証コードを外部業者に渡す方法は使わないでください。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-likes.faq.0.answer | 아닙니다. 인위적인 좋아요 수량을 판매하거나 보장하지 않습니다. 콘텐츠, 공식 광고와 협업처럼 유입 경로를 설명하고 측정할 수 있는 방법만 검토합니다. | いいえ。人為的な「いいね」数の販売や保証は行いません。コンテンツ、公式広告、協業など、流入経路を説明・測定できる方法だけを検討します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-likes.faq.2.answer | 보장되지 않습니다. 플랫폼 노출은 다양한 신호로 결정되며 좋아요 수와 실제 관심·구매 의도도 다를 수 있습니다. 저장, 공유, 프로필 방문과 문의를 함께 확인해야 합니다. | 保証はありません。表示はさまざまなシグナルで決まり、「いいね」数と実際の関心・購買意欲も異なります。保存、共有、プロフィール訪問、問い合わせを合わせて確認する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.start.items.3.a | 시장 반응을 미리 확정할 수는 없습니다. 대신 시작 전에 성공 기준과 중단 기준을 합의하고, 측정 가능한 결과로 다음 결정을 내리도록 운영합니다. | 市場の反応を事前に確定することはできません。開始前に成功の基準と中止の基準を合意し、測定できる結果に基づいて次の判断を行えるよう運用します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.start.items.9.a | 아닙니다. 문의 내용을 확인하고 필요한 정보를 추가로 묻고, 수행 가능 범위와 다음 단계를 맞춘 뒤 별도로 계약 여부를 결정합니다. | いいえ。お問い合わせ内容を確認し、必要な情報を追加で伺います。対応可能な範囲と次のステップをすり合わせたうえで、契約するかどうかを別途決めます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.3.a | 특정 매출이나 ROAS는 보장하지 않습니다. 대신 목표 전환, 테스트 기준, 중단·유지·확대 조건을 먼저 합의하고 같은 기준으로 결과를 판단합니다. | 特定の売上やROASは保証しません。目標とするコンバージョン、テスト基準、中止・継続・拡大の条件を先に合意し、同じ基準で結果を判断します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.6.a | 고정 물량을 일괄적으로 보장하지 않습니다. 액션 난이도, 단가, 일정, 매체 가용성과 초기 운영 데이터를 확인한 뒤 가능한 범위를 협의합니다. | 固定の件数を一律には保証しません。アクションの難易度、単価、日程、媒体の利用可否、初期の運用データを確認してから、対応可能な範囲を協議します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.11.a | 설치만 목표로 두면 일회성 참여가 늘 수 있습니다. 후속 미션, 유효 조건, 중복 기준과 관찰 지표를 함께 설계해 캠페인 목적에 맞는 품질을 판단해야 합니다. 리워드 여부만으로 모든 유저의 가치를 단정하지 않습니다. | インストールだけを目標にすると、一度きりの参加が増える場合があります。後続ミッション、有効と認める条件、重複の判定基準、観測指標を併せて設計し、キャンペーンの目的に合った質を判断する必要があります。リワードの有無だけで、すべてのユーザーの価値を決めつけることはしません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.12.a | 고정 물량을 사전 보장하지 않습니다. 가용 물량은 타깃, 단가, 미션 난이도, 기간과 매체 상황에 따라 달라집니다. 초기 테스트에서 참여·승인 흐름을 확인한 뒤 확대 범위를 결정합니다. | 固定の件数を事前には保証しません。対応可能な件数は、ターゲット、単価、ミッションの難易度、期間、媒体の状況によって変わります。初期テストで参加から有効認定までの流れを確認してから、拡大範囲を決めます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.0.a | 사이트의 기술 상태, 경쟁도, 기존 콘텐츠와 검색엔진의 수집 주기에 따라 달라집니다. 고정 기간이나 특정 순위 시점을 보장하지 않으며, 색인·노출·클릭·전환의 선행 지표부터 확인합니다. | サイトの技術的な状態、競争の度合い、既存のコンテンツ、検索エンジンのクロール周期によって異なります。固定の期間や特定の順位に到達する時期は保証せず、インデックス・表示・クリック・コンバージョンの先行指標から確認します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.2.a | 링크만으로 해결되지 않습니다. 크롤링과 색인, 검색의도에 맞는 콘텐츠, 내부 링크, 출처의 관련성과 품질을 함께 봐야 합니다. 특정 링크 수나 순위 상승을 보장하지 않습니다. | リンクだけでは解決できません。クロールとインデックス、検索意図に合うコンテンツ、内部リンク、参照元の関連性と質を併せて確認する必要があります。特定のリンク数や順位の上昇は保証しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.3.a | 아닙니다. 정보 접근성, 엔티티의 명확성, 근거와 출처의 일관성을 개선해 답변 시스템이 참고할 가능성을 높이는 작업입니다. 최종 노출과 인용은 각 검색·생성 시스템이 결정합니다. | いいえ。情報へのアクセス性、エンティティの明確さ、根拠と出典の一貫性を改善し、回答システムが参照する可能性を高める取り組みです。最終的な表示と引用は、各検索・生成システムが決定します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.4.a | 가능합니다. 먼저 현재 URL과 검색 유입, 기술 문제, 콘텐츠 자산을 진단해 유지할 부분과 수정할 부분을 구분합니다. 전면 개편이 항상 필요한 것은 아닙니다. | はい。まず現在のURL、検索流入、技術的な問題、コンテンツ資産を診断し、維持する部分と修正する部分を切り分けます。全面的なリニューアルが常に必要なわけではありません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.5.a | 가능합니다. 기존 문서에서 실제 질문에 답하는 부분과 근거를 먼저 찾고, 결론·조건·예외·관련 문서의 순서로 재구성합니다. 모든 콘텐츠를 새로 쓸 필요는 없습니다. | はい。既存の文書から、実際の質問に答える箇所と根拠を先に探し、結論・条件・例外・関連文書の順に再構成します。すべてのコンテンツを書き直す必要はありません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.7.a | 아닙니다. 구조화 데이터는 화면에 실제로 존재하는 내용을 설명하는 보조 수단입니다. 답변의 정확성, 근거, 페이지 품질과 검색 시스템의 판단이 함께 작용합니다. | いいえ。構造化データは、画面に実際に存在する内容を説明する補助手段です。回答の正確性、根拠、ページの品質、検索システムの判断も併せて作用します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.8.a | 질문군별 검색 노출과 클릭, 해당 페이지의 행동·전환, 표본 검색 결과에서의 답변 노출과 출처를 함께 기록합니다. 표본 결과가 전체 사용자 결과를 대표한다고 단정하지 않습니다. | 質問群ごとの検索での表示とクリック、対象ページでの行動・コンバージョン、サンプル検索結果での回答の表示と出典を併せて記録します。サンプル結果がすべての利用者の結果を代表するとは断定しません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.9.a | 보장하지 않습니다. AEO는 검색·답변 시스템이 내용을 이해하고 참고하기 쉬운 조건을 만드는 작업이며, 최종 노출 방식은 각 시스템이 결정합니다. | 保証しません。AEOは、検索・回答システムが内容を理解し、参照しやすくする条件を整える取り組みです。最終的な表示方法は、各システムが決定します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.11.a | 아닙니다. 기존 공식 페이지, 회사 자료, 서비스 문서와 콘텐츠를 먼저 감사해 재사용할 수 있는 근거와 불일치를 찾습니다. 부족한 질문과 근거만 우선순위에 따라 보강합니다. | いいえ。既存の公式ページ、会社資料、サービス文書、コンテンツを先に監査し、再利用できる根拠と情報の不一致を探します。不足している質問と根拠だけを、優先順位に沿って補強します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.14.a | 보장하지 않습니다. GEO는 생성 시스템이 브랜드와 정보를 정확히 이해하고 참고할 수 있는 조건을 개선하는 작업이며, 최종 답변과 추천은 각 시스템이 결정합니다. | 保証しません。GEOは、生成システムがブランドや情報を正確に理解し、参照できる条件を改善する取り組みです。最終的な回答と推薦は、各システムが決定します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.self.items.0.a | 보장하지 않습니다. 약속하는 것은 상품 페이지에 적힌 제공 항목과 집행량, 그리고 같은 조건으로 남기는 순위 기록입니다. | 保証しません。お約束するのは、商品ページに記載した提供項目と実施数量、そして同じ条件で残す順位の記録です。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.self.items.1.a | 아닙니다. 자체 수집·분석 기반의 추정 정보이며 네이버의 승인이나 보증을 의미하지 않습니다. | いいえ。自社の収集・分析に基づく推定情報であり、NAVER（韓国最大の検索ポータル）による承認や保証を意味するものではありません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.self.items.5.a | 아닙니다. 자체 분석에 따른 추정 정보이며 실제 거래액이나 향후 매출을 보장하지 않습니다. 상품성·원가·전환율 등 별도 자료와 함께 판단해야 합니다. | いいえ。自社分析に基づく推定情報であり、実際の取引額や将来の売上を保証するものではありません。商品性・原価・コンバージョン率などの別資料と併せて判断する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.self.items.6.a | 그렇게 단정할 수 없습니다. 점수는 비교와 점검을 위한 신호이며 검색 서비스의 실제 반영 방식과 성과는 여러 요인의 영향을 받습니다. | そのようには断定できません。点数は比較や点検のための指標です。検索サービスが実際にどう反映するか、どのような成果が出るかは、複数の要因に左右されます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.self.items.7.a | 보장되지 않습니다. 검색 결과는 검색엔진이 여러 신호와 정책에 따라 결정합니다. 구매 전 제공 작업과 기간, 제외 범위를 기준으로 판단하세요. | 保証されません。検索結果は、検索エンジンが複数のシグナルとポリシーに基づいて決定します。購入前に、提供される作業、期間、対象外の範囲を確認して判断してください。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.self.items.9.a | 어떤 실행도 일률적인 안전을 보장할 수 없습니다. 콘텐츠·공식 광고·협업 방식, 계정 상태와 최신 약관·정책을 확인하고 필요한 최소 권한만 사용해야 합니다. | どのような施策も、一律に安全性を保証することはできません。コンテンツ・公式広告・コラボレーションの方法、アカウントの状態、最新の利用規約・ポリシーを確認し、必要最小限の権限だけを使用する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.self.items.10.a | 보장하지 않습니다. 플랫폼이 최종 노출을 결정하며 인스타그램 세부 페이지도 인위적 반응 수량이나 노출 위치를 판매하는 주문 페이지가 아닙니다. | 保証しません。最終的な表示はプラットフォームが決定します。Instagramの詳細ページも、人為的な反応数や表示位置を販売する注文ページではありません。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.1.a | 그렇게 보장되지 않습니다. 점수는 서비스 내 비교 정보이며 실제 상담 연결과 계약은 DB의 적법성·시점·대상, 담당자의 상담과 시장 상황 등 여러 요인의 영향을 받습니다. | そのようには保証されません。スコアはサービス内の比較情報です。実際に相談につながるか、契約に至るかは、リードの適法性・時点・対象、担当者の相談対応、市場の状況など、複数の要因に左右されます。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.2.a | 보장되지 않습니다. 구매자는 거래 전에 수집 출처, 동의 범위, 제공·이용 목적, 보유기간과 AS 조건을 확인해야 합니다. | 保証されません。購入者は取引前に、収集元、同意の範囲、提供・利用目的、保有期間、アフターサポートの条件を確認する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.3.a | 아닙니다. 서비스는 관리 흐름을 돕지만 거래·이용 주체의 법적·계약상 책임을 대신하지 않습니다. 조직의 기준과 필요한 전문 검토가 별도로 필요합니다. | いいえ。サービスは管理の流れを支援しますが、取引・利用主体の法的責任や契約上の責任を代わりに負うものではありません。組織としての基準と、必要な専門家による確認は別途必要です。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.4.a | 보장되지 않습니다. 연락 가능 여부, 상담 의향, 정보의 시의성, 배분과 상담 품질에 따라 결과가 달라질 수 있습니다. | 保証されません。連絡の可否、相談の意向、情報の鮮度、配分や相談対応の質によって、結果が変わる場合があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.8.a | 정확성을 보장하지 않습니다. 분석은 패턴과 검토 지점을 찾는 보조 정보이며 관리자 또는 검수자가 통화 원자료와 상담 맥락을 함께 확인해야 합니다. | 正確性は保証しません。分析は、パターンや確認すべき点を見つけるための補助情報です。管理者または検査担当者が、通話の元データと相談の文脈を併せて確認する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.10.a | 그렇게 단정할 수 없습니다. 통화 방식과 데이터 처리 구조에 맞는 고지·동의, 이용 목적, 접근 권한, 보유·파기 기준을 실제 운영 전에 확인해야 합니다. | そのようには断定できません。実際の運用前に、通話方法とデータ処理の仕組みに合った告知・同意、利用目的、アクセス権限、保有・破棄の基準を確認する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.11.a | 보장하지 않습니다. 원천 DB의 수집·제공·마케팅 이용 근거와 고객사 납품 조건은 운영·거래 당사자가 직접 확인해야 합니다. | 保証しません。元となるリードの収集・提供・マーケティング利用の根拠と、顧客企業への納品条件は、運営・取引の当事者が直接確認する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.build.items.3.a | 아닙니다. 워드프레스는 검색엔진이 접근하기 좋은 구조를 만들 수 있는 도구일 뿐입니다. 기술 기반, 콘텐츠, 경쟁도와 지속적인 운영이 함께 필요합니다. | いいえ。WordPressは、検索エンジンがアクセスしやすい構造を作れるツールにすぎません。技術基盤、コンテンツ、競争の度合いの把握、継続的な運用も必要です。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.build.items.6.a | 보장하지 않습니다. 선정과 지원금 지급은 운영기관의 심사·협약·정산 기준에 따라 결정됩니다. 제이커브는 협의된 범위에서 과업 해석, 실행 계획, 마케팅 운영과 결과 자료 준비를 지원합니다. | 保証しません。採択と支援金の支給は、運営機関の審査・協約・精算基準に基づいて決定されます。J-Curveは合意した範囲で、業務内容の解釈、実行計画、マーケティング運用、結果資料の準備を支援します。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.build.items.8.a | 아닙니다. 인정되는 비용, 자부담, 집행 기간, 공급기업 요건과 증빙 방식은 사업마다 다릅니다. 계약이나 집행 전에 운영기관의 공고·협약·지침을 확인해야 합니다. | いいえ。対象となる費用、自己負担、支出期間、供給企業の要件、証明方法は、事業ごとに異なります。契約や支出の前に、運営機関の公募・協約・指針を確認する必要があります。 | OK — 부정어 대응 | 해당 없음 |
| lang/ja/pages/faq.php | categories.build.items.9.a | 공고상 인정 범위와 기업의 과업 목표에 따라 퍼포먼스 광고, SEO, 콘텐츠, 영상, 웹 제작 등을 검토할 수 있습니다. 모든 사업에서 모든 항목이 인정되는 것은 아닙니다. | 公募で認められる範囲と企業の業務目標に応じて、パフォーマンス広告、SEO、コンテンツ、動画、Web制作などを検討できます。すべての事業ですべての項目が認められるわけではありません。 | OK — 부정어 대응 | 해당 없음 |

## 7. U6 용어집 §8 전수 572잎

한 잎에 여러 용어가 있으면 한 줄에 모두 기재했다. 미검출 119잎은 아래 표에서 대응 차이를 공개한다. `개인정보` 안의 `인정`, `흩어지면` 안의 `지면`, `상담원` 안의 `상담`처럼 의미가 다른 부분 문자열은 실제 오역으로 세지 않았다. `差し戻さず`는 差し戻し의 활용형, `discuss`·`call`은 문맥상 상담 대응이다. 제목/답변에서 참조로 생략한 명사와 정확한 지정 용어가 아닌 표현은 차이로 남겼다.

금지 검색 `ペット|地面|グラウンド|オペレーティングシステム|カウンセリング|インフロー|operating system|material(s)|top exposure|inflow|counseling|remodeling` = 0. §8의 다른 틀린 예도 문맥을 확인했다. 투자 수익을 가리키는 `return`, 일반 영문 접속사 `as`, 고객 인지를 가리키는 `認識`은 각각 반려·AS·유효인정 번역이 아니므로 금지 위반으로 오판하지 않았다.

| 파일 | 키 | 용어 | 한국어 | 번역 | 대응 검사 | 판정 | 대안 |
| --- | --- | --- | --- | --- | --- | --- | --- |
| lang/en/subpages.php | seo.items.backlinks.meta_description | 상위노출 | 10년간 1,000여 개의 SEO 프로젝트를 성공적으로 수행하며 얻은 검색엔진최적화에 대한 깊은 이해와 경험을 바탕으로 제공하는 전문 백링크 서비스로 검색엔진 상위노출을 경험하세요. 구글과 네이버에 최적화된 검증된 고품질 백링크 전략은 자연스러운 순위 상승을 돕습니다. 무료 컨설팅을 신청하세요. | Our specialist backlink service draws on deep SEO knowledge gained from successfully delivering over 1,000 SEO projects in 10 years. Our proven, quality backlink strategies for Google and NAVER — Korea's largest search portal — support natural ranking improvements. Request a free consultation. | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.backlinks.sections.2.title | 상담 | 상담과 진행 과정에서 확인하는 항목 | What we review during consultation and delivery | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.seo_title | 상위노출 | 네이버 플레이스 상위노출 마케팅, 전문가의 노출 최적화로 매출 상승 | NAVER Place ranking services — expert visibility optimization to grow sales | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.meta_description | 상위노출 | 네이버 플레이스 상위노출 마케팅 성공은 제이커브와 함께! 풍부한 SEO 노하우로 순위 상승, 방문자 증가, 매출 상승을 실현하는 최적의 전략을 제공합니다. | Work with J-Curve on NAVER Place rankings. Drawing on extensive SEO experience, we develop strategies to improve rankings, increase visits and grow sales. | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.faq.2.question | 상담 | 상담 전에 무엇을 준비하면 되나요? | What should I prepare before a consultation? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.seo_title | 상위노출 | 네이버쇼핑 상위노출 마케팅 전문가의 노하우로 매출 UP | Grow sales with specialist NAVER Shopping ranking expertise | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.meta_description | 상위노출 | 네이버쇼핑 상위노출 마케팅을 위한 SEO는 제이커브에게 맡기세요! 10년 이상 풍부한 노하우로 상품 노출 극대화, 클릭률 향상, 매출 증대를 실현시켜 드립니다. | Trust J-Curve with SEO for higher NAVER Shopping rankings. We draw on over 10 years of experience to maximize product visibility, improve click-through rates and grow sales. | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.sections.3.items.0.text | 운영 체계 | 상품군별 정보 기준이 달라져 운영 체계를 다시 잡아야 하는 경우. | You need consistent information standards and a clearer workflow across product groups. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.seo_title | 상위노출 | 카카오선물하기 상위노출로 비즈니스 성장을 경험하세요 - SEO 전문 컨설팅 기업 &#124; 제이커브인터렉티브 | Grow your business with top Kakao Gift rankings — SEO specialists &#124; J-Curve Interactive | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.meta_description | 상위노출 | 카카오선물하기 상위노출 마케팅 — 선물 대상·상황·가격대별 탐색 의도와 상품 정보, 이미지, 상세 설명을 함께 정비하는 제이커브 SEO 서비스입니다. 무료 컨설팅을 신청하세요. | J-Curve's Kakao Gift SEO service reviews search intent by recipient, occasion and price range alongside product details, images and descriptions. Request a free consultation about improving rankings. | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.sections.3.items.3.text | 운영 체계 | 재고·배송·CS 기준이 불명확하다면 노출보다 운영 체계를 먼저 정해야 합니다. | If stock, delivery and customer service standards are unclear, define your operating process before seeking visibility. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.faq.1.answer | 상담 | 가능 여부는 상품과 운영 상태에 따라 다르지만, 검수·콘텐츠·재고 준비를 고려하면 여유 있게 시작하는 편이 좋습니다. 상담 시 목표 시즌을 먼저 알려주세요. | It depends on the product and your readiness. Starting early allows time for reviews, content and stock preparation. Tell us your target season during the consultation. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.seo_title | 상위노출 | 쿠팡 상위노출로 매출 상승의 기회를 잡으세요 - SEO 전문 컨설팅 기업 &#124; 제이커브인터렉티브 | Create opportunities to grow sales with top Coupang rankings — SEO specialists &#124; J-Curve Interactive | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.meta_description | 상위노출 | 쿠팡 상위노출 마케팅 — 카테고리·옵션·상품명·이미지·배송 정보와 상세페이지를 함께 점검하는 제이커브 쿠팡 상품 검색 최적화 서비스입니다. 무료 컨설팅을 신청하세요. | J-Curve's Coupang product SEO service reviews categories, options, names, images, delivery information and product pages together. Request a free consultation about improving rankings. | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.sections.0.title | 지면 | 상품 데이터가 흩어지면 고객도 알고리즘도 이해하기 어렵습니다 | Scattered product data is hard for customers and algorithms to understand | 지면=흩어지면의 일부, 광고 지면 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.title | 상담 | 부동산 분양 광고 — 상담 가능한 관심고객을 정의하는 일 | Real estate pre-sale advertising — defining prospects ready for consultation | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.lead | DB·상담 | 부동산 분양 CPA는 상담 신청이 들어왔다는 사실만 세는 광고가 아닙니다. 사업지와 공급 조건을 정확히 설명하고, 고객의 연락 동의와 유효 DB 기준, 상담 후 피드백까지 연결해야 품질을 관리할 수 있습니다. | CPA marketing for real estate pre-sale (new developments) goes beyond counting consultation requests. Quality depends on accurate project and sales information, consent to contact, valid lead criteria and feedback from consultations. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.meta_description | 상담·인정 | 사업지 정보, 상담 신청 기준, 개인정보 동의, 트래킹과 상담 피드백을 함께 설계하는 부동산 분양 CPA 마케팅입니다. | CPA marketing for real estate pre-sales that connects project information, consultation request criteria, privacy consent, tracking and consultation feedback. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.hero_cta | 상담 | 분양 CPA 구조 상담 | Discuss a real estate CPA campaign | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.body.0 | 상담 | 사업지와 고객 조건에 맞춰 상담 신청의 정의와 운영 기준을 먼저 합의하는 부동산 분양 CPA 서비스입니다. | We agree on consultation request definitions and operating criteria first, based on the development and target customer profile. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.body.1 | 상담 | 상담 신청은 실제 방문이나 계약을 의미하지 않으며 계약 성과를 보장하지 않습니다. | A consultation request does not mean a site visit or signed contract. We do not guarantee contract results. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.0.title | DB·상담 | DB가 많아도 상담 기준이 다르면 성과를 판단할 수 없습니다 | Lead counts mean little without shared consultation criteria | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.0.paragraphs.1 | 상담 | 캠페인 시작 전에 사업지의 사실 정보, 목표 고객, 유효·무효 기준과 상담 대응 시간을 합의해야 광고 데이터를 영업 결과와 연결할 수 있습니다. | Before launch, agree on project facts, target customers, valid and invalid lead criteria, and response times. This connects campaign data to sales results. | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.1.items.1.title | DB | 유효 DB 기준 합의 | Agree on valid lead criteria | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.1.items.3.title | 상담 | 상담 결과 피드백 | Use consultation feedback | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.1.items.3.text | 소재·상담 | 유입 이후 상담 상태를 분류해 매체·소재·타게팅 개선에 반영합니다. | We classify consultation status after acquisition and feed it into media, creative and targeting improvements. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.2.items.1 | 상담 | 목표 지역·고객 조건과 필수 상담 신청 항목 | Target areas, customer criteria and required consultation fields | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.2.items.2 | 상담·인정 | 개인정보 수집·이용 및 상담 연락 동의 문구 | Consent wording for personal data collection, use and consultation contact | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.2.note | 상담 | 관련 법령과 매체 심사 기준을 확인해야 하며, 상담 신청·방문·분양 계약을 보장하지 않습니다. | Applicable laws and media review requirements must be checked. We do not guarantee consultation requests, visits or pre-sale contracts. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.3.items.0.title | 상담 | 상담 대응 체계가 있는 현장 | Developments with a consultation workflow | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.3.items.0.text | 상담 | 유입 후 빠르게 연락하고 상담 상태를 기록할 담당자가 있는 경우. | You have staff who can respond promptly and record consultation status. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.3.items.2.text | DB·상담 | DB 수량뿐 아니라 상담 결과를 캠페인 개선에 활용하려는 경우. | You want to improve campaigns using consultation results as well as lead counts. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.3.items.3.text | 상담 | CPA는 상담 기회를 만드는 구조이며 계약 결과를 대신 확정할 수 없습니다. | CPA creates consultation opportunities. It cannot determine contract outcomes for you. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.faq.0.question | DB | 수집된 DB는 모두 실제 계약 가능 고객인가요? | Are all collected leads ready to sign a contract? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.faq.0.answer | DB·상담 | 아닙니다. DB는 정해진 정보를 입력하고 상담 연락에 동의한 신청입니다. 방문이나 계약 여부는 상품 조건, 상담 품질과 고객 판단에 따라 달라집니다. | No. A lead is a request from someone who supplied the required information and consented to consultation contact. Visits and contracts depend on the offer, consultation quality and the customer's decision. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.faq.1.question | DB | 유효 DB 기준은 누가 정하나요? | Who sets the valid lead criteria? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.faq.2.question | 인정 | 개인정보 동의도 함께 설계하나요? | Do you help design privacy consent? | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.cta.title | DB | 사업지 정보와 유효 DB 기준부터 맞춰보세요 | Start with project information and valid lead criteria | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.cta.text | 상담 | 목표 지역, 상담 조직과 현재 광고 구조를 알려주시면 실행 가능 범위를 구체적으로 검토합니다. | Tell us your target areas, consultation team setup and current campaign structure. We will assess the scope we can deliver. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.cta.label | 상담 | 분양 CPA 구조 상담 | Discuss a real estate CPA campaign | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.title | DB | 주식 DB 마케팅 — 동의와 광고 적합성을 먼저 설계합니다 | Stock-investor lead marketing — consent and ad eligibility first | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.lead | 상담 | 주식 관련 CPA는 투자 관심고객의 상담 신청을 측정하는 캠페인입니다. 수익 기대를 자극하는 과장 표현 대신 서비스의 실제 범위와 위험 정보를 명확히 설명하고, 연락 동의와 유효성 기준을 기록해야 합니다. | Stock-investor CPA campaigns measure consultation requests from people interested in investing. Rather than exaggerate potential returns, explain the service's actual scope and risks, and record consent to contact and lead validity criteria. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.meta_description | DB·상담 | 광고 표현 검토, 상담 동의, 유효 DB 기준과 트래킹을 함께 설계하는 주식·투자 관심고객 CPA 마케팅입니다. | CPA marketing for stock-investor leads that connects ad claim reviews, consultation consent, valid lead criteria and tracking. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.hero_cta | 상담 | 주식 CPA 적합성 상담 | Discuss stock-investor CPA eligibility | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.body.0 | 상담 | 서비스 범위와 위험 정보를 사실대로 설명하고 상담 연락에 동의한 신청을 측정하는 CPA 서비스입니다. | We explain the service's actual scope and risks, and measure requests from people who consent to consultation contact. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.body.1 | 상담 | 투자 수익, 원금, 가입 또는 상담 전환을 보장하지 않습니다. | We do not guarantee investment returns, principal protection, sign-ups or consultation conversions. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.0.paragraphs.1 | 소재 | 제이커브는 광고 문구, 랜딩 설명, 연락 동의와 전환 정의를 하나의 흐름으로 검토합니다. 캠페인 가능 여부도 소재를 만들기 전에 판단합니다. | We review ad copy, landing page information, consent to contact and conversion definitions as one process. We assess campaign eligibility before producing creative. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.1.title | 상담 | 적합성 확인부터 상담 피드백까지 | From eligibility review to consultation feedback | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.1.items.1.title | 상담 | 상담 신청 기준 설계 | Define consultation request criteria | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.1.items.3.title | 상담 | 상담 결과 기반 개선 | Improve campaigns using consultation results | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.1.items.3.text | 소재·상담 | 연락·상담 상태를 분류해 소재와 타게팅 개선에 반영합니다. | We classify contact and consultation status to improve creative and targeting. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.2.items.2 | 상담·인정 | 개인정보 수집·상담 연락 동의 및 보유 기준 | Consent for data collection and consultation contact, with retention rules | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.2.items.3 | DB·상담 | 유효 DB 정의, 상담 담당자와 결과 피드백 방식 | Valid lead definitions, consultation staff and the feedback process | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.3.items.2.title | 상담 | 상담 결과를 기록하는 조직 | Organizations that record consultation results | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.faq.0.answer | 상담 | 그럴 수 없습니다. CPA는 상담 관심과 신청을 측정할 뿐 투자 결과를 예측하거나 보장하지 않습니다. 수익을 암시하는 광고 표현도 별도 검토가 필요합니다. | No. CPA measures interest and consultation requests; it does not predict or guarantee investment outcomes. Ad claims that imply returns also require separate review. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.faq.2.question | 상담 | 상담 신청 정보는 어떻게 관리하나요? | How is consultation request data managed? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.cta.label | 상담 | 주식 CPA 적합성 상담 | Discuss stock-investor CPA eligibility | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.eyebrow | DB | Insurance Permission DB | Consented insurance leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.lead | 상담 | 보험디비는 전화번호 한 건을 전달하는 상품이 아닙니다. 광고 유입, 퍼미션콜, 동의·녹취 확인, 중복 기준, 지역·조건 매칭, 미팅 조정, AS와 영업 피드백이 이어져야 실제 상담 기회가 됩니다. | An insurance lead is more than a phone number. It becomes a genuine consultation opportunity when ad acquisition, consent verification calls, consent and recording checks, duplicate criteria, location and eligibility matching, meeting coordination, after-sales support and sales feedback work together. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.meta_description | DB | 보험디비·보험 퍼미션DB의 차이, 수집·동의·녹취·중복·AS 기준, 맞춤 스크립트와 리드베이 CRM 연계까지 설명하는 제이커브 보험 CPA 안내입니다. | J-Curve's insurance CPA guide explains standard and consented insurance leads, collection, consent, recording, duplicate and after-sales support criteria, tailored scripts and LeadBay CRM integration. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.hero_cta | DB·상담 | 보험 DB 운영 상담 | Discuss insurance lead operations | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.inquiry_template | DB | [보험 CPA·퍼미션 DB 문의]<br><br>조직 형태 / 설계사 수: <br>희망 DB 유형: <br>희망 지역: <br>월 희망 물량: <br>현재 DB 구매·배분 방식: <br>필요 범위: 광고 유입 / DB 납품 / 리드베이 / 콜투세일<br>현재 유효·AS 기준: <br>시작 희망일:  | [Insurance CPA and consent-based lead inquiry]<br><br>Organization type / Number of insurance agents: <br>Preferred lead type: <br>Target regions: <br>Desired monthly volume: <br>Current lead purchasing and allocation process: <br>Required scope: Ad acquisition / Lead delivery / LeadBay / Call2Sale<br>Current validity and after-sales support criteria: <br>Preferred start date:  | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.local_nav.1.label | DB | 퍼미션 DB | Consented leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.body.0 | 상담 | 상담 연락에 동의한 신청을 퍼미션콜·검수·배분·상담 피드백과 연결하는 보험 CPA 서비스입니다. | Our insurance CPA service connects requests with consent to consultation contact to consent verification calls, reviews, allocation and consultation feedback. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.title | DB | 광고 유입·DB 공급·영업관리를 한 구조로 봅니다 | One process for ad acquisition, lead supply and sales management | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.lead | DB | 기존 보험 랜딩의 강점이었던 퍼미션 DB 운영과 리드베이 기능을 현재 제이커브 서비스 구조에 맞춰 연결했습니다. | We connect the consented lead operations and LeadBay features highlighted on our previous insurance landing page to J-Curve's current services. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.items.0.text | 소재·DB·상담 | 광고 소재와 랜딩, 상담 신청, 연락 동의, 퍼미션콜과 유효 DB 기준을 설계합니다. | We design ad creative, landing pages, consultation requests, consent to contact, verification calls and valid lead criteria. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.items.1.text | DB·상담 | DB 업체·조건 비교부터 배분, 상담 일정, 계약, AS와 정산까지 영업조직의 활용 과정을 관리합니다. | Manage how your sales organization uses leads, from comparing suppliers and terms to allocation, appointments, contracts, after-sales support and settlement. | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.items.2.text | DB·상담 | 보험DB 콜센터의 원천 DB, 상담원 배분, 콜 품질, 납품, AS와 정산 업무를 관리합니다. | Manage source leads, agent allocation, call quality, delivery, after-sales support and settlement for insurance lead call centers. | 상담원=agent/operator, 상담 용어 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.items.3.title | 상담 | 상담 결과의 광고 환류 | Feed consultation results back into advertising | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.items.3.text | 상담 | 연락·미팅·상담·계약 상태를 같은 기준으로 기록해 어떤 유입과 스크립트를 개선할지 판단합니다. | Record contact, meeting, consultation and contract status consistently to identify which acquisition sources and scripts need improvement. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.note | DB·인정 | 실제 광고, DB 공급과 솔루션 연동 범위는 조직의 계약 구조, 시스템과 개인정보 처리 역할을 확인한 뒤 확정합니다. | We finalize the advertising, lead supply and platform integration scope after reviewing your contracts, systems and personal data processing responsibilities. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.1.items.1.text | DB | 2026년 기준 · 제이커브 회사 전체 누적 수집 DB | As of 2026 · J-Curve's cumulative leads collected, company-wide | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.2.title | DB | 보험DB 문제는 대부분 수집 이후에 드러납니다 | Most insurance lead problems emerge after collection | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.2.items.2.text | 반려 | 광고주·공급사마다 중복의 기간과 식별 기준이 다르면 반려와 정산 분쟁이 반복됩니다. | Different duplicate windows and identification rules across advertisers and lead suppliers cause repeated rejection and settlement disputes. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.2.items.3.title | 상담 | 상담 결과가 돌아오지 않는다 | Missing consultation feedback | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.2.items.5.title | DB | DB와 영업관리가 분리된다 | Lead data disconnected from sales management | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.2.items.5.text | 상담 | 구매·배분·상담·계약·AS·정산이 서로 다른 엑셀에 있으면 조직 성과를 같은 기준으로 보기 어렵습니다. | When purchases, allocation, consultations, contracts, after-sales support and settlement sit in separate spreadsheets, consistent performance assessment is difficult. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.3.title | DB | 퍼미션 DB는 체크박스가 아니라, 고객이 예상한 연락입니다 | Consented leads mean expected contact, beyond a checkbox | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.3.paragraphs.1 | DB·상담 | 보험 퍼미션 DB에서는 광고·랜딩에서 받은 1차 신청을 그대로 넘기지 않고, 캠페인 구조에 따라 연락 주체와 상담 목적, 제3자 제공 또는 처리위탁 관계, 핵심 상담 의사를 다시 확인하는 과정이 붙을 수 있습니다. | For consented insurance leads, the 1st landing page submission may undergo further checks before delivery. Depending on the campaign, these can confirm the caller, consultation purpose, 3rd-party sharing or data processing arrangements, and the customer's intent to discuss insurance. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.3.paragraphs.2 | 상담 | 다만 동의가 있다는 이유만으로 모든 전화, 무기한 보관, 자유로운 재제공이 허용되는 것은 아닙니다. 수집 항목·목적·제공받는 자·보유기간·철회 방법과 실제 상담 흐름이 맞아야 합니다. | Consent does not permit every call, indefinite retention or unrestricted onward sharing. Data fields, purposes, recipients, retention periods, withdrawal methods and actual consultation practices must align. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.3.note | 인정 | 이 페이지는 법률 자문이 아닙니다. 실제 캠페인은 적용 법령, 금융·보험 광고 기준, 개인정보 처리 역할과 광고주 내부 준법 기준을 별도로 확인해야 합니다. | This page is not legal advice. Each campaign needs separate checks against applicable laws, financial and insurance advertising standards, data processing responsibilities and the advertiser's internal compliance rules. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.4.eyebrow | DB | DB vs Permission DB | Standard vs consented leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.4.title | DB | 일반 신청 DB와 퍼미션 DB의 차이는 ‘전달 전 확인’입니다 | The difference is verification before delivery | DB 지정 표현 미일치(아래 품질 판정 함께 참고) | 오역 — 일반 신청 DB와 퍼미션 DB라는 두 비교 대상을 제목에서 모두 삭제함. | The difference between standard application leads and consent-based leads is verification before delivery. |
| lang/en/subpages.php | cpa.items.insurance.sections.4.columns.1 | DB | 일반 랜딩 신청 DB | Standard landing page leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.4.columns.2 | DB | 퍼미션 확인을 거친 DB | Leads with consent verification | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.4.rows.2.0 | 상담 | 상담 준비도 | Readiness for consultation | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.4.rows.2.2 | 상담 | 상담 의사·주제·지역·일정 등 합의한 조건을 재확인 | Agreed details such as intent, topic, location and schedule are reconfirmed | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.4.rows.3.1 | 상담 | 부재·오인·중복 원인을 상담원이 직접 분류 | Agents must classify no-answer, misunderstanding and duplicate cases themselves | 상담원=agent/operator, 상담 용어 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.5.items.0.text | 상담·리모델링 | 보험 리모델링, 보장 분석, 상담 등 실제 제공 범위를 과장 없이 설명하고 신청 목적을 맞춥니다. | We accurately explain the actual scope, such as policy review / switching, coverage analysis and consultation, and align it with the request's purpose. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.5.items.2.text | 상담 | 캠페인 조건에 따라 상담 주제, 연락 주체, 지역, 가능한 일정과 핵심 의사를 다시 확인합니다. | Depending on campaign terms, we reconfirm the consultation topic, caller, location, available schedule and core intent. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.5.items.4.text | DB | 영업 지역, 조직, 기존 보유 DB와 중복 기준을 확인해 담당자를 배정하고 전달 시점을 기록합니다. | We check sales regions, organizations, existing lead data and duplicate rules, then assign staff and record delivery times. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.5.items.5.title | 상담 | 미팅·상담 상태 관리 | Manage meeting and consultation status | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.5.items.6.text | 소재·상담 | 사전 합의한 AS 증빙을 확인하고 상담 결과를 소재·타기팅·스크립트와 다음 물량 판단에 반영합니다. | We review the evidence agreed for after-sales support and use consultation results to improve creative, targeting, scripts and future volume decisions. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.6.items.0.text | DB | 신청·확인·전달 시간을 기록하고, 오래된 DB와 신규 DB가 섞이지 않도록 캠페인별 납품 주기와 예상 물량을 합의합니다. | Record request, verification and delivery times. Agree on campaign delivery cycles and expected volumes so older and new leads are not mixed. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.6.items.2.text | DB | 한 광고주 전용 여부, 중복 확인 기간, 식별값, 기존 보유 DB 대조와 재제공 금지 범위를 집행 전에 문서화합니다. | Before launch, document advertiser exclusivity, duplicate check windows, identifiers, checks against existing leads and limits on onward supply. | OK — §8 지정 표현 대응 | 어색 — limits on onward supply는 재제공 금지 범위의 강도를 명확히 드러내지 않음. | Before launch, document advertiser exclusivity, duplicate-check windows, identifiers, checks against existing leads and the scope of the prohibition on resupplying leads. |
| lang/en/subpages.php | cpa.items.insurance.sections.6.items.3.text | 상담·리모델링 | 보험 리모델링 설명, 미팅 재확인, 지역·상담 유형과 영업 방식에 맞춰 확인 질문과 전달 정보를 조정합니다. | Adapt verification questions and delivery details to policy review / switching, meeting reconfirmation, regions, consultation types and sales methods. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.7.items.0 | DB | 퍼미션 DB | Consented leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.7.items.1 | DB | 준실버 DB | Semi-silver leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.7.items.2 | DB | 실버 DB | Silver leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.7.items.3 | DB | 확정 DB | Confirmed leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.7.items.4 | 리모델링 | 보험 리모델링 | Policy review / switching | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.7.note | DB·상담 | DB 유형 명칭만으로 품질을 판단하지 마세요. 각 유형의 필수 확인 항목, 상담 의사 수준, 증빙과 AS 범위를 계약서에서 정의해야 합니다. | Lead type names alone do not establish quality. Define required checks, consultation intent, evidence and after-sales support scope for each type in the contract. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.8.rows.2.0 | 상담 | 상담 내용 불일치 | Mismatch in consultation expectations | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.8.rows.2.2 | 상담 | 광고 약속과 실제 상담 의사가 달랐는지 검수 | Review whether the ad's promise differed from the customer's actual consultation intent | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.8.rows.4.2 | 인정 | AS 포함 여부와 인정 기간·증빙을 별도로 합의 | Separately agree on support eligibility, claim windows and evidence | 인정 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.8.rows.5.1 | 상담 | 상담 상태와 거절 사유 | Consultation status and reasons for refusal | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.8.rows.5.2 | 상담 | 계약 결과는 기본 AS 사유가 아니며 광고·상담 개선 데이터로 분류 | Failure to sign is not a default support reason; use it as feedback to improve advertising and consultations | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.8.note | 반려 | 주관적인 “질이 나쁘다”만으로 반려하지 않고, 양측이 같은 자료와 기한으로 판단할 수 있어야 합니다. | Do not reject leads solely on subjective claims of “poor quality.” Both parties need shared evidence and deadlines for assessment. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.9.title | DB | 광고주 규모와 영업 방식에 따라 같은 DB도 다르게 운영합니다 | The same leads need different workflows for different advertiser sizes and sales models | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.9.items.0.title | DB | 보험DB가 처음인 조직 | Organizations new to insurance leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.9.items.1.text | 상담 | 감당 가능한 물량과 지역을 좁히고 담당자별 배분 누락 없이 상담 피드백을 받는 구조를 우선합니다. | Focus on manageable volumes and regions, complete staff allocation and reliable consultation feedback. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.9.items.2.text | DB | 기존 보유 DB와의 중복 대조, 지점·팀별 배분, 물량 일정, 권한과 정산 기준을 먼저 맞춥니다. | Align checks against existing leads, branch and team allocation, volume schedules, permissions and settlement criteria first. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.9.items.3.title | 상담·리모델링 | 리모델링 중심 상담 | Consultations focused on policy review / switching | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.9.items.3.text | 상담 | 고객이 기대한 상담 범위와 미팅 목적을 정확히 설명하고 재확인할 스크립트를 설계합니다. | Design scripts that accurately explain and reconfirm the expected consultation scope and meeting purpose. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.10.title | DB | DB를 산 뒤의 일을 리드베이에서 이어서 관리합니다 | Manage what happens after lead purchase in LeadBay | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.10.items.0.title | DB | DB 구매 관리 | Lead purchase management | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.10.items.1.text | DB | DB별 AS 가능 기간과 신청 상태, 승인·거절 결과와 필요한 증빙을 한 흐름에서 확인합니다. | See each lead's support window, request status, approval or rejection outcome and required evidence in one workflow. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.10.items.2.title | 상담 | 상담 일정 관리 | Consultation scheduling | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.10.items.2.text | 상담 | 상담 일정, 메모, 연락과 진행 상태를 남겨 담당자와 후속 조치를 놓치지 않게 관리합니다. | Record appointments, notes, contact and progress so the responsible staff and follow-up actions stay clear. | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.10.items.3.text | DB·상담 | 보유 DB, 컨택, 미팅, 상담과 계약의 단계별 전환을 팀원·월·지점 기준으로 비교합니다. | Compare lead-to-contact, meeting, consultation and contract conversions by team member, month and branch. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.10.items.5.title | 상담 | 모바일 상담 앱 | Mobile consultation app | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.10.items.5.text | 상담 | 외근 중 상담 이력과 녹취를 정리하고 AI 요약을 검토 보조자료로 활용합니다. 최종 판단은 담당자가 원자료와 함께 확인합니다. | Organize consultation histories and recordings while in the field. Use AI summaries to assist review; staff must check the source records before making final decisions. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.11.title | 상담 | 비교·구매·상담·AS·정산이 한 기록으로 이어집니다 | One record from comparison and purchase to consultation, support and settlement | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.11.items.0.title | DB | 콜센터 DB 마켓 | Call center lead marketplace | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.11.items.0.text | DB | DB 유형, 품질·납품·AS 정보, 잔여 수량과 예상 완료일을 비교해 구매 판단의 근거를 남깁니다. | Compare lead types, quality, delivery and support information, remaining quantities and expected completion dates to document purchasing decisions. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.11.items.1.title | DB | 내 DB 영업 관리 | Manage your lead sales pipeline | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.11.items.1.text | DB·상담 | 미접촉부터 재통화·미팅·상담·계약·AS까지 상태를 관리하고 일정·메모·녹취 이력을 DB 단위로 연결합니다. | Track leads from initial non-contact through callbacks, meetings, consultations, contracts and after-sales support. Connect schedules, notes and recordings to each lead. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.11.items.2.text | 상담 | AS 가능일과 처리 상태를 추적하고 구매·상담·계약 이력을 분쟁 검토 자료로 활용합니다. | Track support eligibility dates and progress. Use purchase, consultation and contract histories as evidence when reviewing disputes. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.12.title | DB | DB를 생산·납품하는 콜센터라면 콜투세일로 이어집니다 | Call2Sale supports call centers that produce and deliver leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.12.items.0.title | DB·상담 | 원천 DB와 상담원 배분 | Source leads and agent allocation | 상담원=agent/operator, 상담 용어 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.12.items.0.text | DB·상담 | 수집된 원천 DB가 어느 상담원에게 배정되고 어떤 상태인지 공급 조직 안에서 관리합니다. | Track which agents receive collected source leads and their status within the supplier organization. | 상담원=agent/operator, 상담 용어 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.12.items.1.text | 상담 | 스크립트 준수와 상담 품질을 기록하고 AI 분석은 관리자의 검토를 돕는 보조자료로 활용합니다. | Record script adherence and consultation quality. Use AI analysis as supporting information for manager review. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.12.note | DB | 리드베이는 DB를 활용하는 구매·영업 조직, 콜투세일은 DB를 생산·납품하는 공급 조직의 흐름에 초점을 둡니다. | LeadBay focuses on buyers and sales teams using leads. Call2Sale focuses on suppliers producing and delivering them. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.13.items.0.text | DB·상담 | 상담 주체, 설계사 수, 대응 지역, 상품 범위와 현재 DB 운영 문제를 확인합니다. | We check who conducts consultations, agent numbers, service areas, product scope and current lead operations issues. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.13.items.1.title | DB | DB 유형·유효·AS 합의 | Agree on lead types, validity and support | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.13.items.3.text | 반려 | 작은 지역·물량으로 연락률, 미팅 상태, 반려 사유와 담당자 입력 품질을 확인합니다. | We use a limited region and volume to check contact rates, meeting status, rejection reasons and the quality of staff data entry. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.13.items.4.text | 상담 | 유입·스크립트·배분·상담 피드백이 안정된 범위만 단계적으로 확대합니다. | We gradually expand only where acquisition, scripts, allocation and consultation feedback are stable. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.14.title | DB | “동의받은 DB” 한 문장으로 끝내지 않습니다 | “Consented leads” is the start of the review | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.14.items.0 | 인정 | 광고주·콜센터·플랫폼 가운데 실제 개인정보 수집·이용·제공·위탁 주체가 누구인지 구분 | Identify who actually collects, uses, shares or processes personal data among the advertiser, call center and platform | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.14.items.1 | 상담 | 고객이 본 광고·랜딩 문구와 실제 연락 주체·목적·보험 상담 범위의 일치 확인 | Check that ad and landing page wording matches the actual caller, purpose and insurance consultation scope | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.14.items.5 | DB | 기존 보유 DB 대조와 중복 판정에 쓰는 식별값·기간·접근 권한 최소화 | Minimize identifiers, comparison windows and access used to check existing leads and duplicates | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.14.items.6 | 상담 | 광고 표현, 보험 모집·상담 역할과 고객 오인 가능성을 광고주 준법 기준으로 검토 | Review ad claims, insurance solicitation and consultation roles, and potential customer misunderstandings against the advertiser's compliance standards | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.14.note | 인정 | 사용 허락이 콘텐츠 저작권 문제를 해결해도 개별 캠페인의 적법성을 자동 보장하지는 않습니다. 실제 공개·집행 전 개인정보·금융 광고 담당자의 현재 기준 확인이 필요합니다. | Permission to use content may resolve copyright concerns, but does not automatically establish a campaign's legality. Before publication or launch, the people responsible for privacy and financial advertising must check current requirements. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.15.title | DB | 보험DB는 영업조직의 준비 수준만큼 작동합니다 | Insurance lead results depend on your sales team's readiness | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.15.items.0.title | DB | 처음 보험DB를 도입하는 GA | General insurance agencies new to leads | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.15.items.1.text | 상담 | 지역·담당자 배분, 권한과 팀별 상담·계약 퍼널을 같은 기준으로 보고 싶은 조직. | You want consistent regional and staff allocation, permissions, and consultation-to-contract funnels across teams. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.15.items.2.title | DB | 기존 DB 품질 분쟁이 잦은 광고주 | Advertisers with frequent lead quality disputes | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.15.items.3.text | 소재·상담 | 상담 결과를 광고 소재·타기팅·랜딩·퍼미션콜 개선으로 다시 돌려보내려는 팀. | You want consultation results to improve creative, targeting, landing pages and consent verification calls. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.15.items.4.text | DB·상담 | 보험DB는 상담 기회를 만드는 입력값이며 미팅·계약·매출을 확정하지 않습니다. | Insurance leads create consultation opportunities. They do not guarantee meetings, contracts or revenue. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.15.items.5.text | DB | 출처·연락 목적·제공 관계를 확인할 수 없다면 광고나 DB 전달보다 준법 구조를 먼저 정비해야 합니다. | If sources, contact purposes and data-sharing relationships cannot be verified, address compliance before advertising or delivering leads. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.0.question | DB | 보험DB는 정확히 무엇인가요? | What exactly is an insurance lead? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.0.answer | DB·상담 | 이 페이지에서 보험DB는 보험 관련 상담 연락을 위해 수집·전달되는 신청 정보를 뜻합니다. 전화번호만이 아니라 신청 목적, 동의 기록, 유효 기준, 전달 시점과 상담 상태를 함께 관리해야 합니다. | On this page, an insurance lead means request data collected and delivered for insurance consultation contact. Alongside phone numbers, you need to manage request purposes, consent records, validity criteria, delivery times and consultation status. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.1.question | DB | 일반 보험DB와 퍼미션DB는 무엇이 다른가요? | How do standard insurance leads differ from consented leads? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.1.answer | DB·상담 | 일반 신청 DB는 랜딩 입력을 중심으로 전달될 수 있지만, 퍼미션DB는 캠페인 조건에 따라 연락 주체·상담 목적·지역·일정과 고객 의사를 추가 확인하고 그 기록을 관리합니다. 구체적인 확인 항목은 계약마다 달라집니다. | Standard leads may be delivered based on landing page submissions. Depending on campaign terms, consented leads involve additional checks of the caller, consultation purpose, region, schedule and customer intent, with records retained. The exact checks vary by contract. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.2.question | DB | 보험 DB 한 건이 곧 미팅이나 보험 계약을 의미하나요? | Does one insurance lead mean a meeting or insurance contract? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.2.answer | DB·상담 | 아닙니다. DB는 합의한 조건을 충족한 상담 기회입니다. 실제 미팅과 가입 여부는 고객의 필요, 상품 적합성, 전달 시점, 담당자의 상담 품질과 고객 판단에 따라 달라집니다. | No. A lead is a consultation opportunity that meets agreed conditions. Meetings and sign-ups depend on customer needs, product suitability, delivery timing, staff consultation quality and the customer's decision. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.3.question | DB | 실시간으로 DB를 받을 수 있나요? | Can we receive leads in real time? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.5.answer | 인정 | 녹취 여부, 접근·제공 범위, 보관기간과 파기 방식은 캠페인·계약과 적용 기준에 따라 달라집니다. 개인정보가 포함되므로 필요성과 권한을 확인한 최소 범위로 운영합니다. | Recording practices, access and sharing scope, retention and destruction depend on campaign terms, contracts and applicable requirements. Recordings contain personal data, so access must be limited to what is necessary and authorized. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.6.question | DB | 한 번 받은 DB는 다른 곳에 절대 중복 납품되지 않나요? | Can you guarantee a delivered lead will never be supplied elsewhere? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.7.answer | 인정 | 자동으로 인정되지 않습니다. AS 가능 사유, 연락 횟수·시간대, 신청 기한, 필요한 증빙, 교환·보완 범위를 집행 전에 문서화해야 합니다. | No. Before launch, document eligible reasons, contact attempts and times, claim deadlines, required evidence and the scope of replacement or remediation. | 인정 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.8.answer | 상담 | 검토할 수 있지만 가용 물량은 지역, 타깃, 스크립트, 단가, 기간과 검수 조건에 따라 달라집니다. 먼저 작은 범위의 파일럿으로 실제 공급·상담 흐름을 확인하는 편이 안전합니다. | We can review your preferences, but available volumes depend on regions, targeting, scripts, pricing, timing and review requirements. A small pilot is the safer way to confirm actual supply and consultation workflows first. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.9.answer | DB·상담 | 리드베이는 보험DB를 비교·구매하고 배분·상담·계약·AS·정산하는 영업조직의 흐름에, 콜투세일은 DB를 생산·검수·납품하는 콜센터의 공급 운영에 초점을 둡니다. 실제 기능과 연동 범위는 각 서비스의 현재 조건을 확인해야 합니다. | LeadBay focuses on sales teams comparing, buying, allocating and using insurance leads through consultation, contracts, support and settlement. Call2Sale focuses on call centers producing, reviewing and delivering leads. Check each service's current terms for actual features and integration scope. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.10.question | 상담 | 상담 전에 무엇을 준비하면 되나요? | What should I prepare before a consultation? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.10.answer | DB | 조직 형태와 설계사 수, 대응 지역, 희망 DB 유형·월 물량, 현재 구매·배분 방식, 기존 CRM, 유효·중복·AS 기준과 시작 희망일을 알려주시면 검토가 빨라집니다. | Your organization type, agent count, service areas, preferred lead types and monthly volume, purchasing and allocation process, existing CRM, validity, duplicate and support criteria, and preferred start date will help speed up the review. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.cta.title | DB | 보험DB 견적보다 먼저, 유효·AS·배분 기준을 맞추세요 | Agree on validity, support and allocation before requesting a lead quote | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.cta.text | DB | 조직 규모, 희망 지역·물량, DB 유형과 현재 운영 방식을 알려주시면 광고 유입·퍼미션콜·리드베이·콜투세일 중 필요한 범위를 구체적으로 나눠드립니다. | Tell us your organization size, target regions, volume, lead types and current workflow. We will identify the specific scope you need across ad acquisition, consent verification calls, LeadBay and Call2Sale. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.cta.label | DB·상담 | 보험 DB 운영 상담 | Discuss insurance lead operations | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.title | DB | 코인 DB 마케팅 — 위험 고지와 동의가 출발점입니다 | Crypto-investor lead marketing — start with risk disclosures and consent | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.lead | 상담·인정 | 가상자산 관련 CPA는 관심고객의 상담 신청을 측정하되, 가격 상승이나 수익 가능성을 약속해서는 안 됩니다. 서비스 제공 범위, 변동성 위험, 광고 가능 여부와 개인정보 동의를 먼저 검토합니다. | Crypto CPA campaigns measure consultation requests from interested prospects. They must not promise price increases or potential returns. We first review the service scope, volatility risks, ad eligibility and privacy consent. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.meta_description | DB·상담 | 사업·광고 적합성, 위험 고지, 상담 동의와 유효 DB 기준을 먼저 확인하는 가상자산 관심고객 CPA 마케팅입니다. | CPA marketing for crypto-investor leads, starting with business and ad eligibility, risk disclosures, consultation consent and valid lead criteria. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.hero_cta | 상담 | 코인 CPA 적합성 상담 | Discuss crypto CPA eligibility | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.body.0 | 상담 | 가상자산 서비스의 실제 범위와 위험을 설명하고 상담 연락에 동의한 신청을 측정합니다. | We explain the actual scope and risks of your crypto service and measure requests from people who consent to consultation contact. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.0.paragraphs.1 | 상담 | 제이커브는 사업 주체와 서비스 범위, 필수 고지, 상담 신청과 동의 구조를 확인한 뒤 캠페인 가능 여부부터 판단합니다. | We review the provider, service scope, required disclosures, consultation request process and consent before assessing campaign eligibility. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.1.items.3.title | 상담 | 상담 피드백 기반 운영 | Use consultation feedback | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.1.items.3.text | 소재 | 신청 이후 상태를 분류해 허용된 범위에서 소재와 타게팅을 개선합니다. | We classify post-request status and improve creative and targeting within the permitted scope. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.2.title | 상담 | 상담 전에 준비할 자료 | What to prepare before a consultation | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.2.items.3 | DB·상담·인정 | 개인정보 동의, 상담 주체와 유효 DB 처리 기준 | Privacy consent, the consultation provider and valid lead handling criteria | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.3.items.2.title | 상담 | 상담 운영 기록이 가능한 조직 | Organizations that can record consultation activity | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.3.items.2.text | 상담 | 연락·상담 상태를 관리하고 동의 범위를 지킬 수 있는 경우. | You can manage contact and consultation status while respecting the consent scope. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.faq.1.answer | 상담 | 아닙니다. 서비스 유형, 제공 지역, 인허가·신고 상태와 매체 정책에 따라 제한될 수 있습니다. 상담 단계에서 사업 자료를 확인합니다. | No. Restrictions may depend on service type, operating regions, licensing or registration status, and media policies. We review your business documents during consultation. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.faq.2.question | 상담 | CPA면 상담 이후 투자 결과도 책임지나요? | Does CPA cover investment outcomes after consultation? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.faq.2.answer | 상담 | CPA는 합의한 상담 신청을 측정하는 과금 구조입니다. 고객의 투자 판단과 결과, 서비스 계약이나 수익을 보장하지 않습니다. | CPA is a billing model based on agreed consultation requests. It does not guarantee customers' investment decisions or outcomes, service contracts or returns. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.cta.label | 상담 | 코인 CPA 적합성 상담 | Discuss crypto CPA eligibility | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.title | DB | 퍼미션 콜 DB 마케팅 — 연락 동의를 운영 가능한 기록으로 | Consent-based call lead marketing — turning consent into usable records | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.meta_description | DB·상담·인정 | 상담 연락 목적, 개인정보 동의, 동의 기록, 전달·콜 운영과 철회 절차를 함께 설계하는 퍼미션 콜 DB 마케팅입니다. | Consent-based call lead marketing that connects contact purposes, privacy consent, consent records, lead delivery, call operations and withdrawal procedures. | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.hero_cta | 상담 | 퍼미션 구조 상담 | Discuss your consent process | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.body.0 | 상담 | 고객이 상담 연락의 목적과 주체를 이해하고 동의하도록 수집·전달·콜 운영 흐름을 설계합니다. | We design collection, delivery and call workflows so customers understand and consent to the purpose and provider of consultation contact. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.sections.0.paragraphs.1 | 운영 체계·DB·상담 | 수집 화면, 동의 로그, DB 전달, 상담 스크립트, 수신 거부와 보유 기간까지 하나의 운영 체계로 설계해야 합니다. | The collection form, consent logs, lead delivery, call scripts, opt-outs and retention periods need one operating process. | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.sections.1.items.2.title | 상담 | 전달·상담 운영 연결 | Connect lead delivery to consultation operations | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.sections.2.items.0 | 인정 | 개인정보 수집 항목·목적·보유 기간과 연락 주체 | Personal data fields, collection purpose, retention period and contacting party | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.sections.3.items.0.title | 상담 | 여러 상담원이 연락하는 조직 | Organizations with multiple consultation agents | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.sections.3.items.0.text | DB | DB 배분과 연락 상태, 수신 거부 반영을 일관되게 관리해야 하는 경우. | You need consistent lead allocation, contact status tracking and opt-out handling. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.sections.3.items.1.title | DB | 외부 파트너와 DB를 주고받는 사업 | Businesses exchanging leads with external partners | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.faq.0.question | 상담 | 상담 동의만 받으면 언제든 전화할 수 있나요? | Can we call at any time once someone consents to a consultation? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.faq.1.question | DB | 기존에 보유한 DB도 바로 사용할 수 있나요? | Can we immediately use leads we already hold? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.cta.text | DB | 현재 랜딩과 DB 전달·콜 운영 방식을 알려주시면 끊긴 지점을 함께 확인합니다. | Tell us how your landing page, lead delivery and call operations work. We will identify gaps in the process together. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.cta.label | 상담 | 퍼미션 구조 상담 | Discuss your consent process | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.lead | 지면·소재 | 네이버 GFA는 네이버 서비스의 다양한 디스플레이 지면에서 오디언스에게 도달하는 광고입니다. 제이커브는 캠페인 목적, 전환 측정, 타게팅과 소재 가설을 먼저 정하고 데이터를 보며 예산과 크리에이티브를 조정합니다. | NAVER GFA — NAVER's display ad platform — reaches audiences across display placements on NAVER services. We first define campaign goals, conversion measurement, targeting and creative hypotheses, then use the data to adjust budgets and creative. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.meta_description | 소재 | 캠페인 목표, 전환 측정, 오디언스, 소재 테스트와 운영 리포트를 연결하는 네이버 GFA 광고 대행 서비스입니다. | Our managed NAVER GFA service connects campaign goals, conversion measurement, audiences, creative testing and reporting. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.body.0 | 소재 | 네이버 GFA 캠페인의 목표, 측정, 오디언스와 소재 테스트를 한 흐름으로 운영합니다. | We manage NAVER GFA goals, measurement, audiences and creative testing as one process. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.sections.0.paragraphs.0 | 소재 | 캠페인 목적과 전환 이벤트가 맞지 않으면 광고 시스템이 잘못된 행동을 학습합니다. 타게팅을 좁히기만 하거나 소재 한두 개를 오래 유지해도 원인을 분리하기 어렵습니다. | When campaign goals and conversion events do not align, the ad system learns the wrong actions. Narrowing targeting alone or keeping the same few creatives for too long also makes causes hard to isolate. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.sections.1.title | 소재 | 목표에서 소재 개선까지 반복 가능한 구조로 | A repeatable process from goal-setting to creative improvement | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.sections.1.items.0.text | 상담 | 매출, 상담, 가입 등 비즈니스에 의미 있는 행동과 측정 지점을 정합니다. | We identify meaningful business actions, such as purchases, consultations or sign-ups, and where to measure them. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.sections.1.items.2.title | 소재 | 오디언스·소재 테스트 | Test audiences and creative | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.sections.2.items.2 | 소재 | 오디언스별 소재 가설과 테스트 이력 | Creative hypotheses and test histories for each audience | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.sections.3.items.0.text | 상담 | 노출보다 상담·가입·구매 등 행동을 기준으로 운영하려는 경우. | You want to optimize for consultations, sign-ups or purchases rather than impressions alone. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.sections.3.items.1.title | 소재 | 소재 테스트가 필요한 팀 | Teams that need creative testing | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.faq.2.question | 소재 | 소재 제작도 포함되나요? | Is creative production included? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.faq.2.answer | 소재 | 필요한 소재 형식과 수량, 촬영·디자인 범위를 확인한 뒤 운영 범위에 포함할지 협의합니다. 기존 자산을 재가공하는 방식도 가능합니다. | We review the formats, quantities, filming and design needed, then agree on whether to include production in the scope. We can also adapt existing assets. | 소재 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.cta.text | 소재 | 목표, 예산과 계정 현황을 알려주시면 측정·캠페인·소재 관점에서 진단합니다. | Share your goals, budget and account status. We will review measurement, campaigns and creative together. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.lead | 소재 | 메타 광고는 타게팅 설정만으로 끝나지 않습니다. 전환 이벤트와 퍼널, 고객에게 말을 거는 소재, 랜딩 경험을 함께 설계하고 학습 데이터를 잃지 않도록 테스트 단위를 관리해야 합니다. | Meta advertising requires more than targeting settings. We design conversion events, funnels, relevant creative and landing experiences together, and control test scope to preserve useful learning data. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.meta_description | 소재 | 메타 광고의 전환 측정, 퍼널, 오디언스, 소재 테스트와 예산 운영을 연결하는 페이스북·인스타그램 광고 대행입니다. | Our managed Facebook &amp; Instagram service connects conversion measurement, funnels, audiences, creative testing and budget management. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.sections.0.paragraphs.0 | 소재 | 광고 세트를 자주 복제하고 목표와 이벤트를 계속 바꾸면 데이터가 흩어집니다. 반대로 같은 소재를 오래 두면 피로도와 메시지 문제를 구분하기 어렵습니다. | Frequently duplicating ad sets or changing objectives and events fragments data. Keeping the same creative too long makes it hard to distinguish creative fatigue from messaging problems. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.sections.1.title | 소재 | 측정과 소재를 같은 주기로 움직입니다 | Keep measurement and creative on the same review cycle | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.sections.1.items.0.text | 상담 | 인지부터 구매·상담까지 단계별 행동과 최종 KPI를 정합니다. | We set stage-specific actions from awareness to purchases or consultations, alongside the final KPIs. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.sections.1.items.2.title | 소재 | 소재 가설 제작 | Build creative hypotheses | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.sections.1.items.2.text | 소재 | 고객의 문제, 증거, 제안과 형식을 나눠 테스트 가능한 소재를 준비합니다. | We separate customer problems, evidence, offers and formats to prepare testable creative. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.sections.1.items.3.text | 소재 | 전환 품질을 보고 예산과 소재를 조정하며 랜딩 병목도 함께 다룹니다. | We use conversion quality to adjust budgets and creative while addressing landing page bottlenecks. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.sections.2.items.2 | 소재 | 소재별 가설, 변경 이력과 학습 내용 | Hypotheses, change histories and learnings for each creative | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.sections.3.items.0.title | 소재 | 소재 회전이 필요한 브랜드 | Brands that need regular creative updates | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.sections.3.items.3.text | 소재 | 메타 광고는 소재와 데이터 학습을 지속 관리해야 하므로 맞지 않을 수 있습니다. | Meta advertising needs ongoing creative and learning management, so this may not be a suitable fit. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.cta.title | 소재 | 소재를 더 만들기 전에, 계정이 무엇을 배우는지 보세요 | Check what your account is learning before making more creative | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.hero_cta | 상담 | 유튜브 전략 상담 | Discuss a YouTube strategy | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.faq.0.answer | 소재 | 가능하지만 광고 목적과 초반 메시지, 화면 비율과 다음 행동이 맞는지 먼저 확인합니다. 필요한 경우 기존 영상을 재편집하거나 새 소재 범위를 협의합니다. | Yes, but we first check the ad objective, opening message, aspect ratio and next action. We can discuss re-editing existing videos or producing new creative where needed. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.cta.label | 상담 | 유튜브 전략 상담 | Discuss a YouTube strategy | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.basic.hero_cta | 상담 | 베이직 적합성 상담 | Discuss whether Basic fits your site | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.basic.cta.label | 상담 | 베이직 적합성 상담 | Discuss whether Basic fits your site | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.pro.hero_cta | 상담 | 프로 적합성 상담 | Discuss whether Pro fits your site | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.pro.cta.label | 상담 | 프로 적합성 상담 | Discuss whether Pro fits your site | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.hero_cta | 상담 | 엘리트 운영 상담 | Discuss Elite campaign management | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.sections.1.title | 운영 체계 | 전사 진단에서 반복 운영 체계까지 | From a business-wide review to a repeatable workflow | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.sections.3.items.3.text | 운영 체계 | 엘리트는 장기 운영 체계에 초점을 두므로 단발성 요청에는 과할 수 있습니다. | Elite focuses on a long-term operating process and may be too extensive for a one-off request. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.cta.title | 운영 체계 | 고경쟁 SEO를 개인의 감이 아닌 운영 체계로 바꾸세요 | Manage competitive SEO through a process rather than individual instinct | 운영 체계 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.cta.label | 상담 | 엘리트 운영 상담 | Discuss Elite campaign management | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.hero_cta | 상담 | 발견 전략 상담 | Discuss a discovery strategy | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.0.title | 지면 | 인기게시물은 외부에서 소유하거나 고정할 수 있는 광고 지면이 아닙니다 | Top posts are not ad placements an outside provider can own or fix | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.faq.2.question | 상담 | 어떤 발견 전략을 상담할 수 있나요? | What discovery strategies can we discuss? | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.cta.label | 상담 | 발견 전략 상담 | Discuss a discovery strategy | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.hero_cta | 상담 | 계정 성장 상담 | Discuss account growth | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.faq.1.question | 상담 | 어떤 성장 방법을 상담할 수 있나요? | What growth methods can we discuss? | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.cta.label | 상담 | 계정 성장 상담 | Discuss account growth | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.hero_cta | 상담 | 콘텐츠 반응 상담 | Discuss content engagement | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.faq.1.question | 상담 | 어떤 참여 확대 방법을 상담할 수 있나요? | What engagement methods can we discuss? | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.cta.label | 상담 | 콘텐츠 반응 상담 | Discuss content engagement | 상담의 문맥상 동의어/참조, consultation 리터럴 없음 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | cta_text | 상담 | 궁금한 점은 문의로 남겨 주세요. 프로젝트 상담은 1:1 문의가 가장 빠릅니다. | Send us your question. For a project consultation, a direct 1:1 inquiry is the fastest way to reach us. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.start.label | 상담 | 시작·상담 | Getting started &amp; consultations | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.start.items.8.q | 상담 | 상담 전에 어떤 자료가 필요한가요? | What information should we prepare before a consultation? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.start.items.10.a | 인정 | 첫 문의에는 비밀번호, API 키, 고객 개인정보를 보내지 마세요. 검토에 필요한 경우에도 접근 방식과 제공 범위를 먼저 합의합니다. | Do not send passwords, API keys or customers’ personal information in your first inquiry. Even when access is needed for a review, we first agree on the access method and the scope of information to provide. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.2.q | 소재 | 광고 소재도 함께 제작하나요? | Do you also produce ad creative? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.2.a | 소재 | 촬영·편집·디자인을 사내에서 연결할 수 있습니다. 필요한 소재의 형식과 수량, 촬영 여부는 캠페인 목표와 계약 범위에 맞춰 확정합니다. | We can coordinate filming, editing and design in-house. We confirm creative formats, quantities and whether filming is needed against the campaign goals and contract scope. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.4.a | 소재 | 노출과 클릭뿐 아니라 합의한 비즈니스 전환, 비용, 매체·캠페인·소재별 차이와 다음 실행 항목을 중심으로 정리합니다. 구체적인 항목과 주기는 운영 범위에 따라 확정합니다. | We focus on agreed business conversions, costs, differences by publisher, campaign and creative, and next actions, as well as impressions and clicks. The specific reporting items and frequency depend on the management scope. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.7.q | DB | 유효하지 않은 DB나 전환은 어떻게 처리하나요? | How do you handle invalid leads or conversions? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.7.a | 반려 | 중복, 필수 항목 오류, 연락 가능 여부, 동의 범위 등 캠페인 전에 합의한 승인·반려 기준으로 판단합니다. 업종과 액션에 따라 기준은 달라질 수 있습니다. | We assess them against acceptance and rejection criteria agreed before the campaign, including duplicates, errors in required fields, whether the person can be contacted and the scope of consent. Criteria may vary by industry and action. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.9.q | 인정 | 개인정보 동의와 광고 심사도 검토하나요? | Do you also review personal information consent and ad approval requirements? | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.10.a | 상담 | 앱 설치, 첫 실행, 회원가입, 튜토리얼 완료, 특정 미션 도달, 견적·상담 신청, 구매 등 확인 가능한 행동을 기준으로 설계할 수 있습니다. 실제 가능 여부와 단가는 업종, 난이도, 검수 방식에 따라 달라집니다. | Campaigns can be designed around verifiable actions such as app installation, first launch, registration, tutorial completion, reaching a specific mission, requesting a quote or consultation, and purchasing. Feasibility and pricing depend on the industry, difficulty and validation method. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.13.a | 지면 | 연동 방식은 앱 구조와 운영 범위에 따라 달라집니다. 기존 지면, 웹뷰, 서버 연동 가능 여부와 보상 처리 구조를 확인한 뒤 개발 범위와 테스트 절차를 합의합니다. | The integration method depends on the app structure and operating scope. We check existing ad placements, WebView and server integration options, and how rewards are processed before agreeing on the development scope and test procedure. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.16.a | 소재·상담 | 목표 액션, 희망 일정과 예산 범위, 랜딩 또는 앱 링크, 전환 확인 방식, 제한 조건, 소재와 브랜드 가이드를 준비하면 됩니다. 준비되지 않은 항목은 상담에서 체크리스트로 정리합니다. | Prepare your target action, preferred schedule and budget range, landing page or app link, conversion verification method, restrictions, creative and brand guidelines. We will turn any missing items into a checklist during the consultation. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.17.a | 지면 | 서비스와 이용자 특성, 월간 활성 이용 규모, 희망 지면, 리워드 정책, 개발 환경, 운영·CS·정산 담당 체계를 확인합니다. 그 결과를 바탕으로 연동 가능 범위와 순서를 정합니다. | We review the service and its users, monthly active user volume, desired ad placements, reward policy, development environment and who handles operations, customer support and settlement. We then define the feasible integration scope and sequence. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.13.a | 상담 | 현재 사이트나 계정, 목표, 예산 범위와 가장 답답한 지점을 알려주세요. 상품 구매가 맞는지, 먼저 진단이나 대행 상담이 필요한지부터 나눠볼 수 있습니다. | Tell us about your current site or account, goals, budget range and biggest bottleneck. We can first determine whether a product purchase fits your needs or whether an audit or managed-service consultation should come first. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.0.a | DB·상담 | 보험DB를 비교·구매하고 조직 내 담당자에게 배분해 상담·계약·AS·정산 상태를 관리하는 영업조직, 설계사와 대리점을 위한 CRM입니다. | It is a CRM for sales organizations, insurance agents and agencies that compare and purchase insurance leads, assign them to team members, and manage consultation, contract, after-sales support and settlement status. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.1.a | DB·상담 | 그렇게 보장되지 않습니다. 점수는 서비스 내 비교 정보이며 실제 상담 연결과 계약은 DB의 적법성·시점·대상, 담당자의 상담과 시장 상황 등 여러 요인의 영향을 받습니다. | That is not guaranteed. Scores provide comparisons within the service. Actual consultation contact and contracts depend on many factors, including the legality, timing and target audience of the leads, the agent’s consultation and market conditions. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.2.q | DB | 입점 업체라는 이유만으로 DB의 적법성이 보장되나요? | Does a listed supplier automatically guarantee that its leads are lawful? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.3.q | 인정 | 리드베이가 개인정보 준법 책임을 대신하나요? | Does LeadBay take over our responsibility for personal information compliance? | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.4.q | DB·상담 | DB를 구매하면 상담이나 계약이 보장되나요? | Does buying leads guarantee consultations or contracts? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.4.a | 상담 | 보장되지 않습니다. 연락 가능 여부, 상담 의향, 정보의 시의성, 배분과 상담 품질에 따라 결과가 달라질 수 있습니다. | No. Results may vary with contactability, willingness to consult, timeliness of the information, lead assignment and consultation quality. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.6.a | 인정 | 이 페이지는 소개용입니다. 실제 화면, 가격, 권한, 거래·정산 기능, 약관과 개인정보 처리 안내는 리드베이의 최신 서비스가 우선합니다. | This page is an introduction. LeadBay’s current service takes precedence for actual screens, prices, permissions, transaction and settlement features, terms, and personal information handling notices. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.7.a | DB·상담 | 원천 DB를 상담원에게 배분해 보험DB를 생산하고 고객사에 수주·납품·AS·정산하는 콜센터 운영조직을 위한 CRM입니다. | It is a CRM for call center operations that assign source leads to agents to generate insurance leads, then handle client orders, delivery, after-sales support and settlement. | 상담원=agent/operator, 상담 용어 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.8.q | 상담 | AI 콜 품질 분석이 상담을 정확히 평가하나요? | Does AI call quality analysis accurately assess consultations? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.8.a | 상담 | 정확성을 보장하지 않습니다. 분석은 패턴과 검토 지점을 찾는 보조 정보이며 관리자 또는 검수자가 통화 원자료와 상담 맥락을 함께 확인해야 합니다. | Accuracy is not guaranteed. The analysis supports the identification of patterns and points to review. A manager or reviewer must also check the original call data and consultation context. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.11.q | DB | 콜투세일이 DB의 적법성을 보장하나요? | Does Call2Sale guarantee that leads are lawful? | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.11.a | DB | 보장하지 않습니다. 원천 DB의 수집·제공·마케팅 이용 근거와 고객사 납품 조건은 운영·거래 당사자가 직접 확인해야 합니다. | No. The parties operating the service and conducting transactions must check the basis for collecting, providing and using source leads for marketing, as well as the conditions for delivery to clients. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.5.a | 상담 | 지원사업의 모집 여부와 자격은 시기와 기관별 공고에 따라 달라집니다. 상담 시 기업 정보와 공고문을 기준으로 마케팅 과업의 적합성을 검토하며, 최신 모집 상태와 신청 자격은 운영기관의 공식 안내를 우선 확인해야 합니다. | Application availability and eligibility vary by timing and each institution’s announcements. During a consultation, we review whether the marketing tasks fit your company information and the program notice. Check the administering institution’s official guidance first for current application status and eligibility. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.8.a | 인정 | 아닙니다. 인정되는 비용, 자부담, 집행 기간, 공급기업 요건과 증빙 방식은 사업마다 다릅니다. 계약이나 집행 전에 운영기관의 공고·협약·지침을 확인해야 합니다. | No. Eligible costs, the company’s own contribution, spending periods, supplier requirements and evidence requirements differ by program. Check the administering institution’s notice, agreement and guidelines before contracting or spending. | 인정=지원사업 비용 허용, 리드 유효인정 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.9.a | 인정 | 공고상 인정 범위와 기업의 과업 목표에 따라 퍼포먼스 광고, SEO, 콘텐츠, 영상, 웹 제작 등을 검토할 수 있습니다. 모든 사업에서 모든 항목이 인정되는 것은 아닙니다. | We can consider performance ads, SEO, content, video and web builds according to the scope permitted by the notice and the company’s task goals. Not every item is eligible under every program. | 인정=지원사업 비용 허용, 리드 유효인정 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | title | 인정 | 개인정보처리방침 &#124; 제이커브인터렉티브 | Privacy policy &#124; J-Curve Interactive | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | heading | 인정 | 개인정보처리방침 | Privacy policy | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | introduction | 인정 | (주)제이커브인터렉티브(이하 "회사")는 이용자의 개인정보를 중요하게 생각하며, 「개인정보 보호법」 등 관련 법령을 준수합니다. | J-Curve Interactive Co., Ltd. (the “Company”) values users’ personal information and complies with applicable laws and regulations, including Korea’s Personal Information Protection Act. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.0.0 | 인정 | 1. 수집하는 개인정보 항목 | 1. Categories of personal information collected | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.0.1 | 상담 | 회사는 상담 문의 및 서비스 제공을 위해 이름, 연락처, 이메일, 회사명, 문의 내용을 수집할 수 있습니다. | The Company may collect names, contact details, email addresses, company names and inquiry details for consultation inquiries and the provision of services. | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.1.0 | 인정 | 2. 개인정보의 수집 및 이용 목적 | 2. Purposes of collecting and using personal information | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.1.1 | 상담·인정 | 수집한 개인정보는 상담 응대, 서비스 제공, 계약의 이행 및 고객 관리를 위해 이용됩니다. | The personal information collected is used to respond to consultations, provide services, perform contracts and manage customer relationships. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.2.0 | 인정 | 3. 개인정보의 보유 및 이용 기간 | 3. Retention and use periods for personal information | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.2.1 | 인정 | 원칙적으로 개인정보 수집·이용 목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 관련 법령에 따라 보존할 필요가 있는 경우 해당 기간 동안 보관합니다. | In principle, the personal information concerned is destroyed without delay after the purposes of collection and use have been achieved. However, where retention is necessary under applicable laws and regulations, the information is retained for the applicable period. | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.3.0 | 인정 | 4. 개인정보 보호책임자 | 4. Personal information protection officer | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.3.1 | 인정 | 개인정보 관련 문의는 대표 이메일(jcurve19@gmail.com) 또는 대표전화(02-1668-2612)로 연락 주시기 바랍니다. | For inquiries concerning personal information, please contact the Company’s main email address (jcurve19@gmail.com) or main telephone number (02-1668-2612). | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.backlinks.meta_description | 상위노출 | 10년간 1,000여 개의 SEO 프로젝트를 성공적으로 수행하며 얻은 검색엔진최적화에 대한 깊은 이해와 경험을 바탕으로 제공하는 전문 백링크 서비스로 검색엔진 상위노출을 경험하세요. 구글과 네이버에 최적화된 검증된 고품질 백링크 전략은 자연스러운 순위 상승을 돕습니다. 무료 컨설팅을 신청하세요. | 10年間にわたり約1,000件のSEOプロジェクトを成功に導いた経験と、検索エンジン最適化への深い理解を生かした専門の被リンクサービスです。GoogleとNAVER（韓国最大の検索ポータル）に適した、検証済みの高品質な被リンク戦略で自然な順位改善を支援します。上位表示を目指す方は無料相談をご利用ください。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.backlinks.sections.2.title | 상담 | 상담과 진행 과정에서 확인하는 항목 | ご相談から実施までに確認する項目 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-place.seo_title | 상위노출 | 네이버 플레이스 상위노출 마케팅, 전문가의 노출 최적화로 매출 상승 | NAVERプレイスの上位表示マーケティング &#124; 専門家による表示最適化で売上向上へ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-place.meta_description | 상위노출 | 네이버 플레이스 상위노출 마케팅 성공은 제이커브와 함께! 풍부한 SEO 노하우로 순위 상승, 방문자 증가, 매출 상승을 실현하는 최적의 전략을 제공합니다. | NAVERプレイスの上位表示マーケティングはJ-Curveへ。豊富なSEOの知見を生かし、順位改善、来訪者の増加、売上向上につなげるための最適な戦略を提案します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-place.faq.2.question | 상담 | 상담 전에 무엇을 준비하면 되나요? | 相談前に何を準備すればよいですか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-shopping.seo_title | 상위노출 | 네이버쇼핑 상위노출 마케팅 전문가의 노하우로 매출 UP | NAVERショッピングの上位表示マーケティング &#124; 専門家の知見で売上向上へ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-shopping.meta_description | 상위노출 | 네이버쇼핑 상위노출 마케팅을 위한 SEO는 제이커브에게 맡기세요! 10년 이상 풍부한 노하우로 상품 노출 극대화, 클릭률 향상, 매출 증대를 실현시켜 드립니다. | NAVERショッピングの上位表示に向けたSEOはJ-Curveにお任せください。10年以上の豊富な知見を生かし、商品の表示機会の最大化、クリック率と売上の向上を支援します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-shopping.sections.3.items.0.text | 운영 체계 | 상품군별 정보 기준이 달라져 운영 체계를 다시 잡아야 하는 경우. | 商品群ごとの情報基準にばらつきがあり、運用体制を見直したいストアに適しています。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.kakao-gift.seo_title | 상위노출 | 카카오선물하기 상위노출로 비즈니스 성장을 경험하세요 - SEO 전문 컨설팅 기업 &#124; 제이커브인터렉티브 | カカオギフトの上位表示で事業成長へ &#124; SEO専門コンサルティング企業 J-Curve Interactive | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.kakao-gift.meta_description | 상위노출 | 카카오선물하기 상위노출 마케팅 — 선물 대상·상황·가격대별 탐색 의도와 상품 정보, 이미지, 상세 설명을 함께 정비하는 제이커브 SEO 서비스입니다. 무료 컨설팅을 신청하세요. | カカオギフトの上位表示マーケティング。贈る相手・場面・価格帯ごとの検索意図と、商品情報・画像・詳細説明を合わせて整えるJ-CurveのSEOサービスです。無料相談をご利用ください。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.kakao-gift.sections.3.items.3.text | 운영 체계 | 재고·배송·CS 기준이 불명확하다면 노출보다 운영 체계를 먼저 정해야 합니다. | 在庫・配送・顧客対応の基準が不明確な場合は、露出を増やす前に運用体制を決める必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.kakao-gift.faq.1.answer | 상담 | 가능 여부는 상품과 운영 상태에 따라 다르지만, 검수·콘텐츠·재고 준비를 고려하면 여유 있게 시작하는 편이 좋습니다. 상담 시 목표 시즌을 먼저 알려주세요. | 商品と運用状況によりますが、確認・コンテンツ制作・在庫準備を考えると、余裕を持って始めることをおすすめします。ご相談の際は目標のシーズンを先にお知らせください。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.coupang.seo_title | 상위노출 | 쿠팡 상위노출로 매출 상승의 기회를 잡으세요 - SEO 전문 컨설팅 기업 &#124; 제이커브인터렉티브 | Coupangの上位表示で売上向上の機会を &#124; SEO専門コンサルティング企業 J-Curve Interactive | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.coupang.meta_description | 상위노출 | 쿠팡 상위노출 마케팅 — 카테고리·옵션·상품명·이미지·배송 정보와 상세페이지를 함께 점검하는 제이커브 쿠팡 상품 검색 최적화 서비스입니다. 무료 컨설팅을 신청하세요. | Coupangの上位表示マーケティング。カテゴリ・オプション・商品名・画像・配送情報・商品詳細ページを合わせて確認する、J-CurveのCoupang商品検索最適化サービスです。無料相談をご利用ください。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.coupang.sections.0.title | 지면 | 상품 데이터가 흩어지면 고객도 알고리즘도 이해하기 어렵습니다 | 商品データがばらつくと、お客様にもアルゴリズムにも伝わりません | 지면=흩어지면의 일부, 광고 지면 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.title | 상담 | 부동산 분양 광고 — 상담 가능한 관심고객을 정의하는 일 | 不動産分譲（新築販売）広告 — 相談につながる見込み客を定義します | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.lead | DB·상담 | 부동산 분양 CPA는 상담 신청이 들어왔다는 사실만 세는 광고가 아닙니다. 사업지와 공급 조건을 정확히 설명하고, 고객의 연락 동의와 유효 DB 기준, 상담 후 피드백까지 연결해야 품질을 관리할 수 있습니다. | 不動産分譲のCPAは、相談申込数だけを数える広告ではありません。開発物件と販売条件を正確に伝え、連絡への同意、有効リードの基準、相談後のフィードバックをつなぐことで品質を管理します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.meta_description | 상담·인정 | 사업지 정보, 상담 신청 기준, 개인정보 동의, 트래킹과 상담 피드백을 함께 설계하는 부동산 분양 CPA 마케팅입니다. | 物件情報、相談申込の基準、個人情報に関する同意、トラッキング、相談結果のフィードバックを合わせて設計する、不動産分譲のCPAマーケティングです。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.hero_cta | 상담 | 분양 CPA 구조 상담 | 分譲CPAの仕組みを相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.body.0 | 상담 | 사업지와 고객 조건에 맞춰 상담 신청의 정의와 운영 기준을 먼저 합의하는 부동산 분양 CPA 서비스입니다. | 物件と顧客条件に合わせ、相談申込の定義と運用基準を先に合意する、不動産分譲のCPAサービスです。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.body.1 | 상담 | 상담 신청은 실제 방문이나 계약을 의미하지 않으며 계약 성과를 보장하지 않습니다. | 相談申込は実際の来場や契約を意味せず、契約成果は保証しません。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.0.title | DB·상담 | DB가 많아도 상담 기준이 다르면 성과를 판단할 수 없습니다 | リードが多くても、相談の基準が違えば成果を判断できません | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.0.paragraphs.1 | 상담 | 캠페인 시작 전에 사업지의 사실 정보, 목표 고객, 유효·무효 기준과 상담 대응 시간을 합의해야 광고 데이터를 영업 결과와 연결할 수 있습니다. | 開始前に物件の事実情報、目標顧客、有効・無効の基準、相談への対応時間を合意することで、広告データと営業結果を結び付けられます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.1.items.1.title | DB | 유효 DB 기준 합의 | 有効リードの基準を合意 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.1.items.3.title | 상담 | 상담 결과 피드백 | 相談結果をフィードバック | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.1.items.3.text | 소재·상담 | 유입 이후 상담 상태를 분류해 매체·소재·타게팅 개선에 반영합니다. | 獲得後の相談状況を分類し、媒体・クリエイティブ・ターゲティングの改善に反映します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.2.items.1 | 상담 | 목표 지역·고객 조건과 필수 상담 신청 항목 | 対象地域・顧客条件と相談申込の必須項目 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.2.items.2 | 상담·인정 | 개인정보 수집·이용 및 상담 연락 동의 문구 | 個人情報の収集・利用と相談連絡への同意文 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.2.note | 상담 | 관련 법령과 매체 심사 기준을 확인해야 하며, 상담 신청·방문·분양 계약을 보장하지 않습니다. | 関連法令と媒体の審査基準の確認が必要です。相談申込・来場・分譲契約は保証しません。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.3.items.0.title | 상담 | 상담 대응 체계가 있는 현장 | 相談への対応体制がある現場 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.3.items.0.text | 상담 | 유입 후 빠르게 연락하고 상담 상태를 기록할 담당자가 있는 경우. | 獲得後にすばやく連絡し、相談状況を記録する担当者がいる現場に適しています。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.3.items.2.text | DB·상담 | DB 수량뿐 아니라 상담 결과를 캠페인 개선에 활용하려는 경우. | リード数だけでなく、相談結果もキャンペーン改善に活用したいチームに適しています。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.3.items.3.text | 상담 | CPA는 상담 기회를 만드는 구조이며 계약 결과를 대신 확정할 수 없습니다. | CPAは相談の機会をつくる仕組みであり、契約結果を確約することはできません。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.faq.0.question | DB | 수집된 DB는 모두 실제 계약 가능 고객인가요? | 獲得したリードは、全員が実際に契約できるお客様ですか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.faq.0.answer | DB·상담 | 아닙니다. DB는 정해진 정보를 입력하고 상담 연락에 동의한 신청입니다. 방문이나 계약 여부는 상품 조건, 상담 품질과 고객 판단에 따라 달라집니다. | いいえ。リードは、所定の情報を入力し、相談の連絡に同意した申込者です。来場や契約の有無は、商品条件、相談対応の品質、お客様の判断によって変わります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.faq.1.question | DB | 유효 DB 기준은 누가 정하나요? | 有効リードの基準は誰が決めますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.faq.2.question | 인정 | 개인정보 동의도 함께 설계하나요? | 個人情報に関する同意も一緒に設計しますか？ | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.cta.title | DB | 사업지 정보와 유효 DB 기준부터 맞춰보세요 | 物件情報と有効リードの基準を合わせましょう | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.cta.text | 상담 | 목표 지역, 상담 조직과 현재 광고 구조를 알려주시면 실행 가능 범위를 구체적으로 검토합니다. | 対象地域、相談対応の組織、現在の広告の仕組みを教えていただければ、実行可能な範囲を具体的に検討します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.cta.label | 상담 | 분양 CPA 구조 상담 | 分譲CPAの仕組みを相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.title | DB | 주식 DB 마케팅 — 동의와 광고 적합성을 먼저 설계합니다 | 株式投資リードのマーケティング — 同意取得と広告の適合性から設計します | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.lead | 상담 | 주식 관련 CPA는 투자 관심고객의 상담 신청을 측정하는 캠페인입니다. 수익 기대를 자극하는 과장 표현 대신 서비스의 실제 범위와 위험 정보를 명확히 설명하고, 연락 동의와 유효성 기준을 기록해야 합니다. | 株式関連のCPAは、投資に関心のある方の相談申込を測定するキャンペーンです。利益への期待をあおる誇張表現を避け、実際のサービス範囲とリスクを明確に伝え、連絡への同意と有効性の基準を記録する必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.meta_description | DB·상담 | 광고 표현 검토, 상담 동의, 유효 DB 기준과 트래킹을 함께 설계하는 주식·투자 관심고객 CPA 마케팅입니다. | 広告表現の確認、相談への同意、有効リードの基準、トラッキングを合わせて設計する、株式・投資に関心のある方に向けたCPAマーケティングです。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.hero_cta | 상담 | 주식 CPA 적합성 상담 | 株式CPAの適合性を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.body.0 | 상담 | 서비스 범위와 위험 정보를 사실대로 설명하고 상담 연락에 동의한 신청을 측정하는 CPA 서비스입니다. | サービス範囲とリスクを事実に即して説明し、相談の連絡に同意した申込を測定するCPAサービスです。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.body.1 | 상담 | 투자 수익, 원금, 가입 또는 상담 전환을 보장하지 않습니다. | 投資収益、元本、加入、相談への転換は保証しません。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.0.paragraphs.1 | 소재 | 제이커브는 광고 문구, 랜딩 설명, 연락 동의와 전환 정의를 하나의 흐름으로 검토합니다. 캠페인 가능 여부도 소재를 만들기 전에 판단합니다. | J-Curveは広告文、ランディングページの説明、連絡への同意、コンバージョンの定義を一連の流れとして確認します。クリエイティブ制作の前に、実施の可否も判断します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.1.title | 상담 | 적합성 확인부터 상담 피드백까지 | 適合性の確認から相談結果のフィードバックまで | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.1.items.1.title | 상담 | 상담 신청 기준 설계 | 相談申込の基準を設計 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.1.items.3.title | 상담 | 상담 결과 기반 개선 | 相談結果に基づいて改善 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.1.items.3.text | 소재·상담 | 연락·상담 상태를 분류해 소재와 타게팅 개선에 반영합니다. | 連絡・相談の状況を分類し、クリエイティブとターゲティングの改善に反映します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.2.items.2 | 상담·인정 | 개인정보 수집·상담 연락 동의 및 보유 기준 | 個人情報の収集・相談連絡への同意と保有基準 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.2.items.3 | DB·상담 | 유효 DB 정의, 상담 담당자와 결과 피드백 방식 | 有効リードの定義、相談担当者、結果のフィードバック方法 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.3.items.2.title | 상담 | 상담 결과를 기록하는 조직 | 相談結果を記録する組織 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.faq.0.answer | 상담 | 그럴 수 없습니다. CPA는 상담 관심과 신청을 측정할 뿐 투자 결과를 예측하거나 보장하지 않습니다. 수익을 암시하는 광고 표현도 별도 검토가 필요합니다. | できません。CPAが測定するのは相談への関心と申込であり、投資結果を予測・保証するものではありません。利益を示唆する広告表現も、別途確認が必要です。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.faq.2.question | 상담 | 상담 신청 정보는 어떻게 관리하나요? | 相談申込の情報はどう管理しますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.cta.label | 상담 | 주식 CPA 적합성 상담 | 株式CPAの適合性を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.eyebrow | DB | Insurance Permission DB | 同意取得済みの保険リード | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.lead | 상담 | 보험디비는 전화번호 한 건을 전달하는 상품이 아닙니다. 광고 유입, 퍼미션콜, 동의·녹취 확인, 중복 기준, 지역·조건 매칭, 미팅 조정, AS와 영업 피드백이 이어져야 실제 상담 기회가 됩니다. | 保険リードは、電話番号を一件渡すだけの商品ではありません。広告からの獲得、同意確認の電話、同意・録音の確認、重複基準、地域・条件のマッチング、面談調整、アフターサポート、営業からのフィードバックをつなぐことで、実際の相談機会になります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.meta_description | DB | 보험디비·보험 퍼미션DB의 차이, 수집·동의·녹취·중복·AS 기준, 맞춤 스크립트와 리드베이 CRM 연계까지 설명하는 제이커브 보험 CPA 안내입니다. | 保険リードと同意取得済み保険リードの違い、収集・同意・録音・重複・アフターサポートの基準、専用スクリプト、LeadBayとのCRM連携を説明する、J-Curveの保険CPAガイドです。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.hero_cta | DB·상담 | 보험 DB 운영 상담 | 保険リードの運用を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.inquiry_template | DB | [보험 CPA·퍼미션 DB 문의]<br><br>조직 형태 / 설계사 수: <br>희망 DB 유형: <br>희망 지역: <br>월 희망 물량: <br>현재 DB 구매·배분 방식: <br>필요 범위: 광고 유입 / DB 납품 / 리드베이 / 콜투세일<br>현재 유효·AS 기준: <br>시작 희망일:  | [保険CPA・同意取得済みリードのお問い合わせ]<br><br>組織形態 / 保険募集人数: <br>希望するリードの種類: <br>希望地域: <br>月間希望件数: <br>現在のリード購入・配分方法: <br>必要な範囲: 広告からの獲得 / リード納品 / LeadBay / Call2Sale<br>現在の有効認定・アフターサポート基準: <br>希望開始日:  | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.local_nav.1.label | DB | 퍼미션 DB | 同意取得済みリード | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.body.0 | 상담 | 상담 연락에 동의한 신청을 퍼미션콜·검수·배분·상담 피드백과 연결하는 보험 CPA 서비스입니다. | 相談の連絡に同意した申込を、同意確認の電話・検品・配分・相談結果のフィードバックにつなぐ保険CPAサービスです。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.title | DB | 광고 유입·DB 공급·영업관리를 한 구조로 봅니다 | 広告からの獲得・リード供給・営業管理を一つの仕組みとして捉えます | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.lead | DB | 기존 보험 랜딩의 강점이었던 퍼미션 DB 운영과 리드베이 기능을 현재 제이커브 서비스 구조에 맞춰 연결했습니다. | 従来の保険ランディングページの強みであった、同意取得済みリードの運用とLeadBayの機能を、現在のJ-Curveのサービス構成に合わせてつなぎました。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.items.0.text | 소재·DB·상담 | 광고 소재와 랜딩, 상담 신청, 연락 동의, 퍼미션콜과 유효 DB 기준을 설계합니다. | 広告クリエイティブ、ランディングページ、相談申込、連絡への同意、同意確認の電話、有効リードの基準を設計します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.items.1.text | DB·상담 | DB 업체·조건 비교부터 배분, 상담 일정, 계약, AS와 정산까지 영업조직의 활용 과정을 관리합니다. | リード供給会社・条件の比較から、配分、相談日程、契約、アフターサポート、精算まで、営業組織がリードを活用する過程を管理します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.items.2.text | DB·상담 | 보험DB 콜센터의 원천 DB, 상담원 배분, 콜 품질, 납품, AS와 정산 업무를 관리합니다. | 保険リードを扱うコールセンターの元リード、オペレーターへの配分、通話品質、納品、アフターサポート、精算を管理します。 | 상담원=agent/operator, 상담 용어 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.items.3.title | 상담 | 상담 결과의 광고 환류 | 相談結果を広告改善へ反映 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.items.3.text | 상담 | 연락·미팅·상담·계약 상태를 같은 기준으로 기록해 어떤 유입과 스크립트를 개선할지 판단합니다. | 連絡・面談・相談・契約の状態を同じ基準で記録し、どの獲得経路やスクリプトを改善するか判断します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.note | DB·인정 | 실제 광고, DB 공급과 솔루션 연동 범위는 조직의 계약 구조, 시스템과 개인정보 처리 역할을 확인한 뒤 확정합니다. | 広告、リード供給、ソリューション連携の実際の範囲は、組織の契約形態、システム、個人情報の取り扱い上の役割を確認して決めます。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.1.items.1.text | DB | 2026년 기준 · 제이커브 회사 전체 누적 수집 DB | 2026年時点・J-Curveの会社全体の累計リード獲得数 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.2.title | DB | 보험DB 문제는 대부분 수집 이후에 드러납니다 | 保険リードの問題の多くは、獲得後に明らかになります | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.2.items.2.text | 반려 | 광고주·공급사마다 중복의 기간과 식별 기준이 다르면 반려와 정산 분쟁이 반복됩니다. | 広告主・リード供給会社ごとに重複確認の期間や識別基準が違うと、差し戻しと精算をめぐる争いが繰り返されます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.2.items.3.title | 상담 | 상담 결과가 돌아오지 않는다 | 相談結果が共有されない | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.2.items.5.title | DB | DB와 영업관리가 분리된다 | リードと営業管理が分断される | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.2.items.5.text | 상담 | 구매·배분·상담·계약·AS·정산이 서로 다른 엑셀에 있으면 조직 성과를 같은 기준으로 보기 어렵습니다. | 購入・配分・相談・契約・アフターサポート・精算が別々のExcelにあると、組織の成果を同じ基準で把握しにくくなります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.3.title | DB | 퍼미션 DB는 체크박스가 아니라, 고객이 예상한 연락입니다 | 同意取得済みリードで大切なのは、チェック欄ではなく、お客様が想定した連絡です | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.3.paragraphs.1 | DB·상담 | 보험 퍼미션 DB에서는 광고·랜딩에서 받은 1차 신청을 그대로 넘기지 않고, 캠페인 구조에 따라 연락 주체와 상담 목적, 제3자 제공 또는 처리위탁 관계, 핵심 상담 의사를 다시 확인하는 과정이 붙을 수 있습니다. | 同意取得済み保険リードでは、広告・ランディングページで得た1次申込をそのまま渡すのではなく、キャンペーンの仕組みに応じて、連絡主体、相談目的、第3者提供や処理委託の関係、主な相談意向を再確認する場合があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.3.paragraphs.2 | 상담 | 다만 동의가 있다는 이유만으로 모든 전화, 무기한 보관, 자유로운 재제공이 허용되는 것은 아닙니다. 수집 항목·목적·제공받는 자·보유기간·철회 방법과 실제 상담 흐름이 맞아야 합니다. | ただし、同意があれば、あらゆる電話、無期限の保管、自由な再提供が許されるわけではありません。収集項目・目的・提供先・保有期間・撤回方法と、実際の相談の流れが一致する必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.3.note | 인정 | 이 페이지는 법률 자문이 아닙니다. 실제 캠페인은 적용 법령, 금융·보험 광고 기준, 개인정보 처리 역할과 광고주 내부 준법 기준을 별도로 확인해야 합니다. | このページは法律上の助言ではありません。実施時には、適用法令、金融・保険広告の基準、個人情報の取り扱い上の役割、広告主の社内コンプライアンス基準を別途確認する必要があります。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.4.eyebrow | DB | DB vs Permission DB | 通常リードと同意取得済みリードの比較 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.4.title | DB | 일반 신청 DB와 퍼미션 DB의 차이는 ‘전달 전 확인’입니다 | 通常の申込リードと同意取得済みリードの違いは、受け渡し前の確認です | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.4.columns.1 | DB | 일반 랜딩 신청 DB | 通常のランディングページ申込リード | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.4.columns.2 | DB | 퍼미션 확인을 거친 DB | 同意を確認したリード | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.4.rows.2.0 | 상담 | 상담 준비도 | 相談の準備状況 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.4.rows.2.2 | 상담 | 상담 의사·주제·지역·일정 등 합의한 조건을 재확인 | 相談意向・テーマ・地域・日程など、合意した条件を再確認 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.4.rows.3.1 | 상담 | 부재·오인·중복 원인을 상담원이 직접 분류 | 不在・誤認・重複の原因をオペレーターが直接分類 | 상담원=agent/operator, 상담 용어 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.5.items.0.text | 상담·리모델링 | 보험 리모델링, 보장 분석, 상담 등 실제 제공 범위를 과장 없이 설명하고 신청 목적을 맞춥니다. | 保険の見直し、保障分析、相談など、実際の提供範囲を誇張せずに説明し、申込目的を合わせます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.5.items.2.text | 상담 | 캠페인 조건에 따라 상담 주제, 연락 주체, 지역, 가능한 일정과 핵심 의사를 다시 확인합니다. | キャンペーン条件に応じて、相談テーマ、連絡主体、地域、対応可能な日程、主な意向を再確認します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.5.items.4.text | DB | 영업 지역, 조직, 기존 보유 DB와 중복 기준을 확인해 담당자를 배정하고 전달 시점을 기록합니다. | 営業地域、組織、既存保有リードとの重複基準を確認して担当者を割り当て、受け渡し時点を記録します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.5.items.5.title | 상담 | 미팅·상담 상태 관리 | 面談・相談の状態を管理 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.5.items.6.text | 소재·상담 | 사전 합의한 AS 증빙을 확인하고 상담 결과를 소재·타기팅·스크립트와 다음 물량 판단에 반영합니다. | 事前合意したアフターサポートの証拠を確認し、相談結果をクリエイティブ・ターゲティング・スクリプトと、次回の件数判断に反映します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.6.items.0.text | DB | 신청·확인·전달 시간을 기록하고, 오래된 DB와 신규 DB가 섞이지 않도록 캠페인별 납품 주기와 예상 물량을 합의합니다. | 申込・確認・受け渡しの時刻を記録します。古いリードと新規リードが混在しないよう、キャンペーンごとの納品周期と予定件数を合意します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.6.items.2.text | DB | 한 광고주 전용 여부, 중복 확인 기간, 식별값, 기존 보유 DB 대조와 재제공 금지 범위를 집행 전에 문서화합니다. | 広告主専用かどうか、重複確認期間、識別値、既存リードとの照合、再提供の禁止範囲を、開始前に文書化します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.6.items.3.text | 상담·리모델링 | 보험 리모델링 설명, 미팅 재확인, 지역·상담 유형과 영업 방식에 맞춰 확인 질문과 전달 정보를 조정합니다. | 保険の見直しの説明、面談の再確認、地域・相談種別・営業方法に合わせて、確認する質問と伝える情報を調整します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.7.items.0 | DB | 퍼미션 DB | 同意取得済みリード | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.7.items.1 | DB | 준실버 DB | 準シルバーリード | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.7.items.2 | DB | 실버 DB | シルバーリード | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.7.items.3 | DB | 확정 DB | 確定リード | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.7.items.4 | 리모델링 | 보험 리모델링 | 保険の見直し | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.7.note | DB·상담 | DB 유형 명칭만으로 품질을 판단하지 마세요. 각 유형의 필수 확인 항목, 상담 의사 수준, 증빙과 AS 범위를 계약서에서 정의해야 합니다. | リードの種別名だけで品質を判断しないでください。種別ごとの必須確認項目、相談意向の度合い、証拠、アフターサポートの範囲を契約書で定義する必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.8.rows.2.0 | 상담 | 상담 내용 불일치 | 相談内容の不一致 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.8.rows.2.2 | 상담 | 광고 약속과 실제 상담 의사가 달랐는지 검수 | 広告の説明と実際の相談意向が違っていたか確認 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.8.rows.4.2 | 인정 | AS 포함 여부와 인정 기간·증빙을 별도로 합의 | アフターサポートの対象かどうかと、有効認定の期間・証拠を別途合意 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.8.rows.5.1 | 상담 | 상담 상태와 거절 사유 | 相談状況と断られた理由 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.8.rows.5.2 | 상담 | 계약 결과는 기본 AS 사유가 아니며 광고·상담 개선 데이터로 분류 | 契約結果は原則としてアフターサポートの対象理由とせず、広告・相談の改善データに分類 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.8.note | 반려 | 주관적인 “질이 나쁘다”만으로 반려하지 않고, 양측이 같은 자료와 기한으로 판단할 수 있어야 합니다. | 主観的な「質が悪い」という理由だけで差し戻さず、双方が同じ資料と期限で判断できるようにします。 | 差し戻し 활용형, 정상 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.9.title | DB | 광고주 규모와 영업 방식에 따라 같은 DB도 다르게 운영합니다 | 広告主の規模と営業方法に応じて、同じリードでも運用を変えます | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.9.items.0.title | DB | 보험DB가 처음인 조직 | 保険リードを初めて使う組織 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.9.items.1.text | 상담 | 감당 가능한 물량과 지역을 좁히고 담당자별 배분 누락 없이 상담 피드백을 받는 구조를 우선합니다. | 対応できる件数と地域に絞り、担当者への配分漏れを防いで相談結果を受け取れる仕組みを優先します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.9.items.2.text | DB | 기존 보유 DB와의 중복 대조, 지점·팀별 배분, 물량 일정, 권한과 정산 기준을 먼저 맞춥니다. | 既存リードとの重複照合、支店・チーム別の配分、件数と日程、権限、精算基準を先に合わせます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.9.items.3.title | 상담·리모델링 | 리모델링 중심 상담 | 保険の見直しを中心とする相談 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.9.items.3.text | 상담 | 고객이 기대한 상담 범위와 미팅 목적을 정확히 설명하고 재확인할 스크립트를 설계합니다. | お客様が期待する相談範囲と面談目的を正確に説明し、再確認できるスクリプトを設計します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.10.title | DB | DB를 산 뒤의 일을 리드베이에서 이어서 관리합니다 | リード購入後の業務も、LeadBayで続けて管理します | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.10.items.0.title | DB | DB 구매 관리 | リード購入管理 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.10.items.1.text | DB | DB별 AS 가능 기간과 신청 상태, 승인·거절 결과와 필요한 증빙을 한 흐름에서 확인합니다. | リードごとの対象期間、申請状況、承認・却下の結果、必要な証拠を一連の流れで確認します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.10.items.2.title | 상담 | 상담 일정 관리 | 相談日程の管理 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.10.items.2.text | 상담 | 상담 일정, 메모, 연락과 진행 상태를 남겨 담당자와 후속 조치를 놓치지 않게 관리합니다. | 相談日程、メモ、連絡・進行状況を記録し、担当者と次の対応を見落とさないよう管理します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.10.items.3.text | DB·상담 | 보유 DB, 컨택, 미팅, 상담과 계약의 단계별 전환을 팀원·월·지점 기준으로 비교합니다. | 保有リード、接触、面談、相談、契約の段階別コンバージョンを、メンバー・月・支店ごとに比較します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.10.items.5.title | 상담 | 모바일 상담 앱 | モバイル相談アプリ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.10.items.5.text | 상담 | 외근 중 상담 이력과 녹취를 정리하고 AI 요약을 검토 보조자료로 활용합니다. 최종 판단은 담당자가 원자료와 함께 확인합니다. | 外出中の相談履歴や録音を整理し、AI要約を確認の補助資料として活用します。最終判断は担当者が原資料と合わせて確認します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.11.title | 상담 | 비교·구매·상담·AS·정산이 한 기록으로 이어집니다 | 比較・購入・相談・アフターサポート・精算が一つの記録につながります | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.11.items.0.title | DB | 콜센터 DB 마켓 | コールセンターのリードマーケット | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.11.items.0.text | DB | DB 유형, 품질·납품·AS 정보, 잔여 수량과 예상 완료일을 비교해 구매 판단의 근거를 남깁니다. | リードの種別、品質・納品・アフターサポート情報、残数、完了予定日を比較し、購入判断の根拠を残します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.11.items.1.title | DB | 내 DB 영업 관리 | 保有リードの営業管理 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.11.items.1.text | DB·상담 | 미접촉부터 재통화·미팅·상담·계약·AS까지 상태를 관리하고 일정·메모·녹취 이력을 DB 단위로 연결합니다. | 未接触から再架電・面談・相談・契約・アフターサポートまで状態を管理し、日程・メモ・録音履歴をリード単位で結び付けます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.11.items.2.text | 상담 | AS 가능일과 처리 상태를 추적하고 구매·상담·계약 이력을 분쟁 검토 자료로 활용합니다. | 対象期間と処理状況を追跡し、購入・相談・契約履歴を紛争時の検討資料として活用します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.12.title | DB | DB를 생산·납품하는 콜센터라면 콜투세일로 이어집니다 | リードを獲得・納品するコールセンターにはCall2Saleを | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.12.items.0.title | DB·상담 | 원천 DB와 상담원 배분 | 元リードとオペレーターへの配分 | 상담원=agent/operator, 상담 용어 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.12.items.0.text | DB·상담 | 수집된 원천 DB가 어느 상담원에게 배정되고 어떤 상태인지 공급 조직 안에서 관리합니다. | 収集した元リードの割当先と現在の状態を、供給組織の中で管理します。 | 상담원=agent/operator, 상담 용어 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.12.items.1.text | 상담 | 스크립트 준수와 상담 품질을 기록하고 AI 분석은 관리자의 검토를 돕는 보조자료로 활용합니다. | スクリプトの遵守状況と相談品質を記録し、AI分析は管理者の確認を助ける補助資料として活用します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.12.note | DB | 리드베이는 DB를 활용하는 구매·영업 조직, 콜투세일은 DB를 생산·납품하는 공급 조직의 흐름에 초점을 둡니다. | LeadBayはリードを活用する購入・営業組織、Call2Saleはリードを獲得・納品する供給組織の業務に重点を置いています。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.13.items.0.text | DB·상담 | 상담 주체, 설계사 수, 대응 지역, 상품 범위와 현재 DB 운영 문제를 확인합니다. | 相談主体、保険募集人数、対応地域、商品範囲、現在のリード運用の課題を確認します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.13.items.1.title | DB | DB 유형·유효·AS 합의 | リード種別・有効性・アフターサポートを合意 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.13.items.3.text | 반려 | 작은 지역·물량으로 연락률, 미팅 상태, 반려 사유와 담당자 입력 품질을 확인합니다. | 地域と件数を絞り、連絡率、面談状況、差し戻し理由、担当者の入力品質を確認します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.13.items.4.text | 상담 | 유입·스크립트·배분·상담 피드백이 안정된 범위만 단계적으로 확대합니다. | 獲得・スクリプト・配分・相談結果のフィードバックが安定した範囲だけを、段階的に拡大します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.14.title | DB | “동의받은 DB” 한 문장으로 끝내지 않습니다 | 「同意取得済みリード」という一言で終わらせません | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.14.items.0 | 인정 | 광고주·콜센터·플랫폼 가운데 실제 개인정보 수집·이용·제공·위탁 주체가 누구인지 구분 | 広告主・コールセンター・プラットフォームのうち、実際の個人情報の収集・利用・提供・委託主体を区別 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.14.items.1 | 상담 | 고객이 본 광고·랜딩 문구와 실제 연락 주체·목적·보험 상담 범위의 일치 확인 | お客様が見た広告・ランディングページの文言と、実際の連絡主体・目的・保険相談範囲の一致を確認 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.14.items.5 | DB | 기존 보유 DB 대조와 중복 판정에 쓰는 식별값·기간·접근 권한 최소화 | 既存リードの照合と重複判定に使う識別値・期間・アクセス権限を必要最小限に限定 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.14.items.6 | 상담 | 광고 표현, 보험 모집·상담 역할과 고객 오인 가능성을 광고주 준법 기준으로 검토 | 広告表現、保険募集・相談の役割、お客様の誤認の可能性を、広告主のコンプライアンス基準で検討 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.14.note | 인정 | 사용 허락이 콘텐츠 저작권 문제를 해결해도 개별 캠페인의 적법성을 자동 보장하지는 않습니다. 실제 공개·집행 전 개인정보·금융 광고 담당자의 현재 기준 확인이 필요합니다. | 使用許諾によってコンテンツの著作権の問題が解決しても、個々のキャンペーンの適法性が自動的に保証されるわけではありません。公開・配信前に、個人情報・金融広告の担当者による最新基準の確認が必要です。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.15.title | DB | 보험DB는 영업조직의 준비 수준만큼 작동합니다 | 保険リードの活用には、営業組織の準備が欠かせません | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.15.items.0.title | DB | 처음 보험DB를 도입하는 GA | 保険リードを初めて導入する保険代理店（GA） | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.15.items.1.text | 상담 | 지역·담당자 배분, 권한과 팀별 상담·계약 퍼널을 같은 기준으로 보고 싶은 조직. | 地域・担当者への配分、権限、チーム別の相談・契約ファネルを、同じ基準で確認したい組織に適しています。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.15.items.2.title | DB | 기존 DB 품질 분쟁이 잦은 광고주 | 既存リードの品質をめぐる争いが多い広告主 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.15.items.3.text | 소재·상담 | 상담 결과를 광고 소재·타기팅·랜딩·퍼미션콜 개선으로 다시 돌려보내려는 팀. | 相談結果を、広告クリエイティブ・ターゲティング・ランディングページ・同意確認の電話の改善へ反映したいチームに適しています。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.15.items.4.text | DB·상담 | 보험DB는 상담 기회를 만드는 입력값이며 미팅·계약·매출을 확정하지 않습니다. | 保険リードは相談機会をつくるための情報であり、面談・契約・売上を確定するものではありません。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.15.items.5.text | DB | 출처·연락 목적·제공 관계를 확인할 수 없다면 광고나 DB 전달보다 준법 구조를 먼저 정비해야 합니다. | 入手元・連絡目的・提供関係を確認できなければ、広告やリードの受け渡しより先にコンプライアンス体制を整える必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.0.question | DB | 보험DB는 정확히 무엇인가요? | 保険リードとは何ですか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.0.answer | DB·상담 | 이 페이지에서 보험DB는 보험 관련 상담 연락을 위해 수집·전달되는 신청 정보를 뜻합니다. 전화번호만이 아니라 신청 목적, 동의 기록, 유효 기준, 전달 시점과 상담 상태를 함께 관리해야 합니다. | このページでは、保険の相談連絡のために収集・提供される申込情報を指します。電話番号だけでなく、申込目的、同意記録、有効基準、受け渡し時点、相談状況も合わせて管理する必要があります。 | DB 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.1.question | DB | 일반 보험DB와 퍼미션DB는 무엇이 다른가요? | 通常の保険リードと同意取得済みリードは何が違いますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.1.answer | DB·상담 | 일반 신청 DB는 랜딩 입력을 중심으로 전달될 수 있지만, 퍼미션DB는 캠페인 조건에 따라 연락 주체·상담 목적·지역·일정과 고객 의사를 추가 확인하고 그 기록을 관리합니다. 구체적인 확인 항목은 계약마다 달라집니다. | 通常の申込リードは、ランディングページの入力情報を中心に提供される場合があります。同意取得済みリードは、キャンペーン条件に応じて連絡主体・相談目的・地域・日程・お客様の意向を追加確認し、記録を管理します。具体的な確認項目は契約によって異なります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.2.question | DB | 보험 DB 한 건이 곧 미팅이나 보험 계약을 의미하나요? | 保険リード一件は、面談や保険契約を意味しますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.2.answer | DB·상담 | 아닙니다. DB는 합의한 조건을 충족한 상담 기회입니다. 실제 미팅과 가입 여부는 고객의 필요, 상품 적합성, 전달 시점, 담당자의 상담 품질과 고객 판단에 따라 달라집니다. | いいえ。リードは合意した条件を満たす相談機会です。実際の面談と加入の有無は、お客様の必要性、商品の適合性、受け渡し時点、担当者の相談品質、お客様の判断によって変わります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.3.question | DB | 실시간으로 DB를 받을 수 있나요? | リアルタイムでリードを受け取れますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.5.answer | 인정 | 녹취 여부, 접근·제공 범위, 보관기간과 파기 방식은 캠페인·계약과 적용 기준에 따라 달라집니다. 개인정보가 포함되므로 필요성과 권한을 확인한 최소 범위로 운영합니다. | 録音の有無、アクセス・提供範囲、保管期間、廃棄方法は、キャンペーン・契約・適用基準によって異なります。個人情報を含むため、必要性と権限を確認した最小限の範囲で運用します。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.6.question | DB | 한 번 받은 DB는 다른 곳에 절대 중복 납품되지 않나요? | 受け取ったリードが、ほかにも重複して納品されることはありませんか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.7.answer | 인정 | 자동으로 인정되지 않습니다. AS 가능 사유, 연락 횟수·시간대, 신청 기한, 필요한 증빙, 교환·보완 범위를 집행 전에 문서화해야 합니다. | 自動的に有効認定されるものではありません。対象理由、連絡回数・時間帯、申請期限、必要な証拠、交換・補完の範囲を開始前に文書化する必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.8.answer | 상담 | 검토할 수 있지만 가용 물량은 지역, 타깃, 스크립트, 단가, 기간과 검수 조건에 따라 달라집니다. 먼저 작은 범위의 파일럿으로 실제 공급·상담 흐름을 확인하는 편이 안전합니다. | 検討できますが、供給可能な件数は地域、対象者、スクリプト、単価、期間、確認条件によって変わります。まず小規模な試行で、実際の供給と相談の流れを確認することをおすすめします。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.9.answer | DB·상담 | 리드베이는 보험DB를 비교·구매하고 배분·상담·계약·AS·정산하는 영업조직의 흐름에, 콜투세일은 DB를 생산·검수·납품하는 콜센터의 공급 운영에 초점을 둡니다. 실제 기능과 연동 범위는 각 서비스의 현재 조건을 확인해야 합니다. | LeadBayは、保険リードの比較・購入から配分・相談・契約・アフターサポート・精算まで、営業組織の業務に重点を置いています。Call2Saleは、リードを獲得・確認・納品するコールセンターの供給業務を扱います。実際の機能と連携範囲は、各サービスの現在の条件を確認する必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.10.question | 상담 | 상담 전에 무엇을 준비하면 되나요? | 相談前に何を準備すればよいですか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.10.answer | DB | 조직 형태와 설계사 수, 대응 지역, 희망 DB 유형·월 물량, 현재 구매·배분 방식, 기존 CRM, 유효·중복·AS 기준과 시작 희망일을 알려주시면 검토가 빨라집니다. | 組織形態、保険募集人数、対応地域、希望リード種別・月間件数、現在の購入・配分方法、既存CRM、有効・重複・アフターサポート基準、希望開始日を教えていただくと、検討がスムーズです。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.cta.title | DB | 보험DB 견적보다 먼저, 유효·AS·배분 기준을 맞추세요 | 保険リードの見積もり前に、有効・アフターサポート・配分の基準を合わせましょう | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.cta.text | DB | 조직 규모, 희망 지역·물량, DB 유형과 현재 운영 방식을 알려주시면 광고 유입·퍼미션콜·리드베이·콜투세일 중 필요한 범위를 구체적으로 나눠드립니다. | 組織規模、希望地域・件数、リード種別、現在の運用方法を教えてください。広告からの獲得・同意確認の電話・LeadBay・Call2Saleの中から、必要な範囲を具体的に整理します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.cta.label | DB·상담 | 보험 DB 운영 상담 | 保険リードの運用を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.title | DB | 코인 DB 마케팅 — 위험 고지와 동의가 출발점입니다 | 暗号資産投資リードのマーケティング — リスク告知と同意取得から始めます | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.lead | 상담·인정 | 가상자산 관련 CPA는 관심고객의 상담 신청을 측정하되, 가격 상승이나 수익 가능성을 약속해서는 안 됩니다. 서비스 제공 범위, 변동성 위험, 광고 가능 여부와 개인정보 동의를 먼저 검토합니다. | 暗号資産関連のCPAは、関心のある方の相談申込を測定しますが、価格上昇や利益の可能性を約束してはいけません。サービスの提供範囲、価格変動リスク、広告実施の可否、個人情報に関する同意を先に確認します。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.meta_description | DB·상담 | 사업·광고 적합성, 위험 고지, 상담 동의와 유효 DB 기준을 먼저 확인하는 가상자산 관심고객 CPA 마케팅입니다. | 事業・広告の適合性、リスク告知、相談への同意、有効リードの基準を先に確認する、暗号資産に関心のある方に向けたCPAマーケティングです。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.hero_cta | 상담 | 코인 CPA 적합성 상담 | 暗号資産CPAの適合性を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.body.0 | 상담 | 가상자산 서비스의 실제 범위와 위험을 설명하고 상담 연락에 동의한 신청을 측정합니다. | 暗号資産サービスの実際の範囲とリスクを説明し、相談の連絡に同意した申込を測定します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.sections.0.paragraphs.1 | 상담 | 제이커브는 사업 주체와 서비스 범위, 필수 고지, 상담 신청과 동의 구조를 확인한 뒤 캠페인 가능 여부부터 판단합니다. | J-Curveは事業主体、サービス範囲、必須の告知、相談申込と同意取得の仕組みを確認し、まず実施の可否を判断します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.sections.1.items.3.title | 상담 | 상담 피드백 기반 운영 | 相談結果に基づいて運用 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.sections.1.items.3.text | 소재 | 신청 이후 상태를 분류해 허용된 범위에서 소재와 타게팅을 개선합니다. | 申込後の状態を分類し、許容範囲内でクリエイティブとターゲティングを改善します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.sections.2.title | 상담 | 상담 전에 준비할 자료 | 相談前に準備する資料 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.sections.2.items.3 | DB·상담·인정 | 개인정보 동의, 상담 주체와 유효 DB 처리 기준 | 個人情報に関する同意、相談主体、有効リードの処理基準 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.sections.3.items.2.title | 상담 | 상담 운영 기록이 가능한 조직 | 相談の運用記録を残せる組織 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.sections.3.items.2.text | 상담 | 연락·상담 상태를 관리하고 동의 범위를 지킬 수 있는 경우. | 連絡・相談の状況を管理し、同意範囲を守れる組織が対象です。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.faq.1.answer | 상담 | 아닙니다. 서비스 유형, 제공 지역, 인허가·신고 상태와 매체 정책에 따라 제한될 수 있습니다. 상담 단계에서 사업 자료를 확인합니다. | いいえ。サービスの種類、提供地域、許認可・届出の状況、媒体の規約によって制限される場合があります。相談時に事業資料を確認します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.faq.2.question | 상담 | CPA면 상담 이후 투자 결과도 책임지나요? | CPAでは、相談後の投資結果にも責任を負いますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.faq.2.answer | 상담 | CPA는 합의한 상담 신청을 측정하는 과금 구조입니다. 고객의 투자 판단과 결과, 서비스 계약이나 수익을 보장하지 않습니다. | CPAは合意した相談申込を測定する課金方式です。お客様の投資判断や結果、サービス契約、収益は保証しません。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.cta.label | 상담 | 코인 CPA 적합성 상담 | 暗号資産CPAの適合性を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.title | DB | 퍼미션 콜 DB 마케팅 — 연락 동의를 운영 가능한 기록으로 | 同意取得済みコールリードのマーケティング — 連絡への同意を運用できる記録へ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.meta_description | DB·상담·인정 | 상담 연락 목적, 개인정보 동의, 동의 기록, 전달·콜 운영과 철회 절차를 함께 설계하는 퍼미션 콜 DB 마케팅입니다. | 相談の連絡目的、個人情報に関する同意、同意記録、受け渡し・電話業務、撤回手順を合わせて設計する、同意取得済みコールリードのマーケティングです。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.hero_cta | 상담 | 퍼미션 구조 상담 | 同意取得の仕組みを相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.body.0 | 상담 | 고객이 상담 연락의 목적과 주체를 이해하고 동의하도록 수집·전달·콜 운영 흐름을 설계합니다. | お客様が相談連絡の目的と主体を理解して同意できるよう、収集・受け渡し・電話業務の流れを設計します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.sections.0.paragraphs.1 | 운영 체계·DB·상담 | 수집 화면, 동의 로그, DB 전달, 상담 스크립트, 수신 거부와 보유 기간까지 하나의 운영 체계로 설계해야 합니다. | 収集画面、同意ログ、リードの受け渡し、相談スクリプト、受信拒否、保有期間までを、一つの運用体制として設計する必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.sections.1.items.2.title | 상담 | 전달·상담 운영 연결 | 受け渡しと相談業務を連携 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.sections.2.items.0 | 인정 | 개인정보 수집 항목·목적·보유 기간과 연락 주체 | 個人情報の収集項目・目的・保有期間と連絡主体 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.sections.3.items.0.title | 상담 | 여러 상담원이 연락하는 조직 | 複数の担当者が連絡する組織 | 상담원=agent/operator, 상담 용어 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.sections.3.items.0.text | DB | DB 배분과 연락 상태, 수신 거부 반영을 일관되게 관리해야 하는 경우. | リードの配分、連絡状況、受信拒否の反映を一貫して管理する必要がある組織に適しています。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.sections.3.items.1.title | DB | 외부 파트너와 DB를 주고받는 사업 | 外部パートナーとリードを授受する事業 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.faq.0.question | 상담 | 상담 동의만 받으면 언제든 전화할 수 있나요? | 相談への同意があれば、いつでも電話できますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.faq.1.question | DB | 기존에 보유한 DB도 바로 사용할 수 있나요? | すでに保有しているリードも、そのまま使えますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.cta.text | DB | 현재 랜딩과 DB 전달·콜 운영 방식을 알려주시면 끊긴 지점을 함께 확인합니다. | 現在のランディングページとリードの受け渡し・電話業務の方法を教えていただければ、途切れている箇所を一緒に確認します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.cta.label | 상담 | 퍼미션 구조 상담 | 同意取得の仕組みを相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.lead | 지면·소재 | 네이버 GFA는 네이버 서비스의 다양한 디스플레이 지면에서 오디언스에게 도달하는 광고입니다. 제이커브는 캠페인 목적, 전환 측정, 타게팅과 소재 가설을 먼저 정하고 데이터를 보며 예산과 크리에이티브를 조정합니다. | NAVER GFA（NAVERのディスプレイ広告）は、NAVERのサービス内のさまざまな広告枠でオーディエンスに届ける広告です。J-Curveは目的、コンバージョン測定、ターゲティング、クリエイティブの仮説を先に定め、データを見ながら予算とクリエイティブを調整します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.meta_description | 소재 | 캠페인 목표, 전환 측정, 오디언스, 소재 테스트와 운영 리포트를 연결하는 네이버 GFA 광고 대행 서비스입니다. | 目標、コンバージョン測定、オーディエンス、クリエイティブのテスト、運用レポートをつなぐNAVER GFA広告の運用代行サービスです。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.body.0 | 소재 | 네이버 GFA 캠페인의 목표, 측정, 오디언스와 소재 테스트를 한 흐름으로 운영합니다. | NAVER GFAの目標、測定、オーディエンス、クリエイティブのテストを、一連の流れとして運用します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.sections.0.paragraphs.0 | 소재 | 캠페인 목적과 전환 이벤트가 맞지 않으면 광고 시스템이 잘못된 행동을 학습합니다. 타게팅을 좁히기만 하거나 소재 한두 개를 오래 유지해도 원인을 분리하기 어렵습니다. | キャンペーンの目的とコンバージョンイベントが合わないと、広告システムは意図しない行動を学習します。対象を絞るだけの運用や、少数のクリエイティブを長く使う運用でも、原因の切り分けが難しくなります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.sections.1.title | 소재 | 목표에서 소재 개선까지 반복 가능한 구조로 | 目標からクリエイティブの改善まで、繰り返せる仕組みへ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.sections.1.items.0.text | 상담 | 매출, 상담, 가입 등 비즈니스에 의미 있는 행동과 측정 지점을 정합니다. | 売上、相談、登録など、事業上意味のある行動と測定地点を決めます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.sections.1.items.2.title | 소재 | 오디언스·소재 테스트 | オーディエンスとクリエイティブをテスト | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.sections.2.items.2 | 소재 | 오디언스별 소재 가설과 테스트 이력 | オーディエンスごとのクリエイティブ仮説とテスト履歴 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.sections.3.items.0.text | 상담 | 노출보다 상담·가입·구매 등 행동을 기준으로 운영하려는 경우. | 表示回数より、相談・登録・購入などの行動を基準に運用したいブランドに適しています。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.sections.3.items.1.title | 소재 | 소재 테스트가 필요한 팀 | クリエイティブのテストが必要なチーム | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.faq.2.question | 소재 | 소재 제작도 포함되나요? | クリエイティブ制作も含まれますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.faq.2.answer | 소재 | 필요한 소재 형식과 수량, 촬영·디자인 범위를 확인한 뒤 운영 범위에 포함할지 협의합니다. 기존 자산을 재가공하는 방식도 가능합니다. | 必要な形式と点数、撮影・デザインの範囲を確認し、運用範囲に含めるか相談します。既存の素材を再編集することも可能です。 | 소재 지정 표현 미일치(아래 품질 판정 함께 참고) | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.cta.text | 소재 | 목표, 예산과 계정 현황을 알려주시면 측정·캠페인·소재 관점에서 진단합니다. | 目標、予算、アカウントの現状を教えてください。測定・キャンペーン・クリエイティブの観点から診断します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.lead | 소재 | 메타 광고는 타게팅 설정만으로 끝나지 않습니다. 전환 이벤트와 퍼널, 고객에게 말을 거는 소재, 랜딩 경험을 함께 설계하고 학습 데이터를 잃지 않도록 테스트 단위를 관리해야 합니다. | Meta広告は、ターゲティングの設定だけでは終わりません。コンバージョンイベントとファネル、お客様に語りかけるクリエイティブ、ランディングページの体験を合わせて設計し、学習データを失わないようテストの単位を管理する必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.meta_description | 소재 | 메타 광고의 전환 측정, 퍼널, 오디언스, 소재 테스트와 예산 운영을 연결하는 페이스북·인스타그램 광고 대행입니다. | コンバージョン測定、ファネル、オーディエンス、クリエイティブのテスト、予算運用をつなぐFacebook・Instagram広告の運用代行です。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.sections.0.paragraphs.0 | 소재 | 광고 세트를 자주 복제하고 목표와 이벤트를 계속 바꾸면 데이터가 흩어집니다. 반대로 같은 소재를 오래 두면 피로도와 메시지 문제를 구분하기 어렵습니다. | 広告セットを頻繁に複製し、目標やイベントを変え続けると、データが分散します。一方、同じクリエイティブを長く使うと、広告疲れとメッセージの問題を区別しにくくなります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.sections.1.title | 소재 | 측정과 소재를 같은 주기로 움직입니다 | 測定とクリエイティブを同じ周期で改善します | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.sections.1.items.0.text | 상담 | 인지부터 구매·상담까지 단계별 행동과 최종 KPI를 정합니다. | 認知から購入・相談まで、段階ごとの行動と最終KPIを決めます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.sections.1.items.2.title | 소재 | 소재 가설 제작 | クリエイティブの仮説を形にする | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.sections.1.items.2.text | 소재 | 고객의 문제, 증거, 제안과 형식을 나눠 테스트 가능한 소재를 준비합니다. | お客様の課題、根拠、提案内容、形式を分け、テストできるクリエイティブを準備します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.sections.1.items.3.text | 소재 | 전환 품질을 보고 예산과 소재를 조정하며 랜딩 병목도 함께 다룹니다. | コンバージョンの品質を見て予算とクリエイティブを調整し、ランディングページのボトルネックも改善します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.sections.2.items.2 | 소재 | 소재별 가설, 변경 이력과 학습 내용 | クリエイティブごとの仮説、変更履歴、学習内容 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.sections.3.items.0.title | 소재 | 소재 회전이 필요한 브랜드 | クリエイティブの入れ替えが必要なブランド | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.sections.3.items.3.text | 소재 | 메타 광고는 소재와 데이터 학습을 지속 관리해야 하므로 맞지 않을 수 있습니다. | Meta広告はクリエイティブとデータ学習の継続管理が必要なため、適さない場合があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.cta.title | 소재 | 소재를 더 만들기 전에, 계정이 무엇을 배우는지 보세요 | クリエイティブを増やす前に、アカウントの学習内容を確認しましょう | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.youtube.hero_cta | 상담 | 유튜브 전략 상담 | YouTubeの戦略を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.youtube.faq.0.answer | 소재 | 가능하지만 광고 목적과 초반 메시지, 화면 비율과 다음 행동이 맞는지 먼저 확인합니다. 필요한 경우 기존 영상을 재편집하거나 새 소재 범위를 협의합니다. | 可能ですが、広告目的、冒頭のメッセージ、画面比率、次の行動が合うか先に確認します。必要に応じて既存動画を再編集するか、新規クリエイティブの範囲を相談します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.youtube.cta.label | 상담 | 유튜브 전략 상담 | YouTubeの戦略を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.basic.hero_cta | 상담 | 베이직 적합성 상담 | ベーシックの適合性を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.basic.cta.label | 상담 | 베이직 적합성 상담 | ベーシックの適合性を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.pro.hero_cta | 상담 | 프로 적합성 상담 | プロの適合性を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.pro.cta.label | 상담 | 프로 적합성 상담 | プロの適合性を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.elite.hero_cta | 상담 | 엘리트 운영 상담 | エリートの運用を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.elite.sections.1.title | 운영 체계 | 전사 진단에서 반복 운영 체계까지 | 全社的な診断から、繰り返し改善する運用体制まで | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.elite.sections.3.items.3.text | 운영 체계 | 엘리트는 장기 운영 체계에 초점을 두므로 단발성 요청에는 과할 수 있습니다. | エリートは長期の運用体制に重点を置くため、単発のご依頼には範囲が大きすぎる場合があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.elite.cta.title | 운영 체계 | 고경쟁 SEO를 개인의 감이 아닌 운영 체계로 바꾸세요 | 競争の激しいSEOを、個人の勘ではなく運用体制で支えましょう | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.elite.cta.label | 상담 | 엘리트 운영 상담 | エリートの運用を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.hero_cta | 상담 | 발견 전략 상담 | 発見されるための戦略を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.sections.0.title | 지면 | 인기게시물은 외부에서 소유하거나 고정할 수 있는 광고 지면이 아닙니다 | 人気投稿は、外部から所有・固定できる広告枠ではありません | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.faq.2.question | 상담 | 어떤 발견 전략을 상담할 수 있나요? | 発見されるために、どのような戦略を相談できますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-popular.cta.label | 상담 | 발견 전략 상담 | 発見されるための戦略を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.hero_cta | 상담 | 계정 성장 상담 | アカウントの成長を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.faq.1.question | 상담 | 어떤 성장 방법을 상담할 수 있나요? | どのような成長方法を相談できますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-followers.cta.label | 상담 | 계정 성장 상담 | アカウントの成長を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-likes.hero_cta | 상담 | 콘텐츠 반응 상담 | コンテンツの反応を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-likes.faq.1.question | 상담 | 어떤 참여 확대 방법을 상담할 수 있나요? | どのようなエンゲージメント向上策を相談できますか？ | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.instagram-likes.cta.label | 상담 | 콘텐츠 반응 상담 | コンテンツの反応を相談する | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | cta_text | 상담 | 궁금한 점은 문의로 남겨 주세요. 프로젝트 상담은 1:1 문의가 가장 빠릅니다. | ご不明な点はお問い合わせください。プロジェクトのご相談は、1:1のお問い合わせが最も早い方法です。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.start.label | 상담 | 시작·상담 | ご利用開始・ご相談 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.start.items.8.q | 상담 | 상담 전에 어떤 자료가 필요한가요? | 相談前にどのような資料が必要ですか。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.start.items.10.a | 인정 | 첫 문의에는 비밀번호, API 키, 고객 개인정보를 보내지 마세요. 검토에 필요한 경우에도 접근 방식과 제공 범위를 먼저 합의합니다. | 最初のお問い合わせでは、パスワード、APIキー、顧客の個人情報を送らないでください。検討に必要な場合も、アクセス方法と提供範囲を先に合意します。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.2.q | 소재 | 광고 소재도 함께 제작하나요? | 広告クリエイティブの制作も依頼できますか。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.2.a | 소재 | 촬영·편집·디자인을 사내에서 연결할 수 있습니다. 필요한 소재의 형식과 수량, 촬영 여부는 캠페인 목표와 계약 범위에 맞춰 확정합니다. | 撮影・編集・デザインを社内で連携して進められます。必要なクリエイティブの形式と数量、撮影の要否は、キャンペーンの目標と契約範囲に合わせて確定します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.4.a | 소재 | 노출과 클릭뿐 아니라 합의한 비즈니스 전환, 비용, 매체·캠페인·소재별 차이와 다음 실행 항목을 중심으로 정리합니다. 구체적인 항목과 주기는 운영 범위에 따라 확정합니다. | 表示回数とクリックに加え、合意した事業上のコンバージョン、費用、媒体・キャンペーン・クリエイティブ別の違い、次の実行項目を中心にまとめます。具体的な項目と頻度は、運用範囲に応じて確定します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.7.q | DB | 유효하지 않은 DB나 전환은 어떻게 처리하나요? | 無効なリードやコンバージョンはどのように扱いますか。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.7.a | 반려 | 중복, 필수 항목 오류, 연락 가능 여부, 동의 범위 등 캠페인 전에 합의한 승인·반려 기준으로 판단합니다. 업종과 액션에 따라 기준은 달라질 수 있습니다. | 重複、必須項目の誤り、連絡の可否、同意の範囲など、キャンペーン開始前に合意した有効認定・却下の基準で判断します。基準は業種やアクションによって異なる場合があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.9.q | 인정 | 개인정보 동의와 광고 심사도 검토하나요? | 個人情報の同意や広告審査も確認しますか。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.10.a | 상담 | 앱 설치, 첫 실행, 회원가입, 튜토리얼 완료, 특정 미션 도달, 견적·상담 신청, 구매 등 확인 가능한 행동을 기준으로 설계할 수 있습니다. 실제 가능 여부와 단가는 업종, 난이도, 검수 방식에 따라 달라집니다. | アプリのインストール、初回起動、会員登録、チュートリアルの完了、特定ミッションへの到達、見積もり・相談の申し込み、購入など、確認可能な行動を基準に設計できます。実施の可否と単価は、業種、難易度、検証方法によって変わります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.13.a | 지면 | 연동 방식은 앱 구조와 운영 범위에 따라 달라집니다. 기존 지면, 웹뷰, 서버 연동 가능 여부와 보상 처리 구조를 확인한 뒤 개발 범위와 테스트 절차를 합의합니다. | 連携方法は、アプリの構造と運用範囲によって異なります。既存の広告枠、WebView・サーバー連携の可否、報酬処理の仕組みを確認してから、開発範囲とテスト手順を合意します。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.16.a | 소재·상담 | 목표 액션, 희망 일정과 예산 범위, 랜딩 또는 앱 링크, 전환 확인 방식, 제한 조건, 소재와 브랜드 가이드를 준비하면 됩니다. 준비되지 않은 항목은 상담에서 체크리스트로 정리합니다. | 目標アクション、希望日程と予算の範囲、ランディングページまたはアプリのリンク、コンバージョンの確認方法、制約条件、クリエイティブ、ブランドガイドを準備してください。未準備の項目は、相談時にチェックリストにまとめます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.17.a | 지면 | 서비스와 이용자 특성, 월간 활성 이용 규모, 희망 지면, 리워드 정책, 개발 환경, 운영·CS·정산 담당 체계를 확인합니다. 그 결과를 바탕으로 연동 가능 범위와 순서를 정합니다. | サービスと利用者の特性、月間アクティブユーザー数、希望する広告枠、リワード方針、開発環境、運用・カスタマーサポート・精算の担当体制を確認します。その結果に基づき、連携可能な範囲と順序を決めます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.self.items.13.a | 상담 | 현재 사이트나 계정, 목표, 예산 범위와 가장 답답한 지점을 알려주세요. 상품 구매가 맞는지, 먼저 진단이나 대행 상담이 필요한지부터 나눠볼 수 있습니다. | 現在のサイトやアカウント、目標、予算の範囲、最もお困りの点をお知らせください。商品購入が適切か、先に診断や運用代行の相談が必要かを整理できます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.0.a | DB·상담 | 보험DB를 비교·구매하고 조직 내 담당자에게 배분해 상담·계약·AS·정산 상태를 관리하는 영업조직, 설계사와 대리점을 위한 CRM입니다. | 保険リードを比較・購入し、組織内の担当者に配分して、相談・契約・アフターサポート・精算の状況を管理する営業組織、保険募集人、代理店向けのCRMです。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.1.a | DB·상담 | 그렇게 보장되지 않습니다. 점수는 서비스 내 비교 정보이며 실제 상담 연결과 계약은 DB의 적법성·시점·대상, 담당자의 상담과 시장 상황 등 여러 요인의 영향을 받습니다. | そのようには保証されません。スコアはサービス内の比較情報です。実際に相談につながるか、契約に至るかは、リードの適法性・時点・対象、担当者の相談対応、市場の状況など、複数の要因に左右されます。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.2.q | DB | 입점 업체라는 이유만으로 DB의 적법성이 보장되나요? | 出店している業者なら、リードの適法性は保証されますか。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.3.q | 인정 | 리드베이가 개인정보 준법 책임을 대신하나요? | LeadBayが個人情報に関する法令遵守の責任を代わりに負いますか。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.4.q | DB·상담 | DB를 구매하면 상담이나 계약이 보장되나요? | リードを購入すれば、相談や契約は保証されますか。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.4.a | 상담 | 보장되지 않습니다. 연락 가능 여부, 상담 의향, 정보의 시의성, 배분과 상담 품질에 따라 결과가 달라질 수 있습니다. | 保証されません。連絡の可否、相談の意向、情報の鮮度、配分や相談対応の質によって、結果が変わる場合があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.6.a | 인정 | 이 페이지는 소개용입니다. 실제 화면, 가격, 권한, 거래·정산 기능, 약관과 개인정보 처리 안내는 리드베이의 최신 서비스가 우선합니다. | このページはサービスの紹介です。実際の画面、価格、権限、取引・精算機能、利用規約、個人情報の取り扱いについては、LeadBayの最新サービスでの案内が優先されます。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.7.a | DB·상담 | 원천 DB를 상담원에게 배분해 보험DB를 생산하고 고객사에 수주·납품·AS·정산하는 콜센터 운영조직을 위한 CRM입니다. | 元となるリードを相談員に配分して保険リードを生成し、顧客企業からの受注・納品・アフターサポート・精算を行う、コールセンター運営組織向けのCRMです。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.8.q | 상담 | AI 콜 품질 분석이 상담을 정확히 평가하나요? | AIによる通話品質分析は、相談対応を正確に評価しますか。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.8.a | 상담 | 정확성을 보장하지 않습니다. 분석은 패턴과 검토 지점을 찾는 보조 정보이며 관리자 또는 검수자가 통화 원자료와 상담 맥락을 함께 확인해야 합니다. | 正確性は保証しません。分析は、パターンや確認すべき点を見つけるための補助情報です。管理者または検査担当者が、通話の元データと相談の文脈を併せて確認する必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.11.q | DB | 콜투세일이 DB의 적법성을 보장하나요? | Call2Saleはリードの適法性を保証しますか。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.11.a | DB | 보장하지 않습니다. 원천 DB의 수집·제공·마케팅 이용 근거와 고객사 납품 조건은 운영·거래 당사자가 직접 확인해야 합니다. | 保証しません。元となるリードの収集・提供・マーケティング利用の根拠と、顧客企業への納品条件は、運営・取引の当事者が直接確認する必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.build.items.5.a | 상담 | 지원사업의 모집 여부와 자격은 시기와 기관별 공고에 따라 달라집니다. 상담 시 기업 정보와 공고문을 기준으로 마케팅 과업의 적합성을 검토하며, 최신 모집 상태와 신청 자격은 운영기관의 공식 안내를 우선 확인해야 합니다. | 支援事業の募集の有無と資格は、時期や各機関の公募によって異なります。相談時には、企業情報と公募要項を基に、マーケティング業務の適合性を検討します。最新の募集状況と申請資格については、まず運営機関の公式案内を確認する必要があります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.build.items.8.a | 인정 | 아닙니다. 인정되는 비용, 자부담, 집행 기간, 공급기업 요건과 증빙 방식은 사업마다 다릅니다. 계약이나 집행 전에 운영기관의 공고·협약·지침을 확인해야 합니다. | いいえ。対象となる費用、自己負担、支出期間、供給企業の要件、証明方法は、事業ごとに異なります。契約や支出の前に、運営機関の公募・協約・指針を確認する必要があります。 | 인정=지원사업 비용 허용, 리드 유효인정 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.build.items.9.a | 인정 | 공고상 인정 범위와 기업의 과업 목표에 따라 퍼포먼스 광고, SEO, 콘텐츠, 영상, 웹 제작 등을 검토할 수 있습니다. 모든 사업에서 모든 항목이 인정되는 것은 아닙니다. | 公募で認められる範囲と企業の業務目標に応じて、パフォーマンス広告、SEO、コンテンツ、動画、Web制作などを検討できます。すべての事業ですべての項目が認められるわけではありません。 | 인정=지원사업 비용 허용, 리드 유효인정 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | title | 인정 | 개인정보처리방침 &#124; 제이커브인터렉티브 | 個人情報保護方針 &#124; J-Curve Interactive | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | heading | 인정 | 개인정보처리방침 | 個人情報保護方針 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | introduction | 인정 | (주)제이커브인터렉티브(이하 "회사")는 이용자의 개인정보를 중요하게 생각하며, 「개인정보 보호법」 등 관련 법령을 준수합니다. | J-Curve Interactive Co., Ltd.（以下「当社」といいます。）は、利用者の個人情報を重視し、韓国の「個人情報保護法」等の関連法令を遵守します。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.0.0 | 인정 | 1. 수집하는 개인정보 항목 | 1. 収集する個人情報の項目 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.0.1 | 상담 | 회사는 상담 문의 및 서비스 제공을 위해 이름, 연락처, 이메일, 회사명, 문의 내용을 수집할 수 있습니다. | 当社は、ご相談への対応およびサービスの提供のため、氏名、連絡先、メールアドレス、会社名、お問い合わせ内容を収集することがあります。 | OK — §8 지정 표현 대응 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.1.0 | 인정 | 2. 개인정보의 수집 및 이용 목적 | 2. 個人情報の収集および利用目的 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.1.1 | 상담·인정 | 수집한 개인정보는 상담 응대, 서비스 제공, 계약의 이행 및 고객 관리를 위해 이용됩니다. | 収集した個人情報は、ご相談への対応、サービスの提供、契約の履行および顧客管理のために利用します。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.2.0 | 인정 | 3. 개인정보의 보유 및 이용 기간 | 3. 個人情報の保有および利用期間 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.2.1 | 인정 | 원칙적으로 개인정보 수집·이용 목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 관련 법령에 따라 보존할 필요가 있는 경우 해당 기간 동안 보관합니다. | 原則として、個人情報の収集・利用目的が達成された後は、当該情報を遅滞なく破棄します。ただし、関連法令に基づき保存する必要がある場合は、該当する期間保管します。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.3.0 | 인정 | 4. 개인정보 보호책임자 | 4. 個人情報保護責任者 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.3.1 | 인정 | 개인정보 관련 문의는 대표 이메일(jcurve19@gmail.com) 또는 대표전화(02-1668-2612)로 연락 주시기 바랍니다. | 個人情報に関するお問い合わせは、当社の代表メールアドレス（jcurve19@gmail.com）または代表電話（02-1668-2612）までご連絡ください。 | 인정=개인정보 부분 문자열, 대상 아님 | OK — 원문의 뜻·조건을 유지함. | 해당 없음 |

## 8. U7 길이·누락·추가

Unicode 문자 수(공백 포함, HTML 태그 제외)로 계산했다. en/ko <0.8 또는 >4.5, ja/ko <0.5 또는 >2.5가 31잎이다. 이상치 순위는 `max(하한/비율, 비율/상한)` 내림차순으로 정해 비교 가능한 이탈도를 사용했다. 아래 순위 1~15를 포함해 31개 모두 원문/번역을 직접 대조했고 누락/새 주장 신호는 없었다. 짧은 UI 조각·브랜드 로마자·AS 풀어쓰기가 대부분이다. `empty_before`·`empty_after`는 검색어를 끼운 뒤의 완성 문장도 확인했다.

| 순위 | 파일 | 키 | 한국어 | 번역 | 비율 | 판정 | 대안 |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | lang/en/pages/faq.php | empty_before | ‘ | We could not find any questions matching “ | 42.0 | 정상 — 검색어 앞뒤 조각을 결합하면 같은 문장 | 해당 없음 |
| 2 | lang/en/pages/faq.php | empty_after | ’에 맞는 질문을 찾지 못했어요. | ”. | 0.111 | 정상 — 검색어 앞뒤 조각을 결합하면 같은 문장 | 해당 없음 |
| 3 | lang/ja/subpages.php | boostingshop.parent.label | 부스팅샵 | BoostingShop（ブースティングショップ） | 6.25 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 4 | lang/en/subpages.php | cpa.items.insurance.local_nav.3.label | 품질·AS | Quality and after-sales support | 6.2 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 5 | lang/en/pages/faq.php | categories.start.label | 시작·상담 | Getting started &amp; consultations | 6.2 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 6 | lang/en/pages/faq.php | categories.build.items.5.from.1 | 마케팅 지원사업 | Korean government SME marketing support programs | 6.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 7 | lang/en/pages/faq.php | categories.build.items.6.from.1 | 마케팅 지원사업 | Korean government SME marketing support programs | 6.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 8 | lang/en/pages/faq.php | categories.build.items.7.from.1 | 마케팅 지원사업 | Korean government SME marketing support programs | 6.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 9 | lang/en/pages/faq.php | categories.build.items.8.from.1 | 마케팅 지원사업 | Korean government SME marketing support programs | 6.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 10 | lang/en/pages/faq.php | categories.build.items.9.from.1 | 마케팅 지원사업 | Korean government SME marketing support programs | 6.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 11 | lang/en/subpages.php | cpa.items.insurance.sections.4.rows.5.0 | AS 판단 | Assessing after-sales support | 5.8 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 12 | lang/en/subpages.php | cpa.items.insurance.sections.10.items.1.title | AS 신청 | After-sales support requests | 5.6 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 13 | lang/en/subpages.php | performance.items.youtube.sections.1.items.2.title | 훅·구성·제작 | Develop hooks, structure and production | 5.571 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 14 | lang/en/pages/faq.php | categories.ads.label | 광고 | Advertising | 5.5 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 15 | lang/ja/pages/faq.php | home | 홈 | ホーム | 3.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 16 | lang/ja/pages/faq.php | categories.self.items.7.from.1 | 부스팅샵 | BoostingShop | 3.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 17 | lang/ja/pages/faq.php | categories.self.items.8.from.1 | 부스팅샵 | BoostingShop | 3.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 18 | lang/ja/pages/faq.php | categories.self.items.9.from.1 | 부스팅샵 | BoostingShop | 3.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 19 | lang/ja/pages/faq.php | categories.self.items.10.from.1 | 부스팅샵 | BoostingShop | 3.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 20 | lang/ja/pages/faq.php | categories.self.items.11.from.1 | 부스팅샵 | BoostingShop | 3.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 21 | lang/ja/pages/faq.php | categories.self.items.12.from.1 | 부스팅샵 | BoostingShop | 3.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 22 | lang/ja/pages/faq.php | categories.self.items.13.from.1 | 부스팅샵 | BoostingShop | 3.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 23 | lang/en/subpages.php | cpa.items.insurance.sections.5.items.6.title | AS·광고 피드백 | Connect after-sales support to campaign feedback | 5.333 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 24 | lang/en/subpages.php | cpa.items.insurance.sections.9.items.1.title | 소규모 GA·팀 | Small general insurance agencies and teams | 5.25 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 25 | lang/en/subpages.php | seo.items.naver-place.sections.1.items.0.title | 현황 진단 | Review the current listing | 5.2 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 26 | lang/en/subpages.php | cpa.items.insurance.sections.9.items.3.title | 리모델링 중심 상담 | Consultations focused on policy review / switching | 5.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 27 | lang/en/subpages.php | boostingshop.items.instagram-followers.sections.3.items.3.title | 성과 해석 분리 | Distinguish counts from business results | 5.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 28 | lang/en/subpages.php | boostingshop.items.instagram-likes.sections.3.items.3.title | 성과 해석 분리 | Distinguish counts from business results | 5.0 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 29 | lang/en/subpages.php | boostingshop.items.instagram-popular.sections.1.items.3.title | 협업과 교차 유입 | Connect collaborations and traffic sources | 4.667 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 30 | lang/en/subpages.php | boostingshop.items.instagram-followers.sections.1.items.3.title | 협업과 교차 유입 | Connect collaborations and traffic sources | 4.667 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |
| 31 | lang/en/subpages.php | boostingshop.items.instagram-likes.sections.1.items.3.title | 협업과 교차 유입 | Connect collaborations and traffic sources | 4.667 | 정상 — 브랜드/약어/어순을 자연스럽게 풀어쓴 표현 | 해당 없음 |

길이 검사는 의미 누락을 충분히 잡지 못한다. 실제 FAIL은 1절의 CTA·보험 비교 제목과 U5의 YouTube 문장이다. 이 3개는 길이 임계값 안에 있어도 원문 요소가 빠지거나 배제 의미가 약해졌으므로 별도로 판정했다.

### 보장·최상급 후보 106잎 전수

`best` 1건은 원문의 「무조건 가장 좋은 선택인가요?」라는 질문, `leading` 1건은 「선행 지표」(leading indicators)라 새 우월성 주장이 아니다. 나머지 guarantee 계열은 질문·비보장·부적합 대상 설명으로, 원문에 없는 실적/최상급/긍정 보장 추가는 확인되지 않았다. 한국 플랫폼 첫 설명 중 최대/가장 많이 쓰는 표현은 GLOSSARY §4에 명시된 설명이며 별도의 창작 실적이 아니다.

| 파일 | 키 | 한국어 | 번역 | 판정 | 대안 |
| --- | --- | --- | --- | --- | --- |
| lang/en/subpages.php | seo.items.backlinks.body.2 | 검색 순위와 페널티 회피를 보장하지 않으며, 사이트 상태와 경쟁 환경에 맞춰 위험을 낮추는 방식으로 진행합니다. | We do not guarantee search rankings or protection from penalties. We work to reduce risk based on your site's condition and competitive environment. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.backlinks.sections.2.note | 검색 순위 상승이나 특정 시점의 노출, 검색엔진 조치 회피를 보장하는 상품이 아닙니다. | This service does not guarantee higher search rankings, visibility by a specific date or protection from search engine actions. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.backlinks.faq.0.answer | 아닙니다. 검색 결과는 사이트 상태, 콘텐츠, 경쟁도와 여러 신호가 함께 작용합니다. 백링크는 그중 외부 신뢰 신호를 보강하는 수단이며 순위나 반영 시점을 보장하지 않습니다. | No. Results depend on site health, content, competition and multiple signals. Backlinks strengthen external trust signals but do not guarantee rankings or when changes will take effect. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.backlinks.faq.2.question | 검색엔진 페널티가 전혀 없다고 보장할 수 있나요? | Can you guarantee there will be no search engine penalties? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | seo.items.backlinks.faq.2.answer | 검색엔진의 판단을 제3자가 보장할 수는 없습니다. 제이커브는 과도한 반복과 비정상 패턴을 피하고, 확인 가능한 범위와 위험 요소를 사전에 설명합니다. | No 3rd party can guarantee a search engine's decisions. We avoid excessive repetition and unusual patterns, and explain what we can verify and the risks involved before starting. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.body.1 | 순위나 노출 위치를 보장하지 않고, 운영 가능한 정보와 콘텐츠를 지속적으로 개선합니다. | We continually improve listing information and content without guaranteeing rankings or placement. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.sections.2.note | 허위 리뷰 작성, 대가성 리뷰 은폐 또는 특정 노출 순위 보장은 제공하지 않습니다. | We do not write fake reviews, conceal paid reviews or guarantee specific rankings. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.faq.0.question | 네이버 플레이스 상위 노출을 보장하나요? | Do you guarantee top rankings on NAVER Place? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.body.1 | 검색 순위나 매출을 보장하지 않으며 플랫폼 정책과 실제 상품 경쟁력을 기준으로 운영합니다. | We follow platform policies and your products' actual competitive strengths. We do not guarantee search rankings or sales. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.sections.2.note | 플랫폼의 노출 위치, 판매량 또는 리뷰 결과를 보장하지 않습니다. | We do not guarantee placement, sales volumes or review outcomes on the platform. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.body.1 | 플랫폼 입점 승인, 노출 위치 또는 판매 성과를 보장하지 않습니다. | We do not guarantee seller approval, placement or sales results on the platform. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.sections.2.note | 플랫폼 심사·정책은 변경될 수 있으며 입점 승인이나 노출 결과를 대신 보장하지 않습니다. | Platform review criteria and policies may change. We cannot guarantee seller approval or visibility outcomes. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.faq.0.question | 카카오 선물하기 입점도 대신 보장해 주나요? | Do you guarantee approval to sell on Kakao Gift? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.faq.2.question | 노출 순위나 판매량을 보장하나요? | Do you guarantee rankings or sales volumes? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.body.1 | 검색 순위, 판매량이나 리뷰 결과를 보장하지 않습니다. | We do not guarantee search rankings, sales volumes or review outcomes. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.faq.0.question | 쿠팡 검색 상위 노출을 보장하나요? | Do you guarantee top rankings in Coupang search? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.body.1 | 상담 신청은 실제 방문이나 계약을 의미하지 않으며 계약 성과를 보장하지 않습니다. | A consultation request does not mean a site visit or signed contract. We do not guarantee contract results. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.2.note | 관련 법령과 매체 심사 기준을 확인해야 하며, 상담 신청·방문·분양 계약을 보장하지 않습니다. | Applicable laws and media review requirements must be checked. We do not guarantee consultation requests, visits or pre-sale contracts. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.3.items.3.title | 계약 보장만 원하는 경우 | Teams seeking guaranteed contracts | 정상: 원문의 부적합 고객 유형/예시/사전보장 어려움에 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.body.1 | 투자 수익, 원금, 가입 또는 상담 전환을 보장하지 않습니다. | We do not guarantee investment returns, principal protection, sign-ups or consultation conversions. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.2.note | 수익·원금·특정 종목 성과를 암시하거나 보장하는 캠페인은 진행하지 않습니다. 최종 집행은 관련 법령과 매체 심사를 충족해야 합니다. | We do not run campaigns that imply or guarantee returns, principal protection or performance of specific stocks. Launch requires compliance with applicable laws and media review requirements. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.3.items.3.title | 수익 보장을 요구하는 경우 | Businesses seeking guaranteed returns | 정상: 원문의 부적합 고객 유형/예시/사전보장 어려움에 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.3.items.3.text | 보장성 표현이나 오인을 유발하는 구조는 진행 대상이 아닙니다. | We do not support campaigns built on guarantees or misleading claims. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.faq.0.answer | 그럴 수 없습니다. CPA는 상담 관심과 신청을 측정할 뿐 투자 결과를 예측하거나 보장하지 않습니다. 수익을 암시하는 광고 표현도 별도 검토가 필요합니다. | No. CPA measures interest and consultation requests; it does not predict or guarantee investment outcomes. Ad claims that imply returns also require separate review. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.faq.1.answer | 아닙니다. 사업 유형, 관련 법령과 매체 정책에 따라 제한될 수 있습니다. 근거 없는 수익 표현, 원금 보장이나 오인을 유발하는 문구는 사용할 수 없습니다. | No. Restrictions depend on your business type, applicable laws and media policies. Unsupported return claims, principal guarantees and misleading wording cannot be used. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.body.1 | 보험 가입, 미팅률, 계약률이나 영업 수익을 보장하지 않습니다. | We do not guarantee insurance sign-ups, meeting rates, contract rates or sales income. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.1.note | 기존 보험 랜딩의 일 생산량·광고주 수·미팅률·전환율 수치는 산출 기준과 최신성을 확인하기 전에는 현재 성과로 사용하지 않습니다. 위 수치 역시 회사 전체 누적 기록이며 보험 캠페인의 결과 보장이 아닙니다. | We do not present daily production, advertiser counts, meeting rates or conversion rates from the previous insurance landing page as current results until their calculation basis and freshness are verified. The figures above are also company-wide cumulative records, not guarantees of insurance campaign results. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.4.note | 퍼미션 확인이 미팅·계약을 보장하지는 않습니다. 기존 페이지가 강조하던 미팅률과 전환율은 캠페인·조직·기간별 결과이며 고정 약속으로 사용하지 않습니다. | Consent verification does not guarantee meetings or contracts. Meeting and conversion rates cited on the previous page reflected specific campaigns, organizations and periods, not fixed commitments. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.6.note | ‘실시간’, ‘전량 검수’, ‘중복 없음’, ‘AS 가능’은 자동 보장이 아닙니다. 실제 적용 수준과 예외는 캠페인 계약, 시스템과 운영 인력 확인 후 확정합니다. | “Real-time,” “fully reviewed,” “no duplicates” and “after-sales support available” are not automatic guarantees. Actual service levels and exceptions depend on campaign contracts, systems and staffing checks. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.15.items.4.title | 계약률을 보장받으려는 경우 | Organizations seeking guaranteed contract rates | 정상: 원문의 부적합 고객 유형/예시/사전보장 어려움에 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.15.items.4.text | 보험DB는 상담 기회를 만드는 입력값이며 미팅·계약·매출을 확정하지 않습니다. | Insurance leads create consultation opportunities. They do not guarantee meetings, contracts or revenue. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.3.answer | 전달 주기와 예상 물량은 광고 유입, 퍼미션콜·검수 인력, 지역과 조건에 따라 달라집니다. “실시간”을 일괄 보장하지 않고 캠페인별 전달 SLA와 예외를 먼저 합의합니다. | Delivery frequency and expected volumes depend on ad acquisition, verification and review staffing, regions and criteria. We agree on campaign-specific delivery SLAs and exceptions rather than guarantee real-time delivery across all campaigns. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.6.question | 한 번 받은 DB는 다른 곳에 절대 중복 납품되지 않나요? | Can you guarantee a delivered lead will never be supplied elsewhere? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.body.1 | 가격, 수익, 원금 또는 투자 결과를 보장하지 않습니다. | We do not guarantee prices, returns, principal protection or investment outcomes. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.2.note | 수익·가격 상승·원금 보장 또는 투자 판단을 오인하게 하는 광고는 진행하지 않습니다. 집행 가능 여부는 법령과 매체 정책에 따라 달라질 수 있습니다. | We do not run ads that guarantee returns, price increases or principal protection, or mislead investment decisions. Eligibility depends on applicable laws and media policies. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.3.items.3.title | 보장성 카피가 필요한 경우 | Campaigns that depend on guaranteed outcomes | 정상: 원문의 부적합 고객 유형/예시/사전보장 어려움에 대응 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.faq.0.answer | 근거 없는 수익률, 가격 상승 또는 원금 보장을 암시하는 표현은 사용할 수 없습니다. 광고 가능 범위는 사업 유형, 법령과 매체 정책을 먼저 확인해야 합니다. | You cannot use unsupported return claims or wording that implies price increases or principal guarantees. Permitted advertising must first be assessed against the business type, applicable laws and media policies. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.faq.2.answer | CPA는 합의한 상담 신청을 측정하는 과금 구조입니다. 고객의 투자 판단과 결과, 서비스 계약이나 수익을 보장하지 않습니다. | CPA is a billing model based on agreed consultation requests. It does not guarantee customers' investment decisions or outcomes, service contracts or returns. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.body.1 | 특정 전환율이나 광고 성과를 보장하지 않습니다. | We do not guarantee specific conversion rates or campaign results. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.sections.3.items.3.title | 성과 보장만 원하는 경우 | Advertisers seeking guaranteed results | 정상: 원문의 부적합 고객 유형/예시/사전보장 어려움에 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.sections.3.items.3.text | 매체 결과는 시장·상품·예산과 데이터에 따라 달라져 사전 보장이 어렵습니다. | Media results depend on the market, product, budget and data, making advance guarantees difficult. | 정상: 원문의 부적합 고객 유형/예시/사전보장 어려움에 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.faq.1.answer | 보장할 수 없습니다. 상품 경쟁력, 제안, 랜딩페이지, 예산과 측정 환경이 함께 영향을 줍니다. 계정 진단에서 광고 외 병목도 함께 확인합니다. | We cannot guarantee that. Product competitiveness, your offer, landing page, budget and measurement setup all affect results. Our account review also checks bottlenecks outside advertising. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.body.1 | 특정 ROAS나 전환 결과를 보장하지 않습니다. | We do not guarantee specific ROAS or conversion results. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.faq.2.question | ROAS를 보장하나요? | Do you guarantee ROAS? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.body.1 | 조회수, 구독자 수 또는 전환 성과를 보장하지 않습니다. | We do not guarantee views, subscriber counts or conversions. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.sections.3.items.3.title | 조회수 보장만 원하는 경우 | Brands seeking guaranteed views | 정상: 원문의 부적합 고객 유형/예시/사전보장 어려움에 대응 | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.sections.3.items.3.text | 조회·구독 숫자를 확정하는 방식은 제공하지 않습니다. | We do not offer guaranteed view or subscriber counts. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.faq.2.question | 조회수나 구독자 증가를 보장하나요? | Do you guarantee growth in views or subscribers? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.basic.sections.2.note | 특정 키워드 순위와 반영 시점은 보장하지 않습니다. 사이트 상태에 따라 우선 작업은 달라질 수 있습니다. | We do not guarantee rankings for specific keywords or when changes will take effect. Initial priorities may vary with site condition. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.basic.faq.0.question | 베이직을 하면 검색 1위를 보장하나요? | Does Basic guarantee a number 1 search ranking? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.pro.sections.2.note | 특정 키워드의 순위나 일정 내 성과를 보장하지 않으며, 실제 실행 범위는 사이트 진단 후 정합니다. | We do not guarantee specific keyword rankings or results within a set period. We define the actual scope after reviewing your site. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.pro.faq.2.answer | 정확한 시점은 보장할 수 없습니다. 검색 반영과 경쟁 환경이 달라 변경 이력과 노출·유입 흐름을 관찰하며 다음 작업을 결정합니다. | We cannot guarantee an exact date. Search updates and competition vary, so we use change records, visibility and traffic patterns to decide the next steps. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.sections.2.note | 고경쟁 키워드의 특정 순위와 기간 내 성과를 보장하지 않습니다. 실제 범위는 진단과 실행 역량을 확인해 확정합니다. | We do not guarantee specific competitive keyword rankings or results within a set period. We confirm the scope after reviewing site needs and delivery capacity. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.faq.0.question | 엘리트는 무조건 가장 좋은 선택인가요? | Is Elite always the best choice? | 정상: 원문의 가장 좋은 선택이라는 질문 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.faq.2.question | 고경쟁 키워드 순위를 보장하나요? | Do you guarantee rankings for highly competitive keywords? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.lead | 제이커브는 특정 인기게시물 위치·기간이나 인위적 반응을 판매·접수하지 않습니다. 플랫폼이 최종 노출을 결정한다는 한계를 전제로 콘텐츠 관련성, 실제 고객 반응과 설명 가능한 배포 경로를 개선합니다. | We do not sell or accept orders for guaranteed top-post positions, durations or artificial engagement. The platform controls final visibility. We focus on content relevance, real customer response and traceable distribution channels. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.meta_description | 인스타그램 인기게시물 보장보다 콘텐츠 관련성, 실제 고객 반응, 공식 광고와 협업 기반의 발견 가능성을 검토하는 안내입니다. | A guide to improving discoverability through relevant content, real customer response, official ads and collaborations rather than guaranteed Instagram top-post placement. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.2.note | 인기게시물 진입, 노출 위치와 유지 기간은 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | We do not guarantee top-post inclusion, position or duration. Do not use methods that require giving an outside supplier your password or 2-step verification code. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.3.items.3.title | 결과 보장 금지 | Avoid guaranteed outcomes | 정상: 보장 배제/비교/금지 문맥 / 어색 — Avoid guaranteed outcomes는 보장을 금지하기보다 결과 자체를 피하라는 표현으로 읽힐 수 있음. | Do not guarantee outcomes |
| lang/en/subpages.php | boostingshop.items.instagram-popular.faq.0.question | 인기게시물 진입과 유지 기간이 보장되나요? | Do you guarantee top-post inclusion and duration? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.sections.2.note | 팔로워 증가 자체는 도달·참여·구매를 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | Follower growth alone does not guarantee reach, engagement or purchases. Do not use methods that require giving an outside supplier your password or 2-step verification code. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.faq.0.answer | 아닙니다. 인위적인 팔로워 수량을 판매하거나 보장하지 않습니다. 콘텐츠, 공식 광고와 협업처럼 유입 경로를 설명하고 측정할 수 있는 방법만 검토합니다. | No. We do not sell or guarantee artificial follower quantities. We consider only methods with explainable, measurable traffic sources, such as content, official ads and collaborations. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.faq.2.answer | 보장되지 않습니다. 팔로워 수와 실제 관심·구매 의도는 다를 수 있으므로 도달, 저장·댓글, 프로필 방문, 링크 클릭과 문의를 별도로 확인해야 합니다. | There is no guarantee. Follower counts may not reflect genuine interest or purchase intent. Review reach, saves, comments, profile visits, link clicks and inquiries separately. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.sections.2.note | 좋아요 증가 자체는 인기게시물 노출, 저장·문의 또는 매출을 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | More likes do not guarantee top-post visibility, saves, inquiries or sales. Do not use methods that require giving an outside supplier your password or 2-step verification code. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.faq.0.answer | 아닙니다. 인위적인 좋아요 수량을 판매하거나 보장하지 않습니다. 콘텐츠, 공식 광고와 협업처럼 유입 경로를 설명하고 측정할 수 있는 방법만 검토합니다. | No. We do not sell or guarantee artificial like quantities. We consider only methods with explainable, measurable traffic sources, such as content, official ads and collaborations. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.faq.2.answer | 보장되지 않습니다. 플랫폼 노출은 다양한 신호로 결정되며 좋아요 수와 실제 관심·구매 의도도 다를 수 있습니다. 저장, 공유, 프로필 방문과 문의를 함께 확인해야 합니다. | There is no guarantee. The platform uses many signals to determine visibility, and likes may not reflect genuine interest or purchase intent. Review saves, shares, profile visits and inquiries too. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/pages/faq.php | search_placeholder | 궁금한 내용을 검색하세요 — 예: 보장, 계정, 환불, 리포트 | Search your question — for example: guarantees, accounts, refunds, reports | 정상: 원문의 부적합 고객 유형/예시/사전보장 어려움에 대응 | 해당 없음 |
| lang/en/pages/faq.php | categories.start.items.3.q | 성과를 미리 보장하나요? | Do you guarantee results before a project starts? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.3.q | 매출이나 ROAS를 보장하나요? | Do you guarantee revenue or ROAS? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.3.a | 특정 매출이나 ROAS는 보장하지 않습니다. 대신 목표 전환, 테스트 기준, 중단·유지·확대 조건을 먼저 합의하고 같은 기준으로 결과를 판단합니다. | We do not guarantee specific revenue or ROAS. We agree on target conversions, test criteria and the conditions for stopping, continuing or scaling before we start, then assess results against the same criteria. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.6.q | 목표 물량을 보장하나요? | Do you guarantee the target volume? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.6.a | 고정 물량을 일괄적으로 보장하지 않습니다. 액션 난이도, 단가, 일정, 매체 가용성과 초기 운영 데이터를 확인한 뒤 가능한 범위를 협의합니다. | We do not offer a blanket guarantee of a fixed volume. We discuss the feasible range after reviewing the difficulty of the action, pricing, schedule, publisher availability and initial campaign data. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.12.q | 원하는 물량을 보장할 수 있나요? | Can you guarantee the volume we want? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.12.a | 고정 물량을 사전 보장하지 않습니다. 가용 물량은 타깃, 단가, 미션 난이도, 기간과 매체 상황에 따라 달라집니다. 초기 테스트에서 참여·승인 흐름을 확인한 뒤 확대 범위를 결정합니다. | We do not guarantee a fixed volume in advance. Available volume depends on targeting, pricing, mission difficulty, duration and publisher conditions. We review participation and acceptance in an initial test before deciding how far to scale. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.0.a | 사이트의 기술 상태, 경쟁도, 기존 콘텐츠와 검색엔진의 수집 주기에 따라 달라집니다. 고정 기간이나 특정 순위 시점을 보장하지 않으며, 색인·노출·클릭·전환의 선행 지표부터 확인합니다. | It depends on the site’s technical condition, competition, existing content and search engine crawl cycles. We do not guarantee a fixed timeframe or a date for reaching a specific ranking. We start by checking leading indicators such as indexing, visibility, clicks and conversions. | 정상: 선행 지표, 업계 선도 주장 아님 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.2.a | 링크만으로 해결되지 않습니다. 크롤링과 색인, 검색의도에 맞는 콘텐츠, 내부 링크, 출처의 관련성과 품질을 함께 봐야 합니다. 특정 링크 수나 순위 상승을 보장하지 않습니다. | Links alone cannot resolve every issue. Crawling and indexing, content that matches search intent, internal links, and the relevance and quality of sources all need to be reviewed together. We do not guarantee a specific number of links or a ranking increase. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.9.q | 답변 영역이나 AI 요약 노출을 보장하나요? | Do you guarantee visibility in answer sections or AI summaries? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.search.items.14.q | ChatGPT나 다른 AI의 추천을 보장하나요? | Do you guarantee recommendations from ChatGPT or other AI systems? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.0.q | 상위 노출을 보장하나요? | Do you guarantee top rankings? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.5.a | 아닙니다. 자체 분석에 따른 추정 정보이며 실제 거래액이나 향후 매출을 보장하지 않습니다. 상품성·원가·전환율 등 별도 자료와 함께 판단해야 합니다. | No. They are estimates based on our own analysis and do not guarantee actual transaction values or future revenue. Assess them alongside other information, such as product viability, costs and conversion rates. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.7.q | SEO 상품을 구매하면 상위 노출이 보장되나요? | Does buying an SEO package guarantee top rankings? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.9.a | 어떤 실행도 일률적인 안전을 보장할 수 없습니다. 콘텐츠·공식 광고·협업 방식, 계정 상태와 최신 약관·정책을 확인하고 필요한 최소 권한만 사용해야 합니다. | No approach can guarantee safety in every case. Review content, official advertising and collaboration methods, account status, and the latest terms and policies. Use only the minimum permissions needed. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/pages/faq.php | categories.self.items.10.q | 인기게시물 노출이나 반응 수치를 보장하나요? | Do you guarantee top-post visibility or engagement counts? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.1.a | 그렇게 보장되지 않습니다. 점수는 서비스 내 비교 정보이며 실제 상담 연결과 계약은 DB의 적법성·시점·대상, 담당자의 상담과 시장 상황 등 여러 요인의 영향을 받습니다. | That is not guaranteed. Scores provide comparisons within the service. Actual consultation contact and contracts depend on many factors, including the legality, timing and target audience of the leads, the agent’s consultation and market conditions. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.2.q | 입점 업체라는 이유만으로 DB의 적법성이 보장되나요? | Does a listed supplier automatically guarantee that its leads are lawful? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.4.q | DB를 구매하면 상담이나 계약이 보장되나요? | Does buying leads guarantee consultations or contracts? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.8.a | 정확성을 보장하지 않습니다. 분석은 패턴과 검토 지점을 찾는 보조 정보이며 관리자 또는 검수자가 통화 원자료와 상담 맥락을 함께 확인해야 합니다. | Accuracy is not guaranteed. The analysis supports the identification of patterns and points to review. A manager or reviewer must also check the original call data and consultation context. | 정상: 보장 배제/비교/금지 문맥 | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.11.q | 콜투세일이 DB의 적법성을 보장하나요? | Does Call2Sale guarantee that leads are lawful? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.3.q | 워드프레스로 만들면 검색 상위 노출이 보장되나요? | Does building with WordPress guarantee top search rankings? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.6.q | 선정이나 지원금 지급을 보장하나요? | Do you guarantee selection or payment of funding? | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/subpages.php | seo.items.naver-place.faq.0.question | 네이버 플레이스 상위 노출을 보장하나요? | NAVERプレイスの上位表示を保証しますか？ | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/subpages.php | seo.items.kakao-gift.faq.2.question | 노출 순위나 판매량을 보장하나요? | 表示順位や販売数を保証しますか？ | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/subpages.php | seo.items.coupang.faq.0.question | 쿠팡 검색 상위 노출을 보장하나요? | Coupang検索の上位表示を保証しますか？ | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/subpages.php | performance.items.facebook.faq.2.question | ROAS를 보장하나요? | ROASを保証しますか？ | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/subpages.php | performance.items.youtube.faq.2.question | 조회수나 구독자 증가를 보장하나요? | 再生回数や登録者数の増加を保証しますか？ | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.basic.faq.0.question | 베이직을 하면 검색 1위를 보장하나요? | ベーシックでは、検索1位を保証しますか？ | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/subpages.php | boostingshop.items.elite.faq.2.question | 고경쟁 키워드 순위를 보장하나요? | 競争の激しいキーワードの順位を保証しますか？ | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/pages/faq.php | categories.start.items.3.q | 성과를 미리 보장하나요? | 開始前に成果を保証しますか。 | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.3.q | 매출이나 ROAS를 보장하나요? | 売上やROASを保証しますか。 | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.6.q | 목표 물량을 보장하나요? | 目標件数を保証しますか。 | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.9.q | 답변 영역이나 AI 요약 노출을 보장하나요? | 回答欄やAI要約への表示を保証しますか。 | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/pages/faq.php | categories.search.items.14.q | ChatGPT나 다른 AI의 추천을 보장하나요? | ChatGPTなどのAIによる推薦を保証しますか。 | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/pages/faq.php | categories.self.items.0.q | 상위 노출을 보장하나요? | 上位表示を保証しますか。 | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/pages/faq.php | categories.self.items.10.q | 인기게시물 노출이나 반응 수치를 보장하나요? | 人気投稿への表示や反応数を保証しますか。 | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.11.q | 콜투세일이 DB의 적법성을 보장하나요? | Call2Saleはリードの適法性を保証しますか。 | 정상: 보장 여부를 묻는 질문 | 해당 없음 |
| lang/ja/pages/faq.php | categories.build.items.6.q | 선정이나 지원금 지급을 보장하나요? | 採択や支援金の支給を保証しますか。 | 정상: 보장 여부를 묻는 질문 | 해당 없음 |

## 9. U8 FAQ·개인정보 형상

| 언어 | FAQ 파일/DOM/JSON-LD 문항 | 분류별 수(원문 순서) | DOM=번역 파일 | JSON-LD=DOM | 분류 순서=한국어 |
| --- | --- | --- | --- | --- | --- |
| en | 81/81/81 | {'start': 11, 'ads': 18, 'search': 15, 'self': 14, 'crm': 13, 'build': 10} | True | True | True |
| ja | 81/81/81 | {'start': 11, 'ads': 18, 'search': 15, 'self': 14, 'crm': 13, 'build': 10} | True | True | True |

한국어와 번역의 각 분류 인덱스별 원문/번역 q/a는 U5·U6·U9 목록에서 직접 확인했다. FAQPage는 @context/@type, mainEntity 질문·acceptedAnswer를 파싱했고 질문·답변 배열 전체가 DOM 목록과 동일하다. 한국어도 별도로 81개/6분류임을 추출했다.

| 언어 | 조항 수 | 모든 조항 렌더 | 원문 우선 고지 렌더 | 고지가 서문 앞 | 이메일 보존 | 전화 보존 |
| --- | --- | --- | --- | --- | --- | --- |
| en | 4 | True | True | True | True | True |
| ja | 4 | True | True | True | True | True |

| 파일 | 키 | 한국어 | 번역 | 판정 | 대안 |
| --- | --- | --- | --- | --- | --- |
| lang/en/pages/privacy.php | introduction | (주)제이커브인터렉티브(이하 "회사")는 이용자의 개인정보를 중요하게 생각하며, 「개인정보 보호법」 등 관련 법령을 준수합니다. | J-Curve Interactive Co., Ltd. (the “Company”) values users’ personal information and complies with applicable laws and regulations, including Korea’s Personal Information Protection Act. | OK | 해당 없음 |
| lang/en/pages/privacy.php | closing | 본 방침은 관련 법령 및 회사 정책에 따라 변경될 수 있으며, 변경 시 웹사이트를 통해 공지합니다. | This policy may be changed in accordance with applicable laws and regulations and Company policies. Any changes will be announced on the website. | OK | 해당 없음 |
| lang/en/pages/privacy.php | sections.0.0 | 1. 수집하는 개인정보 항목 | 1. Categories of personal information collected | OK | 해당 없음 |
| lang/en/pages/privacy.php | sections.0.1 | 회사는 상담 문의 및 서비스 제공을 위해 이름, 연락처, 이메일, 회사명, 문의 내용을 수집할 수 있습니다. | The Company may collect names, contact details, email addresses, company names and inquiry details for consultation inquiries and the provision of services. | OK | 해당 없음 |
| lang/en/pages/privacy.php | sections.1.0 | 2. 개인정보의 수집 및 이용 목적 | 2. Purposes of collecting and using personal information | OK | 해당 없음 |
| lang/en/pages/privacy.php | sections.1.1 | 수집한 개인정보는 상담 응대, 서비스 제공, 계약의 이행 및 고객 관리를 위해 이용됩니다. | The personal information collected is used to respond to consultations, provide services, perform contracts and manage customer relationships. | OK | 해당 없음 |
| lang/en/pages/privacy.php | sections.2.0 | 3. 개인정보의 보유 및 이용 기간 | 3. Retention and use periods for personal information | OK | 해당 없음 |
| lang/en/pages/privacy.php | sections.2.1 | 원칙적으로 개인정보 수집·이용 목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 관련 법령에 따라 보존할 필요가 있는 경우 해당 기간 동안 보관합니다. | In principle, the personal information concerned is destroyed without delay after the purposes of collection and use have been achieved. However, where retention is necessary under applicable laws and regulations, the information is retained for the applicable period. | OK | 해당 없음 |
| lang/en/pages/privacy.php | sections.3.0 | 4. 개인정보 보호책임자 | 4. Personal information protection officer | OK | 해당 없음 |
| lang/en/pages/privacy.php | sections.3.1 | 개인정보 관련 문의는 대표 이메일(jcurve19@gmail.com) 또는 대표전화(02-1668-2612)로 연락 주시기 바랍니다. | For inquiries concerning personal information, please contact the Company’s main email address (jcurve19@gmail.com) or main telephone number (02-1668-2612). | OK | 해당 없음 |
| lang/ja/pages/privacy.php | introduction | (주)제이커브인터렉티브(이하 "회사")는 이용자의 개인정보를 중요하게 생각하며, 「개인정보 보호법」 등 관련 법령을 준수합니다. | J-Curve Interactive Co., Ltd.（以下「当社」といいます。）は、利用者の個人情報を重視し、韓国の「個人情報保護法」等の関連法令を遵守します。 | OK | 해당 없음 |
| lang/ja/pages/privacy.php | closing | 본 방침은 관련 법령 및 회사 정책에 따라 변경될 수 있으며, 변경 시 웹사이트를 통해 공지합니다. | 本方針は、関連法令および当社の方針に基づいて変更される場合があります。変更の際は、Webサイトを通じてお知らせします。 | OK | 해당 없음 |
| lang/ja/pages/privacy.php | sections.0.0 | 1. 수집하는 개인정보 항목 | 1. 収集する個人情報の項目 | OK | 해당 없음 |
| lang/ja/pages/privacy.php | sections.0.1 | 회사는 상담 문의 및 서비스 제공을 위해 이름, 연락처, 이메일, 회사명, 문의 내용을 수집할 수 있습니다. | 当社は、ご相談への対応およびサービスの提供のため、氏名、連絡先、メールアドレス、会社名、お問い合わせ内容を収集することがあります。 | OK | 해당 없음 |
| lang/ja/pages/privacy.php | sections.1.0 | 2. 개인정보의 수집 및 이용 목적 | 2. 個人情報の収集および利用目的 | OK | 해당 없음 |
| lang/ja/pages/privacy.php | sections.1.1 | 수집한 개인정보는 상담 응대, 서비스 제공, 계약의 이행 및 고객 관리를 위해 이용됩니다. | 収集した個人情報は、ご相談への対応、サービスの提供、契約の履行および顧客管理のために利用します。 | OK | 해당 없음 |
| lang/ja/pages/privacy.php | sections.2.0 | 3. 개인정보의 보유 및 이용 기간 | 3. 個人情報の保有および利用期間 | OK | 해당 없음 |
| lang/ja/pages/privacy.php | sections.2.1 | 원칙적으로 개인정보 수집·이용 목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 관련 법령에 따라 보존할 필요가 있는 경우 해당 기간 동안 보관합니다. | 原則として、個人情報の収集・利用目的が達成された後は、当該情報を遅滞なく破棄します。ただし、関連法令に基づき保存する必要がある場合は、該当する期間保管します。 | OK | 해당 없음 |
| lang/ja/pages/privacy.php | sections.3.0 | 4. 개인정보 보호책임자 | 4. 個人情報保護責任者 | OK | 해당 없음 |
| lang/ja/pages/privacy.php | sections.3.1 | 개인정보 관련 문의는 대표 이메일(jcurve19@gmail.com) 또는 대표전화(02-1668-2612)로 연락 주시기 바랍니다. | 個人情報に関するお問い合わせは、当社の代表メールアドレス（jcurve19@gmail.com）または代表電話（02-1668-2612）までご連絡ください。 | OK | 해당 없음 |

한국어는 고정 연/월 보유기간이나 규제기관 이름을 명시하지 않는다. 따라서 없는 기간/기관을 번역에 만들지 않았는지도 확인했다. 명시된 법령 「개인정보 보호법」은 Personal Information Protection Act / 韓国の「個人情報保護法」로, 목적 달성 후 지체 없는 파기·법령상 예외 보유도 그대로 남았다.

## 10. U9 무작위 표본·의심 건 직접 품질 판정

Python 3.14의 `random.Random(seed).sample(pool, 30)`을 사용했다. pool은 사람용 원문 대응 잎을 `(file, key)`로 정렬한 언어별 1,422개이며, 영어 seed=2026110304, 일본어 seed=2026110305. 기술값은 제외하되 영어로 이미 쓰인 사람용 eyebrow와 반복 라벨은 임의로 빼지 않았다. 아래는 추출 순서를 유지한 30개씩 전부다.

| # | 파일 | 키 | 한국어 | 번역 | 판정 | 근거 | 대안 |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | lang/en/pages/faq.php | categories.start.items.5.q | 프로젝트는 어떤 기준으로 시작하나요? | What needs to be in place before a project starts? | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 2 | lang/en/subpages.php | boostingshop.items.instagram-popular.cta.title | 노출 자리를 사기보다, 발견될 이유를 만드세요 | Give people a reason to discover you | 오역 | 노출 자리를 사기보다라는 대조·서비스 경계가 잎 전체에서 누락됨. | Build reasons to be discovered instead of buying placement. |
| 3 | lang/en/subpages.php | performance.items.youtube.faq.2.question | 조회수나 구독자 증가를 보장하나요? | Do you guarantee growth in views or subscribers? | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 4 | lang/en/pages/faq.php | categories.ads.items.4.from.1 | 퍼포먼스 마케팅 | Performance marketing | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 5 | lang/en/subpages.php | cpa.items.insurance.faq.8.question | 지역과 월 희망 물량을 지정할 수 있나요? | Can we specify regions and monthly volumes? | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 6 | lang/en/pages/faq.php | categories.crm.items.4.from.1 | 리드베이 | LeadBay | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 7 | lang/en/subpages.php | cpa.items.insurance.sections.0.items.2.title | 콜투세일 · 공급 조직 | Call2Sale · lead suppliers | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 8 | lang/en/subpages.php | boostingshop.items.instagram-likes.sections.1.items.3.title | 협업과 교차 유입 | Connect collaborations and traffic sources | 어색 | traffic sources만으로 교차 유입의 방향성이 잘 드러나지 않음. | Collaborations and cross-referral traffic |
| 9 | lang/en/subpages.php | cpa.items.insurance.sections.6.items.0.text | 신청·확인·전달 시간을 기록하고, 오래된 DB와 신규 DB가 섞이지 않도록 캠페인별 납품 주기와 예상 물량을 합의합니다. | Record request, verification and delivery times. Agree on campaign delivery cycles and expected volumes so older and new leads are not mixed. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 10 | lang/en/subpages.php | seo.items.naver-shopping.sections.2.eyebrow | Optimization Scope | Optimization scope | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 11 | lang/en/subpages.php | boostingshop.items.instagram-popular.sections.1.items.1.title | 콘텐츠 포맷 개선 | Improve content formats | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 12 | lang/en/subpages.php | cpa.items.stock.sections.1.items.2.text | 과장 없이 서비스를 이해할 정보와 전환 기록 지점을 배치합니다. | We provide the information needed to understand the service without exaggeration, alongside conversion tracking points. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 13 | lang/en/pages/faq.php | categories.search.items.10.from.1 | GEO | GEO | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 14 | lang/en/subpages.php | seo.items.naver-shopping.eyebrow | Commerce SEO | Commerce SEO | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 15 | lang/en/subpages.php | seo.items.naver-shopping.sections.3.items.2.text | 출시 전부터 카테고리·속성·콘텐츠 기준을 만들고 싶은 경우. | You want category, attribute and content standards in place before launch. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 16 | lang/en/pages/faq.php | categories.ads.items.10.q | 어떤 액션으로 캠페인을 만들 수 있나요? | Which actions can a reward campaign target? | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 17 | lang/en/pages/faq.php | categories.ads.items.12.q | 원하는 물량을 보장할 수 있나요? | Can you guarantee the volume we want? | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 18 | lang/en/subpages.php | cpa.items.insurance.sections.4.columns.1 | 일반 랜딩 신청 DB | Standard landing page leads | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 19 | lang/en/pages/faq.php | categories.self.items.13.q | 무엇을 사야 할지 모르겠으면 어떻게 하나요? | What should we do if we do not know what to buy? | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 20 | lang/en/pages/faq.php | categories.start.items.7.a | 가능합니다. 현재 목표와 가장 답답한 지점을 적어주시면 광고, 측정, 콘텐츠, 사이트 중 먼저 확인할 영역부터 정리합니다. | Yes. Tell us your current goals and biggest bottleneck. We will identify what to review first across advertising, measurement, content and your website. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 21 | lang/en/subpages.php | performance.items.facebook.faq.2.question | ROAS를 보장하나요? | Do you guarantee ROAS? | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 22 | lang/en/subpages.php | boostingshop.items.instagram-popular.sections.2.items.3 | 링크 클릭, 문의와 구매처럼 사업에 가까운 후속 행동 | Business-focused follow-up actions, such as link clicks, inquiries and purchases | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 23 | lang/en/subpages.php | cpa.items.coin.body.1 | 가격, 수익, 원금 또는 투자 결과를 보장하지 않습니다. | We do not guarantee prices, returns, principal protection or investment outcomes. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 24 | lang/en/pages/faq.php | categories.crm.items.9.q | AI 점수로 인사평가를 자동화해도 되나요? | Can we automate staff performance evaluations using AI scores? | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 25 | lang/en/subpages.php | cpa.items.real-estate.sections.3.items.1.text | 가격·일정·입지 등 광고 설명의 근거를 제공할 수 있는 경우. | You can provide evidence for advertised prices, schedules and location details. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 26 | lang/en/subpages.php | boostingshop.items.instagram-popular.meta_description | 인스타그램 인기게시물 보장보다 콘텐츠 관련성, 실제 고객 반응, 공식 광고와 협업 기반의 발견 가능성을 검토하는 안내입니다. | A guide to improving discoverability through relevant content, real customer response, official ads and collaborations rather than guaranteed Instagram top-post placement. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 27 | lang/en/subpages.php | boostingshop.items.instagram-followers.faq.1.question | 어떤 성장 방법을 상담할 수 있나요? | What growth methods can we discuss? | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 28 | lang/en/pages/faq.php | categories.search.items.11.a | 아닙니다. 기존 공식 페이지, 회사 자료, 서비스 문서와 콘텐츠를 먼저 감사해 재사용할 수 있는 근거와 불일치를 찾습니다. 부족한 질문과 근거만 우선순위에 따라 보강합니다. | No. We first audit existing official pages, company information, service documentation and content to identify reusable evidence and inconsistencies. We prioritize filling gaps in questions and supporting evidence. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 29 | lang/en/subpages.php | cpa.items.insurance.sections.4.columns.0 | 판단 항목 | Assessment area | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 30 | lang/en/pages/faq.php | categories.search.items.7.from.1 | AEO | AEO | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 31 | lang/ja/pages/faq.php | categories.ads.items.15.from.1 | 리워드 네트워크 | リワード広告ネットワーク | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 32 | lang/ja/subpages.php | cpa.items.insurance.sections.8.rows.4.2 | AS 포함 여부와 인정 기간·증빙을 별도로 합의 | アフターサポートの対象かどうかと、有効認定の期間・証拠を別途合意 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 33 | lang/ja/subpages.php | seo.items.naver-shopping.sections.1.items.2.text | 상품명, 속성, 이미지와 상세페이지를 사실 기반으로 재정렬합니다. | 商品名、属性、画像、商品詳細ページを事実に基づいて整理し直します。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 34 | lang/ja/subpages.php | seo.items.backlinks.sections.3.items.3.text | 사이트가 막 개설됐거나 콘텐츠가 거의 없다면 내부 최적화부터 권합니다. | 開設直後やコンテンツがほとんどないサイトには、まず内部最適化をおすすめします。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 35 | lang/ja/pages/faq.php | categories.search.items.6.from.1 | AEO | AEO | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 36 | lang/ja/pages/faq.php | categories.build.items.8.q | 지원금으로 모든 마케팅 비용을 집행할 수 있나요? | 支援金ですべてのマーケティング費用を支出できますか。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 37 | lang/ja/pages/privacy.php | closing | 본 방침은 관련 법령 및 회사 정책에 따라 변경될 수 있으며, 변경 시 웹사이트를 통해 공지합니다. | 本方針は、関連法令および当社の方針に基づいて変更される場合があります。変更の際は、Webサイトを通じてお知らせします。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 38 | lang/ja/subpages.php | cpa.items.permission-call.faq.1.question | 기존에 보유한 DB도 바로 사용할 수 있나요? | すでに保有しているリードも、そのまま使えますか？ | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 39 | lang/ja/subpages.php | cpa.items.insurance.sections.12.items.3.text | 계약·포인트·후정산 업무를 현재 시스템 제공 범위와 조직 권한에 맞춰 관리합니다. | 契約・ポイント・後払い精算の業務を、現在のシステムの提供範囲と組織の権限に合わせて管理します。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 40 | lang/ja/subpages.php | performance.items.youtube.sections.3.title | 이런 브랜드에 적합합니다 | このようなブランドに適しています | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 41 | lang/ja/subpages.php | performance.items.facebook.cta.label | 메타 광고 진단 문의 | Meta広告の診断を相談する | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 42 | lang/ja/subpages.php | seo.items.backlinks.sections.1.items.1.text | 비즈니스 목표와 검색 의도에 맞춰 링크가 필요한 페이지의 우선순위를 정합니다. | 事業目標と検索意図に沿って、被リンクが必要なページの優先順位を決めます。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 43 | lang/ja/pages/faq.php | categories.crm.items.5.from.1 | 리드베이 | LeadBay | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 44 | lang/ja/subpages.php | cpa.items.insurance.sections.9.items.2.title | 대량 운영 광고주 | 大量に運用する広告主 | 어색 | 大量に運用する는 광고 운영 규모를 나타내는 비즈니스 일본어로 부자연스러움. | 大規模な運用を行う広告主 |
| 45 | lang/ja/subpages.php | boostingshop.items.elite.sections.2.eyebrow | Scope | Scope | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 46 | lang/ja/pages/faq.php | categories.crm.items.3.a | 아닙니다. 서비스는 관리 흐름을 돕지만 거래·이용 주체의 법적·계약상 책임을 대신하지 않습니다. 조직의 기준과 필요한 전문 검토가 별도로 필요합니다. | いいえ。サービスは管理の流れを支援しますが、取引・利用主体の法的責任や契約上の責任を代わりに負うものではありません。組織としての基準と、必要な専門家による確認は別途必要です。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 47 | lang/ja/subpages.php | boostingshop.items.instagram-likes.sections.3.items.3.title | 성과 해석 분리 | 成果の解釈を分ける | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 48 | lang/ja/subpages.php | seo.items.kakao-gift.sections.2.eyebrow | Check List | Check List | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 49 | lang/ja/pages/faq.php | cta_heading | 찾는 답이 없나요? | お探しの回答が見つかりませんか。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 50 | lang/ja/subpages.php | cpa.items.insurance.sections.9.items.5.title | 기존 콜센터 보유 조직 | 自社コールセンターを持つ組織 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 51 | lang/ja/pages/faq.php | categories.search.items.7.from.1 | AEO | AEO | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 52 | lang/ja/subpages.php | seo.items.naver-shopping.sections.1.items.1.text | 고객이 비교하는 기준과 상품별 핵심 검색어를 분류합니다. | お客様の比較基準と、商品ごとの主要な検索語句を分類します。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 53 | lang/ja/subpages.php | boostingshop.items.instagram-popular.sections.2.items.0 | 도달과 비팔로워 도달의 변화 | リーチと非フォロワーへのリーチの変化 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 54 | lang/ja/subpages.php | performance.items.naver-gfa.meta_description | 캠페인 목표, 전환 측정, 오디언스, 소재 테스트와 운영 리포트를 연결하는 네이버 GFA 광고 대행 서비스입니다. | 目標、コンバージョン測定、オーディエンス、クリエイティブのテスト、運用レポートをつなぐNAVER GFA広告の運用代行サービスです。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 55 | lang/ja/subpages.php | seo.items.backlinks.sections.2.items.3 | 게재 URL, 연결 대상, 확인 시점을 포함한 관리 기록 | 掲載URL・リンク先・確認時点を含む管理記録 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 56 | lang/ja/subpages.php | cpa.items.coin.faq.2.question | CPA면 상담 이후 투자 결과도 책임지나요? | CPAでは、相談後の投資結果にも責任を負いますか？ | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 57 | lang/ja/subpages.php | seo.items.naver-place.faq.0.question | 네이버 플레이스 상위 노출을 보장하나요? | NAVERプレイスの上位表示を保証しますか？ | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 58 | lang/ja/pages/faq.php | project_direct | 프로젝트 문의(1:1) | プロジェクトのご相談（1:1） | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 59 | lang/ja/subpages.php | cpa.items.real-estate.sections.3.items.2.title | 피드백을 공유할 수 있는 팀 | フィードバックを共有できるチーム | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| 60 | lang/ja/subpages.php | boostingshop.items.instagram-followers.sections.2.items.1 | 저장·공유·댓글과 프로필 방문 행동 | 保存・共有・コメント・プロフィール訪問 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |

### U5 미검출 17잎 추가 직접 검토

| 파일 | 키 | 한국어 | 번역 | 판정 | 근거 | 대안 |
| --- | --- | --- | --- | --- | --- | --- |
| lang/en/subpages.php | seo.items.naver-shopping.lead | 네이버 쇼핑 SEO는 상품명 한 줄을 바꾸는 작업이 아닙니다. 카테고리와 속성, 가격·배송 정보, 대표 이미지와 상세페이지가 고객의 검색 의도에 맞게 연결되도록 상품 데이터를 구조적으로 정비합니다. | NAVER Shopping — NAVER's product search and shopping hub. SEO here requires more than changing a product name. We organize categories, attributes, pricing, delivery details, main images and product pages around your customers' search intent. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.sections.0.paragraphs.1 | 제이커브는 노출 요소와 구매 설득 요소를 분리하지 않습니다. 상품 데이터의 정확성부터 클릭 이후의 정보 구조까지 한 흐름으로 봅니다. | We review visibility and purchase decisions together, from accurate product data to the structure of information after the click. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.lead | 부동산 분양 CPA는 상담 신청이 들어왔다는 사실만 세는 광고가 아닙니다. 사업지와 공급 조건을 정확히 설명하고, 고객의 연락 동의와 유효 DB 기준, 상담 후 피드백까지 연결해야 품질을 관리할 수 있습니다. | CPA marketing for real estate pre-sale (new developments) goes beyond counting consultation requests. Quality depends on accurate project and sales information, consent to contact, valid lead criteria and feedback from consultations. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.lead | 보험디비는 전화번호 한 건을 전달하는 상품이 아닙니다. 광고 유입, 퍼미션콜, 동의·녹취 확인, 중복 기준, 지역·조건 매칭, 미팅 조정, AS와 영업 피드백이 이어져야 실제 상담 기회가 됩니다. | An insurance lead is more than a phone number. It becomes a genuine consultation opportunity when ad acquisition, consent verification calls, consent and recording checks, duplicate criteria, location and eligibility matching, meeting coordination, after-sales support and sales feedback work together. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.6.items.2.text | 한 광고주 전용 여부, 중복 확인 기간, 식별값, 기존 보유 DB 대조와 재제공 금지 범위를 집행 전에 문서화합니다. | Before launch, document advertiser exclusivity, duplicate check windows, identifiers, checks against existing leads and limits on onward supply. | 어색 | limits on onward supply는 재제공 금지 범위의 강도를 명확히 드러내지 않음. | Before launch, document advertiser exclusivity, duplicate-check windows, identifiers, checks against existing leads and the scope of the prohibition on resupplying leads. |
| lang/en/subpages.php | cpa.items.insurance.sections.14.title | “동의받은 DB” 한 문장으로 끝내지 않습니다 | “Consented leads” is the start of the review | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.3.answer | 전달 주기와 예상 물량은 광고 유입, 퍼미션콜·검수 인력, 지역과 조건에 따라 달라집니다. “실시간”을 일괄 보장하지 않고 캠페인별 전달 SLA와 예외를 먼저 합의합니다. | Delivery frequency and expected volumes depend on ad acquisition, verification and review staffing, regions and criteria. We agree on campaign-specific delivery SLAs and exceptions rather than guarantee real-time delivery across all campaigns. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.0.paragraphs.0 | 가상자산 광고는 고객의 기대를 과도하게 자극하기 쉽고, 사업 유형과 매체에 따라 집행 제한도 달라질 수 있습니다. 강한 카피를 먼저 만드는 방식은 적합하지 않습니다. | Crypto ads can easily create unrealistic expectations. Restrictions also vary by business type and media platform. Starting with bold copy is the wrong approach. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.lead | 퍼미션 콜은 단순히 체크박스를 받는 일이 아닙니다. 누가, 어떤 목적으로, 어떤 채널로 연락하는지 고객이 이해하고 동의해야 하며, 그 범위와 시점을 증명할 기록과 철회 절차가 함께 있어야 합니다. | Consent-based calling requires more than a checkbox. Customers must understand and agree to who will contact them, why and through which channel. You also need records of the consent scope and timing, plus a withdrawal process. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.facebook.lead | 메타 광고는 타게팅 설정만으로 끝나지 않습니다. 전환 이벤트와 퍼널, 고객에게 말을 거는 소재, 랜딩 경험을 함께 설계하고 학습 데이터를 잃지 않도록 테스트 단위를 관리해야 합니다. | Meta advertising requires more than targeting settings. We design conversion events, funnels, relevant creative and landing experiences together, and control test scope to preserve useful learning data. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.lead | 유튜브 마케팅은 영상을 많이 올리거나 조회수를 사는 일이 아닙니다. 누구에게 어떤 문제를 어떤 형식으로 설명할지 정하고, 광고와 채널 콘텐츠의 역할을 나눠 시청 이후 검색·방문·문의로 이어지는 흐름을 만듭니다. | YouTube marketing is more than uploading videos or buying views. We define the audience, problem and format, then give ads and channel content distinct roles that lead viewers toward searches, visits and inquiries. | 오역 | 조회수 구매를 부정한 원문을 more than으로 바꿔 구매도 업무의 일부인 듯한 여지를 만듦. | YouTube marketing is not about uploading large numbers of videos or buying views. We define the audience, the problem to address and the format, then give ads and channel content distinct roles that lead viewers toward searches, visits and inquiries. |
| lang/en/subpages.php | boostingshop.items.elite.sections.0.title | 고경쟁 SEO는 한두 페이지 수정으로 끝나지 않습니다 | Competitive SEO takes more than edits to a few pages | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.sections.3.items.3.title | 결과 보장 금지 | Avoid guaranteed outcomes | 어색 | Avoid guaranteed outcomes는 보장을 금지하기보다 결과 자체를 피하라는 표현으로 읽힐 수 있음. | Do not guarantee outcomes |
| lang/en/subpages.php | boostingshop.items.instagram-followers.body.0 | 팔로워 숫자와 실제 도달·참여·문의는 같은 지표가 아닙니다. 계정 목표와 고객 행동을 기준으로 성장 방식을 판단합니다. | Follower counts, actual reach, engagement and inquiries are different metrics. Assess growth methods against account goals and customer actions. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.sections.0.title | 팔로워 수와 실제 고객 성장은 같은 지표가 아닙니다 | Follower counts and real customer growth measure different things | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.body.0 | 좋아요 숫자와 실제 저장·공유·문의는 같은 지표가 아닙니다. 게시물 목적과 고객 행동을 기준으로 참여 확대 방식을 판단합니다. | Like counts, actual saves, shares and inquiries are different metrics. Assess engagement methods against the post's purpose and customer actions. | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.3.items.3.text | 보장성 표현이나 오인을 유발하는 구조는 진행 대상이 아닙니다. | 保証をうたう表現や誤認を招く仕組みは対応対象外です。 | OK | 원문의 뜻·조건을 유지함. | 해당 없음 |

### U6 지정 대응 미검출 119잎 추가 직접 검토

동형어/상담원/문맥상 참조 때문에 생긴 정규식 미검출을 오역으로 처리하지 않았다. 보험 비교 제목의 비교 대상 누락은 의미 결함으로 구분했다. 원문·번역·대안은 아래에 중복을 감수하고 전부 남긴다.

| 파일 | 키 | 한국어 | 번역 | 판정 | 근거 | 대안 |
| --- | --- | --- | --- | --- | --- | --- |
| lang/en/subpages.php | seo.items.backlinks.meta_description | 10년간 1,000여 개의 SEO 프로젝트를 성공적으로 수행하며 얻은 검색엔진최적화에 대한 깊은 이해와 경험을 바탕으로 제공하는 전문 백링크 서비스로 검색엔진 상위노출을 경험하세요. 구글과 네이버에 최적화된 검증된 고품질 백링크 전략은 자연스러운 순위 상승을 돕습니다. 무료 컨설팅을 신청하세요. | Our specialist backlink service draws on deep SEO knowledge gained from successfully delivering over 1,000 SEO projects in 10 years. Our proven, quality backlink strategies for Google and NAVER — Korea's largest search portal — support natural ranking improvements. Request a free consultation. | OK | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.seo_title | 네이버 플레이스 상위노출 마케팅, 전문가의 노출 최적화로 매출 상승 | NAVER Place ranking services — expert visibility optimization to grow sales | OK | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-place.meta_description | 네이버 플레이스 상위노출 마케팅 성공은 제이커브와 함께! 풍부한 SEO 노하우로 순위 상승, 방문자 증가, 매출 상승을 실현하는 최적의 전략을 제공합니다. | Work with J-Curve on NAVER Place rankings. Drawing on extensive SEO experience, we develop strategies to improve rankings, increase visits and grow sales. | OK | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.seo_title | 네이버쇼핑 상위노출 마케팅 전문가의 노하우로 매출 UP | Grow sales with specialist NAVER Shopping ranking expertise | OK | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.naver-shopping.meta_description | 네이버쇼핑 상위노출 마케팅을 위한 SEO는 제이커브에게 맡기세요! 10년 이상 풍부한 노하우로 상품 노출 극대화, 클릭률 향상, 매출 증대를 실현시켜 드립니다. | Trust J-Curve with SEO for higher NAVER Shopping rankings. We draw on over 10 years of experience to maximize product visibility, improve click-through rates and grow sales. | OK | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.seo_title | 카카오선물하기 상위노출로 비즈니스 성장을 경험하세요 - SEO 전문 컨설팅 기업 &#124; 제이커브인터렉티브 | Grow your business with top Kakao Gift rankings — SEO specialists &#124; J-Curve Interactive | OK | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.kakao-gift.meta_description | 카카오선물하기 상위노출 마케팅 — 선물 대상·상황·가격대별 탐색 의도와 상품 정보, 이미지, 상세 설명을 함께 정비하는 제이커브 SEO 서비스입니다. 무료 컨설팅을 신청하세요. | J-Curve's Kakao Gift SEO service reviews search intent by recipient, occasion and price range alongside product details, images and descriptions. Request a free consultation about improving rankings. | OK | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.seo_title | 쿠팡 상위노출로 매출 상승의 기회를 잡으세요 - SEO 전문 컨설팅 기업 &#124; 제이커브인터렉티브 | Create opportunities to grow sales with top Coupang rankings — SEO specialists &#124; J-Curve Interactive | OK | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.meta_description | 쿠팡 상위노출 마케팅 — 카테고리·옵션·상품명·이미지·배송 정보와 상세페이지를 함께 점검하는 제이커브 쿠팡 상품 검색 최적화 서비스입니다. 무료 컨설팅을 신청하세요. | J-Curve's Coupang product SEO service reviews categories, options, names, images, delivery information and product pages together. Request a free consultation about improving rankings. | OK | 상위노출 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | seo.items.coupang.sections.0.title | 상품 데이터가 흩어지면 고객도 알고리즘도 이해하기 어렵습니다 | Scattered product data is hard for customers and algorithms to understand | OK | 지면=흩어지면의 일부, 광고 지면 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.meta_description | 사업지 정보, 상담 신청 기준, 개인정보 동의, 트래킹과 상담 피드백을 함께 설계하는 부동산 분양 CPA 마케팅입니다. | CPA marketing for real estate pre-sales that connects project information, consultation request criteria, privacy consent, tracking and consultation feedback. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.hero_cta | 분양 CPA 구조 상담 | Discuss a real estate CPA campaign | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.0.paragraphs.1 | 캠페인 시작 전에 사업지의 사실 정보, 목표 고객, 유효·무효 기준과 상담 대응 시간을 합의해야 광고 데이터를 영업 결과와 연결할 수 있습니다. | Before launch, agree on project facts, target customers, valid and invalid lead criteria, and response times. This connects campaign data to sales results. | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.sections.2.items.2 | 개인정보 수집·이용 및 상담 연락 동의 문구 | Consent wording for personal data collection, use and consultation contact | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.faq.2.question | 개인정보 동의도 함께 설계하나요? | Do you help design privacy consent? | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.real-estate.cta.label | 분양 CPA 구조 상담 | Discuss a real estate CPA campaign | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.hero_cta | 주식 CPA 적합성 상담 | Discuss stock-investor CPA eligibility | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.sections.2.items.2 | 개인정보 수집·상담 연락 동의 및 보유 기준 | Consent for data collection and consultation contact, with retention rules | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.stock.cta.label | 주식 CPA 적합성 상담 | Discuss stock-investor CPA eligibility | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.hero_cta | 보험 DB 운영 상담 | Discuss insurance lead operations | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.items.1.text | DB 업체·조건 비교부터 배분, 상담 일정, 계약, AS와 정산까지 영업조직의 활용 과정을 관리합니다. | Manage how your sales organization uses leads, from comparing suppliers and terms to allocation, appointments, contracts, after-sales support and settlement. | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.items.2.text | 보험DB 콜센터의 원천 DB, 상담원 배분, 콜 품질, 납품, AS와 정산 업무를 관리합니다. | Manage source leads, agent allocation, call quality, delivery, after-sales support and settlement for insurance lead call centers. | OK | 상담원=agent/operator, 상담 용어 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.0.note | 실제 광고, DB 공급과 솔루션 연동 범위는 조직의 계약 구조, 시스템과 개인정보 처리 역할을 확인한 뒤 확정합니다. | We finalize the advertising, lead supply and platform integration scope after reviewing your contracts, systems and personal data processing responsibilities. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.3.note | 이 페이지는 법률 자문이 아닙니다. 실제 캠페인은 적용 법령, 금융·보험 광고 기준, 개인정보 처리 역할과 광고주 내부 준법 기준을 별도로 확인해야 합니다. | This page is not legal advice. Each campaign needs separate checks against applicable laws, financial and insurance advertising standards, data processing responsibilities and the advertiser's internal compliance rules. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.4.title | 일반 신청 DB와 퍼미션 DB의 차이는 ‘전달 전 확인’입니다 | The difference is verification before delivery | 오역 | DB 지정 표현 미일치(아래 품질 판정 함께 참고); 일반 신청 DB와 퍼미션 DB라는 두 비교 대상을 제목에서 모두 삭제함. | The difference between standard application leads and consent-based leads is verification before delivery. |
| lang/en/subpages.php | cpa.items.insurance.sections.4.rows.2.2 | 상담 의사·주제·지역·일정 등 합의한 조건을 재확인 | Agreed details such as intent, topic, location and schedule are reconfirmed | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.4.rows.3.1 | 부재·오인·중복 원인을 상담원이 직접 분류 | Agents must classify no-answer, misunderstanding and duplicate cases themselves | OK | 상담원=agent/operator, 상담 용어 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.8.rows.4.2 | AS 포함 여부와 인정 기간·증빙을 별도로 합의 | Separately agree on support eligibility, claim windows and evidence | OK | 인정 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.10.items.2.text | 상담 일정, 메모, 연락과 진행 상태를 남겨 담당자와 후속 조치를 놓치지 않게 관리합니다. | Record appointments, notes, contact and progress so the responsible staff and follow-up actions stay clear. | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.12.items.0.title | 원천 DB와 상담원 배분 | Source leads and agent allocation | OK | 상담원=agent/operator, 상담 용어 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.12.items.0.text | 수집된 원천 DB가 어느 상담원에게 배정되고 어떤 상태인지 공급 조직 안에서 관리합니다. | Track which agents receive collected source leads and their status within the supplier organization. | OK | 상담원=agent/operator, 상담 용어 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.14.items.0 | 광고주·콜센터·플랫폼 가운데 실제 개인정보 수집·이용·제공·위탁 주체가 누구인지 구분 | Identify who actually collects, uses, shares or processes personal data among the advertiser, call center and platform | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.sections.14.note | 사용 허락이 콘텐츠 저작권 문제를 해결해도 개별 캠페인의 적법성을 자동 보장하지는 않습니다. 실제 공개·집행 전 개인정보·금융 광고 담당자의 현재 기준 확인이 필요합니다. | Permission to use content may resolve copyright concerns, but does not automatically establish a campaign's legality. Before publication or launch, the people responsible for privacy and financial advertising must check current requirements. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.5.answer | 녹취 여부, 접근·제공 범위, 보관기간과 파기 방식은 캠페인·계약과 적용 기준에 따라 달라집니다. 개인정보가 포함되므로 필요성과 권한을 확인한 최소 범위로 운영합니다. | Recording practices, access and sharing scope, retention and destruction depend on campaign terms, contracts and applicable requirements. Recordings contain personal data, so access must be limited to what is necessary and authorized. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.faq.7.answer | 자동으로 인정되지 않습니다. AS 가능 사유, 연락 횟수·시간대, 신청 기한, 필요한 증빙, 교환·보완 범위를 집행 전에 문서화해야 합니다. | No. Before launch, document eligible reasons, contact attempts and times, claim deadlines, required evidence and the scope of replacement or remediation. | OK | 인정 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.insurance.cta.label | 보험 DB 운영 상담 | Discuss insurance lead operations | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.lead | 가상자산 관련 CPA는 관심고객의 상담 신청을 측정하되, 가격 상승이나 수익 가능성을 약속해서는 안 됩니다. 서비스 제공 범위, 변동성 위험, 광고 가능 여부와 개인정보 동의를 먼저 검토합니다. | Crypto CPA campaigns measure consultation requests from interested prospects. They must not promise price increases or potential returns. We first review the service scope, volatility risks, ad eligibility and privacy consent. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.hero_cta | 코인 CPA 적합성 상담 | Discuss crypto CPA eligibility | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.sections.2.items.3 | 개인정보 동의, 상담 주체와 유효 DB 처리 기준 | Privacy consent, the consultation provider and valid lead handling criteria | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.coin.cta.label | 코인 CPA 적합성 상담 | Discuss crypto CPA eligibility | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.meta_description | 상담 연락 목적, 개인정보 동의, 동의 기록, 전달·콜 운영과 철회 절차를 함께 설계하는 퍼미션 콜 DB 마케팅입니다. | Consent-based call lead marketing that connects contact purposes, privacy consent, consent records, lead delivery, call operations and withdrawal procedures. | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.hero_cta | 퍼미션 구조 상담 | Discuss your consent process | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.sections.0.paragraphs.1 | 수집 화면, 동의 로그, DB 전달, 상담 스크립트, 수신 거부와 보유 기간까지 하나의 운영 체계로 설계해야 합니다. | The collection form, consent logs, lead delivery, call scripts, opt-outs and retention periods need one operating process. | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.sections.2.items.0 | 개인정보 수집 항목·목적·보유 기간과 연락 주체 | Personal data fields, collection purpose, retention period and contacting party | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | cpa.items.permission-call.cta.label | 퍼미션 구조 상담 | Discuss your consent process | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.naver-gfa.faq.2.answer | 필요한 소재 형식과 수량, 촬영·디자인 범위를 확인한 뒤 운영 범위에 포함할지 협의합니다. 기존 자산을 재가공하는 방식도 가능합니다. | We review the formats, quantities, filming and design needed, then agree on whether to include production in the scope. We can also adapt existing assets. | OK | 소재 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.hero_cta | 유튜브 전략 상담 | Discuss a YouTube strategy | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | performance.items.youtube.cta.label | 유튜브 전략 상담 | Discuss a YouTube strategy | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.basic.hero_cta | 베이직 적합성 상담 | Discuss whether Basic fits your site | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.basic.cta.label | 베이직 적합성 상담 | Discuss whether Basic fits your site | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.pro.hero_cta | 프로 적합성 상담 | Discuss whether Pro fits your site | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.pro.cta.label | 프로 적합성 상담 | Discuss whether Pro fits your site | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.hero_cta | 엘리트 운영 상담 | Discuss Elite campaign management | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.cta.title | 고경쟁 SEO를 개인의 감이 아닌 운영 체계로 바꾸세요 | Manage competitive SEO through a process rather than individual instinct | OK | 운영 체계 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.elite.cta.label | 엘리트 운영 상담 | Discuss Elite campaign management | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.hero_cta | 발견 전략 상담 | Discuss a discovery strategy | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.faq.2.question | 어떤 발견 전략을 상담할 수 있나요? | What discovery strategies can we discuss? | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-popular.cta.label | 발견 전략 상담 | Discuss a discovery strategy | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.hero_cta | 계정 성장 상담 | Discuss account growth | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.faq.1.question | 어떤 성장 방법을 상담할 수 있나요? | What growth methods can we discuss? | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-followers.cta.label | 계정 성장 상담 | Discuss account growth | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.hero_cta | 콘텐츠 반응 상담 | Discuss content engagement | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.faq.1.question | 어떤 참여 확대 방법을 상담할 수 있나요? | What engagement methods can we discuss? | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/subpages.php | boostingshop.items.instagram-likes.cta.label | 콘텐츠 반응 상담 | Discuss content engagement | OK | 상담의 문맥상 동의어/참조, consultation 리터럴 없음; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.start.items.10.a | 첫 문의에는 비밀번호, API 키, 고객 개인정보를 보내지 마세요. 검토에 필요한 경우에도 접근 방식과 제공 범위를 먼저 합의합니다. | Do not send passwords, API keys or customers’ personal information in your first inquiry. Even when access is needed for a review, we first agree on the access method and the scope of information to provide. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.ads.items.9.q | 개인정보 동의와 광고 심사도 검토하나요? | Do you also review personal information consent and ad approval requirements? | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.3.q | 리드베이가 개인정보 준법 책임을 대신하나요? | Does LeadBay take over our responsibility for personal information compliance? | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.6.a | 이 페이지는 소개용입니다. 실제 화면, 가격, 권한, 거래·정산 기능, 약관과 개인정보 처리 안내는 리드베이의 최신 서비스가 우선합니다. | This page is an introduction. LeadBay’s current service takes precedence for actual screens, prices, permissions, transaction and settlement features, terms, and personal information handling notices. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.crm.items.7.a | 원천 DB를 상담원에게 배분해 보험DB를 생산하고 고객사에 수주·납품·AS·정산하는 콜센터 운영조직을 위한 CRM입니다. | It is a CRM for call center operations that assign source leads to agents to generate insurance leads, then handle client orders, delivery, after-sales support and settlement. | OK | 상담원=agent/operator, 상담 용어 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.8.a | 아닙니다. 인정되는 비용, 자부담, 집행 기간, 공급기업 요건과 증빙 방식은 사업마다 다릅니다. 계약이나 집행 전에 운영기관의 공고·협약·지침을 확인해야 합니다. | No. Eligible costs, the company’s own contribution, spending periods, supplier requirements and evidence requirements differ by program. Check the administering institution’s notice, agreement and guidelines before contracting or spending. | OK | 인정=지원사업 비용 허용, 리드 유효인정 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/faq.php | categories.build.items.9.a | 공고상 인정 범위와 기업의 과업 목표에 따라 퍼포먼스 광고, SEO, 콘텐츠, 영상, 웹 제작 등을 검토할 수 있습니다. 모든 사업에서 모든 항목이 인정되는 것은 아닙니다. | We can consider performance ads, SEO, content, video and web builds according to the scope permitted by the notice and the company’s task goals. Not every item is eligible under every program. | OK | 인정=지원사업 비용 허용, 리드 유효인정 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | title | 개인정보처리방침 &#124; 제이커브인터렉티브 | Privacy policy &#124; J-Curve Interactive | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | heading | 개인정보처리방침 | Privacy policy | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | introduction | (주)제이커브인터렉티브(이하 "회사")는 이용자의 개인정보를 중요하게 생각하며, 「개인정보 보호법」 등 관련 법령을 준수합니다. | J-Curve Interactive Co., Ltd. (the “Company”) values users’ personal information and complies with applicable laws and regulations, including Korea’s Personal Information Protection Act. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.0.0 | 1. 수집하는 개인정보 항목 | 1. Categories of personal information collected | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.1.0 | 2. 개인정보의 수집 및 이용 목적 | 2. Purposes of collecting and using personal information | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.1.1 | 수집한 개인정보는 상담 응대, 서비스 제공, 계약의 이행 및 고객 관리를 위해 이용됩니다. | The personal information collected is used to respond to consultations, provide services, perform contracts and manage customer relationships. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.2.0 | 3. 개인정보의 보유 및 이용 기간 | 3. Retention and use periods for personal information | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.2.1 | 원칙적으로 개인정보 수집·이용 목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 관련 법령에 따라 보존할 필요가 있는 경우 해당 기간 동안 보관합니다. | In principle, the personal information concerned is destroyed without delay after the purposes of collection and use have been achieved. However, where retention is necessary under applicable laws and regulations, the information is retained for the applicable period. | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.3.0 | 4. 개인정보 보호책임자 | 4. Personal information protection officer | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/en/pages/privacy.php | sections.3.1 | 개인정보 관련 문의는 대표 이메일(jcurve19@gmail.com) 또는 대표전화(02-1668-2612)로 연락 주시기 바랍니다. | For inquiries concerning personal information, please contact the Company’s main email address (jcurve19@gmail.com) or main telephone number (02-1668-2612). | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | seo.items.coupang.sections.0.title | 상품 데이터가 흩어지면 고객도 알고리즘도 이해하기 어렵습니다 | 商品データがばらつくと、お客様にもアルゴリズムにも伝わりません | OK | 지면=흩어지면의 일부, 광고 지면 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.meta_description | 사업지 정보, 상담 신청 기준, 개인정보 동의, 트래킹과 상담 피드백을 함께 설계하는 부동산 분양 CPA 마케팅입니다. | 物件情報、相談申込の基準、個人情報に関する同意、トラッキング、相談結果のフィードバックを合わせて設計する、不動産分譲のCPAマーケティングです。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.sections.2.items.2 | 개인정보 수집·이용 및 상담 연락 동의 문구 | 個人情報の収集・利用と相談連絡への同意文 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.real-estate.faq.2.question | 개인정보 동의도 함께 설계하나요? | 個人情報に関する同意も一緒に設計しますか？ | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.stock.sections.2.items.2 | 개인정보 수집·상담 연락 동의 및 보유 기준 | 個人情報の収集・相談連絡への同意と保有基準 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.items.2.text | 보험DB 콜센터의 원천 DB, 상담원 배분, 콜 품질, 납품, AS와 정산 업무를 관리합니다. | 保険リードを扱うコールセンターの元リード、オペレーターへの配分、通話品質、納品、アフターサポート、精算を管理します。 | OK | 상담원=agent/operator, 상담 용어 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.0.note | 실제 광고, DB 공급과 솔루션 연동 범위는 조직의 계약 구조, 시스템과 개인정보 처리 역할을 확인한 뒤 확정합니다. | 広告、リード供給、ソリューション連携の実際の範囲は、組織の契約形態、システム、個人情報の取り扱い上の役割を確認して決めます。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.3.note | 이 페이지는 법률 자문이 아닙니다. 실제 캠페인은 적용 법령, 금융·보험 광고 기준, 개인정보 처리 역할과 광고주 내부 준법 기준을 별도로 확인해야 합니다. | このページは法律上の助言ではありません。実施時には、適用法令、金融・保険広告の基準、個人情報の取り扱い上の役割、広告主の社内コンプライアンス基準を別途確認する必要があります。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.4.rows.3.1 | 부재·오인·중복 원인을 상담원이 직접 분류 | 不在・誤認・重複の原因をオペレーターが直接分類 | OK | 상담원=agent/operator, 상담 용어 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.8.note | 주관적인 “질이 나쁘다”만으로 반려하지 않고, 양측이 같은 자료와 기한으로 판단할 수 있어야 합니다. | 主観的な「質が悪い」という理由だけで差し戻さず、双方が同じ資料と期限で判断できるようにします。 | OK | 差し戻し 활용형, 정상; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.12.items.0.title | 원천 DB와 상담원 배분 | 元リードとオペレーターへの配分 | OK | 상담원=agent/operator, 상담 용어 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.12.items.0.text | 수집된 원천 DB가 어느 상담원에게 배정되고 어떤 상태인지 공급 조직 안에서 관리합니다. | 収集した元リードの割当先と現在の状態を、供給組織の中で管理します。 | OK | 상담원=agent/operator, 상담 용어 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.14.items.0 | 광고주·콜센터·플랫폼 가운데 실제 개인정보 수집·이용·제공·위탁 주체가 누구인지 구분 | 広告主・コールセンター・プラットフォームのうち、実際の個人情報の収集・利用・提供・委託主体を区別 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.sections.14.note | 사용 허락이 콘텐츠 저작권 문제를 해결해도 개별 캠페인의 적법성을 자동 보장하지는 않습니다. 실제 공개·집행 전 개인정보·금융 광고 담당자의 현재 기준 확인이 필요합니다. | 使用許諾によってコンテンツの著作権の問題が解決しても、個々のキャンペーンの適法性が自動的に保証されるわけではありません。公開・配信前に、個人情報・金融広告の担当者による最新基準の確認が必要です。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.0.answer | 이 페이지에서 보험DB는 보험 관련 상담 연락을 위해 수집·전달되는 신청 정보를 뜻합니다. 전화번호만이 아니라 신청 목적, 동의 기록, 유효 기준, 전달 시점과 상담 상태를 함께 관리해야 합니다. | このページでは、保険の相談連絡のために収集・提供される申込情報を指します。電話番号だけでなく、申込目的、同意記録、有効基準、受け渡し時点、相談状況も合わせて管理する必要があります。 | OK | DB 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.insurance.faq.5.answer | 녹취 여부, 접근·제공 범위, 보관기간과 파기 방식은 캠페인·계약과 적용 기준에 따라 달라집니다. 개인정보가 포함되므로 필요성과 권한을 확인한 최소 범위로 운영합니다. | 録音の有無、アクセス・提供範囲、保管期間、廃棄方法は、キャンペーン・契約・適用基準によって異なります。個人情報を含むため、必要性と権限を確認した最小限の範囲で運用します。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.lead | 가상자산 관련 CPA는 관심고객의 상담 신청을 측정하되, 가격 상승이나 수익 가능성을 약속해서는 안 됩니다. 서비스 제공 범위, 변동성 위험, 광고 가능 여부와 개인정보 동의를 먼저 검토합니다. | 暗号資産関連のCPAは、関心のある方の相談申込を測定しますが、価格上昇や利益の可能性を約束してはいけません。サービスの提供範囲、価格変動リスク、広告実施の可否、個人情報に関する同意を先に確認します。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.coin.sections.2.items.3 | 개인정보 동의, 상담 주체와 유효 DB 처리 기준 | 個人情報に関する同意、相談主体、有効リードの処理基準 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.meta_description | 상담 연락 목적, 개인정보 동의, 동의 기록, 전달·콜 운영과 철회 절차를 함께 설계하는 퍼미션 콜 DB 마케팅입니다. | 相談の連絡目的、個人情報に関する同意、同意記録、受け渡し・電話業務、撤回手順を合わせて設計する、同意取得済みコールリードのマーケティングです。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.sections.2.items.0 | 개인정보 수집 항목·목적·보유 기간과 연락 주체 | 個人情報の収集項目・目的・保有期間と連絡主体 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | cpa.items.permission-call.sections.3.items.0.title | 여러 상담원이 연락하는 조직 | 複数の担当者が連絡する組織 | OK | 상담원=agent/operator, 상담 용어 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/subpages.php | performance.items.naver-gfa.faq.2.answer | 필요한 소재 형식과 수량, 촬영·디자인 범위를 확인한 뒤 운영 범위에 포함할지 협의합니다. 기존 자산을 재가공하는 방식도 가능합니다. | 必要な形式と点数、撮影・デザインの範囲を確認し、運用範囲に含めるか相談します。既存の素材を再編集することも可能です。 | OK | 소재 지정 표현 미일치(아래 품질 판정 함께 참고); 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.start.items.10.a | 첫 문의에는 비밀번호, API 키, 고객 개인정보를 보내지 마세요. 검토에 필요한 경우에도 접근 방식과 제공 범위를 먼저 합의합니다. | 最初のお問い合わせでは、パスワード、APIキー、顧客の個人情報を送らないでください。検討に必要な場合も、アクセス方法と提供範囲を先に合意します。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.ads.items.9.q | 개인정보 동의와 광고 심사도 검토하나요? | 個人情報の同意や広告審査も確認しますか。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.3.q | 리드베이가 개인정보 준법 책임을 대신하나요? | LeadBayが個人情報に関する法令遵守の責任を代わりに負いますか。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.crm.items.6.a | 이 페이지는 소개용입니다. 실제 화면, 가격, 권한, 거래·정산 기능, 약관과 개인정보 처리 안내는 리드베이의 최신 서비스가 우선합니다. | このページはサービスの紹介です。実際の画面、価格、権限、取引・精算機能、利用規約、個人情報の取り扱いについては、LeadBayの最新サービスでの案内が優先されます。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.build.items.8.a | 아닙니다. 인정되는 비용, 자부담, 집행 기간, 공급기업 요건과 증빙 방식은 사업마다 다릅니다. 계약이나 집행 전에 운영기관의 공고·협약·지침을 확인해야 합니다. | いいえ。対象となる費用、自己負担、支出期間、供給企業の要件、証明方法は、事業ごとに異なります。契約や支出の前に、運営機関の公募・協約・指針を確認する必要があります。 | OK | 인정=지원사업 비용 허용, 리드 유효인정 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/faq.php | categories.build.items.9.a | 공고상 인정 범위와 기업의 과업 목표에 따라 퍼포먼스 광고, SEO, 콘텐츠, 영상, 웹 제작 등을 검토할 수 있습니다. 모든 사업에서 모든 항목이 인정되는 것은 아닙니다. | 公募で認められる範囲と企業の業務目標に応じて、パフォーマンス広告、SEO、コンテンツ、動画、Web制作などを検討できます。すべての事業ですべての項目が認められるわけではありません。 | OK | 인정=지원사업 비용 허용, 리드 유효인정 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | title | 개인정보처리방침 &#124; 제이커브인터렉티브 | 個人情報保護方針 &#124; J-Curve Interactive | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | heading | 개인정보처리방침 | 個人情報保護方針 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | introduction | (주)제이커브인터렉티브(이하 "회사")는 이용자의 개인정보를 중요하게 생각하며, 「개인정보 보호법」 등 관련 법령을 준수합니다. | J-Curve Interactive Co., Ltd.（以下「当社」といいます。）は、利用者の個人情報を重視し、韓国の「個人情報保護法」等の関連法令を遵守します。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.0.0 | 1. 수집하는 개인정보 항목 | 1. 収集する個人情報の項目 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.1.0 | 2. 개인정보의 수집 및 이용 목적 | 2. 個人情報の収集および利用目的 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.1.1 | 수집한 개인정보는 상담 응대, 서비스 제공, 계약의 이행 및 고객 관리를 위해 이용됩니다. | 収集した個人情報は、ご相談への対応、サービスの提供、契約の履行および顧客管理のために利用します。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.2.0 | 3. 개인정보의 보유 및 이용 기간 | 3. 個人情報の保有および利用期間 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.2.1 | 원칙적으로 개인정보 수집·이용 목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 관련 법령에 따라 보존할 필요가 있는 경우 해당 기간 동안 보관합니다. | 原則として、個人情報の収集・利用目的が達成された後は、当該情報を遅滞なく破棄します。ただし、関連法令に基づき保存する必要がある場合は、該当する期間保管します。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.3.0 | 4. 개인정보 보호책임자 | 4. 個人情報保護責任者 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |
| lang/ja/pages/privacy.php | sections.3.1 | 개인정보 관련 문의는 대표 이메일(jcurve19@gmail.com) 또는 대표전화(02-1668-2612)로 연락 주시기 바랍니다. | 個人情報に関するお問い合わせは、当社の代表メールアドレス（jcurve19@gmail.com）または代表電話（02-1668-2612）までご連絡ください。 | OK | 인정=개인정보 부분 문자열, 대상 아님; 원문의 뜻·조건을 유지함. | 해당 없음 |

## 11. U10 게이트·렌더 URL 전수

| 명령 | 종료 코드 | 실제 출력 |
| --- | --- | --- |
| php -l lang/en/subpages.php | 0 | No syntax errors detected in lang/en/subpages.php |
| php -l lang/en/pages/faq.php | 0 | No syntax errors detected in lang/en/pages/faq.php |
| php -l lang/en/pages/privacy.php | 0 | No syntax errors detected in lang/en/pages/privacy.php |
| php -l lang/ja/subpages.php | 0 | No syntax errors detected in lang/ja/subpages.php |
| php -l lang/ja/pages/faq.php | 0 | No syntax errors detected in lang/ja/pages/faq.php |
| php -l lang/ja/pages/privacy.php | 0 | No syntax errors detected in lang/ja/pages/privacy.php |
| ./vendor/bin/pint --test --no-ansi lang/en/subpages.php lang/en/pages/faq.php lang/en/pages/privacy.php lang/ja/subpages.php lang/ja/pages/faq.php lang/ja/pages/privacy.php | 0 | {"tool":"pint","result":"passed"} |
| php -d auto_prepend_file=/private/tmp/verify-intl04-20261103-independent/guard.php artisan test --env=testing --bootstrap=/private/tmp/verify-intl04-20261103-independent/guard.php --do-not-cache-result --no-ansi | 0 | [2026-11-03 07:21:32] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"} <br>[2026-11-03 07:21:32] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"} <br>{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":25894} |

| 언어 | URL | HTTP | html lang | HTML 스냅샷 SHA-256 |
| --- | --- | --- | --- | --- |
| en | /en/seo-backlinks/ | 200 | en | 6a3b58f8c67d0ad52dfc9b9d6f1a283351ae6aab147af67ba0cd376fa1691de2 |
| en | /en/naver-place-marketing/ | 200 | en | a84a7192f19955fbd89951577f9cb5a6ad22fc628050e3af5a6ec25085d8f6c9 |
| en | /en/naver-shopping-marketing/ | 200 | en | 474d906c9d1981d7670d1c1fe6f537e620823fdd390b6595e54f4d9c655c4668 |
| en | /en/kakao-gift/ | 200 | en | 9fde9795726f76ddc368dcf5dc98fd296b02ed10cfc9f4e82dc4597207d39b55 |
| en | /en/coupang/ | 200 | en | c6d3fcb27c2731a74524319ae174cb87a9c1bc3844a3724988c31eff9f174564 |
| en | /en/services/cpa-marketing/real-estate | 200 | en | aa41eb93a627defe192c3e54008094629a95bdb6e5f6fba6d8fb1f085d085e7f |
| en | /en/services/cpa-marketing/stock | 200 | en | f0a415576a4a0894bd18629025f149d0112d9469074cc877686711c4c554fc32 |
| en | /en/services/cpa-marketing/insurance | 200 | en | 60a3662d70f56e0da541f58f103cb0be49fbe2c1ea0e282a8d266a65f4e2d242 |
| en | /en/services/cpa-marketing/coin | 200 | en | 2c54ba7392154f38ac205654e45ed0930a40fab6455ecc377b826265a375faea |
| en | /en/services/cpa-marketing/permission-call | 200 | en | a631279ea02a1599fdd82b66cc963a2542f63655b94cab30dd03e5caeac04fad |
| en | /en/services/performance-marketing/naver-gfa | 200 | en | 9e8e1ba3b7d5bdae06b5bd21b1b623f0107566e722102b153541ec883a5efb7b |
| en | /en/services/performance-marketing/facebook | 200 | en | 3efc53e0b9ca203306b507ef7b373f7411f03c4f7be66e0ef7c7b29f0b645d29 |
| en | /en/services/performance-marketing/youtube | 200 | en | 0a6d31de44122215cd87205ad1a7a92d10234418f6ed362fb3b00c34c9356df4 |
| en | /en/solutions/boostingshop/basic | 200 | en | b08aa233af79b933672752fca9ef59f303e070fb53302c14713654d7a18000ef |
| en | /en/solutions/boostingshop/pro | 200 | en | f75844eee02a758bb6f8d6ccdd24a2bbbf10e34fed67dedee5764a18e1007bb0 |
| en | /en/solutions/boostingshop/elite | 200 | en | d8057c6bc0959d96793c6b1268e6c2643c386d7c6d557a5f254160794b8358f8 |
| en | /en/solutions/boostingshop/instagram-popular | 200 | en | 37818caaeb012bff906c549d285403523524aa7993aa27608ddc13aa9467680d |
| en | /en/solutions/boostingshop/instagram-followers | 200 | en | 4a172b96b66f6db2cf434d55fa7d6ff00caf06c588c500809c332e2ad4c5cba9 |
| en | /en/solutions/boostingshop/instagram-likes | 200 | en | 88a693d11a4aa295cb1aa6d0f5cf63d9254c4e751c802bcec3db80ba73159d0c |
| en | /en/support/faq | 200 | en | 6a7c4e4334499db4bc1c8e71b00f0149fb36972a224c607bd4dd24766723ab01 |
| en | /en/privacy | 200 | en | db4c506869dbdd0d3933b8b75ef8e99a5c452f6c40bd4aaff2e73106375fd716 |
| ja | /ja/seo-backlinks/ | 200 | ja | 3eabbe935004bd77c6ebec27ba15dc132643901767069a78200cc758ff1357fa |
| ja | /ja/naver-place-marketing/ | 200 | ja | c22575a4089cd995a8cd29cd3a16adb3fde78de4c7c4f9b27db7ea09de6dec3b |
| ja | /ja/naver-shopping-marketing/ | 200 | ja | d6183cda5b0e28ec819d8cc4139111f3ec9f8537e88721f4d86fed6a540aa12e |
| ja | /ja/kakao-gift/ | 200 | ja | 37cad1feccc5a09d876591f248bb60296eeffdcc2de22173ab550bc10f4421fd |
| ja | /ja/coupang/ | 200 | ja | 979b119055e1d43e120dc2698ebfe8604ee15609ecdd1c6ead05f8cce1f4fe97 |
| ja | /ja/services/cpa-marketing/real-estate | 200 | ja | 89dff211bdb9fdfa1c2f18aa964758ef566922822ad3514054dc904862d72f63 |
| ja | /ja/services/cpa-marketing/stock | 200 | ja | 99d8e9471f7ab052d2ef814beefbe3824ec065c244dd5f2759978f607f8d900d |
| ja | /ja/services/cpa-marketing/insurance | 200 | ja | 55356328beeee9fcdaf7c78840aa552b11e1a3e9a5fdded7548e25b4c7f345a0 |
| ja | /ja/services/cpa-marketing/coin | 200 | ja | 741d81eda5816529e5a7a4f18cbfcd05bb956bb7e763e1b1eb6928b5f0cd00a6 |
| ja | /ja/services/cpa-marketing/permission-call | 200 | ja | f7a4a9999a5c8c1b4c20f52b28ed0666eebc3978951491d44d9e1e7c5e263400 |
| ja | /ja/services/performance-marketing/naver-gfa | 200 | ja | 54135bf665b78ab3679545def890cce64ffd266cd7b5d0ccebca78394b8b7c05 |
| ja | /ja/services/performance-marketing/facebook | 200 | ja | f5811733da78b69215e671feeac84741614b80988a28e9d76c2139e1f286fca6 |
| ja | /ja/services/performance-marketing/youtube | 200 | ja | fe29e49f7f01e04a6330a51875cdba3bc600e63c039092654b6cdc8b727b9229 |
| ja | /ja/solutions/boostingshop/basic | 200 | ja | f12654ed6cf2af43edad0c10866175312754450dbb0a9aed8e4f44b9df57aa3a |
| ja | /ja/solutions/boostingshop/pro | 200 | ja | 6e4b8e15311105a6d81c896815ab8c2e1328631532b60eced8e63ff7f2e3a80c |
| ja | /ja/solutions/boostingshop/elite | 200 | ja | 07792355e7d5b31c54b49ab03e43815f1499cb5aa3e27702650755a555ddf5fc |
| ja | /ja/solutions/boostingshop/instagram-popular | 200 | ja | 063657649f16ceee11d124643d3c9ed2eb5277e2f7579f39eb5f2611813909b3 |
| ja | /ja/solutions/boostingshop/instagram-followers | 200 | ja | 796508433a07e133e18e813ae8c0cca9aef4c501700fb8f15c1865b3cb0bc2f6 |
| ja | /ja/solutions/boostingshop/instagram-likes | 200 | ja | 06d3bf69094a74a6ad501da6685c85a5ddd1a6e1d8608629e6f61bebccade656 |
| ja | /ja/support/faq | 200 | ja | 79ded771ca763b27a827e9ff8782b788b75dc497e02cd33444214d6d1ab3810d |
| ja | /ja/privacy | 200 | ja | e3496382622c565791fb913600d6284423b60097b56bf543d3d426480079af72 |

## 12. 실험·원복 해시·원본 무변경 증거

동시 세션이 사용하는 제품 파일을 변조하지 않았다. 데이터의 **전용 복사본** `mutation-fixture.json`에 키 삭제·한글 삽입·숫자 변조·부정 삭제·금지 용어 삽입을 각각 적용하고, 본 검증의 실제 `analyze.py`를 같은 입력 인터페이스로 다시 실행했다. 각 변이의 대상 검사는 정상 입력 PASS → 변이 FAIL을 확인했다. `finally`에서 실험 복사본을 처음 바이트로 원복했다. 이는 독립 검사기의 검출력을 확인한 실험이며, 제품 방어 코드를 제거한 뒤 전체 PHPUnit이 실패한다고 주장하는 실험은 아니다.

| 실험 | 검사기 | 정상 입력 | 변이 입력 | 변이 SHA-256 |
| --- | --- | --- | --- | --- |
| U2-key | actual analyze.py | PASS | FAIL | d2dc4756ac5ce2d29c92abbc52ed6e1ef5447372a36fd339bf68b4db98def45f |
| U3-Hangul | actual analyze.py | PASS | FAIL | f5fc6d77ae67c44bafdd5bac55a3d723ac7d7997d4d85862bc3a9fb9b9648b72 |
| U4-number | actual analyze.py | PASS | FAIL | 50ddb2ff079bbc51c96e0a2627e8d52b796d14e3fa7f9886db6bbc264446ae3e |
| U5-negation | actual analyze.py | PASS | FAIL | 083f840a8e05344f76b1a5ed6c49e5daf1cf1a1f1018206eee5fcd71ee69573a |
| U6-term | actual analyze.py | PASS | FAIL | f49365866d310fed18880fa2d8e3c3c5c5ee8dd53a1b68364e8cd3503e5da102 |

- 실험 파일: `/private/tmp/verify-intl04-20261103-independent/mutation-fixture.json`.
- 실험 전 SHA-256: `1c7f6e87d80cc933e9bd1360488d4ddda6a05fe6d6b6c9c26dd6577487036c51`.
- 원복 후 SHA-256: `1c7f6e87d80cc933e9bd1360488d4ddda6a05fe6d6b6c9c26dd6577487036c51`. **완전 동일.**

아래 6개 대상 파일과 4개 한국어 원문은 최초 캡처부터 최종 확인까지 해시가 같다. 원본은 실험 대상으로 바꾼 적이 없어 원복 조작 자체가 없으며, 타 세션 변경을 덮어씌우는 복구도 하지 않았다.

| 파일 | 시작 SHA-256 | 종료 SHA-256 | 결과 |
| --- | --- | --- | --- |
| lang/en/subpages.php | eb2bbcef1598a2a5014a3d44ca1b9742b2d5ad4c80da0dda8c47d872b25e9d17 | eb2bbcef1598a2a5014a3d44ca1b9742b2d5ad4c80da0dda8c47d872b25e9d17 | 동일 |
| lang/en/pages/faq.php | b6d55150204e29d5daa7a96e55f30ce51dab4a49f16c471891afe0c0bf57dfe2 | b6d55150204e29d5daa7a96e55f30ce51dab4a49f16c471891afe0c0bf57dfe2 | 동일 |
| lang/en/pages/privacy.php | e79a1f099e70efbad35de099d7b7a4de76cb5d4b9d28b4171f67331e858dfc2f | e79a1f099e70efbad35de099d7b7a4de76cb5d4b9d28b4171f67331e858dfc2f | 동일 |
| lang/ja/subpages.php | 4b61e0451d6ca16263823c257f2954cd94a47b70a334325ad6dd08a57b87773f | 4b61e0451d6ca16263823c257f2954cd94a47b70a334325ad6dd08a57b87773f | 동일 |
| lang/ja/pages/faq.php | 8b157270ae70f177bf254e39670d04152a2ce7148697d72b9dcde6e88a88b715 | 8b157270ae70f177bf254e39670d04152a2ce7148697d72b9dcde6e88a88b715 | 동일 |
| lang/ja/pages/privacy.php | e5b917b87d936e3b8e7c95b3cda8c5fe444bcca7c405d7f81f05640d52fb03e8 | e5b917b87d936e3b8e7c95b3cda8c5fe444bcca7c405d7f81f05640d52fb03e8 | 동일 |
| config/subpages.php | 731ba65f99813c81861981f2c58dd991ef1d77d9cf816b1e2efd3af2e0ebf4cd | 731ba65f99813c81861981f2c58dd991ef1d77d9cf816b1e2efd3af2e0ebf4cd | 동일 |
| resources/views/partials/jc/faq-data.php | e95ae7bc20b0c666b3eb932338505c289b516036edd30371fc475205469a8b8d | e95ae7bc20b0c666b3eb932338505c289b516036edd30371fc475205469a8b8d | 동일 |
| resources/views/pages/faq.blade.php | 777d97ec3c54584e0e86a25068e91a53945e81b2989a225d7a8b127889cf5692 | 777d97ec3c54584e0e86a25068e91a53945e81b2989a225d7a8b127889cf5692 | 동일 |
| resources/views/pages/privacy.blade.php | 15ccdc2b54a18ee6996c85e635456ac169e22a57390c9f524dc55dff7be71526 | 15ccdc2b54a18ee6996c85e635456ac169e22a57390c9f524dc55dff7be71526 | 동일 |

### 독립 검증 스크립트·실행 증거 해시

| 경로 | SHA-256 |
| --- | --- |
| /private/tmp/verify-intl04-20261103-independent/export.php | 8d2ce1a5f21a01f5019a50622c51849f80ac45a54b119334f8ec37baaba57fe0 |
| /private/tmp/verify-intl04-20261103-independent/guard.php | b179e1f723b353f38423e1028201fe1ec19c4c1319aee938cd040190b9342a9d |
| /private/tmp/verify-intl04-20261103-independent/render.php | c6c64a259cc94221ef2c0736b676ae37225536ab44e17ddab6b4eb38537d9ca1 |
| /private/tmp/verify-intl04-20261103-independent/run.py | 12a7c8cf04c95c2046edef81095a8c2f81ed19ffd0941e54a1ffd3c55440a650 |
| /private/tmp/verify-intl04-20261103-independent/analyze.py | 00d9a9fc5b9abcb772fe3d187e3ff66aa4803b504251ec52f0f759d381825e1d |
| /private/tmp/verify-intl04-20261103-independent/mutation.py | ced826fea5fb56c7a7fcfe495481c4106140c12f7007476b9ac763a2f537deb0 |
| /private/tmp/verify-intl04-20261103-independent/report.py | 1e9a4584cadd0bf4de3409e73736c3154d7a4fac565ebc5c5aff8862dd609f1e |
| /private/tmp/verify-intl04-20261103-independent/data.json | 1c7f6e87d80cc933e9bd1360488d4ddda6a05fe6d6b6c9c26dd6577487036c51 |
| /private/tmp/verify-intl04-20261103-independent/analysis.json | 32632cd9e049764e470246b1ec97f899b1bf21f629ff92a3665fa4886ea60dbb |
| /private/tmp/verify-intl04-20261103-independent/before-hashes.json | b48b7ce6b7ec8e3e9dfede591a1c1c9da1663fe86882f977c3ac6463e4768448 |
| /private/tmp/verify-intl04-20261103-independent/renders.json | 4be72317f2da710faa6286fbb9d7a8e86c428dd40772db41231311c13731f9d9 |
| /private/tmp/verify-intl04-20261103-independent/gates.json | 09c512a26ffac25895f3bf3909fc0633358a5edf310ba5db69f81e55529bc852 |
| /private/tmp/verify-intl04-20261103-independent/test-final.json | 32afdcf8ed29867a6105150f094dbe4f4b6cede04b51ff331218ad6328f54a09 |
| /private/tmp/verify-intl04-20261103-independent/mutation.json | 550ebec4b8e6cd3c0a4e79c8862f022e4654aaded5050b903bb6b164ea3667f7 |

## 13. 검증 한계·미검증 항목

- U1은 제공된 A/B/C 세 로그에 남은 호출 흔적에 대한 판정이다. 네트워크 패킷 캡처나 모든 세션 외부 프로세스의 감사는 하지 않았다.
- U2는 원문=사전본인 사람용 eyebrow까지 포함하는 VERIFY 문구의 엄격 판정이다. 사람용 문자열 예외를 승인하면 판정 수가 바뀔 수 있으므로 58개를 숨기지 않고 전수 기록했다.
- U9는 정해진 무작위 60잎과 U5/U6 의심 잎의 의미 검토다. 모든 2,844쌍의 원어민 수준 문장 품질을 보증하지 않는다. 자동 통과를 사람의 전수 번역 검수로 표현하지 않았다.
- U3/U10은 실제 Laravel 커널의 HTML 렌더·DOM/JSON-LD 검사다. 브라우저에서 데스크톱/모바일 레이아웃, 키보드 조작, JS 실행 후 FAQ 검색·카운터의 화면 동작까지 검증한 것은 아니다.
- 제품 방어 코드의 실물 제거/복구 실험은 하지 않았다. 사용자 수정 금지·같은 worktree 동시 검증 조건을 지켜 전용 데이터 복사본의 변이 검출과 원복 해시로 제한했다.
- 04D JSON, INTL-02의 원복 실험/반환물, 실제 서버·실DB·법적 최신성·성과 수치의 사업상 진위·공개 배포는 이번 범위 밖이다. 동시 세션은 switcher 및 HEAD를 변경했으며 해당 파일을 수정하거나 타 세션 변경을 복구하지 않았다. U3 판정은 보존된 HTML 스냅샷에 한정한다.
- 대시보드·요청 큐·미디어·공유 구현 파일을 수정하지 않았다. 결과 문서에 기록한 대안 문장은 모두 제안이며 제품 파일에는 반영하지 않았다.

**최종 집계: PASS 6 / FAIL 4 (U2·U5·U7·U9).**

## 부록. 이번 세션에서 직접 작성한 재현 스크립트

아래는 임시 경로가 정리된 뒤에도 검증 방법을 확인할 수 있도록 남긴 실제 소스다. 기존 구현 세션의 스크립트는 포함하지 않았다. 경로·환경·원본 SHA가 맞는 동일 worktree에서만 재실행한다.

### guard.php

```php
<?php
// VERIFY-INTL-04: do not load any environment file or use an external database.
if (defined('VERIFY_INTL04_GUARD')) { return; }
define('VERIFY_INTL04_GUARD', true);
$root = '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n';
$loader = require $root.'/vendor/autoload.php';
foreach (['App\\' => 'app/', 'Tests\\' => 'tests/', 'Database\\Seeders\\' => 'database/seeders/', 'Database\\Factories\\' => 'database/factories/'] as $prefix => $directory) {
    $loader->setPsr4($prefix, $root.'/'.$directory);
    foreach ($loader->getClassMap() as $class => $path) {
        if (str_starts_with($class, $prefix)) {
            $loader->addClassMap([$class => $root.'/'.$directory.str_replace('\\', '/', substr($class, strlen($prefix))).'.php']);
        }
    }
}
class VerifyIntl04NoEnvironment {
    public function bootstrap($app): void {
        $app->useEnvironmentPath('/private/tmp/verify-intl04-20261103-independent/no-environment');
        $app->afterBootstrapping(\Illuminate\Foundation\Bootstrap\BootProviders::class, function ($app) {
            if ($app['config']->get('database.default') !== 'sqlite' || $app['config']->get('database.connections.sqlite.database') !== ':memory:') {
                throw new RuntimeException('VERIFY-INTL-04 requires in-memory SQLite');
            }
            \Illuminate\Support\Facades\Http::preventStrayRequests();
        });
    }
}
class_alias(VerifyIntl04NoEnvironment::class, 'Illuminate\\Foundation\\Bootstrap\\LoadEnvironmentVariables');
foreach (['http', 'https'] as $protocol) {
    if (in_array($protocol, stream_get_wrappers(), true)) { stream_wrapper_unregister($protocol); }
}
```

### export.php

```php
<?php
$root = '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n';
$pre = '/private/tmp/claude-501/-Users-anarchy-Claude-Projects-jcurve/782fb1b7-1762-465f-befa-38be705ecc7f/scratchpad/pre04';
function route($name, $params = []) { return ['route' => $name, 'params' => $params]; }
$data = ['ko' => ['subpages' => require $root.'/config/subpages.php', 'faq' => ['categories' => require $root.'/resources/views/partials/jc/faq-data.php']]];
$source = file_get_contents($root.'/resources/views/pages/privacy.blade.php');
$doc = new DOMDocument();
@$doc->loadHTML('<?xml encoding="UTF-8">'.$source);
$xp = new DOMXPath($doc);
$text = fn ($expression) => trim($xp->evaluate('string('.$expression.')'));
$data['ko']['privacy'] = ['heading' => $text('//h1'), 'introduction' => $text('//article/p[1]'), 'sections' => [], 'closing' => $text('//article/p[last()]')];
foreach ($xp->query('//article/section') as $node) {
    $data['ko']['privacy']['sections'][] = [trim($node->getElementsByTagName('h2')->item(0)->textContent), trim($node->getElementsByTagName('p')->item(0)->textContent)];
}
foreach (['en', 'ja'] as $locale) {
    foreach (['subpages' => 'subpages.php', 'faq' => 'pages/faq.php', 'privacy' => 'pages/privacy.php'] as $type => $path) {
        $data[$locale][$type] = require $root.'/lang/'.$locale.'/'.$path;
        $baseline = $pre.'/'.$locale.'-'.$type.'.php';
        if (is_file($baseline)) { $data['before'][$locale][$type] = require $baseline; }
    }
}
echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
```

### render.php

```php
<?php
require __DIR__.'/guard.php';
$root = '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n';
$app = require $root.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$app['config']->set('seo.public_url', 'https://j-curve.co.kr');
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$rows = [];
foreach (['ko', 'en', 'ja'] as $locale) {
    $variants = [];
    foreach (config('intl.subpages') as $route => $group) {
        foreach (array_keys(config('subpages.'.$group.'.items')) as $slug) {
            $parameter = Illuminate\Support\Facades\Route::getRoutes()->getByName($route)->parameterNames()[0];
            $variants[] = ['name' => $route, 'parameters' => [$parameter => $slug], 'group' => $group, 'slug' => $slug];
        }
    }
    $variants[] = ['name' => 'support.faq', 'parameters' => []];
    $variants[] = ['name' => 'privacy', 'parameters' => []];
    foreach ($variants as $variant) {
        $name = ($locale === 'ko' ? '' : $locale.'.').$variant['name'];
        $path = route($name, $variant['parameters'], false);
        $request = Illuminate\Http\Request::create('https://j-curve.co.kr'.$path);
        $response = $kernel->handle($request);
        $filename = $locale.'-'.str_replace('.', '-', $variant['name']).'-'.($variant['slug'] ?? 'main').'.html';
        file_put_contents(__DIR__.'/html/'.$filename, $response->getContent());
        $doc = new DOMDocument();
        @$doc->loadHTML('<?xml encoding="UTF-8">'.$response->getContent());
        $xp = new DOMXPath($doc);
        $channels = [];
        foreach ($xp->query('//text()[not(ancestor::script) and not(ancestor::style)] | //meta/@content | //@alt | //@aria-label | //@title | //@placeholder') as $node) {
            $value = trim($node->nodeValue);
            if ($value !== '') { $channels[] = ['path' => $node->getNodePath(), 'value' => $value, 'switcher' => $xp->query('ancestor::*[@data-intl-switcher]', $node)->length > 0]; }
        }
        $schemas = [];
        foreach ($xp->query('//script[@type="application/ld+json"]') as $node) {
            try { $schemas[] = json_decode($node->textContent, true, 512, JSON_THROW_ON_ERROR); }
            catch (Throwable $e) { $schemas[] = ['parse_error' => $e->getMessage(), 'raw' => $node->textContent]; }
        }
        $faq = [];
        foreach ($xp->query('//details[contains(@class,"jc-faqhub__item")]') as $node) {
            $faq[] = ['q' => trim($xp->evaluate('string(.//summary)', $node)), 'a' => trim($xp->evaluate('string(.//div/p)', $node))];
        }
        $rows[] = ['locale' => $locale, 'path' => $path, 'route' => $variant['name'], 'status' => $response->getStatusCode(), 'lang' => $xp->evaluate('string(/html/@lang)'), 'file' => $filename, 'sha256' => hash('sha256', $response->getContent()), 'channels' => $channels, 'schemas' => $schemas, 'faq' => $faq];
        $kernel->terminate($request, $response);
    }
}
echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
```

### run.py

```python
from pathlib import Path
import subprocess, os, hashlib, json, sys, time

ROOT = Path('/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n')
OUT = Path(__file__).parent
FILES = [f'lang/{l}/{f}' for l in ['en', 'ja'] for f in ['subpages.php', 'pages/faq.php', 'pages/privacy.php']]
SOURCES = ['config/subpages.php', 'resources/views/partials/jc/faq-data.php', 'resources/views/pages/faq.blade.php', 'resources/views/pages/privacy.blade.php']
def sha(path): return hashlib.sha256(Path(path).read_bytes()).hexdigest()
def run(args, env=None):
    t=time.monotonic()
    p=subprocess.run(args,cwd=ROOT,env=env,text=True,capture_output=True)
    return {'command':args,'exit':p.returncode,'seconds':round(time.monotonic()-t,2),'stdout':p.stdout,'stderr':p.stderr}

env=os.environ.copy()
env.update(APP_ENV='testing',APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=',APP_URL='http://localhost',APP_CONFIG_CACHE=str(OUT/'cache/config.php'),APP_ROUTES_CACHE=str(OUT/'cache/routes.php'),APP_SERVICES_CACHE=str(OUT/'cache/services.php'),APP_PACKAGES_CACHE=str(OUT/'cache/packages.php'),VIEW_COMPILED_PATH=str(OUT/'views'),LOG_CHANNEL='stderr',DB_CONNECTION='sqlite',DB_DATABASE=':memory:',DB_URL='',CACHE_STORE='array',SESSION_DRIVER='array',MAIL_MAILER='array',QUEUE_CONNECTION='sync',BCRYPT_ROUNDS='4')

if sys.argv[1] == 'capture':
    hashes={f:sha(ROOT/f) for f in FILES+SOURCES}
    (OUT/'before-hashes.json').write_text(json.dumps(hashes,indent=2))
    d=run(['php',str(OUT/'export.php')]); assert d['exit']==0,d
    data=json.loads(d['stdout'])
    for locale in ['en','ja']:
        old=run(['git','show',f'0f18dc6a329770671f05bfab159f54b5ab6527fb:lang/{locale}/pages/privacy.php'])
        assert old['exit']==0,old
        p=subprocess.run(['php','-r','$a=eval(substr(stream_get_contents(STDIN),5)); echo json_encode($a,JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR);'],input=old['stdout'],capture_output=True,text=True)
        assert p.returncode==0,p.stderr
        data['before'][locale]['privacy']=json.loads(p.stdout)
    (OUT/'data.json').write_text(json.dumps(data,ensure_ascii=False,indent=2))
    print('Captured six translation files and four Korean sources; historical privacy baseline independently loaded.',flush=True)
elif sys.argv[1] == 'render':
    r=run(['php',str(OUT/'render.php')],env)
    (OUT/'render-run.json').write_text(json.dumps(r,ensure_ascii=False,indent=2))
    if r['exit']:
        print('Render failure:',r['stdout'][-2000:],r['stderr'][-2000:]);sys.exit(1)
    rows=json.loads(r['stdout']);(OUT/'renders.json').write_text(json.dumps(rows,ensure_ascii=False,indent=2))
    bad=[x for x in rows if x['status']!=200 or x['lang']!=x['locale']]
    print('Rendered',len(rows),'routes;',len(bad),'status/lang errors',json.dumps(bad,ensure_ascii=False),flush=True)
elif sys.argv[1] in ['gates','test']:
    results=[]
    if sys.argv[1] == 'gates':
        for f in FILES:
            results.append(run(['php','-l',f]))
        results.append(run(['./vendor/bin/pint','--test','--no-ansi',*FILES]))
    results.append(run(['php','-d','auto_prepend_file='+str(OUT/'guard.php'),'artisan','test','--env=testing','--bootstrap='+str(OUT/'guard.php'),'--do-not-cache-result','--no-ansi'],env))
    (OUT/('gates.json' if sys.argv[1]=='gates' else 'test-final.json')).write_text(json.dumps(results,ensure_ascii=False,indent=2))
    for r in results:
        print('COMMAND', ' '.join(r['command']),'EXIT',r['exit'],'SECONDS',r['seconds'])
        print((r['stdout']+r['stderr'])[-1800:])
else: raise ValueError(sys.argv[1])
```

### analyze.py

```python
from pathlib import Path
import re, json, random, hashlib, subprocess, unicodedata, sys
from decimal import Decimal
from collections import Counter

OUT=Path(__file__).parent
ROOT=Path('/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n')
PRE=Path('/private/tmp/claude-501/-Users-anarchy-Claude-Projects-jcurve/782fb1b7-1762-465f-befa-38be705ecc7f/scratchpad')
D=json.loads((Path(sys.argv[1]) if len(sys.argv)>1 else OUT/'data.json').read_text())
HANGUL=re.compile(r'[\u1100-\u11ff\u3130-\u318f\ua960-\ua97f\uac00-\ud7af\ud7b0-\ud7ff]')
NEG_KO=re.compile(r'않습니다|없습니다|아닙니다|보장하지|보장할 수 없|약속하지|제공하지|판매하지|금지')
NEG={'en':re.compile(r'\b(?:not|no|never|cannot|without|neither)\b|n[’\x27]t',re.I),'ja':re.compile(r'ません|ない|いいえ|できません|保証しません|せず|ずに|禁止|不可|異なります')}
BAD=re.compile(r'ペット|地面|グラウンド|オペレーティングシステム|カウンセリング|インフロー|\boperating system\b|\bmaterials?\b|\btop exposure\b|\binflow\b|\bcounseling\b|\bremodeling\b',re.I)
TECH={'route','param','params','type','tone','href','id','contact_interest','icon','slug','source_hash'}

def flat(x,p=()):
    if isinstance(x,dict):
        for k,v in x.items(): yield from flat(v,p+(str(k),))
    elif isinstance(x,list):
        for k,v in enumerate(x): yield from flat(v,p+(str(k),))
    else: yield '.'.join(p),x
def shape(x,p=''):
    rows=[]
    if isinstance(x,(dict,list)):
        it=x.items() if isinstance(x,dict) else enumerate(x)
        rows.append((p,'array',[str(k) for k,v in it]))
        it=x.items() if isinstance(x,dict) else enumerate(x)
        for k,v in it: rows+=shape(v,p+'.'+str(k))
    else: rows.append((p,type(x).__name__))
    return rows
def technical(k,v): return not isinstance(v,str) or bool(set(k.split('.'))&TECH)
def plain(s): return re.sub(r'<[^>]*>','',s)
def tokens(s):
    s=re.sub(r'\b(?:B2B|Call2Sale|C2S)\b','',s,flags=re.I)
    out=[]
    for m in re.finditer(r'(?<![A-Za-z])\d[\d,]*(?:\.\d+)?\s*(?:billion\b|million\b|thousand\b|억|만|億|万|[BMK](?![A-Za-z]))?',s,re.I):
        raw=m.group().strip();n=re.search(r'\d[\d,]*(?:\.\d+)?',raw).group();u=raw[len(n):].strip().lower()
        scale={'억':10**8,'만':10**4,'億':10**8,'万':10**4,'b':10**9,'billion':10**9,'m':10**6,'million':10**6,'k':10**3,'thousand':10**3}.get(u,1)
        out.append(str((Decimal(n.replace(',',''))*scale).normalize()))
    return out

# UI literals in the Korean Blade; no implementation check script is imported.
UI={'title':'자주 묻는 질문 — 고객센터 | 제이커브인터렉티브','description':'제이커브인터렉티브 고객센터. 퍼포먼스·CPA·리워드 광고, SEO·AEO·GEO, 셀프마케팅·부스팅샵, 리드베이·콜투세일, 웹 제작·지원사업에 대해 자주 묻는 질문과 답변을 한곳에 모았습니다.','heading':'자주 묻는 질문','breadcrumb_aria':'현재 위치','home':'홈','support':'고객센터','lead':'서비스마다 가장 많이 받는 질문을 모았습니다. 찾는 답이 없으면 문의를 남겨 주세요.','search_label':'질문 검색','search_placeholder':'궁금한 내용을 검색하세요 — 예: 보장, 계정, 환불, 리포트','questions':'질문','results':'결과','inquiry':'문의 남기기','project_direct':'프로젝트 문의(1:1)','project':'프로젝트 문의','list_aria':'질문 목록','categories_aria':'질문 분야','all':'전체','related':'관련 페이지','empty_before':'‘','empty_after':'’에 맞는 질문을 찾지 못했어요.','empty_text':'다른 단어로 찾아보거나, 문의를 남겨 주시면 확인 후 답변드립니다.','cta_heading':'찾는 답이 없나요?','cta_text':'궁금한 점은 문의로 남겨 주세요. 프로젝트 상담은 1:1 문의가 가장 빠릅니다.','phone':'전화','email':'메일'}
UI['results']='검색 결과'
blade=(ROOT/'resources/views/pages/faq.blade.php').read_text()
for k,v in UI.items():
    # result label is assembled by the existing JS, not literal Blade text.
    assert v in blade or (k=='results' and v in (ROOT/'resources/js/jc.js').read_text()),(k,v)
D['ko']['faq'].update(UI)
D['ko']['privacy']['title']='개인정보처리방침 | 제이커브인터렉티브'

pairs=[];struct=[];hangul=[];equal_changed=[];technical_changed=[]
for locale in ['en','ja']:
    for group in ['subpages','faq','privacy']:
        ko=dict(flat(D['ko'][group])); tr=dict(flat(D[locale][group])); before=dict(flat(D['before'][locale][group]))
        struct.append({'locale':locale,'group':group,'shape_equal':shape(D[locale][group])==shape(D['before'][locale][group]),'leaves':len(tr),'baseline_leaves':len(before)})
        for key,value in tr.items():
            if isinstance(value,str) and HANGUL.search(value): hangul.append({'locale':locale,'group':group,'key':key,'text':value})
            if key in ko and key in before and ko[key]==before[key] and value!=ko[key]: equal_changed.append({'locale':locale,'group':group,'key':key,'ko':ko[key],'tr':value,'human':not technical(key,value)})
            if key in before and technical(key,value) and value!=before[key]: technical_changed.append({'locale':locale,'group':group,'key':key,'before':before[key],'tr':value})
            if key in ko and isinstance(ko[key],str) and isinstance(value,str) and not technical(key,value):
                pairs.append({'locale':locale,'group':group,'file':f'lang/{locale}/'+('subpages.php' if group=='subpages' else f'pages/{group}.php'),'key':key,'ko':ko[key],'tr':value})

neg=[];terms=[];numbers=[];outliers=[];claims=[];forbidden=[]
termmap={
'반려':{'en':r'reject','ja':r'差し戻し|却下'},'지면':{'en':r'placement|inventory','ja':r'広告枠|掲載面'},'소재':{'en':r'creative','ja':r'クリエイティブ|広告素材'},'운영 체계':{'en':r'operating process|workflow','ja':r'運用体制'},'DB':{'en':r'lead','ja':r'リード'},'상담':{'en':r'consultation','ja':r'相談'},'상위노출':{'en':r'top ranking|ranking on page one','ja':r'上位表示'},'인정':{'en':r'accepted as valid','ja':r'有効認定'},'리모델링':{'en':r'policy review|switching','ja':r'保険の見直し'}}
for row in pairs:
    locale=row['locale'];ko=row['ko'];tr=row['tr']
    if NEG_KO.search(ko): neg.append({**row,'negative_detected':bool(NEG[locale].search(tr))})
    hits=[term for term in termmap if term in ko]
    if hits: terms.append({**row,'terms':hits,'mismatch':[term for term in hits if not re.search(termmap[term][locale],tr,re.I)]})
    if BAD.search(tr): forbidden.append({**row,'word':BAD.search(tr).group()})
    a,b=tokens(ko),tokens(tr)
    if a!=b: numbers.append({**row,'ko_tokens':a,'tr_tokens':b})
    a=re.findall(r'\d[\d,]*(?:\.\d+)?',ko);b=re.findall(r'\d[\d,]*(?:\.\d+)?',tr)
    if a!=b and not any(x['key']==row['key'] and x['locale']==locale and x['group']==row['group'] for x in numbers): numbers.append({**row,'ko_tokens':tokens(ko),'tr_tokens':tokens(tr),'notation_only':True})
    ratio=len(plain(tr))/max(len(plain(ko)),1)
    lo,hi=(.8,4.5) if locale=='en' else (.5,2.5)
    if ratio<lo or ratio>hi: outliers.append({**row,'ratio':round(ratio,3),'severity':round(max(lo/ratio,ratio/hi),3) if ratio else 999})
    if re.search(r'\bbest\b|\bleading\b|No\.?\s*1|guarantee|業界No[.．]?1|最高|保証します',tr,re.I): claims.append(row)

seed=2026110304;samples=[]
for locale in ['en','ja']:
    pool=sorted([r for r in pairs if r['locale']==locale],key=lambda x:(x['file'],x['key']))
    samples+=random.Random(seed+(0 if locale=='en' else 1)).sample(pool,30)

logs=[]
pattern=re.compile(r'translate\.googleapis|translate_a|deepl\.com|papago|curl\s+http|file_get_contents\([\x27\x22]http|Http::get',re.I)
for letter in 'abc':
    f=PRE/f'codex-intl04{letter}.log';s=f.read_text();hits=[]
    for m in pattern.finditer(s):
        line=s.count('\n',0,m.start())+1
        prev=s.rfind('\nexec\n',0,m.start()); command_end=s.find(' in /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n\n',prev) if prev!=-1 else -1
        actual=prev!=-1 and command_end!=-1 and m.start()<command_end
        hits.append({'line':line,'match':m.group(),'actual_exec_command':actual,'context':s[max(0,m.start()-90):m.end()+100]})
    logs.append({'file':str(f),'sha256':hashlib.sha256(f.read_bytes()).hexdigest(),'bytes':f.stat().st_size,'exec_count':len(re.findall(r'\nexec\n',s)),'hits':hits})

render=json.loads((OUT/'renders.json').read_text());render_issues=[];allowed=[];faqchecks=[];privacychecks=[]
keypattern=re.compile(r'(?:pages/[a-z-]+\.|subpages\.|menu\.|intl\.)[\w./-]+')
file_keys=[];forbidden_all=[]
for locale in ['en','ja']:
    for group in ['subpages','faq','privacy']:
        for key,value in flat(D[locale][group]):
            if isinstance(value,str) and keypattern.search(value): file_keys.append({'locale':locale,'group':group,'key':key,'value':value})
            if isinstance(value,str) and BAD.search(value): forbidden_all.append({'locale':locale,'group':group,'key':key,'value':value})
for page in render:
    if page['locale']=='ko':continue
    for channel in page['channels']:
        t=channel['value']
        if HANGUL.search(t):
            if t=='한국어' and channel['switcher']: allowed.append({'path':page['path'],**channel})
            else:render_issues.append({'path':page['path'],**channel,'issue':'Hangul'})
        if keypattern.search(t):render_issues.append({'path':page['path'],**channel,'issue':'exposed key'})
    for schema in page['schemas']:
        if 'parse_error' in schema:render_issues.append({'path':page['path'],'issue':'JSON-LD parse error'})
        for key,value in flat(schema):
            if isinstance(value,str) and (HANGUL.search(value) or keypattern.search(value)):render_issues.append({'path':page['path'],'key':key,'value':value,'issue':'schema text'})
    locale=page['locale']
    if page['route']=='support.faq':
        expected=[{'q':x['q'],'a':x['a']} for cat in D[locale]['faq']['categories'].values() for x in cat['items']]
        schemas=[x for x in page['schemas'] if x.get('@type')=='FAQPage']
        entities=[{'q':x['name'],'a':x['acceptedAnswer']['text']} for x in schemas[0]['mainEntity']] if len(schemas)==1 else []
        counts={k:len(v['items']) for k,v in D[locale]['faq']['categories'].items()}
        ko_counts={k:len(v['items']) for k,v in D['ko']['faq']['categories'].items()}
        faqchecks.append({'locale':locale,'count':len(page['faq']),'schema_count':len(entities),'dom_equals_file_order':page['faq']==expected,'jsonld_equals_dom':entities==page['faq'],'category_counts':counts,'ko_category_counts':ko_counts,'category_counts_match_ko':counts==ko_counts,'categories_match_ko':list(D[locale]['faq']['categories'])==list(D['ko']['faq']['categories'])})
    if page['route']=='privacy':
        joined='\n'.join(x['value'] for x in page['channels']);data=D[locale]['privacy']
        privacychecks.append({'locale':locale,'sections':len(data['sections']),'all_clauses_rendered':all(p in joined and h in joined for h,p in data['sections']),'notice_rendered':data['translation_notice'] in joined,'notice_before_intro':joined.find(data['translation_notice'])<joined.find(data['introduction']),'email_preserved':'jcurve19@gmail.com' in joined,'phone_preserved':'02-1668-2612' in joined})

results={'pairs':pairs,'structure':struct,'hangul':hangul,'file_exposed_keys':file_keys,'equal_source_before_changed':equal_changed,'technical_changed':technical_changed,'negative':neg,'terms':terms,'forbidden':forbidden,'forbidden_all_strings':forbidden_all,'numbers':numbers,'outliers':outliers,'claims':claims,'samples':samples,'seed':seed,'logs':logs,'render_issues':render_issues,'allowed_korean':allowed,'faq':faqchecks,'privacy':privacychecks}
(Path(sys.argv[2]) if len(sys.argv)>2 else OUT/'analysis.json').write_text(json.dumps(results,ensure_ascii=False,indent=2))
for k in ['structure','hangul','technical_changed','forbidden','numbers','outliers','render_issues','faq','privacy']:print(k,json.dumps(results[k] if k in ['structure','faq','privacy'] else {'count':len(results[k])},ensure_ascii=False))
print('pairs',len(pairs),'negative',len(neg),'negative missing',sum(not x['negative_detected'] for x in neg),'term rows',len(terms),'term mismatches',sum(bool(x['mismatch']) for x in terms),'equal-source-before changed',len(equal_changed),'claims',len(claims),'allowed Korean',len(allowed))
```

### mutation.py

```python
from pathlib import Path
import json, hashlib, re, copy, subprocess
OUT=Path(__file__).parent
original=(OUT/'data.json').read_bytes()
candidate=OUT/'mutation-fixture.json'
candidate.write_bytes(original)
hash_before=hashlib.sha256(candidate.read_bytes()).hexdigest()
results=[]
def run_checker():
    process=subprocess.run(['python3',str(OUT/'analyze.py'),str(candidate),str(OUT/'mutation-analysis.json')],capture_output=True,text=True)
    assert process.returncode==0,process.stderr
    return json.loads((OUT/'mutation-analysis.json').read_text())
baseline=run_checker()
def triggered(name,result):
    if name=='U2-key':return not next(x for x in result['structure'] if x['locale']=='en' and x['group']=='subpages')['shape_equal']
    if name=='U3-Hangul':return any(x['locale']=='en' and x['key']=='seo.items.backlinks.lead' for x in result['hangul'])
    if name=='U4-number':return any(x['locale']=='en' and x['key']=='cpa.items.insurance.sections.1.items.0.title' and not x.get('notation_only') for x in result['numbers'])
    if name=='U5-negation':return any(x['locale']=='en' and x['key']=='cpa.items.coin.body.1' and not x['negative_detected'] for x in result['negative'])
    if name=='U6-term':return any(x['word']=='ペット' for x in result['forbidden'])
try:
    data=json.loads(original)
    cases=[
        ('U2-key','subpages',lambda d:d['en']['subpages']['seo']['items']['backlinks'].pop('lead'),lambda d:'lead' not in d['en']['subpages']['seo']['items']['backlinks']),
        ('U3-Hangul','subpages',lambda d:d['en']['subpages']['seo']['items']['backlinks'].__setitem__('lead','검증용 오류'),lambda d:bool(re.search('[가-힣]',d['en']['subpages']['seo']['items']['backlinks']['lead']))),
        ('U4-number','subpages',lambda d:d['en']['subpages']['cpa']['items']['insurance']['sections'][1]['items'][0].__setitem__('title','KRW 38.3B+'),lambda d:'37.3' not in d['en']['subpages']['cpa']['items']['insurance']['sections'][1]['items'][0]['title']),
        ('U5-negation','subpages',lambda d:d['en']['subpages']['cpa']['items']['coin']['body'].__setitem__(1,'We guarantee prices, returns, principal protection or investment outcomes.'),lambda d:not re.search(r'\b(?:not|no|never|cannot|without|neither)\b',d['en']['subpages']['cpa']['items']['coin']['body'][1],re.I)),
        ('U6-term','subpages',lambda d:d['ja']['subpages']['cpa']['items']['insurance']['sections'][8].__setitem__('note','ペット'),lambda d:'ペット' in d['ja']['subpages']['cpa']['items']['insurance']['sections'][8]['note']),
    ]
    for name,group,change,check in cases:
        fixture=copy.deepcopy(data);assert not triggered(name,baseline),name+' baseline unexpectedly red'
        change(fixture);candidate.write_text(json.dumps(fixture,ensure_ascii=False))
        actual=run_checker()
        assert triggered(name,actual),name+' mutant survived'
        results.append({'test':name,'baseline':'PASS','mutated':'FAIL','detected':True,'detector':'actual analyze.py','mutant_sha256':hashlib.sha256(candidate.read_bytes()).hexdigest()})
finally:
    candidate.write_bytes(original)
hash_after=hashlib.sha256(candidate.read_bytes()).hexdigest()
assert hash_after==hash_before
result={'method':'isolated JSON fixture mutation; no product file modified','path':str(candidate),'before_sha256':hash_before,'restored_sha256':hash_after,'restored':True,'experiments':results}
(OUT/'mutation.json').write_text(json.dumps(result,indent=2))
print(json.dumps(result,indent=2))
```

<!-- VERIFY-INTL04-PART-044 -->
