<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Kernel\Domain\Values;

use GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Traits\Comparable;

use InvalidArgumentException;

abstract class Decimal extends Value
{
    use Comparable;

    protected float $value;

    public function __construct(float|int|string $value)
    {
        $value = $this->sanitize($value);
        $this->validate($value);
        $this->value = $value;
    }

    final public function value(): float
    {
        return $this->value;
    }

    protected function sanitize(float|int|string $value): float
    {
        if (is_float($value)) {
            return $value;
        }

        if (is_int($value)) {
            return (float) $value;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        $val = var_export($value, true);
        throw new InvalidArgumentException("{$val} is not a valid decimal");
    }

    protected function validate(float $value): void
    {
    }
}