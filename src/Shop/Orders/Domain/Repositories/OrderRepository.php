<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Domain\Repositories;

use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;

interface OrderRepository
{
    public function save(Order $order): void;

    public function sumTotalsByGelato(GelatoId $gelatoId): float;
}