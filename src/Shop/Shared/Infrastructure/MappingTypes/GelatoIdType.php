<?php

declare(strict_types=1);

namespace Gelateria\Shop\Shared\Infrastructure\MappingTypes;

use Gelateria\Shop\Shared\Domain\Values\GelatoId;
use Gelateria\Shared\Doctrine\Infrastructure\MappingTypes\AsciiStringType;

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class GelatoIdType extends AsciiStringType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new GelatoId($value);
    }
}