<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class SetPostMetaTest extends TestCase
{
    public function testSetPostMetaWorks(): void
    {
        $successBody = file_get_contents(__DIR__ . '/fixtures/set_post_meta.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector("", "");
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->setPostMeta(123, ['test_meta_key' => 'test_meta_value']);

        $this->assertIsInt($result);
        $this->assertEquals(123, $result);
    }
}
