<?php

namespace Tests\Feature;

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Models\SeoMeta;
use App\Models\User;
use App\Models\Work;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SeoKeywordFoundationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => 'https://j-curve.co.kr']);
    }

    #[DataProvider('legacyMediaUris')]
    public function test_legacy_media_redirect_preserves_path_and_query_bytes(string $uri, string $target): void
    {
        $this->get($uri)->assertStatus(301)->assertHeader('Location', $target);
    }

    public static function legacyMediaUris(): array
    {
        return [
            'nested image' => ['/manager/data/editor/2020/01/image.jpg', '/v1/manager/data/editor/2020/01/image.jpg'],
            'query bytes and duplicate keys' => [
                '/manager/data/editor/image.jpg?b=2&a=1&a=3&name=a+b&encoded=%2f%2F&empty=',
                '/v1/manager/data/editor/image.jpg?b=2&a=1&a=3&name=a+b&encoded=%2f%2F&empty=',
            ],
            'Korean path' => [
                '/manager/data/editor/한글/이미지.png?size=120',
                '/v1/manager/data/editor/'.rawurlencode('한글').'/'.rawurlencode('이미지').'.png?size=120',
            ],
            'encoded delimiters and percent' => [
                '/manager/data/editor/a%20b%23c%3Fd%25e%2ff%252Fg+v(1).jpg?file=%ED%95%9C%EA%B8%80',
                '/v1/manager/data/editor/a%20b%23c%3Fd%25e%2ff%252Fg+v(1).jpg?file=%ED%95%9C%EA%B8%80',
            ],
            'other data directory' => ['/manager/data/attachments/file.pdf', '/v1/manager/data/attachments/file.pdf'],
            'trailing slash' => ['/manager/data/editor/folder/', '/v1/manager/data/editor/folder/'],
        ];
    }

    public function test_legacy_media_head_uses_the_same_redirect(): void
    {
        $this->head('/manager/data/editor/image.jpg?v=1')
            ->assertStatus(301)->assertHeader('Location', '/v1/manager/data/editor/image.jpg?v=1');
    }

    public function test_empty_sections_are_not_advertised_but_first_pages_stay_available(): void
    {
        $index = $this->xml($this->get('/sitemap.xml')->assertOk()->getContent());
        $this->assertSame(0, $index->query('//sm:loc[contains(text(), "/sitemaps/works/")]')->length);
        $this->assertSame(0, $index->query('//sm:loc[contains(text(), "/sitemaps/insights/")]')->length);
        $this->assertGreaterThan(0, $index->query('//sm:loc[contains(text(), "/sitemaps/pages/")]')->length);

        foreach (['works', 'insights'] as $section) {
            $xml = $this->xml($this->get("/sitemaps/{$section}/1.xml")->assertOk()->getContent());
            $this->assertSame(0, $xml->query('/sm:urlset/sm:url')->length);
            $this->get("/sitemaps/{$section}/2.xml")->assertNotFound();
        }
    }

    public function test_nonempty_work_section_is_advertised(): void
    {
        Work::query()->create(['slug' => 'public-work', 'title' => '공개 성과', 'content' => '<p>성과</p>', 'published_at' => now()->subDay()]);

        $this->get('/sitemap.xml')->assertOk()->assertSee('https://j-curve.co.kr/sitemaps/works/1.xml');
        $this->get('/sitemaps/works/1.xml')->assertOk()->assertSee('https://j-curve.co.kr/work/public-work');
    }

    public function test_all_nine_categories_with_published_articles_and_original_urls_are_listed(): void
    {
        $slugs = ['branding', 'content-marketing', 'cpa', 'facebook', 'google-ads', 'instagram', 'reward', 'wordpress', 'youtube', 'seo', 'link-building'];
        foreach ($slugs as $slug) {
            $this->insight($slug);
        }
        $this->insight('reward', ['slug' => 'second-reward-article']);

        $xml = $this->xml($this->get('/sitemaps/pages/1.xml')->assertOk()->getContent());
        foreach ($slugs as $slug) {
            $path = in_array($slug, ['seo', 'link-building'], true) ? "/blog/{$slug}/" : "/insights/category/{$slug}";
            $this->assertSame(1, $xml->query('/sm:urlset/sm:url/sm:loc[text()="https://j-curve.co.kr'.$path.'"]')->length, $slug);
        }
        $this->assertSame(0, $xml->query('//sm:loc[contains(text(), "/insights/category/seo") or contains(text(), "/insights/category/link-building")]')->length);
    }

    public function test_unpublished_and_nonindexable_categories_remain_excluded(): void
    {
        InsightCategory::query()->create(['name' => 'empty', 'slug' => 'empty']);
        $this->insight('draft-only', ['published_at' => null]);
        $this->insight('future-only', ['published_at' => now()->addDay()]);
        $this->insight('hidden-only', ['slug' => config('seo.hidden_insights')[0]]);
        $this->insight('noindex');
        $this->insight('duplicate');
        SeoMeta::query()->create(['path' => '/insights/category/noindex', 'robots' => 'noindex, follow']);
        SeoMeta::query()->create(['path' => '/insights/category/duplicate', 'canonical' => 'https://other.example/category']);

        $response = $this->get('/sitemaps/pages/1.xml')->assertOk();
        foreach (['empty', 'draft-only', 'future-only', 'hidden-only', 'noindex', 'duplicate'] as $slug) {
            $response->assertDontSee('/insights/category/'.$slug);
        }
    }

    #[DataProvider('coverImages')]
    public function test_insight_cover_images_have_absolute_namespace_qualified_urls(string $image, string $expected): void
    {
        $this->insight('reward', ['cover_image' => $image]);

        $xml = $this->xml($this->get('https://untrusted.example/sitemaps/insights/1.xml')->assertOk()->getContent());
        $this->assertSame(1, $xml->query('/sm:urlset/sm:url/image:image/image:loc')->length);
        $this->assertSame($expected, $xml->evaluate('string(/sm:urlset/sm:url/image:image/image:loc)'));
        $this->assertSame('https://j-curve.co.kr/insights/reward-article', $xml->evaluate('string(/sm:urlset/sm:url/sm:loc)'));
    }

    public static function coverImages(): array
    {
        return [
            'absolute HTTPS' => ['https://cdn.example/cover.jpg?a=1&b=2', 'https://cdn.example/cover.jpg?a=1&b=2'],
            'absolute HTTP' => ['http://j-curve.co.kr/v1/manager/data/editor/cover.jpg', 'http://j-curve.co.kr/v1/manager/data/editor/cover.jpg'],
            'root relative' => ['/storage/covers/cover.jpg', 'https://j-curve.co.kr/storage/covers/cover.jpg'],
            'relative' => ['storage/covers/cover.jpg', 'https://j-curve.co.kr/storage/covers/cover.jpg'],
            'protocol relative' => ['//cdn.example/cover.jpg', 'https://cdn.example/cover.jpg'],
        ];
    }

    public function test_missing_covers_and_nonpublic_articles_do_not_add_image_tags(): void
    {
        $this->insight('reward');
        $this->insight('draft', ['published_at' => null, 'cover_image' => 'https://cdn.example/draft.jpg']);
        $this->insight('future', ['published_at' => now()->addDay(), 'cover_image' => 'https://cdn.example/future.jpg']);
        $this->insight('hidden', ['slug' => config('seo.hidden_insights')[0], 'cover_image' => 'https://cdn.example/hidden.jpg']);
        $this->insight('noindex', ['cover_image' => 'https://cdn.example/noindex.jpg']);
        SeoMeta::query()->create(['path' => '/insights/noindex-article', 'robots' => 'noindex']);

        $xml = $this->xml($this->get('/sitemaps/insights/1.xml')->assertOk()->getContent());
        $this->assertSame(1, $xml->query('/sm:urlset/sm:url')->length);
        $this->assertSame(0, $xml->query('//image:image')->length);
    }

    public function test_llms_uses_claude_view_and_rss_cache_policy_for_get_and_head(): void
    {
        $rss = $this->get('/rss')->assertOk();
        $response = $this->get('/llms.txt')->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertSee('https://j-curve.co.kr/naver-place-marketing/', false)
            ->assertSee('https://j-curve.co.kr/services/reward-network', false);
        $this->assertSame(view('seo.llms')->render(), $response->getContent());
        $this->assertSame($rss->headers->get('Cache-Control'), $response->headers->get('Cache-Control'));

        $this->head('/llms.txt')->assertOk()->assertContent('')
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertHeader('Cache-Control', $rss->headers->get('Cache-Control'));
    }

    public function test_robots_keeps_all_crawlers_allowed_and_lists_discovery_urls(): void
    {
        $robots = file_get_contents(public_path('robots.txt'));
        $this->assertDoesNotMatchRegularExpression('/^Disallow:[ \t]*\S.*$/m', $robots);
        $this->assertMatchesRegularExpression('/^Disallow:[ \t]*$/m', $robots);
        $this->assertStringContainsString('User-agent: *', $robots);
        foreach (['Googlebot', 'Yeti', 'Daumoa', 'Bingbot', 'GPTBot', 'OAI-SearchBot', 'ChatGPT-User', 'ClaudeBot', 'Claude-SearchBot', 'PerplexityBot', 'Google-Extended'] as $crawler) {
            $this->assertStringContainsString('User-agent: '.$crawler."\n", $robots);
        }
        $this->assertStringContainsString("Allow: /\n", $robots);
        $this->assertStringContainsString('Sitemap: https://j-curve.co.kr/sitemap.xml', $robots);
        $this->assertStringContainsString('# llms: https://j-curve.co.kr/llms.txt', $robots);
    }

    public function test_shopping_page_is_discoverable_through_claude_route(): void
    {
        $this->assertTrue(Route::has('self-marketing.shopping'));
        $this->assertSame('self-marketing/shopping', Route::getRoutes()->getByName('self-marketing.shopping')->uri());
        $this->get('/self-marketing/shopping')->assertOk();
        $this->get('/sitemaps/pages/1.xml')->assertOk()->assertSee('https://j-curve.co.kr/self-marketing/shopping');
    }

    private function insight(string $categorySlug, array $extra = []): Insight
    {
        $category = InsightCategory::query()->firstOrCreate(['slug' => $categorySlug], ['name' => $categorySlug]);

        return Insight::query()->create(array_merge([
            'user_id' => User::factory()->create()->id,
            'category_id' => $category->id,
            'slug' => $categorySlug.'-article',
            'title' => $categorySlug,
            'content' => '<p>공개 인사이트</p>',
            'published_at' => now()->subDay(),
        ], $extra));
    }

    private function xml(string $body): DOMXPath
    {
        $xml = new DOMDocument;
        $this->assertTrue($xml->loadXML($body, LIBXML_NONET));
        $xpath = new DOMXPath($xml);
        $xpath->registerNamespace('sm', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $xpath->registerNamespace('image', 'http://www.google.com/schemas/sitemap-image/1.1');

        return $xpath;
    }
}
