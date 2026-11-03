# SEO-META-02 독립 검증 결과

검증: Codex 독립 검증 세션, 2026-11-03 13:25~13:40 KST. 구현 세션의 판정을 재사용하지 않고 직접 실행했어.

**판정: 17개 시나리오 PASS, V14 FAIL. SEO 기능 회귀는 발견하지 못했지만, 지시서의 전체 Pint 게이트가 충족되지 않았어.** 실패 파일 3개는 기준 커밋에도 동일하게 존재하는 스타일 위반이며 이번 변경으로 생긴 문제가 아니야. 변경 PHP 5개에 한정한 Pint는 통과했어.

## 검증 범위와 격리

- 기준: `38c13270627c0d62a40ac6c1e176fbee97f698f2`.
- 대상 HEAD: `0633f883f33f2d1169a8af101e03850ec5e9ccbd`. 시작 작업 트리는 깨끗했어.
- 체크포인트 `8ee6e94`, `bfa7bd8`, `7a76729`, `0633f88`을 포함한 기준 대비 **46개 파일, +4,276/-20행 전체**를 대상으로 했어. 미커밋 diff만 검사한 게 아니야.
- 정본: `SPEC-CODEX-SEO-META-02.md`, `SEO-META-02-TITLES.json`, `SPEC-CODEX-SEO-META-02B.md`, `VERIFY-CODEX-SEO-META-02.md`, URL 회귀 기준 `SPEC-CODEX-URL-PRESERVE-01.md`.
- 격리 경로: `/private/tmp/jcurve-seo-meta-02-verify-45WXtF`. 현재 소스 복사본과 `git archive 38c1327` 기준 스냅샷을 만들었어. `.git` 쓰기 제한 때문에 `git worktree add` 대신 동일 커밋의 archive를 사용했으며, 원본의 브랜치·인덱스·작업 트리를 바꾸지 않았어.
- 각 스냅샷의 임시 SQLite에 `migrate --force`와 `DatabaseSeeder`를 실행했어. 실제 DatabaseSeeder의 Board·InsightCategory·LegacyRedirect·LegacyContent만 실행했고 `WorkSeeder`는 실행하지 않았어. `works=0`, `insights=53`.
- 실제 HTTP 서버는 검증본의 **127.0.0.1:8013만** 사용했고 종료했어. `SEO_PUBLIC_URL=https://j-curve.co.kr`, 요청 Host는 `j-curve.co.kr` / `dev.j-curve.co.kr`. 기본 APP_URL은 기존 테스트 계약에 맞춰 `http://localhost`로 설정했어.
- PHP 8.5.8, Node v20.20.2, Vite v8.2.0, SQLite. 원본 `.env`·기존 DB를 읽거나 변경하지 않았어.
- 운영에는 인증 없는 **GET 17회**만 했어: 정본 16개 페이지와 `/sitemap_index.xml`. 모두 200. 운영 시더·쓰기·배포는 실행하지 않았어.
- 기준 스냅샷의 H1·버튼·제목 비교에는 검증본의 Vite 빌드 manifest를 제공했어. 기준 Blade·설정·DB는 기준 커밋 그대로이고, 시각적 동일성 판정에는 사용하지 않았어.

## 시나리오별 판정

| 시나리오 | 판정 | 직접 확인한 실제 결과 |
|---|---|---|
| V1 제목·설명 16개 | PASS | 16/16 HTTP 200. title 정본 일치, description 각각 1개·값 일치, og:title=title. 기사 설명은 지시된 155자 제한 규칙 적용 |
| V2 운영 제목 대조 | PASS | 운영 GET 16/16 200, HTML 엔티티를 푼 운영 title과 로컬 title 글자 단위 일치 16/16 |
| V3 포지셔닝 | PASS | 16페이지 title·description·og:title·og:description의 금지 문구 검출 0 |
| V4 성과 수치 | PASS | 홈 본문 `373억+`, `15,700+`, `128만+` 모두 존재. 해당 수치가 사라진 제품 diff는 승인된 홈 meta description 교체 1줄뿐; 본문·라벨·고지 변경 없음 |
| V5 블로그 본문 | PASS | 기사 3편의 기사 DOM·문장·대표/본문 이미지 속성·기사 링크 속성 동일. 페이지 H1 각 1개=순수 제목, 저장 본문 H1=0. 제거 조각은 아래에 분류 |
| V6 다른 글 | PASS | 나머지 50행의 title·meta_title·meta_description·excerpt·content 해시 전부 동일. 숨김 글 포함. 아나키 도입 문장 제거 2편 표시 결과 동일, 숨김 글 상세 302 |
| V7 갱신·멱등 | PASS | 기준 DB에 새 시더를 실행해 3편 갱신. 재실행 후 전체 21개 테이블의 모든 행·필드·타임스탬프 동일. 시간을 두고 추가 실행해도 동일 |
| V8 홈·목록 카드 | PASS | 홈·블로그·SEO 카테고리에 3편 링크와 정리된 요약 앞 50자 각각 확인. 잔재 0. link-building 목록은 해당 3편이 배정되지 않은 기존 상태, 잔재 0 |
| V9 사이트맵·피드 | PASS | 운영 index의 하위 5개+상위/추가 3개 사이트맵, feed 2형태: GET/HEAD 20/20 조합이 301→200 1홉. 자체 sitemap/rss 200, 임의 sitemap 404 |
| V10 robots | PASS | robots.txt HTTP 200·정확한 3줄. 공개 16/16 지정 robots, dev 16/16 noindex/nofollow. 410 페이지 noindex |
| V11 서브페이지 부작용 | PASS | 5페이지 title 키·렌더 H1·문의 message 배열이 기준과 동일. 기본 제목 분기 cpa/performance/boostingshop 각 1개 동일 |
| V12 카테고리 | PASS | SEO·link-building 지정 제목, news의 `뉴스·소식 인사이트 \| 제이커브인터렉티브` 유지. SEO page=2 HTTP 200·같은 제목 |
| V13 URL 회귀 전수 | PASS | 원주소 15/15 200·canonical/og:url 일치, N→P 15/15 301·쿼리 보존·도착 200, 지정 30/30 410, v1/gfa 301→200 |
| V14 품질 게이트 | **FAIL** | 전체 테스트 183 passed / 20,195 assertions, 빌드 exit 0. **전체 Pint exit 1(기존 3파일)**. 변경 PHP 5파일 Pint exit 0 |
| V15 원문 진위 | PASS | JSON 9개 **426개 블록 전부** 지금 운영 같은 경로의 main 텍스트에 존재. 문장/숫자 불일치 0. excluded는 허용한 3종뿐 |
| V16 누락 | PASS | JSON을 기대값으로 쓰지 않고 운영 main에서 독립 추출한 20자 이상 문장/텍스트 **261개** 대조. 허용한 기능 안내·날짜 외 누락 0 |
| V17 구조·안전 | PASS | 대상 9개 H1·service-detail 각 1개. 비대상 7개 구간 0·H1 각 1개. 경로/쿼리 공격 6개 정상. 실제 & 문장 및 별도 `<script>`/`<img>` 입력의 이스케이프 확인 |
| V18 숫자 보존 | PASS | 숫자가 있는 원문 블록 **81개**를 운영·로컬과 대조해 동일. 372%·450%·95.7%·월 50만원 포함 |

## FAIL 재현: V14 전체 Pint

두 스냅샷에서 같은 명령을 실행했어.

```sh
cd /private/tmp/jcurve-seo-meta-02-verify-45WXtF/current
./vendor/bin/pint --test
# exit 1

cd /private/tmp/jcurve-seo-meta-02-verify-45WXtF/base
./vendor/bin/pint --test
# exit 1 — 같은 3개 파일, 같은 fixer 목록
```

실제 출력의 파일별 내용:

```text
app/Services/Seo/OnPageAuditor.php:
new_with_parentheses, array_indentation, single_quote,
fully_qualified_strict_types, control_structure_braces,
control_structure_continuation_position, unary_operator_spaces,
no_multiple_statements_per_line, braces_position, statement_indentation,
not_operator_with_successor_space, single_line_empty_body,
blank_line_before_statement, ordered_imports

app/Services/Seo/UrlGuard.php:
no_unneeded_control_parentheses, control_structure_braces,
unary_operator_spaces, braces_position, statement_indentation,
not_operator_with_successor_space, blank_line_before_statement

resources/views/partials/jc/menu.php:
fully_qualified_strict_types, single_line_after_imports
```

원인 위치 예: `app/Services/Seo/OnPageAuditor.php:15`의 한 줄 생성자, `app/Services/Seo/UrlGuard.php:27` 이후의 제어문 스타일, `resources/views/partials/jc/menu.php:17`의 완전 수식 클래스 사용. Pint는 줄 번호를 출력하지 않으므로 각 파일의 fixer 목록이 직접적인 진단 근거야.

다음 명령은 exit 0이었어. 세 파일 모두 기준 대비 바이트가 같아.

```sh
git diff --exit-code 38c1327 -- \
  app/Services/Seo/OnPageAuditor.php \
  app/Services/Seo/UrlGuard.php \
  resources/views/partials/jc/menu.php
```

변경 PHP에 한정한 실제 검사:

```sh
./vendor/bin/pint --test config/subpages.php \
  database/seeders/LegacyContentSeeder.php routes/web.php \
  tests/Feature/SeoMetaRestorationTest.php tests/Feature/WpLegacyContentTest.php
```

```json
{"tool":"pint","result":"passed"}
```

구현 SPEC의 변경 PHP 게이트는 통과했어. 다만 이번 VERIFY의 V14는 `./vendor/bin/pint --test` 전체 실행을 요구하므로, 검증자가 임의로 통과 처리하지 않았어. 소스 수정 금지에 따라 위반 3개 파일도 수정하지 않았어.

## V1·V2 대조 범위

아래 각 경로에서 로컬 title=정본 title=직접 받은 운영 title이야. 각 description은 1개이고 정본 값과 일치했어.

| 경로 | 실제 title |
|---|---|
| `/` | 구글 네이버 SEO 업체 \| 검색엔진 최적화 전문 \| 제이커브 |
| `/about-us/` | About Us - SEO 전문 컨설팅 기업 \| 제이커브인터렉티브 |
| `/contact-us/` | 상담신청 - SEO 전문 컨설팅 기업 \| 제이커브인터렉티브 |
| `/blog/` | SEO \| 검색엔진최적화를 위한 완벽 가이드 |
| `/blog/seo/` | SEO 개념 - SEO 전문 컨설팅 기업 \| 제이커브인터렉티브 |
| `/blog/link-building/` | 링크빌딩 - SEO 전문 컨설팅 기업 \| 제이커브인터렉티브 |
| `/seo/` | 구글 네이버 SEO 업체 \| 검색엔진 최적화 전문 \| 제이커브 |
| `/seo-backlinks/` | 고품질 백링크 서비스 \| 구글・네이버 순위상승 전문 \| 제이커브 |
| `/wordpress-agency/` | 워드프레스 홈페이지 제작 업체 \| 제이커브 |
| `/naver-place-marketing/` | 네이버 플레이스 상위노출 마케팅, 전문가의 노출 최적화로 매출 상승 |
| `/naver-shopping-marketing/` | 네이버쇼핑 상위노출 마케팅 전문가의 노하우로 매출 UP |
| `/kakao-gift/` | 카카오선물하기 상위노출로 비즈니스 성장을 경험하세요 - SEO 전문 컨설팅 기업 \| 제이커브인터렉티브 |
| `/coupang/` | 쿠팡 상위노출로 매출 상승의 기회를 잡으세요 - SEO 전문 컨설팅 기업 \| 제이커브인터렉티브 |
| `/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/` | Chrome 및 Firefox에서 Nofollow 링크를 확인하는 방법 - SEO 전문 컨설팅 기업 \| 제이커브인터렉티브 |
| `/seo/11가지-최고의-seo-실수와-이를-피하는-방법/` | 11가지 최고의 SEO 실수와 이를 피하는 방법 - SEO 전문 컨설팅 기업 \| 제이커브인터렉티브 |
| `/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/` | 경쟁자를 압도하는 6가지 고급 링크 빌딩 구축 전략 - SEO 전문 컨설팅 기업 \| 제이커브인터렉티브 |

## V4~V8 본문·시더 근거

성과 수치가 들어간 삭제 줄은 홈의 옛 meta description 하나야. 기존의 `2026년 기준 누적 집행 광고비 373억원 · 진행 캠페인 15,700건`을 포함한 설명문이 운영 정본 설명문으로 교체됐어. 이는 SPEC §0이 요구하는 메타 복구이며 홈 본문의 세 수치·라벨·고지 문구는 그대로야.

기사의 기준 DB content와 새 DB content를 별도로 파싱해 `.fusion-content-tb` 전체 DOM을 직렬화 비교했어. 세 글 모두 동일했고, 본문과 대표 이미지의 모든 속성도 동일했어.

| 기사 | 기사+대표 이미지 전→후 | 기사 링크 전→후 | 저장 content 전체 이미지 전→후 |
|---|---|---|---|
| 고급 링크 구축 | 22→22 | 0→0 | 24→22 |
| Chrome/Firefox Nofollow | 2→2 | 4→4 | 4→2 |
| SEO 실수 11가지 | 10→10 | 0→0 | 12→10 |

전체 content 이미지가 각 2개 줄어든 것은 제거를 지시한 Related Posts 카드 이미지야. 기사 이미지 손실로 숨기지 않고 구분해서 기록했어.

문자 diff에서 세 글 모두 **앞쪽 1조각 삭제·뒤쪽 1조각 삭제, 기사 영역 수정 0**이었어.

- 앞: `SEO Blog` → `SEO에 대한 유용한 정보와 기사` → 해당 글 제목 반복 → `1월 14th, 2025 jcurve` 또는 `1월 18th, 2025 jcurve`. 전부 WP 배너·제목·작성일/작성자야.
- 고급 링크 구축 뒤: `Categories: SEO 개념, 링크빌딩` → 공유 안내 → Related Posts의 다른 두 글 제목 반복·날짜·0 Comments → `Search for:` → `Categorys` → 카테고리 링크. 전부 분류/공유/관련 글/검색 위젯이야.
- Nofollow 뒤: 위 구성에 `Tags: seo`가 추가된 위젯이야.
- SEO 실수 뒤: 위 구성에 `Tags: seo 노하우, seo 실수`가 추가된 위젯이야.
- 실제 기사 문장·본문 링크·이미지의 추가/삭제/변경은 0이야. 상세 문자 diff는 `evidence/audit-final.json`의 V5에 남겼어.

다른 50행의 필드별 SHA256은 `evidence/other-50-hashes.json`에 저장했어. 아나키 숨김 글도 이 50행에 포함되며, 별도로 두 글의 표시용 문장 제거 결과와 숨김 글 302를 확인했어.

기준 DB를 새 시더로 갱신한 뒤 실제 비교 결과:

```text
three_updated=3
all_tables_identical_after_second_run=true
all_tables_identical_after_delayed_run=true
tables=21, insights=53, insight_categories=13,
legacy_redirects=191, boards=4, users=1, works=0
나머지 15개 테이블은 0행 또는 migrations=17행이며 전부 동일
```

## V9·V10·V13 HTTP 근거

운영 `/sitemap_index.xml`에서 직접 얻은 하위 사이트맵은 다음 5개야.

```text
/post-sitemap.xml
/page-sitemap.xml
/product-sitemap.xml
/avada_portfolio-sitemap.xml
/category-sitemap.xml
```

이 5개와 `/sitemap_index.xml`, `/news-sitemap.xml`, `/wp-sitemap.xml`은 각각 GET·HEAD에서 `301 Location: /sitemap.xml` → 200, 추가 Location 없음. `/feed`, `/feed/`도 각각 GET·HEAD에서 `301 Location: /rss` → 200, 추가 Location 없음. 임의 `/something-arbitrary-sitemap.xml`은 404였어.

```text
GET /robots.txt → 200
User-agent: *
Disallow:
Sitemap: https://j-curve.co.kr/sitemap.xml

public robots: index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large
dev robots: noindex, nofollow
410 robots: noindex
```

V13은 URL-PRESERVE-01의 표 A 15개를 전부 검사했어. 각 P의 canonical과 og:url은 `https://j-curve.co.kr`+끝 슬래시를 포함한 P이고, 각 N에 `?utm_source=verify&page=2`를 붙여 301·P·두 쿼리 보존·도착 200을 확인했어. 한국어 Location은 HTTP 원시 UTF-8 바이트를 올바르게 복원해 비교했어.

410 전수 목록:

```text
19,21,29,38,47,52,56,58,59,60,61,62,63,64,65,
66,67,68,69,70,71,72,73,74,75,76,77,78,79,80
30/30 → HTTP 410
/v1/gfa.php → 301 /services/performance-marketing/naver-gfa → 200
```

## V15~V18 독립 원문·안전 근거

운영 HTML을 직접 받아 `<main id="main">`을 파싱하고 script/style/noscript를 제외했어. 텍스트 노드의 실제 문자를 합친 뒤 Unicode 공백을 하나로 정규화했어. 인라인 strong/span 경계에 없던 공백을 강제로 삽입해 불일치를 만드는 방식은 사용하지 않았어. 목록은 개별 문장과 자식 항목도 비교했어. V16의 기대 문장은 로컬 JSON이 아니라 운영 DOM에서 독립 추출했어.

| 운영 경로 | JSON 블록 | 독립 추출 20자 이상 텍스트 | 비허용 누락/불일치 |
|---|---:|---:|---:|
| `/contact-us/` | 2 | 3 | 0 |
| `/coupang/` | 85 | 62 | 0 |
| `/` | 17 | 10 | 0 |
| `/kakao-gift/` | 64 | 22 | 0 |
| `/naver-place-marketing/` | 65 | 54 | 0 |
| `/naver-shopping-marketing/` | 53 | 40 | 0 |
| `/seo-backlinks/` | 53 | 25 | 0 |
| `/seo/` | 44 | 24 | 0 |
| `/wordpress-agency/` | 43 | 21 | 0 |
| 합계 | **426** | **261** | **0** |

excluded의 실제 종류는 `clients`, `지금 구독하고, SEO 무료 팁을 받아보세요!`, `※ SEO 분석을 이용하시면…동의하신 것으로 간주됩니다.`뿐이야. 독립 비교에서 빠진 나머지는 ISO 형식 수정일 표시였고 지시서가 허용한 날짜 제외에 해당해. `/about-us/`의 테마 견본 영어와 블로그 목록 3개는 원문 보존 대상에서 제외했으며, V17에서 해당 보존 구간이 생기지 않았음을 검사했어.

실제 `&` 문장 2개는 `&amp;`로 렌더됐어. 원문 JSON에는 `<` 문장이 없어서, 소스를 바꾸지 않고 외부 검증 fixture를 실제 wp-legacy 부분 뷰에 입력해 추가 확인했어.

```json
{"script_nodes":0,"image_nodes":0,"p_text":"검증 <script>alert(1)</script> & \"큰따옴표\" '작은따옴표'","li_text":"항목 <img src=x onerror=alert(2)> & 끝","escaped_lt_amp":true}
```

경로 공격 실제 결과:

```text
/..%2f                                       → 404, section=0
/SEO-BACKLINKS/                              → 404, section=0
/%2e%2e%2fseo-backlinks/                      → 404, section=0
/services/seo/backlinks/../../coupang.json     → 404, section=0
/seo-backlinks/?wpLegacy=../../.env           → 200, 원래 백링크 section=1
/seo-backlinks/?wpLegacy=coupang              → 200, 원래 백링크 section=1
```

쿼리는 JSON 선택에 영향을 주지 않았어. 원래 뷰의 파일 이름 제한은 `^[a-z0-9-]+$`이며, 다른 파일 내용이 출력되지 않았어. 마지막의 일반 `../` URL은 HTTP 클라이언트의 표준 경로 정규화가 적용된 결과이며, 해당 문자열을 원시 요청선 그대로 보낸 검사는 하지 않았어. 퍼센트 인코딩한 경로 공격 결과는 위와 같아.

숫자 포함 81개 블록 중 다음 12개 예시를 포함해, 숫자뿐 아니라 해당 **문장 전체**가 운영·로컬에서 같은지 비교했어.

| 경로 | 확인한 원문 숫자/문장 구간 | 결과 |
|---|---|---|
| coupang | 평균 매출 증가율은 372%를 기록했습니다 | 동일 |
| coupang | 평균 ROI는 서비스 시작 6개월 내 450% | 동일 |
| coupang | 2024년 1분기…95.7%가 서비스 재계약 | 동일 |
| home | 월 50만원으로 시작하세요. | 동일 |
| naver-place | 방문자 수 300% 이상 증가…평균 3배 | 동일 |
| naver-place | 평균 67% 매출 상승 효과 | 동일 |
| naver-place | 2,500명 → 8,700명 (248% 증가), 매출 57% 상승 | 동일 |
| naver-shopping | 트래픽 300%·전환율 40%·소비자 83% | 동일 |
| seo-backlinks | 두 번째 페이지 노출 시 클릭률은 0.63% | 동일 |
| seo | 1위 28.5%·2위 15.7%·3위 11%·두 번째 페이지 0.63% | 동일 |
| wordpress-agency | 평균 자연 유입 300% 상승 | 동일 |
| wordpress-agency | 월 50만원으로 시작하세요. | 동일 |

수치의 사업상 진위를 새로 보증하는 검사가 아니라, 지시한 운영 문장 보존 여부를 검사한 결과야.

## §T 테스트 무력화 실험

원본 소스에는 실험을 적용하지 않았어. 격리본에서 한 실험씩 적용·실행하고 해당 파일을 바이트 단위 원복한 다음 다음 실험으로 넘어갔어.

아래 명령의 공통 형태는 `php artisan test --filter=<필터>`이며, 각 실제 출력은 `evidence/T*.log`에 있어.

| 실험 | 임시 변경 | 테스트 필터 | 실제 결과 | 판정 |
|---|---|---|---|---|
| T1 | seo_title 5개 삭제 | `test_public_metadata_matches_the_authoritative_json` | exit 1, **5 failed / 11 passed**, 93 assertions | PASS |
| T2 | 시더 3편 분기 전체 비활성 | `test_articles_keep_their_sentences_images_and_links_without_wordpress_widgets` | exit 1, **3 failed / 0 passed**, 3 assertions | PASS |
| T2b 추가 | 제목 정리는 유지하고 본문 정리 호출만 제거 | 같은 필터 | exit 1, **3 failed / 0 passed**, 12 assertions | PASS |
| T3 | 옛 사이트맵 8개 라우트 등록 제거 | `test_legacy_sitemaps_and_feeds_redirect_once_for_get_and_head` | exit 1, **8 failed / 2 passed**, 24 assertions | PASS |
| T4 | 공개 기본 robots를 index, follow로 축약 | `test_public_metadata_matches_the_authoritative_json` | exit 1, **16 failed / 0 passed**, 112 assertions | PASS |
| T5 | subpage의 wp-legacy include 제거 | `WpLegacyContentTest` | exit 1, **5 failed / 20 passed**, 212 assertions | PASS |
| T6 | home JSON의 월 50만원→월 51만원 | `test_original_block_text_matches_its_fixed_sha256` | exit 1, **1 failed / 8 passed**, 27 assertions | PASS |

실제 실패 메시지 예:

```text
T1: 기대 '고품질 백링크 서비스 | 구글・네이버 순위상승 전문 | 제이커브'
    실제 '백링크 패키지 — 검색을 위한 신뢰 신호 설계 | 제이커브인터렉티브'
T2b: Failed asserting that 4 is identical to 1. (페이지 H1 중복)
T3: Expected response status code [301] but received 404.
T4: 기대 'index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large'
    실제 'index, follow'
T5: /seo-backlinks/: exactly one original-content section
    Failed asserting that 0 is identical to 1.
T6: home: original sentences and numbers must not change
    기대 SHA256 033064a56aebb18d8906fa9d51b1c498ff140fc0d7bb0890b5ce8111d6cd79f4
    변조 SHA256 9a49c50d7db072abc692a3912a7b5b3cb07e5f9820e5ff125176020b35ab298a
```

원복 후 전체 재검사 실제 출력:

```sh
php artisan test
```

```json
{"tool":"phpunit","result":"passed","tests":183,"passed":183,"assertions":20195,"duration_ms":10125}
```

최초 전체 검사도 183 passed / 20,195 assertions였어. 빌드 실제 출력:

```text
$ npm run build
vite v8.2.0 building client environment for production...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time,
it will remain unchanged to be resolved at runtime
✓ 12 modules transformed.
public/build/manifest.json                      0.88 kB
public/build/assets/legacy-reskin-3fymEzpK.css   13.71 kB
public/build/assets/jc-Bqs11fyj.css              90.23 kB
public/build/assets/app-BW-Dp7Pe.css             97.52 kB
public/build/assets/jc-DIWfGL1E.js               25.80 kB
public/build/assets/app-XOhwnyVw.js             159.36 kB
✓ built in 22.31s
EXIT=0
```

위 미디어 해석 경고와 plugin timing 안내가 있었어. 빌드 성공과 실제 미디어 로딩 검증은 구분하며, 미디어 파일은 수정하지 않았어.

## 원복·서버 보존·증거 위치

원본에서 실험 전후 `git diff | shasum` 실제 출력:

```text
before da39a3ee5e6b4b0d3255bfef95601890afd80709  -
after  da39a3ee5e6b4b0d3255bfef95601890afd80709  -
```

체크포인트에 포함된 파일도 빠지지 않도록, 보고서 작성 전 원본 소스 524개와 격리본의 파일별 SHA256을 함께 비교했어.

```text
original_files=524
original_changed=[]
snapshot_changed=[]
source_manifest_sha256=e8417dcf435fbae1a1acc0aad95b2529ca7130a8cb890c7eba40e0cf5fbc8fab
HEAD=0633f883f33f2d1169a8af101e03850ec5e9ccbd
```

처음과 마지막 `lsof`에서 포트 8000은 PHP PID **70383**, 포트 8014는 PHP PID **25237**로 같았어. 둘 다 요청·종료·재시작·설정 변경을 하지 않았어. 검증용 8013은 종료되어 LISTEN 항목이 없었어.

레포에 작성한 산출물은 이 보고서 하나야. 소스·기존 테스트·원문 JSON·미디어·큐·대시보드는 수정하지 않았고, 커밋·푸시·배포는 하지 않았어. 외부 대시보드 경로는 쓰기 허용 범위 밖이고 이번 요청도 판정 문서만 작성하는 범위라 갱신하지 않았어.

원시 HTML·테이블 덤프·실행 로그와 독립 검증 스크립트는 `/private/tmp/jcurve-seo-meta-02-verify-45WXtF`에 보존했어. 주요 증거:

- `evidence/audit-final.json`: V1~V18 경로별 기대·실제·문자 diff·전수 HTTP 결과.
- `evidence/production-index.json`, `production-*.html`: 운영 GET 응답 상태·헤더·HTML.
- `evidence/base-export.json`, `current-export.json`, `upgrade-1.json`, `upgrade-2.json`, `upgrade-delayed.log`: DB 비교.
- `evidence/full-tests.log`, `full-tests-restored.log`, `pint-full.log`, `pint-base.log`, `pint-changed.log`, `build.log`: 실제 게이트 출력.
- `evidence/T*.log`, `escape-probe.log`, `final-checks.json`, `source-before.json`: 무력화·이스케이프·보존 근거.
- `prepare.py`, `audit.py`, `refine.py`, `compare_baseline.py`, `mutation_test.py`, `final_checks.py`, `export.php`, `escape.php`: 실행한 독립 검증 도구. 모두 레포 밖에 있어.

## 미검증 항목과 판정 경계

- 실제 운영 반영·MySQL/PHP 8.3 서버에서의 재실행·Nginx/Apache의 정적 robots 응답·검색엔진 재수집/순위 변화는 검사하지 않았어. 운영 GET은 현재 워드프레스 원문 대조용이야.
- 전체 브라우저 시각/상호작용·이미지의 실제 로딩·모바일 레이아웃 평가는 이번 HTML·SEO 검증 범위 밖이야.
- 원문 숫자의 사실성·광고 문구의 적정성은 이번 원문 보존 검사로 판단하지 않았어.
- 격리본 테스트의 최초 환경 문제였던 기준 Vite manifest 부재는 빌드 manifest 제공 후 다시 실행했고, Python의 한국어 Location 디코딩과 카테고리 이름 가정도 실제 기준 데이터로 교정했어. 최종 표에는 재현이 해소된 검증 도구 오류를 제품 결함으로 넣지 않았어.
- 구현 SPEC의 변경 PHP 게이트와 달리 VERIFY V14의 전체 Pint는 아직 실패야. 최종 승인자는 이 기존 실패의 처리 여부를 결정해야 하며, 이번 검증은 자동으로 예외를 만들지 않았어.

운영 반영 커밋으로 써도 안 됨 — SEO 기능·원문 보존·필수 무력화 실험은 통과했지만, VERIFY V14의 전체 Pint 게이트가 기존 3개 파일의 스타일 위반으로 실패했어.
