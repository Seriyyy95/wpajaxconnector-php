<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class GetPostMetaTest extends TestCase
{
    public function testGetPostMetaWorks(): void
    {
        $successBody = file_get_contents(__DIR__ . '/fixtures/get_post_meta.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector("", "");
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->getPostMeta(123, 'test_meta_key');

        $this->assertIsString($result);
        $this->assertEquals('example_meta_value', $result);
    }
} 