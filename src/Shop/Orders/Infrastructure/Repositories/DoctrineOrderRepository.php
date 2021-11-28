<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Infrastructure\Repositories;

use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;

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

    public function sumTotalsByGelato(GelatoId $gelatoId): float
    {
        return (float) $this
            ->entityManager
            ->createQuery("
                SELECT SUM(o.total.value)
                FROM Gelateria\Shop\Orders\Domain\Entities\Order o
                WHERE o.gelatoId = :gelatoId
            ")
            ->setParameter('gelatoId', $gelatoId)
            ->getSingleScalarResult();
    }
}