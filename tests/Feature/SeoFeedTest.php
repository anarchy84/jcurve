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
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SeoFeedTest extends TestCase
{
    use RefreshDatabase;

    private User $author;

    private InsightCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => 'https://j-curve.co.kr']);
        $this->travelTo(Carbon::parse('2026-10-27 12:00:00'));
        $this->author = User::factory()->create();
        $this->category = InsightCategory::query()->create(['name' => 'SEO', 'slug' => 'seo']);
    }

    public function test_only_current_public_content_appears_in_sitemaps_and_rss(): void
    {
        $this->insight('공개-한글', ['title' => '검색 & 성장 <기록>']);
        $this->insight('draft', ['published_at' => null]);
        $this->insight('future', ['published_at' => now()->addDay()]);
        $this->insight('hidden');
        $this->insight('duplicate');
        SeoMeta::query()->create(['path' => '/insights/hidden', 'robots' => 'index, noindex, follow']);
        SeoMeta::query()->create(['path' => '/insights/duplicate', 'canonical' => 'https://other.example/article']);
        $this->work('public-work');
        $this->work('draft-work', null);
        $this->work('future-work', now()->addDay());

        $response = $this->get('/sitemaps/insights/1.xml')->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $xml = $this->xml($response->getContent());
        $this->assertSame(1, $xml->query('//*[local-name()="url"]')->length);
        $this->assertSame('https://j-curve.co.kr/insights/'.rawurlencode('공개-한글'), $xml->evaluate('string(//*[local-name()="loc"])'));
        $this->get('/sitemaps/works/1.xml')->assertSee('public-work')->assertDontSee('draft-work')->assertDontSee('future-work');

        $rss = $this->xml($this->get('/rss')->assertOk()->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8')->getContent());
        $this->assertSame(1, $rss->query('//item')->length);
        $this->assertSame('검색 & 성장 <기록>', $rss->evaluate('string(//item/title)'));
        $this->assertSame('초록 & 본문 ]]> 끝', $rss->evaluate('string(//item/description)'));
        $this->assertSame('true', $rss->evaluate('string(//item/guid/@isPermaLink)'));
    }

    public function test_index_is_paginated_and_does_not_trust_request_host(): void
    {
        config(['seo.sitemap_page_size' => 1]);
        $this->insight('one');
        $this->insight('two');
        $index = $this->get('https://untrusted.example/sitemap.xml')->assertOk()->assertDontSee('untrusted.example');
        $xpath = $this->xml($index->getContent());
        $this->assertSame(1, $xpath->query('//*[local-name()="loc" and text()="https://j-curve.co.kr/sitemaps/insights/2.xml"]')->length);
        $this->get('/sitemaps/insights/1.xml')->assertSee('/insights/one')->assertDontSee('/insights/two');
        $this->get('/sitemaps/insights/2.xml')->assertSee('/insights/two')->assertDontSee('/insights/one');
        $this->get('/sitemaps/insights/3.xml')->assertNotFound();
        $this->get('/sitemaps/insights/0.xml')->assertNotFound();
        $this->get('/sitemaps/private/1.xml')->assertNotFound();
        $this->get('/sitemaps/insights/999999999999999999999.xml')->assertNotFound();
    }

    public function test_imported_article_keeps_original_date_and_removal_is_immediate(): void
    {
        $article = $this->insight('legacy', [
            'source_url' => 'https://j-curve.co.kr/seo/legacy/',
            'published_at' => Carbon::parse('2021-03-02'),
        ]);
        $xpath = $this->xml($this->get('/sitemaps/insights/1.xml')->assertOk()->getContent());
        $this->assertStringStartsWith('2021-03-02', $xpath->evaluate('string(//*[local-name()="lastmod"])'));
        $rss = $this->xml($this->get('/rss')->assertOk()->getContent());
        $this->assertSame($article->published_at->toRssString(), $rss->evaluate('string(//item/pubDate)'));
        $article->update(['published_at' => null]);
        $this->get('/rss')->assertDontSee('/insights/legacy');
        $this->get('/sitemaps/insights/1.xml')->assertDontSee('/insights/legacy');
    }

    public function test_rss_limit_and_noindex_category_and_private_routes(): void
    {
        for ($i = 0; $i < 52; $i++) {
            $this->insight('article-'.$i, ['published_at' => now()->subMinutes($i)]);
        }
        SeoMeta::query()->create(['path' => '/company', 'robots' => 'none']);
        SeoMeta::query()->create(['path' => '/insights/category/seo', 'robots' => 'noindex']);
        $onlyDraft = InsightCategory::query()->create(['name' => '未公開', 'slug' => 'only-draft']);
        $this->insight('private-category', ['category_id' => $onlyDraft->id, 'published_at' => null]);
        $pages = $this->get('/sitemaps/pages/1.xml')->assertOk();
        $pages->assertDontSee('/company')->assertDontSee('/category/seo')->assertDontSee('/category/only-draft');
        $pages->assertDontSee('/profile')->assertDontSee('/login')->assertDontSee('/community');
        $rss = $this->xml($this->get('/rss')->assertOk()->getContent());
        $this->assertSame(50, $rss->query('//item')->length);
        $this->assertStringEndsWith('/article-0', $rss->evaluate('string(//item[1]/link)'));
        $this->assertStringEndsWith('/article-49', $rss->evaluate('string(//item[last()]/link)'));
    }

    public function test_invalid_metadata_canonical_does_not_break_other_entries(): void
    {
        $this->insight('bad-canonical');
        $this->insight('good');
        SeoMeta::query()->create(['path' => '/insights/bad-canonical', 'canonical' => '/bad#fragment']);
        $this->get('/rss')->assertOk()->assertSee('/insights/good')->assertDontSee('/insights/bad-canonical');
    }

    public function test_metadata_paths_preserve_encoded_delimiters(): void
    {
        $this->insight('part/section');
        SeoMeta::query()->create(['path' => '/insights/part/section', 'robots' => 'noindex']);
        $this->get('/rss')->assertOk()->assertSee('/insights/part%2Fsection');
    }

    public function test_future_update_timestamp_does_not_invent_a_current_lastmod(): void
    {
        $article = $this->insight('future-update', ['published_at' => now()->subYear()]);
        $article->forceFill(['updated_at' => now()->addDay()])->save();
        $xml = $this->xml($this->get('/sitemaps/insights/1.xml')->assertOk()->getContent());
        $this->assertSame($article->published_at->toAtomString(), $xml->evaluate('string(//*[local-name()="lastmod"])'));
    }

    public function test_existing_public_service_subpages_are_discoverable_and_respect_noindex(): void
    {
        $paths = [
            '/services/seo/backlinks', '/services/cpa-marketing/insurance',
            '/services/performance-marketing/youtube', '/solutions/boostingshop/basic',
        ];
        foreach ($paths as $path) {
            $this->get($path)->assertOk();
        }
        $response = $this->get('/sitemaps/services/1.xml')->assertOk();
        foreach ($paths as $path) {
            $response->assertSee('https://j-curve.co.kr'.$path);
        }
        SeoMeta::query()->create(['path' => $paths[0], 'robots' => 'noindex']);
        $this->get('/sitemaps/services/1.xml')->assertOk()->assertDontSee($paths[0]);
    }

    private function insight(string $slug, array $extra = []): Insight
    {
        return Insight::query()->create(array_merge([
            'user_id' => $this->author->id, 'category_id' => $this->category->id,
            'slug' => $slug, 'title' => $slug, 'content' => '<p>본문</p>',
            'excerpt' => '초록 &amp; <b>본문</b> ]]> 끝'."\x01", 'published_at' => now()->subHour(),
        ], $extra));
    }

    private function work(string $slug, mixed $published = 'now'): void
    {
        Work::query()->create(['slug' => $slug, 'title' => $slug, 'content' => '<p>성과</p>', 'published_at' => $published === 'now' ? now() : $published]);
    }

    private function xml(string $body): DOMXPath
    {
        $xml = new DOMDocument;
        $this->assertTrue($xml->loadXML($body, LIBXML_NONET));

        return new DOMXPath($xml);
    }
}
