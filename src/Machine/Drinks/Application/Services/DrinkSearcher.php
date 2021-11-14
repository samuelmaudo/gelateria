<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Drinks\Application\Services;

use GetWith\CoffeeMachine\Machine\Drinks\Domain\Collections\Drinks;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Repositories\DrinkRepository;

final class DrinkSearcher
{
    public function __construct(private DrinkRepository $repository)
    {
    }

    public function search(): Drinks
    {
        return $this->repository->search();
    }
}