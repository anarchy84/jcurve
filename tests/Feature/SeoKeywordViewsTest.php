<?php

namespace Tests\Feature;

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Models\User;
use Database\Seeders\InsightCategorySeeder;
use Database\Seeders\KeywordInsightSeeder;
use Database\Seeders\LegacyContentSeeder;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SeoKeywordViewsTest extends TestCase
{
    use RefreshDatabase;

    private const PUBLIC_URL = 'https://j-curve.co.kr';

    private const ORGANIZATION = self::PUBLIC_URL.'/#organization';

    protected function setUp(): void
    {
        parent::setUp();
        config(['seo.public_url' => self::PUBLIC_URL]);
        $this->travelTo(Carbon::parse('2026-11-05 12:00:00', 'UTC'));
    }

    public static function commonPages(): array
    {
        return array_map(fn ($path) => [$path], ['/', '/naver-place-marketing/', '/services/reward-network', '/self-marketing/shopping']);
    }

    #[DataProvider('commonPages')]
    public function test_common_jsonld_and_public_verification_tags(string $path): void
    {
        $this->assertCommonHead($this->page($path));
    }

    public function test_insight_has_the_same_common_jsonld_and_verification_tags(): void
    {
        $this->assertCommonHead($this->page($this->insightPath($this->insight())));
    }

    public function test_head_jsonld_escapes_script_endings_and_decodes_html_entities(): void
    {
        $title = '제목 & "인용" </script><script data-seo-head-probe>alert(1)</script>';
        $description = '설명 & "인용" </script><b>본문</b>';
        $html = $this->page($this->insightPath($this->insight(['title' => $title, 'meta_title' => $title, 'meta_description' => $description])));
        $webPage = $this->oneSchema($html, 'WebPage');

        $this->assertSame($title.' | 제이커브인터렉티브', $webPage['name']);
        $this->assertSame('설명 & "인용" 본문', $webPage['description']);
        foreach (['name', 'description'] as $field) {
            $this->assertDoesNotMatchRegularExpression('/&(?:amp|quot|lt|gt|#\d+|#x[0-9a-f]+);/i', $webPage[$field]);
        }
        $this->assertSame(0, $this->html($html)->query('//script[@data-seo-head-probe]')->length);
        $this->assertStringContainsString('\\u003C/script\\u003E', implode("\n", $this->jsonBlocks($html)));
    }

    public function test_subpage_has_exactly_one_service_and_breadcrumb(): void
    {
        $html = $this->page('/naver-place-marketing/');
        $service = $this->oneSchema($html, 'Service');
        $this->assertSame(self::ORGANIZATION, $service['provider']['@id']);
        $this->assertSame($this->canonical($html), $service['url']);
        $this->oneSchema($html, 'BreadcrumbList');
    }

    public function test_insight_blogposting_dates_author_publisher_and_article_metadata(): void
    {
        $insight = $this->insight();
        $html = $this->page($this->insightPath($insight));
        $article = $this->oneSchema($html, 'BlogPosting');
        $this->assertSame($insight->title, $article['headline']);
        $this->assertSame($insight->published_at->toAtomString(), $article['datePublished']);
        $this->assertSame($insight->updated_at->toAtomString(), $article['dateModified']);
        $this->assertSame(self::ORGANIZATION, $article['publisher']['@id']);
        $this->assertSame(self::ORGANIZATION, $article['author']['@id']);
        $this->assertSame($this->canonical($html), $article['url']);
        $this->oneSchema($html, 'BreadcrumbList');
        $xpath = $this->html($html);
        $this->assertSame(1, $xpath->query('//head/meta[@property="og:type"]')->length);
        $this->assertSame('article', $xpath->evaluate('string(//head/meta[@property="og:type"]/@content)'));
        $this->assertSame(1, $xpath->query('//head/meta[@property="article:published_time"]')->length);
        $this->assertSame($insight->published_at->toAtomString(), $xpath->evaluate('string(//head/meta[@property="article:published_time"]/@content)'));
    }

    public static function legacyArticles(): array
    {
        $pages = json_decode(file_get_contents(dirname(__DIR__, 2).'/docs/SEO-META-02-TITLES.json'), true, flags: JSON_THROW_ON_ERROR)['pages'];
        $cases = [];
        foreach ($pages as $path => $page) {
            if (str_starts_with($path, '/seo/') && $path !== '/seo/') {
                $cases[$path] = [$path, Str::limit(strip_tags($page['description']), 155)];
            }
        }

        return $cases;
    }

    #[DataProvider('legacyArticles')]
    public function test_original_article_descriptions_keep_the_existing_preservation_contract(string $path, string $expected): void
    {
        $this->seed([InsightCategorySeeder::class, LegacyContentSeeder::class]);
        $html = $this->html($this->page($path));
        $this->assertSame(1, $html->query('//head/meta[@name="description"]')->length);
        $this->assertSame($expected, $html->evaluate('string(//head/meta[@name="description"]/@content)'));
    }

    public static function descriptionLengths(): array
    {
        return [
            '159 Korean characters' => [str_repeat('가', 159), str_repeat('가', 159)],
            '160 Korean characters' => [str_repeat('가', 160), str_repeat('가', 160)],
            '161 Korean characters' => [str_repeat('가', 161), str_repeat('가', 159).'…'],
            '161 ASCII characters' => [str_repeat('a', 161), str_repeat('a', 159).'…'],
        ];
    }

    #[DataProvider('descriptionLengths')]
    public function test_insight_description_uses_160_characters_including_the_ellipsis(string $description, string $expected): void
    {
        $html = $this->page($this->insightPath($this->insight(['meta_description' => $description])));
        $xpath = $this->html($html);
        $this->assertSame(1, $xpath->query('//head/meta[@name="description"]')->length);
        $this->assertSame($expected, $xpath->evaluate('string(//head/meta[@name="description"]/@content)'));
        $this->assertLessThanOrEqual(160, mb_strlen($expected));
        $this->assertSame($expected, $this->oneSchema($html, 'WebPage')['description']);
        $this->assertSame($expected, $this->oneSchema($html, 'BlogPosting')['description']);
    }

    public static function guestPages(): array
    {
        return [['/login', '로그인'], ['/register', '회원가입'], ['/forgot-password', '비밀번호 찾기']];
    }

    #[DataProvider('guestPages')]
    public function test_guest_pages_are_noindex_and_have_their_korean_titles(string $path, string $title): void
    {
        $xpath = $this->html($this->page($path));
        $this->assertSame(1, $xpath->query('//head/meta[@name="robots"]')->length);
        $this->assertContains('noindex', array_map('trim', explode(',', $xpath->evaluate('string(//head/meta[@name="robots"]/@content)'))));
        $this->assertSame(1, $xpath->query('//head/title')->length);
        $this->assertSame($title.' | 제이커브인터렉티브', $xpath->evaluate('string(//head/title)'));
        $this->assertStringNotContainsString('Laravel', $xpath->evaluate('string(//head/title)'));
    }

    public static function categoryPages(): array
    {
        return [
            'empty' => ['empty-keyword', false, 'noindex'],
            'only unpublished and future articles' => ['draft-keyword', false, 'noindex'],
            'published' => ['published-keyword', true, 'index'],
            'preserved empty SEO' => ['seo', false, 'index'],
            'preserved empty link building' => ['link-building', false, 'index'],
        ];
    }

    #[DataProvider('categoryPages')]
    public function test_only_empty_nonpreserved_categories_are_noindex(string $slug, bool $published, string $directive): void
    {
        $category = InsightCategory::query()->create(['slug' => $slug, 'name' => '카테고리 '.$slug]);
        if ($published) {
            $this->insight(['category_id' => $category->id]);
        } elseif ($slug === 'draft-keyword') {
            $this->insight(['slug' => 'draft-keyword-article', 'category_id' => $category->id, 'published_at' => null]);
            $this->insight(['slug' => 'future-keyword-article', 'category_id' => $category->id, 'published_at' => now()->addDay()]);
        }
        $this->assertSame($published ? 1 : 0, $category->insights()->published()->count());
        $path = in_array($slug, ['seo', 'link-building'], true) ? '/blog/'.$slug.'/' : '/insights/category/'.$slug;
        $xpath = $this->html($this->page($path));
        $this->assertSame(1, $xpath->query('//head/meta[@name="robots"]')->length);
        $directives = array_map('trim', explode(',', $xpath->evaluate('string(//head/meta[@name="robots"]/@content)')));
        $this->assertContains($directive, $directives);
        $this->assertNotContains($directive === 'index' ? 'noindex' : 'index', $directives);
    }

    public function test_shopping_keywords_order_links_and_absence_of_displayed_prices(): void
    {
        $xpath = $this->html($this->page('/self-marketing/shopping'));
        $this->assertStringContainsString('쇼핑 리워드', $xpath->evaluate('string(//head/title)'));
        $this->assertSame(1, $xpath->query('//h1')->length);
        $this->assertSame('쇼핑 리워드 마케팅', trim($xpath->evaluate('string(//h1)')));
        $orders = 0;
        foreach ($xpath->query('//*[@id="main"]//a[@href]') as $link) {
            if (parse_url($link->getAttribute('href'), PHP_URL_PATH) === '/self-marketing/order') {
                parse_str(parse_url($link->getAttribute('href'), PHP_URL_QUERY) ?? '', $query);
                $this->assertSame('shopping', $query['type'] ?? null);
                $orders++;
            }
        }
        $this->assertGreaterThan(0, $orders);
        $this->assertDoesNotMatchRegularExpression('/(?:₩\s*[\d,]+|[\d,]+\s*원|KRW)/u', $xpath->evaluate('string(//*[@id="main"])'));
    }

    public function test_place_keywords_and_shopping_link_are_in_the_content(): void
    {
        $xpath = $this->html($this->page('/self-marketing/place'));
        foreach (['플레이스 리워드', '플레이스 순위'] as $keyword) {
            $this->assertStringContainsString($keyword, $xpath->evaluate('string(//head/title)'));
        }
        $this->assertLink($xpath, '//*[@id="main"]', '/self-marketing/shopping');
    }

    public function test_self_marketing_shopping_card_keeps_its_detail_link(): void
    {
        $xpath = $this->html($this->page('/self-marketing'));
        $links = $this->assertLink($xpath, '//*[@id="main"]', '/self-marketing/shopping');
        $this->assertStringContainsString('쇼핑 자세히', implode(' ', array_map(fn ($link) => $link->textContent, $links)));
    }

    public function test_reward_network_has_offerwall_keywords_section_and_faq(): void
    {
        $html = $this->page('/services/reward-network');
        $xpath = $this->html($html);
        foreach (['리워드 광고', '오퍼월'] as $keyword) {
            $this->assertStringContainsString($keyword, $xpath->evaluate('string(//head/title)'));
        }
        $this->assertSame(1, $xpath->query('//section[@id="offerwall"]')->length);
        $this->assertContains('오퍼월이란 무엇인가요?', array_column($this->oneSchema($html, 'FAQPage')['mainEntity'], 'name'));
    }

    public function test_rankfree_title_targets_place_and_shopping_rankings(): void
    {
        $xpath = $this->html($this->page('/solutions/rankfree'));
        foreach (['플레이스 순위', '쇼핑 순위'] as $keyword) {
            $this->assertStringContainsString($keyword, $xpath->evaluate('string(//head/title)'));
        }
    }

    public function test_llms_has_unescaped_text_and_only_public_absolute_links(): void
    {
        $text = $this->get(self::PUBLIC_URL.'/llms.txt')->assertOk()->getContent();
        foreach (['&amp;', '&lt;'] as $entity) {
            $this->assertStringNotContainsString($entity, $text);
        }
        preg_match_all('/\[[^\]]+\]\(([^)\s]+)\)/u', $text, $links);
        $this->assertNotEmpty($links[1]);
        preg_match_all('~https?://[^\s)<>]+~u', $text, $urls);
        foreach ([...$links[1], ...$urls[0]] as $url) {
            $this->assertStringStartsWith(self::PUBLIC_URL.'/', $url);
        }
    }

    public static function faqPages(): array
    {
        return [
            '/self-marketing' => ['/self-marketing', 5],
            '/self-marketing/place' => ['/self-marketing/place', 6],
            '/self-marketing/shopping' => ['/self-marketing/shopping', 6],
            '/solutions' => ['/solutions', 6],
            '/solutions/rankfree' => ['/solutions/rankfree', 9],
            '/solutions/leadbay' => ['/solutions/leadbay', 7],
            '/solutions/boostingshop' => ['/solutions/boostingshop', 7],
            '/solutions/call2sale' => ['/solutions/call2sale', 7],
        ];
    }

    #[DataProvider('faqPages')]
    public function test_faq_schema_matches_the_fixed_count_and_visible_questions(string $path, int $count): void
    {
        $html = $this->page($path);
        $questions = $this->oneSchema($html, 'FAQPage')['mainEntity'];
        $visible = [];
        foreach ($this->html($html)->query('//*[@id="main"]//details/summary') as $summary) {
            $visible[] = $this->normalize($summary->textContent);
        }
        $message = $path.': actual visible FAQ count = '.count($visible).'; actual schema FAQ count = '.count($questions);
        $this->assertCount($count, $visible, $message);
        $this->assertCount($count, $questions, $message);
        $this->assertSame($visible, array_column($questions, 'name'), $path);
        $this->assertPlainAnswers($questions);
    }

    public function test_rankfree_first_visible_faq_keeps_both_service_links(): void
    {
        $xpath = $this->html($this->page('/solutions/rankfree'));
        foreach (['/naver-place-marketing/', '/self-marketing/place'] as $path) {
            $this->assertLink($xpath, '(//*[@id="main"]//details)[1]', $path);
        }
    }

    public function test_faq_jsonld_escapes_script_endings_in_an_insight_question(): void
    {
        // Encoded text survives strip_tags and becomes a literal closing tag
        // when schema-faq decodes entities, exercising its JSON_HEX_TAG flag.
        $question = '질문 &lt;/script&gt;&lt;script data-seo-faq-probe&gt;alert(1)&lt;/script&gt; &amp; "인용"?';
        $content = '<h2>자주 묻는 질문</h2><h3>'.$question.'</h3><p>답 &amp; <strong>설명</strong></p>';
        $html = $this->page($this->insightPath($this->insight(['content' => $content])));
        $questions = $this->oneSchema($html, 'FAQPage')['mainEntity'];
        $this->assertCount(1, $questions);
        $this->assertSame(html_entity_decode($question, ENT_QUOTES | ENT_HTML5, 'UTF-8'), $questions[0]['name']);
        $this->assertSame('답 & 설명', $questions[0]['acceptedAnswer']['text']);
        $this->assertSame(0, $this->html($html)->query('//script[@data-seo-faq-probe]')->length);
        $this->assertStringContainsString('\\u003C/script\\u003E', implode("\n", $this->jsonBlocks($html)));
    }

    public static function breadcrumbPages(): array
    {
        $withoutService = ['/solutions', '/services', '/about-us/', '/contact-us/', '/support/faq'];
        $paths = [
            '/solutions/rankfree', '/solutions/leadbay', '/solutions/boostingshop', '/solutions/call2sale', '/solutions/shopitrend',
            '/solutions', '/services', '/services/performance-marketing', '/services/cpa-marketing', '/services/reward-network',
            '/services/seo/aeo', '/services/seo/geo', '/wordpress-agency/', '/services/marketing-support', '/about-us/',
            '/contact-us/', '/support/faq', '/self-marketing', '/self-marketing/place', '/self-marketing/shopping',
        ];
        $cases = [];
        foreach ($paths as $path) {
            $cases[$path] = [$path, in_array($path, $withoutService, true) === false];
        }

        return $cases;
    }

    #[DataProvider('breadcrumbPages')]
    public function test_page_breadcrumb_and_service_contract(string $path, bool $hasService): void
    {
        $html = $this->page($path);
        $breadcrumb = $this->oneSchema($html, 'BreadcrumbList');
        $canonical = $this->canonical($html);
        $items = $breadcrumb['itemListElement'];
        $this->assertGreaterThanOrEqual(2, count($items));
        $this->assertSame('홈', $items[0]['name']);
        $this->assertSame(self::PUBLIC_URL.'/', $items[0]['item']);
        $this->assertSame($canonical, $items[array_key_last($items)]['item']);
        foreach ($items as $index => $item) {
            $this->assertSame($index + 1, $item['position']);
            $this->assertStringStartsWith(self::PUBLIC_URL.'/', $item['item']);
        }
        $this->assertNotEmpty($breadcrumb['@id']);
        $this->assertSame($breadcrumb['@id'], $this->oneSchema($html, 'WebPage')['breadcrumb']['@id']);
        $services = $this->schemas($html, 'Service');
        $this->assertCount($hasService ? 1 : 0, $services, $path);
        if ($hasService) {
            $this->assertSame(self::ORGANIZATION, $services[0]['provider']['@id']);
            $this->assertSame($canonical, $services[0]['url']);
        }
        if ($path === '/services/seo/aeo') {
            $this->assertCount(4, $items);
            $this->assertSame(['홈', '서비스', 'SEO'], array_slice(array_column($items, 'name'), 0, 3));
            $this->assertSame([self::PUBLIC_URL.'/', self::PUBLIC_URL.'/services', self::PUBLIC_URL.'/seo/', $canonical], array_column($items, 'item'));
        }
    }

    public function test_home_has_no_service_schema(): void
    {
        $this->assertCount(0, $this->schemas($this->page('/'), 'Service'));
    }

    public function test_all_five_seeded_articles_have_three_faqs_matching_their_body_headings(): void
    {
        $this->seed([InsightCategorySeeder::class, KeywordInsightSeeder::class]);
        $manifest = json_decode(file_get_contents(database_path('content/kw01/manifest.json')), true, flags: JSON_THROW_ON_ERROR);
        $this->assertCount(5, $manifest);
        foreach ($manifest as $article) {
            $html = $this->page('/insights/'.rawurlencode($article['slug']));
            $xpath = $this->html($html);
            $headings = [];
            $inFaq = false;
            foreach ($xpath->query('//*[@data-jc-prose]//*[self::h2 or self::h3]') as $heading) {
                if ($heading->tagName === 'h2') {
                    $inFaq = $this->normalize($heading->textContent) === '자주 묻는 질문';
                } elseif ($inFaq) {
                    $headings[] = $this->normalize($heading->textContent);
                }
            }
            $questions = $this->oneSchema($html, 'FAQPage')['mainEntity'];
            $this->assertCount(3, $headings, $article['slug']);
            $this->assertCount(3, $questions, $article['slug']);
            $this->assertSame($headings, array_column($questions, 'name'), $article['slug']);
            $this->assertPlainAnswers($questions);
        }
    }

    public function test_old_article_without_a_faq_heading_has_no_faq_schema(): void
    {
        $this->seed([InsightCategorySeeder::class, LegacyContentSeeder::class]);
        $insight = Insight::query()->published()->where('slug', '2019년-그로스해커에게-필요한-스킬3')->sole();
        $this->assertStringNotContainsString('자주 묻는 질문', $insight->content);
        $this->assertCount(0, $this->schemas($this->page($this->insightPath($insight)), 'FAQPage'));
    }

    public static function footerPages(): array
    {
        return [['/'], ['/blog/'], ['/naver-place-marketing/']];
    }

    #[DataProvider('footerPages')]
    public function test_footer_has_both_reward_links_and_desktop_header_has_one_self_link(string $path): void
    {
        $xpath = $this->html($this->page($path));
        $this->assertSame(1, $xpath->query('//footer')->length);
        foreach (['/self-marketing/place', '/self-marketing/shopping'] as $link) {
            $this->assertLink($xpath, '//footer', $link);
        }
        $links = $this->assertLink($xpath, '//header//nav[@aria-label="주 메뉴"]', '/self-marketing');
        $this->assertCount(1, $links);
    }

    private function assertCommonHead(string $html): void
    {
        $this->assertSame(self::ORGANIZATION, $this->oneSchema($html, 'Organization')['@id']);
        $this->oneSchema($html, 'WebSite');
        $this->assertSame($this->canonical($html), $this->oneSchema($html, 'WebPage')['url']);
        $xpath = $this->html($html);
        $this->assertSame(1, $xpath->query('//head/meta[@name="google-site-verification"]')->length);
        $this->assertSame('-JI9b9PGuPzBzPbZQXEAqZR8YfikUXM7GOP_5lgEQXM', $xpath->evaluate('string(//head/meta[@name="google-site-verification"]/@content)'));
        $this->assertSame(0, $xpath->query('//head/meta[@name="naver-site-verification"]')->length);
    }

    private function assertPlainAnswers(array $questions): void
    {
        foreach ($questions as $question) {
            $this->assertSame('Question', $question['@type']);
            $this->assertSame('Answer', $question['acceptedAnswer']['@type']);
            $this->assertNotSame('', $question['acceptedAnswer']['text']);
            $this->assertStringNotContainsString('<', $question['acceptedAnswer']['text']);
        }
    }

    private function assertLink(DOMXPath $xpath, string $scope, string $path): array
    {
        $links = [];
        foreach ($xpath->query($scope.'//a[@href]') as $link) {
            if (in_array($link->getAttribute('href'), [$path, self::PUBLIC_URL.$path], true)) {
                $links[] = $link;
            }
        }
        $this->assertNotEmpty($links, $scope.' must link to '.$path);

        return $links;
    }

    private function insight(array $attributes = []): Insight
    {
        $category = InsightCategory::query()->firstOrCreate(['slug' => 'seo'], ['name' => 'SEO']);

        return Insight::query()->create(array_replace([
            'user_id' => User::factory()->create()->id,
            'category_id' => $category->id,
            'slug' => 'seo-keyword-view-fixture',
            'title' => '구조화 데이터 테스트',
            'meta_title' => '구조화 데이터 테스트',
            'meta_description' => '검색 설명문 테스트입니다.',
            'excerpt' => '인사이트 테스트 요약입니다.',
            'content' => '<h2>기존 본문</h2><p>FAQ가 없는 글입니다.</p>',
            'published_at' => now()->subDays(2),
            'updated_at' => now()->subDay(),
        ], $attributes))->fresh();
    }

    private function insightPath(Insight $insight): string
    {
        return '/insights/'.rawurlencode($insight->slug);
    }

    private function page(string $path): string
    {
        return $this->get(self::PUBLIC_URL.$path)->assertOk()->getContent();
    }

    private function canonical(string $html): string
    {
        $xpath = $this->html($html);
        $this->assertSame(1, $xpath->query('//head/link[@rel="canonical"]')->length);

        return $xpath->evaluate('string(//head/link[@rel="canonical"]/@href)');
    }

    private function jsonBlocks(string $html): array
    {
        preg_match_all('~<script\b[^>]*\btype=["\']application/ld\+json["\'][^>]*>(.*?)</script\s*>~is', $html, $matches);
        $this->assertNotEmpty($matches[1]);
        $this->assertSame(count($matches[1]), $this->html($html)->query('//script[@type="application/ld+json"]')->length);

        return $matches[1];
    }

    private function schemas(string $html, string $type): array
    {
        $nodes = [];
        foreach ($this->jsonBlocks($html) as $json) {
            $document = json_decode($json, true, flags: JSON_THROW_ON_ERROR);
            $this->assertIsArray($document);
            $this->assertSame('https://schema.org', $document['@context']);
            foreach ($document['@graph'] ?? [$document] as $node) {
                if (in_array($type, (array) ($node['@type'] ?? []), true)) {
                    $nodes[] = $node;
                }
            }
        }

        return $nodes;
    }

    private function oneSchema(string $html, string $type): array
    {
        $nodes = $this->schemas($html, $type);
        $this->assertCount(1, $nodes, $type.' must occur exactly once');

        return $nodes[0];
    }

    private function normalize(string $text): string
    {
        return trim(preg_replace('/\s+/u', ' ', $text));
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
