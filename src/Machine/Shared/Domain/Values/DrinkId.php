<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Shared\Domain\Values;

use GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Text;

final class DrinkId extends Text
{
    protected function sanitize(string $value): string
    {
        return strtolower(parent::sanitize($value));
    }
}