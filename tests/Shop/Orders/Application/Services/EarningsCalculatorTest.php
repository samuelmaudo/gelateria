<?php

declare(strict_types=1);

namespace Gelateria\Tests\Shop\Orders\Application\Services;

use Gelateria\Shop\Gelati\Application\Services\FlavorFinder;
use Gelateria\Shop\Gelati\Domain\Exceptions\FlavorNotFound;
use Gelateria\Shop\Gelati\Infrastructure\Repositories\DummyFlavorRepository;
use Gelateria\Shop\Orders\Application\Services\EarningsCalculator;
use Gelateria\Shop\Orders\Domain\Entities\Order;
use Gelateria\Shop\Orders\Domain\Repositories\OrderRepository;
use Gelateria\Shop\Orders\Infrastructure\Repositories\DummyOrderRepository;
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

        $finder = new FlavorFinder(new DummyFlavorRepository());
        $this->service = new EarningsCalculator($finder, $this->repository);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->service = null;
        $this->repository = null;
    }

    public function testExistingFlavor(): void
    {
        $result = $this->service->calculate('pistachio');

        $this->assertEquals(0, $result);
    }

    public function testMissingFlavor(): void
    {
        $this->expectException(FlavorNotFound::class);

        $this->service->calculate('vodka');
    }

    public function testInvalidKey(): void
    {
        $this->expectException(TypeError::class);

        $this->service->calculate(1);
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

        $result = $this->service->calculate('vanilla');

        $this->assertEquals(2.4, $result);
    }
}