<?php

namespace Tests\Feature;

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Models\LegacyRedirect;
use Database\Seeders\InsightCategorySeeder;
use Database\Seeders\KeywordInsightSeeder;
use Database\Seeders\LegacyContentSeeder;
use Database\Seeders\LegacyRedirectSeeder;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;
use Tests\TestCase;

class KeywordInsightTest extends TestCase
{
    use RefreshDatabase;

    private const PUBLIC_URL = 'https://j-curve.co.kr';

    private const DUPLICATE_SLUG = '2019년-그로스해커에게-필요한-스킬3-1';

    private const CANONICAL_SLUG = '2019년-그로스해커에게-필요한-스킬3';

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => self::PUBLIC_URL]);
        $this->travelTo(Carbon::parse('2026-11-05 12:00:00', 'UTC'));
    }

    public static function landingPages(): array
    {
        return [
            'place' => [
                '/naver-place-marketing/',
                '네이버 플레이스 상위노출 — 발견에서 방문까지',
                '네이버 플레이스 순위와 노출은 무엇으로 정해지나요',
                '플레이스 순위는 어떻게 확인하나요?',
                '플레이스 리워드도 함께 진행하나요?',
                '/self-marketing/place', 'place-rank', 'checklist', 'naver-place',
            ],
            'shopping' => [
                '/naver-shopping-marketing/',
                '네이버 쇼핑·스마트스토어 상위노출 — 상품 데이터부터 구매 설득까지',
                '네이버 쇼핑 순위는 무엇으로 정해지나요',
                '스마트스토어 상위노출은 얼마나 걸리나요?',
                '쇼핑 유입 리워드도 함께 하나요?',
                '/self-marketing/shopping', 'shopping-rank', 'table', 'naver-shopping',
            ],
        ];
    }

    #[DataProvider('landingPages')]
    public function test_landing_copy_ranking_section_faq_and_links_render(
        string $path, string $title, string $sectionTitle, string $firstQuestion,
        string $secondQuestion, string $rewardPath, string $sectionId,
        string $precedingType, string $slug,
    ): void {
        $html = $this->html($this->get(self::PUBLIC_URL.$path)->assertOk()->getContent());
        $this->assertSame(1, $html->query('//h1')->length);
        $this->assertSame($title, trim($html->evaluate('string(//h1)')));
        $this->assertSame(1, $html->query('//h2[normalize-space(.)="'.$sectionTitle.'"]')->length);
        foreach ([$firstQuestion, $secondQuestion] as $question) {
            $this->assertGreaterThan(0, $html->query('//*[normalize-space(.)="'.$question.'"]')->length);
        }
        foreach ([$rewardPath, '/solutions/rankfree'] as $link) {
            $this->assertGreaterThan(0, $html->query('//a[@href="'.$link.'" or @href="'.self::PUBLIC_URL.$link.'"]')->length);
        }

        $sections = config('subpages.seo.items.'.$slug.'.sections');
        $index = array_key_first(array_filter($sections, fn ($section) => ($section['id'] ?? null) === $sectionId));
        $this->assertNotNull($index);
        $this->assertSame($precedingType, $sections[$index - 1]['type']);
    }

    public function test_deployable_sources_are_byte_identical_to_the_approved_copy(): void
    {
        foreach (['manifest.json', ...array_column($this->manifest(), 'file')] as $file) {
            $this->assertSame(
                file_get_contents(base_path('docs/content/articles/kw01/'.$file)),
                file_get_contents(database_path('content/kw01/'.$file)),
                $file,
            );
        }
        $this->assertSame(
            file_get_contents(base_path('docs/content/insight-meta-2026-11-04.json')),
            file_get_contents(database_path('content/kw01/insight-meta.json')),
        );
    }

    public function test_seeding_twice_keeps_five_exact_public_articles_with_fixed_dates_and_categories(): void
    {
        $this->seed(InsightCategorySeeder::class);
        $this->seed(KeywordInsightSeeder::class);
        $first = Insight::query()->orderBy('id')->get()->map->getRawOriginal()->all();
        $this->travelTo(now()->addDays(3));
        $this->seed(KeywordInsightSeeder::class);

        $this->assertDatabaseCount('insights', 5);
        $this->assertSame($first, Insight::query()->orderBy('id')->get()->map->getRawOriginal()->all());
        $this->assertSame(5, Insight::query()->published()->count());
        foreach ($this->manifest() as $article) {
            $insight = Insight::query()->where('slug', $article['slug'])->firstOrFail();
            foreach (['title', 'excerpt', 'meta_title', 'meta_description'] as $field) {
                $this->assertSame($article[$field], $insight->{$field});
            }
            $this->assertSame(file_get_contents(database_path('content/kw01/'.$article['file'])), $insight->getRawOriginal('content'));
            $this->assertNull($insight->user_id);
            $this->assertSame($article['category_slug'], $insight->category->slug);
            $this->assertSame('2026-11-04 10:00:00', $insight->published_at->setTimezone('Asia/Seoul')->format('Y-m-d H:i:s'));
        }
    }

    public function test_new_articles_render_their_own_canonical_metadata_and_appear_in_the_insights_sitemap(): void
    {
        $this->seed([InsightCategorySeeder::class, KeywordInsightSeeder::class]);
        $sitemap = $this->get('/sitemaps/insights/1.xml')->assertOk();
        $this->get('/sitemap.xml')->assertOk()->assertSee(self::PUBLIC_URL.'/sitemaps/insights/1.xml');

        foreach ($this->manifest() as $article) {
            $url = self::PUBLIC_URL.'/insights/'.rawurlencode($article['slug']);
            $html = $this->html($this->get($url)->assertOk()->getContent());
            $this->assertSame($article['title'], trim($html->evaluate('string(//h1)')));
            $this->assertSame($article['meta_title'].' | 제이커브인터렉티브', $html->evaluate('string(//head/title)'));
            $this->assertSame($article['meta_description'], $html->evaluate('string(//head/meta[@name="description"]/@content)'));
            $this->assertSame(1, $html->query('//head/link[@rel="canonical"]')->length);
            $this->assertSame($url, $html->evaluate('string(//head/link[@rel="canonical"]/@href)'));
            $sitemap->assertSee($url, false);
        }
    }

    public function test_missing_category_throws_without_partial_inserts_or_existing_content_changes(): void
    {
        $this->seed(InsightCategorySeeder::class);
        // seo is valid for the first article; reward is missing for the second.
        InsightCategory::query()->where('slug', 'reward')->delete();

        try {
            $this->seed(KeywordInsightSeeder::class);
            $this->fail('A missing category must fail instead of silently falling back.');
        } catch (RuntimeException $exception) {
            $this->assertSame('Missing insight category: reward', $exception->getMessage());
        }
        $this->assertDatabaseCount('insights', 0);
        $this->assertDatabaseCount('legacy_redirects', 0);
    }

    public function test_all_33_descriptions_change_without_touching_other_legacy_fields(): void
    {
        $this->seed([InsightCategorySeeder::class, LegacyRedirectSeeder::class, LegacyContentSeeder::class]);
        $before = Insight::query()->orderBy('id')->get()->keyBy('slug')->map->getRawOriginal()->all();
        $descriptions = array_column($this->descriptions(), 'meta_description', 'slug');
        $this->assertCount(33, $descriptions);
        $this->assertCount(33, array_intersect_key($before, $descriptions));

        $this->artisan('db:seed', ['--class' => KeywordInsightSeeder::class, '--no-interaction' => true])
            ->expectsOutput('Keyword insights upserted: 5')
            ->expectsOutput('Insight descriptions updated: 33; missing slugs skipped: 0')
            ->assertSuccessful();

        foreach ($before as $slug => $original) {
            $expected = $original;
            if (isset($descriptions[$slug])) {
                $expected['meta_description'] = $descriptions[$slug];
            }
            if ($slug === self::DUPLICATE_SLUG) {
                $expected['published_at'] = null;
            }
            $this->assertSame($expected, Insight::query()->where('slug', $slug)->firstOrFail()->getRawOriginal(), $slug);
        }
        foreach ([0, 16, 32] as $index) {
            $row = $this->descriptions()[$index];
            $this->assertDatabaseHas('insights', $row);
        }
    }

    public function test_missing_description_slugs_are_skipped_and_counted(): void
    {
        $this->seed(InsightCategorySeeder::class);

        $this->artisan('db:seed', ['--class' => KeywordInsightSeeder::class, '--no-interaction' => true])
            ->expectsOutput('Keyword insights upserted: 5')
            ->expectsOutput('Insight descriptions updated: 0; missing slugs skipped: 33')
            ->assertSuccessful();
        $this->assertDatabaseCount('insights', 5);
    }

    public function test_duplicate_is_retained_unpublished_and_all_inbound_redirects_finish_in_one_hop(): void
    {
        $this->seed([InsightCategorySeeder::class, LegacyRedirectSeeder::class, LegacyContentSeeder::class]);
        $duplicate = Insight::query()->where('slug', self::DUPLICATE_SLUG)->firstOrFail();
        $original = $duplicate->getRawOriginal();
        $path = '/insights/'.self::DUPLICATE_SLUG;
        $destination = '/insights/'.self::CANONICAL_SLUG;
        $this->get($path)->assertOk();
        $inbound = LegacyRedirect::query()->where('to_path', $path)->pluck('from_path')->all();
        $this->assertNotEmpty($inbound);
        foreach (['encoded' => '/insights/'.rawurlencode(self::DUPLICATE_SLUG), 'trailing-slash' => $path.'/'] as $key => $target) {
            LegacyRedirect::query()->create(['from_path' => 'old-duplicate-'.$key, 'to_path' => $target, 'status_code' => 302]);
            $inbound[] = 'old-duplicate-'.$key;
        }

        $this->seed(KeywordInsightSeeder::class);
        $redirectCount = LegacyRedirect::count();
        $this->seed(KeywordInsightSeeder::class);
        $this->assertSame($redirectCount, LegacyRedirect::count());
        $expected = $original;
        $expected['published_at'] = null;
        $this->assertSame($expected, $duplicate->fresh()->getRawOriginal());
        $this->assertFalse(Insight::query()->published()->whereKey($duplicate->id)->exists());

        foreach ([$path, ...array_map(fn ($from) => '/'.$from, $inbound)] as $from) {
            foreach (['GET', 'HEAD'] as $method) {
                $response = $this->call($method, $from)->assertStatus(301);
                $location = $response->headers->get('Location');
                $this->assertSame($destination, rawurldecode(parse_url($location, PHP_URL_PATH)));
                $this->call($method, $location)->assertOk()->assertHeaderMissing('Location');
            }
        }
        $this->assertSame(0, LegacyRedirect::query()->where('to_path', $path)->count());
        foreach (['/sitemaps/insights/1.xml', '/rss', '/blog/'] as $feed) {
            $response = $this->get($feed)->assertOk();
            $response->assertDontSee(self::DUPLICATE_SLUG, false)->assertDontSee(rawurlencode(self::DUPLICATE_SLUG), false);
        }
    }

    public function test_shopping_page_is_registered_public_and_listed_in_the_pages_sitemap(): void
    {
        $this->assertTrue(Route::has('self-marketing.shopping'));
        $this->get('/self-marketing/shopping')->assertOk();
        $this->get('/sitemaps/pages/1.xml')->assertOk()->assertSee(self::PUBLIC_URL.'/self-marketing/shopping');
    }

    private function manifest(): array
    {
        return json_decode(file_get_contents(database_path('content/kw01/manifest.json')), true, flags: JSON_THROW_ON_ERROR);
    }

    private function descriptions(): array
    {
        return json_decode(file_get_contents(database_path('content/kw01/insight-meta.json')), true, flags: JSON_THROW_ON_ERROR);
    }

    private function html(string $html): DOMXPath
    {
        $dom = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        try {
            $dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_NONET);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        return new DOMXPath($dom);
    }
}
