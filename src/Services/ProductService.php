<?php

declare(strict_types=1);

namespace Qpilot\Services;

use Qpilot\Product;
use Qpilot\Collection;

class ProductService extends AbstractService
{
    public const OBJECT_TYPE = 'product';

    public function all(?array $params = []): Collection
    {
        return $this->requestCollection('get', '/Products', $params, self::OBJECT_TYPE);
    }

    public function retrieve($id): Product
    {
        return $this->request('get', $this->buildPath('/Products/%s', $id), [], self::OBJECT_TYPE);
    }
}
