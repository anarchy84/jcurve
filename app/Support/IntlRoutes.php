<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

class IntlRoutes
{
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
