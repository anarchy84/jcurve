<?php

namespace App\Services\Seo\Publishing;

use DOMDocument;
use DOMElement;
use Illuminate\Support\Str;

class FeedXml
{
    public function __construct(private PublicUrl $urls) {}

    public function rss(array $items): string
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $rss = $xml->appendChild($xml->createElement('rss'));
        $rss->setAttribute('version', '2.0');
        $channel = $rss->appendChild($xml->createElement('channel'));
        $this->text($xml, $channel, 'title', config('seo.feed_title'));
        $this->text($xml, $channel, 'link', $this->urls->absolute('/insights'));
        $this->text($xml, $channel, 'description', config('seo.feed_description'));
        $this->text($xml, $channel, 'language', 'ko');
        $self = $channel->appendChild($xml->createElementNS('http://www.w3.org/2005/Atom', 'atom:link'));
        $self->setAttribute('href', $this->urls->absolute('/rss'));
        $self->setAttribute('rel', 'self');
        $self->setAttribute('type', 'application/rss+xml');

        foreach ($items as $entry) {
            $insight = $entry['insight'];
            $item = $channel->appendChild($xml->createElement('item'));
            $this->text($xml, $item, 'title', $insight->title);
            $this->text($xml, $item, 'link', $entry['url']);
            $guid = $this->text($xml, $item, 'guid', $entry['url']);
            $guid->setAttribute('isPermaLink', 'true');
            $summary = html_entity_decode(strip_tags($insight->excerpt ?: $insight->content), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $this->text($xml, $item, 'description', Str::limit($summary, 500));
            $this->text($xml, $item, 'pubDate', $insight->published_at->toRssString());
        }

        return $xml->saveXML();
    }

    private function text(DOMDocument $xml, DOMElement $parent, string $name, ?string $value): DOMElement
    {
        $node = $parent->appendChild($xml->createElement($name));
        // XML 1.0에서 허용되지 않는 제어문자만 제거한다. HTML은 출력하지 않는다.
        $safe = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', $value ?? '') ?? '';
        $node->appendChild($xml->createTextNode($safe));

        return $node;
    }
}
