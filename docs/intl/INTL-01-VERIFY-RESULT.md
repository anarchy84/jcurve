# VERIFY-INTL-01 — 독립 검증 결과

- 실행일: 2026-11-03 KST. 검증자: Codex 검증 세션. 대상: 현재 worktree `wip/2026-11-03-i18n`, HEAD `3c394d2` 및 시작 시 미커밋 변경. 비교 기준 `0662117`.
- 지시서 `VERIFY-CODEX-INTL-01.md` 전부, 구현 지시서, INTL-PLAN, GLOSSARY §6, COLLAB, QUEUE를 확인했다. 구현 세션의 PASS를 근거로 재사용하지 않고 직접 실행했다. 최종 승인권자는 Claude·대웅이다.
- 소스의 영구 변경은 없다. §T에서만 네 곳을 잠시 바꿨고 각각 원복했다. 커밋·푸시·브랜치 변경·배포·원본 저장소를 대상으로 한 명령은 실행하지 않았다. 금지 포트 8000·8014·8023은 조회·제어하지 않았다. 독립 HTTP 서버는 8031만 사용했고 종료했다.
- 검증 문서 외 작업 파일은 임시 경로에만 두었다. 대시보드·큐는 이번 검증 전용 범위 밖이므로 수정하지 않았다. 기본 빌드가 worktree의 `node_modules` 링크 아래 임시파일 쓰기를 시도하다 권한 차단된 사실은 V11에 그대로 기록한다.

## 시나리오별 판정

| 항목 | 판정 | 실제 근거·한계 |
| --- | --- | --- |
| V1 한국어 무변경 | **FAIL (지정 비교 조건)** | 106경로 × 3헤더 × 2코드=636요청. 상태·Location 차이 0, KO 사이트맵 94항목 동일. CSRF·Vite만 정규화하면 10경로 HTML 차이. 랜덤 SVG·암호화 타이머까지 제거한 참고 비교는 0이나 합격 근거로 쓰지 않음. |
| V2 외국어 주소 | **PASS** | 43×2: 200 2개, 뷰 없음 404 84개. 제외 24개 전부404. 이상한 주소에 500·한국어 화면·외부 리다이렉트 없음. 별도 실제 HTTP 재현. |
| V3 301 | **PASS** | GET/HEAD·슬래시·원시 쿼리 포함 276건, 전부301 1홉·쿼리 동일·루프0. preserved_map 글 별칭 추가48건은 미번역404로 전부 기대 일치. 레거시 별칭382건은 동작 전수 보고. |
| V4 글 | **FAIL (실제 화면 조건 미충족)** | 실제 번역 slug EN은404: `intl.insights.show` 없음. 외부 임시 probe 뷰로 컨트롤러만 격리하면 번역 EN200·미번역/숨김/미래404·언어별 slug·카테고리·page2 통과. 실제200과 혼동하지 않음. |
| V5 canonical·hreflang | **FAIL** | 세 홈 canonical 자기 주소. EN/JA는4개 alternate가 모두200이지만 KO 홈 alternate0개. 404 문맥에서도 helper가 없는 EN/JA 뷰 주소를 반환. 현재 홈의 hreflang/og alternate가 직접404를 가리키는 건0개. |
| V6 사이트맵 | **PASS (지시된 구조·비교)** | KO94 순서·내용·lastmod 동일, 전체184·외국어90·중복0·XML유효. 외국어90 중200 2·404 88은 아래 주의사항. 지시서는 현재 404 분포를 보고하도록 요구함. |
| V7 문의 | **FAIL (재표시 검증 미완료)** | locale 위조6조합·검증 언어·리다이렉트·CSRF419·honeypot/타이머 차단·실제6번째429 통과. 외국어 문의 GET404라 script 재표시 이스케이프는 확인 불가. |
| V8 언어 누수 | **PASS** | 한 PHP 앱에서 EN→KO→JA→KO. lang·복원locale 정상, KO 두 응답 전체 HTML이 기준과 동일(CSRF/Vite만 정규화). cookie=ja/session=en도 주소 선택을 바꾸지 못함. |
| V9 번역 데이터 | **PASS** | 시더2회 행2·전체값 해시동일, stale0→2, 없는 원문 경고, cascade0행, down·재migrate 성공. |
| V10 화면 | **PASS (실행한 필수 검사)** | EN/JA 한글0·번역키0·주요수치 일치·제외링크0. 각184 내부링크: 자기언어178·페이지내2·언어전환4. 390px 검사는 미완료이며 합격 주장에 포함하지 않음. |
| V11 품질 게이트 | **FAIL (기본 빌드 환경)** | 전체199/199·21,198 assertions 및 Pint40파일 PASS. 요청한 기본 `npm run build`는 EPERM exit1. 같은 소스의 `--configLoader runner` 빌드는 exit0. |
| §T 무력화 | **PASS** | 301·404·문의locale 테스트 각각 red, KO 공백1글자 비교도 red. 네 번 각각 원복 후 전체199/199 green, status/diff 해시 동일. |

화면 미구현에 따른404는 V2에서는 명시된 정상값이다. V4의 ‘실제 EN200’, V7의 ‘실제 재표시’를 만족했다고 확대 해석하지 않았다. V1 FAIL은 현재 증거로 한국어 내용 회귀가 발견됐다는 뜻이 아니라, 지정된 엄격 비교의 통과 증거를 만들지 못했다는 뜻이다.

## 1. 환경·실제 실행 방법

원본 디렉터리로 이동하지 않고 현재 worktree에서 `git archive 0662117`을 Python subprocess로 실행, tarfile로 `$SCRATCH/intl-base`에 풀었다. `vendor`·`node_modules`·`public/build`만 worktree 것을 링크했다. `.env`는 수동 열람·복제하지 않았다(앱 자체 bootstrap의 환경 로드는 실행됨). DB는 모두 `$TMPDIR` SQLite, mail=array·queue=sync, SEO 공개 URL과 PHP 요청 Host는 `j-curve.co.kr`. 시간은 `2026-11-03 00:00:00`으로 고정했다.

실제 사용한 임시 경로:
`/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/verify-intl-01.mEV4sm`

```sh
python3 /private/tmp/verify_intl01_run.py /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/verify-intl-01.mEV4sm setup
python3 /private/tmp/verify_intl01_run.py /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/verify-intl-01.mEV4sm probe
```

이 두 명령이 실행한 PHP harness, 환경변수, 외부 PHPUnit probe 전체를 부록에 붙였다. 실DB 연결 없이 `migrate --force`→`db:seed --force`를 양쪽에서 실행했다. WorkSeeder 미호출과 Work행0은 다음 실제 출력으로 확인했다.

```text
$ php /private/tmp/verify_intl01.php /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/verify-intl-01.mEV4sm/intl-base snapshot /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/verify-intl-01.mEV4sm/baseline.json
migrate --force exit=0

   INFO  Preparing database.  

  Creating migration table ....................................... 6.61ms DONE

   INFO  Running migrations.  

  0001_01_01_000000_create_users_table ........................... 9.16ms DONE
  0001_01_01_000001_create_cache_table ........................... 4.22ms DONE
  0001_01_01_000002_create_jobs_table ............................ 5.21ms DONE
  2026_08_04_000001_create_boards_table .......................... 1.57ms DONE
  2026_08_04_000002_create_posts_table .......................... 11.33ms DONE
  2026_08_04_000003_create_comments_table ........................ 1.18ms DONE
  2026_08_04_000004_create_post_likes_table ...................... 1.95ms DONE
  2026_08_04_000005_create_attachments_table ..................... 1.12ms DONE
  2026_08_04_000006_create_insight_categories_table .............. 2.05ms DONE
  2026_08_04_000007_create_insights_table ........................ 1.95ms DONE
  2026_08_04_000008_create_works_table ........................... 1.28ms DONE
  2026_08_04_000009_create_leads_table ........................... 0.49ms DONE
  2026_08_04_000010_create_seo_meta_table ........................ 2.66ms DONE
  2026_08_04_000011_add_community_columns_to_users_table ......... 7.10ms DONE
  2026_08_04_000012_create_legacy_redirects_table ................ 1.05ms DONE
  2026_08_04_000013_add_legacy_columns_to_insights_table ......... 1.90ms DONE
  2026_10_27_000001_create_rankfree_connections_table ............ 1.78ms DONE

db:seed --force exit=0

   INFO  Seeding database.  

  Database\Seeders\BoardSeeder ....................................... RUNNING  
  Database\Seeders\BoardSeeder .................................... 14 ms DONE  

  Database\Seeders\InsightCategorySeeder ............................. RUNNING  
  Database\Seeders\InsightCategorySeeder .......................... 15 ms DONE  

  Database\Seeders\LegacyRedirectSeeder .............................. RUNNING  
  Database\Seeders\LegacyRedirectSeeder .......................... 135 ms DONE  

  Database\Seeders\LegacyContentSeeder ............................... RUNNING  
  Database\Seeders\LegacyContentSeeder ........................... 228 ms DONE  

WORK_COUNT=0
SNAPSHOT paths=106 requests=318 korean_sitemap=94 normalization=CSRF,Vite-only

EXIT=0
```

```text
$ php /private/tmp/verify_intl01.php /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n snapshot /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/verify-intl-01.mEV4sm/current.json
migrate --force exit=0

   INFO  Preparing database.  

  Creating migration table ....................................... 2.42ms DONE

   INFO  Running migrations.  

  0001_01_01_000000_create_users_table ........................... 6.08ms DONE
  0001_01_01_000001_create_cache_table ........................... 1.94ms DONE
  0001_01_01_000002_create_jobs_table ............................ 7.42ms DONE
  2026_08_04_000001_create_boards_table .......................... 1.81ms DONE
  2026_08_04_000002_create_posts_table .......................... 11.57ms DONE
  2026_08_04_000003_create_comments_table ........................ 0.68ms DONE
  2026_08_04_000004_create_post_likes_table ...................... 2.58ms DONE
  2026_08_04_000005_create_attachments_table ..................... 1.00ms DONE
  2026_08_04_000006_create_insight_categories_table .............. 0.66ms DONE
  2026_08_04_000007_create_insights_table ........................ 1.76ms DONE
  2026_08_04_000008_create_works_table ........................... 1.02ms DONE
  2026_08_04_000009_create_leads_table ........................... 0.56ms DONE
  2026_08_04_000010_create_seo_meta_table ........................ 1.51ms DONE
  2026_08_04_000011_add_community_columns_to_users_table ........ 12.88ms DONE
  2026_08_04_000012_create_legacy_redirects_table ................ 6.45ms DONE
  2026_08_04_000013_add_legacy_columns_to_insights_table ......... 7.92ms DONE
  2026_10_27_000001_create_rankfree_connections_table ............ 1.25ms DONE
  2026_11_03_000001_create_insight_translations_table ............ 2.18ms DONE
  2026_11_03_000002_add_locale_to_leads_table .................... 1.22ms DONE

db:seed --force exit=0

   INFO  Seeding database.  

  Database\Seeders\BoardSeeder ....................................... RUNNING  
  Database\Seeders\BoardSeeder ..................................... 9 ms DONE  

  Database\Seeders\InsightCategorySeeder ............................. RUNNING  
  Database\Seeders\InsightCategorySeeder .......................... 10 ms DONE  

  Database\Seeders\LegacyRedirectSeeder .............................. RUNNING  
  Database\Seeders\LegacyRedirectSeeder ........................... 70 ms DONE  

  Database\Seeders\LegacyContentSeeder ............................... RUNNING  
  Database\Seeders\LegacyContentSeeder ........................... 215 ms DONE  

  Database\Seeders\IntlInsightSeeder ................................. RUNNING  
  Database\Seeders\IntlInsightSeeder ............................... 6 ms DONE  

WORK_COUNT=0
SNAPSHOT paths=106 requests=318 korean_sitemap=94 normalization=CSRF,Vite-only

EXIT=0
```

## 2. V1 — 엄격 비교 실패의 정확한 범위

- 사이트맵 한국어 전부·원주소16개·지시된 추가 경로를 합쳐 중복 제거106개. 두 코드 모두 104개200·2개301(`/company`, `/contact`). 301 Location까지 동일했다.
- 각 경로에 Accept-Language 없음/en/ja를 각각 보냈다. 한국어 응답의 헤더별 엄격 HTML 차이도 en10·ja10개이며 같은 랜덤값 차이다. 참고 진단 정규화에서는 헤더에 따른 차이0.
- 합격 비교에서 바꾼 값은 CSRF meta/input, Vite 파일명 해시뿐이다. 스페이스·문구·타이머·SVG ID는 유지했다.
- 기존 `tests/Support/intl_snapshot.php:53-54`는 `valid_from`과 SVG ID도 지운다. 그 도구의 기존 ‘차이0’을 이번 지시서의 엄격 비교 PASS로 인용할 수 없다.
- 차이 발생 위치: `resources/views/partials/scene.blade.php:6`의 `Str::random(5)`, `resources/views/contact.blade.php:65`의 honeypot 출력. 암호화값은 시간 고정만으로 동일해지지 않는다. 아래 diff는 실제 출력 그대로다.

```json
{
  "paths": 106,
  "requests_per_checkout": 318,
  "strict_diffs": [
    "/seo/",
    "/wordpress-agency/",
    "/contact-us/",
    "/services/performance-marketing",
    "/services/cpa-marketing",
    "/services/reward-network",
    "/solutions/rankfree",
    "/solutions/leadbay",
    "/solutions/call2sale",
    "/solutions/boostingshop"
  ],
  "status_location_diffs": [],
  "diagnostic_diffs": [],
  "accept_language_diagnostic_diffs": [],
  "catalog_equal": true
}
```

```text
CATALOG_EQUAL=True
PATHS=106
--- base/seo/
+++ current/seo/
@@ -290,3 +290,3 @@
     <defs>
-        <linearGradient id="sbg-y28bD" x1="0" y1="0" x2="1" y2="1">
+        <linearGradient id="sbg-jDJU6" x1="0" y1="0" x2="1" y2="1">
             <stop offset="0" stop-color="#0a2a63"/>
@@ -294,3 +294,3 @@
         </linearGradient>
-        <radialGradient id="sgl-y28bD" cx="50%" cy="28%" r="72%">
+        <radialGradient id="sgl-jDJU6" cx="50%" cy="28%" r="72%">
             <stop offset="0" stop-color="#2997ff" stop-opacity=".45"/>
@@ -298,3 +298,3 @@
         </radialGradient>
-        <pattern id="sdot-y28bD" width="26" height="26" patternUnits="userSpaceOnUse">
+        <pattern id="sdot-jDJU6" width="26" height="26" patternUnits="userSpaceOnUse">
             <circle cx="2" cy="2" r="1.4" fill="#ffffff" fill-opacity=".07"/>
@@ -302,5 +302,5 @@
     </defs>
-    <rect width="400" height="300" fill="url(#sbg-y28bD)"/>
-    <rect width="400" height="300" fill="url(#sdot-y28bD)"/>
-    <rect width="400" height="300" fill="url(#sgl-y28bD)"/>
+    <rect width="400" height="300" fill="url(#sbg-jDJU6)"/>
+    <rect width="400" height="300" fill="url(#sdot-jDJU6)"/>
+    <rect width="400" height="300" fill="url(#sgl-jDJU6)"/>
 

--- base/wordpress-agency/
+++ current/wordpress-agency/
@@ -290,3 +290,3 @@
     <defs>
-        <linearGradient id="sbg-rgQpL" x1="0" y1="0" x2="1" y2="1">
+        <linearGradient id="sbg-9FR1v" x1="0" y1="0" x2="1" y2="1">
             <stop offset="0" stop-color="#0a2a63"/>
@@ -294,3 +294,3 @@
         </linearGradient>
-        <radialGradient id="sgl-rgQpL" cx="50%" cy="28%" r="72%">
+        <radialGradient id="sgl-9FR1v" cx="50%" cy="28%" r="72%">
             <stop offset="0" stop-color="#2997ff" stop-opacity=".45"/>
@@ -298,3 +298,3 @@
         </radialGradient>
-        <pattern id="sdot-rgQpL" width="26" height="26" patternUnits="userSpaceOnUse">
+        <pattern id="sdot-9FR1v" width="26" height="26" patternUnits="userSpaceOnUse">
             <circle cx="2" cy="2" r="1.4" fill="#ffffff" fill-opacity=".07"/>
@@ -302,5 +302,5 @@
     </defs>
-    <rect width="400" height="300" fill="url(#sbg-rgQpL)"/>
-    <rect width="400" height="300" fill="url(#sdot-rgQpL)"/>
-    <rect width="400" height="300" fill="url(#sgl-rgQpL)"/>
+    <rect width="400" height="300" fill="url(#sbg-9FR1v)"/>
+    <rect width="400" height="300" fill="url(#sdot-9FR1v)"/>
+    <rect width="400" height="300" fill="url(#sgl-9FR1v)"/>
 

--- base/contact-us/
+++ current/contact-us/
@@ -328,3 +328,3 @@
                type="text"
-               value="eyJpdiI6IlNueFJjS0pvM0dWdUdoNThPa2c5V0E9PSIsInZhbHVlIjoiYmMwSEh1NythblFYN2p2b0pMVmlDZz09IiwibWFjIjoiZDc4NzUwZGUyYzQzMTEzZjNmMjc0NzU2NWZiYzgzOTJmNmRhMzZhOWVjYThlYzI4MWQyMzMwMDZmNjc1NzI3ZSIsInRhZyI6IiJ9"
+               value="eyJpdiI6IlBnU0pyTFhwc3RBaElRQ0szY09HSEE9PSIsInZhbHVlIjoiNlpiblFuZC82by93cEkwN0pmcTdPQT09IiwibWFjIjoiMDQzOTMwYzZmZDQwMjcyNjhiMGI4Y2Y4ZWRjYjA3ZTU3NGU1NjljYzViY2FjZmIwMGIzNzdmMmM5ZTRjY2UxOCIsInRhZyI6IiJ9"
                               autocomplete="off"

--- base/services/performance-marketing
+++ current/services/performance-marketing
@@ -295,3 +295,3 @@
     <defs>
-        <linearGradient id="sbg-gIYsJ" x1="0" y1="0" x2="1" y2="1">
+        <linearGradient id="sbg-kIQ5I" x1="0" y1="0" x2="1" y2="1">
             <stop offset="0" stop-color="#0a2a63"/>
@@ -299,3 +299,3 @@
         </linearGradient>
-        <radialGradient id="sgl-gIYsJ" cx="50%" cy="28%" r="72%">
+        <radialGradient id="sgl-kIQ5I" cx="50%" cy="28%" r="72%">
             <stop offset="0" stop-color="#2997ff" stop-opacity=".45"/>
@@ -303,3 +303,3 @@
         </radialGradient>
-        <pattern id="sdot-gIYsJ" width="26" height="26" patternUnits="userSpaceOnUse">
+        <pattern id="sdot-kIQ5I" width="26" height="26" patternUnits="userSpaceOnUse">
             <circle cx="2" cy="2" r="1.4" fill="#ffffff" fill-opacity=".07"/>
@@ -307,5 +307,5 @@
     </defs>
-    <rect width="400" height="300" fill="url(#sbg-gIYsJ)"/>
-    <rect width="400" height="300" fill="url(#sdot-gIYsJ)"/>
-    <rect width="400" height="300" fill="url(#sgl-gIYsJ)"/>
+    <rect width="400" height="300" fill="url(#sbg-kIQ5I)"/>
+    <rect width="400" height="300" fill="url(#sdot-kIQ5I)"/>
+    <rect width="400" height="300" fill="url(#sgl-kIQ5I)"/>
 

--- base/services/cpa-marketing
+++ current/services/cpa-marketing
@@ -290,3 +290,3 @@
     <defs>
-        <linearGradient id="sbg-DSWOK" x1="0" y1="0" x2="1" y2="1">
+        <linearGradient id="sbg-dCYWq" x1="0" y1="0" x2="1" y2="1">
             <stop offset="0" stop-color="#0a2a63"/>
@@ -294,3 +294,3 @@
         </linearGradient>
-        <radialGradient id="sgl-DSWOK" cx="50%" cy="28%" r="72%">
+        <radialGradient id="sgl-dCYWq" cx="50%" cy="28%" r="72%">
             <stop offset="0" stop-color="#2997ff" stop-opacity=".45"/>
@@ -298,3 +298,3 @@
         </radialGradient>
-        <pattern id="sdot-DSWOK" width="26" height="26" patternUnits="userSpaceOnUse">
+        <pattern id="sdot-dCYWq" width="26" height="26" patternUnits="userSpaceOnUse">
             <circle cx="2" cy="2" r="1.4" fill="#ffffff" fill-opacity=".07"/>
@@ -302,5 +302,5 @@
     </defs>
-    <rect width="400" height="300" fill="url(#sbg-DSWOK)"/>
-    <rect width="400" height="300" fill="url(#sdot-DSWOK)"/>
-    <rect width="400" height="300" fill="url(#sgl-DSWOK)"/>
+    <rect width="400" height="300" fill="url(#sbg-dCYWq)"/>
+    <rect width="400" height="300" fill="url(#sdot-dCYWq)"/>
+    <rect width="400" height="300" fill="url(#sgl-dCYWq)"/>
 

--- base/services/reward-network
+++ current/services/reward-network
@@ -309,3 +309,3 @@
     <defs>
-        <linearGradient id="sbg-IGvzo" x1="0" y1="0" x2="1" y2="1">
+        <linearGradient id="sbg-f0znI" x1="0" y1="0" x2="1" y2="1">
             <stop offset="0" stop-color="#0a2a63"/>
@@ -313,3 +313,3 @@
         </linearGradient>
-        <radialGradient id="sgl-IGvzo" cx="50%" cy="28%" r="72%">
+        <radialGradient id="sgl-f0znI" cx="50%" cy="28%" r="72%">
             <stop offset="0" stop-color="#2997ff" stop-opacity=".45"/>
@@ -317,3 +317,3 @@
         </radialGradient>
-        <pattern id="sdot-IGvzo" width="26" height="26" patternUnits="userSpaceOnUse">
+        <pattern id="sdot-f0znI" width="26" height="26" patternUnits="userSpaceOnUse">
             <circle cx="2" cy="2" r="1.4" fill="#ffffff" fill-opacity=".07"/>
@@ -321,5 +321,5 @@
     </defs>
-    <rect width="400" height="300" fill="url(#sbg-IGvzo)"/>
-    <rect width="400" height="300" fill="url(#sdot-IGvzo)"/>
-    <rect width="400" height="300" fill="url(#sgl-IGvzo)"/>
+    <rect width="400" height="300" fill="url(#sbg-f0znI)"/>
+    <rect width="400" height="300" fill="url(#sdot-f0znI)"/>
+    <rect width="400" height="300" fill="url(#sgl-f0znI)"/>
 

--- base/solutions/rankfree
+++ current/solutions/rankfree
@@ -293,3 +293,3 @@
     <defs>
-        <linearGradient id="sbg-Qg17g" x1="0" y1="0" x2="1" y2="1">
+        <linearGradient id="sbg-kvNsy" x1="0" y1="0" x2="1" y2="1">
             <stop offset="0" stop-color="#0a2a63"/>
@@ -297,3 +297,3 @@
         </linearGradient>
-        <radialGradient id="sgl-Qg17g" cx="50%" cy="28%" r="72%">
+        <radialGradient id="sgl-kvNsy" cx="50%" cy="28%" r="72%">
             <stop offset="0" stop-color="#2997ff" stop-opacity=".45"/>
@@ -301,3 +301,3 @@
         </radialGradient>
-        <pattern id="sdot-Qg17g" width="26" height="26" patternUnits="userSpaceOnUse">
+        <pattern id="sdot-kvNsy" width="26" height="26" patternUnits="userSpaceOnUse">
             <circle cx="2" cy="2" r="1.4" fill="#ffffff" fill-opacity=".07"/>
@@ -305,5 +305,5 @@
     </defs>
-    <rect width="400" height="300" fill="url(#sbg-Qg17g)"/>
-    <rect width="400" height="300" fill="url(#sdot-Qg17g)"/>
-    <rect width="400" height="300" fill="url(#sgl-Qg17g)"/>
+    <rect width="400" height="300" fill="url(#sbg-kvNsy)"/>
+    <rect width="400" height="300" fill="url(#sdot-kvNsy)"/>
+    <rect width="400" height="300" fill="url(#sgl-kvNsy)"/>
 

--- base/solutions/leadbay
+++ current/solutions/leadbay
@@ -292,3 +292,3 @@
     <defs>
-        <linearGradient id="sbg-FLJdy" x1="0" y1="0" x2="1" y2="1">
+        <linearGradient id="sbg-EMvKN" x1="0" y1="0" x2="1" y2="1">
             <stop offset="0" stop-color="#0a2a63"/>
@@ -296,3 +296,3 @@
         </linearGradient>
-        <radialGradient id="sgl-FLJdy" cx="50%" cy="28%" r="72%">
+        <radialGradient id="sgl-EMvKN" cx="50%" cy="28%" r="72%">
             <stop offset="0" stop-color="#2997ff" stop-opacity=".45"/>
@@ -300,3 +300,3 @@
         </radialGradient>
-        <pattern id="sdot-FLJdy" width="26" height="26" patternUnits="userSpaceOnUse">
+        <pattern id="sdot-EMvKN" width="26" height="26" patternUnits="userSpaceOnUse">
             <circle cx="2" cy="2" r="1.4" fill="#ffffff" fill-opacity=".07"/>
@@ -304,5 +304,5 @@
     </defs>
-    <rect width="400" height="300" fill="url(#sbg-FLJdy)"/>
-    <rect width="400" height="300" fill="url(#sdot-FLJdy)"/>
-    <rect width="400" height="300" fill="url(#sgl-FLJdy)"/>
+    <rect width="400" height="300" fill="url(#sbg-EMvKN)"/>
+    <rect width="400" height="300" fill="url(#sdot-EMvKN)"/>
+    <rect width="400" height="300" fill="url(#sgl-EMvKN)"/>
 

--- base/solutions/call2sale
+++ current/solutions/call2sale
@@ -292,3 +292,3 @@
     <defs>
-        <linearGradient id="sbg-Rm2dI" x1="0" y1="0" x2="1" y2="1">
+        <linearGradient id="sbg-ur4gJ" x1="0" y1="0" x2="1" y2="1">
             <stop offset="0" stop-color="#0a2a63"/>
@@ -296,3 +296,3 @@
         </linearGradient>
-        <radialGradient id="sgl-Rm2dI" cx="50%" cy="28%" r="72%">
+        <radialGradient id="sgl-ur4gJ" cx="50%" cy="28%" r="72%">
             <stop offset="0" stop-color="#2997ff" stop-opacity=".45"/>
@@ -300,3 +300,3 @@
         </radialGradient>
-        <pattern id="sdot-Rm2dI" width="26" height="26" patternUnits="userSpaceOnUse">
+        <pattern id="sdot-ur4gJ" width="26" height="26" patternUnits="userSpaceOnUse">
             <circle cx="2" cy="2" r="1.4" fill="#ffffff" fill-opacity=".07"/>
@@ -304,5 +304,5 @@
     </defs>
-    <rect width="400" height="300" fill="url(#sbg-Rm2dI)"/>
-    <rect width="400" height="300" fill="url(#sdot-Rm2dI)"/>
-    <rect width="400" height="300" fill="url(#sgl-Rm2dI)"/>
+    <rect width="400" height="300" fill="url(#sbg-ur4gJ)"/>
+    <rect width="400" height="300" fill="url(#sdot-ur4gJ)"/>
+    <rect width="400" height="300" fill="url(#sgl-ur4gJ)"/>
 

--- base/solutions/boostingshop
+++ current/solutions/boostingshop
@@ -293,3 +293,3 @@
     <defs>
-        <linearGradient id="sbg-jXCzP" x1="0" y1="0" x2="1" y2="1">
+        <linearGradient id="sbg-Wsa86" x1="0" y1="0" x2="1" y2="1">
             <stop offset="0" stop-color="#0a2a63"/>
@@ -297,3 +297,3 @@
         </linearGradient>
-        <radialGradient id="sgl-jXCzP" cx="50%" cy="28%" r="72%">
+        <radialGradient id="sgl-Wsa86" cx="50%" cy="28%" r="72%">
             <stop offset="0" stop-color="#2997ff" stop-opacity=".45"/>
@@ -301,3 +301,3 @@
         </radialGradient>
-        <pattern id="sdot-jXCzP" width="26" height="26" patternUnits="userSpaceOnUse">
+        <pattern id="sdot-Wsa86" width="26" height="26" patternUnits="userSpaceOnUse">
             <circle cx="2" cy="2" r="1.4" fill="#ffffff" fill-opacity=".07"/>
@@ -305,5 +305,5 @@
     </defs>
-    <rect width="400" height="300" fill="url(#sbg-jXCzP)"/>
-    <rect width="400" height="300" fill="url(#sdot-jXCzP)"/>
-    <rect width="400" height="300" fill="url(#sgl-jXCzP)"/>
+    <rect width="400" height="300" fill="url(#sbg-Wsa86)"/>
+    <rect width="400" height="300" fill="url(#sdot-Wsa86)"/>
+    <rect width="400" height="300" fill="url(#sgl-Wsa86)"/>
```

같은 원인을 보존한 채로 V1 PASS를 선언할 수 없다. 무작위값을 추가 제거한 진단은 원인 분리용이며 정규화 허용 범위를 임의 확장한 것이 아니다.

## 3. V2 — 전수 상태 및 실제 HTTP

PHP 커널 요청 결과이며 경로·상태·Location 원자료를 표로 변환했다.

| 정식 경로 | 상태 | Location |
| --- | --- | --- |
| /en/ | 200 | — |
| /en/about-us/ | 404 | — |
| /en/contact-us/ | 404 | — |
| /en/privacy | 404 | — |
| /en/support/faq | 404 | — |
| /en/services | 404 | — |
| /en/services/performance-marketing | 404 | — |
| /en/services/cpa-marketing | 404 | — |
| /en/services/reward-network | 404 | — |
| /en/seo/ | 404 | — |
| /en/wordpress-agency/ | 404 | — |
| /en/services/seo/aeo | 404 | — |
| /en/services/seo/geo | 404 | — |
| /en/seo-backlinks/ | 404 | — |
| /en/naver-place-marketing/ | 404 | — |
| /en/naver-shopping-marketing/ | 404 | — |
| /en/kakao-gift/ | 404 | — |
| /en/coupang/ | 404 | — |
| /en/services/cpa-marketing/real-estate | 404 | — |
| /en/services/cpa-marketing/stock | 404 | — |
| /en/services/cpa-marketing/insurance | 404 | — |
| /en/services/cpa-marketing/coin | 404 | — |
| /en/services/cpa-marketing/permission-call | 404 | — |
| /en/services/performance-marketing/naver-gfa | 404 | — |
| /en/services/performance-marketing/facebook | 404 | — |
| /en/services/performance-marketing/youtube | 404 | — |
| /en/services/marketing-support | 404 | — |
| /en/solutions | 404 | — |
| /en/solutions/rankfree | 404 | — |
| /en/solutions/boostingshop | 404 | — |
| /en/solutions/shopitrend | 404 | — |
| /en/solutions/leadbay | 404 | — |
| /en/solutions/call2sale | 404 | — |
| /en/solutions/boostingshop/basic | 404 | — |
| /en/solutions/boostingshop/pro | 404 | — |
| /en/solutions/boostingshop/elite | 404 | — |
| /en/solutions/boostingshop/instagram-popular | 404 | — |
| /en/solutions/boostingshop/instagram-followers | 404 | — |
| /en/solutions/boostingshop/instagram-likes | 404 | — |
| /en/self-marketing | 404 | — |
| /en/self-marketing/place | 404 | — |
| /en/work | 404 | — |
| /en/blog/ | 404 | — |
| /ja/ | 200 | — |
| /ja/about-us/ | 404 | — |
| /ja/contact-us/ | 404 | — |
| /ja/privacy | 404 | — |
| /ja/support/faq | 404 | — |
| /ja/services | 404 | — |
| /ja/services/performance-marketing | 404 | — |
| /ja/services/cpa-marketing | 404 | — |
| /ja/services/reward-network | 404 | — |
| /ja/seo/ | 404 | — |
| /ja/wordpress-agency/ | 404 | — |
| /ja/services/seo/aeo | 404 | — |
| /ja/services/seo/geo | 404 | — |
| /ja/seo-backlinks/ | 404 | — |
| /ja/naver-place-marketing/ | 404 | — |
| /ja/naver-shopping-marketing/ | 404 | — |
| /ja/kakao-gift/ | 404 | — |
| /ja/coupang/ | 404 | — |
| /ja/services/cpa-marketing/real-estate | 404 | — |
| /ja/services/cpa-marketing/stock | 404 | — |
| /ja/services/cpa-marketing/insurance | 404 | — |
| /ja/services/cpa-marketing/coin | 404 | — |
| /ja/services/cpa-marketing/permission-call | 404 | — |
| /ja/services/performance-marketing/naver-gfa | 404 | — |
| /ja/services/performance-marketing/facebook | 404 | — |
| /ja/services/performance-marketing/youtube | 404 | — |
| /ja/services/marketing-support | 404 | — |
| /ja/solutions | 404 | — |
| /ja/solutions/rankfree | 404 | — |
| /ja/solutions/boostingshop | 404 | — |
| /ja/solutions/shopitrend | 404 | — |
| /ja/solutions/leadbay | 404 | — |
| /ja/solutions/call2sale | 404 | — |
| /ja/solutions/boostingshop/basic | 404 | — |
| /ja/solutions/boostingshop/pro | 404 | — |
| /ja/solutions/boostingshop/elite | 404 | — |
| /ja/solutions/boostingshop/instagram-popular | 404 | — |
| /ja/solutions/boostingshop/instagram-followers | 404 | — |
| /ja/solutions/boostingshop/instagram-likes | 404 | — |
| /ja/self-marketing | 404 | — |
| /ja/self-marketing/place | 404 | — |
| /ja/work | 404 | — |
| /ja/blog/ | 404 | — |

| 제외 경로 | 상태 | Location |
| --- | --- | --- |
| /en/login | 404 | — |
| /en/register | 404 | — |
| /en/dashboard | 404 | — |
| /en/profile | 404 | — |
| /en/my-account | 404 | — |
| /en/community | 404 | — |
| /en/self-marketing/order | 404 | — |
| /en/seo-check | 404 | — |
| /en/support/inquiries | 404 | — |
| /en/work/아무거나 | 404 | — |
| /en/rss | 404 | — |
| /en/sitemap.xml | 404 | — |
| /ja/login | 404 | — |
| /ja/register | 404 | — |
| /ja/dashboard | 404 | — |
| /ja/profile | 404 | — |
| /ja/my-account | 404 | — |
| /ja/community | 404 | — |
| /ja/self-marketing/order | 404 | — |
| /ja/seo-check | 404 | — |
| /ja/support/inquiries | 404 | — |
| /ja/work/아무거나 | 404 | — |
| /ja/rss | 404 | — |
| /ja/sitemap.xml | 404 | — |

| 이상한 경로 | 상태 | Location | KO html |
| --- | --- | --- | --- |
| /EN/ | 404 | — | False |
| /en | 301 | https://j-curve.co.kr/en/ | False |
| /en//about-us/ | 404 | — | False |
| /en/./about-us/ | 404 | — | False |
| /en/%2e%2e/ | 404 | — | False |
| /en%2Fabout-us | 404 | — | False |
| /ko/ | 404 | — | False |
| /fr/ | 404 | — | False |
| /en/en/ | 404 | — | False |
| /en//evil.com | 404 | — | False |
| /en/%2F%2Fevil.com | 404 | — | False |

별도 8031 서버에서 `http.client.HTTPConnection`으로 원시 경로·`Host: j-curve.co.kr`를 보내고 자동 follow 없이 관찰했다. HTTP 서버이므로301 URL scheme은 http이며 PHP 커널의 https 요청과 다르다. 둘 다 같은 Host 내부 주소다.

```json
[
  {
    "path": "/en/",
    "status": 200,
    "location": null,
    "ko_html": false,
    "bytes": 89755
  },
  {
    "path": "/ja/",
    "status": 200,
    "location": null,
    "ko_html": false,
    "bytes": 84821
  },
  {
    "path": "/EN/",
    "status": 404,
    "location": null,
    "ko_html": false,
    "bytes": 6586
  },
  {
    "path": "/en",
    "status": 301,
    "location": "http://j-curve.co.kr/en/",
    "ko_html": false,
    "bytes": 342
  },
  {
    "path": "/en//about-us/",
    "status": 404,
    "location": null,
    "ko_html": false,
    "bytes": 6586
  },
  {
    "path": "/en/./about-us/",
    "status": 404,
    "location": null,
    "ko_html": false,
    "bytes": 6586
  },
  {
    "path": "/en/%2e%2e/",
    "status": 404,
    "location": null,
    "ko_html": false,
    "bytes": 6586
  },
  {
    "path": "/en%2Fabout-us",
    "status": 404,
    "location": null,
    "ko_html": false,
    "bytes": 6586
  },
  {
    "path": "/ko/",
    "status": 404,
    "location": null,
    "ko_html": false,
    "bytes": 6586
  },
  {
    "path": "/fr/",
    "status": 404,
    "location": null,
    "ko_html": false,
    "bytes": 6586
  },
  {
    "path": "/en/en/",
    "status": 404,
    "location": null,
    "ko_html": false,
    "bytes": 6586
  },
  {
    "path": "/en//evil.com",
    "status": 404,
    "location": null,
    "ko_html": false,
    "bytes": 6586
  }
]
```

## 4. V3 — 301 전수 검사

원시 query=`x=1&x=2&q=a%2Fb&encoded=%ED%95%9C%EA%B8%80&blank=&plus=a+b`. 모든 요청에 붙였고 Location의 query 원문을 byte 비교했다. 다음 표는 query를 생략한 경로 표시이며 각 행의 PASS는 상태301·Location 전체문자열 일치·도착 응답301 아님을 모두 뜻한다. 뷰가 없는 도착지404는 V2 기대값이다. GET/HEAD 합계276, 실패0.

| method | 요청(공통query 포함) | Location(동일query) | 도착상태 | 2차 Location | 일치 |
| --- | --- | --- | --- | --- | --- |
| GET | /en/company | https://j-curve.co.kr/en/about-us/ | 404 | — | True |
| HEAD | /en/company | https://j-curve.co.kr/en/about-us/ | 404 | — | True |
| GET | /en/about-us | https://j-curve.co.kr/en/about-us/ | 404 | — | True |
| HEAD | /en/about-us | https://j-curve.co.kr/en/about-us/ | 404 | — | True |
| GET | /en/about-us// | https://j-curve.co.kr/en/about-us/ | 404 | — | True |
| HEAD | /en/about-us// | https://j-curve.co.kr/en/about-us/ | 404 | — | True |
| GET | /en/contact | https://j-curve.co.kr/en/contact-us/ | 404 | — | True |
| HEAD | /en/contact | https://j-curve.co.kr/en/contact-us/ | 404 | — | True |
| GET | /en/contact-us | https://j-curve.co.kr/en/contact-us/ | 404 | — | True |
| HEAD | /en/contact-us | https://j-curve.co.kr/en/contact-us/ | 404 | — | True |
| GET | /en/contact-us// | https://j-curve.co.kr/en/contact-us/ | 404 | — | True |
| HEAD | /en/contact-us// | https://j-curve.co.kr/en/contact-us/ | 404 | — | True |
| GET | /en/insights | https://j-curve.co.kr/en/blog/ | 404 | — | True |
| HEAD | /en/insights | https://j-curve.co.kr/en/blog/ | 404 | — | True |
| GET | /en/blog | https://j-curve.co.kr/en/blog/ | 404 | — | True |
| HEAD | /en/blog | https://j-curve.co.kr/en/blog/ | 404 | — | True |
| GET | /en/blog// | https://j-curve.co.kr/en/blog/ | 404 | — | True |
| HEAD | /en/blog// | https://j-curve.co.kr/en/blog/ | 404 | — | True |
| GET | /en/insights/category/seo | https://j-curve.co.kr/en/blog/seo/ | 404 | — | True |
| HEAD | /en/insights/category/seo | https://j-curve.co.kr/en/blog/seo/ | 404 | — | True |
| GET | /en/blog/seo | https://j-curve.co.kr/en/blog/seo/ | 404 | — | True |
| HEAD | /en/blog/seo | https://j-curve.co.kr/en/blog/seo/ | 404 | — | True |
| GET | /en/blog/seo// | https://j-curve.co.kr/en/blog/seo/ | 404 | — | True |
| HEAD | /en/blog/seo// | https://j-curve.co.kr/en/blog/seo/ | 404 | — | True |
| GET | /en/insights/category/link-building | https://j-curve.co.kr/en/blog/link-building/ | 404 | — | True |
| HEAD | /en/insights/category/link-building | https://j-curve.co.kr/en/blog/link-building/ | 404 | — | True |
| GET | /en/blog/link-building | https://j-curve.co.kr/en/blog/link-building/ | 404 | — | True |
| HEAD | /en/blog/link-building | https://j-curve.co.kr/en/blog/link-building/ | 404 | — | True |
| GET | /en/blog/link-building// | https://j-curve.co.kr/en/blog/link-building/ | 404 | — | True |
| HEAD | /en/blog/link-building// | https://j-curve.co.kr/en/blog/link-building/ | 404 | — | True |
| GET | /en/services/seo | https://j-curve.co.kr/en/seo/ | 404 | — | True |
| HEAD | /en/services/seo | https://j-curve.co.kr/en/seo/ | 404 | — | True |
| GET | /en/seo | https://j-curve.co.kr/en/seo/ | 404 | — | True |
| HEAD | /en/seo | https://j-curve.co.kr/en/seo/ | 404 | — | True |
| GET | /en/seo// | https://j-curve.co.kr/en/seo/ | 404 | — | True |
| HEAD | /en/seo// | https://j-curve.co.kr/en/seo/ | 404 | — | True |
| GET | /en/services/seo/backlinks | https://j-curve.co.kr/en/seo-backlinks/ | 404 | — | True |
| HEAD | /en/services/seo/backlinks | https://j-curve.co.kr/en/seo-backlinks/ | 404 | — | True |
| GET | /en/seo-backlinks | https://j-curve.co.kr/en/seo-backlinks/ | 404 | — | True |
| HEAD | /en/seo-backlinks | https://j-curve.co.kr/en/seo-backlinks/ | 404 | — | True |
| GET | /en/seo-backlinks// | https://j-curve.co.kr/en/seo-backlinks/ | 404 | — | True |
| HEAD | /en/seo-backlinks// | https://j-curve.co.kr/en/seo-backlinks/ | 404 | — | True |
| GET | /en/services/wordpress | https://j-curve.co.kr/en/wordpress-agency/ | 404 | — | True |
| HEAD | /en/services/wordpress | https://j-curve.co.kr/en/wordpress-agency/ | 404 | — | True |
| GET | /en/wordpress-agency | https://j-curve.co.kr/en/wordpress-agency/ | 404 | — | True |
| HEAD | /en/wordpress-agency | https://j-curve.co.kr/en/wordpress-agency/ | 404 | — | True |
| GET | /en/wordpress-agency// | https://j-curve.co.kr/en/wordpress-agency/ | 404 | — | True |
| HEAD | /en/wordpress-agency// | https://j-curve.co.kr/en/wordpress-agency/ | 404 | — | True |
| GET | /en/services/seo/naver-place | https://j-curve.co.kr/en/naver-place-marketing/ | 404 | — | True |
| HEAD | /en/services/seo/naver-place | https://j-curve.co.kr/en/naver-place-marketing/ | 404 | — | True |
| GET | /en/naver-place-marketing | https://j-curve.co.kr/en/naver-place-marketing/ | 404 | — | True |
| HEAD | /en/naver-place-marketing | https://j-curve.co.kr/en/naver-place-marketing/ | 404 | — | True |
| GET | /en/naver-place-marketing// | https://j-curve.co.kr/en/naver-place-marketing/ | 404 | — | True |
| HEAD | /en/naver-place-marketing// | https://j-curve.co.kr/en/naver-place-marketing/ | 404 | — | True |
| GET | /en/services/seo/naver-shopping | https://j-curve.co.kr/en/naver-shopping-marketing/ | 404 | — | True |
| HEAD | /en/services/seo/naver-shopping | https://j-curve.co.kr/en/naver-shopping-marketing/ | 404 | — | True |
| GET | /en/naver-shopping-marketing | https://j-curve.co.kr/en/naver-shopping-marketing/ | 404 | — | True |
| HEAD | /en/naver-shopping-marketing | https://j-curve.co.kr/en/naver-shopping-marketing/ | 404 | — | True |
| GET | /en/naver-shopping-marketing// | https://j-curve.co.kr/en/naver-shopping-marketing/ | 404 | — | True |
| HEAD | /en/naver-shopping-marketing// | https://j-curve.co.kr/en/naver-shopping-marketing/ | 404 | — | True |
| GET | /en/services/seo/kakao-gift | https://j-curve.co.kr/en/kakao-gift/ | 404 | — | True |
| HEAD | /en/services/seo/kakao-gift | https://j-curve.co.kr/en/kakao-gift/ | 404 | — | True |
| GET | /en/kakao-gift | https://j-curve.co.kr/en/kakao-gift/ | 404 | — | True |
| HEAD | /en/kakao-gift | https://j-curve.co.kr/en/kakao-gift/ | 404 | — | True |
| GET | /en/kakao-gift// | https://j-curve.co.kr/en/kakao-gift/ | 404 | — | True |
| HEAD | /en/kakao-gift// | https://j-curve.co.kr/en/kakao-gift/ | 404 | — | True |
| GET | /en/services/seo/coupang | https://j-curve.co.kr/en/coupang/ | 404 | — | True |
| HEAD | /en/services/seo/coupang | https://j-curve.co.kr/en/coupang/ | 404 | — | True |
| GET | /en/coupang | https://j-curve.co.kr/en/coupang/ | 404 | — | True |
| HEAD | /en/coupang | https://j-curve.co.kr/en/coupang/ | 404 | — | True |
| GET | /en/coupang// | https://j-curve.co.kr/en/coupang/ | 404 | — | True |
| HEAD | /en/coupang// | https://j-curve.co.kr/en/coupang/ | 404 | — | True |
| GET | /en | https://j-curve.co.kr/en/ | 200 | — | True |
| HEAD | /en | https://j-curve.co.kr/en/ | 200 | — | True |
| GET | /en/privacy/ | https://j-curve.co.kr/en/privacy | 404 | — | True |
| HEAD | /en/privacy/ | https://j-curve.co.kr/en/privacy | 404 | — | True |
| GET | /en/support/faq/ | https://j-curve.co.kr/en/support/faq | 404 | — | True |
| HEAD | /en/support/faq/ | https://j-curve.co.kr/en/support/faq | 404 | — | True |
| GET | /en/services/ | https://j-curve.co.kr/en/services | 404 | — | True |
| HEAD | /en/services/ | https://j-curve.co.kr/en/services | 404 | — | True |
| GET | /en/services/performance-marketing/ | https://j-curve.co.kr/en/services/performance-marketing | 404 | — | True |
| HEAD | /en/services/performance-marketing/ | https://j-curve.co.kr/en/services/performance-marketing | 404 | — | True |
| GET | /en/services/cpa-marketing/ | https://j-curve.co.kr/en/services/cpa-marketing | 404 | — | True |
| HEAD | /en/services/cpa-marketing/ | https://j-curve.co.kr/en/services/cpa-marketing | 404 | — | True |
| GET | /en/services/reward-network/ | https://j-curve.co.kr/en/services/reward-network | 404 | — | True |
| HEAD | /en/services/reward-network/ | https://j-curve.co.kr/en/services/reward-network | 404 | — | True |
| GET | /en/services/seo/aeo/ | https://j-curve.co.kr/en/services/seo/aeo | 404 | — | True |
| HEAD | /en/services/seo/aeo/ | https://j-curve.co.kr/en/services/seo/aeo | 404 | — | True |
| GET | /en/services/seo/geo/ | https://j-curve.co.kr/en/services/seo/geo | 404 | — | True |
| HEAD | /en/services/seo/geo/ | https://j-curve.co.kr/en/services/seo/geo | 404 | — | True |
| GET | /en/services/cpa-marketing/real-estate/ | https://j-curve.co.kr/en/services/cpa-marketing/real-estate | 404 | — | True |
| HEAD | /en/services/cpa-marketing/real-estate/ | https://j-curve.co.kr/en/services/cpa-marketing/real-estate | 404 | — | True |
| GET | /en/services/cpa-marketing/stock/ | https://j-curve.co.kr/en/services/cpa-marketing/stock | 404 | — | True |
| HEAD | /en/services/cpa-marketing/stock/ | https://j-curve.co.kr/en/services/cpa-marketing/stock | 404 | — | True |
| GET | /en/services/cpa-marketing/insurance/ | https://j-curve.co.kr/en/services/cpa-marketing/insurance | 404 | — | True |
| HEAD | /en/services/cpa-marketing/insurance/ | https://j-curve.co.kr/en/services/cpa-marketing/insurance | 404 | — | True |
| GET | /en/services/cpa-marketing/coin/ | https://j-curve.co.kr/en/services/cpa-marketing/coin | 404 | — | True |
| HEAD | /en/services/cpa-marketing/coin/ | https://j-curve.co.kr/en/services/cpa-marketing/coin | 404 | — | True |
| GET | /en/services/cpa-marketing/permission-call/ | https://j-curve.co.kr/en/services/cpa-marketing/permission-call | 404 | — | True |
| HEAD | /en/services/cpa-marketing/permission-call/ | https://j-curve.co.kr/en/services/cpa-marketing/permission-call | 404 | — | True |
| GET | /en/services/performance-marketing/naver-gfa/ | https://j-curve.co.kr/en/services/performance-marketing/naver-gfa | 404 | — | True |
| HEAD | /en/services/performance-marketing/naver-gfa/ | https://j-curve.co.kr/en/services/performance-marketing/naver-gfa | 404 | — | True |
| GET | /en/services/performance-marketing/facebook/ | https://j-curve.co.kr/en/services/performance-marketing/facebook | 404 | — | True |
| HEAD | /en/services/performance-marketing/facebook/ | https://j-curve.co.kr/en/services/performance-marketing/facebook | 404 | — | True |
| GET | /en/services/performance-marketing/youtube/ | https://j-curve.co.kr/en/services/performance-marketing/youtube | 404 | — | True |
| HEAD | /en/services/performance-marketing/youtube/ | https://j-curve.co.kr/en/services/performance-marketing/youtube | 404 | — | True |
| GET | /en/services/marketing-support/ | https://j-curve.co.kr/en/services/marketing-support | 404 | — | True |
| HEAD | /en/services/marketing-support/ | https://j-curve.co.kr/en/services/marketing-support | 404 | — | True |
| GET | /en/solutions/ | https://j-curve.co.kr/en/solutions | 404 | — | True |
| HEAD | /en/solutions/ | https://j-curve.co.kr/en/solutions | 404 | — | True |
| GET | /en/solutions/rankfree/ | https://j-curve.co.kr/en/solutions/rankfree | 404 | — | True |
| HEAD | /en/solutions/rankfree/ | https://j-curve.co.kr/en/solutions/rankfree | 404 | — | True |
| GET | /en/solutions/boostingshop/ | https://j-curve.co.kr/en/solutions/boostingshop | 404 | — | True |
| HEAD | /en/solutions/boostingshop/ | https://j-curve.co.kr/en/solutions/boostingshop | 404 | — | True |
| GET | /en/solutions/shopitrend/ | https://j-curve.co.kr/en/solutions/shopitrend | 404 | — | True |
| HEAD | /en/solutions/shopitrend/ | https://j-curve.co.kr/en/solutions/shopitrend | 404 | — | True |
| GET | /en/solutions/leadbay/ | https://j-curve.co.kr/en/solutions/leadbay | 404 | — | True |
| HEAD | /en/solutions/leadbay/ | https://j-curve.co.kr/en/solutions/leadbay | 404 | — | True |
| GET | /en/solutions/call2sale/ | https://j-curve.co.kr/en/solutions/call2sale | 404 | — | True |
| HEAD | /en/solutions/call2sale/ | https://j-curve.co.kr/en/solutions/call2sale | 404 | — | True |
| GET | /en/solutions/boostingshop/basic/ | https://j-curve.co.kr/en/solutions/boostingshop/basic | 404 | — | True |
| HEAD | /en/solutions/boostingshop/basic/ | https://j-curve.co.kr/en/solutions/boostingshop/basic | 404 | — | True |
| GET | /en/solutions/boostingshop/pro/ | https://j-curve.co.kr/en/solutions/boostingshop/pro | 404 | — | True |
| HEAD | /en/solutions/boostingshop/pro/ | https://j-curve.co.kr/en/solutions/boostingshop/pro | 404 | — | True |
| GET | /en/solutions/boostingshop/elite/ | https://j-curve.co.kr/en/solutions/boostingshop/elite | 404 | — | True |
| HEAD | /en/solutions/boostingshop/elite/ | https://j-curve.co.kr/en/solutions/boostingshop/elite | 404 | — | True |
| GET | /en/solutions/boostingshop/instagram-popular/ | https://j-curve.co.kr/en/solutions/boostingshop/instagram-popular | 404 | — | True |
| HEAD | /en/solutions/boostingshop/instagram-popular/ | https://j-curve.co.kr/en/solutions/boostingshop/instagram-popular | 404 | — | True |
| GET | /en/solutions/boostingshop/instagram-followers/ | https://j-curve.co.kr/en/solutions/boostingshop/instagram-followers | 404 | — | True |
| HEAD | /en/solutions/boostingshop/instagram-followers/ | https://j-curve.co.kr/en/solutions/boostingshop/instagram-followers | 404 | — | True |
| GET | /en/solutions/boostingshop/instagram-likes/ | https://j-curve.co.kr/en/solutions/boostingshop/instagram-likes | 404 | — | True |
| HEAD | /en/solutions/boostingshop/instagram-likes/ | https://j-curve.co.kr/en/solutions/boostingshop/instagram-likes | 404 | — | True |
| GET | /en/self-marketing/ | https://j-curve.co.kr/en/self-marketing | 404 | — | True |
| HEAD | /en/self-marketing/ | https://j-curve.co.kr/en/self-marketing | 404 | — | True |
| GET | /en/self-marketing/place/ | https://j-curve.co.kr/en/self-marketing/place | 404 | — | True |
| HEAD | /en/self-marketing/place/ | https://j-curve.co.kr/en/self-marketing/place | 404 | — | True |
| GET | /en/work/ | https://j-curve.co.kr/en/work | 404 | — | True |
| HEAD | /en/work/ | https://j-curve.co.kr/en/work | 404 | — | True |
| GET | /ja/company | https://j-curve.co.kr/ja/about-us/ | 404 | — | True |
| HEAD | /ja/company | https://j-curve.co.kr/ja/about-us/ | 404 | — | True |

### V3 301 전수 목록(계속)

원시 query=`x=1&x=2&q=a%2Fb&encoded=%ED%95%9C%EA%B8%80&blank=&plus=a+b`. 모든 요청에 붙였고 Location의 query 원문을 byte 비교했다. 다음 표는 query를 생략한 경로 표시이며 각 행의 PASS는 상태301·Location 전체문자열 일치·도착 응답301 아님을 모두 뜻한다. 뷰가 없는 도착지404는 V2 기대값이다. GET/HEAD 합계276, 실패0.

| method | 요청(공통query 포함) | Location(동일query) | 도착상태 | 2차 Location | 일치 |
| --- | --- | --- | --- | --- | --- |
| GET | /ja/about-us | https://j-curve.co.kr/ja/about-us/ | 404 | — | True |
| HEAD | /ja/about-us | https://j-curve.co.kr/ja/about-us/ | 404 | — | True |
| GET | /ja/about-us// | https://j-curve.co.kr/ja/about-us/ | 404 | — | True |
| HEAD | /ja/about-us// | https://j-curve.co.kr/ja/about-us/ | 404 | — | True |
| GET | /ja/contact | https://j-curve.co.kr/ja/contact-us/ | 404 | — | True |
| HEAD | /ja/contact | https://j-curve.co.kr/ja/contact-us/ | 404 | — | True |
| GET | /ja/contact-us | https://j-curve.co.kr/ja/contact-us/ | 404 | — | True |
| HEAD | /ja/contact-us | https://j-curve.co.kr/ja/contact-us/ | 404 | — | True |
| GET | /ja/contact-us// | https://j-curve.co.kr/ja/contact-us/ | 404 | — | True |
| HEAD | /ja/contact-us// | https://j-curve.co.kr/ja/contact-us/ | 404 | — | True |
| GET | /ja/insights | https://j-curve.co.kr/ja/blog/ | 404 | — | True |
| HEAD | /ja/insights | https://j-curve.co.kr/ja/blog/ | 404 | — | True |
| GET | /ja/blog | https://j-curve.co.kr/ja/blog/ | 404 | — | True |
| HEAD | /ja/blog | https://j-curve.co.kr/ja/blog/ | 404 | — | True |
| GET | /ja/blog// | https://j-curve.co.kr/ja/blog/ | 404 | — | True |
| HEAD | /ja/blog// | https://j-curve.co.kr/ja/blog/ | 404 | — | True |
| GET | /ja/insights/category/seo | https://j-curve.co.kr/ja/blog/seo/ | 404 | — | True |
| HEAD | /ja/insights/category/seo | https://j-curve.co.kr/ja/blog/seo/ | 404 | — | True |
| GET | /ja/blog/seo | https://j-curve.co.kr/ja/blog/seo/ | 404 | — | True |
| HEAD | /ja/blog/seo | https://j-curve.co.kr/ja/blog/seo/ | 404 | — | True |
| GET | /ja/blog/seo// | https://j-curve.co.kr/ja/blog/seo/ | 404 | — | True |
| HEAD | /ja/blog/seo// | https://j-curve.co.kr/ja/blog/seo/ | 404 | — | True |
| GET | /ja/insights/category/link-building | https://j-curve.co.kr/ja/blog/link-building/ | 404 | — | True |
| HEAD | /ja/insights/category/link-building | https://j-curve.co.kr/ja/blog/link-building/ | 404 | — | True |
| GET | /ja/blog/link-building | https://j-curve.co.kr/ja/blog/link-building/ | 404 | — | True |
| HEAD | /ja/blog/link-building | https://j-curve.co.kr/ja/blog/link-building/ | 404 | — | True |
| GET | /ja/blog/link-building// | https://j-curve.co.kr/ja/blog/link-building/ | 404 | — | True |
| HEAD | /ja/blog/link-building// | https://j-curve.co.kr/ja/blog/link-building/ | 404 | — | True |
| GET | /ja/services/seo | https://j-curve.co.kr/ja/seo/ | 404 | — | True |
| HEAD | /ja/services/seo | https://j-curve.co.kr/ja/seo/ | 404 | — | True |
| GET | /ja/seo | https://j-curve.co.kr/ja/seo/ | 404 | — | True |
| HEAD | /ja/seo | https://j-curve.co.kr/ja/seo/ | 404 | — | True |
| GET | /ja/seo// | https://j-curve.co.kr/ja/seo/ | 404 | — | True |
| HEAD | /ja/seo// | https://j-curve.co.kr/ja/seo/ | 404 | — | True |
| GET | /ja/services/seo/backlinks | https://j-curve.co.kr/ja/seo-backlinks/ | 404 | — | True |
| HEAD | /ja/services/seo/backlinks | https://j-curve.co.kr/ja/seo-backlinks/ | 404 | — | True |
| GET | /ja/seo-backlinks | https://j-curve.co.kr/ja/seo-backlinks/ | 404 | — | True |
| HEAD | /ja/seo-backlinks | https://j-curve.co.kr/ja/seo-backlinks/ | 404 | — | True |
| GET | /ja/seo-backlinks// | https://j-curve.co.kr/ja/seo-backlinks/ | 404 | — | True |
| HEAD | /ja/seo-backlinks// | https://j-curve.co.kr/ja/seo-backlinks/ | 404 | — | True |
| GET | /ja/services/wordpress | https://j-curve.co.kr/ja/wordpress-agency/ | 404 | — | True |
| HEAD | /ja/services/wordpress | https://j-curve.co.kr/ja/wordpress-agency/ | 404 | — | True |
| GET | /ja/wordpress-agency | https://j-curve.co.kr/ja/wordpress-agency/ | 404 | — | True |
| HEAD | /ja/wordpress-agency | https://j-curve.co.kr/ja/wordpress-agency/ | 404 | — | True |
| GET | /ja/wordpress-agency// | https://j-curve.co.kr/ja/wordpress-agency/ | 404 | — | True |
| HEAD | /ja/wordpress-agency// | https://j-curve.co.kr/ja/wordpress-agency/ | 404 | — | True |
| GET | /ja/services/seo/naver-place | https://j-curve.co.kr/ja/naver-place-marketing/ | 404 | — | True |
| HEAD | /ja/services/seo/naver-place | https://j-curve.co.kr/ja/naver-place-marketing/ | 404 | — | True |
| GET | /ja/naver-place-marketing | https://j-curve.co.kr/ja/naver-place-marketing/ | 404 | — | True |
| HEAD | /ja/naver-place-marketing | https://j-curve.co.kr/ja/naver-place-marketing/ | 404 | — | True |
| GET | /ja/naver-place-marketing// | https://j-curve.co.kr/ja/naver-place-marketing/ | 404 | — | True |
| HEAD | /ja/naver-place-marketing// | https://j-curve.co.kr/ja/naver-place-marketing/ | 404 | — | True |
| GET | /ja/services/seo/naver-shopping | https://j-curve.co.kr/ja/naver-shopping-marketing/ | 404 | — | True |
| HEAD | /ja/services/seo/naver-shopping | https://j-curve.co.kr/ja/naver-shopping-marketing/ | 404 | — | True |
| GET | /ja/naver-shopping-marketing | https://j-curve.co.kr/ja/naver-shopping-marketing/ | 404 | — | True |
| HEAD | /ja/naver-shopping-marketing | https://j-curve.co.kr/ja/naver-shopping-marketing/ | 404 | — | True |
| GET | /ja/naver-shopping-marketing// | https://j-curve.co.kr/ja/naver-shopping-marketing/ | 404 | — | True |
| HEAD | /ja/naver-shopping-marketing// | https://j-curve.co.kr/ja/naver-shopping-marketing/ | 404 | — | True |
| GET | /ja/services/seo/kakao-gift | https://j-curve.co.kr/ja/kakao-gift/ | 404 | — | True |
| HEAD | /ja/services/seo/kakao-gift | https://j-curve.co.kr/ja/kakao-gift/ | 404 | — | True |
| GET | /ja/kakao-gift | https://j-curve.co.kr/ja/kakao-gift/ | 404 | — | True |
| HEAD | /ja/kakao-gift | https://j-curve.co.kr/ja/kakao-gift/ | 404 | — | True |
| GET | /ja/kakao-gift// | https://j-curve.co.kr/ja/kakao-gift/ | 404 | — | True |
| HEAD | /ja/kakao-gift// | https://j-curve.co.kr/ja/kakao-gift/ | 404 | — | True |
| GET | /ja/services/seo/coupang | https://j-curve.co.kr/ja/coupang/ | 404 | — | True |
| HEAD | /ja/services/seo/coupang | https://j-curve.co.kr/ja/coupang/ | 404 | — | True |
| GET | /ja/coupang | https://j-curve.co.kr/ja/coupang/ | 404 | — | True |
| HEAD | /ja/coupang | https://j-curve.co.kr/ja/coupang/ | 404 | — | True |
| GET | /ja/coupang// | https://j-curve.co.kr/ja/coupang/ | 404 | — | True |
| HEAD | /ja/coupang// | https://j-curve.co.kr/ja/coupang/ | 404 | — | True |
| GET | /ja | https://j-curve.co.kr/ja/ | 200 | — | True |
| HEAD | /ja | https://j-curve.co.kr/ja/ | 200 | — | True |
| GET | /ja/privacy/ | https://j-curve.co.kr/ja/privacy | 404 | — | True |
| HEAD | /ja/privacy/ | https://j-curve.co.kr/ja/privacy | 404 | — | True |
| GET | /ja/support/faq/ | https://j-curve.co.kr/ja/support/faq | 404 | — | True |
| HEAD | /ja/support/faq/ | https://j-curve.co.kr/ja/support/faq | 404 | — | True |
| GET | /ja/services/ | https://j-curve.co.kr/ja/services | 404 | — | True |
| HEAD | /ja/services/ | https://j-curve.co.kr/ja/services | 404 | — | True |
| GET | /ja/services/performance-marketing/ | https://j-curve.co.kr/ja/services/performance-marketing | 404 | — | True |
| HEAD | /ja/services/performance-marketing/ | https://j-curve.co.kr/ja/services/performance-marketing | 404 | — | True |
| GET | /ja/services/cpa-marketing/ | https://j-curve.co.kr/ja/services/cpa-marketing | 404 | — | True |
| HEAD | /ja/services/cpa-marketing/ | https://j-curve.co.kr/ja/services/cpa-marketing | 404 | — | True |
| GET | /ja/services/reward-network/ | https://j-curve.co.kr/ja/services/reward-network | 404 | — | True |
| HEAD | /ja/services/reward-network/ | https://j-curve.co.kr/ja/services/reward-network | 404 | — | True |
| GET | /ja/services/seo/aeo/ | https://j-curve.co.kr/ja/services/seo/aeo | 404 | — | True |
| HEAD | /ja/services/seo/aeo/ | https://j-curve.co.kr/ja/services/seo/aeo | 404 | — | True |
| GET | /ja/services/seo/geo/ | https://j-curve.co.kr/ja/services/seo/geo | 404 | — | True |
| HEAD | /ja/services/seo/geo/ | https://j-curve.co.kr/ja/services/seo/geo | 404 | — | True |
| GET | /ja/services/cpa-marketing/real-estate/ | https://j-curve.co.kr/ja/services/cpa-marketing/real-estate | 404 | — | True |
| HEAD | /ja/services/cpa-marketing/real-estate/ | https://j-curve.co.kr/ja/services/cpa-marketing/real-estate | 404 | — | True |
| GET | /ja/services/cpa-marketing/stock/ | https://j-curve.co.kr/ja/services/cpa-marketing/stock | 404 | — | True |
| HEAD | /ja/services/cpa-marketing/stock/ | https://j-curve.co.kr/ja/services/cpa-marketing/stock | 404 | — | True |
| GET | /ja/services/cpa-marketing/insurance/ | https://j-curve.co.kr/ja/services/cpa-marketing/insurance | 404 | — | True |
| HEAD | /ja/services/cpa-marketing/insurance/ | https://j-curve.co.kr/ja/services/cpa-marketing/insurance | 404 | — | True |
| GET | /ja/services/cpa-marketing/coin/ | https://j-curve.co.kr/ja/services/cpa-marketing/coin | 404 | — | True |
| HEAD | /ja/services/cpa-marketing/coin/ | https://j-curve.co.kr/ja/services/cpa-marketing/coin | 404 | — | True |
| GET | /ja/services/cpa-marketing/permission-call/ | https://j-curve.co.kr/ja/services/cpa-marketing/permission-call | 404 | — | True |
| HEAD | /ja/services/cpa-marketing/permission-call/ | https://j-curve.co.kr/ja/services/cpa-marketing/permission-call | 404 | — | True |
| GET | /ja/services/performance-marketing/naver-gfa/ | https://j-curve.co.kr/ja/services/performance-marketing/naver-gfa | 404 | — | True |
| HEAD | /ja/services/performance-marketing/naver-gfa/ | https://j-curve.co.kr/ja/services/performance-marketing/naver-gfa | 404 | — | True |
| GET | /ja/services/performance-marketing/facebook/ | https://j-curve.co.kr/ja/services/performance-marketing/facebook | 404 | — | True |
| HEAD | /ja/services/performance-marketing/facebook/ | https://j-curve.co.kr/ja/services/performance-marketing/facebook | 404 | — | True |
| GET | /ja/services/performance-marketing/youtube/ | https://j-curve.co.kr/ja/services/performance-marketing/youtube | 404 | — | True |
| HEAD | /ja/services/performance-marketing/youtube/ | https://j-curve.co.kr/ja/services/performance-marketing/youtube | 404 | — | True |
| GET | /ja/services/marketing-support/ | https://j-curve.co.kr/ja/services/marketing-support | 404 | — | True |
| HEAD | /ja/services/marketing-support/ | https://j-curve.co.kr/ja/services/marketing-support | 404 | — | True |
| GET | /ja/solutions/ | https://j-curve.co.kr/ja/solutions | 404 | — | True |
| HEAD | /ja/solutions/ | https://j-curve.co.kr/ja/solutions | 404 | — | True |
| GET | /ja/solutions/rankfree/ | https://j-curve.co.kr/ja/solutions/rankfree | 404 | — | True |
| HEAD | /ja/solutions/rankfree/ | https://j-curve.co.kr/ja/solutions/rankfree | 404 | — | True |
| GET | /ja/solutions/boostingshop/ | https://j-curve.co.kr/ja/solutions/boostingshop | 404 | — | True |
| HEAD | /ja/solutions/boostingshop/ | https://j-curve.co.kr/ja/solutions/boostingshop | 404 | — | True |
| GET | /ja/solutions/shopitrend/ | https://j-curve.co.kr/ja/solutions/shopitrend | 404 | — | True |
| HEAD | /ja/solutions/shopitrend/ | https://j-curve.co.kr/ja/solutions/shopitrend | 404 | — | True |
| GET | /ja/solutions/leadbay/ | https://j-curve.co.kr/ja/solutions/leadbay | 404 | — | True |
| HEAD | /ja/solutions/leadbay/ | https://j-curve.co.kr/ja/solutions/leadbay | 404 | — | True |
| GET | /ja/solutions/call2sale/ | https://j-curve.co.kr/ja/solutions/call2sale | 404 | — | True |
| HEAD | /ja/solutions/call2sale/ | https://j-curve.co.kr/ja/solutions/call2sale | 404 | — | True |
| GET | /ja/solutions/boostingshop/basic/ | https://j-curve.co.kr/ja/solutions/boostingshop/basic | 404 | — | True |
| HEAD | /ja/solutions/boostingshop/basic/ | https://j-curve.co.kr/ja/solutions/boostingshop/basic | 404 | — | True |
| GET | /ja/solutions/boostingshop/pro/ | https://j-curve.co.kr/ja/solutions/boostingshop/pro | 404 | — | True |
| HEAD | /ja/solutions/boostingshop/pro/ | https://j-curve.co.kr/ja/solutions/boostingshop/pro | 404 | — | True |
| GET | /ja/solutions/boostingshop/elite/ | https://j-curve.co.kr/ja/solutions/boostingshop/elite | 404 | — | True |
| HEAD | /ja/solutions/boostingshop/elite/ | https://j-curve.co.kr/ja/solutions/boostingshop/elite | 404 | — | True |
| GET | /ja/solutions/boostingshop/instagram-popular/ | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-popular | 404 | — | True |
| HEAD | /ja/solutions/boostingshop/instagram-popular/ | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-popular | 404 | — | True |
| GET | /ja/solutions/boostingshop/instagram-followers/ | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-followers | 404 | — | True |
| HEAD | /ja/solutions/boostingshop/instagram-followers/ | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-followers | 404 | — | True |
| GET | /ja/solutions/boostingshop/instagram-likes/ | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-likes | 404 | — | True |
| HEAD | /ja/solutions/boostingshop/instagram-likes/ | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-likes | 404 | — | True |
| GET | /ja/self-marketing/ | https://j-curve.co.kr/ja/self-marketing | 404 | — | True |
| HEAD | /ja/self-marketing/ | https://j-curve.co.kr/ja/self-marketing | 404 | — | True |
| GET | /ja/self-marketing/place/ | https://j-curve.co.kr/ja/self-marketing/place | 404 | — | True |
| HEAD | /ja/self-marketing/place/ | https://j-curve.co.kr/ja/self-marketing/place | 404 | — | True |
| GET | /ja/work/ | https://j-curve.co.kr/ja/work | 404 | — | True |
| HEAD | /ja/work/ | https://j-curve.co.kr/ja/work | 404 | — | True |

### V3 워드프레스·PHP·v1 등 레거시 별칭 실제 동작

기본시더의 LegacyRedirect191행 × EN/JA=382회. 301 118·404 264. 레거시는 보고 대상이며 아래는 자동 follow 전 실제 Location이다.

| 요청 | 상태 | Location |
| --- | --- | --- |
| /en/shop | 301 | https://j-curve.co.kr/en/solutions/boostingshop |
| /en/shop/backlinks/seo-캠페인-베이직 | 301 | https://j-curve.co.kr/en/solutions/boostingshop/basic |
| /en/shop/backlinks/seo-캠페인-프로 | 301 | https://j-curve.co.kr/en/solutions/boostingshop/pro |
| /en/shop/backlinks/seo-캠페인-엘리트 | 301 | https://j-curve.co.kr/en/solutions/boostingshop/elite |
| /en/log-in | 404 | — |
| /en/join | 404 | — |
| /en/recover-password | 404 | — |
| /en/my-account | 404 | — |
| /en/cart | 301 | https://j-curve.co.kr/en/solutions/boostingshop |
| /en/checkout | 301 | https://j-curve.co.kr/en/solutions/boostingshop |
| /en/cpa.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing |
| /en/land.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing/real-estate |
| /en/stock.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing/stock |
| /en/insurance.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing/insurance |
| /en/coin.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing/coin |
| /en/permission.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing/permission-call |
| /en/gfa.php | 301 | https://j-curve.co.kr/en/services/performance-marketing/naver-gfa |
| /en/facebook.php | 301 | https://j-curve.co.kr/en/services/performance-marketing/facebook |
| /en/youtube.php | 301 | https://j-curve.co.kr/en/services/performance-marketing/youtube |
| /en/instagram.php | 301 | https://j-curve.co.kr/en/solutions/boostingshop/instagram-popular |
| /en/followers_up.php | 301 | https://j-curve.co.kr/en/solutions/boostingshop/instagram-followers |
| /en/instagram_likes.php | 301 | https://j-curve.co.kr/en/solutions/boostingshop/instagram-likes |
| /en/shopping_marketing.php | 301 | https://j-curve.co.kr/en/naver-shopping-marketing/ |
| /en/shopping_smartstore.php | 301 | https://j-curve.co.kr/en/naver-shopping-marketing/ |
| /en/marketing-support-project.php | 301 | https://j-curve.co.kr/en/services/marketing-support |
| /en/contact.php | 301 | https://j-curve.co.kr/en/contact-us/ |
| /en/v1 | 301 | https://j-curve.co.kr/en/ |
| /en/v1/company.php | 301 | https://j-curve.co.kr/en/about-us/ |
| /en/v1/policy.php | 301 | https://j-curve.co.kr/en/privacy |
| /en/v1/contact.php | 301 | https://j-curve.co.kr/en/contact-us/ |
| /en/v1/portfolio.php | 301 | https://j-curve.co.kr/en/work |
| /en/v1/ad_campaign.php | 301 | https://j-curve.co.kr/en/work |
| /en/v1/insurance.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing/insurance |
| /en/v1/cpa.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing |
| /en/v1/land.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing/real-estate |
| /en/v1/stock.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing/stock |
| /en/v1/coin.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing/coin |
| /en/v1/permission.php | 301 | https://j-curve.co.kr/en/services/cpa-marketing/permission-call |
| /en/v1/gfa.php | 301 | https://j-curve.co.kr/en/services/performance-marketing/naver-gfa |
| /en/v1/facebook.php | 301 | https://j-curve.co.kr/en/services/performance-marketing/facebook |
| /en/v1/youtube.php | 301 | https://j-curve.co.kr/en/services/performance-marketing/youtube |
| /en/v1/instagram.php | 301 | https://j-curve.co.kr/en/solutions/boostingshop/instagram-popular |
| /en/v1/followers_up.php | 301 | https://j-curve.co.kr/en/solutions/boostingshop/instagram-followers |
| /en/v1/instagram_likes.php | 301 | https://j-curve.co.kr/en/solutions/boostingshop/instagram-likes |
| /en/v1/shopping_marketing.php | 301 | https://j-curve.co.kr/en/naver-shopping-marketing/ |
| /en/v1/shopping_smartstore.php | 301 | https://j-curve.co.kr/en/naver-shopping-marketing/ |
| /en/v1/marketing-support-project.php | 301 | https://j-curve.co.kr/en/services/marketing-support |
| /en/portfolio-items | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/cras-mollis-nons | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/enim-pellentesque | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/donec-et-sagittis | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/tras-commodo-ets | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/proin-tortor-orcus | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/class-et-aptent | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/iaculis-eu-gigni | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/donec-magna-velit | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/varius-lectus-ulla | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/duis-imperdiet-malis | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/non-mattis-tortor | 301 | https://j-curve.co.kr/en/work |
| /en/portfolio-items/faucibus-tellus | 301 | https://j-curve.co.kr/en/work |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id= | 301 | https://j-curve.co.kr/en/blog/?bo_table=column&wr_id= |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=19 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=21 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=29 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=38 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=47 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=52 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=56 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=58 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=59 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=60 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=61 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=62 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=63 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=64 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=65 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=66 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=67 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=68 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=69 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=70 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=71 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=72 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=73 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=74 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=75 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=76 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=77 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=78 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=79 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=80 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=1 | 301 | https://j-curve.co.kr/en/insights/mobile-marketing-strategies?bo_table=column&wr_id=1 |
| /en/v1/manager/column/반드시-알아야-할-모바일-마케팅-전략-5가지 | 301 | https://j-curve.co.kr/en/insights/mobile-marketing-strategies |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=2 | 404 | — |
| /en/v1/manager/column/2019년-인플루언서마케팅-핵심-트렌드 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=3 | 404 | — |
| /en/v1/manager/column/2019년-필요한-유튜브마케팅-전략 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=4 | 404 | — |
| /en/v1/manager/column/페이스북광고-게재-옵션과-노출-위치-설정은-어떻게 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=5 | 404 | — |
| /en/v1/manager/column/페이스북-광고관리자로-캠페인-세팅하기 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=6 | 404 | — |
| /en/v1/manager/column/인스타그램마케팅-인스타그램쇼핑-가이드 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=7 | 404 | — |
| /en/v1/manager/column/디지털마케터의-역할-인바운드-마케팅과-디지털-마케팅 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=8 | 404 | — |
| /en/v1/manager/column/디지털마케팅-기초적인-개념과-용어-정리 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=9 | 404 | — |
| /en/v1/manager/column/페이스북-광고-계정-설정-방법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=10 | 404 | — |
| /en/v1/manager/column/페이스북-광고-보고서를-통한-캠페인-최적화 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=11 | 404 | — |
| /en/v1/manager/column/구글광고-맞춤-타겟-설정-방법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=12 | 404 | — |
| /en/v1/manager/column/구글-광고-통화-전환-추적방법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=13 | 404 | — |
| /en/v1/manager/column/2019년-그로스해커에게-필요한-스킬1 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=14 | 404 | — |
| /en/v1/manager/column/2019년-그로스해커에게-필요한-스킬2-1 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=15 | 404 | — |
| /en/v1/manager/column/2019년-그로스해커에게-필요한-스킬3-1 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=16 | 404 | — |
| /en/v1/manager/column/2019년-그로스해커에게-필요한-스킬3 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=17 | 404 | — |
| /en/v1/manager/column/페이스북광고-입찰-최적화-방법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=18 | 404 | — |
| /en/v1/manager/column/페이스북광고-ab테스트-가이드 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=20 | 404 | — |
| /en/v1/manager/column/페이스북-마케팅-실전-기법-전략-수립-7단계 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=22 | 404 | — |
| /en/v1/manager/column/페이스북마케팅-광고-소재와-문구는-어떻게 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=23 | 404 | — |
| /en/v1/manager/column/구글광고-보고서에서-중요한-지표는 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=24 | 404 | — |
| /en/v1/manager/column/조회수를-극대화하기-위해-유튜브-채널을-홍보하는-방법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=25 | 404 | — |
| /en/v1/manager/column/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=26 | 404 | — |
| /en/v1/manager/column/구글-광고-계정-설정-방법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=27 | 404 | — |
| /en/v1/manager/column/구글-광고-세팅-시간을-줄이는-법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=28 | 404 | — |
| /en/v1/manager/column/구글-광고-전환에-최적화된-랜딩페이지-제작-방법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=30 | 404 | — |
| /en/v1/manager/column/콘텐츠-마케팅-전략-7단계 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=31 | 404 | — |
| /en/v1/manager/column/구글애널리틱스를-통한-구매-및-전환-추적 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=32 | 404 | — |
| /en/v1/manager/column/페이스북-광고-테스트가-꼭-필요한-이유 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=33 | 404 | — |
| /en/v1/manager/column/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=34 | 404 | — |
| /en/v1/manager/column/인스타그램-마케팅에-대한-뜬소문들 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=35 | 404 | — |
| /en/v1/manager/column/인스타그램-스토리-광고의-특별한-점은 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=36 | 404 | — |
| /en/v1/manager/column/인스타그램-광고-실행-및-관리-방법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=37 | 404 | — |
| /en/v1/manager/column/페이스북-광고-목적에-최적화된-유형-선택이-중요 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=39 | 404 | — |
| /en/v1/manager/column/스마트스토어-검색광고가-꼭-필요할까 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=40 | 404 | — |
| /en/v1/manager/column/스마트스토어-내게-맞는-키워드-발굴하는-법 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=41 | 404 | — |
| /en/v1/manager/column/cpa-광고-마케팅-대행사-선정-시-꼭-알아야 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=42 | 404 | — |
| /en/v1/manager/column/주식-cpa-대행사-퍼미션-db-마케팅은-제이커브로 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=43 | 404 | — |
| /en/v1/manager/column/퍼미션-마케팅-어떻게-해야-제대로-할-수-있을까 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=44 | 404 | — |
| /en/v1/manager/column/마케팅-퍼널이란-무엇인가-1 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=45 | 404 | — |
| /en/v1/manager/column/마이인플루언서-론칭 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=46 | 404 | — |
| /en/v1/manager/column/유튜브까지-섭렵한-마케팅-전문가집단-제이커브인터렉티브 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=48 | 404 | — |
| /en/v1/manager/column/제이커브인터렉티브-기업부설연구소-설립 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=49 | 404 | — |
| /en/v1/manager/column/제이커브인터렉티브-고객관리-프로그램-crmpro-개발 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=50 | 404 | — |
| /en/v1/manager/column/구글-광고-이렇게-해보세요 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=51 | 404 | — |
| /en/v1/manager/column/온라인-마케팅-제대로-배울-수-있는-아나키-강의 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=53 | 404 | — |
| /en/v1/manager/column/제이커브인터렉티브-자사-브랜드-nobb-상표등록-완료 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=54 | 404 | — |
| /en/v1/manager/column/제이커브인터렉티브-혁신성장형-벤처기업인증획득 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=55 | 404 | — |
| /en/v1/manager/column/디지털-마케팅에서-꼭-알아야-할-핵심-공식-12가지 | 404 | — |
| /en/v1/manager/bbs/board.php?bo_table=column&wr_id=57 | 404 | — |
| /en/v1/manager/column/인스타그램-인기게시물-노출을-위한-알고리즘-이해 | 404 | — |
| /ja/shop | 301 | https://j-curve.co.kr/ja/solutions/boostingshop |
| /ja/shop/backlinks/seo-캠페인-베이직 | 301 | https://j-curve.co.kr/ja/solutions/boostingshop/basic |
| /ja/shop/backlinks/seo-캠페인-프로 | 301 | https://j-curve.co.kr/ja/solutions/boostingshop/pro |
| /ja/shop/backlinks/seo-캠페인-엘리트 | 301 | https://j-curve.co.kr/ja/solutions/boostingshop/elite |
| /ja/log-in | 404 | — |
| /ja/join | 404 | — |
| /ja/recover-password | 404 | — |
| /ja/my-account | 404 | — |
| /ja/cart | 301 | https://j-curve.co.kr/ja/solutions/boostingshop |

### V3 레거시 목록(계속)

기본시더의 LegacyRedirect191행 × EN/JA=382회. 301 118·404 264. 레거시는 보고 대상이며 아래는 자동 follow 전 실제 Location이다.

| 요청 | 상태 | Location |
| --- | --- | --- |
| /ja/checkout | 301 | https://j-curve.co.kr/ja/solutions/boostingshop |
| /ja/cpa.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing |
| /ja/land.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing/real-estate |
| /ja/stock.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing/stock |
| /ja/insurance.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing/insurance |
| /ja/coin.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing/coin |
| /ja/permission.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing/permission-call |
| /ja/gfa.php | 301 | https://j-curve.co.kr/ja/services/performance-marketing/naver-gfa |
| /ja/facebook.php | 301 | https://j-curve.co.kr/ja/services/performance-marketing/facebook |
| /ja/youtube.php | 301 | https://j-curve.co.kr/ja/services/performance-marketing/youtube |
| /ja/instagram.php | 301 | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-popular |
| /ja/followers_up.php | 301 | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-followers |
| /ja/instagram_likes.php | 301 | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-likes |
| /ja/shopping_marketing.php | 301 | https://j-curve.co.kr/ja/naver-shopping-marketing/ |
| /ja/shopping_smartstore.php | 301 | https://j-curve.co.kr/ja/naver-shopping-marketing/ |
| /ja/marketing-support-project.php | 301 | https://j-curve.co.kr/ja/services/marketing-support |
| /ja/contact.php | 301 | https://j-curve.co.kr/ja/contact-us/ |
| /ja/v1 | 301 | https://j-curve.co.kr/ja/ |
| /ja/v1/company.php | 301 | https://j-curve.co.kr/ja/about-us/ |
| /ja/v1/policy.php | 301 | https://j-curve.co.kr/ja/privacy |
| /ja/v1/contact.php | 301 | https://j-curve.co.kr/ja/contact-us/ |
| /ja/v1/portfolio.php | 301 | https://j-curve.co.kr/ja/work |
| /ja/v1/ad_campaign.php | 301 | https://j-curve.co.kr/ja/work |
| /ja/v1/insurance.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing/insurance |
| /ja/v1/cpa.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing |
| /ja/v1/land.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing/real-estate |
| /ja/v1/stock.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing/stock |
| /ja/v1/coin.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing/coin |
| /ja/v1/permission.php | 301 | https://j-curve.co.kr/ja/services/cpa-marketing/permission-call |
| /ja/v1/gfa.php | 301 | https://j-curve.co.kr/ja/services/performance-marketing/naver-gfa |
| /ja/v1/facebook.php | 301 | https://j-curve.co.kr/ja/services/performance-marketing/facebook |
| /ja/v1/youtube.php | 301 | https://j-curve.co.kr/ja/services/performance-marketing/youtube |
| /ja/v1/instagram.php | 301 | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-popular |
| /ja/v1/followers_up.php | 301 | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-followers |
| /ja/v1/instagram_likes.php | 301 | https://j-curve.co.kr/ja/solutions/boostingshop/instagram-likes |
| /ja/v1/shopping_marketing.php | 301 | https://j-curve.co.kr/ja/naver-shopping-marketing/ |
| /ja/v1/shopping_smartstore.php | 301 | https://j-curve.co.kr/ja/naver-shopping-marketing/ |
| /ja/v1/marketing-support-project.php | 301 | https://j-curve.co.kr/ja/services/marketing-support |
| /ja/portfolio-items | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/cras-mollis-nons | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/enim-pellentesque | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/donec-et-sagittis | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/tras-commodo-ets | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/proin-tortor-orcus | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/class-et-aptent | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/iaculis-eu-gigni | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/donec-magna-velit | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/varius-lectus-ulla | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/duis-imperdiet-malis | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/non-mattis-tortor | 301 | https://j-curve.co.kr/ja/work |
| /ja/portfolio-items/faucibus-tellus | 301 | https://j-curve.co.kr/ja/work |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id= | 301 | https://j-curve.co.kr/ja/blog/?bo_table=column&wr_id= |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=19 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=21 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=29 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=38 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=47 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=52 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=56 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=58 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=59 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=60 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=61 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=62 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=63 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=64 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=65 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=66 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=67 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=68 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=69 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=70 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=71 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=72 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=73 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=74 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=75 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=76 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=77 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=78 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=79 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=80 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=1 | 301 | https://j-curve.co.kr/ja/insights/mobile-marketing-strategies-ja?bo_table=column&wr_id=1 |
| /ja/v1/manager/column/반드시-알아야-할-모바일-마케팅-전략-5가지 | 301 | https://j-curve.co.kr/ja/insights/mobile-marketing-strategies-ja |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=2 | 404 | — |
| /ja/v1/manager/column/2019년-인플루언서마케팅-핵심-트렌드 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=3 | 404 | — |
| /ja/v1/manager/column/2019년-필요한-유튜브마케팅-전략 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=4 | 404 | — |
| /ja/v1/manager/column/페이스북광고-게재-옵션과-노출-위치-설정은-어떻게 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=5 | 404 | — |
| /ja/v1/manager/column/페이스북-광고관리자로-캠페인-세팅하기 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=6 | 404 | — |
| /ja/v1/manager/column/인스타그램마케팅-인스타그램쇼핑-가이드 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=7 | 404 | — |
| /ja/v1/manager/column/디지털마케터의-역할-인바운드-마케팅과-디지털-마케팅 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=8 | 404 | — |
| /ja/v1/manager/column/디지털마케팅-기초적인-개념과-용어-정리 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=9 | 404 | — |
| /ja/v1/manager/column/페이스북-광고-계정-설정-방법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=10 | 404 | — |
| /ja/v1/manager/column/페이스북-광고-보고서를-통한-캠페인-최적화 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=11 | 404 | — |
| /ja/v1/manager/column/구글광고-맞춤-타겟-설정-방법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=12 | 404 | — |
| /ja/v1/manager/column/구글-광고-통화-전환-추적방법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=13 | 404 | — |
| /ja/v1/manager/column/2019년-그로스해커에게-필요한-스킬1 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=14 | 404 | — |
| /ja/v1/manager/column/2019년-그로스해커에게-필요한-스킬2-1 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=15 | 404 | — |
| /ja/v1/manager/column/2019년-그로스해커에게-필요한-스킬3-1 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=16 | 404 | — |
| /ja/v1/manager/column/2019년-그로스해커에게-필요한-스킬3 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=17 | 404 | — |
| /ja/v1/manager/column/페이스북광고-입찰-최적화-방법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=18 | 404 | — |
| /ja/v1/manager/column/페이스북광고-ab테스트-가이드 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=20 | 404 | — |
| /ja/v1/manager/column/페이스북-마케팅-실전-기법-전략-수립-7단계 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=22 | 404 | — |
| /ja/v1/manager/column/페이스북마케팅-광고-소재와-문구는-어떻게 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=23 | 404 | — |
| /ja/v1/manager/column/구글광고-보고서에서-중요한-지표는 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=24 | 404 | — |
| /ja/v1/manager/column/조회수를-극대화하기-위해-유튜브-채널을-홍보하는-방법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=25 | 404 | — |
| /ja/v1/manager/column/성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=26 | 404 | — |
| /ja/v1/manager/column/구글-광고-계정-설정-방법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=27 | 404 | — |
| /ja/v1/manager/column/구글-광고-세팅-시간을-줄이는-법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=28 | 404 | — |
| /ja/v1/manager/column/구글-광고-전환에-최적화된-랜딩페이지-제작-방법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=30 | 404 | — |
| /ja/v1/manager/column/콘텐츠-마케팅-전략-7단계 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=31 | 404 | — |
| /ja/v1/manager/column/구글애널리틱스를-통한-구매-및-전환-추적 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=32 | 404 | — |
| /ja/v1/manager/column/페이스북-광고-테스트가-꼭-필요한-이유 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=33 | 404 | — |
| /ja/v1/manager/column/페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=34 | 404 | — |
| /ja/v1/manager/column/인스타그램-마케팅에-대한-뜬소문들 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=35 | 404 | — |
| /ja/v1/manager/column/인스타그램-스토리-광고의-특별한-점은 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=36 | 404 | — |
| /ja/v1/manager/column/인스타그램-광고-실행-및-관리-방법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=37 | 404 | — |
| /ja/v1/manager/column/페이스북-광고-목적에-최적화된-유형-선택이-중요 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=39 | 404 | — |
| /ja/v1/manager/column/스마트스토어-검색광고가-꼭-필요할까 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=40 | 404 | — |
| /ja/v1/manager/column/스마트스토어-내게-맞는-키워드-발굴하는-법 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=41 | 404 | — |
| /ja/v1/manager/column/cpa-광고-마케팅-대행사-선정-시-꼭-알아야 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=42 | 404 | — |
| /ja/v1/manager/column/주식-cpa-대행사-퍼미션-db-마케팅은-제이커브로 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=43 | 404 | — |
| /ja/v1/manager/column/퍼미션-마케팅-어떻게-해야-제대로-할-수-있을까 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=44 | 404 | — |
| /ja/v1/manager/column/마케팅-퍼널이란-무엇인가-1 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=45 | 404 | — |
| /ja/v1/manager/column/마이인플루언서-론칭 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=46 | 404 | — |
| /ja/v1/manager/column/유튜브까지-섭렵한-마케팅-전문가집단-제이커브인터렉티브 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=48 | 404 | — |
| /ja/v1/manager/column/제이커브인터렉티브-기업부설연구소-설립 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=49 | 404 | — |
| /ja/v1/manager/column/제이커브인터렉티브-고객관리-프로그램-crmpro-개발 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=50 | 404 | — |
| /ja/v1/manager/column/구글-광고-이렇게-해보세요 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=51 | 404 | — |
| /ja/v1/manager/column/온라인-마케팅-제대로-배울-수-있는-아나키-강의 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=53 | 404 | — |
| /ja/v1/manager/column/제이커브인터렉티브-자사-브랜드-nobb-상표등록-완료 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=54 | 404 | — |
| /ja/v1/manager/column/제이커브인터렉티브-혁신성장형-벤처기업인증획득 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=55 | 404 | — |
| /ja/v1/manager/column/디지털-마케팅에서-꼭-알아야-할-핵심-공식-12가지 | 404 | — |
| /ja/v1/manager/bbs/board.php?bo_table=column&wr_id=57 | 404 | — |
| /ja/v1/manager/column/인스타그램-인기게시물-노출을-위한-알고리즘-이해 | 404 | — |

## 5. V4·V7·V8 — 독립 공격 검사

별도 `/private/tmp/VerifyIntlIndependentTest.php` 6테스트, 80assertions. 저장소의 테스트 파일은 추가·수정하지 않았다. 세팅은 임시 SQLite `independent.sqlite`, 별도 compiled-view 폴더. `APP_LOCALE=ko`, `URL::forceRootUrl/forceScheme`으로 테스트 URL을 지정했다. 첫 probe 작성 시 테스트 기본 localhost/locale=en을 잘못 가정해 assertion 실패가 있었고, 요청·환경을 정정 후 아래 최종본에서 통과했다. 제품 결함으로 세지 않았다.

V4 실제 번역 상세는 먼저404 확인 후, `View::getFinder()->prependLocation('/private/tmp/verify-intl-views')`로 임시3뷰만 제공해 컨트롤러를 격리했다. 따라서 probe의200은 실제 사이트 상세 화면의200이 아니다. 실제 미구현 위치는 `app/Http/Controllers/InsightController.php:91`→`app/Support/intl.php:27-33`의 뷰 없음404이다. 한국어 글 복제13편·EN번역13행을 임시DB에 만들어 page2에2행과 EN page2 URL을 확인했다.

V7 이름·메시지에 `<script>`를 넣고 body locale=ko/xx로 EN·JA·KO 각2회 접수했다. 저장 locale은 주소를 따랐다(`ContactController.php:86`). CSRF 실험은 Laravel의 unit-test 우회를 해제하려고 해당 요청 동안 app env를 local로 바꿔 실제419를 재현했다. Honeypot과 미래 타이머는200 빈 응답 및 DB증가0, 정상6회는 양 언어 모두302×5→429. 검증 메시지는 그 언어이고 redirect는 그 언어 문의 경로였다.

재표시 이스케이프는 실제 `intl.contact`가 없어서 검사하지 못했다(`ContactController.php:52`). 임시 안전한 폼을 만들어 ‘이스케이프 PASS’로 가장하지 않았다.

V8 동일 앱에서 cookie locale=ja/session locale=en을 넣고 EN→KO→JA→KO를 실행, 주소 언어만 적용되고 끝난 app locale은ko였다. 실제 출력:

```text
$ php vendor/phpunit/phpunit/phpunit --colors=never --debug /private/tmp/VerifyIntlIndependentTest.php
PHPUnit Started (PHPUnit 12.5.33 using PHP 8.5.8 (cli) on Darwin)
Test Runner Configured
Bootstrap Finished (/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/vendor/autoload.php)
Event Facade Sealed
Test Suite Loaded (6 tests)
Test Runner Started
Test Suite Sorted
Test Runner Execution Started (6 tests)
Test Suite Started (VerifyIntlIndependentTest, 6 tests)
Test Preparation Started (VerifyIntlIndependentTest::test_v4_controller_filters_and_real_pagination_urls)
Before Test Method Called (VerifyIntlIndependentTest::setUp)
Before Test Method Finished:
- VerifyIntlIndependentTest::setUp
Test Prepared (VerifyIntlIndependentTest::test_v4_controller_filters_and_real_pagination_urls)
After Test Method Called (VerifyIntlIndependentTest::tearDown)
After Test Method Finished:
- VerifyIntlIndependentTest::tearDown
Test Passed (VerifyIntlIndependentTest::test_v4_controller_filters_and_real_pagination_urls)
Test Printed Unexpected Output

V4 actual translated detail status=404
V4 probe views: translated=200 missing/hidden/future=404 category-with=200 category-without=404 page2=https://j-curve.co.kr/en/blog/?page=2 items=2

Test Finished (VerifyIntlIndependentTest::test_v4_controller_filters_and_real_pagination_urls)
Test Preparation Started (VerifyIntlIndependentTest::test_v7_locale_spoof_validation_and_xss_storage)
Before Test Method Called (VerifyIntlIndependentTest::setUp)
Before Test Method Finished:
- VerifyIntlIndependentTest::setUp
Test Prepared (VerifyIntlIndependentTest::test_v7_locale_spoof_validation_and_xss_storage)
After Test Method Called (VerifyIntlIndependentTest::tearDown)
After Test Method Finished:
- VerifyIntlIndependentTest::tearDown
Test Passed (VerifyIntlIndependentTest::test_v7_locale_spoof_validation_and_xss_storage)
Test Printed Unexpected Output

V7 POST /en/contact-us/ body.locale=ko stored.locale='en'

V7 POST /en/contact-us/ body.locale=xx stored.locale='en'

V7 POST /ja/contact-us/ body.locale=ko stored.locale='ja'

V7 POST /ja/contact-us/ body.locale=xx stored.locale='ja'

V7 POST /contact-us/ body.locale=ko stored.locale=NULL

V7 POST /contact-us/ body.locale=xx stored.locale=NULL
V7 validation en=The name field is required. redirect=/en/contact-us/
V7 validation ja=お名前は必須です。 redirect=/ja/contact-us/
V7 XSS redisplay NOT VERIFIED: actual foreign contact views return 404

Test Finished (VerifyIntlIndependentTest::test_v7_locale_spoof_validation_and_xss_storage)
Test Preparation Started (VerifyIntlIndependentTest::test_v7_csrf_honeypot_timer_and_throttle_actually_execute)
Before Test Method Called (VerifyIntlIndependentTest::setUp)
Before Test Method Finished:
- VerifyIntlIndependentTest::setUp
Test Prepared (VerifyIntlIndependentTest::test_v7_csrf_honeypot_timer_and_throttle_actually_execute)
After Test Method Called (VerifyIntlIndependentTest::tearDown)
After Test Method Finished:
- VerifyIntlIndependentTest::tearDown
Test Passed (VerifyIntlIndependentTest::test_v7_csrf_honeypot_timer_and_throttle_actually_execute)
Test Printed Unexpected Output

V7 en missing-CSRF=419
V7 en honeypot=200 lead_delta=0
V7 en future-timer=200 lead_delta=0
V7 en throttle=[302,302,302,302,302,429]

V7 ja missing-CSRF=419
V7 ja honeypot=200 lead_delta=0
V7 ja future-timer=200 lead_delta=0
V7 ja throttle=[302,302,302,302,302,429]

Test Finished (VerifyIntlIndependentTest::test_v7_csrf_honeypot_timer_and_throttle_actually_execute)
Test Preparation Started (VerifyIntlIndependentTest::test_v8_single_application_cookie_session_does_not_choose_language)
Before Test Method Called (VerifyIntlIndependentTest::setUp)
Before Test Method Finished:
- VerifyIntlIndependentTest::setUp
Test Prepared (VerifyIntlIndependentTest::test_v8_single_application_cookie_session_does_not_choose_language)
After Test Method Called (VerifyIntlIndependentTest::tearDown)
After Test Method Finished:
- VerifyIntlIndependentTest::tearDown
Test Passed (VerifyIntlIndependentTest::test_v8_single_application_cookie_session_does_not_choose_language)
Test Printed Unexpected Output

V8 /en/ html.lang=en app.locale.after=ko session.locale=en cookie.locale=ja

V8 / html.lang=ko app.locale.after=ko session.locale=en cookie.locale=ja

V8 /ja/ html.lang=ja app.locale.after=ko session.locale=en cookie.locale=ja

V8 /about-us/ html.lang=ko app.locale.after=ko session.locale=en cookie.locale=ja

Test Finished (VerifyIntlIndependentTest::test_v8_single_application_cookie_session_does_not_choose_language)
Test Preparation Started (VerifyIntlIndependentTest::test_v9_idempotence_stale_missing_source_and_cascade)
Before Test Method Called (VerifyIntlIndependentTest::setUp)
Before Test Method Finished:
- VerifyIntlIndependentTest::setUp
Test Prepared (VerifyIntlIndependentTest::test_v9_idempotence_stale_missing_source_and_cascade)
After Test Method Called (VerifyIntlIndependentTest::tearDown)
After Test Method Finished:
- VerifyIntlIndependentTest::tearDown
Test Passed (VerifyIntlIndependentTest::test_v9_idempotence_stale_missing_source_and_cascade)
Test Printed Unexpected Output

V9 seeder twice identical rows=2
V9 stale=0 -> content changed -> stale=2; delete -> translations=0; missing ko_slug warning observed

Test Finished (VerifyIntlIndependentTest::test_v9_idempotence_stale_missing_source_and_cascade)
Test Preparation Started (VerifyIntlIndependentTest::test_v9_rollback_down_and_remigrate)
Before Test Method Called (VerifyIntlIndependentTest::setUp)
Before Test Method Finished:
- VerifyIntlIndependentTest::setUp
Test Prepared (VerifyIntlIndependentTest::test_v9_rollback_down_and_remigrate)
After Test Method Called (VerifyIntlIndependentTest::tearDown)
After Test Method Finished:
- VerifyIntlIndependentTest::tearDown
Test Passed (VerifyIntlIndependentTest::test_v9_rollback_down_and_remigrate)
Test Printed Unexpected Output

V9 rollback down: translations table=false leads.locale=false; migrate: both=true

Test Finished (VerifyIntlIndependentTest::test_v9_rollback_down_and_remigrate)
After Last Test Method Called (VerifyIntlIndependentTest::tearDownAfterClass)
After Last Test Method Finished:
- VerifyIntlIndependentTest::tearDownAfterClass
Test Suite Finished (VerifyIntlIndependentTest, 6 tests)
Test Runner Execution Finished
Test Runner Finished
PHPUnit Finished (Shell Exit Code: 0)
{"tool":"phpunit","result":"passed","tests":6,"passed":6,"assertions":80,"duration_ms":3268}

EXIT=0
```

또한 일반 HTTP Kernel에서 같은 순서를 다시 요청한 결과:

```json
[
  {
    "path": "/en/",
    "status": 200,
    "html_lang": "en",
    "app_locale_after": "ko",
    "normalized_html_sha256": "7f669f14cd0f429eac4374b8af4e327681f68b9ef1da452fbacfc3dc44bc5594",
    "set_cookie": [
      "XSRF-TOKEN",
      "laravel-session"
    ]
  },
  {
    "path": "/",
    "status": 200,
    "html_lang": "ko",
    "app_locale_after": "ko",
    "normalized_html_sha256": "6c8152b0b62e8fe81c97863f8d5b330525c05f256caa2358df2e4cd80f03c885",
    "set_cookie": [
      "XSRF-TOKEN",
      "laravel-session"
    ]
  },
  {
    "path": "/ja/",
    "status": 200,
    "html_lang": "ja",
    "app_locale_after": "ko",
    "normalized_html_sha256": "75efbe0854dcc36f0771149e90d84ed663c569bcd1175cefe32c153422777a51",
    "set_cookie": [
      "XSRF-TOKEN",
      "laravel-session"
    ]
  },
  {
    "path": "/about-us/",
    "status": 200,
    "html_lang": "ko",
    "app_locale_after": "ko",
    "normalized_html_sha256": "dba64573148417b9bf8332c202abecfa1e4232db4781ceeafba8cef743cc81b4",
    "set_cookie": [
      "XSRF-TOKEN",
      "laravel-session"
    ]
  }
]
```

```text
V8 / full normalized HTML equals baseline: True
V8 /about-us/ full normalized HTML equals baseline: True
```

## 6. V5·V6 — SEO와 404 주소 노출

`/en/`, `/ja/`, `/`의 canonical은 각각 자기 정식 공개 주소다. 외국어 두 홈에 각 ko/en/ja/x-default4태그가 있고 모두200이다. 그 두 홈의 `og:locale:alternate`는 각각2개로 대상ko·다른 외국어 홈은200. 따라서 **현재 외국어 홈에서 404를 가리키는 hreflang=0, og alternate=0**이다. 한국어 홈에는 hreflang0이라 상호 링크 조건은 실패한다. 한국어 head에 지금 추가하지 말라는 구현 단계 지시와 현재 검증 문항 사이의 단계 차이를 숨기지 않았다.

`intl_alternates()`는 `app/Support/intl.php:70-88`에서 Route 존재를 확인하지만 뷰 존재는 확인하지 않는다. `/en/about-us/` 404 직후 호출해도 ko/en/ja 세 주소를 모두 내며 EN/JA 둘 다404다. 같은 현상이 blog·번역 상세 문맥에도 있다. 현재 페이지가404여서 실제 head는 출력되지 않았지만 이 helper를 후속 head에서 그대로 쓰면 없는 뷰도 광고하게 된다.

```json
{
  "heads": [
    {
      "path": "/en/",
      "canonical": "https://j-curve.co.kr/en/",
      "alternates": [
        {
          "lang": "ko",
          "url": "https://j-curve.co.kr/",
          "status": 200
        },
        {
          "lang": "en",
          "url": "https://j-curve.co.kr/en/",
          "status": 200
        },
        {
          "lang": "ja",
          "url": "https://j-curve.co.kr/ja/",
          "status": 200
        },
        {
          "lang": "x-default",
          "url": "https://j-curve.co.kr/",
          "status": 200
        }
      ]
    },
    {
      "path": "/ja/",
      "canonical": "https://j-curve.co.kr/ja/",
      "alternates": [
        {
          "lang": "ko",
          "url": "https://j-curve.co.kr/",
          "status": 200
        },
        {
          "lang": "en",
          "url": "https://j-curve.co.kr/en/",
          "status": 200
        },
        {
          "lang": "ja",
          "url": "https://j-curve.co.kr/ja/",
          "status": 200
        },
        {
          "lang": "x-default",
          "url": "https://j-curve.co.kr/",
          "status": 200
        }
      ]
    },
    {
      "path": "/",
      "canonical": "https://j-curve.co.kr/",
      "alternates": []
    }
  ],
  "404_context": [
    {
      "path": "/en/about-us/",
      "status": 404,
      "alternates": {
        "ko": "https://j-curve.co.kr/about-us/",
        "en": "https://j-curve.co.kr/en/about-us/",
        "ja": "https://j-curve.co.kr/ja/about-us/"
      }
    },
    {
      "path": "/en/blog/",
      "status": 404,
      "alternates": {
        "ko": "https://j-curve.co.kr/blog/",
        "en": "https://j-curve.co.kr/en/blog/",
        "ja": "https://j-curve.co.kr/ja/blog/"
      }
    },
    {
      "path": "/en/insights/mobile-marketing-strategies",
      "status": 404,
      "alternates": {
        "ko": "https://j-curve.co.kr/insights/%EB%B0%98%EB%93%9C%EC%8B%9C-%EC%95%8C%EC%95%84%EC%95%BC-%ED%95%A0-%EB%AA%A8%EB%B0%94%EC%9D%BC-%EB%A7%88%EC%BC%80%ED%8C%85-%EC%A0%84%EB%9E%B5-5%EA%B0%80%EC%A7%80",
        "en": "https://j-curve.co.kr/en/insights/mobile-marketing-strategies",
        "ja": "https://j-curve.co.kr/ja/insights/mobile-marketing-strategies-ja"
      }
    }
  ]
}
```

사이트맵은 KO94+외국어90=184, 중복0. 한국어 catalog는 기준과 내용·순서·lastmod까지 완전히 동일했다. 사이트맵 index 및4개의 XML 모두 파싱 성공. 외국어90=정적86+카테고리2+번역글2, 실제 상태200 2·404 88. 이 중404를 사이트맵에 추가하는 위치는 `FeedCatalog.php:68-94`이며 현재 단계 구현 지시도 전체 대상 주소 추가를 요구한다. 구조 판정과 공개 검색 노출의 위험을 분리해서 보고한다.

```json
{
  "index_status": 200,
  "xml_valid": true,
  "xml_sections": [
    {
      "path": "/sitemaps/pages/1.xml",
      "status": 200,
      "valid": true,
      "count": 31
    },
    {
      "path": "/sitemaps/services/1.xml",
      "status": 200,
      "valid": true,
      "count": 99
    },
    {
      "path": "/sitemaps/insights/1.xml",
      "status": 200,
      "valid": true,
      "count": 54
    },
    {
      "path": "/sitemaps/works/1.xml",
      "status": 200,
      "valid": true,
      "count": 0
    }
  ]
}
```

| 외국어 사이트맵 URL | 실제 상태 |
| --- | --- |
| https://j-curve.co.kr/en/ | 200 |
| https://j-curve.co.kr/en/about-us/ | 404 |
| https://j-curve.co.kr/en/contact-us/ | 404 |
| https://j-curve.co.kr/en/privacy | 404 |
| https://j-curve.co.kr/en/support/faq | 404 |
| https://j-curve.co.kr/en/self-marketing | 404 |
| https://j-curve.co.kr/en/self-marketing/place | 404 |
| https://j-curve.co.kr/en/work | 404 |
| https://j-curve.co.kr/en/blog/ | 404 |
| https://j-curve.co.kr/en/insights/category/performance-marketing | 404 |
| https://j-curve.co.kr/ja/ | 200 |
| https://j-curve.co.kr/ja/about-us/ | 404 |
| https://j-curve.co.kr/ja/contact-us/ | 404 |
| https://j-curve.co.kr/ja/privacy | 404 |
| https://j-curve.co.kr/ja/support/faq | 404 |
| https://j-curve.co.kr/ja/self-marketing | 404 |
| https://j-curve.co.kr/ja/self-marketing/place | 404 |
| https://j-curve.co.kr/ja/work | 404 |
| https://j-curve.co.kr/ja/blog/ | 404 |
| https://j-curve.co.kr/ja/insights/category/performance-marketing | 404 |
| https://j-curve.co.kr/en/services | 404 |
| https://j-curve.co.kr/en/services/performance-marketing | 404 |
| https://j-curve.co.kr/en/services/cpa-marketing | 404 |
| https://j-curve.co.kr/en/services/reward-network | 404 |
| https://j-curve.co.kr/en/seo/ | 404 |
| https://j-curve.co.kr/en/wordpress-agency/ | 404 |
| https://j-curve.co.kr/en/services/seo/aeo | 404 |
| https://j-curve.co.kr/en/services/seo/geo | 404 |
| https://j-curve.co.kr/en/seo-backlinks/ | 404 |
| https://j-curve.co.kr/en/naver-place-marketing/ | 404 |
| https://j-curve.co.kr/en/naver-shopping-marketing/ | 404 |
| https://j-curve.co.kr/en/kakao-gift/ | 404 |
| https://j-curve.co.kr/en/coupang/ | 404 |
| https://j-curve.co.kr/en/services/cpa-marketing/real-estate | 404 |
| https://j-curve.co.kr/en/services/cpa-marketing/stock | 404 |
| https://j-curve.co.kr/en/services/cpa-marketing/insurance | 404 |
| https://j-curve.co.kr/en/services/cpa-marketing/coin | 404 |
| https://j-curve.co.kr/en/services/cpa-marketing/permission-call | 404 |
| https://j-curve.co.kr/en/services/performance-marketing/naver-gfa | 404 |
| https://j-curve.co.kr/en/services/performance-marketing/facebook | 404 |
| https://j-curve.co.kr/en/services/performance-marketing/youtube | 404 |
| https://j-curve.co.kr/en/services/marketing-support | 404 |
| https://j-curve.co.kr/en/solutions | 404 |
| https://j-curve.co.kr/en/solutions/rankfree | 404 |
| https://j-curve.co.kr/en/solutions/boostingshop | 404 |
| https://j-curve.co.kr/en/solutions/shopitrend | 404 |
| https://j-curve.co.kr/en/solutions/leadbay | 404 |
| https://j-curve.co.kr/en/solutions/call2sale | 404 |
| https://j-curve.co.kr/en/solutions/boostingshop/basic | 404 |
| https://j-curve.co.kr/en/solutions/boostingshop/pro | 404 |
| https://j-curve.co.kr/en/solutions/boostingshop/elite | 404 |
| https://j-curve.co.kr/en/solutions/boostingshop/instagram-popular | 404 |
| https://j-curve.co.kr/en/solutions/boostingshop/instagram-followers | 404 |
| https://j-curve.co.kr/en/solutions/boostingshop/instagram-likes | 404 |
| https://j-curve.co.kr/ja/services | 404 |
| https://j-curve.co.kr/ja/services/performance-marketing | 404 |
| https://j-curve.co.kr/ja/services/cpa-marketing | 404 |
| https://j-curve.co.kr/ja/services/reward-network | 404 |
| https://j-curve.co.kr/ja/seo/ | 404 |
| https://j-curve.co.kr/ja/wordpress-agency/ | 404 |
| https://j-curve.co.kr/ja/services/seo/aeo | 404 |
| https://j-curve.co.kr/ja/services/seo/geo | 404 |
| https://j-curve.co.kr/ja/seo-backlinks/ | 404 |
| https://j-curve.co.kr/ja/naver-place-marketing/ | 404 |
| https://j-curve.co.kr/ja/naver-shopping-marketing/ | 404 |
| https://j-curve.co.kr/ja/kakao-gift/ | 404 |
| https://j-curve.co.kr/ja/coupang/ | 404 |
| https://j-curve.co.kr/ja/services/cpa-marketing/real-estate | 404 |
| https://j-curve.co.kr/ja/services/cpa-marketing/stock | 404 |
| https://j-curve.co.kr/ja/services/cpa-marketing/insurance | 404 |
| https://j-curve.co.kr/ja/services/cpa-marketing/coin | 404 |
| https://j-curve.co.kr/ja/services/cpa-marketing/permission-call | 404 |
| https://j-curve.co.kr/ja/services/performance-marketing/naver-gfa | 404 |
| https://j-curve.co.kr/ja/services/performance-marketing/facebook | 404 |
| https://j-curve.co.kr/ja/services/performance-marketing/youtube | 404 |
| https://j-curve.co.kr/ja/services/marketing-support | 404 |
| https://j-curve.co.kr/ja/solutions | 404 |
| https://j-curve.co.kr/ja/solutions/rankfree | 404 |
| https://j-curve.co.kr/ja/solutions/boostingshop | 404 |
| https://j-curve.co.kr/ja/solutions/shopitrend | 404 |
| https://j-curve.co.kr/ja/solutions/leadbay | 404 |
| https://j-curve.co.kr/ja/solutions/call2sale | 404 |
| https://j-curve.co.kr/ja/solutions/boostingshop/basic | 404 |
| https://j-curve.co.kr/ja/solutions/boostingshop/pro | 404 |
| https://j-curve.co.kr/ja/solutions/boostingshop/elite | 404 |
| https://j-curve.co.kr/ja/solutions/boostingshop/instagram-popular | 404 |
| https://j-curve.co.kr/ja/solutions/boostingshop/instagram-followers | 404 |
| https://j-curve.co.kr/ja/solutions/boostingshop/instagram-likes | 404 |
| https://j-curve.co.kr/en/insights/mobile-marketing-strategies | 404 |
| https://j-curve.co.kr/ja/insights/mobile-marketing-strategies-ja | 404 |

## 7. V9 — 데이터 실제 콘솔 출력

독립 PHPUnit 외에 임시 current.sqlite에서 시더·stale·삭제·down·migrate를 별도로 실행했다. 다음은 DB2행 전체 직렬화 해시와 실제 console 출력이다. 모든 변경은 임시DB뿐이다.

```text
$ php /private/tmp/verify_intl01.php /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n data unused
db:seed IntlInsightSeeder #1 exit=0

   INFO  Seeding database.  

db:seed IntlInsightSeeder #2 exit=0

   INFO  Seeding database.  

rows=2 before_sha256=4c0e562ccbbb114a982909c98f423623c2acee60e59dd805f5d3bbfa1e473c19 after_sha256=4c0e562ccbbb114a982909c98f423623c2acee60e59dd805f5d3bbfa1e473c19
+---------+--------+------------------+-------------+--------------+
| ko_slug | locale | translation_slug | source_hash | current_hash |
+---------+--------+------------------+-------------+--------------+
Stale translations: 0
+-------------------------------------------+--------+--------------------------------+------------------------------------------------------------------+------------------------------------------------------------------+
| ko_slug                                   | locale | translation_slug               | source_hash                                                      | current_hash                                                     |
+-------------------------------------------+--------+--------------------------------+------------------------------------------------------------------+------------------------------------------------------------------+
| 반드시-알아야-할-모바일-마케팅-전략-5가지 | en     | mobile-marketing-strategies    | e825527449071ab6acda3c943ee09fffdc5017a1ea11722725398a08d0e2d598 | 07fe12c2069891822599249d93243d3aa56a2b3e3e57b18448ba29ab34ce18ce |
| 반드시-알아야-할-모바일-마케팅-전략-5가지 | ja     | mobile-marketing-strategies-ja | e825527449071ab6acda3c943ee09fffdc5017a1ea11722725398a08d0e2d598 | 07fe12c2069891822599249d93243d3aa56a2b3e3e57b18448ba29ab34ce18ce |
+-------------------------------------------+--------+--------------------------------+------------------------------------------------------------------+------------------------------------------------------------------+
Stale translations: 2
after insight delete translations=0

   INFO  Seeding database.  

INTL skipped missing ko_slug: 반드시-알아야-할-모바일-마케팅-전략-5가지
migrate:rollback exit=0

   INFO  Rolling back migrations.  

  2026_11_03_000002_add_locale_to_leads_table .................... 6.63ms DONE
  2026_11_03_000001_create_insight_translations_table ............ 0.63ms DONE

table=0 locale-column=0
migrate exit=0

   INFO  Running migrations.  

  2026_11_03_000001_create_insight_translations_table ............ 3.63ms DONE
  2026_11_03_000002_add_locale_to_leads_table .................... 0.63ms DONE

table=1 locale-column=1

EXIT=0
```

## 8. V10 — 본문·숫자·내부 링크

DOMDocument로 body text 및 a[href]를 전수 수집했다. 화면 본문의 EN/JA 한글0, `menu.`/`pages/home.` 노출0. 실제 수치는 다음과 같고 새 성과 수치 발견0이다.

| 사실 | KO | EN 실제 | JA 실제 |
| --- | --- | --- | --- |
| 누적 광고비 | 373억+ | KRW 37.3B+ | 373億ウォン+ |
| 누적 리드 | 128만+ | 1.28M+ | 128万件+ |
| 캠페인 | 15,700+ | 15,700+ | 15,700件+ |
| 기준 | 2026년 | as of 2026 | 2026年時点 |

대조 위치: KO `resources/views/pages/home.blade.php:21-23,80-82`; EN `lang/en/pages/home.php:30-32,141-143`; JA `lang/ja/pages/home.php:28-30,138-140`. 주소·전화·등록번호·1300K는 한국어 푸터/브랜드 사실과 일치한다. `2019.01.01`은 번역 sample 원문 글의 발행일이며 신규 성과가 아니다. EN body에서 붙어서 보이는 `1Media`의1은5층 목록 순번이며 ‘1M’ 성과를 추가한 것이 아니다.

각 홈 내부링크184회(고유46개): 자기언어178, #페이지내2, 언어전환4. 제외구역(로그인·주문·진단·문의게시판) 링크0. 한국어 경로로 가는 링크는 두 개의 KO 언어전환 `/`뿐. 다른언어 홈으로 가는2개도 언어전환이며 같은 페이지 홈을 가리킨다. 그 외 한국어 누수0. 아래는 중복횟수까지 보존한 모든 내부 href다.

### /en/

| href | 횟수 |
| --- | --- |
| #main | 1 |
| https://j-curve.co.kr/en/ | 1 |
| https://j-curve.co.kr/en/about-us/ | 3 |
| https://j-curve.co.kr/en/services | 8 |
| https://j-curve.co.kr/en/services/performance-marketing | 5 |
| https://j-curve.co.kr/en/services/performance-marketing#performance-channels | 3 |
| https://j-curve.co.kr/en/services/performance-marketing/naver-gfa | 3 |
| https://j-curve.co.kr/en/services/performance-marketing/facebook | 3 |
| https://j-curve.co.kr/en/services/performance-marketing/youtube | 3 |
| https://j-curve.co.kr/en/services/cpa-marketing | 5 |
| https://j-curve.co.kr/en/services/cpa-marketing/real-estate | 3 |
| https://j-curve.co.kr/en/services/cpa-marketing/stock | 3 |
| https://j-curve.co.kr/en/services/cpa-marketing/insurance | 3 |
| https://j-curve.co.kr/en/services/cpa-marketing/coin | 3 |
| https://j-curve.co.kr/en/services/cpa-marketing/permission-call | 3 |
| https://j-curve.co.kr/en/services/reward-network | 6 |
| https://j-curve.co.kr/en/seo/ | 6 |
| https://j-curve.co.kr/en/services/seo/aeo | 4 |
| https://j-curve.co.kr/en/services/seo/geo | 4 |
| https://j-curve.co.kr/en/naver-place-marketing/ | 6 |
| https://j-curve.co.kr/en/naver-shopping-marketing/ | 4 |
| https://j-curve.co.kr/en/coupang/ | 4 |
| https://j-curve.co.kr/en/kakao-gift/ | 4 |
| https://j-curve.co.kr/en/seo-backlinks/ | 5 |
| https://j-curve.co.kr/en/wordpress-agency/ | 5 |
| https://j-curve.co.kr/en/services/marketing-support | 5 |
| https://j-curve.co.kr/en/self-marketing | 6 |
| https://j-curve.co.kr/en/solutions | 6 |
| https://j-curve.co.kr/en/solutions/rankfree | 5 |
| https://j-curve.co.kr/en/solutions/boostingshop | 5 |
| https://j-curve.co.kr/en/solutions/shopitrend | 5 |
| https://j-curve.co.kr/en/solutions/leadbay | 5 |
| https://j-curve.co.kr/en/solutions/call2sale | 5 |
| https://j-curve.co.kr/en/#apps | 4 |
| https://j-curve.co.kr/en/work | 3 |
| https://j-curve.co.kr/en/blog/ | 4 |
| https://j-curve.co.kr/en/support/faq | 4 |
| https://j-curve.co.kr/en/contact-us/ | 16 |
| / | 2 |
| /en/ | 2 |
| /ja/ | 2 |
| https://j-curve.co.kr/en/services/reward-network#advertisers | 2 |
| https://j-curve.co.kr/en/services/reward-network#publishers | 2 |
| #apps | 1 |
| https://j-curve.co.kr/en/insights/mobile-marketing-strategies | 1 |
| https://j-curve.co.kr/en/privacy | 1 |

### /ja/

| href | 횟수 |
| --- | --- |
| #main | 1 |
| https://j-curve.co.kr/ja/ | 1 |
| https://j-curve.co.kr/ja/about-us/ | 3 |
| https://j-curve.co.kr/ja/services | 8 |
| https://j-curve.co.kr/ja/services/performance-marketing | 5 |
| https://j-curve.co.kr/ja/services/performance-marketing#performance-channels | 3 |
| https://j-curve.co.kr/ja/services/performance-marketing/naver-gfa | 3 |
| https://j-curve.co.kr/ja/services/performance-marketing/facebook | 3 |
| https://j-curve.co.kr/ja/services/performance-marketing/youtube | 3 |
| https://j-curve.co.kr/ja/services/cpa-marketing | 5 |
| https://j-curve.co.kr/ja/services/cpa-marketing/real-estate | 3 |
| https://j-curve.co.kr/ja/services/cpa-marketing/stock | 3 |
| https://j-curve.co.kr/ja/services/cpa-marketing/insurance | 3 |
| https://j-curve.co.kr/ja/services/cpa-marketing/coin | 3 |
| https://j-curve.co.kr/ja/services/cpa-marketing/permission-call | 3 |
| https://j-curve.co.kr/ja/services/reward-network | 6 |
| https://j-curve.co.kr/ja/seo/ | 6 |
| https://j-curve.co.kr/ja/services/seo/aeo | 4 |
| https://j-curve.co.kr/ja/services/seo/geo | 4 |
| https://j-curve.co.kr/ja/naver-place-marketing/ | 6 |
| https://j-curve.co.kr/ja/naver-shopping-marketing/ | 4 |
| https://j-curve.co.kr/ja/coupang/ | 4 |
| https://j-curve.co.kr/ja/kakao-gift/ | 4 |
| https://j-curve.co.kr/ja/seo-backlinks/ | 5 |
| https://j-curve.co.kr/ja/wordpress-agency/ | 5 |
| https://j-curve.co.kr/ja/services/marketing-support | 5 |
| https://j-curve.co.kr/ja/self-marketing | 6 |
| https://j-curve.co.kr/ja/solutions | 6 |
| https://j-curve.co.kr/ja/solutions/rankfree | 5 |
| https://j-curve.co.kr/ja/solutions/boostingshop | 5 |
| https://j-curve.co.kr/ja/solutions/shopitrend | 5 |
| https://j-curve.co.kr/ja/solutions/leadbay | 5 |
| https://j-curve.co.kr/ja/solutions/call2sale | 5 |
| https://j-curve.co.kr/ja/#apps | 4 |
| https://j-curve.co.kr/ja/work | 3 |
| https://j-curve.co.kr/ja/blog/ | 4 |
| https://j-curve.co.kr/ja/support/faq | 4 |
| https://j-curve.co.kr/ja/contact-us/ | 16 |
| / | 2 |
| /en/ | 2 |
| /ja/ | 2 |
| https://j-curve.co.kr/ja/services/reward-network#advertisers | 2 |
| https://j-curve.co.kr/ja/services/reward-network#publishers | 2 |
| #apps | 1 |
| https://j-curve.co.kr/ja/insights/mobile-marketing-strategies-ja | 1 |
| https://j-curve.co.kr/ja/privacy | 1 |

390px 검사: **미검증**. ego-browser 스킬을 적용해 TaskSpace224·390×844 emulation을 사용했으나 최초 서버 실행 cwd 오류로 받은 페이지가 실제 앱 HTML이 아니었다(lang빈값·CSS0). 그때 측정된 viewport988/client980/scroll988은 전부 폐기했다. 해당 TaskSpace는 종료했다. 이후 서버 cwd를 public으로 정정해 실제 EN/JA HTTP200은 확인했지만 올바른 앱에서390px 폭을 재측정하지 못했다. 따라서 ‘가로 스크롤 없음’을 주장하지 않는다.

## 9. V11 — 요청한 품질 게이트 실제 출력

전체 테스트는 DB=:memory:, 각 독립검사·HTML비교는 TMPDIR SQLite였다. Pint는 `git diff --name-only 0662117 -- *.php` 및 untracked PHP의 합집합40개를 실제 지정했다.

```text
$ php artisan test --no-ansi
{"tool":"phpunit","result":"passed","tests":199,"passed":199,"assertions":21198,"duration_ms":11504}

EXIT=0
```

```text
$ ./vendor/bin/pint --test app/Console/Commands/IntlStale.php app/Http/Controllers/ContactController.php app/Http/Controllers/InsightController.php app/Http/Controllers/PageController.php app/Http/Controllers/WorkController.php app/Http/Middleware/PreservePublicUrls.php app/Http/Middleware/SetIntlLocale.php app/Models/Insight.php app/Models/InsightTranslation.php app/Providers/AppServiceProvider.php app/Services/Seo/Publishing/FeedCatalog.php app/Services/Seo/Publishing/PreservedPaths.php app/Support/IntlLegacyRedirects.php app/Support/IntlRoutes.php app/Support/intl.php config/intl.php database/migrations/2026_11_03_000001_create_insight_translations_table.php database/migrations/2026_11_03_000002_add_locale_to_leads_table.php database/seeders/DatabaseSeeder.php database/seeders/IntlInsightSeeder.php lang/en/intl.php lang/en/menu.php lang/en/pages/home.php lang/en/validation.php lang/ja/intl.php lang/ja/menu.php lang/ja/pages/home.php lang/ja/validation.php resources/views/intl/pages/home.blade.php resources/views/layouts/intl.blade.php resources/views/partials/intl/footer.blade.php resources/views/partials/intl/head.blade.php resources/views/partials/intl/header.blade.php resources/views/partials/intl/menu.php resources/views/partials/intl/switcher.blade.php routes/intl.php routes/pages.php routes/web.php tests/Feature/IntlFoundationTest.php tests/Support/intl_snapshot.php
{"tool":"pint","result":"passed"}
EXIT=0
```

```text
$ npm run build

> build
> vite build

failed to load config from /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/vite.config.js
error during build:
Error: EPERM: operation not permitted, open '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/node_modules/.vite-temp/vite.config.js.timestamp-1793684952303-cbd4f3e51ebc8.mjs'
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
  path: '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/node_modules/.vite-temp/vite.config.js.timestamp-1793684952303-cbd4f3e51ebc8.mjs'
}

EXIT=1
```

기본빌드 실패는 외부 링크된 node_modules의 `.vite-temp` 쓰기 EPERM이며 코드 문법 오류로 판정하지 않았다. 소스·링크를 바꾸지 않고 지원된 runner loader로 우회한 보조 빌드:

```text
$ npm run build -- --configLoader runner

> build
> vite build --configLoader runner

vite v8.2.0 building client environment for production...
[2K
transforming...
/media/bg/hero-glow.webp referenced in /media/bg/hero-glow.webp didn't resolve at build time, it will remain unchanged to be resolved at runtime
✓ 12 modules transformed.
rendering chunks...
computing gzip size...
public/build/manifest.json                        0.88 kB │ gzip:  0.26 kB
public/build/assets/legacy-reskin-3fymEzpK.css   13.71 kB │ gzip:  2.99 kB
public/build/assets/jc-BtbJwSAY.css              92.14 kB │ gzip: 17.86 kB
public/build/assets/app-BW-Dp7Pe.css             97.52 kB │ gzip: 18.40 kB
public/build/assets/jc-DIWfGL1E.js               25.80 kB │ gzip:  9.23 kB
public/build/assets/app-XOhwnyVw.js             159.36 kB │ gzip: 60.50 kB

✓ built in 5.00s

EXIT=0
```

이 보조 성공을 요청된 기본 명령의 exit0으로 바꿔 쓰지 않는다. 미디어 경고는 실제 출력 그대로이며 `public/media`는 수정하지 않았다.

## 10. §T — 무력화·원복 증거

결과 문서 생성 전 다음 두 명령을 시작 및 각 원복 후 실행했다.

```sh
git status --porcelain | shasum
git diff | shasum
```

| 시점 | status SHA1 | diff SHA1 |
| --- | --- | --- |
| T 시작 전 | ab6026cc63ea30f875514e86647aa6eaeec5290a | a91133964b5460cecce5e2916432540d41107d0d |
| T1 원복 후 | ab6026cc63ea30f875514e86647aa6eaeec5290a | a91133964b5460cecce5e2916432540d41107d0d |
| T2 원복 후 | ab6026cc63ea30f875514e86647aa6eaeec5290a | a91133964b5460cecce5e2916432540d41107d0d |
| T3 원복 후 | ab6026cc63ea30f875514e86647aa6eaeec5290a | a91133964b5460cecce5e2916432540d41107d0d |
| T4 원복 후·최종 | ab6026cc63ea30f875514e86647aa6eaeec5290a | a91133964b5460cecce5e2916432540d41107d0d |

이는 Git hash-object 결과가 아니라 지시서 그대로 porcelain/diff 출력의 SHA1이다. 결과 문서는 이 증명 후 새로 생성하므로 나중의 status 해시는 문서1개 추가로 달라지는 것이 정상이다.

### T1 접두301 인식 제거

`app/Services/Seo/Publishing/PreservedPaths.php:11`의 prefix if에 `false &&`를 한시 추가. 정확한 테스트가301 대신200을 잡아 red. 원복 후 전체 green.

```text
$ php artisan test --no-ansi --filter test_all_foreign_aliases_redirect_once_preserving_raw_queries
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":1,"duration_ms":234,"failed":1,"failures":[{"test":"Tests\\Feature\\IntlFoundationTest::test_all_foreign_aliases_redirect_once_preserving_raw_queries","file":"/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Feature/IntlFoundationTest.php","line":109,"message":"Expected response status code [301] but received 200.\nFailed asserting that 200 is identical to 301."}]}

EXIT=1
```

```text
$ php artisan test --no-ansi --filter '.*'
{"tool":"phpunit","result":"passed","tests":199,"passed":199,"assertions":21198,"duration_ms":12824}

EXIT=0
```

### T2 번역없는 글 필터 제거

`InsightController.php:86` translatedShow의 `whereHas(translations, locale+slug)`를 한시 제거. 해당 테스트가404 대신200을 잡아 red. published 필터·뷰를 건드리지 않았다. 원복 후 전체 green.

```text
$ php artisan test --no-ansi --filter test_untranslated_and_hidden_insights_are_404_even_when_foreign_view_exists
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":1,"duration_ms":296,"failed":1,"failures":[{"test":"Tests\\Feature\\IntlFoundationTest::test_untranslated_and_hidden_insights_are_404_even_when_foreign_view_exists","file":"/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Feature/IntlFoundationTest.php","line":227,"message":"Expected response status code [404] but received 200.\nFailed asserting that 200 is identical to 404."}]}

EXIT=1
```

```text
$ php artisan test --no-ansi --filter '.*'
{"tool":"phpunit","result":"passed","tests":199,"passed":199,"assertions":21198,"duration_ms":24405}

EXIT=0
```

### T3 locale을 폼에서 읽기

`ContactController.php:86`만 `$lead->locale = $request->input('locale');`로 한시 교체. expected en / actual xx로 red. 원복 후 전체 green.

```text
$ php artisan test --no-ansi --filter test_contact_locale_comes_from_path_and_keeps_utm_flash_and_middleware
{"tool":"phpunit","result":"failed","tests":1,"passed":0,"assertions":8,"duration_ms":650,"failed":1,"failures":[{"test":"Tests\\Feature\\IntlFoundationTest::test_contact_locale_comes_from_path_and_keeps_utm_flash_and_middleware","file":"/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Feature/IntlFoundationTest.php","line":280,"message":"Failed asserting that two strings are identical.\n--- Expected\n+++ Actual\n@@ @@\n-'en'\n+'xx'"}]}

EXIT=1
```

```text
$ php artisan test --no-ansi --filter '.*'
{"tool":"phpunit","result":"passed","tests":199,"passed":199,"assertions":21198,"duration_ms":22741}

EXIT=0
```

### T4 한국어 뷰 공백1글자

`resources/views/pages/company.blade.php:34`의 h1 닫기 직전 공백1개를 추가했다. V1과 같은 norm 함수(CSRF·Vite만)를 사용해 기준0662117의 `/about-us/`와 비교했다. 단1글자 diff와 exit1이 실제 발생했고 원복 후 HTML동일·exit0. 이후 전체 green.

```text
$ python3 /private/tmp/verify_intl01_company.py T4-disabled
Normalization=CSRF,Vite-only
STATUS_LOCATION_EQUAL=True
HTML_EQUAL=False
--- 0662117/about-us/
+++ current/about-us/
@@ -280,5 +280,5 @@
             <div class="landing__hero-inner">
                 <span class="landing__eyebrow">About J-Curve</span>
-                <h1>2009년부터,<br>실행과 데이터로 말해왔습니다</h1>
+                <h1>2009년부터,<br>실행과 데이터로 말해왔습니다 </h1>
                 <p class="landing__lead">광고를 대신 집행하는 데서 멈추지 않았습니다. 유입, 전환, 검색, 리드 운영과 웹 시스템까지 현장에서 막히는 구간을 직접 풀어왔습니다.</p>
                 <div class="cta-row">

EXIT=1
```

```text
$ python3 /private/tmp/verify_intl01_company.py T4-restored
Normalization=CSRF,Vite-only
STATUS_LOCATION_EQUAL=True
HTML_EQUAL=True

EXIT=0
```

```text
$ php artisan test --no-ansi --filter '.*'
{"tool":"phpunit","result":"passed","tests":199,"passed":199,"assertions":21198,"duration_ms":13325}

EXIT=0
```

## 11. 미검증·진행 전 해소할 항목

1. **V1:** 허용 정규화만 적용한 비교는 랜덤값 차이 때문에 아직 PASS 아님. 이 상태로 ‘한국어 완전무변경 검증 완료’라고 넘기면 안 됨. 실제 문구 회귀 근거는 발견하지 못했다.
2. **V5:** 한국어 reciprocal hreflang이 없고 helper가 Route 유무만으로404 뷰를 존재한다고 반환한다. 최종 공개 전 실제 응답과 일치하는 alternate·sitemap 정책이 필요하다. 이번 세션에서는 고치지 않았다.
3. **V4·V7:** 실제 외국어 상세·문의 뷰가 없어 EN200·입력 재표시 XSS는 미충족. 컨트롤러 probe 통과만으로 화면 검증을 대체하지 않았다.
4. **V10:** 유효한 앱 화면에서390px 검사는 미완료. 500 오류 문서의 잘못된 측정은 폐기했다.
5. **V11:** 기본 build 명령 exit1은 실행환경 문제. runner 보조 성공과 구분해 인계한다.
6. 실제 외부 서비스·운영 DB·배포는 요청 범위 밖으로 실행하지 않았다. context-mode MCP는 `approval policy is never`로 차단돼 허용된 로컬 명령에서 결과를 수집·집계했다.

## 부록 A. 재현 harness 원문

아래 코드는 저장소 소스에 넣은 것이 아니라 `/private/tmp`에서 실행한 검증 전용 코드다. 별도 source patch·assertion 완화 없이 재현 가능하도록 최종 실행본을 보존한다. setup 실행 전 SCRATCH 디렉터리가 존재해야 하며 baseline archive 디렉터리는 없어야 한다. 외부 테스트의 URL 설정은 테스트 요청 scheme을 공개주소에 맞추는 설정이다.

### `/private/tmp/verify_intl01.php`

```php
<?php
// Independent VERIFY-INTL-01 runtime harness; no repository source writes.
$root = $argv[1]; $mode = $argv[2]; $out = $argv[3];
$loader = require $root.'/vendor/autoload.php';
foreach (['App\\'=>'app/','Database\\Seeders\\'=>'database/seeders/','Database\\Factories\\'=>'database/factories/'] as $prefix=>$dir) {
    $loader->setPsr4($prefix, $root.'/'.$dir);
    foreach ($loader->getClassMap() as $class=>$path) if (str_starts_with($class,$prefix)) $loader->addClassMap([$class=>$root.'/'.$dir.str_replace('\\','/',substr($class,strlen($prefix))).'.php']);
}
$app = require $root.'/bootstrap/app.php';
$console = $app->make(Illuminate\Contracts\Console\Kernel::class); $console->bootstrap();
Illuminate\Support\Carbon::setTestNow('2026-11-03 00:00:00');
config(['honeypot.randomize_name_field_name'=>false]);
if ($mode === 'data') {
    $before=App\Models\InsightTranslation::orderBy('id')->get()->toJson();
    foreach([1,2] as $i) { $code=$console->call('db:seed',['--class'=>'Database\\Seeders\\IntlInsightSeeder','--force'=>true]); echo "db:seed IntlInsightSeeder #$i exit=$code\n".$console->output(); }
    $after=App\Models\InsightTranslation::orderBy('id')->get()->toJson();
    echo 'rows='.App\Models\InsightTranslation::count().' before_sha256='.hash('sha256',$before).' after_sha256='.hash('sha256',$after)."\n";
    $console->call('intl:stale'); echo $console->output();
    $sample=App\Models\Insight::whereHas('translations')->firstOrFail(); $sample->update(['content'=>$sample->content.'<p>Verifier stale probe</p>']);
    $console->call('intl:stale'); echo $console->output();
    $sample->delete(); echo 'after insight delete translations='.App\Models\InsightTranslation::count()."\n";
    $console->call('db:seed',['--class'=>'Database\\Seeders\\IntlInsightSeeder','--force'=>true]); echo $console->output();
    foreach([['migrate:rollback',['--step'=>2,'--force'=>true]],['migrate',['--force'=>true]]] as [$cmd,$args]) { $code=$console->call($cmd,$args); echo "$cmd exit=$code\n".$console->output(); echo 'table='.(int)Illuminate\Support\Facades\Schema::hasTable('insight_translations').' locale-column='.(int)Illuminate\Support\Facades\Schema::hasColumn('leads','locale')."\n"; }
    exit;
}
if ($mode !== 'probe') {
    foreach (['migrate','db:seed'] as $cmd) { $exit=$console->call($cmd,['--force'=>true]); echo "$cmd --force exit=$exit\n".$console->output(); }
    echo 'WORK_COUNT='.App\Models\Work::count()."\n";
}
$kernel=$app->make(Illuminate\Contracts\Http\Kernel::class);
function req($path,$method='GET',$accept=null) {
    global $kernel;
    $encoded=preg_replace_callback('/[\x80-\xff]/',fn($m)=>rawurlencode($m[0]),$path);
    $r=Illuminate\Http\Request::create('https://j-curve.co.kr'.$encoded,$method,[],[],[], $accept ? ['HTTP_ACCEPT_LANGUAGE'=>$accept] : []);
    $s=$kernel->handle($r); $kernel->terminate($r,$s); return $s;
}
function norm($html) {
    $html=preg_replace('~(<meta name="csrf-token" content=")[^"]*(")~','$1[CSRF]$2',$html);
    $html=preg_replace('~(<input\b[^>]*\bname="_token"[^>]*\bvalue=")[^"]*(")~','$1[CSRF]$2',$html);
    return preg_replace('~(/build/assets/[^"<> ]+)-[A-Za-z0-9_-]{8}(\.(?:css|js))~','$1[VITE]$2',$html);
}
function pathonly($url) { return preg_replace('~^https?://[^/]+~','',$url); }
if ($mode === 'single') {
    $s=req('/about-us/');
    file_put_contents($out,json_encode(['status'=>$s->getStatusCode(),'location'=>$s->headers->get('Location'),'html'=>base64_encode(norm($s->getContent()))])); exit;
}
$catalog=app(App\Services\Seo\Publishing\FeedCatalog::class)->sections();
if ($mode === 'snapshot') {
    $ko=[]; $paths=config('seo.preserved_paths');
    foreach($catalog as $section=>$entries) { $ko[$section]=[]; foreach($entries as $e) if(!preg_match('~^/(en|ja)(/|$)~',pathonly($e['url']))) { $ko[$section][]=$e; $paths[]=pathonly($e['url']); } }
    $paths=array_values(array_unique([...$paths,'/company','/contact','/services','/solutions','/self-marketing','/self-marketing/order','/support/faq','/login','/register','/community','/seo-check','/privacy','/solutions/shopitrend','/self-marketing/place']));
    $pages=[];
    foreach($paths as $p) foreach(['none','en','ja'] as $accept) { $s=req($p,'GET',$accept==='none'?null:$accept); $pages[base64_encode($p)][$accept]=['status'=>$s->getStatusCode(),'location'=>$s->headers->get('Location'),'html'=>base64_encode(norm($s->getContent()))]; }
    file_put_contents($out,json_encode(['catalog'=>$ko,'paths'=>$paths,'pages'=>$pages],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
    echo 'SNAPSHOT paths='.count($paths).' requests='.(count($paths)*3).' korean_sitemap='.array_sum(array_map('count',$ko)).' normalization=CSRF,Vite-only' ."\n"; exit;
}
$data=[];
$variants=App\Support\IntlRoutes::variants();
foreach(['en','ja'] as $loc) {
    foreach($variants as $v) { $p=route($loc.'.'.$v['name'],$v['parameters'],false); $s=req($p); $data['V2']['static'][]=['path'=>$p,'status'=>$s->getStatusCode(),'location'=>$s->headers->get('Location')]; }
    foreach(['/login','/register','/dashboard','/profile','/my-account','/community','/self-marketing/order','/seo-check','/support/inquiries','/work/아무거나','/rss','/sitemap.xml'] as $p) { $s=req('/'.$loc.$p); $data['V2']['excluded'][]=['path'=>'/'.$loc.$p,'status'=>$s->getStatusCode(),'location'=>$s->headers->get('Location')]; }
}
foreach(['/EN/','/en','/en//about-us/','/en/./about-us/','/en/%2e%2e/','/en%2Fabout-us','/ko/','/fr/','/en/en/','/en//evil.com','/en/%2F%2Fevil.com'] as $p) { $s=req($p); $data['V2']['weird'][]=['path'=>$p,'status'=>$s->getStatusCode(),'location'=>$s->headers->get('Location'),'ko_html'=>str_contains($s->getContent(),'<html lang="ko"')]; }
$query='?x=1&x=2&q=a%2Fb&encoded=%ED%95%9C%EA%B8%80&blank=&plus=a+b';
foreach(['en','ja'] as $loc) {
    $pairs=[];
    foreach(config('seo.preserved_map') as $modern=>$canonical) {
        if(preg_match('~^/insights/(?!category/)~',$modern)) continue;
        foreach(array_unique([$modern,rtrim($canonical,'/'),$canonical.'/']) as $alias) if($alias!==$canonical) $pairs[$alias]=$canonical;
    }
    foreach($variants as $v) { $canonical=route($loc.'.'.$v['name'],$v['parameters'],false); $canonical=substr($canonical,strlen('/'.$loc)); $pairs[$v['path']]=$canonical; $pairs[$canonical==='/'?'':(str_ends_with($canonical,'/')?rtrim($canonical,'/'):$canonical.'/')]=$canonical; }
    foreach($pairs as $alias=>$canonical) {
        if($alias===$canonical) continue;
        foreach(['GET','HEAD'] as $method) { $s=req('/'.$loc.$alias.$query,$method); $dest=$s->headers->get('Location'); $follow=$dest?req(pathonly($dest),$method):null; $expected='https://j-curve.co.kr/'.$loc.$canonical.$query;
            $data['V3']['redirects'][]=['path'=>'/'.$loc.$alias.$query,'method'=>$method,'status'=>$s->getStatusCode(),'location'=>$dest,'expected'=>$expected,'follow_status'=>$follow?->getStatusCode(),'follow_location'=>$follow?->headers->get('Location'),'pass'=>$s->getStatusCode()===301 && $dest===$expected && $follow?->getStatusCode()!==301]; }
    }
    foreach(App\Models\LegacyRedirect::orderBy('id')->get() as $legacy) { $p='/'.$loc.'/'.ltrim($legacy->from_path,'/'); $s=req($p); $data['V3']['legacy'][]=['path'=>$p,'status'=>$s->getStatusCode(),'location'=>$s->headers->get('Location')]; }
}
foreach(['/en/','/ja/','/'] as $p) { $s=req($p); $html=$s->getContent(); preg_match('~<link rel="canonical" href="([^"]+)"~',$html,$c); preg_match_all('~<link rel="alternate" hreflang="([^"]+)" href="([^"]+)"~',$html,$alts,PREG_SET_ORDER); $a=[]; foreach($alts as $alt) $a[]=['lang'=>$alt[1],'url'=>html_entity_decode($alt[2]),'status'=>req(pathonly(html_entity_decode($alt[2])))->getStatusCode()]; $data['V5']['heads'][]=['path'=>$p,'canonical'=>$c[1]??null,'alternates'=>$a]; }
foreach(['/en/about-us/','/en/blog/','/en/insights/mobile-marketing-strategies'] as $p) { $s=req($p); $alts=intl_alternates(); $data['V5']['404_context'][]=['path'=>$p,'status'=>$s->getStatusCode(),'alternates'=>$alts]; }
$data['V6']['catalog']=$catalog; $data['V6']['statuses']=[];
foreach($catalog as $section=>$entries) foreach($entries as $e) { $p=pathonly($e['url']); if(preg_match('~^/(en|ja)/~',$p)) $data['V6']['statuses'][]=['url'=>$e['url'],'status'=>req($p)->getStatusCode()]; }
$index=req('/sitemap.xml'); $xml=simplexml_load_string($index->getContent()); $data['V6']['index_status']=$index->getStatusCode(); $data['V6']['xml_valid']=$xml!==false;
foreach($xml?->sitemap??[] as $entry) { $p=pathonly((string)$entry->loc); $r=req($p); $sx=simplexml_load_string($r->getContent()); $data['V6']['xml_sections'][]=['path'=>$p,'status'=>$r->getStatusCode(),'valid'=>$sx!==false,'count'=>count($sx?->url??[])]; }
foreach(['/en/','/','/ja/','/about-us/'] as $p) { $s=req($p); preg_match('~<html[^>]*lang="([^"]+)"~',$s->getContent(),$m); $data['V8'][]=['path'=>$p,'status'=>$s->getStatusCode(),'html_lang'=>$m[1]??null,'app_locale_after'=>app()->getLocale(),'normalized_html_sha256'=>hash('sha256',norm($s->getContent())),'set_cookie'=>array_map(fn($c)=>$c->getName(),$s->headers->getCookies())]; }
foreach(['/en/','/ja/','/'] as $p) {
    $s=req($p); $html=$s->getContent(); $dom=new DOMDocument(); @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$html); $xp=new DOMXPath($dom); $body=$xp->query('//body')->item(0); $text=$body?->textContent??''; preg_match_all('/[가-힣ㄱ-ㅎㅏ-ㅣ]/u',$text,$hangul); preg_match_all('~(?:menu\.|pages/home\.)[A-Za-z0-9_.]+~',$text,$keys); $links=[];
    foreach($dom->getElementsByTagName('a') as $a) { $href=$a->getAttribute('href'); if(str_starts_with($href,'/')||str_starts_with($href,'https://j-curve.co.kr')||str_starts_with($href,'#')||($href!==''&&!preg_match('~^[a-z]+:~i',$href))) $links[]=['href'=>$href,'text'=>trim($a->textContent)]; }
    $data['V10'][]=['path'=>$p,'hangul_count'=>count($hangul[0]),'keys'=>$keys[0],'links'=>$links,'body_text'=>$text];
}
file_put_contents($out,json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
echo 'PROBE variants='.count($variants).' static='.count($data['V2']['static']).' redirects='.count($data['V3']['redirects']).' legacy='.count($data['V3']['legacy'])."\n";
```

### `/private/tmp/verify_intl01_run.py`

```python
import os, pathlib, subprocess, json, tarfile, io, sys, difflib, re, collections
root=pathlib.Path('/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n')
scratch=pathlib.Path(sys.argv[1]); base=scratch/'intl-base'
def run(command, label, cwd=root, env=None):
    result=subprocess.run(command,cwd=cwd,env=env,stdout=subprocess.PIPE,stderr=subprocess.STDOUT,text=True)
    (scratch/(label+'.log')).write_text('$ '+__import__('shlex').join(command)+'\n'+result.stdout+'\nEXIT='+str(result.returncode)+'\n')
    print(label, 'exit='+str(result.returncode), result.stdout[-1600:],flush=True)
    return result
def environment(checkout,label):
    env=os.environ.copy(); env.update(APP_ENV='testing',APP_DEBUG='false',APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=',APP_URL='https://j-curve.co.kr',SEO_PUBLIC_URL='https://j-curve.co.kr',APP_LOCALE='ko',APP_FALLBACK_LOCALE='en',APP_FAKER_LOCALE='en_US',DB_CONNECTION='sqlite',DB_DATABASE=str(scratch/(label+'.sqlite')),DB_URL='',SESSION_DRIVER='array',CACHE_STORE='array',QUEUE_CONNECTION='sync',MAIL_MAILER='array',BCRYPT_ROUNDS='4',GTM_ID='',APP_BASE_PATH=str(checkout),VIEW_COMPILED_PATH=str(scratch/(label+'-views')),LOG_CHANNEL='stderr')
    pathlib.Path(env['DB_DATABASE']).touch(); pathlib.Path(env['VIEW_COMPILED_PATH']).mkdir(exist_ok=True)
    return env
if sys.argv[2]=='setup':
    base.mkdir(); archive=subprocess.check_output(['git','archive','0662117'],cwd=root)
    with tarfile.open(fileobj=io.BytesIO(archive)) as tf: tf.extractall(base,filter='data')
    for rel in ['vendor','node_modules','public/build']: (base/rel).symlink_to(root/rel,target_is_directory=True)
    for rel in ['storage/framework/views','storage/framework/sessions','storage/framework/cache/data','storage/logs','bootstrap/cache']: (base/rel).mkdir(parents=True,exist_ok=True)
    for label,checkout in [('baseline',base),('current',root)]: run(['php','/private/tmp/verify_intl01.php',str(checkout),'snapshot',str(scratch/(label+'.json'))],label,checkout,environment(checkout,label))
if sys.argv[2]=='probe':
    run(['php','/private/tmp/verify_intl01.php',str(root),'probe',str(scratch/'probe.json')],'probe',root,environment(root,'current'))
if sys.argv[2] in ['setup','compare']:
    old,new=[json.loads((scratch/(label+'.json')).read_text()) for label in ['baseline','current']]
    lines=['CATALOG_EQUAL='+str(old['catalog']==new['catalog']),'PATHS='+str(len(old['paths']))]; diffs=[]; statusdiff=[]; acceptdiff=[]
    def diagnostic(s):
        s=re.sub(r'(<input\b[^>]*\bname="valid_from"[^>]*\bvalue=")[^"]*(")',r'\1[HONEYPOT]\2',s,flags=re.S)
        return re.sub(r'\b(sbg|sgl|sdot)-[a-zA-Z0-9]{5}\b',r'\1-[SVG-ID]',s)
    diagnostic_diffs=[]
    for k in old['pages']:
        path=__import__('base64').b64decode(k).decode(); a=old['pages'][k]['none']; b=new['pages'][k]['none']
        if (a['status'],a['location'])!=(b['status'],b['location']): statusdiff.append(path)
        ah,bh=[__import__('base64').b64decode(x['html']).decode() for x in [a,b]]
        if a!=b:
            diffs.append(path); delta=''.join(difflib.unified_diff(ah.splitlines(True),bh.splitlines(True),fromfile='base'+path,tofile='current'+path,n=1)); lines.append(delta)
        if diagnostic(ah)!=diagnostic(bh): diagnostic_diffs.append(path)
        for lang in ['en','ja']:
            v=new['pages'][k][lang]; h=__import__('base64').b64decode(v['html']).decode()
            if (v['status'],v['location'])!=(b['status'],b['location']) or diagnostic(h)!=diagnostic(bh): acceptdiff.append([path,lang])
    summary={'paths':len(old['paths']),'requests_per_checkout':len(old['paths'])*3,'strict_diffs':diffs,'status_location_diffs':statusdiff,'diagnostic_diffs':diagnostic_diffs,'accept_language_diagnostic_diffs':acceptdiff,'catalog_equal':old['catalog']==new['catalog']}
    (scratch/'v1-diff.log').write_text('\n'.join(lines)); (scratch/'v1-summary.json').write_text(json.dumps(summary,ensure_ascii=False,indent=2)); print(json.dumps(summary,ensure_ascii=False))
```

### `/private/tmp/VerifyIntlIndependentTest.php`

```php
<?php
use App\Models\Insight;
use App\Models\InsightTranslation;
use App\Models\Lead;
use Illuminate\Support\Facades\View;
use Spatie\Honeypot\EncryptedTime;
use Tests\TestCase;

final class VerifyIntlIndependentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url'=>'https://j-curve.co.kr','honeypot.randomize_name_field_name'=>false]);
        app()->setLocale('ko');
        Illuminate\Support\Facades\URL::forceRootUrl('https://j-curve.co.kr');
        Illuminate\Support\Facades\URL::forceScheme('https');
        $this->withServerVariables(['HTTP_HOST'=>'j-curve.co.kr','HTTPS'=>'on']);
        $this->artisan('migrate:fresh',['--force'=>true])->assertExitCode(0);
        $this->seed(Database\Seeders\DatabaseSeeder::class);
    }
    private function probeViews(): void { View::getFinder()->prependLocation('/private/tmp/verify-intl-views'); View::getFinder()->flush(); }
    private function fields(array $extra=[]): array { return array_replace(['name'=>'Verifier','email'=>'verify@example.test','message'=>'Consultation','service_interest'=>'seo','my_name'=>'','valid_from'=>(string)EncryptedTime::create(now()->subSeconds(3))],$extra); }
    public function test_v4_controller_filters_and_real_pagination_urls(): void
    {
        $sample=Insight::whereHas('translations')->firstOrFail();
        // Actual templates do not exist yet: first record real status, then isolate controller with external probe views.
        printf("\nV4 actual translated detail status=%d\n",$this->get('/en/insights/mobile-marketing-strategies')->status());
        $this->probeViews();
        $this->get('/en/insights/mobile-marketing-strategies')->assertOk()->assertSee('[EN DRAFT]');
        $this->get('/ja/insights/mobile-marketing-strategies')->assertNotFound();
        $untranslated=Insight::published()->whereDoesntHave('translations')->firstOrFail();
        $this->get('/en/insights/'.rawurlencode($untranslated->slug))->assertNotFound();
        config(['seo.hidden_insights'=>array_merge(config('seo.hidden_insights'),[$sample->slug])]);
        $this->get('/en/insights/mobile-marketing-strategies')->assertNotFound();
        config(['seo.hidden_insights'=>[]]); $sample->update(['published_at'=>now()->addDay()]);
        $this->get('/en/insights/mobile-marketing-strategies')->assertNotFound(); $sample->update(['published_at'=>now()->subDay()]);
        $category=$sample->category;
        $this->get(route('en.insights.category',['slug'=>$category->slug],false))->assertOk();
        $this->get('/en/blog/seo/')->assertNotFound();
        foreach(range(1,13) as $i) {
            $s=$sample->replicate(); $s->slug='verifier-source-'.$i; $s->legacy_wr_id=null; $s->save();
            $s->translations()->create(['locale'=>'en','slug'=>'verifier-en-'.$i,'title'=>'Verifier '.$i,'content'=>'<p>English</p>','source_hash'=>hash('sha256',$s->content)]);
        }
        $response=$this->get('/en/blog/?page=2')->assertOk(); $pager=$response->viewData('insights');
        $this->assertCount(2,$pager->items()); $this->assertStringContainsString('/en/blog/?page=2',$pager->url(2));
        printf("V4 probe views: translated=200 missing/hidden/future=404 category-with=200 category-without=404 page2=%s items=%d\n",$pager->url(2),count($pager->items()));
        $sample->translations()->where('locale','en')->delete();
    }
    public function test_v7_locale_spoof_validation_and_xss_storage(): void
    {
        foreach(['en','ja','ko'] as $j=>$locale) foreach(['ko','xx'] as $i=>$spoof) {
            $this->withServerVariables(['REMOTE_ADDR'=>'192.0.2.'.(10+$j*2+$i)]);
            $path=($locale==='ko'?'':'/'.$locale).'/contact-us/'; $email=$locale.$spoof.'@example.test';
            $this->post($path,$this->fields(['email'=>$email,'locale'=>$spoof,'name'=>'<script>alert(1)</script>','message'=>'<script>alert(2)</script>']))->assertRedirect('https://j-curve.co.kr'.$path);
            $lead=Lead::where('email',$email)->firstOrFail(); $this->assertSame($locale==='ko'?null:$locale,$lead->locale);
            printf("\nV7 POST %s body.locale=%s stored.locale=%s\n",$path,$spoof,var_export($lead->locale,true));
        }
        foreach(['en'=>'The name field is required.','ja'=>'お名前は必須です。'] as $locale=>$message) {
            $this->withServerVariables(['REMOTE_ADDR'=>$locale==='en'?'192.0.2.30':'192.0.2.31']);
            $this->from('/login')->post('/'.$locale.'/contact-us/',['my_name'=>'','valid_from'=>(string)EncryptedTime::create(now()->subSeconds(3))])->assertRedirect('https://j-curve.co.kr/'.$locale.'/contact-us/')->assertSessionHasErrors(['name'=>$message]);
            printf("V7 validation %s=%s redirect=/%s/contact-us/\n",$locale,$message,$locale);
        }
        $this->get('/en/contact-us/')->assertNotFound(); $this->get('/ja/contact-us/')->assertNotFound();
        echo "V7 XSS redisplay NOT VERIFIED: actual foreign contact views return 404\n";
    }
    public function test_v7_csrf_honeypot_timer_and_throttle_actually_execute(): void
    {
        foreach(['en','ja'] as $i=>$locale) {
            $path='/'.$locale.'/contact-us/'; $this->app['env']='local';
            $r=$this->post($path,$this->fields()); $r->assertStatus(419); printf("\nV7 %s missing-CSRF=%d\n",$locale,$r->status());
            $this->app['env']='testing'; $before=Lead::count();
            $this->withServerVariables(['REMOTE_ADDR'=>'192.0.2.'.(50+$i)]);
            $r=$this->post($path,$this->fields(['my_name'=>'bot'])); $this->assertSame($before,Lead::count()); printf("V7 %s honeypot=%d lead_delta=0\n",$locale,$r->status());
            $r=$this->post($path,$this->fields(['valid_from'=>(string)EncryptedTime::create(now()->addMinutes(10))])); $this->assertSame($before,Lead::count()); printf("V7 %s future-timer=%d lead_delta=0\n",$locale,$r->status());
            $this->withServerVariables(['REMOTE_ADDR'=>'192.0.2.'.(60+$i)]); $codes=[];
            foreach(range(1,6) as $n) $codes[]=$this->post($path,$this->fields(['email'=>$locale.$n.'@example.test']))->status();
            $this->assertSame([302,302,302,302,302,429],$codes); printf("V7 %s throttle=%s\n",$locale,json_encode($codes));
        }
    }
    public function test_v8_single_application_cookie_session_does_not_choose_language(): void
    {
        foreach(['/en/'=>'en','/'=>'ko','/ja/'=>'ja','/about-us/'=>'ko'] as $path=>$lang) {
            $r=$this->withCookie('locale','ja')->withSession(['locale'=>'en'])->get($path)->assertOk(); $r->assertSee('<html lang="'.$lang.'"',false); $this->assertSame('ko',app()->getLocale());
            printf("\nV8 %s html.lang=%s app.locale.after=%s session.locale=en cookie.locale=ja\n",$path,$lang,app()->getLocale());
        }
    }
    public function test_v9_idempotence_stale_missing_source_and_cascade(): void
    {
        $before=InsightTranslation::orderBy('id')->get()->toArray(); $this->seed(Database\Seeders\IntlInsightSeeder::class); $this->seed(Database\Seeders\IntlInsightSeeder::class); $this->assertSame($before,InsightTranslation::orderBy('id')->get()->toArray());
        printf("\nV9 seeder twice identical rows=%d\n",count($before));
        $s=Insight::whereHas('translations')->firstOrFail(); $this->artisan('intl:stale')->expectsOutputToContain('Stale translations: 0')->assertExitCode(0);
        $s->update(['content'=>$s->content.'<p>Verifier change</p>']);
        $this->artisan('intl:stale')->expectsOutputToContain($s->slug)->expectsOutputToContain('Stale translations: 2')->assertExitCode(0);
        $s->delete(); $this->assertSame(0,InsightTranslation::count());
        $this->artisan('db:seed',['--class'=>Database\Seeders\IntlInsightSeeder::class])->expectsOutputToContain('INTL skipped missing ko_slug:')->assertExitCode(0);
        echo "V9 stale=0 -> content changed -> stale=2; delete -> translations=0; missing ko_slug warning observed\n";
    }
    public function test_v9_rollback_down_and_remigrate(): void
    {
        $this->artisan('migrate:rollback',['--step'=>2,'--force'=>true])->assertExitCode(0);
        $this->assertFalse(Illuminate\Support\Facades\Schema::hasTable('insight_translations'));
        $this->assertFalse(Illuminate\Support\Facades\Schema::hasColumn('leads','locale'));
        $this->artisan('migrate',['--force'=>true])->assertExitCode(0);
        $this->assertTrue(Illuminate\Support\Facades\Schema::hasTable('insight_translations'));
        $this->assertTrue(Illuminate\Support\Facades\Schema::hasColumn('leads','locale'));
        echo "\nV9 rollback down: translations table=false leads.locale=false; migrate: both=true\n";
    }
}
```

### `/private/tmp/verify_intl01_company.py`

```python
import pathlib,subprocess,os,json,base64,sys,difflib
s=pathlib.Path('/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/verify-intl-01.mEV4sm'); label=sys.argv[1]
env=os.environ.copy(); env.update(APP_ENV='testing',APP_DEBUG='false',APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=',APP_URL='https://j-curve.co.kr',APP_LOCALE='ko',SEO_PUBLIC_URL='https://j-curve.co.kr',DB_CONNECTION='sqlite',DB_DATABASE=str(s/'current.sqlite'),DB_URL='',SESSION_DRIVER='array',CACHE_STORE='array',VIEW_COMPILED_PATH=str(s/'current-views'))
command=['php','/private/tmp/verify_intl01.php',str(pathlib.Path.cwd()),'single',str(s/(label+'.json'))]
subprocess.run(command,env=env,check=True)
old=json.loads((s/'baseline.json').read_text())['pages'][base64.b64encode(b'/about-us/').decode()]['none']; new=json.loads((s/(label+'.json')).read_text())
a,b=[base64.b64decode(x['html']).decode() for x in [old,new]]
delta=''.join(difflib.unified_diff(a.splitlines(True),b.splitlines(True),fromfile='0662117/about-us/',tofile='current/about-us/',n=2))
text='Normalization=CSRF,Vite-only\nSTATUS_LOCATION_EQUAL='+str((old['status'],old['location'])==(new['status'],new['location']))+'\nHTML_EQUAL='+str(a==b)+'\n'+delta+'\nEXIT='+str(int(a!=b))
(s/(label+'.log')).write_text('$ python3 /private/tmp/verify_intl01_company.py '+label+'\n'+text); print(text); sys.exit(int(a!=b))
```

### `/private/tmp/verify_intl01_mutate_run.py`

```python
import os,pathlib,subprocess,sys,shlex
s=pathlib.Path('/var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/verify-intl-01.mEV4sm')
env=os.environ.copy(); env.update(DB_CONNECTION='sqlite',DB_DATABASE=':memory:',APP_KEY='base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=',VIEW_COMPILED_PATH=str(s/'mutant-views')); (s/'mutant-views').mkdir(exist_ok=True)
cmd=['php','artisan','test','--no-ansi','--filter',sys.argv[2]]
r=subprocess.run(cmd,env=env,stdout=subprocess.PIPE,stderr=subprocess.STDOUT,text=True)
(s/(sys.argv[1]+'.log')).write_text('$ '+shlex.join(cmd)+'\n'+r.stdout+'\nEXIT='+str(r.returncode)+'\n'); print(r.stdout); print('EXIT='+str(r.returncode))
```

### 임시 probe 뷰3개

`/private/tmp/verify-intl-views/intl/insights/show.php`:
```php
<?php echo htmlspecialchars($translation->title,ENT_QUOTES,'UTF-8'); ?>
```
`index.php`:
```php
<?php echo $insights->links(); ?>
```
`category.php`:
```php
<?php echo htmlspecialchars($category->slug,ENT_QUOTES,'UTF-8'); ?>
```

## 부록 B. 실행 보정 기록

- 독립 PHPUnit 초기 실행2회는 테스트 요청의 localhost/http 및 기본 app locale을 잘못 가정해 assertion 실패했다. 공개origin·https·ko를 명시한 뒤6/6·80assertions 통과했다. 제품 수정이나 테스트 제품조건 완화는 없었다.
- 최초8031서버는 root cwd로 Laravel router를 불러 index.php를 찾지 못해500이었다. 종료 후 **public cwd**로 다시 실행해 EN/JA200과 이상경로 검사를 완료했다. 금지 포트는 사용하지 않았다.
- ego 브라우저에서 첫 오류페이지 측정값을 인용하지 않았고 TaskSpace224를 닫았다. 실제 모바일 레이아웃 수치는 미검증으로 유지했다.
- 최종8031 listen=false 확인. §T 최종 원복 status/diff 해시는 위와 같았다.

## 보완 증거 — V3 preserved_map 글 별칭 전수

정적301과 별도로 preserved_map의 글 주소를 modern·정식·끝슬래시 변형으로 전부 펼쳐 EN/JA × GET/HEAD를 요청했다. 현재 이 원문 글들은 해당 언어 번역이 없어서48건 모두404·Location없음이 기대값이다. 실제 실패0이다. 전체 한국어 preserved_map을 정적·글로 나누어 빠짐없이 검사했으며, 이404 결과를301 통과 건수에 합산하지 않았다.

```text
$ php /private/tmp/verify_intl01_article301.php /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n probe /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/verify-intl-01.mEV4sm/probe-extra.json
PROBE variants=43 static=86 redirects=276 legacy=382
ARTICLE_ALIASES=48 failed=0 statuses={"404":48}

EXIT=0
```

| method | 요청(공통 원시 query 생략) | 상태 | Location | 기대 일치 |
| --- | --- | --- | --- | --- |
| GET | /en/insights/chrome-및-firefox에서-nofollow-링크를-확인하는-방법 | 404 | None | True |
| HEAD | /en/insights/chrome-및-firefox에서-nofollow-링크를-확인하는-방법 | 404 | None | True |
| GET | /en/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/ | 404 | None | True |
| HEAD | /en/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/ | 404 | None | True |
| GET | /en/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법 | 404 | None | True |
| HEAD | /en/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법 | 404 | None | True |
| GET | /en/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법// | 404 | None | True |
| HEAD | /en/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법// | 404 | None | True |
| GET | /ja/insights/chrome-및-firefox에서-nofollow-링크를-확인하는-방법 | 404 | None | True |
| HEAD | /ja/insights/chrome-및-firefox에서-nofollow-링크를-확인하는-방법 | 404 | None | True |
| GET | /ja/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/ | 404 | None | True |
| HEAD | /ja/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/ | 404 | None | True |
| GET | /ja/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법 | 404 | None | True |
| HEAD | /ja/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법 | 404 | None | True |
| GET | /ja/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법// | 404 | None | True |
| HEAD | /ja/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법// | 404 | None | True |
| GET | /en/insights/11가지-최고의-seo-실수와-이를-피하는-방법 | 404 | None | True |
| HEAD | /en/insights/11가지-최고의-seo-실수와-이를-피하는-방법 | 404 | None | True |
| GET | /en/seo/11가지-최고의-seo-실수와-이를-피하는-방법/ | 404 | None | True |
| HEAD | /en/seo/11가지-최고의-seo-실수와-이를-피하는-방법/ | 404 | None | True |
| GET | /en/seo/11가지-최고의-seo-실수와-이를-피하는-방법 | 404 | None | True |
| HEAD | /en/seo/11가지-최고의-seo-실수와-이를-피하는-방법 | 404 | None | True |
| GET | /en/seo/11가지-최고의-seo-실수와-이를-피하는-방법// | 404 | None | True |
| HEAD | /en/seo/11가지-최고의-seo-실수와-이를-피하는-방법// | 404 | None | True |
| GET | /ja/insights/11가지-최고의-seo-실수와-이를-피하는-방법 | 404 | None | True |
| HEAD | /ja/insights/11가지-최고의-seo-실수와-이를-피하는-방법 | 404 | None | True |
| GET | /ja/seo/11가지-최고의-seo-실수와-이를-피하는-방법/ | 404 | None | True |
| HEAD | /ja/seo/11가지-최고의-seo-실수와-이를-피하는-방법/ | 404 | None | True |
| GET | /ja/seo/11가지-최고의-seo-실수와-이를-피하는-방법 | 404 | None | True |
| HEAD | /ja/seo/11가지-최고의-seo-실수와-이를-피하는-방법 | 404 | None | True |
| GET | /ja/seo/11가지-최고의-seo-실수와-이를-피하는-방법// | 404 | None | True |
| HEAD | /ja/seo/11가지-최고의-seo-실수와-이를-피하는-방법// | 404 | None | True |
| GET | /en/insights/경쟁자를-압도하는-6가지-고급-링크-구축-전략 | 404 | None | True |
| HEAD | /en/insights/경쟁자를-압도하는-6가지-고급-링크-구축-전략 | 404 | None | True |
| GET | /en/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/ | 404 | None | True |
| HEAD | /en/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/ | 404 | None | True |
| GET | /en/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략 | 404 | None | True |
| HEAD | /en/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략 | 404 | None | True |
| GET | /en/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략// | 404 | None | True |
| HEAD | /en/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략// | 404 | None | True |
| GET | /ja/insights/경쟁자를-압도하는-6가지-고급-링크-구축-전략 | 404 | None | True |
| HEAD | /ja/insights/경쟁자를-압도하는-6가지-고급-링크-구축-전략 | 404 | None | True |
| GET | /ja/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/ | 404 | None | True |
| HEAD | /ja/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/ | 404 | None | True |
| GET | /ja/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략 | 404 | None | True |
| HEAD | /ja/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략 | 404 | None | True |
| GET | /ja/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략// | 404 | None | True |
| HEAD | /ja/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략// | 404 | None | True |

### 보완 실행 코드

다른 harness와 같은 환경에서 다음 파일을 실행했다.

```php
<?php
require '/private/tmp/verify_intl01.php';
$rows=[];
$query='?x=1&x=2&q=a%2Fb&encoded=%ED%95%9C%EA%B8%80&blank=&plus=a+b';
foreach(config('seo.preserved_map') as $modern=>$canonical) {
    if(!preg_match('~^/insights/(?!category/)(.+)$~u',$modern,$match)) continue;
    $insight=App\Models\Insight::query()->published()->where('slug',rawurldecode($match[1]))->first();
    foreach(['en','ja'] as $locale) {
        $translation=$insight?->translation($locale)->first();
        $expected=$translation?'https://j-curve.co.kr/'.$locale.'/insights/'.$translation->slug.$query:null;
        foreach(array_unique([$modern,$canonical,rtrim($canonical,'/'),$canonical.'/']) as $alias) foreach(['GET','HEAD'] as $method) {
            $p='/'.$locale.$alias.$query; $r=req($p,$method); $dest=$r->headers->get('Location');
            $follow=$dest?req(pathonly($dest),$method):null;
            $rows[]=['path'=>$p,'method'=>$method,'status'=>$r->getStatusCode(),'location'=>$dest,'expected'=>$expected,'follow_status'=>$follow?->getStatusCode(),'follow_location'=>$follow?->headers->get('Location'),'pass'=>$translation?($r->getStatusCode()===301&&$dest===$expected&&$follow?->getStatusCode()!==301):($r->getStatusCode()===404&&$dest===null)];
        }
    }
}
file_put_contents(dirname($out).'/article301.json',json_encode($rows,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
echo 'ARTICLE_ALIASES='.count($rows).' failed='.count(array_filter($rows,fn($r)=>!$r['pass'])).' statuses='.json_encode(array_count_values(array_column($rows,'status')))."\n";

```

## 최종 상태·정리 한계

§T 원복 후, 이 결과 문서만 추가한 상태에서 다시 실제 실행했다.

```text
status excluding result SHA1=ab6026cc63ea30f875514e86647aa6eaeec5290a
diff SHA1=a91133964b5460cecce5e2916432540d41107d0d
8031 listening=False
```

기존 source/status는 시작과 같고, 이번 세션의 영구 산출물은 이 문서1개다. V11의 프론트 빌드는 ignored `public/build` 산출물을 갱신했지만 추적 소스·미디어는 변경하지 않았다.

지시서의 임시폴더 삭제를 시도했으나 PreToolUse 자동 안전 검토가 **재귀 삭제는 별도 승인 없이는 금지**라는 사유로 실행 전 차단했다. 삭제를 다른 도구로 우회하지 않았다. 따라서 ‘임시폴더 삭제 완료’ 조건은 미완료다. 오류 원문:

```text
Command blocked by PreToolUse hook: 🚨 차단됨: rm -r (폐기용 폴더 외 재귀 삭제)
사용자 승인 없이는 실행 금지.
```

차단된 실제 명령의 삭제 대상은 이번 세션이 만든 다음 경로뿐이었다.

```sh
rm -rf -- /var/folders/_s/jxm41njj5198jwlz0rcc8p1m0000gn/T/verify-intl-01.mEV4sm /private/tmp/verify-intl-views
rm -f -- /private/tmp/verify_intl01.php /private/tmp/verify_intl01_run.py /private/tmp/VerifyIntlIndependentTest.php /private/tmp/verify_intl01_mutate_run.py /private/tmp/verify_intl01_company.py /private/tmp/verify_intl01_report.py /private/tmp/verify_intl01_article301.php
```

전체 명령이 실행 전 차단되어 위 폴더·스크립트는 남아 있다. 최종 read-only 확인:

```text
temporary archive/SQLite/snapshots exist=True
external probe views exist=True
8031 listening=False
```

다음 단계(화면 확장)로 넘어가도 안 됨 — V1 엄격 비교 통과 근거와 V5 실제 존재/상호참조 계약이 미충족이고, V4·V7의 실제 화면 조건·기본 빌드·모바일 증거의 한계가 남아 있음.
