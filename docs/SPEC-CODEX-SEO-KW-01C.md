# SPEC-CODEX-SEO-KW-01C — 화면 변경을 지키는 테스트 + B 테스트 보정 + 원고 사본 동기화 (구현 지시서)

- 작업 ID: SEO-KW-01C (SEO-KW-02 화면 변경 포함) · 작성: Claude 2026-11-04 · 기준: 지금 작업 폴더(HEAD + 미커밋분)
- 앞 작업: `docs/SPEC-CODEX-SEO-KW-01A.md`·`01B.md`·`01B2.md`, 결과 `tests/SEO-KW-01A-RESULT.md`·`tests/SEO-KW-01B-RESULT.md`
- 대상: Claude 가 바꾼 화면(`resources/views/**`). **화면 파일은 고치지 않는다.** 테스트가 화면 버그를 찾으면 고치지 말고 보고한다.
- 영수증·판정 기능과 무관한 작업이다. 운영 DB 접속·시더 실행 금지.

## 소유 파일
`tests/**`, `database/content/kw01/**`(아래 A 의 복사만)

## 금지 파일
그 밖 전부(`resources/views/**`, `app/**`, `config/**`, `routes/**`, `database/seeders/**`, `database/migrations/**`, `public/**`, `docs/**`, `.env`). git 쓰기 명령 금지.

## A. 원고 사본 동기화 (바이트 그대로 복사)
Claude 가 원고를 고쳤다(새 글 5편에 「자주 묻는 질문」 h2 + h3/p, 비교표 3개 추가). 아래를 **그대로 복사**한다(내용 수정 금지).
- `docs/content/articles/kw01/0*.html` 5개 → `database/content/kw01/` 같은 이름
- `docs/content/insight-meta-2026-11-04.json` → `database/content/kw01/insight-meta.json` (항목 수가 33 에서 늘었다. 개수는 파일에서 센다)
- `manifest.json` 은 바뀌지 않았다(바이트 동일 확인만).

## B. `tests/Feature/KeywordInsightTest.php` 보정 (B 결과 보고서 4절의 실패 3개)
1. 설명문 33편 검사: `assertDatabaseHas` 에 JSON 의 `path` 를 넘기지 말고 `slug`·`meta_description` 만 쓴다. 개수 33 을 박지 말고 JSON 항목 수로 검사한다.
2. 중복 글 검사: `…스킬3-1` 은 **비공개(published_at NULL)와 설명문 교체 두 가지가 모두 의도된 변경**이다. 이 두 필드 외 나머지 필드가 원본과 같은지 본다.
3. 새 글 렌더 검사: 화면이 설명문 길이를 **글자 수 160** 으로 자르도록 고쳤다(`insights/show.blade.php`). manifest 설명문(160자 이하)이 그대로 나와야 한다. 기대값 완화 금지.

## C. 새 테스트 `tests/Feature/SeoKeywordViewsTest.php`
1. **공통 구조화 데이터** (`partials/jc/head.blade.php`)
   - `/`, `/naver-place-marketing/`, `/services/reward-network`, `/self-marketing/shopping`, 인사이트 글 1편: `application/ld+json` 블록이 전부 JSON 으로 파싱된다.
   - 페이지마다 `Organization`(id `https://j-curve.co.kr/#organization`) 1개, `WebSite` 1개, `WebPage` 1개. WebPage `url` = canonical.
   - 제목·설명에 `&`, `"`, `</script>` 가 든 인사이트를 렌더해도 JSON 이 깨지지 않고 `</script>` 가 원문으로 새지 않는다.
   - WebPage `name`·`description` 에 `&amp;` 같은 HTML 엔티티가 남지 않는다.
   - head 에 `google-site-verification` 은 기존 값 `-JI9b9PGuPzBzPbZQXEAqZR8YfikUXM7GOP_5lgEQXM` **1개만**, `naver-site-verification` 은 없다(공개 호스트 기준).
2. **서비스 서브페이지** (`pages/subpage.blade.php`): `/naver-place-marketing/` 에 `Service`(provider id = organization)와 `BreadcrumbList` 가 **각각 정확히 1개**.
3. **인사이트 글** (`insights/show.blade.php`): `BlogPosting`(headline, datePublished, dateModified, publisher id, author `@id` = organization) + `BreadcrumbList`, `og:type`=`article`, `article:published_time`. 원주소 글 3편(`/seo/…/`)의 `<meta name="description">` 값 불변(기존 보존 테스트 기준). 설명문이 160자를 넘는 글은 160자(마지막 `…` 포함)로, 160자 이하는 그대로.
4. **로그인류** (`layouts/guest.blade.php`): `/login`·`/register`·`/forgot-password` 에 `noindex` 메타, 제목에 `Laravel` 없음, 각각 `로그인`·`회원가입`·`비밀번호 찾기`.
5. **빈 카테고리** (`insights/category.blade.php`): 공개 글 0편 → `noindex`. 글이 있는 카테고리와 `/blog/seo/`·`/blog/link-building/`(0편이어도) → `index`.
6. **키워드 화면**
   - `/self-marketing/shopping` 200, 제목에 `쇼핑 리워드`, H1 `쇼핑 리워드 마케팅`, 주문 링크 `type=shopping`, 가격(원·₩) 표기 없음.
   - `/self-marketing/place` 제목에 `플레이스 리워드`·`플레이스 순위`, 본문에 `/self-marketing/shopping` 링크.
   - `/self-marketing` 에 `/self-marketing/shopping` 링크(쇼핑 카드 「쇼핑 자세히」).
   - `/services/reward-network` 제목에 `리워드 광고`·`오퍼월`, `id="offerwall"` 섹션, FAQPage 에 `오퍼월이란 무엇인가요?`.
   - `/solutions/rankfree` 제목에 `플레이스 순위`·`쇼핑 순위`.
7. **llms**: `/llms.txt` 에 `&amp;`·`&lt;` 없음, 모든 링크가 `https://j-curve.co.kr/` 로 시작.
8. **FAQPage (SEO-KW-02, `partials/jc/schema-faq.blade.php`)** — 아래 페이지에 FAQPage 가 **정확히 1개**, 질문 수가 표와 같고, 모든 질문이 그 페이지의 `<summary>` 글자와 같으며, 답(text)에 `<` 가 없다.

   | 경로 | 질문 수 |
   |---|---|
   | `/self-marketing` | 5 |
   | `/self-marketing/place` | 6 |
   | `/self-marketing/shopping` | 6 |
   | `/solutions` | 6 |
   | `/solutions/rankfree` | 9 |
   | `/solutions/leadbay` | 7 |
   | `/solutions/boostingshop` | 7 |
   | `/solutions/call2sale` | 7 |

   - 숫자가 화면과 다르면 화면 쪽 실제 개수를 보고한다(기대값을 화면에 맞춰 바꾸지 말고 보고 후 판단은 Claude).
   - `/solutions/rankfree` 첫 FAQ 의 화면 답에 `/naver-place-marketing/`·`/self-marketing/place` 링크가 그대로 있다(배열 전환 회귀).
   - `schema-faq` 에 `</script>` 가 든 질문을 넘겨도 JSON 이 깨지지 않는다(인사이트 본문 FAQ 로 재현).
9. **위치 경로·서비스 (SEO-KW-02, head 의 `sd_page`·`sd_crumbs`·`sd_service`)**
   - 아래 20개: `BreadcrumbList` 정확히 1개, 첫 항목 `홈` = `https://j-curve.co.kr/`, 마지막 항목 = 그 페이지 canonical, 모든 item 이 `https://j-curve.co.kr` 로 시작. WebPage `breadcrumb.@id` = BreadcrumbList `@id`.
     `/solutions/rankfree` `/solutions/leadbay` `/solutions/boostingshop` `/solutions/call2sale` `/solutions/shopitrend` `/solutions` `/services` `/services/performance-marketing` `/services/cpa-marketing` `/services/reward-network` `/services/seo/aeo` `/services/seo/geo` `/wordpress-agency/` `/services/marketing-support` `/about-us/` `/contact-us/` `/support/faq` + `/self-marketing` `/self-marketing/place` `/self-marketing/shopping`
   - `Service` 있음(정확히 1개, provider `@id` = organization, url = canonical): 위 목록에서 `/solutions` `/services` `/about-us/` `/contact-us/` `/support/faq` 를 뺀 나머지.
   - `Service` 없음: `/solutions` `/services` `/about-us/` `/contact-us/` `/support/faq` `/`.
   - `/services/seo/aeo` 경로: 홈 › 서비스(`/services`) › SEO(`/seo/`) › 현재.
10. **새 글 FAQ (`insights/show.blade.php`)**: 시더로 넣은 새 글 5편 각각 FAQPage 1개, 질문 3개, 질문 = 본문 「자주 묻는 질문」 아래 h3 글자. 「자주 묻는 질문」 h2 가 없는 옛 글에는 FAQPage 가 없다.
11. **푸터 링크**: `/`, `/blog/`, `/naver-place-marketing/` 푸터에 `/self-marketing/place`·`/self-marketing/shopping` 링크가 있다. 데스크톱 헤더의 셀프마케팅 링크는 그대로 1개.

## 테스트 무력화 실험 (최소 7건, 필수)
지키는 화면 코드를 **임시로** 되돌려 해당 테스트가 빨개지는지 보고, 반드시 원상복구한다(복구 후 `git diff --stat -- resources/views` 가 실험 전과 같음을 출력으로 붙인다).
- head 의 `JSON_HEX_TAG` 제거 → C1 `</script>` 빨강
- `schema-faq` 의 `JSON_HEX_TAG` 제거 → C8 `</script>` 빨강
- guest 의 `noindex` 메타 제거 → C4 빨강
- category 의 noindex 블록 제거 → C5 빨강
- `solutions/rankfree` 의 `@section('sd_page', …)` 제거 → C9 빨강
- `insights/show` 설명문 제한을 `Str::limit(…, 155)` 로 되돌림 → B3·C3 빨강
- footer 의 `self.children` 반복 제거 → C11 빨강

## 합격 게이트
`php artisan test` 전부 초록(실제 출력) · `./vendor/bin/pint --test tests/Feature/SeoKeywordViewsTest.php tests/Feature/KeywordInsightTest.php` · 무력화 실험 결과표 · 화면 파일 diff 가 실험 전과 동일 · A 복사본이 원본과 바이트 동일(출력).

## 반환물
`tests/SEO-KW-01C-RESULT.md` 에: 바꾼 파일, 새 테스트 목록, 실제 출력, 무력화 실험 표(되돌린 코드 / 빨간 테스트 이름 / 복구 확인), 테스트가 찾은 화면 버그(있으면), 미검증 항목.
