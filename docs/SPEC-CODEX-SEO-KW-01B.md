# SPEC-CODEX-SEO-KW-01B — 키워드 랜딩 문구 반영 · 새 글 5편 · 칼럼 설명 33편 (구현 지시서)

- 작업 ID: SEO-KW-01B · 작성: Claude 2026-11-04 · 기준: `70ccde4` + SEO-KW-01A 작업분(같은 작업 폴더, 아직 미커밋)
- 필독: `docs/COLLAB.md`, `docs/SPEC-CODEX-SEO-KW-01A.md`(앞 작업), `config/subpages.php`, `database/seeders/LegacyContentSeeder.php`·`LegacyRedirectSeeder.php`, `app/Models/Insight.php`
- 목표 키워드(제코 2026-11-04): 쇼핑 상위(노출) · 스마트스토어 상위노출 · 네이버 플레이스 상위(노출) · 플레이스 상위 · 플레이스 노출 · 플레이스 순위 · 쇼핑 순위 · 플레이스 리워드 · 쇼핑 유입 · 리워드 광고 · 오퍼월
- 문구·원고는 Claude 가 확정했다. **글자 하나도 바꾸지 말고** 그대로 넣는다.

## 소유 파일
`config/subpages.php`, `database/seeders/**`, `database/content/kw01/**`(새로 만듦), `tests/**`, `config/seo.php`(B4 만)

## 금지 파일
`resources/views/**`, `routes/pages.php`, `docs/**`(읽기만), `.env`, `public/media/**`, `database/content/legacy/**`. git 쓰기 명령 금지.

## B1. `config/subpages.php` — `seo.items.naver-place`
1. `'title'` → `'네이버 플레이스 상위노출 — 발견에서 방문까지'` (seo_title·meta_description·lead 는 그대로)
2. `sections` 에서 `checklist` 섹션 바로 뒤에 아래 섹션을 끼운다:
```php
[
    'type' => 'points',
    'tone' => 'dark',
    'id' => 'place-rank',
    'eyebrow' => 'Ranking Basics',
    'title' => '네이버 플레이스 순위와 노출은 무엇으로 정해지나요',
    'lead' => '네이버는 플레이스 노출 순서를 자동 계산으로 정하고 세부 가중치를 공개하지 않습니다. 일반적으로 검색어와의 연관성, 정보의 충실성, 인기도, 거리가 함께 반영된다고 알려져 있습니다. 제이커브는 이 순서대로 정비합니다.',
    'items' => [
        ['title' => '연관성', 'text' => '업종·카테고리·소개·메뉴가 고객의 검색어와 맞는지 정비합니다.'],
        ['title' => '정보 충실성', 'text' => '영업시간·가격·사진·예약처럼 고객이 고르는 데 필요한 정보를 빈칸 없이 채웁니다.'],
        ['title' => '인기도', 'text' => '검색 후 방문·저장·길찾기 같은 반응이 쌓이도록 동선을 다듬고, 필요하면 플레이스 리워드로 보탭니다.', 'href' => '/self-marketing/place', 'label' => '플레이스 리워드 보기'],
        ['title' => '플레이스 순위 기록', 'text' => '같은 키워드·같은 조건으로 플레이스 순위를 기록해 다음 작업을 정합니다.', 'href' => '/solutions/rankfree', 'label' => '플레이스 순위 무료 확인'],
    ],
    'note' => '특정 순위나 노출 위치를 보장하지 않습니다.',
],
```
3. `faq` 맨 뒤에 두 개 추가:
```php
['question' => '플레이스 순위는 어떻게 확인하나요?', 'answer' => '랭크프리에서 지역명과 업종을 붙인 키워드를 넣으면 가입 없이 네이버 플레이스 순위를 확인할 수 있습니다. 순위는 검색 위치·기기·시점에 따라 달라지므로 같은 조건으로 기록해 변화를 봅니다.'],
['question' => '플레이스 리워드도 함께 진행하나요?', 'answer' => '정보 정비가 끝난 뒤 반응 신호가 부족하면 플레이스 리워드를 함께 검토합니다. 리워드는 인기도를 돕는 보조 수단이며, 리뷰 작성 미션은 제공하지 않고 순위를 보장하지 않습니다.'],
```

## B2. `config/subpages.php` — `seo.items.naver-shopping`
1. `'title'` → `'네이버 쇼핑·스마트스토어 상위노출 — 상품 데이터부터 구매 설득까지'`
2. `'seo_title'` → `'네이버쇼핑·스마트스토어 상위노출 마케팅 전문가의 노하우로 매출 UP'`
3. `'meta_description'` → `'네이버쇼핑·스마트스토어 상위노출 마케팅을 위한 SEO는 제이커브에게 맡기세요! 10년 이상 풍부한 노하우로 상품 노출 극대화, 클릭률 향상, 매출 증대를 실현시켜 드립니다.'`
   - 원주소 `/naver-shopping-marketing/` 의 제목·설명 보존 테스트가 있으면 **이 두 값으로 기대값을 바꾼다**(제코 지시로 키워드를 더하는 의도적 변경 — 원문 단어는 그대로 두고 「·스마트스토어」만 더함). 다른 원주소 기대값은 건드리지 않는다.
4. `sections` 에서 `table` 섹션 바로 뒤에:
```php
[
    'type' => 'points',
    'tone' => 'dark',
    'id' => 'shopping-rank',
    'eyebrow' => 'Ranking Basics',
    'title' => '네이버 쇼핑 순위는 무엇으로 정해지나요',
    'lead' => '네이버는 쇼핑 검색 순위의 세부 산식을 공개하지 않습니다. 업계에서는 보통 적합도·인기도·신뢰도 세 축으로 설명합니다. 제이커브는 적합도 정비, 신뢰도 지키기, 인기도 쌓기 순서로 봅니다.',
    'items' => [
        ['title' => '적합도', 'text' => '상품명·카테고리·브랜드·속성·태그가 고객의 검색어와 맞도록 상품 데이터를 정비합니다.'],
        ['title' => '신뢰도', 'text' => '상품 정보·이미지·상세페이지가 같은 약속을 하도록 맞추고, 구매평·판매실적 어뷰징처럼 페널티가 되는 방식은 쓰지 않습니다.'],
        ['title' => '인기도', 'text' => '클릭·찜·판매가 쌓이도록 대표 이미지와 상세페이지를 다듬고, 필요하면 쇼핑 리워드로 유입·찜 신호를 보탭니다.', 'href' => '/self-marketing/shopping', 'label' => '쇼핑 리워드 보기'],
        ['title' => '쇼핑 순위 기록', 'text' => '같은 키워드·같은 조건으로 쇼핑 순위를 기록해 다음 작업을 정합니다.', 'href' => '/solutions/rankfree', 'label' => '쇼핑 순위 무료 확인'],
    ],
    'note' => '쇼핑 검색 순위나 매출을 보장하지 않습니다.',
],
```
5. `faq` 맨 뒤에:
```php
['question' => '스마트스토어 상위노출은 얼마나 걸리나요?', 'answer' => '정해진 기간은 없습니다. 상품군의 경쟁도, 현재 상품 정보 상태와 판매 실적에 따라 달라지며, 변경 시점과 쇼핑 순위를 같은 조건으로 기록하며 판단합니다.'],
['question' => '쇼핑 유입 리워드도 함께 하나요?', 'answer' => '상품 데이터 정비가 끝난 뒤 반응 신호가 부족하면 쇼핑 리워드(유입·찜)를 함께 검토합니다. 구매·구매평 작성은 제공하지 않으며 순위를 보장하지 않습니다.'],
```

## B3. 새 인사이트 글 5편 — `KeywordInsightSeeder`
- 원고: `docs/content/articles/kw01/manifest.json` + 같은 폴더 HTML 5개. `database/content/kw01/` 로 **그대로 복사**해 시더가 그 복사본을 읽게 한다(배포 서버에서 docs 에 기대지 않게).
- 슬러그 기준 upsert(여러 번 돌려도 1편씩). 필드: `title, slug, excerpt, content(HTML 원문), meta_title, meta_description, category_id(manifest 의 category_slug → insight_categories.slug), published_at = 2026-11-04 10:00:00 Asia/Seoul 고정, 공개 상태(모델의 공개 필드 규칙을 따른다), user_id = null`.
- 없는 카테고리 slug 면 예외로 멈춘다(조용히 다른 카테고리에 넣지 말 것).
- `DatabaseSeeder` 에 등록하지 말고 단독 실행(`php artisan db:seed --class=KeywordInsightSeeder`) — 운영 반영 때 봇에게 이 명령을 요청한다.

## B4. 칼럼 설명 33편 + 중복 글 정리 — 같은 시더(또는 `InsightMetaSeeder`)
1. `docs/content/insight-meta-2026-11-04.json`(33개 `{slug, meta_description}`)을 `database/content/kw01/insight-meta.json` 으로 복사하고, 슬러그가 일치하는 글의 `meta_description` 만 바꾼다. 다른 필드·본문은 건드리지 않는다. 없는 슬러그는 건너뛰고 개수를 출력.
2. `2019년-그로스해커에게-필요한-스킬3-1` 은 `…스킬3` 과 본문이 똑같은 중복이다(운영 본문 비교 유사도 0.999).
   - `…스킬3-1` 을 비공개로 바꾸고(삭제 금지·되돌릴 수 있게) `legacy_redirects` 에 `insights/2019년-그로스해커에게-필요한-스킬3-1` → `/insights/2019년-그로스해커에게-필요한-스킬3` 301 을 upsert.
   - 이미 `…스킬3-1` 을 목적지로 하는 다른 이전표 줄(`v1/manager/column/…스킬3-1` 등)은 목적지를 `…스킬3` 으로 바꿔 체인(301→301)을 없앤다.
   - 사이트맵·RSS 에서 `…스킬3-1` 이 빠져야 한다(비공개면 자동으로 빠지는지 테스트로 확인).
3. `config/seo.php` `pages` 에 `/self-marketing/shopping` 이 아직 없으면 추가(A2-4). 라우트는 Claude 가 `routes/pages.php` 에 `self-marketing.shopping` 으로 만들어 두었다.

## B5. 테스트
- B1·B2: `/naver-place-marketing/`·`/naver-shopping-marketing/` 렌더에 새 H1, 새 섹션 제목, 새 FAQ 질문, `/self-marketing/place`·`/self-marketing/shopping`·`/solutions/rankfree` 링크가 있다.
- B3: 시더 두 번 실행해도 5편, 각 글 200·canonical 자기 주소·제목·설명이 manifest 와 같음, 카테고리 매핑, 사이트맵 insights 묶음에 5편 포함.
- B4: 33편 설명 교체(샘플 3편 값 대조), `…스킬3-1` → 301 한 번에 `…스킬3`, 체인 없음, 사이트맵에 없음.
- `/self-marketing/shopping` 200 + 사이트맵 포함.
- 기존 테스트 전부 통과(기대값을 바꾼 곳은 B2-3 한 곳뿐이어야 한다 — 바꾼 테스트 줄을 보고에 그대로 적는다).

## 합격 게이트
`php artisan test` 전부 초록 · `./vendor/bin/pint --test`(바꾼 PHP) · `npm run build` · 금지 파일 diff 0.

## 반환물
바꾼 파일 목록 · `git diff --stat` · 실행 명령과 **실제 출력** · 바꾼 기존 테스트 기대값 목록 · 미검증 항목.
