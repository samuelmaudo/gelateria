<?php

declare(strict_types=1);

namespace Gelateria\Shared\Doctrine\Infrastructure\MappingTypes\Traits;

use Doctrine\DBAL\Platforms\AbstractPlatform;

use Gelateria\Shared\Kernel\Domain\Values\Value;

trait MapsValueObjects
{
    private static array $nameCache = [];

    abstract public function getSQLDeclaration(array $column, AbstractPlatform $platform);

    abstract public function convertToPHPValue($value, AbstractPlatform $platform);

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var Value $value */
        return $value->value();
    }

    public function getName(): string
    {
        $classname = static::class;

        if (isset(self::$nameCache[$classname])) {
            return self::$nameCache[$classname];
        }

        $pieces = explode('\\', $classname);
        $camelCase = str_replace('Type', '', end($pieces));
        $snakeCase = strtolower(preg_replace('/([^A-Z\s])([A-Z])/', "$1_$2", $camelCase));

        return self::$nameCache[$classname] = $snakeCase;
    }
}