# SPEC-CODEX-SEO-KW-01B2 — B 보정: 새 글 작성자 (구현 지시서)

- 작업 ID: SEO-KW-01B2 · 작성: Claude 2026-11-04 · 기준: 지금 작업 폴더(HEAD `c9cf526` + 미커밋분)
- 앞 작업: `docs/SPEC-CODEX-SEO-KW-01B.md`, 결과 `tests/SEO-KW-01B-RESULT.md`

## 원인
B3 지시서의 `user_id = null` 은 Claude 지시서 오류다. `insights.user_id` 는 NOT NULL 이다(마이그레이션 `2026_08_04_000007`). **스키마는 바꾸지 않는다.**

## 고칠 것
1. `database/seeders/KeywordInsightSeeder.php` — 새 글 5편의 작성자를 `LegacyContentSeeder` 와 **같은 계정**으로 한다.
   `LegacyContentSeeder::run()` 맨 앞의 `User::query()->firstOrCreate(['email' => 'jcurve19@gmail.com'], [...])` 와 같은 조건·같은 기본값으로 작성자를 확보해 `user_id` 에 넣는다(`LegacyContentSeeder.php` 는 수정하지 말 것).
   이미 있는 계정이면 그대로 쓰고, 이름·권한 등 기존 계정 값을 바꾸지 않는다.
2. `tests/Feature/KeywordInsightTest.php` — 막혀 있던 5개 테스트가 통과해야 한다. 기대값을 완화하지 말 것. 추가로:
   - 새 글 5편의 `user_id` 가 `jcurve19@gmail.com` 계정 id 와 같다.
   - 시더를 두 번 돌려도 users 가 늘지 않는다(계정 1개).
3. `tests/SEO-KW-01B-RESULT.md` 를 최신 결과로 고쳐 쓴다(상태, 전체 테스트 실제 출력, 바꾼 기존 테스트 기대값 목록).

## 소유 파일
`database/seeders/KeywordInsightSeeder.php`, `tests/Feature/KeywordInsightTest.php`, `tests/SEO-KW-01B-RESULT.md`

## 금지 파일
그 밖 전부. 특히 `database/migrations/**`, `database/seeders/LegacyContentSeeder.php`, `resources/views/**`, `config/**`, `routes/**`, `public/**`, `docs/**`, `.env`. git 쓰기 명령 금지. 운영 DB 접속·실행 금지.

## 합격 게이트
`php artisan test` 전부 초록(실제 출력) · `./vendor/bin/pint --test database/seeders/KeywordInsightSeeder.php tests/Feature/KeywordInsightTest.php` · `npm run build` 는 이번에 프론트 변경이 없으니 생략.

## 반환물
diff · 실행 명령과 실제 출력 · 미검증 항목.
