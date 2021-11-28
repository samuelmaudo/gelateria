<?php

declare(strict_types=1);

namespace Gelateria\Shared\Doctrine\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    protected function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    protected function repository(): EntityRepository
    {
        return $this->entityManager->getRepository($this->entityClass());
    }

    abstract protected function entityClass(): string;
}