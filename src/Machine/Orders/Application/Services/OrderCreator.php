<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Orders\Application\Services;

use GetWith\CoffeeMachine\Machine\Drinks\Domain\Entities\Drink;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Entities\Order;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Repositories\OrderRepository;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderExtraHot;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderGivenMoney;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderReturnedMoney;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderSugars;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Values\OrderTotal;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\OrderId;

use InvalidArgumentException;

final class OrderCreator
{
    public function __construct(private OrderRepository $repository)
    {
    }

    public function create(
        OrderGivenMoney $money,
        Drink $drink,
        OrderSugars $sugars,
        OrderExtraHot $extraHot
    ): Order {

        if ($drink->price()->gt($money)) {
            throw new InvalidArgumentException(
                "The {$drink->id()} costs {$drink->price()}."
            );
        }

        $id = OrderId::random();
        $drinkId = $drink->id();
        $total = new OrderTotal($drink->price()->value());
        $returnedMoney = new OrderReturnedMoney(
            $money->value() - $total->value()
        );

        $order = new Order(
            $id,
            $drinkId,
            $sugars,
            $extraHot,
            $total,
            $money,
            $returnedMoney
        );

        $this->repository->save($order);

        return $order;
    }
}