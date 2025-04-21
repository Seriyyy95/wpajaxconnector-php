<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP\Objects;

use DateTime;

class FullPostData
{
    public int $id;

    public string $status;

    public string $title;

    public string $content;

    public ?string $url;

    public ?int $parentId;

    public string $type;

    public string $mimeType;

    public ?DateTime $publishedAt;

    public ?DateTime $modifiedAt;

    public string $category;

    public array $tags = [];

    public string $author;
}
