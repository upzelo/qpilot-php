<?php

declare(strict_types=1);

namespace Qpilot\Services;

use Qpilot\Order;

class OrderService extends AbstractService
{
    public const OBJECT_TYPE = 'order';

    public function all(?array $params = null): \Qpilot\Collection
    {
        return $this->requestCollection('get', '/orders', $params, self::OBJECT_TYPE);
    }

    public function retrieve($id): Order
    {
        return $this->request('get', $this->buildPath('/orders/%s', $id), [], self::OBJECT_TYPE);
    }
}
