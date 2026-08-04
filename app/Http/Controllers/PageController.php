<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * @var array<string, string>
     */
    private const SERVICE_VIEWS = [
        'performance-marketing' => 'services.performance-marketing',
        'cpa-marketing' => 'services.cpa-marketing',
        'reward-network' => 'services.reward-network',
        'seo' => 'services.seo',
        'wordpress' => 'services.wordpress',
    ];

    public function home(): View
    {
        return view('pages.home');
    }

    public function services(): View
    {
        return view('services.index');
    }

    public function service(string $slug): View
    {
        abort_unless(isset(self::SERVICE_VIEWS[$slug]), 404);

        return view(self::SERVICE_VIEWS[$slug]);
    }

    public function seoAeo(): View
    {
        return view('services.seo.aeo');
    }

    public function seoGeo(): View
    {
        return view('services.seo.geo');
    }

    public function rankfree(): View
    {
        return view('solutions.rankfree');
    }

    public function boostingshop(): View
    {
        return view('solutions.boostingshop');
    }

    public function company(): View
    {
        return view('pages.company');
    }

    public function anarchy(): View
    {
        return view('pages.anarchy');
    }
}
