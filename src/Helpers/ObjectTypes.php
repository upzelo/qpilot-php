<?php

declare(strict_types=1);

namespace Qpilot\Helpers;

use Qpilot\Plan;
use Qpilot\Shop;
use Qpilot\Order;
use Qpilot\Charge;
use Qpilot\Product;
use Qpilot\Webhook;
use Qpilot\Customer;
use Qpilot\Discount;
use Qpilot\Collection;
use Qpilot\Subscription;
use Qpilot\Address;

class ObjectTypes
{
    public const MAPPING = [
        Address::OBJECT_NAME => Address::class,
        Customer::OBJECT_NAME => Customer::class,
        Collection::OBJECT_NAME => Collection::class,
        Charge::OBJECT_NAME => Charge::class,
        Discount::OBJECT_NAME => Discount::class,
        Order::OBJECT_NAME => Order::class,
        Plan::OBJECT_NAME => Plan::class,
        Product::OBJECT_NAME => Product::class,
        Shop::OBJECT_NAME => Shop::class,
        Subscription::OBJECT_NAME => Subscription::class,
        Webhook::OBJECT_NAME => Webhook::class,
    ];
}
