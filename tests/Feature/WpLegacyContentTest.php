<?php

namespace Tests\Feature;

use Database\Seeders\InsightCategorySeeder;
use Database\Seeders\LegacyContentSeeder;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class WpLegacyContentTest extends TestCase
{
    use RefreshDatabase;

    private const PUBLIC_URL = 'https://j-curve.co.kr';

    // 2026-11-03 source text: join blocks with spaces, collapse Unicode
    // whitespace to one space, trim, then hash the resulting UTF-8 string.
    private const BLOCKS_SHA256 = [
        'home' => '033064a56aebb18d8906fa9d51b1c498ff140fc0d7bb0890b5ce8111d6cd79f4',
        'contact-us' => '5b966737695a69b925ba9e7e7ef9700f465c5fe4fbf485ca80c2004531cf9f8c',
        'seo' => '2e7ce9449b0b624cb99d44eedb80808edd5c7bf909126f0d925c98453125b902',
        'seo-backlinks' => '15505f2b03ca5dead14471d95b96e7f6dca22051e6b2e3e976ba8cad3ebd0511',
        'wordpress-agency' => '8c8f4993352854c3b5a69fb1d4bf46bc87bea3fd812df41f38317059c64d8703',
        'naver-place-marketing' => 'ecb1963fbc911126a13af247c339725227a1431d8259a40d3f1e10edc5020c40',
        'naver-shopping-marketing' => '12a46075c27e2c57778b8d435d69363dd3645d7c48dd053705d067dce8dd757b',
        'kakao-gift' => '8598648685ad5644756efb334c1ea7160bf5ef0a317938060e9970730ddc6599',
        'coupang' => '2161c31b11619caddc1c5464c98311dafa9cb1ac8fac80e8f2ecdb048489ea67',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        config(['seo.public_url' => self::PUBLIC_URL]);
        $this->seed([InsightCategorySeeder::class, LegacyContentSeeder::class]);
    }

    public static function preservedPages(): array
    {
        $pages = [];

        foreach (array_keys(self::BLOCKS_SHA256) as $name) {
            $pages[$name] = [$name, $name === 'home' ? '/' : '/'.$name.'/'];
        }

        return $pages;
    }

    #[DataProvider('preservedPages')]
    public function test_every_original_block_is_escaped_and_ordered_inside_one_section(string $name, string $path): void
    {
        $source = $this->source($name);
        $html = $this->get(self::PUBLIC_URL.$path)->assertOk()->getContent();
        $xpath = $this->html($html);
        $sections = $xpath->query('//*[@id="service-detail"]');

        $this->assertSame(1, $sections->length, $path.': exactly one original-content section');
        $section = $sections->item(0);
        $this->assertInstanceOf(DOMElement::class, $section);
        $this->assertSame('section', $section->tagName);
        $this->assertSame(1, $xpath->query('//h1')->length, $path.': exactly one page heading');

        $renderedBlocks = [];
        foreach ($xpath->query('.//*[self::h2 or self::h3 or self::h4 or self::p or self::li]', $section) as $block) {
            $renderedBlocks[] = $block->textContent;
        }
        $this->assertSame(array_column($source['blocks'], 'text'), $renderedBlocks, $path.': all original blocks, including repetitions, must retain their order');

        // Check the response bytes as well: DOM text alone cannot distinguish
        // an escaped ampersand from an unescaped one.
        $this->assertSame(1, preg_match('/<section\b[^>]*\bid="service-detail"[^>]*>(.*?)<\/section>/s', $html, $matches));
        $offset = 0;
        foreach ($source['blocks'] as $index => $block) {
            $escaped = htmlspecialchars($block['text'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $position = strpos($matches[1], $escaped, $offset);
            $this->assertNotFalse($position, $path.': escaped block '.$index.' must appear inside the section in order');
            $offset = $position + strlen($escaped);
        }

        foreach ($source['excluded'] as $excluded) {
            $this->assertStringNotContainsString($excluded, $html, $path.': excluded copy must not occur anywhere in the response');
            $this->assertStringNotContainsString($excluded, $xpath->document->textContent, $path.': excluded copy must not occur as decoded page text');
        }
    }

    #[DataProvider('preservedPages')]
    public function test_original_block_text_matches_its_fixed_sha256(string $name, string $path): void
    {
        $source = $this->source($name);
        $this->assertNotEmpty($source['blocks'], $path);
        $normalized = preg_replace('/\s+/u', ' ', trim(implode(' ', array_column($source['blocks'], 'text'))));

        $this->assertNotNull($normalized, $name.': source must be valid UTF-8');
        $this->assertSame(self::BLOCKS_SHA256[$name], hash('sha256', $normalized), $name.': original sentences and numbers must not change');
    }

    public static function pagesWithoutOriginalContent(): array
    {
        return [
            'company' => ['/about-us/', null],
            'blog' => ['/blog/', null],
            'seo category' => ['/blog/seo/', null],
            'link-building category' => ['/blog/link-building/', null],
            'cpa without seo_title' => ['/services/cpa-marketing/real-estate', 'cpa.items.real-estate'],
            'performance without seo_title' => ['/services/performance-marketing/naver-gfa', 'performance.items.naver-gfa'],
            'boostingshop without seo_title' => ['/solutions/boostingshop/basic', 'boostingshop.items.basic'],
        ];
    }

    #[DataProvider('pagesWithoutOriginalContent')]
    public function test_unrelated_pages_have_no_original_content_section_and_one_h1(string $path, ?string $configKey): void
    {
        if ($configKey !== null) {
            $page = config('subpages.'.$configKey);
            $this->assertIsArray($page, $configKey.': configured subpage must exist');
            $this->assertArrayNotHasKey('seo_title', $page, $configKey.': negative case must have no original SEO title');
        }

        $html = $this->get(self::PUBLIC_URL.$path)->assertOk()->getContent();
        $xpath = $this->html($html);

        $this->assertSame(0, $xpath->query('//*[@id="service-detail"]')->length, $path);
        $this->assertSame(1, $xpath->query('//h1')->length, $path.': exactly one page heading');
    }

    private function source(string $name): array
    {
        return json_decode(file_get_contents(resource_path('views/partials/jc/wp-legacy/'.$name.'.json')), true, flags: JSON_THROW_ON_ERROR);
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
