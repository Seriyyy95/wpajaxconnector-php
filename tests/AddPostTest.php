<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class AddPostTest extends TestCase
{
    public function testAddPostWorks(): void
    {
        $successBody = file_get_contents(__DIR__ . '/fixtures/add_post.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector("", "");
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->addPost('Test Post Title', 'Test Post Content');

        $this->assertNotNull($result->id);
        $this->assertNotNull($result->url);
        $this->assertNotNull($result->title);
    }
} 