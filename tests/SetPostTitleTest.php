<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class SetPostTitleTest extends TestCase
{
    public function testSetPostTitleWorks(): void
    {
        $successBody = file_get_contents(__DIR__.'/fixtures/set_post_title.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector('', '');
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->setPostTitle(123, 'Test Post Title');

        $this->assertIsInt($result);
        $this->assertEquals(123, $result);
    }
}
