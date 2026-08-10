# 자동 배포 가이드 — dev.j-curve.kr (GitHub Actions)

> `main` 브랜치에 push하면 GitHub가 자동으로 dev 서버에 배포한다.
> 워크플로: `.github/workflows/deploy.yml`

## 동작 방식

```
개발자가 main 에 push
   └─ GitHub Actions 실행
        1) GitHub에서 프론트 에셋 빌드 (npm ci && npm run build)  ← 서버에 node 불필요
        2) 빌드된 public/build 를 서버로 업로드(scp)
        3) 서버에 SSH 접속 →
             git reset --hard origin/main   (코드 최신화)
             composer install --no-dev       (PHP 의존성)
             php artisan migrate --force      (DB 마이그레이션)
             php artisan optimize             (config/route/view 캐시)
             php artisan storage:link
   └─ 완료 (몇 분 소요)
```

## ⚙️ 최초 1회 설정 — GitHub 시크릿 등록 (형님이 GitHub 웹에서)

**저장소 → Settings → Secrets and variables → Actions → New repository secret** 에서 아래 4개 등록:

| 시크릿 이름 | 값 | 예시 |
|---|---|---|
| `DEV_SSH_HOST` | dev 서버 주소(IP 또는 도메인) | `49.247.x.x` 또는 `dev.j-curve.kr` |
| `DEV_SSH_USER` | SSH 접속 계정 | `jcurve` |
| `DEV_SSH_KEY` | SSH **개인키 전체**(-----BEGIN … END-----) | `~/.ssh/id_rsa` 내용 통째로 |
| `DEV_SSH_PORT` | SSH 포트(표준이면 `22`) | `22` |
| `DEV_DEPLOY_PATH` | 서버에 레포가 clone된 절대경로 | `/home/jcurve/dev.j-curve.kr` |

> `DEV_SSH_KEY` 는 형님이 이미 받은 그 개인키(private key) 파일 내용을 그대로 붙여넣으면 된다.
> 시크릿은 GitHub에 암호화 저장되고 화면에 다시 안 보인다. (Claude/코드가 대신 못 넣음 — 형님이 직접)

## 🖥️ 서버 쪽 전제 조건 (한 번만 확인)

자동 배포가 돌려면 dev 서버에 아래가 준비돼 있어야 한다(대부분 이미 되어 있을 것):

1. **레포가 한 번 clone 되어 있음** — `DEV_DEPLOY_PATH` 경로에.
   서버가 GitHub에서 pull할 수 있어야 함(서버에 deploy key 등록 or https 토큰). 기존에 수동으로 pull 되던 서버면 이미 됨.
2. **PHP 8.3 · Composer · MariaDB** 설치됨 (기존 `docs/DEPLOY.md` 스펙).
3. **`.env` 파일이 서버에 이미 세팅**되어 있음(운영값). — 자동배포는 `.env`를 건드리지 않는다.
4. Apache DocumentRoot = `<DEPLOY_PATH>/public`.

> node/npm은 **서버에 없어도 됨** (에셋은 GitHub에서 빌드해 업로드).

## ✅ 설정 후 사용법

- 코드 push → 자동 배포. **GitHub 저장소 → Actions 탭**에서 진행상황·로그 확인.
- 수동 배포하고 싶으면: Actions 탭 → "Deploy to dev.j-curve.kr" → **Run workflow** 버튼.
- 시크릿을 아직 안 넣었으면 배포는 자동으로 **건너뛰기**(빨간 실패 아님) 처리된다.

## 🌐 DNS (dev.j-curve.kr이 서버를 가리키게)

현재 `dev.j-curve.kr`은 DNS 해석이 안 되는 상태다. 도메인 관리 콘솔(도메인 산 곳)에서
`dev` 서브도메인 **A 레코드 → dev 서버 IP** 를 추가해야 브라우저로 접속된다.
(자동 배포 자체는 IP로 SSH하므로 DNS 없이도 배포는 되지만, 사이트를 열려면 DNS 필요.)

## 🔧 서버 세팅이 다르면 조정할 부분

- 브랜치가 `main`이 아니면 `.github/workflows/deploy.yml` 의 `branches: [main]` 수정.
- 무중단/릴리스 디렉토리 구조를 쓰면 SSH 스크립트 부분을 그 구조에 맞게 조정.
- 큐 워커가 있으면 배포 끝에 `php artisan queue:restart` 추가 권장.
