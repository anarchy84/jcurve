<?php

namespace Tests\Feature;

use App\Models\LegacyRedirect;
use App\Services\Seo\Publishing\PublicUrl;
use App\Services\Seo\Publishing\UrlAuditManifest;
use App\Services\Seo\Publishing\UrlAuditor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Tests\TestCase;

class SeoUrlAuditTest extends TestCase
{
    use RefreshDatabase;

    private array $temporaryFiles = [];

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => 'https://j-curve.co.kr']);
        Http::preventStrayRequests();
    }

    protected function tearDown(): void
    {
        foreach ($this->temporaryFiles as $file) {
            unlink($file);
        }
        parent::tearDown();
    }

    public function test_preservation_is_a_200_contract_and_existing_mapping_is_not_changed(): void
    {
        $mapping = LegacyRedirect::query()->create(['from_path' => 'seo', 'to_path' => '/services/seo', 'status_code' => 301]);
        Http::fake(['https://stage.example/seo/' => Http::response('', 301, ['Location' => '/services/seo'])]);
        $manifest = $this->manifest([['path' => '/seo/', 'status' => 200]]);
        $this->artisan('seo:audit-urls', ['--base-url' => 'https://stage.example', '--manifest' => $manifest, '--json' => true])
            ->expectsOutputToContain('status_mismatch')->assertExitCode(1);
        $this->assertSame('/services/seo', $mapping->fresh()->to_path);
        $this->assertSame(301, $mapping->fresh()->status_code);
        Http::assertSentCount(1);
    }

    public function test_preserved_content_and_explicit_single_hop_redirect_pass(): void
    {
        Http::fake([
            'https://stage.example/seo/' => $this->page('/seo/', '<h1>원래 SEO 내용</h1>'),
            'https://stage.example/old' => Http::response('', 301, ['Location' => '/company#team']),
            'https://stage.example/company' => $this->page('/company', '<h1>회사소개</h1>'),
        ]);
        $manifest = $this->manifest([
            ['path' => '/seo/', 'contains' => ['원래 SEO 내용']],
            ['path' => '/old', 'status' => 301, 'to' => '/company#team'],
        ]);
        $this->artisan('seo:audit-urls', ['--base-url' => 'https://stage.example', '--manifest' => $manifest, '--json' => true])
            ->expectsOutputToContain('"failed": 0')->assertSuccessful();
        Http::assertSentCount(3);
    }

    public function test_chain_external_target_missing_canonical_noindex_and_connection_fail_are_reported(): void
    {
        Http::fake([
            'https://stage.example/broken' => Http::response('missing', 404),
            'https://stage.example/chain' => Http::response('', 301, ['Location' => '/hop']),
            'https://stage.example/hop' => Http::response('', 301, ['Location' => '/unfollowed']),
            'https://stage.example/external' => Http::response('', 301, ['Location' => 'https://other.example/company']),
            'https://stage.example/canonical' => $this->page('/other'),
            'https://stage.example/hidden' => Http::response('<html><head><link rel="canonical" href="https://j-curve.co.kr/hidden"></head><body>내용</body></html>', 200, ['Content-Type' => 'text/html', 'X-Robots-Tag' => 'googlebot: noindex']),
            'https://stage.example/empty' => $this->page('/empty'),
            'https://stage.example/offline' => Http::failedConnection(),
            'https://stage.example/body-canonical' => Http::response('<html><head></head><body><link rel="canonical" href="https://j-curve.co.kr/body-canonical">내용</body></html>', 200, ['Content-Type' => 'text/html']),
        ]);
        $entries = [
            ['path' => '/broken', 'status' => 200],
            ['path' => '/chain', 'status' => 301, 'to' => '/hop'],
            ['path' => '/external', 'status' => 301, 'to' => '/company'],
            ['path' => '/canonical', 'status' => 200],
            ['path' => '/hidden', 'status' => 200],
            ['path' => '/empty', 'status' => 200, 'contains' => ['사라지면 안 되는 본문']],
            ['path' => '/offline', 'status' => 200],
            ['path' => '/body-canonical', 'status' => 200],
        ];
        $report = app(UrlAuditor::class)->audit($entries, 'https://stage.example');
        $this->assertSame(8, $report['failed']);
        $this->assertSame([
            ['status_mismatch'], ['redirect_chain_or_loop'], ['redirect_target_mismatch'],
            ['canonical_mismatch_or_missing'], ['noindex'], ['expected_content_missing'],
            ['connection_failed'], ['canonical_mismatch_or_missing'],
        ], array_column($report['results'], 'issues'));
        Http::assertNotSent(fn ($request) => str_contains($request->url(), 'other.example') || str_contains($request->url(), 'unfollowed'));
    }

    public function test_default_manifest_contains_legacy_original_urls_without_approving_redirects(): void
    {
        $entries = app(UrlAuditManifest::class)->load();
        $this->assertGreaterThan(60, count($entries));
        $this->assertContains('/seo/', array_column($entries, 'path'));
        $this->assertNotEmpty(array_filter($entries, fn ($entry) => str_contains($entry['path'], 'board.php?') && str_contains($entry['path'], 'wr_id=')));
        $this->assertSame([200], array_values(array_unique(array_column($entries, 'status'))));
    }

    public function test_no_base_url_does_not_contact_any_server(): void
    {
        $this->artisan('seo:audit-urls')->assertExitCode(2);
        Http::assertNothingSent();
    }

    public function test_external_manifest_paths_are_rejected_before_network_requests(): void
    {
        $manifest = $this->manifest([['path' => '//other.example/private']]);
        $this->artisan('seo:audit-urls', ['--base-url' => 'https://stage.example', '--manifest' => $manifest])->assertExitCode(2);
        Http::assertNothingSent();
    }

    public function test_invalid_origin_cannot_replace_the_public_base(): void
    {
        $this->expectException(InvalidArgumentException::class);
        PublicUrl::origin('https://user:password@example.test/private');
    }

    public function test_encoded_delimiters_cannot_masquerade_as_approved_redirect_targets(): void
    {
        Http::fake([
            'https://stage.example/fragment' => Http::response('', 301, ['Location' => '/company%23team']),
            'https://stage.example/query' => Http::response('', 301, ['Location' => '/company%3Fteam=1']),
        ]);
        $report = app(UrlAuditor::class)->audit([
            ['path' => '/fragment', 'status' => 301, 'to' => '/company#team'],
            ['path' => '/query', 'status' => 301, 'to' => '/company?team=1'],
        ], 'https://stage.example');
        $this->assertSame(2, $report['failed']);
        $this->assertSame([['redirect_target_mismatch'], ['redirect_target_mismatch']], array_column($report['results'], 'issues'));
        Http::assertSentCount(2);
    }

    public function test_url_comparison_preserves_reserved_characters_and_accepts_unicode_encoding(): void
    {
        $urls = app(PublicUrl::class);
        $this->assertFalse($urls->canonicalMatches('/company%3Fteam=1', 'https://j-curve.co.kr/company?team=1'));
        $this->assertFalse($urls->canonicalMatches('/part%2fsection', 'https://j-curve.co.kr/part/section'));
        $this->assertFalse($urls->canonicalMatches('/?a=1%26b=2', 'https://j-curve.co.kr/?a=1&b=2'));
        $this->assertTrue($urls->canonicalMatches('/'.rawurlencode('한글').'/%7eteam', 'https://j-curve.co.kr/한글/~team'));
        $this->assertFalse(PublicUrl::equivalent('/invalid%path', '/invalid%path'));
    }

    private function page(string $canonicalPath, string $body = '본문'): mixed
    {
        return Http::response('<html><head><link rel="canonical" href="https://j-curve.co.kr'.$canonicalPath.'"></head><body>'.$body.'</body></html>', 200, ['Content-Type' => 'text/html; charset=UTF-8']);
    }

    private function manifest(array $entries): string
    {
        $path = tempnam(sys_get_temp_dir(), 'jcurve-url-test-');
        file_put_contents($path, json_encode($entries, JSON_UNESCAPED_UNICODE));
        $this->temporaryFiles[] = $path;

        return $path;
    }
}
