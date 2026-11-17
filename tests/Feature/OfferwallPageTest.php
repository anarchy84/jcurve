<?php

namespace Tests\Feature;

use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * SEO-KW-03 (2026-11-16) — 「오퍼월」 전용 페이지 /services/offerwall.
 * 주소·제목·H1·FAQPage(화면 FAQ 와 같은 배열)·사이트맵·llms·홈/리워드 페이지 내부 링크를 지킨다.
 */
class OfferwallPageTest extends TestCase
{
    use RefreshDatabase;

    private const PUBLIC_URL = 'https://j-curve.co.kr';

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => self::PUBLIC_URL]);
    }

    public function test_page_is_public_with_offerwall_title_h1_and_description(): void
    {
        $html = $this->get('/services/offerwall')->assertOk()->getContent();
        $xpath = $this->xpath($html);

        $title = $xpath->evaluate('string(//head/title)');
        $this->assertSame('오퍼월 — 앱 수익화 오퍼월 도입과 광고 집행 | 제이커브인터렉티브', $title);

        $h1 = $xpath->query('//h1');
        $this->assertSame(1, $h1->length);
        $this->assertStringContainsString('오퍼월', $h1->item(0)->textContent);

        $description = $xpath->evaluate('string(//head/meta[@name="description"]/@content)');
        $length = mb_strlen($description);
        $this->assertGreaterThanOrEqual(80, $length);
        $this->assertLessThanOrEqual(160, $length);
        foreach (['오퍼월', '오퍼월 도입', '앱 수익화', '연동', '단가', '앱테크'] as $keyword) {
            $this->assertStringContainsString($keyword, $description);
        }

        $this->assertSame(self::PUBLIC_URL.'/services/offerwall', $xpath->evaluate('string(//head/link[@rel="canonical"]/@href)'));
    }

    public function test_faq_jsonld_matches_visible_faq_and_breadcrumb_service_exist(): void
    {
        $html = $this->get('/services/offerwall')->assertOk()->getContent();
        $xpath = $this->xpath($html);

        $visible = [];
        foreach ($xpath->query('//section[@id="faq"]//details/summary') as $summary) {
            $visible[] = trim($summary->textContent);
        }
        $this->assertGreaterThanOrEqual(5, count($visible));
        $this->assertLessThanOrEqual(9, count($visible));
        $this->assertCount(9, $visible);

        $faqPages = $this->schemas($html, 'FAQPage');
        $this->assertCount(1, $faqPages);
        $this->assertSame($visible, array_column($faqPages[0]['mainEntity'], 'name'));
        $this->assertContains('오퍼월이란 무엇인가요?', $visible);
        $this->assertContains('오퍼월 수익은 무엇에 따라 달라지나요?', $visible);
        $this->assertContains('오퍼월 캠페인 품질은 어떤 기준으로 보나요?', $visible);

        $crumbs = $this->schemas($html, 'BreadcrumbList');
        $this->assertCount(1, $crumbs);
        $names = array_column($crumbs[0]['itemListElement'], 'name');
        $this->assertSame('홈', $names[0]);
        $this->assertSame('오퍼월', end($names));
        $this->assertCount(1, $this->schemas($html, 'Service'));
    }

    public function test_comparison_and_partner_selection_sections_are_present(): void
    {
        $xpath = $this->xpath($this->get('/services/offerwall')->assertOk()->getContent());

        foreach (['compare', 'choose'] as $id) {
            $this->assertSame(1, $xpath->query('//section[@id="'.$id.'"]')->length, $id);
        }
    }

    public function test_page_links_to_reward_network_insight_and_contact(): void
    {
        $html = $this->get('/services/offerwall')->assertOk()->getContent();
        $hrefs = $this->hrefs($html);

        $this->assertContains(route('services.show', ['slug' => 'reward-network']), $hrefs);
        $this->assertContains(route('insights.show', ['insight' => '오퍼월이란-리워드-광고-구조와-앱-수익화']), $hrefs);
        $this->assertContains(route('insights.show', ['insight' => '오퍼월-연동-방법-앱에-붙이는-형태와-준비할-것']), $hrefs);
        $this->assertContains(route('insights.show', ['insight' => '오퍼월-업체-고르는-법-플랫폼-비교-기준']), $hrefs);
        $this->assertNotEmpty(array_filter($hrefs, fn ($href) => str_contains($href, 'service_interest=reward-publisher')));
        $this->assertNotEmpty(array_filter($hrefs, fn ($href) => str_contains($href, 'service_interest=reward-advertiser')));
    }

    public function test_sitemap_and_llms_include_offerwall_page(): void
    {
        $this->get('/sitemaps/services/1.xml')->assertOk()
            ->assertSee(self::PUBLIC_URL.'/services/offerwall', false);

        $this->get('/llms.txt')->assertOk()
            ->assertSee('('.self::PUBLIC_URL.'/services/offerwall)', false);

        // 운영 웹서버는 정적 public/llms.txt 를 라우트보다 먼저 내준다(02f63a8) — 그 파일에도 있어야 한다.
        $this->assertStringContainsString('(https://j-curve.co.kr/services/offerwall)', file_get_contents(public_path('llms.txt')));
    }

    public function test_home_publisher_links_and_reward_network_offerwall_section_point_to_new_page(): void
    {
        $target = route('services.show', ['slug' => 'offerwall']);

        $home = $this->xpath($this->get('/')->assertOk()->getContent());
        $doors = $home->query('//a[contains(concat(" ", normalize-space(@class), " "), " jc-door ")][contains(., "오퍼월을 붙여")]');
        $this->assertSame(1, $doors->length);
        $this->assertSame($target, $doors->item(0)->getAttribute('href'));
        $split = $home->query('//h2[contains(., "오퍼월 수익화")]/parent::div//a');
        $this->assertSame(1, $split->length);
        $this->assertSame($target, $split->item(0)->getAttribute('href'));

        $reward = $this->xpath($this->get('/services/reward-network')->assertOk()->getContent());
        $links = $reward->query('//section[@id="offerwall"]//a[@href="'.$target.'"]');
        $this->assertSame(1, $links->length);
        $this->assertStringContainsString('오퍼월 자세히 보기', $links->item(0)->textContent);
    }

    public function test_unknown_service_slug_still_404(): void
    {
        $this->get('/services/offerwall-x')->assertNotFound();
    }

    private function xpath(string $html): DOMXPath
    {
        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors();

        return new DOMXPath($dom);
    }

    /** @return list<string> */
    private function hrefs(string $html): array
    {
        $hrefs = [];
        foreach ($this->xpath($html)->query('//a[@href]') as $a) {
            $hrefs[] = html_entity_decode($a->getAttribute('href'), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return $hrefs;
    }

    /** @return list<array<string, mixed>> */
    private function schemas(string $html, string $type): array
    {
        $found = [];
        foreach ($this->xpath($html)->query('//script[@type="application/ld+json"]') as $script) {
            $data = json_decode($script->textContent, true);
            $nodes = isset($data['@graph']) ? $data['@graph'] : [$data];
            foreach ($nodes as $node) {
                if (is_array($node) && ($node['@type'] ?? null) === $type) {
                    $found[] = $node;
                }
            }
        }

        return $found;
    }
}
