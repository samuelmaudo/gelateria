<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Machine\Shared\Infrastructure\EntityManagers;

use GetWith\CoffeeMachine\Shared\Doctrine\Infrastructure\EntityManagers\EntityManagerFactory;
use GetWith\CoffeeMachine\Shared\Doctrine\Infrastructure\MappingDocuments\DocumentDirectoriesSearcher;

final class DoctrineEntityManagerFactory extends EntityManagerFactory
{
    private const CONTEXT = 'Machine';
    private const MODULES = ['Drinks', 'Orders'];

    protected static function getDocumentPaths(string $baseDir): array
    {
        $paths = [];

        foreach (self::MODULES as $module) {
            $paths[] = DocumentDirectoriesSearcher::search($baseDir, self::CONTEXT, $module);
        }

        return array_merge(...$paths);
    }
}