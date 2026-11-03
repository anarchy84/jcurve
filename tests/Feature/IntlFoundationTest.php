<?php

namespace Tests\Feature;

use App\Models\Insight;
use App\Models\InsightTranslation;
use App\Models\Lead;
use App\Models\LegacyRedirect;
use App\Models\SeoMeta;
use App\Services\Seo\Publishing\FeedCatalog;
use App\Services\Seo\Publishing\PreservedPaths;
use App\Support\IntlRoutes;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\IntlInsightSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Spatie\Honeypot\EncryptedTime;
use Spatie\Honeypot\ProtectAgainstSpam;
use Tests\TestCase;

class IntlFoundationTest extends TestCase
{
    use RefreshDatabase;

    private array $temporaryDirectories = [];

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => 'https://j-curve.co.kr', 'honeypot.randomize_name_field_name' => false]);
        $this->seed(DatabaseSeeder::class);
    }

    protected function tearDown(): void
    {
        foreach ($this->temporaryDirectories as $directory) {
            File::deleteDirectory($directory);
        }
        parent::tearDown();
    }

    private function sample(): Insight
    {
        return Insight::query()->whereHas('translations')->with('translations')->firstOrFail();
    }

    private function translatedView(string $name, string $content = 'translated test view'): void
    {
        $directory = sys_get_temp_dir().'/intl-view-'.bin2hex(random_bytes(8));
        $this->temporaryDirectories[] = $directory;
        $file = $directory.'/intl/'.str_replace('.', '/', $name).'.blade.php';
        File::ensureDirectoryExists(dirname($file));
        File::put($file, $content);
        View::getFinder()->prependLocation($directory);
        View::getFinder()->flush();
    }

    private function staticStatus(array $variant): int
    {
        $views = [
            'home' => 'pages.home', 'company' => 'pages.company', 'contact' => 'contact',
            'privacy' => 'pages.privacy', 'support.faq' => 'pages.faq',
            'services.marketing-support' => 'pages.marketing-support',
            'self-marketing' => 'pages.self-marketing', 'self-marketing.place' => 'pages.self-marketing-place',
        ];
        $name = $variant['name'];
        $view = $views[$name] ?? $name;
        if ($name === 'services.show') {
            $view = 'services.'.$variant['parameters']['slug'];
        } elseif (isset(config('intl.subpages')[$name])) {
            $view = 'pages.subpage';
        }

        return View::exists('intl.'.$view) ? 200 : 404;
    }

    public function test_foreign_route_collection_compiles_without_duplicate_alias_names(): void
    {
        $compiled = Route::getRoutes()->compile();
        $this->assertArrayHasKey('en.home', $compiled['attributes']);
        $this->assertArrayHasKey('ja.contact.store', $compiled['attributes']);
    }

    public function test_all_static_targets_have_foreign_routes_and_missing_views_return_404(): void
    {
        foreach (config('intl.routes') as $name) {
            $this->assertTrue(Route::has($name), $name);
            foreach (['en', 'ja'] as $locale) {
                $this->assertTrue(Route::has($locale.'.'.$name), $locale.'.'.$name);
            }
        }
        foreach (['en', 'ja'] as $locale) {
            foreach (IntlRoutes::variants() as $variant) {
                $path = route($locale.'.'.$variant['name'], $variant['parameters'], false);
                $response = $this->get($path);
                $response->assertStatus($this->staticStatus($variant));
            }
            $this->get('/'.$locale.'/')->assertSee('lang="'.$locale.'"', false)
                ->assertSee('href="https://j-curve.co.kr/'.$locale.'/"', false)
                ->assertSee('hreflang="x-default"', false)
                ->assertSee('content="'.config('intl.locales.'.$locale.'.og_locale').'"', false)
                ->assertDontSee('pages/home.title');
        }
    }

    public function test_all_foreign_aliases_redirect_once_preserving_raw_queries(): void
    {
        foreach (['en', 'ja'] as $locale) {
            foreach (IntlRoutes::variants() as $variant) {
                $canonical = route($locale.'.'.$variant['name'], $variant['parameters'], false);
                $modern = '/'.$locale.($variant['path'] === '/' ? '' : $variant['path']);
                $slashVariant = str_ends_with($canonical, '/') ? rtrim($canonical, '/') : $canonical.'/';
                foreach (array_unique([$modern, $slashVariant]) as $alias) {
                    if ($alias === $canonical) {
                        continue;
                    }
                    $response = $this->get($alias.'?utm_source=a%2Fb&x=1&x=2')->assertStatus(301);
                    $this->assertSame('http://localhost'.$canonical.'?utm_source=a%2Fb&x=1&x=2', $response->headers->get('Location'));
                    $this->get($response->headers->get('Location'))->assertStatus($this->staticStatus($variant))->assertHeaderMissing('Location');
                    $this->head($alias)->assertStatus(301);
                }
            }
        }
    }

    public function test_excluded_foreign_paths_are_404_without_redirects(): void
    {
        foreach (['en', 'ja'] as $locale) {
            foreach (['community', 'login', 'register', 'dashboard', 'profile', 'self-marketing/order', 'self-marketing/orders', 'seo-check', 'support/inquiries', 'work/example'] as $path) {
                $this->get('/'.$locale.'/'.$path)->assertNotFound()->assertHeaderMissing('Location');
            }
            foreach (config('seo.preserved_paths') as $path) {
                if (str_starts_with($path, '/seo/') && $path !== '/seo/') {
                    $this->get('/'.$locale.$path)->assertNotFound()->assertHeaderMissing('Location');
                }
            }
        }
    }

    public function test_legacy_landing_aliases_are_single_hop_but_excluded_destinations_have_no_foreign_redirect(): void
    {
        foreach (['en', 'ja'] as $locale) {
            foreach (['/v1/company.php' => '/about-us/', '/company/anarchy' => '/about-us/', '/shop/' => '/solutions/boostingshop', '/v1/gfa.php' => '/services/performance-marketing/naver-gfa'] as $alias => $canonical) {
                $this->get('/'.$locale.$alias.'?utm_source=a%2Fb&x=1&x=2')->assertStatus(301)
                    ->assertRedirect('http://localhost/'.$locale.$canonical.'?utm_source=a%2Fb&x=1&x=2');
                $this->get('/'.$locale.$canonical)->assertNotFound()->assertHeaderMissing('Location');
            }
            $this->get('/'.$locale.'/my-account/')->assertNotFound()->assertHeaderMissing('Location');
            $this->get('/'.$locale.'/v1/manager/bbs/board.php?bo_table=column&wr_id=51')->assertNotFound()->assertHeaderMissing('Location');
            $this->get('/'.$locale.'/v1/manager/column/온라인-마케팅-제대로-배울-수-있는-아나키-강의')->assertNotFound()->assertHeaderMissing('Location');
        }
        $this->get('/en/v1/manager/bbs/board.php?bo_table=column&wr_id=1&utm_source=a%2Fb')->assertStatus(301)
            ->assertRedirect('http://localhost/en/insights/mobile-marketing-strategies?bo_table=column&wr_id=1&utm_source=a%2Fb');
        $article = $this->sample()->replicate();
        $article->slug = 'untranslated-source';
        $article->legacy_wr_id = null;
        $article->save();
        LegacyRedirect::query()->create(['from_path' => 'legacy-ascii.php', 'to_path' => '/insights/untranslated-source', 'status_code' => 301]);
        $this->get('/en/legacy-ascii.php')->assertNotFound()->assertHeaderMissing('Location');
    }

    public function test_url_helpers_preserve_addresses_and_use_public_origin_for_alternates(): void
    {
        $this->assertSame('http://localhost/en/about-us/', route('en.company'));
        $this->assertSame('http://localhost/ja/seo-backlinks/', route('ja.services.seo.sub', ['sub' => 'backlinks']));
        $this->assertSame('http://localhost/en/blog/seo/?page=2', route('en.insights.category', ['slug' => 'seo', 'page' => 2]));
        $this->assertSame('http://localhost/en/insights/mobile-marketing-strategies', route('en.insights.show', ['slug' => 'mobile-marketing-strategies']));
        $this->assertSame('http://localhost/about-us/', intl_route('company', [], 'ko'));
        $this->assertSame('http://localhost/en/about-us/', intl_route('company', [], 'en'));
        $this->translatedView('pages.company', '{{ json_encode(intl_alternates()) }}');
        $this->get('/en/about-us/')->assertOk()->assertSee('https:\/\/j-curve.co.kr\/en\/about-us\/', false);
        $this->get('/ja/')->assertOk();
        $this->get('/')->assertOk()->assertDontSee('hreflang=');
    }

    public function test_adding_a_view_enables_its_existing_controller_without_route_changes(): void
    {
        $this->get('/en/about-us/')->assertStatus(View::exists('intl.pages.company') ? 200 : 404);
        $this->translatedView('pages.company', '{{ intl_locale() }} company');
        $this->get('/en/about-us/')->assertOk()->assertSee('en company');
        $this->get('/ja/about-us/')->assertOk()->assertSee('ja company');
    }

    public function test_korean_preserved_routes_expose_alternates_without_modifying_korean_views(): void
    {
        $alternates = [];
        View::composer('pages.company', function () use (&$alternates) {
            $alternates = intl_alternates();
        });
        $this->get('/about-us/')->assertOk();
        $this->assertSame([
            'ko' => 'https://j-curve.co.kr/about-us/',
            'en' => 'https://j-curve.co.kr/en/about-us/',
            'ja' => 'https://j-curve.co.kr/ja/about-us/',
        ], $alternates);
        $article = Insight::query()->published()->where('slug', 'chrome-및-firefox에서-nofollow-링크를-확인하는-방법')->firstOrFail();
        $article->translations()->create([
            'locale' => 'en', 'slug' => 'check-nofollow-links', 'title' => 'Check nofollow links',
            'content' => '<p>Translated article</p>', 'source_hash' => hash('sha256', $article->content),
        ]);
        View::composer('insights.show', function () use (&$alternates) {
            $alternates = intl_alternates();
        });
        $this->get('/seo/'.$article->slug.'/')->assertOk();
        $this->assertSame([
            'ko' => 'https://j-curve.co.kr/seo/'.$article->slug.'/',
            'en' => 'https://j-curve.co.kr/en/insights/check-nofollow-links',
        ], $alternates);
    }

    public function test_translated_detail_passes_both_models_and_alternates_use_translated_slugs(): void
    {
        $sample = $this->sample();
        $this->translatedView('insights.show', '{{ $insight->id }} {{ $translation->title }} {!! json_encode(intl_alternates()) !!}');
        $this->get('/en/insights/mobile-marketing-strategies')->assertOk()
            ->assertSee('[EN DRAFT]')->assertSee('https:\/\/j-curve.co.kr\/ja\/insights\/mobile-marketing-strategies-ja', false);
        $sample->translations()->where('locale', 'ja')->delete();
        $this->get('/en/insights/mobile-marketing-strategies')->assertOk()->assertDontSee('mobile-marketing-strategies-ja');
        $this->get('/ja/insights/mobile-marketing-strategies')->assertNotFound();
        $this->get('/en/insights/mobile-marketing-strategies/')->assertStatus(301)
            ->assertRedirect('http://localhost/en/insights/mobile-marketing-strategies');
    }

    public function test_untranslated_and_hidden_insights_are_404_even_when_foreign_view_exists(): void
    {
        $this->translatedView('insights.show', 'foreign detail');
        $this->get('/en/insights/no-such-translation')->assertNotFound();
        $sample = $this->sample();
        foreach (['en', 'ja'] as $locale) {
            $this->get('/'.$locale.'/insights/'.$sample->slug)->assertStatus(301);
        }
        config(['seo.hidden_insights' => [...config('seo.hidden_insights'), $sample->slug]]);
        $this->get('/en/insights/mobile-marketing-strategies')->assertNotFound();
        config(['seo.hidden_insights' => []]);
        $sample->update(['published_at' => now()->addDay()]);
        $this->get('/en/insights/mobile-marketing-strategies')->assertNotFound();
    }

    public function test_foreign_home_lists_and_categories_load_only_published_translations(): void
    {
        $sample = $this->sample();
        $home = $this->get('/en/')->assertOk();
        $this->assertSame([$sample->id], $home->viewData('insights')->modelKeys());
        $this->assertTrue($home->viewData('insights')->first()->relationLoaded('translation'));
        $this->translatedView('insights.index');
        $this->translatedView('insights.category');
        $response = $this->get('/en/blog/')->assertOk();
        $this->assertSame([$sample->id], $response->viewData('insights')->getCollection()->modelKeys());
        $this->assertSame('http://localhost/en/blog/', $response->viewData('insights')->path());
        $category = $sample->category;
        $this->get(route('en.insights.category', ['slug' => $category->slug], false))->assertOk();
        $this->get('/en/blog/seo/')->assertNotFound();
        $sample->translations()->where('locale', 'en')->delete();
        $this->get(route('en.insights.category', ['slug' => $category->slug], false))->assertNotFound();
    }

    public function test_translation_seeder_is_idempotent_updates_rows_and_detects_display_content_changes(): void
    {
        $sample = $this->sample();
        $before = InsightTranslation::query()->orderBy('id')->get()->toArray();
        $this->seed(IntlInsightSeeder::class);
        $this->assertSame($before, InsightTranslation::query()->orderBy('id')->get()->toArray());
        $sample->translations()->where('locale', 'en')->update(['title' => 'obsolete']);
        $this->seed(IntlInsightSeeder::class);
        $this->assertDatabaseCount('insight_translations', 2);
        $this->assertDatabaseHas('insight_translations', ['locale' => 'en', 'title' => '[EN DRAFT] Five mobile marketing strategies']);
        $this->artisan('intl:stale')->expectsOutputToContain('Stale translations: 0')->assertSuccessful();
        $sample->update(['content' => $sample->content.' changed']);
        $this->artisan('intl:stale')->expectsOutputToContain($sample->slug)
            ->expectsOutputToContain('Stale translations: 2')->assertSuccessful();
        $sample->delete();
        $this->assertDatabaseCount('insight_translations', 0);
        $this->artisan('db:seed', ['--class' => IntlInsightSeeder::class])
            ->expectsOutputToContain('INTL skipped missing ko_slug:')->assertSuccessful();
    }

    public function test_contact_locale_comes_from_path_and_keeps_utm_flash_and_middleware(): void
    {
        foreach (['en', 'ja', 'ko'] as $locale) {
            $path = ($locale === 'ko' ? '' : '/'.$locale).'/contact-us/';
            $matched = Route::getRoutes()->match(Request::create($path, 'POST'));
            foreach (['web', ProtectAgainstSpam::class, 'throttle:5,1'] as $middleware) {
                $this->assertContains($middleware, $matched->gatherMiddleware());
            }
            $fields = [
                'name' => 'Intl Test', 'email' => $locale.'@example.com', 'message' => 'Inquiry',
                'service_interest' => 'seo', 'locale' => 'xx', 'my_name' => '',
                'valid_from' => (string) EncryptedTime::create(now()->subSeconds(3)),
            ];
            $this->withSession(['contact.utm' => ['utm_source' => 'first']])
                ->post($path.'?utm_campaign=global', $fields)->assertRedirect('http://localhost'.$path)
                ->assertSessionHas('status', 'inquiry-received')->assertSessionMissing('contact.utm');
            $lead = Lead::query()->where('email', $locale.'@example.com')->firstOrFail();
            $this->assertSame($locale === 'ko' ? null : $locale, $lead->locale);
            $this->assertSame(['utm_source' => 'first', 'utm_campaign' => 'global'], $lead->utm);
        }
    }

    public function test_contact_validation_is_localized_and_redirects_to_its_own_language(): void
    {
        foreach (['en' => 'The name field is required.', 'ja' => 'お名前は必須です。'] as $locale => $message) {
            $fields = ['my_name' => '', 'valid_from' => (string) EncryptedTime::create(now()->subSeconds(3)), 'locale' => 'ko'];
            $this->from('/login')->post('/'.$locale.'/contact-us/', $fields)
                ->assertRedirect('http://localhost/'.$locale.'/contact-us/')
                ->assertSessionHasErrors(['name' => $message]);
        }
        $this->assertDatabaseCount('leads', 0);
    }

    public function test_stale_hash_uses_korean_display_content_instead_of_hidden_raw_introductions(): void
    {
        $article = Insight::query()->where('slug', '스마트스토어-검색광고가-꼭-필요할까')->firstOrFail();
        $first = '안녕하십니까. 마케팅 비전공자이자 10년차 광고대행사 마케터로 생활하고 있는 초짜 셀러 아나키입니다.';
        $second = '안녕하세요. 마케팅 비전공자이자 10년차 광고대행사 마케터로 생활하고 있는 초짜 셀러 아나키입니다.';
        $article->update(['content' => $first.'<p>Visible content</p>']);
        $visible = $article->fresh()->content;
        $article->translations()->create([
            'locale' => 'en', 'slug' => 'display-hash-example', 'title' => 'Display hash example',
            'content' => '<p>Translated content</p>', 'source_hash' => hash('sha256', $visible),
        ]);
        $article->update(['content' => $second.'<p>Visible content</p>']);
        $this->assertSame($visible, $article->fresh()->content);
        $this->artisan('intl:stale')->expectsOutputToContain('Stale translations: 0')->assertSuccessful();
        $article->update(['content' => $second.'<p>Changed content</p>']);
        $this->artisan('intl:stale')->expectsOutputToContain('Stale translations: 1')->assertSuccessful();
    }

    public function test_foreign_sitemap_entries_and_korean_rss_contract(): void
    {
        $sections = app(FeedCatalog::class)->sections();
        $urls = collect($sections)->flatten(1)->pluck('url');
        foreach (['en', 'ja'] as $locale) {
            foreach (IntlRoutes::variants() as $variant) {
                $this->assertContains('https://j-curve.co.kr'.route($locale.'.'.$variant['name'], $variant['parameters'], false), $urls);
            }
        }
        $this->assertContains('https://j-curve.co.kr/en/insights/mobile-marketing-strategies', $urls);
        $this->assertNotContains('https://j-curve.co.kr/en/self-marketing/order', $urls);
        $this->get('/rss')->assertOk()->assertDontSee('https://j-curve.co.kr/en/')->assertDontSee('https://j-curve.co.kr/ja/');
        SeoMeta::query()->create(['path' => '/en/insights/mobile-marketing-strategies', 'robots' => 'noindex']);
        $urls = collect(app(FeedCatalog::class)->sections())->flatten(1)->pluck('url');
        $this->assertNotContains('https://j-curve.co.kr/en/insights/mobile-marketing-strategies', $urls);
        $this->assertSame('/en/about-us/', PreservedPaths::destination('/en/company'));
    }
}
