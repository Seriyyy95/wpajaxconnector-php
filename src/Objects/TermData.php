<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP\Objects;

class TermData
{
    public int $id;
    public string $name;
    public string $slug;
    public string $type;
    public string $url;

    public static function fromArray(array $data): self
    {
        $termData = new self;
        $termData->id = $data['id'];
        $termData->name = $data['name'];
        $termData->slug = $data['slug'];
        $termData->type = $data['type'];
        $termData->url = $data['url'];

        return $termData;
    }
}
