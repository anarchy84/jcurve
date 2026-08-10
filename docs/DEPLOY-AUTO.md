# 자동 배포 가이드 — dev.j-curve.co.kr (GitHub Actions)

> `main` 에 push하면 GitHub가 자동으로 dev 서버에 배포한다.
> 워크플로: `.github/workflows/deploy.yml`

## 서버 정보 (dev 전용 격리 계정)

| 항목 | 값 |
|---|---|
| 호스트 | `49.247.13.187` |
| 포트 | `9022` |
| 계정 | `jcdev` (sudo 없음, 타 프로젝트 접근 불가, 전용 php-fpm 풀 `jcdev.sock`) |
| 작업경로 | `/www/jcurve/j-curve-dev` (DocumentRoot = `public/`) |
| 사이트 | https://dev.j-curve.co.kr |
| PHP | **`php83`** (`php`는 7.x라 안 됨 — 모든 명령 `php83`로) |
| node | 서버엔 불필요(에셋은 GitHub에서 빌드해 업로드) |

호스트·포트·계정·경로는 워크플로 `env:` 에 박아뒀다(비밀 아님). **비밀은 SSH 개인키 하나뿐.**

## ⚙️ 최초 1회 — GitHub 시크릿 1개만 등록

**저장소 → Settings → Secrets and variables → Actions → New repository secret**

| 이름 | 값 |
|---|---|
| `DEV_SSH_KEY` | jcdev SSH **개인키 전체**(암호zip으로 받은 `%USERPROFILE%\.ssh\jcdev` 내용, `-----BEGIN … END-----` 포함) |

> 개인키에 passphrase가 걸려 있으면 GitHub Actions에서 못 푼다. passphrase 없는 키를 쓰거나, passphrase 없는 배포 전용 키를 별도로 만들어 등록한다.

## 🔑 서버 → GitHub 접근 (private 레포라 필수, 최초 1회)

레포가 **private** 이라 dev 서버가 코드를 받으려면 서버에 GitHub 읽기 권한이 있어야 한다. 서버(jcdev)에서:

```bash
# 1) 서버에 배포용 SSH 키 생성 (passphrase 없이 Enter)
ssh-keygen -t ed25519 -C "jcdev-deploy" -f ~/.ssh/gh_deploy -N ""
cat ~/.ssh/gh_deploy.pub     # 이 공개키를 복사
```
→ GitHub 저장소 **Settings → Deploy keys → Add deploy key** 에 붙여넣기(읽기 전용이면 충분).
→ 서버 `~/.ssh/config` 에:
```
Host github.com
  IdentityFile ~/.ssh/gh_deploy
  IdentitiesOnly yes
```
그러면 서버에서 `git@github.com:anarchy84/jcurve.git` 로 clone/pull 가능.

## 🚀 최초 1회 — 첫 배포(수동, 개발자가 서버에서)

자동 배포는 "레포가 이미 clone돼 있고 `.env`가 세팅된 상태"를 전제한다. 그 상태를 만드는 첫 배포는 수동으로 한 번:

```bash
ssh -p 9022 jcdev@49.247.13.187

rm -rf /www/jcurve/j-curve-dev/public          # 빈 public만 있어 clone이 막히므로 제거
git clone git@github.com:anarchy84/jcurve.git /www/jcurve/j-curve-dev
cd /www/jcurve/j-curve-dev

php83 "$(command -v composer)" install --no-dev -o          # composer를 php83로 실행
cp .env.example .env
php83 artisan key:generate
#  ↑ 이후 .env 편집: APP_ENV=production, APP_DEBUG=false,
#     APP_URL=https://dev.j-curve.co.kr, DB_* (rankfree와 별도 스키마)
php83 artisan migrate --force

export NVM_DIR="$HOME/.nvm" && . "$NVM_DIR/nvm.sh"          # node 로드
npm ci && npm run build

chmod -R 775 storage bootstrap/cache
php83 artisan config:cache && php83 artisan route:cache && php83 artisan view:cache
php83 artisan storage:link
```

여기까지 하면 https://dev.j-curve.co.kr 에 뜬다. **이후부터는 push만 하면 자동.**

## ✅ 자동 배포 동작 (첫 배포 이후)

`main` push → GitHub Actions:
1. GitHub에서 에셋 빌드(`npm ci && npm run build`)
2. `public/build` 를 서버로 scp 업로드
3. 서버 SSH → `git reset --hard origin/main` → `php83 composer install` → `php83 artisan migrate --force` → `php83 artisan config:cache/route:cache/view:cache` → `storage:link` → `chmod`

- 진행상황·로그: **저장소 → Actions 탭**
- 수동 실행: Actions → "Deploy to dev.j-curve.co.kr" → **Run workflow**
- `DEV_SSH_KEY` 미등록 시 배포는 **자동 스킵**(빨간 실패 아님)

## 참고
- `.env` 는 배포가 절대 건드리지 않는다(서버에만 존재).
- 큐 워커를 쓰게 되면 워크플로 SSH 스크립트 끝에 `php83 artisan queue:restart` 추가.
- Apache 리로드 불필요(php-fpm 반영). sudo 불필요.
