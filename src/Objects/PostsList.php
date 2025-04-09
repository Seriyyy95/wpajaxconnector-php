<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP\Objects;

class PostsList
{
    public array $posts;

    public bool $hasMore;

    public function __construct(array $posts, bool $hasMore)
    {
        $this->posts = $posts;
        $this->hasMore = $hasMore;
    }
}
