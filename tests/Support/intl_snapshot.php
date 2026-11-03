<?php

use App\Services\Seo\Publishing\FeedCatalog;
use Database\Seeders\IntlInsightSeeder;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

// Usage: php tests/Support/intl_snapshot.php ROOT OUTPUT_JSON
// The caller supplies isolated SQLite and environment variables; never use a real database.
$root = realpath($argv[1]);
$loader = require $root.'/vendor/autoload.php';
foreach (['App\\' => 'app/', 'Database\\Seeders\\' => 'database/seeders/', 'Database\\Factories\\' => 'database/factories/'] as $prefix => $directory) {
    $loader->setPsr4($prefix, $root.'/'.$directory);
    foreach ($loader->getClassMap() as $class => $path) {
        if (str_starts_with($class, $prefix)) {
            $loader->addClassMap([$class => $root.'/'.$directory.str_replace('\\', '/', substr($class, strlen($prefix))).'.php']);
        }
    }
}
$app = require $root.'/bootstrap/app.php';
$app->useEnvironmentPath(dirname($argv[2]));
$console = $app->make(Kernel::class);
$console->bootstrap();
Carbon::setTestNow('2026-11-03 00:00:00');
$app['config']->set('honeypot.randomize_name_field_name', false);
$console->call('migrate:fresh', ['--force' => true]);
if (class_exists(IntlInsightSeeder::class)) {
    // Do not consume files being written by INTL-03 sessions.
    $app->bindMethod([IntlInsightSeeder::class, 'run'], fn () => null);
}
$console->call('db:seed', ['--force' => true]);
$catalog = $app->make(FeedCatalog::class)->sections();
$korean = [];
$paths = $app['config']->get('seo.preserved_paths');
$appendOnly = true;
foreach ($catalog as $section => $entries) {
    $korean[$section] = [];
    $foreignSeen = false;
    foreach ($entries as $entry) {
        // This runtime's parse_url replaces C1 bytes inside valid Korean UTF-8.
        // Strip the known HTTP origin without touching the original path bytes.
        $path = preg_replace('~^https?://[^/]+~', '', $entry['url']);
        if (! preg_match('~^/(en|ja)(/|$)~', $path)) {
            $appendOnly = $appendOnly && ! $foreignSeen;
            $korean[$section][] = $entry;
            $paths[] = $path;
        } else {
            $foreignSeen = true;
        }
    }
}
$paths = array_values(array_unique([...$paths, '/privacy', '/support/faq', '/solutions/shopitrend', '/self-marketing', '/self-marketing/place', '/login', '/register', '/community', '/self-marketing/order', '/seo-check', '/dashboard', '/company', '/contact', '/insights', '/services/seo']));
if (isset($argv[3])) {
    $baseline = json_decode(file_get_contents($argv[3]), true, 512, JSON_THROW_ON_ERROR);
    $paths = array_values(array_unique([...$paths, ...array_map('base64_decode', array_keys($baseline['pages']))]));
}
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$pages = [];
foreach ($paths as $path) {
    $encoded = preg_replace_callback('/[\x80-\xff]/', fn ($match) => rawurlencode($match[0]), $path);
    $request = Request::create('https://j-curve.co.kr'.$encoded);
    $response = $kernel->handle($request);
    $html = $response->getContent();
    // Only per-request randomness: CSRF meta/input and Honeypot's encrypted timer.
    $html = preg_replace('~(<meta name="csrf-token" content=")[^"]*(")~', '$1[CSRF]$2', $html);
    $html = preg_replace('~(<input\b[^>]*\bname="_token"[^>]*\bvalue=")[^"]*(")~', '$1[CSRF]$2', $html);
    $html = preg_replace('~(<input\b[^>]*\bname="valid_from"[^>]*\bvalue=")[^"]*(")~s', '$1[HONEYPOT]$2', $html);
    $html = preg_replace('/\b(sbg|sgl|sdot)-[a-zA-Z0-9]{5}\b/', '$1-[SVG-ID]', $html);
    $html = preg_replace('/\bmy_name_[a-zA-Z0-9]+\b/', 'my_name_[RANDOM]', $html);
    $html = preg_replace('~(/build/assets/[^"\s<>]+)-[a-zA-Z0-9_-]{8}([.]\w+)~', '$1-[VITE]$2', $html);
    $pages[base64_encode($path)] = ['status' => $response->getStatusCode(), 'location' => $response->headers->get('Location'), 'html_base64' => base64_encode($html)];
    $kernel->terminate($request, $response);
}
$xmlKorean = [];
$indexRequest = Request::create('https://j-curve.co.kr/sitemap.xml');
$indexResponse = $kernel->handle($indexRequest);
if ($indexResponse->getStatusCode() !== 200) {
    throw new RuntimeException('Sitemap index did not return 200');
}
$indexXml = simplexml_load_string($indexResponse->getContent());
$kernel->terminate($indexRequest, $indexResponse);
$xmlForeignSeen = [];
foreach ($indexXml->xpath('//*[local-name()="sitemap"]/*[local-name()="loc"]') as $location) {
    $childPath = preg_replace('~^https?://[^/]+~', '', (string) $location);
    preg_match('~^/sitemaps/([^/]+)/~', $childPath, $matches);
    $section = $matches[1];
    $xmlKorean[$section] ??= [];
    $childRequest = Request::create((string) $location);
    $childResponse = $kernel->handle($childRequest);
    if ($childResponse->getStatusCode() !== 200) {
        throw new RuntimeException('Sitemap child did not return 200: '.$childPath);
    }
    $childXml = simplexml_load_string($childResponse->getContent());
    foreach ($childXml->xpath('//*[local-name()="url"]') as $node) {
        $location = (string) $node->loc;
        if (preg_match('~^https?://[^/]+/(en|ja)(/|$)~', $location)) {
            $xmlForeignSeen[$section] = true;
        } else {
            $appendOnly = $appendOnly && ! ($xmlForeignSeen[$section] ?? false);
            $xmlKorean[$section][] = $node->asXML();
        }
    }
    $kernel->terminate($childRequest, $childResponse);
}
$snapshot = ['catalog' => $korean, 'sitemap_xml' => $xmlKorean, 'foreign_append_only' => $appendOnly, 'pages' => $pages];
file_put_contents($argv[2], json_encode($snapshot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
echo 'Snapshot: '.count($pages).' Korean pages; preserved paths: '.count($app['config']->get('seo.preserved_paths')).PHP_EOL;
echo 'Korean sitemap entries: '.array_sum(array_map('count', $korean)).PHP_EOL;
echo 'HTTP statuses: '.json_encode(array_count_values(array_column($pages, 'status'))).PHP_EOL;
