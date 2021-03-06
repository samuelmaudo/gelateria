<?php

declare(strict_types=1);

namespace Gelateria\Apps\Shop\Console\Tests\Shared;

use Gelateria\Apps\Shop\Console\Application;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class IntegrationTestCase extends TestCase
{
    protected ?ContainerBuilder $container;
    protected ?Application $application;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new ContainerBuilder();

        $loader = new YamlFileLoader($this->container, new FileLocator());
        $loader->load(__DIR__ . '/../../config/services_test.yml');

        $this->container->compile();

        $this->application = $this->container->get(Application::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->application = null;
        $this->container = null;
    }
}
