<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Doctrine\Infrastructure\MappingTypes;

use GetWith\CoffeeMachine\Shared\Doctrine\Infrastructure\MappingTypes\Traits\MapsValueObjects;

use Doctrine\DBAL\Types\StringType as DoctrineStringType;

abstract class StringType extends DoctrineStringType
{
    use MapsValueObjects;
}