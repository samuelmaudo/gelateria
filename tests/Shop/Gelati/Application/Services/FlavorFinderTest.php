<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Gelati\Application\Services;

use Gelateria\Shop\Gelati\Application\Services\FlavorFinder;
use Gelateria\Shop\Gelati\Domain\Exceptions\FlavorNotFound;
use Gelateria\Shop\Gelati\Domain\Repositories\FlavorRepository;
use Gelateria\Shop\Gelati\Infrastructure\Repositories\DummyFlavorRepository;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;

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
        $flavorId = new FlavorId('pistachio');
        $flavor = $this->service->find($flavorId);

        $this->assertTrue($flavorId->is($flavor->id()));
    }

    public function testMissingFlavor(): void
    {
        $this->expectException(FlavorNotFound::class);

        $flavorId = new FlavorId('vodka');
        $this->service->find($flavorId);
    }

    public function testInvalidKey(): void
    {
        $this->expectException(TypeError::class);

        $this->service->find('pistachio');
    }
}
