# 현 운영 사이트 실사 — j-curve.co.kr (2026-10-27)

> 수집 방법: 공개 페이지, 사이트맵, robots.txt, 구글 `site:` 검색, 대웅 맥북에서 curl 확인.
> 도메인 점수(DR)·백링크·오가닉 트래픽은 확보하지 못했다. Ahrefs는 현 플랜에서 미지원이고, Semrush는 API 유닛이 부족하다. 서치콘솔 데이터는 보류 중이다.

## 1. 본체 (워드프레스)

| 항목 | 관측 |
|---|---|
| 엔진 | WordPress 6.7.4 + Avada 테마 + WooCommerce + Jetpack + Rank Math |
| 홈 title | 구글 네이버 SEO 업체 \| 검색엔진 최적화 전문 \| 제이커브 |
| 홈 description | 10년+ 경력과 1,000개 이상 프로젝트를 경험한 SEO 전문가가 제공하는 맞춤형 검색엔진최적화 서비스 |
| GNB | SEO(구글·네이버 쇼핑·네이버 플레이스·쿠팡·카카오 선물하기) / 백링크 / Web / Shop / Blog / 문의 |
| 블로그 글 | `/seo/{한글슬러그}/` 3편 (2025-01-14~20) |
| 마지막 수정 | 2025-05-27 (page-sitemap 기준) |
| 구조화데이터 | 확인 안 됨 |
| 외부 링크 | 푸터에서 shopitrend.co 를 셀프마케팅 플랫폼으로 소개 |

## 2. 사이트맵 (2중 운영)

- robots.txt에 3개가 선언돼 있다: `/sitemap.xml`, `/news-sitemap.xml`, `/sitemap_index.xml`.
- **Rank Math** (`sitemap_index.xml`)
  - post 3, page 18, product, avada_portfolio 13, category 2
- **Jetpack** (`sitemap.xml`)
  - `sitemap-1.xml` 24개 URL. Rank Math와 중복이고 새 고유 URL은 없다.
  - `image-sitemap-1.xml`
  - `video-sitemap-1.xml` (lastmod 2017-03-31)
- 리뉴얼 때 하나로 통일해야 한다.

## 3. 품질을 깎는 페이지 (사이트맵에 올라가 있음)

- Avada 데모 포트폴리오 13개: 라틴어 더미. 예: `/portfolio-items/cras-mollis-nons/`, `/portfolio-items/faucibus-tellus/`. lastmod 2014~2025.
- 2015년 데모 계정 페이지: `/log-in/`, `/join/`, `/recover-password/`
- WooCommerce 시스템 페이지: `/cart/`, `/checkout/`, `/my-account/`

## 4. 레거시 /v1/ (그누보드, 사이트맵 밖 고립 상태지만 구글 색인 중)

- 구글 색인 확인: `/v1/gfa.php`, `/v1/youtube.php`, `/v1/contact.php`
- 페이지 제목: "NO.1 퍼포먼스마케팅 에이전시"
- 메뉴
  - 퍼포먼스: 부동산·주식·퍼미션콜·보험·코인 DB, CPA
  - 상품: 네이버 GFA, 페이스북, 유튜브 영상 편집, 중소기업지원사업
  - 인스타그램: 인기게시물·팔로워·좋아요
  - 솔루션: 스마트엠디, 스마트스토어 최적화
- 칼럼 게시판 `/v1/manager/bbs/board.php?bo_table=column`
  - 4페이지, 약 50편. 최신 2022-12-21 (wr_id 57)
  - 카테고리: 퍼포먼스마케팅·페이스북·인스타그램·구글·브랜딩·콘텐츠마케팅
- 실적 표기: 진행 캠페인 15,700+, 포트폴리오 235, 고객사 로고 19곳 (넷플릭스·LGU+·야놀자·현대해상 등)
- 외부 링크: myinfluencer.co.kr, goodmarketing.co.kr, leadbay.co.kr, call2.sale, crmpro.co.kr
- ⚠️ **회사 정보 불일치(NAP)**

  | 항목 | /v1/ 표기 | 현행 |
  |---|---|---|
  | 주소 | 마포구 잔다리로66 누보빌딩 4층 | 금천구 가산디지털1로 가산더블유센터 703호 |
  | 이메일 | jxamen@j-curve.co.kr | jcurve19@gmail.com |

  이관하면서 현행으로 통일해야 한다. 업체 정보가 일관돼야 검색·AI가 같은 회사로 인식한다.

## 5. 리스크 카피

- `/naver-shopping-marketing/`, `/coupang/` 제목에 "상위노출" 판매 문구가 있다.
- 네이버는 2025-06-26 이용정책에서 리워드 앱 등으로 검색 결과를 변동시키는 행위를 금지행위로 명시했다 (`RESEARCH-REA-2026-10-27.md` B-3 참고).

## 6. 스테이징 dev.j-curve.co.kr

- 2026-10-27 대웅 맥북에서 curl로 확인한 결과
  - `/`, `/services/reward-network` 모두 **HTTP 200**
  - `X-Robots-Tag` 없음, 인증(`WWW-Authenticate`) 없음
- robots.txt는 전체 허용이고 Sitemap 선언이 없다.
- 저장소 레이아웃에서 robots 메타(noindex)를 확인하지 못했다.
- 구글 `site:dev.j-curve.co.kr` 결과는 없다 (2026-10-27 기준).
- → **누구나 접속할 수 있고 색인될 수 있는 상태.** 런칭 전 noindex 헤더 + 기본 인증이 필요하다. 서버 작업이므로 대웅 승인이 필요하다.
- 참고: 다른 세션 기록(`docs/frontend/11_…`)에는 비로그인 접속이 403으로 나와 있다. 접속 환경에 따라 다르게 응답하는 것으로 보이고, 위 curl 결과가 실제 공개 상태다.

## 7. 자체 솔루션 사이트 확인

| 사이트 | 내용 | 운영 표기 |
|---|---|---|
| leadbay.co.kr | 보험DB 업체를 품질 점수·납품 속도·AS로 비교해 구매 + 상담·계약·AS·정산 관리 CRM | meta author (주)제이커브인터렉티브 |
| call2.sale | 보험DB를 생산·납품하는 콜센터용 세일즈 CRM | meta author (주)제이커브인터렉티브 |
| apps.j-curve.co.kr | 제이커브 앱스: 앱 목록·스토어 링크 공개 | HTTP 200 (내용은 `11_` 문서 2-3 참고) |
| crmpro.co.kr, shopitrend.co | 수집 실패 (robots 차단 / 클라이언트 에러) | 확인 필요 |

## 8. 아직 없는 데이터 (런칭 전 필요)

- 구글 서치콘솔 16개월 페이지·검색어 실적 → 클릭 상위 URL 보호 목록
- 백링크 상위 URL
- 네이버 서치어드바이저 수집 현황
