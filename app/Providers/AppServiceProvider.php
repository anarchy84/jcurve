<?php

namespace App\Providers;

use App\Services\Seo\Backlinks\BacklinkProvider;
use App\Services\Seo\Backlinks\MockBacklinkProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 백링크 제공자 — 지금은 샘플(Mock). 유료 API 키 확보 시 여기만 실어댑터로 교체.
        $this->app->bind(BacklinkProvider::class, MockBacklinkProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
