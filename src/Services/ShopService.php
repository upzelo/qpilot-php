<?php

declare(strict_types=1);

namespace Qpilot\Services;

use Qpilot\Shop;

class ShopService extends AbstractService
{
    public const OBJECT_TYPE = 'shop';

    public function retrieve($params = []): Shop
    {
        return $this->request('get', 'shop', $params, self::OBJECT_TYPE);
    }
}
