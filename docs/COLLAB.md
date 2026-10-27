# Claude ↔ Codex 협업 규칙 — jcurve

> 2026-10-27 대웅 승인. **두 에이전트 모두 작업 시작 전에 이 문서와 [`docs/collab/QUEUE.md`](collab/QUEUE.md)를 읽는다.**
> 기획 기준(SSOT)은 [`docs/PLAN-FINAL.md`](PLAN-FINAL.md). 이 문서는 "누가 어떤 파일을 만지고, 어떻게 서로 요청하는가"만 정한다.

## 1. 역할

| 담당 | 맡는 일 |
|---|---|
| **Claude** (클로드코드) | 프론트엔드(Blade 화면·CSS·JS), 디자인(Claude Design 와꾸·디자인 시스템), 콘텐츠(페이지 카피·칼럼 원고) |
| **Codex** | 백엔드(컨트롤러·모델·DB·마이그레이션·시더·라우트·어드민·sitemap/RSS/IndexNow·리다이렉트·미들웨어·테스트·배포 스크립트) |
| **대웅** | 결정·검수·커밋/푸시·서버 담당(형님) 전달 |

## 2. 파일 구역 — 내 구역 밖 파일은 직접 저장하지 않는다

| 구역 | 소유 | 경로 |
|---|---|---|
| 화면 | Claude | `resources/views/**` (Blade **익명 컴포넌트만**. PHP 클래스 컴포넌트가 필요하면 Codex에 요청), `resources/css/**`, `resources/js/**` |
| 프론트 빌드 | Claude | `package.json`, `package-lock.json`, `tailwind.config.js`, `vite.config.js`, `postcss.config.js` |
| 정적 에셋 | Claude | `public/images/**`, `public/fonts/**` |
| 미디어 | 둘 다 **읽기 전용** | `public/media/**` (힉스필드 산출물 — 덮어쓰기 금지) |
| 디자인·콘텐츠 문서 | Claude | `design-system.md`, `docs/frontend/**`, `docs/content/**` |
| 정적 페이지 라우트 | Claude | `routes/pages.php` — `Route::view()`만 쓴다. 컨트롤러·미들웨어·파라미터 라우트는 금지(필요하면 Codex에 요청) |
| 백엔드 | Codex | `app/**`, `routes/web.php`·`auth.php`·`console.php`, `database/**`, `config/**`, `bootstrap/**`, `composer.json`·`composer.lock`, `tests/**`, `phpunit.xml`, `scripts/**`, `.github/**`, `.env.example` |
| 이관 원문 데이터 | Codex (Claude는 읽기만) | `database/content/**` — 원문 보존용. 카피를 다듬을 때 원문은 두고 Blade·콘텐츠 문서에서 작업한다 |
| 환경·비밀 | 대웅 | `.env` — 둘 다 열람·수정하지 않는다 |
| 공동 문서 | 합의 후 수정 | `docs/PLAN-FINAL.md`, `docs/COLLAB.md` |
| 요청 큐 | 둘 다 추가 | `docs/collab/QUEUE.md` — 새 항목 추가와 **자기 앞으로 온** 항목의 상태 변경만. 남의 항목 문구는 고치지 않는다 |
| 인수인계 | 각자 | 자기 세션이 만든 `docs/HANDOFF-*.md`만 수정 |

경계가 애매한 파일을 만나면 저장하지 말고 큐에 "구역 확인" 요청을 올린다.

## 3. 데이터 계약 — 화면이 받는 변수

- 이 표가 Blade ↔ 컨트롤러의 약속이다. Claude가 새 화면에 필요한 변수를 **제안**으로 추가하고, Codex가 구현하면 **구현**으로 바꾼다.
- 기존 변수의 이름·형태를 바꿀 땐 반드시 큐로 요청하고, 상대가 수락한 뒤 바꾼다.
- 모델 필드는 현재 `app/Models` 기준 (2026-10-27 확인).

| 뷰 | 변수 | 형태 | 상태 |
|---|---|---|---|
| `pages.home` | `$works` | `Collection<Work>` 최신 공개 3건 (`title, slug, client, industry, summary, metrics(array), cover_image, published_at`) | 구현 |
| `pages.home` | `$insights` | `Collection<Insight>` 최신 공개 3건, `category` 로드 (`title, slug, excerpt, cover_image, published_at`) | 구현 |
| `insights.index` | `$insights`, `$categories` | `LengthAwarePaginator<Insight>`(12개, `category`·`user` 로드), `Collection<InsightCategory>`(`name, slug`) | 구현 |
| `insights.category` | `$category`, `$insights`, `$categories` | 위와 같음 + 현재 `InsightCategory` | 구현 |
| `insights.show` | `$insight` | `Insight` (`category`·`user` 로드, `content, meta_title, meta_description, source_url` 포함) | 구현 |
| `work.index` / `work.show` | `$works` / `$work` | `LengthAwarePaginator<Work>`(12개) / `Work` | 구현 |
| `contact` | 세션 `status` = `inquiry-received` | 문의 접수 후 리다이렉트 플래시 | 구현 |
| `seo.check` | `SeoCheckController::run()` 반환 배열 | 진단 결과 | 구현 |
| `community.*` | `$boards`, `$board`, `$notices`, `$posts`, `$post`, `$comments` | 기존 커뮤니티 | 구현 |

## 4. 요청 큐 사용법 (`docs/collab/QUEUE.md`)

1. 표 맨 아래에 한 줄 추가: `ID | 시각(KST) | 보낸→받는 | 요청 | 관련 파일 | 상태 | 메모`
2. 상태: `열림` → `수락` → `완료` / `반려(사유)` / `공지`(확인만 필요)
3. **세션 시작 때** 내 앞으로 온 `열림`을 확인하고, **세션 끝날 때** 상태를 갱신한다.
4. 서로 막히는 급한 건은 대웅에게도 한 줄 알린다.
5. 큐에 쓴 요청은 대시보드 `tasks.json`에도 같은 ID로 남긴다(owner = 받는 쪽).

## 5. git·동시 작업

- 커밋·푸시·브랜치 변경·stash·reset·checkout은 **대웅만** 한다. 에이전트는 `git status`·`diff`·`log` 읽기만 한다 (lock 충돌 방지).
- 같은 작업 폴더를 함께 쓴다. **구역 분리가 곧 충돌 방지**다.
- 공동 문서는 고치기 직전에 최신본을 다시 읽고, 섹션 단위로만 고친다. 고친 섹션 끝에 `(수정: 이름, 시각)`을 남긴다.

## 6. 기준 문서와 우선순위

| 무엇 | 기준 |
|---|---|
| 기획·IA·카피 방향 | `docs/PLAN-FINAL.md` (U1 URL 보존 우선, U2 순위상승 적극 활용) |
| 디자인 | Claude Design 와꾸(확정 후 링크를 여기 기재) → 확정 뒤 `design-system.md` 갱신 |
| 디자인 재사용 범위 | 2026-10-27 13:27 대웅: "기존에 리뉴얼한 내용들 싹 다 엎어도 괜찮다" → v1 토큰·3D 아이콘·벡터 일러스트 재사용 의무 없음 |
| 충돌 시 | 대웅의 최신 지시 > PLAN-FINAL > 이 문서 > 개별 화면 문서 |

## 7. 공통 절대 규칙 (AGENTS.md·CLAUDE.md와 동일)

- 자동 배포·발행·삭제 금지. 대웅 검수 후 진행.
- 성과 수치(373억 등) 임의 수정 금지 — 라벨·고지 문구 유지.
- `public/media/` 덮어쓰기 금지.
- 작업 시작·완료 때 대시보드 `tasks.json` 갱신, 세션 끝에 `_tools/대시보드.py` 실행.
