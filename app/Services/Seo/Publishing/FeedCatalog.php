<?php

namespace App\Services\Seo\Publishing;

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Models\SeoMeta;
use App\Models\Work;
use Illuminate\Support\Collection;

class FeedCatalog
{
    public function __construct(private PublicUrl $urls) {}

    /** @return array<string, list<array{url: string, modified: mixed}>> */
    public function sections(): array
    {
        $meta = $this->metadata();
        $sections = ['pages' => [], 'services' => [], 'insights' => [], 'works' => []];

        foreach (['pages', 'services'] as $section) {
            $paths = config("seo.{$section}", []);
            if ($section === 'services') {
                foreach (config('seo.subpage_prefixes', []) as $group => $prefix) {
                    foreach (array_keys(config("subpages.{$group}.items", [])) as $slug) {
                        $paths[] = $prefix.'/'.rawurlencode($slug);
                    }
                }
            }
            foreach (array_unique($paths) as $path) {
                if ($this->indexable($path, $meta)) {
                    $sections[$section][] = ['url' => $this->urls->absolute($path), 'modified' => null];
                }
            }
        }

        foreach (InsightCategory::query()->whereHas('insights', fn ($query) => $query->published())->get() as $category) {
            $path = '/insights/category/'.rawurlencode($category->slug);
            if ($this->indexable($path, $meta)) {
                $sections['pages'][] = ['url' => $this->urls->absolute($path), 'modified' => null];
            }
        }

        foreach (Insight::query()->published()->orderBy('id')->cursor() as $insight) {
            $path = $this->insightPath($insight);
            if ($this->indexable($path, $meta)) {
                $modified = $insight->published_at;
                if (! $insight->source_url && $insight->updated_at?->lte(now()) && $insight->updated_at->gt($modified)) {
                    $modified = $insight->updated_at;
                }
                $sections['insights'][] = [
                    'url' => $this->urls->absolute($path),
                    'modified' => $modified,
                ];
            }
        }

        foreach (Work::query()->published()->orderBy('id')->cursor() as $work) {
            $path = '/work/'.rawurlencode($work->slug);
            if ($this->indexable($path, $meta)) {
                $sections['works'][] = ['url' => $this->urls->absolute($path), 'modified' => $work->published_at];
            }
        }

        return $sections;
    }

    /** @return list<array{insight: Insight, url: string}> */
    public function latestInsights(): array
    {
        $meta = $this->metadata();
        $limit = max(1, min(50, (int) config('seo.rss_limit', 50)));
        $items = [];

        foreach (Insight::query()->published()->latest('published_at')->latest('id')->cursor() as $insight) {
            $path = $this->insightPath($insight);
            if ($this->indexable($path, $meta)) {
                $items[] = ['insight' => $insight, 'url' => $this->urls->absolute($path)];
                if (count($items) >= $limit) {
                    break;
                }
            }
        }

        return $items;
    }

    public function pageSize(): int
    {
        return max(1, min(50000, (int) config('seo.sitemap_page_size', 1000)));
    }

    private function insightPath(Insight $insight): string
    {
        return '/insights/'.rawurlencode($insight->slug);
    }

    private function metadata(): Collection
    {
        return SeoMeta::query()->get()->keyBy(fn ($meta) => $this->key($meta->path));
    }

    private function indexable(string $path, Collection $metadata): bool
    {
        $meta = $metadata->get($this->key($path));
        if ($meta === null) {
            return true;
        }
        if (preg_match('/(?:^|[\s,])(?:noindex|none)(?:$|[\s,])/i', $meta->robots ?? '')) {
            return false;
        }

        return empty($meta->canonical) || $this->urls->canonicalMatches($meta->canonical, $this->urls->absolute($path));
    }

    private function key(string $path): string
    {
        return trim(PublicUrl::comparisonKey($path), '/');
    }
}
