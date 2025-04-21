<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use WPAjaxConnector\WPAjaxConnectorPHP\WPConnector;

class SetPostTranslationTest extends TestCase
{
    public function testSetPostTranslationWorks(): void
    {
        $successBody = file_get_contents(__DIR__.'/fixtures/set_post_translation.json');
        $mock = new MockHandler([
            new Response(200, [], $successBody),
        ]);

        $wpConnector = new WPConnector('', '');
        $wpConnector->setMockHandler($mock);

        $result = $wpConnector->setTranslation(123, 'es', 456);

        $this->assertIsInt($result);
    }
}
