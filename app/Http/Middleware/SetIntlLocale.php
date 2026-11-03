<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetIntlLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $previous = app()->getLocale();
        app()->setLocale(intl_locale());
        try {
            return $next($request);
        } finally {
            app()->setLocale($previous);
        }
    }
}
