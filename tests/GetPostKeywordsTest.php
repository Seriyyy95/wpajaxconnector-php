<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class GetPostKeywordsTest extends TestCase
{
    public function testGetPostKeywordsWorks(): void
    {
        $successBody = file_get_contents(__DIR__.'/fixtures/get_post_keywords.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector('', '');
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->getKeywords(123);

        $this->assertIsArray($result);
        $this->assertGreaterThan(0, count($result));
        $this->assertContainsOnly('string', $result);
    }
}
