<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class GetAttachmentTest extends TestCase
{
    public function testGetAttachmentWorks(): void
    {
        $successBody = file_get_contents(__DIR__ . '/fixtures/get_attachment.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector("", "");
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->getAttachment(123);

        $this->assertNotNull($result->attachmentId);
        $this->assertNotNull($result->attachmentUrl);
        $this->assertNotNull($result->filesize);
        $this->assertNotNull($result->largeUrl);
        $this->assertNotNull($result->thumbnailUrl);
    }
} 