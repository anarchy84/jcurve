# SPEC-CODEX-INTL-04 — 기계번역 부분 다시 번역 (Codex 구현 세션, 04A~04E)

- 작성: Claude, 2026-11-03 15:50. 작업 폴더 `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/i18n`. 원래 저장소 접근 금지.
- 먼저 읽을 것: `docs/intl/INTL-PLAN.md` §1·§5, **`docs/intl/GLOSSARY.md`(§8 업계 용어 새로 추가 — 반드시 따른다)**, 말투 본보기 `lang/{en,ja}/pages/{home,company,contact}.php`(Claude)와 잘 된 예 `lang/{en,ja}/pages/{rankfree,marketing-support,self-marketing}.php`.

## 왜 다시 하나
INTL-02(서브페이지·FAQ·개인정보처리방침)와 INTL-03(블로그)은 공개 원문을 Google 번역 무료 엔드포인트(`translate.googleapis.com`)에 넣어 초벌을 만들었다. Claude 검수에서 이런 오역이 나왔다:
- 일본어 「반려(리드 거절)」→ 「ペット(애완동물)」, 「광고 지면」→ 「広告地面」「ディスプレイグラウンド」, 「운영 체계」→ 「オペレーティングシステム」, 「데이터를 보며」→ 「データを表示し」
- 영어 「운영 체계」→ "operating system", 「소재」→ "material", 같은 설명이 두 번 반복(NAVER GFA lead), 제목의 「경쟁 시장을 위한」 누락
외국 기업이 읽는 B2B 문서로 쓸 수 없는 수준이다.

## 절대 규칙
1. **외부 번역 서비스·API·웹 요청 금지**(Google 번역·DeepL·Papago 등 전부, `curl`·`file_get_contents('http…')` 포함). 네가 한국어 원문을 직접 읽고 직접 번역한다. 반환물에 「외부 요청 0」 근거(사용한 명령 목록)를 적는다.
2. 기존 번역을 단어 단위로 고치지 말고, **한국어 원문에서 문장 단위로 새로 번역**한다. 기존 번역 파일은 키·구조 참고로만 쓴다.
3. 키·배열 구조·HTML 구조·사람이 읽지 않는 값(아이콘·주소·클래스·숫자 필드·slug·`source_hash`)은 **바이트 그대로**. 바뀌는 건 사람이 읽는 문자열(과 `alt`·`title` 속성)뿐.
4. 숫자·연도·%·금액·건수는 값 그대로(GLOSSARY §6). 원화 환산 금지. 원문에 없는 실적·보장·최상급·출처를 만들지 않는다. 고지 문장(보장 안 함·추정치·「~기준」)은 빠짐없이.
5. 말투: 영어는 한국에 진출하려는 외국 기업 담당자가 읽는 명료한 B2B 문장(짧은 문장, 능동태, 업계 표준 용어). 일본어는 です・ます, 자연스러운 비즈니스 일본어(직역투 「~の場合。」 나열 금지). 한국 플랫폼 첫 등장 설명은 GLOSSARY §4 그대로 한 번만.
6. 자기 범위 밖 파일 수정 금지. 커밋·푸시·배포 금지. `.env` 열람·변경 금지. 실DB·Claude 임시 DB 사용 금지(필요하면 자기 전용 SQLite, `DB_DATABASE` 는 명령 하나에만).

## 세션별 범위
| 세션 | 파일 | 한국어 원문 |
|---|---|---|
| 04A | `lang/en/subpages.php` | `config/subpages.php` |
| 04B | `lang/ja/subpages.php` | `config/subpages.php` |
| 04C | `lang/{en,ja}/pages/faq.php`, `lang/{en,ja}/pages/privacy.php` | `resources/views/pages/faq.blade.php`, `resources/views/pages/privacy.blade.php` (와 그 뷰가 읽는 데이터) |
| 04D | `database/content/intl/insights/*.json` 중 `docs/intl/insights-list.json` 1~26번 글 | 한국어 표시본 `$insight->content`·제목 등(INTL-03A 결과 문서의 방법) |
| 04E | 같은 폴더의 27~52번 글 | 같음(INTL-03B 결과 문서의 방법) |

블로그(04D·04E) 추가 규칙: `slug`·`ko_slug`·`source_hash` 는 바꾸지 않는다(이미 링크·사이트맵에 쓰인다). `title`·`excerpt`·`meta_title`·`meta_description`·`content` 텍스트·`alt`/`title` 속성을 새로 번역한다. 내부 링크 처리(INTL-03 규칙)와 남긴 한국어 링크 목록은 기존 것을 유지·확인. Word 에서 온 잘게 쪼개진 `<span>` 구조는 그대로 두고, 문단 전체 뜻으로 번역한 뒤 원래 텍스트 칸에 자연스럽게 나눠 넣는다.

## 자동 점검 (스크립트로, 결과를 반환물에)
1. 한글 0(사람이 읽는 문자열·속성 전부).
2. 키 구조·사람이 읽지 않는 값: 작업 전 파일과 비교해 차이 0(블로그는 태그·속성 이름·순서·img src·a href 집합 동일).
3. 숫자 토큰: 한국어 원문 대비 차이 목록(억·만 자리 이동 외 차이는 0 이어야 한다).
4. **기계번역 흔적 검색 — 결과 0 이어야 한다**: 일본어 `ペット` `オペレーティングシステム` `地面` `グラウンド` `カウンセリング` `インフロー`, 영어 `operating system` `material`(소재 뜻) `top exposure` `inflow` `counseling` `remodeling`. 원문 뜻이 정말 그 단어면 예외로 목록에 이유를 적는다.
5. 길이 비율: 문자열(블로그는 문단)마다 en/ko·ja/ko 길이 비율 이상치(en < 0.8 또는 > 4.5, ja < 0.5 또는 > 2.5) 목록 → 하나씩 보고 「누락/추가/정상」 판정을 적는다.
6. `php artisan test` 그린(다른 세션 때문에 생긴 실패는 이름만 적고 고치지 않는다), 바꾼 PHP 파일 `./vendor/bin/pint --test`, 블로그는 `IntlInsightSeeder` 두 번 실행 멱등 + `php artisan intl:stale` 0.

## 반환물 `docs/intl/INTL-04{A|B|C|D|E}-IMPL-RESULT.md`
다시 번역한 문자열(또는 글) 수, 점검 1~6 실제 출력, **이전/이후 대조 20쌍**(한국어 · 이전 번역 · 새 번역 — Claude 검수용, 오역이 컸던 것 위주), 확신 없는 용어·표현 목록, 외부 요청 0 근거, 실행 명령·실제 출력, 미검증 항목.
