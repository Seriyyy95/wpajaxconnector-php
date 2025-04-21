<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class GetPostBlocksTest extends TestCase
{
    public function testGetPostBlocksWorks(): void
    {
        $successBody = file_get_contents(__DIR__.'/fixtures/get_post_blocks.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector('', '');
        $wpConnector->setMockHandler($mock);

        $blocks = $wpConnector->getPostBlocks(123);

        $this->assertIsArray($blocks);
        $this->assertGreaterThan(0, count($blocks));
    }
}
