# SEO-META-02B 구현 결과

작성: Codex, 2026-11-03. 지시서: `docs/SPEC-CODEX-SEO-META-02B.md`.

**테스트 구현 완료. 전체 테스트 183개·20,195개 단언 통과, 필수 무력화 실험 2개 탐지 및 정확한 복구 완료. 전체 Pint는 기존 파일 3개의 스타일 위반으로 실패하므로 전체 합격 게이트 충족을 주장하지 않는다.** 새 테스트 파일의 Pint와 PHP 문법 검사는 통과했다.

구현은 Codex, 검증은 구현과 분리한 verifier 세션이 맡았다. 최종 검수·합격 판정은 Claude에게 남긴다.

## 1. 추가 파일과 구현 내용

| 추가 파일 | 내용 |
|---|---|
| `tests/Feature/WpLegacyContentTest.php` | 149줄 추가. 데이터 제공자 기반 25개 회귀 테스트 |
| `docs/SEO-META-02B-IMPL-RESULT.md` | 사용자가 지정한 반환물인 이 문서 |

기존 파일은 수정하지 않았다. `tests/**` 외 코드·설정·JSON·Blade·미디어와 큐·대시보드는 변경하지 않았다. 커밋·푸시·배포·서버 실행·포트 8000/8014 조작도 하지 않았다.

테스트 파일의 실제 diff 요약:

```text
 /dev/null => tests/Feature/WpLegacyContentTest.php | 149 +++++++++++++++++++++
 1 file changed, 149 insertions(+)
```

| 요구 | 구현한 검사 |
|---|---|
| 공개 호스트의 원주소 9개 | `seo.public_url=https://j-curve.co.kr`, 해당 호스트의 절대 URL로 GET, HTTP 200 |
| 원문 구간 정확히 1개 | 문서 전체에서 `id="service-detail"` 개수 1, 실제 `section` 요소인지 확인 |
| 원문 전체·순서·반복·이스케이프 | 원문 426블록과 구간 내부 요소의 텍스트 배열을 엄격 비교. 별도로 원본 HTML 바이트에서 `htmlspecialchars` 결과를 순서대로 확인 |
| `excluded[]` 부재 | 페이지 전체 raw HTML와 디코딩한 DOM 텍스트 양쪽에서 부재 확인 |
| 무관 페이지 구간 부재 | 회사소개·블로그 목록·SEO/링크빌딩 분류·CPA/performance/boostingshop 각 1개, 총 7페이지 |
| 음성 서브페이지 선정 조건 | 실제 config 항목이 존재하고 `seo_title` 키가 없는지 확인 |
| H1 중복 방지 | 양성 9페이지와 음성 7페이지 모두 H1 정확히 1개 |
| 원문 무결성 | JSON별 기대 SHA256 9개를 테스트 상수로 고정. 현재 파일로 기대값을 재생성하지 않음 |

해시 입력은 각 JSON의 `blocks[].text`를 순서대로 공백으로 이어 붙인 뒤 `/\s+/u`를 공백 하나로 치환하고 양 끝 공백을 제거한 UTF-8 문자열이다. 제목·문장·숫자의 변경을 잡으며 JSON 서식·블록 type/level·excluded 배열 자체는 고정 대상이 아니다.

## 2. 실행 환경과 기준선

원본의 금지 파일을 임시로도 수정하지 않기 위해 **테스트와 무력화 실험은 `/private/tmp/jcurve-seo-meta-02b.jVID3l` 복사본에서 실행**했다. `.git`·실제 `.env`는 복사하지 않았고 vendor는 별도 복사했다. 실제 `.env`를 열람하거나 로딩하지 않았다.

- PHP 8.5.8 CLI, SQLite `:memory:`.
- `RefreshDatabase`, `InsightCategorySeeder`, `LegacyContentSeeder` 사용.
- array cache/session/mail, sync queue. URL 요청은 Laravel 내부 요청이며 운영 서버 호출이 아니다.
- 독립 검증 상세 증거: `/private/tmp/jcurve-seo-meta-02b-verification-result.md`.

### 전체 테스트 — exit 0

```sh
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= SEO_PUBLIC_URL=https://j-curve.co.kr LOG_CHANNEL=null php artisan test
```

실제 출력:

```json
{"tool":"phpunit","result":"passed","tests":183,"passed":183,"assertions":20195,"duration_ms":10457}
```

### 전체 Pint — exit 1

```sh
./vendor/bin/pint --test
```

실제 출력:

```json
{"tool":"pint","result":"fail","files":[{"path":"app\/Services\/Seo\/OnPageAuditor.php","fixers":["new_with_parentheses","array_indentation","single_quote","fully_qualified_strict_types","control_structure_braces","control_structure_continuation_position","unary_operator_spaces","no_multiple_statements_per_line","braces_position","statement_indentation","not_operator_with_successor_space","single_line_empty_body","blank_line_before_statement","ordered_imports"]},{"path":"app\/Services\/Seo\/UrlGuard.php","fixers":["no_unneeded_control_parentheses","control_structure_braces","unary_operator_spaces","braces_position","statement_indentation","not_operator_with_successor_space","blank_line_before_statement"]},{"path":"resources\/views\/partials\/jc\/menu.php","fixers":["fully_qualified_strict_types","single_line_after_imports"]}]}
```

세 파일은 작업 전부터 존재한 파일이며 원본과 검증 복사본의 SHA256이 다음과 같이 일치한다. `tests/**` 수정 제한에 따라 고치지 않았다.

| 파일 | 원본·복사본 공통 SHA256 |
|---|---|
| `app/Services/Seo/OnPageAuditor.php` | `65b3ef4b8c691ba23eff82357276670032911d0af50ea4db56b1b84443e67c0e` |
| `app/Services/Seo/UrlGuard.php` | `121c194b111a567f630dac8437ae79d2a52112223a3d1fe8bedf77c92c3562d1` |
| `resources/views/partials/jc/menu.php` | `866d9a71021b66969e797f49e853f1980baea956bdd81674899be828e96d106b` |

### 신규 파일 Pint·문법 — 각각 exit 0

```sh
./vendor/bin/pint --test tests/Feature/WpLegacyContentTest.php
php -l tests/Feature/WpLegacyContentTest.php
```

실제 출력:

```text
{"tool":"pint","result":"passed"}
No syntax errors detected in tests/Feature/WpLegacyContentTest.php
```

## 3. 무력화 실험 ① — include 한 줄 제거

복사본의 `resources/views/pages/subpage.blade.php`에서 아래 한 줄만 제거했다.

```blade
        @include('partials.jc.wp-legacy', ['wpStyle' => 'landing'])
```

실행 명령:

```sh
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= SEO_PUBLIC_URL=https://j-curve.co.kr LOG_CHANNEL=null php artisan test --filter=test_every_original_block_is_escaped_and_ordered_inside_one_section
```

실제 결과는 **exit 1, 9개 중 5개 실패·4개 통과, 158개 단언**이었다. 실패한 데이터셋은 `seo-backlinks`, `naver-place-marketing`, `naver-shopping-marketing`, `kakao-gift`, `coupang`이다. 각 데이터셋이 구간 개수 0으로 실패했다. 실제 출력에서 첫 실패 메시지:

```text
/seo-backlinks/: exactly one original-content section
Failed asserting that 0 is identical to 1.
```

원래 줄을 같은 위치에 복구하고 동일 명령을 재실행했다. **exit 0**, 실제 출력:

```json
{"tool":"phpunit","result":"passed","tests":9,"passed":9,"assertions":505,"duration_ms":673}
```

실험 전·복구 후 파일 SHA256 모두 `2d5c47ce54d37fe84ef392c2fe394a228c7d02c68a7f5e8193f0df90f2310c95`로 일치했다.

## 4. 무력화 실험 ② — JSON 숫자 한 글자 변경

복사본의 `resources/views/partials/jc/wp-legacy/home.json`, `blocks[0].text`에서 `단! 10초면 됩니다.`를 `단! 11초면 됩니다.`로 변경했다. 본문의 숫자 `0` 한 글자를 `1`로 바꾼 실험이다.

```sh
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= SEO_PUBLIC_URL=https://j-curve.co.kr LOG_CHANNEL=null php artisan test --filter=test_original_block_text_matches_its_fixed_sha256
```

실제 결과는 **exit 1, 9개 중 home 1개 실패·8개 통과, 27개 단언**이었다. 실제 실패 메시지:

```text
home: original sentences and numbers must not change
Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-'033064a56aebb18d8906fa9d51b1c498ff140fc0d7bb0890b5ce8111d6cd79f4'
+'c343f509175a319bcf7c468ca6dc7adfe87e14257be5b081044d133b7d769cbd'
```

`apply_patch`가 EOF 개행 없는 JSON에 개행 1바이트를 추가하는 도구 한계가 있었다. 이 개행은 blocks 텍스트 해시에 영향을 주지 않는다. 숫자를 원복한 뒤에도 바이트 일치까지 보장하기 위해, 원본 SHA256이 실험 전 값과 같은지 확인하고 해당 파일만 원본에서 복사본으로 다시 복사했다. 원본은 읽기만 했다.

```sh
cp /Users/anarchy/Claude_Projects/jcurve/resources/views/partials/jc/wp-legacy/home.json /private/tmp/jcurve-seo-meta-02b.jVID3l/resources/views/partials/jc/wp-legacy/home.json
cmp /Users/anarchy/Claude_Projects/jcurve/resources/views/partials/jc/wp-legacy/home.json /private/tmp/jcurve-seo-meta-02b.jVID3l/resources/views/partials/jc/wp-legacy/home.json
```

두 명령 모두 **exit 0**, `cmp` 무출력. 실험 전·정확한 복구 후 파일 SHA256 모두 `5261639cb1bf0e3ce9c0b1200c588ac24f33c6fff6c3a99cb16bd9a4a3b48723`로 일치했다.

복구 후 신규 테스트 전체를 재실행했다. **exit 0**:

```sh
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= SEO_PUBLIC_URL=https://j-curve.co.kr LOG_CHANNEL=null php artisan test --filter=WpLegacyContentTest
```

```json
{"tool":"phpunit","result":"passed","tests":25,"passed":25,"assertions":559,"duration_ms":1840}
```

## 5. 원본 보존과 git 확인

두 실험 각각의 전후에 원본 레포에서 `git diff | shasum`을 실행했다. 모든 출력이 동일했다.

```text
da39a3ee5e6b4b0d3255bfef95601890afd80709  -
```

이 해시는 untracked 파일을 포함하지 않는다. 따라서 별도로 변이 대상의 SHA256·바이트 일치, 신규 테스트의 원본/복사본 동일성도 확인했다. 신규 테스트 SHA256은 `b0053cb223512a1b4e6c16338a21703408b99adcc6a24345d986ef4920bfb32a`다.

세션 최초에는 지시서 기준 HEAD `bfa7bd8`과 기존 미커밋 변경이 있었고, 구현 중 외부 체크포인트가 HEAD를 `7a76729d8aba6ed167a099ceff8ae1898d789845`로 바꾸는 것을 관찰했다. 이 세션은 커밋·푸시·브랜치 변경·stash·reset·checkout을 실행하지 않았다. 외부 변경을 되돌리지 않았으며 해당 체크포인트 이후 파일로 검증 복사본을 만들었다.

## 6. 미검증·남은 항목

- **전체 Pint 통과는 미충족**: 위 기존 3파일의 스타일 위반을 담당 구역에서 별도 처리한 뒤 재실행해야 한다.
- PHP 8.3/MySQL, 실서버 응답, 브라우저 화면·반응형, GSC 색인 상태는 미검증이다.
- 현재 승인된 JSON을 정본으로 검사했다. 운영 워드프레스 원문의 진위·수집 완전성을 인터넷으로 재대조하지 않았다.
- 현재 원문 특수문자는 `&` 2건이다. 모든 블록의 이스케이프를 검사하지만 별도 `< > " '` 공격 문자열 fixture를 추가한 작업은 아니다.
- 프론트 빌드는 필수 게이트 밖이다. 독립 검증 복사본에는 node_modules를 제외했으므로 참고 실행한 `npm run build`는 `sh: vite: command not found`로 exit 127이었다. 의존성 설치나 빌드 변경은 하지 않았다.
- Claude의 최종 검수·합격 판정과 운영 반영은 수행하지 않았다.
