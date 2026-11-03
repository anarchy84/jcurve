<?php

namespace App\Services\Seo\Publishing;

use Illuminate\Routing\UrlGenerator;

class PreservedUrlGenerator extends UrlGenerator
{
    public function format($root, $path, $route = null)
    {
        $url = parent::format($root, $path, $route);
        preg_match('~^((?:[a-z][a-z0-9+.-]*:)?//[^/?#]+)([^?#]*)(.*)$~si', $url, $parts);
        $destination = PreservedPaths::destination($parts[2] ?? '/');

        // Laravel trims the final slash after formatPathUsing; restore it here,
        // before route parameters are encoded and query strings are appended.
        return $destination === null ? $url : $parts[1].$destination.$parts[3];
    }
}
