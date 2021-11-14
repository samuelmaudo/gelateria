<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Drinks\Domain\Repositories;

use GetWith\CoffeeMachine\Machine\Drinks\Domain\Entities\Drink;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

interface DrinkRepository
{
    public function find(DrinkId $drinkId): ?Drink;
}