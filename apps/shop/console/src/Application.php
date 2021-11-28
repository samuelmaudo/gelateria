<?php

declare(strict_types=1);

namespace Gelateria\Apps\Shop\Console;

use Symfony\Component\Console\Application as SymfonyApplication;

final class Application extends SymfonyApplication
{
    public function __construct(iterable $commands)
    {
        parent::__construct();

        foreach ($commands as $command) {
            $this->add($command);
        }
    }
}