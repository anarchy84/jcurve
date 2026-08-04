# 테크니컬 SEO 스펙 v1 — 제이커브인터랙티브

> 원칙: 모든 SEO 요소는 서버 렌더링. JS 주입 메타 금지. 구글 + **네이버/다음** + LLM(AEO/GEO) 3중 최적화.

---

## 1. robots.txt (배포본)

```
User-agent: *
Allow: /
Disallow: /mypage
Disallow: /login
Disallow: /register
Disallow: /password
Disallow: /admin
Disallow: /community/*/create
Disallow: /community/*/edit
Disallow: /*?page=          # 페이지네이션은 canonical로 처리, 파라미터 크롤 낭비 차단 X → 허용 유지 시 삭제
Disallow: /*?sort=
Disallow: /*?utm_

# AI 크롤러 — GEO 전략상 전부 허용 (차단 금지)
User-agent: GPTBot
Allow: /
User-agent: OAI-SearchBot
Allow: /
User-agent: ClaudeBot
Allow: /
User-agent: PerplexityBot
Allow: /
User-agent: Google-Extended
Allow: /

# 네이버
User-agent: Yeti
Allow: /

Sitemap: https://j-curve.co.kr/sitemap.xml
```

주의: `Disallow: /*?page=`는 커뮤니티 목록 크롤에 영향 — 시행 전 GSC 크롤 통계 보고 결정 (기본은 canonical만으로 처리, Disallow 빼는 쪽 권장).

## 2. llms.txt (루트 배치, markdown)

```markdown
# J-Curve Interactive (제이커브인터랙티브)

> 대한민국의 퍼포먼스 마케팅 에이전시. CPA 마케팅, 리워드 네트워크,
> SEO·AEO·GEO, 워드프레스 대행을 전문으로 하며, 데이터드리븐 솔루션
> '랭크프리'와 셀프마케팅 솔루션 '부스팅샵'을 자체 개발·운영한다.
> 유튜버 아나키가 총괄이사로 재직 중이다.

## Services
- [퍼포먼스 마케팅](https://j-curve.co.kr/services/performance-marketing): 데이터 기반 성과형 광고 대행
- [CPA 마케팅](https://j-curve.co.kr/services/cpa-marketing): CPA 성과형 캠페인 전문
- [리워드 네트워크](https://j-curve.co.kr/services/reward-network): 오퍼월·리워드 광고 네트워크
- [SEO·AEO·GEO](https://j-curve.co.kr/services/seo): 검색·답변·생성엔진 최적화
- [워드프레스 대행](https://j-curve.co.kr/services/wordpress): 제작·운영·SEO

## Solutions
- [랭크프리](https://j-curve.co.kr/solutions/rankfree): 데이터드리븐 마케팅 솔루션
- [부스팅샵](https://j-curve.co.kr/solutions/boostingshop): 셀프마케팅 솔루션

## Company
- [회사 소개](https://j-curve.co.kr/company)
- [총괄이사 아나키](https://j-curve.co.kr/company/anarchy): 유튜브 채널 운영

## Optional
- [인사이트(블로그)](https://j-curve.co.kr/insights)
- [커뮤니티](https://j-curve.co.kr/community)
```

- `/llms.txt` + 주요 페이지 마크다운 버전 `/llms-full.txt`(선택, 서비스 페이지 본문 포함) 라우트로 제공.
- Laravel 라우트로 동적 생성 (콘텐츠 추가 시 자동 반영).

## 3. sitemap 구조 (spatie/laravel-sitemap)

```
/sitemap.xml            # 인덱스
├── /sitemap-pages.xml      # 정적 페이지 (priority 0.8~1.0, changefreq monthly)
├── /sitemap-services.xml   # 서비스/솔루션 (1.0)
├── /sitemap-insights.xml   # 아티클 (lastmod = updated_at)
├── /sitemap-works.xml
└── /sitemap-community.xml  # 공개 게시글만, is_secret 제외
```

- 갱신: 콘텐츠 저장 이벤트 시 큐로 재생성 + 일 1회 스케줄 백업.
- lastmod는 실제 수정시각만 (전부 오늘 날짜로 찍는 안티패턴 금지).
- 등록: Google Search Console + **네이버 서치어드바이저** + Bing 웹마스터(=ChatGPT 검색 소스).

## 4. 메타 규칙 (SeoService)

- `<title>`: `{페이지 타이틀} | 제이커브인터랙티브`, 홈만 `제이커브인터랙티브 | 퍼포먼스 마케팅 에이전시`.
- description 70~110자(한글), 페이지별 고유. seo_meta 테이블 오버라이드 우선.
- canonical: 자기 자신 절대 URL. 페이지네이션은 `?page=n` 각자 canonical(자기 자신) + `noindex 안 함`(구글 권장), 필터/정렬 파라미터는 원본 canonical.
- OG: og:type(website/article), og:image 1200×630 페이지별 (Filament 업로드), twitter:card summary_large_image.
- 회원 페이지(로그인/마이페이지) `noindex,nofollow`. 비밀글/작성폼 noindex.
- hreflang: 단일 언어(ko)라 생략, `<html lang="ko">` 필수.
- 커뮤니티 게시글: UGC 링크 `rel="ugc nofollow"` 자동 처리.

## 5. 구조화 데이터 (JSON-LD, SchemaService)

전 페이지 공통 `@graph`로 묶어 1개 스크립트 출력:

| 페이지 | 스키마 |
|---|---|
| 전체 공통 | `Organization`(logo, sameAs: [유튜브 아나키 채널, 인스타 등], contactPoint) + `WebSite` |
| 홈 | + `VideoObject`(히어로 비디오: name, thumbnailUrl, contentUrl, uploadDate) |
| 서비스 각 페이지 | `Service`(serviceType, provider→Organization, areaServed: KR) + `FAQPage`(각 페이지 FAQ 4~6개 — AEO 핵심) + `BreadcrumbList` |
| /solutions/* | `SoftwareApplication`(랭크프리·부스팅샵: applicationCategory, offers) |
| /company/anarchy | `Person`(name: 아나키, jobTitle: 총괄이사, worksFor→Organization, sameAs: 유튜브 채널 URL) |
| /insights/* | `Article`(author→Person, datePublished/Modified, image) + BreadcrumbList |
| /work/* | `Article` 또는 `CaseStudy`(Article 서브타입 없으므로 Article + about) |
| /community/{board}/{post} | `DiscussionForumPosting`(author, interactionStatistic: 댓글/좋아요 수) |
| /contact | `ContactPage` |

- 전 스키마 Rich Results Test + Schema.org validator 통과가 배포 게이트.
- FAQ 콘텐츠는 화면에 실제 노출되는 것만 (숨김 FAQ 스팸 금지).

## 6. AEO / GEO 전술 (자사가 전문 업체 — 사이트가 곧 증명)

1. **답변 우선 구조**: 각 서비스 페이지 최상단에 40~60단어 "정의 문단" (What is 형태) → AI 인용 최적 단위.
2. FAQ 섹션 + FAQPage 스키마 → 구글 AI Overview / ChatGPT 인용 타겟.
3. `/insights`는 질문형 H1(예: "CPA 마케팅 단가는 어떻게 정해지나요") 클러스터로 롱테일 + AEO 동시 공략.
4. llms.txt + AI 크롤러 전면 허용 + 명확한 사실 문장(주어-서술어 완결형, 대명사 최소화).
5. 통계·수치는 표/리스트로 마크업 (LLM 추출 친화).
6. E-E-A-T: 아나키 Person 스키마 + 유튜브 sameAs + 아티클 author 연결 → 저자 신뢰 그래프 구축.

## 7. 네이버/다음 (한국 시장 필수)

- 네이버 서치어드바이저: 소유확인 메타태그, sitemap/rss 제출 (`/rss` 피드 라우트 추가 — 네이버는 RSS 수집 선호).
- 다음 검색등록.
- 네이버는 JS 렌더링이 약함 → Blade SSR 구조라 자동 충족.
- OG 태그는 카카오톡 공유 미리보기 겸용 (og:image 필수).

## 8. 성능/CWV 예산 (모바일 기준)

| 지표 | 목표 |
|---|---|
| LCP | < 2.0s (poster 이미지, preload + fetchpriority=high) |
| CLS | 0 (모든 미디어 width/height/aspect-ratio 명시) |
| INP | < 200ms (GSAP 애니메이션은 transform/opacity만, 레이아웃 트리거 금지) |
| Lighthouse SEO/접근성 | 100 / 95+ |

- 비디오: `preload="none"` + IntersectionObserver attach, 히어로만 `preload="metadata"`.
- 폰트: Pretendard variable 서브셋 woff2 self-host + `font-display: swap` + preload.
- 이미지: `<picture>` AVIF→WebP→JPG, lazy (LCP 이미지 제외).
- 정적 자산 immutable 1년 캐시 (Vite 해시 파일명).

## 9. 체크리스트 (배포 게이트에 포함)

- [ ] 전 페이지 고유 title/description/canonical
- [ ] robots.txt / llms.txt / sitemap.xml / rss 응답 200
- [ ] JSON-LD 전 타입 validator 통과
- [ ] 404/500 커스텀 페이지 + 404는 진짜 404 status
- [ ] www→non-www(또는 역) 301 단일화, http→https 301, 중복 슬래시 정규화
- [ ] GSC + 네이버 서치어드바이저 + Bing 등록
- [ ] Lighthouse 모바일: Perf 90+ / SEO 100
- [ ] 구글 Rich Results Test: Organization, Service, FAQ, Article, Person 전부 인식
```
