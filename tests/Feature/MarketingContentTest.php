<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Honeypot\ProtectAgainstSpam;
use Tests\TestCase;

class MarketingContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_marketing_pages_render(): void
    {
        $paths = [
            '/services',
            '/services/performance-marketing',
            '/services/cpa-marketing',
            '/services/reward-network',
            '/services/seo',
            '/services/seo/aeo',
            '/services/seo/geo',
            '/services/wordpress',
            '/services/marketing-support',
            '/solutions',
            '/solutions/rankfree',
            '/solutions/boostingshop',
            '/solutions/leadbay',
            '/solutions/call2sale',
            '/company',
            '/contact',
            '/work',
        ];

        foreach ($paths as $path) {
            $response = $this->get($path)->assertOk();

            $this->assertGreaterThanOrEqual(5, substr_count($response->getContent(), '<section'));
        }
    }

    public function test_all_configured_subpages_render(): void
    {
        $paths = [
            '/services/seo/backlinks',
            '/services/seo/naver-place',
            '/services/seo/naver-shopping',
            '/services/seo/kakao-gift',
            '/services/seo/coupang',
            '/services/cpa-marketing/real-estate',
            '/services/cpa-marketing/stock',
            '/services/cpa-marketing/insurance',
            '/services/cpa-marketing/coin',
            '/services/cpa-marketing/permission-call',
            '/services/performance-marketing/naver-gfa',
            '/services/performance-marketing/facebook',
            '/services/performance-marketing/youtube',
            '/solutions/boostingshop/basic',
            '/solutions/boostingshop/pro',
            '/solutions/boostingshop/elite',
            '/solutions/boostingshop/instagram-popular',
            '/solutions/boostingshop/instagram-followers',
            '/solutions/boostingshop/instagram-likes',
        ];

        foreach ($paths as $path) {
            $response = $this->get($path)->assertOk();

            $this->assertGreaterThanOrEqual(8, substr_count($response->getContent(), '<section'));
            $this->assertGreaterThanOrEqual(3, substr_count($response->getContent(), '<details class="faq__item"'));
        }
    }

    public function test_reward_inquiry_paths_prefill_distinct_roles(): void
    {
        $this->get('/contact?service_interest=reward-advertiser')
            ->assertOk()
            ->assertSee('value="reward-advertiser" selected', false);

        $this->get('/contact?service_interest=reward-publisher')
            ->assertOk()
            ->assertSee('value="reward-publisher" selected', false);
    }

    public function test_reward_inquiry_roles_are_accepted_and_stored(): void
    {
        $this->withoutMiddleware(ProtectAgainstSpam::class);

        foreach (['reward-advertiser', 'reward-publisher'] as $role) {
            $this->post('/contact', [
                'name' => '테스트 담당자',
                'company' => '테스트 회사',
                'email' => $role.'@example.com',
                'phone' => '02-0000-0000',
                'service_interest' => $role,
                'message' => '리워드 문의 역할 분기 저장을 확인합니다.',
            ])->assertRedirect(route('contact'));

            $this->assertDatabaseHas('leads', ['service_interest' => $role]);
        }
    }

    public function test_reward_page_contains_advertiser_and_publisher_decision_content(): void
    {
        $response = $this->get('/services/reward-network')
            ->assertOk()
            ->assertSee('광고주 캠페인')
            ->assertSee('매체 제휴')
            ->assertSee('품질은 ‘느낌’이 아니라 승인 규칙으로 관리합니다')
            ->assertSee('매체 검토부터 운영 안정화까지')
            ->assertDontSee('캠페인이 마르지 않습니다')
            ->assertDontSee('버즈빌')
            ->assertDontSee('NBT');

        $this->assertGreaterThanOrEqual(15, substr_count($response->getContent(), '<section'));
    }

    public function test_instagram_guides_do_not_sell_artificial_engagement(): void
    {
        $expectations = [
            '/solutions/boostingshop/instagram-popular' => '특정 인기게시물 위치·기간이나 인위적 반응을 판매·접수하지 않습니다',
            '/solutions/boostingshop/instagram-followers' => '인위적인 팔로워 수량을 판매·접수하지 않습니다',
            '/solutions/boostingshop/instagram-likes' => '인위적인 좋아요 수량을 판매·접수하지 않습니다',
        ];

        foreach ($expectations as $path => $statement) {
            $this->get($path)
                ->assertOk()
                ->assertSee($statement)
                ->assertDontSee('실제 한국인 계정과 똑같')
                ->assertDontSee('구매 수만큼');
        }
    }

    public function test_insurance_page_reuses_the_full_legacy_decision_journey(): void
    {
        $response = $this->get('/services/cpa-marketing/insurance')
            ->assertOk()
            ->assertSee('보험디비 — 동의부터 미팅·AS·영업관리까지')
            ->assertSee('퍼미션 DB는 체크박스가 아니라, 고객이 예상한 연락입니다')
            ->assertSee('일반 랜딩 신청 DB')
            ->assertSee('유효·무효·AS는 사례가 생기기 전에 정합니다')
            ->assertSee('리드베이에서 이어서 관리합니다')
            ->assertSee('콜투세일로 이어집니다')
            ->assertSee('href="/solutions/leadbay"', false)
            ->assertSee('href="/solutions/call2sale"', false)
            ->assertSee('service_interest=cpa-insurance', false)
            ->assertSee('2026년 기준 · 제이커브 회사 전체 누적', false)
            ->assertDontSee('제이커브인터렉티브가 유일합니다')
            ->assertDontSee('최고 매출을 실현')
            ->assertDontSee('가입미팅율 50% 이상')
            ->assertDontSee('전환률 5%')
            ->assertDontSee('한 번 제공된 DB는 폐기처분');

        $content = $response->getContent();

        $this->assertGreaterThanOrEqual(18, substr_count($content, '<section'));
        $this->assertGreaterThanOrEqual(10, substr_count($content, '<details class="faq__item"'));

        foreach (['insurance-overview', 'permission-db', 'insurance-process', 'insurance-quality', 'leadbay-operations', 'insurance-compliance', 'faq'] as $id) {
            $this->assertStringContainsString('href="#'.$id.'"', $content);
            $this->assertStringContainsString('id="'.$id.'"', $content);
        }
    }

    public function test_insurance_faq_schema_matches_visible_faq_count(): void
    {
        $content = $this->get('/services/cpa-marketing/insurance')->assertOk()->getContent();
        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $content, $matches);

        $faqSchema = collect($matches[1] ?? [])
            ->map(fn ($json) => json_decode($json, true))
            ->first(fn ($schema) => is_array($schema) && ($schema['@type'] ?? null) === 'FAQPage');

        $this->assertIsArray($faqSchema);
        $this->assertCount(
            substr_count($content, '<details class="faq__item"'),
            $faqSchema['mainEntity'] ?? [],
        );
    }

    public function test_insurance_inquiry_is_prefilled_and_stored(): void
    {
        $this->get('/contact?service_interest=cpa-insurance&message=insurance')
            ->assertOk()
            ->assertSee('value="cpa-insurance" selected', false)
            ->assertSee('insurance');

        $this->withoutMiddleware(ProtectAgainstSpam::class);

        $this->post('/contact', [
            'name' => '보험 문의 담당자',
            'company' => '테스트 GA',
            'email' => 'insurance@example.com',
            'phone' => '02-0000-0000',
            'service_interest' => 'cpa-insurance',
            'message' => '보험 CPA·퍼미션 DB 문의 저장을 확인합니다.',
        ])->assertRedirect(route('contact'));

        $this->assertDatabaseHas('leads', ['service_interest' => 'cpa-insurance']);
    }
}
