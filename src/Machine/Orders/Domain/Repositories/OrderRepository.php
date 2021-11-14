<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Orders\Domain\Repositories;

use GetWith\CoffeeMachine\Machine\Orders\Domain\Entities\Order;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

interface OrderRepository
{
    public function save(Order $order): void;

    public function sumTotalsByDrink(DrinkId $drinkId): float;
}