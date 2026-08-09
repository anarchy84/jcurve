# SPEC — LLM 질의 기반 GEO 분석기 (AI 브랜드 가시성 모니터링)

> 상태: 설계(Design) — 구현 전. 작성 2026-08-09.
> 관련: 기존 온페이지 GEO·AEO 점검기(`/seo-check`, `OnPageAuditor`)의 **런타임 측정판**.
> 온페이지 점검기가 "AI가 인용하기 좋게 만들어졌는가"(구조)를 본다면, 이 분석기는
> "실제로 AI가 우리 브랜드를 어떻게 답하는가"(결과)를 측정한다.

---

## 1. 목표 & 범위

### 무엇을 하나
브랜드/도메인 + 대표 질문 세트를 입력하면, 여러 생성형 AI(ChatGPT·Perplexity·Gemini·Google AI Overviews·Claude)에 실제로 질의해서 **AI 답변 속 우리 브랜드의 위치**를 측정한다.

측정 항목:
- **언급률(Mention Rate)** — 질문 중 몇 %에서 브랜드가 답변에 등장하는가
- **인용률(Citation Rate)** — 브랜드 도메인이 출처 링크로 인용되는가
- **점유율(Share of Voice)** — 같은 답변에 등장하는 경쟁사 대비 우리 비중
- **위치/현저성(Prominence)** — 답변에서 첫 번째로 언급되는가, 몇 번째인가
- **감성/정확성(Sentiment / Accuracy)** — AI가 우리를 긍정·중립·부정 중 어떻게, 사실에 맞게 설명하는가
- **인용 소스(Cited Sources)** — AI가 어떤 도메인·페이지를 근거로 삼는가 (SEO/GEO 개선 지점)
- **추이(Trend)** — 주간 재실행으로 시간에 따른 변화 추적 (모니터링의 핵심 가치)

### 범위 밖 (명시)
- 실시간 무료 즉석 도구 아님 — LLM 질의는 비용·시간이 들어 **비동기 리포트**로 처리.
- 온페이지 정적 점검(이미 `/seo-check`가 담당)과 별개.
- 검색엔진 순위(SEO 랭킹) 측정 아님 — 그건 기존 랭크프리/SEO 서비스 영역.

---

## 2. 핵심 개념 — Parametric vs Grounded

AI 답변은 두 종류이고, GEO는 둘 다(특히 grounded)를 본다.

| 구분 | 정의 | 대표 엔진 | GEO 관점 |
|---|---|---|---|
| **Parametric** | 웹 검색 없이 모델이 학습한 지식만으로 답 | GPT(검색끔), Claude(툴 없음) | "AI가 우리를 아는가"(브랜드 각인) |
| **Grounded** | 실시간 웹 검색으로 근거를 찾아 답 + 인용 | Perplexity, ChatGPT 검색, Google AI Overviews, Claude+web_search | "AI가 우리를 인용하는가"(콘텐츠·SEO 결과) — **GEO의 주 타깃** |

두 모드를 분리 측정해야 개선 방향이 갈린다: parametric이 낮으면 브랜드 인지도/엔티티 문제, grounded가 낮으면 콘텐츠·구조화·피인용 문제.

---

## 3. 빌드 vs 바이 — 권장: **빌드**

| 옵션 | 내용 | 장점 | 단점 |
|---|---|---|---|
| **A. 바이** | Ahrefs Brand Radar / Semrush AI 등 API 구독 | 빠른 출시, 유지보수 적음 | 월 구독 비용, 종속성, 프롬프트·엔진 통제 불가 |
| **B. 빌드(권장)** | 자체 LLM 질의 파이프라인 | **"도구까지 직접 만든다" 브랜드와 일치**(기존 seo-check와 동일 철학), 프롬프트·엔진·리포트 완전 통제, 판매 상품화 가능 | LLM 비용 발생, 파이프라인 유지보수 |

**권장 근거**: 제이커브는 이미 온페이지 진단기를 자체 구현했고("남의 툴 안 쓴다"), GEO 분석기도 자체 보유하면 **차별화된 판매 상품**이 된다. 하이브리드도 가능(자체 파이프라인 + 인용 소스 데이터만 Ahrefs 보강). MVP는 순수 빌드로 충분.

---

## 4. 프로바이더 매트릭스

두 축을 구분한다: ① **분석 두뇌**(질문 생성·추출·스코어링) ② **측정 대상 엔진**(AI 답변을 뽑는 곳).

### ① 분석 두뇌 — Claude API 고정
- **질문 생성 / 멘션·인용·감성 추출 / 종합 리포트**: `claude-opus-5` (복잡한 판단·종합), 대량 추출은 `claude-haiku-4-5`로 비용 절감.
- Structured Outputs(`output_config.format` + JSON Schema)로 추출 결과를 스키마 강제 → 파싱 안전.
- PHP(Laravel)에서 호출: 공식 `anthropic-ai/sdk`(PHP) 또는 raw HTTP. named args는 camelCase(`maxTokens`).

### ② 측정 대상 엔진 — 어댑터 패턴(플러그블)

| 엔진 | 모드 | 연동 | MVP |
|---|---|---|---|
| **Claude + web_search** | grounded | Anthropic API, `web_search_20260209` 서버툴 | ✅ |
| **Claude (툴 없음)** | parametric | Anthropic API | ✅ |
| **OpenAI GPT** | parametric/grounded | OpenAI API (web_search 옵션) | ✅ (키 확보 시) |
| **Perplexity** | grounded | Perplexity API (인용 포함) | ✅ (키 확보 시) |
| **Google AI Overviews** | grounded | 공식 API 없음 → SerpAPI 등 SERP 스크래핑 | v2 |
| **Gemini** | parametric/grounded | Google AI API | v2 |

각 엔진은 `LlmEngineAdapter` 인터페이스로 추상화(`query(prompt): {answer, citations[], raw}`). 엔진 추가 = 어댑터 추가. **엔진 API 키는 서버 환경변수(.env)로 관리, 클라이언트 노출 금지.**

---

## 5. 아키텍처 (Laravel)

```
[사용자: 브랜드+질문] → 리포트 생성 요청(비동기)
        │
        ▼
  GeoReport(pending) 생성 → Queue Job dispatch
        │
        ▼  (queue worker)
  ┌─ 1. 질문 세트 확정 (사용자 입력 or Claude 자동생성)
  ├─ 2. [질문 × 엔진] 매트릭스로 병렬 질의 (rate-limit·retry·backoff)
  │      각 응답 → GeoResponse 저장 (answer_text, citations, raw)
  ├─ 3. Claude로 각 응답 분석 → GeoMention 추출
  │      (언급여부·위치·감성·경쟁사·인용도메인) [Structured Outputs]
  ├─ 4. 집계·스코어링 → GEO Visibility Score + 지표
  └─ 5. Claude로 요약·개선제안 종합 → GeoReport(completed)
        │
        ▼
  리포트 뷰 렌더 + (선택) 이메일 알림
```

- **큐**: 프로젝트가 이미 `QUEUE=database`(DEPLOY.md). 전용 `geo` 큐 + `queue:work --queue=geo` 워커.
- **동시성/비용 제어**: 엔진별 rate limit 준수, 질의 수 = 질문수 × 엔진수 (예: 20질문 × 3엔진 = 60콜/리포트). 상한·타임아웃·부분실패 허용.
- **재실행(모니터링)**: `schedule:run` 크론으로 주간 재실행 → 추이 그래프.

---

## 6. 데이터 모델 (마이그레이션)

```
geo_brands
  id, user_id(nullable), name, domain, aliases(json),
  competitors(json), industry, created_at

geo_prompts                      # 측정할 질문(구매자 질문)
  id, brand_id, text, intent(enum: awareness|comparison|recommendation|transactional),
  is_auto(bool), created_at

geo_reports                      # 1회 실행 = 1 리포트(추이의 데이터포인트)
  id, brand_id, status(enum: pending|running|completed|failed),
  score(int), metrics(json), summary(text),
  engines(json), started_at, completed_at, error, created_at

geo_responses                    # [질문×엔진] 원응답
  id, report_id, prompt_id, engine(string), mode(enum: parametric|grounded),
  answer_text(longtext), citations(json), tokens(int), latency_ms, created_at

geo_mentions                     # 응답 1건에서 추출한 분석 결과
  id, response_id, mentioned(bool), position(int null), prominence(enum: first|early|late|none),
  sentiment(enum: positive|neutral|negative|null), accurate(bool null),
  competitors_present(json), cited_own_domain(bool), cited_domains(json), created_at
```

민감 데이터 최소화: 원응답 보관 기간 정책(예: 90일) 명시, 사용자 PII 미저장.

---

## 7. 프롬프트 설계 (Claude)

### 7-1. 질문 자동 생성 (선택)
입력: 브랜드·업종·경쟁사. 출력: 구매 여정별 대표 질문 N개(인지/비교/추천/거래).
- 예: "서울 퍼포먼스 마케팅 대행사 추천", "SEO 대행사 vs 인하우스", "리워드 광고 잘하는 곳".
- Structured Outputs로 `{prompts: [{text, intent}]}` 스키마 강제.

### 7-2. 답변 분석/추출 (핵심)
각 `GeoResponse.answer_text`(+citations)를 Claude에 넣어 아래를 **JSON Schema로 강제 추출**:
```json
{
  "mentioned": true,
  "position": 1,                 // 답변에서 브랜드 첫 등장 순번(문단/항목 기준), 미언급 null
  "prominence": "first",         // first|early|late|none
  "sentiment": "positive",       // positive|neutral|negative|null
  "accurate": true,              // 브랜드 설명이 사실과 부합하는가(제공된 fact와 대조)
  "competitors_present": ["A사","B사"],
  "cited_own_domain": true,      // 우리 도메인이 출처로 인용됐는가
  "cited_domains": ["x.com","y.co.kr"]
}
```
- 대량이므로 추출은 `claude-haiku-4-5`, 애매한 케이스·최종 종합은 `claude-opus-5`.
- `accurate` 판정을 위해 브랜드의 "사실 카드"(제공 서비스·소재지 등)를 프롬프트에 함께 제공.

### 7-3. 종합 리포트
집계 지표 + 대표 사례를 Claude에 넣어 "현재 AI 가시성 진단 + 우선 개선 3~5가지"를 한국어로 생성.

---

## 8. GEO Visibility Score (0~100)

가중 합산(초안, 튜닝 대상):
```
score = 100 × (
    0.30 × mention_rate            # 언급된 질문 비율
  + 0.25 × citation_rate           # 우리 도메인 피인용 비율(grounded 응답 중)
  + 0.20 × share_of_voice          # (우리 언급 수)/(우리+경쟁사 언급 수)
  + 0.15 × prominence_score        # first=1, early=0.6, late=0.3, none=0 평균
  + 0.10 × sentiment_score         # positive=1, neutral=0.5, negative=0
)
```
- parametric/grounded **섹션별 서브점수**도 함께 제시(개선 방향 분리).
- 등급 A~F 매핑은 기존 seo-check와 동일 톤.

---

## 9. 보안 · 남용방지 · 비용 · 법적

- **키 관리**: 모든 엔진 API 키 = 서버 `.env`, 클라이언트/응답 노출 금지.
- **비용 통제**: 리포트당 질의 상한, 엔진별 월 예산 캡, `get_cost` 프리플라이트(해당 SDK 지원 시), haiku 우선 라우팅.
- **남용방지**: 리포트 생성은 **인증/리드 게이트**(무료 즉석 아님). rate limit + 일일 생성 상한.
- **부분 실패 허용**: 한 엔진 실패해도 나머지로 리포트 생성, 실패 엔진 표기.
- **법적/약관**: SERP 스크래핑(Google AIO)은 각 서비스 약관 확인 필요 → 공식 API 있는 엔진 우선, AIO는 SerpAPI 같은 합법 경로.
- **경쟁사명 표기**: 리포트 내 경쟁사 실명은 내부/고객 리포트 한정, 공개 페이지엔 비노출(기존 사이트 규칙과 동일).

---

## 10. UI / UX (리드젠 모델)

- **진입**: GEO·AEO 랜딩 페이지에 "AI가 우리 브랜드를 어떻게 답하는지 무료 리포트 받기" CTA.
- **입력 폼**: 브랜드명·도메인·업종·(선택)경쟁사·확인할 질문 → 이메일(리드 확보).
- **비동기 처리**: "리포트 생성 중" → 완료 시 화면/이메일로 결과.
- **무료 샘플 vs 유료**: 무료는 1~2개 엔진·소수 질문으로 맛보기, 정밀·다엔진·주간 모니터링은 유료 상담 전환.
- **결과 화면**: 종합 점수 + parametric/grounded 서브점수 + 엔진별 언급/인용 매트릭스 + 대표 답변 발췌 + 인용 소스 TOP + 개선 제안 + (재실행 시)추이 그래프.

---

## 11. 단계별 로드맵

- **MVP (Phase 1)**: 브랜드/질문 수동 입력 → Claude(parametric+web_search) + (키 확보 시)OpenAI·Perplexity → 추출·스코어링 → 1회 리포트 화면. 리드 폼 연동.
- **Phase 2**: 질문 자동 생성, 주간 스케줄 재실행 + 추이 그래프, 경쟁사 SoV 상세, 인용 소스 드릴다운.
- **Phase 3**: Google AI Overviews·Gemini 어댑터, 알림(개선/악화 감지), 고객 대시보드, (선택)Ahrefs 인용 데이터 보강.

---

## 12. 승인/결정 필요 사항 (구현 착수 전)

1. **엔진 API 키 확보**: OpenAI·Perplexity(·SerpAPI) 계정/키. Claude 키는 확보 여부 확인. → **비용 발생, 사용자 승인 필요**.
2. **무료/유료 경계**: 무료 샘플 범위(엔진·질문 수), 유료 전환 지점.
3. **리드 게이트 방식**: 로그인 필요 vs 이메일만.
4. **원응답 보관 정책**: 보관 기간·PII 처리.
5. **빌드 vs 하이브리드**: 순수 자체 빌드 확정 여부(Ahrefs 보강 여부).

> 위 5가지(특히 1번 비용) 확정되면 Phase 1을 코덱스 루프로 분해해 구현 착수. DB 스키마·보안(키·SSRF·rate limit)은 Claude가 직접, 어댑터·CRUD·뷰 마크업은 코덱스 위임.
