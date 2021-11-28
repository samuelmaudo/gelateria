<?php

declare(strict_types=1);

namespace Gelateria\Shop\Gelati\Domain\Collections;

use Gelateria\Shop\Gelati\Domain\Entities\Gelato;
use Gelateria\Shared\Kernel\Domain\Collections\Collection;

/**
 * @extends Collection<Gelato>
 */
final class Gelati extends Collection
{
    public function type(): string
    {
        return Gelato::class;
    }
}