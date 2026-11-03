<?php

namespace Tests\Support;

use App\Models\Insight;
use Database\Seeders\IntlInsightSeeder;
use Illuminate\Support\Facades\File;

trait UsesIntlFixture
{
    private ?string $intlFixtureDirectory = null;

    private function isolateIntlSeeder(): void
    {
        $this->intlFixtureDirectory = sys_get_temp_dir().'/intl-fixture-'.bin2hex(random_bytes(8));
        File::ensureDirectoryExists($this->intlFixtureDirectory);
        $this->app->bindMethod([IntlInsightSeeder::class, 'run'], function ($seeder) {
            $article = Insight::query()->where('slug', '반드시-알아야-할-모바일-마케팅-전략-5가지')->first();
            if ($article && ! File::exists($this->intlFixtureDirectory.'/sample.json')) {
                $data = ['ko_slug' => $article->slug, 'source_hash' => hash('sha256', $article->content)];
                foreach (['en', 'ja'] as $locale) {
                    $data[$locale] = [
                        'slug' => 'mobile-marketing-strategies'.($locale === 'ja' ? '-ja' : ''),
                        'title' => $locale === 'en' ? '[EN DRAFT] Five mobile marketing strategies' : 'モバイルマーケティングの5つの戦略',
                        'excerpt' => $locale === 'en' ? 'Five strategies for mobile marketing.' : 'モバイルマーケティングの五つの戦略を紹介します。',
                        'content' => '<h2>Mobile marketing</h2><p>Five strategies for mobile marketing.</p>',
                    ];
                }
                File::put($this->intlFixtureDirectory.'/sample.json', json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR));
            }
            $seeder->run($this->intlFixtureDirectory);
        });
    }

    private function removeIntlFixture(): void
    {
        if ($this->intlFixtureDirectory !== null) {
            File::deleteDirectory($this->intlFixtureDirectory);
        }
    }
}
