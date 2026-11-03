# INTL-02 구현 반환물

- 작업 위치: `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`
- 브랜치: `wip/2026-11-03-i18n`, HEAD `6ad6c8d` + 시작 시 미커밋 변경을 기준으로 작업.
- 기준: SPEC-CODEX-INTL-02 전체, 특히 추가 지시 A~E. COLLAB/QUEUE, INTL-PLAN, GLOSSARY, INTL-01 계약 및 지정 본보기 적용.
- 설계·최종 검수: Claude. 구현·실행 증거: Codex(서비스/솔루션/서브페이지는 소유 파일을 나눠 구현). **이 문서는 구현 세션 결과이며 독립 검증·최종 합격 판정은 아니다.**
- 커밋·푸시·배포 없음. 한국어 뷰·config/subpages 값·본보기·미디어·.env·INTL-03 insights JSON은 수정하지 않았다. 금지 포트 서버도 실행하지 않았다.
- 시작 시 존재하던 회사소개·문의·intl-app 및 한국어 head/header/switcher 변경과 다른 세션 문서는 그대로 보존했다.

## 1. 구현 결과

- 정적 43주소 × 2언어 + 4개 카테고리·4개 글 × 2언어 = **102개 응답**의 200, html lang, 자기 canonical, ko/en/ja/x-default, 본문 한글·번역키 노출 0 검사.
- 페이지 내부 링크를 중복 제거 후 요청: 200 또는 의도된 301 한 번 뒤 200. 로그인·회원가입·계정·주문·무료 도구·문의게시판 링크 배제.
- FAQ 81문항 × 2언어, 서브페이지 19개 × 2언어. EN/JA 키 구조 동일. JSON-LD의 @context 및 inLanguage 검사.
- 블로그는 현재 언어 translation의 제목·요약·본문·slug, 번역 카테고리 이름과 날짜 표기 사용. 페이지네이션 두 번째 페이지도 확인.
- 성과 페이지는 회사 전체 누적·2026년 기준 라벨과 숫자 유지. 사례 0건 화면, 한국어 사례가 있더라도 외국어에 무번역 데이터나 제외된 상세 링크가 나오지 않는 경우까지 검사.
- 한국어 **109주소(200:104, 302:1, 301:4)**의 상태·Location·본문 차이 0. 한국어 사이트맵 **94항목**의 배열 및 실제 XML 노드 순서/내용 동일. 외국어 항목은 뒤에만 추가.
- 빌드: npm 기본 명령은 지정된 샌드박스 EPERM. 지시된 runner 대체 명령은 성공.

## 2. 백엔드·테스트 변경 이유

| 파일 | 변경 |
|---|---|
| app/Support/IntlRoutes.php | route+params→foreign view 매핑 및 View::exists/언어별 서브페이지 존재 판정을 한곳에 모음 |
| app/Support/intl.php | intl_view·intl_alternates가 위 판정을 공유. 실제 외국어판이 없으면 hreflang 결과 빈 배열 |
| app/Services/Seo/Publishing/FeedCatalog.php | 정적·글·카테고리 사이트맵에 동일 뷰 존재 판정 적용. 기존 글/카테고리 번역·공개 조건 유지 |
| app/Http/Controllers/PageController.php | 외국어 서브페이지의 parent/page를 해당 언어 배열과 병합. 한국어 분기는 기존 config 그대로 |
| routes/intl.php | /services/{slug}에 5개 서비스 allowlist 적용. 앞서 등록된 동적 라우트가 /services/marketing-support를 가로채던 기존 404 문제 해결 |
| database/seeders/IntlInsightSeeder.php | 선택적 directory 인자 추가. 기본 운영 입력 경로는 동일, 테스트는 임시 fixture 디렉터리를 명시 |
| tests/TestCase.php | 일반 회귀 테스트가 병행 작성 중인 INTL-03 JSON을 읽지 않도록 국제화 시더를 기본 no-op으로 격리 |
| tests/Support/UsesIntlFixture.php | INTL 테스트에서만 시더 바인딩을 임시 파일 데이터로 대체. 제목·본문·hash 모두 테스트에서 생성, 종료 때 정리 |
| tests/Feature/IntlFoundationTest.php | 새 뷰가 있는 별칭의 목적지 200, 한국어 홈 hreflang 존재로 계약 수정. 시더 멱등/갱신/낡음 검사는 고정 fixture로 계속 검사 |
| tests/Feature/IntlPagesTest.php | 전 페이지 언어/SEO/링크·FAQ·키구조·JSON-LD·누락 뷰/서브페이지·제외 구역·페이지네이션·빈/미번역 사례 검사 |
| tests/Support/intl_compare.py, intl_snapshot.php | 기준0662117 archive와 격리 SQLite 비교. 리다이렉트를 따라가지 않고 Location 포함. 지정 두 블록만 현재 출력에서 제거. 실제 sitemap XML도 비교 |

비교 정규화: 양쪽 동일 CSRF·허니팟 이름/시간·SVG 임의 id·Vite 해시. 현재 출력에서만 정확한 hreflang 줄과 data-intl-switcher nav 블록 제거, 앞 공백은 유지. .env 심볼릭 링크를 없애고 임시 환경 경로 사용. 실DB·다른 세션 임시DB 사용 및 DB_DATABASE 셸 export 없음.

## 3. 블로그·성과 화면의 문장/링크·숫자 대조

| 화면 | 문구·링크 처리 | 숫자 |
|---|---|---|
| insights.index/category | 원문 레이아웃·카드·빈 상태 유지. 한국어 모델 문구 대신 translation 사용, 카테고리는 insights.categories 맵. 링크·페이지네이션은 현재 언어 | 카드 요약90자 제한 유지. 게시일은 EN M j, Y / JA Y年n月j日 |
| insights.show | 번역 제목/메타/본문 사용. 신뢰된 시더 HTML만 기존 방식으로 raw 출력. 번역 계약이 없는 사용자 nickname/name 표시와 임의 sources 표시 생략. source_url은 비ASCII 문자만 URL 인코딩. 관련 글은 번역 있는 항목만 표시 | 읽는 시간 기존500자/분 계산 유지, 최소1분. 글 본문 숫자는 INTL-03 영역이며 테스트 fixture 외 실번역 글 검수 미실시 |
| work.index | 개별 사례 상세는 제외 구역이므로 연결하지 않음. 0건 안내와 미번역 사례 안내 구분. 카운트 효과 제거, 문의 연결 | 373억+→KRW37.3B+/373億ウォン+, 128만+→1.28M+/128万件+, 15,700+→15,700+/15,700件+, 2009년→2009/2009年. 회사 전체 누적·2026년 기준 유지. 원칙4개·질문4개 유지 |
| privacy | 4개 조항·도입·마무리 전체 번역, 한국어 원문 우선 안내 추가 | 조항1~4·전화·이메일 그대로 |
| FAQ | 81문항 전부. 문의게시판은 문의폼으로. FAQ 검색/카테고리 전환 시 공용JS의 한글 건수 덮어쓰기를 외국어 템플릿 내 국소 observer로 보정 | 81·무료100개·월5회·301·1:1 유지 |

나머지 페이지별 제거 문장·변경 링크·숫자 대조표는 아래 분업 부록을 함께 구성한다.

## 4. 무력화 실험

### V5: 뷰 매핑/존재 확인

1. 서비스 매핑의 `services.`를 `missing-services.`로 임시 변경. SEO 한국어 응답의 hreflang 0, 외국어 SEO404, 외국어 sitemap 주소 제외를 검사하는 테스트 **1/1, 7 assertions** 통과.
2. 원복 후 `! View::exists('intl.'.$view)` 방어를 임시 제거. 같은 테스트가 실제로 빨개짐:

```text
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":2,"duration_ms":318,"failed":1,"failures":[{"test":"Tests\\Feature\\IntlPagesTest::test_missing_view_is_excluded_from_rendering_alternates_and_sitemap","file":"/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Feature/IntlPagesTest.php","line":129,"message":"Missing foreign view must suppress hreflang\nFailed asserting that 4 is identical to 0."}]}
```

3. 두 실험 모두 원복 전후 `git diff | shasum` 동일:
`b6bc54ff9b5064a4413af88d25b0e1c9e52d6137`.
IntlRoutes.php SHA256도 원복:
`3b4f8bb027643eb4bec6ecd22a38acd98c0a5a58b539b79edfcf1b53139fc9ae`.
원복 후 해당 테스트 **1/1, 7 assertions** 통과.

### 번역 키 삭제

`lang/en/pages/insights.php`의 heading 키를 실제로 삭제하고, 전체페이지와 같은 assertLocalizedPage 검사기를 사용하는 동적페이지 테스트 실행:

```text
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":9,"duration_ms":276,"failed":1,"failures":[{"test":"Tests\\Feature\\IntlPagesTest::test_translated_pagination_and_article_rendering_use_locale_data","file":"/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Feature/IntlPagesTest.php","line":150,"message":"/en/blog/ Translation key: pages/insights.heading\nFailed asserting that 1 is identical to 0."}]}
```

### 한글 삽입

`resources/views/intl/insights/index.blade.php`의 main에 `<p>무력화</p>`를 실제 삽입:

```text
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":8,"duration_ms":205,"failed":1,"failures":[{"test":"Tests\\Feature\\IntlPagesTest::test_translated_pagination_and_article_rendering_use_locale_data","file":"/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Feature/IntlPagesTest.php","line":150,"message":"/en/blog/ Hangul: \ubb34\ub825\ud654\nFailed asserting that 1 is identical to 0."}]}
```

두 파일 원복 후 해당 테스트 **1/1, 42 assertions** 통과(이후 추가한 미번역 성과 케이스까지는64 assertions).
두 실험의 원복 전후 `git diff | shasum`은 모두
`a21c25c649fda46bdf1e583f97f2fd4bc2c79cac`.
신규 파일은 git diff에 포함되지 않으므로 파일 자체 SHA256도 확인:
- lang/en/pages/insights.php: `5299149a4e97ee403e2fb2dcd0b541b5fac4c008c08268b709d7c76debbca298`
- resources/views/intl/insights/index.blade.php: `2620afe2cbcfc92c39876bd067bc8f19aa75f4fac57f343a1550d9b853212bf5`

실험 명령:
```sh
php artisan test --filter=test_missing_view_is_excluded_from_rendering_alternates_and_sitemap
php artisan test --filter=test_translated_pagination_and_article_rendering_use_locale_data
git diff | shasum
shasum -a 256 app/Support/IntlRoutes.php
shasum -a 256 lang/en/pages/insights.php resources/views/intl/insights/index.blade.php
```

## 5. 미검증·최종 검수에 남기는 항목

- 별도 세션 독립 검증, Claude 최종 합격 판정, 실제 브라우저 시각/반응형/키보드·FAQ 동작 검수 미실시.
- FAQ/서브페이지는 공개 원문 Google Translate 초벌 후 용어·숫자·핵심 고지와 FAQ를 수동 보정했다. 영어·일본어 전체 원어민/B2B 교열은 미실시. 기계번역 잔여 문단·보험 리드 유형 관용 표현은 부록에 명시.
- 부록 취합 중 보험 제목의 “冗長”를 중복의 뜻인 “重複”로, 전달 시점을 “リード提供時点”로 최종 보정했다. 영어4개 원칙도 Lead handoff/Duplicate 용어로 정리. 숫자·기준 의미는 그대로.
- 공식 외국어 이름을 확인하지 못한 앱 이름, 보험·투자 리드 규제 표현은 Claude 카피 검수 필요. 외부 서비스 현재 가격/조건 재조사는 하지 않았고 한국어 원문 값 보존.
- INTL-03 JSON/실번역 글 본문 링크·콘텐츠 품질·번역hash는 이 세션에서 검수하지 않았다. 52편 실제 통합은 별도 검증 대상. 테스트는 생성 fixture만 사용한다.
- 보호 본보기의 기존 메타 권장 길이 초과는 수정 금지에 따라 보존: company EN title76자, contact EN description198자, home EN description221자. 이번 신규 페이지의 메타는 별도 검사.
- 빌드 경고 `/media/bg/hero-glow.webp` 미해결은 아래 원문 그대로 기록. 미디어 보호 규칙에 따라 수정하지 않았다.
- 외부 대시보드 tasks.json 및 대시보드 재생성은 허용 쓰기 루트 밖이므로 실행하지 못했다. 결과는 이 worktree 반환물에 남긴다.
- 커밋·푸시·배포·실DB migration·실 문의 제출 없음.

## 6. 최종 실행 명령·실제 출력

모든 명령은 지정 worktree에서 실행했다. 테스트 DB는 phpunit.xml의 SQLite :memory:, 비교기는 스스로 만든 임시 SQLite만 사용했다.

### 전체 테스트

```sh
php artisan test
```
최종 exit 0:
```text
{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":31375}
```

**206/206 테스트, 36,008 assertions.** 테스트 공통 시더 격리와 최종 보험 용어 수정까지 포함한 출력이다.

### Pint

아래 86개 PHP 경로를 명시했다. Blade 실제 동작은 HTTP 렌더 테스트에서 검증했다.
```sh
./vendor/bin/pint --test 'app/Http/Controllers/PageController.php' 'app/Services/Seo/Publishing/FeedCatalog.php' 'app/Support/IntlRoutes.php' 'app/Support/intl.php' 'database/seeders/IntlInsightSeeder.php' 'routes/intl.php' 'tests/Feature/IntlFoundationTest.php' 'tests/Support/intl_snapshot.php' 'lang/en/insights.php' 'lang/en/pages/aeo.php' 'lang/en/pages/boostingshop.php' 'lang/en/pages/call2sale.php' 'lang/en/pages/cpa-marketing.php' 'lang/en/pages/faq.php' 'lang/en/pages/geo.php' 'lang/en/pages/insights.php' 'lang/en/pages/leadbay.php' 'lang/en/pages/marketing-support.php' 'lang/en/pages/performance-marketing.php' 'lang/en/pages/privacy.php' 'lang/en/pages/rankfree.php' 'lang/en/pages/reward-network.php' 'lang/en/pages/self-marketing-place.php' 'lang/en/pages/self-marketing.php' 'lang/en/pages/seo.php' 'lang/en/pages/services-index.php' 'lang/en/pages/shopitrend.php' 'lang/en/pages/solutions-index.php' 'lang/en/pages/subpage.php' 'lang/en/pages/wordpress.php' 'lang/en/pages/work.php' 'lang/en/subpages.php' 'lang/ja/insights.php' 'lang/ja/pages/aeo.php' 'lang/ja/pages/boostingshop.php' 'lang/ja/pages/call2sale.php' 'lang/ja/pages/cpa-marketing.php' 'lang/ja/pages/faq.php' 'lang/ja/pages/geo.php' 'lang/ja/pages/insights.php' 'lang/ja/pages/leadbay.php' 'lang/ja/pages/marketing-support.php' 'lang/ja/pages/performance-marketing.php' 'lang/ja/pages/privacy.php' 'lang/ja/pages/rankfree.php' 'lang/ja/pages/reward-network.php' 'lang/ja/pages/self-marketing-place.php' 'lang/ja/pages/self-marketing.php' 'lang/ja/pages/seo.php' 'lang/ja/pages/services-index.php' 'lang/ja/pages/shopitrend.php' 'lang/ja/pages/solutions-index.php' 'lang/ja/pages/subpage.php' 'lang/ja/pages/wordpress.php' 'lang/ja/pages/work.php' 'lang/ja/subpages.php' 'resources/views/intl/insights/category.blade.php' 'resources/views/intl/insights/index.blade.php' 'resources/views/intl/insights/partials/cards.blade.php' 'resources/views/intl/insights/partials/tabs.blade.php' 'resources/views/intl/insights/show.blade.php' 'resources/views/intl/pages/faq.blade.php' 'resources/views/intl/pages/marketing-support.blade.php' 'resources/views/intl/pages/privacy.blade.php' 'resources/views/intl/pages/self-marketing-place.blade.php' 'resources/views/intl/pages/self-marketing.blade.php' 'resources/views/intl/pages/subpage.blade.php' 'resources/views/intl/partials/pagination.blade.php' 'resources/views/intl/services/cpa-marketing.blade.php' 'resources/views/intl/services/index.blade.php' 'resources/views/intl/services/performance-marketing.blade.php' 'resources/views/intl/services/reward-network.blade.php' 'resources/views/intl/services/seo.blade.php' 'resources/views/intl/services/seo/aeo.blade.php' 'resources/views/intl/services/seo/geo.blade.php' 'resources/views/intl/services/wordpress.blade.php' 'resources/views/intl/solutions/boostingshop.blade.php' 'resources/views/intl/solutions/call2sale.blade.php' 'resources/views/intl/solutions/index.blade.php' 'resources/views/intl/solutions/leadbay.blade.php' 'resources/views/intl/solutions/rankfree.blade.php' 'resources/views/intl/solutions/shopitrend.blade.php' 'resources/views/intl/work/index.blade.php' 'tests/Feature/IntlPagesTest.php' 'tests/Support/UsesIntlFixture.php' 'tests/TestCase.php'
```
최종 exit 0:
```text
{"tool":"pint","result":"passed"}
```

### 한국어 응답·XML 비교

```sh
python3 tests/Support/intl_compare.py
```
exit 0:
```text
baseline: php /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Support/intl_snapshot.php /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/intl-01-m6kfqx53/base /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/intl-01-m6kfqx53/baseline.json
Snapshot: 109 Korean pages; preserved paths: 16
Korean sitemap entries: 94
HTTP statuses: {"200":104,"302":1,"301":4}
implementation: php /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Support/intl_snapshot.php /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/intl-01-m6kfqx53/implementation.json /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/intl-01-m6kfqx53/baseline.json
Snapshot: 109 Korean pages; preserved paths: 16
Korean sitemap entries: 94
HTTP statuses: {"200":104,"302":1,"301":4}
Korean sitemap entries identical (including order/lastmod): True
Korean sitemap XML nodes identical (including order/content): True
Foreign sitemap entries appended only: True
Korean rendered pages: 109
HTML/status differences: 0
Normalization: CSRF, honeypot name/timer, SVG IDs, Vite hashes. Implementation only: exact hreflang lines and switcher blocks; leading whitespace retained. Redirects not followed; status, Location and body compared.
Temporary archive, SQLite databases, snapshots: removed on exit.
```

### 빌드

최초 명령:
```sh
npm run build
```
실제 exit 1:
```text
> build
> vite build

failed to load config from /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/vite.config.js
error during build:
Error: EPERM: operation not permitted, open '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/node_modules/.vite-temp/vite.config.js.timestamp-1793686833908-a9d2a851f82bc.mjs'
    at async open (node:internal/fs/promises:637:25)
    at async Object.writeFile (node:internal/fs/promises:1219:14)
    at async loadConfigFromBundledFile (file:///Users/anarchy/Claude_Projects/jcurve/node_modules/vite/dist/node/chunks/node.js:37009:3)
    at async bundleAndLoadConfigFile (file:///Users/anarchy/Claude_Projects/jcurve/node_modules/vite/dist/node/chunks/node.js:36864:21)
    at async loadConfigFromFile (file:///Users/anarchy/Claude_Projects/jcurve/node_modules/vite/dist/node/chunks/node.js:36824:42)
    at async resolveConfig (file:///Users/anarchy/Claude_Projects/jcurve/node_modules/vite/dist/node/chunks/node.js:36433:22)
    at async createBuilder (file:///Users/anarchy/Claude_Projects/jcurve/node_modules/vite/dist/node/chunks/node.js:34066:17)
    at async CAC.<anonymous> (file:///Users/anarchy/Claude_Projects/jcurve/node_modules/vite/dist/node/cli.js:765:19) {
  errno: -1,
  code: 'EPERM',
  syscall: 'open',
  path: '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/node_modules/.vite-temp/vite.config.js.timestamp-1793686833908-a9d2a851f82bc.mjs'
}
```

추가 지시 E에 따른 대체 명령:
```sh
npx vite build --configLoader runner
```
페이지 구현 후 최종 exit 0(ANSI 화면제어 문자만 제거):
```text
vite v8.2.0 building client environment for production...
transforming...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
✓ 12 modules transformed.
rendering chunks...
computing gzip size...
public/build/manifest.json                        0.88 kB │ gzip:  0.26 kB
public/build/assets/legacy-reskin-3fymEzpK.css   13.71 kB │ gzip:  2.99 kB
public/build/assets/jc-BtbJwSAY.css              92.14 kB │ gzip: 17.86 kB
public/build/assets/app-C57TKjOE.css            108.87 kB │ gzip: 20.21 kB
public/build/assets/jc-DIWfGL1E.js               25.80 kB │ gzip:  9.23 kB
public/build/assets/app-XOhwnyVw.js             159.36 kB │ gzip: 60.50 kB

✓ built in 1.83s
```

### 수량·형상 확인

```text
en subpages: 19
en FAQ: 81
ja subpages: 19
ja FAQ: 81
```

`git branch --show-current` = `wip/2026-11-03-i18n`, `git rev-parse --short HEAD` = `6ad6c8d`.
`git diff --check`: 출력 없음, exit 0. 시작 전 변경은 스테이징하거나 되돌리지 않았다.

## 7. 이번 세션 변경 파일 전체

신규 코드77개 + 기존 코드10개 = **87개**, 이 반환물1개 별도. 빌드의 ignored public/build 산출물은 별도다. 기존 Claude 미커밋 파일6개와 head/header/switcher는 아래 소유 목록에서 제외한다.

| 구분 | 파일 |
|---|---|
| 수정 | `app/Http/Controllers/PageController.php` |
| 수정 | `app/Services/Seo/Publishing/FeedCatalog.php` |
| 수정 | `app/Support/IntlRoutes.php` |
| 수정 | `app/Support/intl.php` |
| 수정 | `database/seeders/IntlInsightSeeder.php` |
| 수정 | `routes/intl.php` |
| 수정 | `tests/Feature/IntlFoundationTest.php` |
| 수정 | `tests/Support/intl_compare.py` |
| 수정 | `tests/Support/intl_snapshot.php` |
| 수정 | `tests/TestCase.php` |
| 신규 | `lang/en/insights.php` |
| 신규 | `lang/en/pages/aeo.php` |
| 신규 | `lang/en/pages/boostingshop.php` |
| 신규 | `lang/en/pages/call2sale.php` |
| 신규 | `lang/en/pages/cpa-marketing.php` |
| 신규 | `lang/en/pages/faq.php` |
| 신규 | `lang/en/pages/geo.php` |
| 신규 | `lang/en/pages/insights.php` |
| 신규 | `lang/en/pages/leadbay.php` |
| 신규 | `lang/en/pages/marketing-support.php` |
| 신규 | `lang/en/pages/performance-marketing.php` |
| 신규 | `lang/en/pages/privacy.php` |
| 신규 | `lang/en/pages/rankfree.php` |
| 신규 | `lang/en/pages/reward-network.php` |
| 신규 | `lang/en/pages/self-marketing-place.php` |
| 신규 | `lang/en/pages/self-marketing.php` |
| 신규 | `lang/en/pages/seo.php` |
| 신규 | `lang/en/pages/services-index.php` |
| 신규 | `lang/en/pages/shopitrend.php` |
| 신규 | `lang/en/pages/solutions-index.php` |
| 신규 | `lang/en/pages/subpage.php` |
| 신규 | `lang/en/pages/wordpress.php` |
| 신규 | `lang/en/pages/work.php` |
| 신규 | `lang/en/subpages.php` |
| 신규 | `lang/ja/insights.php` |
| 신규 | `lang/ja/pages/aeo.php` |
| 신규 | `lang/ja/pages/boostingshop.php` |
| 신규 | `lang/ja/pages/call2sale.php` |
| 신규 | `lang/ja/pages/cpa-marketing.php` |
| 신규 | `lang/ja/pages/faq.php` |
| 신규 | `lang/ja/pages/geo.php` |
| 신규 | `lang/ja/pages/insights.php` |
| 신규 | `lang/ja/pages/leadbay.php` |
| 신규 | `lang/ja/pages/marketing-support.php` |
| 신규 | `lang/ja/pages/performance-marketing.php` |
| 신규 | `lang/ja/pages/privacy.php` |
| 신규 | `lang/ja/pages/rankfree.php` |
| 신규 | `lang/ja/pages/reward-network.php` |
| 신규 | `lang/ja/pages/self-marketing-place.php` |
| 신규 | `lang/ja/pages/self-marketing.php` |
| 신규 | `lang/ja/pages/seo.php` |
| 신규 | `lang/ja/pages/services-index.php` |
| 신규 | `lang/ja/pages/shopitrend.php` |
| 신규 | `lang/ja/pages/solutions-index.php` |
| 신규 | `lang/ja/pages/subpage.php` |
| 신규 | `lang/ja/pages/wordpress.php` |
| 신규 | `lang/ja/pages/work.php` |
| 신규 | `lang/ja/subpages.php` |
| 신규 | `resources/views/intl/insights/category.blade.php` |
| 신규 | `resources/views/intl/insights/index.blade.php` |
| 신규 | `resources/views/intl/insights/partials/cards.blade.php` |
| 신규 | `resources/views/intl/insights/partials/tabs.blade.php` |
| 신규 | `resources/views/intl/insights/show.blade.php` |
| 신규 | `resources/views/intl/pages/faq.blade.php` |
| 신규 | `resources/views/intl/pages/marketing-support.blade.php` |
| 신규 | `resources/views/intl/pages/privacy.blade.php` |
| 신규 | `resources/views/intl/pages/self-marketing-place.blade.php` |
| 신규 | `resources/views/intl/pages/self-marketing.blade.php` |
| 신규 | `resources/views/intl/pages/subpage.blade.php` |
| 신규 | `resources/views/intl/partials/pagination.blade.php` |
| 신규 | `resources/views/intl/services/cpa-marketing.blade.php` |
| 신규 | `resources/views/intl/services/index.blade.php` |
| 신규 | `resources/views/intl/services/performance-marketing.blade.php` |
| 신규 | `resources/views/intl/services/reward-network.blade.php` |
| 신규 | `resources/views/intl/services/seo.blade.php` |
| 신규 | `resources/views/intl/services/seo/aeo.blade.php` |
| 신규 | `resources/views/intl/services/seo/geo.blade.php` |
| 신규 | `resources/views/intl/services/wordpress.blade.php` |
| 신규 | `resources/views/intl/solutions/boostingshop.blade.php` |
| 신규 | `resources/views/intl/solutions/call2sale.blade.php` |
| 신규 | `resources/views/intl/solutions/index.blade.php` |
| 신규 | `resources/views/intl/solutions/leadbay.blade.php` |
| 신규 | `resources/views/intl/solutions/rankfree.blade.php` |
| 신규 | `resources/views/intl/solutions/shopitrend.blade.php` |
| 신규 | `resources/views/intl/work/index.blade.php` |
| 신규 | `tests/Feature/IntlPagesTest.php` |
| 신규 | `tests/Support/UsesIntlFixture.php` |
| 신규 반환물 | `docs/intl/INTL-02-IMPL-RESULT.md` |

## 8. 페이지별 상세 부록

아래는 구현 분업에서 받은 페이지별 숫자·제외문장·링크 대조와 실행 증거다. 분업에서 미실시한 통합 검증은 본문 §6의 최종 실행으로 보완했다. 원어민/브라우저 검수와 독립 판정은 여전히 미실시다.

## INTL-02 서비스 페이지 분업 반환물

작업자: Codex service_pages. 소유 범위만 수정했으며 한국어 뷰, 공용 backend/tests, 본보기, database/content/intl/insights/*.json 은 수정하지 않았다. 커밋·푸시·배포 없음. 구현 세션의 증거이며 최종 검수 판정은 Claude 담당.

### 변경 파일

| 페이지 | 외국어 뷰 | EN·JA 언어 파일 |
|---|---|---|
| 서비스 목록 | resources/views/intl/services/index.blade.php | lang/{en,ja}/pages/services-index.php |
| 퍼포먼스 | resources/views/intl/services/performance-marketing.blade.php | lang/{en,ja}/pages/performance-marketing.php |
| CPA | resources/views/intl/services/cpa-marketing.blade.php | lang/{en,ja}/pages/cpa-marketing.php |
| 리워드 | resources/views/intl/services/reward-network.blade.php | lang/{en,ja}/pages/reward-network.php |
| SEO | resources/views/intl/services/seo.blade.php | lang/{en,ja}/pages/seo.php |
| WordPress | resources/views/intl/services/wordpress.blade.php | lang/{en,ja}/pages/wordpress.php |
| AEO | resources/views/intl/services/seo/aeo.blade.php | lang/{en,ja}/pages/aeo.php |
| GEO | resources/views/intl/services/seo/geo.blade.php | lang/{en,ja}/pages/geo.php |
| 정부 지원사업 | resources/views/intl/pages/marketing-support.blade.php | lang/{en,ja}/pages/marketing-support.php |

합계 27파일(뷰9+언어18). 한국어의 layouts.app 를 layouts.intl-app 로 대응. 텍스트를 페이지별 s000 계열 키로 옮겼고 EN/JA 키 구조가 같다. 기존 PHP FAQ 배열은 번역 키를 사용하며 모든 FAQ 문항을 유지했다. 원문에 있던 영어 섹션명·UI 예시의 숫자도 언어 파일로 이동했다. 줄바꿈은 e()를 거치는 $lines 로 출력한다. FAQ JSON-LD 는 @context 구조를 유지하고 inLanguage 및 JSON_HEX_TAG 를 추가했다.

### 페이지별 제거·링크 변경

| 페이지 | 제외한 한국어 전용 내용 | 링크 처리 |
|---|---|---|
| 서비스 목록 | 없음 | 모든 route 를 intl_route 로 변경. 서비스5개·문의는 현재 언어 유지 |
| 퍼포먼스 | 없음 | 모든 route 를 intl_route 로 변경. Google Ads 서브페이지 설정이 없으면 해당 언어 문의로 가는 기존 조건 유지 |
| CPA | 없음 | 모든 route 를 intl_route 로 변경. 업종별5개와 LeadBay·Call2Sale 포함 |
| 리워드 | 없음 | 모든 route 를 intl_route 로 변경. 광고주·매체 CTA 의 service_interest 유지, 미리 채우는 message 도 각각 EN/JA 로 번역 |
| SEO | partials.jc.wp-legacy 전체: 한국어 SEO 보존용 원문 블록 | 모든 route 를 intl_route 로 변경. AEO·GEO 및 하위5개 서비스 유지 |
| WordPress | partials.jc.wp-legacy 전체: 한국어 SEO 보존용 원문 블록 | 모든 route 를 intl_route 로 변경 |
| AEO | 한국어 도구로 유도하는 “무료 GEO·AEO 자가진단 →” CTA 문구를 문의 취지로 대체(상단·하단2곳) | seo.check → intl_route('contact', ['service_interest' => 'seo']), AEO/GEO/SEO 링크는 현재 언어 유지 |
| GEO | 한국어 도구로 유도하는 “무료 GEO·AEO 자가진단 →” CTA 문구를 문의 취지로 대체(상단·하단2곳) | seo.check → intl_route('contact', ['service_interest' => 'seo']), AEO/GEO/SEO 링크는 현재 언어 유지 |
| 정부 지원사업 | 없음 | 모든 route 를 intl_route 로 변경. 선정·지원금 지급 보장 안 함, 신청기업 책임, 운영기관 권한 고지 유지 |

이 소유 원문에는 partials.jc.rank-form·카카오 버튼·로그인·주문 CTA·“지금 이 화면도 검색 상위” 주장이 없어 별도 삭제하지 않았다. 리워드 UI 는 설명용 예시이며 실제 플랫폼 UI 가 아니라는 고지, 파트너 로고가 네트워크 예시라는 고지를 유지했다.

### 페이지별 숫자 대조

| 페이지 | 한국어 원문 | EN | JA |
|---|---|---|---|
| 서비스 목록 | 채널 다섯 / 먼저 맞추는 네 가지 | five channels / Four foundations | チャネルが5つ / 4つの基準 |
| 퍼포먼스 | 2026년 / 회사 전체 누적373억원·373억+ / 15,700건 이상·15,700+ / 주 단위 | as of 2026 / company-wide cumulative KRW 37.3 billion·KRW 37.3B+ / 15,700+ / Weekly | 2026年時点 / 会社全体の累計373億ウォン・373億ウォン+ / 15,700件以上・15,700+ / 週単位 |
| CPA | 네 가지 조건 | Four conditions | 4つの条件 |
| 리워드 | 리뷰313 / 4.88 / 미션2/4 / 52,000원 / 48,500원 / 8%·7% / 10:24·10:26·10:28 / 5G / 1~4단계 | 313 reviews / 4.88 / 2/4 / KRW 52,000 / KRW 48,500 / 8%·7% / 같은 시각 / 5G / 1~4 | レビュー313件 / 4.88 / 2/4 / 52,000ウォン / 48,500ウォン / 8%・7% / 같은 시각 / 5G / 1~4 |
| SEO | 10년간 / 1,000여 프로젝트 / 다섯 층 / 월50만원부터 / 일주일 안에1위 보장 요구는 부적합 | 10 years / Around 1,000 projects / five layers / From KRW 500,000/month / guaranteed No.1 within a week 는 부적합 | 10年間 / 約1,000件 / 5つの層 / 月50万ウォンから / 1週間以内の1位保証要求は不適合 |
| WordPress | 10년간 / 500여 / 다섯 가지 / 301 | 10 years / Around 500 / Five decisions / 301 | 10年間 / 約500件 / 5つ / 301 |
| AEO | 고정 성과 숫자 없음 | 새 숫자·보장 없음 | 새 숫자·보장 없음 |
| GEO | 고정 성과 숫자 없음 | 새 숫자·보장 없음 | 새 숫자·보장 없음 |
| 정부 지원사업 | 고정 성과·지원금 숫자 없음 | 새 숫자·지원자격·보장 없음 | 새 숫자·지원자격·보장 없음 |

WordPress 원문은 “다섯 가지” 제목 아래에 확장계획까지6항목을 담고 있다. 제목과6항목 모두 원문대로 보존했다. 코드·SVG·CSS의 크기 수치는 변경하지 않았다. 원화를 달러나 엔으로 환산하지 않았다.

### 언어·메타 점검 실제 출력

실행: Python 래퍼에서 각 언어 파일을 `php -r 'echo json_encode(require $argv[1], JSON_UNESCAPED_UNICODE);' PATH` 로 읽어 키 집합을 비교하고 제목·설명 문자 수를 출력. 실행 시점 출력:

```text
services-index en keys=99 title=49 description=139
services-index ja keys=99 title=39 description=78
performance-marketing en keys=124 title=52 description=131
performance-marketing ja keys=124 title=41 description=76
cpa-marketing en keys=144 title=44 description=148
cpa-marketing ja keys=144 title=35 description=59
reward-network en keys=279 title=48 description=149
reward-network ja keys=279 title=37 description=54
seo en keys=137 title=48 description=143
seo ja keys=137 title=39 description=83
wordpress en keys=137 title=54 description=140
wordpress ja keys=137 title=42 description=98
aeo en keys=122 title=48 description=152
aeo ja keys=122 title=31 description=66
geo en keys=128 title=48 description=148
geo ja keys=128 title=31 description=73
marketing-support en keys=135 title=50 description=142
marketing-support ja keys=135 title=42 description=67
Language parity: 9/9 files; no Hangul in EN or JA source
```

이후 키 추가·제거 없이 SEO·AEO·GEO 첫 언급에 용어집의 전체 명칭, NAVER Place·Shopping·Coupang·Kakao Gift 첫 언급에 플랫폼 설명을 보강했다. 메타 제목·설명은 변경하지 않았다.

### 구조·안전 점검 실제 출력

실행: Python 으로 한국어 원문의 Blade 주석을 제거하고 class·id 속성의 출현 순서 전체를 외국어 뷰와 비교. 모든 템플릿에 main·inLanguage·JSON_HEX_TAG 가 있는지, 한글과 일반 route() 가 없는지도 검사. 실제 출력(exit0):

```text
index: class/id order identical; no Hangul; intl_route only; JSON-LD protected
performance-marketing: class/id order identical; no Hangul; intl_route only; JSON-LD protected
cpa-marketing: class/id order identical; no Hangul; intl_route only; JSON-LD protected
reward-network: class/id order identical; no Hangul; intl_route only; JSON-LD protected
seo: class/id order identical; no Hangul; intl_route only; JSON-LD protected
wordpress: class/id order identical; no Hangul; intl_route only; JSON-LD protected
seo/aeo: class/id order identical; no Hangul; intl_route only; JSON-LD protected
seo/geo: class/id order identical; no Hangul; intl_route only; JSON-LD protected
marketing-support: class/id order identical; no Hangul; intl_route only; JSON-LD protected
Structure/safety checks: 9/9
```

### 문법·Pint 명령 및 실제 출력

실행: Python 래퍼에서 담당 뷰9개·언어18개 각각 `php -l PATH`. 오류가 있으면 stdout/stderr 를 출력하도록 실행.
```text
PHP syntax: checked 27 files
```

첫 Pint 는 18언어 파일의 EOF 공백 줄에 single_blank_line_at_eof 오류가 났다. apply_patch 로 EOF 공백과 기존 HTML 엔티티를 정리하고 재실행했다.

최종 명령:
```sh
./vendor/bin/pint --test lang/en/pages/services-index.php lang/ja/pages/services-index.php lang/en/pages/performance-marketing.php lang/ja/pages/performance-marketing.php lang/en/pages/cpa-marketing.php lang/ja/pages/cpa-marketing.php lang/en/pages/reward-network.php lang/ja/pages/reward-network.php lang/en/pages/seo.php lang/ja/pages/seo.php lang/en/pages/wordpress.php lang/ja/pages/wordpress.php lang/en/pages/aeo.php lang/ja/pages/aeo.php lang/en/pages/geo.php lang/ja/pages/geo.php lang/en/pages/marketing-support.php lang/ja/pages/marketing-support.php
```

실제 출력(exit0):
```json
{"tool":"pint","result":"passed"}
```

### 무력화 실험·통합 검증 경계

- 이 분업에서는 backend/test 를 소유하지 않아 무력화 실험과 전체 php artisan test 는 실행하지 않았다. 메인 구현자가 통합 테스트·키삭제·한글삽입·뷰존재 판정 무력화 실험의 실제 출력을 최종 반환물에 기록한다.
- 부모 구현자로부터 IntlPagesTest 7/7·13,843 assertions, IntlFoundationTest 16/16 통과를 전달받았다. 이것은 부모가 실행한 통합 증거이며 이 분업의 독립 실행 결과로 표기하지 않는다.
- 실제 브라우저 화면의 줄바꿈·일본어 길이에 따른 레이아웃 검수는 미실시.
- “earn-while-you-use”, 투자·보험 리드 관련 규제 표현, ポイ活 등에 대한 최종 일본어 카피 판단은 Claude 검수에 남긴다. 근거 없는 새 실적이나 추천·순위·고정물량·수익·지원금 보장을 추가하지 않았다.


## INTL-02 솔루션·셀프마케팅 구현 분업 반환

### 소유 변경 파일

아래 8개 뷰와 각 이름의 `lang/en/pages/*.php`, `lang/ja/pages/*.php` 16개, 합계 24개를 새로 만들었다.

| 뷰 | 언어 파일 이름 |
|---|---|
| `resources/views/intl/solutions/index.blade.php` | `solutions-index.php` |
| `resources/views/intl/solutions/rankfree.blade.php` | `rankfree.php` |
| `resources/views/intl/solutions/boostingshop.blade.php` | `boostingshop.php` |
| `resources/views/intl/solutions/shopitrend.blade.php` | `shopitrend.php` |
| `resources/views/intl/solutions/leadbay.blade.php` | `leadbay.php` |
| `resources/views/intl/solutions/call2sale.blade.php` | `call2sale.php` |
| `resources/views/intl/pages/self-marketing.blade.php` | `self-marketing.php` |
| `resources/views/intl/pages/self-marketing-place.blade.php` | `self-marketing-place.php` |

한국어 원문의 레이아웃 종류, 마크업, 클래스, 섹션·제목 ID와 순서를 복제하고 문구를 언어 파일로 분리했다. 8개 페이지의 section/heading ID 순서 대조는 모두 일치했다. 새 언어 파일은 영·일 같은 키 구조이다. 출력은 `{{ $t(...) }}`로 이스케이프한다. 성과 카운트 효과를 추가하지 않았다. 솔루션 원문에는 JSON-LD가 없었다.

### 페이지별 제외·수정한 문장과 링크

| 페이지 | 제외·조정한 문장 | 링크 |
|---|---|---|
| solutions.index | 「셀프마케팅 주문」「제이커브 사이트에서 랭크프리 계정을 연결해 순위상승 캠페인을 바로 주문합니다.」「주문 시작하기」를 소개·문의판임을 명시하는 문구로 조정 | 원문의 `route(...)` 전체를 `intl_route(...)`로. 셀프마케팅 카드는 허용된 소개 라우트 유지 |
| rankfree | 제외 문장 없음. 자체 추정·비공식 지표·순위 보장 불가 고지를 전부 유지 | 내부 링크는 해당 언어 경로. `https://rankfree.kr` 유지 |
| boostingshop | 제외 문장 없음. 인위적 반응 판매가 아닌 가이드, 정책·보안·환불 조건 및 성과 비보장 설명 유지 | 6개 상품/가이드 링크와 문의를 `intl_route`로. `https://boostings.shop` 유지 |
| shopitrend | 제외 문장 없음. 기능·가격·적립금의 최신 조건 및 비보장 고지 유지 | 내부 링크 `intl_route`, `https://shopitrend.co` 유지 |
| leadbay | 제외 문장 없음. 품질 스코어 비보장 및 거래당사자 개인정보 책임 고지 유지 | 내부 링크 `intl_route`, `https://leadbay.co.kr` 유지 |
| call2sale | 제외 문장 없음. AI 분석 한계·원자료 사람 검토 및 개인정보 처리 책임 고지 유지 | 내부 링크 `intl_route`, `https://call2.sale` 유지 |
| self-marketing | 「이 사이트에서 바로 주문합니다」 및 「로그인해 주문」「마이페이지에서 확인」은 한국어 서비스의 기능 소개로 한정하고 이 언어판은 문의로 안내. 동적 상품 목록과 로그인·계정 연결 블록 전체를 소개·문의 안내로 대체. 제거한 계정 안내: 「랭크프리 계정이 연결되어 있습니다. 주문 가능한 캠페인이 열리면 이 자리에 바로 표시됩니다.」「다음 단계: 랭크프리 계정 연결」「마이페이지에서 랭크프리 API 키를 등록하면 주문할 수 있습니다.」「로그인하고 주문을 시작하세요.」「랭크프리 계정이 없다면 랭크프리에서 먼저 가입할 수 있습니다.」. 무료 진단 CTA도 진단 문의로 조정 | `/self-marketing/order` 및 type=place/shopping → `intl_route('contact', ['service_interest'=>'boostingshop'])`. `seo.check` → service_interest=seo 문의. 로그인·회원가입·dashboard·상품주문 링크 제거. 한국어 순위폼 include → 실제 외부 RankFree 링크. 나머지 내부 링크 `intl_route` |
| self-marketing-place | 카카오 버튼 2개 제거. 「막히면 카카오로 바로 물어보세요」 → 문의 안내. 「오늘 등록하면 내일부터」「1분 등록」「24시간 주문」은 한국어 서비스 기능 설명임을 명시하고 이 언어판 CTA는 문의. 실제 외국어 사례 데이터 계약이 없으므로 고객/로컬 견본 조건부 사례는 연결하지 않고 기록 방식 안내만 제공 | 주문 URL → service_interest=boostingshop 문의. FAQ와 소개 링크 `intl_route`. 카카오 URL 참조 제거 |

`self-marketing-place`의 파트너 띠는 제거하지 않았다. 한국어 partial의 구조·38개 이미지·원래 순서를 소유 뷰 안에 그대로 복제하고 제목, 접근성 문구, alt, 앱 이름, 2026년 10월 기준 고지를 언어 파일로 치환했다. 한국어 partial과 다른 공용 파일은 수정하지 않았다.

### 페이지별 숫자 대조

CSS·SVG 좌표·이미지 크기·HTML ID의 숫자는 실적/가격이 아니므로 아래 표는 사람이 읽는 수치만 기록한다.

| 페이지 | 한국어 원문 | 영어 표기 | 일본어 표기 |
|---|---|---|---|
| solutions.index | 네 개 / 4개 제품·솔루션 | four core / 4 products / 4 solutions | 四つ / 4製品 |
| rankfree | 30초 | 30 seconds | 30秒 |
| rankfree | 1,200+ 사장님 | 1,200+ business owners | 1,200人以上の事業者 |
| rankfree | 6개월 | 6-month | 6か月 |
| rankfree | 무료 0원 | Free: KRW 0 | 無料：0ウォン |
| rankfree | 순위체크 100개·분석 월 5회 | 100 ranking checks · 5 analyses/month | 順位確認100件・分析月5回 |
| rankfree | 프로 29,000원/월 | Pro: KRW 29,000/month | プロ：月29,000ウォン |
| rankfree | N1·N2·N3 | N1/N2/N3 | N1・N2・N3 |
| boostingshop | 월 50만원부터 (2곳) | from KRW 500,000/month | 月50万ウォンから |
| boostingshop | 인스타그램 세 페이지 | three Instagram pages | Instagramの3ページ |
| boostingshop | 다섯 가지 확인 | five points | 五つ |
| shopitrend | 원문에 독립적인 성과·가격 수치 없음 | 신규 수치 없음 | 신규 수치 없음 |
| leadbay | 원문에 독립적인 성과·가격 수치 없음 | 신규 수치 없음 | 신규 수치 없음 |
| call2sale | 원문에 독립적인 성과·가격 수치 없음 | 신규 수치 없음 | 신규 수치 없음 |
| self-marketing | 30초 | 30 sec | 30秒 |
| self-marketing | 0원 (2곳) | KRW 0 | 0ウォン |
| self-marketing | 1,200+ | 1,200+ | 1,200+ |
| self-marketing | 100개, 월 5회 (본문·FAQ) | 100 checks, 5/month | 100件、月5回 |
| self-marketing | 6개월 | 6-month | 6か月 |
| self-marketing | 베이직 월 50만원부터 | Basic from KRW 500,000/month | ベーシック月50万ウォンから |
| self-marketing | 주문 네 단계 / 1·2·3·4 | four-step / 1·2·3·4 | 4段階 / 1·2·3·4 |
| self-marketing | 재고·집행·결과 3단계 | 1·2·3 | 1·2·3 |
| self-marketing | 29,000원/월 | KRW 29,000 /month | 29,000ウォン /月 |
| self-marketing-place | 처음이어도 1분 | Korean service offers 1-minute registration | 韓国語サービスでは1分 |
| self-marketing-place | 메인 키워드 하나·1개 | one / 1 main keyword | 一つ / 1件 |
| self-marketing-place | 일 목표 100명 (정적 예시) | 100 people | 100人 |
| self-marketing-place | 10일·20일·30일 | 10 days·20 days·30 days | 10日·20日·30日 |
| self-marketing-place | 리워드 앱 12종 | 12 reward apps | 12種類 |
| self-marketing-place | 24시간 주문 | 24-hour ordering in Korean | 韓国語サービスで24時間注文 |
| self-marketing-place | 제휴 26개·자체 12개 | 26 partner apps, 12 own apps | 提携26種類・自社12種類 |
| self-marketing-place | 2026년 10월 기준 | As of October 2026 | 2026年10月時点 |
| self-marketing-place | FAQ 무료 100개·월 5회 | 100 checks / 5 analyses per month | 100件 / 月5回 |
| self-marketing-place | 로컬 견본 37→1 / 81→2 / 24→1 | 견본 사례 블록 제거. 실적처럼 번역하여 노출하지 않음 | 동일 |

가격을 달러·엔으로 환산하지 않았다. 숫자 값과 제한·기준 라벨을 유지했다.

### 실행 명령과 실제 출력

작업 폴더: `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`.

```sh
./vendor/bin/pint --test lang/en/pages/solutions-index.php lang/en/pages/rankfree.php lang/en/pages/boostingshop.php lang/en/pages/shopitrend.php lang/en/pages/leadbay.php lang/en/pages/call2sale.php lang/en/pages/self-marketing.php lang/en/pages/self-marketing-place.php lang/ja/pages/solutions-index.php lang/ja/pages/rankfree.php lang/ja/pages/boostingshop.php lang/ja/pages/shopitrend.php lang/ja/pages/leadbay.php lang/ja/pages/call2sale.php lang/ja/pages/self-marketing.php lang/ja/pages/self-marketing-place.php
```

최종 출력(exit 0):

```text
{"tool":"pint","result":"passed"}
```

첫 실행에서는 `self-marketing-place.php` EN/JA의 nested array_indentation이 지적되었다. 배열 들여쓰기를 수정한 뒤 위 최종 실행이 통과했다.

```sh
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= APP_URL=https://j-curve.co.kr DB_CONNECTION=sqlite DB_DATABASE=:memory: SESSION_DRIVER=array CACHE_STORE=array GTM_ID= php /tmp/intl02-solutions-smoke.php
```

실제 출력(exit 0):

```text
Rendered views: 16
Korean text / translation-key failures: 0
```

이 스모크는 Laravel 콘솔을 부팅한 뒤 실제 라우트·locale을 설정하고 담당 8뷰×2언어를 레이아웃 포함 렌더했다. script/style을 제외한 렌더 텍스트에서 한글과 `pages/`·`menu.`·`subpages.` 노출을 확인했다. 실제 DB 읽기/마이그레이션은 하지 않았으며 메모리 SQLite 환경을 명령 하나에만 붙였다. PHP 원문 16파일을 각각 `php -l`로 검사했고 모두 성공했다. 읽기 전용 Python 비교에서 다음 출력이 나왔다.

```text
Section/heading ID order: 8/8 matched
PHP syntax: 16/16 passed
```

메타 길이 검사: EN title >60, 양 언어 description >155 조건으로 출력하는 `php -r` 검사 결과 출력 없음(exit 0).

### Claude 검수용 표현 및 미검증

- 용어집에 공식 로마자명이 없는 앱 `Kkulkkul Cash`, `Kkuk Tech`, `Cash Pangpang`, `Young Tech`, `Pocket Money Capsule`, `Potato Farm`, `Egg Money`, `Jelly Fairy Raising`는 원문을 식별할 수 있는 로마자/영문 뜻으로 적었다. 공식 외국어 브랜드명이 따로 있으면 최종 카피 검수에서 맞춰야 한다.
- Ohouse는 원문의 오늘의집을 지칭한다. 법률/보험의 GA는 영어에서 agency, 일본어에서 保険代理店로 풀었다.
- 가격·기간·무료 한도는 원문 보존이며 외부 RankFree/ShopiTrend 등 서비스의 최신 운영 조건을 별도 조사하지 않았다.
- 담당 뷰의 렌더·문법 증거만 반환한다. 독립 검증, 브라우저 시각 검수, 모든 링크 HTTP 상태, canonical/hreflang, 전체 `php artisan test`, build, 무력화 실험은 메인 구현 담당의 통합 실행 범위이다.
- 커밋·푸시·배포·한국어 원문·insights JSON·미디어·.env 파일을 수정하지 않았다. 다른 담당 변경을 되돌리지 않았다.

## INTL-02 서브페이지·FAQ·개인정보처리방침 분업 반환

### 소유 파일
- `resources/views/intl/pages/{subpage,faq,privacy}.blade.php`
- `lang/{en,ja}/subpages.php`
- `lang/{en,ja}/pages/{subpage,faq,privacy}.php`
- 총 11개. 한국어 원본·config·Claude 본보기·insights JSON 수정 없음.

### 번역 방법과 실제 보정
- 공개 정적 한국어 문구만 `translate.googleapis.com/translate_a/single`의 Google Translate에 전달해 영·일 초벌을 만들었다. 비밀·환경파일·고객 데이터는 전달하지 않았다.
- 용어집 회사명·플랫폼명·상품명과 숫자를 보호한 배치를 사용했다. 보호 토큰이 유실된 배치는 채택하지 않고 단일 문장으로 다시 번역했다. 최종 번역키/구조는 원문과 대조했다.
- 메타 제목·설명, CTA, 보험 누적 숫자·기준 라벨, 제3자 제공·동의·ROAS·허위리뷰 금지, 영어 FAQ 81문항 전체, 핵심 서브페이지 FAQ 13종은 수동 문구로 보정했다.
- 발견·수정한 오류: AS가 ROAS 내부까지 치환됨 → ROAS 복원. 제3자를 숫자3으로 오인 → third party/第三者. 허위리뷰 금지의 강도가 약해진 문장 → '제공하지 않음' 명시. 이탈구간/deviation, 지면/paper, 설계사/designer, 계약보장/coverage, 대행 범위/progress range 등 직역을 수정했다.

### 링크·삭제·마크업
- 19페이지 모두 한국어 subpage 마크업·클래스·섹션 순서를 유지. 상위서비스 breadcrumb와 문의 CTA는 `intl_route()` 사용. `service_interest`, 앵커 id, route/param/type/tone/href 등 기술값은 언어 배열에서 동일하다.
- 보험 페이지의 LeadBay/Call2Sale 카드 및 하단 링크 총4곳은 같은 외국어 소개 페이지로 연결한다.
- 서브페이지의 `partials.jc.wp-legacy` include 제거. 실제 기존 원문 블록이 붙는 대상은 backlinks, naver-place, naver-shopping, kakao-gift, coupang이다. 다른14페이지에도 외국어판은 이 include를 두지 않는다. 한국어 전용 문장을 그 밖에 삭제하지 않았다.
- FAQ81개 모두 유지. 관련 페이지81링크는 같은 route+params를 `intl_route()`로 생성. 문의게시판 진입은 외국어 문의로 대체. 전화·이메일은 원문 그대로.
- 공용 FAQ JS가 검색/분야 선택 후 한글 건수를 넣는 현상을 발견. 공용 JS를 건드리지 않고 외국어 FAQ 템플릿의 count MutationObserver가 같은 숫자를 번역된 questions/results 단위로 표기하도록 국소 처리했다.
- FAQ와 subpage JSON-LD에 `inLanguage`, `JSON_HEX_TAG` 등을 적용. 번역문 직접 raw HTML 출력 없음(안전한 JSON 직렬화만 raw 출력).
- 개인정보처리방침4개 조항·도입·마무리 유지. 맨 위에 번역은 이해를 돕기 위한 것이고 한국어 원문이 우선한다는 안내를 추가했다.

### 실행 명령과 실제 출력

```sh
php -l lang/{en,ja}/subpages.php
php -l lang/{en,ja}/pages/{faq,privacy,subpage}.php
```

실제로는 PHP 루프로 파일8개를 순서대로 `php -l` 실행했다. 출력:

```text
No syntax errors detected in lang/en/subpages.php
No syntax errors detected in lang/ja/subpages.php
No syntax errors detected in lang/en/pages/faq.php
No syntax errors detected in lang/ja/pages/faq.php
No syntax errors detected in lang/en/pages/privacy.php
No syntax errors detected in lang/ja/pages/privacy.php
No syntax errors detected in lang/en/pages/subpage.php
No syntax errors detected in lang/ja/pages/subpage.php
```

`config/subpages.php`와 영·일 배열을 PHP로 재귀 평탄화한 대조 실제 출력:

```text
en schema: same
en technical-value differences: 0
en Korean/token remnants: 0
en FAQ items: 81
ja schema: same
ja technical-value differences: 0
ja Korean/token remnants: 0
ja FAQ items: 81
pages: 19
```

그 밖의 실제 대조 출력:

```text
EN/JA key equality: yes
Subpage leaves per locale: 1338
en FAQ: 81
ja FAQ: 81
```

서브페이지38개 번역의 meta_description 길이 >155 검사: 출력0건.

### 숫자 대조 (19페이지 각각)

`제3자`는 third party/第三者, `1차`는 initial/一次, `4가지`는 four/4つ, `2단계 인증`은 two-factor/二段階認証로 옮긴 언어 표현이다. 금액 환산을 하지 않았다. 회사누적373억+는 KRW37.3B+/373億ウォン+, 128만+는 1.28M+/128万件+, 15,700+는 15,700+/15,700件+로 옮겼다.

| 페이지 | 한국어 원문 | 영어 표기 | 일본어 표기 |
|---|---|---|---|
| seo/backlinks | meta_description: 10년간 1,000여 개의 SEO 프로젝트를 성공적으로 수행하며 얻은 검색엔진최적화에 대한 깊은 이해와 경험을 바탕으로 제공하는 전문 백링크 서비스로 검색엔진 상위노출을 경험하세요. 구글과 네이버에 최적화된 검증된 고품질 백링크 전략은 자연스러운 순위 상승을 돕습니다. 무료 컨설팅을 신청하세요.<br>faq.2.answer: 검색엔진의 판단을 제3자가 보장할 수는 없습니다. 제이커브는 과도한 반복과 비정상 패턴을 피하고, 확인 가능한 범위와 위험 요소를 사전에 설명합니다. | meta_description: Backlink strategy informed by 10 years and over 1,000 SEO projects, with page, source and anchor reviews for Google and NAVER. Ask for a free consultation.<br>faq.2.answer: No third party can guarantee a search engine’s judgment. We avoid excessive repetition and abnormal patterns, and explain the scope we can verify and the risks in advance. | meta_description: 10年間・1,000件以上のSEOプロジェクトの経験を基に、Google・NAVER向けに対象ページ、出典とアンカーテキストを確認する被リンクサービスです。無料相談を受け付けています。<br>faq.2.answer: 検索エンジンの判断を第三者が保証することはできません。J-Curveは過度な繰り返しや不自然なパターンを避け、確認できる範囲とリスクを事前に説明します。 |
| seo/naver-place | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| seo/naver-shopping | meta_description: 네이버쇼핑 상위노출 마케팅을 위한 SEO는 제이커브에게 맡기세요! 10년 이상 풍부한 노하우로 상품 노출 극대화, 클릭률 향상, 매출 증대를 실현시켜 드립니다. | meta_description: NAVER Shopping SEO informed by over 10 years of experience, covering product data, images and pages to improve discovery and purchase decisions. | meta_description: 10年以上の経験を基に、NAVERショッピングの商品情報、画像と詳細ページを整え、検索・クリック・購入判断につなげます。 |
| seo/kakao-gift | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| seo/coupang | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| cpa/real-estate | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| cpa/stock | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| cpa/insurance | sections.1.items.0.title: 373억+<br>sections.1.items.0.text: 2026년 기준 · 제이커브 회사 전체 누적 집행 광고비<br>sections.1.items.1.title: 128만+<br>sections.1.items.1.text: 2026년 기준 · 제이커브 회사 전체 누적 수집 DB<br>sections.1.items.2.title: 15,700+<br>sections.1.items.2.text: 2026년 기준 · 제이커브 회사 전체 누적 진행 캠페인<br>sections.1.items.3.title: 2009년<br>sections.3.paragraphs.1: 보험 퍼미션 DB에서는 광고·랜딩에서 받은 1차 신청을 그대로 넘기지 않고, 캠페인 구조에 따라 연락 주체와 상담 목적, 제3자 제공 또는 처리위탁 관계, 핵심 상담 의사를 다시 확인하는 과정이 붙을 수 있습니다.<br>sections.5.items.1.title: 1차 신청과 동의 기록<br>sections.6.title: 기존 보험 랜딩의 4가지 원칙을 운영 기준으로 다시 씁니다<br>sections.6.items.0.title: 01. 전달 시점 관리<br>sections.6.items.1.title: 02. 동의·녹취 증빙<br>sections.6.items.2.title: 03. 중복·독점 기준<br>sections.6.items.3.title: 04. 조직별 맞춤 스크립트<br>sections.14.items.2: 수집 항목, 제3자 제공받는 자, 목적, 보유·이용 기간과 동의 거부·철회 방법 확인<br>faq.4.answer: 그렇지 않습니다. 동의 문구, 제공받는 자, 목적, 항목과 보유기간이 실제 전달·연락 구조와 맞아야 합니다. 제3자 제공인지 처리위탁인지도 실제 역할과 관계를 기준으로 확인해야 합니다. | sections.1.items.0.title: KRW 37.3B+<br>sections.1.items.0.text: As of 2026 · cumulative ad spend managed, company-wide<br>sections.1.items.1.title: 1.28M+<br>sections.1.items.1.text: As of 2026 · cumulative leads collected, company-wide<br>sections.1.items.2.title: 15,700+<br>sections.1.items.2.text: As of 2026 · cumulative campaigns run, company-wide<br>sections.1.items.3.title: 2009<br>sections.3.paragraphs.1: Insurance consent-based leads may include an additional step after the initial ad or landing-page application. Depending on the campaign, we reconfirm who will contact the customer, the consultation purpose, third-party disclosure or processing arrangements, and the customer’s intent.<br>sections.5.items.1.title: Initial application and consent records<br>sections.6.title: Four principles from the original insurance page, restated as operating standards<br>sections.6.items.0.title: 01. Manage lead handoff timing<br>sections.6.items.1.title: 02. Consent and call-recording evidence<br>sections.6.items.2.title: 03. Duplicate and exclusivity criteria<br>sections.6.items.3.title: 04. Custom scripts for each organization<br>sections.14.items.2: Confirm collected fields, third-party recipients, purposes, retention and use periods, and ways to refuse or withdraw consent.<br>faq.4.answer: No. Consent wording, recipients, purposes, fields and retention must match the actual transfer and contact flow. Third-party disclosure or outsourced-processing arrangements must reflect actual roles and relationships. | sections.1.items.0.title: 373億ウォン+<br>sections.1.items.0.text: 2026年時点 · J-Curve会社全体の累計広告運用額<br>sections.1.items.1.title: 128万件+<br>sections.1.items.1.text: 2026年時点 · J-Curve会社全体の累計リード獲得数<br>sections.1.items.2.title: 15,700件+<br>sections.1.items.2.text: 2026年時点 · J-Curve会社全体の累計キャンペーン実施数<br>sections.1.items.3.title: 2009年<br>sections.3.paragraphs.1: 保険の同意取得済みリードでは、広告・ランディングページからの一次申込をそのまま渡すのではなく、キャンペーンに応じて連絡主体、相談目的、第三者提供・取扱委託の関係と相談意思を再確認する場合があります。<br>sections.5.items.1.title: 一次申込と同意記録<br>sections.6.title: 従来の保険ページの4つの原則を運用基準として整理します<br>sections.6.items.0.title: 01. リード提供時点の管理<br>sections.6.items.1.title: 02. 同意・録音証明<br>sections.6.items.2.title: 03. 重複・独占の基準<br>sections.6.items.3.title: 04. 組織別のカスタムスクリプト<br>sections.14.items.2: 収集項目、第三者提供の相手、目的、保有・利用期間、同意の拒否・撤回方法を確認します。<br>faq.4.answer: いいえ。同意文、提供先、目的、項目と保有期間が、実際の提供・連絡の流れに合っている必要があります。第三者提供か取扱委託かも、実際の役割と関係を基に確認します。 |
| cpa/coin | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| cpa/permission-call | sections.2.items.1: 제3자 제공 또는 위탁 여부와 고객에게 보이는 설명 | sections.2.items.1: Third-party disclosure or outsourced processing, and the explanation shown to customers | sections.2.items.1: 第三者提供・取扱委託の有無と顧客に示す説明 |
| performance/naver-gfa | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| performance/facebook | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| performance/youtube | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| boostingshop/basic | faq.0.question: 베이직을 하면 검색 1위를 보장하나요? | faq.0.question: Does Basic guarantee a number 1 search ranking? | faq.0.question: Basicでは検索1位を保証しますか？ |
| boostingshop/pro | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| boostingshop/elite | 원문 숫자 없음 | 원문 숫자 없음 | 원문 숫자 없음 |
| boostingshop/instagram-popular | sections.2.note: 인기게시물 진입, 노출 위치와 유지 기간은 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | sections.2.note: Entry into popular posts, placement and duration are not guaranteed. Do not give an external provider your account password or two-factor authentication codes. | sections.2.note: 人気投稿への掲載、表示位置と維持期間は保証しません。アカウントのパスワードや二段階認証コードを外部業者に渡す方法は利用しないでください。 |
| boostingshop/instagram-followers | sections.2.note: 팔로워 증가 자체는 도달·참여·구매를 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | sections.2.note: More followers do not guarantee reach, engagement or purchases. Do not give an external provider your account password or two-factor authentication codes. | sections.2.note: フォロワー増加だけでは、リーチ・参加・購入を保証しません。アカウントのパスワードや二段階認証コードを外部業者に渡す方法は利用しないでください。 |
| boostingshop/instagram-likes | sections.2.note: 좋아요 증가 자체는 인기게시물 노출, 저장·문의 또는 매출을 보장하지 않습니다. 계정 비밀번호나 2단계 인증 코드를 외부 공급자에게 넘기는 방식은 진행하지 마세요. | sections.2.note: More likes do not guarantee popular-post placement, saves, inquiries or revenue. Do not give an external provider your account password or two-factor authentication codes. | sections.2.note: いいねの増加だけでは、人気投稿への表示、保存・お問い合わせ・売上を保証しません。アカウントのパスワードや二段階認証コードを外部業者に渡す方法は利用しないでください。 |

FAQ 추가 숫자: 무료 순위체크100개→100 ranking checks/順位チェック100件, 분석 월5회→5 analyses per month/月5回, 이전301→301s/301リダイレクト, 1:1문의→1:1/1:1. 개인정보 조항1~4·전화02-1668-2612·이메일jcurve19@gmail.com 그대로.

### 미검증·검수 필요
- 한국 진출 외국기업 대상의 원어민/B2B 문장 전체 교열은 미실시. 나머지 섹션 문단은 기계번역 초벌이므로 Claude가 최종 카피를 검수해야 한다.
- 특히 permission lead, semi-silver/silver/confirmed lead 유형, insurance remodeling, AS(after-sales support), 원문에서 사용하는 Elite/Pro/Basic 상품 범위의 영·일 업계 관용 표현을 검수해야 한다. 새로운 실적·보장 약속은 추가하지 않았다.
- 실제 브라우저에서 FAQ 검색·분야 선택·건수 변경과 모바일 레이아웃은 별도 실행하지 않았다. 템플릿 국소 observer는 코드 확인만 했다.
- 전체 artisan test, Pint, build, 무력화 실험, 한국어 비교는 루트 세션이 통합 실행하며 이 분업 세션은 별도 최종 합격 판정을 내리지 않는다.

