<?php

declare(strict_types=1);

namespace GetWith\CoffeeMachine\Shared\Doctrine\Infrastructure\MappingDocuments;

final class DocumentDirectoriesSearcher
{
    private const SUBMODULES = ['Entities', 'Values'];

    /**
     * @param  string  $baseDir
     * @param  string  $context
     * @param  string  $module
     * @return array<string, string>
     */
    public static function search(string $baseDir, string $context, string $module): array
    {
        $paths = [];
        $sep = DIRECTORY_SEPARATOR;

        foreach (self::SUBMODULES as $submodule) {
            $path = "{$baseDir}{$sep}{$context}{$sep}{$module}{$sep}{$submodule}";
            if (is_dir($path)) {
                $namespace = "GetWith\\CoffeeMachine\\{$context}\\{$module}\\Domain\\{$submodule}";
                $paths[$path] = $namespace;
            }
        }

        return $paths;
    }
}