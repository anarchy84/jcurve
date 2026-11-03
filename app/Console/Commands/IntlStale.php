<?php

namespace App\Console\Commands;

use App\Models\InsightTranslation;
use Illuminate\Console\Command;

class IntlStale extends Command
{
    protected $signature = 'intl:stale';

    protected $description = 'List translations whose Korean display content has changed';

    public function handle(): int
    {
        $rows = [];
        foreach (InsightTranslation::query()->with('insight')->orderBy('insight_id')->orderBy('locale')->cursor() as $translation) {
            $current = hash('sha256', (string) $translation->insight->content);
            if (! hash_equals($translation->source_hash, $current)) {
                $rows[] = [$translation->insight->slug, $translation->locale, $translation->slug, $translation->source_hash, $current];
            }
        }
        $this->table(['ko_slug', 'locale', 'translation_slug', 'source_hash', 'current_hash'], $rows);
        $this->info('Stale translations: '.count($rows));

        return self::SUCCESS;
    }
}
