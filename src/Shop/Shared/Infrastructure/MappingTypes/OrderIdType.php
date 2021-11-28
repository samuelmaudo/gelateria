<?php

declare(strict_types=1);

namespace Gelateria\Shop\Shared\Infrastructure\MappingTypes;

use Gelateria\Shop\Shared\Domain\Values\OrderId;
use Gelateria\Shared\Doctrine\Infrastructure\MappingTypes\AsciiStringType;
use Gelateria\Shared\Kernel\Domain\Values\Value;

use Doctrine\DBAL\Platforms\AbstractPlatform;

final class OrderIdType extends AsciiStringType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new OrderId($value);
    }
}