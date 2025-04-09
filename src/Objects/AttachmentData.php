<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP\Objects;

class AttachmentData
{
    public int $attachmentId;
    public ?int $width = 0;
    public ?int $height = 0;
    public ?int $filesize = 0;
    public string $attachmentUrl;
    public ?string $thumbnailUrl = null;
    public ?string $largeUrl = null;

    public static function fromArray(array $data): self
    {
        $attachmentData = new self();
        $attachmentData->attachmentId = $data['attachment_id'];
        $attachmentData->attachmentUrl = $data['attachment_url'];
        $attachmentData->width = $data['width'];
        $attachmentData->height = $data['height'];
        $attachmentData->filesize = $data['filesize'];
        $attachmentData->thumbnailUrl = $data['sizes']['thumbnail'];
        $attachmentData->largeUrl = $data['sizes']['large'];

        return $attachmentData;
    }
}
