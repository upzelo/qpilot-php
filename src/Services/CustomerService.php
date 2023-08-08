<?php

declare(strict_types=1);

namespace Qpilot\Services;

use Qpilot\Customer;
use Qpilot\Collection;

class CustomerService extends AbstractService
{
    public const OBJECT_TYPE = 'customer';

    /**
     * @param array|null $params
     *
     * @return Collection<Customer>
     */
    public function all(?array $params = null): Collection
    {
        return $this->requestCollection('get', '/customers', $params, self::OBJECT_TYPE);
    }

    /**
     * @param int|string $id
     * @param array|null $params
     *
     * @return Customer
     */
    public function retrieve(int|string $id, ?array $params = null): Customer
    {
        return $this->request('get', $this->buildPath('/customers/%s', $id), $params, self::OBJECT_TYPE);
    }
}
