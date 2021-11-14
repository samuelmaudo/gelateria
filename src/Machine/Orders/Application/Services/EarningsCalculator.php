<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Orders\Application\Services;

use GetWith\CoffeeMachine\Machine\Orders\Domain\Repositories\OrderRepository;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

final class EarningsCalculator
{
    public function __construct(private OrderRepository $repository)
    {
    }

    public function calculate(DrinkId $drinkId): float
    {
        return $this->repository->sumTotalsByDrink($drinkId);
    }
}