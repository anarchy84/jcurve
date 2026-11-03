<?php

namespace App\Support;

use App\Models\Insight;
use App\Models\LegacyRedirect;
use App\Services\Seo\Publishing\PreservedPaths;
use Illuminate\Http\Request;

class IntlLegacyRedirects
{
    public static function destination(Request $request): ?string
    {
        if (! preg_match('~^/(en|ja)(/.*)$~', $request->getPathInfo(), $matches)) {
            return null;
        }
        [, $locale, $local] = $matches;
        $parameters = array_change_key_case($request->query(), CASE_LOWER);
        $columnId = $parameters['wr_id'] ?? null;
        if (str_contains(mb_strtolower($local), 'board.php')
            && is_string($parameters['bo_table'] ?? null) && mb_strtolower($parameters['bo_table']) === 'column'
            && is_scalar($columnId) && ctype_digit((string) $columnId)) {
            $insight = Insight::query()->published()->where('legacy_wr_id', $columnId)->first();
            $translation = $insight?->translation($locale)->first();

            return $translation ? '/'.$locale.'/insights/'.$translation->slug : null;
        }
        if (preg_match('~^/v1/manager/column/([^/]+)/?$~u', rawurldecode($local), $column)) {
            $insight = Insight::query()->published()->where('slug', $column[1])->first();
            $translation = $insight?->translation($locale)->first();

            return $translation ? '/'.$locale.'/insights/'.$translation->slug : null;
        }
        $target = PreservedPaths::destination($local) ?? $local;
        if ($local === '/company/anarchy' || $local === '/company/anarchy/') {
            $target = '/about-us/';
        } else {
            $copy = Request::create($local, 'GET', $request->query());
            $legacy = LegacyRedirect::resolveFor($copy);
            if ($legacy !== null) {
                if ($legacy->status_code !== 301) {
                    return null;
                }
                $target = PreservedPaths::path($legacy->to_path);
            }
        }
        // A Korean article alias is useful only when this exact language has a public translation.
        if (preg_match('~^/(?:insights|seo)/([^/]+)/?$~u', rawurldecode($target), $article)) {
            $insight = Insight::query()->published()->where('slug', $article[1])->first();
            $translation = $insight?->translation($locale)->first();

            return $translation ? '/'.$locale.'/insights/'.$translation->slug : null;
        }
        if ($target !== $local && ($canonical = PreservedPaths::destination('/'.$locale.$target)) !== null) {
            return $canonical;
        }

        return null;
    }
}
