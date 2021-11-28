<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Domain\Repositories;

use Gelateria\Shop\Gelati\Domain\Collections\Gelati;
use Gelateria\Shop\Gelati\Domain\Entities\Gelato;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;

interface GelatoRepository
{
    public function find(GelatoId $id): ?Gelato;

    public function search(): Gelati;
}