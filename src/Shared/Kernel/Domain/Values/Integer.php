<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Kernel\Domain\Values;

use InvalidArgumentException;

abstract class Integer extends Value
{
    protected int $value;

    public function __construct(int|string $value)
    {
        $value = $this->sanitize($value);
        $this->validate($value);
        $this->value = $value;
    }

    final public function value(): int
    {
        return $this->value;
    }

    protected function sanitize(int|string $value): int
    {
        if (is_int($value)) {
            return $value;
        }

        if (ctype_digit($value)) {
            return (int) $value;
        }

        $val = var_export($value, true);
        throw new InvalidArgumentException("{$val} is not a valid integer");
    }

    protected function validate(int $value): void
    {
    }
}