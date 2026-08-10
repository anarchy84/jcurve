#!/usr/bin/env bash
# dev.j-curve.co.kr 수동 배포 — 개발 PC(맥)에서 실행.
#   1) 로컬에서 프론트 에셋 빌드
#   2) rsync 로 코드+에셋을 서버에 업로드 (.env/storage/vendor/node_modules 등 런타임은 보존)
#   3) 서버에서 composer 설치 + 마이그레이션 + 캐시 (전부 php83)
# 서버가 GitHub를 비대화식으로 당길 수 없어서(https 인증정보 없음) git pull 대신 rsync 방식 사용.
# 사전조건: `ssh-add ~/Downloads/jcdev` 로 키가 ssh-agent에 등록되어 있어야 함.
set -euo pipefail

RHOST=49.247.13.187
RPORT=9022
RUSER=jcdev
RPATH=/www/jcurve/j-curve-dev
SSH="ssh -p ${RPORT} -o BatchMode=yes -o StrictHostKeyChecking=accept-new"

cd "$(dirname "$0")/.."   # 레포 루트로 이동

echo "▶ 1/4 로컬 에셋 빌드 (npm run build)"
npm run build

echo "▶ 2/4 코드·에셋 업로드 (rsync)"
rsync -az -e "${SSH}" \
  --exclude='.git' \
  --exclude='.env' \
  --exclude='node_modules' \
  --exclude='vendor' \
  --exclude='storage' \
  --exclude='bootstrap/cache' \
  --exclude='public/storage' \
  --exclude='public/hot' \
  --exclude='.DS_Store' \
  ./ "${RUSER}@${RHOST}:${RPATH}/"

echo "▶ 3/4 dompdf 한글 폰트 업로드 (storage/fonts)"
rsync -az -e "${SSH}" storage/fonts/ "${RUSER}@${RHOST}:${RPATH}/storage/fonts/"

echo "▶ 4/4 서버 배포 (composer·migrate·cache, php83)"
${SSH} "${RUSER}@${RHOST}" bash -s <<'REMOTE'
set -euo pipefail
cd /www/jcurve/j-curve-dev
echo "  · composer install"
php83 /usr/local/bin/composer install --no-dev -o --no-interaction --prefer-dist
echo "  · migrate"
php83 artisan migrate --force
echo "  · cache 재생성"
php83 artisan config:cache
php83 artisan route:cache
php83 artisan view:cache
php83 artisan storage:link || true
echo "  · 권한"
chmod -R 775 storage bootstrap/cache
echo "  ✅ 서버 배포 완료"
REMOTE

echo ""
echo "✅ 최종 배포 완료 → https://dev.j-curve.co.kr"
