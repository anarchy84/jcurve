# VERIFY-INTL-02 독립 검증 결과

- 검증일: 2026-11-03. 구현 세션과 별개인 Codex 검증 세션.
- 작업 폴더: `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`.
- **V1~V15: PASS 12 / FAIL 3. FAIL = V7·V8·V9.**
- V7은 실제 404 링크다. V8은 안전하게 인코딩됐지만 검증 지시서의 출력 허용 목록을 벗어난 경우다. V9는 숫자의 잘못된 환산이 아니라 원문 수치의 누락이다. 서로 다른 문제이므로 구분해서 기록했다.
- 제품 코드 수정 없음. 요구된 임시 무력화·주입 실험만 수행하고 5개 파일을 원복했다. 이 세션이 만든 저장소 반환물은 이 문서다. 커밋·푸시·배포·브랜치 변경·stash·reset·checkout은 실행하지 않았다.
- 최종 제품 합격·예외 승인은 Claude/대웅의 판단 영역이다. 이 문서에서는 지시서에 없는 예외를 임의로 승인하지 않았다.

## 1. 실행 범위와 재현 환경

`VERIFY-CODEX-INTL-02.md` 전체, `SPEC-CODEX-INTL-02.md` 추가 지시 A~E, `INTL-PLAN.md`, `GLOSSARY.md`, `INTL-01-IMPL-RESULT.md`의 계약, `INTL-02-IMPL-RESULT.md`의 주장·파일 표를 읽었다. 구현 반환물의 통과 수를 증거로 사용하지 않고 별도 수집기·분석기·문의 테스트를 작성했다.

검증 시작 HEAD는 `7f2d2ff98d9f768fe5d8299552718b43587696ed`, 마지막 응답 수집 종료 시 관찰한 HEAD는 `69cc75d0a92648ed86505c3c841e8a9e0784d539`이다. 같은 작업 폴더의 다른 세션/체크포인트가 진행돼 HEAD와 전역 diff가 바뀌었다. 이 세션의 Git 사용은 조회와 `git archive 0662117`뿐이다.

최종 화면 수집 확인 시각은 **2026-11-03 16:14:17 KST**다. 수집 직전/직후 **검증 범위 소스 124파일의 SHA-256 차이 0**을 확인했다(`scope-closing-before.json` / `scope-closing-after.json`). 앞선 전체 테스트 이후 다시 바뀐 `lang/ja/subpages.php`도 이 최종 수집의 19개×2언어 렌더 검사에 포함했고, 해당 파일 Pint를 별도로 재통과했다. 그때의 파일 SHA-256은 `4b61e0451d6ca16263823c257f2954cd94a47b70a334325ad6dd08a57b87773f`다.

- PHP 실측: **8.5.8**. HTTP 서버를 열지 않고 Laravel HTTP Kernel에 요청했다. 금지 포트 사용 없음.
- 실제 `.env`는 읽거나 변경하지 않았다. 전용 PHP prepend가 환경 파일 bootstrap의 경로를 빈 임시 디렉터리로 바꾸며, 필요한 값은 각 자식 프로세스의 환경 사전으로 전달했다.
- 현재 앱의 수집용 DB는 **`storage/framework/testing/verify02.sqlite`**만 사용했다. 매 수집을 `migrate:fresh --seed`로 초기화했다. 기준본도 archive 안의 같은 상대 경로에 자기 SQLite를 만들었다. 기존 DB·Claude 임시 DB에 접속하지 않았다.
- 위 전용 SQLite는 시작 시 없던 파일이며 최종 응답을 임시 증거 파일로 보존한 뒤 삭제해 원래의 부재 상태로 돌렸다. 저장소의 제품/번역 파일은 삭제하지 않았다.
- 전체/독립 PHPUnit은 명령 단위 `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`로 실행했다. 셸 `export DB_DATABASE` 없음. 테스트 시 `APP_URL=http://localhost`, 공개 SEO origin은 `https://j-curve.co.kr`이다.
- **`database/content/intl/insights/*.json`은 열거나 수정하지 않았다.** 해당 시더는 테스트 컨테이너에서 no-op으로 바꾸고 기존 한국어 공개 글에 직접 생성한 en/ja 번역을 연결했다. 비어 있던 link-building 카테고리에는 전용 DB 안에만 한국어 fixture 글 1개를 만들었다.
- 한국어 무변경 비교는 이 fixture를 넣기 **전** 응답으로 수행했다. fixture 후의 목록 변화는 한국어 회귀로 계산하지 않았다.

### 독립 수집 수량

| 대상 | 실측 |
|---|---:|
| 기준 한국어 sitemap XML 항목 | 94 |
| 한국어 비교 응답, 제외·이동 주소 포함 | 109 = 200:104, 302:1, 301:4 |
| 생산 번역 JSON을 제외한 외국어 정적 sitemap | 86 = 43 × 2 |
| 직접 생성한 번역이 있는 카테고리 | 4 × 2 |
| 직접 생성한 번역 글 | 4 × 2 |
| 외국어 전수 화면/fixture sitemap | **102 = 51 × 2** |
| config 라우트 확장, 글 상세는 별도 fixture로 포함 | 94 = 47 × 2 |
| 위 확장에 포함된 서브페이지 | **38 = 19 × 2** |
| 중복 제거한 내부 페이지 링크, 쿼리 포함 | **199** |

구현/Claude의 “외국어 sitemap 90개”와 위 102개는 입력 데이터가 다르다. 90이라는 주장을 재인용하지 않았다. 실제 INTL-03 번역 글의 수량·내용·링크는 이번 판정에 포함하지 않았다.

### 재현 스크립트와 명령

독립 도구와 원시 응답·로그는 `/private/tmp/verify-intl02-20261103/`에 있다. 저장소 구현 비교기는 V2/V14의 공격 대상으로만 사용했다. V1은 그 비교기와 snapshot 함수를 호출하지 않는다.

```sh
D=/private/tmp/verify-intl02-20261103

# C1: 독립 기준본·현재본 수집. 같은 SQLite를 쓰는 snapshot 명령은 순차 실행한다.
python3 "$D/run.py" archive
python3 "$D/run.py" snapshot baseline
python3 "$D/run.py" snapshot current foreign
python3 "$D/analyze.py" compare

# C2: DOM·메타·JSON-LD·hreflang·href/action 검사
python3 "$D/analyze.py" audit

# C3: 비교기 허용 정규식과 한국어 파일 변경 범위
python3 "$D/static_audit.py"

# C4: 숫자·통화·홈 메타 수치 누락
python3 "$D/numbers.py"

# C5: 저장·오류·허니팟·동일 미들웨어의 독립 PHPUnit
python3 "$D/run.py" contact-test

# C6: 게이트
python3 "$D/run.py" test gate-last-concurrent-ja-copy
python3 "$D/run.py" pint
npm run build
npx vite build --configLoader runner

# C7: 원복 후 구현 비교기도 실제 재통과하는지 확인
python3 "$D/run.py" compare-impl restored-comparator-green
```

핵심 스크립트 SHA-256:

| 파일 | SHA-256 |
|---|---|
| `capture.php` | `d45adf4c9d8a0e7eaa461ab5bdbfa16a1769c1a2fe9cbdf469932567a0642dca` |
| `analyze.py` | `eb936905d08a979f4c1f1fb38c85fa5614faca0c96e4be84320dde573a3361f1` |
| `IndependentContactTest.php` | `8865e8b78aa8ccdea156ee4597d35a2732925ba9b6db8d1d03d3df3ab8c3a5bf` |

`numbers.py`는 메타 수치 검사까지 추가한 최종본을 사용한다. 원시 증거: `baseline.json`, `current.json`, `V1.json`, `audit.json`, `numbers.json`, `V9-summary.json`, `raw-output.json`, `contact-independent-*.json`, `mapping.json`, `escape.json`, 각 명령의 `.log`.

## 2. V1~V15 판정표

| 항목 | 판정 | 직접 실행한 명령·근거 | 실제 출력 일부 |
|---|---|---|---|
| V1 한국어 무변경 | **PASS** | C1. 0662117 archive와 현재의 상태·Location·본문을 별도 스크립트로 비교. 301/302를 따라가지 않음. 지정 두 블록과 허용된 임의 값만 정규화. 기준 sitemap 전체와 제외·이동 주소 포함 | `baseline_pages:109`, `baseline_statuses:{200:104,302:1,301:4}`, `diff_count:0`, `korean_xml_equal:true`, `korean_sitemap_count:94`, `foreign_appended_only:true` |
| V2 비교기 무력화 | **PASS** | 한국어 footer 닫는 태그 앞 공백 1개 → 구현 비교기를 실행. 원복 후 C7 재실행. 정규식을 AST로 추출해 RSS·일반 nav·앞 공백 보존도 별도 검사 | 변이 exit **1**, `HTML/status differences:102`. 원복 exit **0**, `differences:0`. `rss_preserved:true`, `unrelated_nav_preserved:true`, `leading_space_preserved:true` |
| V3 한글 0 | **PASS** | C2. 외국어 102화면의 텍스트, title, description·og·twitter, alt/title/aria-label/placeholder/value, JSON-LD의 키·문자열 검사. 스위처 안의 정확한 `한국어`만 허용 | `foreign_pages:102`, `V3:[]` |
| V4 번역 키 노출 | **PASS** | C2. 위 필드에서 pages/·menu.·subpages.·insights.·validation. 뒤에 실제 키 이름이 있는 문자열 검사. 일반 문장 끝 `validation.`은 번역 키로 오인하지 않음 | `V4:[]` |
| V5 hreflang 상호성 | **PASS** | C2. 외국어 102페이지 각각에서 ko/en/ja/x-default 4개·자기 canonical 검사. 모든 alternate를 직접 요청해 200/Location 없음·동일 집합 확인. 한국어 제외 화면 및 번역 없는 글도 검사 | `reciprocal_checks:102`, `V5:[]`, 한국어 200 응답 중 alternate 없는 화면 **55** |
| V6 뷰 존재 확인·sitemap | **PASS** | SEO route→view를 없는 이름으로 잠깐 변경해 독립 mapping 수집. 원복. 별도로 View::exists 조건 제거 후 지정 테스트 실행 → 원복 | `ko_hreflang:0`, `en:404`, `ja:404`, `sitemap_has_en:false`, `sitemap_has_ja:false`. 확인 제거 시 테스트 exit **1**, `4 is identical to 0`. 외국어 sitemap **102/102 200**, Location 없음 |
| V7 제외 구역·링크 | **FAIL** | C2. 탐색 href/action·폼 목적지 전수와 중복 제거 링크 199개 직접 요청. CSS/font/canonical/hreflang 등 문서 리소스·SEO 메타는 탐색 링크와 구별. KO 스위처는 접두 검사만 예외이며 200 검사는 적용 | 금지 구역·카카오·비문의 폼 **0**, 내부 링크 **198 정상 / 1 주소 404**. 상세 §3.1 |
| V8 출력 이스케이프 | **FAIL** | `{!! !!}` **23개** 전수 조사와 lang 값 스크립트 주입. JSON-LD 13개·본문 1개·e() 후 줄바꿈 7개·일반 JS JSON 2개. 마지막 2개가 V8의 명시 허용 목록 밖 | 실제 payload 태그 **0**, `&lt;script&gt;alert(1)&lt;/script&gt;` **1**. XSS 재현은 없지만 FAQ **42·43행**의 일반 JS raw 출력이 허용 목록 위반. 상세 §3.2 |
| V9 숫자·기준 라벨 | **FAIL** | C4. 정적 43페이지와 카테고리 4개 숫자 토큰을 수집해 억/万/M/B 등을 원값으로 정규화하고 의미 대응을 확인. Claude 본보기의 현재 메타도 포함 | `Pages compared:47`, `Currency conversions:[]`. 홈 메타 KO **10년+·1,000개+**에 대응하는 값이 EN/JA 모두 없음. §3.3·§4 |
| V10 고지 유지 | **PASS** | C2 및 숫자 문맥 대조. 지원사업 선정/지원금 비보장, privacy 첫 문장의 한국어 원문 우선, 성과의 누적·시점 라벨 확인 | `V10:[]`. EN `We do not guarantee selection or funding.`; privacy 원문 우선 문장 존재. 회사/보험/성과의 2026·company-wide/会社全体 라벨 유지 |
| V11 문의 | **PASS** | C5의 독립 테스트. locale 위조 입력과 반대되는 주소 언어 저장, service_interest=seo 저장, 허용 밖 값·빈 필수값·허니팟 저장 금지. 한국어와 외국어의 실제 해석된 CSRF/throttle/honeypot 클래스 비교 | **2/2**, **51 assertions**. 정상 **en 1·ja 1** 저장, invalid/empty/spam **0**. 세 경로 모두 `PreventRequestForgery`, `ThrottleRequests:5,1`, `ProtectAgainstSpam` |
| V12 FAQ | **PASS** | C2. 헤더 메뉴 details를 제외하고 `jc-faqhub__item`을 셈. FAQPage JSON 파싱 후 mainEntity 수·외국어 inLanguage 확인 | KO/EN/JA 화면 **81/81/81**, JSON 질문 **81/81/81**, 외국어 `inLanguage:[en]`, `[ja]` |
| V13 한국어 파일 범위 | **PASS** | C3, `git diff --stat 0662117 -- ...`, 구현 결과 §7 파일 표와 대조. 실제 한국어 뷰 차이는 head/header 두 파일뿐, 스위처가 신규 1개. config/subpages 및 ko lang 차이 0 | **3 files changed, 36 insertions** = switcher21 + head13 + header2. 구현 표에 이 세 파일 없음. 작성 세션의 물리적 행위 자체는 Git 합본으로 추적 불가(§7) |
| V14 네 무력화 재현 | **PASS** | 아래 §5 명령·실제 변이로 다시 실행. 키 삭제·한글 삽입·뷰 확인 제거·한국어 공백 삽입 각각 빨강, 5개 실험 파일 SHA 원복 확인 | 키 **0/1**, 한글 **0/1**, 뷰 확인 **0/1**, 공백 비교 exit **1**. 원복 후 전체 **206/206** 및 구현 비교기 차이 **0** |
| V15 게이트 | **PASS** | C6. PHP 전체 테스트, 기준 0662117 이후 신규·변경 비-Blade PHP 89파일 Pint. 빌드 기본 명령 EPERM 후 지시된 runner 대안 사용 | `tests:206,passed:206,assertions:36008`; Pint `passed`; Vite runner exit **0**, **12 modules**, `built in 1.63s`. INTL-03 JSON 탓의 실패 **0**(JSON 입력 격리) |

## 3. FAIL 재현과 위치

### 3.1 V7 — KO 언어 전환 주소가 깨져 404

**위치:** `resources/views/partials/intl/switcher.blade.php:10` 및 `:19`.

현재 PHP 런타임에서 한글 UTF-8 주소에 `parse_url($url, PHP_URL_PATH)`를 적용하면 일부 바이트가 `_`로 바뀌어 유효하지 않은 문자열이 된다. Blade의 이스케이프 뒤에는 대체문자 `�`까지 생긴다. hreflang의 원래 URL은 200인데, 그 URL에서 경로를 뽑아 만든 스위처 href는 404다.

생산 번역 JSON을 사용하지 않고 다음 기존 한국어 글에 직접 만든 번역을 붙였다.

```text
한국어 원문: /seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/
검증 EN: /en/insights/verify02-seo-en
검증 JA: /ja/insights/verify02-seo-ja
```

C1의 현재 foreign 수집 후 C2를 실행하면 다음 결과가 나온다.

```text
/en/insights/verify02-seo-en  KO href: /seo/chrome-�_-firefox�__�__-nofollow-�_�_�를-�__�_��__�__-방�_/
/ja/insights/verify02-seo-ja  KO href: /seo/chrome-�_-firefox�__�__-nofollow-�_�_�를-�__�_��__�__-방�_/
GET [위 href] -> 404, Location 없음
```

데스크톱·모바일 스위처에 각각 있어 총 4개 anchor에서 관찰했다. 중복 제거하면 실패 주소는 1개다. KO 링크를 접두 검사에서 제외해도, V7의 “페이지 안 내부 링크 전부 200/의도된 301 1홉” 조건은 충족하지 못한다. 실제 PHP 8.3/운영 환경의 재현 여부는 별도다.

### 3.2 V8 — 일반 JS의 raw JSON 출력 2개가 명시 허용 목록 밖

**위치:** `resources/views/intl/pages/faq.blade.php:42`, `:43`.

```blade
const questions = {!! json_encode($t('questions'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
const results = {!! json_encode($t('results'), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
```

이 둘은 `<script type="application/ld+json">` 안의 JSON-LD가 아니다. V8은 raw 출력의 허용 대상으로 블로그 본문과 JSON_HEX_TAG를 쓴 **JSON-LD**를 명시했다. 그래서 엄격한 허용 목록 판정은 FAIL이다. 안전한 `json_encode`라서 **실행 가능한 스크립트가 노출됐다는 판정은 아니다.**

본래 구현 스펙이 명시적으로 허용한 `e()` 후 `$lines` 줄바꿈 출력 7개도 따로 추적했다. 이를 비이스케이프 번역 출력으로 오인하지 않았다. 이들 외에 직접 `{!! __() !!}` 또는 `{!! $t(...) !!}`로 번역을 내는 코드는 없었다.

직접 주입 실험:

1. `lang/en/pages/work.php`의 `heading.0`을 `<script>alert(1)</script>`로 잠깐 바꿈.
2. `python3 "$D/run.py" snapshot escape escape`로 `/en/work` 렌더.
3. 실제 태그와 이스케이프 문자열을 각각 셈.
4. 즉시 원복하고 SHA-256 확인.

```text
literal script payload count 0
escaped count 1
```

V8을 안전한 일반 JS JSON도 허용하는 계약으로 바꿀지는 최종 검수자가 정해야 한다. 검증 세션이 임의로 허용 대상을 넓히지 않았다.

### 3.3 V9 — 홈 메타의 원문 실적 숫자 2개가 양 언어에서 누락

**위치:** 원문 `resources/views/pages/home.blade.php:14`, 번역 `lang/en/pages/home.php:11`, `lang/ja/pages/home.php:11`.

```text
KO description: 제이커브는 10년+ 경력과 1,000개 이상의 프로젝트를 경험한 SEO 업체입니다. ...
EN description: Performance ads, CPA, SEO and NAVER, Coupang and Kakao marketing for brands growing in Korea. KRW 37.3B+ cumulative ad spend managed as of 2026.
JA description: J-Curve Interactiveは、韓国市場で成長したい企業のために、...2026年時点で累計広告運用額373億ウォン以上、キャンペーン15,700件以上。
```

```text
Pages compared: 47
Home metadata omissions:
  /en/: missing ['10', '1000']
  /ja/: missing ['10', '1000']
Currency conversions: []
```

**37.3B・373億・1.28M・128万의 환산값은 맞다. 새 USD/$/円 금액도 없다.** FAIL 이유는 수치 오기나 환전이 아니라, 원문에 있던 10년/1,000건의 숫자 정보가 빠진 것이다. 메타를 외국 기업 대상의 문장으로 다시 쓰는 것은 스펙상 허용돼 있지만, V9의 숫자 보존 검사에는 메타 제외 예외가 없고 검증 지시서의 마지막 참고에서도 본보기 메타를 V9 대상으로 명시했다. 따라서 메타 재작성에 따른 숫자 생략을 자동 면제하지 않았다.

이는 Claude 본보기에서 관찰한 차이이며 INTL-02 구현 세션이 해당 본보기를 수정했다는 주장이 아니다. 생략이 승인된 의도라면 최종 검수자가 그 예외를 명시해야 한다.

## 4. 페이지별 숫자 대조와 표기 차이

DOM에서 보이는 숫자를 수집하고, 카운트 애니메이션의 초기 `0`은 원래 `data-count-to` 값으로 대응시켰다. SVG/CSS 좌표·CSRF·랜덤 id는 숫자 실적으로 세지 않았다. 한국어 보존 전용 wp-legacy 블록, 한국어 전용 도구·주문 블록 제거는 스펙의 제외 목록과 함께 확인했다. 카테고리/홈 카드의 날짜·노출 글 수는 번역 존재 여부가 다른 fixture에서 수치 변경으로 단정하지 않았다.

숫자 토큰의 출현 횟수만 같다고 합격시키지 않았다. `Call2Sale`·`B2B` 같은 이름, 한글/영문/한자 수사, 제3자→third party/第三者, 2단계 인증→two-factor/二段階, 월 숫자→영문 월 이름은 문맥을 확인했다. 전체 카운터와 차이 문맥은 `numbers.json`의 47개 페이지 레코드에 있다.

| 한국어 주소 | 직접 대조한 수치·차이 |
|---|---|
| `/` | 본문 373억→KRW37.3B/373億, 128만→1.28M/128万, 15,700 및 2026 일치. 본보기에서 반복 증거/파트너 구간 생략으로 출현 횟수 차이. 메타 10년+/1,000개+ 누락은 V9 FAIL |
| `/about-us/` | 2009·373억·128만·15,700·2026 유지. 네 가지→four/4는 표기 차이 |
| `/contact-us/` | 원문의 네 단계→four/4. 새 성과·금액 없음 |
| `/privacy` | 조항 1~4, 연락처 숫자 보존. 원문 우선 문구에 새 수치 없음 |
| `/support/faq` | 81문항, 분야 11/18/15/14/13/10. 100개·월5회·301 유지. 1:1→one-to-one/1:1은 표기 차이 |
| `/services` | 다섯 채널·네 기준→five/four, 5/4 |
| `/services/performance-marketing` | 2026·373억·15,700, 회사 전체 누적 라벨 유지 |
| `/services/cpa-marketing` | 네 조건→four/4, 단순 첫/1차 표현의 표기 차이 |
| `/services/reward-network` | 313·4.88·2/4·52,000·48,500·8%·7%·10:24/26/28·5G·절차1~4 유지. 세 가지→3은 수사 차이 |
| `/seo/` | 월50만원→KRW500,000/month・月50万ウォン. 1위 비보장 문맥 유지. 다섯 층/일주일→five/5・a week/1週間 |
| `/wordpress-agency/` | 301 유지. 다섯 가지→five/5 |
| `/services/seo/aeo` | 새 금액·실적 없음 |
| `/services/seo/geo` | 새 금액·실적 없음 |
| `/seo-backlinks/` | 제3자→third-party/第三者, 네 층→four/4는 표기 차이 |
| `/naver-place-marketing/` | 새 금액·실적 없음 |
| `/naver-shopping-marketing/` | 한 번/하나→one/1 관련 표현 차이, 새 금액 없음 |
| `/kakao-gift/` | 새 금액·실적 없음 |
| `/coupang/` | 한 번→one/1 수사 차이 |
| `/services/cpa-marketing/real-estate` | 새 금액·실적 없음 |
| `/services/cpa-marketing/stock` | 하나/한 번→one/1 수사 차이 |
| `/services/cpa-marketing/insurance` | 373억·128만·15,700·2009, 2026/회사 전체 누적 3항목 유지. 01~04 유지. 1차·제3자·네 원칙은 수사 차이 |
| `/services/cpa-marketing/coin` | 새 금액·실적 없음 |
| `/services/cpa-marketing/permission-call` | 제3자→third-party/第三者, 한 번 표현 차이 |
| `/services/performance-marketing/naver-gfa` | 한 번·두 접근 등 수사 표기 차이, 새 실적 없음 |
| `/services/performance-marketing/facebook` | 한 번 표현 차이, 새 실적 없음 |
| `/services/performance-marketing/youtube` | 한 번 표현 차이, 새 실적 없음 |
| `/services/marketing-support` | 새 지원금·선정 확률·보장 수치 없음 |
| `/solutions` | 네 개/4개→four/4 유지 |
| `/solutions/rankfree` | 30초·1,200+·6개월·0원·100개·월5회·월29,000원 유지. N1/N2/N3는 지표 이름 |
| `/solutions/boostingshop` | 월50만원 2곳→KRW500,000/month・月50万ウォン, 세 페이지→three/3 |
| `/solutions/shopitrend` | 새 금액·실적 없음 |
| `/solutions/leadbay` | 제3자→third-party/第三者, 새 금액 없음 |
| `/solutions/call2sale` | 브랜드 속 2를 실적으로 세지 않음. 새 금액·실적 없음 |
| `/solutions/boostingshop/basic` | 검색1위 비보장 문맥 유지 |
| `/solutions/boostingshop/pro` | 한 번 표현 차이, 새 실적 없음 |
| `/solutions/boostingshop/elite` | 한 번/두 구간 표현 차이, 새 실적 없음 |
| `/solutions/boostingshop/instagram-popular` | 2단계 인증→two-factor/二段階, 보장 수치 추가 없음 |
| `/solutions/boostingshop/instagram-followers` | 2단계 인증→two-factor/二段階, 보장 수치 추가 없음 |
| `/solutions/boostingshop/instagram-likes` | 2단계 인증→two-factor/二段階, 한 번 표현 차이 |
| `/self-marketing` | 30초·0원 2곳·1,200+·100개·월5회·6개월·월50만원·29,000원·단계1~4/1~3 유지 |
| `/self-marketing/place` | 1분·100명·10/20/30일·12종·24시간·100개/월5회 유지. 2026년10월→October2026/2026年10月은 표기 차이. 실적 오인 가능한 한국어 로컬 견본은 제외 |
| `/work` | 373억·128만·15,700·2009, 2026/회사 전체 누적 라벨 유지 |
| `/blog/` | 번역 있는 글만 노출. 날짜는 EN 월 이름/JA年月日. 생산 번역 본문 숫자는 범위 밖 |

추가로 `performance-marketing`, `news`, `seo`, `link-building`의 카테고리 4개도 검사했다. 번역 fixture의 게시일과 원문의 동일 게시일을 언어별 날짜 형식으로 보여 주며, 한국어 목록 전체와 외국어 목록의 게시글 수가 다른 것은 번역 필터의 결과다.

## 5. 무력화 실험과 원복

실험은 순차로 했다. 각 변이를 적용한 상태에서 아래 명령을 직접 실행하고, 다음 실험 전에 원복했다.

| 변이 | 실행 명령 (`D`는 §1) | 실제 결과 |
|---|---|---|
| 한국어 footer의 `</footer>` 앞 공백 1개 | `python3 "$D/run.py" compare-impl mutant-footer-space` | exit1, 비교109개 중 **102 DIFF**, footer의 추가 공백이 diff에 표시됨 |
| `lang/en/pages/insights.php`의 `heading` 삭제 | `python3 "$D/run.py" test mutant-deleted-key --filter=test_translated_pagination_and_article_rendering_use_locale_data` | **1 tests / 0 passed / 9 assertions**, `/en/blog/ Translation key: pages/insights.heading` |
| 외국어 insights index의 main에 `<p>무력화</p>` 삽입 | `python3 "$D/run.py" test mutant-hangul --filter=test_translated_pagination_and_article_rendering_use_locale_data` | **1 / 0 / 8**, `/en/blog/ Hangul: 무력화` |
| `IntlRoutes::available`의 `! View::exists(...)` 조건 제거 | `python3 "$D/run.py" test mutant-no-view-check --filter=test_missing_view_is_excluded_from_rendering_alternates_and_sitemap` | **1 / 0 / 2**, `Missing foreign view must suppress hreflang`, `4 is identical to 0` |
| SEO 매핑을 `services.verify02-missing`으로 변경 | `python3 "$D/run.py" snapshot mapping mapping` | KO hreflang0, EN/JA404, sitemap EN/JA 주소 없음 |
| work heading에 `<script>alert(1)</script>` | `python3 "$D/run.py" snapshot escape escape` | 실행 가능한 원문 태그0, escaped payload1 |

### 5개 실험 파일의 원복 SHA-256

아래는 실험 전과 실험 후가 **전부 같은 값**이다. `hash-initial.json`과 각 `hash-*-restored.json`에 실제 출력이 있다.

| 파일 | 실험 전 = 원복 후 SHA-256 |
|---|---|
| `app/Support/IntlRoutes.php` | `3b4f8bb027643eb4bec6ecd22a38acd98c0a5a58b539b79edfcf1b53139fc9ae` |
| `lang/en/pages/insights.php` | `5299149a4e97ee403e2fb2dcd0b541b5fac4c008c08268b709d7c76debbca298` |
| `resources/views/intl/insights/index.blade.php` | `2620afe2cbcfc92c39876bd067bc8f19aa75f4fac57f343a1550d9b853212bf5` |
| `resources/views/partials/jc/footer.blade.php` | `4092aa2989048952a20b40c76c39167b4130a4e761ddc139f30f7c890c2788e5` |
| `lang/en/pages/work.php` | `ae2cc28b88151f1c1c683048f8dfb144231b1a207dbe1fec5c90b45b52f1a6a1` |

`git diff | shasum`에 해당하는 SHA-1도 별도로 기록했다.

| 관찰 시점 | 전역 diff SHA-1 |
|---|---|
| 첫 실험 전 | `91987160e6b83ce87be3a4d9ff4d6a202b49a954` |
| footer 원복 뒤 | `91987160e6b83ce87be3a4d9ff4d6a202b49a954` |
| 키 삭제 원복 뒤 | `91987160e6b83ce87be3a4d9ff4d6a202b49a954` |
| 한글 삽입 원복 뒤 | `b388defd55e33f46cdfccba271dcb6d383937ab5` |
| 뷰 존재 확인 원복 뒤 | `b388defd55e33f46cdfccba271dcb6d383937ab5` |
| 잘못된 매핑 원복 뒤 | `b388defd55e33f46cdfccba271dcb6d383937ab5` |
| 스크립트 주입 원복 뒤 | `b388defd55e33f46cdfccba271dcb6d383937ab5` |
| 보고서 작성 준비 시점 | `32edf05145879ab13bc77ccda02b3313c0270c54` |

**전역 diff가 세션 내내 동일했다고 주장하지 않는다.** 한글 실험 무렵 다른 세션이 번역 JSON·GLOSSARY·en/ja FAQ/privacy를 바꾸는 것을 `git diff --name-only`로 관찰했고, 이후 체크포인트로 HEAD도 이동했다. 실험 대상 5파일의 바이트는 전부 초기 해시로 복구됐다. 다른 세션 파일을 원복하지 않았다. 전역 해시 변경을 숨기거나 통과 해시로 덮어쓰지 않았다.

한국어 허용 파일의 검사 시 SHA-256:

```text
partials/jc/head.blade.php      174a5ce9a2b8fcfa5eb780d245786a61e1cb222a715553b5a5492e35e7998694
partials/jc/header.blade.php    c0ba09d21d3465b85834d42ce79cb70c83e3835227dc5dce43af2d01f4333341
partials/intl/switcher.blade.php 1a93e766792212d913a30d8f906a7ed46dcd068e3230a2ed10b842b24c66b0a9
```

## 6. 게이트 실제 출력과 검증기 보정

전체 테스트 최종 성공 출력:

```json
{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008}
```

독립 문의 테스트(저장소의 206개에 합산하지 않음):

```json
{"tool":"phpunit","result":"passed","tests":2,"passed":2,"assertions":51}
```

```text
EN invalid: The selected service interest is invalid.
EN empty: The name field is required. / The email field is required. / The service interest field is required. / The message field is required.
JA invalid: 選択したご希望のサービスは正しくありません。
JA empty: お名前は必須です。 / メールアドレスは必須です。 / ご希望のサービスは必須です。 / お問い合わせ内容は必須です。
각 언어 정상저장 1, 허용밖값 0, 빈값 0, 허니팟 0
```

Pint는 `git diff --name-only 0662117 HEAD`의 신규·변경 PHP 중 Blade를 제외한 **89파일**을 명시해서 실행했다. 경로 목록은 `pint-files.json` 및 `pint.log`에 있다.

```json
{"tool":"pint","result":"passed"}
```

빌드 기본 명령:

```text
npm run build -> exit 1
Error: EPERM: operation not permitted, open '.../node_modules/.vite-temp/vite.config.js.timestamp-1793688622379-cc0d035d78db3.mjs'
```

지시서의 대체 명령:

```text
npx vite build --configLoader runner -> exit 0
vite v8.2.0 building client environment for production...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
12 modules transformed.
public/build/manifest.json 0.88 kB
built in 1.63s
```

미디어 경고는 남아 있다. `public/media/`는 변경하지 않았다.

초기 검증기의 테스트 환경을 공개 origin으로 지정했을 때 URL 기대값 2개가 실패했다. 테스트용 `APP_URL=http://localhost`로 바로잡은 뒤 206/206을 재현했다. 초기 커스텀 문의 검사에서는 HTTP kernel의 미들웨어 초기화 전에 그룹을 조회해 CSRF를 세지 못했으므로, 실제 GET으로 kernel을 초기화한 뒤 클래스 목록을 다시 비교했다. 수집 중 자기 SQLite를 동시에 쓰는 실행도 폐기하고 순차 재실행했다. 이러한 검증기 오류를 제품 FAIL로 세지 않았으며, 표의 결과는 교정 뒤 생성된 증거다.

## 7. 확신 없는 표현·판정 한계

아래는 번역 품질/공식 명칭에 대한 검수 후보이며 자동 FAIL 수에 추가하지 않았다. 외부 업계 관례를 확인한 사실처럼 쓰지 않았다.

| 화면 | 키/파일 | 실제 표현 | 검수 이유 |
|---|---|---|---|
| 보험 서브페이지 | `lang/en/subpages.php`, insurance 리드 유형 | `Semi-silver leads` | 국내 영업 용어의 영어 관용성 확인 필요 |
| 보험 서브페이지 | `lang/ja/subpages.php`, 같은 유형 | `準シルバーリード` / `シルバーリード` | 일본 보험 영업 독자가 이해할 정의가 필요한지 확인 |
| 보험 서브페이지 | insurance title·lead | `after-sales support` | 고객 지원인지 불량 리드 교환/보상인지 오독 가능성 |
| LeadBay | `pages/leadbay.s006` | `quality score` | 확정 품질/성과 지표로 오인되지 않는지 문맥 검수 |
| Call2Sale | `pages/call2sale.s007` | `AI call quality analysis` | 분석 범위와 판정 보장으로 오인될 표현 검수 |
| ShopiTrend | `pages/shopitrend.s007`, `s035` | `Ohouse` | 한국 플랫폼의 공식 브랜드 표기와 첫 설명 검수 |
| 홈 앱 | `pages/home.apps.items` | `Kkulkkul Cash` | 공식 영문 브랜드명 확인 필요 |
| 홈 앱 | `pages/home.apps.items` | `Kkuk Tech` | 공식 영문 브랜드명 확인 필요 |
| 제휴 앱 띠 | `pages/self-marketing-place`, 앱 이름 맵 | `Potato Farm` | 원문 앱과 공식 외국어 이름의 대응 확인 필요 |
| 일본어 홈 앱 | `pages/home.apps.items` | `ポイ活アプリ` | B2B 독자 대상에서 적절한 용어인지 교열 필요 |
| 일본어 보험 | insurance 적합 고객 | `保険代理店（GA）` | 국내 GA 약어를 일본어 문맥에서 보충 설명할지 확인 |
| 솔루션 소개 | `pages/solutions-index.s088` | `permission, consent and handling rules` | permission/consent의 구분이 독자에게 명확한지 확인 |

확인하지 않은 범위와 한계:

- INTL-03 생산 번역 JSON, 실제 52편의 숫자·고유명사·본문 링크·번역 품질은 범위 밖이다. 전체 테스트에서 그 JSON 때문에 실패한 항목이 없다는 것은 **입력을 격리한 테스트의 결과**이며 생산 JSON 승인 증거가 아니다.
- 실제 브라우저의 반응형·시각·키보드·FAQ 검색/필터 JS 동작은 이번 V1~V15 HTTP/코드 검사에 포함하지 않았다. 외부 서비스 가격/계약 현황도 조사하지 않았다.
- CSRF는 Laravel 테스트 모드에서 토큰 거절을 실브라우저로 검증한 것이 아니라, 요구된 실제 route middleware의 동일성을 검증했다.
- V12의 `inLanguage`는 EN/JA JSON-LD에서 확인했다. 한국어 원문 JSON-LD에는 기준본부터 이 속성이 없으며 V1의 한국어 무변경 조건에 따라 손대지 않았다.
- V13은 허용 파일 밖 한국어 차이 0과 구현 반환물 파일 표의 일치를 확인했다. 합쳐진 체크포인트와 시작 당시 미커밋 파일만으로 과거의 모든 타 세션 쓰기 행위를 독립 귀속시킬 수는 없다.
- 다른 세션의 FAQ/privacy/일본어 subpages 변경을 관찰해 최신본으로 추가 수집·Pint·전체 테스트를 실행했다. 검사 범위 파일의 해시 manifest는 `scope-*.json`에 있다. 이후 다른 세션이 계속 변경하는 부분까지 이 판정을 소급 적용하지 않는다.
- 작업 지시의 수정 금지와 쓰기 허용 범위에 따라 외부 대시보드 tasks.json 및 대시보드 생성기는 변경·실행하지 않았다.

**반환: PASS 12 / FAIL 3. 제품 코드의 지속 수정 없이 판정과 근거만 남겼다.**
