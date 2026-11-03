<?php

namespace Tests;

use Database\Seeders\IntlInsightSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Uri;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Other sessions write production translations concurrently. Tests never
        // read those files; UsesIntlFixture replaces this binding with test data.
        $this->app->bindMethod([IntlInsightSeeder::class, 'run'], fn () => null);
    }

    // Requests must reach the kernel verbatim: Laravel's helper otherwise uses
    // our production URL generator and strips the final slash before sending.
    protected function prepareUrlForRequest($uri)
    {
        $uri = $uri instanceof Uri ? $uri->value() : $uri;
        $uri = preg_replace_callback('/[\x80-\xff]/', fn ($match) => rawurlencode($match[0]), $uri);

        return str_starts_with($uri, '/') ? 'http://localhost'.$uri : $uri;
    }
}
