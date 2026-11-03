<?php

namespace Tests\Feature;

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Models\Work;
use App\Services\Seo\Publishing\FeedCatalog;
use App\Support\IntlRoutes;
use Database\Seeders\DatabaseSeeder;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\Support\UsesIntlFixture;
use Tests\TestCase;

class IntlPagesTest extends TestCase
{
    use RefreshDatabase;
    use UsesIntlFixture;

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => 'https://j-curve.co.kr']);
        $this->isolateIntlSeeder();
        $this->seed(DatabaseSeeder::class);
        // Every category and a second paginator page are independent of INTL-03 data.
        foreach (['performance-marketing', 'news', 'seo', 'link-building'] as $slug) {
            $category = InsightCategory::query()->firstOrCreate(['slug' => $slug], ['name' => '테스트 분류']);
            for ($index = 0; $index < 13; $index++) {
                $article = Insight::query()->create([
                    'user_id' => Insight::query()->value('user_id'),
                    'category_id' => $category->id, 'title' => '한국어 제목', 'slug' => 'fixture-'.$slug.'-'.$index,
                    'content' => '<p>한국어 본문</p>', 'published_at' => now()->subDay(),
                ]);
                foreach (['en', 'ja'] as $locale) {
                    $article->translations()->create([
                        'locale' => $locale, 'slug' => $locale.'-fixture-'.$slug.'-'.$index,
                        'title' => $locale === 'en' ? 'Marketing in Korea' : '韓国でのマーケティング',
                        'excerpt' => $locale === 'en' ? 'A marketing guide.' : 'マーケティングのご案内です。',
                        'content' => '<h2>Marketing</h2><p>International content.</p>',
                        'source_hash' => hash('sha256', $article->content),
                    ]);
                }
            }
        }
    }

    protected function tearDown(): void
    {
        $this->removeIntlFixture();
        parent::tearDown();
    }

    private function paths(string $locale): array
    {
        $paths = array_map(fn ($variant) => route($locale.'.'.$variant['name'], $variant['parameters'], false), IntlRoutes::variants());
        foreach (['performance-marketing', 'news', 'seo', 'link-building'] as $slug) {
            $paths[] = route($locale.'.insights.category', ['slug' => $slug], false);
            $paths[] = route($locale.'.insights.show', ['slug' => $locale.'-fixture-'.$slug.'-0'], false);
        }

        return $paths;
    }

    private function document(string $html): DOMXPath
    {
        $document = new DOMDocument;
        @$document->loadHTML('<?xml encoding="UTF-8">'.$html);

        return new DOMXPath($document);
    }

    public function test_every_page_has_localized_text_canonical_and_reciprocal_alternates(): void
    {
        foreach (['en', 'ja'] as $locale) {
            foreach ($this->paths($locale) as $path) {
                $this->assertLocalizedPage($locale, $path);
            }
        }
    }

    private function assertLocalizedPage(string $locale, string $path): void
    {
        $response = $this->get($path);
        $this->assertSame(200, $response->status(), $path);
        $html = $response->getContent();
        $dom = $this->document($html);
        $this->assertSame($locale, $dom->evaluate('string(/html/@lang)'), $path);
        $this->assertSame('https://j-curve.co.kr'.$path, $dom->evaluate('string(//link[@rel="canonical"]/@href)'), $path);
        foreach (['ko', 'en', 'ja', 'x-default'] as $alternate) {
            $this->assertSame(1, $dom->query('//link[@rel="alternate" and @hreflang="'.$alternate.'"]')->length, $path.' '.$alternate);
        }
        foreach ($dom->query('//script[@type="application/ld+json"]') as $script) {
            $schema = json_decode($script->textContent, true, 512, JSON_THROW_ON_ERROR);
            $this->assertSame('https://schema.org', $schema['@context'], $path);
            $this->assertSame($locale, $schema['inLanguage'], $path);
        }
        $body = $dom->query('//body')->item(0);
        foreach ($dom->query('//script|//style') as $node) {
            $node->parentNode->removeChild($node);
        }
        $text = $body->textContent;
        $this->assertSame(0, preg_match('/[\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}]+/u', $text, $matches), $path.' Hangul: '.($matches[0] ?? ''));
        $this->assertSame(0, preg_match('~(?:pages/|menu\.|subpages\.|insights\.categories\.)[\w./-]*~', $text, $matches), $path.' Translation key: '.($matches[0] ?? ''));
        $this->assertStringNotContainsString('data-count-to=', $html, $path);
    }

    public function test_all_internal_page_links_resolve_and_excluded_areas_are_not_linked(): void
    {
        $links = [];
        foreach (['en', 'ja'] as $locale) {
            foreach ($this->paths($locale) as $path) {
                $response = $this->get($path);
                $this->assertSame(200, $response->status(), $path);
                $dom = $this->document($response->getContent());
                foreach ($dom->query('//a[@href]') as $anchor) {
                    $href = html_entity_decode($anchor->getAttribute('href'));
                    if ($href === '' || str_starts_with($href, '#') || preg_match('~^(?:mailto:|tel:|javascript:)~', $href)) {
                        continue;
                    }
                    $host = parse_url($href, PHP_URL_HOST);
                    if ($host !== null && ! in_array($host, ['localhost', 'j-curve.co.kr'], true)) {
                        continue;
                    }
                    $target = preg_replace('~^https?://[^/]+~', '', $href);
                    $target = explode('#', $target)[0];
                    $this->assertDoesNotMatchRegularExpression('~/(?:login|register|dashboard|community|seo-check|support/inquiries|self-marketing/order)(?:[/?]|$)~', $target, $path);
                    $links[$target] = true;
                }
            }
        }
        foreach (array_keys($links) as $target) {
            $response = $this->get($target);
            if ($response->status() === 301) {
                $response = $this->get($response->headers->get('Location'));
            }
            $this->assertSame(200, $response->status(), $target);
        }
    }

    public function test_missing_view_is_excluded_from_rendering_alternates_and_sitemap(): void
    {
        $factory = View::getFacadeRoot();
        $mock = \Mockery::mock($factory);
        $mock->shouldReceive('exists')->andReturnUsing(fn ($name) => $name !== 'intl.services.seo' && $factory->exists($name));
        View::swap($mock);
        $html = $this->get('/seo/')->assertOk()->getContent();
        $this->assertSame(0, $this->document($html)->query('//link[@rel="alternate" and @hreflang]')->length, 'Missing foreign view must suppress hreflang');
        $this->get('/en/seo/')->assertNotFound();
        $this->get('/ja/seo/')->assertNotFound();
        $urls = collect(app(FeedCatalog::class)->sections())->flatten(1)->pluck('url');
        $this->assertContains('https://j-curve.co.kr/seo/', $urls);
        $this->assertNotContains('https://j-curve.co.kr/en/seo/', $urls);
        $this->assertNotContains('https://j-curve.co.kr/ja/seo/', $urls);
    }

    public function test_translated_pagination_and_article_rendering_use_locale_data(): void
    {
        foreach (['en', 'ja'] as $locale) {
            $this->assertLocalizedPage($locale, '/'.$locale.'/blog/');
            $path = route($locale.'.insights.category', ['slug' => 'seo'], false);
            $response = $this->get($path.'?page=2')->assertOk();
            $this->assertCount(1, $response->viewData('insights'));
            $response->assertSee($locale.'-fixture-seo-0')->assertDontSee('한국어 제목');
            $dom = $this->document($response->getContent());
            $this->assertSame('http://localhost'.$path.'?page=1', $dom->evaluate('string(//a[@rel="prev"]/@href)'));
            $this->get('/'.$locale.'/insights/'.$locale.'-fixture-seo-0')->assertOk()
                ->assertSee('<h2>Marketing</h2><p>International content.</p>', false)
                ->assertDontSee('한국어 본문')->assertDontSee('한국어 제목');
            $this->get('/'.$locale.'/work')->assertOk()
                ->assertSee($locale === 'en' ? 'No individual cases are currently approved for publication' : '現在、公開承認済みの個別事例はありません');
        }
        Work::query()->create(['title' => '한국어 사례', 'slug' => 'korean-only-case', 'content' => '한국어 사례 본문', 'published_at' => now()->subDay()]);
        foreach (['en', 'ja'] as $locale) {
            $this->assertLocalizedPage($locale, '/'.$locale.'/work');
            $this->get('/'.$locale.'/work')->assertDontSee('korean-only-case');
        }
    }

    public function test_missing_locale_subpage_does_not_fall_back_to_english(): void
    {
        app('translator')->setLoaded(['*' => ['subpages' => ['ja' => []]]]);
        $this->assertFalse(IntlRoutes::available('services.seo.sub', ['sub' => 'backlinks'], 'ja'));
        $this->get('/ja/seo-backlinks/')->assertNotFound();
        $this->get('/seo-backlinks/')->assertOk()->assertDontSee('<link rel="alternate" hreflang="ja"', false);
        $urls = collect(app(FeedCatalog::class)->sections())->flatten(1)->pluck('url');
        $this->assertNotContains('https://j-curve.co.kr/ja/seo-backlinks/', $urls);
    }

    public function test_excluded_korean_routes_have_no_alternate_link_tags(): void
    {
        foreach (['/login', '/register', '/community', '/self-marketing/order', '/seo-check', '/dashboard'] as $path) {
            $this->get($path)->assertDontSee('<link rel="alternate" hreflang=', false);
        }
    }

    public function test_language_files_have_identical_keys_and_faq_contains_all_81_items(): void
    {
        $keys = function (array $value, string $prefix = '') use (&$keys): array {
            $result = [];
            foreach ($value as $key => $item) {
                $path = $prefix.'.'.$key;
                $result[] = $path;
                if (is_array($item)) {
                    $result = [...$result, ...$keys($item, $path)];
                }
            }

            return $result;
        };
        foreach (glob(lang_path('en/pages/*.php')) as $file) {
            $this->assertSame($keys(require $file), $keys(require str_replace('/en/', '/ja/', $file)), basename($file));
        }
        $this->assertSame($keys(require lang_path('en/subpages.php')), $keys(require lang_path('ja/subpages.php')));
        foreach (['en', 'ja'] as $locale) {
            $html = $this->get('/'.$locale.'/support/faq')->assertOk()->getContent();
            $this->assertSame(81, $this->document($html)->query('//main//details')->length);
        }
    }
}
