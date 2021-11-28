<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Application\Services;

use Gelateria\Shop\Gelati\Domain\Entities\Gelato;
use Gelateria\Shop\Gelati\Domain\Exceptions\GelatoNotFound;
use Gelateria\Shop\Gelati\Domain\Repositories\GelatoRepository;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;

final class GelatoFinder
{
    public function __construct(private GelatoRepository $repository)
    {
    }

    public function find(GelatoId $id): Gelato
    {
        $gelato = $this->repository->find($id);

        if (is_null($gelato)) {
            throw new GelatoNotFound($id);
        }

        return $gelato;
    }
}