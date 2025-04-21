<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class GetPostThumbnailTest extends TestCase
{
    public function testGetPostThumbnailWorks(): void
    {
        $successBody = file_get_contents(__DIR__.'/fixtures/get_post_thumbnail.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector('', '');
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->getPostThumbnail(123);

        $this->assertNotNull($result->thumbnailUrl);
        $this->assertNotNull($result->attachmentUrl);
        $this->assertNotNull($result->largeUrl);
        $this->assertIsString($result->thumbnailUrl);
        $this->assertIsString($result->attachmentUrl);
        $this->assertIsString($result->largeUrl);
    }
}
