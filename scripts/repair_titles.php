<?php
// 칼럼 JSON의 제목을 원 페이지 <title>/og:title에서 재추출해 보정하는 스크립트
// 실행: php scripts/repair_titles.php
$files = glob(__DIR__.'/../database/content/legacy/columns/*.json');
$ctx = stream_context_create(['http' => ['timeout' => 30,
    'header' => "User-Agent: Mozilla/5.0 JCurveMigration/1.0\r\n"]]);
$fixed = 0;
foreach ($files as $f) {
    $j = json_decode(file_get_contents($f), true);
    $html = @file_get_contents($j['source_url'], false, $ctx);
    sleep(1); // 서버 배려
    if ($html === false) { echo "실패: {$j['source_url']}\n"; continue; }
    $title = null;
    if (preg_match('#<meta[^>]+property=["\']og:title["\'][^>]+content=["\']([^"\']+)#i', $html, $m)) $title = $m[1];
    elseif (preg_match('#<title>([^<]+)</title>#i', $html, $m)) $title = $m[1];
    if ($title === null) { echo "제목 없음: {$j['source_url']}\n"; continue; }
    // "제목 > 마케팅칼럼 | 제이커브..." 꼬리표 제거
    $title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
    $title = trim(preg_split('/\s*[>|]\s*마케팅\s*칼럼|\s*\|\s*/u', $title)[0]);
    $j['title'] = $title;
    // 슬러그도 제목 기반으로 재생성 (한글 유지, 공백→하이픈)
    $j['slug'] = trim(preg_replace('/[^\p{L}\p{N}]+/u', '-', mb_strtolower($title)), '-');
    file_put_contents($f, json_encode($j, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
    $fixed++;
}
echo "보정 완료: {$fixed}/".count($files)."\n";
