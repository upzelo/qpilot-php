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

    public function activate($id, $params = []): Subscription
    {
        return $this->request('put', $this->buildPath('/ScheduledOrders/%s/Status/Active', $id), $params, self::OBJECT_TYPE);
    }

    public function applyDiscount($id, array $params = []): Subscription
    {
        return $this->request('put', $this->buildPath('/ScheduledOrders/%s/', $id), $params, self::OBJECT_TYPE);
    }

    public function pause(int|string $id): Subscription
    {
        return $this->request(
            'put',
            $this->buildPath('/ScheduledOrders/%s', $id),
            ['status' => self::PAUSED],
            self::OBJECT_TYPE,
        );
    }

    public function reschedule(int|string $id, array $params = []): Subscription
    {
        \Log::info($this->buildPath('/ScheduledOrders/%s/%s', $id, $params['date']));
        return $this->request(
            'put',
            $this->buildPath('/ScheduledOrders/%s/%s', $id, $params['date']),
            [],
            self::OBJECT_TYPE,
        );
    }

    public function resume(int|string $id): Subscription
    {
        return $this->request(
            'put',
            $this->buildPath('/ScheduledOrders/%s', $id),
            ['status' => self::ACTIVE],
            self::OBJECT_TYPE,
        );
    }

//    public function skip($id, $subscriptionIds): Charge
//    {
//        return $this->request(
//            'post',
//            $this->buildPath('/ScheduledOrders/%s/skip', $id),
//            ['subscription_ids' => $subscriptionIds],
//            self::OBJECT_TYPE
//        );
//    }
//
//    public function unSkip($id, $subscriptionIds): Charge
//    {
//        return $this->request(
//            'post',
//            $this->buildPath('/ScheduledOrders/%s/unskip', $id),
//            ['subscription_ids' => $subscriptionIds],
//            self::OBJECT_TYPE
//        );
//    }
}
