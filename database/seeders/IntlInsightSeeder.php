<?php

namespace Database\Seeders;

use App\Models\Insight;
use Illuminate\Database\Seeder;
use UnexpectedValueException;

class IntlInsightSeeder extends Seeder
{
    public function run(?string $directory = null): void
    {
        $files = glob(($directory ?? database_path('content/intl/insights')).'/*.json') ?: [];
        sort($files);
        foreach ($files as $file) {
            $data = json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
            $insight = Insight::query()->where('slug', $data['ko_slug'] ?? '')->first();
            if (! $insight) {
                $this->command?->warn('INTL skipped missing ko_slug: '.($data['ko_slug'] ?? basename($file)));

                continue;
            }
            if (! preg_match('/^[a-f0-9]{64}$/', $data['source_hash'] ?? '')) {
                throw new UnexpectedValueException('Invalid source_hash: '.basename($file));
            }
            foreach (['en', 'ja'] as $locale) {
                if (! isset($data[$locale])) {
                    continue;
                }
                $payload = $data[$locale];
                foreach (['slug', 'title', 'content'] as $field) {
                    if (! is_string($payload[$field] ?? null) || trim($payload[$field]) === '') {
                        throw new UnexpectedValueException("Invalid {$locale}.{$field}: ".basename($file));
                    }
                }
                if (! preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $payload['slug'])) {
                    throw new UnexpectedValueException('Translation slug must use lowercase ASCII words and hyphens.');
                }
                $values = array_intersect_key($payload, array_flip(['slug', 'title', 'excerpt', 'content', 'meta_title', 'meta_description']));
                $values['source_hash'] = $data['source_hash'];
                $translation = $insight->translations()->firstOrNew(['locale' => $locale]);
                $translation->fill($values);
                if (! $translation->exists || $translation->isDirty()) {
                    $translation->translated_at = now();
                    $translation->save();
                }
            }
        }
    }
}
