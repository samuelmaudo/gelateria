<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Traits;

use GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Value;

trait SupportsValueComparisons
{
    public function lt(mixed $other): bool
    {
        if ($other instanceof Value) {
            $other = $other->value();
        }

        return ($this->value < $other);
    }

    public function le(mixed $other): bool
    {
        if ($other instanceof Value) {
            $other = $other->value();
        }

        return ($this->value <= $other);
    }

    public function eq(mixed $other): bool
    {
        if ($other instanceof Value) {
            $other = $other->value();
        }

        return ($this->value == $other);
    }

    public function ne(mixed $other): bool
    {
        if ($other instanceof Value) {
            $other = $other->value();
        }

        return ($this->value != $other);
    }

    public function gt(mixed $other): bool
    {
        if ($other instanceof Value) {
            $other = $other->value();
        }

        return ($this->value > $other);
    }

    public function ge(mixed $other): bool
    {
        if ($other instanceof Value) {
            $other = $other->value();
        }

        return ($this->value >= $other);
    }
}