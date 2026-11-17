# SPEC-CODEX-SEO-KW-04-IMPL — 오퍼월 연관 키워드·GEO 방법론 보강에 맞춰 테스트 갱신

- 작업 ID: SEO-KW-04-IMPL (2026-11-17, Claude 작성)
- 작업 위치: worktree `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/geo-offerwall` (브랜치 `wip/2026-11-17-geo-offerwall`, 기준 커밋 `7611421` = origin/main)
- 배경: Claude가 콘텐츠(화면 문구·글)를 이미 작성함(작업 트리 변경, 미커밋). 너는 **테스트만** 새 콘텐츠에 맞추고 전체 테스트를 돌린다.

## Claude가 이미 바꾼 것 (읽기만, 고치지 마)
- `resources/views/services/offerwall.blade.php` — 섹션 `#compare`(오퍼월·앱테크·포인트 충전소·리워드 광고 비교표), `#choose`(오퍼월 업체 고르는 기준 6개) 추가, 로컬 내비 2개, FAQ 6→9개(단가·앱테크·업체 추가, SDK 질문 문구 변경), meta description 교체, 관련 글 링크 2개 추가
- `resources/views/services/seo/geo.blade.php` — 섹션 `#geo-readable` `#geo-quality` `#geo-questions` `#geo-metrics` 추가, 진행 과정 2단계 문구 변경, 제공 항목 6→8개, FAQ 5→9개, monitoring/faq 배경 클래스 교대, 관련 글 subcard 2개, meta description 교체
- `database/content/kw01/manifest.json` — 글 4편 추가(총 9편), `database/content/kw01/06~09-*.html` 새 파일
- `docs/content/articles/kw01/` — 위 manifest·06~09 승인본 사본(바이트 동일)
- `resources/views/seo/llms.blade.php`, `public/llms.txt` — 오퍼월·GEO 설명 한 줄씩 보강

## 할 일 (소유 파일: `tests/Feature/**` 만)
1. `tests/Feature/KeywordInsightTest.php` — 글 수 5 → 9(`assertDatabaseCount`, published count, `Keyword insights upserted: 9` 출력). 테스트 이름에 five가 있으면 nine 으로. 새 4편의 slug·category(`reward` 2, `seo` 2)를 확인하는 단언을 기존 패턴대로 추가.
2. `tests/Feature/OfferwallPageTest.php` — FAQ 상한 6 → 9. `#compare` `#choose` 섹션 존재, FAQPage JSON-LD 질문 목록 = 화면 FAQ 목록(기존 단언 유지), meta description 160자 이하·키워드(`오퍼월`, `오퍼월 도입`, `앱 수익화`, `연동`, `단가`, `앱테크`) 포함 단언 추가. 관련 글 링크 2개가 `route('insights.show', …)` 주소로 나오는지.
3. GEO 페이지 테스트가 있으면(`SeoKeywordViewsTest` 등 grep `seo/geo`, `seoGeo`) 새 FAQ 수(9)·FAQPage JSON-LD 일치·새 섹션 id 4개 존재 단언을 추가/갱신. 없으면 `tests/Feature/GeoPageTest.php` 새로 만들어 위 내용 + meta description 160자 이하.
4. 전체 테스트 실행: `php artisan test` (PHP 8.5 로컬, vendor·public/build·.env 는 이미 복사해 둠 — git 에 넣지 마). 실패가 내 변경 밖(기존부터 실패)이면 `git stash` 쓰지 말고, 변경 전 기준(`git worktree` 새로 만들지 말고) 해당 테스트만 원인 설명.

## 금지
- `resources/**`, `database/**`, `docs/content/**`, `public/**`, `routes/**`, `app/**`, `config/**` 수정 금지(콘텐츠는 Claude 구역). 테스트를 통과시키려고 콘텐츠를 바꾸지 마라 — 콘텐츠가 틀렸다고 보면 반환물에 적어라.
- 커밋·푸시·배포·`git stash`·`git reset` 금지.
- 단언 약화 금지(기존 단언 삭제는 숫자 갱신 외 금지).

## 합격 게이트
- `php artisan test` 전부 통과(실제 출력 마지막 요약 붙일 것). 실패 0, 기존부터 깨진 게 있으면 목록·원인.

## 반환물
- 변경 파일 목록 + `git diff --stat` + 핵심 diff
- 실행 명령과 실제 출력(요약 줄 포함)
- 미검증 항목
