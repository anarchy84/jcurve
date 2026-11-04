# SPEC-CODEX-SEO-KW-01C — Claude 화면 변경을 지키는 테스트 (구현 지시서)

- 작업 ID: SEO-KW-01C · 작성: Claude 2026-11-04 · 기준: 지금 작업 폴더(SEO-KW-01A·B 포함, 미커밋)
- 대상: Claude 가 바꾼 화면. **화면 파일은 고치지 않고 테스트만 쓴다.** 테스트가 화면 버그를 찾으면 고치지 말고 보고한다.

## 소유 파일
`tests/**` 만.

## 금지 파일
그 밖 전부(`resources/views/**`, `app/**`, `config/**`, `routes/**`, `database/**`, `public/**`). git 쓰기 명령 금지.

## 테스트할 것 (`tests/Feature/SeoKeywordViewsTest.php`)
1. **공통 구조화 데이터** (`resources/views/partials/jc/head.blade.php`)
   - `/`, `/naver-place-marketing/`, `/services/reward-network`, `/self-marketing/shopping`, 인사이트 글 1편에서 `application/ld+json` 블록을 전부 JSON 으로 파싱할 수 있다.
   - 페이지마다 `Organization`(id `https://j-curve.co.kr/#organization`) 1개, `WebSite` 1개, `WebPage` 1개. WebPage `url` = canonical.
   - 제목·설명에 `&`, `"`, `</script>` 가 들어간 인사이트를 만들어 렌더해도 JSON 이 깨지지 않고 `</script>` 가 원문으로 새지 않는다(JSON_HEX_TAG).
   - WebPage `name`·`description` 에 `&amp;` 같은 HTML 엔티티가 남지 않는다.
2. **서비스 서브페이지** (`pages/subpage.blade.php`): `/naver-place-marketing/` 에 `Service`(provider id = organization)와 `BreadcrumbList`(홈 → 상위 → 현재, 모든 item 이 `https://j-curve.co.kr` 로 시작) 가 있다.
3. **인사이트 글** (`insights/show.blade.php`): `BlogPosting`(headline, datePublished, dateModified, publisher id) + `BreadcrumbList`, `og:type` = `article`, `article:published_time` 메타. 원주소 글 3편(`/seo/…/`)의 `<meta name="description">` 값이 바뀌지 않았다(기존 보존 테스트와 같은 기준).
4. **로그인류** (`layouts/guest.blade.php`): `/login`·`/register`·`/forgot-password` 에 `noindex` 메타, 제목에 `Laravel` 없음, 각각 `로그인`·`회원가입`·`비밀번호 찾기` 포함.
5. **빈 카테고리** (`insights/category.blade.php`): 공개 글 0편 카테고리 → `noindex`. 글이 있는 카테고리와 `/blog/seo/`·`/blog/link-building/`(글 0편이어도) → `index`.
6. **키워드 화면 제목·H1**
   - `/self-marketing/shopping` 200, 제목에 `쇼핑 리워드`, H1 `쇼핑 리워드 마케팅`, 주문 링크 `type=shopping`, 가격(원·₩) 표기 없음.
   - `/self-marketing/place` 제목에 `플레이스 리워드`·`플레이스 순위`, 본문에 `/self-marketing/shopping` 링크.
   - `/services/reward-network` 제목에 `리워드 광고`·`오퍼월`, `id="offerwall"` 섹션, FAQPage JSON-LD 에 `오퍼월이란 무엇인가요?`.
   - `/solutions/rankfree` 제목에 `플레이스 순위`·`쇼핑 순위`.
7. **llms 뷰**: `/llms.txt` 본문에 `&amp;`·`&lt;` 같은 엔티티가 없고, 모든 링크가 `https://j-curve.co.kr/` 로 시작한다.

## 테스트 무력화 실험 (필수)
각 항목에서 지키는 화면 코드를 **임시로** 되돌렸을 때 해당 테스트가 빨개지는지 확인하고, 반드시 원상복구한다(복구 후 `git diff` 로 화면 파일이 실험 전과 같은지 확인).
- head 의 `JSON_HEX_TAG` 제거 → 1번 `</script>` 테스트 빨강
- guest 의 `noindex` 메타 제거 → 4번 빨강
- category 의 noindex 블록 제거 → 5번 빨강
- reward-network 의 `id="offerwall"` 섹션 제거 → 6번 빨강

## 합격 게이트
`php artisan test` 전부 초록 · `./vendor/bin/pint --test tests/Feature/SeoKeywordViewsTest.php` · 무력화 실험 4건 결과표 · 화면 파일 diff 가 실험 전과 동일.

## 반환물
`tests/SEO-KW-01C-RESULT.md` 에: 새 테스트 목록, 실제 출력, 무력화 실험 표(되돌린 코드 / 빨간 테스트 이름 / 복구 확인), 테스트가 찾은 화면 버그(있으면).
