<?php

namespace Database\Seeders;

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Models\LegacyRedirect;
use App\Models\User;
use App\Services\Seo\Publishing\PreservedPaths;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class LegacyContentSeeder extends Seeder
{
    /** @var array<string, string> 운영 WP 글 3편의 설명문 (SEO-META-02) */
    private const WP_META_DESCRIPTIONS = [
        'chrome-및-firefox에서-nofollow-링크를-확인하는-방법' => '웹사이트로의 링크빌딩(Links Building) 할 때 , 링크에 nofollow 속성이 없는지 확인하는 것이 매우 중요합니다 .',
        '11가지-최고의-seo-실수와-이를-피하는-방법' => 'Google은 지속적으로 알고리즘을 업데이트하기 위해 노력하고 있습니다.',
        '경쟁자를-압도하는-6가지-고급-링크-구축-전략' => '몇 년 후의 웹사이트를 상상해보세요. 미친 듯이 노력한다면 검색 엔진 트래픽이 늘어나고, 백링크와 참조 도메인이 늘어나고, 전환율이 높아지기를 바랄 것입니다.',
    ];

    /** @var array<int, string> 이미 사용한 슬러그(중복 방지) */
    private array $usedSlugs = [];

    public function run(): void
    {
        $this->usedSlugs = [];
        // insights.user_id는 NOT NULL — 콘텐츠 소유 관리자 계정 확보
        $author = User::query()->firstOrCreate(
            ['email' => 'jcurve19@gmail.com'],
            [
                'name' => '제이커브인터렉티브',
                'nickname' => 'jcurve',
                'password' => bcrypt(Str::random(32)),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );

        $newsCategoryId = InsightCategory::query()->where('slug', 'news')->value('id');

        $this->seedColumns($author->id, $newsCategoryId);
        $this->seedWpPosts($author->id);
    }

    /** 구버전 그누보드 칼럼 50편 이식 */
    private function seedColumns(int $authorId, int $newsCategoryId): void
    {
        $dir = database_path('content/legacy/columns');
        $files = glob($dir.'/*.json') ?: [];
        sort($files);

        $baseDate = Carbon::parse('2019-01-01');
        $i = 0;

        foreach ($files as $file) {
            $data = json_decode((string) file_get_contents($file), true);
            if (! is_array($data) || empty($data['title'])) {
                continue;
            }

            $wrId = $this->parseWrId($data['source_url'] ?? '');
            $slug = $this->uniqueSlug($data['slug'] ?? Str::slug($data['title']));
            $categoryId = $this->resolveCategory($data['title'], $data['category'] ?? null, $newsCategoryId);
            $publishedAt = $this->parseDate($data['date_raw'] ?? '') ?? $baseDate->copy()->addDays($i);

            $insight = Insight::query()->updateOrCreate(
                $wrId !== null ? ['legacy_wr_id' => $wrId] : ['slug' => $slug],
                [
                    'user_id' => $authorId,
                    'category_id' => $categoryId,
                    'title' => $data['title'],
                    'slug' => $slug,
                    'content' => $data['html'] ?? '',
                    'excerpt' => Str::limit(trim(strip_tags($data['html'] ?? '')), 150),
                    'legacy_wr_id' => $wrId,
                    'source_url' => $data['source_url'] ?? null,
                    'published_at' => $publishedAt,
                ],
            );

            // 리다이렉트 자동 등록: 게시판 쿼리형 + 프리티 URL 형 모두
            if ($wrId !== null) {
                $this->registerRedirect(
                    LegacyRedirect::buildQueryKey('v1/manager/bbs/board.php', [
                        'bo_table' => 'column',
                        'wr_id' => (string) $wrId,
                    ]),
                    $this->columnDestination($slug),
                );
            }
            $this->registerRedirect('v1/manager/column/'.$slug, $this->columnDestination($slug));

            $i++;
        }
    }

    /** 워드프레스 색인 아티클 3편 이식 (슬러그 원형 유지) */
    private function seedWpPosts(int $authorId): void
    {
        $dir = database_path('content/legacy/wp-posts');
        $files = glob($dir.'/*.json') ?: [];
        sort($files);

        $seoCategoryId = InsightCategory::query()->where('slug', 'seo')->value('id');

        foreach ($files as $file) {
            $data = json_decode((string) file_get_contents($file), true);
            if (! is_array($data) || empty($data['title'])) {
                continue;
            }

            $slug = $this->uniqueSlug($data['slug'] ?? Str::slug($data['title']));
            $publishedAt = $this->parseDate($data['published'] ?? '') ?? now();
            $content = $data['html'] ?? '';
            $metadata = [];

            if (isset(self::WP_META_DESCRIPTIONS[$slug])) {
                $data['title'] = Str::beforeLast($data['title'], ' - SEO 전문 컨설팅 기업 | 제이커브인터렉티브');
                $content = $this->wpArticleContent($content);
                $metadata = [
                    'meta_title' => $data['title'].' - SEO 전문 컨설팅 기업',
                    'meta_description' => self::WP_META_DESCRIPTIONS[$slug],
                ];
            }

            Insight::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $authorId,
                    'category_id' => $seoCategoryId,
                    'title' => $data['title'],
                    'slug' => $slug,
                    'content' => $content,
                    'excerpt' => Str::limit($this->wpExcerpt($content), 150),
                    'cover_image' => $data['og_image'] ?? null,
                    'source_url' => $data['source_url'] ?? null,
                    'published_at' => $publishedAt,
                    ...$metadata,
                ],
            );

            // The three original WP addresses now render directly.
            LegacyRedirect::query()->where('from_path', LegacyRedirect::normalizePath('seo/'.$slug))->delete();
        }
    }

    private function wpArticleContent(string $html): string
    {
        // Keep the original hero image and article bytes, excluding Avada's
        // banner/title/byline before them and category/share/sidebar widgets after.
        if (! preg_match('~(<div\b[^>]*\bclass="fusion-image-element\b.*?)(?=<div\b[^>]*\bclass="fusion-meta-tb fusion-meta-tb-2\b)~s', $html, $matches)) {
            throw new \UnexpectedValueException('Legacy WP article boundaries were not found.');
        }

        return preg_replace('~(<\s*/?\s*)h1(?=[\s>])~i', '$1h2', $matches[1]);
    }

    private function wpExcerpt(string $html): string
    {
        $text = preg_replace('~</(?:p|h[1-6]|li|div)>|<br\b[^>]*>~i', ' ', $html);
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $text));
    }

    private function parseWrId(string $url): ?int
    {
        if (preg_match('/wr_id=(\d+)/', $url, $m)) {
            return (int) $m[1];
        }

        return null;
    }

    private function parseDate(string $raw): ?Carbon
    {
        $raw = trim($raw);
        if ($raw === '') {
            return null;
        }
        try {
            return Carbon::parse($raw);
        } catch (\Throwable) {
            return null;
        }
    }

    /** 제목·원본 카테고리로 insight_categories slug 매핑 */
    private function resolveCategory(string $title, ?string $rawCategory, int $newsCategoryId): int
    {
        $map = [
            '퍼포먼스마케팅' => 'performance-marketing',
            '페이스북' => 'facebook',
            '인스타그램' => 'instagram',
            '구글' => 'google-ads',
            '콘텐츠마케팅' => 'content-marketing',
            '브랜딩' => 'branding',
        ];

        // 브랜드 소식 키워드 → news
        foreach (['제이커브', '론칭', '인증', '설립', '상표', 'CRMPRO', '연구소', '마이인플루언서'] as $kw) {
            if (str_contains($title, $kw)) {
                return $newsCategoryId;
            }
        }

        // 원본 카테고리 우선
        if ($rawCategory !== null && isset($map[$rawCategory])) {
            return $this->categoryId($map[$rawCategory], $newsCategoryId);
        }

        // 제목 키워드 추론
        $titleKeywords = [
            '페이스북' => 'facebook',
            '인스타그램' => 'instagram',
            '유튜브' => 'youtube',
            '구글' => 'google-ads',
            '콘텐츠' => 'content-marketing',
            '브랜딩' => 'branding',
            'cpa' => 'cpa',
            'seo' => 'seo',
            '스마트스토어' => 'seo',
        ];
        $lower = mb_strtolower($title);
        foreach ($titleKeywords as $kw => $slug) {
            if (str_contains($lower, mb_strtolower($kw))) {
                return $this->categoryId($slug, $newsCategoryId);
            }
        }

        return $this->categoryId('performance-marketing', $newsCategoryId);
    }

    private function categoryId(string $slug, int $fallback): int
    {
        return InsightCategory::query()->where('slug', $slug)->value('id') ?? $fallback;
    }

    private function uniqueSlug(string $slug): string
    {
        $slug = trim($slug, '-') ?: 'insight';
        $candidate = $slug;
        $n = 2;
        while (in_array($candidate, $this->usedSlugs, true)) {
            $candidate = $slug.'-'.$n;
            $n++;
        }
        $this->usedSlugs[] = $candidate;

        return $candidate;
    }

    private function registerRedirect(string $from, string $to): void
    {
        LegacyRedirect::query()->updateOrCreate(
            ['from_path' => LegacyRedirect::normalizePath($from)],
            ['to_path' => PreservedPaths::path($to), 'status_code' => 301],
        );
    }

    private function columnDestination(string $slug): string
    {
        return in_array($slug, config('seo.hidden_insights', []), true) ? '/blog/' : '/insights/'.$slug;
    }
}
