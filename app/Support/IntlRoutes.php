<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class IntlRoutes
{
    /** The single route-to-view contract used by rendering, alternates and feeds. */
    public static function viewName(string $name, array $parameters = []): ?string
    {
        if (isset(config('intl.subpages')[$name])) {
            return 'pages.subpage';
        }
        if ($name === 'services.show') {
            return in_array($parameters['slug'] ?? '', config('intl.services'), true)
                ? 'services.'.$parameters['slug'] : null;
        }

        return [
            'home' => 'pages.home', 'company' => 'pages.company', 'contact' => 'contact',
            'privacy' => 'pages.privacy', 'support.faq' => 'pages.faq',
            'services.index' => 'services.index', 'services.seo.aeo' => 'services.seo.aeo',
            'services.seo.geo' => 'services.seo.geo', 'services.marketing-support' => 'pages.marketing-support',
            'solutions.index' => 'solutions.index', 'solutions.rankfree' => 'solutions.rankfree',
            'solutions.boostingshop' => 'solutions.boostingshop', 'solutions.shopitrend' => 'solutions.shopitrend',
            'solutions.leadbay' => 'solutions.leadbay', 'solutions.call2sale' => 'solutions.call2sale',
            'self-marketing' => 'pages.self-marketing', 'self-marketing.place' => 'pages.self-marketing-place',
            'work.index' => 'work.index', 'insights.index' => 'insights.index',
            'insights.category' => 'insights.category', 'insights.show' => 'insights.show',
        ][$name] ?? null;
    }

    public static function available(string $name, array $parameters, string $locale): bool
    {
        $view = self::viewName($name, $parameters);
        if ($view === null || ! View::exists('intl.'.$view)) {
            return false;
        }
        if ($view === 'pages.subpage') {
            $group = config('intl.subpages')[$name] ?? null;
            $sub = $parameters['sub'] ?? '';
            // No fallback locale: each language must contain its own complete item.
            $translations = app('translator')->get('subpages', [], $locale, false);

            return is_array($translations) && isset($translations[$group]['items'][$sub]);
        }

        return true;
    }

    /** Static pages, expanded using the same parameter allowlists as the controllers. */
    public static function variants(): array
    {
        $variants = [];
        foreach (config('intl.routes', []) as $name) {
            if (! Route::has($name) || in_array($name, ['insights.category', 'insights.show'], true)) {
                continue;
            }
            $parameters = [[]];
            if ($name === 'services.show') {
                $parameters = array_map(fn ($slug) => ['slug' => $slug], config('intl.services'));
            }
            // Config keys containing dots must be read as array keys, not dot paths.
            if (isset(config('intl.subpages')[$name])) {
                $group = config('intl.subpages')[$name];
                $parameters = array_map(fn ($sub) => ['sub' => $sub], array_keys(config("subpages.{$group}.items", [])));
            }
            foreach ($parameters as $params) {
                $path = '/'.ltrim(Route::getRoutes()->getByName($name)->uri(), '/');
                foreach ($params as $key => $value) {
                    $path = str_replace('{'.$key.'}', rawurlencode($value), $path);
                }
                $variants[] = ['name' => $name, 'parameters' => $params, 'path' => $path];
            }
        }

        return $variants;
    }
}
