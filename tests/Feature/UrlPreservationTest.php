<?php

namespace Tests\Feature;

use App\Http\Middleware\PreservePublicUrls;
use App\Models\Insight;
use App\Models\LegacyRedirect;
use App\Services\Seo\Publishing\PublicUrl;
use App\Services\Seo\Publishing\UrlAuditManifest;
use Database\Seeders\InsightCategorySeeder;
use Database\Seeders\LegacyContentSeeder;
use Database\Seeders\LegacyRedirectSeeder;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Spatie\Honeypot\EncryptedTime;
use Spatie\Honeypot\ProtectAgainstSpam;
use Tests\TestCase;

class UrlPreservationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => 'https://j-curve.co.kr']);
        $this->seed([InsightCategorySeeder::class, LegacyRedirectSeeder::class, LegacyContentSeeder::class]);
    }

    public static function preservedPages(): array
    {
        return [
            ['/about-us/', '/company'],
            ['/contact-us/', '/contact'],
            ['/blog/', '/insights'],
            ['/blog/seo/', '/insights/category/seo'],
            ['/blog/link-building/', '/insights/category/link-building'],
            ['/seo/', '/services/seo'],
            ['/seo-backlinks/', '/services/seo/backlinks'],
            ['/wordpress-agency/', '/services/wordpress'],
            ['/naver-place-marketing/', '/services/seo/naver-place'],
            ['/naver-shopping-marketing/', '/services/seo/naver-shopping'],
            ['/kakao-gift/', '/services/seo/kakao-gift'],
            ['/coupang/', '/services/seo/coupang'],
            ['/seo/chrome-및-firefox에서-nofollow-링크를-확인하는-방법/', '/insights/chrome-및-firefox에서-nofollow-링크를-확인하는-방법'],
            ['/seo/11가지-최고의-seo-실수와-이를-피하는-방법/', '/insights/11가지-최고의-seo-실수와-이를-피하는-방법'],
            ['/seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략/', '/insights/경쟁자를-압도하는-6가지-고급-링크-구축-전략'],
        ];
    }

    #[DataProvider('preservedPages')]
    public function test_preserved_page_renders_original_content_canonical_and_single_hop_aliases(string $preserved, string $modern): void
    {
        $response = $this->get($preserved)->assertOk();
        $xpath = $this->html($response->getContent());
        $canonical = 'https://j-curve.co.kr'.$preserved;
        $this->assertSame($canonical, $xpath->evaluate('string(//link[@rel="canonical"]/@href)'));
        $this->assertSame($canonical, $xpath->evaluate('string(//meta[@property="og:url"]/@content)'));

        $this->withoutMiddleware(PreservePublicUrls::class);
        $original = $this->get($modern)->assertOk();
        $this->withMiddleware(PreservePublicUrls::class);
        $originalHtml = $this->html($original->getContent());
        foreach (['string(//title)', 'string(//meta[@name="description"]/@content)', 'normalize-space(//main)'] as $query) {
            $this->assertSame($originalHtml->evaluate($query), $xpath->evaluate($query), $query);
        }
        $this->assertNotSame('', $xpath->evaluate('normalize-space(//main)'));

        foreach ([rtrim($preserved, '/'), $modern] as $alias) {
            $redirect = $this->get($alias.'?utm_source=a%2Fb&x=1&x=2')->assertStatus(301);
            $this->assertTrue(PublicUrl::equivalent($redirect->headers->get('Location'), 'http://localhost'.$preserved.'?utm_source=a%2Fb&x=1&x=2'));
            $this->get($redirect->headers->get('Location'))->assertOk();
        }
        $this->get($preserved.'?page=2')->assertOk();
        $this->head($preserved)->assertOk();
        $this->head($modern)->assertStatus(301);
    }

    public function test_percent_encoded_article_paths_in_both_hex_cases_render_and_normalize(): void
    {
        foreach (array_slice(self::preservedPages(), 12) as [$preserved, $modern]) {
            $encoded = implode('/', array_map('rawurlencode', explode('/', $preserved)));
            foreach ([$encoded, preg_replace_callback('/%[A-F0-9]{2}/', fn ($m) => strtolower($m[0]), $encoded)] as $path) {
                $this->get($path)->assertOk()->assertSee('https://j-curve.co.kr'.$preserved, false);
                $redirect = $this->get(rtrim($path, '/'))->assertStatus(301);
                $this->get($redirect->headers->get('Location'))->assertOk();
            }
            $this->get(implode('/', array_map('rawurlencode', explode('/', $modern))))->assertStatus(301);
        }
    }

    public function test_generated_urls_cover_parameters_queries_fragments_and_relative_routes(): void
    {
        $this->assertSame('http://localhost/about-us/', route('company'));
        $this->assertSame('/contact-us/', route('contact', [], false));
        $this->assertSame('http://localhost/seo-backlinks/', route('services.seo.sub', ['sub' => 'backlinks']));
        $this->assertSame('http://localhost/blog/seo/?page=2', route('insights.category', ['slug' => 'seo', 'page' => 2]));
        $this->assertSame('http://localhost/contact-us/?a=1#form', url('/contact?a=1#form'));
        $this->assertSame('http://localhost/contact-us/#form', url('/contact#form'));
        $this->assertSame('http://localhost/services/seo/aeo', route('services.seo.aeo'));
    }

    public function test_canonical_override_cannot_replace_preserved_canonical(): void
    {
        // Render within a preserved request, even with an explicit page section.
        $this->app['view']->composer('partials.jc.head', function ($view) {
            $view->getFactory()->startSection('canonical', 'https://j-curve.co.kr/company');
        });
        $this->get('/about-us/')->assertOk()->assertSee('rel="canonical" href="https://j-curve.co.kr/about-us/"', false);
    }

    public function test_rendered_internal_hrefs_and_structured_data_do_not_point_to_modern_aliases(): void
    {
        foreach (['/', '/about-us/', '/contact-us/', '/blog/', '/seo/', self::preservedPages()[12][0]] as $page) {
            $html = $this->get($page)->assertOk()->getContent();
            $xpath = $this->html($html);
            foreach ($xpath->query('//@href | //form/@action') as $attribute) {
                $path = parse_url($attribute->nodeValue, PHP_URL_PATH) ?: '/';
                foreach (self::preservedPages() as [, $modern]) {
                    $this->assertNotSame($modern, PublicUrl::comparisonKey(rtrim($path, '/')), $page.' -> '.$attribute->nodeValue);
                }
            }
            foreach ($xpath->query('//script[@type="application/ld+json"]') as $script) {
                $json = json_decode($script->textContent, true, 512, JSON_THROW_ON_ERROR);
                $this->assertIsArray($json);
                array_walk_recursive($json, function ($value) use ($page) {
                    if (! is_string($value) || ! str_starts_with($value, 'http')) {
                        return;
                    }
                    $path = parse_url($value, PHP_URL_PATH) ?: '/';
                    foreach (self::preservedPages() as [, $modern]) {
                        $this->assertNotSame($modern, PublicUrl::comparisonKey(rtrim($path, '/')), $page.' JSON-LD -> '.$value);
                    }
                });
            }
        }
    }

    public function test_contact_success_validation_honeypot_and_throttle_use_preserved_form(): void
    {
        $html = $this->html($this->get('/contact-us/')->assertOk()->getContent());
        $this->assertSame('http://localhost/contact-us/', $html->evaluate('string(//form[@method="POST"]/@action)'));
        $route = Route::getRoutes()->match(Request::create('/contact-us/', 'POST'));
        $this->assertContains(ProtectAgainstSpam::class, $route->gatherMiddleware());
        $this->assertContains('throttle:5,1', $route->gatherMiddleware());
        $this->assertContains('web', $route->gatherMiddleware());
        config(['honeypot.randomize_name_field_name' => false]);
        $fields = [
            'name' => 'URL 보존 검증', 'email' => 'url-preserve@example.com',
            'service_interest' => 'seo', 'message' => '보존 주소 폼 접수 확인',
            'my_name' => '', 'valid_from' => (string) EncryptedTime::create(now()->subSeconds(3)),
        ];
        $this->post('/contact-us/', $fields)->assertRedirect('http://localhost/contact-us/')->assertSessionHas('status', 'inquiry-received');
        $this->assertDatabaseHas('leads', ['email' => 'url-preserve@example.com']);
        $this->get('/contact-us/')->assertOk()->assertSee('문의가 접수');
        $this->from('/contact-us/')->post('/contact-us/', array_replace($fields, ['email' => 'invalid']))
            ->assertRedirect('http://localhost/contact-us/')->assertSessionHasErrors('email');
        $this->get('/contact-us/')->assertOk()->assertSee('invalid');
        $this->post('/contact-us/', array_replace($fields, ['my_name' => 'bot']))->assertOk();
        $this->assertDatabaseCount('leads', 1);
        for ($i = 0; $i < 5; $i++) {
            $this->post('/contact-us/', $fields);
        }
        $this->post('/contact-us/', $fields)->assertStatus(429);
    }

    public function test_sitemaps_rss_pagination_and_preservation_audit_use_original_paths(): void
    {
        $xml = '';
        foreach (['pages', 'services', 'insights'] as $section) {
            $xml .= $this->get('/sitemaps/'.$section.'/1.xml')->assertOk()->getContent();
        }
        foreach (self::preservedPages() as [$preserved, $modern]) {
            $this->assertStringContainsString('https://j-curve.co.kr'.$preserved, rawurldecode($xml));
            $this->assertStringNotContainsString('https://j-curve.co.kr'.$modern.'<', rawurldecode($xml));
        }
        $rss = rawurldecode($this->get('/rss')->assertOk()->getContent());
        foreach (array_slice(self::preservedPages(), 12) as [$preserved, $modern]) {
            $this->assertStringContainsString('https://j-curve.co.kr'.$preserved, $rss);
            $this->assertStringNotContainsString('https://j-curve.co.kr'.$modern, $rss);
        }
        $page = $this->get('/blog/?page=2')->assertOk();
        $this->assertSame(2, $page->viewData('insights')->currentPage());
        $this->assertStringContainsString('/blog/?page=', $page->getContent());
        $this->assertSame(16, count(config('seo.preserved_paths')));
        $this->assertNotContains('/shop/', config('seo.preserved_paths'));
        $entries = app(UrlAuditManifest::class)->load();
        $this->assertSame(66, count($entries));
        foreach (config('seo.preserved_paths') as $path) {
            $this->assertSame(200, collect($entries)->firstWhere('path', $path)['status']);
        }
    }

    public function test_legacy_chains_new_redirects_and_every_v1_landing_are_one_hop(): void
    {
        $map = [
            '/v1/company.php' => '/about-us/', '/contact.php' => '/contact-us/', '/v1/contact.php' => '/contact-us/',
            '/shopping_marketing.php' => '/naver-shopping-marketing/', '/shopping_smartstore.php' => '/naver-shopping-marketing/',
            '/company/anarchy' => '/about-us/', '/v1/gfa.php' => '/services/performance-marketing/naver-gfa',
            '/v1/youtube.php' => '/services/performance-marketing/youtube',
            '/v1/manager/bbs/board.php?bo_table=column' => '/blog/',
            '/v1/manager/bbs/board.php?wr_id=&bo_table=column' => '/blog/',
            '/v1/manager/bbs/board.php?BO_TABLE=COLUMN&WR_ID=' => '/blog/',
        ];
        foreach (LegacyRedirect::query()->where('from_path', 'not like', '%/%')->where('from_path', 'like', '%.php')->get() as $landing) {
            $map['/v1/'.$landing->from_path] = $landing->to_path;
        }
        foreach ($map as $from => $to) {
            $response = $this->get($from)->assertStatus(301);
            $location = $response->headers->get('Location');
            $this->assertSame('http://localhost'.$to, str_starts_with($location, '/') ? 'http://localhost'.$location : $location);
            $this->get($location)->assertOk();
        }
    }

    public function test_all_thirty_missing_columns_are_gone_with_case_and_query_order_independent_keys(): void
    {
        foreach ([19, 21, 29, 38, 47, 52, 56, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80] as $id) {
            foreach (['?bo_table=column&wr_id='.$id, '?page=2&WR_ID='.$id.'&BO_TABLE=COLUMN'] as $query) {
                $response = $this->get('/v1/manager/bbs/board.php'.$query)->assertStatus(410)
                    ->assertSee('삭제된 글이에요')->assertSee('name="robots" content="noindex"', false)->assertHeaderMissing('Location');
                $this->assertStringContainsString('href="http://localhost/blog/"', $response->getContent());
            }
        }
    }

    public function test_live_column_and_dummy_redirects_remain_unchanged(): void
    {
        foreach (Insight::query()->whereNotNull('legacy_wr_id')->get() as $insight) {
            $to = $insight->legacy_wr_id === 51 ? '/blog/' : '/insights/'.$insight->slug;
            $response = $this->get('/v1/manager/bbs/board.php?bo_table=column&wr_id='.$insight->legacy_wr_id)->assertStatus(301);
            $this->assertTrue(PublicUrl::equivalent($response->headers->get('Location'), 'http://localhost'.$to));
            $this->assertSame(1, preg_match('/^[\x20-\x7e]+$/', $response->headers->get('Location')));
        }
        foreach (LegacyRedirect::query()->where('from_path', 'like', 'portfolio-items%')->get() as $redirect) {
            $this->get('/'.$redirect->from_path)->assertStatus(301)->assertHeader('Location', 'http://localhost/work');
        }
        $this->get('/shop/')->assertStatus(301)->assertHeader('Location', 'http://localhost/solutions/boostingshop');
    }

    public function test_hidden_insight_is_reversible_and_absent_from_all_public_collections(): void
    {
        $slug = '온라인-마케팅-제대로-배울-수-있는-아나키-강의';
        $insight = Insight::query()->where('slug', $slug)->firstOrFail();
        $this->assertNotNull($insight->published_at);
        $this->get('/insights/'.$slug)->assertStatus(302)->assertHeader('Location', 'http://localhost/blog/');
        $this->get('/v1/manager/bbs/board.php?bo_table=column&wr_id=51')->assertStatus(301)->assertHeader('Location', 'http://localhost/blog/');
        foreach (['/', '/blog/', '/blog/seo/', '/rss', '/sitemaps/insights/1.xml'] as $path) {
            $this->get($path)->assertOk()->assertDontSee($slug);
        }
        $this->assertFalse(Insight::query()->published()->whereKey($insight->id)->exists());
        config(['seo.hidden_insights' => []]);
        $this->get('/insights/'.$slug)->assertOk();
        $this->assertTrue(Insight::query()->published()->whereKey($insight->id)->exists());
    }

    public function test_only_two_introduction_sentences_are_hidden_without_changing_raw_content(): void
    {
        foreach (['스마트스토어-검색광고가-꼭-필요할까', '스마트스토어-내게-맞는-키워드-발굴하는-법'] as $slug) {
            $insight = Insight::query()->where('slug', $slug)->firstOrFail();
            $raw = $insight->getRawOriginal('content');
            $this->assertStringContainsString('초짜 셀러 아나키입니다.', $raw);
            $this->assertStringNotContainsString('초짜 셀러 아나키입니다.', $insight->content);
            $this->assertSame(1, preg_match_all('/(?:안녕하십니까|안녕하세요)\. 마케팅 비전공자이자 10년차 광고대행사 마케터로 생활하고 있는 초짜 셀러 아나키입니다\./u', $raw));
            $expected = preg_replace('/(?:안녕하십니까|안녕하세요)\. 마케팅 비전공자이자 10년차 광고대행사 마케터로 생활하고 있는 초짜 셀러 아나키입니다\./u', '', $raw);
            $this->assertSame($expected, $insight->content);
            $this->get('/insights/'.$slug)->assertOk()->assertSee($insight->title)->assertDontSee('초짜 셀러 아나키입니다.');
            $this->assertSame($raw, $insight->fresh()->getRawOriginal('content'));
        }
    }

    public function test_seeders_are_idempotent_and_upgrade_stale_rows(): void
    {
        $counts = [Insight::count(), LegacyRedirect::count()];
        LegacyRedirect::query()->updateOrCreate(['from_path' => 'v1/company.php'], ['to_path' => '/company', 'status_code' => 301]);
        LegacyRedirect::query()->create(['from_path' => 'seo/경쟁자를-압도하는-6가지-고급-링크-구축-전략', 'to_path' => '/insights/경쟁자를-압도하는-6가지-고급-링크-구축-전략', 'status_code' => 301]);
        foreach ([1, 2] as $run) {
            $this->seed([LegacyRedirectSeeder::class, LegacyContentSeeder::class]);
            $this->assertSame($counts, [Insight::count(), LegacyRedirect::count()]);
            $this->assertDatabaseHas('legacy_redirects', ['from_path' => 'v1/company.php', 'to_path' => '/about-us/']);
        }
        // Reusing the exact seeder instance must not append -2 to every slug.
        $seeder = app(LegacyContentSeeder::class);
        $seeder->run();
        $seeder->run();
        $this->assertSame($counts, [Insight::count(), LegacyRedirect::count()]);
    }

    public function test_unmapped_paths_and_unknown_seo_slugs_keep_their_behaviour(): void
    {
        foreach (['/services/seo/aeo', '/services/seo/geo', '/services/cpa-marketing', '/insights/category/news', '/insights/스마트스토어-검색광고가-꼭-필요할까'] as $path) {
            $this->get($path)->assertOk();
        }
        $this->get('/seo/not-an-article/')->assertNotFound();
        $this->get('/seo%2Fnot-an-article/')->assertNotFound();
        LegacyRedirect::query()->create(['from_path' => 'seo/old-hook', 'to_path' => '/work', 'status_code' => 301]);
        $this->get('/seo/old-hook/')->assertStatus(301)->assertHeader('Location', 'http://localhost/work');
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
