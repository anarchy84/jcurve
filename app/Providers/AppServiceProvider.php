<?php

namespace App\Providers;

use App\Services\Seo\Backlinks\BacklinkProvider;
use App\Services\Seo\Backlinks\MockBacklinkProvider;
use App\Services\Seo\Keywords\KeywordProvider;
use App\Services\Seo\Keywords\MockKeywordProvider;
use App\Services\Seo\Traffic\MockTrafficProvider;
use App\Services\Seo\Traffic\TrafficProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // SEO 데이터 제공자 — 지금은 전부 샘플(Mock). 유료 API 키 확보 시 여기만 실어댑터로 교체.
        $this->app->bind(BacklinkProvider::class, MockBacklinkProvider::class);
        $this->app->bind(KeywordProvider::class, MockKeywordProvider::class);
        $this->app->bind(TrafficProvider::class, MockTrafficProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
