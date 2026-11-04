<?php

namespace Database\Seeders;

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Models\LegacyRedirect;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class KeywordInsightSeeder extends Seeder
{
    private const DUPLICATE_SLUG = '2019년-그로스해커에게-필요한-스킬3-1';

    private const CANONICAL_SLUG = '2019년-그로스해커에게-필요한-스킬3';

    public function run(): void
    {
        $directory = database_path('content/kw01');
        $articles = json_decode(file_get_contents($directory.'/manifest.json'), true, flags: JSON_THROW_ON_ERROR);
        $descriptions = json_decode(file_get_contents($directory.'/insight-meta.json'), true, flags: JSON_THROW_ON_ERROR);
        $categories = InsightCategory::query()->pluck('id', 'slug');

        // Resolve all dependencies before changing any existing content.
        foreach ($articles as &$article) {
            if (! $categories->has($article['category_slug'])) {
                throw new RuntimeException('Missing insight category: '.$article['category_slug']);
            }

            $content = file_get_contents($directory.'/'.$article['file']);
            if ($content === false) {
                throw new RuntimeException('Cannot read keyword article: '.$article['file']);
            }
            $article['content'] = $content;
        }
        unset($article);

        [$updated, $skipped] = DB::transaction(function () use ($articles, $descriptions, $categories): array {
            $publishedAt = Carbon::parse('2026-11-04 10:00:00', 'Asia/Seoul')
                ->setTimezone(config('app.timezone'));

            foreach ($articles as $article) {
                Insight::query()->updateOrCreate(['slug' => $article['slug']], [
                    'title' => $article['title'],
                    'excerpt' => $article['excerpt'],
                    'content' => $article['content'],
                    'meta_title' => $article['meta_title'],
                    'meta_description' => $article['meta_description'],
                    'category_id' => $categories->get($article['category_slug']),
                    'published_at' => $publishedAt,
                    'user_id' => null,
                ]);
            }

            $updated = 0;
            $skipped = 0;
            foreach ($descriptions as $description) {
                $query = DB::table('insights')->where('slug', $description['slug']);
                if (! $query->exists()) {
                    $skipped++;

                    continue;
                }

                // Query builder deliberately leaves updated_at and all other fields untouched.
                $query->update(['meta_description' => $description['meta_description']]);
                $updated++;
            }

            $this->hideDuplicate();

            return [$updated, $skipped];
        });

        $this->command?->info('Keyword insights upserted: '.count($articles));
        $this->command?->info("Insight descriptions updated: {$updated}; missing slugs skipped: {$skipped}");
    }

    private function hideDuplicate(): void
    {
        DB::table('insights')->where('slug', self::DUPLICATE_SLUG)->update(['published_at' => null]);

        $duplicatePath = '/insights/'.self::DUPLICATE_SLUG;
        $canonicalPath = '/insights/'.self::CANONICAL_SLUG;
        $localHosts = [...config('seo.legacy_hosts', []), parse_url(config('seo.public_url'), PHP_URL_HOST)];

        foreach (LegacyRedirect::query()->cursor() as $redirect) {
            $target = parse_url($redirect->to_path);
            if ($target === false || (isset($target['host']) && ! in_array($target['host'], $localHosts, true))) {
                continue;
            }
            if (LegacyRedirect::normalizePath($target['path'] ?? '') === LegacyRedirect::normalizePath($duplicatePath)) {
                $redirect->update(['to_path' => $canonicalPath, 'status_code' => 301]);
            }
        }

        LegacyRedirect::query()->updateOrCreate(
            ['from_path' => LegacyRedirect::normalizePath($duplicatePath)],
            ['to_path' => $canonicalPath, 'status_code' => 301],
        );
    }
}
