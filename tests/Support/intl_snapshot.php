<?php

use App\Services\Seo\Publishing\FeedCatalog;
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
$console = $app->make(Kernel::class);
$console->bootstrap();
Carbon::setTestNow('2026-11-03 00:00:00');
$app['config']->set('honeypot.randomize_name_field_name', false);
$console->call('migrate:fresh', ['--force' => true]);
$console->call('db:seed', ['--force' => true]);
$catalog = $app->make(FeedCatalog::class)->sections();
$korean = [];
$paths = $app['config']->get('seo.preserved_paths');
foreach ($catalog as $section => $entries) {
    $korean[$section] = [];
    foreach ($entries as $entry) {
        // This runtime's parse_url replaces C1 bytes inside valid Korean UTF-8.
        // Strip the known HTTP origin without touching the original path bytes.
        $path = preg_replace('~^https?://[^/]+~', '', $entry['url']);
        if (! preg_match('~^/(en|ja)(/|$)~', $path)) {
            $korean[$section][] = $entry;
            $paths[] = $path;
        }
    }
}
$paths = array_values(array_unique([...$paths, '/privacy', '/support/faq', '/solutions/shopitrend', '/self-marketing', '/self-marketing/place']));
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
    $pages[base64_encode($path)] = ['status' => $response->getStatusCode(), 'html_base64' => base64_encode($html)];
    $kernel->terminate($request, $response);
}
$snapshot = ['catalog' => $korean, 'pages' => $pages];
file_put_contents($argv[2], json_encode($snapshot, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
echo 'Snapshot: '.count($pages).' Korean pages; preserved paths: '.count($app['config']->get('seo.preserved_paths')).PHP_EOL;
echo 'Korean sitemap entries: '.array_sum(array_map('count', $korean)).PHP_EOL;
echo 'HTTP statuses: '.json_encode(array_count_values(array_column($pages, 'status'))).PHP_EOL;
