<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Infrastructure\Repositories;

use Gelateria\Shared\Doctrine\Infrastructure\Repositories\DoctrineRepository;
use Gelateria\Shop\Gelati\Domain\Collections\Flavors;
use Gelateria\Shop\Gelati\Domain\Entities\Flavor;
use Gelateria\Shop\Gelati\Domain\Repositories\FlavorRepository;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;

final class DoctrineFlavorRepository extends DoctrineRepository implements FlavorRepository
{
    protected function entityClass(): string
    {
        return Flavor::class;
    }

    public function find(FlavorId $id): ?Flavor
    {
        return $this->repository()->find($id);
    }

    public function search(): Flavors
    {
        return new Flavors($this->repository()->findAll());
    }
}
