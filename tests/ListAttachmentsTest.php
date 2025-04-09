<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\AttachmentData;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\PostsList;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class ListAttachmentsTest extends TestCase
{
    public function testListAttachmentsWorks(): void
    {
        $successBody = file_get_contents(__DIR__ . '/fixtures/list_attachments.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector("", "");
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->query()->getAttachments();

        $this->assertInstanceOf(PostsList::class, $result);
        $this->assertGreaterThan(0, count($result->posts));

        // Check first attachment has all required properties
        $firstAttachment = $result->posts[0];
        $this->assertInstanceOf(AttachmentData::class, $firstAttachment);
        $this->assertNotNull($firstAttachment->attachmentId);
        $this->assertNotNull($firstAttachment->attachmentUrl);
        $this->assertNotNull($firstAttachment->filesize);
        $this->assertNotNull($firstAttachment->largeUrl);
        $this->assertNotNull($firstAttachment->thumbnailUrl);

        // Verify property types
        $this->assertIsInt($firstAttachment->attachmentId);
        $this->assertIsString($firstAttachment->attachmentUrl);
        $this->assertIsInt($firstAttachment->filesize);
        $this->assertIsString($firstAttachment->largeUrl);
        $this->assertIsString($firstAttachment->thumbnailUrl);
    }
}
