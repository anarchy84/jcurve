# jcurve — 작업 규칙

제이커브인터렉티브 홈페이지 (Laravel Blade). 프론트 기획·카피 문서는 `docs/frontend/`.

## ⛔ 절대 규칙
1. **자동 배포·발행·삭제 금지.** 대웅 검수 후 진행
2. 성과 수치(373억 등)는 임의 수정 금지 — 라벨·고지 문구 유지
3. 미디어 파일(`public/media/`)은 힉스필드 산출물 — 덮어쓰지 말 것

## 🤝 Claude ↔ Codex 분업 (2026-10-27~, 대웅 지시)
- **프론트엔드·디자인·콘텐츠 = Claude / 백엔드 = Codex.**
- 작업 전에 **`docs/COLLAB.md`(파일 구역·데이터 계약)**와 **`docs/collab/QUEUE.md`(요청 큐)**를 먼저 읽는다.
- 내 구역 밖 파일은 직접 고치지 않고 큐에 요청한다. 커밋·푸시는 대웅만 한다.

## 📊 대웅 대시보드 연동 (모든 AI 세션 공통)

대웅이 보는 업무 화면은 **`/Users/anarchy/Claude_Projects/AnarchyContentTeam/대시보드.html`** 하나다.
소스: `/Users/anarchy/Claude_Projects/AnarchyContentTeam/anc_main/06_사이트/data/tasks.json`

이 레포에서 작업하면:
- 시작/완료/신규/취소 시 위 tasks.json의 `tasks`·`agents`(웹개발=클로드코드)·`log`를 갱신
- 세션 끝에 실행: `python3 /Users/anarchy/Claude_Projects/AnarchyContentTeam/_tools/대시보드.py`
- 제이커브 작업은 track 없으면 `tasks`에 track `"jcurve"` 트랙을 추가해서 등록

## 💬 대웅과 일하는 방식
한국어 반말 · 핵심부터 · 다단계 작업은 계획→OK→진행 · 추측 금지 · 플레이스홀더 금지
