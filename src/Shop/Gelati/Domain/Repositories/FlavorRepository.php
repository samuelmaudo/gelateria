<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Domain\Repositories;

use Gelateria\Shop\Gelati\Domain\Collections\Flavors;
use Gelateria\Shop\Gelati\Domain\Entities\Flavor;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;

interface FlavorRepository
{
    public function find(FlavorId $id): ?Flavor;

    public function search(): Flavors;
}