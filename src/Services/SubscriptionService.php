<?php

declare(strict_types=1);

namespace Qpilot\Services;

use Qpilot\Collection;
use Qpilot\Subscription;

class SubscriptionService extends AbstractService
{
    public const OBJECT_TYPE = 'subscription';

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
        return $this->request('post', $this->buildPath('/ScheduledOrders/%s/cancel', $id), $params, self::OBJECT_TYPE);
    }

    public function activate($id, $params = []): Subscription
    {
        return $this->request('post', $this->buildPath('/ScheduledOrders/%s/activate', $id), $params, self::OBJECT_TYPE);
    }
}
