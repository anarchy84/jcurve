# 다국어(영어·일본어) 사이트 — 설계 정본 (INTL)

- 작성: Claude, 2026-11-03. 브랜치 `wip/2026-11-03-i18n`(작업 폴더 `.claude/worktrees/i18n`). **main 은 한국어 운영 전환이 끝날 때까지 건드리지 않는다.**
- 제코 결정(11/3): 언어 = 영어·일본어 / 범위 = 블로그 글까지 전부 / 주소 = `/en/`·`/ja/` 하위 경로 / 대상 = **한국 진출 외국 기업**(문구를 그 대상에 맞게 다시 씀, 사실·숫자는 한국어판 그대로) / 시점 = 한국어 운영 전환 끝난 뒤 / 한국어 페이지에 hreflang + 언어 전환 링크 추가 OK / 셀프마케팅은 소개 페이지 2개만(주문 버튼 → 문의).

## 1. 절대 원칙
1. **한국어 페이지는 문구·제목·설명·주소·canonical 이 한 글자도 바뀌지 않는다.** 바뀌어도 되는 건 단 두 가지: ① `<link rel="alternate" hreflang>` 태그 ② 헤더의 언어 전환 링크(`data-intl-switcher` 블록). 검증은 한국어 전 페이지 렌더 결과를 기준 커밋과 비교해서 이 두 블록 외 차이 0.
2. **번역이 없는 페이지는 404.** `/en/…` 에서 한국어 화면을 대신 보여 주지 않는다(검색엔진이 중복·저품질로 본다).
3. 성과 숫자(373억·15,700·128만 등)는 값을 바꾸지 않는다. 단위·표기만 옮긴다(예: 373억 → `KRW 37.3B+` / `373億ウォン+`). 라벨·기준 시점·고지 문구의 뜻은 그대로.
4. 영수증·판정 규칙 등 앱 쪽 규칙은 이 작업과 무관.

## 2. 주소 규칙 (하나의 규칙 + 글 예외)
- 한국어 정식 주소 `P` (원주소 보존 규칙 적용 후, 끝 슬래시 포함 그대로) → 영어 `/en` + `P`, 일본어 `/ja` + `P`. 홈 `/` → `/en/`, `/ja/`.
  - 예: `/about-us/` → `/en/about-us/`, `/seo/` → `/en/seo/`, `/services/performance-marketing/naver-gfa` → `/en/services/performance-marketing/naver-gfa`, `/blog/seo/` → `/en/blog/seo/`.
- 한국어에서 301 되는 옛·새 경로도 같은 규칙: `/en/company` → 301 1홉 → `/en/about-us/`. 끝 슬래시만 다른 변형도 301 1홉.
- **블로그 글만 예외**: `/{locale}/insights/{번역 slug}` (slug 는 그 언어 — 영어는 영문 소문자-하이픈, 일본어도 영문 slug 사용). 한국어 글과의 짝은 DB 로 연결.
- 제외(외국어판 없음 → 404, hreflang 없음): 커뮤니티, 로그인·회원가입·마이페이지, 셀프마케팅 주문(`/self-marketing/order` 등), 무료 SEO 진단 도구(`/seo-check`), 문의게시판, 숨김 글, `/work/{slug}`(운영에 사례 없음).

## 3. 범위 (외국어판을 만드는 한국어 라우트)
home · company(`/about-us/`) · contact(`/contact-us/`) · privacy · support.faq(있으면) · services.index · services.show(performance-marketing·cpa-marketing·reward-network·seo·wordpress) · services.seo.aeo · services.seo.geo · services.seo.sub(5) · services.cpa.sub(5) · services.performance.sub(3, google-ads 생기면 포함) · services.marketing-support · solutions.index · solutions.rankfree·boostingshop·shopitrend·leadbay·call2sale · solutions.boostingshop.sub(6) · self-marketing · self-marketing.place · work.index · insights.index(`/blog/`) · insights.category(번역 글이 있는 카테고리) · insights.show(번역된 공개 글 전부 — 52편).
- 소개 페이지에 넣은 「워드프레스 본문 원문 구간」(partials/jc/wp-legacy)은 한국어 SEO 보존용이라 외국어판에는 넣지 않는다.

## 4. 구조
- **설정** `config/intl.php`: 기본 `ko`, 언어별 `prefix`·`html_lang`·`og_locale`·`label`·`short`, 외국어판이 있는 라우트 이름 목록.
- **라우트**: 외국어 라우트는 `en.`·`ja.` 이름 접두로 한국어 라우트와 같은 이름 체계(`en.home`, `ja.services.show` …). 같은 컨트롤러를 쓰고 미들웨어가 언어를 정한다.
- **화면**: 한국어 뷰 `X` 의 외국어 뷰는 `intl.X` (예: `intl.pages.home`, `intl.services.seo`, `intl.pages.subpage`) — 템플릿 하나를 영어·일본어가 같이 쓰고, 문구는 언어 파일 `lang/{en,ja}/pages/*.php`·`lang/{en,ja}/subpages.php`·`lang/{en,ja}/menu.php` 에서 읽는다. 한국어 뷰는 그대로.
- **도우미**(Blade 에서 사용): `intl_locale()`, `intl_route($name, $params = [], $locale = null)`(한국어면 그대로 `route()`), `intl_alternates()`(현재 페이지의 언어별 절대 URL — 있는 것만), `intl_view($name, $data)`(컨트롤러용, 외국어 뷰가 없으면 404).
- **블로그 번역**: 테이블 `insight_translations`(insight_id, locale, slug, title, excerpt, content, meta_title, meta_description, source_hash, translated_at) — (insight_id, locale) 유일, (locale, slug) 유일. 원문은 `database/content/intl/insights/{영문 slug}.json`(한 파일에 `ko_slug`·`source_hash`·`en`·`ja`), 시더 `IntlInsightSeeder` 가 넣는다. `source_hash` = 번역 당시 한국어 표시본(content) SHA256 → 한국어 글이 바뀌면 「번역 낡음」을 잡아낸다.
- **문의**: 외국어 문의 폼도 같은 접수 처리, `leads.locale` 칸(빈 값 = 한국어)으로 외국 문의를 구분. locale 은 주소 접두로만 정한다. 오류·완료 문구는 그 언어로.
- **SEO**: 모든 대상 페이지에 자기 canonical, `hreflang` ko·en·ja·`x-default`(=ko) 서로 가리킴(있는 언어만), `<html lang>`, `og:locale`. 사이트맵에 외국어 주소 추가. robots·RSS 는 그대로(RSS 는 한국어만).
- **글꼴**: 일본어 페이지는 Pretendard JP(같은 CDN, 같은 판).

## 5. 문구 원칙 (대상 = 한국 진출 외국 기업)
- 한국어판 사실·서비스 범위·숫자만 쓴다. 새 실적·새 약속·성과 보장 문구를 만들지 않는다.
- 외국 기업이 모르는 한국 플랫폼은 처음 나올 때 한 줄로 설명(예: Naver — Korea's largest search portal; Coupang — Korea's largest e-commerce marketplace).
- 영어: B2B, 짧고 단정. 일본어: です・ます, B2B 정중체, 플랫폼명은 현지 표기(NAVER, Coupang(クーパン), カカオトーク).
- 용어집: `docs/intl/GLOSSARY.md`. 모든 번역(사람·Codex)은 이걸 따른다.

## 6. 단계
| 단계 | 내용 | 누가 |
|---|---|---|
| 1 | 기반: 설정·라우트·미들웨어·주소 생성·도우미·번역 테이블·시더 틀·문의 locale·사이트맵·언어 파일 틀·테스트 | Codex 구현 → 별도 Codex 검증 |
| 2 | 외국어 레이아웃·헤더·푸터·언어 전환, 한국어 head hreflang·헤더 전환 링크, 핵심 페이지(홈·회사소개·문의·서비스 5개) 템플릿·영/일 문구 | Claude → 제코 말투 확인 |
| 3 | 나머지 페이지 템플릿·문구 초벌 | Codex 초벌 → Claude 검수 |
| 4 | 블로그 52편 × 영/일 | Codex 초벌 → Claude 표본 검수 + 숫자·고유명사 자동 대조 |
| 5 | 한국어 무변경 전수 비교·hreflang 상호 연결·한글 잔존 0·링크 깨짐 0 독립 검증 → 제코 화면 확인 → 한국어 전환 뒤 main 반영 | Codex 검증 → Claude 판정 → 제코 |
