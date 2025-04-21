<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class GetPostDataTest extends TestCase
{
    public function testGetPostDataWorks(): void
    {
        $successBody = file_get_contents(__DIR__.'/fixtures/get_post_data.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector('', '');
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->getPost(123);

        $this->assertNotNull($result->id);
        $this->assertNotNull($result->title);
        $this->assertNotNull($result->content);
        $this->assertNotNull($result->status);
        $this->assertNotNull($result->type);
        $this->assertNotNull($result->mimeType);
        $this->assertNotNull($result->parentId);
        $this->assertNotNull($result->publishedAt);
        $this->assertNotNull($result->modifiedAt);
        $this->assertNotNull($result->url);
        $this->assertNotNull($result->category);
        $this->assertIsArray($result->tags);
        $this->assertNotNull($result->author);
    }
}
