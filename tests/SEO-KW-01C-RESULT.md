# SEO-KW-01C 구현·독립 검증 결과

- 실행 게이트 전부 충족: 전체 **279개 / 23,813 단언 통과**, 실패·오류·건너뜀 0. Pint 통과.
- 신규 화면 테스트: **23개 메서드 / 데이터셋 포함 65개**. 보정한 KeywordInsightTest 11개도 통과.
- 무력화 **7/7건**에서 지정한 테스트가 실제로 빨개졌고, 복구 후 대상 19개가 다시 통과했다.
- 실험 전후 뷰 **99개 SHA-256·전체 git diff·diff stat 동일**. 영구 화면 변경 없음.
- 원고 5편·설명문 **49개** 사본은 원본과 바이트 동일. manifest는 수정 없이 동일 확인.
- 담당: Codex 구현 세션 / 별도 Codex verifier 세션의 독립 검토·실행. Claude 최종 검수는 별도다.

## 1. 기준과 저장 범위

지시서: `docs/SPEC-CODEX-SEO-KW-01C.md`.

시작 HEAD는 `7a543e1161e732e101b1b25c58b3685e12e8219b`였다. 작업 중 HEAD가 `064d23434a4e2f32bcd7c29bb4fe47c935feba83`로 바뀐 것을 관측했고, 실험 전후·전체 검증은 후자 기준이다. 시작 때 보였던 문서 2개의 미커밋 변경도 이후 사라졌다. 두 Codex 세션은 git 읽기 명령만 사용했다.

| 바꾼 파일 | 내용 |
|---|---|
| `tests/Feature/KeywordInsightTest.php` | 설명문 개수·시더 출력 기대값을 JSON에서 계산. JSON의 `path`를 DB 단언에 넘기지 않고 49개 전부 `slug`·`meta_description` 검사. 중복 글은 `published_at`·`meta_description`만 의도된 변경으로 허용하고 나머지 원본 필드 전체 비교 |
| `tests/Feature/SeoKeywordViewsTest.php` | 지시서 C1~C11 화면 회귀 테스트 추가 |
| `tests/Support/seo_kw_01c_mutations.py` | 7개 임시 무력화·finally 복구·바이트 및 git diff 비교·전후 테스트 실행 도구 |
| `database/content/kw01/01-place-rank.html` | 승인 원고 바이트 사본 동기화 |
| `database/content/kw01/02-place-reward.html` | 승인 원고 바이트 사본 동기화 |
| `database/content/kw01/03-smartstore-rank.html` | 승인 원고 바이트 사본 동기화 |
| `database/content/kw01/04-shopping-inflow.html` | 승인 원고 바이트 사본 동기화 |
| `database/content/kw01/05-offerwall.html` | 승인 원고 바이트 사본 동기화 |
| `database/content/kw01/insight-meta.json` | 승인 설명문 JSON 바이트 사본 동기화 |
| `tests/SEO-KW-01C-EVIDENCE/**` | 실제 stdout·stderr·종료 코드·JUnit·복구 SHA·복사본 비교·독립 검토 증거. 중간 실패 기록도 보존 |
| `tests/SEO-KW-01C-RESULT.md` | 이 보고서 |

B3의 manifest 설명문 기대값은 그대로 유지했다. 기존 보존 테스트와 다른 파일의 기대값을 낮추거나 테스트를 건너뛰지 않았다. `manifest.json`에는 저장하지 않았다. 뷰는 승인된 임시 실험 뒤 원상복구했고, 그 외 소스·문서·대시보드·환경 파일에는 저장하지 않았다.

## 2. 신규 테스트 범위

| 지시서 | 실제 검사 |
|---|---|
| C1 | 지정 공개 페이지 4곳과 인사이트에서 모든 JSON-LD 블록 파싱, Organization·WebSite·WebPage 각각 1개, 회사 id·canonical 일치, 공개 확인 메타 개수·값. 제목·설명에 `&`, 따옴표, `</script>`를 넣어 파싱·태그 탈출·HTML 엔티티 검사 |
| C2 | 플레이스 서브페이지 Service·BreadcrumbList 각각 1개, provider id·서비스 url 검사 |
| C3 | BlogPosting headline·발행/수정일·author/publisher id, article 메타. 원주소 글 3편은 기존 보존 테스트의 설명문 기대값 유지. 한글 159/160/161자와 ASCII 161자 경계에서 실제 meta·WebPage·BlogPosting 설명문 검사 |
| C4 | 로그인·회원가입·비밀번호 찾기의 noindex와 정확한 한글 제목, Laravel 제목 배제 |
| C5 | 빈 카테고리·미발행/미래 글만 있는 카테고리 noindex. 공개 글이 있는 카테고리와 원주소 두 빈 카테고리 index |
| C6 | 쇼핑·플레이스·허브·리워드 광고·랭크프리의 지정 제목, H1, 본문 링크, 쇼핑 주문 type, 가격 비노출, offerwall 섹션·FAQ |
| C7 | llms의 HTML 엔티티 부재와 Markdown 링크·HTTP URL의 공개 절대주소 검사 |
| C8 | 지정 8페이지 FAQPage 정확히 1개, 질문 수 5/6/6/6/9/7/7/7 고정, 본문 summary와 순서까지 동일, 답에서 HTML 제거. 랭크프리 첫 답의 서비스 링크 2개 보존. 인사이트 FAQ 질문으로 script 종료 문자열 공격 재현 |
| C9 | 지정 20페이지 BreadcrumbList 1개, 첫 홈·마지막 canonical·모든 item·순서, WebPage breadcrumb id 연결. 서비스 대상 15곳은 Service 1개, 비대상 5곳과 홈은 0개. AEO 4단계 경로 검사 |
| C10 | 시더 신규 5편 각각 FAQPage 1개·질문 3개·본문 FAQ h3와 일치. FAQ h2 없는 실제 옛 글은 FAQPage 0개 |
| C11 | 홈·블로그·플레이스 푸터의 리워드 링크 2개, 데스크톱 주 메뉴의 셀프마케팅 링크 정확히 1개 |

FAQ 공격 문자열은 본문에 `&lt;/script&gt;` 형태로 넣었다. `schema-faq`의 `strip_tags`를 통과한 글자가 `html_entity_decode` 뒤 실제 `</script>`가 되므로, 해당 partial의 JSON_HEX_TAG 보호를 실제로 검사한다.

## 3. 실행 명령과 실제 출력

모든 PHP 테스트는 SQLite `:memory:`를 사용했다. 테스트 내부의 시딩만 실행했으며 운영 DB 접속이나 운영 시더 실행은 하지 않았다. 컴파일 뷰 경로는 전부 사용자 지정 경로였다. PHPUnit 결과 캐시는 비활성화했다.

### 전체 테스트 — 종료 코드 0

```sh
env APP_ENV=testing DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= CACHE_STORE=array SESSION_DRIVER=array LOG_CHANNEL=stderr VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01c/views php artisan test --do-not-cache-result --log-junit=tests/SEO-KW-01C-EVIDENCE/full-suite.xml
```

실제 출력(행 끝 공백만 생략):

```text
[2026-11-04 08:01:52] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"}
[2026-11-04 08:01:52] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"}
{"tool":"phpunit","result":"passed","tests":279,"passed":279,"assertions":23813,"duration_ms":8169}
```

위 경고는 기존 연결 실패 경로 테스트에서 출력됐다. JUnit 직접 집계도 279개, 실패 0·오류 0·건너뜀 0이다. 원본 출력·명령·환경·종료 코드는 [full-suite.log](SEO-KW-01C-EVIDENCE/full-suite.log), [full-suite-result.json](SEO-KW-01C-EVIDENCE/full-suite-result.json), [full-suite.xml](SEO-KW-01C-EVIDENCE/full-suite.xml)에 보존했다. 전체 스위트는 최종 복구 후 1회 실행했다.

### Pint — 종료 코드 0

```sh
./vendor/bin/pint --test tests/Feature/SeoKeywordViewsTest.php tests/Feature/KeywordInsightTest.php
```

```json
{"tool":"pint","result":"passed"}
```

원본: [pint.log](SEO-KW-01C-EVIDENCE/pint.log), [pint-result.json](SEO-KW-01C-EVIDENCE/pint-result.json).

### 무력화 도구 — 최종 종료 코드 0

```sh
python3 tests/Support/seo_kw_01c_mutations.py
```

도구가 위와 같은 테스트 환경을 강제한다. 실험 전후 대상 19개 실행의 실제 출력:

```text
before: {"tool":"phpunit","result":"passed","tests":19,"passed":19,"assertions":254,"duration_ms":366}
after:  {"tool":"phpunit","result":"passed","tests":19,"passed":19,"assertions":254,"duration_ms":413}
```

`before`·`after`는 출력 구분용 라벨이다. 원본은 [mutation-baseline.log](SEO-KW-01C-EVIDENCE/mutation-baseline.log), [mutation-restored.log](SEO-KW-01C-EVIDENCE/mutation-restored.log), 전체 실행 stdout은 [mutations.stdout.jsonl](SEO-KW-01C-EVIDENCE/mutations.stdout.jsonl)에 있다.

## 4. 무력화 결과표

각 행의 복구 확인은 해당 파일 바이트 동일 + 뷰 99개 SHA 동일 + 전체 git diff 동일 + diff stat 동일을 모두 뜻한다. 각 실험은 변경 1곳만 적용하고 `finally`에서 복구했다. 종료 코드 2는 JSON 파싱 예외, 1은 단언 실패다.

| 임시로 되돌린 코드 | 실제 빨간 테스트 | 종료 코드 | 복구 |
|---|---|---|---|
| head의 `JSON_HEX_TAG` 제거 | `test_head_jsonld_escapes_script_endings_and_decodes_html_entities` — JSON 파싱 오류 | 2 | 전부 동일 |
| schema-faq의 `JSON_HEX_TAG` 제거 | `test_faq_jsonld_escapes_script_endings_in_an_insight_question` — JSON 파싱 오류 | 2 | 전부 동일 |
| guest robots noindex 메타 제거 | `test_guest_pages_are_noindex_and_have_their_korean_titles` — 로그인·회원가입·비밀번호 찾기 3개 | 1 | 전부 동일 |
| category noindex 조건 블록 제거 | `test_only_empty_nonpreserved_categories_are_noindex` — empty, only unpublished and future articles 2개 | 1 | 전부 동일 |
| rankfree의 `sd_page` section 제거 | `test_page_breadcrumb_and_service_contract` — `/solutions/rankfree` | 1 | 전부 동일 |
| insights/show의 meta 설명문을 `Str::limit(..., 155)`로 복귀 | B3 `test_new_articles_render_their_own_canonical_metadata_and_appear_in_the_insights_sitemap` + C3 `test_insight_description_uses_160_characters_including_the_ellipsis`의 한글 159/160/161·ASCII 161자 4개, 합계 5개 | 1 | 전부 동일 |
| footer의 `self.children` foreach 제거 | `test_footer_has_both_reward_links_and_desktop_header_has_one_self_link` — 홈·블로그·플레이스 3개 | 1 | 전부 동일 |

실제 실패 메시지·JUnit은 증거 디렉터리의 `01-head-json-hex-tag`부터 `07-footer-self-children`까지 각각 `.log`·`.xml` 파일에 있다. 실험 코드·명령·실패 테스트 이름·복구 bool 전체는 [mutations.json](SEO-KW-01C-EVIDENCE/mutations.json)에 있다.

### 뷰 원상복구의 실제 git 출력

실험 전과 각 실험 복구 후, 최종 전체 테스트 후에 다음 읽기 명령을 실행했다.

```sh
git diff --stat -- resources/views
git diff -- resources/views
```

두 명령 모두 종료 코드 0, stdout **0바이트**였다. 아래 `<empty>`는 빈 출력을 표시한다.

```text
before diff --stat: <empty>
after  diff --stat: <empty>
before full diff:  <empty>
after  full diff:  <empty>
all_99_view_sha_equal: true
full_view_diff_equal: true
```

실험 직전 99개 파일 해시는 [views-before.json](SEO-KW-01C-EVIDENCE/views-before.json), 최종 읽기 명령·실제 stdout과 독립 집계는 [independent-summary.json](SEO-KW-01C-EVIDENCE/independent-summary.json)에 있다. 구현 세션도 최종 `git diff --stat -- resources/views`의 빈 출력을 재확인했다.

### 실험 도구 보정 이력

첫 실행은 JSON 파싱 예외가 정상적으로 발생했지만 도구가 종료 코드 1만 빨강으로 인정해 중단됐다. 뷰는 복구됐고, 종료 코드 2도 기대한 테스트 이름이 검출될 때만 빨강으로 인정하도록 보정했다. `attempt-1-*`에 원본 증거를 보존했다.

두 번째 실행은 7건 검출·바이트 복구는 성공했으나 복구 후 19개 중 10개가 실패했다. 지정 tmp 경로의 컴파일 파일에 실험 코드가 남아 있음을 확인했고, 해당 경로의 PHP 캐시 60개만 비운 뒤 같은 19개가 254 단언으로 통과했다. [compiled-cache-recovery.json](SEO-KW-01C-EVIDENCE/compiled-cache-recovery.json)과 `attempt-2-*`에 증거가 있다. 도구는 이제 각 실행 전에 `/private/tmp/jcurve-seo-kw-01c/views/*.php`만 정리한다. 세 번째 최종 실행은 7건 검출·복구·전후 19개 통과로 정상 종료했다. 테스트 기대값이나 화면 보호 코드는 이 문제 때문에 변경하지 않았다.

## 5. 원고 사본 바이트 동일 증거

`docs/content/articles/kw01/0*.html` 5개와 `docs/content/insight-meta-2026-11-04.json`을 대응 사본에 동기화했다. `manifest.json`은 읽기 비교만 했다. 직접 바이트 비교와 SHA-256 결과:

| 대상 | 비교 출력 | 원본·사본 공통 SHA-256 |
|---|---|---|
| `01-place-rank.html` | IDENTICAL | `e17578b0b623a2339936768e254c9600f00da2f085e217c68d9f4b3ce340b4da` |
| `02-place-reward.html` | IDENTICAL | `1ad9347a5e22f00f753987601082ccc47dfb1e2deaf15299875a99ed3d43c245` |
| `03-smartstore-rank.html` | IDENTICAL | `9dbe0b5e075a716b4c7e77bf1ca4eee993233b95b657a71a3053d77a0a198c85` |
| `04-shopping-inflow.html` | IDENTICAL | `6b3ec6c8c8ab29c3c2411c7cef8b4472fa4e0a8fe96a92a181c633476ab24da6` |
| `05-offerwall.html` | IDENTICAL | `0783b1137cbec34207a41dcd8e4dccac26b91757d8d18a5893442e7530e92454` |
| `insight-meta.json` | IDENTICAL, JSON 49개 | `dff729bf7a98a8870e8ee9a62a794aeac29db4c58160490980039ded98a7cd7c` |
| `manifest.json` (변경 없음) | IDENTICAL | `b1a314911a16fe1c008283d60799e3aa9c258fe726207f376b79d927423368b6` |

독립 검증의 원본·사본 경로·바이트 동일 여부·각각의 SHA는 [byte-copies.json](SEO-KW-01C-EVIDENCE/byte-copies.json)에 보존했다. 구현 세션도 7개 모두 동일하고 JSON 항목 수 49개임을 재확인했다.

## 6. 화면 버그·미검증

최종 화면 코드에서 발견한 버그는 없다. FAQ 실제 개수는 지시서와 모두 일치했고, 기존 원주소 글 3편의 설명문 보존·신규 5편의 manifest 설명문도 그대로 통과했다. 실험 과정에서 발견한 것은 위 두 가지 검증 도구·컴파일 캐시 문제였으며 모두 보정 후 재실행했다.

독립 검토에서도 요구 누락·기대값 완화·skip·미해결 finding은 발견되지 않았다. 상세 검토: [independent-review.json](SEO-KW-01C-EVIDENCE/independent-review.json).

검증은 로컬 Laravel HTTP 렌더링과 SQLite 메모리 DB 범위다. 브라우저 시각 검수, 운영 서버·검색엔진 수집 결과·운영 DB 적용은 수행하지 않았다. 배포·발행·커밋·푸시·stash·reset·checkout·restore는 실행하지 않았다. Claude의 최종 검수는 이 결과와 증거를 대상으로 별도 진행한다.
