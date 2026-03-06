<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP\Objects;

class TagData
{
    public int $id;
    public string $url;

    public static function fromArray(array $data): self
    {
        $termData = new self;
        $termData->id = $data['tag_id'];
        $termData->url = $data['url'];

        return $termData;
    }
}
