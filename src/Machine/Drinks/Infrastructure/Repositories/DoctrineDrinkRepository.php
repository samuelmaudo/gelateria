<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Drinks\Infrastructure\Repositories;

use GetWith\CoffeeMachine\Machine\Drinks\Domain\Collections\Drinks;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Entities\Drink;
use GetWith\CoffeeMachine\Machine\Drinks\Domain\Repositories\DrinkRepository;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class DoctrineDrinkRepository implements DrinkRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    private function repository(): EntityRepository
    {
        return $this->entityManager->getRepository(Drink::class);
    }

    public function find(DrinkId $id): ?Drink
    {
        return $this->repository()->find($id);
    }

    public function search(): Drinks
    {
        return new Drinks($this->repository()->findAll());
    }
}
