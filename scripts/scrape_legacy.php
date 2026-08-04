<?php

/**
 * 구버전 사이트(/v1/ 그누보드 + 루트 .php 랜딩) 콘텐츠 전량 백업 스크레이퍼
 *
 * 실행: php scripts/scrape_legacy.php
 * 산출물:
 *   database/content/legacy/columns/{wr_id}-{slug}.json  — 칼럼 전문 (title/slug/category/date/html)
 *   database/content/legacy/landings/{이름}.html          — 랜딩 원본 HTML
 *   database/content/legacy/manifest.json                 — 수집 결과 목록/실패 목록
 */
const BASE = 'https://j-curve.co.kr';
const OUT = __DIR__.'/../database/content/legacy';

// 서버에 부담 안 주게 요청 간격(초)
const DELAY_SEC = 1;

@mkdir(OUT.'/columns', 0755, true);
@mkdir(OUT.'/landings', 0755, true);

/** UA 명시해서 GET (그누보드가 UA 없으면 차단하는 경우 대비) */
function fetch(string $url): ?string
{
    $ctx = stream_context_create(['http' => [
        'method' => 'GET',
        'timeout' => 30,
        'header' => "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) JCurveMigration/1.0\r\nAccept-Language: ko\r\n",
    ]]);
    $html = @file_get_contents($url, false, $ctx);
    sleep(DELAY_SEC);

    return $html === false ? null : $html;
}

/** EUC-KR 사이트 대비 UTF-8 정규화 */
function toUtf8(string $html): string
{
    if (preg_match('/charset\s*=\s*["\']?euc-kr/i', $html)) {
        return iconv('EUC-KR', 'UTF-8//IGNORE', $html);
    }

    return $html;
}

$manifest = ['columns' => [], 'landings' => [], 'failed' => []];

// ── 1. 칼럼 수집 대상: wr_id 전수 열람 ─────────────────────────────
// 프리티 URL(/v1/manager/column/슬러그/)은 서버 리라이트가 깨져 404.
// 확실히 열리는 wr_id 방식으로 1~80 전수 시도, 없는 글은 본문 파싱 실패로 걸러짐.
$articleUrls = [];
for ($wrId = 1; $wrId <= 80; $wrId++) {
    $articleUrls["wr_id:{$wrId}"] = BASE."/v1/manager/bbs/board.php?bo_table=column&wr_id={$wrId}";
}
echo '칼럼 시도 대상: '.count($articleUrls)."건 (wr_id 1~80)\n";

// ── 2. 칼럼 본문 수집 ─────────────────────────────────────────────
$seq = 0;
foreach ($articleUrls as $key => $url) {
    $html = fetch($url);
    if ($html === null) {
        $manifest['failed'][] = $url;

        continue;
    }
    $html = toUtf8($html);

    $doc = new DOMDocument;
    @$doc->loadHTML('<?xml encoding="UTF-8">'.$html);
    $xp = new DOMXPath($doc);

    // 그누보드 표준 마크업: 제목 #bo_v_title, 본문 #bo_v_con, 날짜 .if_date|bo_v_info
    $titleNode = $xp->query('//*[@id="bo_v_title"]')->item(0) ?? $xp->query('//h1|//h2')->item(0);
    $bodyNode = $xp->query('//*[@id="bo_v_con"]')->item(0) ?? $xp->query('//article')->item(0);
    $dateNode = $xp->query('//*[contains(@class,"if_date")]')->item(0)
              ?? $xp->query('//*[@id="bo_v_info"]//*[contains(text(),"-")]')->item(0);

    if ($bodyNode === null) {
        $manifest['failed'][] = $url.' (본문 파싱 실패)';

        continue;
    }

    $title = trim(preg_replace('/\s+/', ' ', $titleNode?->textContent ?? ''));
    // 카테고리는 제목 앞 [분류] 또는 페이지 내 sca 링크에서 추출
    $cat = null;
    if (preg_match('/[?&]sca=([^&"]+)/', $html, $cm)) {
        $cat = rawurldecode($cm[1]);
    }

    $bodyHtml = '';
    foreach ($bodyNode->childNodes as $child) {
        $bodyHtml .= $doc->saveHTML($child);
    }

    // 슬러그: 짧은주소면 그 슬러그, wr_id면 제목 기반
    $slug = str_starts_with($key, 'wr_id:')
        ? mb_substr(preg_replace('/[^\p{L}\p{N}]+/u', '-', mb_strtolower($title)), 0, 80)
        : basename(rtrim(parse_url($key, PHP_URL_PATH) ?? $key, '/'));

    $seq++;
    $file = sprintf('%s/columns/%03d-%s.json', OUT, $seq, substr(md5($url), 0, 8));
    file_put_contents($file, json_encode([
        'source_url' => $url,
        'title' => $title,
        'slug' => rawurldecode($slug),
        'category' => $cat,
        'date_raw' => trim($dateNode?->textContent ?? ''),
        'html' => $bodyHtml,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    $manifest['columns'][] = ['file' => basename($file), 'title' => $title, 'url' => $url];
    echo "  [{$seq}] {$title}\n";
}

// ── 3. 랜딩 페이지 원본 백업 ──────────────────────────────────────
$landings = [
    'cpa', 'land', 'stock', 'insurance', 'coin', 'permission',
    'gfa', 'facebook', 'youtube',
    'instagram', 'followers_up', 'instagram_likes',
    'shopping_marketing', 'shopping_smartstore', 'marketing-support-project',
];
foreach ($landings as $name) {
    $html = fetch(BASE."/{$name}.php");
    if ($html === null) {
        $manifest['failed'][] = "/{$name}.php";

        continue;
    }
    file_put_contents(OUT."/landings/{$name}.html", toUtf8($html));
    $manifest['landings'][] = "{$name}.html";
    echo "  랜딩: {$name}.php\n";
}
// /v1/ 전용 페이지도 백업
foreach (['portfolio', 'ad_campaign', 'contact', 'company', 'policy'] as $name) {
    $html = fetch(BASE."/v1/{$name}.php");
    if ($html !== null) {
        file_put_contents(OUT."/landings/v1-{$name}.html", toUtf8($html));
        $manifest['landings'][] = "v1-{$name}.html";
        echo "  랜딩: /v1/{$name}.php\n";
    } else {
        $manifest['failed'][] = "/v1/{$name}.php";
    }
}

file_put_contents(OUT.'/manifest.json', json_encode($manifest, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
printf("\n완료: 칼럼 %d건 / 랜딩 %d건 / 실패 %d건 — manifest.json 참고\n",
    count($manifest['columns']), count($manifest['landings']), count($manifest['failed']));
