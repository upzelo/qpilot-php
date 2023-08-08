<?php

declare(strict_types=1);

namespace Qpilot;

use Qpilot\Services\PlanService;
use Qpilot\Services\ShopService;
use Qpilot\Services\OrderService;
use Qpilot\Services\ChargeService;
use Qpilot\Services\ServiceFactory;
use Qpilot\Services\ProductService;
use Qpilot\Services\WebhookService;
use Qpilot\Services\AddressService;
use Qpilot\Services\CustomerService;
use Qpilot\Services\DiscountService;
use Qpilot\Services\SubscriptionService;

/**
 * @property AddressService      $address
 * @property CustomerService     $customer
 * @property ChargeService       $charge
 * @property DiscountService     $discount
 * @property OrderService        $order
 * @property PlanService         $plan
 * @property ProductService      $product
 * @property ShopService         $shop
 * @property SubscriptionService $subscription
 * @property WebhookService      $webhook
 */
class QpilotClient extends BaseQpilotClient
{
    private ?ServiceFactory $serviceFactory = null;

    public function __get(string $name): mixed
    {
        if (null === $this->serviceFactory) {
            $this->serviceFactory = new ServiceFactory($this);
        }

        return $this->serviceFactory->__get($name);
    }
}
