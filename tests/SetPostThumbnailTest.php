<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class SetPostThumbnailTest extends TestCase
{
    public function testSetPostThumbnailWorks(): void
    {
        $successBody = file_get_contents(__DIR__ . '/fixtures/set_post_thumbnail.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector("", "");
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->setPostThumbnail(123, 456);

        $this->assertIsInt($result);
    }
} 