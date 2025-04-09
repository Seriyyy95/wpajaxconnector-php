<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\PostData;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\PostsList;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class ListPostsTest extends TestCase
{
    public function testListPostsWorks(): void
    {
        $successBody = file_get_contents(__DIR__ . '/fixtures/list_posts.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector("", "");
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->query()->getPosts();

        $this->assertInstanceOf(PostsList::class, $result);
        $this->assertGreaterThan(0, count($result->posts));

        // Check first post has all required properties
        $firstPost = $result->posts[0];
        $this->assertInstanceOf(PostData::class, $firstPost);
        $this->assertNotNull($firstPost->id);
        $this->assertNotNull($firstPost->title);
        $this->assertNotNull($firstPost->url);

        // Verify property types
        $this->assertIsInt($firstPost->id);
        $this->assertIsString($firstPost->title);
        $this->assertIsString($firstPost->url);
    }
}
