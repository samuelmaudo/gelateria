<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Domain\Collections;

use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shared\Kernel\Domain\Collections\Collection;

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