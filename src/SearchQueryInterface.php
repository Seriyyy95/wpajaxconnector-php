<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP;

use DateTime;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\PostsList;

interface SearchQueryInterface
{
    public function searchMeta(string $field, ?string $value = null): self;

    public function orderBy(string $field, string $order = 'desc'): self;

    public function count(int $count = -1): self;

    public function type(string $type): self;

    public function page(int $page): self;

    public function parent(int $postId): self;

    public function startDate(DateTime $date): self;

    public function endDate(DateTime $date): self;

    public function onlyPublished(bool $published): self;

    public function onlyTrashed(bool $trashed): self;

    public function getPosts(): PostsList;

    public function getAttachments(): PostsList;
}
