<?php

namespace App\Http\Middleware;

use App\Services\Seo\Publishing\PreservedPaths;
use App\Services\Seo\Publishing\PublicUrl;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreservePublicUrls
{
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->method(), ['GET', 'HEAD'], true)) {
            $path = $request->getPathInfo();
            $destination = PreservedPaths::destination($path);

            if ($destination !== null && PublicUrl::comparisonKey($path) !== $destination) {
                $query = $request->server->get('QUERY_STRING', '');

                return redirect(PreservedPaths::encode($destination).($query === '' ? '' : '?'.$query), 301);
            }
        }

        return $next($request);
    }
}
