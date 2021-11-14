<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Drinks\Domain\Exceptions;

use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;
use GetWith\CoffeeMachine\Shared\Kernel\Domain\Exceptions\NotFoundError;

/**
 * @extends NotFoundError<DrinkId>
 */
final class DrinkNotFound extends NotFoundError
{
    public function errorCode(): string
    {
        return 'machine_drink_not_found';
    }

    protected function errorMessage(): string
    {
        return "Drink <{$this->key()}> has not been found";
    }
}