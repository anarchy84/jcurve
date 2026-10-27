<?php

use App\Http\Controllers\SeoFeedController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SeoFeedController::class, 'index'])->name('seo.sitemap');
Route::get('/sitemaps/{section}/{page}.xml', [SeoFeedController::class, 'section'])
    ->whereIn('section', ['pages', 'services', 'insights', 'works'])
    ->where('page', '[1-9][0-9]*')
    ->name('seo.sitemap.section');
Route::get('/rss', [SeoFeedController::class, 'rss'])->name('seo.rss');
