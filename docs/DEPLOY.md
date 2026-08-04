# 배포 가이드 — 형님(서버 담당) 전달용

> 2026-08-04 확정된 운영 환경 스펙에 맞춰 앱을 고정해뒀다.

## 운영 환경 (확정 스펙)

| 항목 | 값 | 앱 반영 |
|---|---|---|
| PHP | 8.3.32 (Remi) / 로컬 Laragon 8.3.30 | composer `platform.php=8.3.30` 고정 — 8.3 미지원 패키지 유입 차단 |
| Laravel | 13.8 | `laravel/framework: ~13.8.0` 핀 |
| 웹서버 | Apache 2.4.61 (소스빌드) + mod_proxy_fcgi → php83-fpm 전용 소켓 | public/.htaccess 사용 (트레일링 슬래시 301 룰 제거됨 — SEO상 의도된 것, 복구 금지) |
| DB | 운영 MariaDB 11.4.2 (utf8mb4) / 로컬 SQLite | `DB_CONNECTION=mariadb` (.env.example 하단 예시 참고) |
| 세션/큐/캐시 | 전부 database 드라이버 | .env 기본값으로 설정됨 (`sessions`,`jobs`,`cache` 테이블 마이그레이션 포함) |
| 타임존 | Asia/Seoul | `APP_TIMEZONE=Asia/Seoul` |

## 배포 절차

```bash
git clone <repo> && cd <repo>
cp .env.example .env        # 운영값 기입: APP_ENV=production, APP_DEBUG=false, APP_URL=https://j-curve.co.kr, DB_*
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --seed          # 최초 1회 (--seed는 게시판/카테고리/레거시 리다이렉트 시더)
npm ci && npm run build             # 또는 로컬 빌드 후 public/build 통째 업로드
php artisan config:cache && php artisan route:cache && php artisan view:cache
php artisan storage:link
```

- Apache DocumentRoot = `<repo>/public` (vhost에서 지정. mod_proxy_fcgi 환경이라 .htaccess의 mod_rewrite 활성 확인)
- 큐 워커: `php artisan queue:work --tries=3` (systemd 유닛 권장, database 드라이버라 별도 브로커 불필요)
- 스케줄러: crontab `* * * * * php /path/artisan schedule:run` (사이트맵 자동 갱신용 — SEO 인프라 단계에서 추가 예정)

## ⚠️ SEO 관련 서버 절대 준수사항 (docs/URL-MIGRATION.md 근거)

1. **기존 워드프레스의 `/wp-content/uploads/` 폴더를 새 서버 동일 경로에 통째로 복사** — 구글/네이버에 색인된 이미지 경로 유지용. Apache에서 해당 경로는 정적 서빙 (Laravel 통과 금지, vhost alias 권장).
2. 전환 직전 워드프레스 DB + 파일 풀백업 보관.
3. public/.htaccess의 트레일링 슬래시 리다이렉트 룰을 다시 넣지 말 것 (색인 URL `/seo/` 원형 보존 목적).
4. 전환 후 2주간 access log에서 404 모니터링 — 발견 시 `legacy_redirects` 테이블에 행 추가만 하면 됨 (배포 불필요).

## 검증 (배포 직후)

```bash
curl -I https://j-curve.co.kr/            # 200
curl -I https://j-curve.co.kr/seo/        # 200 (301 아님!)
curl -I https://j-curve.co.kr/log-in/     # 301 → /login
curl -I https://j-curve.co.kr/portfolio-items/cras-mollis-nons/   # 301 → /work
```
