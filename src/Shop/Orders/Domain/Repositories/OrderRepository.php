<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Domain\Repositories;

use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;

interface OrderRepository
{
    public function save(Order $order): void;

    public function sumTotalsByFlavor(FlavorId $flavorId): float;
}