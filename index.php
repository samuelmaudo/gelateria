#!/usr/bin/env php
<?php

use GetWith\CoffeeMachine\Apps\Machine\Console\Application;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();

$loader = new YamlFileLoader($container, new FileLocator());
$loader->load(__DIR__ . '/apps/machine/console/config/services.yml');

$container->compile();

exit($container->get(Application::class)->run());