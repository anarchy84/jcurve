# INTL-03 블로그 52편 영어·일본어 — 검증·수정 결과 (2026-11-04)

- 제코 지시(11/4): 「코덱스 시키지 말고 너가 다 마무리해」 → **Codex 없이 Claude 가 끝냄.** 원래 지시서 `VERIFY-CODEX-INTL-03.md`(T1~T17)를 기준으로, 기계 점검은 Claude 메인 세션이 직접 짠 스크립트로, 52편 전문 뜻 대조·수정은 Claude 서브에이전트 6개(G1~G6, 글 번호로 나눔)가, 수정 결과 검증은 **별도 Claude 검증 세션 2개**(수정 안 함, 판정만)가 맡았다. 최종 판정은 Claude 메인.
- 대상 파일: `database/content/intl/insights/*.json` 52개만 변경(텍스트만). 다른 파일 변경 0.
- 도구·로그·전후 대조 자료(git 제외): `storage/app/intl-handoff/verify03-claude-2026-11-04/`

## 1. 기계 점검 (T1~T16) — 최종 상태

| # | 항목 | 결과 | 근거 |
|---|---|---|---|
| T1 | 빠진 글·자리표시 | PASS | 52/52 1:1, 자리표시 0 |
| T2 | 원문 해시 | PASS | 52편 `source_hash` = 표시본 `$insight->content` SHA256. 35·36번은 `Insight::displayText()` 가 인사 문장을 빼는 표시본 기준이라 일치. `intl:stale` 0 |
| T3 | 한글 0 | PASS | title·excerpt·meta·본문·alt/title 속성 0 |
| T4 | 구조 보존 | PASS | img·a·table·tr·td·ul·ol·li·h2~4·p·iframe·br·div 개수, img src 집합, 줄(블록) 수 한국어와 동일. 추가로 **수정 전(git HEAD) 대비 태그·속성 순서가 52편 en·ja 전부 글자 단위 동일**(`structdiff.py`) — 바뀐 건 텍스트 노드뿐 |
| T5 | 지어낸·빠진 내용 | PASS(수정 후) | 표본 대신 **전문 대조**로 대체 — 아래 2절 |
| T6 | 숫자 | PASS | 남은 25건은 전부 억·만→million·billion·万·億 환산, 「10대」→teenage, 「1도」(속어)→at all/まったく, 목록 번호 등 표기 차이. 값 변경·통화 환산 0 |
| T7 | 링크 | PASS | 외부 href 집합 동일. 내부 링크는 옛 이미지 보기 주소(`/v1/manager/bbs/view_image.php`)뿐이고 한국어와 같음 |
| T8 | slug·메타 | PASS | slug 형식·유일성 OK, `mobile-marketing-strategies` 유지. 메타 제목 권장 길이(영 60·일 32) 초과 0 — 수정 중 늘어난 9개는 원래 값으로 되돌림 |
| T9 | 용어집 | PASS | 「Jcurve」 7건 → 「J-Curve」(용어집 §1 회사 지칭). 제품명 오기 0 |
| T10 | 말투 | PASS | 영어 best·greatest 등은 전부 한국어 「가장·제일」에 근거(검증 세션 확인). 일본어 です・ます 위반 0(검증 세션 전수 스캔) |
| T11 | 시더·화면 | PASS | `IntlInsightSeeder` 두 번 실행 후 en 52·ja 52(멱등). `/en·/ja/insights/*` 104화면 전부 200·Location 없음·canonical 자기 주소·한글 0·hreflang ko 한국어 글 200(그중 3편은 원주소 유지 정책대로 `/seo/…/`) |
| T12 | 범위 밖 변경 | PASS | 이번 작업 변경은 insights JSON 52개 + 이 문서·검수 기록뿐 |
| T13 | 점검 무력화 실험 | PASS | 사본에 한글 1단어·`<img>` 1개 삭제·숫자 1개 변경 → T3·T4·T6 각각 실제로 잡음(원본 무변경) |
| T14 | 외부 번역 | PASS | 03B 로그 네트워크 호출은 로컬 `127.0.0.1:8033` 확인용뿐, 04D 로그는 네트워크 호출 0. 번역 엔드포인트 호출 0 |
| T15 | 금지어(§8) | PASS | ペット·オペレーティングシステム·地面·グラウンド·カウンセリング·インフロー·operating system·top exposure·inflow·counseling·remodeling 0 |
| T16 | 뜻 뒤집힘 | PASS(수정 후) | 부정·면책 의심 줄 전수를 전문 대조에서 확인, 뒤집힘·약화는 고침 |

## 2. 전문 뜻 대조·수정 (T17 대체 — 표본 312쌍 대신 52편 모든 줄)

| 그룹 | 글 | 오역 | 어색 | 비고 |
|---|---|---|---|---|
| G1 | 1~7 | 6 | 56 | 「施策」 남용 정리 |
| G2 | 8~16 | 30 | 98 | 일본어 문장 통째 누락 다수 |
| G3 | 17~25 | 22 | 203 | 23번 일본어 거의 다시 옮김 |
| G4 | 26~33 | 33 | 175 | 26번 일본어 과압축 → 다시 옮김 |
| G5 | 34~42 | 13 | 152 | 40번 인과 방향 뒤집힘 |
| G6 | 43~52 | 19 | 309 | 49번 「非常に強い施策」 해결, J-Curve 표기 22 별도 |
| 합계 | 52편 | **123** | **1,093** | 건수는 그룹 로그 기준(한 줄에 여러 건 가능) |

- 바뀐 줄 1,148(영어 96·일본어 1,052 — 52편 중 영어 본문 34편·일본어 본문 52편).
- 오역 유형: 일본어 문장·주장 누락이 가장 많음, 그다음 부정·단정 약화(「절대」「아무도」→may), 인과·비교 방향 뒤집힘(40번 b76), 업종명 오역(38번 유사투자자문·비상장주식), 원문에 없는 내용 추가(45번 patience, 46번 streetwear, 14번 「described here」).
- Claude 메인 직접 수정: 2번 EN 「users in their 10s」→teenage users, 41번 EN·JA 「1도」 직역, 52번 b185(EN·JA) 원문 구조로 되돌림, 19번 JA b47·b20, 메타 제목 9개 원복.

## 3. 독립 검증 (수정 안 한 별도 Claude 세션)

| 세션 | 범위 | 결과 |
|---|---|---|
| VERIFY-INTL-03-FIX | 무작위 90줄(seed 20261104) + 「오역」 수정 97건 전수 + 지정 확인 | 표본 OK 86·어색 3·FAIL 1, 오역 수정 95/97 정확. FAIL = 52번 b185(EN·JA) → Claude 메인이 원문 구조대로 고침 |
| VERIFY-INTL-03-FIX-G3 | 17~25번 무작위 40줄(seed 20261105) + 「오역」 22건 + 지정 확인 + 영어 붙은 단어 전수 | FAIL 0. 표본 OK 38·어색 2, 오역 22/22 정확, 붙은 단어 0 |

- 어색으로 남긴 것: 38번 EN 「cannot help but be good at CPA」(원문 「잘할 수밖에 없다」 그대로), 51번 JA 「コンテンツスピニング」 괄호 풀이(용어 설명, 주장 추가 아님), 25번 JA 「始める前に一つ。」(원문도 같은 조각 문장).

## 4. 원문(한국어) 쪽 문제 — 번역은 원문대로 두었고, 한국어 본문은 SEO 보존 원칙상 안 고침

- 52번 b260: 「좋은 링크가 항상 더 많으면 결과를 못 얻는다」 — 논리가 뒤집힌 문장
- 51번 b51: 「바운스율을 떨어뜨리고」 — 문맥상 「악화」 뜻이라 EN hurts·JA 悪化させ 로 뜻을 살림
- 48번 b22: 공식의 X 는 ÷ 가 맞아 보임
- 49번 b4: 「요령 6가지」인데 실제 목록은 8개
- 9번 b28, 23번 b58, 24번 b41: 원문 문장끼리 안 맞거나 모호함
- 14번 b7: 「무료 최적화 도구는 Google Optimize 뿐」(2019년 글, Optimize 는 현재 종료)
- 51·52번: 「제이커브 SEO·키워드·백링크 조사 도구」 언급 — 실제 제공 여부 확인 필요

## 5. 다시 돌리는 법
```
S=storage/app/intl-handoff/verify03-claude-2026-11-04
touch /tmp/x.sqlite && DB_CONNECTION=sqlite DB_DATABASE=/tmp/x.sqlite php artisan migrate:fresh --seed --force
python3 -I $S/check03.py "$PWD" /tmp/x.sqlite <출력폴더>      # T1~T16 기계 점검 + 정렬 대조본(review/NN.md)
python3 -I $S/structdiff.py "$PWD" <출력.json>               # HEAD 대비 태그·속성 동일 확인
python3 -I $S/crawl_blog.py "$PWD"                            # 서버 8023 필요
```
