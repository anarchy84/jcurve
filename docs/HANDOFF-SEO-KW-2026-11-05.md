# 인수인계 — 키워드 상위노출 SEO·GEO·AEO (SEO-KW-01/02) · 2026-11-05

> 다음 세션은 이 파일부터 읽는다. 작성: Claude (2026-11-05 11시, 세션 종료 전)

## TL;DR
- **코드는 끝, 운영은 아직.** 모든 작업이 main `e560e1f` 에 푸시돼 있다(제코 승인). 운영 j-curve.co.kr 에는 **아직 안 올라갔다** — 11/05 11:10 확인: `/llms.txt`·`/self-marketing/shopping`·새 글 모두 404, 홈에 새 구조화 데이터 없음.
- 봇(클로드봇)에게 배포를 요청했다: #101-김대웅-업무 11/04 17:41 글(ts `1793781679.850679`). **답 없음.**
- `/v1` 옛 주소 62개(칼럼 50개 404 · 옛 서비스 12개 옛 화면 200) 넘기기 RewriteRule 요청(11/04 15:58, ts `1793775492.201209`)도 **답 없음.**
- 테스트 283/283 · 바꾼 PHP Pint 통과 · 독립 검증 18/19(1건은 지시서 문구, 문제없음 판정) · 무력화 실험 전부 빨강 확인.

## 목표 키워드 → 담당 페이지 (겹치지 않게 하나씩)
| 키워드 | 페이지 |
|---|---|
| 네이버 플레이스 상위노출 · 플레이스 상위 · 플레이스 노출 | `/naver-place-marketing/` (원주소) |
| 플레이스 리워드 | `/self-marketing/place` |
| 쇼핑 상위노출 · 스마트스토어 상위노출 | `/naver-shopping-marketing/` (원주소, 제목·설명에 「·스마트스토어」 추가 = 의도된 변경) |
| 쇼핑 유입 · 쇼핑 리워드 | `/self-marketing/shopping` (새 페이지) |
| 플레이스 순위 · 쇼핑 순위 | `/solutions/rankfree` |
| 리워드 광고 · 오퍼월 | `/services/reward-network` |
| 보조 글 5편 | `/insights/` 아래 — 플레이스 순위 올리는 법 · 플레이스 리워드란 · 스마트스토어 상위노출 방법 · 쇼핑 유입 리워드 · 오퍼월이란 |

「쇼핑 유입플」은 뜻이 불분명해 「쇼핑 유입」으로 처리했다.

## 한 일 (main `e560e1f` 에 전부 포함)
**사이트 구조 (Codex, SEO-KW-01A)**
- `robots.txt` 검색·AI 크롤러 명시 허용, `/llms.txt`(text/plain), 사이트맵 빈 묶음 제외·이미지·lastmod, `/manager/data/*` → `/v1/manager/data/*` 301(옛 칼럼 이미지 84개).

**화면·구조화 데이터 (Claude)**
- `partials/jc/head.blade.php`: Organization·WebSite·WebPage 그래프(전 페이지) + 페이지가 `@section('sd_page'|'sd_crumbs'|'sd_service')` 를 두면 BreadcrumbList·Service 추가.
- `partials/jc/schema-faq.blade.php`(새 부품): 화면 FAQ 배열 → FAQPage. 셀프마케팅 3곳·솔루션 5곳에 적용(솔루션 FAQ 는 하드코딩 → 배열, 문구 동일 검증됨).
- 구조화 데이터 범위: FAQPage 30→38 페이지, BreadcrumbList 19→39, Service 19→34.
- `insights/show.blade.php`: BlogPosting·Breadcrumb·article 메타, 본문 「자주 묻는 질문」 h2 아래 h3/p → FAQPage, **설명문 잘림 버그 수정**(Str::limit 이 한글을 2칸으로 세 77자에서 잘림 → 글자 수 160), 작성자 표기 「제이커브」(화면·스키마).
- 새 페이지 `/self-marketing/shopping`, 플레이스·리워드·랭크프리 제목·설명·섹션 보강, 푸터 셀프마케팅 아래 「플레이스 리워드」「쇼핑 리워드」 링크(전 페이지), 셀프마케팅 허브 쇼핑 카드 링크.
- 로그인류 `noindex`·제목, 글 0편 카테고리 `noindex`(원주소 `/blog/seo/`·`/blog/link-building/` 제외).

**콘텐츠 (Claude 원고, Codex 시더 — SEO-KW-01B/B2/C)**
- `/naver-place-marketing/`·`/naver-shopping-marketing/` 순위 기준 섹션·FAQ(`config/subpages.php`).
- 새 글 5편(`docs/content/articles/kw01/` 원고 = `database/content/kw01/` 사본, 바이트 동일) — 정의 먼저, 질문형 H2, FAQ 3개씩, 비교표 3개.
- 옛 칼럼 설명 49편 새로 씀(`docs/content/insight-meta-2026-11-04.json` = 사본 `insight-meta.json`) — 상투 설명 33 + 설명 없던 16.
- 중복 글 `2019년-그로스해커에게-필요한-스킬3-1` 비공개 + `…스킬3` 로 301, 체인 제거.
- 시더: `KeywordInsightSeeder`(DatabaseSeeder 에 미등록, 단독 실행). 작성자 = `jcurve19@gmail.com` 계정(LegacyContentSeeder 와 같음). 여러 번 돌려도 같음.

## 다음 세션이 할 일 (순서대로)
1. **봇 배포 확인** — #101 의 17:41 글에 답이 왔는지 본다. 배포 명령(봇에게 이미 보낸 것):
   `git pull`(main `e560e1f`) → `php artisan db:seed --class=KeywordInsightSeeder --force` → `php artisan optimize:clear`(캐시 쓰면 `php artisan optimize`). npm 빌드 불필요.
   봇 요청은 **채널 새 글로, 클로드봇(U0C4GJPUT0Q)만 태그**, 짧게(형도 읽음). 김태훈 태그·DM 금지.
2. **배포 후 운영 점검** (전부 읽기 전용 GET, 도구는 git 제외 폴더 `storage/app/intl-handoff/tools/`):
   - `python3 -I storage/app/intl-handoff/tools/prod_check.py` — 원주소 16개·301/410 표본·사이트맵·문의 폼.
   - `python3 -I storage/app/intl-handoff/tools/seo_prod_crawl.py <출력.json>` — 운영 전 페이지 SEO 전수.
   - `python3 -I storage/app/intl-handoff/tools/seo_legacy_redirect_check.py storage/app/intl-handoff/tools/legacy_redirects-2026-11-04.json <출력.json>` — 이전표 전부 301→200 확인(봇이 `/v1` RewriteRule 넣은 뒤 62개 재확인).
   - `seo_local_audit.py` 는 로컬 서버(127.0.0.1:8031, Host=j-curve.co.kr)용 구조 점검(FAQPage·Breadcrumb·Service·alt·설명 길이).
   - 손 확인: `/llms.txt` 200, `/self-marketing/shopping` 200, 새 글 5편 200·FAQPage, 홈 JSON-LD, 푸터 리워드 링크, 옛 칼럼 설명 교체.
3. `/v1` RewriteRule 답이 오면 62개 재확인 후 제코에게 보고.

## 정해진 것 (다시 묻지 말 것)
- **구글 서치콘솔·네이버 서치어드바이저는 다른 사람이 관리 — 손대지 않는다**(등록·확인 태그·사이트맵 제출 금지). head 의 기존 `google-site-verification`(-JI9b9…) 1개만 둔다.
- **공식 SNS 채널 없음** → Organization `sameAs` 넣지 않음. **글 작성자 = 「제이커브」.**
- 순위·매출 보장 문구 금지(부정문만), 구매·구매평·리뷰 생성 제공 안 함. 성과 수치(373억·128만·15,700)와 라벨 임의 수정 금지. `public/media/**` 덮어쓰기 금지.
- 원주소 16개 제목·설명 보존. 예외는 `/naver-shopping-marketing/` 「·스마트스토어」 한 곳(제코 지시).
- Slack 감시 루프는 제코가 끄라고 함(11/04). 필요할 때 한 번씩만 본다.

## 남은 개선 거리 (급하지 않음)
- 다국어(`/en`·`/ja`, worktree `i18n`) 합칠 때 hreflang.
- 운영 배포 뒤 페이지 속도(Core Web Vitals) 측정 — 히어로 풀사이즈 비디오 LCP 위험.
- 옛 칼럼 이미지 216개 중 182개 width/height 없음(CLS), alt 없음 3개.
- 서비스 하위 12페이지 설명 56~66자로 짧음, `/privacy` 설명 없음, 카테고리 설명문 일반 문구.
- `/blog/link-building/` 원주소인데 운영 글 0편(얇은 페이지).
- Pint 실패 2파일(`app/Services/Seo/OnPageAuditor.php`·`UrlGuard.php`)은 이번 작업 전부터 있던 것.
- 네이버 상업 키워드는 블로그·VIEW·광고 비중이 커서 홈페이지만으로 한계 — 외부 네이버 블로그 콘텐츠가 다음 단계 후보.

## 문서·증거 위치
- 지시서: `docs/SPEC-CODEX-SEO-KW-01A.md` · `01B.md` · `01B2.md` · `01C.md` · `01D.md` · 검증 `01-VERIFY.md`
- 결과: `tests/SEO-KW-01A-RESULT.md` · `01B` · `01C` · `01D` · 독립 검증 `tests/SEO-KW-01-VERIFY-RESULT.md`, 무력화 증거 `tests/SEO-KW-01C-EVIDENCE/`
- 테스트: `tests/Feature/SeoKeywordFoundationTest.php` · `KeywordInsightTest.php` · `SeoKeywordViewsTest.php`
- 분담: 화면·문구·원고·구조화 데이터 설계 = Claude / 서버·시더·테스트 = Codex / 독립 검증 = 별도 Codex 세션 / 최종 판정 = Claude
