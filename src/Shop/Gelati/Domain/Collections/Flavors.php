<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Domain\Collections;

use Gelateria\Shop\Gelati\Domain\Entities\Flavor;
use Gelateria\Shared\Kernel\Domain\Collections\Collection;

/**
 * @extends Collection<Flavor>
 */
final class Flavors extends Collection
{
    public function type(): string
    {
        return Flavor::class;
    }
}