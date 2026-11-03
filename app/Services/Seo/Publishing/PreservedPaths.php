<?php

namespace App\Services\Seo\Publishing;

use App\Support\IntlRoutes;

class PreservedPaths
{
    public static function destination(string $path): ?string
    {
        if (preg_match('~^/(en|ja)(/.*)?$~', $path, $matches)) {
            $prefix = '/'.$matches[1];
            $local = $matches[2] ?? '/';
            $key = PublicUrl::comparisonKey(rtrim($local, '/'));
            foreach (IntlRoutes::variants() as $variant) {
                $modern = $variant['path'];
                $canonical = self::destination($modern) ?? $modern;
                if ($key === rtrim($modern, '/') || $key === rtrim($canonical, '/')) {
                    return $prefix.$canonical;
                }
            }
            // Categories share Korean preserved addresses; articles use translation slugs only.
            if (preg_match('~^/insights/category/[^/]+$~', $key)) {
                return $prefix.(self::destination($local) ?? rtrim($local, '/'));
            }
            foreach (['seo', 'link-building'] as $slug) {
                if ($key === '/blog/'.$slug) {
                    return $prefix.'/blog/'.$slug.'/';
                }
            }
            if (preg_match('~^/insights/[a-z0-9]+(?:-[a-z0-9]+)*$~', $key)) {
                return $prefix.$key;
            }

            return null;
        }

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
