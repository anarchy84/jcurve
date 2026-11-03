# VERIFY-URL-PRESERVE-01 독립 검증 결과

검증일: 2026-11-03 (KST). 검증자: Codex 독립 세션. 소스 구현·수정·커밋·푸시·배포는 하지 않았어. 무력화 실험은 원본과 코드가 같은 임시 복제본에서만 진행했고 전부 원복했어.

합격 기준: [SPEC-CODEX-URL-PRESERVE-01.md](/Users/anarchy/Claude_Projects/jcurve/docs/SPEC-CODEX-URL-PRESERVE-01.md). 수행 지시: [VERIFY-CODEX-URL-PRESERVE-01.md](/Users/anarchy/Claude_Projects/jcurve/docs/VERIFY-CODEX-URL-PRESERVE-01.md). 구현자 보고서는 합격 증거로 사용하지 않았어.

검사 범위는 **`git diff 3cbe3d8` 전체 32개 파일**이야. `9f1783e`, `658a0a9`와 검증 시작 중 확인된 자동 체크포인트 `8a140e7`까지 포함했어. 마지막 체크포인트의 변경은 요청 큐 2줄뿐이고, 내가 커밋 명령을 실행한 건 아니야.

## 시나리오별 판정

| 시나리오 | 판정 | 직접 확인한 결과 |
|---|---|---|
| S1 원주소 15개·canonical·og:url·title·h1 | **FAIL\*** | 일반 주소 12개 및 WP 3편의 소문자/대문자 hex 6건은 200·메타·본문 정상. curl에 비인코딩 한글 URL을 넣는 IRI 3건도 200. **요청줄에 원시 UTF-8 바이트를 넣은 3건은 PHP 내장 서버에서 응답 없이 연결 종료**. 엄격한 비인코딩 전송 조건은 미충족으로 남김. |
| S2 끝 슬래시 없는 P | **PASS** | 15/15, 쿼리 `utm_source=x&page=2` 그대로, 301 한 번 후 P=200. |
| S3 새 경로 N | **PASS** | 15/15, 같은 쿼리 보존, 301 한 번 후 P=200. |
| S4 레거시 전 행 체인 | **FAIL** | 301/302 대상 161행 중 160행 통과. **`/my-account → /profile → /login`** 한 건이 2홉. WP 글의 오래된 `seo/{slug}` 301 행은 0개. |
| S5 내부 링크 BFS·JSON-LD | **FAIL** | 홈부터 146페이지, 239개 요청, 큐 잔여 0. **19페이지에서 문제 링크 89건(404 87건·301 2건), 서로 다른 목적지 86개**. N 링크 0, JSON-LD 파싱 오류 0. 전 목록은 아래 표에 수록. |
| S6 문의 폼 | **PASS** | action=`/contact-us/`; 정상 저장·성공 문구, CSRF 누락 419, honeypot 저장 차단, 필수 이메일 누락 시 오류와 원주소 복귀, 정확히 6번째 429. POST 별칭도 301 없이 접수됨. |
| S7 사이트맵·RSS | **PASS** | 사이트맵 색인+하위 4개=200. 콘텐츠 loc 94/94=200, P 15개 포함·N 0개, 숨김 글 미포함. RSS WP 3편은 P. |
| S8 삭제 칼럼 410 | **PASS** | 30개 × 기본/순서 변경/대문자 키=90/90 모두 410·noindex·Location 없음. wr_id=1은 301, 999는 404, 미지정/빈 값은 301 `/blog/`. |
| S9 v1 랜딩 | **PASS** | 루트 PHP 랜딩에서 산출한 `/v1/X.php` 16/16, 정확히 301 한 번 후 200. gfa·youtube 포함. |
| S10 아나키 Q-026 | **PASS** | 강의 상세 302 `/blog/`, wr_id=51은 301 한 번 후 200. BFS·목록·사이트맵·RSS에 숨김 글 없음. 스마트스토어 2편은 지정 문장 56/55자만 제외, 원문 대비 99.208%/99.813% 유지·제목 유지. 크롤에서 “아나키” 노출 페이지 0개. 설정을 비우는 복구 기능도 테스트 통과. |
| S11 유지 대상 | **PASS** | 지정 서비스·인사이트 2편·다른 카테고리·work·self-marketing/order·shopitrend·basic·홈 11개 모두 200·자기 canonical. shop/portfolio 301 목적지 및 미등록 SEO 404 정상. |
| S12 열린 리다이렉트 | **PASS** | 지정 공격 5건 및 미매핑 경로 등 8건에서 외부 Location·프로토콜 상대 Location 없음. P 밖에 슬래시 301 강제 적용 없음. |
| S13 시더 멱등 | **PASS** | 191행의 **전 컬럼 내용**과 SHA-256이 재시딩 전후 동일. S4 재실행도 같은 161행·같은 실패 1건. S4 자체 실패는 그대로 별도 유지. |
| S14 호스트·서치콘솔·GTM | **PASS** | 실제 HTTP 8조합으로 jc/app 모두 확인. dev noindex·태그 없음; 공개+빈 ID는 소유 확인 1개·GTM 없음; 정상 ID는 head 스크립트 1개·body 첫 noscript iframe 1개; 악성 ID는 출력 없음. |
| S15 품질 게이트 | **PASS** | 전체 테스트 126/126, 19,540 assertions. 기준 커밋 이후 변경 PHP/Blade 27개 Pint 통과. npm 빌드 exit 0. hero-glow.webp 경고는 남아 있음. |
| T-A 주소 매핑 무력화 | **PASS** | 원주소 렌더 라우트와 N→P 매핑을 임시 중단하자 15/15 실패(404≠200). 원복 후 전체 126/126 재통과. |
| T-C 410 무력화 | **PASS** | 410을 404로 바꾸자 해당 테스트 실패(404≠410). 원복 후 전체 126/126 재통과. 파일 해시와 diff 해시 동일. |

\* S1은 **환경 제약을 포함한 미충족**이야. 비인코딩 한글 URL을 curl에 그대로 전달하는 일반적인 사용은 정상이야. 다만 curl이 URI로 정규화하지 않은 원시 UTF-8 요청줄은 지정된 `php artisan serve`의 HTTP 파서에서 차단됐어. 이걸 앱 코드의 새 결함으로 단정하지 않으며, “세 전송 형태 모두 실제 HTTP 200”을 확인했다고 주장하지 않아.

## 실행 환경과 준비 명령

모든 앱 실행은 아래 임시 복제본에서 했어. 원본 `.env`·실DB를 읽지 않았고, public host는 헤더와 curl 연결 대상 치환으로만 재현했어. 실제 연결은 127.0.0.1:8012뿐이야. 포트 8000에는 요청·종료·재시작을 하지 않았어.

- 원본: `/Users/anarchy/Claude_Projects/jcurve`
- 격리 앱: `/private/tmp/verify-url-preserve-01.uKzpTc/appcopy`
- 임시 SQLite: `/private/tmp/verify-url-preserve-01.uKzpTc/verify.sqlite`
- PHP 8.5.8 / Node v20.20.2
- 코드 대조: tracked PHP/JSON/XML 280개 검사, 복제된 파일의 불일치 0. 무력화 대상 3개는 아래 SHA로 추가 대조.
- 시더: `BoardSeeder`, `InsightCategorySeeder`, `LegacyRedirectSeeder`, `LegacyContentSeeder`. `WorkSeeder` 실행 안 함.
- 초기 건수: insights=53, works=0, legacy_redirects=191.

다음은 실제 사용한 환경값이야. APP_KEY는 이 검증용 고정 더미 값이야.

```sh
cd /private/tmp/verify-url-preserve-01.uKzpTc/appcopy
export APP_BASE_PATH='/private/tmp/verify-url-preserve-01.uKzpTc/appcopy'
export APP_ENV='local'
export APP_DEBUG='false'
export APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA='
export APP_URL='http://j-curve.co.kr'
export SEO_PUBLIC_URL='https://j-curve.co.kr'
export DB_CONNECTION='sqlite'
export DB_DATABASE='/private/tmp/verify-url-preserve-01.uKzpTc/verify.sqlite'
export DB_URL=''
export CACHE_STORE='database'
export SESSION_DRIVER='database'
export SESSION_SECURE_COOKIE='false'
export MAIL_MAILER='array'
export QUEUE_CONNECTION='sync'
export LOG_CHANNEL='stderr'
export GTM_ID=''
export RANKFREE_API_ENABLED='false'
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder --force
php artisan serve --host=127.0.0.1 --port=8012 --no-reload
```

별도 터미널에서도 위 export를 적용한 뒤 실행하면 돼.

```sh
python3 /private/tmp/verify-url-preserve-01.uKzpTc/http-verify.py S1 S23 S4 S5 S6 S7 S8 S9 S10 S11 S12 S13
```

실제 시더 출력: [setup.log](/private/tmp/verify-url-preserve-01.uKzpTc/setup.log). HTTP 전체 출력: [contracts-http.log](/private/tmp/verify-url-preserve-01.uKzpTc/contracts-http.log), [contact-http.log](/private/tmp/verify-url-preserve-01.uKzpTc/contact-http.log), [crawl-http.log](/private/tmp/verify-url-preserve-01.uKzpTc/crawl-http.log). 위 스크립트의 S1 `raw_utf8` 라벨은 **curl에 전달한 한글 URL 입력**이야. 원시 요청줄 실험은 별도 파일로 구분했어.

## 실패 재현과 원인 위치

### S1: 원시 UTF-8 요청줄 — 환경에서 연결 종료

8012가 비어 있을 때 실행하면 자체적으로 임시 서버를 시작하고 끝에 종료해. 앱 소스는 바꾸지 않아.

```sh
env APP_BASE_PATH='/private/tmp/verify-url-preserve-01.uKzpTc/appcopy' APP_ENV='local' APP_DEBUG='false' APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=' APP_URL='http://j-curve.co.kr' SEO_PUBLIC_URL='https://j-curve.co.kr' DB_CONNECTION='sqlite' DB_DATABASE='/private/tmp/verify-url-preserve-01.uKzpTc/verify.sqlite' DB_URL='' CACHE_STORE='database' SESSION_DRIVER='database' SESSION_SECURE_COOKIE='false' MAIL_MAILER='array' QUEUE_CONNECTION='sync' LOG_CHANNEL='stderr' GTM_ID='' RANKFREE_API_ENABLED='false' python3 /private/tmp/verify-url-preserve-01.uKzpTc/http-tags.py RAW
```

실제 출력 발췌:

```text
S1_RAW_HTTP {"path": "/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/", "status": "NO_HTTP_RESPONSE", "exception": "RemoteDisconnected", "message": "Remote end closed connection without response", "ok": false}
S1_RAW_HTTP {"path": "/seo/11가지-최고의-seo-실수와-이를-피하는-방법/", "status": "NO_HTTP_RESPONSE", "exception": "RemoteDisconnected", "message": "Remote end closed connection without response", "ok": false}
S1_RAW_HTTP {"path": "/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/", "status": "NO_HTTP_RESPONSE", "exception": "RemoteDisconnected", "message": "Remote end closed connection without response", "ok": false}
```

별도 대조에서 같은 한글 URL을 curl 인자로 그대로 전달하면 3건 모두 200이고 canonical·og:url도 P였어. 서버 로그에는 원시 바이트 실험 때 `Invalid request (Malformed HTTP request)`가 찍혔어. Laravel 라우팅 이전의 PHP 내장 HTTP 파서 단계이므로 특정 앱 소스 줄을 원인으로 지목하지 않아. 전체 출력: [raw-unicode-http.log](/private/tmp/verify-url-preserve-01.uKzpTc/raw-unicode-http.log).

### S4: 비로그인 my-account 체인

원인 위치:

- [LegacyRedirectSeeder.php:36](/Users/anarchy/Claude_Projects/jcurve/database/seeders/LegacyRedirectSeeder.php:36): `my-account => /profile`.
- [routes/web.php:99](/Users/anarchy/Claude_Projects/jcurve/routes/web.php:99): `/profile`은 auth 그룹 안에 있어 비로그인 요청이 login으로 302 이동.
- **기준 커밋에도 같은 매핑이 있었어. 신규 회귀로 단정하지 않지만, VERIFY의 “전 행 1홉 뒤 200” 기준에는 실패야.** 인증을 완화하거나 기존 주소의 의미를 임의로 바꾸지 않았어.

### S5: 표시 본문 안의 옛 링크

원인 위치:

- [LegacyContentSeeder.php:68](/Users/anarchy/Claude_Projects/jcurve/database/seeders/LegacyContentSeeder.php:68), [LegacyContentSeeder.php:117](/Users/anarchy/Claude_Projects/jcurve/database/seeders/LegacyContentSeeder.php:117): 이관 HTML을 content로 저장.
- [insights/show.blade.php:62](/Users/anarchy/Claude_Projects/jcurve/resources/views/insights/show.blade.php:62): content HTML을 그대로 렌더.
- 보존 원문 안에 author/tag/view_image.php/instagram.php 링크가 남아 있어. 데이터 원본 파일은 변경 금지 구역이라 수정하지 않았어.
- 대표 원문 2개는 `git show 3cbe3d8:<파일>`과 현재 파일이 바이트 단위로 같고, 기준 커밋에도 해당 href가 있었음을 확인했어. 이번 구현이 새로 만든 href라는 주장은 하지 않아.

S4·S5 대표 재현은 8012가 비어 있을 때 다음 한 명령으로 실행돼. 서버 시작·HTTP 요청·정리까지 수행해.

```sh
env APP_BASE_PATH='/private/tmp/verify-url-preserve-01.uKzpTc/appcopy' APP_ENV='local' APP_DEBUG='false' APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=' APP_URL='http://j-curve.co.kr' SEO_PUBLIC_URL='https://j-curve.co.kr' DB_CONNECTION='sqlite' DB_DATABASE='/private/tmp/verify-url-preserve-01.uKzpTc/verify.sqlite' DB_URL='' CACHE_STORE='database' SESSION_DRIVER='database' SESSION_SECURE_COOKIE='false' MAIL_MAILER='array' QUEUE_CONNECTION='sync' LOG_CHANNEL='stderr' GTM_ID='' RANKFREE_API_ENABLED='false' python3 /private/tmp/verify-url-preserve-01.uKzpTc/http-tags.py REPRO
```

실제 출력:

```text
REPRO_HTTP {"path": "/my-account", "status": 301, "Location": "http://j-curve.co.kr/profile"}
REPRO_HTTP {"path": "/profile", "status": 302, "Location": "http://j-curve.co.kr/login"}
REPRO_HTTP {"path": "/login", "status": 200, "Location": null}
REPRO_HTTP {"path": "/author/jcurve/", "status": 404, "Location": null}
REPRO_HTTP {"path": "/tag/seo/", "status": 404, "Location": null}
REPRO_HTTP {"path": "/instagram.php", "status": 301, "Location": "http://j-curve.co.kr/solutions/boostingshop/instagram-popular"}
REPRO_HTTP {"path": "/v1/manager/bbs/view_image.php?fn=https%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2212%2F0141e988a4fa0caf496a6a1574030e1b_1671608774_2059.png", "status": 404, "Location": null}
REPRO_SOURCE {"path": "/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/", "href": "https://j-curve.co.kr/author/jcurve/", "rendered": 1}
REPRO_SOURCE {"path": "/insights/인스타그램-인기게시물-노출을-위한-알고리즘-이해", "href": "https://j-curve.co.kr/instagram.php", "rendered": 2}
```

S5의 문제 링크 89건은 모두 아래에 적었어. HTML 안 같은 링크의 중복 등장도 별도 건수로 유지했어.

| # | 출발 페이지 | 실제 href | HTTP | Location |
|---|---|---|---|---|
| 1 | `/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/` | `https://j-curve.co.kr/author/jcurve/` | 404 | — |
| 2 | `/seo/11가지-최고의-seo-실수와-이를-피하는-방법/` | `https://j-curve.co.kr/author/jcurve/` | 404 | — |
| 3 | `/seo/11가지-최고의-seo-실수와-이를-피하는-방법/` | `https://j-curve.co.kr/tag/seo-%eb%85%b8%ed%95%98%ec%9a%b0/` | 404 | — |
| 4 | `/seo/11가지-최고의-seo-실수와-이를-피하는-방법/` | `https://j-curve.co.kr/tag/seo-%ec%8b%a4%ec%88%98/` | 404 | — |
| 5 | `/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/` | `https://j-curve.co.kr/author/jcurve/` | 404 | — |
| 6 | `/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/` | `https://j-curve.co.kr/tag/seo/` | 404 | — |
| 7 | `/insights/인스타그램-인기게시물-노출을-위한-알고리즘-이해` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=https%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2212%2F0141e988a4fa0caf496a6a1574030e1b_1671608774_2059.png` | 404 | — |
| 8 | `/insights/인스타그램-인기게시물-노출을-위한-알고리즘-이해` | `https://j-curve.co.kr/instagram.php` | 301 | `http://j-curve.co.kr/solutions/boostingshop/instagram-popular` |
| 9 | `/insights/인스타그램-인기게시물-노출을-위한-알고리즘-이해` | `https://j-curve.co.kr/instagram.php` | 301 | `http://j-curve.co.kr/solutions/boostingshop/instagram-popular` |
| 10 | `/insights/마케팅-퍼널이란-무엇인가-1` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2104%2F0498c989a38589c856a132731de51ca9_1619764356_8222.jpg` | 404 | — |
| 11 | `/insights/스마트스토어-내게-맞는-키워드-발굴하는-법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2007%2Ff45c90162b4f82cdbe0e8ca13ca6e073_1593677114_532.png` | 404 | — |
| 12 | `/insights/스마트스토어-내게-맞는-키워드-발굴하는-법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2007%2Ff45c90162b4f82cdbe0e8ca13ca6e073_1593677046_5062.png` | 404 | — |
| 13 | `/insights/스마트스토어-내게-맞는-키워드-발굴하는-법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2007%2Ff45c90162b4f82cdbe0e8ca13ca6e073_1593677074_4676.png` | 404 | — |
| 14 | `/insights/페이스북-광고-목적에-최적화된-유형-선택이-중요` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577690844_5769.jpg` | 404 | — |
| 15 | `/insights/페이스북-광고-목적에-최적화된-유형-선택이-중요` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691084_7782.png` | 404 | — |
| 16 | `/insights/페이스북-광고-목적에-최적화된-유형-선택이-중요` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691216_4939.gif` | 404 | — |
| 17 | `/insights/페이스북-광고-목적에-최적화된-유형-선택이-중요` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691241_3091.png` | 404 | — |
| 18 | `/insights/페이스북-광고-목적에-최적화된-유형-선택이-중요` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691262_5269.png` | 404 | — |
| 19 | `/insights/페이스북-광고-목적에-최적화된-유형-선택이-중요` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691422_0544.png` | 404 | — |
| 20 | `/insights/페이스북-광고-목적에-최적화된-유형-선택이-중요` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691466_2048.png` | 404 | — |
| 21 | `/insights/페이스북-광고-목적에-최적화된-유형-선택이-중요` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691598_7204.png` | 404 | — |
| 22 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430169_667.png` | 404 | — |
| 23 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430276_9708.png` | 404 | — |
| 24 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430292_3382.png` | 404 | — |
| 25 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430303_6457.png` | 404 | — |
| 26 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430316_5152.png` | 404 | — |
| 27 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430334_828.png` | 404 | — |
| 28 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430342_4196.png` | 404 | — |
| 29 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430353_5754.png` | 404 | — |
| 30 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430362_0196.png` | 404 | — |
| 31 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430373_9152.png` | 404 | — |
| 32 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430388_7864.png` | 404 | — |
| 33 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430422_2036.png` | 404 | — |
| 34 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430437_6752.png` | 404 | — |
| 35 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430474_85.png` | 404 | — |
| 36 | `/insights/인스타그램-광고-실행-및-관리-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430483_7292.png` | 404 | — |
| 37 | `/insights/인스타그램-마케팅에-대한-뜬소문들` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Fdef627a9e530444835cd1befa5db2892_1577175639_3227.png` | 404 | — |
| 38 | `/insights/인스타그램-마케팅에-대한-뜬소문들` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Fdef627a9e530444835cd1befa5db2892_1577175664_7346.jpg` | 404 | — |
| 39 | `/insights/인스타그램-마케팅에-대한-뜬소문들` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Fdef627a9e530444835cd1befa5db2892_1577175787_9403.jpg` | 404 | — |
| 40 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071298_1388.jpg` | 404 | — |
| 41 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071325_5874.png` | 404 | — |
| 42 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071380_2849.png` | 404 | — |
| 43 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071403_1084.png` | 404 | — |
| 44 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071425_2444.png` | 404 | — |
| 45 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071450_443.png` | 404 | — |
| 46 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071567_5384.png` | 404 | — |
| 47 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071607_0172.jpg` | 404 | — |
| 48 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071628_6036.png` | 404 | — |
| 49 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071662_1346.png` | 404 | — |
| 50 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071716_2513.png` | 404 | — |
| 51 | `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071717_8462.png` | 404 | — |
| 52 | `/insights/페이스북-광고-테스트가-꼭-필요한-이유` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9fba2d647a508eebd0a494b417d8575f_1576810661_58.png` | 404 | — |
| 53 | `/insights/페이스북-광고-테스트가-꼭-필요한-이유` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9fba2d647a508eebd0a494b417d8575f_1576810669_7706.jpg` | 404 | — |
| 54 | `/insights/페이스북-광고-테스트가-꼭-필요한-이유` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9fba2d647a508eebd0a494b417d8575f_1576810681_4632.jpg` | 404 | — |
| 55 | `/insights/페이스북-광고-테스트가-꼭-필요한-이유` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9fba2d647a508eebd0a494b417d8575f_1576810703_4147.jpg` | 404 | — |
| 56 | `/insights/구글애널리틱스를-통한-구매-및-전환-추적` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576722956_8352.jpg` | 404 | — |
| 57 | `/insights/구글애널리틱스를-통한-구매-및-전환-추적` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576722970_9683.png` | 404 | — |
| 58 | `/insights/구글애널리틱스를-통한-구매-및-전환-추적` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576723007_2782.png` | 404 | — |
| 59 | `/insights/구글애널리틱스를-통한-구매-및-전환-추적` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576723033_1303.jpg` | 404 | — |
| 60 | `/insights/구글애널리틱스를-통한-구매-및-전환-추적` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576723078_469.png` | 404 | — |
| 61 | `/insights/구글애널리틱스를-통한-구매-및-전환-추적` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576723292_941.jpg` | 404 | — |
| 62 | `/insights/구글애널리틱스를-통한-구매-및-전환-추적` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576723315_9311.jpg` | 404 | — |
| 63 | `/insights/콘텐츠-마케팅-전략-7단계` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9005851423ba3b0dae1f4a48945c72f3_1576643326_0494.jpg` | 404 | — |
| 64 | `/insights/콘텐츠-마케팅-전략-7단계` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9005851423ba3b0dae1f4a48945c72f3_1576643337_2769.jpg` | 404 | — |
| 65 | `/insights/구글-광고-전환에-최적화된-랜딩페이지-제작-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F36a20fe760e47b7579b1689a6957e215_1576551881_6127.png` | 404 | — |
| 66 | `/insights/구글-광고-전환에-최적화된-랜딩페이지-제작-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F36a20fe760e47b7579b1689a6957e215_1576551893_3596.png` | 404 | — |
| 67 | `/insights/구글-광고-전환에-최적화된-랜딩페이지-제작-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F36a20fe760e47b7579b1689a6957e215_1576551905_2192.png` | 404 | — |
| 68 | `/insights/구글-광고-전환에-최적화된-랜딩페이지-제작-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F36a20fe760e47b7579b1689a6957e215_1576554154_7483.png` | 404 | — |
| 69 | `/insights/구글-광고-전환에-최적화된-랜딩페이지-제작-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F36a20fe760e47b7579b1689a6957e215_1576554164_6592.png` | 404 | — |
| 70 | `/insights/구글-광고-계정-설정-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F70b7b16ef5cc45d6af5ca5ecab6bc2ce_1576213632_4606.png` | 404 | — |
| 71 | `/insights/구글-광고-계정-설정-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F70b7b16ef5cc45d6af5ca5ecab6bc2ce_1576213680_2804.png` | 404 | — |
| 72 | `/insights/구글-광고-계정-설정-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F70b7b16ef5cc45d6af5ca5ecab6bc2ce_1576213774_4113.png` | 404 | — |
| 73 | `/insights/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872622_9777.jpg` | 404 | — |
| 74 | `/insights/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872624_511.jpg` | 404 | — |
| 75 | `/insights/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872633_6355.jpg` | 404 | — |
| 76 | `/insights/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872635_033.jpg` | 404 | — |
| 77 | `/insights/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872636_5512.jpg` | 404 | — |
| 78 | `/insights/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872638_0987.jpg` | 404 | — |
| 79 | `/insights/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872640_8423.jpg` | 404 | — |
| 80 | `/insights/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872642_068.jpg` | 404 | — |
| 81 | `/insights/구글광고-보고서에서-중요한-지표는` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F67a1c21ffd96530fbb692b5d68c24ab3_1575512878_5327.jpg` | 404 | — |
| 82 | `/insights/구글광고-보고서에서-중요한-지표는` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F67a1c21ffd96530fbb692b5d68c24ab3_1575513352_8705.png` | 404 | — |
| 83 | `/insights/구글광고-보고서에서-중요한-지표는` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F67a1c21ffd96530fbb692b5d68c24ab3_1575513399_6968.png` | 404 | — |
| 84 | `/insights/페이스북마케팅-광고-소재와-문구는-어떻게` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Faad767404bca59eeb5bdb80cf9af1ce8_1575425985_6401.png` | 404 | — |
| 85 | `/insights/페이스북마케팅-광고-소재와-문구는-어떻게` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Faad767404bca59eeb5bdb80cf9af1ce8_1575425989_3641.png` | 404 | — |
| 86 | `/insights/페이스북마케팅-광고-소재와-문구는-어떻게` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Faad767404bca59eeb5bdb80cf9af1ce8_1575425992_7859.png` | 404 | — |
| 87 | `/insights/페이스북마케팅-광고-소재와-문구는-어떻게` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Faad767404bca59eeb5bdb80cf9af1ce8_1575425997_024.png` | 404 | — |
| 88 | `/insights/페이스북-마케팅-실전-기법-전략-수립-7단계` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F8d193ab535db46cfbd9881a61a4d8732_1575344590_1527.png` | 404 | — |
| 89 | `/insights/페이스북-마케팅-실전-기법-전략-수립-7단계` | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F8d193ab535db46cfbd9881a61a4d8732_1575346752_8528.png` | 404 | — |

각 출발 페이지의 원문 위치는 다음과 같아. 공통 렌더·시더 원인 줄은 위에 명시했어.

| 출발 페이지 | 보존 원문 파일:줄 |
|---|---|
| `/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/` | [database/content/legacy/wp-posts/1-c8271513.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/wp-posts/1-c8271513.json:7) |
| `/seo/11가지-최고의-seo-실수와-이를-피하는-방법/` | [database/content/legacy/wp-posts/3-9d3bc3ca.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/wp-posts/3-9d3bc3ca.json:7) |
| `/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/` | [database/content/legacy/wp-posts/2-633b3300.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/wp-posts/2-633b3300.json:7) |
| `/insights/인스타그램-인기게시물-노출을-위한-알고리즘-이해` | [database/content/legacy/columns/050-5b1f505e.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/050-5b1f505e.json:7) |
| `/insights/마케팅-퍼널이란-무엇인가-1` | [database/content/legacy/columns/040-ff58b1c7.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/040-ff58b1c7.json:7) |
| `/insights/스마트스토어-내게-맞는-키워드-발굴하는-법` | [database/content/legacy/columns/036-33e77872.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/036-33e77872.json:7) |
| `/insights/페이스북-광고-목적에-최적화된-유형-선택이-중요` | [database/content/legacy/columns/034-119578b2.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/034-119578b2.json:7) |
| `/insights/인스타그램-광고-실행-및-관리-방법` | [database/content/legacy/columns/033-66738189.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/033-66738189.json:7) |
| `/insights/인스타그램-마케팅에-대한-뜬소문들` | [database/content/legacy/columns/031-bc83adea.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/031-bc83adea.json:7) |
| `/insights/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드` | [database/content/legacy/columns/030-559ac1f6.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/030-559ac1f6.json:7) |
| `/insights/페이스북-광고-테스트가-꼭-필요한-이유` | [database/content/legacy/columns/029-e2fcbf73.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/029-e2fcbf73.json:7) |
| `/insights/구글애널리틱스를-통한-구매-및-전환-추적` | [database/content/legacy/columns/028-49d42df1.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/028-49d42df1.json:7) |
| `/insights/콘텐츠-마케팅-전략-7단계` | [database/content/legacy/columns/027-97e8e568.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/027-97e8e568.json:7) |
| `/insights/구글-광고-전환에-최적화된-랜딩페이지-제작-방법` | [database/content/legacy/columns/026-e04a1a29.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/026-e04a1a29.json:7) |
| `/insights/구글-광고-계정-설정-방법` | [database/content/legacy/columns/024-cadca27d.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/024-cadca27d.json:7) |
| `/insights/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법` | [database/content/legacy/columns/023-4d504a47.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/023-4d504a47.json:7) |
| `/insights/구글광고-보고서에서-중요한-지표는` | [database/content/legacy/columns/021-7b6b8a78.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/021-7b6b8a78.json:7) |
| `/insights/페이스북마케팅-광고-소재와-문구는-어떻게` | [database/content/legacy/columns/020-f2b0d24d.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/020-f2b0d24d.json:7) |
| `/insights/페이스북-마케팅-실전-기법-전략-수립-7단계` | [database/content/legacy/columns/019-1d52f696.json:7](/Users/anarchy/Claude_Projects/jcurve/database/content/legacy/columns/019-1d52f696.json:7) |

크롤 집계 실제 출력:

```text
S5 {"pages": 146, "requested": 239, "remaining": 0, "bad_links": 89, "modern_links": 0, "json_errors": [], "hidden_article_pages": [], "anarchy_pages": []}
```

## 통과 시나리오의 실제 출력

S1의 curl 한글 URL 입력, S2·S3·S4 재검사, S7~S13 발췌야. 여기서 S1의 21/21은 원시 바이트 전송을 포함하지 않으며, 원시 바이트 3건의 별도 실패는 위 표에 반영했어.

```text
S1 {"total": 21, "failed": 0}
S2 {"total": 15, "failed": 0}
S3 {"total": 15, "failed": 0}
S4 {"total": 161, "failed": 1, "stale_wp_redirects": []}
S11 {"total": 11, "failed": 0}
S13_SEED {"exit": 0, "stdout": "\n INFO Seeding database. \n\n Database\\Seeders\\BoardSeeder .. RUNNING \n Database\\Seeders\\BoardSeeder .. 24 ms DONE \n\n Database\\Seeders\\InsightCategorySeeder .. RUNNING \n Database\\Seeders\\InsightCategorySeeder .. 2 ms DONE \n\n Database\\Seeders\\LegacyRedirectSeeder .. RUNNING \n Database\\Seeders\\LegacyRedirectSeeder .. 23 ms DONE \n\n Database\\Seeders\\LegacyContentSeeder .. RUNNING \n Database\\Seeders\\LegacyContentSeeder .. 358 ms DONE \n\n", "rows_before": 191, "rows_after": 191, "same_full_rows": true, "sha_before": "ce751d4acf877b0794d76b7aabcf7768c5f528358cc58f6d838a0ea0b9b52f91", "sha_after": "ce751d4acf877b0794d76b7aabcf7768c5f528358cc58f6d838a0ea0b9b52f91"}
S13_S4_FAIL {"from": "/my-account", "status": 301, "location": "http://j-curve.co.kr/profile", "end": 302, "ok": false, "db_target": "/profile"}
S13_S4 {"total": 161, "failed": 1, "stale_wp_redirects": []}
S7 {"sitemaps": [["/sitemap.xml", 200], ["/sitemaps/pages/1.xml", 200], ["/sitemaps/services/1.xml", 200], ["/sitemaps/insights/1.xml", 200], ["/sitemaps/works/1.xml", 200]], "loc_count": 94, "bad": [], "missing_P": [], "modern_N": [], "rss_status": 200, "rss_wp_missing": [], "hidden_in_sitemap": false, "hidden_in_rss": false}
S8 {"total": 90, "failed": [], "statuses": [410]}
S9 {"total": 16, "failed": 0}
S10_HIDDEN {"status": 302, "location": "http://j-curve.co.kr/blog/", "ok": true}
S10_WR51 {"from": "/v1/manager/bbs/board.php?bo_table=column&wr_id=51", "status": 301, "location": "http://j-curve.co.kr/blog/", "end": 200, "ok": true}
S10_TEXT {"slug": "스마트스토어-검색광고가-꼭-필요할까", "status": 200, "db_raw_chars": 7075, "removed_chars": 56, "remaining_percent": 99.208, "expected_body_present": true, "title_present": true, "forbidden_sentence": false, "ok": true}
S10_TEXT {"slug": "스마트스토어-내게-맞는-키워드-발굴하는-법", "status": 200, "db_raw_chars": 29436, "removed_chars": 55, "remaining_percent": 99.813, "expected_body_present": true, "title_present": true, "forbidden_sentence": false, "ok": true}
S12_ROW {"path": "//evil.example/", "status": 404, "location": "", "ok": true}
S12_ROW {"path": "/%2f%2fevil.example", "status": 404, "location": "", "ok": true}
S12_ROW {"path": "/\\evil.example", "status": 404, "location": "", "ok": true}
S12_ROW {"path": "/about-us//evil.example", "status": 404, "location": "", "ok": true}
S12_ROW {"path": "/about-us/%2e%2e/", "status": 404, "location": "", "ok": true}
S12_ROW {"path": "/not-in-map", "status": 404, "location": "", "ok": true}
S12_ROW {"path": "/work/", "status": 200, "location": "", "ok": true}
S12_ROW {"path": "/services/seo/aeo/", "status": 200, "location": "", "ok": true}
```

문의 폼 실제 출력:

```text
S6_SUCCESS {"action": "http://j-curve.co.kr/contact-us/", "status": 302, "location": "http://j-curve.co.kr/contact-us/", "lead_delta": 1, "success_text": true, "ok": true}
S6_CSRF {"status": 419, "ok": true}
S6_HONEYPOT {"status": 200, "lead_delta": 0, "ok": true}
S6_REQUIRED {"status": 302, "location": "https://j-curve.co.kr/contact-us/", "error_visible": true, "ok": true}
S6_THROTTLE {"statuses": [302, 302, 302, 302, 302, 429], "ok": true}
S6_POST_ALIAS {"path": "/contact", "status": 302, "location": "http://j-curve.co.kr/contact-us/", "ok": true}
S6_POST_ALIAS {"path": "/contact-us", "status": 302, "location": "http://j-curve.co.kr/contact-us/", "ok": true}
```

GTM·호스트 실제 HTTP 출력:

```text
S14_HTTP {"host": "j-curve.co.kr", "path": "/", "layout": "jc", "GTM_ID": "", "status": 200, "robots": "index, follow", "verification": 1, "head_scripts": 0, "body_iframes": 0, "body_first_noscript": false, "ok": true}
S14_HTTP {"host": "j-curve.co.kr", "path": "/about-us/", "layout": "app", "GTM_ID": "", "status": 200, "robots": "index, follow", "verification": 1, "head_scripts": 0, "body_iframes": 0, "body_first_noscript": false, "ok": true}
S14_HTTP {"host": "j-curve.co.kr", "path": "/", "layout": "jc", "GTM_ID": "GTM-TEST123", "status": 200, "robots": "index, follow", "verification": 1, "head_scripts": 1, "body_iframes": 1, "body_first_noscript": true, "ok": true}
S14_HTTP {"host": "j-curve.co.kr", "path": "/about-us/", "layout": "app", "GTM_ID": "GTM-TEST123", "status": 200, "robots": "index, follow", "verification": 1, "head_scripts": 1, "body_iframes": 1, "body_first_noscript": true, "ok": true}
S14_HTTP {"host": "dev.j-curve.co.kr", "path": "/", "layout": "jc", "GTM_ID": "GTM-TEST123", "status": 200, "robots": "noindex, nofollow", "verification": 0, "head_scripts": 0, "body_iframes": 0, "body_first_noscript": false, "ok": true}
S14_HTTP {"host": "dev.j-curve.co.kr", "path": "/about-us/", "layout": "app", "GTM_ID": "GTM-TEST123", "status": 200, "robots": "noindex, nofollow", "verification": 0, "head_scripts": 0, "body_iframes": 0, "body_first_noscript": false, "ok": true}
S14_HTTP {"host": "j-curve.co.kr", "path": "/", "layout": "jc", "GTM_ID": "GTM-X');alert(1);//", "status": 200, "robots": "index, follow", "verification": 1, "head_scripts": 0, "body_iframes": 0, "body_first_noscript": false, "ok": true}
S14_HTTP {"host": "j-curve.co.kr", "path": "/about-us/", "layout": "app", "GTM_ID": "GTM-X');alert(1);//", "status": 200, "robots": "index, follow", "verification": 1, "head_scripts": 0, "body_iframes": 0, "body_first_noscript": false, "ok": true}
S14_CLEANUP {"server_stopped": true}
```

전체 태그/대표 재현 원출력: [tags-and-repro-http.log](/private/tmp/verify-url-preserve-01.uKzpTc/tags-and-repro-http.log).

### 기본 URL 감사 66개

실제 `seo:audit-urls` 명령을 Artisan으로 호출했고, 응답을 모킹하지 않았어. curl `CURLOPT_CONNECT_TO`로 `j-curve.co.kr:80`을 `127.0.0.1:8012`로만 연결해 공개 Host와 canonical 조건을 함께 지켰어.

```sh
env APP_BASE_PATH='/private/tmp/verify-url-preserve-01.uKzpTc/appcopy' APP_ENV='local' APP_DEBUG='false' APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=' APP_URL='http://j-curve.co.kr' SEO_PUBLIC_URL='https://j-curve.co.kr' DB_CONNECTION='sqlite' DB_DATABASE='/private/tmp/verify-url-preserve-01.uKzpTc/verify.sqlite' DB_URL='' CACHE_STORE='database' SESSION_DRIVER='database' SESSION_SECURE_COOKIE='false' MAIL_MAILER='array' QUEUE_CONNECTION='sync' LOG_CHANNEL='stderr' GTM_ID='' RANKFREE_API_ENABLED='false' python3 /private/tmp/verify-url-preserve-01.uKzpTc/http-tags.py AUDIT
```

실제 결과 발췌:

```json
{
  "base_url": "http://j-curve.co.kr",
  "total": 66,
  "passed": 66,
  "failed": 0
}
```

보존 16개=200, 살아 있는 기존 칼럼 50개=승인된 301·최종 200·canonical 검사. 이 66개 목록에는 `my-account`가 없으므로, 감사가 그린이어도 S4의 전수 실패를 덮지 않아. 상세: [url-audit-http.json](/private/tmp/verify-url-preserve-01.uKzpTc/url-audit-http.json).

## 품질 게이트 명령과 실제 출력

HTTP 서버 환경과 PHPUnit 환경은 분리했어. 테스트는 APP_ENV=testing, DB=:memory:, session/cache=array, APP_URL=http://localhost로 실행했어.

```sh
cd /private/tmp/verify-url-preserve-01.uKzpTc/appcopy
env APP_BASE_PATH='/private/tmp/verify-url-preserve-01.uKzpTc/appcopy' APP_ENV='testing' APP_DEBUG='false' APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=' APP_URL='http://localhost' SEO_PUBLIC_URL='https://j-curve.co.kr' DB_CONNECTION='sqlite' DB_DATABASE=':memory:' DB_URL='' CACHE_STORE='array' SESSION_DRIVER='array' SESSION_SECURE_COOKIE='false' MAIL_MAILER='array' QUEUE_CONNECTION='sync' LOG_CHANNEL='stderr' GTM_ID='' RANKFREE_API_ENABLED='false' php artisan test
python3 - <<'PY'
import subprocess
paths=subprocess.check_output(
    ['git','diff','3cbe3d8','--name-only','--','*.php'],
    cwd='/Users/anarchy/Claude_Projects/jcurve',text=True
).splitlines()
raise SystemExit(subprocess.call(['./vendor/bin/pint','--test',*paths]))
PY
npm run build
```

실제 출력 발췌:

```text
[2026-11-03 02:28:29] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"} 
[2026-11-03 02:28:29] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"} 
{"tool":"phpunit","result":"passed","tests":126,"passed":126,"assertions":19540,"duration_ms":5561}
CHANGED_PHP_FILES 27 ['app/Http/Controllers/InsightController.php', 'app/Http/Middleware/PreservePublicUrls.php', 'app/Models/Insight.php', 'app/Models/LegacyRedirect.php', 'app/Providers/AppServiceProvider.php', 'app/Services/Seo/Publishing/FeedCatalog.php', 'app/Services/Seo/Publishing/PreservedPaths.php', 'app/Services/Seo/Publishing/PreservedUrlGenerator.php', 'app/Services/Seo/Publishing/PublicUrl.php', 'app/Services/Seo/Publishing/UrlAuditManifest.php', 'bootstrap/app.php', 'config/seo.php', 'config/services.php', 'database/seeders/LegacyContentSeeder.php', 'database/seeders/LegacyRedirectSeeder.php', 'resources/views/errors/410.blade.php', 'resources/views/layouts/app.blade.php', 'resources/views/layouts/jc.blade.php', 'resources/views/partials/jc/gtm.blade.php', 'resources/views/partials/jc/head.blade.php', 'routes/web.php', 'tests/Feature/LegacyRedirectTest.php', 'tests/Feature/MarketingContentTest.php', 'tests/Feature/SeoFeedTest.php', 'tests/Feature/SeoUrlAuditTest.php', 'tests/Feature/UrlPreservationTest.php', 'tests/TestCase.php']
{"tool":"pint","result":"passed"}

PINT_EXIT 0
[2Ktransforming...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
✓ 12 modules transformed.
rendering chunks...
computing gzip size...
public/build/manifest.json                        0.88 kB │ gzip:  0.26 kB
public/build/assets/legacy-reskin-3fymEzpK.css   13.71 kB │ gzip:  2.99 kB
public/build/assets/jc-wWAxyZCv.css              89.85 kB │ gzip: 17.36 kB
public/build/assets/app-BW-Dp7Pe.css             97.52 kB │ gzip: 18.40 kB
public/build/assets/jc-DIWfGL1E.js               25.80 kB │ gzip:  9.23 kB
public/build/assets/app-XOhwnyVw.js             159.36 kB │ gzip: 60.50 kB

✓ built in 3.57s
[33m[PLUGIN_TIMINGS] [0mYour build spent 75% of 3.5s inside plugin hooks (2.6s).
Not measurable — 1 hook whose calls overlap, so elapsed time covers work other calls were doing. Profile with `node --cpu-prof`:
  - vite:css transform (3 calls)
See https://rolldown.rs/reference/InputOptions.checks#plugintimings for more details.
```

빌드의 `hero-glow.webp` 미해결 경고는 남아 있어. 성공 판정은 exit 0 기준이야. 테스트에서 출력된 rankfree 경고는 음성 경로 테스트 중 출력이며 실패 개수는 0이야.

초기 테스트 1회는 HTTP용 APP_ENV=local 등을 그대로 전달해 PHPUnit의 환경값을 덮어쓰는 검증 세팅 오류가 있었어(419 및 localhost 기대 불일치). 이를 제품 결함으로 세지 않았고, 환경 분리 후 최초 전체 검사와 각 무력화 원복 후 전체 검사까지 모두 126/126 재확인했어. 최종 게이트 출력은 위의 올바른 testing 환경 결과야.

기존 테스트 diff도 확인했어. 원주소 200·별칭 301 기대값 갱신은 스펙에 맞고, `Tests/TestCase.php`의 변경은 요청을 URL 생성기로 미리 P로 바꿔 버리는 거짓 통과를 막는 방향이야. MarketingContentTest의 버즈빌/NBT 기대 변경은 큐 Q-018의 기존 승인과 일치해. SeoUrlAuditTest의 기본 manifest 기대값은 보존 16개와 기존 칼럼 50개 301 계약에 맞아. 실제 HTTP 검사는 이 테스트 헬퍼를 사용하지 않았어.

## 테스트 무력화 실험과 원복 증명

실험은 `/private/tmp/verify-url-preserve-01.uKzpTc/appcopy`의 다음 3개 파일만 임시 수정했어. 원본 저장소 소스는 한 번도 수정하지 않았어.

1. T-A: `PreservedPaths::destination()`에 임시 `return null`, `routes/web.php`의 P 렌더 라우트 블록 임시 제거.
2. T-C: `bootstrap/app.php`에서 410 응답 코드를 임시 404로 교체.

실행 명령:

```sh
env APP_BASE_PATH='/private/tmp/verify-url-preserve-01.uKzpTc/appcopy' APP_ENV='testing' APP_DEBUG='false' APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=' APP_URL='http://localhost' SEO_PUBLIC_URL='https://j-curve.co.kr' DB_CONNECTION='sqlite' DB_DATABASE=':memory:' DB_URL='' CACHE_STORE='array' SESSION_DRIVER='array' SESSION_SECURE_COOKIE='false' MAIL_MAILER='array' QUEUE_CONNECTION='sync' LOG_CHANNEL='stderr' GTM_ID='' RANKFREE_API_ENABLED='false' php artisan test --filter=test_preserved_page_renders_original_content_canonical_and_single_hop_aliases
# 즉시 원복 후
env APP_BASE_PATH='/private/tmp/verify-url-preserve-01.uKzpTc/appcopy' APP_ENV='testing' APP_DEBUG='false' APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=' APP_URL='http://localhost' SEO_PUBLIC_URL='https://j-curve.co.kr' DB_CONNECTION='sqlite' DB_DATABASE=':memory:' DB_URL='' CACHE_STORE='array' SESSION_DRIVER='array' SESSION_SECURE_COOKIE='false' MAIL_MAILER='array' QUEUE_CONNECTION='sync' LOG_CHANNEL='stderr' GTM_ID='' RANKFREE_API_ENABLED='false' php artisan test
env APP_BASE_PATH='/private/tmp/verify-url-preserve-01.uKzpTc/appcopy' APP_ENV='testing' APP_DEBUG='false' APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=' APP_URL='http://localhost' SEO_PUBLIC_URL='https://j-curve.co.kr' DB_CONNECTION='sqlite' DB_DATABASE=':memory:' DB_URL='' CACHE_STORE='array' SESSION_DRIVER='array' SESSION_SECURE_COOKIE='false' MAIL_MAILER='array' QUEUE_CONNECTION='sync' LOG_CHANNEL='stderr' GTM_ID='' RANKFREE_API_ENABLED='false' php artisan test --filter=test_all_thirty_missing_columns_are_gone_with_case_and_query_order_independent_keys
# 즉시 원복 후
env APP_BASE_PATH='/private/tmp/verify-url-preserve-01.uKzpTc/appcopy' APP_ENV='testing' APP_DEBUG='false' APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=' APP_URL='http://localhost' SEO_PUBLIC_URL='https://j-curve.co.kr' DB_CONNECTION='sqlite' DB_DATABASE=':memory:' DB_URL='' CACHE_STORE='array' SESSION_DRIVER='array' SESSION_SECURE_COOKIE='false' MAIL_MAILER='array' QUEUE_CONNECTION='sync' LOG_CHANNEL='stderr' GTM_ID='' RANKFREE_API_ENABLED='false' php artisan test
```

실제 실패/원복 결과 발췌:

```text
T-A: exit=1; tests=15; passed=0; failed=15; assertions=15
Expected response status code [200] but received 404.
{"tool":"phpunit","result":"passed","tests":126,"passed":126,"assertions":19540,"duration_ms":5517}

T-C:
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":1,"duration_ms":234,"failed":1,"failures":[{"test":"Tests\\Feature\\UrlPreservationTest::test_all_thirty_missing_columns_are_gone_with_case_and_query_order_independent_keys","file":"/private/tmp/verify-url-preserve-01.uKzpTc/appcopy/tests/Feature/UrlPreservationTest.php","line":220,"message":"Expected response status code [410] but received 404.\nFailed asserting that 404 is identical to 410."}]}
{"tool":"phpunit","result":"passed","tests":126,"passed":126,"assertions":19540,"duration_ms":5561}
```

T-A 전체 원출력: [mutation-A.log](/private/tmp/verify-url-preserve-01.uKzpTc/mutation-A.log). T-C 전체 원출력: [mutation-C.log](/private/tmp/verify-url-preserve-01.uKzpTc/mutation-C.log).

실험 전·후 아래 명령의 출력이 같았어. `git diff`가 비어 있는 것만으로 끝내지 않고 **기준 커밋 이후 diff**와 **복제본 원복 파일 SHA-256**도 함께 비교했어.

```sh
cd /Users/anarchy/Claude_Projects/jcurve
git diff | shasum
git diff 3cbe3d8 | shasum
shasum -a 256 /private/tmp/verify-url-preserve-01.uKzpTc/appcopy/app/Services/Seo/Publishing/PreservedPaths.php /private/tmp/verify-url-preserve-01.uKzpTc/appcopy/routes/web.php /private/tmp/verify-url-preserve-01.uKzpTc/appcopy/bootstrap/app.php
```

실험 전:

```text
GIT_DIFF_SHA1 da39a3ee5e6b4b0d3255bfef95601890afd80709
BASE_DIFF_SHA1 7b7956f7bf5fe79a8d3b0468e97b0e84a1ed66d2
FILE_SHA256 {"app/Services/Seo/Publishing/PreservedPaths.php": "158977c6cddebe2394f4b7e48732837da9432eeff0a33b73db77d753a858ac08", "routes/web.php": "0e608ca4ac3957c870d7047ffdef97b5a1053245c2931e6dc6ad4d61ef9b9d05", "bootstrap/app.php": "67fd15356f8aaef1af008fd5f321b08dfde1d1f76dc5f79e37868c13ffb2bc8a"}
```

실험 후:

```text
da39a3ee5e6b4b0d3255bfef95601890afd80709  -
7b7956f7bf5fe79a8d3b0468e97b0e84a1ed66d2  -
158977c6cddebe2394f4b7e48732837da9432eeff0a33b73db77d753a858ac08  /private/tmp/verify-url-preserve-01.uKzpTc/appcopy/app/Services/Seo/Publishing/PreservedPaths.php
0e608ca4ac3957c870d7047ffdef97b5a1053245c2931e6dc6ad4d61ef9b9d05  /private/tmp/verify-url-preserve-01.uKzpTc/appcopy/routes/web.php
67fd15356f8aaef1af008fd5f321b08dfde1d1f76dc5f79e37868c13ffb2bc8a  /private/tmp/verify-url-preserve-01.uKzpTc/appcopy/bootstrap/app.php
```

원복 증명 전체: [restoration.log](/private/tmp/verify-url-preserve-01.uKzpTc/restoration.log). 원본 `git status --porcelain=v1`도 출력 없이 끝났어.

## 전체 변경 범위와 미검증 항목

```text
.env.example                                       |   2 +
 app/Http/Controllers/InsightController.php         |  13 +-
 app/Http/Middleware/PreservePublicUrls.php         |  28 +
 app/Models/Insight.php                             |  31 +-
 app/Models/LegacyRedirect.php                      |  11 +-
 app/Providers/AppServiceProvider.php               |  13 +
 app/Services/Seo/Publishing/FeedCatalog.php        |   5 +-
 app/Services/Seo/Publishing/PreservedPaths.php     |  32 +
 .../Seo/Publishing/PreservedUrlGenerator.php       |  19 +
 app/Services/Seo/Publishing/PublicUrl.php          |   2 +-
 app/Services/Seo/Publishing/UrlAuditManifest.php   |  11 +-
 bootstrap/app.php                                  |  10 +-
 config/seo.php                                     |  28 +-
 config/services.php                                |   6 +
 database/seeders/LegacyContentSeeder.php           |  17 +-
 database/seeders/LegacyRedirectSeeder.php          |  29 +-
 docs/SPEC-CODEX-URL-PRESERVE-01.md                 |  90 +++
 docs/VERIFY-CODEX-URL-PRESERVE-01.md               |  38 ++
 docs/collab/QUEUE.md                               |   2 +
 resources/views/errors/410.blade.php               |  13 +
 resources/views/layouts/app.blade.php              |   2 +
 resources/views/layouts/jc.blade.php               |   2 +
 resources/views/partials/jc/gtm.blade.php          |  21 +
 resources/views/partials/jc/head.blade.php         |   8 +-
 routes/web.php                                     |  28 +-
 tests/Feature/LegacyRedirectTest.php               |   9 +-
 tests/Feature/MarketingContentTest.php             |  29 +-
 tests/Feature/SeoFeedTest.php                      |   2 +-
 tests/Feature/SeoUrlAuditTest.php                  |  12 +-
 tests/Feature/UrlPreservationTest.php              | 317 +++++++++
 tests/TestCase.php                                 |  11 +-
 tests/URL-PRESERVE-01-RESULT.md                    | 736 +++++++++++++++++++++
 32 files changed, 1521 insertions(+), 56 deletions(-)
```

`WorkSeeder.php`, `public/media/**`, `resources/css/**`, `resources/js/**`, `database/content/**`는 기준 커밋 대비 diff 없음. 소스 수정은 하지 않았으므로 발견 사항을 고친 결과는 포함하지 않아.

- 운영 서버·실DB·MySQL·운영 PHP/웹서버·TLS/프록시의 실제 동작은 금지 범위라 접속하지 않았어. 특히 원시 UTF-8 요청줄의 운영 웹서버 수용 여부는 미검증이야.
- S1의 한글 URL 입력과 원시 전송을 혼동하지 않았어. 전자는 200, 후자는 지정 로컬 서버에서 연결 종료였어.
- 크롤은 서버가 렌더한 HTML href·JSON-LD 기준이야. 외부 호스트, img/src 전체, JS 실행 후 DOM 변경은 이번 검증 대상으로 주장하지 않아.
- 공유 대시보드 파일은 쓰기 허용 범위 밖이라 갱신하지 않았어. 요청 큐·원본 문서·원본 소스도 변경하지 않았어.
- 내가 띄운 8012 서버는 전부 종료했어. 마지막 `lsof -nP -iTCP:8012 -sTCP:LISTEN`은 출력 없음·exit 1이었어. 검증 스크립트와 SQLite·증거 파일만 위 임시 폴더에 보관했어.
- 엄격한 지시서 판정은 S1 환경 미충족 + S4 체인 + S5 문제 링크 때문에 FAIL이야. S4/S5 대표 원인은 기준 커밋부터 있던 잔존 문제로 확인했으며, 새 구현의 회귀로 과장하지 않아.

**최종 판정: 운영 전환 커밋으로 사용하면 안 됨 — S4 리다이렉트 체인 1건과 S5 내부 링크 89건이 합격 기준에 미달하고, S1 원시 한글 전송 3건도 로컬 환경에서 200을 입증하지 못했어.**
