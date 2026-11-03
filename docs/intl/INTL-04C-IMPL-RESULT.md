# INTL-04C 구현 결과

- 작업 ID: INTL-04C / 구현 세션
- 작업일: 2026-11-03
- 작업 폴더: `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`
- 담당: Codex — 지정된 번역 파일 4개 구현 및 지시서의 구현 점검. 별도 검증 세션·Claude의 최종 검수 판정은 포함하지 않음.
- 한국어 원문과 연결 데이터에서 문장 단위로 직접 번역. 외부 번역 서비스·API·웹 요청 **0회**.
- 커밋·푸시·배포 없음. 04A·04B·04D·03B·검증 세션의 파일, 한국어 뷰·데이터, 공용 큐·대시보드는 수정하지 않음.

## 1. 변경 범위와 문자열 수

| 파일 | 사람이 읽는 문자열 | 실제 번역 값 변경 | 동일 유지 |
|---|---:|---:|---:|
| `lang/en/pages/faq.php` | 274 | 181 | 93 |
| `lang/en/pages/privacy.php` | 14 | 10 | 4 |
| `lang/ja/pages/faq.php` | 274 | 192 | 82 |
| `lang/ja/pages/privacy.php` | 14 | 9 | 5 |
| 합계 | 576 | **392** | 184 |

- FAQ는 언어별 81문항, 6개 분야. 질문·답변 162개, 관련 페이지명 81개, 분야명 6개, 화면·접근성·검색·메타 문구 25개로 언어별 274개.
- 개인정보처리방침은 언어별 14개. 본문·제목·각 조항의 의미를 원문과 대조하고, 이미 정확한 제목·표준 표현·번역 고지는 유지함.
- 위 392개는 작업 직전 파일 스냅샷과 비교하여 **실제로 값이 달라진 문자열 위치 수**. 중복되는 링크명도 각 위치별로 셈. 184개는 SEO·AEO·GEO, 제품명, 이미 정확한 짧은 표현 등으로 동일하게 남음.
- FAQ의 실제 원문: `resources/views/pages/faq.blade.php`, `resources/views/partials/jc/faq-data.php`.
- 개인정보처리방침의 실제 원문: `resources/views/pages/privacy.blade.php`.
- 기존 번역은 키·배열·라우트 계약과 이전/이후 대조에만 사용. 수집 가능성, 동의 범위, 보장 부정, 결과 변동 조건을 삭제하거나 강화하지 않음.

## 2. 자동 점검 1~5

작업 직전 사본: `/private/tmp/intl-04c-baseline/{en,ja}-{faq,privacy}.php`.

직접 작성한 로컬 검사 스크립트: `/private/tmp/intl-04c-audit.py`. PHP 배열을 실행해 모든 문자열의 경로를 추출하고, 키 순서·배열 형태·값 자료형을 비교함. PHP 문자열 토큰 중 사람이 읽는 값만 마스킹한 원문 바이트도 비교하여 키·라우트·아이콘·빈 배열·들여쓰기·구문 보존을 함께 확인함.

실행 명령:

```sh
python3 /private/tmp/intl-04c-audit.py
git diff --numstat -- lang/en/pages/faq.php lang/ja/pages/faq.php lang/en/pages/privacy.php lang/ja/pages/privacy.php
git diff --check -- lang/en/pages/faq.php lang/ja/pages/faq.php lang/en/pages/privacy.php lang/ja/pages/privacy.php
```

실제 검사 결과의 집계 출력(`runpy.run_path`로 같은 검사 결과를 읽어 출력):

```text
181	181	lang/en/pages/faq.php
7	7	lang/en/pages/privacy.php
192	192	lang/ja/pages/faq.php
7	7	lang/ja/pages/privacy.php
hangul=0
structure=0
nonhuman=0
skeleton=0
numbers=0
address_changes=0
machine_terms=0
html_changes=0
readable=576
changed=392
nonhuman_values=230
numeric_checked=572
ratio_checked=572
ratio_outliers=17
source_absent=4
```

`git diff --check`: 출력 없음, exit 0.

1. **한글 0건**: 화면 문구·접근성 문자열·질문·답변·링크명·개인정보처리방침의 모든 표시 문자열을 검사. HTML 속성을 포함한 문자열 전체를 대상으로 검사함.
2. **키·구조·비표시 값 변경 0건**: 언어별 FAQ의 아이콘·라우트·slug 등 115개, 합계 230개 보존. 사람이 읽는 문자열만 마스킹한 PHP 소스 비교도 차이 0. HTML 태그·속성 변경 0.
3. **한국어 원문 대비 숫자 토큰 차이 목록: `[]`**. 직접 원문에 대응하는 572개 문자열을 전부 비교함. 무료 순위체크 `100`, 월 분석 `5`, `301`, `1:1`, 조항 번호 `1~4`, 연락처 `02-1668-2612` 보존. 이메일·전화번호는 작업 전후 별도로 비교하여 차이 0. 억·만 단위 환산은 이 범위에 없음.
4. **기계번역 흔적 검색 결과: `[]`**. 일본어 `ペット / オペレーティングシステム / 地面 / グラウンド / カウンセリング / インフロー`, 영어 `operating system / material / top exposure / inflow / counseling / remodeling` 검색. 예외 0건.
5. **길이 비율 572개 검사, 이상치 17개**. Unicode 문자 수 기준이며 아래에 각 위치별 검토를 남김.

한국어 원문에 별도 문자열이 없는 기존 필드는 개인정보처리방침의 `description`과 `translation_notice`, 양 언어 합계 4개임. 메타 설명은 본문에 있는 항목만 요약했고, 한국어 원문 우선 고지는 작업 전 문구를 그대로 유지함. 이 4개에는 숫자 토큰이 없으며, 한글·구조·주소·금칙어 검사는 동일하게 적용함. 직접 원문이 없으므로 숫자/길이 비교 분모에는 포함하지 않음.

### 길이 이상치 전수 검토

| 언어·키 | 번역/원문 비율 | 판정 | 근거 |
|---|---:|---|---|
| `en:empty_before` | 42.000 | 정상 | 검색어 앞뒤로 나뉘는 문장. 영어 어순에 맞춰 안내를 앞 칸으로 옮김. 두 칸 결합 시 원문 19자·번역 44자(2.316배)로 의미 누락·추가 없음. |
| `en:empty_after` | 0.111 | 정상 | 검색어 앞뒤로 나뉘는 문장. 영어 어순에 맞춰 안내를 앞 칸으로 옮김. 두 칸 결합 시 원문 19자·번역 44자(2.316배)로 의미 누락·추가 없음. |
| `en:categories.start.label` | 6.200 | 정상 | 짧은 한국어 분야명을 자연스러운 영어 명사구로 옮김. |
| `en:categories.ads.label` | 5.500 | 정상 | 2자 광고의 표준 영어 Advertising. |
| `en:categories.build.items.5.from.1` | 6.000 | 정상 | GLOSSARY §3의 지정 표기 Korean government SME marketing support programs를 따름. 자격·선정·지급 보장 추가 없음. |
| `en:categories.build.items.6.from.1` | 6.000 | 정상 | GLOSSARY §3의 지정 표기 Korean government SME marketing support programs를 따름. 자격·선정·지급 보장 추가 없음. |
| `en:categories.build.items.7.from.1` | 6.000 | 정상 | GLOSSARY §3의 지정 표기 Korean government SME marketing support programs를 따름. 자격·선정·지급 보장 추가 없음. |
| `en:categories.build.items.8.from.1` | 6.000 | 정상 | GLOSSARY §3의 지정 표기 Korean government SME marketing support programs를 따름. 자격·선정·지급 보장 추가 없음. |
| `en:categories.build.items.9.from.1` | 6.000 | 정상 | GLOSSARY §3의 지정 표기 Korean government SME marketing support programs를 따름. 자격·선정·지급 보장 추가 없음. |
| `ja:home` | 3.000 | 정상 | 1자 홈의 표준 일본어 ホーム. |
| `ja:categories.self.items.7.from.1` | 3.000 | 정상 | GLOSSARY §5의 제품명 BoostingShop을 로마자로 유지. 새 기능이나 실적 추가 없음. |
| `ja:categories.self.items.8.from.1` | 3.000 | 정상 | GLOSSARY §5의 제품명 BoostingShop을 로마자로 유지. 새 기능이나 실적 추가 없음. |
| `ja:categories.self.items.9.from.1` | 3.000 | 정상 | GLOSSARY §5의 제품명 BoostingShop을 로마자로 유지. 새 기능이나 실적 추가 없음. |
| `ja:categories.self.items.10.from.1` | 3.000 | 정상 | GLOSSARY §5의 제품명 BoostingShop을 로마자로 유지. 새 기능이나 실적 추가 없음. |
| `ja:categories.self.items.11.from.1` | 3.000 | 정상 | GLOSSARY §5의 제품명 BoostingShop을 로마자로 유지. 새 기능이나 실적 추가 없음. |
| `ja:categories.self.items.12.from.1` | 3.000 | 정상 | GLOSSARY §5의 제품명 BoostingShop을 로마자로 유지. 새 기능이나 실적 추가 없음. |
| `ja:categories.self.items.13.from.1` | 3.000 | 정상 | GLOSSARY §5의 제품명 BoostingShop을 로마자로 유지. 새 기능이나 실적 추가 없음. |

17개 모두 의미 누락·근거 없는 내용 추가가 없는 표기/어순 차이로 확인함. 이는 구현자의 길이 이상치 확인이며 별도 검증 세션의 최종 판정을 대신하지 않음.

## 3. 자동 점검 6 — 실제 실행 출력

### PHP 문법

```sh
php -l lang/en/pages/faq.php
php -l lang/ja/pages/faq.php
php -l lang/en/pages/privacy.php
php -l lang/ja/pages/privacy.php
```

```text
No syntax errors detected in lang/en/pages/faq.php
No syntax errors detected in lang/ja/pages/faq.php
No syntax errors detected in lang/en/pages/privacy.php
No syntax errors detected in lang/ja/pages/privacy.php
```

### Pint

```sh
./vendor/bin/pint --test lang/en/pages/faq.php lang/ja/pages/faq.php lang/en/pages/privacy.php lang/ja/pages/privacy.php
```

```json
{"tool":"pint","result":"passed"}
```

exit 0. 최종 일본어 고유명사 첫 등장 위치를 정리한 후에도 위 4개 파일을 다시 검사함.

### 전체 Laravel 테스트

프로젝트의 `.env`를 열람·로딩하지 않도록 임시 bootstrap에서 Laravel 환경 파일 로더만 건너뜀. 애플리케이션·테스트·phpunit.xml 파일은 수정하지 않음. `--env=testing`을 명시해 artisan test의 환경 파일 재조회도 건너뜀. 설정 캐시·컴파일 뷰는 이 세션 전용 임시 경로, DB는 명령 단위 `:memory:` SQLite. 실제 DB와 다른 세션의 SQLite를 사용하지 않음.

임시 파일 `/private/tmp/intl-04c-test-bootstrap.php`:

```php
<?php

require_once '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/vendor/autoload.php';

// Keep both artisan and PHPUnit from loading any project .env file.
final class Intl04CNoEnvironment
{
    public function bootstrap($app): void {}
}

if (! class_exists('Illuminate\\Foundation\\Bootstrap\\LoadEnvironmentVariables', false)) {
    class_alias(Intl04CNoEnvironment::class, 'Illuminate\\Foundation\\Bootstrap\\LoadEnvironmentVariables');
}
```

실행 명령:

```sh
mkdir -p /private/tmp/intl-04c-compiled
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= APP_CONFIG_CACHE=/private/tmp/intl-04c-no-config.php VIEW_COMPILED_PATH=/private/tmp/intl-04c-compiled DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= CACHE_STORE=array SESSION_DRIVER=array QUEUE_CONNECTION=sync MAIL_MAILER=array php -d auto_prepend_file=/private/tmp/intl-04c-test-bootstrap.php artisan test --env=testing --bootstrap=/private/tmp/intl-04c-test-bootstrap.php --do-not-cache-result --no-ansi
```

실제 출력:

```json
{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":36116}
```

exit 0. 실패 테스트 없음. 테스트의 외부 HTTP 관련 경로는 기존 `Http::fake`·`Http::preventStrayRequests`를 사용하는 모의 경로임.

`IntlInsightSeeder` 2회 실행·`intl:stale` 검사는 04D/04E 블로그 전용 조건으로 이 세션에는 적용하지 않음.

## 4. 한국어 · 이전 번역 · 새 번역 20쌍

직전 스냅샷과 최종 파일의 실제 값을 그대로 기재함.

| # | 파일·키 | 한국어 원문 | 이전 번역 | 새 번역 |
|---|---|---|---|---|
| 1 | `en/faq:categories.start.items.1.a` | 가능합니다. 다만 채널을 많이 여는 것보다 전환 정의와 측정 기준을 먼저 통일해야 합니다. 기반이 맞으면 유료 광고의 학습을 SEO·웹사이트·리워드 캠페인으로 연결할 수 있습니다. | Yes. We first align conversion definitions and measurement criteria. Once that foundation is in place, learning from paid ads can inform SEO, your website and reward campaigns. | Yes. Before adding more channels, we need to align conversion definitions and measurement criteria. With that foundation in place, we can apply what paid ads teach us to SEO, your website and reward campaigns. |
| 2 | `en/faq:categories.ads.items.7.a` | 중복, 필수 항목 오류, 연락 가능 여부, 동의 범위 등 캠페인 전에 합의한 승인·반려 기준으로 판단합니다. 업종과 액션에 따라 기준은 달라질 수 있습니다. | We use approval and rejection criteria agreed before launch, including duplicates, required-field errors, contactability and consent scope. Criteria vary by industry and action. | We assess them against acceptance and rejection criteria agreed before the campaign, including duplicates, errors in required fields, whether the person can be contacted and the scope of consent. Criteria may vary by industry and action. |
| 3 | `en/faq:categories.ads.items.15.a` | 중복 참여, 필수 조건 미충족, 취소·환불, 비정상 패턴처럼 캠페인별 무효 기준과 필요한 증빙을 집행 전에 합의합니다. 기준을 집행 중 임의로 바꾸지 않는 것이 중요합니다. | Before launch, we agree on campaign-specific invalidity rules and evidence, covering duplicates, unmet conditions, cancellations, refunds and abnormal patterns. Rules should not change arbitrarily during delivery. | Before launch, we agree on campaign-specific invalidation criteria and required evidence, such as duplicate participation, unmet requirements, cancellations or refunds, and abnormal patterns. These criteria should not be changed arbitrarily while a campaign is running. |
| 4 | `en/faq:categories.search.items.3.a` | 아닙니다. 정보 접근성, 엔티티의 명확성, 근거와 출처의 일관성을 개선해 답변 시스템이 참고할 가능성을 높이는 작업입니다. 최종 노출과 인용은 각 검색·생성 시스템이 결정합니다. | No. We improve information access, entity clarity and consistent evidence and sources so answer systems can more readily reference your content. Each search or generative system decides final visibility and citations. | No. They improve information accessibility, clarity about entities, and consistency of evidence and sources to increase the likelihood that answer systems will refer to your content. Each search or generative system decides what to display and cite. |
| 5 | `en/faq:categories.search.items.8.a` | 질문군별 검색 노출과 클릭, 해당 페이지의 행동·전환, 표본 검색 결과에서의 답변 노출과 출처를 함께 기록합니다. 표본 결과가 전체 사용자 결과를 대표한다고 단정하지 않습니다. | We record impressions and clicks by question group, page behavior and conversions, plus answer visibility and sources in sample results. We do not assume samples represent every user’s results. | We record search visibility and clicks by question group, actions and conversions on the relevant pages, and answer visibility and sources in sampled search results. We do not assume that sampled results represent what all users see. |
| 6 | `en/faq:categories.self.items.1.a` | 아닙니다. 자체 수집·분석 기반의 추정 정보이며 네이버의 승인이나 보증을 의미하지 않습니다. | No. They are estimates based on our own collection and analysis, and do not mean approval or endorsement by NAVER, Korea’s largest search portal. | No. These are estimates based on our own data collection and analysis. They do not imply approval or endorsement by NAVER — Korea's largest search portal. |
| 7 | `en/faq:categories.crm.items.0.a` | 보험DB를 비교·구매하고 조직 내 담당자에게 배분해 상담·계약·AS·정산 상태를 관리하는 영업조직, 설계사와 대리점을 위한 CRM입니다. | It is a CRM for insurance sales teams, advisers and agencies that compare and buy insurance leads, assign them internally, and manage consultations, contracts, after-sales support and settlement. | It is a CRM for sales organizations, insurance agents and agencies that compare and purchase insurance leads, assign them to team members, and manage consultation, contract, after-sales support and settlement status. |
| 8 | `en/faq:categories.build.items.5.a` | 지원사업의 모집 여부와 자격은 시기와 기관별 공고에 따라 달라집니다. 상담 시 기업 정보와 공고문을 기준으로 마케팅 과업의 적합성을 검토하며, 최신 모집 상태와 신청 자격은 운영기관의 공식 안내를 우선 확인해야 합니다. | Applications and eligibility vary by date and the administering organization’s notice. We review marketing-task fit against your company information and the notice. Current availability and eligibility must be confirmed through official guidance. | Application availability and eligibility vary by timing and each institution’s announcements. During a consultation, we review whether the marketing tasks fit your company information and the program notice. Check the administering institution’s official guidance first for current application status and eligibility. |
| 9 | `ja/faq:categories.ads.items.13.a` | 연동 방식은 앱 구조와 운영 범위에 따라 달라집니다. 기존 지면, 웹뷰, 서버 연동 가능 여부와 보상 처리 구조를 확인한 뒤 개발 범위와 테스트 절차를 합의합니다. | 連携方法は、アプリの構造と動作範囲によって異なります。既存の地面、Webビュー、サーバー連携可能性、および補償処理構造を確認し、開発範囲とテスト手順を合意します。 | 連携方法は、アプリの構造と運用範囲によって異なります。既存の広告枠、WebView・サーバー連携の可否、報酬処理の仕組みを確認してから、開発範囲とテスト手順を合意します。 |
| 10 | `ja/faq:categories.ads.items.16.a` | 목표 액션, 희망 일정과 예산 범위, 랜딩 또는 앱 링크, 전환 확인 방식, 제한 조건, 소재와 브랜드 가이드를 준비하면 됩니다. 준비되지 않은 항목은 상담에서 체크리스트로 정리합니다. | 目標アクション、希望のスケジュールと予算の範囲、ランディングまたはアプリリンク、コンバージョン確認方法、制約、クリエイティブとブランドガイドを準備できます。準備ができていない項目は、カウンセリングでチェックリストにまとめます。 | 目標アクション、希望日程と予算の範囲、ランディングページまたはアプリのリンク、コンバージョンの確認方法、制約条件、クリエイティブ、ブランドガイドを準備してください。未準備の項目は、相談時にチェックリストにまとめます。 |
| 11 | `ja/faq:categories.ads.items.17.a` | 서비스와 이용자 특성, 월간 활성 이용 규모, 희망 지면, 리워드 정책, 개발 환경, 운영·CS·정산 담당 체계를 확인합니다. 그 결과를 바탕으로 연동 가능 범위와 순서를 정합니다. | サービスと利用者特性、月間アクティブ利用規模、希望地面、リワード政策、開発環境、運営・CS・精算担当体系を確認します。その結果に基づいて連動可能範囲と順序を決めます。 | サービスと利用者の特性、月間アクティブユーザー数、希望する広告枠、リワード方針、開発環境、運用・カスタマーサポート・精算の担当体制を確認します。その結果に基づき、連携可能な範囲と順序を決めます。 |
| 12 | `ja/faq:categories.crm.items.8.q` | AI 콜 품질 분석이 상담을 정확히 평가하나요? | AIコール品質分析は、カウンセリングを正確に評価しますか？ | AIによる通話品質分析は、相談対応を正確に評価しますか。 |
| 13 | `ja/faq:categories.crm.items.9.a` | AI 결과만으로 중요한 평가를 확정하는 방식은 오류와 맥락 누락 위험이 있습니다. 평가 기준을 공개하고 사람이 원자료를 검토하는 절차를 두어야 합니다. | AIの結果だけで重要な評価を確定する方法は、エラーと文脈の欠落のリスクがあります。評価基準を開示し、人が原料を見直すための手続きが必要です。 | AIの結果だけで重要な評価を確定すると、誤りや文脈の見落としが生じるリスクがあります。評価基準を公開し、人が元データを確認する手順を設ける必要があります。 |
| 14 | `ja/faq:categories.build.items.8.a` | 아닙니다. 인정되는 비용, 자부담, 집행 기간, 공급기업 요건과 증빙 방식은 사업마다 다릅니다. 계약이나 집행 전에 운영기관의 공고·협약·지침을 확인해야 합니다. | いいえ。認められる費用、自己負担、執行期間、サプライヤーの要件と証明方法は、事業によって異なります。契約や執行前に運営機関の公告・条約・指針を確認しなければなりません。 | いいえ。対象となる費用、自己負担、支出期間、供給企業の要件、証明方法は、事業ごとに異なります。契約や支出の前に、運営機関の公募・協約・指針を確認する必要があります。 |
| 15 | `ja/faq:categories.build.items.3.q` | 워드프레스로 만들면 검색 상위 노출이 보장되나요? | WordPressで作成すると、検索上位インプレッションは保証されますか？ | WordPressで制作すれば、検索上位表示は保証されますか。 |
| 16 | `ja/faq:categories.crm.items.7.a` | 원천 DB를 상담원에게 배분해 보험DB를 생산하고 고객사에 수주·납품·AS·정산하는 콜센터 운영조직을 위한 CRM입니다. | 元リードをエージェントに配分して保険リードを生産し、お客様に受注・納品・アフターサポート・精算するコールセンター運営組織のためのCRMです。 | 元となるリードを相談員に配分して保険リードを生成し、顧客企業からの受注・納品・アフターサポート・精算を行う、コールセンター運営組織向けのCRMです。 |
| 17 | `en/privacy:introduction` | (주)제이커브인터렉티브(이하 "회사")는 이용자의 개인정보를 중요하게 생각하며, 「개인정보 보호법」 등 관련 법령을 준수합니다. | J-Curve Interactive Co., Ltd. (the “Company”) values your personal information and complies with applicable laws, including Korea’s Personal Information Protection Act. | J-Curve Interactive Co., Ltd. (the “Company”) values users’ personal information and complies with applicable laws and regulations, including Korea’s Personal Information Protection Act. |
| 18 | `en/privacy:sections.2.1` | 원칙적으로 개인정보 수집·이용 목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 관련 법령에 따라 보존할 필요가 있는 경우 해당 기간 동안 보관합니다. | In principle, we destroy personal information without delay once the purpose of collection and use has been fulfilled. If applicable laws require retention, we keep it for the required period. | In principle, the personal information concerned is destroyed without delay after the purposes of collection and use have been achieved. However, where retention is necessary under applicable laws and regulations, the information is retained for the applicable period. |
| 19 | `ja/privacy:introduction` | (주)제이커브인터렉티브(이하 "회사")는 이용자의 개인정보를 중요하게 생각하며, 「개인정보 보호법」 등 관련 법령을 준수합니다. | J-Curve Interactive株式会社（以下「当社」）は、利用者の個人情報を大切にし、韓国の「個人情報保護法」などの関連法令を遵守します。 | J-Curve Interactive Co., Ltd.（以下「当社」といいます。）は、利用者の個人情報を重視し、韓国の「個人情報保護法」等の関連法令を遵守します。 |
| 20 | `ja/privacy:sections.2.1` | 원칙적으로 개인정보 수집·이용 목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 관련 법령에 따라 보존할 필요가 있는 경우 해당 기간 동안 보관합니다. | 原則として、個人情報の収集・利用目的を達成した後は、当該情報を遅滞なく破棄します。ただし、関連法令により保存が必要な場合は、定められた期間保管します。 | 原則として、個人情報の収集・利用目的が達成された後は、当該情報を遅滞なく破棄します。ただし、関連法令に基づき保存する必要がある場合は、該当する期間保管します。 |

## 5. 용어·법률 표현 확인 사항

- **추가 확인이 필요한 미해결 번역 용어: 없음.** 아래는 최종 검수자가 확인할 수 있도록 남기는 선택 근거임.
- 리드 승인·반려: 영어 `acceptance / rejection`, 일본어 `有効認定 / 却下`. 애완동물·상품 반품 의미가 아님.
- 광고 지면: 영어 `ad placements`, 일본어 `広告枠`. 운영 담당 체계는 `who handles operations…` / `担当体制`로 옮김.
- 원천 DB: `source leads` / `元となるリード`. 이미 동의를 받았거나 적법하다는 뜻을 추가하지 않음. 적법성·동의·용도 확인 책임에 관한 원문 고지는 모두 유지함.
- AS: GLOSSARY의 `after-sales support` / `アフターサポート`. 구체적인 환불·교환·처리 기한을 새로 정의하지 않음.
- 지원사업 협약: 영어 `agreement`, 일본어 `協約`. 국가 간 조약이라는 뜻의 `条約`을 사용하지 않음.
- 한국 플랫폼: FAQ의 NAVER 첫 설명은 GLOSSARY §4의 `NAVER — Korea's largest search portal` / `NAVER（韓国最大の検索ポータル）`를 각각 한 번만 사용. 일본어 제품명 가나도 각 첫 등장에 한 번만 사용.
- 개인정보처리방침: `수집할 수 있습니다`의 가능성, 수집 목적 4개, `원칙적으로`, 목적 달성 후 `지체 없이` 파기, 법령상 보존 필요 시 해당 기간 보관, 법령·회사 정책에 따른 변경 및 웹사이트 공지를 모두 보존함.
- 회사 법인 표기는 `(주)`에 대응하는 `Co., Ltd.`를 사용하고, 한국의 개인정보 보호법임을 명확히 함. 실제 등록 영문 법인명 검증이나 정책의 법적 적정성 판단은 이번 번역 작업의 범위가 아님.
- 보유기간의 구체적인 연수, 제3자 제공·국외 이전·처리위탁 등 한국어 원문에 없는 조항을 추가하지 않음. 연락처·이메일은 원문 그대로임.

## 6. 외부 요청 0 근거와 실행 명령 목록

번역은 한국어 뷰·데이터를 읽고 직접 작성함. 번역 API·검색·브라우저·웹 도구·패키지 설치를 사용하지 않았고, `curl`·`wget`·HTTP 파일 읽기·외부 번역 스크립트를 실행하지 않음.

실제로 사용한 명령 종류와 대상:

| 명령/도구 | 용도·대상 | 외부 웹 요청 |
|---|---|---:|
| `cat`, `sed -n` | 지시서 전체, GLOSSARY, COLLAB, QUEUE, 한국어 뷰, 기존 번역, 로컬 skill·phpunit.xml 읽기 | 0 |
| `rg -n`, `rg --files` | 로컬 작업 규칙·파일 탐색, 메모리 키워드 확인 | 0 |
| `pwd`, `git status --short` | 작업 폴더·동시 작업 상태 확인 | 0 |
| `python3 - <<'PY'` | INTL-PLAN §1·§5 추출, 본보기 문구·테스트 HTTP 모의 및 환경 부트스트랩 확인, 개인정보 원문 추출, 고유명사 빈도 확인 | 0 |
| `php -r` | 한국어 FAQ route stub을 통한 데이터 읽기, 번역 PHP 배열·문자열 추출. Laravel·DB 미부팅 | 0 |
| `mkdir -p`, `cp` | `/private/tmp/intl-04c-baseline`에 지정 4개 파일 사전 사본, 전용 컴파일 뷰 경로 생성 | 0 |
| `apply_patch` | 지정 번역 4개, 본 결과 문서, `/private/tmp` 전용 검사·테스트 bootstrap 작성 | 0 |
| `python3 /private/tmp/intl-04c-audit.py` 및 `runpy.run_path` 집계 | 점검 1~5, 모든 길이 이상치·숫자·구조·주소 비교 | 0 |
| `php -l` | 지정 PHP 4개 문법 검사 | 0 |
| `./vendor/bin/pint --test …` | 지정 PHP 4개 스타일 검사 | 0 |
| 위 전체 `php … artisan test …` 명령 | 환경 파일 로딩 차단, 메모리 DB 전체 테스트 | 0 |
| `git diff --numstat`, `git diff --check`, `git diff --quiet -- <한국어 파일>` | 변경량·공백 오류·한국어 원문 미변경 확인 | 0 |

context-mode의 로컬 실행 도구 2회 시도는 `MCP tool call requires approval, but approval policy is never`로 실행되지 않음. 이후 로컬 PHP·Python 명령으로 동일한 읽기·점검을 수행함. 외부 번역이나 웹 조회로 우회하지 않음.

한국어 파일 미변경 확인의 실제 출력:

```text
resources/views/pages/faq.blade.php unchanged
resources/views/pages/privacy.blade.php unchanged
resources/views/partials/jc/faq-data.php unchanged
```

고유명사 설명 중복 검사의 실제 출력:

```text
ブースティングショップ 1
リードベイ 1
コールトゥセール 1
韓国最大の検索ポータル 1
ランクフリー 1
```

## 7. 미검증·인수인계

- 브라우저에서의 실제 문장 줄바꿈·검색 동작·반응형 시각 검수는 이번 세션에서 실행하지 않음.
- 별도 검증 세션과 Claude의 최종 번역·법률 문구 대조 판정은 미실시. 이 문서는 구현 반환물임.
- 개인정보처리방침의 원문 자체에 대한 법률 자문, 실제 영문 법인명, 운영 서비스의 실제 개인정보 흐름은 검증하지 않음.
- 실DB·운영 환경·실서버는 열거나 변경하지 않음. 커밋·푸시·배포·공개 발행 없음.
- 임시 검사 스크립트·사전 사본은 `/private/tmp/intl-04c-*` 경로에 있으며 저장소 변경 파일에 포함하지 않음.

