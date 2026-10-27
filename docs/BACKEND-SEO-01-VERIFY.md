# BACKEND-SEO-01 독립 검증 지시서

검증 대상: `/Users/anarchy/Claude_Projects/jcurve` · 기준 구현: BACKEND-SEO-01 · 검증자는 제품 수정·배포·커밋·브랜치 변경 금지.

사용자는 **URL 보존 검증+sitemap·RSS** 범위만 선택했다. 프론트·카피·관리자·인증·주문·기존 301 정책 변경은 제외다. `AGENTS.md`, `docs/COLLAB.md`, `docs/collab/QUEUE.md`, `docs/BACKEND-SEO-01.md`를 읽는다. `.env`는 열람·수정하지 않는다. 외부 서버·API·DB를 호출하지 않는다.

## 소유·검토 범위

검토 대상: `app/Services/Seo/Publishing/*`, `app/Http/Controllers/SeoFeedController.php`, `app/Console/Commands/AuditSeoUrls.php`, `config/seo.php`, `routes/seo.php`, `bootstrap/app.php`의 별도 SEO 라우트 등록, `tests/Feature/SeoFeedTest.php`, `tests/Feature/SeoUrlAuditTest.php`.

협업 큐 Q-002에 따른 `routes/web.php`의 `pages.php` require와 Q-003 문서 변경도 범위 준수 여부만 확인. `AGENTS.md`·`CLAUDE.md`·`docs/COLLAB.md`·`routes/pages.php`는 다른 세션 산출물이니 수정 금지. 검증자는 다른 작업자와 같은 저장소를 공유한다. 타인 변경을 되돌리지 않는다.

## 실행과 공격 시나리오

1. 전체 `php artisan test --compact`와 소유 파일 대상 Pint 확인. 구현자 관측: 기존 43개/306 assertions → 현재 55개/378 assertions. 실제 출력을 따로 기록한다.
2. 초안·미래 발행·noindex·canonical 중복 페이지가 sitemap/RSS에 섞이면 실패. 공개 글·공개 성과·공개 글이 있는 카테고리는 XML 파서로 확인한다.
3. 한글·XML 특수문자·제어문자, RSS 50개 제한, 원발행일·시딩 날짜, sitemap 분할·경계·잘못된 페이지·요청 Host 변조를 확인한다.
4. 감사 명령이 --base-url 없이 서버를 호출하지 않는지, 외부/인증 정보가 든 origin·manifest 경로를 거부하는지, 200·승인된 301 한 번과 체인·외부 목적지·404·연결 실패·noindex·canonical 누락·본문 손실을 구분하는지 확인한다.
5. 실제 기존 301 매핑이 변경되지 않았는지 확인. 기본 manifest는 보존 목표 200이지 301을 승인한 목록이 아니다. 감사 통과와 사이트 공개 승인·GSC 결과를 혼동하면 실패다.
6. **테스트 무력화 실험 1회:** 구현자는 이 검증 동안 제품 코드 편집을 중단한다. `FeedCatalog::latestInsights()`의 `published()` 필터만 임시 제거하고 `SeoFeedTest::test_only_current_public_content_appears_in_sitemaps_and_rss`가 실제로 실패하는지 확인한다. 임시 변경은 기능 수정이 아니라 검증 실험이며 반드시 원문 복구한다. 전후 SHA-256을 비교하고 복구 후 해당 테스트가 통과하는 실제 출력을 기록한다. 다른 파일·다른 필터는 손대지 않는다.

## 반환

- 실제 실행 명령·종료 상태·테스트/스타일 출력.
- 재현 가능한 버그가 있으면 파일·줄·입력·관측·기대 결과. 고치지 말고 보고한다.
- 테스트 무력화 실험의 실패·복구·해시 확인 결과.
- 검증하지 못한 항목과 공개 전 게이트.

검증 보고는 부모 세션에 반환한다. 자동 합격·배포 승인 또는 Claude가 최종 검수했다고 판정하지 않는다.
