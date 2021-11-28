<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Gelati\Application\Services;

use Gelateria\Shop\Gelati\Application\Services\GelatoSearcher;
use Gelateria\Shop\Gelati\Domain\Collections\Gelati;
use Gelateria\Shop\Gelati\Domain\Entities\Gelato;
use Gelateria\Shop\Gelati\Domain\Repositories\GelatoRepository;
use Gelateria\Shop\Gelati\Infrastructure\Repositories\DummyGelatoRepository;

use PHPUnit\Framework\TestCase;

class GelatoSearcherTest extends TestCase
{
    protected ?GelatoSearcher $service;
    protected ?GelatoRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new DummyGelatoRepository();
        $this->service = new GelatoSearcher($this->repository);
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

        $this->assertInstanceOf(Gelati::class, $gelati);
        $this->assertContainsOnlyInstancesOf(Gelato::class, $gelati);

        $expected = ['vanilla', 'pistachio', 'stracciatella'];

        $actual = [];
        foreach ($gelati as $gelato) {
            $actual[] = $gelato->id()->value();
        }

        $this->assertSameSize($expected, $actual);
        $this->assertEmpty(array_diff($expected, $actual));
    }
}
