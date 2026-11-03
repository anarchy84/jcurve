# SPEC-CODEX-INTL-01 — 다국어 기반 (Codex 구현 세션)

- 작성: Claude, 2026-11-03. **작업 위치: `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n` (브랜치 `wip/2026-11-03-i18n`, 기준 `0662117`). 원래 폴더 `/Users/anarchy/Claude_Projects/jcurve` 는 절대 건드리지 말 것(운영 전환 대기 중인 main).**
- 정본: `docs/intl/INTL-PLAN.md` — 먼저 읽는다. 특히 §1 절대 원칙, §2 주소 규칙, §4 구조.
- 함께 읽을 것: `docs/COLLAB.md`, `config/seo.php`(preserved_map), `app/Http/Middleware/PreservePublicUrls.php`, `app/Services/Seo/Publishing/{PreservedPaths,PreservedUrlGenerator,FeedCatalog,PublicUrl}.php`, `routes/web.php`, `routes/pages.php`.

## ⛔ 규칙
- 소유(이번 작업): `app/**`, `config/intl.php`(신규), `routes/**`, `bootstrap/**`, `database/migrations/**`(신규 파일만), `database/seeders/IntlInsightSeeder.php`(신규)·`DatabaseSeeder.php`(호출 추가), `database/content/intl/**`(틀·예시 1개), `lang/{en,ja}/validation.php`·`lang/{en,ja}/intl.php`(공통 문구 틀), `tests/**`, `composer.json`(autoload files 추가가 필요하면).
- 금지: `resources/views/**` 의 **기존 파일**(한국어 화면) — 수정 금지. 새 파일은 `resources/views/intl/pages/home.blade.php` 하나만(파이프라인 확인용 최소 화면, 문구는 `lang/{en,ja}/pages/home.php` 에서 — 이 두 파일도 최소 틀만). `public/media/**`, `.env`(작업 폴더의 `.env` 는 로컬 시험용이라 읽어도 되지만 값 변경 금지), `WorkSeeder`. 커밋·푸시·브랜치 변경 금지. 포트 8000·8014 서버 금지(쓰려면 8020 대).
- 한국어 응답은 이 작업으로 **한 바이트도 바뀌면 안 된다**(아직 hreflang 도 Claude 가 2단계에서 넣는다).

## 만들 것
1. `config/intl.php` — INTL-PLAN §4 그대로. `routes` 목록 = §3 범위의 한국어 라우트 이름(존재하는 것만; 존재 여부는 실제 라우트로 확인해서 목록 확정, 반환물에 표로).
2. **외국어 라우트** — `en`·`ja` 접두, 이름 `en.<한국어 라우트 이름>`. 같은 컨트롤러. 언어 미들웨어(`SetIntlLocale`)가 `app()->setLocale()`.
   - 주소는 INTL-PLAN §2: `/en` + 한국어 정식 주소. 정식 주소 200, 한국어 쪽에서 301 되는 경로·끝 슬래시 변형은 외국어에서도 **301 1홉**(쿼리 보존). `PreservedPaths`·`PreservedUrlGenerator`·`PreservePublicUrls` 를 접두 인식하도록 확장 — `route('en.company')` 는 `/en/about-us/` 를 만든다.
   - 블로그 글: `/{locale}/insights/{번역 slug}`. 번역 없는 글·숨김 글 404.
   - §2 제외 목록은 외국어 라우트 없음 → 404.
3. **도우미** — `intl_locale()`, `intl_route()`, `intl_alternates()`, `intl_view()` (INTL-PLAN §4 계약 그대로). `intl_alternates()` 는 `['ko' => 절대URL, 'en' => …, 'ja' => …]` 중 실제로 존재하는 것만(글은 번역 유무로 판단), 공개 주소 기준(`SEO_PUBLIC_URL`).
4. **컨트롤러** — 외국어 요청이면 `intl_view()` 로 `intl.<뷰>` 를 렌더(없으면 404). 한국어 경로는 기존과 완전히 같은 동작.
   - `InsightController`: 외국어면 해당 언어 번역이 있는 공개 글만 목록·카테고리·상세. 뷰에 `$insight` 와 `$translation` 을 함께 넘긴다.
   - `PageController::home`: 외국어면 최신 번역 글 3건을 `$insights`(+각 `translation` 관계 로드)로.
5. **번역 테이블** — 마이그레이션 `insight_translations`(INTL-PLAN §4 칼럼·유일키, insight 삭제 시 cascade), 모델 `InsightTranslation`, `Insight::translations()`·`translation(?string $locale)`.
6. **시더** `IntlInsightSeeder` — `database/content/intl/insights/*.json` 읽어 upsert(멱등, 기존 행 갱신). JSON 형식: `{"ko_slug": "...", "source_hash": "...", "en": {"slug","title","excerpt","content","meta_title","meta_description"}, "ja": {...}}`. `ko_slug` 로 글을 찾고 없으면 건너뛰며 경고. 예시 파일 1개(아무 공개 글, 문구는 `[EN DRAFT]`·`[JA DRAFT]` 표시된 임시값)로 파이프라인 시험. `DatabaseSeeder` 에 호출 추가(WorkSeeder 는 그대로 빠져 있어야 함).
   - 아티즌 명령 `intl:stale` — 번역의 `source_hash` 와 현재 한국어 표시본 해시가 다른 글 목록 출력.
7. **문의** — 접수 테이블은 `leads`(`App\Models\Lead`, `ContactController::store`). 마이그레이션으로 `leads.locale`(nullable, 빈 값 = 한국어) 추가. 외국어 문의는 `POST /{locale}/contact-us/`(이름 `en.contact.store` 등)로 같은 접수 처리(검증 규칙·UTM 세션·미들웨어 그대로), locale 은 **요청 주소의 접두에서만** 정한다(폼 숨김 필드를 믿지 않는다). 완료·오류 후 `/{locale}/contact-us/` 로(`status=inquiry-received` 플래시 그대로). 검증 메시지는 `lang/{en,ja}/validation.php`(Laravel 기본 판 번역, 필드명 attributes 포함). 한국어 `POST` 는 기존과 동일하게 `locale` = null.
8. **사이트맵** — `FeedCatalog` 에 외국어 주소 추가(대상 라우트 × 언어, 번역 글). 한국어 항목 순서·내용 그대로.
9. **최소 외국어 홈** — `resources/views/intl/pages/home.blade.php`: 기존 레이아웃 재사용 금지(한국어 헤더가 섞임) → `<html lang>`·`<title>`·canonical·hreflang·`og:locale` 만 갖춘 단순 화면에 `__('pages/home.title')` 출력. 2단계에서 Claude 가 전부 다시 만든다.

## 테스트 (`tests/Feature/Intl*`)
- 대상 라우트 × en·ja 정식 주소 200(뷰가 없는 페이지는 404 가 정상이므로 지금은 홈만 200, 나머지는 「뷰 없음 404」를 확인 — 2단계 이후 Claude 가 뷰를 만들면 200 으로 바뀌는 구조여야 함), 제외 목록 404, 301 변형 1홉, 쿼리 보존.
- `route('en.company') === …/en/about-us/` 등 주소 생성.
- `intl_alternates()` 가 글 번역 유무를 반영.
- 시더 멱등·갱신, `intl:stale` 감지.
- 문의: en·ja 접수 시 `leads.locale` 저장, 한국어 접수는 null, 폼에 `locale=xx` 를 넣어도 주소 접두가 이김, 오류 메시지 언어.
- **한국어 무변경**: 사이트맵의 한국어 주소 전부 + 원주소 16개를 렌더한 HTML 이 이 작업 전(기준 `0662117`)과 바이트 동일(CSRF 토큰·Vite 해시처럼 요청마다 달라지는 값만 정규화, 정규화 규칙은 반환물에 명시). 기준 코드는 `git archive 0662117 | tar -x -C "$TMPDIR/intl-base"` 처럼 git 쓰기 없이 풀고(`git worktree add` 는 원래 저장소 .git 에 쓰므로 금지), `vendor`·`node_modules`·`public/build` 는 작업 폴더 것을 심볼릭 링크. 같은 시더·같은 환경변수(`SEO_PUBLIC_URL=https://j-curve.co.kr`, 임시 SQLite)로 양쪽을 렌더해 비교. 테스트로 남길 수 없으면 반환물에 실행 기록·비교 결과(페이지 수·차이 수). 끝나면 임시 폴더 삭제.
- 기존 테스트 전부 그대로 통과.

## 합격 게이트
`php artisan test` 전체 그린(개수), 변경·신규 PHP `pint --test`, `npm run build`. 무력화 실험: ① 접두 인식 리다이렉트를 끄면 301 테스트가 빨개짐 ② 번역 없는 글 404 처리를 끄면 해당 테스트가 빨개짐 — 원복 후 `git diff | shasum` 동일.

## 반환물
`docs/intl/INTL-01-IMPL-RESULT.md`: 확정한 대상 라우트 표, 변경 파일, 도우미·라우트 이름 계약(2단계 Claude 가 그대로 씀), 실행 명령·실제 출력, 무력화 실험, 미검증 항목.
