<?php

namespace Tests\Feature;

use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * JC-RELEASE-A (2026-11-16) — 메뉴의 오퍼월 링크, /self-marketing = 새 랜딩, /lp/self-marketing → 301.
 */
class ReleaseMenuSelfMarketingTest extends TestCase
{
    use RefreshDatabase;

    private const PUBLIC_URL = 'https://j-curve.co.kr';

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => self::PUBLIC_URL]);
    }

    public function test_offerwall_is_in_desktop_mega_menu_mobile_menu_and_footer_next_to_reward_network(): void
    {
        $xpath = $this->xpath($this->get('/')->assertOk()->getContent());
        $offerwall = route('services.show', ['slug' => 'offerwall']);
        $reward = route('services.show', ['slug' => 'reward-network']);

        $scopes = [
            'desktop' => '//header//nav[@aria-label="주 메뉴"]//div[contains(@class, "jc-mega")]',
            'mobile' => '//header//nav[@aria-label="모바일 메뉴"]',
            'footer' => '//footer//nav[@aria-label="광고 마케팅"]',
        ];
        foreach ($scopes as $name => $scope) {
            $links = $xpath->query($scope.'//a[@href="'.$offerwall.'"]');
            $this->assertSame(1, $links->length, $name.' must have one offerwall link');
            $this->assertSame('오퍼월', trim($links->item(0)->textContent), $name);

            // 리워드 네트워크 바로 다음 칸
            $hrefs = [];
            foreach ($xpath->query($scope.'//a[@href]') as $a) {
                $hrefs[] = $a->getAttribute('href');
            }
            $i = array_search($reward, $hrefs, true);
            $this->assertNotFalse($i, $name.' must have reward-network');
            $this->assertSame($offerwall, $hrefs[$i + 1], $name.' offerwall must follow reward-network');
        }
    }

    public function test_old_landing_url_redirects_permanently_to_self_marketing(): void
    {
        $this->get('/lp/self-marketing')->assertStatus(301)->assertRedirect('/self-marketing');
    }

    public function test_self_marketing_renders_the_new_landing_with_breadcrumb_and_faq(): void
    {
        $html = $this->get('/self-marketing')->assertOk()->getContent();
        $xpath = $this->xpath($html);

        $this->assertSame(1, $xpath->query('//div[contains(concat(" ", normalize-space(@class), " "), " jc-lp ")]')->length);
        $h1 = $xpath->query('//h1');
        $this->assertSame(1, $h1->length);
        $this->assertStringContainsString('순위상승 캠페인 주문까지', $h1->item(0)->textContent);
        $this->assertStringStartsWith('셀프마케팅', $xpath->evaluate('string(//head/title)'));

        // 화면 위치 경로: 홈 / 셀프마케팅 (「시작 안내」 단계 없음)
        $crumb = $xpath->query('//nav[@aria-label="현재 위치"]')->item(0);
        $this->assertNotNull($crumb);
        $this->assertSame('셀프마케팅', trim($xpath->evaluate('string(.//*[@aria-current="page"])', $crumb)));
        $this->assertStringNotContainsString('시작 안내', $crumb->textContent);

        $breadcrumb = $this->schemas($html, 'BreadcrumbList');
        $this->assertCount(1, $breadcrumb);
        $this->assertSame(['홈', '셀프마케팅'], array_column($breadcrumb[0]['itemListElement'], 'name'));
        $this->assertSame(self::PUBLIC_URL.'/self-marketing', end($breadcrumb[0]['itemListElement'])['item']);

        $visible = [];
        foreach ($xpath->query('//*[@id="main"]//details/summary') as $summary) {
            $visible[] = trim(preg_replace('/\s+/u', ' ', $xpath->evaluate('string(.//*[contains(@class, "jc-lp-faq__q")])', $summary)));
        }
        $faq = $this->schemas($html, 'FAQPage');
        $this->assertCount(1, $faq);
        $this->assertNotEmpty($visible);
        $this->assertSame($visible, array_column($faq[0]['mainEntity'], 'name'));

        $hrefs = [];
        foreach ($xpath->query('//*[@id="main"]//a[@href]') as $a) {
            $hrefs[] = parse_url($a->getAttribute('href'), PHP_URL_PATH);
        }
        foreach (['/self-marketing/place', '/self-marketing/shopping', '/self-marketing/order', '/solutions/rankfree'] as $path) {
            $this->assertContains($path, $hrefs, 'landing must link to '.$path);
        }
    }

    private function xpath(string $html): DOMXPath
    {
        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors();

        return new DOMXPath($dom);
    }

    /** @return list<array<string, mixed>> */
    private function schemas(string $html, string $type): array
    {
        $found = [];
        foreach ($this->xpath($html)->query('//script[@type="application/ld+json"]') as $script) {
            $data = json_decode($script->textContent, true);
            foreach (isset($data['@graph']) ? $data['@graph'] : [$data] as $node) {
                if (is_array($node) && ($node['@type'] ?? null) === $type) {
                    $found[] = $node;
                }
            }
        }

        return $found;
    }
}
