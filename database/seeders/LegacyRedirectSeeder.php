<?php

namespace Database\Seeders;

use App\Models\LegacyRedirect;
use Illuminate\Database\Seeder;

class LegacyRedirectSeeder extends Seeder
{
    public function run(): void
    {
        // docs/URL-MIGRATION.md v2 §A(워드프레스) + §B-2(구버전 랜딩) 정적 매핑.
        // 칼럼 50편·WP 아티클 3편의 동적 매핑은 LegacyContentSeeder가 등록한다.
        $map = [
            // ── §A 워드프레스 페이지 ──
            'seo' => '/services/seo',
            'seo-backlinks' => '/services/seo/backlinks',
            'wordpress-agency' => '/services/wordpress',
            'naver-place-marketing' => '/services/seo/naver-place',
            'naver-shopping-marketing' => '/services/seo/naver-shopping',
            'kakao-gift' => '/services/seo/kakao-gift',
            'coupang' => '/services/seo/coupang',
            'about-us' => '/company',
            'contact-us' => '/contact',
            'blog' => '/insights',
            'blog/seo' => '/insights/category/seo',
            'blog/link-building' => '/insights/category/link-building',
            'shop' => '/solutions/boostingshop',
            'shop/backlinks/seo-캠페인-베이직' => '/solutions/boostingshop/basic',
            'shop/backlinks/seo-캠페인-프로' => '/solutions/boostingshop/pro',
            'shop/backlinks/seo-캠페인-엘리트' => '/solutions/boostingshop/elite',
            'log-in' => '/login',
            'join' => '/register',
            'recover-password' => '/forgot-password',
            'my-account' => '/profile',
            'cart' => '/solutions/boostingshop',
            'checkout' => '/solutions/boostingshop',

            // ── §B-2 구버전 루트 랜딩(.php) ──
            'cpa.php' => '/services/cpa-marketing',
            'land.php' => '/services/cpa-marketing/real-estate',
            'stock.php' => '/services/cpa-marketing/stock',
            'insurance.php' => '/services/cpa-marketing/insurance',
            'coin.php' => '/services/cpa-marketing/coin',
            'permission.php' => '/services/cpa-marketing/permission-call',
            'gfa.php' => '/services/performance-marketing/naver-gfa',
            'facebook.php' => '/services/performance-marketing/facebook',
            'youtube.php' => '/services/performance-marketing/youtube',
            'instagram.php' => '/solutions/boostingshop/instagram-popular',
            'followers_up.php' => '/solutions/boostingshop/instagram-followers',
            'instagram_likes.php' => '/solutions/boostingshop/instagram-likes',
            'shopping_marketing.php' => '/services/seo/naver-shopping',
            'shopping_smartstore.php' => '/services/seo/naver-shopping',
            'marketing-support-project.php' => '/services/marketing-support',

            // ── §B-3 /v1/ 페이지 ──
            'v1' => '/',
            'v1/company.php' => '/company',
            'v1/policy.php' => '/privacy',
            'v1/contact.php' => '/contact',
            'v1/portfolio.php' => '/work',
            'v1/ad_campaign.php' => '/work',
        ];

        // Avada 테마 더미 포트폴리오 13개 → /work
        $dummies = [
            'portfolio-items',
            'cras-mollis-nons', 'enim-pellentesque', 'donec-et-sagittis',
            'tras-commodo-ets', 'proin-tortor-orcus', 'class-et-aptent',
            'iaculis-eu-gigni', 'donec-magna-velit', 'varius-lectus-ulla',
            'duis-imperdiet-malis', 'non-mattis-tortor', 'faucibus-tellus',
        ];
        foreach ($dummies as $slug) {
            $path = $slug === 'portfolio-items' ? 'portfolio-items' : "portfolio-items/{$slug}";
            $map[$path] = '/work';
        }

        foreach ($map as $from => $to) {
            LegacyRedirect::query()->updateOrCreate(
                ['from_path' => LegacyRedirect::normalizePath($from)],
                ['to_path' => $to, 'status_code' => 301],
            );
        }
    }
}
