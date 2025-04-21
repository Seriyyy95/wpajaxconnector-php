<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class SetPostBlocksTest extends TestCase
{
    public function testSetPostBlocksWorks(): void
    {
        $successBody = file_get_contents(__DIR__.'/fixtures/set_post_blocks.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector('', '');
        $wpConnector->setMockHandler($mock);

        $blocks = [
            [
                'blockName' => 'core/paragraph',
                'attrs' => [],
                'innerHTML' => 'Test content',
            ],
        ];

        $result = $wpConnector->setPostBlocks(123, $blocks);

        $this->assertIsInt($result);
    }
}
