<?php

namespace App\Http\Controllers;

use App\Services\Seo\Publishing\FeedCatalog;
use App\Services\Seo\Publishing\FeedXml;
use App\Services\Seo\Publishing\PublicUrl;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SeoFeedController extends Controller
{
    public function index(FeedCatalog $catalog, PublicUrl $urls): Response
    {
        $index = SitemapIndex::create();
        foreach ($catalog->sections() as $section => $entries) {
            for ($page = 1; $page <= max(1, (int) ceil(count($entries) / $catalog->pageSize())); $page++) {
                $index->add($urls->absolute("/sitemaps/{$section}/{$page}.xml"));
            }
        }

        return $this->xml($index->render(), 'application/xml');
    }

    public function section(string $section, string $page, FeedCatalog $catalog): Response
    {
        $sections = $catalog->sections();
        abort_unless(isset($sections[$section]), 404);
        $entries = $sections[$section];
        $pages = max(1, (int) ceil(count($entries) / $catalog->pageSize()));
        abort_if(strlen($page) > 9 || (int) $page < 1 || (int) $page > $pages, 404);
        $sitemap = Sitemap::create();

        foreach (array_slice($entries, ((int) $page - 1) * $catalog->pageSize(), $catalog->pageSize()) as $entry) {
            $tag = Url::create($entry['url']);
            if ($entry['modified'] !== null) {
                $tag->setLastModificationDate($entry['modified']);
            }
            $sitemap->add($tag);
        }

        return $this->xml($sitemap->render(), 'application/xml');
    }

    public function rss(FeedCatalog $catalog, FeedXml $xml): Response
    {
        return $this->xml($xml->rss($catalog->latestInsights()), 'application/rss+xml');
    }

    private function xml(string $body, string $type): Response
    {
        return response($body, 200, [
            'Content-Type' => $type.'; charset=UTF-8',
            'Cache-Control' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
