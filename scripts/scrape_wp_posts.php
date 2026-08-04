<?php
// 워드프레스 색인 아티클 3편 원문 백업 (제목/본문/날짜/OG이미지)
$urls = [
    'https://j-curve.co.kr/seo/%ea%b2%bd%ec%9f%81%ec%9e%90%eb%a5%bc-%ec%95%95%eb%8f%84%ed%95%98%eb%8a%94-6%ea%b0%80%ec%a7%80-%ea%b3%a0%ea%b8%89-%eb%a7%81%ed%81%ac-%ea%b5%ac%ec%b6%95-%ec%a0%84%eb%9e%b5/',
    'https://j-curve.co.kr/seo/chrome-%eb%b0%8f-firefox%ec%97%90%ec%84%9c-nofollow-%eb%a7%81%ed%81%ac%eb%a5%bc-%ed%99%95%ec%9d%b8%ed%95%98%eb%8a%94-%eb%b0%a9%eb%b2%95/',
    'https://j-curve.co.kr/seo/11%ea%b0%80%ec%a7%80-%ec%b5%9c%ea%b3%a0%ec%9d%98-seo-%ec%8b%a4%ec%88%98%ec%99%80-%ec%9d%b4%eb%a5%bc-%ed%94%bc%ed%95%98%eb%8a%94-%eb%b0%a9%eb%b2%95/',
];
@mkdir(__DIR__.'/../database/content/legacy/wp-posts', 0755, true);
$ctx = stream_context_create(['http' => ['timeout' => 30, 'header' => "User-Agent: Mozilla/5.0 JCurveMigration/1.0\r\n"]]);
foreach ($urls as $i => $url) {
    $html = file_get_contents($url, false, $ctx); sleep(1);
    $doc = new DOMDocument(); @$doc->loadHTML('<?xml encoding="UTF-8">'.$html);
    $xp = new DOMXPath($doc);
    $get = fn($q) => trim($xp->evaluate("string({$q})"));
    $bodyNode = $xp->query('//*[contains(@class,"entry-content")]|//*[contains(@class,"post-content")]|//article')->item(0);
    $body = ''; if ($bodyNode) foreach ($bodyNode->childNodes as $c) $body .= $doc->saveHTML($c);
    $slug = rawurldecode(basename(rtrim(parse_url($url, PHP_URL_PATH), '/')));
    file_put_contents(sprintf('%s/../database/content/legacy/wp-posts/%d-%s.json', __DIR__, $i+1, substr(md5($url),0,8)),
        json_encode([
            'source_url' => rawurldecode($url),
            'title' => $get('//meta[@property="og:title"]/@content') ?: $get('//title'),
            'slug' => $slug,
            'published' => $get('//meta[@property="article:published_time"]/@content'),
            'og_image' => $get('//meta[@property="og:image"]/@content'),
            'html' => $body,
        ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
    echo "저장: {$slug} (본문 ".mb_strlen(strip_tags($body))."자)\n";
}
