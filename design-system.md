# 제이커브인터렉티브 디자인 시스템 v2 — Apple Editorial

> 모든 UI는 이 토큰을 기준으로 한다. 신규 패턴은 사용자 승인 후 여기 반영.
> v1(Dark Neon)에서 2026-08-04 전면 전환. 출처 레퍼런스: apple.com DESIGN.md (getdesign.md/apple).

## 컨셉
사진·영상이 주인공인 **미술관 갤러리형** 인터페이스. 화이트/파치먼트 캔버스와
니어블랙 타일이 풀블리드로 교차하며, **색 전환 자체가 섹션 구분선**이 된다.
UI 크롬은 뒤로 물러나 콘텐츠가 말하게 한다 — 장식 그라디언트 없음, 크롬에 그림자 없음.
인터랙션 컬러는 **액션 블루(#0066cc) 단 하나**. 메인 히어로는 풀사이즈 동영상(검정 배경)이 기본.

## 컬러 토큰
### 브랜드·액션 (인터랙션 컬러는 이 블루 하나뿐)
| 토큰 | 값 | 용도 |
|---|---|---|
| `--primary` | #0066cc | 모든 인터랙티브 요소(링크·CTA·포커스 루트) |
| `--primary-focus` | #0071e3 | 키보드 포커스 링(outline 2px) |
| `--primary-on-dark` | #2997ff | 다크 타일 위 인라인 링크(라이트 블루) |

### 표면
| 토큰 | 값 | 용도 |
|---|---|---|
| `--canvas` | #ffffff | 기본 캔버스(라이트 타일·카드) |
| `--parchment` | #f5f5f7 | 시그니처 오프화이트(교차 라이트 타일·푸터·서브내비) |
| `--pearl` | #fafafc | 고스트 버튼 채움(파치먼트 위에서도 버튼으로 읽히게) |
| `--tile-1` | #272729 | 홈 다크 타일 기본 |
| `--tile-2` | #2a2a2c | 다크 타일 연속 시 미세 분리(밝은 쪽) |
| `--tile-3` | #252527 | 스택 하단·비디오 프레임(어두운 쪽) |
| `--black` | #000000 | 진짜 검정 — 글로벌 내비·풀사이즈 비디오 배경 |

### 텍스트
| 토큰 | 값 | 용도 |
|---|---|---|
| `--ink` | #1d1d1f | 라이트 표면 위 헤드라인·본문(순검정 대신 사진처럼) |
| `--on-dark` | #ffffff | 다크 타일·내비 위 텍스트 |
| `--text-muted` | #86868b | 라이트 표면 보조 텍스트(애플 실측값) |
| `--muted-on-dark` | #a1a1a6 | 다크 타일 위 보조 텍스트 |
| `--ink-48` | #6e6e73 | 비활성 텍스트·법적 fine print |

### 헤어라인
| 토큰 | 값 | 용도 |
|---|---|---|
| `--hairline` | #d2d2d7 | 유틸 카드·칩 1px 보더 |
| `--divider-soft` | rgba(0,0,0,.04) | 세컨더리 버튼의 소프트 링 |

> **그라디언트 토큰 없음.** 분위기는 사진·영상에서 나온다. CSS 장식 그라디언트 금지.

## 타이포
- 디스플레이/본문 모두 SF Pro 스택: `system-ui, -apple-system, "SF Pro Display", "SF Pro Text", sans-serif`
  → 맥·iOS·사파리에서 실제 SF Pro 렌더. 논애플 폴백은 시스템 산세리프.
- **국문**: `Pretendard Variable` — SF Pro와 결이 가장 가까운 국문 폰트(애플 SD 산돌고딕네오 대체). 본문·헤드라인 공용.
- **Space Grotesk / 네온 그라디언트 텍스트는 v2에서 완전 제거.**
- 폰트 스택 변수: `--font: 'Pretendard Variable', system-ui, -apple-system, "SF Pro Display", "SF Pro Text", sans-serif;`

### 스케일 (애플 "타이트" 트래킹)
| 토큰 | size / weight / line-height / letter-spacing | 용도 |
|---|---|---|
| hero-display | 56 / 600 / 1.07 / -0.28px | 히어로 헤드라인 (모바일 34→28) |
| display-lg | 40 / 600 / 1.10 / 0 | 타일 헤드라인 |
| display-md | 34 / 600 / 1.47 / -0.374px | 섹션 헤드 |
| lead | 28 / 400 / 1.14 / +0.196px | 타일 서브카피 |
| tagline | 21 / 600 / 1.19 / +0.231px | 서브타일 태그라인·서브내비 카테고리 |
| body-strong | 17 / 600 / 1.24 / -0.374px | 인라인 강조 |
| body | 17 / 400 / 1.47 / -0.374px | 기본 본문(16 아님 — 17px 리딩 페이스) |
| caption | 14 / 400 / 1.43 / -0.224px | 보조 캡션·버튼 |
| nav-link | 12 / 400 / 1.0 / -0.12px | 글로벌 내비 항목 |

- **원칙**: 웨이트 사다리는 300 / 400 / 600 / 700 — **500은 의도적으로 부재**. 본문 400, 강조 600, 헤드라인 600.
  17px 이상엔 음수 자간(-0.12~-0.374). 12px 이하엔 자간 조이지 않음. 본문 line-height 1.47 밑으로 내리지 않음.

## 스페이싱·라운드
- 간격 스케일(8px 베이스): 4·8·12·17·24·32·48·80(섹션) px
- 섹션 세로 패딩: 80px(타일 내부). 타일은 gap 0으로 풀블리드 스택 — 색 전환이 구분선.
- radius: none 0(풀블리드 타일) · sm 8(유틸 버튼) · md 12(펄 캡슐) · lg 18(유틸 카드) · pill 9999(파란 CTA·검색·칩)
- 컨테이너: 텍스트 섹션 max 980px, 유틸 그리드 max 1440px, 제품/미디어 타일 풀블리드
- 라디우스 문법 혼용 금지: 컴팩트 유틸=sm, 카드=lg, 알약=pill.

## 모션
- **호버는 정의하지 않는다.** default·active(pressed) 상태만.
- active: 모든 버튼 `transform: scale(0.95)` (시스템 공통 마이크로 인터랙션)
- 강조가 필요하면 크롬 추가 대신 **표면 교차(라이트↔다크)** 를 먼저 쓴다.
- `prefers-reduced-motion` 시 모든 모션 제거, 정지 이미지/포스터 폴백.

## 엘리베이션 (그림자는 시스템에 딱 하나)
| 레벨 | 처리 | 용도 |
|---|---|---|
| Flat | 그림자·보더 없음 | 풀블리드 타일·글로벌 내비·푸터·본문 섹션 |
| Soft hairline | 1px `--hairline` | 유틸 카드·서브내비 구분 |
| Backdrop blur | `saturate(180%) blur(20px)` on 파치먼트 80% | 서브내비·플로팅 스티키 바 |
| Product shadow | `rgba(0,0,0,.22) 3px 5px 30px` | 표면에 놓인 미디어/이미지 — **유일한 진짜 그림자** |

> 카드·버튼·텍스트에 그림자 금지. UI 위계는 (a)표면 색 교차 (b)스티키 바 backdrop-blur 로만.

## 컴포넌트 규칙
- **글로벌 내비**: 검정(--black) 배경, 높이 44px, nav-link 12px, 우측 CTA/계정 상시 노출. 834px↓ 햄버거.
- **버튼(primary)**: --primary 채움 + on-primary 텍스트, body 17px, pill, padding 11×22. active scale(.95), focus outline 2px --primary-focus.
- **버튼(secondary pill)**: 투명 + 1px --primary 보더 + --primary 텍스트, pill (두 CTA 나란할 때 "고스트 알약").
- **버튼(dark utility)**: --ink 채움 + on-dark, caption 14px, radius sm, padding 8×15 (Sign In·Bag 류).
- **풀블리드 타일(light/parchment/dark)**: radius 0, 세로 패딩 80px, 중앙 스택(헤드라인→태그라인→CTA→미디어). 다크 타일 인라인 링크는 --primary-on-dark.
- **유틸 카드**: --canvas + 1px --hairline + radius lg(18) + padding 24. 기본 그림자 없음. 내부 미디어만 product-shadow.
- **검색 입력**: --canvas + 1px 소프트 보더 + pill + padding 12×20 + height 44.
- **푸터**: --parchment 배경, 링크 컬럼 relaxed leading, 하단 법적 fine-print 12px --ink-48, 세로 패딩 64.

## Do / Don't
- Do: 인터랙티브는 전부 --primary(액션 블루) 하나. 라이트↔다크 타일 교차로 섹션 리듬. 유일한 그림자는 미디어에만. active는 scale(.95).
- Don't: 두 번째 액센트 색 도입 금지. 카드·버튼·텍스트 그림자 금지. 장식 그라디언트 금지. 본문 웨이트 500 금지. 풀블리드 타일 라운딩 금지. 다크용 --primary-on-dark를 라이트 표면에 쓰지 말 것.
