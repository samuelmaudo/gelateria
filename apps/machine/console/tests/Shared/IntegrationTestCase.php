<?php

namespace GetWith\CoffeeMachine\Apps\Machine\Console\Tests\Shared;

use GetWith\CoffeeMachine\Apps\Machine\Console\Application;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class IntegrationTestCase extends TestCase
{
    protected Application $application;

    protected function setUp(): void
    {
        parent::setUp();

        $container = new ContainerBuilder();

        $loader = new YamlFileLoader($container, new FileLocator());
        $loader->load(__DIR__ . '/../../config/services.yml');

        $container->compile();

        $this->application = $container->get(Application::class);
    }
}
