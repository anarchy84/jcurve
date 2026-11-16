# SEO·GEO·AEO 스킬 설치 기록 (2026-11-16, 이노출)

프로젝트 단위로 설치했다 → `.claude/skills/`(35개) · `.claude/agents/`(19개).
이 레포에서 Claude Code를 열면 자동으로 잡힌다. `/seo`, `/geo`, `/ai-seo` 로 직접 부를 수도 있다.

## 무엇을 깔았나

| 묶음 | 출처(설치 커밋) | 깐 것 | 쓰임 |
|---|---|---|---|
| claude-seo | [AgriciDaniel/claude-seo](https://github.com/AgriciDaniel/claude-seo) `468ed5b` · MIT · v2.6.2 | `seo` 허브 + `seo-*` 20개, 에이전트 14개 | 전체 SEO 감사(기술·콘텐츠 E-E-A-T·스키마·사이트맵·hreflang·이미지·백링크·SXO·에이전트 준비도), `seo-geo` |
| geo-seo-claude | [zubair-trabzada/geo-seo-claude](https://github.com/zubair-trabzada/geo-seo-claude) `989cae0` · MIT | `geo` 허브 + `geo-*` 12개, 에이전트 5개 | GEO 우선 감사: 인용 가능성 점수, AI 크롤러 접근, 브랜드 언급, 플랫폼별(ChatGPT·Perplexity·AI 개요) 최적화, llms.txt |
| marketingskills | [coreyhaines31/marketingskills](https://github.com/coreyhaines31/marketingskills) `1f83744` · MIT · v2.12.3 | `ai-seo` 1개 | AEO·GEO 원고 작성: AI 답변에 인용되는 문장·구조·근거 패턴 |

## 일부러 뺀 것

- `seo-google`, `seo-bing` — 서치콘솔 조회·색인 요청·IndexNow 제출을 한다. **서치콘솔·서치어드바이저는 다른 사람이 관리하니 손대지 않는다**는 규칙 때문에 뺐다.
- `seo-dataforseo`, `seo-image-gen`, `seo-posthog`, `seo-maps` — 유료 API나 따로 붙여야 하는 MCP 서버가 필요하다.
- `seo-shopify`, `seo-ecommerce` — 쇼핑몰용이다.
- `geo-prospect`, `geo-proposal` — 대행사 영업(고객 관리·제안서)용이다.
- `geo-update` — 원격 저장소를 받아 `~/.claude` 를 덮어쓰는 자동 업데이트라서 뺐다.
- claude-seo 훅(`hooks/`)은 등록하지 않았다.

## 원본에서 바꾼 것

- 원본은 `~/.claude/skills/...`(사용자 폴더 설치)를 전제로 한다. 프로젝트 설치라서 문서(.md) 안 경로를 **프로젝트 루트 기준 상대경로** `.claude/skills/...` 로 바꿨다. 그래서 명령은 레포 루트에서 실행해야 한다.
- 그 밖의 내용은 원본 그대로다.

## 알아 둘 것 (2026-11-16 확인)

- **스킬 본문(방법론·체크리스트·점수 기준·스키마 템플릿)은 바로 쓸 수 있다.** 다만 함께 들어 있는 파이썬 도구는 아직 못 돌린다.
  - 현재 에이전트 컨테이너에는 pip·venv(ensurepip)가 없다. 그래서 claude-seo 런타임 설치(`claude-seo setup`)가 실패했고, geo 스크립트가 쓰는 `requests` 도 없다.
- **claude-seo 런타임 위치 주의**: 수동 설치라 기본값으로 두면 `.venv` 가 `.claude/skills/seo/` 안, 즉 프로젝트 안에 생긴다.
  - 맥에서 돌릴 때는 `CLAUDE_SEO_DATA_DIR=~/.local/share/claude-seo` 를 지정해 프로젝트 밖에 만든다.
- **업데이트**: 원본 저장소를 새로 받아 같은 목록으로 다시 복사하고, 위 경로 치환을 다시 한다.
