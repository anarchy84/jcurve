# SPEC-CODEX-SEO-KW-01-VERIFY — 독립 검증 (수정 금지 · 판정과 근거만)

- 작업 ID: SEO-KW-01-V · 작성: Claude 2026-11-04 · 대상: 작업 폴더의 SEO-KW-01A·B·C + Claude 화면 변경 전체(기준 `70ccde4` 대비)
- **아무 파일도 수정하지 마라.** 테스트를 고치거나 코드를 고치지 말고, 공격 시나리오별 판정(통과/실패/판정 불가)과 근거(명령·실제 출력)만 낸다. 무력화 실험으로 잠시 되돌린 파일은 반드시 원상복구하고, 복구 확인 출력을 붙인다.
- 참고: `docs/SPEC-CODEX-SEO-KW-01A.md`, `…01B.md`, `…01C.md`, 각 `tests/SEO-KW-01*-RESULT.md`

## 공격 시나리오
1. **열린 리다이렉트** — `/manager/data//evil.com/x.png`, `/manager/data/%2F%2Fevil.com`, `/manager/data/..%2F..%2Fadmin`, 경로에 `%0d%0a` 넣기, 쿼리에 `//evil.com`. Location 이 항상 `/v1/manager/data/` 로 시작하는 같은 호스트 경로인가. 헤더 주입이 되는가.
2. **JSON-LD 주입** — 제목·설명·카테고리명에 `</script><script>alert(1)</script>`, `"`, ` ` 를 넣은 인사이트를 만들어 렌더. 스크립트가 HTML 로 새거나 JSON 파싱이 깨지면 실패.
3. **원주소 보존** — 원주소 16개(`config/seo.php` `preserved_paths`)의 제목·설명·canonical 이 `70ccde4` 와 같은가. **예외는 `/naver-shopping-marketing/` 의 제목·설명 한 곳뿐**(의도된 변경). 다른 곳이 바뀌면 실패.
4. **canonical·robots 회귀** — 사이트맵에 있는 모든 주소가 200·자기 canonical·index 인가. `noindex` 가 붙으면 안 되는 페이지(원주소, 서비스, 글)에 붙었는가.
5. **빈 카테고리** — 글 0편 카테고리는 noindex·사이트맵 제외, 글이 생기면 index·사이트맵 포함. `/blog/seo/`·`/blog/link-building/` 은 0편이어도 index.
6. **새 글 시더** — `KeywordInsightSeeder` 두 번 실행 → 5편 그대로. manifest 와 제목·설명·본문 HTML 이 바이트 단위로 같은가(원고 변조 금지). 없는 카테고리 slug 로 실행하면 멈추는가.
7. **칼럼 설명 33편** — `insight-meta.json` 33개가 그대로 들어갔는가. 본문·제목 등 다른 필드가 바뀌었는가(바뀌면 실패).
8. **중복 글** — `…스킬3-1` 이 비공개·사이트맵·RSS 제외, 301 한 번에 `…스킬3`. 이 글을 가리키던 이전표 줄에 301→301 체인이 남았는가.
9. **사이트맵 구조** — 빈 묶음(works) 이 목록에 없는가, 묶음 lastmod 형식, 이미지 태그 절대 주소, 새 페이지 `/self-marketing/shopping` 포함.
10. **llms.txt / robots.txt** — text/plain, 엔티티 없음, 링크 전부 공개 주소. robots 에 `Disallow: /` 같은 차단 줄이 없는가.
11. **약속 문구** — 바뀐 화면·새 글·새 설명에 순위·매출 '보장'을 약속하는 문장이 있는가(「보장하지 않습니다」 같은 부정문은 정상). 구매·구매평·리뷰를 만들어 준다는 문장이 있는가.
12. **성과 수치** — `373억`·`128만`·`15,700` 수치와 라벨(「2026년 기준 · 회사 전체 누적 …」)이 바뀐 곳이 있는가. `public/media/**` 변경이 있는가(있으면 실패).

## 테스트 무력화 실험 (최소 5건)
아래를 하나씩 임시로 되돌려 관련 테스트가 실제로 빨개지는지 보고, 원상복구한다.
- `/manager/data` 라우트 제거
- `FeedCatalog` 의 빈 묶음 제외 로직 되돌리기
- `…스킬3-1` 비공개 처리 되돌리기
- head 의 `JSON_HEX_TAG` 제거
- guest 레이아웃 `noindex` 제거
초록으로 남는 실험이 있으면 그 테스트는 아무것도 지키지 않는 것이므로 **실패**로 판정한다.

## 합격 게이트(판정 기준)
`php artisan test` 전부 초록 · 시나리오 1~12 전부 통과 · 무력화 실험 전부 빨강 · 실험 후 `git diff` 가 실험 전과 동일.

## 반환물
`tests/SEO-KW-01-VERIFY-RESULT.md` 에 시나리오별 판정표(통과/실패/판정 불가 + 근거 명령·출력), 무력화 실험 표, 발견한 문제(심각도 순).
