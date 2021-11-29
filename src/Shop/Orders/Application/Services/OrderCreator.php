<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Application\Services;

use Gelateria\Shop\Gelati\Domain\Entities\Flavor;
use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
use Gelateria\Shop\Orders\Domain\Values\OrderSyrup;
use Gelateria\Shop\Orders\Domain\Values\OrderGivenMoney;
use Gelateria\Shop\Orders\Domain\Values\OrderReturnedMoney;
use Gelateria\Shop\Orders\Domain\Values\OrderScoops;
use Gelateria\Shop\Orders\Domain\Values\OrderTotal;
use Gelateria\Shop\Shared\Domain\Values\OrderId;

use InvalidArgumentException;

final class OrderCreator
{
    public function __construct(private OrderRepository $repository)
    {
    }

    public function create(
        OrderGivenMoney $money,
        Flavor $flavor,
        OrderScoops $scoops,
        OrderSyrup $syrup
    ): Order {

        $price = $flavor->price()->value();
        $amount = 0.0;
        for ($i = 0; $i < $scoops->value(); $i++) {
            $amount += $price - (0.2 * $i);
        }
        $total = new OrderTotal($amount);

        if ($total->gt($money)) {
            throw new InvalidArgumentException(
                "Your order costs {$total}"
            );
        }

        $orderId = OrderId::random();
        $flavorId = $flavor->id();
        $returnedMoney = new OrderReturnedMoney(
            $money->value() - $total->value()
        );

        $order = new Order(
            $orderId,
            $flavorId,
            $scoops,
            $syrup,
            $total,
            $money,
            $returnedMoney
        );

        $this->repository->save($order);

        return $order;
    }
}