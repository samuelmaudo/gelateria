<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Orders\Application\Services;

use Gelateria\Shop\Orders\Application\Services\EarningsCalculator;
use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
use Gelateria\Shop\Orders\Infrastructure\Repositories\DummyOrderRepository;
use Gelateria\Shop\Shared\Domain\Values\FlavorId;
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

    public function testExistingFlavor(): void
    {
        $flavorId = new FlavorId('pistachio');
        $result = $this->service->calculate($flavorId);

        $this->assertEquals(0, $result);
    }

    public function testMissingFlavor(): void
    {
        $flavorId = new FlavorId('vodka');
        $result = $this->service->calculate($flavorId);

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
                flavorId: 'vanilla',
                scoops: 1,
                syrup: false,
                total: 0.8,
                givenMoney: 1.0,
                returnedMoney: 0.2
            ));
        }

        $flavorId = new FlavorId('vanilla');
        $result = $this->service->calculate($flavorId);

        $this->assertEquals(2.4, $result);
    }
}