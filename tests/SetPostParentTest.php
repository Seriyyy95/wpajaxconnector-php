<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class SetPostParentTest extends TestCase
{
    public function testSetPostParentWorks(): void
    {
        $successBody = file_get_contents(__DIR__ . '/fixtures/set_post_parent.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector("", "");
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->setPostParent(123, 456);

        $this->assertIsInt($result);
    }
} 