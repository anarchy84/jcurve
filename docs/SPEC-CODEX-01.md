# Codex 작업지시서 #01 — DB·라우트·컨트롤러·기본 뷰

> 발주: Claude / 범위 엄수. 이 문서에 없는 것은 만들지 않는다.
> 참조: docs/PLAN.md (§3 URL, §5 스키마, §6 앱 구조), docs/CONTENT.md

## 0. 금지사항 (위반 시 반려)

1. 인증(Auth)·비밀번호·세션·권한 로직을 **생성/수정 금지** (Claude 담당. Breeze 산출물 건드리지 말 것)
2. composer/npm 패키지 **추가 금지**
3. `.env`, `config/*.php` 수정 금지 (필요하면 주석으로 요청만)
4. 도메인·URL 하드코딩 금지 — `route()`, `url()`, `config('app.url')`만 사용
5. 인라인 스타일·CSS 프레임워크 클래스 남발 금지 — 뷰는 시맨틱 HTML 구조만 (디자인은 별도 단계)
6. DB 쿼리를 뷰에서 실행 금지, N+1 금지 (`with()` 필수)

## 1. 마이그레이션 (PLAN.md §5 스키마 그대로)

파일 순서: boards → posts → comments → post_likes → attachments → insight_categories → insights → works → leads → seo_meta, users 테이블은 기존 마이그레이션에 컬럼 추가 마이그레이션(nickname unique nullable, avatar, provider, provider_id, role enum default 'member', last_login_at, softDeletes).

- 모든 FK는 `foreignId()->constrained()->cascadeOnDelete()` (posts.user_id는 `nullOnDelete` — 탈퇴해도 글 유지)
- posts: index(board_id, published_at), FULLTEXT(title, content) — MySQL 전용 문법은 `DB::statement`로
- post_likes: unique(post_id, user_id)
- insights.slug, works.slug, boards.slug, seo_meta.path: unique
- metrics(json), utm(json)은 `json` 컬럼

## 2. 모델 (app/Models/)

Board, Post, Comment, PostLike, Attachment, Insight, InsightCategory, Work, Lead, SeoMeta + User 수정(관계만 추가).

- 관계 전부 정의 (Post belongsTo Board/User, hasMany Comments, Comment 자기참조 parent/children 등)
- casts: published_at→datetime, metrics/utm→array, is_notice/is_secret→boolean
- Post·Insight·Work에 `scopePublished()` (published_at not null & <= now)
- Post: `getRouteKeyName()` 대신 라우트에서 `{post}` id 바인딩 + slug는 URL 표시용 (`/community/{board:slug}/{post}-{slug}` 형태는 컨트롤러에서 id로 조회 후 slug 불일치 시 301 리다이렉트)
- SoftDeletes: users, posts, comments

## 3. 시더

- BoardSeeder: notice(공지, admin만 작성), free(자유게시판), qna(질문답변), tips(정보공유) — write_permission은 member 기본
- InsightCategorySeeder: seo, performance-marketing, cpa, reward, wordpress (slug/name)
- DatabaseSeeder에서 호출

## 4. 라우트 (routes/web.php) — 전부 named

```
GET  /                          home                PageController@home
GET  /services                  services.index      PageController@services
GET  /services/{slug}           services.show       PageController@service   # 5개 화이트리스트, 없으면 404
GET  /services/seo/aeo          services.seo.aeo    PageController@seoAeo
GET  /services/seo/geo          services.seo.geo    PageController@seoGeo
GET  /solutions/rankfree        solutions.rankfree  PageController@rankfree
GET  /solutions/boostingshop    solutions.boostingshop PageController@boostingshop
GET  /company                   company             PageController@company
GET  /company/anarchy           company.anarchy     PageController@anarchy
GET  /work                      work.index          WorkController@index
GET  /work/{work:slug}          work.show           WorkController@show
GET  /insights                  insights.index      InsightController@index
GET  /insights/category/{slug}  insights.category   InsightController@category
GET  /insights/{insight:slug}   insights.show       InsightController@show
GET  /community                 community.index     BoardController@index
GET  /community/{board:slug}    community.board     BoardController@show     # 페이지네이션 20개
GET  /community/{board:slug}/{postSlug} community.post PostController@show   # {id}-{slug} 파싱
auth 미들웨어 그룹:
  GET/POST /community/{board:slug}/create|store   community.post.create/store
  GET/PUT  .../edit|update, DELETE destroy        (작성자 본인 or admin — Policy로)
  POST /community/posts/{post}/comments           comments.store (parent_id optional)
  DELETE /comments/{comment}                      comments.destroy
  POST /community/posts/{post}/like               posts.like (토글, JSON 응답)
GET  /contact                   contact             ContactController@show
POST /contact                   contact.store       ContactController@store  # honeypot 미들웨어, rate limit 5/min
```

## 5. 컨트롤러 로직

- PageController: 각 페이지 뷰 반환. 서비스 페이지는 `config/services_pages.php` 같은 배열 상수 대신 **컨트롤러 내 화이트리스트 배열**로 slug→view 매핑 (performance-marketing, cpa-marketing, reward-network, seo, wordpress)
- PostController@show: 조회수 증가는 세션당 1회 (`session()->has("viewed.{$post->id}")` 체크), 댓글 `with('user','children.user')` 로드
- PostPolicy, CommentPolicy: update/delete = 본인 or role admin
- BoardController@show: 공지(is_notice) 상단 고정 + 일반글 최신순, `withCount` 사용 금지하고 비정규화 컬럼(comment_count, like_count) 사용
- 댓글/좋아요 생성·삭제 시 Post의 comment_count/like_count 동기화 (모델 이벤트 or 명시적 increment/decrement)
- ContactController@store: validate(name required, email required|email, phone nullable, service_interest in:화이트리스트, message required|max:2000) 후 leads 저장, UTM 파라미터는 세션/쿼리에서 utm(json)으로

## 6. 뷰 (구조만 — 시맨틱 HTML, 클래스는 BEM 형태 최소)

- layouts/app.blade.php: `<html lang="ko">`, @yield('meta') 슬롯(비워둠 — Claude가 SEO 컴포넌트 주입), header nav(PLAN §3 메뉴 전부 route() 링크), footer(CONTENT.md 회사정보 그대로), @stack('scripts')
- 각 라우트별 blade 파일 생성: h1 1개(페이지당 정확히 1개), 시맨틱 태그(main/section/article/nav/aside), 목록은 실제 데이터 루프
- 커뮤니티: 목록 테이블(제목/작성자 닉네임/날짜/조회/좋아요), 글쓰기 폼(title, content textarea), 댓글 리스트+폼, 대댓글 1depth
- 페이지네이션 `{{ $posts->links() }}`
- 폼 전부 @csrf, old() 값 유지, @error 표시

## 7. 완료 기준 (Claude가 검증)

- `php artisan migrate:fresh --seed` 에러 없이 완료
- `php artisan route:list` 가 위 표와 일치
- `./vendor/bin/pint --test` 통과
- `php artisan test` 기존 테스트 그린
- 전 페이지 200 응답 (feature test 없이도 수동 확인 가능한 상태)
