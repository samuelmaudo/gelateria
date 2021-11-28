<?php

declare(strict_types=1);

namespace Gelateria\Shared\Doctrine\Infrastructure\MappingTypes\Traits;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

trait MapsAsciiStrings
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getAsciiStringTypeDeclarationSQL($column);
    }

    public function getBindingType(): int
    {
        return ParameterType::ASCII;
    }
}