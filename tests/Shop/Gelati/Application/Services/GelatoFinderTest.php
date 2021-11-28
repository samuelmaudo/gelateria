<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Gelati\Application\Services;

use Gelateria\Shop\Gelati\Application\Services\GelatoFinder;
use Gelateria\Shop\Gelati\Domain\Exceptions\GelatoNotFound;
use Gelateria\Shop\Gelati\Domain\Repositories\GelatoRepository;
use Gelateria\Shop\Gelati\Infrastructure\Repositories\DummyGelatoRepository;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;

use TypeError;

use PHPUnit\Framework\TestCase;

class GelatoFinderTest extends TestCase
{
    protected ?GelatoFinder $service;
    protected ?GelatoRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new DummyGelatoRepository();
        $this->service = new GelatoFinder($this->repository);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->service = null;
        $this->repository = null;
    }

    public function testExistingGelato(): void
    {
        $gelatoId = new GelatoId('pistachio');
        $gelato = $this->service->find($gelatoId);

        $this->assertTrue($gelatoId->is($gelato->id()));
    }

    public function testMissingGelato(): void
    {
        $this->expectException(GelatoNotFound::class);

        $gelatoId = new GelatoId('vodka');
        $this->service->find($gelatoId);
    }

    public function testInvalidKey(): void
    {
        $this->expectException(TypeError::class);

        $this->service->find('pistachio');
    }
}
