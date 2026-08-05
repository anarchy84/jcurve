<?php

namespace Tests\Feature;

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Models\LegacyRedirect;
use App\Models\User;
use Database\Seeders\InsightCategorySeeder;
use Database\Seeders\LegacyRedirectSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegacyRedirectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // 콘텐츠 이식은 파일 I/O가 커서 리다이렉트 테스트에는 정적 시더만 사용.
        $this->seed(InsightCategorySeeder::class);
        $this->seed(LegacyRedirectSeeder::class);
    }

    public function test_wordpress_page_redirects_with_trailing_slash_single_hop(): void
    {
        $this->get('/about-us/')
            ->assertStatus(301)
            ->assertRedirect('/company');
    }

    public function test_service_landing_redirects(): void
    {
        $this->get('/seo-backlinks')
            ->assertStatus(301)
            ->assertRedirect('/services/seo/backlinks');
    }

    public function test_legacy_php_landing_redirects(): void
    {
        $this->get('/cpa.php')
            ->assertStatus(301)
            ->assertRedirect('/services/cpa-marketing');
    }

    public function test_v1_insurance_landing_redirects_in_one_hop(): void
    {
        $this->get('/v1/insurance.php')
            ->assertStatus(301)
            ->assertRedirect('/services/cpa-marketing/insurance');
    }

    public function test_avada_dummy_portfolio_redirects_to_work(): void
    {
        $this->get('/portfolio-items/cras-mollis-nons')
            ->assertStatus(301)
            ->assertRedirect('/work');
    }

    public function test_gnuboard_column_query_redirects_to_insight(): void
    {
        // 이식된 칼럼 한 편을 흉내내는 최소 데이터 + 리다이렉트 등록
        $author = User::factory()->create();
        $categoryId = InsightCategory::query()->where('slug', 'news')->value('id');
        $insight = Insight::query()->create([
            'user_id' => $author->id,
            'category_id' => $categoryId,
            'title' => '테스트 칼럼',
            'slug' => 'test-column',
            'content' => '<p>본문</p>',
            'legacy_wr_id' => 999,
            'published_at' => now(),
        ]);
        LegacyRedirect::query()->create([
            'from_path' => LegacyRedirect::buildQueryKey('v1/manager/bbs/board.php', [
                'bo_table' => 'column', 'wr_id' => '999',
            ]),
            'to_path' => '/insights/'.$insight->slug,
            'status_code' => 301,
        ]);

        $this->get('/v1/manager/bbs/board.php?bo_table=column&wr_id=999&page=3')
            ->assertStatus(301)
            ->assertRedirect('/insights/test-column');
    }

    public function test_unknown_path_stays_404(): void
    {
        $this->get('/definitely-not-a-real-page')->assertStatus(404);
    }

    public function test_subpage_whitelist_enforced(): void
    {
        $this->get('/services/seo/backlinks')->assertStatus(200);
        $this->get('/services/seo/not-a-real-sub')->assertStatus(404);
    }

    public function test_standalone_pages_render(): void
    {
        $this->get('/services/marketing-support')->assertStatus(200);
        $this->get('/privacy')->assertStatus(200);
        $this->get('/solutions/boostingshop/basic')->assertStatus(200);
    }
}
