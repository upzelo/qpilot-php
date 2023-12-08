<?php

declare(strict_types=1);

namespace Qpilot\Services;

use Qpilot\Collection;
use Qpilot\Subscription;

class SubscriptionService extends AbstractService
{
    public const OBJECT_TYPE = 'subscription';
    public const PAUSED = 'Paused';
    public const ACTIVE = 'Active';

    public function all(?array $params = []): Collection
    {
        return $this->requestCollection('get', '/ScheduledOrders', $params, self::OBJECT_TYPE);
    }

    public function retrieve($id): Subscription
    {
        return $this->request('get', $this->buildPath('/ScheduledOrders/%s', $id), [], self::OBJECT_TYPE);
    }

    public function cancel($id, $params = []): Subscription
    {
        return $this->request('delete', $this->buildPath('/ScheduledOrders/%s/', $id), $params, self::OBJECT_TYPE);
    }

    public function update($id, Subscription $subscription): Subscription
    {
        return $this->request('put', $this->buildPath('/ScheduledOrders/%s/', $id), $subscription, self::OBJECT_TYPE);
    }

    //No longer used from here down
    public function applyDiscount($id, Subscription $subscription): Subscription
    {
        return $this->request('put', $this->buildPath('/ScheduledOrders/%s/', $id), $subscription, self::OBJECT_TYPE);
    }

    public function pause(int|string $id, Subscription $subscription): Subscription
    {
        return $this->request(
            'put',
            $this->buildPath('/ScheduledOrders/%s', $id),
            ['status' => self::PAUSED],
            self::OBJECT_TYPE,
        );
    }

}
