<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Orders\Domain\Values;

use GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Integer;

use InvalidArgumentException;

final class OrderSugars extends Integer
{
    protected function validate(int $value): void
    {
        parent::validate($value);

        if ($value < 0 || $value > 2) {
            throw new InvalidArgumentException(
                'The number of sugars should be between 0 and 2.'
            );
        }
    }
}