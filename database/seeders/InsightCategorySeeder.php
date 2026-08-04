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
            // 구버전 칼럼 이관용 카테고리
            ['slug' => 'facebook', 'name' => '페이스북 마케팅'],
            ['slug' => 'instagram', 'name' => '인스타그램 마케팅'],
            ['slug' => 'google-ads', 'name' => '구글 광고'],
            ['slug' => 'youtube', 'name' => '유튜브 마케팅'],
            ['slug' => 'content-marketing', 'name' => '콘텐츠 마케팅'],
            ['slug' => 'branding', 'name' => '브랜딩'],
            ['slug' => 'news', 'name' => '뉴스·소식'],
            ['slug' => 'link-building', 'name' => '링크 빌딩'],
        ];

        foreach ($categories as $category) {
            InsightCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            );
        }
    }
}
