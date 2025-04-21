<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class GetPostTranslationsTest extends TestCase
{
    public function testGetPostTranslationsWorks(): void
    {
        $successBody = file_get_contents(__DIR__.'/fixtures/get_post_translations.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector('', '');
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->getTranslations(123);

        $this->assertIsArray($result);
        $this->assertGreaterThan(0, count($result));
    }
}
