<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\InsightController;
use App\Http\Middleware\SetIntlLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

// Snapshot the Korean routes before registering either language.
Route::getRoutes()->refreshNameLookups();
$originals = [];
foreach (config('intl.routes') as $name) {
    if (Route::has($name)) {
        $originals[$name] = Route::getRoutes()->getByName($name);
    }
}
foreach (['en', 'ja'] as $locale) {
    Route::prefix($locale)->name($locale.'.')->middleware(SetIntlLocale::class)->group(function () use ($originals) {
        foreach ($originals as $name => $original) {
            if ($name === 'insights.show') {
                Route::get('/insights/{slug}', [InsightController::class, 'translatedShow'])
                    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*')->name($name);
            } else {
                $route = Route::get($original->uri(), $original->getAction('uses'))->name($name);
                if ($name === 'services.show') {
                    // Do not let /services/{slug} swallow /services/marketing-support.
                    $route->whereIn('slug', config('intl.services'));
                }
            }
        }
        // Only preserved static/category aliases; Korean article slugs are never foreign aliases.
        foreach (config('seo.preserved_map') as $modern => $preserved) {
            if (preg_match('~^/insights/(?!category/)~', $modern)) {
                continue;
            }
            $original = Route::getRoutes()->match(Request::create($modern));
            if (! isset($originals[$original->getName()])) {
                continue;
            }
            $route = Route::get($preserved, $original->getAction('uses'));
            $route->setAction(array_merge($route->getAction(), ['as' => null, 'intl_name' => $original->getName()]));
            foreach ($original->parameters() as $key => $value) {
                $route->defaults($key, $value);
            }
        }
        Route::post('/contact-us/', [ContactController::class, 'store'])
            ->middleware([ProtectAgainstSpam::class, 'throttle:5,1'])->name('contact.store');
    });
}
