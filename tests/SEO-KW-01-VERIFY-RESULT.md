# SEO-KW-01-V 독립 검증 결과

검증일: 2026-11-04 KST · 검증자: Codex · 대상 HEAD: `b4e1325288aa213da394a6e4e6ee88963fa0cb04`

## 판정

**추가분까지 포함한 전체 판정: 실패 — 19개 중 18개 통과, 1개 실패(시나리오 16, 낮은 심각도).**

기본 합격 게이트(시나리오 1~12, 전체 테스트, 무력화 실험, 복구)는 통과했다. 다만 추가 시나리오 16의 “160자를 넘으면 생략기호 포함 정확히 160자” 조건은 공백 경계에서 재현 실패했다. 최대 160자 이내라는 조건은 지키며, 현재 원고의 설명이 손상된 사례는 발견하지 못했다.

- 최종 전체 테스트: **279/279, 23,813 assertions**, exit 0.
- 무력화 실험: **10/10 실제 빨강**, 실험마다 복구 SHA-256 및 전체 git diff 동일 확인.
- 로컬 SQLite `:memory:`에 카테고리·기존 글·이전표·키워드 시더를 넣어 재현했다. 운영 서버·운영 DB에 접속하지 않았다. URL의 운영 도메인은 문자열과 로컬 커널 요청에만 사용했다.
- 앞 구현 보고서·앞 증거 파일을 판정 근거로 사용하지 않았다. 이 세션에서 새로 실행한 출력만 사용했다.
- 소스·기존 테스트·문서의 영구 변경 없음. 저장한 저장소 파일은 이 보고서 하나다. git 쓰기 명령 없음.

## 발견한 문제 — 심각도 순

### P3 / 낮음 — 설명문 잘림 경계에 공백이 있으면 160자가 아닌 159자 출력

위치: `resources/views/insights/show.blade.php:26`의 아래 제한 함수.

```php
$sdLimit = fn (string $s, int $n): string => mb_strlen($s) > $n ? rtrim(mb_substr($s, 0, $n - 1)).'…' : $s;
```

입력 `str_repeat('가', 158).' '.str_repeat('나', 2)`는 161자다. 앞 159자 안에 든 마지막 공백을 `rtrim()`이 제거하므로 결과는 `가 × 158 + …`, 총 159자다. 기존 길이 테스트는 이 공백 경계를 다루지 않아 전체 279개가 초록이어도 이 조건 위반은 남는다. 보안 문제나 실제 검색 성과 저하는 이번 실험으로 확인되지 않았다.

실제 실행:

```sh
python3 /private/tmp/jcurve-seo-kw-verify/verify.py probe independent-current-complete current
python3 /private/tmp/jcurve-seo-kw-verify/assess.py 16
```

실제 렌더에서 추출한 출력:

```json
[
  {
    "case": "Korean-159",
    "input": 159,
    "output": 159,
    "last": "가",
    "prefix_characters": 158
  },
  {
    "case": "Korean-160",
    "input": 160,
    "output": 160,
    "last": "가",
    "prefix_characters": 159
  },
  {
    "case": "Korean-161",
    "input": 161,
    "output": 160,
    "last": "…",
    "prefix_characters": 159
  },
  {
    "case": "Korean-220",
    "input": 220,
    "output": 160,
    "last": "…",
    "prefix_characters": 159
  },
  {
    "case": "space-at-cutoff",
    "input": 161,
    "output": 159,
    "last": "…",
    "prefix_characters": 158
  }
]
```

그 밖 Critical/High/Medium 구현 결함은 이번 검증 범위에서 발견하지 못했다. 수정은 하지 않았다.

## 시나리오별 판정표

아래 명령에서 `V=/private/tmp/jcurve-seo-kw-verify`다. `assess.py N`은 이 세션에서 렌더·DB·기준 커밋을 직접 수집한 JSON을 검사해 해당 시나리오의 측정값을 출력한다. 분석 프로그램의 exit 0 자체를 제품 통과로 해석하지 않고 출력의 verdict를 판정으로 삼았다.

| 번호 | 시나리오 | 판정 | 근거 명령 | 실제 측정 결과 |
|---|---|---|---|---|
| 1 | 열린 리다이렉트 | **통과** | `python3 $V/assess.py 1` | 5개 입력 모두 301. Location은 `/v1/manager/data/`로 시작. 원문 CR/LF 및 X-Injected 헤더 없음. |
| 2 | JSON-LD 주입 | **통과** | `python3 $V/assess.py 2` | 제목·설명·카테고리에 script 종료 태그, 역슬래시/인용부호, U+2028 투입. JSON 오류 0, 주입 script 노드 0. |
| 3 | 원주소 보존 | **통과** | `python3 $V/assess.py 3` | 16개 비교. canonical 16개 동일. 제목·설명은 허용된 쇼핑 페이지 1곳만 변경. |
| 4 | canonical·robots | **통과** | `python3 $V/assess.py 4` | 사이트맵 고유 URL 107개 모두 200·자기 canonical·index. 위반 0. |
| 5 | 빈 카테고리 | **통과** | `python3 $V/assess.py 5` | reward: 빈 상태 noindex·사이트맵 제외 → 1편 공개 후 index·포함. seo/link-building: 빈 상태도 index·포함. |
| 6 | 새 글 시더 | **통과** | `python3 $V/assess.py 6` | 두 번 실행 후 새 글 5편, 두 실행의 전체 행 바이트 값 동일. manifest/본문/카테고리 불일치 0. 누락 카테고리 예외·행 수 불변. |
| 7 | 설명 49편·필드 보존 | **통과** | `python3 $V/assess.py 7` | 49/49 설명 값 일치. 제목·본문 등 예상 밖 필드 변경 0. 중복 글의 published_at NULL만 별도 허용. |
| 8 | 중복 글·이전표 체인 | **통과** | `python3 $V/assess.py 8` | 중복 행 보존·비공개·사이트맵/RSS 제외. 관련 이전표 5개 모두 301→200. |
| 9 | 사이트맵 구조 | **통과** | `python3 $V/assess.py 9` | pages 19·services 32·insights 56. works 제외. 묶음 lastmod 3개 형식 정상. 이미지 3개 절대 주소. shopping 포함. |
| 10 | llms.txt·robots.txt | **통과** | `python3 $V/assess.py 10` | 로컬 HTTP GET/HEAD 두 파일 모두 200·text/plain; charset=UTF-8. llms 공개 링크 16개 모두 200, 엔티티/차단 줄 0. |
| 11 | 약속 문구 | **통과** | `python3 $V/assess.py 11` | 변경분에서 후보 54줄을 추출해 문맥 검토. 보장/조작 제공 약속 없음. 부정문·경고·FAQ 질문과 구분. |
| 12 | 성과 수치·미디어 | **통과** | `python3 $V/assess.py 12` | 기존 숫자·고지 삭제/변경 0. llms에 동일 수치와 회사 전체 누적·2026년 기준 표기 추가. public/media 변경 0. |
| 13 | FAQPage 정합성 | **통과** | `python3 $V/assess.py 13` | 107페이지 JSON-LD 파싱 오류 0. FAQPage 있는 44페이지 질문 = summary/본문 h3. 중복 FAQPage·답 HTML 0. |
| 14 | FAQ 배열 전환 회귀 | **통과** | `python3 $V/assess.py 14` | c9cf526 렌더와 5페이지 36개 FAQ 질문·답·링크 목적지 모두 동일. |
| 15 | 위치 경로·Service | **통과** | `python3 $V/assess.py 15` | BreadcrumbList 95페이지·Service 34페이지 검사. 마지막 item=canonical·공개 주소·중복 없음. item 고유 목적지 102개 모두 200. |
| 16 | 설명문 길이 | **실패** | `python3 $V/assess.py 16` | 원주소 글 3편 설명 동일. 공개 48편 설명 그대로, 비공개 중복 1편 DB 일치·301은 정상. 공백 경계의 161자 입력은 159자로 출력되어 정확히 160자 계약 위반. |
| 17 | 확인 태그 | **통과** | `python3 $V/assess.py 17` | 107페이지 모두 기존 Google 확인 값 정확히 1개, Naver 확인 태그 0. |
| 18 | 푸터·헤더 링크 | **통과** | `python3 $V/assess.py 18` | 107페이지 푸터 두 리워드 링크 있음. 헤더 소스 바이트 동일, 원주소 16페이지의 데스크톱·모바일 헤더 링크 배열 동일. |
| 19 | 새 글 원고 | **통과** | `python3 $V/assess.py 19` | HTML 5개+manifest+설명 JSON, 7쌍 모두 SHA-256/바이트 동일. 새 FAQ·표 문맥 검토에서 금지 약속 없음. |

## 실행 환경·원자료

작업 디렉터리: `/Users/anarchy/Claude_Projects/jcurve`.

테스트 실행은 `verify.py`의 subprocess에서 다음 환경을 지정했다. DB 연결 URL은 빈 값으로 고정하고 캐시·뷰·로그·테스트 결과 경로를 격리했다. 독립 PHP probe는 환경 파일 경로도 임시 폴더로 바꾼다. 테스트 시간은 독립 probe에서 2026-11-05 12:00:00 UTC로 고정했다(운영 시각 관측값이 아님).

```text
APP_ENV=testing
APP_URL=http://localhost
SEO_PUBLIC_URL=https://j-curve.co.kr
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
DB_URL=
CACHE_STORE=array
SESSION_DRIVER=array
QUEUE_CONNECTION=sync
MAIL_MAILER=array
LOG_CHANNEL=stderr
VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-verify/views
APP_CONFIG_CACHE=/private/tmp/jcurve-seo-kw-verify/config-cache.php
TMPDIR=/private/tmp/jcurve-seo-kw-verify
TMP=/private/tmp/jcurve-seo-kw-verify
TEMP=/private/tmp/jcurve-seo-kw-verify
```

기준 커밋은 checkout/reset/restore 없이 파일마다 `git show <커밋>:<파일>`로 읽었다. 70ccde4의 뷰 트리 파일 96개와 설정 2개를 임시 폴더에 재구성하고, 현재와 동일한 기존 콘텐츠 fixture로 메타를 렌더해 비교했다. FAQ 전환은 c9cf526의 지정 파일 5개를 별도로 렌더했다. 비교에 필요한 URL 생성·기존 콘텐츠 시더 등의 코드는 기준 이후 변경되지 않았음을 변경 목록으로 확인했다.

```sh
python3 /private/tmp/jcurve-seo-kw-verify/verify.py baseline
# 내부에서 파일별 실행:
git show 70ccde4:resources/views/partials/jc/head.blade.php
git show 70ccde4:config/subpages.php
git show c9cf526:resources/views/solutions/rankfree.blade.php
python3 /private/tmp/jcurve-seo-kw-verify/verify.py probe independent-baseline-complete baseline
python3 /private/tmp/jcurve-seo-kw-verify/verify.py probe independent-faq-baseline faq-baseline
python3 /private/tmp/jcurve-seo-kw-verify/verify.py probe independent-current-complete current
python3 /private/tmp/jcurve-seo-kw-verify/static_http.py
python3 /private/tmp/jcurve-seo-kw-verify/assess.py
```

수집 출력:

```text
baseline files from git show 98 FAQ baseline files 5
{"mode":"baseline","db":{"driver":"sqlite","database":":memory:"},"preserved":16,"pages":0,"evidence":"/private/tmp/jcurve-seo-kw-verify/baseline.json"}
{"mode":"faq-baseline","db":{"driver":"sqlite","database":":memory:"},"preserved":0,"pages":0,"evidence":"/private/tmp/jcurve-seo-kw-verify/faq-baseline.json"}
{"mode":"current","db":{"driver":"sqlite","database":":memory:"},"preserved":16,"pages":107,"evidence":"/private/tmp/jcurve-seo-kw-verify/current.json"}
```

최종 분석 실제 출력:

```json
{"passed": 18, "failed": 1, "verdicts": {"1": "통과", "2": "통과", "3": "통과", "4": "통과", "5": "통과", "6": "통과", "7": "통과", "8": "통과", "9": "통과", "10": "통과", "11": "통과", "12": "통과", "13": "통과", "14": "통과", "15": "통과", "16": "실패", "17": "통과", "18": "통과", "19": "통과"}, "mutations": [{"id": "M01-route", "exit": 1, "tests": 7, "red": 7, "restored": true}, {"id": "M02-empty-section", "exit": 1, "tests": 1, "red": 1, "restored": true}, {"id": "M03-duplicate", "exit": 1, "tests": 1, "red": 1, "restored": true}, {"id": "M04-head", "exit": 2, "tests": 1, "red": 1, "restored": true}, {"id": "M05-guest", "exit": 1, "tests": 3, "red": 3, "restored": true}, {"id": "M06-faq", "exit": 2, "tests": 1, "red": 1, "restored": true}, {"id": "M07-rankfree", "exit": 1, "tests": 1, "red": 1, "restored": true}, {"id": "M08-description", "exit": 1, "tests": 5, "red": 5, "restored": true}, {"id": "M09-category", "exit": 1, "tests": 5, "red": 2, "restored": true}, {"id": "M10-footer", "exit": 1, "tests": 3, "red": 3, "restored": true}]}
```

원자료는 모두 `/private/tmp/jcurve-seo-kw-verify/` 아래에 있다: `current.json`, `baseline.json`, `faq-baseline.json`, `assessment.json`, `static-http.json`, `pages/*.html`, `logs/*.log`, `logs/*.xml`, `logs/*-restoration.json`, `backups/*.bin`. 임시 스크립트 SHA-256:

| 파일 | SHA-256 |
|---|---|
| verify.py | `f1c0ea4e9b3af451159caefeaa0f1105cca93fddd4537b2365024d022e86f0a5` |
| probe.php | `c6a85c43313daf3e4a41d4d465a2e325a59b95aaafd868162112dbc253cf7cbe` |
| assess.py | `0ae43802fdcea96de996db3513df593efa00ecc6c6b3c7a858bbb9afd87e0e8d` |
| static_http.py | `177d710dbdd3955b191dd6800db825eec9bc5eb3e311e3f56d06c9e618bacf90` |

## 전체 테스트 — 실제 명령·출력

최종 명령(위 환경 적용):

```sh
python3 /private/tmp/jcurve-seo-kw-verify/verify.py suite full-restored-strict-tmp
# 실제 하위 프로세스:
php artisan test --do-not-cache-result --log-junit /private/tmp/jcurve-seo-kw-verify/logs/full-restored-strict-tmp.xml
```

실제 출력(exit 0):

```json
{"tool":"phpunit","result":"passed","tests":279,"passed":279,"assertions":23813,"duration_ms":13539}
```

무력화 전 정상 환경 실행(exit 0):

```json
{"tool":"phpunit","result":"passed","tests":279,"passed":279,"assertions":23813,"duration_ms":15756}
```

원본 로그 SHA-256:

| 실행 | exit | 로그 SHA-256 |
|---|---|---|
| full-isolated | 0 | `495be7d0f54fcae01e6882b3cd3fcc2603aad3a79589067cff3c7e157313c141` |
| full-restored | 0 | `ee59fa67f4e8065d019a688a932f1fa8310166a3b477d9fc36fe3a4aa29141bf` |
| full-restored-strict-tmp | 0 | `256e87b4dc90bb1914e27d2ff3505f6120caad7e1bcb644a81151265a7253dc3` |

## 무력화 실험

각 실험은 한 파일의 보호 동작만 임시로 되돌렸다. 실행 전후 임시 컴파일 뷰를 비워 mtime/컴파일 캐시 때문에 초록이 남는 상황을 피했다. 정상 기준은 앞의 전체 테스트다. 표의 “빨강/실행”은 실패·오류 테스트 수/실행 테스트 수다. JSON_HEX_TAG 제거의 exit 2는 JSON 파싱 오류로 실제 빨강이다.

빈 묶음 제외는 현재 FeedCatalog가 반환한 빈 목록을 SeoFeedController의 반복 횟수 0으로 거르는 구조다. 따라서 M02는 실제 동작 지점인 SeoFeedController를 기준 동작(빈 묶음도 1페이지)으로 되돌렸다.

공통 실제 명령 형식:

```sh
python3 /private/tmp/jcurve-seo-kw-verify/verify.py mut-test '<ID>' '<filter>'
# 내부 실행:
php artisan test --filter '<filter>' --do-not-cache-result --log-junit /private/tmp/jcurve-seo-kw-verify/logs/<ID>.xml
# 파일 원복 직후:
python3 /private/tmp/jcurve-seo-kw-verify/verify.py check '<파일>' '<ID>'
```

| ID | 임시 무력화 | 실제 --filter | exit | 빨강/실행 | 실제 실패 출력(첫 원인) | 판정 |
|---|---|---|---|---|---|---|
| M01-route | manager/data 라우트 제거 | `test_legacy_media_` | 1 | 7/7 | Tests\Feature\SeoKeywordFoundationTest::test_legacy_media_redirect_preserves_path_and_query_bytes with data set "nested image" | 통과(검출) |
| M02-empty-section | 빈 묶음도 최소 1페이지 광고 | `test_empty_sections_are_not_advertised` | 1 | 1/1 | Tests\Feature\SeoKeywordFoundationTest::test_empty_sections_are_not_advertised_but_first_pages_stay_available | 통과(검출) |
| M03-duplicate | 중복 글 비공개 갱신 제거 | `test_duplicate_is_retained_unpublished` | 1 | 1/1 | Tests\Feature\KeywordInsightTest::test_duplicate_is_retained_unpublished_and_all_inbound_redirects_finish_in_one_hop | 통과(검출) |
| M04-head | head JSON_HEX_TAG 제거 | `test_head_jsonld_escapes_script_endings` | 2 | 1/1 | Tests\Feature\SeoKeywordViewsTest::test_head_jsonld_escapes_script_endings_and_decodes_html_entities | 통과(검출) |
| M05-guest | guest robots 메타 제거 | `test_guest_pages_are_noindex` | 1 | 3/3 | Tests\Feature\SeoKeywordViewsTest::test_guest_pages_are_noindex_and_have_their_korean_titles with data set #0 | 통과(검출) |
| M06-faq | schema-faq JSON_HEX_TAG 제거 | `test_faq_jsonld_escapes_script_endings` | 2 | 1/1 | Tests\Feature\SeoKeywordViewsTest::test_faq_jsonld_escapes_script_endings_in_an_insight_question | 통과(검출) |
| M07-rankfree | rankfree sd_page 제거 | `test_page_breadcrumb_and_service_contract.*rankfree` | 1 | 1/1 | Tests\Feature\SeoKeywordViewsTest::test_page_breadcrumb_and_service_contract with data set "/solutions/rankfree" | 통과(검출) |
| M08-description | Str::limit($s, 155)로 되돌림 | `test_insight_description_uses_160\|test_new_articles_render_their_own_canonical` | 1 | 5/5 | Tests\Feature\KeywordInsightTest::test_new_articles_render_their_own_canonical_metadata_and_appear_in_the_insights_sitemap | 통과(검출) |
| M09-category | 빈 카테고리 noindex 블록 제거 | `test_only_empty_nonpreserved_categories_are_noindex` | 1 | 2/5 | Tests\Feature\SeoKeywordViewsTest::test_only_empty_nonpreserved_categories_are_noindex with data set "empty" | 통과(검출) |
| M10-footer | footer self.children 반복 제거 | `test_footer_has_both_reward_links` | 1 | 3/3 | Tests\Feature\SeoKeywordViewsTest::test_footer_has_both_reward_links_and_desktop_header_has_one_self_link with data set #0 | 통과(검출) |

각 실험의 빨간 테스트 이름(실제 JUnit):

- M01-route: `test_legacy_media_redirect_preserves_path_and_query_bytes with data set "nested image"`, `test_legacy_media_redirect_preserves_path_and_query_bytes with data set "query bytes and duplicate keys"`, `test_legacy_media_redirect_preserves_path_and_query_bytes with data set "Korean path"`, `test_legacy_media_redirect_preserves_path_and_query_bytes with data set "encoded delimiters and percent"`, `test_legacy_media_redirect_preserves_path_and_query_bytes with data set "other data directory"`, `test_legacy_media_redirect_preserves_path_and_query_bytes with data set "trailing slash"`, `test_legacy_media_head_uses_the_same_redirect`
- M02-empty-section: `test_empty_sections_are_not_advertised_but_first_pages_stay_available`
- M03-duplicate: `test_duplicate_is_retained_unpublished_and_all_inbound_redirects_finish_in_one_hop`
- M04-head: `test_head_jsonld_escapes_script_endings_and_decodes_html_entities`
- M05-guest: `test_guest_pages_are_noindex_and_have_their_korean_titles with data set #0`, `test_guest_pages_are_noindex_and_have_their_korean_titles with data set #1`, `test_guest_pages_are_noindex_and_have_their_korean_titles with data set #2`
- M06-faq: `test_faq_jsonld_escapes_script_endings_in_an_insight_question`
- M07-rankfree: `test_page_breadcrumb_and_service_contract with data set "/solutions/rankfree"`
- M08-description: `test_new_articles_render_their_own_canonical_metadata_and_appear_in_the_insights_sitemap`, `test_insight_description_uses_160_characters_including_the_ellipsis with data set "159 Korean characters"`, `test_insight_description_uses_160_characters_including_the_ellipsis with data set "160 Korean characters"`, `test_insight_description_uses_160_characters_including_the_ellipsis with data set "161 Korean characters"`, `test_insight_description_uses_160_characters_including_the_ellipsis with data set "161 ASCII characters"`
- M09-category: `test_only_empty_nonpreserved_categories_are_noindex with data set "empty"`, `test_only_empty_nonpreserved_categories_are_noindex with data set "only unpublished and future articles"`
- M10-footer: `test_footer_has_both_reward_links_and_desktop_header_has_one_self_link with data set #0`, `test_footer_has_both_reward_links_and_desktop_header_has_one_self_link with data set #1`, `test_footer_has_both_reward_links_and_desktop_header_has_one_self_link with data set #2`

## 복구 증명 — SHA-256·git diff

모든 행의 복구 후 SHA-256은 실험 전 SHA-256과 같다. 각 실험 직후 `git diff --binary`의 해시는 공통으로 `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`(0바이트), 기준 70ccde4 대비 diff 해시도 시작과 동일한 `41aa631ae40503bc9b65f581fcd8be9c06c7ae5ca6bd8797359238be1735cb93`였다.

| ID | 파일 | 실험 전 SHA-256 | 복구 후 SHA-256 | 전체 git diff 동일 |
|---|---|---|---|---|
| M01-route | routes/web.php | `a839d9e0f7a5f59a0e7c5023214bd26b638084ae5ce1d9be13ba31a19b105083` | `a839d9e0f7a5f59a0e7c5023214bd26b638084ae5ce1d9be13ba31a19b105083` | true |
| M02-empty-section | app/Http/Controllers/SeoFeedController.php | `939d43dd3b932b1aaba94bf7c900b685bf37cfcdc76609dc7af17c649e4ffd97` | `939d43dd3b932b1aaba94bf7c900b685bf37cfcdc76609dc7af17c649e4ffd97` | true |
| M03-duplicate | database/seeders/KeywordInsightSeeder.php | `d9e9831508d7d31c0929f0396da024300b52cf38633a9d9d1d607b91631f88a7` | `d9e9831508d7d31c0929f0396da024300b52cf38633a9d9d1d607b91631f88a7` | true |
| M04-head | resources/views/partials/jc/head.blade.php | `ab284b12e1067d74666948d76cbff7d05646f81db8add63414a811a3be32eea1` | `ab284b12e1067d74666948d76cbff7d05646f81db8add63414a811a3be32eea1` | true |
| M05-guest | resources/views/layouts/guest.blade.php | `468f2b1ed79fabcd39571b19c47af04ba219abe84cd635f7972fc2b4cabe36d0` | `468f2b1ed79fabcd39571b19c47af04ba219abe84cd635f7972fc2b4cabe36d0` | true |
| M06-faq | resources/views/partials/jc/schema-faq.blade.php | `51a0731e1f7560c84e967e0e39b764fbc0392d597fb54272a890853959acc934` | `51a0731e1f7560c84e967e0e39b764fbc0392d597fb54272a890853959acc934` | true |
| M07-rankfree | resources/views/solutions/rankfree.blade.php | `387901f59a0a1e54c110c51e3e8feebb52d86a81059874700956d59d3d28f46f` | `387901f59a0a1e54c110c51e3e8feebb52d86a81059874700956d59d3d28f46f` | true |
| M08-description | resources/views/insights/show.blade.php | `759f4274f306703b96bb96fdccd2cf835396907aa8c91b3c0fead1ec56d2e272` | `759f4274f306703b96bb96fdccd2cf835396907aa8c91b3c0fead1ec56d2e272` | true |
| M09-category | resources/views/insights/category.blade.php | `62cbe5c41a6a04aa29b711546377cd7410670b7854c8668dcde92ad9e25a177f` | `62cbe5c41a6a04aa29b711546377cd7410670b7854c8668dcde92ad9e25a177f` | true |
| M10-footer | resources/views/partials/jc/footer.blade.php | `3b9ea5c84822a5ede34c0290366b70bc3a2885d1f9e1483ea974be193c4ec5a4` | `3b9ea5c84822a5ede34c0290366b70bc3a2885d1f9e1483ea974be193c4ec5a4` | true |

보고서 저장 직전 전체 검사 실제 명령:

```sh
git status --short --untracked-files=all
git diff --binary
git diff --binary 70ccde4
# initial.json의 597개 파일 SHA-256과 현재 파일을 다시 대조
```

실제 출력(위 명령 결과를 해시·목록으로 집계):

```json
{
  "head_unchanged": true,
  "hashed_files": 597,
  "changed_files": [],
  "extra_files_except_report": [],
  "git_status": "",
  "git_diff_bytes": 0,
  "git_diff_sha256": "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855",
  "git_diff_identical": true,
  "base_diff_sha256": "41aa631ae40503bc9b65f581fcd8be9c06c7ae5ca6bd8797359238be1735cb93",
  "base_diff_identical": true,
  "old_os_temp_manifest_residue": 0
}
```

## 주요 상세 근거

### 원주소 16개

| 경로 | HTTP | 제목 | 설명 | canonical |
|---|---|---|---|---|
| / | 200 | 동일 | 동일 | 동일 |
| /seo/ | 200 | 동일 | 동일 | 동일 |
| /seo-backlinks/ | 200 | 동일 | 동일 | 동일 |
| /wordpress-agency/ | 200 | 동일 | 동일 | 동일 |
| /naver-place-marketing/ | 200 | 동일 | 동일 | 동일 |
| /naver-shopping-marketing/ | 200 | 허용 변경 | 허용 변경 | 동일 |
| /kakao-gift/ | 200 | 동일 | 동일 | 동일 |
| /coupang/ | 200 | 동일 | 동일 | 동일 |
| /about-us/ | 200 | 동일 | 동일 | 동일 |
| /contact-us/ | 200 | 동일 | 동일 | 동일 |
| /blog/ | 200 | 동일 | 동일 | 동일 |
| /blog/seo/ | 200 | 동일 | 동일 | 동일 |
| /blog/link-building/ | 200 | 동일 | 동일 | 동일 |
| /seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/ | 200 | 동일 | 동일 | 동일 |
| /seo/11가지-최고의-seo-실수와-이를-피하는-방법/ | 200 | 동일 | 동일 | 동일 |
| /seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/ | 200 | 동일 | 동일 | 동일 |

허용 변경 실제 값:

```json
{
  "/naver-shopping-marketing/": {
    "title": {
      "before": "네이버쇼핑 상위노출 마케팅 전문가의 노하우로 매출 UP",
      "after": "네이버쇼핑·스마트스토어 상위노출 마케팅 전문가의 노하우로 매출 UP"
    },
    "description": {
      "before": "네이버쇼핑 상위노출 마케팅을 위한 SEO는 제이커브에게 맡기세요! 10년 이상 풍부한 노하우로 상품 노출 극대화, 클릭률 향상, 매출 증대를 실현시켜 드립니다.",
      "after": "네이버쇼핑·스마트스토어 상위노출 마케팅을 위한 SEO는 제이커브에게 맡기세요! 10년 이상 풍부한 노하우로 상품 노출 극대화, 클릭률 향상, 매출 증대를 실현시켜 드립니다."
    }
  }
}
```

### 공격 리다이렉트

| 요청 | HTTP | 실제 Location |
|---|---|---|
| `/manager/data//evil.com/x.png` | 301 | `/v1/manager/data//evil.com/x.png` |
| `/manager/data/%2F%2Fevil.com` | 301 | `/v1/manager/data/%2F%2Fevil.com` |
| `/manager/data/..%2F..%2Fadmin` | 301 | `/v1/manager/data/..%2F..%2Fadmin` |
| `/manager/data/editor/a%0d%0aX-Injected:%20yes.png` | 301 | `/v1/manager/data/editor/a%0d%0aX-Injected:%20yes.png` |
| `/manager/data/editor/a.png?next=//evil.com` | 301 | `/v1/manager/data/editor/a.png?next=//evil.com` |

### 새 글·설명·중복 처리

```json
{
  "seeding": {
    "verdict": "통과",
    "articles": 5,
    "count": 5,
    "second_run_exact": true,
    "mismatches": [],
    "missing_category": {
      "exception": "RuntimeException",
      "message": "Missing insight category: seo",
      "counts_unchanged": true
    }
  },
  "descriptions": {
    "verdict": "통과",
    "count": 49,
    "mismatches": [],
    "unexpected_changed_fields": {},
    "duplicate_changed_fields": [
      "meta_description",
      "published_at"
    ]
  },
  "duplicate": {
    "verdict": "통과",
    "published_at": null,
    "sitemap_contains": false,
    "rss_contains": false,
    "inbound": [
      {
        "from": "v1/manager/bbs/board.php?bo_table=column&wr_id=15",
        "status": 301,
        "location": "https://j-curve.co.kr/insights/2019%EB%85%84-%EA%B7%B8%EB%A1%9C%EC%8A%A4%ED%95%B4%EC%BB%A4%EC%97%90%EA%B2%8C-%ED%95%84%EC%9A%94%ED%95%9C-%EC%8A%A4%ED%82%AC3",
        "next_status": 200
      },
      {
        "from": "v1/manager/column/2019년-그로스해커에게-필요한-스킬3-1",
        "status": 301,
        "location": "https://j-curve.co.kr/insights/2019%EB%85%84-%EA%B7%B8%EB%A1%9C%EC%8A%A4%ED%95%B4%EC%BB%A4%EC%97%90%EA%B2%8C-%ED%95%84%EC%9A%94%ED%95%9C-%EC%8A%A4%ED%82%AC3",
        "next_status": 200
      },
      {
        "from": "v1/manager/bbs/board.php?bo_table=column&wr_id=16",
        "status": 301,
        "location": "https://j-curve.co.kr/insights/2019%EB%85%84-%EA%B7%B8%EB%A1%9C%EC%8A%A4%ED%95%B4%EC%BB%A4%EC%97%90%EA%B2%8C-%ED%95%84%EC%9A%94%ED%95%9C-%EC%8A%A4%ED%82%AC3",
        "next_status": 200
      },
      {
        "from": "v1/manager/column/2019년-그로스해커에게-필요한-스킬3",
        "status": 301,
        "location": "https://j-curve.co.kr/insights/2019%EB%85%84-%EA%B7%B8%EB%A1%9C%EC%8A%A4%ED%95%B4%EC%BB%A4%EC%97%90%EA%B2%8C-%ED%95%84%EC%9A%94%ED%95%9C-%EC%8A%A4%ED%82%AC3",
        "next_status": 200
      },
      {
        "from": "insights/2019년-그로스해커에게-필요한-스킬3-1",
        "status": 301,
        "location": "https://j-curve.co.kr/insights/2019%EB%85%84-%EA%B7%B8%EB%A1%9C%EC%8A%A4%ED%95%B4%EC%BB%A4%EC%97%90%EA%B2%8C-%ED%95%84%EC%9A%94%ED%95%9C-%EC%8A%A4%ED%82%AC3",
        "next_status": 200
      }
    ]
  }
}
```

설명 49건 중 공개 48건은 실제 meta description과도 완전히 일치했다. 나머지 중복 1건은 의도된 비공개·301이므로 HTML 메타 대신 DB 값 일치와 301 목적지 공개를 별도로 확인했다.

### FAQ·위치 경로

```json
{
  "faq": {
    "verdict": "통과",
    "checked": 107,
    "faq_pages": 44,
    "bad": []
  },
  "baseline_faq": {
    "verdict": "통과",
    "comparison": {
      "/solutions/rankfree": {
        "count": 9,
        "identical": true
      },
      "/solutions/leadbay": {
        "count": 7,
        "identical": true
      },
      "/solutions/boostingshop": {
        "count": 7,
        "identical": true
      },
      "/solutions/call2sale": {
        "count": 7,
        "identical": true
      },
      "/solutions": {
        "count": 6,
        "identical": true
      }
    },
    "normalization": "HTML 렌더 후 표시 공백만 한 칸으로 정규화; 문구와 펼친 링크 목적지 동일"
  },
  "breadcrumb_service": {
    "verdict": "통과",
    "breadcrumb_pages": 95,
    "service_pages": 34,
    "unique_targets": 102,
    "bad": [],
    "parents": {
      "https://j-curve.co.kr/services": {
        "status": 200,
        "location": null
      },
      "https://j-curve.co.kr/solutions": {
        "status": 200,
        "location": null
      },
      "https://j-curve.co.kr/self-marketing": {
        "status": 200,
        "location": null
      },
      "https://j-curve.co.kr/seo/": {
        "status": 200,
        "location": null
      }
    }
  }
}
```

### 원고 사본 SHA-256

| 원본 | 배포 사본 | 공통 SHA-256 | 바이트 동일 |
|---|---|---|---|
| docs/content/articles/kw01/01-place-rank.html | database/content/kw01/01-place-rank.html | `e17578b0b623a2339936768e254c9600f00da2f085e217c68d9f4b3ce340b4da` | true |
| docs/content/articles/kw01/02-place-reward.html | database/content/kw01/02-place-reward.html | `1ad9347a5e22f00f753987601082ccc47dfb1e2deaf15299875a99ed3d43c245` | true |
| docs/content/articles/kw01/03-smartstore-rank.html | database/content/kw01/03-smartstore-rank.html | `9dbe0b5e075a716b4c7e77bf1ca4eee993233b95b657a71a3053d77a0a198c85` | true |
| docs/content/articles/kw01/04-shopping-inflow.html | database/content/kw01/04-shopping-inflow.html | `6b3ec6c8c8ab29c3c2411c7cef8b4472fa4e0a8fe96a92a181c633476ab24da6` | true |
| docs/content/articles/kw01/05-offerwall.html | database/content/kw01/05-offerwall.html | `0783b1137cbec34207a41dcd8e4dccac26b91757d8d18a5893442e7530e92454` | true |
| docs/content/articles/kw01/manifest.json | database/content/kw01/manifest.json | `b1a314911a16fe1c008283d60799e3aa9c258fe726207f376b79d927423368b6` | true |
| docs/content/insight-meta-2026-11-04.json | database/content/kw01/insight-meta.json | `dff729bf7a98a8870e8ee9a62a794aeac29db4c58160490980039ded98a7cd7c` | true |

### 문구·숫자 검토

숫자가 들어간 변경분은 llms의 다음 3줄뿐이며 기존 화면의 숫자·라벨 삭제/교체는 없었다:

```text
+- 회사 전체 누적 집행 광고비 373억+ (2026년 기준)
+- 회사 전체 누적 수집 DB 128만+ (2026년 기준)
+- 회사 전체 누적 진행 캠페인 15,700+ (2026년 기준)
```

문구 검토에서는 “순위는 보장되지 않습니다”, “리뷰 작성 미션은 제공하지 않습니다”, “구매나 구매평도 만들어 주나요? / 아닙니다” 및 보장 업체를 경계하는 문장을 긍정 약속으로 오판하지 않았다. 새 글 5편의 FAQ·표, 설명 JSON, 바뀐 Blade·subpages 문구를 원문으로 확인했다.

## 실행 중 확인·보정한 사항 및 검증 한계

- 첫 전체 실행은 검증자가 APP_URL을 공개 도메인으로 지정해 UrlPreservationTest가 기대하는 localhost와 충돌했다(278/279, exit 1). 아래 실제 출력에 남겼다. APP_URL을 localhost로 되돌린 뒤 소스 변경 없이 279/279가 되었으며, 최종 복구 후에도 통과했다.
- 초기 전체 실행에서 검증자가 TMPDIR 지정을 누락했다. 기존 SeoUrlAuditTest의 tempnam fixture가 OS 임시 폴더를 사용하고 tearDown에서 삭제됐다. 해당 접두사의 잔류 파일 0개를 확인했다. 이 사용자 지정 경로 이탈을 기록하며, 최종 전체 실행은 TMPDIR/TMP/TEMP를 지정 폴더로 고정해 재수행했다. 수동 저장한 증거·스크립트·백업은 전부 지정 폴더 아래다.
- 독립 probe 초기의 raw 한글 URL 파싱 문제는 probe에서 URL을 인코딩 전에 분리하도록 보정하고 다시 수집했다. 초기 잠정 400 응답을 제품 결함으로 사용하지 않았다. 최종 107개 응답은 모두 200이다.
- HTTP/DOM 및 메타·구조화 데이터·DB 바이트 검증이다. 운영 DB의 실제 적용 상태나 운영 웹서버의 MIME 설정, 브라우저의 화면 연출을 확인한 결과가 아니다. robots/llms MIME은 PHP 로컬 서버로 검증했다. 그 로컬 서버는 종료했다.

첫 실행의 실제 테스트 출력:

```json
{"tool":"phpunit","result":"failed","tests":279,"passed":278,"assertions":23807,"duration_ms":17461,"failed":1,"failures":[{"test":"Tests\\Feature\\UrlPreservationTest::test_generated_urls_cover_parameters_queries_fragments_and_relative_routes","file":"/Users/anarchy/Claude_Projects/jcurve/tests/Feature/UrlPreservationTest.php","line":96,"message":"Failed asserting that two strings are identical.\n--- Expected\n+++ Actual\n@@ @@\n-'http://localhost/about-us/'\n+'https://j-curve.co.kr/about-us/'"}]}
```

## 보고서 저장 후 최종 상태

실제 명령 `git status --short --untracked-files=all` 출력:

```text
?? tests/SEO-KW-01-VERIFY-RESULT.md
```

실제 명령 `git diff --stat` 출력: 0바이트(변경 없음).

597개 시작 파일 해시 및 새 파일·diff를 재집계한 실제 출력:

```json
{
  "git_status": "?? tests/SEO-KW-01-VERIFY-RESULT.md\n",
  "git_diff_stat": "",
  "original_files_checked": 597,
  "original_files_changed": [],
  "new_files": [
    "tests/SEO-KW-01-VERIFY-RESULT.md"
  ],
  "diff_sha256": "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855",
  "base_diff_unchanged": true,
  "staged_diff_unchanged": true
}
```
