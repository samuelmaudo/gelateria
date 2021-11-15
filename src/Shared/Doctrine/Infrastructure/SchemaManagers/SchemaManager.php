<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Doctrine\Infrastructure\SchemaManagers;

use DirectoryIterator;
use RuntimeException;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception as DbalException;
use Doctrine\DBAL\Schema\AbstractSchemaManager;

final class SchemaManager
{
    /**
     * @param  array  $parameters
     * @param  string  $schemaDir
     *
     * @throws DbalException
     */
    public static function createDatabaseIfDoesntExist(
        array $parameters,
        string $schemaDir
    ): void {

        self::ensureSchemaDirectoryExists($schemaDir);

        $database = $parameters['dbname'];
        unset($parameters['dbname']);

        $connection = DriverManager::getConnection($parameters);
        $schemaManager = $connection->createSchemaManager();

        if (!self::databaseExists($database, $schemaManager)) {
            self::createDatabase($database, $schemaDir, $connection, $schemaManager);
        }

        $connection->close();
    }

    private static function ensureSchemaDirectoryExists(string $schemaDir): void
    {
        if (!is_dir($schemaDir)) {
            throw new RuntimeException("Directory <{$schemaDir}> does not exist");
        }

        if (!is_readable($schemaDir)) {
            throw new RuntimeException("Directory <{$schemaDir}> is not readable");
        }
    }

    private static function databaseExists(
        string $database,
        AbstractSchemaManager $schemaManager
    ): bool {
        return in_array($database, $schemaManager->listDatabases(), true);
    }

    private static function createDatabase(
        string $database,
        string $schemaDir,
        Connection $connection,
        AbstractSchemaManager $schemaManager
    ): void {

        $schemaManager->createDatabase($database);
        $connection->executeStatement(sprintf('USE %s', $database));

        /** @var DirectoryIterator $fileinfo */
        foreach (new DirectoryIterator($schemaDir) as $fileinfo) {

            if (!$fileinfo->isFile()
                || $fileinfo->isDot()
                || !str_ends_with($fileinfo->getFilename(), '.sql')) {
                continue;
            }

            $file = $fileinfo->openFile();

            $connection->executeStatement($file->fread($file->getSize()));
        }
    }
}