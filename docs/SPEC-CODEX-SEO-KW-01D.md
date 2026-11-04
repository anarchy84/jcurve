# SPEC-CODEX-SEO-KW-01D — 글 작성자 「제이커브」 테스트 (구현 + 무력화)

- 작업 ID: SEO-KW-01D · 작성: Claude 2026-11-04 · 기준: 지금 작업 폴더
- Claude 변경: `resources/views/insights/show.blade.php` — 글 작성자 표기를 「제이커브」 하나로(제코 지시). 화면 `글 <strong>…</strong>` 와 BlogPosting `author.name` 모두. 회사 계정 별명 `jcurve` 가 보이던 것을 바로잡음.

## 소유 파일
`tests/Feature/SeoKeywordViewsTest.php`, `tests/SEO-KW-01D-RESULT.md`

## 금지 파일
그 밖 전부(화면은 무력화 실험의 임시 되돌림만 허용, 실험 뒤 원상복구 + `git diff --stat -- resources/views` 출력으로 증명). git 쓰기 금지. 운영 DB 금지.

## 테스트
1. 작성자 계정(nickname `jcurve`)으로 만든 공개 인사이트 1편과 작성자 계정이 다른 이름인 인사이트 1편: 화면에 `글 <strong>제이커브</strong>` 가 있고 `jcurve` 가 작성자 칸에 보이지 않는다.
2. BlogPosting `author` = `{"@type":"Organization","@id":"https://j-curve.co.kr/#organization","name":"제이커브","url":"https://j-curve.co.kr/about-us/"}`.

## 무력화
`$author = '제이커브';` 를 예전 식 `$insight->user ? ($insight->user->nickname ?: $insight->user->name) : '제이커브인터렉티브'` 로 임시 되돌림 → 1·2 빨강 확인 → 복구.

## 합격 게이트
`php artisan test` 전부 초록(실제 출력, VIEW_COMPILED_PATH=/private/tmp/jcurve-seo-kw-01d/views) · `./vendor/bin/pint --test tests/Feature/SeoKeywordViewsTest.php` · 무력화 결과 · 화면 diff 실험 전과 동일.

## 반환물
`tests/SEO-KW-01D-RESULT.md`: diff, 실제 출력, 무력화 표.
