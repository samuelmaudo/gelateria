<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Shared\Domain\Values;

use GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Text;

use InvalidArgumentException;

final class DrinkId extends Text
{
    protected const CASES = [
        'tea',
        'coffee',
        'chocolate',
    ];

    protected function sanitize(string $value): string
    {
        return strtolower(parent::sanitize($value));
    }

    protected function validate(string $value): void
    {
        parent::validate($value);

        if (!in_array($value, self::CASES, true)) {
            throw new InvalidArgumentException(
                'The drink type should be tea, coffee or chocolate.'
            );
        }
    }
}