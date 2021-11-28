<?php

declare(strict_types=1);

namespace Gelateria\Shared\Doctrine\Infrastructure\MappingTypes;

use Gelateria\Shared\Doctrine\Infrastructure\MappingTypes\Traits\MapsValueObjects;

use Doctrine\DBAL\Types\StringType as DoctrineStringType;

abstract class StringType extends DoctrineStringType
{
    use MapsValueObjects;
}