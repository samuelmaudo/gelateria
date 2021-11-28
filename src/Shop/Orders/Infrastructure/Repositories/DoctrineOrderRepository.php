<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Infrastructure\Repositories;

use Gelateria\Shared\Doctrine\Infrastructure\Repositories\DoctrineRepository;
use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;

final class DoctrineOrderRepository extends DoctrineRepository implements OrderRepository
{
    protected function entityClass(): string
    {
        return Order::class;
    }

    public function save(Order $order): void
    {
        $this->entityManager()->persist($order);
        $this->entityManager()->flush($order);
    }

    public function sumTotalsByFlavor(FlavorId $flavorId): float
    {
        return (float) $this
            ->entityManager()
            ->createQuery("
                SELECT SUM(o.total.value)
                FROM Gelateria\Shop\Orders\Domain\Entities\Order o
                WHERE o.flavorId = :flavorId
            ")
            ->setParameter('flavorId', $flavorId)
            ->getSingleScalarResult();
    }
}