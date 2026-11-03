# INTL-03B 구현 반환물

- 작업 ID: INTL-03B / 구현 세션 B / 2026-11-03
- 작업 폴더: `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`
- 범위: `docs/intl/insights-list.json` 27~52번, **JSON 26개 / EN·JA 번역 52개**.
- 지시·최종 검수 담당: Claude. 번역 초벌·지정 자동 점검·실행 증거: Codex.
- `SPEC-CODEX-INTL-03.md` 전체와 맨 아래 추가 지시, INTL-PLAN §1·§5, GLOSSARY, INTL-01 결과의 라우트·표시 본문·시더 계약을 읽고 수행했다. 작업 중 추가된 **GLOSSARY §8**도 반영했다.
- 커밋·푸시·배포·발행·브랜치 변경을 수행하지 않았다. 한국어 글·시더·마이그레이션·화면·테스트·다른 세션 JSON을 수정하지 않았다.
- 수정한 저장소 파일은 아래 26개 JSON과 이 반환물뿐이다. 허용된 전용 테스트 SQLite와 저장소 밖 임시 점검 자료를 별도로 사용했다.
- 이는 구현 세션의 자체 실행 증거다. **별도 세션 독립 검증과 Claude의 최종 합격 판정은 아직 수행하지 않았다.**

## 1. 결과

| 항목 | 실제 결과 |
|---|---|
| 대상 표시 본문 | 공개 글 52편 확인, B 26편의 표시 본문 SHA256 모두 목록 hash와 일치 |
| JSON / 번역 | 26 / 52 |
| 점검 1 | 본문 텍스트·제목·요약·메타 한글 0; alt/title의 한글도 0 |
| 점검 2 | 태그 순서·기술 속성·이미지 src·개수·링크·표·목록 구조 동일 |
| 이미지 / 링크 | 원문 기준 이미지 151개, 앵커 62개를 언어별 각각 보존 |
| 점검 3 | 숫자 토큰 차이를 §3에 전부 기록; 만·억·천·날짜·서수·용어 표기 차이 |
| 점검 4 | DOMDocument 파싱: 원문 오류 0, 번역의 신규 오류 0 |
| 점검 5 | B slug 26개 모두 4~8단어 ASCII 소문자·하이픈, 전체 52파일의 언어별 slug 충돌 0 |
| 메타 | EN title ≤60 / description ≤155, JA title ≤32 / description ≤110 모두 충족 |
| 점검 6 | 실제 로컬 HTTP 52/52 응답 200, HTML entity를 해제한 응답에 번역 제목 52/52 확인 |
| DB | 전체 104행, B 52행, B 각 글에 en·ja 각각 1행 |
| stale | 전체 0, 따라서 B 0 |
| 시더 멱등 | 연속 두 번 실행 전후 행 수·전체 행 SHA256·B 행 SHA256 동일 |
| 전체 테스트 | B 제외 206/206, B 복원 최종 206/206, 각각 36,008 assertions |
| 무력화 | en.content에 `한글` 삽입 시 점검 1 실패, 원복 후 SHA256 동일 및 점검 통과 |

글자 수는 HTML 태그를 제외한 **DOM 본문 텍스트 문자 수**다. 점검 1·4·6은 EN / JA 순서다. JSON 파일은 `database/content/intl/insights/{영문 slug}.json`이다.

| # | 한국어 slug | 영문 공통 slug | 영어 제목 | 일본어 제목 | 본문 글자 수 EN / JA | 1 한글 | 2 구조 | 3 숫자 | 4 신규 오류 | 5 slug·메타 | 6 HTTP |
|---|---|---|---|---|---:|---|---|---|---|---|---|
| 27 | 콘텐츠-마케팅-전략-7단계 | seven-steps-to-content-marketing-strategy | Seven steps to a content marketing strategy | コンテンツマーケティング戦略の7段階 | 9583 / 3918 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 28 | 구글애널리틱스를-통한-구매-및-전환-추적 | track-purchases-and-conversions-with-google-analytics | Tracking purchases and conversions with Google Analytics | Googleアナリティクスで購入とコンバージョンを追跡 | 7755 / 3257 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 29 | 페이스북-광고-테스트가-꼭-필요한-이유 | why-testing-facebook-ad-creative-matters | Why testing Facebook ads matters | Facebook広告のテストが必要な理由 | 4920 / 2077 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 30 | 페이스북-광고-캠페인-타켓팅-초보자를-위한-가이드 | facebook-ad-targeting-guide-for-beginners | Facebook ad campaigns: a beginner's targeting guide | Facebook広告のターゲティング入門 | 7209 / 2953 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 31 | 인스타그램-마케팅에-대한-뜬소문들 | common-rumors-about-instagram-marketing-explained | Rumors about Instagram marketing | Instagramマーケティングのうわさ | 4286 / 1729 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 32 | 인스타그램-스토리-광고의-특별한-점은 | what-makes-instagram-stories-ads-different | What makes Instagram Stories ads different? | Instagramストーリーズ広告の特徴 | 3220 / 1351 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 33 | 인스타그램-광고-실행-및-관리-방법 | how-to-run-and-manage-instagram-ads | How to run and manage Instagram ads | Instagram広告の配信と管理方法 | 8090 / 3435 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 34 | 페이스북-광고-목적에-최적화된-유형-선택이-중요 | choose-facebook-ad-formats-by-campaign-objective | Choose Facebook ad formats for your objective | 目的に合うFacebook広告形式の選び方 | 10388 / 4453 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 35 | 스마트스토어-검색광고가-꼭-필요할까 | does-naver-smart-store-need-search-ads | Does a NAVER Smart Store need search ads? | スマートストアに検索広告は必要ですか | 4626 / 1754 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 36 | 스마트스토어-내게-맞는-키워드-발굴하는-법 | finding-effective-keywords-for-naver-smart-store | Finding effective keywords for your Smart Store | スマートストアに合うキーワードの探し方 | 3136 / 1167 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 37 | cpa-광고-마케팅-대행사-선정-시-꼭-알아야 | choosing-a-cpa-marketing-agency-key-considerations | What to know when choosing a CPA marketing agency | CPA広告の代理店選びで確認すべき点 | 5727 / 2315 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 38 | 주식-cpa-대행사-퍼미션-db-마케팅은-제이커브로 | stock-cpa-and-consent-based-leads-at-jcurve | Stock CPA and consented leads at J-Curve | J-Curveの株式CPAと同意取得済みリード | 2980 / 1157 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 39 | 퍼미션-마케팅-어떻게-해야-제대로-할-수-있을까 | how-to-run-permission-marketing-properly | How to run permission marketing properly | パーミッションマーケティングの進め方 | 2549 / 926 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 40 | 마케팅-퍼널이란-무엇인가-1 | what-is-a-marketing-funnel-part-one | What is a marketing funnel? (1) | マーケティングファネルとは何ですか（1） | 8047 / 2856 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 41 | 마이인플루언서-론칭 | introducing-the-my-influencer-marketing-platform | Introducing My Influencer | My Influencerのサービス開始 | 1484 / 608 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 42 | 유튜브까지-섭렵한-마케팅-전문가집단-제이커브인터렉티브 | jcurve-expands-into-youtube-with-foodie-mate | J-Curve expands into YouTube with Foodie Mate | Foodie MateでYouTube事業に進出 | 1412 / 569 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 43 | 제이커브인터렉티브-기업부설연구소-설립 | jcurve-establishes-its-corporate-research-institute | J-Curve establishes a corporate research institute | J-Curveが企業付設研究所を設立 | 1175 / 448 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 44 | 제이커브인터렉티브-고객관리-프로그램-crmpro-개발 | jcurve-develops-crmpro-for-cpa-customer-management | J-Curve develops the CRMPRO customer management program | 顧客管理プログラムCRMPROを開発 | 1239 / 425 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 45 | 구글-광고-이렇게-해보세요 | how-to-make-google-ads-work-better | How to make Google Ads work better | Google広告を効果的に活用する方法 | 4461 / 1636 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 46 | 제이커브인터렉티브-자사-브랜드-nobb-상표등록-완료 | jcurve-completes-trademark-registration-for-nobb | J-Curve completes trademark registration for NOBB | 自社ブランドNOBBの商標登録が完了 | 1008 / 391 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 47 | 제이커브인터렉티브-혁신성장형-벤처기업인증획득 | jcurve-earns-innovation-growth-venture-company-certification | J-Curve earns innovation-growth venture certification | 革新成長型ベンチャー企業認証を取得 | 950 / 411 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 48 | 디지털-마케팅에서-꼭-알아야-할-핵심-공식-12가지 | twelve-essential-formulas-for-digital-marketing | 12 essential formulas for digital marketing | デジタルマーケティングの必須公式12選 | 4542 / 1710 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 49 | 인스타그램-인기게시물-노출을-위한-알고리즘-이해 | understanding-instagram-top-posts-ranking-algorithm | Understanding Instagram's top-posts algorithm | Instagram人気投稿の仕組みを理解する | 6795 / 2292 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 50 | chrome-및-firefox에서-nofollow-링크를-확인하는-방법 | check-nofollow-links-in-chrome-and-firefox | How to check nofollow links in Chrome and Firefox | Chrome・Firefoxでnofollowを確認 | 860 / 422 | 0 / 0 | 동일 | 동일 | 0 / 0 | 통과 | 200 / 200 |
| 51 | 11가지-최고의-seo-실수와-이를-피하는-방법 | eleven-common-seo-mistakes-and-how-to-avoid | 11 common SEO mistakes and how to avoid them | よくあるSEOの失敗11選と回避方法 | 10068 / 4385 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |
| 52 | 경쟁자를-압도하는-6가지-고급-링크-구축-전략 | six-advanced-link-building-strategies-to-outperform-competitors | 6 advanced link-building strategies to outperform competitors | 競合を上回る6つの高度な被リンク戦略 | 18590 / 8455 | 0 / 0 | 동일 | 차이표 | 0 / 0 | 통과 | 200 / 200 |

### 구조·메타 세부 수치

이미지·앵커·표·목록 수는 원문과 EN·JA가 같다. 메타는 title / description 문자 수다.

| # | img | a | table | ul+ol | EN 메타 | JA 메타 |
|---|---:|---:|---:|---:|---|---|
| 27 | 3 | 2 | 0 | 0 | 43 / 121 | 18 / 52 |
| 28 | 7 | 7 | 0 | 0 | 56 / 125 | 27 / 58 |
| 29 | 4 | 4 | 0 | 0 | 32 / 117 | 20 / 59 |
| 30 | 16 | 12 | 0 | 0 | 51 / 115 | 20 / 47 |
| 31 | 6 | 3 | 0 | 0 | 32 / 110 | 20 / 51 |
| 32 | 4 | 0 | 0 | 0 | 43 / 118 | 20 / 47 |
| 33 | 23 | 15 | 0 | 0 | 35 / 124 | 19 / 47 |
| 34 | 19 | 8 | 0 | 0 | 45 / 125 | 21 / 50 |
| 35 | 4 | 0 | 0 | 0 | 41 / 128 | 18 / 53 |
| 36 | 6 | 3 | 0 | 0 | 47 / 120 | 19 / 47 |
| 37 | 3 | 0 | 0 | 0 | 49 / 113 | 18 / 39 |
| 38 | 3 | 0 | 0 | 0 | 40 / 108 | 23 / 43 |
| 39 | 3 | 0 | 0 | 0 | 40 / 89 | 18 / 45 |
| 40 | 2 | 1 | 0 | 0 | 31 / 123 | 20 / 40 |
| 41 | 0 | 0 | 0 | 0 | 25 / 117 | 20 / 55 |
| 42 | 0 | 0 | 0 | 0 | 45 / 115 | 24 / 50 |
| 43 | 0 | 0 | 0 | 0 | 50 / 120 | 18 / 40 |
| 44 | 1 | 0 | 0 | 0 | 55 / 121 | 18 / 56 |
| 45 | 1 | 0 | 0 | 0 | 34 / 107 | 19 / 45 |
| 46 | 1 | 0 | 0 | 0 | 49 / 115 | 18 / 50 |
| 47 | 2 | 0 | 0 | 0 | 53 / 108 | 17 / 52 |
| 48 | 1 | 0 | 0 | 0 | 43 / 121 | 19 / 45 |
| 49 | 8 | 3 | 0 | 0 | 45 / 112 | 22 / 41 |
| 50 | 2 | 4 | 0 | 1 | 49 / 94 | 26 / 44 |
| 51 | 10 | 0 | 0 | 5 | 44 / 122 | 18 / 48 |
| 52 | 22 | 0 | 0 | 6 | 35 / 137 | 16 / 53 |

## 2. 번역·저장 방식

- DB 원시값 대신 한국어 **표시 본문**을 사용했다. 35·36번에서 모델이 숨긴 도입 인사말을 번역에 되살리지 않았다.
- 원문을 태그와 텍스트 조각으로 나누고, 태그·속성·순서를 유지한 채 텍스트를 번역했다. 기술 속성, class, style, 이미지 src는 보존했다. 원문의 한국어 글꼴명이 들어간 style도 원형대로 보존하므로, 본문 텍스트와 달리 JSON 원시 HTML 속성에는 그 글꼴명이 남는다.
- alt/title의 설명은 번역했다. 해시 형태의 비언어적 이미지 파일명은 보존했고, percent-encoded 한국어 파일명이 alt에 있던 경우 표시용 속성만 번역했다. 이미지 자체와 src는 변경하지 않았다.
- `ko_slug`와 `source_hash`는 목록 정본을 그대로 사용했다. `en`·`ja`는 slug/title/excerpt/content/meta_title/meta_description을 모두 갖는다.
- JSON은 폴더 밖 `/tmp/intl03b-{slug}.json`에서 완성·점검한 뒤 파일별 `mv`로 원자 교체했다.
- 통화는 KRW / ウォン으로 표기하고 환산하지 않았다. 한국 플랫폼은 해당 글의 첫 언급에 필요한 설명을 붙였다.
- GLOSSARY §8에 따라 광고 소재는 creative / 広告素材, 전환은 コンバージョン, 동의 리드는 consented leads / 同意取得済みリード, 무료 상담은 free consultation, AS는 after-sales support / アフターサポート로 정리했다.
- 마지막 slug 대조는 A의 26개를 포함한 전체 52파일의 EN·JA 각각을 대상으로 수행했다. B slug를 바꿔야 할 충돌은 없었다.

## 3. 숫자 토큰 차이 전체

숫자는 HTML 속성·이미지 파일명을 제외한 DOM 본문에서 `\d+(?:[,.]\d+)*(?:%)?`로 추출하여 **토큰별 출현 횟수**를 비교했다. 아래 객체는 `토큰: 차이 횟수`다. 값의 추가·삭제 판정이 아니라 문자 표기의 차이이며, 이 표에 없는 글·언어는 토큰 다중집합이 같다.

| # | 언어 | 원문에만 있는 토큰 | 번역에만 있는 토큰 |
|---|---|---|---|
| 28 | en | `{"1":5,"2":4}` | — |
| 28 | ja | `{"1":5,"2":4}` | — |
| 30 | en | `{"10":1}` | `{"1":1}` |
| 30 | ja | — | `{"1":1}` |
| 33 | ja | — | `{"1":2}` |
| 36 | en | `{"4":1,"5":3,"6":1}` | `{"1,000":1,"6,000":1,"40,000":1,"5,000":3}` |
| 36 | ja | `{"4":1,"5":3,"6":1}` | `{"1,000":1,"6,000":1,"40,000":1,"5,000":3}` |
| 38 | ja | — | `{"1":1}` |
| 39 | en | `{"1":2,"3":2}` | — |
| 39 | ja | `{"1":2,"3":2}` | — |
| 40 | en | `{"2":1}` | — |
| 41 | en | `{"5":1}` | — |
| 45 | ja | — | `{"1":1}` |
| 47 | en | `{"690":1}` | `{"6.9":1}` |
| 48 | en | `{"1":1}` | — |
| 48 | ja | `{"1":1}` | — |
| 49 | en | `{"2":1,"10":1,"2,500":1}` | `{"1":1,"25":1,"200":1}` |
| 51 | en | `{"3":1}` | — |
| 51 | ja | — | `{"1":2}` |
| 52 | ja | — | `{"1":1}` |

차이 해설:

- 28: `1차/2차` → primary/secondary, 主要/補助.
- 30 EN: `10억` → `1 billion`. JA의 추가 `1`은 `일일` → `1日`.
- 33 JA: 일일 예산·일일 도달을 `1日`로 풀어 썼다.
- 36 EN·JA: `천원` → `1,000`, `6천회` → `6,000`, `4만회` → `40,000`, 세 번의 `5천원` → 세 번의 `5,000`. 통화 가치는 동일하다.
- 38 JA·45 JA: `하루` → `1日`.
- 39: `1차` → initial / 一次, `제3자` → third-party / 第三者.
- 40 EN: `2가지` → `Two`.
- 41 EN: `5월` → `May`.
- 47 EN: `690만` → `6.9 million`으로 정확히 변환했다. 숫자와 단위가 별도 태그에 있어 숫자 텍스트 조각도 함께 변경했다.
- 48: `1회 방문자` → first-time visitors / 初回訪問者.
- 49 EN: `10억` → `1 billion`, `2,500만` → `25 million`, `2억` → `200 million`.
- 51 EN: `3월` → `March`. JA의 추가 `1`은 첫 페이지와 기사당 표현을 숫자로 풀어 쓴 것이다.
- 52 JA: 첫 페이지를 `1ページ目`로 풀어 썼다.
- ROAS 1400%, 비율·해상도·단가·날짜·연도 등 나머지 수치는 원문 값을 유지했다.

## 4. 내부·외부 링크

### 번역 주소로 바꾼 링크

- 49번의 `https://j-curve.co.kr/instagram.php` 두 앵커 → `/{locale}/solutions/boostingshop/instagram-popular`. LegacyRedirectSeeder 및 전용 DB의 실제 redirect 목적지와 INTL-01의 정적 대상 목록으로 확인했다.
- 50번에서 52번으로 가는 percent-encoded 한국어 `/seo/{한국어 slug}/` → `/{locale}/insights/six-advanced-link-building-strategies-to-outperform-competitors`.
- **03A 글로 가는 링크는 B 원문에 없으므로, 다른 세션 번역 slug 미확정으로 남긴 한국어 글 링크는 0개다.**
- 외부 링크 3개(PageRank Wikipedia, Chrome Web Store, Mozilla add-ons)는 원문 그대로 유지했다.
- 외국어 정적 대상이 아닌 옛 이미지 확대 뷰어 링크 56개는 원형을 보존했다. 각 언어에서 동일한 URL이다. 새 번역 경로나 가짜 이미지 뷰어를 만들지 않았다.

<details>
<summary>남긴 원문 이미지 뷰어 URL 전체 56개</summary>

| 원문 # | URL |
|---|---|
| 27 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9005851423ba3b0dae1f4a48945c72f3_1576643326_0494.jpg` |
| 27 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9005851423ba3b0dae1f4a48945c72f3_1576643337_2769.jpg` |
| 28 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576722956_8352.jpg` |
| 28 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576722970_9683.png` |
| 28 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576723007_2782.png` |
| 28 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576723033_1303.jpg` |
| 28 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576723078_469.png` |
| 28 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576723292_941.jpg` |
| 28 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9894057d5ca8e5b440766d88069c84c0_1576723315_9311.jpg` |
| 29 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9fba2d647a508eebd0a494b417d8575f_1576810661_58.png` |
| 29 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9fba2d647a508eebd0a494b417d8575f_1576810669_7706.jpg` |
| 29 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9fba2d647a508eebd0a494b417d8575f_1576810681_4632.jpg` |
| 29 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9fba2d647a508eebd0a494b417d8575f_1576810703_4147.jpg` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071298_1388.jpg` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071325_5874.png` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071380_2849.png` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071403_1084.png` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071425_2444.png` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071450_443.png` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071567_5384.png` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071607_0172.jpg` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071628_6036.png` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071662_1346.png` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071716_2513.png` |
| 30 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F93caa74db6dbb8c4d77ec4fd572c60c7_1577071717_8462.png` |
| 31 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Fdef627a9e530444835cd1befa5db2892_1577175639_3227.png` |
| 31 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Fdef627a9e530444835cd1befa5db2892_1577175664_7346.jpg` |
| 31 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Fdef627a9e530444835cd1befa5db2892_1577175787_9403.jpg` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430169_667.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430276_9708.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430292_3382.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430303_6457.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430316_5152.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430334_828.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430342_4196.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430353_5754.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430362_0196.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430373_9152.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430388_7864.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430422_2036.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430437_6752.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430474_85.png` |
| 33 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F9425b53a92666161bbfddf275ca50833_1577430483_7292.png` |
| 34 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577690844_5769.jpg` |
| 34 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691084_7782.png` |
| 34 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691216_4939.gif` |
| 34 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691241_3091.png` |
| 34 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691262_5269.png` |
| 34 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691422_0544.png` |
| 34 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691466_2048.png` |
| 34 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F90cece8ff2ad77488d403e2ce12c2732_1577691598_7204.png` |
| 36 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2007%2Ff45c90162b4f82cdbe0e8ca13ca6e073_1593677114_532.png` |
| 36 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2007%2Ff45c90162b4f82cdbe0e8ca13ca6e073_1593677046_5062.png` |
| 36 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2007%2Ff45c90162b4f82cdbe0e8ca13ca6e073_1593677074_4676.png` |
| 40 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2104%2F0498c989a38589c856a132731de51ca9_1619764356_8222.jpg` |
| 49 | `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=https%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F2212%2F0141e988a4fa0caf496a6a1574030e1b_1671608774_2059.png` |

</details>

## 5. Claude 검수용 용어·원문 모호성

다음은 추가 사실을 조사해 확정하지 않고, 원문에 근거해 번역한 항목이다.

| 대상 | 처리·검수 포인트 |
|---|---|
| 27 BLT | 원문의 `BLT(Below the line)` 표기를 그대로 보존했다. BTL로 임의 교정하지 않았다. |
| 37·43 Jacob / Suit | 제이콥 → Jacob, 수트 → Suit로 로마자화했다. 두 글에서 분석·자동화 역할 설명이 서로 다르지만 원문대로 옮겼다. 공식 영문 제품명 확인 필요. |
| 38 고객사·인명 | Hwiyeol's Leading Stocks Investment Club, Cheonggaeguri Investment Club, Han Yong-hee Investment Club, Wall Street Korea, X1, Yeouido TV, Galaxy Investment Group, Cheongin Invest, Isang Investment는 원문 이름만 로마자화했다. 공식 영문 상호 미확인. |
| 41·42 My Influencer / Foodie Mate | 원문 서비스·채널명을 자연스러운 영문으로 옮겼다. 공식 영문 띄어쓰기 확인 필요. |
| 32 Puple | 원문 철자를 그대로 보존했다. Purple 등으로 바꾸지 않았다. |
| 48 공식 | 제목의 12와 실제 나열된 17개 공식의 차이, `전환율=전환수 X 유입수 X 100` 등 원문의 공식을 그대로 유지했다. 산술·정의 교정은 하지 않았다. |
| 51 직후 이탈 설명 | 원문의 “바운스율을 떨어뜨리고”를 그대로 옮겼다. 뒤의 논리와 맞는지 원문 편집 검수가 필요하다. |
| 52 깨진 이미지 설명 | “게스트 포스트 검색 쿼리 제출ㅍㅍㅍㅍㅍㅍㅍㅍ”의 잡음은 한글을 남기지 않도록 `pppppppp`로 로마자화했다. 해당 이미지의 alt는 의미 있는 부분만 번역했다. |
| 52 Moving Man 3단계 제목 | “음식을 위해 이사하는 사람을 내쫓으라”는 깨진 표현은 바로 다음 문단의 링크 교체 설명에 따라 “기존 리소스 링크 교체 제안”으로 최소 정리했다. |
| 52 마지막 부정적 SEO 문장 | 원문의 “좋은 링크가 나쁜 스팸 링크보다 항상 많은 경우 ... 결과를 얻을 수 없다” 관계를 뒤집지 않고 보존했다. 원문 의미 확인 필요. |
| 오래된 플랫폼 기능·정책·성과 주장 | Google Analytics의 기존 목표·다중 채널 보고, 과거 Facebook 규격, Instagram 정책 및 수치 등은 최신 정보로 고치지 않고 당시 원문대로 번역했다. 신규 보장·실적·출처는 추가하지 않았다. |

## 6. 실행 명령·실제 출력

### 전용 DB 생성

전용 경로는 `storage/framework/testing/intl03b.sqlite`다. 실DB·Claude 임시 DB를 사용하지 않았다. DB 환경 변수는 **각 명령 앞에만** 붙였고 export하지 않았다. .env를 열거나 수정하지 않았다.

```sh
touch storage/framework/testing/intl03b.sqlite
DB_CONNECTION=sqlite DB_DATABASE="$PWD/storage/framework/testing/intl03b.sqlite" DB_URL= APP_ENV=testing CACHE_STORE=array SESSION_DRIVER=array php artisan migrate:fresh --seed --force
```

실제 출력: migration 19개 및 BoardSeeder·InsightCategorySeeder·LegacyRedirectSeeder·LegacyContentSeeder·IntlInsightSeeder 완료, exit 0. 생성 직후 한국어 공개 글은 `52`였다.

### 자동 점검

저장소 밖 점검 스크립트 `/tmp/intl03b-check.php`를 사용했다. 원문 스냅샷은 `/tmp/intl03b-sources.json`이며 각 원문 hash를 목록 정본과 재대조한다. DOM 태그 순서와 alt/title/href 외 속성까지 비교하고, img src 배열·앵커 수·표·목록을 확인한다. href 변경은 §4에 열거한 대상만 수행했다.

```sh
php /tmp/intl03b-check.php
```

```text
files=26 translations=52 failures=0 slug_collisions=0
```

### 시더 연속 실행·행 비교

```sh
DB_CONNECTION=sqlite DB_DATABASE="$PWD/storage/framework/testing/intl03b.sqlite" DB_URL= APP_ENV=testing CACHE_STORE=array SESSION_DRIVER=array php artisan db:seed --class=IntlInsightSeeder --force
# 행·해시 조회 후 위 명령 한 번 더 실행하고 재조회
```

매 실행 출력과 exit:

```text
INFO  Seeding database.
exit=0
```

최종 첫 조회:

```json
{"all_rows":104,"own_rows":52,"per_article_locale_ok":true,"rows_sha256":"12906ec3c314e4be06e1e4c83f1b73e9b28ea123e28e878ec1a8f6aa9c8a211e","own_rows_sha256":"42a5c13081c7a37b806b71fc95c2f73bfee02269b4006ba254df3f16d6bcf2fc"}
```

최종 두 번째 조회:

```json
{"all_rows":104,"own_rows":52,"per_article_locale_ok":true,"rows_sha256":"12906ec3c314e4be06e1e4c83f1b73e9b28ea123e28e878ec1a8f6aa9c8a211e","own_rows_sha256":"42a5c13081c7a37b806b71fc95c2f73bfee02269b4006ba254df3f16d6bcf2fc"}
```

SHA256은 SQLite의 `select * from insight_translations order by id` 전체 행을 Python `json.dumps(..., ensure_ascii=False)`로 직렬화한 값이다. B 해시는 목록 27~52의 insight에 해당하는 행만 같은 방식으로 정렬·직렬화한 값이다. 시더가 반쯤 쓴 타 세션 JSON 때문에 실패한 사례는 없었다.

### stale

```sh
DB_CONNECTION=sqlite DB_DATABASE="$PWD/storage/framework/testing/intl03b.sqlite" DB_URL= APP_ENV=testing CACHE_STORE=array SESSION_DRIVER=array php artisan intl:stale
```

```text
+---------+--------+------------------+-------------+--------------+
| ko_slug | locale | translation_slug | source_hash | current_hash |
+---------+--------+------------------+-------------+--------------+
Stale translations: 0
```

### 실제 HTTP

```sh
DB_CONNECTION=sqlite DB_DATABASE="$PWD/storage/framework/testing/intl03b.sqlite" DB_URL= APP_ENV=testing CACHE_STORE=array SESSION_DRIVER=array MAIL_MAILER=array QUEUE_CONNECTION=sync php artisan serve --host=127.0.0.1 --port=8033
```

Python urllib로 B의 모든 JSON에서 EN/JA slug를 읽고 `http://127.0.0.1:8033/{locale}/insights/{slug}`에 실제 GET을 보냈다.

```text
HTTP responses: 52
HTTP 200: 52
Translated titles found after html.unescape: 52
```

최종 상태는 §1의 글별 표와 같다. 확인 후 해당 실행 세션에 Ctrl-C를 보내 exit 130으로 종료했고, `lsof -nP -iTCP:8033 -sTCP:LISTEN`은 출력 없이 exit 1이었다. 금지된 다른 포트를 사용하지 않았다.

### 전체 테스트·동시 작업 분리

명령은 `php artisan test`이며 **DB_DATABASE를 붙이지 않았다.**

초기 B 투입 전:

```json
{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":51749}
```

초기 B 투입 후:

```json
{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":47087}
```

도중 동시 작업의 언어 파일 상태에 따라 다음 두 실패가 관찰되었다. **테스트·화면·언어 파일을 수정하지 않았고**, 요청대로 실패 이름과 메시지를 아래 그대로 기록한다.

```text
Tests\Feature\IntlPagesTest::test_translated_pagination_and_article_rendering_use_locale_data
/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Feature/IntlPagesTest.php:160
/en/blog/ Translation key: pages/insights.heading
Failed asserting that 1 is identical to 0.

Tests\Feature\IntlPagesTest::test_language_files_have_identical_keys_and_faq_contains_all_81_items
/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/tests/Feature/IntlPagesTest.php:200
insights.php
Failed asserting that two arrays are identical.
--- Expected
+++ Actual
@@ @@
 Array &0 [
 0 => '.title',
 1 => '.description',
- 2 => '.lead',
- 3 => '.category_lead',
- 4 => '.all',
- 5 => '.categories',
- 6 => '.empty',
- 7 => '.empty_lead',
- 8 => '.category_empty',
- 9 => '.all_link',
- 10 => '.contact',
- 11 => '.home',
- 12 => '.breadcrumb',
- 13 => '.published',
- 14 => '.reading',
- 15 => '.toc',
- 16 => '.category',
- 17 => '.sources',
- 18 => '.source',
- 19 => '.back',
- 20 => '.related_services',
- 21 => '.cta_heading',
- 22 => '.cta_lead',
- 23 => '.cta',
- 24 => '.related',
- 25 => '.other',
- 26 => '.pagination',
- 27 => '.previous',
- 28 => '.next',
- 29 => '.date_format',
+ 2 => '.heading',
+ 3 => '.lead',
+ 4 => '.category_lead',
+ 5 => '.all',
+ 6 => '.categories',
+ 7 => '.empty',
+ 8 => '.empty_lead',
+ 9 => '.category_empty',
+ 10 => '.all_link',
+ 11 => '.contact',
+ 12 => '.home',
+ 13 => '.breadcrumb',
+ 14 => '.published',
+ 15 => '.reading',
+ 16 => '.toc',
+ 17 => '.category',
+ 18 => '.sources',
+ 19 => '.source',
+ 20 => '.back',
+ 21 => '.related_services',
+ 22 => '.cta_heading',
+ 23 => '.cta_lead',
+ 24 => '.cta',
+ 25 => '.related',
+ 26 => '.other',
+ 27 => '.pagination',
+ 28 => '.previous',
+ 29 => '.next',
+ 30 => '.date_format',
 ]
```

그 뒤 EN·JA `pages/insights.php`에서 heading 키가 모두 존재하는 상태가 확인되었다. B 26개 JSON을 `/tmp/intl03b-test-without/`로 잠시 옮겨 전체 테스트를 실행한 후 전부 복원했다.

B 제외:

```json
{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":54044}
```

B 복원 최종:

```json
{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":35729}
```

따라서 최종 비교에서 **B 파일 때문에 생긴 실패는 0개**다. 다른 세션 파일의 동시 갱신을 되돌리지 않았다.

### 무력화 실험

공유 폴더에서 다른 시더가 시험용 한글을 읽지 않도록, 27번 최종 JSON과 같은 내용의 **폴더 밖 원자 교체 대기본**에서 수행했다. 동일한 점검 스크립트의 `--staged` 입력 경로만 바꿨다.

```text
before SHA256: d794dba4badd0cf2b8d94c9f157861e29f14610040288c3f6dc4346bb3ea162e
en.content 첫 텍스트에 "한글 " 삽입
27 en check1_hangul:2
files=26 translations=52 failures=1 slug_collisions=0
exit=1

원복
after SHA256:  d794dba4badd0cf2b8d94c9f157861e29f14610040288c3f6dc4346bb3ea162e
files=26 translations=52 failures=0 slug_collisions=0
exit=0
```

최종 저장소의 27번 파일 SHA256도 위 값과 동일함을 확인했다.

## 7. 변경 파일·SHA256

아래는 이 세션이 생성한 JSON 26개다. 문서 이외의 추가 저장소 코드 변경은 없다.

| 파일 | SHA256 |
|---|---|
| `database/content/intl/insights/check-nofollow-links-in-chrome-and-firefox.json` | `281763466f00e0fb8478a6916b5f6a2c99e921190bc5131597b9e53053c9c690` |
| `database/content/intl/insights/choose-facebook-ad-formats-by-campaign-objective.json` | `1fdce6b18c1aad2964ddda1d0b7c0422616f1435d9c09395ae26e40871680545` |
| `database/content/intl/insights/choosing-a-cpa-marketing-agency-key-considerations.json` | `8d191e29d238ab95a02f38ccb4b9355213120be35aa555d804f3a7f19e2f3065` |
| `database/content/intl/insights/common-rumors-about-instagram-marketing-explained.json` | `9de99092b5e633f134a4edb2868e9cd55422b59134c0da8c1e16b5fd2271c2b0` |
| `database/content/intl/insights/does-naver-smart-store-need-search-ads.json` | `c8c1332a50d3bb5309e3f8ac03d6379df2e9369fe68a7a410a726c80d6c7060d` |
| `database/content/intl/insights/eleven-common-seo-mistakes-and-how-to-avoid.json` | `1d21ba7770e0396582556118750689ba628541aa175b4aa9125b0237bc68df07` |
| `database/content/intl/insights/facebook-ad-targeting-guide-for-beginners.json` | `e9bf714eabfc3ec3c82172076ca2e81fbe25c8c46908a57d3cfc545cad3df536` |
| `database/content/intl/insights/finding-effective-keywords-for-naver-smart-store.json` | `86a799368dfc478a5c21e81464814dd89974b177560b6b60a6f17a0fd7e362cf` |
| `database/content/intl/insights/how-to-make-google-ads-work-better.json` | `d9d56b43ed16d540bf2961ee7f2680de2d001ea804f46450445e2db27148352a` |
| `database/content/intl/insights/how-to-run-and-manage-instagram-ads.json` | `15e9963f5c846b1962e6b51d906f48a292de64427172d6457cd76881c7559bd2` |
| `database/content/intl/insights/how-to-run-permission-marketing-properly.json` | `7a0696aab440f884884629e4ec3027264c66d56f551c8229be934cbba62cf22c` |
| `database/content/intl/insights/introducing-the-my-influencer-marketing-platform.json` | `030e74de56eb12f5ecd4f7f8fc877fc30a05f9e0bc75007a05862f4ae7064e34` |
| `database/content/intl/insights/jcurve-completes-trademark-registration-for-nobb.json` | `aa5eecb83214f9920d88d94ff61c6627e0e61a8b91cc7e88fac5f42f2739134e` |
| `database/content/intl/insights/jcurve-develops-crmpro-for-cpa-customer-management.json` | `3b50e3c46ddf879e0655ae24ccb725a182049bba5558e33d50ae2b6545ae9a3e` |
| `database/content/intl/insights/jcurve-earns-innovation-growth-venture-company-certification.json` | `16117a0641cb0c9a9e393ea9236732a9a9aa54f6ce984aa52c72c71ec0e8dae1` |
| `database/content/intl/insights/jcurve-establishes-its-corporate-research-institute.json` | `d8aef8fbb263f2c76f6b0e91e17360d7f4490d47dc4795696dc57d939c1596e3` |
| `database/content/intl/insights/jcurve-expands-into-youtube-with-foodie-mate.json` | `03359439ebdfcdf7f704b98f266aeca5499ddc68b3464639769182e2db501442` |
| `database/content/intl/insights/seven-steps-to-content-marketing-strategy.json` | `d794dba4badd0cf2b8d94c9f157861e29f14610040288c3f6dc4346bb3ea162e` |
| `database/content/intl/insights/six-advanced-link-building-strategies-to-outperform-competitors.json` | `5427664cf296a18b9c2eb6ca250235a64aac1d26361368fd3884cefdfa30dae8` |
| `database/content/intl/insights/stock-cpa-and-consent-based-leads-at-jcurve.json` | `86761b07ae67b0b8156522ca382f044395b59ab88467866f5a91b71c42bc47dc` |
| `database/content/intl/insights/track-purchases-and-conversions-with-google-analytics.json` | `00549a6192df1f553cfc3659a62a0d9b18eefaa93051759d57a703ecd71c148c` |
| `database/content/intl/insights/twelve-essential-formulas-for-digital-marketing.json` | `28e347d7a352239a0321a851563340bdc5887b0e5c0795a263e84024f2cac3fa` |
| `database/content/intl/insights/understanding-instagram-top-posts-ranking-algorithm.json` | `a113ac88109e6f02cb4d36c74d6b0a246477f1f714222b6674cb5d2145062950` |
| `database/content/intl/insights/what-is-a-marketing-funnel-part-one.json` | `a743408e8b8d4221425a7c1ff86df3c5b30f4fa79a21c5ff7550b0082dae6ad4` |
| `database/content/intl/insights/what-makes-instagram-stories-ads-different.json` | `0f92df6c6b6f560d47eeaf0ec8b933ed62a31d28180083c65132cb88f360a3fc` |
| `database/content/intl/insights/why-testing-facebook-ad-creative-matters.json` | `3cc91ed6922ba19bd51aec89ae8a9931649421a34253582487be8ac736f8314f` |

- 반환물: `docs/intl/INTL-03B-IMPL-RESULT.md`.
- 동시 세션이 수정한 A의 mobile-marketing-strategies·influencer-marketing-trends-for-2019 및 기타 A 파일, 화면 언어 파일, GLOSSARY, 새 지시서는 이 세션이 저장하거나 되돌리지 않았다.
- 작업 도중 공유 HEAD의 변경을 관찰했으나 이 세션은 Git 쓰기 명령을 실행하지 않았다.

## 8. 미검증·인계

- 원어민 교정, 공식 영문 서비스·고객사명 확인, 원문 자체의 오래된 정책·수치·계산식 검수는 미실시다. §5를 Claude 검수 대상으로 남긴다.
- 브라우저 시각·반응형·접근성 및 화면 공통부 검수는 INTL-02 범위이며, B는 실제 HTTP·번역 제목·DB·지정 구조 점검까지 확인했다.
- 운영 DB·운영 서버·배포는 다루지 않았다.
- 저장소 밖 공용 대시보드 tasks.json 갱신·렌더는 이 세션의 쓰기 허용 범위 밖이며, 지정된 B 파일 소유 범위를 지키기 위해 실행하지 않았다.
- 독립 검증자는 최종 26개 JSON과 이 문서를 대상으로 검증하고, 최종 합격은 Claude가 판정한다.
