# BACKEND-SEO-01 — SEO 피드·기존 URL 검증

상태: 로컬 구현·독립 검증 완료 / Claude 최종 검수·서버 검증 대기 · 시작: 2026-10-27 · 기준: `main / ae256e3`

## 승인과 역할

사용자가 프론트는 Claude Design, 콘텐츠는 Claude, 백엔드는 Codex로 나누자고 요청했고, 후속 질문에서 **‘SEO 기반부터: URL 보존 검증 + sitemap·RSS’**를 선택했다. 이 문서의 범위에 한해 이전 개발 보류를 해제한다. 배포·서버 변경·실제 콘텐츠 발행은 승인되지 않았다.

- Codex: SEO 피드와 URL 보존 검증 도구·관련 테스트.
- Claude Design: 프론트 화면. 이번 작업에서는 `resources/`, CSS/JS, `public/media/`를 편집하지 않는다.
- Claude: 콘텐츠 작성·사업 카피. 이번 작업에서 상품·실적·브랜드·본문을 만들거나 변경하지 않는다.

## 소유 파일과 제외 범위

소유: `app/Services/Seo/Publishing/*`, `app/Http/Controllers/SeoFeedController.php`, `app/Console/Commands/AuditSeoUrls.php`, `config/seo.php`, `routes/seo.php`, `tests/Feature/Seo*Test.php`, 이 문서.

통합 지점: `bootstrap/app.php`에 별도 SEO 라우트 파일 등록, `.env.example`의 비밀값 없는 설정 예시, 계획·Codex 인수인계의 현재 작업 링크. 기존 예외 처리·리다이렉트 시더는 유지한다. Q-002에 따른 프론트 라우트 파일 require만 추가한다.

제외: CMS·관리자·계정·권한·DB 스키마 변경, 예약 발행·IndexNow 자동화, 주문/결제 API, 프론트·카피·미디어, 기존 301 매핑 수정, 실제 서버 배포·발행.

## 구현 계약

1. `/sitemap.xml`: 현재 공개 페이지의 분할 사이트맵 인덱스. `/sitemaps/{section}/{page}.xml`: pages/services/insights/works, 1파일 최대 50,000 URL. 기본 청크 1,000. `config/subpages.php`의 기존 공개 서비스·솔루션 서브페이지 19개도 포함하며 동일 noindex·canonical 제외 조건을 적용한다.
2. `/rss`: 현재 공개 글 중 최신 50편 이내. 초안·미래 글·noindex·다른 canonical을 가진 중복 페이지는 제외. 제목·요약은 XML 안전 텍스트로 출력.
3. 생성 URL은 요청 Host가 아닌 `SEO_PUBLIC_URL`(미설정 시 `APP_URL`) 기준. 실제 공개 도메인을 서버 환경에서 정확히 설정해야 한다.
4. 피드는 현재 Laravel 라우트·발행 상태와 `seo_meta`의 제외 지시를 반영한다. 기존 WordPress URL 보존을 구현 완료했다고 의미하지 않는다. 원URL 200 계획과 현 301 응답의 차이는 감사 명령이 별도로 차단 항목으로 보고한다.
5. lastmod는 글의 실제 기록을 사용한다. 가져온 기존 글은 시딩 시각을 수정일로 광고하지 않고 원발행일을 사용한다. 일반 글의 미래 수정일도 오늘로 치환하지 않고 저장된 발행일을 사용한다. 정적 페이지에 가짜 오늘 날짜를 넣지 않는다.
6. `seo:audit-urls --base-url=...`: 명시한 서버에 GET으로 원주소 200·canonical 또는 승인된 1회 301→200을 검사. 기본 목록은 보호할 핵심 기존 주소와 보관 JSON의 원주소. `--manifest`로 승인된 기대값 목록 사용 가능. 예외 301은 정확한 같은 origin 목적지를 명시해야 한다.
7. 감사는 콘텐츠·매핑을 수정하지 않고 읽은 결과를 콘솔/JSON으로 보고한다. 대상 서버의 일반 접근 로그·기존 redirect hit_count는 GET으로 기록될 수 있다. 외부 사이트로 리다이렉트를 따라가지 않는다.

## 합격 기준과 검증 방법

- 기존 43개 테스트 기준선 통과(306 assertions).
- sitemap/RSS를 XML 파서로 검사. draft/future/noindex/다른 canonical 제외, 공개 글·성과만 포함, 특수문자·한글·Host 변조·분할 경계·원발행일 보존 검증.
- URL 감사는 200 보존 성공, 기존 301의 정책 불일치, 승인 301, 체인·루프·다른 origin·404·canonical 불일치·네트워크 오류를 실제 HTTP 응답 형식의 테스트로 검증.
- DB 마이그레이션·프론트·시더·리다이렉트 로직 변경 없음.
- 구현과 독립 검증은 별도 세션. 검증 세션은 제품 코드 수정 없이 판정과 근거를 반환한다. 최종 제품 검수와 공개는 별도다.

## 현재 알려진 공개 전 게이트

기존 정적 시더·404 훅은 `/seo/` 등을 301로 이동한다. 이번 사용자 승인 범위는 **보존 검증**이므로 이를 200으로 바꾸지 않는다. 감사 결과의 정책 불일치를 해결하는 실제 URL 호환 작업은 다음 범위로 분리해야 한다. GSC·네이버·운영 서버 검증도 아직 미실시다.

## 현재 사용법

현재 앱의 기존 테이블이 준비된 로컬·검수 서버에서 사용한다. 새 DB 변경은 없고 이 작업을 위해 운영 DB에 마이그레이션·시딩을 실행하지 않았다.

- `/sitemap.xml`: 인덱스. `/sitemaps/pages/1.xml`, `/sitemaps/services/1.xml`, `/sitemaps/insights/1.xml`, `/sitemaps/works/1.xml`로 연결.
- `/rss`: 최근 공개 인사이트 최대 50개.
- 피드 주소는 서버 환경의 `SEO_PUBLIC_URL` 우선, 없으면 `APP_URL`. 요청 Host를 사용하지 않는다. `.env`는 대웅 소유이며 읽거나 수정하지 않았다. `.env.example`에 선택 설정만 설명했다.
- `config/seo.php`의 정적 허용 목록과 `subpage_prefixes`가 현재 공개 주요 페이지·기존 서브페이지를 구성한다. 기존 4개 그룹의 세부 페이지는 `config/subpages.php`를 따른다. 새 프론트 라우트·새 그룹의 공개가 확정되면 주소와 canonical/robots를 대조해 목록·그룹을 갱신한다. 레거시·신규 프론트의 임의 주소를 자동 크롤링하는 기능은 아니다.

로컬 검수 서버가 `http://127.0.0.1:8000`에서 실행 중일 때:

```sh
php artisan seo:audit-urls --base-url=http://127.0.0.1:8000 --json
```

기본 검증 목록은 핵심 기존 주소 13개와 원문 JSON의 주소 53개(합계 66개)다. 기본 기대값은 모두 **200 보존**이다. 이는 현재 응답을 확인해 승인한 목록도, 운영 사이트 전체 주소도 아니다. `--base-url`을 생략하면 네트워크 요청 없이 종료 2다.

별도 승인 manifest는 JSON 배열이며 각 항목에 `path`, 선택 `status`(200 또는 301), 승인 301의 `to`, 선택 `canonical`, 선택 `contains`를 사용한다. 실제 본문 보존 확인이 필요하면 `contains`에 원문 핵심 문장을 넣는다. `canonical` 미지정 시 공개 origin과 기대 최종 경로를 비교한다.

```json
[
  {"path": "/seo/", "status": 200},
  {"path": "/company/anarchy", "status": 301, "to": "/company#anarchy"}
]
```

종료값: 0=검증 목록 통과, 1=응답·canonical·본문 등 실패 있음, 2=명령/manifest 입력 오류. 다른 origin 리다이렉트는 따라가지 않는다. noindex인 스테이징은 공개 준비 검사에서 실패할 수 있으며, 도구를 초록으로 만들려고 보호 설정을 해제하지 않는다.

## 구현자 확인 결과

- 변경 전 `php artisan test --compact`: **43 passed / 306 assertions**.
- 최초 SEO 테스트: **12 passed / 72 assertions**, 전체 **55 passed / 378 assertions**.
- 독립 재현 버그 수정 후 전체 `php artisan test --compact`: **60 passed / 402 assertions**.
- 소유 PHP 파일 대상 `vendor/bin/pint --test`: passed.
- `php artisan route:list --path=sitemap --json`: 인덱스·분할 라우트 등록 확인. CLI `seo:audit-urls --help` 등록 확인.
- `git diff --check`: 종료 0.
- 로컬 실행 환경: PHP 8.5.8, PHPUnit의 SQLite `:memory:`. PHP 8.3·MySQL 서버와 실제 스테이징은 별도 확인 필요.

이 수치는 구현자 실행 결과이며 별도 검증 결과와 구분한다. 독립 검증 지시서는 `docs/BACKEND-SEO-01-VERIFY.md`다. 검증 중에는 소유 제품 코드 편집을 중단했다. 첫 독립 검증에서 `%23`·`%3F`를 URL 구분자와 같게 보는 감사의 거짓 통과가 재현됐다. 예약문자는 인코딩 상태를 유지하고 한글·unreserved 문자만 정규화하도록 고쳤으며, metadata 경로 비교·미래 수정일 회귀 테스트도 추가했다.

추가 독립 검증에서 현재 HTTP 200인 기존 서브페이지 19개의 sitemap 누락을 확인했다. 기존 공개 콘텐츠 화이트리스트와 피드 목록을 연결하고, 실제 페이지 200·사이트맵 포함·noindex 제외를 회귀 테스트로 확인했다. 본문이나 프론트는 수정하지 않았다.

## 독립 검증 최종 결과

[독립 검증 보고서](BACKEND-SEO-01-VERIFY-RESULT.md)에 실제 명령·출력·공격 fixture 원문·환경 격리 방법·최종 12개 파일 SHA-256을 보관했다.

- 전체 **60/60 tests · 402 assertions**, 별도 공격 **10/10 tests · 108 assertions** 통과.
- 소유 파일 Pint, PHP 문법 12개 파일, 임시 폴더의 Vite 빌드 통과. 기존 `hero-glow.webp` 해석 경고와 실제 에셋 렌더 미확인은 보고서에 남겼다.
- 발행 필터를 임시 제거하면 테스트 exit 1, 원문 복구 후 exit 0. 실험 전후 SHA-256 동일. 복구 뒤 후속 수정본에서도 최종 전체 테스트 통과.
- 검증자는 제품 수정 없이 버그를 반환했고 구현자가 수정한 뒤 독립 재실행했다. PHP 8.5.8·SQLite 메모리 테스트이며 PHP 8.3/MySQL 운영 검증과 구분한다.

이 작업의 ‘완료’는 로컬 백엔드 범위의 구현·검증 완료다. Claude 최종 판단, 실제 기존 URL 200 보존, 서버·검색 도구 확인, 배포·공개 승인까지 완료된 것은 아니다. Q-008로 최종 검토를 요청했다.

## 협업 요청과 남은 게이트

- 작업 중 추가된 `AGENTS.md`·`CLAUDE.md`의 분업 규칙과 `docs/COLLAB.md`·요청 큐를 읽고 따랐다. 이 파일들은 다른 세션 산출물이므로 덮어쓰지 않았다.
- Q-002: Claude가 만든 `routes/pages.php`를 `routes/web.php`에서 읽는 한 줄 추가. 파일 내용은 수정하지 않음.
- Q-003: 공유 PLAN-FINAL의 기존 디자인 재사용 의무를 해제하는 문구 정정. 프론트 디자인·카피를 구현한 것은 아님.
- Q-006: 새 프론트 `<head>`에 실제 canonical·robots와 피드 발견 링크를 연결하도록 Claude에게 요청. 현재 레이아웃에 canonical 출력이 확인되지 않아 감사에서 누락으로 잡힐 수 있다. 프론트 파일을 직접 고치지 않음.
- Q-001: 스테이징 접근 차단·인증은 이번 선택 범위 밖이다. Q-007 공지로 별도 후속임을 남김. 서버 설정·인증 미들웨어·계정 생성 없음.
- 기존 콘텐츠 시더는 원문 날짜가 비어 있을 때 과거 날짜를 보충하는 동작이 있다. 피드는 DB 기록을 유지할 뿐 실제 원발행일의 진실성까지 확인한 것이 아니다. 원문·GSC 대조와 날짜 정정은 콘텐츠/이관 검수에서 다뤄야 한다.
- 관리자·승인 기능은 미구현이므로 현재 `published_at` 조건을 그대로 사용한다. 새 CMS 도입 시 승인 버전·상태를 함께 확인하는 계약이 필요하다.
- 운영 서버 전수 URL 감사, 사이트맵·RSS 검색 도구 제출, GSC/네이버 기준선 수집, 배포·발행은 하지 않았다.
