# 제이커브인터랙티브 (J-Curve Interactive) — 전체 기획서 v1

> 작성: 2026-08-04 / 담당: Claude(설계·검증) · 구현 주력: Codex · 디자인: 클로드디자인 + 힉스필드(비주얼 에셋)

---

## 1. 프로젝트 개요

- **사이트명**: 제이커브인터렉티브 (J-Curve Interactive) — 공식 법인명 (주)제이커브인터렉티브 기준 표기
- **도메인**: https://j-curve.co.kr (확정)
- **회사 정보(확정)**: 대표이사 김태훈 / 사업자등록번호 753-88-01488 / 서울 금천구 가산디지털1로 가산더블유센터 703호 / 02-1668-2612 / jcurve19@gmail.com
- **아나키 유튜브**: https://www.youtube.com/@아나키 (구독자 5.06만, 동영상 248개, 누적 조회 239만+, 2011-11-15 개설)
- **성격**: 종합 퍼포먼스 마케팅 에이전시 공식 사이트 + 커뮤니티(회원제 게시판)
- **핵심 차별점**:
  1. 스크롤 연동 비디오 줌 인/아웃 비주얼 (Awwwards급 모션)
  2. 테크니컬 SEO "구글 엔지니어보다 완벽하게" — SEO/AEO/GEO 전문사 사이트가 곧 포트폴리오
- **필수 포함 사업 영역** (누락 금지):
  1. 마케팅 에이전시 (광고대행)
  2. CPA 마케팅 전문
  3. 리워드 네트워크사 (버즈빌/애드팝콘/NBT 동종 카테고리)
  4. 퍼포먼스 마케팅 전문
  5. 데이터드리븐 솔루션 자체 개발·운영 — **랭크프리(RankFree)**
  6. 유튜버 **아나키** 총괄이사 — 유튜브 채널 연결
  7. 셀프마케팅 솔루션 개발·운영 — **부스팅샵**
  8. SEO · AEO · GEO 전문
  9. 워드프레스 대행 전문
- **호스팅**: 카페24 (PHP + MySQL/MariaDB)

---

## 2. 기술 스택 & 아키텍처 결정

| 레이어 | 선택 | 이유 |
|---|---|---|
| 프레임워크 | **Laravel 11.x** (LTS 성격, PHP 8.2+) | 카페24 PHP 8.2 지원 범위 내에서 최신 안정 |
| 템플릿 | **Blade SSR** (SPA 금지) | SEO가 최우선. 모든 HTML이 서버에서 완성돼 나가야 크롤러/LLM봇이 100% 읽음 |
| 인터랙션 | **Alpine.js + GSAP(ScrollTrigger) + Lenis** | 비디오 줌 스크롤 연출은 GSAP ScrollTrigger scrub이 표준. React 불필요 |
| CSS | **Tailwind CSS** + design-system.md 토큰 | 빌드는 Vite, 산출물만 서버 업로드 |
| DB | MySQL (카페24 제공) | |
| 인증 | **Laravel Breeze(Blade)** + Socialite(카카오/네이버/구글) | 커뮤니티 회원가입. 한국 시장이라 카카오/네이버 소셜 로그인 필수 |
| 관리자 | **Filament 3** | 게시판·문의·SEO 메타 관리를 코드 최소로 |
| 이미지/비디오 | WebP/AVIF + MP4(H.264)/WebM(VP9), poster 이미지 | CWV 방어 |

**아키텍처 원칙**
- SEO 관련 요소(메타, 스키마, canonical, sitemap)는 전부 **서버 렌더링**. JS로 주입하는 메타 절대 금지.
- 페이지 = "정적 콘텐츠 + 모션 레이어" 구조. JS 꺼도 콘텐츠·링크 전부 접근 가능 (Progressive Enhancement).
- 커뮤니티(동적)와 마케팅 페이지(준정적)를 같은 앱 안에 두되, 마케팅 페이지는 full-page cache로 응답속도 확보 (카페24 사양이 낮아도 버티게).

---

## 3. URL / 디렉토리 구조 (SEO 정보구조)

원칙: **1 URL = 1 타겟 키워드 클러스터**, 디렉토리 깊이 최대 3, 전부 소문자-하이픈, trailing slash 없음.

```
/                                   # 홈 — 종합 브랜드 + 비디오 히어로
├── /services                       # 서비스 허브 (필러 페이지)
│   ├── /services/performance-marketing   # 퍼포먼스 마케팅 대행
│   ├── /services/cpa-marketing           # CPA 마케팅
│   ├── /services/reward-network          # 리워드 네트워크 (버즈빌·애드팝콘·NBT 카테고리)
│   ├── /services/seo                     # SEO·AEO·GEO 전문 (허브)
│   │   ├── /services/seo/aeo             # AEO (답변엔진 최적화)
│   │   └── /services/seo/geo             # GEO (생성엔진 최적화)
│   └── /services/wordpress               # 워드프레스 제작·운영 대행
├── /solutions                      # 자체 솔루션 허브
│   ├── /solutions/rankfree               # 랭크프리 — 데이터드리븐 솔루션
│   └── /solutions/boostingshop           # 부스팅샵 — 셀프마케팅 솔루션
├── /company                        # 회사소개 (연혁·미션)
│   └── /company/anarchy                  # 총괄이사 아나키 — 유튜브 채널 연동 페이지
├── /work                           # 포트폴리오/케이스스터디 목록
│   └── /work/{slug}                      # 개별 사례 (성과 수치 중심)
├── /insights                       # 블로그/칼럼 (SEO 콘텐츠 엔진)
│   ├── /insights/{slug}                  # 개별 아티클
│   └── /insights/category/{slug}         # 카테고리
├── /community                      # 커뮤니티 허브
│   ├── /community/{board}                # 게시판 (free, qna, tips, notice)
│   └── /community/{board}/{id}-{slug}    # 게시글 (id+슬러그로 URL 안정성+키워드)
├── /contact                        # 문의 (리드 폼)
├── /login /register /mypage        # 회원 (noindex)
└── /sitemap.xml /robots.txt /llms.txt
```

> **⚠️ §3 최종 확정 (2026-08-04 v2)** — 서버 담당 지시로 **기존 문서는 전부 301 리다이렉트** 정책 확정. 위 클린 URL 구조(원안)를 그대로 사용하고, 기존 워드프레스·구버전(/v1/) URL 전체는 docs/URL-MIGRATION.md v2의 매핑대로 301 처리한다. 리다이렉트 도착지로 서브페이지 다수 추가됨 (URL-MIGRATION.md §C 참고: /services/seo/* 5종, /services/cpa-marketing/* 5종, /services/performance-marketing/* 3종, /solutions/boostingshop/* 6종, /services/marketing-support, /privacy).

**내부링크 설계 (토픽 클러스터)**
- `/services/*` 각 페이지 하단 → 관련 `/insights` 아티클 3개 + 관련 `/work` 사례 → 허브로 역링크.
- `/insights` 아티클 본문 → 해당 서비스 페이지로 contextual link (앵커텍스트 = 타겟 키워드).
- 홈 → 9개 사업영역 전부 1클릭 도달 (크롤 뎁스 보장).
- Breadcrumb 전 페이지 적용 (+ BreadcrumbList 스키마).

---

## 4. 페이지별 타겟 키워드 맵

| URL | 주 키워드 | 보조 키워드 |
|---|---|---|
| / | 퍼포먼스 마케팅 에이전시 | 종합 광고대행사, 제이커브인터랙티브 |
| /services/performance-marketing | 퍼포먼스 마케팅 대행 | 데이터드리븐 마케팅, 그로스 마케팅 |
| /services/cpa-marketing | CPA 마케팅 | CPA 광고, 성과형 광고 대행 |
| /services/reward-network | 리워드 광고 | 리워드 네트워크, 오퍼월 광고, 앱 리워드 마케팅 |
| /services/seo | SEO 대행 | 검색엔진최적화 업체, 테크니컬 SEO |
| /services/seo/aeo | AEO | 답변엔진 최적화, AI 검색 최적화 |
| /services/seo/geo | GEO 최적화 | 생성형 AI 검색 노출, ChatGPT 노출 |
| /services/wordpress | 워드프레스 제작 대행 | 워드프레스 유지보수, 워드프레스 SEO |
| /solutions/rankfree | 랭크프리 | 순위 추적 솔루션, 데이터드리븐 SEO 툴 |
| /solutions/boostingshop | 부스팅샵 | 셀프마케팅, 셀프 광고 솔루션 |
| /company/anarchy | 유튜버 아나키 | 아나키 마케팅, 아나키 유튜브 |
| /community | 마케팅 커뮤니티 | 마케터 커뮤니티, 광고 커뮤니티 |

- 경쟁사명(버즈빌/애드팝콘/NBT)은 **meta·title에 넣지 않고** `/insights` 비교 아티클("리워드 네트워크 비교")에서만 본문 언급 — 상표 리스크 회피 + 롱테일 흡수.
- 타이틀 포맷: `{주 키워드} | 제이커브인터랙티브` (60자/한글 30자 내).

---

## 5. DB 스키마 (커뮤니티 + 회원 + 콘텐츠)

```
users            id, name, nickname(unique), email(unique), password, avatar,
                 provider(kakao|naver|google|null), provider_id, role(admin|member),
                 email_verified_at, last_login_at, timestamps, softDeletes
boards           id, slug(unique), name, description, is_anonymous(bool),
                 write_permission(guest|member|admin), order
posts            id, board_id(FK), user_id(FK), title, slug, content(markdown),
                 view_count, like_count, comment_count(denormalized),
                 is_notice, is_secret, published_at, timestamps, softDeletes
comments         id, post_id(FK), user_id(FK), parent_id(self FK, 대댓글 1depth),
                 content, timestamps, softDeletes
post_likes       id, post_id, user_id (unique[post_id,user_id])
attachments      id, attachable(morph), path, mime, size
insights         id, user_id, category_id, title, slug(unique), excerpt,
                 content, cover_image, meta_title, meta_description,
                 published_at, timestamps          # 블로그는 게시판과 분리 (SEO 필드 전용)
insight_categories  id, name, slug
works            id, title, slug, client, industry, summary, content,
                 metrics(json), cover_image, published_at
leads            id, name, company, phone, email, service_interest, message,
                 utm(json), status, timestamps      # /contact 폼
seo_meta         id, path(unique), meta_title, meta_description, og_image,
                 canonical, robots                  # 페이지별 오버라이드 (Filament에서 관리)
```

- 인덱스: posts(board_id, published_at), insights(published_at), 검색용 FULLTEXT(title, content).
- 댓글수/좋아요수는 비정규화 컬럼 + 이벤트로 동기화 (목록 쿼리 N+1 방지).

---

## 6. Laravel 앱 구조

```
app/
├── Http/Controllers/
│   ├── PageController          # 홈·서비스·솔루션·회사 (준정적, 캐시)
│   ├── InsightController
│   ├── WorkController
│   ├── Community/{BoardController, PostController, CommentController, LikeController}
│   ├── ContactController
│   └── Auth/*                  # Breeze + SocialiteController
├── Models/                     # 위 스키마 대응
├── Services/
│   ├── SeoService              # 메타/OG/canonical 조립 (seo_meta 오버라이드 반영)
│   ├── SchemaService           # JSON-LD 생성 (페이지 타입별)
│   └── SitemapService          # spatie/laravel-sitemap 래핑, 스케줄 갱신
├── View/Components/
│   ├── Seo/Meta, Seo/JsonLd, Breadcrumb
│   └── Motion/VideoHero, Motion/ScrollSection   # GSAP 연동 Blade 컴포넌트
resources/views/
├── layouts/{app, community, admin}
├── pages/, services/, solutions/, insights/, work/, community/
routes/web.php                  # 전 라우트 named route, 커뮤니티는 auth 미들웨어
```

주요 패키지: `spatie/laravel-sitemap`, `laravel/socialite`, `filament/filament`, `spatie/laravel-honeypot`(스팸), `intervention/image`.

---

## 7. 비주얼/모션 스펙 (비디오 줌 연출)

- **홈 히어로**: 풀스크린 `<video>` (muted, autoplay, loop, playsinline) → 스크롤 시 GSAP ScrollTrigger `scrub`으로 scale 1.0 → 0.62 축소되며 라운드 프레임 안으로 들어가고, 다음 섹션 진입 시 다시 확대되는 "zoom in/out" 시퀀스.
- 섹션별 서브 비디오(서비스 9개 영역 카드)도 뷰포트 진입 시 scale/clip-path 트랜지션.
- **에셋 파이프라인**: 힉스필드로 브랜드 비디오/모션 에셋 생성 → WebM(VP9)+MP4(H.264) 2벌 인코딩, 히어로는 6초 내외 루프·1080p·비트레이트 3Mbps 이하, `poster` WebP 필수.
- **CWV 방어선**: LCP는 poster 이미지로 잡음(비디오 lazy attach), CLS 0 (모든 미디어 aspect-ratio 예약), 모바일/저사양·`prefers-reduced-motion`은 정지 이미지 폴백.
- 디자인 토큰·컴포넌트는 `design-system.md`로 확정 후 구현 (클로드디자인 번들 수신 시 토큰 우선순위 규칙 적용).

---

## 8. 카페24 배포 전략

카페24 상품 유형에 따라 두 트랙 (현재 어떤 상품인지 확인 필요):

**트랙 A — 일반 웹호스팅 (SSH 제한/도큐먼트루트 고정 `/www`)**
1. 로컬(또는 GitHub Actions)에서 `composer install --no-dev` + `npm run build` 완료된 아티팩트 생성.
2. Laravel `public/` 내용물을 `/www`에, 앱 본체는 `/www` 상위(예: `/laravel`)에 배치, `index.php`의 부트스트랩 경로 수정.
3. `.env`는 FTP로 직접 관리, 캐시는 `php artisan config:cache` 결과물 포함 업로드.
4. cron(사이트맵 갱신 등)은 카페24 예약작업 또는 외부 cron으로 URL 히트.

**트랙 B — 카페24 가상서버(VPS)/매니지드**: 표준 배포(git + composer + nginx root=public). **권장**. 트래픽·커뮤니티 성장 고려하면 이쪽으로 이전 추천.

공통: PHP 8.2 이상 확인, OPcache 활성, HTTP/2 + gzip/brotli, 정적 자산 장기 캐시 헤더.

---

## 9. 로드맵 & 역할 분담

| 단계 | 내용 | 담당 |
|---|---|---|
| 0 | 기획·아키텍처·SEO 스펙 (본 문서) | Claude ✅ |
| 1 | design-system.md 확정 + 힉스필드 비주얼 에셋 | 클로드디자인 + 힉스필드, Claude 검수 |
| 2 | Laravel 스캐폴딩·마이그레이션·Breeze·라우트 | Codex (스펙: 본 문서 5·6장) |
| 3 | SEO 인프라 (SeoService/SchemaService/sitemap/robots/llms.txt) | **Claude 직접** (핵심 통합부) |
| 4 | 마케팅 페이지 마크업 + GSAP 모션 | Codex(마크업 물량) + Claude(모션 핵심) |
| 5 | 커뮤니티 (게시판 CRUD·댓글·좋아요·Filament) | Codex, Claude 검증 |
| 6 | 인증·소셜로그인·권한 | **Claude 직접** (보안 예외 항목) |
| 7 | 콘텐츠 주입 (서비스 카피·insights 초기 10편) | Claude 주도 작성 |
| 8 | 성능·CWV 튜닝 + 검증 게이트 + 카페24 배포 | Claude |

검증 게이트: 빌드·타입(larastan lv8)·핀트(pint)·테스트(Pest) 그린 + Lighthouse 모바일 95+ + 스키마 validator 통과.
