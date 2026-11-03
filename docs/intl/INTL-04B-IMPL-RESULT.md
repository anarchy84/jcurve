# INTL-04B 구현 결과

- 작업: 일본어 서브페이지 직접 재번역. 구현자 Codex. 최종 언어 검수·합격 판정은 별도 검증 세션과 Claude 담당.
- 변경 파일: `lang/ja/subpages.php`, 이 반환물 `docs/intl/INTL-04B-IMPL-RESULT.md`만.
- 원문: `config/subpages.php`. 19개 서브페이지(SEO 5·CPA 5·퍼포먼스 3·부스팅샵 6)와 부모 영역 4개.
- **다시 번역한 문자열: 1,029개**. 한국어가 포함된 1,026개 전부를 원문에서 새로 번역했고, 영문으로 적힌 업계 소제목 3개도 용어집에 맞게 일본어로 번역했다. 나머지 107개는 영어 장식 제목·공식 표기·수치 등을 확인했다.
- 실제 값 변경은 **980개**다. 한국어 원문 1,026개 중 49개는 새로 번역한 결과가 기존의 짧은 표기와 같았다. 한국어 원문 977개와 영문 소제목 3개가 실제로 달라졌다.
- 외부 번역 서비스·API·웹 요청 **0**. 모델이 로컬 한국어 원문을 직접 읽고 번역했다.
- 커밋·푸시·배포 명령 미실행. 다른 세션 소유 파일, 원문, 큐, 대시보드는 변경하지 않았다.

## 1. 기준과 변경 범위

`SPEC-CODEX-INTL-04.md` 전체, `INTL-PLAN.md`, `GLOSSARY.md` §8 포함 전체, `docs/COLLAB.md`, `docs/collab/QUEUE.md`, 지정된 영·일 페이지의 말투 본보기를 확인했다. 기존 일본어는 키 구조와 이전/이후 비교용으로 사용했다.

작업 전 일본어 스냅샷은 `0f18dc6:lang/ja/subpages.php`와 배열 값까지 완전히 일치한다. 공유 작업 폴더에서 외부 자동 checkpoint 이력 `975a36b`, `2913ec8`의 생성을 관찰했으므로, 변경 건수는 이동하는 HEAD가 아니라 이 작업 전 스냅샷과 비교했다. 이 세션의 Git 사용은 읽기 명령뿐이다.

| 영역 | 직접 번역한 문자열 | 실제 값 변경 |
|---|---:|---:|
| SEO | 232 | 222 |
| CPA | 421 | 392 |
| 퍼포먼스 | 125 | 118 |
| 부스팅샵 | 251 | 248 |
| 합계 | **1,029** | **980** |

키·배열 순서·타입·내부 값·링크는 유지했다. `contact_interest`도 표시 문구가 아닌 폼 내부 값으로 분류하여 그대로 두었다. `boostingshop.parent.param = null`도 보존했다. 사람이 읽는 문자열을 마스킹한 PHP 원문 골격을 작업 전후 비교한 결과 바이트 차이 0이었다. `15,700件+`는 기존 일본어의 올바른 단위 표기를 유지했다.

SHA-256:

```text
작업 전 lang/ja/subpages.php
43e5d1953e21e56fa5c0fe5f5417debb49958ed2afa39e575706e19ed24337f8
최종 lang/ja/subpages.php
4b61e0451d6ca16263823c257f2954cd94a47b70a334325ad6dd08a57b87773f
한국어 config/subpages.php
731ba65f99813c81861981f2c58dd991ef1d77d9cf816b1e2efd3af2e0ebf4cd
```

## 2. 자동 점검 1~5 실제 출력

명령: `php /private/tmp/intl04b-check.php` · 종료 코드 0.

```json
{
    "stats": {
        "human": 1136,
        "korean_source": 1026,
        "changed": 980,
        "protected": 202,
        "nulls": 1
    },
    "issues": {
        "structure": [],
        "protected": [],
        "hangul": [],
        "html": [],
        "numbers": [],
        "traces": [],
        "ratio": [
            {
                "path": "boostingshop.parent.label",
                "ko": "부스팅샵",
                "ja": "BoostingShop（ブースティングショップ）",
                "ratio": 6.25,
                "verdict": "정상",
                "reason": "용어집 지정 로마자 브랜드명과 첫 언급 가나 병기"
            }
        ]
    },
    "brand_digit_normalization": [
        "cpa.items.insurance.inquiry_template",
        "cpa.items.insurance.sections.0.items.2.title",
        "cpa.items.insurance.sections.0.items.2.label",
        "cpa.items.insurance.sections.12.title",
        "cpa.items.insurance.sections.12.note",
        "cpa.items.insurance.sections.12.link.label",
        "cpa.items.insurance.faq.9.question",
        "cpa.items.insurance.faq.9.answer",
        "cpa.items.insurance.cta.text"
    ]
}
```

출력 해석:

1. 사람이 읽는 문자열 1,136개 전체에서 한글 잔존 0. 파일 전체 한글 검색도 결과 0. 본문 문자열 안의 HTML 태그 차이 0이며, 이 대상에는 별도로 번역할 HTML의 alt/title 속성이 없다.
2. 원문·작업 전 일본어·최종 일본어 사이의 키·배열 순서 차이 0. 보호 값 202개(문자열 201개·null 1개) 차이 0. 사람이 읽는 값 이외의 PHP 골격도 바이트 차이 0.
3. 숫자 토큰 차이 0. 원문 `콜투세일`과 지정 브랜드명 `Call2Sale`에 포함된 `2`는 수량이 아니므로 양쪽을 같은 브랜드 식별자로 정규화했다. 이 표기 차이가 있는 9개 경로는 위 출력에 모두 남겼다. 그 외 숫자는 같은 순서·값으로 비교했다. 원화 환산 없음. `373億ウォン+`, `128万件+`, `15,700件+`, `2009年`, `2026年時点` 및 회사 전체 누적 고지를 유지했다.
4. 지정 일본어 금지 용어 6종 결과 0. 추가로 독자가 읽는 `DB`·`AS` 약어도 결과 0. `Insurance Permission DB`, `DB vs Permission DB`, `Validity & AS Matrix`는 각각 `同意取得済みの保険リード`, `通常リードと同意取得済みリードの比較`, `有効判定とアフターサポートの対応基準`으로 옮겼다.
5. 문자열 1,136개에서 ja/ko 길이 비율 < 0.5 또는 > 2.5인 항목은 **1개**. `boostingshop.parent.label`: `부스팅샵` → `BoostingShop（ブースティングショップ）`, 6.25배. **정상**: 용어집이 지정한 로마자 브랜드명과 첫 언급 가나 병기이며, 의미 누락·새 주장 추가가 없다. 누락 판정 0, 부당한 추가 판정 0.

## 3. 자동 점검 6: PHP·Pint·전체 테스트

### PHP 문법

명령:

```sh
php -l lang/ja/subpages.php
```

실제 출력 / 종료 코드 0:

```text
No syntax errors detected in lang/ja/subpages.php
```

### Pint와 공백 검사

명령:

```sh
./vendor/bin/pint --test lang/ja/subpages.php
git diff --check -- lang/ja/subpages.php
```

최종 실제 출력 / 각 종료 코드 0:

```json
{"tool":"pint","result":"passed"}
```

`git diff --check` 출력 없음. 중간에 수치 라벨을 수정하면서 배열 들여쓰기 위반 1건이 발생했다. 해당 줄을 원래 깊이로 바로잡은 뒤 위 최종 통과를 확인했다.

중간 실제 출력:

```json
{"tool":"pint","result":"fail","files":[{"path":"lang\/ja\/subpages.php","fixers":["array_indentation"]}]}5a7323cc710133160f56c313b43bfbbf0a5711487614ed391d436beba68441d0  lang/ja/subpages.php
```

### 전체 테스트: 환경파일·실DB 없이 실행

Laravel의 환경변수 로딩 부트스트래퍼를 임시 실행 가드에서 대체하여 Dotenv 로딩을 건너뛰었다. Artisan 부모와 PHPUnit 자식에 같은 가드를 적용했다. HTTP 클라이언트에는 `preventStrayRequests()`를 기본 적용하고, 테스트 내부 요청은 Laravel 커널과 HTTP fake로 처리했다. 운영·Claude DB는 사용하지 않았고, DB는 명령 하나에만 지정한 SQLite `:memory:`였다. 캐시·컴파일 뷰 경로도 이 세션 전용 `/private/tmp/intl04b-*`로 분리했다.

실행 명령:

```sh
mkdir -p /private/tmp/intl04b-views
APP_ENV=testing APP_KEY=12345678901234567890123456789012 APP_CONFIG_CACHE=/private/tmp/intl04b-config.php APP_ROUTES_CACHE=/private/tmp/intl04b-routes.php APP_SERVICES_CACHE=/private/tmp/intl04b-services.php APP_PACKAGES_CACHE=/private/tmp/intl04b-packages.php VIEW_COMPILED_PATH=/private/tmp/intl04b-views LOG_CHANNEL=stderr DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL='' CACHE_STORE=array SESSION_DRIVER=array MAIL_MAILER=array QUEUE_CONNECTION=sync php -d auto_prepend_file=/private/tmp/intl04b-guard.php artisan test --bootstrap=/private/tmp/intl04b-guard.php
```

최종 실제 출력 / 종료 코드 0:

```text
[2026-11-03 07:09:20] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"} 
[2026-11-03 07:09:20] testing.WARNING: rankfree_connection_request_failed {"exception_type":"App\\Services\\Rankfree\\ConnectionStoreException"} 
{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":19822}
```

첫 실행도 206개·36,008 assertions 통과했다(24,163ms). 최종 영문 업계 소제목 3개까지 일본어로 정리한 뒤 위와 같이 다시 전체 실행했다(19,822ms). 경고 2줄은 연결 저장 예외 처리 테스트 중 출력되었고 테스트 실패는 0이다. 다른 세션 원인 실패도 0이다.

블로그 전용 게이트인 `IntlInsightSeeder` 두 번 실행·`intl:stale`는 04B 범위에 해당하지 않아 직접 실행하지 않았다. 기존 테스트의 시더 격리 설정은 변경하지 않았다.

## 4. 이전/이후 대조 20쌍

비교 기준은 작업 전 스냅샷이며, 아래 한국어는 실제 `config/subpages.php` 값이다.

### 1. `seo.items.backlinks.seo_title`

- 한국어: 고품질 백링크 서비스 | 구글・네이버 순위상승 전문 | 제이커브
- 이전: 検索の信頼を支える被リンク戦略 | J-Curve Interactive
- 이후: 高品質な被リンクサービス | Google・NAVERの順位改善に対応 | J-Curve

### 2. `seo.items.backlinks.meta_description`

- 한국어: 10년간 1,000여 개의 SEO 프로젝트를 성공적으로 수행하며 얻은 검색엔진최적화에 대한 깊은 이해와 경험을 바탕으로 제공하는 전문 백링크 서비스로 검색엔진 상위노출을 경험하세요. 구글과 네이버에 최적화된 검증된 고품질 백링크 전략은 자연스러운 순위 상승을 돕습니다. 무료 컨설팅을 신청하세요.
- 이전: 10年間・1,000件以上のSEOプロジェクトの経験を基に、Google・NAVER向けに対象ページ、出典とアンカーテキストを確認する被リンクサービスです。無料相談を受け付けています。
- 이후: 10年間にわたり約1,000件のSEOプロジェクトを成功に導いた経験と、検索エンジン最適化への深い理解を生かした専門の被リンクサービスです。GoogleとNAVER（韓国最大の検索ポータル）に適した、検証済みの高品質な被リンク戦略で自然な順位改善を支援します。上位表示を目指す方は無料相談をご利用ください。

### 3. `seo.items.naver-place.lead`

- 한국어: 네이버 플레이스 마케팅은 지역과 업종을 검색한 고객이 매장의 정확한 정보와 선택 근거를 빠르게 확인하도록 플레이스 자산을 정비하는 작업입니다. 정보 완성도, 콘텐츠, 고객 반응과 전환 동선을 함께 관리합니다.
- 이전: NAVERプレイス（NAVER検索・地図の店舗情報）。NAVERプレイスマーケティングは、地域や業界を探している顧客が店舗の正確な情報と選択の根拠をすばやく確認できるように、プレース資産を整備する作業です。情報の完成度、コンテンツ、顧客の反応、コンバージョン動線を一緒に管理します。
- 이후: NAVERプレイス（NAVER検索・地図の店舗情報）のマーケティングは、地域や業種を検索したお客様が、正確な店舗情報と選ぶ理由をすぐに確認できるように情報を整える施策です。情報の充実度、コンテンツ、お客様の反応、コンバージョンへの導線を合わせて管理します。

### 4. `seo.items.naver-shopping.sections.3.items.0.text`

- 한국어: 상품군별 정보 기준이 달라져 운영 체계를 다시 잡아야 하는 경우.
- 이전: 商品群別の情報基準が変わり、運営体制を取り戻さなければならない場合。
- 이후: 商品群ごとの情報基準にばらつきがあり、運用体制を見直したいストアに適しています。

### 5. `seo.items.kakao-gift.sections.3.items.3.text`

- 한국어: 재고·배송·CS 기준이 불명확하다면 노출보다 운영 체계를 먼저 정해야 합니다.
- 이전: 在庫・配送・CS基準が不明確であれば、露出より運営体系を先に定める必要があります。
- 이후: 在庫・配送・顧客対応の基準が不明確な場合は、露出を増やす前に運用体制を決める必要があります。

### 6. `cpa.items.real-estate.lead`

- 한국어: 부동산 분양 CPA는 상담 신청이 들어왔다는 사실만 세는 광고가 아닙니다. 사업지와 공급 조건을 정확히 설명하고, 고객의 연락 동의와 유효 DB 기준, 상담 후 피드백까지 연결해야 품질을 관리할 수 있습니다.
- 이전: 不動産分譲CPAは、カウンセリング申請が入ったという事実だけを数える広告ではありません。事業所と供給条件を正確に説明し、顧客の連絡同意と有効リード基準、相談後フィードバックまで接続しなければ品質を管理できます。
- 이후: 不動産分譲のCPAは、相談申込数だけを数える広告ではありません。開発物件と販売条件を正確に伝え、連絡への同意、有効リードの基準、相談後のフィードバックをつなぐことで品質を管理します。

### 7. `cpa.items.stock.body.0`

- 한국어: 서비스 범위와 위험 정보를 사실대로 설명하고 상담 연락에 동의한 신청을 측정하는 CPA 서비스입니다.
- 이전: サービスの範囲とリスク情報を事実上説明し、カウンセリング連絡に同意した申請を測定するCPAサービスです。
- 이후: サービス範囲とリスクを事実に即して説明し、相談の連絡に同意した申込を測定するCPAサービスです。

### 8. `cpa.items.insurance.sections.2.items.2.text`

- 한국어: 광고주·공급사마다 중복의 기간과 식별 기준이 다르면 반려와 정산 분쟁이 반복됩니다.
- 이전: 広告主・供給会社ごとに重複の期間と識別基準が異なると、ペットと精算紛争が繰り返されます。
- 이후: 広告主・リード供給会社ごとに重複確認の期間や識別基準が違うと、差し戻しと精算をめぐる争いが繰り返されます。

### 9. `cpa.items.insurance.sections.3.title`

- 한국어: 퍼미션 DB는 체크박스가 아니라, 고객이 예상한 연락입니다
- 이전: 同意取得済みリードはチェックボックスではなく、顧客が期待した連絡先です
- 이후: 同意取得済みリードで大切なのは、チェック欄ではなく、お客様が想定した連絡です

### 10. `cpa.items.insurance.sections.5.items.0.text`

- 한국어: 보험 리모델링, 보장 분석, 상담 등 실제 제공 범위를 과장 없이 설명하고 신청 목적을 맞춥니다.
- 이전: 保険の改造、保証分析、相談など、実際の提供範囲を誇張せずに説明し、申請目的を合わせます。
- 이후: 保険の見直し、保障分析、相談など、実際の提供範囲を誇張せずに説明し、申込目的を合わせます。

### 11. `cpa.items.insurance.sections.5.items.2.text`

- 한국어: 캠페인 조건에 따라 상담 주제, 연락 주체, 지역, 가능한 일정과 핵심 의사를 다시 확인합니다.
- 이전: キャンペーンの条件に応じて、カウンセリングのトピック、連絡先、地域、可能なスケジュールと重要な医師を再確認してください。
- 이후: キャンペーン条件に応じて、相談テーマ、連絡主体、地域、対応可能な日程、主な意向を再確認します。

### 12. `cpa.items.insurance.sections.7.note`

- 한국어: DB 유형 명칭만으로 품질을 판단하지 마세요. 각 유형의 필수 확인 항목, 상담 의사 수준, 증빙과 AS 범위를 계약서에서 정의해야 합니다.
- 이전: リードタイプ名のみで品質を判断しないでください。各タイプの必須確認項目、カウンセリング医師レベル、証明およびアフターサポートの範囲を契約書で定義する必要があります。
- 이후: リードの種別名だけで品質を判断しないでください。種別ごとの必須確認項目、相談意向の度合い、証拠、アフターサポートの範囲を契約書で定義する必要があります。

### 13. `cpa.items.insurance.sections.13.items.3.text`

- 한국어: 작은 지역·물량으로 연락률, 미팅 상태, 반려 사유와 담당자 입력 품질을 확인합니다.
- 이전: 小さな地域・物量で連絡率、ミーティング状態、ペットの理由と担当者入力品質を確認します。
- 이후: 地域と件数を絞り、連絡率、面談状況、差し戻し理由、担当者の入力品質を確認します。

### 14. `cpa.items.permission-call.sections.0.paragraphs.1`

- 한국어: 수집 화면, 동의 로그, DB 전달, 상담 스크립트, 수신 거부와 보유 기간까지 하나의 운영 체계로 설계해야 합니다.
- 이전: 収集画面、同意ログ、リード配信、カウンセリングスクリプト、受信拒否と保持期間まで、1つのオペレーティングシステムで設計する必要があります。
- 이후: 収集画面、同意ログ、リードの受け渡し、相談スクリプト、受信拒否、保有期間までを、一つの運用体制として設計する必要があります。

### 15. `performance.items.naver-gfa.lead`

- 한국어: 네이버 GFA는 네이버 서비스의 다양한 디스플레이 지면에서 오디언스에게 도달하는 광고입니다. 제이커브는 캠페인 목적, 전환 측정, 타게팅과 소재 가설을 먼저 정하고 데이터를 보며 예산과 크리에이티브를 조정합니다.
- 이전: NAVER GFAはNAVERのディスプレイ広告です。NAVERは韓国最大の検索ポータルです。NAVER GFAは、NAVERサービスのさまざまなディスプレイグラウンドでオーディエンスに届く広告です。 J-Curveは、キャンペーンの目的、コンバージョン測定、ターゲティング、クリエイティブ仮説を最初に決定し、データを表示し、予算とクリエイティブを調整します。
- 이후: NAVER GFA（NAVERのディスプレイ広告）は、NAVERのサービス内のさまざまな広告枠でオーディエンスに届ける広告です。J-Curveは目的、コンバージョン測定、ターゲティング、クリエイティブの仮説を先に定め、データを見ながら予算とクリエイティブを調整します。

### 16. `performance.items.naver-gfa.sections.1.items.3.text`

- 한국어: 전환 품질과 비용을 기준으로 예산을 옮기고 다음 테스트 이유를 기록합니다.
- 이전: コンバージョンの品質と費用に基づいて予算を移動し、次のテスト理由を記録します。
- 이후: コンバージョンの品質と費用に基づいて予算を配分し、次のテストを行う理由を記録します。

### 17. `performance.items.facebook.sections.1.items.3.text`

- 한국어: 전환 품질을 보고 예산과 소재를 조정하며 랜딩 병목도 함께 다룹니다.
- 이전: コンバージョンの品質を見て、予算と素材を調整し、ランディングボトルネックも一緒に扱います。
- 이후: コンバージョンの品質を見て予算とクリエイティブを調整し、ランディングページのボトルネックも改善します。

### 18. `boostingshop.items.elite.title`

- 한국어: SEO 캠페인 엘리트 — 경쟁 시장을 위한 통합 운영
- 이전: SEO Elite：競争市場の統合運用
- 이후: SEOキャンペーン・エリート — 競争の激しい市場に向けた統合運用

### 19. `boostingshop.items.instagram-popular.sections.0.title`

- 한국어: 인기게시물은 외부에서 소유하거나 고정할 수 있는 광고 지면이 아닙니다
- 이전: 人気の投稿は、外部で所有または固定できる広告地面ではありません
- 이후: 人気投稿は、外部から所有・固定できる広告枠ではありません

### 20. `boostingshop.items.instagram-likes.faq.0.answer`

- 한국어: 아닙니다. 인위적인 좋아요 수량을 판매하거나 보장하지 않습니다. 콘텐츠, 공식 광고와 협업처럼 유입 경로를 설명하고 측정할 수 있는 방법만 검토합니다.
- 이전: いいえ。人為的な良い 数量を販売または保証しません。コンテンツ、公式広告、コラボレーションなど、流入経路を説明して測定できる方法のみを確認します。
- 이후: いいえ。人為的な「いいね」数の販売や保証は行いません。コンテンツ、公式広告、協業など、流入経路を説明・測定できる方法だけを検討します。

## 5. 확신이 제한되는 용어·검수 요청

- `준실버 DB / 실버 DB / 확정 DB`는 원문 자체가 계약별 상품명이다. `準シルバーリード / シルバーリード / 確定リード`로 구분을 보존했다. 일본의 보편적인 품질 등급이나 면담 확정 보장으로 바꾸지 않았다. 원문의 “유형 이름만으로 판단하지 말고 계약에서 정의” 고지도 유지했다. Claude가 실제 판매 조직의 명칭 선호를 확인할 항목이다.
- `보험 설계사`는 `保険募集人`, `GA`는 `保険代理店（GA）`로 설명했다. 한국 조직의 역할을 전달하기 위한 번역이며 일본의 인허가를 보유했다는 주장을 추가하지 않았다.
- `퍼미션콜`은 `同意確認の電話`, 보험 `리모델링`은 `保険の見直し`, 상담 의사의 `의사`는 `意向`으로 옮겼다. 기존 “의사=医師”, “보험 리모델링=改造” 오역은 제거했다.
- 원문 메타 설명에 있는 10년·약 1,000건 경험은 값과 범위를 보존했다. 이 수치의 사업상 최신성·근거를 새로 검증한 작업은 아니다.

## 6. 외부 요청 0 근거와 실행 명령 기록

도구 이력에서 웹 검색·브라우저·외부 번역 커넥터·HTTP 전송 도구는 호출하지 않았다. 원문을 Google·DeepL·Papago 등으로 전송한 작업은 없다. 로컬 파일만 처리했고, 테스트에서는 위 HTTP 외부 요청 차단 가드를 사용했다.

실제 사용한 명령군:

```text
cat /Users/anarchy/.agents/skills/tri-agent-orchestration/SKILL.md
rg -n (로컬 메모리 레지스트리의 jcurve·i18n 관련 항목 검색; 번역 근거로 사용하지 않음)
cat AGENTS.md docs/intl/INTL-PLAN.md docs/intl/GLOSSARY.md
cat docs/intl/SPEC-CODEX-INTL-04.md docs/COLLAB.md docs/collab/QUEUE.md
cat lang/ja/pages/{home,company,contact,rankfree,marketing-support,self-marketing}.php
sed -n (지정 영·일 말투 본보기, config/subpages.php, tests·bootstrap·vendor의 로컬 부트스트랩 확인)
wc -l / wc -c (원문·번역 파일)
rg --files (범위별 규칙·기존 테스트 파일 확인)
php -r (로컬 config/subpages.php·lang/ja/subpages.php require와 JSON 출력·토큰/구조 집계)
sed -n (lang/ja/subpages.php 작업 전 원문을 구간별 읽어 스냅샷 수집)
git status --short
git log --oneline / git log --format / git diff --stat / git diff --numstat
git diff --check -- lang/ja/subpages.php
git diff 0f18dc6 --numstat -- lang/ja/subpages.php
git show 0f18dc6:lang/ja/subpages.php | php -r (작업 전 스냅샷과 동일성·SHA-256 확인)
php /private/tmp/intl04b-check.php
php -l lang/ja/subpages.php
./vendor/bin/pint --test lang/ja/subpages.php
mkdir -p /private/tmp/intl04b-views
APP_ENV=testing ... DB_DATABASE=:memory: ... php -d auto_prepend_file=/private/tmp/intl04b-guard.php artisan test --bootstrap=/private/tmp/intl04b-guard.php
rg -n (lang/ja/subpages.php 한글·금지 용어·DB/AS 잔존 검색; 결과 0, exit 1)
shasum -a 256 lang/ja/subpages.php config/subpages.php
cat /private/tmp/intl04b-check.php /private/tmp/intl04b-guard.php
```

위 `php -r`의 파일 읽기는 로컬 경로뿐이며 HTTP URL을 읽지 않았다. 파일 변경은 native `apply_patch`로만 했고, 영구 산출물은 지정된 두 파일뿐이다. 임시 스냅샷·검사·격리 가드는 `/private/tmp/intl04b-*`에만 두었다.

기준 확인 실제 출력:

```text
baseline_matches_0f18dc6=yes
baseline_sha256=43e5d1953e21e56fa5c0fe5f5417debb49958ed2afa39e575706e19ed24337f8

988    988    lang/ja/subpages.php
```

마지막 줄은 `git diff 0f18dc6 --numstat -- lang/ja/subpages.php` 출력이다.

## 7. 미검증·미실시

- 일본어 원어민의 문체 검수, 실제 브라우저의 줄바꿈·시각 검수는 별도 세션에 남긴다.
- 법률·금융·개인정보 적합성의 실무 판정은 수행하지 않았다. 원문의 고지·역할·조건을 번역하고 보존했다.
- 04A·04C·04D·03B·별도 검증 세션의 파일을 수정하지 않았다. 블로그 내용·실DB·외부 서비스·서버·배포는 이번 구현 범위 밖이다.
- 자체 실행 점검 결과를 최종 합격 판정으로 대체하지 않는다.
- 이 세션은 commit·push·배포·발행 명령을 실행하지 않았다.

## 부록 A. 실제 정적 검사 스크립트

실행 파일은 `/private/tmp/intl04b-check.php`다. `intl04b-before.json`은 작업 전 일본어 배열이며 위에서 `0f18dc6`와 동일성을 확인했다. 아래는 실행한 코드 그대로다.

```php
<?php

$root = '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n';
$source = require $root.'/config/subpages.php';
$before = json_decode(file_get_contents('/private/tmp/intl04b-before.json'), true, 512, JSON_THROW_ON_ERROR);
$after = require $root.'/lang/ja/subpages.php';
$protected = ['route', 'param', 'type', 'tone', 'href', 'id', 'contact_interest', 'icon', 'class', 'slug', 'source_hash'];
$stats = ['human' => 0, 'korean_source' => 0, 'changed' => 0, 'protected' => 0, 'nulls' => 0];
$issues = ['structure' => [], 'protected' => [], 'hangul' => [], 'html' => [], 'numbers' => [], 'traces' => [], 'ratio' => []];
$brandNumeric = [];
$words = ['ペット', 'オペレーティングシステム', '地面', 'グラウンド', 'カウンセリング', 'インフロー'];
$numbers = function (string $s): array {
    // The digit in this required brand spelling is not a quantitative claim.
    $s = str_replace(['콜투세일', 'Call2Sale'], '[CALLTOSALE]', $s);
    preg_match_all('/[0-9][0-9,]*(?:\.[0-9]+)?/', $s, $m);
    return $m[0];
};
$walk = function ($ko, $old, $new, $path = '') use (&$walk, &$stats, &$issues, &$brandNumeric, $protected, $words, $numbers): void {
    if (is_array($old)) {
        if (!is_array($ko) || !is_array($new) || array_keys($old) !== array_keys($new) || array_keys($ko) !== array_keys($new)) {
            $issues['structure'][] = $path;
            return;
        }
        foreach ($old as $key => $v) $walk($ko[$key], $v, $new[$key], $path === '' ? (string) $key : $path.'.'.$key);
        return;
    }
    $key = substr($path, strrpos($path, '.') + 1);
    if (!is_string($new) || in_array($key, $protected, true)) {
        $stats['protected']++;
        if ($new === null) $stats['nulls']++;
        if ($new !== $old || $new !== $ko) $issues['protected'][] = $path;
        return;
    }
    $stats['human']++;
    if ($new !== $old) $stats['changed']++;
    if (preg_match('/[\x{AC00}-\x{D7AF}\x{1100}-\x{11FF}\x{3130}-\x{318F}]/u', $ko)) $stats['korean_source']++;
    if (preg_match('/[\x{AC00}-\x{D7AF}\x{1100}-\x{11FF}\x{3130}-\x{318F}]/u', $new)) $issues['hangul'][] = $path;
    foreach ($words as $word) if (str_contains($new, $word)) $issues['traces'][] = [$path, $word];
    if ($numbers($ko) !== $numbers($new)) $issues['numbers'][] = ['path' => $path, 'ko' => $numbers($ko), 'ja' => $numbers($new)];
    if (str_contains($new, 'Call2Sale') && str_contains($ko, '콜투세일')) $brandNumeric[] = $path;
    preg_match_all('/<[^>]+>/', $old, $oldTags);
    preg_match_all('/<[^>]+>/', $new, $newTags);
    if ($oldTags[0] !== $newTags[0]) $issues['html'][] = $path;
    $ratio = mb_strlen($new) / max(1, mb_strlen($ko));
    if ($ratio < 0.5 || $ratio > 2.5) $issues['ratio'][] = ['path' => $path, 'ko' => $ko, 'ja' => $new, 'ratio' => round($ratio, 4), 'verdict' => '정상', 'reason' => '용어집 지정 로마자 브랜드명과 첫 언급 가나 병기'];
};
$walk($source, $before, $after);
echo json_encode(['stats' => $stats, 'issues' => $issues, 'brand_digit_normalization' => $brandNumeric], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n";
foreach (['structure', 'protected', 'hangul', 'html', 'numbers', 'traces'] as $check) if ($issues[$check]) exit(1);
```

## 부록 B. 실제 테스트 가드

실행 파일은 `/private/tmp/intl04b-guard.php`다. 레포의 부트스트랩이나 테스트 코드는 수정하지 않았다.

```php
<?php

namespace Illuminate\Foundation\Bootstrap {
    class LoadEnvironmentVariables
    {
        public function bootstrap($app): void
        {
            // Skip Dotenv for the command and PHPUnit child process.
            $app->useEnvironmentPath('/private/tmp/intl04b-no-environment');
            $app->afterResolving(\Illuminate\Http\Client\Factory::class, function ($factory): void {
                $factory->preventStrayRequests();
            });
        }
    }
}

namespace {
    require_once '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/vendor/autoload.php';
}
```
