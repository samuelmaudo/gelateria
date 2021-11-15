#!/usr/bin/env php
<?php

use GetWith\CoffeeMachine\Apps\Machine\Console\Application;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Dotenv\Dotenv;

if (false === in_array(PHP_SAPI, ['cli', 'phpdbg', 'embed'], true)) {
    echo 'This script should be invoked via the CLI version of PHP, not the ' . PHP_SAPI . ' SAPI' . PHP_EOL;
}

set_time_limit(0);

require __DIR__ . '/vendor/autoload.php';

$input = new ArgvInput();
if (null !== $env = $input->getParameterOption(['--env', '-e'], null, true)) {
    putenv('APP_ENV=' . $_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = $env);
}

if ($input->hasParameterOption('--no-debug', true)) {
    putenv('APP_DEBUG=' . $_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = '0');
}

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$container = new ContainerBuilder();

$loader = new YamlFileLoader($container, new FileLocator());
$loader->load(__DIR__ . '/apps/machine/console/config/services.yml');

$container->compile(true);

exit($container->get(Application::class)->run());