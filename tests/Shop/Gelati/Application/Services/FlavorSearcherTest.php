<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Gelati\Application\Services;

use Gelateria\Shop\Gelati\Application\Services\FlavorSearcher;
use Gelateria\Shop\Gelati\Domain\Collections\Flavors;
use Gelateria\Shop\Gelati\Domain\Entities\Flavor;
use Gelateria\Shop\Gelati\Domain\Repositories\FlavorRepository;
use Gelateria\Shop\Gelati\Infrastructure\Repositories\DummyFlavorRepository;

use PHPUnit\Framework\TestCase;

class FlavorSearcherTest extends TestCase
{
    protected ?FlavorSearcher $service;
    protected ?FlavorRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new DummyFlavorRepository();
        $this->service = new FlavorSearcher($this->repository);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->service = null;
        $this->repository = null;
    }

    public function testResults(): void
    {
        $gelati = $this->service->search();

        $this->assertInstanceOf(Flavors::class, $gelati);
        $this->assertContainsOnlyInstancesOf(Flavor::class, $gelati);

        $expected = ['vanilla', 'pistachio', 'stracciatella'];

        $actual = [];
        foreach ($gelati as $flavor) {
            $actual[] = $flavor->id()->value();
        }

        $this->assertSameSize($expected, $actual);
        $this->assertEmpty(array_diff($expected, $actual));
    }
}
