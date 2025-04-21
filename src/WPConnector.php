<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\AttachmentData;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\FullPostData;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\PostData;

class WPConnector implements WPConnectorInterface
{
    private bool $debug = false;

    private string $domain;

    private string $accessKey;

    private ?MockHandler $mock = null;

    public function __construct($domain, $accessKey)
    {
        $this->domain = $domain;
        $this->accessKey = $accessKey;
    }

    public function enableDebug(bool $bool): self
    {
        $this->debug = $bool;

        return $this;
    }

    public function setMockHandler(MockHandler $handler): self
    {
        $this->mock = $handler;

        return $this;
    }

    public function query(?string $query = null): SearchQueryInterface
    {
        return new SearchQuery($this, $query);
    }

    public function isAccessible(): bool
    {
        $result = $this->makeRequest('is_accessible', [], null);

        if ($result['success'] === true) {
            return true;
        }

        return false;

    }

    public function getPost(int $post_id): FullPostData
    {
        $params = [
            'post_id' => $post_id,
        ];

        $result = $this->makeRequest('get_post_data', $params);

        $postData = new FullPostData;
        $postData->id = $result['post_id'];
        $postData->title = $result['post_title'];
        $postData->content = $result['post_content'];
        $postData->status = $result['post_status'];
        $postData->type = $result['post_type'];
        $postData->mimeType = $result['post_mime_type'];
        $postData->parentId = $result['post_parent'];
        $postData->publishedAt = $result['publish_date'] != null ? new DateTime($result['publish_date']) : null;
        $postData->modifiedAt = $result['last_modified'] != null ? new DateTime($result['last_modified']) : null;
        $postData->url = $result['post_url'];
        $postData->category = $result['category_name'] ?? '';
        $postData->tags = $result['tags'];
        $postData->author = $result['author'];

        return $postData;
    }

    public function deletePost(int $postId): bool
    {
        $params = [
            'post_id' => $postId,
        ];

        $result = $this->makeRequest('delete_post', $params, null);

        if (isset($result['success']) && $result['success'] === true) {
            return true;
        }

        return false;

    }

    public function getTranslations(int $postId): array
    {
        $params = [
            'post_id' => $postId,
        ];

        return $this->makeRequest('get_post_translations', $params);
    }

    public function getKeywords(int $postId): array
    {
        $params = [
            'post_id' => $postId,
        ];

        return $this->makeRequest('get_post_keywords', $params)['keywords'];
    }

    public function setTranslation(int $postId, string $code, int $translationId): int
    {
        $params = [
            'post_id' => $postId,
            'translation_id' => $translationId,
            'locale' => $code,
        ];

        $result = $this->makeRequest('set_post_translation', $params);

        return $result['post_id'];
    }

    public function getPostThumbnail(int $postId): AttachmentData
    {
        $params = [
            'post_id' => $postId,
        ];

        $result = $this->makeRequest('get_post_thumbnail', $params);

        return AttachmentData::fromArray($result);
    }

    public function getAttachment(int $attachmentId): AttachmentData
    {
        $params = [
            'attachment_id' => $attachmentId,
        ];

        $result = $this->makeRequest('get_attachment', $params);

        return AttachmentData::fromArray($result);
    }

    public function getAttachmentByUrl(string $url): AttachmentData
    {
        $params = [
            'url' => $url,
        ];

        $result = $this->makeRequest('get_attachment', $params);

        return AttachmentData::fromArray($result);
    }

    public function getPostBlocks(int $postId): array
    {
        $params = [
            'post_id' => $postId,
        ];

        $result = $this->makeRequest('get_post_blocks', $params);

        return $result['blocks'];
    }

    public function getPostMeta(int $postId, string $key): ?string
    {
        $params = [
            'post_id' => $postId,
            'meta_key' => $key,
        ];

        $result = $this->makeRequest('get_post_meta', $params);

        return $result['value'];
    }

    public function setPostBlocks(int $postId, array $blocks): int
    {
        $params = [
            'post_id' => $postId,
            'blocks' => json_encode($blocks),
        ];

        $result = $this->makeRequest('set_post_blocks', $params, 'data', 'POST');

        return intval($result['post_id']);
    }

    public function addAttachment(string $imageName, string $imageData, ?int $post_id = null): AttachmentData
    {
        $params = [
            'attachment_name' => $imageName,
            'attachment_data' => base64_encode($imageData),
            'post_id' => $post_id,
        ];

        $result = $this->makeRequest('add_attachment', $params, 'data', 'POST');

        return AttachmentData::fromArray($result);
    }

    public function updateAttachment(string $imageName, string $imageData, int $attachmentId): AttachmentData
    {
        $params = [
            'attachment_name' => $imageName,
            'attachment_data' => base64_encode($imageData),
            'attachment_id' => $attachmentId,
        ];

        $result = $this->makeRequest('update_attachment', $params, 'data', 'POST');

        return AttachmentData::fromArray($result);
    }

    public function deleteAttachment(int $attachmentId): bool
    {
        $params = [
            'attachment_id' => $attachmentId,
        ];

        $result = $this->makeRequest('delete_attachment', $params, null, 'POST');

        if (isset($result['success']) && $result['success'] === true) {
            return true;
        }

        return false;

    }

    public function addPost(string $postTitle, string $postContent): PostData
    {
        $params = [
            'post_title' => $postTitle,
            'post_content' => $postContent,
        ];

        $result = $this->makeRequest('add_post', $params, 'data', 'POST');

        $postData = new PostData;
        $postData->id = $result['post_id'];
        $postData->url = $result['url'];
        $postData->title = $result['title'];

        return $postData;
    }

    public function setContent(int $postId, string $content): int
    {
        $params = [
            'post_id' => $postId,
            'post_content' => $content,
        ];

        $result = $this->makeRequest('set_post_content', $params, 'data', 'POST');

        return intval($result['post_id']);
    }

    public function setPostParent(int $postId, int $parentId): int
    {
        $params = [
            'post_id' => $postId,
            'post_parent_id' => $parentId,
        ];

        $result = $this->makeRequest('set_post_parent', $params, 'data', 'POST');

        return intval($result['post_id']);
    }

    public function setPostTitle(int $postId, string $title): int
    {
        $params = [
            'post_id' => $postId,
            'post_title' => $title,
        ];
        $result = $this->makeRequest('set_post_title', $params, 'data', 'POST');

        return intval($result['post_id']);
    }

    public function setPostCategory(int $postId, int $categoryId): int
    {
        $params = [
            'post_id' => $postId,
            'category_id' => $categoryId,
        ];
        $result = $this->makeRequest('set_post_category', $params, 'data', 'POST');

        return intval($result['post_id']);
    }

    public function setPostMeta(int $postId, array $postMeta): int
    {
        $params = [
            'post_id' => $postId,
            'post_meta' => json_encode($postMeta),
        ];
        $result = $this->makeRequest('set_post_meta', $params, 'data', 'POST');

        return intval($result['post_id']);
    }

    public function setPostThumbnail(int $postId, int $attachmentId): int
    {
        $params = [
            'post_id' => $postId,
            'attachment_id' => $attachmentId,
        ];

        $result = $this->makeRequest('set_post_thumbnail', $params);

        return intval($result['post_id']);
    }

    public function makeListPostsRequest(array $params): array
    {
        return $this->makeRequest('list_posts', $params, null);
    }

    public function makeListAttachmentsRequest(array $params): array
    {
        return $this->makeRequest('list_attachments', $params, null);
    }

    private function makeRequest(
        string $action,
        array $params = [],
        ?string $dataField = 'data',
        string $method = 'GET'
    ) {
        $uri = sprintf('%s/wp-admin/admin-ajax.php', $this->domain);

        if ($this->mock !== null) {
            $handlerStack = HandlerStack::create($this->mock);
        } else {
            $handlerStack = HandlerStack::create(new CurlHandler);
        }

        $client = new Client([
            'base_uri' => $uri,
            'timeout' => 60,
            'handler' => $handlerStack,
        ]);

        $params['action'] = $action;

        if ($this->debug) {
            $params['debug'] = true;
        }

        if ($method == 'GET') {
            $paramsField = 'query';
        } else {
            $paramsField = 'form_params';
        }

        try {
            $httpResponse = $client->request($method, '', [
                $paramsField => $params,
                'headers' => [
                    'X-Access-Key' => $this->accessKey,
                ],
                'debug' => false,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseString = $response->getBody()->getContents();

            throw new WPConnectorException('Http client returns error: '.$responseString.' for action: '.$action);
        }

        $jsonString = (string) $httpResponse->getBody()->getContents();
        if (strlen($jsonString) == 0) {
            throw new WPConnectorException('Wordpress has returned empty result, please check wordpress debug logs for errors');
        }

        $post = json_decode($jsonString, true);
        if ($post === null && str_contains($jsonString, '404')) {
            throw new WPConnectorException('Wordpress does not have enough resources to evaluate request!');
        } elseif ($post === null) {
            throw new WPConnectorException("Can't decode json response: ".json_last_error_msg().', '.print_r($jsonString, true).', '.print_r([$action, $params, $uri], true));
        }

        if ($dataField != null) {
            if (isset($post[$dataField])) {
                return $post[$dataField];
            } elseif (isset($post['error'])) {
                throw new WPConnectorException('The WPConnector plugin has returned an error: '.$post['error']);
            }
            throw new WPConnectorException('The WPConnector plugin has returned an unexpected data: '.print_r($post, true));
        } else {
            if (isset($post['error'])) {
                throw new WPConnectorException('The WPConnector plugin has returned an error: '.$post['error']);
            }

            return $post;
        }
    }
}
