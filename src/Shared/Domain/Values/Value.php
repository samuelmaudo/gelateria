<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Domain\Values;

use Stringable;

abstract class Value implements Stringable
{
    abstract public function value();

    public function equals($other): bool
    {
        return is_object($other)
            && $other::class === static::class
            && $other == $this;
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}