<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP;

use WPAjaxConnector\WPAjaxConnectorPHP\Enum\TaxonomyType;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\AttachmentData;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\FullPostData;
use WPAjaxConnector\WPAjaxConnectorPHP\Objects\PostData;

interface WPConnectorInterface
{
    public function query(?string $query = null): SearchQueryInterface;

    public function isAccessible(): bool;

    public function getPost(int $post_id): FullPostData;

    public function deletePost(int $postId): bool;

    public function getTranslations(int $postId): array;

    public function getKeywords(int $postId): array;

    public function setTranslation(int $postId, string $code, int $translationId): int;

    public function getPostThumbnail(int $postId): AttachmentData;

    public function getAttachment(int $attachmentId): AttachmentData;

    public function getAttachmentByUrl(string $url): AttachmentData;

    public function getPostBlocks(int $postId): array;

    public function getPostMeta(int $postId, string $key): ?string;

    public function setPostBlocks(int $postId, array $blocks): int;

    public function addAttachment(string $imageName, string $imageData, ?int $post_id = null): AttachmentData;

    public function updateAttachment(string $imageName, string $imageData, int $attachmentId): AttachmentData;

    public function deleteAttachment(int $attachmentId): bool;

    public function addPost(string $postTitle, string $postContent): PostData;

    public function addCategory(string $categoryName, string $categorySlug): int;

    public function addTag(string $tagName, string $tagSlug): int;

    public function setPostParent(int $postId, int $parentId): int;

    public function setPostThumbnail(int $postId, int $attachmentId): int;

    public function setPostMeta(int $postId, array $postMeta): int;

    public function setContent(int $postId, string $content): int;

    public function setPostTitle(int $postId, string $title): int;

    public function setPostCategory(int $postId, int $categoryId): int;

    public function setPostTags(int $postId, array $tagIds): int;

    public function setTermName(int $termId, TaxonomyType $type, string $name): int;
    public function setTermSlug(int $termId, TaxonomyType $type, string $slug): int;
}
