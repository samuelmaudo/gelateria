<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Kernel\Domain\Values;

use InvalidArgumentException;

use Ramsey\Uuid\Uuid as RamseyUuid;

abstract class Uuid extends Text
{
    public static function random(): static
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    protected function validate(string $value): void
    {
        if (!RamseyUuid::isValid($value)) {
            $val = var_export($value, true);
            throw new InvalidArgumentException("{$val} is not a valid UUID");
        }
    }
}