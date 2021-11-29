<?php

declare(strict_types=1);

namespace Gelateria\Shop\Orders\Domain\Values;

use Gelateria\Shared\Kernel\Domain\Values\Integer;

use InvalidArgumentException;

final class OrderScoops extends Integer
{
    protected function validate(int $value): void
    {
        parent::validate($value);

        if ($value < 1 || $value > 3) {
            throw new InvalidArgumentException(
                'The number of scoops should be between 1 and 3'
            );
        }
    }
}