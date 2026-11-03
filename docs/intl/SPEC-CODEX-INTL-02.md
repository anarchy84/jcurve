# SPEC-CODEX-INTL-02 — 영어·일본어 나머지 페이지 화면·문구 초벌 (Codex 구현 세션)

- 작성: Claude, 2026-11-03. 작업 폴더 `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`(브랜치 `wip/2026-11-03-i18n`). 원래 저장소 접근 금지.
- 먼저 읽을 것(순서대로): `docs/intl/INTL-PLAN.md`(§1 절대 원칙·§5 문구 원칙) → `docs/intl/GLOSSARY.md`(**용어·숫자 표기 정본, 반드시 따른다**) → `docs/intl/INTL-01-IMPL-RESULT.md` §3(도우미·라우트·뷰 계약) → **Claude 가 만든 본보기 3개**(아래) → 해당 한국어 원본 뷰.
- 제코 결정(11/3): 대상 = 한국 진출 외국 기업, 말투는 Claude 본보기 그대로 OK, 문의 언어 안내는 「어느 언어로 써도 되고 답은 번역을 거쳐 보낸다」(같은 언어로 답한다는 약속 금지), 셀프마케팅은 소개 페이지만(주문 버튼 → 문의).

## 본보기 (Claude 작성 — 수정 금지, 구조·말투·방식을 그대로 따른다)
| 종류 | 템플릿 | 문구 |
|---|---|---|
| 새 디자인(layouts.jc 계열) | `resources/views/intl/pages/home.blade.php` → `@extends('layouts.intl')` | `lang/{en,ja}/pages/home.php` |
| 기존 랜딩 톤(layouts.app 계열) | `resources/views/intl/pages/company.blade.php`, `resources/views/intl/contact.blade.php` → `@extends('layouts.intl-app')` | `lang/{en,ja}/pages/company.php`, `lang/{en,ja}/pages/contact.php` |
| 공용 | `layouts/intl*.blade.php`, `partials/intl/{head,header,footer,switcher,menu}`, `lang/{en,ja}/menu.php` | |

규칙(본보기에서 확인할 것):
- 한국어 뷰가 `layouts.jc` 를 쓰면 외국어 뷰는 `layouts.intl`, `layouts.app` 이면 `layouts.intl-app`. 마크업·클래스·섹션 순서·id 는 한국어 뷰와 같게.
- 문구는 전부 `lang/{en,ja}/pages/<이름>.php` 배열(영·일 키 구조 동일). 템플릿은 `$t = fn ($k) => __('pages/<이름>.'.$k)`. 줄바꿈은 배열 + `$lines`(e() 후 `<br>`). **번역 문자열을 `{!! !!}` 로 그대로 출력하지 않는다.**
- 링크는 전부 `intl_route()`. 한국어 전용·제외 구역(로그인·회원가입·마이페이지·커뮤니티·셀프마케팅 주문 `/self-marketing/order`·무료 진단 `seo.check`·문의게시판)으로 가는 링크·폼은 **문의(`intl_route('contact', ['service_interest' => …])`)로 바꾸거나 뺀다.** 외부 서비스 링크(rankfree.kr 등)는 그대로.
- 빼는 것: `partials.jc.wp-legacy`(한국어 SEO 보존용), `partials.jc.rank-form`(한국어 도구), 카카오 버튼, 한국어에만 사실인 문장(예: 「지금 이 화면도 검색 상위」류). 뺀 문장은 반환물에 목록으로.
- JSON-LD 가 있으면 같은 구조로 번역(`inLanguage` 추가, `JSON_HEX_TAG`).
- 숫자는 GLOSSARY §6 대응 그대로(값 변경 금지, 원화 환산 금지). 2026년 기준·회사 전체 누적 같은 라벨 유지. 숫자 세기 효과(`data-count-to`)는 외국어에선 빼고 정적 표기(본보기 company 참고).
- 메타: `title`(영어 ≤ 60자 권장, 브랜드 `J-Curve Interactive`), `description`(≤ 155자). 한국어 SEO 제목을 직역하지 말고 그 페이지 주제 + 대상(외국 기업)에 맞게.

## 만들 화면 (en·ja 둘 다)
| 라우트(한국어 이름) | 외국어 뷰(`intl.` + 한국어 뷰 이름) | 비고 |
|---|---|---|
| privacy | `intl.pages.privacy` | 충실 번역. 맨 위에 「번역본은 이해를 돕기 위한 것이며 한국어 원문이 우선한다」 한 줄(영·일) |
| support.faq | `intl.pages.faq` | 81문항 전부. 제외 구역 안내 문항은 「외국어판에서는 문의로」 취지로 링크만 바꾸고 문장 사실은 유지 |
| services.index | `intl.services.index` | |
| services.show ×5 | `intl.services.{performance-marketing,cpa-marketing,reward-network,seo,wordpress}` | PageController::SERVICE_VIEWS 대응 뷰 이름 확인 |
| services.seo.aeo / geo | 한국어 뷰 이름 확인 후 `intl.` 접두 | |
| services.marketing-support | `intl.pages.marketing-support` | 「선정·지원금 보장 안 함」 고지 유지 |
| services.seo.sub·cpa.sub·performance.sub, solutions.boostingshop.sub (19개) | `intl.pages.subpage` 하나 | 문구는 `lang/{en,ja}/subpages.php` — `config/subpages.php` 와 같은 그룹·키 구조로 그 안의 사람이 읽는 문자열만 번역(`seo_title` 은 외국어 제목으로). 컨트롤러가 넘기는 `$parent`·`$page` 와 짝 맞추는 방법은 INTL-01 계약 범위에서(필요하면 컨트롤러가 `__('subpages')` 를 병합 — 이 경우 변경 이유를 반환물에) |
| solutions.index·rankfree·boostingshop·shopitrend·leadbay·call2sale | `intl.solutions.*` | |
| self-marketing, self-marketing.place | `intl.pages.self-marketing`, `intl.pages.self-marketing-place` | 주문 버튼·주문 흐름 → 문의(`service_interest=boostingshop` 등). 가격표는 숫자 그대로 KRW |
| work.index | `intl.work.index` | 운영 DB 에 사례 0건일 수 있음 — 빈 상태 문구 포함 |
| insights.index / category / show | `intl.insights.{index,category,show}` | 계약: index·category 의 `$insights`(각 `translation`), show 의 `$insight` + `$translation`. 본문은 `$translation->content`(HTML, 신뢰된 시더 데이터 — 한국어 show 와 같은 방식으로 출력). 카테고리 이름은 `lang/{en,ja}/insights.php` 의 `categories` 맵(performance-marketing·news·seo·link-building). 날짜 형식은 그 언어 관례 |

## 테스트 (`tests/Feature/IntlPagesTest.php`)
- 위 모든 라우트 × en·ja: 200, `<html lang>` 맞음, canonical = 자기 주소, hreflang ko·en·ja·x-default.
- 렌더된 본문 텍스트(스크립트·스타일 제외)에 **한글 0자**, 번역 키 노출(`pages/`·`menu.`·`subpages.` 같은 원문 키) 0.
- 페이지 안 내부 링크 전부 200(또는 의도된 301 1홉), 제외 구역 링크 0.
- 한국어 페이지 무변경 테스트(INTL-01 것) 계속 그린. **Claude 가 이번에 한국어 쪽에 넣은 두 블록**(① `partials/jc/head.blade.php` 의 `<link rel="alternate" hreflang=…>` 줄들 ② 헤더의 `data-intl-switcher` 블록, `partials/intl/switcher.blade.php`)만 정규화에서 제거하고 비교하도록 비교기·테스트를 갱신한다 — 그 밖의 차이는 여전히 0 이어야 한다. 한국어 페이지 중 외국어판이 있는 것은 hreflang ko·en·ja·x-default 가 나오고, 없는 것(로그인·커뮤니티·주문 등)은 hreflang 이 하나도 없어야 한다(테스트 추가).

## 합격 게이트
`php artisan test` 전체 그린(개수), 새·변경 PHP `./vendor/bin/pint --test`, `npm run build`. 무력화 실험: lang 파일 하나에서 키 하나를 지우면 키 노출 테스트가 빨개지는지, 템플릿 하나에 한글 한 단어를 넣으면 한글 0 테스트가 빨개지는지 — 원복 후 `git diff | shasum` 동일.

## 금지
커밋·푸시·배포, 한국어 뷰·한국어 데이터(`config/subpages.php` 값 포함) 수정, Claude 본보기 파일 수정, **Claude 구역 한국어 블록(`partials/jc/head.blade.php`·`partials/jc/header.blade.php`·`partials/intl/switcher.blade.php`) 수정**, `database/content/intl/insights/*.json`(INTL-03 세션 구역), `public/media/**`, `.env` 열람·변경, 포트 8000·8014·8023·8024(서버가 필요하면 8031만).

## 추가 지시 (Claude, 2026-11-03 15:13 — 위 내용보다 이 절이 우선)

### A. 지금 상태 — 시작 시 테스트 2개 실패는 예상된 것
Claude 가 한국어 화면에 허용된 두 블록을 넣었다(INTL-PLAN §1): ① `partials/jc/head.blade.php` 의 hreflang `<link>` 줄 ② `partials/jc/header.blade.php` 의 `@include('partials.intl.switcher')` 2곳(데스크톱 aside, 모바일 패널 끝). include 는 **줄 맨 앞(들여쓰기 0)** 에 있다 — 그래야 렌더 결과에 스위처 블록 문자열만 끼어들고 다른 공백이 그대로 남는다. 그래서 시작 시 `php artisan test` 199개 중 2개가 빨갛다. 둘 다 이번 작업에서 **테스트를 새 계약에 맞게 고친다**:
- `IntlFoundationTest::test_legacy_landing_aliases_are_single_hop_but_excluded_destinations_have_no_foreign_redirect` (143행): `/en/about-us/` 404 를 기대 → 회사소개 외국어 뷰가 생겨서 200. 「외국어 뷰가 있는 목적지는 200·Location 없음, 없는 목적지(제외 구역)는 404」로.
- `IntlFoundationTest::test_url_helpers_preserve_addresses_and_use_public_origin_for_alternates` (176행): 한국어 `/` 에 hreflang 이 없다고 단언 → 이제 있어야 한다. 「외국어판이 있는 한국어 페이지는 hreflang ko·en·ja·x-default, 없는 페이지는 `<link rel="alternate" hreflang` 0」로.

### B. V5 수정 (INTL-01 검증 지적 — 이번 범위)
지금 `intl_alternates()` 와 FeedCatalog 사이트맵은 외국어 **뷰가 실제로 있는지** 보지 않는다. 실측(15:10): 한국어 사이트맵 104개 주소 중 94개에 hreflang 이 나가는데, 외국어 뷰가 없어서 대부분 404 를 가리킨다(`/seo/` → `/en/seo/` 404, `/blog/` → `/en/blog/` 404 등).
- 라우트 이름 + 파라미터 → 외국어 뷰 이름 매핑을 **한 곳**(`App\Support\IntlRoutes` 등)에 두고, `intl_alternates()`·사이트맵·`intl_view()` 가 같은 판정을 쓴다. 판정 = `View::exists('intl.'.$view)` 이고, 서브페이지(`pages.subpage`)는 `lang/{locale}/subpages.php` 에 그 그룹·키가 있을 때만 참. 블로그 글·카테고리의 번역 확인은 지금 것 유지.
- 언어 전환 링크(`partials/intl/switcher`)는 `intl_alternates()` 결과만 쓰므로 자동으로 맞춰진다(Claude 가 15:11 에 대체 링크도 경로만 쓰게 바꿨다 — 손대지 않는다).
- 테스트 + **무력화 실험**: 매핑 하나를 없는 뷰 이름으로 바꾸면 그 한국어 페이지의 hreflang 이 0 이 되고 사이트맵에서도 그 외국어 주소가 빠지는지. 판정 코드를 되돌리면(뷰 확인 제거) 테스트가 실제로 빨개지는지. 원복 후 `git diff | shasum` 동일.

### C. 한국어 비교기(`tests/Support/intl_compare.py`·`intl_snapshot.php`) 갱신
- 현재 쪽 출력에서 **딱 두 가지만** 지우고 기준(0662117)과 비교한다:
  - 줄 단위 `^<link rel="alternate" hreflang="[^"]+" href="[^"]+">\n` (multiline)
  - 블록 `<nav class="jc-lang[^"]*"[^>]*data-intl-switcher>.*?</nav>\n` (dotall, **앞 공백은 지우지 않는다**)
- 정규화 허용(양쪽 동일 적용): CSRF 토큰, 허니팟(무작위 필드 이름 `my_name_*`, `valid_from` 값), SVG 무작위 id `(sbg|sgl|sdot)-*`, Vite 해시. 그 밖의 차이는 0 이어야 한다.
- 대상: 기준 사이트맵의 **모든** 주소 + 제외 구역(`/login`·`/register`·`/community`·`/self-marketing/order`·`/seo-check`·`/dashboard`) + 이동 주소(`/company`·`/contact`·`/insights`·`/services/seo`). **301·302 는 따라가지 말고** 상태·Location·본문을 비교한다(따라가면 운영 워드프레스까지 가서 가짜 「같음」이 나온다). 사이트맵 XML 은 「한국어 항목 순서·내용 동일 + 외국어 항목은 뒤에만 추가」로 따로 판정.
- 참고 실측(Claude, 15:10): 위 방식으로 104개 주소 DIFF 0.

### D. 다른 세션과 같이 돈다
- INTL-03A·03B(블로그 번역)가 같은 폴더에서 동시에 `database/content/intl/insights/*.json` 을 만든다. 그 파일은 건드리지 않는다. 테스트는 그 JSON 내용에 기대지 말고 테스트 안에서 만든 데이터만 쓴다(예외: 기존 `mobile-marketing-strategies` slug — 03A 가 그 slug 를 유지한다).
- 실DB·Claude 임시 DB(`/private/tmp/.../intl.sqlite`)를 쓰지 않는다. `DB_DATABASE` 를 셸에 export 하지 않는다(테스트가 그 DB 를 지운 적 있음). 필요하면 명령 하나에만 붙인다.

### E. 빌드
`npm run build` 가 샌드박스 EPERM 이면 `npx vite build --configLoader runner`. 그래도 안 되면 실제 오류 출력을 반환물에 그대로.

## 반환물 `docs/intl/INTL-02-IMPL-RESULT.md`
만든 파일 표, 페이지별로 뺀 한국어 전용 문장·바꾼 링크 목록, **페이지별 숫자 대조표**(한국어 원문 숫자 → 외국어 표기), 확신 없는 용어·표현 목록(Claude 검수용), 실행 명령·실제 출력, 무력화 실험, 미검증 항목.
