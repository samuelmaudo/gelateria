<?php

declare(strict_types=1);

namespace Gelateria\Shared\Doctrine\Infrastructure\EntityManagers;

use Gelateria\Shared\Doctrine\Infrastructure\MappingTypes\MappingTypeRegistrar;
use Gelateria\Shared\Doctrine\Infrastructure\SchemaManagers\SchemaManager;

use Doctrine\DBAL\Exception as DbalException;
use Doctrine\DBAL\Types\Type as MappingType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\ORMException as OrmException;
use Doctrine\ORM\Tools\Setup;

abstract class EntityManagerFactory
{
    private const SCHEMA_DIR = __DIR__ . '/../../../../../etc/schemas';
    private const MAPPING_DIR = __DIR__ . '/../../../../../etc/mappings';

    /**
     * @param  string  $environment
     * @param  array  $parameters
     * @param  MappingType[]  $mappingTypes
     * @return EntityManagerInterface
     *
     * @throws DbalException
     * @throws OrmException
     */
    public static function create(
        string $environment,
        array $parameters,
        iterable $mappingTypes
    ): EntityManagerInterface {

        $devMode = ($environment !== 'prod');

        if ($devMode) {
            SchemaManager::createDatabaseIfDoesntExist($parameters, realpath(self::SCHEMA_DIR));
        }

        MappingTypeRegistrar::register($mappingTypes);

        $paths = static::getDocumentPaths(realpath(self::MAPPING_DIR));

        $config = Setup::createConfiguration($devMode);
        $config->setMetadataDriverImpl(new SimplifiedXmlDriver($paths));

        return EntityManager::create($parameters, $config);
    }

    abstract protected static function getDocumentPaths(string $baseDir): array;
}