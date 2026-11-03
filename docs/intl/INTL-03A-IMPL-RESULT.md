# INTL-03A 구현 반환물

- 작업 ID: INTL-03A / 구현 세션 A / 2026-11-03 KST
- 작업 폴더: `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`
- 브랜치: `wip/2026-11-03-i18n`
- 기준·관측 HEAD: `6ad6c8db8730f5615521d32660628da8ea0ba316`
- 지시서: `SPEC-CODEX-INTL-03.md` 전체와 맨 아래 추가 지시를 우선 적용했다. INTL-PLAN §1·§5, GLOSSARY 전체, INTL-01 구현 결과의 라우트·원문·시더 계약, 시더·예시 JSON, COLLAB·QUEUE를 읽었다.
- 담당: Codex가 지정된 26편의 번역 초벌과 로컬 실행 증거를 만들었다. 별도 세션 독립 검증·Claude 최종 판정은 남아 있다.

## 1. 산출물과 범위

`database/content/intl/insights/*.json` **26개**: 신규 25개 + 예시 파일 1개 실제 번역으로 교체. EN 26편 + JA 26편이다. 소유 JSON과 이 반환 문서만 작업했다. 한국어 글, 시더, 마이그레이션, 화면, 테스트, INTL-03B 범위는 수정하지 않았다.

예시 `mobile-marketing-strategies.json`은 파일명을 유지하고 EN·JA slug를 모두 `mobile-marketing-strategies`로 맞췄다. 두 언어의 DRAFT 제목·요약·본문·메타는 실제 번역으로 교체했다. 15·16번은 원문 제목과 본문 해시가 같은 별도 공개 글이어서 두 글을 유지하고, 16번 slug에 `archive`를 붙였다.

Google Translate 공개 번역 엔드포인트를 이용해 초벌을 생성하고, 용어집, 제목, 숫자·통화 단위, 회사명, 일부 문맥 오역을 교정했다. 단어별로 잘린 Word HTML은 문단의 문맥으로 번역한 뒤 기존 텍스트 슬롯에 다시 배치했다. 태그·속성·순서·이미지·표·목록은 보존했다. 글 전체에 대한 전문 영·일 교열 완료를 의미하지 않는다.

JSON은 폴더 밖 `/private/tmp/intl03a/`에서 native patch로 완성한 뒤 파일별 `mv`/`os.replace`로 원자적으로 옮겼다. 시더 실행 중 다른 세션의 불완전 JSON으로 인한 실패는 관측하지 않았다.

최종 관측:

- 공개 한국어 글: **52편**
- A JSON: **26개**, 1,162,261 bytes
- A 번역 DB: **52행**; 각 글·언어 1행, slug·title·excerpt·content·meta_title·meta_description 및 source_hash 일치
- 본문·제목·요약·메타·alt/title 속성 한글 잔존: **0**
- 태그 순서·속성, img 개수·src 순서, a 개수, 표·목록 구조 차이: **0**
- DOMDocument 원문 오류 **0**, 번역의 신규 오류 **0**
- slug 형식·단어 수·메타 길이 초과: **0**. mobile slug는 지시된 예외 적용
- EN **26/26**, JA **26/26** 실제 애플리케이션 GET 응답 **200**
- `intl:stale`: **0**
- 최종 공유 폴더 JSON **26개**. 이 시점에는 B JSON이 아직 없었다. 현재 폴더 전체에서 언어별 slug 중복은 **0**이며, B가 나중에 추가되면 최종 통합에서 다시 대조해야 한다. 충돌 시 B가 자기 slug를 바꾸는 계약을 유지한다.
- A 파일명(이 표 순서) + 파일 bytes의 SHA256: `a5b7f0db609b2b30cac9e6fde9653c57e884777ebb89346e3335368ed1f12ef1`

## 2. 글별 결과

글자 수는 PHP `mb_strlen(strip_tags(content))` 기준 EN / JA다.

① 본문·title·excerpt·meta·alt/title 한글 0  
② 원문 이미지·링크 개수·표·목록 및 전체 HTML 구조·비번역 속성 동일  
③ 원문/번역 숫자 토큰 다중집합 비교. 차이는 §3에 기록하며 합격/실패로 사용하지 않음  
④ DOMDocument 신규 파싱 오류 0  
⑤ slug 형식·유일성·단어 수와 메타 길이 통과  
⑥ DB 각 1행·6필드·source_hash 일치, stale 0, GET 상태

| # | 한국어 slug | EN·JA 공통 slug / 파일명(.json) | 영문 제목 | 일본어 제목 | 본문 글자 수 EN / JA | ① | ② | ③ | ④ | ⑤ | ⑥ EN / JA |
|---|---|---|---|---|---:|---|---|---|---|---|---|
| 1 | `반드시-알아야-할-모바일-마케팅-전략-5가지` | `mobile-marketing-strategies` | Five mobile marketing strategies you need to know | 知っておきたいモバイルマーケティング戦略5選 | 4972 / 2295 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 2 | `2019년-인플루언서마케팅-핵심-트렌드` | `influencer-marketing-trends-for-2019` | Key influencer marketing trends for 2019 | 2019年のインフルエンサーマーケティング動向 | 11318 / 5489 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 3 | `2019년-필요한-유튜브마케팅-전략` | `youtube-marketing-strategies-for-2019` | YouTube marketing strategies for 2019 | 2019年に必要なYouTubeマーケティング戦略 | 8334 / 4294 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 4 | `페이스북광고-게재-옵션과-노출-위치-설정은-어떻게` | `facebook-ad-delivery-and-placement-settings` | How to set Facebook ad delivery and placements | Facebook広告の配信と配置の設定方法 | 5106 / 2728 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 5 | `페이스북-광고관리자로-캠페인-세팅하기` | `set-up-campaigns-facebook-ads-manager` | Set up campaigns in Facebook Ads Manager | Facebook広告マネージャでキャンペーンを設定 | 7330 / 3927 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 6 | `인스타그램마케팅-인스타그램쇼핑-가이드` | `instagram-marketing-and-shopping-guide` | Instagram marketing: a guide to Instagram Shopping | Instagramマーケティングとショッピングのガイド | 5596 / 3021 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 7 | `디지털마케터의-역할-인바운드-마케팅과-디지털-마케팅` | `digital-marketer-inbound-and-digital-marketing` | The digital marketer: inbound and digital marketing | デジタル担当者の役割とインバウンドマーケティング | 13070 / 6546 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 8 | `디지털마케팅-기초적인-개념과-용어-정리` | `digital-marketing-basic-concepts-and-terms` | Digital marketing: basic concepts and terms | デジタルマーケティングの基礎概念と用語 | 10188 / 5231 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 9 | `페이스북-광고-계정-설정-방법` | `set-up-facebook-ad-account` | How to set up a Facebook ad account | Facebook広告アカウントの設定方法 | 7465 / 3727 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 10 | `페이스북-광고-보고서를-통한-캠페인-최적화` | `optimize-campaigns-facebook-ad-reports` | Optimize campaigns with Facebook ad reports | Facebook広告レポートでキャンペーンを最適化 | 4580 / 2412 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 11 | `구글광고-맞춤-타겟-설정-방법` | `set-up-google-ads-custom-audiences` | How to set up custom audiences in Google Ads | Google広告のカスタムオーディエンス設定方法 | 4748 / 2481 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 12 | `구글-광고-통화-전환-추적방법` | `track-phone-call-conversions-google-ads` | How to track call conversions in Google Ads | Google広告の通話コンバージョンを測定する方法 | 4047 / 2055 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 13 | `2019년-그로스해커에게-필요한-스킬1` | `growth-hacker-skills-2019-part-one` | Skills growth hackers need in 2019 (1) | 2019年に必要なグロースハッカーのスキル（1） | 9321 / 4838 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 14 | `2019년-그로스해커에게-필요한-스킬2-1` | `growth-hacker-skills-2019-part-two` | Skills growth hackers need in 2019 (2) | 2019年に必要なグロースハッカーのスキル（2） | 6157 / 2968 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 15 | `2019년-그로스해커에게-필요한-스킬3-1` | `growth-hacker-skills-2019-part-three` | Skills growth hackers need in 2019 (3) | 2019年に必要なグロースハッカーのスキル（3） | 6792 / 3379 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 16 | `2019년-그로스해커에게-필요한-스킬3` | `growth-hacker-skills-2019-part-three-archive` | Skills growth hackers need in 2019 (3) | 2019年に必要なグロースハッカーのスキル（3） | 6792 / 3379 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 17 | `페이스북광고-입찰-최적화-방법` | `optimize-bidding-for-facebook-ads` | How to optimize bidding for Facebook ads | Facebook広告の入札を最適化する方法 | 5974 / 3059 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 18 | `페이스북광고-ab테스트-가이드` | `facebook-ads-ab-testing-guide` | A guide to A/B testing Facebook ads | Facebook広告のA/Bテストガイド | 6198 / 3076 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 19 | `페이스북-마케팅-실전-기법-전략-수립-7단계` | `facebook-marketing-strategy-seven-step-guide` | Facebook marketing: a seven-step strategy guide | Facebookマーケティング戦略の7ステップ | 7233 / 3475 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 20 | `페이스북마케팅-광고-소재와-문구는-어떻게` | `facebook-marketing-ad-creative-and-copy` | Facebook marketing: ad creative and copy | Facebook広告のクリエイティブとコピー | 4553 / 2281 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 21 | `구글광고-보고서에서-중요한-지표는` | `important-metrics-in-google-ads-reports` | Which metrics matter in Google Ads reports? | Google広告レポートで重要な指標とは | 7022 / 3292 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 22 | `조회수를-극대화하기-위해-유튜브-채널을-홍보하는-방법` | `promote-youtube-channel-for-more-views` | How to promote a YouTube channel for more views | 視聴回数を増やすYouTubeチャンネルの宣伝方法 | 2683 / 1386 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 23 | `성공적인-유튜브-인플루언서-마케팅-전략을-개발하는-방법` | `develop-youtube-influencer-marketing-strategy` | Develop a YouTube influencer marketing strategy | YouTubeインフルエンサーマーケティング戦略 | 12726 / 6190 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 24 | `구글-광고-계정-설정-방법` | `set-up-google-ads-account` | How to set up a Google Ads account | Google広告アカウントの設定方法 | 8317 / 4605 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 25 | `구글-광고-세팅-시간을-줄이는-법` | `reduce-google-ads-campaign-setup-time` | How to reduce Google Ads setup time | Google広告の設定時間を短縮する方法 | 7458 / 3648 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |
| 26 | `구글-광고-전환에-최적화된-랜딩페이지-제작-방법` | `build-landing-pages-for-google-ads-conversions` | Build landing pages for Google Ads conversions | Google広告のコンバージョンを促すLP制作 | 5745 / 2943 | 통과 | 통과 | 차이 목록 | 통과 | 통과 | 200 / 200 |

## 3. 숫자 차이 목록

본문의 태그를 제거하고 HTML entity를 해제한 뒤 `\d+(?:,\d{3})*(?:\.\d+)?` 토큰을 비교했다. 아래는 **다중집합의 차이**이며 위치별 대응을 뜻하지 않는다. 표에 없는 글·언어는 토큰 목록이 동일하다.

영어의 Five/three/six 등 수사, 일본어의 원문 한자 수사에 대한 아라비아 숫자 표기, 시간의 `:00`, M/B·억/만 변환으로 토큰이 달라질 수 있다. 숫자 토큰 검사만으로 문장 의미의 동일성을 판정하지 않았으며 Claude 검수용으로 차이를 전부 남겼다.

| 글 # | 언어 | 원문에만 남는 토큰 | 번역에만 남는 토큰 |
|---|---|---|---|
| 1 | EN | `5` | — |
| 2 | EN | `10` × 4, `4`, `100` × 2 | `1`, `100,000` × 2 |
| 2 | JA | — | `1` × 2 |
| 3 | EN | `6` | — |
| 3 | JA | — | `3` |
| 4 | JA | — | `1`, `2` |
| 5 | EN | `2`, `3` | — |
| 5 | JA | — | `1`, `4` |
| 6 | EN | `4`, `10` | `1` |
| 6 | JA | — | `1` × 2 |
| 7 | EN | `1`, `2`, `6` | — |
| 7 | JA | — | `2` |
| 8 | EN | `3` | — |
| 8 | JA | — | `1` |
| 9 | JA | — | `2`, `1`, `3` |
| 10 | EN | `4` | — |
| 10 | JA | — | `3`, `1` × 3, `4` |
| 11 | JA | — | `2` × 4, `1` × 2 |
| 12 | JA | — | `3` × 2, `1` |
| 13 | EN | `3`, `5`, `10`, `400`, `280` | `4`, `100,000`, `2.8` |
| 13 | JA | — | `3`, `1` |
| 14 | EN | `3`, `20` | `200,000` |
| 14 | JA | — | `2`, `1` |
| 15 | EN | `3` | — |
| 15 | JA | — | `2`, `1` |
| 16 | EN | `3` | — |
| 16 | JA | — | `2`, `1` |
| 17 | JA | — | `3`, `1` × 10, `2` × 4 |
| 18 | EN | `236`, `101`, `3` × 3, `5`, `120` | `2.36`, `1.01`, `1.2` |
| 18 | JA | — | `2` × 3, `1` × 3 |
| 19 | EN | `7`, `400` | `00` × 2, `4` |
| 19 | JA | — | `1` × 3, `2` |
| 20 | JA | — | `1`, `3`, `2` |
| 21 | EN | `1` | — |
| 21 | JA | — | `2` × 3, `1` × 2 |
| 22 | EN | `6` | — |
| 22 | JA | — | `2` × 2, `1` |
| 23 | EN | `2` × 2, `5` × 2, `3`, `4` | `500`, `30`, `50,000` |
| 23 | JA | — | `2` × 4, `1` |
| 24 | JA | — | `1` × 2 |
| 25 | JA | — | `10` × 2, `1` × 5 |
| 26 | JA | — | `1`, `2` |

값을 환산하지 않고 자리·통화 표기만 옮긴 주요 항목:

| 글 # | 한국어 원문 | 영어 표기 | 일본어 표기 |
|---|---|---|---|
| 2 | 100만 / 10만 / 10억 | 1M / 100,000 / 1B | 100万 / 10万 / 10億 |
| 6 | 10억 달러 | USD 1B | 10億ドル |
| 13 | 10만 / 400만 / 280만 | 100,000 / 4M / 2.8M | 10万 / 400万 / 280万 |
| 14 | 20만 원 | KRW 200,000 | 20万ウォン |
| 18 | 236만 원 / 101만 원 / 3,000원 / 120만 원 | KRW 2.36M / KRW 1.01M / KRW 3,000 / KRW 1.2M | 236万ウォン / 101万ウォン / 3,000ウォン / 120万ウォン |
| 19 | 400만 명 | 4M | 400万 |
| 21 | 10·15·50·100·200 달러 | 같은 값의 USD | 같은 값의 ドル |
| 23 | 5억 / 3천만 / 5만 명 | 500M / 30M / 50,000 | 5億 / 3千万 / 5万 |
| 23 | 500~5,000 달러, 1달러 | 같은 값의 USD | 같은 값의 ドル |
| 24 | 500 달러 | USD 500 | 500ドル |

원화를 USD·JPY로 환산하지 않았다. 원문의 2019년 맥락, 날짜, 광고 UI·통계·예측 문장은 현재 사실로 갱신하지 않았다.

## 4. 내부 링크

A 범위 본문에는 번역 주소로 바꿀 **정적 페이지 링크 0개, 다른 블로그 글 링크 0개**였다. 따라서 다른 세션 글로 가는 한국어 링크를 남겨 Claude에게 재매핑을 요청할 항목은 없다.

아래 한국어 도메인 링크는 모두 원본 이미지 뷰어다. 외국어 페이지 라우트 대상이 아니므로 href를 보존했다. src도 원문과 같다. EN·JA가 같은 href를 사용한다.

| 글 # | a 수 | 처리 |
|---|---:|---|
| 19 | 2 | 원문 이미지 뷰어 URL 보존 |
| 20 | 4 | 원문 이미지 뷰어 URL 보존 |
| 21 | 3 | 원문 이미지 뷰어 URL 보존 |
| 23 | 8 | 원문 이미지 뷰어 URL 보존 |
| 24 | 3 | 원문 이미지 뷰어 URL 보존 |
| 26 | 5 | 원문 이미지 뷰어 URL 보존 |

<details>
<summary>보존한 원본 이미지 뷰어 href 25개</summary>

글 19:

- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F8d193ab535db46cfbd9881a61a4d8732_1575344590_1527.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F8d193ab535db46cfbd9881a61a4d8732_1575346752_8528.png`

글 20:

- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Faad767404bca59eeb5bdb80cf9af1ce8_1575425985_6401.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Faad767404bca59eeb5bdb80cf9af1ce8_1575425989_3641.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Faad767404bca59eeb5bdb80cf9af1ce8_1575425992_7859.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Faad767404bca59eeb5bdb80cf9af1ce8_1575425997_024.png`

글 21:

- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F67a1c21ffd96530fbb692b5d68c24ab3_1575512878_5327.jpg`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F67a1c21ffd96530fbb692b5d68c24ab3_1575513352_8705.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F67a1c21ffd96530fbb692b5d68c24ab3_1575513399_6968.png`

글 23:

- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872622_9777.jpg`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872624_511.jpg`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872633_6355.jpg`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872635_033.jpg`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872636_5512.jpg`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872638_0987.jpg`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872640_8423.jpg`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2Ffae8ea6a64b65ebcf279f0a167e054cf_1575872642_068.jpg`

글 24:

- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F70b7b16ef5cc45d6af5ca5ecab6bc2ce_1576213632_4606.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F70b7b16ef5cc45d6af5ca5ecab6bc2ce_1576213680_2804.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F70b7b16ef5cc45d6af5ca5ecab6bc2ce_1576213774_4113.png`

글 26:

- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F36a20fe760e47b7579b1689a6957e215_1576551881_6127.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F36a20fe760e47b7579b1689a6957e215_1576551893_3596.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F36a20fe760e47b7579b1689a6957e215_1576551905_2192.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F36a20fe760e47b7579b1689a6957e215_1576554154_7483.png`
- `https://j-curve.co.kr/v1/manager/bbs/view_image.php?fn=http%3A%2F%2Fj-curve.co.kr%2Fmanager%2Fdata%2Feditor%2F1912%2F36a20fe760e47b7579b1689a6957e215_1576554164_6592.png`

</details>

## 5. 확인이 필요한 용어·원문

- 15·16번의 `자피에` → Zapier, `덥숩` → Dux-Soup: 자동화 도구 문맥으로 식별한 표기다. 원문에 해당 제품 URL이 없어 제품 식별·공식 표기는 최종 교열에서 확인이 필요하다.
- 13번의 `해적 퍼널` → pirate funnel / 海賊ファンネル: 원문 표현을 보존했다. 일본어 독자용 업계 용어는 최종 교열에서 확인해야 한다.
- 13번의 추가 프로젝트 마케팅·B2B 지역 봉사 등은 원문 자체가 모호하다. 새 개념이나 설명을 덧붙이지 않았다.
- 4·10번 Audience Network의 `틈새/삽입` 광고는 광고 문맥에 맞춰 interstitial ads / インタースティシャル広告로 정리했다. 2019년 UI 표기를 현재 제품 UI와 일치시킨 것은 아니다.
- 23번의 구독자 구매 단가 등 이례적인 수치도 원문대로 보존했다. 사실 검증·통계 갱신은 수행하지 않았다.
- 한국 플랫폼 NAVER·Coupang·Kakao의 첫 언급 설명이 필요한 본문은 A 범위에서 확인되지 않았다.
- 전체 일본어 자연스러움·영문 문장별 의미 대응·역사적 UI 표기의 전문 교열은 별도 검수 항목이다.

## 6. 실행 명령과 실제 결과

`DB_DATABASE`를 셸에 export하지 않았다. 모든 DB 명령에만 A 전용 파일을 붙였다. 실DB·Claude 임시 DB·B 임시 DB는 사용하지 않았다. `php artisan test`에는 이 파일 경로를 붙이지 않았고 PHPUnit의 격리 SQLite 테스트 설정을 사용했다.

### A 전용 DB 준비

```sh
mkdir -p storage/framework/testing
touch storage/framework/testing/intl03a.sqlite
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= DB_CONNECTION=sqlite DB_DATABASE="$PWD/storage/framework/testing/intl03a.sqlite" DB_URL='' CACHE_STORE=array SESSION_DRIVER=array QUEUE_CONNECTION=sync MAIL_MAILER=array php artisan migrate:fresh --seed --force --no-interaction
```

실제 출력: migration 19개 및 BoardSeeder·InsightCategorySeeder·LegacyRedirectSeeder·LegacyContentSeeder·IntlInsightSeeder 모두 DONE, exit 0. 앱의 `Insight::published()->count()` 결과 52. 26편 표시본 해시는 목록의 source_hash와 모두 일치했다.

### 자동 점검·DB·GET

```sh
python3 /private/tmp/intl03a/validate.py
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= DB_CONNECTION=sqlite DB_DATABASE="$PWD/storage/framework/testing/intl03a.sqlite" DB_URL='' CACHE_STORE=array SESSION_DRIVER=array QUEUE_CONNECTION=sync MAIL_MAILER=array php /private/tmp/intl03a/check.php
```

실제 출력에서 추출한 결과:

```text
JSON: 26 failures: [] duplicate slugs: []
published: 52
total_translations: 52
GET 200: 52/52
db_fields_match: true (all 52 translations)
db_rows: 1 (each article / locale)
db_hash_matches: true (all 52 translations)
source DOM errors: 0
new DOM errors: 0
```

별도 서버나 포트를 띄우지 않고 Laravel HTTP Kernel에 실제 GET 요청을 보냈다. INTL-02가 만든 상세 뷰가 존재해서 대기 대신 200을 확인했다. 단순 DB 조회를 HTTP 확인으로 대체하지 않았다.

### 시더 두 번·stale

동일 명령을 두 번 실행했다:

```sh
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= DB_CONNECTION=sqlite DB_DATABASE="$PWD/storage/framework/testing/intl03a.sqlite" DB_URL='' CACHE_STORE=array SESSION_DRIVER=array QUEUE_CONNECTION=sync MAIL_MAILER=array php artisan db:seed --class=IntlInsightSeeder --force --no-interaction
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= DB_CONNECTION=sqlite DB_DATABASE="$PWD/storage/framework/testing/intl03a.sqlite" DB_URL='' CACHE_STORE=array SESSION_DRIVER=array QUEUE_CONNECTION=sync MAIL_MAILER=array php artisan db:seed --class=IntlInsightSeeder --force --no-interaction
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= DB_CONNECTION=sqlite DB_DATABASE="$PWD/storage/framework/testing/intl03a.sqlite" DB_URL='' CACHE_STORE=array SESSION_DRIVER=array php artisan intl:stale
```

```text
Before repeat: rows 52 sha256 7ea79e4cfc9a57b1810ae03f680b513dd17f778b3603b2a20735f2f6e7930319
After repeat: rows 52 sha256 7ea79e4cfc9a57b1810ae03f680b513dd17f778b3603b2a20735f2f6e7930319
Stale translations: 0
```

전체 행 `select * from insight_translations order by id`의 JSON SHA256을 비교했다. 행 수뿐 아니라 translated_at을 포함한 실제 행 내용도 동일했다.

### 전체 테스트와 JSON 제거 비교

```sh
APP_ENV=testing APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA= DB_URL='' php artisan test --no-ansi
python3 /private/tmp/intl03a/ablation.py
```

최종 전체 테스트 출력:

```json
{"tool": "phpunit", "result": "passed", "tests": 206, "passed": 206, "assertions": 36008, "duration_ms": 24532}
```

A JSON을 폴더 밖으로 옮긴 별도 전체 실행:

```text
Removed own complete JSON files: 26
{"test":{"tool":"phpunit","result":"passed","tests":206,"passed":206,"assertions":36008,"duration_ms":31505},"test_exit":0}
All 26 files restored with identical SHA256: True
Non-JSON code snapshot before: 6c36f97338534359697d849580f8bc05c2ea575d2940440e471dca17fffa9186
Non-JSON code snapshot after: 6c36f97338534359697d849580f8bc05c2ea575d2940440e471dca17fffa9186
```

제거·복원은 A 파일명 26개만 대상으로 했고 `try/finally`로 복원했다. 테스트 사이 코드 스냅샷은 app·bootstrap·config·시더·마이그레이션·라우트·테스트·뷰·lang·phpunit.xml을 포함했다. JSON 유무에 따른 테스트 실패는 양쪽 모두 0이다.

### 한글 무력화 실험

2번 파일의 en.content 뒤에 `한글` 한 단어를 넣고 동일 점검기를 실행했다. 의도적으로 한글 검사만 실패했다. 파일은 원자적으로 복원했다.

```text
Before SHA256: 6955f6adc69d40c1c998ac9277c88ee7be356db0f3670db40db24b6da2079276
Mutation failures: [[2, "en", "hangul_or_token"]]
Mutation exit: 1
Restored SHA256: 6955f6adc69d40c1c998ac9277c88ee7be356db0f3670db40db24b6da2079276
Restored failures: []
Restored exit: 0
```

이 SHA는 실험 직전·원복 직후의 해시다. 이후 단위의 M/B 표기를 정리한 최종 파일 전체 해시는 §1에 별도로 기록했다.

## 7. 동시 작업 중 관측한 테스트 변화

아래는 A JSON 투입 전 실행에서 관측한 INTL-02 작업 중의 실패다. 해당 화면·테스트·언어 파일을 이 세션에서 고치지 않았다. 최종 실행에서는 전부 사라졌고 전체 206개가 통과했다.

첫 관측: 199개 중 195 통과, 4 실패. 오류 본체(거대한 HTML 덤프는 생략):

| 테스트 | 실제 메시지 |
|---|---|
| `IntlFoundationTest::test_legacy_landing_aliases_are_single_hop_but_excluded_destinations_have_no_foreign_redirect` | Expected response status code [404] but received 200. Failed asserting that 200 is identical to 404. |
| `IntlFoundationTest::test_url_helpers_preserve_addresses_and_use_public_origin_for_alternates` | does not contain "hreflang=" [ASCII](length: 9). |
| `IntlFoundationTest::test_korean_preserved_routes_expose_alternates_without_modifying_korean_views` | Failed asserting that two arrays are identical. Expected ko/en alternates; Actual Array &0 []. |
| `IntlFoundationTest::test_foreign_sitemap_entries_and_korean_rss_contract` | Failed asserting that a traversable contains 'https://j-curve.co.kr/en/privacy'. |

두 번째 관측: 205개 중 199 통과, 5 실패·1 오류. 로그는 `/private/tmp/intl03a/baseline-test.log`에 있다.

| 테스트 | 실제 메시지 |
|---|---|
| `IntlFoundationTest::test_all_static_targets_have_foreign_routes_and_missing_views_return_404` | Cannot access offset of type string on string (View: /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/resources/views/intl/pages/faq.blade.php) |
| `IntlFoundationTest::test_all_foreign_aliases_redirect_once_preserving_raw_queries` | Cannot access offset of type string on string (View: /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/resources/views/intl/pages/faq.blade.php) |
| `IntlFoundationTest::test_legacy_landing_aliases_are_single_hop_but_excluded_destinations_have_no_foreign_redirect` | Expected response status code [200] but received 404. Failed asserting that 404 is identical to 200. |
| `IntlPagesTest::test_every_page_has_localized_text_canonical_and_reciprocal_alternates` | Cannot access offset of type string on string (View: /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/resources/views/intl/pages/faq.blade.php) |
| `IntlPagesTest::test_all_internal_page_links_resolve_and_excluded_areas_are_not_linked` | Cannot access offset of type string on string (View: /Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/resources/views/intl/pages/faq.blade.php) |
| `IntlPagesTest::test_language_files_have_identical_keys_and_faq_contains_all_81_items` | require(/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n/lang/en/subpages.php): Failed to open stream: No such file or directory |

최종 실패는 0이므로 타 세션 파일에 대한 수정 요청이나 작업 범위 확대는 하지 않았다.

## 8. 미검증·운영 경계

- 별도 검증 세션의 판정, Claude 최종 교열·통합 검수는 수행하지 않았다.
- B 27~52번 JSON이 추가된 최종 52편 상태의 중복 slug·링크·전체 시더·테스트는 통합 세션에서 다시 확인해야 한다.
- 브라우저 시각 검수·실서버·검색엔진·배포 후 응답은 미검증이다. 이번 응답 검사는 격리 DB를 쓰는 로컬 Laravel Kernel 기준이다.
- 커밋·푸시·배포·발행, 브랜치 변경·stash·reset·checkout, .env 열람·변경은 하지 않았다.
- 원래 저장소를 작업 경로로 사용하거나 그 소스를 열어 수정하지 않았다.
- 대시보드 tasks.json 및 재생성 스크립트는 허용된 쓰기 경로 밖이라 갱신·실행하지 않았다. 본 작업의 지정 JSON과 반환 문서 범위만 작성했다.
- A 전용 DB는 `storage/framework/testing/intl03a.sqlite`, 검사용 임시 스크립트·로그는 `/private/tmp/intl03a/`에 남아 있다. 다른 세션 DB는 사용하지 않았다.

## 9. 재현용 점검 코드

임시 경로가 없어져도 아래 코드로 동일 점검을 재현할 수 있다. 운영 코드·테스트 파일은 아니다.

<details>
<summary>validate.py — 한글·구조·slug·메타·숫자·내부 링크</summary>

```python
import collections
import hashlib
import html
import json
import re
import sqlite3
import sys
from html.parser import HTMLParser
from pathlib import Path

ROOT=Path('/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n')
HANGUL=re.compile(r'[\u1100-\u11ff\u3130-\u318f\uac00-\ud7af]')

class Structure(HTMLParser):
    def __init__(self, content):
        super().__init__(convert_charrefs=True)
        self.tokens=[]; self.tags=collections.Counter(); self.images=[]; self.links=[]; self.text=[]; self.attrs=[]
        self.feed(content)
    def handle_starttag(self,tag,attrs):
        self.tags[tag]+=1
        self.tokens.append(('open',tag,tuple((k,v) for k,v in attrs if k not in ('alt','title'))))
        if tag=='img':self.images.append(dict(attrs).get('src'))
        if tag=='a':self.links.append(dict(attrs).get('href'))
        self.attrs.extend(v for k,v in attrs if k in ('alt','title') and v)
    def handle_startendtag(self,tag,attrs):
        self.handle_starttag(tag,attrs)
        self.tokens.append(('selfclose',tag))
    def handle_endtag(self,tag):self.tokens.append(('close',tag))
    def handle_data(self,data):self.text.append(data)

def main():
    catalog=json.loads((ROOT/'docs/intl/insights-list.json').read_text())[:26]
    db=sqlite3.connect(ROOT/'storage/framework/testing/intl03a.sqlite')
    files={}; duplicates=[]; seen={}
    content_dir=Path(sys.argv[1]) if len(sys.argv)>1 else ROOT/'database/content/intl/insights'
    for p in sorted(content_dir.glob('*.json')):
        if p.name in ('staging-check.json','final-check.json','runtime-check.json'):continue
        d=json.loads(p.read_text());files[d['ko_slug']]=(p,d)
        for loc in ('en','ja'):
            if loc not in d:continue
            key=(loc,d[loc]['slug'])
            if key in seen:duplicates.append([*key,seen[key],p.name])
            seen[key]=p.name
    results=[]
    for n,item in enumerate(catalog,1):
        if item['slug'] not in files:raise ValueError('Missing article '+str(n))
        p,d=files[item['slug']]
        source=db.execute('select content from insights where slug=?',(item['slug'],)).fetchone()[0]
        original=Structure(source)
        row={'index':n,'file':p.name,'source_hash':d['source_hash']==item['hash']==hashlib.sha256(source.encode()).hexdigest(),'locales':{}}
        for loc in ('en','ja'):
            t=d[loc];parsed=Structure(t['content'])
            strings=[t[f] for f in ('title','excerpt','meta_title','meta_description')]+parsed.text+parsed.attrs
            hangul=[s for s in strings if HANGUL.search(s)]
            before=re.findall(r'\d+(?:,\d{3})*(?:\.\d+)?',html.unescape(''.join(original.text)))
            after=re.findall(r'\d+(?:,\d{3})*(?:\.\d+)?',html.unescape(''.join(parsed.text)))
            bc,ac=collections.Counter(before),collections.Counter(after)
            slug=t['slug'];words=len(slug.split('-'))
            row['locales'][loc]={
                'hangul':hangul,'images_equal':original.images==parsed.images,
                'tags_equal':original.tags==parsed.tags,
                'structure_and_attrs_equal':original.tokens==parsed.tokens,
                'anchor_count_equal':original.tags['a']==parsed.tags['a'],
                'slug_valid':bool(re.fullmatch('[a-z0-9]+(?:-[a-z0-9]+)*',slug)) and (4<=words<=8 or slug=='mobile-marketing-strategies'),
                'meta_lengths':[len(t['meta_title']),len(t['meta_description'])],
                'meta_lengths_ok':len(t['meta_title'])<=(60 if loc=='en' else 32) and len(t['meta_description'])<=(155 if loc=='en' else 110),
                'numbers_removed':list((bc-ac).elements()),'numbers_added':list((ac-bc).elements()),
                'internal_links_unchanged':[v for v in parsed.links if v and ('j-curve.co.kr' in v or v.startswith('/'))],
                'unrestored_token':bool(re.search('ZXQ',t['content'])),
            }
        results.append(row)
    failures=[]
    for row in results:
        if not row['source_hash']:failures.append([row['index'],'hash'])
        for loc,r in row['locales'].items():
            for key in ('images_equal','tags_equal','structure_and_attrs_equal','anchor_count_equal','slug_valid','meta_lengths_ok'):
                if not r[key]:failures.append([row['index'],loc,key])
            if r['hangul'] or r['unrestored_token']:failures.append([row['index'],loc,'hangul_or_token'])
    print(json.dumps({'json_count':len(results),'duplicate_slugs':duplicates,'failures':failures,'results':results},ensure_ascii=False))
    if failures or duplicates:sys.exit(1)

if __name__=='__main__':main()
```

</details>

<details>
<summary>check.php — 표시본 해시·DOMDocument·DB 6필드·실제 GET</summary>

```php
<?php
// Temporary evidence collector for INTL-03A; no production configuration writes.
$root = '/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n';
require $root.'/vendor/autoload.php';
$app = require $root.'/bootstrap/app.php';
$console = $app->make(Illuminate\Contracts\Console\Kernel::class);
$console->bootstrap();
$catalog = array_slice(json_decode(file_get_contents($root.'/docs/intl/insights-list.json'), true, 512, JSON_THROW_ON_ERROR), 0, 26);
$all = [];
foreach (glob($root.'/database/content/intl/insights/*.json') as $path) {
    $data = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    $all[$data['ko_slug']] = ['path' => $path, 'data' => $data];
}
function domErrors(string $content): array {
    libxml_use_internal_errors(true);
    libxml_clear_errors();
    $dom = new DOMDocument;
    $dom->loadHTML('<?xml encoding="UTF-8">'.$content, LIBXML_NONET);
    $errors = [];
    foreach (libxml_get_errors() as $error) {
        $key = $error->level.':'.$error->code.':'.trim($error->message);
        $errors[$key] = ($errors[$key] ?? 0) + 1;
    }
    libxml_clear_errors();
    return $errors;
}
$results = [];
foreach ($catalog as $index => $item) {
    $insight = App\Models\Insight::where('slug', $item['slug'])->firstOrFail();
    $source = $insight->content;
    $originalErrors = domErrors($source);
    $file = $all[$item['slug']] ?? null;
    $row = ['index' => $index+1, 'ko_slug' => $item['slug'], 'source_hash_matches' => hash('sha256', $source) === $item['hash'], 'source_chars' => mb_strlen(strip_tags($source)), 'source_dom_errors' => $originalErrors, 'locales' => []];
    foreach (['en', 'ja'] as $locale) {
        $data = $file['data'][$locale] ?? null;
        if (! $data) {
            $row['locales'][$locale] = ['missing' => true];
            continue;
        }
        $newErrors = [];
        foreach (domErrors($data['content']) as $key => $count) {
            if ($count > ($originalErrors[$key] ?? 0)) $newErrors[$key] = $count - ($originalErrors[$key] ?? 0);
        }
        $translation = $insight->translations()->where('locale', $locale)->first();
        $fieldsMatch = $translation !== null;
        foreach (['slug', 'title', 'excerpt', 'content', 'meta_title', 'meta_description'] as $field) {
            $fieldsMatch = $fieldsMatch && $translation?->{$field} === $data[$field];
        }
        $entry = [
            'slug' => $data['slug'], 'title' => $data['title'],
            'chars' => mb_strlen(strip_tags($data['content'])),
            'meta_title_length' => mb_strlen($data['meta_title']),
            'meta_description_length' => mb_strlen($data['meta_description']),
            'new_dom_errors' => $newErrors,
            'db_rows' => $insight->translations()->where('locale', $locale)->count(),
            'db_content_matches' => $translation && $translation->content === $data['content'],
            'db_fields_match' => $fieldsMatch,
            'db_hash_matches' => $translation && $translation->source_hash === hash('sha256', $source),
        ];
        if (is_file($root.'/resources/views/intl/insights/show.blade.php')) {
            $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
            $request = Illuminate\Http\Request::create('http://localhost/'.$locale.'/insights/'.$data['slug']);
            $response = $kernel->handle($request);
            $entry['http_status'] = $response->getStatusCode();
            $kernel->terminate($request, $response);
        } else $entry['http_status'] = 'INTL-02 대기';
        $row['locales'][$locale] = $entry;
    }
    $results[] = $row;
}
echo json_encode(['published' => App\Models\Insight::published()->count(), 'total_translations' => App\Models\InsightTranslation::count(), 'results' => $results], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR).PHP_EOL;
```

</details>
