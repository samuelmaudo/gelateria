<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Infrastructure\Repositories;

use Gelateria\Shop\Gelati\Domain\Collections\Gelati;
use Gelateria\Shop\Gelati\Domain\Entities\Gelato;
use Gelateria\Shop\Gelati\Domain\Repositories\GelatoRepository;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class DoctrineGelatoRepository implements GelatoRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    private function repository(): EntityRepository
    {
        return $this->entityManager->getRepository(Gelato::class);
    }

    public function find(GelatoId $id): ?Gelato
    {
        return $this->repository()->find($id);
    }

    public function search(): Gelati
    {
        return new Gelati($this->repository()->findAll());
    }
}
