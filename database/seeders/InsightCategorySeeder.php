<?php

namespace Database\Seeders;

use App\Models\InsightCategory;
use Illuminate\Database\Seeder;

class InsightCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'seo', 'name' => 'SEO'],
            ['slug' => 'performance-marketing', 'name' => '퍼포먼스 마케팅'],
            ['slug' => 'cpa', 'name' => 'CPA 마케팅'],
            ['slug' => 'reward', 'name' => '리워드 네트워크'],
            ['slug' => 'wordpress', 'name' => '워드프레스'],
        ];

        foreach ($categories as $category) {
            InsightCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            );
        }
    }
}
