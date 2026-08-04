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

    // ── 레거시 301 도착지 서브페이지 (config/subpages.php 데이터 주도) ──

    public function seoSub(string $sub): View
    {
        return $this->subpage('seo', $sub);
    }

    public function cpaSub(string $sub): View
    {
        return $this->subpage('cpa', $sub);
    }

    public function performanceSub(string $sub): View
    {
        return $this->subpage('performance', $sub);
    }

    public function boostingshopSub(string $sub): View
    {
        return $this->subpage('boostingshop', $sub);
    }

    public function marketingSupport(): View
    {
        return view('pages.marketing-support');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    /**
     * config/subpages.php의 그룹·서브슬러그로 서브페이지를 렌더한다.
     * 화이트리스트에 없는 slug는 404.
     */
    private function subpage(string $group, string $sub): View
    {
        $items = config("subpages.{$group}.items", []);
        abort_unless(isset($items[$sub]), 404);

        return view('pages.subpage', [
            'parent' => config("subpages.{$group}.parent"),
            'page' => $items[$sub],
        ]);
    }
}
