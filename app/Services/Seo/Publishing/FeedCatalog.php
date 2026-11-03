<?php

namespace App\Services\Seo\Publishing;

use App\Models\Insight;
use App\Models\InsightCategory;
use App\Models\InsightTranslation;
use App\Models\SeoMeta;
use App\Models\Work;
use App\Support\IntlRoutes;
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

        foreach (InsightCategory::query()->whereHas('insights', fn ($query) => $query->published())
            ->orWhereIn('slug', ['seo', 'link-building'])->get() as $category) {
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

        // Append only: Korean entries keep their original bytes and order.
        foreach (['en', 'ja'] as $locale) {
            foreach (IntlRoutes::variants() as $variant) {
                if (! IntlRoutes::available($variant['name'], $variant['parameters'], $locale)) {
                    continue;
                }
                $path = route($locale.'.'.$variant['name'], $variant['parameters'], false);
                if ($this->indexable($variant['path'], $meta) && $this->indexable($path, $meta)) {
                    $section = str_starts_with($variant['name'], 'services.') || str_starts_with($variant['name'], 'solutions.') ? 'services' : 'pages';
                    $sections[$section][] = ['url' => $this->urls->absolute($path), 'modified' => null];
                }
            }
            foreach (InsightCategory::query()->whereHas('insights', fn ($query) => $query->published()
                ->whereHas('translations', fn ($query) => $query->where('locale', $locale)))->get() as $category) {
                $path = route($locale.'.insights.category', ['slug' => $category->slug], false);
                if (IntlRoutes::available('insights.category', ['slug' => $category->slug], $locale) && $this->indexable($path, $meta)) {
                    $sections['pages'][] = ['url' => $this->urls->absolute($path), 'modified' => null];
                }
            }
            foreach (InsightTranslation::query()->where('locale', $locale)
                ->whereHas('insight', fn ($query) => $query->published())->with('insight')->orderBy('insight_id')->cursor() as $translation) {
                $path = route($locale.'.insights.show', ['slug' => $translation->slug], false);
                if (IntlRoutes::available('insights.show', ['slug' => $translation->slug], $locale) && $this->indexable($this->insightPath($translation->insight), $meta) && $this->indexable($path, $meta)) {
                    $sections['insights'][] = ['url' => $this->urls->absolute($path), 'modified' => $translation->translated_at];
                }
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
        return trim(PublicUrl::comparisonKey(PreservedPaths::path($path)), '/');
    }
}
