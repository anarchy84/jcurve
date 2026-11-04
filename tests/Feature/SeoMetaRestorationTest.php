<?php

namespace Tests\Feature;

use App\Models\Insight;
use Database\Seeders\InsightCategorySeeder;
use Database\Seeders\LegacyContentSeeder;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SeoMetaRestorationTest extends TestCase
{
    use RefreshDatabase;

    private const PUBLIC_URL = 'https://j-curve.co.kr';

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => self::PUBLIC_URL]);
        $this->seed([InsightCategorySeeder::class, LegacyContentSeeder::class]);
    }

    public static function publicPages(): array
    {
        $expectations = json_decode(file_get_contents(dirname(__DIR__, 2).'/docs/SEO-META-02-TITLES.json'), true, flags: JSON_THROW_ON_ERROR);
        $cases = [];
        foreach ($expectations['pages'] as $path => $page) {
            $cases[$path] = [$path, $page['title'], $page['description']];
        }

        return $cases;
    }

    #[DataProvider('publicPages')]
    public function test_public_metadata_matches_the_authoritative_json(string $path, string $title, string $description): void
    {
        $html = $this->html($this->get(self::PUBLIC_URL.$path)->assertOk()->getContent());
        $this->assertSame(1, $html->query('//head/title')->length);
        $this->assertSame($title, $html->evaluate('string(//head/title)'));
        $this->assertSame(1, $html->query('//head/meta[@name="description"]')->length);
        $expectedDescription = str_starts_with($path, '/seo/') && $path !== '/seo/'
            ? Str::limit(strip_tags($description), 155) : $description;
        $this->assertSame($expectedDescription, $html->evaluate('string(//head/meta[@name="description"]/@content)'));
        $this->assertSame(1, $html->query('//head/meta[@name="robots"]')->length);
        $this->assertSame('index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large', $html->evaluate('string(//head/meta[@name="robots"]/@content)'));

        if ($path === '/') {
            $this->assertStringNotContainsString('퍼포먼스 마케팅 에이전시', $html->evaluate('string(//head/title)'));
        }
    }

    public function test_dev_host_remains_noindex(): void
    {
        foreach (array_keys(self::publicPages()) as $path) {
            $html = $this->html($this->get('https://dev.j-curve.co.kr'.$path)->assertOk()->getContent());
            $this->assertSame(1, $html->query('//head/meta[@name="robots"]')->length);
            $this->assertSame('noindex, nofollow', $html->evaluate('string(//head/meta[@name="robots"]/@content)'));
        }
    }

    public static function wpArticles(): array
    {
        return [
            ['chrome-및-firefox에서-nofollow-링크를-확인하는-방법', '2-633b3300.json'],
            ['11가지-최고의-seo-실수와-이를-피하는-방법', '3-9d3bc3ca.json'],
            ['경쟁자를-압도하는-6가지-고급-링크-구축-전략', '1-c8271513.json'],
        ];
    }

    #[DataProvider('wpArticles')]
    public function test_articles_keep_their_sentences_images_and_links_without_wordpress_widgets(string $slug, string $file): void
    {
        $source = json_decode(file_get_contents(database_path('content/legacy/wp-posts/'.$file)), true, flags: JSON_THROW_ON_ERROR);
        $insight = Insight::query()->where('slug', $slug)->firstOrFail();
        $pureTitle = Str::beforeLast($source['title'], ' - SEO 전문 컨설팅 기업 | 제이커브인터렉티브');
        $this->assertSame($pureTitle, $insight->title);
        $this->assertSame($pureTitle.' - SEO 전문 컨설팅 기업', $insight->meta_title);

        $rendered = $this->html($this->get(self::PUBLIC_URL.'/seo/'.$slug.'/')->assertOk()->getContent());
        $this->assertSame(1, $rendered->query('//h1')->length);
        $this->assertSame($pureTitle, $rendered->evaluate('string(//h1)'));

        $original = $this->html($source['html']);
        $clean = $this->html($insight->getRawOriginal('content'));
        $this->assertSame(0, $clean->query('//h1')->length);
        $this->assertSame(2, $clean->query('//body/*')->length);
        foreach (['fusion-image-element', 'fusion-content-tb'] as $class) {
            $query = '//*[contains(concat(" ", normalize-space(@class), " "), " '.$class.' ")]';
            $this->assertSame(1, $original->query($query)->length);
            $this->assertSame(1, $clean->query($query)->length);
            $before = $original->query($query)->item(0);
            $after = $clean->query($query)->item(0);
            $this->assertSame($before->ownerDocument->saveHTML($before), $after->ownerDocument->saveHTML($after), $class.': article markup, text and all attributes must survive');
        }

        foreach ([$insight->content, $insight->excerpt, $insight->meta_description] as $value) {
            foreach (['SEO Blog', 'SEO에 대한 유용한 정보와 기사', 'Related Posts', 'Search for:', 'Categorys', '마음껏 공유해 가세요~', '← 인사이트 목록', 'jcurve'] as $widget) {
                $this->assertStringNotContainsString($widget, $value);
            }
            $this->assertDoesNotMatchRegularExpression('/\d+월\s+\d+(?:st|nd|rd|th),\s+\d{4}/u', $value);
        }

        $article = $clean->query('//*[contains(concat(" ", normalize-space(@class), " "), " fusion-content-tb ")]')->item(0);
        $firstParagraph = (new DOMXPath($article->ownerDocument))->query('.//p', $article)->item(0);
        $this->assertInstanceOf(DOMElement::class, $firstParagraph);
        $this->assertStringStartsWith(mb_substr(trim($firstParagraph->textContent), 0, 20), $insight->excerpt);
    }

    public function test_reseeding_repairs_existing_wp_rows_and_is_idempotent_without_changing_columns(): void
    {
        $columns = Insight::query()->whereNotNull('legacy_wr_id')->orderBy('id')->get()->map->getRawOriginal()->all();
        $this->assertCount(50, $columns);
        $count = Insight::count();
        foreach (self::wpArticles() as [$slug, $file]) {
            $source = json_decode(file_get_contents(database_path('content/legacy/wp-posts/'.$file)), true, flags: JSON_THROW_ON_ERROR);
            Insight::query()->where('slug', $slug)->update([
                'title' => $source['title'], 'content' => $source['html'],
                'excerpt' => 'SEO BlogSEO에 대한 유용한 정보와 기사',
                'meta_title' => 'stale', 'meta_description' => 'stale',
            ]);
        }

        $seeder = app(LegacyContentSeeder::class);
        $seeder->run();
        $first = Insight::query()->orderBy('id')->get()->map->getRawOriginal()->all();
        $seeder->run();
        $this->assertSame($first, Insight::query()->orderBy('id')->get()->map->getRawOriginal()->all());
        $this->assertSame($columns, Insight::query()->whereNotNull('legacy_wr_id')->orderBy('id')->get()->map->getRawOriginal()->all());
        $this->assertSame($count, Insight::count());

        foreach (self::wpArticles() as [$slug]) {
            $insight = Insight::query()->where('slug', $slug)->firstOrFail();
            $expected = self::publicPages()['/seo/'.$slug.'/'];
            $this->assertSame($expected[1], $insight->meta_title.' | 제이커브인터렉티브');
            $this->assertSame($expected[2], $insight->meta_description);
            $this->assertStringNotContainsString('SEO Blog', $insight->content);
        }
    }

    public static function legacyDiscoveryPaths(): array
    {
        $cases = [];
        foreach (['sitemap_index.xml', 'news-sitemap.xml', 'wp-sitemap.xml', 'post-sitemap.xml', 'page-sitemap.xml', 'product-sitemap.xml', 'avada_portfolio-sitemap.xml', 'category-sitemap.xml'] as $path) {
            $cases[$path] = ['/'.$path, '/sitemap.xml'];
        }
        $cases['feed'] = ['/feed', '/rss'];
        $cases['feed/'] = ['/feed/', '/rss'];

        return $cases;
    }

    #[DataProvider('legacyDiscoveryPaths')]
    public function test_legacy_sitemaps_and_feeds_redirect_once_for_get_and_head(string $path, string $destination): void
    {
        foreach (['GET', 'HEAD'] as $method) {
            $response = $this->call($method, self::PUBLIC_URL.$path)->assertStatus(301);
            $location = $response->headers->get('Location');
            $resolved = str_starts_with($location, '/') ? self::PUBLIC_URL.$location : $location;
            $this->assertSame(self::PUBLIC_URL.$destination, $resolved);
            $this->call($method, $resolved)->assertOk()->assertHeaderMissing('Location');
        }
    }

    public function test_robots_txt_keeps_crawling_allowed_and_advertises_the_current_sitemap(): void
    {
        $robots = file_get_contents(public_path('robots.txt'));
        $this->assertStringStartsWith("User-agent: *\nDisallow:\n", $robots);
        $this->assertDoesNotMatchRegularExpression('/^Disallow:[ \t]*\S.*$/m', $robots);
        $this->assertMatchesRegularExpression('~^Sitemap: https://j-curve\.co\.kr/sitemap\.xml$~m', $robots);
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
