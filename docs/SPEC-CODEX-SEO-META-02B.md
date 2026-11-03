# SPEC-CODEX-SEO-META-02B — 워드프레스 본문 원문 보존 구간 회귀 테스트 (Codex 구현 세션)

- 작성: Claude, 2026-11-03. 기준: 현재 작업 트리(HEAD `bfa7bd8` + 미커밋 변경).
- 배경: 제코 11/3 「옛 문장 그대로 넣기」·「전부 그대로 넣기」. 원주소 소개 페이지의 운영 워드프레스 본문이 새 디자인에 1~10% 만 남아 있어서, Claude 가 원문을 그대로 보여 주는 구간을 넣었다. 나중에 누가 고쳐서 문장이 빠지면 바로 빨개지는 테스트가 필요하다.

## Claude 가 만든 것 (수정 금지 — `resources/**` 는 Claude 구역)
- `resources/views/partials/jc/wp-legacy.blade.php` — `@include('partials.jc.wp-legacy', ['wpLegacy' => 이름?, 'wpStyle' => 'landing'|'jc'])`. 이름이 없으면 현재 원주소에서 이름을 얻는다(`/seo-backlinks/` → `seo-backlinks`, `/` → `home`, `[a-z0-9-]` 만 허용). `<section id="service-detail" class="… jc-wp-legacy">` 안에 블록을 순서대로 출력(`h`·`p`·`li`, 텍스트는 이스케이프).
- 데이터 `resources/views/partials/jc/wp-legacy/{home,contact-us,seo,seo-backlinks,wordpress-agency,naver-place-marketing,naver-shopping-marketing,kakao-gift,coupang}.json` — `blocks[]`(type·level·text), `excluded[]`(새 사이트에 없는 기능 안내라 뺀 문구).
- include 위치: `pages/home`(jc), `services/seo`, `services/wordpress`, `contact`, `pages/subpage`(이름 자동).

## ⛔ 규칙
- 소유 파일: `tests/**` 만. 금지: 그 밖의 모든 파일(특히 `resources/**`, `config/**`, `database/**`, `routes/**`). 커밋·푸시·배포 금지. 포트 8000·8014 서버 건드리지 말 것.

## 만들 테스트 (`tests/Feature/WpLegacyContentTest.php`)
공개 호스트 조건(`SEO_PUBLIC_URL=https://j-curve.co.kr`, Host `j-curve.co.kr`), 기존 테스트처럼 필요한 시더를 돌린 상태에서:
1. JSON 9개 각각: 해당 원주소(`home`→`/`, `contact-us`→`/contact-us/`, 그 밖은 `/{이름}/`) 응답 200, `id="service-detail"` 구간이 정확히 1개, **모든 `blocks[].text` 가 그 구간 안에 이스케이프된 형태로 들어 있고 JSON 순서대로 나온다.**
2. `excluded[]` 문구는 페이지 어디에도 없다.
3. `/about-us/`, `/blog/`, `/blog/seo/`, `/blog/link-building/`, 그리고 `seo_title` 없는 서브페이지(cpa·performance·boostingshop 그룹에서 각 1개)에는 `service-detail` 구간이 없다.
4. 페이지당 `<h1` 은 1개(구간 추가로 h1 이 늘지 않음).
5. 원문 무결성 고정: JSON 9개의 `blocks` 를 정규화(공백 하나로)해 이어 붙인 문자열의 SHA256 을 테스트에 상수로 박아, 누가 JSON 문구·숫자를 고치면 빨개지게 한다(값은 현재 파일로 계산).

## 합격 게이트
`php artisan test` 전체 그린(개수), `./vendor/bin/pint --test`. 무력화 실험: ① `pages/subpage.blade.php` 의 include 한 줄을 임시로 지움 → 1번이 빨개짐 ② JSON 하나의 숫자 한 글자를 임시로 바꿈 → 5번이 빨개짐. 둘 다 원복 후 `git diff | shasum` 실험 전후 동일 출력.

## 반환물
`docs/SEO-META-02B-IMPL-RESULT.md`: 추가 파일, 실행 명령·실제 출력, 무력화 실험 결과, 미검증 항목.
