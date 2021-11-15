<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Orders\Infrastructure\Repositories;

use GetWith\CoffeeMachine\Machine\Orders\Domain\Entities\Order;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Repositories\OrderRepository;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

final class DummyOrderRepository implements OrderRepository
{
    /** @var array<string, Order> */
    private static array $orders = [];

    public function save(Order $order): void
    {
        $key = $order->id()->value();

        self::$orders[$key] = $order;
    }

    public function sumTotalsByDrink(DrinkId $drinkId): float
    {
        $totals = [];

        foreach (self::$orders as $order) {
            if ($order->drinkId()->is($drinkId)) {
                $totals[] = $order->total()->value();
            }
        }

        return (float) array_sum($totals);
    }
}