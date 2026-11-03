<?php

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Services\Seo\Publishing\PreservedPaths;
use App\Services\Seo\Publishing\PublicUrl;
use App\Support\IntlRoutes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

function intl_locale(): string
{
    $prefix = request()->segment(1);

    return isset(config('intl.locales', [])[$prefix]) && $prefix !== 'ko' ? $prefix : config('intl.default', 'ko');
}

function intl_route($name, $params = [], $locale = null): string
{
    $locale ??= intl_locale();
    abort_unless(isset(config('intl.locales')[$locale]), 404);
    $name = preg_replace('/^(?:en|ja)\./', '', $name);

    return route($locale === 'ko' ? $name : $locale.'.'.$name, $params);
}

function intl_view($name, $data = []): View
{
    if (intl_locale() !== 'ko') {
        $route = request()->route();
        $routeName = preg_replace('/^(?:en|ja)\./', '', $route?->getAction('intl_name') ?? $route?->getName() ?? '');
        $parameters = $route?->parameters() ?? [];
        abort_unless(IntlRoutes::available($routeName, $parameters, intl_locale()), 404);
        $name = 'intl.'.IntlRoutes::viewName($routeName, $parameters);
    }

    return view($name, $data);
}

function intl_alternates(): array
{
    $route = request()->route();
    $name = preg_replace('/^(?:en|ja)\./', '', $route?->getAction('intl_name') ?? $route?->getName() ?? '');
    $params = $route?->parameters() ?? [];
    // Korean preserved routes intentionally stay unnamed. Resolve their named
    // counterpart without changing any Korean route, response, or URL contract.
    if ($name === '' && intl_locale() === 'ko') {
        foreach (config('seo.preserved_map', []) as $modern => $preserved) {
            if (PublicUrl::comparisonKey(request()->getPathInfo()) === $preserved) {
                $counterpart = Route::getRoutes()->match(Request::create(PreservedPaths::encode($modern)));
                $name = $counterpart->getName() ?? '';
                $params = $counterpart->parameters();
                break;
            }
        }
    }
    if (! in_array($name, config('intl.routes', []), true)) {
        return [];
    }
    $insight = null;
    if ($name === 'insights.show') {
        $insight = request()->attributes->get('intl.insight');
        if (! $insight) {
            $value = $params['insight'] ?? null;
            $insight = $value instanceof Insight ? $value : Insight::query()->where('slug', $value)->first();
        }
        if (! $insight || ! Insight::query()->published()->whereKey($insight->id)->exists()) {
            return [];
        }
        $insight->loadMissing('translations');
    }
    $urls = [];
    foreach (array_keys(config('intl.locales')) as $locale) {
        if ($locale !== 'ko' && ! IntlRoutes::available($name, $params, $locale)) {
            continue;
        }
        $localized = $params;
        if ($insight) {
            $translation = $insight->translations->firstWhere('locale', $locale);
            if ($locale !== 'ko' && ! $translation) {
                continue;
            }
            $localized = $locale === 'ko' ? ['insight' => $insight->slug] : ['slug' => $translation->slug];
        } elseif ($name === 'insights.category' && $locale !== 'ko') {
            $exists = InsightCategory::query()->where('slug', $params['slug'] ?? '')
                ->whereHas('insights', fn ($query) => $query->published()->whereHas('translations', fn ($query) => $query->where('locale', $locale)))
                ->exists();
            if (! $exists) {
                continue;
            }
        }
        $localizedName = $locale === 'ko' ? $name : $locale.'.'.$name;
        if (Route::has($localizedName)) {
            $urls[$locale] = app(PublicUrl::class)->absolute(route($localizedName, $localized, false));
        }
    }

    return count($urls) > 1 ? $urls : [];
}
