<?php

namespace App\Services\Seo\Publishing;

use DOMDocument;
use DOMXPath;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class UrlAuditor
{
    public function __construct(private PublicUrl $urls) {}

    public function audit(array $entries, string $base): array
    {
        $base = PublicUrl::origin($base);
        $rows = [];
        foreach ($entries as $entry) {
            $row = ['path' => $entry['path'], 'expected_status' => $entry['status'], 'observed_status' => null, 'issues' => []];
            try {
                $response = $this->get($base.$entry['path']);
                $row['observed_status'] = $response->status();
                if ($response->status() !== $entry['status']) {
                    $row['issues'][] = 'status_mismatch';
                } elseif ($entry['status'] === 301) {
                    $location = $response->header('Location');
                    $actual = str_starts_with($location, '/') && ! str_starts_with($location, '//') ? $base.$location : $location;
                    $expected = $base.$entry['to'];
                    if (! PublicUrl::equivalent($actual, $expected)) {
                        $row['issues'][] = 'redirect_target_mismatch';
                    } else {
                        $response = $this->get(explode('#', $expected, 2)[0]);
                        $row['final_status'] = $response->status();
                        if ($response->status() !== 200) {
                            $row['issues'][] = $response->redirect() ? 'redirect_chain_or_loop' : 'destination_not_200';
                        }
                    }
                }
                if ($row['issues'] === [] && $response->status() === 200) {
                    $path = $entry['status'] === 301 ? explode('#', $entry['to'], 2)[0] : $entry['path'];
                    $expectedCanonical = $entry['canonical'] ?? $this->urls->absolute($path);
                    $this->checkPage($response, $expectedCanonical, $entry['contains'] ?? [], $row);
                }
            } catch (ConnectionException) {
                $row['issues'][] = 'connection_failed';
            }
            $row['passed'] = $row['issues'] === [];
            $rows[] = $row;
        }
        $failed = count(array_filter($rows, fn ($row) => ! $row['passed']));

        return ['base_url' => $base, 'total' => count($rows), 'passed' => count($rows) - $failed, 'failed' => $failed, 'results' => $rows];
    }

    private function get(string $url): Response
    {
        return Http::withoutRedirecting()->connectTimeout(5)->timeout(10)
            ->withHeaders(['Accept' => 'text/html', 'User-Agent' => 'JCurve-URL-Preservation-Audit/1.0'])
            ->get($url);
    }

    private function checkPage(Response $response, string $expectedCanonical, array $contains, array &$row): void
    {
        if (! str_contains(strtolower($response->header('Content-Type')), 'text/html')) {
            $row['issues'][] = 'not_html';

            return;
        }
        $xml = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        try {
            $xml->loadHTML('<?xml encoding="UTF-8">'.$response->body(), LIBXML_NONET);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }
        $xpath = new DOMXPath($xml);
        $canonical = [];
        foreach ($xpath->query('//head/link[@href]') as $link) {
            if (in_array('canonical', preg_split('/\s+/', strtolower(trim($link->getAttribute('rel')))), true)) {
                $canonical[] = $link->getAttribute('href');
            }
        }
        $row['canonical'] = $canonical;
        if (count($canonical) !== 1 || ! $this->urls->canonicalMatches($canonical[0], $expectedCanonical)) {
            $row['issues'][] = 'canonical_mismatch_or_missing';
        }
        $robots = $response->header('X-Robots-Tag');
        foreach ($xpath->query('//head/meta[@name]') as $meta) {
            if (in_array(strtolower($meta->getAttribute('name')), ['robots', 'googlebot'], true)) {
                $robots .= ','.$meta->getAttribute('content');
            }
        }
        if (preg_match('/(?:^|[\s,:])(?:noindex|none)(?:$|[\s,])/i', $robots)) {
            $row['issues'][] = 'noindex';
        }
        $text = preg_replace('/\s+/u', ' ', $xpath->query('//body')->item(0)?->textContent ?? '');
        foreach ($contains as $expected) {
            if (! str_contains($text, preg_replace('/\s+/u', ' ', $expected))) {
                $row['issues'][] = 'expected_content_missing';
                break;
            }
        }
    }
}
