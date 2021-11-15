<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Shared\Infrastructure\MappingTypes;

use GetWith\CoffeeMachine\Machine\Shared\Domain\Values\DrinkId;
use GetWith\CoffeeMachine\Shared\Doctrine\Infrastructure\MappingTypes\AsciiStringType;
use GetWith\CoffeeMachine\Shared\Kernel\Domain\Values\Value;

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DrinkIdType extends AsciiStringType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new DrinkId($value);
    }
}