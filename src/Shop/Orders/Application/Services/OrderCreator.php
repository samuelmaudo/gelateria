<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Application\Services;

use Gelateria\Shop\Gelati\Domain\Entities\Gelato;
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
        Gelato $gelato,
        OrderScoops $scoops,
        OrderSyrup $syrup
    ): Order {

        if ($gelato->price()->gt($money)) {
            throw new InvalidArgumentException(
                "The {$gelato->id()} costs {$gelato->price()}."
            );
        }

        $id = OrderId::random();
        $gelatoId = $gelato->id();
        $total = new OrderTotal($gelato->price()->value());
        $returnedMoney = new OrderReturnedMoney(
            $money->value() - $total->value()
        );

        $order = new Order(
            $id,
            $gelatoId,
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