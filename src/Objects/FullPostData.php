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

    public string|null $url;

    public int|null $parentId;

    public string $type;

    public string $mimeType;

    public DateTime|null $publishedAt;

    public DateTime|null $modifiedAt;

    public string $category;

    public array $tags = [];

    public string $author;
}
