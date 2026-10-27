<?php

namespace App\Services\Seo\Publishing;

use InvalidArgumentException;

class PublicUrl
{
    public function base(): string
    {
        return self::origin((string) config('seo.public_url'));
    }

    public static function origin(string $value): string
    {
        $base = rtrim($value, '/');
        $parts = parse_url($base);

        if (! is_array($parts) || ! in_array($parts['scheme'] ?? '', ['http', 'https'], true)
            || empty($parts['host']) || isset($parts['user']) || isset($parts['pass'])
            || isset($parts['query']) || isset($parts['fragment']) || ! empty($parts['path'])
            || preg_match('/[\x00-\x20\\\\]/', $base)) {
            throw new InvalidArgumentException('SEO_PUBLIC_URL must be an HTTP(S) origin without a path or credentials.');
        }

        return $base;
    }

    public function absolute(string $path): string
    {
        if (! str_starts_with($path, '/') || str_starts_with($path, '//')
            || preg_match('/[\x00-\x20\\\\#]/', $path)) {
            throw new InvalidArgumentException('A local absolute URL path is required.');
        }

        return $this->base().$path;
    }

    public function canonicalMatches(string $canonical, string $expected): bool
    {
        if (str_starts_with($canonical, '/') && ! str_starts_with($canonical, '//')) {
            try {
                $canonical = $this->absolute($canonical);
            } catch (InvalidArgumentException) {
                return false;
            }
        }

        return self::equivalent($canonical, $expected);
    }

    public static function equivalent(string $actual, string $expected): bool
    {
        foreach ([$actual, $expected] as $url) {
            if (preg_match('/[\x00-\x20\\\\]|%(?![0-9a-f]{2})/i', $url)) {
                return false;
            }
        }

        return self::comparisonKey($actual) === self::comparisonKey($expected);
    }

    public static function comparisonKey(string $url): string
    {
        return preg_replace_callback('/%([0-9a-f]{2})/i', static function (array $match): string {
            $character = chr(hexdec($match[1]));

            // Keep encoded delimiters distinct from URL path, query and fragment syntax.
            return ord($character) >= 128 || preg_match('/[a-z0-9._~-]/i', $character)
                ? $character : '%'.strtoupper($match[1]);
        }, $url);
    }
}
