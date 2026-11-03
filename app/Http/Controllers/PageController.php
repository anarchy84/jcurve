<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\Work;
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
        // S8 대표 성과: work 데이터 없으면 뷰에서 @if로 섹션 숨김(빈 카드 금지).
        $works = Work::query()
            ->published()
            ->latest('published_at')
            ->latest('id')
            ->take(3)
            ->get();

        // S10a 인사이트 프리뷰: 최신 3건. 없으면 뷰에서 섹션 숨김.
        $query = Insight::query()->with('category');
        if (intl_locale() !== 'ko') {
            $query->whereHas('translations', fn ($query) => $query->where('locale', intl_locale()))
                ->with('translation');
        }
        $insights = $query
            ->published()
            ->latest('published_at')
            ->latest('id')
            ->take(3)
            ->get();

        return intl_view('pages.home', compact('works', 'insights'));
    }

    public function services(): View
    {
        return intl_view('services.index');
    }

    public function service(string $slug): View
    {
        abort_unless(isset(self::SERVICE_VIEWS[$slug]), 404);

        return intl_view(self::SERVICE_VIEWS[$slug]);
    }

    public function seoAeo(): View
    {
        return intl_view('services.seo.aeo');
    }

    public function seoGeo(): View
    {
        return intl_view('services.seo.geo');
    }

    public function solutions(): View
    {
        return intl_view('solutions.index');
    }

    public function rankfree(): View
    {
        return intl_view('solutions.rankfree');
    }

    public function leadbay(): View
    {
        return intl_view('solutions.leadbay');
    }

    public function call2sale(): View
    {
        return intl_view('solutions.call2sale');
    }

    public function boostingshop(): View
    {
        return intl_view('solutions.boostingshop');
    }

    public function company(): View
    {
        return intl_view('pages.company');
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
        return intl_view('pages.marketing-support');
    }

    public function privacy(): View
    {
        return intl_view('pages.privacy');
    }

    public function selfMarketing(): View
    {
        return intl_view('pages.self-marketing');
    }

    public function selfMarketingPlace(): View
    {
        return intl_view('pages.self-marketing-place');
    }

    public function shopitrend(): View
    {
        return intl_view('solutions.shopitrend');
    }

    public function faq(): View
    {
        return intl_view('pages.faq');
    }

    /**
     * config/subpages.php의 그룹·서브슬러그로 서브페이지를 렌더한다.
     * 화이트리스트에 없는 slug는 404.
     */
    private function subpage(string $group, string $sub): View
    {
        $items = config("subpages.{$group}.items", []);
        abort_unless(isset($items[$sub]), 404);

        return intl_view('pages.subpage', [
            'parent' => config("subpages.{$group}.parent"),
            'page' => $items[$sub],
        ]);
    }
}
