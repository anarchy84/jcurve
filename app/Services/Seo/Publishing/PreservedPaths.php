<?php

namespace App\Services\Seo\Publishing;

class PreservedPaths
{
    public static function destination(string $path): ?string
    {
        $key = PublicUrl::comparisonKey(rtrim($path, '/'));

        foreach (config('seo.preserved_map', []) as $modern => $preserved) {
            if ($key === $modern || $key === rtrim($preserved, '/')) {
                return $preserved;
            }
        }

        return null;
    }

    public static function path(string $path): string
    {
        $parts = preg_split('/(?=[?#])/', $path, 2);

        return (self::destination($parts[0]) ?? $parts[0]).($parts[1] ?? '');
    }

    public static function encode(string $path): string
    {
        // URI headers must carry ASCII; retain existing escapes and query bytes.
        return preg_replace_callback('/[\x80-\xff]/', fn ($match) => rawurlencode($match[0]), $path);
    }
}
