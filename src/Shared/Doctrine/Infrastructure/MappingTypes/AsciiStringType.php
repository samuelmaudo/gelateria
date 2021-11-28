<?php

declare(strict_types=1);

namespace Gelateria\Shared\Doctrine\Infrastructure\MappingTypes;

use Gelateria\Shared\Doctrine\Infrastructure\MappingTypes\Traits\MapsAsciiStrings;

abstract class AsciiStringType extends StringType
{
    use MapsAsciiStrings;
}