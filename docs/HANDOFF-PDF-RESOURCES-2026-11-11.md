# 인수인계 — PDF 자료실(관리자 업로드 · 회원 다운로드) · 2026-11-11

> 작성: Claude (2026-11-11 14:30 KST, 팀 하네스 업무 1~3/3). 다음 세션은 이 파일부터 읽는다.
> 커밋·푸시·PR·슬랙 발송은 하지 않았다(대웅만 한다). 변경은 전부 main 위 작업 트리에 있다(기준 커밋 `d5efbaf`).

## TL;DR
- **코드는 끝, 운영은 아직.** 관리자는 PDF를 올리고 로그인한 회원은 내려받는 `/resources`를 만들었다. 가입·로그인은 기존 것을 그대로 쓴다.
- 테스트(php-wasm 8.3): **298개 통과 · 실패 0 · wasm에서 실행 못 한 5개.** 5개는 변경 전에도 똑같이 죽었고, 원인은 wasm 쪽 문제(아래 「테스트 결과」)다. 복사본에서 그 문제만 피해서 돌리면 인증 테스트 18개가 변경 전·후 모두 통과했다.
- 독립 검증(공격자 입장 13개 항목): **합격, 실패 0.** 낮음·정보 관찰 5개 중 1개 고침, 4개는 이유를 적고 남김.
- 운영 반영 때 할 일: `php artisan migrate`(새 표 `resource_files` 하나), `npm run build`(CSS 추가), 관리자 계정 `role=admin` 지정.
- 백엔드 구역(app·routes·database·tests)을 팀 하네스 지시로 Claude가 썼다. 큐 Q-036에서 Codex 검토를 요청했다.

## 만든 것
- **공개 목록 `/resources`:** 공개된 자료의 제목·설명·용량·올린 날짜와 받기 버튼을 최신순 30개씩 보여 준다.
  - 비로그인이면 버튼이 「로그인하고 받기」로 바뀌고 `route('login')`로 보낸다.
  - 목록을 볼 때 돌아올 곳(intended)을 목록으로 잡아 둔다. 그래서 로그인하거나 가입하면 목록으로 돌아온다.
- **받기 `/resources/{id}/download`:** 로그인 회원만, 분당 30회.
  - `Storage::disk('local')->download($path, 원래 이름)`으로 `attachment`로 내려 준다.
  - 비공개 자료나 디스크에 파일이 없는 자료는 404(500 아님). 받은 수를 올린다(HEAD 요청은 세지 않음).
  - 공유받은 받기 주소를 비로그인으로 바로 열어도, 로그인 뒤 파일 응답이 아니라 목록으로 온다.
- **관리 `/admin/resources`:** `role=admin`만 들어온다. 업로드 폼과 목록, 삭제(확인 창)가 있다.
  - 업로드 검사: `file` = `required|file|mimes:pdf|max:20480`, `title` = `required|string|max:200`, `description` = `nullable|string|max:2000`. 검사 문구는 한국어다.
  - 저장은 `$file->store('resources','local')`. 실제 위치는 `storage/app/private/resources/<무작위 40자>.pdf`이고, 확장자는 파일 내용으로 정해진다.
  - 원래 이름은 DB `original_name`에만 둔다. 경로 구분자·제어문자·방향전환 문자를 지우고, `.pdf`로 끝나게, 255자 이내로 맞춘다. 비면 `자료.pdf`.
  - 삭제하면 DB 행과 저장 파일을 함께 지운다.
- **관리자 막기:** `EnsureUserIsAdmin`이 `role !== 'admin'`이면 403. 별칭은 `admin`이다.
  - 모델 조회보다 먼저 돌게 해서, 회원이 없는 번호로 찔러도 404가 아니라 403이 나온다.
- **가입 흐름:** `RegisteredUserController::store`의 마지막 줄만 `redirect()->intended(route('dashboard', absolute: false))`로 바꿨다.
  - `verified` 미들웨어와 `MustVerifyEmail`은 쓰지 않는다. 메일 발송이 꺼져 있기 때문이다.
- **검색 노출:** 두 화면 모두 `noindex, nofollow`. 사이트맵·RSS·llms에 넣지 않았고, 받기 응답에는 `X-Robots-Tag`를 붙였다.
- **25MB 초과 요청:** 한국어 `errors/413` 화면을 띄운다.
- **메인 내비는 바꾸지 않았다.** 위치는 대웅이 정한다.

## 바뀐 파일 (git status 기준 15개)
| 구분 | 파일 | 내용 |
|---|---|---|
| 수정 | `routes/web.php` | 자료실 경로 5개 |
| 수정 | `bootstrap/app.php` | `admin` 별칭, 관리자 검사 우선순위, 받기 주소 비로그인 → 로그인 → 목록 복귀 |
| 수정 | `app/Http/Controllers/Auth/RegisteredUserController.php` | 마지막 줄 `intended` |
| 수정 | `resources/css/jc.css` | 끝에 자료실 블록(`.jc-res*`) |
| 수정 | `docs/collab/QUEUE.md` | Q-035(구현 공지)·Q-036(Codex 검토 요청) |
| 새 파일 | `database/migrations/2026_11_11_000001_create_resource_files_table.php` | `resource_files` 표 |
| 새 파일 | `app/Models/ResourceFile.php` | `cleanOriginalName()`, `humanSize()`, `published` 범위 |
| 새 파일 | `app/Http/Middleware/EnsureUserIsAdmin.php` | 관리자 막기 |
| 새 파일 | `app/Http/Controllers/ResourceFileController.php` | 목록·받기 |
| 새 파일 | `app/Http/Controllers/Admin/ResourceFileController.php` | 관리 목록·업로드·삭제 |
| 새 파일 | `resources/views/resources/index.blade.php` | 공개 목록 화면 |
| 새 파일 | `resources/views/admin/resources/index.blade.php` | 관리 화면 |
| 새 파일 | `resources/views/errors/413.blade.php` | 요청이 너무 클 때 안내 |
| 새 파일 | `tests/Feature/ResourceFileTest.php` | 테스트 20개 |
| 새 파일 | `docs/HANDOFF-PDF-RESOURCES-2026-11-11.md` | 이 문서 |

건드리지 않은 것: `.env`, `public/media/**`, `config/filesystems.php`, 성과 수치 문구, 운영 DB. `public/build`는 git 대상이 아니라 빌드하지 않았다.

## 경로·권한
| 메서드 | 주소 | 이름 | 미들웨어 | 비회원 | 회원 | 관리자 |
|---|---|---|---|---|---|---|
| GET | `/resources` | `resources.index` | web | 목록 보기(받기 버튼 → 로그인) | 목록 + 받기 | 목록 + 받기 + 관리 링크 |
| GET | `/resources/{resourceFile}/download` | `resources.download` | auth, throttle:30,1 | 로그인으로(로그인 뒤 목록 복귀) | 200 attachment / 비공개·파일 없음 404 | 회원과 같음 |
| GET | `/admin/resources` | `admin.resources.index` | auth, admin | 로그인으로 | 403 | 업로드 폼 + 전체 목록 |
| POST | `/admin/resources` | `admin.resources.store` | auth, admin (+CSRF) | 로그인으로 | 403 | 업로드 |
| DELETE | `/admin/resources/{resourceFile}` | `admin.resources.destroy` | auth, admin (+CSRF) | 로그인으로 | 403(없는 번호도 403) | 행 + 파일 삭제 |

## 데이터 계약 (화면이 받는 값)
| 뷰 | 변수 | 형태 |
|---|---|---|
| `resources.index` | `$files` | `LengthAwarePaginator<ResourceFile>`. 공개분(`is_published = true`)만, id 내림차순 30개 |
| `admin.resources.index` | `$files` | `LengthAwarePaginator<ResourceFile>`. 전체, id 내림차순 30개, `uploader`(User) 함께 로드 |
| `admin.resources.index` | 세션 `status` | `resource-uploaded` / `resource-deleted`(업로드·삭제 뒤 리다이렉트 플래시) |
| `admin.resources.index` | `$errors` | 한국어 검사 문구(`title`·`description`·`file`) |

`ResourceFile`의 칸은 `id, title, description, original_name, path, mime, size, download_count, is_published, uploaded_by, created_at, updated_at`이다. 화면은 `humanSize()`(예: `820KB`, `3.4MB`)를 쓴다.

**`path`는 화면에 절대 내지 않는다.** 받기는 항상 `route('resources.download', $file)`로만 한다.

## 테스트 결과
상자에 php가 없어서 php-wasm으로 돌렸다. 저장소 코드는 이 때문에 고친 게 없다.

```bash
# 저장소 밖 부트스트랩: 앱을 띄워 Artisan::call('migrate:fresh') 후
# RefreshDatabaseState::$inMemoryConnections[sqlite] = PDO, $migrated = true 로 넘겨 준다
PHP=8.3 npx -y @php-wasm/cli vendor/phpunit/phpunit/phpunit --bootstrap /tmp/t3/bootstrap.php <테스트 파일>
```
- 기본 실행(`npx -y @php-wasm/cli vendor/bin/phpunit`, PHP 8.5)은 시작하자마자 죽는다. RefreshDatabase가 `migrate:fresh`를 객체가 사라지는 순간(소멸자)에 돌리는데 wasm이 이걸 못 견딘다. 그래서 위처럼 테스트 파일마다 따로 돌렸다.
- **최종 실행(2026-11-11 14:2x, 이번 보완 반영 후):**
  - 22개 파일 · 292개 통과 · 실패 0.
  - 인증 테스트 3개 파일은 메서드 단위로 돌렸다: 6개 통과, 5개 실행 불가(wasm 크래시).
  - **합계: 298개 통과 / 실패 0 / 실행 불가 5개.** SEO 감사·URL 보존 테스트(UrlPreservation 28, SeoUrlAudit 9, SeoMetaRestoration 32 등)도 통과했다. 변경 전 기준선은 278개 통과(같은 5개 실행 불가)였다.
- **실행 불가 5개:**
  - 목록: `AuthenticationTest::…invalid_password`, `PasswordConfirmationTest::…invalid_password`, `PasswordResetTest`의 `link_can_be_requested`·`reset_password_screen_can_be_rendered`·`password_can_be_reset_with_valid_token`.
  - 원인: 로그인 실패 시 대기하는 Laravel `Timebox` → `Sleep::usleep`이 대기를 소멸자에서 해서 wasm이 죽는다.
  - 독립 검증 때 /tmp 복사본의 vendor에서만 이 대기를 없애고 돌렸더니 `tests/Feature/Auth` 18개가 변경 전(HEAD 복원본)·변경 후 모두 통과했다.
  - **실서버 PHP에서 `php artisan test`를 한 번 돌려 확인 권장.**
- 코드 스타일(Pint `--test`): 바꾼 PHP 전부 통과.
- 무력화 실험(코드를 일부러 망가뜨려 테스트가 잡는지):
  - 구현 때 19개, 독립 검증 때 6개(① admin 미들웨어 제거, ② 받기 auth 제거, ③ mimes:pdf 제거, ④ max:20480 제거, 미들웨어 본문 무력화, 가입 intended 원복), 이번 보완 1개(413 Referer 링크 원복). **모두 테스트가 실패로 잡았다.**

## 검증 판정 요약
- **1차 검증(구현 중, 별도 검증 에이전트):** 조건부 합격, 뚫림 0. 권고 4개(받기 주소 직접 열기 복귀, 없는 번호 403, 413 한국어 화면, HEAD 비집계)를 구현 때 반영했다.
- **2차 독립 검증(공격자 입장 13개 항목, /tmp 복사본):** **합격, 13개 전부 통과, 실패 0.**
  - 비회원 받기 → 바이트 없이 로그인.
  - 회원·비회원 관리 경로 → 403·로그인. role 비교는 엄격(`!==`).
  - 가입·프로필 수정 때 role 끼워 넣기 → 막힘.
  - PNG·HTML·PHP·SVG·ZIP을 `.pdf` 이름으로 → 거절. PDF 내용을 `x.php` 이름으로 → 거절(Laravel 규칙이 php 계열 확장자 차단).
  - 20,971,520바이트 통과, +1바이트 거절.
  - 저장 위치는 `storage/app/private`, public 쪽 사본·심볼릭 링크 없음, 서명 없는 `/storage/...`는 열리지 않음.
  - 위험한 원래 이름(줄바꿈·따옴표·`../`·400자 등)과 전체 유니코드 72,757건 → 500 없음.
  - 404 처리, 삭제 시 파일 삭제, CSRF 419(올바른 토큰 대조 통과), 미인증 회원도 이용 가능, 복귀 흐름, SEO 미포함·noindex, migration(MySQL용 SQL·sqlite 되돌리기) 모두 정상.

### 낮음·정보 관찰 조치
| # | 관찰 | 등급 | 조치 | 이유 |
|---|---|---|---|---|
| 1 | /profile 등으로 가려다 로그인 화면에 온 비회원이 중간에 `/resources`를 보면, 로그인 후 목록으로 간다(돌아갈 곳이 덮어쓰임) | 낮음 | 남김 | 요구사항 7이 「목록을 볼 때 돌아올 곳을 목록으로 잡는다」로 정했다. 「이미 있으면 안 덮기」로 바꾸면 오래된 값이 남은 사람이 「로그인하고 받기」를 눌러도 목록으로 못 돌아온다. 보안 영향 없음 |
| 2 | 한글 이름은 ASCII 대체 이름(`filename=`)에서 빠져 `.pdf`만 남는다 | 낮음 | 남김 | 요즘 브라우저는 모두 `filename*`(UTF-8, 한글 그대로)를 쓴다. 대체 이름을 바꾸려면 `Storage::download()` 대신 Content-Disposition을 직접 만들어야 해서 지시(Storage::download 사용)와 어긋난다 |
| 3 | `Sec-Fetch-Site: same-origin` 요청은 토큰 없이 CSRF를 통과한다 | 정보 | 남김 | Laravel 13 기본 설계. 이 머리글은 브라우저가 붙이는 값이라 다른 사이트가 위조할 수 없다. 토큰 없음·틀린 토큰·cross-site는 419 확인 |
| 4 | 맨 앞이 `%PDF`이면 뒤에 다른 내용이 붙어도 PDF로 통과한다 | 정보 | 남김 | 비공개 폴더 저장 + `attachment`·`application/pdf`로만 제공 + `public/.htaccess` nosniff + 업로드는 관리자만. 완전히 막으려면 PDF 정밀 검사 라이브러리가 필요해 범위 밖 |
| 5 | 413 화면 「이전 화면」 링크가 브라우저가 보낸 Referer 값을 그대로 쓴다 | 정보 | **고침** | 링크를 없애고 「브라우저의 뒤로 가기」 안내 + 홈 링크로 바꿨다. Referer가 화면에 실리지 않는지 테스트 단언을 추가했고, 옛 링크로 되돌리면 실패하는 것도 확인했다 |

## 남은 결정 (대웅)
1. **관리자 계정:** 운영 회원 2명 중 누구를 `role=admin`으로 할지. 운영 DB는 손대지 않았다. 서버 쪽에서 바꿔야 한다.
2. **내비 위치:** 지금은 어디에도 링크가 없어 `/resources` 주소로만 들어간다. 메인 메뉴 / 고객센터 아래 / 푸터 중 선택.
3. **운영 설정 확인:** `APP_DEBUG=false`인지, 웹서버 요청 본문 한도가 25MB 이상인지.
4. (참고, 이번 범위 밖) 일반 가입 뒤 가는 `/dashboard`에는 원래 `verified`가 걸려 있다. 메일이 꺼진 지금은 인증 안내 화면에서 멈춘다. 자료실을 거쳐 가입하면 목록으로 돌아오니까 자료실은 영향 없다.

## 대웅이 실행할 명령
현재 브랜치는 `main`, 작업 트리에 변경이 있는 상태에서 실행한다(새 브랜치로 변경이 그대로 따라간다).

```bash
cd ~/Claude_Projects/jcurve
git switch -c feat/pdf-resources

git add \
  routes/web.php \
  bootstrap/app.php \
  app/Http/Controllers/Auth/RegisteredUserController.php \
  resources/css/jc.css \
  docs/collab/QUEUE.md \
  database/migrations/2026_11_11_000001_create_resource_files_table.php \
  app/Models/ResourceFile.php \
  app/Http/Middleware/EnsureUserIsAdmin.php \
  app/Http/Controllers/ResourceFileController.php \
  app/Http/Controllers/Admin/ResourceFileController.php \
  resources/views/resources/index.blade.php \
  resources/views/admin/resources/index.blade.php \
  resources/views/errors/413.blade.php \
  tests/Feature/ResourceFileTest.php \
  docs/HANDOFF-PDF-RESOURCES-2026-11-11.md

git status   # 위 15개만 올라갔는지 확인

git commit -F - <<'MSG'
feat(resources): PDF 자료실 — 관리자 업로드 · 회원 다운로드

- /resources 공개 목록, /resources/{id}/download(auth+throttle:30,1, Storage::download)
- /admin/resources 업로드·삭제(auth+admin, role === 'admin')
- resource_files 표(migration), 저장은 storage/app/private 무작위 이름, 원래 이름은 DB
- 검사 mimes:pdf + max:20480, 한국어 오류 문구, 25MB 초과 413 안내 화면
- 비로그인 → 로그인/가입 → 목록 복귀(가입 후 redirect()->intended)
- noindex, 사이트맵·RSS·llms 미포함, verified/MustVerifyEmail 미사용(메일 꺼짐)
- 테스트 20개(tests/Feature/ResourceFileTest.php)

Co-Authored-By: Claude Opus 5.5 <noreply@anthropic.com>
MSG

git push -u origin feat/pdf-resources
```
그다음 GitHub(`anarchy84/jcurve`)에서 **base: `main` ← compare: `feat/pdf-resources`**로 PR을 만든다. 본문은 아래 초안을 쓴다.

### PR 본문 초안
```markdown
## 무엇
홈페이지 PDF 자료실. 관리자는 PDF를 올리고, 로그인한 회원은 내려받는다. 가입·로그인은 기존 /register·/login 을 그대로 쓴다.

## 경로
| 주소 | 권한 |
|---|---|
| GET /resources | 누구나(받기는 로그인 필요) |
| GET /resources/{id}/download | 로그인 회원, 분당 30회 |
| GET·POST /admin/resources, DELETE /admin/resources/{id} | role = admin |

## 서버 반영 때
1. `php artisan migrate` — 새 표 `resource_files` 하나만 생긴다(기존 표 변경 없음).
2. `npm run build` — `resources/css/jc.css` 에 자료실 스타일 추가.
3. 관리자로 쓸 계정의 `users.role` 을 `admin` 으로 변경.

## 지킨 것
- PDF는 `storage/app/private`(local 디스크)에 무작위 이름으로 저장, 원래 이름은 DB `original_name`. 주소로 바로 열리지 않는다(서명 없는 /storage/... 403/404).
- 다운로드는 auth 경로에서 `Storage::disk('local')->download()`. 파일 주소·temporaryUrl 노출 없음.
- 업로드는 role = admin 만. 검사 `mimes:pdf` + `max:20480`.
- 메일 발송이 꺼져 있어 `verified`·`MustVerifyEmail` 은 쓰지 않았다.
- 두 화면 noindex, 사이트맵·RSS·llms 미포함. 메인 메뉴 변경 없음(위치 결정 대기).

## 테스트
- php-wasm 8.3: 298개 통과 / 실패 0 / wasm에서 실행 못 한 5개(로그인 실패 대기 Timebox 관련, 변경 전과 동일. 복사본에서 대기만 빼고 돌리면 Auth 18개 통과). 실서버 PHP에서 `php artisan test` 한 번 확인 부탁.
- 독립 검증(공격자 입장 13개 항목) 합격, 무력화 실험 전부 테스트가 잡음.
- 자세한 내용: `docs/HANDOFF-PDF-RESOURCES-2026-11-11.md`

🤖 Generated with [Claude Code](https://claude.com/claude-code)
```

## 슬랙 요청 초안
- 채널: **#101-김대웅-업무**에 **채널 최상위 새 글**로 올린다(댓글 아님).
- 태그: 클로드봇만. 아래 대괄호 두 칸을 채운 뒤 보낸다:
  - `[PR 주소]`: PR을 연 뒤 넣는다.
  - `[관리자 계정 이메일]`: 대웅이 정해서 넣는다.

```
<@U0C4GJPUT0Q> 홈페이지 PDF 업로드·다운로드(자료실) 다 됐어요. PR: [PR 주소]
운영 반영 때 `php artisan migrate` 하면 resource_files 표가 하나 생겨요(CSS도 바뀌어서 `npm run build`도 같이 부탁드려요).
관리자로 쓸 계정 [관리자 계정 이메일] 의 role을 admin으로 바꿔 주세요.
메일이 꺼져 있어서 가입 때 이메일 인증은 요구하지 않았어요.
크기 한도는 지금 설정(파일 20MB·요청 25MB)으로 충분해요.
```
