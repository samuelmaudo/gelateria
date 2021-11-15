<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Doctrine\Infrastructure\MappingTypes;

use GetWith\CoffeeMachine\Shared\Doctrine\Infrastructure\MappingTypes\Traits\MapsAsciiStrings;

abstract class AsciiStringType extends StringType
{
    use MapsAsciiStrings;
}