<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Orders\Infrastructure\Repositories;

use GetWith\CoffeeMachine\Machine\Orders\Domain\Entities\Order;
use GetWith\CoffeeMachine\Machine\Orders\Domain\Repositories\OrderRepository;
use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class DoctrineOrderRepository implements OrderRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    private function repository(): EntityRepository
    {
        return $this->entityManager->getRepository(Order::class);
    }

    public function save(Order $order): void
    {
        $this->entityManager->persist($order);
        $this->entityManager->flush($order);
    }

    public function sumTotalsByDrink(DrinkId $drinkId): float
    {
        return (float) $this
            ->entityManager
            ->createQuery("
                SELECT SUM(o.total.value)
                FROM GetWith\CoffeeMachine\Machine\Orders\Domain\Entities\Order o
                WHERE o.drinkId = :drinkId
            ")
            ->setParameter('drinkId', $drinkId)
            ->getSingleScalarResult();
    }
}