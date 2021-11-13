<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Domain\Values;

use InvalidArgumentException;

abstract class Integer extends Value
{
    protected int $value;

    public function __construct(int|string $value)
    {
        $this->value = $this->sanitize($value);
    }

    public function value(): int
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
}