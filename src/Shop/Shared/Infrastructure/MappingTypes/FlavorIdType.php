<?php

declare(strict_types=1);

namespace Gelateria\Shop\Shared\Infrastructure\MappingTypes;

use Gelateria\Shop\Shared\Domain\Values\FlavorId;
use Gelateria\Shared\Doctrine\Infrastructure\MappingTypes\AsciiStringType;

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class FlavorIdType extends AsciiStringType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new FlavorId($value);
    }
}