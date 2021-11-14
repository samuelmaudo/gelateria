<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Drinks\Domain\Collections;

use GetWith\CoffeeMachine\Machine\Drinks\Domain\Entities\Drink;
use GetWith\CoffeeMachine\Shared\Kernel\Domain\Collections\Collection;

/**
 * @extends Collection<Drink>
 */
final class Drinks extends Collection
{
    public function type(): string
    {
        return Drink::class;
    }
}