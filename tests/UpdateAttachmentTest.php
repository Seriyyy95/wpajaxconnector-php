<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class UpdateAttachmentTest extends TestCase
{
    public function testUpdateAttachmentWorks(): void
    {
        $successBody = file_get_contents(__DIR__ . '/fixtures/update_attachment.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector("", "");
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->updateAttachment('test.png', 'data...', 123);

        $this->assertNotNull($result->attachmentId);
        $this->assertNotNull($result->attachmentUrl);
        $this->assertNotNull($result->filesize);
        $this->assertNotNull($result->largeUrl);
        $this->assertNotNull($result->thumbnailUrl);
        
        // Verify property types
        $this->assertIsInt($result->attachmentId);
        $this->assertIsString($result->attachmentUrl);
        $this->assertIsInt($result->filesize);
        $this->assertIsString($result->largeUrl);
        $this->assertIsString($result->thumbnailUrl);
    }
} 