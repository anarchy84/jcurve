<?php
// 목록 페이지의 링크 텍스트(진짜 제목)를 수집해 정규화 매칭으로 칼럼 제목 최종 보정
$ctx = stream_context_create(['http' => ['timeout' => 30, 'header' => "User-Agent: Mozilla/5.0 JCurveMigration/1.0\r\n"]]);
$norm = fn(string $s) => preg_replace('/[^\p{L}\p{N}]+/u', '', mb_strtolower($s)); // 문자·숫자만 남겨 비교
$realTitles = [];
for ($p = 1; $p <= 4; $p++) {
    $html = file_get_contents("https://j-curve.co.kr/v1/manager/bbs/board.php?bo_table=column&page={$p}", false, $ctx);
    sleep(1);
    $doc = new DOMDocument(); @$doc->loadHTML('<?xml encoding="UTF-8">'.$html);
    foreach ((new DOMXPath($doc))->query('//a[contains(@href,"column")]') as $a) {
        $t = trim(preg_replace('/\s+/', ' ', $a->textContent));
        if (mb_strlen($t) >= 8 && !str_contains($t, '마케팅칼럼')) $realTitles[$norm($t)] = $t;
    }
}
echo "목록 제목 수집: ".count($realTitles)."건\n";
$fixed = 0; $miss = 0;
foreach (glob(__DIR__.'/../database/content/legacy/columns/*.json') as $f) {
    $j = json_decode(file_get_contents($f), true);
    $key = $norm($j['title']);
    if (isset($realTitles[$key])) {
        $j['title'] = $realTitles[$key]; $fixed++;
        file_put_contents($f, json_encode($j, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
    } else { $miss++; echo "매칭 실패: ".$j['title']."\n"; }
}
echo "보정: {$fixed} / 실패: {$miss}\n";
