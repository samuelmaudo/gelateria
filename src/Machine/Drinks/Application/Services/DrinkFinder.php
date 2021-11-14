<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Drinks\Application\Services;

use GetWith\CoffeeMachine\Machine\Drinks\Domain\Entities\Drink;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Exceptions\DrinkNotFound;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Repositories\DrinkRepository;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

final class DrinkFinder
{
    public function __construct(private DrinkRepository $repository)
    {
    }

    public function find(DrinkId $id): Drink
    {
        $drink = $this->repository->find($id);

        if (is_null($drink)) {
            throw new DrinkNotFound($id);
        }

        return $drink;
    }
}