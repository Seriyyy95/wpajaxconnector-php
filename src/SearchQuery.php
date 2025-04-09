<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP;

use DateTime;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\AttachmentData;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\PostData;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\PostsList;

class SearchQuery implements SearchQueryInterface
{
    private WPConnector $connector;

    private string $searchQuery = '';

    private int $page = 1;

    private int|null $parentPostId = null;

    private int $countPosts = -1; // Всё

    private string $sortOrder = 'desc';

    private string $sortField = 'relevance';

    private DateTime|null $startDate = null;

    private DateTime|null $endDate = null;

    private string|null $type = null;

    private string|null $searchMetaField = null;

    private string $searchMetaValue = '';

    private bool $onlyPublished = false;

    private bool $onlyTrashed = false;

    private array $sortFieldValues = [
        'date', 'modified', 'ID', 'author', 'parent', 'comment_count', 'menu_order', 'relevance',
    ];

    public function __construct(WPConnector $connector, ?string $query = null)
    {
        $this->connector = $connector;
        if ($query !== null) {
            $this->searchQuery = $query;
        }
    }

    public function searchMeta(string $field, ?string $value = null): self
    {
        $this->searchMetaField = $field;
        $this->searchMetaValue = $value;

        return $this;
    }

    public function orderBy(string $field, string $order = 'desc'): self
    {
        if (!in_array($field, $this->sortFieldValues)) {
            throw new WPConnectorException("Unexpected sort field value $field, expecting: " . implode(', ', $this->sortFieldValues));
        }
        if (!in_array($order, ['asc', 'desc'])) {
            throw new WPConnectorException("Unexpected sort order value $order, expecting: asc, desc");
        }
        $this->sortField = $field;
        $this->sortOrder = $order;

        return $this;
    }

    public function count(int $count = -1): self
    {
        $this->countPosts = $count;

        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function page(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function parent(int $postId): self
    {
        $this->parentPostId = $postId;

        return $this;
    }

    public function startDate(DateTime $date): self
    {
        $this->startDate = $date;

        return $this;
    }

    public function endDate(DateTime $date): self
    {
        $this->endDate = $date;

        return $this;
    }

    public function onlyPublished(bool $published): self
    {
        $this->onlyPublished = $published;

        return $this;
    }

    public function onlyTrashed(bool $trashed): self
    {
        $this->onlyTrashed = $trashed;

        return $this;
    }

    public function getPosts(): PostsList
    {
        $params = [
            'count' => $this->countPosts,
            'page' => $this->page,
            'text' => $this->searchQuery,
            'sort' => $this->sortField,
            'order' => $this->sortOrder,
            'only_published' => $this->onlyPublished,
            'only_trashed' => $this->onlyTrashed,
        ];
        if ($this->searchMetaField !== null) {
            $params['meta_field'] = $this->searchMetaField;
            $params['meta_text'] = $this->searchMetaValue;
        }
        if ($this->type !== null) {
            $params['type'] = $this->type;
        }
        if ($this->startDate !== null) {
            $params['start_date'] = $this->startDate->format('Y-m-d H:i:s');
        }
        if ($this->endDate !== null) {
            $params['end_date'] = $this->endDate->format('Y-m-d H:i:s');
        }

        $posts = [];
        $result = $this->connector->makeListPostsRequest($params);

        foreach ($result['posts'] as $postData) {
            $post = new PostData;
            $post->id = $postData['post_id'];
            $post->title = $postData['title'];
            $post->url = $postData['url'];

            $posts[] = $post;
        }

        return new PostsList($posts, $result['has_more']);
    }

    public function getAttachments(): PostsList
    {
        $params = [
            'count' => $this->countPosts,
            'page' => $this->page,
            'text' => $this->searchQuery,
            'sort' => $this->sortField,
            'order' => $this->sortOrder,
            'only_published' => $this->onlyPublished,
            'only_trashed' => $this->onlyTrashed,
        ];

        if ($this->parentPostId !== null) {
            $params['post_id'] = $this->parentPostId;
        }
        if ($this->startDate !== null) {
            $params['start_date'] = $this->startDate->format('Y-m-d H:i:s');
        }
        if ($this->endDate !== null) {
            $params['end_date'] = $this->endDate->format('Y-m-d H:i:s');
        }

        $posts = [];
        $result = $this->connector->makeListAttachmentsRequest($params);

        foreach ($result['attachments'] as $item) {
            $posts[] = AttachmentData::fromArray($item);
        }

        return new PostsList($posts, $result['has_more']);
    }
}
