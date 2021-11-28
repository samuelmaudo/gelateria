<?php

declare(strict_types=1);

namespace Gelateria\Shop\Shared\Infrastructure\EntityManagers;

use Gelateria\Shared\Doctrine\Infrastructure\EntityManagers\EntityManagerFactory;
use Gelateria\Shared\Doctrine\Infrastructure\MappingDocuments\DocumentDirectoriesSearcher;

final class DoctrineEntityManagerFactory extends EntityManagerFactory
{
    private const CONTEXT = 'Shop';
    private const MODULES = ['Gelati', 'Orders'];

    protected static function getDocumentPaths(string $baseDir): array
    {
        $paths = [];

        foreach (self::MODULES as $module) {
            $paths[] = DocumentDirectoriesSearcher::search($baseDir, self::CONTEXT, $module);
        }

        return array_merge(...$paths);
    }
}