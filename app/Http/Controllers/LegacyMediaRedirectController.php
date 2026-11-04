<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LegacyMediaRedirectController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        // Route parameters are decoded; use the original path and query bytes.
        $query = $request->server->get('QUERY_STRING', '');

        return new RedirectResponse('/v1'.$request->getPathInfo().($query === '' ? '' : '?'.$query), 301);
    }
}
