<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Orders\Application\Services;

use Gelateria\Shop\Orders\Application\Services\EarningsCalculator;
use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
use Gelateria\Shop\Orders\Infrastructure\Repositories\DummyOrderRepository;
use Gelateria\Shop\Shared\Domain\Values\GelatoId;
use Gelateria\Shop\Shared\Domain\Values\OrderId;

use TypeError;

use PHPUnit\Framework\TestCase;

class EarningsCalculatorTest extends TestCase
{
    protected ?EarningsCalculator $service;
    protected ?OrderRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new DummyOrderRepository();
        $this->service = new EarningsCalculator($this->repository);
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
        $result = $this->service->calculate($gelatoId);

        $this->assertEquals(0, $result);
    }

    public function testMissingGelato(): void
    {
        $gelatoId = new GelatoId('vodka');
        $result = $this->service->calculate($gelatoId);

        $this->assertEquals(0, $result);
    }

    public function testInvalidKey(): void
    {
        $this->expectException(TypeError::class);

        $this->service->calculate('pistachio');
    }

    public function testResults(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->repository->save(Order::fromPrimitives(
                id: OrderId::random()->value(),
                gelatoId: 'vanilla',
                scoops: 1,
                syrup: false,
                total: 0.4,
                givenMoney: 0.5,
                returnedMoney: 0.1
            ));
        }

        $gelatoId = new GelatoId('vanilla');
        $result = $this->service->calculate($gelatoId);

        $this->assertEquals(1.2, $result);
    }
}