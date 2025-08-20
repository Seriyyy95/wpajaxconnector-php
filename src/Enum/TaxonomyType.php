<?php

declare(strict_types=1);

namespace WPAjaxConnector\WPAjaxConnectorPHP\Enum;

enum TaxonomyType: string
{
    case TAG = 'post_tag';
    case CATEGORY = 'category';
}
