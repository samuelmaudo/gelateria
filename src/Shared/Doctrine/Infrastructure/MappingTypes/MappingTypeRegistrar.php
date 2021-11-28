<?php

declare(strict_types=1);

namespace Gelateria\Shared\Doctrine\Infrastructure\MappingTypes;

use Doctrine\DBAL\Exception as DbalException;
use Doctrine\DBAL\Types\Type as MappingType;

final class MappingTypeRegistrar
{
    private static bool $executed = false;

    /**
     * @param  MappingType[]  $mappingTypes
     * @return void
     *
     * @throws DbalException
     */
    public static function register(iterable $mappingTypes): void
    {
        if (self::$executed) {
            return;
        }

        $registry = MappingType::getTypeRegistry();

        foreach ($mappingTypes as $type) {
            $registry->register($type->getName(), $type);
        }

        self::$executed = True;
    }
}