<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Orders\Domain\Collections;

use GetWith\CoffeeMachine\Machine\Orders\Domain\Entities\Order;
use GetWith\CoffeeMachine\Shared\Kernel\Domain\Collections\Collection;

/**
 * @extends Collection<Order>
 */
final class Orders extends Collection
{
    public function type(): string
    {
        return Order::class;
    }
}