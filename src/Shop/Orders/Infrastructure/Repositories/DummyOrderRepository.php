<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Infrastructure\Repositories;

use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;

final class DummyOrderRepository implements OrderRepository
{
    /** @var array<string, Order> */
    private static array $orders = [];

    public function save(Order $order): void
    {
        $key = $order->id()->value();

        self::$orders[$key] = $order;
    }

    public function sumTotalsByGelato(GelatoId $gelatoId): float
    {
        $totals = [];

        foreach (self::$orders as $order) {
            if ($order->gelatoId()->is($gelatoId)) {
                $totals[] = $order->total()->value();
            }
        }

        return (float) array_sum($totals);
    }

    public function reset(): void
    {
        self::$orders = [];
    }
}