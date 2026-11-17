# VERIFY-CODEX-SEO-KW-04 — 오퍼월 연관 키워드·GEO 방법론 보강 독립 검증

- 작업 ID: SEO-KW-04-VERIFY (2026-11-17, Claude 작성)
- 위치: worktree `/Users/anarchy/Claude_Projects/jcurve/.claude/worktrees/geo-offerwall`, 기준 `7611421`, 대상 = 작업 트리 변경 전체(`git status`, `git diff`)
- **수정하지 마라. 판정과 근거만 낸다.** (테스트 무력화 실험 때 임시로 바꾼 것은 끝나면 원상복구하고, 복구했다는 증거(`git diff --stat` 전후)를 붙인다.)

## 공격 시나리오 — 각 항목 PASS/FAIL + 근거(파일:줄, 명령 출력)
1. **금지 문구** — 바뀐 화면·글(`offerwall.blade.php`, `seo/geo.blade.php`, `database/content/kw01/06~09-*.html`, llms 두 곳)에 다음이 있으면 FAIL:
   - 새 숫자·단가·수익률·정산 주기·기간 약속(예: "○주 만에", "○% 상승", 원 단위 금액). 지표 정의·"1~2주"·"3주 이후" 같은 측정 주기 설명은 허용 — 성과 약속인지 측정 방법인지 판정해 근거를 적어라.
   - 수익·노출·추천·순위 보장 긍정문("보장합니다"). 부정문("보장하지 않습니다")만 허용.
   - "SDK를 제공합니다"처럼 SDK 제공 단정.
   - 다른 회사·제품 이름(특히 genser, 플래티어/PLATEER, gelatto, 슈마커, 리바트, 애드팝콘, 버즈빌, 캐시슬라이드, 텐핑 등). `grep -rniE` 결과를 붙여라.
   - 외부 소개서 문장을 그대로 옮긴 흔적: 다음 원문 구절이 그대로 있으면 FAIL — "AI 답변의 출처가 되지 못하면, 고객이 비교하는 목록에도", "상세 이미지를 만드는 데 들인 노력이, AI가 읽는 정보로 그대로", "생성에서 끝나지 않고, 개선이 이어지는 구조". (일반 용어·지표 이름 일치는 허용)
2. **FAQ 일치** — 오퍼월·GEO 페이지 각각 화면 FAQ(`details/summary`) 질문 목록과 FAQPage JSON-LD `mainEntity[].name` 이 같은 순서·같은 개수인지 실제 렌더링 HTML 로 확인(`php artisan test` 외에 직접 요청해 HTML 파싱해도 됨).
3. **링크** — 새로 넣은 내부 링크(오퍼월 관련 글 2개, GEO subcard 2개, 글 본문 속 `/insights/…`·`/services/…` 링크 전부)의 slug 가 manifest 의 slug 와 정확히 일치하는지. 오타 하나라도 FAIL. 시더(`KeywordInsightSeeder`) 실행 뒤 각 주소가 200 인지 테스트 환경에서 확인.
4. **로컬 내비 앵커** — 두 페이지 로컬 내비의 `href="#…"` 마다 같은 id 섹션이 있는지, id 중복이 없는지.
5. **meta description** — 두 페이지와 새 글 4편(manifest `meta_description`) 모두 160자 이하(mb_strlen), 오퍼월 페이지는 `오퍼월`·`앱 수익화` 포함.
6. **승인본 일치** — `docs/content/articles/kw01/` 의 manifest·06~09 가 `database/content/kw01/` 와 바이트 동일.
7. **llms** — `resources/views/seo/llms.blade.php` 와 `public/llms.txt` 의 오퍼월·GEO 줄이 같은 뜻으로 갱신됐는지, `/llms.txt` 응답에 나오는지.
8. **배경 교대** — GEO 페이지 섹션 배경 클래스가 연속 두 번 같은 값(light-light, parchment-parchment, dark-dark)인 곳이 있으면 목록으로(판정은 WARN).
9. **테스트** — `php artisan test` 전체 실행, 실제 요약 출력 붙이기.
10. **테스트 무력화 실험(필수)** — 아래를 하나씩 임시로 되돌리고 해당 테스트가 **실제로 빨개지는지** 확인한 뒤 원상복구:
    a. 오퍼월 FAQPage JSON-LD 에서 질문 하나 빼기(또는 화면 FAQ 하나 빼기) → FAQ 일치 테스트 FAIL 해야 함
    b. manifest 에서 글 1편 지우기 → KeywordInsightTest FAIL 해야 함
    c. `docs/content/articles/kw01/08-geo-metrics.html` 한 글자 바꾸기 → 승인본 일치 테스트 FAIL 해야 함
    d. 오퍼월 meta description 을 161자 이상으로 → 길이 테스트 FAIL 해야 함
    e. GEO 페이지에서 `id="geo-metrics"` 지우기 → GEO 섹션 테스트 FAIL 해야 함
    초록으로 남는 실험이 있으면 그 테스트는 지키는 게 없다 → FAIL 로 보고.
11. **영수증·리워드 판정 로직** — 이번 변경은 콘텐츠·테스트만이어야 한다. `app/`, `routes/`, `config/`, `database/migrations`, `database/seeders` 변경이 있으면 FAIL.

## 금지
- 파일 수정(실험 후 복구 제외)·커밋·푸시·`git stash`·`git reset --hard`.

## 반환물
- 항목별 PASS/FAIL/WARN 표 + 근거
- 실험 a~e 각각: 바꾼 내용, 실패한 테스트 이름과 출력 한 줄, 복구 확인
- 최종 판정(합격/불합격)과 불합격이면 고칠 곳
