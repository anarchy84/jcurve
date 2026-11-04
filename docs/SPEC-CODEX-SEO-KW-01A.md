# SPEC-CODEX-SEO-KW-01A — 기술 SEO 보강 (구현 지시서)

- 작업 ID: SEO-KW-01A · 작성: Claude 2026-11-04 · 기준 커밋: `70ccde4` (main)
- 필독: `docs/COLLAB.md`(파일 구역), `docs/PLAN-FINAL.md`(U1 URL 보존), `config/seo.php`, `app/Services/Seo/Publishing/*`
- 배경: 2026-11-04 15:25 운영 전환 뒤 점검. 주소·제목은 보존됐지만 기술 SEO 일부가 비어 있음. 목표 키워드(네이버 플레이스·쇼핑 상위노출, 플레이스·쇼핑 순위, 플레이스 리워드, 리워드 광고, 오퍼월) 상위노출 작업의 기반 공사.

## 소유 파일 (이 안에서만 수정)
`routes/web.php`, `app/**`, `config/seo.php`, `public/robots.txt`, `tests/**`

## 금지 파일
`resources/views/**`(Claude 구역 — 단, 읽기는 가능), `config/subpages.php`(다음 작업 B), `routes/pages.php`, `.env`, `public/media/**`, `database/content/**`. git 커밋·푸시·브랜치·stash·reset·checkout 금지.

## 할 일

### A1. 칼럼 본문 이미지 주소 살리기
- 옛 칼럼 본문 22편이 `http(s)://j-curve.co.kr/manager/data/editor/...` 로 이미지를 부른다. 실제 파일은 `/v1/manager/data/editor/...` 에 있다(운영에서 84개 전부 확인).
- `GET /manager/data/{path}` (하위 경로 전부, `where('path','.*')`) → **301** `/v1/manager/data/{path}` (쿼리 그대로). 경로 문자를 바꾸지 말 것.

### A2. 사이트맵 정리 (`FeedCatalog`·`SeoFeedController`)
1. 주소가 0개인 묶음(지금 `works`)은 사이트맵 목록(`/sitemap.xml`)에 넣지 않는다. 묶음 주소(`/sitemaps/works/1.xml`) 자체는 지금처럼 200 유지.
2. 공개 글이 1편 이상인 **모든** 인사이트 카테고리(`/insights/category/{slug}`)를 넣는다. 지금은 일부만 들어가고 9개(branding, content-marketing, cpa, facebook, google-ads, instagram, reward, wordpress, youtube)가 빠져 있다. 주소 생성은 기존처럼 `$this->urls->absolute()` — 원주소 매핑(`/insights/category/seo` → `/blog/seo/`)이 그대로 적용돼야 한다.
3. 인사이트 글에 `cover_image` 가 있으면 사이트맵 항목에 이미지(`<image:image><image:loc>`)를 붙인다(spatie/laravel-sitemap `addImage`). 이미지 주소는 절대 주소.
4. `config/seo.php` `pages` 에 `/self-marketing/shopping` 을 추가한다(Claude 가 같은 배포에 이 화면을 만든다 — `routes/pages.php` 의 `self-marketing.shopping`). 라우트가 아직 없으면 테스트가 깨지니 존재를 확인한 뒤 넣고, 없으면 미검증 항목으로 보고.

### A3. `/llms.txt`
- `GET /llms.txt` → `view('seo.llms')` 를 `Content-Type: text/plain; charset=UTF-8` 로 200 응답. 뷰는 Claude 가 이미 만들었다(`resources/views/seo/llms.blade.php`). 뷰 내용은 고치지 말 것.
- HEAD 요청도 200. 캐시 헤더는 다른 피드(rss)와 같은 정책.

### A4. `public/robots.txt`
지금 내용(전체 허용 + Sitemap)을 유지하고 아래만 더한다. **Disallow 를 새로 넣지 않는다**(로그인류는 화면에서 noindex 로 처리 — 크롤링을 막으면 noindex 를 못 읽는다).
```
User-agent: *
Disallow:

# 검색·AI 크롤러 — 전부 허용 (명시)
User-agent: Googlebot
User-agent: Yeti
User-agent: Daumoa
User-agent: Bingbot
User-agent: GPTBot
User-agent: OAI-SearchBot
User-agent: ChatGPT-User
User-agent: ClaudeBot
User-agent: Claude-SearchBot
User-agent: PerplexityBot
User-agent: Google-Extended
Allow: /

Sitemap: https://j-curve.co.kr/sitemap.xml
# llms: https://j-curve.co.kr/llms.txt
```

### A5. 테스트
- 새 테스트: A1(301·쿼리 보존·한글/특수문자 경로), A2(빈 묶음 제외·카테고리 9개 포함·원주소 매핑·이미지 태그), A3(200·content-type·`/naver-place-marketing/` 와 `/services/reward-network` 링크 포함), A4(파일에 `Disallow: /` 줄 없음·Sitemap 줄 있음).
- 기존 테스트 183개 전부 통과 유지.

## 합격 게이트
`php artisan test` 전부 초록 · `./vendor/bin/pint --test` (바꾼 PHP 파일) 통과 · `npm run build` 성공 · 금지 파일 diff 0.

## 반환물
바꾼 파일 목록 · `git diff --stat` · 실행한 명령과 **실제 출력**(테스트 요약 줄 포함) · 미검증 항목.
