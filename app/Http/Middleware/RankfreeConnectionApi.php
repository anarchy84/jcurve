<?php

namespace App\Http\Middleware;

use App\Services\Rankfree\ConnectionStoreException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RankfreeConnectionApi
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('rankfree.connections_enabled') !== true) {
            throw new ConnectionStoreException('connections_disabled');
        }

        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-store, private');
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}
