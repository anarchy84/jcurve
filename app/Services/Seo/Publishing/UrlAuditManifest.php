<?php

namespace App\Services\Seo\Publishing;

use InvalidArgumentException;
use JsonException;

class UrlAuditManifest
{
    public function __construct(private PublicUrl $urls) {}

    public function load(?string $file = null): array
    {
        if ($file !== null) {
            $entries = $this->json($file);
        } else {
            $entries = array_map(fn ($path) => ['path' => $path, 'status' => 200], config('seo.preserved_paths', []));
            foreach (['columns', 'wp-posts'] as $group) {
                $files = glob(database_path("content/legacy/{$group}/*.json")) ?: [];
                sort($files);
                foreach ($files as $source) {
                    $data = $this->json($source);
                    $parts = parse_url($data['source_url'] ?? '');
                    if (! is_array($parts) || ! in_array($parts['host'] ?? '', config('seo.legacy_hosts', []), true)
                        || ! in_array($parts['scheme'] ?? '', ['https', 'http'], true)
                        || isset($parts['user']) || isset($parts['pass']) || isset($parts['fragment'])) {
                        throw new InvalidArgumentException("Invalid legacy source URL in {$source}");
                    }
                    $path = ($parts['path'] ?? '/').(isset($parts['query']) ? '?'.$parts['query'] : '');
                    $entries[] = ['path' => $path, 'status' => 200];
                }
            }
        }

        if (! array_is_list($entries) || $entries === []) {
            throw new InvalidArgumentException('The manifest must be a non-empty JSON list.');
        }
        $result = [];
        foreach ($entries as $entry) {
            if (! is_array($entry) || ! is_string($entry['path'] ?? null)) {
                throw new InvalidArgumentException('Every manifest entry needs a local path.');
            }
            $this->urls->absolute($entry['path']);
            $status = $entry['status'] ?? 200;
            if (! in_array($status, [200, 301], true)) {
                throw new InvalidArgumentException('Manifest status must be 200 or an explicitly approved 301.');
            }
            if ($status === 301) {
                if (! is_string($entry['to'] ?? null)) {
                    throw new InvalidArgumentException('An approved 301 needs its exact local destination in to.');
                }
                $this->urls->absolute(explode('#', $entry['to'], 2)[0]);
                if (preg_match('/[\x00-\x20\\\\]/', $entry['to'])) {
                    throw new InvalidArgumentException('Invalid redirect destination.');
                }
            }
            if (isset($entry['canonical']) && ! is_string($entry['canonical'])) {
                throw new InvalidArgumentException('canonical must be a URL string.');
            }
            if (isset($entry['contains']) && (! is_array($entry['contains']) || array_filter($entry['contains'], fn ($value) => ! is_string($value)))) {
                throw new InvalidArgumentException('contains must be a list of expected text strings.');
            }
            if (isset($result[$entry['path']])) {
                throw new InvalidArgumentException('Duplicate URL path in manifest: '.$entry['path']);
            }
            $result[$entry['path']] = array_merge($entry, ['status' => $status]);
        }

        return array_values($result);
    }

    private function json(string $file): array
    {
        if (! is_file($file) || ! is_readable($file)) {
            throw new InvalidArgumentException('Manifest/source file is not readable: '.$file);
        }
        try {
            $data = json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidArgumentException('Invalid JSON in '.$file, previous: $e);
        }
        if (! is_array($data)) {
            throw new InvalidArgumentException('JSON must contain an object or array: '.$file);
        }

        return $data;
    }
}
