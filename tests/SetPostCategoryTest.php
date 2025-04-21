<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class SetPostCategoryTest extends TestCase
{
    public function testSetPostCategoryWorks(): void
    {
        $successBody = file_get_contents(__DIR__.'/fixtures/set_post_category.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector('', '');
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->setPostCategory(123, 456);

        // post id
        $this->assertIsInt($result);
    }
}
