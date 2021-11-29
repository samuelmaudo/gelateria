<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Gelati\Application\Services;

use Gelateria\Shop\Gelati\Application\Services\FlavorFinder;
use Gelateria\Shop\Gelati\Domain\Exceptions\FlavorNotFound;
use Gelateria\Shop\Gelati\Domain\Repositories\FlavorRepository;
use Gelateria\Shop\Gelati\Infrastructure\Repositories\DummyFlavorRepository;

use TypeError;

use PHPUnit\Framework\TestCase;

class FlavorFinderTest extends TestCase
{
    protected ?FlavorFinder $service;
    protected ?FlavorRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new DummyFlavorRepository();
        $this->service = new FlavorFinder($this->repository);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->service = null;
        $this->repository = null;
    }

    public function testExistingFlavor(): void
    {
        $flavor = $this->service->find('pistachio');

        $this->assertEquals('pistachio', $flavor->id()->value());
    }

    public function testMissingFlavor(): void
    {
        $this->expectException(FlavorNotFound::class);

        $this->service->find('vodka');
    }

    public function testInvalidKey(): void
    {
        $this->expectException(TypeError::class);

        $this->service->find(1);
    }
}
