<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP\Objects;

class TermData
{
    public int $id;
    public string $url;

    public static function fromArrayForTag(array $data): self
    {
        $termData = new self;
        $termData->id = $data['tag_id'];
        $termData->url = $data['url'];

        return $termData;
    }

    public static function fromArrayForCategory(array $data): self
    {
        $termData = new self;
        $termData->id = $data['category_id'];
        $termData->url = $data['url'];

        return $termData;
    }
}
