<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Kernel\Domain\Entities;

use GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Value;

abstract class Entity
{
    public function identity(): Value
    {
        return $this->id();
    }

    final public function equals($other): bool
    {
        return is_object($other)
            && $other::class === static::class
            && $other->identity() == $this->identity();
    }
}