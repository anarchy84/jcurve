# INTL-04A 구현 결과

- 작업 ID: INTL-04A / 구현: Codex / 날짜: 2026-11-03.
- 작업 폴더: `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`.
- 기준: `docs/intl/SPEC-CODEX-INTL-04.md` 전체, `INTL-PLAN.md` §1·§5, `GLOSSARY.md` §1~§8, `docs/COLLAB.md`, `docs/collab/QUEUE.md`, tri-agent-orchestration 규칙. 영어·일본어 home/company/contact/rankfree/marketing-support/self-marketing 문구를 말투 참고로 확인.
- 수정한 제품 파일: **`lang/en/subpages.php` 하나**. 한국어 원문: `config/subpages.php` 읽기 전용.
- 반환물: `docs/intl/INTL-04A-IMPL-RESULT.md`.
- **한국어에서 다시 번역한 문자열: 1,026개**. 경로별 문자열 값 기준이며, 동일 문구가 다른 경로에 있으면 각각 센다.
- 전체 비표시 값 제외 사람용 문자열 1,136개를 확인했다. 한국어 원문 문자열 1,026개를 직접 새로 작성하고, 나머지 원래 영어인 라벨·제목 110개도 확인했다. 용어·문장형 제목 기준에 맞춰 영어 eyebrow 61개 경로를 정리했다.
- 작업 전 영어 파일과 실제 내용이 달라진 사람용 문자열: 1,042개. 짧은 CTA 등 새로 번역한 결과가 이전 표현과 같은 항목도 있어 1,026과 별개 집계다.
- 구현자 필수 점검은 완료했다. 최종 합격 판정은 별도 검증 세션과 Claude 검수에 남긴다.

## 1. 변경 범위와 diff

| 구역 | 하위 페이지 | 한국어 원문에서 재번역한 문자열(부모 문구 포함) | 이전 영어 대비 변경 문자열 |
|---|---:|---:|---:|
| seo | 5 | 232 | 231 |
| cpa | 5 | 418 | 431 |
| performance | 3 | 125 | 123 |
| boostingshop | 6 | 251 | 257 |
| 합계 | 19 | 1,026 | 1,042 |

누락됐던 제목의 의미(예: Elite의 ‘경쟁 시장을 위한’), 축약된 SEO 설명, GFA의 반복 설명을 한국어 원문 기준으로 다시 옮겼다. leads / creative / placement / operating process·workflow / rejection / after-sales support / policy review / switching 등 용어집을 적용했다. 보험 페이지의 회사 전체 누적 라벨, 2026년 기준, 미팅·계약 비보장, 동의·검수·중복·AS·정산 조건도 모두 포함했다. 한국 플랫폼 설명은 해당 페이지의 첫 설명 문장에서 한 번만 제공한다.

작업 전 스냅샷 대비 실제 출력:

```text
Line-aligned snapshot comparison:
before_lines = 2509
after_lines = 2509
changed_lines = 1050
```

변경 직후 실행한 `git diff --stat -- lang/en/subpages.php`:

```text
 lang/en/subpages.php | 2100 +++++++++++++++++++++++++-------------------------
 1 file changed, 1050 insertions(+), 1050 deletions(-)
```

공유 작업 중 마지막 조회에서 `git log -1 --format='%H %s' -- lang/en/subpages.php`는 아래 checkpoint를 가리켰고, 이 파일의 최종 `git diff` 출력은 비어 있었다. **이 구현 세션에서는 git 쓰기 명령을 실행하지 않았다.** 공유 HEAD와 독립적으로 저장한 작업 전 내용과 아래 SHA-256으로 전후를 비교했다.

```text
975a36b0488277baff007a70781ed46a0c3a8260 🤖 checkpoint: 2026-11-03 16:02:04
```

- 전: `8a01ec020e18446715037329d5ae770d034b678b3ee0716052bc64debbacfb4a`
- 후: `eb2bbcef1598a2a5014a3d44ca1b9742b2d5ad4c80da0dda8c47d872b25e9d17`

## 2. 자동 점검 1~5: 실행 및 실제 출력

명령:

```sh
php /private/tmp/intl-04a-check.php
```

스크립트는 PHP 배열을 재귀 순회해 사람용 문자열과 비표시 값을 분리한다. 표시하지 않는 키는 route/param/type/tone/href/id/contact_interest/icon/slug/source_hash다. 배열 키·순서·자료형, PHP 키 토큰 원문 바이트, 비표시 값, HTML 태그, 숫자, 한글, 금지 표현, Unicode 문자 길이 비율을 비교했다. HTML 텍스트·속성이 있는 문자열은 원문과 변경 파일 모두 0개다. 실행 종료 코드: **0**.

```json
{
  "summary": {
    "total_leaves": 1338,
    "human_strings": 1136,
    "korean_source_strings_retranslated": 1026,
    "human_strings_changed_from_before": 1042,
    "hangul_remaining": 0,
    "key_structure_differences": 0,
    "source_key_structure_differences": 0,
    "key_token_byte_differences": 0,
    "non_human_values_checked": 202,
    "non_human_value_differences": 0,
    "html_structure_differences": 0,
    "raw_numeric_difference_rows": 11,
    "normalized_numeric_differences": 0,
    "machine_translation_traces": 0,
    "length_ratio_outliers": 13,
    "baseline_source_unchanged": true,
    "sha256_before": "8a01ec020e18446715037329d5ae770d034b678b3ee0716052bc64debbacfb4a",
    "sha256_after": "eb2bbcef1598a2a5014a3d44ca1b9742b2d5ad4c80da0dda8c47d872b25e9d17"
  },
  "hangul": [],
  "nonHumanDiffs": [],
  "htmlDiffs": [],
  "rawNumberDiffs": [
    {
      "path": "cpa.items.insurance.inquiry_template",
      "ko": [],
      "en": [
        "2"
      ]
    },
    {
      "path": "cpa.items.insurance.sections.0.items.2.title",
      "ko": [],
      "en": [
        "2"
      ]
    },
    {
      "path": "cpa.items.insurance.sections.0.items.2.label",
      "ko": [],
      "en": [
        "2"
      ]
    },
    {
      "path": "cpa.items.insurance.sections.1.items.0.title",
      "ko": [
        "373"
      ],
      "en": [
        "37.3B"
      ]
    },
    {
      "path": "cpa.items.insurance.sections.1.items.1.title",
      "ko": [
        "128"
      ],
      "en": [
        "1.28M"
      ]
    },
    {
      "path": "cpa.items.insurance.sections.12.title",
      "ko": [],
      "en": [
        "2"
      ]
    },
    {
      "path": "cpa.items.insurance.sections.12.note",
      "ko": [],
      "en": [
        "2"
      ]
    },
    {
      "path": "cpa.items.insurance.sections.12.link.label",
      "ko": [],
      "en": [
        "2"
      ]
    },
    {
      "path": "cpa.items.insurance.faq.9.question",
      "ko": [],
      "en": [
        "2"
      ]
    },
    {
      "path": "cpa.items.insurance.faq.9.answer",
      "ko": [],
      "en": [
        "2"
      ]
    },
    {
      "path": "cpa.items.insurance.cta.text",
      "ko": [],
      "en": [
        "2"
      ]
    }
  ],
  "numericDiffs": [],
  "traces": [],
  "outliers": [
    {
      "path": "seo.items.naver-place.sections.1.items.0.title",
      "ratio": 5.2,
      "ko": "현황 진단",
      "en": "Review the current listing"
    },
    {
      "path": "cpa.items.insurance.local_nav.3.label",
      "ratio": 6.2,
      "ko": "품질·AS",
      "en": "Quality and after-sales support"
    },
    {
      "path": "cpa.items.insurance.sections.4.rows.5.0",
      "ratio": 5.8,
      "ko": "AS 판단",
      "en": "Assessing after-sales support"
    },
    {
      "path": "cpa.items.insurance.sections.5.items.6.title",
      "ratio": 5.333,
      "ko": "AS·광고 피드백",
      "en": "Connect after-sales support to campaign feedback"
    },
    {
      "path": "cpa.items.insurance.sections.9.items.1.title",
      "ratio": 5.25,
      "ko": "소규모 GA·팀",
      "en": "Small general insurance agencies and teams"
    },
    {
      "path": "cpa.items.insurance.sections.9.items.3.title",
      "ratio": 5,
      "ko": "리모델링 중심 상담",
      "en": "Consultations focused on policy review / switching"
    },
    {
      "path": "cpa.items.insurance.sections.10.items.1.title",
      "ratio": 5.6,
      "ko": "AS 신청",
      "en": "After-sales support requests"
    },
    {
      "path": "performance.items.youtube.sections.1.items.2.title",
      "ratio": 5.571,
      "ko": "훅·구성·제작",
      "en": "Develop hooks, structure and production"
    },
    {
      "path": "boostingshop.items.instagram-popular.sections.1.items.3.title",
      "ratio": 4.667,
      "ko": "협업과 교차 유입",
      "en": "Connect collaborations and traffic sources"
    },
    {
      "path": "boostingshop.items.instagram-followers.sections.1.items.3.title",
      "ratio": 4.667,
      "ko": "협업과 교차 유입",
      "en": "Connect collaborations and traffic sources"
    },
    {
      "path": "boostingshop.items.instagram-followers.sections.3.items.3.title",
      "ratio": 5,
      "ko": "성과 해석 분리",
      "en": "Distinguish counts from business results"
    },
    {
      "path": "boostingshop.items.instagram-likes.sections.1.items.3.title",
      "ratio": 4.667,
      "ko": "협업과 교차 유입",
      "en": "Connect collaborations and traffic sources"
    },
    {
      "path": "boostingshop.items.instagram-likes.sections.3.items.3.title",
      "ratio": 5,
      "ko": "성과 해석 분리",
      "en": "Distinguish counts from business results"
    }
  ]
}
```

### 숫자 차이 판정

원시 숫자 추출 결과 차이는 위 rawNumberDiffs의 **11개 경로**다. 다음 두 범주만 있으며 실제 수치 차이는 0이다.

- 2개: `373억+` → `KRW 37.3B+`, `128만+` → `1.28M+`. 각각 37,300,000,000원과 1,280,000건으로 값이 같다.
- 9개: 원문 고유명사 ‘콜투세일’의 용어집 표기 `Call2Sale` 안에 숫자 2가 나타난다. 실적·금액·수량이 아닌 고유명사의 동일 표기다. 양쪽의 고유명사를 제외해 숫자를 비교했다.
- 숫자 토큰을 정렬하고 억·만·M·B를 실제 값으로 정규화한 결과 **차이 0**. 연도·건수·단계·2단계 인증 등 나머지 숫자도 보존했다. 원화 환산은 없다.
- 영어 `3rd`, `1st`는 원문의 제3자·1차에 해당하며 숫자 값을 유지한다.

### 길이 비율 이상치 13개: 개별 검토

기준은 Unicode 문자 수 en/ko < 0.8 또는 > 4.5다. 13개 모두 아래와 같이 **정상**으로 판정했다. 누락·새 서비스·새 약속으로 판정한 항목은 없다.

| 경로 | 비율 | 한국어 | 새 영어 | 판정과 근거 |
|---|---:|---|---|---|
| `seo.items.naver-place.sections.1.items.0.title` | 5.2 | 현황 진단 | Review the current listing | 정상 — 짧은 한국어 제목 ‘현황 진단’을 해당 문맥의 listing review로 명확히 표현. 의미 추가·누락 없음. |
| `cpa.items.insurance.local_nav.3.label` | 6.2 | 품질·AS | Quality and after-sales support | 정상 — AS를 용어집의 after-sales support로 풀어 쓰면서 증가. 품질·AS 두 의미 모두 보존. |
| `cpa.items.insurance.sections.4.rows.5.0` | 5.8 | AS 판단 | Assessing after-sales support | 정상 — AS를 after-sales support로 풀어 씀. 판단이라는 원문 의미 보존. |
| `cpa.items.insurance.sections.5.items.6.title` | 5.333 | AS·광고 피드백 | Connect after-sales support to campaign feedback | 정상 — AS를 풀어 쓰고 광고 피드백 연결을 문장형으로 표현. 원문 단계의 범위와 동일. |
| `cpa.items.insurance.sections.9.items.1.title` | 5.25 | 소규모 GA·팀 | Small general insurance agencies and teams | 정상 — GA를 general insurance agencies로 풀어 외국 기업 담당자가 이해하도록 표현. 팀이라는 항목도 보존. |
| `cpa.items.insurance.sections.9.items.3.title` | 5 | 리모델링 중심 상담 | Consultations focused on policy review / switching | 정상 — 용어집의 policy review / switching을 사용하면서 증가. 보험 리모델링의 상담 문맥 보존. |
| `cpa.items.insurance.sections.10.items.1.title` | 5.6 | AS 신청 | After-sales support requests | 정상 — AS를 after-sales support로 풀어 씀. 신청은 requests로 옮김. |
| `performance.items.youtube.sections.1.items.2.title` | 5.571 | 훅·구성·제작 | Develop hooks, structure and production | 정상 — 한국어의 훅·구성·제작을 세 항목 모두 영어로 명시. 의미 추가·누락 없음. |
| `boostingshop.items.instagram-popular.sections.1.items.3.title` | 4.667 | 협업과 교차 유입 | Connect collaborations and traffic sources | 정상 — 협업과 교차 유입을 협업·traffic sources 연결로 명시. 원문 본문의 채널 연결과 같은 범위. |
| `boostingshop.items.instagram-followers.sections.1.items.3.title` | 4.667 | 협업과 교차 유입 | Connect collaborations and traffic sources | 정상 — 협업과 교차 유입의 두 요소 모두 보존. 짧은 한국어 항목의 영어 확장. |
| `boostingshop.items.instagram-followers.sections.3.items.3.title` | 5 | 성과 해석 분리 | Distinguish counts from business results | 정상 — 성과 해석의 분리를 counts와 business results 구분으로 표현. 바로 뒤 원문 설명의 뜻과 일치. |
| `boostingshop.items.instagram-likes.sections.1.items.3.title` | 4.667 | 협업과 교차 유입 | Connect collaborations and traffic sources | 정상 — 협업과 교차 유입의 두 요소 모두 보존. 짧은 한국어 항목의 영어 확장. |
| `boostingshop.items.instagram-likes.sections.3.items.3.title` | 5 | 성과 해석 분리 | Distinguish counts from business results | 정상 — 성과 해석의 분리를 counts와 business results 구분으로 표현. 바로 뒤 원문 설명의 뜻과 일치. |

## 3. 자동 점검 6: PHP 문법·Pint·전체 테스트

```sh
php -l lang/en/subpages.php
```

종료 코드 0, 실제 출력:

```text
No syntax errors detected in lang/en/subpages.php
```

```sh
./vendor/bin/pint --test lang/en/subpages.php
```

종료 코드 0, 실제 출력:

```json
{"tool":"pint","result":"passed"}
```

전체 테스트는 실제 프로젝트 `bootstrap/app.php`를 사용하는 임시 artisan 진입점으로 실행했다. 이 진입점은 환경 파일 탐색 위치만 세션 전용 임시 폴더로 지정한다. 테스트 자식 프로세스도 `APP_BASE_PATH`를 통해 같은 진입점을 사용한다. 프로젝트 `.env`를 읽거나 복제하지 않았으며, DB는 해당 명령 한 번에만 `DB_DATABASE=:memory:`로 지정했다. 임시 bootstrap은 HTTP/HTTPS PHP 스트림을 해제하고 각 앱 부팅 후 `Http::preventStrayRequests()`를 적용했다. 기존 테스트의 HTTP fake와 인프로세스 요청만 사용한다.

실행한 전체 명령:

```sh
APP_BASE_PATH=/private/tmp/intl-04a-runtime APP_ENV=testing APP_KEY=base64:MDEyMzQ1Njc4OTAxMjM0NTY3ODkwMTIzNDU2Nzg5MDE= DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= CACHE_STORE=array SESSION_DRIVER=array QUEUE_CONNECTION=sync MAIL_MAILER=array VIEW_COMPILED_PATH=/private/tmp/intl-04a-runtime/views APP_CONFIG_CACHE=/private/tmp/intl-04a-runtime/config.php APP_EVENTS_CACHE=/private/tmp/intl-04a-runtime/events.php APP_ROUTES_CACHE=/private/tmp/intl-04a-runtime/routes.php APP_SERVICES_CACHE=/private/tmp/intl-04a-runtime/services.php APP_PACKAGES_CACHE=/private/tmp/intl-04a-runtime/packages.php php /private/tmp/intl-04a-runtime/artisan test --compact
```

종료 코드 0, 실제 출력:

```json
{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":20228}
```

**206/206 테스트, 36,008 assertions 통과.** 다른 세션으로 인한 테스트 실패는 관찰되지 않았다. 블로그 시더 두 번 실행 및 `intl:stale`은 INTL-04A의 수정 범위에 해당하지 않아 실행하지 않았다.

추가 `git diff --check -- lang/en/subpages.php`: 종료 코드 0, 출력 없음.

## 4. 한국어 · 이전 번역 · 새 번역 20쌍

이전 번역은 작업 시작 시 저장한 배열 스냅샷에서 그대로 추출했다. 새 번역은 변경 파일의 해당 경로 값이다.

### 1. `seo.items.naver-shopping.sections.3.items.0.text`

- 한국어: 상품군별 정보 기준이 달라져 운영 체계를 다시 잡아야 하는 경우.
- 이전: When information standards for each product group change and the operating system needs to be reorganized.
- 새 번역: You need consistent information standards and a clearer workflow across product groups.

### 2. `seo.items.kakao-gift.sections.3.items.3.text`

- 한국어: 재고·배송·CS 기준이 불명확하다면 노출보다 운영 체계를 먼저 정해야 합니다.
- 이전: If inventory, delivery, and CS standards are unclear, the operating system must be determined before exposure.
- 새 번역: If stock, delivery and customer service standards are unclear, define your operating process before seeking visibility.

### 3. `cpa.items.permission-call.sections.0.paragraphs.1`

- 한국어: 수집 화면, 동의 로그, DB 전달, 상담 스크립트, 수신 거부와 보유 기간까지 하나의 운영 체계로 설계해야 합니다.
- 이전: Collection screen, consent log, leads delivery, consultation script, opt-out and retention period must be designed as one operating system.
- 새 번역: The collection form, consent logs, lead delivery, call scripts, opt-outs and retention periods need one operating process.

### 4. `boostingshop.items.elite.title`

- 한국어: SEO 캠페인 엘리트 — 경쟁 시장을 위한 통합 운영
- 이전: SEO Elite — integrated operations
- 새 번역: SEO Elite campaign — integrated management for competitive markets

### 5. `boostingshop.items.elite.sections.1.title`

- 한국어: 전사 진단에서 반복 운영 체계까지
- 이전: From enterprise diagnosis to repeatable operating system
- 새 번역: From a business-wide review to a repeatable workflow

### 6. `boostingshop.items.elite.cta.title`

- 한국어: 고경쟁 SEO를 개인의 감이 아닌 운영 체계로 바꾸세요
- 이전: Make high-competition SEO an operating system rather than a personal instinct
- 새 번역: Manage competitive SEO through a process rather than individual instinct

### 7. `performance.items.naver-gfa.lead`

- 한국어: 네이버 GFA는 네이버 서비스의 다양한 디스플레이 지면에서 오디언스에게 도달하는 광고입니다. 제이커브는 캠페인 목적, 전환 측정, 타게팅과 소재 가설을 먼저 정하고 데이터를 보며 예산과 크리에이티브를 조정합니다.
- 이전: NAVER GFA is NAVER’s display ad platform. NAVER is Korea’s largest search portal. NAVER GFA is an advertisement that reaches audiences on various display surfaces of the NAVER service. J-Curve first determines the campaign purpose, conversion measurement, targeting, and creative hypothesis, and then adjusts the budget and creative by looking at the data.
- 새 번역: NAVER GFA — NAVER's display ad platform — reaches audiences across display placements on NAVER services. We first define campaign goals, conversion measurement, targeting and creative hypotheses, then use the data to adjust budgets and creative.

### 8. `performance.items.naver-gfa.sections.1.items.2.text`

- 한국어: 한 번에 바꾸는 요소를 제한해 메시지와 크리에이티브 가설을 검증합니다.
- 이전: Test your message and creative hypotheses by limiting the number of changes you make at a time.
- 새 번역: We limit the variables changed at once to test messaging and creative hypotheses.

### 9. `performance.items.facebook.sections.1.items.2.title`

- 한국어: 소재 가설 제작
- 이전: Material hypothesis production
- 새 번역: Build creative hypotheses

### 10. `performance.items.youtube.faq.0.answer`

- 한국어: 가능하지만 광고 목적과 초반 메시지, 화면 비율과 다음 행동이 맞는지 먼저 확인합니다. 필요한 경우 기존 영상을 재편집하거나 새 소재 범위를 협의합니다.
- 이전: Yes, after checking the campaign goal, opening message, aspect ratio and next action. We can discuss re-editing existing footage or producing new creative if needed.
- 새 번역: Yes, but we first check the ad objective, opening message, aspect ratio and next action. We can discuss re-editing existing videos or producing new creative where needed.

### 11. `cpa.items.insurance.sections.2.items.2.text`

- 한국어: 광고주·공급사마다 중복의 기간과 식별 기준이 다르면 반려와 정산 분쟁이 반복됩니다.
- 이전: If the duplication period and identification criteria are different for each advertiser or supplier, rejection and settlement disputes will be repeated.
- 새 번역: Different duplicate windows and identification rules across advertisers and lead suppliers cause repeated rejection and settlement disputes.

### 12. `cpa.items.insurance.sections.5.items.0.text`

- 한국어: 보험 리모델링, 보장 분석, 상담 등 실제 제공 범위를 과장 없이 설명하고 신청 목적을 맞춥니다.
- 이전: We explain the actual scope of provision, including insurance remodeling, coverage analysis, and consultation, without exaggeration, and align with the purpose of the application.
- 새 번역: We accurately explain the actual scope, such as policy review / switching, coverage analysis and consultation, and align it with the request's purpose.

### 13. `cpa.items.insurance.sections.6.items.3.text`

- 한국어: 보험 리모델링 설명, 미팅 재확인, 지역·상담 유형과 영업 방식에 맞춰 확인 질문과 전달 정보를 조정합니다.
- 이전: Insurance remodeling explanations, reconfirmation of meetings, and adjustment of confirmation questions and delivery information according to region, consultation type, and sales method.
- 새 번역: Adapt verification questions and delivery details to policy review / switching, meeting reconfirmation, regions, consultation types and sales methods.

### 14. `cpa.items.insurance.sections.8.note`

- 한국어: 주관적인 “질이 나쁘다”만으로 반려하지 않고, 양측이 같은 자료와 기한으로 판단할 수 있어야 합니다.
- 이전: Rather than rejecting an application based solely on subjective “bad quality,” both parties should be able to make a judgment based on the same data and deadline.
- 새 번역: Do not reject leads solely on subjective claims of “poor quality.” Both parties need shared evidence and deadlines for assessment.

### 15. `cpa.items.insurance.sections.13.items.3.text`

- 한국어: 작은 지역·물량으로 연락률, 미팅 상태, 반려 사유와 담당자 입력 품질을 확인합니다.
- 이전: Check contact rate, meeting status, reason for rejection, and quality of input from the person in charge in small areas and volumes.
- 새 번역: We use a limited region and volume to check contact rates, meeting status, rejection reasons and the quality of staff data entry.

### 16. `cpa.items.insurance.sections.10.items.1.text`

- 한국어: DB별 AS 가능 기간과 신청 상태, 승인·거절 결과와 필요한 증빙을 한 흐름에서 확인합니다.
- 이전: Check the after-sales support availability period, application status, approval/rejection results, and necessary evidence for each leads in one flow.
- 새 번역: See each lead's support window, request status, approval or rejection outcome and required evidence in one workflow.

### 17. `cpa.items.real-estate.sections.1.items.3.text`

- 한국어: 유입 이후 상담 상태를 분류해 매체·소재·타게팅 개선에 반영합니다.
- 이전: After inflow, the consultation status is classified and reflected in improving media, materials, and targeting.
- 새 번역: We classify consultation status after acquisition and feed it into media, creative and targeting improvements.

### 18. `boostingshop.items.instagram-popular.sections.0.title`

- 한국어: 인기게시물은 외부에서 소유하거나 고정할 수 있는 광고 지면이 아닙니다
- 이전: Popular posts are not advertising spaces that can be owned or pinned externally.
- 새 번역: Top posts are not ad placements an outside provider can own or fix

### 19. `seo.items.backlinks.meta_description`

- 한국어: 10년간 1,000여 개의 SEO 프로젝트를 성공적으로 수행하며 얻은 검색엔진최적화에 대한 깊은 이해와 경험을 바탕으로 제공하는 전문 백링크 서비스로 검색엔진 상위노출을 경험하세요. 구글과 네이버에 최적화된 검증된 고품질 백링크 전략은 자연스러운 순위 상승을 돕습니다. 무료 컨설팅을 신청하세요.
- 이전: Backlink strategy informed by 10 years and over 1,000 SEO projects, with page, source and anchor reviews for Google and NAVER. Ask for a free consultation.
- 새 번역: Our specialist backlink service draws on deep SEO knowledge gained from successfully delivering over 1,000 SEO projects in 10 years. Our proven, quality backlink strategies for Google and NAVER — Korea's largest search portal — support natural ranking improvements. Request a free consultation.

### 20. `seo.items.naver-shopping.meta_description`

- 한국어: 네이버쇼핑 상위노출 마케팅을 위한 SEO는 제이커브에게 맡기세요! 10년 이상 풍부한 노하우로 상품 노출 극대화, 클릭률 향상, 매출 증대를 실현시켜 드립니다.
- 이전: NAVER Shopping SEO informed by over 10 years of experience, covering product data, images and pages to improve discovery and purchase decisions.
- 새 번역: Trust J-Curve with SEO for higher NAVER Shopping rankings. We draw on over 10 years of experience to maximize product visibility, improve click-through rates and grow sales.

## 5. 확신이 낮거나 추가 검수가 필요한 명칭

| 원문 | 적용한 표현 | 검수할 점 |
|---|---|---|
| 준실버 DB / 실버 DB | Semi-silver leads / Silver leads | 공급사별 등급 명칭이다. 원문에 등급별 상세 정의가 없어 품질 수준을 새로 설명하지 않았다. 업체가 사용하는 확정 영문 명칭이 있는지 확인 필요. |
| 확정 DB | Confirmed leads | 고유 상품 유형을 옮긴 것이며 미팅·계약 확정을 뜻하지 않는다. 그 비보장 고지는 같은 페이지에 유지했다. 공급사 용어 확정 시 검토 가능. |
| 퍼미션콜 | consent verification calls | 실제 캠페인의 확인 범위가 다르므로 단순 상담이나 포괄 동의로 바꾸지 않았다. 업체 내부에서 쓰는 영문 명칭이 따로 있는지 최종 검수 대상. |
| GA | general insurance agencies | 외국 기업 담당자가 이해하도록 업종 문맥으로 풀었다. 법적 사업자 유형의 새 정의를 추가하지 않았다. |

외부 확인 없이 한국어 원문과 용어집만으로 번역했다. 위 명칭의 불확실성을 감추기 위한 의미 추가는 하지 않았다.

## 6. 외부 요청 0 근거와 실행 명령 인벤토리

**외부 번역 서비스 0회, API 호출 0회, 웹·브라우저 요청 0회.** 번역은 한국어 배열을 직접 읽고 Codex가 문장별로 작성했다. 기존 영어는 키·구조와 검수용 ‘이전’ 스냅샷에만 사용했다. 번역 단계에 HTTP 클라이언트·웹 도구·번역 패키지·네트워크 명령을 쓰지 않았다.

사용한 실행 표면은 로컬 `exec_command`, 로컬 런타임 함수, 파일 편집용 `apply_patch`, 테스트 프로세스 출력 회수용 `write_stdin`이다. context-mode 로컬 실행 도구는 승인 정책 오류로 실행되지 않아 로컬 명령으로 확인을 이어갔다.

중복 실행을 합친 명령 목록:

- 규칙·지시서: `cat /Users/anarchy/.agents/skills/tri-agent-orchestration/SKILL.md`, `cat docs/intl/SPEC-CODEX-INTL-04.md`, `cat docs/COLLAB.md docs/collab/QUEUE.md`, `cat docs/intl/GLOSSARY.md docs/intl/INTL-PLAN.md`, `sed -n '14,25p' docs/collab/QUEUE.md`.
- 로컬 이력 검색: 메모리 레지스트리에 `rg -n -i 'jcurve|INTL-04|i18n'` 검색. 관련 번역 이력은 없어 작업의 사실 근거로 사용하지 않았다.
- 범위·크기 확인: `python3`로 현재 worktree의 AGENTS 파일과 해당 하위 AGENTS 존재 여부, 원문·영문·계획 문서의 행 수·크기를 확인했다.
- 말투 확인: `cat`으로 영어 home/company/contact/rankfree/marketing-support/self-marketing, `python3`로 같은 영어·일본어 파일의 제목·설명 등을 확인했다.
- 원문·구조: `sed -n '1,240p' config/subpages.php`, `sed -n '1,190p' config/subpages.php`, `sed -n '1,200p' lang/en/subpages.php`, `cat lang/en/subpages.php`.
- 전후 배열 추출:
  `php -r 'echo json_encode(["ko"=>require "config/subpages.php", "before"=>require "lang/en/subpages.php"], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR);'`
- 전체 원문 판독: 위 한국어 배열의 모든 사람용 문자열을 경로·페이지별로 출력해 직접 번역했다. 1,026개 경로의 누락 여부를 로컬 함수로 비교해 0개를 확인했다.
- 테스트 환경 확인: `cat phpunit.xml tests/TestCase.php`, `cat artisan bootstrap/app.php tests/Support/intl_snapshot.php`, Laravel TestCase와 LoadEnvironmentVariables의 `sed` 조회, Collision TestCommand의 `sed` 조회, `php --ini`.
- 테스트 환경 검색: Laravel Application/Kernel/TestCase의 bootstrap 메서드에 대한 `rg -n`, 테스트 파일의 HTTP·fake·소켓 관련 `rg -n`, 기존 INTL 결과 문서와 테스트 명령의 환경 로딩 관련 `rg -n`. 이 검색 중 존재하지 않는 Laravel TestCommand 경로 한 건이 보고돼 실제 Collision 경로를 확인했다. 제품 코드 변경은 없다.
- 구현 점검: `php /private/tmp/intl-04a-check.php`, `php -l lang/en/subpages.php`, `./vendor/bin/pint --test lang/en/subpages.php`, 위 전체 테스트 명령.
- 스냅샷 diff: `python3`로 임시 작업 전 파일과 현재 파일을 difflib 및 행별 비교. 행별 변경 수는 1,050이다.
- 읽기 전용 Git: `git status --short`, `git branch --show-current`, `git rev-parse HEAD`, `git diff --stat -- lang/en/subpages.php`, `git diff --numstat -- lang/en/subpages.php`, `git diff -- lang/en/subpages.php`, `git diff --check -- lang/en/subpages.php`, `git log -1 --format='%H %s' -- lang/en/subpages.php`.

임시 비교·테스트 파일은 `/private/tmp/intl-04a-baseline.json`, `/private/tmp/intl-04a-before.php`, `/private/tmp/intl-04a-check.php`, `/private/tmp/intl-04a-runtime/`에만 만들었다. 수정한 저장소 파일은 제품 파일 하나와 이 반환물뿐이다. 공유 중인 다른 세션의 파일, 요청 큐, 대시보드, 원문, 미디어, 환경 파일은 수정하지 않았다. 커밋·스테이징·푸시·배포 명령을 실행하지 않았다.

## 7. 미검증·인수인계

- 별도 세션의 독립 번역 검수와 Claude의 최종 합격 판정.
- 실제 브라우저의 모바일·데스크톱 줄바꿈 및 긴 라벨 표시. 이번 세션에서는 외부 요청 금지에 따라 브라우저를 사용하지 않았다.
- 위 공급사별 리드 등급 명칭의 확정 영문 표기.
- 실제 DB, 실외부 서비스, 서버 반영·배포는 실행하지 않았다.
